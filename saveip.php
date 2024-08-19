<?php
require("connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ip_address = $_POST['ip'];
    $id = $_POST['id']; // Get the ID from the hidden input field

    if (filter_var($ip_address, FILTER_VALIDATE_IP)) {
        // Prepare the SQL statement to update the IP address for the given ID
        $stmt = $con->prepare("UPDATE staticip SET ip = ? WHERE id = ?");

        if ($stmt) {
            $stmt->bind_param("si", $ip_address, $id);

            if ($stmt->execute()) {
                // Successful update
                echo "<script>
                        alert('IP updated successfully');
                        window.location.href = 'add.php';
                      </script>";
            } else {
                // Error during execution
                echo "<script>alert('Error updating IP: " . htmlspecialchars($stmt->error) . "');</script>";
            }

            $stmt->close();
        } else {
            // Prepare statement failed
            echo "<script>alert('Prepare failed: " . htmlspecialchars($con->error) . "');</script>";
        }
    } else {
        // Invalid IP format
        echo "<script>alert('Invalid IP address format');</script>";
    }
}

// Close the database connection
$con->close();
?>
