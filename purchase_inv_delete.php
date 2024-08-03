<?php 


include 'include/db_connect.php';

if (isset($_GET['clid'])) {
	  $id=$_GET['clid'];

	$result=$con->query("DELETE FROM  purchase WHERE id=$id ");
	if ($result==true) {
		header("location:purchase_invoice.php");
	}else{

	}
}


 ?>