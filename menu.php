<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - CampusCrave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/menu.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="#">CampusCrave 🍔</a>
        
        <div class="ms-auto">
            <a href="my_orders.php" class="btn btn-info text-white me-2">My Orders 📦</a>
            
            <a href="cart.php" class="btn btn-warning">View Cart 🛒</a>
            
            <a href="logout.php" class="btn btn-outline-light ms-2">Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Today's Menu</h2>

        <div class="row">
            
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
            ?>
            
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="assets/images/<?php echo $row['image']; ?>" class="card-img-top food-img" alt="Food Image">
                        
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <p class="card-text text-muted">Rs. <?php echo $row['price']; ?></p>
                            
                            <form action="action.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                                
                                <div class="input-group mb-3 px-4">
                                    <input type="number" name="quantity" value="1" min="1" class="form-control text-center">
                                    <button type="submit" name="add_to_cart" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            <?php 
                } 
            } else {
                echo "<p class='text-center'>No food items available!</p>";
            }
            ?>

        </div>
    </div>

</body>
</html>