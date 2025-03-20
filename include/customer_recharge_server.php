<?php
if (empty($_SESSION)) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', '1');
include 'db_connect.php';
$TotalrchgAmt = 0;
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

    // Bulk Recharge
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
        if (isset($customer_id) && !empty($customer_id) && isset($pop_id) && !empty($pop_id) && isset($chrg_mnths) && !empty($chrg_mnths) && isset($tra_type)) {
            /* Calculate pop balance AND Customer Recharge balance in this pop*/
            $_pop_balance = 0;
            $_recharge_balance = 0;
            /*Calculate POP Balance*/
            if ($pop_payment = $con->query('SELECT SUM(amount) AS pop_balance FROM pop_transaction where pop_id=' . $pop_id . ' ')) {
                while ($rows = $pop_payment->fetch_assoc()) {
                    $_pop_balance = $rows['pop_balance'];
                }
            }
            /*Calculate Recharge Balance*/
            if ($customer_recharge = $con->query('SELECT SUM(purchase_price) AS recharge_balance FROM customer_rechrg WHERE pop_id=' . $pop_id . ' ')) {
                while ($rows = $customer_recharge->fetch_assoc()) {
                    $_recharge_balance = $rows['recharge_balance'];
                }
            }
            /*Calculate Current Balance*/
            if (!empty($_pop_balance) && isset($_pop_balance) && !empty($_recharge_balance) && isset($_recharge_balance)) {
                $_current_pop_balance = $_pop_balance - $_recharge_balance;
            }

            // Finding each selected customer
            foreach ($selectedCustomers as $customer_id) {
                /*****************GET Package Price*************************/
                $package_id = null;
                if ($get_all_customer = $con->query("SELECT * from customers WHERE id=$customer_id")) {
                    while ($rows = $get_all_customer->fetch_assoc()) {
                        $package_id = $rows['package'];
                        $package_name = $rows['package_name'];
                        $expiredDate = $rows['expiredate'];
                        $username = $rows['username'];
                        $password = $rows['password'];
                        $pop_id = $rows['pop'];
                        //$customer_package_price = $rows['price'];
                    }
                }
                /****************GET package purchase sales price******************************/
                $package_sales_price = null;

                if ($get_all_customer = $con->query("SELECT s_price, p_price FROM branch_package WHERE id=$package_id AND pop_id=$pop_id")) {
                    while ($rows = $get_all_customer->fetch_assoc()) {
                        $package_sales_price = $rows['s_price'];
                        $customer_package_price = $rows['p_price'];
                    }
                }
                $package_purchase_price = $customer_package_price * intval($chrg_mnths);

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
                    $con->query("INSERT INTO customer_rechrg(customer_id, pop_id, months, sales_price, purchase_price, discount, ref, rchrg_until, type, rchg_by, datetm) VALUES('$customer_id', '$pop_id', '$chrg_mnths', '$package_sales_price', '$package_purchase_price','0.00', '$RefNo', '$exp_date', '$tra_type', '$recharge_by', NOW())");

                    $con->query("UPDATE radreply SET value='$package_name' WHERE username='$username'");

                    /*Update Customer New Balance AND Expire Date */
                    $_customer_total_paid_amount = 0;
                    $_customer_total_due_amount = 0;
                    $_customer_total_recharge_amount = 0;
                    /**** Get Customer total paid amount *************/
                    if ($customer_total_paid_amount = $con->query("SELECT SUM(purchase_price) as customer_total_paid_amount FROM customer_rechrg WHERE customer_id='$customer_id' AND type!='0'")) {
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
    exit();
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

    /*Get Customer information*/
    if ($allCstmr = $con->query("SELECT * FROM customers WHERE id=$customer_id")) {
        while ($rows = $allCstmr->fetch_array()) {
            $packageId = $rows['package'];
            $_price = $rows['price'];
            $pop_id = $rows['pop'];
        }
    }

    /*Get DISCOUNT Amount*/
    if (!empty($chrg_mnths) && isset($chrg_mnths) && !empty($package_purchase_price) && isset($package_purchase_price)) {
        $main_amount = $chrg_mnths * $_price;
        $discount_amount = $main_amount - $package_purchase_price ?? 0;
    }

    //get customer sale's price [Use id for package id]
    if ($allPackg = $con->query("SELECT s_price, p_price FROM branch_package WHERE id=$packageId AND pop_id=$pop_id LIMIT 1")) {
        while ($rows = $allPackg->fetch_array()) {
            $package_sales_price = $rows['s_price'];
        }
    }

    /*Check POP Blance*/
    if ($pop_payment = $con->query("SELECT SUM(amount) AS balance FROM pop_transaction WHERE pop_id='$pop_id' ")) {
        while ($rows = $pop_payment->fetch_array()) {
            $popBalance = $rows['balance'];
        }
        if ($customer_recharge = $con->query("SELECT SUM(purchase_price) AS amount FROM customer_rechrg WHERE pop_id='$pop_id'")) {
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

        //$con->query("UPDATE radreply SET value='$package_name' WHERE username='$username'");
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

        $con->query("UPDATE radreply SET value='$package_name' WHERE username='$username'");
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
    exit();
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
    exit();
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
    exit();
}

if (isset($_GET['get_recharge_data']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    require 'datatable.php';

    $table = 'customer_rechrg';
    $primaryKey = 'id';
    $columns = [
        [
            'db' => 'id',
            'dt' => 0,
        ],
        [
            'db' => 'datetm',
            'dt' => 1,
            'formatter' => function ($d, $row) {
                return date('d-m-Y', strtotime($d));
            },
        ],
        [
            'db' => 'customer_id',
            'dt' => 2,
            'formatter' => function ($d, $row) use ($con) {
                $allCustomer = $con->query("SELECT username FROM customers WHERE id = $d");
                $row = $allCustomer->fetch_array();
                $username = $row['username'];
                $onlineusr = $con->query("SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username = '$username'");
                $chkc = $onlineusr->num_rows;
                $status = $chkc == 1 ? '<abbr title="Online"><img src="images/icon/online.png" height="10" width="10"/></abbr>' : '<abbr title="Offline"><img src="images/icon/offline.png" height="10" width="10"/></abbr>';
                return $status . ' <a href="profile.php?clid=' . $d . '">' . $username . '</a>';
            },
        ],
        [
            'db' => 'months',
            'dt' => 3,
            'formatter' => function ($d, $row) {
                if (empty($d)) {
                    return 'N/A';
                }
                return $d;
            },
        ],
        [
            'db' => 'type',
            'dt' => 4,
            'formatter' => function ($d, $row) {
                switch ($d) {
                    case '0':
                        return '<span class="badge bg-danger">Credit</span>';
                    case '1':
                        return '<span class="badge bg-success">Cash</span>';
                    case '2':
                        return '<span class="badge bg-info">Bkash</span>';
                    case '3':
                        return '<span class="badge bg-info">Nagad</span>';
                    case '4':
                        return '<span class="badge bg-warning">Due Paid</span>';
                    default:
                        return '';
                }
            },
        ],
        ['db' => 'rchrg_until', 'dt' => 5],
        ['db' => 'purchase_price', 'dt' => 6],
    ];

    $condition = '';

    if (!empty($_SESSION['user_pop'])) {
        $condition .= "pop_id = '" . $_SESSION['user_pop'] . "'";
    }

    if (isset($_GET['area_id']) && !empty($_GET['area_id'])) {
        $condition .= (!empty($condition) ? ' AND ' : '') . "area = '" . $_GET['area_id'] . "'";
    }

    if (isset($_GET['pop_id']) && !empty($_GET['pop_id'])) {
        $condition .= (!empty($condition) ? ' AND ' : '') . "pop_id = '" . $_GET['pop_id'] . "'";
    }

    if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
        $from_date = date('Y-m-d 00:00:00', strtotime($_GET['from_date']));
        $to_date = date('Y-m-d 23:59:59', strtotime($_GET['to_date']));
        $condition .= (!empty($condition) ? ' AND ' : '') . "datetm BETWEEN '$from_date' AND '$to_date'";
    }

    if (!empty($_GET['type']) && $_GET['type'] !== '---Select Type---') {
        $type = $_GET['type'];
        if ($type == 'Credit') {
            $condition .= (!empty($condition) ? ' AND ' : '') . "type = '0'";
        } elseif (in_array($type, ['1', '2', '3', '4'])) {
            $condition .= (!empty($condition) ? ' AND ' : '') . "type = '$type'";
        }
    }
    /*Total Amount Initial Value*/
    $totalAmount = '';
    if (isset($_GET['bill_collect']) && $_GET['bill_collect'] > 0) {
        $condition .= (!empty($condition) ? ' AND ' : '') . "rchg_by = '" . $_GET['bill_collect'] . "'";

        $totalAmount = get_total_amount($table, $condition . " AND type != '0'", $con);

        if (!empty($_GET['type']) && $_GET['type'] !== '---Select Type---') {
            $type = $_GET['type'];

            if ($type == 'Credit') {
                $totalAmount = get_total_amount($table, $condition, $con);
            }
        }
    } else {
        $totalAmount = get_total_amount($table, $condition, $con);
    }

    $response = SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $condition);
    $response['totalAmount'] = number_format((float) $totalAmount, 2, '.', '');

    echo json_encode($response);
    exit();
}

/************** Customer Recharge With Bkash Payment Method ***************/

if (isset($_GET['customer_recharge_with_payment_getway']) && !empty($_GET['customer_recharge_with_payment_getway'])) {
    $customer_id = $_GET['customer_id'];
    $customer_amount = $con->query("SELECT price From `customers` WHERE id=$customer_id")->fetch_assoc()['price'];
    $pop_id = $con->query("SELECT pop From `customers` WHERE id=$customer_id")->fetch_assoc()['pop'];

    include 'Service/Bkash_payment_service.php';
    include 'Config.php';

    $callback_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $callback_url .= $_SERVER['HTTP_HOST'] . '/self.php?clid=' . $customer_id . '';

    $bk = new BkashPaymentService($config);
    $idToken = $bk->getGrantToken();
    $bk->createPayment($idToken, $callback_url, $customer_amount, '12345');

    if (!empty($idToken) && isset($idToken)) {
        /* Create Payment*/
        $_payment_response = $bk->createPayment($idToken, $callback_url, $customer_amount, '12345');
        if (!empty($_payment_response['paymentID']) && !empty($_payment_response['statusMessage']) && $_payment_response['statusMessage'] === 'Successful') {
            if (isset($_payment_response['bkashURL'])) {
                header('Location: ' . $_payment_response['bkashURL']);
                exit();
            } else {
                echo 'Error creating payment.';
            }
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error Generate Token',
        ]);
    }
    exit();
}
/************** Customer Recharge With SSL Commerce Payment Method ***************/

if (isset($_GET['customer_recharge_with_ssl_payment_getway']) && !empty($_GET['customer_recharge_with_ssl_payment_getway'])) {
    $customer_id = $_GET['customer_id'];
    $customer_amount = $con->query("SELECT price From `customers` WHERE id=$customer_id")->fetch_assoc()['price'];
    $pop_id = $con->query("SELECT pop From `customers` WHERE id=$customer_id")->fetch_assoc()['pop'];

    include 'Service/ssl_payment_service.php';
    include 'Config.php';

    $callback_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $callback_url .= $_SERVER['HTTP_HOST'] . '/self.php?clid=' . $customer_id . '';

    $object = new SSLCommercePaymentService($ssl_commerce_config);

    $result = $object->create_payment($customer_amount);

    if (!empty($result) && isset($result)) {
        if (isset($result['GatewayPageURL'])) {
            header('Location: ' . $result['GatewayPageURL']);
            exit();
        } else {
            echo 'Error creating payment.';
        }
    }
    exit();
}
/************** Show Credit Recharge List ***************/
if (isset($_GET['get_credit_recharge_list']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : null;
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : null;

    $whereClause = '';
    if ($from_date && $to_date) {
        $whereClause = " AND cr.datetm BETWEEN '$from_date' AND '$to_date'";
    } elseif ($from_date) {
        $whereClause = " AND cr.datetm >= '$from_date'";
    } elseif ($to_date) {
        $whereClause = " AND cr.datetm <= '$to_date'";
    }

    $result = $con->query("SELECT 
    c.id AS customer_id, 
    c.username, 
    MAX(u.fullname) AS fullname,
    c.mobile, 
    cr.datetm,
    GROUP_CONCAT(DISTINCT cr.months ORDER BY cr.rchrg_until DESC SEPARATOR ', ') AS due_months,
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
    total_due > 0");

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
                <td>{$row['due_months']}</td>
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
    exit();
}

function get_total_amount($table, $condition, $con)
{
    $totalQuery = "SELECT SUM(purchase_price) as total FROM $table " . (!empty($condition) ? " WHERE $condition" : '');
    $totalResult = $con->query($totalQuery);
    $totalRow = $totalResult->fetch_assoc();
    return $totalRow['total'] ?? 0;
}

if (isset($_GET['get_customer_billing_report']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    require 'datatable.php';

    $table = 'customers';
    $primaryKey = 'id';
    /* Get Selected Month & Year */
    $fromMonth = isset($_GET['from_month']) ? $_GET['from_month'] : date('m');
    $selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');

    $selectedYear = intval($selectedYear);
    $_data = $selectedYear . '-' . $fromMonth;

    $total_target_query = $con->query('SELECT SUM(price) AS total_target FROM customers');
    $total_target = $total_target_query->fetch_array()['total_target'] ?? 0;

    /*Get TOTAL Collection Amount*/
    $total_collection_query = $con->query("SELECT SUM(purchase_price) AS total_collection FROM customer_rechrg WHERE DATE_FORMAT(datetm, '%Y-%m') BETWEEN '$_data' AND '$_data'");
    $total_collection = $total_collection_query->fetch_array()['total_collection'] ?? 0;

    $columns = [
        [
            'db' => 'id',
            'dt' => 0,
        ],

        [
            'db' => 'id',
            'dt' => 1,
            'formatter' => function ($d, $row) use ($con) {
                $allCustomer = $con->query("SELECT username FROM customers WHERE id = $d");
                $row = $allCustomer->fetch_array();
                $username = $row['username'];
                $onlineusr = $con->query("SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username = '$username'");
                $chkc = $onlineusr->num_rows;
                $status = $chkc == 1 ? '<abbr title="Online"><img src="images/icon/online.png" height="10" width="10"/></abbr>' : '<abbr title="Offline"><img src="images/icon/offline.png" height="10" width="10"/></abbr>';
                return $status . ' <a href="profile.php?clid=' . $d . '">' . $username . '</a>';
            },
        ],
        [
            'db' => 'price',
            'dt' => 2,
            'formatter' => function ($d, $row) {
                if (empty($d)) {
                    return 'N/A';
                }
                return $d;
            },
        ],
        [
            'db' => 'id',
            'dt' => 3,
            'formatter' => function ($d, $row) use ($con, $fromMonth, $selectedYear) {
                $selectedYear = intval($selectedYear);
                $data = $selectedYear . '-' . $fromMonth;
                $amount = $con->query("SELECT SUM(purchase_price) AS total_collection FROM customer_rechrg WHERE customer_id = '$d' AND DATE_FORMAT(datetm, '%Y-%m') BETWEEN '$data' AND '$data'")->fetch_array()['total_collection'];
                return $amount;
            },
        ],
    ];

    $condition = '';

    if (!empty($_SESSION['user_pop'])) {
        $condition .= "pop_id = '" . $_SESSION['user_pop'] . "'";
    }

    if (isset($_GET['area_id']) && !empty($_GET['area_id'])) {
        $condition .= (!empty($condition) ? ' AND ' : '') . "area = '" . $_GET['area_id'] . "'";
    }

    if (isset($_GET['pop_id']) && !empty($_GET['pop_id'])) {
        $condition .= (!empty($condition) ? ' AND ' : '') . "pop_id = '" . $_GET['pop_id'] . "'";
    }

    if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
        $from_date = date('Y-m-d 00:00:00', strtotime($_GET['from_date']));
        $to_date = date('Y-m-d 23:59:59', strtotime($_GET['to_date']));
        $condition .= (!empty($condition) ? ' AND ' : '') . "datetm BETWEEN '$from_date' AND '$to_date'";
    }

    $data = SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $condition);
    $data['total_target_amount'] = number_format($total_target, 2);
    $data['total_collection_amount'] = number_format($total_collection, 2);
    echo json_encode($data);
    exit();
}

?>
