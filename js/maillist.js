// Mailing List 
$(document).ready(function(){
	
// Click Submit button	
$('#submit').live('click', function(event){

	event.preventDefault();
	
	var type    = $('input[name=type]:checked').val();
	var address = $('#address').val();
	var city    = $('#city').val();
	var state   = $('#state').val();
	var zip     = $('#zip').val();
	
	if(!$('input[name=type]:checked').val())
	{
		// Result to user
		$.fallr('show',{
			closeKey: true,
			content : 'Please select a list to add the address.',
			icon: 'help',
			position: 'center',
			useOverlay: false
		});
	} else if(!$('#address').val())
	{
		// Result to user
		$.fallr('show',{
			closeKey: true,
			content : 'Please enter an address.',
			icon: 'help',
			position: 'center',
			useOverlay: false
		});
	} else if(!$('#city').val())
	{
		// Result to user
		$.fallr('show',{
			closeKey: true,
			content : 'Please enter a city.',
			icon: 'help',
			position: 'center',
			useOverlay: false
		});
	} else if(!$('#state').val())
	{
		// Result to user
		$.fallr('show',{
			closeKey: true,
			content : 'Please select a state.',
			icon: 'help',
			position: 'center',
			useOverlay: false
		});
	} else if(!$('#zip').val())
	{
		// Result to user
		$.fallr('show',{
			closeKey: true,
			content : 'Please enter an zip code.',
			icon: 'help',
			position: 'center',
			useOverlay: false
		});
	} else
	{
		// Post results to maillist.php
		$.post('php/maillist.php',{type:type, address: address, city: city, state: state, zip: zip},function(data){
		
			if (data == 'success' && type == 'add')
			{
				// Result to user
				$.fallr('show',{
					closeKey: true,
					content : 'The address was successfully added to the mailing list.',
					icon: 'smile',
					position: 'center',
					useOverlay: false
				});
			} else if (data == 'success' && type == 'doNot')
			{
				// Result to user
				$.fallr('show',{
					closeKey: true,
					content : 'The address was successfully added to the Do Not Mail List.',
					icon: 'smile',
					position: 'center',
					useOverlay: false
				});
			} else if (data == 'duplicate' && type == 'add')
			{
				// Result to user
				$.fallr('show',{
					closeKey: true,
					content : 'That address is already in the mailing list.',
					icon: 'sad',
					position: 'center',
					useOverlay: false
				});
			} else if (data == 'duplicate' && type == 'doNot')
			{
				// Result to user
				$.fallr('show',{
					closeKey: true,
					content : 'That address is already in the Do Not Mail list.',
					icon: 'sad',
					position: 'center',
					useOverlay: false
				});
			}
		}); // End Post
	}
	
}); // End Submit click

// Click View Do Not Mail button
$('#viewDoNot').live('click', function(event){

	event.preventDefault();
	
	// Get route history
	$.post('php/SQLCommands.php', {source: 'getDoNotMail'},
		function(data){
		
		// Check to see if database has any entries	
		if($(data).find("row").text()){
			
			// Header for table
			var tableText = '<table>' +
							'<thead>' +
							'<tr>' +
							'<th>Address</th>' +
							'<th>City</th>' +
							'<th>State</th>' +
							'<th>Zip</th>' +
							'<th>Date Added</th>' +
							'<th>Added By</th>' +
							'</tr>' +
							'</thead>' +
							'<tbody>';
			
			// Create Table
			var table = $(document.createElement('div'));
			
			// Append header
			table.append(tableText);
			
			// Add sorting
			$(table).find('table').addClass('tablesorter doNotMailTable');
			$('table').tablesorter();
			
			// Table CSS
			table.find('td').css('border', '1px solid black');			
			
			// Populate rows
			$('row', data).each(function(i){
				
				// Get data from database
				var address = $(this).find("address").text();
				var city = $(this).find("city").text();
				var state = $(this).find("state").text();
				var zip = $(this).find("zip").text();
				var dateAdded = $(this).find("dateAdded").text();
				var addedBy = $(this).find("addedBy").text();
				
				// String for table
					table.find('tbody').append(
						'<tr>' +
						'<td>' + address + '</td>' +
						'<td>' + city + '</td>' +
						'<td>' + state + '</td>' +
						'<td>' + zip + '</td>' +
						'<td>' + dateAdded + '</td>' +
						'<td>' + addedBy + '</td>' +
						'</tr>');
						
				// Tell the table to sort the new data
				table.trigger('update');
				table.tablesorter();
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
					content : "There are not addresses in the Do Not Mail List.",
					icon: 'smile'});	
			} // End Condition for entries in database
	}); // End query to database
}); // End Do Not Mail

// Click View Mailing List
$('#viewList').live('click', function(event){

	event.preventDefault();
	
	// Get route history
	$.post('php/SQLCommands.php', {source: 'getMail'},
		function(data){
		
		// Check to see if database has any entries	
		if($(data).find("row").text()){
			
			// Header for table
			var tableText = '<table>' +
							'<thead>' +
							'<tr>' +
							'<th>Address</th>' +
							'<th>City</th>' +
							'<th>State</th>' +
							'<th>Zip</th>' +
							'<th>Date Added</th>' +
							'<th>Added By</th>' +
							'</tr>' +
							'</thead>' +
							'<tbody>';
			
			// Create Table
			var table = $(document.createElement('div'));
			
			// Append header
			table.append(tableText);
			
			// Add sorting
			$(table).find('table').addClass('tablesorter MailTable');
			$('table').tablesorter();
			
			// Table CSS
			table.find('td').css('border', '1px solid black');			
			
			// Populate rows
			$('row', data).each(function(i){
				
				// Get data from database
				var address = $(this).find("address").text();
				var city = $(this).find("city").text();
				var state = $(this).find("state").text();
				var zip = $(this).find("zip").text();
				var dateAdded = $(this).find("dateAdded").text();
				var addedBy = $(this).find("addedBy").text();
				
				// String for table
					table.find('tbody').append(
						'<tr>' +
						'<td>' + address + '</td>' +
						'<td>' + city + '</td>' +
						'<td>' + state + '</td>' +
						'<td>' + zip + '</td>' +
						'<td>' + dateAdded + '</td>' +
						'<td>' + addedBy + '</td>' +
						'</tr>');
						
				// Tell the table to sort the new data
				table.trigger('update');
				table.tablesorter();
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
					content : "There are not addresses in the mailing list.",
					icon: 'sad'});	
			} // End Condition for entries in database
	}); // End query to database
}); // End Mail List
	
}); // End Mailing List 
