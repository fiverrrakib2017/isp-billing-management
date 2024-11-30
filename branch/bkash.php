<?php
/*install Process*/
$callbackURL = 'http://103.146.16.154/branch/index.php'; 
$app_key = '0vWQuCRGiUX7EPVjQDr0EUAYtc'; 
$app_secret = 'jcUNPBgbcqEDedNKdvE4G1cAK7D3hCjmJccNPZZBq96QIxxwAMEx'; 
$username = '01770618567'; 
$password = 'D7DaC<*E*eG'; 
$base_url = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized/checkout';

/* Grant Token*/
function getGrantToken($base_url, $username, $password, $app_key, $app_secret) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $base_url . '/token/grant',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'accept: application/json',
            'content-type: application/json',
            'password: ' . $password,
            'username: ' . $username,
        ],
        CURLOPT_POSTFIELDS => json_encode([
            'app_key' => $app_key,
            'app_secret' => $app_secret,
        ]),
    ]);

    $response = curl_exec($curl);
    curl_close($curl);
    
    $response_data = json_decode($response, true);
    return $response_data['id_token'] ?? null;
}

/*Create Payment*/ 
function createPayment($base_url, $auth, $app_key, $callbackURL, $amount) {
    $InvoiceNumber = 'POP/Branch' . rand(1000, 9999); 
    $requestbody = [
        'mode' => '0011',
        'amount' => $amount,
        'currency' => 'BDT',
        'intent' => 'sale',
        'payerReference' => $InvoiceNumber,
        'merchantInvoiceNumber' => $InvoiceNumber,
        'callbackURL' => $callbackURL,
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $base_url . '/create',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: ' . $auth,
            'X-APP-Key: ' . $app_key,
        ],
        CURLOPT_POSTFIELDS => json_encode($requestbody),
    ]);

    $resultdata = curl_exec($curl);
    curl_close($curl);
    return json_decode($resultdata);
}

/*Payment Process*/
if (isset($_GET['submit_payment']) && !empty($_GET['submit_payment'])) {
    $amount = $_GET['amount']; 
    $pop_id = $_GET['pop_id']; 
    $result = $con->query("SELECT `fullname` FROM add_pop WHERE id='$pop_id'");

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $recharge_by = $row['fullname']; 
    } 

    /*Start Grant Token*/ 
    $id_token = getGrantToken($base_url, $username, $password, $app_key, $app_secret);

    if ($id_token) {
        $paymentResponse = createPayment($base_url, $id_token, $app_key, $callbackURL, $amount);

        if (isset($paymentResponse->bkashURL)) {      
            date_default_timezone_set('Asia/Dhaka');
            $todayDate=date('H:i A, d-M-Y');
            $con->query("INSERT INTO pop_transaction(pop_id,amount,paid_amount,action,transaction_type,recharge_by,date)VALUES('$pop_id','$amount','$amount','1','Recharge','$recharge_by','$todayDate')");
            header("Location: " . $paymentResponse->bkashURL);
            exit;
        } else {
            echo "Error creating payment.";
        }
    } else {
        echo "Error generating token.";
    }
}
?>
