<?php

session_start();

class BkashHelper
{
    // bKash Merchant API Information

    public $base_url = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized/checkout'; // For Live Production URL: https://checkout.pay.bka.sh/v1.2.0-beta
    public $app_key = '0vWQuCRGiUX7EPVjQDr0EUAYtc'; // bKash Merchant API APP KEY
    public $app_secret = 'jcUNPBgbcqEDedNKdvE4G1cAK7D3hCjmJccNPZZBq96QIxxwAMEx'; // bKash Merchant API APP SECRET
    public $username = '01770618567'; // bKash Merchant API USERNAME
    public $password = 'D7DaC<*E*eG'; // bKash Merchant API PASSWORD
	


    public function getToken()
    {
        $_SESSION['id_token'] = null;

        $post_token = array(
            'app_key' => $this->app_key,
            'app_secret' => $this->app_secret
        );

        $url = curl_init("$this->base_url/token/grant");
        $post_token = json_encode($post_token);
        $header = array(
            'Content-Type:application/json',
			'Accept:application/json',
            "password:$this->password",
            "username:$this->username"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $post_token);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $result_data = curl_exec($url);
        curl_close($url);

        $response = json_decode($result_data, true);

        if (array_key_exists('msg', $response)) {
            return json_encode($response);
        }

        $_SESSION['id_token'] = $response['id_token'];

        return json_encode($response);
    }

    public function createPayment()
    {
        

        $token = $_SESSION['id_token'];
		$_SESSION['paymentID'] =null;
		
		
		
		$_POST['callbackURL'] = 'http://103.146.16.154/b/api-handle.php?action=executePayment';
		$_POST['payerReference'] = '01929918378';

		$_POST['mode'] = '0011';
		$_POST['amount'] = '1330';
        $_POST['intent'] = 'sale';
        $_POST['currency'] = 'BDT';
        $_POST['merchantInvoiceNumber'] = rand();

        $url = curl_init("$this->base_url/create");
        $request_data_json = json_encode($_POST);
        $header = array(
            'Content-Type:application/json',
            "authorization: $token",
            "x-app-key: $this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $result_data = curl_exec($url);
        curl_close($url);
		///////////////////////////
		
		$response = json_decode($result_data, true);

       /*if (array_key_exists('paymentID', $response)) {
            return json_encode($response);
			
			 
        }
		*/
		///////////////////////////
		$_SESSION['paymentID'] = $response['paymentID'];
        return $result_data;
		//return $response;
    }

    public function executePayment()
    {
         $token = $_SESSION['id_token'];

         $paymentID = $_SESSION['paymentID'];
		 
		 $post_paymentID = array(
           'paymentID' => $paymentID
            );
			
			 $posttoken = json_encode($post_paymentID);

        $url = curl_init("$this->base_url/execute");
        $header = array(
            'Content-Type:application/json',
			
            "authorization:$token",
            "x-app-key:$this->app_key"
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

    public function queryPayment()
    {
        $token = $_SESSION['id_token'];
        $paymentID = $_GET['paymentID'];

        $url = curl_init("$this->base_url/payment/query/" . $paymentID);
        $header = array(
            'Content-Type:application/json',
            "authorization:$token",
            "x-app-key:$this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $result_data = curl_exec($url);
        curl_close($url);

        return $result_data;
    }

    public function searchTransaction($trxID)
    {
        $url = curl_init("$this->base_url/payment/search/" . $trxID);

        $header = array(
            'Content-Type:application/json',
            'authorization:' . $_SESSION['id_token'],
            "x-app-key: $this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $result_data = curl_exec($url);
        curl_close($url);

        return $result_data;
    }
}
