<?php
include("include/security_token.php");
include("include/users_right.php");
include "include/db_connect.php";
include "include/pop_security.php";
error_reporting(E_ALL);


if(isset($_GET["inactive"]))
{
    if($_GET["inactive"]=="true")
    {
        $popID = $_GET["pop"];

        $custmrs = $con->query("SELECT * FROM customers WHERE pop=$popID");
        while ($rowsct = mysqli_fetch_assoc($custmrs)) 
            {
                $custmr_usrname = $rowsct["username"];

                // Deleting users from Radius user list
                $con->query("DELETE FROM radcheck WHERE username = '$custmr_usrname'");
                $con->query("DELETE FROM radreply WHERE username = '$custmr_usrname'");
                $con->query("UPDATE customers SET status='0' WHERE username='$custmr_usrname'");
                $con->query("UPDATE add_pop SET status='0' WHERE id='$popID'");

            }

            header('Location: '.$_SERVER['PHP_SELF']);
            die;


    }
    else if($_GET["inactive"]=="false")
    {
        $popID = $_GET["pop"];

        $custmrs = $con->query("SELECT * FROM customers WHERE pop=$popID");
        while ($rowsct = mysqli_fetch_assoc($custmrs)) 
            {
                $custmr_usrname = $rowsct["username"];
                $custmr_password = $rowsct["password"];
                $custmr_package = $rowsct["package_name"];
                
                // Deleting users from Radius user list
                $con->query("INSERT INTO radcheck(username,attribute,op,value) VALUES('$custmr_usrname','Cleartext-Password',':=','$custmr_password')");
                $con->query("INSERT INTO radreply (username,attribute,op,value) VALUES('$custmr_usrname','MikroTik-Group',':=','$custmr_package')");
                $con->query("UPDATE customers SET status='1' WHERE username='$custmr_usrname'");
                $con->query("UPDATE add_pop SET status='1' WHERE id='$popID'");

            }

            header('Location: '.$_SERVER['PHP_SELF']);
            die;


    }



}

?>


<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/toastr/toastr.min.css">
</head>

<body data-sidebar="dark">


    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="index.php" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/it-fast.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/it-fast.png" alt="" height="17">
                            </span>
                        </a>

                        <a href="index.php" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="assets/images/it-fast.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/it-fast.png" alt="" height="36">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="mdi mdi-menu"></i>
                    </button>

                    <div class="d-none d-sm-block ms-2">
                        <h4 class="page-title">POP/Branch</h4>
                    </div>
                </div>



                <div class="d-flex">





                    <div class="dropdown d-none d-md-block me-2">
                        <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="font-size-16">
                                <?php if (isset($_SESSION['username'])) {
                                    echo $_SESSION['username'];
                                } ?>
                            </span>
                        </button>
                    </div>


                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg" alt="Header Avatar">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block me-2">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ion ion-md-notifications"></i>
                            <span class="badge bg-danger rounded-pill">3</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="m-0 font-size-16"> Notification (3) </h5>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-success rounded-circle font-size-16">
                                                <i class="mdi mdi-cart-outline"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mt-0 font-size-15 mb-1">Your order is placed</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">Dummy text of the printing and typesetting industry.</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-warning rounded-circle font-size-16">
                                                <i class="mdi mdi-message-text-outline"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mt-0 font-size-15 mb-1">New Message received</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">You have 87 unread messages</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-info rounded-circle font-size-16">
                                                <i class="mdi mdi-glass-cocktail"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mt-0 font-size-15 mb-1">Your item is shipped</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">It is a long established fact that a reader will</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>
                            <div class="p-2 border-top">
                                <div class="d-grid">
                                    <a class="btn btn-sm btn-link font-size-14  text-center" href="javascript:void(0)">
                                        View all
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>

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
                                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                                            </p>
                                            <p class="text-primary mb-0 hover-cursor">POP/Branch</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">

                                    <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" style="margin-bottom: 12px;">&nbsp;&nbsp;New
                                        POP/Branch</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addModal">
                        <div class="modal-dialog" role="document">
                            <form id="pop_branch">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add POP/Branch</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 d-flex">
                                                    <div class="col-md-6" style="margin-right:9px">
                                                        <div class="form-group mb-3">
                                                            <label>POP/Branch</label>
                                                            <input class="form-control" type="text" name="pop" id="pop" placeholder="Type Your POP/Branch" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label>Incharge Fullname</label>
                                                            <input class="form-control" type="text" name="fullname" id="fullname" placeholder="Type Your fullname" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 d-flex">
                                                    <div class="col-md-6" style="margin-right:9px">
                                                        <div class="form-group mb-3">
                                                            <label>Incharge Username</label>
                                                            <input class="form-control" type="text" name="username" id="username" placeholder="Enter username" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label>Incharge Password</label>
                                                            <input class="form-control" type="password" name="password" id="password" placeholder="Enter Your Password" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 d-flex">
                                                    <div class="col-md-6" style="margin-right:9px">
                                                        <div class="form-group mb-3">
                                                            <label>Opening Balance</label>
                                                            <input class="form-control" type="text" name="opening_bal" id="opening_bal" placeholder="Enter Balance" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="margin-right:5px">
                                                        <div class="form-group mb-3">
                                                            <label>Mobile Number</label>
                                                            <input class="form-control" type="text" name="mobile_num1" placeholder="Enter Your Mobile Number" id="mobile_num1" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 d-flex">
                                                    <div class="col-md-6" style="margin-right:9px">
                                                        <div class="form-group mb-3">
                                                            <label>Mobile Number 2</label>
                                                            <input class="form-control" type="text" name="mobile_num2" id="mobile_num2" placeholder="Enter Mobile No" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label>Email Address</label>
                                                            <input class="form-control" type="email" name="email_address" placeholder="Enter Email Address" id="email_address" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 ">
                                                    <div class="form-group mb-3">
                                                        <label>Note</label>
                                                        <textarea id="note" placeholder="Enter Your Text" class="form-control" rows="4" cols="50"></textarea>

                                                    </div>
                                                    <input class="d-none" type="text" id="user_type" name="user_type" value="<?php echo $auth_usr_type; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                        <button type="button" id="addButton" class="btn btn-primary">Add POP/Branch</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-6 float-md-right grid-margin-sm-0">
                                        <div class="form-group">

                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>POP/Branch</th>

                                                    <th>Total Users</th>
                                                    <th>Total Due</th>
                                                    <th>Available Balance</th>
                                                    <th>Action</th>
                                                    <th>Active</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                $sql = "SELECT * FROM add_pop  WHERE  user_type='$auth_usr_type'  ";
                                                $result = mysqli_query($con, $sql);

                                                while ($rows = mysqli_fetch_assoc($result)) {

                                                ?>

                                                    <tr>
                                                        <td><?php echo $popId = $rows['id']; ?></td>
                                                        <td><a href="view_pop.php?id=<?php echo $rows['id']; ?>"><?php echo $popName = $rows['pop']; ?></a> </td>
                                                        <td>
                                                            <?php
                                                            if ($pop_usr = $con->query("SELECT * FROM customers WHERE pop='$popId'  ")) {
                                                                echo $popttlusr = $pop_usr->num_rows;
                                                            }

                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($pop_payment = $con->query("SELECT SUM(amount) AS balance FROM `pop_transaction` WHERE pop_id=$popId  ")) {
                                                                while ($rowssss = $pop_payment->fetch_array()) {
                                                                    $totalAmount = $rowssss["balance"];
                                                                }
                                                                $totalAmount;
                                                            }

                                                            if ($pop_payment = $con->query("SELECT SUM(paid_amount) AS amount FROM `pop_transaction` WHERE pop_id=$popId  ")) {
                                                                while ($rowss = $pop_payment->fetch_array()) {
                                                                    $paidAmount = $rowss["amount"];
                                                                }
                                                            }
                                                            echo $totalAmount - $paidAmount;

                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            //echo $popId;
                                                            if ($allTransactionAmount = $con->query("SELECT SUM(amount) AS balance FROM `pop_transaction` WHERE pop_id=$popId ")) {
                                                                while ($totalAmount = $allTransactionAmount->fetch_array()) {
                                                                    $totalCostAmount =  $totalAmount['balance'];
                                                                }
                                                            }
                                                            if ($allCustomerAmount = $con->query("SELECT SUM(purchase_price) AS recharge_amount FROM `customer_rechrg` WHERE pop_id=$popId ")) {
                                                                while ($CstmrAmount = $allCustomerAmount->fetch_array()) {
                                                                    $totalCustomerAmount  = $CstmrAmount['recharge_amount'];
                                                                }
                                                            }
                                                            echo $totalCostAmount - $totalCustomerAmount;

                                                            ?>

                                                        </td>
                                                            <td>

                                                            <span>
                                                            <?php
                                                            $pop_status = $rows['status'];
                                                            if($rows['status']=='0')
                                                            {
                                                                $checkd = "";
                                                               echo '<a href="?inactive=false&pop='.$popId.'">Active</a>';

                                                            }
                                                            elseif($rows['status']=='1')
                                                            {
                                                                echo '<a href="?inactive=true&pop='.$popId.'">Inctive</a>';
                                                                $checkd = "checked";
                                                            }
                                                            
                                                            
                                                            ?></span>

                                                            </td>
                                                        </td>

                                                        <td style="text-align:right">
                                                            
                                                        <input disabled="disabled" class="form-check form-switch" type="checkbox" onchange="popAction()" id="<?php echo $popId; ?>" value="id="<?php echo $popId; ?>"" switch="bool" <?php echo $checkd; ?>>
                                            <label class="form-label" for="<?php echo $popId; ?>" data-on-label="Yes"
                                                   data-off-label="No"></label>

                                                        </td>

                                                        <td style="text-align:right">
                                                            <a class="btn-sm btn btn-success" href="view_pop.php?id=<?php echo $rows['id']; ?>"><i class="mdi mdi-eye"></i></a>

                                                            <a class="btn-sm btn btn-info" href="pop_edit.php?id=<?php echo $rows['id']; ?>"><i class="fas fa-edit"></i></a>

                                                            



                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © IT-FAST.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Development <i class="mdi mdi-heart text-danger"></i><a target="__blank" href="https://facebook.com/rakib56789">Rakib Mahmud</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title px-3 py-4">
                <a href="javascript:void(0);" class="right-bar-toggle float-end">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
                <h5 class="m-0">Settings</h5>
            </div>

            <!-- Settings -->
            <hr class="mt-0">
            <h6 class="text-center mb-0">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="Layouts-1">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch">
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="Layouts-2">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css">
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="Layouts-3">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css">
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>


            </div>

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/libs/jszip/jszip.min.js"></script>
    <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript" src="js/toastr/toastr.min.js"></script>
    <script type="text/javascript" src="js/toastr/toastr.init.js"></script>
    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>

    <script src="assets/js/app.js"></script>
    <script type="text/javascript">
        add_pop_branch();

        function add_pop_branch() {
            $("#addButton").click(function() {
                var pop = $('#pop').val();
                var fullname = $('#fullname').val();
                var username = $('#username').val();
                var password = $('#password').val();
                var opening_bal = $('#opening_bal').val();
                var mobile_num1 = $('#mobile_num1').val();
                var mobile_num2 = $('#mobile_num2').val();
                var email_address = $('#email_address').val();
                var note = $('#note').val();
                var user_type = $('#user_type').val();
                addPopData(pop, fullname, username, password, opening_bal, mobile_num1, mobile_num2, email_address, note, user_type);
            });
        }
        const addPopData = (pop, fullname, username, password, opening_bal, mobile_num1, mobile_num2, email_address, note, user_type) => {
            if (pop.length == 0) {
                toastr.error("POP/Branch name is required");
            } else if (fullname.length == 0) {
                toastr.error("Fullname is required");
            } else if (username.length == 0) {
                toastr.error("Username is required");
            } else if (password.length == 0) {
                toastr.error("Password is required");
            } else if (opening_bal.length == 0) {
                toastr.error("Type your opening balance");
            } else if (mobile_num1.length == 0) {
                toastr.error("Mobile Number  is required");
            } else if (email_address.length == 0) {
                toastr.error("Email is required");
            } else {

                var addPopData = "0";
                $.ajax({
                    type: "POST",
                    data: {
                        pop: pop,
                        fullname: fullname,
                        username: username,
                        password: password,
                        opening_bal: opening_bal,
                        mobile_num1: mobile_num1,
                        mobile_num2: mobile_num2,
                        email_address: email_address,
                        note: note,
                        addPopData: addPopData,
                        user_type: user_type
                    },
                    url: "include/popBranch.php",
                    cache: false,
                    success: function(response) {
                        if (response == 1) {
                            toastr.success("POP/Branch Create Success");
                            $("#addModal").modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error('Please Try Again');
                        }
                    }
                });


            }
        }

        $(document).ready(function(){

            $(".form-check form-switch").change(function() {
                //$(this).val()
                alert("ok");
            });

        });

            
                       
        

    </script>
</body>

</html>