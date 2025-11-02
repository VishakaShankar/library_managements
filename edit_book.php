<?php
include('db.php');
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM books WHERE id=$id");
$book = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];

    $sql = "UPDATE books SET title='$title', author='$author', genre='$genre', year='$year' WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-box">
    <h2>Edit Book</h2>
    <form method="POST">
        <input type="text" name="title" value="<?= $book['title']; ?>" required><br>
        <input type="text" name="author" value="<?= $book['author']; ?>" required><br>
        <input type="text" name="genre" value="<?= $book['genre']; ?>" required><br>
        <input type="number" name="year" value="<?= $book['year']; ?>" required><br>
        <button type="submit">Update</button>
        <a href="dashboard.php" class="btn">Back</a>
    </form>
</div>
</body>
</html>
