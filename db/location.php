<?php
session_start();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize input
    $state    = trim($_POST['state'] ?? '');
    $district = trim($_POST['district'] ?? '');
    $city     = trim($_POST['city'] ?? '');

    // Validation
    if ($state === '') {
        $errors[] = "State is required";
    }
    if ($district === '') {
        $errors[] = "District is required";
    }
    if ($city === '') {
        $errors[] = "City is required";
    }

    // If no errors, store in session
    if (empty($errors)) {
        $_SESSION['location'] = [
            'state_id'    => $state,
            'district_id' => $district,
            'city_id'     => $city,
        ];

        $_SESSION['success'] = "Location saved successfully";
    }
    header('Location:../index.php');
}
header('Location:../index.php');
