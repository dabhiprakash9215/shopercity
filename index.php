<?php
// require_once "db/connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <?php
    require_once "include/header_script.php";
    ?>
    <link rel="stylesheet" type="text/css" href="vendor/magnific-popup/magnific-popup.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="css/demo1.min.css">
</head>
<body class="home">
    <div class="page-wrapper">
        <h1 class="d-none"></h1>
        <?php
        require_once "include/header.php";
        ?>
        <main class="main">
            <div class="page-content">
                <section class="intro-section">
                    <div class="owl-carousel owl-theme row owl-dot-inner owl-dot-white intro-slider animation-slider cols-1 gutter-no"
                        data-owl-options="{
                        'nav': false,
                        'dots': true,
                        'loop': false,
                        'items': 1,
                        'autoplay': false,
                        'autoplayTimeout': 8000
                    }">
                        <div class="banner banner-fixed intro-slide1" style="background-color: #46b2e8;">
                            <figure>
                                <img src="images/demos/demo1/slides/slide1.jpg" alt="intro-banner" width="1903"
                                    height="630" style="background-color: #34ace5;" />
                            </figure>
                            <div class="container">
                                <div class="banner-content y-50">
                                    <h4 class="banner-subtitle font-weight-bold ls-l">
                                        <span class="d-inline-block slide-animate"
                                            data-animation-options="{'name': 'fadeInRightShorter', 'duration': '1s', 'delay': '.2s'}">Buy
                                            2 Get</span>
                                        <span class="d-inline-block label-star bg-white text-primary slide-animate"
                                            data-animation-options="{'name': 'fadeInRightShorter', 'duration': '1s', 'delay': '.4s'}">1
                                            Free</span>
                                    </h4>
                                    <h2 class="banner-title font-weight-bold text-white lh-1 ls-md slide-animate"
                                        data-animation-options="{'name': 'fadeInUpShorter', 'duration': '1.2s', 'delay': '1s'}">
                                        Exiting Offers And</h2>
                                    <h3 class="font-weight-normal lh-1 ls-l text-white slide-animate"
                                        data-animation-options="{'name': 'fadeInUpShorter', 'duration': '1.2s', 'delay': '1s'}">
                                        Discount</h3>
                                </div>
                            </div>
                        </div>
                        <div class="banner banner-fixed intro-slide2" style="background-color: #dddee0;">
                            <figure>
                                <img src="images/demos/demo1/slides/slide2.jpg" alt="intro-banner" width="1903"
                                    height="630" style="background-color: #d8d9d9;" />
                            </figure>
                            <div class="container">
                                <div class="banner-content y-50 ml-auto text-right">
                                    <h2 class="banner-title mb-2 d-inline-block font-weight-bold text-primary slide-animate"
                                        data-animation-options="{'name': 'fadeInRight', 'duration': '1.2s', 'delay': '.5s'}">
                                        Sale</h2>
                                </div>
                            </div>
                        </div>
                        <div class="banner banner-fixed video-banner intro-slide3" style="background-color: #dddee0;">
                            <figure>
                                <video src="video/memory-of-a-woman.mp4" width="1903" height="630"></video>
                            </figure>
                            <div class="container">
                                <div class="banner-content x-50 y-50 text-center">
                                    <h4 class="banner-subtitle text-white text-uppercase mb-3 ls-normal slide-animate"
                                        data-animation-options="{'name': 'fadeIn', 'duration': '.7s'}">Check out our
                                    </h4>
                                    <h2 class="banner-title mb-3 text-white font-weight-bold text-uppercase ls-m slide-animate"
                                        data-animation-options="{'name': 'fadeInUp', 'duration': '.7s', 'delay': '.5s'}">
                                        Season's Local Schemes</h2>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container mt-6 appear-animate">
                        <div class="service-list">
                            <div class="owl-carousel owl-theme row cols-lg-3 cols-sm-2 cols-1" data-owl-options="{
                                    'items': 3,
                                    'nav': false,
                                    'dots': false,
                                    'loop': true,
                                    'autoplay': false,
                                    'autoplayTimeout': 5000,
                                    'responsive': {
                                        '0': {
                                            'items': 1
                                        },
                                        '576': {
                                            'items': 2
                                        },
                                        '768': {
                                            'items': 3,
                                            'loop': false
                                        }
                                    }
                                }">
                                <div class="icon-box icon-box-side icon-box1 appear-animate" data-animation-options="{
                                        'name': 'fadeInRightShorter',
                                        'delay': '.3s'
                                    }">
                                    <i class="icon-box-icon d-icon-truck"></i>
                                    <div class="icon-box-content">
                                        <h4 class="icon-box-title text-capitalize ls-normal lh-1">Hassle Free  Services
                                        </h4>
                                        <p class="ls-s lh-1">Access All Local Platforms</p>
                                    </div>
                                </div>
                                <div class="icon-box icon-box-side icon-box2 appear-animate" data-animation-options="{
                                        'name': 'fadeInRightShorter',
                                        'delay': '.4s'
                                    }">
                                    <i class="icon-box-icon d-icon-service"></i>
                                    <div class="icon-box-content">
                                        <h4 class="icon-box-title text-capitalize ls-normal lh-1">Customer Support 24/7
                                        </h4>
                                        <p class="ls-s lh-1">Instant access to perfect support</p>
                                    </div>
                                </div>
                                <div class="icon-box icon-box-side icon-box3 appear-animate" data-animation-options="{
                                        'name': 'fadeInRightShorter',
                                        'delay': '.5s'
                                    }">
                                    <i class="icon-box-icon d-icon-secure"></i>
                                    <div class="icon-box-content">
                                        <h4 class="icon-box-title text-capitalize ls-normal lh-1">100% Secure Payment
                                        </h4>
                                        <p class="ls-s lh-1">We ensure secure payment!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="mt-7 appear-animate" data-animation-options="{'delay': '.3s'}">
                    <div class="container">
                        <h2 class="title title-center mb-5">Our Categories</h2>
                        <div class="row">
                            <?php
                            $qry = "SELECT * FROM category";
                            $res = mysqli_query($conn, $qry);
                            if (mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_array($res)) {
                                    ?>
                                    <div class="col-xs-6 col-lg-3 mb-4">
                                        <div class="category category-default1 category-absolute banner-radius overlay-zoom">
                                            <a href="vendor.php?cat_id=<?php echo 
                                            $row['id']; ?>">
                                                <figure class="category-media">
                                                    <img src="category/<?php echo $row['image']; ?>" alt="category" style="height: 400px !important; display: block; width: 100%; object-fit: cover; margin-left: auto; margin-right: auto;" width="280"
                                                        height="280" style="background-color: #8c8c8d;" />
                                                </figure>
                                            </a>
                                            <div class="category-content">
                                                <h4 class="category-name font-weight-bold ls-l"><a
                                                        href="vendor.php?cat_id=<?php echo $row['id']; ?>">
                                                        <?php echo $row['name']; ?>
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "No results found.";
                            }

                            ?>
                        </div>
                    </div>
            </div>
            </section>
            <section class="banner banner-background parallax text-center" data-option="{'offset': -60}"
                data-image-src="images/demos/demo1/parallax.jpg" style="background-color: #2d2f33;">
                <div class="container">
                    <div class="banner-content appear-animate"
                        data-animation-options="{'name': 'blurIn', 'duration': '1s', 'delay': '.2s'}">
                        <h4 class="banner-subtitle text-white font-weight-bold ls-l">
                            Welcom To <span class="d-inline-block label-star bg-dark text-primary ml-4 mr-2">
                                Start</span>Earning Now
                        </h4>
                        <!-- <h3 class="banner-title font-weight-bold text-white">Summer Season Sale</h3> -->
                        <!-- <p class="text-white ls-s">Free shipping on orders over $99</p> -->
                        <a href="plan.php" class="btn btn-primary btn-rounded btn-icon-right">Start Earning Now<i
                                class="d-icon-arrow-right"></i></a>
                    </div>
                </div>
            </section>
    </div>
    </main>

    <?php
    require_once "include/footer.php";
    ?>

    </div>

    <?php
    require_once "include/mobile-menu.php";
    ?>

    <!-- 
    <div class="newsletter-popup newsletter-pop1 mfp-hide" id="newsletter-popup"
        style="background-image: url(images/newsletter-popup.jpg)">
        <div class="newsletter-content">
            <h4 class="text-uppercase text-dark">Up to <span class="text-primary">20% Off</span></h4>
            <h2 class="font-weight-semi-bold">Sign up to <span>RIODE</span></h2>
            <p class="text-grey">Subscribe to the Riode eCommerce newsletter to receive timely updates from your
                favorite
                products.</p>
            <form action="#" method="get" class="input-wrapper input-wrapper-inline input-wrapper-round">
                <input type="email" class="form-control email" name="email" id="email2"
                    placeholder="Email address here..." required>
                <button class="btn btn-dark" type="submit">SUBMIT</button>
            </form>
            <div class="form-checkbox justify-content-center">
                <input type="checkbox" class="custom-checkbox" id="hide-newsletter-popup" name="hide-newsletter-popup"
                    required />
                <label for="hide-newsletter-popup">Don't show this popup again</label>
            </div>
        </div>
    </div> -->

    <?php
    require_once "include/footer_script.php";
    ?>
</body>

<!-- Mirrored from d-themes.com/html/riode/demo1.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 17 Feb 2024 11:32:42 GMT -->

</html>