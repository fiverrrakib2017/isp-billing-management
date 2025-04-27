<?php
 include 'include/security_token.php';
 include 'include/db_connect.php';
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

         <?php $page_title = 'Message Report';
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
                     <div class="col-md-12 ">
                <div class="card">
                <div class="card-body  shadow">
                    <form class="row g-3 align-items-end" id="search_box">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="from_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input name="start_date" id="start_date" class="form-control" type="date" placeholder="Start Date" required>
                                   
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                <input name="end_date" id="end_date" class="form-control" type="date" placeholder="End Date" required>
                                   
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pop_id" class="form-label">POP/Branch Name <span class="text-danger">*</span></label>
                                <select name="pop_id" id="pop_id" class="form-select" style="width: 100%;">
                                    <option>---Select---</option>
                                    <?php 
                                    if ($allPOPuSR = $con->query("SELECT * FROM add_pop WHERE user_type=1")) {
                                        while ($rows = $allPOPuSR->fetch_array()) {
                                            echo '<option value="'.$rows['id'].'">'.$rows['pop'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="area" class="form-label">Area <span class="text-danger">*</span></label>
                                <select name="area" id="area" class="form-select" style="width: 100%;">
                                    <option>---Select---</option> 
                                </select>
                            </div>
                        </div>

                       

                        <div class="col-md-2 d-grid">
                            <div class="form-group">
                                <button type="button" name="search_btn" class="btn btn-success">
                                    <i class="fas fa-search me-1"></i> Search Now
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                    <div class="card-body d-none"  id="print_area">

                       
                        
                        <div class="table-responsive responsive-table">

                            <table id="datatable1" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>

                                       
                                        <th class="">ID.</th>
                                        <th class="">Username</th>
                                        <th class="">POP/Branch</th>
                                        <th class="">Area</th>
                                        <th class="">Phone Number</th>
                                        <th class="">Status</th>
                                        <th class="">Message</th>
                                        <th class="">Send</th>
                                    </tr>
                                </thead>
                                <tbody id="_data">
                                    <tr id="no-data">
                                        <td colspan="10" class="text-center">No data available</td>
                                    </tr>
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


     <!-- Right bar overlay-->
     <div class="rightbar-overlay"></div>


     <!-- JAVASCRIPT -->
     <?php include 'script.php'; ?>
     <script type="text/javascript">
        $(document).ready(function(){
         
            $('#pop_id').select2({
                placeholder: 'Select POP/Branch',
                allowClear: false
            });
            $('#area').select2({
                placeholder: 'Select Area',
                allowClear: false
            });
            $('#customer_status').select2({
                placeholder: 'Select Status',
                allowClear: false
            });
           
            $("select[name='pop_id']").on('change', function() {
                var pop_id = $(this).val();
                $.ajax({
                    url: 'include/add_pop.php',
                    type: 'POST',
                    data: {pop_id: pop_id},
                    success: function(data) {
                        console.log(data);
                        $('#area').html(data).select2({
                            placeholder: 'Select Area',
                            allowClear: false
                        });
                    }
                });
            });

            /***Load Customer **/
            $("button[name='search_btn']").click(function() {
                var button = $(this); 

                button.html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...`);
                button.attr('disabled', true);
                var start_date = $("#start_date").val();
                var end_date = $("#end_date").val();
                var pop_id = $("#pop_id").val();
                var area_id = $("#area").val();
                if ( $.fn.DataTable.isDataTable("#datatable1") ) {
                    $("#datatable1").DataTable().destroy();
                }
                $.ajax({
                    url: 'include/message_server.php?get_sms_logs_data=true',
                    type: 'GET',
                    dataType: 'json',
                    data: {start_date:start_date, end_date:end_date,pop_id: pop_id, area_id: area_id},
                    success: function(response) {
                        if(response.success==true){
                            
                            $("#print_area").removeClass('d-none');
                            $("#_data").html(response.data);
                            $("#datatable1").DataTable({
                                "paging": true,
                                "searching": true,
                                "ordering": true,
                                "info": true
                            });
                           
                        }
                        
                        if(response.success==false) {
                            toastr.error(response.message);
                            $("#_data").html('<tr id="no-data"><td colspan="10" class="text-center">No data available</td></tr>');
                        }
                    },
                    complete: function() {
                        button.html('<i class="fas fa-search me-1"></i> Search Now');
                        button.attr('disabled', false);
                    }
                });
            });
       
        });


     </script>

 </body>

 </html>
