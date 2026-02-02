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
					<li class="breadcrumb-item active" aria-current="page">Add Your Business</li>
				</ol>
			</div>
			<!-- start: page body area -->
			<div class="px-xl-5 px-lg-4 px-3 py-3 page-body">
				<h3 class="fw-bold">Add your business</h3>
				<div class="card p-4">
					<form class="row g-3" method="post" action="" enctype='multipart/form-data' id="add_vendor">
						<input type="hidden" name="id" value="<?php if (isset($_GET['id'])) {
																	echo $_GET['id'];
																} ?>">
						<input type="hidden" name="old_banner" value="<?php if (!empty($vendor_row['banner'])) {
																			echo $vendor_row['banner'];
																		} ?>">
						<input type="hidden" name="old_image" value="<?php if (!empty($vendor_row['image'])) {
																			echo $vendor_row['image'];
																		} ?>">
						<div class="col-lg-6 col-12">
							<label class="form-label ">Owner Name</label>
							<input type="text" name="v_name" class="form-control text form-control-lg" placeholder="" value="<?php if (!empty($vendor_row['name'])) {
																																	echo $vendor_row['name'];
																																} ?>">
						</div>
						<div class="col-lg-6 col-12">
							<label class="form-label ">Business Name</label>
							<input type="text" name="store_name" class="form-control form-control-lg" placeholder="" value="<?php if (!empty($vendor_row['store_name'])) {
																																echo $vendor_row['store_name'];
																															} ?>">
						</div>
						<div class="col-xl-3 col-lg-4 col-md-6">
							<label class="form-label">Email Address</label>
							<input type="text" class="form-control form-control-lg" name="email" placeholder="" value="<?php if (!empty($vendor_row['email'])) {
																															echo $vendor_row['email'];
																														} ?>">
						</div>
						<div class="col-xl-3 col-lg-4 col-md-6">
							<label class="form-label">Bio</label>
							<input type="text" class="form-control form-control-lg" name="street" value="<?php if (!empty($vendor_row['street'])) {
																												echo $vendor_row['street'];
																											} ?>">
						</div>
						<div class="col-xl-3 col-lg-6 col-sm-6">
							<label class="form-label">City</label>
							<input type="text" class="form-control form-control-lg" name="city" value="<?php if (!empty($vendor_row['city_id'])) {
																											echo $vendor_row['city_id'];
																										} ?>">
						</div>
						<div class="col-xl-3 col-lg-4 col-md-6">
							<label class="form-label">State</label>

							<select name="state" required class="form-select form-control-lg">
								<option value="">Select State</option>
								<?php
								$state_qry = "SELECT * FROM state";
								$state_res = mysqli_query($conn, $state_qry);
								while ($row = mysqli_fetch_assoc($state_res)) {
									echo '<option value="' . $row['state_code'] . '">' . $row['name'] . '</option>';
								}
								?>
							</select>
						</div>
						<div class="col-xl-3 col-lg-4 col-md-6">
							<label class="form-label">District</label>
							<select name="district" required class="form-select form-control-lg">
								<option value="">Select District</option>
							</select>
						</div>
						<div class="col-xl-3 col-lg-4 col-md-6">
							<label class="form-label">Country</label>
							<select class="form-select form-control-lg" name="country">
								<?php
								while ($row   =   mysqli_fetch_assoc($country)) {
								?>
									<option value="<?php echo $row['id']; ?>" <?php if (!empty($vendor_row['country_id']) && $row['id']	==  $vendor_row['country_id']) {
																					echo "selected";
																				} ?>><?php echo $row['name']; ?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="col-xl-3 col-lg-4 col-md-6">
							<label class="form-label">Zipcode</label>
							<input type="number" class="form-control form-control-lg" placeholder="" name="zipcode" value="<?php if (!empty($vendor_row['zipcode'])) {
																																echo $vendor_row['zipcode'];
																															} ?>">
						</div>
						<div class="col-xl-3 col-lg-4 col-md-6">
							<label class="form-label">Contact</label>
							<input type="number" class="form-control form-control-lg" placeholder="" name="contact" value="<?php if (!empty($vendor_row['contact'])) {
																																echo $vendor_row['contact'];
																															} ?>">
						</div>
						<div class="col-xl-3 col-lg-6 col-sm-6">
							<label class="form-label">Category Name</label>
							<select class="form-select form-control-lg" name="category">
								<?php
								while ($row   =   mysqli_fetch_assoc($category)) {
								?>
									<option value="<?php echo $row['id']; ?>" <?php if (!empty($vendor_row['category_id']) && $row['id']	==  $vendor_row['category_id']) {
																					echo "selected";
																				} ?>><?php echo $row['name']; ?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="col-xl-3 col-lg-6 col-sm-6">
							<label class="form-label">Discount</label>
							<select class="form-select form-control-lg" name="discount">
								<?php
								while ($row   =   mysqli_fetch_assoc($discount)) {
								?>
									<option value="<?php echo $row['id']; ?>" <?php if (!empty($vendor_row['discount_id']) && $row['id']	==  $vendor_row['discount_id']) {
																					echo "selected";
																				} ?>><?php echo $row['name']; ?></option>
								<?php
								}
								?>
							</select>
						</div>
						<input type="hidden" class="btn-check" value="1" name="delivery" id="btnradio1">
						<div class="col-xl-3 col-lg-4 col-md-6">
							<label class="form-label ">Start Date</label>
							<input type="date" class="form-control form-control-lg" name="s_date" value="<?php if (!empty($vendor_row['starting_date'])) {
																												echo $vendor_row['starting_date'];
																											} ?>" placeholder="">
						</div>
						<div class="col-xl-3 col-lg-4 col-md-6">
							<label class="form-label ">End Date</label>
							<input type="date" class="form-control form-control-lg" name="e_date" placeholder="" value="<?php if (!empty($vendor_row['end_date'])) {
																															echo $vendor_row['end_date'];
																														} ?>">
						</div>
						<div class="col-12 row">
							<div class="col-12 col-md-12 col-lg-6">
								<label class="col-form-label">Discount terms & condition</label>
								<textarea class="summernote" name="desc_1"><?php if (!empty($vendor_row['desc_1'])) {
																				echo $vendor_row['desc_1'];
																			} ?></textarea>
							</div>
							<div class="col-12 col-md-12 col-lg-6">

								<label class="col-form-label">Service Description</label>
								<textarea class="summernote" name="desc_2"><?php if (!empty($vendor_row['desc_2'])) {
																				echo $vendor_row['desc_2'];
																			} ?></textarea>
							</div>
						</div>
						<div class="col-12 row">
							<div class="col-12 col-md-12 col-lg-6">
								<label class="col-form-label">Facebook Link</label>
								<input type="text" name="fb_link" value="<?php if (!empty($vendor_row['fb_link'])) {
																				echo $vendor_row['fb_link'];
																			} ?>">
							</div>
							<div class="col-12 col-md-12 col-lg-6">

								<label class="col-form-label">Instagram Link</label>
								<input type="text" name="insta_link" value="<?php if (!empty($vendor_row['insta_link'])) {
																				echo $vendor_row['insta_link'];
																			} ?>">
							</div>
						</div>
						<div class="col-lg-6 col-12">
							<label class="form-label ">Business Baner Upload </label>
							<div class="form-group">
								<input type="file" name="banner" class="form-control" placeholder="">
							</div>
						</div>
						<div class="col-lg-6 col-12">
							<label class="form-label ">Business profile upload</label>
							<div class="form-group">
								<input type="file" name="image" class="form-control" placeholder="">
							</div>
						</div>
						<div class="col-lg-6 col-12">
							<?php
							if (!empty($vendor_row['banner'])) {
							?>
								<img src="<?php echo URL . 'vendor/banner/' . $vendor_row['banner']; ?>" class="w-25 rounded" alt="" srcset="">
							<?php
							}
							?>
						</div>
						<div class="col-lg-6 col-12">
							<?php
							if (!empty($vendor_row['image'])) {
							?>
								<img src="<?php echo URL . 'vendor/profile/' . $vendor_row['image']; ?>" class="w-25 rounded" alt="" srcset="">
							<?php
							}
							?>
						</div>
						<div class="col-12">
							<button type="submit" name="add" class="btn btn-primary">Submit</button>
							<a href="vendor.php" name="add" class="btn btn-primary" style="background-color: white; color:#8057c7;">cancel</a>
						</div>
					</form><!-- Row End -->
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


	<!-- Template page js -->
	<script src="assets/js/main.js"></script>
	<script>
		$(document).ready(function() {
			$('.summernote').summernote();
			var noteBar = $('.note-toolbar');
			noteBar.find('[data-toggle]').each(function() {
				$(this).attr('data-bs-toggle', $(this).attr('data-toggle')).removeAttr('data-toggle');
			});
		});

		$(document).ready(function() {
			// Initialize the jQuery Validation Plugin
			$("#add_vendor").validate({
				rules: {
					// Category
					category: {
						required: true
					},
					// Vendor Name
					v_name: {
						required: true,
						minlength: 3
					},
					// Store Name
					store_name: {
						required: true,
						minlength: 3
					},
					// Contact Number (validate number format)
					contact: {
						required: true,
						digits: true,
						minlength: 10,
						maxlength: 15
					},
					// Email
					email: {
						required: true,
						email: true
					},
					// Street
					street: {
						required: true
					},
					// City
					city: {
						required: true
					},
					// State
					state: {
						required: true
					},
					district: {
						required: true
					},
					// Country
					country: {
						required: true
					},
					// Zipcode (validate number format)
					zipcode: {
						required: true,
						digits: true,
						minlength: 5,
						maxlength: 10
					},
					// Latitude (validate number format)
					lat: {
						required: true,
						number: true
					},
					// Longitude (validate number format)
					log: {
						required: true,
						number: true
					},
					// Plan
					plan: {
						required: true
					},
					// Description 1
					desc_1: {
						required: true,
						minlength: 5
					},
					// Description 2 (optional)
					desc_2: {
						minlength: 5
					},
					// Discount (ensure number is not negative)
					discount: {
						required: true,
						min: 0
					},
					// Delivery (if checked, must be true)
					delivery: {
						required: false // No validation needed for checkbox if it's optional
					},
					// Link (URL format)
					link: {
						url: true
					},
					// Starting Date
					s_date: {
						required: true,
						date: true
					},
					// End Date
					e_date: {
						required: true,
						date: true,
						// greaterThan: "#s_date" // Custom rule to ensure end date is after start date
					},
					banner: {
						<?php if (empty($vendor_row['banner'])) { ?>
							required: true,
						<?php } ?>
						extension: "jpg|jpeg|png|gif", // File types
						filesize: 5242880 // Max file size: 5MB
					},
					// Image Validation (File type and size)
					image: {
						<?php if (empty($vendor_row['image'])) { ?>
							required: true,
						<?php } ?>
						extension: "jpg|jpeg|png|gif", // File types
						filesize: 5242880 // Max file size: 5MB
					}

				},
				messages: {
					category: {
						required: "Please select a category"
					},
					v_name: {
						required: "Please enter vendor name",
						minlength: "Vendor name must be at least 3 characters long"
					},
					store_name: {
						required: "Please enter store name",
						minlength: "Store name must be at least 3 characters long"
					},
					contact: {
						required: "Please enter your contact number",
						digits: "Please enter a valid phone number",
						minlength: "Phone number must be at least 10 digits",
						maxlength: "Phone number must be at most 15 digits"
					},
					email: {
						required: "Please enter a valid email address",
						email: "Please enter a valid email address"
					},
					street: {
						required: "Please enter your street address"
					},
					city: {
						required: "Please enter your city"
					},
					state: {
						required: "Please enter your state"
					},
					district: {
						required: 'Please enter your district'
					},
					country: {
						required: "Please enter your country"
					},
					zipcode: {
						required: "Please enter your zipcode",
						digits: "Zipcode must be a number",
						minlength: "Zipcode must be at least 5 digits",
						maxlength: "Zipcode can be at most 10 digits"
					},
					lat: {
						required: "Please enter latitude",
						number: "Latitude must be a number"
					},
					log: {
						required: "Please enter longitude",
						number: "Longitude must be a number"
					},
					plan: {
						required: "Please enter plan details"
					},
					desc_1: {
						required: "Please provide a description",
						minlength: "Description must be at least 5 characters long"
					},
					desc_2: {
						minlength: "Description must be at least 5 characters long"
					},
					discount: {
						required: "Please enter discount",
						min: "Discount cannot be negative"
					},
					link: {
						url: "Please enter a valid URL"
					},
					s_date: {
						required: "Please select a starting date",
						date: "Please enter a valid date"
					},
					e_date: {
						required: "Please select an end date",
						date: "Please enter a valid date",
						greaterThan: "End date must be later than the starting date"
					},
					// Banner file (Validate image)
					banner: {
						required: "Please upload a banner image",
						extension: "Allowed file types: jpg, jpeg, png, gif",
						filesize: "File size must be less than 5MB"
					},
					image: {
						required: "Please upload an image",
						extension: "Allowed file types: jpg, jpeg, png, gif",
						filesize: "File size must be less than 5MB"
					}
				},
				submitHandler: function(form) {
					// If the form is valid, submit the form (optional)
					form.submit();
				}
			});

			// Custom validation rule to check that end date is later than the start date
			$.validator.addMethod("greaterThan", function(value, element, param) {
				var startDate = $(param).val();
				return new Date(value) > new Date(startDate);
			}, "End date must be after the start date.");
			// Custom validation for file extension (using the extension rule)
			$.validator.addMethod("extension", function(value, element, param) {
				var fileName = value.toLowerCase();
				return this.optional(element) || fileName.match(new RegExp("\\.(" + param + ")$"));
			}, "Invalid file type.");
		});

		$(document).ready(function() {
			$('select[name="state"]').on('change', function() {
				var stateCode = $(this).val();

				if (stateCode !== "") {
					$.ajax({
						url: '../get_state.php', // ✅ Set correct file path here
						type: 'POST',
						data: {
							state: stateCode
						},
						dataType: 'json',
						success: function(response) {
							let $districtSelect = $('select[name="district"]');
							$districtSelect.empty();

							if (response.length > 0) {
								$districtSelect.append('<option value="">Select District</option>');
								$.each(response, function(index, districtName) {
									$districtSelect.append('<option value="' + districtName + '">' + districtName + '</option>');
								});
							} else {
								$districtSelect.append('<option value="">No Districts Found</option>');
							}
						},
						error: function() {
							alert("Failed to fetch districts.");
						}
					});
				} else {
					$('select[name="district"]').empty().append('<option value="">Select District</option>');
				}
			});
		});
	</script>
</body>

</html>