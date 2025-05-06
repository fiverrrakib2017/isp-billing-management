<?php 


include '../include/db_connect.php';

if (isset($_GET['id'])) {
	  $id=$_GET['id'];

	$result=$con->query("DELETE FROM  message_template WHERE id=$id ");
	if ($result==true) {
		header("location:../branch/message_template.php");
	}else{

	}
}



 ?>