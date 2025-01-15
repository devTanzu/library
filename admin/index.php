<?php

session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Library Management System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body,
        html {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        header {
            background-color: black;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav ul {
            list-style: none;
            text-align: center;
            padding: 10px 0;
        }

        nav li {
            display: inline-block;
            margin: 0 15px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        section {
            flex: 1;
            background-image: url('image1.jpeg');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .box {
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            width: 400px;
        }

        footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 15px 0;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <header>
            <h1>LIBRARY MANAGEMENT SYSTEM</h1>



            <?php
            if (isset($_SESSION['login_admin']))

            {?>



            <nav>
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="books.php">BOOKS</a></li>
                    <li><a href="logout.php">LOGOUT</a></li>
                </ul>
            </nav>
            <?php
            } 
            
        else {
             
                
                ?>

                <nav>
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="books.php">BOOKS</a></li>
                    <li><a href="admin_login.php">LOGIN</a></li>
                </ul>
             </nav>

             <?php

        } ?>
        </header>

        <section>
            <div class="box">
                <h1>Welcome to the Library</h1>
                <h2>Opens at: 09:00 AM</h2>
                <h2>Closes at: 10:00 PM</h2>
            </div>
        </section>


    </div>
    <?php
    include "footer.php";
    ?>
</body>

</html>