<?php
// Include the database connection file
include "connection.php";

// Start the session if it hasn't been started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the admin is logged in
if (!isset($_SESSION['login_admin'])) {
    echo "<script>alert('Please log in first to view this page.'); window.location = 'user_admin.php';</script>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Requests</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
            margin: auto;
            border-collapse: collapse;
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

        .btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Book Requests</h2>
       <!-- Back to Books button -->
       <div class="text-center">
        <a href="books.php" class="btn btn-secondary">Back to Books</a>
    </div>

    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $bid = mysqli_real_escape_string($db, $_POST['bid']);
        $approve = mysqli_real_escape_string($db, $_POST['approve']);

        // Current date and return date calculation
        $currentDate = date('Y-m-d');
        $returnDate = date('Y-m-d', strtotime('+7 days'));

        if ($approve === 'Approved') {
            // Update with issue and return dates
            $updateQuery = "
                UPDATE issue_book 
                SET approve = '$approve', issue = '$currentDate', `return` = '$returnDate' 
                WHERE username = '$username' AND bid = '$bid'";
        } else {
            // Reset issue and return dates if not approved
            $updateQuery = "
                UPDATE issue_book 
                SET approve = '$approve', issue = NULL, `return` = NULL 
                WHERE username = '$username' AND bid = '$bid'";
        }

        if (mysqli_query($db, $updateQuery)) {
            echo "<div class='alert alert-success'>Request updated successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error updating request: " . mysqli_error($db) . "</div>";
        }
    }

    // Fetch book requests from the database
    if ($db) {
        $query = "
            SELECT user.username, books.bid, books.b_name, issue_book.approve, issue_book.issue, issue_book.return 
            FROM user 
            INNER JOIN issue_book ON user.username = issue_book.username 
            INNER JOIN books ON issue_book.bid = books.bid";

        $result = mysqli_query($db, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered table-hover'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Username</th>";
            echo "<th>Book ID</th>";
            echo "<th>Book Name</th>";
            echo "<th>Approval Status</th>";
            echo "<th>Issue Date</th>";
            echo "<th>Return Date</th>";
            echo "<th>Action</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>" . htmlspecialchars($row['bid']) . "</td>";
                echo "<td>" . htmlspecialchars($row['b_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['approve']) . "</td>";
                echo "<td>" . htmlspecialchars($row['issue']) . "</td>";
                echo "<td>" . htmlspecialchars($row['return']) . "</td>";
                echo "<td>
                        <form method='post' action=''>
                            <input type='hidden' name='username' value='" . htmlspecialchars($row['username']) . "'>
                            <input type='hidden' name='bid' value='" . htmlspecialchars($row['bid']) . "'>
                            <select name='approve' required>
                                <option value=''>Select</option>
                                <option value='Approved'>Approve</option>
                                <option value='Rejected'>Reject</option>
                            </select>
                            <button type='submit' class='btn btn-primary btn-sm'>Submit</button>
                        </form>
                    </td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No book requests found.</p>";
        }
    } else {
        echo "<p>Database connection is not established.</p>";
    }

    // Close the database connection
    mysqli_close($db);
    ?>
</body>
</html>
