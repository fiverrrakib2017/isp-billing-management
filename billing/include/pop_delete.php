<?php 
include "db_connect.php";
if (isset($_GET["id"])) {
	 $deleteId=$_GET["id"];
	$result= $con->query("DELETE FROM add_pop WHERE id='$deleteId'");

	if ($result==true) {
		header("location:../pop_branch.php");
		echo "<script>alert('Delete Successfully');</script>";
	}else{
		echo "<script>alert('Error');</script>";
	}
}



 ?>