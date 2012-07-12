// Map
$(document).ready(function(){
/******************************************************************************* 
* Global variables
*******************************************************************************/
var i,j,k;						// Counters
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
	// Add truck to vehicle array
	this.addTruck = function(truck) {
		this.vehicles.push(truck);
	}
	// Return all stops for a vehicle
	this.getStops = function(truck) {
		var i;
		for(i = 0; i < this.vehicles.length; i++) {
			if(this.vehicles[i].name == truck) {
				return this.vehicles[i].getStops();
			}
		}	
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
				
			if(truck.name != value.id){
				if(truck.name != '')
					trucks.addTruck(truck);
				truck = new Truck();
				truck.name = value.id;
			}
				
			// Add stop to truck	
			truck.addStop(stop);
		}); // End val.each
	}); // End data.points.each

}

/******************************************************************************* 
* Add trucks and stops to Control Panel
*******************************************************************************/
// Add truck holder to control panel
$('.control').append('<div class="trucks"></div>');

// Add truck objects to controlPanel
for(i = 0; i < trucks.vehicles.length; i++) {
	var truck = trucks.vehicles[i];
	$('.trucks').append('<p class="truck ' + truck.name + '">' + truck.name + '</p>');
	$('.trucks').append('<ul class="' + truck.name + '-list"></ul>');
	
	// Add stops to truck
	for(j = 0; j < truck.getStops().length; j++) {
		var stop = truck.stops[j];
		
		$('.' + truck.name + '-list').append(
			'<li class="stop ' + truck.name + '-' + (j+1) + '">' + stop.time + '</li>'
		);
	}
}

// Event to hide stops
$('.truck').click(function() {
	var truck = $(this).attr('class').replace('truck ', '');
	$(this).parent().find('.' + truck + '-list').toggle(); //css({'display': 'none'});
});

/******************************************************************************* 
* Add markers
*******************************************************************************/

//$('.map').gmap('addMarker', { 'position': new google.maps.LatLng(lat,lon), 'bounds':true } ); 

//}); // End getJSON

}); // End document