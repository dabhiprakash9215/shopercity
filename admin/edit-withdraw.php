<?php include("../db/connection.php");
if (isset($_GET['id']) && $_GET['id'] != '') {
    $button = "Update";
    // $qry = "select * from withdrawals where  id = " . $_GET['id'];
    // $res = mysqli_query($conn, $qry);
    $id = $_GET['id'];
    $center = "SELECT * FROM withdrawals WHERE id = $id";
    $res = mysqli_query($conn, $center);
    $row = mysqli_fetch_array($res);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    if ($state == 2) {
        $message = $_POST['message'];
        $upd_qry = "update withdrawals set status='$status', message='$message' where id='$id'";
        // if(){

        // }
        $res = mysqli_query($conn, $upd_qry);
        if ($res) {
            header("Location:withdraw.php");
        }
    } else {
        $_SESSION['ins_msg'] = 'Payment is alrady ';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add subscription | Shopercity</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
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
                            <h1>Withdraw</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Withdraw</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Withdraw</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="post" action="">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Enter Message</label>
                                            <input type="text" class="form-control" name="message"
                                                placeholder="Enter Message" value="<?php echo $row['message']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Validity Month</label>
                                            <select name="status" class="form-control custom-select" id="">
                                                <option value="0" <?php if ($row['status'] == 0) {
                                                                        echo "selected";
                                                                    } ?>>
                                                    Processing</option>
                                                <option value="1" <?php if ($row['status'] == 1) {
                                                                        echo "selected";
                                                                    } ?>>
                                                    Success</option>
                                                <option value="2" <?php if ($row['status'] == 2) {
                                                                        echo "selected";
                                                                    } ?>>
                                                    Reject</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <input type="hidden" name="id" value="<?php if ($_GET) {
                                                                                echo $_GET['id'];
                                                                            } ?>">
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary" name="update"
                                            value="<?php echo $button; ?>">
                                            <?php echo $button; ?>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                        <!-- right column -->

                        <!--/.col (right) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php require_once "footer.php"; ?>

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
    <!-- bs-custom-file-input -->
    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>