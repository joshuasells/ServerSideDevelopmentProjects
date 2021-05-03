/* updateZoo.js - JavaScript functions for update Zoo page
Joshua Sells - joshuataylorsells@gmail.com
Written: 12/17/2020
*/

var jsonFileName = "zoo4.json";

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
      var myZoo = JSON.parse(thisRequest.responseText);
      var stringToDisplay = "";
      // Clear the form before displaying new data
      theForm.innerHTML = "";

      // Append each string, forming one long string with the HTLM table elements.
      stringToDisplay += "<form action='updateZooForm.php' method='POST'>";
      stringToDisplay += "<table><tr>";
      stringToDisplay += "<th>Name</th><th>Habitat</th><th>Population</th></tr>";
      for (var count = 0; count < myZoo.zoo.length; count++) {
        stringToDisplay += "<tr>";
          stringToDisplay += "<td><input type='text' name='txtAnimal" + count + "' value='" + myZoo.zoo[count].animal + "' /></td>";
          stringToDisplay += "<td><input type='text' name='txtHabitat" + count + "' value='" + myZoo.zoo[count].habitat + "' /></td>";
          stringToDisplay += "<td><input type='text' name='txtPopulation" + count + "' value='" + myZoo.zoo[count].population + "' /></td>";
        stringToDisplay += "</tr>";
      } // end of for loop to print table rows
      stringToDisplay += "</table><br />";
      // Add on the submit button
      stringToDisplay += "<input type='submit' value='Do it' /><br /><br />";
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
} // end of showTable()