<?php
include("include/security_token.php");
include("include/db_connect.php");
include("include/pop_security.php");
include("include/users_right.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'style.php';?>
</head>

<body data-sidebar="dark">


    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php $page_title="Onu List";  include 'Header.php';  ?>

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
                                            <p class="text-primary mb-0 hover-cursor">Onu List</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>

                               
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                 <div class="card-header">
                                    <marquee behavior="scroll" direction="left" scrollamount="5" style="color: #0c5460; font-weight: bold;  padding: 8px; border-radius: 5px;">
                                        📢 নোটিশ: এই তালিকায় থাকা কাস্টমাররা তাদের ইন্টারনেট সংযোগ বাতিল করেছেন। অনু/ONU ডিভাইস যদি কোম্পানি প্রদান করে থাকে, তবে তা দ্রুত সংগ্রহ করুন এবং স্টকে আপডেট করুন। সংযোগ বাতিলের তারিখ ও অনু টাইপ যাচাই করে প্রয়োজনীয় পদক্ষেপ গ্রহণ করুন। ✅
                                    </marquee>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive ">
                                        <table id="table1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" >
                                            <thead >
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Username</th>
                                                    <th>Package</th>
                                                    <th>Phone Number </th>
                                                    <th>Pop/Branch</th>
                                                    <th>Area</th>
                                                    <th>Onu Type</th>
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
    <div class="rightbar-overlay"></div>
    <?php include 'script.php';?>
    <script type="text/javascript">
    var table;
    $(document).ready(function(){
        var status_filter = '<label style="margin-left: 20px;"> ';
        status_filter += '<select class="status_filter form-select">';
        status_filter += '<option value="">--Onu Type--</option>';
        status_filter += '<option value="company">Company</option>';
        status_filter += '<option value="customer">Customer</option>';
        status_filter += '</select></label>';

        setTimeout(() => {
            $('.dataTables_length').parent().removeClass(
                'col-sm-12 col-md-6');
            $('.dataTables_filter').parent().removeClass(
                'col-sm-12 col-md-6');
            $('.dataTables_length').append(status_filter);
            $('.status_filter').select2();
        }, 1000);
        /*Initialize DataTable with server-side processing*/ 
            table=$('#table1').DataTable( {
                "searching": true,
                "paging": true,
                "info": false,
                "lengthChange":true ,
                "processing"		: true,
                "serverSide"		: true,
                "zeroRecords"       :    "No matching records found",
                "ajax"				: {
                    url             : "include/customer_server_new.php?get_customers_onu_data=true",
                    type		    : 'GET',
                    data: function(d) {

                        /********************Filter For Onu Type*******************************/
                        d.onu_type = $('.status_filter').val();

                    },
                },
                "buttons": [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
                exportOptions: { columns: ':visible' }
            }, 
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
                exportOptions: { columns: ':visible' }
            }, 
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
                exportOptions: { columns: ':visible' }
            }, 
            {
                extend: 'pdf',
                exportOptions: { columns: ':visible' },
                orientation: 'landscape',
                pageSize: "LEGAL",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            }, 
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print',
                exportOptions: { columns: ':visible' }
            }, 
            {
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
            ],
        });
        table.buttons().container().appendTo($('#export_buttonscc'));	
        
        /* Onu Type filter change event*/
        $(document).on('change', '.status_filter', function() {

           $('.status_filter').val() == null ? '' : $('.status_filter').val();
            table.ajax.reload(null, false);

        });
    });

    </script>
</body>

</html>