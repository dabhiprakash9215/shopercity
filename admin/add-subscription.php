<?php include("../include/connection.php");
if(isset($_GET['id']) && $_GET['id'] != '')
{
	$button="Update";
	$name=$user->getField($_GET['id'],'subscription','name'); 
	$month=$user->getField($_GET['id'],'subscription','month'); 
	$price=$user->getField($_GET['id'],'subscription','price'); 
}
else
{
	$button="Save";
	$name='';
	$month=''; 
	$price=''; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add subscription | Shopercity</title>

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
            <h1>subscription</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">subscription</li>
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
                <h3 class="card-title">subscription</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="query.php">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Enter Plan name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter Plan Name" value="<?php echo $name; ?>">
                  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">Validity Month</label>
                    <input type="text" class="form-control" name="month" placeholder="Enter Month" value="<?php echo $month; ?>">
                  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">Price</label>
                    <input type="text" class="form-control" name="price" placeholder="Enter Price" value="<?php echo $price; ?>">
                  </div>
				</div>
                <!-- /.card-body -->
				<input type="hidden" name="id" value="<?php if($_GET){ echo $_GET['id']; } ?>" >
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="subscription" value="<?php echo $button; ?>"><?php echo $button; ?></button>
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
$(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
