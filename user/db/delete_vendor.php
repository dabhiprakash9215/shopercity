<?php
require_once('../../db/connection.php');
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Delete Photo
    $qry = "select image, banner from vendor where id=$id";
    $res = mysqli_query($conn, $qry);
    $row = mysqli_fetch_assoc($res);
    unlink('../vendor/profile/' . $row['image']);
    unlink('../vendor/banner/' . $row['banner']);
    $qry = "delete from vendor where id=$id";

    if (mysqli_query($conn, $qry)) {
        header("location: ../vendor.php");
        exit;
    } else {
        header("location: ../vendor.php");
        exit;
    }
} else {
    header("location: ../vendor.php");
    exit;
}
