<?php
include "db_connect.php";
include 'Service/Purchase_invoice.php';
session_start();

if (isset($_GET['fetch_invoice']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    /* Fetch data with filtering*/
    $start_date = $_GET['start_date'] ?? '';
    $end_date = $_GET['end_date'] ?? '';

    $query = "SELECT * FROM purchase WHERE 1";

    /* Add date range filter if dates are provided*/
    if (!empty($start_date) && !empty($end_date)) {
        $query .= " AND date BETWEEN '$start_date' AND '$end_date'";
    }
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $rows['id'] . "</td>";
            echo "<td>";

            $client_id = $rows['client_id'];
            $allCustomerData = $con->query("SELECT * FROM suppliers WHERE id=$client_id");
            while ($client_loop = $allCustomerData->fetch_array()) {
                echo '<a href="supplier_profile.php?clid=' . $client_id . '" >' . $client_loop['fullname'] . '</a>';
            }

            echo "</td>";
            echo "<td>" . $rows['sub_total'] . "</td>";
            echo "<td>" . $rows['discount'] . "</td>";
            echo "<td>" . $rows['total_due'] . "</td>";
            echo "<td>" . $rows['grand_total'] . "</td>";
            $status_badge = ($rows['status'] == '1') ? '<span class="badge bg-success">Completed</span>' : '<span class="badge bg-danger">Draft Invoice</span>';
            echo "<td>" . $status_badge . "</td>";
            echo "<td>";

            $date = $rows['date'];
            $formatted_date = date("d F Y", strtotime($date));
            echo $formatted_date;

            echo "</td>";

            echo "<td>" . (!empty($rows['created_at']) ? date("d F Y", strtotime($rows['created_at'])) : $rows['created_at']) . "</td>";


            echo "<td style='margin-right: 5px;'>";

            echo '<a class="btn-sm btn btn-primary" style="margin-right: 5px;" href="purchase_invoice_edit.php?id=' . $rows['id'] . '"><i class="fas fa-edit"></i></a>';
            echo '<a class="btn-sm btn btn-success" style="margin-right: 5px;" href="invoice/purchase_inv_view.php?clid=' . $rows['id'] . '"><i class="fas fa-eye"></i></a>';
            echo '<button type="button" name="delete_button" data-id="' . $rows['id'] . '" class="btn-sm btn btn-danger" style="margin-right: 5px;"><i class="fas fa-trash"></i></button>';
            
            // if ($rows['total_due'] > 0 && $rows['status'] == '1') {
            //     echo '<button type="button" name="due_paid_button" data-id="' . $rows['id'] . '" class="btn-sm btn btn-info" style="margin-right: 5px;">  <i class="fas fa-money-bill-wave"></i> Pay Due</button>';
            // }
            echo "</td>";
            echo "</tr>";
        }
    } 

    mysqli_close($con);

}


if (isset($_GET['getSupplierData'])) {
    if ($client = $con->query("SELECT * FROM suppliers ORDER BY id DESC")) {
       echo '<option value="">---Select---</option>';
       while ($rows = $client->fetch_array()) {
          $clientId = $rows["id"];
          $client_name = $rows["fullname"];
          $company_name = $rows["company"];
          echo '<option value="' . $clientId . '">' . $client_name . ' (' . $company_name . ')</option>';
       }
    }
 }
 
if (isset($_GET['getProductData'])) {
   if ($ledgr = $con->query("SELECT * FROM products")) {
      echo '<option value="">Select</option>';

      while ($rows = $ledgr->fetch_array()) {
          $id = $rows["id"];

          $product_name = $rows["name"];

          echo '<option value="'.$id.'">'.$product_name.'</option>';
      }
  }
}
if (isset($_GET['getSingleProductData'])) {
   $id=$_GET['id'];
   if ($ledgr = $con->query("SELECT * FROM products WHERE `id`='$id' ")) {

      while ($rows = $ledgr->fetch_array()) {
          echo json_encode($rows);
          exit; 
      }
  }
}



 if (isset($_GET['get_invoice_data'])) {
    $invoice_id = $_GET['invoice_id'];

    /* Validate invoice_id*/
    $stmt = $con->prepare("SELECT total_due FROM purchase WHERE id = ?");
    $stmt->bind_param("i", $invoice_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            'status' => 'success',
            'total_due' => $row['total_due']
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invoice not found!'
        ]);
    }
    exit();
}

/* Add Purchase Invoice*/

if (isset($_GET['add_invoice']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $purchase_invoice=new Purchase_invoice($con); 
    
    $__response=Purchase_invoice::add_invoice($_POST);

    echo json_encode($__response);
    exit;

}
if (isset($_GET['get_invoice']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $invoice_id = intval($_GET['invoice_id']);
    $result = $con->query("SELECT * FROM purchase WHERE id=$invoice_id");
    if ($result->num_rows > 0) {
        $invoice_data = $result->fetch_assoc(); 
        echo json_encode($invoice_data);
    } else {
        echo json_encode(null); 
    }
    exit;
}
if(isset($_GET['add_due_payment']) && $_SERVER['REQUEST_METHOD']=='POST'){

    

    $client_id = isset($_POST["client_id"]) ? trim($_POST["client_id"]) : '';
    $paid_amount = isset($_POST["paid_amount"]) ? trim($_POST["paid_amount"]) : '';
    $transaction_type = isset($_POST["transaction_type"]) ? trim($_POST["transaction_type"]) : '';
    $transaction_date = isset($_POST["transaction_date"]) ? trim($_POST["transaction_date"]) : '';
    $transaction_note = isset($_POST["transaction_note"]) ? trim($_POST["transaction_note"]) : '';

	if (empty($client_id)) {
		echo json_encode([
			'success' => false,
			'message' => 'Client is required!',
		]);
		exit;
    }

	if (empty($paid_amount)) {
		echo json_encode([
			'success' => false,
			'message' => 'Paid Amount is required!',
		]);
		exit;
    }
	
	if (empty($transaction_type)) {
		echo json_encode([
			'success' => false,
			'message' => 'Transactioin Type is required!',
		]);
		exit;
    }
	if (empty($transaction_date)) {
		echo json_encode([
			'success' => false,
			'message' => 'Transactioin Date is required!',
		]);
		exit;
    }
	if (empty($transaction_note)) {
		echo json_encode([
			'success' => false,
			'message' => 'Transaction Note is required!',
		]);
		exit;
    }
    $total_amount = $con->query("SELECT SUM(grand_total) AS amount FROM purchase WHERE client_id='$client_id' ")->fetch_array()['amount'] ?? 0;

    $total_paid_amount = $con->query("SELECT SUM(amount) AS total_paid FROM inventory_transaction WHERE client_id='$client_id' AND transaction_type  !='0' AND inventory_type='Supplier'")->fetch_array()['total_paid'] ?? 0;

    $total_due_amount=$total_amount-$total_paid_amount;

    if ($_POST['paid_amount'] > $total_due_amount) {
        echo json_encode([
            'success' => false,
            'message' => 'Over Payment Not Allowed'
        ]);
        exit();
    }
    
    /*Get Master Ledger And Ledger id*/
    $sub_ledger_id=$_POST['sub_ledger_id'];
    $get_all_sub_ledger= $con->query("SELECT * FROM legder_sub WHERE id =$sub_ledger_id ");
    while($rows=$get_all_sub_ledger->fetch_array()){
        $ledger_id=$rows['ledger_id'];
        $mstr_ledger_id=$rows['mstr_ledger_id'];
    }
    $user_id=$_SESSION['uid']?? 1;
    $date=date('Y-m-d');

    $con->query("INSERT INTO ledger_transactions (transaction_number,user_id, mstr_ledger_id, ledger_id, sub_ledger_id, qty, value, total, status, note, date) VALUES ('$transaction_number','$user_id', '$mstr_ledger_id', '$ledger_id', '$sub_ledger_id', '1', '$paid_amount', '$paid_amount', '1', '$transaction_note', '$transaction_date')");

     /*Insert Inventory Transaction data*/
    $con->query("INSERT INTO `inventory_transaction`(`inventory_type`,`invoice_id`, `client_id`, `user_id`, `amount`, `transaction_type`, `transaction_date`, `create_date`, `note`) VALUES ('Supplier','0','$client_id','$user_id','$paid_amount','$transaction_type','$transaction_date',NOW(),'$transaction_note')");

    echo json_encode([
        'success' => true,
        'message' => 'Payment processed successfully!',
        'remaining_due' => $new_due_amount
    ]);
    exit;
}

if (isset($_GET['update_invoice']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    new Purchase_invoice($con); 
    $invoice_id = intval($_GET['invoice_id']);
    $__response=Purchase_invoice::update_invoice($invoice_id,$_POST);
    echo json_encode($__response);
    exit;
}
if (isset($_POST['delete_invoice']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    new Purchase_invoice($con); 
    $invoice_id = intval($_POST['invoice_id']);
    $__response=Purchase_invoice::delete_invoice($invoice_id);
    echo json_encode($__response);
    exit;
   
}



?>
