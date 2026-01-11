<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");

if (isset($_POST['search'])) {
    $search_term = $_POST['search'];
    // Redirect to search-results.php with the search term as a URL parameter
    header("Location: vendor.php?search=$search_term");
    exit(); // Ensure that no further code is executed after the redirect
}
?>
<div class="row d-flex flex-column align-items-end w-100" style="position: absolute; z-index: 10;">
</div>

<header class="header header-border">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <p class="welcome-msg">Welcome to ShoperCity </p>
            </div>
            <div class="header-right">
                <span class="divider"></span>
                <a href="contact-us.php" class="contact d-lg-show"><i class="d-icon-map"></i>Contact</a>
                <a href="javascript:void(0)" class="help d-lg-show"><i class="d-icon-info"></i> Need Help</a>
                <?php
                if (isset($_SESSION)) {
                    if (empty($_SESSION['user_id']) && empty($_SESSION['email'])) {
                ?>
                        <a class="help" href="login.php"><i class="d-icon-user"></i>Sign in</a>
                    <?php } else { ?>
                        <a class="help ml-4" href="db/logout.php">logout</a>
                <?php }
                } ?>
            </div>
        </div>
    </div>

    <div class="header-middle sticky-header fix-top sticky-content">
        <div class="container">
            <div class="header-left">
                <a href="#" class="mobile-menu-toggle">
                    <i class="d-icon-bars2"></i>
                </a>
                <a href="index.php" class="logo">
                    <img src="assets/images/logo.png" alt="logo" width="100" height="44" />
                </a>

                <div class="header-search hs-simple">
                    <form action="" method="post" class="input-wrapper">
                        <input type="text" class="form-control" name="search" autocomplete="off" placeholder="Search..."
                            required />
                        <button class="btn btn-search" type="submit">
                            <i class="d-icon-search"></i>
                        </button>
                    </form>
                </div>

            </div>
            <div class="header-right main-contact-now-icon">
                <!-- <a href="tel:919265744500" class="icon-box icon-box-side">
                    <div class="icon-box-icon mr-0 mr-lg-2">
                        <i class="d-icon-phone"></i>
                    </div>
                    <div class="icon-box-content d-lg-show">
                        <p>+91 92657 44500</p>
                        <h4 class="icon-box-title">Call Us Now:</h4>
                    </div>
                </a> -->
                <div class="header-search hs-toggle mobile-search">
                    <a href="#" class="search-toggle">
                        <i class="d-icon-search"></i>
                    </a>
                    <form action="db/search_db.php" method="get" class="input-wrapper">
                        <input type="text" class="form-control" name="search" autocomplete="off"
                            placeholder="Search your keyword..." required />
                        <button class="btn btn-search" name='submit' type="submit">
                            <i class="d-icon-search"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="header-bottom d-lg-show">
        <div class="container">
            <div class="header-left">
                <nav class="main-nav">
                    <ul class="menu">
                        <li class="<?php if ($activePage == 'index') {
                                        echo "active";
                                    } ?>">
                            <a href="index.php">Home</a>
                        </li>
                        <?php
                        if (isset($_SESSION['is_active']) && $_SESSION['is_active'] != 1) { ?>
                            <li class="<?php if ($activePage == 'plan') {
                                            echo "active";
                                        } ?>">
                                <a href="plan.php">Plan</a>
                            </li>
                        <?php } else if (!isset($_SESSION['is_active'])) {
                        ?>
                            <li>
                                <a href="plan.php">Plan</a>
                            </li>
                        <?php
                        } ?>
                        <li class="<?php if ($activePage == 'about') {
                                        echo "active";
                                    } ?>">
                            <a href="about.php">About</a>
                        </li>
                        <?php
                        if (isset($_SESSION)) {
                            if (!empty($_SESSION['user_id'])) {
                        ?>
                                <li class="<?php if ($activePage == 'account') {
                                                echo "active";
                                            } ?>">
                                    <a href="account.php">Account</a>
                                </li>
                        <?php
                            }
                        }
                        ?>
                        <li class="<?php if ($activePage == 'contact-us') {
                                        echo "active";
                                    } ?>">
                            <a href="contact-us.php">Contact Us</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="header-right">
                <a href="#"><i class="d-icon-card"></i>Special Offers</a>
            </div>
        </div>
    </div>
</header>