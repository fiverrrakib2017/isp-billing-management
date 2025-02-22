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
  $package_name= $_GET['package'];
  $price= $_GET['price'];
  $user_type= $_GET['user_type'];
  $pool_id= $_GET['pool_id'];

  $result= $con->query("INSERT INTO radgroupcheck(pool_id,groupname,price,user_type) VALUES('$pool_id','$package_name','$price','$user_type')");
  if ($result==true) {
    echo "Package Added";
  }else{
    echo "Error";
  }
}

if(isset($_GET['get_package_data'])){
    $id = intval($_GET['id']); 
    $result = $con->query("SELECT * FROM branch_package WHERE id = $id");

    $data = [];
    while ($row = $result->fetch_assoc()) { 
        $data[] = $row;
    }

    echo json_encode($data);
    exit;
}

if(isset($_POST['update_package_data'])){
    $id = intval($_POST['id']);
    $p_price = $con->real_escape_string($_POST['p_price']);
    $s_price = $con->real_escape_string($_POST['s_price']);
    $pop_id = $con->real_escape_string($_POST['pop_id']);
   
    $con->query("UPDATE branch_package SET 
        p_price = '$p_price', 
        s_price = '$s_price', 
        pop_id = '$pop_id' 
        WHERE id = $id"); 
    echo json_encode(['success'=>true,'message'=>'Successfully Updated']);
    exit; 
}

if (isset($_POST['pop_id'])) {
  $pop_id=$_POST['pop_id'];
  $p_name=$_POST['p_name'];
  $p_price=$_POST['p_price'];
  $S_price=$_POST['s_price'];

  if($con->query("SELECT * FROM branch_package WHERE pop_id='$pop_id' AND pkg_id='$p_name' ")->num_rows>0){
    echo json_encode(['success'=>false, 'message'=>'Package Already Exists']);
    exit();
  }

  /*Package Name Retrive*/   
    if ($pkgName = $con->query("SELECT * FROM radgroupcheck WHERE id='$p_name' LIMIT 1")) {
        while ($rowspk = $pkgName->fetch_array()) {
        $packageName = $rowspk['groupname'];
        }
      }
  
   /**/
  $result= $con->query("INSERT INTO branch_package(pop_id, pkg_id, package_name, p_price, s_price) VALUES('$pop_id','$p_name','$packageName', '$p_price','$S_price')");
  if ($result==true) {
    echo json_encode(['success'=>true, 'message'=>'Package Added']);
  }else{
    echo json_encode(['success'=>false, 'message'=>'Something else']);
  }
}

if (isset($_POST['package_name_id'])) {
    $packageId= $_POST['package_name_id'];
    //$result=$con->query("");
    if ($allArea=$con->query("SELECT * FROM radgroupcheck WHERE id='$packageId' ")) {
        while ($rows=$allArea->fetch_array()) {
            echo $rows['price'];
        }
    }
 } 



?>

