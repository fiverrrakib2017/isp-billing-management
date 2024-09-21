<?php
include "db_connect.php";
require 'datatable.php';
if (isset($_GET['show_department_data']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $table = 'department';
    $primaryKey = 'id';

    $columns = array(
        array('db' => 'id', 'dt' => 0),
        array(
            'db' => 'department_name',
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

if (isset($_GET['get_all_department']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $result = $con->query("SELECT id,department_name FROM department");
    $data = [];
    while ($row = $result->fetch_array()) {
        $data[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if (isset($_GET['add_department']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
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
            'errors' => $errors,
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
            'message' => 'Department Added Successfully!',
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Error: ' . $stmt->error,
        ]);
    }

    $stmt->close();
}

if (isset($_GET['get_department']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $department_id = intval($_GET['id']);

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
if (isset($_POST['delete_data']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
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
if (isset($_GET['show_shift_data']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
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
            'formatter' => function ($d, $row) {
                return date('h:i A', strtotime($d));
            },
        ),
        array(
            'db' => 'end_time',
            'dt' => 3,
            'formatter' => function ($d, $row) {
                return date('h:i A', strtotime($d));
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

if (isset($_GET['get_all_shift']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $result = $con->query("SELECT id,shift_name,start_time,end_time FROM shifts");
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if (isset($_GET['add_shift']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
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
            'errors' => $errors,
        ]);
        exit;
    }
    /*Insert query*/
    $stmt = $con->prepare("INSERT INTO `shifts` (`shift_name`,`start_time`,`end_time`) VALUES (?,?,?)");
    $stmt->bind_param('sss', $shift_name, $start_time, $end_time);

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

if (isset($_GET['get_shift']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $_id = intval($_GET['id']);

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
    $stmt->bind_param("sssi", $shift_name, $start_time, $end_time, $id);

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

if (isset($_POST['shift_delete_data']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
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
if (isset($_GET['show_employee_data']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $table = 'employees';
    $primaryKey = 'id';

    $columns = array(
        array('db' => 'id', 'dt' => 0),
        array(
            'db' => 'name',
            'dt' => 1,
        ),
        array(
            'db' => 'phone_number',
            'dt' => 2,
        ),
        array(
            'db' => 'email',
            'dt' => 3,
        ),
        array(
            'db' => 'designation',
            'dt' => 4,
        ),
        array(
            'db' => 'department',
            'dt' => 5,
            'formatter' => function($d, $row) use ($con) {
                $department_id = $d;
                $all_department = $con->query("SELECT * FROM department WHERE id=$department_id");
                $row = $all_department->fetch_array();
                return $row['department_name'];
            }
        ),
        array(
            'db' => 'postal_code',
            'dt' => 6,
        ),
        array(
            'db' => 'joining_date',
            'dt' => 7,
        ),
        array(
            'db' => 'id',
            'dt' => 8,
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

if (isset($_GET['get_all_employee']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $result = $con->query("SELECT id,name FROM employees");
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

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
    $status = isset($_POST["status"]) ? 'Active' : 'Inactive';

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
            'errors' => $errors,
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
            'message' => 'Employee added successfully!',
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => $stmt->error,
        ]);
    }

    $stmt->close();
}

if (isset($_GET['get_employee']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $_id = intval($_GET['id']);

    /* Prepare the SQL statement*/
    $stmt = $con->prepare("SELECT * FROM `employees` WHERE id = ?");
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
if (isset($_GET['edit_employee']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST["id"]) ? trim($_POST["id"]) : ''; 
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
    $status = isset($_POST["status"]) ? trim($_POST["status"]) : '';

    $errors = [];

   

    if (empty($employee_code)) {
        $errors['employee_code'] = "Employee Code is required.";
    }

    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'errors' => $errors
        ]);
        exit;
    }
 

    /*Update query*/
    $stmt = $con->prepare("UPDATE `employees` SET `employee_code`=?, `name`=?, `father_name`=?, `mother_name`=?, `nid`=?, `birth_date`=?, `gender`=?, `phone_number`=?, `email`=?, `address`=?, `division`=?, `district`=?, `upazila`=?, `postal_code`=?, `joining_date`=?, `designation`=?, `department`=?, `salary`=?  WHERE `id`=?");
    $stmt->bind_param('ssssssssssssssssisi', $employee_code, $name, $father_name, $mother_name, $nid, $birth_date, $gender, $phone_number, $email, $address, $division, $district, $upazila, $postal_code, $joining_date, $designation, $department, $salary, $id);
   
    $result = $stmt->execute();

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Employee updated successfully!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $stmt->error
        ]);
    }

    $stmt->close();
}


if (isset($_POST['employee_delete_data']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);

    /*Prepare the SQL statement*/
    $stmt = $con->prepare("DELETE FROM `employees` WHERE id = ?");
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


/*============================================================================================================================================Leave======================================================================================================================================================================================================================================================================================================================================================================*/
if (isset($_GET['show_leave_data']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $table = 'leaves';
    $primaryKey = 'id';

    $columns = array(
        array('db' => 'id', 'dt' => 0),
        array(
            'db' => 'employee_id',
            'dt' => 1,
            'formatter' => function($d, $row) use ($con) {
                $employee_id = $d;
                $all_employee = $con->query("SELECT name FROM employees WHERE id=$employee_id");
                $row = $all_employee->fetch_array();
                return $row['name'];
            }
        ),
        array(
            'db' => 'leave_type',
            'dt' => 2,
        ),
        array(
            'db' => 'leave_reason',
            'dt' => 3,
            // 'formatter'=>function($d, $row) {
            //     /* Check if the string contains '<br>' and remove everything after it*/
            //     if (strpos($d, '<br>') !== false) {
            //         $d = substr($d, 0, strpos($d, '<br>'));
            //     }
            //     if (strlen($d) > 30) {
            //         return substr($d, 0, 30) . '...'; 
            //     } else {
            //         return $d;
            //     }
            // }
            'formatter'=>function($d, $row) {
            /*to find the position of '<br>'*/
            // function findPosition($haystack, $needle) {
            //     $length = customStrlen($needle);
            //     for ($i = 0; $i <= customStrlen($haystack) - $length; $i++) {
            //         $match = true;
            //         for ($j = 0; $j < $length; $j++) {
            //             if ($haystack[$i + $j] !== $needle[$j]) {
            //                 $match = false;
            //                 break;
            //             }
            //         }
            //         if ($match) {
            //             return $i;
            //         }
            //     }
            //     return false;
            // }

            // function customSubstr($string, $start, $length = null) {
            //     $result = '';
            //     $strLength = customStrlen($string);
            //     if ($length === null) {
            //         $length = $strLength - $start;
            //     }
            //     for ($i = $start; $i < $start + $length && $i < $strLength; $i++) {
            //         $result .= $string[$i];
            //     }
            //     return $result;
            // }
            // function customStrlen($string) {
            //     $length = 0;
            //     while (isset($string[$length])) {
            //         $length++;
            //     }
            //     return $length;
            // }
            // $position = findPosition($d, '<br>');
            // if ($position !== false) {
            //     $d = customSubstr($d, 0, $position);
            // }
            // if (customStrlen($d) > 30) {
            //     return customSubstr($d, 0, 30) . '...';
            // } else {
            //     return $d; 
            // }
            if (strpos($d, '<br>') !== false) {
                $d = substr($d, 0, strpos($d, '<br>'));
            }
            if (strlen($d) > 30) {
                return substr($d, 0, 30) . '...'; 
            } else {
                return $d;
            }
        }


        ),
        array(
            'db' => 'leave_status',
            'dt' => 4,
            'formatter'=>function($d, $row){
                if($d == 'Approved'){
                    return '<span class="badge bg-success">Approved</span>';
                }elseif($d=='Rejected'){
                    return '<span class="badge bg-danger">Rejected</span>';
                }
                else{
                    return '<span class="badge bg-danger">Pending</span>';
                }
            }
        ),
        array(
            'db' => 'start_date',
            'dt' => 5,
            'formatter' => function($d, $row) {
            // function customDateFormat($dateString) {
            //     $timestamp = customStrToTime($dateString);
            //     if ($timestamp === false) {
            //         return $dateString; 
            //     }
            //     $day = customDate('d', $timestamp);
            //     $month = customDate('M', $timestamp);
            //     $year = customDate('Y', $timestamp);
            //     return $day . ' ' . $month . ' ' . $year;
            // }
            // function customStrToTime($dateString) {
            //     $dateParts = explode('-', $dateString);
            //     if (count($dateParts) !== 3) {
            //         return false; 
            //     }
            //     return mktime(0, 0, 0, $dateParts[1], $dateParts[2], $dateParts[0]);
            // }
            // function customDate($format, $timestamp) {
            //     $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            //     $day = date('d', $timestamp);
            //     $month = date('m', $timestamp);
            //     $year = date('Y', $timestamp);

            //     switch ($format) {
            //         case 'd':
            //             return $day;
            //         case 'M':
            //             return $months[$month - 1];
            //         case 'Y':
            //             return $year;
            //         default:
            //             return '';
            //     }
            // }
            // return customDateFormat($d);
            return date('d M Y', strtotime($d)); 
        }

        ),
        array(
            'db' => 'end_date',
            'dt' => 6,
            'formatter' => function($d, $row) {
                return date('d M Y', strtotime($d)); 
            }
        ),
        array(
            'db' => 'id',
            'dt' => 7,
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

if (isset($_GET['add_leave']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    /*Retrieving form data*/
    $employee_id = isset($_POST["employee_id"]) ? trim($_POST["employee_id"]) : '';
    $leave_type = isset($_POST["leave_type"]) ? trim($_POST["leave_type"]) : '';
    $leave_reason = isset($_POST["leave_reason"]) ? trim($_POST["leave_reason"]) : '';
    $leave_status = isset($_POST["leave_status"]) ? trim($_POST["leave_status"]) : '';

    $start_date = isset($_POST["start_date"]) ? trim($_POST["start_date"]) : '';
    $end_date = isset($_POST["end_date"]) ? trim($_POST["end_date"]) : '';

    /*Basic validation for some fields*/
    if (empty($employee_id)) {
        $errors['employee_id'] = "Employee Name is required.";
    }
    if (empty($leave_type)) {
        $errors['leave_type'] = "Leave Type is required.";
    }
    if (empty($leave_reason)) {
        $errors['leave_reason'] = "Leave Reason is required.";
    }
    if (empty($leave_status)) {
        $errors['leave_status'] = "Leave Status is required.";
    }
    if (empty($start_date)) {
        $errors['start_date'] = "Start Date is required.";
    }
    if (empty($end_date)) {
        $errors['end_date'] = "End Date is required.";
    }

    /* If validation errors exist, return errors */
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'errors' => $errors,
        ]);
        exit;
    }

    /* Insert query */
    $stmt = $con->prepare("INSERT INTO `leaves`(`employee_id`, `leave_type`, `leave_reason`, `leave_status`, `start_date`, `end_date`)VALUES(?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        'isssss',
        $employee_id, $leave_type, $leave_reason, $leave_status, $start_date, $end_date
    );

    $result = $stmt->execute();

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Added successfully!',
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => $stmt->error,
        ]);
    }

    $stmt->close();
}

if (isset($_GET['get_leave']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $_id = intval($_GET['id']);

    /* Prepare the SQL statement*/
    $stmt = $con->prepare("SELECT * FROM `leaves` WHERE id = ?");
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


if (isset($_GET['edit_leave']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $errors = [];
    /*Retrieving form data*/
    $id = isset($_POST["id"]) ? trim($_POST["id"]) : ''; 
    $employee_id = isset($_POST["employee_id"]) ? trim($_POST["employee_id"]) : '';
    $leave_type = isset($_POST["leave_type"]) ? trim($_POST["leave_type"]) : '';
    $leave_reason = isset($_POST["leave_reason"]) ? trim($_POST["leave_reason"]) : '';
    $leave_status = isset($_POST["leave_status"]) ? trim($_POST["leave_status"]) : '';

    $start_date = isset($_POST["start_date"]) ? trim($_POST["start_date"]) : '';
    $end_date = isset($_POST["end_date"]) ? trim($_POST["end_date"]) : '';

    /*Basic validation for some fields*/
    if (empty($employee_id)) {
        $errors['employee_id'] = "Employee Name is required.";
    }
    if (empty($leave_type)) {
        $errors['leave_type'] = "Leave Type is required.";
    }
    if (empty($leave_reason)) {
        $errors['leave_reason'] = "Leave Reason is required.";
    }
    if (empty($leave_status)) {
        $errors['leave_status'] = "Leave Status is required.";
    }
    if (empty($start_date)) {
        $errors['start_date'] = "Start Date is required.";
    }
    if (empty($end_date)) {
        $errors['end_date'] = "End Date is required.";
    }

    /* If validation errors exist, return errors */
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'errors' => $errors,
        ]);
        exit;
    }

    /*Update query*/
    $stmt = $con->prepare("UPDATE `leaves` SET `employee_id`=?, `leave_type`=?, `leave_reason`=?, `leave_status`=?, `start_date`=?, `end_date`=?  WHERE `id`=?");
    $stmt->bind_param('isssssi', $employee_id, $leave_type, $leave_reason, $leave_status, $start_date, $end_date, $id);
   
    $result = $stmt->execute();

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Updated successfully!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $stmt->error
        ]);
    }

    $stmt->close();
}

if (isset($_POST['leave_delete_data']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);

    /*Prepare the SQL statement*/
    $stmt = $con->prepare("DELETE FROM `leaves` WHERE id = ?");
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
