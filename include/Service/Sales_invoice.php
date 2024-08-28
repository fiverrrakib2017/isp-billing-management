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
        $validator=self::request_validation($data); 
        
        if (is_null($validator['client_id']) || is_null($validator['sub_total']) || is_null($validator['total_paid']) || is_null($validator['total_due']) || empty($validator['product_ids'])) {
            return ['success'=>false, 'message'=>'Invalid input data.'];
            exit;
        }
    
        /* Begin transaction */
        self::$con->begin_transaction();
    
        try {
            /* Update data in `sales` table */
            self::request_update_invoice('sales',$invoice_id,$validator); 
           
            /* Delete old details */
           self::request_delete_invoice_details('sales_details',$invoice_id); 
          
            /* Insert updated details */
            self::insert_invoice_details('sales_details',$invoice_id,$validator); 
    
            /* Commit transaction */
            self::$con->commit();
            return ['success'=>true, 'message'=>'Invoice updated successfully.'];
        } catch (Exception $e) {
            /* Rollback transaction */
            self::$con->rollback();
            return  ['success' => false, 'message' => $e->getMessage()];
        }
    }
    public static function delete_invoice($id){
        /*Implementation for delete sales invoice*/
    } 
}


?>