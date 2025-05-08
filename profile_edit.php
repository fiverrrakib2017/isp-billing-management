<?php
include 'include/db_connect.php';
include 'include/security_token.php';
include 'include/users_right.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_GET['clid'])) {
    $clid = $_GET['clid'];
    if ($cstmr = $con->query("SELECT * FROM customers WHERE id='$clid'")) {
        while ($rows = $cstmr->fetch_array()) {
            $lstid = $rows['id'];
            $fullname = $rows['fullname'];
            $package = $rows['package'];
            $username = $rows['username'];
            $password = $rows['password'];
            $mobile = $rows['mobile'];
            $area = $rows['area'];
            $area_house = $rows['area_house_id'];
            $pop_id = $rows['pop'];
            $address = $rows['address'];
            $nid = $rows['nid'];
            $remarks = $rows['remarks'];
            $con_charge = $rows['con_charge'];
            //$pop = $rows['pop'];
            $price = $rows['price'];
            $customer_status = $rows['status'];
            $expiredate = $rows['expiredate'];
            $liablities = $rows['liablities'];
            $con_type = $rows['con_type'];
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <?php include 'style.php'; ?>
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

        .wizard>.content {
            padding: 12px !important;
        }

        .content.clearfix {
            border: 2px dotted #a6a6a9 !important;
            margin-top: 12px !important;
            margin-bottom: 15px !important;
        }
    </style>
</head>

<body data-sidebar="dark">




    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php $page_title = 'Update Customer';
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
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-10 col-xl-10">
                            <div class="card shadow-sm">
                                <!-- <div class="card-header bg-info text-white text-center">
                                    <h4>Update Customer</h4>
                                </div> -->
                                <div class="card-body">
                                    <form id="form-horizontal" class="form-horizontal form-wizard-wrapper">
                                        <h3>Basic Information</h3>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="" class="col-lg-3 col-form-label">Full
                                                            Name</label>
                                                        <div class="col-lg-9">
                                                            <input id="customer_id" type="text" class="d-none"
                                                                value="<?php echo $lstid; ?>" />
                                                            <input id="customer_fullname" type="text"
                                                                class="form-control " placeholder="Enter Your Fullname"
                                                                value="<?php echo $fullname; ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="txtLastNameBilling"
                                                            class="col-lg-3 col-form-label">Mobile No.</label>
                                                        <div class="col-lg-9">
                                                            <input id="customer_mobile" type="text"
                                                                class="form-control " name="mobile"
                                                                placeholder="Enter Your Mobile Number"
                                                                value="<?php echo $mobile; ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="txtCompanyBilling"
                                                            class="col-lg-3 col-form-label">Address.</label>
                                                        <div class="col-lg-9">
                                                            <input id="customer_address" type="text"
                                                                class="form-control" name="address"
                                                                placeholder="Enter Your Addres"
                                                                value="<?php echo $address; ?>" />

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="txtEmailAddressBilling"
                                                            class="col-lg-3 col-form-label">Nid Card Number</label>
                                                        <div class="col-lg-9">
                                                            <input id="customer_nid" type="text" class="form-control"
                                                                name="nid" placeholder="Enter Your Nid Number"
                                                                value="<?php echo $nid; ?>" />
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
                                                        <label for="txtFirstNameShipping"
                                                            class="col-lg-3 col-form-label">POP/Branch</label>
                                                        <div class="col-lg-9">
                                                            <select id="customer_pop" class="form-select"
                                                                style="width: 100%;">
                                                                <option value="">Select Pop/Branch
                                                                </option>
                                                                <?php
                                                                if ($get_all_pop = $con->query('SELECT * FROM add_pop')) {
                                                                    while ($pop_rows = $get_all_pop->fetch_assoc()) {
                                                                        $_pop_id = $pop_rows['id'];
                                                                        $pop_name = $pop_rows['pop'];
                                                                        $pop_selected = $_pop_id == $pop_id ? 'selected' : '';
                                                                        echo '<option value="' . $_pop_id . '" ' . $pop_selected . '>' . $pop_name . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="txtLastNameShipping"
                                                            class="col-lg-3 col-form-label">Area/Location</label>
                                                        <div class="col-lg-9">
                                                            <select id="customer_area" class="form-select"
                                                                name="area" style="width: 100%;">
                                                                <option>Select Area</option>
                                                                <?php
                                                                if ($get_all_area = $con->query("SELECT * FROM area_list WHERE pop_id=$pop_id")) {
                                                                    while ($area_rows = $get_all_area->fetch_assoc()) {
                                                                        $area_id = $area_rows['id'];
                                                                        $area_name = $area_rows['name'];
                                                                        $area_selected = $area_id == $area ? 'selected' : '';
                                                                        echo '<option value="' . $area_id . '" ' . $area_selected . '>' . $area_name . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="txtCompanyShipping"
                                                            class="col-lg-3 col-form-label">House No.<?php  $area_house;?></label>
                                                        <div class="col-lg-9">
                                                            <div class="d-flex">
                                                                <select id="customer_house_id" class="form-select"
                                                                    name="customer_house_id" style="width: 100%;">
                                                                    <option value="0">---Select---</option>
                                                                    <?php
                                                                    
                                                                    if ($get_all_house = $con->query("SELECT * FROM area_house WHERE pop_id=$pop_id")) {
                                                                        while ($rows = $get_all_house->fetch_assoc()) {
                                                                            $_id = $rows['id'];
                                                                            $house_name = $rows['house_no'];
                                                                            $selected = ($_id == $area_house) ? 'selected' : '';
                                                                            echo '<option value="' . $_id . '" '.$selected.'>' . $house_name . '</option>';
                                                                        }
                                                                    }
                                                                    
                                                                    ?>
                                                                </select>
                                                                <button type="button"
                                                                    class="btn btn-primary add-house-btn"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#addHouseModal">
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
                                                        <label for="txtNameCard"
                                                            class="col-lg-3 col-form-label">Username <span
                                                                id="usernameCheck"></span></label>
                                                        <div class="col-lg-9">
                                                            <input id="customer_username" type="text"
                                                                class="form-control " name="username"
                                                                placeholder="Enter Your Username"
                                                                value="<?php echo $username; ?>" />

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="ddlCreditCardType"
                                                            class="col-lg-3 col-form-label">Password</label>
                                                        <div class="col-lg-9">
                                                            <input id="customer_password" type="password"
                                                                class="form-control " name="password"
                                                                placeholder="Enter Your Password"
                                                                value="<?php echo $password; ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="txtCreditCardNumber"
                                                            class="col-lg-3 col-form-label">Package</label>
                                                        <div class="col-lg-9">
                                                            <select id="customer_package" class="form-select"
                                                                style="width: 100%;">
                                                                <?php
                                                                
                                                                if ($result = $con->query("SELECT * FROM branch_package WHERE pop_id=$pop_id")) {
                                                                    while ($rows = $result->fetch_assoc()) {
                                                                        $id = htmlspecialchars($rows['pkg_id']);
                                                                        $package_name = htmlspecialchars($rows['package_name']);
                                                                        $selected = $id == $package ? 'selected' : '';
                                                                        echo '<option value="' . $id . '" ' . $selected . '>' . $package_name . '</option>';
                                                                    }
                                                                }
                                                                
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="txtCardVerificationNumber"
                                                            class="col-lg-3 col-form-label">Package Price</label>
                                                        <div class="col-lg-9">
                                                            <input id="customer_price" type="text"
                                                                class="form-control" value="<?php echo $price ?? 00; ?>" />

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="txtExpirationDate"
                                                            class="col-lg-3 col-form-label">Connection Charge</label>
                                                        <div class="col-lg-9">
                                                            <input id="customer_con_charge" type="text"
                                                                class="form-control" name="con_charge"
                                                                placeholder="Enter Connection Charge"
                                                                value="<?php echo $con_charge ?? 500; ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="txtExpirationDate"
                                                            class="col-lg-3 col-form-label">Expire Date</label>
                                                        <div class="col-lg-9">
                                                            <!-- <select id="customer_billing_date" class="form-select"
                                                                style="width: 100%;">
                                                                <?php
                                                                if ($get_all_area_billing_days = $con->query("SELECT `billing_date` FROM area_list WHERE id=$area")) {
                                                                    $billing_date_found = false;
                                                                
                                                                    while ($rows = $get_all_area_billing_days->fetch_assoc()) {
                                                                        $billing_date = $rows['billing_date'] ?? null;
                                                                
                                                                        if (!empty($billing_date) && $billing_date > 0) {
                                                                            echo '<option value="' . $billing_date . '">' . $billing_date . '</option>';
                                                                            $billing_date_found = true;
                                                                        }
                                                                    }
                                                                
                                                                    if (!$billing_date_found) {
                                                                        if ($exp_cstmr = $con->query('SELECT `days` FROM customer_expires')) {
                                                                            $expire_dates = [];
                                                                            while ($rowsssss = $exp_cstmr->fetch_assoc()) {
                                                                                $exp_date = $rowsssss['days'];
                                                                                if (!in_array($exp_date, $expire_dates)) {
                                                                                    echo '<option value="' . $exp_date . '">' . $exp_date . '</option>';
                                                                                    $expire_dates[] = $exp_date;
                                                                                }
                                                                            }
                                                                
                                                                            if (empty($expire_dates)) {
                                                                                $default_date = date('d');
                                                                                echo '<option value="' . $default_date . '">' . $default_date . '</option>';
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                ?>

                                                            </select> -->
                                                            <input id="customer_expire_date" type="date"
                                                                class="form-control" name="customer_expire_date"
                                                                value="<?php echo $expiredate; ?>" />
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
                                                        <label for="txtNameCard"
                                                            class="col-lg-3 col-form-label">Remarks</label>
                                                        <div class="col-lg-9">
                                                            <textarea id="customer_remarks" type="text" class="form-control" placeholder="Enter Remarks"><?php echo htmlspecialchars($remarks); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="ddlCreditCardType"
                                                            class="col-lg-3 col-form-label">Status</label>
                                                        <div class="col-lg-9">
                                                            <select id="customer_status" class="form-select"
                                                                style="width: 100%;">
                                                                <option value="">Select Status</option>
                                                                <option value="0" <?php echo $customer_status == 0 ? 'selected' : ''; ?>>Disable
                                                                </option>
                                                                <option value="1" <?php echo $customer_status == 1 ? 'selected' : ''; ?>>Active
                                                                </option>
                                                                <option value="2" <?php echo $customer_status == 2 ? 'selected' : ''; ?>>Expire
                                                                </option>
                                                                <option value="3" <?php echo $customer_status == 3 ? 'selected' : ''; ?>>Request
                                                                </option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="txtCreditCardNumber"
                                                            class="col-lg-3 col-form-label">Liablities</label>
                                                        <div class="col-lg-9">
                                                            <select id="customer_liablities" class="form-select"
                                                                style="width: 100%;">
                                                                <option value="">---Select---</option>
                                                                <option value="0" <?php echo $liablities == 0 ? 'selected' : ''; ?>>No</option>
                                                                <option value="1" <?php echo $liablities == 1 ? 'selected' : ''; ?>>Yes
                                                                </option>
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
                                                                <option value="UTP" <?= ($con_type == 'UTP') ? 'selected' : '' ?>>UTP</option>
                                                                <option value="ONU" <?= ($con_type == 'ONU') ? 'selected' : '' ?>>ONU</option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <div class="card-footer mt-2">
                                    <button type="button" class="btn btn-danger"
                                        onclick="window.history.back();">Back</button>
                                    <button type="button" class="btn btn-success" id="customer_update_btn">Update
                                        Customer</button>
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

    <!-- Add House Modal  -->
    <div class="modal fade" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        id="addHouseModal">
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
                                        <select class="form-select" name="area_id" id="area_id"
                                            style="width: 100%;">
                                            <option >Select</option>
                                            <?php
                                            if ($pop = $con->query('SELECT * FROM area_list')) {
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
                                        <input class="form-control" type="text" name="house_no" id="house_no"
                                            placeholder="Type  House-Building No." />

                                    </div>
                                    <div class="form-group mb-1">
                                        <label>Note</label>
                                        <input class="form-control" type="text" name="note" id="note"
                                            placeholder="Type Your Note" />
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

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <?php include 'script.php'; ?>
    <script src="js/customer.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select').select2();
            //$('#customer_house_id').removeClass('d-none');
        });



        $("#customer_update_btn").click(function() {
            var customer_id = $("#customer_id").val();
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
            var customer_houseno = $("#customer_house_id").val();
            var customer_connection_type = $("#customer_connection_type").val();
            var user_type = 1;

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
            } else if (liablities.length == 0) {
                toastr.error("Liablities is require");
            } else if (nid.length == 0) {
                toastr.error("Nid is require");
            } else if (address.length == 0) {
                toastr.error("Address is require");
            }else if(customer_connection_type.length=='0'){
                toastr.error("Connection Type is Require");
                return false; 
            }
            $("#customer_update_btn").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $("#customer_update_btn").prop("disabled", true);
            $.ajax({
                type: 'POST',
                url: 'include/customers_server.php?update_customer=true',
                dataType: "json",
                data: {
                    customer_id: customer_id,
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
                },
                success: function(response) {
                    if (response.success == true) {
                        toastr.success(response.message);
                    }
                    if (response.success == false) {
                        toastr.error(response.message);
                    }
                    $("#customer_update_btn").html('Update Customer');
                    $("#customer_update_btn").prop("disabled", false);
                }
            });

        });
    </script>

</body>

</html>
