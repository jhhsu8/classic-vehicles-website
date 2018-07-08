<?php
    session_start();
    //check to see if session variables are set for valid user session
    if (isset($_SESSION['username']) && isset($_SESSION['employeeNumber'])) {
        header('Location: index.php');
    } 
?>