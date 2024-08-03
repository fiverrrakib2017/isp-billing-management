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
  ?>