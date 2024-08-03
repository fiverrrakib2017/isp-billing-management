<?php
include "db_connect.php";

if (isset($_POST["updateTicket"])) {
	$id = $_POST["id"];
	$ticket_type = $_POST["ticket_type"];
	$assigned = $_POST["assigned"];
	$ticket_for = $_POST["ticket_for"];
	$complain_type = $_POST["complain_type"];
	$from_date = $_POST["from_data"];
	$to_date = $_POST["to_date"];
	$user_type = $_POST["user_type"];

	$result = $con->query("UPDATE ticket SET  ticket_type='$ticket_type', asignto='$assigned',ticketfor='$ticket_for',complain_type='$complain_type',startdate='$from_date',enddate='$to_date' WHERE id='$id'   ");
	if ($result == true) {
		echo 1;
	} else {
		echo 0;
	}
}

if (isset($_POST["addTicketData"])) {
	$customerId = $_POST['customer_id'];
$ticketType = $_POST['ticket_type'];
$assignedTo = $_POST['assigned_to'];
$ticketFor = $_POST['ticket_for'];
$complainType = $_POST['complain_type'];
$fromDate = $_POST['from_date'];
$toDate = $_POST['to_date'];

	if ($allCstmr=$con->query("SELECT * FROM customers WHERE id=$customerId")) {
		while($rows=$allCstmr->fetch_array()){
			$customerPopId = $rows['pop'];
		}
	}

	$result = $con->query("INSERT INTO ticket (customer_id, ticket_type, asignto, ticketfor, pop_id, complain_type, startdate, enddate,user_type) 
	VALUES ('$customerId', '$ticketType', '$assignedTo', '$ticketFor', '$customerPopId', '$complainType', '$fromDate', '$toDate',2)");
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
		2;
	}
}


if (isset($_POST["addTicketComment"])) {
	$tickId = $_POST["id"];
	$type = $_POST["type"];
	$progress = $_POST["progress"];
	$date = $_POST["date"];
	$comment = $_POST["comment"];

	$ticketCommentPost=$con->query("INSERT INTO ticket_details(tcktid,	status,datetm,comments,parcent)VALUES('$tickId','$type','$date','$comment','$progress')");
	if ($ticketCommentPost==true) {
		echo 1;
	}else{
		echo 0;
	}
}

//update ticket topic
if (isset($_POST['updateTicketTopic'])) {
	$id = $_POST['id'];
	$name = $_POST["name"];

	$result = $con->query("UPDATE ticket_topic SET  topic_name='$name' WHERE id='$id'   ");
	if ($result == true) {
		echo "Topic Update Successfully";
	} else {
		echo "Please try again";
	}
}
