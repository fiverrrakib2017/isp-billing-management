<?php 
include "db_connect.php";


 if (isset($_GET["update"])) {
  $popId=$_GET["id"];
  $pop_name=$_GET["pop"];
  $update_res=$con->query("UPDATE add_pop SET pop='$pop_name' WHERE id=$popId");
  if ($update_res==true) {
    echo  "Success!!";
  }else{
   echo  "Error!!!";
  }
   
} 

if(isset($_GET['list'])){
    $popttlusr=0;
  if ($pop_list = $con -> query("SELECT * FROM add_pop")) {
    while($rows= $pop_list->fetch_array())
    {
      $lstid=$rows["id"];
      $pop_name=$rows["pop"];
	  
	  if ($pop_usr = $con -> query("SELECT * FROM customers WHERE pop='$pop_name'")) {
		$popttlusr = $pop_usr->num_rows;
	  }
	  
      echo '
      <tr>
        <td>'.$lstid.'</td>
        <td>'.$pop_name.'</td>
		<td>'.$popttlusr.'</td>
        <td  class="text-right">
        <a class="btn btn-info"  href="pop_edit.php?id='.$lstid.'"><i class="mdi mdi-border-color"></i></a>

        
        <button class="btn btn-primary btn-delete" data-id='.$lstid.' style="cursor:pointer; color:white;"><i class="mdi mdi-delete"></i></button>

        <a class="btn btn-success" href="view_pop.php?id='.$lstid.'"><i class="mdi mdi-eye"></i></a>
        </td>
     '; 
    }
  }
}
  $con -> close();
?>

