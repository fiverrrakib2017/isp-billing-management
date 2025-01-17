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


            echo "<td>";

            echo '<a class="btn-sm btn btn-primary" style="margin-right: 5px;" href="purchase_invoice_edit.php?id=' . $rows['id'] . '"><i class="fas fa-edit"></i></a>';
            echo '<a class="btn-sm btn btn-success" style="margin-right: 5px;" href="invoice/purchase_inv_view.php?clid=' . $rows['id'] . '"><i class="fas fa-eye"></i></a>';
            echo '<button type="button" name="delete_button" data-id="' . $rows['id'] . '" class="btn-sm btn btn-danger" style="margin-right: 5px;"><i class="fas fa-trash"></i></button>';

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
}
   
/* Add Purchase Invoice*/

if (isset($_GET['add_invoice']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    
    $purchase_invoice=new Purchase_invoice($con); 
    
    $__response=Purchase_invoice::add_invoice($_POST);

    echo json_encode($__response);

}

if (isset($_GET['update_invoice']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    new Purchase_invoice($con); 
    $invoice_id = intval($_GET['invoice_id']);
    $__response=Purchase_invoice::update_invoice($invoice_id,$_POST);
    echo json_encode($__response);
}
if (isset($_POST['delete_invoice']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    new Purchase_invoice($con); 
    $invoice_id = intval($_POST['invoice_id']);
    $__response=Purchase_invoice::delete_invoice($invoice_id);
    echo json_encode($__response);
   
}



?>
