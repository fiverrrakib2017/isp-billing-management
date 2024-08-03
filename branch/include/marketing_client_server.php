<?php 
include "db_connect.php";

if(isset($_GET['add']))
{
	$area = $_GET['area'];

$result=$con->query("INSERT INTO marketing_area(area) VALUES('$area')");
	if ($result==true) {
		return "Data insert successfully";
	}else{
		return "Error!!!";
	}
	
}

 ?>