<?php
include("include/security_token.php");
include("include/db_connect.php");
include("include/users_right.php");


// //get today new  customer  display frontend 
// if ($cstmr = $con->query("SELECT * FROM customers WHERE pop=$auth_usr_POP_id AND status=1 AND createdate=NOW() ")) {
//     $today_new_customer = ($cstmr->num_rows);
// }
// //get today new  customer  display frontend 
// if ($cstmr = $con->query("SELECT * FROM customers WHERE pop=$auth_usr_POP_id AND  status=1  AND createdate >= DATE_SUB(NOW(), INTERVAL 7 DAY)")) {
//     $last_one_week_customer = ($cstmr->num_rows);
// }

// //get today new  customer  display frontend 
// if ($cstmr = $con->query("SELECT * FROM customers
// WHERE pop=$auth_usr_POP_id AND status=1 AND  createdate>NOW() - INTERVAL 1 MONTH;")) {
//     $last_one_month_customer = ($cstmr->num_rows);
// }




// //get today new  customer  display frontend 
// if ($cstmr = $con->query("SELECT * FROM `customers` WHERE pop=$auth_usr_POP_id AND `expiredate` <= NOW()")) {
//     $expire_customer = ($cstmr->num_rows);
// }
// //get today new  customer  display frontend 
// if ($cstmr = $con->query("SELECT * FROM customers WHERE pop=$auth_usr_POP_id AND status=0 AND user_type=$auth_usr_type")) {
//     $deactive_customer = ($cstmr->num_rows);
// }

// //get today new  customer  display frontend 
// if ($cstmr = $con->query("SELECT * FROM customers WHERE pop=$auth_usr_POP_id AND status=3 AND user_type=$auth_usr_type")) {
//     $customer_request = ($cstmr->num_rows);
// }


?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">

    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <!-- C3 Chart css -->
    <link href="assets/libs/c3/c3.min.css" rel="stylesheet" type="text/css">
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
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
                        <h4 class="page-title">Welcome To Dashboard </h4>
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
                    <div class="row mb-2">
                        <div class="col-md-12 col-sm-6">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#addRechargeModal" class="btn-sm btn btn-primary mb-1"><i class="mdi mdi-battery-charging-90"></i> Recharge Now</button>

                            <button type="button" data-bs-toggle="modal" data-bs-target="#addCustomerModal" class="btn-sm btn btn-success mb-1"><i class="mdi mdi-account-plus"></i> Add Customer</button>

                            <a href="con_request.php" class="btn-sm btn btn-warning mb-1">Connection Request
                                <?php
                                if ($allCstmr = $con->query("SELECT * FROM customers WHERE user_type=$auth_usr_type AND pop=$auth_usr_POP_id AND status=3")) {
                                    //echo $allCstmr->num_rows;
                                    if ($allCstmr->num_rows > 0) {
                                        echo '<span class="badge rounded-pill bg-danger float-end">' . $allCstmr->num_rows . '<span>';
                                    } else {
                                    }
                                }



                                ?>
                            </a>

                            <button type="button" data-bs-toggle="modal" data-bs-target="#sendMessage" class="btn-sm btn btn-primary mb-1"><i class="far fa-envelope"></i> SMS Notification</button>

                            <button type="button" data-bs-toggle="modal" data-bs-target="#addTicketModal" class="btn-sm btn btn-success mb-1">Add Ticket</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <a href="customers.php">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-purple me-0 float-end"><i class=" far fa-user"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-purple">
                                                    <?php if ($totalCustomer = $con->query("SELECT * FROM customers WHERE  pop=$auth_usr_POP_id ")) {
                                                        echo  $totalCustomer->num_rows;
                                                    }

                                                    ?>
                                                </span>
                                                Total Customers
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div> <!--End col -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-success me-0 float-end"><i class="fas fa-globe"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-green">
                                                <?php
                                                $sql = "SELECT radacct.username FROM radacct
                                                INNER JOIN customers
                                                ON customers.username=radacct.username
                                                
                                                WHERE customers.pop='$auth_usr_POP_id' AND radacct.acctstoptime IS NULL";
                                                $countpoponlnusr = mysqli_query($con, $sql);

                                                echo $countpoponlnusr->num_rows;
                                                


                                                ?>
                                            </span>
                                            Online
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End col -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <a href="customer_expire.php">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-danger me-0 float-end"><i class="fas fa-exclamation-triangle"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-danger">
                                                    <?php
                                                    
                                                    $todayDate=date('Y-m-d');
                                                     if ($AllExcstmr = $con->query("SELECT * FROM customers WHERE expiredate < NOW() AND user_type=$auth_usr_type AND pop=$auth_usr_POP_id")) {
                                                        echo  $AllExcstmr->num_rows;
                                                    }

                                                    ?>

                                                </span>
                                                Expired
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div> <!-- End col -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-teal me-0 float-end"><i class=" fas fa-calendar-times"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-teal">
                                                <?php if ($dsblcstmr = $con->query("SELECT * FROM customers WHERE status='0'AND user_type=$auth_usr_type AND pop=$auth_usr_POP_id")) {
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
                                                if ($pop_payment = $con->query(" SELECT SUM(`amount`) AS balance FROM `pop_transaction` WHERE pop_id='$auth_usr_POP_id' ")) {
                                                    while ($rows = $pop_payment->fetch_array()) {
                                                        $currentBal += $rows["balance"];
                                                    }
                                                    if ($pop_payment = $con->query(" SELECT `purchase_price` FROM `customer_rechrg` WHERE pop_id='$auth_usr_POP_id' ")) {
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

                                                if ($pop_payment = $con->query(" SELECT `paid_amount` FROM `pop_transaction` WHERE pop_id='$auth_usr_POP_id' ")) {
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
                                                if ($pop_payment = $con->query("SELECT SUM(amount) AS balance FROM `pop_transaction` WHERE pop_id=$auth_usr_POP_id  ")) {
                                                    while ($rows = $pop_payment->fetch_array()) {
                                                        $totalAmount += $rows["balance"];
                                                    }
                                                    $totalAmount;
                                                }

                                                if ($pop_payment = $con->query("SELECT SUM(paid_amount) AS amount FROM `pop_transaction` WHERE pop_id=$auth_usr_POP_id  ")) {
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
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                    <div class="col-md-7 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">

                                <div class="table-responsive">
                                        <table id="expire_customer_datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                <th>ID</th>
                                                    <th>POP Name</th>
                                                    <th>Total</th>
                                                    <th><img src="images/icon/online.png" height="10" width="10"/> Online</th>
                                                    <th><img src="images/icon/expired.png" height="10" width="10"/> Expired</th>
                                                    <th><img src="images/icon/disabled.png" height="10" width="10"/> Disabled</th>
                                                   
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $sql = "SELECT * FROM area_list WHERE pop_id='$auth_usr_POP_id'";
                                                $result = mysqli_query($con, $sql);

                                                while ($rows = mysqli_fetch_assoc($result)) {
                                                   $areaid = $rows['id'];
                                                ?>

                                                    <tr>
                                                        <td><?php echo $rows['id']; ?></td>
                                                        <td><a href="view_area.php?id=<?php echo $areaid; ?>"><?php echo $rows['name']; ?></a></td>
                                                        <td>
                                                            <?php

                                                                $sql = "SELECT * FROM customers WHERE area='$areaid'";
                                                                $countareausr = mysqli_query($con, $sql);

                                                                echo $countareausr->num_rows;

                                                            ?>

                                                        </td>
                                                        <td>
                                                            <?php

                                                                $sql = "SELECT radacct.username FROM radacct
                                                                INNER JOIN customers
                                                                ON customers.username=radacct.username
                                                                
                                                                WHERE customers.area='$areaid' AND radacct.acctstoptime IS NULL";
                                                                $countareaonlnusr = mysqli_query($con, $sql);

                                                                echo $countareaonlnusr->num_rows;

                                                            ?>

                                                        </td>
                                                        <td>
                                                            <?php
                                                                $sql = "SELECT * FROM customers WHERE area='$areaid' AND NOW() > expiredate";
                                                                $countxprd = mysqli_query($con, $sql);
                                                                 $totalexprs = $countxprd->num_rows;
                                                                if($totalexprs == 0)
                                                                {
                                                                    echo $totalexprs;   

                                                                }
                                                                else{

                                                                    echo "<span class='badge bg-danger'>$totalexprs</span>";
                                                                }
                                                            
                                                                //
                                                            
                                                            ?>
                                                        </td>

                                                        <td>
                                                            <?php
                                                                $disableQ = "SELECT * FROM customers WHERE area='$areaid' AND status='0'";
                                                                $countdsbld = mysqli_query($con, $disableQ);
                                                                 $totaldsbld = $countdsbld->num_rows;
                                                                if($totaldsbld == 0)
                                                                {
                                                                    echo $totaldsbld;   

                                                                }
                                                                else{

                                                                    echo "<span class='badge bg-danger'>$totaldsbld</span>";
                                                                }
                                                            
                                                                //
                                                            
                                                            ?>
                                                        </td>
                                                   
                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                            





                                </div>
                            </div>
                        </div>

                        <div class="col-xl-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>Tickets</p>
                                        </div>
                                        <div class="col-md-4">
                                            <button style="float: right;">
                                                <a href="allTickets.php">+</a>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="tickets_table" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Complain Type</th>
                                                    <th>Ticket Type</th>
                                                    <th>Form Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="ticket-list">
                                                <?php
                                                $sql = "SELECT * FROM ticket WHERE pop_id=$auth_usr_POP_id LIMIT 5";
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
                                                                echo "<span class='badge bg-danger'>Active</span>";
                                                            } else if ($ticketType == "Open") {
                                                                echo "<span class='badge bg-info'>Open</span>";
                                                            } else if ($ticketType == "New") {
                                                                echo "<span class='badge bg-danger'>New</span>";
                                                            } else if ($ticketType == "Complete") {
                                                                echo "<span class='badge bg-success'>Complete</span>";
                                                            }

                                                            ?>

                                                        </td>

                                                        <td><?php echo $rows["startdate"]; ?></td>

                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end row -->


                   
                    <!-- end row -->

                    <div class="row">
                        <div class="card">
                            <div class="card-body">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#branch_user" role="tab">
                                            <span class="d-none d-md-block">Users (

                                                <?php if ($totalCustomers = $con->query("SELECT * FROM customers WHERE   pop=$auth_usr_POP_id ")) {
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
                                            <div class="card-header">
                                                <div class="row d-flex">
                                                    <div style="width:50%; float: left;">

                                                    </div>
                                                    <div style="width:50%; float: right;">
                                                        <button type="button" data-bs-target="#addCustomerModal" data-bs-toggle="modal" class="btn-sm btn btn-primary" style="float:right;" type="button" id=""><i class="mdi mdi-account-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
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
                                                        $sql = "SELECT * FROM customers WHERE pop='$auth_usr_POP_id'  ";
                                                        $result = mysqli_query($con, $sql);

                                                        while ($rows = mysqli_fetch_assoc($result)) {
                                                            $username = $rows["username"];

                                                        ?>

                                                            <tr>
                                                                <td><?php echo $rows['id']; ?></td>
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
                                                                 echo " ". $rows["fullname"]; ?></a></td>
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
                                                        $sql = "SELECT * FROM ticket WHERE pop_id='$auth_usr_POP_id' ";
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
                                                        $sql = "SELECT * FROM customer_rechrg WHERE pop_id='$auth_usr_POP_id'  ";
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
                                                                <td><?php echo $rows["amount"]; ?></td>

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
                                                        $sql = "SELECT * FROM branch_package WHERE pop_id='$auth_usr_POP_id' ";
                                                        $result = mysqli_query($con, $sql);

                                                        while ($rows = mysqli_fetch_assoc($result)) {

                                                        ?>

                                                            <tr>
                                                                <td><?php echo $increment++; ?></td>
                                                                <td>
                                                                    <?php

                                                                    echo  $rows["package_name"];
                                                                    // $allPackageee = $con->query("SELECT * FROM radgroupcheck WHERE id=$packageNameId ");
                                                                    // while ($popRowwww = $allPackageee->fetch_array()) {
                                                                    //     echo $popRowwww['groupname'];
                                                                    // }


                                                                    ?>
                                                                </td>
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
                                                        $sql = "SELECT * FROM pop_transaction WHERE pop_id='$auth_usr_POP_id'  ";
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
                                                                    $transaction_type = $rows["transaction_type"];

                                                                    if ($transaction_action == 'Recharge' && $transaction_type == '0') {
                                                                        echo  '<span class="badge bg-danger">Recharged</span> <br> <span class="badge bg-success">Paid</span>';
                                                                    } else if ($transaction_action == 'Recharge' && $transaction_type == '1') {
                                                                        echo  '<span class="badge bg-danger">Recharged </span>';
                                                                    } else if ($transaction_action == 'paid') {
                                                                        echo  '<span class="badge bg-success">Paid</span>';
                                                                    } else if ($transaction_action == 'Return') {
                                                                        echo  '<span class="badge bg-warning">Return</span>';
                                                                    }




                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    $transaction_type = $rows["transaction_type"];
                                                                    if ($transaction_type == 0) {
                                                                        echo  '<button class="btn-sm btn btn-outline-success">Cash</button>';
                                                                    } elseif ($transaction_type == 1) {
                                                                        echo  '<button class="btn-sm btn btn-outline-danger">Credit</button>';
                                                                    } elseif ($transaction_type == 2) {
                                                                        echo 'Bkash';
                                                                    } elseif ($transaction_type == 3) {
                                                                        echo 'Nagad';
                                                                    } elseif ($transaction_type == 4) {
                                                                        echo 'Bank';
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

    <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addRechargeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Recharge</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card">
                    <div class="row" id="searchRow">
                        <div class="col-md col-sm m-auto">
                            <div class="card shadow">
                                
                                <div class="card-body">
                                <form action="">
                                        <div class="form-gruop mb-2">
                                            <label>Select Customer</label>

                                            <select type="text" id="recharge_customer" class="form-select">
                                                <option value="">Select Item</option>
                                                <?php
                                                if ($allCustomer = $con->query("SELECT * FROM customers WHERE pop=$auth_usr_POP_id ")) {
                                                    while ($rows = $allCustomer->fetch_array()) {
                                                        echo '<option value="' . $rows['id'] . '">' . $rows['username'] . '(' . $rows['mobile'] . ')</option>';
                                                    }
                                                }


                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label>Month</label>
                                            <select id="recharge_customer_month" class="form-select">
                                                <option value="">Select</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                        <div class="form-group ">
                                            <label for="">Package</label>
                                            <select disabled="Disable" id="recharge_customer_package" class="form-select ">

                                            </select>
                                        </div>
                                        <div class="form-group mb-1 ">
                                            <label>Package Price:</label>

                                            <input id="recharge_customer_package_price" disabled="Disable" type="text" class="form-control " value="">
                                        </div>
                                        <div class="form-group mb-1 ">
                                            <label>Ref:</label>

                                            <input id="ref"  type="text" class="form-control " value="">
                                        </div>
                                        <div class="form-group mb-1 d-none">
                                            <label>Pop id:</label>

                                            <input id="recharge_customer_pop_id" disabled="Disable" type="text" class="form-control form-control-sm" value="">
                                        </div>
                                        <div class="form-group mb-1 ">
                                            <label>Payable Amount:</label>
                                            <input id="recharge_customer_amount" disabled type="text" class="form-control form-control-sm" value="" />
                                        </div>
                                        <div class="form-group mb-1">
                                            <label>Transaction Type:</label>
                                            <select id="recharge_customer_transaction_type" class="form-select">
                                                <option value="">Select</option>
                                                <option value="1">Cash</option>
                                                <option value="0">On Credit</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-success" style="width: 100%;" type="button" id="add_recharge_btn"><i class="mdi mdi mdi-battery-charging-90"></i>&nbsp;&nbsp;Recharge Now</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!---add send msg modal---->
    <div id="sendMessage" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Send Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Customer Account</label>
                                <select name="cstmr_ac" id="cstmr_ac" class="form-select select2" style="width:100%;">
                                    <option>Select</option>
                                    <?php

                                    if ($allCstmr = $con->query("SELECT * FROM customers WHERE user_type=$auth_usr_type AND status=1 ")) {
                                        while ($rows = $allCstmr->fetch_array()) {
                                            echo '<option value=' . $rows['id'] . '>' . $rows['fullname'] . '</option>';
                                        }
                                    }

                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group mb-2">
                                <label>Customer Phone No.</label>
                                <input id="phone" type="text" name="phone" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group mb-2">
                                <label>Message Template</label>
                                <select class="form-select" id="currentMessageTemp" onchange="currentMsgTemp()">
                                    <option>Select</option>
                                    <?php
                                    if ($allCstmr = $con->query("SELECT * FROM message_template WHERE user_type=$auth_usr_type")) {
                                        while ($rows = $allCstmr->fetch_array()) {
                                            echo '<option value=' . $rows['id'] . '>' . $rows['template_name'] . '</option>';
                                        }
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Message</label>
                                <textarea id="message" rows="5" placeholder="Enter Your Message" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light">Send Message</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="addTicketModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Add Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group mb-2">
                                <label for="">Ticket Type</label>
                                <select id="ticket_type" name="ticket_type" class="form-select">
                                    <option value="">Select</option>
                                    <option value="Active">Active</option>
                                    <option value="New">New</option>
                                    <option value="Open">Open</option>
                                    <option value="Complete">Complete</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group mb-2">
                                <label for="">Assigned To</label>
                                <select id="assigned" name="assigned" class="form-select">
                                    <option value="">Select</option>
                                    <option value="SR Comunication">SR Comunication</option>
                                    <option value="Ali Hossain">Ali Hossain</option>
                                    <option value="Ali Hossain">Ali Hossain</option>
                                    <option value="Support">Support</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group mb-2">
                                <label for="">Ticket For</label>
                                <select id="ticket_for" name="ticket_for " class="form-select">
                                    <option value="">Select</option>
                                    <option value="Reseller">Reseller</option>
                                    <option value="Corporate">Corporate</option>
                                    <option value="Home Connection">Home Connection</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group mb-2">
                                <label for=""> Complain Type </label>
                                <select id="complain_type" name="complain_type" class="form-select">
                                    <option value="">Select</option>
                                    <?php

                                    if ($allData = $con->query("SELECT * FROM ticket_topic WHERE user_type=$auth_usr_type AND pop_id=$auth_usr_POP_id")) {
                                        while ($rows = $allData->fetch_array()) {
                                            echo ' <option value=' . $rows['id'] . '>' . $rows['topic_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-sm">
                            <div class="form-group mb-2">
                                <label for="">Form Date</label>
                                <input id="from_date" name="from_data" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="">To Date</label>
                                <input id="to_date" type="date" name="to_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input class="d-none" type="text" id="user_type" value="<?php echo $auth_usr_type; ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-sm btn btn-danger waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="addTicketConfirmBtn" class="btn-sm btn btn-primary waves-effect waves-light">Add Ticket</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
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
                                                        if ($pop = $con->query("SELECT * FROM add_pop WHERE id=$auth_usr_POP_id")) {
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
    <script src="assets/libs/select2/js/select2.min.js"></script>
    <script src="js/toastr/toastr.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            //datatable 
            $("#expire_customer_datatable").DataTable();
            $("#ticket_datatable").DataTable();
            $("#transaction_datatable").DataTable();
            $("#package_datatable").DataTable();
            $("#branch_datatable").DataTable();
            $("#recharge_history_datatable").DataTable();



            //select 2 input box
            $('#customerId').select2();


            //recharge script
            $("#recharge_customer").on('change', function() {
    var id = $("#recharge_customer").val();
    getCustomerPackage(id);
    getCustomerPackagePrice(id);
    getCustomerPopId(id);

});

//get Package name
function getCustomerPackage(recevedId) {
    var customerId = recevedId;
    $.ajax({
        url: 'include/customers_server.php',
        method: 'POST',
        data: {
            id: customerId,
            getCustomerSpecificId: 0
        },
        //dataType: 'json',
        success: function(responseData) {
            $("#recharge_customer_package").html(responseData);
        },
        error: function(xhr, textStatus, errorThrown) {
            // Handle any errors here
            console.error('An error occurred:', errorThrown);
        }
    });
}
//get Package price
function getCustomerPackagePrice(recevedId) {
    var customerId = recevedId;
    $.ajax({
        url: 'include/customers_server.php',
        method: 'POST',
        data: {
            id: customerId,
            getCustomerPackagePrice: 0
        },
        //dataType: 'json',
        success: function(responseData) {
            $("#recharge_customer_package_price").val(responseData);
        },
        error: function(xhr, textStatus, errorThrown) {
            // Handle any errors here
            console.error('An error occurred:', errorThrown);
        }
    });
}
//get Package price
function getCustomerPopId(recevedId) {
    var customerId = recevedId;
    $.ajax({
        url: 'include/customers_server.php',
        method: 'POST',
        data: {
            id: customerId,
            getCustomerPop: 0
        },
        //dataType: 'json',
        success: function(responseData) {
            $("#recharge_customer_pop_id").val(responseData);
        },
        error: function(xhr, textStatus, errorThrown) {
            // Handle any errors here
            console.error('An error occurred:', errorThrown);
        }
    });
}
//get recharge Calculation
getCalculation();

function getCalculation() {
    $(document).on('change', "#recharge_customer_month", function() {
        var month = $("#recharge_customer_month").val();
        var price = $("#recharge_customer_package_price").val();
        var totalAmount = Number(month * price);
        $("#recharge_customer_amount").val(totalAmount);
    });
}

//customer recharge script

$(document).on('click', '#add_recharge_btn', function() {
    var customer_id = $("#recharge_customer").val();
    var month = $("#recharge_customer_month").val();
    var package = $("#recharge_customer_package").val();
    var mainAmount = $("#recharge_customer_amount").val();
    var tra_type = $("#recharge_customer_transaction_type").val();
    var pop_id = $("#recharge_customer_pop_id").val();
    var ref = $("#ref").val();
    sendData(customer_id, month, package, mainAmount, tra_type, pop_id,ref);
});
const sendData = (customer_id, month, package, mainAmount, tra_type, pop_id,ref) => {

    if (month.length == 0) {
        toastr.error("Select Month");
    } else if (customer_id.length == 0) {
        toastr.error("Select Customer");
    } else if (tra_type.length == 0) {
        toastr.error("Select Transaction");
    } else {
        $("#add_recharge_btn").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $.ajax({
            type: 'POST',
            url: 'include/customer_recharge_server.php',
            data: {
                customer_id: customer_id,
                month: month,
                package: package,
                amount: mainAmount,
                tra_type: tra_type,
                pop_id: pop_id,
                RefNo: ref,
                add_recharge_data:0
            },
            success: function(response) {
                if (response == 1) {
                    $("#add_recharge_btn").html('Recharge Now');
                    $("#addRechargeModal").modal('hide');
                    toastr.success("Recharge Successful");
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(response);
                    $("#add_recharge_btn").html('Recharge Now');
                }



            }
        });



    }

}












            //////////////////////////////// ADD CUSTOMER SCRIPT ///////////////////////////////////////////////////
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
                            $("#customer_add").html('Add Customer');
                            toastr.success("Added Successfully");
                            $("#addCustomerModal").modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(responseData);
                            $("#customer_add").html('Add Customer');
                        }
                    }
                });
            }
        }







            //////////////////////////////// ADD Message SCRIPT ///////////////////////////////////////////////////
            $(document).on('change', '#currentMessageTemp', function() {
                var name = $("#currentMessageTemp").val();
                var currentMsgTemp = "0";
                $.ajax({
                    type: 'POST',
                    data: {
                        name: name,
                        currentMsgTemp: currentMsgTemp
                    },
                    url: 'include/message.php',
                    success: function(response) {
                        console.log(response);
                        $("#message").val(response);
                    }
                });
            });
            $(document).on('change', '#cstmr_ac', function() {
                var name = $("#cstmr_ac").val();
                var currentCstmrAc = "0";
                $.ajax({
                    type: 'POST',
                    data: {
                        name: name,
                        currentCstmrAc: currentCstmrAc
                    },
                    url: 'include/message.php',
                    success: function(response) {
                        console.log(response);
                        $("#phone").val(response);
                    }
                });
            });











            //////////////////////////////// ADD Message SCRIPT ///////////////////////////////////////////////////
            $("#addTicketConfirmBtn").click(function() {
                var ticket_type = $("#ticket_type").val();
                var assigned = $("#assigned").val();
                var ticket_for = $("#ticket_for").val();
                var pop = <?php echo $auth_usr_POP_id; ?>;
                var complain_type = $("#complain_type").val();
                var from_date = $("#from_date").val();
                var to_date = $("#to_date").val();
                var user_type = $("#user_type").val();
                if (ticket_type.length == 0) {
                    toastr.error('Ticket type required');
                } else if (assigned.length == 0) {
                    toastr.error('Assigned required');
                } else if (ticket_for.length == 0) {
                    toastr.error('Ticket for required');
                } else if (pop.length == 0) {
                    toastr.error('POP/Branch is required');
                } else if (complain_type.length == 0) {
                    toastr.error('Complain type for required');
                } else if (from_date.length == 0) {
                    toastr.error('From Date required');
                } else if (to_date.length == 0) {
                    toastr.error('To Date required');
                } else {
                    var addTicketData = "0";
                    $.ajax({
                        type: "POST",
                        data: {
                            type: ticket_type,
                            assigned: assigned,
                            ticket_for: ticket_for,
                            complain_type: complain_type,
                            from_date: from_date,
                            to_date: to_date,
                            addTicketData: addTicketData,
                            user_type: user_type,
                            pop: pop
                        },
                        url: "include/tickets.php",
                        success: function(response) {
                            if (response == 1) {
                                toastr.success("Ticket Create Successfully");
                                $("#addTicketModal").modal('hide');
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            } else {
                                toastr.error("Please try again");
                            }
                        }
                    });
                }
            });




            ////////////////////////////////  customer static SCRIPT ///////////////////////////////////////////////////


            //customer static 
            var xValues = [1, 2, 3, 4, 5, 6];

            new Chart("myChart", {
                type: "line",
                data: {
                    labels: xValues,
                    datasets: [{
                        data: [2, 1140, 1060, 1060, 1070, 1110],
                        borderColor: "red",
                        fill: false
                    }, {
                        data: [1600, 1700, 1700, 1900, 2000, 2700],
                        borderColor: "green",
                        fill: false
                    }, {
                        data: [13, 500, 400, 700, 900, 1000],
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




            

            

            
        });
    </script>




</body>

</html>