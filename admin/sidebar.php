<?php require_once "../include/connection.php";
if ($user->is_loggedin() == "") {
    $user->redirect('login.php');
}
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Shoper City</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php
                    if(isset($_SESSION["type"]) && $_SESSION["type"] == 0){
                ?>
                <li class="nav-item menu-open">
                    <a href="index.php" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Brand
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add-brand.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Brand</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="brand.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Brand</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Discount
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add-discount.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Discount</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="discount.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Discount</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Category
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add-category.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="category.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Category</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Vendor
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add-vendor.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Vendor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="vendor.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Vendor</p>
                            </a>
                        </li>
                    </ul>
                </li> -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Subscription Plan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add-subscription.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Plan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="subscription.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Plan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Country
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add-country.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Country</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="country.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Country</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            State
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add-state.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add State</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="state.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View State</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            City
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add-city.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add City</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="city.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View City</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            User
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="user.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Unpaid Users </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="user.php?type=1" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Paid Users</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="contactus.php" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Contact Us
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            withdraw
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="withdraw.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View withdraw</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php 
                    } else {
                ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            User
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="user.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Users</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php                        
                    }
                ?>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>