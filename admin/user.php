<?php
include "connection.php"; // Include the connection file
include "navbar.php"; // Include the navigation bar
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .srch {
            padding-left: 900px;
        }
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
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>

<div class="srch">
    <form class="navbar-form" method="post" name="form1">
        <input class="form-control" type="text" name="search" placeholder="Search a user..." required>
        <button style="background-color: #6db6b9e6;" type="submit" name="submit" class="btn btn-default">
            <span class="glyphicon glyphicon-search"></span>
        </button>
    </form>
</div>

<h2>List of Users</h2>

<?php
if (isset($_POST['submit'])) {
    $search = mysqli_real_escape_string($db, $_POST['search']);  // Use $db here
    $q = mysqli_query($db, "SELECT id,first, last, username, email FROM user WHERE username LIKE '%$search%'");  // Use $db here

    if (!$q || mysqli_num_rows($q) == 0) {
        echo "<p>Sorry! No user found with that username. Try searching again.</p>";
    } else {
        displayuserTable($q);
    }
} else {
    $query = "SELECT id,first, last, username, email FROM user ORDER BY id";
    $result = mysqli_query($db, $query);  // Use $db here

    if ($result && mysqli_num_rows($result) > 0) {
        displayuserTable($result);
    } else {
        echo "<p>No user found in the database.</p>";
    }
}

// Function to display the users table
function displayuserTable($result) {
    echo "<table class='table table-bordered table-hover'>";
    echo "<thead>";
    echo "<tr style='background-color: #6db6b9e6;'>";
    echo "<th>ID (id)</th>";
    echo "<th>First Name (first)</th>";
    echo "<th>Last Name (last)</th>";
    echo "<th>User Name (username)</th>";
    echo "<th>Email (email)</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['first']) . "</td>";
        echo "<td>" . htmlspecialchars($row['last']) . "</td>";
        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
}

// Close the database connection
mysqli_close($db);  // Close the connection properly
?>

</body>
</html>
