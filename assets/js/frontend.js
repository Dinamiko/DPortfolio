jQuery(document).ready(function($) {

	function onResize() {

		// checkboxes

		var container = $('#dportfolio-container').imagesLoaded( function() {

		  container.masonry({});

		});

	    container.multipleFilterMasonry({
	    	itemSelector: '.dportfolio-item',
	  		filtersGroupSelector:'.dportfolio-filters'       
	    });

	    // list

		var container_list = $('#dportfolio-container-list').imagesLoaded( function() {

		  container_list.masonry({});

		});
		
		container_list.multipleFilterMasonry({
			itemSelector: '.dportfolio-item-list',
			filtersGroupSelector:'.dportfolio-filters',
			selectorType: 'list'
		});
	
	}
	
	$(window).resize(onResize);
	onResize();

	$( 'input[type="checkbox"]' ).click(function(e) {
			
		if ( $(this).parent().hasClass('dportfolio-active')) {

	 		$(this).parent().removeClass('dportfolio-active');

	   	} else {

	   		$(this).parent().addClass('dportfolio-active');

	   	}
	    
	});
	
});

