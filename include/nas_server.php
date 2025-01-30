<?php
include "db_connect.php";
require('routeros/routeros_api.class.php');
$API = new RouterosAPI();

if(isset($_GET['list'])){


    
if ($nas = $con -> query("SELECT * FROM nas")) {
  
  
  while($rows= $nas->fetch_array())
  {
			  $nasusername = $rows["nasname"];
			  $api_user = $rows["api_user"];
			  $api_password = $rows["api_password"];
			
			
			
			
			if ($API->connect($nasusername, $api_user, $api_password)) {


			$items = $API->comm("/system/resource/print");
			$uptime = "Uptime : ".($items['0']['uptime']);
			$cpuload = "CPU : ".($items['0']['cpu-load'])." %";
			$API->disconnect();

			}
	 echo '
	 <tr>
     <td>'.$rows["shortname"].'</br>'.$uptime.'</br>'.$cpuload.'</td>
     <td>'.$rows["nasname"].'</td>
     <td>'.$rows["secret"].'</td>
     <td>'.$rows["description"].'</td>
     <td>'.$rows["shortname"].'</td>
     <td>'.$rows["shortname"].'</td>
     <td><button class="btn btn-warning" type="button"><span class="mdi mdi mdi-border-color mdi-18px"></span></button></td>
     </tr>'; 
  }
  // Free result set
  //$result -> free_result();
}



}




// if(isset($_GET['add']))
// 	{
	 
// 		$nasname = $_GET['ip'];
// 		$shortname = $_GET['name'];
// 		$type = "otherss";
//     $ports = $_GET['ports'];
//     $secret = $_GET['secret'];
//     //$server = $_GET['server'];
//    // $community = $_GET['community'];
//     //$description = $_GET['description'];
//     $api_user = $_GET['api_user'];
//     $api_pass = $_GET['api_pass'];
	
// 		$con -> query("INSERT INTO nas(nasname,shortname,type,ports,secret,api_user,api_pass) VALUES('$nasname','$shortname','$type','$ports','$secret','$api_user','$api_pass')");
// 		$con -> close();
	 
// 	}

/*Add Nas Router Script*/
if (isset($_GET['add_data']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
	require 'functions.php';
    /* validate inputs*/
    $nas_name = trim($_POST['nas_name']);
    $short_name = trim($_POST['short_name']);
    $type = trim($_POST['type']);
    $port = trim($_POST['port']);
    $secret = trim($_POST['secret']);
    $api_user = trim($_POST['api_user']);
    $api_pass = trim($_POST['api_pass']);
    $api_ip = trim($_POST['api_ip']);
    $server = trim($_POST['server'])?? '';
    $location = trim($_POST['location']);
    $community = trim($_POST['community'])?? '';
    $description = trim($_POST['description']);

    /* Validate pop nas_name */
  __validate_input($nas_name,'NAS name');
  /* Validate short_name */
  __validate_input($short_name,'Short Name');
  /* Validate port */
  __validate_input($port,'Port');
  /* Validate secret */
  __validate_input($secret,'Secret');
  /* Validate api_user */
  __validate_input($api_user,'Api User');
  /* Validate Api Pass */
  __validate_input($api_pass,'Api Pass');
  /* Validate  location */
  __validate_input($location,'Location');

   $result= $con -> query("INSERT INTO nas(`nasname`, `shortname`, `type`, `ports`, `secret`, `api_user`, `api_password`, `api_ip`, `server`, `location`, `community`, `description`) VALUES('$nas_name', '$short_name', '$type', '$port', '$secret', '$api_user', '$api_pass', '$api_ip', '$server', '$location', '$community', '$description')");
		$con -> close();

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Added successfully!',
        ]);
        exit;
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to add POP/Branch!',
        ]);
        exit;
    }
    exit; 
}


if (isset($_GET['get_nas_data']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
  $_id = intval($_GET['id']);

  /* Prepare the SQL statement*/
  $stmt = $con->prepare("SELECT * FROM nas WHERE id = ?");
  $stmt->bind_param("i", $_id);

  /*Execute the statement*/ 
  if ($stmt->execute()) {
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
          $data = $result->fetch_assoc();
          $response = array("success" => true, "data" => $data);
      } else {
          $response = array("success" => false, "message" => "No record found!");
      }
  } else {
      $response = array("success" => false, "message" => "Error executing query: " . $stmt->error);
  }

  /*Close the statement*/
  $stmt->close();
  $con->close();

  /* Return the response as JSON*/
  echo json_encode($response);
  exit;
}


/*Update NAS Router Script*/
if (isset($_GET['update_data']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
	require 'functions.php';
  $id = trim($_POST['id']);
  $nas_name = trim($_POST['nas_name']);
  $short_name = trim($_POST['short_name']);
  $type = trim($_POST['type']);
  $port = trim($_POST['port']);
  $secret = trim($_POST['secret']);
  $api_user = trim($_POST['api_user']);
  $api_pass = trim($_POST['api_pass']);
  $api_ip = trim($_POST['api_ip']);
  $server = trim($_POST['server'])?? '';
  $location = trim($_POST['location']);
  $community = trim($_POST['community'])?? '';
  $description = trim($_POST['description']);

  /* Validate pop nas_name */
  __validate_input($nas_name,'NAS name');
  /* Validate short_name */
  __validate_input($short_name,'Short Name');
  /* Validate port */
  __validate_input($port,'Port');
  /* Validate secret */
  __validate_input($secret,'Secret');
  /* Validate api_user */
  __validate_input($api_user,'Api User');
  /* Validate Api Pass */
  __validate_input($api_pass,'Api Pass');
  /* Validate  location */
  __validate_input($location,'Location');

	/* Update query */
  $result= $con ->query("UPDATE nas SET `nasname`='$nas_name', `shortname`='$short_name', `type`='$type', `ports`='$port', `secret`='$secret', `api_user`='$api_user', `api_password`='$api_pass', `api_ip`='$api_ip', `server`='$server', `location`='$location', `community`='$community', `description`='$description' WHERE `id`='$id'");
  if($result){
    echo json_encode([
        'success' => true,
        'message' => 'Updated successfully!',
    ]);
    exit;
  }else{
    echo json_encode([
        'success' => false,
        'message' => 'Failed to update!',
    ]);
    exit;
  }
  $con -> close();
  exit; 

}

function __validate_input($value,$field){
  if (empty($value)) {
    echo json_encode([
        'success' => false,
        'message' => ''.$field.' is required!',
    ]);
    exit;
  }
}
