<?php
require_once "include/connection.php";
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once "include/header_script.php";
    ?>
    <style>
        .profile-pic {
            width: 200px;
            max-height: 200px;
            display: inline-block;
        }

        .file-upload {
            display: none;
        }

        .circle {
            border-radius: 100% !important;
            overflow: hidden;
            width: 128px;
            height: 128px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            /* position: absolute; */
            top: 72px;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .p-image {
            position: relative;
            /* top: 167px; */
            left: 83px;
            bottom: 40px;
            color: #666666;
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
        }

        .p-image:hover {
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
        }

        .upload-button {
            font-size: 1.2em;
        }

        .upload-button:hover {
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
            color: #999;
        }

        #raffer input {
            padding: 10px;
            border: 1px solid;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        @import 'https://fonts.googleapis.com/css?family=Open+Sans:600,700';

        * {
            font-family: 'Open Sans', sans-serif;
        }

        .rwd-table {
            margin: auto;
            min-width: 300px;
            max-width: 100%;
            border-collapse: collapse;
        }

        .rwd-table tr:first-child {
            border-top: none;
            background: #428bca;
            color: #fff;
        }

        .rwd-table tr {
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            background-color: #f5f9fc;
        }

        .rwd-table tr:nth-child(odd):not(:first-child) {
            background-color: #ebf3f9;
        }

        .rwd-table th {
            display: none;
        }

        .rwd-table td {
            display: block;
        }

        .rwd-table td:first-child {
            margin-top: .5em;
        }

        .rwd-table td:last-child {
            margin-bottom: .5em;
        }

        .rwd-table td:before {
            content: attr(data-th) ": ";
            font-weight: bold;
            width: 120px;
            display: inline-block;
            color: #000;
        }

        .rwd-table th,
        .rwd-table td {
            text-align: left;
        }

        .rwd-table {
            color: #333;
            border-radius: .4em;
            overflow: hidden;
        }

        .rwd-table tr {
            border-color: #bfbfbf;
        }

        .rwd-table th,
        .rwd-table td {
            padding: .5em 1em;
        }

        @media screen and (max-width: 601px) {
            .rwd-table tr:nth-child(2) {
                border-top: none;
            }

            td {
                padding-left: 1rem !important;
            }
        }

        @media screen and (min-width: 600px) {
            .rwd-table tr:hover:not(:first-child) {
                background-color: #d8e7f3;
            }

            .rwd-table td:before {
                display: none;
            }

            .rwd-table th,
            .rwd-table td {
                display: table-cell;
                padding: .25em .5em;
            }

            .rwd-table th:first-child,
            .rwd-table td:first-child {
                padding-left: 0;
            }

            .rwd-table th:last-child,
            .rwd-table td:last-child {
                padding-right: 0;
            }

            .rwd-table th,
            .rwd-table td {
                padding: 1em !important;
            }
        }


        /* THE END OF THE IMPORTANT STUFF */

        @-webkit-keyframes leftRight {
            0% {
                -webkit-transform: translateX(0)
            }

            25% {
                -webkit-transform: translateX(-10px)
            }

            75% {
                -webkit-transform: translateX(10px)
            }

            100% {
                -webkit-transform: translateX(0)
            }
        }

        @keyframes leftRight {
            0% {
                transform: translateX(0)
            }

            25% {
                transform: translateX(-10px)
            }

            75% {
                transform: translateX(10px)
            }

            100% {
                transform: translateX(0)
            }
        }
        .dashboard-card {
            padding: 20px 60px;
            border: none; /* Remove default border */
            border-radius: 15px; /* More rounded corners */
            margin: 15px;
            background: rgba(255, 255, 255, 0.2); /* Semi-transparent white background */
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            backdrop-filter: blur(10px); /* The magic blur effect */
            -webkit-backdrop-filter: blur(10px); /* For Safari support */
            color: #333; /* Darker text for better contrast */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Modern font */
            text-align: center; /* Center align content */
            display: flex; /* Use flexbox for alignment */
            flex-direction: column; /* Stack items vertically */
            justify-content: center; /* Center content vertically */
            align-items: center; /* Center content horizontally */
            min-height: 120px; /* Give cards a minimum height */
        }
        
        .dashboard-card h5 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.2em; /* Slightly larger heading */
            color: #1a1a1a; /* Even darker heading */
        }
        
        .dashboard-card span {
            font-size: 1.8em; /* Larger number */
            font-weight: bold;
            color: #007bff; /* Highlight numbers with a primary color */
        }
        
        /* Optional: Add a subtle hover effect */
        .dashboard-card:hover {
            transform: translateY(-5px); /* Lift card slightly on hover */
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.15); /* Enhance shadow on hover */
            transition: all 0.3s ease; /* Smooth transition */
        }
        
        /* For the parent container to properly lay out the cards */
        .withdrawal-cards-container {
            display: flex;
            flex-wrap: wrap; /* Allow cards to wrap to the next line */
            justify-content: center; /* Center cards in the container */
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <?php
        require_once "include/header.php";
        ?>
        <main class="main account">
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb">
                        <li><a href=""><i class="d-icon-home"></i></a></li>
                        <li>Account</li>
                    </ul>
                </div>
            </nav>
            <div class="page-content mt-4 mb-10 pb-6">
                <div class="container">
                    <h2 class="title title-center mb-10">My Account</h2>
                    <div class="tab tab-vertical gutter-lg">
                        <div class="flex-col mb-4 col-lg-3 col-md-4">
                            <ul class="nav nav-tabs mb-4 col-lg-12 col-md-12" role="tablist">
                                <li class="nav-item ">
                                    <a class="nav-link active" href="#dashboard">Withdrawal</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="#account">Profile </a>
                                </li>
                                <?php
                                if ($_SESSION['is_active'] == 1) {
                                ?>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="#raffer">Raffer And Earn</a>
                                    </li>
                                <?php
                                }
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="#change-pass">Change Password</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content col-lg-9 col-md-8">
                            <div class="tab-pane active" id="dashboard">
                                <h2>Withdrawal</h2>
                                <div class="details-section">
                                    <div class="earning">
                                        <div class="balance-box account-page row wrap flex-col justify-content-center align-items-center" style="width: 100%;">
                                            <?php
                                            $user_id = $_SESSION['user_id'];
                                            $qry1 = "SELECT balance FROM users WHERE id=$user_id";
                                            $res1 = mysqli_query($conn, $qry1);
                                            $row2 = mysqli_fetch_array($res1);
                                            $qry3 = "SELECT SUM(amount) as total_amount FROM withdrawals WHERE user_id=$user_id AND status = 1";
                                            $res3 = mysqli_query($conn, $qry3);
                                            $row3 = mysqli_fetch_array($res3);
                                            $qry = "SELECT first_name,last_name,email,mobile,created_at FROM users WHERE upline_id=$user_id";
                                            $res = mysqli_query($conn, $qry);
                                            ?>
                                            <!--<div style="padding: 20px 60px; border: 1px solid; border-radius: 10px; margin: 10px;" class="col-md-5 col-lg-5 col-sm-12">-->
                                            <!--    <h5>Total Balance</h5>-->
                                            <!--    <span style="padding:0px 3px;">₹</span>-->
                                            <!--    <?php echo $row2['balance']; ?>-->
                                            <!--</div>-->
                                            <!--<div style="padding: 20px 60px; border: 1px solid; border-radius: 10px; margin: 10px;" class="col-md-5 col-lg-5 col-sm-12">-->
                                            <!--    <h5>Total withdrawal</h5>-->
                                            <!--    <span style="padding:0px 3px;">₹</span>-->
                                            <!--    <?php echo $row3['total_amount'] ? $row3['total_amount'] : 0; ?>-->
                                            <!--</div>-->
                                            <!--<div style="padding: 20px 60px; border: 1px solid; border-radius: 10px; margin: 10px;" class="col-md-5 col-lg-5 col-sm-12">-->
                                            <!--    <h5>Shared User</h5>-->
                                                <!-- <span style="padding:0px 3px;">₹</span> -->
                                            <!--    <?php echo mysqli_num_rows($res); ?>-->
                                            <!--</div>-->
                                            <div class="withdrawal-cards-container">
                                                <div class="dashboard-card col-md-5 col-lg-5 col-sm-12">
                                                    <h5>Total Balance</h5>
                                                    <span style="padding:0px 3px;">₹</span>
                                                    <?php echo $row2['balance']; ?>
                                                </div>
                                                <div class="dashboard-card col-md-5 col-lg-5 col-sm-12">
                                                    <h5>Total withdrawal</h5>
                                                    <span style="padding:0px 3px;">₹</span>
                                                    <?php echo $row3['total_amount'] ? $row3['total_amount'] : 0; ?>
                                                </div>
                                                <div class="dashboard-card col-md-5 col-lg-5 col-sm-12">
                                                    <h5>Shared User</h5>
                                                    <!-- <span style="padding:0px 3px;">₹</span> -->
                                                    <?php echo mysqli_num_rows($res); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="withdrawal-box mb-10 mt-10">
                                        <form action="db/withdrawal_db.php" method="post">
                                            <label>Enter your UPI ID</label>
                                            <input type="text" class="form-control" name="upi" required>
                                            <label class="mt-2">Enter withdrawal Amount Minimum(3000) Maximum(10000)
                                            </label>
                                            <input type="number" class="form-control" name="amount" required>
                                            <button type="submit" name="withdraw"
                                                class="btn btn-primary mt-2">Withdrawal</button>
                                        </form>
                                    </div>
                                    <?php
                                    $user_id = $_SESSION['user_id'];
                                    $qry = "SELECT * FROM withdrawals WHERE user_id=$user_id";
                                    $res = mysqli_query($conn, $qry);
                                    if (mysqli_num_rows($res) > 0) {
                                    ?>
                                        <div class="earning">
                                            <h5>Total withdrawal</h5>
                                            <table class="rwd-table">
                                                <thead>
                                                    <tr>
                                                        <td>No</td>
                                                        <td>Amount</td>
                                                        <td>Message</td>
                                                        <td>Status</td>
                                                        <td>Date</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $count = 0;
                                                    if (mysqli_num_rows($res) > 0) {
                                                        while ($row = mysqli_fetch_array($res)) {
                                                            $count++;
                                                    ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $count; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row['amount']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row['message']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($row['status'] == 0) {
                                                                        echo "Processing";
                                                                    } else if ($row['status'] == 1) {
                                                                        echo "Completed";
                                                                    } else if ($row['status'] == 2) {
                                                                        echo "rejected";
                                                                    } ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo date("d-m-Y", strtotime($row['created_at'])) ?>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    } else {
                                                        echo "Yet not any withdrawal";
                                                    }

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="tab-pane" id="withdrawal">
                                <h2>withdrawal</h2>

                            </div>
                            <?php
                            if ($_SESSION['is_active'] == 1) {
                            ?>
                                <div class="tab-pane" id="raffer">
                                    <h2>Raffer And Earn</h2>
                                    <div class="col-md-9">
                                        <input type='text'
                                            value='https://shopercity.com/login.php?ref_id=<?php echo $_SESSION['referral_id']; ?>'
                                            id='url_input' class="w-100" readonly>
                                        <button onclick='copyToClipboard()'
                                            class="btn btn-rounded btn-blue btn-block btn-gradient d-flex align-items-center justify-content-center">Copy</button>
                                        <?php
                                        // $qry = "SELECT first_name,last_name,email,mobile,created_at FROM users WHERE upline_id=$user_id";
                                        // $res = mysqli_query($conn, $qry);
                                        // if (mysqli_num_rows($res) > 0) {
                                        ?>
                                        <!-- <table class="rwd-table mt-10">
                                            <tbody>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Date</th>
                                                </tr>
                                               <?php

                                                // $count = 0;
                                                //     while ($row = mysqli_fetch_array($res)) {
                                                //   $dateTime = new DateTime($row['created_at']);
                                                //   $formattedDate = $dateTime->format('d-m-Y');
                                                //         $count++;
                                                //         echo "<tr>";
                                                //         echo "<td data-th='Name'>".$row['first_name'] .' '. $row['first_name']."</td>";
                                                //         echo "<td data-th='Date'>" . $formattedDate."</td>";
                                                //         echo "</tr>";
                                                //     }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php //} 
                                        ?> -->
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="tab-pane" id="change-pass">
                                <form action="db/changepass_db.php" method="post">
                                    <legend>Password Change</legend>
                                    <label>Current password (leave blank to leave unchanged)</label>
                                    <input type="password" class="form-control" name="current_password" required>
                                    <label>New password (leave blank to leave unchanged)</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                    <label>Confirm new password</label>
                                    <input type="password" class="form-control" name="confirm_password" required>
                                    <button type="submit" class="btn btn-primary mt-2">SAVE CHANGES</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="account">
                                <form action="db/signup_db.php" class="form" method="post" id="register-form"
                                    enctype="multipart/form-data">
                                    <div class="small-12 medium-2 large-2 columns">
                                        <div class="circle" style="display: flex;">
                                            <img class="profile-pic"
                                                src="<?php if (!empty($_SESSION['old_img'])) {
                                                            echo "assets/images/profile_img/" . $_SESSION['old_img'];
                                                        } else { ?>https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg<?php } ?>">
                                        </div>
                                        <div class="p-image">
                                            <i class="fa fa-camera upload-button"></i>
                                            <input type="hidden" name="old_img"
                                                value="<?php echo $_SESSION['old_img']; ?>">
                                            <div class="form-group">
                                                <input class="file-upload" name="profile_image" type="file"
                                                    accept="image/*" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 form-group mb-2">
                                            <label>First Name *</label>
                                            <input type="text" class="form-control m-0" name="first_name"
                                                value="<?php echo $_SESSION['first_name']; ?>" required>

                                        </div>
                                        <div class="col-sm-6 form-group mb-2">
                                            <label>Last Name *</label>
                                            <input type="text" class="form-control m-0" name="last_name"
                                                value="<?php echo $_SESSION['last_name']; ?>" required>

                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Mobile Number *</label>
                                        <input type="text" class="form-control m-0" name="mobile_number"
                                            value="<?php echo $_SESSION['mobile']; ?>" required>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Address *</label>
                                        <input type="text" class="form-control m-0" name="address"
                                            value="<?php echo $_SESSION['address']; ?>" required>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="mt-2">City *</label>
                                        <input type="text" class="form-control" name="city"
                                            value="<?php echo $_SESSION['city']; ?>" required>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="mt-2">State *</label>
                                        <select name="state" required class="form-control">
                                            <option value="">Select State</option>
                                            <?php 
                                            $state_qry = "SELECT * FROM state";
                                            $state_res = mysqli_query($conn, $state_qry);
                                            while ($row = mysqli_fetch_assoc($state_res)) {
                                                echo '<option value="' . $row['state_code'] . '">' . $row['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group mb-2">
                                        <label class="mt-2">District *</label>
                                        <select name="district" required class="form-control">
                                            <option value="">Select District</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="mt-2">Country *</label>
                                        <input type="text" class="form-control m-0"
                                            value="<?php echo $_SESSION['country']; ?>" name="country" required>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="mt-2">Postal Code *</label>
                                        <input type="text" class="form-control m-0"
                                            value="<?php echo $_SESSION['pincode']; ?>" name="pincode" required>
                                    </div>
                                    <button type="submit" name="update" class="btn btn-primary mt-2">SAVE
                                        CHANGES</button>
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
    ?>

    <?php
    require_once "include/footer_script.php";
    ?>
    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("url_input");
            copyText.select();
            document.execCommand("copy");
            // alert("Link copied to clipboard: " + copyText.value);
        }
        $(document).ready(function() {
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('.profile-pic').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(".file-upload").on('change', function() {
                readURL(this);
            });
            $(".upload-button").on('click', function() {
                $(".file-upload").click();
            });
        });
        $(function() {
            $('#register-form').validate({
                rules: {
                    first_name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    mobile: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    city: {
                        required: true,
                    },
                    state: {
                        required: true,
                    },
                    district:{
                        required:true,
                    },
                    country: {
                        required: true,
                    },
                    pincode: {
                        required: true,
                    },
                    aadhar_number: {
                        required: true,
                    },
                    image: {
                        required: true,
                        accept: "image/*", // Accept only image files
                        filesize: 2048576, // Maximum file size in bytes (2MB)
                    },
                },
                messages: {
                    first_name: {
                        required: "Please enter your first name",
                    },
                    last_name: {
                        required: "Please enter your last name",
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email address"
                    },
                    mobile: {
                        required: "Please enter your mobile number",
                        min: 10,
                        max: 10,
                    },
                    address: {
                        required: "Please enter your Address ",
                    },
                    city: {
                        required: "Please enter your city ",
                    },
                    state: {
                        required: "Please select state ",
                    },
                    district{
                        required:"Please select district"
                    },
                    country: {
                        required: "Please enter your country ",
                    },
                    pincode: {
                        required: "Please enter your postal code number",
                    },
                    aadhar_number: {
                        required: "Please enter your addhar number",
                    },
                    image: {
                        required: "Please select an image file",
                        accept: "Please upload a valid image file",
                        filesize: "The image file size should not exceed 2MB",
                        // You can add more specific error messages here
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback text-danger');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid text-danger');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
        $('#add_your_business').click(function() {
            window.location.href = "user/login.php";
        })
    </script>
    <!---<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
    $(document).ready(function () {
    $('select[name="state"]').on('change', function () {
        var stateCode = $(this).val();

        if (stateCode !== "") {
            $.ajax({
                url: 'get_state.php', // ✅ Set correct file path here
                type: 'POST',
                data: { state: stateCode },
                dataType: 'json',
                success: function (response) {
                    let $districtSelect = $('select[name="district"]');
                    $districtSelect.empty();

                    if (response.length > 0) {
                        $districtSelect.append('<option value="">Select District</option>');
                        $.each(response, function (index, districtName) {
                            $districtSelect.append('<option value="' + districtName + '">' + districtName + '</option>');
                        });
                    } else {
                        $districtSelect.append('<option value="">No Districts Found</option>');
                    }
                },
                error: function () {
                    alert("Failed to fetch districts.");
                }
            });
        } else {
            $('select[name="district"]').empty().append('<option value="">Select District</option>');
        }
    });
});

</script>

</body>

</html>