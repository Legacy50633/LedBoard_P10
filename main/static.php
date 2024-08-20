<?php
require("connection.php");
session_start();

// Assume $id is retrieved from the session or some other source, such as a query parameter.
$id = $_SESSION['id'] ?? null;  // Replace with the actual logic to get the ID.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Static IP</title>
    <link rel="stylesheet" href="../css/static.css">
</head>
<body>
    <form action="./saveip.php" method="post">
        <label for="ip_address">Static IP Address:</label>
        <input type="text" id="ip_address" name="ip" required>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <input type="submit" value="Save IP Address">
    </form>
    <script src="../js/static.js"></script>
</body>
</html>
