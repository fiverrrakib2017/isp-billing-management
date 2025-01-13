<?php 
include 'db_connect.php';

class BkashPayment
{
    private $baseUrl;
    private $appKey;
    private $appSecret;
    private $token;

    public function __construct($baseUrl, $appKey, $appSecret)
    {
        $this->baseUrl = $baseUrl;
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;

        $this->token = $this->getToken();
    }

    /*Generate Bkash Token*/
    private function getToken()
    {
        $url = $this->baseUrl . '/token/grant';
        $postData = json_encode([
            'app_key' => $this->appKey,
            'app_secret' => $this->appSecret,
        ]);

        $response = $this->makeRequest($url, $postData);
        if (isset($response['id_token'])) {
            return $response['id_token'];
        }

        throw new Exception('Unable to generate token.');
    }

    /*********************************Bkash Payment Initialize*******************************/
    public function initiatePayment($amount, $invoiceId)
    {
        $url = $this->baseUrl . '/checkout/payment/initiate';
        $postData = json_encode([
            'amount' => $amount,
            'invoice' => $invoiceId,
            'intent' => 'sale',
            'currency' => 'BDT',
        ]);

        $response = $this->makeRequest($url, $postData, true);
        if (isset($response['paymentID'])) {
            return $response;
        }

        throw new Exception('Payment initiation failed.');
    }

     /*********************************Bkash Payment Execute*******************************/
    public function executePayment($paymentId)
    {
        $url = $this->baseUrl . '/checkout/payment/execute/' . $paymentId;
        $response = $this->makeRequest($url, null, true, 'POST');

        if (isset($response['transactionStatus']) && $response['transactionStatus'] === 'Completed') {
            return $response;
        }

        throw new Exception('Payment execution failed.');
    }

    // পেমেন্ট ভেরিফাই করার ফাংশন
    public function verifyPayment($paymentId)
    {
        $url = $this->baseUrl . '/checkout/payment/query/' . $paymentId;
        $response = $this->makeRequest($url, null, true, 'GET');

        if (isset($response['transactionStatus'])) {
            return $response;
        }

        throw new Exception('Payment verification failed.');
    }

 
    private function makeRequest($url, $data = null, $auth = false, $method = 'POST')
    {
        $ch = curl_init($url);
        $headers = ['Content-Type: application/json'];
        if ($auth) {
            $headers[] = 'Authorization: Bearer ' . $this->token;
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception('Request Error: ' . curl_error($ch));
        }

        curl_close($ch);

        return json_decode($result, true);
    }
}









?>