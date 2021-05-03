<!DOCTYPE html>
<html land="en">
<head>
<meta charset="utf-8">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
<link rel="stylesheet" contect="text/css" href="css/createDatabaseStyle.css">
<title>Recipe Tracker</title>

</head>
<body>
  <h1>Recipe Tracker Create Page</h1>
  <?PHP
  /* createDatabase.php - A page to demonstrate creating a recipe tracking database using SQL and PHP
  Written by Joshua Sells
  Started: 11/19/2020
  Finished: 11/19/2020
  Revised:
  */

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

  // Create connection
  createConnection();

  // Start with a new database to start primary keys at 1
  $sql = "DROP DATABASE IF EXISTS " . DATABASE_NAME;
  runQuery($sql, "DROP " . DATABASE_NAME, true);

  // Create database if it doesn't exist
  $sql = "CREATE DATABASE IF NOT EXISTS " . DATABASE_NAME;
  runQuery($sql, "Creating " . DATABASE_NAME, true);

  // Select the database
  $conn->select_db(DATABASE_NAME);

  /*********************************
  ** Create the tables
  **********************************/
  // Create Table: recipe
  $sql = "CREATE TABLE IF NOT EXISTS recipe (
    recipeID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    recipeName VARCHAR(50) NOT NULL,
    recipeDescription TEXT NOT NULL,
    servingSize VARCHAR(25),
    numServings SMALLINT(3)
    )";
  runQuery($sql, "Table: recipe", true);
  // collectionID INT(6), (for use if database includes category table.)

  // Create Table: hotRecipe
  $sql = "CREATE TABLE IF NOT EXISTS hotRecipe (
    hotRecipeID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    recipeID INT(6) NOT NULL,
    cookTemp VARCHAR(25) NOT NULL,
    cookTime VARCHAR(25) NOT NULL
    )";
  runQuery($sql, "Table: hotRecipe", true);

  // Create Table: ingredient
  $sql = "CREATE TABLE IF NOT EXISTS ingredient (
    ingredientID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ingredientName VARCHAR(50) NOT NULL,
    ingredientDescription TEXT NOT NULL
    )";
  runQuery($sql, "Table: ingredient", true);
  // categoryID INT(6), (for use if database includes category table.)
  
  // Create Table: instruction
  $sql = "CREATE TABLE IF NOT EXISTS instruction (
    instructionID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    recipeID INT(6) NOT NULL,
    stepNumber SMALLINT(3) NOT NULL,
    instruction TEXT NOT NULL
    )";
  runQuery($sql, "Table: instruction", true);

  // Create Table: stock
  $sql = "CREATE TABLE IF NOT EXISTS stock (
    stockID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ingredientID INT(6) NOT NULL,
    quantityInStock VARCHAR(25) NOT NULL
    )";
  runQuery($sql, "Table: stock", true);
/*  
  // Create Table: category
  $sql = "CREATE TABLE IF NOT EXISTS category (
    categoryID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    categoryName VARCHAR(50) NOT NULL,
    categoryDescription TEXT
    )";
  runQuery($sql, "Table: category", true);

  // Create Table: collection
  $sql = "CREATE TABLE IF NOT EXISTS collection (
    collectionID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    collectionName VARCHAR(50) NOT NULL,
    collectionDescription TEXT
    )";
  runQuery($sql, "Table: collection", true);
*/
  // Create Table: ingredientRecipe
  $sql = "CREATE TABLE IF NOT EXISTS ingredientRecipe (
    recipeID INT(6) NOT NULL,
    ingredientID INT(6) NOT NULL,
    quantity SMALLINT(3)
    )";
  runQuery($sql, "Table: ingredientRecipe", true);

  /***********************************************
  ** Populate Tables Using Sample Data
  ************************************************/
  // Populate Table: recipe
  $recipeArray = array(
    array("Enchilada Hotdish", "Yummy hotdish!", "1 peice", 18),
    array("White Chicken Enchilada", "Yummy enchiladas!", "2 enchiladas", 10),
    array("Penna Rosa", "Lovely pasta", "1 bowl", 6),
    array("Crispy Waffles", "My favorite recipe from my mother!", "1 waffle", 4)
  );

  foreach($recipeArray as $recipe) {
    $sql = "INSERT INTO recipe (recipeName, recipeDescription, servingSize, numServings) "
      . "VALUES ('" . $recipe[0] . "', '"
      . $recipe[1] . "', '"
      . $recipe[2] . "', '"
      . $recipe[3] . "')";
    runQuery($sql, "Record inserted for: " . $recipe[0], true);
  }

  // Populate Table: hotRecipe
  $hotRecipeArray = array(
    array(1, "350 Degrees", "30 Minutes"),
    array(2, "350 Degrees", "25 Minutes")
  );

  foreach($hotRecipeArray as $hotRecipe) {
    $sql = "INSERT INTO hotRecipe (recipeID, cookTemp, cookTime) "
      . "VALUES ('" . $hotRecipe[0] . "', '"
      . $hotRecipe[1] . "', '"
      . $hotRecipe[2] . "')";
    runQuery($sql, "Record inserted for: a hot recipe", true);
  }

  // Populate Table: ingredient
  $ingredientArray = array(
    array("Milk", "Delicious liquid!"),
    array("Eggs", "Straight from the bird!"),
    array("Garlic Powder", "A very versatile spice that uses garlic"),
    array("Jerkey Sticks", "Beef jerky stick")
  );

  foreach($ingredientArray as $ingredient) {
    $sql = "INSERT INTO ingredient (ingredientName, ingredientDescription) "
      . "VALUES ('" . $ingredient[0] . "', '"
      . $ingredient[1] . "')";
    runQuery($sql, "Record inserted for: " . $ingredient[0], true);
  }

  // Populate Table: instruction
  $instructionArray = array(
    array(1, 1, "Make the enchilada hotdish"),
    array(1, 2, "Eat the enchilada hotdish!"),
    array(2, 1, "Make the Chicken enchiladas"),
    array(2, 2, "Eat the chicken enchiladas!"),
    array(3, 1, "Make the Penne Rosa"),
    array(3, 2, "Eat the Penne Rosa!"),
    array(4, 1, "Make the Crispy Waffles"),
    array(4, 2, "Eat the Crispy Waffles!")
  );

  foreach($instructionArray as $instruction) {
    $sql = "INSERT INTO instruction (recipeID, stepNumber, instruction) "
      . "VALUES ('" . $instruction[0] . "', '"
      . $instruction[1] . "', '"
      . $instruction[2] . "')";
    runQuery($sql, "Record inserted for a simple instruction", true);
  }

  // Populate Table: stock
  $stockArray = array(
    array(1, "4 gallons"),
    array(2, "2 cartons"),
    array(3, "1 container"),
    array(4, "1 bag")
  );

  foreach($stockArray as $stock) {
    $sql = "INSERT INTO stock (ingredientID, quantityInStock) "
      . "VALUES ('" . $stock[0] . "', '"
      . $stock[1] . "')";
    runQuery($sql, "Record inserted for: item in stock", true);
  }

/*  // Populate Table: category
  $categoryArray = array(
    array("Dairy", "Milks, Cheeses, etc."),
    array("Meats", "Anything from animal flesh"),
    array("Spices", "For flavoring the food!"),
    array("Snacks", "When you have the munchies!")
  );

  foreach($categoryArray as $category) {
    $sql = "INSERT INTO category (categoryName, categoryDescription) "
      . "VALUES ('" . $category[0] . "', '"
      . $category[1] . "')";
    runQuery($sql, "Record inserted for: " . $category[0], true);
  }

  // Populate Table: collection
  $collectionArray = array(
    array("Breakfast", "Most important meal of the day"),
    array("Lunch", "Eating around noon"),
    array("Dinner", "What\'s for dinner????"),
    array("Favorites", "A list of favorite recipes")
  );

  foreach($collectionArray as $collection) {
    $sql = "INSERT INTO collection (collectionName, collectionDescription) "
      . "VALUES ('" . $collection[0] . "', '"
      . $collection[1] . "')";
    runQuery($sql, "Record inserted for: " . $collection[0], true);
  }

*/

  // Populate Table: ingredientRecipe
  // populate all 4 ingredients of sample data into all 4 recipes of sample data
  foreach($ingredientArray as $ingredient) {
    buildIngredientRecipe($ingredient[0], $recipeArray[0][0], "1");
    buildIngredientRecipe($ingredient[0], $recipeArray[1][0], "1");
    buildIngredientRecipe($ingredient[0], $recipeArray[2][0], "1");
    buildIngredientRecipe($ingredient[0], $recipeArray[3][0], "1");
  }

  /***********************************************
  ** Display the tables
  ************************************************/
  // Table: recipe
  echo "<h2>Recipe Table</h2>";
  $sql = "SELECT * FROM recipe";
  $result = $conn->query($sql);
  displayResult($result, $sql);
  echo "<br />";

  // Table: hotRecipe
  echo "<h2>Hot Recipe Table</h2>";
  $sql = "SELECT * FROM hotRecipe";
  $result= $conn->query($sql);
  displayResult($result, $sql);
  echo "<br />";

  // Table: ingredient
  echo "<h2>Ingredient Table</h2>";
  $sql = "SELECT * FROM ingredient";
  $result = $conn->query($sql);
  displayResult($result, $sql);
  echo "<br />";

  // Table: instruction
  echo "<h2>Instruction Table</h2>";
  $sql = "SELECT * FROM instruction";
  $result = $conn->query($sql);
  displayResult($result, $sql);
  echo "<br />";

  // Table: stock
  echo "<h2>Stock Table</h2>";
  $sql = "SELECT * FROM stock";
  $result = $conn->query($sql);
  displayResult($result, $sql);
  echo "<br />";

/*  // Table: category
  echo "<h2>Category Table</h2>";
  $sql = "SELECT * FROM category";
  $result = $conn->query($sql);
  displayResult($result, $sql);
  echo "<br />";

  // Table: collection
  echo "<h2>Collection Table</h2>";
  $sql = "SELECT * FROM collection";
  $result = $conn->query($sql);
  displayResult($result, $sql);
  echo "<br />";
*/
  // Table: ingredientRecipe
  echo "<h2>Ingredient Recipe Table</h2>";
  $sql = "SELECT * FROM ingredientRecipe";
  $result = $conn->query($sql);
  displayResult($result, $sql);
  echo "<br />";

  // Close the database
  $conn->close();

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
  * displayResult( ) - Execute a query and display the result
  *    Parameters:  $rs -  result set to display as 2D array
  *                 $sql - SQL string used to display an error msg
  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
  function displayResult($result, $sql) {
    if ($result->num_rows > 0) {
      echo "<table border='1'>\n";
      // print headings (field names)
      $heading = $result->fetch_assoc( );
      echo "<tr>\n";
      // print field names 
      foreach($heading as $key=>$value){
        echo "<th>" . $key . "</th>\n";
      }
      echo "</tr>\n";
      
      // Print values for the first row
      echo "<tr>\n";
      foreach($heading as $key=>$value){
        echo "<td>" . $value . "</td>\n";
      }
                 
      // output rest of the records
      while($row = $result->fetch_assoc()) {
        //print_r($row);
        //echo "<br />";
        echo "<tr>\n";
        // print data
        foreach($row as $key=>$value) {
          echo "<td>" . $value . "</td>\n";
        }
        echo "</tr>\n";
      }
      echo "</table>\n";
    } else {
        echo "<strong>zero results using SQL: </strong>" . $sql;
    }
  } // end of displayResult( )  

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
</body>
</html>