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
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <!-- C3 Chart css -->
    <link href="assets/libs/c3/c3.min.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/toastr/toastr.min.css">
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        /* div#sub_ledgr_table_length {
            display: none;
        } */

        /* div#sub_ledgr_table_filter {
         display: none;
         } */
        /* .row {
            margin-left: 0px !important;
            margin-right: 0px !important;
        }

        .vl {
            border-bottom: 6px solid green;
            height: 500px;
        } */
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
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="index.php" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/it-fast.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/it-fast.png" alt="" height="17">
                            </span>
                        </a>

                        <a href="index.php" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="assets/images/it-fast.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/it-fast.png" alt="" height="36">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="mdi mdi-menu"></i>
                    </button>

                    <div class="d-none d-sm-block ms-2">
                        <h4 class="page-title">Transaction</h4>
                    </div>
                </div>



                <div class="d-flex">





                    <div class="dropdown d-none d-md-block me-2">
                        <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="font-size-16">
                                <?php if (isset($_SESSION['username'])) {
                                    echo $_SESSION['username'];
                                } ?>
                            </span>
                        </button>
                    </div>


                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg" alt="Header Avatar">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block me-2">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ion ion-md-notifications"></i>
                            <span class="badge bg-danger rounded-pill">3</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="m-0 font-size-16"> Notification (3) </h5>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-success rounded-circle font-size-16">
                                                <i class="mdi mdi-cart-outline"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mt-0 font-size-15 mb-1">Your order is placed</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">Dummy text of the printing and typesetting industry.</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-warning rounded-circle font-size-16">
                                                <i class="mdi mdi-message-text-outline"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mt-0 font-size-15 mb-1">New Message received</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">You have 87 unread messages</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-info rounded-circle font-size-16">
                                                <i class="mdi mdi-glass-cocktail"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mt-0 font-size-15 mb-1">Your item is shipped</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">It is a long established fact that a reader will</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>
                            <div class="p-2 border-top">
                                <div class="d-grid">
                                    <a class="btn btn-sm btn-link font-size-14  text-center" href="javascript:void(0)">
                                        View all
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>

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
                        <div class="row">
                            <div class="card ">
                                <div class="container">
                                    <div class="row mb-3 mt-1">
                                        <input id="user_id" class="form-control d-none" type="text" value="<?php if (isset($_SESSION['uid'])) {
                                                                                                                echo $_SESSION['uid'];
                                                                                                            } ?>">


                                    </div>
                                    <div class="row mb-3 mt-1">
                                        <div class="col-sm mt-2">
                                            <div class="form-group">
                                                <label>Refer No:</label>
                                                <input class="form-control" type="text" placeholder="Type Your Refer No" id="refer_no">
                                            </div>
                                        </div>
                                        <div class="col-sm mt-2">
                                            <div class="form-group">
                                                <label>Note:</label>
                                                <input class="form-control" type="text" placeholder="Notes" id="note">
                                            </div>
                                        </div>
                                        <div class="col-sm mt-2">
                                            <div class="form-group">
                                                <label>Date</label>
                                                <input class="form-control" type="date" id="currentDate" value="<?php echo $date = date('m/d/Y ', time()); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mt-2">
                                                <label for="">Sub Ledger</label>
                                                <select class="form-control select2" id="sub_ledger">

                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-md-1 ">
                                            <div class="form-group mt-4">
                                                <button class="btn-sm btn btn-primary ml-0" type="button" data-bs-toggle="modal" data-bs-target="#addSubLedgerModal" style="margin-top:5px;">+</button>
                                            </div>

                                        </div>

                                        <div class="col-md-1">
                                            <div class="form-group mt-2">
                                                <label for="">Quantity</label>
                                                <input type="number" id="qty" class="form-control" min="1" value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group mt-2">
                                                <label for="">Value</label>
                                                <input type="text" class="form-control" id="value">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group mt-2">
                                                <label for="">Total</label>
                                                <input id="total" type="text" class="form-control">
                                            </div>
                                        </div>
										<div class="col-md-3">
                                            <div class="form-group mt-2">
                                                <label for="">Details</label>
                                                <input id="details" type="text" class="form-control" placeholder="Details">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <button type="button" id="submitButton" class=" btn btn-primary " style="margin-top: 25px; width:100%;">Add</button>
                                            </div>
                                        </div>
										
                                    </div>

                                    <div class="row">
                                        <div class=" mt-4">
                                            <div class="col-md-12 col-sm-12" >
                                               <div class="table-responsive" id="sub_ledgr_table1">

                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- container-fluid -->
                <div class="modal fade" id="addSubLedgerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Sub Ledger</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                        <div class="row">
                                            
                                                <div class="form-group mb-2"style="width:100%">
                                                    <label for="">Ledger Name</label>
                                                    <select name="ledger_id" id="sub_ledger_id" class="form-select" >
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
                                Development <i class="mdi mdi-heart text-danger"></i><a href="https://facebook.com/rakib56789">Rakib Mahmud</a>
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
        </div>
        <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <!-- JAVASCRIPT -->

    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/libs/jszip/jszip.min.js"></script>
    <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript" src="js/toastr/toastr.min.js"></script>
    <script type="text/javascript" src="js/toastr/toastr.init.js"></script>
    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>
    <script src="assets/libs/select2/js/select2.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // $('#sub_ledgr_table1').html('include/_server.php?show');
            getAllData();
            getLedgerData();

            
            function getLedgerData() {
                $.ajax({
                    url: "include/transactions_server.php?getLedger",
                    method: 'GET',
                    success: function(response) {
                        $('#sub_ledger').html(response);
                    },
                    error: function(xhr, status, error) {
                        // handle the error response
                        console.log(error);
                    }
                });
            }

            function getAllData() {
                $.ajax({
                    url: "include/transactions_server.php?show",
                    method: 'GET',
                    success: function(response) {
                        $('#sub_ledgr_table1').html(response);
                    },
                    error: function(xhr, status, error) {
                        // handle the error response
                        console.log(error);
                    }
                });
            } 
            //$("#sub_ledger_id").select2();
            $("#sub_ledger").select2();
           
            // Get the value and quantity input elements
            $('#qty').change(calculate);
            $('#value').keyup(calculate);

            function calculate(e) {
                $('#total').val($('#qty').val() * $('#value').val());
            }
            $("#submitButton").click(function() {
                var user_id = $("#user_id").val();
                var refer_no = $("#refer_no").val();
				var details = $("#details").val();
                var note = $("#note").val();
                var currentDate = $("#currentDate").val();

                var sub_ledger = $("#sub_ledger").val();
                var qty = $("#qty").val();
                var value = $("#value").val();
                var total = $("#total").val();

                if (sub_ledger.length == '') {
                    toastr.error('Sub ledger is require');
                }else if(currentDate.length==0){
                    toastr.error('Please Select Your Date');
                }
                
                else if (value.length=='') {
                    toastr.error('Value is require');
                } else if (qty.length=='') {
                    toastr.error('Quantity is require');
                } else if (total.length=='') {
                    total.error('Total Amount is require');
                } else {
                    //alert(sub_ledger);
                    var addTransactionData = 0;
                    $.ajax({
                        type: "POST",
                        data: {
                            addTransactionData: addTransactionData,
                            refer_no: refer_no,
                            note: note,
                            currentDate: currentDate,
                            sub_ledger: sub_ledger,
                            qty: qty,
                            value: value,
                            total: total,
                            user_id: user_id,
							details: details
                        },
                        url: "include/transactions_server.php",
                        cache: false,
                        success: function(response) {
                            if (response == 1) {
                                $("#refer_no").val('');
                                $("#description").val('');
                                $("#qty").val(1);
                                $("#value").val('');
                                $("#total").val('');

                            } else {
                                toastr.error(response);
                            }
                            getAllData();

                        }
                    });
                }

            });
            $("#addSubLedgerBtn").click(function() {
                var sub_ledger_id = $("#sub_ledger_id").val();
                var item_name = $("#item_name").val();
                var subLedgerDescription = $("#subLedgerDescription").val();
                if (sub_ledger_id.length == '') {
                    toastr.error('Select Ledger');
                } else if (item_name.length == 0) {
                    toastr.error('Item is require');
                }  else {
                    var addSubLedgerData = 0;
                    $.ajax({
                        type: "POST",
                        data: {
                            addSubLedgerData: addSubLedgerData,
                            sub_ledger_id: sub_ledger_id,
                            item_name: item_name,
                            description: subLedgerDescription
                        },
                        url: "include/transactions_server.php",
                        cache: false,
                        success: function(response) {
                            if (response == 1) {
                                toastr.success("Add Successfully ");
                                $('#addSubLedgerModal').modal('hide');
                            } else {
                                toastr.error("Please Try Again");
                            }
                            //$('#sub_ledgr_table').load('include/transactions_server.php?show');
                            getLedgerData();
                        }
                    });
                }

            });
            $(document).on('click',".finishedBtn",function(){
                $.ajax({
                    url: "include/transactions_server.php?finishedTransaction",
                    method: 'GET',
                    success: function(response) {
                        if (response==1) {
                            toastr.success("Finish Successfully");
                            getAllData();
                        }
                       // $('#sub_ledger').html(response);
                    },
                    error: function(xhr, status, error) {
                        // handle the error response
                        console.log(error);
                    }
                });
            });
            $(document).on('click',"#transaction_deleteBtn",function(){
                var id=$(this).data('id');
                alert(id);
                // $.ajax({
                //     url: "include/transactions_server.php?finishedTransaction",
                //     method: 'GET',
                //     success: function(response) {
                //         if (response==1) {
                //             toastr.success("Finish Successfully");
                //             getAllData();
                //         }
                //        // $('#sub_ledger').html(response);
                //     },
                //     error: function(xhr, status, error) {
                //         // handle the error response
                //         console.log(error);
                //     }
                // });
            });
            function deleteTransaction(dataid){
                alert(dataid);
            }
        });
    </script>


</body>

</html>