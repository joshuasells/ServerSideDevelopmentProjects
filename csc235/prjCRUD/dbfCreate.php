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
  <h1>Small College Create Page</h1>
  <?PHP
  /* dbfCreate.php - A page to demonstrate creating a small college database using SQL and PHP
  Written by Joshua Sells
  Started: 11/15/2020
  Finished: 11/15/2020
  Revised:
  */

  

  // Set up connection constants
  // Credentials for localhost
  define("SERVER_NAME", "localhost");
  define("DBF_USER_NAME", "root");
  define("DBF_PASSWORD", "mysql");
  define("DATABASE_NAME", "college");

  // NOTE: I am still having trouble using my database on the web server.
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

  // Start with a new database to start primary keys at 1
  $sql = "DROP DATABASE IF EXISTS " . DATABASE_NAME;
  runQuery($sql, "DROP " . DATABASE_NAME, false);

  // Create database if it doesn't exist
  $sql = "CREATE DATABASE IF NOT EXISTS " . DATABASE_NAME;
  runQuery($sql, "Creating " . DATABASE_NAME, false);

  // Select the database
  $conn->select_db(DATABASE_NAME);

  /*********************************
  ** Create the tables
  **********************************/
  // Create Table: student
  $sql = "CREATE TABLE IF NOT EXISTS student (
    studentID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fName VARCHAR(25) NOT NULL,
    lName VARCHAR(25) NOT NULL,
    phone VARCHAR(10),
    degreeID INT(6)
    )";
  runQuery($sql, "Table: student", false);

  // Create Table: course
  $sql = "CREATE TABLE IF NOT EXISTS course (
    courseID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    crsName VARCHAR(25) NOT NULL,
    crsDescription VARCHAR(200) NOT NULL,
    degreeID INT(6) NOT NULL
    )";
  runQuery($sql, "Table: course", false);

  // Create Table: class
  $sql = "CREATE TABLE IF NOT EXISTS class (
    classID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    className VARCHAR(25) NOT NULL,
    courseID INT(6) NOT NULL,
    instructorID INT(6) NOT NULL,
    semester VARCHAR(10) NOT NULL
    )";
  runQuery($sql, "Table: class", false);

  // Create Table: degree
  $sql = "CREATE TABLE IF NOT EXISTS degree (
    degreeID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    degreeName VARCHAR(25) NOT NULL,
    degreeDescription VARCHAR(255)
    )";
  runQuery($sql, "Table: degree", false);

  // Create Table: instructor
  $sql = "CREATE TABLE IF NOT EXISTS instructor (
    instructorID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fName VARCHAR(25) NOT NULL,
    lName VARCHAR(25) NOT NULL,
    phone VARCHAR(10)
    )";
  runQuery($sql, "Table: instructor", false);

  // Create Table: stuClass
  $sql = "CREATE TABLE IF NOT EXISTS stuClass (
    studentID INT(6) NOT NULL,
    classID INT(6) NOT NULL
    )";
  runQuery($sql, "Table: stuClass", false);

  /***********************************************
  ** Populate Tables Using Sample Data
  ************************************************/
  // Populate Table: student
  $studentArray = array(
    array("Johnny", "Hayes", "1234567890", 2),
    array("Robert", "Fowler", "2234567890", 1),
    array("James", "Clark", "3234567890", 3),
    array("Marie-Louise", "Ledru", "4234567890", 1)
  );

  foreach($studentArray as $student) {
    $sql = "INSERT INTO student (fName, lName, phone, degreeID) "
      . "VALUES ('" . $student[0] . "', '"
      . $student[1] . "', '"
      . $student[2] . "', '"
      . $student[3] . "')";
    runQuery($sql, "Record inserted for: " . $student[0], false);
  }

  // Populate Table: course
  $courseArray = array(
    array("Human Biology", "A course about the human body", 3),
    array("Intro to Java", "An introduction to the Java programming language", 2),
    array("Organizational Management", "An elective course about Business Administration", 1)
  );

  foreach($courseArray as $course) {
    $sql = "INSERT INTO course (crsName, crsDescription, degreeID) "
      . "VALUES ('" . $course[0] . "', '"
      . $course[1] . "', '"
      . $course[2] . "')";
    runQuery($sql, "Record inserted for: " . $course[0], false);
  }

  // Populate Table: class
  $classArray = array(
    array("Intro to Java", 2, 3, "Fall"),
    array("Organizational Management", 3, 2, "Summer"),
    array("Human Biology", 1, 1, "Summer"),
    array("Human Biology", 1, 5, "Spring"),
    array("Organizational Management", 3, 4, "Fall"),
    array("Intro to Java", 2, 3, "Spring")
  );

  foreach($classArray as $class) {
    $sql = "INSERT INTO class (className, courseID, instructorID, semester) "
      . "VALUES ('" . $class[0] . "', '"
      . $class[1] . "', '"
      . $class[2] . "', '"
      . $class[3] . "')";
    runQuery($sql, "Record inserted for: " . $class[0], false);
  }

  // Populate Table: degree
  $degreeArray = array(
    array("Human Resources", "The study of human resources"),
    array("Computer Science", "The study of computers"),
    array("Biology", "The study of biology")
  );

  foreach($degreeArray as $degree) {
    $sql = "INSERT INTO degree (degreeName, degreeDescription) "
      . "VALUES ('" . $degree[0] . "', '"
      . $degree[1] . "')";
    runQuery($sql, "Record inserted for: " . $degree[0], false);
  }

  // Populate Table: instructor
  $instuctorArray = array(
    array("Jerry", "Seinfield", "0987654321"),
    array("Thomas", "Aquanis", "9987654321"),
    array("Joshua", "Sells", "8987654321"),
    array("Brad", "Pit", "7987654321"),
    array("Josh", "Brolin", "6987654321")
  );

  foreach($instuctorArray as $instructor) {
    $sql = "INSERT INTO instructor (fName, lName, phone) "
      . "VALUE ('" . $instructor[0] . "', '"
      . $instructor[1] . "', '"
      . $instructor[2] . "')";
    runQuery($sql, "Record inserted for: " . $instructor[0], false);
  }

  // Populate Table: stuClass
  // Enroll each student from the sample array in the class "Intro to Java"
  foreach($studentArray as $student) {
    buildStuClass($student[0], $student[1], "Intro to Java");
  }

  // Add in an extra instructor who isn't teaching a class yet.
  $sql = "INSERT INTO instructor (fName, lName, phone) 
    VALUES ('Barry', 'Johnson', '4736876537')";
  runQuery($sql, "Record inserted for: Barry", false);

  // Add in an extra course that doesn't have a current class yet.
  $sql = "INSERT INTO course (crsName, crsDescription, degreeID)
    VALUES ('Server Side Developement', 'A really cool class!', 2)";
  runQuery($sql, "Record inserted for: Server Side Developement", false);

  /***********************************************
  ** Display the tables
  ************************************************/
  // Table: student
  echo "<h2>Student Table</h2>";
  $sql = "SELECT * FROM student";
  $result = $conn->query($sql);
  displayResult($result, $sql);
  echo "<br />";

  // Table: course
  echo "<h2>Course Table</h2>";
  $sql = "SELECT * FROM course";
  $result = $conn->query($sql);
  displayResult($result, $sql);
  echo "<br />";

  // Table: class
  echo "<h2>Class Table</h2>";
  $sql = "SELECT * FROM class";
  $result = $conn->query($sql);
  displayResult($result, $sql);
  echo "<br />";

  // Table: degree
  echo "<h2>Degree Table</h2>";
  $sql = "SELECT * FROM degree";
  $result = $conn->query($sql);
  displayResult($result, $sql);
  echo "<br />";

  // Table: instructor
  echo "<h2>Instructor Table</h2>";
  $sql = "SELECT * FROM instructor";
  $result = $conn->query($sql);
  displayResult($result, $sql);
  echo "<br />";

  // Table: stuClass
  echo "<h2>Student Class Table</h2>";
  $sql = "SELECT * FROM stuClass";
  $result = $conn->query($sql);
  displayResult($result, $sql);
  echo "<br />";

  // Close the database
  $conn->close();

  /* = = = = = = = = = = = = = = = = = = = 
     Functions are in alphabetical order
   = = = = = = = = = = = = = = = = = = = = */

  /*************************************************************
  ** buildstuClass() - Register a student for a class.
  **
  ** Parameters: $fName - student's first name
                $lName - student's last name
                $thisClass - register this student to this class
  **************************************************************/
  function buildStuClass($fName, $lName, $thisClass) {
    global $conn;
    // Populate Table: stuClass
    // Determine studentID
    $sql = "SELECT studentID FROM student WHERE fName='" . $fName . "' AND lName='" . $lName . "'";
    $result = $conn->query($sql);
    $record = $result->fetch_assoc();
    $studentID = $record['studentID'];

    // Determine classID
    $sql = "SELECT classID FROM class WHERE className='" . $thisClass . "'";
    $result = $conn->query($sql);
    $record = $result->fetch_assoc();
    $classID = $record['classID'];

    // Check to make sure student hasn't already registered for this class
    $sql = "SELECT classID FROM stuClass WHERE classID = " . $classID
      . " AND studentID = " . $studentID;
    if ($result = $conn->query($sql)) {
    // determine number of rows result set
    $rowCount = $result->num_rows;
    if($rowCount > 0) {
      echo "Student " . $studentID
      . " has already registered for class "
      . $classID . "<br />";
    } else { // Not a duplicate
        $sql = "INSERT INTO stuClass (studentID, classID)
          VALUES (" . $studentID . ", " . $classID . ")";
        runQuery($sql, "Insert student " . $studentID . " and class " . $classID, false);
    }
    }
  } // end of buildStuClass()

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