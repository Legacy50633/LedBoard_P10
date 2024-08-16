<?php
// Include the database connection file
require('connection.php');

// Start session and check if user is logged in and is an admin
session_start();
if (!isset($_SESSION['username']) || $_SESSION["usertype"] != 0) {
    header("Location:index.php");
    exit;
}

// Fetch all records from the 'users' table
$sql = "SELECT * FROM users";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Data Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" href="./usersetting.css"> -->

</head>
<body>
<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Magneto Dynamics </a>
    <span class="navbar-text ms-auto">
        <?php
        echo $_SESSION["username"];
        ?>
      </span>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Magnito Dynamics</h5>
        <span class="navbar-text ms-auto">
        <?php
        echo $_SESSION["username"];
        ?>
      </span>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <?php
              $action = $_SESSION['usertype'];
              switch ($action) {
                  case '0':
                      echo '<li class="nav-item"><a class="nav-link active" href="./add.php">Add Page</a></li>';
                      echo '<li class="nav-item"><a class="nav-link" href="./dataview.php">View</a></li>';
                      echo '<li class="nav-item"><a class="nav-link" href="./logout.php">Logout</a></li>';
                      echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Setting</a>';
                      echo '<ul id = "static" class="dropdown-menu dropdown-menu-dark"><li><a class="dropdown-item" href="#">Static IP</a></li>';
                      echo '<li><a class="dropdown-item" href="./usersetting.php">User Setting</a></li>';
                      echo '<li><a class="dropdown-item" href="./newuser.php">Register User</a></li></ul></li>';
                      break;
                  case '1':
                      echo '<li class="nav-item"><a class="nav-link" href="./dataview.php">View</a></li>';
                      echo '<li class="nav-item"><a class="nav-link" href="./logout.php">Logout</a></li>';
                      break;
                  case '2':
                      echo '<li class="nav-item"><a class="nav-link active" href="./add.php">Add page</a></li>';
                      echo '<li class="nav-item"><a class="nav-link" href="./dataview.php">View</a></li>';
                      echo '<li class="nav-item"><a class="nav-link" href="./logout.php">Logout</a></li>';
                      break;
              }
          ?>
        </ul>
      </div>
    </div>
  </div>
</nav><br><br>

<div class="container mt-5">
    <h2 class="mb-4">Users Data Table</h2>
    <table id="dataTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row["id"];
                    $username = $row["username"];
                    $email = $row["email"];
                    $usertype = $row["usertype"];

                    // Convert usertype integer to string
                    switch ($usertype) {
                        case 0:
                            $usertypeString = "Admin";
                            break;
                        case 1:
                            $usertypeString = "View User";
                            break;
                        case 2:
                            $usertypeString = "Edit User";
                            break;
                        default:
                            $usertypeString = "Unknown";
                    }

                    echo "<tr>";
                    echo "<td>" . $id . "</td>";
                    echo "<td>" . $username . "</td>";
                    echo "<td>" . $email . "</td>";
                    echo "<td>" . $usertypeString . "</td>";
                    echo '<td>
                            <form action="edituser.php" method="get" style="display:inline;">
                                <input type="hidden" name="id" value="' . $id . '">
                                <input type="submit" class="btn btn-warning btn-sm" value="Edit">
                            </form>
                            <form action="removeuser.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="' . $id . '">
                                <input type="submit" class="btn btn-danger btn-sm" value="Remove" onclick="return confirm(\'Are you sure you want to remove this user?\')">
                            </form>
                          </td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No data found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>

<script>


  </script>

</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
