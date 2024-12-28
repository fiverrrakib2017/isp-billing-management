<?php
date_default_timezone_set('Asia/Dhaka');
include 'include/security_token.php';
include 'include/db_connect.php';
include 'include/users_right.php';
include 'include/pop_security.php';
include 'include/functions.php';

function timeAgo($startdate)
{
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
        'second' => 1,
    ];

    /*Check for each time unit*/
    foreach ($units as $unit => $value) {
        if ($difference >= $value) {
            $time = floor($difference / $value);
            return '<img src="images/icon/online.png" height="10" width="10"/>' . ' ' . $time . ' ' . $unit . ($time > 1 ? 's' : '') . '';
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

    <?php include 'style.php'; ?>
</head>

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php
        $page_title = 'Welcome To Dashboard';
        include 'Header.php';
        ?>

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
                        <div class="col-md-6 col-sm-6">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#addRechargeModal"
                                class="btn-sm btn btn-primary mb-1"><i class="mdi mdi-battery-charging-90"></i> Recharge
                                Now</button>

                            <button type="button" data-bs-toggle="modal" data-bs-target="#addCustomerModal"
                                class="btn-sm btn btn-success mb-1"><i class="mdi mdi-account-plus"></i> Add
                                Customer</button>

                            <a href="con_request.php" class="btn-sm btn btn-warning mb-1">Connection Request
                                <?php
                                if ($allCstmr = $con->query('SELECT * FROM customer_request WHERE status=0')) {
                                    if ($allCstmr->num_rows > 0) {
                                        echo '<span class="badge rounded-pill bg-danger float-end">' . $allCstmr->num_rows . '<span>';
                                    } else {
                                    }
                                }
                                
                                ?>
                            </a>

                            <button type="button" id="addSmsBtn" class="btn-sm btn btn-primary mb-1"><i
                                    class="far fa-envelope"></i> SMS Notification</button>

                            <button type="button" data-bs-toggle="modal" data-bs-target="#ticketModal"
                                class="btn-sm btn btn-success mb-1">Add Ticket</button>
                        </div>
                        <div class="col-md-6">
                            <div class="float-end">
                                <abbr title="Date And Time ">
                                    <button type="button" class="btn-sm btn btn-info">
                                        <i class="mdi mdi-clock-outline"></i>
                                    </button></abbr>
                                &nbsp;
                                <abbr title="Up Time">
                                    <button type="button" id="rechargeBtn" class="btn-sm btn btn-primary ">
                                        <i class="mdi mdi-server"></i>
                                    </button></abbr>
                                &nbsp;
                                <abbr title="Cloud Server">
                                    <button type="button" class="btn-sm btn btn-secondary">
                                        <i class="mdi mdi-cloud-outline"></i>
                                    </button></abbr>
                                &nbsp;
                                <abbr title="Payment received">
                                    <button type="button" data-bs-target="#addPaymentModal" data-bs-toggle="modal"
                                        class="btn-sm btn btn-info ">
                                        <i class="mdi mdi mdi-cash-multiple"></i>
                                    </button></abbr>
                                &nbsp;

                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mini-stat">
                                        <span class="mini-stat-icon bg-primary me-0 float-end"><i
                                                class="fas fa-user-check"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-primary">
                                                <?php
                                                if ($onlinecstmr = $con->query('SELECT * FROM radacct WHERE acctstoptime IS NULL')) {
                                                    echo $onlinecstmr->num_rows;
                                                }
                                                ?>
                                            </span>
                                            <img src="images/icon/online.png" height="10" width="10"/>&nbsp;Online
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
                                            <span class="mini-stat-icon bg-success me-0 float-end"><i
                                                    class="fas fa-users"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-success">
                                                    <?php if ($totalCustomer = $con->query("SELECT * FROM customers WHERE status='1'")) {
                                                        echo $totalcstmr = $totalCustomer->num_rows;
                                                    }
                                                    
                                                    ?>
                                                </span>
                                                Active Customers
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
                                            <span class="mini-stat-icon bg-danger me-0 float-end"><i
                                                    class="fas fa-exclamation-triangle"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-danger">
                                                    <?php if ($AllExcstmr = $con->query('SELECT * FROM `customers` WHERE  NOW() > expiredate')) {
                                                        echo $AllExcstmr->num_rows;
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
                                            <span class="mini-stat-icon bg-secondary me-0 float-end"><i
                                                    class="fas fa-user-slash"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-secondary">
                                                    <?php if ($dsblcstmr = $con->query("SELECT * FROM customers WHERE status='0'")) {
                                                        echo $dsblcstmr->num_rows;
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
                                    <a href="pop_branch.php">
                                        <div class="mini-stat">

                                            <span class="mini-stat-icon bg-brown me-0 float-end"><i
                                                    class="fas fa-project-diagram"></i></span>
                                            <div class="mini-stat-info">

                                                <span class="counter text-brown">
                                                    <?php
                                                    if ($data = $con->query('SELECT * FROM add_pop')) {
                                                        echo $data->num_rows;
                                                    }
                                                    ?>
                                                </span>
                                                POP/Branch 
                                                <br>  
<img src="images/icon/online.png" height="10" width="10"/>&nbsp;Online(
<?php
$popCounts = get_count_pop_and_area_with_online_and_offline($con, 'add_pop', 'pop');
echo $popCounts['online'];
?>
) 
<br>  
<img src="images/icon/disabled.png" height="10" width="10"/>&nbsp;Offline(
<?php
echo $popCounts['offline'];
?>
)


                                            </div>
                                        </div>
                                </div></a>
                            </div>
                        </div> <!-- End col -->

                        <div class="col-md-6 col-xl-3">

                            <div class="card">
                                <div class="card-body">
                                    <a href="pop_area.php">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-teal me-0 float-end"><i
                                                    class="fas fa-search-location"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-teal">
                                                    <?php if ($totalCustomer = $con->query('SELECT * FROM area_list')) {
                                                        echo $totalCustomer->num_rows;
                                                    }
                                                    
                                                    ?>
                                                </span>
                                                Area
                                                <br>  
<img src="images/icon/online.png" height="10" width="10"/>&nbsp;Online(
<?php
$popCounts = get_count_pop_and_area_with_online_and_offline($con, 'area_list', 'area');
echo $popCounts['online'];
?>
) 
<br>  
<img src="images/icon/disabled.png" height="10" width="10"/>&nbsp;Offline(
<?php
echo $popCounts['offline'];
?>
)
                                                    

                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        </div> <!--End col -->





                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <a href="allTickets.php">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-warning me-0 float-end"><i
                                                    class="fas fa-notes-medical"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-danger">
                                                    <?php if ($dsblcstmr = $con->query('SELECT * FROM ticket')) {
                                                        echo $dsblcstmr->num_rows;
                                                    }
                                                    ?>
                                                </span>
                                                Tickets
                                                <br>  <img src="images/icon/online.png" height="10" width="10"/>Completed(233232) <br> <img src="images/icon/offline.png" height="10" width="10"/>Incompleted(2323)
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div> <!-- End col -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <a href="nas.php">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-purple me-0 float-end"><i
                                                    class="fas fa-network-wired"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-teal">
                                                    <?php if ($dsblcstmr = $con->query('SELECT * FROM nas')) {
                                                        echo $dsblcstmr->num_rows;
                                                    }
                                                    ?>
                                                </span>
                                                Routers
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div><!--end col -->
                    </div> <!-- end row-->


                    <div class="row">

                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        <table class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>POP Name</th>
                                                    <th>Total</th>
                                                    <th><img src="images/icon/online.png" height="10"
                                                            width="10" /> Online</th>
                                                    <th><img src="images/icon/expired.png" height="10"
                                                            width="10" /> Expired</th>
                                                    <th><img src="images/icon/disabled.png" height="10"
                                                            width="10" /> Disabled</th>

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
                                                    <td><a
                                                            href="view_pop.php?id=<?php echo $pop_ID; ?>"><?php echo $rows['pop']; ?></a>
                                                    </td>
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
                                                        if ($totalexprs == 0) {
                                                            echo $totalexprs;
                                                        } else {
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
                                                        if ($totaldsbld == 0) {
                                                            echo $totaldsbld;
                                                        } else {
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
                                <div class="card-header bg-white text-black">
                                    <h4 class="card-title">Tickets</h4>
                                    <button style="float: right;">
                                        <a href="allTickets.php">+</a>
                                    </button>
                                    <?php
                                    $badge_colors = ['bg-primary', 'bg-purple', 'bg-success', 'bg-warning'];
                                    $color_index = 0;
                                    $is_first = true;
                                    
                                    if ($get_best_area = $con->query('SELECT area_id, COUNT(*) AS ticket_count FROM ticket GROUP BY area_id ORDER BY ticket_count DESC LIMIT 5')) {
                                        while ($rows = $get_best_area->fetch_assoc()) {
                                            $area_id = $rows['area_id'];
                                            $ticket_count = $rows['ticket_count'];
                                            $area_name_result = $con->query("SELECT name FROM area_list WHERE id = $area_id");
                                    
                                            if ($area_name_result && ($area_row = $area_name_result->fetch_assoc())) {
                                                $area_name = $area_row['name'];
                                    
                                                if ($is_first) {
                                                    echo '<span class="badge bg-danger me-2">' . htmlspecialchars($area_name) . ' (' . $ticket_count . ')</span>';
                                                    $is_first = false;
                                                } else {
                                                    echo '<span class="badge ' . $badge_colors[$color_index] . ' me-2">' . htmlspecialchars($area_name) . ' (' . $ticket_count . ')</span>';
                                                    $color_index++;
                                                }
                                            } else {
                                                echo '<span class="badge bg-secondary me-2">Unknown (' . $ticket_count . ')</span>';
                                            }
                                            if ($color_index >= count($badge_colors)) {
                                                $color_index = 0;
                                            }
                                        }
                                    } else {
                                        echo '<span class="badge bg-danger">Error fetching areas</span>';
                                    }
                                    ?>
                                </div>



                                <div class="card-body">

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
                                                        <a
                                                            href="tickets_profile.php?id=<?php echo $rows['id']; ?>"><?php echo $ticketType; ?></a>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $startdate = $rows['startdate'];
                                                        echo timeAgo($startdate);
                                                        ?>

                                                    </td>
                                                    <td>
                                                        <?php
                                                        $customer_id = $rows['customer_id'];
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
                                                        if ($chkc == 1) {
                                                            echo '<abbr title="Online"><img src="images/icon/online.png" height="10" width="10"/></abbr>';
                                                        } else {
                                                            echo '<abbr title="Offline"><img src="images/icon/offline.png" height="10" width="10"/></abbr>';
                                                        }
                                                        
                                                        ?>


                                                        <a href="profile.php?clid=<?php echo $cstmrID; ?>"
                                                            target="_blank"> <?php echo $cstmr_fullname; ?></a>
                                                    </td>

                                                    </td>
                                                    <td>
                                                        <?php
                                                        $complain_typeId = $rows['complain_type'];
                                                        if ($allCom = $con->query("SELECT * FROM ticket_topic WHERE id='$complain_typeId' ")) {
                                                            while ($rowss = $allCom->fetch_array()) {
                                                                echo $rowss['topic_name'];
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>

                                                        <a class="btn-sm btn btn-success"
                                                            href="tickets_profile.php?id=<?php echo $rows['id']; ?>"><i
                                                                class="fas fa-eye"></i>
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
                                                $daystkt = date('Y-m-d', strtotime('-7 day'));
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE startdate BETWEEN '$daystkt' AND NOW()");
                                                echo $tktsql->num_rows;
                                                ?>

                                            </h5>
                                            <p class="text-muted text-truncate">Tickets</p>
                                        </div>
                                        <div class="col-3">
                                            <h5 class="mb-0 font-size-18">
                                                <?php
                                                $daystkt = date('Y-m-d', strtotime('-7 day'));
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE ticket_type='Complete' AND startdate BETWEEN '$daystkt' AND NOW()");
                                                echo $tktsql->num_rows;
                                                ?>

                                            </h5>
                                            <p class="text-muted text-truncate">Resolved</p>
                                        </div>
                                        <div class="col-3">
                                            <h5 class="mb-0 font-size-18">
                                                <?php
                                                $daystkt = date('Y-m-d', strtotime('-7 day'));
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE ticket_type='Active' AND startdate BETWEEN '$daystkt' AND NOW()");
                                                echo $tktsql->num_rows;
                                                ?>
                                            </h5>
                                            <p class="text-muted text-truncate">Pending</p>
                                        </div>

                                        <div class="col-3">
                                            <h5 class="mb-0 font-size-18">
                                                <?php
                                                $daystkt = date('Y-m-d', strtotime('-7 day'));
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
                                            <h5 class="mb-0 font-size-18"></h5>
                                            <p class="text-muted text-truncate">New</p>
                                        </div>
                                        <div class="col-4">
                                            <h5 class="mb-0 font-size-18"></h5>
                                            <p class="text-muted text-truncate">Expired</p>
                                        </div>
                                        <div class="col-4">
                                            <h5 class="mb-0 font-size-18"></h5>
                                            <p class="text-muted text-truncate">Disabled</p>
                                        </div>
                                    </div>

                                    <div id="simple-line-chart" class="ct-chart ct-golden-section" dir="ltr">
                                    </div>

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
                                        <table id="datatables" class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                                    <td><a target="new"
                                                            href="profile.php?clid=<?php echo $rows['id']; ?>">
                                                            <?php
                                                            $onlineusr = $con->query("SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username='$username'");
                                                            $chkc = $onlineusr->num_rows;
                                                            if ($chkc == 1) {
                                                                echo '<abbr title="Online"><img src="images/icon/online.png" height="10" width="10"/></abbr>';
                                                            } else {
                                                                echo '<abbr title="Offline"><img src="images/icon/offline.png" height="10" width="10"/></abbr>';
                                                            }
                                                            
                                                            echo ' ' . $rows['fullname']; ?></a></td>

                                                    <td>
                                                        <?php
                                                        $popID = $rows['pop'];
                                                        $allPOP = $con->query("SELECT * FROM add_pop WHERE id=$popID ");
                                                        while ($popRow = $allPOP->fetch_array()) {
                                                            echo $popRow['pop'];
                                                        }
                                                        
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php $id = $rows['area'];
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
                                        <table id="datatables" class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                                    <td><a target="new"
                                                            href="profile.php?clid=<?php echo $rows['id']; ?>">
                                                            <?php
                                                            $onlineusr = $con->query("SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username='$username'");
                                                            $chkc = $onlineusr->num_rows;
                                                            if ($chkc == 1) {
                                                                echo '<abbr title="Online"><img src="images/icon/online.png" height="10" width="10"/></abbr>';
                                                            } else {
                                                                echo '<abbr title="Offline"><img src="images/icon/offline.png" height="10" width="10"/></abbr>';
                                                            }
                                                            
                                                            echo ' ' . $rows['fullname']; ?></a></td>

                                                    <td>
                                                        <?php
                                                        $popID = $rows['pop'];
                                                        $allPOP = $con->query("SELECT * FROM add_pop WHERE id=$popID ");
                                                        while ($popRow = $allPOP->fetch_array()) {
                                                            echo $popRow['pop'];
                                                        }
                                                        
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php $id = $rows['area'];
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
                                                $daystkt = date('Y-m-d', strtotime('-7 day'));
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE startdate BETWEEN '$daystkt' AND NOW()");
                                                echo $tktsql->num_rows;
                                                ?>

                                            </h5>
                                            <p class="text-muted text-truncate">Tickets</p>
                                        </div>
                                        <div class="col-3">
                                            <h5 class="mb-0 font-size-18">
                                                <?php
                                                $daystkt = date('Y-m-d', strtotime('-7 day'));
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE ticket_type='Complete' AND startdate BETWEEN '$daystkt' AND NOW()");
                                                echo $tktsql->num_rows;
                                                ?>

                                            </h5>
                                            <p class="text-muted text-truncate">Resolved</p>
                                        </div>
                                        <div class="col-3">
                                            <h5 class="mb-0 font-size-18">
                                                <?php
                                                $daystkt = date('Y-m-d', strtotime('-7 day'));
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE ticket_type='Active' AND startdate BETWEEN '$daystkt' AND NOW()");
                                                echo $tktsql->num_rows;
                                                ?>
                                            </h5>
                                            <p class="text-muted text-truncate">Pending</p>
                                        </div>

                                        <div class="col-3">
                                            <h5 class="mb-0 font-size-18">
                                                <?php
                                                $daystkt = date('Y-m-d', strtotime('-7 day'));
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
                                        <table id="datatables" class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
        for($i=1; $i<=12; $i++)
        {
            ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td>
                                                        <?php
                                                        $month = sprintf('%02d', $i);
                                                        $currentyrMnth = date('Y') . '-' . $month;
                                                        echo date('M-Y', strtotime($currentyrMnth));
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $sql = "SELECT * FROM customers WHERE createdate LIKE '%$currentyrMnth%'";
                                                        $result = mysqli_query($con, $sql);
                                                        $countconn = mysqli_num_rows($result);
                                                        echo '<a href="customer_newcon.php?list=' . $currentyrMnth . '">' . $countconn . '</a>';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $sql = "SELECT * FROM customers WHERE  expiredate LIKE '%$currentyrMnth%'";
                                                        $result = mysqli_query($con, $sql);
                                                        $countexpconn = mysqli_num_rows($result);
                                                        echo '<a href="customer_expire.php?list=' . $currentyrMnth . '">' . $countexpconn . '</a>';
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php 
        }	
        ?>
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
<?php system('uptime'); ?>
<br />
<strong>System Information:</strong>
<?php system('uname -a'); ?>

<?php
//<strong>CPU Usage:</strong>
$exec_loads = sys_getloadavg();
$exec_cores = trim(shell_exec("grep -P '^processor' /proc/cpuinfo|wc -l"));
$cpu1 = round(($exec_loads[1] / ($exec_cores + 1)) * 100, 0);

//<strong>RAM Usage%:</strong>
$exec_free = explode("\n", trim(shell_exec('free')));
$get_mem = preg_split('/[\s]+/', $exec_free[1]);
$mem1 = round(($get_mem[2] / $get_mem[1]) * 100, 0);

//<strong>RAM Usage:</strong>
$exec_free = explode("\n", trim(shell_exec('free')));
print_r($get_mem = preg_split('/[\s]+/', $exec_free[1]));
$mem = number_format(round($get_mem[2] / 1024 / 1024, 2), 2) . '/' . number_format(round($get_mem[1] / 1024 / 1024, 2), 2);
?>

<strong>System Date & Time:</strong>
<?php
//$exec_uptime = preg_split("/[\s]+/", trim(shell_exec('uptime')));
echo date('D-M-Y') . ' ' . date('h:i:s A') . '<br/>';
echo date_default_timezone_get();
?>
<br/>
<strong><span class="mdi-database-clock-outline"></span> Date & Time:</strong>
<?php
//$exec_uptime = preg_split("/[\s]+/", trim(shell_exec('uptime')));
$dbtime = $con->query('SELECT NOW() AS dbtime');
$rowd = $dbtime->fetch_assoc();
echo $rowd['dbtime'];

?>


<strong>Uptime:</strong>
<?php
$exec_uptime = preg_split('/[\s]+/', trim(shell_exec('uptime')));
echo $uptime = $exec_uptime[2] . ' Days';
?>
<br/>
<strong>DB Sync:</strong>
<?php
$cronupdt = $con->query('SELECT * FROM cron');
$rowcron = $cronupdt->fetch_assoc();
echo $rowcron['date'];

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

            <?php
            include 'Footer.php';
            ?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <div class="modal fade" id="addRechargeModal" tabindex="-1" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
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
                                    if ($allCustomer = $con->query('SELECT * FROM customers')) {
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
                                <input id="recharge_customer_package_price" type="text" class="form-control"
                                    disabled>
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
                                <label for="recharge_customer_transaction_type" class="form-label">Transaction
                                    Type</label>
                                <select id="recharge_customer_transaction_type" class="form-select">
                                    <option value="1">Cash</option>
                                    <option value="0">On Credit</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-success mt-4" id="add_recharge_btn"
                                    style="margin-top: 4px;">
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
                                <select name="cstmr_ac" id="cstmr_ac" class="form-control select2"
                                    onchange="currentCstmrAc()" style="width:100%;">
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
                                    if ($allCstmr = $con->query('SELECT * FROM message_template WHERE user_type=1')) {
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
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light">Send Message</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <?php include 'modal/tickets_modal.php'; ?>


    <?php require 'modal/customer_modal.php'; ?>

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>



    <?php include 'script.php'; ?>
    <script src="js/tickets.js"></script>
    <script src="js/customer.js"></script>
    <script type="text/javascript">
        /*** Add ticket Modal Script****/
        ticket_modal();
        loadCustomers();
        ticket_assign();
        ticket_complain_type();


        new Chartist.Line("#simple-line-chart", {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    series: [
        {
            name: 'New Customers',
            data: [<?php
                for ($i = 1; $i <= 12; $i++) {
                    $currentyrMnth = date('Y') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
                    $sql = "SELECT COUNT(*) AS new_customers FROM customers WHERE createdate LIKE '%$currentyrMnth%'";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['new_customers'] . ',';
                }
            ?>]
        },
        {
            name: 'Active Customers',
            data: [<?php
                for ($i = 1; $i <= 12; $i++) {
                    $currentyrMnth = date('Y') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
                    $sql = "SELECT COUNT(*) AS active_customers FROM customers WHERE status = '1' AND createdate LIKE '%$currentyrMnth%'";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['active_customers'] . ',';
                }
            ?>]
        },
        {
            name: 'Expired Customers',
            data: [<?php
                for ($i = 1; $i <= 12; $i++) {
                    $currentyrMnth = date('Y') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
                    $sql = "SELECT COUNT(*) AS expired_customers FROM customers WHERE expiredate LIKE '%$currentyrMnth%'";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['expired_customers'] . ',';
                }
            ?>]
        },
        {
            name: 'Disabled Customers',
            data: [<?php
                for ($i = 1; $i <= 12; $i++) {
                    $currentyrMnth = date('Y') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
                    $sql = "SELECT COUNT(*) AS disabled_customers FROM customers WHERE status = '0' AND createdate LIKE '%$currentyrMnth%'";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['disabled_customers'] . ',';
                }
            ?>]
        }
    ]
}, {
    fullWidth: true,
    chartPadding: {
        right: 40
    },
    plugins: [Chartist.plugins.tooltip()]
});






        var times = function(e) {
                return Array.apply(null, new Array(e))
            },
            data = times(52).map(Math.random).reduce(function(e, t, a) {
                return e.labels.push(a + 1), e.series.forEach(function(e) {
                    e.push(100 * Math.random())
                }), e
            }, {
                labels: [],
                series: times(4).map(function() {
                    return new Array
                })
            }),
            options = {
                showLine: !1,
                axisX: {
                    labelInterpolationFnc: function(e, t) {
                        return t % 13 == 0 ? "W" + e : null
                    }
                }
            },
            responsiveOptions = [
                ["screen and (min-width: 640px)", {
                    axisX: {
                        labelInterpolationFnc: function(e, t) {
                            return t % 4 == 0 ? "W" + e : null
                        }
                    }
                }]
            ];
        new Chartist.Line("#scatter-diagram", data, options, responsiveOptions);


        ///////////////// Chart Bar //////////////////////
        ! function(e) {
            "use strict";

            function a() {}
            a.prototype.init = function() {
                    c3.generate({
                        bindto: "#chart",
                        data: {
                            columns: [
                                ["Tickets",
                                    <?php
                                    // Date find from 5 days ago
                                    //echo $Fidayago = strtotime(date("d", strtotime("-5 day")));
                                    /**/
                                    for ($i = 0; $i < 9; $i++) {
                                        $daystkt = date('Y-m-d', strtotime('-' . $i . ' day'));
                                        $tktsql = $con->query("SELECT * FROM ticket WHERE startdate LIKE '%$daystkt%'");
                                        echo $tktsql->num_rows;
                                        echo ',';
                                    }
                                    
                                    ?>
                                ],
                                ["Resolved",
                                    <?php
                                    // Date find from 5 days ago
                                    
                                    for ($i = 0; $i < 9; $i++) {
                                        $daystkt = date('Y-m-d', strtotime('-' . $i . ' day'));
                                        $tktsql = $con->query("SELECT * FROM ticket WHERE startdate LIKE '%$daystkt%' AND ticket_type='Complete'");
                                        echo $tktsql->num_rows;
                                        echo ',';
                                    }
                                    
                                    ?>


                                ],
                                ["Pending",
                                    <?php
                                    // Date find from 5 days ago
                                    
                                    for ($i = 0; $i < 9; $i++) {
                                        $daystkt = date('Y-m-d', strtotime('-' . $i . ' day'));
                                        $tktsql = $con->query("SELECT * FROM ticket WHERE startdate LIKE '%$daystkt%' AND ticket_type='Active'");
                                        echo $tktsql->num_rows;
                                        echo ',';
                                    }
                                    
                                    ?>


                                ]
                            ],
                            type: "bar",
                            colors: {
                                Tickets: "#fb8c00",
                                Resolved: "#3bc3e9",
                                Pending: "#5468da"
                            }
                        }
                    })
                },
                e.ChartC3 = new a, e.ChartC3.Constructor = a
        }(window.jQuery),
        function() {
            "use strict";
            window.jQuery.ChartC3.init()
        }();


        ///////////////// ####### Yearly Customer statics Chart Bar ######## //////////////////////
        ! function(e) {
            "use strict";

            function a() {}
            a.prototype.init = function() {
                    c3.generate({
                        bindto: "#chart_year",
                        data: {
                            columns: [
                                ["New Customer",
                                    <?php
                                    
                                    for ($i = 1; $i < 13; $i++) {
                                        $currentyrMnth = date('Y') . '-0' . $i;
                                        date('M-Y', strtotime(date('Y') . '-' . $i));
                                        $sql = "SELECT * FROM customers WHERE createdate LIKE '%$currentyrMnth%'";
                                        $result = mysqli_query($con, $sql);
                                        echo $countconn = mysqli_num_rows($result) . ',';
                                    }
                                    
                                    ?>
                                ],
                                ["Expired",
                                    <?php
                                    // Date find from 5 days ago
                                    
                                    for ($i = 0; $i < 11; $i++) {
                                        $currentyrMnth = date('Y') . '-0' . $i;
                                        date('M-Y', strtotime(date('Y') . '-' . $i));
                                        $sql = "SELECT * FROM customers WHERE expiredate LIKE '%$currentyrMnth%'";
                                        $result = mysqli_query($con, $sql);
                                        echo $countconn = mysqli_num_rows($result) . ',';
                                    }
                                    
                                    ?>


                                ],
                                ["Disabled",
                                    <?php
                                    // Date find from 5 days ago
                                    
                                    for ($i = 0; $i < 11; $i++) {
                                        $daystkt = date('Y-m-d', strtotime('-' . $i . ' day'));
                                        $tktsql = $con->query("SELECT * FROM ticket WHERE startdate LIKE '%$daystkt%' AND ticket_type='Active'");
                                        echo $tktsql->num_rows;
                                        echo ',';
                                    }
                                    
                                    ?>


                                ]
                            ],
                            type: "bar",
                            colors: {
                                Tickets: "#fb8c00",
                                Resolved: "#3bc3e9",
                                Pending: "#5468da"
                            }
                        }
                    })
                },
                e.ChartC3 = new a, e.ChartC3.Constructor = a
        }(window.jQuery),
        function() {
            "use strict";
            window.jQuery.ChartC3.init()
        }();


        $('#expire_customer_datatable').dataTable();
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#cstmr_ac').select2();
            //
            $('#addRechargeModal').on('shown.bs.modal', function() {
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
            sendData(customer_id, month, package, mainAmount, tra_type, pop_id, ref);
        });
        const sendData = (customer_id, month, package, mainAmount, tra_type, pop_id, ref) => {

            if (month.length == 0) {
                toastr.error("Select Month");
            } else if (customer_id.length == 0) {
                toastr.error("Select Customer");
            } else if (tra_type.length == 0) {
                toastr.error("Select Transaction");
            } else {
                $("#add_recharge_btn").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
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
                        add_recharge_data: 0
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
