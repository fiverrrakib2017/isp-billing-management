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

  if(isset($_POST['pop_id'])){
    $popID = $_POST['pop_id'];
    
    // Fetch areas based on pop_id
    $query = "SELECT * FROM area_list WHERE pop_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $popID);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        echo '<option>---Select---</option>';
        while($row = $result->fetch_assoc()){
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    } else {
        echo '<option>No areas found</option>';
    }

    $stmt->close();
    $con->close();
}
 
?>

