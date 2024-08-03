<?php 
include "db_connect.php";

   if (isset($_POST['addPopRecharge'])) {
       $id=$_POST['id'];
       $amount=$_POST['amount'];
       $action=$_POST['action'];
       $tra_type=$_POST['trasaction'];
       $recharge_by=$_POST['recharge_by'];
       if($action=="Return"){
        $amount="-".$amount;
       }
       date_default_timezone_set('Asia/Dhaka');
       $todayDate=date('H:i A, d-M-Y');

       // Credit sale
       if($tra_type==1){
        $result=$con->query("INSERT INTO pop_transaction(pop_id,amount,paid_amount,action,transaction_type,recharge_by,date)VALUES('$id','$amount','$amount','$action','$tra_type','$recharge_by','$todayDate')"); 
       }else if($action=="Return"){
        $result= $con->query("INSERT INTO pop_transaction(pop_id,amount,paid_amount,action,transaction_type,recharge_by,date)VALUES('$id','$amount','0','$action','$tra_type','$recharge_by','$todayDate')");
       }
       else{
          $result= $con->query("INSERT INTO pop_transaction(pop_id,amount,paid_amount,action,transaction_type,recharge_by,date)VALUES('$id','$amount','0','$action','$tra_type','$recharge_by','$todayDate')");
       }
      

      if ($result==true) {
        echo 1;
      }else{
        echo 0;
      }
   }
   //add pop payment received 
   if (isset($_POST['addPayment'])) {
       $id=$_POST['id'];
       $amount=$_POST['amount'];
       $tra_type=$_POST['trasaction'];
       $addRemarks=$_POST['addRemarks'];
       $recharge_by=$_POST['recharge_by'];
       if($action=="Return"){
        $amount="-".$amount;
       }
       date_default_timezone_set('Asia/Dhaka');
       $todayDate=date('H:i A, d-M-Y');
      $result= $con->query("INSERT INTO pop_transaction(pop_id,amount,paid_amount,action,transaction_type,remarks,recharge_by,date)VALUES('$id','0','$amount','paid','5','$addRemarks','$recharge_by','$todayDate')");
      if ($result==true) {
        echo 1;
      }else{
        echo 0;
      }
   }

 ?>