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




if(isset($_GET['add']))
	{
	 
		$nasname = $_GET['ip'];
		$shortname = $_GET['name'];
		$type = "otherss";
    $ports = $_GET['ports'];
    $secret = $_GET['secret'];
    //$server = $_GET['server'];
   // $community = $_GET['community'];
    //$description = $_GET['description'];
    $api_user = $_GET['api_user'];
    $api_pass = $_GET['api_pass'];
	
		$con -> query("INSERT INTO nas(nasname,shortname,type,ports,secret,api_user,api_pass) VALUES('$nasname','$shortname','$type','$ports','$secret','$api_user','$api_pass')");
		$con -> close();
	 
	}

/*Add POP/Branch Script*/
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

    /* Validate pop name */
    if (empty($nas_name)) {
        echo json_encode([
            'success' => false,
            'message' => 'NAS name is required!',
        ]);
        exit;
    }
    /* Validate short_name */
    if (empty($short_name)) {
        echo json_encode([
            'success' => false,
            'message' => 'Short Name is required!',
        ]);
        exit;
    }
    /* Validate port */
    if (empty($port)) {
        echo json_encode([
            'success' => false,
            'message' => 'Port is required!',
        ]);
        exit;
    }
    /* Validate secret */
    if (empty($secret)) {
        echo json_encode([
            'success' => false,
            'message' => 'Secret is required!',
        ]);
        exit;
    }
    /* Validate api_user */
    if (empty($api_user)) {
        echo json_encode([
            'success' => false,
            'message' => 'Api User is required!',
        ]);
        exit;
    }
    /* Validate Api Pass */
    if (empty($api_pass)) {
        echo json_encode([
            'success' => false,
            'message' => 'Api Pass is required!',
        ]);
        exit;
    }
    /* Validate  location */
    if (empty($location)) {
        echo json_encode([
            'success' => false,
            'message' => 'Location is required!',
        ]);
        exit;
    }
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


  ?>
