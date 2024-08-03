<?php 


include 'include/db_connect.php';

if (isset($_GET['id'])) {
	 $id=$_GET['id'];

	$result=$con->query("DELETE FROM `radgroupcheck` WHERE id=$id ");
	if ($result==true) {
		header("location:package_add.php");
	}else{

	}
}


 ?>