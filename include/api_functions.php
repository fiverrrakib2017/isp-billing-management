<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'db_connect.php';


if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'all_customer':
            all_customer($con);
            break;

        case 'get_customer':
            $id = $_GET['clid'] ?? null;
            get_customer($con, $id);
            break;

       

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No action specified']);
}

function all_customer($con){
    $result =$con->query("SELECT * FROM customers");
    $customers = [];
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $customers]);
}
 function get_customer($con,$id){
    if(isset($id) && !empty($id)){
     $customer=$con->query("SELECT * FROM `customers` WHERE id=$id");
     if($customer->num_rows>0){
         $row=$customer->fetch_array();
         echo json_encode(['success'=>true,'data'=>$row]);
     }
    }else{
         echo json_encode(['success'=>false,'message'=>'Customer not found']);
    }
 }