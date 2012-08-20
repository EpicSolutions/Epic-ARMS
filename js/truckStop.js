/*******************************************************
 * This file contains the objects for maps.php
 ******************************************************/
 
 // marker object
 function Marker(id, time, nickName, cached, tLocation, bLevel, gLevel,
 	tLevel, lat, lon, alt, speed, heading, direction) {
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
 	 this.nickName = '';
     this.length = 0;
	 this.currentMarker = new Marker();
	 this.markers = new Array();
	 
	 // Return current marker
	 this.getCurrent = function() {
		 return this.currentMarker;
	 };
	 
	 // Return all markers
	 this.getMarkers = function() {
		 return this.markers;
	 };
	 
	 // Add a marker
	 this.addMarker = function(marker) {
	 	this.length++;
	 	this.markers.push(marker);
	 };
	 
	 // Get length
	 this.getLength = function(){
		 return this.length;
	 }
	 
	 // Clear truck
	 this.clear = function() {
		this.name = '';
		this.nickName = '';
		this.length = 0;
		this.currentMarker = new marker();
		this.markers = new Array(); 
	 };
 }
 
 // Button object
 function Button(marker) {
	 // Will work on this later!
 }