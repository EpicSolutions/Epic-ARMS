/*******************************************************
 * This file contains the objects for maps.php
 ******************************************************/
 
 // Stop object
 function Stop(id, time, nickName, cached, tLocation, bLevel, gLevel,
 	tLevel, lat, lon, alt, speed, heading, direction) {
	 this.current   = false;
	 this.id        = id;
	 this.time      = time;
	 this.nickName  = nickName;
	 this.cached    = cached;
	 this.tLocation = tLocation;
	 this.bLevel	= bLevel;
	 this.gLevel	= gLevel;
	 this.tLevel	= tLevel;
	 this.lat		= lat;
	 this.lon 		= lon;
	 this.alt 		= alt;
	 this.speed		= speed;
	 this.heading	= heading;
	 this.direction	= direction;  
 }
 
 // Truck object
 function Truck() {
 	 this.name = '';
     this.length = 0;
	 this.currentStop = new Stop();
	 this.stops = new Array();
	 
	 // Return current stop
	 this.getCurrent = function() {
		 return this.currentStop;
	 };
	 
	 // Return all stops
	 this.getStops = function() {
		 return this.stops;
	 };
	 
	 // Add a stop
	 this.addStop = function(stop) {
	 	this.length++;
	 	this.stops.push(stop);
	 };
	 
	 // Get length
	 this.getLength = function(){
		 return this.length;
	 }
 }
 
 // Button object
 function Button(stop) {
	 // Will work on this later!
 }