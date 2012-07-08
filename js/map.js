// Map
$(document).ready(function(){
/******************************************************************************* 
* DOM 
*******************************************************************************/
$('body').append('<div class="trucks"></div>');
$('.trucks').css('display', 'none');

/******************************************************************************* 
* Parse JSON
*******************************************************************************/
$.getJSON('php/getPoints.php', function(data) {
	$.each(data.points, function(i, val) {
		$('.trucks').append('<div class="' + i + '"></div>');
		
		$.each(val, function(key, value) {
			// Append each stop to the truck
			$('.' + i).append('<ul id="' + i + '-' + key + 
				'" class="' + key + '"></ul>');
			
			// Append details to stop
			var list = $('#' + i + '-' + key);
			list.append('<li class="id">'        + value.id        + '</li>');
			list.append('<li class="time">'      + value.time      + '</li>');
			list.append('<li class="nickName">'  + value.nickName  + '</li>');
			list.append('<li class="cached">'    + value.cached    + '</li>');
			list.append('<li class="tLocation">' + value.tLocation + '</li>');
			list.append('<li class="bLevel">'    + value.bLevel    + '</li>');
			list.append('<li class="gLevel">'    + value.gLevel    + '</li>');
			list.append('<li class="tLevel">'    + value.tLevel    + '</li>');
			list.append('<li class="lat">'       + value.lat       + '</li>');
			list.append('<li class="lon">'       + value.lon       + '</li>');
			list.append('<li class="alt">'       + value.alt       + '</li>');
			list.append('<li class="speed">'     + value.speed     + '</li>');
			list.append('<li class="heading">'   + value.heading   + '</li>');
			list.append('<li class="direction">' + value.direction + '</li>');
			
			// Add current class to first(current) stop
			$('.trucks').find('.i0').addClass('current');
		}); // End val.each
	}); // End data.points.each
}); // End getJSON

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

/******************************************************************************* 
* Test marker
*******************************************************************************/	
	$('.map').gmap(
		'addMarker', 
		{ /*id:'m_1',*/ 
		'position': new google.maps.LatLng(-34.397, 150.644), 
		'bounds': false }
	).click(function() {
        $('.map').gmap('openInfoWindow', { 'content': 'TEXT_AND_HTML_IN_INFOWINDOW' }, this);
	});
	
/******************************************************************************* 
* Add markers
*******************************************************************************/
/*	$.getJSON( 'URL_TO_JSON', function(data) {
        $.each( data.markers, function(i, m) {
                $('#map_canvas').gmap('addMarker', { 'position': new google.maps.LatLng(m.latitude, m.longitude), 'bounds':true } );
        });
	});
*/
});
