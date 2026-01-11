<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            require_once "include/header_script.php";
        ?>
    </head>
    <body>
        <div class="page-wrapper">
            <?php 
                require_once "include/header.php";
            ?>

            <main class="main">
                <div class="page-content">
                    <section class="error-section d-flex flex-column justify-content-center align-items-center text-center pl-3 pr-3">
                        <h1 class="mb-2 ls-m">Error 404</h1>
                        <img src="images/subpages/404.png" alt="error 404" width="609" height="131" />
                        <h4 class="mt-7 mb-0 ls-m text-uppercase">Ooopps.! That page can’t be found.</h4>
                        <p class="text-grey font-primary ls-m">It looks like nothing was found at this location.</p>
                        <a href="demo1.html" class="btn btn-primary btn-rounded mb-4">Go home</a>
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

        <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

        <script src="js/main.min.js"></script>
    </body>
</html>
