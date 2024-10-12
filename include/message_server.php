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
