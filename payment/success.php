<?php
session_start();
require_once "../db/connection.php";

// Set content type early
header('Content-Type: text/html; charset=utf-8');

// Enable error reporting for development (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Define constants
define('PAYMENT_SUCCESS_CODE', 'PAYMENT_SUCCESS');
define('TRANSACTION_SUCCESS_STATUS', 1);
define('USER_ACTIVE_STATUS', 1);

// Function to log errors
function logError($message, $conn = null)
{
    $logMessage = date('[Y-m-d H:i:s]') . " - " . $message . PHP_EOL;
    error_log($logMessage, 3, __DIR__ . '/../logs/payment_errors.log');

    if ($conn) {
        $errorMsg = mysqli_real_escape_string($conn, $message);
        $query = "INSERT INTO error_logs (message, created_at) VALUES ('$errorMsg', NOW())";
        @mysqli_query($conn, $query);
    }
}

// Main payment processing
try {
    // Validate required parameters
    if (!isset($_POST['code']) || !isset($_POST['transactionId'])) {
        throw new Exception("Missing required parameters");
    }

    $payment_code = trim($_POST['code']);
    $transaction_id = trim($_POST['transactionId']);

    if (!preg_match('/^[A-Z0-9_-]+$/i', $transaction_id)) {
        throw new Exception("Invalid transaction ID format");
    }

    if ($payment_code === PAYMENT_SUCCESS_CODE) {
        // Start database transaction
        mysqli_begin_transaction($conn);

        try {
            // 1. Get payment transaction details
            $qry_order = "SELECT id, user_id, amount FROM pay_transaction WHERE transaction_id = ? AND status = 1 LIMIT 1";
            $stmt_order = mysqli_prepare($conn, $qry_order);

            if (!$stmt_order) {
                throw new Exception("Database query preparation failed: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt_order, "s", $transaction_id);

            if (!mysqli_stmt_execute($stmt_order)) {
                throw new Exception("Failed to execute query: " . mysqli_stmt_error($stmt_order));
            }

            $res_order = mysqli_stmt_POST_result($stmt_order);
            $transaction = mysqli_fetch_assoc($res_order);
            mysqli_stmt_close($stmt_order);

            if (!$transaction) {
                throw new Exception("Transaction not found or already processed: " . $transaction_id);
            }

            $user_id = (int)$transaction['user_id'];
            $transaction_amount = (float)$transaction['amount'];

            // 2. Get commission settings
            $query = "SELECT plan_price, level1_commission, level2_commission, level3_commission 
                     FROM commission_settings WHERE is_active = 1 LIMIT 1";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                throw new Exception("Failed to fetch commission settings: " . mysqli_error($conn));
            }

            $commission = mysqli_fetch_assoc($result);

            if (!$commission) {
                throw new Exception("Commission settings not found");
            }

            // Use plan price from commission settings if available
            if (!empty($commission['plan_price']) && $commission['plan_price'] > 0) {
                $transaction_amount = (float)$commission['plan_price'];
            }

            // 3. Get user details
            $sel_user_qry = "SELECT * FROM users WHERE id = ? LIMIT 1";
            $stmt_user = mysqli_prepare($conn, $sel_user_qry);
            mysqli_stmt_bind_param($stmt_user, "i", $user_id);
            mysqli_stmt_execute($stmt_user);
            $user_result = mysqli_stmt_POST_result($stmt_user);
            $user = mysqli_fetch_assoc($user_result);
            mysqli_stmt_close($stmt_user);

            if (!$user) {
                throw new Exception("User not found: " . $user_id);
            }

            // 4. Update session data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['mobile'] = $user['mobile'];
            $_SESSION['address'] = $user['address'] ?? "";
            $_SESSION['city'] = $user['city'] ?? "";
            $_SESSION['state'] = $user['state'] ?? "";
            $_SESSION['country'] = $user['country'] ?? "";
            $_SESSION['old_img'] = $user['image'] ?? "";
            $_SESSION['pincode'] = $user['pincode'] ?? "";
            $_SESSION['referral_id'] = $user['referral_id'] ?? "";
            $_SESSION['aadhar_number'] = $user['aadhar_number'] ?? "";
            $_SESSION['is_active'] = USER_ACTIVE_STATUS;
            $_SESSION['balance'] = $user['balance'];

            // 5. Update payment transaction status (0 = pending, 1 = success, 2 = failed)
            $upd_ord_qry = "UPDATE pay_transaction SET status = 0, updated_at = NOW() 
                           WHERE transaction_id = ? AND status = 0";
            $stmt_upd_ord = mysqli_prepare($conn, $upd_ord_qry);
            mysqli_stmt_bind_param($stmt_upd_ord, "s", $transaction_id);

            if (!mysqli_stmt_execute($stmt_upd_ord)) {
                throw new Exception("Failed to update transaction status");
            }

            if (mysqli_stmt_affected_rows($stmt_upd_ord) === 0) {
                throw new Exception("Transaction already processed or not found");
            }
            mysqli_stmt_close($stmt_upd_ord);

            // 6. Update user active status (DO NOT add plan amount to user's balance)
            $upd_user_qry = "UPDATE users SET is_active = 1, updated_at = NOW() WHERE id = ?";
            $stmt_upd_user = mysqli_prepare($conn, $upd_user_qry);
            mysqli_stmt_bind_param($stmt_upd_user, "i", $user_id);

            if (!mysqli_stmt_execute($stmt_upd_user)) {
                throw new Exception("Failed to update user status");
            }
            mysqli_stmt_close($stmt_upd_user);

            $created_at = date("Y-m-d H:i:s");

            // 7. Insert transaction for the purchasing user (NO balance addition for plan purchase)
            // यूजर को प्लान खरीदने पर बैलेंस नहीं मिलेगा, सिर्फ एक्टिव होगा
            $sql = "INSERT INTO transaction (order_id, user_id, balance, status, created_at) 
                   VALUES (?, ?, ?, 1, ?)";
            $stmt_insert_user_trans = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param(
                $stmt_insert_user_trans,
                "sids",
                $transaction_id,
                $user_id,
                $transaction_amount,
                $created_at
            );

            if (!mysqli_stmt_execute($stmt_insert_user_trans)) {
                throw new Exception("Failed to insert user transaction");
            }

            $user_transaction_id = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt_insert_user_trans);

            // 8. Calculate commission percentages
            $level1_percentage = min(100, max(0, (float)$commission['level1_commission'])) / 100;
            $level2_percentage = min(100, max(0, (float)$commission['level2_commission'])) / 100;
            $level3_percentage = min(100, max(0, (float)$commission['level3_commission'])) / 100;

            // Calculate commission amounts
            $level1_commission = round($transaction_amount * $level1_percentage, 2);
            $level2_commission = round($transaction_amount * $level2_percentage, 2);
            $level3_commission = round($transaction_amount * $level3_percentage, 2);

            // 9. Process 3-level commission distribution with proper chain
            $commission_data = [];

            // Get Level 1 Upline (Direct Referrer)
            $qry_level1 = "SELECT upline_id FROM users WHERE id = ? AND upline_id IS NOT NULL LIMIT 1";
            $stmt_level1 = mysqli_prepare($conn, $qry_level1);
            mysqli_stmt_bind_param($stmt_level1, "i", $user_id);
            mysqli_stmt_execute($stmt_level1);
            $result_level1 = mysqli_stmt_POST_result($stmt_level1);
            $level1_upline = mysqli_fetch_assoc($result_level1);
            mysqli_stmt_close($stmt_level1);

            $level1_upline_id = null;
            if ($level1_upline && !empty($level1_upline['upline_id'])) {
                $level1_upline_id = (int)$level1_upline['upline_id'];

                // Give Level 1 Commission (30%)
                $update_level1_sql = "UPDATE users SET balance = balance + ?, total_commission = COALESCE(total_commission, 0) + ?, updated_at = NOW() WHERE id = ?";
                $stmt_update_level1 = mysqli_prepare($conn, $update_level1_sql);
                mysqli_stmt_bind_param($stmt_update_level1, "ddi", $level1_commission, $level1_commission, $level1_upline_id);

                if (!mysqli_stmt_execute($stmt_update_level1)) {
                    throw new Exception("Failed to update level 1 upline balance");
                }
                mysqli_stmt_close($stmt_update_level1);

                // Insert transaction for Level 1
                $insert_level1_sql = "INSERT INTO transaction (order_id, user_id, balance, status, created_at) 
                                     VALUES (?, ?, ?, 1, ?)";
                $stmt_insert_level1 = mysqli_prepare($conn, $insert_level1_sql);
                mysqli_stmt_bind_param(
                    $stmt_insert_level1,
                    "sids",
                    $transaction_id,
                    $level1_upline_id,
                    $level1_commission,
                    $created_at
                );
                mysqli_stmt_execute($stmt_insert_level1);
                mysqli_stmt_close($stmt_insert_level1);

                $commission_data[] = [
                    'level' => 1,
                    'upline_id' => $level1_upline_id,
                    'amount' => $level1_commission,
                    'percentage' => $level1_percentage * 100
                ];

                // Get Level 2 Upline (Level 1's Upline)
                $qry_level2 = "SELECT upline_id FROM users WHERE id = ? AND upline_id IS NOT NULL LIMIT 1";
                $stmt_level2 = mysqli_prepare($conn, $qry_level2);
                mysqli_stmt_bind_param($stmt_level2, "i", $level1_upline_id);
                mysqli_stmt_execute($stmt_level2);
                $result_level2 = mysqli_stmt_POST_result($stmt_level2);
                $level2_upline = mysqli_fetch_assoc($result_level2);
                mysqli_stmt_close($stmt_level2);

                if ($level2_upline && !empty($level2_upline['upline_id'])) {
                    $level2_upline_id = (int)$level2_upline['upline_id'];

                    // Give Level 2 Commission (20%)
                    $update_level2_sql = "UPDATE users SET balance = balance + ?, total_commission = COALESCE(total_commission, 0) + ?, updated_at = NOW() WHERE id = ?";
                    $stmt_update_level2 = mysqli_prepare($conn, $update_level2_sql);
                    mysqli_stmt_bind_param($stmt_update_level2, "ddi", $level2_commission, $level2_commission, $level2_upline_id);

                    if (!mysqli_stmt_execute($stmt_update_level2)) {
                        throw new Exception("Failed to update level 2 upline balance");
                    }
                    mysqli_stmt_close($stmt_update_level2);

                    // Insert transaction for Level 2
                    $insert_level2_sql = "INSERT INTO transaction (order_id, user_id, balance, status, created_at) 
                                         VALUES (?, ?, ?, 1, ?)";
                    $stmt_insert_level2 = mysqli_prepare($conn, $insert_level2_sql);
                    mysqli_stmt_bind_param(
                        $stmt_insert_level2,
                        "sids",
                        $transaction_id,
                        $level2_upline_id,
                        $level2_commission,
                        $created_at
                    );
                    mysqli_stmt_execute($stmt_insert_level2);
                    mysqli_stmt_close($stmt_insert_level2);

                    $commission_data[] = [
                        'level' => 2,
                        'upline_id' => $level2_upline_id,
                        'amount' => $level2_commission,
                        'percentage' => $level2_percentage * 100
                    ];

                    // Get Level 3 Upline (Level 2's Upline)
                    $qry_level3 = "SELECT upline_id FROM users WHERE id = ? AND upline_id IS NOT NULL LIMIT 1";
                    $stmt_level3 = mysqli_prepare($conn, $qry_level3);
                    mysqli_stmt_bind_param($stmt_level3, "i", $level2_upline_id);
                    mysqli_stmt_execute($stmt_level3);
                    $result_level3 = mysqli_stmt_POST_result($stmt_level3);
                    $level3_upline = mysqli_fetch_assoc($result_level3);
                    mysqli_stmt_close($stmt_level3);

                    if ($level3_upline && !empty($level3_upline['upline_id'])) {
                        $level3_upline_id = (int)$level3_upline['upline_id'];

                        // Give Level 3 Commission (10%)
                        $update_level3_sql = "UPDATE users SET balance = balance + ?, total_commission = COALESCE(total_commission, 0) + ?, updated_at = NOW() WHERE id = ?";
                        $stmt_update_level3 = mysqli_prepare($conn, $update_level3_sql);
                        mysqli_stmt_bind_param($stmt_update_level3, "ddi", $level3_commission, $level3_commission, $level3_upline_id);

                        if (!mysqli_stmt_execute($stmt_update_level3)) {
                            throw new Exception("Failed to update level 3 upline balance");
                        }
                        mysqli_stmt_close($stmt_update_level3);

                        // Insert transaction for Level 3
                        $insert_level3_sql = "INSERT INTO transaction (order_id, user_id, balance, status, created_at) 
                                             VALUES (?, ?, ?, 1, ?)";
                        $stmt_insert_level3 = mysqli_prepare($conn, $insert_level3_sql);
                        mysqli_stmt_bind_param(
                            $stmt_insert_level3,
                            "sids",
                            $transaction_id,
                            $level3_upline_id,
                            $level3_commission,
                            $created_at
                        );
                        mysqli_stmt_execute($stmt_insert_level3);
                        mysqli_stmt_close($stmt_insert_level3);

                        $commission_data[] = [
                            'level' => 3,
                            'upline_id' => $level3_upline_id,
                            'amount' => $level3_commission,
                            'percentage' => $level3_percentage * 100
                        ];
                    }
                }
            }

            // 10. Commit all changes
            mysqli_commit($conn);

            // 11. Send success email
            sendSuccessEmail($user, $transaction_id, $transaction_amount, $commission_data);

            // 12. Update session with current balance
            $get_balance_qry = "SELECT balance FROM users WHERE id = ?";
            $stmt_balance = mysqli_prepare($conn, $get_balance_qry);
            mysqli_stmt_bind_param($stmt_balance, "i", $user_id);
            mysqli_stmt_execute($stmt_balance);
            $balance_result = mysqli_stmt_POST_result($stmt_balance);
            $balance_data = mysqli_fetch_assoc($balance_result);
            $_SESSION['balance'] = $balance_data['balance'] ?? $user['balance'];
            mysqli_stmt_close($stmt_balance);

            // 13. Log success
            logError("Payment SUCCESS - Transaction: $transaction_id, User: $user_id, Amount: $transaction_amount, Commission Distributed: " . count($commission_data) . " levels", $conn);
        } catch (Exception $e) {
            // Rollback on error
            mysqli_rollback($conn);
            throw $e;
        }
    } else {
        // Payment failed - update status to 2
        $update_failed_qry = "UPDATE pay_transaction SET status = 2, updated_at = NOW() 
                             WHERE transaction_id = ? AND status = 0";
        $stmt_failed = mysqli_prepare($conn, $update_failed_qry);
        mysqli_stmt_bind_param($stmt_failed, "s", $transaction_id);
        mysqli_stmt_execute($stmt_failed);
        mysqli_stmt_close($stmt_failed);

        logError("Payment FAILED - Code: $payment_code, Transaction: $transaction_id", $conn);
    }
} catch (Exception $e) {
    logError("Payment processing ERROR: " . $e->getMessage(), $conn);
    $error_message = "An error occurred while processing your payment. Please contact support.";
}

// Function to send success email with commission details
function sendSuccessEmail($user, $transaction_id, $amount, $commission_data = [])
{
    $to = $user['email'];
    $subject = "Payment Successful - Order #" . $transaction_id;

    $now = new DateTime();
    $timestring = $now->format('F j, Y');
    $user_name = htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
    $formatted_amount = number_format($amount, 2);

    // Build commission details HTML
    $commission_html = '';
    if (!empty($commission_data)) {
        $commission_html = '<h3>Commission Distributed:</h3><table style="width:100%;border-collapse:collapse;margin:15px 0;">';
        $commission_html .= '<tr style="background:#f5f5f5;"><th style="padding:10px;text-align:left;">Level</th><th style="padding:10px;text-align:left;">Upline ID</th><th style="padding:10px;text-align:left;">Amount</th><th style="padding:10px;text-align:left;">Percentage</th></tr>';

        foreach ($commission_data as $commission) {
            $commission_html .= '<tr style="border-bottom:1px solid #ddd;">';
            $commission_html .= '<td style="padding:10px;">Level ' . $commission['level'] . '</td>';
            $commission_html .= '<td style="padding:10px;">' . $commission['upline_id'] . '</td>';
            $commission_html .= '<td style="padding:10px;">₹' . number_format($commission['amount'], 2) . '</td>';
            $commission_html .= '<td style="padding:10px;">' . $commission['percentage'] . '%</td>';
            $commission_html .= '</tr>';
        }
        $commission_html .= '</table>';
    }

    $message = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #28a745; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { background: #fff; padding: 30px; border: 1px solid #ddd; border-top: none; }
        .footer { background: #f5f5f5; padding: 20px; text-align: center; font-size: 12px; color: #666; border-top: 1px solid #ddd; }
        .button { display: inline-block; padding: 12px 25px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .details { margin: 20px 0; border-collapse: collapse; width: 100%; }
        .details th { background: #f8f9fa; padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6; }
        .details td { padding: 10px; border-bottom: 1px solid #dee2e6; }
        .success-icon { color: #28a745; font-size: 48px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Payment Successful!</h1>
        </div>
        <div class="content">
            <div style="text-align:center;">
                <div class="success-icon">✓</div>
            </div>
            
            <p>Dear $user_name,</p>
            <p>Your payment has been processed successfully. Thank you for your purchase!</p>
            
            <table class="details">
                <tr>
                    <th>Transaction ID:</th>
                    <td>$transaction_id</td>
                </tr>
                <tr>
                    <th>Date:</th>
                    <td>$timestring</td>
                </tr>
                <tr>
                    <th>Amount Paid:</th>
                    <td><strong>₹$formatted_amount</strong></td>
                </tr>
                <tr>
                    <th>Account Status:</th>
                    <td><span style="color:#28a745;font-weight:bold;">ACTIVE</span></td>
                </tr>
            </table>
            
            $commission_html
            
            <h3>What's Next?</h3>
            <ul>
                <li>Your account is now active</li>
                <li>You can access all premium features</li>
                <li>Start earning commissions by referring others</li>
                <li>Check your updated balance in dashboard</li>
            </ul>
            
            <div style="text-align:center;margin:30px 0;">
                <a href="https://shopercity.com/dashboard" class="button">Go to Dashboard</a>
            </div>
            
            <p>If you have any questions, please contact our support team.</p>
        </div>
        <div class="footer">
            <p>This is an automated email, please do not reply.</p>
            <p>&copy; " . date('Y') . " Shopercity. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
HTML;

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Shopercity <noreply@shopercity.com>" . "\r\n";
    $headers .= "Reply-To: support@shopercity.com" . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    $headers .= "X-Priority: 1 (Highest)" . "\r\n";
    $headers .= "X-MSMail-Priority: High" . "\r\n";

    @mail($to, $subject, $message, $headers);
}

// Display status page
$is_success = ($payment_code ?? '') === PAYMENT_SUCCESS_CODE;
$display_amount = $transaction_amount ?? 0;
$display_transaction_id = $transaction_id ?? ($_POST['transactionId'] ?? 'N/A');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status - Shopercity</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito Sans', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #333;
        }

        .status-container {
            max-width: 800px;
            width: 100%;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .status-header {
            background: <?php echo $is_success ? '#28a745' : '#dc3545'; ?>;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .status-icon {
            font-size: 70px;
            margin-bottom: 15px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .status-title {
            font-size: 36px;
            font-weight: 900;
            margin-bottom: 10px;
        }

        .status-subtitle {
            font-size: 18px;
            opacity: 0.9;
        }

        .status-content {
            padding: 40px;
        }

        .transaction-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .detail-item {
            margin-bottom: 15px;
        }

        .detail-label {
            font-size: 14px;
            color: #666;
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }

        .detail-value {
            font-size: 18px;
            font-weight: 700;
            color: #333;
        }

        .commission-chain {
            background: #e8f4fd;
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 25px;
            margin: 25px 0;
        }

        .chain-title {
            color: #007bff;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            font-size: 20px;
        }

        .chain-levels {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .chain-levels::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 10%;
            right: 10%;
            height: 2px;
            background: #007bff;
            z-index: 1;
        }

        .level-box {
            background: white;
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            width: 30%;
            position: relative;
            z-index: 2;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .level-number {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .level-amount {
            font-size: 18px;
            font-weight: 900;
            color: #28a745;
            margin: 5px 0;
        }

        .level-percentage {
            font-size: 16px;
            color: #007bff;
            font-weight: 600;
        }

        .action-section {
            text-align: center;
            margin-top: 30px;
        }

        .btn {
            display: inline-block;
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            margin: 0 10px 10px;
            border: none;
            cursor: pointer;
        }

        .btn-success {
            background: #28a745;
            color: white;
            border: 2px solid #28a745;
        }

        .btn-success:hover {
            background: #218838;
            border-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-primary {
            background: #007bff;
            color: white;
            border: 2px solid #007bff;
        }

        .btn-primary:hover {
            background: #0056b3;
            border-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: #6c757d;
            border: 2px solid #6c757d;
        }

        .btn-outline:hover {
            background: #6c757d;
            color: white;
            transform: translateY(-2px);
        }

        .redirect-notice {
            text-align: center;
            margin-top: 25px;
            color: #6c757d;
            font-size: 14px;
        }

        .countdown {
            font-weight: 900;
            color: #007bff;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .status-content {
                padding: 25px 20px;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .chain-levels {
                flex-direction: column;
            }

            .chain-levels::before {
                display: none;
            }

            .level-box {
                width: 100%;
                margin-bottom: 15px;
            }

            .btn {
                display: block;
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>

<body>
    <div class="status-container">
        <div class="status-header">
            <div class="status-icon">
                <?php if ($is_success): ?>
                    <i class="fas fa-check-circle"></i>
                <?php else: ?>
                    <i class="fas fa-times-circle"></i>
                <?php endif; ?>
            </div>
            <h1 class="status-title">
                <?php echo $is_success ? 'Payment Successful!' : 'Payment Failed'; ?>
            </h1>
            <p class="status-subtitle">
                <?php echo $is_success ? 'Your transaction has been completed successfully.' : 'We could not process your payment.'; ?>
            </p>
        </div>

        <div class="status-content">
            <div class="transaction-details">
                <h3 style="margin-bottom:20px;color:#333;">Transaction Details</h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Transaction ID</span>
                        <span class="detail-value"><?php echo htmlspecialchars($display_transaction_id); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Amount</span>
                        <span class="detail-value">₹<?php echo number_format($display_amount, 2); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Date & Time</span>
                        <span class="detail-value"><?php echo date('F j, Y, g:i a'); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Status</span>
                        <span class="detail-value" style="color:<?php echo $is_success ? '#28a745' : '#dc3545'; ?>;">
                            <?php echo $is_success ? 'COMPLETED' : 'FAILED'; ?>
                        </span>
                    </div>
                </div>
            </div>

            <?php if ($is_success && isset($level1_commission)): ?>
                <div class="commission-chain">
                    <h4 class="chain-title"><i class="fas fa-network-wired"></i> Commission Distribution Chain</h4>
                    <div class="chain-levels">
                        <div class="level-box">
                            <div class="level-number">Level 1 (Direct)</div>
                            <div class="level-amount">₹<?php echo number_format($level1_commission ?? 0, 2); ?></div>
                            <div class="level-percentage"><?php echo ($level1_percentage ?? 0) * 100; ?>%</div>
                            <div style="font-size:12px;color:#666;margin-top:5px;">
                                <?php echo isset($level1_upline_id) ? "Upline ID: $level1_upline_id" : "No upline found"; ?>
                            </div>
                        </div>
                        <div class="level-box">
                            <div class="level-number">Level 2 (Indirect)</div>
                            <div class="level-amount">₹<?php echo number_format($level2_commission ?? 0, 2); ?></div>
                            <div class="level-percentage"><?php echo ($level2_percentage ?? 0) * 100; ?>%</div>
                            <div style="font-size:12px;color:#666;margin-top:5px;">
                                <?php echo isset($level2_upline_id) ? "Upline ID: $level2_upline_id" : "No upline found"; ?>
                            </div>
                        </div>
                        <div class="level-box">
                            <div class="level-number">Level 3 (Indirect)</div>
                            <div class="level-amount">₹<?php echo number_format($level3_commission ?? 0, 2); ?></div>
                            <div class="level-percentage"><?php echo ($level3_percentage ?? 0) * 100; ?>%</div>
                            <div style="font-size:12px;color:#666;margin-top:5px;">
                                <?php echo isset($level3_upline_id) ? "Upline ID: $level3_upline_id" : "No upline found"; ?>
                            </div>
                        </div>
                    </div>
                    <p style="text-align:center;margin-top:15px;color:#666;font-size:14px;">
                        Commission chain breaks if any upline is not found
                    </p>
                </div>
            <?php endif; ?>

            <div class="action-section">
                <?php if ($is_success): ?>
                    <a href="/setting.php" class="btn btn-success">
                        <i class="fas fa-tachometer-alt"></i> Go to Dashboard
                    </a>
                    <a href="/setting.php" class="btn btn-primary">
                        <i class="fas fa-user"></i> View Profile
                    </a>
                    <a href="/setting.php" class="btn btn-outline">
                        <i class="fas fa-users"></i> Refer & Earn
                    </a>
                <?php else: ?>
                    <a href="/plan.php" class="btn btn-primary">
                        <i class="fas fa-redo"></i> Try Again
                    </a>
                    <a href="/contact.php" class="btn btn-outline">
                        <i class="fas fa-headset"></i> Contact Support
                    </a>
                <?php endif; ?>
            </div>

            <div class="redirect-notice">
                <p>You will be redirected automatically in <span id="countdown" class="countdown">10</span> seconds...</p>
                <p style="font-size:12px;margin-top:5px;">Or click any button above to navigate manually</p>
            </div>
        </div>
    </div>

    <script>
        // Auto-redirect after countdown
        let countdown = 10;
        const countdownElement = document.getElementById('countdown');

        const countdownInterval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(countdownInterval);
                <?php if ($is_success): ?>
                    window.location.href = '/dashboard';
                <?php else: ?>
                    window.location.href = '/';
                <?php endif; ?>
            }
        }, 1000);

        // Manual redirect override
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
                clearInterval(countdownInterval);
                countdownElement.textContent = '0';
            });
        });
    </script>
</body>

</html>