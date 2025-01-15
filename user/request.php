<?php
include "connection.php"; // Ensure connection.php includes the database connection
include "navbar.php"; // Include navigation bar

// Start the session if it hasn't been started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['login_user'])) {
    echo "<script>alert('Please log in first to view this page.'); window.location = 'user_login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Request</title>
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

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color:rgb(117, 169, 248);
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .sidenav {
            height: 100%;
            margin-top: 70px;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #222;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        #main {
            transition: margin-left .5s;
            padding: 16px;
        }
    </style>
</head>
<body>
    <!-- Side Navigation -->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div style="color: white; margin-left:35px; font-size:20px;">
            <?php echo "WELCOME " . htmlspecialchars($_SESSION['login_user']); ?>
        </div>
        <br><br>
        <a href="profile.php">PROFILE</a>
        <a href="request.php">BOOK REQUEST</a>
    </div>

    <div id="main">
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>

        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "250px";
                document.getElementById("main").style.marginLeft = "250px";
                document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
                document.getElementById("main").style.marginLeft = "0";
                document.body.style.backgroundColor = "white";
            }
        </script>

        <h2>Book Requests</h2>

        <?php
        // Fetch the user's book requests
        $username = mysqli_real_escape_string($db, $_SESSION['login_user']);
        $query = "SELECT issue_book.bid, books.b_name, issue_book.approve, issue_book.issue, issue_book.return 
                  FROM issue_book 
                  JOIN books ON issue_book.bid = books.bid 
                  WHERE issue_book.username = '$username'";
        $result = mysqli_query($db, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered table-hover'>";
            echo "<thead>";
            echo "<tr style='background-color: #6db6b9e6;'>";
            echo "<th>Book ID</th>";
            echo "<th>Book Name</th>";
            echo "<th>Approval Status</th>";
            echo "<th>Issue Date</th>";
            echo "<th>Return Date</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
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
            echo "<p>No book requests found.</p>";
        }

        // Close the database connection
        mysqli_close($db);
        ?>
    </div>
</body>
</html>
