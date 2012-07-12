/*******************************************************
 * This file contains the objects for maps.php
 ******************************************************/
 
 // Stop object
 function Stop() {
	 this.current   = false;
	 this.id        = '';
	 this.time      = '';
	 this.nickName  = '';
	 this.cached    = '';
	 this.tLocation = '';
	 this.bLevel	= '';
	 this.gLevel	= '';
	 this.tLevel	= '';
	 this.lag		= '';
	 this.lon 		= '';
	 this.alt 		= '';
	 this.speed		= '';
	 this.heading	= '';
	 this.direction	= '';  
 }
 
 // Truck object
 function Truck() {
	 this.currentStop = new Stop();
	 this.stops = new Array();
	 
	 // Return current stop
	 this.getCurrent() {
		 return this.currentStop;
	 }
	 
	 // Return all stops
	 this.getStops() {
		 return this.stops;
	 }
 }
 
 // Button object
 function Button(stop) {
	 // Will work on this later!
 }