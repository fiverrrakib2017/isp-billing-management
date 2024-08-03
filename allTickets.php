<?php
include("include/security_token.php");
include("include/db_connect.php");

include("include/users_right.php");

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
        'minute' => 60,
        'second' => 1
    ];

    /*Check for each time unit*/ 
    foreach ($units as $unit => $value) {
        if ($difference >= $value) {
            $time = floor($difference / $value);
            return '<img src="images/icon/online.png" height="10" width="10"/>'.' '.$time . ' ' . $unit . ($time > 1 ? 's' : '') . ' ago';
        }
    }
    /*If the difference is less than a second*/
    return '<img src="images/icon/online.png" height="10" width="10"/> just now';  
}

function get_complete_time( $endDate) {
    /*Convert startdate to a timestamp*/ 
    $startTimestamp = strtotime($endDate);
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
        'minute' => 60,
        'second' => 1
    ];

    /*Check for each time unit*/ 
    foreach ($units as $unit => $value) {
        if ($difference >= $value) {
            $time = floor($difference / $value);
            return '<img src="images/icon/online.png" height="10" width="10"/>'.' '.$time . ' ' . $unit . ($time > 1 ? 's' : '') . ' ago';
        }
    }
    /*If the difference is less than a second*/
    return '<img src="images/icon/online.png" height="10" width="10"/> just now';  

    // /***Determine the appropriate time difference string***/ 
    // if ($timeDifference < $minutes) {
    //     $count = floor($timeDifference / $seconds);
    //     return '<img src="images/icon/online.png" height="10" width="10"/>'.' '.$count . ' second' . ($count !== 1 ? 's' : '') . ' ago';
    // } elseif ($timeDifference < $hours) {
    //     $count = floor($timeDifference / $minutes);
    //     return '<img src="images/icon/online.png" height="10" width="10"/>'.' '.$count . ' minute' . ($count !== 1 ? 's' : '') . ' ago';
    // } elseif ($timeDifference < $days) {
    //     $count = floor($timeDifference / $hours);
    //     return '<img src="images/icon/online.png" height="10" width="10"/>'.' '.$count . ' hour' . ($count !== 1 ? 's' : '') . ' ago';
    // } elseif ($timeDifference < $weeks) {
    //     $count = floor($timeDifference / $days);
    //     return '<img src="images/icon/online.png" height="10" width="10"/>'.' '.$count . ' day' . ($count !== 1 ? 's' : '') . ' ago';
    // } elseif ($timeDifference < $months) {
    //     $count = floor($timeDifference / $weeks);
    //     return '<img src="images/icon/online.png" height="10" width="10"/>'.' '.$count . ' week' . ($count !== 1 ? 's' : '') . ' ago';
    // } elseif ($timeDifference < $years) {
    //     $count = floor($timeDifference / $months);
    //     return '<img src="images/icon/online.png" height="10" width="10"/>'.' '.$count . ' month' . ($count !== 1 ? 's' : '') . ' ago';
    // } else {
    //     $count = floor($timeDifference / $years);
    //     return '<img src="images/icon/online.png" height="10" width="10"/>'.' '.$count . ' year' . ($count !== 1 ? 's' : '') . ' ago';
    // }
}
function acctual_work($startdate, $enddate) {
    $startTimestamp = strtotime($startdate);
    $endTimestamp = strtotime($enddate);
    $time_difference = $endTimestamp - $startTimestamp;

    // Define time periods in seconds
    $units = [
        'year' => 365 * 24 * 60 * 60,
        'month' => 30 * 24 * 60 * 60,
        'week' => 7 * 24 * 60 * 60,
        'day' => 24 * 60 * 60,
        'hour' => 60 * 60,
        'minute' => 60,
        'second' => 1,
    ];

    // Determine the appropriate time period
    foreach ($units as $unit => $value) {
        if ($time_difference >= $value) {
            $count = floor($time_difference / $value);
            return $count . ' ' . $unit . ($count > 1 ? 's' : '') . ' ';
        }
    }

    return 'just now'; 
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
	
	<link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">

           <link href="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">

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
                        <h4 class="page-title">Tickets</h4>
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
                                            <p class="text-primary mb-0 hover-cursor">Ticket</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                   
									<a href="create_ticket.php" class="btn btn-primary mt-2 mb-2 mt-xl-0 mdi mdi-account-plus mdi-18px" >&nbsp;&nbsp;New Ticket</a>
                                    <br>
                                </div>
                            </div>
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
                                                    <th>Status</th> 
                                                    <th>Created</th>
                                                    <th>Customer Name</th>
                                                    <th>Pop/Area</th>
                                                    <th>Issues</th>
                                                   
                                                    <th>Assigned Team</th>
                                                    <th>Ticket For</th>
                                                    
                                                    <th>Acctual Work</th>
                                                    <th>Note</th>
                                                    <th>Percentage</th>
                                                    
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $sql = "SELECT * FROM `ticket` ORDER BY id DESC";
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
                                         $customer_id = $rows["customer_id"];
                                        $customer = $con->query("SELECT * FROM customers WHERE id=$customer_id ");
                                        while ($stmr = $customer->fetch_array()) {
                                            $customer_area_id= $stmr['area'];
                                            $get_all_area=$con->query("SELECT * FROM area_list WHERE id=$customer_area_id"); 
                                            while ($all_area = $get_all_area->fetch_array()) {
                                               echo  $all_area['name'];
                                            }

                                        }

                                                            ?>
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
                                                             <?php 
                                                            $stmt = $con->prepare("SELECT group_name FROM working_group WHERE id = ?");
                                                            $stmt->bind_param("i", $rows['asignto']);
                                                            $stmt->execute();
                                                            $group_result = $stmt->get_result();

                                                            if ($group_result->num_rows > 0) {
                                                                while ($ro = $group_result->fetch_assoc()) {
                                                                    echo htmlspecialchars($ro["group_name"]);
                                                                }
                                                            } else {
                                                                echo "No assigned group";
                                                            }

                                                            /*Close the statement*/ 
                                                            $stmt->close();
                                                            ?>
                                                                
                                                            </td>
                                                         <td><?php echo $rows["ticketfor"]; ?></td>
                                                        
                                                       
                                                         <td>
                                                            <?php 
                                                             $startdate = $rows["startdate"];
                                                             $enddate=$rows["enddate"];
                                                            
                                                             if ($enddate=='') {
                                                                echo 'Work Processing..';
                                                             }else{
                                                                echo acctual_work( $startdate, $enddate); 
                                                             }
                                                                // $startdate = $rows["startdate"];
                                                                //echo timeAgo($enddate); 
                                                            ?>
                                                            
                                                        </td>
                                                        <td><?php echo $rows["notes"]; ?></td>
                                                        <td><?php echo $rows["parcent"]; ?></td>
                                                        

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
	<script src="assets/libs/select2/js/select2.min.js"></script>
        <script src="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>

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
        <script src="assets/js/pages/form-advanced.init.js"></script>

    <script src="assets/js/app.js"></script>
    <script type="text/javascript">

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
</body>

</html>