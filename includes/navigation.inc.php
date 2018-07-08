            <div id="navigation">
                
                <?php
                    if (isset($_SESSION['username']) && isset($_SESSION['employeeNumber'])) {
                        // user is logged in
                ?>
                
                <p class="nav"><a href="index.php" target="_self">Welcome</a></p> 
                <p class="nav"><a href="inventory.php" target="_self">Vehicle Inventory</a></p> 
                <p class="nav"><a href="bargraph.php" target="_self">Customers' Credit Limits</a></p>
                <p class="nav"><a href="customerform.php" target="_self">Customer Information Form</a></p>
                <p id="logout"><a href="logout.php" target="_self">Log Out</a></p>

                <?php
                    } else { // user is not logged in
                ?>
                
                <p id="phrase">Check Out Our Great Selection of Classic Vehicles</p>
                <p id="login"><a href="login.php" target="_self">Log In</a></p>
        
                <?php
                    } 
                ?>
                
            </div>