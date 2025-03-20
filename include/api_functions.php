<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'db_connect.php';


if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'all_customer':
            all_customer($con);
            break;

        case 'get_customer':
            $id = $_GET['clid'] ?? null;
            get_customer($con, $id);
            break;
        case 'check_customer_status':
            $id = $_GET['clid'] ?? null;
            check_customer_status($con, $id);
            break;

        case 'execute_customer_bkash_payment':
            $id = $_GET['clid'] ?? null;
            execute_customer_bkash_payment($con, $id);
            break;

        case 'customer_monthly_uses':
            $id = $_GET['clid'] ?? null;
            customer_monthly_uses($con, $id);
            break;

       

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No action specified']);
}

function all_customer($con){
    $result =$con->query("SELECT * FROM customers");
    $customers = [];
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $customers]);
}
 function get_customer($con,$id){
    if(isset($id) && !empty($id)){
     $customer=$con->query("SELECT * FROM `customers` WHERE id=$id");
     if($customer->num_rows>0){
         $row=$customer->fetch_array();
         echo json_encode(['success'=>true,'data'=>$row]);
     }
    }else{
         echo json_encode(['success'=>false,'message'=>'Customer not found']);
    }
 }
 function check_customer_status($con , $id){
    /*check customer exist*/
    if(isset($id) && !empty($id)){
        $customer_result=$con->query("SELECT * FROM customers WHERE id=$id");
        if ($customer_result->num_rows == 0) {
            return ['success' => false, 'message' => 'Customer not found'];
        }
    }
    /*Check customer status*/
    $online_check_customer = $con->query("SELECT 1 FROM radacct WHERE username = (SELECT username FROM customers WHERE id = '$id') AND acctstoptime IS NULL");
    if ($online_check_customer->num_rows > 0) {
        echo json_encode(['success' => true, 'status' => 'online']);
        exit; 
    } else {
        echo json_encode(['success' => true, 'status' => 'offline']);
        exit; 
    }
 }
 function customer_monthly_uses($con,$customer_id){
    if(!empty($customer_id) && isset($customer_id)){
        $username = $con->query("SELECT `username` FROM customers WHERE id=$customer_id")->fetch_assoc()['username'];
         $currentMonth = date("m");
        if ($lastused = $con->query("SELECT SUM(acctinputoctets)/1000/1000/1000 AS GB_IN, SUM(acctoutputoctets)/1000/1000/1000 AS GB_OUT FROM radacct WHERE username='$username' AND  MONTH(acctstarttime)='$currentMonth'")) {
            $r_usd_rows = $lastused->fetch_array();
            $Download = $r_usd_rows["GB_OUT"];
            $Download = number_format($Download, 3);
            $Upload = $r_usd_rows["GB_IN"];
            $Upload = number_format($Upload, 3);
            echo json_encode(['success' => true, 'data' => ['download' => $Download, 'upload' => $Upload]]);
        }
    }
 }

 function execute_customer_bkash_payment($con, $customer_id){
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
            $con -> query("UPDATE radreply SET value='$package' WHERE username='$username'");

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
        echo json_encode(['success' => true, 'message' => 'Payment Successfully Done']);
 
 }

?>