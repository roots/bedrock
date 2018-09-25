/**
 * SMOF js
 *
 * contains the core functionalities to be used
 * inside SMOF
 */

jQuery.noConflict();

/** Fire up jQuery - let's dance! 
 */
jQuery(document).ready(function($){

	//
	//
	// Theme Customizer predefined styles
	//
	//
	
	$('#section-vntd_predefined_style input[name="vntd_predefined_style"]').live('change', function() {
		load_predefined(jQuery('input[name="vntd_predefined_style"]:checked').val());
		
	});
	
	$('#customizer-tab-General select').live('change', function() {
				
		load_scheme($(this).data('dependency')+'_'+$(this).val());		

	});
	
	$('#customizer-tab-General input[type=radio]').live('change', function() {
					
		//load_skin($(this).val());	
		//alert($(this).val());
		$('#vntd_accent_color').val($(this).val()).change();	
	
	});
	
	function load_skin(name) {
		
		var vntd = "#vntd_";
		
		var skins = {
			green: {
				color: '#96C94A',	
				color_hover: '#5FB2DA',			
			},
			blue: {
				color: '#5FB2DA',
				color_hover: '#99DA54',			
			},
			orange: {
				color: '#F59C69',
				color_hover: '#CF672B',			
			},
			amaranth: {
				color: '#FD5DB0',
				color_hover: '#BE337B',			
			},
			turquoise: {
				color: '#51C8E6',
				color_hover: '#2189A3',			
			},
			stealblue: {
				color: '#5FB2DA',
				color_hover: '#99DA54',			
			},
			yellow: {
				color: '#5FB2DA',
				color_hover: '#99DA54',			
			},
			grey: {
				color: '#5FB2DA',
				color_hover: '#99DA54',			
			}
		}
		
			
		$(vntd+'accent_color,'+vntd+'footer_link_color,'+vntd+'subfooter_link_color').val(skins[name]['color']).change();
		$(vntd+'content_hover_color,'+vntd+'footer_link_color_hover,'+vntd+'subfooter_color_hover').val(skins[name]['color_hover']).change();
		
	}
	
	function load_scheme(name) {
	
		var vntd = "#vntd_"; // Prefix
		
		var white_border = '#e7e7e7';
		
		var schemes = {
			body_white: {
				header_nav_color: '#3e3e3e',
				header_bg_color: '#ffffff',
				header_hover_color: '#f8f8f8',
				pagetitle_color: '#3e3e3e',
				pagetitle_bg_color: '#fafafa',
				pagetitle_border_color: '#fafafa',
				pagetitle_tagline_color: '#787777',
				pagetitle_breadcrumbs_color: '#6a6a6a',
				body_color: '#717171',
				bg_color: '#fff',
				heading_color: '#161616',
				divider_color: '#eee',	
				footer_bg_color: '#fff',
				footer_border_color: '#fff',
				footer_color: '#767676'
			},
			body_night: {
				header_nav_color: '#ffffff',
				header_bg_color: '#21242a',
				header_hover_color: '#212428',
				pagetitle_color: '#ffffff',
				pagetitle_bg_color: '#171717',
				pagetitle_border_color: '#171717',
				pagetitle_tagline_color: '#e4e4e4',
				pagetitle_breadcrumbs_color: '#e4e4e4',
				body_color: '#d1d1d1',
				bg_color: '#222326',
				heading_color: '#ffffff',
				divider_color: '#2e2e2e',	
				footer_bg_color: '#191919',
				footer_border_color: '#191919',
				footer_color: '#8d8d8d'
			},
			body_dark: {
				header_nav_color: '#ffffff',
				header_bg_color: '#222222',
				header_hover_color: '#1D1D1D',
				pagetitle_color: '#ffffff',
				pagetitle_bg_color: '#171717',
				pagetitle_border_color: '#171717',
				pagetitle_tagline_color: '#e4e4e4',
				pagetitle_breadcrumbs_color: '#e4e4e4',
				body_color: '#bbb',
				bg_color: '#1f1f1f',
				heading_color: '#ffffff',
				divider_color: '#2e2e2e',	
				footer_bg_color: '#191919',
				footer_border_color: '#191919',
				footer_color: '#8d8d8d'
			}
		};
				
		for(var key in schemes[name]) {
			
			$(vntd+key).val(schemes[name][key]).change();
		}
	}
	
	var layout = jQuery('#vntd_website_layout').attr('value');
	//alert(layout);
	if(layout == "wide") {
		jQuery('.f_vntd_bg_image_switch, .f_vntd_website_layout').hide();
	}

	jQuery('.toggle-checkbox').each(function() {
		
		var opened;
		
		jQuery(this).next().hide();
		
		if(jQuery(this).next().is(':checked')) {
			opened = true;
		} else {
			opened = false;
		}
		
		jQuery(this).toggles({
	       checkbox: jQuery(this).next(),
	       height: 24,
	       width: 60,
	       on: opened
		});
		
	});
	
	//(un)fold options in a checkbox-group
  	jQuery('.fld').live('change', function() {
  		//alert("CHANGE");
  		
  		var opened;
  		
  		if(jQuery(this).is(':checked')) {
  			opened = 1;
  		} else {
  			opened = 0;
  		}
  		
  		var $fold='.f_'+this.id;
  		
  		if(opened == 1) {
  			$($fold).slideDown('normal', "swing");
  		} else {
  			$($fold).slideUp('normal', "swing");
  		}
  		
    	
    	//$($fold).slideToggle('normal', "swing");
  	});
  	
  	//(un)fold options in a checkbox-group
	jQuery('select.fld').live('change', function() {
		//alert('changed');
		
		var val = jQuery(this).find('option:selected').val();
		
		//alert(val);
		
	
	//$($fold).slideToggle('normal', "swing");
	});
  	
  	$('[id$=_bg_image]').each(function(){
  		var val = jQuery(this).find('option:selected').val();
  		
  		//alert(val);
  		if(val == 'none') {
  			$(this).closest('.customizer-tab').find('div[id*=bg_image_]').hide();
  		}
  	});

  	//Color picker
  	$('.of-color').each(function(){  	 		
  	
  		
	  	$(this).wpColorPicker({
	  		change: function(event, ui) {
	  			var dep = $(this).data('dependency');
	  			if(dep) {
	  				$("#theme-preview ."+dep).css('color',ui.color.toString());
	  			}
	  		}
	  	});
	  	
	});
	
	// Bg Color picker
	$('.of-bg-color').each(function(){  	 		
		
	  	$(this).wpColorPicker({
	  		change: function(event, ui) {
	  			var dep = $(this).data('dependency');
	  			$("#theme-preview ."+dep).css('backgroundColor',ui.color.toString());
	  		}
	  	});
	  	
	});
	
	// Bg Color picker
	$('.of-border-color').each(function(){  	 		
		
	  	$(this).wpColorPicker({
	  		change: function(event, ui) {
	  			var dep = $(this).data('dependency');
	  			$("#theme-preview ."+dep).css('borderColor',ui.color.toString());
	  		}
	  	});
	  	
	});
	
	//hides warning if js is enabled			
	$('#js-warning').hide();
	
	//Tabify Options			
	//$('.group').hide();
	
	// Get the URL parameter for tab
	function getURLParameter(name) {
	    return decodeURI(
	        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,''])[1]
	    );
	}
	
	// If the $_GET param of tab is set, use that for the tab that should be open
//	if (getURLParameter('tab') != "") {
//		$.cookie('of_current_opt', '#'+getURLParameter('tab'), { expires: 7, path: '/' });
//	}

	// Display last current tab	
//	if ($.cookie("of_current_opt") === null) {
//		$('.group:first').fadeIn('fast');	
//		$('#of-nav li:first').addClass('current');
//		$.cookie('of_current_opt', '#of-option-general', { expires: 7, path: '/' });
//	}
//	} else {
//	
//		var hooks = $('#hooks').html();
//		hooks = jQuery.parseJSON(hooks);
//		
//		if(hooks) {
//		
//		$.each(hooks, function(key, value) { 
//		
//			if ($.cookie("of_current_opt") == '#of-option-'+ value) {
//				$('.group#of-option-' + value).fadeIn();
//				$('#of-nav li.' + value).addClass('current');
//				$('.panel-tab-title').text($('#of-nav li.' + value).text());
//			}	
//			
//			
//		});
//		
//		} else {
//			$('.group#of-option-general').fadeIn();
//			$('#of-nav li.general').addClass('current');
//		}
//	
//	}
//				
	//Current Menu Class
	$('#of-nav li a').click(function(evt){
	// event.preventDefault();
		
		$('#of-nav li').removeClass('current');
		$(this).parent().addClass('current');
							
		var clicked_group = $(this).attr('href');
		
		//$.cookie('of_current_opt', clicked_group, { expires: 7, path: '/' });
			
		$('.group').hide();
							
		$(clicked_group).fadeIn('fast');
		$('.panel-tab-title').text($(this).text());
		return false;
						
	});

	//Expand Options 
	var flip = 0;
				
	$('#expand_options').click(function(){
		if(flip == 0){
			flip = 1;
			$('#of_container #of-nav').hide();
			$('#of_container #content').width(755);
			$('#of_container .group').add('#of_container .group h2').show();
	
			$(this).removeClass('expand');
			$(this).addClass('close');
			$(this).text('Close');
					
		} else {
			flip = 0;
			$('#of_container #of-nav').show();
			$('#of_container #content').width(595);
			$('#of_container .group').add('#of_container .group h2').hide();
			$('#of_container .group:first').show();
			$('#of_container #of-nav li').removeClass('current');
			$('#of_container #of-nav li:first').addClass('current');
					
			$(this).removeClass('close');
			$(this).addClass('expand');
			$(this).text('Expand');
				
		}
			
	});
	
	//Update Message popup
	$.fn.center = function () {
		this.animate({"top":( $(window).height() - this.height() - 200 ) / 2+$(window).scrollTop() + "px"},100);
		//this.css("left", 250 );
		return this;
	}
	
	$('.google_font_select').chosen();
		
			
	$('#of-popup-save').center();
	$('#of-popup-reset').center();
	$('#of-popup-fail').center();
			
	$(window).scroll(function() { 
		$('#of-popup-save').center();
		$('#of-popup-reset').center();
		$('#of-popup-fail').center();
	});

	//Masked Inputs (images as radio buttons)
	$('.of-radio-img-img').click(function(){
	
		
		$(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		$(this).addClass('of-radio-img-selected');
		
		$(this).parent().find('input').prop("checked", true).change();

	});
	$('.of-radio-img-label').hide();
	$('.of-radio-img-img').show();
	$('.of-radio-img-radio').hide();
	
	//Masked Inputs (background images as radio buttons)
	$('.of-radio-tile-img').click(function(){
		$(this).parent().parent().find('.of-radio-tile-img').removeClass('of-radio-tile-selected');
		$(this).addClass('of-radio-tile-selected');
	});
	$('.of-radio-tile-label').hide();
	$('.of-radio-tile-img').show();
	$('.of-radio-tile-radio').hide();	
	
	/** Aquagraphite Slider MOD */
	
	//Hide (Collapse) the toggle containers on load
	$(".slide_body").hide(); 

	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
	$(".slide_edit_button").live( 'click', function(){		
		/*
		//display as an accordion
		$(".slide_header").removeClass("active");	
		$(".slide_body").slideUp("fast");
		*/
		//toggle for each
		$(this).parent().toggleClass("active").next().slideToggle("fast");
		return false; //Prevent the browser jump to the link anchor
	});	
	
	// Update slide title upon typing		
	function update_slider_title(e) {
		var element = e;
		if ( this.timer ) {
			clearTimeout( element.timer );
		}
		this.timer = setTimeout( function() {
			$(element).parent().prev().find('strong').text( element.value );
		}, 100);
		return true;
	}
	
	$('.of-slider-title').live('keyup', function(){
		update_slider_title(this);
	});
		
	
	//Remove individual slide
	$('.slide_remove_button').live('click', function(){
	// event.preventDefault();
	var agree = confirm("Are you sure you wish to delete this slide?");
		if (agree) {
			var $trash = $(this).parents('li');
			//$trash.slideUp('slow', function(){ $trash.remove(); }); //chrome + confirm bug made slideUp not working...
			$trash.animate({
					opacity: 0.25,
					height: 0,
				}, 500, function() {
					$(this).remove();
			});
			return false; //Prevent the browser jump to the link anchor
		} else {
		return false;
		}	
	});
	
	//Add new slide
	$(".slide_add_button").live('click', function(){		
		var slidesContainer = $(this).prev();
		var sliderId = slidesContainer.attr('id');
		
		var numArr = $('#'+sliderId +' li').find('.order').map(function() { 
			var str = this.id; 
			str = str.replace(/\D/g,'');
			str = parseFloat(str);
			return str;			
		}).get();
		
		var maxNum = Math.max.apply(Math, numArr);
		if (maxNum < 1 ) { maxNum = 0};
		var newNum = maxNum + 1;
		
		var newSlide = '<li class="temphide"><div class="slide_header">Slide ' + newNum + '<input type="hidden" class="slide of-input order" name="' + sliderId + '[' + newNum + '][order]" id="' + sliderId + '_slide_order-' + newNum + '" value="' + newNum + '"><a class="slide_edit_button" href="#">Edit</a></div><div class="slide_body" style="display: none; "><label>Title</label><input class="slide of-input of-slider-title" name="' + sliderId + '[' + newNum + '][title]" id="' + sliderId + '_' + newNum + '_slide_title" value=""><a class="slide_remove_button" href="#">Delete</a><div class="clear"></div></div></li>';
		
		slidesContainer.append(newSlide);
		var nSlide = slidesContainer.find('.temphide');
		nSlide.fadeIn('fast', function() {
			$(this).removeClass('temphide');
		});
				
		optionsframework_file_bindings(); // re-initialise upload image..
		
		return false; //prevent jumps, as always..
	});	
	
	$(".slide_body select.select").live('change', function() {
		$(this).closest("li").find("strong").text($(this).val());
	});
	
	$(".socials_add_button").live('click', function(){		
		var slidesContainer = $(this).prev();
		var sliderId = slidesContainer.attr('id');
		var sliderInt = $('#'+sliderId).attr('rel');
		
		var numArr = $('#'+sliderId +' li').find('.order').map(function() { 
			var str = this.id; 
			str = str.replace(/\D/g,'');
			str = parseFloat(str);
			return str;			
		}).get();
		
		var maxNum = Math.max.apply(Math, numArr);
		if (maxNum < 1 ) { maxNum = 0};
		var newNum = maxNum + 1;
		
		var newSlide = '<li class="temphide"><div class="slide_header">Facebook<input type="hidden" class="slide of-input order" name="' + sliderId + '[' + newNum + '][order]" id="' + sliderId + '_slide_order-' + newNum + '" value="' + newNum + '"><a class="slide_edit_button" href="#">Edit</a></div><div class="slide_body" style="display: none; "><label>Social Icon</label><select class="select" name="' + sliderId + '[' + newNum + '][icon_name]">';
		
		//var social_icons = ['Facebook','Twitter','Google-Plus','Pinterest','RSS','Dribbble','StumbleUpon','YouTube','Vimeo','Tumblr','LinkedIn','Digg','Dropbox','Delicious','MySpace','Skype','Plixi','Last.fm','Mobypicture','E-Mail'];
		
		var socials = {
			'facebook': "Facebook",
			'twitter': "Twitter",
			'google-plus': "Google Plus",
			'linkedin': 'LinkedIn',
			'dribbble': 'Dribbble',
			'pinterest': 'Pinterest',
			'skype': 'Skype',
			'tumblr': 'Tumblr',
			'dropbox': 'Dropbox',
			'rss': 'RSS',
			'weibo': 'Weibo',
			'flickr': 'Flickr',
			'instagram': 'Instagram',
			'vimeo': 'Vimeo',
			'youtube': 'YouTube',
			'stack-exchange': 'Stack Exchange',
			'stack-overflow': 'Stack Overflow',
			'github': 'Github',
			'maxcdn': 'Maxcdn',
			'envelope': 'E-Mail'	
		};
//		for (var i = 0; i < social_icons.length; i++) {
//			newSlide = newSlide+'<option value="'+social_icons[i]+'">'+social_icons[i]+'</option>';
//		}
		
		for(key in socials) {
			newSlide = newSlide+'<option value="'+key+'">'+socials[key]+'</option>';
		}
		
		newSlide = newSlide+'</select><label>URL</label><input class="slide of-input of-slider-url" name="' + sliderId + '[' + newNum + '][url]" id="' + sliderId + '_' + newNum + '_slide_url" value=""><a class="slide_remove_button" href="#">Delete</a><div class="clear"></div></div></li>';
		
		slidesContainer.append(newSlide);
		//StyleSelect();
		$('.temphide').fadeIn('fast', function() {
			$(this).removeClass('temphide');
		});
				
		//of_image_upload(); // re-initialise upload image..
		
		
		return false; //prevent jumps, as always..
	});	
	
	$(".headers_add_button").live('click', function(){		
		var slidesContainer = $(this).prev();
		var sliderId = slidesContainer.attr('id');
		var sliderInt = $('#'+sliderId).attr('rel');
		
		var numArr = $('#'+sliderId +' li').find('.order').map(function() { 
			var str = this.id; 
			str = str.replace(/\D/g,'');
			str = parseFloat(str);
			return str;			
		}).get();
		
		var maxNum = Math.max.apply(Math, numArr);
		if (maxNum < 1 ) { maxNum = 0};
		var newNum = maxNum + 1;
		
		var newSlide = '<li class="temphide"><div class="slide_header"><strong>Header ' + newNum + '</strong><input type="hidden" class="slide of-input order" name="' + sliderId + '[' + newNum + '][order]" id="' + sliderId + '_slide_order-' + newNum + '" value="' + newNum + '"><a class="slide_edit_button" href="#">Edit</a></div><div class="slide_body" style="display: none; "><select name="' + sliderId + '[' + newNum + '][icon_name]">';
		
		var social_icons = ['Facebook','Twitter','Google Plus','Pinterest','RSS','Dribbble','StumbleUpon','YouTube','Vimeo','Tumblr','LinkedIn','Digg','Dropbox','Delicious','MySpace','Skype','Plixi','Last.fm','Mobypicture','E-Mail'];
		for (var i = 0; i < social_icons.length; i++) {
			newSlide = newSlide+'<option value="'+social_icons[i]+'">'+social_icons[i]+'</option>';
		}
		
		newSlide = newSlide+'</select><label>URL</label><input class="slide of-input of-slider-url" name="' + sliderId + '[' + newNum + '][url]" id="' + sliderId + '_' + newNum + '_slide_url" value=""><a class="slide_remove_button" href="#">Delete</a><div class="clear"></div></div></li>';
		
		slidesContainer.append(newSlide);
		$('.temphide').fadeIn('fast', function() {
			$(this).removeClass('temphide');
		});
				
		of_image_upload(); // re-initialise upload image..
		
		return false; //prevent jumps, as always..
	});	
	
	
	//Sort slides
	jQuery('.slider').find('ul').each( function() {
		var id = jQuery(this).attr('id');
		$('#'+ id).sortable({
			placeholder: "placeholder",
			opacity: 0.6,
			handle: ".slide_header",
			cancel: "a"
		});	
	});
	
	
	/**	Sorter (Layout Manager) */
	jQuery('.sorter').each( function() {
		var id = jQuery(this).attr('id');
		$('#'+ id).find('ul').sortable({
			items: 'li',
			placeholder: "placeholder",
			connectWith: '.sortlist_' + id,
			opacity: 0.6,
			update: function() {
				$(this).find('.position').each( function() {
				
					var listID = $(this).parent().attr('id');
					var parentID = $(this).parent().parent().attr('id');
					parentID = parentID.replace(id + '_', '')
					var optionID = $(this).parent().parent().parent().attr('id');
					$(this).prop("name", optionID + '[' + parentID + '][' + listID + ']');
					
				});
			}
		});	
	});
	
	
	/**	Ajax Backup & Restore MOD */
	//backup button
	$('#of_backup_button').live('click', function(){
	
		var answer = confirm("Click OK to backup your current saved options.")
		
		if (answer){
	
			var clickedObject = $(this);
			var clickedID = $(this).attr('id');
					
			var nonce = $('#security').val();
		
			var data = {
				action: 'of_ajax_post_action',
				type: 'backup_options',
				security: nonce
			};
						
			$.post(ajaxurl, data, function(response) {
							
				//check nonce
				if(response==-1){ //failed
								
					var fail_popup = $('#of-popup-fail');
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();                        
					}, 2000);
				}
							
				else {
							
					var success_popup = $('#of-popup-save');
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				}
							
			});
			
		}
		
	return false;
					
	}); 
	
	//restore button
	$('#of_restore_button').live('click', function(){
	
		var answer = confirm("'Warning: All of your current options will be replaced with the data from your last backup! Proceed?")
		
		if (answer){
	
			var clickedObject = $(this);
			var clickedID = $(this).attr('id');
					
			var nonce = $('#security').val();
		
			var data = {
				action: 'of_ajax_post_action',
				type: 'restore_options',
				security: nonce
			};
						
			$.post(ajaxurl, data, function(response) {
			
				//check nonce
				if(response==-1){ //failed
								
					var fail_popup = $('#of-popup-fail');
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();                        
					}, 2000);
				}
							
				else {
							
					var success_popup = $('#of-popup-save');
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				}	
						
			});
	
		}
	
	return false;
					
	});
	
	/**	Ajax Transfer (Import/Export) Option */
	$('#of_import_button').live('click', function(){
	
		var answer = confirm("Click OK to import options.")
		
		if (answer){
	
			var clickedObject = $(this);
			var clickedID = $(this).attr('id');
					
			var nonce = $('#security').val();
			
			var import_data = $('#export_data').val();
		
			var data = {
				action: 'of_ajax_post_action',
				type: 'import_options',
				security: nonce,
				data: import_data
			};
						
			$.post(ajaxurl, data, function(response) {
				var fail_popup = $('#of-popup-fail');
				var success_popup = $('#of-popup-save');
				
				//check nonce
				if(response==-1){ //failed
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();                        
					}, 2000);
				}		
				else 
				{
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				}
							
			});
			
		}
		
	return false;
					
	});
	
	/** AJAX Save Options */
	$('.of-save').live('click',function() {
			
		var nonce = $('#security').val();
					
		$('.ajax-loading-img').fadeIn();
		
		//get serialized data from all our option fields			
		var serializedReturn = $('#of_form :input[name][name!="security"][name!="of_reset"]').serialize();

		$('#of_form :input[type=checkbox]').each(function() {     
		    if (!this.checked) {
		        serializedReturn += '&'+this.name+'=0';
		    }
		});
						
		var data = {
			type: 'save',
			action: 'of_ajax_post_action',
			security: nonce,
			data: serializedReturn
		};
					
		$.post(ajaxurl, data, function(response) {
			var success = $('#of-popup-save');
			var fail = $('#of-popup-fail');
			var loading = $('.ajax-loading-img');
			loading.fadeOut();  
						
			if (response==1) {
				success.fadeIn();
			} else { 
				fail.fadeIn();
			}
						
			window.setTimeout(function(){
				success.fadeOut(); 
				fail.fadeOut();				
			}, 2000);
		});
			
	return false; 
					
	});   
	
	
	/* AJAX Options Reset */	
	$('#of_reset').click(function() {
		
		//confirm reset
		var answer = confirm("Click OK to reset. All settings will be lost and replaced with default settings!");
		
		//ajax reset
		if (answer){
			
			var nonce = $('#security').val();
						
			$('.ajax-reset-loading-img').fadeIn();
							
			var data = {
			
				type: 'reset',
				action: 'of_ajax_post_action',
				security: nonce,
			};
						
			$.post(ajaxurl, data, function(response) {
				var success = $('#of-popup-reset');
				var fail = $('#of-popup-fail');
				var loading = $('.ajax-reset-loading-img');
				loading.fadeOut();  
							
				if (response==1)
				{
					success.fadeIn();
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				} 
				else 
				{ 
					fail.fadeIn();
					window.setTimeout(function(){
						fail.fadeOut();				
					}, 2000);
				}
							

			});
			
		}
			
	return false;
		
	});
	
	
	/* Appearance Load */	
		$('#of_load').click(function() {
			
			//confirm reset
			var answer = confirm("Click OK to load settings. Hehe!");
			
			//ajax reset
			if (answer){
				
				var nonce = $('#security').val();
							
				$('.ajax-reset-loading-img').fadeIn();
								
				var data = {
				
					//type: 'reset',
					type: 'load',
					action: 'of_ajax_post_action',
					security: nonce,
				};
							
				$.post(ajaxurl, data, function(response) {
					var success = $('#of-popup-reset');
					var fail = $('#of-popup-fail');
					var loading = $('.ajax-reset-loading-img');
					loading.fadeOut();  
								
					if (response==1)
					{
						success.fadeIn();
						alert("Loaded succesfully");
						window.setTimeout(function(){
							location.reload();                        
						}, 1000);
					} 
					else 
					{ 
						fail.fadeIn();
						alert("Loading failed");
						window.setTimeout(function(){
							fail.fadeOut();				
						}, 2000);
					}
								
	
				});
				
			}
				
		return false;
			
		});


	/**	Tipsy @since v1.3 */
	if (jQuery().tipsy) {
		$('.tooltip, .typography-size, .typography-height, .typography-face, .typography-style, .of-typography-color').tipsy({
			fade: true,
			gravity: 's',
			opacity: 0.7,
		});
	}
	
	
	/**
	  * JQuery UI Slider function
	  * Dependencies 	 : jquery, jquery-ui-slider
	  * Feature added by : Smartik - http://smartik.ws/
	  * Date 			 : 03.17.2013
	  */
	jQuery('.smof_sliderui').each(function() {
		
		var obj   = jQuery(this);
		var sId   = "#" + obj.data('id');
		var val   = parseInt(obj.data('val'));
		var min   = parseInt(obj.data('min'));
		var max   = parseInt(obj.data('max'));
		var step  = parseInt(obj.data('step'));
		
		
		//slider init
		obj.slider({
			value: val,
			min: min,
			max: max,
			step: step,
			range: "min",
			slide: function( event, ui ) {
				jQuery(sId).val( ui.value );
				var dep = obj.prev('input').data('dependency');
				if(dep) {
					jQuery('#theme-preview .'+dep).css('font-size',ui.value);
				}
			},
			change: function( event, ui ) {
				jQuery(sId).val( ui.value );
				var dep = obj.prev('input').data('dependency');
				if(dep) {
					jQuery('#theme-preview .'+dep).css('font-size',ui.value);
				}
			}
		});
		
	});


	/**
	  * Switch
	  * Dependencies 	 : jquery
	  * Feature added by : Smartik - http://smartik.ws/
	  * Date 			 : 03.17.2013
	  */
	jQuery(".cb-enable").click(function(){
		var parent = $(this).parents('.switch-options');
		jQuery('.cb-disable',parent).removeClass('selected');
		jQuery(this).addClass('selected');
		jQuery('.main_checkbox',parent).attr('checked', true);
		
		//fold/unfold related options
		var obj = jQuery(this);
		var $fold='.f_'+obj.data('id');
		jQuery($fold).slideDown('normal', "swing");
	});
	jQuery(".cb-disable").click(function(){
		var parent = $(this).parents('.switch-options');
		jQuery('.cb-enable',parent).removeClass('selected');
		jQuery(this).addClass('selected');
		jQuery('.main_checkbox',parent).attr('checked', false);
		
		//fold/unfold related options
		var obj = jQuery(this);
		var $fold='.f_'+obj.data('id');
		jQuery($fold).slideUp('normal', "swing");
	});
	//disable text select(for modern chrome, safari and firefox is done via CSS)
	if (($.browser.msie && $.browser.version < 10) || $.browser.opera) { 
		$('.cb-enable span, .cb-disable span').find().attr('unselectable', 'on');
	}
	
	
	/**
	  * Google Fonts
	  * Dependencies 	 : google.com, jquery
	  * Feature added by : Smartik - http://smartik.ws/
	  * Date 			 : 03.17.2013
	  */
	function GoogleFontSelect( slctr, mainID ){
		
		var _selected = $(slctr).val(); 						//get current value - selected and saved
		var _linkclass = 'style_link_'+ mainID;
		var _previewer = mainID +'_ggf_previewer';
		var _dep = $(slctr).data('dependency');
		
		if( _selected ){ //if var exists and isset

			$('.'+ _previewer ).fadeIn();
			
			//Check if selected is not equal with "Select a font" and execute the script.
			if ( _selected !== 'none' && _selected !== 'Select a font' ) {
				
				//remove other elements crested in <head>
				$( '.'+ _linkclass ).remove();
				
				//replace spaces with "+" sign
				var the_font = _selected.replace(/\s+/g, '+');
				
				//add reference to google font family
				$('head').append('<link href="http://fonts.googleapis.com/css?family='+ the_font +':300,400,500,600,700" rel="stylesheet" type="text/css" class="'+ _linkclass +'">');
				
				//show in the preview box the font
				//$('.'+ _previewer ).css('font-family', _selected +', sans-serif' );
				
				

				$('.'+ _dep ).css('font-family', _selected +', sans-serif' );
				//$('.'+ _previewer ).css('font-family', _selected +', sans-serif' );
				
			}else{
				
				//if selected is not a font remove style "font-family" at preview box
				$('.'+ _previewer ).css('font-family', '' );
				$('.'+ _previewer ).fadeOut();
				
			}
		
		}
	
	}
	
	//init for each element
	jQuery( '.google_font_select' ).each(function(){ 
		var mainID = jQuery(this).attr('id');
		GoogleFontSelect( this, mainID );
	});
	
	//init when value is changed
	jQuery( '.google_font_select' ).change(function(){ 
		var mainID = jQuery(this).attr('id');
		GoogleFontSelect( this, mainID );
	});


	/**
	  * Media Uploader
	  * Dependencies 	 : jquery, wp media uploader
	  * Feature added by : Smartik - http://smartik.ws/
	  * Date 			 : 05.28.2013
	  */
	function optionsframework_add_file(event, selector) {
	
		var upload = $(".uploaded-file"), frame;
		var $el = $(this);
		var main_id = selector.attr('id');
		var dep = $('#'+main_id).find('input').data('dependency')
		
		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( frame ) {
			frame.open();
			return;
		}

		// Create the media frame.
		frame = wp.media({
			// Set the title of the modal.
			title: $el.data('choose'),

			// Customize the submit button.
			button: {
				// Set the text of the button.
				text: $el.data('update'),
				// Tell the button not to close the modal, since we're
				// going to refresh the page when the image is selected.
				close: false
			}
		});

		// When an image is selected, run a callback.
		frame.on( 'select', function() {
			// Grab the selected attachment.
			var attachment = frame.state().get('selection').first();
			frame.close();
			selector.find('.upload').val(attachment.attributes.url);
			if ( attachment.attributes.type == 'image' ) {
				selector.find('.screenshot').empty().hide().append('<img class="of-option-image" src="' + attachment.attributes.url + '">').slideDown('fast');
			}
			selector.find('.media_upload_button').unbind();
			selector.find('.remove-image').show().removeClass('hide');//show "Remove" button
			selector.find('.of-background-properties').slideDown();
			optionsframework_file_bindings();
			
			selector.closest('.customizer-tab').find('.folded-'+selector.find('input').attr('name')).show();
			
			if(dep) {
				$('#theme-preview .'+dep).css('background-image', 'url('+attachment.attributes.url+')');
			}
			//alert(dep);
		});

		// Finally, open the modal.
		frame.open();
	}
    
	function optionsframework_remove_file(selector) {
		selector.find('.remove-image').hide().addClass('hide');//hide "Remove" button
		selector.find('.upload').val('');
		selector.find('.of-background-properties').hide();
		selector.find('.screenshot').slideUp();
		selector.find('.remove-file').unbind();
		// We don't display the upload button if .upload-notice is present
		// This means the user doesn't have the WordPress 3.5 Media Library Support
		if ( $('.section-upload .upload-notice').length > 0 ) {
			$('.media_upload_button').remove();
		}
		selector.closest('.customizer-tab').find('.folded-'+selector.find('input').attr('name')).hide();
		optionsframework_file_bindings();
	}
	
	function optionsframework_file_bindings() {
		$('.remove-image, .remove-file').on('click', function() {
			var dep = $(this).closest('.controls').find('input').data('dependency')
			if(dep) {
				$('#theme-preview .'+dep).css('background-image', 'none');
			}
			optionsframework_remove_file( $(this).parents('.section-upload, .section-media, .slide_body') );
			
        });
        
        $('.media_upload_button').unbind('click').click( function( event ) {
        	optionsframework_add_file(event, $(this).parents('.section-upload, .section-media, .slide_body'));
        });
    }
    
    optionsframework_file_bindings();

	
	

}); //end doc ready
