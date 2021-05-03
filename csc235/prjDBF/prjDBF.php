<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--prjDBF.php - Display data from a database
    Joshua Sells
    Written: 11/06/2020
  -->
  <title>Marshall Database</title>
  <!-- link to css -->
  <link rel="stylesheet" type="text/css" href="style.css">

  <?php

    /*

    // set up constants for credentials to localhost server
    define("DB_NAME", "marshall");
    define("DB_USER", "root");
    define("DB_PASSWORD", "mysql");
    define("DB_SERVER", "localhost");

    */

    // set up constants for credentials to remote server
    define("DB_NAME", "joshulls_lauren");
    define("DB_USER", "joshulls_user");
    define("DB_PASSWORD", "A6D1M8O7S3jts");
    define("DB_SERVER", "localhost");

    

    // set up constants for each table format
    define("DRIVER", "0");
    define("MECHANIC", "1");
    define("OFFICE_WORKER", "2");
    define("CUSTOMER_INVOICE", "3");
    define("TRUCK_JOB", "4");
    $tableFormat = DRIVER;  // this is going to be the default table shown when the page is loaded for the first time
    $sql = "SELECT e.emp_id, fName, lName, address, z.city, z.state, z.zipCode, ssn, truck_id
            FROM marshall.employee e
            JOIN marshall.zip z
            ON e.zipCode = z.zipCode
            JOIN marshall.driver d
            ON e.emp_id = d.emp_id";  // sql command to extract data

    // check to see if it is a returning user. 
    // this means that the user has selected data to be viewed on the page
    // we need to check to see what they checked and then set up a switch statement to handle this
    if(array_key_exists("hidIsReturning", $_POST)) {
      // capture the selected option the user submitted in the variable $selection
      $selection = $_POST["lstDisplay"];
      
      // set up a switch statement to deal with the user input
      // for each case, we update the variables $tableFormat and $sql
      switch($selection) {
        case "driver": {
          $tableFormat = DRIVER;
          $sql = "SELECT e.emp_id, fName, lName, address, z.city, z.state, z.zipCode, ssn, truck_id
                  FROM marshall.employee e
                  JOIN marshall.zip z
                  ON e.zipCode = z.zipCode
                  JOIN marshall.driver d
                  ON e.emp_id = d.emp_id";
          break;
        }

        case "mechanic": {
          $tableFormat = MECHANIC;
          $sql = "SELECT e.emp_id, fName, lName, address, z.city, z.state, z.zipCode, ssn
                  FROM marshall.employee e
                  JOIN marshall.zip z
                  ON e.zipCode = z.zipCode
                  JOIN marshall.mechanic m
                  ON e.emp_id = m.emp_id";
          break;
        }

        case "offWorker": {
          $tableFormat = OFFICE_WORKER;
          $sql = "SELECT e.emp_id, fName, lName, address, z.city, z.state, z.zipCode, ssn
                  FROM marshall.employee e
                  JOIN marshall.zip z
                  ON e.zipCode = z.zipCode
                  JOIN marshall.officeWorker o
                  ON e.emp_id = o.emp_id";
          break;
        }

        case "custInvoice": {
          $tableFormat = CUSTOMER_INVOICE;
          $sql = "SELECT c.cust_id, c.fName, c.lName, comName, i.inv_id, 
                    officeEmp_id, driverEmp_id, invDate, address, z.city, z.state, z.zipCode
                  FROM marshall.customer c
                  JOIN marshall.invoice i
                  ON c.cust_id = i.cust_id
                  JOIN marshall.zip z
                  ON i.zipCode = z.zipCode";
          break;
        }

        case "tckJob": {
          $tableFormat = TRUCK_JOB;
          $sql = "SELECT job_id, m.emp_id, e.fName, e.lName, j.truck_id, maxCap, tckLength, dateWorkedOn, problem, solved
                  FROM marshall.employee e
                  JOIN marshall.mechanic m
                  ON e.emp_id = m.emp_id
                  JOIN marshall.job j
                  ON j.emp_id = m.emp_id
                  JOIN marshall.truck t
                  ON t.truck_id = j.truck_id";
          break;
        }
        default: {
          echo($selection . "is not a valid choice from the list of displays<br />");
        }
      }
    }

    /* --------------  functions  ----------------- */
    function displayData() {
      // call global variables
      global $tableFormat;
      global $sql;

      // create a new database object
      // PARAMETERS: server, user, password, datbase name.
      $db = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

      if ($db->connect_error) {
        die('There was an error connecting to the database (' . $db->connect_errno . ') ');
      }

      // Get the data from the database
      $result = $db->query($sql);
      // check to make sure the query was successful
      if(!$result) {
        die("There was an error running the query (" . $db->error . ") ");
      }

      // set up a switch statement to determine how to display the data from the query
      // this switch statment first print the layout of the tables headers
      // after that it uses a while loop to print each row of data
      switch($tableFormat) {
        case DRIVER: {
          echo("<h2>Drivers</h2>");
          echo("<table>");
          echo("<tr>");
          echo("<th>Employee ID</th>");
          echo("<th>Name</th>");
          echo("<th>Address</th>");
          echo("<th>City</th>");
          echo("<th>State</th>");
          echo("<th>Zip</th>");
          echo("<th>Truck Number</th>");
          echo("</tr>");

          while($row = $result->fetch_assoc()) {
            echo("<tr>");
            echo("<td>" . $row["emp_id"] . "</td>");
            echo("<td>" . $row["fName"] . " " . $row["lName"] . "</td>");
            echo("<td>" . $row["address"] . "</td>");
            echo("<td>" . $row["city"] . "</td>");
            echo("<td>" . $row["state"] . "</td>");
            echo("<td>" . $row["zipCode"] . "</td>");
            echo("<td>" . $row["truck_id"] . "</td>");
            echo("</tr>");
          }

          echo("</table>");
          break;
        }

        case MECHANIC: {
          echo("<h2>Mechanics</h2>");
          echo("<table>");
          echo("<tr>");
          echo("<th>Employee ID</th>");
          echo("<th>Name</th>");
          echo("<th>Address</th>");
          echo("<th>City</th>");
          echo("<th>State</th>");
          echo("<th>Zip</th>");
          echo("</tr>");

          while($row = $result->fetch_assoc()) {
            echo("<tr>");
            echo("<td>" . $row["emp_id"] . "</td>");
            echo("<td>" . $row["fName"] . " " . $row["lName"] . "</td>");
            echo("<td>" . $row["address"] . "</td>");
            echo("<td>" . $row["city"] . "</td>");
            echo("<td>" . $row["state"] . "</td>");
            echo("<td>" . $row["zipCode"] . "</td>");
            echo("</tr>");
          }

          echo("</table>");
          break;
        }

        case OFFICE_WORKER: {
          echo("<h2>Office Workers</h2>");
          echo("<table>");
          echo("<tr>");
          echo("<th>Employee ID</th>");
          echo("<th>Name</th>");
          echo("<th>Address</th>");
          echo("<th>City</th>");
          echo("<th>State</th>");
          echo("<th>Zip</th>");
          echo("</tr>");

          while($row = $result->fetch_assoc()) {
            echo("<tr>");
            echo("<td>" . $row["emp_id"] . "</td>");
            echo("<td>" . $row["fName"] . " " . $row["lName"] . "</td>");
            echo("<td>" . $row["address"] . "</td>");
            echo("<td>" . $row["city"] . "</td>");
            echo("<td>" . $row["state"] . "</td>");
            echo("<td>" . $row["zipCode"] . "</td>");
            echo("</tr>");
          }

          echo("</table>");
          break;
        }

        case CUSTOMER_INVOICE: {
          echo("<h2>Customers & Invoices</h2>");
          echo("<table>");
          echo("<tr>");
          echo("<th>Customer ID</th>");
          echo("<th>Name</th>");
          echo("<th>Company Name</th>");
          echo("<th>Invoice ID</th>");
          echo("<th>Office Employee ID</th>");
          echo("<th>Driver ID</th>");
          echo("<th>Invoice Date</th>");
          echo("<th>Address</th>");
          echo("<th>City</th>");
          echo("<th>State</th>");
          echo("<th>Zip</th>");
          echo("</tr>");

          while($row = $result->fetch_assoc()) {
            echo("<tr>");
            echo("<td>" . $row["cust_id"] . "</td>");
            echo("<td>" . $row["fName"] . " " . $row["lName"] . "</td>");
            echo("<td>" . $row["comName"] . "</td>");
            echo("<td>" . $row["inv_id"] . "</td>");
            echo("<td>" . $row["officeEmp_id"] . "</td>");
            echo("<td>" . $row["driverEmp_id"] . "</td>");
            echo("<td>" . $row["invDate"] . "</td>");
            echo("<td>" . $row["address"] . "</td>");
            echo("<td>" . $row["city"] . "</td>");
            echo("<td>" . $row["state"] . "</td>");
            echo("<td>" . $row["zipCode"] . "</td>");
            echo("</tr>");
          }

          echo("</table>");
          break;
        }

        case TRUCK_JOB: {
          echo("<h2>Truck Jobs</h2>");
          echo("<table>");
          echo("<tr>");
          echo("<th>Job ID</th>");
          echo("<th>Mechanic ID</th>");
          echo("<th>Name</th>");
          echo("<th>Truck ID</th>");
          echo("<th>Maximum Carrying Capacity</th>");
          echo("<th>Truck Length</th>");
          echo("<th>Date Worked On</th>");
          echo("<th>Problem</th>");
          echo("<th>Solved?</th>");
          echo("</tr>");

          while($row = $result->fetch_assoc()) {
            echo("<tr>");
            echo("<td>" . $row["job_id"] . "</td>");
            echo("<td>" . $row["emp_id"] . "</td>");
            echo("<td>" . $row["fName"] . " " . $row["lName"] . "</td>");
            echo("<td>" . $row["truck_id"] . "</td>");
            // create a variable so I can add the unit of measurment to the data from the database
            $yardCapacity = $row['maxCap'] . ' yards';
            echo("<td>" . $yardCapacity . "</td>");
            // create a variable so I can add the unit of measurment to the data from the database
            $truckLength = $row['tckLength'] . ' feet';
            echo("<td>" . $truckLength . "</td>");
            echo("<td>" . $row["dateWorkedOn"] . "</td>");
            echo("<td>" . $row["problem"] . "</td>");
            // set up if statement to assign the boolean value from the database to a readable string for the user
            if($row["solved"]) {
              $solvedProblem = "Yes";
            }
            else {
              $solvedProblem = "No";
            }
            echo("<td>" . $solvedProblem . "</td>");
            echo("</tr>");
          }

          echo("</table>");
          break;
        }

        default: {
          echo($tableFormat . " is not a valid table format.<br />");
        }
      }

      // display total results from table
      echo("<br />Total Results: " . $result->num_rows);

      // close the database object when all finished
      $db->close;
    } // end of displayData()


  ?>

</head>
<body>
  <!-- container for style with css -->
  <div id="frame">
    <!-- title of page -->
    <h1>Marshall Database</h1>

    <!-- create a form that will always call itself. -->
    <form name="frmDBF" action="<?php echo(htmlentities($_SERVER['PHP_SELF'])); ?>" method="POST">
      <!-- prompt the user to select the information they want to see -->
      <p><strong>What information do you want to see?</strong></p>
      <!-- use JavaScript to submit the form when user selects an option -->
      <select name="lstDisplay" onchange="this.form.submit()">
        <!-- list of options for displaying information -->
        <option value="null">Select and item</option>
        <option value="driver">Drivers</option>
        <option value="mechanic">Mechanics</option>
        <option value="offWorker">Office Workers</option>
        <option value="custInvoice">Customers and Invoices</option>
        <option value="tckJob">Truck Jobs</option>
      </select>

      <!-- set up buttom for when JavaScript is disabled -->
      <noscript>
        <input type="submit" name="btnSubmit" value="Submit" />
        <br /><br />
      </noscript>

      <!-- set up a hidden field to let the server know whether it is a first time user or returning user -->
      <input type="hidden" name="hidIsReturning" value="true" />
    </form>
    <?php
      displayData();
    ?>
  </div>
</body>
</html>
