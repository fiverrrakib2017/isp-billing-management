<?php
include 'db_connect.php';

if (isset($_GET['get_pop_data'])) {
    $pop_list=[]; 
    if (!isset($_GET['id']) && !empty($_GET['id'])) {
        $id=$_GET['id']; 
        /*  Validate ID AND  POP fetch data*/
        $stmt = $con->prepare("SELECT id,pop,fullname FROM add_pop WHERE id = ?");
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
                'message'=>'POP not found for the provided ID!',
            ]);  
        }

    }
    $stmt = $con->prepare("SELECT id,pop,fullname FROM add_pop ");
    $stmt->execute();
    $result = $stmt->get_result();
    while($rows=$result->fetch_array()){
        $pop_list[]=array(
            'id' => $rows['id'],
            'pop' => $rows['pop'],
            'fullname'=>$rows['fullname']
        );
    }
    /*return response the result */ 
    if (count($pop_list) > 0) {
        echo json_encode([
            'success' => true,
            'data' => $pop_list,
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No POP data found!',
        ]);
    }
    exit();
}