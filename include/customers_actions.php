<?php
session_start();
include "db_connect.php";
include("security_token.php");
include("users_right.php");
if (isset($_POST["process"]) && $_POST["process"] == 'print') {
    if ($_POST['action'] == 3) {
        $pop = $_POST['pop'];
        $area = $_POST['area'];
        $customers = [];

        if ($result = $con->query("SELECT * FROM customers WHERE pop='$pop' AND area='$area'")) {
            while ($row = $result->fetch_assoc()) {
                $customers[] = $row;
            }
        }

        echo json_encode($customers);
    }
}

//////////////////////////////////////////////////
//Find the customer and Recharge set expire date//
//////////////////////////////////////////////////
/*
if ($cstmr = $con->query("SELECT * FROM customers WHERE id='$customer_id'")) {

      while ($rows = $cstmr->fetch_array()) {
        $customer_id = $rows["id"];
        $packageId = $rows["package"];
        $package_name = $rows["package_name"];
        $package_price = $rows["price"];
        $customer_POP = $rows["pop"];
        echo $username = $rows["username"];
        $expiredDate = $rows["expiredate"];
      }
    }

*/
?>