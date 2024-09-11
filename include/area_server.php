<?php
include 'db_connect.php';

if (isset($_GET['get_area_data'])) {
    $area_list=[]; 
    if (!isset($_GET['id']) && !empty($_GET['id'])) {
        $id=$_GET['id']; 
        /*  Validate ID AND  POP fetch data*/
        $stmt = $con->prepare("SELECT id,name FROM area_list WHERE id = ?");
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
    $stmt = $con->prepare("SELECT id,name FROM area_list ");
    $stmt->execute();
    $result = $stmt->get_result();
    while($rows=$result->fetch_array()){
        $area_list[]=array(
            'id' => $rows['id'],
            'name' => $rows['name']
        );
    }
    /*return response the result */ 
    if (count($area_list) > 0) {
        echo json_encode([
            'success' => true,
            'data' => $area_list,
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No  data found!',
        ]);
    }
    exit();
}