/**
 * Easy Social Share Buttons for WordPress Core Javascript
 * 
 * @package EasySocialShareButtons
 * @author appscreo
 * @since 5.0
 */

/**
 * jQuery function extension package for Easy Social Share Buttons
 */
jQuery(document).ready(function($){
	jQuery.fn.essb_toggle_more = function(){
		return this.each(function(){
			$(this).removeClass('essb_after_more');
			$(this).addClass('essb_before_less');
		});
	};
	
	jQuery.fn.essb_toggle_less = function(){
		return this.each(function(){
			$(this).addClass('essb_after_more');
			$(this).removeClass('essb_before_less');
		});
	};
	
	jQuery.fn.extend({
		center: function () {
			return this.each(function() {
				var top = (jQuery(window).height() - jQuery(this).outerHeight()) / 2;
				var left = (jQuery(window).width() - jQuery(this).outerWidth()) / 2;
				jQuery(this).css({position:'fixed', margin:0, top: (top > 0 ? top : 0)+'px', left: (left > 0 ? left : 0)+'px'});
			});
		},
		centerH: function (bottom_position) {
			return this.each(function() {
				var left = (jQuery(window).width() - jQuery(this).outerWidth()) / 2;
				jQuery(this).css({position:'fixed', margin:0, bottom: (bottom_position > 0 ? bottom_position : 0)+'px', left: (left > 0 ? left : 0)+'px'});
			});
		}
	});
	
	jQuery.fn.isInViewport = function() {
		var elementTop = $(this).offset().top;
		var elementBottom = elementTop + $(this).outerHeight();
		var viewportTop = $(window).scrollTop();
		var viewportBottom = viewportTop + $(window).height();
		return elementBottom > viewportTop && elementTop < viewportBottom;
	};
	
});

(function ($) {
    $.fn.countTo = function (options) {
        options = options || {};

        return $(this).each(function () {
            // set options for current element
            var settings = $.extend({}, $.fn.countTo.defaults, {
                from: $(this).data('from'),
                to: $(this).data('to'),
                speed: $(this).data('speed'),
                refreshInterval: $(this).data('refresh-interval'),
                decimals: $(this).data('decimals')
            }, options);

            // how many times to update the value, and how much to increment the value on each update
            var loops = Math.ceil(settings.speed / settings.refreshInterval),
                increment = (settings.to - settings.from) / loops;

            // references & variables that will change with each update
            var self = this,
                $self = $(this),
                loopCount = 0,
                value = settings.from,
                data = $self.data('countTo') || {};

            $self.data('countTo', data);

            // if an existing interval can be found, clear it first
            if (data.interval) {
                clearInterval(data.interval);
            }
            data.interval = setInterval(updateTimer, settings.refreshInterval);

            // initialize the element with the starting value
            render(value);

            function updateTimer() {
                value += increment;
                loopCount++;

                render(value);

                if (typeof (settings.onUpdate) == 'function') {
                    settings.onUpdate.call(self, value);
                }

                if (loopCount >= loops) {
                    // remove the interval
                    $self.removeData('countTo');
                    clearInterval(data.interval);
                    value = settings.to;

                    if (typeof (settings.onComplete) == 'function') {
                        settings.onComplete.call(self, value);
                    }
                }
            }

            function render(value) {
                var formattedValue = settings.formatter.call(self, value, settings);
                $self.text(formattedValue);
            }
        });
    };

    $.fn.countTo.defaults = {
        from: 0, // the number the element should start at
        to: 0, // the number the element should end at
        speed: 1000, // how long it should take to count between the target numbers
        refreshInterval: 100, // how often the element should be updated
        decimals: 0, // the number of decimal places to show
        formatter: formatter,  // handler for formatting the value before rendering
        onUpdate: null, // callback method for every time the element is updated
        onComplete: null       // callback method for when the element finishes updating
    };

    function formatter(value, settings) {
        return value.toFixed(settings.decimals);
    }
    
    

}(jQuery));

( function( $ ) {

	/**
	 * Easy Social Share Buttons for WordPress 
	 * 
	 * @package EasySocialShareButtons
	 * @since 5.0
	 * @author appscreo
	 */
	var essb = {};
	
	var debounce = function( func, wait ) {
		var timeout, args, context, timestamp;
		return function() {
			context = this;
			args = [].slice.call( arguments, 0 );
			timestamp = new Date();
			var later = function() {
				var last = ( new Date() ) - timestamp;
				if ( last < wait ) {
					timeout = setTimeout( later, wait - last );
				} else {
					timeout = null;
					func.apply( context, args );
				}
			};
			if ( ! timeout ) {
				timeout = setTimeout( later, wait );
			}
		};
	};
	
	var isElementInViewport = function (el) {

	    //special bonus for those using jQuery
	    if (typeof jQuery === "function" && el instanceof jQuery) {
	        el = el[0];
	    }

	    var rect = el.getBoundingClientRect();

	    return (
	        rect.top >= 0 &&
	        rect.left >= 0 &&
	        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && /*or $(window).height() */
	        rect.right <= (window.innerWidth || document.documentElement.clientWidth) /*or $(window).width() */
	    );
	};


	essb.window = function (url, service, instance, trackingOnly) {
		var element = $('.essb_'+instance),
			instance_post_id = $(element).attr('data-essb-postid') || '',
			instance_position = $(element).attr('data-essb-position') || '',
			wnd;

		var w = (service == 'twitter') ? '500' : '800',
			h = (service == 'twitter') ? '300' : '500',
			left = (screen.width/2)-(Number(w)/2),
			top = (screen.height/2)-(Number(h)/2);

		if (!trackingOnly) 
			wnd = window.open( url, "essb_share_window", "height="+(service == 'twitter' ? '300' : '500')+",width="+(service == 'twitter' ? '500' : '800')+",resizable=1,scrollbars=yes,top="+top+",left="+left );
		
		
		if (typeof(essb_settings) != "undefined") {
			if (essb_settings.essb3_stats) {
				if (typeof(essb_handle_stats) != "undefined") 
					essb_handle_stats(service, instance_post_id, instance);
				
			}

			if (essb_settings.essb3_ga) 
				essb_ga_tracking(service, url, instance_position);
			
		}
	
		essb_self_postcount(service, instance_post_id);
	
		if (typeof(essb_abtesting_logger) != "undefined") 
			essb_abtesting_logger(service, instance_post_id, instance);
		
		if (typeof(essb_conversion_tracking) != 'undefined')
			essb_conversion_tracking(service, instance_post_id, instance);

		if (!trackingOnly) 
			var pollTimer = window.setInterval(function() {
				if (wnd.closed !== false) {
					window.clearInterval(pollTimer);
					essb_smart_onclose_events(service, instance_post_id);
										
					if (instance_position == 'booster' && typeof(essb_booster_close_from_action) != 'undefined')
						essb_booster_close_from_action();
				}
			}, 200);
		
	};

	essb.tracking_only = function(url, service, instance, afterShare) {
		if (url == '')
			url = document.URL;
		
		essb.window(url, service, instance, true);
		
		var element = $('.essb_'+instance),
			instance_position = $(element).attr('data-essb-position') || '';
		
		if (afterShare) {
			var instance_post_id = $('.essb_'+instance).attr('data-essb-postid') || '';
			essb_smart_onclose_events(service, instance_post_id);
			
			if (instance_position == 'booster' && typeof(essb_booster_close_from_action) != 'undefined')
				essb_booster_close_from_action();
		}
	}
	
	essb.pinterest_picker = function(instance) {
		essb.tracking_only('', 'pinterest', instance);
		var e=document.createElement('script');
		e.setAttribute('type','text/javascript');
		e.setAttribute('charset','UTF-8');
		e.setAttribute('src','//assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);
		document.body.appendChild(e);
	}
	
	essb.print = function (instance) {
		essb.tracking_only('', 'print', instance);
		window.print();
	}
	
	essb.setCookie = function(cname, cvalue, exdays) {
	    var d = new Date();
	    d.setTime(d.getTime() + (exdays*24*60*60*1000));
	    var expires = "expires="+d.toGMTString();
	    document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";
	}

	essb.getCookie = function(cname) {
	    var name = cname + "=";
	    var ca = document.cookie.split(';');
	    for(var i=0; i<ca.length; i++) {
	        var c = ca[i].trim();
	        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
	    }
	    return "";
	}
	
	essb.loveThis = function (instance) {
		if (essb.clickedLoveThis) {
			alert(essb_love_you_message_loved);
			return;
		}

		var element = $('.essb_'+instance);
		if (!element.length) return;
		
		var instance_post_id = $(element).attr("data-essb-postid") || "";

		var cookie_set = essb.getCookie("essb_love_"+instance_post_id);
		if (cookie_set) {
			alert(essb_love_you_message_loved);
			return;
		}

		if (typeof(essb_settings) != "undefined") {
			$.post(essb_settings.ajax_url, {
				'action': 'essb_love_action',
				'post_id': instance_post_id,
				'service': 'love',
				'nonce': essb_settings.essb3_nonce
			}, function (data) { if (data) {
				alert(essb_love_you_message_thanks);
			}},'json');
		}

		essb.tracking_only('', 'love', instance, true);
	};
	
	essb.toggle_more = function(unique_id) {
		if (essb['is_morebutton_clicked']) { 
			essb.toggle_less(unique_id); 
			return; 
		}
		$('.essb_'+unique_id+' .essb_after_more').essb_toggle_more();
		
		var moreButton = $('.essb_'+unique_id).find('.essb_link_more');
		if (typeof(moreButton) != "undefined") {
			moreButton.hide();
			moreButton.addClass('essb_hide_more_sidebar');
		}
		
		moreButton = $('.essb_'+unique_id).find('.essb_link_more_dots');
		if (typeof(moreButton) != "undefined") {
			moreButton.hide();
			moreButton.addClass('essb_hide_more_sidebar');			
		}
		
		essb['is_morebutton_clicked'] = true;
	};
		
	essb.toggle_less = function(unique_id) {
		essb['is_morebutton_clicked'] = false;
		$('.essb_'+unique_id+' .essb_before_less').essb_toggle_less();
		
		var moreButton = $('.essb_'+unique_id).find('.essb_link_more');
		if (typeof(moreButton) != "undefined") {
			moreButton.show();
			moreButton.removeClass('essb_hide_more_sidebar');
		}
		
		moreButton = $('.essb_'+unique_id).find('.essb_link_more_dots');
		if (typeof(moreButton) != "undefined") {
			moreButton.show();
			moreButton.removeClass('essb_hide_more_sidebar');
		}
	};
	
	essb.toggle_more_popup = function(unique_id) {
		
		if (essb['essb_morepopup_opened']) {
			essb.toggle_less_popup(unique_id);
			return;
		}
		
		if ($(".essb_morepopup_"+unique_id).hasClass("essb_morepopup_inline")) {
			essb.toggle_more_inline(unique_id);
			return;
		}
		
		var is_from_mobilebutton = false;
		var height_of_mobile_bar = 0;
		if ($(".essb-mobile-sharebottom").length) {
			is_from_mobilebutton = true;
			height_of_mobile_bar = $(".essb-mobile-sharebottom").outerHeight();
		}
		
		
		var win_width = $( window ).width();
		var win_height = $(window).height();
		var doc_height = $('document').height();
		
		var base_width = 550;
		if (!is_from_mobilebutton) 
			base_width = 660;
		
		
		if (win_width < base_width) 
			base_width = win_width - 30; 
		var height_correction = is_from_mobilebutton ? 10 : 80;
		
		var instance_mobile = false;
		
		var element_class = ".essb_morepopup_"+unique_id;
		var element_class_shadow = ".essb_morepopup_shadow_"+unique_id;
		var alignToBottom = false;
		
		if ($(element_class).hasClass("essb_morepopup_sharebottom")) 
			alignToBottom = true; 
		
		if ($(element_class).hasClass("essb_morepopup_modern") && !is_from_mobilebutton) 
			height_correction = 100;
		
		$(element_class).css( { width: base_width+'px'});
		
		
		var element_content_class = ".essb_morepopup_content_"+unique_id;
		var popup_height = $(element_class).outerHeight();
		if (popup_height > (win_height - 30)) {
			var additional_correction = 0;		
			if (is_from_mobilebutton) {
				$(element_class).css( { top: '5px'});
				additional_correction += 30;
			}				
			$(element_class).css( { height: (win_height - height_of_mobile_bar - height_correction - additional_correction)+'px'});
			$(element_content_class).css( { height: (win_height - height_of_mobile_bar - additional_correction - (height_correction+30))+'px', "overflowY" :"auto"});
		}
		
		$(element_class_shadow).css( { height: (win_height - height_of_mobile_bar)+'px'});
		if (!alignToBottom)
			$(element_class).center();
		else {
			var left = ($(window).width() - $(element_class).outerWidth()) / 2;
			$(element_class).css( { left: left+"px", position:'fixed', margin:0, bottom: (height_of_mobile_bar + height_correction) + "px" });
		}
		$(element_class).fadeIn(400);
		$(element_class_shadow).fadeIn(200);
		essb['essb_morepopup_opened'] = true;
	};
	
	essb.toggle_less_popup = function(unique_id) {
		var element_class = ".essb_morepopup_"+unique_id;
		var element_class_shadow = ".essb_morepopup_shadow_"+unique_id;
		$(element_class).fadeOut(200);
		$(element_class_shadow).fadeOut(200);
		essb['essb_morepopup_opened'] = false;
	};
	
	essb.toggle_more_inline = function(unique_id) {
	
	
		var buttons_element = $(".essb_"+unique_id);
		if (!buttons_element.length) return;
		var element_class = ".essb_morepopup_"+unique_id;						
		
		var appear_y = $(buttons_element).position().top + $(buttons_element).outerHeight(true);
		var appear_x = $(buttons_element).position().left;
		var appear_position = "absolute";
		
		
		var appear_at_bottom = false;
		
		if ($(buttons_element).css("position") === "fixed") 
			appear_position = "fixed";
						
		if ($(buttons_element).hasClass("essb_displayed_bottombar"))
			appear_at_bottom = true;
			
		if (appear_at_bottom) {
			appear_y = $(buttons_element).position().top - $(element_class).outerHeight(true);
			var pointer_element = $(element_class).find(".modal-pointer");
			if ($(pointer_element).hasClass("modal-pointer-up-left")) {
				$(pointer_element).removeClass("modal-pointer-up-left");
				$(pointer_element).addClass("modal-pointer-down-left");
			}
		}
			
		var more_button = $(buttons_element).find(".essb_link_more");
		if (!$(more_button).length)
		    more_button = $(buttons_element).find(".essb_link_more_dots"); 
		if ($(more_button).length) 
			appear_x = (appear_position != "fixed") ? $(more_button).position().left - 5 : (appear_x + $(more_button).position().left - 5);

		var share_button = $(buttons_element).find(".essb_link_share");
		if ($(share_button).length) 
			appear_x = (appear_position != "fixed") ? $(share_button).position().left - 5 : (appear_x + $(share_button).position().left - 5);

		
			
		$(element_class).css( { left: appear_x+"px", position: appear_position, margin:0, top: appear_y + "px" });
		
		$(element_class).fadeIn(200);
		essb['essb_morepopup_opened'] = true;
		
	}
	
	essb.subscribe_popup_close = function(key) {
		$('.essb-subscribe-form-' + key).fadeOut(400);
		$('.essb-subscribe-form-overlay-' + key).fadeOut(400);
	}

	essb.toggle_subscribe = function(key) {
		// subsribe container do not exist
		if (!$('.essb-subscribe-form-' + key).length) return;
		
		if (!essb['essb_subscribe_opened'])
			essb['essb_subscribe_opened'] = {};
		
		var asPopup = $('.essb-subscribe-form-' + key).attr("data-popup") || "";

		// it is not popup (in content methods is asPopup == "")
		if (asPopup != '1') {
			if ($('.essb-subscribe-form-' + key).hasClass("essb-subscribe-opened")) {
				$('.essb-subscribe-form-' + key).slideUp('fast');
				$('.essb-subscribe-form-' + key).removeClass("essb-subscribe-opened");
			}
			else {
				$('.essb-subscribe-form-' + key).slideDown('fast');
				$('.essb-subscribe-form-' + key).addClass("essb-subscribe-opened");
				
				if (!essb['essb_subscribe_opened'][key]) {
					essb['essb_subscribe_opened'][key] = key;
					essb.tracking_only('', 'subscribe', key, true);
				}
			}
		}
		else {
			var win_width = $( window ).width();
			var doc_height = $('document').height();
			
			var base_width = 600;
			
			if (win_width < base_width) { base_width = win_width - 40; }
			
			
			$('.essb-subscribe-form-' + key).css( { width: base_width+'px'});
			$('.essb-subscribe-form-' + key).center();
			
			$('.essb-subscribe-form-' + key).fadeIn(400);
			$('.essb-subscribe-form-overlay-' + key).fadeIn(200);

		}
		
	}

	essb.ajax_subscribe = function(key, event) {
		
		event.preventDefault();
		
		var formContainer = $('.essb-subscribe-form-' + key + ' #essb-subscribe-from-content-form-mailchimp'),
			positionContainer = $('.essb-subscribe-form-' + key + ' .essb-subscribe-form-content');
		
		var usedPosition = $(positionContainer).attr('data-position') || '';
		
		if (formContainer.length) {
			var user_mail = $(formContainer).find('.essb-subscribe-form-content-email-field').val();
			var user_name = $(formContainer).find('.essb-subscribe-form-content-name-field').length ? $(formContainer).find('.essb-subscribe-form-content-name-field').val() : '';
			$(formContainer).find('.submit').prop('disabled', true);
			$(formContainer).hide();
			$('.essb-subscribe-form-' + key).find('.essb-subscribe-loader').show();
			var submitapi_call = formContainer.attr('action') + '&mailchimp_email='+user_mail+'&mailchimp_name='+user_name;
				
			$.post(submitapi_call, { mailchimp_email1: user_mail, mailchimp_name1: user_name}, 
					function (data) {

						if (data) {
						
						console.log(data);
						
						if (data['code'] == '1') {
							$('.essb-subscribe-form-' + key).find('.essb-subscribe-form-content-success').show();
							$('.essb-subscribe-form-' + key).find('.essb-subscribe-form-content-error').hide();		
							$(formContainer).hide();
							
							// subscribe conversions tracking
							//usedPosition
							if (typeof(essb_subscribe_tracking) != 'undefined') {
								essb_subscribe_tracking(usedPosition);
							}
							
							// redirecting users if successful redirect URL is set
							if (data['redirect']) {
								setTimeout(function() {
									
									if (data['redirect_new']) {
										var win = window.open(data['redirect'], '_blank');
										win.focus();
									}
									else
										window.location.href = data['redirect'];
								}, 200);
							}
						}
						else {
							var storedMessage = $('.essb-subscribe-form-' + key).find('.essb-subscribe-form-content-error').attr('data-message') || '';
							if (storedMessage == '') {
								 $('.essb-subscribe-form-' + key).find('.essb-subscribe-form-content-error').attr('data-message', $('.essb-subscribe-form-' + key).find('.essb-subscribe-form-content-error').text());
							}
							
							if (data['code'] == 90)
								$('.essb-subscribe-form-' + key).find('.essb-subscribe-form-content-error').text(data['message']);
							else
								$('.essb-subscribe-form-' + key).find('.essb-subscribe-form-content-error').text(storedMessage);
							$('.essb-subscribe-form-' + key).find('.essb-subscribe-form-content-error').show();						
							$('.essb-subscribe-form-' + key).find('.essb-subscribe-from-content-form').show();	
							$(formContainer).find('.submit').prop('disabled', false);
						}
						$('.essb-subscribe-form-' + key).find('.essb-subscribe-loader').hide();
					}},
			'json');
		}
		
	} 

	essb.get_url_parameter = function( param_name ) {
		var page_url = window.location.search.substring(1);
		var url_variables = page_url.split('&');
		for ( var i = 0; i < url_variables.length; i++ ) {
				var curr_param_name = url_variables[i].split( '=' );
			if ( curr_param_name[0] == param_name ) {
				return curr_param_name[1];
			}
		}
	}
	
	essb.flyin_close = function () {
		$(".essb-flyin").fadeOut(200);
	}
	
	essb.popup_close = function() {

		$(".essb-popup").fadeOut(200);
		$(".essb-popup-shadow").fadeOut(400);
	}

	/** 
	 * Mobile Display Code
	 */

	essb.mobile_sharebar_open = function() {
		var element = $('.essb-mobile-sharebar-window');
		if (!element.length) 
			return;
		

		var sharebar_element = $('.essb-mobile-sharebar');
		if (!sharebar_element.length) 
			sharebar_element = $('.essb-mobile-sharepoint');
		
		if (!sharebar_element.length) 
			return;
		

		if (essb['is_displayed_sharebar']) {
			essb.mobile_sharebar_close();
			return;
		}

		var win_top = 0;

		var current_height_of_bar = $(sharebar_element).outerHeight();
		var win_height = $(window).height();
		var win_width = $(window).width();
		win_height -= current_height_of_bar;

		if ($('#wpadminbar').length) 
			$("#wpadminbar").hide();
		

		var element_inner = $('.essb-mobile-sharebar-window-content');
		if (element_inner.length) {
			element_inner.css({
				height : (win_height - 60) + 'px'
			});
		}

		$(element).css({
			width : win_width + 'px',
			height : win_height + 'px'
		});
		$(element).fadeIn(400);
		essb['is_displayed_sharebar'] = true;
	}

	essb.mobile_sharebar_close = function() {
		var element = $('.essb-mobile-sharebar-window');
		if (!element.length) 
			return;
		

		$(element).fadeOut(400);
		essb['is_displayed_sharebar'] = false;
	}
	
	essb.update_facebook_counter = function(url, recovery_url) {
		
		$.when($.get('https://graph.facebook.com/?fields=og_object{likes.summary(true).limit(0)},share&id=' + url) ,
				( recovery_url ? $.get('https://graph.facebook.com/?fields=og_object{likes.summary(true).limit(0)},share&id=' + recovery_url) : '')
		).then( function( counter, recovery_counter ) {
			
			if( 'undefined' !== typeof counter[0].share ) {
				var shares1 = parseInt(counter[0].share.share_count),
					comments1 = parseInt(counter[0].share.comment_count),
					likes1 = 0,
					total_shares1 = 0,
					total_shares2 = 0;
				
				if ('undefined' !== typeof counter[0].og_object )
					likes1 = parseInt( counter[0].og_object.likes.summary.total_count );
				
				total_shares1 = shares1 + comments1 + likes1;
				
				if (recovery_url) {
					var shares2 = parseInt(recovery_counter[0].share.share_count),
						comments2 = parseInt(recovery_counter[0].share.comment_count),
						likes2 = 0;
					if ('undefined' !== typeof recovery_counter[0].og_object )
						likes2 = parseInt( recovery_counter[0].og_object.likes.summary.total_count );
					
					total_shares2 = shares2 + comments2 + likes2;
					
					if (total_shares1 != total_shares2) total_shares1 += total_shares2;
				}
				
				$.post(essb_settings.ajax_url, {
					'action': 'essb_facebook_counter_update',
					'post_id': essb_settings.post_id,
					'count': total_shares1,
					'nonce': essb_settings.essb3_nonce
				}, function (data) { if (data) {
					console.log(data);
				}},'json');
			}
		});
	}
	
	essb.update_pinterest_counter = function(url, recovery_url) {
		$.get('https://api.pinterest.com/v1/urls/count.json?callback=?&url=' + url, {
		}, function (data) { 
			var total_shares1 = data['count'] ? data['count'] : 0; 
			
			console.log('total_shares1 = ' + total_shares1);

			$.post(essb_settings.ajax_url, {
				'action': 'essb_pinterest_counter_update',
				'post_id': essb_settings.post_id,
				'count': total_shares1.toString(),
				'nonce': essb_settings.essb3_nonce
			}, function (data) { if (data) {
				console.log(data);
			}},'json');

		},'json');
		
	}
	
	window.essb = essb;
	/**
	 * Incore Specific Functions & Events
	 */
	
	var essb_self_postcount = function (service, countID) {
		if (typeof(essb_settings) != "undefined") {
			countID = String(countID);

			$.post(essb_settings.ajax_url, {
				'action': 'essb_self_postcount',
				'post_id': countID,
				'service': service,
				'nonce': essb_settings.essb3_nonce
			}, function (data) { },'json');
		}
	};

	var essb_smart_onclose_events = function (service, postID) {
		if (service == "subscribe" || service == "comments") return;
		
		if (typeof (essbasc_popup_show) == 'function') 
				essbasc_popup_show();
		
		if (typeof essb_acs_code == 'function') 
			essb_acs_code(service, postID);

		if (typeof(after_share_easyoptin) != "undefined") 
			essb.toggle_subscribe(after_share_easyoptin);
	
	};

	
	var essb_ga_tracking = function(service, url, position) {
		var essb_ga_type = essb_settings.essb3_ga_mode;

		if ( 'ga' in window && window.ga !== undefined && typeof window.ga === 'function' ) {
			if (essb_ga_type == "extended")
				ga('send', 'event', 'social', service + ' ' + position, url);
			
			else 
				ga('send', 'event', 'social', service, url);
			
		}
		
		if (essb_ga_type == "layers" && typeof(dataLayer) != "undefined") {
			dataLayer.push({
			  'service': service,
			  'position': position,
			  'url': url,
			  'event': 'social'
			});
		}
	};
	
	$(document).ready(function(){
		/**
		 * Mobile Share Bar
		 */
		
		var mobileHideTriggered = false;
		var mobileHideOnScroll = false;
		var mobileHideTriggerPercent = 90;
		var mobileAppearOnScroll = false;
		var mobileAppearOnScrollPercent = 0;
		var mobileAdBarConnected = false;

		var essb_mobile_sharebuttons_onscroll = function() {

			var current_pos = $(window).scrollTop();
			var height = $(document).height() - $(window).height();
			var percentage = current_pos / height * 100;
			
			var isVisible = true;
			if (mobileAppearOnScroll && !mobileHideOnScroll) {
				if (percentage < mobileAppearOnScrollPercent) isVisible = false;
			}
			if (mobileHideOnScroll && !mobileAppearOnScroll) {
				if (percentage > mobileHideTriggerPercent) isVisible = false;
			}
			if (mobileAppearOnScroll && mobileHideOnScroll) {
				if (percentage > mobileHideTriggerPercent || percentage < mobileAppearOnScrollPercent) isVisible = false;
				
			}

			if (!isVisible) {
				if (!$('.essb-mobile-sharebottom').hasClass("essb-mobile-break")) {
					$('.essb-mobile-sharebottom').addClass("essb-mobile-break");
					$('.essb-mobile-sharebottom').fadeOut(400);
				}
				
				if ($('.essb-adholder-bottom').length && mobileAdBarConnected) {
					if (!$('.essb-adholder-bottom').hasClass("essb-mobile-break")) {
						$('.essb-adholder-bottom').addClass("essb-mobile-break");
						$('.essb-adholder-bottom').fadeOut(400);
					}
				}
				
			} else {
				if ($('.essb-mobile-sharebottom').hasClass("essb-mobile-break")) {
					$('.essb-mobile-sharebottom').removeClass("essb-mobile-break");
					$('.essb-mobile-sharebottom').fadeIn(400);
				}

				if ($('.essb-adholder-bottom').length && mobileAdBarConnected) {
					if ($('.essb-adholder-bottom').hasClass("essb-mobile-break")) {
						$('.essb-adholder-bottom').removeClass("essb-mobile-break");
						$('.essb-adholder-bottom').fadeIn(400);
					}
				}
			}
		}
		
		if ($('.essb-mobile-sharebottom').length) {
			
			var hide_on_end = $('.essb-mobile-sharebottom').attr('data-hideend');
			var hide_on_end_user = $('.essb-mobile-sharebottom').attr('data-hideend-percent');
			var appear_on_scroll = $('.essb-mobile-sharebottom').attr('data-show-percent') || '';
			var check_responsive = $('.essb-mobile-sharebottom').attr('data-responsive') || '';
			
			if (Number(appear_on_scroll)) {
				mobileAppearOnScroll = true;
			    mobileAppearOnScrollPercent = Number(appear_on_scroll);
			}
			
			if (hide_on_end == 'true') mobileHideOnScroll = true;
			
			var instance_mobile = false;
			if( (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i).test(navigator.userAgent) ) {
				instance_mobile = true;
			}
			
			if ($('.essb-adholder-bottom').length) {
				$adbar_connected = $('.essb-adholder-bottom').attr('data-connected') || '';
				if ($adbar_connected == 'true') mobileAdBarConnected = true;
			}
			
			if (mobileHideOnScroll || mobileAppearOnScroll) {
				if (parseInt(hide_on_end_user) > 0)
					mobileHideTriggerPercent = parseInt(hide_on_end_user);
				
				if (check_responsive == '' || (check_responsive == 'true' && instance_mobile))
					$(window).scroll(debounce(essb_mobile_sharebuttons_onscroll, 1));

			}
		}
		

		/**
		 * Display Methods: Float on top
		 */
		if ($('.essb_displayed_float').length) {
			
			var floatingTop = $('.essb_displayed_float').offset().top - parseFloat($('.essb_displayed_float').css('marginTop').replace(/auto/, 0)),
				basicElementWidth = '',
				hide_float_percent = essb_settings['hide_float'] || '',
				custom_top_postion = essb_settings['custom_top_postion'] || '',
				hide_float_active = false;
			
			if (hide_float_percent != '' && Number(hide_float_percent) > 0) {
				hide_float_percent = parseInt(hide_float_percent);
				hide_float_active = true;
			}
			
			var active_custom_top = false;
			if (custom_top_postion != '' && Number(custom_top_postion) > 0) {
				custom_top_postion = parseInt(custom_top_postion);
				active_custom_top = true;
			}
			
			/**
			 * Hold down scroll event for floating top display method when such is present
			 * inside code
			 */
			function essbFloatingButtons() {
				var y = $(window).scrollTop();
				
				if (active_custom_top) 
					y -= custom_top_postion;
				
				var height = $(document).height() - $(window).height();
				var percentage = y/height*100;
				// whether that's below the form
				if (y >= floatingTop) {
					// if so, ad the fixed class
					if (basicElementWidth == '') {
						var widthOfContainer = $('.essb_displayed_float').width();
						basicElementWidth = widthOfContainer;
						$('.essb_displayed_float').width(widthOfContainer);
					}
					
					$('.essb_displayed_float').addClass('essb_fixed');

				} else {
					// otherwise remove it
					$('.essb_displayed_float').removeClass('essb_fixed');
					if (basicElementWidth != '') {
						$('.essb_displayed_float').width(basicElementWidth);
					}
				}
				
				if (hide_float_active) {
					if (percentage >= hide_float_percent && !$('.essb_displayed_float').hasClass('hidden-float')) {
						$('.essb_displayed_float').addClass('hidden-float');
						$('.essb_displayed_float').fadeOut(100);
						return;
					}
					if (percentage < hide_float_percent && $('.essb_displayed_float').hasClass('hidden-float')) {
						$('.essb_displayed_float').removeClass('hidden-float');
						$('.essb_displayed_float').fadeIn(100);
						return;
					}
				}
			} // end: essbFloatingButtons
			
			$(window).scroll(debounce(essbFloatingButtons, 1));
		}
		
		/**
		 * Display Methods: Sidebar
		 */

		// Sidebar animation reveal on load
		if ($('.essb_sidebar_transition').length) {
			$('.essb_sidebar_transition').each(function() {
				if ($(this).hasClass('essb_sidebar_transition_slide')) 
					$(this).toggleClass('essb_sidebar_transition_slide');
				
				if ($(this).hasClass('essb_sidebar_transition_fade')) 
					$(this).toggleClass('essb_sidebar_transition_fade');
				
			});
		}
		
		// Sidebar close button
		$(".essb_link_sidebar-close a").each(function() {			
			$(this).click(function(event) {
				event.preventDefault();
				var links_list = $(this).parent().parent().get(0);
		
				if (!$(links_list).length) return;
		
				$(links_list).find(".essb_item").each(function(){
					if (!$(this).hasClass("essb_link_sidebar-close"))
						$(this).toggleClass("essb-sidebar-closed-item");					
					else 
						$(this).toggleClass("essb-sidebar-closed-clicked");
				});
		
			});		
		});
		
		var essb_sidebar_onscroll = function () {
			var current_pos = $(window).scrollTop();
			var height = $(document).height()-$(window).height();
			var percentage = current_pos/height*100;
		
			var value_disappear = essb_settings.sidebar_disappear_pos || '';
			var value_appear = essb_settings.sidebar_appear_pos || '';
			var value_appear_unit = essb_settings.sidebar_appear_unit || '';
			
			if (value_appear_unit == 'px') percentage = current_pos;
		
			var element;
			if ($(".essb_displayed_sidebar").length) 
				element = $(".essb_displayed_sidebar");
		
			if ($(".essb_displayed_sidebar_right").length) 
				element = $(".essb_displayed_sidebar_right");
		
		
			if (!element || typeof(element) == "undefined") return; 
		
			value_disappear = parseInt(value_disappear);
			value_appear = parseInt(value_appear);
			
			if (isNaN(value_disappear)) value_disappear = 0;
			if (isNaN(value_appear)) value_appear = 0;
					
			if (value_appear > 0 && value_disappear == 0) {
				if (percentage >= value_appear && !element.hasClass("active-sidebar")) {
					element.fadeIn(100);
					element.addClass("active-sidebar");
					return;
				}
			
				if (percentage < value_appear && element.hasClass("active-sidebar")) {
					element.fadeOut(100);
					element.removeClass("active-sidebar");
					return;
				}
			}
		
			if (value_disappear > 0 && value_appear == 0) {
				if (percentage >= value_disappear && !element.hasClass("hidden-sidebar")) {
					element.fadeOut(100);
					element.addClass("hidden-sidebar");
					return;
				}
			
				if (percentage < value_disappear && element.hasClass("hidden-sidebar")) {
					element.fadeIn(100);
					element.removeClass("hidden-sidebar");
					return;
				}
			}
		
			if (value_appear > 0 && value_disappear > 0) {
				if (percentage >= value_appear && percentage < value_disappear && !element.hasClass("active-sidebar")) {
					element.fadeIn(100);
					element.addClass("active-sidebar");
					return;
				}
			
				if ((percentage < value_appear || percentage >= value_disappear) && element.hasClass("active-sidebar")) {
					element.fadeOut(100);
					element.removeClass("active-sidebar");
					return;
				}
			}
		}
		
		if ((essb_settings.sidebar_disappear_pos || '') != '' || (essb_settings.sidebar_appear_pos || '') != '')
			$(window).scroll(debounce(essb_sidebar_onscroll, 1));
		
		/**
		 * Display Method: Post Bar
		 */		
		if ($('.essb-postbar').length) {
			
	        // Define Variables
	        var ttr_start = $(".essb_postbar_start"),
	            ttr_end = $(".essb_postbar_end");
	        if (ttr_start.length) {
	            var docOffset = ttr_start.offset().top,
	        	docEndOffset = ttr_end.offset().top,
	            elmHeight = docEndOffset - docOffset,
	            progressBar = $('.essb-postbar-progress-bar'),
	            winHeight = $(window).height(),
	            docScroll,viewedPortion;

	        
		        $(".essb-postbar-prev-post a").on('mouseenter touchstart', function(){
		            $(this).next('div').css("top","-162px");
		        });
		        $(".essb-postbar-close-prev").on('click', function(){
		        	$(".essb-postbar-prev-post a").next('div').css("top","46px");
		        });
		        $(".essb-postbar-next-post a").on('mouseenter touchstart', function(){
		            $(this).next('div').css("top","-162px");
		        });
		        $(".essb-postbar-close-next").on('click', function(){
		        	$(".essb-postbar-next-post a").next('div').css("top","46px");
		        });
		        
		        $(window).load(function(){
		            docOffset = ttr_start.offset().top,
		            docEndOffset = ttr_end.offset().top,
		            elmHeight = docEndOffset - docOffset;
		        });
		
		        $(window).on('scroll', function() {
		
					docScroll = $(window).scrollTop(),
		            viewedPortion = winHeight + docScroll - docOffset;
		
					if(viewedPortion < 0) { 
						viewedPortion = 0; 
					}
		            if(viewedPortion > elmHeight) { 
		            	viewedPortion = elmHeight;
		            }
		            var viewedPercentage = (viewedPortion / elmHeight) * 100;
					progressBar.css({ width: viewedPercentage + '%' });
		
				});
		
				$(window).on('resize', function() {
					docOffset = ttr_start.offset().top;
					docEndOffset = ttr_end.offset().top;
					elmHeight = docEndOffset - docOffset;
					winHeight = $(window).height();
					$(window).trigger('scroll');
				});
				
				$(window).trigger('scroll');
	        }

		};

		/**
		 * Display Method: Post Vertical Float
		 */
		
		if ($('.essb_displayed_postfloat').length) {
			var essb_postfloat_height_break = 0;
			if ($('.essb_break_scroll').length) {
				var break_position = $('.essb_break_scroll').position();
				var break_top = break_position.top;
				
			}
			
			var top = $('.essb_displayed_postfloat').offset().top - parseFloat($('.essb_displayed_postfloat').css('marginTop').replace(/auto/, 0));
			var basicElementWidth = '';
			var postfloat_always_onscreen = false;
			if (typeof(essb_settings) != "undefined") {
				postfloat_always_onscreen = essb_settings.essb3_postfloat_stay;
			}
			var custom_user_top = 0;
			if (typeof(essb_settings) != "undefined") {
				if (typeof(essb_settings['postfloat_top']) != "undefined") {
					custom_user_top = essb_settings["postfloat_top"];
					custom_user_top = parseInt(custom_user_top);
					if (isNaN(custom_user_top)) custom_user_top = 0;
					
					top -= custom_user_top;
				}
			}
			
			function essbPostVerticalFloatScroll() {
				var y = $(this).scrollTop();

				if (y >= top) {
					$('.essb_displayed_postfloat').addClass('essb_postfloat_fixed');
			      
					var element_position = $('.essb_displayed_postfloat').offset();
					var element_height = $('.essb_displayed_postfloat').outerHeight();
					var element_top = parseInt(element_position.top) + parseInt(element_height);
						
					if (!postfloat_always_onscreen) {
						if (element_top > break_top) {
							if (!$('.essb_displayed_postfloat').hasClass("essb_postfloat_breakscroll")) {
								$('.essb_displayed_postfloat').addClass("essb_postfloat_breakscroll");
							}
						}
						else {
							if ($('.essb_displayed_postfloat').hasClass("essb_postfloat_breakscroll")) {
								$('.essb_displayed_postfloat').removeClass("essb_postfloat_breakscroll");
							}
						}
					}
				} 
				else 
			      // otherwise remove it
			      $('.essb_displayed_postfloat').removeClass('essb_postfloat_fixed');
			    
			}
			
			$(window).scroll(debounce(essbPostVerticalFloatScroll, 1));
		}
		
		/**
		 * Display Method: Fly In
		 */		
		if ($('.essb-flyin').length) {
			
			var flyinDisplayed = false;
			
			var essb_flyin_onscroll = function() {
				if (flyinTriggeredOnScroll) return; 
				
				var current_pos = $(window).scrollTop();
				var height = $(document).height()-$(window).height();
				var percentage = current_pos/height*100;	
				
				if (!flyinTriggerEnd) {
					if (percentage > flyinTriggerPercent && flyinTriggerPercent > 0) {
						flyinTriggeredOnScroll = true;
						essb_flyin_show();
					}
				}
				else {
					var element = $('.essb_break_scroll');
					if (!element.length) { return; }
					var top = $('.essb_break_scroll').offset().top - parseFloat($('.essb_break_scroll').css('marginTop').replace(/auto/, 0));
					
					if (current_pos >= top) {
						flyinTriggeredOnScroll = true;
						essb_flyin_show();
					}
				}
			}

			var essb_flyin_show = function() {
				if (flyinDisplayed) return;
				
				var element = $('.essb-flyin');
				if (!element.length) return; 
				
				var popWidth = $(element).attr("data-width") || "";
				var popHideOnClose = $(element).attr("data-close-hide") || "";
				var popHideOnCloseAll = $(element).attr("data-close-hide-all") || "";
				var popPostId = $(element).attr("data-postid") || "";
				
				var popAutoCloseAfter = $(element).attr("data-close-after") || "";

				if (popHideOnClose == "1" || popHideOnCloseAll == "1") {
					var cookie_name = "";
					var base_cookie_name = "essb_flyin_";
					if (popHideOnClose == "1") {
						cookie_name = base_cookie_name + popPostId;
						
						var cookieSet = essb.getCookie(cookie_name);
						if (cookieSet == "yes") return;
						essb.setCookie(cookie_name, "yes", 7);
					}
					if (popHideOnCloseAll == "1") {
						cookie_name = base_cookie_name + "all";

						var cookieSet = essb.getCookie(cookie_name);
						if (cookieSet == "yes") return; 
						essb.setCookie(cookie_name, "yes", 7);
					}
				}
				
				var win_width = $( window ).width();
				var doc_height = $('document').height();
				
				var base_width = 400;
				var userwidth = popWidth;
				if (Number(userwidth) && Number(userwidth) > 0) 
					base_width = userwidth;
				
				
				if (win_width < base_width) base_width = win_width - 60; 
				
				// automatically close
				if (Number(popAutoCloseAfter) && Number(popAutoCloseAfter) > 0) {
					
					var optin_time = parseFloat(popAutoCloseAfter);
					optin_time = optin_time * 1000;
					setTimeout(function(){ 
						$(".essb-flyin").fadeOut(200);
					}, optin_time);
				}
				
				$(".essb-flyin").css( { width: base_width+'px'});
				$(".essb-flyin").fadeIn(400);
				
				flyinDisplayed = true;
			}

			var flyinTriggeredOnScroll = false;
			var flyinTriggerPercent = -1;
			var flyinTriggerEnd = false;

			var element = $('.essb-flyin');
			
			if ('true' == essb.get_url_parameter('essb_popup') && element.hasClass("essb-flyin-oncomment")) {
				essb_flyin_show();
				return;
			}
			
			var popOnPercent = $(element).attr("data-load-percent") || "";
			var popAfter = $(element).attr("data-load-time") || "";
			var popOnEnd = $(element).attr("data-load-end") || "";
			var popManual = $(element).attr("data-load-manual") || "";

			if (popManual == '1') return; 

			if (popOnPercent != '' || popOnEnd == "1") {
				flyinTriggerPercent = Number(popOnPercent);
				flyinTriggeredOnScroll = false;
				flyinTriggerEnd = (popOnEnd == "1") ? true : false;
				
				$(window).scroll(debounce(essb_flyin_onscroll, 1));
			}
			
			if (popAfter && typeof(popAfter) != "undefined") {
				if (popAfter != '' && Number(popAfter)) {
					setTimeout(function() {
						essb_flyin_show();
					}, (Number(popAfter) * 1000));
				}
				else 
					essb_flyin_show();	
			}
			else {
				
				if (popOnPercent == '' && popOnEnd != '1')
					essb_flyin_show();
			}
			

		}	
		
		
		/**
		 * Display Method: Pop up
		 */
		
		if ($('.essb-popup').length) {
			
			var popupTriggeredOnScroll = false;
			var popupTriggerPercent = -1;
			var popupTriggerEnd = false;
			var popupTriggerExit = false;
			var popupShown = false;

			
			var essb_popup_exit = function(event) {
				if (popupTriggerExit) return; 
				
				var e = event || window.event;
				
				var from = e.relatedTarget || e.toElement;

				// Reliable, works on mouse exiting window and user switching active program
				if(!from || from.nodeName === "HTML") {
					popupTriggerExit = true;
					essb_popup_show();
				}
			}

			var essb_popup_onscroll = function() {
				if (popupTriggeredOnScroll) return; 
				
				var current_pos = $(window).scrollTop();
				var height = $(document).height() - $(window).height();
				var percentage = current_pos/height*100;	
				
				if (!popupTriggerEnd) {
					if (percentage > popupTriggerPercent && popupTriggerPercent > 0) {
						popupTriggeredOnScroll = true;
						essb_popup_show();
					}
				}
				else {
					var element = $('.essb_break_scroll');
					if (!element.length) { 
						var userTriggerPercent = 90;
						if (percentage > userTriggerPercent && userTriggerPercent > 0) {
							popupTriggeredOnScroll = true;
							essb_popup_show();
						}
					}
					else {
						var top = $('.essb_break_scroll').offset().top - parseFloat($('.essb_break_scroll').css('marginTop').replace(/auto/, 0));
						
						if (current_pos >= top) {
							popupTriggeredOnScroll = true;
							essb_popup_show();
						}
					}
				}
			}

			var essb_popup_show = function() {

				if (popupShown) return;
				
				var element = $('.essb-popup');
				if (!element.length) return; 
				
				var popWidth = $(element).attr("data-width") || "";
				var popHideOnClose = $(element).attr("data-close-hide") || "";
				var popHideOnCloseAll = $(element).attr("data-close-hide-all") || "";
				var popPostId = $(element).attr("data-postid") || "";
				
				var popAutoCloseAfter = $(element).attr("data-close-after") || "";
				
				if (popHideOnClose == "1" || popHideOnCloseAll == "1") {
					var cookie_name = "";
					var base_cookie_name = "essb_popup_";
					if (popHideOnClose == "1") {
						cookie_name = base_cookie_name + popPostId;
						
						var cookieSet = essb.getCookie(cookie_name);
						if (cookieSet == "yes")  return; 
						essb.setCookie(cookie_name, "yes", 7);
					}
					if (popHideOnCloseAll == "1") {
						cookie_name = base_cookie_name + "all";

						var cookieSet = essb.getCookie(cookie_name);
						if (cookieSet == "yes") return; 
						essb.setCookie(cookie_name, "yes", 7);
					}
				}
				
				var win_width = $( window ).width();
				var doc_height = $('document').height();
				
				var base_width = 800;
				var userwidth = popWidth;
				if (Number(userwidth) && Number(userwidth) > 0) {
					base_width = userwidth;
				}
				
				if (win_width < base_width) { base_width = win_width - 60; }
				
				// automatically close
				if (Number(popAutoCloseAfter) && Number(popAutoCloseAfter) > 0) {
					
					optin_time = Number(popAutoCloseAfter) * 1000;
					setTimeout(function(){ 
						essb.popup_close();
					}, optin_time);

				}
				
				$(".essb-popup").css( { width: base_width+'px'});
				$(".essb-popup").center();
				
				$(".essb-popup").fadeIn(400);
				$(".essb-popup-shadow").fadeIn(200);

				popupShown = true;
			}
			
			var element = $('.essb-popup');
			if ('true' == essb.get_url_parameter('essb_popup')) {
				if (element.hasClass("essb-popup-oncomment")) {
					essb_popup_show();
					return;
				}
			}
			
			var popOnPercent = $(element).attr("data-load-percent") || "";
			var popAfter = $(element).attr("data-load-time") || "";
			var popOnEnd = $(element).attr("data-load-end") || "";
			var popManual = $(element).attr("data-load-manual") || "";
			var popExit = $(element).attr("data-exit-intent") || "";

			if (popManual == '1') return; 
			 	
			if (popOnPercent != '' || popOnEnd == "1") {
				popupTriggerPercent = Number(popOnPercent);
				popupTriggeredOnScroll = false;
				popupTriggerEnd = (popOnEnd == "1") ? true : false;
				$(window).scroll(essb_popup_onscroll);
			}
			
			if (popExit == '1') 
				$(document).mouseout(essb_popup_exit);
			
			
			
			//alert(popafter);
			if (popAfter && typeof(popAfter) != "undefined") {
				if (popAfter != '' && Number(popAfter)) {
					setTimeout(function() {
						essb_popup_show();
					}, (Number(popAfter) * 1000));
				}
				else {
					essb_popup_show();	
				}
				
			}
			else {
				if (popOnPercent == '' && popOnEnd != '1' && popExit != '1') {
					essb_popup_show();
				}
					
			}

		}
		
		/**
		 * Display Method: Bottom Bar
		 */
		
		function essb_bottombar_onscroll() {
			var current_pos = $(window).scrollTop();
			var height = $(document).height()-$(window).height();
			var percentage = current_pos/height*100;
		
			var value_appear = essb_settings.bottombar_appear || '';
			var value_disappear = essb_settings.bottombar_disappear || '';
			var element;
			if ($(".essb_bottombar").length) 
				element = $(".essb_bottombar");
			
		
			if (!element || typeof(element) == "undefined") return;
		
		
			value_appear = parseInt(value_appear);
			value_disappear = parseInt(value_disappear);
			
			if (isNaN(value_appear)) value_appear = 0;
			if (isNaN(value_disappear)) value_disappear = 0;
			
			
			if (value_appear > 0 ) {
				if (percentage >= value_appear && !element.hasClass("essb_active_bottombar")) {
					element.addClass("essb_active_bottombar");
					return;
				}
			
				if (percentage < value_appear && element.hasClass("essb_active_bottombar")) {
					element.removeClass("essb_active_bottombar");
					return;
				}
			}
			if (value_disappear > 0) {
				if (percentage >= value_disappear && !element.hasClass("hidden-float")) {
					element.addClass("hidden-float");
					element.css( {"opacity": "0"});
					return;
				}
				if (percentage < value_disappear && element.hasClass("hidden-float")) {
					element.removeClass("hidden-float");
					element.css( {"opacity": "1"});
					return;
				}
			}
		}
		
		if ($(".essb_bottombar").length) 
			if ((essb_settings.bottombar_appear || '') != '' || (essb_settings.bottombar_disappear || '') != '')
				$(window).scroll(debounce(essb_bottombar_onscroll, 1));
		

		/**
		 * Display Method: Top Bar
		 */
		
		function essb_topbar_onscroll() {
			var current_pos = $(window).scrollTop();
			var height = $(document).height()-$(window).height();
			var percentage = current_pos/height*100;
		
			var value_appear = essb_settings.topbar_appear || '';
			var value_disappear = essb_settings.topbar_disappear || '';
			var element;
			if ($(".essb_topbar").length) 
				element = $(".essb_topbar");
			
		
			if (!element || typeof(element) == "undefined") return;
		
		
			value_appear = parseInt(value_appear);
			value_disappear = parseInt(value_disappear);
			
			if (isNaN(value_appear)) value_appear = 0;
			if (isNaN(value_disappear)) value_disappear = 0;
			
			if (value_appear > 0 ) {
				if (percentage >= value_appear && !element.hasClass("essb_active_topbar")) {
					element.addClass("essb_active_topbar");
					return;
				}
			
				if (percentage < value_appear && element.hasClass("essb_active_topbar")) {
					element.removeClass("essb_active_topbar");
					return;
				}
			}
			if (value_disappear > 0) {
				if (percentage >= value_disappear && !element.hasClass("hidden-float")) {
					element.addClass("hidden-float");
					element.css( {"opacity": "0"});
					return;
				}
				if (percentage < value_disappear && element.hasClass("hidden-float")) {
					element.removeClass("hidden-float");
					element.css( {"opacity": "1"});
					return;
				}
			}
		}
		
		if ($(".essb_topbar").length) 
			if ((essb_settings.topbar_appear || '') != '' || (essb_settings.topbar_disappear || '') != '')
				$(window).scroll(debounce(essb_topbar_onscroll, 1));
		
		/**
		 * Display Method: Post Vertical Float
		 */
		function essb_postfloat_onscroll() {
			var current_pos = $(window).scrollTop();
			var height = $(document).height()-$(window).height();
			var percentage = current_pos/height*100;
		
			var value_appear = essb_settings.postfloat_percent || '';
		
			var element;
			if ($(".essb_displayed_postfloat").length) 
				element = $(".essb_displayed_postfloat");
		
			if (!element || typeof(element) == "undefined") { return; }
		
			value_appear = parseInt(value_appear);
			if (isNaN(value_appear)) value_appear = 0;
		
			if (value_appear > 0 ) {
				if (percentage >= value_appear && !element.hasClass("essb_active_postfloat")) {
					element.addClass("essb_active_postfloat");
					return;
				}
			
				if (percentage < value_appear && element.hasClass("essb_active_postfloat")) {
					element.removeClass("essb_active_postfloat");
					return;
				}
			}
		}
		
		if ((essb_settings.postfloat_percent || '') != '' && $(".essb_displayed_postfloat").length)
			$(window).scroll(debounce(essb_postfloat_onscroll, 1));
		
		/**
		 * Animated Counters Code
		 */		
		$(".essb_counters .essb_animated").each(function() {
			var current_counter = $(this).attr("data-cnt") || "";
			var current_counter_result = $(this).attr("data-cnt-short") || "";
			
			if ($(this).hasClass("essb_counter_hidden")) return;
			
			$(this).countTo({
				from: 1,
				to: current_counter,
				speed: 500,
				onComplete: function (value) {
 					$(this).html(current_counter_result); 
				}
			});
		});
		
		/**
		 *  Display Method: Follow Me
		 */
		
		if ($('.essb-followme').length) {
			if ($('.essb-followme .essb_links').length) $('.essb-followme .essb_links').removeClass('essb_displayed_followme');
			
			var dataPosition = $('.essb-followme').attr('data-position') || '',
				dataCustomTop = $('.essb-followme').attr('data-top') || '',
				dataBackground = $('.essb-followme').attr('data-background') || '',
				dataFull = $('.essb-followme').attr('data-full') || '',
				dataAvoidLeftMargin = $('.essb-followme').attr('data-avoid-left') || '',
				dataFollowmeHide = $('.essb-followme').attr('data-hide') || '';
			
			if (dataPosition == 'top' && dataCustomTop != '') 
				$('.essb-followme').css({'top': dataCustomTop+'px'});
			if (dataBackground != '') 
				$('.essb-followme').css({ 'background-color': dataBackground});
			
			if (dataFull != '1') {
				var basicWidth = $('.essb_displayed_followme').width();
				var leftPosition = $('.essb_displayed_followme').position().left;
				
				if (dataAvoidLeftMargin != 'true')
					$('.essb-followme .essb_links').attr('style', 'width:'+ basicWidth+'px; margin-left:'+leftPosition+'px !important;');
				else
					$('.essb-followme .essb_links').attr('style', 'width:'+ basicWidth+'px;');
			}
			
			function essb_followme_scroll() {
				var isOneVisible = false;
				
				$('.essb_displayed_followme').each(function() {
					if (isElementInViewport($(this)))
						isOneVisible = true;
				});
				
				var current_pos = $(window).scrollTop();
				var height = $(document).height() - $(window).height();
				var percentage = current_pos / height * 100;
				
				if (!isOneVisible) {
					if (!$('.essb-followme').hasClass('active')) $('.essb-followme').addClass('active');
				}
				else {
					if ($('.essb-followme').hasClass('active')) $('.essb-followme').removeClass('active');
				}
				
				if (dataFollowmeHide != '') {
					if (percentage > 95) {
						if (!$('.essb-followme').hasClass('essb-followme-hiddenend')) {
							$('.essb-followme').addClass('essb-followme-hiddenend');
							$('.essb-followme').slideUp(100);
						}
					}
					else {
						if ($('.essb-followme').hasClass('essb-followme-hiddenend')) {
							$('.essb-followme').removeClass('essb-followme-hiddenend');
							$('.essb-followme').slideDown(100);
						}
					}
				}
			}
			
			$(window).scroll(debounce(essb_followme_scroll, 1));
			
			// execute one time after load
			essb_followme_scroll();
		}
		
		if ($('.essb-point').length) {
			var essb_point_triggered = false;
			var essb_point_trigger_mode = "";
			
			var essb_point_trigger_open_onscroll = function() {
				var current_pos = $(window).scrollTop() + $(window).height() - 200;
				
				var top = $('.essb_break_scroll').offset().top - parseFloat($('.essb_break_scroll').css('marginTop').replace(/auto/, 0));
				
				if (essb_point_trigger_mode == 'end') {
					if (current_pos >= top && !essb_point_triggered) {
						if (!$('.essb-point-share-buttons').hasClass('essb-point-share-buttons-active')) {
							$('.essb-point-share-buttons').addClass('essb-point-share-buttons-active');
							if (essb_point_mode != 'simple') $('.essb-point').toggleClass('essb-point-open');
							essb_point_triggered = true;
							
							if (essb_point_autoclose > 0) {
								setTimeout(function() {
									$('.essb-point-share-buttons').removeClass('essb-point-share-buttons-active');
									if (essb_point_mode != 'simple') $('.essb-point').removeClass('essb-point-open');
								}, essb_point_autoclose * 1000)
							}
						}
					}
				}
				if (essb_point_trigger_mode == 'middle') {
					var percentage = current_pos * 100 / top;
					if (percentage > 49 && !essb_point_triggered) {
						if (!$('.essb-point-share-buttons').hasClass('essb-point-share-buttons-active')) {
							$('.essb-point-share-buttons').addClass('essb-point-share-buttons-active');
							if (essb_point_mode != 'simple') $('.essb-point').toggleClass('essb-point-open');
							essb_point_triggered = true;
							
							if (essb_point_autoclose > 0) {
								setTimeout(function() {
									$('.essb-point-share-buttons').removeClass('essb-point-share-buttons-active');
									if (essb_point_mode != 'simple') $('.essb-point').removeClass('essb-point-open');
								}, essb_point_autoclose * 1000)
							}
						}
					}
				}
			}
			
			var essb_point_onscroll = $('.essb-point').attr('data-trigger-scroll') || "";
			var essb_point_mode = $('.essb-point').attr('data-point-type') || "simple";
			var essb_point_autoclose = Number($('.essb-point').attr('data-autoclose') || 0) || 0;
			
			if (essb_point_onscroll == 'end' || essb_point_onscroll == 'middle') {
				essb_point_trigger_mode = essb_point_onscroll;
				$(window).scroll(essb_point_trigger_open_onscroll);
			}
			
			$(".essb-point").on('click', function(){
	
				$('.essb-point-share-buttons').toggleClass('essb-point-share-buttons-active');
				
				if (essb_point_mode != 'simple') $('.essb-point').toggleClass('essb-point-open');
				
				if (essb_point_autoclose > 0) {
					setTimeout(function() {
						$('.essb-point-share-buttons').removeClass('essb-point-share-buttons-active');
						if (essb_point_mode != 'simple') $('.essb-point').removeClass('essb-point-open');
					}, essb_point_autoclose * 1000)
				}
	        });
		}
		
		/**
		 *  Display Method: Corner Bar
		 */
		
		if ($('.essb-cornerbar').length) {
			if ($('.essb-cornerbar .essb_links').length) $('.essb-cornerbar .essb_links').removeClass('essb_displayed_cornerbar');
			
			var dataCornerBarShow = $('.essb-cornerbar').attr('data-show') || '',
				dataCornerBarHide = $('.essb-cornerbar').attr('data-hide') || '';
			
			function essb_cornerbar_scroll() {
				var current_pos = $(window).scrollTop();
				var height = $(document).height() - $(window).height();
				var percentage = current_pos / height * 100,
					breakPercent = dataCornerBarShow == 'onscroll' ? 5 : 45;
				
				if (dataCornerBarShow == 'onscroll' || dataCornerBarShow == 'onscroll50') {
					if (percentage > breakPercent) {
						if ($('.essb-cornerbar').hasClass('essb-cornerbar-hidden')) $('.essb-cornerbar').removeClass('essb-cornerbar-hidden');
					}
					else {
						if (!$('.essb-cornerbar').hasClass('essb-cornerbar-hidden')) $('.essb-cornerbar').addClass('essb-cornerbar-hidden');
					}
				}
				
				if (dataCornerBarShow == 'content') {
					var isOneVisible = false;
					$('.essb_displayed_top').each(function() {
						if (isElementInViewport($(this)))
							isOneVisible = true;
					});
					$('.essb_displayed_bottom').each(function() {
						if (isElementInViewport($(this)))
							isOneVisible = true;
					});
					
					if (!isOneVisible) {
						if ($('.essb-cornerbar').hasClass('essb-cornerbar-hidden')) $('.essb-cornerbar').removeClass('essb-cornerbar-hidden');
					}
					else {
						if (!$('.essb-cornerbar').hasClass('essb-cornerbar-hidden')) $('.essb-cornerbar').addClass('essb-cornerbar-hidden');
					}
				}
				
				if (dataCornerBarHide != '') {
					if (percentage > 90) {
						if (!$('.essb-cornerbar').hasClass('essb-cornerbar-hiddenend')) $('.essb-cornerbar').addClass('essb-cornerbar-hiddenend');
					}
					else {
						if ($('.essb-cornerbar').hasClass('essb-cornerbar-hiddenend')) $('.essb-cornerbar').removeClass('essb-cornerbar-hiddenend');
					}
				}
			}
			
			if (dataCornerBarHide != '' || dataCornerBarShow != '')
				$(window).scroll(debounce(essb_cornerbar_scroll, 1));
			
			if (dataCornerBarShow == 'content') essb_cornerbar_scroll();
			

		}
		

		/**
		 * Display Method: Share Booster
		 */
		
		if ($('.essb-sharebooster').length) {
			function essb_booster_trigger() {
				if (booster_shown) return;
				
				$('.essb-sharebooster').center();
				$('.essb-sharebooster').fadeIn(400);
				$('.essb-sharebooster-overlay').fadeIn(200);
				
				$('body').addClass('essb-sharebooster-preventscroll');
				
				booster_shown = true;
				
				if (Number(booster_autoclose))
					setTimeout(essb_booster_close, Number(booster_autoclose) * 1000);

			}
			
			function essb_booster_close() {
				$('.essb-sharebooster').fadeOut(200);
				$('.essb-sharebooster-overlay').fadeOut(400);
				
				$('body').removeClass('essb-sharebooster-preventscroll');
			}
			
			function essb_booster_close_from_action() {
				var boosterCookieKey = booster_donotshow == 'all' ? 'essb_booster_all' : 'essb_booster_' + essb_settings.post_id;
				
				essb.setCookie(boosterCookieKey, "yes", Number(booster_hide));
				essb_booster_close();
			}
			
			window.essb_booster_close_from_action = essb_booster_close_from_action;
			
			function essb_booster_scroll() {
				var current_pos = $(window).scrollTop();
				var height = $(document).height() - $(window).height();
				var percentage = current_pos / height * 100,
					breakPercent = booster_scroll;
				
				if (percentage > breakPercent) 
					essb_booster_trigger();
				
			}
			
			var booster_trigger = $('.essb-sharebooster').attr('data-trigger') || '',
				booster_time = $('.essb-sharebooster').attr('data-trigger-time') || '',
				booster_scroll = $('.essb-sharebooster').attr('data-trigger-scroll') || '',
				booster_hide = $('.essb-sharebooster').attr('data-donotshow') || '',
				booster_donotshow = $('.essb-sharebooster').attr('data-donotshowon') || '',
				booster_autoclose = $('.essb-sharebooster').attr('data-autoclose') || '',
				booster_shown = false;			
			
			if (!Number(booster_hide)) booster_hide = 7;
			
			var boosterCookieKey = booster_donotshow == 'all' ? 'essb_booster_all' : 'essb_booster_' + essb_settings.post_id;
			var cookie_set = essb.getCookie(boosterCookieKey);
			
			// booster is already triggered
			if (cookie_set) booster_trigger = 'disabled';
			
			if (booster_trigger == '') 
				essb_booster_trigger();
			if (booster_trigger == 'time')
				setTimeout(essb_booster_trigger, Number(booster_time) * 1000)
			if (booster_trigger == 'scroll')
				$(window).scroll(debounce(essb_booster_scroll, 1));
	
			
			if ($('.essb-sharebooster-close').length) {
				$('.essb-sharebooster-close').click(function(e){
					e.preventDefault();
					essb_booster_close();
				});
			}
		}	
		
		/**
		 * Facebook Client Side Counter Update
		 */
		
		if (essb_settings['facebook_client']) {
			essb.update_facebook_counter(essb_settings['facebook_post_url'] || '', essb_settings['facebook_post_recovery_url'] || '');
		}
		if (essb_settings['pinterest_client']) {
			essb.update_pinterest_counter(essb_settings['facebook_post_url'] || '', essb_settings['facebook_post_recovery_url'] || '');
		}
	});
	

} )( jQuery );

