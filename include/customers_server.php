<?php
session_start();
//date_default_timezone_set('Asia/Dhaka');
include "db_connect.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['delete'])) {
    $id = $_GET['id'];

    //$result=$con->query("DELETE FROM customers WHERE id=$id");

    if ($result == true) {
        echo  "Delete Success";
    } else {
        echo  "Error";
    }
}

// EDIT CUSTOMER
if (isset($_POST['updateCustomer'])) {
    $lstid = $_POST['id'];
    $fullname = $_POST['fullname'];
    $area = $_POST['area'];
    $package = $_POST['package'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $nid = $_POST['nid'];
    $remarks = $_POST['remarks'];
    $connection_charge = $_POST['connection_charge'];
    $expiredate = $_POST['expiredate'];

    
	
	
	// Branch Package

    if ($allArea = $con->query("SELECT * FROM customers WHERE id='$lstid' ")) {
        while ($rowcmr = $allArea->fetch_array()) {
            $cmrPOPid = $rowcmr['pop'];
			$CustomerUserName = $rowcmr['username'];
        }
    }

    if ($pkgnm = $con->query("SELECT * FROM branch_package WHERE id='$package'")) {

        while ($rowspkg = $pkgnm->fetch_array()) {
             $package_name = $rowspkg['package_name']; 
        }
    }
/**/
    $result = $con->query("UPDATE customers SET fullname='$fullname', username='$username', password='$password', package='$package', mobile='$mobile', address='$address', area='$area', nid='$nid', remarks='$remarks', con_charge='$connection_charge',expiredate='$expiredate'  WHERE id='$lstid'");
    // UPDATE redcheck
	$con->query("UPDATE radcheck SET value='$password', username='$username' WHERE username='$CustomerUserName'");
	// UPDATE radreplay
	$con->query("UPDATE radreply SET value='$package_name', username='$username' WHERE username='$CustomerUserName'");
    if ($result == true) {
        echo  1;
    } else {
        echo 0;
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
    } else if ($count == 0 && $UserInputUsername != "") {

        echo "(<span style='color:green'>User available</span>)";
        echo "<script>$('#customer_add').prop('disabled',false);</script>";
    }
}

//pop dependence area
if (isset($_POST['current_pop_name'])) {
    $popName = $_POST['current_pop_name'];
    //$result=$con->query("");
    if ($allArea = $con->query("SELECT * FROM `area_list` WHERE pop_id='$popName' ")) {
        while ($rowsssss = $allArea->fetch_array()) {
            $AreaName = $rowsssss['name'];
            $AreaID = $rowsssss['id'];
            echo '<option value=' . $AreaID . '>' . $AreaName . '</option>';
        }
    }
}
/* Get Area Billing Cycle */
if (isset($_POST['get_billing_cycle'])) {
    $area_id = $_POST['area_id'];
    $response = '';
    $data=[];
    $allArea = $con->query("SELECT billing_date FROM `area_list` WHERE  id='$area_id'");
    if ($allArea->num_rows > 0) {
        while ($row = $allArea->fetch_array()) {
            if(!is_null($row['billing_date']) && $row['billing_date'] !==''){
                $data[] = $row['billing_date'];
            }
        }
    }
    
    if(empty($data)){
        $exp_cstmr = $con->query('SELECT * FROM customer_expires');
        if ($exp_cstmr && $exp_cstmr->num_rows > 0) {
            while ($rowss = $exp_cstmr->fetch_array()) {
                $data[] = $rowss['days'];
            }
        }
    }
    if(empty($data)){
        $data[] = "No Data Avaliable";
    }

    echo json_encode($data);
    exit;
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
    exit;
}


/* Get Customer Last id  */
if(isset($_POST['get_customer_last_id'])){
    $result=$con->query("SELECT * FROM customers ORDER BY id DESC LIMIT 1");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            echo $row['id'];
        }
    }
    exit; 
}

/* Check Customer Online Offline  */
if(isset($_GET['check_customer_online_status']) && $_POST['check_customer_online_status']){
    if(isset($_POST['username']) && !empty($_POST['username'])){
        $username = $_POST['username'];
        $onlineusr = $con->query("SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username='$username'");
        $response = $onlineusr->num_rows > 0 ? 'Online' : 'Offline';
        echo $response;
        exit; 
    }
   
}
/* Create  Customer Request */
if(isset($_GET['create_customer_request']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $fullname = trim($_POST['fullname']);
    $mobile = trim($_POST['mobile']);
    $address = trim($_POST['address']);
    $area_id = intval($_POST['area_id']);
    $request_by = trim($_POST['request_by']);
    if (empty($fullname) || empty($mobile) || empty($address)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }
    /* Insert data into the database*/
    $stmt = $con->prepare("INSERT INTO customer_request (fullname, mobile, address, area_id,req_date, request_by,status) VALUES (?, ?, ?, ?, NOW(),?,'0')");
    $stmt->bind_param('sssis', $fullname, $mobile, $address, $area_id, $request_by);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Customer request created successfully!']);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
        exit;
    }

    $stmt->close();
    exit; 
}
/* Delete  Customer Request */
if(isset($_GET['delete_customer_request_data']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = intval($_POST['id']);
    $stmt = $con->prepare("DELETE FROM customer_request WHERE id = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Deleted successfully!']);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
        exit;
    }

    $stmt->close();
    exit;
}
/* GET All Customer With Online Status */
if (isset($_GET['get_all_customer_with_online_status']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    /* Check if session is started */
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    /* Set default pop_id value */
    $pop_id = 1;
    if (isset($_SESSION['user_pop']) && !empty($_SESSION['user_pop'])) {
        $pop_id = $_SESSION['user_pop'];
    }

    /* Prepare the SQL query */
    $stmt = $con->prepare("SELECT id, username, fullname, mobile FROM customers WHERE pop = ?");
    $stmt->bind_param('i', $pop_id);

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
                'status' => $status
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
    exit;
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
            echo '<option value='.$AreaID.'>'. $AreaName .'</option>';
        }
    }
}

//dynamic customer package when click pop/branch
if (isset($_POST['getCustomerPackage'])) {
    echo '<option value="">Select</option>';
    $popId = $_POST['pop_name'];
    if ($allArea = $con->query("SELECT * FROM branch_package WHERE  pop_id='$popId' ")) {

        while ($rows = $allArea->fetch_array()) {
            echo '<option value="' . $rows['pkg_id'] . '">' . $rows['package_name'] . '</option>';
        }
    }
}
//package dynamic price
if (isset($_POST['getPackagePrice'])) {
    $packageId = $_POST['package_id'];
    $pop_id = $_POST['pop_id'];
    if ($allArea = $con->query("SELECT s_price FROM branch_package WHERE pkg_id='$packageId' AND pop_id=$pop_id   ")) {
        while ($rowsssss = $allArea->fetch_array()) {
            echo $rowsssss['s_price'];
        }
    }
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
    //$chrg_mnths = "5";
    // One month from a specific date
    $exp_date = date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m-' . $exp_date))));
    //$exp_date = date('Y-m-d', strtotime('+'.$chrg_mnths.' month', strtotime(date('Y-m-'.$exp_date))));

    //প্যাকেজ এর  আইডি থেকে এর নেম টা বের করে ডাটাবেজ টেবিল এ দিয়ে দিবো , ব্যাস খাতাম , 
    if ($allPack = $con->query("SELECT * FROM branch_package WHERE id=$package")) {
        while ($rowssss = $allPack->fetch_array()) {
            $package_name = $rowssss['package_name'];
            $package_purchase_price = $rowssss['p_price'];
            $package_sales_price = $rowssss['s_price'];
        }
    }

    /*Check Pop Blance */
    if ($pop_payment = $con->query("SELECT SUM(`amount`) AS balance FROM `pop_transaction` WHERE pop_id='$pop' ")) {
        while ($rows = $pop_payment->fetch_array()) {
            $popBalance = $rows["balance"];
        }
        if ($customer_recharge = $con->query(" SELECT SUM(`purchase_price`) AS amount FROM `customer_rechrg` WHERE pop_id='$pop' ")) {
            while ($rows = $customer_recharge->fetch_array()) {
                $rechargeBalance = $rows["amount"];
            }
        }
        $totalCurrentBal = $popBalance - $rechargeBalance;
    }

    if ($package_purchase_price > $totalCurrentBal) {
        echo "Insufficiant balance!
        Please Recharge POP/Branch ";
    } else {

    $result = $con->query("INSERT INTO customers(user_type,fullname,username,password,package,package_name,expiredate,status,mobile,address,pop,area,area_house_id,createdate,profile_pic,nid,con_charge,price,remarks,liablities,rchg_amount,paid_amount,balance_amount) VALUES('$user_type','$fullname','$username','$password','$package','$package_name','$exp_date','$status','$mobile','$address','$pop','$area','$area_house_id',NOW(),'avatar.png','$nid','$con_charge','$price','$remarks','$liablities','$price','$price', '0')");
    /*Change the customer Reqeust status*/
    if($customer_request_id > 0){
        $con->query("UPDATE customer_request SET status='1' WHERE id='$customer_request_id'");
    }
    if ($result == true) {

        //Update account recharge and transection
        $custID = $con->insert_id;
        $recharge_by=isset($_SESSION["uid"]) ? intval($_SESSION["uid"]) : 0;
        $con->query("INSERT INTO customer_rechrg(customer_id, pop_id,months, sales_price, purchase_price,discount,ref,rchrg_until,type,rchg_by,datetm) 
          VALUES('$custID','$pop','1','$package_sales_price','$package_purchase_price','0.00', 'On Connection', '$exp_date','1','$recharge_by',NOW())");
        echo 1;
    } else {
        echo "Problem Is : " . $con->error;
    }
    $con->query("INSERT INTO radcheck(username,attribute,op,value) VALUES('$username','Cleartext-Password',':=','$password')");
    $con->query("INSERT INTO radreply(username,attribute,op,value) VALUES('$username','MikroTik-Group',':=','$package_name')");
    }
}
//get specifik customer package and display frontend 
if (isset($_POST['getCustomerSpecificId'])) {
    $id = $_POST['id'];
    if ($cstmr = $con->query("SELECT * FROM customers WHERE id=$id")) {
        while ($rows = $cstmr->fetch_array()) {
            $package_name = $rows['package_name'];
            echo '<option value="">' . $package_name . '</option>';
        }
        // if($allPackage=$con->query("SELECT * FROM radgroupcheck where id=$packageId")){
        //     //echo '<option value="'.$row['id'].'">'.$row['groupname'].'</option>';
        //         while($row=$allPackage->fetch_array()){
        //             echo '<option value="'.$row['id'].'">'.$row['groupname'].'</option>'; 
        //         }
        //     } 

    }
}
//get specifik customer package and display frontend 
if (isset($_POST['getCustomerPackagePrice'])) {
    $id = $_POST['id'];
    if ($cstmr = $con->query("SELECT * FROM customers WHERE id=$id")) {
        while ($rows = $cstmr->fetch_array()) {
            echo $rows['price'];
        }
    }
}
//get specifik customer package and display frontend 
if (isset($_POST['getCustomerPop'])) {
    $id = $_POST['id'];
    if ($cstmr = $con->query("SELECT * FROM customers WHERE id=$id")) {
        while ($rows = $cstmr->fetch_array()) {
            echo   $popId = $rows['pop'];
        }
    }
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
        echo  1;
    } else {
        echo "Error:" . $con->error;
    }
}

if (isset($_POST['pwdmissname']) && !empty($_POST['pwdmissname'])) {
    $pwdmissname = $_POST['pwdmissname'];
    $pwdtry = $_POST['pwdtry'];
    
    $con->query("UPDATE customers SET password='$pwdtry' WHERE username='$pwdmissname'");
    $con->query("UPDATE radcheck SET value='$pwdtry' WHERE username='$pwdmissname'");
   
}


if(isset($_POST['area_id'])){
    $popID = $_POST['area_id'];
    
    // Fetch customer based on area_id
    $query = "SELECT * FROM customers WHERE area = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $popID);
    $stmt->execute();
    $result = $stmt->get_result();
  
    if($result->num_rows > 0){
        echo '<option>---Select---</option>';
        echo '<option value="all">All</option>';
        while($row = $result->fetch_assoc()){
            echo ' <option value="'.$row['id'].'">['.$row['id'].'] - '.$row['username'].' || '.$row['fullname'].', ('.$row['mobile'].')</option>';
        }
    } else {
        echo '<option>No Customers found</option>';
    }
  
    $stmt->close();
    $con->close();
  }

if(isset($_POST['get_customer_phone_number'])){
    $customerID = $_POST['get_customer_phone_number'];
    
    // Fetch customer phone number 
    $query = "SELECT * FROM customers WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();
  
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo $row['mobile'];
        }
    } else {
        
    }
  
    $stmt->close();
    $con->close();
  }

  
  
//   if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['send_message']) {
//         echo 'okkkk'; exit; 
//         if (isset($_POST['customer_ids']) && !empty($_POST['customer_ids'])) {
//             $customerIds = $_POST['customer_ids'];
//             $message = $_POST['message'];

//             // Assuming you have a function to send messages
//             foreach ($customerIds as $id) {
//                 // Fetch customer's mobile number or any other details you need
//                 $query = "SELECT mobile FROM customers WHERE id = $id";
//                 $result = mysqli_query($con, $query);
//                 if ($result && mysqli_num_rows($result) > 0) {
//                     $customer = mysqli_fetch_assoc($result);
//                     $mobileNumber = $customer['mobile'];

//                     // Here you can integrate your SMS API or any other messaging service
//                     // sendSMS($mobileNumber, $message);
                    
//                     // For demonstration, we'll just echo the mobile number and message
//                     echo "Message sent to: " . $mobileNumber . " - Message: " . $message . "<br>";
//                 }
//             }
//         } else {
//             echo "No customer selected or message is empty.";
//         }
//     }


    if (isset($_GET['get_all_expire_customer_ids'])) {
        $query = "SELECT id FROM customers WHERE expiredate<NOW()";
        $result = mysqli_query($con, $query);
        $ids = [];
        while($row = mysqli_fetch_assoc($result)) {
            $ids[] = $row['id'];
        }
        echo implode(",", $ids); 
    }
?>
 

