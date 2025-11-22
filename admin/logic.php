<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $order_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
elseif (isset($_POST['delete_item'])) {
    $product_id = $_POST['product_id'];

    $img_query = "SELECT image FROM products WHERE id = $product_id";
    $img_res = $conn->query($img_query);
    $img_row = $img_res->fetch_assoc();
    $file_path = "../assets/images/" . $img_row['image'];
    if (file_exists($file_path)) {
        unlink($file_path); 
    }

  
    // Note: We delete from products. 
    // (If this product is in past orders, this might error due to Foreign Keys. 
    //  For a simple project, we assume you only delete new/unused items.)
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error deleting: " . $conn->error;
    }
}
?>