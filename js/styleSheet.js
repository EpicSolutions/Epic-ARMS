//  Change the stylesheet depending on browser
$(document).ready(function(){

jQuery.each(jQuery.browser, function(i, val){

	if(i == 'safari')
		document.getElementById('stylesheet').href = 'css/safariStyle.css';

});

});
