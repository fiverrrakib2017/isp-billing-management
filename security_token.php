<?php
session_start();
$_SESSION["uid"];
$_SESSION["username"];
$_SESSION["fullname"];
$_SESSION["tcoken"];

if(empty($_SESSION["username"]))
{
	
	header('location: login.php');
}
?>