<?php
include "db_connect.php";

	
	$con -> query("UPDATE customers SET notes = NOW()");
	
	
if ($cstmr = $con -> query("SELECT * FROM customers WHERE expiredate<=NOW()")) {

  
  while($rows= $cstmr->fetch_array())
  {
	  $lstid=$rows["id"];
	  $username = $rows["username"];
	  
	  $con -> query("UPDATE customers SET status='2' WHERE username='$username'");
	  $con -> query("UPDATE radreply SET value='expired' WHERE username='$username'");
  }
}
$con -> close();
?>
