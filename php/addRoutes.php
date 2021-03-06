<?php
require_once('connect_to_mysql.php');
require_once('reformatDate.php');

// Localize variables
$source 	  	   = $_POST['source']; // Calling script
$selectedDate 	   = $_POST['date']; // Date
$selectedDate 	   = ReformatDate($selectedDate, 'Y-m-d'); // Formated to match database
$dateBegin   	   = $_POST['dateBegin']; // Date
$dateBegin   	   = ReformatDate($dateBegin, 'Y-m-d'); // Formated to match database
$dateEnd     	   = $_POST['dateEnd']; // Date
$dateEnd     	   = ReformatDate($dateBegin, 'Y-m-d'); // Formated to match database
$route      	   = strtoupper($_POST['route']); // Scalar variable
$routes     	   = $_POST['routes']; // Array
$firstName	 	   = $_POST['firstName']; // First name
$lastName     	   = $_POST['lastName']; // Last name
$newFirst	  	   = $_POST['newFirst']; // New first name
$newLast	  	   = $_POST['newLast']; // New last name
$newName		   = $_POST['newName'];
$driver		  	   = $_POST['driver']; // Driver
$helper		  	   = $_POST['helper']; // Helper
$track		  	   = $_POST['track']; // Tracking check value
$report	      	   = $_POST['report']; // Reports check value
$admin		  	   = $_POST['admin']; // Admin check value
$uName		  	   = $_POST['uName']; // Username
$pass		  	   = $_POST['pass']; // Password
$street		  	   = $_POST['street']; // Street address
$city 		  	   = $_POST['city']; // City
$state	      	   = $_POST['state']; // State
$zip		  	   = $_POST['zip']; // Zip code
$phone		  	   = $_POST['phone'];  // Phone number
$aPhone			   = $_POST['aPhone']; // Alternate phone number
$email		  	   = $_POST['email']; // Email address
$notes		 	   = $_POST['notes']; // Notes
$donation		   = $_POST['donation']; // Donation
$location	  	   = $_POST['location']; // Location of items
$driverInstruction = $_POST['driverInstruction']; // Driver Instructions
$miss			   = $_POST['miss']; // Donor missed pick-up
$days			   = $_POST['days']; // Days between old and new dates
$card			   = $_POST['card']; // Cards
$call			   = $_POST['call']; // Calls
$cloth			   = $_POST['cloth']; // Clothing
$furn			   = $_POST['furn']; // Furniture
$misc			   = $_POST['misc']; // MISC
$stops		       = $_POST['stops']; // Number of stops
$avg			   = $_POST['avg']; // Average pounds per pickup

// Depending on the calling page, query different tables
if($source == 'scheduledRoutes')
{
	// Start xml
	$xml = "";
	// Send to XML
	header('Content-Type: application/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	echo '<query>';
	
	// String for query
	$query = "SELECT * FROM scheduledRoutes WHERE datePickup='$selectedDate'";	
	// Query
	$sql = mysql_query($query) or die(mysql_error());
	
	// Action to take on query
	while($array = mysql_fetch_array($sql))
	{
		$date     = ReformatDate($array['datePickup'], 'm/d/Y');
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
	
	if(mysql_num_rows($sql) == 0)
	{
		$xml .= "<row>";
		$xml .= "<result>No Routes</result>";
		$xml .=	"</row>";
	}
	
	// Add XML string to document
	echo $xml;
	echo '</query>';

} else if($source == 'deleteScheduledRoutes')
{
	// String for query
	$query = "DELETE FROM scheduledRoutes WHERE datePickup='$selectedDate' AND route='$route'";	
	// Query
	$sql = mysql_query($query) or die(mysql_error());

} else if($source == 'generateCR')
{
	// Start xml
	$xml = "";
	// Send to XML
	header('Content-Type: application/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	echo '<query>';
	
	// String for query
	$query = "SELECT * 
			  FROM callHistory 
			  WHERE datePickup='$selectedDate' AND route='$route'";	
	// Query
	$sql = mysql_query($query) or die(mysql_error());
	
	while($array = mysql_fetch_array($sql))
	{
		$phone = $array['primaryPhone'];
		$firstName = $array['firstName'];
		$lastName = $array['lastName'];
		$address = $array['address'];
		$city = $array['city'];
		$state = $array['state'];
		$zip = $array['zip'];
		$email = $array['email'];
		$notes = $array['notes'];
		$location = $array['location'];
		$instruction = $array['driverInstruction'];
		$dateCalled = $array['dateCalled'];
		$operator = $array['operator'];
		$callType = $array['callType'];
		$missed = $array['donorMissed'];
		$endStatus = $array['endingStatus'];
				
		// XML string
		$xml .= "<row>";
		$xml .= "<phone>$phone</phone>";
		$xml .= "<firstName>$firstName</firstName>";
		$xml .= "<lastName>$lastName</lastName>";
		$xml .= "<address>$address</address>";
		$xml .= "<city>$city</city>";
		$xml .= "<state>$state</state>";
		$xml .= "<zip>$zip</zip>";
		$xml .= "<email>$email</email>";
		$xml .= "<notes>$notes</notes>";
		$xml .= "<location>$location</location>";
		$xml .= "<instruction>$instruction</instruction>";
		$xml .= "<dateCalled>$dateCalled</dateCalled>";
		$xml .= "<operator>$operator</operator>";
		$xml .= "<callType>$callType</callType>";
		$xml .= "<missed>$missed</missed>";
		$xml .= "<endStatus>$endStatus</endStatus>";
		$xml .= "</row>";
	}
	
	if(mysql_num_rows($sql) == 0)
	{
		$xml .= "<row>";
		$xml .= "<result>No History</result>";
		$xml .=	"</row>";
	} else
	{
		// String for query
	$query = "SELECT * 
			  FROM scheduledRoutes
			  WHERE datePickup='$selectedDate' AND route='$route'";	
	// Query
	$sql = mysql_query($query) or die(mysql_error());
	
	while($array = mysql_fetch_array($sql))
	{
		$driver = $array['driver'];
		$helper = $array['helper'];
				
		// XML string
		$xml .= "<row2>";
		$xml .= "<driver>$driver</driver>";
		$xml .= "<helper>$helper</helper>";
		$xml .= "</row2>";
	}
	}
	
	// Add XML string to document
	echo $xml;
	echo '</query>';
		
} else if($source == 'addScheduledRoutes')
{
	// Start xml
	$xml = "";
	// Send to XML
	header('Content-Type: application/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	echo '<query>';
	
	/* Routes Table */
	// String for query
	$query = "SELECT * FROM routes";	
	// Query
	$sql = mysql_query($query) or die(mysql_error());
	
	// Action to take on query
	while($array = mysql_fetch_array($sql))
	{
		$route = $array['route'];
		$map   = $array['mapImage'];
		$ave   = $array['averagePounds'];
		$zip   = $array['zips'];
		$city  = ucfirst($array['city']);
		$cards  = $array['cards'];
		$last  = ReformatDate($array['lastScheduled'], 'm/d/Y');
	
		// XML string
		$xml .= "<Route>";
		$xml .= "<route>$route</route>";
		$xml .= "<map>$map</map>";
		$xml .= "<ave>$ave</ave>";
		$xml .= "<zip>$zip</zip>";
		$xml .= "<city>$city</city>";
		$xml .= "<cards>$cards</cards>";
		$xml .= "<last>$last</last>";
		$xml .= "</Route>";
	}
	
	/* Route History Table */
	// String for query
	$query = "SELECT * FROM routeHistory";	
	// Query
	$sql = mysql_query($query) or die(mysql_error());
	
	// Action to take on query
	while($array = mysql_fetch_array($sql))
	{
		$route   = $array['route'];
		$date    = $array['date'];
		$cards   = $array['cards'];
		$calls   = $array['calls'];
		$stops   = $array['stops'];
		$cloth = $array['clothing'];
		$misc    = $array['misc'];
		$notes = $array['notes'];
	}
	
	// Add XML string to document
	echo $xml;
	echo '</query>';

} else if($source == 'routeHistory')
{
	// Start xml
	$xml = "";
	// Send to XML
	header('Content-Type: application/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	echo '<query>';
	
	/* Route History Table */
	
	// String for query
	$query = "SELECT * FROM routeHistory WHERE route='$route'";	
	// Query
	$sql = mysql_query($query) or die(mysql_error());
	
	// Action to take on query
	while($array = mysql_fetch_array($sql))
	{
		$route = $array['route'];
		$date  = ReformatDate($array['date'], 'm/d/Y');
		$cards = $array['cards'];
		$calls = $array['calls'];
		$stops = $array['stops'];
		$cloth = $array['clothing'];
		$misc  = $array['misc'];
		$notes = $array['notes'];
	
		// XML string
		$xml .= "<History>";
		$xml .= "<route>$route</route>";
		$xml .= "<date>$date</date>";
		$xml .= "<cards>$cards</cards>";
		$xml .= "<calls>$calls</calls>";
		$xml .= "<stops>$stops</stops>";
		$xml .= "<cloth>$cloth</cloth>";
		$xml .= "<misc>$misc</misc>";
		$xml .= "<notes>$notes</notes>";
		$xml .= "</History>";
	}
	
	// Add XML string to document
	echo $xml;
	echo '</query>';

} else if($source == 'addToScheduled')
{
	
	// Loop to perform add for each route
	for($i = 0; $i < count($routes); $i++)
	{
		// Get data from routes table
		$query = "SELECT * FROM routes WHERE route='$routes[$i]'";	
		// Query
		$sql = mysql_query($query) or die(mysql_error());
		
		while($array = mysql_fetch_array($sql))
		{
			// Variables
			$location = ucfirst($array['city']);
			$cards = $array['cards'];
			$calls = $array['calls'];
			
			// Get current results from scheduledRoutes
			$query = "SELECT datePickup,route FROM scheduledRoutes";
			// Query
			$sql = mysql_query($query) or die(mysql_error());
			
			// Set a switch
			$switch = true;
			
			// Loop throuh results
			while($fetch = mysql_fetch_array($sql))
			{			
				// If already in database set switch to false
				if($routes[$i] == $fetch['route'] && $selectedDate == $fetch['date'])
				{
					$switch = false;
				}
			} // End scheduledRoutes fetch loop	
					
				if($switch)
				{	
					// Add route to scheduleRoutes
					$query = "INSERT INTO scheduledRoutes (datePickup, route, location, cards, calls)
							  VALUES ('$selectedDate', '$routes[$i]', '$location', '$cards', '$calls')";
							  
					// Query
					$sql = mysql_query($query) or die(mysql_error());
					
					echo 'success';
				} else
					echo 'already added';
						
		} // End get data from routes table
		
		/* Change last scheduled Date */
		$query = "UPDATE
					routes
			      SET
			  		lastScheduled='$selectedDate'
			      WHERE
			  		route='$routes[$i]'";
		
		$sql = mysql_query($query) or die(mysql_error());
	} // End loop through all routes
	
} else if($source == 'populateDrivers')
{
	// Start xml
	$xml = "";
	// Send to XML
	header('Content-Type: application/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	echo '<query>';
	
	/* Route History Table */
	
	// String for query
	$query = "SELECT * FROM drivers";	
	// Query
	$sql = mysql_query($query) or die(mysql_error());
	
	// Action to take on query
	while($array = mysql_fetch_array($sql))
	{
		$firstName = $array['firstName'];
		$lastName  = $array['lastName'];
	
		// XML string
		$xml .= "<Driver>";
		$xml .= "<first>$firstName</first>";
		$xml .= "<last>$lastName</last>";
		$xml .= "</Driver>";
	}
	
	// Add XML string to document
	echo $xml;
	echo '</query>';

} else if($source == 'deleteDriver')
{
	// String for query
	$query = "DELETE FROM drivers WHERE firstName='$firstName' AND lastName='$lastName'";	
	// Query
	$sql = mysql_query($query) or die(mysql_error());

} else if($source == 'addDriver')
{
	$count = 0;
	
	// Get names already in table
	$query = "SELECT * FROM drivers";	
	$sql = mysql_query($query) or die(mysql_error());
	
	// Check through table for name
	while($array = mysql_fetch_array($sql))
	{
		// If name is in table, increment $count
		if(strcmp($firstName, $array['firstName']) == 0 && strcmp($lastName, $array['lastName']) == 0)
		{
			$count++;
		}
	}
	
	// If not in table, add driver
	if($count == 0)
	{
		$firstName = ucfirst($firstName);
		$lastName = ucfirst($lastName);
		
		// String for query
		$query = "INSERT INTO drivers(firstName, lastName)
				  VALUES('$firstName', '$lastName')";	
		// Query
		$sql = mysql_query($query) or die(mysql_error());
		
		// Send to XML
		header('Content-Type: application/xml; charset=ISO-8859-1');
		echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
		echo '<query>';
		echo "<Driver>";
		echo "<first>$firstName</first>";
		echo "<last>$lastName</last>";
		echo "</Driver>";
		echo "</query>";
		
	// If already in table, send message
	}else
		echo 'already added';

} else if($source == 'editDriver')
{
	// Update Drivers table
	$query = "UPDATE drivers SET firstName='$newFirst', lastName='$newLast' WHERE firstName='$firstName' AND lastName='$lastName'";
	
	$sql = mysql_query($query) or die(mysql_error());
	
	$oldDriver = $firstName . " " . $lastName;
	$newDriver = $newFirst . " " . $newLast;
	
	// Update driver in scheduledRoutes table
	$query = "UPDATE scheduledRoutes SET driver='$newDriver' WHERE driver='$oldDriver'";
	
	$sql = mysql_query($query) or die(mysql_error());
	
	// Update helper in scheduledRoutes table
	$query = "UPDATE scheduledRoutes SET helper='$newDriver' WHERE helper='$oldDriver'";
	
	$sql = mysql_query($query) or die(mysql_error());

} else if($source == 'getAssignDrivers')
{
	// Start xml
	$xml = "";
	// Send to XML
	header('Content-Type: application/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	echo '<query>';
	
	// String for query
	$query = "SELECT * FROM scheduledRoutes WHERE datePickup='$selectedDate'";	
	// Query
	$sql = mysql_query($query) or die(mysql_error());
	
	// Action to take on query
	while($array = mysql_fetch_array($sql))
	{
		$date     = ReformatDate($array['datePickup'], 'm/d/Y');
		$route    = $array['route'];
		$driver   = $array['driver'];
		$helper   = $array['helper'];
		$stops	  = $array['stops'];
	
		// XML string
		$xml .= "<row>";
		$xml .= "<date>$date</date>";
		$xml .= "<route>$route</route>";
		$xml .= "<driver>$driver</driver>";
		$xml .= "<helper>$helper</helper>";
		$xml .= "<stops>$stops</stops>";
		$xml .= "</row>";
	}
	
	if(mysql_num_rows($sql) == 0)
	{
		$xml .= "<row>";
		$xml .= "<result>No Routes</result>";
		$xml .=	"</row>";
	}
	
	// Add XML string to document
	echo $xml;
	echo '</query>';

} else if ($source == 'changeDriver')
{
	$query = "UPDATE scheduledRoutes SET driver='$driver', helper='$helper' WHERE datePickup='$selectedDate' AND route='$route'";
	
	$sql = mysql_query($query) or die(mysql_error());
	
	if ($sql)
	{
		echo $selectedDate;
		echo $route;
	}
} else if($source == 'addUser')
{
	$count = 0;
	
	// Get names already in table
	$query = "SELECT * FROM users";	
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
			
		if ($route == 'true')
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
		$query = "INSERT INTO users(uName, pass, tracking, routes, reports, admin, dateChanged)
				  VALUES('$uName', '$pass', '$track', '$route', '$report', '$admin', CURDATE())";	
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
	$query = "SELECT * FROM users";	
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
		
	if (strtolower($route) == 'true')
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
				dateChanged='CURDATE' 
		      WHERE 
			  	uName='$uName'";
	
	$sql = mysql_query($query) or die(mysql_error());


} else if($source == 'deleteUser')
{
	// String for query
	$query = "DELETE FROM users WHERE uName='$uName'";	
	// Query
	$sql = mysql_query($query) or die(mysql_error());

} else if($source == 'getDoNotMail')
{
	// Start xml
	$xml = "";
	// Send to XML
	header('Content-Type: application/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	echo '<query>';
	
	/* Route History Table */
	
	// String for query
	$query = "SELECT * FROM doNotMail";	
	// Query
	$sql = mysql_query($query) or die(mysql_error());
	
	// Action to take on query
	while($array = mysql_fetch_array($sql))
	{
		$address   = $array['address'];
		$city      = $array['city'];
		$state     = $array['state'];
		$zip       = $array['zip'];
		$dateAdded = $array['dateAdded'];
		$addedBy   = $array['addedBy'];
	
		// XML string
		$xml .= "<row>";
		$xml .= "<address>$address</address>";
		$xml .= "<city>$city</city>";
		$xml .= "<state>$state</state>";
		$xml .= "<zip>$zip</zip>";
		$xml .= "<dateAdded>$dateAdded</dateAdded>";
		$xml .= "<addedBy>$addedBy</addedBy>";
		$xml .= "</row>";
	}
	
	// Add XML string to document
	echo $xml;
	echo '</query>';
} else if($source == 'getMail')
{
	// Start xml
	$xml = "";
	// Send to XML
	header('Content-Type: application/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	echo '<query>';
	
	/* Route History Table */
	
	// String for query
	$query = "SELECT * FROM mail";	
	// Query
	$sql = mysql_query($query) or die(mysql_error());
	
	// Action to take on query
	while($array = mysql_fetch_array($sql))
	{
		$address   = $array['address'];
		$city      = $array['city'];
		$state     = $array['state'];
		$zip       = $array['zip'];
		$dateAdded = $array['dateAdded'];
		$addedBy   = $array['addedBy'];
	
		// XML string
		$xml .= "<row>";
		$xml .= "<address>$address</address>";
		$xml .= "<city>$city</city>";
		$xml .= "<state>$state</state>";
		$xml .= "<zip>$zip</zip>";
		$xml .= "<dateAdded>$dateAdded</dateAdded>";
		$xml .= "<addedBy>$addedBy</addedBy>";
		$xml .= "</row>";
	}
	
	// Add XML string to document
	echo $xml;
	echo '</query>';
} else if ($source == 'getCallHistory')
{
	// Start xml
	$xml = "";
	// Send to XML
	header('Content-Type: application/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	echo '<query>';
	
	$condition = false;
	$query = "SELECT * FROM callHistory WHERE ";
	$fields = array('phone', 
					'route', 
					'firstName', 
					'lastName', 
					'street', 
					'zip', 
					'dateBegin', 
					'dateEnd');
	
	// If the field is not empty add to query				
	foreach($fields as $field)
	{
		if(isset($_POST[$field]) && !empty($_POST[$field]))
		{
			if($field == 'dateBegin' || $field == 'dateEnd')
				$clean = mysql_real_escape_string(ReformatDate($_POST[$field],'Y-m-d'));
			else
				$clean = mysql_real_escape_string($_POST[$field]);
			$query .= $field . "='$clean', ";
			$condition = true;
		}
	}
	
	// Kill last comma
	$query = rtrim($query, ', ');
		
	$sql = mysql_query($query) or die(mysql_error());
	
	// Action to take on query
	while($array = mysql_fetch_array($sql))
	{
		$primaryPhone = $array['address'];
		$firstName    = $array['city'];
		$lastName     = $array['state'];
		$address      = $array['zip'];
		$city         = $array['dateAdded'];
		$state        = $array['addedBy'];
		$zip = $array['address'];
		$email    = $array['city'];
		$notes     = $array['state'];
		$location      = $array['zip'];
		$driverInstruction         = $array['dateAdded'];
		$state        = $array['addedBy'];
	
		// XML string
		$xml .= "<row>";
		$xml .= "<address>$address</address>";
		$xml .= "<city>$city</city>";
		$xml .= "<state>$state</state>";
		$xml .= "<zip>$zip</zip>";
		$xml .= "<dateAdded>$dateAdded</dateAdded>";
		$xml .= "<addedBy>$addedBy</addedBy>";
		$xml .= "</row>";
	}
	
	// Add XML string to document
	echo $xml;
	echo '</query>';
} else if($source == 'getByPhone')
{
	// Start xml
	$xml = "";
	// Send to XML
	header('Content-Type: application/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	echo '<query>';
	
	$query = "SELECT * FROM callHistory WHERE primaryPhone='$phone'";
	
	$sql = mysql_query($query) or die(mysql_error());
	
	while($array = mysql_fetch_array($sql))
	{
		$phone             = $array['primaryPhone'];
		$fName 			   = $array['firstName'];
		$lName 			   = $array['lastName'];
		$address 		   = $array['address'];
		$city 			   = $array['city'];
		$state 		       = $array['state'];
		$zip 			   = $array['zip'];
		$email    		   = $array['email'];
		$notes             = $array['notes'];
		$location          = $array['location'];
		$driverInstruction = $array['driverInstruction'];
		$dateCalled 	   = $array['dateCalled'];
		$operator 		   = $array['operator'];
		$callType 		   = $array['confirmed'];
		$route 			   = $array['route'];
		$datePickup 	   = ReformatDate($array['datePickup'],'F j\, Y');
		$missed 		   = $array['donorMissed'];
		$endStatus 		   = $array['endingStatus'];
		
		// XML string
		$xml .= "<row>";
		$xml .= "<phone>$phone</phone>";
		$xml .= "<fName>$fName</fName>";
		$xml .= "<lName>$lName</lName>";
		$xml .= "<address>$address</address>";
		$xml .= "<city>$city</city>";
		$xml .= "<state>$state</state>";
		$xml .= "<zip>$zip</zip>";
		$xml .= "<email>$email</email>";
		$xml .= "<notes>$notes</notes>";
		$xml .= "<location>$location</location>";
		$xml .= "<driverInstruction>$driverInstruction</driverInstruction>";
		$xml .= "<dateCalled>$dateCalled</dateCalled>";
		$xml .= "<operator>$operator</operator>";
		$xml .= "<callType>$callType</callType>";
		$xml .= "<route>$route</route>";
		$xml .= "<datePickup>$datePickup</datePickup>";
		$xml .= "<missed>$missed</missed>";
		$xml .= "<endStatus>$endStatus</endStatus>";
		$xml .= "</row>";
	}
	
	// Add XML string to document
	echo $xml;
	echo '</query>';
} else if($source == 'updateCallHistory')
{
	/**** Get current phone numbers in callHistory table ****/
	$query = "SELECT primaryPhone FROM callHistory";
	
	$sql = mysql_query($query) or die(mysql_error());
	
	$counter = 0;
	while($array = mysql_fetch_array($sql))
	{
		if($phone == $array['primaryPhone'] && $selectedDate == $array['datePickup'])
			$counter++;	
	}
	
	if($counter == 0)
	{
		/**** Add new information to call history table ****/
		$query = "INSERT INTO 
					callHistory
					(primaryPhone, firstName, lastName, address,
				  	city, state, zip, email, notes, location, driverInstruction, dateCalled,
				  	operator, callType, route, datePickup, donorMissed, endingStatus)
				  VALUES 
				  	('$phone', '$firstName', '$lastName', '$street', '$city', '$state', '$zip', 
				  	'$email', '$notes', '$location', '$driverInstruction', CURDATE(), '', 
				  	'', '$route', '$selectedDate', '$miss', '')";
		
		$sql = mysql_query($query) or die(mysql_error());
		
		if($sql)
			echo 'added';
		else
			echo 'failure';
		
	} else
	{
		/**** Update call history table ****/
		$query = "UPDATE 
					callHistory
				 SET
					firstName='$firstName', 
					lastName='$lastName', 
					address='$street', 
					city='$city', 
					state='$state', 
					zip='$zip', 
					email='$email', 
					notes='$notes', 
					location='$location', 
					driverInstruction='$driverInstruction', 
					route='$route', 
					datePickup='$selectedDate', 
					donorMissed='$miss'
				WHERE 
					primaryPhone='$phone'";
					
		$sql = mysql_query($query) or die(mysql_error());
		
		if($sql)
			echo 'changed';
		else
			echo 'failure';
	}
	
	/**** Update stops for route ****/
	$query = "SELECT route, datePickup FROM callHistory WHERE route='$route'";
	
	$sql = mysql_query($query) or die(mysql_error());
	
	$counter = 0;
	while($array = mysql_fetch_array($sql))
	{
		$datePickup = ReformatDate($array['datePickup'], 'Y-m-d');
		$selectedDate = ReformatDate($selectedDate, 'Y-m-d');
		
		if($selectedDate == $datePickup &&	$route == $array['route'])
			$counter++;
	}
	
	$query = "UPDATE 
				scheduledRoutes 
			 SET
			 	stops='$counter',
				calls='$counter'
			 WHERE 
			 	route='$route'
			 AND
			 	datePickup='$selectedDate'";
				
	$sql = mysql_query($query) or die(mysql_error());
	
} else if($source == 'updateDonationHistory')
{
	echo $scheduledDate;
	
	/**** Get current phone numbers in callHistory table ****/
	$query = "SELECT * FROM donationHistory";
	
	$sql = mysql_query($query) or die(mysql_error());
	
	$counter = 0;
	while($array = mysql_fetch_array($sql))
	{
		if($street == $array['address'] && $selectedDate == $array['date'])
		{
			$counter++;	
		}
	}
	
	if($counter == 0)
	{
		/**** Add new information to donation history table ****/
		$query = "INSERT INTO 
					donationHistory
					(primaryPhone, altPhone, firstName, lastName, address,
				  	city, state, zip, email, route, date, donation)
				  VALUES 
				  	('$phone', '$aPhone', '$firstName', '$lastName', '$street', '$city', '$state', '$zip', 
				  	'$email', '$route', '$selectedDate', '$donation')";
		
		$sql = mysql_query($query) or die(mysql_error());
		
		if(!sql)
			echo 'failure';
		else
			echo 'added';
		
	} else
	{
		/**** Update donation history table ****/
		$query = "UPDATE 
					donationHistory
				 SET
				 	primaryPhone='$phone',
					altPhone='$aPhone',
					firstName='$firstName', 
					lastName='$lastName', 
					address='$street', 
					city='$city', 
					state='$state', 
					zip='$zip', 
					email='$email',
					route='$route', 
					date='$selectedDate',
					donation='$donation'
				WHERE 
					address='$street'";
					
		$sql = mysql_query($query) or die(mysql_error());
		
		if(!$sql)
			echo 'failure';
		else
			echo 'changed';
	}
} else if($source == 'updateRouteHistory')
{	 
	/**** Get current phone numbers in callHistory table ****/
	$query = "SELECT * FROM routeHistory";
	
	$sql = mysql_query($query) or die(mysql_error());
	
	$counter = 0;
	while($array = mysql_fetch_array($sql))
	{
		if($route == $array['route'] && $selectedDate == $array['date'])
		{
			$counter++;	
		}
	}
	
	if($counter == 0)
	{
		/**** Add new information to donation history table ****/
		$query = "INSERT INTO 
					routeHistory
					(route, date, cards, calls, driver, helper, clothing, misc, furniture,
					 stops, averagePerPickup, notes)
				  VALUES 
				  	('$route', '$selectedDate', '$card', '$call', '$driver', '$helper',
					 '$cloth', '$misc', '$furn', '$stops', '$avg', '$notes')";
		
		$sql = mysql_query($query) or die(mysql_error());
		
		if(!sql)
			echo 'failure';
		else
			echo 'added';
		
	} else
	{
		/**** Update donation history table ****/
		$query = "UPDATE 
					routeHistory
				 SET
				 	route='$route',
					date='$selectedDate',
					cards='$card',
					calls='$call',
					driver='$driver',
					helper='$helper',
					clothing='$cloth',
					misc='$misc',
					furniture='$furn',
					stops='$stops',
					averagePerPickup='$avg',
					notes='$notes'
				WHERE 
					route='$route'
				AND
					date='$selectedDate'";
					
		$sql = mysql_query($query) or die(mysql_error());
		
		if(!$sql)
			echo 'failure';
		else
			echo 'changed';
	}
	
	/**** Update Average for route ****/
	$query = "SELECT stops, averagePerPickup FROM routeHistory WHERE route='$route'";
	
	$sql = mysql_query($query) or die(mysql_error());
	
	$counter = $avg = 0;
	
	while($array = mysql_fetch_array($sql))
	{
		$avg += intval($array['averagePerPickup']);
		$counter++;	
	}
	
	$totalAvg = $avg / $counter;
	
	$query = "UPDATE
				routes
			  SET
			  	averagePounds='$totalAvg'
			  WHERE
			  	route='$route'";
	
	$sql = mysql_query($query) or die(mysql_error());
	
	
}
?>