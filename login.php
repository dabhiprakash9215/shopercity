<?php
$referral_id = "";
if ($_GET) {
    $referral_id    =   $_GET['ref_id'];
}

?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <?php
    require_once "include/header_script.php";
    ?>
    <style>
        .main-contact-now-icon {
            display: none;
        }

        header .header-left .logo {
            margin: 0px;
        }

        header .header-left {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <?php
        require_once "include/header.php";
        if (isset($_SESSION) && isset($_SESSION['user_id'])) {
            header('location: index.php');
        }
        ?>
        <main class="main">
            <div class="page-content mt-6 pb-2 mb-10">
                <div class="container">
                    <div class="login-popup">
                        <div class="form-box">
                            <div class="tab tab-nav-simple tab-nav-boxed form-tab">
                                <ul class="nav nav-tabs nav-fill align-items-center border-no justify-content-center mb-5" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link border-no lh-1 ls-normal active" href="#signin">Login</a>
                                    </li>
                                    <li class="delimiter">or</li>
                                    <li class="nav-item">
                                        <a class="nav-link border-no lh-1 ls-normal" href="#register">Register</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="signin">
                                        <form action="db/login_db.php" method="post">
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" id="singin-email" name="email" placeholder="Email Address *" required />
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" id="singin-password" name="password" placeholder="Password *"
                                                    required />
                                            </div>
                                            <div class="form-footer">
                                                <div class="form-checkbox">
                                                    <input type="checkbox" class="custom-checkbox" id="signin-remember"
                                                        name="signin-remember" />
                                                    <label class="form-control-label" for="signin-remember">Remember me</label>
                                                </div>
                                            </div>
                                            <button class="btn btn-dark btn-block btn-rounded" type="submit">Login</button>
                                            <a href="forgot-password.php" class="text-black mt-2" style="font-size: 13px;">Forgot Password?</a>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="register">
                                        <form action="db/signup_db.php" method="post" onsubmit="">
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" id="register-first-name" name="register-first-name" placeholder="Your first name *"
                                                    required />
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" id="register-mobile-number" name="register-mobile-number" placeholder="Your Mobile number*"
                                                    required />
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="email" class="form-control" id="register-email" name="register-email" placeholder="Your Email Address *"
                                                    required />
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" id="register-password" name="register-password" placeholder="Password *"
                                                    required />
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="register-referral" name="register-referral" value="<?php echo $referral_id; ?>" placeholder="Agency Code*"
                                                    required />
                                            </div>
                                            <div class="form-footer">
                                                <div class="form-checkbox">
                                                    <input type="checkbox" class="custom-checkbox" id="register-agree" name="register-agree"
                                                        required />
                                                    <label class="form-control-label" for="register-agree">I agree to the
                                                        privacy policy</label>
                                                </div>
                                            </div>
                                            <button class="btn btn-dark btn-block btn-rounded" name="register" type="submit" onclick="signUp()">Register</button>
                                            <a href="forgot-password.php" class="text-black mt-2" style="font-size: 13px;">Forgot Password?</a>
                                        </form>
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

    <a id="scroll-top" href="#top" title="Top" role="button" class="scroll-top"><i class="d-icon-arrow-up"></i></a>
    <?php
    require_once "include/mobile-menu.php";
    ?>
    <?php
    require_once "include/footer_script.php";
    ?>
</body>

</html>