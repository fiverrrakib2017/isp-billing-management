<?php
session_start();
include "db_connect.php";
include("security_token.php");
include("users_right.php");

if(isset($_GET["recharge"]))
{
    if (isset($_SESSION['fullname'])) {
        $logged_user = $_SESSION['fullname'];
    } 
    else{
        $logged_user="System";
    }
    $itemCount = count($_GET["checkAll"]);
    $pop_id = $_GET["rchPOP"];
    $chrg_mnths = 1; // Recharge for one month

    for ($i = 0; $i < $itemCount; $i ++) {
            $customer_id = $_GET["checkAll"][$i];
//*
            
//////////////////////////////////////////////////
//Find the customer and Recharge set expire date//
//////////////////////////////////////////////////

if ($cstmr = $con->query("SELECT * FROM customers WHERE id='$customer_id'")) {

      while ($rows = $cstmr->fetch_array()) {
        $customer_id = $rows["id"];
        $packageId = $rows["package"];
        $package_name = $rows["package_name"];
        $package_price = $rows["price"];
        $customer_POP = $rows["pop"];
        $username = $rows["username"];
        $expiredDate = $rows["expiredate"];
      }
    }
////////////////////////////////////////////
// Package Sales and Purchase Price by POP//
////////////////////////////////////////////
if ($allPackg=$con->query("SELECT * FROM branch_package WHERE id=$packageId")) {
    while($rows=$allPackg->fetch_array()){
        $package_sales_price=$rows['s_price'];
        $package_purchase_price=$rows['p_price'];
    }
  }
////////////////////////////////////////
// Generete Expire date by Rchg Months//
////////////////////////////////////////
    if ($expiredDate < date('Y-m-d')) {
      $exp_date = date('Y-m-d', strtotime('+' . $chrg_mnths . ' month', strtotime(date('Y-m-' . date('d', $expiredDate)))));
    } else {
      // Increase recharge monthe from current expired date
      $exp_date = date('Y-m-d', strtotime('+' . $chrg_mnths . ' month', strtotime($expiredDate)));
    }
//////////////////////
// POP Balance Check//
//////////////////////
if ($pop_payment = $con->query("SELECT SUM(amount) AS pop_amount FROM pop_transaction WHERE pop_id='$pop_id'")) {
        while ($rows = $pop_payment->fetch_array()) {
            $pop_amount = $rows["pop_amount"];
        }

if ($customer_recharge = $con->query("SELECT SUM(purchase_price) AS total_rchg_amount FROM customer_rechrg WHERE pop_id='$pop_id'")) {
    while ($rowr = $customer_recharge->fetch_array()) {
        $total_rchg_amount = $rowr["total_rchg_amount"];
    }
    }
    $totalCurrentBal = $pop_amount - $total_rchg_amount;

        
///////////////////////////////////
// After verifing all insert data//
///////////////////////////////////
if($totalCurrentBal>=$package_price)
{
    //echo $totalCurrentBal." ".$exp_date." ".$username;
    $con->query("INSERT INTO customer_rechrg(customer_id,pop_id,months,sales_price,purchase_price,ref,rchrg_until,type,rchg_by,datetm) VALUES('$customer_id','$pop_id','$chrg_mnths','$package_sales_price','$package_purchase_price','Group Rchg.','$exp_date','1','$logged_user',NOW())");
    $con->query("UPDATE radreply SET value='$package_name' WHERE username='$username'");

/////////////////////////////////////////////////
// Update total Balance information to customer//
/////////////////////////////////////////////////
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
  $con->query("UPDATE customers SET expiredate='$exp_date', status='1', rchg_amount='$TotalrchgAmt', paid_amount='$TotalPaidAmt', balance_amount='$balanceamount' WHERE id='$customer_id'");
  
  
}



            }

}

/////////////
if($totalCurrentBal==0)
{
    echo '0';
}
else{

    echo '1';
}



}
//*/

/*
if (! empty($_POST["save"])) {
    $connection = mysqli_connect("localhost", "root", "", "dynamic_textbox");
    $itemCount = count($_POST["item_name"]);
    for ($i = 0; $i < $itemCount; $i ++) {
        if (! empty($_POST["item_name"][$i]) || ! empty($_POST["item_price"][$i])) {
            $query = "INSERT INTO item (item_name,item_price) VALUES(?, ?)";
            $statement = $connection->prepare($query);
            $statement->bind_param('si', $_POST["item_name"][$i], $_POST["item_price"][$i]);
            $result = $statement->execute();
        }
        if (! empty($result)) {
            $response = array("type"=>"success", "message"=>"Added successfully.");
        } else {
            $response = array("type"=>"error", "message"=>"Please enter the data.");
        }
    }
}

*/
?>