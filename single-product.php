<?php
$vendor_id = "";
require_once "db/connection.php";
$row = "";
if (isset($_GET['shop_id'])) {
	$vendor_id = $_GET['shop_id'];
	$qry = "select * from vendor where id='$vendor_id'";
	$res = mysqli_query($conn, $qry);
	$row = mysqli_fetch_assoc($res);
	// print_r();
	// die;
	if (empty($row['id'])) {
		header('Location:index.php');
	}
	$descount_id = $row['discount_id'];
	$qry1 = "select * from discount where id='$descount_id'";
	$res1 = mysqli_query($conn, $qry1);
	$row1 = mysqli_fetch_assoc($res1);
	// print_r($row);
	// die;
} else {
	$_SESSION['error_msg']	=	"Something went wrong";
	header('Location:index.php');
}
// if (!isset($_SESSION)) {
// 	$_SESSION['error_msg']	=	"Please login now";
// 	header('Location:index.php');
// } else if (empty($_SESSION['user_id'])) {
// 	$_SESSION['error_msg']	=	"Please login now";
// 	header('Location:index.php');
// }
$row5 = [];
if (isset($_GET['cat_id'])) {
	$id = $_GET['cat_id'];
	$qry5 = "SELECT name FROM category WHERE id=$id";
	$res5 = mysqli_query($conn, $qry5);
	$row5 = mysqli_fetch_array($res5);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	require_once "include/header_script.php";
	?>
	<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
	<style>
		.owl-stage {
			display: flex;
			align-items: center;
		}
	</style>
</head>

<body>
	<div class="page-wrapper">
		<?php
		require_once "include/header.php";
		?>
		<main class="main single-product">

			<div class="page-content mb-10 pb-6">
				<div class="container">
					<div class="flex md:hidden flex-wrap items-center justify-between my-5">
						<ul class="breadcrumb breadcrumb-lg">
							<li><a href="index.php"><i class="d-icon-home"></i></a></li>
							<?php if(!empty($row['name'])){ ?><li><a href="vendor.php?cat_id=<?php if (isset($_GET['cat_id'])) {
																echo $_GET['cat_id'];
															} ?>" class="active"><?php echo $row5['name']; ?></a></li>
															<?php } ?>
							<li>
								<?php echo $row['store_name']; ?>
							</li>
						</ul>
					</div>
					<div class="relative overflow-hidden text-lg text-[#999] transition-all sm:mt-8 row mb-8">
						<div class="col-md-6">
							<div class="product-gallery pg-vertical">
								<div
									class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1 gutter-no">
									<figure class="relative object-cover w-full sm:max-h-full rounded-sm overflow-hidden">
										<img class="object-cover" src="vendor/profile/<?php echo $row['image']; ?>"
											data-zoom-image="images/product/product-2-1-800x900.jpg"
											alt="Women's Brown Leather Backpacks">
									</figure>
									<figure class="relative object-cover w-full sm:max-h-full rounded-sm overflow-hidden">
										<img class="object-cover" src="vendor/banner/<?php echo $row['banner']; ?>"
											data-zoom-image="images/product/product-2-1-800x900.jpg"
											alt="Women's Brown Leather Backpacks">
									</figure>
								</div>
							</div>
						</div>
						<div class="col-md-6 sticky-sidebar-wrapper">
							<div class="product-details sticky-sidebar">
								<div class="hidden md:flex flex-wrap items-center justify-between pb-2">
									<ul class="breadcrumb breadcrumb-lg">
										<li><a href="demo1.html"><i class="d-icon-home"></i></a></li>
										<?php if(!empty($row['name'])){ ?><li><a href="vendor.php?cat_id=<?php if (isset($_GET['cat_id'])) {
																echo $_GET['cat_id'];
															} ?>" class="active"><?php echo $row5['name']; ?></a></li>
															<?php } ?>
										<li> <?php echo $row['store_name']; ?> </li>
									</ul>
								</div>
								<div>
									<div class="!text-[3rem] text-black mb-0">
										<?php echo $row['store_name']; ?>
									</h1>
								</div>
								<div class="text-xl font-medium">
									<div class="text-gray-700 flex gap-2">
										<div class="text-2xl">
											<i class="d-icon-map-marker"></i>
											<?php echo $row['street']; ?>,
											<?php
											echo $row['city_id'];
											if ($row['state_id']) {
												$qry = "SELECT name FROM state WHERE id =" . $row['state_id'];
												$res = mysqli_query($conn, $qry);
												$state = mysqli_fetch_array($res);
												echo ', ' . $state['name'];
											}
											echo ' - ' . $row['zipcode'];
											?>
										</div>
									</div>
									<div class="border border-gray-300 p-5 shadow-lg mt-4 rounded-lg">
										<div class="text-[#2266cc] text-4xl text-center my-5">
											<i class="fas fa-tag"></i> <?php echo $row1['name']; ?>
										</div>

										<div class="!text-[#666] text-2xl mt-2">
											<?php echo $row['desc_1']; ?>
										</div>
									</div>
								</div>
								<div class="border bg-[#2266cc] p-6 text-white rounded-md flex flex-col gap-2  mt-2">
									<span>
										<i class="d-icon-user"></i>
										<?= $row['name']; ?>
									</span>
									<a class="text-white text-2xl" href="tel:<?php echo $row['contact']; ?>" class="product-meta">
										<i class="d-icon-phone"></i>
										<span class="product-brand"><?php echo $row['contact']; ?></span>
									</a>
								</div>
								<?php
								if (!empty($_SESSION['is_active']) && 	$_SESSION['is_active'] == 1) {
								?>
									<div class="product-meta">
										<div>SHARE: <a href="javascript:void(0)" id="shareButton"><img src="images/icons/share-icon.png" width="25" class="ml-2"></a></div>
									</div>
								<?php } ?>
								<!-- <p class="product-short-desc">
								</p> -->
								<hr class="product-divider">
							</div>
						</div>
					</div>
					<div class="tab tab-nav-simple product-tabs mb-4">
						<ul class="nav nav-tabs justify-content-center" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" href="#product-tab-description">Product Or Services</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active in" id="product-tab-description">
								<div class="row mt-12">
									<div class="col-md-12">
										<?php echo $row['desc_2']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<?php
		require_once "include/footer.php";
		?>

	</div>

	<?php
	require_once "include/mobile-menu.php";
	require_once "include/footer_script.php"
	?>
	<script>
		document.getElementById('shareButton').addEventListener('click', function() {
			if (navigator.share) {
				navigator.share({
						title: 'Shoppercity',
						text: 'Check out this awesome website!',
						url: "https://shopercity.com/login.php"
					})
					.then(() => console.log('Successfully shared'))
					.catch((error) => console.log('Error sharing:', error));
			} else {
				console.log('Web Share API is not supported.');
			}
		});
	</script>
</body>

</html>