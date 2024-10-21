<?php
    include 'db_connect.php';
    require 'datatable.php';
    if (!isset($_SESSION)) {
        session_start();
    }
    $table = 'customers';
    $primaryKey = 'id';

    $columns = array(
        array(
            'db' => 'id', 
            'dt' => 0,
            'formatter' => function($d, $row) {
                return '<input type="checkbox" value="' . $d . '" name="checkAll[]" class="checkSingle">';
            }
        ),
        array('db' => 'id', 'dt' => 1),
        array(
            'db'        => 'fullname',
            'dt'        => 2,
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
        array('db' => 'package_name', 'dt' => 3),
        array('db' => 'price', 'dt' => 4),
        array(
            'db' => 'expiredate',
            'dt' => 5,
            'formatter' => function($d, $row) {
                $todayDate = date("Y-m-d");
                if ($d <= $todayDate) {
                    return "<span class='badge bg-danger'>Expired</span>";
                } else {
                    return $d;
                }
            }
        ),
        array('db' => 'expiredate', 'dt' => 6),
        array('db' => 'username', 'dt' => 7),
        array('db' => 'mobile', 'dt' => 8),
        array(
            'db' => 'pop',
            'dt' => 9,
            'formatter' => function($d, $row) use ($con) {
                $popID = $d;
                $allPOP = $con->query("SELECT * FROM add_pop WHERE id=$popID");
                $popRow = $allPOP->fetch_array();
                return $popRow['pop'];
            }
        ),
        array(
            'db' => 'area',
            'dt' => 10,
            'formatter' => function($d, $row) use ($con) {
                $areaID = $d;
                $allArea = $con->query("SELECT * FROM area_list WHERE id='$areaID'");
                $areaRow = $allArea->fetch_array();
                return $areaRow['name'];
            }
        ),
        array(
            'db' => 'id',
            'dt' => 11,
            'formatter' => function($d, $row) {
                return '<a class="btn btn-info" href="profile_edit.php?clid=' . $d . '"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-success" href="profile.php?clid=' . $d . '"><i class="fas fa-eye"></i></a>';
            }
        )
    );
   
    $condition="";
    if (!empty($_SESSION['user_pop'])) {
		$condition = "pop = '" . $_SESSION['user_pop'] . "'";
	} else {
        $condition = "package = 5"; 
	}
	/* Output JSON for DataTables to handle*/
	echo json_encode(
		SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $condition)
	);
?>
