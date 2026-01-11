<?php
require_once 'connection.php';

if (isset($_POST['district_id'])) {
    $district_id = $_POST['district_id'];
    $result = $conn->query("SELECT * FROM city WHERE district_id = '$district_id'");
} else {
    $result = $conn->query("SELECT * FROM city");
}

echo '<option value="">Select City</option>';
while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row['id']}'>{$row['name']}</option>";
}
