<?php

$callbackURL = ''; 
$app_key = '0vWQuCRGiUX7EPVjQDr0EUAYtc'; 
$app_secret = 'jcUNPBgbcqEDedNKdvE4G1cAK7D3hCjmJccNPZZBq96QIxxwAMEx'; 
$username = '01770618567'; 
$password = 'D7DaC<*E*eG'; 
$base_url = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized/checkout'; 

// Start Grant Token using cURL
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => $base_url.'/v1.2.0-beta/tokenized/checkout/token/grant',
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
        'app_secret' => $app_secret
    ]),
]);

$response = curl_exec($curl);
curl_close($curl);

$response_data = json_decode($response, true);
$id_token = $response_data['id_token']; // End Grant Token

// Handle create payment logic
if (isset($_GET['a'])) {
    $amount = $_GET['a'];
    $InvoiceNumber = 'shop' . rand();

    // Start Create Payment
    $auth = $id_token;
    $requestbody = [
        'mode' => '0011',
        'amount' => $amount,
        'currency' => 'BDT',
        'intent' => 'sale',
        'payerReference' => $InvoiceNumber,
        'merchantInvoiceNumber' => $InvoiceNumber,
        'callbackURL' => $callbackURL
    ];

    $url = curl_init($base_url.'/v1.2.0-beta/tokenized/checkout/create');
    $requestbodyJson = json_encode($requestbody);
    $header = [
        'Content-Type: application/json',
        'Authorization: ' . $auth,
        'X-APP-Key: ' . $app_key
    ];

    curl_setopt_array($url, [
        CURLOPT_HTTPHEADER => $header,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $requestbodyJson,
    ]);

    $resultdata = curl_exec($url);
    curl_close($url);
    
    $obj = json_decode($resultdata);
    header("Location: " . $obj->bkashURL); // Redirect to payment URL
    exit;
}

// Handle payment execution
if (isset($_GET['paymentID'], $_GET['status']) && $_GET['status'] == 'success') {
    $paymentID = $_GET['paymentID'];
    $auth = $id_token;
    $post_token = ['paymentID' => $paymentID];

    $url = curl_init($base_url.'/v1.2.0-beta/tokenized/checkout/execute');
    $posttoken = json_encode($post_token);
    
    $header = [
        'Content-Type: application/json',
        'Authorization: ' . $auth,
        'X-APP-Key: ' . $app_key
    ];

    curl_setopt_array($url, [
        CURLOPT_HTTPHEADER => $header,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $posttoken,
    ]);

    $resultdata = curl_exec($url);
    curl_close($url);

    $obj = json_decode($resultdata);
    print_r($obj); // Print transaction details
}

exit; 
session_start();
require('BkashHelper.php');

$bkash_helper = new BkashHelper();
echo '<pre>';
print_r(json_encode($bkash_helper->getToken()));
echo '</pre>'; exit;
// Step 1: Initiate payment request to bKash
$api_url = "https://checkout.sandbox.bka.sh/v1.2.0-beta/checkout/payment/create";
$access_token = "Bearer " . $bkash_helper->getToken(); 

$data = [
    "amount" => "1000",
    "currency" => "BDT",
    "intent" => "sale",
    "merchantInvoiceNumber" => uniqid("INV_"), 
    "callbackURL" => "https://yourwebsite.com/payment_callback.php" 
];

// cURL দিয়ে API কল
$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $access_token"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

// যদি API সফলভাবে কাজ করে
if (isset($result['bkashURL'])) {
    header("Location: " . $result['bkashURL']); // bKash পেমেন্ট পেজে রিডাইরেক্ট
    exit();
} else {
    echo "Payment initiation failed: " . $result['errorMessage'];
}
?>
