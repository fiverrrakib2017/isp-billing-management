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
                'db' => 'liablities',
                'dt' => 11,
                'formatter' => function($d, $row) use ($con) {
                   if ($d==1) {
                    return '<span class="badge bg-success">Yes</span>';
                   }else{
                    return '<span class="badge bg-danger">No</span>';
                   }
                }
            ),
            array(
                'db' => 'id',
                'dt' => 12,
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
            $condition .= (!empty($condition) ? " AND " : ""). "area = '" . $_GET['area_id'] . "'";
        }
        /* If 'pop_id' is provided, */
        if (isset($_GET['pop_id']) && !empty($_GET['pop_id'])) {
            // $condition .= " AND pop = '" . $_GET['pop_id'] . "'";
            $condition .= (!empty($condition) ? " AND " : ""). "pop = '" . $_GET['pop_id'] . "'";
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
            } elseif ($status == 'free') {
                $condition .= (!empty($condition) ? " AND " : "") . "package = 5"; 
            } elseif ($status == 'unpaid') {
                $popID = $_SESSION['user_pop'] ?? 1;
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
            } elseif ($status == 'offline') {
                $status = "0";
                // $condition .= (!empty($condition) ? " AND " : "") . "customers.status = '" . $status . "' 
                //                 AND NOT EXISTS (
                //                     SELECT 1 FROM radacct 
                //                     WHERE radacct.username = customers.username 
                //                     AND radacct.acctstoptime IS NOT NULL
                //                 )";
                $condition .= (!empty($condition) ? " AND " : "") . "
                                EXISTS (
                                    SELECT 1 FROM radacct 
                                    WHERE radacct.username = customers.username 
                                    AND radacct.acctstoptime IS NOT NULL
                                )
                            ";
            } else {
                $condition .= (!empty($condition) ? " AND " : "") . "customers.status = '" . $status . "'";
            }
        }
        /* Output JSON for DataTables to handle*/
        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $condition)
        );
    }

    if (isset($_GET['change_pop_request']) && !empty($_GET['change_pop_request']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $selectedCustomers = json_decode($_POST['selectedCustomers'], true);
        $updated_by = $_SESSION['uid'] ?? 0;
       
        $errors = [];
        $pop_id = isset($_POST['pop_id']) ? trim($_POST['pop_id']) : '';
        /* Validate Filds */
        if (empty($pop_id) && $pop_id !== '0') {
          $errors['pop_id'] = 'POP/Branch is required.';
        }
        /* If validation errors exist, return errors */
        if (!empty($errors)) {
            echo json_encode([
                'success' => false,
                'errors' => $errors,
            ]);
            exit();
        }
        /* Get Customer id, pop id,package id*/
        if (count($selectedCustomers) !== 0 && !empty($selectedCustomers)) {
            foreach ($selectedCustomers as $customer_id) {
                if ($get_customer_list = $con->query('SELECT * FROM customers WHERE id=' . $customer_id . ' ')) {
                    while ($rows = $get_customer_list->fetch_assoc()) {
                        $customer_id = $rows['id'];

                    }
                }
                $con->query("UPDATE customers SET pop = '$pop_id' WHERE id = '$customer_id'");
            }
            echo json_encode(['success' => true, 'message' => 'POP/Branch Changed successfully.']);
            exit();
        }
    }

    /************************** Customer Billing And Expire Section **************************/

    if (isset($_GET['import_file_data']) && $_SERVER['REQUEST_METHOD']=='POST' && !empty($_FILES['import_file_name']['name']) && $_FILES['import_file_name']['error'] == 0) {
        // if (isset($_FILES['import_file_name']) && $_FILES['import_file_name']['error'] == 0) {
        //     $fileName = $_FILES['import_file_name']['tmp_name'];
    
        //     if (($handle = fopen($fileName, 'r')) !== false) {
        //         /*Skip the header row*/ 
        //         fgetcsv($handle);
    
        //         while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        //             list(
        //                 $id, $user_type, $fullname, $username, $password, $package, $package_name,
        //                 $expiredate, $rchg_amount, $paid_amount, $balance_amount, $grace_days,
        //                 $grace_expired, $status, $mobile, $address, $pop, $area, $createdate,
        //                 $profile_pic, $nid, $con_charge, $price, $remarks
        //             ) = $data;
        //             /*Check if record already exists*/ 
        //             $checkStmt = $con->prepare("SELECT id FROM customers WHERE username = ? OR mobile = ?");
        //             $checkStmt->bind_param('ss', $username, $mobile);
        //             $checkStmt->execute();
        //             $checkStmt->store_result();
        //             if ($checkStmt->num_rows > 0) {
        //                 echo json_encode(['success' => false, 'message' => 'Duplicate entry found for username: "'.$username.'" or mobile: "'.$mobile.'"']);
        //                 exit();
        //             } else {

        //             }
        //             exit; 
        //             /* Prepare and execute the SQL insert statement*/
        //             $stmt = $con->prepare("INSERT INTO customers (
        //                 id, user_type, fullname, username, password, package, package_name,
        //                 expiredate, rchg_amount, paid_amount, balance_amount, grace_days,
        //                 grace_expired, status, mobile, address, pop, area, createdate,
        //                 profile_pic, nid, con_charge, price, remarks
        //             ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
        //             $stmt->bind_param(
        //                 'iisssissdddisissssssdsd',
        //                 $id, $user_type, $fullname, $username, $password, $package, $package_name,
        //                 $expiredate, $rchg_amount, $paid_amount, $balance_amount, $grace_days,
        //                 $grace_expired, $status, $mobile, $address, $pop, $area, $createdate,
        //                 $profile_pic, $nid, $con_charge, $price, $remarks
        //             );
    
        //             if (!$stmt->execute()) {
        //                 $response['errors'][] = "Error inserting row: " . $stmt->error;
        //             }
        //         }
    
        //         fclose($handle);
        //         echo json_encode(['success' => true, 'message' => 'Data imported successfully']);
        //         exit();
        //     } else {
        //         echo json_encode(['success' => false, 'message' => 'Failed to open the file.']);
        //         exit();
        //     }
        // } else {
        //     echo json_encode(['success' => false, 'message' => 'File upload error.']);
        //     exit();
        // }
        if (isset($_FILES['import_file_name']) && $_FILES['import_file_name']['error'] == 0) {
            $fileName = $_FILES['import_file_name']['name'];
            $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowed_ext = ['csv']; 
            if (in_array($file_ext, $allowed_ext)) {
                $inputFileNamePath  = $_FILES['import_file_name']['tmp_name'];
                if (($handle = fopen($inputFileNamePath, 'r')) !== false) {
                    $count = 0;
                    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                        if ($count > 0) { 
                            print_r($data); 
                            exit;
                        } else {
                            $count = 1; 
                        }
                    }
                }
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'File upload error.']);
            exit();
        }
    } 

    /************************** Customer Billing And Expire Section **************************/
    
    if (isset($_GET['customer_billing_request']) && !empty($_GET['customer_billing_request']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $customers = json_decode($_POST['customers'], true);
        $customer_billing_date = isset($_POST['customer_billing_date']) ? trim($_POST['customer_billing_date']) : '';

         /* Validate Filds */
         if (empty($customer_billing_date) && $customer_billing_date !== '0') {
             echo json_encode([
                 'success' => false,
                 'message' => 'Billing Date is required.',
             ]);
             exit();
          }
          if(count($customers) !== 0 && !empty($customers)) {
            foreach ($customers as $customer_id) {
                $expiredate = $con->query("SELECT `expiredate` FROM customers WHERE id = '$customer_id'")->fetch_assoc()['expiredate'];
                $year=''; 
                $month=""; 
                for($i=0; $i<4; $i++){
                    $year .= $expiredate[$i];
                }
                for($i=5; $i<7; $i++){
                    $month .= $expiredate[$i];
                }
                if($customer_billing_date !== '0'){
                    $new_expiredate = $year.'-'.$month.'-'.$customer_billing_date;
                    $con->query("UPDATE customers SET  expiredate = '$new_expiredate' WHERE id = '$customer_id'");
                }

            }
            
            echo json_encode([
                'success' => true,
                'message' => 'Billing Updated successfully.',
            ]);
            exit();
          }
    }
?>
