<?php

/* = = = = = = = = = = = = = = = = = = = 
    Functions are in alphabetical order
  = = = = = = = = = = = = = = = = = = = = */

/*************************************************************
** buildIngredientRecipe - Place an ingredient into a recipe.
**
** Parameters: $ingredientName - Ingredient's name from the ingredient table
              $recipeName - Recipe's name from the recipe table
              $quantity - quantity that show be in the recipe
**************************************************************/
function buildIngredientRecipe($ingredientName, $recipeName, $quantity) {
  global $conn;
  // Determine ingredientID
  $sql = "SELECT ingredientID FROM ingredient WHERE ingredientName='" . $ingredientName . "'";
  $result = $conn->query($sql);
  $record = $result->fetch_assoc();
  $ingredientID = $record['ingredientID'];

  // Determine recipeID
  $sql = "SELECT recipeID FROM recipe WHERE recipeName='" . $recipeName . "'";
  $result = $conn->query($sql);
  $record = $result->fetch_assoc();
  $recipeID = $record['recipeID'];

  // Check to make sure ingredient isn't already in the recipe
  $sql = "SELECT recipeID FROM ingredientRecipe WHERE recipeID = " . $recipeID
    . " AND ingredientID = " . $ingredientID;
  if ($result = $conn->query($sql)) {
  // determine number of rows result set
  $rowCount = $result->num_rows;
  if($rowCount > 0) {
    echo "Ingredient " . $ingredientID
    . " is already in recipe "
    . $recipeID . "<br />";
  } else { // Not a duplicate
      $sql = "INSERT INTO ingredientRecipe (recipeID, ingredientID, quantity)
        VALUES ('" . $recipeID . "', '" . $ingredientID . "', '" . $quantity . "')";
      runQuery($sql, "Insert ingredient " . $ingredientID . " into recipe " . $recipeID, true);
  }
  }
} // end of buildIngredientRecipe()

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  * createConnection( ) - Create a database connection
  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function createConnection( ) {
  global $conn;
  // Create connection object
  $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } 
} // end of createConnection( )

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* displayInventory( ) - Execute a query and display the result
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function displayInventory() {
  echo "<div class='inventoryHeader'>\n
      <h1>Inventory</h1>\n
      <button id='btnAddItem' class='edit' type='button' onclick='addInventoryRow()'>Add item</button>\n
    </div>\n";
  
  global $conn;
        $sql = "SELECT ingredient.ingredientName AS 'Item',
          ingredient.ingredientDescription AS 'Description',
          stock.quantityInStock AS 'Quantity'
          FROM ingredient
          LEFT JOIN stock
          ON ingredient.ingredientID = stock.ingredientID
          ORDER BY ingredientName";
        $result = $conn->query($sql);
  
  // Begin displaying the table.
  if ($result->num_rows > 0) {
    echo "<form id='inventoryForm' action='index.php' method='POST'>\n";
    echo "<table id='inventoryTable' class='inventoryTable'>\n";
    // print headings (field names)
    $heading = $result->fetch_assoc( );
    echo "<thead>\n<tr>\n";
    // print field names 
    foreach($heading as $key=>$value){
      echo "<th>" . $key . "</th>\n";
    }
    echo "<th></th>\n";
    echo "</tr>\n</thead>\n<tbody>\n";
    
    // Print values for the first row
    echo "<tr>\n";
    foreach($heading as $key=>$value){
      echo "<td>" . $value . "</td>\n";
    }
    // Print the buttons of the first row
    echo "<td class='tableButton'><button class='edit' type='button' onclick='addInputTags(this)'>Edit</button>
    <button class='delete' type='button' onclick='doubleCheck(this)'>Delete</button></td>\n";
    echo "</tr>\n";
                
    // output rest of the records
    while($row = $result->fetch_assoc()) {
      //print_r($row);
      //echo "<br />";
      echo "<tr>\n";
      // print data
      foreach($row as $key=>$value) {
        echo "<td>" . $value . "</td>\n";
      }
      // Print the buttons of the rest of the rows.
      echo "<td class='tableButton'><button class='edit' type='button' onclick='addInputTags(this)'>Edit</button>
      <button class='delete' type='button' onclick='doubleCheck(this)'>Delete</button></td>\n";
      echo "</tr>\n";
    }
    echo "</tbody>\n</table>\n";
    echo "<input type='hidden' name='hdnReturning' value='returning' />";
    echo "</form>";
  } else {
      echo "<strong>zero results using SQL: </strong>" . $sql;
  }
} // end of displayInventory()  

/*****************************************************
** runQuery() - Execute a query and display message
** Parameters: $sql - SQL String to be executed.
              $msg - Text of message to display on success or error
              $echoSuccess - boolean True=Display message on success
***********************************************************************/
function runQuery($sql, $msg, $echoSuccess) {
  global $conn;

  // run the query
  if($conn->query($sql) === TRUE) {
    if($echoSuccess) {
      echo $msg . " successful.<br />";
    }
  } else {
      echo "<strong>Error when: " . $msg . "</strong> using SQL: " . $sql . "<br />" . $conn->error;
    }
  } // end of runQuery()

?>