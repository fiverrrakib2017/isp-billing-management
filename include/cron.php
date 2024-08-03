<?php
include "db_connect.php";
date_default_timezone_set("Asia/Dhaka");

	
if ($cstmr = $con-> query("SELECT * FROM customers WHERE expiredate<=NOW()")) {

  
  while($rows= $cstmr->fetch_array())
  {
	  $lstid=$rows["id"];
	  $username = $rows["username"];
	  
	  // Expire date Expired but grase date has expiry date [so dont disable the customers]
	  $gracetime = $con-> query("SELECT * FROM customers WHERE grace_expired>=NOW() AND username='$username'");
	  if($gracetime == true)
	  {
		  
	  }
	  else
	  {
		$con -> query("UPDATE customers SET status='2' WHERE username='$username'");
		$con -> query("UPDATE radreply SET value='expired' WHERE username='$username'");
	  }
	  
	  
  }
}
if(date("h") >= "01")
{
$con -> query("DELETE FROM radpostauth");


}
//




// Wrong Online user correction
$crrusr = $con -> query("SELECT username, acctstarttime FROM radacct WHERE acctstoptime IS NULL");
//$crrusr = mysqli_query($con, $sql);

		if($crrusr->num_rows>1)
		{
			echo "Working...";
			while($rowcrr = $crrusr->fetch_array())
			{
				$radacctid=$rowcrrs["radacctid"];
	  			$username = $rows["username"];
				$acctstarttime = $rows["acctstarttime"];

				$con->query("UPDATE radacct SET acctstoptime=NOW() WHERE username='$username' AND acctstoptime IS NULL AND radacctid!=SELECT MAX(radacctid) FROM radacct WHERE username='$username' AND acctstoptime IS NULL");

			}

		}
// Update cron run time
$con -> query("UPDATE cron SET date = NOW() WHERE id = 1");

$con -> close();
?>
