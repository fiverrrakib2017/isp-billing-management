<?php
include 'include/security_token.php';
include 'include/db_connect.php';
include 'include/users_right.php';
include 'include/pop_security.php';
if (isset($_GET['id'])) {
    $popid = $_GET['id'];
}
if ($pop_list = $con->query("SELECT * FROM add_pop WHERE id='$popid'")) {
    while ($rows = $pop_list->fetch_array()) {
        $lstid = $rows['id'];
        $pop_name = $rows['pop'];
        $pop_status = $rows['status'];
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
    if (isset($_GET['inactive'])) {
        if ($_GET['inactive'] == 'true') {
            $popID = $_GET['id'];

            $custmrs = $con->query("SELECT * FROM customers WHERE pop=$popID");
            while ($rowsct = mysqli_fetch_assoc($custmrs)) {
                $custmr_usrname = $rowsct['username'];

                // Deleting users from Radius user list
                $con->query("DELETE FROM radcheck WHERE username = '$custmr_usrname'");
                $con->query("DELETE FROM radreply WHERE username = '$custmr_usrname'");
                $con->query("UPDATE customers SET status='0' WHERE username='$custmr_usrname'");
                $con->query("UPDATE add_pop SET status='0' WHERE id='$popID'");
            }

            header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $popID);
            die();
        } elseif ($_GET['inactive'] == 'false') {
            $popID = $_GET['id'];

            $custmrs = $con->query("SELECT * FROM customers WHERE pop=$popID");
            while ($rowsct = mysqli_fetch_assoc($custmrs)) {
                $custmr_usrname = $rowsct['username'];
                $custmr_password = $rowsct['password'];
                $custmr_package = $rowsct['package_name'];

                // Deleting users from Radius user list
                $con->query("INSERT INTO radcheck(username,attribute,op,value) VALUES('$custmr_usrname','Cleartext-Password',':=','$custmr_password')");
                $con->query("INSERT INTO radreply (username,attribute,op,value) VALUES('$custmr_usrname','MikroTik-Group',':=','$custmr_package')");
                $con->query("UPDATE customers SET status='1' WHERE username='$custmr_usrname'");
                $con->query("UPDATE add_pop SET status='1' WHERE id='$popID'");
            }

            header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $popID);
            die();
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
    <?php include 'style.php'; ?>
</head>

<body data-sidebar="dark">




    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php $page_title = 'POP/Branch';
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
                                            <p class="text-muted mb-0 hover-cursor">
                                                <a href="index.php">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</a>
                                            </p>
                                            <p class="text-primary mb-0 hover-cursor"><a
                                                    href="pop_branch.php">POP&nbsp;/&nbsp; </a><?php echo $pop_name; ?></p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">

                                    <div class="d-flex py-2" style="float:right;">
                                        <abbr title="Recharge All">
                                            <button type="button" class="btn-sm btn btn-success" style="float:right;"
                                                type="button" id="RchgMdlBtn"><i
                                                    class="ion ion-ios-people"></i></button>
                                        </abbr>
                                        &nbsp;
                                        <abbr title="Add Package">
                                            <button type="button" class="btn-sm btn btn-danger" style="float:right;"
                                                type="button" id="packageAddBtn"><i
                                                    class="mdi mdi-briefcase-plus"></i></button>
                                        </abbr>
                                        &nbsp;
                                        <abbr title="Add Customer">
                                            <button type="button" data-bs-target="#addCustomerModal"
                                                data-bs-toggle="modal" class="btn-sm btn btn-primary"
                                                style="float:right;" type="button" id=""><i
                                                    class="mdi mdi-account-plus"></i></button>
                                        </abbr>
                                        &nbsp;
                                        <abbr title="Complain">
                                            <button type="button" data-bs-target="#ComplainModalCenter"
                                                data-bs-toggle="modal" class="btn-sm btn btn-warning ">
                                                <i class="mdi mdi-alert-outline"></i>
                                            </button></abbr>
                                        &nbsp;
                                        <abbr title="Recharge">
                                            <button type="button" id="rechargeBtn" class="btn-sm btn btn-primary "
                                                data-bs-target="#addRechargeModal" data-bs-toggle="modal">
                                                <i class="mdi mdi mdi-battery-charging-90"></i>
                                            </button></abbr>
                                        &nbsp;
                                        <abbr title="Recharge">
                                            <button type="button" id="" class="btn-sm btn btn-success "
                                                data-bs-target="#addPaymentModal" data-bs-toggle="modal">
                                                <i class=" mdi mdi-cash-multiple"></i>
                                            </button></abbr>
                                        &nbsp;

                                        <?php
                                        //echo $pop_status;
                                        if ($pop_status == '0') {
                                            $checkd = '';
                                            echo '<a href="?inactive=false&id=' .
                                                $lstid .
                                                '"><abbr title="Make Enable POP"><button type="button" class="btn-sm btn btn-success">
                                                                                                                                               <i class="mdi mdi mdi-wifi-off "></i>
                                                                                                                                           </button></abbr></a>';
                                        } elseif ($pop_status == '1') {
                                            echo '<a href="?inactive=true&id=' .
                                                $lstid .
                                                '"><abbr title="Make Disable POP"><button type="button" class="btn-sm btn btn-danger">
                                                                                                                                                <i class="mdi mdi mdi-wifi-off "></i>
                                                                                                                                            </button></abbr></a>';
                                            $checkd = 'checked';
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
                                            Online
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End col -->

                        <div class="col-md-6 col-xl-3">
                            <a href="customers_new.php?pop_id=<?php echo $popid; ?>&active=1">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-success me-0 float-end"><i
                                                    class="fas fa-users"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-success">
                                                    <?php if ($totalCustomer = $con->query("SELECT * FROM customers WHERE status='1' AND pop=$popid")) {
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
                                <a href="customer_expire.php?pop_id=<?php echo $popid; ?>">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-danger me-0 float-end"><i
                                                    class="fas fa-exclamation-triangle"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-danger">
                                                    <?php if ($AllExcstmr = $con->query("SELECT * FROM `customers` WHERE  NOW() > expiredate AND pop=$popid")) {
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
                                <a href="customer_disabled.php?pop_id=<?php echo $popid; ?>">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-secondary me-0 float-end"><i
                                                    class="fas fa-user-slash"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-secondary">
                                                    <?php if ($dsblcstmr = $con->query("SELECT * FROM customers WHERE status='0' AND pop=$popid")) {
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
                        <div class="col-md-6 col-xl-4">

                            <div class="card">
                                <div class="card-body">
                                    <a href="pop_area.php?pop_id=<?php echo $popid; ?>">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-teal me-0 float-end"><i
                                                    class="fas fa-search-location"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-teal">
                                                    <?php if ($totalarea = $con->query("SELECT * FROM area_list WHERE pop_id=$popid")) {
                                                        echo $totalarea->num_rows;
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





                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <a href="allTickets.php?pop_id=<?php echo $popid; ?>">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-warning me-0 float-end">
                                                <i class="fas fa-notes-medical"></i>
                                            </span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-danger">
                                                    <?php
                                                    if ($dsblcstmr = $con->query("SELECT * FROM ticket WHERE pop_id=$popid")) {
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
                        </div> <!-- End col -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2" style="border-left:3px solid #2A0FF1;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Current Balance</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                if ($pop_payment = $con->query(" SELECT SUM(`amount`) AS balance FROM `pop_transaction` WHERE pop_id='$popid' ")) {
                                                    while ($rows = $pop_payment->fetch_array()) {
                                                        $currentBal += $rows['balance'];
                                                    }
                                                    if ($pop_payment = $con->query(" SELECT `purchase_price` FROM `customer_rechrg` WHERE pop_id='$popid' ")) {
                                                        while ($rows = $pop_payment->fetch_array()) {
                                                            $totalpaid += $rows['purchase_price'];
                                                        }
                                                        echo $currentBal - $totalpaid;
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

                    </div> <!-- end row-->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2" style="border-left:3px solid #27F10F;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Paid</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                
                                                if ($pop_payment = $con->query(" SELECT `paid_amount` FROM `pop_transaction` WHERE pop_id='$popid'")) {
                                                    while ($rows = $pop_payment->fetch_array()) {
                                                        $stotalpaid += $rows['paid_amount'];
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
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Due</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                if ($pop_payment = $con->query("SELECT SUM(amount) AS balance FROM `pop_transaction` WHERE pop_id=$popid  ")) {
                                                    while ($rows = $pop_payment->fetch_array()) {
                                                        $totalAmount += $rows['balance'];
                                                    }
                                                    $totalAmount;
                                                }
                                                
                                                if ($pop_payment = $con->query("SELECT SUM(paid_amount) AS amount FROM `pop_transaction` WHERE pop_id=$popid")) {
                                                    while ($rows = $pop_payment->fetch_array()) {
                                                        $paidAmount += $rows['amount'];
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
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Due
                                                Paid</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                
                                                if ($pop_dupayment = $con->query(" SELECT paid_amount FROM pop_transaction WHERE pop_id='$popid' AND transaction_type='5' ")) {
                                                    while ($rowsdp = $pop_dupayment->fetch_array()) {
                                                        $stotalDupaid += $rowsdp['paid_amount'];
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
                                            <p><i class="mdi mdi-marker-check"></i> Incharge Fullname:</p> <a
                                                href="#"><?php echo $fullname; ?></a>
                                        </div>
                                        <div class="d-flex justify-content-between border-bottom py-2 px-3">
                                            <p><i class="mdi mdi-account-circle"></i> Incharge Username:</p> <a
                                                href="#"><?php echo $username; ?></a>
                                        </div>
                                        <div class="d-flex justify-content-between border-bottom py-2 px-3">
                                            <p><i class=" fas fa-dollar-sign"></i> Opening Balance:</p> <a
                                                href="#"><?php echo $opening_bal; ?></a>
                                        </div>
                                        <div class="d-flex justify-content-between border-bottom py-2 px-3">
                                            <p><i class="mdi mdi-phone"></i> Mobile:</p> <a
                                                href="#"><?php echo $mobile_num1; ?></a>
                                        </div>
                                        <div class="d-flex justify-content-between border-bottom py-2 px-3">
                                            <p><i class=" fas fa-envelope"></i> Email Address:</p> <a
                                                href="#"><?php echo $email_address; ?></a>
                                        </div>
                                    </div>
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

                                    <div id="simple-line-chart" class="ct-chart ct-golden-section" dir="ltr">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
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
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE ticket_type='Complete' AND startdate BETWEEN '$daystkt' AND NOW() AND pop_id=$popid");
                                                echo $tktsql->num_rows;
                                                ?>

                                            </h5>
                                            <p class="text-muted text-truncate">Resolved</p>
                                        </div>
                                        <div class="col-3">
                                            <h5 class="mb-0 font-size-18">
                                                <?php
                                                $daystkt = date('Y-m-d', strtotime('-7 day'));
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE ticket_type='Active' AND startdate BETWEEN '$daystkt' AND NOW() AND pop_id=$popid");
                                                echo $tktsql->num_rows;
                                                ?>
                                            </h5>
                                            <p class="text-muted text-truncate">Pending</p>
                                        </div>

                                        <div class="col-3">
                                            <h5 class="mb-0 font-size-18">
                                                <?php
                                                $daystkt = date('Y-m-d', strtotime('-7 day'));
                                                $tktsql = $con->query("SELECT * FROM ticket WHERE ticket_type='Close' AND startdate BETWEEN '$daystkt' AND NOW() AND pop_id=$popid");
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
                        <div class="col-md-6 stretch-card">
                            <div class="card">
                                <div class="card-body">



                                    <div class="row">
                                        <div class="col-md-8 mt-1 py-2">
                                            <p class="card-title ">Recent Customers</p>
                                        </div>
                                        <div class="col-md-4">
                                            <button style="float: right;">
                                                <a href="customers_new.php?pop_id=<?php echo $popid; ?>&active=1">+</a>
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
                                                $sql = "SELECT * FROM customers WHERE pop=$popid ORDER BY id DESC LIMIT 5 ";
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
                                                    $sql = "SELECT * FROM customers WHERE createdate LIKE '%$currentyrMnth%' AND pop=$popid";
                                                    $result = mysqli_query($con, $sql);
                                                    $countconn = mysqli_num_rows($result);
                                                    echo '<a href="customer_newcon.php?list=' . $currentyrMnth . '">' . $countconn . '</a>';
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $sql = "SELECT * FROM customers WHERE  expiredate LIKE '%$currentyrMnth%' AND pop=$popid";
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


                </div> <!-- container-fluid -->

                <div class="">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#branch_user"
                                            role="tab">
                                            <span class="d-none d-md-block">Users (

                                                <?php if ($totalCustomers = $con->query("SELECT * FROM customers WHERE pop=$popid ")) {
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
                                                            <th>Expired Date</th>
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
                                                    <!-- <tbody>
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
                                                                    echo $dateTm->format('d-M-Y');
                                                                    ?>
                                                                </td>

                                                                <td>
                                                                    <?php
                                                                    $getCstmrId = $rows['customer_id'];
                                                                    if ($allCom = $con->query("SELECT * FROM customers WHERE id='$getCstmrId' ")) {
                                                                        while ($rowss = $allCom->fetch_array()) {
                                                                            $customerName = $rowss['fullname'];
                                                                            echo '<a href="profile.php?clid=' . $getCstmrId . '">' . $customerName . '</a>';
                                                                        }
                                                                    }
                                                                    ?>

                                                                </td>


                                                                <td><?php echo $rows['months']; ?></td>
                                                                <td><?php echo $rows['rchrg_until']; ?></td>
                                                                <td><?php echo $rows['purchase_price']; ?></td>

                                                            </tr>
                                                        <?php } ?>
                                                    </tbody> -->
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
                                                        $sql = "SELECT * FROM branch_package WHERE pop_id='$popid'";
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
                                                <table id="transaction_datatable"
                                                    class="table table-bordered dt-responsive nowrap"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                                            <td> <?php echo $rows['amount']; ?></td>
                                                            <td> <?php echo $rows['paid_amount']; ?></td>


                                                            <td>
                                                                <?php
                                                                $transaction_action = $rows['action'];
                                                                $transaction_type = $rows['transaction_type'];
                                                                
                                                                if ($transaction_action == 'Recharge' && $transaction_type == '1') {
                                                                    echo '<span class="badge bg-danger">Recharged</span> <br> <span class="badge bg-success">Paid</span>';
                                                                } elseif ($transaction_action == 'Recharge' && $transaction_type == '0') {
                                                                    echo '<span class="badge bg-danger">Recharged </span>';
                                                                } elseif ($transaction_action == 'paid') {
                                                                    echo '<span class="badge bg-success">Paid</span>';
                                                                } elseif ($transaction_action == 'Return') {
                                                                    echo '<span class="badge bg-warning">Return</span>';
                                                                }
                                                                
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $transaction_type = $rows['transaction_type'];
                                                                if ($transaction_type == 1) {
                                                                    echo '<button class="btn-sm btn btn-outline-success">Cash</button>';
                                                                } elseif ($transaction_type == 0) {
                                                                    echo '<button class="btn-sm btn btn-outline-danger">Credit</button>';
                                                                } elseif ($transaction_type == 2) {
                                                                    echo 'Bkash';
                                                                } elseif ($transaction_type == 3) {
                                                                    echo 'Nagad';
                                                                } elseif ($transaction_type == 4) {
                                                                    echo 'Bank';
                                                                } elseif ($transaction_type == 5) {
                                                                    echo '<button class="btn-sm btn btn-outline-primary">Payment Rcvd</button>';
                                                                }
                                                                
                                                                ?>
                                                            </td>
                                                            <td> <?php echo $rows['date']; ?></td>
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
            <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel"
                aria-hidden="true" id="addRechargeModal">
                <div class="modal-dialog" role="document">
                    <form id="FormData">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add POP Recharge</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <input class="d-none" type="text" name="pop_id"
                                        value="<?php echo $popid; ?>">
                                    <div class="form-group mb-2">
                                        <label>Amount:</label>
                                        <input type="text" id="addPopAmount" placeholder="Enter Your Amount"
                                            class="form-control">
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
                                        <input type="text" id="recharge_by" class="form-control"
                                            value="<?php echo $_SESSION['username']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                    class="btn btn-danger">Cancle</button>
                                <button id="submitBtn" type="button" name="submit"
                                    class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel"
                aria-hidden="true" id="addPaymentModal">
                <div class="modal-dialog" role="document">
                    <form id="FormData">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Payment Received</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <input class="d-none" type="text" name="pop_id"
                                        value="<?php echo $popid; ?>">
                                    <div class="form-group mb-2">
                                        <label>Amount:</label>
                                        <input type="text" id="addPopRechargeAmount"
                                            placeholder="Enter Your Amount" class="form-control">
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
                                        <input type="text" id="recharge_by" class="form-control"
                                            value="<?php echo $_SESSION['username']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                    class="btn btn-danger">Cancle</button>
                                <button type="button" id="addPaymentBtn" class="btn btn-primary"><i
                                        class="mdi mdi-cash"></i> Add Payment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel"
                aria-hidden="true" id="addPackageModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Package</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <input class="d-none" type="text" id="pop_id" value="<?php echo $popid; ?>">
                                <div class="form-group mb-2">
                                    <label>Package Name</label>
                                    <select id="p_name" id="p_name" class="form-select"
                                        onchange="getPackagePrice()">
                                        <option>Select Package</option>
                                        <?php
                                        if ($allPackage = $con->query('SELECT * FROM radgroupcheck')) {
                                            while ($rows = $allPackage->fetch_array()) {
                                                echo '<option value=' . $rows['id'] . '>' . $rows['groupname'] . '</option>';
                                            }
                                        }
                                        
                                        ?>


                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Purchase Price</label>
                                    <input type="text" id="p_price" name="p_price"
                                        placeholder="Enter Your Amount" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Sale's Price</label>
                                    <input type="text" id="s_price" name="s_price"
                                        placeholder="Enter Your Amount" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                class="btn btn-danger">Cancle</button>
                            <button id="PackageSubmitBtn" type="button" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>


            <!----------------Customer MODAL---------------->
            <?php include 'modal/customer_modal.php'; ?>
            <?php include 'Footer.php'; ?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <?php include 'script.php'; ?>
    <script type="text/javascript" src="js/customer.js"></script>
    <script type="text/javascript">
        /*************************simple-line-chart Start**************************************************/
        var chart = new Chartist.Line("#simple-line-chart", {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            series: [
                [<?php
                for ($i = 1; $i < 13; $i++) {
                    $currentyrMnth = date('Y') . '-0' . $i;
                    $sql = "SELECT * FROM customers WHERE createdate LIKE '%$currentyrMnth%' AND pop='{$_GET['id']}'";
                    $result = mysqli_query($con, $sql);
                    echo $countconn = mysqli_num_rows($result) . ',';
                }
                ?>],
                [

                    <?php
                    for ($i = 1; $i < 13; $i++) {
                        $currentyrMnth = date('Y') . '-0' . $i;
                        $sql = "SELECT * FROM customers WHERE expiredate LIKE '%$currentyrMnth%' AND pop='{$_GET['id']}'";
                        $result = mysqli_query($con, $sql);
                    }
                    
                    ?>
                ],
                [1, 3, 4, 5, 6, 7, 7, 7, 7, 7, 7, 7, 10],
                [10, 2, 3, 4, 5, 6, 6, 6, 6, 6, 6, 6, 13]
            ]
        }, {
            fullWidth: !0,
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
        /*************************simple-line-chart End**************************************************/
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
                                    // Date find from 9 days ago
                                    for ($i = 0; $i < 9; $i++) {
                                        $daystkt = date('Y-m-d', strtotime('-' . $i . ' day'));
                                        $stmt = $con->prepare('SELECT COUNT(*) AS total FROM ticket WHERE startdate LIKE ? AND pop_id = ?');
                                        $likeDate = "%$daystkt%";
                                        $stmt->bind_param('si', $likeDate, $_GET['id']);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();
                                        echo $row['total'] . ',';
                                    }
                                    ?>
                                ],
                                ["Resolved",
                                    <?php
                                    for ($i = 0; $i < 9; $i++) {
                                        $daystkt = date('Y-m-d', strtotime('-' . $i . ' day'));
                                        $stmt = $con->prepare("SELECT COUNT(*) AS total FROM ticket WHERE startdate LIKE ? AND ticket_type='Complete' AND pop_id = ?");
                                        $likeDate = "%$daystkt%";
                                        $stmt->bind_param('si', $likeDate, $_GET['id']);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();
                                        echo $row['total'] . ',';
                                    }
                                    ?>
                                ],
                                ["Pending",
                                    <?php
                                    for ($i = 0; $i < 9; $i++) {
                                        $daystkt = date('Y-m-d', strtotime('-' . $i . ' day'));
                                        $stmt = $con->prepare("SELECT COUNT(*) AS total FROM ticket WHERE startdate LIKE ? AND ticket_type='Active' AND pop_id = ?");
                                        $likeDate = "%$daystkt%";
                                        $stmt->bind_param('si', $likeDate, $_GET['id']);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();
                                        echo $row['total'] . ',';
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

        $(document).ready(function() {

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
                    url: "include/customer_server_new.php?get_customers_data=true",
                    type: 'GET',
                    data: function(d) {
                        d.status = $('.status_filter').val();
                        // d.pop_id = $('.pop_filter').val();
                        d.pop_id = <?php echo $popid; ?>;
                        d.area_id = $('.area_filter').val();
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
                    url: "include/customer_recharge_server.php?get_recharge_data=true",
                    type: 'GET',
                    data: function(d) {
                        //d.status = $('.status_filter').val();
                        // d.pop_id = $('.pop_filter').val();
                        d.pop_id = <?php echo $popid; ?>;
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
                    url: "include/tickets_server.php?get_tickets_data=1",
                    type: 'GET',
                    data: function(d) {
                        d.area_id = $('.area_filter').val();
                        <?php if (isset($popid)) {
                            echo 'd.pop_id = ' . $popid;
                        } ?>
                    },
                    beforeSend: function() {
                        $(".dataTables_empty").html(
                            '<img src="assets/images/loading.gif" style="background-color: transparent"/>'
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


            //$("#package-list-table").DataTable();

            $("#transaction_datatable").DataTable();
            $("#package_datatable").DataTable();
            $("#recharge_history_datatable").DataTable();


            $("#packageAddBtn").click(function() {
                $("#addPackageModal").modal('show');
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
    </script>

   

</body>

</html>
