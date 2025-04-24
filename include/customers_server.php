<?php
if (!isset($_SESSION)) {
    session_start();
}
//date_default_timezone_set('Asia/Dhaka');
include 'db_connect.php';
include 'functions.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['delete'])) {
    $id = $_GET['id'];

    //$result=$con->query("DELETE FROM customers WHERE id=$id");

    if ($result == true) {
        echo 'Delete Success';
    } else {
        echo 'Error';
    }
}

//username check script///////
if (isset($_POST['current_username'])) {
    $UserInputUsername = $_POST['current_username'];

    $result = $con->query("SELECT * FROM customers WHERE username='$UserInputUsername' LIMIT 1");

    $count = mysqli_num_rows($result);

    if ($count > 0) {
        echo "(<span style='color:red'>User already taken</span>)";
        echo "<script>$('#customer_add').prop('disabled',true);</script>";
    } elseif ($count == 0 && $UserInputUsername != '') {
        echo "(<span style='color:green'>User available</span>)";
        echo "<script>$('#customer_add').prop('disabled',false);</script>";
    }
    exit();
}

//pop dependence area
if (isset($_POST['current_pop_name'])) {
    $popName = $_POST['current_pop_name'];
    echo '<option value="">---Select---</option>';
    //$result=$con->query("");
    if ($allArea = $con->query("SELECT * FROM `area_list` WHERE pop_id='$popName' ")) {
        while ($rowsssss = $allArea->fetch_array()) {
            $AreaName = $rowsssss['name'];
            $AreaID = $rowsssss['id'];
            echo '<option value=' . $AreaID . '>' . $AreaName . '</option>';
        }
    }
    exit();
}
/* Get Area Billing Cycle */
if (isset($_POST['get_billing_cycle'])) {
    $area_id = $_POST['area_id'];
    $response = '';
    $data = [];
    $allArea = $con->query("SELECT billing_date FROM `area_list` WHERE  id='$area_id'");
    if ($allArea->num_rows > 0) {
        while ($row = $allArea->fetch_array()) {
            if (!is_null($row['billing_date']) && $row['billing_date'] !== '') {
                $data[] = $row['billing_date'];
            }
        }
        for ($i = 1; $i <= 31; $i++) {
            $data[] = $i;
        }
    }

    if (empty($data)) {
        $exp_cstmr = $con->query('SELECT * FROM customer_expires');
        if ($exp_cstmr && $exp_cstmr->num_rows > 0) {
            while ($rowss = $exp_cstmr->fetch_array()) {
                $data[] = $rowss['days'];
            }
        }
        for ($i = 1; $i <= 31; $i++) {
            $data[] = $i;
        }
    }
    if (empty($data)) {
        $data[] = 'No Data Avaliable';
    }

    echo json_encode($data);
    exit();
}
/* Get Area House Building No. */
if (isset($_POST['get_house_building_no'])) {
    $area_id = $_POST['area_id'];
    $response = '';
    $condition = '';
    if (!empty($area_id) && $area_id > 0) {
        $condition = " WHERE area_id = '$area_id'";
    }
    $query = "SELECT * FROM `area_house` $condition";
    $allArea = $con->query($query);
    if ($allArea) {
        if ($allArea->num_rows > 0) {
            while ($row = $allArea->fetch_assoc()) {
                if (!empty($row['house_no'])) {
                    $response .= '<option value="' . $row['id'] . '">' . htmlspecialchars($row['house_no']) . '</option>';
                }
            }
        }

        if (empty($response)) {
            $response = '<option value="">No Data Available</option>';
        }
    } else {
        $response = '<option value="">Error fetching data</option>';
    }

    echo $response;
    exit();
}

/* Get Customer Last id  */
if (isset($_POST['get_customer_last_id'])) {
    $result = $con->query('SELECT * FROM customers ORDER BY id DESC LIMIT 1');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            echo $row['id'];
        }
    }
    exit();
}

/* Check Customer Online Offline  */
if (isset($_GET['check_customer_online_status']) && $_POST['check_customer_online_status']) {
    if (isset($_POST['username']) && !empty($_POST['username'])) {
        $username = $_POST['username'];
        $onlineusr = $con->query("SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username='$username'");
        $response = $onlineusr->num_rows > 0 ? 'Online' : 'Offline';
        echo $response;
        exit();
    }
}
/* Create  Customer Request */
if (isset($_GET['create_customer_request']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']);
    $mobile = trim($_POST['mobile']);
    $address = trim($_POST['address']);
    $area_id = intval($_POST['area_id']);
    $request_by = trim($_POST['request_by']);
    $remarks = trim($_POST['remarks']);
    if (empty($fullname) || empty($mobile) || empty($address)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }
    /* Insert data into the database*/
    $stmt = $con->prepare("INSERT INTO customer_request (fullname, mobile, address, area_id,req_date, request_by,remarks,status) VALUES (?, ?, ?, ?, NOW(),?,?,'0')");
    $stmt->bind_param('sssiss', $fullname, $mobile, $address, $area_id, $request_by, $remarks);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Customer request created successfully!']);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
        exit();
    }

    $stmt->close();
    exit();
}
if (isset($_GET['get_customer_request_data']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $customer_request_id = $_GET['id'];
    $stmt = $con->prepare('SELECT * FROM customer_request WHERE id=?');
    $stmt->bind_param('i', $customer_request_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['success' => true, 'data' => $row]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No data found!']);
    }

    $stmt->close();
    exit();
}

/* Update  Customer Request */
if (isset($_GET['update_customer_request']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $fullname = trim($_POST['fullname']);
    $mobile = trim($_POST['mobile']);
    $address = trim($_POST['address']);
    $area_id = intval($_POST['area_id']);
    $request_by = trim($_POST['request_by']);
    $remarks = trim($_POST['remarks']);
    if (empty($fullname) || empty($mobile) || empty($address)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }
    /* Update data into the database*/
    $stmt = $con->prepare('UPDATE customer_request SET fullname = ?, mobile = ?, address = ?, area_id = ?, request_by = ?, remarks = ? WHERE id = ?');
    $stmt->bind_param('sssissi', $fullname, $mobile, $address, $area_id, $request_by, $remarks, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Customer request updated successfully!']);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
        exit();
    }

    $stmt->close();
    exit();
}
/* Delete  Customer Request */
if (isset($_GET['delete_customer_request_data']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $stmt = $con->prepare('DELETE FROM customer_request WHERE id = ?');
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Deleted successfully!']);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
        exit();
    }

    $stmt->close();
    exit();
}
/* GET All Customer With Online Status */
if (isset($_GET['get_all_customer_with_online_status']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    /* Check if session is started */
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $condition = 'WHERE pop = ?';
    /* Set default pop_id value */
    $pop_id = 0;
    if (isset($_SESSION['user_pop']) && !empty($_SESSION['user_pop'])) {
        $pop_id = $_SESSION['user_pop'];
    }
    if ($pop_id == 0) {
        $condition = '';
    }

    /* Prepare the SQL query */
    $stmt = $con->prepare("SELECT id, username, fullname, mobile FROM customers $condition");
    if (!empty($Pop_id)) {
        $stmt->bind_param('i', $pop_id);
    }
    /* Execute the query */
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $customers = [];

        /* Fetch results */
        while ($row = $result->fetch_assoc()) {
            $username = $row['username'];
            $onlineusr = $con->query("SELECT * FROM radacct WHERE acctstoptime IS NULL AND username='$username'");
            $status = $onlineusr->num_rows == 1 ? 'online' : 'offline';

            $customers[] = [
                'id' => $row['id'],
                'fullname' => $row['fullname'],
                'username' => $row['username'],
                'mobile' => $row['mobile'],
                'status' => $status,
            ];
        }

        /* Return JSON response */
        echo json_encode(['success' => true, 'data' => $customers]);
    } else {
        /* If there's an error with the query */
        echo json_encode(['success' => false, 'message' => 'Error retrieving customer data']);
    }

    /* Close the statement */
    $stmt->close();
    exit();
}

//Area name by POP
if (isset($_POST['srch_pop_name'])) {
    $srch_pop_name = $_POST['srch_pop_name'];
    //$result=$con->query("");
    echo '<option value="all">All</option>';
    if ($allArea = $con->query("SELECT * FROM `area_list` WHERE pop_id='$srch_pop_name' ")) {
        while ($rowsssss = $allArea->fetch_array()) {
            $AreaName = $rowsssss['name'];
            $AreaID = $rowsssss['id'];
            echo '<option value=' . $AreaID . '>' . $AreaName . '</option>';
        }
    }
    exit();
}

//dynamic customer package when click pop/branch
if (isset($_POST['getCustomerPackage'])) {
    $popId = $_POST['pop_name'];
    if ($allArea = $con->query("SELECT * FROM branch_package WHERE  pop_id='$popId' ")) {
        echo '<option value="">---Select---</option>';
        while ($rows = $allArea->fetch_array()) {
            echo '<option value="' . $rows['id'] . '">' . $rows['package_name'] . '</option>';
        }
    }
    exit();
}
//package dynamic price
if (isset($_POST['getPackagePrice'])) {
    $packageId = $_POST['package_id'];
    $pop_id = $_POST['pop_id'];
    if ($allArea = $con->query("SELECT p_price FROM branch_package WHERE id='$packageId' AND pop_id=$pop_id   ")) {
        while ($rowsssss = $allArea->fetch_array()) {
            echo $rowsssss['p_price'];
        }
    }
    exit();
}

// ADD NEW CUSTOMER

if (isset($_POST['addCustomerData'])) {
    $customer_request_id = $_POST['customer_request_id'] ?? 0;
    $fullname = $_POST['fullname'];
    $package = $_POST['package'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    $exp_date = $_POST['expire_date'];
    $pop = $_POST['pop'];
    $area = $_POST['area'];
    $area_house_id = is_numeric($_POST['customer_houseno']) ? intval($_POST['customer_houseno']) : '0';
    $address = $_POST['address'];
    $nid = $_POST['nid'];
    $con_charge = $_POST['con_charge'];
    $price = $_POST['price'];
    $remarks = $_POST['remarks'];
    $liablities = $_POST['liablities'];
    $status = $_POST['status'];
    $user_type = $_POST['user_type'];
    $con_type = $_POST['customer_connection_type'] ?? 'ONU';
    $send_message = $_POST['send_message'] ?? 0;
    
    // One month from a specific date
    $exp_date = date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m-' . $exp_date))));

    if ($allPack = $con->query("SELECT * FROM branch_package WHERE id=$package AND pop_id=$pop")) {
        while ($rowssss = $allPack->fetch_array()) {
            $package_name = $rowssss['package_name'];
            $package_purchase_price = $rowssss['p_price'];
            $package_sales_price = $rowssss['s_price'];
        }
    }
    /*Check Pop Current  Blance */
    $pop_amount = $con->query("SELECT SUM(amount) AS pop_amount FROM pop_transaction WHERE pop_id='$pop' AND transaction_type !='5'")->fetch_array()['pop_amount'] ?? 0;

    $total_paid = $con->query("SELECT SUM(purchase_price) AS total_paid FROM customer_rechrg WHERE pop_id='$pop' AND type!='4'")->fetch_array()['total_paid'] ?? 0;

    $_Pop_balance = $pop_amount - $total_paid;

    if ($package_purchase_price > $_Pop_balance) {
        echo "Insufficiant balance!
        Please Recharge POP/Branch ";
    } else {
        $result = $con->query("INSERT INTO customers(user_type,fullname,username,password,package,package_name,expiredate,status,mobile,address,pop,area,area_house_id,createdate,profile_pic,nid,con_charge,price,remarks,liablities,rchg_amount,paid_amount,balance_amount,con_type) VALUES('$user_type','$fullname','$username','$password','$package','$package_name','$exp_date','$status','$mobile','$address','$pop','$area','$area_house_id',NOW(),'avatar.png','$nid','$con_charge','$price','$remarks','$liablities','$price','$price', '0','$con_type')");

        if ($result == true) {
            $custID = $con->insert_id;
            $recharge_by = isset($_SESSION['uid']) ? intval($_SESSION['uid']) : 0;
            $con->query("INSERT INTO customer_rechrg(customer_id, pop_id,months, sales_price, purchase_price,discount,ref,rchrg_until,type,rchg_by,datetm) 
          VALUES('$custID','$pop','1','$package_sales_price','$package_purchase_price','0.00', 'On Connection', '$exp_date','1','$recharge_by',NOW())");
            echo 1;
        } else {
            echo 'Problem Is : ' . $con->error;
        }
        /*Change the customer Reqeust status*/
        if ($customer_request_id > 0) {
            $con->query("UPDATE customer_request SET status='1' WHERE id='$customer_request_id'");
        }
        $con->query("INSERT INTO radcheck(username,attribute,op,value) VALUES('$username','Cleartext-Password',':=','$password')");
        $con->query("INSERT INTO radreply(username,attribute,op,value) VALUES('$username','MikroTik-Group',':=','$package_name')");
        /*Send Message To the Customer */
        /*Send Message To the Customer */
        if($send_message == 1) {
            $bill_payment_link = "https://sr-wifi.net?clid={$custID}";

            $message = 'Thank you for joining SR Wi-Fi.
                        Your Customer ID : {customer_id}
                        username : {username}
                        password : {password}
                        HelpLine : 01821600600
                        Bill payment link: {bill_payment_link}';

            $message = str_replace('{customer_id}', $custID, $message);
            $message = str_replace('{username}', $username, $message);
            $message = str_replace('{password}', $password, $message);
            $message = str_replace('{bill_payment_link}', $bill_payment_link, $message);

            send_message($mobile, $message);
        }
    }
    /*send Notification*/
    // try {
    //     send_notification("".$fullname." New Customer Added", '<i class="fas fa-user"></i>', "http://103.146.16.154/profile.php?clid=".$custID, 'unread');
    // } catch (Exception $e) {
    //     error_log('Error in sending notification: '.$e->getMessage());
    // }
    exit();
}
//get specifik customer package and display frontend
if (isset($_POST['getCustomerSpecificId'])) {
    $id = $_POST['id'];
    if ($cstmr = $con->query("SELECT * FROM customers WHERE id=$id")) {
        while ($rows = $cstmr->fetch_array()) {
            $package_name = $rows['package_name'];
            echo '<option value="">' . $package_name . '</option>';
        }
    }
    exit();
}
//get specifik customer package and display frontend
if (isset($_POST['getCustomerPackagePrice'])) {
    $id = $_POST['id'];
    if ($cstmr = $con->query("SELECT * FROM customers WHERE id=$id")) {
        while ($rows = $cstmr->fetch_array()) {
            echo $rows['price'];
        }
    }
    exit();
}
//get specifik customer package and display frontend
if (isset($_POST['getCustomerPop'])) {
    $id = $_POST['id'];
    if ($cstmr = $con->query("SELECT * FROM customers WHERE id=$id")) {
        while ($rows = $cstmr->fetch_array()) {
            echo $popId = $rows['pop'];
        }
    }
    exit();
}

// Password Change
if (isset($_POST['updateCustomerData'])) {
    $customer_id = $_POST['customer_id'];
    $username = $_POST['customer_username'];
    $password = $_POST['customer_password'];

    if ($Customerinfo = $con->query("SELECT * FROM customers WHERE id='$customer_id' ")) {
        while ($rowcmrinf = $Customerinfo->fetch_array()) {
            //$cmrPOPid = $rowcmr['pop'];
            $CustomerUserName = $rowcmrinf['username'];
        }
    }

    $result = $con->query("UPDATE customers SET  username='$username', password='$password' WHERE id='$customer_id'");
    if ($result == true) {
        // UPDATE redcheck
        $con->query("UPDATE radcheck SET value='$password', username='$username' WHERE username='$CustomerUserName'");
        // UPDATE radreplay
        $con->query("UPDATE radreply SET username='$username' WHERE username='$CustomerUserName'");
        echo 1;
    } else {
        echo 'Error:' . $con->error;
    }
    exit();
}
/*Customer Remarks Update*/
if (isset($_POST['update_customer_remarks_data'])) {
    $customer_id = $_POST['customer_id'];
    $remarks = $_POST['customer_remarks'];

    $con->query("UPDATE customers SET  remarks='$remarks' WHERE id='$customer_id'");
    echo json_encode([
        'success'=>true,
        'message'=>'Update Successfully',
    ]);
    exit();
}

if (isset($_POST['pwdmissname']) && !empty($_POST['pwdmissname'])) {
    $pwdmissname = $_POST['pwdmissname'];
    $pwdtry = $_POST['pwdtry'];

    $con->query("UPDATE customers SET password='$pwdtry' WHERE username='$pwdmissname'");
    $con->query("UPDATE radcheck SET value='$pwdtry' WHERE username='$pwdmissname'");
    exit();
}

if (isset($_POST['area_id'])) {
    $popID = $_POST['area_id'];

    // Fetch customer based on area_id
    $query = 'SELECT * FROM customers WHERE area = ?';
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $popID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<option>---Select---</option>';
        echo '<option value="all">All</option>';
        while ($row = $result->fetch_assoc()) {
            echo ' <option value="' . $row['id'] . '">[' . $row['id'] . '] - ' . $row['username'] . ' || ' . $row['fullname'] . ', (' . $row['mobile'] . ')</option>';
        }
    } else {
        echo '<option>No Customers found</option>';
    }

    $stmt->close();
    $con->close();
    exit();
}

if (isset($_POST['get_customer_phone_number'])) {
    $customerID = $_POST['get_customer_phone_number'];

    // Fetch customer phone number
    $query = 'SELECT * FROM customers WHERE id = ?';
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $customerID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row['mobile'];
        }
    }

    $stmt->close();
    $con->close();
    exit();
}

if (isset($_GET['update_customer']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // echo '<pre>';
    // print_r($_POST);

    // echo '</pre>';exit;
    $customer_id = $_POST['customer_id'] ?? 0;
    $fullname = $_POST['fullname'];
    $package = $_POST['package'];
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $mobile = $_POST['mobile'];
    $billing_date = $_POST['billing_date'];
    $pop = $_POST['pop'];
    $area = $_POST['area'];
    $area_house_id = is_numeric($_POST['customer_houseno']) ? intval($_POST['customer_houseno']) : '0';
    $address = $_POST['address'];
    $nid = $_POST['nid'];
    $con_charge = $_POST['con_charge'];
    $price = $_POST['price'];
    $remarks = $_POST['remarks'];
    $liablities = $_POST['liablities'];
    $status = $_POST['status'];
    $user_type = $_POST['user_type'];
    $con_type = $_POST['customer_connection_type'];

    /*GET Package Name*/
    $package_name = $con->query("SELECT package_name FROM branch_package WHERE id='$package'")->fetch_array()['package_name'];
    /*Check Expire Date */
    if ($billing_date > 0) {
        $get_customer_expire_date = $con->query("SELECT expiredate FROM customers WHERE id='$customer_id'")->fetch_array()['expiredate'];
        $year = '';
        $month = '';

        for ($i = 0; $i < strlen($get_customer_expire_date); $i++) {
            if ($i < 4) {
                $year .= $get_customer_expire_date[$i];
            } elseif ($i > 4 && $i < 7) {
                $month .= $get_customer_expire_date[$i];
            }
        }
        $new_expire_date = $year . '-' . $month . '-' . $billing_date;
    }
    $result = $con->query("UPDATE `customers` SET `user_type`='$user_type',`fullname`='$fullname',`username`='$username',`password`='$password',`package`='$package',`package_name`='$package_name',`expiredate`='$new_expire_date',`status`='$status',`mobile`='$mobile',`address`='$address',`pop`='$pop',`area`='$area',`area_house_id`='$area_house_id',`nid`='$nid',`con_charge`='$con_charge',`price`='$price',`remarks`='$remarks',`liablities`='$liablities' , `con_type`='$con_type' WHERE id=$customer_id");
    if ($result) {
        /*Update radcheck*/
        if ($con->query("SELECT * FROM radcheck WHERE username='$username'")->num_rows > 0) {
            $con->query("UPDATE radcheck SET value='$password' WHERE username='$username'");
        } else {
            $con->query("INSERT INTO radcheck(username, attribute, op, value) VALUES('$username', 'Cleartext-Password', ':=', '$password')");
        }

        /* Update radreply */
        if ($con->query("SELECT * FROM radreply WHERE username='$username'")->num_rows > 0) {
            $con->query("UPDATE radreply SET value='$package_name' WHERE username='$username'");
        } else {
            $con->query("INSERT INTO radreply(username, attribute, op, value) VALUES('$username', 'MikroTik-Group', ':=', '$package_name')");
        }

        echo json_encode(['success' => true, 'message' => 'Customer updated successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $con->error]);
    }
    exit();
}

if (isset($_GET['get_all_expire_customer_ids'])) {
    $query = 'SELECT id FROM customers WHERE expiredate<NOW()';
    $result = mysqli_query($con, $query);
    $ids = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $ids[] = $row['id'];
    }
    echo implode(',', $ids);
    /* Stop the script*/
    exit; 
}

if (isset($_GET['fetch_bandwith_data']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    require '../routeros/routeros_api.class.php';
    $username = $_GET['username'];
  
    $onlineusr = $con->query("SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username='$username'");
    $onlineusr->num_rows;

    // NAS Info
    $rowacct = $onlineusr->fetch_assoc();
    $nasipaddress = $rowacct['nasipaddress'] ?? '';
    
    $CNRT = $con->query("SELECT * FROM nas WHERE nasname='$nasipaddress' LIMIT 1");
    while ($nas_rows = $CNRT->fetch_array()) {
        $NASname = $nas_rows['shortname'];
        $nasname = $nas_rows['nasname'];
        $api_usr = $nas_rows['api_user'];
        $api_pswd = $nas_rows['api_password'];
        $api_server = $nas_rows['api_ip'];
        $api_port = $nas_rows['ports'];
        
    }
   
    $API = new RouterosAPI();
    if (!$API->connect($api_server, $api_usr, $api_pswd, $api_port)) {
        echo json_encode(['error' => 'Unable to connect to the router']);
        exit;
        $API->write('/interface/monitor-traffic', false);
        $API->write('=interface=ether1', false);
        $API->write('=once=', true);
        $response = $API->read();
        $API->disconnect();
        if (!empty($response)) {
            $download = round($response[0]['rx-bits-per-second'] / 1024 / 1024, 2);
            $upload = round($response[0]['tx-bits-per-second'] / 1024 / 1024, 2);

            echo json_encode([
                'time' => date('H:i:s'),
                'download' => $download,
                'upload' => $upload,
            ]);
        } else {
            echo json_encode(['error' => 'No data received']);
        }
    }
    exit;
}
?>
