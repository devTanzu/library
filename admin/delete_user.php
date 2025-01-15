<?php
// Include the database connection file
include "connection.php"; 

session_start();

// Check if the admin is logged in
if (!isset($_SESSION['login_admin'])) {
    header("Location: login.php");
    exit();
}

$admin_username = $_SESSION['login_admin']; // Get the logged-in admin's username

// Get the user ID from the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete the user from the database
    $delete_query = "DELETE FROM user WHERE id = '$user_id'";
    if (mysqli_query($db, $delete_query)) {
        header("Location: manage_user.php");
    } else {
        echo "Error deleting user: " . mysqli_error($db);
    }
} else {
    die("No user ID provided.");
}
?>
