<div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" id="addCustomerModal"
    aria-hidden="true">
    <div class="modal-dialog">
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
