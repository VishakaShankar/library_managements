<?php
include('db.php');
session_start();

// ✅ Only allow logged-in admin
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'Admin') {
    header("Location: index.php");
    exit();
}

// ✅ Add New Book
if (isset($_POST['add'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);

    mysqli_query($conn, "INSERT INTO books (title, author, genre, year) VALUES ('$title', '$author', '$genre', '$year')");
    header("Location: admin_dashboard.php");
    exit();
}

// ✅ Delete Book
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM books WHERE id=$id");
    header("Location: admin_dashboard.php");
    exit();
}

// ✅ Update Book
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);

    mysqli_query($conn, "UPDATE books SET title='$title', author='$author', genre='$genre', year='$year' WHERE id=$id");
    header("Location: admin_dashboard.php");
    exit();
}

// ✅ Search Books
$search = "";
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search_term']);
    $query = "SELECT * FROM books WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR genre LIKE '%$search%'";
} else {
    $query = "SELECT * FROM books";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Library Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>📚 Admin Dashboard</h2>
    <p>Welcome, <?php echo $_SESSION['user']; ?> | <a href="logout.php" class="btn">Logout</a></p>

    <!-- 🔍 Search Bar -->
    <form method="POST" class="search-bar">
        <input type="text" name="search_term" placeholder="Search by title, author, or genre" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" name="search">Search</button>
        <a href="admin_dashboard.php" class="btn">Reset</a>
    </form>

    <!-- ➕ Add or Update Book -->
    <div class="form-box">
        <h3><?php echo isset($_GET['edit']) ? "Update Book" : "Add New Book"; ?></h3>
        <form method="POST">
            <?php
            if (isset($_GET['edit'])) {
                $id = $_GET['edit'];
                $edit_query = mysqli_query($conn, "SELECT * FROM books WHERE id=$id");
                $book = mysqli_fetch_assoc($edit_query);
            ?>
                <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                <input type="text" name="title" value="<?php echo $book['title']; ?>" required>
                <input type="text" name="author" value="<?php echo $book['author']; ?>" required>
                <input type="text" name="genre" value="<?php echo $book['genre']; ?>">
                <input type="number" name="year" value="<?php echo $book['year']; ?>">
                <button type="submit" name="update">Update Book</button>
                <a href="admin_dashboard.php" class="btn">Cancel</a>
            <?php } else { ?>
                <input type="text" name="title" placeholder="Book Title" required>
                <input type="text" name="author" placeholder="Author" required>
                <input type="text" name="genre" placeholder="Genre">
                <input type="number" name="year" placeholder="Year">
                <button type="submit" name="add">Add Book</button>
            <?php } ?>
        </form>
    </div>

    <!-- 📋 Book Table -->
    <h3>Book Records</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Year</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['author']); ?></td>
                <td><?php echo htmlspecialchars($row['genre']); ?></td>
                <td><?php echo htmlspecialchars($row['year']); ?></td>
                <td>
                    <a href="admin_dashboard.php?edit=<?php echo $row['id']; ?>" class="btn">Edit</a>
                    <a href="admin_dashboard.php?delete=<?php echo $row['id']; ?>" class="btn" onclick="return confirm('Delete this book?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
