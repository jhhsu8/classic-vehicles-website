<?php
    // start and check for valid session
    require_once("./includes/redirectlogin.inc.php");
    // database connection
    require_once "./includes/connectvars.inc.php";
    // functions for drawing bar graph
    require_once("./includes/functions.inc.php");
    
    // store credit limit data into array
    $creditlimit = array();
    $query = "SELECT creditLimit from customers";
    $data = mysqli_query($dbc, $query)
        or die("Error querying database - $query");
    while ($row = mysqli_fetch_array($data)) {
        array_push($creditlimit, $row['creditLimit']);
    }
    
    // draw bar graph based on credit limit data
    $graph_array = fill_graph_array($creditlimit);
    $graph_name = "./charts/bar-graph-report.png";
    $graph_scale = make_graph_scale($creditlimit);
    draw_bar_graph(600, 500, $graph_array, $graph_scale, $graph_name);

    require_once("./includes/htmlhead.inc.php");
?>

    <body>
        <div id="bodycontainer">
            
<?php require_once("./includes/header.inc.php"); ?>
            
<?php require_once("./includes/navigation.inc.php"); ?>
            
            <div id="content">
                <h2>Credit Limits and Number of Customers</h2>
                <p>Our past customers had a wide range of credit limits or financial capabilities. Please select the vehicles that will fit the customer's financial requirements.</p>
                <p id="vertical-axis-title">Number of Customers</p>
                <div id="bar-graph">
                    <p><img src="<?= $graph_name ?>" alt="Credit limits and customer number bar graph"></p>
                    <p id="horizontal-axis-title">Credit Limits in US Dollars</p>
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