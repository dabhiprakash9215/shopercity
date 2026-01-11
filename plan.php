<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <?php
    require_once "include/header_script.php";
    ?>
<style>
/* Basic Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Container for the Form Box */
.form-box {
    width: 100%;
    max-width: 500px;
    background-color: #ffffff; /* White background for the form box */
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    padding: 30px;
    text-align: center;
    background: linear-gradient(135deg, #e6e9f0 0%, #eef1f5 100%); /* Light blue-gray gradient */
}

/* Tab Navigation */
.tab-nav-simple {
    margin-bottom: 20px;
}

.nav-tabs {
    display: flex;
    gap: 10px;
}

.nav-item {
    list-style: none;
}

.nav-link {
    color: #333;
    font-weight: bold;
    font-size: 1rem;
    text-decoration: none;
    padding: 10px 20px;
    border: 1px solid transparent;
    border-radius: 20px;
    transition: background-color 0.3s, color 0.3s;
}

.nav-link:hover,
.nav-link.active {
    background-color: #007bff;
    color: #fff;
}

/* Tab Content */
.tab-content {
    padding: 20px 0;
}

.tab-pane h4,
.tab-pane h6 {
    margin-bottom: 15px;
    color: #333;
}

.tab-pane h4 {
    font-size: 2.4rem;
    font-weight: bold;
    color: #007bff;
}

.tab-pane h6 {
    font-size: 1.5rem;
    color: #555;
}

/* Buy Now Button */
	.header-search.hs-simple .btn-search {
    position: absolute;
    background: transparent;
    color: #333;
    min-width: 48px;
    height: 100%;
    border-radius: 5px;
    right: 0;
}
	.header-search .btn-search i {
    margin: 0 -47.9rem 0.6rem 0;
    vertical-align: middle;
    font-size: 2rem;
}
.btn {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    padding: 12px;
    font-size: 1.2rem;
    font-weight: bold;
    color: #fff;
    text-decoration: none;
    background-color: #007bff;
    border-radius: 30px;
    transition: background-color 0.3s;
    margin-top: 20px;
    font-family: 'Poppins', sans-serif;
}

.btn:hover {
    background-color: #0056b3;
}

.btn-blue {
    background-color: #007bff;
}

.btn-gradient {
    background: linear-gradient(45deg, #007bff, #0056b3);
}

.btn-rounded {
    border-radius: 30px;
}

#PayNow {
    width: auto;
    padding: 12px 24px;
}
.container>.login-popup {
    margin: 0 auto;
    box-shadow: 0 0 0px rgba(0,0,0,0.1);
}	
	

/* Responsive */
@media (max-width: 576px) {
    .form-box {
        padding: 20px;
    }
    
    .tab-pane h4 {
        font-size: 2.4rem;
    }

    .tab-pane h6 {
        font-size: 1.5rem;
    }
    
    .btn {
        font-size: 1rem;
    }
}


</style>
</head>

<body>
    <div class="page-wrapper">
        <?php
        require_once "include/header.php";
        ?>
        <main class="main">
            <div class="page-content mt-6 pb-2 mb-10">
                <div class="container">
                    <h3 class="text-center">How to Earn from Shopercity</h3>
                                    <h6>Welcome to Shopercity!</h6>
                                    <span>Join our platform today and enjoy exclusive discounts and deals. But that’s not all – we also offer an exciting opportunity to earn bonuses!</span>
                                    <span>Instead of advertising Shopercity on other platforms, we give you the chance to promote us and earn rewards. Although you have limited contacts to advertise, you can still earn bonuses by following our process.</span>
                                    <h6 class="mb-0 mt-4">How It Works:</h6>
                                    <span>Become a subscriber partner and Get 10 Store space to add Business and receive a unique agency code to work with us.</span>
                                    <span>Marketing for add new Business your self and earn asper your vision.
However you have the power to add store inside various categories and earn like Agency owner of This Platform. On the other side Share our platform on social media messaging apps to advertise Shopercity and attract new users by Using Agency Code. Register Free for your friends, family, relatives, and others on our platform.</span>
<span>But Our marketing team will reach out to them and offer the same opportunity. When they ready to Start same work like you. You earn extra Bonus from Us. When they subscribe, you’ll receive bonuses in your wallet.</span>
<span>To redeem your bonus, simply provide the amount you’d like to redeem along with your UPI ID or contact information. We’ll transfer the funds to your personal wallet application within 1-7 days.</span>
<span>You have potential to earn bonus Unlimited And Unlimited Earning Potential also. You can register an unlimited number of partners and earn unlimited bonuses.</span>
<h6 class="mb-0 mt-4">Get Started</h6>
<span>If you have any questions, feel free to contact us at the provided numbers. You can also watch our tutorial Hindi video for a better understanding of the process.</span>
                    <div class="login-popup">
                        <div class="form-box">
                            
                            <div class="tab tab-nav-simple tab-nav-boxed form-tab">
                                <ul class="nav nav-tabs nav-fill align-items-center border-no justify-content-center mb-5"
                                    role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link border-no lh-1 ls-normal" href=""></a>
                                    </li>
                                </ul>
                                <div class="tab-content ">
                                    <div class="tab-pane active d-flex flex-column justify-content-center align-items-center" id="signin">
										<h4>Benefits</4>
                                        <h6>Acceceble All features.</h6>
                                        <h6>Use all Category.</h6>
										<h6>Use Unlimited for 2 year.</h6>
										<h6>Get Agency Code.</h6>
										<!-- <h6>Earn Rewards Get Income.</h6> -->
                                        <h6>Get full Marketing Support from us.</h6>
                                        <h6>Start strong! Easily manage up to 10 stores under one account—perfect for growing businesses.</h6>
										    <h4>Rs. 150</h4>
											<?php 
											if(!empty($_SESSION['is_active']) && $_SESSION['is_active'] == 1){
												$_SESSION['error_msg'] = "You Plan Is Alrady Purchase";
												?>
										    <a href="user/index.php"
                                            class="btn btn-rounded btn-blue btn-block btn-gradient d-flex align-items-center justify-content-center">Add your business</a><?php
											}else{
                                                if(isset($_SESSION['user_id'])){
										?>
                                        <a href="payment/pay.php" id="<?php if(isset($_SESSION) && isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){echo "PayNow";} ?>" class="btn btn-rounded btn-blue btn-block btn-gradient d-flex align-items-center justify-content-center">Buy Now...</a>
										<?php 
                                        }else{
                                            ?>
                                            <a href="login.php" id="" class="btn btn-rounded btn-blue btn-block btn-gradient d-flex align-items-center justify-content-center">Login Now</a>
                                            <?php
                                        }} ?>
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
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
    // //Pay Amount
    // jQuery(document).ready(function($) {
    //     jQuery("#PayNow").click(function(e) {
    //         var paymentOption = "";
    //         let billing_name = 'test';
    //         let billing_mobile = 9328797950;
    //         let billing_email = "dabhiprakash32244@gmail.com";
    //         var shipping_name = "<?php echo $_SESSION['first_name'];
    //             echo $_SESSION['last_name']; ?>";
    //         var shipping_mobile = "<?php echo $_SESSION['mobile']; ?>";
    //         var shipping_email = "<?php echo $_SESSION['email']; ?>";
    //         var paymentOption = "netbanking";
    //         var payAmount = 2000;

    //         var request_url = "submitpayment.php";
    //         var formData = {
    //             billing_name: billing_name,
    //             billing_mobile: billing_mobile,
    //             billing_email: billing_email,
    //             shipping_name: shipping_name,
    //             shipping_mobile: shipping_mobile,
    //             shipping_email: shipping_email,
    //             paymentOption: paymentOption,
    //             payAmount: payAmount,
    //             action: "payOrder",
    //         };

    //         $.ajax({
    //             type: "POST",
    //             url: request_url,
    //             data: formData,
    //             dataType: "json",
    //             encode: true,
    //         }).done(function(data) {
    //             if (data.res == "success") {
    //                 var orderID = data.order_number;
    //                 var orderNumber = data.order_number;
    //                 var options = {
    //                     key: data
    //                         .razorpay_key, // Enter the Key ID generated from the Dashboard
    //                     amount: data.userData
    //                         .amount, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
    //                     currency: "INR",
    //                     name: "Tutorialswebsite", //your business name
    //                     description: data.userData.description,
    //                     image: "https://www.tutorialswebsite.com/wp-content/uploads/2022/02/cropped-logo-tw.png",
    //                     order_id: data.userData
    //                         .rpay_order_id, //This is a sample Order ID. Pass
    //                     handler: function(response) {
    //                         window.location.replace("payment-success.php?oid=" +
    //                             orderID + "&rp_payment_id=" + response
    //                             .razorpay_payment_id + "&rp_signature=" + response
    //                             .razorpay_signature);
    //                     },
    //                     modal: {
    //                         ondismiss: function() {
    //                             window.location.replace("payment-success.php?oid=" +
    //                                 orderID);
    //                         },
    //                     },
    //                     prefill: {
    //                         //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
    //                         name: data.userData.name, //your customer's name
    //                         email: data.userData.email,
    //                         contact: data.userData
    //                             .mobile, //Provide the customer's phone number for better conversion rates
    //                     },
    //                     notes: {
    //                         address: "Tutorialswebsite",
    //                     },
    //                     config: {
    //                         display: {
    //                             blocks: {
    //                                 banks: {
    //                                     name: "Pay using " + paymentOption,
    //                                     instruments: [{
    //                                         method: paymentOption,
    //                                     }, ],
    //                                 },
    //                             },
    //                             sequence: ["block.banks"],
    //                             preferences: {
    //                                 show_default_blocks: true,
    //                             },
    //                         },
    //                     },
    //                     theme: {
    //                         color: "#3399cc",
    //                     },
    //                 };
    //                 var rzp1 = new Razorpay(options);
    //                 rzp1.on("payment.failed", function(response) {
    //                     window.location.replace("payment-failed.php?oid=" + orderID +
    //                         "&reason=" + response.error.description +
    //                         "&paymentid=" + response.error.metadata.payment_id);
    //                 });
    //                 rzp1.open();
    //                 e.preventDefault();
    //             }
    //         });
    //     });
		
	// 	//alrady plan perchance 
	// 	jQuery("#pay").click(function(e) {
	// 		location.reload();
	// 	});
    // });
    </script>
</body>

</html>