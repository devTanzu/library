<?php
include "connection.php"; // Include your database connection
include "navbar.php"; // Include the navbar if required
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Student Registration</title>
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
          $password = $_POST['password']; // Raw password input
          $email = htmlspecialchars($_POST['email']);

          // Regular expression for password validation
          $password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%?&])[A-Za-z\d@$!%?&]{8,}$/";

          // Server-side validation for the password
          if (!preg_match($password_pattern, $password)) {
            $error_message = "Password must be at least 8 characters long, include an uppercase letter, a lowercase letter, a number, and a special character.";
          } else {
            // Hash the password for storage
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            // Check if username already exists
            $query = $db->prepare("SELECT username FROM user WHERE username = ?");
            $query->bind_param("s", $username);
            $query->execute();
            $result = $query->get_result();

            if ($result->num_rows > 0) {
              // Username exists, set error message
              $error_message = "The username already exists. Please choose a different one.";
            } else {
              // Insert new user into the database
              $insert = $db->prepare("INSERT INTO user (first, last, username, password, email) VALUES (?, ?, ?, ?, ?)");
              $insert->bind_param("sssss", $first, $last, $username, $password_hashed, $email);

              if ($insert->execute()) {
                $success_message = "Registration Successful!";
              } else {
                $error_message = "An error occurred during registration. Please try again.";
              }

              // Close the prepared statement
              $insert->close();
            }

            // Close database connections
            $query->close();
          }
        }
        ?>

        <!-- Registration Form -->
        <form name="Registration" action="" method="post">
          <div class="login">
            <input type="text" name="first" placeholder="First Name" required style="color:black;"> <br><br>
            <input type="text" name="last" placeholder="Last Name" required style="color:black;"> <br><br>
            <input
              type="text"
              name="username"
              placeholder="Username"
              required
              style="color:black;"
              pattern="^[a-zA-Z0-9._]{3,15}$"
              title="Username must be 3-15 characters, and can include letters, numbers, dots, or underscores.">
            <br><br>
            <input
              type="password"
              name="password"
              placeholder="Password"
              required
              style="color:black;"
              pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%?&])[A-Za-z\d@$!%?&]{8,}$"
              title="Password must be at least 8 characters, include an uppercase letter, a lowercase letter, a number, and a special character.">
            <br><br>
            <input
              type="email"
              name="email"
              placeholder="Email"
              required
              style="color:black;"
              pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$"
              title="Enter a valid email address.">
            <br><br>
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
        <div style="color:white; padding-left:15px;margin-top:15px;">
        <!-- <p>
          <a style="color:yellow; text-decoration:center;" href="user_login.php">Login</a>
        </p> -->
      </div>

      </div>
    </div>
  </section>
</body>
</html>
