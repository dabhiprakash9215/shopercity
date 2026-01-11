<?php
require_once "db/connection.php";
require_once "./utils/config.php";
require_once "./utils/common.php";
// require_once "./utils/SendMail.php";
print_r($_POST['merchantId']);
print_r($_GET);
die;

if (isset($_POST['merchantId']) && isset($_POST['transactionId']) && isset($_POST['amount'])) {

    $merchantId = $_POST['merchantId'];
    $transactionId = $_POST['transactionId'];
    $amount = $_POST['amount'];


    session_start();

    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $mobile = $_SESSION['mobile'];




    if (API_STATUS == "LIVE") {
        $url = LIVESTATUSCHECKURL . $merchantId . "/" . $transactionId;
        $saltkey = SALTKEYLIVE;
        $saltindex = SALTINDEX;
    } else {
        $url = STATUSCHECKURL . $merchantId . "/" . $transactionId;
        $saltkey = SALTKEYUAT;
        $saltindex = SALTINDEX;
    }



    $st = "/pg/v1/status/" . $merchantId . "/" . $transactionId . $saltkey;

    $dataSha256 = hash("sha256", $st);

    $checksum = $dataSha256 . "###" . $saltindex;


    //GET API CALLING
    $headers = array(
        "Content-Type: application/json",
        "accept: application/json",
        "X-VERIFY: " . $checksum,
        "X-MERCHANT-ID:" . $merchantId
    );



    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, '0');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, '0');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $resp = curl_exec($curl);

    curl_close($curl);

    $responsePayment = json_decode($resp, true);

    echo "<pre>";
    print_r($responsePayment);
    echo "</pre>";


    $tran_id = $responsePayment['data']['transactionId'];
    $amount = $responsePayment['data']['amount'];



    if ($responsePayment['success'] && $responsePayment['code'] == "PAYMENT_SUCCESS") {
        //Send Email and redirect to success page

        $now = new DateTime();
        $timestring = $now->format('d-M-Y h:i:s');

        $msg = 'Dear ' . $name . ",<br/>";
        $msg .= '<br/>We have received your payment and Below is your payment Details<br/> ';
        $msg .= '<table>';
        $msg .= '<tr><td>Name:</td><td>' . $name . '</td></tr>';
        $msg .= '<tr><td>Email:</td><td>' . $email . '</td></tr>';
        $msg .= '<tr><td>Mobile:</td><td>' . $mobile . '</td></tr>';
        $msg .= '<tr><td>Amount:</td><td>Rs.' . $amount / 100 . '</td></tr>';
        $msg .= '<tr><td>Transaction id:</td><td>' . $tran_id . '</td></tr>';
        $msg .= '<tr><td>Date:</td><td>' . $timestring . '</td></tr>';
        $msg .= '</table><br/>';

        $msg .= '<p>From,</p>';
        $msg .= '<p>Techmalasi Team</p>';

        $ob = new Mail();
        $r =  $ob->sendMail($email, $msg);
        echo "response>>" . $r;
        sleep(3);

        if ($r)
            header('Location:' . BASE_URL . "success.php?tid=" . $tran_id . "&amount=" . $amount);
        else
            header('Location:' . BASE_URL . "success.php?tid=" . $tran_id . "&amount=" . $amount);
    } else {

        header('Location:' . BASE_URL . "failure.php?tid=" . $tran_id . "&amount=" . $amount);
    }
}



if (isset($_GET)) {
    if ($_GET['rp_payment_id']) {
        $order_id = $_GET['rp_payment_id'];
        $user_id = $_SESSION['user_id'];
        $created_at = date("Y-m-d H:i:s");

        // Define commission percentages for each level
        $level1_percentage = 0.25; // 25% for direct upline
        $level2_percentage = 0.10; // 10% for second level upline
        $level3_percentage = 0.10; // 10% for third level upline

        // Calculate commission amounts
        $total_payment = 2000; // Total payment
        $level1_commission = $total_payment * $level1_percentage;
        $level2_commission = $total_payment * $level2_percentage;
        $level3_commission = $total_payment * $level3_percentage;

        // Insert transaction for the user
        $sql = "INSERT INTO transaction (order_id, user_id, balance, created_at) VALUES ('$order_id', '$user_id', '$total_payment', '$created_at')";
        $qry = "UPDATE users SET status = 1   WHERE id = '$user_id'";
        $conn->query($qry);
        $conn->query($update_level3_balance_sql);
        $_SESSION['is_active'] = 1;
        // Check if the transaction was successful
        if ($conn->query($sql) === TRUE) {
            // Update user balance with level 1 commission
            $get_user = "SELECT upline_id FROM users WHERE id = '$user_id'";
            $qry1 = "select upline_id from users where id='$user_id'";
            $res = mysqli_query($conn, $qry1);
            $rows = mysqli_fetch_array($res);
            $dirst_level_upline_id = $rows['upline_id'];
            $update_balance_sql = "UPDATE users SET balance = balance + $level1_commission WHERE id = '$dirst_level_upline_id'";
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
                $update_level2_balance_sql = "UPDATE users SET balance = balance + $level2_commission WHERE id = '$level1_upline_id'";
                $conn->query($update_level2_balance_sql);
                $qry3 = "INSERT INTO transaction (order_id, user_id, balance, created_at) VALUES ('$order_id', '$level1_upline_id','$level2_commission', '$created_at')";
                $conn->query($qry3);
                // Get level 2 upline
                $level2_upline_sql = "SELECT upline_id FROM users WHERE id = '$level1_upline_id'";
                $level2_upline_result = $conn->query($level2_upline_sql);

                if ($level2_upline_result->num_rows > 0) {
                    $level2_upline_row = $level2_upline_result->fetch_assoc();
                    $level2_upline_id = $level2_upline_row['upline_id'];
                    $update_level3_balance_sql = "UPDATE users SET balance = balance + $level3_commission WHERE id = '$level2_upline_id'";
                    $qry4 = "INSERT INTO transaction (order_id, user_id, balance, created_at) VALUES ('$order_id', '$level2_upline_id', '$level3_commission', '$created_at')";
                    $conn->query($qry4);
                    $conn->query($update_level3_balance_sql);
                }
            }
        }
        $_SESSION['success_msg'] = "Payment is successfully.";
        header("Location: plan.php");
    } else {
        $_SESSION['success_msg'] = "Payment is Faild.";
        header("Location: plan.php");
    }
}
