<?php
// Session start
session_start();
$site = $_SESSION['site'];

require_once("../$site/php/connect_to_mysql.php");
require_once('reformatDate.php');

$key = mysql_real_escape_string($_POST['key']);
$field = mysql_real_escape_string($_POST['field']);
$method = mysql_real_escape_string($_POST['method']);

// Parse date
if ($field == 'datePickup') {
	$key = ReformatDate($key, 'Y-m-d');	
}

// Start xml
$xml = "";
// Send to XML
header('Content-Type: application/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
echo '<query>';

// Search all fields
if($field == 'all') {
	
	$date = ReformatDate($key, 'Y-m-d');
	
	// Contains
	if($method == 'contains') {
			
			if ($first == '' && $last == '') {
				$first = 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
				$last =  'ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ';
			}
					
		$query = "SELECT 
					* FROM callHistory 
				  WHERE 
					(firstName LIKE '%"    . $first . "%'
				  AND
					lastName LIKE '%"      . $last  . "%')
				  OR
				     firstName LIKE '%"    . $key   . "%'
				  OR
				     lastName LIKE '%"     . $key   . "%'
			      OR
				     primaryPhone LIKE '%" . $key   . "%'	 
			      OR
				     route LIKE '%"        . $key   . "%'
				  OR
				     city LIKE '%"         . $key   . "%'
				  OR
				     zip LIKE '%"          . $key   . "%'
				  OR
				     datePickup LIKE '%"   . $date   . "%'
				  ORDER BY
					lastName";
	}
	// Exact
	else {
		
		$query = "SELECT 
					* FROM callHistory 
				  WHERE 
					(firstName='$first'
				  AND
					lastName='$last')
				  OR
				     firstName='$key'
				  OR
				     lastName='$key'
			      OR
				     primaryPhone='$key'	 
			      OR
				     route='$key'
				  OR
				     city='$key'
				  OR
				     zip='$key'
				  OR
				     datePickup='$date'
				  ORDER BY
					lastName";
	}

}
// If the field is name, then search by first and last name
else if($field == 'fullName') {

	$key = explode(' ', $key);
	$first = $key[0];
	$last = $key[1];	
	
	// Contains
	if($method == 'contains') {
			
		$query = "SELECT 
					* FROM callHistory 
				  WHERE 
					firstName LIKE '%" . $first . "%'
				  AND
					lastName LIKE '%" . $last . "%'
				  ORDER BY
					lastName";
	}
	// Exact
	else {
		$query = "SELECT 
					* FROM callHistory 
				  WHERE 
					firstName='$first'
				  AND
					lastName LIKE '$last'
				  ORDER BY
					lastName";
	}
			
}
// search by field
else {
	
	// Format date
	if($field == 'date')
		$key = FormatDate($key, 'Y-m-d');
		
	// Contains
	if($method	== 'contains') {
		
		$query = "SELECT 
					* FROM callHistory 
				  WHERE 
					" . $field . " LIKE '%" . $key . "%'
				  ORDER BY
					lastName";	
	}
	// Exact
	else {
	
		$query = "SELECT 
				* FROM callHistory 
			  WHERE 
				$field='$key'
			  ORDER BY
				lastName";
	}
}

// Perform query
$sql = mysql_query($query) or die(mysql_error());

// Success	
if(mysql_num_rows($sql) != 0) {

	$end_result = '';
	
	while($row = mysql_fetch_array($sql)) {
	
		// Get results
		$phone 			   = $row['primaryPhone'];
		$name 			   = $row['firstName'] . ' ' . $row['lastName'];
		$address		   = $row['address'];
		$city 			   = $row['city'];
		$state			   = $row['state'];
		$zip 			   = $row['zip'];
		$email 			   = $row['email'];
		$notes 			   = $row['notes'];
		$location          = $row['location'];
		$driverInstruction = $row['driverInstruction'];
		$dateCalled 	   = $row['dateCalled'];
		$operator 		   = $row['operator'];
		$type 			   = $row['callType'];
		$route 			   = $row['route'];
		$datePickup 	   = ReformatDate($row['datePickup'], 'n/j/Y');
		$missed 		   = $row['donorMissed'];
		$status 		   = $row['endingStatus'];
		
	
		// XML string
		$xml .= "<row>";
		$xml .= 	"<phone>$phone</phone>";
		$xml .= 	"<name>$name</name>";
		$xml .= 	"<address>$address</address>";
		$xml .= 	"<city>$city</city>";
		$xml .= 	"<state>$state</state>";
		$xml .= 	"<zip>$zip</zip>";
		$xml .= 	"<email>$email</email>";
		$xml .= 	"<notes>$notes</notes>";
		$xml .= 	"<location>$location</location>";
		$xml .= 	"<driverInstruction>$driverInstruction</driverInstruction>";
		$xml .= 	"<dateCalled>$dateCalled</dateCalled>";
		$xml .= 	"<operator>$operator</operator>";
		$xml .= 	"<type>$type</type>";
		$xml .= 	"<route>$route</route>";
		$xml .= 	"<date>$datePickup</date>";
		$xml .= 	"<missed>$missed</missed>";
		$xml .= 	"<status>$status</status>";
		$xml .= "</row>";
	}
}
// No results
else {
	$xml .= '<row>';
	$xml .= '<result>No Results</result>';
	$xml .= '</row>';	
}

// Add XML string to document
echo $xml;
echo '</query>';
	

?>