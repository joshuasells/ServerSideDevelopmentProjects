<!DOCTYPE html>
<html lang="en">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- priceEdit.php - form used to update prices for a grocery store
  Joshua Sells - joshuataylorsells@gmail.com
  Written: 1/3/2020
  -->
  <title>Grocery Store prices</title>

  <!-- JavaScript for app -->
  <script>
    var jsonFileName = "priceData.json";

    function showForm() {
      // Find the HTML <div> to display the results
      var theForm = document.getElementById("theForm");
      // Create an AJAX request object
      var thisRequest = new XMLHttpRequest();
      thisRequest.open("GET", jsonFileName, true);
      // Set up content header to send URL encoded variables
      // using GET as part of the request asking for JSON type text
      thisRequest.setRequestHeader("Content-type", "application/json", true);
      // Run the on ready state change event
      thisRequest.onreadystatechange = function () {
        if (thisRequest.readyState == 4 && thisRequest.status == 200) {
          // parse the response text as JSON data
          var myPrices = JSON.parse(thisRequest.responseText);
          var stringToDisplay = "";
          // Clear the form before displaying new data
          theForm.innerHTML = "";

          // Append each string, forming one long string with the HTLM table elements.
          stringToDisplay += "<form action='priceEdit.php' method='POST'>";
          stringToDisplay += "<table><tr>";
          stringToDisplay += "<th>Name</th><th>Location</th><th>Price</th><th>Description</th></tr>";
          for (var count = 0; count < myPrices.groceryStore.length; count++) {
            stringToDisplay += "<tr>";
              stringToDisplay += "<td><input type='text' name='txtName" + count + "' value='" + myPrices.groceryStore[count].name + "' /></td>";
              stringToDisplay += "<td><input type='text' name='txtLocation" + count + "' value='" + myPrices.groceryStore[count].location + "' /></td>";
              stringToDisplay += "<td><input type='text' name='txtPrice" + count + "' value='" + myPrices.groceryStore[count].price + "' /></td>";
              stringToDisplay += "<td><input type='text' name='txtDescription" + count + "' value='" + myPrices.groceryStore[count].description + "' /></td>";
            stringToDisplay += "</tr>";
          } // end of for loop to print table rows
          stringToDisplay += "</table><br />";
          // Add on the submit button
          stringToDisplay += "<input type='submit' value='Save' /><br /><br />";
          // Add a hidden field
          stringToDisplay += "<input type='hidden' name='hdnReturning' value'returning' />";
          stringToDisplay += "</form>";
          // Display the String containing the HTML table output as the text of the #theForm <div>.
          theForm.innerHTML = stringToDisplay;
        }
      }
      thisRequest.send(null);
      theForm.innerHTML = "<br />Requesting data from server...";
    } // end of showForm()

    function showTable() {
      // Find the HTML <div> to display the results
      var result = document.getElementById("result");
      // Create an AJAX request object
      var thisRequest = new XMLHttpRequest();
      thisRequest.open("GET", jsonFileName, true);
      // Set up content header to send URL encoded variables
      // using GET as part of the request asking for JSON type text
      thisRequest.setRequestHeader("Content-type", "application/json", true);
      // Run the on ready state change event
      thisRequest.onreadystatechange = function() {
        if (thisRequest.readyState == 4 && thisRequest.status == 200) {
          // parse the response text as JSON data
          var myPrices = JSON.parse(thisRequest.responseText);
          var stringToDisplay = "";
          // Clear the result box before displaying new data
          result.innerHTML = "";

          // Append each string, forming one long string with the HTML table elements.
          stringToDisplay += "<table><thead><tr>";
          stringToDisplay += "<th>Name</th><th>Location</th><th>Price</th><th>Description</th></tr></thead>";
          for (var count = 0; count < myPrices.groceryStore.length; count++) {
            stringToDisplay += "<tr>";
              stringToDisplay += "<td>" +myPrices.groceryStore[count].name + "</td>";
              stringToDisplay += "<td>" +myPrices.groceryStore[count].location + "</td>";
              stringToDisplay += "<td>" +myPrices.groceryStore[count].price + "</td>";
              stringToDisplay += "<td>" +myPrices.groceryStore[count].description + "</td>";
            stringToDisplay += "</tr>";
          } // end of for
          stringToDisplay += "</table>";
          // Display the String containing the HTML table output as the text of the #result <div>.
          result.innerHTML = stringToDisplay;
        } // end of if
      } // end of function()
      thisRequest.send(null);
      result.innerHTML = "<br />Requesting data from server...";
    } // end of showTable()


  </script>

  <?php 

  // Determine if this is a new or returning visitor
  // check to see if this is the first time viewing the page
  $jsonFileName = "priceData.json";

  if (array_key_exists('hdnReturning', $_POST)) {

    //echo "<h1>Welcome back!</h1>";
    // Read the JSON file
    $thisArray = readJSON($jsonFileName);

  /* // DEBUG: Show the $_POST[ ]
  echo '<pre>';
  print_r($_POST);
  echo "</pre><hr />";
  */

  /* // DEBUG: Show the jsonArray[ ]
  echo '<pre>';
  print_r($thisArray);
  echo "</pre><hr />";
  */

    // Replace the data in the array with the user input
    for ($x = 0; $x < count($thisArray['groceryStore']); $x++) {
      $thisArray['groceryStore'][$x]['name'] = $_POST['txtName' . $x];
      $thisArray['groceryStore'][$x]['location'] = $_POST['txtLocation' . $x];
      $thisArray['groceryStore'][$x]['price'] = $_POST['txtPrice' . $x];
      $thisArray['groceryStore'][$x]['description'] = $_POST['txtDescription' . $x];
    }

    // Update the JSON file
    writeJSON($thisArray, $jsonFileName);

  }

  /*************** FUNCTIONS (Alphabetical) *************************/

  /* - - - - - - - - - - - - - - - - - - - - - -
  * readJSON( ) - read the JSON file
  * returns: array with JSON data
  * - - - - - - - - - - - - - - - - - - - - - - */
  function readJSON($myFile) {
    // Set up an array to hold the JSON data
    $priceArray = array();

    try {
      // get data from the JSON file
      $jsonData = file_get_contents($myFile);
      // convert it into an array
      $priceArray = json_decode($jsonData, true);
      return $priceArray;
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
        echo "Price file updated successfully<br />";
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
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div id="frame">
    <h3>Update my Prices</h3>
    <h6>Credit for the styles are due to Peter K. Johnson</h6>
    <h6>I relied heavily on the lab provinded with week 6, but have gone through all the code using my own scenario.</h6>
    <!-- Display the form -->
    <div id="theForm"></div>

    <!-- Put the table showing the JSON data here -->
    <div id="result"></div>
    <div>
      <h4>AJAX</h4>
      <p>
        AJAX stands for <b>A</b>synchronous <b>J</b>avaScript <b>A</b>nd <b>X</b>ML
      </p>
      <p>
        AJAX is not a programming language but simply a method for retrieving data. W3 schools describes is as a
        developers dream because it allows you to communicate with the web server via not only JavaScript, but also 
        because you don't need to reload a page.
      </p>
      <p>
        I believe that websites like facebook and twitter use AJAX to retrieve more and more information from a database
        without ever reloading webpages. If your scrolling through your feed and get to the bottem, the app will load more 
        information. This is AJAX at work. I am a bit inexperienced with it at the moment, but even in my projects, I have found
        that it is a very valuable thing to know and be able to leverage in the development process.
      </p>
      <p>
        We can use a server side language such as PHP to retrieve data from a database. From here we can then use built
        in functions to encode the data as JSON data. This is a special type of type of data format that javaScript can understand
        because it literally is plain javaScript. We can then use JavaScript to get this information via AJAX and work with it however we like.
      </p>
      <p>
        Here are the listed steps:
        <ol>
          <li>Set up a PHP document that makes a connection to a database.</li>
          <li>Retrieve data using SQL and store in an array</li>
          <li>Encode this data as JSON data using the built in php function: json_encode().</li>
          <li>echo this result</li>
          <li>Set the header content type: header('content-type: application/json');</li>
          <li>From here the file will display valid JSON data from a database.</li>
        </ol>
        <ol>
          <li>Now you can use JavaScript and AJAX to access this data and use it in your app like I have done above.</li>
          <li>Wrap everything in a function to be called when you want it.</li>
          <li>Create an XMLHttpRequest();</li>
          <li>Create a function to be called when the onreadystatechange event happens.</li>
          <li>Write code to display this data however you see fit.</li>
          <li>There you have it!</li>
        </ol>
      </p>
      <p>
        
      </p>
    </div>
    
    <!-- Populate the form and the table -->
    <script>
      // Call the AJAX request function
      showForm();
      showTable();
    </script>
  </div> <!-- end of #frame -->
</body>
</html>