<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- edit.php - This page is part of the employee schedule application.
    It's purpose is to allow an authorized individual to manage the employee schedule.
    Author: Joshua Sells
    Written: 11/30/2020
    Revised:
  -->
  <title>Employee Schedule Edit Page</title>
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

    // Is this a return visit?
    if(array_key_exists("btnSubmit", $_POST)) {
      switch($_POST["btnSubmit"]) {

        case "Add information":
          addEmployee();
          break;

        case "Remove":
          removeEmployee();
          break;

        case "Schedule":
          scheduleEmployee();
          break;

        case "Unschedule":
          unscheduleEmployee();
          break;
      }  // end of switch
    }

    /* = = = = = = = = = = = = = = = = = = = 
        Functions are in alphabetical order
    = = = = = = = = = = = = = = = = = = = = */

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    * addEmployee() - Adds an employee to the database.
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    function addEmployee() {
      $sql = "INSERT INTO employee (fName, lName)
        VALUES ('" . $_POST['txtFName'] . "', '" . $_POST['txtLName'] . "')";
      runQuery($sql, "Inserted Record for: " . $_POST['txtFName'], true);
    } // end of addEmployee()

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    * createConnection() - Create a database connection
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    function createConnection() {
      global $conn;
      // Create connection object
      $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
    } // end of createConnection()

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    * removeEmployee() - Removes an employee from the database.
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    function removeEmployee() {
      $sql = "DELETE FROM employee
        WHERE empID = " . $_POST['lstRemoveEmployee'];
      runQuery($sql, "Deleted Record for: " . $_POST['lstRemoveEmployee'], true);
      $sql = "DELETE FROM empShift
        WHERE empID = " . $_POST['lstRemoveEmployee'];
      runQuery($sql, "Deleted Record for: " . $_POST['lstRemoveEmployee'], false);
    } // end of removeEmployee()

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

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    * scheduleEmployee() - Schedules an employee for a shift.
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    function scheduleEmployee() {
      global $conn;
      // Check to make sure employee isn't already schedule for the shift time and date
      $sql = "SELECT empShiftID FROM empShift WHERE empID = " . $_POST['lstScheduleEmployee']
        . " AND shiftID = " . $_POST['lstScheduleTime']
        . " AND shiftDate = '" . $_POST['txtDate'] . "'";
      if ($result = $conn->query($sql)) {
      // determine number of rows result set
      $rowCount = $result->num_rows;
      if($rowCount > 0) {
        echo "Employee " . $_POST['lstScheduleEmployee']
        . " has already been scheduled for this shift" . "<br />";
      } else { // Not a duplicate
          $sql = "INSERT INTO empShift (shiftDate, empID, shiftID)
          VALUES ('" . $_POST['txtDate'] . "', '" 
          . $_POST['lstScheduleEmployee'] . "', '" 
          . $_POST['lstScheduleTime'] . "')";
        runQuery($sql, "Scheduled employee: " . $_POST['lstScheduleEmployee'] . " on date: " . $_POST['txtDate'], true);
        }
      }
    } // end of scheduleEmployee()

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    * unscheduleEmployee() - Unschedules an employee for a shift.
    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    function unscheduleEmployee() {
      global $conn;
      // Check to make sure employee is already scheduled for the shift time and date
      $sql = "SELECT empShiftID FROM empShift WHERE empID = " . $_POST['lstUnscheduleEmployee']
        . " AND shiftID = " . $_POST['lstUnscheduleTime']
        . " AND shiftDate = '" . $_POST['txtUnscheduleDate'] . "'";
      echo $sql;
      if ($result = $conn->query($sql)) {
      // determine number of rows result set
      $rowCount = $result->num_rows;
      echo $rowCount;
      if($rowCount = 0) {
        echo "Employee " . $_POST['lstUnscheduleEmployee']
        . " was never scheduled for this shift" . "<br />";
      } else { // Delete record
          $sql = "DELETE FROM empShift
            WHERE empID = " . $_POST['lstUnscheduleEmployee']
            . " AND shiftID = " . $_POST['lstUnscheduleTime']
            . " AND shiftDate = '" . $_POST['txtUnscheduleDate'] . "'"; 
        runQuery($sql, "Unscheduled employee: " . $_POST['lstUnscheduleEmployee'] . " on date: " . $_POST['txtUnscheduleDate'], true);
        }
      }
    } // end of unscheduleEmployee()
        
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
    Date: 11/30/2020
  </h2>

  <h3>Edit page for the Employee Schedule</h3>

  <!-- FORM 1 -------------------------------------->

  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="frmAdd">
    <fieldset id="fieldsetAdd">
    <legend>Add employee to schedule</legend>

      <label for="txtFName">First Name:</label>
      <input type="text" name="txtFName" id="txtFName" />
      <br /><br />

      <label for="txtLName">Last Name:</label>
      <input type="text" name="txtLName" id="txtLName" />
      <br /><br />

      <input name="btnSubmit" type="submit" value="Add information" />
    </fieldset>
  </form>

  <!-- FORM 2 -------------------------------------->

  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="frmDelete">
    <fieldset id="fieldsetDelete">
    <legend>Remove an employee from schedule</legend>
      
      <label for="lstRemoveEmployee">Select employee:</label>
      <select name="lstRemoveEmployee">
        <option value="">Select</option>
        <?php 
          // loop through employee table to build the <option> list.
          $sql = "SELECT empID, CONCAT(fName,' ',lName) AS 'name'
            FROM employee
            ORDER BY fName";
          $result = $conn->query($sql);
          while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['empID'] . "'>" . $row['name'] . "</option>\n";
          }
        ?>
      </select>
      <br /><br />

      <input name="btnSubmit" type="submit" value="Remove" />
    </fieldset>
  </form>

  <!-- FORM 3 -------------------------------------->

  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="frmSchedule">
    <fieldset id="fieldsetSchedule">
    <legend>Schedule an employee shift</legend>

      <label for="lstScheduleEmployee">Select employee:</label>
      <select name="lstScheduleEmployee">
        <option value="">Select</option>
        <?php 
          // loop through employee table to build the <option> list.
          $sql = "SELECT empID, CONCAT(fName,' ',lName) AS 'name'
            FROM employee
            ORDER BY fName";
          $result = $conn->query($sql);
          while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['empID'] . "'>" . $row['name'] . "</option>\n";
          }
        ?>
      </select>
      <br /><br />

      <label for="txtDate">Enter date (mm/dd/yyyy):</label>
      <input type="text" name="txtDate" id="txtDate" />
      <br /><br />

      <label for="lstScheduleTime">Select time:</label>
      <select name="lstScheduleTime">
        <option value="">Select</option>
        <?php 
          // Loop through shift table to build the <option> list.
          $sql = "SELECT shiftID, shiftTime
            FROM shift
            ORDER BY shiftTime";
          $result = $conn->query($sql);
          while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['shiftID'] . "'>" . $row['shiftTime'] . "</option>\n";
          }
        ?>
      </select>
      <br /><br />

      <input name="btnSubmit" type="submit" value="Schedule" />
    </fieldset>
  </form>

  <!-- FORM 4 -------------------------------------->

  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="frmUnschedule">
    <fieldset id="fieldsetUnschedule">
    <legend>Unschedule and employee shift</legend>

      <label for="lstUnscheduleEmployee">Select employee:</label>
      <select name="lstUnscheduleEmployee">
        <option value="">Select</option>
        <?php 
          // loop through employee table to build the <option> list.
          $sql = "SELECT empID, CONCAT(fName,' ',lName) AS 'name'
            FROM employee
            ORDER BY fName";
          $result = $conn->query($sql);
          while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['empID'] . "'>" . $row['name'] . "</option>\n";
          }
        ?>
      </select>
      <br /><br />

      <label for="txtUnscheduleDate">Enter date (mm/dd/yyyy):</label>
      <input type="text" name="txtUnscheduleDate" id="txtDate" />
      <br /><br />

      <label for="lstUnscheduleTime">Select time:</label>
      <select name="lstUnscheduleTime">
        <option value="">Select</option>
        <?php 
          // Loop through shift table to build the <option> list.
          $sql = "SELECT shiftID, shiftTime
            FROM shift";
          $result = $conn->query($sql);
          while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['shiftID'] . "'>" . $row['shiftTime'] . "</option>\n";
          }
        ?>
      </select>
      <br /><br />

      <input name="btnSubmit" type="submit" value="Unschedule" />
    </fieldset>
  </form>

  </div>
</body>
</html>