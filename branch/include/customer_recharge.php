<?php 
session_start();
include "db_connect.php";
include "users_right.php";


if(isset($_POST['customer_id'])){
  $customer_id = $_POST['customer_id'];
  $chrg_mnths= $_POST['month'];
  $amount= $_POST['amount'];
  $ref= $_POST['ref'];
  $username= $_SESSION['username'];
  //$totalRechargeAmount=$chrg_mnths*$amount;
  
  if ($cstmr = $con -> query("SELECT * FROM customers WHERE id='$customer_id'")) {
  
  while($rows= $cstmr->fetch_array())
  {
      $lstid = $rows["id"];
      $package = $rows["package"];
      $username = $rows["username"];
     
      $expiredDate=$rows["expiredate"];
}
  }
  /**/
  if($expiredDate<date('Y-m-d'))
  {
	$exp_date = date('Y-m-d', strtotime('+'.$chrg_mnths.' month', strtotime(date('Y-m-'.date('d',$expiredDate)))));
  }
  else
  {
	// Increase recharge monthe from current expired date
	$exp_date = date('Y-m-d', strtotime('+'.$chrg_mnths.' month', strtotime($expiredDate)));	 
  }
 
 
  //$chrg_mnths = "5";
	   // One month from a specific date
	//$exp_date = date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m-'.$exp_date))));
	
	

	$con->query("INSERT INTO customer_rechrg(customer_id,pop_id,months,amount,ref,rchrg_until,rchg_by,datetm) VALUES('$customer_id','$auth_usr_POP_id','$chrg_mnths','$amount','$ref','$exp_date','$username',NOW())");
  
	$con -> query("UPDATE customers SET expiredate='$exp_date' WHERE id='$customer_id'");
	//$con -> query("INSERT INTO radcheck(username,attribute,op,value) VALUES('$username','Cleartext-Password',':=','$password')");
	//$con -> query("INSERT INTO radreply(username,attribute,op,value) VALUES('$username','MikroTik-Group',':=','$package')");
 $con -> close();

}
  
?>