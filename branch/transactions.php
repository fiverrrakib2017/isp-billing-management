<?php 
include "include/db_connect.php"; 
include("include/security_token.php");
include("include/users_right.php");
if (isset($_SESSION['uid'])) {
      $ledgr_id= $_SESSION["uid"];
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
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
      <style type="text/css">
         div#sub_ledgr_table_length {
         display: none;
         }div#sub_ledgr_table_filter {
         display: none;
         }
         .row{
         margin-left: 0px !important;
         margin-right: 0px !important;
         }
         .vl {
         border-bottom: 6px solid green;
         height: 500px;
         }
      </style>
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
                            <h4 class="page-title">Transaction</h4>
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
                     <div class="card ">
                         <div class="container">
                            <div class="row mb-3 mt-1">
                                        <input  name="id" class="form-control d-none" type="text" placeholder="Type Your Id" value="<?php if(isset($_SESSION['uid'])){echo $_SESSION['uid']; } ?>">
                                <div class="col-sm mb-2">
                                    <div class="form-group">
                                       <label>Transaction Type:</label>
                                        <select name="transaction_type" class="form-select">
                                          <option value="">Select</option>
                                          <option value="Income">Income</option>
                                          <option value="Expense">Expense</option>
                                          <option value="Asset">Asset</option>
                                          <option value="Laiblaties">Laiblaties</option>
                                       </select>
                                    </div>
                                </div>
                                <div class="col-sm mb-2">
                                    <div class="form-group">
                                       <label>Client/Supplier</label>
                                       <select class="form-select" name="client" id="">
                            <?php if ($client=$con->query("SELECT * FROM clients")) {
                                while($rows=$client->fetch_array()){
                                    $client_name=$rows["fullname"];
                                    echo '

                                    <option value=".$client_name.">'.$client_name.'</option>

                                    ';
                                }
                            } ?>
                           

                        </select>
                                    </div>
                                </div>
                            </div> 
                            <div class="row mb-3 mt-1">
                                <div class="col-sm mb-2">
                                    <div class="form-group">
                                       <label>Refer No:</label>
                                        <input class="form-control" type="text" placeholder="Type Your Refer No" name="refer_no">
                                    </div>
                                </div>
                                <div class="col-sm mb-2">
                                    <div class="form-group">
                                       <label>Description:</label>
                                        <input class="form-control" type="text" placeholder="Type Your Description" name="description">
                                    </div>
                                </div>
                                <div class="col-sm mb-2">
                                    <div class="form-group">
                                       <label>Date</label>
                                        <input class="form-control" type="text" name="date" value="<?php echo $date = date('m/d/Y ', time()); ?>">
                                    </div>
                                </div>
                            </div> 
                         </div>
                     </div>
                     <div class="card">
                        <div class="container">
                            <div class="row mb-3 mt-1">
                               <div class="col-sm">
                                    <div class="form-group">
                                       <label for=""><b>Ledger</b></label>
                                        <select id="ledger_auto_select" name="ledger" class="form-select" style="border: 1px solid #bebebe; color: black;">
                                       <option>Select</option>
                                       <?php 
                                          if ($ledgr = $con-> query("SELECT * FROM ledger")) {
                                          
                                          
                                              while($rows= $ledgr->fetch_array()){
                                                $id=$rows["id"];
                                                 
                                                  $name = $rows["ledger_name"];
                                                  
                                                  echo '<option value='.$id.'>'.$name.'</option>';
                                              }
                                          }
                                          
                                          ?> 
                                    </select>
                                    </div>
                                </div> 
                                <div class="col-sm">
                                    <div class="form-group">
                                       <label for=""><b>Item:</b></label>
                                        <select id="item_name" class="form-select" name="item" style="border: 1px solid #bebebe; color: black;">
                                       <option value="">Select</option>
                                    </select>
                                    </div>
                                </div> 
                                <div class="col-sm text-center">
                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-top:20px; width:68px;font-size: 18px;">+</button>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for=""><b>Quantity</b></label>
                                         <input type="number" id="qty" class="form-control" name="qty">
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for=""><b>Value</b></label>
                                        <input type="text" name="value" class="form-control" id="value">
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for=""><b>Total</b></label>
                                        <input name="total" id="total" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <button id="submitButton" class="btn btn-primary customBtn" style="margin-top: 22px;">Submit</button>
                                    </div>
                                </div>
                                <div class=" mt-4" >
                                    <div class="col-md-12 col-sm-12">
                           <table id="sub_ledgr_table datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                              <thead>
                                 <tr>
                                    <th>No:</th>
                                    <th>Ledger</th>
                                    <th>Quantity</th>
                                    <th>Value</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody id="transaction-list">
                                 <?php 
                                    if ($details=$con->query("SELECT *FROM transaction_details")) {
                                        while($rows=$details->fetch_array()){
                                           $id= $rows["id"];
                                            $ledger=$rows["ledger"];
                                            $qty=$rows["qty"];
                                            $value=$rows["value"];
                                            $total=$rows["total"];
                                            echo '<tr>
                                            <td>'.$id.'</td>
                                            <td>'.$ledger.'</td>
                                            <td>'.$qty.'</td>
                                            <td>'.$value.'</td>
                                            <td>'.$total.'</td>
                                            <td>
                                            <a class="btn btn-info" href="transaction_view.php?id='.$id.'">View</a>
                                            </td>
                                            </tr>';
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
               <!-- container-fluid -->
               <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                  aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Add Something</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="card">
                           <div class="card-body">
                              <form id="ledgr_form">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group ">
                                          <input class="d-none" type="text" name="ledgr_id" value="<?php echo $ledgr_id; ?>">
                                          <input id="details" type="text" class="form-control"
                                             name="details" placeholder="Details"><br>
                                       </div>
                                       <div class="form-group ">
                                          <input id="form" type="text" class="form-control"
                                             name="description" placeholder="description">
                                       </div>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary"
                              data-bs-dismiss="modal">Close</button>
                           <button id="save" type="submit" class="btn btn-primary">Save</button>
                        </div>
                     </div>
                  </div>
               </div>
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

        <script src="assets/js/app.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
     <script type="text/javascript">
         $(document).ready(function(){
         $('#qty').keyup(calculate);
         $('#value').keyup(calculate);
         });
         function calculate(e)
         {
         $('#total').val($('#qty').val() * $('#value').val());
         }
      </script>
      <script type="text/javascript">
         $(document).ready(function(){
             $("#ledger_auto_select").change(function(){
                var cid=$(this).val();
                 $.post("include/auto_select.php",{id:cid},function(data){
                     $("#item_name").html(data);
                 });
             });
         });
      </script>
      <script type="text/javascript">
         $(document).ready(function(){
             $('#sub_ledgr_table').DataTable();
             $("#save").click(function(e){
                 e.preventDefault();
                var formData=$("#ledgr_form").serialize();
                alert(formData);
                $.ajax({
                     type: "GET",
                     url: "include/sbldgr_details.php?add",
                     data: formData,
                     cache: false,
                     success: function() {
                        Swal.fire(
                      'Success!',
                      'Data Insert Success!',
                      'success'
                        )
                     }
                 });
             });
         });
      </script>
      <script type="text/javascript">
         $(document).ready(function(){
             $("#submitButton").click(function(){
                 var data=$("#transaction_form").serialize();
                 alert(data);
                 $.ajax({
                     type:"GET",
                     data:data,
                     url:"include/transactions.php?add",
                     cache:false,
                     success:function(){
                         Swal.fire(
                      'Success!',
                      'Data Insert Success!',
                      'success'
                        )
                     }
                 });
             });
         });
      </script>


   </body>
</html>