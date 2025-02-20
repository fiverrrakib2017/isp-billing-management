<?php

class Base_invoivce{
    protected static $con; 
    public function __construct($con)
    {
        self::$con=$con; 
    }

    public function request_validation($data){
        return [
            'usr_id' => isset($_SESSION["uid"]) ? intval($_SESSION["uid"]) : 0,
            'client_id' => $data['client_id'] ?? null,
            'date' =>$data['date']?? date('Y-m-d'),
            'sub_total' => $data['table_total_amount'] ?? null,
            'discount' => $data['table_discount_amount'] ?? 0,
            'grand_total' => $data['table_total_amount'] - ($data['table_discount_amount'] ?? 0),
            'total_due' => $data['table_due_amount'] ?? null,
            'total_paid' => $data['table_paid_amount'] ?? null,
            'note' => $data['note'] ?? '',
            'status' => $data['table_status'] ?? '0',
            'sub_ledger_id' => $data['sub_ledger_id'] ?? '0',

            'product_ids' => $data['table_product_id'] ?? [],
            'qtys' => $data['table_qty'] ?? [],
            'prices' => $data['table_price'] ?? [],
            'total_prices' => $data['table_total_price'] ?? [],
            'table_assets'=>$data['table_assets'] ?? 'off',
        ]; 
    }
    protected function insert_invoice($table,$validator){

        /*Insert purchase/sales invoice data*/
        $transaction_number=self::get_transaction_number();
         $sql = "INSERT INTO $table (transaction_number,usr_id, client_id, date, sub_total, discount, grand_total, total_due, total_paid, note, status,created_at) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = self::$con->prepare($sql);

        if (!$stmt) {
            throw new Exception('Prepare statement failed: ' . self::$con->error);
        }

        $stmt->bind_param("siisssssiss", 
           $transaction_number,
            $validator['usr_id'], 
            $validator['client_id'], 
            $validator['date'], 
            $validator['sub_total'], 
            $validator['discount'], 
            $validator['grand_total'], 
            $validator['total_due'], 
            $validator['total_paid'], 
            $validator['note'], 
            $validator['status']
        );
        
        if (!$stmt->execute()) {
            throw new Exception('Execute statement failed: ' . $stmt->error);
        }
        $invoice_id=self::$con->insert_id;

         /*Insert Inventory Transaction data*/
         $inventory_type=$table === "purchase" ? "Supplier" : "Customer";
         self::$con->query("INSERT INTO `inventory_transaction`(`inventory_type`,`invoice_id`, `client_id`, `user_id`, `amount`, `transaction_type`, `transaction_date`, `create_date`, `note`) VALUES ('$inventory_type','$invoice_id','$validator[client_id]','$validator[usr_id]','$validator[total_paid]','1','$validator[date]',NOW(),'Invoice Created')");

        return [
            'invoice_id' => $invoice_id,
            'transaction_number' => $transaction_number,
        ];
    }
    protected function insert_invoice_details($table, $invoice_id, $validator,$transaction_number=NULL){
        
        /********************Get Transaction Number ***********************/
        if (is_null($transaction_number)) {
            $transaction_table = $table === "purchase_details" ? "purchase" : "sales";
            
            $get_transaction_number = self::$con->query("SELECT transaction_number FROM `$transaction_table` WHERE id = $invoice_id");
            if ($get_transaction_number && $row = $get_transaction_number->fetch_assoc()) {
                $transaction_number = $row['transaction_number'];
            } else {
                throw new Exception("Transaction number not found for invoice ID: $invoice_id");
            }
        }
        
        /******************** Insert Details ***********************/
        $details_sql = "INSERT INTO $table (transaction_number,invoice_id, product_id, qty, value, total,status) VALUES (?,?, ?, ?, ?, ?, ?)";
        $details_stmt =self::$con->prepare($details_sql);

        if (!$details_stmt) {
            throw new Exception('Prepare statement for details failed: ' . self::$con->error);
        }

      

        /*Get Master Ledger And Ledger id*/
        $sub_ledger_id=$validator['sub_ledger_id'];
        $get_all_sub_ledger= self::$con->query("SELECT * FROM legder_sub WHERE id =$sub_ledger_id ");
        while($rows=$get_all_sub_ledger->fetch_array()){
            $ledger_id=$rows['ledger_id'];
            $mstr_ledger_id=$rows['mstr_ledger_id'];
        }
       
        /*Get Total Inoivce Amount*/
        $transaction_table = $table === "purchase_details" ? "purchase" : "sales";
        $get_total_inv_amount=self::$con->query("SELECT total_paid FROM $transaction_table WHERE id=$invoice_id");
        while($rows=$get_total_inv_amount->fetch_array()){
            $total_inv_amount=$rows['total_paid'];
        }
        
        /*Insert TOTAL Amount in  Ledger Transaction */
        if ($validator['status']=='1') {
            self::$con->query("INSERT INTO ledger_transactions (transaction_number,user_id, mstr_ledger_id, ledger_id, sub_ledger_id, qty, value, total, status, note, date) VALUES ('".$transaction_number."','".$validator['usr_id']."', '$mstr_ledger_id', '$ledger_id', '$sub_ledger_id', '1', '$total_inv_amount', '$total_inv_amount', '1', '".$validator['note']."', '".$validator['date']."')");
        }
       
        foreach ($validator['product_ids'] as $index => $product_id) {
            $qty = $validator['qtys'][$index];
            $price = $validator['prices'][$index];
            $total_price = $validator['total_prices'][$index];
            if ($table=="purchase_details" &&  $validator['status']=='1') {
                /******************** Insert Assets in Transaction table ***********************/
                if ($validator['table_assets']=='on') {
                    $_all_product=self::$con->query("SELECT * FROM products WHERE id = $product_id");
                    while($rows=$_all_product->fetch_array()){
                        $sub_ledger=$rows['assets_ac'];
                        if ($sub_ledger !== 0) {
                            if ($allSubLedger=self::$con->query("SELECT * FROM legder_sub WHERE id=$sub_ledger")) {
                                while ($rwos=$allSubLedger->fetch_array()) {
                                    $ledger_ID=$rwos['ledger_id'];
                                }
                            }
                            if ($getMasterLdg=self::$con->query("SELECT * FROM ledger WHERE id=$ledger_ID")) {
                                while ($rwos=$getMasterLdg->fetch_array()) {
                                    $mstr_ledger_id=$rwos['mstr_ledger_id'];
                                }
                            }   
                            self::$con->query("INSERT INTO ledger_transactions (transaction_number,user_id, mstr_ledger_id, ledger_id, sub_ledger_id, qty, value, total, status, note, date) VALUES ('".$transaction_number."','".$validator['usr_id']."', '".$mstr_ledger_id."', '".$ledger_ID."', '".$sub_ledger."', '".$qty."', '".$price."', '".$total_price."', '1', '".$validator['note']."', '".$validator['date']."')");
                        }
                    }
                }
            } 
            
            $details_stmt->bind_param("siiiiii", $transaction_number,$invoice_id, $product_id, $qty, $price, $total_price,$validator['status']);
            
            if (!$details_stmt->execute()) {
                throw new Exception('Execute statement for details failed: ' . $details_stmt->error);
            }
        }
    }
    public function request_update_invoice($table,$invoice_id,$validator){
         /* Update data in `sales` table */
         $sql = "UPDATE $table SET usr_id = ?, client_id = ?, date = ?, sub_total = ?, discount = ?, grand_total = ?, total_due = ?, total_paid = ?, note = ?, status = ? WHERE id = ?";
         $stmt = self::$con->prepare($sql);
         $stmt->bind_param("iisssssissi", 
             $validator['usr_id'], 
             $validator['client_id'], 
             $validator['date'], 
             $validator['sub_total'], 
             $validator['discount'], 
             $validator['grand_total'], 
             $validator['total_due'], 
             $validator['total_paid'], 
             $validator['note'], 
             $validator['status'], 
             $invoice_id,
         );
          /*Insert Inventory Transaction data*/
           $inventory_type=$table === "purchase" ? "Supplier" : "Customer";
          
          self::$con->query("UPDATE `inventory_transaction` SET `inventory_type`='$inventory_type',`client_id`='$validator[client_id]',`user_id`='$validator[usr_id]',`amount`='$validator[total_paid]',`transaction_type`='1',`transaction_date`=$validator[date],`create_date`='NOW()', WHERE invoice_id='$invoice_id'");
         if (!$stmt->execute()) {
            throw new Exception('Error updating  data.');
         }
         
    }
    protected function  request_delete_invoice_details($table,$invoice_id){

        $get_transaction_number=self::$con->query("SELECT transaction_number FROM $table WHERE invoice_id = $invoice_id");
        while($rows=$get_transaction_number->fetch_array()){
            $transaction_number=$rows['transaction_number'];
        }
        if (!empty($transaction_number)) {
            self::$con->query("DELETE FROM ledger_transactions WHERE transaction_number = '$transaction_number'");
        }
        self::$con->query("DELETE FROM $table WHERE invoice_id = $invoice_id");
    }

    public static function get_transaction_number(){
        /*Implementation for get transaction number*/
        $transaction_number= "TRANSID-".strtoupper(uniqid());
        return $transaction_number;
    }
    public static function delete($table, $invoice_id) {
        if (!empty($invoice_id) && !empty($table) && is_numeric($invoice_id)) {
            if ($table == "sales") {
                $get_transaction_number_result = self::$con->query("SELECT transaction_number FROM sales WHERE id = $invoice_id");
                if ($get_transaction_number_result && $row = $get_transaction_number_result->fetch_assoc()) {
                    $transaction_number = $row['transaction_number'];
                    self::$con->query("DELETE FROM ledger_transactions WHERE transaction_number = '$transaction_number'");
                    self::$con->query("DELETE FROM sales_details WHERE transaction_number = '$transaction_number'");
                    self::$con->query("DELETE FROM sales WHERE id = $invoice_id");
                }
            } elseif ($table == "purchase") {
                $get_transaction_number_result = self::$con->query("SELECT transaction_number FROM purchase WHERE id = $invoice_id");
                if ($get_transaction_number_result && $row = $get_transaction_number_result->fetch_assoc()) {
                    $transaction_number = $row['transaction_number'];
                    self::$con->query("DELETE FROM ledger_transactions WHERE transaction_number = '$transaction_number'");
                    self::$con->query("DELETE FROM purchase_details WHERE transaction_number = '$transaction_number'");
                    self::$con->query("DELETE FROM purchase WHERE id = $invoice_id");
                }
            }
        }
    }

    private function insert_ledger_transaction($transaction_number, $product_id, $qty, $price, $total_price, $validator, $ledger_column)
    {
        $_all_products = self::$con->query("SELECT * FROM products WHERE id = $product_id");
        while ($rows = $_all_products->fetch_array()) {
            $sub_ledger = $rows[$ledger_column];
            if ($sub_ledger !== 0) {
                $ledger_ID = $this->get_ledger_id($sub_ledger);
                $mstr_ledger_id = $this->get_master_ledger_id($ledger_ID);

                self::$con->query(
                    "INSERT INTO ledger_transactions (transaction_number, user_id, mstr_ledger_id, ledger_id, sub_ledger_id, qty, value, total, status, note, date) 
                    VALUES ('$transaction_number', '{$validator['usr_id']}', '$mstr_ledger_id', '$ledger_ID', '$sub_ledger', '$qty', '$price', '$total_price', '1', '{$validator['note']}', '{$validator['date']}')"
                );
            }
        }
    }

    private function get_ledger_id($sub_ledger)
    {
        $ledger_ID = NULL;
        if ($allSubLedger = self::$con->query("SELECT * FROM legder_sub WHERE id=$sub_ledger")) {
            while ($rwos = $allSubLedger->fetch_array()) {
                $ledger_ID = $rwos['ledger_id'];
            }
        }
        return $ledger_ID;
    }

    private function get_master_ledger_id($ledger_ID)
    {
        $mstr_ledger_id = NULL;
        if ($getMasterLdg = self::$con->query("SELECT * FROM ledger WHERE id=$ledger_ID")) {
            while ($rwos = $getMasterLdg->fetch_array()) {
                $mstr_ledger_id = $rwos['mstr_ledger_id'];
            }
        }
        return $mstr_ledger_id;
    }
    
}




?>