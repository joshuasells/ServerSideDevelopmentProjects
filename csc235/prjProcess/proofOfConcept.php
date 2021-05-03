<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- proofOfConcept.php - This page is part of the Employee Schedule application.
  It's purpose is to write a few functions to "prove the concept" of the application -->
<!-- Author: Joshua Sells
  Written: 11/24/2020
  Revised:
-->
<title>Employee Schedule Proof Of Concept</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<?php 

  /*************************************************************
  ** Function - diplayTable() - Displays a 2D table of data.
  **
  ** Parameters: $data - Multidimensional Array holding all the employee shift data.
                 $dateArray - array of the dates to show in the table
  **************************************************************/
  function displayTable($data, $dateArray) {
    $masterArray = array();
    // Populate the masterArray array with all the names of the employees only once.
    // This is used for when I print each row of my table so that every employee's name displays once and only once.
    foreach($data as $subData) {
      if(!in_array($subData[0], $masterArray)) {
        array_push($masterArray, $subData[0]);
      }
    }
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
        foreach($data as $subData) {
          if($subData[0] == $masterArray[$x] && $subData[1] == $dateArray[$i]) {
            echo "<td>" . $subData[2] . "</td>";
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
      }
      echo "</tr>";
    }
    echo "</table>";
  } // end of displayTable()

  /*************************************************************
  ** Function - getDateRange() - Returns a string array of the 7 dates of the current week.
  **
  ** Parameters: None
  **************************************************************/
  function getDateRange() {
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
  } // end of getDateRange()

?>

</head>
<body>
  <div id="frame">
    <h1>Proof Of Concept</h1>
    <h2>
      Written by: Joshua Sells<br />
      Date: 11/24/2020  
    </h2>

    <h3>Essential tasks</h3>
      <ul>
        <li>Display a two dimensional table with employee shift data</li>
        <li>This table should be dynamic and automatically display the current week of shift data.
      </ul>
    <h3>Task: Display a two dimensional table</h3>
    <h4>Table of sample data</h4>
    <table border="1">
      <tr>
        <th>Name</th>
        <th>Date</th>
        <th>Time</th>
      </tr>
      <tr>
        <td>Shawn Johnson</td>
        <td>11/25/2020</td>
        <td>7-3</td>
      </tr>
      <tr>
        <td>Jeff Walten</td>
        <td>11/26/2020</td>
        <td>8-4</td>
      </tr>
      <tr>
        <td>Joshua Connor</td>
        <td>11/24/2020</td>
        <td>3-11</td>
      </tr>
      <tr>
        <td>Macy Jackson</td>
        <td>11/28/2020</td>
        <td>12-8</td>
      </tr>
      <tr>
        <td>Shawn Johnson</td>
        <td>11/26/2020</td>
        <td>7-3</td>
      </tr>
      <tr>
        <td>Jeff Walten</td>
        <td>11/25/2020</td>
        <td>8-4</td>
      </tr>
      <tr>
        <td>Joshua Connor</td>
        <td>11/28/2020</td>
        <td>3-11</td>
      </tr>
      <tr>
        <td>Macy Jackson</td>
        <td>11/24/2020</td>
        <td>12-8</td>
      </tr>
    </table><br /><br />
    <h4>2D Table</h4>
    <p>Keep in mind that this table is fully dynamic. It will get the current week and display all the data appropriately.</p>

    <?php 

    //Create sample data in an array
    $sampleArray = array (
      array("Shawn Johnson", "11/25/2020", "7-3"),
      array("Jeff Walten", "11/26/2020", "8-4"),
      array("Joshua Connor", "11/24/2020", "3-11"),
      array("Macy Jackson", "11/28/2020", "12-8"),
      array("Shawn Johnson", "11/26/2020", "7-3"),
      array("Jeff Walten", "11/25/2020", "8-4"),
      array("Joshua Connor", "11/28/2020", "3-11"),
      array("Macy Jackson", "11/24/2020", "12-8")
    );
    $dateArray = getDateRange();
    displayTable($sampleArray, $dateArray);
    
    ?>

  </div>
</body>
</html>