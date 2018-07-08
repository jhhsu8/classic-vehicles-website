<?php
    //DB configuration variables for site
    define("HOST", "localhost");
    define("DBNAME", "SampleDB01");
    define("DBUSER", "DBUser123");
    define("PWD", "sample%data~!");
    $dbc = 0;
    
    //database connection
    $dbc = mysqli_connect(HOST, DBUSER, PWD, DBNAME)
        or die('Cannot connect to database');

    // set default character set to utf8
    mysqli_set_charset($dbc, "utf8");
?>