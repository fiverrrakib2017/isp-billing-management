<?php
include("include/security_token.php");
include("include/users_right.php");
include "include/db_connect.php";
include "include/pop_security.php";

?>
<!doctype html>
<html lang="en">
    <head>
    
        <meta charset="utf-8">
        <title>FAST-ISP-BILLING-SOFTWARE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
        <meta content="Themesbrand" name="author">
        <!-- App favicon -->
        <!-- <link rel="shortcut icon" href="assets/images/favicon.ico"> -->
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
            <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

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
                            <h4 class="page-title">Product/Store</h4>
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
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-end flex-wrap">
                            <div class="mr-md-3 mr-xl-5">


                                <div class="d-flex">
                                    <i class="mdi mdi-home text-muted hover-cursor"></i>
                                    <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                                    </p>
                                    <p class="text-primary mb-0 hover-cursor">Product/Store</p>
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
                            <form action="include/product_server.php?add_product" id="productForm" enctype="multipart/form-data" method="post">
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
                                                    name="brand" required>
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
                                                <select id="category" class="form-select" name="category" required>
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
                                            <select id="purchase_ac" type="text" class="form-control"name="purchase_ac" required>
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
                                            <select type="text" id="sales_ac" class="form-control" name="sales_ac" required>
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
                                            <select id="store" class="form-select" name="store">
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
                                    <button type="button" onclick="history.back();" class="btn btn-danger">Back</button>
                                    <button type="submit" class=" btn btn-success">Add Now</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div> 
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>document.write(new Date().getFullYear())</script> © IT-FAST.
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
                        <input class="form-check-input theme-choice" type="checkbox"  id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css">
                        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>
            
            
                </div>

            </div> <!-- end slimscroll-menu-->
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

    <script src="assets/js/app.js"></script>
    <script src="assets/libs/select2/js/select2.min.js"></script>
    <script type="text/javascript">
       $("#brand_id").select2();
       $("#category").select2();
       $("#sales_ac").select2();
       $("#purchase_ac").select2();
       
    /** Store The data from the database table **/
        $(document).ready(function(){
            $('#productForm').on('submit', function(e){
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.success) {
                            toastr.success(result.message);
                            $('#productForm')[0].reset();
                        } else {
                            toastr.error(result.message);
                        }
                    },
                    error: function() {
                        toastr.error("Error occurred during the request.");
                    }
                });
            });
        });
 
    </script>

    </body>
</html>
