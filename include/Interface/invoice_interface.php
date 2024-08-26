<?php

interface InvoiceInterface{
    /*no body in this method*/
    public static function add_invoice($data); 
    public static function update_invoice($id,$data); 
    public static function delete_invoice($id); 
}


?>