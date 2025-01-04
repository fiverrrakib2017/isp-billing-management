<?php 
include "db_connect.php";
if (isset($_GET['id'])) {
	$deleteId=$_GET['id'];

	$result=$con->query("DELETE FROM ledger WHERE id='$deleteId'");
	if ($result==true) {
		header("location:../ledger.php");
	}else{
		echo "<script>alert('Error!!');</script>";
	}
}

 
 
 ?>