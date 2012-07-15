// Map
$(document).ready(function(){
/******************************************************************************* 
* Global variables
*******************************************************************************/
var i,j,k, numTrucks;						// Counters
var truck = new Truck();		// Truck object
var trucks = new function() {   // Singleton to hold trucks
	// Array for trucks
	this.vehicles = new Array();
	
	// Return trucks
	this.getTrucks = function() {
		return this.vehicles;	
	};
	
	// Return current markers
	this.getCurrent = function() {
		var currents = new Array();
		
		for(i = 0; i < this.vehicles.length; i++) {
			currents.push(this.vehicles[i].getCurrent());
		}
		
		return currents;
	}
	
	// Add truck to vehicle array
	this.addTruck = function(truck) {
		this.vehicles.push(truck);
	}
	
	// Return all markers for a vehicle
	this.getMarkers = function(truck) {
		for(i = 0; i < this.vehicles.length; i++) {
			if(this.vehicles[i].name == truck) {
				return this.vehicles[i].getMarkers();
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

// Run initial call for markers
parseMarkersJSON();

// Add markers to map
addMarkers(trucks.getCurrent());

console.log(trucks);

/******************************************************************************* 
* Parse JSON
*******************************************************************************/
function parseMarkersJSON() {
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
	// Get the number of trucks
	numTrucks = data.rows;
	
	$.each(data.points, function(i, val) {		
		$.each(val, function(key, value) {
		
			// Create marker object
			var marker = new Marker(
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
				
			// If new truck...	
			if(truck.name != value.id){
				// If truck object doesn't exist, create it
				if(truck.name != '')
					trucks.addTruck(truck);
					
				truck               = new Truck();
				truck.name          = value.id;
				truck.nickName      = value.nickName;
				truck.currentMarker = marker;
			}
				
			// Add marker to truck	
			truck.addMarker(marker);
			
			// Add last truck
			if(key.replace('i', '') == numTrucks)
				trucks.addTruck(truck);
				
		}); // End val.each
	}); // End data.points.each

}

/******************************************************************************* 
* Add trucks and markers to Control Panel
*******************************************************************************/
// Add truck holder to control panel
$('.control').append('<div class="trucks"></div>');

// Add truck objects to controlPanel
for(i = 0; i < trucks.vehicles.length; i++) {
	var truck = trucks.vehicles[i];
	$('.trucks').append('<p class="button truck black ' + truck.name + '">' + truck.nickName + 
		'</p><div  style="display: none;" class="panel ' + truck.name + '-panel"></div>');
	
	var panel = '.' + truck.name + '-panel';
	
	// Add top box
	$(panel).append('<div class="top-box"></div>');
	
	// Add Phone ID
	$(panel + ' .top-box').append('<div class="id">Phone ID: ' + 
		truck.name.replace('u','') + '</div>');

	// Add date drop-down list
	$(panel + ' .top-box').append('<div class="date-drop">Date: <select></select></div>');
	
	// Options
	var date = new Date();
	$(panel + ' select').append('<option>' + 
		date.getFullYear() + '-' + date.getMonth() + '-' + date.getDate() + 
		'</option>');
		
	date = new Date(date.getTime() - 1000 * 60 * 60 * 24 * 1);
	$(panel + ' select').append('<option>' + 
		date.getFullYear() + '-' + date.getMonth() + '-' + date.getDate() + 
		'</option>');
	
	date = new Date(date.getTime() - 1000 * 60 * 60 * 24 * 1);
	$(panel + ' select').append('<option>' + 
		date.getFullYear() + '-' + date.getMonth() + '-' + date.getDate() + 
		'</option>');
		
	date = new Date(date.getTime() - 1000 * 60 * 60 * 24 * 1);
	$(panel + ' select').append('<option>' + 
		date.getFullYear() + '-' + date.getMonth() + '-' + date.getDate() + 
		'</option>');
		
	date = new Date(date.getTime() - 1000 * 60 * 60 * 24 * 1);
	$(panel + ' select').append('<option>' + 
		date.getFullYear() + '-' + date.getMonth() + '-' + date.getDate() + 
		'</option>');
		
	date = new Date(date.getTime() - 1000 * 60 * 60 * 24 * 1);
	$(panel + ' select').append('<option>' + 
		date.getFullYear() + '-' + date.getMonth() + '-' + date.getDate() + 
		'</option>');
	
	
	// Add list
	$(panel).append('<ul class="' + truck.name + '-list"></ul>');
	
	// Add markers to truck
	for(j = 0; j < truck.getMarkers().length; j++) {
		var marker = truck.markers[j];
		
		// Parse time from marker time stamp
		var time = marker.time.split(' ');
		time = time[1].split(':');
		time = time[0] + ':' + time[1];
		
		$('.' + truck.name + '-list').append(
			'<li class="marker ' + truck.name + '-' + (j+1) + '">' +
				'<p>' +
					'Time: ' + time +
					'<span>' +
						 'Speed: ' + marker.speed + ' mph' +
					'</span>' + 
				'</p>' +
				'<p>' +
					'Heading: ' + ((marker.heading == 0) ? 'N/A' : marker.heading) + 
					'<span>' +
						'Battery: ' + marker.bLevel + '%' +
					'</span>' +
			    '</p>' +
			'</li>'
		);
	}
}

/******************************************************************************* 
* Toggle truck visibilty in control panel
*******************************************************************************/
$('.truck').click(function() {
	// Get truck name
	var truck = $(this).attr('class').replace('button truck black ', '');
	
	$(this).parent().find('.panel').each(function(index) {
		if($(this).css('display') == 'block' && $(this).attr('class') != 'panel ' + 
			truck + '-panel')
			$(this).toggle(500, function(){});
	});
	
	// toggle display
	$(this).parent().find('.' + truck + '-panel').toggle(500, function() {});
});

/******************************************************************************* 
* Add markers
*******************************************************************************/
function addMarkers(markers) {
	for(i = 0; i < markers.length; i++) {
		var marker = markers[i];
		$('.map').gmap('addMarker', 
			{ 
				'position': new google.maps.LatLng(marker.lat,marker.lon), 
			} 
		);
	} 
}
}); // End document