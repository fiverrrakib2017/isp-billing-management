<?php
include "db_connect.php";
require 'datatable.php';
 if (isset($_GET['show_department_data']) && $_SERVER['REQUEST_METHOD']=='GET') {
	$table = 'department';
	$primaryKey = 'id';

	$columns = array(
		array('db' => 'id', 'dt' => 0),
		array(
			'db' => 'department_name', 
			'dt' => 1,
		),
		array(
			'db'=>'id',
			'dt'=>2,
			'formatter'=>function($d, $row){
				return '
				<button type="button" name="edit_button" data-id='.$row['id'].' class="btn-sm btn btn-primary"> <i class="fas fa-edit"></i></button> 

				<button type="button" name="delete_button" data-id='.$row['id'].' class="btn-sm btn btn-danger"> <i class="fas fa-trash"></i></button>'; 
			}
		),
		
		
	);

	$condition = ""; 
	/* Output JSON for DataTables to handle*/
	echo json_encode(
		SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns,null, $condition)
	);
 }

 if (isset($_GET['get_all_department'])&& $_SERVER['REQUEST_METHOD']=='GET') {
	$result = $con->query("SELECT id,department_name FROM department");
    $data = [];
    while ($row = $result->fetch_array()) {
        $data[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}
 
 if (isset($_GET['add_department']) && $_SERVER['REQUEST_METHOD']=='POST') {
    $errors = [];
    $department_name = isset($_POST["department_name"]) ? trim($_POST["department_name"]) : '';

    /* Validate Department Name */
	if (empty($department_name)) {
		$errors['department_name'] = "Departmnet Name is required.";
	}
    /* If validation errors exist, return errors */
	if (!empty($errors)) {
		echo json_encode([
			'success' => false,
			'errors' => $errors
		]);
		exit;
	}
     /*Insert query*/ 
     $stmt = $con->prepare("INSERT INTO department (`department_name`) VALUES (?)");
     $stmt->bind_param('s', $department_name);
 
     $result = $stmt->execute();
 
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Department Added Successfully!'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Error: ' . $stmt->error
            ]);
        }
 
     $stmt->close();
 }

 if (isset($_GET['get_department']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $department_id =intval( $_GET['id']);

    /* Prepare the SQL statement*/
    $stmt = $con->prepare("SELECT * FROM department WHERE id = ?");
    $stmt->bind_param("i", $department_id);

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
if (isset($_GET['update_department']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $department_id = $_POST['id'];
    $department_name = $_POST['department_name'];


    /* Prepare an SQL statement*/
    $stmt = $con->prepare("UPDATE `department` SET department_name = ? WHERE id = ?");
	   
    /* Bind parameters*/
    $stmt->bind_param("si", $department_name, $department_id);

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
if (isset($_POST['delete_data']) && $_SERVER['REQUEST_METHOD']=='POST') {
    $id = intval($_POST['id']);

    /*Prepare the SQL statement*/ 
    $stmt = $con->prepare("DELETE FROM department WHERE id = ?");
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


/*==================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================*/
if (isset($_GET['show_shift_data']) && $_SERVER['REQUEST_METHOD']=='GET') {
	$table = 'shifts';
	$primaryKey = 'id';

	$columns = array(
		array('db' => 'id', 'dt' => 0),
		array(
			'db' => 'shift_name', 
			'dt' => 1,
		),
		array(
			'db' => 'start_time', 
			'dt' => 2,
            'formatter' => function($d, $row) {
                return date('h:i A', strtotime($d));
            }
		),
		array(
			'db' => 'end_time', 
			'dt' => 3,
            'formatter' => function($d, $row) {
                return date('h:i A', strtotime($d));
            }
		),
		array(
			'db'=>'id',
			'dt'=>4,
			'formatter'=>function($d, $row){
				return '
				<button type="button" name="edit_button" data-id='.$row['id'].' class="btn-sm btn btn-primary"> <i class="fas fa-edit"></i></button> 

				<button type="button" name="delete_button" data-id='.$row['id'].' class="btn-sm btn btn-danger"> <i class="fas fa-trash"></i></button>'; 
			}
		),
		
		
	);

	$condition = ""; 
	/* Output JSON for DataTables to handle*/
	echo json_encode(
		SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns,null, $condition)
	);
 }


 if (isset($_GET['get_shift']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $_id =intval( $_GET['id']);

    /* Prepare the SQL statement*/
    $stmt = $con->prepare("SELECT * FROM `shifts` WHERE id = ?");
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

if (isset($_GET['get_all_shift'])&& $_SERVER['REQUEST_METHOD']=='GET') {
	$result = $con->query("SELECT id,shift_name,start_time,end_time FROM shifts");
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if (isset($_GET['add_shift']) && $_SERVER['REQUEST_METHOD']=='POST') {
    $errors = [];
    $shift_name = isset($_POST["shift_name"]) ? trim($_POST["shift_name"]) : '';
    $start_time = isset($_POST["start_time"]) ? trim($_POST["start_time"]) : '';
    $end_time = isset($_POST["end_time"]) ? trim($_POST["end_time"]) : '';

    /* Validate Department Name */
	if (empty($shift_name)) {
		$errors['shift_name'] = "Shift Name is required.";
	}
	if (empty($start_time)) {
		$errors['start_time'] = "Start Time is required.";
	}
	if (empty($end_time)) {
		$errors['end_time'] = "End Time is required.";
	}
    /* If validation errors exist, return errors */
	if (!empty($errors)) {
		echo json_encode([
			'success' => false,
			'errors' => $errors
		]);
		exit;
	}
     /*Insert query*/ 
     $stmt = $con->prepare("INSERT INTO `shifts` (`shift_name`,`start_time`,`end_time`) VALUES (?,?,?)");
     $stmt->bind_param('sss', $shift_name, $start_time,$end_time);
 
     $result = $stmt->execute();
 
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
 
     $stmt->close();
}

if (isset($_GET['get_shift']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $_id =intval( $_GET['id']);

    /* Prepare the SQL statement*/
    $stmt = $con->prepare("SELECT * FROM shifts WHERE id = ?");
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

if (isset($_GET['update_shift']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $shift_name = $_POST['shift_name'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];


    /* Prepare an SQL statement*/
    $stmt = $con->prepare("UPDATE `shifts` SET shift_name = ?, start_time=?,end_time=? WHERE id = ?");
	   
    /* Bind parameters*/
    $stmt->bind_param("sssi", $shift_name, $start_time,$end_time, $id);

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

if (isset($_POST['shift_delete_data']) && $_SERVER['REQUEST_METHOD']=='POST') {
    $id = intval($_POST['id']);

    /*Prepare the SQL statement*/ 
    $stmt = $con->prepare("DELETE FROM `shifts` WHERE id = ?");
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


/*==================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================*/
if (isset($_GET['add_employee']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    /*Retrieving form data*/ 
    $employee_code = isset($_POST["employee_code"]) ? trim($_POST["employee_code"]) : '';
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : '';
    $father_name = isset($_POST["father_name"]) ? trim($_POST["father_name"]) : '';
    $mother_name = isset($_POST["mother_name"]) ? trim($_POST["mother_name"]) : '';
    $nid = isset($_POST["nid"]) ? trim($_POST["nid"]) : '';
    $birth_date = isset($_POST["birth_date"]) ? trim($_POST["birth_date"]) : '';
    $gender = isset($_POST["gender"]) ? trim($_POST["gender"]) : '';
    $phone_number = isset($_POST["phone_number"]) ? trim($_POST["phone_number"]) : '';
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
    $address = isset($_POST["address"]) ? trim($_POST["address"]) : '';
    $division = isset($_POST["division"]) ? trim($_POST["division"]) : '';
    $district = isset($_POST["district"]) ? trim($_POST["district"]) : '';
    $upazila = isset($_POST["upazila"]) ? trim($_POST["upazila"]) : '';
    $postal_code = isset($_POST["postal_code"]) ? trim($_POST["postal_code"]) : '';
    $joining_date = isset($_POST["joining_date"]) ? trim($_POST["joining_date"]) : '';
    $designation = isset($_POST["designation"]) ? trim($_POST["designation"]) : '';
    $department = isset($_POST["department"]) ? trim($_POST["department"]) : '';
    $salary = isset($_POST["salary"]) ? trim($_POST["salary"]) : '';
    $status = isset($_POST["status"]) ? 'Active':'Inactive';

    /*Basic validation for some fields*/ 
    if (empty($employee_code)) {
        $errors['employee_code'] = "Employee Code is required.";
    }
    if (empty($name)) {
        $errors['name'] = "Employee Name is required.";
    }
    if (empty($phone_number)) {
        $errors['phone_number'] = "Phone Number is required.";
    }
    if (empty($email)) {
        $errors['email'] = "Email is required.";
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
    $stmt = $con->prepare("INSERT INTO `employees` 
        (`employee_code`, `name`, `father_name`, `mother_name`, `nid`, `birth_date`, `gender`, 
         `phone_number`, `email`, `address`, `division`, `district`, `upazila`, `postal_code`, 
         `joining_date`, `designation`, `department`, `salary`, `status`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        'ssssssssssssssssiss', 
        $employee_code, $name, $father_name, $mother_name, $nid, $birth_date, $gender, 
        $phone_number, $email, $address, $division, $district, $upazila, $postal_code, 
        $joining_date, $designation, $department, $salary, $status
    );

    $result = $stmt->execute();

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Employee added successfully!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Error: ' . $stmt->error
        ]);
    }

    $stmt->close();
}
