<?php 

include "db_connect.php";
if(isset($_GET['add']))
{
	$details = $_GET['details'];
	$ledgr_id = $_GET['ledgr_id'];
	$description = $_GET['description'];
	$con -> query("INSERT INTO ledger_items_details(sub_ldgr_id,details,description) VALUES('$ledgr_id', '$details','$description')");
	$con -> close();
}



if(isset($_GET['list']))
{
	$listd =$_GET['list'];

	$detailss = $con-> query("SELECT * FROM ledger_items_details WHERE sub_ldgr_id='$listd'");

	        while($rowl= $detailss->fetch_array()){
	            $id=$rowl["id"];
	            $details = $rowl["details"];
	            echo '<option value='.$id.'>'.$details.'</option>';
	        }
	    
                                    
                                      
	$con -> close();
}


?>