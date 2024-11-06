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



/* Generate Report by Master Ledger*/
if (isset($_POST['getReport'])) {
    $masterLedgerId = $_POST['masterLedger'];
    $fromDate = $_POST['fromDate'];
    $endDate = $_POST['endDate'];
    $increment = 1;

    echo '<button type="button" onclick="printTable()" class="btn btn-primary"><i class="fas fa-print"></i></button> <br><br>';
    echo '
    <table id="reportTable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">';
    echo '<thead><tr><th>No</th><th class="text-center">Accounts Titles And Explanations</th><th>Amount</th></tr></thead>';
    echo '<tbody>';

    $ledgerQuery = "SELECT DISTINCT ledger_id FROM ledger_transactions 
                    WHERE mstr_ledger_id = $masterLedgerId 
                    AND date BETWEEN '$fromDate' AND '$endDate'";
    $ledgerResult = $con->query($ledgerQuery);

    if ($ledgerResult && $ledgerResult->num_rows > 0) {
        while ($ledgerRow = $ledgerResult->fetch_assoc()) {
            $ledger_id = $ledgerRow["ledger_id"];

            /* Fetch ledger name from the ledger table*/
            $ledgerNameQuery = "SELECT ledger_name FROM ledger WHERE id = $ledger_id";
            $ledgerNameResult = $con->query($ledgerNameQuery);
            $ledger_name = $ledgerNameResult->fetch_assoc()['ledger_name'] ?? 'N/A';

            echo '<tr>';
            echo '<td>' . $increment++ . '</td>';
            echo '<td><b>' . $ledger_name . ' </b><br>';

            $ledgerTotal = 0;

            /* Fetch sub-ledgers and their amounts from transactions*/
            $subLedgerQuery = "SELECT sub_ledger_id, 
                                      SUM(total) AS sub_total, 
                                      GROUP_CONCAT(note SEPARATOR ', ') AS notes,
                                      (SELECT item_name FROM legder_sub WHERE id = sub_ledger_id) AS sub_ledger_name 
                               FROM ledger_transactions 
                               WHERE ledger_id = $ledger_id 
                               AND date BETWEEN '$fromDate' AND '$endDate' 
                               GROUP BY sub_ledger_id";
            $subLedgerResult = $con->query($subLedgerQuery);

            if ($subLedgerResult && $subLedgerResult->num_rows > 0) {
                while ($subLedgerRow = $subLedgerResult->fetch_assoc()) {
                    $sub_ledger_name = $subLedgerRow['sub_ledger_name'] ?? 'N/A';
                    $sub_total = $subLedgerRow['sub_total'] ?? 0;
                    $notes = $subLedgerRow['notes'] ?? '';

                    /* Check if the date is today to show notes*/
                    if (date('Y-m-d') === date('Y-m-d', strtotime($fromDate))) {
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $sub_ledger_name . ' - <span style="float:right">' . round($sub_total, 2) . '</span> ' . ($notes ? '(' . $notes . ')' : '') . '<br>';
                    } else {
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $sub_ledger_name . ' - <span style="float:right">' . round($sub_total, 2) . '</span><br>';
                    }

                    $ledgerTotal += $sub_total;
                }
            }

            echo '</td>';
            echo '<td>' . round($ledgerTotal, 2) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="3">No records found.</td></tr>';
    }

    $grandTotalQuery = "SELECT SUM(total) AS grandTotal FROM ledger_transactions 
                        WHERE mstr_ledger_id = $masterLedgerId 
                        AND date BETWEEN '$fromDate' AND '$endDate'";
    $grandTotalResult = $con->query($grandTotalQuery);
    $grandTotal = $grandTotalResult->fetch_assoc()['grandTotal'] ?? 0;

    echo '<tr><td colspan="2" style="text-align: right;"><b>Total:</b></td>';
    echo '<td><b>' . round($grandTotal, 2) . '</b></td></tr>';

    echo '</tbody></table>';

    $con->close();
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


?>



<!-- <script type="text/javascript">
function printTable() {
    var printContents = document.getElementById("reportTable").outerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script> -->