<?php
include("include/security_token.php");
include("include/db_connect.php");
include("include/users_right.php");
include("include/pop_security.php");
if (isset($_GET["id"])) {
    $popid = $_GET["id"];
}
if ($pop_list = $con->query("SELECT * FROM add_pop WHERE id='$popid'")) {
    while ($rows = $pop_list->fetch_array()) {
        $lstid = $rows["id"];
        $pop_name = $rows["pop"];
        $pop_status = $rows["status"];
        $fullname = $rows['fullname'];
        $username = $rows['username'];
        $password = $rows['password'];
        $opening_bal = $rows['opening_bal'];
        $mobile_num1 = $rows['mobile_num1'];
        $mobile_num2 = $rows['mobile_num2'];
        $email_address = $rows['email_address'];
        $note = $rows['note'];
    }

// Enable /disable POP Users
if(isset($_GET["inactive"]))
{
    if($_GET["inactive"]=="true")
    {
        $popID = $_GET["id"];

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

            header('Location: '.$_SERVER['PHP_SELF'].'?id='.$popID);
            die;


    }
    else if($_GET["inactive"]=="false")
    {
        $popID = $_GET["id"];

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

            header('Location: '.$_SERVER['PHP_SELF'].'?id='.$popID);
            die;


    }



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
                                <?php if (isset($_SESSION['fullname'])) {
                                    echo $_SESSION['fullname'];
                                } ?>
                            </span>
                        </button>
                    </div>


                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="profileImages/avatar.png" alt="Header Avatar">
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
                                    <p class="text-primary mb-0 hover-cursor">POP&nbsp;/&nbsp; <?php echo $pop_name; ?></p>
                                 </div>
                              </div>
                              <br>
                           </div>
                           <div class="d-flex justify-content-between align-items-end flex-wrap">
                              
                           <div class="d-flex py-2" style="float:right;">
                           <abbr title="Recharge All">
                                <button type="button" class="btn-sm btn btn-success" style="float:right;" type="button" id="RchgMdlBtn"><i class="ion ion-ios-people"></i></button>
                                </abbr>
                                &nbsp;
                                <abbr title="Add Package">
                                <button type="button" class="btn-sm btn btn-danger" style="float:right;" type="button" id="packageAddBtn"><i class="mdi mdi-briefcase-plus"></i></button>
                                </abbr>
                                &nbsp;
                                <abbr title="Add Customer">
                                <button type="button" data-bs-target="#addCustomerModal" data-bs-toggle="modal" class="btn-sm btn btn-primary" style="float:right;" type="button" id=""><i class="mdi mdi-account-plus"></i></button>
                            </abbr>
                                &nbsp;
                                <abbr title="Complain">
                                    <button type="button" data-bs-target="#ComplainModalCenter" data-bs-toggle="modal" class="btn-sm btn btn-warning ">
                                        <i class="mdi mdi-alert-outline"></i>
                                    </button></abbr>
                                &nbsp;
                                <abbr title="Recharge">
                                    <button type="button" id="rechargeBtn" class="btn-sm btn btn-primary " data-bs-target="#addRechargeModal" data-bs-toggle="modal">
                                        <i class="mdi mdi mdi-battery-charging-90"></i>
                                    </button></abbr>
                                &nbsp;
                                <abbr title="Recharge">
                                    <button type="button" id="" class="btn-sm btn btn-success " data-bs-target="#addPaymentModal" data-bs-toggle="modal">
                                        <i class=" mdi mdi-cash-multiple"></i>
                                    </button></abbr>
                                &nbsp;

                                <?php
                                                            //echo $pop_status;
                                                            if($pop_status=='0')
                                                            {
                                                                $checkd = "";
                                                               echo '<a href="?inactive=false&id='.$lstid.'"><abbr title="Make Enable POP"><button type="button" class="btn-sm btn btn-success">
                                                               <i class="mdi mdi mdi-wifi-off "></i>
                                                           </button></abbr></a>';

                                                            }
                                                            elseif($pop_status=='1')
                                                            {
                                                                echo '<a href="?inactive=true&id='.$lstid.'"><abbr title="Make Disable POP"><button type="button" class="btn-sm btn btn-danger">
                                                                <i class="mdi mdi mdi-wifi-off "></i>
                                                            </button></abbr></a>';
                                                                $checkd = "checked";
                                                            }
                                                            
                                                            
                                                            ?>

                                
                                &nbsp;
                                <abbr title="Edit Customer">
                                    <a href="#">
                                        <button type="button" class="btn-sm btn btn-info">
                                            <i class="mdi mdi-account-edit"></i>
                                        </button></a>
                                </abbr>
                            </div>   
                           






                           </div>
                        </div>
                     </div>

                        
                    </div>







                    <div class="row mt-3">
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-purple me-0 float-end"><i class=" fas fa-globe"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-purple">
                                                <?php

                                                        $sql = "SELECT radacct.username FROM radacct
                                                        INNER JOIN customers
                                                        ON customers.username=radacct.username
                                                        WHERE customers.pop='$popid' AND radacct.acctstoptime IS NULL";
                                                        $countpoponlnusr = mysqli_query($con, $sql);

                                                        echo $countpoponlnusr->num_rows;
                                                ?>
                                            </span>
                                            Online Users
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!--End col -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-warning me-0 float-end"><i class="fas fa-exclamation-triangle"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-warning">
                                                <?php if ($AllExcstmr = $con->query("SELECT * FROM customers WHERE pop=$popid AND expiredate < NOW() ")) {
                                                    echo  $AllExcstmr->num_rows;
                                                }

                                                ?>
                                            </span>
                                            Expired
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End col -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-danger me-0 float-end"><i class=" fas fa-calendar-times"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-danger">
                                                <?php if ($dsblcstmr = $con->query("SELECT * FROM customers WHERE status='0' AND user_type=2 AND pop=$popid")) {
                                                    echo  $dsblcstmr->num_rows;
                                                }
                                                ?>
                                            </span>
                                            Disabled
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-primary me-0 float-end"><i class=" fas fa-user"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-primary">
                                            <?php if ($totalCustomers = $con->query("SELECT * FROM customers WHERE   pop=$popid ")) {
                                                    echo  $totalCustomers->num_rows;
                                                }

                                                ?>
                                            </span>
                                            Total Users
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col -->
                    </div> <!-- end row-->
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2" style="border-left:3px solid #2A0FF1;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Current Balance</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                if ($pop_payment = $con->query(" SELECT SUM(`amount`) AS balance FROM `pop_transaction` WHERE pop_id='$popid' ")) {
                                                    while ($rows = $pop_payment->fetch_array()) {
                                                        $currentBal += $rows["balance"];
                                                    }
                                                    if ($pop_payment = $con->query(" SELECT `purchase_price` FROM `customer_rechrg` WHERE pop_id='$popid' ")) {
                                                        while ($rows = $pop_payment->fetch_array()) {
                                                            $totalpaid += $rows["purchase_price"];
                                                        }
                                                        echo  $currentBal - $totalpaid;
                                                    }
                                                }

                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="mdi mdi-currency-bdt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2" style="border-left:3px solid #27F10F;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Paid</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php

                                                if ($pop_payment = $con->query(" SELECT `paid_amount` FROM `pop_transaction` WHERE pop_id='$popid'")) {
                                                    while ($rows = $pop_payment->fetch_array()) {
                                                        $stotalpaid += $rows["paid_amount"];
                                                    }
                                                    echo $stotalpaid;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="mdi mdi-currency-bdt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2" style="border-left:3px solid red;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Due</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                if ($pop_payment = $con->query("SELECT SUM(amount) AS balance FROM `pop_transaction` WHERE pop_id=$popid  ")) {
                                                    while ($rows = $pop_payment->fetch_array()) {
                                                        $totalAmount += $rows["balance"];
                                                    }
                                                    $totalAmount;
                                                }

                                                if ($pop_payment = $con->query("SELECT SUM(paid_amount) AS amount FROM `pop_transaction` WHERE pop_id=$popid")) {
                                                    while ($rows = $pop_payment->fetch_array()) {
                                                        $paidAmount += $rows["amount"];
                                                    }
                                                }
                                                echo $totalAmount - $paidAmount;

                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="mdi mdi-currency-bdt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2" style="border-left:3px solid #0FADF1;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Due Paid</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php

                                            if ($pop_dupayment = $con->query(" SELECT paid_amount FROM pop_transaction WHERE pop_id='$popid' AND transaction_type='5' ")) {
                                                while ($rowsdp = $pop_dupayment->fetch_array()) {
                                                    $stotalDupaid += $rowsdp["paid_amount"];
                                                }
                                                echo $stotalDupaid;
                                            }
                                            ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="mdi mdi-currency-bdt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-12 bg-white p-0 px-2 pb-3 mb-3">
                                        <div class="d-flex justify-content-between border-bottom py-2 px-3">
                                            <p><i class="mdi mdi-marker-check"></i> Incharge Fullname:</p> <a href="#"><?php echo $fullname; ?></a>
                                        </div>
                                        <div class="d-flex justify-content-between border-bottom py-2 px-3">
                                            <p><i class="mdi mdi-account-circle"></i> Incharge Username:</p> <a href="#"><?php echo $username; ?></a>
                                        </div>
                                        <div class="d-flex justify-content-between border-bottom py-2 px-3">
                                            <p><i class=" fas fa-dollar-sign"></i> Opening Balance:</p> <a href="#"><?php echo $opening_bal; ?></a>
                                        </div>
                                        <div class="d-flex justify-content-between border-bottom py-2 px-3">
                                            <p><i class="mdi mdi-phone"></i> Mobile:</p> <a href="#"><?php echo $mobile_num1; ?></a>
                                        </div>
                                        <div class="d-flex justify-content-between border-bottom py-2 px-3">
                                            <p><i class=" fas fa-envelope"></i> Email Address:</p> <a href="#"><?php echo $email_address; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <h5 class="text-center mt-3">Cutomers Statistics</h5>
                                <div class="card-body">
                                    <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>


                </div> <!-- container-fluid -->

                <div class="container">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#branch_user" role="tab">
                                            <span class="d-none d-md-block">Users (

                                                <?php if ($totalCustomers = $con->query("SELECT * FROM customers WHERE pop=$popid ")) {
                                                    echo  $totalCustomers->num_rows;
                                                }

                                                ?>

                                                )</span><span class="d-block d-md-none"><i class="mdi mdi-account-check h5"></i></span>
                                        </a>
                                    </li>
                                    
                                
                                <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tickets" role="tab">
                                            <span class="d-none d-md-block">Tickets
                                            </span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#recharge_history" role="tab">
                                            <span class="d-none d-md-block">Recharge History</span><span class="d-block d-md-none"><i class="mdi mdi-battery-charging h5"></i></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#packages" role="tab">
                                            <span class="d-none d-md-block">Package</span><span class="d-block d-md-none"><i class="mdi mdi-package h5"></i></span>
                                        </a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#pop_transaction" role="tab">
                                            <span class="d-none d-md-block">Transaction Statment</span><span class="d-block d-md-none"><i class="mdi mdi-currency-bdt h5"></i></span>
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">

                                <div class="tab-pane active p-3" id="branch_user" role="tabpanel">
                                        <div class="card">
                                            
                                            <div class="card-body">
                                                <table id="branch_datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Full Name</th>
                                                            <th>Package</th>
                                                            <th>Expired Date</th>
                                                            <th>User Name</th>
                                                            <th>Mobile no.</th>
                                                            <th>Create Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="transaction-list">
                                                        <?php
                                                        $sql = "SELECT * FROM customers WHERE pop='$popid'  ";
                                                        $result = mysqli_query($con, $sql);

                                                        while ($rows = mysqli_fetch_assoc($result)) {
                                                            $username = $rows['username'];

                                                        ?>

                                                            <tr>
                                                                <td><?php echo $rows['id']; ?></td>
                                                                <td><a target="blank" href="profile.php?clid=<?php echo $rows['id']; ?>">
                                                                
                                                                <?php 
                                                                
                                                                $onlineusr = $con->query("SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username='$username'");
                                                                $chkc = $onlineusr->num_rows;
                                                                if($chkc==1)
                                                                {
                                                                    echo '<abbr title="Online"><img src="images/icon/online.png" height="10" width="10"/></abbr>';
                                                                } else{
                                                                    echo '<abbr title="Offline"><img src="images/icon/offline.png" height="10" width="10"/></abbr>';
        
                                                                }
                                                                
                                                                
                                                                
                                                                
                                                                
                                                                echo" ".$rows["fullname"]; ?></a></td>
                                                                <td>

                                                                    <?php
                                                                    $popID = $rows["package"];
                                                                    $allPOP = $con->query("SELECT * FROM radgroupcheck WHERE id=$popID ");
                                                                    while ($popRow = $allPOP->fetch_array()) {
                                                                        echo $popRow['groupname'];
                                                                    }

                                                                    ?>


                                                                </td>
                                                                <td>
                                                                    <?php

                                                                    $expireDate = $rows["expiredate"];
                                                                    $todayDate = date("Y-m-d");
                                                                    if ($expireDate <= $todayDate) {
                                                                        echo "<span class='badge bg-danger'>Expired</span>";
                                                                    } else {
                                                                        //echo date("d-m-Y", strtotime($expireDate));
                                                                        echo date("d M Y", strtotime($expireDate));
                                                                    }
                                                                    ?>

                                                                </td>
                                                                <td><?php echo $rows["username"]; ?></td>
                                                                <td><?php echo $rows["mobile"]; ?></td>
                                                                <td><?php echo  date("d M Y", strtotime($rows["createdate"])) ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane p-3" id="tickets" role="tabpanel">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="ticket_datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Complain Type</th>
                                                            <th>Ticket Type</th>
                                                            <th>Form Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="ticket-list">
                                                        <?php
                                                        $sql = "SELECT * FROM ticket WHERE pop_id='$popid' ";
                                                        $result = mysqli_query($con, $sql);

                                                        while ($rows = mysqli_fetch_assoc($result)) {

                                                        ?>

                                                            <tr>

                                                                <td>
                                                                    <?php
                                                                    $complain_typeId = $rows["complain_type"];
                                                                    $ticketsId = $rows["id"];
                                                                    if ($allCom = $con->query("SELECT * FROM ticket_topic WHERE id='$complain_typeId' ")) {
                                                                        while ($rowss = $allCom->fetch_array()) {
                                                                            $topicName = $rowss['topic_name'];
                                                                            echo '<a href="tickets_edit.php?id=' . $ticketsId . '">' . $topicName . '</a>';
                                                                        }
                                                                    }
                                                                    ?>

                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    $ticketType = $rows['ticket_type'];
                                                                    if ($ticketType == "Active") {
                                                                        echo "<span class='badge bg-success'>Active</span>";
                                                                    } else if ($ticketType == "Open") {
                                                                        echo "<span class='badge bg-info'>Open</span>";
                                                                    } else if ($ticketType == "New") {
                                                                        echo "<span class='badge bg-danger'>New</span>";
                                                                    } else if ($ticketType == "Complete") {
                                                                        echo "<span class='badge bg-success'>Complete</span>";
                                                                    }

                                                                    ?>

                                                                </td>

                                                                <td><?php echo  date("d M Y", strtotime($rows["startdate"])) ?></td>

                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane p-3" id="recharge_history" role="tabpanel">
                                        <div class="card">

                                            <div class="card-body">
                                                <table id="recharge_history_datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>

                                                            <th>Recharged date</th>
                                                            <th>Customer Name</th>
                                                            <th>Months</th>
                                                            <th>Paid until</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT * FROM customer_rechrg WHERE pop_id='$popid'  ";
                                                        $result = mysqli_query($con, $sql);

                                                        while ($rows = mysqli_fetch_assoc($result)) {

                                                        ?>

                                                            <tr>
                                                                <td>
                                                                    <?php
                                                                    $recharge_date_time = $rows['datetm'];
                                                                    $dateTm = new DateTime($recharge_date_time);
                                                                    //echo $dateTm->format("H:i A, d-M-Y");
                                                                    echo $dateTm->format("d-M-Y");
                                                                    ?>
                                                                </td>

                                                                <td>
                                                                    <?php
                                                                    $getCstmrId = $rows["customer_id"];
                                                                    if ($allCom = $con->query("SELECT * FROM customers WHERE id='$getCstmrId' ")) {
                                                                        while ($rowss = $allCom->fetch_array()) {
                                                                            $customerName = $rowss['fullname'];
                                                                            echo '<a href="profile.php?clid=' . $getCstmrId . '">' . $customerName . '</a>';
                                                                        }
                                                                    }
                                                                    ?>

                                                                </td>


                                                                <td><?php echo $rows["months"]; ?></td>
                                                                <td><?php echo $rows["rchrg_until"]; ?></td>
                                                                <td><?php echo $rows["purchase_price"]; ?></td>

                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane p-3" id="packages" role="tabpanel">
                                        <div class="card">
                                            
                                            <div class="card-body">
                                                <table id="package_datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Package List</th>
                                                            <th>Purchase Price</th>
                                                            <th>Sale's Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="package-list">
                                                        <?php
                                                        $increment = 1;
                                                        $sql = "SELECT * FROM branch_package WHERE pop_id='$popid'";
                                                        $result = mysqli_query($con, $sql);

                                                        while ($rows = mysqli_fetch_assoc($result)) {

                                                        ?>

                                                            <tr>
                                                                <td><?php echo $increment++; ?></td>
                                                                
                                                                <td><?php echo $rows["package_name"]; ?></td>
                                                                <td><?php echo $rows["p_price"]; ?></td>
                                                                <td><?php echo $rows["s_price"]; ?></td>


                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                           
                                    <div class="tab-pane p-3" id="pop_transaction" role="tabpanel">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="transaction_datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Recharge Amount</th>
                                                            <th>Paid Amount</th>
                                                            <th>Action</th>
                                                            <th>Transaction Type</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT * FROM pop_transaction WHERE pop_id='$popid'  ";
                                                        $result = mysqli_query($con, $sql);

                                                        while ($rows = mysqli_fetch_assoc($result)) {

                                                        ?>

                                                            <tr>
                                                                <td><?php echo $rows['id']; ?></td>
                                                                <td> <?php echo  $rows["amount"]; ?></td>
                                                                <td> <?php echo  $rows["paid_amount"]; ?></td>


                                                                <td>
                                                                    <?php
                            $transaction_action = $rows["action"];
                            $transaction_type=$rows["transaction_type"];

                            if ($transaction_action == 'Recharge' && $transaction_type=='1') {
                                echo  '<span class="badge bg-danger">Recharged</span> <br> <span class="badge bg-success">Paid</span>';
                            } else if($transaction_action == 'Recharge' && $transaction_type=='0'){
                                echo  '<span class="badge bg-danger">Recharged </span>';
                            }else if($transaction_action == 'paid'){
                                echo  '<span class="badge bg-success">Paid</span>';
                            }else if($transaction_action == 'Return'){
                                echo  '<span class="badge bg-warning">Return</span>';
                            }
                            


                                                                    
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    $transaction_type = $rows["transaction_type"];
                                                                    if ($transaction_type == 1) {
                                                                        echo  '<button class="btn-sm btn btn-outline-success">Cash</button>';
                                                                    } elseif ($transaction_type == 0) {
                                                                        echo  '<button class="btn-sm btn btn-outline-danger">Credit</button>';
                                                                    } elseif ($transaction_type == 2) {
                                                                        echo 'Bkash';
                                                                    } elseif ($transaction_type == 3) {
                                                                        echo 'Nagad';
                                                                    } elseif ($transaction_type == 4) {
                                                                        echo 'Bank';
                                                                    }elseif ($transaction_type == 5) {
                                                                        echo '<button class="btn-sm btn btn-outline-primary">Payment Rcvd</button>';
                                                                    }

                                                                    ?>
                                                                </td>
                                                                <td> <?php echo  $rows["date"]; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page-content -->
            <!-----modal--->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addRechargeModal">
                <div class="modal-dialog" role="document">
                    <form id="FormData">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add POP Recharge</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <input class="d-none" type="text" name="pop_id" value="<?php echo $popid; ?>">
                                    <div class="form-group mb-2">
                                        <label>Amount:</label>
                                        <input type="text" id="addPopAmount" placeholder="Enter Your Amount" class="form-control">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Action:</label>
                                        <select id="addPopAction" class="form-select">
                                            <option value="">Select</option>
                                            <option value="Recharge">Add</option>
                                            <option value="Return">Return</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Transaction Type:</label>
                                        <select id="addPopTra_type" class="form-select">
                                            <option value="">Select</option>
                                            <option value="1">Cash</option>
                                            <option value="0">Credit</option>
                                        </select>
                                    </div>
                                    <div class="form-group d-none">
                                        <label>Transaction Type:</label>
                                        <input type="text" id="recharge_by" class="form-control" value="<?php echo $_SESSION['username']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger">Cancle</button>
                                <button id="submitBtn" type="button" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addPaymentModal">
                <div class="modal-dialog" role="document">
                    <form id="FormData">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Payment Received</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <input class="d-none" type="text" name="pop_id" value="<?php echo $popid; ?>">
                                    <div class="form-group mb-2">
                                        <label>Amount:</label>
                                        <input type="text" id="addPopRechargeAmount" placeholder="Enter Your Amount" class="form-control">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Transaction Type:</label>
                                        <select id="addPopRechargeTra_type" class="form-select">
                                            <option value="1">Cash</option>
                                            <option value="2">Bkash</option>
                                            <option value="3">Nagad</option>
                                            <option value="4">Bank</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Remarks</label>
                                        <textarea id="addRechargeRemarks" class="form-control" placeholder="Enter Remarks"></textarea>
                                    </div>
                                    <div class="form-group d-none">
                                        <label>Recharge By:</label>
                                        <input type="text" id="recharge_by" class="form-control" value="<?php echo $_SESSION['username']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger">Cancle</button>
                                <button type="button" id="addPaymentBtn" class="btn btn-primary"><i class="mdi mdi-cash"></i> Add Payment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addPackageModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Package</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <input class="d-none" type="text" id="pop_id" value="<?php echo $popid; ?>">
                                <div class="form-group mb-2">
                                    <label>Package Name</label>
                                    <select id="p_name" id="p_name" class="form-select" onchange="getPackagePrice()">
                                        <option>Select Package</option>
                                        <?php
                                        if ($allPackage = $con->query("SELECT * FROM radgroupcheck")) {
                                            while ($rows = $allPackage->fetch_array()) {
                                                echo '<option value=' . $rows['id'] . '>' . $rows['groupname'] . '</option>';
                                            }
                                        }


                                        ?>


                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Purchase Price</label>
                                    <input type="text" id="p_price" name="p_price" placeholder="Enter Your Amount" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Sale's Price</label>
                                    <input type="text" id="s_price" name="s_price" placeholder="Enter Your Amount" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-danger">Cancle</button>
                            <button id="PackageSubmitBtn" type="button" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>



            <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" id="addCustomerModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><span class="mdi mdi-account-check mdi-18px"></span> &nbsp;New customer</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="">
                                                <form id="customer_form">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Full Name</label>
                                                                        <input id="customer_fullname" type="text" class="form-control " placeholder="Enter Your Fullname" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Username <span id="usernameCheck"></span></label>
                                                                        <input id="customer_username" type="text" class="form-control " name="username" placeholder="Enter Your Username" oninput="checkUsername();" />

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Password</label>
                                                                        <input id="customer_password" type="password" class="form-control " name="password" placeholder="Enter Your Password" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Mobile no.</label>
                                                                        <input id="customer_mobile" type="text" class="form-control " name="mobile" placeholder="Enter Your Mobile Number" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Expired Date</label>
                                                                        <select id="customer_expire_date" class="form-select">
                                                                            <option value="<?php echo date("d"); ?>"><?php echo date("d"); ?></option>
                                                                            <?php
                                                                            if ($exp_cstmr = $con->query("SELECT * FROM customer_expires")) {
                                                                                while ($rowsssss = $exp_cstmr->fetch_array()) {


                                                                                    $exp_date = $rowsssss["days"];

                                                                                    echo '<option value="' . $exp_date . '">' . $exp_date . '</option>';
                                                                                }
                                                                            }

                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Address</label>
                                                                        <input id="customer_address" type="text" class="form-control" name="address" placeholder="Enter Your Addres" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group mb-2">
                                                                        <label>POP/Branch</label>
                                                                        <select id="customer_pop" class="form-select">
                                                                            <option value="">Select Pop/Branch</option>
                                                                            <?php
                                                                            if ($pop = $con->query("SELECT * FROM add_pop WHERE id=$popid")) {
                                                                                while ($rows = $pop->fetch_array()) {


                                                                                    $id = $rows["id"];
                                                                                    $name = $rows["pop"];

                                                                                    echo '<option value="' . $id . '">' . $name . '</option>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group mb-2">
                                                                        <label>Area/Location</label>
                                                                        <select id="customer_area" class="form-select" name="area">
                                                                            <option>Select Area</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Nid Card Number</label>
                                                                        <input id="customer_nid" type="text" class="form-control" name="nid" placeholder="Enter Your Nid Number" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Package</label>
                                                                        <select id="customer_package" class="form-select">


                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Connection Charge</label>
                                                                        <input id="customer_con_charge" type="text" class="form-control" name="con_charge" placeholder="Enter Connection Charge" value="500" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Package Price</label>
                                                                        <input disabled id="customer_price" type="text" class="form-control" value="00" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Remarks</label>
                                                                        <textarea id="customer_remarks" type="text" class="form-control" placeholder="Enter Remarks"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Status</label>
                                                                        <select id="customer_status" class="form-select">
                                                                            <option value="">Select Status</option>
                                                                            <option value="0">Disable</option>
                                                                            <option value="1">Active</option>
                                                                            <option value="2">Expire</option>
                                                                            <option value="3">Request</option>
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success" id="customer_add">Add Customer</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
            <!-------->




            <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" id="RchgCustomerModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Recharge All</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="">
                                                
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                
                                                          
                                                    <table id="branch_datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th><input type="checkbox" id="checkedAll" name="checkedAll" value="Bike"> All</th>
                                                            <th>User Name</th>
                                                            <th>Exp. Date</th>
                                                            <th>Status</th>
                                                            
                                                            
                                                        </tr>
                                                    </thead>
                                                    <form name="ALLRchFrm" id="ALLRchFrm" method="get" target="load_iframe">
                                                        <input type="hidden" name="rchPOP" value="<?php echo $popid; ?>"/>
                                                    <tbody id="transaction-list">
                                                        <?php
                                                        $sql = "SELECT * FROM customers WHERE pop='$popid'  ";
                                                        $result = mysqli_query($con, $sql);

                                                        while ($rows = mysqli_fetch_assoc($result)) {
                                                            $username = $rows['username'];

                                                        ?>

                                                            <tr>
                                                                <td><input type="checkbox" Value="<?php echo $rows["id"]; ?>" name="checkAll[]" class="checkSingle"></td>
                                                                <td><a href="profile.php?clid=<?php echo $rows['id']; ?>">
                                                                
                                                                <?php 
                                                                
                                                                $onlineusr = $con->query("SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username='$username'");
                                                                $chkc = $onlineusr->num_rows;
                                                                if($chkc==1)
                                                                {
                                                                    echo '<abbr title="Online"><img src="images/icon/online.png" height="10" width="10"/></abbr>';
                                                                } else{
                                                                    echo '<abbr title="Offline"><img src="images/icon/offline.png" height="10" width="10"/></abbr>';
        
                                                                }
                                                                
                                                                echo" ".$rows["fullname"]; ?></a></td>
                                                                <td> <?php echo $rows['expiredate'];?></td>
                                                                <td>
                                                                    <?php

                                                                    $expireDate = $rows["expiredate"];
                                                                    $todayDate = date("Y-m-d");
                                                                    if ($expireDate <= $todayDate) {
                                                                        echo "<span class='badge bg-danger'>Expired</span>";
                                                                    } else {
                                                                        //echo date("d-m-Y", strtotime($expireDate));
                                                                        echo date("d M Y", strtotime($expireDate));
                                                                    }
                                                                    ?>

                                                                </td>
                                                                
                                                                
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                               
                                                    <tfoot>
                                                <tr>
                                                    <th colspan="8"><button style="float:right" id="btnRchgProcs" class="btn btn-success">Process Recharge</button></th>
                                                </tr>
                                            </tfoot>
                                         </table>
                                      

                                                            </div>
                                                            
                                                            
                                                            



                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success" id="customer_add">Add Customer</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
            <!-------->







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
                                Development <i class="mdi mdi-heart text-danger"></i><a href="https://facebook.com/rakib56789">Rakib Mahmud</a>
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
    <script src="js/toastr/toastr.min.js"></script>
    <script src="js/toastr/toastr.init.js"></script>
    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>

    <script src="assets/js/app.js"></script>

    <!-- Peity chart-->
    <script src="assets/libs/peity/jquery.peity.min.js"></script>

    <!--C3 Chart-->
    <script src="assets/libs/d3/d3.min.js"></script>
    <script src="assets/libs/c3/c3.min.js"></script>
    <script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>

    <script src="assets/js/pages/dashboard.init.js"></script>

    <script src="assets/js/app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>

    <script src="assets/js/app.js"></script>
    <script type="text/javascript" src="assets/js/js-fluid-meter.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#checkedAll").change(function() {
                if (this.checked) {
                    $(".checkSingle").each(function() {
                        this.checked = true;
                    })
                } else {
                    $(".checkSingle").each(function() {
                        this.checked = false;
                    })
                }
            });

            $(".checkSingle").click(function() {
                if ($(this).is(":checked")) {
                    var isAllChecked = 0;
                    $(".checkSingle").each(function() {
                        if (!this.checked)
                            isAllChecked = 1;
                    })
                    if (isAllChecked == 0) {
                        $("#checkedAll").prop("checked", true);
                    }
                } else {
                    $("#checkedAll").prop("checked", false);
                }
            });


            $("#btnRchgProcs").click(function() {

                    var rchformdata = $("#ALLRchFrm").serialize();

                    var rchgcnfrm = confirm("Are you sure selected accounts to be recharged?");
                    
                    if(rchgcnfrm == true)
                    {
                    $.ajax({
                            url: "include/bulk_recharge.php?recharge",
                            method: 'get',
                            data: rchformdata,

                    success: function(rspnsrchg) {
                        //alert(rspnsrchg);
                        if(rspnsrchg==0)
                        {
                            toastr.error("Balance Empty, Please recharge POP</br> Recharge failed!");
                            //$("#RchgCustomerModal").modal('hide');

                        }
                        if(rspnsrchg==1)
                        {
                            toastr.success("Recharge done successfully...");
                            $("#RchgCustomerModal").modal('hide');

                        }
                        
                    }
                    
                    });}else{}

                });


            //$("#package-list-table").DataTable();
            $("#ticket_datatable").DataTable();
            $("#transaction_datatable").DataTable();
            $("#package_datatable").DataTable();
            $("#branch_datatable").DataTable();
            $("#recharge_history_datatable").DataTable();


            $("#packageAddBtn").click(function() {
                $("#addPackageModal").modal('show');
            });
            
            $("#RchgMdlBtn").click(function() {
                $("#RchgCustomerModal").modal('show');
            });
            $("#PackageSubmitBtn").click(function() {
                var pop_id = $("#pop_id").val();
                var p_name = $("#p_name").val();
                var p_price = $("#p_price").val();
                var s_price = $("#s_price").val();
                if (p_name.length == 0) {
                    toastr.error("Package Name is required");
                } else if (p_price.length == 0) {
                    toastr.error("Purchase price is required");
                } else if (s_price.length == 0) {
                    toastr.error("Sale's price is required");
                } else {
                    $.ajax({
                        type: "POST",
                        data: {
                            pop_id: pop_id,
                            p_name: p_name,
                            p_price: p_price,
                            s_price
                        },
                        url: "include/package_server.php",
                        cache: false,
                        success: function(largestPossibleRadius) {
                            $("#addPackageModal").modal('hide');
                            toastr.success(largestPossibleRadius);
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    });
                }
            });
            $("#submitBtn").click(function() {
                var pop_id = $("#pop_id").val();
                var addPopAmount = $("#addPopAmount").val();
                var addPopAction = $("#addPopAction").val();
                var addPopTra_type = $("#addPopTra_type").val();
                var recharge_by = $("#recharge_by").val();
                var addPopRecharge = "0";
                if (addPopAmount.length == 0) {
                    toastr.error("Amount is required");
                } else if (addPopAction.length == 0) {
                    toastr.error("Please Select Action Type");
                } else if (addPopTra_type.length == 0) {
                    toastr.error("Please Select Trasaction Type");
                } else {
                    $.ajax({
                        type: "POST",
                        data: {
                            id: pop_id,
                            amount: addPopAmount,
                            action: addPopAction,
                            trasaction: addPopTra_type,
                            addPopRecharge: addPopRecharge,
                            recharge_by: recharge_by
                        },
                        url: "include/pop_transaction.php",
                        cache: false,
                        success: function(repsonse) {
                            if (repsonse == 1) {
                                $("#addRechargeModal").modal('hide');
                                toastr.success("Recharge Successfully");
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            } else {
                                toastr.error('Please Try Again');
                            }
                        }
                    });
                }


            });
            $("#addPaymentBtn").click(function() {
                var pop_id = $("#pop_id").val();
                var addPopAmount = $("#addPopRechargeAmount").val();
                var addPopTra_type = $("#addPopRechargeTra_type").val();
                var addRemarks = $("#addRechargeRemarks").val();
                var recharge_by = $("#recharge_by").val();
                var addPayment = "0";
                if (addPopAmount.length == 0) {
                    toastr.error("Amount is required");
                } else {
                    $.ajax({
                        type: "POST",
                        data: {
                            id: pop_id,
                            amount: addPopAmount,
                            trasaction: addPopTra_type,
                            addRemarks: addRemarks,
                            addPayment: addPayment,
                            recharge_by: recharge_by
                        },
                        url: "include/pop_transaction.php",
                        cache: false,
                        success: function(repsonse) {
                            if (repsonse == 1) {
                                $("#addPaymentModal").modal('hide');
                                toastr.success("Payment Successfully");
                                toastr.success("Thank You");
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            } else {
                                toastr.error('Please Try Again');
                            }
                        }
                    });
                }


            });
        });

        function getPackagePrice() {
            var p_name = $("#p_name").val();
            $.ajax({
                type: 'POST',
                data: {
                    package_name_id: p_name,
                },
                url: 'include/package_server.php',
                success: function(response) {
                    $("#p_price").val(response);
                }

            });
        }




        var xValues = [1, 2, 3, 4, 5, 6];
        new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    data: [860, 1140, 1060, 1060, 1070, 1110],
                    borderColor: "red",
                    fill: false
                }, {
                    data: [1600, 1700, 1700, 1900, 2000, 2700],
                    borderColor: "green",
                    fill: false
                }, {
                    data: [300, 700, 2000, 3000, 3000, 4000],
                    borderColor: "blue",
                    fill: false
                }]
            },
            options: {
                legend: {
                    display: false
                }
            }
        });
        //add customer script
        $(document).on('keyup', '#customer_username', function() {
            var customer_username = $("#customer_username").val();
            $.ajax({
                type: 'POST',
                url: "include/customers_server.php",
                data: {
                    current_username: customer_username
                },
                success: function(response) {
                    $("#usernameCheck").html(response);
                }
            });
        });
        
        $(document).on('change', '#customer_pop', function() {
            var pop_id = $("#customer_pop").val();
           // alert(pop_id);
            $.ajax({
                type: 'POST',
                url: "include/customers_server.php",
                data: {
                    current_pop_name: pop_id
                },
                success: function(response) {
                     $("#customer_area").html(response);
                }
            });
        });
        $(document).on('change', '#customer_pop', function() {
            var pop_id = $("#customer_pop").val();
           // alert(pop_id);
            $.ajax({
                type: 'POST',
                url: "include/customers_server.php",
                data: {
                    pop_name: pop_id,
                    getCustomerPackage:0
                },
                success: function(response) {
                     $("#customer_package").html(response);
                }
            });
        });
        $(document).on('change', '#customer_package', function() {
            var packageId = $("#customer_package").val();
            var pop_id = $("#customer_pop").val();
           // alert(pop_id);
            $.ajax({
                type: 'POST',
                url: "include/customers_server.php",
                data: {
                    package_id: packageId,
                    pop_id: pop_id,
                    getPackagePrice:0
                },
                success: function(response) {
                     $("#customer_price").val(response);
                }
            });
        });




        $("#customer_add").click(function() {
            var fullname = $("#customer_fullname").val();
            var package = $("#customer_package").val();
            var username = $("#customer_username").val();
            var password = $("#customer_password").val();
            var mobile = $("#customer_mobile").val();
            var address = $("#customer_address").val();
            var expire_date = $("#customer_expire_date").val();
            var area = $("#customer_area").val();
            var pop = $("#customer_pop").val();
            var nid = $("#customer_nid").val();
            var con_charge = $("#customer_con_charge").val();
            var price = $("#customer_price").val();
            var remarks = $("#customer_remarks").val();
            var status = $("#customer_status").val();
            var user_type = <?php echo $auth_usr_type; ?>;

            customerAdd(user_type, fullname, package, username, password, mobile, address, expire_date, area, pop, con_charge, price, remarks, nid, status)

        });

        function customerAdd(user_type, fullname, package, username, password, mobile, address, expire_date, area, pop, con_charge, price, remarks, nid, status) {
            if (fullname.length == 0) {
                toastr.error("Customer name is require");
            } else if (package.length == 0) {
                toastr.error("Customer Package is require");
            } else if (username.length == 0) {
                toastr.error("Username is require");
            } else if (password.length == 0) {
                toastr.error("Password is require");
            } else if (mobile.length == 0) {
                toastr.error("Mobile number is require");
            } else if (expire_date.length == 0) {
                toastr.error("Expire Date is require");
            } else if (pop.length == 0) {
                toastr.error("POP/Branch is require");
            } else if (area.length == 0) {
                toastr.error("Area is require");
            } else if (con_charge.length == 0) {
                toastr.error("Connection Charge is require");
            } else if (price.length == 0) {
                toastr.error("price is require");
            } else if (status.length == 0) {
                toastr.error("Status is require");
            } else {
                $("#customer_add").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                var addCustomerData = 0;
                $.ajax({
                    type: 'POST',
                    url: 'include/customers_server.php',
                    data: {
                        addCustomerData: addCustomerData,
                        fullname: fullname,
                        package: package,
                        username: username,
                        password: password,
                        mobile: mobile,
                        address: address,
                        expire_date: expire_date,
                        area: area,
                        pop: pop,
                        con_charge: con_charge,
                        price: price,
                        remarks: remarks,
                        nid: nid,
                        status: status,
                        user_type: user_type,
                    },
                    success: function(responseData) {
                        if (responseData == 1) {
                            toastr.success("Added Successfully");
                            $("#addCustomerModal").modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(responseData);
                        }
                    }
                });
            }
        }
    </script>

<iframe name="load_iframe" style="height:0px, width:0px, border:0px"></iframe>
</body>

</html>