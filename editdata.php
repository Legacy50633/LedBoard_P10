<?php
require('connection.php');
session_start();

// Error reporting (optional, for development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Redirect if user is not logged in
if (!isset($_SESSION["username"])) {
    echo "<script>alert('You must be logged in to view this page.'); window.location.href='index.php';</script>";
    exit();
}

// Initialize variables
$row = null;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Ensure the database connection is established
    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    
    // Fetch and sanitize form input
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $line = mysqli_real_escape_string($con, $_POST["line"]);
    $message = mysqli_real_escape_string($con, $_POST["message"]);
    $effect = mysqli_real_escape_string($con, $_POST["effect"]);
    
    // Create the update query
    $sql = "UPDATE data SET line='$line', message='$message', effect='$effect' WHERE id='$id'";

    // Execute the update query
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Updated Successfully'); window.location.href='./add.php';</script>";
        exit();
    } else {
        echo "<script>alert('Couldn't Update: " . mysqli_error($con) . "'); window.location.href='./editdata.php?id=$id';</script>";
        exit();
    }
}

// Check if an ID is passed for editing
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $sql = "SELECT * FROM data WHERE id='$id'";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "<script>alert('No record found!'); window.location.href='add.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('No ID provided!'); window.location.href='add.php';</script>";
    exit();
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <link rel="stylesheet" href="./editdata.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <!-- Modal Structure -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Record</h5>
                    <button type="button" class="btn-close" id="closeButton" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="./editdata.php?id=<?php echo htmlspecialchars($row['id']); ?>">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <div class="mb-3">
                            <label for="line" class="form-label">Line:</label>
                            <input type="text" name="line" id="line" value="<?php echo htmlspecialchars($row['line']); ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message:</label>
                            <input type="text" name="message" id="message" value="<?php echo htmlspecialchars($row['message']); ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="effect" class="form-label">Effect:</label>
                            <select name="effect" id="effect" class="form-select" required>
                                <option value="0" <?php if ($row['effect'] == '0') echo 'selected'; ?>>Blink</option>
                                <option value="1" <?php if ($row['effect'] == '1') echo 'selected'; ?>>Scroll</option>
                                <option value="2" <?php if ($row['effect'] == '2') echo 'selected'; ?>>Blink & Scroll</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Display the modal when the page loads
        window.onload = function() {
            var myModal = new bootstrap.Modal(document.getElementById('editModal'));
            myModal.show();
        };

        // Redirect to add.php when the Close button is clicked
        document.getElementById('closeButton').addEventListener('click', function() {
            window.location.href = 'add.php';
        });
    </script>
</body>
</html>
