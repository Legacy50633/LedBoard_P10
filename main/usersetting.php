<?php
// usersetting.php

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container, .navbar, .form-group, .data-table-container, fieldset {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            background-color: #ffffff;
            margin-bottom: 20px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .horizontal-form {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .horizontal-form .form-group {
            flex: 1;
            min-width: 150px;
        }

        .horizontal-form .form-submit {
            flex: 0;
            margin-left: auto;
        }

        .form-group input, .form-group select {
            max-width: 200px;
        }

        @media (max-width: 768px) {
            .horizontal-form {
                flex-direction: column;
                align-items: center;
            }

            .horizontal-form .form-group, .horizontal-form .form-submit {
                width: 100%;
                text-align: center;
            }
        }

        .data-table-container {
            overflow-x: auto;
            max-height: 400px;
            overflow-y: auto;
            margin-top: 20px;
            text-align: center;
        }

        table.dataTable {
            width: 100% !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="https://www.magdyn.com/Products-Services/">Magneto Dynamics</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./home.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Settings
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="./usersetting.php">User Setting</a></li>
                            <li><a class="dropdown-item" href="./newuser.php">Register User</a></li>
                        </ul>
                    </li>
                </ul>
                <form action="./logout.php" class="d-flex align-items-center">
                    <span class="navbar-text text-white me-3">
                        <i class="fa-solid fa-user"></i> <?php echo $_SESSION['username']; ?>
                    </span>
                    <button class="btn btn-outline-danger" type="submit">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Users Settings</h2>
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

                        switch ($usertype) {
                            case 0:
                                $usertypeString = "Admin";
                                break;
                            case 1:
                                $usertypeString = "User";
                                break;
                            case 2:
                                $usertypeString = "View User";
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
                                <button type="button" class="btn btn-warning btn-sm btn-edit" data-id="' . $id . '" data-bs-toggle="modal" data-bs-target="#editModal">
                                    Edit
                                </button>
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

    <!-- Modal Structure -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content will be dynamically loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

            $('.btn-edit').on('click', function() {
                var userId = $(this).data('id');
                $.ajax({
                    url: 'edituser.php',
                    type: 'GET',
                    data: { id: userId },
                    success: function(response) {
                        $('#editModal .modal-body').html(response);
                    }
                });
            });
        });
    </script>
</body>
</html>
