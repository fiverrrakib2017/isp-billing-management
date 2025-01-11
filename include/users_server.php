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


    $con->query("UPDATE users SET fullname='$fullname', username='$username',password='$password',mobile='$mobile',email='$email',role='$role' WHERE id=$userId      ");
   
}

/*Add User Script*/
if (isset($_GET['add_user']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
	require 'functions.php';
    /*Sanitize and validate inputs*/
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
	
    $fullname = isset($_POST["fullname"]) ? trim($_POST["fullname"]) : '';
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : '';
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';
    $mobile = isset($_POST["mobile"]) ? trim($_POST["mobile"]) : '';
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
    $role = isset($_POST["role"]) ? trim($_POST["role"]) : '';

	/*Hash the password*/ 
	//$hashed_password = password_hash($password, PASSWORD_BCRYPT);

    /* Validate fullname */
    if (empty($fullname)) {
        echo json_encode([
            'success' => false,
            'message' => 'fullname is required!',
        ]);
        exit;
    }
    /* Validate username */
    if (empty($username)) {
        echo json_encode([
            'success' => false,
            'message' => 'Username is required!',
        ]);
        exit;
    }
    /* Validate password */
    if (empty($password)) {
        echo json_encode([
            'success' => false,
            'message' => 'password is required!',
        ]);
        exit;
    }
    /* Validate Email */
    if (empty($email)) {
        echo json_encode([
            'success' => false,
            'message' => 'Email is required!',
        ]);
        exit;
    }
    /* Validate mobile */
    if (empty($mobile)|| !preg_match('/^[0-9]{10,15}$/', $mobile)) {
        echo json_encode([
            'success' => false,
            'message' => 'Valid Mobile number is required!',
        ]);
        exit;
    }
    /* Validate Role */
    if (empty($role)) {
        echo json_encode([
            'success' => false,
            'message' => 'Role is required!',
        ]);
        exit;
    }

	/*Check Username  already exist*/
	if (isUniqueColumn($con, 'users', 'username', $username)) {
		echo json_encode([
            'success' => false,
            'message' => 'Username already exists!',
        ]);
        exit;
	}
	/*Check  Email already exist*/
	if (isUniqueColumn($con, 'users', 'email', $email)) {
		echo json_encode([
            'success' => false,
            'message' => 'Email already exists!',
        ]);
        exit;
	}
	

    /*Update query*/
	$query = "INSERT INTO users (user_type,fullname, username, password, mobile, email, role, lastlogin) VALUES ('1',?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $con->prepare($query);
    if ($stmt) {
		$stmt->bind_param("ssssss", $fullname, $username, $password, $mobile, $email, $role);
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'User added successfully!',
                
            ]);
            exit; 
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to User Added.',
            ]);
            exit; 
        }
    }
    exit; 
}

?>