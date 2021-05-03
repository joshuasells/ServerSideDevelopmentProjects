<!DOCTYPE html>
<html land="en">
<head>
<meta charset="utf-8">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
<link rel="stylesheet" contect="text/css" href="style.css">
<title>Small College</title>
</head>
<body>
  <h1>Small College JOIN Page</h1>
  <?PHP
  /* dbfCreate.php - A page to demonstrate the JOIN commands offered by SQL
  Written by Joshua Sells
  Started: 11/16/2020
  Finished: 11/16/2020
  Revised:
  */

  

  // Set up connection constants
  // Credentials for localhost
  define("SERVER_NAME", "localhost");
  define("DBF_USER_NAME", "root");
  define("DBF_PASSWORD", "mysql");
  define("DATABASE_NAME", "college");

  /*

  // Credentials for remote server
  define("SERVER_NAME", "gator4170.hostgator.com");
  define("DBF_USER_NAME", "joshulls_user");
  define("DBF_PASSWORD", "A6D1M8O7S3jts");
  define("DATABASE_NAME", "joshulls_college");

  */

  // Global connection object
  $conn = NULL;

  // Create connection
  createConnection();

  // Select the database
  $conn->select_db(DATABASE_NAME);

  /***********************************************
  ** Display the tables using JOIN commands
  ************************************************/

  // Display all data. 3 points. Because I have 6 tables and a lot of data,
  // I will just display a Join command on 3 of my tables.
  // Tables: Student, Class, and stuClass
  echo "<h2>INNER JOIN (Tables: student, stuClass, and class)</h2>";
  echo "<pre>
    SQL String used to generate the data:

    SELECT s.studentID AS 'Student ID', s.fName AS 'First Name', s.lName AS 'Last Name',
      c.classID AS 'Class ID', c.className AS 'Class Name', c.semester AS 'Semester Term'
      FROM student s
      JOIN stuClass sc
      ON s.studentID = sc.studentID
      JOIN class c
      ON sc.classID = c.classID
      ORDER BY s.lName;
    </pre>";
  $sql = "SELECT s.studentID AS 'Student ID', s.fName AS 'First Name', s.lName AS 'Last Name',
    c.classID AS 'Class ID', c.className AS 'Class Name', c.semester AS 'Semester Term'
    FROM student s
    JOIN stuClass sc
    ON s.studentID = sc.studentID
    JOIN class c
    ON sc.classID = c.classID
    ORDER BY s.lName";
  $result = $conn->query($sql);
  displayResult($result, $sql);

  // Display a LEFT OUTER JOIN. 3 points
  // Tables: instructor and class
  echo "<h2>LEFT OUTER JOIN (Tables: instructor, class)</h2>";
  echo "<pre>
    SQL String used to generate the data:
    
    SELECT i.instructorID AS 'Instructor ID', i.fName AS 'First Name', i.lName AS 'Last Name',
      c.classID AS 'Class ID', c.className AS 'Class Name', c.semester AS 'Semester Term'
      FROM instructor i
      LEFT JOIN class c
      ON i.instructorID = c.instructorID
      ORDER BY i.lName;
    </pre>";
  $sql = "SELECT i.instructorID AS 'Instructor ID', i.fName AS 'First Name', i.lName AS 'Last Name',
    c.classID AS 'Class ID', c.className AS 'Class Name', c.semester AS 'Semester Term'
    FROM instructor i
    LEFT JOIN class c
    ON i.instructorID = c.instructorID
    ORDER BY i.lName";
  $result = $conn->query($sql);
  displayResult($result, $sql);

  // Display a RIGHT OUTER JOIN. 3 points
  // Tables: class and course
  echo "<h2>RIGHT OUTER JOIN (Tables: class, course)</h2>";
  echo "<pre>
    SQL String used to generate the data:

    SELECT co.courseID AS 'Course ID', co.crsName AS 'Course Name', co.crsDescription AS 'Course Description',
      c.classID AS 'Class ID', c.instructorID AS 'Instructor ID', c.semester AS 'Semester Term'
      FROM class c
      RIGHT JOIN course co
      ON c.courseID = co.courseID
      ORDER BY co.crsName;
    </pre>";
  $sql = "SELECT co.courseID AS 'Course ID', co.crsName AS 'Course Name', co.crsDescription AS 'Course Description',
    c.classID AS 'Class ID', c.instructorID AS 'Instructor ID', c.semester AS 'Semester Term'
    FROM class c
    RIGHT JOIN course co
    ON c.courseID = co.courseID
    ORDER BY co.crsName";
  $result = $conn->query($sql);
  displayResult($result, $sql);

  echo "<h2>Explanation of JOINS</h2>";
  echo "<h3>JOIN (INNER JOIN)</h3>";
  echo "<p>
  
    An INNER JOIN is the same as a JOIN. It looks at 2 or more tables and selects records based on the defined criteria. Typically 
    you would have the script join the tables on a relationship between them, like a foriegn key/primary key relationship. The JOIN
    will only select the records that have the common criteria and nothing else. This is useful for what I did earlier when I JOINED
    the student and class tables. From that JOIN, you can see all of the student and the classes they are enrolled in.
    
  </p>";

  echo "<h3>LEFT OUTER JOIN</h3>";
  echo "<p>
  
    A LEFT OUTER JOIN does everything that a regular JOIN does but a little more. Depending on how you structure your SQL commands,
    a LEFT OUTER JOIN will return all the records of an INNER JOIN and also the rest of the records on the left table. SQL is read
    left to right so whatever table you wrote in first will be considered the left table. This operation is useful for when you not only
    want to see all the students and classes they are registered in, but you may also want to see any students that potentially are not
    registered in a class yet.
    
  </p>";

  echo "<h3>RIGHT OUTER JOIN</h3>";
  echo "<p>
  
    A RIGHT OUTER JOIN is the same thing as a LEFT OUTER JOIN but it executes the SQL command with whatever table was listed as the right
    table. In other words, it selected all the records of a regular JOIN with the rest of the records on the right table. This is useful
    for the same reason a LEFT JOIN is. It all depends on how you structure your SQL commands. You could write an SQL LEFT JOIN command
    and switch the order of tables listed. Then you could change the command from LEFT JOIN to RIGHT JOIN. This would yeild the same results
    as the initial LEFT JOIN.
    
  </p>";
  

  /* = = = = = = = = = = = = = = = = = = = 
     Functions are in alphabetical order
   = = = = = = = = = = = = = = = = = = = = */

  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
   * createConnection( ) - Create a database connection
   * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
  function createConnection( ) {
    global $conn;
    // Create connection object
    $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } 
  } // end of createConnection( )

  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  * displayResult( ) - Execute a query and display the result
  *    Parameters:  $rs -  result set to display as 2D array
  *                 $sql - SQL string used to display an error msg
  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
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

  /*****************************************************
  ** runQuery() - Execute a query and display message
  ** Parameters: $sql - SQL String to be executed.
                $msg - Text of message to display on success or error
                $echoSuccess - boolean True=Display message on success
  ***********************************************************************/
  function runQuery($sql, $msg, $echoSuccess) {
    global $conn;

    // run the query
    if($conn->query($sql) === TRUE) {
      if($echoSuccess) {
        echo $msg . " successful.<br />";
      }
    } else {
        echo "<strong>Error when: " . $msg . "</strong> using SQL: " . $sql . "<br />" . $conn->error;
      }
    } // end of runQuery()