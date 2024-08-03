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
    $usr_id = 1; 
    $client_id = $_POST['supplier_id'];
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

    /*Begin transaction*/ 
    $con->begin_transaction();

    try {
        // Insert data into `purchase` table
        $sql_purchase = "INSERT INTO purchase (usr_id, client_id, date, sub_total, discount, grand_total, total_due, total_paid, note, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_purchase = $con->prepare($sql_purchase);
        $stmt_purchase->bind_param("iisssssiss", $usr_id, $client_id, $date, $sub_total, $discount, $grand_total, $total_due, $total_paid, $note, $status);

        if (!$stmt_purchase->execute()) {
            throw new Exception('Error inserting purchase data.');
        }
        $invoice_id = $stmt_purchase->insert_id; // Get the ID of the inserted purchase

        // Insert data into `purchase_details` table
        $sql_details = "INSERT INTO purchase_details (invoice_id, product_id, qty, value, total) VALUES (?, ?, ?, ?, ?)";
        $stmt_details = $con->prepare($sql_details);

        for ($i = 0; $i < count($product_ids); $i++) {
            $stmt_details->bind_param("iiidd", $invoice_id, $product_ids[$i], $qtys[$i], $prices[$i], $total_prices[$i]);
            if (!$stmt_details->execute()) {
                throw new Exception('Error inserting purchase details data.');
            }
        }

        // Commit transaction
        $con->commit();

        // Close statements
        $stmt_purchase->close();
        $stmt_details->close();
        $con->close();

        echo json_encode(['success' => true, 'message' => 'Purchase recorded successfully.']);

    } catch (Exception $e) {
        // Rollback transaction on error
        $con->rollback();
        echo json_encode(['success' => false, 'message' => 'Transaction failed: ' . $e->getMessage()]);
    }

}



?>
