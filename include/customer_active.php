<?php 
include "db_connect.php";

if (isset($_GET['clid'])) {
	$id= $_GET['clid'];
	if ($result=$con->query("UPDATE customers SET status = '1' WHERE `id` =$id;")) {
		if ($result==true) {
			header("location:../con_request.php");
		}
	}
}



 ?>