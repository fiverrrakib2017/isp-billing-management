<?php 
 include("db_connect.php");
	
 if (isset($_POST["add_group_data"])) {
    $group_name = $_POST['group_name'];
    $area_id = $_POST['area_id'];
    $note = $_POST['note'];

    /* Prepare an SQL statement*/
    $stmt = $con->prepare("INSERT INTO working_group (pop_id, group_name, area_id, note, create_date) VALUES (NULL, ?, ?, ?, NOW())");
    
    /* Bind parameters*/
    $stmt->bind_param("sis", $group_name, $area_id, $note);

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

    // Return the response as JSON
    echo json_encode($response);
    exit; 
}



	if (isset($_GET['edit_data']) && isset($_GET['id'])) { 
	    $id = intval($_GET['id']); 

	    // Prepare the SQL statement
	    $stmt = $con->prepare("SELECT * FROM working_group WHERE id = ?");
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

	    // Close the statement
	    $stmt->close();
	    $con->close();

	    // Return the response as JSON
	    echo json_encode($response);
	    exit; 
	}
	if (isset($_POST['delete_data']) && isset($_POST['id'])) {
	    $id = intval($_POST['id']);

	    // Prepare the SQL statement
	    $stmt = $con->prepare("DELETE FROM working_group WHERE id = ?");
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

	    // Close the statement and connection
	    $stmt->close();
	    $con->close();

	    // Return the response as JSON
	    echo json_encode($response); 
	    exit; 
	} 




	if (isset($_POST["update_working_data"])) {
    $group_name = $_POST['group_name'];
    $note = $_POST['note'];
    $area_id = $_POST['area_id'];
	$id = $_POST['id'];
    /* Prepare an SQL statement*/
    $stmt = $con->prepare("UPDATE working_group SET group_name = ?, area_id=?, note = ? WHERE id = ?");
    /* Bind parameters*/
    $stmt->bind_param("sisi", $group_name,$area_id, $note,$id);

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

    // Return the response as JSON
    echo json_encode($response);
     exit; 
}

?>