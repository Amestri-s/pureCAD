<?php
    //Establishing connection details
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'purecadn_pcad');
    define('DB_PASSWORD', 'M9GtrSe$kTKN');
    define('DB_NAME', 'purecadn_pcaddat_dev');

    //Establishing connection
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    //Checking that the connection didn't fail
    if($link == false){
        die("Error: ". mysqli_connect_error());
    }
?>

