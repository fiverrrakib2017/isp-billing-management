<?php
include 'include/security_token.php';
include 'include/users_right.php';
include 'include/db_connect.php';

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

        <?php $page_title = 'Customers Billing Report';
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
                                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                                            </p>
                                            <p class="text-primary mb-0 hover-cursor">Customers Billing Report</p>
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
                                                    <th>Customer Name</th>
                                                    <th>Target Amount</th>
                                                    <th>Collection Amount</th>

                                                </tr>
                                            </thead>
                                            <tbody></tbody>
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
        // $options = '';
        // $get_data = $con->query("SELECT id, fullname FROM users WHERE user_type='1'");

        // while ($row = $get_data->fetch_assoc()) {
        //     $options .= '<option value="' . $row['id'] . '">' . $row['fullname'] . '</option>';
        // }
    ?>
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <?php require 'script.php'; ?>
    <script type="text/javascript">

    /* Generate Month Dropdown */
    function getMonthOptions(selectedMonth) {
        const months = [
            "January", "February", "March", "April", "May", "June", 
            "July", "August", "September", "October", "November", "December"
        ];
        
        let options = "";
        months.forEach((month, index) => {
            let value = (index + 1).toString().padStart(2, '0'); 
            let selected = (value === selectedMonth) ? "selected" : "";
            options += `<option value="${value}" ${selected}>${month}</option>`;
        });

        return options;
    }

    /* Generate Year Dropdown */
    function getYearOptions(selectedYear) {
        let options = "";
        let currentYear = new Date().getFullYear();
        for (let year = currentYear - 5; year <= currentYear + 5; year++) {
            let selected = (year === selectedYear) ? "selected" : "";
            options += `<option value="${year}" ${selected}>${year}</option>`;
        }
        return options;
    }

    /* Get Current Month & Year*/
    let currentMonth = new Date().getMonth() + 1; 
    let currentMonthStr = currentMonth.toString().padStart(2, '0'); 
    let currentYear = new Date().getFullYear(); 

    // Month & Year Filters
    var from_month = `<label style="margin-left: 20px;">
                        <select class="from_month form-control" style="width: 120px; display: inline;">
                            ${getMonthOptions(currentMonthStr)}
                        </select>
                    </label>`;

    var to_month = `<label style="margin-left: 10px;">
                        <select class="to_month form-control" style="width: 120px; display: inline;">
                            ${getMonthOptions(currentMonthStr)}
                        </select>
                    </label>`;

    var year_filter = `<label style="margin-left: 10px;">
                        <select class="year_filter form-control" style="width: 100px; display: inline;">
                            ${getYearOptions(currentYear)}
                        </select>
                    </label>`;

    setTimeout(() => {
        let filterContainer = $('.dataTables_filter');

        filterContainer.append(from_month);
        filterContainer.append(to_month);
        filterContainer.append(year_filter);

        $('.from_month').select2();
        $('.to_month').select2();
        $('.year_filter').select2();

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
            url: "include/customer_recharge_server.php?get_customer_billing_report=true",
            type: 'GET',
            data: function(d) {
                d.from_month = $('.from_date').val() || '<?php echo date('Y-m-d');?>';
                d.to_month = $('.to_date').val() || '<?php echo date('Y-m-d');?>';
            },
            beforeSend: function() {
                $(".dataTables_empty").html(
                    '<img src="assets/images/loading.gif" style="background-color: transparent"/>'
                    );
            },

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
