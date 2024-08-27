<?php
include "db_connect.php";
include 'Service/Purchase_invoice.php';
session_start();
//delete data
if (isset($_POST['deleteData'])) {
   $id = $_POST['id'];
   $result = $con->query("DELETE FROM `invoice_details` WHERE  id=$id");
   if ($result == true) {
      echo "Item Delete Successfully";
   }
}

if (isset($_GET['getSupplierData'])) {
   if ($client = $con->query("SELECT * FROM suppliers ORDER BY id DESC")) {
      echo '<option value="">Select</option>';
      while ($rows = $client->fetch_array()) {
         $clientId = $rows["id"];
         $client_name = $rows["fullname"];
         echo '<option value='. $clientId.'>' . $client_name . '</option>';
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




if (isset($_GET['deleteInvItem'])) {
   $id=$_GET['id'];
    $con->query("DELETE  FROM purchase_details WHERE id= $id");
    echo 1;
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
}
   
/* Add Purchase Invoice*/

if (isset($_GET['add_invoice']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $purchase_invoice=new Purchase_invoice($con); 
    
    $__response=Purchase_invoice::add_invoice($_POST);

    echo json_encode($__response);

}

if (isset($_GET['update_invoice']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    

    $invoice_id = $_GET['invoice_id'];
    $usr_id = isset($_SESSION["uid"]) ? intval($_SESSION["uid"]) : 0;
    $client_id = $_POST['supplier_id'] ?? null;
    $date = date('Y-m-d'); 
    $sub_total = $_POST['table_total_amount'] ?? null;
    $discount = $_POST['table_discount_amount'] ?? 0; 
    $grand_total = $sub_total - $discount;
    $total_due = $_POST['table_due_amount'] ?? null;
    $total_paid = $_POST['table_paid_amount'] ?? null;
    $note = $_POST['note']??'';
    $status =$_POST['table_status'] ?? 0; 

    $product_ids = $_POST['table_product_id'] ?? [];
    $qtys = $_POST['table_qty'] ?? [];
    $prices = $_POST['table_price'] ?? [];
    $total_prices = $_POST['table_total_price'] ?? [];

    if (is_null($client_id) || is_null($sub_total) || is_null($total_paid) || is_null($total_due) || empty($product_ids)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
        exit;
    }
    /*Update purchase table*/ 
    $updatePurchaseQuery = "UPDATE purchase SET 
                                client_id = '$client_id', 
                                date = '$date', 
                                sub_total='$sub_total',
                                discount = '$discount', 
                                grand_total = '$grand_total',
                                total_due = '$total_due', 
                                total_paid = '$total_paid', 
                                note = '$note', 
                                status = '$status'
                            WHERE id = '$invoice_id'";
    
    if ($con->query($updatePurchaseQuery)) {
        /*Delete previous purchase details for this invoice*/ 
        $con->query("DELETE FROM purchase_details WHERE invoice_id = '$invoice_id'");


        foreach ($product_ids as $index => $product_id) {
            $qty = $qtys[$index];
            $value = $prices[$index];
            $total = $total_prices[$index];

            $insertDetailsQuery = "INSERT INTO purchase_details (invoice_id, product_id, qty, value, total) VALUES ('$invoice_id', '$product_id', '$qty', '$value', '$total')";

            $con->query($insertDetailsQuery);
        }

        echo json_encode(['success' => true, 'message' => 'Invoice updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating invoice: ' . $con->error]);
    }
}



?>
