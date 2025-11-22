<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Cart - CampusCrave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/cart.css">
</head>
<body>

    <nav class="navbar navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="menu.php">← Back to Menu</a>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Your Shopping Cart 🛒</h2>

        <div class="table-responsive">
            <table class="table table-bordered cart-table">
                <thead class="table-dark">
                    <tr>
                        <th>Food Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_price = 0;

                    if (!empty($_SESSION['cart'])) {
                       
                        foreach ($_SESSION['cart'] as $key => $value) {
                            $item_total = $value['product_price'] * $value['product_quantity'];
                            $total_price += $item_total; 
                    ?>
                        <tr>
                            <td><?php echo $value['product_name']; ?></td>
                            <td>Rs. <?php echo $value['product_price']; ?></td>
                            <td><?php echo $value['product_quantity']; ?></td>
                            <td>Rs. <?php echo $item_total; ?></td>
                            <td>
                                <a href="action.php?action=remove&id=<?php echo $value['product_id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                            </td>
                        </tr>
                    <?php
                        } 
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Your cart is empty!</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="text-end mt-3">
            <h3>Grand Total: Rs. <?php echo $total_price; ?></h3>
            
            <?php if($total_price > 0): ?>
                <form action="action.php" method="POST">
                    <input type="hidden" name="grand_total" value="<?php echo $total_price; ?>">
                    <button type="submit" name="checkout" class="btn btn-success btn-lg mt-2">Confirm Order ✅</button>
                </form>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>