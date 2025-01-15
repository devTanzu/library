<?php
include "./connection.php"; // Ensure this establishes a connection as $db
include "navbar.php"; // Include admin-specific navbar

// Start session to check admin login
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login_admin'])) {
    header("Location: ./login.php"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .container {
            margin-top: 20px;
        }
        .srch {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
<div class="container">
    <h2>Manage Books</h2>

    <!-- Search Form -->
    <div class="srch">
        <form method="post" class="form-inline">
            <input class="form-control" type="text" name="search" placeholder="Search books..." required>
            <button type="submit" name="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-search"></span> Search
            </button>
            <a href="manage_books.php" class="btn btn-default">Reset</a>
            <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
        </form>
    </div>

    <!-- Add Book Form -->
    <div class="add-book">
        <form method="post" class="form-inline">
            <input class="form-control" type="text" name="b_name" placeholder="Book Name" required>
            <input class="form-control" type="text" name="status" placeholder="Status (Available/Unavailable)" required>
            <input class="form-control" type="text" name="type" placeholder="Type (e.g., Fiction, Non-Fiction)" required>
            <input class="form-control" type="number" name="price" placeholder="Price" required>
            <button type="submit" name="add" class="btn btn-success">
                <span class="glyphicon glyphicon-plus"></span> Add Book
            </button>
        </form>
    </div>

    <?php
    // Add Book
    if (isset($_POST['add'])) {
        $b_name = mysqli_real_escape_string($db, $_POST['b_name']);
        $status = mysqli_real_escape_string($db, $_POST['status']);
        $type = mysqli_real_escape_string($db, $_POST['type']);
        $price = mysqli_real_escape_string($db, $_POST['price']);

        $insert_query = "INSERT INTO books (b_name, status, type, price) VALUES ('$b_name', '$status', '$type', '$price')";
        if (mysqli_query($db, $insert_query)) {
            echo "<p class='text-success'>Book added successfully!</p>";
        } else {
            echo "<p class='text-danger'>Error adding book: " . mysqli_error($db) . "</p>";
        }
    }

    // Search Books
    if (isset($_POST['submit'])) {
        $search = mysqli_real_escape_string($db, $_POST['search']);
        $query = "SELECT * FROM books WHERE b_name LIKE '%$search%' ORDER BY bid";
    } else {
        $query = "SELECT * FROM books ORDER BY bid";
    }
    $result = mysqli_query($db, $query);

    // Display Books Table
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered table-hover'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Book ID</th>";
        echo "<th>Book Name</th>";
        echo "<th>Status</th>";
        echo "<th>Type</th>";
        echo "<th>Price</th>";
        echo "<th>Actions</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['bid']) . "</td>";
            echo "<td>" . htmlspecialchars($row['b_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
            echo "<td>" . htmlspecialchars($row['type']) . "</td>";
            echo "<td>" . htmlspecialchars($row['price']) . "</td>";
            echo "<td>";
            echo "<a href='edit_book.php?id=" . $row['bid'] . "' class='btn btn-warning btn-xs'>Edit</a> ";
            echo "<a href='delete_book.php?id=" . $row['bid'] . "' class='btn btn-danger btn-xs' onclick='return confirm(\"Are you sure you want to delete this book?\")'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No books found.</p>";
    }

    // Close the database connection
    mysqli_close($db);
    ?>
</div>
</body>
</html>