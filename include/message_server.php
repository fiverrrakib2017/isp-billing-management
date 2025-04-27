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
    include "functions.php";
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
         /*Insert SMS Logs*/
         sms_logs($phone,$message,'1');
    } else {
        echo json_encode([
            'success' => false,
            'error' => $responseData['error_message'] ?: 'An error occurred.'
        ]);
         /*Insert SMS Logs*/
         sms_logs($phone,$message,'0');
    }
    exit;

}
//*************************** Bulk Message **********************************************/
if (isset($_GET['bulk_message']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    /*Load required files*/
    include "functions.php";
    include "db_connect.php";
    $errors = [];

    $customer_ids = isset($_POST['customer_ids']) ? $_POST['customer_ids'] : []; 
    $original_message = isset($_POST["message"]) ? trim($_POST["message"]) : ''; 

    preg_match_all('/\{([^\}]+)\}/', $original_message, $matches);

    /* Validate data */
    if (empty($original_message)) {
        $errors['message'] = "Message is required.";
    }
    if (empty($customer_ids)) {
        $errors['customer_ids'] = "At least one customer must be selected.";
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
        $customer_id = (int) $customer_id; 
        $all_customer = $con->query("SELECT * FROM customers WHERE id = $customer_id");

        if ($all_customer && $all_customer->num_rows > 0) {
            $customer = $all_customer->fetch_assoc();

            $personalized_message = $original_message;

            if (!empty($matches[1])) {
                foreach ($matches[1] as $item) {
                    $field = $item;
                    $personalized_message = str_replace("{" . $field . "}", $customer[$field] ?? '', $personalized_message);
                }
            }

            $phone = $customer['mobile'];

            $messages[] = [
                "to" => $phone,
                "message" => $personalized_message
            ];
        } else {
            $errors[] = "Customer with ID $customer_id not found.";
        }
    }

    if (empty($messages)) {
        echo json_encode([
            'success' => false,
            'error' => "No valid customers found."
        ]);
        exit;
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

    /* Check response */
    if (isset($responseData['response_code']) && $responseData['response_code'] == 202) {
        echo json_encode([
            'success' => true,
            'message' => "Messages sent successfully!"
        ]);

        // Log all successful messages
        foreach ($messages as $msg) {
            sms_logs($msg['to'], $msg['message'], 1);
        }
    } else {
        echo json_encode([
            'success' => false,
            'error' => $responseData['error_message'] ?? 'An error occurred.'
        ]);

        // Log failed attempts
        foreach ($messages as $msg) {
            sms_logs($msg['to'], $msg['message'], 2);
        }
    }
    exit;
}


/*************************** SMS Package Add **********************************************/

if (isset($_GET['add_sms_package']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    /* Sanitize input values */
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : '';
    $quantity = isset($_POST["quantity"]) ? trim($_POST["quantity"]) : '';
    $price = isset($_POST["price"]) ? trim($_POST["price"]) : '';
    
    /* Validate pop_id */
    if (empty($name)) {
        $errors['name'] = "Name is required.";
    }
    
    /* Validate area_id */
    if (empty($quantity)) {
        $errors['quantity'] = "Quantity is required.";
    }
    
    /* Validate message */
    if (empty($price)) {
        $errors['price'] = "Price is required.";
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
    $stmt = $con->prepare("INSERT INTO sms_packages (name, sms_quantity, price, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");

    /* Bind parameters correctly */
    $stmt->bind_param('sid', $name, $quantity, $price);

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
    exit; 
}


if (isset($_GET['show_sms_package_data']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
	require 'datatable.php';

	$table = 'sms_packages';
	$primaryKey = 'id';
	$columns = array(
		array('db' => 'id', 'dt' => 0),
        array('db'=>'name','dt'=>1,'formatter'=>function($d, $row)use ($con){
            return $d; 

        }),
        array('db'=>'sms_quantity','dt'=>2,'formatter'=>function($d, $row)use ($con){
            return $d; 

        }),
        array('db'=>'price','dt'=>3,'formatter'=>function($d, $row)use ($con){
            return $d; 

        }),
        array(
			'db'=>'id',
			'dt'=>4,
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


if (isset($_GET['get_message_package']) && isset($_GET['id'])) { 
	$id = intval($_GET['id']); 

	// Prepare the SQL statement
	$stmt = $con->prepare("SELECT * FROM sms_packages WHERE id = ?");
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


if (isset($_GET['update_sms_package']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    /* Sanitize input values */
    $id = isset($_POST["id"]) ? trim($_POST["id"]) : '';
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : '';
    $quantity = isset($_POST["quantity"]) ? trim($_POST["quantity"]) : '';
    $price = isset($_POST["price"]) ? trim($_POST["price"]) : '';
    
    /* Validate pop_id */
    if (empty($name)) {
        $errors['name'] = "Name is required.";
    }
    
    /* Validate area_id */
    if (empty($quantity)) {
        $errors['quantity'] = "Quantity is required.";
    }
    
    /* Validate message */
    if (empty($price)) {
        $errors['price'] = "Price is required.";
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
    $stmt = $con->prepare("UPDATE sms_packages SET name = ?, sms_quantity = ?, price = ? WHERE id = ?");

    /* Bind parameters correctly */
    $stmt->bind_param('sidi', $name, $quantity, $price,  $id); 

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
    exit; 
}



if (isset($_POST['sms_package_delete_data']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
	$id=$_POST['id'];

	/* Delete query */
	$stmt = $con->prepare("DELETE FROM sms_packages WHERE id = ?");
	/* Bind parameters correctly */
	$stmt->bind_param('i', $id);
	/* Execute the statement */
	$result = $stmt->execute();
	/* Check if deletion was successful */
	if ($result) {
		echo json_encode([
			'success' => true,
			'message' => 'Deleted successfully!'
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
    exit; 
}
/***************************  SMS logs Get Data *********************************************/
if (isset($_GET['get_sms_logs_data']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    include 'db_connect.php'; // ডাটাবেস কানেকশন ইনক্লুড করতে ভুলবেনা

    $data = [];

    /* Start Date Check */ 
    if (!isset($_GET['start_date']) || empty($_GET['start_date'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid Start Date']);
        exit;
    }

    /* End Date Check */
    if (!isset($_GET['end_date']) || empty($_GET['end_date'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid End Date']);
        exit;
    }

    /* POP ID Check */ 
    if (!isset($_GET['pop_id']) || !is_numeric($_GET['pop_id']) || (int)$_GET['pop_id'] <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid POP ID']);
        exit;
    }

    /* Get SMS Logs */
    $start_date = trim($_GET['start_date']);
    $end_date = trim($_GET['end_date']);
    $pop_id = (int) $_GET['pop_id'];
    $area_id = isset($_GET['area_id']) ? (int) $_GET['area_id'] : null;

    $condition = " WHERE sms_logs.pop_id = '$pop_id'";

    if ($area_id) {
        $condition .= " AND sms_logs.area_id = '$area_id'";
    }

    $condition .= " AND sms_logs.created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";

    $query = "
        SELECT 
            sms_logs.*, 
            add_pop.pop AS pop_name, 
            area_list.name AS area_name , 
            customers.username AS username
        FROM sms_logs
        LEFT JOIN add_pop ON sms_logs.pop_id = add_pop.id
        LEFT JOIN area_list ON sms_logs.area_id = area_list.id
        LEFT JOIN customers ON sms_logs.customer_id = customers.id
        $condition
        ORDER BY sms_logs.created_at DESC
    ";

    $result = $con->query($query);

    if ($result && $result->num_rows > 0) {
        $html = '';

        while ($row = $result->fetch_assoc()) {
            /** Status */
            $logs_status = $row['status'] == 1 
                ? '<span class="badge bg-success">Success</span>' 
                : '<span class="badge bg-danger">Failed</span>';

            /* Message */
            $message = $row['message'];
            if (strlen($message) > 40) {
                $message = substr($message, 0, 40) . '...';
            }

            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($row['id']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['username']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['pop_name'] ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($row['area_name'] ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($row['phone_number']) . '</td>';
            $html .= '<td>' . $logs_status . '</td>';
            $html .= '<td>' . htmlspecialchars($message) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['sent_at']) . '</td>';
            $html .= '</tr>';
        }

        echo json_encode(['success' => true, 'data' => $html]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No data found']);
    }
    exit;
}



?>