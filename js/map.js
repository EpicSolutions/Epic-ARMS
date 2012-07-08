// Map
$(document).ready(function(){

/*************************************************************************************** 
* Initial options & initialization
***************************************************************************************/
	var myOptions = {
		center: new google.maps.LatLng(-34.397, 150.644),
		zoom: 8,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
	};
	
	$('.map').gmap(myOptions);

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
