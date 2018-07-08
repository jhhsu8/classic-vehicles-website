<?php
    session_start();
    // database connection
    require_once "./includes/connectvars.inc.php";
    $output = 'No product information';

    // check if $_GET variable is set
    if (isset($_GET['productid'])) {
        
        $product_id = trim($_GET['productid']); // get product id from URL via GET
        $query = "SELECT * FROM products WHERE productCode = '$product_id'"; // select query
        $result = mysqli_query($dbc, $query) // query result
            or die ("Error querying database - $query");
        
        $num_rows = mysqli_num_rows($result); // number of rows in result set
        
        if ($num_rows != 0) { // valid data provided to page via GET
            
            // loop through each data row
            while ($row = mysqli_fetch_array($result)) {
                $product_code = $row['productCode'];
                $product_name = $row['productName'];
                $product_line = $row['productLine'];
                $product_scale = $row['productScale'];
                $product_vendor = $row['productVendor'];
                $product_quantity = number_format($row['quantityInStock']);
                $product_description = $row['productDescription'];
                $buy_price = $row['buyPrice'];
                $msrp = $row['MSRP'];
                
                $usd_buy_price = "US$".number_format($buy_price,2);
                $usd_msrp = "US$".number_format($msrp,2);
                
                $output = "<p>Product ID: $product_code</p>
                        <p>Product Line: $product_line</p>
                        <p>Product Scale: $product_scale</p>
                        <p>Vendor: $product_vendor</p>
                        <p>Quantity in Stock: $product_quantity</p>
                        <p>Description: $product_description</p>
                        <p>Buy Price: $usd_buy_price</p>
                        <p>MSRP: $usd_msrp</p>";
            }
        } else { // invalid data provided to page via GET
            $output = 'No match found';
        }
    }
    // HTML document
    require_once("./includes/htmlhead.inc.php");
?>

    <body>
        <div id="bodycontainer">
        
<?php require_once("./includes/header.inc.php"); ?>
            
<?php require_once("./includes/navigation.inc.php"); ?>
        
            <div id="content">
                <h2><?= $product_name ?></h2>
                <div>
                    
                    <?= $output ?>
                    
                </div>
            </div>
        
<?php require_once("./includes/footer.inc.php"); ?>
        
        </div>
    </body>
</html>

<?php
    // close database connection
    mysqli_close($dbc);
?>