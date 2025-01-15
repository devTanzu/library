<?php
// Include the necessary files
include "connection.php"; // Database connection
include "navbar.php"; // Admin navigation bar

// Start the session if not started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Debug session variables
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

// // Check if the admin is logged in
// if (!isset($_SESSION['admin_user'])) {
//     echo "<script>alert('Please log in as admin to view this page.'); window.location = 'admin_login.php';</script>";
//     exit();
// }

// Retrieve username and bid from the session or GET parameters
if (isset($_GET['username']) && isset($_GET['bid'])) {
    $username = mysqli_real_escape_string($db, $_GET['username']);
    $bid = mysqli_real_escape_string($db, $_GET['bid']);
} else {
    echo "<script>alert('Invalid request parameters.'); window.location = 'admin_requests.php';</script>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Request</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .form-control {
            width: 300px;
            height: 40px;
            margin-bottom: 10px;
        }

        .container {
            text-align: center;
        }

        h3 {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>Approve Book Request</h3>
        <form action="" method="post">
            <input class="form-control" type="text" name="approve" placeholder="Yes or No" required>
            <input class="form-control" type="date" name="issue" placeholder="Issue Date" required>
            <input class="form-control" type="date" name="return" placeholder="Return Date" required>
            <button class="btn btn-success" type="submit" name="submit">Approve Request</button>
        </form>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $approve = mysqli_real_escape_string($db, $_POST['approve']);
        $issue = mysqli_real_escape_string($db, $_POST['issue']);
        $return = mysqli_real_escape_string($db, $_POST['return']);

        // Validate input
        if (strtolower($approve) !== 'yes' && strtolower($approve) !== 'no') {
            echo "<script>alert('Approval status must be Yes or No.');</script>";
        } elseif ($issue >= $return) {
            echo "<script>alert('Return date must be after the issue date.');</script>";
        } else {
            // Update the request in the database
            $query = "UPDATE issue_book SET approve='$approve', issue='$issue', `return`='$return' WHERE username='$username' AND bid='$bid'";
            $result = mysqli_query($db, $query);

            if ($result) {
                echo "<script>alert('Request updated successfully.'); window.location = 'admin_requests.php';</script>";
            } else {
                echo "<script>alert('Error updating request: " . mysqli_error($db) . "');</script>";
            }
        }
    }
    ?>

</body>

</html>
