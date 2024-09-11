<?php
include("include/security_token.php");

include("include/users_right.php");



?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
	
	<link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">

    <link href="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/toastr/toastr.min.css">
	        
<link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
		
			


</head>

<body data-sidebar="dark">


    <!-- Loader -->
    <!-- <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div> -->

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="index.php" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/it-fast.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/it-fast.png" alt="" height="17">
                            </span>
                        </a>

                        <a href="index.php" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="assets/images/it-fast.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/it-fast.png" alt="" height="36">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="mdi mdi-menu"></i>
                    </button>

                    <div class="d-none d-sm-block ms-2">
                        <h4 class="page-title">Tickets</h4>
                    </div>
                </div>



                <div class="d-flex">





                    <div class="dropdown d-none d-md-block me-2">
                        <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="font-size-16">
                                <?php if (isset($_SESSION['fullname'])) {
                                    echo $_SESSION['fullname'];
                                } ?>
                            </span>
                        </button>
                    </div>


                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="profileImages/avatar.png" alt="Header Avatar">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block me-2">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ion ion-md-notifications"></i>
                            <span class="badge bg-danger rounded-pill">3</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="m-0 font-size-16"> Notification (3) </h5>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-success rounded-circle font-size-16">
                                                <i class="mdi mdi-cart-outline"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mt-0 font-size-15 mb-1">Your order is placed</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">Dummy text of the printing and typesetting industry.</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-warning rounded-circle font-size-16">
                                                <i class="mdi mdi-message-text-outline"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mt-0 font-size-15 mb-1">New Message received</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">You have 87 unread messages</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-info rounded-circle font-size-16">
                                                <i class="mdi mdi-glass-cocktail"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mt-0 font-size-15 mb-1">Your item is shipped</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">It is a long established fact that a reader will</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>
                            <div class="p-2 border-top">
                                <div class="d-grid">
                                    <a class="btn btn-sm btn-link font-size-14  text-center" href="javascript:void(0)">
                                        View all
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>

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
                                            <p class="text-primary mb-0 hover-cursor">Ticket</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                   
									<a href="create_ticket.php" class="btn btn-primary mt-2 mb-2 mt-xl-0 mdi mdi-account-plus mdi-18px" >&nbsp;&nbsp;New Ticket</a>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <!-- <div id="export_buttonscc" class="mb-3"></div> -->
                                    <div class="table-responsive">
                                        <table id="tickets_datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead class="bg-success text-white" style="background-color: #2c845f !important;">
                                                <tr>
                                                    <th>No.</th> 
                                                    <th>Status</th> 
                                                    <th>Created</th>
                                                    <th>Priority</th>
                                                    <th>Customer Name</th>
                                                    <th>Phone Number</th>
                                                    <th>Issues</th>
                                                    <th>Pop/Area</th>                                                   
                                                    <th>Assigned Team</th>
                                                    <th>Ticket For</th>
                                                    <th>Acctual Work</th>
                                                    <th>Percentage</th>
                                                    <th>Note</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

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

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © IT-FAST.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Development <i class="mdi mdi-heart text-danger"></i><a href="https://facebook.com/rakib56789">Rakib Mahmud</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title px-3 py-4">
                <a href="javascript:void(0);" class="right-bar-toggle float-end">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
                <h5 class="m-0">Settings</h5>
            </div>

            <!-- Settings -->
            <hr class="mt-0">
            <h6 class="text-center mb-0">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="Layouts-1">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch">
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="Layouts-2">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css">
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="Layouts-3">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css">
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>


            </div>

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <div class="modal fade" id="settings_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header  bg-info">
                    <h5 class="modal-title text-white " id="exampleModalLabel">Ticket Settings <i class="fas fa-cog"></i></h5>
                    
                </div>
                <form action="include/tickets_server.php?add_ticket_settings=true" method="POST" id="settings_modal_form">
                    <div class="modal-body">
                        <div class="form-group d-none">
                            <input type="text" name="ticket_id" value="">
                        </div>
                        <div class="form-group mb-2">
                               <label>Ticket Status</label>
                            <select id="ticket_type" name="ticket_type" class="form-select" required>
                                <option value="">Select</option>
                                <option value="Active">Active</option>
                                <option value="New" >New</option>
                                <option value="Open">Open</option>
                                <option value="Complete">Complete</option>
                                <option value="Close">Close</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Progress</label>
                                <select id="progress" name="progress" class="form-select" required>
                                    <option value="">Select</option>
                                    <option value="0%">0%</option>
                                    <option value="15%">15%</option>
                                    <option value="25%">25%</option>
                                    <option value="35%">35%</option>
                                    <option value="45%">45%</option>
                                    <option value="55%">55%</option>
                                    <option value="65%">65%</option>
                                    <option value="75%">75%</option>
                                    <option value="85%">85%</option>
                                    <option value="95%">95%</option>
                                    <option value="100%">100%</option>
                                </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Assigned To</label>
                            <select name="assigned" id="assigned" class="form-select" required>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Write Comment</label> 
                            <textarea class="form-control"  rows="5" name="comment" placeholder="Enter Your Comment" style="height: 89px;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
	<script src="assets/libs/select2/js/select2.min.js"></script>
    <script src="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/libs/jszip/jszip.min.js"></script>
    <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript" src="js/toastr/toastr.min.js"></script>
    <script type="text/javascript" src="js/toastr/toastr.init.js"></script>
    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>
        <!-- <script src="assets/js/pages/form-advanced.init.js"></script> -->

    <script src="assets/js/app.js"></script>
    <script type="text/javascript">
        var table;
        $(document).ready(function(){
            function loadAreaOptions() {
                $.ajax({
                    url: 'include/area_server.php?get_area_data=1', 
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success==true) {
                            var popOptions = '<label style="margin-left: 20px;"> ';
                            popOptions += '<select class="area_filter form-select">';
                            popOptions += '<option value="">--Select Area--</option>';
                            
                        
                            $.each(response.data, function(key, data) {
                                popOptions += '<option value="'+data.id+'">'+data.name+'</option>';
                            });

                            popOptions += '</select></label>';
                            
                            setTimeout(() => {
                                $('.dataTables_length').append(popOptions);
                                $('.area_filter').select2(); 
                            }, 500);
                        }
                       
                    }
                });
            }
            loadAreaOptions();

                table=$('#tickets_datatable').DataTable( {
                    "searching": true,
                    "paging": true,
                    "info": false,
                    "lengthChange":true ,
                    "processing"		: true,
                    "serverSide"		: true,
                    "zeroRecords":    "No matching records found",
                    "ajax"				: {
                        url			: "include/tickets_server.php?get_tickets_data=1",
                        type		: 'GET',
                    },
                    "order": [[0, 'desc']], 
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
                ]
            });
            //table.buttons().container().appendTo($('#export_buttonscc'));	
        });
         /* POP filter change event*/
        $(document).on('change','.area_filter',function(){
        
        var area_filter_result = $('.area_filter').val() == null ? '' : $('.area_filter').val();

            table.columns(7).search(area_filter_result).draw();
        
        });                   

        $(document).on('click', 'button[name="settings_button"]', function() {
            let dataId=$(this).data('id'); 
            $.ajax({
                url: "include/tickets_server.php?get_single_ticket=true", 
                type: "GET",
                data: { 
                    id:dataId,
                },
                dataType:'json',
                success: function(response) {
                    if (response.success == true) {
                        console.log(response); 
                        $("#settings_modal input[name='ticket_id']").val(response.data.id);
                        $("#settings_modal select[name='ticket_type']").val(response.data.ticket_type);
                        $("#settings_modal #progress").val(response.data.parcent);
                        $("#settings_modal textarea[name='comment']").val(response.data.notes);
                         $("#settings_modal select[name='assigned']").val(response.data.asignto);
                        $("#settings_modal").modal('show');
                    }
                }
            });
            
        });
        __load_assign_option()
        function __load_assign_option(){
            $.ajax({
                url: "include/tickets_server.php?get_working_group=true",
                type: "GET",
                dataType:'json',
                success: function(response) {
                    if (response.success == true) {
                        let assignedSelect = $("#settings_modal select[name='assigned']");
                        assignedSelect.empty();  
                        
                        $.each(response.data, function(index, item) {
                            assignedSelect.append(new Option(item.name, item.id));
                        });
                    } else {
                        console.log("No data found or an error occurred.");
                    }
                }
            });
        }
        $("#settings_modal_form").submit(function(e) {
            e.preventDefault();

            /* Get the submit button */
            var submitBtn = $(this).find('button[type="submit"]');
            var originalBtnText = submitBtn.html();

            submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden"></span>');
            submitBtn.prop('disabled', true);

            var form = $(this);
            var formData = new FormData(this);

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                dataType:'json',
                success: function(response) {
                    if (response.success) {
                        $("#settings_modal").modal('hide');
                        toastr.success(response.message);
                        $('#tickets_datatable').DataTable().ajax.reload();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) { 
                        /* Validation error*/
                        var errors = xhr.responseJSON.errors;

                        /* Loop through the errors and show them using toastr*/
                        $.each(errors, function(field, messages) {
                            $.each(messages, function(index, message) {
                                /* Display each error message*/
                                toastr.error(message); 
                            });
                        });
                    } else {
                        /*General error message*/ 
                        toastr.error('An error occurred. Please try again.');
                    }
                },
                complete: function() {
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);
                }
            });
        });

        $("#customer_ticket_btn").click(function() {
            // Get form values
            var customerId = $("#ticket_customer_id").val();
            var ticketType = $("#ticket_type").val();
            var assignedTo = $("#ticket_assigned").val();
            var ticketFor = $("#ticket_for").val();
            var complainType = $("#ticket_complain_type").val();
            var fromDate = $("#ticket_from_date").val();
            var toDate = $("#ticket_to_date").val();
            if (ticketType.length == 0) {
                toastr.error("Customer Ticket Type is require");
            } else if (assignedTo.length == 0) {
                toastr.error("Customer Assign  is require");
            } else if (ticketFor.length == 0) {
                toastr.error("Please Select Ticket For");
            } else if (complainType.length == 0) {
                toastr.error("Complain Type is require");
            } else if (fromDate.length == 0) {
                toastr.error("From Date is require");
            } else if (toDate.length == 0) {
                toastr.error("To Date is require");
            } else {
                /*Make AJAX request to server*/ 
                $.ajax({
                    url: "include/tickets_server.php", 
                    type: "POST",
                    data: {
                        customer_id: customerId,
                        ticket_type: ticketType,
                        assigned_to: assignedTo,
                        ticket_for: ticketFor,
                        complain_type: complainType,
                        from_date: fromDate,
                        to_date: toDate,
                        addTicketData: 0,
                    },
                    success: function(response) {
                      /* Handle the response from the server*/
                      if (response == 1) {
                            toastr.success("Ticket Added Success");
                            $("#addTicketModal").modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(response);
                        }
                    }
                });
            }

        });
    </script>
</body>

</html>