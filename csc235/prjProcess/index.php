<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- index.php - This page is part of the employee schedule application.
  It's purpose is to display an employee schedule for the employee to look at.
  Author: Joshua Sells
  Written: 11/28/2020
  Revised:
-->
<title>Employee Schedule</title>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/style.css">

<?php

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

  // Select the database
  $conn->select_db(DATABASE_NAME);

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
  } // end of createConnection()

  /*************************************************************
  ** Function - diplayTable() - Displays a 2D table of data.
  **
  ** Parameters: $data - Multidimensional Array holding all the employee shift data.
                 $dateArray - array of the dates to show in the table
  **************************************************************/
  function displayTable($result, $dateArray) {
    $masterArray = array();
    // Populate the masterArray array with all the names of the employees only once.
    // This is used for when I print each row of my table so that every employee's name displays once and only once.
    while($row = $result->fetch_array()) {
      if(!in_array($row[0], $masterArray)) {
        array_push($masterArray, $row[0]);
      }
    }
    // Set the mysqli pointer back to row 1.
    mysqli_data_seek($result, 0);
    
    $masterArrayLength = count($masterArray);
    
    //Display top header dates
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th></th>";
    foreach($dateArray as $date) {
      echo "<th>" . $date . "</th>";
    }
    echo "</tr>";
    
    // Begin to create the table.
    // The first for loop will be for each row in the table. This loop will run the length of $masterArray.
    for($x = 0; $x < $masterArrayLength; $x++) {
      echo "<tr>";
      echo "<th>" . $masterArray[$x] . "</th>";
      // The second loop will be for each day of the week. This loop will run 7 times.
      for($i = 0; $i < 7; $i++) {
        // The third and final loop will run through each record from the database to check the employee name and shift date.
        // This loop will run however many records are pulled from the database.
        while($row = $result->fetch_array()) {
          if($row[0] == $masterArray[$x] && $row[1] == $dateArray[$i]) {
            echo "<td>" . $row[2] . "</td>";
            // This boolean is just there to track whether the table cell has been populated by a shift time.
            $isCellPopulated = true;
          }
        }

        // If the table cell had no appropriate value, we need to still print an empty cell to maintain table structure.
        // The boolean value comes in handy by keeping track of this.
        if(!$isCellPopulated) {
          echo "<td></td>";
        }
        // Set the boolean back to false. This is very important for the table to print correctly.
        $isCellPopulated = false;
        // Set the mysqli pointer back to row 1.
        mysqli_data_seek($result, 0);
      }
      echo "</tr>";
    }
    echo "</table>";
  } // end of displayTable()

  /*************************************************************
  ** Function - getDateRange() - Returns a string array of the 7 dates of the current week.
  **
  ** Parameters: $nextWeek - optional - this will tell the function to get the date range for the following week.
  **************************************************************/
  function getDateRange($week) {
    // Check if the $nextWeek parameter was provided.
    if($week == 'this week') {
      // This switch statement check the current day of the week.
      // Depending on the day, we build an array to hold strings of the 7 days of the current week.
      switch (date("l")) {
        case "Monday":
          $dateRange = array (
            gmdate("m/d/Y", strtotime("this Monday")),
            gmdate("m/d/Y", strtotime("this Tuesday")),
            gmdate("m/d/Y", strtotime("this Wednesday")),
            gmdate("m/d/Y", strtotime("this Thursday")),
            gmdate("m/d/Y", strtotime("this Friday")),
            gmdate("m/d/Y", strtotime("this Saturday")),
            gmdate("m/d/Y", strtotime("this Sunday"))
          );
          break;

        case "Tuesday":
          $dateRange = array (
            gmdate("m/d/Y", strtotime("last Monday")),
            gmdate("m/d/Y", strtotime("this Tuesday")),
            gmdate("m/d/Y", strtotime("this Wednesday")),
            gmdate("m/d/Y", strtotime("this Thursday")),
            gmdate("m/d/Y", strtotime("this Friday")),
            gmdate("m/d/Y", strtotime("this Saturday")),
            gmdate("m/d/Y", strtotime("this Sunday"))
          );
          break;

        case "Wednesday":
          $dateRange = array (
            gmdate("m/d/Y", strtotime("last Monday")),
            gmdate("m/d/Y", strtotime("last Tuesday")),
            gmdate("m/d/Y", strtotime("this Wednesday")),
            gmdate("m/d/Y", strtotime("this Thursday")),
            gmdate("m/d/Y", strtotime("this Friday")),
            gmdate("m/d/Y", strtotime("this Saturday")),
            gmdate("m/d/Y", strtotime("this Sunday"))
          );
          break;

        case "Thursday":
          $dateRange = array (
            gmdate("m/d/Y", strtotime("last Monday")),
            gmdate("m/d/Y", strtotime("last Tuesday")),
            gmdate("m/d/Y", strtotime("last Wednesday")),
            gmdate("m/d/Y", strtotime("this Thursday")),
            gmdate("m/d/Y", strtotime("this Friday")),
            gmdate("m/d/Y", strtotime("this Saturday")),
            gmdate("m/d/Y", strtotime("this Sunday"))
          );
          break;

        case "Friday":
          $dateRange = array (
            gmdate("m/d/Y", strtotime("last Monday")),
            gmdate("m/d/Y", strtotime("last Tuesday")),
            gmdate("m/d/Y", strtotime("last Wednesday")),
            gmdate("m/d/Y", strtotime("last Thursday")),
            gmdate("m/d/Y", strtotime("this Friday")),
            gmdate("m/d/Y", strtotime("this Saturday")),
            gmdate("m/d/Y", strtotime("this Sunday"))
          );
          break;

        case "Saturday":
          $dateRange = array (
            gmdate("m/d/Y", strtotime("last Monday")),
            gmdate("m/d/Y", strtotime("last Tuesday")),
            gmdate("m/d/Y", strtotime("last Wednesday")),
            gmdate("m/d/Y", strtotime("last Thursday")),
            gmdate("m/d/Y", strtotime("last Friday")),
            gmdate("m/d/Y", strtotime("this Saturday")),
            gmdate("m/d/Y", strtotime("this Sunday"))
          );
          break;

        case "Sunday":
          $dateRange = array (
            gmdate("m/d/Y", strtotime("last Monday")),
            gmdate("m/d/Y", strtotime("last Tuesday")),
            gmdate("m/d/Y", strtotime("last Wednesday")),
            gmdate("m/d/Y", strtotime("last Thursday")),
            gmdate("m/d/Y", strtotime("last Friday")),
            gmdate("m/d/Y", strtotime("last Saturday")),
            gmdate("m/d/Y", strtotime("this Sunday"))
          );
          break;
      }
      return $dateRange;
    }

    if($week == 'next week') {
      // This switch statement check the current day of the week.
      // Depending on the day, we build an array to hold strings of the 7 days of the current week.
      switch (date("l")) {
        case "Monday":
          $dateRange = array (
            gmdate("m/d/Y", strtotime("7 days")),
            gmdate("m/d/Y", strtotime("8 days")),
            gmdate("m/d/Y", strtotime("9 days")),
            gmdate("m/d/Y", strtotime("10 days")),
            gmdate("m/d/Y", strtotime("11 days")),
            gmdate("m/d/Y", strtotime("12 days")),
            gmdate("m/d/Y", strtotime("13 days"))
          );
          break;

        case "Tuesday":
          $dateRange = array (
            gmdate("m/d/Y", strtotime("6 days")),
            gmdate("m/d/Y", strtotime("7 days")),
            gmdate("m/d/Y", strtotime("8 days")),
            gmdate("m/d/Y", strtotime("9 days")),
            gmdate("m/d/Y", strtotime("10 days")),
            gmdate("m/d/Y", strtotime("11 days")),
            gmdate("m/d/Y", strtotime("12 days"))
          );
          break;

        case "Wednesday":
          $dateRange = array (
            gmdate("m/d/Y", strtotime("5 days")),
            gmdate("m/d/Y", strtotime("6 days")),
            gmdate("m/d/Y", strtotime("7 days")),
            gmdate("m/d/Y", strtotime("8 days")),
            gmdate("m/d/Y", strtotime("9 days")),
            gmdate("m/d/Y", strtotime("10 days")),
            gmdate("m/d/Y", strtotime("11 days"))
          );
          break;

        case "Thursday":
          $dateRange = array (
            gmdate("m/d/Y", strtotime("4 days")),
            gmdate("m/d/Y", strtotime("5 days")),
            gmdate("m/d/Y", strtotime("6 days")),
            gmdate("m/d/Y", strtotime("7 days")),
            gmdate("m/d/Y", strtotime("8 days")),
            gmdate("m/d/Y", strtotime("9 days")),
            gmdate("m/d/Y", strtotime("10 days"))
          );
          break;

        case "Friday":
          $dateRange = array (
            gmdate("m/d/Y", strtotime("3 days")),
            gmdate("m/d/Y", strtotime("4 days")),
            gmdate("m/d/Y", strtotime("5 days")),
            gmdate("m/d/Y", strtotime("6 days")),
            gmdate("m/d/Y", strtotime("7 days")),
            gmdate("m/d/Y", strtotime("8 days")),
            gmdate("m/d/Y", strtotime("9 days"))
          );
          break;

        case "Saturday":
          $dateRange = array (
            gmdate("m/d/Y", strtotime("2 days")),
            gmdate("m/d/Y", strtotime("3 days")),
            gmdate("m/d/Y", strtotime("4 days")),
            gmdate("m/d/Y", strtotime("5 days")),
            gmdate("m/d/Y", strtotime("6 days")),
            gmdate("m/d/Y", strtotime("7 days")),
            gmdate("m/d/Y", strtotime("8 days"))
          );
          break;

        case "Sunday":
          $dateRange = array (
            gmdate("m/d/Y", strtotime("1 days")),
            gmdate("m/d/Y", strtotime("2 days")),
            gmdate("m/d/Y", strtotime("3 days")),
            gmdate("m/d/Y", strtotime("4 days")),
            gmdate("m/d/Y", strtotime("5 days")),
            gmdate("m/d/Y", strtotime("6 days")),
            gmdate("m/d/Y", strtotime("7 days"))
          );
          break;
      }
      return $dateRange;
    }
    
  } // end of getDateRange()

  ?>


</head>
<body>
  <div id="frame">
  <h1>Welcome</h1>
  <!-- Navigation -->
  <header>
    <nav>
      <ul class="navLinks">
        <li><a href="presentation.php">Home</a></li>
        <li><a href="index.php">User View</a></li>
        <li><a href="edit.php">Edit Page</a></li>
<!--        <li><a href="dbfCreate.php">Reset Database</a></li> -->
    </nav>
  </header>
  <h2>
    Written by: Joshua Sells<br />
    Date: 11/28/2020
  </h2>

  <h3>Employee Schedule</h3>

  <?php 

    $sql = "SELECT CONCAT(fName, ' ', lName) AS 'Employee Name', shiftDate AS 'Shift Date', shiftTime AS 'Shift Time'
      FROM employee
      LEFT JOIN empShift
      ON employee.empID = empShift.empID
      LEFT JOIN shift
      ON empShift.shiftID = shift.shiftID
      ORDER BY fName";
    $result = $conn->query($sql);
    $dateArray = getDateRange('this week');
    echo "<h4>This Week</h4>";
    displayTable($result, $dateArray);
    echo "<h4>Next Week</h4>";
    $dateArray = getDateRange('next week');
    displayTable($result, $dateArray);

  ?>

  </div>
</body>
</html>