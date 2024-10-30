<?php
include 'include/security_token.php';
include 'include/db_connect.php';
include 'include/pop_security.php';
include 'include/users_right.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'style.php'; ?>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
</head>

<body data-sidebar="dark">


    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include 'Header.php'; ?>

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
                                            <p class="text-primary mb-0 hover-cursor">Customers</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button data-bs-toggle="modal" data-bs-target="#addCustomerModal"
                                        class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"
                                        id="addBtn" style="margin-bottom: 12px;">&nbsp;&nbsp;New customer</button>



                                </div>

                                <div class="modal fade bs-example-modal-lg" tabindex="-1"
                                    aria-labelledby="myLargeModalLabel" id="addCustomerModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><span
                                                        class="mdi mdi-account-check mdi-18px"></span> &nbsp;New
                                                    customer</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="">
                                                <form id="customer_form">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Full Name</label>
                                                                        <input id="customer_fullname" type="text"
                                                                            class="form-control "
                                                                            placeholder="Enter Your Fullname" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Username <span
                                                                                id="usernameCheck"></span></label>
                                                                        <input id="customer_username" type="text"
                                                                            class="form-control " name="username"
                                                                            placeholder="Enter Your Username"
                                                                            oninput="checkUsername();" />

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Password</label>
                                                                        <input id="customer_password" type="password"
                                                                            class="form-control " name="password"
                                                                            placeholder="Enter Your Password" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Mobile no.</label>
                                                                        <input id="customer_mobile" type="text"
                                                                            class="form-control " name="mobile"
                                                                            placeholder="Enter Your Mobile Number" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Expired Date</label>
                                                                        <select id="customer_expire_date"
                                                                            class="form-select">
                                                                            <option value="<?php echo date('d'); ?>">
                                                                                <?php echo date('d'); ?></option>
                                                                            <?php
                                                                            if ($exp_cstmr = $con->query('SELECT * FROM customer_expires')) {
                                                                                while ($rowsssss = $exp_cstmr->fetch_array()) {
                                                                                    $exp_date = $rowsssss['days'];
                                                                            
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
                                                                        <input id="customer_address" type="text"
                                                                            class="form-control" name="address"
                                                                            placeholder="Enter Your Addres" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group mb-2">
                                                                        <label>POP/Branch</label>
                                                                        <select id="customer_pop" class="form-select">
                                                                            <option value="">Select Pop/Branch
                                                                            </option>
                                                                            <?php
                                                                            if ($pop = $con->query('SELECT * FROM add_pop ')) {
                                                                                while ($rows = $pop->fetch_array()) {
                                                                                    $id = $rows['id'];
                                                                                    $name = $rows['pop'];
                                                                            
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
                                                                        <select id="customer_area" class="form-select"
                                                                            name="area">
                                                                            <option>Select Area</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Nid Card Number</label>
                                                                        <input id="customer_nid" type="text"
                                                                            class="form-control" name="nid"
                                                                            placeholder="Enter Your Nid Number" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Package</label>
                                                                        <select id="customer_package"
                                                                            class="form-select">


                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Connection Charge</label>
                                                                        <input id="customer_con_charge" type="text"
                                                                            class="form-control" name="con_charge"
                                                                            placeholder="Enter Connection Charge"
                                                                            value="500" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Package Price</label>
                                                                        <input disabled id="customer_price"
                                                                            type="text" class="form-control"
                                                                            value="00" />
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
                                                                        <select id="customer_status"
                                                                            class="form-select">
                                                                            <option value="">Select Status
                                                                            </option>
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
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success" id="customer_add">Add
                                                    Customer</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">

                                <div class="card-body">
                                    <div class="table-responsive ">
                                        <table id="customers_table" class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="checkedAll" name="checkedAll"
                                                            class="form-check-input"></th>
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
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="customer-list">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer d-flex flex-wrap justify-content-between align-items-center">
                                    <button class="btn btn-primary mb-2" id="send_message_btn">
                                        <i class="far fa-envelope"></i>&nbsp;Send Message
                                    </button>

                                    <button type="button" class="btn btn-success mb-2" name="export_to_excel">
                                        <img src="https://img.icons8.com/?size=100&id=117561&format=png&color=000000"
                                            class="img-fluid icon-img" style="height: 20px !important;">
                                        Export To Excel
                                    </button>

                                    <button type="button" onclick="printSelectedRows()" class="btn btn-danger mb-2">
                                        <i class="fas fa-print"></i>&nbsp;Print
                                    </button>

                                    <button type="button" class="btn btn-info mb-2" name="recharge_btn">
                                        <i class="mdi mdi-battery-charging-20"></i>&nbsp;Recharge
                                    </button>

                                    <button type="button" class="btn btn-danger mb-2" name="">
                                        <i class="mdi mdi-cash-multiple"></i>&nbsp;Cash Received
                                    </button>

                                    <button type="button" class="btn btn-success mb-2" name="import_excel">
                                        <img src="https://img.icons8.com/?size=100&id=117561&format=png&color=000000"
                                            class="img-fluid icon-img" style="height: 20px !important;">
                                        Import Excel File
                                    </button>

                                    <button type="button" class="btn btn-info mb-2" name="Recharge_btn">
                                        <i class="mdi mdi-ticket"></i>&nbsp;Add Ticket
                                    </button>

                                    <button type="button" class="btn btn-success mb-2" name="Recharge_btn">
                                        <i class="fas fa-angle-double-right"></i>&nbsp;Change POP/Branch
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?php include 'Footer.php'; ?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Modal for Send Message -->
    <div class="modal fade bs-example-modal-lg" id="sendMessageModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content col-md-12">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span
                            class="mdi mdi-account-check mdi-18px"></span> &nbsp;Send Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info" id="selectedCustomerCount"></div>
                    <form id="paymentForm" method="POST">

                        <div class="form-group mb-2">
                            <label>Message Template</label>
                            <select class="form-select" name="message_template">
                                <option>---Select---</option>
                                <?php
                                if ($allCstmr = $con->query('SELECT * FROM message_template WHERE user_type=1')) {
                                    while ($rows = $allCstmr->fetch_array()) {
                                        echo '<option value=' . $rows['id'] . '>' . $rows['template_name'] . '</option>';
                                    }
                                }
                                
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Message</label>
                            <textarea id="message" rows="5" placeholder="Enter Your Message" class="form-control"></textarea>
                        </div>
                        <div class="modal-footer ">
                            <button data-bs-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                            <button type="button" name="send_message_btn" class="btn btn-success">Send
                                Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Recharge -->
    <div class="modal fade" id="rechargeModal" tabindex="-1" role="dialog" aria-labelledby="ComplainModalCenterTitle" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">
                           Recharge 
                        </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="alert alert-info" id="selectedCustomerCount"></div>
                <form id="recharge-form" method="POST">
                    <div id="holders">
                        <div class="form-group mb-1">
                            <label>Month</label>
                            <select id="month" class="form-select" name='month'>
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
                    </div>
                    <div class="form-group mb-1 ">
                        <label>Ref No.:</label>
                        <input id="RefNo" type="text" class="form-control" name="RefNo" placeholder="Enter Ref No"/>
                    </div>
                    <div class="form-group mb-1">
                        <label>Transaction Type:</label>
                        <select id="tra_type" name="tra_type" class="form-select">
                            <option>---Select---</option>
                            <option value="1">Cash</option>
                            <option value="0">On Credit</option>
                            <option value="2">Bkash</option>
                            <option value="3">Nagad</option>
                            <option value="4">Due Payment</option>
                        </select>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button  type="button" name="recharge_submit_btn" class="btn btn-success">Recharge Now</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <?php include 'script.php'; ?>
    <script type="text/javascript">
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
                    getCustomerPackage: 0
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
                    getPackagePrice: 0
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

            customerAdd(user_type, fullname, package, username, password, mobile, address, expire_date, area, pop,
                con_charge, price, remarks, nid, status)

        });

        function customerAdd(user_type, fullname, package, username, password, mobile, address, expire_date, area, pop,
            con_charge, price, remarks, nid, status) {
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
                $("#customer_add").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
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


    <script type="text/javascript">
        var table;
        $(document).ready(function() {

            loadPopOptions();
            loadAreaOptions();

            function loadPopOptions() {
                $.ajax({
                    url: 'include/pop_server.php?get_pop_data=1',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success == true) {
                            var popOptions = '<label style="margin-left: 10px;"> ';
                            popOptions += '<select class="pop_filter">';
                            popOptions += '<option value="">--Select POP--</option>';


                            $.each(response.data, function(key, data) {
                                popOptions += '<option value="' + data.id + '">' + data.pop +
                                    '</option>';
                            });

                            popOptions += '</select></label>';

                            setTimeout(() => {
                                $('.dataTables_length').append(popOptions);
                                $('.pop_filter').select2();
                            }, 500);
                        }

                    }
                });
            }

            function loadAreaOptions() {
                $.ajax({
                    url: 'include/area_server.php?get_area_data=1',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success == true) {
                            var popOptions = '<label style="margin-left: 10px;"> ';
                            popOptions += '<select class="area_filter form-select">';
                            popOptions += '<option value="">--Select Area--</option>';


                            $.each(response.data, function(key, data) {
                                popOptions += '<option value="' + data.id + '">' + data.name +
                                    '</option>';
                            });

                            popOptions += '</select></label>';

                            setTimeout(() => {
                                $('.dataTables_length').append(popOptions);
                                $('.area_filter').select2();
                            }, 1000);

                            var status_filter = '<label style="margin-left: 10px;"> ';
                            status_filter += '<select class="status_filter form-select">';
                            status_filter += '<option value="">--Status--</option>';
                            status_filter += '<option value="online" >Online</option>';
                            status_filter += '<option value="offline">Offline</option>';
                            status_filter += '<option value="expired">Expired</option>';
                            status_filter += ' <option value="unpaid">Unpaid</option>';
                            status_filter += ' <option value="due">Due</option>';
                            status_filter += ' <option value="free">Free</option>';
                            status_filter += ' <option value="active">Active</option>';
                            status_filter += ' <option value="disabled">Disabled</option>';
                            status_filter += '</select></label>';

                            setTimeout(() => {
                                $('.dataTables_length').parent().removeClass(
                                    'col-sm-12 col-md-6');
                                $('.dataTables_filter').parent().removeClass(
                                    'col-sm-12 col-md-6');
                                $('.dataTables_length').append(status_filter);
                                $('.status_filter').select2();
                            }, 1000);
                        }

                    }
                });
            }
            $(document).on('change', '.pop_filter', function() {
                var pop_id = $(this).val();
                $.ajax({
                    url: 'include/area_server.php?get_area_data=1&pop_id=' + pop_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success == true) {
                            var areaOptions = '<option value="">--Select Area--</option>';
                            $.each(response.data, function(key, data) {
                                areaOptions += '<option value="' + data.id + '">' + data
                                    .name + '</option>';
                            });
                            setTimeout(() => {
                                $('.area_filter').html(areaOptions);
                                $('.area_filter').select2();
                            }, 500);
                        }
                    }
                });
            });
            var checkedBoxes = {};
            table = $('#customers_table').DataTable({
                "searching": true,
                "paging": true,
                "info": true,
                "order": [
                    [0, "desc"]
                ],
                "lengthChange": true,
                "processing": true,
                "serverSide": true,
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 10,
                }],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All']
                ],
                select: {
                    style: 'os',
                    selector: 'td.select-checkbox'
                },
                "zeroRecords": "No matching records found",
                "ajax": {
                    url: "include/customer_server_new.php?get_customers_data=true",
                    type: 'GET',
                    data: function(d) {
                        d.status = $('.status_filter').val();
                    },
                },
                "drawCallback": function() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                    /* Restore checked state*/
                    $('.customer-checkbox').each(function() {
                        var id = $(this).val();
                        if (checkedBoxes[id]) {
                            $(this).prop('checked', true);
                        }
                    });
                },
                "buttons": [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        titleAttr: 'Export to Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        titleAttr: 'Print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ],
            });
            table.buttons().container().appendTo($('#export_buttonscc'));
            /* Check/Uncheck All Checkboxes*/
            $(document).on('change', '#checkedAll', function() {
                var isChecked = $(this).is(':checked');
                $('.customer-checkbox').prop('checked', isChecked);
                $('.customer-checkbox').each(function() {
                    var id = $(this).val();
                    checkedBoxes[id] = isChecked;
                });
            });

            /* Handle Individual Checkbox Change*/
            $(document).on('cilck', '.customer-checkbox', function() {
                var id = $(this).val();
                checkedBoxes[id] = $(this).is(':checked');

                var allChecked = $('.customer-checkbox:checked').length === $('.customer-checkbox').length;
                $('#checkedAll').prop('checked', allChecked);
            });
        });

        /* POP filter change event*/
        $(document).on('change', '.pop_filter', function() {

            var pop_filter_result = $('.pop_filter').val() == null ? '' : $('.pop_filter').val();

            table.columns(9).search(pop_filter_result).draw();

        });
        /* Area change event*/
        $(document).on('change', '.area_filter', function() {

            var area_filter_result = $('.area_filter').val() == null ? '' : $('.area_filter').val();

            table.columns(10).search(area_filter_result).draw();

        });
        /* Area change event*/
        $(document).on('change', '.status_filter', function() {
            var status_filter_result = $('.status_filter').val() == null ? '' : $('.status_filter').val();
            table.ajax.reload(null, false);
        });
        $(document).on('click', 'button[name="export_to_excel"]', function() {
            let csvContent = "data:text/csv;charset=utf-8,";

            /* Add header row */
            csvContent += [
                '', 'ID', 'Name', 'Package', 'Amount', 'Expired Date', 'Expired Date', 'Username', 'Mobile no.',
                'POP/Branch', 'Area/Location'
            ].join(",") + "\n";



            /* Add selected data rows */
            $('#customers_table tbody tr').each(function() {
                let row = [];
                $(this).find('td').each(function() {
                    row.push($(this).text().trim());
                });
                csvContent += row.join(",") + "\n";
            });


            /* Create a link element and simulate click to download the CSV file */
            let encodedUri = encodeURI(csvContent);
            let link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "customers.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });


        function printTable() {
            var divToPrint = document.getElementById('customers_table');
            var newWin = window.open('', '_blank');
            newWin.document.write('<html><head><title>Customer</title>');
            newWin.document.write('<style>');
            newWin.document.write('table { width: 100%; border-collapse: collapse; }');
            newWin.document.write('table, th, td { border: 1px solid black; padding: 10px; text-align: left; }');
            newWin.document.write('a { text-decoration: none; color: black; }');
            newWin.document.write('</style></head><body>');
            newWin.document.write(divToPrint.outerHTML);
            newWin.document.write('</body></html>');
            newWin.document.close();
            newWin.focus();
            newWin.print();
            newWin.close();
        }

        function printSelectedRows() {
            let selectedContent = `
                <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th></th>
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
                        </tr>
                    </thead>
                    <tbody>
            `;

            let hasSelectedRows = false;

            $('#customers_table tbody tr').each(function() {
                let checkbox = $(this).find('input[type="checkbox"]');
                if (checkbox.is(':checked')) {
                    hasSelectedRows = true;
                    selectedContent += "<tr>";
                    $(this).find('td').each(function() {
                        selectedContent += `<td>${$(this).text().trim()}</td>`;
                    });
                    selectedContent += "</tr>";
                }
            });

            if (!hasSelectedRows) {
                toastr.error("Please select at least one row to print.");
                return;
            }

            selectedContent += `
                    </tbody>
                </table>
            `;


            let newWin = window.open('', '_blank');
            newWin.document.write('<html><head><title>Customer Data</title>');
            newWin.document.write('<style>');
            newWin.document.write('table { width: 100%; border-collapse: collapse; }');
            newWin.document.write('table, th, td { border: 1px solid black; padding: 10px; text-align: left; }');
            newWin.document.write('</style></head><body>');
            newWin.document.write(selectedContent);
            newWin.document.write('</body></html>');
            newWin.document.close();
            newWin.focus();
            newWin.print();
            newWin.close();
        }
        $(document).on('click', '#send_message_btn', function(event) {
            event.preventDefault();
            var selectedCustomers = [];
            $(".checkSingle:checked").each(function() {
                selectedCustomers.push($(this).val());
            });
            var countText = "You have selected " + selectedCustomers.length + " customers.";
            $("#selectedCustomerCount").text(countText);
            $('#sendMessageModal').modal('show');

        });
        $(document).on('click', 'button[name="send_message_btn"]', function(e) {
            var selectedCustomers = [];
            $(".checkSingle:checked").each(function() {
                selectedCustomers.push($(this).val());
            });

            e.preventDefault();
            $.ajax({
                url: 'include/message_server.php?bulk_message=true',
                method: 'POST',
                dataType: 'json',
                data: {
                    /*sending the array of customer IDs*/
                    customer_ids: selectedCustomers,
                    message: $("#message").val(),
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#sendMessageModal').modal('hide');
                        $('#customers_table').DataTable().ajax.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
                    alert("There was an error sending the message.");
                }
            });
        });
        $('select[name="message_template"]').on('change', function() {
            var name = $(this).val();
            var currentMsgTemp = "0";
            $.ajax({
                type: 'POST',
                data: {
                    name: name,
                    currentMsgTemp: currentMsgTemp
                },
                url: 'include/message.php',
                success: function(response) {
                    $("#message").val(response);
                }
            });
        });
        $(document).on('click','button[name="recharge_btn"]',function(e){
            event.preventDefault();
            var selectedCustomers = [];
            $(".checkSingle:checked").each(function() {
                selectedCustomers.push($(this).val());
            });
            if (selectedCustomers.length==0) {
                toastr.error("Please select at least one customer to recharge.");
                return false;
            }
            var countText = "You have selected " + selectedCustomers.length + " customers.";
            $("#rechargeModal #selectedCustomerCount").text(countText);
            $('#rechargeModal').modal('show');
        });
        $(document).on('click','button[name="recharge_submit_btn"]',function(e){
            event.preventDefault();
            var selectedCustomers = [];
            $(".checkSingle:checked").each(function() {
                selectedCustomers.push($(this).val());
            });
            var data = $('#recharge-form').serialize() + '&selectedCustomers=' + JSON.stringify(selectedCustomers);
            $.ajax({
                url: 'include/customer_recharge_server.php?add_customer_recharge=true',
                method: 'POST',
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#rechargeModal').modal('hide');
                        $('#customers_table').DataTable().ajax.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
                    alert("There was an error sending the message.");
                }
            });
        });
    </script>
</body>

</html>
