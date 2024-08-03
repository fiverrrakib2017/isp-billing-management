<?php 


include 'include/db_connect.php';

if (isset($_GET['id'])) {
	 $id=$_GET['id'];

	$result=$con->query("DELETE FROM `product_brand` WHERE id=$id ");
	if ($result==true) {
		header("location:brand.php");
	}else{

	}
}


 ?>