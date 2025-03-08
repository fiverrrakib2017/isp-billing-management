<?php
include "db_connect.php";
require 'datatable.php';
if (isset($_GET['show_bank_data']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $table = 'banks';
    $primaryKey = 'id';

    $columns = array(
        array('db' => 'id', 'dt' => 0),
        array(
            'db' => 'bank_name',
            'dt' => 1,
        ),
        array(
            'db' => 'branch_name',
            'dt' => 2,
        ),
        array(
            'db' => 'account_number',
            'dt' => 3,
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

if (isset($_GET['get_all_bank']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $result = $con->query("SELECT id,unit_name FROM units");
    $data = [];
    while ($row = $result->fetch_array()) {
        $data[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if (isset($_GET['add_bank']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $bank_name = isset($_POST["bank_name"]) ? trim($_POST["bank_name"]) : '';
    $branch_name = isset($_POST["branch_name"]) ? trim($_POST["branch_name"]) : '';
    $account_number = isset($_POST["account_number"]) ? trim($_POST["account_number"]) : '';

    /* Validate Bank Name */
    if (empty($bank_name)) {
        $errors['bank_name'] = "Bank Name is required.";
    }
    if (empty($branch_name)) {
        $errors['branch_name'] = "Branch Name is required.";
    }
    if (empty($account_number)) {
        $errors['account_number'] = "Account Number is required.";
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
    $stmt = $con->prepare("INSERT INTO banks (`bank_name`, `branch_name`, `account_number`, `created_at`) VALUES (?,?,?,NOW())");
    $stmt->bind_param('sss', $bank_name,$branch_name,$account_number);

    $result = $stmt->execute();

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Bank Added Successfully!',
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Error: ' . $stmt->error,
        ]);
    }

    $stmt->close();
}

if (isset($_GET['get_bank']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $_id = intval($_GET['id']);

    /* Prepare the SQL statement*/
    $stmt = $con->prepare("SELECT * FROM banks WHERE id = ?");
    $stmt->bind_param("i", $_id);

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
if (isset($_GET['update_bank']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $_id = $_POST['id'];

    $bank_name = isset($_POST["bank_name"]) ? trim($_POST["bank_name"]) : '';
    $branch_name = isset($_POST["branch_name"]) ? trim($_POST["branch_name"]) : '';
    $account_number = isset($_POST["account_number"]) ? trim($_POST["account_number"]) : '';
    /* Validate Bank Name */
    if (empty($bank_name)) {
        $errors['bank_name'] = "Bank Name is required.";
    }
    if (empty($branch_name)) {
        $errors['branch_name'] = "Branch Name is required.";
    }
    if (empty($account_number)) {
        $errors['account_number'] = "Account Number is required.";
    }
    // print_r($_POST); exit; 
    // echo $_POST; exit; 
    /* Prepare an SQL statement*/
    $stmt = $con->prepare("UPDATE `banks` SET bank_name = ?, branch_name=?,account_number=? WHERE id = ?");

    /* Bind parameters*/
    $stmt->bind_param("sssi", $bank_name,$branch_name,$account_number, $_id);

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
    $stmt = $con->prepare("DELETE FROM banks WHERE id = ?");
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