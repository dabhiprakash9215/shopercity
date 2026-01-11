<?php
    require_once "connection.php";
    // Get user ID from session
    $userID = $_SESSION['user_id'];

    // Get current password and new password from POST data
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    // Fetch current password from database for comparison
    $sql = "SELECT password FROM users WHERE id = $userID";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        if($newPassword == $confirm_password){
            $hashedPassword = $row['password'];
            if (password_verify($currentPassword, $hashedPassword)) {
                // Hash the new password
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                // Update password in the database
                $updateSql = "UPDATE users SET password = '$hashedNewPassword' WHERE id = $userID";
                if (mysqli_query($conn, $updateSql)) {
                    $_SESSION['success_msg']  = 'Password changed successfully.';
                    header("location:../account.php");
                } else {
                    $_SESSION['error_msg']  = 'Error updating password:'. mysqli_error($conn);
                    header("location:../account.php");                    
                }
            } else {
                $_SESSION['error_msg']  = 'Current password is incorrect.';
                header("location:../account.php");  
            }
        }
    } else {
        $_SESSION['error_msg']  = 'User not found.';
        header("location:../db/logout.php"); 
    }

?>