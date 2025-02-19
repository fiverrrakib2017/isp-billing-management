<?php
include("include/security_token.php");
include("include/db_connect.php");
include("include/pop_security.php");
include("include/users_right.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
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

        <?php $page_title = 'Purchase Invoice List'; include 'Header.php';?>

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
                                        
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <a href="purchase.php" class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px" style="margin-bottom: 12px;">&nbsp;&nbsp;New Invoice </a>
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
                                    <div class="col-md-6 float-md-right grid-margin-sm-0">
                                        <div class="form-group">

                                        </div>
                                    </div>
                                    <div class="table-responsive ">
                                        <table id="invoice-table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Invoice id</th>
                                                    <th>Supplier Name</th>
                                                    <th>Sub Total</th>
                                                    <th>Discount</th>
                                                    <th>Total Due</th>
                                                    <th>Grand Total</th>
                                                    <th>Status</th>
                                                    <th>Invoice Date</th>
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

            <?php include 'Footer.php';?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
     
    <div class="modal fade bs-example-modal-lg" id="payDueModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span
                    class="mdi mdi-account-check mdi-18px"></span> &nbsp;Due Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="include/purchase_server.php?add_due_payment=true" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="invoice_id" id="invoice_id">
                    <div class="form-group mb-2">
                        <label>Transaction Number</label>
                        <input name="transaction_number" class="form-control" type="text" readonly>
                    </div>
                    <div class="form-group mb-2">
                        <label>Due Amount</label>
                        <input readonly name="due_amount" placeholder="Enter Due Amount" class="form-control" type="text" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Paid Amount</label>
                        <input name="paid_amount" placeholder="Enter Paid Amount" class="form-control" type="text" required>
                    </div>   
                    <div class="form-group mb-2">
                        <label>Select Accounts</label>
                        <select type="text" class="form-control" id="sub_ledger_id" name="sub_ledger_id"
                            style="width: 100%;">
                            <?php
                            if ($ledgr = $con->query('SELECT * FROM ledger')) {
                                echo '<option value="">Select</option>';
                            
                                while ($rowsitm = $ledgr->fetch_array()) {
                                    $ldgritmsID = $rowsitm['id'];
                                    $ledger_name = $rowsitm['ledger_name'];
                            
                                    echo '<optgroup label="' . $ledger_name . '">';
                            
                                    // Sub Ledger items list
                                    if ($ledgrsubitm = $con->query("SELECT * FROM legder_sub WHERE ledger_id='$ldgritmsID'")) {
                                        while ($rowssb = $ledgrsubitm->fetch_array()) {
                                            $sub_ldgrid = $rowssb['id'];
                                            $ldgr_items = $rowssb['item_name'];
                            
                                            echo '<option value="' . $sub_ldgrid . '">' . $ldgr_items . '</option>';
                                        }
                                    }
                            
                                    echo '</optgroup>';
                                }
                            }
                            ?>
                        </select>
                    </div>                 
                    <div class="form-group mb-2">
                        <label>Transaction Date</label>
                        <input name="transaction_date" class="form-control" type="date" required>
                    </div>                
                    <div class="form-group mb-2">
                        <label>Transaction Notes</label>
                        <input name="transaction_note" class="form-control" type="text" placeholder="Enter Transaction Notes" required>
                    </div>                
                    <div class="modal-footer ">
                        <button data-bs-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
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
    <!-- JAVASCRIPT -->
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
                    url: 'include/purchase_server.php',
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
                        url: 'include/purchase_server.php',
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
            /*Paid Due Amount Script*/
            $(document).on('click',"button[name='due_paid_button']",function(){
                var id=$(this).data('id');
                $.ajax({
                    type: 'GET', 
                    url: 'include/purchase_server.php?get_invoice=true',
                    data: { invoice_id: id }, 
                    dataType:'json',
                    success: function(response) {
                        if (response) {
                            $("#payDueModal").modal('show');
                            $("#payDueModal #invoice_id").val(response.id); 
                            $("#payDueModal input[name='transaction_number']").val(response.transaction_number);
                            $("#payDueModal input[name='due_amount']").val(response.total_due);
                        } else {
                            toastr.error("No data found for this invoice!");
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        toastr.error("Error deleting item! " + error);
                    }
                });
            });
            $('#payDueModal').on('shown.bs.modal', function () {
                if (!$('#sub_ledger_id').hasClass("select2-hidden-accessible")) {
                    $('#sub_ledger_id').select2({
                        dropdownParent: $('#payDueModal')
                    });
                }
            });
            $('#payDueModal form').submit(function(e){
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();
                $.ajax({
                type:'POST',
                'url':url,
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if(response.success){
                        toastr.success(response.message);
                        $("#payDueModal").modal('hide');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }else{
                        toastr.error(response.message);
                    }
                },


                error: function (xhr, status, error) {
                    /** Handle  errors **/
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]); 
                        });
                    }
                }
                });
            });
            
        });



      
    </script>
</body>

</html>