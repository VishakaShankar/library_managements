<?php
include('db.php');
session_start();

$error = "";

//  Handle both Admin & User Login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Admin credentials (static)
    $adminEmail = "admin@library.com";
    $adminPass = "admin123";

    if (isset($_POST['admin_login'])) {
        if ($email === $adminEmail && $password === $adminPass) {
            $_SESSION['user'] = "Admin";
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Invalid admin credentials!";
        }
    }

    // Normal User Login
    if (isset($_POST['user_login'])) {
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            $_SESSION['user'] = $user['email'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Library Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-box">
    <h2>Library Management System</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>

        <div style="display:flex; justify-content:space-between;">
            <button type="submit" name="user_login" class="btn">User Login</button>
            <button type="submit" name="admin_login" class="btn">Admin Login</button>
        </div>

        <p style="text-align:center; margin-top:10px;">
            Don’t have an account? <a href="register.php">Register Here</a>
        </p>

        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    </form>
</div>
</body>
</html>
