<?php
if (isset ($_GET)) {
    $_SESSION['success_msg'] = "Payment is Faild.";
    header("Location: plan.php");
}
?>