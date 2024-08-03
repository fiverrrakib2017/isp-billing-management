<?php 

include("db_connect.php");
include("users_right.php");



if (isset($_SESSION['user_pop'])) {
	header("location:branch/index.php");
}else{
	//header("location:login.php");
}

// if (empty($_SESSION['user_pop'])) {
// 	header("location:index.php");
// }