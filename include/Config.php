<?php 

$config = [
    'base_url' => 'https://tokenized.pay.bka.sh/v1.2.0-beta/tokenized/checkout',
    'app_key' => 'OEOyCIxZuEtF76cS5RzVaaWstc',
    'app_secret' => 'h2EXSWTQ6iTQIjEwz83vnT80wzd7k8wJ4YBMKhvXhJnVG6Cm7hPX',
    'username' => '01831550088',
    'password' => 'Q4gp%tVJ-#%'
];

$bkashService = new BkashPaymentService($config);



?>