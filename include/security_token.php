<?php
if(!isset($_SESSION)){
	session_start();
}
$_SESSION["uid"];
$_SESSION["username"];


/*********************Check user is loged in *************************************/
if(empty($_SESSION["username"]) || empty($_SESSION['uid']))
{
	
	header('location: login.php');
	exit; 
}
/*************************************Include Database Connection*************************************/
if(!file_exists('db_connect.php')){
	include 'db_connect.php';
}else{
	$con = new mysqli("localhost","radiususr","src@54321","radiusdb");
	/*Check connection*/ 
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
}
if($_SESSION['uid']!=='0' && !empty($_SESSION['uid'])){
	if($stmt =$con->prepare("SELECT * FROM users WHERE id = ?")){
		$stmt->bind_param("i", $_SESSION['uid']); 
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			$_SESSION['details'] = $result->fetch_assoc(); 
		} else {
			session_destroy();
			header('Location: login.php');
			exit;
		}
		$stmt->close();
	}
}

/* Close the database connection*/
$con->close();
?>