<?php
include('db.php');
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];

    $sql = "INSERT INTO books (title, author, genre, year) VALUES ('$title', '$author', '$genre', '$year')";
    mysqli_query($conn, $sql);
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-box">
    <h2>Add New Book</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Book Title" required><br>
        <input type="text" name="author" placeholder="Author" required><br>
        <input type="text" name="genre" placeholder="Genre" required><br>
        <input type="number" name="year" placeholder="Year" required><br>
        <button type="submit">Add Book</button>
        <a href="dashboard.php" class="btn">Back</a>
    </form>
</div>
</body>
</html>
