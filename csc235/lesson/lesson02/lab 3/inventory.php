<?php
  // Tell the server that you will be tracking session variables
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- inventory.php - Keep track of inventory
    Joshua Sells - joshuataylorsells@gmail.com
    Started: 10/28/2020
    Finished: 
  -->
  <link rel="stylesheet" type="text/css" href="styles.css">
  <title>My Inventory</title>

</head>
<body>
  <?php
    // The filename of the currently executing script to be used
    // as the action=" " attribute of the form element.
    $self = $_SERVER['PHP_SELF'];

    // Check to see if this is the first time viewing the page
    // The hidSubmitFlag will not exist if this is the first time
    if(array_key_exists("hidSubmitFlag", $_POST))
    {
      // Look at the hidden submitGlag variable to determine what to do
      $submitFlag = $_POST['hidSubmitFlag'];

      // Get the array that was stored as a session variable
      $invenArray = unserialize(urldecode($_SESSION['serializedArray']));
      switch($submitFlag)
      {
        case "99": deleteRecord();
        break;
        
        case "01": addRecord();
        break;

        default: displayInventory($invenArray);
      }
    }
    else
    {
      // First time visitor? If so, create the array
      $invenArray = array();
      $invenArray[0][0]="1111";
      $invenArray[0][1]="Rose";
      $invenArray[0][2]="1.95";
      $invenArray[0][3]="100";

      $invenArray[1][0]="2222";
      $invenArray[1][1]="Dandelion Tree";
      $invenArray[1][2]="2.95";
      $invenArray[1][3]="200";

      $invenArray[2][0]="3333";
      $invenArray[2][1]="Crabgrass Bush";
      $invenArray[2][2]="3.95";
      $invenArray[2][3]="300";

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
      $invenArray[] = array($_POST["txtPartNo"],$_POST["txtDescr"],$_POST["txtPrice"],$_POST["txtQty"]);
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
      echo("<tr><th>Part No.</th><th>Description</th><th>Price</th><th>Qty</th></tr>");

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
  <h2>Welcome to the Inventory Page</h2>

  <h1>Plants You-nique</h1>

  <p>
    Here is our current inventory:<br />
    <?php displayInventory(); ?>
  </p>

  <form action="<?php $self ?>" method="POST" name="frmAdd">
    <fieldset id="fieldsetAdd">
    <legend>Add an item</legend>

      <label for="txtPartNo">Part Number:</label>
      <input type="text" name="txtPartNo" id="txtPartNo" value="999" size="5" />
      <br /><br />

      <label for="txtDescr">Description:</label>
      <input type="text" name="txtDescr" id="txtDescr" value="Test Descr" />
      <br /><br />

      <label for="txtPrice">Price: $US</label>
      <input type="text" name="txtPrice" id="txtPrice" value="123.45" />
      <br /><br />

      <label for="txtQty">Quantity in Stock:</label>
      <input type="text" name="txtQty" id="txtQty" value="123" size="5" />
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