<?php 

include "db_connect.php";
if (isset($_GET["update"])) {
  $packageId=$_GET["id"];
  $days=$_GET["days"];
  $con->query("UPDATE customer_expires SET days='$days' WHERE id=$packageId");
   
}
//expire date delete function 
if (isset($_GET['delete'])) {
    $id=$_GET['id'];
     $result=$con->query("DELETE FROM `customer_expires` WHERE  id='$id'");
    if ($result==true) {
        echo 1; 
    }else{
        echo 0; 
    }
}


if (isset($_GET['add'])) {
	$expired=$_GET["expired"];
	$con->query("INSERT INTO customer_expires(days)VALUES('$expired')");
	$con->close();
  
}

if(isset($_GET['list'])){
    
  if ($exp = $con -> query("SELECT * FROM customer_expires")) {
    while($rows= $exp->fetch_array())
    {
      $lstid=$rows["id"];
      $expired_date=$rows["days"];
      echo '
      <tr>
        <td>'.$lstid.'</td>
        <td>'.$expired_date.'</td>
        <td class="text-right">
        <a class="btn btn-info" href="expired_edit.php?id='.$lstid.'"><i class="mdi mdi-border-color"></i></a>

        </td>
        </tr>
     '; 
    }
  }
}
  $con -> close();


 ?>