<?php
include 'db_connect.php';

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_GET['get_area_data'])) {
    $area_list = [];

    /* Fetch specific area data by ID*/
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];

        /* Validate and fetch specific area data using a prepared statement*/
        $stmt = $con->prepare("SELECT id, name FROM area_list WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode([
                'success' => true,
                'message' => 'Success',
                'data' => $row,
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Area not found',
            ]);
        }
        exit();
    }

    /* Fetch all areas by pop_id if provided*/
    if (!empty($_GET['pop_id'])) {
        $pop_id = $_GET['pop_id'];

        $stmt = $con->prepare("SELECT id, name FROM area_list WHERE pop_id = ?");
        $stmt->bind_param("i", $pop_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $area_list[] = [
                'id' => $row['id'],
                'name' => $row['name'],
            ];
        }

        if (!empty($area_list)) {
            echo json_encode([
                'success' => true,
                'data' => $area_list,
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No areas found for the specified pop_id',
            ]);
        }
        exit();
    }

    /* Fetch all areas based on session user_pop or default*/
    $pop_id = $_SESSION['user_pop'] ?? 1;
    $query = !empty($_SESSION['user_pop']) 
        ? "SELECT id, name FROM area_list WHERE pop_id = ?" 
        : "SELECT id, name FROM area_list";

    $stmt = $con->prepare($query);
    if (!empty($_SESSION['user_pop'])) {
        $stmt->bind_param("i", $pop_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $area_list[] = [
            'id' => $row['id'],
            'name' => $row['name'],
        ];
    }

    echo json_encode([
        'success' => !empty($area_list),
        'data' => $area_list,
        'message' => !empty($area_list) ? 'Data retrieved successfully' : 'No data found!',
    ]);
    exit();
}
?>
