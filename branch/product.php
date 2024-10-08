<?php
include("include/security_token.php");
include("include/db_connect.php");
include("include/users_right.php");
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
        <link rel="shortcut icon" href="assets/images/favicon.ico">
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
                            <h4 class="page-title">Products</h4>
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
               <div class="col-md-12 grid-margin">
                  <div class="d-flex justify-content-between flex-wrap">
                     <div class="d-flex align-items-end flex-wrap">
                        <div class="mr-md-3 mr-xl-5">
                           <div class="d-flex">
                              <i class="mdi mdi-home text-muted hover-cursor"></i>
                              <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;
                              </p>
                              <p class="text-primary mb-0 hover-cursor">Products</p>
                           </div>
                        </div>
                        <br>
                     </div>
                     <div class="d-flex justify-content-between align-items-end flex-wrap">
                        <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" style="margin-bottom: 12px;">&nbsp;&nbsp;&nbsp;New Product</button>
                     </div>
                     <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true" id="addModal">
                     <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content col-md-10">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel"><span
                                 class="mdi mdi-account-check mdi-18px"></span> &nbsp;New Product</h5>
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
                              <div class="form-group ">
                              <label>Product Name</label>
                              <input id="pdname" type="text"
                                 class="form-control"
                                 name="pdname"
                                 placeholder="Enter Your Product Name" />
                              </div>
                              </div>
                              <div class="col-md-6">
                              <div class="form-group ">
                              <label>Description</label>
                              <input id="desc" type="text"
                                 class="form-control"
                                 name="desc"
                                 placeholder="Enter Description" />
                              </div>
                              </div>  
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Category</label>
                                       <select id="category" class="form-select"
                                          name="category">
                                               <?php 
                                    if ($category = $con-> query("SELECT * FROM product_cat")) {
                                        while($rows= $category->fetch_array()){

                                          $id=$rows["id"];
                                           
                                            $name = $rows["name"];
                                            
                                            echo '<option value='.$name.'>'.$name.'</option>';
                                        }
                                    }
                                    
                                    ?>
                                          

                                       </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                              <div class="form-group">
                              <label>Brand</label>
                              <select id="brand" class="form-select"
                                 name="brand">
                                 <?php 
                                    if ($category = $con-> query("SELECT * FROM product_brand")) {
                                        while($rows= $category->fetch_array()){

                                          $id=$rows["id"];
                                           
                                            $name = $rows["name"];
                                            
                                            echo '<option value='.$name.'>'.$name.'</option>';
                                        }
                                    }
                                    
                                    ?>

                              </select>
                              </div>
                              </div>
                              <div class="col-md-6">
                              <div class="form-group ">
                              <label>Purchase A/C</label>
                              <input id="purchase_ac" type="text"
                                 class="form-control"
                                 name="purchase_ac"
                                 placeholder="Enter Purchase A/C" />
                              </div>
                              </div> 
                              <div class="col-md-6">
                              <div class="form-group">
                              <label>Sales Account</label>
                              <input type="text" id="sales_ac" 
                                 class="form-control"
                                 name="sales_ac"
                                 placeholder="Enter Your Sales A/C" />
                              </div>
                              </div>
                              <div class="col-md-6">
                              <div class="form-group">
                              <label>Purchase Price</label>
                              <input id="purchase_price" type="text"
                                 class="form-control"
                                 name="purchase_price"
                                 placeholder="Enter Purchase Price" />
                              </div>
                              </div>
                              <div class="col-md-6">
                              <div class="form-group">
                              <label>Sales Price</label>
                              <input id="sale_price" type="text"
                                 class="form-control "
                                 name="sale_price"
                                 placeholder="Enter Sales Price" />
                              </div>
                              </div>
                              <div class="col-md-6">
                              <div class="form-group">
                              <label>Store</label>
                              <input id="store" type="text"
                                 class="form-control "
                                 name="store" placeholder="Store" />
                              </div>
                              </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                  <label>Product Image</label>
                                  <input id="store" type="file"
                                     class="form-control "
                                     name="uploadPhoto" />
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
                              <div class="table-responsive">
                                 <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                       <tr>
                                          <th>ID</th>
                                          <th>Product Name</th>
                                          <th>Description</th>
                                          <th>Category</th>
                                          <th>Brand</th>
                                          <th>Purchase A/C</th>
                                          <th>Sales A/C</th>
                                          <th>Purchase Price</th>
                                          <th>Sale Price</th>
                                          <th>Store</th>
                                          <th></th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       
                                          <?php 

                          $sql="SELECT * FROM products";
                          $result=mysqli_query($con,$sql);

                          while ($rows=mysqli_fetch_assoc($result)) {

                           ?>

                           <tr>
        <td><?php echo $rows['id']; ?></td>
        <td><a href="product_profile.php?id=<?php echo $rows['id']; ?>"><?php echo $rows['name']; ?></a></td>
        <td><?php echo $rows['description']; ?></td>
        <td><?php echo $rows['category']; ?></td>
        <td><?php echo $rows['brand']; ?></td>
        <td><?php echo $rows['purchase_ac']; ?></td>
        <td><?php echo $rows['sales_ac']; ?></td>
        <td><?php echo $rows['purchase_price']; ?></td>
        <td><?php echo $rows['sale_price']; ?></td>
        <td><?php echo $rows['store']; ?></td>
       <td style="text-align:right">
        <a class="btn btn-info" href="product_profile_edit.php?id=<?php echo $rows['id']; ?>"><i class="fas fa-edit"></i></a>
        <a class="btn btn-success" href="product_profile.php?id=<?php echo $rows['id']; ?>"><i class="fas fa-eye"></i>
        </a>
        <a onclick=" return confirm('Are You Sure');" class="btn btn-danger" href="product_delete.php?id=<?php echo $rows['id']; ?>"><i class="fas fa-trash"></i>
        </a>

        </td>
        </tr>
                       <?php } ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
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
        
        <script type="text/javascript">
         $(document).ready(function() {

            $("#porduct_table").DataTable();
             //add customer
             $("#product_add").click(function() {
                var pdname=$("#pdname").val();
                var desc=$("#desc").val();
                var category=$("#category").val();
                var brand=$("#brand").val();
                var purchase_ac=$("#purchase_ac").val();
                var sales_ac=$("#sales_ac").val();
                var purchase_price=$("#purchase_price").val();
                var sale_price=$("#sale_price").val();
                var store=$("#store").val();
         
                 
         
                 if (pdname.length==0) {
                    toastr.error('Product Name is required');
                 }else if(desc.length==0){
                    toastr.error('Description is required');
                 }else if(category.length==0){
                    toastr.error('Category is required');
                 }else if(brand.length==0){
                    toastr.error('Brand is required');
                 }else if(purchase_ac.length==0){
                    toastr.error('Purchase A/C number required');
                 }else if(sales_ac.length==0){
                    toastr.error('Sale A/C number required');
                 }else if(purchase_price.length==0){
                    toastr.error('Purchase Price required');
                 }else if(sale_price.length==0){
                    toastr.error('Sale Price number required');
                 }else if(store.length==0){
                    toastr.error('Store required');
                 }else{
                    
                    var productData = $("#prduct_form").serialize();
                    alert(productData);
                    $.ajax({
                     type: "GET",
                      url: "include/product.php?add",
                     data: productData,
                     cache: false,
                     success: function(response) {
                         toastr.success('Product Added');
                        $("#addModal").modal('hide');
                        
                        //$("#customer-list").load("include/customers.php?list");
                     }
                 });
                 }
                 
         
         
             });
         });
         //delete Button
             
      </script>
    </body>
</html>
