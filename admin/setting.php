<?php

// include("../include/connection.php");
require_once('../db/connection.php');
if (isset($_POST['update_commission'])) {

    $level1 = (float) $_POST['level1'];
    $level2 = (float) $_POST['level2'];
    $level3 = (float) $_POST['level3'];
    $plan_price = (float) $_POST['plan_price'];

    if ($level1 < 0 || $level2 < 0 || $level3 < 0) {
        echo "<div class='alert alert-danger'>Commission cannot be negative</div>";
        exit;
    }

    if ($plan_price  < 0) {
        echo "<div class='alert alert-danger'>Plan price please proper enter</div>";
        exit;
    }

    $totalCommission = $level1 + $level2 + $level3;
    if ($totalCommission > 100) {
        echo "<div class='alert alert-danger'>
                Total commission cannot exceed 100%.
                Currently: $totalCommission%
              </div>";
        exit;
    }

    $adminCommission = 100 - $totalCommission;

    $stmt = $conn->prepare("
        UPDATE commission_settings 
        SET level1_commission = ?, 
            level2_commission = ?, 
            level3_commission = ?, 
            admin_commission = ?,
            plan_price =?
        WHERE id = 1
    ");
    $stmt->bind_param("ddddd", $level1, $level2, $level3, $adminCommission, $plan_price);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>
                Commission updated successfully <br>
                Admin Commission: $adminCommission%
              </div>";
    } else {
        echo "<div class='alert alert-danger'>Something went wrong</div>";
    }
}
$query = "SELECT * FROM commission_settings WHERE is_active = 1 LIMIT 1";
$result = mysqli_query($conn, $query);
$commission = mysqli_fetch_assoc($result);

// Default fallback (safety)
$level1 = $commission['level1_commission'] ?? 0;
$level2 = $commission['level2_commission'] ?? 0;
$level3 = $commission['level3_commission'] ?? 0;
$admin = $commission['admin_commission'] ?? 0;
$plan_prices     =   $commission['plan_price'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Brand | Shopercity</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
                            <h1>Setting</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Setting</li>
                            </ol>
                        </div>
                    </div>
                </div>
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
                                    <h3 class="card-title">Setting</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="POST" id="commissionForm">

                                    <div class="card-body">
                                        <label>1st Level Commission (%)</label>
                                        <input type="number" class="form-control commission-input"
                                            id="level1" name="level1" min="0" max="100" step="0.01" value="<?= $level1 ?>">
                                    </div>

                                    <div class="card-body">
                                        <label>2nd Level Commission (%)</label>
                                        <input type="number" class="form-control commission-input"
                                            id="level2" name="level2" min="0" max="100" step="0.01" value="<?= $level2 ?>">
                                    </div>

                                    <div class="card-body">
                                        <label>3rd Level Commission (%)</label>
                                        <input type="number" class="form-control commission-input"
                                            id="level3" name="level3" min="0" max="100" step="0.01" value="<?= $level3 ?>">
                                    </div>

                                    <div class="card-body bg-light">
                                        <label><strong>Admin Commission (%)</strong></label>
                                        <input type="text" class="form-control" id="adminCommission" readonly value="<?= $admin ?>">
                                    </div>
                                    <div class="card-body bg-light">
                                        <div class="text-danger mb-2">
                                            <input type="number" class="form-control plan_price" name="plan_price" value="<?= $plan_price ?>">
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div id="errorMsg" class="text-danger mb-2"></div>
                                        <button type="submit" name="update_commission" id="submitBtn" class="btn btn-primary" disabled>
                                            Update Commission
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const inputs = document.querySelectorAll(".commission-input");
            const adminInput = document.getElementById("adminCommission");
            const errorMsg = document.getElementById("errorMsg");
            const submitBtn = document.getElementById("submitBtn");

            function calculateCommission() {
                let total = 0;
                let hasError = false;
                let plan_price = $('#plan_price').val();

                inputs.forEach(input => {
                    let value = parseFloat(input.value);

                    if (isNaN(value)) value = 0;

                    // ❌ Negative check
                    if (value < 0) {
                        hasError = true;
                        errorMsg.innerText = "Commission cannot be negative.";
                        submitBtn.disabled = true;
                        adminInput.value = "";
                        return;
                    }

                    total += value;
                });

                // ❌ 100% limit check
                if (total > 100) {
                    errorMsg.innerText = `Total commission cannot exceed 100%. Currently: ${total}%`;
                    submitBtn.disabled = true;
                    adminInput.value = "";
                    return;
                }

                // ❌ All empty case
                if (total === 0) {
                    errorMsg.innerText = "At least one commission must be greater than 0.";
                    submitBtn.disabled = true;
                    adminInput.value = "";
                    return;
                }

                if (plan_price === 0) {
                    errorMsg.innerText = "At least one plan price must be greater than 0.";
                    submitBtn.disabled = false;
                    adminInput.value = "";
                    return;
                }

                // ✅ Valid
                const adminCommission = (100 - total).toFixed(2);

                adminInput.value = adminCommission + " %";
                errorMsg.innerText = "";
                submitBtn.disabled = false;
            }

            inputs.forEach(input => {
                input.addEventListener("input", calculateCommission);
            });
            $('.plan_price').on('change', function() {
                submitBtn.disabled = false;
            });

        });
    </script>

</body>

</html>