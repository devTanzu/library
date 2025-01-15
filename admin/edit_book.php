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

    // Fetch book details from the database
    $query = $db->prepare("SELECT * FROM books WHERE bid = ?");
    $query->bind_param("i", $book_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "<p>Book not found!</p>";
        exit();
    }

    // Update book details when form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $b_name = htmlspecialchars($_POST['b_name']);
        $status = htmlspecialchars($_POST['status']);
        $type = htmlspecialchars($_POST['type']);
        $price = floatval($_POST['price']);

        $update_query = $db->prepare("UPDATE books SET b_name = ?, status = ?, type = ?, price = ? WHERE bid = ?");
        $update_query->bind_param("sssdi", $b_name, $status, $type, $price, $book_id);

        if ($update_query->execute()) {
            echo "<script>alert('Book details updated successfully!'); window.location = 'manage_books.php';</script>";
        } else {
            echo "<script>alert('Failed to update book details. Please try again.');</script>";
        }
    }
} else {
    echo "<p>No book ID provided!</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        .radio-group {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .radio-group label {
            margin: 0;
        }
        .radio-group input {
            margin-right: 5px;
        }
    </style>
</head>

<body>
<div class="container">
    <h2>Edit Book</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="b_name">Book Name:</label>
            <input type="text" class="form-control" id="b_name" name="b_name" value="<?php echo htmlspecialchars($book['b_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="status" value="Available" <?php if ($book['status'] === 'Available') echo 'checked'; ?>> Available
                </label>
                <label>
                    <input type="radio" name="status" value="Not Available" <?php if ($book['status'] === 'Not Available') echo 'checked'; ?>> Not Available
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="type">Type:</label>
            <input type="text" class="form-control" id="type" name="type" value="<?php echo htmlspecialchars($book['type']); ?>" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($book['price']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="manage_books.php" class="btn btn-default">Cancel</a>
    </form>
</div>
</body>
</html>
