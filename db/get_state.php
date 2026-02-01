<?php
require_once 'connection.php';

$result = $conn->query("SELECT * FROM state");

echo '<option value="">Select District</option>';
while ($row = $result->fetch_assoc()) {
    $selected = '';
    if (empty($_SESSION['state_id']) && $_SESSION['state_id'] == $row['state_code']) {
        $selected = "selected";
    }
    echo "<option value='{$row['state_code']}' $selected>{$row['name']}</option>";
}
