<?php
include 'include/security_token.php';
include 'include/db_connect.php';
include 'include/pop_security.php';
include 'include/users_right.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'style.php'; ?>
    <script src="./assets/libs/jquery/jquery.min.js"></script>

</head>

<body data-sidebar="dark">


    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php $page_title = 'Customers test';
        include 'Header.php'; ?>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <?php include 'Sidebar_menu.php'; ?>

                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="d-flex align-items-end flex-wrap">
                                    <div class="mr-md-3 mr-xl-5">
                                        <div class="d-flex">
                                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                                            <p class="text-primary mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                                            </p>
                                            <p class="text-primary mb-0 hover-cursor">Customers</p>
                                            <?php if($_GET['new_customer_month']):?>
                                                <p class="text-primary mb-0 hover-cursor">/&nbsp;New Customers</p>
                                            <?php endif; ?>
                                            <?php if($_GET['expire_customer_month']):?>
                                                <p class="text-primary mb-0 hover-cursor">/&nbsp; Monthly Expired Customers</p>
                                            <?php endif; ?>
                                            <?php if($_GET['online']):?>
                                                <p class="text-primary mb-0 hover-cursor">/&nbsp;Online Customers</p>
                                            <?php endif; ?>
                                            <?php if($_GET['offline']):?>
                                                <p class="text-primary mb-0 hover-cursor">/&nbsp;Offline Customers</p>
                                            <?php endif; ?>
                                            <?php if($_GET['active']):?>
                                                <p class="text-primary mb-0 hover-cursor">/&nbsp;Active Customers</p>
                                            <?php endif; ?>
                                            <?php if($_GET['expired']):?>
                                                <p class="text-primary mb-0 hover-cursor">/&nbsp;Expired Customers</p>
                                            <?php endif; ?>
                                            <?php if($_GET['disabled']):?>
                                                <p class="text-primary mb-0 hover-cursor">/&nbsp;Disabled Customers</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button data-bs-toggle="modal" data-bs-target="#addCustomerModal"
                                        class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"
                                        id="addBtn" style="margin-bottom: 12px;">&nbsp;&nbsp;New customer
                                    </button>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                           <?php require 'Component/customer_table.php';?>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?php include 'Footer.php'; ?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

   
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <?php include 'script.php'; ?>



    
</body>

</html>
