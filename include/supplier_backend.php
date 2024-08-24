<?php 
 include("db_connect.php");
	
	

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_supplier_data'])) {
        $fullname = $_POST['fullname'];
        $company = $_POST['company'];
       $phone_number = $_POST['phone_number'];
       $address = $_POST['address'];
       $email = $_POST['email'];
       $status = $_POST['status'] ?? 0;

	    /* Prepare an SQL statement*/
	    $stmt = $con->prepare("INSERT INTO suppliers(`fullname`,`company`,`status`,`mobile`, `email`, `address`) VALUES(?, ?, ?,?,?,?)");
	    
	    /* Bind parameters*/
	    $stmt->bind_param("ssisss", $fullname,$company,$status, $phone_number,$email,$address);

	    /* Execute the statement*/
	    if ($stmt->execute()) {
	        $response = array("success" => true, "message" => "Added Successfully");
	    } else {
	        $response = array("success" => false, "message" => "Error: " . $stmt->error);
	    }

	    /*Close the statement*/ 
	    $stmt->close();

	    /* Close the database connection*/
	    $con->close();

	    /* Return the response as JSON*/
	    echo json_encode($response);
	    exit; 
	}

	
	if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit_data'])) {
	    $id = intval($_GET['id']); 

	    // Prepare the SQL statement
	    $stmt = $con->prepare("SELECT * FROM suppliers WHERE id = ?");
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




	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_data'])) {

	    $id = intval($_POST['id']);

	    /*Prepare the SQL statement*/ 
	    $stmt = $con->prepare("DELETE FROM suppliers WHERE id = ?");
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


	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['update_supplier_data'])) {
	 	$fullname = $_POST['fullname'];
	 	$company = $_POST['company'];
	    $phone_number = $_POST['phone_number'];
	    $address = $_POST['address'];
	    $email = $_POST['email'];
	    $status = $_POST['status'];
	    $id = $_POST['id'];


	    /* Prepare an SQL statement*/
	    $stmt = $con->prepare("UPDATE `suppliers` SET fullname = ?, company = ?, status=?, mobile = ?,  email = ?, address = ? WHERE id = ?");
	   
	    /* Bind parameters*/
	    $stmt->bind_param("ssisssi", $fullname, $company,$status,$phone_number, $email ,$address, $id);

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


?>