<?php


include("../include/db_connect.php");

if (isset($_POST['marketing_client_add'])) {
    $company_name = $_POST['company_name'];
    $contact_name = $_POST['contact_name'];
    $mobile_number = $_POST['mobile_number'];
    $mobile_number2 = $_POST['mobile_number2'];
    $area = $_POST['area'];
    $address = $_POST['address'];
    $details=$_POST['details'];
    $comMatch=$con->query("SELECT * FROM marketing_client WHERE company_name='$company_name'");
    $count=$comMatch->num_rows;
    if ($count >0) {
        echo "<script>alert('Company Name Already Taken');</script>";
    }else{
       $result=$con->query("INSERT INTO marketing_client(company_name,contact_name,mobile_number,mobile_number2,area,address,details) VALUES('$company_name','$contact_name','$mobile_number','$mobile_number2','$area','$address','$details')");
    if ($result==true) {
       echo "<script>alert(Data insert successfully);</script";
    }else{
        echo "<script>alert(Error!!!);</script";
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
        <link rel="../shortcut icon" href="assets/images/favicon.ico">
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
        <!-- C3 Chart css -->
        <link href="../assets/libs/c3/c3.min.css" rel="stylesheet" type="text/css">
    
        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css">
        <!-- App Css-->
        <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
    
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
                                    <img src="../assets/images/it-fast.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="../assets/images/it-fast.png" alt="" height="17">
                                </span>
                            </a>

                            <a href="index.php" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="../assets/images/it-fast.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="../assets/images/it-fast.png" alt="" height="36">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                            <i class="mdi mdi-menu"></i>
                        </button>

                        <div class="d-none d-sm-block ms-2">
                            <h4 class="page-title">Marketing Client</h4>
                        </div>
                    </div>

                    <!-- Search input -->
                    <div class="search-wrap" id="search-wrap">
                        <div class="search-bar">
                            <input class="search-input form-control" placeholder="Search">
                            <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                                <i class="mdi mdi-close-circle"></i>
                            </a>
                        </div>
                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-none d-lg-inline-block me-2">
                            <button type="button" class="btn header-item toggle-search noti-icon waves-effect" data-target="#search-wrap">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </div>

                        <div class="dropdown d-none d-lg-inline-block me-2">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                                <i class="mdi mdi-fullscreen"></i>
                            </button>
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

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="../assets/images/users/avatar-1.jpg" alt="Header Avatar">
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="#">Profile</a>
                                <a class="dropdown-item" href="#">My Wallet</a>
                                <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end">11</span>Settings</a>
                                <a class="dropdown-item" href="#">Lock screen</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                                <i class="mdi mdi-spin mdi-cog"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </header>
        
            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li>
                                <a href="index.php" class="waves-effect">
                                    <i class="mdi mdi-view-dashboard"></i>
                                    <span> Dashboard </span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-account-child-outline"></i>
                                    <span>Marketing</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="marketing_area.php">Marketing Area</a></li>
                                </ul>
                        </ul>
                    </div>
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
                              <p class="text-primary mb-0 hover-cursor">Marketing Client</p>
                           </div>
                        </div>
                        <br>
                     </div>
                     <div class="d-flex justify-content-between align-items-end flex-wrap">
                        <button class="btn btn-primary mt-2 mt-xl-0 mdi mdi-account-plus mdi-18px"data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg"> Add New </button>
                     </div>
                     <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-lg" role="document">
                        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                            <div class="modal-content col-md-10">
                               <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel"><span
                                     class="mdi mdi-account-check mdi-18px"></span> &nbsp;New Marketing Client</h5>
                                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                  </button>
                               </div>
                               <div>
                                  <!--Product form start-->
                                     <div>
                                        <div class="card">
                                           <div class="card-body">
                                  <div class="row">
                                  <div class="col-md-6">
                                  <div class="form-group ">
                                  <label>Company Name</label>
                                  <input id="form" type="text"
                                     class="form-control"
                                     name="company_name"
                                     placeholder="Enter Your Company Name" />
                                  </div>
                                  </div>
                                  <div class="col-md-6">
                                  <div class="form-group ">
                                  <label>Contact Name</label>
                                  <input id="contact_name" type="text"
                                     class="form-control"
                                     name="contact_name"
                                     placeholder="Enter Contact Name" />
                                  </div>
                                  </div> 
                                  <div class="col-md-6">
                                  <div class="form-group">
                                  <label>Area</label>
                                  <select id="form" class="form-control"
                                     name="area">
                                     <?php 
                                        if ($category = $con-> query("SELECT * FROM marketing_area")) {
                                            while($rows= $category->fetch_array()){
                                               
                                                $area = $rows["area"];
                                                
                                                echo '<option value='.$area.'>'.$area.'</option>';
                                            }
                                        }
                                        
                                        ?>

                                  </select>
                                  </div>
                                  </div>
                                  <div class="col-md-6">
                                  <div class="form-group ">
                                  <label>Mobile Number 1</label>
                                  <input id="mobile_number" type="text"
                                     class="form-control"
                                     name="mobile_number"
                                     placeholder="Enter Mobile Number" />
                                  </div>
                                  </div> 
                                  <div class="col-md-6">
                                  <div class="form-group">
                                  <label>Mobile Number 2</label>
                                  <input type="text"
                                     class="form-control"
                                     name="mobile_number2"
                                     placeholder="Enter Mobile Number" />
                                  </div>
                                  </div>
                                  <div class="col-md-6">
                                  <div class="form-group">
                                  <label>Address</label>
                                  <input id="address" type="text"
                                     class="form-control"
                                     name="address"
                                     placeholder="Enter Address" />
                                  </div>
                                  </div>
                                  <div class="col-md-6">
                                  <div class="form-group">
                                  <label>Client Details</label>
                                  <textarea name="details" placeholder="Enter Client Details" class="form-control"></textarea>
                                  </div>
                                  </div>
                                  </div>
                                  </div>
                                  </div>
                                  </div>
                                  <!--Product form end-->
                                 
                               </div>
                               <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary" data-dismiss="modal" name="marketing_client_add"> Add New</button>
                               </div>
                            </div> 
                        </form>
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
                              <div id="alertMsg" class="alert alert-success p-2 mt-3" style="width: 400px; display:none">
                                 <i class="mdi mdi-check-circle"></i>
                                 <strong class="mx-2">Success!</strong> Data Insert 
                              </div>
                              <div class="table-responsive">
                                 <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                       <tr>
                                          <th>ID</th>
                                          <th>Company Name</th>
                                          <th>Contact Name</th>
                                          <th>Mobile Number</th>
                                          <th>Area</th>
                                          <th>Address</th>
                                          <th></th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                        <?php 

                                        if ($product = $con -> query("SELECT * FROM marketing_client")) {
    while($rows= $product->fetch_array())
    {
      $lstid=$rows["id"];
      $company_name=$rows["company_name"];
      $contact_name = $rows["contact_name"];
      $mobile_number = $rows["mobile_number"];
      $mobile_number2=$rows["mobile_number2"];
      $area = $rows["area"];
      $address = $rows["address"];
      $details = $rows["details"];
      echo '
      <tr>
        <td>'.$lstid.'</td>
        <td><a href="marketing_client_profile.php?id='.$lstid.'">'.$company_name.'</a></td>
        <td>'.$contact_name.'</td>
        <td>'.$mobile_number.'</td>
          <td>'.$area.'</td>
             <td>'.$address.'</td>
       <td >
        <a class="btn btn-success" href="marketing_client_profile.php?id='.$lstid.'"><i class="mdi mdi-eye"></i>
        </a>

        </td>
        </tr>
     '; 
    }
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

        

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        
        
        <!-- JAVASCRIPT -->
        <script src="../assets/libs/jquery/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        
        
        <!-- Peity chart-->
        <script src="../assets/libs/peity/jquery.peity.min.js"></script>
        
        <!--C3 Chart-->
        <script src="../assets/libs/d3/d3.min.js"></script>
        <script src="../assets/libs/c3/c3.min.js"></script> 
        <script src="../assets/libs/jquery-knob/jquery.knob.min.js"></script>
        
        <script src="../assets/js/pages/dashboard.init.js"></script>
        
        <script src="../assets/js/app.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

        <!-- Required datatable js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="../assets/js/pages/datatables.init.js"></script> 

        <script src="../assets/js/app.js"></script>
        <script type="text/javascript" src="assets/js/js-fluid-meter.js"></script>
        <!-- <script type="text/javascript">
         $(document).ready(function(){
         
             $("#marketing_client_add").click(function(e) {
                e.preventDefault();
             var formData = $("#marketing_client_form").serialize();
             alert(formData);
             $.ajax({
                 type: "GET",
                 url: "include/marketing_client_server.php?add",
                 data: formData,
                 cache: false,
                 success: function(response) {
                    alert(response.data);
                 // $("#alertMsg").show();
                 // setTimeout(function() { $("#alertMsg").hide(); }, 10000);
                 //     $("#product-list").load("include/product.php?list");
                 }
             });
         });
         });
      </script> -->
    </body>
</html>
