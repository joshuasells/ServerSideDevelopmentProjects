<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
<!-- injectionDemp.php - Demonstrate SQL Injection
  Joshua Sells
  Written: 12/05/2020
  Revised:
-->
<title>SQL Injejection</title>
<link rel="stylesheet" type="text/css" href="registration.css">

<?php

  $whitelist = array('127.0.0.1', '::1');

    if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
    // Credentials for localhost
    define("SERVER_NAME", "localhost");
    define("DBF_USER_NAME", "root");
    define("DBF_PASSWORD", "mysql");
    define("DATABASE_NAME", "sunRun");
    } else {
        // Credentials for Hostgator
        define("SERVER_NAME", "gator4170.hostgator.com");
        define("DBF_USER_NAME", "joshulls_db");
        define("DBF_PASSWORD", "C.MLC.NpeGb4");
        define("DATABASE_NAME", "joshulls_sunRun");
    }

  $conn = NULL;

  // Connect to database
  createConnection();

  // Is this a return visit?
  if (array_key_exists('hidIsReturning', $_POST)) {
    
    echo "<hr /><strong>\$_POST: </strong>";
    print_r($_POST);

    // Test input. It must be numeric
    if (is_numeric($_POST['txtID'])) {
      // Extract runner and sponsor information
      $sql = "SELECT *
      FROM runner
      WHERE id_runner = " . $_POST['txtID'];
      $result = $conn->query($sql);
      displayResult($result, $sql);
    } else {
        displayMessage("Please type in a number.", "red");
    }
  } else {
      //echo "<h1>Welcome FIRST TIME</h1>";
  } // end of if new else returning

  /**********************************************
  * createConnection() - Create a database connection
  ***********************************************/
  function createConnection() {
    global $conn;
    // Create connection object
    $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    // Select the database
    $conn->select_db(DATABASE_NAME);
  } // end of createConnection()

  /**********************************************
  * displayMessage() - Display message to user
      parameters {
        $msg - Text of the message
        $color - Hex color code for text as String
      }
  ***********************************************/
  function displayMessage($msg, $color) {
    echo "<hr /><strong style='color:" . $color . ";'>" . $msg . "</strong><hr />";
  } // end of displayMessage()

  /******************************************************
   * displayResult() - Execute a query and display the result
       parameters {
         $result - result set to display as 2D array
         $sql - SQL string used to display an error msg
       }
   **********************************************************/
  function displayResult($result, $sql) {
    echo "<strong>The SQL was: </strong>" . $sql;
    if ($result->num_rows > 0) {
      echo "<table border='1'>\n";
      // print headings (field names)
      $heading = $result->fetch_assoc();
      echo "<tr>\n";
      // print field names
      foreach ($heading as $key=>$value) {
        echo "<th>" . $key . "</th>\n";
      }
      echo "</tr>\n";
      // print values for the first row
      echo "<tr>\n";
      foreach ($heading as $key=>$value) {
        echo "<td>" . $value . "</td>\n";
      }
      // output rest of the records
      while ($row = $result->fetch_assoc()) {
        echo "<tr>\n";
        // print data
        foreach ($row as $key=>$value) {
          echo "<td>" . $value . "</td>\n";
        }
        echo "</tr>\n";
      }
      echo "</table>\n";
    } else {
      echo "<strong>Zero results using SQL: </strong>" . $sql;
    }
  } // end of displayResult()

?>
</head>
<body>
<div id="frame">
  <h1>SQL Injection Demo</h1>
  <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
    method="POST"
    name="frmRegistration"
    id="frmRegistration">

    <label for="lstRunner"><strong>Select Runner's Name</strong></label>
    <br /><br />
    <fieldset>
      <legend>Search for Runner</legend>

      <div class="topLabel">
        <label for="txtLName">Runner ID</label>
        <input type="text" name="txtID" id="txtID" value="4" />
      </div>
    </fieldset>
    <br />

    <button name="btnSubmit"
      value="new"
      style="float:left;"
      onclick="this.form.submit();">
      Search for Runner
    </button>
    <br />
    <!-- Use a hidden field to tell server if return visitor -->
    <input type="hidden" name="hidIsReturning" value="true" />
  </form>
</div>
</body>
</html>