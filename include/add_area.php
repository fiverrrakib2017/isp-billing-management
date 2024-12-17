<?php 
include "db_connect.php";

if(isset($_GET['add_area_for_google_map'])){
  $area_name= $_POST['area'];
  $pop_id= $_POST['pop_id'];
  $lat= $_POST['lat'];
  $lng= $_POST['lng'];
  $bar= 'bar';
  //print_r($_POST);exit; 
   $con->query("INSERT INTO google_map( `name`, `address`, `lat`, `lng`, `type`) VALUES('$area_name','Dfault Address','$lat','$lng','$bar')");
  echo 1; 
}

if(isset($_GET['get_locations_for_google_map'])){

  $sql = "SELECT name, lat, lng FROM google_map";
  $result = $con->query($sql);

  $locations = [];
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $locations[] = $row;
      }
  }
  echo json_encode($locations);
  exit; 
}

if(isset($_GET['add_area_house'])) {
  $area_id= $_POST['area_id'];
  $house_no= $_POST['house_no'];
  $lat= $_POST['lat']??'';
  $lng= $_POST['lng']??'';
  $note= $_POST['note']?? '';
  $pop_id='';
  /*Fetch pop_id from area_list table*/ 
  $result = $con->query("SELECT pop_id FROM area_list WHERE id='$area_id'");
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $pop_id = $row['pop_id'];
    }
   $con->query("INSERT INTO area_house(`pop_id`, `area_id`, `house_no`, `lat`, `lng`, `Note`) VALUES('$pop_id','$area_id','$house_no','$lat','$lng','$note')");
  echo 1; 
  exit; 
}
if(isset($_GET['load_house_no'])) {
    $result = $con->query("SELECT * FROM area_house");
    $response = '';
    while ($row = $result->fetch_assoc()) {
      $response .= '<option value="' . htmlspecialchars($row['id']) . '">' 
      . htmlspecialchars($row['house_no']) . '</option>';
    }
  echo $response;
  exit;
}




if (isset($_GET["update"])) {
  $areaId = $_GET["id"];
  $area_name = $_GET["area"];
  $billing_date = $_GET["billing_date"];

  /* GET Customers for updating their Billing Date area ID wise */
  $get_customer = $con->query("SELECT `id`, `expiredate` FROM customers WHERE area=$areaId");
  
  while ($customer = $get_customer->fetch_assoc()) {
      $customer_id = $customer["id"];
      $expiredate = $customer["expiredate"]; 
      
      $year = "";
      $month = "";
      for ($i = 0; $i < 4; $i++) {
          $year .= $expiredate[$i]; 
      }
      for ($i = 5; $i < 7; $i++) {
          $month .= $expiredate[$i]; 
      }      
      $billing_date = (strlen($billing_date) === 1) ? "0" . $billing_date : $billing_date; 
      $newexpDate = $year . "-" . $month . "-" . $billing_date;

      /*Update Customer Expire Date*/
      $con->query("UPDATE customers SET expiredate='$newexpDate' WHERE id=$customer_id");
  }

  /* Update area_list table */
  $con->query("UPDATE area_list SET name='$area_name', billing_date='$billing_date' WHERE id=$areaId");
}






if(isset($_GET['add'])){
  $area_name= $_GET['area'];
  $pop_name= $_GET['pop_id'];
  $billing_date= $_GET['billing_date'];
  $user_type= $_GET['user_type'];

  $result= $con->query("INSERT INTO area_list(name,pop_id,billing_date,user_type) VALUES('$area_name','$pop_name','$billing_date','$user_type')");
  if ($result) {
    echo "Area Added Successfully";
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