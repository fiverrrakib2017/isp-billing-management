<?php
include "db_connect.php";
require 'datatable.php';
if (isset($_GET['show_unit_data']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $table = 'units';
    $primaryKey = 'id';

    $columns = array(
        array('db' => 'id', 'dt' => 0),
        array(
            'db' => 'unit_name',
            'dt' => 1,
        ),
        array(
            'db' => 'id',
            'dt' => 2,
            'formatter' => function ($d, $row) {
                return '
				<button type="button" name="edit_button" data-id=' . $row['id'] . ' class="btn-sm btn btn-primary"> <i class="fas fa-edit"></i></button>

				<button type="button" name="delete_button" data-id=' . $row['id'] . ' class="btn-sm btn btn-danger"> <i class="fas fa-trash"></i></button>';
            },
        ),

    );

    $condition = "";
    /* Output JSON for DataTables to handle*/
    echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, $condition)
    );
}

if (isset($_GET['get_all_unit']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $result = $con->query("SELECT id,unit_name FROM units");
    $data = [];
    while ($row = $result->fetch_array()) {
        $data[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if (isset($_GET['add_unit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $unit_name = isset($_POST["unit_name"]) ? trim($_POST["unit_name"]) : '';

    /* Validate Department Name */
    if (empty($unit_name)) {
        $errors['unit_name'] = "Unit Name is required.";
    }
    /* If validation errors exist, return errors */
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'errors' => $errors,
        ]);
        exit;
    }
    /*Insert query*/
    $stmt = $con->prepare("INSERT INTO units (`unit_name`) VALUES (?)");
    $stmt->bind_param('s', $unit_name);

    $result = $stmt->execute();

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Unit Added Successfully!',
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Error: ' . $stmt->error,
        ]);
    }

    $stmt->close();
}

if (isset($_GET['get_unit']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $unit_id = intval($_GET['id']);

    /* Prepare the SQL statement*/
    $stmt = $con->prepare("SELECT * FROM units WHERE id = ?");
    $stmt->bind_param("i", $unit_id);

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

    /*Close the statement*/
    $stmt->close();
    $con->close();

    /* Return the response as JSON*/
    echo json_encode($response);
    exit;
}
if (isset($_GET['update_unit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $unit_id = $_POST['id'];
    $unit_name = $_POST['unit_name'];

    /* Prepare an SQL statement*/
    $stmt = $con->prepare("UPDATE `units` SET unit_name = ? WHERE id = ?");

    /* Bind parameters*/
    $stmt->bind_param("si", $unit_name, $unit_id);

    /* Execute the statement*/
    if ($stmt->execute()) {
        $response = array("success" => true, "message" => "Update Successfully");
    } else {
        $response = array("success" => false, "message" => "Error: " . $stmt->error);
    }

    // Close the statement
    $stmt->close();

    /* Close the database connection*/
    $con->close();

    /*Return the response as JSON*/
    echo json_encode($response);
    exit;
}
if (isset($_POST['delete_data']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);

    /*Prepare the SQL statement*/
    $stmt = $con->prepare("DELETE FROM units WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response = array("success" => true, "message" => "Record deleted successfully!");

        } else {
            $response = array("success" => false, "message" => "No record found with the provided ID!");
        }
    } else {
        $response = array("success" => false, "message" => "Error executing query: " . $stmt->error);
    }

    /*Close the statement and connection*/
    $stmt->close();
    $con->close();

    /* Return the response as JSON*/
    echo json_encode($response);
    exit;
}