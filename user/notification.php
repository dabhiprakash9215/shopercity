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
	<link rel="stylesheet" href="../css/select2.css">
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


		.range-wrapper {
			width: 420px;
			margin: 60px;

			.range-slider {
				-webkit-appearance: none;
				width: 100%;
				height: 6px;
				border-radius: 10px;
				background: linear-gradient(to right,
						#3fa9c6 0%,
						#3fa9c6 0%,
						#e5e7eb 0%,
						#e5e7eb 100%);
				outline: none;
			}

			.range-slider::-webkit-slider-thumb {
				-webkit-appearance: none;
				width: 22px;
				height: 22px;
				background: #ffffff;
				border: 3px solid #3fa9c6;
				border-radius: 50%;
				cursor: pointer;
			}

			.range-slider::-moz-range-thumb {
				width: 22px;
				height: 22px;
				background: #ffffff;
				border: 3px solid #3fa9c6;
				border-radius: 50%;
				cursor: pointer;
			}
		}

		.select2-selection__choice {
			background-color: #1b1a1e !important;
		}

		.select2-results__options {
			background-color: #1b1a1e !important;
		}

		.select2-selection.select2-selection--multiple {
			background-color: #1b1a1e !important;
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
		$qry = "SELECT id FROM vendor WHERE  `user_id` = $user_id";
		$res = mysqli_query($conn, $qry);
		if (mysqli_num_rows($res) == 10) {
			header("location:vendor.php");
		}
		if (isset($_GET['id'])) {
			$user_id        =   $_SESSION['user_id'];
			$id				=	$_GET['id'];
			$vendor_qry    	=   "select * from vendor where user_id=$user_id AND id =$id  AND status != 3";
			$vendor        	=   mysqli_query($conn, $vendor_qry);
			$vendor_row    	=   mysqli_fetch_assoc($vendor);
		} else {
			$vendor_row		=	[];
		}
		?>
		<div class="content">
			<!-- start: page header -->
			<?php require_once "include/header.php"; ?>
			<!-- start: page header area -->
			<div class="px-xl-5 px-lg-4 px-3 py-2 page-header">
				<ol class="breadcrumb mb-0 bg-transparent">
					<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">/ Notifications</li>
				</ol>
			</div>
			<!-- start: page body area -->
			<div class="px-xl-5 px-lg-4 px-3 py-3 page-body">
				<h3 class="fw-bold">Notifications</h3>
				<form id="notificationForm" method="post">
					<div class="card p-4">
						<div class="col-xl-12 col-lg-12 col-md-12">
							<label class="form-label">Your Store</label>
							<select name="store_id" required class="form-select form-control-lg">
								<option value="">Select Your Store</option>
								<?php
								$qry = "SELECT id, store_name FROM vendor WHERE (status = 2) AND user_id = $user_id";
								$res = mysqli_query($conn, $qry);
								while ($row = mysqli_fetch_assoc($res)) {
									echo '<option value="' . $row['id'] . '">' . $row['store_name'] . '</option>';
								}
								?>
							</select>
						</div>
						<div class="col-xl-12 col-lg-12 col-md-12 mt-3">
							<label class="form-label">Discount</label>
							<select name="discount_id" required class="form-select form-control-lg">
								<option value="">Select Discount</option>
								<?php
								$qry2 = "SELECT id, name FROM discount";
								$res2 = mysqli_query($conn, $qry2);
								while ($row2 = mysqli_fetch_assoc($res2)) {
									echo '<option value="' . $row2['id'] . '">' . $row2['name'] . '</option>';
								}
								?>
							</select>
						</div>
						<div class="col-md-12 mt-3">
							<label class="form-label">Notification Location</label>
							<select name="notification_type" class="form-select form-control-lg notification_type">
								<option value="">Select Notification Type</option>
								<option value="state">State</option>
								<option value="district">District</option>
								<option value="city">City</option>
							</select>
						</div>
						<div class="col-md-12 mt-3">
							<label class="form-label">Notification Location</label>
							<select name="notification_location[]" class="form-select form-control-lg notification_location" multiple="true">
								<option value="">Select Location</option>
							</select>
						</div>

						<div class="col-md-12 mt-3">
							<label class="form-label">Notification Title</label>
							<input type="text" class="form-control form-control-lg" name="title" placeholder="Enter Notification Title">
						</div>
						<div class="col-xl-3 col-lg-4 col-md-6 mt-3">
							<label class="form-label">Start Date</label>
							<input type="date" class="form-control form-control-lg" name="start_date" placeholder="Enter Start Date">
						</div>
						<div class="col-md-12 mt-3 mb-3">
							<div class="range-0">
								<input type="range" name="total_user" min="100" max="5000" step="100" value="100" class="range-slider w-100" id="userRange" />
								<div class="price-box">
									Users: <span id="users">100</span><br />
									<b>Total Price: ₹<span id="price">50</span></b>
								</div>
							</div>
						</div>
						<div class="col-12">
							<button type="submit" name="add" class="btn btn-primary">Send Notification</button>
						</div>
					</div>
				</form>
			</div>
		</div>

	</main>

	<!--[ hotelair template vender js ]-->
	<script src="assets/bundles/libscripts.bundle.js"></script>
	<script src="assets/bundles/summernote.bundle.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

	<!-- Include jQuery Validation Plugin -->
	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


	<!-- Template page js -->
	<script src="assets/js/main.js"></script>
	<script>
		$(document).ready(function() {
			$(".notification_location").select2({
				placeholder: "Select Location" //placeholder
			});

			$('.summernote').summernote();
			var noteBar = $('.note-toolbar');
			noteBar.find('[data-toggle]').each(function() {
				$(this).attr('data-bs-toggle', $(this).attr('data-toggle')).removeAttr('data-toggle');
			});
		});

		$(document).ready(function() {

			// RANGE PRICE
			$("#userRange").on("input", function() {
				let users = $(this).val();
				let price = (users / 100) * 50;

				$("#users").text(users);
				$("#price").text(price);
				$("#totalUsers").val(users);
				$("#totalPrice").val(price);
			}).trigger("input");

			// FORM VALIDATION
			$("#notificationForm").validate({
				rules: {
					vendor_id: "required",
					discount_id: "required",
					notification_type: "required",
					"title": {
						required: true,
						minlength: 5
					},
					start_date: "required",
					"notification_location[]": {
						required: true
					}
				},
				messages: {
					vendor_id: "Select store",
					discount_id: "Select discount",
					notification_type: "Select notification type",
					title: "Enter notification title",
					start_date: "Select start date",
					"notification_location[]": "Select location"
				},
				errorClass: "text-danger",
				submitHandler: function(form) {

					$.ajax({
						url: "add-notification-db.php",
						type: "POST",
						data: $(form).serialize(),
						dataType: "json",
						beforeSend: function() {
							$("button[type=submit]").prop("disabled", true);
						},
						success: function(res) {
							if (res.status) {
								form.reset();
								window.location.href = 'notification-list.php';
							}
						},
						complete: function() {
							$("button[type=submit]").prop("disabled", false);
						}
					});

					return false;
				}
			});
		});


		$(document).ready(function() {
			const pricePerUser = 0.5;
			const min = 100;
			const max = 5000;

			function updateSlider(val) {
				const percent = ((val - min) / (max - min)) * 100;
				$("#userRange").css(
					"background",
					`linear-gradient(
                to right,
                #3fa9c6 0%,
                #3fa9c6 ${percent}%,
                #e5e7eb ${percent}%,
                #e5e7eb 100%
            )`
				);

				$("#users").text(val);
				$("#price").text((val * pricePerUser).toFixed(2));
			}

			$("#userRange").on("input", function() {
				updateSlider(this.value);
			});

			updateSlider(100); // initial
		});

		$('.notification_type').on('change', function() {
			$('.notification_location').html('<option>Loading...</option>').prop('disabled', true);
			if (this.value == 'state') {
				$.post('../db/get_state.php', html => {
					$('.notification_location').html(html).prop('disabled', false);
					$(".notification_location").select2({
						placeholder: "Select State" //placeholder
					});
				});
			} else if (this.value == 'district') {
				$.post('../db/get_districts.php', html => {
					$('.notification_location').html(html).prop('disabled', false);
					$(".notification_location").select2({
						placeholder: "Select District" //placeholder
					});
				});
			} else {
				$.post('../db/get_cities.php', html => {
					$('.notification_location').html(html).prop('disabled', false);
					$(".notification_location").select2({
						placeholder: "Select City" //placeholder
					});
				});
			}
		});
	</script>
</body>

</html>