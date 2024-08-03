<?php 
include("include/security_token.php");
include "include/db_connect.php";
include("include/users_right.php");
include("include/pop_security.php");
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
                            <h4 class="page-title">Supplier</h4>
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
                                            <p class="text-primary mb-0 hover-cursor">Supplier</p>
                                        </div>


                                    </div>
                                    <br>


                                </div>
                                <div class="d-flex justify-content-between align-items-end flex-wrap">
                                    <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"
                                 data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" style="margin-bottom: 12px;">&nbsp;&nbsp;&nbsp;New
                              Supplier</button>
                          </div>
                            </div>
                        </div>
                    </div>






                    <div class="modal fade bs-example-modal-lg" id="client-add-popup" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true" >
                     <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content col-md-10">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel"><span
                                 class="mdi mdi-account-check mdi-18px"></span> &nbsp;New Supplier</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div>
                              <!--supplier form start-->
                              <form id="supplier_form">
                                 <div>
                                    <div class="card">
                                       <div class="card-body">
                              <form class="form-sample">
                              <div class="row">
                              <div class="col-md-6">
                              <div class="form-group ">
                              <label>Full Name</label>
                              <input id="fullname" type="text"
                                 class="form-control "
                                 name="fullname"
                                 placeholder="Enter Your Fullname" />
                              </div>
                              </div>
                              <div class="col-md-6">
                              <div class="form-group">
                              <label>Company</label>
                              <input id="company" type="text"
                                 class="form-control "
                                 name="company"
                                 placeholder="Enter Company Name" />
                              </div>
                              </div>
                              <div class="col-md-6">
                              <div class="form-group">
                              <label>Status</label>
                              <select id="" name="status" class="form-control ">
                                 <option value="1">Active</option>
                                 <option value="0">Disable</option>
                                 <option value="2">Expired</option>
                              </select>
                              </div>
                              </div>
                              <div class="col-md-6">
                              <div class="form-group">
                              <label>Mobile no.</label>
                              <input id="mobile" type="text"
                                 class="form-control "
                                 name="mobile"
                                 placeholder="Enter Your Mobile Number" />
                              </div>
                              </div>

                              <div class="col-md-6">
                              <div class="form-group">
                              <label>Email</label>
                              <input id="email" type="email"
                                 class="form-control "
                                 name="email" placeholder="Enter Your Email" />
                              </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="from-group">
                                    <label>Address</label>
                              <input id="address" type="text"
                                 class="form-control "
                                 name="address"
                                 placeholder="Enter Your Addres" />
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
                              <button type="button" class="btn btn-secondary"
                                 data-bs-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="supplier_add">Add Supplier</button>
                           </div>
                        </div>
                     </div>
                  </div>







                    <div class="row mt-1">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-6 float-md-right grid-margin-sm-0">
                                    </div>


                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                               <tr>
                                                  <th>ID</th>
		                                          <th>Full Name</th>
		                                          <th>Company</th>
                                                  <th>Status</th>
		                                          <th>Mobile</th>
		                                          <th>Email</th>
		                                          <th></th>
                                               </tr>
                                            </thead>
                                            <tbody id="supplier_list">
                                         <?php 

                          $sql="SELECT * FROM suppliers";
                          $result=mysqli_query($con,$sql);

                          while ($rows=mysqli_fetch_assoc($result)) {

                           ?>

                           <tr>
        <td><?php echo $rows['id']; ?></td>
        <td><a href="supplier_profile.php?clid=<?php echo $rows['id']; ?>"><?php echo $rows["fullname"]; ?></a></td>
        <td><?php echo $rows["company"]; ?></td>
        <td>
        <?php 
        $status=$rows["status"];
        if ($status==1) {
            echo '<span class="badge bg-success">Active</span>';
        }else if($status==2){
           echo '<span class="badge bg-danger">In Active</span>';  
        }

         ?>

        </td>
        <td><?php echo $rows["mobile"]; ?></td>
        <td><?php echo $rows['email']; ?></td>
       <td style="text-align:right">
        <a class="btn btn-info" href="supplier_edit.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-edit"></i></a>
        <a class="btn btn-success" href="supplier_profile.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-eye"></i>
        </a>
        <a onclick=" return confirm('Are You Sure');" class="btn btn-danger" href="supplier_delete.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-trash"></i>
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
            $("#supplier_table").DataTable();
             $("#supplier-list").load("include/supplier.php?list");
        $.ajax({
            type: "GET",
            url: "include/supplier_data.php?list",
            cache: false,
            success: function(list) {
                $("#supplier-list").html(list);
            }
        });



            //supplier Add
            $("#supplier_add").click(function(){
                var fullname=$("#fullname").val();
                var company=$("#company").val();
                var mobile=$("#mobile").val();
                var email=$("#email").val();
                var address=$("#address").val();
                if (fullname.length==0) {
                    toastr.error("Full name required");
                }else if(company.length==0){
                    toastr.error("Company name required");
                }else if(mobile.length==0){
                    toastr.error("Mobile number required");
                }else if(email.length==0){
                    toastr.error("Email required");
                }else if(address.length==0){
                    toastr.error("Address required");
                }else{
                var formData=$("#supplier_form").serialize();
                   $.ajax({
                      type:"GET",
                      data:formData,
                      url:"include/supplier_data.php?add",
                      cache:false,
                      success:function(){
                        toastr.success("Supplier Add Successfully");
                            $("#client-add-popup").modal('hide');
                         setTimeout(()=>{location.reload();},1000);
                      }
                   });
                }
               
            });
         });
      </script>

    </body>
</html>
