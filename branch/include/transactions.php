<?php
include "db_connect.php";
$a=1;


if(isset($_GET['add']))
   {
    
      $userId= $_GET['id'];
      $transaction_type= $_GET['transaction_type'];
      $client= $_GET['client'];
      $refer_no= $_GET['refer_no'];
      $description= $_GET['description'];
      $date= $_GET['date'];
      $ledger= $_GET['ledger'];
      $items= $_GET['item'];
      $quantity= $_GET['qty'];
      $value= $_GET['value'];
      $total= $_GET['total'];
   
      $sql=$con -> query("INSERT INTO transaction(user_id,client_id,date) VALUES('$userId','$client','$date')");

      $invcID = $con->insert_id;
      $result=$con->query("INSERT INTO transaction_details(invoice_id,ledger,items,qty,value,total)VALUES('$invcID','$ledger','$items','$quantity','$value','$total')");
   }


if (isset($_GET["sub_transaction_add"])) {
    $id=$_GET['id'];
    $name=$_GET['name'];
    $description=$_GET['description'];

    $con->query("INSERT INTO  sub_transaction(transaction_id,item_name,description)VALUES('$id','$name','$description')");
}


?>