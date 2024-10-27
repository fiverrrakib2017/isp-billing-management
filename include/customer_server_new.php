<?php
    include 'db_connect.php';
    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_GET['get_customers_data']) && $_SERVER['REQUEST_METHOD']=='GET') {
        require 'datatable.php';

        $table = 'customers';
        $primaryKey = 'id';
        $columns = array(
            array(
                'db' => 'id', 
                'dt' => 0,
                'formatter' => function($d, $row) {
                    return '<input type="checkbox" value="' . $d . '" name="checkAll[]" class="form-check-input customer-checkbox checkSingle">';
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
            //$condition = "package = 5"; 
        }

        /* If 'area_id' is provided, */
        if (isset($_GET['area_id']) && !empty($_GET['area_id'])) {
            $condition .= " AND area = '" . $_GET['area_id'] . "'";
        }
        /* If 'pop_id' is provided, */
        if (isset($_GET['pop_id']) && !empty($_GET['pop_id'])) {
            $condition .= " AND pop = '" . $_GET['pop_id'] . "'";
        }
        /* If Status is provided, */
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $status = $_GET['status'];

            if ($status == 'expired') {
                $status = "2";
                $condition .= (!empty($condition) ? " AND " : "") . "customers.status = '" . $status . "'";
            } elseif ($status == 'disabled') {
                $status = "0";
                $condition .= (!empty($condition) ? " AND " : "") . "customers.status = '" . $status . "'";
            } elseif ($status == 'active') {
                $status = "1";
                $condition .= (!empty($condition) ? " AND " : "") . "customers.status = '" . $status . "'";
            } elseif ($status == 'online') {
                $status = "1";
                $condition .= (!empty($condition) ? " AND " : "") . "customers.status = '" . $status . "' 
                                AND EXISTS (
                                    SELECT 1 FROM radacct 
                                    WHERE radacct.username = customers.username 
                                    AND radacct.acctstoptime IS NULL
                                )";
            }elseif($status == 'free') {
                $condition .= "package = 5"; 
            }elseif($status == 'unpaid') {
                $popID=$_SESSION['user_pop'] ?? 1;
                /* Unpaid customers condition*/
                    $condition .= (!empty($condition) ? " AND " : "") . "
                    EXISTS (
                        SELECT 1 FROM customer_rechrg 
                        WHERE 
                            DAY(expiredate) BETWEEN 1 AND 10 
                            AND MONTH(expiredate) = MONTH(CURDATE()) 
                            AND YEAR(expiredate) = YEAR(CURDATE())
                            AND pop = '$popID'
                    )
                ";
            }
            elseif($status == 'offline') {
                $status = "0";
                $condition .= (!empty($condition) ? " AND " : "") . "customers.status = '" . $status . "' 
                                AND NOT EXISTS (
                                    SELECT 1 FROM radacct 
                                    WHERE radacct.username = customers.username 
                                    AND radacct.acctstoptime IS NOT NULL
                                )";
            }
            else {
                $condition .= (!empty($condition) ? " AND " : "") . "customers.status = '" . $status . "'";
            }
        }
        /* Output JSON for DataTables to handle*/
        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $condition)
        );
    }
?>
