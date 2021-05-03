<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="urf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- zoo.html - Show how to parse through a JSON object
  Joshua Sells - joshuataylorsells@gmail.com
  Written: 12/16/2020
  -->
  <title>MyZoo</title>
  <script>
    function getJSON() {
      // Find the HTML <div> to display the results
      var result = document.getElementById("result");
      // Create an AJAX request object
      var thisRequest = new XMLHttpRequest();
      thisRequest.open("GET", "zoo4.json", true);
      // Set up content header to send URL encoded variables
      // using GET as part of the request asking for JSON type text
      thisRequest.setRequestHeader("Content-type", "application/json", true);
      // Run the on ready state change event
      thisRequest.onreadystatechange = function() {
        if (thisRequest.readyState == 4 && thisRequest.status == 200) {
          // parse the response text as JSON data
          var myZoo = JSON.parse(thisRequest.responseText);
          var stringToDisplay = "";
          // Clear the result box before displaying new data
          result.innerHTML = "";

          // Append each string, forming one long string with the HTML table elements.
          stringToDisplay += "<table><thead><tr>";
          stringToDisplay += "<th>Name</th><th>Habitat</th><th>Population</th></tr></thead>";
          for (var count = 0; count < myZoo.zoo.length; count++) {
            stringToDisplay += "<tr>";
              stringToDisplay += "<td>" +myZoo.zoo[count].animal + "</td>";
              stringToDisplay += "<td>" +myZoo.zoo[count].habitat + "</td>";
              stringToDisplay += "<td>" +myZoo.zoo[count].population + "</td>";
            stringToDisplay += "</tr>";
          } // end of for
          stringToDisplay += "</table>";
          // Display the String containing the HTML table output as the text of the #result <div>.
          result.innerHTML = stringToDisplay;
        } // end of if
      } // end of function()
      thisRequest.send(null);
      result.innerHTML = "<br />Requesting data from server...";
    } // end of getJSON()
  </script>

  <!-- Add PHP function -->
  <?PHP 
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
    * - - - - - - - - - - - - - - - - - - - - - - */
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
    * - - - - - - - - - - - - - - - - - - - - - - */
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

  ?>

  <!-- Insert the CSS styles-->
  <link rel="stylesheet" type="text/css" href="zoo.css">
</head>
<body>
  <div id="frame">
    <h1>Test read/write JSON File</h1>
    <div id="result"></div>
    <!-- Repopulate with new information -->
    <script>
      // Call the AJAX request function
      getJSON();
    </script>
  </div>
</body>
</html>