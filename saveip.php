<?php
require('connection.php');

// Enable error reporting for debugging
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize the input
    $ip_address = $_POST['ip'];

    // Validate IP address
    if (filter_var($ip_address, FILTER_VALIDATE_IP)) {
        // Prepare and bind
        $stmt = $con->prepare("INSERT INTO staticip (ip) VALUES (?)");
        
        if ($stmt === false) {
            die("Prepare failed: " . htmlspecialchars($con->error));
        }

        $stmt->bind_param("s", $ip_address);

        // Execute and check for errors
        if ($stmt->execute()) {
            echo "IP address saved successfully.";
            header("Location: add.php");
        } else {
            echo "Error executing statement: " . htmlspecialchars($stmt->error);    
        }

        $stmt->close();
    } else {
        echo "Invalid IP address format: " . htmlspecialchars($ip_address);
    }
} else {
    echo "No data received.";
}

$con->close();
?>
