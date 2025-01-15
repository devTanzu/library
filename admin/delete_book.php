<?php
include "connection.php"; // Include database connection
include "navbar.php"; // Include admin navbar

// Check if admin is logged in
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login_admin'])) {
    header("Location: ./login.php");
    exit();
}

// Check if book ID is provided in the URL
if (isset($_GET['id'])) {
    $book_id = intval($_GET['id']); // Get the book ID from URL

    // Delete the book from the database
    $delete_query = $db->prepare("DELETE FROM books WHERE bid = ?");
    $delete_query->bind_param("i", $book_id);

    if ($delete_query->execute()) {
        echo "<script>alert('Book deleted successfully!'); window.location = 'manage_books.php';</script>";
    } else {
        echo "<script>alert('Failed to delete the book. Please try again.'); window.location = 'manage_books.php';</script>";
    }
} else {
    echo "<script>alert('No book ID provided!'); window.location = 'manage_books.php';</script>";
}
?>
