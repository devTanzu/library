<?php
// Include the necessary files
include "connection.php"; // Database connection
include "navbar.php"; // Admin navigation bar

// Start the session if not started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the admin is logged in
if (!isset($_SESSION['admin_user'])) {
    echo "<script>alert('Please log in as admin to view this page.'); window.location = 'admin_login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Book Requests</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #6db6b9e6;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <h2>All User Book Requests</h2>

    <?php
    // Query to fetch all book requests
    $query = "SELECT issue_book.username, issue_book.bid, books.b_name, issue_book.approve, issue_book.issue, issue_book.return 
              FROM issue_book 
              JOIN books ON issue_book.bid = books.bid";
    $result = mysqli_query($db, $query);

    if (!$result) {
        echo "<p>Error fetching requests: " . mysqli_error($db) . "</p>";
    } elseif (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered table-hover'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Username</th>";
        echo "<th>Book ID</th>";
        echo "<th>Book Name</th>";
        echo "<th>Approval Status</th>";
        echo "<th>Issue Date</th>";
        echo "<th>Return Date</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // Loop through the results and display each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td>" . htmlspecialchars($row['bid']) . "</td>";
            echo "<td>" . htmlspecialchars($row['b_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['approve']) . "</td>";
            echo "<td>" . htmlspecialchars($row['issue']) . "</td>";
            echo "<td>" . htmlspecialchars($row['return']) . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No requests found.</p>";
    }

    // Close the database connection
    mysqli_close($db);
    ?>
</body>
</html>
