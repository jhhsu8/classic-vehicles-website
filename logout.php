<?php
    // start and check for valid session
    require_once("./includes/redirectlogin.inc.php");

    // set local employee name to say goodbye
    $employee_name = $_SESSION['username'];

    // destroy session, logout, redirect to login page
    $_SESSION = array();

    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600);
    }

    session_destroy();
    header('Refresh: 8; login.php');

    // HTML document
    require_once("./includes/htmlhead.inc.php");
?>

    <body>
        <div id="bodycontainer">
            
<?php require_once("./includes/header.inc.php"); ?>
            
<?php require_once("./includes/navigation.inc.php"); ?>
            
            <div id="content">
                <h2>You have now logged out</h2>
                <div>
                    <p>Thank you for visiting the website of Berkeley Classic Vehicles, <?= $employee_name ?>! Please come back soon.</p>
                </div>
            </div>
            
<?php require_once("./includes/footer.inc.php"); ?>
            
        </div>
    </body>
</html>