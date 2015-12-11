jQuery(window).load(function(){

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
  var container = $('.gallery-items');
=======
    function onResize() { }
>>>>>>> parent of 6d3029d... not working
    
    jQuery(window).resize(onResize);
    onResize();
  
});

<<<<<<< HEAD
/*
var DEMO = (function( jQuery ) {
  'use strict';

  var jQuerygrid = jQuery('#grid'),
      jQueryfilterOptions = jQuery('.filter-options'),
      jQuerysizer = jQuerygrid.find('.shuffle__sizer'),

  init = function() {


    // None of these need to be executed synchronously
    setTimeout(function() {
      listen();
      setupFilters();
      setupSorting();
      setupSearching();
    }, 100);

    // You can subscribe to custom events.
    // shrink, shrunk, filter, filtered, sorted, load, done
    jQuerygrid.on('loading.shuffle done.shuffle shrink.shuffle shrunk.shuffle filter.shuffle filtered.shuffle sorted.shuffle layout.shuffle', function(evt, shuffle) {
      // Make sure the browser has a console
      if ( window.console && window.console.log && typeof window.console.log === 'function' ) {
        console.log( 'Shuffle:', evt.type );
      }
    });

    // instantiate the plugin
    jQuerygrid.shuffle({
      itemSelector: '.picture-item',
      sizer: jQuerysizer
=======
    var grid = jQuery( '.items' );
    var filterOptions = jQuery('.filter-options');
    var btns = filterOptions.children();
        
    grid.imagesLoaded( function() {
        grid.shuffle({
            itemSelector:'.dportfolio-item',
            gutterWidth: 30,
            delimeter:','
        });   
>>>>>>> parent of 735c7e8... resolves #11
    });

    // Destroy it! o_O
    // jQuerygrid.shuffle('destroy');
  },

<<<<<<< HEAD
  // Set up button clicks
  setupFilters = function() {
    var jQuerybtns = jQueryfilterOptions.children();
    jQuerybtns.on('click', function() {
      var jQuerythis = jQuery(this),
          isActive = jQuerythis.hasClass( 'active' ),
          group = isActive ? 'all' : jQuerythis.data('group');

      // Hide current label, show current label in title
      if ( !isActive ) {
        jQuery('.filter-options .active').removeClass('active');
      }

      jQuerythis.toggleClass('active');
=======
        var jQuerythis = jQuery(this),
        isActive = jQuerythis.hasClass( 'active' ),
        group = isActive ? 'all' : jQuerythis.data('group');

        if ( !isActive ) { jQuery('.filter-options .active').removeClass('active'); }

        jQuerythis.toggleClass('active');
        grid.shuffle( 'shuffle', jQuery(this).data('group') );
>>>>>>> parent of 735c7e8... resolves #11
=======
jQuery(document).ready(function($) {
>>>>>>> parent of 6d3029d... not working

    var grid = $( '.dportfolio-items' );
    var filterOptions = $('.filter-options');
=======
    var grid = jQuery( '.items' );
    var filterOptions = jQuery('.filter-options');
>>>>>>> parent of 735c7e8... resolves #11
    var btns = filterOptions.children();
        
    grid.imagesLoaded( function() {
        grid.shuffle({
            itemSelector:'.dportfolio-item',
            gutterWidth: 30,
            delimeter:','
        });   
    });

<<<<<<< HEAD
<<<<<<< HEAD
    jQuerybtns = null;
  },

  setupSorting = function() {
    // Sorting options
    jQuery('.sort-options').on('change', function() {
      var sort = this.value,
          opts = {};
=======
    btns.on('click', function() {
>>>>>>> parent of 6d3029d... not working

        var jQuerythis = jQuery(this),
        isActive = jQuerythis.hasClass( 'active' ),
        group = isActive ? 'all' : jQuerythis.data('group');

        if ( !isActive ) { jQuery('.filter-options .active').removeClass('active'); }

        jQuerythis.toggleClass('active');
        grid.shuffle( 'shuffle', jQuery(this).data('group') );

    });

<<<<<<< HEAD
<<<<<<< HEAD
      // Image already loaded
      if ( this.complete && this.naturalWidth !== undefined ) {
        return;
      }

      // If none of the checks above matched, simulate loading on detached element.
      proxyImage = new Image();
      jQuery( proxyImage ).on('load', function() {
        jQuery(this).off('load');
        debouncedLayout();
      });

      proxyImage.src = this.src;
=======
=======
>>>>>>> parent of 735c7e8... resolves #11
    function onResize() {
      
    }
    
    jQuery(window).resize(onResize);
    onResize();
  
});

jQuery(document).ready(function($) {



<<<<<<< HEAD
=======
>>>>>>> parent of 6d3029d... not working
=======
>>>>>>> parent of 735c7e8... resolves #11
    // gallery (uses default masonry)     
    /*
    var container = $('.gallery-items');
      
    container.imagesLoaded( function() {
        container.masonry({"gutter": 25});
<<<<<<< HEAD
>>>>>>> parent of 735c7e8... resolves #11
=======
>>>>>>> parent of 6d3029d... not working
    });
    */

});