<?php
session_start();
require 'config/db.php';

if (isset($_POST['add_to_cart'])) {
    $id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $quantity = $_POST['quantity'];

    $item_array = array(
        'product_id' => $id,
        'product_name' => $name,
        'product_price' => $price,
        'product_quantity' => $quantity
    );

    if (isset($_SESSION['cart'])) {
        $item_id_list = array_column($_SESSION['cart'], 'product_id');
        if (!in_array($id, $item_id_list)) {
            $count = count($_SESSION['cart']);
            $_SESSION['cart'][$count] = $item_array;
        } else {
            echo "<script>alert('Item already in cart!'); window.location.href='menu.php';</script>";
            exit();
        }
    } else {
        $_SESSION['cart'][0] = $item_array;
    }
    echo "<script>window.location.href='menu.php';</script>";
}

if (isset($_GET['action']) && $_GET['action'] == "remove") {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['product_id'] == $_GET['id']) {
            unset($_SESSION['cart'][$key]); 
            
            $_SESSION['cart'] = array_values($_SESSION['cart']); 
        }
    }
    header("Location: cart.php");
}

if (isset($_POST['checkout'])) {
    $user_id = $_SESSION['user_id'];
    $total = $_POST['grand_total'];

    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'pending')");
    $stmt->bind_param("id", $user_id, $total); // 'id' means Integer, Decimal
    
    if ($stmt->execute()) {
        $order_id = $conn->insert_id; 

        $stmt_items = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase) VALUES (?, ?, ?, ?)");

        foreach ($_SESSION['cart'] as $item) {
            $stmt_items->bind_param("iiid", $order_id, $item['product_id'], $item['product_quantity'], $item['product_price']);
            $stmt_items->execute();
        }

        unset($_SESSION['cart']);
        echo "<script>alert('Order Placed Successfully!'); window.location.href='my_orders.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>