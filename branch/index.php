<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
$CurPageURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if (!isset($_SESSION)) {
    session_start();
}
$rootPath = $_SERVER['DOCUMENT_ROOT'];

$db_connect_path = $rootPath . '/include/db_connect.php';
$users_right_path = $rootPath . '/include/users_right.php';
$custom_func_path = $rootPath . '/include/functions.php';

if (file_exists($db_connect_path)) {
    require $db_connect_path;
}

if (file_exists($users_right_path)) {
    require $users_right_path;
}
if (file_exists($custom_func_path)) {
    require $custom_func_path;
}

if (isset($_GET['paymentID']) && $_GET['status'] == 'success') {
    $paymentID = $_GET['paymentID'];
    $id_token = $_SESSION['id_token'];
    $app_key = $_SESSION['app_key'];
    $amount = $_SESSION['final_amount'];
    $pop_id = $_SESSION['pop_id'];

    $post_paymentID = [
        'paymentID' => $paymentID,
    ];

    $posttoken = json_encode($post_paymentID);
    $base_url = 'https://tokenized.pay.bka.sh/v1.2.0-beta/tokenized/checkout';
    $url = curl_init("$base_url/execute");
    $header = ['Content-Type:application/json', "authorization:$id_token", "x-app-key:$app_key"];

    curl_setopt($url, CURLOPT_HTTPHEADER, $header);
    curl_setopt($url, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($url, CURLOPT_POSTFIELDS, $posttoken);
    curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_exec($url);
    curl_close($url);

    $result = $con->query("SELECT `fullname` FROM add_pop WHERE id='$pop_id'");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $recharge_by = $row['fullname'];
    }

    date_default_timezone_set('Asia/Dhaka');
    $todayDate = date('H:i A, d-M-Y');
    $percent_amount = $amount - $amount * 0.02;
    $con->query("INSERT INTO pop_transaction(pop_id,amount,paid_amount,action,transaction_type,recharge_by,date)VALUES('$pop_id','$percent_amount','$percent_amount','Recharge','2','$recharge_by','$todayDate')");

    // Clear session data
    unset($_SESSION['id_token'], $_SESSION['app_key'], $_SESSION['final_amount'], $_SESSION['pop_id']);

    header("Location: $CurPageURL");
    exit();
}

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
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    
    $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
    $url = $protocol . $_SERVER['HTTP_HOST'] . '/style.php';
    
    echo file_get_contents($url);
    
    ?>

</head>

<body data-sidebar="dark">


    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php $page_title = 'Branch Dashboard';
        include '../Header.php'; ?>

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
                            <button type="button" data-bs-toggle="modal" data-bs-target="#addRechargeModal"
                                class="btn-sm btn btn-primary mb-1"><i class="mdi mdi-battery-charging-90"></i> Recharge
                                Now</button>

                            <button type="button" data-bs-toggle="modal" data-bs-target="#addCustomerModal"
                                class="btn-sm btn btn-success mb-1"><i class="mdi mdi-account-plus"></i> Add
                                Customer</button>



                            <button type="button" data-bs-toggle="modal" data-bs-target="#sendMessage"
                                class="btn-sm btn btn-primary mb-1"><i class="far fa-envelope"></i> SMS
                                Notification</button>

                            <button type="button" data-bs-toggle="modal" data-bs-target="#ticketModal"
                                class="btn-sm btn btn-success mb-1">Add Ticket</button>


                            <button type="button" class="btn-sm btn mb-1" data-bs-toggle="modal"
                                data-bs-target="#bkash_paymentModal">
                                <img src="images/bkash_payment_logo.svg" class="img-fluid" height="50px"
                                    width="80px">
                            </button>

                        </div>
                    </div>

                  <?php require 'Component/Customer_statics.php'; ?>
                    <div class="row">
                        <?php require 'Component/Transaction_history.php'; ?>
                        <div class="col-md-6 col-xl-3">
                            <div class="card ">
                                <a href="allTickets.php">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-warning me-0 float-end"><i
                                                    class="fas fa-notes-medical"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-teal">
                                                    <?php if ($dsblcstmr = $con->query("SELECT * FROM ticket WHERE pop_id=$auth_usr_POP_id")) {
                                                        echo $dsblcstmr->num_rows;
                                                    }
                                                    ?>
                                                </span>
                                                Tickets
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div><!--end col -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <a href="pop_area.php">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-teal me-0 float-end"><i
                                                    class="fas fa-search-location"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-teal">
                                                    <?php if ($totalCustomer = $con->query("SELECT * FROM area_list WHERE pop_id='$auth_usr_POP_id' ")) {
                                                        echo $totalCustomer->num_rows;
                                                    }
                                                    
                                                    ?>
                                                </span>
                                                Area
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div> <!--End col -->
                    </div>
                    <div class="row">
                        <div class="card">
                            <div class="card-body">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#branch_user"
                                            role="tab">
                                            <span class="d-none d-md-block">Users (

                                                <?php if ($totalCustomers = $con->query("SELECT * FROM customers WHERE pop=$auth_usr_POP_id ")) {
                                                    echo $totalCustomers->num_rows;
                                                }
                                                
                                                ?>

                                                )</span><span class="d-block d-md-none"><i
                                                    class="mdi mdi-account-check h5"></i></span>
                                        </a>
                                    </li>


                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tickets" role="tab">
                                            <span class="d-none d-md-block">Tickets
                                            </span><span class="d-block d-md-none"><i
                                                    class="mdi mdi-home-variant h5"></i></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#recharge_history"
                                            role="tab">
                                            <span class="d-none d-md-block">Recharge History</span><span
                                                class="d-block d-md-none"><i
                                                    class="mdi mdi-battery-charging h5"></i></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#packages" role="tab">
                                            <span class="d-none d-md-block">Package</span><span
                                                class="d-block d-md-none"><i class="mdi mdi-package h5"></i></span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#pop_transaction"
                                            role="tab">
                                            <span class="d-none d-md-block">Transaction Statment</span><span
                                                class="d-block d-md-none"><i
                                                    class="mdi mdi-currency-bdt h5"></i></span>
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <div class="tab-pane active p-3" id="branch_user" role="tabpanel">
                                        <div class="card">

                                            <div class="card-body">
                                                <table id="customers_table"
                                                    class="table table-bordered dt-responsive nowrap"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th><input type="checkbox" id="checkedAll"
                                                                    name="checkedAll" class="form-check-input"></th>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Package</th>
                                                            <th>Amount</th>
                                                            <th>Create Date</th>
                                                            <th>Expired Date</th>
                                                            <th>User Name</th>
                                                            <th>Mobile no.</th>
                                                            <th>POP/Branch</th>
                                                            <th>Area/Location</th>
                                                            <th>Liablities</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="customer-list">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane p-3" id="tickets" role="tabpanel">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="tickets_datatable"
                                                    class="table table-bordered dt-responsive nowrap"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Status</th>
                                                            <th>Created</th>
                                                            <th>Priority</th>
                                                            <th>Customer Name</th>
                                                            <th>Phone Number</th>
                                                            <th>Issues</th>
                                                            <th>Pop/Area</th>
                                                            <th>Assigned Team</th>
                                                            <th>Ticket For</th>
                                                            <th>Acctual Work</th>
                                                            <th>Percentage</th>
                                                            <th>Note</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane p-3" id="recharge_history" role="tabpanel">
                                        <div class="card">

                                            <div class="card-body">
                                                <table id="recharge_history_datatable"
                                                    class="table table-bordered dt-responsive nowrap"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Recharged date</th>
                                                            <th>Customer Name</th>
                                                            <th>Months</th>
                                                            <th>Paid until</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane p-3" id="packages" role="tabpanel">
                                        <div class="card">

                                            <div class="card-body">
                                                <table id="package_datatable"
                                                    class="table table-bordered dt-responsive nowrap"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                                        $sql = "SELECT * FROM branch_package WHERE pop_id='$auth_usr_POP_id'";
                                                        $result = mysqli_query($con, $sql);

                                                        while ($rows = mysqli_fetch_assoc($result)) {

                                                        ?>

                                                        <tr>
                                                            <td><?php echo $increment++; ?></td>

                                                            <td><?php echo $rows['package_name']; ?></td>
                                                            <td><?php echo $rows['p_price']; ?></td>
                                                            <td><?php echo $rows['s_price']; ?></td>


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
                                                <?php include 'Table/transaction_history_table.php'; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="row">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="map" style="height: 400px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-7 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-header text-black bg-white">
                                    <h4 class="card-title">POP/Branch Area</h4>
                                </div>
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table id="expire_customer_datatable"
                                            class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Area Name</th>
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
                                                $sql = "SELECT * FROM area_list WHERE pop_id='$auth_usr_POP_id'";
                                                $result = mysqli_query($con, $sql);

                                                while ($rows = mysqli_fetch_assoc($result)) {
                                                   $areaid = $rows['id'];
                                                ?>

                                                <tr>
                                                    <td><?php echo $rows['id']; ?></td>
                                                    <td><a
                                                            href="view_area.php?id=<?php echo $areaid; ?>"><?php echo $rows['name']; ?></a>
                                                    </td>
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
                                                        $disableQ = "SELECT * FROM customers WHERE area='$areaid' AND status='0'";
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
                                    <div class="table table-responsive">
                                        <table id="tickets_table" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Created</th>
                                                    <th>Customer</th>
                                                    <th>Issues</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="ticket-list">
                                                <?php
                                                $sql = "SELECT * FROM `ticket` WHERE pop_id=$auth_usr_POP_id ORDER BY id DESC limit 5";
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
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE pop_id=$auth_usr_POP_id AND startdate BETWEEN '$daystkt' AND NOW()");
                                                echo $tktsql->num_rows;
                                                ?>

                                            </h5>
                                            <p class="text-muted text-truncate">Tickets</p>
                                        </div>
                                        <div class="col-3">
                                            <h5 class="mb-0 font-size-18">
                                                <?php
                                                $daystkt = date('Y-m-d', strtotime('-7 day'));
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE pop_id=$auth_usr_POP_id AND ticket_type='Complete' AND startdate BETWEEN '$daystkt' AND NOW()");
                                                echo $tktsql->num_rows;
                                                ?>

                                            </h5>
                                            <p class="text-muted text-truncate">Resolved</p>
                                        </div>
                                        <div class="col-3">
                                            <h5 class="mb-0 font-size-18">
                                                <?php
                                                $daystkt = date('Y-m-d', strtotime('-7 day'));
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE pop_id=$auth_usr_POP_id AND ticket_type='Active' AND startdate BETWEEN '$daystkt' AND NOW()");
                                                echo $tktsql->num_rows;
                                                ?>
                                            </h5>
                                            <p class="text-muted text-truncate">Pending</p>
                                        </div>

                                        <div class="col-3">
                                            <h5 class="mb-0 font-size-18">
                                                <?php
                                                $daystkt = date('Y-m-d', strtotime('-7 day'));
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE pop_id=$auth_usr_POP_id AND ticket_type='Close' AND startdate BETWEEN '$daystkt' AND NOW()");
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

                                    <div id="simple-line-chart" style="height: 310px;"></div>

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
                                                $sql = "SELECT * FROM customers WHERE pop=$auth_usr_POP_id ORDER BY id DESC LIMIT 5 ";
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
                                                <a href="customer_expire.php">+</a>
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
                                                $sql = "SELECT * FROM customers WHERE expiredate<NOW() AND pop=$auth_usr_POP_id ORDER BY id DESC LIMIT 5 ";
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
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE pop_id=$auth_usr_POP_id AND startdate BETWEEN '$daystkt' AND NOW()");
                                                echo $tktsql->num_rows;
                                                ?>

                                            </h5>
                                            <p class="text-muted text-truncate">Tickets</p>
                                        </div>
                                        <div class="col-3">
                                            <h5 class="mb-0 font-size-18">
                                                <?php
                                                $daystkt = date('Y-m-d', strtotime('-7 day'));
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE pop_id=$auth_usr_POP_id AND ticket_type='Complete' AND startdate BETWEEN '$daystkt' AND NOW()");
                                                echo $tktsql->num_rows;
                                                ?>

                                            </h5>
                                            <p class="text-muted text-truncate">Resolved</p>
                                        </div>
                                        <div class="col-3">
                                            <h5 class="mb-0 font-size-18">
                                                <?php
                                                $daystkt = date('Y-m-d', strtotime('-7 day'));
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE  pop_id=$auth_usr_POP_id AND ticket_type='Active' AND startdate BETWEEN '$daystkt' AND NOW()");
                                                echo $tktsql->num_rows;
                                                ?>
                                            </h5>
                                            <p class="text-muted text-truncate">Pending</p>
                                        </div>

                                        <div class="col-3">
                                            <h5 class="mb-0 font-size-18">
                                                <?php
                                                $daystkt = date('Y-m-d', strtotime('-7 day'));
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE pop_id=$auth_usr_POP_id AND ticket_type='Close' AND startdate BETWEEN '$daystkt' AND NOW()");
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
                                                        $sql = "SELECT * FROM customers WHERE pop=$auth_usr_POP_id AND createdate LIKE '%$currentyrMnth%'";
                                                        $result = mysqli_query($con, $sql);
                                                        $countconn = mysqli_num_rows($result);
                                                        echo '<a href="customers_new.php?new_customer_month=' . $currentyrMnth . '">' . $countconn . '</a>';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $sql = "SELECT * FROM customers WHERE pop=$auth_usr_POP_id AND expiredate LIKE '%$currentyrMnth%'";
                                                        $result = mysqli_query($con, $sql);
                                                        $countexpconn = mysqli_num_rows($result);
                                                        echo '<a href="customers_new.php?expire_customer_month=' . $currentyrMnth . '">' . $countexpconn . '</a>';
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
                    <!-- end row -->



                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php
            
            $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
            $url = $protocol . $_SERVER['HTTP_HOST'] . '/Footer.php';
            
            echo file_get_contents($url);
            
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
                                    if ($allCustomer = $con->query("SELECT * FROM customers WHERE pop=$auth_usr_POP_id ")) {
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
                                <select name="cstmr_ac" id="cstmr_ac" class="form-select select2"
                                    style="width:100%;">
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
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light">Send Message</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <!-- Customer Modal -->
    <?php include 'modal/customer_modal.php'; ?>
    <!-- Tickets Modal -->
    <?php include 'modal/tickets_modal.php'; ?>
    <!-- Bkash Payment  Modal -->
    <div class="modal fade" id="bkash_paymentModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">POP/Branch Recharge</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="bkash_payment_form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group mb-2">
                                <label for="">Amount</label>
                                <input type="text" name="received_amount" class="form-control"
                                    placeholder="Enter Your Amount">
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Charge Amount</label>
                                <input readonly type="text" name="charge_amount" class="form-control"
                                    value="00">
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Billing Amount</label>
                                <input readonly type="text" name="amount" class="form-control" value="00">
                            </div>
                            <div class="form-group mb-2 d-none">
                                <input type="text" name="pop_id" class="form-control"
                                    value="<?php echo $auth_usr_POP_id ?? 0; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-cash"></i>&nbsp;Payment
                            Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <?php
    
    $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
    $url = $protocol . $_SERVER['HTTP_HOST'] . '/script.php';
    
    echo file_get_contents($url);
    
    ?>
    <script src="js/customer.js"></script>
    <script type="text/javascript" src="../../js/google_map.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("input[name='received_amount']").keyup(function() {
                var received_amount = parseFloat($(this).val());
                if (isNaN(received_amount) || received_amount <= 0) {
                    $("input[name='charge_amount']").val("0");
                    $("input[name='amount']").val("0");
                    return;
                }
                /*Calculate charge and final amount*/
                var charge_amount = received_amount * 0.02;
                var amount = received_amount - charge_amount;

                /* Update the readonly fields*/
                $("input[name='charge_amount']").val(charge_amount.toFixed(2));
                $("input[name='amount']").val(amount.toFixed(2));
            });
            $("#bkash_payment_form").on('submit', function(e) {
                e.preventDefault();
                var amount = $("input[name='received_amount']").val();
                var pop_id = $("input[name='pop_id']").val();
                if (!amount || amount <= 0) {
                    toastr.error("Invalid payment amount!");
                    return;
                }
                window.location.href =
                    `http://<?php echo $_SERVER['HTTP_HOST']; ?>/branch/bkash.php?amount=${amount}&pop_id=${pop_id}&submit_payment=1`;
            });
            $('#customers_table').DataTable({
                "searching": true,
                "paging": true,
                "info": true,
                "order": [
                    [0, "desc"]
                ],
                "lengthChange": true,
                "processing": true,
                "serverSide": true,

                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All']
                ],
                "zeroRecords": "No matching records found",
                "ajax": {
                    url: "../include/customer_server_new.php?get_customers_data=true",
                    type: 'GET',
                    data: function(d) {
                        //d.status = $('.status_filter').val();
                        // d.pop_id = $('.pop_filter').val();
                        d.pop_id = <?php echo $auth_usr_POP_id; ?>;
                        //d.area_id = $('.area_filter').val();
                    },
                },
                "drawCallback": function() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },

            });
            $('#recharge_history_datatable').DataTable({
                "searching": true,
                "paging": true,
                "info": true,
                "order": [
                    [0, "desc"]
                ],
                "lengthChange": true,
                "processing": true,
                "serverSide": true,

                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All']
                ],
                "zeroRecords": "No matching records found",
                "ajax": {
                    url: "../include/customer_recharge_server.php?get_recharge_data=true",
                    type: 'GET',
                    data: function(d) {
                        //d.status = $('.status_filter').val();
                        // d.pop_id = $('.pop_filter').val();
                        d.pop_id = <?php echo $auth_usr_POP_id; ?>;
                    },
                },
                "drawCallback": function() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },

            });

            $('#tickets_datatable').DataTable({
                "searching": true,
                "paging": true,
                "info": false,
                "lengthChange": true,
                "processing": false,
                "serverSide": false,
                "zeroRecords": "No matching records found",
                "ajax": {
                    url: "../include/tickets_server.php?get_tickets_data=1",
                    type: 'GET',
                    data: function(d) {
                        d.area_id = $('.area_filter').val();
                        <?php if (isset($auth_usr_POP_id)) {
                            echo 'd.pop_id = ' . $auth_usr_POP_id;
                        } ?>
                    },
                    beforeSend: function() {
                        $(".dataTables_empty").html(
                            '<img src="../assets/images/loading.gif" style="background-color: transparent"/>'
                        );
                    }
                },
                "order": [
                    [0, 'desc']
                ],
                "scrollX": true,
                "responsive": true,
                "columnDefs": [{
                        "width": "5%",
                        "targets": 0
                    },
                    {
                        "width": "10%",
                        "targets": 1
                    }
                ]
            });

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var protocol = location.protocol;
            var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' +
            '/include/tickets_server.php?get_all_customer=true';

            async function loadCustomerOptions() {
                try {
                    let response = await $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json'
                    });
                    if (response.success === true) {
                        var customerOptions = '<option value="">--- Select Customer ---</option>';

                        $.each(response.data, function(key, customer) {
                            customerOptions += '<option value="' + customer.id + '">[' + customer.id +
                                '] - ' + customer.username + ' || ' + customer.fullname + ', (' +
                                customer.mobile + ')</option>';
                        });

                        $('select[name="menu_select_box"]').html(customerOptions);
                        $('select[name="menu_select_box"]').select2({
                            placeholder: '---Select Customer---',
                        });
                    }

                } catch (error) {
                    console.error('Error fetching customer options:', error);
                }
            }

            if ($('select[name="menu_select_box"]').length > 0) {
                loadCustomerOptions();
            }

            $('select[name="menu_select_box"]').on('change', function() {
                var customerId = $(this).val();
                if (customerId) {
                    window.location.href = 'profile.php?clid=' + customerId;
                }
            });

        });
    </script>
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


            /********************************Recharge script*************************************/

            $('#addRechargeModal').on('shown.bs.modal', function() {
                /*Check if select2 is already initialized*/
                if (!$('#recharge_customer').hasClass("select2-hidden-accessible")) {
                    $("#recharge_customer").select2({
                        dropdownParent: $('#addRechargeModal'),
                        placeholder: "Select Customer"
                    });
                }
            });

            $("#recharge_customer").on('change', function() {
                var id = $("#recharge_customer").val();
                getCustomerPackage(id);
                getCustomerPackagePrice(id);
                getCustomerPopId(id);

            });

            //get Package name
            function getCustomerPackage(recevedId) {
                var customerId = recevedId;
                var protocol = location.protocol;
                var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/customers_server.php';
                $.ajax({
                    url: url,
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
                var protocol = location.protocol;
                var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/customers_server.php';
                $.ajax({
                    url: url,
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
                var protocol = location.protocol;
                var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/customers_server.php';
                $.ajax({
                    url: url,
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
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                        );
                    var protocol = location.protocol;
                    var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' +
                    '/include/customer_recharge_server.php';
                    $.ajax({
                        type: 'POST',
                        url: url,
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

            /******************************** Message Script*************************************/
            $(document).on('change', '#currentMessageTemp', function() {
                var name = $("#currentMessageTemp").val();
                var currentMsgTemp = "0";
                $.ajax({
                    type: 'POST',
                    data: {
                        name: name,
                        currentMsgTemp: currentMsgTemp
                    },
                    url: '../include/message.php',
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





            /******************************** Customer tickets Script*************************************/

            // Customers load function
            function ticket_modal() {
                $("#ticketModal").on('show.bs.modal', function(event) {
                    /*Check if select2 is already initialized*/
                    if (!$('#ticket_customer_id').hasClass("select2-hidden-accessible")) {
                        $("#ticket_customer_id").select2({
                            dropdownParent: $("#ticketModal"),
                            placeholder: "Select Customer"
                        });
                        $("#ticket_assigned").select2({
                            dropdownParent: $("#ticketModal"),
                            placeholder: "---Select---"
                        });
                        $("#ticket_complain_type").select2({
                            dropdownParent: $("#ticketModal"),
                            placeholder: "---Select---"
                        });
                        $("#ticket_priority").select2({
                            dropdownParent: $("#ticketModal"),
                            placeholder: "---Select---"
                        });
                    }
                });
            }

            function loadCustomers(selectedCustomerId) {
                var protocol = location.protocol;
                var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' +
                    '/include/tickets_server.php?get_all_customer=true';
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success == true) {
                            let customerSelect = $("#ticket_customer_id");
                            customerSelect.empty();
                            customerSelect.append('<option value="">---Select Customer---</option>');
                            $.each(response.data, function(index, customer) {
                                customerSelect.append('<option value="' + customer.id + '">[' +
                                    customer.id + '] - ' + customer.username + ' || ' +
                                    customer.fullname + ', (' + customer.mobile +
                                    ')</option>');
                            });
                        }
                        if (selectedCustomerId) {
                            $("#ticket_customer_id").val(selectedCustomerId);
                        }
                    }
                });
            }

            // Ticket assign function
            function ticket_assign(customerId) {
                if (customerId) {
                    var protocol = location.protocol;
                    var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/tickets_server.php';
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            customer_id: customerId,
                            get_area: true,
                        },
                        success: function(response) {
                            $("#ticket_assigned").html(response);
                        }
                    });
                } else {
                    $(document).on('change', '#ticket_customer_id', function() {
                        var protocol = location.protocol;
                        var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/tickets_server.php';
                        /* Make AJAX request to server*/
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                customer_id: $(this).val(),
                                get_area: true,
                            },
                            success: function(response) {
                                /* Handle the response from the server*/
                                $("#ticket_assigned").html(response);
                            }
                        });
                    });
                }
            }

            // Ticket complain type function
            function ticket_complain_type() {
                var protocol = location.protocol;
                var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/tickets_server.php';
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        get_complain_type: true,
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success == true) {
                            let ticket_complain_type = $("#ticket_complain_type");
                            ticket_complain_type.empty();
                            ticket_complain_type.append('<option value="">---Select---</option>');
                            $.each(response.data, function(index, item) {
                                ticket_complain_type.append('<option value="' + item.id + '">' +
                                    item.topic_name + '</option>');
                            });
                        }
                    }
                });
            }


            $("#ticket_modal_form").submit(function(e) {
                e.preventDefault();

                /* Get the submit button */
                var submitBtn = $(this).find('button[type="submit"]');
                var originalBtnText = submitBtn.html();

                submitBtn.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden"></span>'
                    );
                submitBtn.prop('disabled', true);

                var form = $(this);
                var formData = new FormData(this);

                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $("#ticketModal").fadeOut(500, function() {
                                $(this).modal('hide');
                                toastr.success(response.message);
                                $('#tickets_datatable').DataTable().ajax.reload();
                            });

                        } else if (!response.success && response.errors) {
                            $.each(response.errors, function(field, message) {
                                toastr.error(message);
                            });
                        }
                    },
                    complete: function() {
                        submitBtn.html(originalBtnText);
                        submitBtn.prop('disabled', false);
                    }
                });
            });
            /*** Add ticket Modal Script****/
            ticket_modal();
            loadCustomers();
            ticket_assign();
            ticket_complain_type();






            /******************************** Customer Static Script*************************************/










        });
    </script>
    <script type="text/javascript">
        new Chartist.Line("#simple-line-chart", {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            series: [{
                    name: 'New Customers',
                    data: [<?php
                    for ($i = 1; $i <= 12; $i++) {
                        $currentyrMnth = date('Y') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
                        $sql = "SELECT COUNT(*) AS new_customers FROM customers WHERE pop=$auth_usr_POP_id AND createdate LIKE '%$currentyrMnth%'";
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
                        $sql = "SELECT COUNT(*) AS active_customers FROM customers WHERE pop=$auth_usr_POP_id AND status = '1' AND createdate LIKE '%$currentyrMnth%'";
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
                        $sql = "SELECT COUNT(*) AS expired_customers FROM customers WHERE pop=$auth_usr_POP_id AND expiredate LIKE '%$currentyrMnth%'";
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
                        $sql = "SELECT COUNT(*) AS disabled_customers FROM customers WHERE pop=$auth_usr_POP_id AND status = '0' AND createdate LIKE '%$currentyrMnth%'";
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
                                        $tktsql = $con->query("SELECT * FROM ticket WHERE pop_id=$auth_usr_POP_id AND startdate LIKE '%$daystkt%'");
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
                                        $tktsql = $con->query("SELECT * FROM ticket WHERE pop_id=$auth_usr_POP_id AND startdate LIKE '%$daystkt%' AND ticket_type='Complete'");
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
                                        $tktsql = $con->query("SELECT * FROM ticket WHERE pop_id=$auth_usr_POP_id AND startdate LIKE '%$daystkt%' AND ticket_type='Active'");
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
                                        $sql = "SELECT * FROM customers WHERE pop=$auth_usr_POP_id AND createdate LIKE '%$currentyrMnth%'";
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
                                        $sql = "SELECT * FROM customers WHERE pop=$auth_usr_POP_id AND expiredate LIKE '%$currentyrMnth%'";
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
                                        $tktsql = $con->query("SELECT * FROM ticket WHERE pop_id=$auth_usr_POP_id AND startdate LIKE '%$daystkt%' AND ticket_type='Active'");
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
        /*************************Google Map Load**********************************************************/
        loadMaps(<?= $auth_usr_POP_id ?>, 0);
    </script>



</body>

</html>
