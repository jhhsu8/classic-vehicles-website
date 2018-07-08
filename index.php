<?php
    // start and check for valid session
    require_once("./includes/redirectlogin.inc.php");
    // HTML document
    require_once("./includes/htmlhead.inc.php");
?>

    <body>
        <div id="bodycontainer">

<?php require_once("./includes/header.inc.php"); ?>
            
<?php require_once("./includes/navigation.inc.php"); ?>
            
            <div id="content">
                <h2>Welcome, <?= $_SESSION['username'] ?>!</h2>
                <div id="welcome">
                    <p>Check out our inventory and select from the categories of cars, motorcycles, trucks and buses, planes, ships, and trains. We offer high quality products at competitive prices and attractive terms for customer finance.</p>
                </div>
                
                <div id="photos">
                    <p>A few photos of our classic vehicles</p>
                    <table>
                        <tr>
                            <td><img src="./images/chevrolet-napco.jpg" alt="Chevrolet Napco"></td>
                            <td><img src="./images/ford-thunderbird.jpg" alt="Ford Thunderbird"></td>
                            <td><img src="./images/classic-car.jpg" alt="Classic Car"></td>
                        </tr>
                        <tr>
                            <td><img src="./images/greyhound.jpg" alt="Greyhound"></td>
                            <td><img src="./images/motorcycle.jpg" alt="Motorcycle"></td>
                            <td><img src="./images/kenosha-trolley.jpg" alt="Kenosha Trolley"></td>
                        </tr>
                    </table>
                </div>
            </div>
            
<?php require_once("./includes/footer.inc.php"); ?>
            
        </div>
    </body>
</html>