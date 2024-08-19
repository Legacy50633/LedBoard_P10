<?php
require('connection.php');
session_start();

// Error reporting (optional, for development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if ID is set
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p>No ID provided.</p>";
    exit;
}

$id = $_GET['id'];

// Fetch user details from the database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows != 1) {
    echo "<p>No user found with this ID.</p>";
    exit;
}

$user = $result->fetch_assoc();

// Assign fetched data to variables
$username = $user['username'];
$email = $user['email'];
$usertype = $user['usertype'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $id = $_POST['id'];
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $usertype = intval($_POST['usertype']); // Ensure it's an integer

    // Prepare the update query
    $sql = "UPDATE users SET username = ?, email = ?, usertype = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('ssii', $username, $email, $usertype, $id);

    // Execute the update query
    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully'); window.location.href = './usersetting.php';</script>";
    } else {
        echo "<script>alert('Update failed: " . $stmt->error . "'); window.location.href = './edituser.php?id=" . htmlspecialchars($id) . "';</script>";
    }
    exit();
}

?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit User</h2>
        <form action="./edituser.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input name="username" type="text" id="username" value="<?php echo htmlspecialchars($username); ?>" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email" id="email" value="<?php echo htmlspecialchars($email); ?>" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="usertype" class="form-label">User Type</label>
                <select name="usertype" id="usertype" class="form-select" required>
                    <option value="0" <?php echo $usertype == 0 ? 'selected' : ''; ?>>Admin</option>
                    <option value="1" <?php echo $usertype == 1 ? 'selected' : ''; ?>>User</option>
                    <option value="2" <?php echo $usertype == 2 ? 'selected' : ''; ?>>View User</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
