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
    <script src="./assets/libs/jquery/jquery.min.js"></script>

</head>

<body data-sidebar="dark">


    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php $page_title = 'Customers test';
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
                                            <p class="text-primary mb-0 hover-cursor">
                                                &nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                                            </p>
                                            <p class="text-primary mb-0 hover-cursor">Customers</p>
                                            <?php if($_GET['new_customer_month']):?>
                                            <p class="text-primary mb-0 hover-cursor">/&nbsp;New Customers</p>
                                            <?php endif; ?>
                                            <?php if($_GET['expire_customer_month']):?>
                                            <p class="text-primary mb-0 hover-cursor">/&nbsp; Monthly Expired Customers
                                            </p>
                                            <?php endif; ?>
                                            <?php if($_GET['online']):?>
                                            <p class="text-primary mb-0 hover-cursor">/&nbsp;Online Customers</p>
                                            <?php endif; ?>
                                            <?php if($_GET['offline']):?>
                                            <p class="text-primary mb-0 hover-cursor">/&nbsp;Offline Customers</p>
                                            <?php endif; ?>
                                            <?php if($_GET['active']):?>
                                            <p class="text-primary mb-0 hover-cursor">/&nbsp;Active Customers</p>
                                            <?php endif; ?>
                                            <?php if($_GET['expired']):?>
                                            <p class="text-primary mb-0 hover-cursor">/&nbsp;Expired Customers</p>
                                            <?php endif; ?>
                                            <?php if($_GET['disabled']):?>
                                            <p class="text-primary mb-0 hover-cursor">/&nbsp;Disabled Customers</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button data-bs-toggle="modal" data-bs-target="#addCustomerModal"
                                        class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"
                                        id="addBtn" style="margin-bottom: 12px;">&nbsp;&nbsp;New customer
                                    </button>
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

<div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" id="addCustomerModal"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span class="mdi mdi-account-check mdi-18px"></span>
                    &nbsp;New  
                    customer</h5>
                    
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="">
            <form id="form-horizontal" class="form-horizontal form-wizard-wrapper">
                <h3>Basic Information</h3>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="" class="col-lg-3 col-form-label">Full Name</label>
                                <div class="col-lg-9">
                                    <input id="customer_request_id" type="text" class="d-none"/>
                                    <input id="customer_fullname" type="text" class="form-control "
                                        placeholder="Enter Your Fullname" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Mobile No.</label>
                                <div class="col-lg-9">
                                    <input id="customer_mobile" type="text" class="form-control " name="mobile" placeholder="Enter Your Mobile Number" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="txtCompanyBilling" class="col-lg-3 col-form-label">Address.</label>
                                <div class="col-lg-9">
                                    <input id="customer_address" type="text" class="form-control" name="address" placeholder="Enter Your Addres" />

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="txtEmailAddressBilling" class="col-lg-3 col-form-label">Nid Card Number</label>
                                <div class="col-lg-9">
                                    <input id="customer_nid" type="text" class="form-control" name="nid" placeholder="Enter Your Nid Number" />
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <h3>POP/Area</h3>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="txtFirstNameShipping" class="col-lg-3 col-form-label">POP/Branch</label>
                                <div class="col-lg-9">
                                    <select id="customer_pop" class="form-select" style="width: 100%;">
                                        <option value="">Select Pop/Branch
                                        </option>
                                        <?php
                                        $condition = "";
                                        if (isset($pop_id)) {
                                            $pop_id = intval($pop_id); 
                                            $condition = "WHERE id=$pop_id";
                                        }
                                        
                                        $query = "SELECT * FROM add_pop $condition";
                                        if ($pop = $con->query($query)) { 
                                            while ($rows = $pop->fetch_array()) {
                                                $id = htmlspecialchars($rows['id']);
                                                $name = htmlspecialchars($rows['pop']);
                                        
                                                echo '<option value="' . $id . '">' . $name . '</option>';
                                            }
                                        } else {
                                            echo "Error: " . $con->error; 
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="txtLastNameShipping" class="col-lg-3 col-form-label">Area/Location</label>
                                <div class="col-lg-9">
                                    <select id="customer_area" class="form-select" name="area" style="width: 100%;">
                                        <option>Select Area</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="txtCompanyShipping" class="col-lg-3 col-form-label">House No.</label>
                                <div class="col-lg-9">
                                  <div class="d-flex">
                                    <select id="customer_houseno" class="form-select" name="customer_houseno" style="width: 100%;">
                                            <option value="0">---Select---</option>
                                        </select>
                                        <button type="button" class="btn btn-primary add-house-btn" data-bs-toggle="modal" data-bs-target="#addHouseModal">
                                            <span>+</span>
                                        </button>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <h3>Subscription</h3>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="txtNameCard" class="col-lg-3 col-form-label">Username <span id="usernameCheck"></span></label>
                                <div class="col-lg-9">
                                    <input id="customer_username" type="text" class="form-control "
                                        name="username" placeholder="Enter Your Username"
                                         />

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="ddlCreditCardType" class="col-lg-3 col-form-label">Password</label>
                                <div class="col-lg-9">
                                <input id="customer_password" type="password" class="form-control "
                                name="password" placeholder="Enter Your Password" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="txtCreditCardNumber" class="col-lg-3 col-form-label">Package</label>
                                <div class="col-lg-9">
                                    <select id="customer_package" class="form-select" style="width: 100%;"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="txtCardVerificationNumber" class="col-lg-3 col-form-label">Package Price</label>
                                <div class="col-lg-9">
                                    <input  id="customer_price" type="text" class="form-control"
                                        value="00" />

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="txtExpirationDate" class="col-lg-3 col-form-label">Connection Charge</label>
                                <div class="col-lg-9">
                                    <input id="customer_con_charge" type="text" class="form-control"
                                    name="con_charge" placeholder="Enter Connection Charge" value="500" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="txtExpirationDate" class="col-lg-3 col-form-label">Expired Date</label>
                                <div class="col-lg-9">
                                    <select id="customer_expire_date" class="form-select">
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
                        </div>
                    </div>
                </fieldset>
                <h3>Additional</h3>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="txtNameCard" class="col-lg-3 col-form-label">Remarks</label>
                                <div class="col-lg-9">
                                    <textarea id="customer_remarks" type="text" class="form-control" placeholder="Enter Remarks"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="ddlCreditCardType" class="col-lg-3 col-form-label">Status</label>
                                <div class="col-lg-9">
                                    <select id="customer_status" class="form-select" style="width: 100%;">
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="txtCreditCardNumber" class="col-lg-3 col-form-label">Liablities</label>
                                <div class="col-lg-9">
                                    <select id="customer_liablities" class="form-select" style="width: 100%;">
                                        <option value="">---Select---</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="txtCreditCardNumber" class="col-lg-3 col-form-label">Connection Type</label>
                                <div class="col-lg-9">
                                    <select id="customer_connection_type" class="form-select" style="width: 100%;">
                                        <option value="">---Select---</option>
                                        <option value="UTP">UTP</option>
                                        <option value="ONU">ONU</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="liability_device_table" class="mt-3" style="display: none;">
                                <h6>Device Information</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="device_table">
                                        <thead>
                                            <tr>
                                                <th>Device Type</th>
                                                <th>Name</th>
                                                <th>Serial No</th>
                                                <th>Assign Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select class="form-select" name="device_type[]" style="width: 100%;">
                                                        <option >---Select---</option>
                                                        <option value="router">Router</option>
                                                        <option value="onu">Onu</option>
                                                        <option value="fiber">Fiber</option>
                                                        <option value="other">Others</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" class="form-control" placeholder="Enter Device Name" name="device_name[]"></td>
                                                <td><input type="text" class="form-control" placeholder="Example: K5453110" name="serial_no[]"></td>
                                                <td><input type="date" class="form-control" name="assign_date[]"></td>
                                                <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm" id="add_row">+ Add Row</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="sendMessageCheckbox" class="col-lg-1 col-form-label">
                                <input type="checkbox" id="sendMessageCheckbox" name="send_message" value="1" class="form-check-input">
                                  </label>
                                </label>
                                <div class="col-lg-9 d-flex align-items-center">
                                 Send this message to the Customer
                                  
                                </div>
                            </div>
                        </div>
                    </div>

                </fieldset>
            </form>
            </div>
            <div class="modal-footer mt-2">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="customer_add">Add
                    Customer</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<!-- Add House Modal  -->
<div class="modal fade" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addHouseModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Area</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="form-area">
                                <div class="form-group mb-1">
                                    <label>Area</label>
                                    <select class="form-select" name="area_id" id="area_id" style="width: 100%;">
                                        <option value="">Select</option>
                                        <?php
                                        if ($pop = $con->query("SELECT * FROM area_list")) {
                                            while ($rows = $pop->fetch_array()) {
                                                $id = $rows['id'];
                                                $name = $rows['name'];
                                                echo '<option value="' . $id . '">' . $name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group mb-1">
                                    <label>House/Building No.</label>
                                    <input class="form-control" type="text" name="house_no" id="house_no" placeholder="Type  House-Building No." />
                                  
                                </div>
                                <div class="form-group mb-1">
                                    <label>Note</label>
                                    <input class="form-control" type="text" name="note" id="note" placeholder="Type Your Note" />
                                </div>
                                <div class="d-none">
                                    <input type="hidden" id="lat" name="lat">
                                    <input type="hidden" id="lng" name="lng">
                                </div>
                                <div class="form-group mb-1">
                                    <label>Map Location</label>
                                    <div id="show_map" style="width: 100%; height: 300px;"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="add_area" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Customer Details Show Modal -->
<div class="modal fade" id="customer_details_show_modal" tabindex="-1" aria-labelledby="customerDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header ">
                <h5 class="modal-title" id="customerDetailsModalLabel">Customer Details</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Details Section -->
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div id="customer-details" class="row gx-3 gy-2">
                            <div class="col-12">
                                <p><strong>Full Name:</strong> <span id="details-name" class="text-muted"></span></p>
                            </div>
                            <div class="col-12">
                                <p><strong>Username:</strong> <span id="details-username" class="text-muted"></span></p>
                            </div>
                            <div class="col-12">
                                <p><strong>Mobile:</strong> <span id="details-mobile" class="text-muted"></span></p>
                            </div>
                            <div class="col-12">
                                <p><strong>Address:</strong> <span id="details-address" class="text-muted"></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-center mt-3">
                        <button  class="btn btn-success me-2" onclick="copyDetails()">
                            <i class="fas fa-clipboard"></i> Copy Information
                        </button>
                        <button  class="btn btn-warning">
                            <i class="fas fa-chat"></i> Send Message
                        </button>
                        <a  class="btn btn-primary go_to_profile">
                            <i class="mdi mdi-account"></i> View Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    #details-section {
        max-width: 600px;
        margin: 0 auto;
        background: #f8f9fa;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    #details-section .card-body {
        position: relative;
    }

    #customer-details p {
        font-size: 14px;
        color: #333;
        border-bottom: 2px dotted #ccc;
        padding-bottom: 5px;
        margin-bottom: 10px;
    }

    #customer-details p span {
        font-weight: bold;
        color: #007bff;
    }
    .wizard>.content{
        padding: 12px !important;
    }

    .content.clearfix {
        border: 2px dotted #a6a6a9 !important;
        margin-top: 12px !important;
        margin-bottom: 15px !important;
    }


    </style>

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <?php include 'script.php'; ?>
     <script type="text/javascript">
        var table;
       
        $(document).ready(function() {
            //$("#customer_details_show_modal").modal('show');
            var get_pop_id = "<?php echo isset($_GET['pop_id']) ? $_GET['pop_id'] : ''; ?>";
            var get_area_id = "<?php echo isset($_GET['area_id']) ? $_GET['area_id'] : ''; ?>";

            if (get_pop_id.length > 0 || get_area_id.length > 0) {

            } else {
                loadPopOptions();
                loadAreaOptions();
            }



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

                        /********************Filter For Active Customer*******************************/
                        <?php if (isset($_GET['active']) && !empty($_GET['active'])): ?>
                        d.status = <?php echo $_GET['active']; ?>;
                        $("#customers_table_length").hide();
                        <?php else: ?>
                        d.status = $('.status_filter').val();
                        <?php endif; ?>

                        /********************Filter For POP ID Customer*******************************/
                        <?php if (isset($_GET['pop_id']) && !empty($_GET['pop_id'])): ?>
                        d.pop_id = <?php echo $_GET['pop_id']; ?>;
                        <?php else: ?>
                        d.pop_id = $('.pop_filter').val();
                        <?php endif; ?>
                        /********************Filter For AREA ID Customer*******************************/
                        <?php if (isset($_GET['area_id']) && !empty($_GET['area_id'])): ?>
                        d.area_id = <?php echo $_GET['area_id']; ?>;
                        <?php else: ?>
                        d.area_id = $('.area_filter').val();
                        <?php endif; ?>
                        /********************Filter For Online Customer*******************************/
                        <?php if (isset($_GET['online']) && !empty($_GET['online'])): ?>
                        d.status = "online";
                        //$("#customers_table_length").hide();
                        <?php else: ?>
                        //d.status = $('.status_filter').val();
                        <?php endif; ?>
                        /********************Filter For Online Customer*******************************/
                        <?php if (isset($_GET['offline']) && !empty($_GET['offline'])): ?>
                        d.status = "offline";
                        //$("#customers_table_length").hide();
                        <?php else: ?>
                        //d.status = $('.status_filter').val();
                        <?php endif; ?>
                        /********************Filter For expired Customer*******************************/
                        <?php if (isset($_GET['expired']) && !empty($_GET['expired'])): ?>
                        d.status = "expired";
                        //$("#customers_table_length").hide();
                        <?php else: ?>
                        //d.status = $('.status_filter').val();
                        <?php endif; ?>
                        /********************Filter For Disabled Customer*******************************/
                        <?php if (isset($_GET['disabled']) && !empty($_GET['disabled'])): ?>
                        d.status = "disabled";
                        //$("#customers_table_length").hide();
                        <?php else: ?>
                        //d.status = $('.status_filter').val();
                        <?php endif; ?>

                        /********************Filter Monthly Expire Customer*******************************/
                        <?php if (isset($_GET['expire_customer_month']) && !empty($_GET['expire_customer_month'])): ?>
                        let expire_customer_month = "<?php echo $_GET['expire_customer_month']; ?>";
                        d.expire_customer_month = expire_customer_month;
                       // $("#customers_table_length").hide();
                        <?php endif; ?>

                        /********************Filter Monthly New Customer*******************************/
                        <?php if (isset($_GET['new_customer_month']) && !empty($_GET['new_customer_month'])): ?>
                        let new_customer_month = "<?php echo $_GET['new_customer_month']; ?>";
                        d.new_customer_month = new_customer_month;
                        //$("#customers_table_length").hide();
                        <?php endif; ?>

                    },
                    beforeSend: function() {
                        $(".dataTables_empty").html(
                            '<img src="assets/images/loading.gif" style="background-color: transparent"/>'
                            );
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
        });
         $(document).on('change', '#customer_liablities', function() {
            if ($(this).val() === '1') {
                $('#liability_device_table').show();
            } else {
                $('#liability_device_table').hide();
            }
        });
        /* Add new row For Include Device*/
        $(document).on('click', '#add_row', function() {
            var newRow = `
                <tr>
                    <td>
                        <select class="form-select" name="device_type[]" style="width: 100%;">
                            <option >---Select---</option>
                            <option value="router">Router</option>
                            <option value="onu">Onu</option>
                            <option value="fiber">Fiber</option>
                            <option value="other">Others</option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" placeholder="Enter Device Name" name="device_name[]"></td>
                    <td><input type="text" class="form-control" placeholder="Example: K5453110" name="serial_no[]"></td>
                    <td><input type="date" class="form-control" name="assign_date[]"></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                </tr>
            `;
            $('#device_table tbody').append(newRow);
        });

    // Remove row
    $(document).on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
    });
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
        $(document).on('change', '#customer_area', function() {
            var area_id = $("#customer_area").val();
            $.ajax({
                type: 'POST',
                url: "include/customers_server.php",
                dataType: 'json',
                data: {
                    area_id: area_id,
                    get_billing_cycle: 1
                },
                success: function(response) {
                    if (response.length > 0) {
                        var options = "";
                        response.forEach(function (item) {
                            options += '<option value="' + item + '">' + item + '</option>';
                        });
                        $("#customer_expire_date").html(options);
                    } else {
                        console.log("No data received.");
                    }
                },
                error: function() {
                    console.error("An error occurred while fetching billing cycle.");
                }
            });
        });


        $("#customer_add").click(function() {
            var customer_request_id = $("#customer_request_id").val();
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
            var liablities = $("#customer_liablities").val();
            var customer_houseno = $("#customer_houseno").val();
            var customer_connection_type = $("#customer_connection_type").val();
            var customer_onu_type = $("#customer_onu_type").val();
            var send_message = $('#sendMessageCheckbox').is(':checked') ? $('#sendMessageCheckbox').val() : '0';
            var user_type = 1;

            /* Device data arrays*/
            var device_types = $("select[name='device_type[]']").map(function() {
                return $(this).val();
            }).get();

            var device_names = $("input[name='device_name[]']").map(function() {
                return $(this).val();
            }).get();

            var serial_nos = $("input[name='serial_no[]']").map(function() {
                return $(this).val();
            }).get();

            var assign_dates = $("input[name='assign_date[]']").map(function() {
                return $(this).val();
            }).get();

        customerAdd(customer_request_id,user_type, fullname, package, username, password, mobile, address, expire_date, area, customer_houseno, pop,con_charge, price, remarks,liablities, nid, status,customer_connection_type,customer_onu_type,send_message,device_types, device_names, serial_nos, assign_dates);

        });

        function customerAdd(customer_request_id,user_type, fullname, package, username, password, mobile, address, expire_date, area, customer_houseno, pop,con_charge, price, remarks,liablities, nid, status,customer_connection_type,customer_onu_type,send_message,device_types, device_names, serial_nos, assign_dates) {
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
            }else if (con_charge.length == 0) {
                toastr.error("Connection Charge is require");
            } else if (price.length == 0) {
                toastr.error("price is require");
            } else if (status.length == 0) {
                toastr.error("Status is require");
            } else if (liablities.length == 0) {
                toastr.error("Liablities is require");
            }else if(customer_connection_type.length==0){
                toastr.error("Connection Type is require");
            } else {
                $("#customer_add").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                $("#customer_add").prop("disabled", true);
                var addCustomerData = 0;
                $.ajax({
                    type: 'POST',
                    url: 'include/customers_server.php',
                    data: {
                        addCustomerData: addCustomerData,
                        customer_request_id:customer_request_id,
                        fullname: fullname,
                        package: package,
                        username: username,
                        password: password,
                        mobile: mobile,
                        address: address,
                        expire_date: expire_date,
                        area: area,
                        customer_houseno: customer_houseno,
                        pop: pop,
                        con_charge: con_charge,
                        price: price,
                        remarks: remarks,
                        liablities: liablities,
                        nid: nid,
                        status: status,
                        user_type: user_type,
                        customer_connection_type:customer_connection_type,
                        onu_type:customer_onu_type,
                        send_message:send_message,
                        device_types: device_types,
                        device_names: device_names,
                        serial_nos: serial_nos,
                        assign_dates: assign_dates
                    },
                    success: function(responseData) {
                        $("#customer_add").html('Add Customer');
                        $("#customer_add").prop("disabled", false);
                        if (responseData == 1) {
                            toastr.success("Added Successfully");
                            /*GET Last id With callback function */
                                get_customer_last_id(function(last_id) {
                                //$('#customers_table').DataTable().ajax.reload();
                                $("#addCustomerModal").modal('hide');
                                $("#customer_details_show_modal").modal('show');
                                $("#details-name").html(fullname);
                                $("#details-username").html(username);
                                $("#details-mobile").html(mobile);
                                $("#details-address").html(address);
                                $(".go_to_profile").attr("href", "profile.php?clid=" + last_id);
                            });
                        } else {
                            toastr.error(responseData);
                            $("#customer_add").html('Add Customer');
                            $("#customer_add").prop("disabled", false);
                        }
                    }
                });
            }
        }
        function get_customer_last_id(callback) {
            $.ajax({
                type: 'POST',
                url: "include/customers_server.php",
                data: {
                    get_customer_last_id: 1
                },
                success: function(response) {
                    /*Response Customer Callback function*/
                    callback(response); 
                }
            });
        }

        function copyDetails() {
            let customerDetails = "";

            /* Collect customer details*/
            $('#customer-details p').each(function() {
                customerDetails += $(this).text() + "\n";
            });

            if (navigator.clipboard) {
                navigator.clipboard.writeText(customerDetails)
                    .then(() => {
                        toastr.success("Copied the details:\n" + customerDetails); 
                    })
                    .catch(err => {
                        console.error("Failed to copy details: ", err);
                        toastr.error("Failed to copy details!"); 
                    });
            } else {
                let tempInput = $("<textarea>");
                $("body").append(tempInput);
                tempInput.val(customerDetails).select();

                /*Focus before copying for older browsers*/ 
                tempInput[0].focus();
                
                /* Use execCommand to copy text*/
                if (document.execCommand("copy")) {
                    toastr.success("Copied the details"); 
                } else {
                    toastr.error("Failed to copy details!"); 
                }

                tempInput.remove();
            }

            return false; 
        }



        function copyDetailsssss() {

            let customerDetails = "";

            $('#customer-details p').each(function() {
                customerDetails += $(this).text() + "\n";
            });

            if (navigator.clipboard) {
                navigator.clipboard.writeText(customerDetails)
                    .then(() => {
                        toastr.success("Copied the details:\n" + customerDetails); 
                    })
                    .catch(err => {
                        console.error("Failed to copy details: ", err);
                        alert("Failed to copy details!");
                    });
            } else {
                let tempInput = $("<textarea>");
                $("body").append(tempInput);
                tempInput.val(customerDetails).select();

                document.execCommand("copy");

                tempInput.remove();

                toastr.success("Copied the details"); 
            }

            return false;
            

            return false;
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(customerDetails).then(() => {
                    toastr.success("Copied the details");
                }).catch((err) => {
                    console.error("Failed to copy details: ", err);
                    toastr.error("Failed to copy details!");
                });
            } else {
                let tempTextarea = document.createElement("textarea");
                tempTextarea.value = customerDetails;
                document.body.appendChild(tempTextarea);
                tempTextarea.select();
                tempTextarea.setSelectionRange(0, 99999);

                try {
                    document.execCommand("copy");
                    toastr.success("Copied the details");
                } catch (err) {
                    console.error("Fallback: Failed to copy details: ", err);
                    toastr.error("Fallback: Failed to copy details!");
                }

                document.body.removeChild(tempTextarea);
            }
        }


        $("#addCustomerModal").on('show.bs.modal', function (event) {
            /*Check if select2 is already initialized*/
            if (!$('#customer_area').hasClass("select2-hidden-accessible")) {
                $("#customer_area").select2({
                    dropdownParent: $("#addCustomerModal"),
                    placeholder: "---Select---"
                });
            }
            if (!$('#customer_houseno').hasClass("select2-hidden-accessible")) {
                $("#customer_houseno").select2({
                    dropdownParent: $("#addCustomerModal"),
                    placeholder: "---Select---"
                });
            }
            if (!$('#customer_package').hasClass("select2-hidden-accessible")) {
                $("#customer_package").select2({
                    dropdownParent: $("#addCustomerModal"),
                    placeholder: "---Select---"
                });
            }
            if (!$('#customer_status').hasClass("select2-hidden-accessible")) {
                $("#customer_status").select2({
                    dropdownParent: $("#addCustomerModal"),
                    placeholder: "---Select---"
                });
            }
            if (!$('#customer_liablities').hasClass("select2-hidden-accessible")) {
                $("#customer_liablities").select2({
                    dropdownParent: $("#addCustomerModal"),
                    placeholder: "---Select---"
                });
            }
            if (!$('#customer_pop').hasClass("select2-hidden-accessible")) {
                $("#customer_pop").select2({
                    dropdownParent: $("#addCustomerModal"),
                    placeholder: "---Select---"
                });
            }
        }); 
        $("#addHouseModal").on('show.bs.modal', function (event) {
            /*Check if select2 is already initialized*/
            if (!$('#area_id').hasClass("select2-hidden-accessible")) {
                $("#area_id").select2({
                    dropdownParent: $("#addHouseModal"),
                    placeholder: "---Select---"
                });
            }
        }); 
        $(document).on('click','#add_area',function(){
            // var formData=$("#form-area").serialize();
            var area_id=$("select[name='area_id']").val();
            var house_no=$("input[name='house_no']").val();
            var note=$("input[name='note']").val();
            var lat=$("input[name='lat']").val();
            var lng=$("input[name='lng']").val();
            var formData = "area_id=" + area_id + 
                            "&house_no=" + house_no + 
                            "&note=" + note + 
                            "&lat=" + lat + 
                            "&lng=" + lng;
            $.ajax({
                type:'POST',
                url:'include/add_area.php?add_area_house',
                data:formData,
                cache:false,
                success:function(response){
                    if(response==1){
                        $("#addHouseModal").modal('hide');
                        toastr.success("Successfully Added");
                        load_house_no(); 
                    }
                }
            });
        });
        load_house_no(); 
        function load_house_no() {
            $.ajax({
                type: "POST",
                url: "include/add_area.php?load_house_no",
                success: function(response) {
                    $("#customer_houseno").html(response);
                }
            });
        }

        function loadGoogleMapsScript() {
            return new Promise((resolve, reject) => {
                if (window.google) {
                    resolve(window.google); 
                    return;
                }
                
                const script = document.createElement('script');
                script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyBuBbBNNwQbS81QdDrQOMq2WlSFiU1QdIs&callback=initMap2";
                script.async = true;
                script.defer = true;

                script.onload = () => {
                    resolve(window.google);
                };

                script.onerror = (error) => {
                    reject(error);
                };

                document.body.appendChild(script);
            });
        }

        function initMap2() {
            const initialLocation = { lat: 23.5565964, lng: 90.7866716 };
            const map = new google.maps.Map(document.getElementById("show_map"), {
                center: initialLocation,
                zoom: 12,
            });

            let marker;

            map.addListener("click", (event) => {
                const clickedLocation = event.latLng;

                if (!marker) {
                    marker = new google.maps.Marker({
                        position: clickedLocation,
                        map: map,
                    });
                } else {
                    marker.setPosition(clickedLocation);
                }
                document.getElementById("lat").value = clickedLocation.lat();
                document.getElementById("lng").value = clickedLocation.lng();
            });
        }


        (async () => {
            try {
                await loadGoogleMapsScript();
                initMap2(); 
            } catch (error) {
                console.error("Google Maps API:", error);
            }
        })();



     </script>                                           



</body>

</html>
