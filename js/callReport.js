// Mailing List 
$(document).ready(function(){

// Search Button
$('#submit').live('click', function(event){

	event.preventDefault();
	
	var phone     = $('#phone').val();
	var route     = $('#route').val();
	var fName     = $('#fName').val();
	var lName     = $('#lName').val();
	var street    = $('#street').val();
	var zip       = $('#zip').val();
	var dateBegin = $('#dateBegin').val();
	var dateEnd   = $('#dateEnd').val();
	var result = '';
	
	if(phone.indexOf('-') < 0)
	{
		phone = phone.substring(0,3) + '-' + phone.substring(3,6) + '-' + phone.substring(6,10);	
	}
		
	// Get Call Report data
	$.post("php/SQLCommands.php",{source: 'getCallHistory', route: route, phone: phone, firstName: fName, lastName: lName, street: street
								 , zip: zip, dateBegin: dateBegin, dateEnd: dateEnd},function(data){
		
		//Begin Call Report table
		var row = '<html>' +
				  '<head>' +
				  '<link href="css/CR.css" rel="stylesheet" type="text/css" media="print" />' +
				  '<link href="css/CR.css" rel="stylesheet" type="text/css" media="screen" />' +
				  '</head>' + 
				  '<body><cfoutput><table id="crTable">' +
				  '<thead>' +
			      '<tr class="noBorder"><th colspan="2">Call Report</th></tr>' +
				  '</thead>'; 
		
		$('row', data).each(function(i){
			
			if($(this).find("result").text() != "No History")
			{			
				// Get each field from the current row		
				var phone = $(this).find("phone").text();
				var firstName = $(this).find("firstName").text();
				var lastName = $(this).find("lastName").text();
				var address = $(this).find("address").text();
				var city = $(this).find("city").text();
				var state = $(this).find("state").text();
				var zip = $(this).find("zip").text();
				var email = $(this).find("email").text();
				var notes = $(this).find("notes").text();
				var location = $(this).find("location").text();
				var instruction = $(this).find("instruction").text();
				var dateCalled = $(this).find("dateCalled").text();
				var operator = $(this).find("operator").text();
				var callType = $(this).find("callType").text();
				var missed = $(this).find("missed").text();
				var endStatus = $(this).find("endStatus").text();
				
				// String to add rows to table
				row += '<tr class="start">';
				row += '<th>' + address + ', ' + city + ', ' + state + ' ' + zip +'</th>';
				row += '</tr>';
				row += '<tr>';
				row += '<td class="left">Items Location: ' + location + '</td>';
				row += '<td class="right">' + firstName + ': ' + phone + '</td>';
				row += '</tr>';
				row += '<tr class="end">';
				row += '<td colspan="2">' + notes + '</td>';
				row += '</tr>';
				row += '<tr class="break" style="border: none;"></tr>';
			} else
			{
				// Show error message 
				$.fallr('show', {
					closeKey: true,
					content : "There is no call history for this route.",
					position: 'top',
					width: '300px',
					height: '150px',
					icon    : 'sad'
				});	
				
				result = 'No History';	
			}
			
		});
	
	/*if(result != "No History")
	{	
		row += '</table></cfoutput></body></html>';
		
		var win = window.open('','Call Report');
		win.document.open();
		win.document.write(row);
		win.document.close();
	}*/
	});

}); // End Search
	
}); // End Mailing List 
