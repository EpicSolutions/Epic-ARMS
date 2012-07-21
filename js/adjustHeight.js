$(document).ready(function(){
	
	// Adjust height of holders
	var headerHeight  = parseInt($('.header').css('height'));
	var footerHeight  = parseInt($('.footer').css('height'));
	var wrapperHeight = parseInt($('#wrapper').css('height'));
	var height 		  = wrapperHeight - headerHeight - footerHeight - 25;
	
	$('.controlHolder').css({height: height + 'px'});
	$('.mapHolder').css({height: height + 'px'});
	
	// Adjust map width
	var controlWidth = parseInt($('.controlHolder').css('width'));
	var wrapperWidth = parseInt($('#wrapper').css('width'));
	var width		 = wrapperWidth - controlWidth;
	
	$('.mapHolder').css({width: width + 'px'});	

	$(window).resize(function() {
		// Ajust height of holders
		var headerHeight  = parseInt($('.header').css('height'));
		var footerHeight  = parseInt($('.footer').css('height'));
		var wrapperHeight = parseInt($('#wrapper').css('height'));
		var height 		  = wrapperHeight - headerHeight - footerHeight - 4;
		
		$('.controlHolder').css({height: height + 'px'});
		$('.mapHolder').css({height: height + 'px'});
		
		
		// Adjust map width
		var controlWidth = parseInt($('.controlHolder').css('width'));
		var wrapperWidth = parseInt($('#wrapper').css('width'));
		var width		 = wrapperWidth - controlWidth;
	
		$('.mapHolder').css({width: width + 'px'});
	
	});
});