<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- displayPostGetData.php - HTML test form
    Joshua Sells
    Written: 10/27/2020
    -->
    <title>Feedback to User</title>
    <link rel="stylesheet" type="text/css" href="displayData.css">
</head>
<body>
    <div id="frame">

    <?php
        echo "<h1>This page was created by displayPostGetData.php</h1>";
        echo "Contents of the \$_POST[ ] array:<br /><pre>";
        echo print_r($_POST);
        echo "</pre>";

        echo "Content of the \$_GET[ ] array:<br /><pre>";
        echo print_r($_GET);
        echo "</pre>";

        // Extract the values from the associative array
        if(isset($_POST["txtName"])) {
            $txtName = $_POST["txtName"];
        }

        if(isset($_POST["txtEmail"])) {
            $txtEmail = $_POST["txtEmail"];
        }

        if(isset($_POST["txtContact"])) {
            $txtContact = $_POST["txtContact"];
        }

        // Display the information
        if( $txtName || $txtEmail || $txtContact)
        {
            echo "<p>";
            echo "Welcome: ". $txtName. "<br />";
            echo "Your Email is: ". $txtEmail. "<br />";
            echo "Your Mobile No. is: ". $txtContact;
            echo "</p>";
        }

        // Extract the GET variables
        if($_GET["serverID"] || $_GET["requestedBy"])
        {
            echo "<p>";
            echo "This data was input from: " . $_GET["requestedBy"] .
                " using server #" . $_GET["serverID"];
            echo "</p>";
        }

    ?>

    </div>
</body>
</html>