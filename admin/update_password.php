<?php
include "connection.php";
include "navbar.php";

// Function to validate password
function validate_password($password) {
    $errors = [];
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must include at least one uppercase letter.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must include at least one lowercase letter.";
    }
    if (!preg_match('/\d/', $password)) {
        $errors[] = "Password must include at least one number.";
    }
    if (!preg_match('/[@$!%*?&#]/', $password)) {
        $errors[] = "Password must include at least one special character (e.g., @$!%*?&).";
    }
    return $errors;
}

// Initialize variables for messages
$error_message = '';
$success_message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate passwords
    $password_errors = validate_password($new_password);

    if ($new_password !== $confirm_password) {
        $password_errors[] = "Passwords do not match.";
    }

    if (empty($password_errors)) {
        // If no errors, hash the new password and update the database
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update user details in the database
        $update_query = $db->prepare("UPDATE user SET email = ?, password = ? WHERE username = ?");
        $update_query->bind_param("sss", $email, $hashed_password, $username);

        if ($update_query->execute()) {
            $success_message = "Details updated successfully.";
        } else {
            $error_message = "Failed to update details. Please try again.";
        }

        $update_query->close();
    } else {
        // Collect all password validation errors
        $error_message = implode("<br>", $password_errors);
    }

    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Details</title>
    <style type="text/css">
        body {
            min-height: 100vh;
            margin: 0;
            background-color: red;
            background-image: url("image4.jpeg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            font-family: "Lucida Console", monospace;
        }
        .wrapper {
            width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.8); /* Semi-transparent black */
            border-radius: 10px;
            color: antiquewhite;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
        }
        .form-control {
            width: 90%;
            padding: 10px;
            margin: 15px auto;
            display: block;
            border: none;
            border-radius: 5px;
        }
        .btn {
            width: 95%;
            padding: 10px;
            margin-top: 15px;
            background-color: antiquewhite;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: gray;
            color: white;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
        .success-message {
            color: green;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <h2 style="font-size: 20px;">Update User Details</h2>
    <form action="" method="POST">
        <!-- Input for Username -->
        <input type="text" class="form-control" name="username" placeholder="Username" required>
        
        <!-- Input for Email -->
        <input type="email" class="form-control" name="email" placeholder="Email" required>
        
        <!-- Input for New Password -->
        <input type="password" class="form-control" name="new_password" placeholder="New Password" required>
        
        <!-- Input for Confirm Password -->
        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm New Password" required>
        
        <!-- Submit Button -->
        <button type="submit" class="btn">Update</button>
    </form>

    <!-- Display Error/Success Messages -->
    <?php if (!empty($error_message)) { ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php } ?>

    <?php if (!empty($success_message)) { ?>
        <p class="success-message"><?php echo $success_message; ?></p>
    <?php } ?>
</div>
</body>
</html>
