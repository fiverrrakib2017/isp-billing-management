<?php
   include("include/security_token.php");
   include("include/users_right.php");
   include "include/db_connect.php";
   ini_set('display_errors', '1');
   ini_set('display_startup_errors', '1');
   error_reporting(E_ALL);
   
   
   if (isset($_GET['clid'])) {
        $clid = $_GET['clid'];
       if ($cstmr = $con->query("SELECT * FROM suppliers WHERE id=$clid")) {
   
           while ($rows = $cstmr->fetch_array()) {
               $lstid = $rows["id"];
               $fullname = $rows["fullname"];
               $company = $rows["company"];
               $mobile = $rows["mobile"];
               $email = $rows["email"];
               $address = $rows["address"];
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
                     <h4 class="page-title">Supplier Profile</h4>
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
                     <img class="rounded-circle header-profile-user" src="profileImages/avatar.png" alt="Header Avatar">
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
                     <div class="">
                        <div class="row">
                           <div class="col-md-6"></div>
                           <div class="col-md-6">
                              <div class="d-flex py-2" style="float:right;">
                                 <abbr title="Complain">
                                 <button type="button" data-bs-target="#ComplainModalCenter" data-bs-toggle="modal" class="btn-sm btn btn-warning ">
                                 <i class="mdi mdi-alert-outline"></i>
                                 </button></abbr>
                                 &nbsp;
                                 <abbr title="Payment received">
                                 <button type="button" data-bs-target="#paymentModal" data-bs-toggle="modal" class="btn-sm btn btn-info ">
                                 <i class="mdi mdi mdi-cash-multiple"></i>
                                 </button></abbr>
                                 &nbsp;
                                 <abbr title="Disable"><button type="button" class="btn-sm btn btn-danger">
                                 <i class="mdi mdi mdi-wifi-off "></i>
                                 </button></abbr>
                                 &nbsp;
                                 <abbr title="Reconnect">
                                 <button type="button" class="btn-sm btn btn-success">
                                 <i class="mdi mdi-sync"></i>
                                 </button>
                                 </abbr>
                                 &nbsp;
                                 <abbr title="Edit Customer">
                                 <a href="supplier_edit.php?clid=<?php echo $clid; ?>">
                                 <button type="button" class="btn-sm btn btn-info">
                                 <i class="mdi mdi-account-edit"></i>
                                 </button></a>
                                 </abbr>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="container">
                        <div class="main-body">
                           <div class="row gutters-sm">
                              <div class="col-md-4 mb-3">
                                 <div class="card">
                                    <div class="card-body">
                                       <div class="d-flex flex-column align-items-center text-center profile">
                                          <img src="profileImages/avatar.png" alt='Profile Picture' class="rounded-circle" width="150" />
                                          <div class="imgUpIcon">
                                             <button id="uploadBtn" type="button">
                                             <i class="mdi mdi-camera"></i>
                                             </button>
                                          </div>
                                          <div class="mt-3">
                                             <h5>
                                                <?php echo $fullname; ?>
                                             </h5>
                                             <p class="text-secondary mb-1"># <?php echo $clid; ?>
                                                <br>
                                                <?php echo $mobile; ?>
                                             </p>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="card">
                                    <div class="card-body">
                                       <div class="col-12 bg-white p-0 px-2 pb-3 mb-3">
                                          <div class="d-flex justify-content-between border-bottom py-2 px-3">
                                             <p><i class="mdi mdi-marker-check"></i> Fullname:</p>
                                             <a href="#"><?php echo $fullname; ?></a>
                                          </div>
                                          <div class="d-flex justify-content-between border-bottom py-2 px-3">
                                             <p><i class="mdi mdi-phone"></i> Mobile:</p>
                                             <a href="#"><?php echo $mobile; ?></a>
                                          </div>
                                          <div class="d-flex justify-content-between border-bottom py-2 px-3">
                                             <p><i class="fas fa-id-card"> </i> Address: </p>
                                             <a href="#"><?php echo $address; ?></a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-8">
                                 <div class="row">
                                    <!-- Earnings (Monthly) Card Example -->
                                    <div class="col-xl-4 col-md-6 mb-4">
                                       <div class="card shadow py-2" style="border-left:3px solid #2A0FF1;">
                                          <div class="card-body">
                                             <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                   <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Sale's</div>
                                                   <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                                $result = $con->query("SELECT SUM(grand_total) AS amount FROM purchase WHERE client_id='$clid'");

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $totalAmount = $row["amount"] ?? 0; 
                                    echo $totalAmount;
                                }
                                ?>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <!-- Earnings (Monthly) Card Example -->
                                    <div class="col-xl-4 col-md-6 mb-4">
                                       <div class="card shadow  py-2" style="border-left:3px solid #27F10F;">
                                          <div class="card-body">
                                             <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                   <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Paid</div>
                                                   <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                   <?php
                                $result = $con->query("SELECT SUM(total_paid) AS amount FROM purchase WHERE client_id='$clid'");

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $totalAmount = $row["amount"] ?? 0; 
                                    echo $totalAmount;
                                }
                                ?>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <!-- Pending Requests Card Example -->
                                    <div class="col-xl-4 col-md-6 mb-4">
                                       <div class="card shadow  py-2" style="border-left:3px solid red;">
                                          <div class="card-body">
                                             <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                   <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Due</div>
                                                   <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                   <?php
                                $result = $con->query("SELECT SUM(total_due) AS amount FROM purchase WHERE client_id='$clid'");

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $totalAmount = $row["amount"] ?? 0; 
                                    echo $totalAmount;
                                }
                                ?>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
<div class="container">
<div class="row">
    <div class="card">
        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#transaction" role="tab">
                <span class="d-none d-md-block">Transaction
                </span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#invoice" role="tab">
                <span class="d-none d-md-block">Invoice</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                </a>
            </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
            <div class="tab-pane active p-3" id="transaction" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                        <div class="table-responsive">
                            <table id="transaction_datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>Invoice Id</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <?php
                                    $totalCount=1;
                                    $sql = "SELECT * FROM purchase_dues WHERE supplier_id=$lstid";
                                    $result = mysqli_query($con, $sql);
                                    
                                    while ($rows = mysqli_fetch_assoc($result)) {
                                    
                                    ?>
                                    <tr>
                                    <td>
                                        <?php 
                                            echo $totalCount++; 
                                            ?>
                                    </td>
                                    <td><?php echo $rows['invoice_id']; ?></td>
                                    <td><?php echo $rows['due_amount']; ?></td>
                                    <td>
                                        <?php
                                            $date = $rows['date'];
                                            $formatted_date = date("d F Y", strtotime($date));
                                            echo $formatted_date;
                                            
                                            ?>
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
            <div class="tab-pane  p-3" id="invoice" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                        <div class="table-responsive">
                            <table id="invoice_datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                                <tr>
                                                    <th>Invoice id</th>
                                                    <th>Customer Name</th>
                                                    <th>Sub Total</th>
                                                    <th>Paid Amount</th>
                                                    <th>Due Balance</th>
                                                    <th>Grand Total</th>
                                                    <th>Create Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody >
                                            <?php
$sql = "SELECT * FROM purchase WHERE client_id=?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $lstid);  
$stmt->execute();
$result = $stmt->get_result();

while ($rows = $result->fetch_assoc()) {
?>
    <tr>
        <td><?php echo htmlspecialchars($rows['id']); ?></td>
        <td>
            <?php
            $supplier_id = $rows['client_id'];
            $allCustomerData = $con->prepare("SELECT fullname FROM suppliers WHERE id=?");
            $allCustomerData->bind_param("i", $supplier_id);
            $allCustomerData->execute();
            $client_result = $allCustomerData->get_result();

            if ($client_row = $client_result->fetch_assoc()) {
                echo '<a href="supplier_profile.php?clid=' . htmlspecialchars($supplier_id) . '">' . htmlspecialchars($client_row['fullname']) . '</a>';
            }
            ?>
        </td>
        <td><?php echo htmlspecialchars($rows['sub_total']); ?></td>
        <td><?php echo htmlspecialchars($rows['total_paid']); ?></td>
        <td><?php echo htmlspecialchars($rows['total_due']); ?></td>
        <td><?php echo htmlspecialchars($rows['grand_total']); ?></td>
        <td>
            <?php
            $date = $rows['date'];
            $formatted_date = date("d F Y", strtotime($date));
            echo htmlspecialchars($formatted_date);
            ?>
        </td>
        <td>
            <a class="btn-sm btn btn-primary" href="purchase_invoice_edit.php?clid=<?php echo htmlspecialchars($rows['id']); ?>"><i class="fas fa-edit"></i></a>
            <a class="btn-sm btn btn-success" href="invoice/purchase_inv_view.php?clid=<?php echo htmlspecialchars($rows['id']); ?>"><i class="fas fa-eye"></i></a>
            <a class="btn-sm btn btn-danger" onclick="return confirm('Are You Sure');" href="purchase_inv_delete.php?clid=<?php echo htmlspecialchars($rows['id']); ?>"><i class="fas fa-trash"></i></a>
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
    </div>
</div>
</div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <!-- Modal for addPayment -->
            <div class="modal fade bs-example-modal-lg" id="paymentModal" tabindex="-1" role="dialog"
               aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog " role="document">
                  <div class="modal-content col-md-12">
                     <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><span
                           class="mdi mdi-account-check mdi-18px"></span> &nbsp;Add Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                        <form id="paymentForm"  method="POST">
                           <div class="form-group mb-2 d-none">
                              <label>Client Id</label>
                              <input readonly name="client_id" type="text" value="<?php echo $lstid ?? 0;  ?>">
                           </div>
                           <div class="form-group mb-2">
                              <label>Invoice Id</label>
                              <select class="form-control" type="text" name="invoice_id">
                                 <option value="">---Select---</option>
                                <?php 
                                    if ($allSales = $con->query("SELECT * FROM `purchase` WHERE client_id = $lstid AND total_due IS NOT NULL")) {
                                        while ($rows = $allSales->fetch_array()) {
                                            echo '<option value="' . $rows['id'] . '">' . $rows['id'] . '</option>';
                                        }
                                    }
                                ?>

                              </select>
                           </div>
                           <div class="form-group mb-2">
                              <label>Total Due</label>
                              <input readonly name="total_due" placeholder="Total Due" class="form-control" type="text">
                           </div>
                           <div class="form-group mb-2">
                              <label>Payment Now</label>
                              <input  name="amount" placeholder="Enter Amount" class="form-control" type="text">
                           </div>
                           <div class="form-group mb-2">
                              <label>Type</label>
                              <select class="form-control" type="text" name="type">
                                 <option value="">---Select---</option>
                                 <option value="1">Cash</option>
                                 <option value="2">Bkash</option>
                                 <option value="3">Nagad</option>
                                 <option value="4">Bank</option>
                              </select>
                           </div>
                           <div class="modal-footer ">
                              <button data-bs-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                              <button type="submit" class="btn btn-success">Save Changes</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <footer class="footer">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-sm-6">
                        <script>
                           document.write(new Date().getFullYear())
                        </script> © IT-FAST.
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
      <!-- Datatable init js -->
      <script src="assets/js/pages/datatables.init.js"></script>
      <script src="js/toastr/toastr.min.js"></script>
      <script src="js/toastr/toastr.init.js"></script>
      <script src="assets/js/app.js"></script>
      <script type="text/javascript">
        
         $(document).ready(function() {
            $("#transaction_datatable").DataTable();
            $("#invoice_datatable").DataTable();
             $('select[name="invoice_id"]').on('change', function() {
                 var invoiceId = $(this).val();
         
                 if (invoiceId) {
                     $.ajax({
                         url: 'include/purchase_server.php',
                         type: 'GET',
                         data: {
                             get_invoice_data: true,
                             invoice_id: invoiceId
                         },
                         dataType: 'json',
                         success: function(response) {
                             if (response.status === 'success') {
                                 $('input[name="total_due"]').val(response.total_due);
                             } else {
                                 toastr.error(response.message);
                                 $('input[name="total_due"]').val('');
                             }
                         }
                     });
                 } else {
                     $('input[name="total_due"]').val('');
                 }
             });
             $('#paymentForm').submit(function(e) {
                 e.preventDefault(); 
                 
                 var formData = $(this).serialize();
                 
                 $.ajax({
                     url: 'include/purchase_server.php?process_payment', 
                     method: 'POST',
                     data: formData,
                     dataType: 'json',
                     success: function(response) {
                         if (response.status === 'success') {
                             toastr.success(response.message); 
                             $('#paymentForm')[0].reset();
                             $("#paymentModal").modal('hide'); 
                         } else {
                             toastr.error(response.message);
                         }
                     },
                     error: function(xhr, status, error) {
                         console.log(error);
                     }
                 });
             });
         
         });
      </script>
   </body>
</html>