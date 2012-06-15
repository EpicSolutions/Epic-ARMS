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

// Ajax call to get Routes Table
$.post("php/SQLCommands.php",{source: 'addScheduledRoutes', date: selectedDate}, 
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
					  '<td><a class="map" target="_blank" href="' + sitePHP + '/routes/maps/' + route + '.pdf">Map</a></td>' +
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
		
		$('table').tablesorter(
			{sortList: [[1,0]]},
			{widgets: ['zebra']});
		
}); // End query

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
			var tableText = '<table>' +
							'<thead>' +
							'<tr>' +
							'<th>ScheduledDates</th>' +
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
							'<tbody>';
			
			// Create Table
			var table = $(document.createElement('div'));
			
			// Append header
			table.append(tableText);
			
			// Add sorting
			$(table).find('table').addClass('tablesorter historyTable');
			$('.historyTable').tablesorter({widgets: ['zebra']});
			
			// Table CSS
			table.find('td').css('border', '1px solid black');			
			
			// Populate rows
			$('History', data).each(function(i){
				
				// Get data from database
				var route = $(this).find("route").text();
				var date = $(this).find("date").text();
				var cards = $(this).find("cards").text();
				var calls = $(this).find("calls").text();
				var stops = $(this).find("stops").text();
				var cloth = $(this).find("cloth").text();
				var misc = $(this).find("misc").text();
				var notes = $(this).find("notes").text();
				
				// Calculate total and average
				var total = parseInt(cloth) + parseInt(misc);
				var average = total / stops;
				
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
						'<td>' + notes + '</td>' +
						'<td>' + total + '</td>' +
						'<td>' + average + '</td>' +
						'</tr>');
			
					// Tell the table to sort the new data
					table.trigger('update');
					table.tablesorter({widgets: ['zebra']});					
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
				width: boxW,
				height: boxH,
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
		case  0: month = 'Jan';
		   break;
		case  1: month = 'Feb';
		   break;
		case  2: month = 'Mar';
		   break;
	    case  3: month = 'Apr';
		   break;
		case  4: month = 'May';
		   break;
		case  5: month = 'Jun';
		   break;
		case  6: month = 'Jul';
		   break;
		case  7: month = 'Aug';
		   break;
		case  8: month = 'Sep';
		   break;
		case  9: month = 'Oct';
		   break;
		case 10: month = 'Nov';
		   break;
		default: month = 'Dec';
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
		case  0: month = 'Jan';
		   break;
		case  1: month = 'Feb';
		   break;
		case  2: month = 'Mar';
		   break;
	    case  3: month = 'Apr';
		   break;
		case  4: month = 'May';
		   break;
		case  5: month = 'Jun';
		   break;
		case  6: month = 'Jul';
		   break;
		case  7: month = 'Aug';
		   break;
		case  8: month = 'Sep';
		   break;
		case  9: month = 'Oct';
		   break;
		case 10: month = 'Nov';
		   break;
		default: month = 'Dec';
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
		case  0: month = 'Jan';
		   break;
		case  1: month = 'Feb';
		   break;
		case  2: month = 'Mar';
		   break;
	    case  3: month = 'Apr';
		   break;
		case  4: month = 'May';
		   break;
		case  5: month = 'Jun';
		   break;
		case  6: month = 'Jul';
		   break;
		case  7: month = 'Aug';
		   break;
		case  8: month = 'Sep';
		   break;
		case  9: month = 'Oct';
		   break;
		case 10: month = 'Nov';
		   break;
		default: month = 'Dec';
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
		case  0: month = 'Jan';
		   break;
		case  1: month = 'Feb';
		   break;
		case  2: month = 'Mar';
		   break;
	    case  3: month = 'Apr';
		   break;
		case  4: month = 'May';
		   break;
		case  5: month = 'Jun';
		   break;
		case  6: month = 'Jul';
		   break;
		case  7: month = 'Aug';
		   break;
		case  8: month = 'Sep';
		   break;
		case  9: month = 'Oct';
		   break;
		case 10: month = 'Nov';
		   break;
		default: month = 'Dec';
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
		case  0: month = 'Jan';
		   break;
		case  1: month = 'Feb';
		   break;
		case  2: month = 'Mar';
		   break;
	    case  3: month = 'Apr';
		   break;
		case  4: month = 'May';
		   break;
		case  5: month = 'Jun';
		   break;
		case  6: month = 'Jul';
		   break;
		case  7: month = 'Aug';
		   break;
		case  8: month = 'Sep';
		   break;
		case  9: month = 'Oct';
		   break;
		case 10: month = 'Nov';
		   break;
		default: month = 'Dec';
		   break;	
	}
	
	dateString = month + ' ' + date.getDate() + ', ' + date.getFullYear();
	$(".datePicker").val(dateString);	
	
	$('#clear').click();
	
}); // End Friday

}); // End document