<?php
session_start();
require_once "../db/connection.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
    exit;
}
$user_id = $_SESSION['user_id'];

$vendor_id = (int)$user_id;
$discount_id = (int)$_POST['discount_id'];
$type = $_POST['notification_type'];
$title = trim($_POST['title']);
$start_date = $_POST['start_date'];
$locations = $_POST['notification_location'] ?? [];
$total_user = (int)$_POST['total_user'];
$price = (int)$_POST['total_user'] * 0.5;

if (
    $discount_id <= 0 ||
    empty($type) ||
    empty($title) ||
    empty($start_date) ||
    empty($locations)
) {
    echo json_encode(['status' => false, 'message' => 'Invalid input']);
    exit;
}

$location_json = json_encode($locations);

$stmt = $conn->prepare("
	INSERT INTO notifications 
	(user_id, vendor_id, notification_title, notification_type, discount_id, notification_location, start_date, total_user, price)
	VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "iississii",
    $user_id,
    $vendor_id,
    $title,
    $type,
    $discount_id,
    $location_json,
    $start_date,
    $total_user,
    $price
);

if ($stmt->execute()) {
    echo json_encode(['status' => true, 'message' => 'Notification created successfully']);
} else {
    echo json_encode(['status' => false, 'message' => 'DB error']);
}
