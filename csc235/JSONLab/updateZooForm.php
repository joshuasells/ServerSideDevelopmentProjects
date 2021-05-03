<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="urf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- updateZooForm.php - form used to update the zoo json file
  Joshua Sells - joshuataylorsells@gmail.com
  Written: 12/17/2020
  -->
  <title>Update My Zoo</title>

  <!-- Add PHP function -->
  <?PHP /*
    // The JSON filename
    $myJSONFile = "zoo4.json";
    // Set up a temporary array to hold the JSON data
    $zooArray = array();
    $zooArray = readJSON($myJSONFile);

    // Hard-code in a change to the first record with a time stamp
    // Later, the data from the form textboxes will be used to update this array
    date_default_timezone_set("America/Chicago");
    $zooArray['zoo'][0]['animal'] = "Candy-striped Platypus " . date("h:i:sa");

    writeJSON($zooArray, $myJSONFile);

    /* - - - - - - - - - - - - - - - - - - - - - -
    * readJSON( ) - read the JSON file
    * returns: array with JSON data
    * - - - - - - - - - - - - - - - - - - - - - - **
    function readJSON($myFile) {
      // Set up an array to hold the JSON data
      $zooArray = array();

      try {
        // get data from the JSON file
        $jsonData = file_get_contents($myFile);
        // convert it into an array
        $zooArray = json_decode($jsonData, true);
        return $zooArray;
      }
      catch (Exception $e) {
        echo "Caught exception: ", $e->getMessage(), "\n";
      }
    } // end of readJSON()

    /* - - - - - - - - - - - - - - - - - - - - - -
    * writeJSON( ) - write the JSON file
    * Parameters: $myArray - Array to be written to the file
    * $myFile - Name of the JSON file storing the data
    * - - - - - - - - - - - - - - - - - - - - - - **
    function writeJSON($myArray, $myFile) {
      // convert array to JSON formatted variable
      $jsonData = json_encode($myArray, JSON_PRETTY_PRINT);

      try {
        // write to the JSON file
        if (file_put_contents($myFile, $jsonData)) {
          echo "Zoo file updated successfully<br />";
        }
        else {
          echo "There was an error writing to the " . $myFile . " file.<br />";
        }
      }
      catch (Exception $e) {
        echo "Caught exception: ", $e->getMessage(), "\n";
      }
    } // end of writeJSON()
*/
  ?> 

  <!-- Insert the CSS styles-->
  <link rel="stylesheet" type="text/css" href="zoo.css">

  <!-- Insert the JavaScript functions -->
  <script src="updateZoo.js"></script>

  <!-- Insert in the PHP code -->
  <?php include "updateZooCode.php"; ?>
</head>
<body>
  <div id="frame">
    <h3>Update My Zoo</h3>
    <!-- Display the form -->
    <div id="theForm"></div>

    <!-- Put the table showing the JSON data here -->
    <div id="result"></div>
    
    <!-- Populate the form and the table -->
    <script>
      // Call the AJAX request function
      showForm();
      showTable();
    </script>
  </div> <!-- end of #frame -->
</body>
</html>