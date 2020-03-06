jQuery(function($){
 "use strict";
   jQuery('.main-menu-navigation > ul').superfish({
     delay:       500,                            
     animation:   {opacity:'show',height:'show'},  
     speed:       'fast'                        
   });

});

function resMenu_open() {
	  document.getElementById("menu-sidebar").style.width = "250px";
}
function resMenu_close() {
  document.getElementById("menu-sidebar").style.width = "0";
}

function search_open() {
	jQuery(".serach_outer").animate({width: '100%'});
}
function search_close() {
	jQuery(".serach_outer").animate({width: '0'});
}

(function( $ ) {

  $(window).scroll(function(){
    var sticky = $('.sticky-header'),
      scroll = $(window).scrollTop();
    if (scroll >= 100) sticky.addClass('fixed-header');
    else sticky.removeClass('fixed-header');
  });

  // Back to top
  jQuery(document).ready(function () {
    jQuery(window).scroll(function () {
      if (jQuery(this).scrollTop() > 0) {
        jQuery('.scrollup').fadeIn();
      } else {
        jQuery('.scrollup').fadeOut();
      }
    });
    jQuery('.scrollup').click(function () {
      jQuery("html, body").animate({
        scrollTop: 0
      }, 600);
      return false;
    });
  });

})( jQuery );