<?php 

 include("db_connect.php");

/*Add User Script*/
if (isset($_GET['add_company_data']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
	require 'functions.php';
    /*Sanitize and validate inputs*/
	
    $company_name = isset($_POST["company_name"]) ? trim($_POST["company_name"]) : '';
    $fullname = isset($_POST["fullname"]) ? trim($_POST["fullname"]) : '';
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : '';
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';
    $mobile_number = isset($_POST["mobile_number"]) ? trim($_POST["mobile_number"]) : '';
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
    $address = isset($_POST["address"]) ? trim($_POST["address"]) : '';
    $company_logo = isset($_POST["company_logo"]) ? trim($_POST["company_logo"]) : '';

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

if (isset($_GET['get_user']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $user_id = intval($_GET['id']);

    /* Prepare the SQL statement*/
    $stmt = $con->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    /*Execute the statement*/ 
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $response = array("success" => true, "data" => $data);
        } else {
            $response = array("success" => false, "message" => "No record found!");
        }
    } else {
        $response = array("success" => false, "message" => "Error executing query: " . $stmt->error);
    }

    /*Close the statement*/
    $stmt->close();
    $con->close();

    /* Return the response as JSON*/
    echo json_encode($response);
    exit;
}


/*Update User Script*/
if (isset($_GET['update_user']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
	require 'functions.php';
    /*Sanitize and validate inputs*/
    $id = trim($_POST['id']);
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
	
    $id = isset($_POST["id"]) ? trim($_POST["id"]) : '';
    $fullname = isset($_POST["fullname"]) ? trim($_POST["fullname"]) : '';
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : '';
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';
    $mobile = isset($_POST["mobile"]) ? trim($_POST["mobile"]) : '';
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
    $role = isset($_POST["role"]) ? trim($_POST["role"]) : '';

	/* Validate User ID */
	if (empty($id)) {
		echo json_encode([
			'success' => false,
			'message' => 'User ID is required!',
		]);
		exit;
    }
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
	if (isUniqueColumn($con, 'users', 'username', $username, $id)) {
		echo json_encode([
            'success' => false,
            'message' => 'Username already exists!',
        ]);
        exit;
	}
	/*Check  Email already exist*/
	if (isUniqueColumn($con, 'users', 'email', $email, $id)) {
		echo json_encode([
            'success' => false,
            'message' => 'Email already exists!',
        ]);
        exit;
	}
	/* Update query */
	 $query = "UPDATE users SET fullname = ?, username = ?, password = ?, mobile = ?, email = ?, role = ? WHERE id = ?";

    $stmt = $con->prepare($query);
    if ($stmt) {
		$stmt->bind_param("ssssssi", $fullname, $username, $password, $mobile, $email, $role, $id);
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'User Update successfully!',
                
            ]);
            exit; 
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to User Update.',
            ]);
            exit; 
        }
    }
    exit; 
}

?>