<?php
include 'Interface/Customer_interface.php'; 

class Customer_service implements CustomerInterface{
    private static $con;
    public function __construct($con)
    {
        self::$con = $con; 
    } 
    public static function all_customer(){
        $result = self::$con->query("SELECT * FROM customers");
        $customers = [];
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $customers]);
    }
    public static function find_customer($id){
       if(isset($id) && !empty($id)){
        $customer=self::$con->query("SELECT * FROM `customers` WHERE id=$id");
        if($customer->num_rows>0){
            $row=$customer->fetch_array();
            echo json_encode(['success'=>true,'data'=>$row]);
        }
       }else{
            echo json_encode(['success'=>false,'message'=>'Customer not found']);
       }
    }
}