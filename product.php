<?php
include("include/security_token.php");
include("include/db_connect.php");
include("include/users_right.php");
include("include/pop_security.php");
?>

<!doctype html>
<html lang="en">
    <head>
    
        <meta charset="utf-8">
        <title>FAST-ISP-BILLING-SOFTWARE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include 'style.php';?>
    </head>

    <body data-sidebar="dark">


       

        <!-- Begin page -->
        <div id="layout-wrapper">
        
           <?php $page_title="Products"; include 'Header.php';?>
        
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
                         <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"data-bs-toggle="modal" data-bs-target="#addproductModal" style="margin-bottom: 12px;">&nbsp;&nbsp;&nbsp;New Product</button> 
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
                                          <th>Category</th>
                                          <th>Brand</th>
                                          <th>Purchase Price</th>
                                          <th>Sale Price</th>
                                          <th>Store</th>
                                          <th>Quantity</th>
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
        <td>
            <?php 
            $categoryId= $rows['category']; 
            if ($categories = $con->query("SELECT * FROM product_cat WHERE id= '$categoryId' ")) {
                while($row = $categories->fetch_array()){
                    echo $row['name'];
                }
            }
            ?>
        </td>
        <td>
        <?php 
            $brandId= $rows['brand']; 
            if ($brands = $con->query("SELECT * FROM product_brand WHERE id= '$brandId' ")) {
                while($row = $brands->fetch_array()){
                    echo $row['name'];
                }
            }
            ?>
        </td>
        <td><?php echo $rows['purchase_price']; ?></td>
        <td><?php echo $rows['sale_price']; ?></td>
        <td>
        <?php 
            $storeid= $rows['store']; 
            if ($stores = $con->query("SELECT * FROM store WHERE id= '$storeid' ")) {
                while($row = $stores->fetch_array()){
                    echo $row['name'];
                }
            }
            ?> 
            
        </td>
        <td><?php echo $rows['qty']; ?></td>
       <td style="text-align:right">
        <a class="btn-sm btn btn-info" href="product_profile_edit.php?id=<?php echo $rows['id']; ?>"><i class="fas fa-edit"></i></a>
        <a class="btn-sm btn btn-success" href="product_profile.php?id=<?php echo $rows['id']; ?>"><i class="fas fa-eye"></i>
        </a>
        <a onclick=" return confirm('Are You Sure');" class="btn-sm btn btn-danger" href="product_delete.php?id=<?php echo $rows['id']; ?>"><i class="fas fa-trash"></i>
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
        <?php include 'modal/product_modal.php'; ?>
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
        <?php include 'script.php';?>
        <script src="modal/product_modal.js"></script>
        
    </body>
</html>
