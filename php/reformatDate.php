<?php

function ReformatDate($date, $format){

	$output = date($format, strtotime($date));
	return $output;	
}

?>