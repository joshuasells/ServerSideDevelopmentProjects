<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <!-- showJSONData.php - Use AJAX to call the JSON Server
  Joshua Sells
  1/3/2020
-->

<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/indexStyle.css">

<script>
  var counter = 0;
  function getData() {
    // Find the HTML <div> to display the results
    var databox = document.getElementById("databox");
    // Create an AJAX request object
    var httpReq = new XMLHttpRequest();

    // Add AJAX Call
    // Request the API script using POST, calling the PHP script
    httpReq.open("GET", "getJSONData.php", true);
    // Set up content header to send URL encoded variables 
   // using GET as part of the request asking for JSON type text
    httpReq.setRequestHeader("Content-type", "application/json", true);
    // Run the on ready state change event
    httpReq.onreadystatechange = function () {
      if (httpReq.readyState == 4 && httpReq.status == 200) {
        // parse the response text as JSON data
        var dataObject = JSON.parse(httpReq.responseText);
        // Clear the data each time around
        databox.innerHTML = "";
        var strToDisplay = "";
        strToDisplay += "<table class='inventoryTable'>";
        strToDisplay += "<thead><tr><th>Item</th><th>Description</th><th>Quantity</th></tr></thead>";
        for (var index in dataObject) {
          // Populate the databox using array data returned from server
          strToDisplay += "<tr>";
          strToDisplay += "<td>" + dataObject[index].Item + "</td>";
          strToDisplay += "<td>" + dataObject[index].Description + "</td>";
          strToDisplay += "<td>" + dataObject[index].Quantity + "</td>";
          strToDisplay += "</tr>";
        } // end of for()
        strToDisplay += "</table>";
        databox.innerHTML = strToDisplay;
      } // end of if readyState
    } // end of onreadystatechange
    httpReq.send(null);

    //databox.innerHTML = "Requesting data from server... Counter is: " + counter++;
  } // end of getData()
</script>
</head>
<body>
  <div class="jsonFrame">
    <!-- Navigation -->
    <header>
      <a id="logo" href="#"><img src="graphic/logo.png" alt="logo"></a>
      <nav>
        <ul class="navLinks">
          <li><a id="backToTracker" href="index.php">Back to Tracker App</a></li>
        </ul>
      </nav>
    </header>
    <!-- End of Navigation -->
    <h1 id="jsonH1">Inventory</h1>
    <div id="databox"></div>
    <script>
      getData();
    </script>
  </div>
</body>
</html>



<!-- var counter = 0;
  function getData() {
    var databox = document.getElementById("databox");
    var httpReq = new XMLHttpRequest();

    // Add AJAX Call
    // Request the API script using POST, calling the PHP script
    httpReq.open("POST", "getJSONData.php", true);
    httpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    httpReq.onreadystatechange = function () {
      if (httpReq.readyState == 4 && httpReq.status == 200) {
        var dataObject = JSON.parse(httpReq.responseText);
        // Clear the data each time around
      databox.innerHTML = "";
      console.log(dataObject);
        // for (var index in dataObject) {
        //   if  (dataObject[index].Item) {
        //     // Populate the databox using array data returned from server
        //     databox.innerHTML += "<p>" + dataObject[index].Item + "</p>";
        //   }
        // } // end of for()
      } // end of if readyState
    } // end of onreadystatechange

    //databox.innerHTML = "Requesting data from server... Counter is: " + counter++;
    // Twiddle the CPU's thumbs for 4 seconds
    // Then, call the function.
    setTimeout("getData()", 4000); -->