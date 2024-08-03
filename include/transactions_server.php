<?php

use PhpParser\Node\Expr\Isset_;

include "db_connect.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['addTransactionData'])) {

    $user_id = $_POST['user_id'];
    $refer_no = $_POST['refer_no'];
	$details = $_POST['details'];
    $note = $_POST['note'];
    $currentDate = $_POST['currentDate'];
    $sub_ledger = $_POST['sub_ledger'];
    $quantity = $_POST['qty'];
    $value = $_POST['value'];
    $total = $_POST['total'];
    $date = $_POST['currentDate'];

    if ($allSubLedger=$con->query("SELECT * FROM legder_sub WHERE id=$sub_ledger")) {
        while ($rwos=$allSubLedger->fetch_array()) {
            $ledger_ID=$rwos['ledger_id'];
        }
    }
    if ($getMasterLdg=$con->query("SELECT * FROM ledger WHERE id=$ledger_ID")) {
        while ($rwos=$getMasterLdg->fetch_array()) {
            $mstr_ledger_id=$rwos['mstr_ledger_id'];
        }
    }

     $result = $con->query("INSERT INTO ledger_transactions(user_id,mstr_ledger_id,ledger_id,sub_ledger_id,qty,value,total,status,note,date) VALUES('$user_id','$mstr_ledger_id','$ledger_ID','$sub_ledger','$quantity','$value','$total','0','$details','$date')");

    if ($result==true) {
        echo 1;
    }else{
        echo "Error: ".$con->error;
    }
}



// Generate Report by Master Ledger

if (isset($_POST['getReport'])) {
    $mstr_ledger_id="";
    $masterLedgerId = $_POST['masterLedger'];
    $fromDate = $_POST['fromDate'];
    $endDate = $_POST['endDate'];
    $total = 0;
    $increment = 1;
    echo '<table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">';
    echo '<thead><tr><th>No</th><th>Ledger</th><th>Amount</th></tr></thead>';
    echo '<tbody>';

    if ($details = $con->query("SELECT * FROM ledger WHERE mstr_ledger_id= $masterLedgerId ")) {
        while ($rows = $details->fetch_array()) {
            $mstr_ledger_id = $rows["id"];
            $ledger_name = $rows["ledger_name"];

                    

            
            echo '<tr>
                    <td>' . $increment++ . '</td>';

                    
?>


<td>
<?php
             
// echo $ledger_name    .'<br>';
echo '<b>'.$ledger_name.'</b>' .'<br>';

                        if ($allLedger = $con->query("SELECT * FROM legder_sub WHERE ledger_id='$mstr_ledger_id'")) {
                        while ($rowss = $allLedger->fetch_array()) {
                            $id=$rowss['id'];
                            echo "&nbsp&nbsp&nbsp&nbsp&nbsp". $item_name = $rowss['item_name'] .'-';
                            


// Total Sum Qeuery would be heres
if($allTran =$con->query("SELECT SUM(total)as totalPayment FROM `ledger_transactions` WHERE `sub_ledger_id`=$id  AND `date` BETWEEN '$fromDate' AND '$endDate';")){
    while($rowpp=$allTran->fetch_array()){
        echo '<span style=float:right>'.$rowpp['totalPayment'].'</span><br>';
       
    }
}





                        }
                        
                    }
?>
</td>
<?php
                    
                   
                   echo '</tr>';

          



        }
    }

    
    // Total Amount
if($TotalLdgramt =$con->query("SELECT SUM(total)as totalldgramount FROM ledger_transactions WHERE mstr_ledger_id='$masterLedgerId' AND date BETWEEN '$fromDate' AND '$endDate';")){
    while($rowttlpp=$TotalLdgramt->fetch_array()){
        echo '<tr><td></td><td><span style=float:right>'.$rowttlpp['totalldgramount'].'</span></td></tr>';
       
    }
}
/**/
    echo '</table>';
}
if (isset($_GET['show'])) {
    $total = 0;
    $increment = 1;
    echo '<table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">';
    echo '<thead><tr><th>No</th><th>Ledger</th><th>Quantity</th><th>Value</th><th>Total</th><th>Action</th></tr></thead>';
    echo '<tbody>';

    if ($details = $con->query("SELECT * FROM ledger_transactions WHERE status=0")) {
        while ($rows = $details->fetch_array()) {
            $id = $rows["id"];
            $sub_ledger_id = $rows["sub_ledger_id"];
            if ($allLedger = $con->query("SELECT * FROM legder_sub WHERE id='$sub_ledger_id'")) {
                while ($rowss = $allLedger->fetch_array()) {
                    $item_name = $rowss['item_name'];
                }
            }
            $qty = $rows["qty"];
            $value = $rows["value"];
			$notedetails = $rows["note"];
            $total_value  = $rows["total"];
            $total += $total_value;
            echo '<tr>
            
            <td>' . $increment++ . '</td>
            <td>' . $item_name . ' </br><i>('.$notedetails.')</i></td>
            <td>' . $qty . '</td>
            <td>' . $value . '</td>
            <td>' . $total_value  . '</td>
            <td>
            <a onclick="deleteTransaction('.$id.')"  class="btn-sm btn btn-danger" ><i class="fas fa-trash"></i></a>
            </td>
            
            
            </tr>';
        }
    }
    echo '<tbody>
    
    <tr>
    <td colspan="4"></td><td>Total: ' . $total . '</td>
    <td><button type="button"  class="btn-sm btn btn-primary finishedBtn">Finished</button></td>
    </tr>
    
    </tbody>';

    echo '</table>';
}
if (isset($_GET["finishedTransaction"])) {

    $con->query("UPDATE `ledger_transactions` SET status='1' ");
    echo 1;
}
if (isset($_GET["sub_transaction_add"])) {
    $id = $_GET['id'];
    $name = $_GET['name'];
    $description = $_GET['description'];

    $con->query("INSERT INTO  sub_transaction(transaction_id,item_name,description)VALUES('$id','$name','$description')");
}



if (isset($_GET['getLedger'])) {
    if ($ledgr = $con->query("SELECT * FROM ledger")) {
        echo '<option value="">Select</option>';

        while ($rowsitm = $ledgr->fetch_array()) {
            $ldgritmsID = $rowsitm["id"];
            $ledger_name = $rowsitm["ledger_name"];

            echo '<optgroup label="' . $ledger_name . '">';


            // Sub Ledger items list
            if ($ledgrsubitm = $con->query("SELECT * FROM legder_sub WHERE ledger_id='$ldgritmsID'")) {


                while ($rowssb = $ledgrsubitm->fetch_array()) {
                    $sub_ldgrid = $rowssb["id"];
                    $ldgr_items = $rowssb["item_name"];

                    echo '<option value="' . $sub_ldgrid . '">' . $ldgr_items . '</option>';
                }
            }



            echo '</optgroup>';
        }
    }
}


if (isset($_POST['addSubLedgerData'])) {
    $ledger_id = $_POST['sub_ledger_id'];
    if($allLedger=$con->query("SELECT * FROM ledger WHERE id=$ledger_id")){
        while ($rows=$allLedger->fetch_array()) {
            $masterLedgerId=$rows['mstr_ledger_id'];
        }
    }
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];

    $result = $con->query("INSERT INTO  legder_sub(mstr_ledger_id,ledger_id,item_name,description)VALUES('$masterLedgerId','$ledger_id','$item_name','$description')");

    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
}
