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
            
            if ($rows['total_due'] > 0 && $rows['status'] == '1') {
                echo '<button type="button" name="due_paid_button" data-id="' . $rows['id'] . '" class="btn-sm btn btn-info" style="margin-right: 5px;">  <i class="fas fa-money-bill-wave"></i> Pay Due</button>';
            }
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
/* Check if the process_payment request is made and it is a POST request*/
if (isset($_GET['process_payment']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $invoice_id = $_POST['invoice_id'];
    $client_id = $_POST['client_id'];
    $amount = $_POST['amount'];
    $payment_type = $_POST['type']??'1';
    /* Check if the payment amount is valid*/
     if ($_POST['amount'] > $_POST['total_due']) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Over Payment Not Allowed'
        ]);
        exit();
    }

 
    /* Update the `purchase` table*/
    $stmt = $con->prepare("UPDATE `purchase` SET `total_paid`=`total_due`+?, `total_due` = `total_due` - ? WHERE `id` = ? AND `client_id` = ?");
    $stmt->bind_param("iiii", $amount,$amount, $invoice_id, $client_id);
   
    if ($stmt->execute()) {

        /*Insert payment details into `purchase_dues` table*/            
        $stmt2 = $con->prepare("INSERT INTO `purchase_dues`(`invoice_id`, `supplier_id`, `due_amount`, `payment_type`, `date`) VALUES (?, ?, ?, ?, NOW())");
        $stmt2->bind_param("iiii", $invoice_id, $client_id, $amount, $payment_type);

        if ($stmt2->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Payment processed successfully and record saved.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Payment processed but failed to save payment record.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update payment. Please try again.'
        ]);
    }

    $stmt->close();
    $stmt2->close();
    $con->close();
    exit;
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
    $transaction_number = isset($_POST["transaction_number"]) ? trim($_POST["transaction_number"]) : '';
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
	if (empty($transaction_number)) {
		echo json_encode([
			'success' => false,
			'message' => 'Transaction Number is required!',
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
    /* Check if the payment amount is valid*/
    // $supplier_id=$con->query("SELECT client_id FROM purchase WHERE id=$invoice_id")->fetch_assoc()['client_id'];
    // $total_due_amount=$con->query("SELECT total_due FROM purchase WHERE id=$invoice_id")->fetch_assoc()['total_due'];
    // if ($total_due_amount === null) {
    //     echo json_encode([
    //         'success' => false,
    //         'message' => 'No Due Amount Found'
    //     ]);
    //     exit();
    // }
    if ($_POST['paid_amount'] > $total_due_amount) {
        echo json_encode([
            'success' => false,
            'message' => 'Over Payment Not Allowed'
        ]);
        exit();
    }
    
    /* Calculation New Due Amount*/
    $new_due_amount=$total_due_amount-$paid_amount;
    
    /* Update the `purchase` table*/
    $stmt = $con->prepare("UPDATE purchase  SET total_due = GREATEST(0, ?), total_paid = total_paid + ? 
    WHERE id = ?");
    $stmt->bind_param("iii", $new_due_amount, $paid_amount, $invoice_id);
    
    if ($stmt->execute()) {
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

        // $con->query("INSERT INTO `purchase_dues`( `invoice_id`, `supplier_id`, `due_amount`, `payment_type`,`transaction_date`, `date`) VALUES ('$invoice_id','$supplier_id','$paid_amount','1','$transaction_date','$date')");
         /*Insert Inventory Transaction data*/
        $con->query("INSERT INTO `inventory_transaction`(`inventory_type`,`invoice_id`, `client_id`, `user_id`, `amount`, `transaction_type`, `transaction_date`, `create_date`, `note`) VALUES ('Supplier','$supplier_id','$user_id','$paid_amount','4','$create_date',NOW(),'$transaction_note')");
        echo json_encode([
            'success' => true,
            'message' => 'Payment processed successfully!',
            'remaining_due' => $new_due_amount
        ]);
    } else {
        echo json_encode([
        'success' => false,
        'message' => 'Update Failed'
        ]);
    }

$stmt->close();

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
