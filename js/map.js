// Map
$(document).ready(function(){
/******************************************************************************* 
* Global variables
*******************************************************************************/
var i,j,k, numTrucks;				// Counters
var truckObj = new Truck();		 	// Truck object
var currentMarkers = new Array(); 	// Current markers on map

function Trucks() {  			// Singleton to hold trucks
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

var trucks = new Trucks();

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

// Run initial call for markers parseMarkersJSON();
// Remove parameters in side before pushing live
var date = new Date('2012', '06', '21');
date = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate(); 
parseMarkersJSON(date);

console.log(trucks.getCurrent());

// Add markers to map
addMarkers(trucks.getCurrent());

/******************************************************************************* 
* Parse JSON
*******************************************************************************/
function parseMarkersJSON(date) {
	// global object to catch json
	var jsonData = {};			
    
    // Run ajax call to retrieve JSON
    $.ajax({
	type: "POST",
        url: "php/getPoints.php",
	data: {date: date},
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
	
	// Reset map markers
	currentMarkers = new Array();
	
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

			// Add marker to currentMarkers
			currentMarkers.push(marker)

			// If new truck...	
			if(truckObj.name != value.id){
				// If truck object doesn't exist, create it
				if(truckObj.name != '') {
					trucks.addTruck(truckObj);
				}
					
				truckObj               = new Truck();
				truckObj.name          = value.id;
				truckObj.nickName      = value.nickName;
				truckObj.currentMarker = marker;
			}
				
			// Add marker to truck	
			truckObj.addMarker(marker);
			
			// Add last truck
			if(key.replace('i', '') == numTrucks)
				trucks.addTruck(truckObj);
				
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
	$(panel + ' .top-box').append('<div class="date-drop">Date: <select class="date-pick"></select></div>');
	
	// Options
	// Remove parameters before pushing live
	var date = new Date('2012', '06', '21');
	$(panel + ' select').append('<option value="' + date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate() + 
		'">Today</option>');
		
	date = new Date(date.getTime() - 1000 * 60 * 60 * 24 * 1);
	$(panel + ' select').append('<option value="' + date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate() +
                '">' + date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate() + '</option>');
	
	date = new Date(date.getTime() - 1000 * 60 * 60 * 24 * 1);
	$(panel + ' select').append('<option value="' + date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate() +
                '">' + date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate() + '</option>');
		
	date = new Date(date.getTime() - 1000 * 60 * 60 * 24 * 1);
	$(panel + ' select').append('<option value="' + date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate() +
                '">' + date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate() + '</option>');
		
	date = new Date(date.getTime() - 1000 * 60 * 60 * 24 * 1);
	$(panel + ' select').append('<option value="' + date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate() +
                '">' + date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate() + '</option>');
		
	date = new Date(date.getTime() - 1000 * 60 * 60 * 24 * 1);
	$(panel + ' select').append('<option value="' + date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate() +
                '">' + date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate() + '</option>');
	
	
	// Add list
	$(panel).append('<ul class="' + truck.name + '-list"></ul>');
	
	// Add the markers to the control panel
	addToConrtrol(truck);
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
	$(this).parent().find('.' + truck + '-panel').toggle(300, function() {});

	var win = $("body");
	win.width(win.width() - 1);
	win.width(win.width() + 1);
	
	// Populate markers
	var currentCheck = $('.' + truck + '-panel').css('opacity');
	if(currentCheck == 0)
		$('.date-pick').change();
	else {
		clearMarkers();
		addMarkers(trucks.getCurrent());
	}
	
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

/*******************************************************************************
* Change Date
*******************************************************************************/
$(".date-pick").change(function() {
	var name = $(this).attr("class");
	var date = $('.' + name + ' option:selected').val();

	// Clear markers
	clearMarkers();

	// Clear trucks 
	trucks = new Trucks();
 	truckObj = new Truck();
	
	// Get new markers
	parseMarkersJSON(date);
	
	// Get list name
	var list = $(this).parent().parent().parent().find('ul').attr('class').replace('-list','');

	// If no markers...
	if(trucks.vehicles.length < 1) {
	    $('.' + list + '-list').html(
	        '<li class="noRoutes">No data for this date</li>'
	    );
	}	

	// Get correct truck
	for(i = 0; i < trucks.vehicles.length; i++){
	    var truck = trucks.vehicles[i];
	    
	    // If truck matches...
 	    if(truck.name == list) {
	   		$('.' + truck.name + '-list').html('');

	        // Add the markers to the control panel
			addToConrtrol(truck);
			
			// Add markers to map
    		addMarkers(truck.getMarkers());
			
	    } // End if truck == list
	} // End get correct truck	
});

// Add Markers to the control panel
function addToConrtrol(truck) {
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
                '<div class="pointCoord" style="display: none;">' +
                	'<div class="lat">' + marker.lat + '</div>' +
                	'<div class="lon">' + marker.lon + '</div>' +
                '</div>' +
            '</li>'
            );
    } // End add markers to truck
    
} // End addToControl

// Clear markers
function clearMarkers() {
	$('.map').gmap('clear', 'markers');
}

}); // End document
