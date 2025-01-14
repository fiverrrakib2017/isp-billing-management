<?php 
include 'db_connect.php';
include 'Service/Bkash_payment_service.php';

if(isset($_GET['customer_recharge']) && !empty($_GET['customer_recharge'])){
    $idToken = $bkashService->getGrantToken();
}





?>