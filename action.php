<?php
session_start();

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

        if (in_array($id, $item_id_list)) {
            
            echo "<script>alert('Item is already in your cart!'); window.location.href='menu.php';</script>";
        } else {
            $count = count($_SESSION['cart']);
            $_SESSION['cart'][$count] = $item_array;
            echo "<script>alert('Item Added!'); window.location.href='menu.php';</script>";
        }

    } else {
        $_SESSION['cart'][0] = $item_array;
        echo "<script>alert('Item Added!'); window.location.href='menu.php';</script>";
    }
}
?>