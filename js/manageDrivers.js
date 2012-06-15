// Begin Scheduled Routes
$(document).ready(function(){

// Table Sorter
$('table').livequery(function(){$(this).tablesorter({widgets: ['zebra']})});

// Initiate iterator
var num = 0;

// Ajax call to get table contents
$.post("php/SQLCommands.php",{source: 'populateDrivers'}, 
		function(data){$('Driver', data).each(function(i){
		
			// Get each field from the current row		
			var firstName = $(this).find('first').text();
			var lastName = $(this).find('last').text();
			var name = firstName + lastName;
			
			// String to add row to table
			var row = '<tr>' +
					  '<td id="' + name + '" class="name">' + lastName + ', ' + firstName + '</td>' +
					  '<td><a class="edit" href="">Edit</a></td>' +
					  '<td><a class="delete" href="">Delete</a></td>' +
					  '</tr>';
					 
			// Add row to table
			$('table').find('tbody').append(row);
			
			// Tell the table to sort the new data
			$('table').trigger('update');
			
			$('table').tablesorter({widgets: ['zebra']});
		});
});

// Add driver
$('#addDriverButton').live('click', function(event){
	
	event.preventDefault();
	
	// Ajax call to get table contents
	$.post("php/SQLCommands.php",{source: 'addDriver', firstName: $('#firstName').val(), lastName: $('#lastName').val()}, 
		function(data){$('Driver', data).each(function(i){
			
			// Update Table
			// Get each field from the current row		
			var firstName = $(this).find('first').text();
			var lastName = $(this).find('last').text();
			var name = firstName + lastName;			
			
			// String for insertion			
			var row = '<tr>' +
					  '<td id="' + name + '" class="name">' + firstName + ' ' + lastName + '</td>' +
					  '<td><a class="edit" href="">Edit</a></td>' +
					  '<td><a class="delete" href="">Delete</a></td>' +
					  '</tr>';
			
			// Perform update
			$('table').find('tbody').append(row);	
			$('table').trigger('update');			
			$('table').tablesorter({widgets: ['zebra']});
		});
		
		// Display message to user
		if(data.indexOf('already added') >= 0)
		{
			// Show message when already in table
			$.fallr('show',{
				closeKey: true,
				content : 'The driver is already in the table',
				icon: 'sad',
				position: 'center',
				useOverlay: false
			}); // End fallr
		} // End message
	}); // End post
}); // End Add driver button
		
// Delete Button
$('.delete').live('click', function(event){

	event.preventDefault();
	
	var name = $(this).parent().parent().find('.name').html();
	    name = name.split(' ');
	var firstName = name[0];
	var lastName = name[1];
	var string = 'Are you sure you want to delete ' + firstName +  ' ' + lastName + '?';

	// Show confirmation 
	$.fallr('show', {
		buttons : {
			button1 : {text: 'Yes', danger: true, onclick: function(){
				
				// Ajax call to delete row
				$.post("php/SQLCommands.php",
				{source: 'deleteDriver', firstName: firstName, lastName: lastName});
				
				// Remove row
				$('table').find('#' + name[0] + name[1]).parent().remove();
				
				// Tell the table to sort the new data
				$('table').trigger('update');				
				$('table').tablesorter({widgets: ['zebra']});
				
				// Close pop-up
				$.fallr('hide');
				
				}},
			button2 : {text: 'No'}
			},
		closeKey: true,
		content : string,
		position: 'center',
		width: '300px',
		height: '150px',
		icon    : 'help'
	});
});

// Map Button
$('.map').live('click', function(event){

	event.preventDefault();
	alert("hello");

});

// Edit Button
$('.edit').live('click', function(event){
	
	event.preventDefault();
	
	// Split the original name into two variables
	var name = $(this).parent().parent().find('.name').text().split(', ');
	var iFirst = name[1];
	var iLast = name[0];

	// String containg form code
	var string = '<p>Enter the driver\'s name change and click "Change". You must enter the full name even if only changing one.</p>'
			   + '<form id="editName">'
			   + '<input id="first" style="margin-right: 5px;" size=15 placeholder="First name" type="text" />'
			   + '<input id="last" size=15 placeholder="Last name" type="text" />'
			   + '</form>';

	// Pop-up window with entry form
	$.fallr('show', {
		buttons: {
			button1: {text: 'Change', onclick: 
				function(){
					// Get values from input fields
					var newFirst = $(this).children('form').find('#first').val();
					var newLast = $(this).children('form').find('#last').val();
					
					if(newFirst != "")
					{
						$.post("php/SQLCommands.php", {source: 'editDriver', firstName: iFirst, lastName: iLast,
								newFirst: newFirst, newLast: newLast});
								
						$('table').find('#' + iFirst + iLast).parent().html('' +
								'<td id="' + newFirst + newLast + '" class="name">' +
								newLast + ', ' + newFirst +
								'</td>' +
								'<td>' +
								'<a class="edit" href="">Edit</a>' +
								'</td>' +
								'<td>' +
								'<a class="delete" href="">Delete</a>' +
								'</td>');
						
						// Tell the table to sort the new data
						$('table').trigger('update');		
						$('table').tablesorter({widgets: ['zebra']});
					}
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
	});
	
});

}); // End Schedule Routes