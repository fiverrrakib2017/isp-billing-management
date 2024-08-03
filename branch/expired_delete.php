<?php 


include 'include/db_connect.php';

if (isset($_GET['id'])) {
	  $id=$_GET['id'];

	$result=$con->query("DELETE FROM `customer_expires` WHERE id=$id ");
	if ($result==true) {
		header("location:expired.php");
	}else{

	}
}


 ?>