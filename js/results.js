// Mailing List 
$(document).ready(function(){
	
// Initialize variables
var driverList = '';	
	
// Get drivers/helpers
	$.post("php/SQLCommands.php", {source: 'populateDrivers'},
		function(data){
			$('Driver', data).each(function(i){
			
				// Get each field from the current row		
				var firstName = $(this).find('first').text();
				var lastName = $(this).find('last').text();
				var name = firstName + ' ' + lastName;
				
				driverList = '<option>' + name + '</option>';
				
				$('#driver').append(driverList);
				$('#helper').append(driverList);
				
			}); // End each 
			
		}// End inner function
	); // End .post

// Submit Button
$('#submit').live('click', function(event){

	event.preventDefault();
	
	// New values
	var driver 			  = $('#driver').val();
	var helper			  = $('#helper').val();
	var cloth;
	if($('#clothLB').val() != '')
		cloth 			  = $('#clothLB').val();
	else
		cloth			  = $('#clothCart').val();
	var furn;
	if($('#furnLB').val() != '')
		cloth 			  = $('#furnLB').val();
	else
		furn			  = $('#furnPiece').val();
	var misc;
	if($('#miscLB').val() != '')
		misc 			  = $('#miscLB').val();
	else
		misc			  = $('#miscCart').val();
	var stops 			  = $('#stop').val();
	var avg 			  = $('#avg').val();
	var route 			  = $('#route').val();
	var date 			  = $('#date').val();
	var card 			  = $('#card').val();
	var call		  	  = $('#call').val();
	var notes			  = $('#notes').val();
	
	// Check if fields are filled out
	if(driver == '')
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'A driver is required in order to process route results.',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});		
	} else if(isNaN($('#clothLB').val()) || isNaN($('#clothCart').val()))
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'You did not enter a correct value for Clothing.',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});	
	} else if(isNaN($('#furnLB').val()) || isNaN($('#furnPiece').val()))
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'You did not enter a correct value for Furniture.',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});	
	} else if(isNaN($('#miscLB').val()) || isNaN($('#miscCart').val()))
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'You did not enter a correct value for MISC.',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});	
	} else if(isNaN($('#stop').val()))
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'You did not enter a correct value for Stops.',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});	
	} else if(stops == '')
	{
		// Show error message 
		$.fallr('show', {
			closeKey: true,
			content : 'The number of stops must be entered in order to process route results.',
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
			content : 'The route must be entered in order to process route results.',
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
			content : 'The date must be entered in order to process route results.',
			position: 'top',
			width: '300px',
			height: '150px',
			icon    : 'warning'
		});			
	} else
	{
		
		// Send info to SQLCommands
		$.post('php/SQLCommands.php',{source: 'updateRouteHistory',
			driver: driver,
			helper: helper,
			cloth: cloth,
			furn: furn,
			misc: misc,
			stops: stops,
			avg: avg,
			route: route,
			date: date,
			card: card,
			call: call,
			notes: notes},
			function(data){
				
				var string = '';
				var icon = 'smile';
				
				// Get string based on return
				if(data == 'changed')
				{
					string = 'The route history has been changed.';
				}
				else if(data == 'failure')
				{
					string = 'There was an error. Please contact your administrator.';
					icon = 'error';
				}
				else
				{
					string = 'The route results were successfully added';
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
				
				//if(data != 'failure')
					//$('#clear').click();
				
		}); // End post
	} // End check

}); // End Submit

// Clear button
$('#clear').live('click', function(event){
	
	event.preventDefault();
	
	// clear fields			
	$('#driver').val('');
	$('#helper').val('');
	$('#clothLB').val('');
	$('#clothCart').val('');
	$('#furnLB').val('');
	$('#furnPiece').val('');
	$('#miscLB').val('');
	$('#miscCart').val('');
	$('#stop').val('');
	$('#avg').val('');
	$('#route').val('');
	$('#date').val('');
	$('#card').val('');
	$('#call').val('');
	$('#notes').val('');
	
}); // End Clear

// Calculate average
$('#stop').live('blur',function(event){
	
	var cloth = 0;
	var furn = 0;
	var misc = 0;
	var stops = 0;
	var avg = 0;
	
	// Get LBs
	if($('#clothLB').val() != '' && !isNaN($('#clothLB').val())) {
		cloth += parseFloat($('#clothLB').val());
	}
	else
		cloth += 0;
	if($('#clothCart').val() != '' && !isNaN($('#clothCart').val()))
		cloth += parseFloat($('#clothCart').val()) * 950;
	else
		cloth += 0;
	
	if($('#furnLB').val() != '' && !isNaN($('#furnLB').val()))
		furn += parseFloat($('#furnLB').val());
	else
		furn += 0;
	if($('#furnPiece').val() != '' && !isNaN($('#furnPiece').val()))
		furn += parseFloat($('#furnPiece').val()) * 950;
	else
		furn += 0;
		
	if($('#miscLB').val() != '' && !isNaN($('#miscLB').val()))
		misc += parseFloat($('#miscLB').val());
	else
		misc += 0;
	if($('#miscCart').val() != '' && !isNaN($('#miscCart').val()))
		misc += parseFloat($('#miscCart').val()) * 950;
	else
		misc += 0;
	
	if($('#stop').val() != '' 
	&& (($('#clothLB').val != '' || $('#furnLB').val() != '' || $('#miscLB').val() != '' || !isNaN($('#stop').val()))
	|| ($('#clothCart').val != '' || $('#furnPiece').val() != '' || $('#miscCart').val() != '' || !isNaN($('#stop').val()))))
	{
		stops = parseFloat($('#stop').val());
		avg = (cloth + furn + misc) / stops;
		avg = avg.toFixed(2);
		$('#avg').val(avg + ' lbs');
	} else
		$('#avg').val('');
	
	
}); // End average

// Activate blur action
$('#clothLB').blur(function(){$('#stop').blur();});
$('#furnLB').blur(function(){$('#stop').blur();});
$('#miscLB').blur(function(){$('#stop').blur();});
$('#clothCart').blur(function(){$('#stop').blur();});
$('#furnPiece').blur(function(){$('#stop').blur();});
$('#miscCart').blur(function(){$('#stop').blur();});
	
}); // End Mailing List 
