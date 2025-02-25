<?php
include '../include/security_token.php';
include '../include/users_right.php';
include '../include/db_connect.php';

?>


<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/branch/style.php';
        
        echo file_get_contents($url);
    ?>

</head>

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php $page_title = 'Customer Payment'; include '../Header.php'; ?>

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
                                    <div id="totalAmount" style="font-weight: bold; color:green; font-size: 18px; margin-bottom: 10px; text-align: right;"></div>
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Recharged date</th>
                                                    <th>Customer Username</th>
                                                    <th>Months</th>
                                                    <th>Type</th>
                                                    <th>Paid until</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody id="recharge-list">

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
    <?php
        $options = '';
        $pop_id=$_SESSION['user_pop']?? '0';
        $get_data = $con->query("SELECT id, fullname FROM users WHERE pop_id='$pop_id'  ORDER BY fullname ASC");

        while ($row = $get_data->fetch_assoc()) {
            $options .= '<option value="' . $row['id'] . '">' . $row['fullname'] . '</option>';
        }
    ?>
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <?php

        $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/branch/script.php';

        echo file_get_contents($url);

        ?>
    <script type="text/javascript">

    /* From Date */
    var from_date = `<label style="margin-left: 20px;">
                        <input class="from_date form-control" type="date" value="<?php echo date('Y-m-d');?>" style="width: 150px; display: inline;">
                    </label>`;

    /* To Date */
    var to_date = `<label style="margin-left: 10px;">
                        <input class="to_date form-control" value="<?php echo date('Y-m-d');?>" type="date" style="width: 150px; display: inline;">
                    </label>`;
    var status = `<label style="margin-left: 10px;">
                        <select class="status_filter form-control" style="width: 150px; display: inline;">
                            <option >---Select Type---</option>
                            <option value="Credit">Credit</option>
                            <option value="1">Cash</option>
                            <option value="2">Bkash</option>
                            <option value="3">Nagad</option>
                            <option value="4">Due Paid</option>
                        </select>
                    </label>`;

     /* Bill Collect Dropdown */
     var bill_collect = `<label style="margin-left: 10px;">
                                <select class="bill_collect form-control" style="width: 150px; display: inline;">
                                    <option>---Collection---</option>
                                    <?= $options; ?>
                                </select>
                            </label>`;

    setTimeout(() => {
        let filterContainer = $('.dataTables_filter');
        let lengthContainer = $('.dataTables_length');

        lengthContainer.parent().removeClass('col-sm-12 col-md-6');
        filterContainer.parent().removeClass('col-sm-12 col-md-6');

        filterContainer.append(from_date);
        filterContainer.append(to_date);
        filterContainer.append(status);
        filterContainer.append(bill_collect);

        $('.status_filter').select2();
        $('.bill_collect').select2();
    }, 500); 

    /* DataTable Initialization */
    $('#datatable').DataTable({
        searching: true,
        paging: true,
        info: true,
        order: [[0, "desc"]],
        lengthChange: true,
        processing: false,
        serverSide: false,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All']
        ],
        language: {
            zeroRecords: "No matching records found"
        },
        ajax: {
            url: "../include/customer_recharge_server.php?get_recharge_data=true",
            type: 'GET',
            data: function(d) {
                d.from_date = $('.from_date').val() || '<?php echo date('Y-m-d');?>';
                d.to_date = $('.to_date').val() || '<?php echo date('Y-m-d');?>';
                d.type = $('.status_filter').val();
                d.bill_collect = $('.bill_collect').val();
            },
            beforeSend: function() {
                $(".dataTables_empty").html(
                    '<img src="assets/images/loading.gif" style="background-color: transparent"/>'
                    );
            },
            
            dataSrc: function(json) {
                $('#totalAmount').text('Total Amount: ' + json.totalAmount + ' BDT');

                return json.data;
            }

        },
        drawCallback: function() {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }
    });
    $(document).on('change','.from_date',function(){
        $('#datatable').DataTable().ajax.reload();
    });
    $(document).on('change','.to_date',function(){
        $('#datatable').DataTable().ajax.reload();
    });
    $(document).on('change','.status_filter',function(){
        $('#datatable').DataTable().ajax.reload();
    });
    $(document).on('change','.bill_collect',function(){
        $('#datatable').DataTable().ajax.reload();
    });

    </script>
</body>

</html>
