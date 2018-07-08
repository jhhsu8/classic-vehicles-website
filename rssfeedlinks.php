<?php
    session_start();
    // function for creating links to rss feeds
    require_once("./includes/functions.inc.php");
    //HTML document
    require_once("./includes/htmlhead.inc.php");
?>

    <body>
        <div id="bodycontainer">
            
<?php require_once("./includes/header.inc.php"); ?>
            
<?php require_once("./includes/navigation.inc.php"); ?>
            
            <div id="content">
                <h2>RSS Feeds for Vehicles</h2>
            
                <?php
                    $vehicle_types = array('Classic Cars', 'Motorcycles', 'Vintage Cars', 'Planes');
                    $rss_links = rssfeed_links($vehicle_types);
                ?>
                
                <div id="rsslinks">
                    
                    <?= $rss_links ?>
                
                </div>
            </div>
    
<?php require_once("./includes/footer.inc.php"); ?>
            
        </div>
    </body>
</html>