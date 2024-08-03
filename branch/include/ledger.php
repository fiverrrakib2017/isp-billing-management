<?php

include "db_connect.php";

if(isset($_GET['list'])){
	
	if ($ledgr = $con-> query("SELECT * FROM ledger")) {
  
  
  while($rows= $ledgr->fetch_assoc()){
    $id=$rows["id"];
	  $ledger = $rows["mstr_ledger"];
	  $name = $rows["ledger_name"];
	  
	  echo '
	 <tr>
	   <td>'.$id.'</td>
     <td>'.$name.'</td>
     <td>'.$ledger.'</td>
     <td style="text-align:right;">
     <a class="btn btn-success " href="ledger_view.php?id='.$id.'"><i class="fas fa-eye"></i></a>
     <a class="btn btn-danger" href="include/ledger_delete.php?id='.$id.'"><i class="fas fa-trash"></i></a>
     </td>
     </tr>
	 '; 
	}
  }
  //$con->close();
}


if(isset($_GET["add"])){
    $ledger=$_GET["ledger"];
    $name=$_GET["name"];

    $con->query("INSERT INTO ledger(mstr_ledger,ledger_name)VALUES( '$ledger','$name')");
    $con->close();
}




?>