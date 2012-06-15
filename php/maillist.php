<?php
// Start Session
session_start();
$site = $_SESSION['site'];

require_once("../$site/php/connect_to_mysql.php");

$type = $_POST['type'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];

// Add address to Mailing list
if ($type == 'add')
{
	// Query string
	$query = "INSERT INTO mail (address, city, state, zip, dateAdded)
			 VALUES ('$address', '$city', '$state', '$zip', CURDATE())";
	
	$sql = mysql_query($query);
	
	if ($sql == 1)
		echo "success";
	else
		echo "duplicate";
}
// Add address to Do Not Mail list 
else if ($type == 'doNot')
{	
	// Query string
	$query = "INSERT INTO doNotMail (address, city, state, zip, dateAdded)
			 VALUES ('$address', '$city', '$state', '$zip', CURDATE())";
	
	$sql = mysql_query($query);
	
	if ($sql == 1)
		echo "success";
	else
		echo "duplicate";
}


?>