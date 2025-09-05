<?php
    $db_server = 'localhost';
    $db_user = 'root';  
    $db_pass = '';      
    $db_name   = 'gerichte';    
    $connection = "";

    $connection = mysqli_connect($db_server, 
                                 $db_user,
                                 $db_pass, 
                                 $db_name );

    if($connection){
        echo 'Connection established';
    }else{
        echo 'Could not connect'. mysqli_connect_error();
    }
?>