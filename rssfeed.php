<?php
    require_once "./includes/connectvars.inc.php"; // database connection
    header('Content-Type: text/xml');
    echo '<?xml version="1.0" encoding="utf-8"?>';
    $builddate = gmdate(DATE_RSS, time()); // GMT date and time
        
    if (isset($_GET['rssLink'])) { // $_GET variable is set
            
        // get vehicle type from URL via GET
        $vehicle_type = trim($_GET['rssLink']);
        // select query
        $query = "SELECT * FROM products WHERE productLine = '$vehicle_type' ORDER BY dateAdded DESC LIMIT 10";
        // query result
        $result = mysqli_query($dbc, $query)
            or die("Error querying database - $query");
        
        $num_rows = mysqli_num_rows($result);
        
        if ($num_rows != 0) { // valid data provided to page via GET
?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title><?= $vehicle_type ?></title>
        <atom:link href="http://<?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" rel="self" type="application/rss+xml" />
        <link>http://joahsu.com/berkeley-classic-vehicles/rssfeedlinks.php</link>
        <description>RSS Feed for <?= $vehicle_type ?></description>
        <lastBuildDate><?= $builddate ?></lastBuildDate>
        <language>en-us</language> 
<?
        // loop through each data row
        while ($newArray = mysqli_fetch_array($result)) {
            $product_code = $newArray['productCode'];
            $product_name = $newArray['productName'];
            $product_line = $newArray['productLine'];
            $product_scale = $newArray['productScale'];
            $product_vendor = $newArray['productVendor'];
            $product_description = $newArray['productDescription'];
            $buy_price = $newArray['buyPrice'];
            $date_added = $newArray['dateAdded'];

            $usd_buy_price = "US$".number_format($buy_price,2);
            $pubdate = date(DATE_RSS, strtotime($date_added));

            $information = "Product Line - $product_line&lt;br /&gt;
                        Product Scale - $product_scale&lt;br /&gt;
                        Vendor - $product_vendor&lt;br /&gt;
                        Description - $product_description&lt;br /&gt;
                        Buy Price - $usd_buy_price";
?>
        <item>
            <title><?= $product_name ?></title>
            <description><?= $information ?></description>
            <link>http://joahsu.com/berkeley-classic-vehicles/product.php?productid=<?= $product_code ?></link>
            <guid isPermaLink="false">http://joahsu.com/berkeley-classic-vehicles/product.php?productid=<?= $product_code ?></guid>
            <pubDate><?= $pubdate ?></pubDate>
        </item>
<?
        }
            } else { // invalid data provided to page via GET
            require_once("./includes/xmlrss.inc.php");
        }
            } else { // $_GET variable is not set 
        require_once("./includes/xmlrss.inc.php");
    }
?>
    </channel>
</rss>

<?php
    // close database connection
    mysqli_close($dbc);
?>