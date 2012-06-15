// Manage User

$(document).ready(function(){
	
	// Table Sorter
	$("#userTable").tablesorter({sortList:[[0,0]]});
	
	// Edit User alert window
	
	// Add content to window upon click
	$("#userTable").find("a").click(function(event)
	{
		event.preventDefault();
		
		var user = $(this).parent().parent().find('#user').html();
		var tracking = $(this).parent().parent().find('#tracking').html();
		var routes = $(this).parent().parent().find('#routes').html();
		var reports = $(this).parent().parent().find('#reports').html();
		var admin = $(this).parent().parent().find('#admin').html();
		
		var content = 
		'<table id="userTable" class="tablesorter" cellspacing="0" cellpadding="2">' 
    	+ '<thead>' 
    	+ '<tr>' 
        + '<th>Username</th>' 
        + '<th>Tracking</th>' 
        + '<th>Routes</th>'
        + '<th>Reports</th>'
        + '<th>Admin</th>'
        + '<th></th>'
    	+ '</tr>' 
    	+ '</thead>'
    	+ '<tbody>' 
		+ '<tr>' 
        + '<td id="user">' + user + '</td> '
        + '<td id="tracking">' + tracking + '</td>' 
        + '<td id="routes">' + routes + '</td>' 
        + '<td id="reports">' + reports + '</td>' 
        + '<td id="admin">' + admin + '</td>'
    	+ '</tr>'
		+ '</tbody>' 
    	+ '</table>';
				
		$('#editUser').html(content);
		
		// Show window
		$.fallr('show', {
			content : $('#editUser').html(),
			position: 'center',
			width: '750px',
			height: '1000px',
			icon    : 'help'
		
		});
	});
		
});