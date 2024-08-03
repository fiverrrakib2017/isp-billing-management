<?php 
include "db_connect.php";
// if (isset($_GET['add']) {
//     $id=$_GET['id'];
//     $amount=$_GET['amount'];
//     $action=$_GET['action'];
//    $tra_type=$_GET['tra_type'];

//   $result=$con->query("INSERT INTO pop_transaction(pop_id, amount, action,transaction_type)VALUES('$id','$amount','$action','$tra_type')");
//   if ($result=true) {
//     echo "<script>alert('Success!!');</script>";
//   }else{
//     echo "<script>alert('Error!!');</script>";
//   }
// }

   if (isset($_GET['add'])) {
       $id=$_GET['id'];
       $amount=$_GET['amount'];
       $action=$_GET['action'];
       $tra_type=$_GET['tra_type'];

       if($action=="return"){
        $amount="-".$amount;
       }
      $result= $con->query("INSERT INTO pop_transaction(pop_id,amount,action,transaction_type)VALUES('$id','$amount','$action','$tra_type')");
      if ($result==true) {
        echo "<script>alert('Success');</script>";
      }else{
        echo "<script>alert('Error');</script>";
      }
   }

 ?>