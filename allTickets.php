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
	
	<?php include 'style.php'; ?>
	<style>
        /* div#tickets_datatable_filter {
            display: none;
        }
        div#tickets_datatable_length {
            display: flex;
        }
        .customer_filter {
            width: 400px !important;
        }
        @media (min-width: 600px) {
            .customer_filter {
                width: 200px !important; 
            }
            
        } */
    </style>



</head>

<body data-sidebar="dark">



    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php
        $page_title="Tickets";
        include 'Header.php'; 
        ?>

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
                                   
									<!-- <a href="create_ticket.php" class="btn btn-primary mt-2 mb-2 mt-xl-0 mdi mdi-account-plus mdi-18px" >&nbsp;&nbsp;New Ticket</a> -->
									<button type="button" class="btn btn-primary mt-2 mb-2 mt-xl-0 mdi mdi-account-plus mdi-18px"  data-bs-toggle="modal" data-bs-target="#ticketModal">&nbsp;&nbsp;New Ticket</button>
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

            <?php include 'Footer.php';?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


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
                            <input type="text" name="ticket_id" value="" required>
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

    <?php require 'modal/tickets_modal.php';?>

    <?php include 'script.php'; ?>
    <script src="js/tickets.js"></script>
    <script type="text/javascript">
        var table;
        $(document).ready(function(){
            var received_pop_id = "<?php echo isset($_GET['pop_id']) ? $_GET['pop_id'] : ''; ?>";
            var received_area_id = "<?php echo isset($_GET['area_id']) ? $_GET['area_id'] : ''; ?>";

            if (received_pop_id.length > 0 || received_area_id.length > 0) {
                console.log('yes');
            }else{
                loadAreaOptions();  
            }
           

            function loadAreaOptions() {
                $.ajax({
                    url: 'include/area_server.php?get_area_data=1', 
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success==true) {
                            var popOptions = '<label style="margin-left: 10px;"> ';
                            popOptions += '<select class="area_filter form-select select2">';
                            popOptions += '<option value="">--Select Area--</option>';
                            
                        
                            $.each(response.data, function(key, data) {
                                popOptions += '<option value="'+data.id+'">'+data.name+'</option>';
                            });

                            popOptions += '</select></label>';
                            
                            setTimeout(() => {
                                $('.dataTables_length').append(popOptions);
                                $('.select2').select2();
                            }, 500);

                            var status_filter = '<label style="margin-left: 10px;"> ';
                            status_filter += '<select class="status_filter form-select select2">';
                            status_filter += '<option value="">--Select Status--</option>';
                            status_filter += ' <option value="Active">Active</option>';
                            status_filter += '<option value="New" >New</option>';
                            status_filter += '<option value="Open">Open</option>';
                            status_filter += '<option value="Complete">Complete</option>';
                            status_filter += ' <option value="Close">Close</option>';
                            status_filter += '</select></label>';


                            setTimeout(() => {
                                $('.dataTables_length').parent().removeClass(
                                    'col-sm-12 col-md-6');
                                $('.dataTables_filter').parent().removeClass(
                                    'col-sm-12 col-md-6');
                            $('.dataTables_length').append(status_filter);
                            $('.select2').select2();
                            }, 500);
                        }
                       
                    }
                });
            }
           
            
            table=$('#tickets_datatable').DataTable( {
               "searching": true,
                "paging": true,
                "info": false,
                "lengthChange":true ,
                "processing"		: false,
                "serverSide"		: false,
                "zeroRecords":    "No matching records found",
                "ajax"				: {
                    url			: "include/tickets_server.php?get_tickets_data=1",
                    type		: 'GET',
                    data: function(d) {
                        d.pop_id = received_pop_id.length > 0 ? received_pop_id : $('.pop_filter').val();
                        d.area_id = received_area_id.length > 0 ? received_area_id : $('.area_filter').val();
                      
                    },
                    beforeSend: function() {
                        $(".dataTables_empty").html('<img src="assets/images/loading.gif" style="background-color: transparent"/>');
                    },
                    complete: function() {
                        // Hide loading spinner
                        //$('#tickets_datatable').unblock();
                    },
                },
                "order": [[0, 'desc']],
            });
        });
        /* Area filter change event*/
        $(document).on('change', '.area_filter', function(){
            // var area_filter_result = $('.area_filter').val() || '';
            // table.columns(7).search(area_filter_result).draw();
            table.ajax.reload(null, false);
        });          
        /* Status filter change event*/
        $(document).on('change', '.status_filter', function(){
            var status_filter_result = $('.status_filter').val() || '';
            table.columns(1).search(status_filter_result).draw();
        });   
        $(document).on('change', '.customer_filter', function(){
            var status_filter_result = $('.customer_filter').val() || '';
            table.columns(4).search(status_filter_result).draw();
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
        

        /*** Add ticket Modal Script****/
         ticket_modal();
         loadCustomers();
         ticket_assign();
         ticket_complain_type();
    </script>
</body>

</html>