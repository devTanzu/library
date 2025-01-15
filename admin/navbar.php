<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library Management System</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand active">LIBRARY MANAGEMENT SYSTEM</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="index.php">HOME</a></li>
      <li><a href="books.php">BOOKS</a></li>
    </ul>

    <?php
    if (isset($_SESSION['login_admin'])) {
      ?>
      <!-- <ul class="nav navbar-nav">
        <li><a href="profile.php">PROFILE</a></li>
        <li><a href="user.php">
          USER-INFORMATION
        </a></li>
        
      </ul> -->
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="">
            <div style="color: white;">
              <?php echo " " . $_SESSION['login_admin']; ?>
            </div>
          </a>
        </li>
        <li>
          <a href="logout.php">
            <span class="glyphicon glyphicon-log-out"> LOGOUT</span>
          </a>
        </li>
        <!-- <li><a href="user.php">
          USER-INFORMATION
        </a></li> -->
      </ul>
      <?php
    } else {
      ?>
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="admin_login.php">
            <span class="glyphicon glyphicon-log-in"> LOGIN</span>
          </a>
        </li>
        <li>
          <a href="registration.php">
            <span class="glyphicon glyphicon-user"> SIGN UP</span>
          </a>
        </li>
      </ul>
      <?php
    }
    ?>
  </div>
</nav>
</body>
</html>
