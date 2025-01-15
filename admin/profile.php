<?php
include "connection.php"; // Ensure this includes the correct database connection
include "navbar.php"; // Ensure navbar.php has session_start() at the top

// Start session (to avoid "Undefined $_SESSION" issues)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure that the database connection exists
if (!isset($db)) {
    die("Database connection error!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
            background-color: lightgreen;
            color: black;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: #004528;
            font-family: Arial, sans-serif;
        }

        .btn {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #4cae4c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #5cb85c;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="edit_profile.php" method="post">
            <button class="btn btn-default" style="float:right; width:70px;" name="submit1">Edit</button>
        </form>

        <div class="wrapper">
            <?php
            // Validate session and retrieve user data
            if (isset($_SESSION['login_admin'])) {
                $username = $_SESSION['login_admin'];
                $query = "SELECT * FROM admin WHERE username = '$username'";
                $q = mysqli_query($db, $query);

                if ($q && mysqli_num_rows($q) > 0) {
                    $row = mysqli_fetch_assoc($q);
                    ?>

                    <h2 style="text-align:center;">My Profile</h2>

                    <div style="text-align: center;"><b>WELCOME</b>
                        <h4><?php echo htmlspecialchars($username); ?></h4>
                    </div>

                    <table>
                        <tr>
                            <td><b>First Name:</b></td>
                            <td><?php echo htmlspecialchars($row['first']); ?></td>
                        </tr>
                        <tr>
                            <td><b>Last Name:</b></td>
                            <td><?php echo htmlspecialchars($row['last']); ?></td>
                        </tr>
                        <tr>
                            <td><b>Username:</b></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                        </tr>
                        <tr>
                            <td><b>Email:</b></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                        </tr>
                        <tr>
                            <td><b>Password:</b></td>
                            <td><?php echo htmlspecialchars($row['password']); ?></td> <!-- Display the password --> 
                         </tr>
                    </table>

                    <?php
                } else {
                    echo "<p style='color: red; text-align: center;'>User not found.</p>";
                }
            } else {
                echo "<p style='color: red; text-align: center;'>Please log in to view your profile.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>