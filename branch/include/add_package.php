<?php 
include "db_connect.php";



if (isset($_GET["update"])) {
  $packageId=$_GET["id"];
  $package=$_GET["package"];
  $con->query("UPDATE radgroupcheck SET groupname='$package' WHERE id=$packageId");
   
}
//delete data
if (isset($_GET['delete'])) {
    $id=$_GET['id'];
     $result=$con->query("DELETE FROM `radgroupcheck` WHERE  id='$id'");
    if ($result==true) {
        echo 1; 
    }else{
        echo 0; 
    }
}






if(isset($_GET['add'])){
  $package_name= $_GET['package_list'];
  $purchase_price= $_GET['purchase_price'];
  $sale_price= $_GET['sale_price'];
  $user_type= $_GET['user_type'];

  $result= $con->query("INSERT INTO  branch_package( pop_id , name , p_price ,sale_price) VALUES('$user_type','$package_name','$purchase_price')");
  if ($result==true) {
    echo "Package Added";
  }else{
    echo "Error";
  }
}



if (isset($_POST['get_package_list'])) {
    $packageId= $_POST['get_package_list'];
    //$result=$con->query("");
    if ($allArea=$con->query("SELECT * FROM `radgroupcheck` WHERE id='$packageId' ")) {
        while ($rowsssss=$allArea->fetch_array()) {
            $popAreaName=$rowsssss['price'];
            echo $popAreaName;
        }
    }
 } 


?>

