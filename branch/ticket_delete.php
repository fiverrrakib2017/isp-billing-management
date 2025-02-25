<?php 


include '../include/db_connect.php';

if (isset($_GET['id'])) {
	 $id=$_GET['id'];

	$result=$con->query("DELETE FROM `ticket` WHERE id='$id'");
	if ($result==true) {
		header("location:allTickets.php");
	}else{

	}
}


 ?>