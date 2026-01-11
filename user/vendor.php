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
		$qry = "SELECT id, name, store_name, email, image, status, reason
        FROM vendor 
        WHERE (status = 0 OR status = 1 OR status = 2) 
        AND user_id = $user_id";
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
					<li class="breadcrumb-item active" aria-current="page">All Business</li>
				</ol>
			</div>
			<!-- start: page body area -->
			<div class="px-xl-5 px-lg-4 px-3 py-3 page-body">
				<div class="px-xl-5 px-lg-4 px-3 py-3 page-body">
					<div class="row g-3">
						<div class="col-sm-12">
							<div class="d-flex align-items-center justify-content-between flex-wrap">
								<h3 class="fw-bold mb-0">Business List</h3>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body" style="overflow: scroll;">
									<table class="table dataTable align-middle table-hover table-body" style="width: 100%;">
										<thead>
											<tr>
												<th>Id</th>
												<th>Owner Name</th>
												<th>Business Name</th>
												<th>Email Address</th>
												<th>Status</th>
												<th>Reason</th>
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
														<td><?= $row['name'] ?></td>
														<td><?= $row['store_name'] ?></td>
														<td><?= $row['email'] ?></td>
														<td>
															<?php
															if ($row['status'] == 0) {
																echo "<span class='badge text-bg-warning'>Pending</span>";
															} else if ($row['status'] == 1) {
																echo "<span class='badge text-bg-danger'>Reject</span>";
															} else if ($row['status'] == 2) {
																echo "<span class='badge text-bg-success'>Approved</span>";
															}

															?>
														</td>
														<td>
															<?php echo $row['reason'];  ?>
														</td>
														<td>
															<a href="add-vendor.php?id=<?php echo $row['id']; ?>" class="btn">
																<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
																	<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
																	<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
																</svg>
															</a>
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