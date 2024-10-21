<?php 
 include("db_connect.php");
 if (!isset($_SESSION)) {
    session_start();
	
}
	

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_works_data'])) {
	    $name = $_POST['name'];
	    $email = $_POST['email'];
	    $phone = $_POST['phone'];
	    $group_id = $_POST['group_id'];

		$pop_id="";
		if (!empty($_SESSION['user_pop'])) {
			$pop_id=$_SESSION['user_pop'];
		}

	    /* Prepare an SQL statement*/
	    $stmt = $con->prepare("INSERT INTO works(`name`, `email`, `phone`, `group_id`,`pop_id`, `create_date`) VALUES(?, ?, ?, ?, ?, NOW())");
	    
	    /* Bind parameters*/
	    $stmt->bind_param("sssii", $name, $email,$phone,$group_id,$pop_id);

	    /* Execute the statement*/
	    if ($stmt->execute()) {
	        $response = array("success" => true, "message" => "Added Successfully");
	    } else {
	        $response = array("success" => false, "message" => "Error: " . $stmt->error);
	    }

	    // Close the statement
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
	    $stmt = $con->prepare("SELECT * FROM works WHERE id = ?");
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
	    $stmt = $con->prepare("DELETE FROM works WHERE id = ?");
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


	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_works_data'])) {
	 	$name = $_POST['name'];
	    $email = $_POST['email'];
	    $phone = $_POST['phone'];
	    $group_id = $_POST['group_id'];
	    $id = $_POST['id'];

	    /* Prepare an SQL statement*/
	    $stmt = $con->prepare("UPDATE `works` SET name = ?, email = ?, phone = ?, group_id = ? WHERE id = ?");
	   
	    /* Bind parameters*/
	    $stmt->bind_param("sssii", $name, $email, $phone, $group_id, $id);

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