<?php
require_once 'connection.php';

$result = $conn->query("SELECT * FROM state");

echo '<option value="">Select District</option>';
while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row['state_code']}'>{$row['name']}</option>";
}
