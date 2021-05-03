<?php
   /* jsonServer.php - Extract data from database and present as JSON data
    *   Written by Student Name
    *   Written:  Current Date
    *   Revised:  
    *   Ref: https://www.developphp.com/video/JavaScript/JSON-Timed-Ajax-PHP-MySQL-Data-Request-Web-Application

   */
  // The JSON standard MIME header. Output as JSON, not HTML
  header('Content-type: application/json');
   $limit = 5;
      // Set up connection constants
      // Using default username and password for AMPPS  
      define("SERVER_NAME",   "localhost");
      define("DBF_USER_NAME", "root");
      define("DBF_PASSWORD",  "mysql");
      define("DATABASE_NAME", "sunRun");
      // Global connection object
      $conn = NULL;
   
      // Connect to database
      createConnection();
      
     // Get the runner and sponsor data from the tables
     // Use the RANDOM function and the $limit variable 
     // so only four records at random are extracted.
      $sql = "SELECT runner.id_runner AS 'id',
             fName, lName, gender,
             CONCAT(SUBSTR(phone,1,3),'-',SUBSTR(phone,4,3),'-',SUBSTR(phone,7,4)) AS 'phone',
             sponsor.sponsorName
             FROM runner
             LEFT OUTER JOIN sponsor
             ON runner.id_runner = sponsor.id_runner
             ORDER BY RAND( ) LIMIT " . $limit;
      $result = $conn->query($sql);
      //displayResult($result, $sql);

    // Loop through the $result to create JSON formatted data
    $runnerArray = array();
    while ($thisRow = $result->fetch_assoc()) {
      $runnerArray[] = $thisRow;
    }
    echo json_encode($runnerArray);
   

/*************** FUNCTIONS (Alphabetical) *************************/
/* -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
 * createConnection( ) - Create a database connection
 -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - */
function createConnection( ) {
   global $conn;
   // Create connection object
   $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
   // Check connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   } 
   // Select the database
   $conn->select_db(DATABASE_NAME);
} // end of createConnection( )


/* -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
 * displayResult( ) - Execute a query and display the result
 *    Parameters:  $rs -  result set to display as 2D array
 *                 $sql - SQL string used to display an error msg
 -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  */
function displayResult($result, $sql) {
   if ($result->num_rows > 0) {
      echo "<table border='1'>\n";
      // print headings (field names)
      $heading = $result->fetch_assoc( );
      echo "<tr>\n";
      // print field names 
      foreach($heading as $key=>$value){
         echo "<th>" . $key . "</th>\n";
      }
      echo "</tr>\n";
      
      // Print values for the first row
      echo "<tr>\n";
      foreach($heading as $key=>$value){
         echo "<td>" . $value . "</td>\n";
      }
                 
       // output rest of the records
       while($row = $result->fetch_assoc()) {
           //print_r($row);
           //echo "<br />";
           echo "<tr>\n";
           // print data
           foreach($row as $key=>$value) {
              echo "<td>" . $value . "</td>\n";
           }
           echo "</tr>\n";
       }
       echo "</table>\n";
   } else {
       echo "<strong>zero results using SQL: </strong>" . $sql;
   }
} // end of displayResult( )
?>