// Mailing List 
$(document).ready(function(){

// Submit Button
$('#submit').live('click', function(event){

	event.preventDefault();
	
	// New values
	var phone 			  = $('#phone').val();
	var aPhone			  = $('#aphone').val();
	var fName 			  = $('#fName').val();
	var lName 			  = $('#lName').val();
	var street 			  = $('#street').val();
	var city 			  = $('#city').val();
	var state 			  = $('#state').val();
	var zip 			  = $('#zip').val();
	var email 			  = $('#email').val();
	var donation		  = $('#donation').val();
	var route			  = $('#route').val();
	var date 			  = $('#date').val();
	
	// Check if fields are filled out
	if(fName == '')
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'A first name is required in order to process donation',
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
			content : 'A last name is required in order to process donation',
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
			content : 'An address is required in order to process donation',
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
			content : 'A city is required in order to process donation',
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
			content : 'A state is required in order to process donation',
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
			content : 'A zip is required in order to process donation',
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
	} else if(date == '')
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'A date is required in order to process donation',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});		
	} else if(donation == '')
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'Donation information is required in order to process donation',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});		
	} else
	{
		// Add dashes to phone numbers
		if(phone != '' && phone.indexOf('-') < 0)
		{
			phone = phone.substring(0,3) + '-' + phone.substring(3,6) + '-' + phone.substring(6,10);	
		}
		
		if(aPhone != '' && aPhone.indexOf('-') < 0)
		{
			aPhone = aPhone.substring(0,3) + '-' + aPhone.substring(3,6) + '-' + aPhone.substring(6,10);	
		}
		
		// Send info to SQLCommands
		$.post('php/SQLCommands.php',{source: 'updateDonationHistory',
			phone: phone,
			aPhone: aPhone,
			firstName: fName,
			lastName: lName,
			street: street,
			city: city,
			state: state,
			zip: zip,
			email: email,
			route: route,
			donation: donation,
			date: date},
			function(data){
				
				var string = '';
				var icon = 'smile';
				
				// Get string based on return
				if(data == 'changed')
				{
					string = 'The donation has been changed.';
				}
				else if(data == 'failure')
				{
					string = 'There was an error. Please contact your administrator.';
					icon = 'error';
				}
				else
				{
					string = 'The donation was successfully added';
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
	} // End check

}); // End Submit

// Clear button
$('#clear').live('click', function(event){
	
	event.preventDefault();
	
	// clear fields			
	$('#phone').val('');
	$('#aphone').val('');
	$('#fName').val('');
	$('#lName').val('');
	$('#street').val('');
	$('#city').val('');
	$('#state').val('');
	$('#zip').val('');
	$('#email').val('');
	$('#donation').val('');
	$('#route').val('');
	$('#date').val('');
	
}); // End Clear
	
}); // End Mailing List 
