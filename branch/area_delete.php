<?php 


include 'include/db_connect.php';

if (isset($_GET['id'])) {
	 $id=$_GET['id'];

	$result=$con->query("DELETE FROM  area_list WHERE id=$id ");
	if ($result==true) {
		header("location:pop_area.php");
	}else{

	}
}


 ?>