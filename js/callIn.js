// Mailing List 
$(document).ready(function(){

// Look Up button
$('#phone').live('blur', function(event){
	
	event.preventDefault();
	
	var phone = $('#phone').val();
	
	if(phone.indexOf('-') < 0)
	{
		phone = phone.substring(0,3) + '-' + phone.substring(3,6) + '-' + phone.substring(6,10);	
	}
	
	// Get results from phone number
	$.post('php/SQLCommands.php', {source: 'getByPhone', phone: phone}
		,function(data){$('row', data).each(function(i){
			
			// Get each field from the current row		
			var phone = $(this).find("phone").text();
			var fName = $(this).find("fName").text();
			var lName = $(this).find("lName").text();
			var street = $(this).find("address").text();
			var city = $(this).find("city").text();
			var state = $(this).find("state").text();
			var zip = $(this).find("zip").text();
			var email = $(this).find("email").text();
			var notes = $(this).find("notes").text();
			var locationItems = $(this).find("location").text();
			var driverInstruction = $(this).find("driverInstruction").text();
			var dateCalled = $(this).find("dateCalled").text();
			var operator = $(this).find("operator").text();
			var callType = $(this).find("callType").text();
			var route = $(this).find('route').text();
			var datePickup = $(this).find("datePickup").text();
			var missed = $(this).find("missed").text();
			var endStatus = $(this).find("endStatus").text();
			var type = $(this).find("type").text();
			
			// Populate fields			
			$('#phone').val(phone);
			$('#fName').val(fName);
			$('#lName').val(lName);
			$('#street').val(street);
			$('#city').val(city);
			$('#state option').filter(function() {
				return $(this).val() == state;
			}).attr('selected', true);
			$('#zip').val(zip);
			$('#email').val(email);
			$('#notes').val(notes);
			$('#locationItems').val(locationItems);
			$('#route').val(route);
			$('#driverInstruction').val(driverInstruction);
			$('#date').val(datePickup);
			$('#oldDate').val(datePickup);
			$('#type option').filter(function() {
				return $(this).val() == type;
			}).attr('selected', true);
			
			if(missed == 'true')
				$('#miss').attr('checked', 'checked');
			
		}); // End row results			
	}); // End post
	
}); // End Look Up

	
// Submit Button
$('#submit').live('click', function(event){

	event.preventDefault();
	
	// New values
	var phone 			  = $('#phone').val();
	var fName 			  = $('#fName').val();
	var lName 			  = $('#lName').val();
	var street 			  = $('#street').val();
	var city 			  = $('#city').val();
	var state 			  = $('#state').val();
	var zip 			  = $('#zip').val();
	var email 			  = $('#email').val();
	var notes 			  = $('#notes').val();
	var locationItems 	  = $('#locationItems').val();
	var route			  = $('#route').val();
	var driverInstruction = $('#driverInstruction').val();
	if($('#miss').is(':checked'))
		var miss 		  = 'true';
	else
		var miss	      = 'false';
	var type			  = $('#type option:selected').val();
	var oldDate           = new Date($('#oldDate').val());
	var newDate 	      = new Date($('#date').val());
	var days		      = (newDate - oldDate)/1000/60/60/24;
	newDate  			  = $('#date').val();
	
	if(phone.indexOf('-') < 0 && phone != '')
	{
		phone = phone.substring(0,3) + '-' + phone.substring(3,6) + '-' + phone.substring(6,10);	
	}
	
	// Check if fields are filled out
	if(phone == '')
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'A phone number is required in order to schedule pick-up.',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});
	} else if(fName == '')
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'A first name is required in order to schedule pick-up.',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});		
	} else if(lName == '')
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'A last name is required in order to schedule pick-up.',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});		
	} else if(street == '')
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'An address is required in order to schedule pick-up.',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});		
	} else if(city == '')
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'A city is required in order to schedule pick-up.',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});		
	} else if(state == '')
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'A state is required in order to schedule pick-up.',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});		
	} else if(zip == '')
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'A zip is required in order to schedule pick-up.',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});		
	} else if(route == '')
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'A route is required in order to process donation',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});		
	} else if(newDate == '')
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'A date is required in order to schedule pick-up',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});		
	} else
	{
		// Send info to SQLCommands
	$.post('php/SQLCommands.php',{source: 'updateCallHistory',
			phone: phone,
			firstName: fName,
			lastName: lName,
			street: street,
			city: city,
			state: state,
			zip: zip,
			email: email,
			notes: notes,
			location: locationItems,
			driverInstruction: driverInstruction,
			miss: miss,
			type: type,
			route: route, 
			date: newDate,
			days: days},
			function(data){
				
				var string = '';
				var icon = 'smile';
				
				// Get string based on return
				if(data == 'changed')
				{
					string = 'The pick-up has been changed.';
				}
				else if(data == 'added')
				{
					string = 'The pick-up was successfully scheduled';
				}
				else
				{
					string = 'There was an error. Please contact your administrator.';
					icon = 'error';
				}
				
				// Show error message 
				$.fallr('show', {
					closeKey: true,
					content : string,
					position: 'top',
					width: '300px',
					height: '150px',
					icon    : icon
				});	
				
				if(data != 'failure')
					$('#clear').click();
				
		}); // End post
	}
}); // End Submit

// Clear button
$('#clear').live('click', function(event){
	
	event.preventDefault();
	
	// clear fields			
	$('#phone').val('');
	$('#fName').val('');
	$('#lName').val('');
	$('#street').val('');
	$('#city').val('');
	$('#state').val('');
	$('#zip').val('');
	$('#email').val('');
	$('#notes').val('');
	$('#locationItems').val('');
	$('#route').val('');
	$('#driverInstruction').val('');
	$('#date').val('');
	$('#oldDate').val('');
	$('#miss').removeAttr('checked');
	
}); // End Clear

// Look up button
$('#lookUp').live('click',function(event){
	
	event.preventDefault();
	
	$('#phone').blur();

});
	
}); // End Mailing List 
