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
                                                    <th>Create Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="invoice-list">
                                                <?php
                                                $sql = "SELECT * FROM purchase ";
                                                $result = mysqli_query($con, $sql);

                                                while ($rows = mysqli_fetch_assoc($result)) {

                                                ?>

                                                    <tr>
                                                        <td><?php echo $rows['id']; ?></td>
                                                        <td>
                                                            <?php
                                                            $client_id = $rows['client_id'];
                                                            $allSupplierData = $con->query("SELECT * FROM suppliers WHERE id=$client_id ");
                                                            while ($supplier = $allSupplierData->fetch_array()) {
                                                                echo $supplier['fullname'] . ' (' . $supplier['company'] . ')';
                                                            }

                                                            ?>
                                                        </td>
                                                        <td><?php echo $rows['sub_total']; ?></td>
                                                        <td><?php echo $rows['grand_total']; ?></td>
                                                        <td>
                                                            <?php

                                                            $date = $rows['date'];
                                                            $formatted_date = date("d F Y", strtotime($date));
                                                            echo $formatted_date;

                                                            ?>
                                                        </td>
                                                        <td>

                                                            <a class="btn-sm btn btn-primary" href="purchase_invoice_edit.php?id=<?php echo $rows['id']; ?>"><i class="fas fa-edit"></i></a>

                                                            <a class="btn-sm btn btn-success" href="invoice/purchase_inv_view.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-eye"></i></a>

                                                            <a class="btn-sm btn btn-danger"  onclick=" return confirm('Are You Sure');" href="purchase_inv_delete.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-trash"></i></a>

                                                        </td>

                                                    </tr>
                                                <?php } ?>
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
            
        });
    </script>
</body>

</html>