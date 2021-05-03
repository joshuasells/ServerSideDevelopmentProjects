<?php
  /* getJSONData.php - Extract data from database and present as JSON data
  Joshua Sells
  1/3/2020
*/

// The JSON standard MIME header. Output as JSON, not HTML
header('Content-type: application/json');

// Get credentials for database
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

// Select the database
$conn->select_db(DATABASE_NAME);

// Get ingredient data
$sql = "SELECT ingredient.ingredientName AS 'Item',
          ingredient.ingredientDescription AS 'Description',
          stock.quantityInStock AS 'Quantity'
          FROM ingredient
          LEFT JOIN stock
          ON ingredient.ingredientID = stock.ingredientID
          ORDER BY ingredientName";
$result = $conn->query($sql);

// Loop through the $result to create JSON formatted data
$runnerArray = array();
while ($thisRow = $result->fetch_assoc()) {
  $runnerArray[] = $thisRow;
}
echo json_encode($runnerArray);

/* = = = = = = = = = = = = = = = = = = = 
    Functions are in alphabetical order
  = = = = = = = = = = = = = = = = = = = = */

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

?>