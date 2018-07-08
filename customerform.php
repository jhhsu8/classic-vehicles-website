<?php
    // start and check for valid session
    require_once("./includes/redirectlogin.inc.php");
    // database connection
    require_once "./includes/connectvars.inc.php";

    // declare variables
    $display_form = true;

    $firstname = '';
    $firstname_error_msg = '';
    $valid_firstname = false;
    $firstname_regex = '/^[a-zA-Z]{2,20}$/';
    
    $lastname = '';
    $lastname_error_msg = '';
    $valid_lastname = false;
    $lastname_regex = '/^[a-zA-Z]{2,20}$/';
    
    $company = '';
    $company_error_msg = '';
    $valid_company = false;
    $company_regex = "/^[0-9a-zA-Z\s\&]{2,40}$/";

    $phone = '';
    $digits_only_phone = '';
    $phone_error_msg = '';
    $valid_phone = false;
    $phone_regex = '/^\d{3}\-\d{3}-\d{4}$/';

    $address1 = '';
    $address1_error_msg = '';
    $valid_address1 = false;
    $address1_regex = '/^[a-zA-Z0-9#,\.\s]{2,40}$/';
        
    $address2 = '';
    $address2_error_msg = '';
    $valid_address2 = false;
    $address2_regex = '/^[a-zA-Z0-9#,\.\s]{2,40}$/';

    $city = '';
    $city_error_msg = '';
    $valid_city = false;
    $city_regex = '/^[a-zA-Z\s]{3,20}$/';

    $state = '';
    $state_error_msg = '';
    $valid_state = false;
    $state_regex = '/^[a-zA-Z\s]{2,20}$/';

    $postalcode = '';
    $postalcode_error_msg = '';
    $valid_postalcode = false;
    $postalcode_regex = '/^[0-9]{5}(\-[0-9]{4})?$/';

    $country = '';
    $country_error_msg = '';
    $valid_country = false;
    $country_regex = '/^[a-zA-Z\s]{2,20}$/';

    $salesrep = '1165';

    $creditlimit = '';
    $creditlimit_error_msg = '';
    $valid_creditlimit = false;
    $creditlimit_regex = '/^\d{1,6}$/';
    
    // SELECT query
    $query = "SELECT * FROM employees WHERE jobTitle = 'Sales Rep' ORDER BY employeeNumber ASC";
    
    // result of query
    $result = mysqli_query($dbc, $query)
        or die ("Error querying database - $query");
    
    // check if submit button has submitted form data
    if (isset($_POST['submit'])) {
        
        // get submitted form data
        $firstname = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
        $lastname = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
        $company = mysqli_real_escape_string($dbc, trim($_POST['company']));
        $phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));
        $address1 = mysqli_real_escape_string($dbc, trim($_POST['address1']));
        $address2 = mysqli_real_escape_string($dbc, trim($_POST['address2']));
        $city = mysqli_real_escape_string($dbc, trim($_POST['city']));
        $state = mysqli_real_escape_string($dbc, trim($_POST['state']));
        $postalcode = mysqli_real_escape_string($dbc, trim($_POST['postalcode']));
        $country = mysqli_real_escape_string($dbc, trim($_POST['country']));
        $salesrep = $_POST['salesrep'];
        $creditlimit = mysqli_real_escape_string($dbc, trim($_POST['creditlimit']));
        
        // validate first name
        if (preg_match($firstname_regex, $firstname)) {
            $valid_firstname = true;
        } else {
            $firstname_error_msg = '<span class="error">Enter from 2 to 20 alphabets</span>';
        }
        
        // validate last name
        if (preg_match($lastname_regex, $lastname)) {
            $valid_lastname = true;
        } else {
            $lastname_error_msg = '<span class="error">Enter from 2 to 20 alphabets</span>';
        }
        
        // validate company
        if (preg_match($company_regex, $company)) {
            $valid_company = true;
        } else {
            $company_error_msg = '<span class="error">Enter from 2 to 40 characters. Acceptable characters are alphabets, numbers, space, and &</span>';
        }
        
        // validate phone
        if (preg_match($phone_regex, $phone)) {
            $valid_phone = true;
        } else {
            $phone_error_msg = '<span class="error">Enter in xxx-xxx-xxxx format</span>';
        }
        
        // validate address line 1
        if (preg_match($address1_regex, $address1)) {
            $valid_address1 = true;
        } else {
            $address1_error_msg = '<span class="error">Enter from 2 to 40 characters. Acceptable characters are alphabets, numbers, period, space, comma, and #</span>';
        }
        
        // validate address line 2
        if (strlen($address2) == 0) {
            $valid_address2 = true;
        }
        else if (preg_match($address2_regex, $address2)){
            $valid_address2 = true;
        } else {
            $address2_error_msg = '<span class="error">Enter from 2 to 40 characters. Acceptable characters are alphabets, numbers, period, space, comma, and #</span>';
        }
        
        // validate city
        if (preg_match($city_regex, $city)) {
            $valid_city = true;
        } else {
            $city_error_msg = '<span class="error">Enter from 3 to 20 characters. Acceptable characters are alphabets and space</span>';
        }
        
        // validate state
        if (preg_match($state_regex, $state)) {
            $valid_state = true;
        } else {
            $state_error_msg = '<span class="error">Enter from 2 to 20 characters. Acceptable characters are alphabets and space</span>';
        }
             
        // validate postal code
        if (preg_match($postalcode_regex, $postalcode)) {
            $valid_postalcode = true;
        } else {
            $postalcode_error_msg = '<span class="error">Enter in xxxxx or xxxxx-xxxx format</span>';
        }
        
        // validate country
        if (preg_match($country_regex, $country)) {
            $valid_country = true;
        } else {
            $country_error_msg = '<span class="error">Enter from 2 to 20 characters. Acceptable characters are alphabets and space</span>';
        }
        
        // validate credit limit
        if (preg_match($creditlimit_regex, $creditlimit)) {
            $valid_creditlimit = true;
        } else {
            $creditlimit_error_msg = '<span class="error">Enter from 1 to 6 digits only</span>';
        }

        if (!$valid_firstname || !$valid_lastname || !$valid_company || !$valid_phone || !$valid_address1 || !$valid_address2 || !$valid_postalcode || !$valid_city || !$valid_state || !$valid_country || !$valid_creditlimit) {
            // one or more inputs are invalid
            $display_form = true;
         
        } else {
            // all inputs are valid
            $display_form = false;
            $pattern = '/[\-]/';
            $replacement = '';
            $digits_only_phone = preg_replace($pattern, $replacement, $phone);
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
                    if ($display_form) {
                ?>
                
                <h2>Customer Information Form</h2>
                <p id="application">Please complete the form below to record the customer's information.</p>
                <p>
                    All fields are required except Address Line 2. Phone is in xxx-xxx-xxxx format.<br>
                    Postal Code is 5 digits or 5 digits+4. Credit Limit is from 1 to 6 digits only.
                </p>
                <p>
                    Upon successful submission, the customer's information will be recorded in the database under your name.
                </p>
         
                    <form action = "<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" name="customerform">
                          
                        <table>
                            <tr>
                                <td><label for="firstname">First Name:</label></td>
                                <td><input type="text" name="firstname" id="firstname" size="25" value="<?= $firstname ?>"><?= $firstname_error_msg ?></td>
                            </tr>
                            <tr>
                                <td><label for="lastname">Last Name:</label></td>
                                <td><input type="text" name="lastname" id="lastname" size="25" value="<?= $lastname ?>"><?= $lastname_error_msg ?></td>
                            </tr>
                            <tr>
                                <td><label for="company">Company:</label></td>
                                <td><input type="text" name="company" id="company" size="25" value="<?= $company ?>"><?= $company_error_msg ?></td>
                            </tr>
                            <tr>
                                <td><label for="phone">Phone:</label></td>
                                <td><input type="text" name="phone" id="phone" size="25" value="<?= $phone ?>"><?= $phone_error_msg ?></td>
                            </tr>
                            <tr>
                                <td><label for="address1">Address Line 1:</label></td>
                                <td><input type="text" name="address1" id="address1" size="25" value="<?= $address1 ?>"><?= $address1_error_msg ?></td>
                            </tr>
                            <tr>
                                <td><label for="address2">Address Line 2:</label></td>
                                <td><input type="text" name="address2" id="address2" size="25" value="<?= $address2 ?>"><?= $address2_error_msg ?></td>
                            </tr>
                            <tr>
                                <td><label for="city">City:</label></td>
                                <td><input type="text" name="city" id="city" size="25" value="<?= $city ?>"><?= $city_error_msg ?></td>
                            </tr>
                            <tr>
                                <td><label for="state">State:</label></td>
                                <td><input type="text" name="state" id="state" size="25" value="<?= $state ?>"><?= $state_error_msg ?></td>
                            </tr>
                            <tr>
                                <td><label for="postalcode">Postal Code:</label></td>
                                <td><input type="text" name="postalcode" id="postalcode" size="25" value="<?= $postalcode ?>"><?= $postalcode_error_msg ?></td>
                            </tr>
                            <tr>
                                <td><label for="country">Country:</label></td>
                                <td><input type="text" name="country" id="country" size="25" value="<?= $country ?>"><?= $country_error_msg ?></td>
                            </tr>
                            <tr>
                                <td><label for="salesrep">Sales Rep:</label></td>
                                <td><select name="salesrep" id="salesrep">
                                    
                                    <?php
                                        while ($row = mysqli_fetch_array($result)) {
                                            $emp_number = $row['employeeNumber'];
                                            $emp_lastname = $row['lastName'];
                                            $emp_firstname = $row['firstName'];
                                            if ($salesrep == $emp_number) {
                                                $selected = " selected";
                                            } else {
                                                $selected = "";
                                            }
                                    ?>
                                    
                                    <option value="<?= $emp_number ?>"<?= $selected ?>><?= "$emp_number - $emp_firstname $emp_lastname" ?></option>
                                    
                                    <?php
                                        }
                                    ?>
                                    
                                    </select></td>
                            </tr>
                            <tr>
                                <td><label for="creditlimit">Credit Limit:</label></td>
                                <td><input type="text" name="creditlimit" id="creditlimit" size="25" value="<?= $creditlimit ?>"><?= $creditlimit_error_msg ?></td>
                            </tr>
                        </table>
                        <p><input type="submit" name="submit" id="submit" value="Submit"></p>
                </form>
                
                <?php
                    
                    } else {
                                             
                        $insert_query = "INSERT INTO customers (customerName, contactLastName, contactFirstName, phone, addressLine1, addressLine2, city, state, postalCode, country, salesRepEmployeeNumber, creditLimit) VALUES ('$company','$lastname','$firstname','$digits_only_phone','$address1','$address2','$city','$state','$postalcode','$country', '$salesrep','$creditlimit')";
                        
                        mysqli_query($dbc, $insert_query)
                            or die ("Error querying database - $insert_query");
                        
                        $update_query = "UPDATE customers SET addressLine2 = NULL WHERE addressLine2 = ''";
                        
                        mysqli_query($dbc, $update_query)
                            or die ("Error querying database - $update_query");
                ?>
                
                <h2>You have successfully recorded the customer's information</h2>
                <p>
                    Name: <?= "$firstname $lastname" ?><br>
                    Company: <?= $company ?><br>
                    Phone: <?= $phone ?><br>
                    Address 1: <?= $address1 ?><br>
                    Address 2: <?= $address2 ?><br>
                    City: <?= $city ?><br>
                    State: <?= $state ?><br>
                    Postal Code: <?= $postalcode ?><br>
                    Country: <?= $country ?><br>
                    Sales Representative's Number: <?= $salesrep ?><br>
                    Credit Limit: <?= $creditlimit ?>
                </p>
                
                <?php
                    }
                ?>
                
            </div>

<?php require_once("./includes/footer.inc.php"); ?>
            
        </div>
    </body>
</html>

<?php
    mysqli_close($dbc);
?>