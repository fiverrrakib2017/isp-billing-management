<?php
date_default_timezone_set("Asia/Dhaka");
include("include/security_token.php");
include("include/db_connect.php");
include("include/users_right.php");
include("include/pop_security.php");

function timeAgo($startdate) {
    /*Convert startdate to a timestamp*/ 
    $startTimestamp = strtotime($startdate);
    $currentTimestamp = time();
    
    /* Calculate the difference in seconds*/
    $difference = $currentTimestamp - $startTimestamp;

    /*Define time intervals*/ 
    $units = [
        'year' => 31536000,
        'month' => 2592000,
        'week' => 604800,
        'day' => 86400,
        'hour' => 3600,
        'min' => 60,
        'second' => 1
    ];

    /*Check for each time unit*/ 
    foreach ($units as $unit => $value) {
        if ($difference >= $value) {
            $time = floor($difference / $value);
            return '<img src="images/icon/online.png" height="10" width="10"/>'.' '.$time . ' ' . $unit . ($time > 1 ? 's' : '') . '';
        }
    }
    /*If the difference is less than a second*/
    return '<img src="images/icon/online.png" height="10" width="10"/> just now';  
}



?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SYSTEM</title>
    
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
        <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
        <link href="assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet" type="text/css">
        <link href="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
    
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
        <!-- Chartist Chart -->
        <link href="assets/libs/chartist/chartist.min.css" rel="stylesheet">
<!-- C3 Chart css -->
        <link href="assets/libs/c3/c3.min.css" rel="stylesheet" type="text/css">
        <link href="css/toastr/toastr.min.css" rel="stylesheet" type="text/css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"> </script>
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
                    <div class="row mb-2">
                        <div class="col-md-12 col-sm-6">
                            <button type="button"  data-bs-toggle="modal" data-bs-target="#addRechargeModal" class="btn-sm btn btn-primary mb-1"><i class="mdi mdi-battery-charging-90"></i> Recharge Now</button>

                            <button type="button" data-bs-toggle="modal" data-bs-target="#addCustomerModal" class="btn-sm btn btn-success mb-1"><i class="mdi mdi-account-plus"></i> Add Customer</button>

                            <a href="con_request.php" class="btn-sm btn btn-warning mb-1">Connection Request
                                <?php
                                if ($allCstmr = $con->query("SELECT * FROM customers WHERE user_type='1' AND status=3")) {
                                    //echo $allCstmr->num_rows;
                                    if ($allCstmr->num_rows > 0) {
                                        echo '<span class="badge rounded-pill bg-danger float-end">' . $allCstmr->num_rows . '<span>';
                                    } else {
                                    }
                                }



                                ?>
                            </a>

                            <button type="button" id="addSmsBtn" class="btn-sm btn btn-primary mb-1"><i class="far fa-envelope"></i> SMS Notification</button>

                            <button type="button" id="AddTicketBtn" class="btn-sm btn btn-success mb-1">Add Ticket</button>
                        </div>
                    </div>
                    <div class="row">

                    <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-success me-0 float-end"><i class="fas fa-user-check"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-success">
                                                <?php
                                                if ($onlinecstmr = $con->query("SELECT * FROM radacct WHERE acctterminatecause=''")) {
                                                echo $onlinecstmr->num_rows;
                                                }
                                                ?>
                                            </span>
                                            Online
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End col -->

                        <div class="col-md-6 col-xl-3">
                            <a href="customers.php">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-primary me-0 float-end"><i class="fas fa-users"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-purple">
                                                    <?php if ($totalCustomer = $con->query("SELECT * FROM customers")) {
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
                                <a href="customer_expire.php">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-warning me-0 float-end"><i class="fas fa-exclamation-triangle"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-danger">
                                                    <?php if ($AllExcstmr = $con->query("SELECT * FROM `customers` WHERE  NOW() > expiredate")) {
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
                            <a href="customer_disabled.php">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-danger me-0 float-end"><i class="fas fa-user-slash"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-teal">
                                                <?php if ($dsblcstmr = $con->query("SELECT * FROM customers WHERE status='0'")) {
                                                    echo  $dsblcstmr->num_rows;
                                                }
                                                ?>
                                            </span>
                                            Disabled
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>
                        </div><!--end col -->
                    </div> <!-- end row-->
					
					<!-- New Row-->
					 <div class="row">

                    <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-brown me-0 float-end"><i class="fas fa-code-branch"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-success">
                                                <?php
                                                if ($onlinecstmr = $con->query("SELECT * FROM add_pop")) {
                                                echo $onlinecstmr->num_rows;
                                                }
                                                ?>
                                            </span>
                                            POP/Branch
											<br/>
											<a href="pop_branch.php">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End col -->

                        <div class="col-md-6 col-xl-3">
                            
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-teal me-0 float-end"><i class="fas fa-search-location"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-purple">
                                                    <?php if ($totalCustomer = $con->query("SELECT * FROM area_list")) {
                                                        echo  $totalCustomer->num_rows;
                                                    }

                                                    ?>
                                                </span>
                                                Area
												<br/>
											<a href="pop_area.php">View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                        </div> <!--End col -->


                        
                        

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <a href="customer_expire.php">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-success me-0 float-end"><i class="fas fa-money-bill-wave"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-danger">
                                                    <?php if ($AllExcstmr = $con->query("SELECT * FROM `customers` WHERE  NOW() > expiredate")) {
                                                        echo  $AllExcstmr->num_rows;
                                                    }

                                                    ?>
                                                </span>
                                                Revenew
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
                                        <span class="mini-stat-icon bg-warning me-0 float-end"><i class="far fa-sticky-note"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-teal">
                                                <?php if ($dsblcstmr = $con->query("SELECT * FROM ticket")) {
                                                    echo  $dsblcstmr->num_rows;
                                                }
                                                ?>
                                            </span>
                                            Tickets
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col -->
                    </div> <!-- end row-->


                    <div class="row">

                         <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                <div >
                                        <table  class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                                $sql = "SELECT * FROM add_pop LIMIT 5";
                                                $result = mysqli_query($con, $sql);

                                                while ($rows = mysqli_fetch_assoc($result)) {
                                                   $pop_ID = $rows['id'];
                                                ?>

                                                    <tr>
                                                        <td><?php echo $rows['id']; ?></td>
                                                        <td><a href="view_pop.php?id=<?php echo $pop_ID; ?>"><?php echo $rows['pop']; ?></a></td>
                                                        <td>
                                                            <?php

                                                                $sql = "SELECT * FROM customers WHERE pop='$pop_ID'";
                                                                $countpopusr = mysqli_query($con, $sql);

                                                                echo $countpopusr->num_rows;

                                                            ?>

                                                        </td>
                                                        <td>
                                                            <?php

                                                                $sql = "SELECT radacct.username FROM radacct
                                                                INNER JOIN customers
                                                                ON customers.username=radacct.username
                                                                
                                                                WHERE customers.pop='$pop_ID' AND radacct.acctstoptime IS NULL";
                                                                $countpoponlnusr = mysqli_query($con, $sql);

                                                                echo $countpoponlnusr->num_rows;

                                                            ?>

                                                        </td>
                                                        <td>
                                                            <?php
                                                                $sql = "SELECT * FROM customers WHERE pop='$pop_ID' AND NOW() > expiredate";
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
                                                                $disableQ = "SELECT * FROM customers WHERE pop='$pop_ID' AND status='0'";
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

                        <div class="col-xl-6">
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
                                                    <th>Status</th> 
                                                    <th>Created</th>
                                                    <th>Customer Name</th>
                                                    <th>Issues</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="ticket-list">
                                            <?php
                                                $sql = "SELECT * FROM `ticket` ORDER BY id DESC limit 5";
                                                $result = mysqli_query($con, $sql);

                                                while ($rows = mysqli_fetch_assoc($result)) {

                                                ?>

                                                    <tr>
                                                       
                                                        <td>
                                                            <?php 
                                                            $ticketType = $rows["ticket_type"];
                                                            
                                                            if ($ticketType === "Complete"): ?>
                                                                
                                                                <a href="tickets_profile.php?id=<?php echo $rows['id']; ?>">
                                                                    <span class="badge bg-success">Completed</span>
                                                                </a>
                                                            <?php elseif ($ticketType === "Active"): ?>
                                                                
                                                                <a href="tickets_profile.php?id=<?php echo $rows['id']; ?>">
                                                                    <span class="badge bg-danger">Active</span>
                                                                </a>
                                                            <?php elseif ($ticketType === "Close"): ?>
                                                                
                                                                <a href="tickets_profile.php?id=<?php echo $rows['id']; ?>">
                                                                    <span class="badge bg-success">Close</span>
                                                                </a>
                                                            <?php else: ?>
                                                                <a href="tickets_profile.php?id=<?php echo $rows['id']; ?>"><?php echo $ticketType; ?></a>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                             $startdate = $rows["startdate"];
                                                             echo timeAgo($startdate); 
                                                            ?>
                                                            
                                                        </td>
                                                        <td>
                                                        <?php 
                                                            $customer_id= $rows['customer_id']; 
                                                            $customer = $con->query("SELECT * FROM customers WHERE id=$customer_id ");
                                                            while ($stmr = $customer->fetch_array()) {
                                                                 $cstmrID = $stmr['id'];
																 $username = $stmr['username'];
																 $cstmr_fullname = $stmr['fullname'];
                                                            }
                                                        ?>
														
                                                            <?php 
                                                            
                                                            $onlineusr = $con->query("SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username='$username'");
                                                            $chkc = $onlineusr->num_rows;
                                                            if($chkc==1)
                                                            {
                                                                echo '<abbr title="Online"><img src="images/icon/online.png" height="10" width="10"/></abbr>';
                                                            } else{
                                                                echo '<abbr title="Offline"><img src="images/icon/offline.png" height="10" width="10"/></abbr>';

                                                            }
                                                 
                                                            
                                                            ?>
                                                        
                                                        
                                                        <a href="profile.php?clid=<?php echo $cstmrID; ?>" target="_blank"> <?php echo $cstmr_fullname; ?></a></td>
                                                        
                                                        </td>
                                                        <td>
                                                             <?php
                                                            $complain_typeId = $rows["complain_type"];
                                                            if ($allCom = $con->query("SELECT * FROM ticket_topic WHERE id='$complain_typeId' ")) {
                                                                while ($rowss = $allCom->fetch_array()) {
                                                                    echo $rowss['topic_name'];
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            
                                                            <a class="btn-sm btn btn-success" href="tickets_profile.php?id=<?php echo $rows['id']; ?>"><i class="fas fa-eye"></i>
                                                            </a>


                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <!------------ ------------->

                         














                            <!---------------------->
                        </div>






                    </div>
                    <!-- end row -->
                    


                     <div class="row">
					 <div class="col-md-6 grid-margin stretch-card">
					 <div class="card">
                                <div class="card-body">
                                    	<h4 class="card-title mb-4">Ticket Statics 10 Days</h4>					
									

                                         <div class="row text-center mt-4">
                                            <div class="col-3">
                                                <h5 class="mb-0 font-size-18">
												<?php
												$daystkt = date("Y-m-d", strtotime('-7 day'));
												$tktsql = $con->query("SELECT * FROM ticket WHERE startdate BETWEEN '$daystkt' AND NOW()");
												echo $tktsql->num_rows;
												?>
												
												</h5>
                                                <p class="text-muted text-truncate">Tickets</p>
                                            </div>
                                            <div class="col-3">
                                                <h5 class="mb-0 font-size-18">
												<?php
												$daystkt = date("Y-m-d", strtotime('-7 day'));
												$tktsql = $con->query("SELECT * FROM ticket WHERE ticket_type='Complete' AND startdate BETWEEN '$daystkt' AND NOW()");
												echo $tktsql->num_rows;
												?>
												
												</h5>
                                                <p class="text-muted text-truncate">Resolved</p>
                                            </div>
                                            <div class="col-3">
                                                <h5 class="mb-0 font-size-18">
												<?php
												$daystkt = date("Y-m-d", strtotime('-7 day'));
												$tktsql = $con->query("SELECT * FROM ticket WHERE ticket_type='Active' AND startdate BETWEEN '$daystkt' AND NOW()");
												echo $tktsql->num_rows;
												?>
												</h5>
                                                <p class="text-muted text-truncate">Pending</p>
                                            </div>
											
											<div class="col-3">
                                                <h5 class="mb-0 font-size-18">
												<?php
												$daystkt = date("Y-m-d", strtotime('-7 day'));
												$tktsql = $con->query("SELECT * FROM ticket WHERE ticket_type='Close' AND startdate BETWEEN '$daystkt' AND NOW()");
												echo $tktsql->num_rows;
												?>
												</h5>
                                                <p class="text-muted text-truncate danger">Closed</p>
                                            </div>
											
                                        </div>

                                        <div id="chart" dir="ltr"></div>
									
									
									
									
									
                                </div>
                            </div>
							</div>
							
							
                        <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title mb-4">Customer Statics</h4>

                                        <div class="row text-center mt-4">
                                            <div class="col-4">
                                                <h5 class="mb-0 font-size-18">50</h5>
                                                <p class="text-muted text-truncate">New</p>
                                            </div>
                                            <div class="col-4">
                                                <h5 class="mb-0 font-size-18">44</h5>
                                                <p class="text-muted text-truncate">Expired</p>
                                            </div>
                                            <div class="col-4">
                                                <h5 class="mb-0 font-size-18">32</h5>
                                                <p class="text-muted text-truncate">Disabled</p>
                                            </div>
                                        </div>

                                        <div id="simple-line-chart" class="ct-chart ct-golden-section" dir="ltr"></div>

                                    </div>
                                </div>
                        </div>


                    </div> 
                    <!-- end row -->

                    <div class="row">
                        <div class="col-md-6 stretch-card">
                            <div class="card">
                                <div class="card-body">



                                    <div class="row">
                                        <div class="col-md-8 mt-1 py-2">
                                            <p class="card-title ">Recent Customers</p>
                                        </div>
                                        <div class="col-md-4">
                                            <button style="float: right;">
                                                <a href="customers.php">+</a>
                                            </button>
                                        </div>
                                    </div>



                                    <div class="table-responsive">
                                        <table id="datatables" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Full Name</th>
                                                    
                                                    <th>POP</th>
                                                    <th>Area</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //AND user_type='$auth_usr_type'
                                                $sql = "SELECT * FROM customers ORDER BY id DESC LIMIT 5 ";
                                                $result = mysqli_query($con, $sql);

                                                while ($rows = mysqli_fetch_assoc($result)) {
                                                    $username = $rows["username"];

                                                ?>

                                                    <tr>
                                                        <td><?php echo $rows['id']; ?></td>
                                                        <td><a target="new" href="profile.php?clid=<?php echo $rows['id']; ?>">
                                                        <?php 
                                                        $onlineusr = $con->query("SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username='$username'");
                                                        $chkc = $onlineusr->num_rows;
                                                        if($chkc==1)
                                                        {
                                                            echo '<abbr title="Online"><img src="images/icon/online.png" height="10" width="10"/></abbr>';
                                                        } else{
                                                            echo '<abbr title="Offline"><img src="images/icon/offline.png" height="10" width="10"/></abbr>';

                                                        }
                                                        
                                                        
                                                        echo ' '. $rows["fullname"]; ?></a></td>
                                                        
                                                        <td>
                                                            <?php
                                                            $popID = $rows["pop"];
                                                            $allPOP = $con->query("SELECT * FROM add_pop WHERE id=$popID ");
                                                            while ($popRow = $allPOP->fetch_array()) {
                                                                echo $popRow['pop'];
                                                            }

                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php $id = $rows["area"];
                                                            $allArea = $con->query("SELECT * FROM area_list WHERE id='$id' ");
                                                            while ($popRow = $allArea->fetch_array()) {
                                                                echo $popRow['name'];
                                                            }

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
						
						
						<div class="col-md-6 stretch-card">
                            <div class="card">
                                <div class="card-body">



                                    <div class="row">
                                        <div class="col-md-8 mt-1 py-2">
                                            <p class="card-title ">Recent Expired</p>
                                        </div>
                                        <div class="col-md-4">
                                            <button style="float: right;">
                                                <a href="customers.php">+</a>
                                            </button>
                                        </div>
                                    </div>



                                    <div class="table-responsive">
                                        <table id="datatables" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Full Name</th>
                                                    
                                                    <th>POP</th>
                                                    <th>Area</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //AND user_type='$auth_usr_type'
                                                $sql = "SELECT * FROM customers WHERE expiredate<NOW() ORDER BY id DESC LIMIT 5 ";
                                                $result = mysqli_query($con, $sql);

                                                while ($rows = mysqli_fetch_assoc($result)) {
                                                    $username = $rows["username"];

                                                ?>

                                                    <tr>
                                                        <td><?php echo $rows['id']; ?></td>
                                                        <td><a target="new" href="profile.php?clid=<?php echo $rows['id']; ?>">
                                                        <?php 
                                                        $onlineusr = $con->query("SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username='$username'");
                                                        $chkc = $onlineusr->num_rows;
                                                        if($chkc==1)
                                                        {
                                                            echo '<abbr title="Online"><img src="images/icon/online.png" height="10" width="10"/></abbr>';
                                                        } else{
                                                            echo '<abbr title="Offline"><img src="images/icon/offline.png" height="10" width="10"/></abbr>';

                                                        }
                                                        
                                                        
                                                        echo ' '. $rows["fullname"]; ?></a></td>
                                                        
                                                        <td>
                                                            <?php
                                                            $popID = $rows["pop"];
                                                            $allPOP = $con->query("SELECT * FROM add_pop WHERE id=$popID ");
                                                            while ($popRow = $allPOP->fetch_array()) {
                                                                echo $popRow['pop'];
                                                            }

                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php $id = $rows["area"];
                                                            $allArea = $con->query("SELECT * FROM area_list WHERE id='$id' ");
                                                            while ($popRow = $allArea->fetch_array()) {
                                                                echo $popRow['name'];
                                                            }

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
						
						
						
						
						
						
						
						
                    </div>
					
					
					
					
					
					<div class="row">
					
					<div class="col-md-12 grid-margin stretch-card">
					 <div class="card">
                                <div class="card-body">
                                    	<h4 class="card-title mb-4">Yearly Customer Statics</h4>					
									

                                         <div class="row text-center mt-4">
                                            <div class="col-3">
                                                <h5 class="mb-0 font-size-18">
												<?php
												$daystkt = date("Y-m-d", strtotime('-7 day'));
												$tktsql = $con->query("SELECT * FROM ticket WHERE startdate BETWEEN '$daystkt' AND NOW()");
												echo $tktsql->num_rows;
												?>
												
												</h5>
                                                <p class="text-muted text-truncate">Tickets</p>
                                            </div>
                                            <div class="col-3">
                                                <h5 class="mb-0 font-size-18">
												<?php
												$daystkt = date("Y-m-d", strtotime('-7 day'));
												$tktsql = $con->query("SELECT * FROM ticket WHERE ticket_type='Complete' AND startdate BETWEEN '$daystkt' AND NOW()");
												echo $tktsql->num_rows;
												?>
												
												</h5>
                                                <p class="text-muted text-truncate">Resolved</p>
                                            </div>
                                            <div class="col-3">
                                                <h5 class="mb-0 font-size-18">
												<?php
												$daystkt = date("Y-m-d", strtotime('-7 day'));
												$tktsql = $con->query("SELECT * FROM ticket WHERE ticket_type='Active' AND startdate BETWEEN '$daystkt' AND NOW()");
												echo $tktsql->num_rows;
												?>
												</h5>
                                                <p class="text-muted text-truncate">Pending</p>
                                            </div>
											
											<div class="col-3">
                                                <h5 class="mb-0 font-size-18">
												<?php
												$daystkt = date("Y-m-d", strtotime('-7 day'));
												$tktsql = $con->query("SELECT * FROM ticket WHERE ticket_type='Close' AND startdate BETWEEN '$daystkt' AND NOW()");
												echo $tktsql->num_rows;
												?>
												</h5>
                                                <p class="text-muted text-truncate danger">Closed</p>
                                            </div>
											
                                        </div>

                                        <div id="chart_year" dir="ltr"></div>
								
                                </div>
                            </div>
							</div>
							
							
							
							
							
							
							
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">



                                    <div class="row">
                                        <div class="col-md-8 mt-1 py-2">
                                            <p class="card-title ">New Customers by months</p>
                                        </div>
                                        <div class="col-md-4">
                                            <button style="float: right;">
                                                <a href="customers.php">+</a>
                                            </button>
                                        </div>
                                    </div>



                                    <div class="table-responsive">
                                        <table id="datatables" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Months</th>
                                                    <th>New Conn.</th>
													<th>Expired Conn.</th>
                                                    
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
											<?php
											for($i=1; $i<13; $i++)
											{
												?>
												
												
												
											

                                                    <tr>
													<td><?php echo $i; ?></td>
                                                        <td><?php 
														//$monthDigit = "0".$i;
														$currentyrMnth = date("Y").'-0'.$i;
														echo date("M-Y", strtotime(date("Y").'-'.$i)); ?></td>
                                                        <td>
														<?php
															//AND user_type='$auth_usr_type'
															
															$sql = "SELECT * FROM customers WHERE createdate LIKE '%$currentyrMnth%'";
															$result = mysqli_query($con, $sql);
														     $countconn = mysqli_num_rows($result);	
                                                            echo '<a href="customer_newcon.php?list='.$currentyrMnth.'">'.$countconn.'</a>';											

														?>
														</td>
														
														<td>
														<?php
															//AND user_type='$auth_usr_type'
															
															$sql = "SELECT * FROM customers WHERE expiredate LIKE '%$currentyrMnth%'";
															$result = mysqli_query($con, $sql);
															$countexpconn = mysqli_num_rows($result);
															echo '<a href="customer_expire.php?list='.$currentyrMnth.'">'.$countexpconn.'</a>';
															

														?>
														</td>
														
														                                                                                                               
                                                        
                                                    </tr>
													<?php }	?>
                                                
                                                

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						
						
						
						
						
						
						
						
                    </div>
					
					
					
                    <div class="row">


                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-title">System info</p>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div id="fluid-meter2"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div id="fluid-meter"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div id="fluid-meter1"></div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">


                                        <pre>
<strong>Uptime:</strong>
<?php system("uptime"); ?>
<br />
<strong>System Information:</strong>
<?php system("uname -a"); ?>

<?php
//<strong>CPU Usage:</strong>
$exec_loads = sys_getloadavg();
$exec_cores = trim(shell_exec("grep -P '^processor' /proc/cpuinfo|wc -l"));
$cpu1 = round($exec_loads[1] / ($exec_cores + 1) * 100, 0);

//<strong>RAM Usage%:</strong>
$exec_free = explode("\n", trim(shell_exec('free')));
$get_mem = preg_split("/[\s]+/", $exec_free[1]);
$mem1 = round($get_mem[2] / $get_mem[1] * 100, 0);

//<strong>RAM Usage:</strong>
$exec_free = explode("\n", trim(shell_exec('free')));
print_r( $get_mem = preg_split("/[\s]+/", $exec_free[1]));
$mem = number_format(round($get_mem[2] / 1024 / 1024, 2), 2) . '/' . number_format(round($get_mem[1] / 1024 / 1024, 2), 2);
?>

<strong>System Date & Time:</strong>
<?php
//$exec_uptime = preg_split("/[\s]+/", trim(shell_exec('uptime')));
echo date("D-M-Y")." ".date("h:i:s A")."<br/>";
echo date_default_timezone_get();
?>
<br/>
<strong><span class="mdi-database-clock-outline"></span> Date & Time:</strong>
<?php
//$exec_uptime = preg_split("/[\s]+/", trim(shell_exec('uptime')));
     $dbtime = $con->query("SELECT NOW() AS dbtime");
 $rowd = $dbtime->fetch_assoc();
echo $rowd['dbtime'];

?>


<strong>Uptime:</strong>
<?php
$exec_uptime = preg_split("/[\s]+/", trim(shell_exec('uptime')));
echo $uptime = $exec_uptime[2] . ' Days';
?>
<br/>
<strong>DB Sync:</strong>
<?php
$cronupdt = $con->query("SELECT * FROM cron");
		$rowcron = $cronupdt->fetch_assoc();
			echo $rowcron["date"];
		

?>
<?php 





?>
</pre>




                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © iT-FAST.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Development <i class="mdi mdi-heart text-danger"></i><a target="__blank" href="#">iT-Fast</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <div class="modal fade" id="addRechargeModal" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLabel">Add Recharge</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="recharge_customer" class="form-label">Select Customer</label>
                            <select id="recharge_customer" class="form-select">
                                <option value="">Select Customer</option>
                                <?php
                                if ($allCustomer = $con->query("SELECT * FROM customers")) {
                                    while ($rows = $allCustomer->fetch_array()) {
                                        echo '<option value="' . $rows['id'] . '">' . $rows['username'] . ' (' . $rows['mobile'] . ')</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="recharge_customer_month" class="form-label">Month</label>
                            <select id="recharge_customer_month" class="form-select">
                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="recharge_customer_package" class="form-label">Package</label>
                            <select id="recharge_customer_package" class="form-select" disabled>
                                <!-- Options will be loaded here dynamically -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="recharge_customer_package_price" class="form-label">Package Price</label>
                            <input id="recharge_customer_package_price" type="text" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ref" class="form-label">Reference</label>
                            <input id="ref" type="text" class="form-control">
                        </div>
                        <div class="col-md-6 d-none">
                            <label for="recharge_customer_pop_id" class="form-label">Pop ID</label>
                            <input id="recharge_customer_pop_id" type="text" class="form-control" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="recharge_customer_amount" class="form-label">Payable Amount</label>
                            <input id="recharge_customer_amount" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        
                        <div class="col-md-6">
                            <label for="recharge_customer_transaction_type" class="form-label">Transaction Type</label>
                            <select id="recharge_customer_transaction_type" class="form-select">
                                <option value="1">Cash</option>
                                <option value="0">On Credit</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success mt-4" id="add_recharge_btn" style="margin-top: 4px;">
                                <i class="mdi mdi-battery-charging-90"></i>&nbsp;&nbsp;Recharge Now
                            </button>
                        </div>
                    </div>
                </form>
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
                                <select name="cstmr_ac" id="cstmr_ac" class="form-control select2" onchange="currentCstmrAc()" style="width:100%;">
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
                                    if ($allCstmr = $con->query("SELECT * FROM message_template WHERE user_type=1")) {
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

    <div class="modal fade" id="addTicketModal" tabindex="-1" role="dialog" aria-labelledby="Profile_pic_upload_Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Customer Ticket</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form>

                                                    <div class="from-group ">
                                                        <label>Customer Name</label>
                                                        <select class="form-select" type="text" id="ticket_customer_id">
                                                            <option value="">Select</option>
                                                            <?php

                                                            if ($allData = $con->query("SELECT * FROM customers ")) {
                                                                while ($rows = $allData->fetch_array()) {
                                                                    echo ' <option value="' . $rows['id'] . '">' . $rows['username'] . '</option>';
                                                                }
                                                            }


                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="from-group mb-2">
                                                        <label for="">Ticket Type</label>
                                                        <select id="ticket_type" class="form-select">
                                                            <option value="">Select</option>
                                                            <option value="Active">Active</option>
                                                            <option value="New">New</option>
                                                            <option value="Open">Open</option>
                                                            <option value="Complete">Complete</option>
                                                        </select>
                                                    </div>
                                                    <div class="from-group mb-2">
                                                        <label for="">Assigned To</label>
                                                        <select id="ticket_assigned" class="form-select">
                                                            <option value="">Select</option>
                                                            <option value="Locale Team">Locale Team</option>
                                                            <option value="Fiber Team">Fiber Team</option>
                                                            <option value="Rayhan Sir">Rayhan Sir</option>
                                                            <option value="SR Comunication">SR Comunication</option>
                                                            <option value="Ali Hossain">Ali Hossain</option>
                                                            <option value="Support">Support</option>
                                                        </select>
                                                    </div>
                                                    <div class="from-group mb-2">
                                                        <label for="">Ticket For</label>
                                                        <select id="ticket_for" name="ticket_for " class="form-select">
                                                            <option value="">Select</option>
                                                            <option value="Reseller">Reseller</option>
                                                            <option value="Corporate">Corporate</option>
                                                            <option value="Home Connection">Home Connection</option>
                                                        </select>
                                                    </div>
                                                    <div class="from-group mb-2">
                                                        <label for=""> Complain Type </label>
                                                        <select id="ticket_complain_type" class="form-select">
                                                            <option value="">Select</option>
                                                            <?php

                                                            if ($allData = $con->query("SELECT * FROM ticket_topic WHERE user_type=1")) {
                                                                while ($rows = $allData->fetch_array()) {
                                                                    echo ' <option value="' . $rows['id'] . '">' . $rows['topic_name'] . '</option>';
                                                                }
                                                            }


                                                            ?>
                                                        </select>

                                                    </div>
                                                    <div class="from-group mb-2">
                                                        <label for="">Form Date</label>
                                                        <input id="ticket_from_date" type="date" class="form-control">

                                                    </div>
                                                    <div class="from-group mb-2">
                                                        <label for="">To Date</label>
                                                        <input id="ticket_to_date" type="date" class="form-control">

                                                    </div>



                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                <button type="button" id="customer_ticket_btn" class="btn btn-primary">Add Ticket Now</button>
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
                                                                        <input id="customer_password" type="password" class="form-control " name="password" value="12345" placeholder="Enter Your Password" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Mobile no.</label>
                                                                        <input id="customer_mobile" type="text" class="form-control " name="mobile" value="0" placeholder="Enter Your Mobile Number" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Expired Date</label>
                                                                        <select id="customer_expire_date" class="form-select">
                                                                            <option value="<?php echo "10";//date("d"); ?>"><?php echo "10";//date("d"); ?></option>
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
                                                                        <input id="customer_address" type="text" class="form-control" name="address" value="Sharkapur, Gouripur, Daudkandi" placeholder="Enter Your Addres" />
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
                                                                            if ($pop = $con->query("SELECT * FROM add_pop ")) {
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
                                                                        <input id="customer_nid" type="text" class="form-control" name="nid" value="7263478246" placeholder="Enter Your Nid Number" />
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
                                                                            <option value="1">Active</option>
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
    <script type="text/javascript"  src="assets/libs/select2/js/select2.min.js"></script>
    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
   
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
        
        <!-- Init js 
        <script src="assets/js/pages/c3-chart.init.js"></script>-->
    <script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>

    <script src="assets/js/pages/dashboard.init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

        
    <script type="text/javascript" src="assets/js/js-fluid-meter.js"></script>
  
   

    
    <script src="assets/js/pages/form-advanced.init.js"></script>

        <!-- Plugin Js-->
        <script src="assets/libs/chartist/chartist.min.js"></script>
        <script src="assets/libs/chartist-plugin-tooltips/chartist-plugin-tooltip.min.js"></script>
        <!-- demo js
        <script src="assets/js/pages/chartist.init.js"></script>-->

        <script src="assets/js/app.js"></script>
        


        <script src="js/toastr/toastr.min.js"></script>


    <script type="text/javascript">
	
	$('#menu_select_box').select2();
	var chart=new Chartist.Line("#simple-line-chart",{labels:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
		series:[
		[<?php 
		for($i=1; $i<13; $i++)
			{
				$currentyrMnth = date("Y").'-0'.$i;
				$sql = "SELECT * FROM customers WHERE createdate LIKE '%$currentyrMnth%'";
				$result = mysqli_query($con, $sql);
				echo $countconn = mysqli_num_rows($result).',';
			}
				?>],
		[
		
		<?php
		for($i=1; $i<13; $i++)
			{
				$currentyrMnth = date("Y").'-0'.$i;
				$sql = "SELECT * FROM customers WHERE expiredate LIKE '%$currentyrMnth%'";
				$result = mysqli_query($con, $sql);
				//echo $countexpconn = mysqli_num_rows($result).',';
				
			}

		?>],
		[1,3,4,5,6,7,7,7,7,7,7,7,10],
		[10,2,3,4,5,6,6,6,6,6,6,6,13]]},
		{fullWidth:!0,chartPadding:{right:40},plugins:[Chartist.plugins.tooltip()]});
		
		var times=function(e){return Array.apply(null,new Array(e))},data=times(52).map(Math.random).reduce(function(e,t,a){return e.labels.push(a+1),e.series.forEach(function(e){e.push(100*Math.random())}),e},{labels:[],series:times(4).map(function(){return new Array})}),
		options={showLine:!1,axisX:{labelInterpolationFnc:function(e,t){return t%13==0?"W"+e:null}}},responsiveOptions=[["screen and (min-width: 640px)",{axisX:{labelInterpolationFnc:function(e,t){return t%4==0?"W"+e:null}}}]];new Chartist.Line("#scatter-diagram",data,options,responsiveOptions);


///////////////// Chart Bar //////////////////////
!function(e){"use strict";function a(){}a.prototype.init=function(){c3.generate({bindto:"#chart",
data:{columns:[
["Tickets",
<?php 
// Date find from 5 days ago
//echo $Fidayago = strtotime(date("d", strtotime("-5 day")));
/**/
		for($i=0; $i<9; $i++)
			{
				$daystkt = date("Y-m-d", strtotime('-'.$i.' day'));
				$tktsql = $con->query("SELECT * FROM ticket WHERE startdate LIKE '%$daystkt%'");
				echo $tktsql->num_rows;
				echo ',';
				 
				
				
			}
			
?>
],
["Resolved",
<?php 
// Date find from 5 days ago

		for($i=0; $i<9; $i++)
			{
				$daystkt = date("Y-m-d", strtotime('-'.$i.' day'));
				$tktsql = $con->query("SELECT * FROM ticket WHERE startdate LIKE '%$daystkt%' AND ticket_type='Complete'");
				echo $tktsql->num_rows;
				echo ',';	
			}
			
?>


],
["Pending",
<?php 
// Date find from 5 days ago

		for($i=0; $i<9; $i++)
			{
				$daystkt = date("Y-m-d", strtotime('-'.$i.' day'));
				$tktsql = $con->query("SELECT * FROM ticket WHERE startdate LIKE '%$daystkt%' AND ticket_type='Active'");
				echo $tktsql->num_rows;
				echo ',';	
			}
			
?>


]],
type:"bar",colors:{Tickets:"#fb8c00",Resolved:"#3bc3e9",Pending:"#5468da"}}})},
e.ChartC3=new a,e.ChartC3.Constructor=a}(window.jQuery),
function(){"use strict";
window.jQuery.ChartC3.init()}();


///////////////// ####### Yearly Customer statics Chart Bar ######## //////////////////////
!function(e){"use strict";function a(){}a.prototype.init=function(){c3.generate({bindto:"#chart_year",
data:{columns:[
["New Customer",
<?php 

		for($i=1; $i<13; $i++)
			{
				
				$currentyrMnth = date("Y").'-0'.$i;
				date("M-Y", strtotime(date("Y").'-'.$i));
				$sql = "SELECT * FROM customers WHERE createdate LIKE '%$currentyrMnth%'";
				$result = mysqli_query($con, $sql);
				echo $countconn = mysqli_num_rows($result).',';
			}
			
?>
],
["Expired",
<?php 
// Date find from 5 days ago

		for($i=0; $i<11; $i++)
			{
				$currentyrMnth = date("Y").'-0'.$i;
				date("M-Y", strtotime(date("Y").'-'.$i));
				$sql = "SELECT * FROM customers WHERE expiredate LIKE '%$currentyrMnth%'";
				$result = mysqli_query($con, $sql);
				echo $countconn = mysqli_num_rows($result).',';
			}
			
?>


],
["Disabled",
<?php 
// Date find from 5 days ago

		for($i=0; $i<11; $i++)
			{
				$daystkt = date("Y-m-d", strtotime('-'.$i.' day'));
				$tktsql = $con->query("SELECT * FROM ticket WHERE startdate LIKE '%$daystkt%' AND ticket_type='Active'");
				echo $tktsql->num_rows;
				echo ',';	
			}
			
?>


]],
type:"bar",colors:{Tickets:"#fb8c00",Resolved:"#3bc3e9",Pending:"#5468da"}}})},
e.ChartC3=new a,e.ChartC3.Constructor=a}(window.jQuery),
function(){"use strict";
window.jQuery.ChartC3.init()}();


        $('#expire_customer_datatable').dataTable();
        $(document).on('click', '#AddTicketBtn', function() {
            $("#addTicketModal").modal('show');
        });
        $("#customer_ticket_btn").click(function() {
            // Get form values
            var customerId = $("#ticket_customer_id").val();
            var ticketType = $("#ticket_type").val();
            var assignedTo = $("#ticket_assigned").val();
            var ticketFor = $("#ticket_for").val();
            var complainType = $("#ticket_complain_type").val();
            var fromDate = $("#ticket_from_date").val();
            var toDate = $("#ticket_to_date").val();
            if (ticketType.length == 0) {
                toastr.error("Customer Ticket Type is require");
            } else if (assignedTo.length == 0) {
                toastr.error("Customer Assign  is require");
            } else if (ticketFor.length == 0) {
                toastr.error("Please Select Ticket For");
            } else if (complainType.length == 0) {
                toastr.error("Complain Type is require");
            } else if (fromDate.length == 0) {
                toastr.error("From Date is require");
            } else if (toDate.length == 0) {
                toastr.error("To Date is require");
            } else {
                // Make AJAX request to server
                $.ajax({
                    url: "include/tickets_server.php", // Provide the PHP file to handle the database insertion
                    type: "POST",
                    data: {
                        customer_id: customerId,
                        ticket_type: ticketType,
                        assigned_to: assignedTo,
                        ticket_for: ticketFor,
                        complain_type: complainType,
                        from_date: fromDate,
                        to_date: toDate,
                        addTicketData: 0,
                    },
                    success: function(response) {
                        // Handle the response from the server
                        if (response == 1) {
                            toastr.success("Ticket Added Success");
                            $("#addTicketModal").modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(response);
                        }
                    }
                });
            }

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#cstmr_ac').select2();
            //
            $('#addRechargeModal').on('shown.bs.modal', function () {
                /*Check if select2 is already initialized*/ 
                if (!$('#recharge_customer').hasClass("select2-hidden-accessible")) {
                    $("#recharge_customer").select2({
                        dropdownParent: $('#addRechargeModal'),
                        placeholder: "Select Customer"
                    });
                }
            });
        });

        function currentMsgTemp() {
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
        }

        function currentCstmrAc() {
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
        }
    </script>
    <script type="text/javascript">
        $("#addSmsBtn").click(function() {
            $("#sendMessage").modal('show');
        });

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

        // On Change of username
        $(document).on('change', '#customer_username', function() {
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
            } /*else if (mobile.length == 0) {
                toastr.error("Mobile number is require");
            }*/ else if (expire_date.length == 0) {
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





        //////////////////////////////// CUSTOMER  Recharge SCRIPT ///////////////////////////////////////////////////

        

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
            $("#recharge_customer_amount").val(responseData);
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
                    }, 500);
                } else {
                    toastr.error(response);
                    $("#add_recharge_btn").html('Recharge Now');
                }



            }
        });



    }

}

</script>


<script type="text/javascript">
        //Storage
        var fm = new FluidMeter();
        fm.init({
            targetContainer: document.getElementById("fluid-meter1"),
            fillPercentage: <?php echo $mem1; ?>,
        });

        // CPU
        var fm = new FluidMeter();
        fm.init({
            targetContainer: document.getElementById("fluid-meter2"),
            fillPercentage: <?php echo $cpu1; ?>,

        });

        //RAM
        var fm = new FluidMeter();
        fm.init({
            targetContainer: document.getElementById("fluid-meter"),
            fillPercentage: <?php echo $mem1; ?>,
            options: {
                fontSize: "70px",
                fontFamily: "Arial",
                fontFillStyle: "white",
                drawShadow: true,
                drawText: true,
                drawPercentageSign: true,
                drawBubbles: true,
                size: 300,
                borderWidth: 25,
                backgroundColor: "#e2e2e2",
                foregroundColor: "#fafafa",
                foregroundFluidLayer: {
                    fillStyle: "#F1C40F",
                    angularSpeed: 100,
                    maxAmplitude: 12,
                    frequency: 30,
                    horizontalSpeed: -150
                },
                backgroundFluidLayer: {
                    fillStyle: "#F1C40F",
                    angularSpeed: 100,
                    maxAmplitude: 9,
                    frequency: 30,
                    horizontalSpeed: 150
                },
                backgroundFluidLayer: {
                    fillStyle: "  #CCCCFF",
                    angularSpeed: 100,
                    maxAmplitude: 9,
                    frequency: 30,
                    horizontalSpeed: 150
                },
            }
        });
        fm.setPercentage(percentage);
		
		
/////////////////////////Chart /////////////////////////////////////




    </script>
	
	
</body>

</html>