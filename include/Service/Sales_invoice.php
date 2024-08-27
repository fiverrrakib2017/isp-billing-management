<?php
include 'Interface/invoice_interface.php'; 
include 'Base_invoice.php'; 

class Sales_invoice extends Base_invoivce  implements InvoiceInterface{

    public static function add_invoice($data){
       $validator = self::request_validation($data);
       
        if (is_null($validator['client_id']) || is_null($validator['sub_total']) || is_null($validator['total_paid']) || is_null($validator['total_due']) || empty($validator['product_ids'])) {
            return ['success'=>false, 'message'=>'Invalid input data.'];
            exit;
        }
        /* Begin transaction */
        self::$con->begin_transaction();

        try {
            /* Insert data into `sales` table */
           $invoice_id= self::insert_invoice('sales',$validator); 

            /* Insert data into `sales_details` table */
            self::insert_invoice_details('sales_details', $invoice_id, $validator);

            /* Commit transaction */
             self::$con->commit();
            return ['success' => true, 'message' => 'Invoice Create successfully.'];
            } catch (Exception $e) {
                /* Rollback transaction */
                self::$con->rollback();
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