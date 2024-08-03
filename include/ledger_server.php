<?php

include "db_connect.php";

if(isset($_GET['list'])){
	
	if ($ledgr = $con-> query("SELECT * FROM ledger")) {
  
  
  while($rows= $ledgr->fetch_assoc()){
    $id=$rows["id"];
	  $mstr_ledger_id = $rows["mstr_ledger_id"];
	  $ledger_name = $rows["ledger_name"];
    $masterLedgerName="";
    if ($mstr_ledger_id==1) {
       $masterLedgerName="Income";
    }else if($mstr_ledger_id==2){
       $masterLedgerName="Expense";
    }
    else if($mstr_ledger_id==3){
       $masterLedgerName="Asset";
    }
    else if($mstr_ledger_id==4){
       $masterLedgerName="Liabilities";
    }
	  
	  echo '
	 <tr>
	   <td>'.$id.'</td>
     <td>'.$ledger_name.'</td>
     <td>'.$masterLedgerName.'</td>
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


if(isset($_POST["addLedgerData"])){
     $masterLedger=$_POST["masterLedger"];
    $ledgerName=$_POST["ledgerName"];

   $con->query("INSERT INTO ledger(mstr_ledger_id,ledger_name)VALUES('$masterLedger','$ledgerName')");
   echo 1;
    
}




?>