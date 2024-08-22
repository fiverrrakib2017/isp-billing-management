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
                                <?php if (isset($_SESSION['fullname'])) {
                                    echo $_SESSION['fullname'];
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
                    <form id="form-data" action="include/sale_server.php?add_invoice" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="refer_no" class="form-label">Refer No:</label>
                                                    <input class="form-control" type="text" placeholder="Type Your Refer No" id="refer_no" name="refer_no">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group mt-2">
                                                    <label>Client Name</label>
                                                    <select type="text" id="client_name" name="client_id" class="form-select select2">
                                                        <option>---Select---</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="note" class="form-label">Note:</label>
                                                    <input class="form-control" type="text" placeholder="Notes" id="note" name="note">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="currentDate" class="form-label">Date</label>
                                                    <input class="form-control" type="date" id="currentDate" value="<?php echo $date = date('m/d/Y ', time()); ?>" name="date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="product_item" class="form-label">Product</label>
                                                    <div class="input-group">
                                                        <select type="text" id="product_name"  class="form-control">
                                                            <option>---Select---</option>
                                                        </select>
                                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addproductModal">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="qty" class="form-label">Quantity</label>
                                                    <input type="number" id="qty" class="form-control" min="1" value="1">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="price" class="form-label">Price</label>
                                                    <input type="text" class="form-control price" id="price">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="total_price" class="form-label">Total Price</label>
                                                    <input id="total_price" type="text" class="form-control total_price">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="details" class="form-label">Details</label>
                                                    <input id="details" type="text" class="form-control" placeholder="Details">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-end">
                                                <button type="button" id="submitButton" class="btn btn-success">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                        <th class="text-center" colspan="3"></th>
                                        <th class="text-left" colspan="4">
                                            Total Amount <input readonly class="form-control table_total_amount" name="table_total_amount" type="text">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="3"></th>
                                        <th class="text-left" colspan="4">
                                            Paid Amount <input  type="text" class="form-control table_paid_amount" name="table_paid_amount" >
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="3"></th>
                                        <th class="text-left" colspan="4">
                                            Discount Amount <input  type="text" class="form-control table_discount_amount" name="table_discount_amount" value="00">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="3"></th>
                                        <th class="text-left" colspan="4">
                                            Due Amount <input type="text" readonly class="form-control table_due_amount" name="table_due_amount" >
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="3"></th>
                                        <th class="text-left" colspan="4">
                                            Status <select type="text"  class="form-select table_status" name="table_status" >
                                                <option value="">---Select---</option>
                                                <option value="0">Draf</option>
                                                <option value="1">Completed</option>
                                                <option value="2">Print Invoice</option>
                                            </select>
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
                                Development <i class="mdi mdi-heart text-danger"></i><a href="https://facebook.com/rakib56789">Rakib Mahmud</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="addproductModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content col-md-10">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span
                        class="mdi mdi-account-check mdi-18px"></span> &nbsp;New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="card">
                    <form action="#" id="productForm" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label for="">Product Name</label>
                                        <input type="text"  class="form-control" name="product_name" id="product_name" placeholder="Enter Product Name" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label for="">Brand</label>
                                        <select id="brand_id" class="form-select"
                                            name="brand" required style="width: 100%;">
                                            <option value="">---Select---</option>
                                            <?php 
                                                if ($category = $con-> query("SELECT * FROM product_brand")) {
                                                    while($rows= $category->fetch_array()){

                                                    $id=$rows["id"];
                                                    
                                                        $name = $rows["name"];
                                                        
                                                        echo '<option value='.$id.'>'.$name.'</option>';
                                                    }
                                                }
                                                
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label for="">Category</label>
                                        <select id="category" class="form-select" name="category" style="width: 100%;" required>
                                        <option value="">---Select---</option>
                                        <?php 
                                            if ($category = $con-> query("SELECT * FROM product_cat")) {
                                                while($rows= $category->fetch_array()){

                                                $id=$rows["id"];
                                                
                                                    $name = $rows["name"];
                                                    
                                                    echo '<option value='.$id.'>'.$name.'</option>';
                                                }
                                            }
                                            
                                            ?>
                                                

                                            </select>
                                    </div>
                                </div>
                            </div>

                        

                            <div class="row">

                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label>Purchase A/C</label>
                                        <select id="purchase_ac" type="text" class="form-control"name="purchase_ac" required style="width: 100%;">
                                        <?php
                                    if ($ledgr = $con->query("SELECT * FROM ledger Where `mstr_ledger_id`=2")) {
                                        echo '<option value="">Select</option>';

                                        while ($rowsitm = $ledgr->fetch_array()) {
                                            $ldgritmsID = $rowsitm["id"];
                                            $ledger_name = $rowsitm["ledger_name"];

                                            echo '<optgroup label="' . $ledger_name . '">';


                                            // Sub Ledger items list
                                            if ($ledgrsubitm = $con->query("SELECT * FROM legder_sub WHERE ledger_id='$ldgritmsID'")) {


                                                while ($rowssb = $ledgrsubitm->fetch_array()) {
                                                    $sub_ldgrid = $rowssb["id"];
                                                    $ldgr_items = $rowssb["item_name"];

                                                    echo '<option value="' . $sub_ldgrid . '">' . $ldgr_items . '</option>';
                                                }
                                            }



                                            echo '</optgroup>';
                                        }
                                    }
                                    ?>
                                        </select>
                                    </div>
                                </div>            
                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label>Sales Account</label>
                                        <select type="text" id="sales_ac" class="form-control" name="sales_ac" required style="width: 100%;">
                                    <?php
                                    if ($ledgr = $con->query("SELECT * FROM ledger Where `mstr_ledger_id`=1")) {
                                        echo '<option value="">Select</option>';

                                        while ($rowsitm = $ledgr->fetch_array()) {
                                            $ldgritmsID = $rowsitm["id"];
                                            $ledger_name = $rowsitm["ledger_name"];

                                            echo '<optgroup label="' . $ledger_name . '">';


                                            // Sub Ledger items list
                                            if ($ledgrsubitm = $con->query("SELECT * FROM legder_sub WHERE ledger_id='$ldgritmsID'")) {


                                                while ($rowssb = $ledgrsubitm->fetch_array()) {
                                                    $sub_ldgrid = $rowssb["id"];
                                                    $ldgr_items = $rowssb["item_name"];

                                                    echo '<option value="' . $sub_ldgrid . '">' . $ldgr_items . '</option>';
                                                }
                                            }



                                            echo '</optgroup>';
                                        }
                                    }
                                    ?>
                                        </select>
                                    </div>
                                </div>            
                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label for="">Purchase Price</label>
                                        <input type="number" class="form-control" id="p_price"  name="p_price" placeholder="Enter Your Price" required/>
                                    </div>
                                </div>            
                                
                            </div>


                            


                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label for="">Sale's Price</label>
                                        <input type="number" class="form-control" id="s_price"  name="s_price" placeholder="Enter Your Sale's Price" required/>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label for="">Store</label>
                                        <select id="store" class="form-select" name="store" style="width: 100%;">
                                            <option value="">---Select---</option>
                                            <?php 
                                                if ($store = $con-> query("SELECT * FROM store")) {
                                                    while($rows= $store->fetch_array()){

                                                        $id=$rows["id"];
                                                    
                                                        $name = $rows["name"];
                                                        
                                                        echo '<option value='.$id.'>'.$name.'</option>';
                                                    }
                                                }
                                                
                                                ?>
                                                    

                                                </select>       
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4">
                                        <label for="">Remarks</label>
                                        <input type="text" class="form-control" id="note"  name="note" placeholder="Enter Your Note" />
                                    </div>
                                </div>
                            </div>



                        </div>
                        <div class="card-footer">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-danger">Close</button>
                            <button type="submit" id="addProductBtn" class=" btn btn-success">Add Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
            $('#addproductModal').on('shown.bs.modal', function () {
                // Check if select2 is already initialized
                if (!$('#brand_id').hasClass("select2-hidden-accessible")) {
                    $("#brand_id").select2({
                        dropdownParent: $('#addproductModal')
                    });
                }
                if (!$('#category').hasClass("select2-hidden-accessible")) {
                    $("#category").select2({
                        dropdownParent: $('#addproductModal')
                    });
                }
                if (!$('#sales_ac').hasClass("select2-hidden-accessible")) {
                    $("#sales_ac").select2({
                        dropdownParent: $('#addproductModal')
                    });
                }
                if (!$('#purchase_ac').hasClass("select2-hidden-accessible")) {
                    $("#purchase_ac").select2({
                        dropdownParent: $('#addproductModal')
                    });
                }
            });

          var selectedProductId = null;
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
            $("#product_name").change(function() {
                var itemId = $(this).val();
                $.ajax({
                    url: "include/purchase_server.php?getSingleProductData",
                    method: 'GET',
                    data: {
                        id: itemId
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        selectedProductId = data.id;
                        var price = data.sale_price;

                        $('#price').val(price);
                        updateTotalPrice();

                    },
                    error: function(xhr, status, error) {
                        /*handle the error response*/ 
                        console.log(error);
                    }
                });
            });
            $('#qty').on('input', function() {
                updateTotalPrice();
            });
            $('#price').on('input', function() {
                updateTotalPrice();
            });

            function updateTotalPrice() {
                var qty = $('#qty').val();
                var price = $('#price').val();
                var total = qty * price;
                $('#total_price').val(total);
               
            }

            $(document).on('click','#submitButton',function(e){
                e.preventDefault(); 

                var productName = $('#product_name option:selected').text();
                var quantity = $('#qty').val();
                var price = $('#price').val();
                var totalPrice = $('#total_price').val();

                var row = `<tr>
                    <td><input type="hidden" name="table_product_id[]"value="`+ selectedProductId +`">${productName}</td>

                    <td><input readonly type="number" min="1" name="table_qty[]" value="${quantity}" class="form-control table_qty"></td>

                    <td><input readonly type="number" name="table_price[]" class="form-control table_price" value="${price}"></td>

                    <td><input readonly type="number" id="table_total_price" name="table_total_price[]" class="form-control" value="${totalPrice}"></td>

                   <td><button class="btn btn-danger btn-sm removeRow">Remove</button></td>

                   
                    
                  </tr>`;

                $("#tableRow").append(row);
                calculateTotalAmount(); 
                 $('#product_name').val('');
                 $('#qty').val('1');
                 $('#price').val('');
                 $('#total_price').val('');
                 selectedProductId = null;
            });
            $(document).on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
                calculateTotalAmount(); 
            });
            /* Calculate total amount function*/
            function calculateTotalAmount() {
                var totalAmount = 0;
                $('#tableRow tr').each(function() {
                    var total_price = $(this).find('input[name="table_total_price[]"]').val();
                    totalAmount += parseFloat(total_price);
                });
                $('input[name="table_total_amount"]').val(totalAmount);

                // Calculate Due Amount
                var paidAmount = parseFloat($('input[name="table_paid_amount"]').val()) || 0;
                var discountAmount = parseFloat($('input[name="table_discount_amount"]').val()) || 0;
                var dueAmount = totalAmount - paidAmount - discountAmount;
                $('input[name="table_due_amount"]').val(dueAmount);
            }
            /*Update Due Amount when Paid Amount or Discount changes*/ 
            $(document).on('input', 'input[name="table_paid_amount"], input[name="table_discount_amount"]', function() {
                calculateTotalAmount();
            });


            $("form").submit(function(e){
                e.preventDefault();
                var form = $(this);
                form.find('button[type="submit"]').prop('disabled',true).html(`Loading...`);
                var url = form.attr('action');
                var formData = form.serialize();
                  /** Use Ajax to send the  request **/
                  $.ajax({
                    type:'POST',
                    'url':url,
                    data: formData,
                    dataType: 'json',
                    success:function(response){
                        
                        if (response.success) {
                            toastr.success(response.message);
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        /** Handle  errors **/
                        if (xhr.status === 400) {
                            toastr.error(xhr.responseJSON.message);
                            return false;
                        }
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            Object.values(errors).forEach(function(errorMessage) {
                            toastr.error(errorMessage);
                            });
                            return false;
                        }
                        else {
                            console.error(xhr.responseText);
                            toastr.error('Server Problem');
                        }
                    },
                    complete:function(){
                        form.find('button[type="submit"]').prop('disabled',false).html('Create Now');
                    }
                  }); 
            });

        });

        $(document).on('click','#addProductBtn',function(e){
            e.preventDefault();
            var formData = $("#productForm").serialize(); 
            $.ajax({
                url:'include/product_server.php?add_product',
                type: 'POST',
                data: formData,
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                processData: true,
                success: function(response) {
                   
                    var result = JSON.parse(response);
                    if (result.success) {
                        toastr.success(result.message);
                        $('#productForm')[0].reset(); 
                        $("#addproductModal").modal('hide');
                        getProductData(); 
                    } else {
                        toastr.error(result.message);
                    }
                },
                error: function() {
                    toastr.error("Error occurred during the request.");
                }
            });
        });

    </script>


</body>

</html>