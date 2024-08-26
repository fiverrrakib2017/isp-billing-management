<?php
include 'Interface/invoice_interface.php'; 

class Sales_invoice implements InvoiceInterface{
    private static $con;
    public function __construct($con)
    {
        self::$con = $con; 
    }
    private function request_validation($data){
        return [
            'usr_id' => isset($_SESSION["uid"]) ? intval($_SESSION["uid"]) : 0,
            'client_id' => $data['client_id'] ?? null,
            'date' => date('Y-m-d'),
            'sub_total' => $data['table_total_amount'] ?? null,
            'discount' => $data['table_discount_amount'] ?? 0,
            'grand_total' => $data['table_total_amount'] - ($data['table_discount_amount'] ?? 0),
            'total_due' => $data['table_due_amount'] ?? null,
            'total_paid' => $data['table_paid_amount'] ?? null,
            'note' => $data['note'] ?? '',
            'status' => $data['table_status'] ?? '0',
            'product_ids' => $data['table_product_id'] ?? [],
            'qtys' => $data['table_qty'] ?? [],
            'prices' => $data['table_price'] ?? [],
            'total_prices' => $data['table_total_price'] ?? []
        ]; 
    }
    public static function add_invoice($data){
       $validator= Sales_invoice::request_validation($data);

        if (is_null($validator['client_id']) || is_null($validator['sub_total']) || is_null($validator['total_paid']) || is_null($validator['total_due']) || empty($validator['product_ids'])) {
            return ['success'=>false, 'message'=>'Invalid input data.'];
            exit;
        }
        /* Begin transaction */
        Sales_invoice::$con->begin_transaction();

        try {
            /* Insert data into `sales` table */
            $sql = "INSERT INTO sales (usr_id, client_id, date, sub_total, discount, grand_total, total_due, total_paid, note, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = Sales_invoice::$con->prepare($sql);

            if (!$stmt) {
                throw new Exception('Prepare statement failed: ' . Sales_invoice::$con->error);
            }

            $stmt->bind_param("iisssssiss", 
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

            $invoice_id = self::$con->insert_id;

            /* Insert data into `sales_details` table */
            $details_sql = "INSERT INTO sales_details (invoice_id, product_id, qty, value, total) VALUES (?, ?, ?, ?, ?)";
            $details_stmt =self::$con->prepare($details_sql);

            if (!$details_stmt) {
                throw new Exception('Prepare statement for details failed: ' .  Sales_invoice::$con->error);
            }

            foreach ($validator['product_ids']  as $index => $product_id) {
                $qty = $validator['qtys'][$index];
                $price = $validator['prices'][$index];
                $total_price = $validator['total_prices'][$index];
                /* Revert stock changes */
                
                //$this->con->query("UPDATE products SET store=store-$qty WHERE id=$product_id"); 

                $details_stmt->bind_param("iiiii", $invoice_id, $product_id, $qty, $price, $total_price);
                
                if (!$details_stmt->execute()) {
                    throw new Exception('Execute statement for details failed: ' . $details_stmt->error);
                }
            }

            /* Commit transaction */
             Sales_invoice::$con->commit();
            return ['success' => true, 'message' => 'Invoice Create successfully.'];
            } catch (Exception $e) {
                /* Rollback transaction */
                Sales_invoice::$con->rollback();
                return ['success' => false, 'message' => $e->getMessage()];
            }
        }
    public static function update_invoice($invoice_id,$data){
        /*Implementation for updating sales invoice*/ 

        $validator=Sales_invoice::request_validation($data); 
        
        if (is_null($validator['client_id']) || is_null($validator['sub_total']) || is_null($validator['total_paid']) || is_null($validator['total_due']) || empty($validator['product_ids'])) {
            return ['success'=>false, 'message'=>'Invalid input data.'];
            exit;
        }
    
        /* Begin transaction */
        Sales_invoice::$con->begin_transaction();
    
        try {
            /* Update data in `sales` table */
            $sql = "UPDATE sales SET usr_id = ?, client_id = ?, date = ?, sub_total = ?, discount = ?, grand_total = ?, total_due = ?, total_paid = ?, note = ?, status = ? WHERE id = ?";
            $stmt = Sales_invoice::$con->prepare($sql);
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
                $invoice_id
            );
            if (!$stmt->execute()) {
                throw new Exception('Error updating Sales data.');
            }
    
            /* Delete old details */
            Sales_invoice::$con->query("DELETE FROM sales_details WHERE invoice_id = $invoice_id");
    
            /* Insert updated details */
            $details_sql = "INSERT INTO sales_details (invoice_id, product_id, qty, value, total) VALUES (?, ?, ?, ?, ?)";
            $details_stmt = Sales_invoice::$con->prepare($details_sql);
            foreach ($validator['product_ids'] as $index => $product_id) {
                $qty = $validator['qtys'][$index];
                $price =$validator['prices'][$index];
                $total_price = $validator['total_prices'][$index];
    
                $details_stmt->bind_param("iiiii", $invoice_id, $product_id, $qty, $price, $total_price);
                if (!$details_stmt->execute()) {
                    throw new Exception('Execute statement for details failed: ' . $details_stmt->error);
                }
            }
    
            /* Commit transaction */
            Sales_invoice::$con->commit();
            return ['success'=>true, 'message'=>'Invoice updated successfully.'];
        } catch (Exception $e) {
            /* Rollback transaction */
            Sales_invoice::$con->rollback();
            return  ['success' => false, 'message' => $e->getMessage()];
        }
    }
    public static function delete_invoice($id){
        /*Implementation for delete sales invoice*/
    } 
}


?>