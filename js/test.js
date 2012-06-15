// Begin Scheduled Routes
$(document).ready(function(){

// Table Sorter
$('table').livequery(function(){$(this).tablesorter(
			{headers: {0: {sorter: false}
					  ,2: {sorter: false}
					  ,6: {sorter: false}
					  ,9: {sorter: false}}
			,widgets: ['zebra']})});

// Populate table
var selectedDate = $('.datePicker').val();

// Clear table
$('table').find('tbody').html('');

// Initiate iterator
var num = 0;


// Ajax call to get Routes Table
$.post("php/addRoutes.php",{source: 'addScheduledRoutes', date: selectedDate}, 
		function(data){
			var row = '';
			$('Route', data).each(function(i){

			// Get each field from the current row		
			var route = $(this).find("route").text();
			var map = $(this).find("map").text();
			var zip = $(this).find("zip").text();
			var city = $(this).find("city").text();
			var cards = $(this).find("cards").text();
			var demo = $(this).find("demo").text();
			var last = $(this).find("last").text();
			if(last == '11/30/-0001')
				last = 'None';
			var ave = $(this).find("ave").text();
			
			// String to add row to table
			row += '<tr>' +
					  '<td><input type="checkbox" id="' + route + '" /></td>' +
					  '<td class="route">' + route + '</td>' +
					  '<td><a class="map" target="_blank" href="routes/maps/' + route + '.pdf">Map</a></td>' +
					  '<td class="zip">' + zip + '</td>' +
					  '<td class="city">' + city + '</a></td>' +
					  '<td class="cards">' + cards + '</td>' +
					  '<td><a class="demo" href="">Demo</a></td>' +
					  '<td class="lastScheduled">' + last + '</td>' +
					  '<td class="average">' + ave + '</td>' +
					  '<td><a class="history" href="">History</a></td>' +
					  '</tr>';

		}); // End inner function within query
		
		// Add row to table
			$('table').find('tbody').append(row);
			
			// Tell the table to sort the new data
			$('table').trigger('update');
			
			$('table').tablesorter({widgets: ['zebra']});
}); // End query

}); // End document