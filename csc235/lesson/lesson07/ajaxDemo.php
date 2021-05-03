<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">

 <!-- ajaxDemo.html - Use AJAX to read JSON data
      Student Name
      Written:   Current Date 
      Revised:   
  -->
  <title>JSON Demo</title>
  <link rel="stylesheet" type="text/css" href="../../sunRun/registration.css">

<script>

/* Set up the JSON data (This goes in a separate file acting as a JSON server)
// Keep this block as a reference
[
   { "fName": "Johnny", 
     "lName": "Hayes",
     "gender":"male",
     "phone":"1234567890",
     "sponsor":"BMW"  
   },
   { 
     "fName": "Robert",
     "lName": "Fowler",
     "gender":"male",
     "phone":"2222222222", 
     "sponsor":"Nike"  
   },
   { 
     "fName": "James",
     "lName": "Clark",
     "gender":"male",
     "phone":"3333333333",
     "sponsor":"Avis"  
   }
]
   
/**/

function getJSON(){
   // Find the HTML <div> to display the results
   var result = document.getElementById("result");
   // Create an AJAX request object
   var thisRequest = new XMLHttpRequest();
   thisRequest.open("GET", "runner.json", true);
   // Set up content header to send URL encoded variables
   // using GET as part of the request asking for JSON type text
   thisRequest.setRequestHeader("Content-type", "application/json", true);
   // Run the on ready state change event
   thisRequest.onreadystatechange = function() {
     /*
         State  Description
         0      The request is not initialized
         1      The request has been set up
         2      The request has been sent
         3      The request is in process
         4      The request is complete (the most common state to check for)
         
         Status Description https://www.wikiwand.com/en/List_of_HTTP_status_codes
         200    Request fulfilled ok.
         403    Forbidden access.
         404    Page not found.
      */
      if(thisRequest.readyState == 4 && thisRequest.status == 200) {
        // parse the response text as JSON data
        var data = JSON.parse(thisRequest.responseText);
        // Clear the result box before displaying new data
        result.innerHTML = "";
        for(var index in data) {
          // Populate the result box with each name in the array
          result.innerHTML += data[index].fName
          + " " + data[index].lName 
          + " Phone: " + data[index].phone
          + "<br />";
        }
      }
   }
   thisRequest.send(null);
   // This can contain an animated gif showing that it is loading
   // http://www.ajaxload.info/
   result.innerHTML = "<img src='loading.gif' alt='loading...' /><br />Requesting data from server...";
} // end of getJSON()

</script>
</head>
<body>
<div id="frame">
   <h1>Demo AJAX-JSON</h1>
   <!-- Create a spot on the web page to hold the data -->
   <div id="result"></div>
   <script>
      // run the request function 
      //after the entire page is loaded into the DOM
      getJSON( );
   </script>
</div>
</body>
</html>