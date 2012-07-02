<?php
/*****************************************************************************************
*	Header information
*****************************************************************************************/
// Connect to database
require_once("arc/php/connect_to_mysql.php");

/*****************************************************************************************
*	Retrieve data from Accutracking
*****************************************************************************************/
$format = $_POST['format'];			// Format. I don't know what this is for
$data = $_POST['record'];			// The actual data
$data = str_replace("\\","",$data);	// Get rid of the escape character '\'
$data = json_decode($data);			// Parse the JSON into an object
 
/*****************************************************************************************
*	Parse the data into variables
*****************************************************************************************/

$root = $data->{'atdatalatest'};				// Root
	$unit = $root->{'unit'};						// Unit
		$id     = $unit->{'id'};						// id
		$nick   = $unit->{'nick'};						// Nick name
		$record = $unit->{'record'};					// Record
			$cached        = $record->{'cached'};			// Cached?
			$towerLocation = $record->{'towerlocation'};	// Tower location?
			$time 		   = $record->{'time'};	 			// Time
				$timeText = $time->{'text'};					// Text
			$status 	   = $record->{'status'};			// Status
				$batLevel   = $status->{'batterylevel'};		// Battery Level
				$gpsLevel   = $status->{'gpslevel'};			// GPS Level
				$towerLevel = $status->{'towerlevel'};			// Tower Level
			$gps		  = $record->{'gps'};				// GPS
				$lat	   = $gps->{'lat'};						// Latitude
				$lon	   = $gps->{'lon'};						// Longitude
				$alt	   = $gps->{'alt'};						// Altitude
				$speed     = $gps->{'speed'};					// Speed
				$heading   = $gps->{'heading'};					// Heading
				$direction = $gps->{'direction'};				// Direction		

/*****************************************************************************************
*	Make the data worthy to put in the database
*****************************************************************************************/		
$id            = mysql_real_escape_string($id);
$nick          = mysql_real_escape_string($nick);
$cached        = mysql_real_escape_string($cached);
$towerLocation = mysql_real_escape_string($towerLocation);
$timeText      = mysql_real_escape_string($timeText);
$batLevel      = mysql_real_escape_string($batLevel);
$gpsLevel      = mysql_real_escape_string($gpsLevel);
$towerLevel    = mysql_real_escape_string($towerLevel);
$lat           = mysql_real_escape_string($lat);
$lon 		   = mysql_real_escape_string($lon);
$alt 		   = mysql_real_escape_string($alt);
$speed 	       = mysql_real_escape_string($speed);
$heading 	   = mysql_real_escape_string($heading);
$direction 	   = mysql_real_escape_string($direction);
			
/*****************************************************************************************
*	Add data to database
*****************************************************************************************/

$query = 
" INSERT INTO tracking
  	(id, 
  	time, 
  	nick_name, 
  	cached, 
  	tower_location, 
  	battery_level, 
  	gps_level,
  	tower_level, 
  	latitude, 
  	longitude, 
  	altitude, 
  	speed, 
  	heading, 
  	direction)
  VALUES
  	('$id', 
  	'$timeText', 
  	'$nick', 
  	'$cached', 
  	'$towerLocation', 
  	'$batLevel', 
  	'$gpsLevel',
  	'$towerLevel', 
  	'$lat', 
  	'$lon', 
  	'$alt', 
  	'$speed', 
  	'$heading', 
  	'$direction')";	

$sql = mysql_query($query) or die(mysql_error());