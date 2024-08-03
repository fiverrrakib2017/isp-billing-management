<?php 
include "db_connect.php";

//product data update

if (isset($_GET["update"])) {
  $id=$_GET["id"];
   $name= $_GET['pdname'];
   $desc=$_GET['desc'];
   $category=$_GET['category'];
   $brand=$_GET['brand'];
   $purchase_ac=$_GET['purchase_ac'];
   $sales_ac=$_GET['sales_ac'];
   $p_price=$_GET['purchase_price'];
   $s_price=$_GET['sale_price'];
   $store=$_GET['store'];


    $con->query("UPDATE products SET name='$name', description='$desc',category='$category',brand='$brand',purchase_ac='$purchase_ac',sales_ac='$sales_ac',purchase_price='$p_price',sale_price='$s_price',store='$store' WHERE id=$id      ");
   
}


//product data insert
if(isset($_GET['add'])){
  $name= $_GET['pdname'];
   $desc=$_GET['desc'];
   $category=$_GET['category'];
   $brand=$_GET['brand'];
   $purchase_ac=$_GET['purchase_ac'];
   $sales_ac=$_GET['sales_ac'];
   $p_price=$_GET['purchase_price'];
   $s_price=$_GET['sale_price'];
   $store=$_GET['store'];

   $con->query("INSERT INTO products(name,description,category,brand,purchase_ac,sales_ac,purchase_price,sale_price,store) VALUES('$name','$desc','$category','$brand','$purchase_ac','$sales_ac','$p_price','$s_price','$store')");
}
//product data display
if(isset($_GET['list'])){
    
  if ($product = $con -> query("SELECT * FROM products")) {
    while($rows= $product->fetch_array())
    {
      $lstid=$rows["id"];
      $pd_name=$rows["name"];
      $desc = $rows["description"];
      $category = $rows["category"];
      $brand=$rows["brand"];
      $p_ac = $rows["purchase_ac"];
      $sales_ac = $rows["sales_ac"];
      $p_price = $rows["purchase_price"];
      $s_price = $rows["sale_price"];
      $store = $rows["store"];
      echo '
      <tr>
        <td>'.$lstid.'</td>
        <td><a href="product_profile.php?id='.$lstid.'">'.$pd_name.'</a></td>
        <td>'.$desc.'</td>
        <td>'.$category.'</td>
          <td>'.$brand.'</td>
             <td>'.$p_ac.'</td>
           
          <td>'.$sales_ac.'</td>
       <td>'.$p_price.'</td>
       <td>'.$s_price.'</td>
       <td>'.$store.'</td>
       <td >
        <a class="btn btn-info" href="product_profile_edit.php?id='.$lstid.'"><i class="mdi mdi-border-color"></i></a>
        <a class="btn btn-success" href="product_profile.php?id='.$lstid.'"><i class="mdi mdi-eye"></i>
        </a>

        </td>
        </tr>
     '; 
    }
  }
}
  $con -> close();
?>

