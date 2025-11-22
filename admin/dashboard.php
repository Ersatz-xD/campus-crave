<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT orders.*, users.username 
        FROM orders 
        JOIN users ON orders.user_id = users.id 
        ORDER BY orders.created_at DESC";
$result = $conn->query($sql);

$menu_sql = "SELECT * FROM products WHERE is_active = 1 ORDER BY id DESC";
$menu_result = $conn->query($menu_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kitchen Dashboard - CampusCrave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

    <nav class="navbar navbar-dark bg-danger px-4">
        <a class="navbar-brand" href="#">👨‍🍳 Kitchen Dashboard</a>
        <a href="../logout.php" class="btn btn-light btn-sm">Logout</a>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Live Orders Queue</h2>
            <a href="add_item.php" class="btn btn-success">➕ Add New Food Item</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover admin-table">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Student Name</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Current Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $row['id']; ?></td>
                            <td><?php echo $row['username']; ?></td>

                            <td>
                                <small>
                                    <?php
                                    $o_id = $row['id'];
                                    $items_sql = "SELECT products.name, order_items.quantity 
                                              FROM order_items 
                                              JOIN products ON order_items.product_id = products.id 
                                              WHERE order_id = $o_id";
                                    $i_result = $conn->query($items_sql);
                                    while ($item = $i_result->fetch_assoc()) {
                                        echo $item['name'] . " (x" . $item['quantity'] . ")<br>";
                                    }
                                    ?>
                                </small>
                            </td>

                            <td>Rs. <?php echo $row['total_price']; ?></td>

                            <td class="status-text-<?php echo $row['status']; ?>">
                                <?php echo strtoupper($row['status']); ?>
                            </td>

                            <td>
                                <form action="logic.php" method="POST" class="d-flex gap-2">
                                    <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">

                                    <select name="status" class="form-select form-select-sm">
                                        <option value="pending" <?php if ($row['status'] == 'pending')
                                            echo 'selected'; ?>>
                                            Pending</option>
                                        <option value="preparing" <?php if ($row['status'] == 'preparing')
                                            echo 'selected'; ?>>
                                            Preparing</option>
                                        <option value="ready" <?php if ($row['status'] == 'ready')
                                            echo 'selected'; ?>>Ready
                                        </option>
                                        <option value="completed" <?php if ($row['status'] == 'completed')
                                            echo 'selected'; ?>>
                                            Completed</option>
                                        <option value="cancelled" <?php if ($row['status'] == 'cancelled')
                                            echo 'selected'; ?>>
                                            Cancelled</option>
                                    </select>

                                    <button type="submit" name="update_status"
                                        class="btn btn-sm btn-primary">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <hr class="my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manage Current Menu 🍔</h2>
            <a href="add_item.php" class="btn btn-success">➕ Add New Food Item</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = $menu_result->fetch_assoc()): ?>
                        <tr>
                            <td style="width: 100px;">
                                <img src="../assets/images/<?php echo $item['image']; ?>"
                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                            </td>
                            <td class="align-middle"><?php echo $item['name']; ?></td>
                            <td class="align-middle">Rs. <?php echo $item['price']; ?></td>

                            <td class="align-middle">
                                <form action="logic.php" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this item?');">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" name="delete_item" class="btn btn-danger btn-sm">🗑
                                        Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>