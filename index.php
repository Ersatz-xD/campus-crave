<?php
session_start();
require 'config/db.php'; 

$error = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, role, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if ($password === $row['password']) {
            
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['username'] = $username;

          
            if ($row['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: menu.php");
            }
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CampusCrave</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/global.css">

    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">

        <div class="card shadow p-4 login-card">
            <h3 class="text-center mb-4">CampusCrave 🍔</h3>

            <?php if ($error): ?>
                <div class="alert alert-danger p-2 text-center"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-dark w-100">Login</button>
            </form>

            <div class="mt-3 text-center text-muted" style="font-size: 0.8rem;">
                <p class="mb-1">Admin: <b>admin</b> / <b>admin123</b></p>
                <p>Student: <b>student1</b> / <b>pass123</b></p>
            </div>
        </div>

    </div>

</body>

</html>