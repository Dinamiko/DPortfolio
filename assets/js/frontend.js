jQuery(document).ready(function($) {



  var grid = $( '.portfolio-items' );
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

      console.log(9)

      var $this = $(this),
      isActive = $this.hasClass( 'active' ),
      group = isActive ? 'all' : $this.data('group');

      if ( !isActive ) { $('.filter-options .active').removeClass('active'); }

      $this.toggleClass('active');
      grid.shuffle( 'shuffle', $(this).data('group') );

  });

  /*
  // gallery (uses default masonry)     

  var container = $('.gallery-items');
    
  container.imagesLoaded( function() {
      container.masonry({"gutter": 25});
  });
*/

});

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
    });

    // Destroy it! o_O
    // jQuerygrid.shuffle('destroy');
  },

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

      // Filter elements
      jQuerygrid.shuffle( 'shuffle', group );
    });

    jQuerybtns = null;
  },

  setupSorting = function() {
    // Sorting options
    jQuery('.sort-options').on('change', function() {
      var sort = this.value,
          opts = {};

      // We're given the element wrapped in jQuery
      if ( sort === 'date-created' ) {
        opts = {
          reverse: true,
          by: function(jQueryel) {
            return jQueryel.data('date-created');
          }
        };
      } else if ( sort === 'title' ) {
        opts = {
          by: function(jQueryel) {
            return jQueryel.data('title').toLowerCase();
          }
        };
      }

      // Filter elements
      jQuerygrid.shuffle('sort', opts);
    });
  },

  setupSearching = function() {
    // Advanced filtering
    jQuery('.js-shuffle-search').on('keyup change', function() {
      var val = this.value.toLowerCase();
      jQuerygrid.shuffle('shuffle', function(jQueryel, shuffle) {

        // Only search elements in the current group
        if (shuffle.group !== 'all' && jQuery.inArray(shuffle.group, jQueryel.data('groups')) === -1) {
          return false;
        }

        var text = jQuery.trim( jQueryel.find('.picture-item__title').text() ).toLowerCase();
        return text.indexOf(val) !== -1;
      });
    });
  },

  // Re layout shuffle when images load. This is only needed
  // below 768 pixels because the .picture-item height is auto and therefore
  // the height of the picture-item is dependent on the image
  // I recommend using imagesloaded to determine when an image is loaded
  // but that doesn't support IE7
  listen = function() {
   
    //var debouncedLayout = jQuery.throttle( 300, function() {
      //jQuerygrid.shuffle('update');
    //});


    // Get all images inside shuffle
    jQuerygrid.find('img').each(function() {
      var proxyImage;

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
    });

    
    // Because this method doesn't seem to be perfect.
    //setTimeout(function() {
      //debouncedLayout();
    //}, 500);
    

  };

  return {
    init: init
  };
}( jQuery ));



jQuery(document).ready(function() {
  DEMO.init();
});
*/
