<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders - CampusCrave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/orders.css">
</head>
<body>

    <nav class="navbar navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="menu.php">← Back to Menu</a>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">My Order History 📦</h2>

        <?php if ($result->num_rows > 0): ?>
            <div class="row">
                <?php while($order = $result->fetch_assoc()): ?>
                    
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Order #<?php echo $order['id']; ?></span>
                                
                                <span class="badge status-<?php echo $order['status']; ?>">
                                    <?php echo strtoupper($order['status']); ?>
                                </span>
                            </div>
                            
                            <div class="card-body">
                                <h6 class="text-muted">Items:</h6>
                                <ul class="list-group mb-3">
                                    <?php
                                    $order_id = $order['id'];
                                    $items_sql = "SELECT products.name, order_items.quantity 
                                                  FROM order_items 
                                                  JOIN products ON order_items.product_id = products.id 
                                                  WHERE order_id = $order_id";
                                    $items_result = $conn->query($items_sql);

                                    while($item = $items_result->fetch_assoc()):
                                    ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?php echo $item['name']; ?>
                                            <span class="badge bg-secondary rounded-pill">x<?php echo $item['quantity']; ?></span>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>

                                <div class="d-flex justify-content-between">
                                    <strong>Total Paid:</strong>
                                    <span class="text-success fw-bold">Rs. <?php echo $order['total_price']; ?></span>
                                </div>
                                <small class="text-muted">Ordered on: <?php echo $order['created_at']; ?></small>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">You haven't placed any orders yet!</div>
        <?php endif; ?>

    </div>

</body>
</html>