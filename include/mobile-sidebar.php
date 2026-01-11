<?php
if (isset($_POST['search'])) {
    $search_term = $_POST['search'];
    // Redirect to vendor.php with the search term as a URL parameter
    header("Location: vendor.php?search=" . urlencode($search_term));
    exit(); // Ensure that no further code is executed after the redirect
}
?>
<div class="mobile-menu-wrapper">
    <div class="mobile-menu-overlay">
    </div>
    <a class="mobile-menu-close" href="#"><i class="d-icon-times"></i></a>
    <div class="mobile-menu-container scrollable">
        <form action="" method="post" class="input-wrapper">
            <input type="text" class="form-control" name="search" autocomplete="off"
                placeholder="Search your keyword..." required />
            <button class="btn btn-search" type="submit" title="submit-button">
                <i class="d-icon-search"></i>
            </button>
        </form>
        <ul class="mobile-menu mmenu-anim">
            <li class="<?php echo ($activePage == 'index') ? "active" : ""; ?>">
                <a href="index.php">Home</a>
            </li>
            <li class="<?php echo ($activePage == 'about') ? "active" : ""; ?>">
                <a href="about.php">About</a>
            </li>
            <?php
            // Check if $_SESSION['is_active'] is set and not equal to 1
            if (isset($_SESSION['is_active']) && $_SESSION['is_active'] != 1) {
                ?>
                <li class="<?php echo ($activePage == 'plan') ? "active" : ""; ?>">
                    <a href="plan.php">Plan</a>
                </li>
                <?php
            } elseif (!isset($_SESSION['is_active'])) {
                // If is_active is 1, still show the plan link, but the original code had it outside an <li> which is invalid HTML
                // Assuming it should be an active menu item if on the plan page
                ?>
                <li class="<?php echo ($activePage == 'plan') ? "active" : ""; ?>">
                    <a href="plan.php">Plan</a>
                </li>
                <?php
            }
            ?>

            <?php
            // Check if $_SESSION is set and user_id is not empty
            if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                ?>
                <li class="<?php echo ($activePage == 'account') ? "active" : ""; ?>">
                    <a href="account.php">Account</a>
                </li>
                <?php
            } else {
                ?>
                <li class="<?php echo ($activePage == 'login') ? "active" : ""; ?>">
                    <a href="login.php">Login</a>
                </li>
                <?php
            }
            ?>
            <li class="<?php echo ($activePage == 'contact-us') ? "active" : ""; ?>">
                <a href="contact-us.php">Contact Us</a>
            </li>
        </ul>
    </div>
</div>