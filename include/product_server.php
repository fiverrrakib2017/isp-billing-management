<?php
include "db_connect.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['add_product'])) {
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $purchase_ac = $_POST['purchase_ac'];
    $sales_ac = $_POST['sales_ac'];
    $purchase_price = $_POST['p_price'];
    $sale_price = $_POST['s_price'];
    $store = $_POST['store'];
    $note = $_POST['note'];
    $qty = $_POST['qty'];

    // Debugging: Check what is received in POST
    //print_r($_POST); exit;

    /* Prepare an SQL statement*/
    $stmt = $con->prepare("INSERT INTO products(`name`, `category`, `brand`, `purchase_ac`, `sales_ac`, `purchase_price`, `sale_price`, `store`,`note`,`qty`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");

    /* Bind parameters*/
    $stmt->bind_param("siiiiiiisi", $name, $category, $brand, $purchase_ac, $sales_ac, $purchase_price, $sale_price, $store, $note, $qty);

    /* Execute the statement*/
    if ($stmt->execute()) {
        $response = array("success" => true, "message" => "Product added successfully");
    } else {
        $response = array("success" => false, "message" => "Error: " . $stmt->error);
    }

    /*Close the statement and the database connection*/ 
    $stmt->close();
    $con->close();

    /* Return the response as JSON*/
    echo json_encode($response);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['update_product'])) {
    
    $product_id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $purchase_ac = $_POST['purchase_ac'];
    $sales_ac = $_POST['sales_ac'];
    $purchase_price = $_POST['p_price'];
    $sale_price = $_POST['s_price'];
    $store = $_POST['store'];
    $note = $_POST['note'];
    $qty = $_POST['qty'];
    
    /* Prepare an SQL statement for updating the product*/
    $stmt = $con->prepare("UPDATE products SET `name`=?, `category`=?, `brand`=?, `purchase_ac`=?, `sales_ac`=?, `purchase_price`=?, `sale_price`=?, `store`=?, `note`=?, `qty`=? WHERE `id`=?");
    
    /* Bind parameters*/
    $stmt->bind_param("sssiiisssii", $name, $category, $brand, $purchase_ac, $sales_ac, $purchase_price, $sale_price, $store, $note,$qty,$product_id);

    /* Execute the statement*/
    if ($stmt->execute()) {
        $response = array("success" => true, "message" => "Product updated successfully");
    } else {
        $response = array("success" => false, "message" => "Error: " . $stmt->error);
    }

    /*Close the statement and the database connection*/ 
    $stmt->close();
    $con->close();

     /* Return the response as JSON*/
    echo json_encode($response);
    exit;
}



?>