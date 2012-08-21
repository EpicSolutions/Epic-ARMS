<?php
session_start();

$type = $_POST["type"];

if($type == 'set') {
	$data = unserialize($_SESSION["data"]);
	
	foreach($data as $key => $val) {
		$_SESSION["key"] = $val;
	}
}
else if($type == 'get') {	
	// Start xml
	$xml = "";
	// Send to XML
	header('Content-Type: application/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	echo '<query>';
	
	foreach($_SESSION as $key => $val) {
		$xml .= "<var>";
		$xml .= "<key>$key</key>";
		$xml .= "<val>$val</val>";
		$xml .= "</var>";
	}
	
	echo $xml;
	echo '</query>';
}
