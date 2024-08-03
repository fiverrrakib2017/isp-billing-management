<?php

include "db_connect.php";


if (isset($_GET['add'])) {
    $pop_name= $_GET['pop'];
   $fullname= $_GET['fullname'];
   $username= $_GET['username'];
   $password= $_GET['password'];
   $opening_bal= $_GET['opening_bal'];
   $mobile_num1= $_GET['mobile_num1'];
   $mobile_num2= $_GET['mobile_num2'];
   $email_address= $_GET['email_address'];
   $note= $_GET['note'];
   $user_type= $_GET['user_type'];




    $result=$con->query("INSERT INTO add_pop(user_type,pop,fullname,username,password,opening_bal,mobile_num1,mobile_num2,email_address,note) VALUES('$user_type','$pop_name','$fullname','$username','$password','$opening_bal','$mobile_num1','$mobile_num2','$email_address','$note')");
    //last id find 
    $selectquery="SELECT id FROM add_pop ORDER BY id DESC LIMIT 1";
    $results = $con->query($selectquery);
    $row = $results->fetch_assoc();
    $lastId= $row['id'];



    $result2=$con->query("INSERT INTO users(user_type,pop_id,fullname,username,password,mobile,email) VALUES('2','$lastId','$fullname','$username','$password','$mobile_num1','$email_address')");

   $result3= $con->query("INSERT INTO pop_transaction(pop_id,amount,action,transaction_type)VALUES('$lastId','$opening_bal','add','0')");

    if ($result & $result2 & $result3==true) {
        echo "Data Insert Successfully";
    }
$con -> close();
       
   
}

?>
