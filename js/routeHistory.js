// Begin Scheduled Routes
$(document).ready(function(){
	
// Set to By Day
$('input:radio[name="viewType"]').filter('[value="day"]').attr('checked',true);

// Table Sorter
$('table').livequery(function(){$(this).tablesorter({widgets: ['zebra']})});

// Once date is selected populate table

$('.datePicker').change(function(event){
	
	event.preventDefault();
	
	var selectedDate = $('.datePicker').val();
	
	var dateType = $("input[@name=viewType]:checked").val();

	// Clear table
	$('table').find('tbody').html('');
	
	// Initiate iterator
	var num = 0;
	
	// Ajax call to get table contents
	$.post("php/SQLCommands.php",{source: 'routeResults', date: selectedDate, dateType: dateType}, 
			function(data){	$('row', data).each(function(i){
			
			var row = '';
			
				// Get each field from the current row		
				var route     = $(this).find("route").text();
				var notes     = $(this).find("notes").text();
				var date      = $(this).find("date").text();
				var cards     = $(this).find("cards").text();
				var calls     = $(this).find("calls").text();
				var driver    = $(this).find("driver").text();
				var helper    = $(this).find("helper").text();
				var clothing  = $(this).find("clothing").text();
				var misc      = $(this).find("misc").text();
				var furniture = $(this).find("furniture").text();
				var stops     = $(this).find("stops").text();
				var total     = parseFloat(clothing) + parseFloat(misc);
				var avg       = (total / stops).toFixed(2);					
				
				
				if($(this).find("result").text() != "No Routes")
				{
					// String to add row to table
					row += '<tr>' +
						  	  '<td class="date">'     + date     + '</td>' +
						  	  '<td class="cards">'    + cards    + '</td>' +
						   	  '<td class="calls">'    + calls    + '</td>' +
						   	  '<td class="stops">'    + stops    + '</td>' +
						      '<td class="clothing">' + clothing + '</td>' +
						   	  '<td class="misc">'     + misc     + '</td>' +
						  	  '<td class="notes">'    + notes    + '</td>' +
						  	  '<td class="total">'    + total    + '</td>' +
						  	  '<td class="avg">'      + avg      + '</td>' +
						   '</tr>';
				console.log("hello");			 
					// Add row to table
					$('table').find('tbody').append(row);
					
					// Tell the table to sort the new data
					$('table').trigger('update');
					
					$('table').tablesorter({widgets: ['zebra']});
				} else
				{
					// Show error message 
					$.fallr('show', {
						closeKey: true,
						content : "There are no routes for this date.",
						position: 'top',
						width: '300px',
						height: '150px',
						icon    : 'sad'
					});	
				}
				
			}); // End each row 
	}); // End post
}); // End change

// When the viewType radio changes perform date change
$('input:radio[name=viewType]').change(function(event) {
	
	$('.datePicker').change();
});

}); // End Schedule Routes