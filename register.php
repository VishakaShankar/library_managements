<?php
include('db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email already registered!";
    } else {
        $insert = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
        if (mysqli_query($conn, $insert)) {
            $success = "Registration successful! Please login now.";
        } else {
            $error = "Error during registration.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Library System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-box">
    <h2>Create Your Account</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" class="btn">Register</button>
        <p style="text-align:center; margin-top:10px;">
            Already have an account? <a href="index.php">Login Here</a>
        </p>
        <?php 
        if (isset($error)) echo "<p class='error'>$error</p>";
        if (isset($success)) echo "<p class='success'>$success</p>";
        ?>
    </form>
</div>
</body>
</html>
