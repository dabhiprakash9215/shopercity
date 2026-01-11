<?php
require_once 'connection.php';

if (isset($_POST['state_id'])) {
    $state_id = $_POST['state_id'];
    $result = $conn->query("SELECT * FROM districts WHERE state_code='$state_id'");
} else {
    $result = $conn->query("SELECT * FROM districts");
}

echo '<option value="">Select District</option>';
while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row['id']}'>{$row['district_name']}</option>";
}
