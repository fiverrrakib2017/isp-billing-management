<?php 
 include("db_connect.php");
 session_start();
 if (isset($_GET['get_all_working_data']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
	$working_group_data = array();
	$pop_id_condition ="";

	if (!empty($_SESSION['user_pop'])) {
		$pop_id=$_SESSION['user_pop'];
		$pop_id_condition = "WHERE pop_id='$pop_id'";
	}

	if ($result = $con->query("SELECT * FROM working_group $pop_id_condition ")) {
		while ($rows = $result->fetch_array()) {
			$userId = $rows["id"];
			$group_name = $rows["group_name"];
			$area_ids = $rows["area_id"];
			$note = $rows["note"];
	
			$area_id_array = explode(',', $area_ids);
			$area_names = array();
	
			foreach ($area_id_array as $area_id) {
				$area_query = $con->query("SELECT name FROM area_list WHERE id = '$area_id'");
				if ($area_row = $area_query->fetch_array()) {
					$area_names[] = $area_row['name'];
				}
			}
	
			$working_group_data[] = array(
				"id" => $userId,
				"group_name" => $group_name,
				"area_names" => $area_names,
				"note" => $note
			);
		}
	}
	
	header('Content-Type: application/json');
	echo json_encode($working_group_data);
 }
 if (isset($_POST["add_group_data"])) {
    $group_name = $_POST['group_name'];
    $area_ids = $_POST['area_id'];
    $note = $_POST['note'];
	$pop_id="";
	if (!empty($_SESSION['user_pop'])) {
		$pop_id=$_SESSION['user_pop'];
	}

	/*Convert Array To string*/
	$area_ids_imploded = implode(",",$area_ids,);

    /* Prepare an SQL statement*/
    $stmt = $con->prepare("INSERT INTO working_group (pop_id, group_name, area_id, note, create_date) VALUES (?, ?, ?, ?, NOW())");
    
    /* Bind parameters*/
    $stmt->bind_param("isss", $pop_id,$group_name, $area_ids_imploded, $note);

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