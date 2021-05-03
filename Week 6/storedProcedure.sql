/* storedProcedure.sql - Stored procedures used by registration.php in the sunRun database.
 * Joshua Sells
 * Written: 12/07/2020
 * Revised: 12/08/2020
 * Original unsafe SQL: 
	$sql = "UPDATE runner SET fName='" . $_POST['txtFName'] . "', "
        . " lName = '" . $_POST['txtLName'] . "', "
        . " phone = '" . unformatPhone($_POST['txtPhone']) . "', "
        . " gender = '" . $_POST['lstGender'] . "' 
        WHERE id_runner = " . $thisRunner['id_runner'];
 */
# Change the default delimiter so you can use ; in the SQL statement
DELIMITER //
CREATE PROCEDURE runnerUpdate(IN thisFName VARCHAR(25), IN thisLName VARCHAR(25), IN thisPhone VARCHAR(25), IN thisGender VARCHAR(25), IN thisIDRunner INT)
BEGIN
 UPDATE runner SET fName= thisFName, lName = thisLName, phone = thisPhone, gender = thisGender WHERE id_runner = thisIDRunner;
END//
# Set the SProcedure delimiter back to its default
DELIMITER ;

# $_POST['txtFName'] = thisFName
# $_POST['txtLName'] = thisLName
# $_POST['txtPhone'] = thisPhone
# $_POST['lstGender'] = thisGender
# $thisRunner['id_runner'] = thisIDRunner

# need to unformatPhone() the phone number before sending into procedure.

# Output from phpmyadmin:
# CREATE DEFINER=`root`@`localhost` 
# PROCEDURE `runnerUpdateMYADMIN`(IN `thisFName` VARCHAR(25), IN `thisLName` VARCHAR(25), IN `thisPhone` VARCHAR(25), IN `thisGender` VARCHAR(25), IN `thisIDRunner` INT) 
# COMMENT 'Update a runner\'s information.' NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER 
# BEGIN 
# UPDATE runner SET fName = thisFName, lName = thisLName, phone = thisPhone, gender = thisGender WHERE id_runner = thisIDRunner; 
# END

UPDATE runner SET fName = 'Joshua', lName = 'Clark', phone = '7638076162', gender = 'Male' WHERE id_runner = 3