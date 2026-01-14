<?php
// 1️⃣ Read raw POST data

require_once "./payment/utils/config.php";
require_once "./payment/utils/common.php";
$payload = file_get_contents("php://input");
$headers = getallheaders();

// 2️⃣ Convert JSON to array
$data = json_decode($payload, true);

// 3️⃣ PhonePe Signature verify
$receivedSignature = $headers['X-VERIFY'] ?? '';
$secretKey = "YOUR_PHONEPE_SALT_KEY";

$generatedSignature = hash("sha256", $payload . $secretKey);

if ($receivedSignature !== $generatedSignature) {
    http_response_code(401);
    exit("Invalid signature");
}

// 4️⃣ Extract payment data
$merchantTransactionId = $data['data']['merchantTransactionId'] ?? null;
$status = $data['code'] ?? null; // PAYMENT_SUCCESS / PAYMENT_ERROR

// 5️⃣ Payment success check
if ($status === "PAYMENT_SUCCESS") {

    // ✅ Update database
    // Example:
    // update orders set status = 'paid' where txn_id = $merchantTransactionId;

    http_response_code(200);
    echo "Payment success processed";
} else {
    // ❌ Failed or pending
    http_response_code(200);
    echo "Payment not successful";
}
