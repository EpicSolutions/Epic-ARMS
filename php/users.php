<?php
session_start();
$site = $_SESSION['site'];
$user = $_SESSION['uName'];

require_once("connect_to_mysql.php");
require_once('reformatDate.php');

// Localize variables
$source 	  	   = $_POST['source']; // Calling script
$selectedDate 	   = $_POST['date']; // Date
$selectedDate 	   = ReformatDate($selectedDate, 'Y-m-d'); // Formated to match database
$dateBegin   	   = $_POST['dateBegin']; // Date
$routeBool 		   = $_POST['routeBool'];
$newName		   = $_POST['newName'];
$track		  	   = $_POST['track']; // Tracking check value
$report	      	   = $_POST['report']; // Reports check value
$admin		  	   = $_POST['admin']; // Admin check value
$uName		  	   = $_POST['uName']; // Username
$pass		  	   = $_POST['pass']; // Password

if($source == 'addUser')
{
	$count = 0;
	
	// Get names already in table
	$query = "SELECT * FROM users
	          WHERE site='$site'";
			  	
	$sql = mysql_query($query) or die(mysql_error());
	
	// Check through table for name
	while($array = mysql_fetch_array($sql))
	{
		// If name is in table, increment $count
		if(strcmp($uName, $array['uName']) == 0)
		{
			$count++;
		}
	}
	
	// If not in table, add driver
	if($count == 0)
	{
		// Change check values
		if ($track == 'true')
			$track = 'checked="checked"';
		else
			$track = '';
			
		if ($routeBool == 'true')
			$route = 'checked="checked"';
		else
			$route = '';
			
		if ($report == 'true')
			$report = 'checked="checked"';
		else
			$report = '';
		
		if ($admin == 'true')
			$admin = 'checked="checked"';
		else
			$admin = '';
		
		// String for query
		$query = "INSERT INTO users(uName, pass, tracking, routes, reports, admin, addedBy, dateChanged, site)
				  VALUES('$uName', '$pass', '$track', '$route', '$report', '$admin', '$user', CURDATE(), '$site')";	
		// Query
		$sql = mysql_query($query) or die(mysql_error());
		
		// Send to XML
		header('Content-Type: application/xml; charset=ISO-8859-1');
		echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
		echo '<query>';
		echo "<User>";
		echo "<uName>$uName</uName>";
		echo "<track>$track</track>";
		echo "<route>$route</route>";
		echo "<report>$report</report>";
		echo "<admin>$admin</admin>";
		echo "</User>";
		echo "</query>";
		
	// If already in table, send message
	}else
		echo 'already added';

} else if($source == 'populateUsers')
{
	// Start xml
	$xml = "";
	// Send to XML
	header('Content-Type: application/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	echo '<query>';
	
	/* Route History Table */
	
	// String for query
	$query = "SELECT * FROM users
		      WHERE site='$site'";	
	// Query
	$sql = mysql_query($query) or die(mysql_error());
	
	// Action to take on query
	while($array = mysql_fetch_array($sql))
	{
		$uName  = $array['uName'];
		$pass   = $array['pass'];
		$track  = $array['tracking'];
		$route  = $array['routes'];
		$report = $array['reports'];
		$admin  = $array['admin'];
	
		// XML string
		$xml .= "<User>";
		$xml .= "<uName>$uName</uName>";
		$xml .= "<pass>$pass</pass>";
		$xml .= "<track>$track</track>";
		$xml .= "<route>$route</route>";
		$xml .= "<report>$report</report>";
		$xml .= "<admin>$admin</admin>";
		$xml .= "</User>";
	}
	
	// Add XML string to document
	echo $xml;
	echo '</query>';

} else if($source == 'editUser')
{
	
	// Change check values
	if ($track == 'true')
		$track = 'checked="checked"';
	else
		$track = '';
		
	if (strtolower($routeBool) == 'true')
		$route = 'checked="checked"';
	else
		$route = '';
		
	if ($report == 'true')
		$report = 'checked="checked"';
	else
		$report = '';
	
	if ($admin == 'true')
		$admin = 'checked="checked"';
	else
		$admin = '';
		
		echo $uName;
	echo $track;
	echo $route;
	echo $report;
	echo $admin;
	
	// Update Drivers table
	$query = "UPDATE 
				users 
			  SET 
			  	uName='$newName',
				pass='$pass',
				tracking='$track',
				routes='$route',
				reports='$report',
				admin='$admin',
				lastChangedBy='$user',
				dateChanged=CURDATE() 
		      WHERE 
			  	uName='$uName'
			  AND
			    site='$site'";
	
	$sql = mysql_query($query) or die(mysql_error());


} else if($source == 'deleteUser')
{
	// String for query
	$query = "DELETE FROM users WHERE uName='$uName' AND site='$site'";	
	// Query
	$sql = mysql_query($query) or die(mysql_error());

}

?>