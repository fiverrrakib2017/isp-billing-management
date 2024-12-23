<?php 

 include("db_connect.php");
	
//update data

 if (isset($_GET["update"])) {
	$userId=$_GET["id"];
	$fullname=$_GET["fullname"];
	$username=$_GET["username"];
	$password=$_GET["password"];
	$mobile=$_GET["mobile"];
	$email=$_GET["email"];
	$role=$_GET["role"];
	$last_login=$_GET["lastlogin"];


    $con->query("UPDATE users SET fullname='$fullname', username='$username',password='$password',mobile='$mobile',email='$email',role='$role' WHERE id=$userId ");
   
}





	if(isset($_GET["add"])){
		echo $fullname = $_GET['fullname'];
		 $username = $_GET['username'];
		 $password = $_GET['password'];
		 $mobile = $_GET['mobile'];
		 $email = $_GET['email'];
		 $role = $_GET['role'];
		 $last_login = $_GET['last_login'];

		$con->query("INSERT INTO users(user_type,fullname,username,password,mobile,email,role,lastlogin) VALUES('1','$fullname','$username','$password','$mobile','$email','$role',NOW())");
		$con->close();
	}

?>