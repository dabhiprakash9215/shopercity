<?php
if (!defined('DIR')) {
    // Check if the environment is local or live
    if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
        // Local environment
        define('DIR', 'http://localhost/project/core_php/shopercity/'); // Use your local path
    } else {
        // Production environment
        define('DIR', 'https://shopercity.com/');
    }
}

if (!defined('URL')) {
    // Check if the environment is local or live
    if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
        // Local environment
        define('URL', 'http://localhost/project/core_php/shopercity/');
    } else {
        // Production environment
        define('URL', 'https://shopercity.com/');
    }
}

if (isset($_POST['add'])) {
    // print_r($_POST);
    // die;
    // Get POST data and sanitize inputs to avoid SQL injection
    // $category_id = mysqli_real_escape_string($conn, $_POST['category']);
    $name = mysqli_real_escape_string($conn, $_POST['v_name']);
    $store_name = mysqli_real_escape_string($conn, $_POST['store_name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $city_id = mysqli_real_escape_string($conn, $_POST['city']);
    $state_id = mysqli_real_escape_string($conn, $_POST['state']);
    $zipcode = mysqli_real_escape_string($conn, $_POST['zipcode']);
    $desc_1 = mysqli_real_escape_string($conn, $_POST['desc_1']);
    $desc_2 = mysqli_real_escape_string($conn, $_POST['desc_2']); // assuming desc_2 is in POST data
    $discount_id = mysqli_real_escape_string($conn, $_POST['discount']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $delivery_status = mysqli_real_escape_string($conn, $_POST['delivery'] ? $_POST['delivery'] : 0);
    $created_by = date("Y-m-d"); // You can replace with    user or other context
    $modified_by = date("Y-m-d");
    $image = '';  // Placeholder if you don't upload an image
    $banner = ''; // Placeholder if you don't upload a banner
    // $starting_date = mysqli_real_escape_string($conn, $_POST['s_date']);
    // $end_date = mysqli_real_escape_string($conn, $_POST['e_date']);
    $fb_link = mysqli_real_escape_string($conn, $_POST['fb_link']);
    $insta_link = mysqli_real_escape_string($conn, $_POST['insta_link']);
    $website_link = mysqli_real_escape_string($conn, $_POST['website_link']);
    $yt_link = mysqli_real_escape_string($conn, $_POST['yt_link']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $status = 0; // You can modify the status value based on your requirement

    // File upload logic for banner
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $banner_new_name    =   "";
    $image_new_name     =   "";
    if (isset($_FILES['banner']) && !empty($_FILES['banner']['name'])) {
        $banner = $_FILES['banner'];
        $banner_name = $banner['name'];
        $banner_tmp_name = $banner['tmp_name'];
        $banner_ext = pathinfo($banner_name, PATHINFO_EXTENSION);
        $banner_new_name = uniqid('', true) . "." . $banner_ext;
        $banner_upload_path = "../vendor/banner/" . $banner_new_name;
        if (!move_uploaded_file($banner_tmp_name, $banner_upload_path)) {
            $_SESSION['msg_error']  =   "Error uploading banner.";
        } else {
            if (isset($_POST['old_banner']) && !empty($_POST['old_banner'])) {
                unlink('../vendor/banner/' . $_POST['old_banner']);
            }
        }
    } else {
        $banner_new_name    =   $_POST['old_banner'];
    }
    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $image_name = $image['name'];
        $image_tmp_name = $image['tmp_name'];
        $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_new_name = uniqid('', true) . "." . $image_ext;
        $image_upload_path = "../vendor/profile/" . $image_new_name;

        if (!move_uploaded_file($image_tmp_name, $image_upload_path)) {
            $_SESSION['msg_error']  =   "Error uploading image.";
        } else {
            if (isset($_POST['old_image']) && !empty($_POST['old_image'])) {
                unlink('../vendor/profile/' . $_POST['old_image']);
            }
        }
    } else {
        $image_new_name =   $_POST['old_image'];
    }

    $user_id = $_SESSION['user_id'];
    $check_query = "SELECT * FROM vendor WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $check_query);
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id     =   $_POST['id'];
        // Record exists, perform update
        $row = mysqli_fetch_assoc($result);

        // Perform the update with the new banner and image
        $update_query = "UPDATE vendor SET 
                        name='$name',
                        store_name='$store_name',
                        contact='$contact',
                        email='$email',
                        city_id='$city_id',
                        state_id='$state_id',
                        zipcode='$zipcode',
                        desc_1='$desc_1',
                        desc_2='$desc_2',
                        discount_id='$discount_id',
                        delivery_status='$delivery_status',
                        modified_by='$modified_by',
                        image='$image_new_name',
                        banner='$banner_new_name',
                        status='$status',
                        district='$district',
                        fb_link='$fb_link',
                        insta_link='$insta_link',
                        website_link='$website_link',
                        yt_link='$yt_link',
                        bio='$bio'
                    WHERE user_id='$user_id' AND id='$id'";

        // print_r($update_query);
        // die;
        if (mysqli_query($conn, $update_query)) {
            $_SESSION['msg_success']    =   "Record updated successfully!";
        } else {
            $_SESSION['msg_error']    =   "Something went wrong!";
        }
    } else {
        // Construct SQL query to insert data into the database
        $query = "INSERT INTO vendor (user_id,  name, store_name, contact, email, city_id, state_id, country_id, zipcode, desc_1, desc_2, discount_id, delivery_status, created_by, modified_by, image, banner, status,  district, insta_link, fb_link, website_link, yt_link, bio)
                        VALUES ('$user_id', '$name', '$store_name', '$contact', '$email', '$city_id', '$state_id', '$country_id', '$zipcode', '$desc_1', '$desc_2', '$discount_id', '$delivery_status', '$created_by', '$modified_by', '$image_new_name', '$banner_new_name', '$status', '$district', '$insta_link', '$fb_link', '$website_link', '$yt_link', '$bio')";

        // Execute query
        if (mysqli_query($conn, $query)) {
            $_SESSION['msg_success']    =   "Data inserted successfully!";
        } else {
            $_SESSION['msg_error']    =   "Something went wrong!";
        }
    }
    header("Location:vendor.php");
}



$subscription_qry   =   "select * from subscription";
$subscription       =   mysqli_query($conn, $subscription_qry);

$city_qry   =   "select * from city";
$city       =   mysqli_query($conn, $city_qry);


$state_qry  =   "select * from state";
$state      =   mysqli_query($conn, $state_qry);

$country_qry    =   "select * from country";
$country        =   mysqli_query($conn, $country_qry);

$category_qry   =   "select * from category";
$category       =   mysqli_query($conn, $category_qry);

$discount_qry   =   "select * from discount";
$discount       =   mysqli_query($conn, $discount_qry);
