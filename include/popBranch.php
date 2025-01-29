<?php
include "db_connect.php";
if(!isset($_SESSION)){
    session_start();
}

/*Add POP/Branch Script*/
if (isset($_GET['add_pop']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
	require 'functions.php';
    /* validate inputs*/
    $pop_name = trim($_POST['pop']);
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $opening_bal = trim($_POST['opening_bal']);
    $mobile_num1 = trim($_POST['mobile_num1']);
    $mobile_num2 = trim($_POST['mobile_num2']);
    $email_address = trim($_POST['email_address']);
    $note = trim($_POST['note']);
    $user_type = trim($_POST['user_type']);
    $addBy=$_SESSION['uid']??1;

    /* Validate pop name */
    if (empty($pop_name)) {
        echo json_encode([
            'success' => false,
            'message' => 'POP/Branch name is required!',
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
    /* Validate opening_bal */
    if (empty($opening_bal)) {
        echo json_encode([
            'success' => false,
            'message' => 'Opening Balance is required!',
        ]);
        exit;
    }
    /* Validate mobile */
    if (empty($mobile_num1)|| !preg_match('/^[0-9]{10,15}$/', $mobile_num1)) {
        echo json_encode([
            'success' => false,
            'message' => 'Valid Mobile number is required!',
        ]);
        exit;
    } 
    /* Validate Email Address */
    if (empty($email_address)) {
        echo json_encode([
            'success' => false,
            'message' => 'Email Address is required!',
        ]);
        exit;
    }
    date_default_timezone_set('Asia/Dhaka');
    $todayDate=date('H:i A, d-M-Y');

    /* query*/
	$con->query("INSERT INTO add_pop(user_type,status,pop,fullname,username,password,opening_bal,mobile_num1,mobile_num2,email_address,note) VALUES('$user_type','0','$pop_name','$fullname','$username','$password','$opening_bal','$mobile_num1','$mobile_num2','$email_address','$note')");
    $lastId = $con->insert_id;
    if ($lastId) {
        $con->query("INSERT INTO users(user_type,pop_id,fullname,username,password,mobile,email) VALUES('2','$lastId','$fullname','$username','$password','$mobile_num1','$email_address')");
        $con->query("INSERT INTO pop_transaction(pop_id,amount,paid_amount,action,transaction_type,remarks,recharge_by,date)VALUES( '$lastId', '$opening_bal', '$opening_bal', 'paid', '0', NULL, '$addBy', '$todayDate')");
        echo json_encode([
            'success' => true,
            'message' => 'Added successfully!',
        ]);
        exit;
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to add POP/Branch!',
        ]);
        exit;
    }
    exit; 
}
if (isset($_POST['addPopData'])) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";exit; 
    

  

    $addBy=$_SESSION['username'];
   if ($result=$con->query()) {
       $lastId=$con->insert_id;
       if ($result==true) {
           if ($result1=$con->query("INSERT INTO users(user_type,pop_id,fullname,username,password,mobile,email) VALUES('2','$lastId','$fullname','$username','$password','$mobile_num1','$email_address')")) {
               if ($result1==true) {
                   if ($final_result=$con->query("INSERT INTO pop_transaction(pop_id,amount,paid_amount,action,transaction_type,remarks,recharge_by,date)VALUES( '$lastId', '$opening_bal', '$opening_bal', 'paid', '0', NULL, '$addBy', '$todayDate')")) {
                       if ($final_result==true) {
                           echo 1;
                       }else{
                            echo 0;
                       }
                   }
               }
           }
       }
   }


    
$con -> close();
       
   
}

?>
