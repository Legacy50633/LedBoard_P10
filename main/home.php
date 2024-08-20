<?php
require("connection.php");
session_start();

// Redirect based on session
if (!isset($_SESSION['username'])) {
    header("Location:index.php");
    exit();
}else if($_SESSION["usertype"] == 0){
    $sql = "SELECT * FROM data";
    $result = mysqli_query($con, $sql);
}else{
$sql = "SELECT * FROM data ";
$result = mysqli_query($con, $sql);
}
// Fetch data from the database where the username matches the session username


// Navigation items based on user type
$ip = '
    <div class="container mt-4">
        <center>
        <form action="./saveip.php" method="post" class="ip-form">
            <label for="ip_address">Static IP Address:</label>
            <div class="d-flex">
                <input type="text" id="ip_address" name="ip" required class="form-control me-2">
                <input type="submit" value="Save IP" class="btn btn-primary">
            </div>
        </form>
        </center>
    </div>
';
$login = '<li class="nav-item"><a class="nav-link" href="./index.php">Login</a></li>';
$logout = '<li class="nav-item"><a class="nav-link" href="./logout.php">Logout</a></li>';
$settings = '
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Settings
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
            <li><a class="dropdown-item" href="./usersetting.php">User Settings</a></li>
            <li><a class="dropdown-item" href="./newuser.php">Register User</a></li>
        </ul>
    </li>
';
$register = '<li><a class="dropdown-item" href="./newuser.php">Register User</a></li>';
$view = '<li class="nav-item"><a class="nav-link" href="./dataview.php">View</a></li>';
$home = '<li class="nav-item"><a class="nav-link active" aria-current="page" href="./home.php">Home</a></li>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/add.css">    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .ip-form {
    display: flex;
    justify-content: center;
    align-items: center;
}

.ip-form .form-control {
    max-width: 300px; /* Adjust as needed */
}

.ip-form .btn {
    margin-left: 10px; /* Space between input and button */
}

        .container, .navbar, .form-group, .data-table-container, fieldset {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            background-color: #ffffff;
            margin-bottom: 20px;
            max-width: 1200px; /* Limit container width */
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

        /* Responsive adjustments */
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

        /* DataTable scroll styles */
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
            <a class="navbar-brand" href="https://www.magdyn.com/">Magneto Dynamics</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <?php echo $home; ?>
                    <?php if ($_SESSION["usertype"] == 0) { echo $settings; } ?>
                </ul>
                <form action="./logout.php" class="d-flex">
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

    <!-- IP Form Section -->
       <?php if ($_SESSION["usertype"] == 0) {
             echo $ip;
        } ?>

    <!-- Form Section -->
    <!-- <div class="container mt-4">
        <fieldset>
            <legend>Enter Message Details</legend>
            <form action="create.php" method="post" class="horizontal-form">
                <div class="form-group">
                    <label for="line">Line</label>
                    <input type="number" id="line" name="line" max="3" min="1" class="form-control" required>
                    <small class="form-text text-muted">Choose a line number between 1 and 3.</small>
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <input type="text" id="message" name="message" class="form-control" required>
                    <small class="form-text text-muted">Enter the message to be displayed.</small>
                </div>

                <div class="form-group">
                    <label for="effect">Effect</label>
                    <select name="effect" id="effect" class="form-control" required>
                        <option value="0">Blink</option>
                        <option value="1">Scroll</option>
                        <option value="2">Blink & Scroll</option>
                    </select>
                    <small class="form-text text-muted">Select the desired display effect.</small>
                </div>

                <div class="form form-submit">
                    <input type="submit" value="Submit" class="btn btn-primary mt-3">
                </div>
            </form>
        </fieldset>
    </div> -->

    <!-- Data Table Section -->
    <div class="container mt-5">
        <h2 class="mb-4">LED Message Details</h2>
        <div class="data-table-container">
            <table id="dataTable" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        
                        <th>Line</th>
                        <th>Message</th>
                        <th>Blink</th>
                        <th>Scroll</th>
                        <th>Edit</th>
                        <!-- <th>Remove</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row["id"];
                            $line = $row["line"];
                            $message = $row["message"];
                            $effect = $row["effect"];
                            $owner = $row["owner"];

                            // // Convert the effect integer to a string
                            // switch ($effect) {
                            //     case 0:
                            //         $effect = "Blink";
                            //         break;
                            //     case 1:
                            //         $effect = "Scroll";
                            //         break;
                            //     case 2:
                            //         $effect = "Blink & Scroll";
                            //         break;
                            //     default:
                            //         $effect = "Unknown";
                            // }
                          
                            // Fetch owner name
                            // $owner_sql = "SELECT username FROM users WHERE id='$owner'";
                            // $owner_result = mysqli_query($con, $owner_sql);
                            // $owner_row = mysqli_fetch_assoc($owner_result);
                            // $owner_name = $owner_row ? $owner_row["username"] : "Unknown";

                            // Output data
                            echo "<tr>";
                            
                            echo "<td>" . $line . "</td>";
                            echo "<td>" . $message . "</td>";
                            if($effect == 0){
                                echo "<td><input type='radio' value='0' checked></td>";
                                echo "<td><input type='radio'  value='1' ></td>";
                            }
                            else if ($effect == 1){
                                echo "<td><input type='radio' value='0' ></td>";
                                echo "<td><input type='radio'  value='1'checked ></td>";
                            }else{
                                echo "<td><input type='radio' value='0' checked></td>";
                                echo "<td><input type='radio'  value='1' checked></td>";
                            }
                           
                            // echo "<td>" . $owner_name . "</td>";
                            if ($_SESSION["usertype"] == 1 || $_SESSION["usertype"] == 0) {
                                echo "<td><a  href='./editdata.php?id=" . $id . "' class='btn btn-primary'   data-bs-target='#editModal' >Edit</a></td>";
                                // echo "<td><a href='./removedata.php?id=" . $id . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Remove</a></td>";
                            } else {
                                echo "<td></td><td></td>";
                            }
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/add.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                scrollCollapse: true,
               scroller: true,
              scrollY: 200,
               stateSave: true
            });
        });
    </script>
    <!-- Edit Data Modal -->
<

</body>
</html>
