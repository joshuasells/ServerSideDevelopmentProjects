<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- index.php - main page for the Recipe tracker application
  Written by: Joshua Sells
  Date Written: 12/23/2020
  Revised:
-->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/indexStyle.css">
  <script src="recipeTracker.js" defer></script>
  <script src="functions.js"></script>
  <title>Recipe Tracker</title>

<?php
  $whitelist = array('127.0.0.1', '::1');

  if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
    // Credentials for localhost
    define("SERVER_NAME", "localhost");
    define("DBF_USER_NAME", "root");
    define("DBF_PASSWORD", "mysql");
    define("DATABASE_NAME", "termProject");
  } else {
      // Credentials for Hostgator
      define("SERVER_NAME", "gator4170.hostgator.com");
      define("DBF_USER_NAME", "joshulls_db");
      define("DBF_PASSWORD", "C.MLC.NpeGb4");
      define("DATABASE_NAME", "joshulls_termProject");
  }

  // Global connection object
  $conn = NULL;

  // Link to external library file
  require_once(getcwd( ) . "/recipeTrackerLib.php");

  // Create connection
  createConnection();

  // Select the database
  $conn->select_db(DATABASE_NAME);
  
  if (array_key_exists('hdnReturning', $_POST)) {
    $returningVisit = true;
    // Determine which button may have been clicked
    switch($_POST['hdnAction']) {
      //-------------------------------------------
      // ADD---------------------------------------
      //-------------------------------------------
      case 'add':
        // Get POST data.
        $itemName = $_POST['txtItem'];
        $itemDescription = $_POST['txtDescription'];
        $itemQuantity = $_POST['txtQuantity'];
        
        //----------------------ORIGINAL UNSAFE SQL-----------------
        // Check for duplicated in database
    /*  $sql = "SELECT ingredientID FROM ingredient
          WHERE ingredientName = '" . $itemName . "'";
        
        $result = $conn->query($sql);
        $totalRows = $result->num_rows; */
        //-----------------------END OF ORIGINAL UNSAFE SQL-----------

        // Set up a prepared statement
        $sql = "SELECT ingredientID FROM ingredient WHERE ingredientName = ?";
        if ($stmt = $conn->prepare($sql)) {
          // Pass the parameters
          $stmt->bind_param("s", $itemName);
          if ($stmt->errno) {
            echo "stmt prepare() had error.";
          }
          // Execute the query
          $stmt->execute();
          if ($stmt->errno) {
            echo "Could not execute prepared statement";
          }
          // Store the result
          $stmt->store_result();
          $totalRows = $stmt->num_rows;
          // Free results
          $stmt->free_result();
          // Close statement
          $stmt->close();
        } // end if( prepare())


        // If no duplicates, then add data.
        if ($totalRows == 0) {
          // Add to ingredient table
          //----------------------ORIGINAL UNSAFE SQL-----------------
    /*    $sql = "INSERT INTO ingredient (ingredientName, ingredientDescription)
            VALUES ('" . $itemName . "', '"
            . $itemDescription . "')";
          $result = $conn->query($sql);   */
          //-----------------------END OF ORIGINAL UNSAFE SQL-----------

          // Set up a prepared statement
          $sql = "INSERT INTO ingredient (ingredientName, ingredientDescription) VALUES (?, ?)";
          if ($stmt = $conn->prepare($sql)) {
            // Pass the parameters
            $stmt->bind_param("ss", $itemName, $itemDescription);
            if ($stmt->errno) {
              echo "stmt prepare() has error.";
            }
            // Execute the query
            $stmt->execute();
            if ($stmt->errno) {
              echo "Could not execute prepared statement";
            }
            // Free results
            $stmt->free_result();
            // Close the statement
            $stmt->close();
          } // end if( prepare())

          // Add to stock table
          //----------------------ORIGINAL UNSAFE SQL-----------------
    /*    $sql = "INSERT INTO stock (ingredientID, quantityInStock)
            VALUES (
              (SELECT ingredientID
                FROM ingredient
                WHERE ingredientName = '" . $itemName . "'
              )
            , '" . $itemQuantity . "')";
          $result = $conn->query($sql);   */
          //-----------------------END OF ORIGINAL UNSAFE SQL-----------

          //  ------ INNER QUERY TO GO INSIDE OUTER QUERY JUST BELOW THIS PREPARED STATEMENT-------
          $sql = "SELECT ingredientID FROM ingredient WHERE ingredientName = ?";
          // Set up a prepared statement
          if ($stmt = $conn->prepare($sql)) {
            // Pass the parameters
            $stmt->bind_param("s", $itemName);
            if ($stmt->errno) {
              echo "stmt prepare() had error.";
            }
            // Execute the query
            $stmt->execute();
            if ($stmt->errno) {
              echo "Could not execute prepared statement";
            }
            // Store the result
            $stmt->store_result();
            // Bind result variable
            $stmt->bind_result($ingredientID);
            // Fetch result
            $stmt->fetch();
            // Free results
            $stmt->free_result();
            // Close the statement
            $stmt->close();
          } // end of if ( prepare())
          // ------------------------------ END OF INNER QUERY. STORED RESULT IN $ingredientID. ----------------

          // ------------------------------ OUTER QUERY - ADD QUANTITY TO STOCK TABLE ----------------------
          $sql = "INSERT INTO stock (ingredientID, quantityInStock) VALUES (?, ?)";
          // Set up a prepared statement
          if ($stmt = $conn->prepare($sql)) {
            // Pass the parameters
            $stmt->bind_param("is", $ingredientID, $itemQuantity);
            if ($stmt->errno) {
              echo "stmt prepare() has error.";
            }
            // Execute the query
            $stmt->execute();
            if ($stmt->errno) {
              echo "Could not execute prepared statement";
            }
            // Free results
            $stmt->free_result();
            // Close the statement
            $stmt->close();
          } // end if ( prepare())


          // -------------------------------END OF OUTER QUERY ---------------------------------------------
        }
        break;
      //-------------------------------------------
      // EDIT -------------------------------------
      //-------------------------------------------
      case 'edit':
        // Get POST data.
        $originalItemName = $_POST['hdnOriginalName'];
        $itemName = $_POST['txtItem'];
        $itemDescription = $_POST['txtDescription'];
        $itemQuantity = $_POST['txtQuantity'];

        //----------------------ORIGINAL UNSAFE SQL-----------------
  /*    // Get ID of original data
        $sql = "SELECT ingredientID FROM ingredient
          WHERE ingredientName = '" . $originalItemName . "'";
        $result = $conn->query($sql);
        $record = $result->fetch_assoc();
        $itemID = $record['ingredientID'];    */
        //-----------------------END OF ORIGINAL UNSAFE SQL-----------

        $sql = "SELECT ingredientID FROM ingredient WHERE ingredientName = ?";
          // Set up a prepared statement
          if ($stmt = $conn->prepare($sql)) {
            // Pass the parameters
            $stmt->bind_param("s", $originalItemName);
            if ($stmt->errno) {
              echo "stmt prepare() had error.";
            }
            // Execute the query
            $stmt->execute();
            if ($stmt->errno) {
              echo "Could not execute prepared statement";
            }
            // Store the result
            $stmt->store_result();
            // Bind result variable
            $stmt->bind_result($itemID);
            // Fetch result
            $stmt->fetch();
            // Free results
            $stmt->free_result();
            // Close the statement
            $stmt->close();
          } // end of if ( prepare())
          
        
        //----------------------ORIGINAL UNSAFE SQL-----------------
  /*    // Check for duplicates in database against new edited data.
        $sql = "SELECT ingredientID FROM ingredient
          WHERE ingredientName = '" . $itemName . "'";
        $result = $conn->query($sql);
        $totalRows = $result->num_rows;   */
        //-----------------------END OF ORIGINAL UNSAFE SQL----------

        // Set up a prepared statement
        $sql = "SELECT ingredientID FROM ingredient WHERE ingredientName = ?";
        if ($stmt = $conn->prepare($sql)) {
          // Pass the parameters
          $stmt->bind_param("s", $itemName);
          if ($stmt->errno) {
            echo "stmt prepare() had error.";
          }
          // Execute the query
          $stmt->execute();
          if ($stmt->errno) {
            echo "Could not execute prepared statement";
          }
          // Store the result
          $stmt->store_result();
          $totalRows = $stmt->num_rows;
          // Bind result variable
          $stmt->bind_result($duplicateID);
          // Fetch result
          $stmt->fetch();
          // Free results
          $stmt->free_result();
          // Close statement
          $stmt->close();
        } // end if( prepare())
        
        if ($totalRows > 0) {
          if ($itemID != $duplicateID) {
            $editError = true;
          }
          else {
            $editError = false;
          }
        }
        else {
          $editError = false;
        }

        if (!$editError) {

    /*    //---------------ORIGINAL UNSAFE SQL--------------------------------------      
          // Update ingredient table
          $sql = "UPDATE ingredient SET ingredientName = '" . $itemName . "', "
            . " ingredientDescription = '" . $itemDescription . "'
            WHERE ingredientID = " . $itemID;
          $result = $conn->query($sql);
          //-------------------------END OF UNSAFE SQL----------------------------- */


          // Close out existing connection
          // Create a new one for the stored procedure
          mysqli_close($conn);
          createConnection();
          // Select the database
          $conn->select_db(DATABASE_NAME);
          // Set up the SQL String, calling a stored procedure
          $sql = "call ingredientUpdate('" . $itemName . "', '" . $itemDescription . "', '" . $itemID . "')";
          // Run the stored procedure
          $result = $conn->query($sql);
          // Close the stored procedure connection and reopen a new one
          // For other SQL calls
          mysqli_close($conn);
          createConnection();
          // Select the database
          $conn->select_db(DATABASE_NAME);

    /*    //---------------ORIGINAL UNSAFE SQL-------------------------------------- 
          // Update stock table
          $sql = "UPDATE stock SET quantityInStock = '" . $itemQuantity . "'
            WHERE ingredientID = " . $itemID;
          $result = $conn->query($sql);
          //-------------------------END OF UNSAFE SQL----------------------------- */

          // Close out existing connection
          // Create a new one for the stored procedure
          mysqli_close($conn);
          createConnection();
          // Select the database
          $conn->select_db(DATABASE_NAME);
          // Set up the SQL String, calling a stored procedure
          $sql = "call stockUpdate('" . $itemQuantity . "', '" . $itemID . "')";
          // Run the stored procedure
          $result = $conn->query($sql);
          // Close the stored procedure connection and reopen a new one
          // For other SQL calls
          mysqli_close($conn);
          createConnection();
          // Select the database
          $conn->select_db(DATABASE_NAME);


        }
        break;
      //-------------------------------------------
      // DELETE -----------------------------------
      //-------------------------------------------
      case 'delete':
        // Get POST data.
        $itemName = $_POST['hdnItem'];
        $itemDescription = $_POST['hdnDescription'];
        $itemQuantity = $_POST['hdnQuantity'];


  /*    //------------------ORIGINAL UNSAFE SQL------------------------------
        // Get item ID
        $sql = "SELECT ingredientID FROM ingredient
          WHERE ingredientName = '" . $itemName . "'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $itemID = $row['ingredientID'];   */
        //-------------------END OF UNSAFE SQL--------------------------------

        $sql = "SELECT ingredientID FROM ingredient WHERE ingredientName = ?";
          // Set up a prepared statement
          if ($stmt = $conn->prepare($sql)) {
            // Pass the parameters
            $stmt->bind_param("s", $itemName);
            if ($stmt->errno) {
              echo "stmt prepare() had error.";
            }
            // Execute the query
            $stmt->execute();
            if ($stmt->errno) {
              echo "Could not execute prepared statement";
            }
            // Store the result
            $stmt->store_result();
            // Bind result variable
            $stmt->bind_result($itemID);
            // Fetch result
            $stmt->fetch();
            // Free results
            $stmt->free_result();
            // Close the statement
            $stmt->close();
          } // end of if ( prepare())

  /*    //------------------ORIGINAL UNSAFE SQL------------------------------      
        // Delete item from ingredient table
        $sql = "DELETE FROM ingredient WHERE ingredientID = " . $itemID;
        $result = $conn->query($sql);
        //-------------------END OF UNSAFE SQL-------------------------------- */

        // $sql for prepared statement
        $sql = "DELETE FROM ingredient WHERE ingredientID = ?";
        // Prepare
        if ($stmt = $conn->prepare($sql)) {
          // Bind the parameters
          $stmt->bind_param("i", $itemID);
          if ($stmt->errno) {
            echo "stmt prepare() had error.";
          }
          // Execute the query
          $stmt->execute();
          if ($stmt->errno) {
            echo "Could not execute prepared statement";
          }
          // Free results
          $stmt->free_result();
          // Close the statement
          $stmt->close();
        } // end if (prepare())

  /*    //------------------ORIGINAL UNSAFE SQL------------------------------ 
        // Delete item from stock table
        $sql = "DELETE FROM stock WHERE ingredientID = " . $itemID;
        $result = $conn->query($sql);
        //-------------------END OF UNSAFE SQL-------------------------------- */

        // $sql for prepared statement
        $sql = "DELETE FROM stock WHERE ingredientID = ?";
        // Prepare
        if ($stmt = $conn->prepare($sql)) {
          // Bind the parameters
          $stmt->bind_param("i", $itemID);
          if ($stmt->errno) {
            echo "stmt prepare() had error.";
          }
          // Execute the query
          $stmt->execute();
          if ($stmt->errno) {
            echo "Could not execute prepared statement";
          }
          // Free results
          $stmt->free_result();
          // Close the statement
          $stmt->close();
        } // end if (prepare())

        break;
    } // end of switch()
  } // end of if returning visit.
?>

</head>
<body>
  <div class="frame">
    <!-- Navigation -->
    <header>
      <a id="logo" href="#"><img src="graphic/logo.png" alt="logo"></a>
      <nav>
        <ul class="navLinks">
          <li><a href="reflection.html">Reflection</a></li>
          <li><a id="showJSONData" href="showJSONData.php">Show JSON DATA</a></li>
          <li><a id="navInventory" class="active" onclick="showInventory()" href="#">Inventory</a></li>
          <li><a id="navRecipes" onclick="showRecipes()" href="#">Recipes</a></li>
        </ul>
      </nav>
    </header>
    <!-- End of Navigation -->
    
    <main>
      <?php
        if ($returningVisit) {

          switch($_POST['hdnAction']) {
            case 'add':
              if ($totalRows > 0) {
                echo "<div id='msgError' class='msg msgError'>This ingredient already exists! Please enter a new ingredient in.</div>";
                $executeAddInventoryRow = true;
              }
              else {
                echo "<div id='msgSuccessful' class='msg msgSuccessful'>Great! This ingredient has been saved!</div>";
              }
              break;
            case 'edit':
              if (!$editError) {
                echo "<div id='msgSuccessful' class='msg msgSuccessful'>Great! This ingredient has been saved!</div>";
              }
              else {
                echo "<div id='msgError' class='msg msgError'>It looks like you may be editing the wrong ingredient. That ingredient already exists!</div>";
              }

              break;
            case 'delete':
              echo "<div id='msgSuccessful' class='msg msgSuccessful'>Great! This ingredient has been deleted.</div>";
              break;

          }
        }
      ?>
      <!-- Div element for inventory -->
      <div id="inventory"><?php displayInventory(); ?></div>
      <!-- Div element for recipes -->
      <div id="recipes" class="hidden"><h1>Here are all my recipes</h1></div>
    </main>
    <footer>
        <h2>Welcome!</h2>
        <p>Here are a couple notes:</p>
        <ul>
          <li>Make sure to try everything. Add, edit, and delete items. I put a lot of code in here to validate everything.</li>
          <li>Let me know what you think! I plan to build out the recipe portion in due time. I also plan to make a few upgrades as well.</li>
          <li>Thank you!</li>
          
        </ul>
    </footer>
    <script>
      // This is here to let JavaScript know if it should execute the addInventoryRow() function.
      // It checks a php variable that has been populated upon an error message.
      var shouldExecute = "<?php echo $executeAddInventoryRow; ?>";
      if (shouldExecute == "1") {
        addInventoryRow();
      }
    </script>
  </div>
</body>
</html>