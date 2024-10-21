<?php
if (!isset($_SESSION)) {
    session_start();
}
$rootPath = $_SERVER['DOCUMENT_ROOT'];  

$db_connect_path = $rootPath . '/include/db_connect.php';  
$users_right_path = $rootPath . '/include/users_right.php';

if (file_exists($db_connect_path)) {
    require($db_connect_path);
}

if (file_exists($users_right_path)) {
    require($users_right_path);
}

?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>FAST-ISP-BILLING-SOFTWARE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
       
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $url = $protocol . $_SERVER['HTTP_HOST'] . '/style.php';
            
            echo file_get_contents($url);
        
        ?>
</head>

<body data-sidebar="dark">


    <!-- Begin page -->
    <div id="layout-wrapper">

       <?php $page_title="Customers Dues/Unpaid"; include '../Header.php';?>

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
                                            <p class="text-primary mb-0 hover-cursor">Customers</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <!-- <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button data-bs-toggle="modal" data-bs-target="#addCustomerModal" class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px" id="addBtn" style="margin-bottom: 12px;">&nbsp;&nbsp;New customer</button>
                                </div> -->

                                <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" id="addCustomerModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><span class="mdi mdi-account-check mdi-18px"></span> &nbsp;New customer</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="">
                                                <form id="customer_form">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Full Name</label>
                                                                        <input id="customer_fullname" type="text" class="form-control " placeholder="Enter Your Fullname" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Username <span id="usernameCheck"></span></label>
                                                                        <input id="customer_username" type="text" class="form-control " name="username" placeholder="Enter Your Username" oninput="checkUsername();" />

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Password</label>
                                                                        <input id="customer_password" type="password" class="form-control " name="password" placeholder="Enter Your Password" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Mobile no.</label>
                                                                        <input id="customer_mobile" type="text" class="form-control " name="mobile" placeholder="Enter Your Mobile Number" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Expired Date</label>
                                                                        <select id="customer_expire_date" class="form-select">
                                                                            <option value="<?php echo date("d"); ?>"><?php echo date("d"); ?></option>
                                                                            <?php
                                                                            if ($exp_cstmr = $con->query("SELECT * FROM customer_expires")) {
                                                                                while ($rowsssss = $exp_cstmr->fetch_array()) {


                                                                                    $exp_date = $rowsssss["days"];

                                                                                    echo '<option value="' . $exp_date . '">' . $exp_date . '</option>';
                                                                                }
                                                                            }

                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Address</label>
                                                                        <input id="customer_address" type="text" class="form-control" name="address" placeholder="Enter Your Addres" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group mb-2">
                                                                        <label>POP/Branch</label>
                                                                        <select id="customer_pop" class="form-select">
                                                                            <option value="">Select Pop/Branch</option>
                                                                            <?php
                                                                            if ($pop = $con->query("SELECT * FROM add_pop ")) {
                                                                                while ($rows = $pop->fetch_array()) {


                                                                                    $id = $rows["id"];
                                                                                    $name = $rows["pop"];

                                                                                    echo '<option value="' . $id . '">' . $name . '</option>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group mb-2">
                                                                        <label>Area/Location</label>
                                                                        <select id="customer_area" class="form-select" name="area">
                                                                            <option>Select Area</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Nid Card Number</label>
                                                                        <input id="customer_nid" type="text" class="form-control" name="nid" placeholder="Enter Your Nid Number" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Package</label>
                                                                        <select id="customer_package" class="form-select">


                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Connection Charge</label>
                                                                        <input id="customer_con_charge" type="text" class="form-control" name="con_charge" placeholder="Enter Connection Charge" value="500" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>Package Price</label>
                                                                        <input disabled id="customer_price" type="text" class="form-control" value="00" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Remarks</label>
                                                                        <textarea id="customer_remarks" type="text" class="form-control" placeholder="Enter Remarks"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Status</label>
                                                                        <select id="customer_status" class="form-select">
                                                                            <option value="">Select Status</option>
                                                                            <option value="0">Disable</option>
                                                                            <option value="1">Active</option>
                                                                            <option value="2">Expire</option>
                                                                            <option value="3">Request</option>
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success" id="customer_add">Add Customer</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-6 float-md-right grid-margin-sm-0">
                                        <div class="form-group">

                                        </div>
                                    </div>
                                    <div class="table-responsive ">
                                        <table id="customers_table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Package</th>
                                                    
                                                    <th>Due Amount</th>
                                                    <th>Expired Date</th>
                                                    <th>Mobile no.</th>
                                                    <th>POP/Branch</th>
                                                    <th>Area/Location</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="customer-list">

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td colspan="3">
                                                        <span  id="totalPrice"></span>
                                                    </td>
                                                    <td colspan="3"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include '../Footer.php';?>

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
    <?php include '../script.php'; ?>

     <script type="text/javascript">
        var table;
        $(document).ready(function(){

                table=$('#customers_table').DataTable( {
                    "searching": true,
                    "paging": true,
                    "info": false,
                    "lengthChange":true ,
                    "processing"		: true,
                    "serverSide"		: true,
                    "zeroRecords":    "No matching records found",
                    "ajax"				: {
                        url			: "../include/customers_dues_server.php?show_customer_dues_data=true",
                        type		: 'GET',
                        dataSrc     :function(json){
                            var totalPrice = json.total_price;
                            $('#totalPrice').html(totalPrice);
                            return json.data;
                        }
                    },
                    "buttons": [			
                {
                    extend: 'copy',
                    text: '<i class="fas fa-copy"></i> Copy',
                    titleAttr: 'Copy',
                    exportOptions: { columns: ':visible' }
                }, 
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    titleAttr: 'Excel',
                    exportOptions: { columns: ':visible' }
                }, 
                {
                    extend: 'csv',
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    titleAttr: 'CSV',
                    exportOptions: { columns: ':visible' }
                }, 
                {
                    extend: 'pdf',
                    exportOptions: { columns: ':visible' },
                    orientation: 'landscape',
                    pageSize: "LEGAL",
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    titleAttr: 'PDF'
                }, 
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    titleAttr: 'Print',
                    exportOptions: { columns: ':visible' }
                }, 
                {
                    extend: 'colvis',
                    text: '<i class="fas fa-list"></i> Column Visibility',
                    titleAttr: 'Column Visibility'
                }
                ],
            });
            table.buttons().container().appendTo($('#export_buttonscc'));	
        });
         /* POP filter change event*/
         $(document).on('change','.area_filter',function(){
        
        var area_filter_result = $('.area_filter').val() == null ? '' : $('.area_filter').val();

            table.columns(7).search(area_filter_result).draw();
        
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

    </script>
</body>

</html>