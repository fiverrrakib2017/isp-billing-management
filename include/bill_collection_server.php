<?php 
 include("db_connect.php");
    session_start();
    /*ADD BILL Collection By User*/

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['add_collection'])) {
        
    
        $user_id = $_POST['user_id']; 
        $collection_date = $_POST['collection_date'];
        $total_amount = $_POST['total_amount'];
        $received_amount = $_POST['received_amount'];
        $note = isset($_POST['note']) ? $_POST['note'] : 'Cash collected';
        $uploader_info = isset($_SESSION['uid']) ? $_SESSION['uid'] : '';
    
        // Insert into cash_collection
        $insert_query = "INSERT INTO cash_collection (user_id, amount, received_amount, note, uploader_info, collection_date, create_date) VALUES ('$user_id', '$total_amount', '$received_amount', '$note', '$uploader_info', '$collection_date', NOW())";
    
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
    
