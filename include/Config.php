<?php 

$config = [
    'base_url' => 'https://tokenized.pay.bka.sh/v1.2.0-beta/tokenized/checkout',
    'app_key' => 'OEOyCIxZuEtF76cS5RzVaaWstc',
    'app_secret' => 'h2EXSWTQ6iTQIjEwz83vnT80wzd7k8wJ4YBMKhvXhJnVG6Cm7hPX',
    'username' => '01831550088',
    'password' => 'Q4gp%tVJ-#%'
];
// $config = [
//     'base_url' => 'https://checkout.sandbox.bka.sh/v1.2.0-beta',
//     'app_key' => '0vWQuCRGiUX7EPVjQDr0EUAYtc',
//     'app_secret' => 'jcUNPBgbcqEDedNKdvE4G1cAK7D3hCjmJccNPZZBq96QIxxwAMEx',
//     'username' => '01831550088',
//     'password' => 'Q4gp%tVJ-#%'
// ];

$callback_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$callback_url .= $_SERVER['HTTP_HOST'] . '/self.php?clid=' . $customer_id . '';


$ssl_commerce_config = [
    'merchant_key' => 'srwif67d29730edb1a@ssl',
    'store_id' => 'srwif67d29730edb1a',
    'return_url' => 'https://sr-wifi.net', 
    'cancel_url' => $callback_url,
    'base_url' => "https://sandbox.sslcommerz.com/gwprocess/v3/api.php"
];






?>