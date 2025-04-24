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

</head>

<body data-sidebar="dark">


    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php $page_title = 'Customers';
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
                                            <p class="text-primary mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                                            </p>
                                            <p class="text-primary mb-0 hover-cursor">Customers</p>
                                            <?php if($_GET['new_customer_month']):?>
                                                <p class="text-primary mb-0 hover-cursor">/&nbsp;New Customers</p>
                                            <?php endif; ?>
                                            <?php if($_GET['expire_customer_month']):?>
                                                <p class="text-primary mb-0 hover-cursor">/&nbsp; Monthly Expired Customers</p>
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
                                        id="addBtn" style="margin-bottom: 12px;">&nbsp;&nbsp;New customer</button>



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
                                <div class="card-footer flex-wrap justify-content-between align-items-center">
                                    <button class="btn btn-primary mb-2" id="send_message_btn">
                                        <i class="fa fa-envelope"></i>&nbsp;
                                    </button>
                                   <button type="button" class="btn btn-info mb-2" name="customer_billing_btn">
                                        <i class="fa fa-exchange-alt"></i>&nbsp;Change Billing
                                    </button>


                                    <button type="button" class="btn btn-success mb-2" name="export_to_excel">
                                        <img src="https://img.icons8.com/?size=100&id=117561&format=png&color=000000"
                                            class="img-fluid icon-img" style="height: 20px !important;">
                                        
                                    </button>

                                    <button type="button" onclick="printSelectedRows()" class="btn btn-danger mb-2">
                                        <i class="fas fa-print"></i>&nbsp;
                                    </button>

                                    <button type="button" class="btn btn-info mb-2" name="recharge_btn">
                                        <i class="mdi mdi-battery-charging-20"></i>&nbsp;
                                    </button>

                                    <!-- <button type="button" class="btn btn-info mb-2"data-bs-toggle="modal"
                                        data-bs-target="#ticketModal">
                                        <i class="mdi mdi-ticket"></i>&nbsp;Add Ticket
                                    </button> -->

                                    <button type="button" class="btn btn-success mb-2" name="pop_change_btn">
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
                    <h5 class="modal-title" id="exampleModalLabel"><span class="mdi mdi-account-check mdi-18px"></span>
                        &nbsp;Send Message</h5>
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
    <!------------------ Modal for Recharge ------------------>
    <div class="modal fade " id="rechargeModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
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
                            <input id="RefNo" type="text" class="form-control" name="RefNo"
                                placeholder="Enter Ref No" />
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
                    <button type="button" name="recharge_submit_btn" class="btn btn-success">Recharge Now</button>
                </div>
            </div>
        </div>
    </div>
    <!--------------------Add Payment received Modal---------------------------->
    <div class="modal fade " id="addPaymentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Payment Received
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info" id="selectedCustomerCount"></div>
                    <form id="cash_received_form" method="POST">
                        <div class="form-group mb-2">
                            <label>Amount:</label>
                            <input type="text" name="received_amount" placeholder="Enter Your Amount"
                                class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Transaction Type:</label>
                            <select id="received_tra_type" class="form-select" required>
                                <option>---Select---</option>
                                <option value="1">Cash</option>
                                <option value="2">Bkash</option>
                                <option value="3">Nagad</option>
                                <option value="4">Bank</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Remarks</label>
                            <textarea name="received_remarks" class="form-control" placeholder="Enter Remarks"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" name="cash_received_submit_btn" class="btn btn-success"><i
                            class="mdi mdi-cash"></i> Payment Now</button>
                </div>
            </div>
        </div>
    </div>
    <!--------------------CSV File Import Modal---------------------------->
    <div class="modal fade " id="fileImportModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="mdi mdi-upload"></i> File Import
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="file_import_form" method="POST">
                        <div class="form-group mb-2">
                            <label>Upload Your File:</label>
                            <input type="file" name="import_file_name" class="form-control" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" name="file_upload_submit_btn" class="btn btn-success"><i
                            class="mdi mdi-upload"></i> Upload Now</button>
                </div>
            </div>
        </div>
    </div>
    <!------------------ Modal for Change Customer POP/Branch ------------------>
    <div class="modal fade " id="changePopModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="mdi mdi-swap-horizontal"></i> Change POP/Branch
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info" id="selectedCustomerCount"></div>
                    <form id="change_pop_form" method="POST">
                        <div class="form-group mb-1">
                            <label>Transfer To POP/Branch</label>
                            <select type="text" name="pop_id" class="form-select" style="width: 100%;"></select>
                        </div>
                        <div class="form-group mb-1">
                            <label>Area</label>
                            <select type="text" name="area_id" class="form-select" style="width: 100%;"></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" name="pop_change_submit_btn" class="btn btn-success"> <i
                            class="mdi mdi-swap-horizontal"></i> Change POP/Branch</button>
                </div>
            </div>
        </div>
    </div>
    <!--------------------Customer Billing Modal Modal---------------------------->
    <div class="modal fade " id="customerBillingModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Customer Billing Change
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info" id="selectedCustomerCount"></div>
                    <form id="customer_billing_form" method="POST">
                        <div class="form-group mb-2">
                            <label>Billing Date:</label>
                            <select type="text" name="customer_billing_date" class="form-select" required>
                                <option value="">---Select---</option>
                                <?php
                                for ($i = 1; $i <= 31; $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" name="customer_billing_submit_btn" class="btn btn-success"><i
                            class="mdi mdi-update"></i> Change Now</button>
                </div>
            </div>
        </div>
    </div>
    <!------------------ Modal Customer Tickets ------------------>
    <?php require 'modal/tickets_modal.php'; ?>
    <?php require 'modal/customer_modal.php'; ?>
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <?php include 'script.php'; ?>
    <script src="js/tickets.js"></script>
    <script src="js/customer.js"></script>
    <script src="js/Ajax.js"></script>



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
                "processing": false,
                "serverSide": false,
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

            // table.columns(9).search(pop_filter_result).draw();
            table.ajax.reload(null, false);

        });
        /* Area change event*/
        $(document).on('change', '.area_filter', function() {

            var area_filter_result = $('.area_filter').val() == null ? '' : $('.area_filter').val();

            // table.columns(10).search(area_filter_result).draw();

            table.ajax.reload(null, false);

        });
        /* Area change event*/
        $(document).on('change', '.status_filter', function() {
            var status_filter_result = $('.status_filter').val() == null ? '' : $('.status_filter').val();
            table.ajax.reload(null, false);
        });
        $(document).on('click', 'button[name="export_to_excel"]', function () {
            let csvContent = "data:text/csv;charset=utf-8,";

            /*Header Row (Remove first and last column)*/ 
            csvContent += [
                'ID', 'Name', 'Package', 'Amount', 'Create Date', 'Expired Date',
                'Username', 'Mobile no.', 'POP/Branch', 'Area/Location', 'Liabilities'
            ].join(",") + "\n";
            $('#customers_table tbody tr').each(function () {
                let row = [];
                let $tds = $(this).find('td');

                /*Remove 1st and 2nd Column*/ 
                for (let i = 1; i < $tds.length - 1; i++) {
                    let cell = $tds.eq(i).text().trim();
                    row.push('"' + cell.replace(/"/g, '""') + '"');
                }

                csvContent += row.join(",") + "\n";
            });
            

            /* Trigger download*/
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
        /************************** Customer Recharage Section **************************/
        $(document).on('click', 'button[name="recharge_btn"]', function(e) {
            event.preventDefault();
            var selectedCustomers = [];
            $(".checkSingle:checked").each(function() {
                selectedCustomers.push($(this).val());
            });
            if (selectedCustomers.length == 0) {
                toastr.error("Please select at least one customer to recharge.");
                return false;
            }
            var countText = "You have selected " + selectedCustomers.length + " customers.";
            $("#rechargeModal #selectedCustomerCount").text(countText);
            $('#rechargeModal').modal('show');
        });

        $(document).on('click', 'button[name="recharge_submit_btn"]', function(e) {
            event.preventDefault();
            var $button = $(this);
            $button.prop('disabled', true);
            $button.html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...'
            );

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
                    } else if (response.success == false) {
                        if (response.errors) {
                            $.each(response.errors, function(key, error) {
                                toastr.error(error);
                            });
                        } else {
                            toastr.error(response.message);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
                    alert("There was an error sending the message.");
                },
                complete: function() {

                    $button.prop('disabled', false);
                    $button.html('Recharge Now');
                }
            });
        });
        /************************** Cash Received **************************/
        $(document).on('click', 'button[name="cash_received_btn"]', function(e) {
            event.preventDefault();
            var customers = [];
            $(".checkSingle:checked").each(function() {
                customers.push($(this).val());
            });
            if (customers.length == 0) {
                toastr.error("Please select at least one customer");
                return false;
            }
            if (customers.length > 1) {
                toastr.error("Sorry!! You Don't Selected One More");
                return false;
            }

            var countText = "You have selected " + customers.length + " customer.";
            $("#addPaymentModal #selectedCustomerCount").text(countText);
            $('#addPaymentModal').modal('show');
        });

        $(document).on('click', 'button[name="cash_received_submit_btn"]', function(e) {
            event.preventDefault();
            var $button = $(this);
            $button.prop('disabled', true);
            $button.html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...'
            );

            var selectedCustomers = [];
            $(".checkSingle:checked").each(function() {
                selectedCustomers.push($(this).val());
            });
            var data = $('#cash_received_form').serialize() + '&selectedCustomers=' + JSON.stringify(
                selectedCustomers);
            $.ajax({
                url: 'include/customer_recharge_server.php?cash_received=true',
                method: 'POST',
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#addPaymentModal').modal('hide');
                        $('#customers_table').DataTable().ajax.reload();
                    } else if (response.success == false) {
                        if (response.errors) {
                            $.each(response.errors, function(key, error) {
                                toastr.error(error);
                            });
                        } else {
                            toastr.error(response.message);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
                    alert("There was an error sending the message.");
                },
                complete: function() {

                    $button.prop('disabled', false);
                    $button.html('<i class="mdi mdi-cash"></i>Payment Now');
                }
            });
        });
        /************************** CSV File Upload **************************/
        $(document).on('click', 'button[name="file_upload_submit_btn"]', function(e) {
            event.preventDefault();
            var $button = $(this);
            $button.prop('disabled', true);
            $button.html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...'
            );
            var formData = new FormData($('#file_import_form')[0]);

            $.ajax({
                url: 'include/customer_server_new.php?import_file_data=true',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#fileImportModal').modal('hide');
                        $('#customers_table').DataTable().ajax.reload();
                    } else {
                        if (response.errors) {
                            $.each(response.errors, function(key, error) {
                                toastr.error(error);
                            });
                        } else {
                            toastr.error(response.message);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
                    alert("There was an error sending the message.");
                },
                complete: function() {
                    $button.prop('disabled', false);
                    $button.html('<i class="mdi mdi-upload"></i> Upload Now');
                }
            });

        });
        /************************** Charge Customer POP/Branch **************************/
        $(document).on('click', 'button[name="pop_change_btn"]', function(e) {
            event.preventDefault();
            var selectedCustomers = [];
            $(".checkSingle:checked").each(function() {
                selectedCustomers.push($(this).val());
            });
            var countText = "You have selected " + selectedCustomers.length + " customers.";
            $("#changePopModal #selectedCustomerCount").text(countText);
            if (selectedCustomers.length == 0) {
                toastr.error("Please select at least one customer");
                return false;
            }
            $.ajax({
                url: 'include/pop_server.php?get_pop_data=1',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success == true) {
                        var popOptions = '<option value="">--Select POP--</option>';

                        $.each(response.data, function(key, data) {
                            popOptions += '<option value="' + data.id + '">' + data.pop +
                                '</option>';
                        });

                        $('select[name="pop_id"]').html(popOptions);
                        $('#changePopModal').modal('show');
                        $('#changePopModal').on('shown.bs.modal', function() {
                            if (!$('select[name="pop_id"]').hasClass(
                                    "select2-hidden-accessible")) {
                                $('select[name="pop_id"]').select2({
                                    dropdownParent: $('#changePopModal')
                                });
                            }
                        });
                        get_area();
                    }
                }
            });
        });
        $("#changePopModal select[name='pop_id']").change(function() {
            var pop_id = $(this).val();
            get_area(pop_id);
        });

        function get_area(pop_id) {
            $.ajax({
                url: 'include/area_server.php?get_area_data=1',
                type: 'GET',
                data: {
                    pop_id: pop_id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success == true) {
                        var areaOptions = '<option value="">--Select Area--</option>';

                        $.each(response.data, function(key, data) {
                            areaOptions += '<option value="' + data.id + '">' + data.name +
                                '</option>';
                        });
                        $('select[name="area_id"]').html(areaOptions);
                        $('#changePopModal').on('shown.bs.modal', function() {
                            if (!$('select[name="area_id"]').hasClass(
                                    "select2-hidden-accessible")) {
                                $('select[name="area_id"]').select2({
                                    dropdownParent: $('#changePopModal')
                                });
                            }
                        });

                    }

                }
            });
        }

        $(document).on('click', 'button[name="pop_change_submit_btn"]', function(e) {
            event.preventDefault();
            var $button = $(this);
            $button.prop('disabled', true);
            $button.html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...'
            );

            var selectedCustomers = [];
            $(".checkSingle:checked").each(function() {
                selectedCustomers.push($(this).val());
            });
            var data = $('#change_pop_form').serialize() + '&selectedCustomers=' + JSON.stringify(
                selectedCustomers);
            $.ajax({
                url: 'include/customer_server_new.php?change_pop_request=true',
                method: 'POST',
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#changePopModal').modal('hide');
                        $('#customers_table').DataTable().ajax.reload();
                    } else if (response.success == false) {
                        if (response.errors) {
                            $.each(response.errors, function(key, error) {
                                toastr.error(error);
                            });
                        } else {
                            toastr.error(response.message);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
                    alert("There was an error sending the message.");
                },
                complete: function() {

                    $button.prop('disabled', false);
                    $button.html('<i class="mdi mdi-swap-horizontal"></i> Change POP/Branch');

                }
            });
        });
        /************************** Add ticket Modal Script **************************/
        ticket_modal();
        loadCustomers();
        ticket_assign();
        ticket_complain_type();
        /************************** Customer Billing And Expire Section **************************/
        $(document).on('click', 'button[name="customer_billing_btn"]', function(e) {
            event.preventDefault();
            var customers = [];
            $(".checkSingle:checked").each(function() {
                customers.push($(this).val());
            });
            if (customers.length == 0) {
                toastr.error("Please select at least one customer");
                return false;
            }
            // if (customers.length > 1) {
            //     toastr.error("Sorry!! You Don't Selected One More");
            //     return false;
            // }

            var countText = "You have selected " + customers.length + " customer.";
            $("#customerBillingModal #selectedCustomerCount").text(countText);
            $('#customerBillingModal').modal('show');
        });

        $(document).on('click', 'button[name="customer_billing_submit_btn"]', function(e) {
            e.preventDefault();
            var $button = $(this);
            $button.prop('disabled', true);
            $button.html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...'
            );

            var customers = [];
            $(".checkSingle:checked").each(function() {
                customers.push($(this).val());
            });

            var data = $('#customer_billing_form').serialize() + '&customers=' + JSON.stringify(customers);

            $.ajax({
                url: 'include/customer_server_new.php?customer_billing_request=true',
                method: 'POST',
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#customerBillingModal').modal('hide');
                        $('#customers_table').DataTable().ajax.reload();
                    } else if (response.success === false) {
                        if (response.errors) {
                            $.each(response.errors, function(key, error) {
                                toastr.error(error);
                            });
                        } else {
                            toastr.error(response.message);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
                    toastr.error("There was an error sending the message.");
                },
                complete: function() {
                    $button.prop('disabled', false);
                    $button.html('<i class="mdi mdi-update"></i> Change Now');
                }
            });
        });
    </script>
</body>

</html>
