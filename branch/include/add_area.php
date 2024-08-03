<?php 
include "db_connect.php";





 if (isset($_GET["update"])) {
  $areaId=$_GET["id"];
  $area_name=$_GET["area"];
  $con->query("UPDATE area_list SET name='$area_name' WHERE id=$areaId");
   
}





if(isset($_POST['addArea'])){
  $area_name= $_POST['name'];
  $pop_name= $_POST['pop_id'];
  $user_type= $_POST['user_type'];

  $result= $con->query("INSERT INTO area_list(name,pop_id,user_type) VALUES('$area_name','$pop_name','$user_type')");
  if ($result==true) {
    echo 1;
  }else{
    echo 0;
  }
}

if(isset($_GET['list'])){
    
  if ($area_list = $con -> query("SELECT * FROM area_list")) {
    while($rows= $area_list->fetch_array())
    {
      $lstid=$rows["id"];
      $area_name=$rows["name"];
   echo  '
      <tr>
        <td>'.$lstid.'</td>
        <td>'.$area_name.'</td>
        <td style="text-align:right;">
        <a class="btn btn-info" href="area_edit.php?id='.$lstid.'"><i class="fas fa-edit"></i></a>
        <a class="btn btn-success" href="view_area.php?id='.$lstid.'"><i class="fas fa-eye"></i>
        </a>
        <a id="deleteId" href="area_delete.php?id='.$lstid.'"  value="" class="btn btn-danger" data-id='.$lstid.'><i class="fas fa-trash"></i></a>
        </td></tr>
     '; 
    }
  }
}



if (isset($_GET['delete'])) {
    $id=$_GET['id'];
     $result=$con->query("DELETE FROM `area_list` WHERE  id='$id'");
    if ($result==true) {
        echo 1; 
    }else{
        echo 0; 
    }
}





?>