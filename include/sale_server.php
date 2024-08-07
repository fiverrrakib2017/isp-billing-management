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

//add amount dues table
if (isset($_POST['addReceivedPayment'])) {
  $add_amount = $_POST['add_amount'];
  $client_id = $_POST['client_id'];
  $date=date('Y-m-d');

  $result=$con->query("INSERT INTO invoice_dues(client_id,	due_amount,	date  )VALUES('$client_id','$add_amount','$date')");
  if ($result) {
     echo 1;
  }else{
     echo 0;
  }

  }

  
  if (isset($_GET['add_invoice']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $usr_id = isset($_SESSION["uid"]) ? intval($_SESSION["uid"]) : 0;
    $client_id = $_POST['client_id'];
    $date = date('Y-m-d');
    $sub_total = $_POST['total_amount'];
    $discount = $_POST['discount_amount'];
    $grand_total = $_POST['total_amount'] - $_POST['discount_amount'];
    $total_due = $_POST['due_amount'];
    $total_paid = $_POST['paid_amount'];
    $note = '';
    $status = 'Pending';

    $product_ids = $_POST['product_id'];
    $qtys = $_POST['qty'];
    $prices = $_POST['price'];
    $total_prices = $_POST['total_price'];

    if (!$client_id || !$sub_total || !$total_paid || !$total_due || empty($product_ids)) {
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

        echo json_encode(['success' => true, 'message' => 'Purchase recorded successfully.']);
    } catch (Exception $e) {
        /* Rollback transaction */
        $con->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

if (isset($_GET['update_invoice']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
  $invoice_id = intval($_GET['invoice_id']);
  $usr_id = isset($_SESSION["uid"]) ? intval($_SESSION["uid"]) : 0;
  $client_id = $_POST['client_id'];
  $date = date('Y-m-d'); 
  $sub_total = $_POST['total_amount'];
  $discount = $_POST['discount_amount'];
  $grand_total = $_POST['total_amount'] - $_POST['discount_amount'];
  $total_due = $_POST['due_amount'];
  $total_paid = $_POST['paid_amount'];
  $note = ''; 
  $status = 'Pending'; 

  $product_ids = $_POST['product_id'];
  $qtys = $_POST['qty'];
  $prices = $_POST['price'];
  $total_prices = $_POST['total_price'];

  if (!$client_id || !$sub_total || !$total_paid || !$total_due || empty($product_ids)) {
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

      /* Fetch existing details to adjust stock */
      $old_details = $con->query("SELECT * FROM sales_details WHERE invoice_id = $invoice_id");
      while ($row = $old_details->fetch_assoc()) {
          $product_id = $row['product_id'];
          $old_qty = $row['qty'];
          /* Revert stock changes */
          $con->query("UPDATE products SET stock = stock + $old_qty WHERE id = $product_id");
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
          $con->query("UPDATE products SET stock = stock - $qty WHERE id = $product_id");
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
