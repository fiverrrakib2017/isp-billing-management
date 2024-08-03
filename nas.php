<?php
include("include/security_token.php");
include("include/db_connect.php");
include("include/pop_security.php");
include("include/users_right.php");
require('routeros/routeros_api.class.php');
?>

<!doctype html>
<html lang="en">
    <head>
    
        <meta charset="utf-8">
        <title>FAST-ISP-BILLING-SOFTWARE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
        <meta content="Themesbrand" name="author">
        <!-- DataTables -->
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
        <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">
    
        <!-- Responsive datatable examples -->
        <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
    
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="css/toastr/toastr.min.css">
        <link rel="stylesheet" type="text/css" href="css/deleteModal.css">
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
                            <h4 class="page-title">NAS</h4>
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
                              <p class="text-primary mb-0 hover-cursor">NAS</p>
                           </div>
                        </div>
                        <br>
                     </div>
                     <div class="d-flex justify-content-between align-items-end flex-wrap">
                        <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px" id="addBtn" style="margin-bottom: 12px;">&nbsp;&nbsp;New NAS</button>
                     </div>

                     <div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" id="addModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel"><span
                                 class="mdi mdi-account-check mdi-18px"></span> &nbsp;New NAS</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="">
                               <form id="customer_form">
                                  <div class="card">
                                      <div class="card-body">
                                         <div class="row">
                                              <div class="col-md-6">
                                                 <div class="form-group mb-2">
                                                        <label>Name</label>
                                                        <input id="name" type="text"
                                                         class="form-control "
                                                         placeholder="Enter Your Name" />
                                                  </div> 
                                              </div>
                                              <div class="col-md-6">
                                                 <div class="form-group mb-2">
                                                        <label>IP</label>
                                                        <input id="ip" type="text"
                                                         class="form-control "
                                                         placeholder="Enter Your IP" />
                                                  </div> 
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-md-6">
                                                   <div class="form-group mb-2">
                                                        <label>Radius Secret</label>
                                                        <input id="secret" type="text"class="form-control "
                                                         placeholder="Enter Radius Secret" />
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                 <div class="form-group mb-2">
                                                        <label>Radius Inc. Port</label>
                                                        <input id="port" type="text"class="form-control "
                                                         placeholder="Enter Radius Secret" />
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-md-6 ">
                                                 <div class="form-group mb-2">
                                                  <label>API User</label>
                                                      <input id="api_user" type="text"class="form-control "
                                                         placeholder="Enter API User" />
                                                  </div> 
                                              </div>
                                              <div class="col-md-6 ">
                                                  <div class="form-group mb-2">
                                                       <label>API Password</label>
                                                      <input id="api_pass" type="text"class="form-control "
                                                         placeholder="Enter API Password" />
                                                  </div> 
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-md-6">
                                                 <div class="form-group mb-2">
                                                   <label>Port</label>
                                                    <input id="port" type="text" class="form-control"
                                                     placeholder="Enter Your Port" />
                                                  </div> 
                                              </div>
                                              <div class="col-md-6">
                                                 <div class="form-group mb-2">
                                                  <label>Email</label>
                                                  <input id="email" type="email"
                                                     class="form-control"
                                                     placeholder="Enter Your Email" />
                                                  </div> 
                                              </div>
                                          </div>  
                                      </div>
                                  </div> 
                               </form> 
                            </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-success" id="customer_add">Add Now</button>
                           </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
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
                  <div class="table-responsive ">
                    <table id="customers_table" class="table table-striped table-bordered  nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                           <tr>
                                <th>Name</th>
                                <th>IP</th>
                                <th>Secret</th>
                                <th>Api User</th>
                                <th>Description</th>
                                <th>Server</th>
                                <th>&nbsp;</th>
                           </tr>
                        </thead>
                        <tbody id="customer-list">
                           <?php 
                          $sql="SELECT * FROM nas";
                          $result=mysqli_query($con,$sql);

                          while ($rows=mysqli_fetch_assoc($result)) {
                            $nasname = $rows['nasname'];
                            $api_usr = $rows['api_user'];
                            $api_pswd = $rows['api_password'];
                            //$api_usr = $rows['api_user'];
                           ?>

                           
                           
                            
                            

                           <tr>
                            <td>
                            <?php echo $rows['shortname']."<br>";
                            //print_r($READ);
                            /*
                            echo $READ['0']['uptime']."<br>";
                            echo $READ['0']['platform']."<br>";
                            echo $READ['0']['version']."<br>";
                            echo $READ['0']['architecture-name']."<br>";
                            echo $READ['0']['cpu']."<br>";
                            echo $READ['0']['cpu-count']."Core <br>";
                            echo $READ['0']['cpu-frequency']/(1000)." GHz <br>";
                            */
                            $API = new RouterosAPI();
                            if ($API->connect($nasname, $api_usr, $api_pswd)) {
                            $API->write('/system/resource/print');

                            $READ = $API->read(true);   
                            echo "Platform-".$READ['0']['platform'].", Version-".$READ['0']['version']."<br/> CPU-".$READ['0']['architecture-name']." ".$READ['0']['cpu-count']."Core ".$READ['0']['cpu-frequency']/(1000)."GHz <br>";
                            }
                            $API->disconnect();
                            
                            
                            
                            ?>
                            </td>
                            <td><?php echo $host=$rows['nasname'];?>
                            <br/>
                            <div id="pingchk"></div>


                        
                        
                        </td>
                            <td><?php echo $rows['secret']; ?></td>
                            <td><?php echo $rows['api_user']; ?></td>
                            <td><?php echo $rows['description']; ?></td>
                            <td><?php echo $rows['server']; ?></td>
                            <td>
                                <a href="include/nas_delete.php?clid=<?php echo $rows['id']; ?>" class="btn-sm btn btn-danger" onclick=" return confirm('Are You Sure');">Delete
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
        
        <div id="deleteModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header flex-column">
                <div class="icon-box">
                    <i class="fa fa-trash"></i>
                </div>
                <h4 class="modal-title w-100">Are you sure?</h4>
                <h4 class="modal-title w-100 " id="DeleteId">1</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="True">&times;</button>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="DeleteConfirm">Delete</button>
            </div>
        </div>
    </div>
</div>
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





    </body>
</html>
