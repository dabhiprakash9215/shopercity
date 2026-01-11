<?php
// Set transaction details
$order_id = uniqid();
$name = "SHOPERCITY INFO SERVICE";
$email = "dabhiprakash32244@gmail.com";
$mobile = 9328797950;
$amount = 1; // amount in INR
$description = 'Payment for Product/Service';

require_once "./utils/config.php";
require_once "./utils/common.php";

    $merchantid  = MERCHANTIDUAT;
    $saltkey = SALTKEYUAT;
    $saltindex = SALTINDEX;


    $payLoad = array(
        'merchantId' => $merchantid,
        'merchantTransactionId' => "MT-" . getTransactionID(), // test transactionID
        "merchantUserId" => "M-" . uniqid(),
        'amount' => $amount * 100, // phone pe works on paise
        'redirectUrl' => BASE_URL . REDIRECTURL,
        'redirectMode' => "POST",
        'callbackUrl' => BASE_URL . REDIRECTURL,
        "mobileNumber" => $mobile,
        "email" => $email,
        "param1"=>$name,
        "paymentInstrument" => array(
            "type" => "PAY_PAGE",
        )
    );
    $jsonencode = json_encode($payLoad);
    $payloadbase64 = base64_encode($jsonencode);
    $payloaddata = $payloadbase64 . "/pg/v1/pay" . $saltkey;
    $sha256 = hash("sha256", $payloaddata);
    $checksum = $sha256 . '###' . $saltindex;
    $request = json_encode(array('request' => $payloadbase64));

    // $url = '';
    // if(API_STATUS == "LIVE") {
        $url = LIVEURLPAY;
    // } else {
    //     $url = UATURLPAY;
    // }

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $request,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "X-VERIFY: " . $checksum,
            "accept: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      $res = json_decode($response);
      if (isset($res->success) && $res->success == '1') {
        // $paymentCode=$res->code;
        // $paymentMsg=$res->message;
        $payUrl = $res->data->instrumentResponse->redirectInfo->url;
        header('Location:' . $payUrl);
      }

    }