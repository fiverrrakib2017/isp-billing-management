<?php
include "db_connect.php";

if (isset($_POST["updateTicket"])) {
	$id = $_POST["id"];
	$ticket_type = $_POST["ticket_type"];
	$assigned = $_POST["assigned"];
	$ticket_for = $_POST["ticket_for"];
	$complain_type = $_POST["complain_type"];
	$from_date = $_POST["from_data"];
	$note = $_POST["note"];
	
	$user_type = $_POST["user_type"];

	$result = $con->query("UPDATE ticket SET ticket_type='$ticket_type', asignto='$assigned',ticketfor='$ticket_for',complain_type='$complain_type',startdate='$from_date',notes='$note' WHERE id='$id'   ");
	if ($result == true) {
		echo 1;
	} else {
		echo "Error: " . $sql . "<br>" . $con->error;
	}
}

if (isset($_POST["addTicketData"])) {
	$customerId = $_POST['customer_id'];

	$assignedTo = $_POST['assigned_to'];
	$ticketFor = $_POST['ticket_for'];
	$complainType = $_POST['complain_type'];
	$notes = $_POST['notes'];


	if ($allCstmr=$con->query("SELECT * FROM customers WHERE id=$customerId")) {
		while($rows=$allCstmr->fetch_array()){
			$customerPopId = $rows['pop'];
		}
	}

	$result = $con->query("INSERT INTO ticket (customer_id, asignto, ticketfor, complain_type, startdate, notes) 
	VALUES ('$customerId', '$assignedTo', '$ticketFor', '$complainType', NOW(), '$notes')");
	if ($result == true) {
		echo 1;
	} else {
		echo "Error: " . $sql . "<br>" . $con->error;
	}
}
if (isset($_POST["addTicketTopicData"])) {
	$ticketTopic = $_POST['ticketTopic'];
	$pop_id = $_POST['pop_id'];
	$user_type=$_POST['user_type'];
	$result = $con->query("INSERT INTO ticket_topic(topic_name,pop_id,user_type) VALUES ('$ticketTopic','$pop_id','$user_type')");
	if ($result == true) {
		echo 1;
	} else {
		echo "Error: " . $sql . "<br>" . $con->error;
	}
}


if (isset($_POST["addTicketComment"])) {
    $tickId = $_POST["id"];
    $type = $_POST["type"];
    $progress = $_POST["progress"];
    $comment = $_POST["comment"];
    $assigned = $_POST["assigned"];

    /* Insert data into the database*/
    $sql = "INSERT INTO ticket_details (tcktid, status, datetm, comments, parcent, asignto) 
            VALUES ('$tickId', '$type', NOW(), '$comment', '$progress', '$assigned')";
	$con->query("UPDATE ticket SET  ticket_type='$type',parcent='$progress',enddate=NOW() WHERE id='$tickId' ");
    if ($con->query($sql) === TRUE) {
        echo 1;
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

//update ticket topic
if (isset($_POST['updateTicketTopic'])) {
	$id = $_POST['id'];
	$name = $_POST["name"];

	$result = $con->query("UPDATE ticket_topic SET  topic_name='$name' WHERE id='$id'   ");
	if ($result == true) {
		echo 1;
	} else {
		echo "Error: " . $sql . "<br>" . $con->error;
	}
}
