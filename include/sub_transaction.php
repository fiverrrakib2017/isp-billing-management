<?php 

include "db_connect.php";


if (isset($_GET["add"])) {
    $id=$_GET['id'];
    $name=$_GET['name'];
    $description=$_GET['description'];

    $con->query("INSERT INTO  sub_transaction(transaction_id,item_name,description)VALUES('$id','$name','$description')");
}



 ?>