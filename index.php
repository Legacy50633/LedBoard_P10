<?php 

require("connection.php");
session_start();

$login = ' <li class="nav-item">
            <a class="nav-link" href="./index.php">Login</a>
          </li>';
$logout = ' <li class="nav-item">
            <a class="nav-link" href="./logout.php">Logout</a>
          </li>';
$settings = '<li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Setting
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="#">Static IP</a></li>
              <li><a class="dropdown-item" href="./usersetting.php">User Setting</a></li>';
$register = '<li><a class="dropdown-item" href="./newuser.php">Register User</a></li>';    
$view = ' <li class="nav-item">
            <a class="nav-link" href="./dataview.php">View</a>
          </li>';
$home = ' <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./add.php">Add Page</a>
          </li>';         
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./log.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
           
<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Magnito Dyanics</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Magneto Dynamics  </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
         
          <?php
          if(!isset($_SESSION["username"])) {
              echo $login; 

          }
          else{
            $action = $_SESSION['usertype'] ; // Get the action from the query string or default to an empty string
       
            switch ($action) {
                case '0':
                    // Code for admin actions
                    echo $home;
                    echo $view;
                    echo $logout;   
                    echo $settings;
                    echo $register ;   
                             
                    break;
                    
                case '1':
                    // Code to view a user
                   echo $view;
                   echo $logout;
                    
                    break;
                    
                case '2':
                    // Code to edit a user
                    echo $home;
                    echo $view;
                    echo $logout;
                    break;
                 
                    
             
                }   

          }
           
              ?>
          
                   
         
      
        
         

             <!-- <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#"></a></li> 
            </ul>
          </li>
        </ul>
        <form class="d-flex mt-3" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-success" type="submit">Search</button>
        </form>
-->
      </div>
    </div>
  </div>
</nav>
<div class = "d1">
<center><h1>Login </h1></center>
    <form action="./login.php" method="post">
       <p>Username</p>
        <input id="username" name="username" type="text">
        <p>Password</p>
        <input id="password" name="password" type="password">
        <input type="submit" id = "btn" name ="submit" value="Login">

    </form>
        </div>
    <script src="./log.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>




