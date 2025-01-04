<?php 
include "db_connect.php";



if (isset($_GET["update"])) {
  $categoryId=$_GET["id"];
  $name=$_GET["category"];
  $con->query("UPDATE product_cat SET name='$name' WHERE id=$categoryId");
   
}


if(isset($_GET['add'])){
  $category_name= $_GET['category'];

   $con->query("INSERT INTO product_cat(name) VALUES('$category_name')");
}

if(isset($_GET['list'])){
    
  if ($category_list = $con -> query("SELECT * FROM product_cat")) {
    while($rows= $category_list->fetch_array())
    {
      $lstid=$rows["id"];
      $category_name=$rows["name"];
      echo '
      <tr>
        <td>'.$lstid.'</td>
        <td>'.$category_name.'</td>
        <td style="float:right;margin-left:5px;">
        <a class="btn btn-info" href="category_edit.php?id='.$lstid.'"><i class="mdi mdi-border-color"></i></a>

        </td>
        </tr>
     '; 
    }
  }
}
  $con -> close();
?>

