$(function() {
// Date picker
	$('.datePicker').datepicker({dateFormat: 'MM d, yy'});
	$('.datePicker').css('z-index', 21);
	$('.datePicker').draggable();
});