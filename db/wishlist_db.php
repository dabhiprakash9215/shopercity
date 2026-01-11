<?php
// Include database connection
require_once "connection.php";
if (isset($_POST['action'])) {
    // CRUD operations based on action
    if(!empty($_SESSION['user_id'])){
        switch ($_POST['action']) {
            case 'add':
                $vendor_id = $_POST['vendor_id'];
                $user_id = $_SESSION['user_id'];
                $sql = "INSERT INTO wishlist (user_id, vendor_id) VALUES ('$user_id', '$vendor_id')";
                mysqli_query($conn, $sql);
                echo 'added wishlist';
                break;
            case 'delete':
                $id = $_POST['vendor_id'];
                $sql = "DELETE FROM wishlist WHERE vendor_id='$id'";
                mysqli_query($conn, $sql);
                echo 'remove wishlist';
                break;
            case 'get':
                $sql = "SELECT * FROM wishlist";
                $result = mysqli_query($conn, $sql);
                $vendors = mysqli_fetch_all($result, MYSQLI_ASSOC);
                echo json_encode($vendors);
                break;
        }
    }else{
        echo "Please Login After wishlish Add.";
        return;
    }
}
?>
