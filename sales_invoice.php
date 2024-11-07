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
    <?php include "style.php";?>
</head>

<body data-sidebar="dark">



    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php $page_title="Sales Invoice"; include 'Header.php';?>

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
                                          
                                           
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <a href="sale.php" class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px" style="margin-bottom: 12px;">&nbsp;&nbsp;New Invoice </a>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row d-flex">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="start_date">Start Date:</label>
                                                <input type="date" id="start_date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="end_date">End Date:</label>
                                                <input type="date" id="end_date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mt-1">
                                                <button id="filter_invoice_btn" class="btn btn-primary mt-3">Search Now</button>
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive ">
                                        <table id="invoice-table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Invoice id</th>
                                                    <th>Customer Name</th>
                                                    <th>Sub Total</th>
                                                    <th>Paid Amount</th>
                                                    <th>Discount</th>
                                                    <th>Due Balance</th>
                                                    <th>Grand Total</th>
                                                    <th>Status</th>
                                                    <th>Create Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="invoice-list">
                                             

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
                                Development <i class="mdi mdi-heart text-danger"></i><a target="__blank" href="https://facebook.com/rakib56789">Rakib Mahmud</a>
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
    <div id="deleteModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header flex-column">
                    <div class="icon-box">
                        <i class="fa fa-trash"></i>
                    </div>
                    <h4 class="modal-title w-100">Are you sure?</h4>
                    <h4 class="modal-title w-100 " id="DeleteId">1</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="True">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Do you really want to delete these records? This process cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="DeleteConfirm">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <?php include 'script.php';?>
    <script type="text/javascript">
        $(document).ready(function(){
            //var table = $('#invoice-table').DataTable();
             /* Fetch initial data*/
             __fetch_invoice_data();

            /* Filter button click event*/
            $('#filter_invoice_btn').click(function() {
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();

                if (startDate.length=='') {
                    toastr.error("Please Select Date"); 
                }
                else if (endDate.length=='') {
                    toastr.error("Please Select Date"); 
                }else{
                    __fetch_invoice_data(startDate,endDate);
                }
               
            });
            function __fetch_invoice_data(startDate,endDate) {

               
               
                $("#filter_invoice_btn").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...');
                $("#filter_invoice_btn").prop('disabled', true);

                $.ajax({
                    url: 'include/sale_server.php',
                    type: 'GET',
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        fetch_invoice:true,
                    },
                    success: function(response) {
                        $('#invoice-list').html(response);
                        $("#invoice-table").DataTable();
                        $('#filter_invoice_btn').html('Search');
                        $('#filter_invoice_btn').prop('disabled', false);
                    }
                });
            }
            /*Delete Script*/
            $(document).on('click',"button[name='delete_button']",function(){
                var id=$(this).data('id');
                if (confirm("Are you sure you want to delete this item?")) {
                   
                    $.ajax({
                        type: 'POST', 
                        url: 'include/sale_server.php',
                        data: { delete_invoice: true, invoice_id: id }, 
                        dataType:'json',
                        success: function(response) {
                            if (response.success) {
                                toastr.success("Deleted successfully!");
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            toastr.error("Error deleting item! " + error);
                        }
                    });
                }
            });
            
        });
    </script>
    
</body>

</html>