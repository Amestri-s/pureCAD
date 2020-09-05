<?php
    //Establishing connection details
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'scfrsite_scfrdata');
    define('DB_PASSWORD', 'scfrdata11');
    define('DB_NAME', 'scfrsite_scfrdata');

    //Establishing connection
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    //Checking that the connection didn't fail
    if($link == false){
        die("Error: ". mysqli_connect_error());
    }
?>

