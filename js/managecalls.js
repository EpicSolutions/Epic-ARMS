// Manage Calls
$(document).ready(function(){

// Table Sorter
$('table').livequery(function(){$(this).tablesorter({widgets: ['zebra']})});

// Once Search clicked
$('#submit').live('click', function(event){
	
	event.preventDefault();
	
	// Form values
	var key = $('#key').val();
	var field = $('#field option:selected').val();
	var method = $('#method option:selected').val();

	// Clear table
	$('#callTable').find('tbody').html('');
	
	// Initiate iterator
	var num = 0;
	
	// Ajax call to get table contents
	$.post("php/search.php",{key: key, field: field, method: method} 
			,function(data){$('row', data).each(function(i){
		
				// Get each field from the current row		
				var name    		  = $(this).find("name").text();
				var phone   		  = $(this).find("phone").text();
				var address 		  = $(this).find("address").text();
				var city    		  = $(this).find("city").text();
				var state   		  = $(this).find("state").text();
				var zip     		  = $(this).find("zip").text();
				var email  		      = $(this).find("email").text();
				var notes   		  = $(this).find("notes").text();
				var location		  = $(this).find("location");
				var driverInstruction = $(this).find("driverInstruction");
				var dateCalled        = $(this).find("dateCalled").text();
				var operator 		  = $(this).find("operator").text();
				var route   		  = $(this).find("route").text();
				var type    		  = $(this).find("type").text();
				var date   		      = $(this).find("date").text();
				var missed 			  = $(this).find("missed").text();
				var status 			  = $(this).find("status").text();
				
				if($(this).find("result").text() != "No Results")
				{
					// String to add row to table
					var row = '<tr>' +
							  '<td class="name">'    + name    + '</td>' +
							  '<td class="phone">'   + phone   + '</td>' +
							  '<td class="city">'    + city    + '</td>' +
							  '<td class="zip">'     + zip     + '</td>' +
							  '<td class="route">'   + route   + '</td>' +
							  '<td class="date">'    + date    + '</td>' +
							  '<td class="details"><a href="">Edit</a></td>' +
							  '<td class="delete"><a href="">Delete</a></td>' +
							  '</tr>';
							 
					// Add row to table
					$('#callTable').find('tbody').append(row);
					
					// Tell the table to sort the new data
					$('#scheduleTable').trigger('update');
					
					$('#scheduleTable').tablesorter({widgets: ['zebra']});
				} else
				{
					// Show error message 
					$.fallr('show', {
						closeKey: true,
						content : "No results were found. Please try again.",
						position: 'top',
						width: '300px',
						height: '150px',
						icon    : 'sad'
					});	
				} 
			}); 
	}); 
		
});


// Delete Button
$('.delete').live('click', function(event){

	event.preventDefault();
	
	var phone = $(this).parent().parent().find('.phone').html();
	var date = $(this).parent().parent().find('.date').html();

	// Show confirmation 
	$.fallr('show', {
		buttons : {
			button1 : {text: 'Yes', danger: true, onclick: function(){
				
				// Ajax call to delete row
				$.post("php/SQLCommands.php",
				{source: 'deleteCallHistory', date: date, phone: phone});
				
				// Tell the table to sort the new data
				$('#submit').click();
				
				$.fallr('hide');
				}},
			button2 : {text: 'No'}
			},
		closeKey: true,
		content : "Do you want to delete this row?",
		position: 'center',
		width: '300px',
		height: '150px',
		icon    : 'help'
	}); 
});

// Details Button
$('.details').live('click', function(event){

	event.preventDefault();
	
	var phone = $(this).parent().find('.phone').html();
	var date = $(this).parent().find('.date').html();

	// Ajax call to get table contents
	$.post("php/SQLCommands.php",{source: 'getCallRow', phone: phone, date: date} 
		,function(data){$('row', data).each(function(i){
			
			// Get each field from the current row		
			var name    		  = $(this).find("name").text();
			var phone   		  = $(this).find("phone").text();
			var address 		  = $(this).find("address").text();
			var city    		  = $(this).find("city").text();
			var state   		  = $(this).find("state").text();
			var zip     		  = $(this).find("zip").text();
			var email  		      = $(this).find("email").text();
			var notes   		  = $(this).find("notes").text();
			var location		  = $(this).find("location").text();
			var driverInstruction = $(this).find("driverInstruction").text();
			var dateCalled        = $(this).find("dateCalled").text();
			var operator 		  = $(this).find("operator").text();
			var route   		  = $(this).find("route").text();
			var type    		  = $(this).find("type").text();
			var datePickup        = $(this).find("datePickup").text();
			var missed 			  = $(this).find("missed").text();
			var status 			  = $(this).find("status").text();
			var id				  = $(this).find("id").text();
			
			var string = '<form id="detailForm">' +
						 '<input type="hidden" id="id" value="' + id + '" />' +
						 '<input type="hidden" id="missedVal" value="' + missed + '" />' +
						 '<p style="margin-bottom: 20px;">' +
						  		'Name:' +
								'<input type="text" id="name" style="color: black;" value="' + name + '" />' +
						 '</p>' +
						 '<p style="margin-bottom: 20px;">' +
						  		'Phone Number:' +
								'<input type="text" id="phone" style="color: black;" value="' + phone + '" />' +
						 '</p>' +
						 '<p style="margin-bottom: 20px;">' +
						  		'Address:' +
								'<input type="text" id="address" style="color: black;" value="' + address + '" />' +
						 '</p>' +
						 '<p style="margin-bottom: 20px;">' +
						  		'City,State, Zip:' +
								'<input type="text" id="address2" style="color: black;" value="' + city + ', ' + state + ' ' + zip + '" />' +
						 '</p>' +
						 '<p style="margin-bottom: 20px;">' +
						  		'Email:' +
								'<input type="text" id="email" style="color: black;" value="' + email + '" />' +
						 '</p>' +
						 '<p style="margin-bottom: 20px;">' +
						  		'Notes:' +
								'<input type="text" id="notes" style="color: black;" value="' + notes + '" />' +
						 '</p>' +
						 '<p style="margin-bottom: 20px;">' +
						  		'Location:' +
								'<input type="text" id="location" style="color: black;" value="' + location + '" />' +
						 '</p>' +
						 '<p style="margin-bottom: 20px;">' +
						  		'Driver Instructions:' +
								'<input type="text" id="driverInstruction" style="color: black;" value="' + driverInstruction + '" />' +
						 '</p>' +
						 '<p style="margin-bottom: 20px;">' +
						  		'Date Called:' +
								'<input type="text" id="dateCalled" style="color: black;" value="' + dateCalled + '" />' +
						 '</p>' +
						 '<p style="margin-bottom: 20px;">' +
						  		'Operator:' +
								'<input type="text" id="operator" style="color: black;" value="' + operator + '" />' +
						 '</p>' +
						 '<p style="margin-bottom: 20px;">' +
						  		'Route:' +
								'<input type="text" id="route" style="color: black;" value="' + route + '" />' +
						 '</p>' +
						 '<p style="margin-bottom: 20px;">' +
						  		'Type:' +
								'<input type="text" id="type" style="color: black;" value="' + type + '" />' +
						 '</p>' +
						 '<p style="margin-bottom: 20px;">' +
						  		'Pickup Date:' +
								'<input type="text" id="datePickup" style="color: black;" value="' + datePickup + '" />' +
						 '</p>' +
						 '<p>' +
						  		'Missed:' +
								'<span style="position: relative; left: 110px;">Yes</span>' +
								'<input style="position: relative; width: 10px; left: 120px; margin-right: 0;" type="radio" name="missed" id="missed" value="true">' +
								'<span style="position: relative; left: 130px; margin-right: 0;">No</span>' +
								'<input style="width: 10px; position: relative; left: 140px; margin-left: 0;" type="radio" name="missed" id="missed" value="false">' +
						 '</p>' +
						 '</form>';

			// Show confirmation 
			$.fallr('show', {
				buttons : {
					button1 : {text: 'Update', danger: true, onclick: function(){
						
						// Get each field from the current row		
						var name    		  = $("#name").val();
						var phone   		  = $("#phone").val();
						var address 		  = $("#address").val();
						var address2		  = $('#address2').val();
						var email  		      = $("#email").val();
						var notes   		  = $("#notes").val();
						var location		  = $("#location").val();
						var driverInstruction = $("#driverInstruction").val();
						var dateCalled        = $("#dateCalled").val();
						var operator 		  = $("#operator").val();
						var route   		  = $("#route").val();
						var type    		  = $("#type").val();
						var datePickup        = $("#datePickup").val();
						var missedNew   	  = $("input[@name=missed]:checked").val();
						var id				  = $("#id").val();
						
						var fullName = name.split(" ");
						var firstName = fullName[0];
						var lastName = fullName[1];
						
						 address2 = address2.split(" " );
						 var city = address2[0];
							 city = city.split(',');
							 city = city[0];
						var state = address2[1];
						  var zip = address2[2];
						
						// Ajax call to delete row
						$.post("php/SQLCommands.php",
							{source: 'updateCallRow',
							 firstName: firstName,
							 lastName: lastName,
							 street: address,
							 city: city,
							 state: state,
							 zip: zip, 
							 date: dateCalled, 
							 phone: phone,
							 email: email,
							 notes: notes,
							 location: location,
							 driverInstruction: driverInstruction,
							 operator: operator,
							 route: route,
							 type: type,
							 dateBegin: datePickup,
							 miss: missedNew,
							 id: id
						});
						
						// Tell the table to sort the new data
						$('#submit').click();
						
						$.fallr('hide');
						}},
					button2 : {text: 'Cancel'}
				},
				closeKey: true,
				content : string,
				position: 'center',
				width: '600px',
				height: '630px',
				icon    : 'help'
			}); 
			
			// Populate missed radio button
			var missed = $('#missedVal').val();
			
			$(function() {
				var $radios = $('input:radio[name=missed]');
				if($radios.is(':checked') === false) {
					if(missed == 'true')
						$radios.filter('[value=true]').attr('checked', true);
					else
						$radios.filter('[value=false]').attr('checked', true);
				}
			});	
		
		});
	});
});

}); // End Schedule Routes