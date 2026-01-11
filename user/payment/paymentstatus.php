<?php
// require_once "./utils/config.php";
// require_once "./utils/common.php";
// require_once "./utils/SendMail.php";
// print_r($_POST);

// if (isset($_POST['merchantId']) && isset($_POST['transactionId']) && isset($_POST['amount'])) {

//     $merchantId = $_POST['merchantId'];
//     $transactionId = $_POST['transactionId'];
//     $amount = $_POST['amount'];


//     session_start();

//     $name = $_SESSION['name'];
//     $email = $_SESSION['email'];
//     $mobile = $_SESSION['mobile'];




//     if (API_STATUS == "LIVE") {
//         $url = LIVESTATUSCHECKURL . $merchantId . "/" . $transactionId;
//         $saltkey = SALTKEYLIVE;
//         $saltindex = SALTINDEX;
//     } else {
//         $url = STATUSCHECKURL . $merchantId . "/" . $transactionId;
//         $saltkey = SALTKEYUAT;
//         $saltindex = SALTINDEX;
//     }



//     $st = "/pg/v1/status/" . $merchantId . "/" . $transactionId . $saltkey;

//     $dataSha256 = hash("sha256", $st);

//     $checksum = $dataSha256 . "###" . $saltindex;


//     //GET API CALLING
//     $headers = array(
//         "Content-Type: application/json",
//         "accept: application/json",
//         "X-VERIFY: " . $checksum,
//         "X-MERCHANT-ID:" . $merchantId
//     );



//     $curl = curl_init();
//     curl_setopt($curl, CURLOPT_URL, $url);
//     curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
//     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, '0');
//     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, '0');
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

//     $resp = curl_exec($curl);

//     curl_close($curl);

//     $responsePayment = json_decode($resp, true);

//     echo "<pre>";
//     print_r($responsePayment);
//     echo "</pre>";


//     $tran_id = $responsePayment['data']['transactionId'];
//     $amount = $responsePayment['data']['amount'];



//     if ($responsePayment['success'] && $responsePayment['code'] == "PAYMENT_SUCCESS") {
//         //Send Email and redirect to success page

//         $now = new DateTime();
//         $timestring = $now->format('d-M-Y h:i:s');

//         $msg = 'Dear ' . $name . ",<br/>";
//         $msg .= '<br/>We have received your payment and Below is your payment Details<br/> ';
//         $msg .= '<table>';
//         $msg .= '<tr><td>Name:</td><td>' . $name . '</td></tr>';
//         $msg .= '<tr><td>Email:</td><td>' . $email . '</td></tr>';
//         $msg .= '<tr><td>Mobile:</td><td>' . $mobile . '</td></tr>';
//         $msg .= '<tr><td>Amount:</td><td>Rs.' . $amount / 100 . '</td></tr>';
//         $msg .= '<tr><td>Transaction id:</td><td>' . $tran_id . '</td></tr>';
//         $msg .= '<tr><td>Date:</td><td>' . $timestring . '</td></tr>';
//         $msg .= '</table><br/>';

//         $msg .= '<p>From,</p>';
//         $msg .= '<p>Techmalasi Team</p>';

//         $ob = new Mail();
//         $r = $ob->sendMail($email, $msg);
//         echo "response>>" . $r;
//         sleep(3);
        
//         if ($r)
//             header('Location:' . BASE_URL . "success.php?tid=" . $tran_id . "&amount=" . $amount);
//         else
//             header('Location:' . BASE_URL . "success.php?tid=" . $tran_id . "&amount=" . $amount);

//     } else {
//         header('Location:' . BASE_URL . "failure.php?tid=" . $tran_id . "&amount=" . $amount);
//     }
// }
?>


<?php
require_once "./utils/config.php";
require_once "./utils/common.php";
require_once "./utils/SendMail.php";

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

    // echo "<pre>";
    // print_r($responsePayment);
    // echo "</pre>";

    if ($responsePayment['success'] && $responsePayment['code'] == "PAYMENT_SUCCESS") {
        $tran_id = $responsePayment['data']['transactionId'];
        $payment_amount = $responsePayment['data']['amount'] / 100; // Amount in rupees

        $now = new DateTime();
        $timestring = $now->format('F j, Y'); // e.g., August 25, 2025

        //Send Email and redirect to success page
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
                                                    Hi ' . $name . ',
                                                </p>
                                                <p style="font-size: 16px; color: #555555; line-height: 1.6em; margin: 0;">
                                                    Thank you for purchasing our <strong style="color: #000000;">₹' . $payment_amount . ' plan!</strong> We\'re thrilled to have you on board and are excited to help you unlock new opportunities for your business.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 15px 0;">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td width="50%" valign="top">
                                                            <p style="font-size: 14px; color: #333333; margin: 0; font-weight: bold;">Billed to:</p>
                                                            <p style="font-size: 14px; color: #555555; margin: 5px 0 0 0;">' . $name . '</p>
                                                        </td>
                                                        <td width="50%" valign="top">
                                                             <p style="font-size: 14px; color: #333333; margin: 0; font-weight: bold;">Order details:</p>
                                                             <p style="font-size: 14px; color: #555555; margin: 5px 0 0 0;">Transaction ID: ' . $tran_id . '</p>
                                                             <p style="font-size: 14px; color: #555555; margin: 5px 0 0 0;">Date: ' . $timestring . '</p>
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
                                                        <td align="right" style="padding: 15px 0; font-size: 16px; color: #333333; font-weight: bold;">₹' . number_format($payment_amount, 2) . '</td>
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
                                                <a href="[Your Video Tutorial Link]" target="_blank" style="font-size: 15px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 6px; padding: 12px 25px; border: 1px solid #28a745; display: inline-block; font-weight: bold;">
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
                                   <a href="[Your Newsletter Link]" style="color: #ffffff; text-decoration: underline;">Subscribe to the Shopercity newsletter</a>
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

        $ob = new Mail();
        $r = $ob->sendMail($email, "Your Shopercity Purchase Receipt", $msg);
        echo "response>>" . $r;
        sleep(3);
        
        $redirect_url = BASE_URL . "success.php?tid=" . $tran_id . "&amount=" . ($payment_amount * 100);
        header('Location:' . $redirect_url);

    } else {
        $tran_id = isset($responsePayment['data']['transactionId']) ? $responsePayment['data']['transactionId'] : 'N/A';
        $payment_amount = isset($responsePayment['data']['amount']) ? $responsePayment['data']['amount'] : '0';
        
        $redirect_url = BASE_URL . "failure.php?tid=" . $tran_id . "&amount=" . $payment_amount;
        header('Location:' . $redirect_url);
    }
}
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
                                                    Hi,
                                                </p>
                                                <p style="font-size: 16px; color: #555555; line-height: 1.6em; margin: 0;">
                                                    Thank you for purchasing our <strong style="color: #000000;">₹100 plan!</strong> We\'re thrilled to have you on board and are excited to help you unlock new opportunities for your business.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 15px 0;">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td width="50%" valign="top">
                                                            <p style="font-size: 14px; color: #333333; margin: 0; font-weight: bold;">Billed to:</p>
                                                            <p style="font-size: 14px; color: #555555; margin: 5px 0 0 0;">100</p>
                                                        </td>
                                                        <td width="50%" valign="top">
                                                             <p style="font-size: 14px; color: #333333; margin: 0; font-weight: bold;">Order details:</p>
                                                             <p style="font-size: 14px; color: #555555; margin: 5px 0 0 0;">Transaction ID: test</p>
                                                             <p style="font-size: 14px; color: #555555; margin: 5px 0 0 0;">Date: test</p>
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
                                                        <td align="right" style="padding: 15px 0; font-size: 16px; color: #333333; font-weight: bold;">₹1000</td>
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
                                                <a href="[Your Video Tutorial Link]" target="_blank" style="font-size: 15px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 6px; padding: 12px 25px; border: 1px solid #28a745; display: inline-block; font-weight: bold;">
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
                                   <a href="[Your Newsletter Link]" style="color: #ffffff; text-decoration: underline;">Subscribe to the Shopercity newsletter</a>
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

        $ob = new Mail();
        $r = $ob->sendMail('prakash1204@yopmail.com', "Your Shopercity Purchase Receipt", $msg);
        echo "response>>" . $r;
        sleep(3);
?>