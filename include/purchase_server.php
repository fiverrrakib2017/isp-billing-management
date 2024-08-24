<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include "db_connect.php";
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



// if (isset($_POST['addData'])) {
//    $userId = $_POST['userId'];
//    $date = date("Y-m-d");
//    $supplier = $_POST['supplier'];
//    $refer_no = $_POST['refer_no'];
//    $desc = $_POST['desc'];
//    $item = $_POST['item'];
//    $quantity = $_POST['quantity'];
//    $value = $_POST['value'];
//    $total = $_POST['total'];

//    if (empty($_SESSION["purchase_invoice_id"])) {
//       $con->query("INSERT INTO purchase(usr_id,	client_id,	date,	sub_total,	discount,	grand_total	,note,status) VALUES('$userId','$supplier','$date','00','00','00','$desc','0')");
//       $invcID = $con->insert_id;
//       $_SESSION["purchase_invoice_id"] = $invcID;
//    }

//    if(!empty($_SESSION["purchase_invoice_id"])){
//      $crtdinvcID= $_SESSION['purchase_invoice_id'] ;
//        $con->query("INSERT INTO purchase_details(invoice_id,items,qty,value,total)VALUES('$crtdinvcID','$item','$quantity','$value','$total')");
//    }

//    //echo $_SESSION["purchase_invoice_id"];
   
// }


// if (isset($_GET['show'])) {
//    $invcID=0;
//    if(isset($_SESSION["purchase_invoice_id"])){
//        $invcID=$_SESSION["purchase_invoice_id"];
//    }
  
//    $total = 0;
//    $increment = 1;
//    echo '<table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">';
//    echo '<thead><tr><th>No</th><th>Item Name</th><th>Quantity</th><th>Value</th><th>Total</th><th>Action</th></tr></thead>';
//    echo '<tbody>';

//    if ($details = $con->query("SELECT * FROM purchase_details WHERE invoice_id ='$invcID'")) {
//       while ($rows = $details->fetch_array()) {
//          $id = $rows["id"];
//          $items = $rows["items"];
//          $qty = $rows["qty"];
//          $value = $rows["value"];
//          $total_value  = $rows["total"];
//          $total += $total_value;
//          echo '<tr>
            
//             <td>' . $increment++ . '</td>
//             <td>' . $items . '</td>
//             <td>' . $qty . '</td>
//             <td>' . $value . '</td>
//             <td>' . $total_value  . '</td>
//             <td>
//             <button class="btn-sm btn btn-danger" onclick="deleteInvItem('.$id.')"><i class="fas fa-trash"></i></button>
//             </td>
            
            
//             </tr>';
//       }
//    }
//    echo '<tbody>
    
//     <tr>
    
//     <td colspan="4"></td><td><b>Total: ' . $total . ' </b></td>
//     <td><button type="button" onclick="processPayment('.$total.')"  class="btn-sm btn btn-primary ">Payment</button></td>
    
//     </tr>
    
//     </tbody>';

//    echo '</table>';

//    echo '
  
   
//    ';
// }

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




// if (isset($_GET['subTotal'])) {
//    $invcID=$_SESSION["purchase_invoice_id"];
//    $subTotal = $_GET['subTotal'];
// 	$Discount =$_GET['Discounts'];
// 	$GrandTotal = $_GET['GrandTotal'];
// 	$totalPaid = $_GET['totalPaid'];
//    $total_due=$GrandTotal-$totalPaid;
//    if ($totalPaid > $GrandTotal) {
//       echo 2;
//    }else{
//       $con->query("UPDATE purchase SET sub_total='$subTotal',discount='$Discount', grand_total='$GrandTotal', total_due='$total_due', total_paid='$totalPaid' ,status='1' WHERE id='$invcID' ");
//     $_SESSION["purchase_invoice_id"]="";
//     echo 1;
//    }
   
// }
//add amount dues table
// if (isset($_POST['addReceivedPayment'])) {
//    $add_amount = $_POST['add_amount'];
//    $client_id = $_POST['client_id'];
//    $date=date('Y-m-d');

//    $result=$con->query("INSERT INTO purchase_dues(client_id,	due_amount,	date  )VALUES('$client_id','$add_amount','$date')");
//    if ($result) {
//       echo 1;
//    }else{
//       echo 0;
//    }



//    }
   
/* Set response header to JSON*/

if (isset($_GET['add_invoice']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
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
    /*Begin transaction*/ 
    $con->begin_transaction();

    try {
        /* Insert data into `purchase` table */
        $sql = "INSERT INTO purchase (usr_id, client_id, date, sub_total, discount, grand_total, total_due, total_paid, note, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);

        if (!$stmt) {
            throw new Exception('Prepare statement failed: ' . $con->error);
        }

        $stmt->bind_param("iisssssiss", $usr_id, $client_id, $date, $sub_total, $discount, $grand_total, $total_due, $total_paid, $note, $status);
        
        if (!$stmt->execute()) {
            throw new Exception('Execute statement failed: ' . $stmt->error);
        }

        $invoice_id = $con->insert_id;

        /* Insert data into `purchase_details` table */
        $details_sql = "INSERT INTO purchase_details (invoice_id, product_id, qty, value, total) VALUES (?, ?, ?, ?, ?)";
        $details_stmt = $con->prepare($details_sql);

        if (!$details_stmt) {
            throw new Exception('Prepare statement for details failed: ' . $con->error);
        }

        foreach ($product_ids as $index => $product_id) {
            $qty = $qtys[$index];
            $price = $prices[$index];
            $total_price = $total_prices[$index];
            /* Revert stock changes */
            
            //$con->query("UPDATE products SET store=store-$qty WHERE id=$product_id"); 

            $details_stmt->bind_param("iiiii", $invoice_id, $product_id, $qty, $price, $total_price);
            
            if (!$details_stmt->execute()) {
                throw new Exception('Execute statement for details failed: ' . $details_stmt->error);
            }
        }

        /* Commit transaction */
        $con->commit();

        echo json_encode(['success' => true, 'message' => 'Invoice Create successfully.']);
    } catch (Exception $e) {
        /* Rollback transaction */
        $con->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

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
