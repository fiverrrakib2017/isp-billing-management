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
                        <div class="col-md-12">
                            <div class="row ">
                                <div class="col-md-7 m-auto">
                                    <div class="card ">
                                        <div class="card-header">
                                            <button class="btn btn-success"  data-bs-toggle="modal" data-bs-target="#productModal" >Add Product</button>
                                            <button class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#supplierModal" >Add Supplier</button>
                                        </div>
                                        <div class="card-body">
                                        <form id="form-data" action="include/purchase_server.php?add_invoice" method="post">
                                            <div class="form-group mb-2">
                                                <label>Product Name</label>
                                                <select type="text" id="product_name"  class="form-control">
                                                    <option>Select</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label>Client Name</label>
                                                <select type="text" id="client_name" name="client_id" class="form-control select2">
                                                    <option>---Select---</option>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-bordered">
                                                    <thead class="bg bg-info text-white">
                                                        <th>Product List</th>
                                                        <th>Qty</th>
                                                        <th>Price</th>
                                                        <th>Total</th>
                                                        <th></th>
                                                    </thead>
                                                    <tbody id="tableRow">
                                                    </tbody>
                                                    <tfoot class="">
                                                        <tr>
                                                            <th class="text-center" colspan="2"></th>
                                                            <th class="text-left" colspan="3">
                                                                Total Amount <input readonly class="form-control total_amount" name="total_amount" type="text">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center" colspan="2"></th>
                                                            <th class="text-left" colspan="3">
                                                                Paid Amount <input  type="text" class="form-control paid_amount" name="paid_amount" >
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center" colspan="2"></th>
                                                            <th class="text-left" colspan="3">
                                                                Discount Amount <input  type="text" class="form-control discount_amount" name="discount_amount" value="00">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center" colspan="2"></th>
                                                            <th class="text-left" colspan="3">
                                                                Due Amount <input type="text" readonly class="form-control due_amount" name="due_amount" >
                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                                    </table>
                                                    <div class="form-group text-center">
                                                    <button type="submit"  class="btn btn-success"><i class="fe fe-dollar"></i> Create Now</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
        $("#client_name").select2();
        $("#product_name").select2();

        function calculate(e) {
            $('#total').val($('#quantity').val() * $('#value').val());
        }
        
        getClientData()

        function getClientData() {

            $.ajax({
                url: "include/sale_server.php?getClientData",
                method: 'GET',
                success: function(response) {
                    $('#client_name').html(response);
                   
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
                    $('#product_name').html(response);
                },
                error: function(xhr, status, error) {
                    // handle the error response
                    console.log(error);
                }
            });
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

        
        $("#product_name").change(function() {
            var itemId = $(this).val();
            $.ajax({
                url: "include/purchase_server.php?getSingleProductData",
                method: 'GET',
                data: {
                    id: itemId
                },
                success: function(response) {
                    /* যদি রেসপন্স JSON string হিসাবে আসে, তাহলে এটিকে JSON অবজেক্টে কনভার্ট করতে হবে*/
                    var product = typeof response === 'string' ? JSON.parse(response) : response;

                    var product_exists = false;
                    /*Check if the product already exists in the table*/
                    $("#tableRow tr").each(function(){
                        var existing_product_id = $(this).find('input[name="product_id[]"]').val();
                        if (existing_product_id == product.id) {
                            product_exists = true;
                            return false; // break loop
                        }
                    });
                    if (product_exists) {
                        toastr.error("Product already added. Please increase the quantity.");
                        return false;
                    }

                    /* Create table row with product details*/
                    var row = '<tr>' +
                        '<td><input type="hidden" name="product_id[]" value="'+ product.id +'">'+ product.name +'</td>' +
                        '<td><input type="number" min="1" name="qty[]" value="1" class="form-control qty"></td>' +
                        '<td><input readonly type="number" name="price[]" class="form-control" value="' + product.purchase_price + '"></td>' +
                        '<td><input readonly type="number" id="total_price" name="total_price[]" class="form-control" value="' + product.purchase_price + '"></td>' +
                        '<td><a class="btn-sm btn-danger" type="button" id="itemRow"><i class="mdi mdi-close"></i></a></td>' +
                        '</tr>';

                    /*Append row to the table body*/ 
                    $('#tableRow').append(row);
                     calculateTotalAmount();

                },
                error: function(xhr, status, error) {
                    /*handle the error response*/ 
                    console.log(error);
                }
            });
        });
    
        /*Calculate total amount when quantity or price changes*/ 
        $(document).on('input', '.qty', function() {
            var row = $(this).closest('tr');
            var qty = $(this).val();
            var price = row.find('input[name="price[]"]').val();
            var total_price = qty * price;
            row.find('input[name="total_price[]"]').val(total_price);
            calculateTotalAmount();
        });
        /* Calculate total amount function*/
        function calculateTotalAmount() {
            var totalAmount = 0;
            $('#tableRow tr').each(function() {
                var total_price = $(this).find('input[name="total_price[]"]').val();
                totalAmount += parseFloat(total_price);
            });
            $('input[name="total_amount"]').val(totalAmount);

            // Calculate Due Amount
            var paidAmount = parseFloat($('input[name="paid_amount"]').val()) || 0;
            var discountAmount = parseFloat($('input[name="discount_amount"]').val()) || 0;
            var dueAmount = totalAmount - paidAmount - discountAmount;
            $('input[name="due_amount"]').val(dueAmount);
        }
    /*Update Due Amount when Paid Amount or Discount changes*/ 
        $(document).on('input', 'input[name="paid_amount"], input[name="discount_amount"]', function() {
            calculateTotalAmount();
        });

        /* Remove row when the delete button is clicked*/
        $(document).on('click', '#itemRow', function() {
            $(this).closest('tr').remove();
            calculateTotalAmount();
        });




    </script>

</body>

</html>