<?php
include "navbar.php";
include "connection.php";

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login page if not logged in
if (!isset($_SESSION['login_user'])) {
    header("Location: user_login.php");
    exit();
}

// Fetch existing user data
$sql = "SELECT * FROM user WHERE username='$_SESSION[login_user]'";
$result = mysqli_query($db, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $first = $row['first'];
    $last = $row['last'];
    $username = $row['username'];
    $email = $row['email'];
} else {
    die("User not found.");
}

// Handle form submission to update data
if (isset($_POST['submit'])) {
    $first = mysqli_real_escape_string($db, $_POST['first']);
    $last = mysqli_real_escape_string($db, $_POST['last']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);

    // Hash the password if it's changed, otherwise retain the original password
    $password = $_POST['password'];
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hashing the password
    } else {
        // If password is not changed, retain the old password
        $hashed_password = $row['password']; 
    }

    // Update SQL query
    $sql_update = "UPDATE user SET 
                    first='$first', 
                    last='$last', 
                    username='$username',  
                    email='$email', 
                    password='$hashed_password'
                   WHERE username='$_SESSION[login_user]'";

    if (mysqli_query($db, $sql_update)) {
        $_SESSION['login_user'] = $username; // Update session username if changed
        echo "<script>
                alert('Profile updated successfully.');
                window.location='profile.php';
              </script>";
    } else {
        echo "<script>alert('Error updating profile.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            background-color: #004528;
            font-family: Arial, sans-serif;
            color: white;
        }

        .form-control {
            width: 100%; /* Make inputs fill the container */
            height: 35px;
            margin-bottom: 15px;
            padding: 5px;
        }

        .form-container {
            margin: 50px auto;
            width: 400px;  /* Adjust width of the container */
            background: #5cb85c;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;  /* Prevent overflow */
        }

        h2 {
            text-align: center;
            color: #fff;
        }

        .btn {
            background-color: #005f00;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 10px auto;  /* Center the button */
            width: 100%;  /* Make the button full-width */
        }

        .btn:hover {
            background-color: #004000;
        }
    </style>
</head>
<body>

    <h2>Edit Profile</h2>
    
    <div class="form-container">
        <form method="post">
            <label>First Name</label><br>
            <input type="text" class="form-control" name="first" value="<?php echo htmlspecialchars($first); ?>" required>

            <label>Last Name</label><br>
            <input type="text" class="form-control" name="last" value="<?php echo htmlspecialchars($last); ?>" required>

            <label>Username</label><br>
            <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($username); ?>" required>

            <label>Email</label><br>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label>Password</label><br>
            <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current password">

            <button type="submit" class="btn" name="submit">Save Changes</button>
        </form>
    </div>

</body>
</html>
