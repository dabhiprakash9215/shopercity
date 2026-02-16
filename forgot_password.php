<?php 
	$referral_id = "";
	if($_GET){
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
    </head>
    <body>
        <div class="page-wrapper">
            <?php 
            require_once "include/header.php";
			if(isset($_SESSION) && isset($_SESSION['user_id'])){
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
                                            <a class="nav-link border-no lh-1 ls-normal active" href="#signin">Forgot Password</a>
                                        </li>                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="signin">
                                            <form action="db/forgot_password_db.php" method="post">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" id="singin-email" name="email" placeholder="Email Address *" required />
                                                </div>
                                                <button class="btn btn-dark btn-block btn-rounded" type="submit" name="forgot">Send reset password</button>
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
