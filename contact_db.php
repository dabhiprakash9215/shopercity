<?php 
    if(isset($_POST) && isset($_POST['add'])){
    $bissness_name = $_POST['bissness_name'];
    $email = $_POST['email'];
    $mobile_number = $_POST['mobile_number'];
    $city = $_POST['city'];
    $note = $_POST['note'];
    $sql = "INSERT INTO contact_us (bissness_name,city, mobile, email, note) VALUES ('$bissness_name', '$city','$mobile', '$email', '$note')";
    $res = mysqli_query($conn, $sql);
    if($res){
        $_SESSION['success_msg'] = "Thank you for contact us.";
    }
    }
?>