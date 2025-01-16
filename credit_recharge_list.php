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
    <?php include 'style.php';?>
    <style>
/* @media print {
    body {
        visibility: hidden;
    }

    #customers_table, #customers_table * {
        visibility: visible;
    }

    #customers_table {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }

    th, td {
        padding: 10px;
        text-align: left;
    }

    a {
        text-decoration: none;
        color: black;
    }

    button {
        display: none;
    }
} */
</style>
</head>

<body data-sidebar="dark">



    <!-- Begin page -->
    <div id="layout-wrapper">

       <?php $page_title="Credit Recharge List"; include 'Header.php';?>

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
                                            <p class="text-primary mb-0 hover-cursor">Credit Recharge List</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <!-- <button data-bs-toggle="modal" data-bs-target="#addCustomerModal" class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px" id="addBtn" style="margin-bottom: 12px;">&nbsp;&nbsp;New customer</button> -->
                                </div>

                               
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <div class="table-responsive ">
                                        <table id="customers_table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Customer Username</th>
                                                    <th>Phone Number</th>
                                                    <th>Recharged</th>
                                                    <th>Total Paid</th>
                                                    <th>Total Due</th>
                                                    <th>Recharge By</th>
                                                </tr>
                                            </thead>
                                            <tbody id="customer-data"></tbody>
                                            <tfoot id="total-footer"> </tfoot>
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
    <!-- JAVASCRIPT -->
    <?php include 'script.php';?>
    <script type="text/javascript">
        var from_date_filter = '<label style="margin-left: 10px;">';
        from_date_filter += '<input type="date" id="from_date" class="form-control from_date_filter">';
        from_date_filter += '</input></label>';

        var to_date_filter = '<label style="margin-left: 10px;">';
        to_date_filter += '<input type="date" id="to_date" class="form-control to_date_filter">';
        to_date_filter += '</input></label>';

        var export_button = '<button style="margin-left: 10px;" class="btn btn-success" id="export_to_excel">Export</button>';

        setTimeout(() => {
            $('.dataTables_length').append(from_date_filter);
            $('.dataTables_length').append(to_date_filter);
            $('.dataTables_length').append(export_button);
        }, 500);
       
        show_credit_recharge_list();
        function show_credit_recharge_list(){
            $.ajax({
                url: 'include/customer_recharge_server.php?get_credit_recharge_list=true', 
                type: 'GET',
                data: function(d) {
                    d.from_date = $('.from_date_filter').val(); 
                    d.to_date = $('.to_date_filter').val(); 
                },
                dataType: 'json',
                success: function (response) {
                    $('#customer-data').html(response.rows);
                    $('#total-footer').html(response.footer); 
                    $('#customers_table').DataTable();
                },
                error: function () {
                    alert('Failed to load customer data.');
                },
            });
        }
        /* Apply date filter*/
        // $('#from_date, #to_date').on('change', function() {
        //     //show_credit_recharge_list();
        //     alert('okkkk');
        // });
        $(document).on('change','#from_date',function(){
            show_credit_recharge_list();
        });
        $(document).on('change','#to_date',function(){
            show_credit_recharge_list();
        });
        function printTable() {
            var divToPrint = document.getElementById('customers_table');
            var newWin = window.open('', '_blank');
            newWin.document.write('<html><head><title>Print Table</title>');
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



        $(document).on('click','#export_to_excel',function(){
                    let csvContent = "data:text/csv;charset=utf-8,";
                
                /* Add header row*/
                csvContent += [
                     'Username', 'Phone Number', 'Recharged', 'Total Paid', 'Total Due'
                ].join(",") + "\n";
                
                /*Add data rows*/ 
                $('#customers_table tbody tr').each(function() {
                    let row = [];
                    $(this).find('td').each(function() {
                        row.push($(this).text().trim());
                    });
                    csvContent += row.join(",") + "\n";
                });

                /* Create a link element and simulate click to download the CSV file*/
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