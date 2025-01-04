<?php 
 include("db_connect.php");
    if (empty($_SESSION)) {
        session_start();
    }
    $condition="";
    $pop_id=1;
    if (!empty($_SESSION['user_pop'])) {
		$condition = "pop_id = '" . $_SESSION['user_pop'] . "'";
        $pop_id=$_SESSION['user_pop'];
	} else {
		$condition = "pop_id = 1"; 
	}
    /*ADD BILL Collection By User*/
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['add_collection'])) {
        
    
        $user_id = $_POST['user_id']; 
        $collection_date = $_POST['collection_date'];
        $total_amount = $_POST['total_amount'];
        $received_amount = $_POST['received_amount'];
        $note = isset($_POST['note']) ? $_POST['note'] : 'Cash collected';
        $uploader_info = isset($_SESSION['uid']) ? $_SESSION['uid'] : '';
    
        // Insert into cash_collection
        $insert_query = "INSERT INTO cash_collection (user_id, amount, received_amount, note, uploader_info,pop_id, collection_date, create_date) VALUES ('$user_id', '$total_amount', '$received_amount', '$note', '$uploader_info', '$pop_id', '$collection_date', NOW())";
    
        if (mysqli_query($con, $insert_query)) {
            /*Retrieve IDs from customer_rechrg where user_id and collection_date match*/ 
            $select_query = "SELECT id  FROM customer_rechrg  WHERE rchg_by = '$user_id' AND DATE(datetm) = '$collection_date' AND status = '0'
            ";
    
            $result = mysqli_query($con, $select_query);
    
            /*Collect IDs into an array*/ 
            $ids = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $ids[] = $row['id'];
            }
    
            if (!empty($ids)) {
                /*Convert the IDs array to a comma-separated string*/ 
                $ids_str = implode(',', $ids);
    
                // Update status in customer_rechrg
                $update_query = "
                    UPDATE customer_rechrg 
                    SET status = '1' 
                    WHERE id IN ($ids_str)
                ";
    
                mysqli_query($con, $update_query);
            }
    
            // Prepare the response
            $response = ['success' => true, 'message' => 'Successfully'];
            echo json_encode($response);
            exit; 
        } else {
            // Handle errors
            echo "Error: " . mysqli_error($con);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['show_data_filter'])) {
        $user_id = $_GET['user_id'];
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 10; 
        $offset = ($page - 1) * $limit;

        $sql = "
            SELECT u.id, DATE(cr.datetm) AS recharge_date, SUM(cr.sales_price) AS total_collection, u.fullname AS recharge_by_name 
            FROM customer_rechrg cr
            JOIN users u ON cr.rchg_by = u.id
            WHERE cr.status = '0'";

        if ($user_id) {
            $sql .= " AND u.id = '$user_id'";
        }

        $sql .= " GROUP BY u.id, DATE(cr.datetm), u.fullname
                ORDER BY recharge_date DESC
                LIMIT $limit OFFSET $offset";

        $result = mysqli_query($con, $sql);

        /* Fetch the total number of records for pagination*/
        $totalSql = "SELECT COUNT(*) as total 
            FROM (
                SELECT u.id, DATE(cr.datetm) AS recharge_date, SUM(cr.sales_price) AS total_collection, u.fullname AS recharge_by_name 
                FROM customer_rechrg cr
                JOIN users u ON cr.rchg_by = u.id
                WHERE cr.$condition cr.status = '0'";

        if ($user_id) {
            $totalSql .= " AND u.id = '$user_id'";
        }

        $totalSql .= " GROUP BY u.id, DATE(cr.datetm), u.fullname
                    ) as count_table";

        $totalResult = mysqli_query($con, $totalSql);
        $totalRows = mysqli_fetch_assoc($totalResult)['total'];
        $totalPages = ceil($totalRows / $limit);

        $tableData = '';
        while ($rows = mysqli_fetch_assoc($result)) {
            $recharge_date = $rows['recharge_date'];
            $yearMonth = date("Y-m", strtotime($recharge_date)); 
        
            $tableData .= "<tr>
                <td><input type='checkbox' data-id='" . $rows['id'] . "' data-collection_date='" . $rows['recharge_date'] . "'></td>
                <td><a href='monthly_recharge.php?month=" . $yearMonth . "'>" . (new DateTime($recharge_date))->format("d-M-Y") . "</a></td>
                <td>" . $rows['total_collection'] . "</td>
                <td>" . $rows['recharge_by_name'] . "</td>
                <td><a href='daily_recharge.php?date=" . $yearMonth . "&user_id=" . $rows['id'] . "' class='btn-sm btn btn-success'><i class='fas fa-eye'></i></a></td>
            </tr>";
        }
        

        /* Generate pagination links*/
        $pagination = '';
        for ($i = 1; $i <= $totalPages; $i++) {
            $pagination .= "<a href='#' class='pagination-link' data-page='$i'>$i</a> ";
        }

        echo json_encode(['tableData' => $tableData, 'pagination' => $pagination]);
    }

?>