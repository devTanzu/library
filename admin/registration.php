<?php

include "connection.php"; // Include your database connection
include "navbar.php"; // Include the navbar if required

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Admin Registration</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <style>
    section {
      margin: 0;
      padding: 0;
      height: 100vh;
      overflow: hidden;
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
  <section>
    <div class="reg_img" style="background-image: url(image3.jpeg);">
      <div class="box2">
        <h1 style="text-align: center; font-size: 35px;font-family: Lucida Console;">Library Management System</h1><br>
        <h1 style="text-align: center; font-size: 25px;">Registration Form</h1><br>

        <?php
        $error_message = ''; // Variable to hold error messages
        $success_message = ''; // Variable to hold success messages

        if (isset($_POST['submit'])) {
          // Get user input
          $first = htmlspecialchars($_POST['first']);
          $last = htmlspecialchars($_POST['last']);
          $username = htmlspecialchars($_POST['username']);
          $email = htmlspecialchars($_POST['email']);
          $password = $_POST['password'];

          // Password validation function
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

          // Validate password
          $password_errors = validate_password($password);
          if (!empty($password_errors)) {
            $error_message = implode("<br>", $password_errors);
          } else {
            $password_hashed = password_hash($password, PASSWORD_DEFAULT); // Hash the password

            // Check if username already exists
            $query = $db->prepare("SELECT username FROM admin WHERE username = ?");
            $query->bind_param("s", $username);
            $query->execute();
            $result = $query->get_result();

            if ($result->num_rows > 0) {
              // Username exists, set error message
              $error_message = "The username already exists. Please choose a different one.";
            } else {
              // Insert new user into the database
              $insert = $db->prepare("INSERT INTO admin (first, last, username, email, password) VALUES (?, ?, ?, ?, ?)");
              $insert->bind_param("sssss", $first, $last, $username, $email, $password_hashed);

              if ($insert->execute()) {
                $success_message = "Registration Successful!";
              } else {
                $error_message = "An error occurred during registration. Please try again.";
              }

              // Close the prepared statement if it was created
              $insert->close();
            }

            // Close database connections
            $query->close();
          }

          $db->close();
        }
        ?>

        <!-- Registration Form -->
        <form name="Registration" action="" method="post">
          <div class="login">
            <input type="text" name="first" placeholder="First Name" required style="color:black;" value="<?php echo isset($_POST['first']) ? htmlspecialchars($_POST['first']) : ''; ?>"> <br><br>
            <input type="text" name="last" placeholder="Last Name" required style="color:black;" value="<?php echo isset($_POST['last']) ? htmlspecialchars($_POST['last']) : ''; ?>"> <br><br>
            <input type="text" name="username" placeholder="Username" required style="color:black;" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"> <br><br>
            <input type="email" name="email" placeholder="Email" required style="color:black;" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"> <br><br>
            <input type="password" name="password" placeholder="Password" required style="color:black;"> <br><br>
            <input class="btn btn-default" type="submit" name="submit" value="Sign Up" style="color: black; width: 70px; height: 30px">
          </div>
        </form>

        <!-- Display Error/Success Message -->
        <?php
        if (!empty($error_message)) {
          echo "<p class='error-message'>$error_message</p>";
        }

        if (!empty($success_message)) {
          echo "<p class='success-message'>$success_message</p>";
        }
        ?>

      </div>
    </div>
  </section>
</body>

</html>