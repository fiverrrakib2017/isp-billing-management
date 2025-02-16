<?php
include "include/db_connect.php";
include("include/security_token.php");
include("include/users_right.php");
include("include/pop_security.php");
if (isset($_SESSION['uid'])) {
    $ledgr_id = $_SESSION["uid"];
}

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
       <?php $page_title="Reports"; include 'Header.php';?>

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
                        <div class="card shadow">
                            <div class="card-body">
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
                                            <input type="date" class="form-control" id="endDate" value="<?php echo date('Y-m-d');?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-2">
                                            <label for="">Master Ledger</label>
                                            <select class="form-select" id="masterLedger">
                                                <option value="">Select</option>
                                                <option value="1">Income</option>
                                                <option value="2">Expense</option>
                                                <option value="3">Asset</option>
                                                <option value="4">Liabilities</option>
                                                <option value="5">Income Vs Expense</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" id="searchBtn" class="btn btn-primary mt-3">Search Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                   
                                    <div class="table-responsive" id="tableArea">
                                    <!-- <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Ledger</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <b>Main Ledger 1</b><br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sub Ledger Item 1 - <span style="float:right">1000</span><br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sub Ledger Item 2 - <span style="float:right">2000</span><br>
                                                </td>
                                                <td>3000</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>
                                                    <b>Main Ledger 2</b><br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sub Ledger Item 1 - <span style="float:right">1500</span><br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sub Ledger Item 2 - <span style="float:right">2500</span><br>
                                                </td>
                                                <td>4000</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="text-align: right;"><b>Total:</b></td>
                                                <td>7000</td>
                                            </tr>
                                        </tbody>
                                    </table> -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- container-fluid -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Sub Ledger</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group mb-2" style="width:100%">
                                            <label for="">Ledger Name</label>
                                            <select name="ledger_id" id="sub_ledger_id" class="form-select">
                                                <?php
                                                if ($ledgr = $con->query("SELECT * FROM ledger")) {

                                                    while ($rowsitm = $ledgr->fetch_array()) {
                                                        $ldgritmsID = $rowsitm["id"];
                                                        $ledger_name = $rowsitm["ledger_name"];
                                                        echo '<option value="' . $ldgritmsID . '">' . $ledger_name . '</option>';
                                                    }
                                                }


                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="">Sub Ledger Name</label>
                                            <input id="item_name" type="text" class="form-control" placeholder="Enter Item Name">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="">Description</label>
                                            <input id="subLedgerDescription" type="text" class="form-control" name="description" placeholder="description">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button id="addSubLedgerBtn" type="submit" class="btn btn-primary">Add Sub Ledger</button>
                            </div>
                        </div>
                    </div>
                </div>
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
        $(document).ready(function() {
            $(document).on('click', '#searchBtn', function() {
                var masterLedger = $('#masterLedger').val();
                var fromDate = $('#fromDate').val();
                var endDate = $('#endDate').val();

                if (fromDate.length == 0) {
                    toastr.error("From Date is Require");
                } else if (endDate.length == 0) {
                    toastr.error("To Date is Require");
                } else if (masterLedger.length == 0) {
                    toastr.error("Please Select Ledger");
                } else {
                    $("#searchBtn").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                    
                    $.ajax({
                        type: 'POST',
                        data: {
                            masterLedger: masterLedger,
                            fromDate: fromDate,
                            endDate: endDate,
                            getReport: 0,
                        },
                        url: "include/transactions_server.php",
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
        });

        function printTable() {
            var divToPrint = document.getElementsByClassName('report_table');
            var newWin = window.open('', '_blank');
            newWin.document.write('<html><head><title>Customer</title>');
            newWin.document.write('<style>');
            newWin.document.write('table { width: 100%; border-collapse: collapse; }');
            newWin.document.write('table, th, td { border: 1px solid black; padding: 10px; text-align: left; }');
            newWin.document.write('a { text-decoration: none; color: black; }');
            newWin.document.write('</style></head><body>');
            newWin.document.write(divToPrint.outerHTML);
            newWin.document.write('</body></html>');
            newWin.document.close();
            newWin.focus();
            newWin.print();
            newWin.close();
        }
    </script>


</body>

</html>