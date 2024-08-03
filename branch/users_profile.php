<?php
include("include/security_token.php");
include("include/users_right.php");
?>

<?php
include "include/db_connect.php";
if (isset($_GET["id"])) {

    $userId=$_GET["id"];

    if ($userData=$con->query("SELECT *FROM users WHERE id='$userId'")) {

        while ($rows=$userData->fetch_array()) {

            $userId=$rows["id"];

            $fullname=$rows["fullname"];

            $username=$rows["username"];

            $password=$rows["password"];

            $mobile=$rows["mobile"];

            $email=$rows["email"];

            $role=$rows["role"];

            $last_login=$rows["lastlogin"];
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
                            <h4 class="page-title">User Profile</h4>
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
               <div class="container">
                    <div class="main-body">

                        <div class="row gutters-sm">
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center profile">
                                            <img src="images/avatar.png" alt='profile' class="rounded-circle"
                                                width="150" />
                                            <div class="imgUpIcon">
                                                <button id="uploadBtn" data-bs-toggle="modal"
                                                    data-bs-target="#Profile_pic_upload_Modal" type="button">
                                                    <i class="mdi mdi-camera"></i>
                                                </button>

                                            </div>
                                            <div class="mt-3">
                                                <h4>
                                                    <?php echo $fullname; ?><br>
                                                    (<?php echo $userId; ?>)
                                                </h4>
                                                <p class="text-secondary mb-1"><?php echo $mobile; ?></p>
                                                <p class="text-muted font-size-sm"><?php echo $address; ?></p>
                                                <button class="btn btn-primary">Print</button>
                                                <button class="btn btn-outline-primary">Message</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
               <div class="card-body">
                   <div class="col-12 bg-white p-0 px-2 pb-3 mb-3">
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class="mdi mdi-marker-check"></i> Fullname:</p> <a href="#"><?php echo $fullname; ?></a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class="mdi mdi-account-circle"></i>   Username:</p> <a href="#"><?php echo $username; ?></a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class="mdi mdi-phone"></i> Mobile:</p> <a href="#"><?php echo $mobile; ?></a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class=" fas fa-envelope"></i> Email:</p> <a href="#"><?php echo $email; ?></a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class="fas fa-location-arrow"></i> Area:</p> <a href="#"><?php echo $area; ?></a>
                    </div>
                </div>
               </div>
           </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Full Name</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $fullname; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Username</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $username;?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Password</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $password; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Mobile</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $mobile; ?>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Email</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $email; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Role</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $role; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Last Login</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $last_login; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <a class="btn btn-info "
                                                    href="users_profile_edit.php?id=<?php echo $userId; ?>">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Hoverable Table</h4>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>User</th>
                                                        <th>Product</th>
                                                        <th>Sale</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Jacob</td>
                                                        <td>Photoshop</td>
                                                        <td class="text-danger"> 28.76% <i
                                                                class="mdi mdi-arrow-down"></i></td>
                                                        <td><label class="badge badge-danger">Pending</label></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Messsy</td>
                                                        <td>Flash</td>
                                                        <td class="text-danger"> 21.06% <i
                                                                class="mdi mdi-arrow-down"></i></td>
                                                        <td><label class="badge badge-warning">In progress</label></td>
                                                    </tr>
                                                    <tr>
                                                        <td>John</td>
                                                        <td>Premier</td>
                                                        <td class="text-danger"> 35.00% <i
                                                                class="mdi mdi-arrow-down"></i></td>
                                                        <td><label class="badge badge-info">Fixed</label></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Peter</td>
                                                        <td>After effects</td>
                                                        <td class="text-success"> 82.00% <i
                                                                class="mdi mdi-arrow-up"></i></td>
                                                        <td><label class="badge badge-success">Completed</label></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dave</td>
                                                        <td>53275535</td>
                                                        <td class="text-success"> 98.05% <i
                                                                class="mdi mdi-arrow-up"></i></td>
                                                        <td><label class="badge badge-warning">In progress</label></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
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

<!-- Modal for profile picture upload -->
                <div class="modal fade" id="Profile_pic_upload_Modal" tabindex="-1" role="dialog"
                    aria-labelledby="Profile_pic_upload_Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="Profile_pic_upload_Label">Upload Profile Picture</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form enctype="multipart/form-data" method="POST">
                                    <input class="d-none" type="text" name="profile_pic_id" value="<?php echo $lstid; ?>">
                                    <input type="file" name="photo" class="form-control"><br>

                                    <button name="upload" class="btn btn-primary">Upload Now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<!-- Modal for Complain -->
                <div class="modal fade" id="ComplainModalCenter" tabindex="-1" role="dialog"
                    aria-labelledby="ComplainModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ComplainModalLongTitle">
                                    Complain Box
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="from-group">
                                        <label>Name:</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Name">
                                    </div><br>
                                    <div class="form-group">
                                        <label for=""> Complain Type </label>
                                <select id="form" name="complain_type" id="" class="form-control form-control-sm">
                                    <option value="">Select</option>
                                    <option value="Disconnect/Discontinue">Disconnect/Discontinue</option>
                                    <option value="Fibre Down">Fibre Down</option>
                                    <option value="Router re-configure">Router re-configure</option>
                                    <option value="New Connection">New Connection</option>
                                    <option value="Connection Shift">Connection Shift</option>
                                    <option value="Connection Problem">Connection Problem</option>
                                    <option value="Internet Speed">Internet Speed</option>
                                    <option value="Other">Other</option>
                                    <option value="ONU Power Off">ONU Power Off</option>
                                    <option value="ONU Wire Down">ONU Wire Down</option>
                                    <option value="Line Problem">Line Problem</option>
                                </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Complain Box</label>
                                        <input name="" id="" placeholder="Enter Here Complain" class="form-control" />
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
<!-- Modal for Recharge -->
                <div class="modal fade" id="rechargeModal" tabindex="-1" role="dialog"
                    aria-labelledby="ComplainModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ComplainModalLongTitle">
                                    Recharge
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="recharge-form" method="POST">
                                    <div class="from-group">
                                        <label>Previous Balance</label>
                                        <input disabled="Disable" type="text" class="form-control form-control-sm" placeholder="00">
                                    </div><br>
                                    <div class="form-group d-none" >
                                        <label for="">Username</label>
                                        <input id="form" type="text" name='customer_name' value="<?php echo $username; ?>" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group">
                                        <label>Month</label>
                                        <select id="form" class="form-control form-control-sm" name='month'>
                                            <option value="01">1</option>
                                            <option value="02">2</option>
                                            <option value="03">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Package</label>
                                        <select id="form" name="package" class="form-control form-control-sm">
                                            <option value="">Select Package</option>
                                            <?php 
                                            if ($package_p=$con->query("SELECT * FROM radpackageprice")) {
                                                while($rows=$package_p->fetch_array()){
                                                    $name=$rows["packagename"];
                                                    $price=$rows["sprice"];
                                                    echo '<option value='.$name.' ('.$price.')>'.$name.' ('.$price.')</option>';
                                                }
                                            }

                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Amount:</label>
                                        <strong><input id="form" type="text" name='amount' class="form-control form-control-sm"></strong>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button id="recharge-button" type="button" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>











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
        
        
        <!-- Peity chart-->
        <script src="assets/libs/peity/jquery.peity.min.js"></script>
        
        <!--C3 Chart-->
        <script src="assets/libs/d3/d3.min.js"></script>
        <script src="assets/libs/c3/c3.min.js"></script> 
        <script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>
        
        <script src="assets/js/pages/dashboard.init.js"></script>
        
        <script src="assets/js/app.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

        <!-- Required datatable js -->
        <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="assets/js/pages/datatables.init.js"></script> 

        <script src="assets/js/app.js"></script>
        <script type="text/javascript" src="assets/js/js-fluid-meter.js"></script>
 <script type="text/javascript">
     $(document).ready(function(){
        $("#tickets_table").DataTable();
        $('#example').DataTable();
        $("#recharge-button").click(function(){
            var formData=$("#recharge-form").serialize();
            alert(formData);
            $.ajax({
                type:"GET",
                url:"include/customer_recharge.php?add",
                data:formData,
                success:function(rsps){
                    //alert(rsps);
                }
            });
        });
     });
 </script> 

    </body>
</html>
