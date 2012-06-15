<?php
require_once('connect_to_mysql.php');
require_once('reformatDate.php');

$val = $_POST['source'];
$selectedDate = $_POST['date'];
$selectedDate = ReformatDate($selectedDate, 'Y-m-d');

// Start xml
$xml = "";
// Send to XML
header('Content-Type: application/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
echo '<query>';


// Depending on the calling page, query different tables
if($val == 'scheduledRoutes')
{
	// String for query
	$query = "SELECT * FROM scheduledRoutes WHERE date='$selectedDate'";	
	// Query
	$sql = mysql_query($query) or die(mysql_error());
	
	// Action to take on query
	while($array = mysql_fetch_array($sql))
	{
		$date     = ReformatDate($array['date'], 'm/d/Y');
		$route    = $array['route'];
		$location = $array['location'];
		$cards    = $array['cards'];
		$calls    = $array['calls'];
	
		// XML string
		$xml .= "<row>";
		$xml .= "<date>$date</date>";
		$xml .= "<route>$route</route>";
		$xml .= "<location>$location</location>";
		$xml .= "<cards>$cards</cards>";
		$xml .= "<calls>$calls</calls>";
		$xml .= "</row>";
	}
}

// Add XML string to document
echo $xml;
echo '</query>';


?>