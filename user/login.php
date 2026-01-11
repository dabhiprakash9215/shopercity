<?php
    require_once('db/login_db.php');
	if (isset ($_SESSION)) {
		if (!empty ($_SESSION['user_id'])) {
			header("location:add-vendor.php");
		}
	}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>    
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="shoper city add new resort and start earning now">
	<meta name="keyword" content="shopercit add new resort">
	<link rel="icon" href="../assets/images/logo.png" type="image/x-icon"> 
    <title>Add New Resort</title>
	<link rel="icon" type="image/x-icon" href="../assets/images/logo.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../assets/images/logo.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../assets/images/logo.png">
	<link rel="apple-touch-icon" sizes="180x180" href="../assets/images/logo.png">

	<!--[ Template main css file ]-->
	<link rel="stylesheet" href="assets/css/style.min.css">

</head>

<body data-theme="theme-PurpleHeart" class="svgstroke-a auth bg-gradient">

	<!-- start: main grid layout -->
	<main class="container-fluid px-0">

		<!-- start: project logo -->
		<div class="px-md-5 px-4 auth-header" data-bs-theme="none">
			<a href="index-2.html" class="brand-icon text-decoration-none d-flex align-items-center" title="HotelAir Admin Template">
				<span style="border: 1px solid #b67e9d; padding: 1px 8px;">S</span>
				<span class="fw-bold ps-2 fs-5 text-gradient">Shopercity</span>
			</a>
		</div>

		<!-- start: page body area -->
		<div class="px-md-5 px-4 auth-body">
			<form method="POST" action=""> 
				<ul class="row g-3 list-unstyled li_animate">
					<li class="col-12">
						<label class="form-label text-accent text-center"><?php if(isset($_SESSION) && isset($_SESSION['error_msg'])) { echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); } ?></label>
					</li>
					<li class="col-12">
						<label class="form-label">Email</label>
						<input type="email" name="email" class="form-control form-control-lg" placeholder="email" value="">
					</li>
					<li class="col-12">
						<div class="form-label">
							<span class="d-flex justify-content-between align-items-center">
								Password
							</span>
						</div>
						<input type="password" name="password" class="form-control form-control-lg" placeholder="password" value="">
					</li>
					<li class="col-12">
						<div class="form-check fs-5">
							<input class="form-check-input" type="checkbox" value="" id="Rememberme">
							<label class="form-check-label fs-6" for="Rememberme">Remeber this Device</label>
						</div>
					</li>
					<li class="col-12 my-lg-4">
						<button type="submit" class="btn btn-lg w-100 btn-primary text-uppercase mb-2" title="sign in">SIGN IN</button>
					</li>
				</ul>
			</form>
		</div>

		<footer class="px-xl-5 px-4">
			<p class="mb-0 text-muted">© <?php echo date('Y'); ?> <a href="#" target="_blank" title="hotelair">Shopercity </a>, All Rights Reserved.</p>
		</footer>
		
	</main>

</body>
</html>
