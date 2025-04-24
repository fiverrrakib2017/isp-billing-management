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
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="sendMessageCheckbox" class="col-lg-3 col-form-label">
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
