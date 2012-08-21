// Begin Scheduled Routes
$(document).ready(function(){



// Site name
var sitePHP = $('#sitePHP').val();

// Populate days
$('#days').html(
	'<a id="mon" href="" style="margin-left: 40px;">Monday</a>' +
	'<a id="tues" href="">Tuesday</a>' +
	'<a id="wed" href="">Wednesday</a>' +
	'<a id="thur" href="">Thursday</a>' +
	'<a id="fri" href="">Friday</a>'
);

// Populate table
var selectedDate = $('.datePicker').val();

// Clear table
$('table').find('tbody').html('');

// Initiate iterator
var num = 0;

// Add History
$('.datePicker').change(function() {
	$.post("php/SQLCommands.php",{source: 'routeHistory', date: selectedDate}, 
			function(data){
				
				var row = '';
				
				$('Route', data).each(function(i){
			
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
					var avg       = $(this).find("avg").text();
						avg       = parseFloat(avg);					
					var total     = partFloat(clothing) + parseFloat(misc);
					
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
						 
			}); // End inner function within query
			
			// Add row to table
			$('table').find('tbody').append(row);
			
			$('table').tablesorter(
				{sortList: [[1,0]]},
				{widthFixed: false},
				{widgets: ['zebra']});
				
			// Fix header
			fixedHead(745, 320);
			
	}); // End query
}); // End datePicker change

// Clear Button
$('#clear').live('click', function(event){
	
	event.preventDefault();
	
	$('input:checkbox').removeAttr('checked');
	
	/*$('input').each($('#addRouteTable'), function(i){
	
		$('#' + this).
	});*/
	
});

// History Button
$('.history').live('click', function(event){

	event.preventDefault();
	
	var route = $(this).parent().parent().find('.route').html();
	
	// Get route history
	$.post('php/SQLCommands.php', {source: 'routeHistory', route: route},
		function(data){
		
		// Check to see if database has any entries	
		if($(data).find("route").text()){
			
			// Header for table
			var tableText = '<table class="historyTable">' +
							'<thead>' +
							'<tr>' +
							'<th>Scheduled Dates</th>' +
							'<th>Cards</th>' +
							'<th>Calls</th>' +
							'<th>Stops</th>' +
							'<th>Clothing (Lbs)</th>' +
							'<th>MISC (Lbs)</th>' +
							'<th>Notes</th>' +
							'<th>Total</th>' +
							'<th>Average Per Stop</th>' +
							'</tr>' +
							'</thead>' +
							'</table>' +
							'<div class="historyHolder">' +
							'<table class="historyTable">' +
							'<tbody></tbody>' +
							'</table>' +
							'</div>';
			
			// Create Table
			var table = $(document.createElement('div'));
			
			// Append header
			table.append(tableText);
			
			// Add sorting
			$(table).find('table').addClass('tablesorter historyTable');
			$('.historyTable').tablesorter({widthFixed: false},{widgets: ['zebra']});
			
			// Table CSS
			table.find('td').css('border', '1px solid black');			
			
			// Populate rows
			$('History', data).each(function(i){
				
				// Get data from database
				var route = $(this).find("route").text();
				var date  = $(this).find("date").text();
				var cards = $(this).find("cards").text();
				var calls = $(this).find("calls").text();
				var stops = $(this).find("stops").text();
				var cloth = $(this).find("cloth").text();
				var misc  = $(this).find("misc").text();
				var notes = $(this).find("notes").text();
				
				// Calculate total and average
				var total = parseFloat(cloth) + parseFloat(misc);
				var average = (total / stops).toFixed(2);
				
				// Calculate days since route
				var today = new Date();
				var numDays = parseInt((today - Date.parse(date))/1000/3600/24);
				
				// Show route history from last 12 months only
				if(numDays <= 365)
				{					
					// String for table
					table.find('tbody').append(
						'<tr>' +
						'<td>' + date + '</td>' +
						'<td>' + cards + '</td>' +
						'<td>' + calls + '</td>' +
						'<td>' + stops + '</td>' +
						'<td>' + cloth + '</td>' +
						'<td>' + misc + '</td>' +
						'<td class="noteCol">' + notes + '</td>' +
						'<td>' + total + '</td>' +
						'<td>' + average + '</td>' +
						'</tr>');
						
					$('.historyHolder').css({scroll: 'auto'});
			
					// Tell the table to sort the new data
					table.trigger('update');
					table.tablesorter({widthFixed: false},{widgets: ['zebra']});
										
				} // Condition for last 12 months
			}); // End row population
		
			// Window dimensions
			var gap = 20;
			var boxH = $(window).height() - gap;
			var boxW = $(window).width() - gap * 2;
			
			// Create fallr pop-up window
			$.fallr('show', {
				buttons : {
					button1 : {text: 'Close', onclick: function(){
						
						// Do stuff here
						
						$.fallr('hide');
						}}
					},
				closeKey: true,
				content : table,
				position: 'center',
				width: 1060,
				height: 500,
				icon: 'none'});
			
		} else // If no entries in database display error
			{
				// Create fallr pop-up window
				$.fallr('show', {
					buttons : {
						button1 : {text: 'Close', onclick: function(){
							
							// Do stuff here
							
							$.fallr('hide');
							}}
						},
					closeKey: true,
					content : "There is no history for this route.",
					icon: 'sad'});	
			} // End Condition for entries in database
	}); // End query to database
}); // End History button

// Demograpics Button
$('.demo').live('click', function(event){

	event.preventDefault();
	
	$.fallr('show',{
			closeKey: true,
			content : "This feature is not available yet.",
			icon: 'help'});	


}); // End Demographics button

/**** Add Routes Button ****/
$('#addRoutes').live('click', function(event){
	
	event.preventDefault();
	
	// Initialize variables
	var date = $('.datePicker').val();
        var week = $('#week:checked').length > 0;
	var routes = [];
	
	
	if(date == '')
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'You must first enter a date.',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});		
	}else
	{	
		// Iterate through table to find selected routes
		$('#addRouteTable input').each(function(i){
			
			if($(this).attr('checked'))
				routes.push($(this).attr('id'));	
			
		}); // End table iteration
		
		var message = 'Are you sure you want to add these routes:<br /><br />';
		
		for(var i = 0; i < routes.length; i++)
		{
			message += routes[i] + "<br />";	
		}
		
		// Variable for response
		var check = false;
		
		if(routes.length > 0)
		{
			// Message if routes are selected
			$.fallr('show', {
				buttons : {
					button1 : {text: 'Yes', onclick: function(){addRoutes(date, routes);}},
					button2: {text: 'No', danger: true}
					},
				closeKey: true,
				content : message});
				
		} else
		{
			// Message if no routes are selected
			$.fallr('show', {
				closeKey: true,
				content : 'You did not select any routes.',
				icon: 'error',
				position: 'center',
				useOverlay: false});
		}
		
		function addRoutes(date, routes){
			
			// Ajax to add routes to scheduledRoutes table
			$.post('php/SQLCommands.php', {source: 'addToScheduled', routes: routes, date: date, week: week},
				function(data){
									
					// Hide previous fallr
					$.fallr('hide', function(){
						if(data.indexOf('success') >= 0)
						{
							// Show message when success
							$.fallr('show',{
								closeKey: true,
								content : 'The routes were added.',
								icon: 'smile',
								position: 'center',
								useOverlay: false
							}); // End inner fallr
						} else if(data.indexOf('already added') >= 0)
						{
							// Show message when success
							$.fallr('show',{
								closeKey: true,
								content : 'These routes are already in the table',
								icon: 'sad',
								position: 'center',
								useOverlay: false
							}); // End inner fallr
						} else
						{
							// Show message when success
							$.fallr('show',{
								closeKey: true,
								content : 'There was an error adding routes. Please contact your administrator.',
								icon: 'sad',
								position: 'center',
								useOverlay: false
							}); // End inner fallr
						}
					}); // End outer fallr
										
			}); // End post
		} // end addRoutes
	}
}); // End Add Routes button

/**** Back Button ****/
$('#back').live('click', function(event){
	
	$(window.location).attr('href', 'routes.php');
	
}); // End Back button

/**** Week day buttons ****/
//Monday
$('#mon').live('click',function(event){
	
	event.preventDefault();
		
	$('#days').html(
		'<span id="mon" href="" style="margin-left: 40px;">Monday</span>' +
        '<a id="tues" href="">Tuesday</a>' +
        '<a id="wed" href="">Wednesday</a>' +
        '<a id="thur" href="">Thursday</a>' +
        '<a id="fri" href="">Friday</a>'
	);
	
	// Day of week
	var dateString = $('.datePicker').val();
	var date = new Date(dateString);
	
	var dayOfMon = date.getDate();
	var day = date.getDay();
	
	date.setDate(date.getDate() + 1 - day);
		
	var month = '';
	
	switch (date.getMonth())
	{
		case  0: month = 'January';
		   break;
		case  1: month = 'February';
		   break;
		case  2: month = 'March';
		   break;
	    case  3: month = 'April';
		   break;
		case  4: month = 'May';
		   break;
		case  5: month = 'June';
		   break;
		case  6: month = 'July';
		   break;
		case  7: month = 'August';
		   break;
		case  8: month = 'September';
		   break;
		case  9: month = 'October';
		   break;
		case 10: month = 'November';
		   break;
		default: month = 'December';
		   break;	
	}
	
	dateString = month + ' ' + date.getDate() + ', ' + date.getFullYear();
	$(".datePicker").val(dateString);
	
	$('#clear').click();	
	
}); // End Monday

//Tuesday
$('#tues').live('click',function(event){
	
	event.preventDefault();
		
	$('#days').html(
		'<a id="mon" href="" style="margin-left: 40px;">Monday</a>' +
        '<span id="tues" href="">Tuesday</span>' +
        '<a id="wed" href="">Wednesday</a>' +
        '<a id="thur" href="">Thursday</a>' +
        '<a id="fri" href="">Friday</a>'
	);
	
	// Day of week
	var dateString = $('.datePicker').val();
	var date = new Date(dateString);
	
	var dayOfMon = date.getDate();
	var day = date.getDay();
	
	date.setDate(date.getDate() + 2 - day);
		
	var month = '';
	
	switch (date.getMonth())
	{
		case  0: month = 'January';
		   break;
		case  1: month = 'February';
		   break;
		case  2: month = 'March';
		   break;
	    case  3: month = 'April';
		   break;
		case  4: month = 'May';
		   break;
		case  5: month = 'June';
		   break;
		case  6: month = 'July';
		   break;
		case  7: month = 'August';
		   break;
		case  8: month = 'September';
		   break;
		case  9: month = 'October';
		   break;
		case 10: month = 'November';
		   break;
		default: month = 'December';
		   break;	
	}
	
	dateString = month + ' ' + date.getDate() + ', ' + date.getFullYear();
	$(".datePicker").val(dateString);
	
	$('#clear').click();	
	
}); // End Tuesday

//Wednesday
$('#wed').live('click',function(event){
	
	event.preventDefault();
		
	$('#days').html(
		'<a id="mon" href="" style="margin-left: 40px;">Monday</a>' +
        '<a id="tues" href="">Tuesday</a>' +
        '<span id="wed" href="">Wednesday</span>' +
        '<a id="thur" href="">Thursday</a>' +
        '<a id="fri" href="">Friday</a>'
	);
	
	// Day of week
	var dateString = $('.datePicker').val();
	var date = new Date(dateString);
	
	var dayOfMon = date.getDate();
	var day = date.getDay();
	
	date.setDate(date.getDate() + 3 - day);
		
	var month = '';
	
	switch (date.getMonth())
	{
		case  0: month = 'January';
		   break;
		case  1: month = 'February';
		   break;
		case  2: month = 'March';
		   break;
	    case  3: month = 'April';
		   break;
		case  4: month = 'May';
		   break;
		case  5: month = 'June';
		   break;
		case  6: month = 'July';
		   break;
		case  7: month = 'August';
		   break;
		case  8: month = 'September';
		   break;
		case  9: month = 'October';
		   break;
		case 10: month = 'November';
		   break;
		default: month = 'December';
		   break;	
	}
	
	dateString = month + ' ' + date.getDate() + ', ' + date.getFullYear();
	$(".datePicker").val(dateString);
	
	$('#clear').click();	
		
}); // End Wednesday

//Thursday
$('#thur').live('click',function(event){
	
	event.preventDefault();
		
	$('#days').html(
		'<a id="mon" href="" style="margin-left: 40px;">Monday</a>' +
        '<a id="tues" href="">Tuesday</a>' +
        '<a id="wed" href="">Wednesday</a>' +
        '<span id="thur" href="">Thursday</span>' +
        '<a id="fri" href="">Friday</a>'
	);
	
	// Day of week
	var dateString = $('.datePicker').val();
	var date = new Date(dateString);
	
	var dayOfMon = date.getDate();
	var day = date.getDay();
	
	date.setDate(date.getDate() + 4 - day);
		
	var month = '';
	
	switch (date.getMonth())
	{
		case  0: month = 'January';
		   break;
		case  1: month = 'February';
		   break;
		case  2: month = 'March';
		   break;
	    case  3: month = 'April';
		   break;
		case  4: month = 'May';
		   break;
		case  5: month = 'June';
		   break;
		case  6: month = 'July';
		   break;
		case  7: month = 'August';
		   break;
		case  8: month = 'September';
		   break;
		case  9: month = 'October';
		   break;
		case 10: month = 'November';
		   break;
		default: month = 'December';
		   break;	
	}
	
	dateString = month + ' ' + date.getDate() + ', ' + date.getFullYear();
	$(".datePicker").val(dateString);	
	
	$('#clear').click();
	
}); // End Thursday

//Friday
$('#fri').live('click',function(event){
	
	event.preventDefault();
		
	$('#days').html(
		'<a id="mon" href="" style="margin-left: 40px;">Monday</a>' +
        '<a id="tues" href="">Tuesday</a>' +
        '<a id="wed" href="">Wednesday</a>' +
        '<a id="thur" href="">Thursday</a>' +
        '<span id="fri" href="">Friday</span>'
	);
	
	// Day of week
	var dateString = $('.datePicker').val();
	var date = new Date(dateString);
	
	var dayOfMon = date.getDate();
	var day = date.getDay();
	
	date.setDate(date.getDate() + 5 - day);
		
	var month = '';
	
	switch (date.getMonth())
	{
		case  0: month = 'January';
		   break;
		case  1: month = 'February';
		   break;
		case  2: month = 'March';
		   break;
	    case  3: month = 'April';
		   break;
		case  4: month = 'May';
		   break;
		case  5: month = 'June';
		   break;
		case  6: month = 'July';
		   break;
		case  7: month = 'August';
		   break;
		case  8: month = 'September';
		   break;
		case  9: month = 'October';
		   break;
		case 10: month = 'November';
		   break;
		default: month = 'December';
		   break;	
	}
	
	dateString = month + ' ' + date.getDate() + ', ' + date.getFullYear();
	$(".datePicker").val(dateString);	
	
	$('#clear').click();
	
}); // End Friday
}); // End document