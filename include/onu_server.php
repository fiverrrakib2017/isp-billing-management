<?php
include "db_connect.php";
require 'datatable.php';
if (isset($_GET['show_onu_data']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $table = 'onu_list';
    $primaryKey = 'id';
    $columns = array(
        array('db' => 'id', 'dt' => 0),
        array(
            'db' => 'name',
            'dt' => 1,
        ),
        array(
            'db' => 'serial_no',
            'dt' => 2,
        ),
        array(
            'db' => 'status',
            'dt' => 3,
            'formatter' => function ($d, $row) {
              
                if( $d == '0') {
                    return '<span class="badge bg-danger">Unsold</span>';
                } else if ($d == '1') {
                    return '<span class="badge bg-success">Sold</span>';
                } else {
                    return '<span class="badge bg-secondary">Unknown</span>';
                }
            },
        ),
        array(
            'db' => 'id',
            'dt' => 4,
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

if (isset($_GET['get_all_onu']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $result     = $con->query("SELECT * FROM onu_list");
    $data       = [];
    while ($row = $result->fetch_array()) {
        $data[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if (isset($_GET['add_onu']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors     = [];
    $name       = isset($_POST["name"]) ? trim($_POST["name"]) : '';
    $serial_no  = isset($_POST["serial_no"]) ? trim($_POST["serial_no"]) : '';
    //$status     = isset($_POST["status"]) ? trim($_POST["status"]) : '0';
    $status     =0;
    /* Validate  Name */
    if (empty($name)) {
        $errors['name'] = "Name Name is required.";
    }
    /* Validate  serial_no */
    if (empty($serial_no)) {
        $errors['serial_no'] = "Serial No is required.";
    }
    /* Validate  status */
    // if (empty($status)) {
    //     $errors['status'] = "Status Name is required.";
    // }
    /* If validation errors exist, return errors */
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'errors' => $errors,
        ]);
        exit;
    }
    /*Insert query*/
    $stmt = $con->prepare("INSERT INTO onu_list (`name`,`serial_no`,`status`) VALUES (?,?,?)");
    $stmt->bind_param('ssi', $name, $serial_no, $status);
    /* Execute the statement*/
    $result = $stmt->execute();

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Added Successfully!',
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Error: ' . $stmt->error,
        ]);
    }

    $stmt->close();
}

if (isset($_GET['get_onu']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = intval($_GET['id']);

    /* Prepare the SQL statement*/
    $stmt = $con->prepare("SELECT * FROM onu_list WHERE id = ?");
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

    /*Close the statement*/
    $stmt->close();
    $con->close();

    /* Return the response as JSON*/
    echo json_encode($response);
    exit;
}
if (isset($_GET['update_onu']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id  = $_POST['id'];
    $name           = $_POST['name'];
    $serial_no      = $_POST['serial_no'];
    $status         = $_POST['status'];

    /* Prepare an SQL statement*/
    $stmt = $con->prepare("UPDATE `onu_list` SET `name` = ? , `serial_no`=? , `status`=? WHERE id = ?");

    /* Bind parameters*/
    $stmt->bind_param("ssii", $name, $serial_no, $status,$id);

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
    $stmt = $con->prepare("DELETE FROM onu_list WHERE id = ?");
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
?>