<?php
date_default_timezone_set("Asia/Dhaka");
include 'include/db_connect.php';
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
                        <div class="col-md-6 m-auto">
                            <div class="card">
                                
                                <div class="card-body">
                                <form class="form-custom">
                                    <div class="row">
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
                                            <label class=" form-label" for="nid_no">Package.</label>
                                            <input readonly type="text" class="form-control" name="nid_no" placeholder="Your Nid" value="<?php echo $packagename ?? ''; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="nid_no">Status</label>
                                                <?php 
                                                $todayDate = date("Y-m-d");
                                                if ($expiredDate <= $todayDate) {
                                                    echo '<br>';
                                                    echo '
                                                        <span class="badge bg-danger ms-2">Expired</span>';
                                                } else {
                                                    $expiredDate = new DateTime($expiredDate);
                                                    $formattedDate = $expiredDate->format('d-M-Y');
                                                    echo '<input readonly type="text" class="form-control" value="Expire Will be '.$formattedDate.'">';
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-12 text-center">
                                            <button type="button" id="bkash_payment_btn" class="btn btn-success"> <img src="images/Bkash-Logo.jpg" alt="Bkash" style="width: 20px; margin-right: 8px;">Pay With Bkash</button>
                                        </div>
                                    </div>
                                </form>
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
      <script type="text/javascript">
        $("#bkash_payment_btn").on('click',function(e){
                e.preventDefault();
            var amount=<?php echo $price; ?>;
            var pop_id=<?php echo $pop; ?>;
            var customer_id=<?php echo $lstid; ?>;
            
            if (!amount || amount <= 0) {
                toastr.error("Invalid payment amount!");
                return;
            }
            window.location.href = `http://<?php echo $_SERVER['HTTP_HOST']; ?>/branch/bkash.php?amount=${amount}&pop_id=${pop_id}&submit_payment=1&landing_page=1&customer_id=${customer_id}`;
        });
      </script>
   </body>
</html>