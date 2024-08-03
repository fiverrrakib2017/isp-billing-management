<?php
session_start();
$_SESSION["uid"] = "";	
$_SESSION["username"] = "";	

session_destroy();
header("location: ../login.php");


?>
