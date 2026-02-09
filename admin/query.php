<?php include("../include/connection.php");
if (isset($_POST['signin']) && $_POST['signin'] == 'SignIn') {

	if ($user->doLogin($_POST['username'], $_POST['password'])) {
		if ($_SESSION['type'] == 0) {
			$user->redirect('index.php?page=dashboard');
		} else {

			$user->redirect('user.php');
		}
	} else {
		$_SESSION['err'] = 'Invalid Username Password';
		$user->redirect('login.php');
	}
}
// Discount
if (isset($_POST['discount']) && $_POST['discount'] == 'Save') {
	$name = $_POST['name'];
	$insert_query = $conn->prepare("INSERT INTO discount (name,created_by) VALUES (:name,:created_by)");
	$insert_record = $insert_query->execute(array(
		':name' => $name,
		':created_by' => date("Y-m-d H:i:s")
	));

	if ($insert_record) {
		$_SESSION['ins_msg'] = 'discount added successfully';
		header('location:discount.php');
	}
}
if (isset($_POST['discount']) && $_POST['discount'] == 'Update') {
	$name = $_POST['name'];
	$update_query = $conn->prepare("UPDATE discount SET name=:name, modified_by=:modified_by WHERE id=:id");
	$update_record = $update_query->execute(array(
		':name' => $name,
		':id' => $_POST['id'],
		':modified_by' => date("Y-m-d H:i:s")
	));

	if ($update_record) {
		$_SESSION['ins_msg'] = 'discount updated successfully';
		header('location:discount.php');
	}
}
if (isset($_GET['name']) && $_GET['name'] == 'discount' and $_GET['id'] != '') {
	$id = $_GET['id'];
	$update_query = $conn->prepare("DELETE FROM discount WHERE id=:id");
	$update_record = $update_query->execute(array(
		':id' => $_GET['id']
	));

	if ($update_record) {
		$_SESSION['ins_msg'] = 'discount Delete successfully';
		header('location:discount.php');
	}
}

// country
if (isset($_POST['brand']) && $_POST['brand'] == 'Save') {
	$name = $_POST['name'];
	$insert_query = $conn->prepare("INSERT INTO brand (name,created_by) VALUES (:name,:created_by)");
	$insert_record = $insert_query->execute(array(
		':name' => $name,
		':created_by' => date("Y-m-d H:i:s")
	));

	if ($insert_record) {
		$_SESSION['ins_msg'] = 'Brand added successfully';
		header('location:brand.php');
	}
}
if (isset($_POST['brand']) && $_POST['brand'] == 'Update') {
	$name = $_POST['name'];
	$update_query = $conn->prepare("UPDATE brand SET name=:name, modified_by=:modified_by WHERE id=:id");
	$update_record = $update_query->execute(array(
		':name' => $name,
		':id' => $_POST['id'],
		':modified_by' => date("Y-m-d H:i:s")
	));

	if ($update_record) {
		$_SESSION['ins_msg'] = 'Brand updated successfully';
		header('location:brand.php');
	}
}
if (isset($_GET['name']) && $_GET['name'] == 'brand' and $_GET['id'] != '') {
	$id = $_GET['id'];
	$update_query = $conn->prepare("DELETE FROM brand WHERE id=:id");
	$update_record = $update_query->execute(array(
		':id' => $_GET['id']
	));

	if ($update_record) {
		$_SESSION['ins_msg'] = 'Brand Delete successfully';
		header('location:brand.php');
	}
}

//Category
if (isset($_POST['category']) && $_POST['category'] == 'Save') {
	$name = $_POST['name'];
	$insert_query = $conn->prepare("INSERT INTO category (name,created_by,parent,description) VALUES (:name,:created_by,:parent,:description)");
	$insert_record = $insert_query->execute(array(
		':name' => $name,
		':created_by' => date("Y-m-d H:i:s"),
		':parent' => $_POST['parent'],
		':description' => $_POST['description']
	));
	$insert_id = $conn->lastInsertId();

	$imgFile = $_FILES['image']['name'];
	$tmp_dir = $_FILES['image']['tmp_name'];
	$imgSize = $_FILES['image']['size'];

	if ($imgFile) {
		$upload_dir = '../category/'; // upload directory
		$imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
		// valid image extensions
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		// rename uploading image
		$userpic = 'Shopercity-' . time() . "." . $imgFile;
		// allow valid image file formats
		if (in_array($imgExt, $valid_extensions)) {
			// Check file size '5MB'
			if ($imgSize < 5000000) {
				move_uploaded_file($tmp_dir, $upload_dir . $userpic);
				$update_query = $conn->prepare("UPDATE category SET image=:image WHERE id='" . $insert_id . "'");
				$update_rec = $update_query->execute(array(':image' => $userpic));
			} else {
				$errMSG = "Sorry, your file is too large.";
			}
		} else {
			$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		}
	}
	if ($insert_record) {
		$_SESSION['ins_msg'] = 'category added successfully';
		header('location:category.php');
	}
}
if (isset($_POST['category']) && $_POST['category'] == 'Update') {
	$name = $_POST['name'];
	$update_query = $conn->prepare("UPDATE category SET name=:name, parent=:parent, description=:description, modified_by=:modified_by WHERE id=:id");
	$update_record = $update_query->execute(array(
		':name' => $name,
		':id' => $_POST['id'],
		':modified_by' => date("Y-m-d H:i:s"),
		':parent' => $_POST['parent'],
		':description' => $_POST['description']
	));
	$insert_id = $_POST['id'];

	$imgFile = $_FILES['image']['name'];
	$tmp_dir = $_FILES['image']['tmp_name'];
	$imgSize = $_FILES['image']['size'];

	if ($imgFile) {
		$upload_dir = '../category/'; // upload directory
		$imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
		// valid image extensions
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		// rename uploading image
		$userpic = 'Shopercity-' . time() . "." . $imgFile;
		// allow valid image file formats
		if (in_array($imgExt, $valid_extensions)) {
			// Check file size '5MB'
			if ($imgSize < 5000000) {
				move_uploaded_file($tmp_dir, $upload_dir . $userpic);
				$update_query = $conn->prepare("UPDATE category SET image=:image WHERE id='" . $insert_id . "'");
				$update_rec = $update_query->execute(array(':image' => $userpic));
			} else {
				$errMSG = "Sorry, your file is too large.";
			}
		} else {
			$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		}
	}
	if ($update_record) {
		$_SESSION['ins_msg'] = 'category updated successfully';
		header('location:category.php');
	}
}
if (isset($_GET['name']) && $_GET['name'] == 'category' and $_GET['id'] != '') {
	$id = $_GET['id'];
	$update_query = $conn->prepare("DELETE FROM category WHERE id=:id");
	$update_record = $update_query->execute(array(
		':id' => $_GET['id']
	));

	if ($update_record) {
		$_SESSION['ins_msg'] = 'category Delete successfully';
		header('location:category.php');
	}
}

//Subscription Plan

if (isset($_POST['subscription']) && $_POST['subscription'] == 'Save') {
	$name = $_POST['name'];

	$insert_query = $conn->prepare("INSERT INTO subscription (name,created_by,month,price) VALUES (:name,:created_by,:month,:price)");
	$insert_record = $insert_query->execute(array(
		':name' => $name,
		':created_by' => date("Y-m-d H:i:s"),
		':month' => $_POST['month'],
		':price' => $_POST['price']
	));

	if ($insert_record) {
		$_SESSION['ins_msg'] = 'subscription added successfully';
		header('location:subscription.php');
	}
}
if (isset($_POST['subscription']) && $_POST['subscription'] == 'Update') {
	$name = $_POST['name'];
	$update_query = $conn->prepare("UPDATE subscription SET name=:name, month=:month, price=:price, modified_by=:modified_by WHERE id=:id");
	$update_record = $update_query->execute(array(
		':name' => $name,
		':id' => $_POST['id'],
		':modified_by' => date("Y-m-d H:i:s"),
		':month' => $_POST['month'],
		':price' => $_POST['price']
	));

	if ($update_record) {
		$_SESSION['ins_msg'] = 'subscription updated successfully';
		header('location:subscription.php');
	}
}
if (isset($_GET['name']) && $_GET['name'] == 'subscription' and $_GET['id'] != '') {
	$id = $_GET['id'];
	$update_query = $conn->prepare("DELETE FROM subscription WHERE id=:id");
	$update_record = $update_query->execute(array(
		':id' => $_GET['id']
	));

	if ($update_record) {
		$_SESSION['ins_msg'] = 'subscription Delete successfully';
		header('location:subscription.php');
	}
}

// country
if (isset($_POST['country']) && $_POST['country'] == 'Save') {
	$name = $_POST['name'];
	$insert_query = $conn->prepare("INSERT INTO country (name,created_by) VALUES (:name,:created_by)");
	$insert_record = $insert_query->execute(array(
		':name' => $name,
		':created_by' => date("Y-m-d H:i:s")
	));

	if ($insert_record) {
		$_SESSION['ins_msg'] = 'country added successfully';
		header('location:country.php');
	}
}
if (isset($_POST['country']) && $_POST['country'] == 'Update') {
	$name = $_POST['name'];
	$update_query = $conn->prepare("UPDATE country SET name=:name, modified_by=:modified_by WHERE id=:id");
	$update_record = $update_query->execute(array(
		':name' => $name,
		':id' => $_POST['id'],
		':modified_by' => date("Y-m-d H:i:s")
	));

	if ($update_record) {
		$_SESSION['ins_msg'] = 'country updated successfully';
		header('location:country.php');
	}
}
if (isset($_GET['name']) && $_GET['name'] == 'country' and $_GET['id'] != '') {
	$id = $_GET['id'];
	$update_query = $conn->prepare("DELETE FROM country WHERE id=:id");
	$update_record = $update_query->execute(array(
		':id' => $_GET['id']
	));

	if ($update_record) {
		$_SESSION['ins_msg'] = 'country Delete successfully';
		header('location:country.php');
	}
}


//State
if (isset($_POST['state']) && $_POST['state'] == 'Save') {
	$name = $_POST['name'];
	$insert_query = $conn->prepare("INSERT INTO state (name,created_by,country_id) VALUES (:name,:created_by,:country_id)");
	$insert_record = $insert_query->execute(array(
		':name' => $name,
		':created_by' => date("Y-m-d H:i:s"),
		':country_id' => $_POST['country_id']
	));

	if ($insert_record) {
		$_SESSION['ins_msg'] = 'state added successfully';
		header('location:state.php');
	}
}
if (isset($_POST['state']) && $_POST['state'] == 'Update') {
	$name = $_POST['name'];
	$update_query = $conn->prepare("UPDATE state SET name=:name, country_id=:country_id, modified_by=:modified_by WHERE id=:id");
	$update_record = $update_query->execute(array(
		':name' => $name,
		':id' => $_POST['id'],
		':modified_by' => date("Y-m-d H:i:s"),
		':country_id' => $_POST['country_id']
	));

	if ($update_record) {
		$_SESSION['ins_msg'] = 'state updated successfully';
		header('location:state.php');
	}
}
if (isset($_GET['name']) && $_GET['name'] == 'state' and $_GET['id'] != '') {
	$id = $_GET['id'];
	$update_query = $conn->prepare("DELETE FROM state WHERE id=:id");
	$update_record = $update_query->execute(array(
		':id' => $_GET['id']
	));

	if ($update_record) {
		$_SESSION['ins_msg'] = 'state Delete successfully';
		header('location:state.php');
	}
}

//city
if (isset($_POST['city']) && $_POST['city'] == 'Save') {
	$name = $_POST['name'];
	$insert_query = $conn->prepare("INSERT INTO city (name,created_by,country_id,state_id) VALUES (:name,:created_by,:country_id,:state_id)");
	$insert_record = $insert_query->execute(array(
		':name' => $name,
		':created_by' => date("Y-m-d H:i:s"),
		':country_id' => $_POST['country_id'],
		':state_id' => $_POST['state_id']
	));

	if ($insert_record) {
		$_SESSION['ins_msg'] = 'city added successfully';
		header('location:city.php');
	}
}
if (isset($_POST['city']) && $_POST['city'] == 'Update') {
	$name = $_POST['name'];
	$update_query = $conn->prepare("UPDATE city SET name=:name, country_id=:country_id, state_id=:state_id, modified_by=:modified_by WHERE id=:id");
	$update_record = $update_query->execute(array(
		':name' => $name,
		':id' => $_POST['id'],
		':modified_by' => date("Y-m-d H:i:s"),
		':country_id' => $_POST['country_id'],
		':state_id' => $_POST['state_id']
	));

	if ($update_record) {
		$_SESSION['ins_msg'] = 'city updated successfully';
		header('location:city.php');
	}
}
if (isset($_GET['name']) && $_GET['name'] == 'city' and $_GET['id'] != '') {
	$id = $_GET['id'];
	$update_query = $conn->prepare("DELETE FROM city WHERE id=:id");
	$update_record = $update_query->execute(array(
		':id' => $_GET['id']
	));

	if ($update_record) {
		$_SESSION['ins_msg'] = 'city Delete successfully';
		header('location:city.php');
	}
}

//Vendor
if (isset($_POST['vendor']) && $_POST['vendor'] == 'Save') {
	$city_id = $_POST['city_id'];
	$youtube_link = $_POST['youtube_link'];
	$country_id = $_POST['country_id'];
	$category_id = $_POST['category_id'];
	$state_id = $_POST['state_id'];
	$zipcode = $_POST['zipcode'];
	$store_name = $_POST['store_name'];
	$email = $_POST['email'];
	$street = $_POST['street'];
	$plan_id = $_POST['plan_id'];
	$contact = $_POST['contact'];
	$desc_1 = $_POST['desc_1'];
	$desc_2 = $_POST['desc_2'];
	$starting_date = $_POST['starting_date'];
	$end_date = $_POST['end_date'];
	$discount_id = $_POST['discount_id'];
	$delivery_status = $_POST['delivery_status'];
	$imgFile = $_FILES['image']['name'];
	$tmp_dir = $_FILES['image']['tmp_name'];
	$imgSize = $_FILES['image']['size'];

	$imgFile1 = $_FILES['banner']['name'];
	$tmp_dir1 = $_FILES['banner']['tmp_name'];
	$imgSize1 = $_FILES['banner']['size'];
	$name = $_POST['name'];
	$status	= $_POST['status'];
	$reason	=	$_POST['reason'];
	$insert_query = $conn->prepare("INSERT INTO vendor (name, created_by, country_id, state_id, city_id, contact, zipcode, store_name, email, street, plan_id, category_id, youtube_link, desc_1, desc_2, delivery_status,discount_id,starting_date,end_date,status, reason) VALUES (:name, :created_by, :country_id, :state_id, :city_id, :contact, :zipcode, :store_name, :email, :username, :password, :street, :lat, :longitude, :plan_id, :category_id, :youtube_link, :desc_1, :desc_2, :delivery_status, :discount_id,:starting_date,:end_date,:status, :reason)");

	$insert_record = $insert_query->execute(array(
		':name' => $name,
		':created_by' => date("Y-m-d H:i:s"),
		':country_id' => $country_id,
		':state_id' => $state_id,
		':city_id' => $city_id,
		':zipcode' => $zipcode,
		':store_name' => $store_name,
		':email' => $email,
		':contact' => $contact,
		':street' => $street,
		':plan_id' => $plan_id,
		':category_id' => $category_id,
		':youtube_link' => $youtube_link,
		':desc_1' => "$desc_1",
		':desc_2' => "$desc_2",
		':delivery_status' => $delivery_status,
		':discount_id' => $discount_id ? $discount_id : 1,
		':starting_date' => $starting_date,
		':end_date' => $end_date,
		':status' => $status,
		':reason' => $reason
	));

	$insert_id = $conn->lastInsertId();
	$month = $user->getField($plan_id, 'subscription', 'month');
	$end_date = date('Y-m-d', strtotime("+$month months", strtotime(date("Y-m-d"))));
	$insert_query = $conn->prepare("INSERT INTO vendor_subscribe (user_id,plan_id,start_date,end_date) VALUES (:user_id,:plan_id,:start_date,:end_date)");
	$insert_record = $insert_query->execute(array(
		':user_id' => $insert_id,
		':plan_id' => $plan_id,
		':start_date' => date("Y-m-d H:i:s"),
		':end_date' => $end_date
	));
	if ($imgFile) {
		$upload_dir = DIR . 'vendor/profile/'; // upload directory

		$imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

		// valid image extensions
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

		// rename uploading image
		$userpic = 'Shopercity-' . time() . "." . $imgExt;
		// allow valid image file formats
		if (in_array($imgExt, $valid_extensions)) {
			// Check file size '5MB'
			if ($imgSize < 5000000) {
				move_uploaded_file($_FILES['image']['tmp_name'], '../vendor/profile/' . $userpic);
				$update_query = $conn->prepare("UPDATE vendor SET image=:image WHERE id='" . $insert_id . "'");
				$update_rec = $update_query->execute(array(':image' => $userpic));
			} else {
				$errMSG = "Sorry, your file is too large.";
			}
		} else {
			$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		}
	}
	if ($imgFile1) {
		$upload_dir = DIR . 'vendor/banner/'; // upload directory

		$imgExt = strtolower(pathinfo($imgFile1, PATHINFO_EXTENSION)); // get image extension

		// valid image extensions
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

		// rename uploading image
		$userpic = 'Shopercity-' . time() . "." . $imgExt;

		// allow valid image file formats
		if (in_array($imgExt, $valid_extensions)) {
			// Check file size '5MB'
			if ($imgSize1 < 5000000) {
				move_uploaded_file($_FILES['banner']['tmp_name'], '../vendor/banner/' . $userpic);
				$update_query = $conn->prepare("UPDATE vendor SET banner=:image WHERE id='" . $insert_id . "'");
				$update_rec = $update_query->execute(array(':image' => $userpic));
			} else {
				$errMSG = "Sorry, your file is too large.";
			}
		} else {
			$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		}
	}
	if ($insert_record) {
		$_SESSION['ins_msg'] = 'vendor added successfully';
		header('location:user.php');
	}
}
if (isset($_POST['vendor']) && $_POST['vendor'] == 'Update') {
	$city_id = $_POST['city_id'];
	// $youtube_link = $_POST['youtube_link'];
	// $country_id = $_POST['country_id'];
	$category_id = $_POST['category_id'];
	$state_id = $_POST['state_id'];
	$zipcode = $_POST['zipcode'];
	$store_name = $_POST['store_name'];
	$email = $_POST['email'];
	// $username = $_POST['username'];
	// $password = $_POST['password'];
	// $street = $_POST['street'];
	// $lat = $_POST['lat'];
	// $long = $_POST['long'];
	$plan_id = $_POST['plan_id'];
	$contact = $_POST['contact'];
	$desc_1 = $_POST['desc_1'];
	$desc_2 = $_POST['desc_2'];
	// $starting_date = $_POST['starting_date'];
	// $end_date = $_POST['end_date'];
	$delivery_status = $_POST['delivery_status'];
	$discount_id = $_POST['discount_id'];
	$imgFile = $_FILES['image']['name'];
	$tmp_dir = $_FILES['image']['tmp_name'];
	$imgSize = $_FILES['image']['size'];
	$imgFile1 = $_FILES['banner']['name'];
	$tmp_dir1 = $_FILES['banner']['tmp_name'];
	$imgSize1 = $_FILES['banner']['size'];
	$old_image = $_POST['old_img'];
	$old_banner = $_POST['old_banner'];
	$status	= $_POST['status'];
	$reason	=	$_POST['reason'];
	$name = $_POST['name'];
	$insta_link = $_POST['insta_link'];
	$yt_link = $_POST['yt_link'];
	$fb_link = $_POST['fb_link'];
	$website_link = $_POST['website_link'];
	$bio = $_POST['bio'];
	//$update_query=$conn->prepare("UPDATE vendor SET name=:name,country_id=:country_id,state_id=:state_id,city_id=:city_id,contact=:contact,zipcode=:zipcode,store_name=:store_name,email=:email,username=:username,password=:password,street=:street,lat=:lat,longitude=:longitude,plan_id=:plan_id,modified_by=:modified_by,category_id=:category_id,youtube_link=:youtube_link,desc_1:desc_1,desc_2:desc_2,delivery_status:delivery_status WHERE id=:id");
	$sql = "
UPDATE vendor SET
    name = :name,
    country_id = :country_id,
    state_id = :state_id,
    city_id = :city_id,
    contact = :contact,
    zipcode = :zipcode,
    store_name = :store_name,
    category_id = :category_id,
    desc_1 = :desc_1,
    desc_2 = :desc_2,
    delivery_status = :delivery_status,
    discount_id = :discount_id,
    end_date = :end_date,
    status = :status,
    reason = :reason,
    insta_link = :insta_link,
    yt_link = :yt_link,
    fb_link = :fb_link,
    website_link = :website_link,
    bio = :bio
WHERE id = :id
";

	$stmt = $conn->prepare($sql);

	$stmt->bindParam(':id', $_POST['id']);
	$stmt->bindParam(':name', $name);
	$stmt->bindParam(':country_id', $country_id);
	$stmt->bindParam(':state_id', $state_id);
	$stmt->bindParam(':city_id', $city_id);
	$stmt->bindParam(':contact', $contact);
	$stmt->bindParam(':zipcode', $zipcode);
	$stmt->bindParam(':store_name', $store_name);
	$stmt->bindParam(':category_id', $category_id);
	$stmt->bindParam(':desc_1', $desc_1);
	$stmt->bindParam(':desc_2', $desc_2);
	$stmt->bindParam(':delivery_status', $delivery_status);
	$stmt->bindParam(':discount_id', $discount_id);
	$stmt->bindParam(':end_date', $end_date);
	$stmt->bindParam(':status', $status);
	$stmt->bindParam(':reason', $reason);
	$stmt->bindParam(':insta_link', $insta_link);
	$stmt->bindParam(':yt_link', $yt_link);
	$stmt->bindParam(':fb_link', $fb_link);
	$stmt->bindParam(':website_link', $website_link);
	$stmt->bindParam(':bio', $bio);

	$stmt->execute();

	$insert_id = $_POST['id'];
	$month = $user->getField($plan_id, 'subscription', 'month');
	$end_date = date('Y-m-d', strtotime("+$month months", strtotime(date("Y-m-d"))));

	if ($imgFile) {
		$upload_dir = '../vendor/profile/'; // upload directory

		$imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

		// valid image extensions
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

		// rename uploading image
		$userpic = 'Shopercity-' . time() . "." . $imgExt;

		// allow valid image file formats
		if (in_array($imgExt, $valid_extensions)) {
			// Check file size '5MB'
			if ($imgSize < 5000000) {
				move_uploaded_file($_FILES['image']['tmp_name'], '../vendor/profile/' . $userpic);
				//move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				$update_query = $conn->prepare("UPDATE vendor SET image=:image WHERE id='" . $insert_id . "'");
				$update_rec = $update_query->execute(array(':image' => $userpic));
				unlink('../vendor/profile/' . $old_image);
			} else {
				$errMSG = "Sorry, your file is too large.";
			}
		} else {
			$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		}
	}
	if ($imgFile1) {
		$upload_dir = '../vendor/banner/'; // upload directory

		$imgExt = strtolower(pathinfo($imgFile1, PATHINFO_EXTENSION)); // get image extension

		// valid image extensions
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

		// rename uploading image
		$userpic = 'Shopercity-' . time() . "." . $imgExt;

		// allow valid image file formats
		if (in_array($imgExt, $valid_extensions)) {
			// Check file size '5MB'
			if ($imgSize1 < 5000000) {
				move_uploaded_file($_FILES['banner']['tmp_name'], '../vendor/banner/' . $userpic);
				$update_query = $conn->prepare("UPDATE vendor SET banner=:image WHERE id='" . $insert_id . "'");
				$update_rec = $update_query->execute(array(':image' => $userpic));
				unlink('../vendor/banner/' . $old_banner);
			} else {
				$errMSG = "Sorry, your file is too large.";
			}
		} else {
			$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		}
	}
	$_SESSION['ins_msg'] = 'vendor updated successfully';
	header('location:user.php');
}
if (isset($_GET['name']) && $_GET['name'] == 'vendor' and $_GET['id'] != '') {
	$id = $_GET['id'];
	$update_query = $conn->prepare("DELETE FROM vendor WHERE id=:id");
	$update_record = $update_query->execute(array(
		':id' => $_GET['id']
	));

	if ($update_record) {
		$_SESSION['ins_msg'] = 'vendor Delete successfully';
		header('location:user.php');
	}
}

//product
if (isset($_POST['product']) && $_POST['product'] == 'Save') {
	$name = $_POST['name'];
	if ($user->getBrandName($_POST['brand_id']) > 0) {
		$brand_id = $user->getBrandId($_POST['brand_id']);
	} else {
		$iquery = $conn->prepare("INSERT INTO brand (name,created_by) VALUES (:name,:created_by)");
		$irecord = $iquery->execute(array(
			':name' => $_POST['brand_id'],
			':created_by' => date("Y-m-d H:i:s")
		));
		$brand_id = $conn->lastInsertId();
	}
	$youtube_link = $_POST['youtube_link'];
	$discount_id = $_POST['discount_id'];
	$category_id = $_POST['category_id'];
	$price = $_POST['price'];
	$sale_price = $_POST['sale_price'];

	$vendor_id = $_POST['vendor_id'];
	$city_id = $user->getField($_POST['vendor_id'], 'vendor', 'city_id');
	$exp_date = $_POST['exp_date'];
	$contact = $_POST['contact'];
	$short_description = $_POST['short_description'];
	$description = $_POST['description'];

	$imgFile = $_FILES['image']['name'];
	$tmp_dir = $_FILES['image']['tmp_name'];
	$imgSize = $_FILES['image']['size'];

	$insert_query = $conn->prepare("INSERT INTO product (name,category_id,price,sale_price,brand_id,vendor_id,exp_date,contact,short_description,description,created_by,discount_id,city_id,youtube_link) VALUES (:name,:category_id,:price,:sale_price,:brand_id,:vendor_id,:exp_date,:contact,:short_description,:description,:created_by,:discount_id,:city_id,:youtube_link)");
	$insert_record = $insert_query->execute(array(
		':name' => $name,
		':created_by' => date("Y-m-d H:i:s"),
		':category_id' => $category_id,
		':price' => $price,
		':sale_price' => $sale_price,
		':brand_id' => $brand_id,
		':vendor_id' => $vendor_id,
		':exp_date' => $exp_date,
		':contact' => $contact,
		':short_description' => $short_description,
		':description' => $description,
		':discount_id' => $discount_id,
		':city_id' => $city_id,
		':youtube_link' => $youtube_link
	));
	$insert_id = $conn->lastInsertId();
	for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
		$imgFile1 = $_FILES['images']['name'][$i];
		$tmp_dir1 = $_FILES['images']['tmp_name'][$i];
		$imgSize1 = $_FILES['images']['size'][$i];
		$insert_query1 = $conn->prepare("INSERT INTO product_gallery (product_id,created_by) VALUES (:product_id,:created_by)");
		$insert_record1 = $insert_query1->execute(array(
			':product_id' => $insert_id,
			':created_by' => date("Y-m-d H:i:s")
		));
		$insert_id1 = $conn->lastInsertId();

		if ($imgFile1) {
			$upload_dir = DIR . 'product/images/'; // upload directory

			$imgExt = strtolower(pathinfo($imgFile1, PATHINFO_EXTENSION)); // get image extension

			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

			// rename uploading image
			$userpic = 'Shopercity-' . $insert_id1 . date("Ymdhis") . "." . $imgExt;

			// allow valid image file formats
			if (in_array($imgExt, $valid_extensions)) {
				// Check file size '5MB'
				if ($imgSize1 < 5000000) {
					move_uploaded_file($tmp_dir1, $upload_dir . $userpic);
					$update_query = $conn->prepare("UPDATE product_gallery SET image=:image WHERE id='" . $insert_id1 . "'");
					$update_rec = $update_query->execute(array(':image' => $userpic));
				} else {
					$errMSG = "Sorry, your file is too large.";
				}
			} else {
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			}
		}
	}
	if ($imgFile) {
		$upload_dir = DIR . 'product/'; // upload directory

		$imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

		// valid image extensions
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

		// rename uploading image
		$userpic = 'Shopercity-' . $insert_id . "." . $imgExt;

		// allow valid image file formats
		if (in_array($imgExt, $valid_extensions)) {
			// Check file size '5MB'
			if ($imgSize < 5000000) {
				move_uploaded_file($tmp_dir, $upload_dir . $userpic);
				$update_query = $conn->prepare("UPDATE product SET image=:image WHERE id='" . $insert_id . "'");
				$update_rec = $update_query->execute(array(':image' => $userpic));
			} else {
				$errMSG = "Sorry, your file is too large.";
			}
		} else {
			$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		}
	}
	if ($insert_record) {
		$_SESSION['ins_msg'] = 'product added successfully';
		header('location:add-product.php');
	}
}
if (isset($_POST['product']) && $_POST['product'] == 'Update') {
	$name = $_POST['name'];
	if ($user->getBrandName($_POST['brand_id']) > 0) {
		$brand_id = $user->getBrandId($_POST['brand_id']);
	} else {
		$iquery = $conn->prepare("INSERT INTO brand (name,created_by) VALUES (:name,:created_by)");
		$irecord = $iquery->execute(array(
			':name' => $_POST['brand_id'],
			':created_by' => date("Y-m-d H:i:s")
		));
		$brand_id = $conn->lastInsertId();
	}
	$youtube_link = $_POST['youtube_link'];
	$category_id = $_POST['category_id'];
	$discount_id = $_POST['discount_id'];
	$price = $_POST['price'];
	$sale_price = $_POST['sale_price'];
	$vendor_id = $_POST['vendor_id'];
	$city_id = $user->getField($_POST['vendor_id'], 'vendor', 'city_id');
	$exp_date = $_POST['exp_date'];
	$contact = $_POST['contact'];
	$short_description = $_POST['short_description'];
	$description = $_POST['description'];

	$imgFile = $_FILES['image']['name'];
	$tmp_dir = $_FILES['image']['tmp_name'];
	$imgSize = $_FILES['image']['size'];

	$update_query = $conn->prepare("UPDATE product SET name=:name,category_id=:category_id,city_id=:city_id, price=:price, sale_price=:sale_price, brand_id=:brand_id, vendor_id=:vendor_id, exp_date=:exp_date, contact=:contact, short_description=:short_description, description=:description, modified_by=:modified_by, discount_id=:discount_id,youtube_link=:youtube_link WHERE id=:id");
	$update_record = $update_query->execute(array(
		':id' => $_POST['id'],
		':modified_by' => date("Y-m-d H:i:s"),
		':name' => $name,
		':category_id' => $category_id,
		':price' => $price,
		':sale_price' => $sale_price,
		':brand_id' => $brand_id,
		':vendor_id' => $vendor_id,
		':exp_date' => $exp_date,
		':contact' => $contact,
		':short_description' => $short_description,
		':description' => $description,
		':discount_id' => $discount_id,
		':city_id' => $city_id,
		':youtube_link' => $youtube_link
	));
	$insert_id = $_POST['id'];
	for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
		$imgFile1 = $_FILES['images']['name'][$i];
		$tmp_dir1 = $_FILES['images']['tmp_name'][$i];
		$imgSize1 = $_FILES['images']['size'][$i];

		$insert_query1 = $conn->prepare("INSERT INTO product_gallery (product_id,created_by) VALUES (:product_id,:created_by)");
		$insert_record1 = $insert_query1->execute(array(
			':product_id' => $insert_id,
			':created_by' => date("Y-m-d H:i:s")
		));
		$insert_id1 = $conn->lastInsertId();

		if ($imgFile1) {
			$upload_dir = DIR . 'product/images/'; // upload directory

			$imgExt = strtolower(pathinfo($imgFile1, PATHINFO_EXTENSION)); // get image extension

			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

			// rename uploading image
			$userpic = 'Shopercity-' . $insert_id1 . date("Ymdhis") . "." . $imgExt;

			// allow valid image file formats
			if (in_array($imgExt, $valid_extensions)) {
				// Check file size '5MB'
				if ($imgSize1 < 5000000) {
					move_uploaded_file($tmp_dir1, $upload_dir . $userpic);
					$update_query = $conn->prepare("UPDATE product_gallery SET image=:image WHERE id='" . $insert_id1 . "'");
					$update_rec = $update_query->execute(array(':image' => $userpic));
				} else {
					$errMSG = "Sorry, your file is too large.";
				}
			} else {
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			}
		}
	}
	if ($imgFile) {
		$upload_dir = DIR . 'product/profile/'; // upload directory

		$imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

		// valid image extensions
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

		// rename uploading image
		$userpic = 'Shopercity-' . $insert_id . "." . $imgExt;

		// allow valid image file formats
		if (in_array($imgExt, $valid_extensions)) {
			// Check file size '5MB'
			if ($imgSize < 5000000) {
				move_uploaded_file($tmp_dir, $upload_dir . $userpic);
				$update_query = $conn->prepare("UPDATE product SET image=:image WHERE id='" . $insert_id . "'");
				$update_rec = $update_query->execute(array(':image' => $userpic));
			} else {
				$errMSG = "Sorry, your file is too large.";
			}
		} else {
			$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		}
	}
	if ($update_record) {
		$_SESSION['ins_msg'] = 'product updated successfully';
		header('location:product.php');
	}
}
if (isset($_GET['name']) && $_GET['name'] == 'product' and $_GET['id'] != '') {
	$id = $_GET['id'];
	$update_query = $conn->prepare("DELETE FROM product WHERE id=:id");
	$update_record = $update_query->execute(array(
		':id' => $_GET['id']
	));

	if ($update_record) {
		$_SESSION['ins_msg'] = 'product Delete successfully';
		header('location:product.php');
	}
}
