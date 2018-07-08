<?php
    // start and check for valid session
    require_once("./includes/redirectindex.inc.php");
    // database connection
    require_once "./includes/connectvars.inc.php";
    
    // declare variables
    $display_form = true;
    $error_msg = '';

    $username = '';
    $username_error_msg = '';
    $valid_username = false;
    $username_regex = '/^[a-zA-Z][a-zA-Z0-9_\-]{2,23}[a-zA-Z0-9]$/';
    
    $password = '';
    $password_error_msg = '';
    $valid_password = false;
    $password_regex = '/(?=.*\d)(?=.*[a-zA-Z])(?=.*[@!\?\^\$]).{6,}/';
    
    // check if submit button has submitted form data
    if (isset($_POST['submit'])) {
        
        // get submitted form data
        $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
        
        // validate username
        if (preg_match($username_regex, $username)) {
            $valid_username = true;
        } else {
            $username_error_msg = '<span class="error">Username is not acceptable</span>';
        }
        
        // validate password
        if (preg_match($password_regex, $password)) {
            $valid_password = true;
        } else {
            $password_error_msg = '<span class="error">Password is not acceptable</span>';
        }

        if (!$valid_username || !$valid_password) {
            // one or more inputs are invalid
            $display_form = true;
         
        } else {
            
            $display_form = false;
            
            // look up username in database
            $select_query = "SELECT * FROM employees WHERE username = '$username'";
            
            $data = mysqli_query($dbc, $select_query) 
                or die("Error querying database - $select_query");
            
            if (mysqli_num_rows($data) == 0) { // username is avaliable for registration
                
                $display_form = false;
                
                // look up last added employee number in database
                $select_query_empnumber = "SELECT MAX(employeeNumber) from employees";
                
                $rows = mysqli_query($dbc, $select_query_empnumber)
                    or die("Error querying database - $select_query_empnumber");
                
                $row = mysqli_fetch_array($rows);
                
                $employee_id = $row['MAX(employeeNumber)']; // set $employee_id to last added employee number 
                
                $employee_id++; // add one to $employee_id
                
                // insert user information into database
                $insert_query = "INSERT INTO employees (employeeNumber, lastName, firstName, extension, email, officeCode, reportsTo, jobTitle, username, password) VALUES ('$employee_id', NULL, NULL, NULL, NULL, 1, 1088, NULL, '$username', md5('$password'))";
            
                mysqli_query($dbc, $insert_query)
                    or die("Error querying database - $insert_query");
                
                // redirect to login page
                header('Location: login.php');
            
            } else { // username already taken
                
                $display_form = true;
                $username_error_msg = '<span class="error">Username is already taken</span>';
            }
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
                
                <?php
                    if ($display_form) { // display entry form  
                ?>
                
                <h2>Create a User Account</h2>
                <p><span id="uname">Username</span> - Enter from 4 to 25 characters. Acceptable characters are letters, numbers, underscore, and hypen.<br>
                    First character must be a letter. Last character must be a letter or a number</p>
                <p><span id="pwd">Password</span> - Enter at least 6 characters. Password must have at least one letter, one number, and one of<br>
                    these special characters @, !, ?, ^, and $.</p>

                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" name="registerform">
                        
                    <table>
                        <tr>
                            <td><label for="username">Username:</label></td>
                            <td><input type="text" name="username" id="username" size="20" value="<?= $username ?>"><?= $username_error_msg ?></td>
                        </tr>
                        <tr>
                            <td><label for="password">Password:</label></td>
                            <td><input type="password" name="password" id="password" size="20" value="<?= $password ?>"><?= $password_error_msg ?></td>
                        </tr>
                    </table>
                    <p><input type="submit" name="submit" id="submit" value="Submit"></p>
                </form>
            
                <?php
                    }   
                ?>
                
            </div>
            
<?php require_once("./includes/footer.inc.php"); ?>
            
        </div>
    </body>
</html>

<?php
    // close database connection
    mysqli_close($dbc);
?>