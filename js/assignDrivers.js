// Begin Scheduled Routes
$(document).ready(function(){

// Table Sorter
$('table').livequery(function(){$(this).tablesorter({widgets: ['zebra']})});

// Once date is selected populate table

$('.datePicker').change(function(event){
	
	event.preventDefault();
	
	var selectedDate = $('.datePicker').val();
	
	// Clear table
	$('table').find('tbody').html('');
	
	// Initiate iterator
	var num = 0;
	
	// Ajax call to get table contents
	$.post("php/SQLCommands.php",{source: 'getAssignDrivers', date: selectedDate}, 
			function(data){$('row', data).each(function(i){
			
				// Get each field from the current row		
				var date = $(this).find("date").text();
				var route = $(this).find("route").text();
				var driver = $(this).find("driver").text();
				var driverSplit = driver.split(' ');
				var helper = $(this).find("helper").text();
				var helperSplit = helper.split(' ');
				var stops = $(this).find("stops").text();
				var driverColor = '';
				var helperColor = '';
				
				if (driver == '' || driver == 'Not assigned')
				{
					driver = 'Not assigned';
					driverColor = 'style="color: red;"';
				}
				if (helper == '' || helper == 'Not assigned')
				{
					helper = 'Not assigned';
					helperColor = 'style="color: red;"';
				}
				
				if($(this).find("result").text() != "No Routes")
				{
					// String to add row to table
					var row = '<tr>' +
							  '<td class="date">' + date + '</td>' +
							  '<td class="route">' + route + '</td>' +
							  '<td class="' + driverSplit[0] + driverSplit[1] + '" ' + driverColor + '>' + driver + '</td>' +
							  '<td class="helper"' + helperColor + '>' + helper + '</td>' +
							  '<td class="stops">' + stops + '</td>' +
							  '<td><a class="change" href="">Change</a></td>' +
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

// Change Button
$('.change').live('click', function(event){

	event.preventDefault();
	
	var date   = $(this).parent().parent().find('.date').html();
	var route  = $(this).parent().parent().find('.route').html();
	var driver = $(this).parent().parent().find('td:eq(2)').attr('class');
	var helper = $(this).parent().parent().find('td:eq(3)').html();
	var stops = $(this).parent().parent().find('.stops').html();
	var result = '';
	var driverList = '';
	
	// Get drivers/helpers
	$.post("php/SQLCommands.php", {source: 'populateDrivers'},
		function(data){
			$('Driver', data).each(function(i){
			
				// Get each field from the current row		
				var firstName = $(this).find('first').text();
				var lastName = $(this).find('last').text();
				var name = firstName + ' ' + lastName;
				
				driverList += '<option>' + name + '</option>';
				
			}); // End each 
		
			// String for pop-up
			var string = '<p>Select the driver and helper. Then click "Change".</p>'
					   + '<form id="editDriver">'
					   + '<label>Driver  '
					   + '<select id="newDriver" style="margin-right: 5px;">'
					   + '<option>Not assigned</option>'
					   + driverList
					   + '</select></label>'
					   + '<label>Helper '
					   + '<select id="newHelper" style="margin-right: 5px;">'
					   + '<option>Not assigned</option>'
					   + driverList
					   + '</select></label>'
					   + '</form>';
			
			// Change pop-up
			$.fallr('show', {
				buttons: {
					button1: {text: 'Change', onclick: 
						function(){
							// Get values from input fields
							var newDriver = $(this).children('form').find('#newDriver option:selected').val();
							newDriverSplit = newDriver.split(' ');
							var newHelper = $(this).children('form').find('#newHelper option:selected').val();
							var driverColor = '';
							var helperColor = '';
							
							if(newDriver == 'Not assigned')
								driverColor = 'style="color: red;"';
							else
								driverColor = 'style="color: black;"';
								
							if(newHelper == 'Not assigned')
								helperColor = 'style="color: red;"';
							else
								helperColor = 'style="color: black;"';
							
							// Send data to php commands
							$.post("php/SQLCommands.php", {source: 'changeDriver', date: date, route: route, driver: newDriver, helper: newHelper});
							
							$('table').find('.' + driver).parent().html('' +
								'<td class="date">' + date + '</td>' +
								'<td class="route">' + route + '</td>' +
								'<td class="driver"' + driverColor + '>' + newDriverSplit[0] +  ' ' + newDriverSplit[1] + '</td>' +
								'<td class="helper"' + helperColor + '>' + newHelper + '</td>' +
								'<td class="stops">' + stops + '</td>' +
								'<td><a class="change" href="">Change</a></td>');
							
							// Tell the table to sort the new data
							$('table').trigger('update');		
							$('table').tablesorter({widgets: ['zebra']});
							
							// Close pop-up
							$.fallr('hide');
						}
					},
					button2: {text: 'Cancel', danger: true}	
				},
				closeKey : true,
				content  : string,
				position : 'center',
				width    : '400px',
				height   : '200px',
				icon     : 'card'
			}); // End Change pop-up
			
		}// End inner function
	); // End .post
});

}); // End Schedule Routes