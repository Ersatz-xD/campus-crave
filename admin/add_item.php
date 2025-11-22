<?php
session_start();
require '../config/db.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    $image = $_FILES['image']['name']; 
    $target_dir = "../assets/images/";
    $target_file = $target_dir . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        
        $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $name, $price, $image); // String, Decimal, String
        
        if ($stmt->execute()) {
            $msg = "Item added successfully! ✅";
        } else {
            $msg = "Database Error: " . $conn->error;
        }
    } else {
        $msg = "Failed to upload image. Make sure the folder exists.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Item - CampusCrave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

    <nav class="navbar navbar-dark bg-danger px-4">
        <a class="navbar-brand" href="dashboard.php">← Back to Dashboard</a>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0">Add New Menu Item 🍔</h4>
                    </div>
                    <div class="card-body">
                        
                        <?php if($msg): ?>
                            <div class="alert alert-info"><?php echo $msg; ?></div>
                        <?php endif; ?>

                        <form method="POST" action="" enctype="multipart/form-data">
                            
                            <div class="mb-3">
                                <label>Food Name</label>
                                <input type="text" name="name" class="form-control" required placeholder="e.g. Club Sandwich">
                            </div>

                            <div class="mb-3">
                                <label>Price (Rs.)</label>
                                <input type="number" step="0.01" name="price" class="form-control" required placeholder="e.g. 250">
                            </div>

                            <div class="mb-3">
                                <label>Food Image</label>
                                <input type="file" name="image" class="form-control" required accept="image/*">
                                <small class="text-muted">Image will be saved to assets/images/</small>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Add Item</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>