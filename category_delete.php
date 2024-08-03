<?php 


include 'include/db_connect.php';

if (isset($_GET['id'])) {
	echo $id=$_GET['id'];

	$result=$con->query("DELETE FROM `product_cat` WHERE id='$id'");
	if ($result==true) {
		header("location:category.php");
	}else{

	}
}


 ?>