<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <?php
    require_once "include/header_script.php";
    function displayImage($imagePath, $defaultImage)
    {
        if (file_exists($imagePath)) {
            return $imagePath;
        } else {
            return $defaultImage;
        }
    }
    ?>
</head>

<body>
    <div class="page-wrapper">
        <?php
        require_once "include/header.php";
        // if (isset($_SESSION) && !isset($_SESSION['user_id'])) {
        //     $_SESSION['error_msg'] = "Please Login First After View Vendor";
        //     header("location: login.php");
        // }
        ?>
        <main class="main">
            <div class="page-header !max-h-[90px] sm:!max-h-[170px]" style="background-image: url('images/shop/page-header-back1.jpg'); background-color: #3c63a4;">
                <h3 class="page-subtitle"></h3>
                <!-- <h1 class="page-title">vendor </h1> -->
                <ul class="breadcrumb">
                    <li>
                        <a href="index.php"><i class="d-icon-home"></i>Home</a>
                    </li>
                    <li class="delimiter">/</li>
                    <li><?php
                        if (isset($_GET['cat_id']) and !empty($_GET['cat_id'])) {
                            $id = $_GET['cat_id'];
                            $qry1 = "SELECT name FROM category WHERE id=$id";
                            $res1 = mysqli_query($conn, $qry1);
                            $row2 = mysqli_fetch_array($res1);
                            echo $row2['name'];
                        } else {
                            echo "vendor";
                        } ?> </li>
                </ul>
            </div>

            <div class="mb-10 py-6 container">
                <div class="flex flex-wrap gap-8 mb-4">
                    <?php
                    print_r($_SESSION['city_id']);
                    die;
                    if (isset($_GET["cat_id"])) {
                        $get_catId  =   $_GET["cat_id"];

                        $get_catId = (int) $get_catId; // safety

                        $conditions = [];
                        $conditions[] = "category_id = $get_catId";
                        $conditions[] = "status = 2";

                        // city filter ONLY if session has city_id
                        if (!empty($_SESSION['city_id'])) {
                            $city_id = (int) $_SESSION['city_id'];
                            $conditions[] = "city_id = $city_id";
                        }
                        $qry = "SELECT id, store_name, city_id, image, discount_id, street FROM vendor WHERE  " . implode(' AND ', $conditions);
                        $res = mysqli_query($conn, $qry);
                        if (mysqli_num_rows($res) > 0) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $like = "";
                    ?>


                                <div class="relative w-full md:w-1/2 lg:w-1/3 min-h-[13rem] flex gap-4 border border-gray-300 rounded-2xl hover:shadow-lg bg-white overflow-hidden transition-all duration-300">
                                    <!-- Image Section -->
                                    <div class="relative aspect-square w-52 !aspect-3/4 overflow-hidden object-cover rounded-l-2xl">
                                        <img src="<?php echo displayImage("vendor/profile/" . $row['image'], 'images/images.png'); ?>" alt="product"
                                            class="w-full h-full object-cover" style="height:100% !important" />
                                        <div class="absolute top-2 left-2">
                                            <span class="bg-[#2266cc] text-white text-sm px-2 py-1 rounded-md">New</span>
                                        </div>
                                    </div>

                                    <!-- Content Section -->
                                    <div class="flex flex-col justify-between p-4 flex-1">
                                        <div class="flex flex-col">
                                            <div class="text-[2rem] font-semibold text-gray-800 hover:text-[#2266cc] transition-colors duration-200">
                                                <a href="single-product.php?shop_id=<?php echo $row['id']; ?>&cat_id=<?php echo $_GET['cat_id']; ?>">
                                                    <?php echo $row['store_name']; ?>
                                                </a>
                                            </div>
                                            <a href="single-product.php?shop_id=<?php echo $row['id']; ?>&cat_id=<?php echo $_GET['cat_id']; ?>">
                                                <i class="d-icon-map-marker"></i> </i> <?php echo $row['street'] . ' ' . $row['city_id']; ?>
                                            </a>
                                        </div>
                                        <div class="mt-4 bg-[#2266cc] text-white p-2 rounded-lg text-center">
                                            <a href="single-product.php?shop_id=<?php echo $row['id']; ?>&cat_id=<?php echo $_GET['cat_id']; ?>">
                                                <?php if (!empty($row['discount_id'])) { ?>
                                                    <i class="fas fa-tag"></i>
                                                    <a href="single-product.php?shop_id=<?php echo $row['id']; ?>&cat_id=<?php echo $_GET['cat_id']; ?>">
                                                        <?php
                                                        $qry2 = "SELECT name FROM discount WHERE id =" . $row['discount_id'] . "";
                                                        $res2 = mysqli_query($conn, $qry2);
                                                        $discount = mysqli_fetch_array($res2);
                                                        echo $discount['name'];
                                                        ?>
                                                    </a>
                                                <?php } ?>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                                <?php
                            }
                        } else {
                            echo "<h4>No Any Vendor Available...<h4>";
                        }
                    } else {
                        if (isset($_GET["search"])) {
                            $row = "";
                            $search_term = $_GET['search'];
                            $search_term = mysqli_real_escape_string($conn, $search_term); // Ensure safe input
                            $query = "SELECT v.*, s.name as state_name
                                                    FROM `vendor` v
                                                    LEFT JOIN `state` s ON v.state_id = s.id
                                                    WHERE v.`name` LIKE '%$search_term%'
                                                    OR v.`store_name` LIKE '%$search_term%'
                                                    OR v.`city_id` LIKE '%$search_term%'
                                                    OR s.`name` LIKE '%$search_term%'
                                                    ORDER BY v.`name` ASC";
                            $result = mysqli_query($conn, $query);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <div class="relative w-full md:w-1/2 lg:w-1/3 min-h-[13rem] flex gap-4 border border-gray-300 rounded-2xl hover:shadow-lg bg-white overflow-hidden transition-all duration-300">
                                        <!-- Image Section -->
                                        <div class="relative aspect-square w-52 overflow-hidden rounded-l-2xl">
                                            <img src="<?php echo displayImage("vendor/profile/" . $row['image'], 'images/images.png'); ?>" alt="product"
                                                class="w-full h-full object-cover" />
                                            <div class="absolute top-2 left-2">
                                                <span class="bg-[#2266cc] text-white text-sm px-2 py-1 rounded-md">New</span>
                                            </div>
                                        </div>

                                        <!-- Content Section -->
                                        <div class="flex flex-col justify-between p-4 flex-1">
                                            <div class="flex flex-col">
                                                <div class="text-[2.5rem] font-semibold text-gray-800 hover:text-[#2266cc] transition-colors duration-200">
                                                    <a href="single-product.php?shop_id=<?php echo $row['id']; ?>">
                                                        <?php echo $row['store_name']; ?>
                                                    </a>
                                                </div>


                                                <a href="single-product.php?shop_id=<?php echo $row['id']; ?>">
                                                    <i class="d-icon-map-marker"></i> </i> <?php echo $row['street'] . ' ' . $row['city_id']; ?>
                                                </a>

                                            </div>





                                            <div class="mt-4 bg-[#2266cc] text-white p-2 rounded-lg text-center">
                                                <a href="single-product.php?shop_id=<?php echo $row['id']; ?>">
                                                    <?php if (!empty($row['discount_id'])) { ?>
                                                        <i class="fas fa-tag"></i>
                                                        <a href="single-product.php?shop_id=<?php echo $row['id']; ?>">
                                                            <?php
                                                            $qry2 = "SELECT name FROM discount WHERE id =" . $row['discount_id'] . "";
                                                            $res2 = mysqli_query($conn, $qry2);
                                                            $discount = mysqli_fetch_array($res2);
                                                            echo $discount['name'];
                                                            ?>
                                                        </a>

                                                    <?php } ?>

                                                </a>
                                            </div>
                                        </div>
                                    </div>


                    <?php }
                            } else {
                                echo "<h4>No Any Vendor Available...<h4>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </main>

        <?php
        require_once "include/footer.php";
        ?>
    </div>
    <?php
    require_once "include/mobile-menu.php";
    require_once "include/footer_script.php";
    ?>
</body>

</html>