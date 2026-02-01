<?php
ob_start();
if (!isset($_SESSION)) {
    session_start();
}

// Define database connection parameters for local and live environments
$hostname = "localhost";
$username = "u740713800_user";
$password = "nCq53z~4";
$db = "u740713800_db";
// $username = "root";
// $password = "";
// $db = "shopercity";

$conn = mysqli_connect($hostname, $username, $password, $db);

if (!$conn == true) {
    echo "database not connected";
}
// // Determine if the environment is local or live
// if ($_SERVER['SERVER_ADDR'] == $local_hostname || $_SERVER['SERVER_NAME'] == 'localhost') {
//     // Local environment
//     $conn = mysqli_connect($local_hostname, "root", "", "shoppercity_live");
//     if (!$conn) {
//         echo "database not connected";
//     }
// } else {
//     // Live environment
//     $conn = mysqli_connect($local_hostname, $username, $password, $db);
//     if (!$conn) {
//         echo "database not connected";
//     }
// }
function encryptValue(string $value): string
{
    $key = hash('sha256', SECRET_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    $name   =   'shopercity_' . $value;
    $encrypted = openssl_encrypt($name, ENCRYPTION_METHOD, $key, 0, $iv);
    return base64_encode($encrypted);
}

function decryptValue(string $encryptedValue): string
{
    $key = hash('sha256', SECRET_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    $name = 'shopercity_' . $encryptedValue;
    $decrypted = openssl_decrypt(base64_decode($name), ENCRYPTION_METHOD, $key, 0, $iv);
    return $decrypted;
}
