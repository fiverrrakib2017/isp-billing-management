<?php
include("include/security_token.php");
include("include/users_right.php");
include "include/db_connect.php";

?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/style.php';

        echo file_get_contents($url);
    ?>

</head>

<body data-sidebar="dark">
    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php 
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $url = $protocol . $_SERVER['HTTP_HOST'] . '/Header.php';

            echo file_get_contents($url);
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
                    <div class="row" id="searchRow">
                        <div class="col-md-6 col-sm m-auto">
                            <div class="card shadow">
                                <div class="card-header bg-dark text-white">Customer Recharge</div>
                                <div class="card-body">
                                    <form action="">
                                        <div class="form-gruop mb-2">
                                            <label>Select Customer</label>

                                            <select type="text" id="recharge_customer" class="form-select select2">
                                                <option value="">---Select---</option>
                                                <?php

											if ($allData = $con->query("SELECT * FROM customers WHERE pop=$auth_usr_POP_id")) {
												while ($rows = $allData->fetch_array()) {
											echo ' <option value="'.$rows['id'].'">['.$rows['id'].'] - '.$rows['username'].' || '.$rows['fullname'].', ('.$rows['mobile'].')</option>';
												}
											}


											?>
                                            </select>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label>Month</label>
                                            <select id="recharge_customer_month" class="form-select">
                                                <option value="">Select</option>
                                                <?php 
                                                for($i=1;$i<=12;$i++){
                                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                                }
                                                
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group ">
                                            <label for="">Package</label>
                                            <select disabled="Disable" id="recharge_customer_package" class="form-select ">

                                            </select>
                                        </div>
                                        <div class="form-group mb-1 ">
                                            <label>Package Price:</label>

                                            <input id="recharge_customer_package_price" disabled="Disable" type="text" class="form-control form-control-sm" value="">
                                        </div>
                                        <div class="form-group mb-1 ">
                                            <label>Ref:</label>

                                            <input id="ref"  type="text" class="form-control form-control-sm" value="">
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

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php 
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
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
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/script.php';

        echo file_get_contents($url);
    ?>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#recharge_customer").select2();

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
                    url:url,
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
                    var protocol = location.protocol;
                    var url = protocol + '//' + '<?php echo $_SERVER['HTTP_HOST']; ?>' + '/include/customer_recharge_server.php';
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
                            add_recharge_data:0
                        },
                        success: function(response) {
                            if (response == 1) {
                                $("#add_recharge_btn").html('Recharge Now');
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

        });
    </script>
</body>

</html>