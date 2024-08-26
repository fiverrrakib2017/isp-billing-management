<?php
include "db_connect.php";
include 'Service/Sales_invoice.php';
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

<option value=' . $clientId . '>' . $client_name . '</option>

';
        }
    }
}

if (isset($_GET['deleteInvItem'])) {
    $id = $_GET['id'];
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
            'total_due' => $row['total_due'],
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invoice not found!',
        ]);
    }
    exit();
}
/* Check if the process_payment request is made and it is a POST request*/
if (isset($_GET['process_payment']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $invoice_id = $_POST['invoice_id'];
    $client_id = $_POST['client_id'];
    $amount = $_POST['amount'];
    $payment_type = $_POST['type'] ?? 'Cash';
    /* Check if the payment amount is valid*/
    if ($_POST['amount'] > $_POST['total_due']) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Over Payment Not Allowed',
        ]);
        exit();
    }

    /* Update the `sales` table*/
    $stmt = $con->prepare("UPDATE `sales` SET `total_paid`= `total_due` + ?, `total_due` = `total_due` - ? WHERE `id` = ? AND `client_id` = ?");
    $stmt->bind_param("iii", $amount, $invoice_id, $client_id);

    if ($stmt->execute()) {

        /*Insert payment details into `sales_dues` table*/
        $stmt2 = $con->prepare("INSERT INTO `sales_dues`(`invoice_id`, `client_id`, `due_amount`, `payment_type`, `date`) VALUES (?, ?, ?, ?, NOW())");
        $stmt2->bind_param("iiii", $invoice_id, $client_id, $amount, $payment_type);

        if ($stmt2->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Payment processed successfully and record saved.',
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Payment processed but failed to save payment record.',
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update payment. Please try again.',
        ]);
    }

    $stmt->close();
    $stmt2->close();
    $con->close();
}

if (isset($_GET['add_invoice']) && $_SERVER['REQUEST_METHOD']=='POST') {
        
    $sales_invoice=new Sales_invoice($con); 
    
    $__response=Sales_invoice::add_invoice($_POST);

    echo json_encode($__response);
}

if (isset($_GET['update_invoice']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $sales_invoice=new Sales_invoice($con); 
    $invoice_id = intval($_GET['invoice_id']);
    $__response=Sales_invoice::update_invoice($invoice_id,$_POST);
    echo json_encode($__response);
}