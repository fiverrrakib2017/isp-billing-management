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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Payment Process</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css?v=3.2.0">
  <style> 
    .login-box .card, .register-box .card {
    
    border: 2px #bfbfbf dotted !important;
}
  </style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <!-- <div class="register-logo">
   <img  width="90px" src="http://103.146.16.154/profileImages/avatar.png">
  </div> -->

  <div class="card">
    <div class="card-body register-card-body">
    <div class="register-logo">
   <img  width="90px" src="http://103.146.16.154/profileImages/avatar.png">
  </div>
      <p class="login-box-msg">Welcome To SR Communication</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input readonly type="text" class="form-control" placeholder="Full name" value="<?php echo $fullname ?? ''; ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input readonly type="text" class="form-control" placeholder="Package" value="<?php echo $packagename ?? ''; ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
        <?php 
            $todayDate = date("Y-m-d");
            if ($expiredDate <= $todayDate) {
                echo '<br>';
                echo ' <input readonly type="text" class="form-control" value="Expired" style="color:red">';
            } else {
                $expiredDate = new DateTime($expiredDate);
                $formattedDate = $expiredDate->format('d-M-Y');
                echo ' <input readonly type="text" class="form-control" value="Expire Will be '.$formattedDate.'">';
            }
        ?>
         
          <div class="input-group-append">
            <div class="input-group-text">
                <i class="fas fa-clock"></i>
            </div>
          </div>
        </div>
      </form>

      <div class="social-auth-links text-center">
      
        
        <a type="button" id="bkash_payment_btn" class="btn btn-block btn-danger">
        <img src="images/Bkash-Logo.jpg" alt="Bkash" style="width: 20px; margin-right: 8px;">
          Pay With Bkash
        </a>
      </div>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://adminlte.io/themes/v3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js?v=3.2.0"></script>
<script type="text/javascript">

  $("#bkash_payment_btn").on('click',function(){
    console.log(window.location.href);
     window.location.href = `http://<?php echo $_SERVER['HTTP_HOST']; ?>/include/Bkash_payment.php?customer_recharge=true&pop_id=${pop_id}&landing_page=1&customer_id=${customer_id}`;
  });
</script>
</body>
</html>
