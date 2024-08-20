<?php      
    $host = "localhost";  
    $user = "ledpten";  
    $password = '';  
    $db_name = "ledpten";  
      
    $con = new mysqli($host, $user, $password, $db_name);  
    if(mysqli_connect_error()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    } 
   
    
?>  
