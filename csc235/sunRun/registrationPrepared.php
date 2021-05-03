<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
<!-- registrationPrepared.php - Register new racers - edit, delete using prepared statements
Written by: Joshua Sells (Template for code from lesson)
Written: 12/07/2020 
Revised:
-->
  <title>SunRun Registration</title>
  <link rel="stylesheet" type="text/css" href="registration.css">

<?PHP
  $whitelist = array('127.0.0.1', '::1');

  if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
    // Credentials for localhost
    define("SERVER_NAME", "localhost");
    define("DBF_USER_NAME", "root");
    define("DBF_PASSWORD", "mysql");
    define("DATABASE_NAME", "sunRun");
  } else {
      // Credentials for Hostgator
      define("SERVER_NAME", "gator4170.hostgator.com");
      define("DBF_USER_NAME", "joshulls_db");
      define("DBF_PASSWORD", "C.MLC.NpeGb4");
      define("DATABASE_NAME", "joshulls_sunRun");
  }
  // Global connection object
  $conn = NULL;

  // Link to external library file
  //echo "PATH:" . getcwd( ) . "sunRunLib.php" . "<br />";
  // Need the / because getcwd( ) does not add it at the end of the path
  require_once(getcwd( ) . "/sunRunLib.php");   
  // Connect to database
  createConnection();
  // Is this a return visit?
  if(array_key_exists('hidIsReturning',$_POST)) {
    // Get the array that was stored as a session variable
    // Used to populate the HTML textboxes using JavaScript DOM
    $thisRunner = unserialize(urldecode($_SESSION['sessionThisRunner']));

    // Did the user select a runner from the list?
    // 'new' is the value of the first item on the runner listbox 
    if(isset($_POST['lstRunner']) && !($_POST['lstRunner'] == 'new')){
      // Extract runner and sponsor information
      
      /* Original unsafe SQL - extracting runner and sponsor information
      
      $sql = "SELECT runner.id_runner, fName, lName, phone, gender, sponsorName 
        FROM runner 
        LEFT OUTER JOIN sponsor ON runner.id_runner = sponsor.id_runner 
        WHERE runner.id_runner =" . $_POST['lstRunner'];
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();

      */
      $idRunner = $_POST['lstRunner'];
      $sql = "SELECT id_runner, fName, lName, phone, gender FROM runner WHERE id_runner=?";
      // Set up a prepared statement
      if ($stmt = $conn->prepare($sql)) {
        // Pass the parameters
        $stmt->bind_param("i", $idRunner);
        if ($stmt->errno) {
          displayMessage("stmt prepare() had error.", "red");
        }
        // Execute the query
        $stmt->execute();
        if ($stmt->errno) {
          displayMessage("Could not execute prepared statement", "red");
        }
        // Optional - Download all the rows into a cache
        // When fetch() is called all the records will be downloaded
        $stmt->store_result();
        // Get number of rows
        // (only good if store_result() is used first)
        $rowCount = $stmt->num_rows;
        // Bind result variables
        // one variable for each field in the SELECT
        // This is the variable that fetch() will use to store the result
        $stmt->bind_result($idRunner, $fName, $lName, $phone, $gender);
        // Fetch the value - returns the next row in the result set
        while ($stmt->fetch()) {
          // output the result
          echo("The id is: " . $idRunner . "<br />");
          echo("The fName is: " . $fName . "<br />");
          echo("The lName is: " . $lName . "<br />");
          echo("The phone is: " . $phone . "<br />");
          echo("The gender is: " . $gender . "<br />");
          echo("Row count is: " . $rowCount . "<br />");
        }
        // Free results
        $stmt->free_result();
        // Clost the statement
        $stmt->close();
      } // end of if ($conn->prepare($sql))

      // Create an associative array mirroring the record in the HTML table
      // This will be used to populate the text boxes with the current runner info
      /*$thisRunner = [
        "id_runner" => $row['id_runner'],
        "fName" => $row['fName'],
        "lName" => $row['lName'],
        "phone" => $row['phone'],
        "gender" => $row['gender'],
        "sponsor" => $row['sponsorName']
      ]; */
      $thisRunner = [
        "id_runner" => $idRunner,
        "fName" => $fName,
        "lName" => $lName,
        "phone" => $phone,
        "gender" => $gender
      ];
      // Save array as a serialized session variable
      $_SESSION['sessionThisRunner'] = urlencode(serialize($thisRunner));

    } // end if lstRunner

    // Determine which button may have been clicked
    switch($_POST['btnSubmit']){
      // = = = = = = = = = = = = = = = = = = = 
      // DELETE  
      // = = = = = = = = = = = = = = = = = = = 
      case 'delete':
        //displayMessage("DELETE button pushed.", "green");

        //Make sure a runner has been selected.
        if($_POST["txtFName"] == "") {
          displayMessage("Please select a runner's name.", "red");
        } else {
          // Original unsafe SQL
          //$sql = "DELETE FROM runner WHERE id_runner = " . $thisRunner["id_runner"];
          //$result = $conn->query($sql);

          // $sql for prepared statement
          $sql = "DELETE FROM runner WHERE id_runner = ?";
          // Prepare
          if ($stmt = $conn->prepare($sql)) {
            // Bind the parameters
            $stmt->bind_param("i", $thisRunner['id_runner']);
            if ($stmt->errno) {
              displayMessage("stmt prepare() had error.", "red");
            }
            // Execute the query
            $stmt->execute();
            if ($stmt->errno) {
              displayMessage("Could not execute prepared statement", "red");
            }
            // Free results
            $stmt->free_result();
            // Close the statement
            $stmt->close();
          } // end if (prepare())


          // Remove any records in Table:sponsor
          // Original unsafe SQL
          //$sql = "DELETE FROM sponsor WHERE id_runner = " . $thisRunner["id_runner"];
          //$result = $conn->query($sql);

          // $sql for prepared statement
          $sql = "DELETE FROM sponsor WHERE id_runner = ?";
          // Prepare
          if ($stmt = $conn->prepare($sql)) {
            // Bind the parameters
            $stmt->bind_param("i", $thisRunner['id_runner']);
            if ($stmt->errno) {
              displayMessage("stmt prepare() had error.", "red");
            }
            // Execute the query
            $stmt->execute();
            if ($stmt->errno) {
              displayMessage("Could not execute prepared statement", "red");
            }
            // Free results
            $stmt->free_result();
            // Close the statement
            $stmt->close();
          } // end if (prepare())

          //if($result) {
          //  displayMessage($thisRunner['fName'] . " " . $thisRunner['lName'] . " deleted.", "green");
          //}
        }
        // Zero out the current selected runner
        clearThisRunner( );
        break;
      // = = = = = = = = = = = = = = = = = = = 
      // ADD NEW RUNNER 
      // = = = = = = = = = = = = = = = = = = = 
      case 'new':
        // Check for duplicate names using fName, lName, and phoneNumber
        // Original unsafe SQL
        /*$sql = "SELECT COUNT(*) AS total FROM runner 
          WHERE fName='" . $_POST['txtFName'] . "'
          AND   lName='" . $_POST['txtLName'] . "'
          AND   phone='" . unformatPhone($_POST['txtPhone']) . "'";

        $result = $conn->query($sql);
        $row=$result->fetch_assoc();
        */

        // Get the data from the POST request
        // Used to check for duplicates as well as to INSERT a new record
        $fName = $_POST['txtFName'];
        $lName = $_POST['txtLName'];
        $phone = unformatPhone($_POST['txtPhone']);
        $gender = $_POST['lstGender'];

        $sql = "SELECT fName, lName, phone FROM runner WHERE fName=? AND lName=? AND phone=?";
        // Set up a prepared statement
        if ($stmt = $conn->prepare($sql)) {
          // Pass the parameters
          echo "\$fName is: $fName<br />";
          echo "\$lName is: $lName<br />";
          echo "\$phone is: $phone<br />";
          $stmt->bind_param("sss", $fName, $lName, $phone);
          if ($stmt->errno) {
            displayMessage("stmt prepare() had error.", "red");
          }
          // Execute the query
          $stmt->execute();
          if ($stmt->errno) {
            displayMessage("Could not execute prepared statement", "red");
          }
          // Store the result
          $stmt->store_result();
          $totalCount = $stmt->num_rows;
          echo "total count variable is: " . $totalCount;
          // Free results
          $stmt->free_result();
          // Close statement
          $stmt->close();
        } // end if( prepare())
           
        // Runner already registered?
        if($totalCount > 0) {
          displayMessage("This runner is already registered.", "red");
        }  
        //No duplicates
        else { 
          // Check for empty name fields or phone 
          if ($_POST['txtFName']=="" 
            || $_POST['txtFName']==""
            || $_POST['txtPhone']=="") {
            displayMessage("Please type in a first and last name and a phone number.", "red");
          }
          // First name and last name are populated
          else {
            // Add to Table:runner
            // Original unsafe SQL
            /*$sql = "INSERT INTO runner (id_runner, fName, lName, phone, gender)
              VALUES (NULL, '" 
              . $_POST['txtFName'] ."', '" 
              . $_POST['txtLName'] ."', '"
              . unformatPhone($_POST['txtPhone']) ."', '"
              . $_POST['lstGender']."')";
            $result = $conn->query($sql);
            */

            $sql = "INSERT INTO runner (id_runner, fName, lName, phone, gender) VALUES (NULL, ?, ?, ?, ?)";
            // Set up a prepared statement
            if ($stmt = $conn->prepare($sql)) {
              // Pass the parameters
              $stmt->bind_param("ssss", $fName, $lName, $phone, $gender);
              if ($stmt->errno) {
                displayMessage("stmt prepare() has error.", "red");
              }
              // Execute the query
              $stmt->execute();
              if ($stmt->errno) {
                displayMessage("Could not execute prepared statement", "red");
              }
              // Free results
              $stmt->free_result();
              // Close the statement
              $stmt->close();
            } // end if( prepare())
                        
            // Add to Table:sponsor containing the foreign key id_runner
            // Original unsafe SQL
            /*$sql = "INSERT INTO sponsor (id_sponsor, sponsorName, id_runner) 
              VALUES (NULL,'" .$_POST['txtSponsor'] ."', 
                (SELECT id_runner 
                  FROM runner 
                  WHERE fName='" . $_POST['txtFName'] . "' 
                  AND lName='"   . $_POST['txtLName'] . "'
                )
              )";
            $result = $conn->query($sql);   
            */
            
            //  ------ INNER QUERY TO GO INSIDE OUTER QUERY JUST BELOW THIS PREPARED STATEMENT-------
            $sql = "SELECT id_runner FROM runner WHERE fName=? AND lName=?";
            // Set up a prepared statement
            if ($stmt = $conn->prepare($sql)) {
              // Pass the parameters
              $stmt->bind_param("ss", $fName, $lName);
              if ($stmt->errno) {
                displayMessage("stmt prepare() had error.", "red");
              }
              // Execute the query
              $stmt->execute();
              if ($stmt->errno) {
                displayMessage("Could not execute prepared statement", "red");
              }
              // Store the result
              $stmt->store_result();
              // Bind result variable
              $stmt->bind_result($idRunner);
              // Fetch result
              $stmt->fetch();
              // Free results
              $stmt->free_result();
              // Close the statement
              $stmt->close();
            } // end of if ($conn->prepare($sql))
            // ------------------------------ END OF INNER QUERY. STORED RESULT IN $idRunner. ----------------

            // ------------------------------ OUTER QUERY - ADD RUNNER TO SPONSOR TABLE ----------------------
            $sponsorName = $_POST['txtSponsor'];
            $sql = "INSERT INTO sponsor (id_sponsor, sponsorName, id_runner) VALUES (NULL, ?, ?)";
            // Set up a prepared statement
            if ($stmt = $conn->prepare($sql)) {
              // Pass the parameters
              $stmt->bind_param("si", $sponsorName, $idRunner);
              if ($stmt->errno) {
                displayMessage("stmt prepare() has error.", "red");
              }
              // Execute the query
              $stmt->execute();
              if ($stmt->errno) {
                displayMessage("Could not execute prepared statement", "red");
              }
              // Free results
              $stmt->free_result();
              // Close the statment
              $stmt->close();
            } // end if( prepare())
            // -------------------------------END OF OUTER QUERY ---------------------------------------------
          }
          // Zero out the current selected runner
          clearThisRunner( );
        } // end of if/else($total > 0)
        break;

      // = = = = = = = = = = = = = = = = = = = 
      // UPDATE   
      // = = = = = = = = = = = = = = = = = = = 
      case 'update':
        //displayMessage("UPDATE button pushed.", "green");
        // Check for empty name 
        if ($_POST['txtFName']=="" || $_POST['txtLName']=="") {
          displayMessage("Please select a runner's name.", "red");
        }
        // First name and last name are selected
        else {
          $isSuccessful = false;
          // Update Table:runner
/*          Original unsafe SQL:
          $sql = "UPDATE runner SET fName='" . $_POST['txtFName'] . "', "
            . " lName = '" . $_POST['txtLName'] . "', "
            . " phone = '" . unformatPhone($_POST['txtPhone']) . "', "
            . " gender = '" . $_POST['lstGender'] . "' 
            WHERE id_runner = " . $thisRunner['id_runner'];
          $result = $conn->query($sql);
*/

          // Close out existing connection
          // Create a new one for the stored procedure
          mysqli_close($conn);
          createConnection();
          // Get $_POST data
          $fName = $_POST['txtFName'];
          $lName = $_POST['txtLName'];
          $phone = unformatPhone($_POST['txtPhone']);
          $gender = $_POST['lstGender'];
          $idRunner = $thisRunner['id_runner'];
          // Set up the SQL String, calling a stored procedure
          $sql = "call runnerUpdate('" . $fName . "', '" . $lName . "', '" . $phone . "', '" . $gender . "', '" . $idRunner . "')";
          // Run the stored procedure
          $result = $conn->query($sql);
          // Close the stored procedure connection and reopen a new one
          // for other SQL calls
          mysqli_close($conn);
          createConnection();

          if($result) {
            $isSuccessful = true;
          }
          // Update Table:sponsor
          // !!!! Does not update sponsor unless an entry already exists in the table !!!!
          $sql = "UPDATE sponsor SET sponsorName='" . $_POST['txtSponsor'] . "' WHERE id_runner = " . $thisRunner['id_runner'];
          $result = $conn->query($sql);
          if(!$result) {
            $isSuccessful = false;
          }
          // If successful update the variables
          if($isSuccessful) {
            displayMessage("Update successful!", "green");
            $thisRunner['id_runner'] = $_POST['id_runner'];
            $thisRunner['fName']  = $_POST['txtFName'];
            $thisRunner['lName']  = $_POST['txtLName'];
            $thisRunner['phone']  = unformatPhone($_POST['txtPhone']);
            $thisRunner['gender'] = $_POST['lstGender'];
            $thisRunner['sponsor']= $_POST['txtSponsor'];

            // Save array as a serialized session variable
            $_SESSION['sessionThisRunner'] = urlencode(serialize($thisRunner));
          }
        }
        // Zero out the current selected runner
        clearThisRunner( );
        break;
    } // end of switch( )

  } 
  // or, a first time visitor?
  else {
    //echo '<h1>Welcome FIRST TIME</h1>';
  } // end of if new else returning
?>

</head>
<body>
  <div id="frame">
    <h1>SunRun Registration</h1>

    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
      method="POST"
      name="frmRegistration"
      id="frmRegistration">

      <label for="lstRunner"><strong>Select Runner's Name</strong></label>

      <select name="lstRunner" id="lstRunner" onChange="this.form.submit();">
        <option value="new">Select a name</option>
        <?PHP
          // Loop through the runner table to build the <option> list
          $sql = "SELECT id_runner, CONCAT(fName,' ',lName) AS 'name' 
            FROM runner ORDER BY lName";
          $result = $conn->query($sql);
          while($row = $result->fetch_assoc()) {    
            echo "<option value='" . $row['id_runner'] . "'>" . $row['name'] . "</option>\n";
          }
        ?>
      </select> 
      &nbsp;&nbsp;<a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">New</a>
      <br />
      <br />

      <fieldset>
        <legend>Runner's Information</legend>

        <div class="topLabel">
          <label for="txtFName">First Name</label>
          <input type="text" name="txtFName"   id="txtFName"   value="<?php echo $thisRunner['fName']; ?>" />

        </div>

        <div class="topLabel">
          <label for="txtLName">Last Name</label>
          <input type="text" name="txtLName"   id="txtLName"   value="<?php echo $thisRunner['lName']; ?>" />
        </div>

        <div class="topLabel">
          <label for="txtPhone">Phone</label>
          <input type="text" name="txtPhone"   id="txtPhone"   value="<?php echo formatPhone($thisRunner['phone']); ?>" />
        </div>

        <div class="topLabel">
          <label for="lstGender">Gender</label>
          <select name="lstGender" id="lstGender">
            <option value="female">Female</option>
            <option value="male">Male</option>
          </select> 
        </div>

        <div class="topLabel">
          <label for="txtSponsor">Sponsor</label>
          <input type="text" name="txtSponsor" id="txtSponsor" value="<?php echo $thisRunner['sponsor']; ?>" />
        </div>
      </fieldset>

      <br />
      <button name="btnSubmit" 
        value="delete"
        style="float:left;"
        onclick="this.form.submit();">
        Delete
      </button>

      <button name="btnSubmit"    
        value="new"  
        style="float:right;"
        onclick="this.form.submit();">
        Add New Runner Information
      </button>

      <button name="btnSubmit" 
        value="update" 
        style="float:right;"
        onclick="this.form.submit();">
        Update
      </button>
      <br />     
      <!-- Use a hidden field to tell server if return visitor -->
      <input type="hidden" name="hidIsReturning" value="true" />
    </form>
    <br /><br />
    <h2>Registered Runners</h2>
    <?PHP
      displayRunnerTable( );
      echo "<br />"; 
    ?>
    <h3>Prepared Statements</h3>
    <p>Prepared statements is when an SQL statement is sent to the database server with placeholders instead of actual variables. 
    Normally, an sql statement would be built with some user input and then sent for processing. 
    In this way, SQL injection could occur.
    Anyone could pass in the right code to get the SQL to act the way they want. 
    This is insecure and very dangerous. With prepared statements, The structure of the command is sent before the user input is given. 
    Once the user input is sent for execution, any code the user entered is just seen as characters to the database server. 
    This means that even if the user attemps to enter something in that looks like SQL syntax, the database server will interpret it as just a string of characters. 
    Because of this, SQL injection is impossible. 
    Another way prepared statement helps with security is that they check input for a specific data type. 
    This can also provide security against unwated input from the user.</p>
    <h3>Controlling User Input</h3>
    <p>Controlling user input is an important of a good user interface.
    There are php methods that can recieve input from the user, such as a comment, and parse it to display the way the programmer wants.
    htmlentities() and strip_tags() are boths methods that accomplish this goal. htmlentities() allows text to be recieved without the browser interpreting the html tags.
    This means that plain html markup will display on the page if you use this method. strip_tags() will take the user text and remove any html tags that are included.
    If you pass a parameter in, then the method will skip over those html tags and leave them in.
    This is useful is you want to let a user bold their text in a paragraph, but you don't want them getting carried away with any other html tags such as headings.
    <script>
      // Populate the drop-down box with current value
      document.getElementById("lstGender").value = "<?PHP echo $thisRunner['gender']; ?>";
    </script>
  </div>
</body>
</html>