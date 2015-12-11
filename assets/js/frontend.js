jQuery(document).ready(function($) {

  var grid = $( '.dportfolio-items' );
  var filterOptions = $('.filter-options');
  var btns = filterOptions.children();
      
  grid.imagesLoaded( function() {
      grid.shuffle({
          itemSelector:'.dportfolio-item',
          gutterWidth: 30,
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

  var container = $('.gallery-items');
    
  container.imagesLoaded( function() {
      container.masonry({"gutter": 25});
  });

});