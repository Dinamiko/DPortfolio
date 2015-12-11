jQuery(document).ready(function($) {

  // get dportfolio_data 
  var gutter = dportfolio_data.thumbnails_gutter;
  console.log(typeof(gutter))

  var grid = $( '.dportfolio-items' );
  var filterOptions = $('.filter-options');
  var btns = filterOptions.children();
      
  grid.imagesLoaded( function() {
      grid.shuffle({
          itemSelector:'.dportfolio-item',
          gutterWidth: parseInt(gutter),
          delimeter:','
      });   
  });

  btns.on('click', function() {

      var $this = $(this),
      isActive = $this.hasClass( 'active' ),
      group = isActive ? 'all' : $this.data('group');

      if ( !isActive ) { $('.filter-options .active').removeClass('active'); }

      $this.toggleClass('active');
      grid.shuffle( 'shuffle', $(this).data('group') );

  });

  // gallery (uses default masonry)     
  /*
  var container = $('.gallery-items');
    
  container.imagesLoaded( function() {
      container.masonry({"gutter": 25});
  });
  */

});