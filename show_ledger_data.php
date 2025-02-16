<?php
include 'include/db_connect.php';
include 'include/security_token.php';
include 'include/users_right.php';
include 'include/pop_security.php';
$data = [];

// Validate input parameters
if (isset($_GET['id']) && isset($_GET['fromDate']) && isset($_GET['endDate'])) {
    $ledger_id = $_GET['id'];
    $fromDate = $_GET['fromDate'];
    $endDate = $_GET['endDate'];

    // Prepare SQL query to prevent SQL Injection
    $stmt = $con->prepare('SELECT * FROM ledger_transactions WHERE ledger_id = ? AND date BETWEEN ? AND ?');
    $stmt->bind_param('iss', $ledger_id, $fromDate, $endDate);
    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();
}

// Output the data in a readable format
// echo "<pre>";
// print_r($data);
// echo "</pre>";

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
        <?php $page_title = 'Ledger Reports';
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

                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card ledger-card">
                                <div class="card-header bg-primary text-white text-center">
                                    <h4>Ledger: </h4>
                                    <p class="mb-0">From: <strong><?php echo $_GET['fromDate']; ?></strong> | To:
                                        <strong><?php echo $_GET['endDate']; ?></strong></p>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <button type="button" onclick="printTable()" class="btn btn-success">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Accounts Titles And Explanations</th>
                                                    <th>Quantity</th>
                                                    <th>Value</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total_amount = 0;
                                                $i = 1;
                                                foreach ($data as $row) {
                                                    $sub_ledger_id = $row['sub_ledger_id'];
                                                    $stmt = $con->prepare('SELECT * FROM legder_sub WHERE id = ?');
                                                    $stmt->bind_param('i', $sub_ledger_id);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    $rowsss = $result->fetch_assoc();
                                                    $sub_ledger_name = $rowsss['item_name'];
                                                    $total_amount += $row['total'];
                                                    echo '
                                                                                    <tr>
                                                                                        <td>' .
                                                        $i .
                                                        '</td>
                                                                                        <td>' .
                                                        $sub_ledger_name .
                                                        '</td> 
                                                                                        <td>' .
                                                        $row['qty'] .
                                                        '</td>
                                                                                        <td>' .
                                                        $row['value'] .
                                                        '</td>
                                                                                        <td>' .
                                                        $row['total'] .
                                                        '</td>
                                                                                    </tr>
                                                                                    ';
                                                    $i++;
                                                }
                                                ?>

                                                <tr>
                                                    <td colspan="4" class="text-end total-row"><b>Total:</b></td>
                                                    <td class="total-row"><b>৳ <?php echo number_format($total_amount, 2); ?></b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
        

    function printTable() {
        var divToPrint = document.querySelector('.ledger-card'); 
        var newWin = window.open('', '_blank'); 

        newWin.document.write('<html><head><title>Ledger Report</title>');
        newWin.document.write('<style>');
        newWin.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
        newWin.document.write('.ledger-card { width: 100%; padding: 20px; border: 1px solid black; }');
        newWin.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
        newWin.document.write('th, td { border: 1px solid black; padding: 10px; text-align: left; }');
        newWin.document.write('th { background-color: #f2f2f2; }');
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
