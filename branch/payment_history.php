<?php
if (!isset($_SESSION)) {
    session_start();
}
$rootPath = $_SERVER['DOCUMENT_ROOT'];  

$db_connect_path = $rootPath . '/include/db_connect.php';  
$users_right_path = $rootPath . '/include/users_right.php';

if (file_exists($db_connect_path)) {
    require($db_connect_path);
}

if (file_exists($users_right_path)) {
    require($users_right_path);
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

            <?php 
                $page_title="Working Group";
                include '../Header.php';
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
                        <div class="col-md-12 grid-margin">
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="d-flex align-items-end flex-wrap">
                                    <div class="mr-md-3 mr-xl-5">
                                        <div class="d-flex">
                                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                                            </p>
                                            <p class="text-primary mb-0 hover-cursor">Customers Payment</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <span class="card-title"></span>
                                    <div class="col-md-6 float-md-right grid-margin-sm-0">
                                        <div class="form-group">


                                        </div>
                                    </div>
                                    <div class="table-responsive">
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

   

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <!-- JAVASCRIPT -->
    <?php
        
        $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/script.php';
        
        echo file_get_contents($url);
        
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#transaction_datatable").DataTable();
        });
        //  $(document).ready(function(){
        //      $("#area_table").DataTable();
        //      $("#area-list").load("include/add_area.php?list");
        //      $.ajax({
        //          type: "GET",
        //          url: "include/add_area.php?list",
        //          cache: false,
        //          success: function(areaList) {
        //              $("#area-list").html(areaList);
        //          }
        //      });
        // $("#add_area").click(function(){
        //    var formData=$("#form-area").serialize();
        //       $.ajax({
        //       type:"GET",
        //       data:formData,
        //       url:"include/add_area.php?add",
        //       cache:false,
        //       success: function() {
        //              Swal.fire(
        //                    'Success!',
        //                    'Data Insert Success!',
        //                    'success'
        //                      )
        //                $("#area-list").load("include/add_area.php?list");
        //              }
        //    });
        // });
        //  });   
    </script>
</body>

</html>