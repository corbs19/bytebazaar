<?php
header("Content-Type: application/json");
@include 'config.php';

$request_method = $_SERVER["REQUEST_METHOD"];

function getProducts() {
    global $conn;
    $query = "SELECT * FROM products";
    $result = $conn->query($query);

    if ($result) {
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        echo json_encode($products);
    } else {
        echo json_encode(["message" => "Error fetching products"]);
    }
}

function getOrder() {
    global $conn;
    $query = "SELECT * FROM cart";
    $result = $conn->query($query);

    if ($result) {
        $order = [];
        while ($row = $result->fetch_assoc()) {
            $order[] = $row;
        }
        echo json_encode($order);
    } else {
        echo json_encode(["message" => "Error fetching order"]);
    }
}

function getProduct($name) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM products WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode($product);
    } else {
        echo json_encode(["message" => "Product not found"]);
    }
    $stmt->close();
}

function updateOrder($id) {
    global $conn;

    $data = json_decode(file_get_contents("php://input"), true);
    $status = $data['status'];

    $stmt = $conn->prepare("UPDATE `order` SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Order updated successfully"]);
    } else {
        echo json_encode(["message" => "Error updating order"]);
    }
    $stmt->close();
}

function deleteOrder($id) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM `order` WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Order deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error deleting order"]);
    }
    $stmt->close();
}

// Routing based on request method
switch ($request_method) {
    case 'GET':
        if (!empty($_GET["name"])) {
            getProduct($_GET["name"]);
        } else if (isset($_GET["order"])) {
            getOrder();
        } else {
            getProducts();
        }
        break;

    case 'PUT':
        if (!empty($_GET["id"])) {
            updateOrder($_GET["id"]);
        }
        break;

    case 'DELETE':
        if (!empty($_GET["id"])) {
            deleteOrder($_GET["id"]);
        }
        break;

    default:
        echo json_encode(["message" => "Invalid Request Method"]);
        break;
}

$conn->close();
?>
