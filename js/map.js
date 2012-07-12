// Map
$(document).ready(function(){
/******************************************************************************* 
* Global variables
*******************************************************************************/
var truck = new Truck();		// Truck object
var trucks = new function() {   // Singleton to hold trucks
	// Array for trucks
	this.vehicles = new Array();
	// Return trucks
	this.getTrucks = function() {
		return this.vehicles;	
	};
	// Return current stops
	this.getCurrent = function() {
		var i; // counter
		var currents = new Array();
		for(i = 0; i < vehicles.length; i++) {
			currents.push(vehicles[i].getCurrent());
		}
	}
	// Return all stops for a vehicle
	this.getStops = function(truck) {
		return truck.getStops();	
	};	
};

/******************************************************************************* 
* Initial options & initialization
*******************************************************************************/
	// Initial options
	var myOptions = {
		zoom: 8,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
	};
	
	// Render map
	$('.map').gmap(myOptions);
	
	// Set center at starting point
	$('.map').gmap('search', { 'address': 'Dallas, Texas' }, function(results, status) {
    if ( status === 'OK' ) {
                $('.map').gmap('get', 'map').panTo(results[0].geometry.location);
        }
});

// Run initial call for stops
parseStopsJSON();

/******************************************************************************* 
* Parse JSON
*******************************************************************************/
function parseStopsJSON() {
	// global object to catch json
	var jsonData = {};			
    
    // Run ajax call to retrieve JSON
    $.ajax({
        url: "php/getPoints.php",
        async: false,
        dataType: 'json',
        success: function(data) {
                processJSON(data);
        }
    });
}
/******************************************************************************* 
* Process JSON
*******************************************************************************/
function processJSON(data) {
	$.each(data.points, function(i, val) {		
		$.each(val, function(key, value) {
			// Create stop object
			var stop = new Stop(
				value.id,
				value.time,
				value.nickName,
				value.cached,
				value.tLocation,
				value.bLevel,
				value.gLevel,
				value.tLevel,
				value.lat,
				value.lon,
				value.alt,
				value.speed,
				value.heading,
				value.direction);
				
			// Add stop to truck	
			trucks.addStop(stop);
		}); // End val.each
	}); // End data.points.each

}

/******************************************************************************* 
* Add markers
*******************************************************************************/

//$('.map').gmap('addMarker', { 'position': new google.maps.LatLng(lat,lon), 'bounds':true } ); 

//}); // End getJSON

/******************************************************************************* 
* Add trucks and stops to Control Panel
*******************************************************************************/
// Add trucks to control panel
$('.control').append('<div class="trucks"></div>');
//$('.trucks').css('display', 'none');
$('.control').css('overflow', 'scroll');

}); // End document