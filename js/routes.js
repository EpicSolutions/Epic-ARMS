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
	$.post("php/SQLCommands.php",{source: 'scheduledRoutes', date: selectedDate, dateType: dateType}, 
			function(data){$('row', data).each(function(i){
			
				// Get each field from the current row		
				var date = $(this).find("date").text();
				var route = $(this).find("route").text();
				var location = $(this).find("location").text();
				var cards = $(this).find("cards").text();
				var calls = $(this).find("calls").text();
				
				if($(this).find("result").text() != "No Routes")
				{
					// String to add row to table
					var row = '<tr>' +
							  '<td class="date">' + date + '</td>' +
							  '<td class="route">' + route + '</td>' +
							  '<td class="location">' + location + '</td>' +
							  '<td class="cards">' + cards + '</td>' +
							  '<td><a class="calls" href="">' + calls + '</a></td>' +
							  '<td><a class="delete" href="">Delete</a></td>' +
							  '<td><a class="map" target="_blank" href="routes/maps/' + route + '.pdf">Map</a></td>' +
							  '</tr>';
							 
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
			});
	});
		
});

// Calls Button
$('.calls').live('click', function(event){

	event.preventDefault();
	
	var date = $(this).parent().parent().find('.date').html();
	date = new Date(date);
	date = date.toString();
	date = date.split(' ');
	date = date[2] + ' ' + date[1] + ' ' + date[3];
	var route = $(this).parent().parent().find('.route').html();
	var result = '';
		
	// Get Call Report data
	$.post("php/SQLCommands.php",{source: 'generateCR', date: date, route: route}, 
		function(data){
		
		var confirmed = '';
		var special = '';
		
		//Begin Call Report table
		var row = '<html>' +
				  '<head>' +
				  '<link href="css/CR.css" rel="stylesheet" type="text/css" media="print" />' +
				  '<link href="css/CR.css" rel="stylesheet" type="text/css" media="screen" />' +
				  '</head>' + 
				  '<body><cfoutput><table id="crTable">' +
				  '<thead>' +
			      '<tr class="noBorder"><th colspan="2">Call Report</th></tr>' +
				  '<tr class="noBorder"><td class="noBorder">Route: ' + route + '</td>' +
				  '<td class="noBorder">Date: ' + date.toString() + '</td></tr>';
				  
		
		$('row2', data).each(function(i){
		   row += '<tr class="noBorder">';
		   row += '<td class="noBorder">Driver: ' + $(this).find("driver").text() + '</td>';
		   row += '<td class="noBorder">Helper: ' + $(this).find("helper").text() + '</td>';
		   row += '</tr>';
		});
		
		   row += '<tr class="break" style="border: none;"></tr>';
		   row += '</thead>'; 
		
		$('row', data).each(function(i){
			
			if($(this).find("result").text() != "No History")
			{			
				// Get each field from the current row		
				var phone = $(this).find("phone").text();
				var firstName = $(this).find("firstName").text();
				var lastName = $(this).find("lastName").text();
				var address = $(this).find("address").text();
				var city = $(this).find("city").text();
				var state = $(this).find("state").text();
				var zip = $(this).find("zip").text();
				var email = $(this).find("email").text();
				var notes = $(this).find("notes").text();
				var location = $(this).find("location").text();
				var instruction = $(this).find("instruction").text();
				var dateCalled = $(this).find("dateCalled").text();
				var operator = $(this).find("operator").text();
				var callType = $(this).find("callType").text();
				var missed = $(this).find("missed").text();
				var endStatus = $(this).find("endStatus").text();
				
				// Config missed alert
				if(missed == 'true')
					missed = 'MISSED';
				else
					missed = '';
				
				if(callType == 'confirmed')
				{
					// String to add confirmed rows to table
					confirmed += '<tr class="start">';
					confirmed += '<th>' + address + ', ' + city + ', ' + state + ' ' + zip +'</th>';
					confirmed += '<td style="color: red; text-align: center;">' + missed + '</td>';
					confirmed += '</tr>';
					confirmed += '<tr>';
					confirmed += '<td class="left">Items Location: ' + location + '</td>';
					confirmed += '<td class="right">' + firstName + ': ' + phone + '</td>';
					confirmed += '</tr>';
					confirmed += '<tr class="end">';
					confirmed += '<td colspan="2">' + notes + '</td>';
					confirmed += '</tr>';
					confirmed += '<tr class="break" style="border: none;"></tr>';
				}
				else if (callType == 'special')
				{
					// String to add special rows to table
					special += '<tr class="start">';
					special += '<th>' + address + ', ' + city + ', ' + state + ' ' + zip +'</th>';
					special += '<td style="color: red; text-align: center;">' + missed + '</td>';
					special += '</tr>';
					special += '<tr>';
					special += '<td class="left">Items Location: ' + location + '</td>';
					special += '<td class="right">' + firstName + ': ' + phone + '</td>';
					special += '</tr>';
					special += '<tr class="end">';
					special += '<td colspan="2">' + notes + '</td>';
					special += '</tr>';
					special += '<tr class="break" style="border: none;"></tr>';	
				}
			} else
			{
				// Show error message 
				$.fallr('show', {
					closeKey: true,
					content : "There is no call history for this route.",
					position: 'top',
					width: '300px',
					height: '150px',
					icon    : 'sad'
				});	
				
				result = 'No History';	
			}
			
		});
	
	if(result != "No History")
	{	
		row += '<tr style="border-left: none;">';
		row += '<th style="font-size: 20pt;">Confirmed:</th>';
		row += '</tr>';
		row += '<tr style="height: 7px;"></tr>';
		row += confirmed;
		row += '<tr style="border-left: none;">';
		row += '<th style="font-size: 20pt;">Special:</th>';
		row += '</tr>';
		row += '<tr style="height: 7px;"></tr>';
		row += special;
		row += '</table></cfoutput></body></html>';
		
		var win = window.open('','Call Report');
		win.document.open();
		win.document.write(row);
		win.document.close();
	}
	});

});

// Delete Button
$('.delete').live('click', function(event){

	event.preventDefault();
	
	var date = $(this).parent().parent().find('.date').html();
	var route = $(this).parent().parent().find('.route').html();

	// Show confirmation 
	$.fallr('show', {
		buttons : {
			button1 : {text: 'Yes', danger: true, onclick: function(){
				
				// Ajax call to delete row
				$.post("php/SQLCommands.php",
				{source: 'deleteScheduledRoutes', date: date, route: route});
	
				$('.datePicker').change();
				
				$.fallr('hide');
				}},
			button2 : {text: 'No'}
			},
		closeKey: true,
		content : "Do you want to delete this row?",
		position: 'center',
		width: '300px',
		height: '150px',
		icon    : 'help'
	});
});

// When the viewType radio changes perform date change
$('input:radio[name=viewType]').change(function(event) {
	
	$('.datePicker').change();
});

}); // End Schedule Routes