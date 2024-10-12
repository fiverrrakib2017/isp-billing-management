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
function get_message_schedule_data(){

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
			return 'Unknown Area';

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
				<button type="button" name="settings_button" data-id='.$row['id'].' class="btn-sm btn btn-danger"> <i class="fas fa-cog"></i></button>
				<a class="btn-sm btn btn-success" href="tickets_profile.php?id='.$row['id'].'"><i class="fas fa-eye"></i></a>'; 
			}
		),
		
		
	);

	$condition = ""; 
	/* Output JSON for DataTables to handle*/
	echo json_encode(
		SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns,null, $searchCondition)
	);
}