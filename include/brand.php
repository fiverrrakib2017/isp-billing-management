<?php 
include "db_connect.php";

if (isset($_GET["update"])) {
  $BrandId=$_GET["id"];
  $name=$_GET["brand"];
  $con->query("UPDATE product_brand SET name='$name' WHERE id=$BrandId");
   
}
if(isset($_GET['add'])){
  $brand_name= $_GET['brand'];

   $con->query("INSERT INTO product_brand(name) VALUES('$brand_name')");
}

if(isset($_GET['list'])){
    
  if ($brand_list = $con -> query("SELECT * FROM product_brand")) {
    while($rows= $brand_list->fetch_array())
    {
      $lstid=$rows["id"];
      $brand_name=$rows["name"];
      echo '
      <tr>
        <td>'.$lstid.'</td>
        <td>'.$brand_name.'</td>
        <td style="float:right;margin-left:5px;">
        <a class="btn btn-info" href="brand_edit.php?id='.$lstid.'"><i class="mdi mdi-border-color"></i></a>

        </td>
     '; 
    }
  }
}
  $con -> close();
?>

