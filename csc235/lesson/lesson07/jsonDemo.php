<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <!-- jsonDemo.html - Use JSON to store and display runner data
  Joshua Sells
  12/14/2020
  -->
  <title>JSON Demo</title>
  <link rel="stylesheet" type="text/css" href="../../sunRun/registration.css">

  <script>
  // * JSON Data Structure

  var  runnerData = {"runnerList":  [
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
   ]};

  /**/

  /* = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = 
 * displayRunnerData( ) - Display contents of JSON data structure
 * = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = */
function displayRunnerData( ) {
  
} // end of displayRunnerData( )


/* = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = 
 * displayRunnerTable( ) - Display contents of JSON data structure
 *   using an HTML table for improved UX
 * = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = */

function displayRunnerTable( ) {
  document.write("<table border='1'>");
  document.write("<tr><th>Name</th><th>Phone</th><th>Gender</th><th>Sponsor</th></tr>")
  for(var x=0;x<runnerData.runnerList.length;x++) {
    document.write("<tr>");
    document.write("<td>" + runnerData.runnerList[x].fName + " " + runnerData.runnerList[x].lName + "</td>");
    document.write("<td>" + runnerData.runnerList[x].phone + "</td>");
    document.write("<td>" + runnerData.runnerList[x].gender + "</td>");
    document.write("<td>" + runnerData.runnerList[x].sponsor + "</td>");
    document.write("</tr>");
  }
  document.write("</table>");
} // end of displayRunnerData( )

</script>
</head>
<body>
<div id="frame">
  <h1>JSON Data for Runner</h1>
  <script>
    document.write(runnerData.runnerList[0].fName + "<br />");
    document.write(runnerData.runnerList[1].fName + "<br />");
    document.write(runnerData.runnerList[2].fName + "<br />");
    displayRunnerTable();
  </script>
</div>
</body>
</html>