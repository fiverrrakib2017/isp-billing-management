<?php
include "db_connect.php";
session_start();
$sessionUserId = $_SESSION["uid"];
//delete data
if (isset($_POST['deleteData'])) {
  $id = $_POST['id'];
  $result = $con->query("DELETE FROM `invoice_details` WHERE  id=$id");
  if ($result == true) {
    echo "Item Delete Successfully";
  }
}

if (isset($_GET['getClientData'])) {
  if ($client = $con->query("SELECT * FROM clients ORDER BY id DESC")) {
    echo '<option value="">Select</option>';
    while ($rows = $client->fetch_array()) {
        $clientId = $rows["id"];
        $client_name = $rows["fullname"];
        echo '

<option value='.$clientId.'>'.$client_name.'</option>

';
    }
} 
}


if (isset($_GET['deleteInvItem'])) {
  $id=$_GET['id'];
   $con->query("DELETE  FROM invoice_details WHERE id= $id");
   echo 1;
}

    if (isset($_GET['get_invoice_data'])) {
        $invoice_id = $_GET['invoice_id'];

        /* Validate invoice_id*/
        $stmt = $con->prepare("SELECT total_due FROM sales WHERE id = ?");
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
        $payment_type = $_POST['type']??'Cash';
        /* Check if the payment amount is valid*/
         if ($_POST['amount'] > $_POST['total_due']) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Over Payment Not Allowed'
            ]);
            exit();
        }

     
        /* Update the `sales` table*/
        $stmt = $con->prepare("UPDATE `sales` SET `total_due` = `total_due` - ? WHERE `id` = ? AND `client_id` = ?");
        $stmt->bind_param("iii", $amount, $invoice_id, $client_id);
       
        if ($stmt->execute()) {

            /*Insert payment details into `sales_dues` table*/            
            $stmt2 = $con->prepare("INSERT INTO `sales_dues`(`invoice_id`, `client_id`, `due_amount`, `payment_type`, `date`) VALUES (?, ?, ?, ?, NOW())");
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
  
  if (isset($_GET['add_invoice']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $usr_id = isset($_SESSION["uid"]) ? intval($_SESSION["uid"]) : 0;
    $client_id = $_POST['client_id']?? null;
    $date = date('Y-m-d');
    $sub_total = $_POST['table_total_amount']?? null;
    $discount = $_POST['table_discount_amount']?? 0; 
    $grand_total = $sub_total - $discount;
    $total_due = $_POST['table_due_amount'] ?? null;
    $total_paid = $_POST['table_paid_amount'] ?? null;
    $note = $_POST['note']??'';
    $status =$_POST['table_status']??'0';

    $product_ids = $_POST['table_product_id']?? [];
    $qtys = $_POST['table_qty']?? [];
    $prices = $_POST['table_price']?? [];
    $total_prices = $_POST['table_total_price']?? [];

    if (is_null($client_id) || is_null($sub_total) || is_null($total_paid) || is_null($total_due) || empty($product_ids)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
        exit;
    }

    /* Begin transaction */
    $con->begin_transaction();

    try {
        /* Insert data into `sales` table */
        $sql = "INSERT INTO sales (usr_id, client_id, date, sub_total, discount, grand_total, total_due, total_paid, note, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);

        if (!$stmt) {
            throw new Exception('Prepare statement failed: ' . $con->error);
        }

        $stmt->bind_param("iisssssiss", $usr_id, $client_id, $date, $sub_total, $discount, $grand_total, $total_due, $total_paid, $note, $status);
        
        if (!$stmt->execute()) {
            throw new Exception('Execute statement failed: ' . $stmt->error);
        }

        $invoice_id = $con->insert_id;

        /* Insert data into `sales_details` table */
        $details_sql = "INSERT INTO sales_details (invoice_id, product_id, qty, value, total) VALUES (?, ?, ?, ?, ?)";
        $details_stmt = $con->prepare($details_sql);

        if (!$details_stmt) {
            throw new Exception('Prepare statement for details failed: ' . $con->error);
        }

        foreach ($product_ids as $index => $product_id) {
            $qty = $qtys[$index];
            $price = $prices[$index];
            $total_price = $total_prices[$index];
            /* Revert stock changes */
            
            $con->query("UPDATE products SET store=store-$qty WHERE id=$product_id"); 

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
  $invoice_id = intval($_GET['invoice_id']);
  $usr_id = isset($_SESSION["uid"]) ? intval($_SESSION["uid"]) : 0;
  $client_id = $_POST['client_id']?? null;
  $date = date('Y-m-d'); 
  $sub_total = $_POST['table_total_amount']?? null;
  $discount = $_POST['table_discount_amount']?? null;
  $grand_total = $sub_total - $discount;
  $total_due = $_POST['table_due_amount']?? null;
  $total_paid = $_POST['table_paid_amount']?? null;
  $note = $_POST['note']??'';
  $status =$_POST['table_status'] ?? 0; 

    $product_ids = $_POST['table_product_id']?? [];
    $qtys = $_POST['table_qty']?? [];
    $prices = $_POST['table_price']?? [];
    $total_prices = $_POST['table_total_price']?? [];

  
    if (is_null($client_id) || is_null($sub_total) || is_null($total_paid) || is_null($total_due) || empty($product_ids)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
        exit;
    }

  /* Begin transaction */ 
  $con->begin_transaction();

  try {
      /* Update data in `sales` table */
      $sql = "UPDATE sales SET usr_id = ?, client_id = ?, date = ?, sub_total = ?, discount = ?, grand_total = ?, total_due = ?, total_paid = ?, note = ?, status = ? WHERE id = ?";
      $stmt = $con->prepare($sql);
      $stmt->bind_param("iisssssissi", $usr_id, $client_id, $date, $sub_total, $discount, $grand_total, $total_due, $total_paid, $note, $status, $invoice_id);
      if (!$stmt->execute()) {
          throw new Exception('Error updating Sales data.');
      }


      /* Delete old details */
      $con->query("DELETE FROM sales_details WHERE invoice_id = $invoice_id");

      /* Insert updated details */
      $details_sql = "INSERT INTO sales_details (invoice_id, product_id, qty, value, total) VALUES (?, ?, ?, ?, ?)";
      $details_stmt = $con->prepare($details_sql);
      foreach ($product_ids as $index => $product_id) {
          $qty = $qtys[$index];
          $price = $prices[$index];
          $total_price = $total_prices[$index];

          $details_stmt->bind_param("iiiii", $invoice_id, $product_id, $qty, $price, $total_price);
          if (!$details_stmt->execute()) {
              throw new Exception('Execute statement for details failed: ' . $details_stmt->error);
          }

          /* Adjust stock */
          $con->query("UPDATE products SET store = store - $qty WHERE id = $product_id");
      }

      /* Commit transaction */
      $con->commit();
      echo json_encode(['success' => true, 'message' => 'Invoice updated successfully.']);
  } catch (Exception $e) {
      /* Rollback transaction */
      $con->rollback();
      echo json_encode(['success' => false, 'message' => $e->getMessage()]);
  }
}

