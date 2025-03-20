<?php
date_default_timezone_set('Asia/Dhaka');
include 'include/db_connect.php';




if (isset($_GET['clid'])) {
    $clid = $_GET['clid'];
    if ($cstmr = $con->query("SELECT * FROM customers WHERE id='$clid'")) {
        while ($rows = $cstmr->fetch_array()) {
            $lstid = $rows['id'];
            $fullname = $rows['fullname'];
            $package = $rows['package'];
            $packagename = $rows['package_name'];
            $username = $rows['username'];
            $password = $rows['password'];
            $mobile = $rows['mobile'];
            $pop = $rows['pop'];
            $area = $rows['area'];
            $address = $rows['address'];
            $expiredDate = $rows['expiredate'];
            $createdate = $rows['createdate'];
            $profile_pic = $rows['profile_pic'];
            $nid = $rows['nid'];
            $price = $rows['price'];
            $remarks = $rows['remarks'];
            $liablities = $rows['liablities'];
        }
    }
}


$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";  
$CurPageURL = $protocol . $_SERVER['HTTP_HOST'].'/self.php?clid='.$_GET['clid'].''; 

if (isset($_GET['clid']) && isset($_GET['paymentID']) && $_GET['status'] == 'success') {
    $customer_id = $_GET['clid'];
    include 'include/Service/Bkash_payment_service.php';
    include 'include/Config.php';
    $bk = new BkashPaymentService($config);
    $idToken = $bk->getGrantToken();

    if (!empty($idToken)) {
        $paymentID = $_GET['paymentID'];

        /* Execute the payment*/
        $response = $bk->executePayment($idToken, $paymentID);

        /* Check response*/
        if (!empty($response['transactionStatus']) && $response['transactionStatus'] === 'Completed') {
            $pop_id = $con->query("SELECT `pop` FROM customers WHERE id=$customer_id")->fetch_assoc()['pop'];
            $get_customer_package = $con->query("SELECT `package` FROM customers WHERE id=$customer_id")->fetch_assoc()['package'];
            $package = $con->query("SELECT `package_name` FROM customers WHERE id=$customer_id")->fetch_assoc()['package_name'];
            $username = $con->query("SELECT `username` FROM customers WHERE id=$customer_id")->fetch_assoc()['username'];
            $password = $con->query("SELECT `password` FROM customers WHERE id=$customer_id")->fetch_assoc()['password'];
            $customer_amount = $con->query("SELECT `price` FROM customers WHERE id=$customer_id")->fetch_assoc()['price'];
            $sale_price = $con->query("SELECT s_price FROM branch_package WHERE pkg_id=$get_customer_package AND pop_id=$pop_id")->fetch_assoc()['s_price'];
            $expiredDate = $con->query("SELECT `expiredate` FROM customers WHERE id=$customer_id")->fetch_assoc()['expiredate'];
            $chrg_mnths = 1;
            $recharge_by = $_SESSION['uid'] ?? 0;
            /*Calculate new expiry date*/
            if (!empty($expiredDate) && isset($expiredDate) && !empty($chrg_mnths) && isset($chrg_mnths)) {
                $today = date('Y-m-d');
                if ($expiredDate > $today) {
                    $exp_date = date('Y-m-d', strtotime("+$chrg_mnths month", strtotime($expiredDate)));
                } else {
                    $exp_date = date('Y-m-d', strtotime("+$chrg_mnths month", strtotime($today)));
                }

                /*Insert Recharge Data*/
                $con->query("INSERT INTO customer_rechrg(customer_id, pop_id, months, sales_price, purchase_price,discount, ref, rchrg_until, type, rchg_by, datetm) VALUES('$customer_id', '$pop_id', '$chrg_mnths', '$sale_price', '$customer_amount','0.00', 'Bkash Payment', '$exp_date', '2', '$recharge_by', NOW())");
                $con->query("INSERT INTO radcheck(username,attribute,op,value) VALUES('$username','Cleartext-Password',':=','$password')");
                $con->query("INSERT INTO radreply(username,attribute,op,value) VALUES('$username','MikroTik-Group',':=','$package')");

                /*Update Customer New Balance AND Expire Date */
                $_customer_total_paid_amount = 0;
                $_customer_total_due_amount = 0;
                $_customer_total_recharge_amount = 0;
                /**** Get Customer total paid amount *************/
                if ($customer_total_paid_amount = $con->query("SELECT SUM(`purchase_price`) as customer_total_paid_amount FROM customer_rechrg WHERE customer_id='$customer_id' AND type!='0'")) {
                    while ($rows = $customer_total_paid_amount->fetch_assoc()) {
                        $_customer_total_paid_amount = $rows['customer_total_paid_amount'];
                    }
                }

                /**** Get Customer total Due amount *************/
                if ($customer_total_due_amount = $con->query("SELECT SUM(`purchase_price`) as customer_total_due_amount FROM customer_rechrg WHERE customer_id='$customer_id' AND type='0'")) {
                    while ($rows = $customer_total_due_amount->fetch_assoc()) {
                        $_customer_total_due_amount = $rows['customer_total_due_amount'];
                    }
                }

                /**** Get Customer total Recharge amount *************/
                if ($customer_total_recharge_amount = $con->query("SELECT SUM(`purchase_price`) as customer_total_recharge_amount FROM customer_rechrg WHERE customer_id='$customer_id' AND type !='4'")) {
                    while ($rows = $customer_total_recharge_amount->fetch_assoc()) {
                        $_customer_total_recharge_amount = $rows['customer_total_recharge_amount'];
                    }
                }

                /**** Get Customer Defference Balance *************/
                if (!empty($_customer_total_paid_amount) && isset($_customer_total_paid_amount) && !empty($_customer_total_recharge_amount) && isset($_customer_total_recharge_amount)) {
                    $_balance_amount = $_customer_total_recharge_amount - $_customer_total_paid_amount;

                    $con->query("UPDATE customers SET expiredate='$exp_date', status='1', rchg_amount='$_customer_total_recharge_amount', paid_amount='$_customer_total_paid_amount', balance_amount='$_balance_amount' WHERE id='$customer_id'");
                }
            }
            header("Location: $CurPageURL");
            exit; 
        }
    }
}


if (isset($_GET['status']) && isset($_GET['tran_id'])) {
    $status = $_GET['status']; 
    $tran_id = $_GET['tran_id']; 
    $customer_id = $_GET['clid'];
    if ($status == 'VALID') {
        include 'Service/ssl_payment_service.php';
        include 'Config.php';

        $object = new SSLCommercePaymentService($ssl_commerce_config);

        $result = $object->verifyPayment($tran_id);
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
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css?v=3.2.0">
    <style>
        .login-box .card,
        .register-box .card {

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
                    <img width="90px" src="http://103.146.16.154/profileImages/avatar.png">
                </div>
                <p class="login-box-msg">Welcome To SR Communication</p>

                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input readonly type="text" class="form-control" placeholder="Full name"
                            value="<?php echo $fullname ?? ''; ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input readonly type="text" class="form-control" placeholder="Package"
                            value="<?php echo $packagename ?? ''; ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <?php
                        $todayDate = date('Y-m-d');
                        if ($expiredDate <= $todayDate) {
                            echo '<br>';
                            echo ' <input readonly type="text" class="form-control" value="Expired" style="color:red">';
                        } else {
                            $expiredDate = new DateTime($expiredDate);
                            $formattedDate = $expiredDate->format('d-M-Y');
                            echo ' <input readonly type="text" class="form-control" value="Expire Will be ' . $formattedDate . '">';
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


                    <button type="button" id="_payment_btn" class="btn btn-block btn-success">
                        SSL Commerce
                    </button>
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
        $("#_payment_btn").on('click', function() {
            console.log(window.location.href);
            var pop_id = <?php echo $pop; ?>;
            var customer_id = <?php echo $clid; ?>;
            window.location.href =
                `http://<?php echo $_SERVER['HTTP_HOST']; ?>/include/customer_recharge_server.php?customer_recharge_with_ssl_payment_getway=true&customer_id=${customer_id}`;
        });
    </script>
</body>

</html>
