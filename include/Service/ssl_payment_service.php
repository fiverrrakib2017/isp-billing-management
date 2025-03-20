<?php

class SSLCommercePaymentService 
{
    private $merchantKey;
    private $storeId;
    private $returnUrl;
    private $cancelUrl;
    private $baseUrl;

    public function __construct($config)
    {
        $this->merchantKey = $config['merchant_key'];
        $this->storeId = $config['store_id'];
        $this->returnUrl = $config['return_url'];
        $this->cancelUrl = $config['cancel_url'];
        $this->baseUrl = $config['base_url'];
    }

    public function create_payment($amount, $currency = 'BDT')
    {
        $invoiceNumber = "INV-" . strtoupper(uniqid());

        $postData = [
            'store_id' => $this->storeId,
            'store_passwd' => $this->merchantKey,
            'total_amount' => $amount,
            'currency' => $currency,
            'tran_id' => $invoiceNumber,
            'success_url' => $this->returnUrl,
            'fail_url' => $this->cancelUrl,
            'cancel_url' => $this->cancelUrl,
        ];

        /* Initialize SSL Commerce Payment Gateway */
        $url = curl_init($this->baseUrl);
        curl_setopt($url, CURLOPT_POST, true);
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($url, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($url);
        $curlError = curl_error($url);
        curl_close($url);

        if (!$result) {
            return ['error' => 'cURL error: ' . $curlError];
        }

        return json_decode($result, true);
    }

    public function verifyPayment($tran_id)
    {
        $postData = [
            'store_id' => $this->storeId,
            'store_passwd' => $this->merchantKey,
            'tran_id' => $tran_id
        ];

        /* Initialize cURL for SSL Commerce Payment Status*/
        $url = curl_init("https://secure.sslcommerz.com/validator/api/merchanttransidvalidation.php");
        curl_setopt($url, CURLOPT_POST, true);
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($url, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($url);
        $curlError = curl_error($url);
        curl_close($url);

        if (!$result) {
            return ['error' => 'cURL error: ' . $curlError];
        }

        $response = json_decode($result, true);
        return isset($response['status']) && $response['status'] === 'VALID';
    }
}