<?php
require('connection.php');
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

// Ensure the database connection is established
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if the request method is POST and an ID is provided
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = mysqli_real_escape_string($con, $_GET['id']);

       
            // Record exists and user has permission to delete it
            $sql = "DELETE FROM data WHERE id='$id'";
            if (mysqli_query($con, $sql)) {
                // Redirect after successful delete
                header("Location: dataview.php");
                exit();
            } else {
                // Display error message if the delete fails
                echo "Error deleting record: " . mysqli_error($con);
            }
    } else {
        // ID parameter is missing or empty
        echo "No ID provided!";
    }
} else {
    echo "Request method is not POST!";
}

// Close the database connection
mysqli_close($con);
?>


