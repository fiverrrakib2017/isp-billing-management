<?php

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$protocol . $_SERVER['HTTP_HOST'] . '/index.php';

require '../Config.php';
class BkashPaymentService
{
    private $baseUrl;
    private $appKey;
    private $appSecret;
    private $username;
    private $password;

    public function __construct($config)
    {
        $this->baseUrl = $config['base_url'];
        $this->appKey = $config['app_key'];
        $this->appSecret = $config['app_secret'];
        $this->username = $config['username'];
        $this->password = $config['password'];
    }
    /************Generate Grant Token******************/
    public function getGrantToken()
    {
        $postToken = json_encode([
            'app_key' => $this->appKey,
            'app_secret' => $this->appSecret,
        ]);

        $url = curl_init("$this->baseUrl/token/grant");
        $header = ['Content-Type: application/json', 'Accept: application/json', "password: {$this->password}", "username: {$this->username}"];

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $postToken);

        $result = curl_exec($url);
        curl_close($url);

        $response = json_decode($result, true);
        return $response['id_token'] ?? null;
    }
    // Create Payment
    public function createPayment($idToken, $callbackURL, $amount, $payerReference = null)
    {
        $requestData = [
            'callbackURL' => $callbackURL,
            'payerReference' => $payerReference,
            'mode' => '0011',
            'amount' => $amount,
            'intent' => 'sale',
            'currency' => 'BDT',
            'merchantInvoiceNumber' => 'TRANSID-' . strtoupper(uniqid()),
        ];

        $url = curl_init("$this->baseUrl/create");
        $header = ['Content-Type: application/json', "Authorization: Bearer $idToken", "X-APP-Key: {$this->appKey}"];

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, json_encode($requestData));

        $result = curl_exec($url);
        curl_close($url);

        return json_decode($result, true);
    }
    /************** Execute Payment***************/
    public function executePayment($idToken, $paymentID)
    {
        $postPaymentID = json_encode(['paymentID' => $paymentID]);

        $url = curl_init("$this->baseUrl/execute");
        $header = ['Content-Type: application/json', "Authorization: $idToken", "X-APP-Key: {$this->appKey}"];

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $postPaymentID);

        $result = curl_exec($url);
        curl_close($url);

        return json_decode($result, true);
    }
}
