// Begin Scheduled Routes
$(document).ready(function(){

// Table Sorter
$('table').livequery(function(){$(this).tablesorter({widgets: ['zebra']})});

// Initiate iterator
var num = 0;

// Ajax call to get table contents
$.post("php/users.php",{source: 'populateUsers'}, 
		function(data){$('User', data).each(function(i){
		
			// Get each field from the current row		
			var uName  = $(this).find('uName').text();
			var track  = $(this).find('track').text();
			var route  = $(this).find('route').text();			
			var report = $(this).find('report').text();
			var admin  = $(this).find('admin').text();
			
			// HTML for each checkbox
			track  = '<input type="checkbox" class="check" id="tracking" disabled value="tracking" ' + track + ' />';
			route  = '<input type="checkbox" class="check" id="route" disabled value="route" ' + route + ' />';
			report = '<input type="checkbox" class="check" id="report" disabled value="report" ' + report + ' />';
			admin  = '<input type="checkbox" class="check" id="admin" disabled value="admin" ' + admin + ' />';
			
			// String for insertion			
			var row = '<tr>' +
					  '<td id="' + uName + '" class="name">' + uName + '</td>' +
					  '<td class="check">' + track + '</td>' +
					  '<td class="check">' + route + '</td>' +
					  '<td class="check">' + report + '</td>' +
					  '<td class="check">' + admin + '</td>' +
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

// Add user
$('#addUserButton').live('click', function(event){
	
	event.preventDefault();
	
	// Ajax call to get table contents
	$.post("php/users.php",
		  {source: 'addUser', uName: $('#uName').val(), pass: $('#pass').val(), 
		   track: $('#tracking').is(':checked'), routeBool: $('#routes').is(':checked'), report: $('#reports').is(':checked'), admin: $('#admin').is(':checked')}, 
		   function(data){$('User', data).each(function(i){
			
			// Update Table
			// Get each field from the current row		
			var uName  = $(this).find('uName').text();
			var track  = $(this).find('track').text();
			var route  = $(this).find('route').text();			
			var report = $(this).find('report').text();
			var admin  = $(this).find('admin').text();
			
			// HTML for each checkbox
			track  = '<input type="checkbox" class="check" disabled id="tracking" value="tracking" ' + track + ' />';
			route  = '<input type="checkbox" class="check" disabled id="route" value="route" ' + route + ' />';
			report = '<input type="checkbox" class="check" disabled id="report" value="report" ' + report + ' />';
			admin  = '<input type="checkbox" class="check" disabled id="admin" value="admin" ' + admin + ' />';
			
			// String for insertion			
			var row = '<tr>' +
					  '<td id="' + uName + '" class="name">' + uName + '</td>' +
					  '<td class="check">' + track + '</td>' +
					  '<td class="check">' + route + '</td>' +
					  '<td class="check">' + report + '</td>' +
					  '<td class="check">' + admin + '</td>' +
					  '<td><a class="edit" href="">Edit</a></td>' +
					  '<td><a class="delete" href="">Delete</a></td>' +
					  '</tr>';
			
			// Add row to table
			$('table').find('tbody').append(row);
			
			// Tell the table to sort the new data
			$('table').trigger('update');
			
			$('table').tablesorter({widgets: ['zebra']});
		});
		
		// Display message to user
		if(data.indexOf('already added') >= 0)
		{
			// Show message when already in table
			$.fallr('show',{
				closeKey: true,
				content : 'That username is already taken',
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
	
	var uName = $(this).parent().parent().find('.name').html();
	var string = 'Are you sure you want to delete ' + uName + '?';

	// Show confirmation 
	$.fallr('show', {
		buttons : {
			button1 : {text: 'Yes', danger: true, onclick: function(){
				
				// Ajax call to delete row
				$.post("php/users.php",
				{source: 'deleteUser', uName: uName});
				
				// Remove row
				$('table').find('#' + uName).parent().remove();
				
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

// Edit Button
$('.edit').live('click', function(event){
	
	event.preventDefault();
	
	// Split the original name into two variables
	var uName = $(this).parent().parent().find('.name').text();
	var pass, track, route, report, admin;
	
	// Get current data
	// Ajax call to get table contents
	$.post("php/users.php",{source: 'populateUsers'}, 
		function(data){$('User', data).each(function(i){
	
		var uName2  = $(this).find('uName').text();
		var pass2   = $(this).find('pass').text();
		var track2  = $(this).find('track').text();
		var route2  = $(this).find('route').text();
		var report2 = $(this).find('report').text();
		var admin2  = $(this).find('admin').text();
		
		
		if (uName == uName2)
		{
			pass   = pass2;
			track  = track2;
			route  = route2;
			report = report2;
			admin  = admin2;

		// String containg form code
		var string = '<p>Please make the changes you would like for ' + uName + '.'
				   + '<form id="changeUser">'
				   + 'Username: <input style="margin-right: 10px;" size=10 id="newName" name="newName" type="text" value="' + uName + '" />'
				   + 'Password: <input id="pass" name="pass" size=10 type="text" value="' + pass + '" />'
				   + '<span style="margin-right: 10px; float: left; margin-top: 10px;">Permissions:</span>'
				   + '<div class="userCheck" style="margin-right: 20px;">Tracking<br /><input type="checkbox" id="trackingPop" value="tracking" ' + track + ' /></div>'
				   + '<div class="userCheck" style="margin-right: 20px;">Routes<br /><input type="checkbox" id="routesPop" value="routes" ' + route + ' /></div>'
				   + '<div class="userCheck" style="margin-right: 20px;">Reports<br /><input type="checkbox" id="reportsPop" value="reports" ' + report + ' /></div>'
				   + '<div class="userCheck">Admin<br /><input type="checkbox" id="adminPop" value="admin" ' + admin + ' /></div>'
				   + '</form>';

		// Pop-up window with entry form
		$.fallr('show', {
			buttons: {
				button1: {text: 'Change', onclick: 
					function(){
						
						// Get values from input fields
						var newName = $(this).children('form').find('#newName').val();
						pass = $(this).children('form').find('#pass').val();
						track = $(this).children('form').find('#trackingPop').val();
						route = $(this).children('form').find('#routesPop').val();
						report = $(this).children('form').find('#reportsPop').val();
						admin = $(this).children('form').find('#adminPop').val();
						
						if(newName != "" && pass != "")
						{
							$.post("php/users.php", {source  : 'editUser', 
														   uName   : uName,
														   newName : newName, 
														   pass    : pass, 
														   track: $('#trackingPop').is(':checked'), 
														   routeBool: $('#routesPop').is(':checked'), 
														   report: $('#reportsPop').is(':checked'), 
														   admin: $('#adminPop').is(':checked')}
							);
							
							// Change check values
							if ($('#trackingPop').is(':checked'))
								track = 'checked="checked"';
							else
								track = '';
								
							if ($('#routesPop').is(':checked'))
								route = 'checked="checked"';
							else
								route = '';
								
							if ($('#reportsPop').is(':checked'))
								report = 'checked="checked"';
							else
								report = '';
							
							if ($('#adminPop').is(':checked'))
								admin = 'checked="checked"';
							else
								$admin = '';
									
							$('table').find('#' + uName).parent().html('' +
									'<td id="' + newName + '" class="name">' + 
										newName + 
									'</td>' +
									'<td class="check">' +
										'<input style="text-align: center;" type="checkbox" class="check" disabled id="tracking" value="tracking" ' + track + ' />' +
									'</td>' +
									'<td class="check">' +
										'<input type="checkbox" class="check" disabled id="route" value="route" ' + route + ' />' +
									'</td>' +
									'<td class="check">' +
										'<input type="checkbox" class="check" disabled id="report" value="report" ' + report + ' />' +
									'</td>' +
									'<td class="check">' +
										'<input type="checkbox" class="check" disabled id="admin" value="admin" ' + admin + ' />' +
									'</td>' +
									'<td><a class="edit" href="">Edit</a></td>' +
					  				'<td><a class="delete" href="">Delete</a></td>'
									);
							
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
			width    : '500px',
			height   : '250px',
			icon     : 'card'
		});

		// Change on focus
		$('#changeUser').find('input').focus(function(){
				
			$(this).val('');	
		});

		}
		
	}); // End each
	}); // End .post
	
});

// Admin checkbox
$('#admin').live('click', function(){
	
	if($(this).is(':checked'))
	{
		$('#tracking').attr('checked', 'checked');
		$('#routes').attr('checked', 'checked');	
		$('#reports').attr('checked', 'checked');		
	} else
	{
		$('#tracking').removeAttr('checked');
		$('#routes').removeAttr('checked');	
		$('#reports').removeAttr('checked');
	}
}); // End Admin

// AdminPop checkbox
$('#adminPop').live('click', function(){
	
	if($(this).is(':checked'))
	{
		$('#trackingPop').attr('checked', 'checked');
		$('#routesPop').attr('checked', 'checked');	
		$('#reportsPop').attr('checked', 'checked');		
	} else
	{
		$('#trackingPop').removeAttr('checked');
		$('#routesPop').removeAttr('checked');	
		$('#reportsPop').removeAttr('checked');
	}
}); // End Admin

}); // End Schedule Routes