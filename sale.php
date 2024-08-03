<?php
include "include/db_connect.php";
include("include/security_token.php");
include("include/users_right.php");
include("include/pop_security.php");
if (isset($_SESSION['uid'])) {
    $_SESSION["uid"];
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
                        <h4 class="page-title">Sale</h4>
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
                        <div class="card ">
                            <form id="saleForm">
                                <div class="row mb-3 mt-1">
                                    <div class="col-sm d-none">
                                        <div class="form-group ">
                                            <label>User Id</label>
                                            <input id="userId" class="form-control" type="text" name="id" value="<?php if (isset($_SESSION['uid'])) {
                                                                                                                        echo $_SESSION['uid'];
                                                                                                                    } ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label>Client</label>
                                            <select class="form-select" name="client" id="client">


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1 ">
                                        <div class="form-group mt-3">
                                            <button class="btn-sm btn btn-primary ml-0" type="button" data-bs-toggle="modal" data-bs-target="#clientModal" style="margin-top:5px;"><i class="mdi mdi-account-plus"></i></button>
                                        </div>

                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group ">
                                            <label>Refer No:</label>
                                            <input class="form-control" type="text" name="refer_no" id="refer_no" placeholder="Type Your Refer No">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group ">
                                            <label>Description:</label>
                                            <input class="form-control" type="text" name="desc" id="desc" placeholder="Type Your Description">
                                        </div>
                                    </div>

                                </div>




                            </form>
                        </div>

                    </div>
                    <div class="row">
                        <div class="card">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="">Item</label>
                                            <select class="form-select" name="item" id="item">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group mt-4 mb-3">
                                            <button class="btn-sm btn btn-primary ml-0" type="button" data-bs-toggle="modal" data-bs-target="#productModal" style="margin-top:5px;">+</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-3">
                                            <label for="">Quantity</label>
                                            <input type="number" class="form-control" name="quantity" id="quantity" min="1">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-3">
                                            <label for="">Value</label>
                                            <input type="text" class="form-control" name="value" id="value">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-3">
                                            <label for="">Total</label>
                                            <input type="text" class="form-control" name="total" id="total">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-3">
                                            <button type="button" id="submitBtn" class="btn btn-success" style="margin-top: 22px;">Add</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row  ">
                                    <div class="col-md-12 ">
                                        <div class="table-responsive " id="saleTable">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- container-fluid -->

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
    <div class="modal fade bs-example-modal-lg" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content col-md-10">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span class="mdi mdi-account-check mdi-18px"></span> &nbsp;New Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div>
                    <!--Customer form start-->
                    <form id="client_form">
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <form class="form-sample">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Full Name</label>
                                                    <input id="fullname" type="text" class="form-control" name="fullname" placeholder="Enter Your Fullname" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Company</label>
                                                    <input id="company" type="text" class="form-control" name="company" placeholder="Enter Company Name" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Status</label>
                                                    <select id="status_check" name="status" class="form-select">
                                                        <option value="">Select</option>
                                                        <option value="1">Active</option>
                                                        <option value="0">Disable</option>
                                                        <option value="2">Expired</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Mobile no.</label>
                                                    <input id="mobile" type="text" class="form-control" name="mobile" placeholder="Enter Your Mobile Number" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Email</label>
                                                    <input id="email" type="email" class="form-control" name="email" placeholder="Enter Your Email" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="from-group mb-2">
                                                    <label>Address</label>
                                                    <input id="address" type="text" class="form-control" name="address" placeholder="Enter Your Addres" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--Customer form end-->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="client_add">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="productModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content col-md-10">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span class="mdi mdi-account-check mdi-18px"></span> &nbsp;New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div>
                    <!--Product form start-->
                    <form id="prduct_form">
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <form class="form-sample">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Product Name</label>
                                                    <input id="pdname" type="text" class="form-control" name="pdname" placeholder="Enter Your Product Name" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group  mb-2">
                                                    <label>Description</label>
                                                    <input id="description" type="text" class="form-control" name="desc" placeholder="Enter Description" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Category</label>
                                                    <select id="category" class="form-select" name="category">
                                                        <?php
                                                        if ($category = $con->query("SELECT * FROM product_cat")) {
                                                            while ($rows = $category->fetch_array()) {

                                                                $id = $rows["id"];

                                                                $name = $rows["name"];

                                                                echo '<option value=' . $name . '>' . $name . '</option>';
                                                            }
                                                        }

                                                        ?>


                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Brand</label>
                                                    <select id="brand" class="form-select" name="brand">
                                                        <?php
                                                        if ($category = $con->query("SELECT * FROM product_brand")) {
                                                            while ($rows = $category->fetch_array()) {

                                                                $id = $rows["id"];

                                                                $name = $rows["name"];

                                                                echo '<option value=' . $name . '>' . $name . '</option>';
                                                            }
                                                        }

                                                        ?>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group  mb-2">
                                                    <label>Purchase A/C</label>
                                                    <input id="purchase_ac" type="text" class="form-control" name="purchase_ac" placeholder="Enter Purchase A/C" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Sales Account</label>
                                                    <input type="text" id="sales_ac" class="form-control" name="sales_ac" placeholder="Enter Your Sales A/C" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Purchase Price</label>
                                                    <input id="purchase_price" type="text" class="form-control" name="purchase_price" placeholder="Enter Purchase Price" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Sales Price</label>
                                                    <input id="sale_price" type="text" class="form-control " name="sale_price" placeholder="Enter Sales Price" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Store</label>
                                                    <input id="store" type="text" class="form-control " name="store" placeholder="Store" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label>Product Image</label>
                                                    <input id="store" type="file" class="form-control " name="uploadPhoto" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--Product form end-->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="product_add">Add Product</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="paymentModal">
        <div class="modal-dialog " role="document">
            <div class="modal-content col-md-10">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Add Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card-body">
                    <form action="" id="paymnt_process">
                        <div class="form-group mb-2">
                            <label for="">Sub Total</label>
                            <input disabled type="text" id="payment_sub_total" placeholder="Enter Sub total Amount" class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Discount</label>
                            <input type="text" id="payment_discount" value="00" placeholder="Enter Amount" class="form-control ">
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Grand Total</label>
                            <input disabled type="text" id="payment_grand_total" placeholder="Enter  Amount" class="form-control ">
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Total Paid</label>
                            <input type="text" id="payment_totalPaid" placeholder="Enter  Amount" class="form-control ">
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Total Due</label>
                            <input disabled type="text" id="payment_totalDue" placeholder="Enter  Amount" class="form-control ">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-sm btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn-sm btn btn-primary" id="payment_add">Payment Now</button>
                </div>
            </div>
        </div>
    </div>
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
    <script src="assets/libs/select2/js/select2.min.js"></script>
    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>

    <script src="assets/js/app.js"></script>

    <script type="text/javascript">
        $("#client").select2();
        $("#item").select2();
        $('#quantity').change(calculate);
        $('#value').keyup(calculate);

        function calculate(e) {
            $('#total').val($('#quantity').val() * $('#value').val());
        }
        getAllData();

        function getAllData() {
            $.ajax({
                url: "include/sale_server.php?show",
                method: 'GET',
                success: function(response) {
                    $('#saleTable').html(response);
                },
                error: function(xhr, status, error) {
                    // handle the error response
                    console.log(error);
                }
            });
        }
        getClientData()

        function getClientData() {

            $.ajax({
                url: "include/sale_server.php?getClientData",
                method: 'GET',
                success: function(response) {
                    $('#client').html(response);
                },
                error: function(xhr, status, error) {
                    // handle the error response
                    console.log(error);
                }
            });
        }
        getProductData();

        function getProductData() {

            $.ajax({
                url: "include/purchase_server.php?getProductData",
                method: 'GET',
                success: function(response) {
                    $('#item').html(response);
                },
                error: function(xhr, status, error) {
                    // handle the error response
                    console.log(error);
                }
            });
        }
        addInvoiceData()

        function addInvoiceData() {
            $("#submitBtn").click(function() {
                var userId = $("#userId").val();
                var discount = $("#discount").val();
                var client = $("#client").val();
                var refer_no = $("#refer_no").val();
                var desc = $("#desc").val();
                var item = $("#item").val();
                var quantity = $("#quantity").val();
                var value = $("#value").val();
                var total = $("#total").val();
                addInvoiceDataReq(discount, userId, client, refer_no, desc, item, quantity, value, total);
            });
        }
        const addInvoiceDataReq = (discount, userId, client, refer_no, desc, item, quantity, value, total) => {
            var addData = 0;
            if (client.length == 0) {
                toastr.error("Client name require");
            } else if (item.length == 0) {
                toastr.error("Item Must be require");
            } else if (quantity.length == 0) {
                toastr.error("Quantity require");
            } else if (value.length == 0) {
                toastr.error("Value require");
            } else {
                $.ajax({
                    url: 'include/sale_server.php',
                    type: 'POST',
                    data: {
                        discount: discount,
                        addData: addData,
                        userId: userId,
                        client: client,
                        refer_no: refer_no,
                        desc: desc,
                        item: item,
                        quantity: quantity,
                        value: value,
                        total: total
                    },
                    success: function(response) {

                        $("#qty").val('');
                        $("#value").val('');
                        $("#total").val('');
                        getAllData();
                        //console.log(response);
                    }
                });
            }
        }
        //client Add
        $("#client_add").click(function() {
            var fullname = $("#fullname").val();
            var company = $("#company").val();
            var mobile = $("#mobile").val();
            var email = $("#email").val();
            var address = $("#address").val();

            //alert(fullname.length);
            if (fullname.length == 0) {
                toastr.error("Full name required");
            } else if (company.length == 0) {
                toastr.error("Company name required");
            } else if (mobile.length == 0) {
                toastr.error("Mobile number required");
            } else if (email.length == 0) {
                toastr.error("Email required");
            } else if (address.length == 0) {
                toastr.error("Address required");
            } else {
                var formData = $("#client_form").serialize();
                $.ajax({
                    type: "GET",
                    data: formData,
                    url: "include/client_data.php?add",
                    cache: false,
                    success: function() {
                        toastr.success("Client Added Successfully");
                        $("#clientModal").modal('hide');
                        getClientData();
                    }
                });
            }

        });


        $("#product_add").click(function() {
            var pdname = $("#pdname").val();
            var desc = $("#description").val();
            var category = $("#category").val();
            var brand = $("#brand").val();
            var purchase_ac = $("#purchase_ac").val();
            var sales_ac = $("#sales_ac").val();
            var purchase_price = $("#purchase_price").val();
            var sale_price = $("#sale_price").val();
            var store = $("#store").val();



            if (pdname.length == 0) {
                toastr.error('Product Name is required');
            } else if (desc.length == 0) {
                toastr.error('Description is required');
            } else if (category.length == 0) {
                toastr.error('Category is required');
            } else if (brand.length == 0) {
                toastr.error('Brand is required');
            } else if (purchase_ac.length == 0) {
                toastr.error('Purchase A/C number required');
            } else if (sales_ac.length == 0) {
                toastr.error('Sale A/C number required');
            } else if (purchase_price.length == 0) {
                toastr.error('Purchase Price required');
            } else if (sale_price.length == 0) {
                toastr.error('Sale Price number required');
            } else if (store.length == 0) {
                toastr.error('Store required');
            } else {

                var productData = $("#prduct_form").serialize();
                $.ajax({
                    type: "GET",
                    url: "include/product.php?add",
                    data: productData,
                    cache: false,
                    success: function(response) {
                        toastr.success('Product Added');
                        $("#productModal").modal('hide');
                        getProductData();
                        //$("#customer-list").load("include/customers.php?list");
                    }
                });
            }
        });


        //when product select then automatic insert qty and value 
        $("#item").change(function() {
            var itemId = $("#item").val();
            $.ajax({
                url: "include/purchase_server.php?getSingleProductData",
                method: 'GET',
                data: {
                    id: itemId
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $("#quantity").val('1');
                    $("#value").val(data.purchase_price);
                    $("#total").val(data.purchase_price);
                },
                error: function(xhr, status, error) {
                    // handle the error response
                    console.log(error);
                }
            });
        });


        //delete invoicce item script
        function deleteInvItem(receviedId) {
            var dataId = receviedId;
            $.ajax({
                url: "include/sale_server.php?deleteInvItem",
                method: 'GET',
                data: {
                    id: dataId
                },
                success: function(response) {
                    if (response == 1) {
                        toastr.success("Delete Successful");
                        getAllData();
                    } else {
                        toastr.error('Something else');
                    }

                },
                error: function(xhr, status, error) {
                    // handle the error response
                    console.log(error);
                }
            });

        }



        ////////////////////////payment process/////////////////////////
        function processPayment(sabtotal) {
            $("#paymentModal").modal('show');
            $("#payment_sub_total").val(sabtotal);
            $("#payment_grand_total").val(sabtotal);
        }



        // $('#payment_discount').on('keyup', function() {
        //     var sub_total = $('#payment_sub_total').val();
        //     var payment_discount = $(this).val();
        //     var grand_total = $('#payment_grand_total').val(Number(sub_total - payment_discount));

        //     var total_paid = $('#payment_totalPaid').val(number(grand_total));
        //     //setTimeout(function(){var balances = Number(grand_total - total_paid)}, 500);

        //      $('#payment_totalDue').val(number(total_paid) - number($('#payment_grand_total').val()));

        // });
        // $('#payment_totalPaid').on('keyup',function(){
        //     var grand_total = $('#payment_grand_total').val();
        //     var total_paid = $('#payment_totalPaid').val();
        //     var total_due = $('#payment_totalDue').val(Number(grand_total-total_paid));
        // });
        $('#payment_discount').on('keyup', function() {
            var sub_total = parseFloat($('#payment_sub_total').val());
            var payment_discount = parseFloat($(this).val());
            var grand_total = sub_total - payment_discount;

            $('#payment_grand_total').val(grand_total.toFixed(2));

            var total_paid = parseFloat($('#payment_totalPaid').val());
            var total_due = grand_total - total_paid;

            $('#payment_totalDue').val(total_due.toFixed(2));
        });

        $('#payment_totalPaid').on('keyup', function() {
            var grand_total = parseFloat($('#payment_grand_total').val());
            var total_paid = parseFloat($(this).val());
            var total_due = grand_total - total_paid;

            $('#payment_totalDue').val(total_due.toFixed(2));
        });






        //Payment Process
        $("#payment_add").click(function() {
            var sub_total = $('#payment_sub_total').val();
            var payment_discount = $('#payment_discount').val();
            var payment_grand_total = $('#payment_grand_total').val();
            var payment_totalPaid = $('#payment_totalPaid').val();
            var payment_totalDue = $('#payment_totalDue').val();

            if (payment_totalPaid.length === 0) {
                toastr.error("Enter Paid Amount");
            } else if (parseFloat(payment_totalPaid) > parseFloat(payment_totalDue)) {
                toastr.error("Over Payment Not allowed");
            } else {
                $.ajax({
                    type: "POST",
                    data: {
                        sub_total: sub_total,
                        payment_discount: payment_discount,
                        payment_grand_total: payment_grand_total,
                        payment_totalPaid: payment_totalPaid,
                        payment_totalDue: payment_totalDue,
                        addPayment: 0
                    },
                    url: "include/sale_server.php",
                    cache: false,
                    success: function(response) {
                        if (response == 1) {
                            toastr.success("Done Successfully");
                            $("#paymentModal").modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error("Please Try Again");
                        }
                    }
                });
            }
        });
    </script>

</body>

</html>