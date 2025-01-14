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
    
    /* Return the formatted total amount*/
    return number_format($total_amount, 2);
}

function get_latest_customer($con, $pop_id = null, $limit = 5) {
    $customers = [];

    /*Check if pop_id is set*/
    $whereClause = isset($pop_id) && !empty($pop_id) ? "WHERE pop = '$pop_id'" : "";

    /**Get latest 5 customers*/
    $sql = "SELECT * FROM customers $whereClause ORDER BY id DESC LIMIT $limit";
    $result = mysqli_query($con, $sql);

    while ($rows = mysqli_fetch_assoc($result)) {
        $username = $rows['username'];
        $popID = $rows['pop'];
        $areaID = $rows['area'];

        /**Check if user is online*/
        $onlineusr = mysqli_query($con, "SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username='$username'");
        $status = (mysqli_num_rows($onlineusr) > 0) ? 'Online' : 'Offline';

        /**Get pop and area name*/
        $popResult = mysqli_query($con, "SELECT pop FROM add_pop WHERE id='$popID'");
        $popName = ($popRow = mysqli_fetch_assoc($popResult)) ? $popRow['pop'] : 'N/A';

        /**Get area name*/
        $areaResult = mysqli_query($con, "SELECT name FROM area_list WHERE id='$areaID'");
        $areaName = ($areaRow = mysqli_fetch_assoc($areaResult)) ? $areaRow['name'] : 'N/A';

       
        $customers[] = [
            'id' => $rows['id'],
            'fullname' => $rows['fullname'],
            'username' => $username,
            'status' => $status,
            'pop' => $popName,
            'area' => $areaName
        ];
    }

    return $customers;
}

function get_online_users($area_id,$pop_id,$con) {
    $customers=[];
    if (!empty($area_id)&&isset($area_id)) {
        $onlinecstmr = $con->query("SELECT `username` AS online_users FROM customers WHERE  area=$area_id");
        while($row = mysqli_fetch_assoc($onlinecstmr)) {
            $customers[] = $row['online_users'];

        }
    }
    if (!empty($pop_id)&&isset($pop_id)) {
        $onlinecstmr = $con->query("SELECT `username` AS online_users FROM customers WHERE  pop=$pop_id");
        while($row = mysqli_fetch_assoc($onlinecstmr)) {
            $customers[] = $row['online_users'];
        }
    }
    
    $_online_users = 0;

    foreach ($customers as $_get_customer_username) {
        $result = $con->query("SELECT COUNT(*) AS online_count FROM radacct WHERE username='$_get_customer_username' AND acctstoptime IS NULL");
        if ($row = $result->fetch_assoc()) {
            $_online_users += $row['online_count'];
        }
    }

    return $_online_users;
};

function get_count_pop_and_area_with_online_and_offline($con,$table_name,$column_name) {
    $online_count = 0;
    $offline_count=0; 
    /*Fetch The all Entries from the table*/
    if($_all_data = $con->query("SELECT * FROM $table_name")) {
        while($_all_data_row =$_all_data->fetch_array()){
            $id=$_all_data_row['id'];
            /*Count The data from table*/
            $get_data=$con->query("SELECT COUNT(*) as online_count 
                    FROM radacct
                    INNER JOIN customers 
                    ON customers.username = radacct.username
                    WHERE customers.$column_name = '$id' AND radacct.acctstoptime IS NULL"); 
            if($get_data){
                $row = $get_data->fetch_assoc();
                $online_count += ($row['online_count'] > 0) ? 1 : 0;
                $offline_count += ($row['online_count'] == 0) ? 1 : 0;
            }else{
                $offline_count ++; 
            }

        }
    }
    return [
        'online' => $online_count,
        'offline' => $offline_count,
    ];
}


function get_ticket_count($con, $value){
    $ticket_count = 0;
    $sql = "SELECT COUNT(*) as ticket_count FROM ticket WHERE ticket_type = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('s', $value);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $row = $result->fetch_assoc()) {
        $ticket_count = $row['ticket_count'] ?? 0;
    }
    $stmt->close();
    return $ticket_count;
}

/**
 * Check if a value exists in a specific column of a database table
 *
 * @param mysqli $con The database connection
 * @param string $table The name of the table
 * @param string $column The column to check
 * @param string $value The value to check for uniqueness
 * @return bool True if the value exists, false otherwise
 */
function isUniqueColumn($con, $table, $column, $value, $exclude=NULL)
{
    $condition=""; 
    $types = "s";
    if(isset($exclude) && !empty($exclude)){
        $condition ='AND id != ?'; 
        $types .= "i"; 
    }
    

    $query = "SELECT COUNT(*) as count FROM $table WHERE $column = ? $condition ";
    $stmt = $con->prepare($query);
    if ($stmt) {
        if (!empty($exclude)) {
            $stmt->bind_param($types, $value, $exclude); 
        } else {
            $stmt->bind_param("s", $value); 
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
    return false;
    exit; 
}

?>
