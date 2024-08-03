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


if (isset($_POST['getDetails'])) {
  $a = 1;

  if ($invDetails = $con->query("SELECT * FROM invoice_details WHERE usr_id=$sessionUserId")) {
    while ($rows = $invDetails->fetch_array()) {
      $id = $rows["id"];
      $items = $rows["items"];
      $qty = $rows["qty"];
      $value = $rows["value"];
      $total = $rows["total"];

      echo '<tr>

         <td>' . $a++ . '</td>
         <td>' . $items . '</td>
         <td>' . $qty . '</td>
         <td>' . $value . '</td>
         <td>' . $total . '</td>
         <td><button type="button" data-id=' . $id . ' class="btn-sm btn btn-danger deleteBtn"><i class="fas fa-trash"></i></button></td>
         

         </tr>';
    }
  }
}

if (isset($_POST['addData'])) {

  $userId = $_POST['userId'];
  $date = date("Y-m-d");
  $client = $_POST['client'];
  $refer_no = $_POST['refer_no'];
  $desc = $_POST['desc'];
  $item = $_POST['item'];
  $quantity = $_POST['quantity'];
  $value = $_POST['value'];
  $total = $_POST['total'];
 
if($_SESSION["invcID"]=="")
{
  $con->query("INSERT INTO invoice(client_id,date,sub_total,discount,grand_total,note) VALUES('$client',NOW(),'00','00','00','$desc')");
  //$con->query("INSERT INTO invoice(client_id,date) VALUES('$client',NOW())");
  // $con->rollback();

  $invcID = $con->insert_id;
  $_SESSION["invcID"] = $invcID;
}

if($_SESSION["invcID"]!=""){
       $crtdinvcID = $_SESSION["invcID"];
	  $result = $con->query("INSERT INTO invoice_details(invoice_id,usr_id,items,qty,value,total)VALUES('$crtdinvcID','$userId','$item','$quantity','$value','$total')");

}

}

if (isset($_GET['show'])) {

  $invcID = $_SESSION["invcID"];
  $total = 0;
  $increment = 1;
  echo '<table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">';
  echo '<thead><tr><th>No</th><th>Item Name</th><th>Quantity</th><th>Value</th><th>Total</th><th>Action</th></tr></thead>';
  echo '<tbody>';

  if ($details = $con->query("SELECT * FROM invoice_details WHERE invoice_id='$invcID'")) {
    while ($rows = $details->fetch_array()) {
      $id = $rows["id"];
      $items = $rows["items"];
      $qty = $rows["qty"];
      $value = $rows["value"];
      $total_value  = $rows["total"];
      $total += $total_value;
      echo '<tr>
            
            <td>' . $increment++ . '</td>
            <td>' . $items . '</td>
            <td>' . $qty . '</td>
            <td>' . $value . '</td>
            <td>' . $total_value. '</td>
            <td>
            <a class="btn-sm btn btn-danger" onclick="deleteInvItem('.$id.')"><i class="fas fa-trash"></i></a>
            </td>
            
            
            </tr>';
    }
  }
  echo '<tbody>
    
    <tr>
    <td colspan="4"></td><td>Total: ' . $total . '</td>
    <td><button type="button" onclick="processPayment('.$total.')"  class="btn-sm btn btn-primary ">Payment</button></td>
    </tr>
    
    
    </tbody>';

  echo '</table>';
}
if (isset($_GET['deleteInvItem'])) {
  $id=$_GET['id'];
   $con->query("DELETE  FROM invoice_details WHERE id= $id");
   echo 1;
}
// Payment complete
if(isset($_POST['addPayment']))
{
	$invcID = $_SESSION["invcID"];
	$sub_total = $_POST['sub_total'];
	$payment_discount =$_POST['payment_discount'];
	$payment_grand_total = $_POST['payment_grand_total'];
  $payment_totalPaid = $_POST['payment_totalPaid'];
  $payment_totalDue = $_POST['payment_totalDue'];

  $con->query("UPDATE invoice SET sub_total='$sub_total',discount='$payment_discount', grand_total='$payment_grand_total', total_due='$payment_totalDue', total_paid='$payment_totalPaid' ,status='1' WHERE id='$invcID' "); 
  $_SESSION["invcID"] = "";
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
  
