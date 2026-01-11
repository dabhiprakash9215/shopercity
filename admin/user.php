<?php
require_once "../db/connection.php";
if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];
    $qry = "UPDATE users SET status ='$status'  WHERE id = '$user_id'";
    $res = mysqli_query($conn, $qry);
}
if (isset($_GET['delete_id'])) {
    $user_id = $_GET['delete_id'];
    $qry = "DELETE FROM users  WHERE id = '$user_id'";
    $res = mysqli_query($conn, $qry);
    $qry_2 = "DELETE FROM vendor  WHERE user_id = '$user_id'";
    $res_2 = mysqli_query($conn, $qry_2);
}
if (isset($_GET['type'])) {
    $type = 1;
} else {
    $type   =   0;
}

if (isset($_POST['vendor']) && $_POST['vendor'] == 'Search') {
    $vendor_id = isset($_POST['vendor_id']) ? (int)$_POST['vendor_id'] : 0;
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
    $plan_id = isset($_POST['plan_id']) ? (int)$_POST['plan_id'] : 0;

    $query = "SELECT users.id, users.first_name, users.last_name, users.email, users.mobile, 
                     users.address, users.city, users.state, users.country, 
                     vendor.store_name, vendor.name, vendor.id AS vendor_id, category.name AS category_name, 
                     users.created_at, users.status, vendor.starting_date, vendor.end_date
              FROM users
              LEFT JOIN vendor ON users.id = vendor.user_id
              LEFT JOIN category ON vendor.category_id = category.id
              WHERE users.is_active = $type";

    $conditions = [];

    if ($vendor_id > 0) {
        $conditions[] = "vendor.id = $vendor_id";
    }
    if ($category_id > 0) {
        $conditions[] = "vendor.category_id = $category_id";
    }
    if ($plan_id > 0) {
        $conditions[] = "vendor.plan_id = $plan_id";
    }

    if (!empty($conditions)) {
        $query .= " AND " . implode(" AND ", $conditions);
    }

    // Execute the query
    $class = $conn->query($query);

    // if ($class) {
    //     while ($row = $class->fetch_assoc()) {
    //         print_r($row);
    //     }
    // } else {
    //     echo "Query failed: " . $conn->error;
    // }

    // die;
} else {
    $vendor_id = '';
    $category_id = '';
    $class = $conn->query("SELECT users.id, users.first_name, users.last_name, users.email, users.mobile, 
                users.address, users.city, users.state, users.country, 
                vendor.store_name, vendor.name, vendor.id as vendor_id, category.name AS category_name, 
                users.created_at, users.status, vendor.starting_date, vendor.end_date
            FROM users
            LEFT JOIN vendor ON users.id = vendor.user_id
            LEFT JOIN category ON vendor.category_id = category.id
            WHERE users.is_active = $type");
    // You can use PDO::FETCH_ASSOC for an associative array

}
$i = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Projects</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("nav.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("sidebar.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>User</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">User</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
                <div class="clearfix"></div>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <select id="inputStatus" name="vendor_id" class="form-control custom-select">
                                <option value="0"> Select Store</option>
                                <?php
                                $center = $conn->query("SELECT * FROM vendor");
                                while ($center_fetch = $center->fetch()) { ?>
                                    <option <?php if ($vendor_id == $center_fetch['id']) {
                                                echo 'selected="selected"';
                                            } ?> value="<?php echo $center_fetch['id']; ?>"><?php echo $center_fetch['store_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select id="inputStatus" name="category_id" class="form-control custom-select">
                                <option value="0"> Select Category</option>
                                <?php
                                $vendor_id = 0;
                                $center = $conn->query("SELECT * FROM category");
                                while ($center_fetch = $center->fetch()) { ?>
                                    <option <?php if ($category_id == $center_fetch['id']) {
                                                echo 'selected="selected"';
                                            } ?> value="<?php echo $center_fetch['id']; ?>"><?php echo $center_fetch['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <button type="submit" class="btn btn-primary" name="vendor" value="Search">Search</button>
                        </div>
                        </from>
                    </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th style="width: 1%">
                                    #
                                </th>
                                <th style="width: 20%">
                                    Name
                                </th>
                                <th style="width: 5%">
                                    Email
                                </th>
                                <th style="width: 20%">
                                    Mobile
                                </th>
                                <th style="width: 20%">
                                    Address
                                </th>
                                <th style="width: 100px">
                                    Vendor
                                </th>
                                <th style="width: 20%">
                                    Vendor detail
                                </th>
                                <th style="width: 20%">
                                    Category Name
                                </th>
                                <th style="width: 20%">
                                    vendor date
                                <th style="width: 20%">
                                    User created date
                                </th>
                                </th>
                                <th style="width: 20%">
                                    Edit Vendor
                                </th>
                                <?php
                                if (isset($_SESSION['type']) && $_SESSION['type'] == 0) {
                                ?>
                                    <th style="width: 20%">
                                        user status
                                    </th>
                                <?php
                                }
                                ?>

                                <th style="width: 20%">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $class->fetch_assoc()) {
                                $i++;
                            ?>
                                <tr>
                                    <td>
                                        <?= $i; ?>
                                    </td>
                                    <td>
                                        <?= $row['first_name'] . ' ' . $row['last_name']; ?>
                                    </td>
                                    <td>
                                        <?= $row['email']; ?>
                                    </td>
                                    <td>
                                        <?= $row['mobile']; ?>
                                    </td>
                                    <td>
                                        <?= $row['address'] . ' ' . $row['city'] . ' ' . $row['state'] . ' ' . $row['country']; ?>
                                    </td>
                                    <td>
                                        <span class="bg-<?php if (!empty($row['vendor_id'])) {
                                                            echo "success";
                                                        } else {
                                                            echo "danger";
                                                        } ?> border px-3 py-1 text-center" style="border-radius: 50px;"> <?php if (!empty($row['vendor_id'])) {
                                                                                                                                echo "Yes";
                                                                                                                            } else {
                                                                                                                                echo "No";
                                                                                                                            } ?> </span>
                                    </td>
                                    <td>
                                        <?php if (!empty($row['vendor_id'])) {
                                            $row['store_name'] . ' (' . $row['name'] . ')';
                                        } ?>
                                    </td>
                                    <td>
                                        <?= $row['category_name']; ?>
                                    </td>
                                    <td>
                                        <small>
                                            <b>Open:</b> <?php echo $row['starting_date']; ?>
                                            <b>Expire:</b> <?php echo $row['end_date']; ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?= $row['created_at']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (!empty($row['vendor_id'])) {
                                        ?>
                                            <a href="add-vendor.php?id=<?= $row['vendor_id']; ?>" class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                </svg>
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <?php
                                    if (isset($_SESSION['type']) && $_SESSION['type'] == 0) {
                                    ?>
                                        <td>
                                            <form action="user.php" method="post">
                                                <select name="status" class="form-control">
                                                    <option value="0" <?php if ($row['status'] == 0) {
                                                                            echo "selected";
                                                                        } ?>>Active
                                                    </option>
                                                    <option value="1" <?php if ($row['status'] == 1) {
                                                                            echo "selected";
                                                                        } ?>>
                                                        Deactive</option>
                                                </select>
                                                <input type="hidden" name="user_id" value="<?= $row['id']; ?>">
                                                <input type="submit" class="btn btn-primary mt-2" name="submit" value="Update">
                                            </form>

                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-danger delete-user" data-id="<?= $row['id'] ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                                </svg>
                                            </a>
                                        </td>
                                    <?php
                                    } else {
                                    ?>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-danger delete-user" data-id="<?= $row['id'] ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                </svg>
                                            </a>
                                        </td>
                                    <?php
                                    }
                                    ?>

                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
        </div>
        <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require_once('footer.php'); ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- sweet alert  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete-user').click(function(e) {
                e.preventDefault();
                let deleteId = $(this).data("id");
                let deleteUrl = "?delete_id=" + deleteId;

                Swal.fire({
                    title: "Are you sure you want to delete this record?",
                    text: "This action will permanently delete the record!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // AJAX request to delete
                        $.ajax({
                            url: deleteUrl, // Your backend URL
                            type: "GET", // Sending GET request
                            success: function(response) {
                                Swal.fire("Deleted!", "The record has been permanently deleted.", "success")
                                    .then(() => {
                                        location.reload();
                                    });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire("Error!", "Something went wrong. Try again!", "error");
                            }
                        });
                    }
                });
            });

        });
    </script>
</body>

</html>