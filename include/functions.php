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

function get_online_users($area_id, $pop_id, $con) {
    $online_users = 0;

    $conditions = [];
    if (!empty($area_id)) {
        $conditions[] = "area = " . intval($area_id)."AND status='1'"; 
    }
    if (!empty($pop_id)) {
        $conditions[] = "pop = " . intval($pop_id)."AND status='1'"; 
    }

    $where_clause = !empty($conditions) ? "WHERE " . implode(" OR ", $conditions) : "";

    $query = "SELECT `username` FROM customers $where_clause";
    $result = $con->query($query);

    if ($result) {
        $usernames = [];
        while ($row = $result->fetch_assoc()) {
            $usernames[] = $row['username'];
        }

        if (!empty($usernames)) {
            $usernames_list = "'" . implode("','", array_map([$con, 'real_escape_string'], $usernames)) . "'";

            $online_query = "
                SELECT COUNT(DISTINCT username) AS online_count
                FROM radacct
                WHERE username IN ($usernames_list)
                AND acctstoptime IS NULL
            ";

            $online_result = $con->query($online_query);
            if ($online_result && $row = $online_result->fetch_assoc()) {
                $online_users = $row['online_count'];
            }
        }
    }

    return $online_users;
}

function get_offline_users($area_id, $pop_id, $con) {
    $offline_users = 0;

    $conditions = [];
    if (!empty($area_id)) {
        $conditions[] = "area = " . intval($area_id)."AND status='1'"; 
    }
    if (!empty($pop_id)) {
        $conditions[] = "pop = " . intval($pop_id)."AND status='1'"; 
    }

    $where_clause = !empty($conditions) ? "WHERE " . implode(" OR ", $conditions) : "";

    $query = "SELECT `username` FROM customers $where_clause";
    $result = $con->query($query);

    if ($result) {
        $usernames = [];
        while ($row = $result->fetch_assoc()) {
            $usernames[] = $row['username'];
        }
        if (!empty($usernames)) {
            $usernames_list = "'" . implode("','", array_map([$con, 'real_escape_string'], $usernames)) . "'";
           
            $offline_query = "SELECT COUNT(*) AS offline_count 
                FROM customers 
                WHERE username NOT IN (
                    SELECT username 
                    FROM radacct 
                    WHERE acctstoptime IS NULL AND acctterminatecause = ''
                ) AND username IN ($usernames_list)";

            $offline_result = $con->query($offline_query);
            if ($offline_result && $row = $offline_result->fetch_assoc()) {
                $offline_users = $row['offline_count'];
            }
        }
    }

    return $offline_users;
}

function get_filtered_customers($status, $area_id = null, $pop_id = null, $con) {
    $condition = "";

    if (!empty($area_id)) {
        $condition .= (!empty($condition) ? " AND " : "") . "area = '" . $area_id . "'";
    }

    if (!empty($pop_id)) {
        $condition .= (!empty($condition) ? " AND " : "") . "pop = '" . $pop_id . "'";
    }

    if (!empty($status)) {
        if ($status == 'expired') {
            $condition .= (!empty($condition) ? " AND " : "") . "customers.status = '2'";
        } elseif ($status == 'disabled') {
            $condition .= (!empty($condition) ? " AND " : "") . "customers.status = '0'";
        } elseif ($status == 'active') {
            $condition .= (!empty($condition) ? " AND " : "") . "customers.status = '1'";
        } elseif ($status == 'online') {
            $condition .= (!empty($condition) ? " AND " : "") . "customers.status = '1' 
                                AND EXISTS (
                                    SELECT 1 FROM radacct 
                                    WHERE radacct.username = customers.username 
                                    AND radacct.acctstoptime IS NULL
                                )";
        } elseif ($status == 'free') {
            $condition .= (!empty($condition) ? " AND " : "") . "package = 5";
        } elseif ($status == 'unpaid') {
            $condition .= (!empty($condition) ? " AND " : "") . "
                EXISTS (
                    SELECT 1 FROM customer_rechrg 
                    WHERE 
                        DAY(expiredate) BETWEEN 1 AND 10 
                        AND MONTH(expiredate) = MONTH(CURDATE()) 
                        AND YEAR(expiredate) = YEAR(CURDATE())
                )";
        } elseif ($status == 'offline') {
            $condition .= (!empty($condition) ? " AND " : "") . "customers.status = '1' 
                                AND customers.username NOT IN (
                                    SELECT username FROM radacct 
                                    WHERE acctstoptime IS NULL AND acctterminatecause = ''
                                )";
        } else {
            $condition .= (!empty($condition) ? " AND " : "") . "customers.status = '" . $status . "'";
        }
    }

    $query = "SELECT * FROM customers";
    if (!empty($condition)) {
        $query .= " WHERE " . $condition;
    }

    $result = $con->query($query);
    $customers = [];
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }

    return $customers;
}


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

function find_customer($id){
    include 'db_connect.php';
    header('Content-Type: application/json');
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



?>
