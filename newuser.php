<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location:index.php");
}
else{
    if($_SESSION["usertype"] != 0){
        header("Location:index.php");        
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 <link rel="stylesheet" href="./add.css">
    <link rel="stylesheet" href="./register.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Magnito Dynamics </a>
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
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Magneto Dynamics</h5>
        <span class="navbar-text">
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
    <form action="./register.php" method="post">
        <p>Username</p>
         <input id="username" name="username" type="text">
         <p>email</p>
         <input id="email" name="email" type="email">
         <p>Password</p>
         <input id="password" name="password" type="password">
         <p>Confirm Password</p>
         <input id="confirmpassword" name="confirmpassword" type="password">
         <p>User Type</p>
         <select name="usertype" id="usertype">
            <option value="0">Admin</option>
            <option value="1">View User</option>
            <option value="2"> Edit User</option>
        </select>

         <input type="submit" id = "btn" name ="submit" value="Register">
 
     </form>
     <script src="./register.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>