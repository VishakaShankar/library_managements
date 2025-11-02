<?php
include('db.php');
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Optional: insert sample data only if table is empty
$check = mysqli_query($conn, "SELECT COUNT(*) AS total FROM books");
$count = mysqli_fetch_assoc($check)['total'];

if ($count == 0) {
    $insert = "INSERT INTO books (title, author, genre, year) VALUES
    ('The Great Gatsby', 'F. Scott Fitzgerald', 'Novel', 1925),
    ('To Kill a Mockingbird', 'Harper Lee', 'Fiction', 1960),
    ('1984', 'George Orwell', 'Dystopian', 1949),
    ('Harry Potter and the Sorcerer''s Stone', 'J.K. Rowling', 'Fantasy', 1997),
    ('The Catcher in the Rye', 'J.D. Salinger', 'Fiction', 1951)";
    mysqli_query($conn, $insert);
}

// Fetch all books
$result = mysqli_query($conn, "SELECT * FROM books");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Library Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Welcome, <?php echo $_SESSION['user']; ?></h2>
    <a href="logout.php" class="btn">Logout</a>

    <h3>📚 Book List</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Year</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['author']; ?></td>
            <td><?php echo $row['genre']; ?></td>
            <td><?php echo $row['year']; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
