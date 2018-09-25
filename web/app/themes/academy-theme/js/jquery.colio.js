/**
 * Colio - jQuery Portfolio Content Expander Plugin
 * http://plugins.gravitysign.com/colio
 * Copyright (c) 2013 Roman Yurchuk
 * Version 1.2 # 02/12/13
 */
 
 
(function($, undefined) {

	"use strict";

	// Constructor
	// ---------------------------------------------------------------------------
	
	function Colio(list, settings){
		
		// properties
		this.list = $(list);
		this.items = this.list.children();
		this.settings = settings;
		this.position = 0;
		this.active_id = undefined;
		this.lock = false;
		
		// variables
		var self =  this;
		
		// add class to portfolio items
		this.items.addClass('colio-item');
		
		// markup
		this.markup = $('<div class="colio"><div class="colio-wrap colio-inactive"><div class="colio-loader"><i></i></div></div></div>');
		this.markup.find('.colio-wrap').append('<div class="colio-container"></div>');
		if(this.settings.navigation) {
			this.markup.addClass('colio-has-navigation');
			$('<div class="colio-navigation colio-hidden"></div>').
				append('<a class="colio-prev" href="#"></a>').
				append('<a class="colio-next" href="#"></a>').
				appendTo(this.markup.find('.colio-wrap'));
		}
		this.markup.find('.colio-wrap').append('<a class="colio-close colio-hidden" href="#">' + this.settings.closeText + '</a>');
		
		// insert markup into the document
		if(this.settings.placement === 'after' ) {
			this.list.after(this.markup);
		} else if(this.settings.placement === 'inside') {
			this.markup.css({position:'absolute', top:0, left:0});
			$('body').append(this.markup);
		} else if(/^#\w/.test(this.settings.placement)) {
			$(this.settings.placement).append(this.markup);
			this.settings.placement = 'element';
		} else {
			//this.list.before(this.markup);
			//this.settings.placement = 'before';
			
			this.list.closest('.portfolio').find('.vntd-grid-before').before(this.markup);
			this.settings.placement = 'before';
		}
		
		// set id if provided
		if(this.settings.id) {
			this.markup.attr('id', this.settings.id);
		}
		
		// add class that defines colio placement
		this.markup.addClass('colio-placement-' + this.settings.placement);
		
		// add theme class if provided
		if(this.settings.theme) {
			this.markup.addClass('colio-theme-' + this.settings.theme);
		}
								
		// assign click handlers to expand colio viewport
		this.items.find(this.settings.expandLink).click(function(){
		
			
			// save page scroll when expand link was clicked
			//self.page_scroll = $(window).scrollTop();
			
			// expand colio viewport for item
			var item = $(this).closest('.colio-item');
			self.expand(item);
			
									
			return false;
		});
		
		// assign click handler to colio viewport close button
		this.markup.find('.colio-close').click(function(){
		
//		jQuery(this).closest('.colio-wrap').find('iframe')
//		var url = jQuery(this).closest('.colio-wrap').find('iframe').attr('src');
//		jQuery(this).closest('.colio-wrap').find('iframe').attr('src', '');
//		jQuery(this).closest('.colio-wrap').find('iframe').attr('src', url);
		
		//jQuery(".wpb_video_wrapper iframe")
			self.collapse(); 
			return false;
		});
		
		// assign click handlers to previous/next buttons
		this.markup.find('.colio-prev').click(function(){
		
//			jQuery(this).closest('.colio-wrap').find('iframe')
//			var url = jQuery(this).closest('.colio-wrap').find('iframe').attr('src');
//			jQuery(this).closest('.colio-wrap').find('iframe').attr('src', '');
//			jQuery(this).closest('.colio-wrap').find('iframe').attr('src', url);
		
			// check if position is in range
			if(!self.lock && self.position > 0) {	
							
				self.position--;
				self.expand(self.items.eq(self.position));
			}	
			return false;
		
		}).end().find('.colio-next').click(function(){
		
//			jQuery(this).closest('.colio-wrap').find('iframe')
//			var url = jQuery(this).closest('.colio-wrap').find('iframe').attr('src');
//			jQuery(this).closest('.colio-wrap').find('iframe').attr('src', '');
//			jQuery(this).closest('.colio-wrap').find('iframe').attr('src', url);
			
			// check if position is in range
			if(!self.lock && self.position < self.items.length - 1) {
				self.position++;
				self.expand(self.items.eq(self.position));
			}
			return false;
		
		});
		
		// adjust colio viewport height on window resize
		$(window).resize(function(e){
			
			// for 'inside' placement hide viewport immediately
			if(self.settings.placement === 'inside') {
				self.insideHideViewport();
			}
			
			// disable page scroll during window resize
			if(!self.temp) {
				self.temp = [self.settings.syncScroll, self.settings.scrollPage];
			}
			self.settings.syncScroll = true;
			self.settings.scrollPage = false;
			
			// adjust viewport height
			clearTimeout(self.resize_timer);
			self.resize_timer = setTimeout(function(){
				self.expandViewport(self.active_id, true);
				self.settings.syncScroll = self.temp[0];
				self.settings.scrollPage = self.temp[1];
				delete self.temp;
			}, 200);
			
			// stop propagation if colio is event target
			if(e.target === self.markup.get(0)) {
				e.stopImmediatePropagation();
			}
			
		});
		
		// define API methods
		this.api = {
			expand: function(n){
				self.expand(self.items.eq(n));
			},
			collapse: function(){
				self.collapse();
			},
			excludeHidden: function(){
				self.items = self.list.children(':not(' + self.settings.hiddenItems + ')');
				self.position = self.items.index(self.list.find('.colio-active-item'));
				if(self.settings.placement === 'inside') {
					self.insideHideViewport();
				}
			}
		};
		
		// make API methods available via custom event or data of portfolio list
		this.list.data('colio', this.api);
		this.list.bind('colio', function(e, method, param){
			if(self.api.hasOwnProperty(method)) {
				self.api[method](param);
			}
		});
		
	}
	
	
	// Methods
	// ---------------------------------------------------------------------------
	
	
	/**
	* Method to load content and expand viewport for portfolio item
	*/
	
	Colio.prototype.expand = function(item) {
		
		
		// load content from "data-content" attribute
		var content_data = item.data('content');
		var item_title = item.find('.portfolio-grid-title').text()
		;
		// return if locked or "data-content" is not set
		if(this.lock || !content_data) { 
			return; 
		}
		
		// ok, now set lock!
		this.lock = true;
		
		// save item position
		this.position = this.items.index(item);
		
		// for "inside" placement position colio viewport
		if(this.settings.placement === 'inside') {
			this.insidePositionViewport(item);
		}
		
		// check if content is already loaded
		var	content_id = item.data('colio-content-id');
		
		// START EXPANDING
		
		// Hide currently opened modal content
		
		
		$('.colio-loader').fadeIn();
		
			
		// ok, content is loaded
		if(content_id) {
		
			// for "inside" placement make a gap for viewport inside portfolio grid
			if(this.settings.placement === 'inside') {
				this.insideMakeGap(item);
			}
			
			//alert('TEST'+content_id);
			
			var position = $('.portfolio').offset().top;
			
			
			
			(function(content_id) {
				$('body, html').stop().animate({scrollTop: position-90}, 500, function() {
					var content_idd = content_id;
					(function(content_idd) {
						//$('.colio-content:visible').css('background-color','red');
						$('.colio-navigation,.colio-close').stop().animate({'opacity':0},300);
						
						
						
							$('.colio-content.colio-content-active').stop().animate({'opacity':0},300, function(content_id) {
								//$('.colio-content:visible').hide();
								
								$('.colio-content.colio-content-active').hide().removeClass('colio-content-active');
								$('#'+content_idd).addClass('colio-content-active');
								
								if(!$('.colio-wrap').hasClass('colio-active')) {
									$('.colio-wrap').removeClass('colio-inactive').addClass('colio-active');
								}							
								
//								$('#'+content_idd).animate({'opacity':1},300).fadeIn('normal', function() {
//									//alert('fade IN');
//									//alert("FADED IN");
//									$('.colio-navigation,.colio-close').animate({'opacity':1},300);
//								});
								$('#'+content_idd).css('display','block');
								$('.colio-navigation,.colio-close,#'+content_idd).animate({'opacity':1},300).fadeIn('normal');
								
								//$('#'+content_idd).fadeIn();
								//alert(content_idd);
								//alert(content_idd);
								//alert('Test');
							});
						
						
					})(content_idd);
					//alert("TOP");
				});
			})(content_id);
			
			
			// expand colio viewport and show content
			var height = this.expandViewport(content_id);
		
		} else {
			
			// if content_id isn't set, load content first
			this.loadContent(content_data, item_title, function(content_id){
			
				// save content_id for loaded content
				item.data('colio-content-id', content_id);
				
				// for "inside" placement, make a gap for viewport inside portfolio grid
				if(this.settings.placement === 'inside') {
					this.insideMakeGap(item);
				}
				
				//alert('TEST'+content_id);
				var position = $('.portfolio').offset().top;
				
				if($('#'+content_id).find('img').length > 0) {
					
				} else {
				
				
				
				(function(content_id) {
					$('body,html').stop().animate({scrollTop: position-90}, 500, function() {
						var content_idd = content_id;
						(function(content_idd) {
							//$('.colio-content:visible').css('background-color','red');
							$('.colio-navigation,.colio-close').stop().animate({'opacity':0},300);
							
							if ($(".colio-content.colio-content-active").length > 0) {
							
								$('.colio-content.colio-content-active').stop().animate({'opacity':0},300, function(content_id) {
									//$('.colio-content:visible').hide();
									
									$('.colio-content.colio-content-active').hide().removeClass('colio-content-active');
									
									if(!$('.colio-wrap').hasClass('colio-active')) {
										$('.colio-wrap').removeClass('colio-inactive').addClass('colio-active');
									}
									
									$('#'+content_idd).addClass('colio-content-active');
									
									
									$('.colio-navigation,.colio-close,#'+content_idd).fadeIn('normal', function() {
										//alert("FADED IN");
										//$('.colio-navigation,.colio-close').animate({'opacity':1},300);
									}).css('opacity',1);
									//$('#'+content_idd).fadeIn();
									//alert(content_idd);
									//alert(content_idd);
									//alert('Test');
								});
							
							} else {
							
								if(!$('.colio-wrap').hasClass('colio-active')) {
									$('.colio-wrap').removeClass('colio-inactive').addClass('colio-active');
								}
								
								//$('.colio-content.colio-content-active').removeClass('colio-content-active');
								$('#'+content_idd).addClass('colio-content-active');
								
								//$('#'+content_idd).fadeIn('normal', function() {
									//alert('fade IN');
									
									//$('.colio-navigation,.colio-close').animate({'opacity':1},300);
								//}).css('opacity',1);
							
							}
						})(content_idd);
						
						//alert("TOP");
					});
				})(content_id);
				
				}
				
				// expand colio viewport and show content
				var height = this.expandViewport(content_id);
				
				
				//$('.colio').animate({'height':height},500);
				//alert(height);
				
				
				
			});
		
		}
		
		// add class to navigatin controls when first/last item has been reached
		this.markup.find('.colio-navigation a').removeClass('colio-no-prev colio-no-next');
		
		if(this.position === 0 ) {
			this.markup.find('.colio-prev').addClass('colio-no-prev');
		}
		
		if(this.position === this.items.length - 1 ) {
			this.markup.find('.colio-next').addClass('colio-no-next');
		}
		
		// add class for active item
		this.items.removeClass('colio-active-item'); 
		item.addClass('colio-active-item');
		
	};
	
	
	/* 
	* Method to load content and execute callback when ready
	*/
	
	Colio.prototype.loadContent = function(data, item_title, callback){
		
		// ref to Colio object
		var self = this;
		//alert('TEST' + item_title);
		
		// function to add new "colio-content" div
		var _addContentDiv = function(content){
			
			// jq object
			content = $(content);
			
			//$('.colio-contaier').css('height',0);
			

			// apply content filter if set
			if(self.settings.contentFilter) {				
				content = content.filter(self.settings.contentFilter);
				if(content.length === 0) {
					content = content.end().find(self.settings.contentFilter);
				}
			}
			
			//$('.colio-loader').fadeIn(10);
			//$('.colio-loader').fadeIn();
			content = content.filter('#page-content');
			//content = content.filter('#page-content').html();
			
			//	LOAD CALLBACK
			
			if(content.find('img').length > 0) {
				
			
			
			content.find('img').imagesLoaded(function() {
				self.settings.onLoad.call(self.markup.get(0), content_id);
				$(window).trigger('resize');
				$('.colio-navigation,.colio-close').animate({'opacity':1},300);
				//self.scroll();			
				//alert(content_id);
				$('.colio-loader').fadeOut();
				
				var position = $('.portfolio').offset().top;
				//$('body, html').stop().animate({scrollTop: position-90}, 300, function() {
					//$('.colio-container').css('height','auto');
				//});
				
				$('.custom_slider').flexslider({
				    animation: "fade",
					selector: ".image_slider .slide",
					controlNav: true,
					directionNav: true,
					animationSpeed: 500,
					slideshowSpeed: 5000,
					pauseOnHover: true, 
					direction: "vertical"
				 });
				 
				 (function(content_id) {
				 	$('body,html').stop().animate({scrollTop: position-90}, 500, function() {
				 		var content_idd = content_id;
				 		(function(content_idd) {
				 			//$('.colio-content:visible').css('background-color','red');
				 			$('.colio-navigation,.colio-close').stop().animate({'opacity':0},300);
				 			
				 			if ($(".colio-content.colio-content-active").length > 0) {
				 			
				 				$('.colio-content.colio-content-active').stop().animate({'opacity':0},300, function(content_id) {
				 					//$('.colio-content:visible').hide();
				 					
				 					$('.colio-content.colio-content-active').hide().removeClass('colio-content-active');
				 					
				 					if(!$('.colio-wrap').hasClass('colio-active')) {
				 						$('.colio-wrap').removeClass('colio-inactive').addClass('colio-active');
				 					}
				 					
				 					$('#'+content_idd).addClass('colio-content-active');
				 					
				 					
				 					$('.colio-navigation,.colio-close,#'+content_idd).fadeIn('normal', function() {
				 						//alert("FADED IN");
				 						//$('.colio-navigation,.colio-close').animate({'opacity':1},300);
				 					}).css('opacity',1);
				 					//$('#'+content_idd).fadeIn();
				 					//alert(content_idd);
				 					//alert(content_idd);
				 					//alert('Test');
				 				});
				 			
				 			} else {
				 			
				 				if(!$('.colio-wrap').hasClass('colio-active')) {
				 					$('.colio-wrap').removeClass('colio-inactive').addClass('colio-active');
				 				}
				 				
				 				//$('.colio-content.colio-content-active').removeClass('colio-content-active');
				 				$('#'+content_idd).addClass('colio-content-active');
				 				
				 				//$('#'+content_idd).fadeIn('normal', function() {
				 					//alert('fade IN');
				 					
				 					//$('.colio-navigation,.colio-close').animate({'opacity':1},300);
				 				//}).css('opacity',1);
				 			
				 			}
				 		})(content_idd);
				 		
				 		//alert("TOP");
				 	});
				 })(content_id);
				 
				 
				 //$('.colio-content,.colio-navigation,.colio-close').animate({'opacity':1},300);
				
				//alert($('.portfolio').offset().top);

				//self.scroll(0,false);
			});
			
			} else {
			
			var position = $('.portfolio').offset().top;
			
				(function(content_id) {
					$('body,html').stop().animate({scrollTop: position-90}, 500, function() {
						var content_idd = content_id;
						
						(function(content_idd) {
							//$('.colio-content:visible').css('background-color','red');
							$('.colio-navigation,.colio-close').stop().animate({'opacity':0},300);
							
							if ($(".colio-content.colio-content-active").length > 0) {
								
								$('.colio-content.colio-content-active').stop().animate({'opacity':0},300, function(content_id) {
									//$('.colio-content:visible').hide();
									//alert("BAM");
									$('.colio-content.colio-content-active').hide().removeClass('colio-content-active');
									
									if(!$('.colio-wrap').hasClass('colio-active')) {
										$('.colio-wrap').removeClass('colio-inactive').addClass('colio-active');
									}
									
									$('#'+content_idd).addClass('colio-content-active');
									
									
									$('.colio-navigation,.colio-close,#'+content_idd).fadeIn('normal', function() {
										//alert("FADED IN");
										//$('.colio-navigation,.colio-close').animate({'opacity':1},300);
									}).css('opacity',1);
									//$('#'+content_idd).fadeIn();
									//alert(content_idd);
									//alert(content_idd);
									//alert('Test');
								});
							
							} else {
								alert("BAM");
								if(!$('.colio-wrap').hasClass('colio-active')) {
									$('.colio-wrap').removeClass('colio-inactive').addClass('colio-active');
								}
								
								//$('.colio-content.colio-content-active').removeClass('colio-content-active');
								$('#'+content_idd).addClass('colio-content-active');
								
								//$('#'+content_idd).fadeIn('normal', function() {
									//alert('fade IN');
									
									//$('.colio-navigation,.colio-close').animate({'opacity':1},300);
								//}).css('opacity',1);
							
							}
						})(content_idd);
						
						//alert("TOP");
					});
				})(content_id);
				
				
				
			}
			
//			content.find('img').bind("load", function () { 
//				self.settings.onLoad.call(self.markup.get(0), content_id);
//			});
			
//			content.find('img').one("load", function() {
//			  // do stuff
//			}).each(function() {
//			  if(this.complete) 
//			});
			
			var onImgLoad = function(selector, callback){
			    $(selector).each(function(){
			        if (this.complete || /*for IE 10-*/ $(this).height() > 0) {
			            callback.apply(this);
			        }
			        else {
			            $(this).on('load', function(){
			                callback.apply(this);
			            });
			        }
			    });
			};
			
			onImgLoad(content.find('img'), function(){
			    //self.settings.onLoad.call(self.markup.get(0), content_id);
			});
			
			content = content.html();
			
			// generate uniq id for new content
			var content_id = 'colio_' + Math.floor(Math.random() * 100000);
			
			// create and insert "colio-content" div
			//$('<div id="' + content_id + '" class="colio-content"></div>').append(content).appendTo(self.markup.find('.colio-container'));
			
			$('<div id="' + content_id + '" class="colio-content"><div class="modal-portfolio-header"><h2>'+item_title+'</h2></div><div class="modal-portfolio-content"></div></div>').append(content).appendTo(self.markup.find('.colio-container'));
						
			// content callback
			if(typeof self.settings.onContent === 'function') {
				//alert("CALLBACK");
				//self.settings.onLoad.call(self.markup.get(0), content_id);
				//self.settings.onContent.call(self.markup.get(0), content_id);
			}
			//alert('#' + content_id);
			$('#' + content_id).bind('load',function() {
				//alert('images loaded');
			});
			//alert(self.settings.onContent);
			//this.settings.onContent.call(this.markup.get(0), content_id);
			//self.settings.onContent.call();
						
			// return content id	
			return content_id;
		};
		
		
		// get content from another element in document
		if(/^#\w/.test(data)) {
			var html = $(data).html();
			var content_id = _addContentDiv(html);
			// slighly delay running callback to give onContent() time to complete 
			setTimeout(function(){ 
				callback.call(self, content_id);
			}, 20);
			
		// get content from URL by sending AJAX request
		} else if (/(^\.{0,2}\/+\w)|(^https?:\/\/\w)/.test(data)) {
			$.get(data, function(html) {
				callback.call(self, _addContentDiv(html));
			});
		
		// inline content that we insert as is
		} else {
			var content_id = _addContentDiv(data);
			// slighly delay running callback to give onContent() time to complete
			setTimeout(function(){ 
				callback.call(self, content_id); 
			}, 20);
			
		}
		
	};

	
	/*
	* Method to expand viewport and display requested content
	*/
	
	Colio.prototype.expandViewport = function(content_id, adjust){
	
		// variables
		var duration = this.settings.expandDuration, 
			easing = this.settings.expandEasing,
			sync = this.settings.syncScroll,
			viewport_top = this.markup.offset().top - parseInt(this.settings.scrollOffset, 10),
			viewport_height = this.getViewportHeight(content_id);
			
		// unlock and return if received content height is 0 or if we try
		// to expand same item, but only when adjust argument isn't true
		
				
		if(viewport_height === 0 || (!adjust && content_id === this.active_id)) {
			this.lock = false; // unlock
			return;
		}
		
		
		
		// switch content in colio viewport
		this.switchContent(content_id);
		
		//$('#'+content_id).css('opacity',0);
		
		//alert(viewport_height);
		//if(viewport_height < 500) {
			//viewport_height = this.getViewportHeight(content_id);
			//alert(viewport_height);
			//viewport_height = 800;
		//}	
		//alert(viewport_height);
		//alert(viewport_height);						
		// run animation to expand colio viewport
		this.markup.stop().delay(100).animate({height: viewport_height}, duration, easing, $.proxy(function(){
			
			// add expanded class
			this.markup.addClass('colio-expanded');
			
			// scroll page to colio viewport
			this.scroll(viewport_top, !sync);
			
			// unlock
			this.lock = false;
			
			// expand callback
			if(typeof this.settings.onExpand === 'function') {
				this.settings.onExpand.call(this.markup.get(0), content_id);
			}
			
		}, this));
		
		
		
		// scroll page to colio viewport (sync)
		this.scroll(viewport_top, sync);
		
		return(viewport_height);
	};
		
	
	/*
	* Method to switch content inside viewport using fade animation
	*/
	
	Colio.prototype.switchContent = function(content_id) {
		
		//alert('SWITCH');
		// variables
		var active_content = this.markup.find('#' + this.active_id),
			new_content = this.markup.find('#' + content_id);

		// don't run animation if active and new content match
		//if(this.active_id === content_id) {
			//alert("NOTHING");
			//return;
		//}
		// veented1				
		// start animation to replace active content with new one		
		if(active_content.length) {
//			active_content.stop().fadeOut(this.settings.contentFadeOut, $.proxy(function(){
//				new_content.fadeIn(this.settings.contentFadeIn);
//			}, this));
		} else {
			//new_content.delay(this.settings.contentDelay).fadeIn(this.settings.contentFadeIn);
		}
		
		// save id of new visible content
		this.active_id = content_id;
		
	};
	
	
	/*
	* Method to get viewport height for specific content 
	*/
	
	Colio.prototype.getViewportHeight = function(content_id){
		
		// variables
		var container = this.markup.find('.colio-container'),
			container_width = container.width(),
			container_padding = container.outerHeight() - container.height(),
			content = this.markup.find('#' + content_id),
			content_height = 0;
								
		// if content is visible, get height right away
		if(content.is(':visible')) {
			content_height = content.height();
			
		} else {
			// otherwise make content temporaly visible to get its height
			content.css({display: 'block', position: 'absolute', visibility: 'hidden', width: container_width});
			content_height = content.height();
			content.css({display: '', position: '', visibility: '', width: ''});
		}
						
		// return 0 if content height is 0, otherwise return total viewport height 
		return content_height > 0 ? content_height + container_padding : 0;
	
	};
	
	
	/*
	* Method to scroll page to specific position
	*/
	
	Colio.prototype.scroll = function(top, allow){
		
		// variables
		var duration = this.settings.scrollDuration, 
			easing = this.settings.scrollEasing;
						
		// check if page scroll is allowed in settings
		if( !this.settings.scrollPage ) {
			return;
		}
			
		// animate page scroll
		if( allow ) {
			$('body, html').stop().animate({scrollTop: top-80}, duration, easing);
		}
		
	};
	
	
	/*
	* Method to collapse colio viewport
	*/
	
	Colio.prototype.collapse = function(){
		
		// variables
		var duration = this.settings.collapseDuration, 
			easing = this.settings.collapseEasing,
			sync = this.settings.syncScroll;
						
		// unset position
		this.position = undefined;
		
		$('.colio-content:visible,.colio-navigation,.colio-close').animate({'opacity':0},300);
		
		
		// start collapse animation
		this.markup.stop().delay(350).animate({height:0}, duration, easing, $.proxy(function(){
		
			// hide any visible content
			//this.markup.find('.colio-content:visible').hide();
			
			// remove active class from portfolio items
			this.items.removeClass('colio-active-item');
			
			// scroll page back to original scroll position
			//this.scroll(this.page_scroll, !sync);
			var position = $('.portfolio').offset().top;
			$('body, html').stop().animate({scrollTop: position-90}, 300);
			
			// collapse callback
			if(typeof this.settings.onCollapse === 'function') {
				this.settings.onCollapse.call(this.markup.get(0), this.active_id);
			}
			
			// unset active content
			this.active_id = undefined;
			
		}, this));
		
		// remove expanded class
		this.markup.removeClass('colio-expanded');
		
		// for "inside" placement close gap in item grid
		if(this.settings.placement === 'inside') {
			this.insideJoinGap();
		}
		
		// scroll page back to original scroll position (sync)
		var position = $('.portfolio').offset().top;
		$('body, html').stop().animate({scrollTop: position-90}, 300);
		
		//this.scroll(this.page_scroll, sync);
		
	};
	
	
	/*
	* For "inside" placement. Method to get all items that follow the row of current item
	*/
	
	Colio.prototype.insideBottomItems = function(item){
	
		// variables
		var in_row = Math.floor( this.list.width() / item.outerWidth(true) );
		
		// in_row cannot not be less then 1
		in_row = Math.max(1, in_row);
		
		var	total_rows = Math.ceil( this.items.length / in_row),
			row = Math.floor( this.items.index(item) / in_row );
		
		// do not increase row if this is last row
		if(row < total_rows - 1) {
			row = row + 1;
		}
				
		return this.items.slice( row * in_row);
		
	};
	
	
	/*
	* For "inside" placement. Method to make a gap for colio viewport inside item grid
	*/
	
	Colio.prototype.insideMakeGap = function(item){
	
		// variables			
		var duration = this.settings.expandDuration, 
			easing = this.settings.expandEasing;
	
		// get content_id for item to get viewport height to make a gap in item grid
		var content_id = item.data('colio-content-id');
		var viewport_height = this.getViewportHeight(content_id);
	
		// add any bottom margins to colio viewport height
		viewport_height += parseFloat(this.markup.css('margin-bottom'));
		
		// push items that are below colio viewport down by the amount of viewport height
		$.each(this.insideBottomItems(item), function(){
			
			// save initial top position
			var item_top = $(this).data('colio-item-top');
			if(item_top === undefined) {
				item_top = parseFloat($(this).css('top')) || 0;
				$(this).data('colio-item-top', item_top);
			}
			
			// add class to items that we have pushed down
			$(this).addClass('colio-bottom-item');
						
			// push items using animation
			$(this).stop().animate({top: item_top + viewport_height}, duration, easing);
		
		});
		
		// save initial portfolio list height
		var list_height = this.list.data('colio-list-height');
		if(list_height === undefined) {
			list_height = this.list.height();
			this.list.data('colio-list-height', list_height);
		}
										
		// increase list height by the amount of viewport height
		this.list.height(list_height + viewport_height);
		
	};
	
	
	/*
	* For "inside" placement. Method to close the gap in item grid
	*/
	
	Colio.prototype.insideJoinGap = function(no_animation){
	
		// variables			
		var duration = this.settings.collapseDuration, 
			easing = this.settings.collapseEasing;
		
		// restore initial top position of items with class "colio-bottom-item"
		this.items.filter('.colio-bottom-item').each(function(){
			var item_top = $(this).data('colio-item-top') || 0;
			if(no_animation) {
				$(this).css('top', item_top);
			} else {
				$(this).stop().animate({top: item_top}, duration, easing);
			}
			$(this).removeData('colio-item-top').removeClass('colio-bottom-item');
		});
		
		// restore initial list height (use .no-transition class to disable css3 transitions)
		var list_height = this.list.data('colio-list-height');
		this.list.addClass('no-transition').height(list_height);
		this.list.get(0).offsetHeight;  //force relayout
		this.list.removeClass('no-transition').removeData('colio-list-height');		
	};
	
	
	/*
	* For "inside" placement. Method to position colio viewport inside the gap created in item grid
	*/
	
	Colio.prototype.insidePositionViewport = function(item){
			
		// items that go below viewport
		var bottom_items = this.insideBottomItems(item);
			
		// check if colio viewport is expanded
		if(this.active_id) {
		
			// current items below viewport
			var active_bottom_items = this.items.filter('.colio-bottom-item');
			
			// check if colio viewport should be moved to next row of items
			if( active_bottom_items.length !== bottom_items.length ) {
				
				// hide colio viewport and restore item grid to initial state
				this.insideHideViewport(); 
				
				// reposition colio viewport (active_id is unset)
				this.insidePositionViewport(item);
			}
		
		} else {
		
			// make sure portfolio items have relative or absolute position
			if(/absolute|relative/.test(this.items.eq(0).css('position')) === false ) {
				this.items.css({position: 'relative', top: 0, left: 0});
			}
		
			// calculate position for colio viewport
			var vp_margin_left = parseFloat(this.markup.css('margin-left')),
				vp_margin_right = parseFloat(this.markup.css('margin-right')),
				vp_left = this.list.offset().left + vp_margin_left,
				vp_width = this.list.width() - (vp_margin_left + vp_margin_right),
				vp_top = bottom_items.offset().top;
			
			// set position
			this.markup.css({top: vp_top, left: vp_left, width: vp_width});
		
		}
		
	};
	
	
	/*
	* For "inside" placement. Method to hide viewport immediately
	*/
	
	Colio.prototype.insideHideViewport = function() {
	
		// return if viewport is already collapsed
		if(this.active_id === undefined) { return; }
		
		// unset active content
		this.active_id = undefined;
		
		// close gap in item grid without animation
		this.insideJoinGap(true);
		
		// set viewport height to 0 and hide any visible content
		//this.markup.height(0).find('.colio-content:visible').hide();
			
		// remove active item class 
		this.items.removeClass('colio-active-item');
		
		// remove expanded class
		this.markup.removeClass('colio-expanded');

	};


	
	// jQuery plugin
	// ---------------------------------------------------------------------------
	
	$.fn.colio = function(c) {
		// default settings
		var s = $.extend({
			id: 'colio',						// "id" attribute to be assigned to colio viewport
			theme: '',							// colio theme - "black" or "white"
			placement: 'before',				// viewport placement - "before", "after", "inside" or "#id"
			expandLink: '.colio-link',			// selector for elements that will expand colio viewport
			expandDuration: 500,				// duration of expand animation, ms
			expandEasing: 'swing',				// easing for expand animation
			collapseDuration: 300,				// duration of collapse animation, ms
			collapseEasing: 'swing',			// easing for collapse animation
			scrollPage: true,					// whether to scroll page to colio viewport
			syncScroll: false,					// sync page scroll with expand/collapse animation
			scrollDuration: 300,				// page scroll duration, ms
			scrollEasing: 'swing',				// page scroll easing
			scrollOffset: 10,					// viewport offset from top of the page, px
			contentFadeIn: 500,					// content fade-in duration, ms
			contentFadeOut: 200,				// content fade-out duration, ms
			contentDelay: 200,					// content fade-in delay, ms
			navigation: true,					// whether to show next/previous controls
			closeText: '<span>Close</span>',	// text/html for close button
			nextText: '<span>Next</span>',		// text/html for next button
			prevText: '<span>Prev</span>',		// text/html for previous button
			contentFilter: '',					// selector to filter content that is to be loaded
			hiddenItems: '.hidden',				// selector to exclude hidden portfolio items
			onExpand: function(content_id){
				//console.log(test);
				//alert(content_id);
				//$('.colio-navigation,.colio-close, #'+content_id).animate({'opacity':1},300);
				$('.colio-loader').fadeOut();
				//$('#'+content_id).animate({'opacity',0);	
			},				// viewport expand callback
			onLoad: function(){
			
			},				// viewport expand callback
			onCollapse: function(){
				//$('.colio-navigation,.colio-close,.colio-content').css('opacity',0);
				$('.colio-wrap').addClass('colio-inactive').removeClass('colio-active');
			},			// viewport collapse callback
			onContent: function(){
				alert('loaded');
			}				// content load callback
		}, c);
		
		// create Colio instance
		return this.each(function(){
			var colio = new Colio(this, s);
		});
	};


})(jQuery);

(function( window, $, undefined ){

// ======================= imagesLoaded Plugin ===============================
  /*!
   * jQuery imagesLoaded plugin v1.1.0
   * http://github.com/desandro/imagesloaded
   *
   * MIT License. by Paul Irish et al.
   */


  // $('#my-container').imagesLoaded(myFunction)
  // or
  // $('img').imagesLoaded(myFunction)

  // execute a callback when all images have loaded.
  // needed because .load() doesn't work on cached images

  // callback function gets image collection as argument
  //  `this` is the container

  $.fn.imagesLoaded = function( callback ) {
    var $this = this,
        $images = $this.find('img').add( $this.filter('img') ),
        len = $images.length,
        blank = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==',
        loaded = [];

    function triggerCallback() {
      callback.call( $this, $images );
    }

    function imgLoaded( event ) {
      var img = event.target;
      if ( img.src !== blank && $.inArray( img, loaded ) === -1 ){
        loaded.push( img );
        if ( --len <= 0 ){
          setTimeout( triggerCallback );
          $images.unbind( '.imagesLoaded', imgLoaded );
        }
      }
    }

    // if no images, trigger immediately
    if ( !len ) {
      triggerCallback();
    }

    $images.bind( 'load.imagesLoaded error.imagesLoaded',  imgLoaded ).each( function() {
      // cached images don't fire load sometimes, so we reset src.
      var src = this.src;
      // webkit hack from http://groups.google.com/group/jquery-dev/browse_thread/thread/eee6ab7b2da50e1f
      // data uri bypasses webkit log warning (thx doug jones)
      this.src = blank;
      this.src = src;
    });

    return $this;
  };


  // helper function for logging errors
  // $.error breaks jQuery chaining
  var logError = function( message ) {
    if ( window.console ) {
      window.console.error( message );
    }
  };

 

})( window, jQuery );

jQuery(document).ready(function() {

	var colio_run = function(){
		jQuery('#demo_1').remove();
		jQuery('.portfolio .portfolio-items').colio({
			id: 'demo_1',
			theme: 'white',
			placement: 'before',
			onContent: function(content){
				// init "flexslider" plugin
				//jQuery('.flexslider', content).flexslider({slideshow: false, animationSpeed: 300});
				alert('on content');
			}
		});
	};
	
	colio_run();
	
	jQuery('.portfolio .item').each(function(n){
		jQuery(this).attr('data-id', n);
	});
	
	var copy = jQuery('.portfolio .item').clone();
	
});