<?php
include 'db_connect.php';
require 'datatable.php';

$table = 'customers';
$primaryKey = 'id';

$columns = array(
    array(
        'db' => 'id', 
        'dt' => 0,
    ),
    array(
        'db'        => 'fullname',
        'dt'        => 1,
        'formatter' => function($d, $row) use ($con) {
            $username = $row['username'];
            $onlineusr = $con->query("SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username='$username'");
            $chkc = $onlineusr->num_rows;
            $status = ($chkc == 1) 
                ? '<abbr title="Online"><img src="images/icon/online.png" height="10" width="10"/></abbr>' 
                : '<abbr title="Offline"><img src="images/icon/offline.png" height="10" width="10"/></abbr>';
            return $status . ' <a href="profile.php?clid=' . $row['id'] . '">' . $d . '</a>';
        }
    ),
    array('db' => 'package_name', 'dt' => 2),
    array('db' => 'price', 'dt' => 3),
    array(
        'db' => 'expiredate',
        'dt' => 4,
        'formatter' => function($d, $row) {
            $todayDate = date("Y-m-d");
            if ($d <= $todayDate) {
                return "<span class='badge bg-danger'>Expired</span>";
            } else {
                return $d;
            }
        }
    ),
  
    array('db' => 'mobile', 'dt' => 5),  
    array(
        'db' => 'pop',
        'dt' => 6,
        'formatter' => function($d, $row) use ($con) {
            $popID = $d;
            $allPOP = $con->query("SELECT * FROM add_pop WHERE id=$popID");
            $popRow = $allPOP->fetch_array();
            return $popRow['pop'];
        }
    ),
    array(
        'db' => 'area',
        'dt' => 7,
        'formatter' => function($d, $row) use ($con) {
            $areaID = $d;
            $allArea = $con->query("SELECT * FROM area_list WHERE id='$areaID'");
            $areaRow = $allArea->fetch_array();
            return $areaRow['name'];
        }
    ),
    array(
        'db' => 'id',
        'dt' => 8,
        'formatter' => function($d, $row) {
            return '<a class="btn btn-info" href="profile_edit.php?clid=' . $d . '"><i class="fas fa-edit"></i></a>

                <a class="btn btn-success" href="profile.php?clid=' . $d . '"><i class="fas fa-eye"></i></a>

                <a href="customer_delete.php?clid=' . $d . '" class="btn btn-danger deleteBtn" onclick=" return confirm(`Are You Sure`);" data-id=' . $d . '><i class="fas fa-trash"></i> </a>
                
                ';
        }
    )
);
/*Total price calculation*/
$result = $con->query("SELECT SUM(price) AS total_price FROM customers WHERE expiredate < DATE_ADD(now(), INTERVAL 10 DAY) AND pop = '1'");
$row = $result->fetch_assoc();
$total_price = $row['total_price'];

$condition = "expiredate<DATE_ADD(now(), INTERVAL 10 DAY) AND pop='1'"; 
/* Output JSON for DataTables to handle*/
$data = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, $condition);
/*Add total_price to the json response*/ 
$data['total_price'] = $total_price;
echo json_encode($data);

?>
