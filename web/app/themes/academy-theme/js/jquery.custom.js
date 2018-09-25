jQuery(window).load(function($){

	'use strict';

/* ==============================================
PAGE LOADER
============================================== */
	
	if(document.getElementById("pageloader")) {
		jQuery(".mid").delay(0).fadeOut();
		jQuery(".outter").delay(0).fadeOut();
		jQuery("#pageloader").delay(300).fadeOut("slow", function() {
			if (typeof startRainySound == 'function') { startRainySound(); }
		});
	}
	
	jQuery("#pageloader").delay(300).fadeOut("slow");

/* ==============================================
FIT VIDEOS
============================================== */
	
    //$(".fit-vids").fitVids();

/* ==============================================
NAVIGATION DROP DOWN MENU
=============================================== */	

	jQuery('.nav-menu-desktop .menu-item-has-children').hover(function() {
	    jQuery(this).find('.dropdown-menu,.sub-menu').first().stop(true, true).fadeIn(250);
	    }, function() {
	    jQuery(this).find('.dropdown-menu,.sub-menu').first().stop(true, true).fadeOut(250)
 	});
 	
 	
// 	jQuery('a.dropdown-toggle, .dropdown-menu a').bind('touchend', function(){
// 	        var href = jQuery(this).attr('href');
// 	        location.href = href;
// 	})
 	jQuery('body').on('touchstart.dropdown', '.dropdown-menu, .work-image', function (e) { e.stopPropagation(); });
 	

/* ==============================================
HOME PAGE IMAGE SLIDER (SUPER SLIDES)
=============================================== */

 	jQuery('.fullscreen-slider , .p-section').superslides({
	 	play: 12000,
	    animation: 'fade',
	    inherit_height_from: window,
    });

/* ==============================================
PROJECT 01 HOME (SUPER SLIDES)
=============================================== */

 	jQuery('#project').superslides({
	 	play: 8000,
	    animation: 'fade',
	    inherit_width_from: window,
	    inherit_height_from: window,
    });

/* ==============================================
FLEX SLIDER FOR HOME TEXTS V1
=============================================== */	
		
    jQuery('.v1 .text-slider').flexslider({
        animation: "slide",
		selector: "ul.home-texts li.slide",
		controlNav: false,
		directionNav: true,
		touch: true, 
		slideshowSpeed: 5000,  
		direction: "vertical",
        start: function(slider){
        	jQuery('body').removeClass('loading'); 
        }
     });

/* ==============================================
FLEX SLIDER FOR HOME TEXTS V2
=============================================== */	
		
    jQuery('.v2 .text-slider').flexslider({
        animation: "fade",
		selector: "ul.home-texts li.slide",
		controlNav: false,
		directionNav: true,
		animationSpeed: 500,
		slideshowSpeed: 5000,  
		direction: "vertical",
        start: function(slider){
        	jQuery('body').removeClass('loading'); 
        }
     });

/* ==============================================
MAGNIFIC POPUP
=============================================== */	
	
	//for single image
	jQuery('.mp-image').each(function() {
		jQuery(this).magnificPopup({type:'image'});
	});
	jQuery('.mp-video, mp-map').each(function() {
		jQuery(this).magnificPopup({type:'iframe'});
	});

	//	for image gallery
	jQuery('.mp-gallery').each(function() { // the containers for all your galleries
	    jQuery(this).magnificPopup({
	        delegate: 'a', // the selector for gallery item
	        type: 'image',
	        fixedContentPos: false,
	        gallery: {
	          enabled:true
	        }
	    });
	}); 

/* ==============================================
PRETTY PHOTO
=============================================== */

	jQuery("a[data-rel^='prettyPhoto']").each(function() {
		jQuery(this).prettyPhoto({
			theme: "light_square",
			default_width: 700,
			default_height: 400,
		});
	});

/* ==============================================
Fit Videos
=============================================== */

     jQuery(".fitvid").fitVids();

/* ==============================================
CUSTOM IMAGE SLIDER
=============================================== */	
		
    jQuery('.custom_slider').flexslider({
        animation: "fade",
		selector: ".image_slider .slide",
		controlNav: true,
		directionNav: true,
		animationSpeed: 500,
		slideshowSpeed: 5000,
		pauseOnHover: true, 
		direction: "vertical",
        start: function(slider){
        	jQuery('body').removeClass('loading'); 
        }
     });

/* ==============================================
FLEX SLIDER FOR PORTFOLIO VERSION
=============================================== */	
		
    jQuery('.inner-portfolio .text-slider').flexslider({
        animation: "fade",
		selector: "ul.texts li.slide",
		controlNav: false,
		directionNav: true,
		slideshowSpeed: 5000,  
		direction: "vertical",
        start: function(slider){
        	jQuery('body').removeClass('loading'); 
        }
     });

/* ==============================================
FLEX SLIDER FOR PORTFOLIO VERSION
=============================================== */	
		
    jQuery('.inner-portfolio .circle-image-slider').flexslider({
        animation: "fade",
		selector: "ul.circle-slider li.slide",
		controlNav: false,
		directionNav: true,
		slideshowSpeed: 5000,  
		direction: "vertical",
        start: function(slider){
        	jQuery('body').removeClass('loading'); 
        }
     });

/* ==============================================
CAROUSEL SLIDER FOR HOME BOXES (V1)
=============================================== */	

    jQuery(".home-boxes").owlCarousel({
    	items : 3,
    	// Responsive Settings
    	itemsDesktop : [1169,3],
		itemsDesktopSmall : [979,2],
		itemsTablet : [600,1],
		itemsTabletSmall : false,
		itemsMobile : [560,1],
		stopOnHover: true,
		// End Responsive Settings
    	slideSpeed : 400
    });

/* ==============================================
CAROUSEL SLIDER FOR TEAM BOXES
=============================================== */	

    jQuery(".team-boxes").owlCarousel({
    	items : 4,
    	// Responsive Settings
    	itemsDesktop : [1169,4],
		itemsDesktopSmall : [1024,3],
		itemsTablet : [640,2],
		itemsTabletSmall : false,
		itemsMobile : [560,1],
		stopOnHover: true,
		// End Responsive Settings
    	slideSpeed : 400
    });
    
    // Modall fix for iOS
    
    jQuery('.member-detail-button').on("touchend", function() {
    
    	var target = jQuery(this).data('target');
    	jQuery(target).addClass('in').css({'display':'block','opacity':'1'});
    	
    });
    
    jQuery('.modal-head .close').on("touchend", function() {
    	
    	var target = jQuery(this).closest('.modal').attr('id');   	
    	jQuery('#'+target).removeClass('in').css({'display':'none','opacity':'0'});
    
    });
    
    

/* ==============================================
CAROUSEL SLIDER FOR CLIENTS
=============================================== */	

    jQuery(".clients").owlCarousel({
    	items : 3,
    	// Responsive Settings
    	itemsDesktop : [1169,3],
		itemsDesktopSmall : [979,3],
		itemsTablet : [768,2],
		itemsTabletSmall : false,
		itemsMobile : [479,1],
		// End Responsive Settings
		mouseDrag : false,
		pagination : true,
		navigation : false,
		touchDrag : true,
		stopOnHover: true,
    	slideSpeed : 400
    });

/* ==============================================
CAROUSEL SLIDER FOR CLIENT LOGOS
=============================================== */	

    jQuery(".logos").owlCarousel({
    	items : 5,
    	// Responsive Settings
    	itemsDesktop : [1169,5],
		itemsDesktopSmall : [979,4],
		itemsTablet : [768,3],
		itemsTabletSmall : false,
		itemsMobile : [479,2],
		// End Responsive Settings
		autoPlay : 8000,
    	slideSpeed : 400
    });

/* ==============================================
FEATURED WORKS SLIDER
=============================================== */	

   jQuery(".vntd-portfolio-carousel .works").owlCarousel({
    	items : 4,
    	// Responsive Settings
    	itemsDesktop : [1169,4],
		itemsDesktopSmall : [1100,3],
		itemsTablet : [960,2],
		itemsMobile : [640,1],
		// End Responsive Settings
		pagination : false,
		navigation : true,
		mouseDrag : false,
    	stopOnHover : true,
    	slideSpeed : 700,
    	paginationSpeed : 900,
    	rewindSpeed : 1100
    });

/* ==============================================
SERVİCES SLIDER
=============================================== */	

    jQuery(".service-boxes").owlCarousel({
    	items : 4,
    	// Responsive Settings
    	itemsDesktop : [1169,4],
		itemsDesktopSmall : [979,3],
		itemsTablet : [768,2],
		itemsTabletSmall : false,
		itemsMobile : [479,1],
		stopOnHover: true,
		// End Responsive Settings
		pagination : false,
		navigation : true,
		mouseDrag : true,
    });

/* ==============================================
FULLSCREEN VIDEO PLAYER
=============================================== */	

jQuery(".player").each(function() {
	jQuery(this).mb_YTPlayer();
});

/* ==============================================
FLEX SLIDER FOR TESTIMONIALS
=============================================== */	
		
    jQuery('.testimonials').flexslider({
        animation: "fade",
		selector: "ul.text-slider li.text",
		controlNav: false,
		directionNav: true ,
		slideshowSpeed: 5000,  
        start: function(slider){
        	jQuery('body').removeClass('loading'); 
        }
     });
     
     var $wpAdminBar = jQuery('#wpadminbar');
     if ($wpAdminBar.length) {
     	jQuery("#navigation-sticky").sticky({topSpacing:$wpAdminBar.height()});
     } else {
     	jQuery("#navigation-sticky").sticky({topSpacing:0});
 	 } 

/* ==============================================
SOFT SCROLL EFFECT FOR NAVIGATION LINKS
=============================================== */	
	var $iterator = 0;
	
	jQuery('.nav-menu-desktop a,.scroll,.ex-link a,a.ex-link,.slide-button,.page-numbers').bind('click', function(event) {
	
		if(jQuery(this).hasClass('ex-link') && document.getElementById("pageloader") || jQuery(this).closest('li').hasClass('ex-link') && document.getElementById("pageloader")) {
			if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

				jQuery('.mbYTP_wrapper').addClass('mobile-bg');
				jQuery('section , div').addClass('b-scroll');
				jQuery('.animated').addClass('visible');
				
			}
			else{
				//if (jQuery.browser.mozilla) {}
				//else if (jQuery.browser.safari) {}
				//else{
					// Select to link
					
				//}
			}
			var Exlink = this.getAttribute('href');		
			// Fade In Page Loader
				jQuery('#pageloader').fadeIn(350, function(){	
					jQuery(".mid").fadeIn();
					jQuery(".outter").fadeIn();	  
					document.location.href = Exlink;
				});
				return false;
		
		}
		
		var $anchor = jQuery(this);
		var headerH = jQuery('#navigation, #navigation-sticky').outerHeight();
		var extra = 0;
		if($iterator == 0) {
			extra = 67;
		}
		jQuery('html,body').stop().animate({ 
			scrollTop: jQuery($anchor.attr('href')).offset().top + extra - headerH + "px"
		},1200, 'easeInOutExpo');
		event.preventDefault();
		
		$iterator = $iterator+1;
	});


/* ==============================================
NAVIGATION SECTION CHANGEABLE BACKGROUND SCRIPT
=============================================== */

	var menu = jQuery('#navigation');
    jQuery(window).scroll(function () {
        var y = jQuery(this).scrollTop();
        var homeH,z,homeHOffset;
        homeH = homeHOffset = 0;
        if(document.getElementById("first")) {
        	homeH = jQuery('#first').outerHeight();        	      	
        	homeHOffset = jQuery('#first').offset().top; 
        }
        
        var headerH = jQuery('#navigation').outerHeight();
        z = homeHOffset + homeH - headerH;
        if (y >= z) {
            menu.removeClass('first-nav').addClass('second-nav');
        }
        else{
            menu.removeClass('second-nav').addClass('first-nav');
        }
    });
    
   

/* ==============================================
BACK TO TOP BUTTON
=============================================== */	
	
	// hide #back-top first
	jQuery("#back-top").hide();
	
	// fade in #back-top
	jQuery(window).scroll(function () {
		if (jQuery(this).scrollTop() > 500) {
			jQuery('#back-top').fadeIn();
		} else {
			jQuery('#back-top').fadeOut();
		}
	});

/* ==============================================
WHAT WE DO EFFECTS
=============================================== */

	var $containerFirst = jQuery('.w-items');

		$containerFirst.isotope({
			resizable: false, 
			//masonry: { columnWidth: $containerFirst.width() / 5 },
			itemSelector : '.w-item' ,
			hiddenStyle: { opacity: 0, },
			visibleStyle: { opacity: 1,},			
			transformsEnabled: false,
		});

	    var $optionSets = jQuery('#w-options .w-option-set'),
	          $optionLinks = $optionSets.find('a');
	          
	          
			  var first_tab = jQuery('#w-options .w-option-set li:first-child a').attr('data-option-value');
	          // Your First Selected Item
	          $containerFirst.isotope({ filter: first_tab });

	    $optionLinks.click(function(){
	        var $this = jQuery(this);

	        // don't proceed if already selected
	        if ( $this.hasClass('selected') ) {
	          return false;
	        }
	        var $optionSet = $this.parents('.w-option-set');
	        $optionSet.find('.selected').removeClass('selected');
	        $this.addClass('selected');

	        // make option object dynamically, i.e. { filter: '.my-filter-class' }
	        var options = {},
	            key = $optionSet.attr('data-option-key'),
	            value = $this.attr('data-option-value');
	        // parse 'false' as false boolean
	        value = value === 'false' ? false : value;
	        options[ key ] = value;
	        if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
	          // changes in layout modes need extra logic
	          changeLayoutMode( $this, options )
	        } else {
	          // otherwise, apply new options
	          $containerFirst.isotope( options );
	        }
	        
	        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
	        	var wItemsTop = jQuery('.w-items').offset().top;
	        	
	        	var headerHH = jQuery('#navigation, #navigation-sticky').outerHeight();
	        	
	        	var AdminBarHH = 0;
	        	
	        	if (jQuery('#wpadminbar').length) {
	        		var AdminBarHH = jQuery('#wpadminbar').height();
	        	}
	        	 
	        	jQuery('html,body').stop().animate({ 
	        		scrollTop: wItemsTop - headerHH - AdminBarHH - 20 + "px"
	        	},600, 'easeInOutExpo');
	        }
	        
	        return false;
	    });
	    
	    jQuery(window).resize(function () {
			if(jQuery('.w-items').length) {
				jQuery('.w-items').isotope('reLayout');
			}
				    	
	    });


/* ==============================================
PORTFOLIO ITEMS
=============================================== */

		var $container = jQuery('.portfolio-items');

			$container.isotope({
				//masonry: { columnWidth: $container.width() / 5 },
				itemSelector : '.item' 
			});
		      
		    var $optionSets = jQuery('#options .option-set'),
		          $optionLinks = $optionSets.find('a');

		    $optionLinks.click(function(){
		        var $this = jQuery(this);

		        // don't proceed if already selected
		        if ( $this.hasClass('selected') ) {
		          return false;
		        }
		        var $optionSet = $this.parents('.option-set');
		        $optionSet.find('.selected').removeClass('selected');
		        $this.addClass('selected');
		  
		        // make option object dynamically, i.e. { filter: '.my-filter-class' }
		        var options = {},
		            key = $optionSet.attr('data-option-key'),
		            value = $this.attr('data-option-value');
		        // parse 'false' as false boolean
		        value = value === 'false' ? false : value;
		        options[ key ] = value;
		        if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
		          // changes in layout modes need extra logic
		          changeLayoutMode( $this, options )
		        } else {
		          // otherwise, apply new options
		          $container.isotope( options );
		        }
		        
		        return false;
		    });



 }); // END FUNCTION

/* ==============================================
PARALLAX CALLING
=============================================== */

	( function ( $ ) {
		'use strict';
		jQuery(document).ready(function(){
		
		jQuery('.panel-group .panel:first-child').find('.panel-collapse').addClass('in');
		
		jQuery('.tab-content  .tab-pane:first-child').addClass('active in');
		
		jQuery(window).bind('load', function () {
				parallaxInit();						  
			});
			function parallaxInit() {
				testMobile = isMobile.any();
				if (testMobile == null)
				{
					//Parallax Classes
					jQuery('body .parallax').each(function() {
						jQuery(this).parallax("50%", 0.5);
					});
				}
			}	
			parallaxInit();	 
		});	
		//Mobile Detect
		var testMobile;
		var isMobile = {
		    Android: function() {
		        return navigator.userAgent.match(/Android/i);
		    },
		    BlackBerry: function() {
		        return navigator.userAgent.match(/BlackBerry/i);
		    },
		    iOS: function() {
		        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		    },
		    Opera: function() {
		        return navigator.userAgent.match(/Opera Mini/i);
		    },
		    Windows: function() {
		        return navigator.userAgent.match(/IEMobile/i);
		    },
		    any: function() {
		        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		    }
		};
	}( jQuery ));

/* ==============================================
COUNT FACTORS
=============================================== */	
  
	jQuery(function() {
		
		jQuery(".fact").appear(function(){
			jQuery('.fact').each(function(){
		       	dataperc = jQuery(this).attr('data-perc'),
				jQuery(this).find('.factor').delay(6000).countTo({
			        from: 0,
			        to: dataperc,
			        speed: 3000,
			        refreshInterval: 50,
	            
        		});  
			});
		});
	});
 
(function($) {
    $.fn.countTo = function(options) {
        // merge the default plugin settings with the custom options
        options = $.extend({}, $.fn.countTo.defaults, options || {});

        // how many times to update the value, and how much to increment the value on each update
        var loops = Math.ceil(options.speed / options.refreshInterval),
            increment = (options.to - options.from) / loops;

        return jQuery(this).each(function() {
            var _this = this,
                loopCount = 0,
                value = options.from,
                interval = setInterval(updateTimer, options.refreshInterval);

            function updateTimer() {
                value += increment;
                loopCount++;
                jQuery(_this).html(value.toFixed(options.decimals));

                if (typeof(options.onUpdate) == 'function') {
                    options.onUpdate.call(_this, value);
                }

                if (loopCount >= loops) {
                    clearInterval(interval);
                    value = options.to;

                    if (typeof(options.onComplete) == 'function') {
                        options.onComplete.call(_this, value);
                    }
                }
            }
        });
    };

    $.fn.countTo.defaults = {
        from: 0,  // the number the element should start at
        to: 100,  // the number the element should end at
        speed: 1000,  // how long it should take to count between the target numbers
        refreshInterval: 100,  // how often the element should be updated
        decimals: 0,  // the number of decimal places to show
        onUpdate: null,  // callback method for every time the element is updated,
        onComplete: null,  // callback method for when the element finishes updating
    };
})(jQuery);

/* ==============================================
ANIMATED SKILL BARS
=============================================== */
jQuery(window).load(function(){
	
	jQuery('.progress-bar').appear(function(){
		datavl = jQuery(this).attr('data-value'),
		jQuery(this).animate({ "width" : datavl + "%"}, '300');		
	});
	
	jQuery('.modal-right .progress-bar').each(function() {
		datavl = jQuery(this).attr('data-value'),
		jQuery(this).animate({ "width" : datavl + "%"}, '300');	
	});
	
});



	jQuery(window).bind("load",function(){
		
		//alert('loaded');
		
		/* ==============================================
		NAVIGATION SECTION CHANGEABLE BACKGROUND SCRIPT
		=============================================== */
		
		setTimeout(updateScrollSpy, 1000);
//		
//		jQuery('.scroll').each(function () {
//		      var $spy = $(this).scrollspy('refresh')
//		    });
	
	});	


function updateScrollSpy() {
    jQuery('body').scrollspy({ 
    	target: '.nav-menu-desktop',
    	offset: 95
    });
}	

//jQuery(window).resize(function () {
//	//alert('hi');
//	updateScrollSpy();
//	jQuery('.scroll').each(function () {
//	      var $spy = $(this).scrollspy('refresh')
//	    });
//});




/* ==============================================
MOBILE BACKGROUND FOR VIDEO BACKGROUNDS
=============================================== */

jQuery(window).load(function(){
	'use strict';
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		//jQuery('.mbYTP_wrapper').addClass('mobile-bg');
		
		if ( jQuery('.mbYTP_wrapper').closest('.vc_row').css('background-image') == 'none' ) {
			//console.log("Bg image: " + jQuery('.mbYTP_wrapper').closest('.vc_row').css('background-image') );
			jQuery('.mbYTP_wrapper').addClass('mobile-bg');
			jQuery('.mbYTP_wrapper').remove();
		} else {
			jQuery('.mbYTP_wrapper').remove();
		}
		
		jQuery('section , div').addClass('b-scroll');
		jQuery('.animated').addClass('visible');
		
		if( jQuery('body').hasClass('header-not-sticky-mobile') ) {
			jQuery('.first-nav').removeClass('first-nav').addClass('second-nav');
		}
		
	}
	else{
		if (jQuery.browser.mozilla) {}
		else if (jQuery.browser.safari) {}
		else{
			// Select to link
//			jQuery('a').bind('click',function(){
//				alert('hi');
//				var Exlink = this.getAttribute('href');		
//				// Fade In Page Loader
//		  		jQuery('#pageloader').each(function(){
//		  			jQuery(this).fadeIn(350, function(){		  
//		  			  document.location.href = Exlink;
//		  			});
//		  		});
//			  return false;
//			});
		}

		//ANIMATED ITEMS
	    jQuery('.animated.vntd-animated').appear(function() {
	    	console.log('bla');
		    var elem = jQuery(this);
		    var animation = elem.data('animation');		    
		    if(!animation) {
		    	animation = 'fadeInLeft';
		    }
		    if ( !elem.hasClass('visible') ) {
		    	
		       	var animationDelay = elem.data('animation-delay');
		        if ( animationDelay ) {
		            setTimeout(function(){
		                elem.addClass( animation + " visible" );
		            }, animationDelay);
		        } else {
		            setTimeout(function(){
		                elem.addClass( animation + " visible" );
		            }, 300);
		        }
		    }
		});

	}

}); 

	
jQuery(document).ready(function() {
    
    /* ==============================================
    MOBILE NAV BUTTON
    =============================================== */	
    
    	jQuery( ".mobile-nav-button" ).bind('click',function() {
    		jQuery( ".nav-inner .nav-menu-mobile" ).slideToggle( "medium", function() {
    		// Animation complete.
    		});
    		//jQuery(".nav-inner .nav-menu").css('display','block');
	
    	});
  
    	jQuery('.nav-inner .nav-menu-desktop ul.nav li a').click(function () {
    		if (jQuery(window).width() < 1000) {
    			jQuery(".nav-menu").slideToggle("2000")
    		}
    	});
    	
    	jQuery('.nav-menu-mobile a').bind('click', function(event) {
			var parent = jQuery(this).closest('li');
			//event.preventDefault();

			if( parent.hasClass('menu-item-has-children') && !jQuery(this).attr('data-click-count') ) {
				
				parent.find("> .dropdown-menu,> .sub-menu").slideToggle("medium");
				//jQuery(this).attr('href', '#');	
				jQuery(this).attr( 'data-click-count', 1 );	
				event.preventDefault();
				
			} else {
			 
				if(jQuery(this).hasClass('ex-link') && document.getElementById("pageloader")) {

					var Exlink = this.getAttribute('href');		
					// Fade In Page Loader
						jQuery('#pageloader').fadeIn(350, function(){	
							jQuery(".mid").fadeIn();
							jQuery(".outter").fadeIn();	  
							document.location.href = Exlink;
						});
						return false;
				
				}
			
				var $anchor = jQuery(this);
				var headerH = jQuery('#navigation, #navigation-sticky').outerHeight();
				var extra = 0;
				
				jQuery(this).attr( 'data-click-count', 0 );	
				if( parent.hasClass('menu-item-has-children') ) {
					parent.attr( 'data-click-count', 0 );
				}
				jQuery('html,body').stop().animate({ 
					scrollTop: jQuery($anchor.attr('href')).offset().top + extra - headerH + "px"
				},1200, 'easeInOutExpo');
				event.preventDefault();
				
				//var linkURL = this.getAttribute('href');		
				//document.location.href = linkURL;
				
				if (jQuery(window).width() < 1000) {
					jQuery(".nav-menu-mobile").slideToggle("2000")
				}

			}
					
			
		});
		

});