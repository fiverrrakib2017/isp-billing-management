<?php

include "db_connect.php";
include 'security_token.php';

if (isset($_POST['addPopData'])) {
    $pop_name= $_POST['pop'];
   $fullname= $_POST['fullname'];
   $username= $_POST['username'];
   $password= $_POST['password'];
    $opening_bal= $_POST['opening_bal'];
   $mobile_num1= $_POST['mobile_num1'];
   $mobile_num2= $_POST['mobile_num2'];
   $email_address= $_POST['email_address'];
   $note= $_POST['note'];
   $user_type= $_POST['user_type'];

   date_default_timezone_set('Asia/Dhaka');
    $todayDate=date('H:i A, d-M-Y');

    $addBy=$_SESSION['username'];
   if ($result=$con->query("INSERT INTO add_pop(user_type,pop,fullname,username,password,opening_bal,mobile_num1,mobile_num2,email_address,note) VALUES('$user_type','$pop_name','$fullname','$username','$password','$opening_bal','$mobile_num1','$mobile_num2','$email_address','$note')")) {
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
