<?php
   include("include/security_token.php");
   include("include/users_right.php");
   include "include/db_connect.php";
   ini_set('display_errors', '1');
   ini_set('display_startup_errors', '1');
   error_reporting(E_ALL);
   
   
   if (isset($_GET['clid'])) {
   
       $clid = $_GET['clid'];
       if ($cstmr = $con->query("SELECT * FROM clients WHERE id='$clid'")) {
   
           while ($rows = $cstmr->fetch_array()) {
               $lstid = $rows["id"];
               $fullname = $rows["fullname"];
               $company = $rows["company"];
               $mobile = $rows["mobile"];
               $email = $rows["email"];
               $address = $rows["address"];
               $createdate = $rows["createdate"];
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
      <?php include 'style.php';?>
   </head>
   <body data-sidebar="dark">
      <!-- Begin page -->
      <div id="layout-wrapper">
         <?php $page_title="Client Profile"; include 'Header.php';?>
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
                                 <a href="client_edit.php?clid=<?php echo $clid; ?>">
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
                                                         if ($totalPurchase = $con->query("SELECT SUM(grand_total) AS Amount FROM invoice WHERE client_id='$clid' ")) {
                                                             while ($r_purchase_rows = $totalPurchase->fetch_array()) {
                                                                 $totalPurAmt = $r_purchase_rows["Amount"];
                                                             }
                                                             echo $totalPurAmt;
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
                                                         if(isset($clid) && !empty($clid)) {
                                                            /* Prepare the SQL statement*/
                                                            $stmt = $con->prepare("SELECT SUM(total_paid) AS total_paid_amount FROM sales WHERE client_id = ?");
                                                            $stmt->bind_param("i", $clid);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();
                                                            
                                                            if($result && $row = $result->fetch_assoc()) {
                                                                $total_paid = $row['total_paid_amount'] ?? 0;
                                                                echo round($total_paid); 
                                                            } else {
                                                                echo "0.00";
                                                            }
                                                            
                                                            $stmt->close();
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
                                                         if(isset($clid) && !empty($clid)) {
                                                            /* Prepare the SQL statement*/
                                                            $stmt = $con->prepare("SELECT SUM(total_due) AS total_due_amount FROM sales WHERE client_id = ?");
                                                            $stmt->bind_param("i", $clid);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();
                                                            
                                                            if($result && $row = $result->fetch_assoc()) {
                                                                $total_due = $row['total_due_amount'] ?? 0;
                                                                echo round($total_due); 
                                                            } else {
                                                                echo "0.00";
                                                            }
                                                            
                                                            $stmt->close();
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
                                    $sql = "SELECT * FROM sales_dues WHERE client_id=$lstid";
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
                                                $sql = "SELECT * FROM sales Where client_id=$lstid";
                                                $result = mysqli_query($con, $sql);

                                                while ($rows = mysqli_fetch_assoc($result)) {

                                                ?>

                                                    <tr>
                                                        <td><?php echo $rows['id']; ?></td>
                                                        <td>
                                                            <?php
                                                            $client_id = $rows['client_id'];
                                                            $allCsutoemrData = $con->query("SELECT * FROM clients WHERE id=$client_id ");
                                                            while ($client_loop = $allCsutoemrData->fetch_array()) {
                                                                echo '<a href="client_profile.php?clid='.$client_id.'" >'.$client_loop['fullname'].'</a>';
                                                            }

                                                            ?>
                                                        </td>
                                                        <td><?php echo $rows['sub_total']; ?></td>
                                                        <td><?php echo $rows['total_paid']; ?></td>
                                                        <td><?php echo $rows['total_due']; ?></td>   
                                                        <td><?php echo $rows['grand_total']; ?></td>
                                                        <td>
                                                            <?php

                                                            $date = $rows['date'];
                                                            $formatted_date = date("d F Y", strtotime($date));
                                                            echo $formatted_date;

                                                            ?>
                                                        </td>
                                                        <td>

                                                            <a class="btn-sm btn btn-primary" href="sales_inv_edit.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-edit"></i></a>

                                                            <a class="btn-sm btn btn-success" href="invoice/sales_inv_view.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-eye"></i></a>

                                                            <a class="btn-sm btn btn-danger" onclick=" return confirm('Are You Sure');" href="sales_inv_delete.php?clid=<?php echo $rows['id']; ?>"><i class="fas fa-trash"></i></a>

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
                                    if ($allSales=$con->query("SELECT * FROM `sales` WHERE client_id=$lstid AND total_due IS NOT NULL")) {
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
      <?php include 'script.php';?>
      <script type="text/javascript">
        
         $(document).ready(function() {
            $("#transaction_datatable").DataTable();
            $("#invoice_datatable").DataTable();
             $('select[name="invoice_id"]').on('change', function() {
                 var invoiceId = $(this).val();
         
                 if (invoiceId) {
                     $.ajax({
                         url: 'include/sale_server.php',
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
                     url: 'include/sale_server.php?process_payment=true', 
                     method: 'POST',
                     data: formData,
                     dataType: 'json',
                     success: function(response) {
                         if (response.success) {
                             toastr.success(response.message); 
                             $('#paymentForm')[0].reset();
                             $("#paymentModal").modal('hide'); 
                             setTimeout(() => {
                              location.reload();
                             }, 500);
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