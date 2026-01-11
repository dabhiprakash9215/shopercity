<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Vendor</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Shopercity add user restoraant">
    <meta name="keyword" content="Add new user resort">
    <!--[ Favicon]-->
    <link rel="icon" type="image/x-icon" href="../assets/images/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/logo.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/logo.png">
    <!--[ Template main css file ]-->
    <link rel="stylesheet" href="assets/css/summernote.min.css">
    <link rel="stylesheet" href="assets/css/style.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        @font-face {
            font-family: "summernote";
            src: url("assets/fonts/summernoted41d.eot?#iefix") format("embedded-opentype"),
                url("assets/fonts/summernote.woff2") format("woff2"),
                url("assets/fonts/summernote.woff") format("woff"),
                url("assets/fonts/summernote.ttf") format("truetype");
        }

        .error {
            color: red;
        }

        .note-editable {
            min-height: 60vh;
        }
    </style>

</head>

<body data-theme="theme-PurpleHeart" class="svgstroke-a bg-gradient">
    <main class="container-fluid px-0">
        <!-- start: page menu link -->
        <?php
        require_once('include/nav.php');
        require_once('db/add_vendor_db.php');
        $user_id    =   $_SESSION['user_id'];
        $qry = "SELECT * FROM notifications WHERE  user_id = $user_id";
        $res = mysqli_query($conn, $qry);
        // if (mysqli_num_rows($res) === 0) {
        // 	header("Location:add-vendor.php");
        // }
        ?>
        <div class="content">
            <!-- start: page header -->
            <?php require_once "include/header.php"; ?>
            <!-- start: page header area -->
            <div class="px-xl-5 px-lg-4 px-3 py-2 page-header">
                <ol class="breadcrumb mb-0 bg-transparent">
                    <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Notification</li>
                </ol>
            </div>
            <!-- start: page body area -->
            <div class="px-xl-5 px-lg-4 px-3 py-3 page-body">
                <div class="px-xl-5 px-lg-4 px-3 py-3 page-body">
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                <h3 class="fw-bold mb-0">Notification List</h3>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body" style="overflow: scroll;">
                                    <table class="table dataTable align-middle table-hover table-body" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Title</th>
                                                <th>Total User</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count  =   0;
                                            if (mysqli_num_rows($res) > 0) {
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    $count  =   $count + 1;
                                            ?>
                                                    <tr>
                                                        <td><?= $count ?></td>
                                                        <td><?= $row['notification_title'] ?></td>
                                                        <td><?= $row['total_user'] ?></td>
                                                        <td><?= $row['price'] ?></td>
                                                        <td>
                                                            <?php
                                                            if ($row['status'] == 0) {
                                                                echo "<span class='badge text-bg-warning'>Pending</span>";
                                                            } else if ($row['status'] == 1) {
                                                                echo "<span class='badge text-bg-info'>In Progress</span>";
                                                            } else if ($row['status'] == 2) {
                                                                echo "<span class='badge text-bg-success'>Complete</span>";
                                                            }

                                                            ?>
                                                        </td>
                                                        <td>
                                                            <form action="pay.php" method="get">

                                                                <button type="submit">Pay Now</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td rowspan="2" colspan="2" align="center">No Business Add</td>
                                                    <!-- <td></td> -->
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!--[ hotelair template vender js ]-->
    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="assets/bundles/summernote.bundle.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    <!-- Include jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <!-- Template page js -->
    <script src="assets/js/main.js"></script>
    <script>
        $(document).ready(function() {
            <?php
            if (isset($_SESSION['msg_success'])) {
            ?>
                toastr.success('<?php echo $_SESSION['msg_success']; ?>', 'Success');
            <?php
                unset($_SESSION['msg_success']);
            }
            ?>
            <?php
            if (isset($_SESSION['msg_error'])) {
            ?>
                toastr.error('<?php echo $_SESSION['msg_error']; ?>', 'Error');
            <?php
                unset($_SESSION['msg_error']);
            }
            ?>
        });
    </script>
</body>

</html>