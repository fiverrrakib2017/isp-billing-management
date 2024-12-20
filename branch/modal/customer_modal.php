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
                <form id="customer_form">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>Full Name</label>
                                        <input id="customer_fullname" type="text" class="form-control "
                                            placeholder="Enter Your Fullname" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>Username <span id="usernameCheck"></span></label>
                                        <input id="customer_username" type="text" class="form-control "
                                            name="username" placeholder="Enter Your Username"
                                            oninput="checkUsername();" />

                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>Password</label>
                                        <input id="customer_password" type="password" class="form-control "
                                            name="password" placeholder="Enter Your Password" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>Mobile no.</label>
                                        <input id="customer_mobile" type="text" class="form-control " name="mobile"
                                            placeholder="Enter Your Mobile Number" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>Expired Date</label>
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
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>Address</label>
                                        <input id="customer_address" type="text" class="form-control" name="address"
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
                                            $condition = "";
                                            if (isset($auth_usr_POP_id)) {
                                                $pop_id = intval($auth_usr_POP_id); 
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
                                <div class="col-md-6 ">
                                    <div class="form-group mb-2">
                                        <label>Area/Location</label>
                                        <select id="customer_area" class="form-select" name="area">
                                            <option>Select Area</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>Nid Card Number</label>
                                        <input id="customer_nid" type="text" class="form-control" name="nid"
                                            placeholder="Enter Your Nid Number" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>Package</label>
                                        <select id="customer_package" class="form-select">


                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>Connection Charge</label>
                                        <input id="customer_con_charge" type="text" class="form-control"
                                            name="con_charge" placeholder="Enter Connection Charge" value="500" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>Package Price</label>
                                        <input disabled id="customer_price" type="text" class="form-control"
                                            value="00" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea id="customer_remarks" type="text" class="form-control" placeholder="Enter Remarks"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select id="customer_status" class="form-select">
                                            <option value="">Select Status
                                            </option>
                                            <option value="0">Disable</option>
                                            <option value="1">Active</option>
                                            <option value="2">Expire</option>
                                            <option value="3">Request</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Liablities</label>
                                        <select id="customer_liablities" class="form-select">
                                            <option value="">---Select---</option>
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="customer_add">Add
                    Customer</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
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
                        <button  class="btn btn-primary">
                            <i class="fas fa-chat"></i> Send Message
                        </button>
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

    </style>