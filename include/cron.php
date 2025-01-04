<?php
include "db_connect.php";
date_default_timezone_set("Asia/Dhaka");

/*	*/	
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
	  // If expire both grace & date
	  $exdate = $con-> query("SELECT * FROM customers WHERE (grace_expired<=NOW()) OR (grace_expired IS null)  AND expiredate<=NOW() AND username='$username'");
	  if($exdate == true)
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


// Wrong Online user correction
$crrusr = $con -> query("SELECT username, acctstarttime FROM radacct WHERE acctstoptime IS NULL");

		if($crrusr->num_rows>1)
		{
			
			while($rowcrr = $crrusr->fetch_array())
			{
				$radacctid=$rowcrr["radacctid"];
	  			$username = $rowcrr["username"];
				//$acctstarttime = $rows["acctstarttime"];
				
				//
				$oneonline = $con->query("SELECT radacctid FROM radacct WHERE username='$username' AND acctstoptime IS NULL ORDER BY radacctid DESC LIMIT 1");
				 if($oneonline->num_rows)
						{
							while($rowone = $oneonline->fetch_array())
							{
								$lastusr = $rowone["radacctid"];		
							}
						}

				$con->query("UPDATE radacct SET acctstoptime=NOW() WHERE username='$username' AND acctstoptime IS NULL AND radacctid!='$lastusr'");
				$con->query("DELETE FROM radacct WHERE username!=SELECT username FROM customers");
			}

		}
		
// Mismatch of online user then total user in customers..
$con->query("DELETE FROM radacct WHERE radacct.username NOT IN (SELECT customers.username FROM customers))");
// Update cron run time
$con -> query("UPDATE cron SET date = NOW() WHERE id = 1");

$con -> close();
?>
