<?php
require_once "connection.php";
if(isset($_POST['register'])){
    // print_r($_POST);
    // die;
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    // Get form data
    $firstName = $_POST['register-first-name'];
    $lastName = $_POST['register-last-name'];
    $mobile = $_POST['register-mobile-number'];
    $email = $_POST['register-email'];
    $password = $_POST['register-password'];
    $district = $_POST['district'];
    $createAt = date("Y-m-d H:i:s");
    $newPass =  password_hash($password, PASSWORD_DEFAULT);
    $sel_admin_qry  = "select * from users where email='$email'";
    $sel_admin      = mysqli_query($conn,$sel_admin_qry);
    $rows           = mysqli_num_rows($sel_admin);
	$referral_id    = $_POST['register-referral'];
	$user_referral_id = time();
	
	if($rows){
		$_SESSION['error_msg'] = "alrady email is register.";
		header("Location: ../login.php");
		exit(); // Ensure no further output is sent  
	}else{
		$sql = "SELECT * FROM users WHERE referral_id = $referral_id";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		// Output data of each row
			while($row = $result->fetch_assoc()) {
				$upline_id = $row['id'];
					$sql = "INSERT INTO users (first_name, last_name, mobile, email, password, referral_id, upline_id, created_at, district) VALUES ('$firstName', '$lastName','$mobile', '$email', '$newPass','$user_referral_id','$upline_id', '$createAt', '$district')";
					$res = mysqli_query($conn,$sql);
					if ($res){
                        $user_id = mysqli_insert_id($conn);
                        $sel_admin_qry = "select * from users where id='$user_id' and status='0'";
                        $sel_admin = mysqli_query($conn, $sel_admin_qry);
                        $fetch_row = mysqli_fetch_assoc($sel_admin);
                        $_SESSION['user_id'] = $fetch_row['id'];
                        $_SESSION['first_name'] = $fetch_row['first_name'];
                        $_SESSION['last_name'] = $fetch_row['last_name'];
                        $_SESSION['email'] = $fetch_row['email'];
                        $_SESSION['mobile'] = $fetch_row['mobile'];
                        $_SESSION['address'] = $fetch_row['address'] != null ? $fetch_row['address'] : "";
                        $_SESSION['city'] = $fetch_row['city'] != null ? $fetch_row['city'] : "";
                        $_SESSION['state'] = $fetch_row['state'] != null ? $fetch_row['state'] : "";
                        $_SESSION['district'] = $fetch_row['district'] != null ? $fetch_row['district'] : "";
                        $_SESSION['country'] = $fetch_row['country'] != null ? $fetch_row['country'] : "";
                        $_SESSION['old_img'] = $fetch_row['image'] != null ? $fetch_row['image'] : "";
                        $_SESSION['pincode'] = $fetch_row['pincode'] != null ? $fetch_row['pincode'] : "";
                        $_SESSION['referral_id'] = $fetch_row['referral_id'] != null ? $fetch_row['referral_id'] : "";
                        $_SESSION['is_active'] = $fetch_row['is_active'] != null ? $fetch_row['is_active'] : "";
						$_SESSION['success_msg'] = "register successfully.";
						header("Location: ../login.php");
						exit(); // Ensure no further output is sent  
					} else {
						$_SESSION['error_msg'] = "register faild.";
						header("location: ../login.php");
						exit(); // Ensure no further output is sent  
				}
			}
		} else {
			$_SESSION['error_msg'] = "please enter valid refferal code.";
			header("Location: ../login.php");
			exit(); // Ensure no further output is sent  
		}
	}
    // Close database connection
    $conn->close();
}
if(isset($_POST['update'])){
    $address = $_POST['address'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $country = $_POST['country'];
    $mobile = $_POST['mobile_number'];    
    $pincode = $_POST['pincode'];    
    $mobile = $_POST['mobile_number'];    
    $user_id = $_SESSION['user_id'];
    $filename = basename($_FILES["profile_image"]["name"]);
    $old_file = $_POST["old_img"];
    // Generate a unique filename to prevent overwriting existing files
    $newFilename = time() . '_' . $filename;
    $uploadDir = "../assets/images/profile_img/"; 
    $uploadPath = $uploadDir . $newFilename;
    
    if(!empty($filename)){
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $uploadPath)) {
            // Remove old image file
            if (!empty($old_file)) {
                $oldImagePath = $uploadDir . $old_file;
                unlink($oldImagePath);
            }
        } else {
            $_SESSION['error_msg'] = "File Not Uploaded.";
            header("Location: ../account.php");
            exit(); // Ensure no further output is sent  
        }
    }else{
        $newFilename = $old_file;
    }
    $qry = "UPDATE users SET address = '$address',city = '$city', state = '$state', district = '$district',country = '$country',pincode = '$pincode', mobile = '$mobile',image = '$newFilename',last_name='$last_name',first_name='$first_name' WHERE id = '$user_id'";
    // "update hotel_master set name='$name',address='$address',city='$city',description='$description' where id='$id'";
    $res2 = mysqli_query($conn,$qry);
    if ($res2) {
        $_SESSION['success_msg'] = "Data Update Successfully";
        header("Location: ../account.php");
        $_SESSION['address'] = $_POST['address'];
        $_SESSION['last_name'] = $_POST['last_name'];
        $_SESSION['first_name'] = $_POST['first_name'];
        $_SESSION['district'] = $_POST['district'];
        $_SESSION['city'] = $_POST['city'];
        $_SESSION['state'] = $_POST['state'];
        $_SESSION['country'] = $_POST['country'];
        $_SESSION['pincode'] = $_POST['pincode'];
        $_SESSION['old_img'] = $newFilename;
        exit(); // Ensure no further output is sent  
    } else {
        $_SESSION['error_msg'] = "Data Update Faild";
        header("Location: ../account.php");
        exit(); // Ensure no further output is sent  
    }
}
?>