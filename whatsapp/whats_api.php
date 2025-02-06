<?php 
// include 'include/Service/Customer_service.php';
// include 'include/db_connect.php';
// $customerService = new Customer_service($con);
// $customerService::all_customer(); 

/*
curl -i -X POST https://graph.facebook.com/v21.0/578827858638675/messages
  -H 'Authorization: Bearer EAAVjLaT37yQBO2QThWwBmVuxkZCZCIj9e1vucalT4aoCCgAw3JgKMxZBCVfHGSawoNkmDrNZBmUc0DqYMVgVYBbEPE4g3IkVe4YFRCRcYZCz4QchvkDFUDayzZAkwteeRrqY0UOgiD5y3ZCGDmYWrfIw4EqjxQ2zWzZAoQaETUSeWcuXQ9GZAY7cpwQI9T0VOsJqPLgKuRar5CuBZBtkmxi35Y8hSsTYMZCmOc4pZCIZBjdRs' `
  -H 'Content-Type: application/json' `
  -d '{ \"messaging_product\": \"whatsapp\", \"to\": \"8801791225252\", \"type\": \"template\", \"template\": { \"name\": \"hello_world\", \"language\": { \"code\": \"en_US\" } } }'


*/
// $postvars = '{
// 				  "messaging_product": "whatsapp",
// 				  "recipient_type": "individual",
// 				  "to": "+8801791225252",
// 				  "type": "text",
// 				  "text": {
// 					"preview_url": true,
// 					"body": "As requested, here the link to our latest product: https://www.meta.com/quest/quest-3/"
// 				  }
// }';
// $postvars = '{
// 				  "messaging_product": "whatsapp",
// 				  "recipient_type": "individual",
// 				  "to": "+8801757967432",
// 				  "type": "text",
// 				  "text": {
// 					"preview_url": true,
// 					"body": "As requested, here the link to our latest product: https://www.meta.com/quest/quest-3/"
// 				  }
// }';

// 	$ch = curl_init();
  
//   $url = "https://graph.facebook.com/v21.0/578827858638675/messages";
//   curl_setopt($ch,CURLOPT_URL,$url);
//   curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//     'Authorization: Bearer EAAVjLaT37yQBO2QThWwBmVuxkZCZCIj9e1vucalT4aoCCgAw3JgKMxZBCVfHGSawoNkmDrNZBmUc0DqYMVgVYBbEPE4g3IkVe4YFRCRcYZCz4QchvkDFUDayzZAkwteeRrqY0UOgiD5y3ZCGDmYWrfIw4EqjxQ2zWzZAoQaETUSeWcuXQ9GZAY7cpwQI9T0VOsJqPLgKuRar5CuBZBtkmxi35Y8hSsTYMZCmOc4pZCIZBjdRs',
// 	'Content-Type: application/json'
// ));
//   curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
//   curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
//   curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
//   curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
//   curl_setopt($ch,CURLOPT_TIMEOUT, 20);
//   $response = curl_exec($ch);
//   print "curl response is:" . $response;
//   curl_close ($ch);


// $curl = curl_init();

// curl_setopt_array($curl, [
//   CURLOPT_URL => "https://api.wassenger.com/v1/messages",
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 30,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "POST",
//   CURLOPT_POSTFIELDS => json_encode([
//     'phone' => '+8801757967432',
//     'message' => 'Hello world! This is a test message.'
//   ]),
//   CURLOPT_HTTPHEADER => [
//     "Content-Type: application/json",
//     "Token: 33fe4de0b9752b595c2a8e5c22c8adf9ee81a7e413989a0700d0b61b985c8e2c96d50bbdbed32d7e"
//   ],
// ]);

// $response = curl_exec($curl);
// $err = curl_error($curl);

// curl_close($curl);

// if ($err) {
//   echo "cURL Error #:" . $err;
// } else {
//   echo $response;
// }


$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.wassenger.com/v1/messages",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'group' => '120363386291315088@g.us',
    'message' => 'Hello world! This is a test message.'
  ]),
  CURLOPT_HTTPHEADER => [
    "Content-Type: application/json",
    "Token: 33fe4de0b9752b595c2a8e5c22c8adf9ee81a7e413989a0700d0b61b985c8e2c96d50bbdbed32d7e"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo "<pre>";
  print_r($response);
  echo "</pre>";
}



?>