<?php
    // start and check for valid session
    require_once("./includes/redirectindex.inc.php");
    // database connection
    require_once "./includes/connectvars.inc.php";

    // declare variables
    $display_form = true;
    $error_msg = '';
    $username = '';
    $password = '';
    
    // check if submit button has submitted form data
    if (isset($_POST['submit'])) {
        
        // get submitted form data
        $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
        
        if (strlen($username) == 0 || strlen($password) == 0) { // username or password field is blank

            $error_msg = '<p class="error">Enter both password and username</p>';
            $display_form = true;
            
        } else {
            
            // look up username and password in database
            $select_query = "SELECT * FROM employees WHERE username = '$username' AND password = md5('$password')";

            $data = mysqli_query($dbc, $select_query)
                or die("Error querying database - $select_query");

            if(mysqli_num_rows($data) == 1) { // valid username and password
                
                $display_form = false;
                $row = mysqli_fetch_array($data);
                
                // set username and employee number as session variables and redirect to index page
                $_SESSION['username'] = $row['username'];
                $_SESSION['employeeNumber'] = $row['employeeNumber'];

                header('Location: index.php');
            }

            else { // invalid username and/or password
                
                $display_form = true;
                $error_msg = '<p class="error">Invalid username and/or password.</p>';
            }
        }
    }

    // HTML document
    require_once("./includes/htmlhead.inc.php");
?>

    <body>
        <div id="bodycontainer">
            
<?php require_once("./includes/header.inc.php"); ?>
            
            <div id="content">
                
                <?php
                if ($display_form) { // display entry form  
                ?>

                <div id="block1">
                    <h2>Login</h2>
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" name="loginform">
                    
                    <?= $error_msg ?>
                        
                    <table>
                        <tr>
                            <td><label for="username">Username:</label></td>
                            <td><input type="text" name="username" id="username" size="20" value="<?= $username ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="password">Password:</label></td>
                            <td><input type="password" name="password" id="password" size="20" value="<?= $password ?>"></td>
                        </tr>
                    </table>
                    <p><input type="submit" name="submit" id="submit" value="Submit"></p>
                    </form>
            
                    <?php
                        }   
                    ?>

                    <p id="account"><a href="register.php">Create a User Account</a></p>
                </div>
                <div id="block2">
                    <p>Employees/sales representatives at Berkeley Classic Vehicles may use this website to help customers with their purchase of classical vehicle(s) they are interested in. Berkeley Classic Vehicles offers a great variety of classic vehicles from 18th century to early 2000's, including such cars as Porsche 356, BMW F650, and Ford Pickups as well as mortorcycles, buses, trains, planes, and ships. The range of vehicle prices is from US$40 to US$200.</p>
                </div>
                <div id="block3">
                    <p><img src="./images/porsche356.jpg" alt="1956 Porsche 356"></p>
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