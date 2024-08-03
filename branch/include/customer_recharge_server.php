<?php
session_start();
include "db_connect.php";
// include"users_right.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['add_recharge_data'])) {
  $customer_id = $_POST['customer_id'];
  $chrg_mnths = $_POST['month'];
  $package_purchase_price = $_POST['amount'];
  $pop_id = $_POST['pop_id'];
  $recharge_by = $_SESSION['username'];
  $RefNo = $_POST['RefNo'];

  $tra_type = $_POST['tra_type'];
  //how to get customer package of customers table 
  if ($allCstmr=$con->query("SELECT * FROM customers WHERE id=$customer_id")) {
    while($rows=$allCstmr->fetch_array()){
        $packageId=$rows['package'];
    }
  }
  //get customer sale's price 
  if ($allPackg=$con->query("SELECT * FROM branch_package WHERE pkg_id=$packageId")) {
    while($rows=$allPackg->fetch_array()){
        $package_sales_price=$rows['s_price'];
    }
  }
  //পপ এর বেলেন্স চেক করে রিচারজ করবো , 
  if ($pop_payment = $con->query("SELECT SUM(`amount`) AS balance FROM `pop_transaction` WHERE pop_id='$pop_id' ")) {
    while ($rows = $pop_payment->fetch_array()) {
       $popBalance = $rows["balance"];
    }
    if ($customer_recharge = $con->query(" SELECT SUM(`purchase_price`) AS amount FROM `customer_rechrg` WHERE pop_id='$pop_id' ")) {
      while ($rows = $customer_recharge->fetch_array()) {
         $rechargeBalance = $rows["amount"];
      }
    }
     $totalCurrentBal = $popBalance - $rechargeBalance;
  }

  //এখন কন্ডিশন দিব যদি পপ এর টাকা কম হয় তাহলে ডাটাবেজ এর কানেকশন বন্দ করে দিবো , recharge করতে দিবো নাহ , 
  if ($package_purchase_price > $totalCurrentBal) {
    echo "Please Recharge This POP/Branch ";
  } else {

    //পপের বেলেন্স চেক করা শেষ এখন কাস্টমার  আইডি ধরে তার expire date বের করবো , কারন রিচারজ হলে অই তারিখ টা বাড়িয়ে দিবো ।   

    if ($cstmr = $con->query("SELECT * FROM customers WHERE id='$customer_id'")) {

      while ($rows = $cstmr->fetch_array()) {
        $lstid = $rows["id"];
        $package = $rows["package"];
        $username = $rows["username"];

        $expiredDate = $rows["expiredate"];
      }
    }

    if ($expiredDate < date('Y-m-d')) {
      $exp_date = date('Y-m-d', strtotime('+' . $chrg_mnths . ' month', strtotime(date('Y-m-' . date('d', $expiredDate)))));
    } else {
      // Increase recharge monthe from current expired date
      $exp_date = date('Y-m-d', strtotime('+' . $chrg_mnths . ' month', strtotime($expiredDate)));
    }

    $con->query("INSERT INTO customer_rechrg(customer_id,pop_id,months,sales_price,purchase_price,ref,rchrg_until,type,rchg_by,datetm) VALUES('$customer_id','$pop_id','$chrg_mnths','$package_sales_price','$package_purchase_price','$RefNo','$exp_date','$tra_type','$recharge_by',NOW())");

    // Total Paid amount 
    if ($ttlpdamt = $con->query("SELECT SUM(purchase_price) AS TotalPaidAmt FROM customer_rechrg WHERE customer_id='$customer_id' AND type!='0'")) {
      while ($rowspd = $ttlpdamt->fetch_array()) {
        $TotalPaidAmt = $rowspd["TotalPaidAmt"];
      }
    }
    // Total recharged Credit amount
    if ($ttlduamt = $con->query("SELECT SUM(purchase_price) AS TotaldueAmt FROM customer_rechrg WHERE customer_id='$customer_id' AND type='0'")) {
      while ($rowsdu = $ttlduamt->fetch_array()) {
        $TotaldueAmt = $rowsdu["TotaldueAmt"];
      }
    }

    // Total Recharged Amount
    if ($ttlrchgmt = $con->query("SELECT SUM(purchase_price) AS TotalrchgAmt FROM customer_rechrg WHERE customer_id='$customer_id' AND type!='4'")) {
      while ($rowrch = $ttlrchgmt->fetch_array()) {
        $TotalrchgAmt = $rowrch["TotalrchgAmt"];
      }
    }
    $balanceamount = $TotalrchgAmt - $TotalPaidAmt;
    $con->query("UPDATE customers SET expiredate='$exp_date', rchg_amount='$TotalrchgAmt', paid_amount='$TotalPaidAmt', balance_amount='$balanceamount' WHERE id='$customer_id'");
    //$con -> query("INSERT INTO radcheck(username,attribute,op,value) VALUES('$username','Cleartext-Password',':=','$password')");
    //$con -> query("INSERT INTO radreply(username,attribute,op,value) VALUES('$username','MikroTik-Group',':=','$package')");
    echo 1;
    $con->close();
  }
}
if (isset($_POST['addCustomerDuePayment'])) {

  $customer_id = $_POST['customer_id'];
  $amount = $_POST['amount'];
  $pop_id = $_POST['pop_id'];
  $remarks = $_POST['remarks'];
  $transaction_type = 4;
  $date = date('Y-m-d');
  $recharge_by = $_SESSION['username'];

  $result = $con->query("INSERT INTO `customer_rechrg` (`id`, `customer_id`, `pop_id`, `months`, `sales_price`,`purchase_price`, `ref`, `rchrg_until`, `type`, `rchg_by`, `datetm`) VALUES (NULL, '$customer_id', '$pop_id', '', '00','$amount', '$remarks', '2023-06-02', '$transaction_type', '$recharge_by', '$date');");
  if ($result == true) {

    // Total Paid amount 
    if ($ttlpdamt = $con->query("SELECT SUM(purchase_price) AS TotalPaidAmt FROM customer_rechrg WHERE customer_id='$customer_id' AND type!='0'")) {
      while ($rowspd = $ttlpdamt->fetch_array()) {
        $TotalPaidAmt = $rowspd["TotalPaidAmt"];
      }
    }
    // Total recharged Credit amount
    if ($ttlduamt = $con->query("SELECT SUM(purchase_price) AS TotaldueAmt FROM customer_rechrg WHERE customer_id='$customer_id' AND type='0'")) {
      while ($rowsdu = $ttlduamt->fetch_array()) {
        $TotaldueAmt = $rowsdu["TotaldueAmt"];
      }
    }

    // Total Recharged Amount
    if ($ttlrchgmt = $con->query("SELECT SUM(purchase_price) AS TotalrchgAmt FROM customer_rechrg WHERE customer_id='$customer_id' AND type!='4'")) {
      while ($rowrch = $ttlrchgmt->fetch_array()) {
        $TotalrchgAmt = $rowrch["TotalrchgAmt"];
      }
    }

    $balanceamount = $TotalrchgAmt - $TotalPaidAmt;
    $con->query("UPDATE customers SET rchg_amount='$TotalrchgAmt', paid_amount='$TotalPaidAmt', balance_amount='$balanceamount' WHERE id='$customer_id'");






    echo 1;
  } else {
    echo $con->error;
  }

  $con->close();
}
if (isset($_POST['customer_temp_recharge'])) {

  $customer_id = $_POST['customer_id'];
  $pop_id = $_POST['pop_id'];
  $days = $_POST['days'];
  $RefNo = $_POST['RefNo'];
  $transaction_type = $_POST['transaction_type'];
  if ($cstmr = $con->query("SELECT * FROM customers WHERE id='$customer_id' AND pop=$pop_id")) {

    while ($rows = $cstmr->fetch_array()) {
      $expiredDate = $rows["expiredate"];
    }
  }

  $new_date = date("Y-m-d", strtotime($expiredDate . " + $days days"));
  $result = $con->query("UPDATE customers SET expiredate='$new_date' WHERE id='$customer_id'");
  if ($result == true) {
    echo 1;
  } else {
    echo 0;
  }
  $con->close();
}
