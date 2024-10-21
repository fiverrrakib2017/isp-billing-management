<?php
include 'db_connect.php';
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_GET['get_area_data'])) {
    $area_list = [];

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];

        // Validate and fetch specific area data using prepared statement
        $stmt = $con->prepare("SELECT id, name FROM area_list WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Return specific area data in JSON format
            echo json_encode([
                'success' => true,
                'message' => 'Success',
                'data' => $row,
            ]);
        } else {
            // If the area is not found
            echo json_encode([
                'success' => false,
                'message' => 'Not Found',
            ]);
        }
        
        exit(); // Stop further execution if specific area data is fetched
    }

    if (!empty($_SESSION['user_pop'])) {
        $pop_id = $_SESSION['user_pop'];
        $stmt = $con->prepare("SELECT id, name FROM area_list WHERE pop_id = ?");
        $stmt->bind_param("i", $pop_id);
    } else {
        $pop_id = 1;
        $stmt = $con->prepare("SELECT id, name FROM area_list");
       
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all data
    while ($rows = $result->fetch_assoc()) {
        $area_list[] = array(
            'id' => $rows['id'],
            'name' => $rows['name'],
        );
    }

    if (count($area_list) > 0) {
        echo json_encode([
            'success' => true,
            'data' => $area_list,
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No data found!',
        ]);
    }

    exit();
}
?>
