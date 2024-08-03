<?php 
include "include/db_connect.php";
include("include/security_token.php");
include("include/users_right.php");
if(isset($_GET['clid'])){
    
   $clid =$_GET['clid'];
if ($cstmr = $con -> query("SELECT * FROM customers WHERE id='$clid' AND pop='$auth_usr_POP_id' ")) {
  
  while($rows= $cstmr->fetch_array())
  {
      $lstid = $rows["id"];
      $fullname = $rows["fullname"];
      $package = $rows["package"];
      $username = $rows["username"];
      $password = $rows["password"];
      $mobile = $rows["mobile"];
      $area = $rows["area"];
      $address = $rows["address"];
      $nid=$rows['nid'];
      $remarks=$rows['remarks'];
      $con_charge=$rows['con_charge'];
}
}
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
        <link href="assets/css/custom.css" id="app-style" rel="stylesheet" type="text/css">
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
                            <h4 class="page-title">Customers Update</h4>
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
               <div class="col-md-6 m-auto">
                   <div class="card">
                       <div class="card-header">Update Customer</div>
                       <div class="card-body">
                           <div class="row">
                               <div class="col-sm">
                                   <div class="form-group mb-2">
                                      <label>Fullname</label>
                                        <input type="text" id="userUpdateId" class="d-none" value="<?php echo $lstid;?>" name="id">

                                        <input type="text" id="fullname" class="form-control" value="<?php echo $fullname;?>" name="fullname">
                                   </div>
                                </div>
                                <div class="col-sm">
                                   <div class="form-group mb-2">
                                        <label>User Name </label>
                                        <input id="username" type="text" class="form-control" name="username"
                                        value="<?php echo $username; ?>"/>
                                   </div>
                                </div>
                           </div>
                           <div class="row">
                               <div class="col-sm">
                                   <div class="form-group mb-2">
                                      <label>Password</label>
                                    <input id="password" name="password" type="text" class="form-control"
                                        value="<?php echo $password; ?>"/>
                                   </div>
                                </div><div class="col-sm">
                                   <div class="form-group mb-2">
                                       <label>Mobile no.</label>
                                    <input id="mobile" type="text" class="form-control" name="mobile"value="<?php echo $mobile; ?>" />
                                   </div>
                                </div>
                           </div>
                           <div class="row">
                               <div class="col-sm">
                                   <div class="form-group mb-2">
                                       <label>Area/Location</label>
                                       <select id="area" class="form-select" name="area">
                                        <option value="<?php echo $area; ?>">
                                           <?php 

                                        $areaId =$area; 

                                        $allArea=$con->query("SELECT * FROM area_list WHERE id=$areaId AND pop_id='$auth_usr_POP_id' ");
                                            while ($rows=$allArea->fetch_array()) {
                                               echo $rows['name'];
                                            }

                                        ?>                                                
                                        </option>
                                       <?php 
                                        if ($area = $con-> query("SELECT * FROM area_list WHERE pop_id='$auth_usr_POP_id' ")) {
                                            while($rows= $area->fetch_array()){

                                               
                                                $name = $rows["name"];
                                                $id = $rows["id"];
                                                
                                                echo '<option value='.$id.'>'.$name.'</option>';
                                            }
                                        }
                                        
                                        ?> 
                                    </select>
                                   </div>
                                </div>
                                <div class="col-sm">
                                   <div class="form-group mb-2">
                                      <label>Package</label>
                                    <select id="package" class="form-select" name="package">
                                    <option value="<?php echo $package; ?>">

                                        <?php 

                                        $packageNameId =$package; 

                                        $allPackageee=$con->query("SELECT * FROM radgroupcheck WHERE id=$packageNameId ");
                                            while ($popRowwww=$allPackageee->fetch_array()) {
                                               echo $popRowwww['groupname'];
                                            }

                                        ?>
                                            
                                        </option>
                                    <?php

                                  $sql="SELECT * FROM branch_package WHERE pop_id='$auth_usr_POP_id'";
                                $result=mysqli_query($con,$sql);
                                while ($rows=mysqli_fetch_assoc($result)) {
                                 

                                 ?>

                                <option value="<?php echo $rows['name']?>">


                                <?php $packageNameId= $rows['name']; 

                                $allPackageee=$con->query("SELECT * FROM radgroupcheck WHERE id=$packageNameId ");
                                    while ($popRowwww=$allPackageee->fetch_array()) {
                                       echo $popRowwww['groupname'];
                                    }

                                ?>
                                        

                                </option>

                             <?php } ?>
                         </select>
                                   </div>
                                </div>
                           </div>
                           <div class="row">
                               <div class="col-sm">
                                   <div class="form-group mb-2">
                                       <label>Addres</label>
                                       <input id="address" type="text" class="form-control" name="address" value="<?php echo $address; ?>" />
                                   </div>
                               </div>
                               <div class="col-sm">
                                   <div class="form-group mb-2">
                                       <label>Nid Card Number</label>
                                        <input id="nid" type="text" class="form-control" name="nid" value="<?php echo $nid; ?>" />
                                   </div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-sm">
                                   <div class="form-group">
                                       <label>Remarks</label>
                                        <textarea  id="remarks" type="text" class="form-control" name="remarks" ><?php echo $remarks; ?></textarea>
                                   </div>
                               </div>
                               <div class="col-sm">
                                   <div class="form-group">
                                       <label>Connection Charge</label>
                                        <input  id="connection_charge" type="text" class="form-control" name="remarks" value="<?php echo $con_charge;?>" />
                                   </div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-sm">
                                   <button id="updateBtn" type="button" class="btn btn-success mt-3">Update Now</button>
                                   <button class="btn btn-danger mt-3"type="button" onclick="history.back();">Back</button>
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
        $(document).ready(function(){
            $("#updateBtn").click(function(){
                
                var id=$("#userUpdateId").val();
                var fullname=$("#fullname").val();
                var username=$("#username").val();
                var password=$("#password").val();
                var mobile=$("#mobile").val();
                var area=$("#area").val();
                var package=$("#package").val();
                var address=$("#address").val();
                var nid=$("#nid").val();
                var remarks=$("#remarks").val();
                var connection_charge=$("#connection_charge").val();
                if (fullname.length==0) {
                    toastr.error("Fullnae is require");
                }else if(username.length==0){
                    toastr.error("Username is require");
                }else if(password.length==0){
                    toastr.error("Password is require");
                }else if(mobile.length==0){
                    toastr.error("Mobile is require");
                }else if(area.length==0){
                    toastr.error("Area is require");
                }else if(package.length==0){
                    toastr.error("Package is require");
                }else if(address.length==0){
                    toastr.error("Address is require");
                }else if(nid.length==0){
                    toastr.error("Nid Number is require");
                }else if(remarks.length==0){
                    toastr.error("Remarks is require");
                }else if(connection_charge.length==0){
                    toastr.error("Connection is require");
                }else{
                    updateCustomer="0";
                    $.ajax({
                        type:'POST',
                          url:'include/customers.php',
                        data:{id:id,fullname:fullname,username:username,password:password,mobile:mobile,area:area,package:package,address:address,nid:nid,remarks:remarks,connection_charge:connection_charge,updateCustomer:updateCustomer},
                        success:function(response){
                            if (response==1) {
                                 toastr.success("Update Successfully");

                             }else{
                                 toastr.error("Data not Update");
                             }
                         
                        }
                    });
                }
                
            });
        });
    </script>

    </body>
</html>
