<?php
// Include the database connection file
require('connection.php');

// Start session and check if user is logged in and is an admin
session_start();
if (!isset($_SESSION['username']) || $_SESSION["usertype"] != 0) {
    header("Location:index.php");
    exit;
}

// Check if the form is submitted and 'id' is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Get the user ID and ensure it is an integer

    // Prepare the delete query
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        // Successfully deleted the user, redirect or show a success message
        header("Location:usersetting.php"); // Redirect to the users list page
        exit;
    } else {
        // Error handling
        echo "Error deleting record: " . $con->error;
    }
} else {
    // Redirect if no ID was provided
    header("Location:usersetting.php.php");
    exit;
}

// Close the database connection
mysqli_close($con);
?>
