<?php
  // Tell the server that you will be tracking session variables
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- index.php - Keeping track of employee information for my company, MARSHALL CONCRETE PRODUCTS.
    Joshua Sells - joshuataylorsells@gmail.com
    Started: 10/31/2020
    Finished: 11/01/2020
  -->
  <link rel="stylesheet" type="text/css" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
  <title>MCP Employee tracker</title>

</head>
<body>
  <?php
    // This is here so the page will be able to always call itself.
    // By using a variable, I can change the page name and it will not break.
    $self = $_SERVER['PHP_SELF'];

    // Check to see if this is the first time viewing the page.
    // The hidSubmitFlag will not exist if this is the first time.
    if(array_key_exists("hidSubmitFlag", $_POST))
    {
      // Look at the hidden submitFlag variable to determine what to do
      $submitFlag = $_POST["hidSubmitFlag"];

      // Get the array that was stored as a session variable
      $invenArray = unserialize(urldecode($_SESSION["serializedArray"]));
      // This identifies what to do depending on the value that $submitFlag is.
      // We will either delete a record or add a record.
      switch($submitFlag)
      {
        // If the user clicked the delete button, then the record they selected will be deleted via the deleteRecord() function.
        case "99": deleteRecord();
        break;
        
        // If the user clicked the add info button, then the information they entered in the form
        // will be added as a record via the addRecord() function.
        case "01": addRecord();
        break;

        default: displayInventory($invenArray);
      }
    }
    else
    {
      // First time visitor? If so, create the array with sample data.
      $invenArray = array();
      $invenArray[0][0]="01";
      $invenArray[0][1]="Joshua";
      $invenArray[0][2]="Sells";
      $invenArray[0][3]="537";
      $invenArray[0][4]="763-807-6162";
      $invenArray[0][5]="2";

      $invenArray[1][0]="02";
      $invenArray[1][1]="Jeffrey";
      $invenArray[1][2]="Varughese";
      $invenArray[1][3]="531";
      $invenArray[1][4]="420-420-4200";
      $invenArray[1][5]="3";

      $invenArray[2][0]="03";
      $invenArray[2][1]="Kyle";
      $invenArray[2][2]="Johnson";
      $invenArray[2][3]="536";
      $invenArray[2][4]="420-420-4200";
      $invenArray[2][5]="5";

      // Save this array as a serialized session variable
      $_SESSION['serializedArray'] = urlencode(serialize($invenArray));
    }

    /* ====================================================
        Functions are alphabetical
    ====================================================  */
    function addRecord()
    {
      global $invenArray;
      // Add the new information into the array
      $invenArray[] = array($_POST["empID"],$_POST["fName"],$_POST["lName"],$_POST["truckNum"],$_POST["phoneNum"],$_POST["yrsOfSen"]);
      // The sort will be on the first column (part number) so use this to re-order the displays
      sort($invenArray);
      // Save the updated array in its session variable
      $_SESSION["serializedArray"] = urlencode(serialize($invenArray));
    }  // end of addRecord()


    function deleteRecord()
    {
      global $invenArray;
      global $deleteMe;

      // Get the selected index from the lstItem
      $deleteMe = $_POST['lstItem'];
      // Remove the selected index from the lstItem
      unset($invenArray[$deleteMe]);
      // Save the updated array in its session variable
      $_SESSION['serializedArray'] = urlencode(serialize($invenArray));
    }  // end of deleteRecord()


    function displayInventory()
    {
      global $invenArray;
      echo("<table border='1'>");

      // display the header
      echo("<tr><th>Employee ID</th><th>First Name</th><th>Last Name</th><th>Truck Number</th><th>Phone Number</th><th>Years of Senority</th<</tr>");

      // Walk through each record or row
      foreach($invenArray as $record)
      {
        echo("<tr>");
        // for each column in the row
        foreach($record as $value)
        {
          echo("<td>$value</td>");
        }
        echo("</tr>");
      }
      // stop the table
      echo("</table>");
    }  // end of displayInventory()
  ?>
  <h2>Welcome</h2>

  <img src="graphic/truck.jpg" alt="Photo of truck">

  <h1>Marshall Concrete Products Employee Tracker</h1>

  <h2>Here is Marshall's current employees:<br /></h2>
    <p><?php displayInventory(); ?></p>

  <form action="<?php $self ?>" method="POST" name="frmAdd">
    <fieldset id="fieldsetAdd">
    <legend>Add an employee</legend>

      <label for="empID">Employee ID:</label>
      <input type="text" name="empID" id="empID" size="5" />
      <br /><br />

      <label for="fName">First Name:</label>
      <input type="text" name="fName" id="fName" />
      <br /><br />

      <label for="lName">Last Name:</label>
      <input type="text" name="lName" id="lName" />
      <br /><br />

      <label for="truckNum">Truck Number:</label>
      <input type="text" name="truckNum" id="truckNum" size="5" />
      <br /><br />

      <label for="phoneNum">Phone Number:</label>
      <input type="text" name="phoneNum" id="phoneNum" />
      <br /><br />

      <label for="yrsOfSen">Years of Senority:</label>
      <input type="text" name="yrsOfSen" id="yrsOfSen" size="5" />
      <br /><br />

      <!-- This field is used to determine if the page has been viewed already
        Code 01 = Add
      -->
      <input type="hidden" name="hidSubmitFlag" id="hidSubmitFlag" value="01" />
      <input name="btnSubmit" type="submit" value="Add this information" />
    </fieldset>
  </form>

  <form action="<?php $self ?>" method="POST" name="frmDelete">
    <fieldset id="fieldsetDelete">
    <legend>Select an item to delete:</legend>
      <select name="lstItem" size="1">
      <?php
        // Populate the list box using data from the array
        foreach($invenArray as $index => $lstRecord)
        {
          // Make the value the index and the text displayed the description from the array
          
          // The index will be used by deleteRecord()
          echo "<option value='" . $index . "'>" . $lstRecord[1] . "</option>\n";
        }
      ?>
      </select>
      <!-- This field is used to determine if the page has been viewed already Code 99 = Delete -->
      <input type="hidden" name="hidSubmitFlag" id="hidSubmitFlag" value="99" />
      <br /><br />
      <input name="btnSubmit" type="submit" value="Delete" />
    </fieldset>
  </form>
</body>
</html>