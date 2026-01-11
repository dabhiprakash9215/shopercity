<?php
require_once "connection.php";
if (isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $query = "SELECT * FROM `vendor` WHERE `name` LIKE '%$search_term%' ORDER BY `name` ASC";

    // Execute the query
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        // Loop through the results and display them
        while ($row = mysqli_fetch_assoc($result)) {
            // Output the data, you can format this as you wish
            echo "Column 1: " . $row['name'] . "<br>";
            echo "Column 2: " . $row['store_name'] . "<br>";
            // Add more columns as needed
            echo "<br>";
        }
    } else {
		$qry1 = "SELECT * FROM `city` WHERE `name` LIKE '%$search_term%' ORDER BY `name` ASC";
    	// Execute the query
    	$res1 = mysqli_query($conn, $qry1);
		
		if (mysqli_num_rows($res1) > 0) {
			while ($row = mysqli_fetch_assoc($res1)) {
				echo $row['name'];
			}
		}else{
			$qry2 = "SELECT * FROM `state` WHERE `name` LIKE '%$search_term%'";
    		// Execute the query
    		$res2 = mysqli_query($conn, $qry2);
			if (mysqli_num_rows($res2) > 0) {
				while ($row = mysqli_fetch_assoc($res2)) {
					echo $row['name'];
				}
			}else{
				echo "Record Not Found";
			}
		}
    }
}
?>