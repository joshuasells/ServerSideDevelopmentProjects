<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
<link rel="stylesheet" contect="text/css" href="css/style.css">
<title>Employee Schedule Create Page</title>
</head>
<body>
  <h1>Employee Schedule Create Page</h1>
  <!-- Navigation -->
  <header>
    <nav>
      <ul class="navLinks">
        <li><a href="presentation.php">Home</a></li>
        <li><a href="index.php">User View</a></li>
        <li><a href="edit.php">Edit Page</a></li>
        <li><a href="dbfCreate.php">Reset Database</a></li>
    </nav>
  </header>
  <?php 
  /* dbfCreate.php - A page to creating a employee schedule database
  Written by Joshua Sells
  Started: 11/28/2020
  Finished: 11/28/2020
  Revised:
  */
  
  $whitelist = array('127.0.0.1', '::1');

    if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
      // Credentials for localhost
      define("SERVER_NAME", "localhost");
      define("DBF_USER_NAME", "root");
      define("DBF_PASSWORD", "mysql");
      define("DATABASE_NAME", "employeeSchedule");
    } else {
        // Credentials for Hostgator
        define("SERVER_NAME", "gator4170.hostgator.com");
        define("DBF_USER_NAME", "joshulls_db");
        define("DBF_PASSWORD", "C.MLC.NpeGb4");
        define("DATABASE_NAME", "joshulls_employeeSchedule");
    }

  /*

    // Set up connection constants
    // Credentials for localhost
    define("SERVER_NAME", "localhost");
    define("DBF_USER_NAME", "root");
    define("DBF_PASSWORD", "mysql");
    define("DATABASE_NAME", "employeeSchedule");

    // Set up connection constants
    // Credentials for remote server
    define("SERVER_NAME", "gator4170.hostgator.com");
    define("DBF_USER_NAME", "joshulls");
    define("DBF_PASSWORD", "A6D1M8O7S3jts");
    define("DATABASE_NAME", "employeeSchedule");

  */


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
  // Create Table: employee
  $sql = "CREATE TABLE IF NOT EXISTS employee (
    empID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fName VARCHAR(25) NOT NULL,
    lName VARCHAR(25) NOT NULL
    )";
  runQuery($sql, "Table: employee", true);

  // Create Table: shift
  $sql = "CREATE TABLE IF NOT EXISTS shift (
    shiftID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    shiftTime VARCHAR(5) NOT NULL
    )";
  runQuery($sql, "Table: shift", true);
  
  // Create Table: empShift
  $sql = "CREATE TABLE IF NOT EXISTS empShift (
    empShiftID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    shiftDate VARCHAR(25) NOT NULL,
    empID INT(6) NOT NULL,
    shiftID INT(6) NOT NULL
    )";
  runQuery($sql, "Table: empShift", true);

  /***********************************************
  ** Populate Tables Using Sample Data
  ************************************************/
/*
  // Populate Table: employee
  $employeeArray = array(
    array("Johnny", "Hayes"),
    array("Robert", "Fowler"),
    array("James", "Clark"),
    array("Marie-Louise", "Ledru"),
    array("Shawn", "Johnson"),
    array("Jeff", "Walten"),
    array("Joshua", "Connor"),
    array("Macy", "Jackson")
  );

  foreach($employeeArray as $employee) {
    $sql = "INSERT INTO employee (fName, lName) "
      . "VALUES ('" . $employee[0] . "', '"
      . $employee[1] . "')";
    runQuery($sql, "Record inserted for: " . $employee[0], true);
  }
*/
  // Populate Table: shift
  $shiftArray = array(
    "6-3", "7-4", "8-5", "9-6", "10-7", "11-8", "12-9", "1-10", "2-11", "3-12"
  );

  foreach($shiftArray as $shift) {
    $sql = "INSERT INTO shift (shiftTime) "
      . "VALUES ('" . $shift . "')";
    runQuery($sql, "Record inserted for: " . $shift, true);
  }


  // DEBUG ----------------------------------
  // Populate Table: empShift
  //foreach($employeeArray as $employee) {
  //  buildEmpShift($employee[0], $employee[1], $shiftArray[0], "'11/30/2020'");
  //  buildEmpShift($employee[0], $employee[1], $shiftArray[1], "'12/01/2020'");
  //  buildEmpShift($employee[0], $employee[1], $shiftArray[1], "'12/03/2020'");
  //}
  // DEBUG ----------------------------------


  /* = = = = = = = = = = = = = = = = = = = 
     Functions are in alphabetical order
   = = = = = = = = = = = = = = = = = = = = */

  /*************************************************************
  ** buildEmpShift() - Schedule an employee for a shift.
  **
  ** Parameters: $fName - student's first name
                $lName - student's last name
                $shiftTime - desired shift time
                $shiftDate - desired shift date
  **************************************************************/

  /*


  function buildEmpShift($fName, $lName, $shiftTime, $shiftDate) {
    global $conn;
    // Populate Table: empShift
    // Determine employeeID
    $sql = "SELECT empID FROM employee WHERE fName='" . $fName . "' AND lName='" . $lName . "'";
    $result = $conn->query($sql);
    $record = $result->fetch_assoc();
    $employeeID = $record['empID'];

    // Determine shiftID
    $sql = "SELECT shiftID FROM shift WHERE shiftTime='" . $shiftTime . "'";
    $result = $conn->query($sql);
    $record = $result->fetch_assoc();
    $shiftID = $record['shiftID'];

    // Check to make sure employee isn't already schedule for the shift time and date
    $sql = "SELECT empShiftID FROM empShift WHERE empID = " . $employeeID
      . " AND shiftID = " . $shiftID
      . " AND shiftDate = " . $shiftDate;
    if ($result = $conn->query($sql)) {
    // determine number of rows result set
    $rowCount = $result->num_rows;
    if($rowCount > 0) {
      echo "Employee " . $employeeID
      . " has already been scheduled for this shift" . "<br />";
    } else { // Not a duplicate
        $sql = "INSERT INTO empShift (shiftDate, empID, shiftID)
          VALUES (" . $shiftDate . ", " . $employeeID . ", " . $shiftID . ")";
        runQuery($sql, "Schedule employee " . $employeeID . " to shift " . $shiftID . " on date " . $shiftDate, true);
    }
    }
  } // end of buildEmpShift()

  */

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
  } // end of createConnection()  

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