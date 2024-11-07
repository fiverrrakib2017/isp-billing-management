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
                                          <th>Purchase Price</th>
                                          <th>Sale Price</th>
                                          <th>unit</th>
                                          <th>Store</th>
                                          <th>Quantity</th>
                                          <th></th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       
                                        <?php
                                        
                                        $sql = "SELECT  p.id, 
                                        p.name, 
                                        p.purchase_price, 
                                        p.sale_price, 
                                        u.unit_name,
                                        s.name AS store_name, 
                                        IFNULL(purchase_qty.total_purchase_qty, 0) - IFNULL(sale_qty.total_sale_qty, 0) AS current_qty
                                    FROM 
                                        products p
                                    LEFT JOIN 
                                        units u ON p.unit_id = u.id
                                    LEFT JOIN 
                                        store s ON p.store = s.id
                                    LEFT JOIN 
                                        (SELECT product_id, SUM(qty) AS total_purchase_qty 
                                         FROM purchase_details 
                                         WHERE status = 1  -- এখানে স্ট্যাটাস চেক করা হচ্ছে
                                         GROUP BY product_id) AS purchase_qty 
                                        ON p.id = purchase_qty.product_id
                                    LEFT JOIN 
                                        (SELECT product_id, SUM(qty) AS total_sale_qty 
                                         FROM sales_details 
                                         WHERE status = 1  -- এখানে স্ট্যাটাস চেক করা হচ্ছে
                                         GROUP BY product_id) AS sale_qty 
                                        ON p.id = sale_qty.product_id";
                            
                            $result = mysqli_query($con, $sql);
                            
                            while ($rows = mysqli_fetch_assoc($result)) {
                            ?>
                            
                                <tr>
                                    <td><?php echo $rows['id']; ?></td>
                                    <td><a href="product_profile.php?id=<?php echo $rows['id']; ?>"><?php echo $rows['name']; ?></a></td>
                                    <td><?php echo $rows['purchase_price']; ?></td>
                                    <td><?php echo $rows['sale_price']; ?></td>
                                    <td><?php echo $rows['unit_name']; ?></td>
                                    <td><?php echo $rows['store_name']; ?></td>
                                    <td>
                                        <?php if ($rows['current_qty'] == 0) { ?>
                                            <span class="badge bg-danger">0</span>
                                        <?php } else { ?>
                                            <?php echo $rows['current_qty']; ?>
                                        <?php } ?>
                                    </td>
                                    <td style="text-align:right">
                                        <a class="btn-sm btn btn-info" href="product_profile_edit.php?id=<?php echo $rows['id']; ?>"><i class="fas fa-edit"></i></a>
                                        <a class="btn-sm btn btn-success" href="product_profile.php?id=<?php echo $rows['id']; ?>"><i class="fas fa-eye"></i></a>
                                        <a onclick=" return confirm('Are You Sure');" class="btn-sm btn btn-danger" href="product_delete.php?id=<?php echo $rows['id']; ?>"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            
                            <?php 
                            } 
                            
                                        
                                        ?> 

                         
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

    <?php include 'Footer.php';?>

</div>
<!-- end main content-->
        
        </div>
        <?php include 'modal/product_modal.php'; ?>
        <!-- END layout-wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <?php include 'script.php';?>
        <script src="modal/product_modal.js"></script>
        
    </body>
</html>
