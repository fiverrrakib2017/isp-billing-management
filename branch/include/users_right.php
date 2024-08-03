<?php 


include("security_token.php");
include("db_connect.php");

if (isset($_SESSION['username'])) {
	 $id= $_SESSION['uid'];
}

if ($user=$con->query("SELECT * FROM users WHERE id=$id ")) {
		while ($rows=$user->fetch_array()) {
			    $auth_usr_type= $rows['user_type'];
			    $auth_usr_POP_id= $rows['pop_id'];
		}
	}

	 // echo "user_type".$auth_usr_type."<br>";
	 // echo "auth_usr_POP_id".$auth_usr_POP_id;