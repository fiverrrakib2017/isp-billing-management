<?php
date_default_timezone_set("Asia/Dhaka");
// if(!file_exists("include/db_connect.php")){
     include 'include/db_connect.php';
// }
if (isset($_GET['clid'])) {

    $clid = $_GET['clid'];
    if ($cstmr = $con->query("SELECT * FROM customers WHERE id='$clid'")) {
        while ($rows = $cstmr->fetch_array()) {
            $lstid = $rows["id"];
            $fullname = $rows["fullname"];
            $package = $rows["package"];
            $packagename = $rows["package_name"];
            $username = $rows["username"];
            $password = $rows["password"];
            $mobile = $rows["mobile"];
            $pop = $rows["pop"];
            $area = $rows["area"];
            $address = $rows["address"];
            $expiredDate = $rows["expiredate"];
            $createdate = $rows["createdate"];
            $profile_pic = $rows["profile_pic"];
            $nid = $rows["nid"];
            $price = $rows["price"];
            $remarks = $rows["remarks"];
            $liablities = $rows["liablities"];
        }      
    }
}
?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>FAST-ISP-BILLING-SYSTEM</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <?php include 'style.php';?>
      
   </head>
   <body data-sidebar="dark">
      <!-- Begin page -->
      <div id="layout-wrapper">
        
         <!-- ============================================================== -->
         <!-- Start right Content here -->
         <!-- ============================================================== -->
         <div class="main-content">
            <div class="page-content">
               <div class="container-fluid">
               <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="text-center mt-2">
                                                    <h5>Payment With Baksh?</h5>
                                                    <p class="text-muted">বাটন এ ক্লিক করে আপনার পেমেন্ট সম্পূর্ণ করেন।</p>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end col -->

                                        <div class="row mt-5">
                                            <div class="col-md-4">
                                                <div>
                                                    <h6 class="font-size-14">Email Address</h6>
                                                    <p class="text-muted">support@sr-communication.com</p>
                                                </div>
                                                <div class="pt-3">
                                                    <h6 class="font-size-14">Mobile Number</h6>
                                                    <p class="text-muted">01821600600</p>
                                                </div>
                                                <div class="pt-3">
                                                    <h6 class="font-size-14">Address</h6>
                                                    <p class="text-muted">Sarkar super market,1st floor,gouripur,Daudkandi,cumilla</p>
                                                </div>
                                            </div> <!-- end col -->
                                            <div class="col-md-8">
                                                <form class="form-custom">
                                                    <div class="row">
                                                        <div class="d-none">
                                                            <input  type="text" name="customer_id" value="<?php echo $lstid ?? 0; ?>">
                                                            <input  type="text" name="pop_id" value="<?php echo $pop ?? 0; ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class=" form-label" for="fullname">Fullname</label>
                                                                <input readonly type="text" class="form-control" name="fullname" placeholder="Your Fullname" value="<?php echo $fullname ?? ''; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                            <label class=" form-label" for="username">Username</label>
                                                            <input readonly type="text" class="form-control" name="username" placeholder="Your Username" value="<?php echo $username ?? ''; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                            <label class=" form-label" for="mobile">Mobile</label>
                                                            <input readonly type="text" class="form-control" name="mobile" placeholder="Your Mobile" value="<?php echo $mobile ?? ''; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                            <label class=" form-label" for="amount">Amount</label>
                                                            <input readonly type="text" class="form-control" name="amount" placeholder="Your Amount" value="<?php echo $price ?? 0; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                            <label class=" form-label" for="area">Area</label>
                                                            <?php 
                                                                $get_area = $con->query("SELECT * FROM area_list WHERE id='$area' ");
                                                                while ($row = $get_area->fetch_array()) {
                                                                    $area_name= $row['name'] ?? '';
                                                                }

                                                                ?>
                                                            <input readonly type="text" class="form-control" name="area" placeholder="Your Area" value="<?php echo $area_name ?? ''; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                            <label class=" form-label" for="nid_no">NID No.</label>
                                                            <input readonly type="text" class="form-control" name="nid_no" placeholder="Your Nid" value="<?php echo $nid ?? ''; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 text-center">
                                                            <button type="button" class="btn btn-success"> <img src="images/Bkash-Logo.jpg" alt="Bkash" style="width: 20px; margin-right: 8px;">Pay With Bkash</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
               </div>
               <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
           
            <!-- <?php include 'Footer.php';?> -->
         </div>
         <!-- end main content-->
      </div>
      <!-- END layout-wrapper -->
      <!-- Right bar overlay-->
      <div class="rightbar-overlay"></div>
      <?php include 'script.php';?>
   </body>
</html>