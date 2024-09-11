<?php
include "db_connect.php";

if (isset($_GET['get_tickets_data']) && $_SERVER['REQUEST_METHOD']=='GET') {
	require 'datatable.php';

	$table = 'ticket';
	$primaryKey = 'id';

	$columns = array(
		array('db' => 'id', 'dt' => 0),
		array(
			'db' => 'ticket_type', 
			'dt' => 1,
			'formatter'=>function($d, $row){
				if ($d === "Complete") {
					return '<a href="tickets_profile.php?id='.$row['id'].'"><span class="badge bg-success">Completed</span></a>';
				} elseif ($d === "Active") {
					return '<a href="tickets_profile.php?id='.$row['id'].'"><span class="badge bg-danger">Active</span></a>';
				} elseif ($d === "Close") {
					return '<a href="tickets_profile.php?id='.$row['id'].'"><span class="badge bg-success">Close</span></a>';
				} else {
					return '<a href="tickets_profile.php?id='.$row['id'].'">'.$d.'</a>';
				}
			}
		),
		array( 'db' => 'startdate', 'dt' => 2, 'formatter' => function($d, $row) {
			return timeAgo($d);
		}),
		array( 'db' => 'priority', 'dt' => 3, 'formatter' => function($d, $row) {
			// $priorityLabels = [
			// 	1 => 'Low', 2 => 'Normal', 4 => 'Standard', 
			// 	4 => 'Medium', 5 => 'High', 5 => 'Very High'
			// ];
			$priority = $row["priority"]; 

			$priorityLabel = '';
			
			switch ($priority) {
				case 1:
					$priorityLabel = 'Low';
					break;
				case 2:
					$priorityLabel = 'Normal';
					break;
				case 3:
					$priorityLabel = 'Standard';
					break;
				case 4:
					$priorityLabel = 'Medium';
					break;
				case 5:
					$priorityLabel = 'High';
					break;
				case 6:
					$priorityLabel = 'Very High';
					break;
				default:
					$priorityLabel = 'Unknown'; 
					break;
			}
			
			return $priorityLabel;
			// isset($priorityLabels[$d]) ? $priorityLabels[$d] : 'Unknown';
		}),
		array( 'db' => 'customer_id', 'dt' => 4, 'formatter' => function($d, $row) use ($con) {
			/*Fetch customer details*/ 
			$customerQuery = $con->query("SELECT * FROM customers WHERE id=$d");
			if ($customer = $customerQuery->fetch_assoc()) {
				$username = $customer['username'];
				$fullname = $customer['fullname'];
				$onlineCheck = $con->query("SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username='$username'");
				$statusIcon = ($onlineCheck->num_rows == 1) ? '<abbr title="Online"><img src="images/icon/online.png" height="10" width="10"/></abbr>' : '<abbr title="Offline"><img src="images/icon/offline.png" height="10" width="10"/></abbr>';
				return $statusIcon . ' <a href="profile.php?clid=' . $customer['id'] . '" >' . $fullname . '</a><br>(' . $username . ')';
			}
			return 'Unknown Customer';
		}),
		array( 'db' => 'customer_id', 'dt' => 5, 'formatter' => function($d, $row) use ($con) {
			/*Fetch customer details*/ 
			$customerQuery = $con->query("SELECT * FROM customers WHERE id=$d");
			if ($customer = $customerQuery->fetch_assoc()) {
				return  $customer['mobile'];
				
			}
			return 'Unknown Customer';
		}),
		array( 'db' => 'complain_type', 'dt' => 6, 'formatter' => function($d, $row) use ($con) {
			/* Fetch complain type*/
			$complainQuery = $con->query("SELECT * FROM ticket_topic WHERE id='$d'");
			if ($complain = $complainQuery->fetch_assoc()) {
				return $complain['topic_name'];
			}
			return 'Unknown Topic';
		}),
		array( 'db' => 'customer_id', 'dt' => 7, 'formatter' => function($d, $row) use ($con) {
			/*Fetch customer area*/ 
			$customerQuery = $con->query("SELECT * FROM customers WHERE id=$d");
			if ($customer = $customerQuery->fetch_assoc()) {
				$area_id = $customer['area'];
				$areaQuery = $con->query("SELECT * FROM area_list WHERE id=$area_id");
				if ($area = $areaQuery->fetch_assoc()) {
					return $area['name'];
				}
			}
			return 'Unknown Area';
		}),
		array( 'db' => 'asignto', 'dt' => 8, 'formatter' => function($d, $row) use ($con) {
			/*Fetch assigned group*/ 
			$groupQuery = $con->prepare("SELECT group_name FROM working_group WHERE id = ?");
			$groupQuery->bind_param("i", $d);
			$groupQuery->execute();
			$groupResult = $groupQuery->get_result();
			if ($group = $groupResult->fetch_assoc()) {
				return htmlspecialchars($group['group_name']);
			}
			return 'No assigned group';
		}),
		array(
			'db' => 'ticketfor', 
			'dt' => 9,
		),
		array(
			'db'=>'startdate',
			'dt'=>10,
			'formatter'=>function($d, $row){
				$startdate = $row["startdate"];
				$enddate=$row["enddate"];
				if ($enddate=='') {
					return  'Work Processing..';
				 }else{
					return acctual_work( $startdate, $enddate); 
				 }
			}
		),
		array(
			'db'=>'parcent',
			'dt'=>11,
		),
		array(
			'db'=>'notes',
			'dt'=>12,
		),
		array(
			'db'=>'id',
			'dt'=>13,
			'formatter'=>function($d, $row){
				return '
				<button type="button" name="settings_button" data-id='.$row['id'].' class="btn-sm btn btn-danger"> <i class="fas fa-cog"></i></button>
				<a class="btn-sm btn btn-success" href="tickets_profile.php?id='.$row['id'].'"><i class="fas fa-eye"></i></a>'; 
			}
		),
		
		
	);
	$condition = ""; 
	/* Output JSON for DataTables to handle*/
	echo json_encode(
		SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns,null, $condition)
	);
}
if (isset($_POST['get_area']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerId = $_POST['customer_id'];

    /* Get area_id from customers table*/
    $allCstmr = $con->query("SELECT `area` FROM customers WHERE id = $customerId");

    if ($allCstmr && $rows = $allCstmr->fetch_array()) {
        $area_id = $rows["area"];

        /* Check if there is any data in working_group with this area_id*/
        $all_working_area = $con->query("SELECT id, group_name FROM working_group WHERE FIND_IN_SET('$area_id', area_id)");

        if ($all_working_area && $all_working_area->num_rows > 0) {
            /* If area_id matches, show only those records*/
            while ($rowsss = $all_working_area->fetch_array()) {
                echo '<option value="' . $rowsss['id'] . '">' . $rowsss['group_name'] . '</option>';
            }
        } else {
            /* If no matching area_id, show all records from working_group*/
            $all_working_area = $con->query("SELECT id, group_name FROM working_group");
            while ($rowsss = $all_working_area->fetch_array()) {
                echo '<option value="' . $rowsss['id'] . '">' . $rowsss['group_name'] . '</option>';
            }
        }
    } else {
        /* If no area_id found, show all records from working_group*/
        $all_working_area = $con->query("SELECT id, group_name FROM working_group");
        while ($rowsss = $all_working_area->fetch_array()) {
            echo '<option value="' . $rowsss['id'] . '">' . $rowsss['group_name'] . '</option>';
        }
    }
}

if (isset($_GET['get_single_ticket']) && $_SERVER['REQUEST_METHOD']=='GET') {
	
	if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id=$_GET['id']; 

        $stmt = $con->prepare("SELECT * FROM ticket WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode([
                'success'=>true, 
                'message'=>'success', 
                'data'=>$row, 
            ]); 
        }else {
            echo json_encode([
                'success'=>false, 
                'message'=>'Not Found',
            ]);  
        }

    }
}
if (isset($_GET['get_working_group']) && $_GET['get_working_group'] == 'true') {
    $stmt2 = $con->prepare("SELECT * FROM working_group");
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    
    $data = [];
    while ($row = $result2->fetch_assoc()) {
        $data[] = [
            'id' => $row['id'],
            'name' => $row['group_name'] 
        ];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
}

if (isset($_GET['add_ticket_settings']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $tickId   = $_POST["ticket_id"];
    $type     = $_POST["ticket_type"];
    $progress = $_POST["progress"];
    $comment  = $_POST["comment"];
    $assigned = $_POST["assigned"];

    $stmt1 = $con->prepare("INSERT INTO ticket_details (tcktid, status, datetm, comments, parcent, asignto) VALUES (?, ?, NOW(), ?, ?, ?)");
    $stmt1->bind_param('issss', $tickId, $type, $comment, $progress, $assigned);
    
    if ($stmt1->execute()) {
        /*Update Tickets*/ 
        $stmt2 = $con->prepare("UPDATE ticket SET notes=?, ticket_type = ?, asignto=?, parcent = ?, enddate = NOW() WHERE id = ?");
        $stmt2->bind_param('ssisi', $comment, $type, $assigned, $progress, $tickId);
        
        if ($stmt2->execute()) {
            echo json_encode(['success' => true, 'message' => 'Ticket settings updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update ticket.'.$stmt->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to insert ticket details.']);
    }
    
    /*Close the statement*/
    $stmt1->close();
    $stmt2->close();
}

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
	$priority = $_POST['priority'];


	if ($allCstmr=$con->query("SELECT * FROM customers WHERE id=$customerId")) {
		while($rows=$allCstmr->fetch_array()){
			$customerPopId = $rows['pop'];
		}
	}

	$result = $con->query("INSERT INTO ticket (customer_id, asignto, ticketfor, complain_type, startdate, notes,parcent,priority) 
	VALUES ('$customerId', '$assignedTo', '$ticketFor', '$complainType', NOW(), '$notes','0%','$priority')");
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


function timeAgo($startdate) {
    /*Convert startdate to a timestamp*/ 
    $startTimestamp = strtotime($startdate);
    $currentTimestamp = time();
    
    /* Calculate the difference in seconds*/
    $difference = $currentTimestamp - $startTimestamp;

    /*Define time intervals*/ 
    $units = [
        'year' => 31536000,
        'month' => 2592000,
        'week' => 604800,
        'day' => 86400,
        'hour' => 3600,
        'minute' => 60,
        'second' => 1
    ];

    /*Check for each time unit*/ 
    foreach ($units as $unit => $value) {
        if ($difference >= $value) {
            $time = floor($difference / $value);
            return '<img src="images/icon/online.png" height="10" width="10"/>'.' '.$time . ' ' . $unit . ($time > 1 ? 's' : '') . ' ago';
        }
    }
    /*If the difference is less than a second*/
    return '<img src="images/icon/online.png" height="10" width="10"/> just now';  
}

function acctual_work($startdate, $enddate) {
    $startTimestamp = strtotime($startdate);
    $endTimestamp = strtotime($enddate);
    $time_difference = $endTimestamp - $startTimestamp;

    // Define time periods in seconds
    $units = [
        'year' => 365 * 24 * 60 * 60,
        'month' => 30 * 24 * 60 * 60,
        'week' => 7 * 24 * 60 * 60,
        'day' => 24 * 60 * 60,
        'hour' => 60 * 60,
        'minute' => 60,
        'second' => 1,
    ];

    // Determine the appropriate time period
    foreach ($units as $unit => $value) {
        if ($time_difference >= $value) {
            $count = floor($time_difference / $value);
            return $count . ' ' . $unit . ($count > 1 ? 's' : '') . ' ';
        }
    }

    return 'just now'; 
}
