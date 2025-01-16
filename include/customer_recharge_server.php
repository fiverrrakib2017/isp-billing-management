<?php
if (empty($_SESSION)) {
    session_start();
}

include 'db_connect.php';

if (isset($_GET['add_customer_recharge']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedCustomers = json_decode($_POST['selectedCustomers'], true);
    $recharge_by = $_SESSION['uid'] ?? 0;
    $RefNo = $_POST['RefNo'];

    $errors = [];
    $chrg_mnths = isset($_POST['month']) ? trim($_POST['month']) : '';
    $tra_type = isset($_POST['tra_type']) ? trim($_POST['tra_type']) : '';
    /* Validate Filds */
    if (empty($chrg_mnths) && $chrg_mnths !== '0') {
      $errors['chrg_mnths'] = 'Month is required.';
    }
    if ($tra_type === '') {
      $errors['tra_type'] = 'Transaction Type is required.';
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
                    $pop_id = $rows['pop'];
                }
            }
        }
        if (isset($customer_id) && !empty($customer_id) && isset($pop_id) && !empty($pop_id) && isset($chrg_mnths) && !empty($chrg_mnths) && isset($tra_type) ) {
            /* Calculate pop balance AND Customer Recharge balance in this pop*/
            $_pop_balance = 0;
            $_recharge_balance = 0;
            /*Calculate POP Balance*/
            if ($pop_payment = $con->query('SELECT SUM(`amount`) AS pop_balance FROM `pop_transaction` where pop_id=' . $pop_id . ' ')) {
                while ($rows = $pop_payment->fetch_assoc()) {
                    $_pop_balance = $rows['pop_balance'];
                }
            }
            /*Calculate Recharge Balance*/
            if ($customer_recharge = $con->query('SELECT SUM(`purchase_price`) AS recharge_balance FROM `customer_rechrg` where pop_id=' . $pop_id . ' ')) {
                while ($rows = $customer_recharge->fetch_assoc()) {
                    $_recharge_balance = $rows['recharge_balance'];
                }
            }
            /*Calculate Current Balance*/
            if (!empty($_pop_balance) && isset($_pop_balance) && !empty($_recharge_balance) && isset($_recharge_balance)) {
                $_current_pop_balance = $_pop_balance - $_recharge_balance;
            }
            foreach ($selectedCustomers as $customer_id) {
                /*****************GET Package Price*************************/
                $package_id = null;
                if ($get_all_customer = $con->query("SELECT * from customers WHERE id=$customer_id")) {
                    while ($rows = $get_all_customer->fetch_assoc()) {
                        $package_id = $rows['package'];
                        $package = $rows['package_name'];
                        $expiredDate = $rows['expiredate'];
                        $username = $rows['username'];
                        $password = $rows['password'];
                        $pop_id = $rows['pop'];
                        //$customer_package_price = $rows['price'];
                    }
                }
                /****************GET package purchase sales price******************************/
                $package_sales_price = null;
              

                if ($get_all_customer = $con->query("SELECT s_price , p_price from branch_package WHERE pkg_id=$package_id AND pop_id=$pop_id")) {
                    while ($rows = $get_all_customer->fetch_assoc()) {
                        $package_sales_price = $rows['s_price'];
                        $customer_package_price = $rows['p_price'];
                    }
                }
                $package_purchase_price = $customer_package_price * intval($chrg_mnths);
                //echo $package_purchase_price; exit; 

                if (!empty($package_sales_price) && isset($package_sales_price) && !empty($package_purchase_price) && isset($package_purchase_price)) {
                    /***********Ensure sufficient balance ************/
                    if ($package_purchase_price > $_current_pop_balance) {
                        echo json_encode(['success' => false, 'message' => 'Please Recharge This POP/Branch. <br>This POP Avaiable Balance is ' . $_current_pop_balance]);
                        exit();
                    }
                }

                /*Calculate new expiry date*/
                if (!empty($expiredDate) && isset($expiredDate) && !empty($chrg_mnths) && isset($chrg_mnths)) {
                    $today = date('Y-m-d');
                    if ($expiredDate > $today) {
                        $exp_date = date('Y-m-d', strtotime("+$chrg_mnths month", strtotime($expiredDate)));
                    } else {
                        $exp_date = date('Y-m-d', strtotime("+$chrg_mnths month", strtotime($today)));
                    }
                    /*Insert Recharge Data*/
                    $con->query("INSERT INTO customer_rechrg(customer_id, pop_id, months, sales_price, purchase_price,discount, ref, rchrg_until, type, rchg_by, datetm) VALUES('$customer_id', '$pop_id', '$chrg_mnths', '$package_sales_price', '$package_purchase_price','0.00', '$RefNo', '$exp_date', '$tra_type', '$recharge_by', NOW())");

                    $con -> query("INSERT INTO radcheck(username,attribute,op,value) VALUES('$username','Cleartext-Password',':=','$password')");
                    $con -> query("INSERT INTO radreply(username,attribute,op,value) VALUES('$username','MikroTik-Group',':=','$package')");

                    /*Update Customer New Balance AND Expire Date */
                    $_customer_total_paid_amount = 0;
                    $_customer_total_due_amount = 0;
                    $_customer_total_recharge_amount = 0;
                    /**** Get Customer total paid amount *************/
                    if ($customer_total_paid_amount = $con->query("SELECT SUM(`purchase_price`) as customer_total_paid_amount FROM customer_rechrg WHERE customer_id='$customer_id' AND type!='0'")) {
                        while ($rows = $customer_total_paid_amount->fetch_assoc()) {
                            $_customer_total_paid_amount = $rows['customer_total_paid_amount'];
                        }
                    }

                    /**** Get Customer total Due amount *************/
                    if ($customer_total_due_amount = $con->query("SELECT SUM(`purchase_price`) as customer_total_due_amount FROM customer_rechrg WHERE customer_id='$customer_id' AND type='0'")) {
                        while ($rows = $customer_total_due_amount->fetch_assoc()) {
                            $_customer_total_due_amount = $rows['customer_total_due_amount'];
                        }
                    }

                    /**** Get Customer total Recharge amount *************/
                    if ($customer_total_recharge_amount = $con->query("SELECT SUM(`purchase_price`) as customer_total_recharge_amount FROM customer_rechrg WHERE customer_id='$customer_id' AND type !='4'")) {
                        while ($rows = $customer_total_recharge_amount->fetch_assoc()) {
                            $_customer_total_recharge_amount = $rows['customer_total_recharge_amount'];
                        }
                    }

                    /**** Get Customer Defference Balance *************/
                    if (!empty($_customer_total_paid_amount) && isset($_customer_total_paid_amount) && !empty($_customer_total_recharge_amount) && isset($_customer_total_recharge_amount)) {
                        $_balance_amount = $_customer_total_recharge_amount - $_customer_total_paid_amount;

                        $con->query("UPDATE customers SET expiredate='$exp_date', status='1', rchg_amount='$_customer_total_recharge_amount', paid_amount='$_customer_total_paid_amount', balance_amount='$_balance_amount' WHERE id='$customer_id'");
                    }
                }
            }
            echo json_encode(['success' => true, 'message' => 'Recharges processed successfully.']);
            $con->close();
        }
    }
    exit; 
}

/***************************** Cash Received ************************************/

if (isset($_GET['cash_received']) && !empty($_GET['cash_received']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
  $selectedCustomers = json_decode($_POST['selectedCustomers'], true);
  $recharge_by = $_SESSION['uid'] ?? 0;

  $errors = [];
  $received_amount = isset($_POST['received_amount']) ? trim($_POST['received_amount']) : '';
  $received_tra_type = isset($_POST['received_tra_type']) ? trim($_POST['received_tra_type']) : '';
  $received_remarks = isset($_POST['received_remarks']) ? trim($_POST['received_remarks']) : 'Default';
 
  /* Validate Fields */
  if (!isset($received_amount) || !is_numeric($received_amount) || $received_amount < 0) {
      $errors['received_amount'] = 'Valid amount is required.';
  }
  if (!isset($received_tra_type)) {
      $errors['received_tra_type'] = 'Transaction Type is required.';
  }

  if (!empty($errors)) {
      echo json_encode([
          'success' => false,
          'errors' => $errors,
      ]);
      exit();
  }
 
  /* Process each selected customer */
  if (count($selectedCustomers) !== 0 && !empty($selectedCustomers)) {
      foreach ($selectedCustomers as $customer_id) {
          // Fetch customer details
          $get_customer_list = $con->query("SELECT * FROM customers WHERE id = $customer_id");
          $customer_data = $get_customer_list->fetch_assoc();
          /* Skip if customer not found*/
          if (!$customer_data) continue; 
          
          $pop_id = $customer_data['pop'];
         

          /* Calculate total due and total recharge for the customer */
          $result_due = $con->query("SELECT SUM(purchase_price) as customer_total_due_amount FROM customer_rechrg WHERE customer_id = $customer_id AND type ='0' ");
          $_customer_total_due_amount = $result_due->fetch_assoc()['customer_total_due_amount'] ?? 0;
          
          $result_recharge = $con->query("SELECT SUM(purchase_price) as customer_total_recharge_amount FROM customer_rechrg WHERE customer_id = $customer_id AND type != '4' ");
          $_customer_total_recharge_amount = $result_recharge->fetch_assoc()['customer_total_recharge_amount'] ?? 0;
         
          /* Check for overpayment */
          if ($_customer_total_due_amount > 0 && $_customer_total_due_amount < $received_amount) {
              echo json_encode(['success' => false, 'message' => 'Over Payment Not Allowed!']);
              exit();
          }
        
          /* Insert Recharge Data */
          $result = $con->query("INSERT INTO `customer_rechrg`( `customer_id`, `pop_id`, `months`, `sales_price`, `purchase_price`,`discount`, `ref`, `rchrg_until`, `type`, `rchg_by`, `datetm`, `status`) VALUES ('$customer_id', '$pop_id', '0', '0', '$received_amount', '0.00', '$received_remarks', '2023-06-02', '4', '$recharge_by',  NOW() , '0')"); 
          if ($result) {
              /* Update Customer Balance */
              $result_paid = $con->query("SELECT SUM(purchase_price) as customer_total_paid_amount FROM customer_rechrg WHERE customer_id = $customer_id AND type != '0' ");
              $_customer_total_paid_amount = $result_paid->fetch_assoc()['customer_total_paid_amount'] ?? 0;

              $_balance_amount = $_customer_total_recharge_amount - $_customer_total_paid_amount;

              $con->query("UPDATE customers SET rchg_amount = '$_customer_total_recharge_amount', paid_amount = '$_customer_total_paid_amount', balance_amount = '$_balance_amount' WHERE id = $customer_id");

              echo json_encode(['success' => true, 'message' => 'Cash Received Completed.']);
          }
      }
      $con->close();
  }
}


if (isset($_POST['add_recharge_data'])) {
    $customer_id = $_POST['customer_id'];
    $chrg_mnths = $_POST['month'];
    $package_purchase_price = $_POST['amount'];
    $pop_id = $_POST['pop_id'];
    $recharge_by = $_SESSION['uid'];
    $RefNo = $_POST['RefNo'];
    $tra_type = $_POST['tra_type'];

    /* Initialize variables*/
    $packageId = null;
    $_price = 0;

    //how to get customer package of customers table
    if ($allCstmr = $con->query("SELECT * FROM customers WHERE id=$customer_id")) {
        while ($rows = $allCstmr->fetch_array()) {
            $packageId = $rows['package'];
            $_price = $rows['price'];
        }
    }
     
    /*Get DISCOUNT Amount*/
    if (!empty($chrg_mnths) && isset($chrg_mnths) && !empty($package_purchase_price) && isset($package_purchase_price)) {
        $main_amount=$chrg_mnths * $_price;
        $discount_amount=$main_amount - $package_purchase_price ?? 0;
    }
    
    //get customer sale's price
    if ($allPackg = $con->query("SELECT * FROM branch_package WHERE id=$packageId")) {
        while ($rows = $allPackg->fetch_array()) {
            $package_sales_price = $rows['s_price'];
        }
    }
    //পপ এর বেলেন্স চেক করে রিচারজ করবো ,
    if ($pop_payment = $con->query("SELECT SUM(`amount`) AS balance FROM `pop_transaction` WHERE pop_id='$pop_id' ")) {
        while ($rows = $pop_payment->fetch_array()) {
            $popBalance = $rows['balance'];
        }
        if ($customer_recharge = $con->query(" SELECT SUM(`purchase_price`) AS amount FROM `customer_rechrg` WHERE pop_id='$pop_id' ")) {
            while ($rows = $customer_recharge->fetch_array()) {
                $rechargeBalance = $rows['amount'];
            }
        }
        $totalCurrentBal = $popBalance - $rechargeBalance;
    }

    if ($package_purchase_price > $totalCurrentBal) {
        echo 'Please Recharge This Pop/Branch';
    } else {
        if ($cstmr = $con->query("SELECT * FROM customers WHERE id='$customer_id'")) {
            while ($rows = $cstmr->fetch_array()) {
                $lstid = $rows['id'];
                $package = $rows['package'];
                $package_name = $rows['package_name'];
                $username = $rows['username'];

                $expiredDate = $rows['expiredate'];
            }
        }

        if ($expiredDate < date('Y-m-d')) {
            $exp_date = date('Y-m-d', strtotime('+' . $chrg_mnths . ' month', strtotime(date('Y-m-' . date('d', strtotime($expiredDate))))));
        } else {
            // Increase recharge monthe from current expired date
            $exp_date = date('Y-m-d', strtotime('+' . $chrg_mnths . ' month', strtotime($expiredDate)));
        }
        
        $con->query("INSERT INTO customer_rechrg(customer_id,pop_id,months,sales_price,purchase_price,discount,ref,rchrg_until,type,rchg_by,datetm) VALUES('$customer_id','$pop_id','$chrg_mnths','$package_sales_price','$main_amount','$discount_amount','$RefNo','$exp_date','$tra_type','$recharge_by',NOW())");

        $con->query("UPDATE radreply SET value='$package_name' WHERE username='$username'");
        // Total Paid amount
        if ($ttlpdamt = $con->query("SELECT SUM(purchase_price) AS TotalPaidAmt FROM customer_rechrg WHERE customer_id='$customer_id' AND type!='0'")) {
            while ($rowspd = $ttlpdamt->fetch_array()) {
                $TotalPaidAmt = $rowspd['TotalPaidAmt'];
            }
        }
        // Total recharged Credit amount
        if ($ttlduamt = $con->query("SELECT SUM(purchase_price) AS TotaldueAmt FROM customer_rechrg WHERE customer_id='$customer_id' AND type='0'")) {
            while ($rowsdu = $ttlduamt->fetch_array()) {
                $TotaldueAmt = $rowsdu['TotaldueAmt'];
            }
        }

        // Total Recharged Amount
        if ($ttlrchgmt = $con->query("SELECT SUM(purchase_price) AS TotalrchgAmt FROM customer_rechrg WHERE customer_id='$customer_id' AND type!='4'")) {
            while ($rowrch = $ttlrchgmt->fetch_array()) {
                $TotalrchgAmt = $rowrch['TotalrchgAmt'];
            }
        }
        $balanceamount = $TotalrchgAmt - $TotalPaidAmt;
        $con->query("UPDATE customers SET expiredate='$exp_date', status='1', rchg_amount='$TotalrchgAmt', paid_amount='$TotalPaidAmt', balance_amount='$balanceamount' WHERE id='$customer_id'");

        $con -> query("INSERT INTO radcheck(username,attribute,op,value) VALUES('$username','Cleartext-Password',':=','$password')");
        $con -> query("INSERT INTO radreply(username,attribute,op,value) VALUES('$username','MikroTik-Group',':=','$package')");
        echo 1;
        $con->close();
    }
}
if (isset($_POST['addCustomerDuePayment'])) {
    $customer_id = $_POST['customer_id'];
    $amount = $_POST['amount'];
    $pop_id = $_POST['pop_id'];
    $remarks = $_POST['remarks'];
    $transaction_type = 4;
    $date = date('Y-m-d');
    $recharge_by = $_SESSION['uid'];

    $result = $con->query("INSERT INTO `customer_rechrg` (`id`, `customer_id`, `pop_id`, `months`, `sales_price`,`purchase_price`,`discount`, `ref`, `rchrg_until`, `type`, `rchg_by`, `datetm`) VALUES (NULL, '$customer_id', '$pop_id', '', '00','$amount','0.00', '$remarks', '2023-06-02', '$transaction_type', '$recharge_by', '$date');");
    if ($result == true) {
        // Total Paid amount
        if ($ttlpdamt = $con->query("SELECT SUM(purchase_price) AS TotalPaidAmt FROM customer_rechrg WHERE customer_id='$customer_id' AND type!='0'")) {
            while ($rowspd = $ttlpdamt->fetch_array()) {
                $TotalPaidAmt = $rowspd['TotalPaidAmt'];
            }
        }
        // Total recharged Credit amount
        if ($ttlduamt = $con->query("SELECT SUM(purchase_price) AS TotaldueAmt FROM customer_rechrg WHERE customer_id='$customer_id' AND type='0'")) {
            while ($rowsdu = $ttlduamt->fetch_array()) {
                $TotaldueAmt = $rowsdu['TotaldueAmt'];
            }
        }

        // Total Recharged Amount
        if ($ttlrchgmt = $con->query("SELECT SUM(purchase_price) AS TotalrchgAmt FROM customer_rechrg WHERE customer_id='$customer_id' AND type!='4'")) {
            while ($rowrch = $ttlrchgmt->fetch_array()) {
                $TotalrchgAmt = $rowrch['TotalrchgAmt'];
            }
        }

        $balanceamount = $TotalrchgAmt - $TotalPaidAmt;
        $con->query("UPDATE customers SET rchg_amount='$TotalrchgAmt', paid_amount='$TotalPaidAmt', balance_amount='$balanceamount' WHERE id='$customer_id'");

        echo 1;
    } else {
        echo $con->error;
    }

    $con->close();
    exit; 
}

// Temporary recharge ######
if (isset($_POST['customer_temp_recharge'])) {
    $customer_id = $_POST['customer_id'];
    $pop_id = $_POST['pop_id'];
    $days = $_POST['days'];
    $RefNo = $_POST['RefNo'];
    $transaction_type = $_POST['transaction_type'];
    if ($cstmr = $con->query("SELECT * FROM customers WHERE id='$customer_id' AND pop=$pop_id")) {
        while ($rows = $cstmr->fetch_array()) {
            $username = $rows['username'];
            $expiredDate = $rows['expiredate'];
            $package = $rows['package'];
            $package_name = $rows['package_name'];
        }
    }

    //$new_date = date("Y-m-d", strtotime($expiredDate . " + $days days"));
    $new_date = date('Y-m-d', strtotime(date('Y-m-d') . " + $days days"));
    $result = $con->query("UPDATE customers SET grace_days='$days', grace_expired='$new_date' WHERE id='$customer_id'");
    if ($result == true) {
        // Enabling the customer profile and status
        if ($con->query("SELECT * FROM customers WHERE grace_expired>=NOW() AND id='$customer_id'")) {
            $con->query("UPDATE radreply SET value='$package_name' WHERE username='$username'");
            $con->query("UPDATE customers SET status='1' WHERE id='$customer_id'");
        }
        echo 1;
    } else {
        echo 0;
    }
    $con->close();
    exit; 
}

if (isset($_POST['undo_customer_recharge'])) {
    $rechargeID = $_POST['rechargeID'];

    if ($rchg = $con->query("SELECT * FROM customer_rechrg WHERE id='$rechargeID'")) {
        while ($rowsrch = $rchg->fetch_array()) {
            $rchrg_until = $rowsrch['rchrg_until'];
            $customer_id = $rowsrch['customer_id'];
            $months = $rowsrch['months'];
        }
    }

    if ($cstmr = $con->query("SELECT * FROM customers WHERE id='$customer_id'")) {
        while ($rows = $cstmr->fetch_array()) {
            $expiredDate = $rows['expiredate'];
        }
    }

    // Month Difrent
    $newDate = strtotime($rchrg_until . ' -' . $months . ' months');
    $newDate = date('Y-m-d', $newDate);

    // Delete Recharge
    $con->query("DELETE FROM customer_rechrg WHERE id='$rechargeID'");

    //$new_date = date("Y-m-d", strtotime($expiredDate . " + $days days"));
    $result = $con->query("UPDATE customers SET expiredate='$newDate', remarks='$newDate' WHERE id='$customer_id'");
    if ($result == true) {
        echo 1;
    } else {
        echo 0;
    }
    $con->close();
    exit; 
}


if (isset($_GET['get_recharge_data']) && $_SERVER['REQUEST_METHOD']=='GET') {
    require 'datatable.php';

    $table = 'customer_rechrg';
    $primaryKey = 'id';
    $columns = array(
        array(
            'db' => 'id', 
            'dt' => 0,
            
        ),
        array(
            'db'        => 'datetm',
            'dt'        => 1,
            'formatter' => function($d, $row) use ($con) {
                return date('d-m-Y', strtotime($d));
            }
        ),
        array('db' => 'customer_id', 
            'dt' => 2,
            'formatter' => function($d, $row) use ($con) {
                $customer_id = $d;
                $allCustomer = $con->query("SELECT fullname FROM customers WHERE id=$customer_id");
                $row = $allCustomer->fetch_array();
                return $row['fullname'];
            }

        ),
        array('db' => 'months', 'dt' => 3),
        
        array('db' => 'rchrg_until', 'dt' => 4),
        array('db' => 'purchase_price', 'dt' => 5),
      
    );
    $condition="";

    if (!empty($_SESSION['user_pop'])) {
        $condition = "pop_id = '" . $_SESSION['user_pop'] . "'";
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
        $condition .= (!empty($condition) ? " AND " : ""). "pop_id = '" . $_GET['pop_id'] . "'";
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
            $condition .= (!empty($condition) ? " AND " : "") . "customers.status = '" . $status . "' 
                            AND NOT EXISTS (
                                SELECT 1 FROM radacct 
                                WHERE radacct.username = customers.username 
                                AND radacct.acctstoptime IS NOT NULL
                            )";
        } else {
            $condition .= (!empty($condition) ? " AND " : "") . "customers.status = '" . $status . "'";
        }
    }
    /* Output JSON for DataTables to handle*/
    echo json_encode(
        SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $condition)
    );
}




 /************** Customer Recharge With Bkash Payment Method ***************/

if(isset($_GET['customer_recharge_with_payment_getway']) && !empty($_GET['customer_recharge_with_payment_getway'])){
   $customer_id= $_GET['customer_id'];
    $customer_amount=$con->query("SELECT price From `customers` WHERE id=$customer_id")->fetch_assoc()['price']; 
    $pop_id=$con->query("SELECT pop From `customers` WHERE id=$customer_id")->fetch_assoc()['pop']; 
     
    include 'Service/Bkash_payment_service.php';
    include 'Config.php';
     
    $callback_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $callback_url .= $_SERVER['HTTP_HOST'] . '/self.php?clid='.$customer_id.'';
    
    $bk=new BkashPaymentService($config);
    $idToken = $bk->getGrantToken();
    $bk->createPayment( $idToken,$callback_url, $customer_amount, '12345');
    
    if(!empty($idToken) && isset($idToken)){
        /* Create Payment*/
        $_payment_response = $bk->createPayment( $idToken,$callback_url, $customer_amount, '12345');
        if (!empty($_payment_response['paymentID']) && !empty($_payment_response['statusMessage']) && $_payment_response['statusMessage'] === 'Successful') {
            if (isset($_payment_response['bkashURL'])) {      
                 header("Location: " . $_payment_response['bkashURL']);
                exit;
            } else {
                echo "Error creating payment.";
            }
        } 
    }else{
        echo json_encode([
            'success'=>false,
            'message'=>'Error Generate Token',
        ]);
    }
    exit; 
}
 /************** Show Credit Recharge List ***************/
 if (isset($_GET['get_credit_recharge_list']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : null;
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : null;

    $whereClause = '';
    if ($from_date && $to_date) {
        $whereClause = " AND cr.daterm BETWEEN '$from_date' AND '$to_date'";
    } elseif ($from_date) {
        $whereClause = " AND cr.daterm >= '$from_date'";
    } elseif ($to_date) {
        $whereClause = " AND cr.daterm <= '$to_date'";
    }

    $query = "
        SELECT 
            c.id AS customer_id, 
            c.username, 
            MAX(u.fullname) AS fullname,
            c.mobile, 
            COALESCE(SUM(CASE WHEN cr.type != '4' THEN cr.purchase_price ELSE 0 END), 0) AS total_recharge,
            COALESCE(SUM(CASE WHEN cr.type != '0' THEN cr.purchase_price ELSE 0 END), 0) AS total_paid,
            (COALESCE(SUM(CASE WHEN cr.type != '4' THEN cr.purchase_price ELSE 0 END), 0) - 
            COALESCE(SUM(CASE WHEN cr.type != '0' THEN cr.purchase_price ELSE 0 END), 0)) AS total_due,
            COALESCE(SUM(CASE WHEN cr.type = '4' THEN cr.purchase_price ELSE 0 END), 0) AS total_due_paid
        FROM 
            customers c
        LEFT JOIN 
            customer_rechrg cr ON c.id = cr.customer_id
        LEFT JOIN 
            users u ON cr.rchg_by = u.id
        WHERE 
            1=1 $whereClause
        GROUP BY 
            c.id, c.username, c.mobile 
        HAVING 
            total_due > 0;
    ";

    $result = $con->query($query);

    $response = ['rows' => '', 'footer' => '', 'total_due_sum' => 0];

    if ($result->num_rows > 0) {
        $total_due_sum = 0;
        while ($row = $result->fetch_assoc()) {
            $total_due_sum += $row['total_due'];
            $response['rows'] .= "<tr>
                <td><a href='profile.php?clid={$row['customer_id']}'>{$row['username']}</a></td>
                <td>{$row['mobile']}</td>
                <td>{$row['total_recharge']}</td>
                <td>{$row['total_paid']}</td>
                <td>{$row['total_due']}</td>
                <td>{$row['fullname']}</td>
            </tr>";
        }

        $response['footer'] = "<tr>
            <td colspan='4'><strong>Total Due</strong></td>
            <td class='text-danger'><strong>{$total_due_sum}</strong></td>
            <td></td>
        </tr>";
        $response['total_due_sum'] = $total_due_sum;
    } else {
        $response['rows'] = "<tr><td colspan='6'>No customers with due amounts found</td></tr>";
    }

    echo json_encode($response);
}

?>



