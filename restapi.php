<?php
header("Content-Type: application/json");
@include 'config.php'; 

$request_method = $_SERVER["REQUEST_METHOD"];

function getProducts() {
    global $conn;
    $query = "SELECT * FROM products";
    $result = $conn->query($query);
    
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    
    echo json_encode($products);
}

      
       
function getOrder() {
    global $conn;
    $query = "SELECT * FROM cart";
    $result = $conn->query($query);
    
    $order = [];
    while ($row = $result->fetch_assoc()) {
        $order[] = $row;
    }
    
    echo json_encode($order);
}

function getProduct($name) {
    global $conn;
    $query = "SELECT * FROM product WHERE name = $name";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        echo json_encode($order);
    } else {
        echo json_encode(["message" => "Product not found"]);
    }
}

function updateOrder($id) {
    global $conn;
    
    $data = json_decode(file_get_contents("php://input"));
    $status = $data->status; 
    
    $query = "UPDATE order SET status = '$status' WHERE id = $id";
    if ($conn->query($query) === TRUE) {
        echo json_encode(["message" => "Order updated successfully"]);
    } else {
        echo json_encode(["message" => "Error updating order"]);
    }
}


function deleteOrder($id) {
    global $conn;
    $query = "DELETE FROM order WHERE id = $id";
    if ($conn->query($query) === TRUE) {
        echo json_encode(["message" => "Order deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error deleting order"]);
    }
}

$conn->close(); 
?>
