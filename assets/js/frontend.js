jQuery(window).load(function(){

    var grid = jQuery( '.items' );
    var filterOptions = jQuery('.filter-options');
    var btns = filterOptions.children();
        
    grid.imagesLoaded( function() {
        grid.shuffle({
            itemSelector:'.dportfolio-item',
            gutterWidth: 30,
            delimeter:','
        });   
    });

    btns.on('click', function() {

        var jQuerythis = jQuery(this),
        isActive = jQuerythis.hasClass( 'active' ),
        group = isActive ? 'all' : jQuerythis.data('group');

        if ( !isActive ) { jQuery('.filter-options .active').removeClass('active'); }

        jQuerythis.toggleClass('active');
        grid.shuffle( 'shuffle', jQuery(this).data('group') );

    });

    function onResize() {
      
    }
    
    jQuery(window).resize(onResize);
    onResize();
  
});

jQuery(document).ready(function($) {



    // gallery (uses default masonry)     
    /*
    var container = $('.gallery-items');
      
    container.imagesLoaded( function() {
        container.masonry({"gutter": 25});
    });
    */

});