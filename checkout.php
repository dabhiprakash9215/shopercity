<!DOCTYPE html>
<html lang="en">

<head>
    <title>Checkout</title>
    <?php
    require_once "include/header_script.php";
    require_once "db/connection.php";
    ?>
    <style>
        .mainscreen {
            min-height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            
        }

        .card {
            width: 80rem;
            margin: auto;
            background: white;
            position: center;
            align-self: center;
            top: 50rem;
            border-radius: 1.5rem;
            box-shadow: 4px 3px 20px #3535358c;
            display: flex;
            flex-direction: row;

        }

        .leftside {
            background: #030303;
            width: 25rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-top-left-radius: 1.5rem;
            border-bottom-left-radius: 1.5rem;
        }

        .product {
            object-fit: cover;
            width: 20em;
            height: 20em;
            border-radius: 100%;
        }

        .rightside {
            background-color: #ffffff;
            width: 35rem;
            border-bottom-right-radius: 1.5rem;
            border-top-right-radius: 1.5rem;
            padding: 1rem 2rem 3rem 3rem;
        }

        p {
            display: block;
            font-size: 1.1rem;
            font-weight: 400;
            margin: .8rem 0;
        }

        .inputbox {
            color: #030303;
            width: 100%;
            padding: 0.5rem;
            border: none;
            border-bottom: 1.5px solid #ccc;
            margin-bottom: 1rem;
            border-radius: 0.3rem;
            font-family: 'Roboto', sans-serif;
            color: #615a5a;
            font-size: 1.1rem;
            font-weight: 500;
            outline: none;
        }

        .expcvv {
            display: flex;
            justify-content: space-between;
            padding-top: 0.6rem;
        }

        .expcvv_text {
            padding-right: 1rem;
        }

        .expcvv_text2 {
            padding: 0 1rem;
        }

        .button {
            background: linear-gradient(135deg, #753370 0%, #298096 100%);
            padding: 15px;
            border: none;
            border-radius: 50px;
            color: white;
            font-weight: 400;
            font-size: 1.2rem;
            margin-top: 10px;
            width: 100%;
            letter-spacing: .11rem;
            outline: none;
        }

        .button:hover {
            transform: scale(1.05) translateY(-3px);
            box-shadow: 3px 3px 6px #38373785;
        }
        form {
            display: flex;
            flex-direction: column;
            align-content: center;
            align-items: center;
        }
        @media only screen and (max-width: 1000px) {
            .card {
                flex-direction: column;
                width: auto;

            }

            .leftside {
                width: 100%;
                border-top-right-radius: 0;
                border-bottom-left-radius: 0;
                border-top-right-radius: 0;
                border-radius: 0;
            }

            .rightside {
                width: auto;
                border-bottom-left-radius: 1.5rem;
                padding: 0.5rem 3rem 3rem 2rem;
                border-radius: 0;
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
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb">
                        <li>
                            <a href="demo1.html"><i class="d-icon-home"></i></a>
                        </li>
                        <li>Checkout</li>
                    </ul>
                </div>
            </nav>
            <div class="page-content pt-10 pb-10 mb-2">
                <div class="container">

                    <div class="mainscreen">
                        <!-- <img src="https://image.freepik.com/free-vector/purple-background-with-neon-frame_52683-34124.jpg"  class="bgimg " alt="">-->
                        <div class="card">
                            <div class="leftside">
                                <img src="images/1231857247.png"
                                    class="product" alt="Shoes" />
                            </div>
                            <div class="rightside">
                                <form action="payment/pay.php" method="post">
                                    <h1>CheckOut</h1>
                                    <!-- <h2>Payment Information</h2>
                                    <p>Cardholder Name</p>
                                    <input type="text" class="inputbox" name="name" required />
                                    <p>Card Number</p>
                                    <input type="number" class="inputbox" name="card_number" id="card_number"
                                        required />

                                    <p>Card Type</p>
                                    <select class="inputbox" name="card_type" id="card_type" required>
                                        <option value="">--Select a Card Type--</option>
                                        <option value="Visa">Visa</option>
                                        <option value="RuPay">RuPay</option>
                                        <option value="MasterCard">MasterCard</option>
                                    </select>
                                    <div class="expcvv">

                                        <p class="expcvv_text">Expiry</p>
                                        <input type="date" class="inputbox" name="exp_date" id="exp_date" required />

                                        <p class="expcvv_text2">CVV</p>
                                        <input type="password" class="inputbox" name="cvv" id="cvv" required />
                                    </div>
                                    <p></p> -->
                                    <p>Acceceble All features.</p>
                                    <p>Use all Catagory.</p>
                                    <p>Use Unlimited for 2 year</p>
                                    <p>Get Rafaral Code.</p>
                                    <!-- <p>Earn Rewards Get Income.</p> -->
                                    <!-- <p>Price Plan 2000</p> -->
                                    <button type="submit" class="button">Pay Now</button>
                                </form>
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
    <?php
    require_once "include/mobile-menu.php";
    require_once "include/footer_script.php";
    ?>
</body>

</html>