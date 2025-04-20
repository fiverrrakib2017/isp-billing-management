<?php 
include "db_connect.php";

if (isset($_GET['add_message_shchedule_data']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    /* Sanitize input values */
    $pop_id = isset($_POST["pop_id"]) ? trim($_POST["pop_id"]) : '';
    $area_id = isset($_POST["area_id"]) ? trim($_POST["area_id"]) : '';
    $message = isset($_POST["message"]) ? trim($_POST["message"]) : '';
    $send_date = isset($_POST["send_date"]) ? trim($_POST["send_date"]) : '';
    /* Use trim to remove unwanted spaces*/
    $note = isset($_POST["notes"]) ? trim($_POST["notes"]) : ''; 
    
    /* Validate pop_id */
    if (empty($pop_id)) {
        $errors['pop_id'] = "POP/Branch id is required.";
    }
    
    /* Validate area_id */
    if (empty($area_id)) {
        $errors['area_id'] = "Area id is required.";
    }
    
    /* Validate message */
    if (empty($message)) {
        $errors['message'] = "Message is required.";
    }
    
    /* Validate send_date */
    if (empty($send_date)) {
        $errors['send_date'] = "Send Date field is required.";
    }
    
    /* If validation errors exist, return errors */
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'errors' => $errors
        ]);
        exit;
    }

    /* Insert query */ 
    $stmt = $con->prepare("INSERT INTO message_schedule (pop_id, area_id, message_text, send_date, note, create_date) VALUES (?, ?, ?, ?, ?, NOW())");

    /* Bind parameters correctly */
    $stmt->bind_param('iisss', $pop_id, $area_id, $message, $send_date, $note);

    $result = $stmt->execute();

    /* Check if insertion was successful */
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Added Successfully!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Error: ' . $stmt->error
        ]);
    }

    /* Close statement */
    $stmt->close();
}


if (isset($_GET['get_message_schedule_data']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
	require 'datatable.php';

	$table = 'message_schedule';
	$primaryKey = 'id';
	$columns = array(
		array('db' => 'id', 'dt' => 0),
		array('db'=>'pop_id','dt'=>1,'formatter'=>function($d, $row)use ($con){
			
			/*Fetch POP/Branch details*/ 
			$Query = $con->query("SELECT * FROM add_pop WHERE id=$d");
			if ($run_query = $Query->fetch_assoc()) {
				$data = $run_query['pop'];
				return $data;
			}
			return 'Unknown POP/Branch';

		}),
		array('db'=>'area_id','dt'=>2,'formatter'=>function($d, $row)use ($con){
			/*Fetch POP/Branch details*/ 
			$Query = $con->query("SELECT * FROM area_list WHERE id=$d");
			if ($run_query = $Query->fetch_assoc()) {
				$data = $run_query['name'];
				return $data;
			}
			return 'All Area';

		}),
		array(
			'db' => 'message_text',
			'dt' => 3,
			'formatter' => function($d, $row) use ($con) {
				/* Limit message text to 40 characters */
				if (strlen($d) > 40) {
					return substr($d, 0, 40) . '...';
				} else {
					return $d;
				}
			}
		),
		
		array('db'=>'send_date','dt'=>4,'formatter'=>function($d, $row)use ($con){
			return $d; 

		}),
		array('db'=>'create_date','dt'=>5,'formatter'=>function($d, $row)use ($con){
			return $d; 

		}),
		array(
			'db'=>'id',
			'dt'=>6,
			'formatter'=>function($d, $row){
				return '
				<button type="button" name="edit_button" data-id='.$row['id'].' class="btn-sm btn btn-success edit-btn"> <i class="fas fa-edit"></i></button>

				<button type="button" name="delete_button" data-id='.$row['id'].' class="btn-sm btn btn-danger delete-btn"> <i class="fas fa-trash"></i></button>

				'; 
			}
		),
		
		
	);

	$condition = ""; 
	/* Output JSON for DataTables to handle*/
	echo json_encode(
		SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns,null, $searchCondition)
	);
}



if (isset($_GET['delete_message_schedule_data']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
	$id=$_POST['id'];

	/* Delete query */
	$stmt = $con->prepare("DELETE FROM message_schedule WHERE id = ?");
	/* Bind parameters correctly */
	$stmt->bind_param('i', $id);
	/* Execute the statement */
	$result = $stmt->execute();
	/* Check if deletion was successful */
	if ($result) {
		echo json_encode([
			'success' => true,
			'message' => 'Record deleted successfully!'
		]);
	} else {
		echo json_encode([
			'success' => false,
			'error' => 'Error: ' . $stmt->error
		]);
	}
	/* Close statement */
	$stmt->close();
	/* Close connection */
	$con->close();
}

if (isset($_GET['edit_data']) && isset($_GET['id'])) { 
	$id = intval($_GET['id']); 

	// Prepare the SQL statement
	$stmt = $con->prepare("SELECT * FROM message_schedule WHERE id = ?");
	$stmt->bind_param("i", $id);

	// Execute the statement
	if ($stmt->execute()) {
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			$data = $result->fetch_assoc();
			$response = array("success" => true, "data" => $data);
		} else {
			$response = array("success" => false, "message" => "No record found!");
		}
	} else {
		$response = array("success" => false, "message" => "Error executing query: " . $stmt->error);
	}

	// Close the statement
	$stmt->close();
	$con->close();

	// Return the response as JSON
	echo json_encode($response);
	exit; 
}


if (isset($_GET['update_message_shchedule_data']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    /* Sanitize input values */
    $id = isset($_POST["id"]) ? trim($_POST["id"]) : ''; 
    $pop_id = isset($_POST["pop_id"]) ? trim($_POST["pop_id"]) : '';
    $area_id = isset($_POST["area_id"]) ? trim($_POST["area_id"]) : '';
    $message = isset($_POST["message"]) ? trim($_POST["message"]) : '';
    $send_date = isset($_POST["send_date"]) ? trim($_POST["send_date"]) : '';
    /* Use trim to remove unwanted spaces*/
    $note = isset($_POST["notes"]) ? trim($_POST["notes"]) : ''; 
    
    /* Validate id */
    if (empty($id)) {
        $errors['id'] = "ID is required.";
    }

    /* Validate pop_id */
    if (empty($pop_id)) {
        $errors['pop_id'] = "POP/Branch id is required.";
    }
    
    /* Validate area_id */
    if (empty($area_id)) {
        $errors['area_id'] = "Area id is required.";
    }
    
    /* Validate message */
    if (empty($message)) {
        $errors['message'] = "Message is required.";
    }
    
    /* Validate send_date */
    if (empty($send_date)) {
        $errors['send_date'] = "Send Date field is required.";
    }
    
    /* If validation errors exist, return errors */
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'errors' => $errors
        ]);
        exit;
    }

    /* Update query */ 
    $stmt = $con->prepare("UPDATE message_schedule SET pop_id = ?, area_id = ?, message_text = ?, send_date = ?, note = ? WHERE id = ?");

    /* Bind parameters correctly */
    $stmt->bind_param('iisssi', $pop_id, $area_id, $message, $send_date, $note, $id); 

    $result = $stmt->execute();

    /* Check if update was successful */
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Updated Successfully!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Error: ' . $stmt->error
        ]);
    }

    /* Close statement */
    $stmt->close();
}

if (isset($_GET['send_message']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // $rakib=`http://bulksmsbd.net/api/smsapi?api_key=WC1N6AFA4gVRZLtyf8z9&type=text&number=01757967432&senderid=8809617620311&message=TestSMS`; 
    // echo $rakib; 
    $errors = [];

    /* Input sanitize */
    $phone = isset($_POST["phone"]) ? trim($_POST["phone"]) : ''; 
    $message = isset($_POST["message"]) ? trim($_POST["message"]) : ''; 
    
    /* Validate phone number and message */
    if (empty($phone)) {
        $errors['phone'] = "Phone Number is required.";
    }
    if (empty($message)) {
        $errors['message'] = "Message is required.";
    }

    /* Return errors if validation fails */
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'errors' => $errors
        ]);
        exit;
    }
    

    /* SMS API details */
    $url = "http://bulksmsbd.net/api/smsapi";
    $api_key = "WC1N6AFA4gVRZLtyf8z9";
    $senderid = "SR WiFi";
    
    /* Prepare data */
    $data = [
        "api_key" => $api_key,
        "senderid" => $senderid,
        "number" => $phone,
        "message" => $message
    ];

    /* Initialize cURL */
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    /* Execute request */
    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);

    if ($responseData['response_code'] == 202) {
        echo json_encode([
            'success' => true,
            'message' => $responseData['success_message']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => $responseData['error_message'] ?: 'An error occurred.'
        ]);
    }
    exit;

}
if (isset($_GET['bulk_message']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    $customer_ids = isset($_POST['customer_ids']) ? $_POST['customer_ids'] : []; 

    /* Input sanitize */
    $message = isset($_POST["message"]) ? trim($_POST["message"]) : ''; 
    
    /* Validate data */
    if (empty($message)) {
        $errors['message'] = "Message is required.";
    }

    /* Return errors if validation fails */
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'errors' => $errors
        ]);
        exit;
    }
    
    /* SMS API details */
    $url = "http://bulksmsbd.net/api/smsapimany";
    $api_key = "WC1N6AFA4gVRZLtyf8z9";
    $senderid = "SR WiFi";

    /* Prepare data */  
    $messages = [];
    foreach ($customer_ids as $customer_id) {
        $customer_id = trim($customer_id);
        

        $all_customer = $con->query("SELECT * FROM customers WHERE id = $customer_id");
        $customer = $all_customer->fetch_assoc();

        if ($customer) {
            $phone = $customer['mobile'];

            $messages[] = [
                "to" => $phone,
                "message" => $message
            ];
        } else {
            $errors[] = "Customer with ID $customer_id not found.";
        }
    }

    $messagesJson = json_encode($messages);
    
    

    /* Prepare data for SMS API */
    $data = [
        "api_key" => $api_key,
        "senderid" => $senderid,
        "messages" => $messagesJson
    ];
    
    /* Initialize cURL */
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    /* Execute request */
    $response = curl_exec($ch);
    curl_close($ch);
   
    $responseData = json_decode($response, true);
    /*Check response*/ 
    if (isset($responseData['response_code']) && $responseData['response_code'] == 202) {
        echo json_encode([
            'success' => true,
            'message' => "Messages sent successfully!"
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => $responseData['error_message'] ?: 'An error occurred.'
        ]);
    }
    exit;
}



?>