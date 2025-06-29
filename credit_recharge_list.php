<?php
include 'include/security_token.php';
include 'include/db_connect.php';
include 'include/pop_security.php';
include 'include/users_right.php';
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'style.php'; ?>
    </style>
</head>

<body data-sidebar="dark">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php $page_title = 'Credit Recharge List';
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
                                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<a
                                                    href="index.php">Dashboard</a>&nbsp;/&nbsp;
                                            </p>
                                            <p class="text-primary mb-0 hover-cursor">Credit Recharge List</p>
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
                                <div class="card-body">

                                    <div class="table-responsive ">
                                      <table id="customers_table" class="table table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Customer Username</th>
                                                <th>POP/Branch</th>
                                                <th>Area</th>
                                                <th>Phone Number</th>
                                                <th>Recharged</th>
                                                <th>Total Paid</th>
                                                <th>Total Due</th>
                                                <th>Month</th> 
                                            </tr>
                                        </thead>
    <?php
    $sql = "SELECT 
    c.id AS customer_id, 
    c.pop AS pop_id, 
    c.area AS area_id, 
    c.username, 
    p.pop AS pop_name,
    a.name AS area_name, 
    c.mobile, 
    COALESCE(SUM(CASE WHEN cr.type != '4' THEN cr.purchase_price ELSE 0 END), 0) AS total_recharge,
    COALESCE(SUM(CASE WHEN cr.type != '0' THEN cr.purchase_price ELSE 0 END), 0) AS total_paid,
    (
        COALESCE(SUM(CASE WHEN cr.type != '4' THEN cr.purchase_price ELSE 0 END), 0) - 
        COALESCE(SUM(CASE WHEN cr.type != '0' THEN cr.purchase_price ELSE 0 END), 0)
    ) AS total_due,
    DATE_FORMAT(DATE_SUB(MAX(cr.datetm), INTERVAL 1 MONTH), '%m') AS recharge_month
FROM 
    customers c
LEFT JOIN 
    customer_rechrg cr ON c.id = cr.customer_id
LEFT JOIN 
    add_pop p ON c.pop = p.id
LEFT JOIN 
    area_list a ON c.area = a.id
GROUP BY 
    c.id
HAVING 
    total_due > 0
";

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $monthNum = (int)$row['recharge_month'];
            $monthName = DateTime::createFromFormat('!m', $monthNum)->format('F'); 

            echo "<tr>
                    <td><a href='profile.php?clid={$row['customer_id']}'>{$row['username']}</a></td>
                
                    <td>{$row['pop_name']}</td>
                    <td>{$row['area_name']}</td>
                    <td>{$row['mobile']}</td>
                    <td>{$row['total_recharge']}</td>
                    <td>{$row['total_paid']}</td>
                    <td>{$row['total_due']}</td>
                    <td>{$monthName}</td>
                </tr>";
        }
    } else {
        echo '<tr><td colspan="6">No results found.</td></tr>';
    }
    ?>
</table>



                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button class="btn btn-danger print-btn" onclick="printTable()"><i
                                            class="fa fa-print"></i></button>

                                    <button class="btn btn btn-success" id="export_to_excel">Export <img
                                            src="https://img.icons8.com/?size=100&id=117561&format=png&color=000000"
                                            class="img-fluid icon-img" style="height: 20px !important;"></button>

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
        $("#customers_table").DataTable();



        function printTable() {
            var printContents = document.getElementById('customers_table').outerHTML;
            var originalContents = document.body.innerHTML;

            var newWindow = window.open('', '', 'width=800, height=600');
            newWindow.document.write('<html><head><title>Print Table</title>');
            newWindow.document.write('<style>');
            newWindow.document.write('table {width: 100%; border-collapse: collapse; border: 1px solid black;}');
            newWindow.document.write('th, td {border: 2px dotted #ababab; padding: 8px; text-align: left;}');
            newWindow.document.write('</style></head><body>');

            newWindow.document.write('<div class="header">');
            newWindow.document.write(
                '<img src="http://103.146.16.154/assets/images/it-fast.png" class="logo" alt="Company Logo" style="display:block; margin:auto; height:50px;">'
            );
            newWindow.document.write('<h2 style="text-align:center; color: #000;">Star Communication</h2>');
            newWindow.document.write('<p style="text-align:center;">Customer Recharge Report</p>');
            newWindow.document.write('</div>');

            newWindow.document.write(printContents);
            newWindow.document.write('</body></html>');

            newWindow.document.close();
            newWindow.print();
            newWindow.close();
        }

        $(document).on('click', '#export_to_excel', function() {
            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += [
                'Username', 'Phone Number', 'Recharged', 'Total Paid', 'Total Due'
            ].join(",") + "\n";
            $('#customers_table tbody tr').each(function() {
                let row = [];
                $(this).find('td').each(function() {
                    row.push($(this).text().trim());
                });
                csvContent += row.join(",") + "\n";
            });
            let encodedUri = encodeURI(csvContent);
            let link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "customers.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    </script>

</body>

</html>
