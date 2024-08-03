<?php
include "db_connect.php";

//update data

if (isset($_GET["update"])) {
  $poolId=$_GET["id"];
  $poolname=$_GET["pool-name"];
  $strtIP=$_GET["start-ip"];
  $con->query("UPDATE pool SET name='$poolname',ip_block='$strtIP' WHERE id=$poolId");
   
}








if(isset($_GET['list']))
{
	 
	
	if ($pool = $con -> query("SELECT * FROM pool")) {
  
  
  while($rows= $pool->fetch_array())
  {
	  $lstid = $rows["id"];
	  $poolname = $rows["name"];
	  $strtIP = $rows["ip_block"];
	  
	  
	  echo '
	 <tr>
	 <td>'.$lstid.'</td>
     <td>'.$poolname.'</td>
     <td>'.$strtIP.'</td>
     
     <td class="text-right">
        <a class="btn btn-primary " href="pool_edit.php?id='.$lstid.'"><i class="fas fa-edit"></i></a>

        <button type="button" class="btn btn-danger deleteId" data-id='.$lstid.'><i class="fas fa-trash"></i></button>


        </td>
     </tr>
	 '; 
	  
	  
	 
  }
}
}

if(isset($_GET['add']))
	{
	 
		 $poolname = $_GET['pool-name'];
		 $pool_start_ip = $_GET['start-ip'];
	   
       //INSERT INTO `pool` (`id`, `radgrp_id`, `name`, `start_ip`, `end_ip`) VALUES (NULL, '0', 'rakib', '172.16.11.1', '172.16.10.254');
		//$result=$con->query("INSERT INTO pool(name,start_ip,end_ip) VALUES('$poolname',0,'$pool_start_ip','$pool_end_ip_ip')");
        $result=$con->query("INSERT INTO pool (radgrp_id,name,ip_block)VALUES(0,'$poolname','$pool_start_ip')");
		if ($result==true) {
            echo 1; 
        }else{
            echo 0; 
        }
	 
	}

if (isset($_GET['delete'])) {
    $id=$_GET['id'];
     $result=$con->query("DELETE FROM `pool` WHERE  id='$id'");
    if ($result==true) {
        echo 1; 
    }else{
        echo 0; 
    }
}







?>