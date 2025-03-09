<?php
include 'include/security_token.php';
include 'include/db_connect.php';
include 'include/pop_security.php';
include 'include/users_right.php';

// $bank_transaction = $con->query("SELECT  b.id, b.bank_name AS bank_name,
//             COALESCE(SUM(CASE WHEN bt.transaction_type = 'credit' THEN bt.amount ELSE 0 END), 0) AS total_credit,
//             COALESCE(SUM(CASE WHEN bt.transaction_type = 'debit' THEN bt.amount ELSE 0 END), 0) AS total_debit,

//             (COALESCE(SUM(CASE WHEN bt.transaction_type = 'debit' THEN bt.amount ELSE 0 END),0)-
//              COALESCE(SUM(CASE WHEN bt.transaction_type = 'credit' THEN bt.amount ELSE 0 END), 0)) AS balance

//         FROM banks b
//         LEFT JOIN bank_transactions bt ON b.id = bt.bank_id
//         GROUP BY b.id, b.bank_name");
$bank_transaction = $con->query("SELECT 
            bt.id,
            b.bank_name AS bank_name,
            bt.transaction_type,
            bt.amount,
            bt.transaction_date,
            bt.description
        FROM bank_transactions bt
        JOIN banks b ON bt.bank_id = b.id
        ORDER BY bt.transaction_date ASC");
$balances = [];
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

        <?php $page_title = 'Bank Transaction';
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
                                            <p class="text-primary mb-0 hover-cursor">Bank Transaction</p>
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
                                <div class="card-header bg-white">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group mb-2">
                                                <label for="">From Date</label>
                                                <input type="date" class="form-control" id="fromDate">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-2">
                                                <label for="">To Date</label>
                                                <input type="date" class="form-control" id="endDate"
                                                    value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-2">
                                                <label for="">Bank Account</label>
                                                <select class="form-select" id="bank_id">
                                                    <option value="">Select</option>
                                                    <?php
                                                    if ($get_all_bank = $con->query('SELECT * FROM banks')) {
                                                        while ($rows = $get_all_bank->fetch_array()) {
                                                            echo '<option value="' . $rows['id'] . '">' . $rows['bank_name'] . '</option>';
                                                        }
                                                    }
                                                    
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" id="searchBtn" class="btn btn-primary "
                                                style="margin-top: 20px;">Search Now</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body" id="tableArea">
                                    
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
    <!-- Add Modal -->
    <div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content col-md-12">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span class="mdi mdi-account-check mdi-18px"></span>
                        &nbsp;Create Bank</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="include/bank_server.php?add_bank=true" method="POST" enctype="multipart/form-data">
                        <div class="form-group mb-2">
                            <label>Bank Name</label>
                            <input name="bank_name" placeholder="Enter Bank Name" class="form-control"
                                type="text">
                        </div>
                        <div class="form-group mb-2">
                            <label>Branch Name</label>
                            <input name="branch_name" placeholder="Enter Branch Name" class="form-control"
                                type="text">
                        </div>
                        <div class="form-group mb-2">
                            <label>Account Number</label>
                            <input name="account_number" placeholder="Enter Account Number" class="form-control"
                                type="text">
                        </div>
                        <div class="modal-footer ">
                            <button data-bs-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                            <button type="submit" class="btn btn-success">Save Bank</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade bs-example-modal-lg" id="editModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content col-md-12">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span
                            class="mdi mdi-account-check mdi-18px"></span> &nbsp;Update Bank</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="include/bank_server.php?update_bank=true" method="POST"
                        enctype="multipart/form-data">
                        <div class="form-group mb-2">
                            <label>Bank Name</label>
                            <input name="id" class="d-none" type="text">
                            <input name="bank_name" placeholder="Enter Bank Name" class="form-control"
                                type="text">
                        </div>
                        <div class="form-group mb-2">
                            <label>Branch Name</label>
                            <input name="branch_name" placeholder="Enter Branch Name" class="form-control"
                                type="text">
                        </div>
                        <div class="form-group mb-2">
                            <label>Account Number</label>
                            <input name="account_number" placeholder="Enter Account Number" class="form-control"
                                type="text">
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
    <div class="rightbar-overlay"></div>
    <?php include 'script.php'; ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#bank_id").select2();

        });
        $(document).on('click', '#searchBtn', function() {
            var bank_id = $('#bank_id').val();
            var fromDate = $('#fromDate').val();
            var endDate = $('#endDate').val();

            if (fromDate.length == 0) {
                toastr.error("From Date is Require");
            } else if (endDate.length == 0) {
                toastr.error("To Date is Require");
            } else if (bank_id.length == 0) {
                toastr.error("Please Select Bank");
            } else {
                $("#searchBtn").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    type: 'POST',
                    data: {
                        bank_id: bank_id,
                        fromDate: fromDate,
                        endDate: endDate,
                        getReport: 1,
                    },
                    url: "include/bank_server.php",
                    success: function(response) {
                        $("#searchBtn").html('Search Now');
                        $('#tableArea').html(response);
                    },
                    error: function(xhr, status, error) {
                        // handle the error response
                        console.log(error);
                    }
                });
            }

        });
    </script>
</body>

</html>
