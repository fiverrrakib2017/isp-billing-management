<?php
include("include/security_token.php");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>FAST-ISP-Billing</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-brand-wrapper d-flex justify-content-center">
                <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                    <a class="navbar-brand brand-logo" href="index.php"><img src="images/it-fast.png" alt="logo" /></a>
                    <a class="navbar-brand brand-logo-mini" href="index.php"><img src="images/it-fast.png"
                            alt="logo" /></a>
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                        data-toggle="minimize">
                        <span class="mdi mdi-sort-variant"></span>
                    </button>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item dropdown mr-1">
                        <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
                            id="messageDropdown" href="#" data-toggle="dropdown">
                            <i class="mdi mdi-message-text mx-0"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="messageDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                            <a class="dropdown-item">
                                <div class="item-thumbnail">
                                    <img src="images/faces/face4.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="item-content flex-grow">
                                    <h6 class="ellipsis font-weight-normal">David Grey
                                    </h6>
                                    <p class="font-weight-light small-text text-muted mb-0">
                                        The meeting is cancelled
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item">
                                <div class="item-thumbnail">
                                    <img src="images/faces/face2.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="item-content flex-grow">
                                    <h6 class="ellipsis font-weight-normal">Tim Cook
                                    </h6>
                                    <p class="font-weight-light small-text text-muted mb-0">
                                        New product launch
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item">
                                <div class="item-thumbnail">
                                    <img src="images/faces/face3.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="item-content flex-grow">
                                    <h6 class="ellipsis font-weight-normal"> Johnson
                                    </h6>
                                    <p class="font-weight-light small-text text-muted mb-0">
                                        Upcoming board meeting
                                    </p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown mr-4">
                        <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center notification-dropdown"
                            id="notificationDropdown" href="#" data-toggle="dropdown">
                            <i class="mdi mdi-bell mx-0"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="notificationDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                            <a class="dropdown-item">
                                <div class="item-thumbnail">
                                    <div class="item-icon bg-success">
                                        <i class="mdi mdi-information mx-0"></i>
                                    </div>
                                </div>
                                <div class="item-content">
                                    <h6 class="font-weight-normal">Application Error</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        Just now
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item">
                                <div class="item-thumbnail">
                                    <div class="item-icon bg-warning">
                                        <i class="mdi mdi-settings mx-0"></i>
                                    </div>
                                </div>
                                <div class="item-content">
                                    <h6 class="font-weight-normal">Settings</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        Private message
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item">
                                <div class="item-thumbnail">
                                    <div class="item-icon bg-info">
                                        <i class="mdi mdi-account-box mx-0"></i>
                                    </div>
                                </div>
                                <div class="item-content">
                                    <h6 class="font-weight-normal">New user registration</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        2 days ago
                                    </p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="images/faces/face5.jpg" alt="profile" />
                            <span class="nav-profile-name">
                                <?php if (!empty($_SESSION['fullname'])) {
                                    echo $_SESSION['fullname'];
                                } ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item">
                                <i class="mdi mdi-settings text-primary"></i>
                                Settings
                            </a>
                            <a class="dropdown-item">
                                <i class="mdi mdi-logout text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
               <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="mdi mdi-home menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#customer" aria-expanded="false"
                            aria-controls="customer">
                            <i class="mdi mdi-account menu-icon"></i>
                            <span class="menu-title">Customers</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="customer">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="customers.php">Customers List</a></li>
                                <li class="nav-item"> <a class="nav-link" href="bulk_payment.php">Bulk Payment</a></li>
                                <li class="nav-item"> <a class="nav-link" href="add_pop.php"> Pop</a></li>
                                <li class="nav-item"> <a class="nav-link" href="add_package.php">Add Package</a></li>
                                <li class="nav-item"> <a class="nav-link" href="area.php"> Area</a></li>
                            </ul>
                        </div>
                    </li>  
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false"
                            aria-controls="auth">
                            <i class="mdi mdi-account menu-icon"></i>
                            <span class="menu-title">Customers Packages</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="auth">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="pool.php"> IP Pool </a></li>
                                <li class="nav-item"> <a class="nav-link" href="package.php"> Packages </a></li>
                                <li class="nav-item"> <a class="nav-link" href="expired.php"> Expired date</a></li>

                            </ul>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#tickets" aria-expanded="false"
                            aria-controls="auth">
                            <i class="mdi mdi-note menu-icon"></i>
                            <span class="menu-title">Tickets</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="tickets">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/allTickets.php"> List All Tickets </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/allTickets.php"> List MY Ticket </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/createTickets.php"> Create Ticket </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/ticketsTopic.php"> Ticket Topics </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/salesQuery.php"> Sales Query </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#accounts" aria-expanded="true"
                            aria-controls="auth">
                            <i class="mdi mdi-account-multiple menu-icon"></i>
                            <span class="menu-title">Accounts</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="accounts">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="./ledger.php">Leger</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/transactions.php">Transactions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">Reports</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./cash_bank.php"> Cash/Bank List </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/cash_bank.php">Transaction</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/cash_bank.php">Reports</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/cash_bank.php">Setting</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/cash_bank.php"> Cash/Bank List </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/voucher.php">Voucher Entry</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/bill_entry.php"> Bill Entry</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/daybook.php">Daybook </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/bank_maping.php">Bank Mapping </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#invoice" aria-expanded="true"
                            aria-controls="auth">
                            <i class="mdi mdi-folder-plus menu-icon"></i>
                            <span class="menu-title">Inventory</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="invoice">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="sale.php">Sale</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="product.php">Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="category.php">Add Category</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="brand.php">Add Brand</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="client.php">Client</a>
                                </li><li class="nav-item">
                                    <a class="nav-link" href="supplier.php">Supplier</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#reports" aria-expanded="true"
                            aria-controls="auth">
                            <i class="mdi mdi-chart-pie menu-icon"></i>
                            <span class="menu-title">Reports</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="reports">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/payment_getway.php">Payment GW Report</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/mobile_banking.php">Mobile Banking Log</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/bkash_search.php">bKash Search</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#sms" aria-expanded="true"
                            aria-controls="auth">
                            <i class="mdi mdi-message menu-icon"></i>
                            <span class="menu-title">SMS</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="sms">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/sms_provider.php">SMS Provider Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/sms_setting.php">SMS Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/message_template.php">Message Templates</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/send_message.php">Send SMS </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pages/summery_reports.php">Summary Report</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">SMS Sync Report</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">Download Sync App </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#users" aria-expanded="false"
                            aria-controls="auth">
                            <i class="mdi mdi-account menu-icon"></i>
                            <span class="menu-title">Users</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="users">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="./add_user.php">Add User</a>
                                </li>
                                <li class="nav-item"> <a class="nav-link" href="./pages/user_activity.php">User
                                        ActivityLog</a>
                                </li>
                                <li class="nav-item"> <a class="nav-link" href="./pages/todo_list.php">To Do List</a>
                                </li>
                                <li class="nav-item"> <a class="nav-link" href="./pages/schedule.php"> Shedule Action
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="false"
                            aria-controls="auth">
                            <i class="mdi mdi-power-settings menu-icon"></i>
                            <span class="menu-title">Settings</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="settings">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="nas.php"> NAS </a>
                                </li>
                                <li class="nav-item"> <a class="nav-link" href="./pages/pwd_change.php"> Password Change
                                    </a>
                                </li>
                                <li class="nav-item"> <a class="nav-link" href="./pages/router_setting.php">Router
                                        Setting </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="documentation/documentation.php">
                            <i class="mdi mdi-file-document-box-outline menu-icon"></i>
                            <span class="menu-title">Documentation</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="d-flex align-items-end flex-wrap">
                                    <div class="mr-md-3 mr-xl-5">


                                        <div class="d-flex">
                                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                                            </p>
                                            <p class="text-primary mb-0 hover-cursor">Customers</p>
                                        </div>


                                    </div>
                                    <br>


                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button type="button"
                                        class="btn btn-light bg-white btn-icon mr-3 d-none d-md-block ">
                                        <i class="mdi mdi-download text-muted"></i>
                                    </button>
                                    <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                                        <i class="mdi mdi-clock-outline text-muted"></i>
                                    </button>
                                    <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                                        <i class="mdi mdi-plus text-muted"></i>
                                    </button>
                                    <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"
                                        data-toggle="modal" data-target="#customer-add-popup"> &nbsp; &nbsp;New
                                        NAS</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                    </div>






                    <!-- Modal -->
                    <div class="modal fade" id="customer-add-popup" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content col-md-10">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><span
                                            class="mdi mdi-account-check mdi-18px"></span> &nbsp;New NAS</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div>

                                    <!--Customer form start-->

                                    <div>
                                        <div class="card">
                                            <div class="card-body">

                                                <form class="form-sample" id="form-sample">

                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group ">
                                                                <label>Name</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="name" />

                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group ">
                                                                <label>IP</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="ip" />

                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group ">
                                                                <label>Radius Secret</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="secret" />

                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group ">
                                                                <label>Radius Inc. Port</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    value="37991" name="ports" />

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>API User</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="api_user" />

                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>API Password</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="api_pass" />

                                                            </div>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Port</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="port" />

                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="email" />

                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="row">


                                                    </div>






                                            </div>
                                        </div>
                                    </div>


                                    <!--Customer form end-->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="save" class="btn btn-primary">Save changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>








                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <span class="card-title">NAS</span>


                                    <div class="col-md-6 float-md-right grid-margin-sm-0">



                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control rounded"
                                                    placeholder="Search customers" aria-label="Recipient's username">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary mdi mdi-account-search mdi-18px"
                                                        type="button"></button>
                                                </div>
                                            </div>
                                        </div>


                                    </div>


                                    <div class="table-responsive">
                                        <table id="recent-purchases-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>IP</th>
                                                    <th>Secret</th>
                                                    <th>Loacation</th>
                                                    <th>Description</th>
                                                    <th>etc.</th>
                                                    <th>&nbsp;</th>

                                                </tr>
                                            </thead>
                                            <tbody id="nas-list">


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021 <a
                                href="https://www.it-fast.com/" target="_blank">iT-Fast</a>. All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made
                            with <i class="mdi mdi-heart text-danger"></i></span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <script src="vendors/chart.js/Chart.min.js"></script>
    <script src="vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="js/dashboard.js"></script>
    <script src="js/data-table.js"></script>
    <script src="js/jquery.dataTables.js"></script>
    <script src="js/dataTables.bootstrap4.js"></script>

    <!-- End custom js for this page-->

    <script type="text/javascript">
    $(document).ready(function(e) {


        var nas = "0";
        $.ajax({
            type: "GET",
            url: "include/nas.php?list",
            data: nas,
            cache: false,
            success: function(naslist) {
                //alert(naslist);
                $("#nas-list").html(naslist);
            }
        });


        $("#save").click(function() {

            var nasdt = $("#form-sample").serialize();

            alert(nasdt);
            $.ajax({
                type: "GET",
                url: "include/nas.php?add",
                data: nasdt,
                cache: false,
                success: function(naslist) {
                    $("#nas-list").load("include/nas.php?list");
                }
            });
        });


    });
    </script>



</body>

</html>