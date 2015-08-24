jQuery(document).ready(function($){
		
	// grid
	$('#boxes').masonry({
		itemSelector: '.box',
		columnWidth: 210,
		gutterWidth: 40
	});

	$('#related').masonry({
		itemSelector: '.box',
		columnWidth: 210,
		gutterWidth: 40
	});
	
	

});