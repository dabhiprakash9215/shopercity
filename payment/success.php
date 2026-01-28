<?php
session_start(); // Start the session if not already started
require_once "../db/connection.php";

if (isset($_POST['code']) && $_POST['code'] == "PAYMENT_SUCCESS") {
    $order_id = mysqli_real_escape_string($conn, $_POST['transactionId']);
    $total_payment = 150; // Get amount from POST and convert to actual currency

    // Use prepared statements for security and efficiency
    $qry_order = "SELECT id, transaction_id, user_id FROM pay_transaction WHERE transaction_id = ?";
    $stmt_order = mysqli_prepare($conn, $qry_order);
    mysqli_stmt_bind_param($stmt_order, "s", $order_id);
    mysqli_stmt_execute($stmt_order);
    $res_order = mysqli_stmt_get_result($stmt_order);
    $rows_orders = mysqli_fetch_assoc($res_order); // Use fetch_assoc for easier access by column name

    if ($rows_orders) {
        $row_transaction_id = $rows_orders['transaction_id'];
        $user_id = $rows_orders['user_id'];
        $transaction_amount = 150; // Get the original transaction amount
        $query = "SELECT * FROM commission_settings WHERE is_active = 1 LIMIT 1";
        $result = mysqli_query($conn, $query);
        $commission = mysqli_fetch_assoc($result);
        if ($commission['plan_price']) {
            $transaction_amount = $commission['plan_price'];
        }
        if ($order_id == $row_transaction_id) {
            $sel_admin_qry = "SELECT * FROM users WHERE id = ?";
            $stmt_admin = mysqli_prepare($conn, $sel_admin_qry);
            mysqli_stmt_bind_param($stmt_admin, "i", $user_id);
            mysqli_stmt_execute($stmt_admin);
            $sel_admin = mysqli_stmt_get_result($stmt_admin);
            $fetch_row = mysqli_fetch_assoc($sel_admin);

            if ($fetch_row) {
                $_SESSION['user_id'] = $fetch_row['id'];
                $_SESSION['first_name'] = $fetch_row['first_name'];
                $_SESSION['last_name'] = $fetch_row['last_name'];
                $_SESSION['email'] = $fetch_row['email'];
                $_SESSION['mobile'] = $fetch_row['mobile'];
                $_SESSION['address'] = $fetch_row['address'] ?? "";
                $_SESSION['city'] = $fetch_row['city'] ?? "";
                $_SESSION['state'] = $fetch_row['state'] ?? "";
                $_SESSION['country'] = $fetch_row['country'] ?? "";
                $_SESSION['old_img'] = $fetch_row['image'] ?? "";
                $_SESSION['pincode'] = $fetch_row['pincode'] ?? "";
                $_SESSION['referral_id'] = $fetch_row['referral_id'] ?? "";
                $_SESSION['aadhar_number'] = $fetch_row['aadhar_number'] ?? "";
                $_SESSION['is_active'] = 1; // Mark user as active

                // Update pay_transaction status to 1 (successful)
                $upd_ord_qry = "UPDATE pay_transaction SET status = 1 WHERE transaction_id = ?";
                $stmt_upd_ord = mysqli_prepare($conn, $upd_ord_qry);
                mysqli_stmt_bind_param($stmt_upd_ord, "s", $order_id);
                mysqli_stmt_execute($stmt_upd_ord);

                // Update user's is_active status
                $upd_user_active_qry = "UPDATE users SET is_active = 1 WHERE id = ?";
                $stmt_upd_user_active = mysqli_prepare($conn, $upd_user_active_qry);
                mysqli_stmt_bind_param($stmt_upd_user_active, "i", $user_id);
                mysqli_stmt_execute($stmt_upd_user_active);

                $created_at = date("Y-m-d H:i:s");

                // Define commission percentages for each level
                $level1_percentage = '0.' . $commission['level_1']; // 25% for direct upline
                $level2_percentage = ' 0.' . $commission['level_2']; // 10% for second level upline
                $level3_percentage = '0.' . $commission['level_3']; // 10% for third level upline

                // // Calculate commission amounts based on the actual transaction amount
                $level1_commission = $transaction_amount * $level1_percentage;
                $level2_commission = $transaction_amount * $level2_percentage;
                $level3_commission = $transaction_amount * $level3_percentage;

                // Insert transaction for the purchasing user (initial payment)
                $sql = "INSERT INTO transaction (order_id, user_id, balance, created_at) VALUES (?, ?, ?, ?)";
                $stmt_insert_user_trans = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt_insert_user_trans, "sids", $order_id, $user_id, $transaction_amount, $created_at);

                if (mysqli_stmt_execute($stmt_insert_user_trans)) {
                    // Get user's direct upline (level 1)
                    $qry1 = "SELECT upline_id FROM users WHERE id = ?";
                    $stmt_upline1 = mysqli_prepare($conn, $qry1);
                    mysqli_stmt_bind_param($stmt_upline1, "i", $user_id);
                    mysqli_stmt_execute($stmt_upline1);
                    $res1 = mysqli_stmt_get_result($stmt_upline1);
                    $rows1 = mysqli_fetch_assoc($res1);
                    $first_level_upline_id = $rows1['upline_id'] ?? null;

                    if ($first_level_upline_id) {
                        // Update direct upline's balance with level 1 commission
                        $update_balance_sql1 = "UPDATE users SET balance = balance + ? WHERE id = ?";
                        $stmt_update_balance1 = mysqli_prepare($conn, $update_balance_sql1);
                        mysqli_stmt_bind_param($stmt_update_balance1, "di", $level1_commission, $first_level_upline_id);
                        mysqli_stmt_execute($stmt_update_balance1);

                        // Insert transaction for level 1 upline
                        $qry_insert_trans1 = "INSERT INTO transaction (order_id, user_id, balance, created_at) VALUES (?, ?, ?, ?)";
                        $stmt_insert_trans1 = mysqli_prepare($conn, $qry_insert_trans1);
                        mysqli_stmt_bind_param($stmt_insert_trans1, "sids", $order_id, $first_level_upline_id, $level1_commission, $created_at);
                        mysqli_stmt_execute($stmt_insert_trans1);

                        // Get level 2 upline (upline of the direct upline)
                        $qry2 = "SELECT upline_id FROM users WHERE id = ?";
                        $stmt_upline2 = mysqli_prepare($conn, $qry2);
                        mysqli_stmt_bind_param($stmt_upline2, "i", $first_level_upline_id);
                        mysqli_stmt_execute($stmt_upline2);
                        $res2 = mysqli_stmt_get_result($stmt_upline2);
                        $rows2 = mysqli_fetch_assoc($res2);
                        $second_level_upline_id = $rows2['upline_id'] ?? null;

                        if ($second_level_upline_id) {
                            // Update level 2 upline's balance with level 2 commission
                            $update_balance_sql2 = "UPDATE users SET balance = balance + ? WHERE id = ?";
                            $stmt_update_balance2 = mysqli_prepare($conn, $update_balance_sql2);
                            mysqli_stmt_bind_param($stmt_update_balance2, "di", $level2_commission, $second_level_upline_id);
                            mysqli_stmt_execute($stmt_update_balance2);

                            // Insert transaction for level 2 upline
                            $qry_insert_trans2 = "INSERT INTO transaction (order_id, user_id, balance, created_at) VALUES (?, ?, ?, ?)";
                            $stmt_insert_trans2 = mysqli_prepare($conn, $qry_insert_trans2);
                            mysqli_stmt_bind_param($stmt_insert_trans2, "sids", $order_id, $second_level_upline_id, $level2_commission, $created_at);
                            mysqli_stmt_execute($stmt_insert_trans2);

                            // Get level 3 upline (upline of the second level upline)
                            $qry3 = "SELECT upline_id FROM users WHERE id = ?";
                            $stmt_upline3 = mysqli_prepare($conn, $qry3);
                            mysqli_stmt_bind_param($stmt_upline3, "i", $second_level_upline_id);
                            mysqli_stmt_execute($stmt_upline3);
                            $res3 = mysqli_stmt_get_result($stmt_upline3);
                            $rows3 = mysqli_fetch_assoc($res3);
                            $third_level_upline_id = $rows3['upline_id'] ?? null;

                            if ($third_level_upline_id) {
                                // Update level 3 upline's balance with level 3 commission
                                $update_balance_sql3 = "UPDATE users SET balance = balance + ? WHERE id = ?";
                                $stmt_update_balance3 = mysqli_prepare($conn, $update_balance_sql3);
                                mysqli_stmt_bind_param($stmt_update_balance3, "di", $level3_commission, $third_level_upline_id);
                                mysqli_stmt_execute($stmt_update_balance3);

                                // Insert transaction for level 3 upline
                                $qry_insert_trans3 = "INSERT INTO transaction (order_id, user_id, balance, created_at) VALUES (?, ?, ?, ?)";
                                $stmt_insert_trans3 = mysqli_prepare($conn, $qry_insert_trans3);
                                mysqli_stmt_bind_param($stmt_insert_trans3, "sids", $order_id, $third_level_upline_id, $level3_commission, $created_at);
                                mysqli_stmt_execute($stmt_insert_trans3);
                            }
                        }
                    }
                }

                // Email sending logic
                $now = new DateTime();
                $timestring = $now->format('F j, Y');

                $msg = '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Your Shopercity Purchase Receipt</title>
                </head>
                <body style="margin: 0; padding: 0; background-color: #f7f5f2; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif;">
                    <span style="display:none; font-size:1px; color:#ffffff; line-height:1px; max-height:0px; max-width:0px; opacity:0; overflow:hidden;">
                        Thank you for your purchase! Here are your plan details and how to start earning.
                    </span>
                
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td align="center" bgcolor="#ffde00" style="padding: 20px 0;">
                                            <img src="https://shopercity.com/assets/images/logo.png" alt="Shopercity Logo" width="100" style="display: block; border: 0;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ffffff" style="padding: 30px 30px 20px 30px;">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td>
                                                        <h1 style="font-size: 24px; color: #333333; margin: 0; font-weight: 600;">
                                                            <span style="color: #e73168; vertical-align: middle;">♥</span> Thanks for your purchase!
                                                        </h1>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 20px 0;">
                                                        <p style="font-size: 16px; color: #555555; line-height: 1.6em; margin: 0 0 15px 0;">
                                                            Hi ' . htmlspecialchars($fetch_row['first_name'] . ' ' . $fetch_row['last_name']) . ',
                                                        </p>
                                                        <p style="font-size: 16px; color: #555555; line-height: 1.6em; margin: 0;">
                                                            Thank you for purchasing our <strong style="color: #000000;">₹' . number_format($transaction_amount) . ' plan!</strong> We\'re thrilled to have you on board and are excited to help you unlock new opportunities for your business.
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 15px 0;">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tr>
                                                                <td width="50%" valign="top">
                                                                    <p style="font-size: 14px; color: #333333; margin: 0; font-weight: bold;">Billed to:</p>
                                                                    <p style="font-size: 14px; color: #555555; margin: 5px 0 0 0;">' .  htmlspecialchars($fetch_row['first_name'] . ' ' . $fetch_row['last_name'])  . '</p>
                                                                </td>
                                                                <td width="50%" valign="top">
                                                                     <p style="font-size: 14px; color: #333333; margin: 0; font-weight: bold;">Order details:</p>
                                                                     <p style="font-size: 14px; color: #555555; margin: 5px 0 0 0;">Transaction ID: ' . htmlspecialchars($order_id) . '</p>
                                                                     <p style="font-size: 14px; color: #555555; margin: 5px 0 0 0;">Date: ' . htmlspecialchars($timestring) . '</p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 20px;">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tr style="border-top: 1px solid #eeeeee; border-bottom: 1px solid #eeeeee;">
                                                                <td style="padding: 12px 0; font-size: 15px; color: #555555;">Plan Benefits Unlocked</td>
                                                                <td align="right" style="padding: 12px 0; font-size: 15px; color: #555555;"></td>
                                                            </tr>
                                                            <tr style="border-bottom: 1px solid #eeeeee;">
                                                                 <td colspan="2" style="padding: 12px 0 12px 15px; font-size: 14px; color: #555555; line-height: 1.6;">
                                                                    - Access All Features<br>
                                                                    - Unlimited Use for 2 Years<br>
                                                                    - Manage 10 Stores<br>
                                                                    - Referral & Agency Code<br>
                                                                    - Full Marketing Support
                                                                 </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 15px 0; font-size: 16px; color: #333333; font-weight: bold;">Total Paid</td>
                                                                <td align="right" style="padding: 15px 0; font-size: 16px; color: #333333; font-weight: bold;">₹' . number_format($transaction_amount) . '</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 20px 0;">
                                                        <p style="font-size: 15px; color: #555555; line-height: 1.6em; margin: 0;">
                                                            You can access your account and dashboard by logging in. <br><a href="https://shopercity.com" target="_blank" style="color: #007BFF; text-decoration: underline;">Go to Your Dashboard</a>.
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td></tr>
                                    <tr>
                                        <td bgcolor="#f5f4f9" style="padding: 30px;">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr><td align="center">
                                                    <h2 style="font-size: 18px; color: #333333; margin: 0 0 10px 0; font-weight: 600;">Earn With Shopercity</h2>
                                                </td></tr>
                                                <tr><td align="center">
                                                    <p style="font-size: 15px; color: #555555; line-height: 1.6em; margin: 0 0 20px 0; max-width: 450px;">
                                                        Become a partner, share your unique Agency Code, and earn unlimited bonuses when your referrals subscribe. It’s that simple!
                                                    </p>
                                                </td></tr>
                                                <tr><td align="center">
                                                    <table border="0" cellspacing="0" cellpadding="0"><tr><td align="center" style="border-radius: 6px;" bgcolor="#28a745">
                                                        <a href="https://www.shopercity.com" target="_blank" style="font-size: 15px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 6px; padding: 12px 25px; border: 1px solid #28a745; display: inline-block; font-weight: bold;">
                                                            Learn How It Works
                                                        </a>
                                                    </td></tr></table>
                                                </td></tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ffde00" align="center" style="padding: 12px 20px; font-size: 14px; color: #333333;">
                                            If you have questions, feel free to <a href="https://shopercity.com/contact-us.php" style="color: #999999; text-decoration: underline;">contact us</a>.
                                        </td>
                                    </tr>
                                     <tr>
                                        <td bgcolor="#4a4a4a" align="center" style="padding: 12px 20px; font-size: 14px;">
                                           <a href="https://www.shopercity.com" style="color: #ffffff; text-decoration: underline;">Subscribe to the Shopercity newsletter</a>
                                        </td>
                                    </tr>
                                    <tr>
                                         <td align="center" style="padding: 20px 20px; font-size: 12px; color: #999999; line-height: 1.5;">
                                         </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>
                </html>';

                // Set appropriate headers for HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: Shopercity <noreply@shopercity.com>" . "\r\n"; // Sender's email address

                // Send email
                mail($fetch_row['email'], "Your Shopercity Purchase Receipt", $msg, $headers);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Status</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <style>
        body {
            text-align: center;
            padding: 40px 0;
            background: #EBF0F5;
        }

        h1 {
            color: <?php echo ($_POST['code'] == 'PAYMENT_SUCCESS') ? '#88B04B' : '#D11A2A'; ?>;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-weight: 900;
            font-size: 40px;
            margin-bottom: 10px;
        }

        p {
            color: #404F5E;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-size: 20px;
            margin: 0;
        }

        i {
            color: <?php echo ($_POST['code'] == 'PAYMENT_SUCCESS') ? '#9ABC66' : '#D11A2A'; ?>;
            font-size: 100px;
            line-height: 200px;
            margin-left: -15px;
        }

        .card {
            background: white;
            padding: 60px;
            border-radius: 4px;
            box-shadow: 0 2px 3px #C8D0D8;
            display: inline-block;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="card">
        <div style="border-radius:200px; height:200px; width:200px; background:<?php echo ($_POST['code'] == 'PAYMENT_SUCCESS') ? '#F8FAF5;' : '#FFEDED;'; ?> margin:0 auto;">
            <i class="checkmark">
                <?php echo ($_POST['code'] == 'PAYMENT_SUCCESS') ? '✓' : 'X'; ?>
            </i>
        </div>

        <h1><?php echo ($_POST['code'] == 'PAYMENT_SUCCESS') ? 'Success' : 'Failed'; ?></h1>
        <p>Transaction ID : <?php echo htmlspecialchars($_POST['transactionId'] ?? 'N/A'); ?></p>
        <p>Amount : ₹<?php echo number_format($total_payment ?? 0, 2); ?></p>
        <p>
            <?php
            if ($_POST['code'] == 'PAYMENT_SUCCESS') {
                echo "We received your purchase request;<br /> we'll be in touch shortly!";
            } else {
                echo 'Your Transaction has Failed. Please try again later.';
            }
            ?>
        </p>
    </div>

    <script>
        function redirectPage() {
            // Uncomme?nt the line below to enable redirection
            window.location.href = "https://www.shopercity.com/";
        }
        setTimeout(redirectPage, 4000); // Redirect after 5 seconds
    </script>
</body>

</html>