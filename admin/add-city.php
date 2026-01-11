<?php include("../include/connection.php");
if(isset($_GET['id']) && $_GET['id'] != '')
{
	$button="Update";
	$name=$user->getField($_GET['id'],'city','name'); 
	$country= $user->getField($_GET['id'],'city','country_id'); 
	$state= $user->getField($_GET['id'],'city','state_id');
}
else
{
	$button="Save";
	$name='';
	$country= ''; 
	$state= '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add city | Shopercity</title>

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
            <h1>city</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">city</li>
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
                <h3 class="card-title">city</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="query.php">
                <div class="card-body">
					<div class="form-group">
						<label for="inputStatus">Country</label>
						<select id="inputStatus" name="country_id" class="form-control custom-select">
						  <option value="0"> Select Country</option>
						  <?php 
							$center = $conn->query("SELECT * FROM country");
							while($center_fetch=$center->fetch())
							{ ?>
								<option <?php if($country==$center_fetch['id']) { echo 'selected="selected"';}?> value="<?php echo $center_fetch['id'];?>"><?php echo $center_fetch['name'];?></option>
							<?php } ?>
						</select>
					  </div>
					  <div class="form-group">
						<label for="inputStatus">State</label>
						<select id="inputStatus" name="state_id" class="form-control custom-select">
						  <option value="0"> Select State</option>
						  <?php 
							$center = $conn->query("SELECT * FROM state");
							while($center_fetch=$center->fetch())
							{ ?>
								<option <?php if($state==$center_fetch['id']) { echo 'selected="selected"';}?> value="<?php echo $center_fetch['id'];?>"><?php echo $center_fetch['name'];?></option>
							<?php } ?>
						</select>
					  </div>
					<div class="form-group">
						<label for="exampleInputEmail1">Enter city name</label>
						<input type="text" class="form-control" name="name" placeholder="Enter city Name" value="<?php echo $name; ?>">
					  </div>
                  
				</div>
                <!-- /.card-body -->
				<input type="hidden" name="id" value="<?php if($_GET){ echo $_GET['id']; } ?>" >
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="city" value="<?php echo $button; ?>"><?php echo $button; ?></button>
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
