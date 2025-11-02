<?php
include('db.php');
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM books WHERE id=$id");
header("Location: dashboard.php");
exit();
?>
