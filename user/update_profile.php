<?php
// Include connection
include "connection.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the updated data from the form
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    // SQL query to update the user's profile in the database
    $update_query = "UPDATE user SET first_name = '$first_name', last_name = '$last_name', email = '$email' WHERE id = '$user_id'";

    if (mysqli_query($db, $update_query)) {
        // After successful update, redirect to the profile page
        header("Location: profile.php?id=$user_id");
    } else {
        // Handle error
        echo "Error updating profile: " . mysqli_error($db);
    }
}
?>
