<?php
include("../include/db_connect.php");
include ("../include/functions.php");
session_start();
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
$call_back_url = "https://";   
else  
$call_back_url = "http://";    
$call_back_url.= $_SERVER['HTTP_HOST'];   
if($_GET['landing_page'] && !empty($_GET['landing_page'])){
    $call_back_url.'/customer_landing_page.php?clid='.$_GET['customer_id'].'';  
}else{
    //$call_back_url.'/branch/index.php';   
}

/*install Process*/
$callbackURL = $call_back_url; 
$app_key = 'OEOyCIxZuEtF76cS5RzVaaWstc'; 
$app_secret = 'h2EXSWTQ6iTQIjEwz83vnT80wzd7k8wJ4YBMKhvXhJnVG6Cm7hPX'; 
$username = '01831550088'; 
$password = 'Q4gp%tVJ-#%'; 
$base_url = 'https://tokenized.pay.bka.sh/v1.2.0-beta/tokenized/checkout';

function getGrantToken($base_url, $username, $password, $app_key, $app_secret) {
    
    $post_token = array(
        'app_key' => $app_key,
        'app_secret' => $app_secret
    );

    $url = curl_init("$base_url/token/grant");
    $post_token = json_encode($post_token);
    $header = array(
        'Content-Type: application/json',
        'Accept: application/json',
        "password: $password",
        "username: $username"
    );

    curl_setopt($url, CURLOPT_HTTPHEADER, $header);
    curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($url, CURLOPT_POSTFIELDS, $post_token);
    curl_setopt($url, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

    $result_data = curl_exec($url);
    
    if (curl_errno($url)) {
        echo 'Curl error: ' . curl_error($url);
        curl_close($url);
        return null;
    }

    curl_close($url);

    $response_data = json_decode($result_data, true);
   
    return $response_data['id_token'] ?? null;
}

/*Create Payment*/ 
function createPayment($base_url, $id_token, $app_key, $callbackURL, $amount, $pop_id) {
    $request_data = [
        'callbackURL' => $callbackURL,
        'payerReference' => $pop_id,
        'mode' => '0011',
        'amount' => $amount,
        'intent' => 'sale',
        'currency' => 'BDT',
        'merchantInvoiceNumber' =>"TRANSID-".strtoupper(uniqid()),
    ];

    $url = curl_init("$base_url/create");
    $request_data_json = json_encode($request_data);

    $header = [
        'Content-Type: application/json',
        "Authorization: Bearer $id_token", 
        "X-APP-Key: $app_key"
    ];

    curl_setopt($url, CURLOPT_HTTPHEADER, $header);
    curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
    curl_setopt($url, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

    $result_data = curl_exec($url);

    if (curl_errno($url)) {
        echo 'Curl error: ' . curl_error($url);
        curl_close($url);
        return null;
    }

    curl_close($url);

    $response = json_decode($result_data, true); 
    $_SESSION['id_token'] = $id_token;
    $_SESSION['app_key'] =$app_key;
    $_SESSION['final_amount']=$amount;
    $_SESSION['pop_id']=$pop_id;
    return $response;
}

function executePayment($base_url,$id_token,$app_key,$paymentID)
{
        
        $post_paymentID = array(
        'paymentID' => $paymentID
        );
        
            $posttoken = json_encode($post_paymentID);

    $url = curl_init("$base_url/execute");
    $header = array(
        'Content-Type:application/json',
        
        "authorization:$id_token",
        "x-app-key:$app_key"
    );

    curl_setopt($url, CURLOPT_HTTPHEADER, $header);
    curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($url, CURLOPT_POSTFIELDS, $posttoken);
    curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    $result_data = curl_exec($url);
    curl_close($url);

    return $result_data;
}

 function queryPayment($base_url, $id_token, $app_key, $paymentID)
{
        $url = curl_init("$base_url/payment/query/" . $paymentID);
        $header = array(
            'Content-Type:application/json',
            "authorization:$id_token",
            "x-app-key:$app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $result_data = curl_exec($url);
        curl_close($url);

        return $result_data;
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
        $paymentResponse = createPayment($base_url, $id_token, $app_key, $callbackURL, $amount,$pop_id,$recharge_by,$con);
       
        if (!empty($paymentResponse['paymentID']) && !empty($paymentResponse['statusMessage']) && $paymentResponse['statusMessage'] === 'Successful') {
            if (isset($paymentResponse['bkashURL'])) {      
                header("Location: " . $paymentResponse['bkashURL']);
                exit;
            } else {
                echo "Error creating payment.";
            }
        }

      

        
    } else {
        echo "Error generating token.";
    }
}


?>