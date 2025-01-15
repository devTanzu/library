<?php
// Include the database connection file
include "connection.php"; // Ensure the path is correct

session_start();

// Check if the admin is logged in
if (!isset($_SESSION['login_admin'])) {
    header("Location: login.php");
    exit();
}

$admin_username = $_SESSION['login_admin']; // Get the logged-in admin's username

// Fetch all users from the database using $db
$query = "SELECT * FROM user ORDER BY username ASC";
$result = mysqli_query($db, $query);  // Use $db instead of $conn

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #2c3e50;
            color: white;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        h1 {
            color: #ecf0f1;
        }
        table {
            width: 100%;
            margin-top: 20px;
            background-color: #34495e;
            border-radius: 5px;
            overflow: hidden;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #7f8c8d;
        }
        table th {
            background-color: #1abc9c;
            color: white;
        }
        table tr:hover {
            background-color: #16a085;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage User</h1>
        <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if users exist
                if ($result && mysqli_num_rows($result) > 0) {
                    // Loop through each user and display in the table
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>
        
                                <a href='delete_user.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    // Display a message if no users are found
                    echo "<tr><td colspan='4'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
