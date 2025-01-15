<?php
include "connection.php"; // Ensure connection is included and $db is available
include "navbar.php"; // Navigation bar

// Start the session if it hasn't been started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['login_admin'])) {
    // Redirect to the login page with a message
    echo "<script>alert('Please log in first to view this page.'); window.location = 'admin_login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .srch {
            padding-left: 750px;
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

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color:rgb(118, 220, 228);
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

        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }

            .sidenav a {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>

    <!-- _________________sidenav__________________ -->

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

        <div style="color: white; margin-left:35px; font-size:20px;">
            <?php echo "WELCOME " . $_SESSION['login_admin']; ?>
        </div>

        <br><br>

        <a href="profile.php">PROFILE</a>
        <a href="dashboard.php">DASHBOARD</a>
        <a href="user.php">USER_INFO.</a>
        <a href="request.php">Book Request</a>
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

        <!-- __________________search bar_____________ -->

        <div class="srch">
            <form class="navbar-form" method="post" name="form1">
                <input class="form-control" type="text" name="search" placeholder="Search books..." required>
                <button style="background-color: #6db6b9e6;" type="submit" name="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </form>
        </div>

        <h2>List of Books</h2>

        <?php
        if (isset($_POST['submit'])) {
            $search = mysqli_real_escape_string($db, $_POST['search']);
            $q = mysqli_query($db, "SELECT * FROM books WHERE b_name LIKE '%$search%'");

            if (!$q || mysqli_num_rows($q) == 0) {
                echo "<p>Sorry! No books found. Try searching again.</p>";
            } else {
                displayBooksTable($q);
            }
        } else {
            $query = "SELECT * FROM books ORDER BY bid";
            $result = mysqli_query($db, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                displayBooksTable($result);
            } else {
                echo "<p>No books found in the database.</p>";
            }
        }

        // Function to display the books table
        function displayBooksTable($result)
        {
            echo "<table class='table table-bordered table-hover'>";
            echo "<thead>";
            echo "<tr style='background-color: #6db6b9e6;'>";
            echo "<th>Book ID (bid)</th>";
            echo "<th>Book Name (b_name)</th>";
            echo "<th>Status</th>";
            echo "<th>Type</th>";
            echo "<th>Price</th>";
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
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        }

        // Close the database connection
        mysqli_close($db);
        ?>
    </div>

</body>

</html>
