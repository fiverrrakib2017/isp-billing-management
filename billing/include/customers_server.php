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
    $result = $con->query("UPDATE customers SET fullname='$fullname', username='$username', password='$password', package='$package', mobile='$mobile', address='$address', area='$area', nid='$nid', remarks='$remarks', con_charge='$connection_charge'  WHERE id='$lstid'");
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

//Area name by POP
if (isset($_POST['srch_pop_name'])) {
    $srch_pop_name = $_POST['srch_pop_name'];
    //$result=$con->query("");
	//echo '<option value='all'>'All'</option>';
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
    $fullname = $_POST['fullname'];
    $package = $_POST['package'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    $exp_date = $_POST['expire_date'];
    $pop = $_POST['pop'];
    $area = $_POST['area'];
    $address = $_POST['address'];
    $nid = $_POST['nid'];
    $con_charge = $_POST['con_charge'];
    $price = $_POST['price'];
    $remarks = $_POST['remarks'];
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

    //পপ এর বেলেন্স চেক করে রিচারজ করবো , 
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

    $result = $con->query("INSERT INTO customers(user_type,fullname,username,password,package,package_name,expiredate,status,mobile,address,pop,area,createdate,profile_pic,nid,con_charge,price,remarks,rchg_amount,paid_amount,balance_amount) VALUES('$user_type','$fullname','$username','$password','$package','$package_name','$exp_date','$status','$mobile','$address','$pop','$area',NOW(),'avatar.png','$nid','$con_charge','$price','$remarks','$price','$price', '0')");
    if ($result == true) {

        //Update account recharge and transection
        $custID = $con->insert_id;
        $recharge_by=$_SESSION['username'];
        $con->query("INSERT INTO customer_rechrg(customer_id, pop_id,months, sales_price, purchase_price,ref,rchrg_until,type,rchg_by,datetm) 
          VALUES('$custID','$pop','1','$package_sales_price','$package_purchase_price', 'On Connection', '$exp_date','1','$recharge_by',NOW())");
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





?>
 

