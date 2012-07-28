<?php
// Start session
session_start();
$site = $_SESSION['site'];
$user = $_SESSION['uName'];
// Include needed files
require_once("../$site/php/connect_to_mysql.php");
require_once('reformatDate.php');	

// Get pushed data
$date = date('Y-m-d', strtotime($_POST["date"]));

/*******************************************************************************
* Headers
*******************************************************************************/
// Used for returning json. COMMENT OUT WHEN TESTING
header('Content-Type: application/json');

// Used to test on webpage. COMMENT OUT WHEN NOT TESTING
// header('Content-Type: text/plain');

/*******************************************************************************
* Start json array
*******************************************************************************/
$json = array(
	"date" => $date,
	"count" => 0,			// Number of trucks to return
	"points" => array(),	// Array of stops
);

/*******************************************************************************
* Query DB
*******************************************************************************/
// Query string
$query = "SELECT * 
	  FROM tracking
	  WHERE time LIKE '$date%'
	  ORDER BY id ASC, time DESC";

// Query
$sql = mysql_query($query) or die(mysql_error());

/*******************************************************************************
* Process query
*******************************************************************************/
// Check for loop
$check = '';
$count = 0;
// Loop through array
while($array = mysql_fetch_array($sql)) {
	// Create array from row
	$row = array(
		"id"        => 'u' . $array["id"],
		"time"      => $array["time"],
		"nickName"  => $array["nick_name"],
		"cached"    => $array["cached"],
		"tLocation" => $array["tower_location"],
		"bLevel"    => $array["battery_level"],
		"gLevel"    => $array["gps_level"],
		"tLevel"    => $array["tower_level"],
		"lat"       => $array["latitude"],
		"lon"       => $array["longitude"],
		"alt"       => $array["altitude"],
		"speed"     => $array["speed"],
		"heading"   => $array["heading"],
		"direction" => $array["direction"],
	);
	
	// If id isn't in json already, add it
	if($row["id"] != $check) {
		$json["points"][$row["id"]] = array();
		$check = $row["id"];
		$count = 0;
		$json["rows"] += 1; // Increment number of trucks
	}

	// Add row to correct id
	$json["points"][$row["id"]]['i' . $count] = $row;
	$count++;
}

/*******************************************************************************
* Process query
*******************************************************************************/
// Return json
echo json_encode($json);
?>