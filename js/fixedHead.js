// Table sorter & fixed header integration
function fixedHead(setWidth, setHeight) {
	$('table').scrollableFixedHeaderTable(setWidth, setHeight, false, 'mycookie');
	$('table').tablesorter().bind('sortEnd', function(){
		var $cloneTH = $('.sfhtHeader thead th');
		var $trueTH = $('.sfhtData thead th');
		$cloneTH.each(function(index){
			$(this).attr('class', $($trueTH[index]).attr('class'));
		});
	});
		
	/* synchronize sortable and scrollable */
	$('.sfhtHeader thead th').each(function(index){
		var $cloneTH = $(this);
		var $trueTH = $($('.sfhtData thead th')[index]);
		$cloneTH.attr('class', $trueTH.attr('class'));
		$cloneTH.click(function(){
			$trueTH.click();
		});
	});
}