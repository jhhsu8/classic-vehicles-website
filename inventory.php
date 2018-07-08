<?php
    // start and check for valid session
    require_once("./includes/redirectlogin.inc.php");
    // database connection
    require_once "./includes/connectvars.inc.php";
    // function for creating navigational page links
    require_once("./includes/functions.inc.php");
    
    //declare variables
    $error_msg = '';
    $page_links = '';

    // query to get all product lines  
    $query_productlines = "SELECT productLine FROM productlines ORDER BY productLine ASC";
    $result = mysqli_query($dbc, $query_productlines)
        or die ("Error querying database - $query_productlines");

    // get first product line
    $first_row = mysqli_fetch_array($result);
    $first_productline = $first_row['productLine'];
    $user_selection = $first_productline;

    // check if $_GET variable is set
    if (isset($_GET['productline'])) {
        // get selected product line from URL via GET
        $user_selection = trim($_GET['productline']);
    } 

    $user_selection_url = urlencode($user_selection);
 
    $current_page = 1;
    
    // check if $_GET variable is set
    if (isset($_GET['page'])) {
        // get page from URL via GET
        $current_page = trim($_GET['page']);
    }
    
    // query to get products of a product line 
    $query_products = "SELECT * FROM products WHERE productLine = '$user_selection' ORDER BY productName ASC";
    $products = mysqli_query($dbc, $query_products)
        or die ("Error querying database - $query_products");

    $total_rows = mysqli_num_rows($products); // total product rows
    $rows_per_page = 10;  // number of products per page
    $skip_rows = (($current_page - 1) * $rows_per_page); // rows to be skipped
    $number_of_pages = ceil($total_rows / $rows_per_page); // total number of pages

    // query to get ten products for each page
    $query_subset = "$query_products LIMIT $skip_rows, $rows_per_page";
    $subset = mysqli_query($dbc, $query_subset)
        or die ("Error querying database - $query_subset");
    
    // display navigational page links if we have more than one page
    if ($number_of_pages > 1) {
        $page_links = generate_page_links($user_selection_url, $current_page, $number_of_pages);
    }
    
    // display error message if invalid data provided via GET
    if ($current_page < 1 || $current_page > $number_of_pages) {
        $user_selection = '';
        $page_links = '';
        $error_msg = '<p>Sorry, there is no inventory list on this page.</p>';
    }

    // HTML document
    require_once("./includes/htmlhead.inc.php");
?>

    <body>
        <div id="bodycontainer">
            
<?php require_once("./includes/header.inc.php"); ?>
            
<?php require_once("./includes/navigation.inc.php"); ?>
            
            <div id="content">
                <p id="product-line">Please select a product line to check the makes, models, features, quantities, base prices and MSRPs.</p>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get" enctype="multipart/form-data" name="report">
                    <table>
                        <tr>
                            <td><label for="productline">Product Line:</label></td>
                            <td><select name="productline" id="productline">
                                
                                    <?php
                                        // productline selection options
                                        $productlines = mysqli_query($dbc, $query_productlines)
                                                or die ("Error querying database - $query_productlines");
                      
                                        while ($row = mysqli_fetch_array($productlines)) {
                                            $pline = $row['productLine'];
                                            if ($user_selection == $pline) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                    ?>
                                
                                    <option value="<?= $pline ?>" <?= $selected ?>><?= $pline ?></option>
                                
                                    <?php
                                        }
                                    ?>
                                
                                </select></td>
                            <td><input type="submit" name="submit" id="submit" value="Submit"></td>
                        </tr>
                    </table>
                </form>
                
                <h2><?= $user_selection ?></h2> 
                
                <p id="pagelinks">
                    
                    <?= $page_links ?>
                
                </p>
                
                <table id="inventory">
                    <tr>
                        <th class="cell">Product Line</th>
                        <th class="cell">Product ID</th>
                        <th class="cell">Product Name</th>
                        <th class="cell">Product Scale</th>
                        <th class="cell">Product Vendor</th>
                        <th class="description">Product Description</th>
                        <th class="cell">Quantity in Stock</th>
                        <th class="cell">Buy Price</th>
                        <th class="cell">MSRP</th>
                    </tr>
            
                <?php
                    $row_count = 1; // keep track of row number
                
                    // loop through each data row
                    while ($row = mysqli_fetch_array($subset)) {
                        $product_line = $row['productLine'];
                        $product_code = $row['productCode'];
                        $product_name = $row['productName'];
                        $product_scale = $row['productScale'];
                        $product_vendor = $row['productVendor'];
                        $product_description = $row['productDescription'];
                        $quantity_stock = number_format($row['quantityInStock']);
                        $buy_price = $row['buyPrice'];
                        $msrp = $row['MSRP'];
                        
                        $usd_buy_price = "US$".number_format($buy_price,2);
                        $usd_msrp = "US$".number_format($msrp,2);
              
                        $row_count++; // count row number
                    
                        if ($row_count % 2 == 0) { // even row
                            echo "<tr class='even-row-color'>
                                    <td class='cell'>$product_line</td>
                                    <td class='cell'>$product_code</td>
                                    <td class='cell'>$product_name</td>
                                    <td class='cell'>$product_scale</td>
                                    <td class='cell'>$product_vendor</td>
                                    <td class='description'>$product_description</td>
                                    <td class='cell'>$quantity_stock</td>
                                    <td class='cell'>$usd_buy_price</td>
                                    <td class='cell'>$usd_msrp</td>
                                </tr>";
                        } else { // odd row
                            echo "<tr class='odd-row-color'>
                                    <td class='cell'>$product_line</td>
                                    <td class='cell'>$product_code</td>
                                    <td class='cell'>$product_name</td>
                                    <td class='cell'>$product_scale</td>
                                    <td class='cell'>$product_vendor</td>
                                    <td class='description'>$product_description</td>
                                    <td class='cell'>$quantity_stock</td>
                                    <td class='cell'>$usd_buy_price</td>
                                    <td class='cell'>$usd_msrp</td>
                                </tr>";
                        }
                    }
                ?>
                    
                </table>
                
                <?= $error_msg ?>
                
            </div>

<?php require_once("./includes/footer.inc.php"); ?>
            
        </div>
    </body>
</html>

<?php
    // close database connection
    mysqli_close($dbc);
?>