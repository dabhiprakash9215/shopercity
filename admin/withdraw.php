<?php
require_once "../db/connection.php";
if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];
    $qry = "UPDATE users SET status ='$status'  WHERE id = '$user_id'";
    $res = mysqli_query($conn, $qry);
}
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
                                <li class="breadcrumb-item active">withdrawal</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
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
                                    UPI Id
                                </th>
                                <th style="width: 20%">
                                    Amount
                                </th>
                                <th style="width: 20%">
                                    Message
                                </th>
                                <th style="width: 20%">
                                    Payment status
                                </th>
                                <th style="width: 20%">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $center = $conn->query("SELECT withdrawals.*, users.first_name,  users.last_name
                                                    FROM withdrawals 
                                                    JOIN users ON withdrawals.user_id = users.id");
                            while ($row = $center->fetch()) {
                                $i++;
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['first_name'] . ' ' . $row['last_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['upi']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['amount']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['message']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row['status'] == 0) {
                                            echo "Processing";
                                        } elseif ($row['status'] == 1) {
                                            echo "Succeeded";
                                        } else {
                                            echo "Rejected";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-sm"
                                            href="edit-withdraw.php?id=<?php echo $row['id']; ?>">
                                            <i class=" fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </a>
                                    </td>
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

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
</body>

</html>