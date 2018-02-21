var essb_disable_ajax_submit = false;

jQuery(document).ready(function($){
	
	var essb_admin_deactivate_all = function(oSender) {
		$("#section").val("");
		$("#subsection").val("");
		
		var parent_selector = ".essb-options-group-menu";
		var options_selector = ".essb-options-container";
		
		if (oSender && typeof(oSender) != "undefined") {
			var parentContainer = jQuery(oSender).closest('.essb-options-sidebar');
			if (parentContainer && typeof(parentContainer) != "undefined") {
				var existInstanceID = jQuery(parentContainer).attr("data-instance") || "";
				
				if (existInstanceID != '') {
					parent_selector = ".essb-options-group-menu-" + existInstanceID;
					options_selector = ".essb-options-container-" + existInstanceID;
				}
			}
		}
		
		jQuery(parent_selector).find(".essb-menu-item").each(function() {
			if (jQuery(this).hasClass("active")) {
				jQuery(this).removeClass("active");
			}
		});

		jQuery(parent_selector).find(".essb-submenu-item").each(function() {
			if (jQuery(this).hasClass("active-sub")) {
				jQuery(this).slideUp("50", function() {
					jQuery(this).removeClass("active-sub");	
				});
				
			}
		});


		jQuery(parent_selector).find(".essb-submenu-item").each(function() {
			if (jQuery(this).hasClass("active-submenu")) {
				jQuery(this).removeClass("active-submenu");
			}
		});

		jQuery(options_selector).find(".essb-data-container").each(function() {
			//jQuery(this).fadeOut("50");
			jQuery(this).hide();
		});
	}
	
	var essb_decativate_containers = function() {
		jQuery(".essb-options-group-menu").find(".essb-submenu-item").each(function() {
			if (jQuery(this).hasClass("active-submenu")) {
				jQuery(this).removeClass("active-submenu");
			}
		});

		jQuery(".essb-options-container").find(".essb-data-container").each(function() {
			//jQuery(this).fadeOut("50");
			jQuery(this).hide();

		});
	}
		
	var essb_fix_width_of_radio_and_checkboxes = function() {
		// Image Checkbox
		$('.essb_image_checkbox').each(function() {
			
			var image = $(this).find('.checkbox-image img');
			if (image) {
				var width = image.width();
				width += 10;
				$(this).parent().find('.essb_checkbox_label').width(width);
			}			
		});
		
		// Image Radio Button
		$('.essb_image_radio').each(function() {
			
			var image = $(this).find('.checkbox-image img');
			if (image) {
				var width = image.width();
				width += 10;
				
				$(this).parent().find('.essb_radio_label').width(width);
			}
			
		});
				
	}
	
	var activate_code_editors = function(parent_id) {
		$(parent_id).find(".is-code-editor").each(function() {
			var has_activate_call = $(this).attr("data-function-activate") || "";
			
			if (has_activate_call != '') {
				try {
					if (!window['essb3_admin_'+has_activate_call]) {
						window[has_activate_call]();
						window['essb3_admin_'+has_activate_call] = "activated";
					}
				}
				catch (e) {
					
				}
			}
		});
	}
	
	$(".essb-options-group-menu").find(".essb-menu-item").each(function() {
		
		$(this).click(function(e) {
			e.preventDefault();
			
			if ($(this).hasClass("active")) return;
			
			var has_field_id = $(this).attr("data-menu") || "";
			
			if ($('.essb-options-subtitle').length) {
				$('.essb-options-subtitle').text($(this).text());
			}
			
			if (has_field_id != "") {
				essb_admin_deactivate_all(this);
				
				$(this).addClass("active");
				
				var activate_first_sub = $(this).hasClass("essb-activate-first");
				var first_child_id = $(this).attr("data-activate-child") || "";
				
				if (first_child_id != '') {
					first_child_id = "#essb-menu-" + first_child_id;
				}
								
				for (var i=1;i<49;i++) {
					var selector = "#essb-menu-"+has_field_id + "-" + i;
					if ($(selector).length) {
						$(selector).addClass("active-sub");		
						$(selector).slideDown("50", function(){
												
						});
					}
				}
				
				if (!activate_first_sub) {
					if ($("#essb-container-"+has_field_id).length) {
						$("#essb-container-"+has_field_id).fadeIn("100");
						//$("#essb-container-"+has_field_id).show();
						essb_fix_width_of_radio_and_checkboxes("#essb-container-"+has_field_id);
						activate_code_editors("#essb-container-"+has_field_id);
						$("#essb-scroll-top").scrollintoview({
						      duration: "slow",
						      direction: "y"});
					}
				}
				else {
					$(first_child_id).trigger('click');
				}
				
				$("#section").val(has_field_id);
			}
		});
	});
		

	$(".essb-options-group-menu").find(".essb-submenu-item.essb-submenu-with-action").each(function() {
		if ($(this).hasClass("essb-submenu-menuitem")) {
			$(this).click(function(e) {
				e.preventDefault();
				var has_field_id = $(this).attr("data-menu") || "";
				
				if ($('.essb-options-subtitle').length) {
					var current_item_title = $(this).text();

					var parentMenuItem = $(this).closest('.essb-options-sidebar').find('.essb-menu-item.active');
					if (parentMenuItem.length) {
						current_item_title = parentMenuItem.text()+": "+current_item_title;
					}
					
					$('.essb-options-subtitle').text(current_item_title);
				}
				
				
				if (has_field_id != "") {
					essb_decativate_containers();
					
					$(this).addClass("active-submenu");
										
					if ($("#essb-container-"+has_field_id).length) {
						
						$("#essb-container-"+has_field_id).fadeIn("100");
						//$("#essb-container-"+has_field_id).show();
						essb_fix_width_of_radio_and_checkboxes();
						activate_code_editors("#essb-container-"+has_field_id);
						$("#essb-scroll-top").scrollintoview({
						      duration: "slow",
						      direction: "y"});
					}
					
					$("#subsection").val(has_field_id);
				}
			});
		}
		else {
			$(this).click(function(e) {
				e.preventDefault();
				var has_field_id = $(this).attr("data-menu") || "";
				var data_menu_action = $(this).attr("data-menu-action") || "";
				if (has_field_id != "") {
					
					if (data_menu_action == "toggle") {
						if ($("#essb-submenu-"+has_field_id).length) {
							$("#essb-submenu-"+has_field_id).scrollintoview({
								duration: "slow",
								direction: "y"});
						}
					}
					else {
						if ($("#essb-submenu-"+has_field_id).length) {
							$("#essb-submenu-"+has_field_id).toggle();
						}
					}
				}
			});
		}
	});
	
	$('.essb-button-backtotop').click(function(e) {
		e.preventDefault();
		$("#essb-scroll-top").scrollintoview({
		      duration: "slow",
		      direction: "y"});
	});
	
	$(".essb-options-header").find(".essb-wizard-next").each(function() {
		$(this).click(function(e) {			
			e.preventDefault();
			var current_section = $("#section").val();
			
			if (current_section != '') {
				var sectionObject = current_section.split("-");
				var section_id = sectionObject[1];
				section_id = Number(section_id) + 1;
			
				$(".essb-options-group-menu").find("#essb-menu-"+sectionObject[0]+"-"+section_id).first().trigger('click');
			}
		});
	});
	
	$(".essb-options-header").find(".essb-wizard-prev").each(function() {
		$(this).click(function(e) {			
			e.preventDefault();
			var current_section = $("#section").val();
			
			if (current_section != '') {
				var sectionObject = current_section.split("-");
				var section_id = sectionObject[1];
				section_id = Number(section_id) - 1;
				
				if (section_id < 1) { return; }
			
				$(".essb-options-group-menu").find("#essb-menu-"+sectionObject[0]+"-"+section_id).first().trigger('click');
			}
		});
	});
	
	var initial_active_section = $("#section").val();
	var initial_active_subsection = $("#subsection").val();

	if (typeof(essb5_active_tag) != 'undefined')
		console.log('section = ' + essb5_active_tag);
	
	if (initial_active_section != '') {
		//alert('has initial section = '+initial_active_section);
		$(".essb-options-group-menu").find("#essb-menu-"+initial_active_section).first().trigger('click');

		$(".essb-options-group-menu").find("#essb-menu-"+initial_active_subsection).first().trigger('click');
		//alert('has initial subsection = '+initial_active_subsection);
		essb_fix_width_of_radio_and_checkboxes();
		setTimeout(essb_fix_width_of_radio_and_checkboxes, 1000);
	}
	else {
		$(".essb-options-group-menu").find(".essb-menu-item").first().trigger('click');
	}
	
	if (typeof(essb5_active_tag) != 'undefined') {
		if (essb5_active_tag == 'functions')
			$('#essb-container-functions').fadeIn(200);
		if (essb5_active_tag == 'modes')
			$('#essb-container-modes').fadeIn(200);
		if (essb5_active_tag == 'status')
			$('#essb-container-status').fadeIn(200);
		
		if (essb5_active_tag == 'update')
			$('#essb-container-automatic').fadeIn(200);
	}
	
	
	$(".essb-switch .cb-enable").click(function(){
		var parent = $(this).parents('.essb-switch');
		$('.cb-disable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', true);
		
		if ($(parent).hasClass('essb-switch-submit'))
			$('#essb_options_form').submit();
	});
	
	
	$('.onoffswitch-checkbox').click(function(){
		if ($(this).parent().hasClass('essb-switch-submit')) {
			essb_disable_ajax_submit = true;
			$('#essb_options_form').submit();
		}
	});
	
	$(".essb-switch .cb-disable").click(function(){
		var parent = $(this).parents('.essb-switch');
		$('.cb-enable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);

		if ($(parent).hasClass('essb-switch-submit'))
			$('#essb_options_form').submit();
	});
	
	// Image Checkbox
	$('.essb_image_checkbox').each(function() {
		
		var image = $(this).find('.checkbox-image img');
		if (image) {
			var width = image.width();
			width += 10;
			$(this).parent().find('.essb_checkbox_label').width(width);
		}
		
		$(this).click(function(e) {
			e.preventDefault();
			
			var checkbox_id = $(this).attr('data-field') || "";
			var state;
			if ($(this).hasClass("active")) {
				state = false;
				$(this).removeClass("active");
			}
			else {
				state = true;
				$(this).addClass("active");
			}
			
			if (checkbox_id != "") {
				$("#essb_options_"+checkbox_id).attr("checked", state);			
			}
		});
	});
	
	// Image Radio Button
	$('.essb_image_radio').each(function() {
		
		var image = $(this).find('.checkbox-image img');
		if (image) {
			var width = image.width();
			width += 10;
			
			$(this).parent().find('.essb_radio_label').width(width);
		}
		
		$(this).click(function(e) {
			e.preventDefault();
			
			//alert($(this).parent().parent().prop("tagName"));
			
			$(this).parent().parent().find('.essb_radio').each(function(){
				var clickable_element = $(this).find('.essb_image_radio');
				var radio_element = $(this).find('input[type="radio"]');
				
				if (clickable_element.length) {
					if (clickable_element.hasClass("active")) {
						clickable_element.removeClass("active");
					}
				}
				
				if (radio_element.length) {
					radio_element.attr("checked", false);
				}
			});
			
			var checkbox_id = $(this).attr('data-field') || "";
			$("#essb_options_"+checkbox_id).attr("checked", true);	
			
			if (!$(this).hasClass("active")) {
				$(this).addClass("active");
			}
		});
	});
	

	// simple sortables
	$('.essb_sortable').each(function() {
		var element = $(this).attr("id");
		jQuery('#'+element).sortable2();
	});
	
	// fix the top navigation panel
	if ($('.essb-options-header').length)
		$('.essb-options-header').scrollToFixed( { marginTop: 30 } );
	/*if ($('.essb-plugin-menu').length)
		$('.essb-options-header').scrollToFixed( { marginTop: 132 } );
	else
		$('.essb-options-header').scrollToFixed( { marginTop: 30 } );
	
	if ($('.essb-plugin-menu').length)
		$('.essb-plugin-menu').scrollToFixed( { marginTop: 30 } );
	*/
	
	// quick navigation panel
	$(".essb-options-container").find(".essb-internal-navigation-item").each(function() {
		
		
			$(this).click(function(e) {
				e.preventDefault();
				var has_field_id = $(this).attr("data-goto") || "";
				if (has_field_id != '') {
					$("#"+has_field_id).scrollintoview({
					      duration: "slow",
					      direction: "y",
					      complete: function(){
					      }});
					

				}
			});
		
	});	
	
	$(".essb-options-container").find(".essb-internal-navigation-close").each(function() {
		
		
		$(this).click(function(e) {
			e.preventDefault();
			$(".essb-options-container").find(".essb-internal-navigation").each(function() {
				$(this).hide();
			});
		});
	
	});
	
	// portlet toggle style
	$('.essb-options-container').find('.essb-portlet-toggle').find('.essb-portlet-heading').each(function(){
	//$('.essb-options-container .essb-portlet-toggle .essb-portlet-heading').each(function(){
		$(this).click(function(e) {
			e.preventDefault();
			e.stopPropagation();
						
			// closed
			if ($(this).hasClass('essb-portlet-heading-closed')) {
				$(this).removeClass('essb-portlet-heading-closed');
				var content = $(this).parent().find('.essb-portlet-content');
			
				$(content).slideDown("fast", function() {
					$(content).removeClass('essb-portlet-content-closed');
				});
				var icon = $(this).find('.essb-portlet-state').find('i');
				if (icon.length) {
					$(icon).addClass('fa-chevron-down');
					$(icon).removeClass('fa-chevron-right');
				}
				
				$('.CodeMirror').each(function(i, el){
				    el.CodeMirror.refresh();
				});
			}
			else {
				$(this).addClass('essb-portlet-heading-closed');
				var content = $(this).parent().find('.essb-portlet-content');
				$(content).slideUp("fast", function() {
					$(content).addClass('essb-portlet-content-closed');
				});
				
				var icon = $(this).find('.essb-portlet-state').find('i');
				if (icon.length) {
					$(icon).removeClass('fa-chevron-down');
					$(icon).addClass('fa-chevron-right');
				}
			}
		});
	});
	
	$('.essb-options-container').find('.essb-portlet-switch').find('.onoffswitch-checkbox').each(function(){
		$(this).click(function(e) {
			//e.preventDefault();
			
			var state_checkbox = $(this);//.find('input');
			if (!state_checkbox.length) return;
			
			var state = $(state_checkbox).is(':checked');

			
			var parent_heading = $(this).parent().parent().parent();
			
			if ($(parent_heading).hasClass('essb-portlet-submit')) {
				essb_disable_ajax_submit = true;
				$('#essb_options_form').submit();
			}
			
			// closed
			if (state) {
				$(parent_heading).removeClass('essb-portlet-heading-closed');
				var content = $(parent_heading).parent().find('.essb-portlet-content');
				if (content.length > 1) content = content[0];
				$(content).slideDown("fast", function() {
					$(content).removeClass('essb-portlet-content-closed');
				});
				
				$('.CodeMirror').each(function(i, el){
				    el.CodeMirror.refresh();
				});
				
				$(parent_heading).parent().find('.essb_image_radio').each(function() {
					var image = $(this).find('.checkbox-image img');
					if (image) {
						var width = image.width();
						width += 10;
						
						$(this).parent().find('.essb_radio_label').width(width);
					}
				});
				
				$(parent_heading).parent().find('.essb_image_checkbox').each(function() {
					//console.log('parsing checkbox image');
					var image = $(this).find('.checkbox-image img');
					if (image) {
						var width = image.width();
						width += 10;
						
						$(this).parent().find('.essb_checkbox_label').width(width);
					}
				});
			}
			else {
				$(parent_heading).addClass('essb-portlet-heading-closed');
				var content = $(parent_heading).parent().find('.essb-portlet-content');
				if (content.length > 1) content = content[0];
				$(content).slideUp("fast", function() {
					$(content).addClass('essb-portlet-content-closed');
				});
								
			}
		});
	});
	
	// portlet toggle style
	$('.essb-options-container').find('.essb-section-tabs').find('li').each(function(){
		$(this).click(function(e) {
			e.preventDefault();
			//console.log('tab click');
			
			var parent = $(this).parent();
			parent.find('li').each(function(){
				if ($(this).hasClass('active')){
					$(this).removeClass('active');
					var data_tab = $(this).attr('data-tab');
					
					if ($('.ess-section-tab-'+data_tab).length) {
						if ($('.ess-section-tab-'+data_tab).hasClass('active')) {
							$('.ess-section-tab-'+data_tab).fadeOut('fast');
							$('.ess-section-tab-'+data_tab).removeClass('active');
						}
					}
				}
			});
			
			$(this).addClass('active');
			var data_tab = $(this).attr('data-tab');
			
			if ($('.ess-section-tab-'+data_tab).length) {
				$('.ess-section-tab-'+data_tab).fadeIn('fast');
				$('.ess-section-tab-'+data_tab).addClass('active');
				
				window.setTimeout(function() {
					$('.CodeMirror').each(function(i, el){
					    el.CodeMirror.refresh();
					});
				}, 1);
			}
		});
	});
	
	$('.essb-options-container').find('.essb-main-network-order').find('.essb-clickable-order').each(function(){
		$(this).click(function(e) {
			var state = $(this).is(':checked');
			
			if (state) {
				if ($(this).parent().parent().length) {
					$(this).parent().parent().addClass('active');
				}
			}
			else {
				if ($(this).parent().parent().length) {
					$(this).parent().parent().removeClass('active');
				}
			}
		});
	});
	
	$(".essb-settings-wrap").find(".essb-header-status").each(function() {
		$(this).fadeIn(300);
	});
	
	// quick filter control
	
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
	
	function quickFilterDebounceRun () {
		var value = $(this).val();
		value = value.toLowerCase();
		
		if (value.length > 2)
			console.log("search value = "+value);
		
		var filterContainer = $(this).attr('data-filter') || '';
		if (filterContainer == '') return;
		
		var element = $('#'+filterContainer);
		if (!element.length) return;
		
		$(element).find("li").each(function(){
		    if (value == '') {
		    	$(this).removeClass('filter-yes');
		    	$(this).removeClass('filter-no');
		    } 
		    else {
		    	var singleValue = ($(this).attr('data-filter-value') || '').toLowerCase();
		    	$(this).removeClass('filter-yes');
		    	$(this).removeClass('filter-no');
		    	if (singleValue.indexOf(value) > -1) 
		    		$(this).addClass('filter-yes');
		    	else
		    		$(this).addClass('filter-no');
		    }
		});
	}
	
	$(".essb-options .input-filter").keyup(debounce(quickFilterDebounceRun, 300));

	
	// AdminPopupWindow Class
	var essbAdminPopupHolder = {};
	
	var essbAdminPopup = function() {
		this.windowId = '';
		this.windowHolder = null;
		this.windowWidth = '';
		this.windowHeight = '';
		
		this.options = {};
		
		this.init = function(instanceId, userContent, options) {
			if (!$(instanceId).length) return;
			
			this.options = options ? options : {};
			
			this.windowId = instanceId;
			this.windowHolder = $(instanceId);
			
			if (!userContent || typeof(userContent) == 'undefined') userContent = '';

			if (userContent != '')
				this.setUserContent(userContent);
			
			this.windowWidth = $(this.windowHolder).attr('data-width') || '';
			this.windowHeight = $(this.windowHolder).attr('data-height') || '';
			
			if (this.windowWidth == 'auto') {
				if ($('.wrap').length)
					this.windowWidth = $('.essb-settings-wrap').width() - 160;
				else
					this.windowWidth = $(window).width() - 160;
			}

			if (this.windowHeight == 'auto') {
				this.windowHeight = $(window).height() - 100;
			}

			
			var win_width = $( window ).width();
			var doc_height = $(window).height();
			
			if (this.windowWidth > (win_width - 60)) this.windowWidth = win_width - 60;
			if (this.windowHeight > (doc_height - 60)) this.windowHeight = doc_height - 60;
			
			if ($(this.windowHolder).find('.essb-helper-popup-content').length) {
				var contentHolder = $(this.windowHolder).find('.essb-helper-popup-content'),
					contentHolderHeight = $(contentHolder).actual('height');
				
				var contentOffsetCorrection = 140;
				if (this.options['noCommandButtons'])
					contentOffsetCorrection = 90;
				
				$(this.windowHolder).find('.essb-helper-popup-content').css({height: (this.windowHeight - contentOffsetCorrection)+'px'});
				
				if (contentHolderHeight > (this.windowHeight - contentOffsetCorrection)) 
					$(this.windowHolder).find('.essb-helper-popup-content').css({overflowY: 'scroll'});
			}
			
			$(this.windowHolder).css( { width: this.windowWidth+'px', height: this.windowHeight+'px'});

		}
		
		this.show = function(withAdminBar) {
			
			
			jQuery.fn.extend({
		        center: function () {
		            return this.each(function() {
		                var top = (jQuery(window).height() - jQuery(this).outerHeight()) / 2;
		                var left = (jQuery(window).width() - jQuery(this).outerWidth()) / 2;
		                jQuery(this).css({position:'fixed', margin:0, top: (top > 0 ? top : 0)+'px', left: (left > 0 ? left : 0)+'px'});
		            });
		        }
		    }); 
			
			jQuery.fn.extend({
		        centerWithAdminBar: function () {
		            return this.each(function() {
		                var top = (jQuery(window).height() - jQuery(this).outerHeight()) / 2;
		                var left = (jQuery(window).width() - jQuery(this).outerWidth()) / 2;
		                
		                if (jQuery('#adminmenuwrap').length)
		                	left = left + (jQuery('#adminmenuwrap').width() / 2);
		                
		                jQuery(this).css({position:'fixed', margin:0, top: (top > 0 ? top : 0)+'px', left: (left > 0 ? left : 0)+'px'});
		            });
		        }
		    }); 
			
			if (withAdminBar)
				$(this.windowHolder).centerWithAdminBar();
			else
				$(this.windowHolder).center();
			
			$(this.windowHolder).fadeIn(400);
			$('.essb-helper-popup-overlay').fadeIn(200);
			
			essbAdminPopupHolder[this.windowId] = this;
			essbAdminPopupHolder['last'] = this;
			
			this.assignClose();
		}
		
		this.setUserContent = function(content) {
			if ($(this.windowHolder).find('.essb-helper-popup-content').length) { 
				$(this.windowHolder).find('.essb-helper-popup-content').html(content);
				
				var contentHolderHeight = $(this.windowHolder).find('.essb-helper-popup-content').actual('height');
				
				if (contentHolderHeight > (this.windowHeight - 100 - 40)) 
					$(this.windowHolder).find('.essb-helper-popup-content').css({overflowY: 'scroll'});
			}
			
		}
		
		this.close = function() {
			$(this.windowHolder).fadeOut(200);
			$(".essb-helper-popup-overlay").fadeOut(400);

		}
		
		this.assignClose = function() {
			if ($(this.windowHolder).find('.essb-helper-popup-close').length) {
				$(this.windowHolder).find('.essb-helper-popup-close').attr('data-window', this.windowId);
				$(this.windowHolder).find('.essb-helper-popup-close').click(function(e) {

					e.preventDefault();
					
					var classHolderId = $(this).attr('data-window') || '';
					
					if (classHolderId != '' && essbAdminPopupHolder[classHolderId])
						essbAdminPopupHolder[classHolderId].close();
				});
			}
			//essb-assign-popupclose
			if ($(this.windowHolder).find('.essb-assign-popupclose').length) {
				$(this.windowHolder).find('.essb-assign-popupclose').attr('data-window', this.windowId);
				$(this.windowHolder).find('.essb-assign-popupclose').click(function(e) {
					
					e.preventDefault();
					
					var classHolderId = $(this).attr('data-window') || '';
					
					if (classHolderId != '' && essbAdminPopupHolder[classHolderId])
						essbAdminPopupHolder[classHolderId].close();
				});
			}
			
			if ($('.essb-helper-popup-overlay').length) {
				$('.essb-helper-popup-overlay').click(function(e) {
					if (essbAdminPopupHolder['last'])
						essbAdminPopupHolder['last'].close();
				});
			}

		}
	}
	
	/**
	 * essbSettingsHelper
	 * 
	 * Real time live admin settings helper to generate and redraw components
	 */
	var essbSettingsHelper = {
		version: '5.0',
		cache: {}
	};
	
	essbSettingsHelper.setCache = function(key, value) {
		essbSettingsHelper.cache[key] = value;
	}
	
	essbSettingsHelper.getCache = function(key) {
		return essbSettingsHelper.cache[key] ? essbSettingsHelper.cache[key] : null;
	}
	
	essbSettingsHelper.resetCache = function() {
		essbSettingsHelper.cache = {};
	}
	
	essbSettingsHelper.chooseSocialNetworks = function(activeNetworks) {
		var popup = new essbAdminPopup();
		popup.init('#essb-networkselect', essbSettingsHelper.generateNetworkSelection(activeNetworks));
		popup.show(true);
		
		essbSettingsHelper.assingNetworkSelection();
		essbSettingsHelper.assingNetworksFilter();
	}
	
	essbSettingsHelper.assingNetworkSelection = function() {
		$('.essb-admin-networkselect').click(function(e){
			e.preventDefault();
			
			$(this).toggleClass('active');
		});
	}
	
	essbSettingsHelper.assingNetworksFilter = function() {
		function runNetworkFilterDebounce () {
			var value = $(this).val();
			value = value.toLowerCase();
			
			if (value.length > 2)
				console.log("search value = "+value);
			
			
			$('.essb-admin-networkselect').each(function(){
			    if (value == '') {
			    	$(this).removeClass('filter-yes');
			    	$(this).removeClass('filter-no');
			    } 
			    else {
			    	var singleValue = ($(this).attr('data-filter-value') || '').toLowerCase();
			    	$(this).removeClass('filter-yes');
			    	$(this).removeClass('filter-no');
			    	if (singleValue.indexOf(value) > -1) 
			    		$(this).addClass('filter-yes');
			    	else
			    		$(this).addClass('filter-no');
			    }
			});
		}
		
		$("#essb-network-filter").keyup(debounce(runNetworkFilterDebounce, 300));
	}
	
	essbSettingsHelper.generateNetworkSelection = function(activeNetworks) {
		if (typeof(activeNetworks) == 'undefined') activeNetworks = {};
		
		var output = [];
		
		if (!essbAdminSettings.networks) {
			console.log('[Admin Error]: missing social networks');
			return;
		}
		
		var networksIndex = [];
		for (var network in activeNetworks) {
			networksIndex.push(network);
		}
		
		for (var network in essbAdminSettings.networks) {
			if (!activeNetworks[network])
				networksIndex.push(network);
		}
		
		output.push('<div class="essb-filter-networks">');
		output.push('<input type="text" class="input-element essb-network-filter" id="essb-network-filter" placeholder="Search Networks" />')
		output.push('</div>');
		
		for (var i=0;i<networksIndex.length;i++) {
			var network = networksIndex[i],
				networkDetails = essbAdminSettings.networks[network] || {},
				name = networkDetails['name'] || '',
				isActive = activeNetworks[network] ? true: false;
			
			output.push('<div class="essb-admin-networkselect essb-admin-network-' + network+' essb-network-color-' + network + ' '+(isActive ? 'active' : '')+'" data-filter-value="'+name+'" data-network="'+network+'">');
			output.push('<span class="essb_icon essb_icon_' + network+'"></span>');
			output.push('<span class="essb-network-name">' + name + '</span>');
			output.push('<span class="essb-active"><i class="fa fa-check"></i></span>')
			output.push('</div>');
		}
		
		return output.join('');
	}
	
	essbSettingsHelper.getSelectedSocialNetworks = function() {
		var active = [];
		
		$('.essb-admin-networkselect').each(function() {
			if ($(this).hasClass('active')) {
				var networkId = $(this).attr('data-network') || '';
				if (networkId != '')
					active.push(networkId);
			}
		});
		
		return active;
	}
	
	essbSettingsHelper.startNetworkSelection = function(componentKey) {
		console.log('component key = ' + componentKey);
		
		if (!$('.essb-componentkey-'+componentKey).length)
			return;
		
		var active_networks = {}, active_network_texts = {};
		
		$('.essb-componentkey-'+componentKey).find('li').each(function(){
			var network = $(this).attr('data-network');
			if (network != '' && network != 'add')
				active_networks[network] = 'true';
			
			if ($(this).find('.essb-single-network-name input').length) {
				var networkSaveText = $(this).find('.essb-single-network-name input').val();
				active_network_texts[network] = networkSaveText;
			}
		})
		
		essbSettingsHelper.chooseSocialNetworks(active_networks);
		essbSettingsHelper.setCache('cache-'+componentKey, active_network_texts);
		
		if ($('#essb-button-confirm-select').length) {
			$('#essb-button-confirm-select').attr('data-redraw', componentKey);
		}
		
	};
	
	essbSettingsHelper.removeNetwork = function(sender) {
	
		$(sender).parent().remove();
	}
	
	window.essbSettingsHelper = essbSettingsHelper;
	
	/** 
	 * Dynamic Share Buttons Generator Object 
	 */
	var essbPreviewButtonsHolder = {};
	
	var essbPreviewButtons = {
			
		init: function() {
			$('.essb-component-buttons-livepreview').each(function() {
				var settings = $(this).attr('data-settings') || '';
				
				if (settings == '') return;
				
				var previewOptions = {};
				
				try {
					previewOptions = eval(settings);
				}
				catch (e) {				
				}
				
				var uniqueID = 'essb-lv-' + (new Date()).getTime();
				$(this).attr('id', uniqueID);
				essbPreviewButtonsHolder[uniqueID] = {
						'id': uniqueID,
						'options': previewOptions
				}
				
				for (var key in previewOptions) {
					if (key == 'networks') continue;
					
					var elementID = previewOptions[key] || '';
					if (!$('#'+elementID).length) continue;
					
					$('#'+elementID).attr('data-preview-id', uniqueID);
					$('#'+elementID).change(function(e) {
						var previewRedrawID = $(this).attr('data-preview-id') || '';
						if (previewRedrawID == '') return;
						
						essbPreviewButtons.draw(previewRedrawID);
					});
				}
			});
		},
		
		draw: function(id) {
			var drawSettings = {};
			if (!essbPreviewButtonsHolder[id]) return;
			
			
			for (var key in essbPreviewButtonsHolder[id].options) {
				if (key == 'networks')
					drawSettings[key] = essbPreviewButtonsHolder[id].options[key];
				else {
					var elementID = essbPreviewButtonsHolder[id].options[key];
					if (!$('#'+elementID).length) continue;
					
					var type = $('#'+elementID).attr('type') || '';
					
					if (type == 'checkbox')
						drawSettings[key] = $('#'+elementID).is(':checked');
					else
						drawSettings[key] = $('#'+elementID).val();
				}
			}
			
			//console.log(drawSettings);
			
			var button_style = drawSettings['button_style'] || 'button',
				additional_classes = '',
				name_hidde_class = '';
			
			if (button_style == 'icon_hover')
				name_hidde_class = 'essb_hide_name';
			if (button_style == 'icon')
				name_hidde_class = 'essb_force_hide_name essb_force_hide';
			if (button_style == 'button_name')
				name_hidde_class = 'essb_hide_icon';
			if (button_style == 'vertical')
				name_hidde_class = 'essb_vertical_name';
			
			var template = drawSettings['template'] || '5';
			
			if (essbAdminSettings) {
				template = Number(template);
				if (essbAdminSettings.templates[template])
					template = essbAdminSettings.templates[template];
			}
			additional_classes += ' essb_template_' + template;
			
			if (drawSettings['nospace'])
				additional_classes += ' essb_nospace';
			
			if (drawSettings['animation'] != '' && drawSettings['animation'] != 'no')
				additional_classes += ' ' + drawSettings['animation'];
			
			var align = drawSettings['align'] || 'left';
			if (align == 'center')
				additional_classes += ' essb_links_center';
			if (align == 'right')
				additional_classes += ' essb_links_right';
			
			
			if (drawSettings ['counter_pos'] == 'leftm') {
				additional_classes += ' essb_counter_modern_left';
			}

			if (drawSettings ['counter_pos'] == 'rightm') {
				additional_classes += ' essb_counter_modern_right';
			}

			if (drawSettings ['counter_pos'] == 'top') {
				additional_classes += ' essb_counter_modern_top';
			}

			if (drawSettings ['counter_pos'] == 'topm') {
				additional_classes += ' essb_counter_modern_top_mini';
			}
			if (drawSettings ['counter_pos'] == 'bottom') {
				additional_classes += ' essb_counter_modern_bottom';
			}
			if (drawSettings ['counter_pos'] == 'topn') {
				additional_classes += ' essb_counter_modern_topn';
			}
			
			if (drawSettings['essb_counters'])
				additional_classes += ' essb_counters';
			
			var additional_link_styles = '';
			var additional_full_width_correction = '';
			var fullwidth_first = '';
			var fullwidth_second = '';
			
			if (drawSettings['width'] != '') {
				
				if (drawSettings['width'] == 'fixed') {
					additional_classes += ' essb_fixedwidth_';
					
					var userWidth = drawSettings['fixed_width'] || '80';					
					additional_link_styles += ' width:' + userWidth+'px';
					
					if (drawSettings['fixed_align'] == 'center' || drawSettings['fixed_align'] == '') {
						additional_classes += ' essb_network_align_center';
					}
					if (drawSettings['fixed_align'] == 'right') {
						additional_classes += ' essb_network_align_right';
					}
				}
				
				if (drawSettings['width'] == 'column') {
					additional_classes += ' essb_width_columns_' + drawSettings['columns_count'];
					
					if (drawSettings['columns_align'] == 'center') {
						additional_classes += ' essb_network_align_center';
					}
					if (drawSettings['columns_align'] == 'right') {
						additional_classes += ' essb_network_align_right';
					}
				}
				
				if (drawSettings['width'] == 'flex')
					additional_classes += ' essb_width_flex';
				
				if (drawSettings['width'] == 'full') {
					additional_classes += ' essb_fullwidth';
					
					var single_percent = 20;
					
					if (drawSettings['full_first']) {
						var userPercents = Number(drawSettings['full_first']) || 0;
						
						fullwidth_first = 'width:'+drawSettings['full_first'] + '%';
						
						var divideBy = 4;
						if (drawSettings['full_second']) {
							userPercents += Number(drawSettings['full_second']) || 0;
							divideBy = 3;
							
							fullwidth_second = 'width:'+drawSettings['full_second'] + '%';
						}
						
						single_percent = (100 - userPercents) / divideBy;
						
					}
					
					additional_link_styles += ' width:'+single_percent+'%';
					
					additional_full_width_correction = 'width:' + ((drawSettings['full_button']) ? drawSettings['full_button'] : '98') + '%';
					
					if (fullwidth_first == '')
						fullwidth_first = ' width:'+single_percent+'%';
					if (fullwidth_second == '')
						fullwidth_second = ' width:'+single_percent+'%';
				}
			}
			
			var output = [];
			
			output.push('<div class="essb_links ' + additional_classes + '" style="margin: 0 !important;">');
			
			output.push('<ul class="essb_links_list '+name_hidde_class+'">');
			
			// generate total counter output
			
			if (drawSettings['counter'] && drawSettings['total_counter_pos'] != 'hidden') {
				if (drawSettings['total_counter_pos'] == 'left') {
					output.push('<li class="essb_item essb_totalcount_item"><span class="essb_totalcount essb_t_l"><span class="essb_total_text">Total:</span><span class="essb_t_nb">1.2K</span></span></li>');
				}
				
				if (drawSettings['total_counter_pos'] == 'leftbig') {
					output.push('<li class="essb_item essb_totalcount_item"><span class="essb_totalcount essb_t_l_big"><span class="essb_t_nb">1.2K<span class="essb_t_nb_after">SHARES</span></span></span></li>');
				}

				if (drawSettings['total_counter_pos'] == 'leftbigicon') {
					output.push('<li class="essb_item essb_totalcount_item"><span class="essb_totalcount essb_t_l_big essb_total_icon essb_icon_share-tiny"><span class="essb_t_nb">1.2K<span class="essb_t_nb_after">SHARES</span></span></span></li>');
				}
				
				if (drawSettings['total_counter_pos'] == 'before') {
					output.push('<li class="essb_item essb_totalcount_item essb_totalcount_item_before"><span class="essb_totalcount essb_t_before"><span class="essb_t_nb">1.2K Shares</span></span></li>');
				}
			}
			
			var cached_code_left = '';
			var cached_code_right = '';
			var cached_code_insidebefore = '';
			var cached_code_insideafter = '';
			var cached_code_before = '';
			var cached_code_after = '';
			
			if (drawSettings['counter']) {
				var counter_pos = drawSettings['counter_pos'];
				
				if (counter_pos == 'left' || counter_pos == '' || counter_pos == 'leftm' || counter_pos == 'topm' || counter_pos == 'top') {
					cached_code_left = essbPreviewButtons.generateButtonCounterCode('');
				}
				
				if (counter_pos == 'right' || counter_pos == 'rightm') {
					cached_code_right =  essbPreviewButtons.generateButtonCounterCode('_right');
				}
				if (counter_pos == 'insidename' || counter_pos == 'inside' || counter_pos == 'bottom') {
					cached_code_insideafter =  essbPreviewButtons.generateButtonCounterCode('_'+counter_pos);
				}
				if (counter_pos == 'insidebeforename') {
					cached_code_insidebefore =  essbPreviewButtons.generateButtonCounterCode('_'+counter_pos);
				}
				if (counter_pos == 'hidden') {
					cached_code_right =  essbPreviewButtons.generateButtonCounterCode('_'+counter_pos);
				}
				if (counter_pos == 'topn') {
					cached_code_before =  essbPreviewButtons.generateButtonCounterCode('_'+counter_pos);
				}
				if (counter_pos == 'insidehover') {
					cached_code_after =  essbPreviewButtons.generateButtonCounterCode('_'+counter_pos);
				}
				
				if (counter_pos == 'hidden') {
					cached_code_left = '';
					cached_code_before = '';
					cached_code_insidebefore = '';
					cached_code_insideafter = '';
					cached_code_after = '';
					cached_code_right = '';
				}
			}
			
			for (var i = 0;i < drawSettings['networks'].length;i++) {
				var networkDetails = drawSettings['networks'][i];
				var nameDisplay = networkDetails['name'];
				
				if (drawSettings['counter'] && drawSettings['counter_pos'] == 'inside')
					nameDisplay = '';
				
				var useDrawingStyles = additional_link_styles;
				
				if (drawSettings['width'] == 'full' && i == 0)
					useDrawingStyles = fullwidth_first;
				if (drawSettings['width'] == 'full' && i == 1)
					useDrawingStyles = fullwidth_second;
				
				output.push('<li class="essb_item essb_link_' + networkDetails['key']+'" style="'+useDrawingStyles+'">');
				output.push(cached_code_left);
				output.push('<a href="#" style="'+additional_full_width_correction+'">');
				output.push(cached_code_before);
				output.push('<span class="essb_icon essb_icon_'+networkDetails['key']+'"></span>');
				output.push('<span class="essb_network_name">' + cached_code_insidebefore + nameDisplay+ cached_code_insideafter +'</span>');
				output.push(cached_code_after);
				output.push('</a>');
				output.push(cached_code_right);
				output.push('</li>');
			}
			
			// total counter right or after
			if (drawSettings['counter'] && drawSettings['total_counter_pos'] != 'hidden') {
				if (drawSettings['total_counter_pos'] == 'right') {
					output.push('<li class="essb_item essb_totalcount_item"><span class="essb_totalcount essb_t_r"><span class="essb_total_text">Total:</span><span class="essb_t_nb">1.2K</span></span></li>');
				}
				
				if (drawSettings['total_counter_pos'] == 'rightbig') {
					output.push('<li class="essb_item essb_totalcount_item"><span class="essb_totalcount essb_t_r_big"><span class="essb_t_nb">1.2K<span class="essb_t_nb_after">SHARES</span></span></span></li>');
				}

				if (drawSettings['total_counter_pos'] == 'rightbigicon') {
					output.push('<li class="essb_item essb_totalcount_item"><span class="essb_totalcount essb_t_r_big essb_total_icon essb_icon_share-tiny"><span class="essb_t_nb">1.2K<span class="essb_t_nb_after">SHARES</span></span></span></li>');
				}
				
				if (drawSettings['total_counter_pos'] == 'after') {
					output.push('<li class="essb_item essb_totalcount_item essb_totalcount_item_before"><span class="essb_totalcount essb_t_before"><span class="essb_t_nb">1.2K Shares</span></span></li>');
				}
			}

			
			output.push('</ul>');
			
			output.push('</div>');
			
			if ($('#'+id).length)
				$('#'+id).html(output.join(''));
		},
		
		generateButtonCounterCode: function(position) {
			var min = 80, max = 600;
			var counterValue = Math.floor(Math.random() * (max - min + 1)) + min;
			return '<span class="essb_counter'+position+'">'+counterValue+'</span>';
		}
	}
	
	essbPreviewButtons.init();
	
	// Example popup call
	//var popup = new essbAdminPopup();
	//popup.show('#essb-testpopup', true);
	
	/*var popup = new essbAdminPopup();
	popup.init('#essb-templateselect', '', {'noCommandButtons': true});
	popup.show();
	*/
	//essbSettingsHelper.chooseSocialNetworks({'facebook':'true', 'twitter':'true', 'whatsapp': 'true'});
	//		popup.init('#essb-networkselect', essbSettingsHelper.generateNetworkSelection(activeNetworks), { 'noCommandButtons': true});

	
	// Assign specific events
	
	$('.essb-popup-select').each(function(){
		$(this).click(function(e) {
			e.preventDefault();
			
			var updateValueID = 'essb_field_' + $(this).attr('data-field') || '',
				updateTextID = $(this).attr('data-field-text') || '',
				callbackWindow = $(this).attr('data-field-window') || '',
				userSelectedValue = $('#' + updateValueID).val();
						
			var popup = new essbAdminPopup();
			popup.init(callbackWindow, '', {'noCommandButtons': true});
			popup.show();
			
			if ($(callbackWindow).find('.essb-component-clickholder').length) {
				$(callbackWindow).find('.essb-component-clickholder').attr('data-field', updateValueID);
				$(callbackWindow).find('.essb-component-clickholder').attr('data-field-text', updateTextID);
				
				$(callbackWindow).find('.essb-component-clickselect').each(function() {
					if ($(this).hasClass('active'))
						$(this).removeClass('active');
					
					var currentElementValue = $(this).attr('data-value') || '';
					if (currentElementValue == userSelectedValue) 
						$(this).addClass('active');
				});
			}
		});
	})
	
	
	if ($('#essb-button-confirm-select').length) {
		$('#essb-button-confirm-select').click(function(e){
			e.preventDefault();
			
			var selected = essbSettingsHelper.getSelectedSocialNetworks();		
			
			var classHolderId = $(this).attr('data-close') || '';
			
			if (classHolderId != '' && essbAdminPopupHolder[classHolderId])
				essbAdminPopupHolder[classHolderId].close();
			
			var redrawKey = $(this).attr('data-redraw') || '';
			var namesCache = essbSettingsHelper.getCache('cache-'+redrawKey);
			if (!namesCache || typeof(namesCache) == 'undefined') namesCache = {};
						
			var positionKey = '';
			if ($('.essb-componentkey-'+redrawKey).length)
				positionKey = $('.essb-componentkey-'+redrawKey).attr('data-position') || '';
			
			var output = [];
			for (var i=0;i < selected.length;i++) {
				var network = selected[i],
					networkDetails = essbAdminSettings.networks[network] || {},
					name = networkDetails['name'] || '',
					cachedName = typeof(namesCache[network]) != 'undefined' ? namesCache[network] : positionKey != '' ? '' : name;
					
				output.push( '<li class="essb-admin-networkselect-single essb-network-color-'+network+'" data-network="'+network+'" data-key="'+redrawKey+'">');
				if (positionKey != '') 
					output.push( '<input type="hidden" name="essb_options['+positionKey+'_networks][]" value="'+network+'"/>');
				else
					output.push( '<input type="hidden" name="essb_options[networks][]" value="'+network+'"/>');
				output.push( '<span class="essb-icon-remove fa fa-times" onclick="essbSettingsHelper.removeNetwork(this); return false;"></span>');
				output.push( '<span class="essb_icon essb_icon_'+network+'"></span>');
				output.push( '<span class="essb-sns-name">'+name+'</span>');
				output.push( '<span class="essb-single-network-name">');
				if (positionKey != '')
					output.push( 'Personalize text on button:'+'<br/><input type="text" class="input-element" name="essb_options['+positionKey+'_'+network+'_name]" value="'+cachedName+'"/>');
				else
					output.push( 'Personalize text on button:'+'<br/><input type="text" class="input-element" name="essb_options_names['+network+']" value="'+cachedName+'"/>');
				output.push( '</span>');
				output.push( '</li>');
			}
			
			network = 'add';
			output.push( '<li class="essb-admin-networkselect-single essb-network-color-'+network+'" data-network="'+network+'" data-key="'+redrawKey+'" onclick="essbSettingsHelper.startNetworkSelection(\''+redrawKey+'\'); return false;">');
			output.push( '<span class="essb_icon fa fa-plus-square"></span>');
			output.push( '<span class="essb-sns-name">Add more networks</span>');
			output.push( '</li>');
			
			if ($('.essb-componentkey-'+redrawKey).length) {
				$('.essb-componentkey-'+redrawKey).html(output.join(''));
				
				if ($('.essb-componentkey-'+redrawKey).hasClass('essb-sortable')) {
					var element = $('.essb-componentkey-'+redrawKey).attr("id");
					jQuery('#'+element).sortable2();
				}
			}
		});
	}
	
	$('.essb-component-clickselect').each(function(){
		$(this).click(function(e){
			e.preventDefault();
			
			$(this).parent().find('.essb-component-clickselect').each(function(){
				if ($(this).hasClass('active'))
					$(this).removeClass('active');
			});
			
			$(this).addClass('active');
			
			var selectedValue = $(this).attr('data-value') || '',
				selectedText = $(this).attr('data-text') || '',
				valueId = $(this).parent().attr('data-field') || '',
				valueTextId = $(this).parent().attr('data-field-text') || '';
			
			var classHolderId = '#' + $(this).parent().parent().parent().attr('id') || '';
			if (classHolderId != '' && essbAdminPopupHolder[classHolderId])
				essbAdminPopupHolder[classHolderId].close();
			
			if ($('#'+valueId).length) {
				$('#'+valueId).val(selectedValue);
				$('#'+valueId).trigger('change');
			}
			if ($('#'+valueTextId).length) 
				$('#'+valueTextId).html(selectedText);
		});
	});
	
	$('.essb-component-toggleselect .toggleselect-item').each(function() {
		$(this).click(function(e) {
			e.preventDefault();
			
			$(this).parent().find('.toggleselect-item').each(function(){
				if ($(this).hasClass('active'))
					$(this).removeClass('active');
			});
			
			$(this).addClass('active');
			
			var selectedValue = $(this).attr('data-value') || '';
			$(this).parent().find('.toggleselect-holder').val(selectedValue);
			
			$(this).parent().find('.toggleselect-holder').trigger('change');
		});
 	});
	
	$('.essb-component-groupselect .toggleselect-item').each(function() {
		$(this).click(function(e) {
			e.preventDefault();
			
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
				$(this).find('.toggleselect-holder').attr('checked', false);
				$(this).find('.toggleselect-holder').trigger('change');
			}
			else {
				$(this).addClass('active');
				$(this).find('.toggleselect-holder').attr('checked', true);
				$(this).find('.toggleselect-holder').trigger('change');
			}
			
		});
 	});
	
	$('.essb-component-toggleselect .toggleselect-holder').each(function(){
		var id = $(this).attr('id') || '';
		
		if (id.indexOf('_button_width') > -1) {

			$(this).change(function(e){
				var value = $(this).val(),
					id = $(this).attr('id') || '';
				id = id.replace('essb_options_', '');
				var idParts = id.split('_'), location = idParts[0];
				
				$('#'+location+'-essb-fixed-width').hide();
				$('#'+location+'-essb-full-width').hide();
				$('#'+location+'-essb-column-width').hide();
				
				if (value == 'fixed')
					$('#'+location+'-essb-fixed-width').show();
				if (value == 'full')
					$('#'+location+'-essb-full-width').show();
				if (value == 'column')
					$('#'+location+'-essb-column-width').show();
			});
			
			$(this).trigger('change');
		}
		
	});
	
	$('.essb-single-position-select .essb-single').each(function(){
		$(this).click(function(e) {
			e.preventDefault();
			
			$(this).parent().find('.essb-single').each(function(){
				if ($(this).hasClass('active'))
					$(this).removeClass('active');
			});
			
			$(this).addClass('active');
			
			var selectedValue = $(this).attr('data-value') || '';
			$(this).parent().find('.value-holder').val(selectedValue);
			
			$(this).parent().find('.value-holder').trigger('change');
		});
	});
	
	$('.essb-multi-position-select .essb-single').each(function(){
		$(this).click(function(e) {
			e.preventDefault();
			
			var state = false;
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
				state = false;
			}
			else {
				$(this).addClass('active');
				state = true;
			}
				
			var selectedValue = $(this).attr('data-value') || '';
			$(this).find('.value-holder').attr('checked', state);			
			$(this).find('.value-holder').trigger('change');
		});
	});
	
	$('.essb-position-select .essb-single .customize').each(function() {
		$(this).click(function(e) {
			e.preventDefault();
			e.stopPropagation();
			
			var menuElement = $(this).attr('data-menu') || '',
				subMenuElement = $(this).attr('data-sub-menu') || '';
			
			if (menuElement != '' && $('#'+menuElement).length)
				$('#'+menuElement).trigger('click');
			if (subMenuElement != '' && $('#'+subMenuElement).length)
				$('#'+subMenuElement).trigger('click');
		});
	});
	
	
	
	
	$('#essb_options_button_width').change(function(e){
		var value = $(this).val();
		
		$('#essb-fixed-width').hide();
		$('#essb-full-width').hide();
		$('#essb-column-width').hide();
		
		if (value == 'fixed')
			$('#essb-fixed-width').show();
		if (value == 'full')
			$('#essb-full-width').show();
		if (value == 'column')
			$('#essb-column-width').show();
	});
	
	$('#essb_options_shorturl_type').change(function(e){
		var value = $(this).val();
		
		$('#essb-short-bitly').hide();
		$('#essb-short-googl').hide();
		$('#essb-short-rebrandly').hide();
		$('#essb-short-post').hide();
		
		if (value == 'goo.gl')
			$('#essb-short-googl').show();
		if (value == 'bit.ly')
			$('#essb-short-bitly').show();
		if (value == 'rebrand.ly')
			$('#essb-short-rebrandly').show();
		if (value == 'po.st')
			$('#essb-short-post').show();
	});
	
	$('#essb_options_subscribe_function').change(function(e){
		var value = $(this).val();
		
		$('#essb-subscribe-link').hide();
		$('#essb-subscribe-content').hide();
		$('#essb-subscribe-form').hide();
		
		if (value == 'form')
			$('#essb-subscribe-content').show();
		if (value == 'link')
			$('#essb-subscribe-link').show();
		if (value == 'mailchimp')
			$('#essb-subscribe-form').show();
	});
	
	//essb_options_subscribe_connector
	$('#essb_options_subscribe_connector').change(function(e){
		var value = $(this).val();
		
		$('.essb-options-container').find('.essb-subscribe-connector').each(function(){
			$(this).hide();
		});

		if ($('#essb-subscribe-connector-'+value).length)
			$('#essb-subscribe-connector-'+value).show();
	
	});
	
	$('#essb_options_counter_mode').change(function(e){
		var value = $(this).val();
		
		if (value == '')
			$('#essb-tabs-counter-tabs-3').show();
		else
			$('#essb-tabs-counter-tabs-3').hide();
	});
	
	$('#essb_options_functions_mode').change(function(e){
		
		var clearAllOptions = function() {
			$('#essb_field_deactivate_module_aftershare').attr('checked', false);
			$('#essb_field_deactivate_module_analytics').attr('checked', false);
			$('#essb_field_deactivate_module_affiliate').attr('checked', false);
			$('#essb_field_deactivate_module_customshare').attr('checked', false);
			$('#essb_field_deactivate_module_message').attr('checked', false);
			$('#essb_field_deactivate_module_metrics').attr('checked', false);
			$('#essb_field_deactivate_module_translate').attr('checked', false);
			$('#essb_field_deactivate_module_conversions').attr('checked', false);
			
			$('#essb_field_deactivate_module_followers').attr('checked', false);
			$('#essb_field_deactivate_module_profiles').attr('checked', false);
			$('#essb_field_deactivate_module_natives').attr('checked', false);
			$('#essb_field_deactivate_module_subscribe').attr('checked', false);
			
			$('#essb_field_deactivate_method_float').attr('checked', false);
			$('#essb_field_deactivate_method_postfloat').attr('checked', false);
			$('#essb_field_deactivate_method_sidebar').attr('checked', false);
			$('#essb_field_deactivate_method_topbar').attr('checked', false);
			$('#essb_field_deactivate_method_bottombar').attr('checked', false);
			$('#essb_field_deactivate_method_popup').attr('checked', false);
			$('#essb_field_deactivate_method_flyin').attr('checked', false);
			$('#essb_field_deactivate_method_postbar').attr('checked', false);
			$('#essb_field_deactivate_method_point').attr('checked', false);
			$('#essb_field_deactivate_method_image').attr('checked', false);
			$('#essb_field_deactivate_method_native').attr('checked', false);
			$('#essb_field_deactivate_method_heroshare').attr('checked', false);
			$('#essb_field_deactivate_method_integrations').attr('checked', false);

			//$('#essb_field_activate_fake').attr('checked', false);
			//$('#essb_field_activate_hooks').attr('checked', false);
		}
		
		var value = $(this).val();
		
		if (value == '')
			$('#essb-functions-holder').show();
		else
			$('#essb-functions-holder').hide();
		

		

		
		if (value == '') {
			
		}
		if (value == 'light') {
			clearAllOptions();
			
			$('#essb_field_deactivate_module_aftershare').attr('checked', true);
			$('#essb_field_deactivate_module_analytics').attr('checked', true);
			$('#essb_field_deactivate_module_affiliate').attr('checked', true);
			$('#essb_field_deactivate_module_customshare').attr('checked', true);
			$('#essb_field_deactivate_module_message').attr('checked', true);
			$('#essb_field_deactivate_module_metrics').attr('checked', true);
			$('#essb_field_deactivate_module_translate').attr('checked', true);
			$('#essb_field_deactivate_module_conversions').attr('checked', true);

			
			$('#essb_field_deactivate_module_followers').attr('checked', true);
			$('#essb_field_deactivate_module_profiles').attr('checked', true);
			$('#essb_field_deactivate_module_natives').attr('checked', true);
			$('#essb_field_deactivate_module_subscribe').attr('checked', true);
			
			$('#essb_field_deactivate_method_float').attr('checked', true);
			$('#essb_field_deactivate_method_postfloat').attr('checked', true);
			$('#essb_field_deactivate_method_topbar').attr('checked', true);
			$('#essb_field_deactivate_method_bottombar').attr('checked', true);
			$('#essb_field_deactivate_method_popup').attr('checked', true);
			$('#essb_field_deactivate_method_flyin').attr('checked', true);
			$('#essb_field_deactivate_method_postbar').attr('checked', true);
			$('#essb_field_deactivate_method_point').attr('checked', true);
			$('#essb_field_deactivate_method_native').attr('checked', true);
			$('#essb_field_deactivate_method_heroshare').attr('checked', true);
			
			$('#essb_field_deactivate_method_integrations').attr('checked', true);
			
			$('.essb-component-functions_mode_mobile').find('[data-value="auto"]').trigger('click');
		}
		
		if (value == 'medium') {
			clearAllOptions();
			$('#essb_field_deactivate_module_affiliate').attr('checked', true);
			$('#essb_field_deactivate_module_customshare').attr('checked', true);
			$('#essb_field_deactivate_module_message').attr('checked', true);
			$('#essb_field_deactivate_module_metrics').attr('checked', true);
			$('#essb_field_deactivate_module_translate').attr('checked', true);
			$('#essb_field_deactivate_module_conversions').attr('checked', true);

			
			$('#essb_field_deactivate_module_followers').attr('checked', true);
			$('#essb_field_deactivate_module_profiles').attr('checked', true);
			$('#essb_field_deactivate_module_natives').attr('checked', true);
			
			$('#essb_field_deactivate_method_postfloat').attr('checked', true);
			$('#essb_field_deactivate_method_topbar').attr('checked', true);
			$('#essb_field_deactivate_method_bottombar').attr('checked', true);
			$('#essb_field_deactivate_method_popup').attr('checked', true);
			$('#essb_field_deactivate_method_point').attr('checked', true);
			$('#essb_field_deactivate_method_native').attr('checked', true);
			$('#essb_field_deactivate_method_heroshare').attr('checked', true);

			$('#essb_field_deactivate_method_integrations').attr('checked', true);
		}
		
		if (value == 'advanced') {
			clearAllOptions();
			$('#essb_field_deactivate_module_customshare').attr('checked', true);

			$('#essb_field_deactivate_module_followers').attr('checked', true);
			$('#essb_field_deactivate_module_profiles').attr('checked', true);
			$('#essb_field_deactivate_module_natives').attr('checked', true);

			$('#essb_field_deactivate_method_native').attr('checked', true);
			$('#essb_field_deactivate_method_heroshare').attr('checked', true);
		}
		
		if (value == 'sharefollow') {
			clearAllOptions();
			$('#essb_field_deactivate_module_customshare').attr('checked', true);

			$('#essb_field_deactivate_module_natives').attr('checked', true);	
			$('#essb_field_deactivate_method_native').attr('checked', true);
			$('#essb_field_deactivate_method_heroshare').attr('checked', true);			
		}
		
		if (value == 'full') {
			clearAllOptions();
			$('.essb-component-functions_mode_mobile').find('[data-value=""]').trigger('click');
		}
	});
	
	$('#essb_options_optimization_level').change(function(e){
		var value = $(this).val();
		console.log('valye ' + value);
		
		if (value == '') {
			$('#optimizations-css').show();
			$('#optimizations-css-builder').show();
			$('#optimizations-other').show();
		}
		else {
			$('#optimizations-css').hide();
			$('#optimizations-css-builder').hide();
			$('#optimizations-other').hide();	
			
			$('#essb_field_use_minified_css').attr('checked', false);
			$('#essb_field_load_css_footer').attr('checked', false);
			$('#essb_field_use_minified_js').attr('checked', false);
			$('#essb_field_scripts_in_head').attr('checked', false);
			$('#essb_field_load_js_async').attr('checked', false);
			$('#essb_field_load_js_defer').attr('checked', false);
			$('#essb_field_remove_ver_resource').attr('checked', false);
			$('#essb_field_precompiled_resources').attr('checked', false);
			$('#essb_options_precompiled_mode').val('');
			$('#essb_field_essb_cache_runtime').attr('checked', false);
			$('#essb_field_essb_cache').attr('checked', false);
			$('#essb_field_essb_cache_static').attr('checked', false);
			$('#essb_field_essb_cache_static_js').attr('checked', false);
			
			$('#essb_field_use_stylebuilder').attr('checked', true);
			$('#essb_field_use_stylebuilder').trigger('click');
			
			if (value == 'level1') {
				$('#essb_field_use_minified_css').attr('checked', true);
				$('#essb_field_use_minified_js').attr('checked', true);
				$('#essb_field_load_js_async').attr('checked', true);
			}
			
			if (value == 'level2') {
				$('#essb_field_use_minified_css').attr('checked', true);
				$('#essb_field_use_minified_js').attr('checked', true);
				$('#essb_field_load_js_async').attr('checked', true);
				$('#essb_field_remove_ver_resource').attr('checked', true);
				$('#essb_field_precompiled_resources').attr('checked', true);
			}
			
			if (value == 'level3') {
				$('#essb_field_use_minified_css').attr('checked', true);
				$('#essb_field_use_minified_js').attr('checked', true);
				$('#essb_field_load_js_async').attr('checked', true);
				$('#essb_field_remove_ver_resource').attr('checked', true);
				$('#essb_options_precompiled_mode').val('js');
				$('#essb_field_precompiled_resources').attr('checked', true);
				$('#optimizations-css-builder').show();
				
				$('#essb_field_use_stylebuilder').attr('checked', false);
				$('#essb_field_use_stylebuilder').trigger('click');
				
			}
		}
	});
	
	$('#essb_options_functions_mode_mobile').change(function(e){
		var value = $(this).val();
		
		if (value == 'deactivate') {
			$('#essb_field_deactivate_mobile_share').attr('checked', true);
		}
		else {
			$('#essb_field_deactivate_mobile_share').attr('checked', false);
		}
	});
	
	$('#essb_component_button_position_mobile_sharebar').change(function(e) {
		if ($(this).is(':checked'))
			$('#essb-panel-sharebar').show();
		else
			$('#essb-panel-sharebar').hide();
	});
	
	$('#essb_component_button_position_mobile_sharebottom').change(function(e) {
		if ($(this).is(':checked'))
			$('#essb-panel-sharebuttons').show();
		else
			$('#essb-panel-sharebuttons').hide();
	});
	
	$('.essb-sortable').each(function() {
		var element = $(this).attr("id");
		jQuery('#'+element).sortable2();
	});
	
	
	
	$('#essb-sortable-essb3fans_networks input[type="checkbox"]').each(function(){
		$(this).click(function(e){
			
			var network = $(this).val();
			if ($(this).is(':checked')) {
				
				if ($('.essb-followers-' + network).length)
					$('.essb-followers-' + network).show();
				
				if ($('.settings-panel-essb3fans_layout_cols_' + network).length)
					$('.settings-panel-essb3fans_layout_cols_' + network).show();
			}
			else {
				if ($('.essb-followers-' + network).length)
					$('.essb-followers-' + network).hide();

				if ($('.settings-panel-essb3fans_layout_cols_' + network).length)
					$('.settings-panel-essb3fans_layout_cols_' + network).hide();
			}
		});
	});
	
	
	// automatic open portlets which are closed but contain active options
	$('.essb-auto-open').each(function(){
		
		var hasOneValue = false;
		
		$(this).find('.essb-portlet-content').find('input').each(function(){
			
			var id = $(this).attr('id') || '',
				type = $(this).attr('type') || '';
						
			if (type == 'checkbox' || type == 'radio') {
				if ($(this).is(':checked'))
					hasOneValue = true;
			}
			
			if (type == 'text') {
				if ($(this).val() != '')
					hasOneValue = true;
			}
		});

		$(this).find('.essb-portlet-content').find('select').each(function(){
			
			if ($(this).val() != '')
				hasOneValue = true;
		});

		if (hasOneValue)
			$(this).find('.essb-portlet-heading').trigger('click');
	});
	
	// trigger specific events
	if ($('#essb_options_button_width').length)
		$('#essb_options_button_width').trigger('change');
	
	if ($('#essb_options_shorturl_type').length)
		$('#essb_options_shorturl_type').trigger('change');
	
	if ($('#essb_options_subscribe_function').length)
		$('#essb_options_subscribe_function').trigger('change');
	
	if ($('#essb_options_subscribe_connector').length)
		$('#essb_options_subscribe_connector').trigger('change');
	
	if ($('#essb_options_counter_mode').length)
		$('#essb_options_counter_mode').trigger('change');
	
	if ($('#essb_options_functions_mode').length)
		$('#essb_options_functions_mode').trigger('change');
	
	if ($('#essb_component_button_position_mobile_sharebar').length)
		$('#essb_component_button_position_mobile_sharebar').trigger('change');
	
	if ($('#essb_component_button_position_mobile_sharebottom').length)
		$('#essb_component_button_position_mobile_sharebottom').trigger('change');
	
	if ($('#essb_options_optimization_level').length)
		$('#essb_options_optimization_level').trigger('change');
	
	$('#essb-sortable-essb3fans_networks input[type="checkbox"]').each(function(){
		var network = $(this).val();
		if ($(this).is(':checked')) {
			
			if ($('.essb-followers-' + network).length)
				$('.essb-followers-' + network).show();
			
			if ($('.settings-panel-essb3fans_layout_cols_' + network).length)
				$('.settings-panel-essb3fans_layout_cols_' + network).show();

		}
		else {
			if ($('.essb-followers-' + network).length)
				$('.essb-followers-' + network).hide();
			
			if ($('.settings-panel-essb3fans_layout_cols_' + network).length)
				$('.settings-panel-essb3fans_layout_cols_' + network).hide();


		}

	});
});

/*!
 * jQuery scrollintoview() plugin and :scrollable selector filter
 *
 * Version 1.8 (14 Jul 2011)
 * Requires jQuery 1.4 or newer
 *
 * Copyright (c) 2011 Robert Koritnik
 * Licensed under the terms of the MIT license
 * http://www.opensource.org/licenses/mit-license.php
 */

(function ($) {
	var converter = {
		vertical: { x: false, y: true },
		horizontal: { x: true, y: false },
		both: { x: true, y: true },
		x: { x: true, y: false },
		y: { x: false, y: true }
	};

	var settings = {
		duration: "fast",
		direction: "both"
	};

	var rootrx = /^(?:html)$/i;

	// gets border dimensions
	var borders = function (domElement, styles) {
		styles = styles || (document.defaultView && document.defaultView.getComputedStyle ? document.defaultView.getComputedStyle(domElement, null) : domElement.currentStyle);
		var px = document.defaultView && document.defaultView.getComputedStyle ? true : false;
		var b = {
			top: (parseFloat(px ? styles.borderTopWidth : $.css(domElement, "borderTopWidth")) || 0),
			left: (parseFloat(px ? styles.borderLeftWidth : $.css(domElement, "borderLeftWidth")) || 0),
			bottom: (parseFloat(px ? styles.borderBottomWidth : $.css(domElement, "borderBottomWidth")) || 0),
			right: (parseFloat(px ? styles.borderRightWidth : $.css(domElement, "borderRightWidth")) || 0)
		};
		return {
			top: b.top,
			left: b.left,
			bottom: b.bottom,
			right: b.right,
			vertical: b.top + b.bottom,
			horizontal: b.left + b.right
		};
	};

	var dimensions = function ($element) {
		var win = $(window);
		var isRoot = rootrx.test($element[0].nodeName);
		return {
			border: isRoot ? { top: 0, left: 0, bottom: 0, right: 0} : borders($element[0]),
			scroll: {
				top: (isRoot ? win : $element).scrollTop(),
				left: (isRoot ? win : $element).scrollLeft()
			},
			scrollbar: {
				right: isRoot ? 0 : $element.innerWidth() - $element[0].clientWidth,
				bottom: isRoot ? 0 : $element.innerHeight() - $element[0].clientHeight
			},
			rect: (function () {
				var r = $element[0].getBoundingClientRect();
				return {
					top: isRoot ? 0 : r.top,
					left: isRoot ? 0 : r.left,
					bottom: isRoot ? $element[0].clientHeight : r.bottom,
					right: isRoot ? $element[0].clientWidth : r.right
				};
			})()
		};
	};

	$.fn.extend({
		scrollintoview: function (options) {
			/// <summary>Scrolls the first element in the set into view by scrolling its closest scrollable parent.</summary>
			/// <param name="options" type="Object">Additional options that can configure scrolling:
			///        duration (default: "fast") - jQuery animation speed (can be a duration string or number of milliseconds)
			///        direction (default: "both") - select possible scrollings ("vertical" or "y", "horizontal" or "x", "both")
			///        complete (default: none) - a function to call when scrolling completes (called in context of the DOM element being scrolled)
			/// </param>
			/// <return type="jQuery">Returns the same jQuery set that this function was run on.</return>

			options = $.extend({}, settings, options);
			options.direction = converter[typeof (options.direction) === "string" && options.direction.toLowerCase()] || converter.both;

			var dirStr = "";
			if (options.direction.x === true) dirStr = "horizontal";
			if (options.direction.y === true) dirStr = dirStr ? "both" : "vertical";

			var el = this.eq(0);
			var scroller = el.closest(":scrollable(" + dirStr + ")");

			// check if there's anything to scroll in the first place
			if (scroller.length > 0)
			{
				scroller = scroller.eq(0);

				var dim = {
					e: dimensions(el),
					s: dimensions(scroller)
				};

				var rel = {
					top: dim.e.rect.top - (dim.s.rect.top + dim.s.border.top),
					bottom: dim.s.rect.bottom - dim.s.border.bottom - dim.s.scrollbar.bottom - dim.e.rect.bottom,
					left: dim.e.rect.left - (dim.s.rect.left + dim.s.border.left),
					right: dim.s.rect.right - dim.s.border.right - dim.s.scrollbar.right - dim.e.rect.right
				};

				var animOptions = {};

				// vertical scroll
				if (options.direction.y === true)
				{
					if (rel.top < 0)
					{
						animOptions.scrollTop = dim.s.scroll.top + rel.top - 40;
					}
					else if (rel.top > 0 && rel.bottom < 0)
					{
						animOptions.scrollTop = dim.s.scroll.top + Math.min(rel.top, -rel.bottom) - 40;
					}
				}

				// horizontal scroll
				if (options.direction.x === true)
				{
					if (rel.left < 0)
					{
						animOptions.scrollLeft = dim.s.scroll.left + rel.left;
					}
					else if (rel.left > 0 && rel.right < 0)
					{
						animOptions.scrollLeft = dim.s.scroll.left + Math.min(rel.left, -rel.right);
					}
				}

				// scroll if needed
				if (!$.isEmptyObject(animOptions))
				{
					if (rootrx.test(scroller[0].nodeName))
					{
						scroller = $("html,body");
					}
					scroller
						.animate(animOptions, options.duration)
						.eq(0) // we want function to be called just once (ref. "html,body")
						.queue(function (next) {
							$.isFunction(options.complete) && options.complete.call(scroller[0]);
							next();
						});
				}
				else
				{
					// when there's nothing to scroll, just call the "complete" function
					$.isFunction(options.complete) && options.complete.call(scroller[0]);
				}
			}

			// return set back
			return this;
		}
	});

	var scrollValue = {
		auto: true,
		scroll: true,
		visible: false,
		hidden: false
	};

	$.extend($.expr[":"], {
		scrollable: function (element, index, meta, stack) {
			var direction = converter[typeof (meta[3]) === "string" && meta[3].toLowerCase()] || converter.both;
			var styles = (document.defaultView && document.defaultView.getComputedStyle ? document.defaultView.getComputedStyle(element, null) : element.currentStyle);
			var overflow = {
				x: scrollValue[styles.overflowX.toLowerCase()] || false,
				y: scrollValue[styles.overflowY.toLowerCase()] || false,
				isRoot: rootrx.test(element.nodeName)
			};

			// check if completely unscrollable (exclude HTML element because it's special)
			if (!overflow.x && !overflow.y && !overflow.isRoot)
			{
				return false;
			}

			var size = {
				height: {
					scroll: element.scrollHeight,
					client: element.clientHeight
				},
				width: {
					scroll: element.scrollWidth,
					client: element.clientWidth
				},
				// check overflow.x/y because iPad (and possibly other tablets) don't dislay scrollbars
				scrollableX: function () {
					return (overflow.x || overflow.isRoot) && this.width.scroll > this.width.client;
				},
				scrollableY: function () {
					return (overflow.y || overflow.isRoot) && this.height.scroll > this.height.client;
				}
			};
			return direction.y && size.scrollableY() || direction.x && size.scrollableX();
		}
	});
})(jQuery);


/*!
 * jQuery lockfixed plugin
 * http://www.directlyrics.com/code/lockfixed/
 *
 * Copyright 2012 Yvo Schaap
 * Released under the MIT license
 * http://www.directlyrics.com/code/lockfixed/license.txt
 *
 * Date: Sun Feb 9 2014 12:00:01 GMT
 */
(function($, undefined){
	$.extend({
		/**
		 * Lockfixed initiated
		 * @param {Element} el - a jquery element, DOM node or selector string
		 * @param {Object} config - offset - forcemargin
		 */
		"lockfixed": function(el, config){
			if (config && config.offset) {
				config.offset.bottom = parseInt(config.offset.bottom,10);
				config.offset.top = parseInt(config.offset.top,10);
			}else{
				config.offset = {bottom: 100, top: 0};	
			}
			var el = $(el);
			if(el && el.offset()){
				var el_position = el.css("position"),
					el_margin_top = parseInt(el.css("marginTop"),10),
					el_position_top = el.css("top"),
					el_top = el.offset().top,
					pos_not_fixed = false;
				
				/* 
				 * We prefer feature testing, too much hassle for the upside 
				 * while prettier to use position: fixed (less jitter when scrolling)
				 * iOS 5+ + Android has fixed support, but issue with toggeling between fixed and not and zoomed view
				 */
				if (config.forcemargin === true || navigator.userAgent.match(/\bMSIE (4|5|6)\./) || navigator.userAgent.match(/\bOS ([0-9])_/) || navigator.userAgent.match(/\bAndroid ([0-9])\./i)){
					pos_not_fixed = true;
				}

				/*
				// adds throttle to position calc; modern browsers should handle resize event fine
				$(window).bind('scroll resize orientationchange load lockfixed:pageupdate',el,function(e){

					window.setTimeout(function(){
						$(document).trigger('lockfixed:pageupdate:async');
					});			
				});
				*/

				$(window).bind('scroll resize orientationchange load lockfixed:pageupdate',el,function(e){
					// if we have a input focus don't change this (for smaller screens)
					if(pos_not_fixed && document.activeElement && document.activeElement.nodeName === "INPUT"){
						return;	
					}

					var top = 0,
						el_height = el.outerHeight(),
						el_width = el.outerWidth(),
						max_height = $(document).height() - config.offset.bottom,
						scroll_top = $(window).scrollTop();
 
					// if element is not currently fixed position, reset measurements ( this handles DOM changes in dynamic pages )
					if (el.css("position") !== "fixed" && !pos_not_fixed) {
						el_top = el.offset().top;
						el_position_top = el.css("top");
					}

					if (scroll_top >= (el_top-(el_margin_top ? el_margin_top : 0)-config.offset.top)){

						if(max_height < (scroll_top + el_height + el_margin_top + config.offset.top)){
							top = (scroll_top + el_height + el_margin_top + config.offset.top) - max_height;
						}else{
							top = 0;	
						}

						if (pos_not_fixed){
							el.css({'marginTop': (parseInt(scroll_top - el_top - top,10) + (2 * config.offset.top))+'px'});
						}else{
							el.css({'position': 'fixed','top':(config.offset.top-top)+'px','width':el_width +"px"});
						}
					}else{
						el.css({'position': el_position,'top': el_position_top, 'width':el_width +"px", 'marginTop': (el_margin_top && !pos_not_fixed ? el_margin_top : 0)+"px"});
					}
				});	
			}
		}
	});
})(jQuery);

///---
/*
 * ScrollToFixed
 * https://github.com/bigspotteddog/ScrollToFixed
 * 
 * Copyright (c) 2011 Joseph Cava-Lynch
 * MIT license
 */
(function($) {
    $.isScrollToFixed = function(el) {
        return !!$(el).data('ScrollToFixed');
    };

    $.ScrollToFixed = function(el, options) {
        // To avoid scope issues, use 'base' instead of 'this' to reference this
        // class from internal events and functions.
        var base = this;

        // Access to jQuery and DOM versions of element.
        base.$el = $(el);
        base.el = el;

        // Add a reverse reference to the DOM object.
        base.$el.data('ScrollToFixed', base);

        // A flag so we know if the scroll has been reset.
        var isReset = false;

        // The element that was given to us to fix if scrolled above the top of
        // the page.
        var target = base.$el;

        var position;
        var originalPosition;
        var originalOffsetTop;
        var originalZIndex;

        // The offset top of the element when resetScroll was called. This is
        // used to determine if we have scrolled past the top of the element.
        var offsetTop = 0;

        // The offset left of the element when resetScroll was called. This is
        // used to move the element left or right relative to the horizontal
        // scroll.
        var offsetLeft = 0;
        var originalOffsetLeft = -1;

        // This last offset used to move the element horizontally. This is used
        // to determine if we need to move the element because we would not want
        // to do that for no reason.
        var lastOffsetLeft = -1;

        // This is the element used to fill the void left by the target element
        // when it goes fixed; otherwise, everything below it moves up the page.
        var spacer = null;

        var spacerClass;

        var className;

        // Capture the original offsets for the target element. This needs to be
        // called whenever the page size changes or when the page is first
        // scrolled. For some reason, calling this before the page is first
        // scrolled causes the element to become fixed too late.
        function resetScroll() {
            // Set the element to it original positioning.
            target.trigger('preUnfixed.ScrollToFixed');
            setUnfixed();
            target.trigger('unfixed.ScrollToFixed');

            // Reset the last offset used to determine if the page has moved
            // horizontally.
            lastOffsetLeft = -1;

            // Capture the offset top of the target element.
            offsetTop = target.offset().top;

            // Capture the offset left of the target element.
            offsetLeft = target.offset().left;

            // If the offsets option is on, alter the left offset.
            if (base.options.offsets) {
                offsetLeft += (target.offset().left - target.position().left);
            }

            if (originalOffsetLeft == -1) {
                originalOffsetLeft = offsetLeft;
            }

            position = target.css('position');

            // Set that this has been called at least once.
            isReset = true;

            if (base.options.bottom != -1) {
                target.trigger('preFixed.ScrollToFixed');
                setFixed();
                target.trigger('fixed.ScrollToFixed');
            }
        }

        function getLimit() {
            var limit = base.options.limit;
            if (!limit) return 0;

            if (typeof(limit) === 'function') {
                return limit.apply(target);
            }
            return limit;
        }

        // Returns whether the target element is fixed or not.
        function isFixed() {
            return position === 'fixed';
        }

        // Returns whether the target element is absolute or not.
        function isAbsolute() {
            return position === 'absolute';
        }

        function isUnfixed() {
            return !(isFixed() || isAbsolute());
        }

        // Sets the target element to fixed. Also, sets the spacer to fill the
        // void left by the target element.
        function setFixed() {
            // Only fix the target element and the spacer if we need to.
            if (!isFixed()) {
                // Set the spacer to fill the height and width of the target
                // element, then display it.
                spacer.css({
                    'display' : target.css('display'),
                    'width' : target.outerWidth(true),
                    'height' : target.outerHeight(true),
                    'float' : target.css('float')
                });

                // Set the target element to fixed and set its width so it does
                // not fill the rest of the page horizontally. Also, set its top
                // to the margin top specified in the options.

                cssOptions={
                    'z-index' : base.options.zIndex,
                    'position' : 'fixed',
                    'top' : base.options.bottom == -1?getMarginTop():'',
                    'bottom' : base.options.bottom == -1?'':base.options.bottom,
                    'margin-left' : '0px'
                }
                if (!base.options.dontSetWidth){ cssOptions['width']=target.width(); };

                target.css(cssOptions);
                
                target.addClass(base.options.baseClassName);
                
                if (base.options.className) {
                    target.addClass(base.options.className);
                }

                position = 'fixed';
            }
        }

        function setAbsolute() {

            var top = getLimit();
            var left = offsetLeft;

            if (base.options.removeOffsets) {
                left = '';
                top = top - offsetTop;
            }

            cssOptions={
              'position' : 'absolute',
              'top' : top,
              'left' : left,
              'margin-left' : '0px',
              'bottom' : ''
            }
            if (!base.options.dontSetWidth){ cssOptions['width']=target.width(); };

            target.css(cssOptions);

            position = 'absolute';
        }

        // Sets the target element back to unfixed. Also, hides the spacer.
        function setUnfixed() {
            // Only unfix the target element and the spacer if we need to.
            if (!isUnfixed()) {
                lastOffsetLeft = -1;

                // Hide the spacer now that the target element will fill the
                // space.
                spacer.css('display', 'none');

                // Remove the style attributes that were added to the target.
                // This will reverse the target back to the its original style.
                target.css({
                    'z-index' : originalZIndex,
                    'width' : '',
                    'position' : originalPosition,
                    'left' : '',
                    'top' : originalOffsetTop,
                    'margin-left' : ''
                });

                target.removeClass('scroll-to-fixed-fixed');

                if (base.options.className) {
                    target.removeClass(base.options.className);
                }

                position = null;
            }
        }

        // Moves the target element left or right relative to the horizontal
        // scroll position.
        function setLeft(x) {
            // Only if the scroll is not what it was last time we did this.
            if (x != lastOffsetLeft) {
                // Move the target element horizontally relative to its original
                // horizontal position.
                target.css('left', offsetLeft - x);

                // Hold the last horizontal position set.
                lastOffsetLeft = x;
            }
        }

        function getMarginTop() {
            var marginTop = base.options.marginTop;
            if (!marginTop) return 0;

            if (typeof(marginTop) === 'function') {
                return marginTop.apply(target);
            }
            return marginTop;
        }

        // Checks to see if we need to do something based on new scroll position
        // of the page.
        function checkScroll() {
            if (!$.isScrollToFixed(target)) return;
            var wasReset = isReset;

            // If resetScroll has not yet been called, call it. This only
            // happens once.
            if (!isReset) {
                resetScroll();
            } else if (isUnfixed()) {
                // if the offset has changed since the last scroll,
                // we need to get it again.

                // Capture the offset top of the target element.
                offsetTop = target.offset().top;

                // Capture the offset left of the target element.
                offsetLeft = target.offset().left;
            }

            // Grab the current horizontal scroll position.
            var x = $(window).scrollLeft();

            // Grab the current vertical scroll position.
            var y = $(window).scrollTop();

            // Get the limit, if there is one.
            var limit = getLimit();

            // If the vertical scroll position, plus the optional margin, would
            // put the target element at the specified limit, set the target
            // element to absolute.
            if (base.options.minWidth && $(window).width() < base.options.minWidth) {
                if (!isUnfixed() || !wasReset) {
                    postPosition();
                    target.trigger('preUnfixed.ScrollToFixed');
                    setUnfixed();
                    target.trigger('unfixed.ScrollToFixed');
                }
            } else if (base.options.maxWidth && $(window).width() > base.options.maxWidth) {
                if (!isUnfixed() || !wasReset) {
                    postPosition();
                    target.trigger('preUnfixed.ScrollToFixed');
                    setUnfixed();
                    target.trigger('unfixed.ScrollToFixed');
                }
            } else if (base.options.bottom == -1) {
                // If the vertical scroll position, plus the optional margin, would
                // put the target element at the specified limit, set the target
                // element to absolute.
                if (limit > 0 && y >= limit - getMarginTop()) {
                    if (!isAbsolute() || !wasReset) {
                        postPosition();
                        target.trigger('preAbsolute.ScrollToFixed');
                        setAbsolute();
                        target.trigger('unfixed.ScrollToFixed');
                    }
                // If the vertical scroll position, plus the optional margin, would
                // put the target element above the top of the page, set the target
                // element to fixed.
                } else if (y >= offsetTop - getMarginTop()) {
                    if (!isFixed() || !wasReset) {
                        postPosition();
                        target.trigger('preFixed.ScrollToFixed');

                        // Set the target element to fixed.
                        setFixed();

                        // Reset the last offset left because we just went fixed.
                        lastOffsetLeft = -1;

                        target.trigger('fixed.ScrollToFixed');
                    }
                    // If the page has been scrolled horizontally as well, move the
                    // target element accordingly.
                    setLeft(x);
                } else {
                    // Set the target element to unfixed, placing it where it was
                    // before.
                    if (!isUnfixed() || !wasReset) {
                        postPosition();
                        target.trigger('preUnfixed.ScrollToFixed');
                        setUnfixed();
                        target.trigger('unfixed.ScrollToFixed');
                    }
                }
            } else {
                if (limit > 0) {
                    if (y + $(window).height() - target.outerHeight(true) >= limit - (getMarginTop() || -getBottom())) {
                        if (isFixed()) {
                            postPosition();
                            target.trigger('preUnfixed.ScrollToFixed');

                            if (originalPosition === 'absolute') {
                                setAbsolute();
                            } else {
                                setUnfixed();
                            }

                            target.trigger('unfixed.ScrollToFixed');
                        }
                    } else {
                        if (!isFixed()) {
                            postPosition();
                            target.trigger('preFixed.ScrollToFixed');
                            setFixed();
                        }
                        setLeft(x);
                        target.trigger('fixed.ScrollToFixed');
                    }
                } else {
                    setLeft(x);
                }
            }
        }

        function getBottom() {
            if (!base.options.bottom) return 0;
            return base.options.bottom;
        }

        function postPosition() {
            var position = target.css('position');

            if (position == 'absolute') {
                target.trigger('postAbsolute.ScrollToFixed');
            } else if (position == 'fixed') {
                target.trigger('postFixed.ScrollToFixed');
            } else {
                target.trigger('postUnfixed.ScrollToFixed');
            }
        }

        var windowResize = function(event) {
            // Check if the element is visible before updating it's position, which
            // improves behavior with responsive designs where this element is hidden.
            if(target.is(':visible')) {
                isReset = false;
                checkScroll();
            }
        }

        var windowScroll = function(event) {
            (!!window.requestAnimationFrame) ? requestAnimationFrame(checkScroll) : checkScroll();
        }

        // From: http://kangax.github.com/cft/#IS_POSITION_FIXED_SUPPORTED
        var isPositionFixedSupported = function() {
            var container = document.body;

            if (document.createElement && container && container.appendChild && container.removeChild) {
                var el = document.createElement('div');

                if (!el.getBoundingClientRect) return null;

                el.innerHTML = 'x';
                el.style.cssText = 'position:fixed;top:100px;';
                container.appendChild(el);

                var originalHeight = container.style.height,
                originalScrollTop = container.scrollTop;

                container.style.height = '3000px';
                container.scrollTop = 500;

                var elementTop = el.getBoundingClientRect().top;
                container.style.height = originalHeight;

                var isSupported = (elementTop === 100);
                container.removeChild(el);
                container.scrollTop = originalScrollTop;

                return isSupported;
            }

            return null;
        }

        var preventDefault = function(e) {
            e = e || window.event;
            if (e.preventDefault) {
                e.preventDefault();
            }
            e.returnValue = false;
        }

        // Initializes this plugin. Captures the options passed in, turns this
        // off for devices that do not support fixed position, adds the spacer,
        // and binds to the window scroll and resize events.
        base.init = function() {
            // Capture the options for this plugin.
            base.options = $.extend({}, $.ScrollToFixed.defaultOptions, options);

            originalZIndex = target.css('z-index')

            // Turn off this functionality for devices that do not support it.
            // if (!(base.options && base.options.dontCheckForPositionFixedSupport)) {
            //     var fixedSupported = isPositionFixedSupported();
            //     if (!fixedSupported) return;
            // }

            // Put the target element on top of everything that could be below
            // it. This reduces flicker when the target element is transitioning
            // to fixed.
            base.$el.css('z-index', base.options.zIndex);

            // Create a spacer element to fill the void left by the target
            // element when it goes fixed.
            spacer = $('<div />');

            position = target.css('position');
            originalPosition = target.css('position');

            originalOffsetTop = target.css('top');

            // Place the spacer right after the target element.
            if (isUnfixed()) base.$el.after(spacer);

            // Reset the target element offsets when the window is resized, then
            // check to see if we need to fix or unfix the target element.
            $(window).bind('resize.ScrollToFixed', windowResize);

            // When the window scrolls, check to see if we need to fix or unfix
            // the target element.
            $(window).bind('scroll.ScrollToFixed', windowScroll);

            // For touch devices, call checkScroll directlly rather than
            // rAF wrapped windowScroll to animate the element
            if ('ontouchmove' in window) {
              $(window).bind('touchmove.ScrollToFixed', checkScroll);
            }

            if (base.options.preFixed) {
                target.bind('preFixed.ScrollToFixed', base.options.preFixed);
            }
            if (base.options.postFixed) {
                target.bind('postFixed.ScrollToFixed', base.options.postFixed);
            }
            if (base.options.preUnfixed) {
                target.bind('preUnfixed.ScrollToFixed', base.options.preUnfixed);
            }
            if (base.options.postUnfixed) {
                target.bind('postUnfixed.ScrollToFixed', base.options.postUnfixed);
            }
            if (base.options.preAbsolute) {
                target.bind('preAbsolute.ScrollToFixed', base.options.preAbsolute);
            }
            if (base.options.postAbsolute) {
                target.bind('postAbsolute.ScrollToFixed', base.options.postAbsolute);
            }
            if (base.options.fixed) {
                target.bind('fixed.ScrollToFixed', base.options.fixed);
            }
            if (base.options.unfixed) {
                target.bind('unfixed.ScrollToFixed', base.options.unfixed);
            }

            if (base.options.spacerClass) {
                spacer.addClass(base.options.spacerClass);
            }

            target.bind('resize.ScrollToFixed', function() {
                spacer.height(target.height());
            });

            target.bind('scroll.ScrollToFixed', function() {
                target.trigger('preUnfixed.ScrollToFixed');
                setUnfixed();
                target.trigger('unfixed.ScrollToFixed');
                checkScroll();
            });

            target.bind('detach.ScrollToFixed', function(ev) {
                preventDefault(ev);

                target.trigger('preUnfixed.ScrollToFixed');
                setUnfixed();
                target.trigger('unfixed.ScrollToFixed');

                $(window).unbind('resize.ScrollToFixed', windowResize);
                $(window).unbind('scroll.ScrollToFixed', windowScroll);

                target.unbind('.ScrollToFixed');

                //remove spacer from dom
                spacer.remove();

                base.$el.removeData('ScrollToFixed');
            });

            // Reset everything.
            windowResize();
        };

        // Initialize the plugin.
        base.init();
    };

    // Sets the option defaults.
    $.ScrollToFixed.defaultOptions = {
        marginTop : 0,
        limit : 0,
        bottom : -1,
        zIndex : 1000,
        baseClassName: 'scroll-to-fixed-fixed'
    };

    // Returns enhanced elements that will fix to the top of the page when the
    // page is scrolled.
    $.fn.scrollToFixed = function(options) {
        return this.each(function() {
            (new $.ScrollToFixed(this, options));
        });
    };
})(jQuery);

/*
* HTML5 Sortable jQuery Plugin
* http://farhadi.ir/projects/html5sortable
*
* Copyright 2012, Ali Farhadi
* Released under the MIT license.
*/
(function($) {
var dragging, placeholders = $();
$.fn.sortable2 = function(options) {
	var method = String(options);
	options = $.extend({
		connectWith: false
	}, options);
	return this.each(function() {
		if (/^(enable|disable|destroy)$/.test(method)) {
			var items = $(this).children($(this).data('items')).attr('draggable', method == 'enable');
			if (method == 'destroy') {
				items.add(this).removeData('connectWith items')
					.off('dragstart.h5s dragend.h5s selectstart.h5s dragover.h5s dragenter.h5s drop.h5s');
			}
			return;
		}
		var isHandle, index, items = $(this).children(options.items);
		var placeholder = $('<' + (/^(ul|ol)$/i.test(this.tagName) ? 'li' : 'div') + ' class="sortable-placeholder">');
		items.find(options.handle).mousedown(function() {
			isHandle = true;
		}).mouseup(function() {
			isHandle = false;
		});
		$(this).data('items', options.items)
		placeholders = placeholders.add(placeholder);
		if (options.connectWith) {
			$(options.connectWith).add(this).data('connectWith', options.connectWith);
		}
		items.attr('draggable', 'true').on('dragstart.h5s', function(e) {
			if (options.handle && !isHandle) {
				return false;
			}
			isHandle = false;
			var dt = e.originalEvent.dataTransfer;
			dt.effectAllowed = 'move';
			dt.setData('Text', 'dummy');
			index = (dragging = $(this)).addClass('sortable-dragging').index();
		}).on('dragend.h5s', function() {
			if (!dragging) {
				return;
			}
			dragging.removeClass('sortable-dragging').show();
			placeholders.detach();
			if (index != dragging.index()) {
				dragging.parent().trigger('sortupdate', {item: dragging});
			}
			dragging = null;
		}).not('a[href], img').on('selectstart.h5s', function() {
			this.dragDrop && this.dragDrop();
			return false;
		}).end().add([this, placeholder]).on('dragover.h5s dragenter.h5s drop.h5s', function(e) {
			if (!items.is(dragging) && options.connectWith !== $(dragging).parent().data('connectWith')) {
				return true;
			}
			if (e.type == 'drop') {
				e.stopPropagation();
				placeholders.filter(':visible').after(dragging);
				dragging.trigger('dragend.h5s');
				return false;
			}
			e.preventDefault();
			e.originalEvent.dataTransfer.dropEffect = 'move';
			if (items.is(this)) {
				if (options.forcePlaceholderSize) {
					placeholder.height(dragging.outerHeight());
				}
				dragging.hide();
				$(this)[placeholder.index() < $(this).index() ? 'after' : 'before'](placeholder);
				placeholders.not(placeholder).detach();
			} else if (!placeholders.is(this) && !$(this).children(options.items).length) {
				placeholders.detach();
				$(this).append(placeholder);
			}
			return false;
		});
	});
};
})(jQuery);


/*! Copyright 2012, Ben Lin (http://dreamerslab.com/)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Version: 1.0.19
 *
 * Requires: jQuery >= 1.2.3
 */
;( function ( factory ) {
if ( typeof define === 'function' && define.amd ) {
    // AMD. Register module depending on jQuery using requirejs define.
    define( ['jquery'], factory );
} else {
    // No AMD.
    factory( jQuery );
}
}( function ( $ ){
  $.fn.addBack = $.fn.addBack || $.fn.andSelf;

  $.fn.extend({

    actual : function ( method, options ){
      // check if the jQuery method exist
      if( !this[ method ]){
        throw '$.actual => The jQuery method "' + method + '" you called does not exist';
      }

      var defaults = {
        absolute      : false,
        clone         : false,
        includeMargin : false,
        display       : 'block'
      };

      var configs = $.extend( defaults, options );

      var $target = this.eq( 0 );
      var fix, restore;

      if( configs.clone === true ){
        fix = function (){
          var style = 'position: absolute !important; top: -1000 !important; ';

          // this is useful with css3pie
          $target = $target.
            clone().
            attr( 'style', style ).
            appendTo( 'body' );
        };

        restore = function (){
          // remove DOM element after getting the width
          $target.remove();
        };
      }else{
        var tmp   = [];
        var style = '';
        var $hidden;

        fix = function (){
          // get all hidden parents
          $hidden = $target.parents().addBack().filter( ':hidden' );
          style   += 'visibility: hidden !important; display: ' + configs.display + ' !important; ';

          if( configs.absolute === true ) style += 'position: absolute !important; ';

          // save the origin style props
          // set the hidden el css to be got the actual value later
          $hidden.each( function (){
            // Save original style. If no style was set, attr() returns undefined
            var $this     = $( this );
            var thisStyle = $this.attr( 'style' );

            tmp.push( thisStyle );
            // Retain as much of the original style as possible, if there is one
            $this.attr( 'style', thisStyle ? thisStyle + ';' + style : style );
          });
        };

        restore = function (){
          // restore origin style values
          $hidden.each( function ( i ){
            var $this = $( this );
            var _tmp  = tmp[ i ];

            if( _tmp === undefined ){
              $this.removeAttr( 'style' );
            }else{
              $this.attr( 'style', _tmp );
            }
          });
        };
      }

      fix();
      // get the actual value with user specific methed
      // it can be 'width', 'height', 'outerWidth', 'innerWidth'... etc
      // configs.includeMargin only works for 'outerWidth' and 'outerHeight'
      var actual = /(outer)/.test( method ) ?
        $target[ method ]( configs.includeMargin ) :
        $target[ method ]();

      restore();
      // IMPORTANT, this plugin only return the value of the first element
      return actual;
    }
  });
}));
