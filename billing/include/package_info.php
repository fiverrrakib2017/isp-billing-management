<?php
include "db_connect.php";

if(isset($_GET['edit']))
{
	 $packgID = $_GET['pakgid'];
	
	if ($package = $con -> query("SELECT * FROM radgroupcheck WHERE id='$packgID' LIMIT 1")) {
  
  
  while($rows= $package->fetch_array())
  {
	  $lstid = $rows["id"];
	  $packgid = $rows["id"];
	  $packagename = $rows["groupname"];
	  $pool = $con->query("SELECT * FROM pool WHERE radgrp_id=$packgid");
			 while($rowp= $pool->fetch_array())
				  {
					 $pname = $rowp["name"];
					 $pstrtip = $rowp["start_ip"];
					 $pendip = $rowp["end_ip"];
				  }
	 
  }
  
	echo json_encode(
        array(
            "pckgid" => $packgID,
            "pckgname" => $packagename,
            //"color"		=> "green",
            //"data"		=> $Config
        )) ;

	
	//$con -> query("INSERT INTO radgroupcheck(groupname,attribute,op,value) VALUES('$packgname','Framed-Protocol','==','PPP')");
	//$con -> close();
}
}
?>
