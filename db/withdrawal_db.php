<?php
require_once "connection.php";
if (isset($_POST['withdraw'])) {
    $amount = $_POST['amount'];
    $upi = $_POST['upi'];
    if ($amount < 3000 || $amount > 10000) {
        $_SESSION['error_msg'] = "withdrawal amount must be between 3000 and 10000.";
        header("Location: ../account.php");
        exit();
    }
    $userId = $_SESSION['user_id'];
    // Check user balance
    $balanceQuery = "SELECT balance FROM users WHERE id = $userId";
    $balanceResult = mysqli_query($conn, $balanceQuery);
    $row = mysqli_fetch_assoc($balanceResult);
    $balance = $row['balance'];

    if ($balance < $amount) {
        $_SESSION['error_msg'] = "Insufficient balance for withdrawal.";
        header("Location: ../account.php");
        exit();
    }
    $qry = "SELECT balance, withdraw_total FROM users WHERE id = $userId";
    $res = mysqli_query($conn, $qry);
    $row = mysqli_fetch_assoc($res);
    $balance = $row['balance'];
    $withdrawalBalance = $row['withdraw_total'];
    // Update balance
    $newBalance = $balance - $amount;
    $totalWithdraw = $withdrawalBalance + $amount;
    $message = "";
    $status = 0; // or 'pending', etc., depending on your workflow
    if ($withdrawalBalance >= 40000) {
        $status = 1;
        $newBalance = $balance - 2000;
        $message = "2000 charges in Membership";
        $updateQuery = "UPDATE users SET balance = $newBalance,  withdraw_total = 0 WHERE id = $userId";
        mysqli_query($conn, $updateQuery);
        // Define commission percentages for each level
        $level1_percentage = 0.25; // 25% for direct upline
        $level2_percentage = 0.10; // 10% for second level upline
        $level3_percentage = 0.10; // 10% for third level upline

        // Calculate commission amounts
        $total_payment = 2000; // Total payment
        $level1_commission = $total_payment * $level1_percentage;
        $level2_commission = $total_payment * $level2_percentage;
        $level3_commission = $total_payment * $level3_percentage;

        // Update user balance with level 1 commission
        $get_user = "SELECT upline_id FROM users WHERE id = '$userId'";
        $qry1 = "select upline_id from users where id='$userId'";
        $res = mysqli_query($conn, $qry1);
        $rows = mysqli_fetch_array($res);
        $dirst_level_upline_id = $rows['upline_id'];
        $update_balance_sql = "UPDATE users SET balance = balance + $level1_commission,is_active = 1 WHERE id = '$dirst_level_upline_id'";
        $qry2 = "INSERT INTO transaction (order_id, user_id, balance, created_at) VALUES ('$order_id', '$dirst_level_upline_id',' $level1_commission', '$created_at')";
        $conn->query($qry2);
        $conn->query($update_balance_sql);
        // Get user's upline (level 1)
        $level1_upline_sql = "SELECT upline_id FROM users WHERE id = '$dirst_level_upline_id'";
        $level1_upline_result = $conn->query($level1_upline_sql);

        if ($level1_upline_result->num_rows > 0) {
            $level1_upline_row = $level1_upline_result->fetch_assoc();
            $level1_upline_id = $level1_upline_row['upline_id'];
            // Update level 1 upline's balance with level 2 commission
            $update_level2_balance_sql = "UPDATE users SET balance = balance + $level2_commission,is_active = 1 WHERE id = '$level1_upline_id'";
            $conn->query($update_level2_balance_sql);
            $qry3 = "INSERT INTO transaction (order_id, user_id, balance, created_at) VALUES ('$order_id', '$level1_upline_id','$level2_commission', '$created_at')";
            $conn->query($qry3);
            // Get level 2 upline
            $level2_upline_sql = "SELECT upline_id FROM users WHERE id = '$level1_upline_id'";
            $level2_upline_result = $conn->query($level2_upline_sql);

            if ($level2_upline_result->num_rows > 0) {
                $level2_upline_row = $level2_upline_result->fetch_assoc();
                $level2_upline_id = $level2_upline_row['upline_id'];
                $update_level3_balance_sql = "UPDATE users SET balance = balance + $level3_commission, is_active = 1 WHERE id = '$level2_upline_id'";
                $qry4 = "INSERT INTO transaction (order_id, user_id, balance, created_at) VALUES ('$order_id', '$level2_upline_id', '$level3_commission', '$created_at')";
                $conn->query($qry4);
                $conn->query($update_level3_balance_sql);
            }
        }
        $amount = 2000;
    } else {
        $updateQuery = "UPDATE users SET balance = $newBalance, withdraw_total = $totalWithdraw WHERE id = $userId";
        mysqli_query($conn, $updateQuery);
    }

    // Record withdrawal
    $createdAt = date('Y-m-d H:i:s');
    $withdrawalQuery = "INSERT INTO withdrawals (user_id, upi, amount, message, created_at, status) VALUES ('$userId', '$upi',' $amount', '$message', '$createdAt', '$status')";
    mysqli_query($conn, $withdrawalQuery);
    $_SESSION['success_msg'] = "withdwals successfully";
    header("Location: ../account.php");
    exit();
}
