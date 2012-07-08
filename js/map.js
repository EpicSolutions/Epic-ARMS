// Map
$(document).ready(function(){

/*************************************************************************************** 
* Initial options & initialization
***************************************************************************************/
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

/*************************************************************************************** 
* Test marker
***************************************************************************************/	
	$('.map').gmap(
		'addMarker', 
		{ /*id:'m_1',*/ 
		'position': new google.maps.LatLng(-34.397, 150.644), 
		'bounds': false }
	).click(function() {
        $('.map').gmap('openInfoWindow', { 'content': 'TEXT_AND_HTML_IN_INFOWINDOW' }, this);
	});
	
/*************************************************************************************** 
* Add markers
***************************************************************************************/
/*	$.getJSON( 'URL_TO_JSON', function(data) {
        $.each( data.markers, function(i, m) {
                $('#map_canvas').gmap('addMarker', { 'position': new google.maps.LatLng(m.latitude, m.longitude), 'bounds':true } );
        });
	});
*/
});
