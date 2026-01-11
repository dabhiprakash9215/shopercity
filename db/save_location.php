<?php
header('Content-Type: application/json');
require_once 'connection.php';

function response($status, $message)
{
    echo json_encode([
        'status' => $status,
        'message' => $message
    ]);
    exit;
}

/* ================= VALIDATION ================= */

$token = trim($_POST['notification_token'] ?? '');
$state_id = $_POST['state_id'] ?? null;
$district_id = intval($_POST['district_id'] ?? 0);
$city_id = intval($_POST['city_id'] ?? 0);

if (!$token) {
    response(false, 'Notification token is required');
}

if (!$state_id || !$district_id || !$city_id) {
    response(false, 'Invalid location selected');
}

/* ================= DUPLICATE CHECK ================= */

$check = $conn->prepare(
    "SELECT id FROM user_locations WHERE notification_token = ?"
);
$check->bind_param("s", $token);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    response(false, 'Location already saved for this device');
}

/* ================= INSERT ================= */

$ip = $_SERVER['REMOTE_ADDR'] ?? null;
$ua = $_SERVER['HTTP_USER_AGENT'] ?? null;

$stmt = $conn->prepare("
    INSERT INTO user_locations
    (notification_token, state_id, district_id, city_id, ip_address, user_agent)
    VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "siiiss",
    $token,
    $state_id,
    $district_id,
    $city_id,
    $ip,
    $ua
);

if ($stmt->execute()) {
    response(true, 'Location saved successfully');
}

response(false, 'Failed to save data');
