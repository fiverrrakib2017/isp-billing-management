<?php 
include 'db_connect.php'; 



function get_total_amount($con, $table_name = "sales", $column_name = "total_due", $client_id = null, $invoice_id = null) {

    $query = "SELECT SUM($column_name) AS total_amount FROM $table_name";
    $params = [];
    $types = '';

    if ($client_id !== null) {
        $query .= " WHERE client_id = ?";
        $params[] = $client_id;
        $types .= 'i'; 
    }
    
    if ($invoice_id !== null) {
        $query .= $client_id !== null ? " AND invoice_id = ?" : " WHERE invoice_id = ?";
        $params[] = $invoice_id;
        $types .= 'i'; 
    }

    $stmt = $con->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $total_amount = 0;
    if ($result && $row = $result->fetch_assoc()) {
        $total_amount = $row['total_amount'] ?? 0;
    }

    $stmt->close();
    
    // Return the formatted total amount
    return number_format($total_amount, 2);
}


echo get_total_amount($con, "purchase","total_due"); 



?>
