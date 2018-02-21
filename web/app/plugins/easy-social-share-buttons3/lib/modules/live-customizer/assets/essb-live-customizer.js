var debugMode = false;

jQuery(document).ready(function($){
		
	// Assign open of plugin settings	
	if ($('.essb-customizer-toggle').length) 
		$('.essb-customizer-toggle').click(function(e) {
			e.preventDefault();
			
			essbLiveCustomizer.toggle(e);
		});
	
	if ($('.essb-live-customizer-close-icon').length) 
		$('.essb-live-customizer-close-icon').click(function(e){
			e.preventDefault();
			
			essbLiveCustomizer.toggle(e);
		});
	
	if ($('.essb-live-button-customizer-close-icon').length) 
		$('.essb-live-button-customizer-close-icon').click(function(e){
			e.preventDefault();
			
			if ($(essbLiveCustomizer.buttonCustomizer).hasClass('active'))
				$(essbLiveCustomizer.buttonCustomizer).removeClass('active');
		});
	
	if ($('.essb-live-customizer-back').length)
		$('.essb-live-customizer-back').click(function(e){
			e.preventDefault();
			
			essbLiveCustomizer.backToIcons();
		});
	
	// Assing customize on each button location that is not from shortcode
	$('body').find(".essb_links").each(function() {
		if (!$(this).hasClass('essb_displayed_shortcode')) {
			if (debugMode)
				console.log('assing open customization to location');
			
			var position = $(this).attr('data-essb-position') || '';
			if (position == 'more' || position == 'more_popup') return;
			if ($(this).hasClass('location-setup-done')) return;
			
			$(this).append('<div class="essb-location-customize" title="Change display settings for this plugin location" data-position="'+position+'" onclick="essbLiveCustomizer.positionSettingsClick(\''+position+'\');"><i class="fa fa-cog"></i> Customize</div>');
			$(this).addClass('location-setup-done');			
		}
	});
	

	
	// -- Additional Helper Functions
	
	var essbLiveCustomizer = {
			customizer: null,
			icons: null,
			options: null,
			buttonCustomizer: null
	}
	
	essbLiveCustomizer.init = function() {
		if ($('.essb-live-customizer-main').length) 
			essbLiveCustomizer.customizer = $('.essb-live-customizer-main').get();
		if ($('.essb-live-customizer-icons').length)
			essbLiveCustomizer.icons = $('.essb-live-customizer-icons').get();
		if ($('.essb-live-customizer-options').length) 
			essbLiveCustomizer.options = $('.essb-live-customizer-options').get();
		
		if ($('.essb-live-buttons-customizer').length) 
			essbLiveCustomizer.buttonCustomizer = $('.essb-live-buttons-customizer').get();
		
		if (essbLiveCustomizer.icons) {
			$(essbLiveCustomizer.icons).find('.customizer-box').each(function() {
				$(this).click(function(e) {
					e.preventDefault();
					
					var sectionTitle = $(this).attr('data-title') || '',
						sectionID = $(this).attr('data-options') || '';
					
					var options = {'title': sectionTitle, 'section': sectionID};
					if (sectionID != 'close')
						essbLiveCustomizer.iconClick(options);
					else
						essbLiveCustomizer.toggle(e);
					
					if (debugMode)
						console.log('icon click');
				});
			});
		}
	}
	
	essbLiveCustomizer.toggle = function(e) {
		if (debugMode)
			console.log('toggle customizer');
		
		if (!$(essbLiveCustomizer.customizer).hasClass('active'))
			essbLiveCustomizer.backToIcons(true);
		
		if (essbLiveCustomizer.customizer)
			$(essbLiveCustomizer.customizer).toggleClass('active');
	}
	
	essbLiveCustomizer.toggleButtonsPanel = function(e) {
		if (essbLiveCustomizer.buttonCustomizer) {
			if (!$(essbLiveCustomizer.buttonCustomizer).hasClass('active'))
				$(essbLiveCustomizer.buttonCustomizer).addClass('active');
		}
	}
	
	essbLiveCustomizer.backToIcons = function(noAnimation) {
		$('.essb-live-customizer-options-title').hide();
		$('.essb-live-customizer-close').removeClass('active-title');
		if (!noAnimation) {
			$(essbLiveCustomizer.options).slideUp(200);
			$(essbLiveCustomizer.icons).slideDown(300);
		}
		else {
			$(essbLiveCustomizer.options).hide();
			$(essbLiveCustomizer.icons).show();

		}
	}
	
	essbLiveCustomizer.positionSettingsClick = function(dataPosition) {
		essbLiveCustomizer.toggleButtonsPanel();
		essbLiveCustomizer.request('livecustomizer_options', { 'position': dataPosition, 'section': 'position-settings'}, essbLiveCustomizer.showPositionSetup);
	}
	
	essbLiveCustomizer.iconClick = function(options) {
		if (debugMode)
			console.log(options);
		
		if (options['section'] == 'counters' || options['section'] == 'share' || 
				options['section'] == 'mobile' || options['section'] == 'optimize' || options['section'] == 'positions'
					|| options['section'] == 'modules')
			if ($('.essb-live-customizer-options-content').length)
				$('.essb-live-customizer-options-content').html('');
		
		$(essbLiveCustomizer.icons).slideUp(200);
		$(essbLiveCustomizer.options).slideDown(300);
		
		if ($('.essb-live-customizer-options-title').find('.title').length) {
			$('.essb-live-customizer-options-title').find('.title').html(options['title'] || '');
			$('.essb-live-customizer-options-title').show();
			$('.essb-live-customizer-close').addClass('active-title');
		}
		
		if (options['section'] == 'counters' || options['section'] == 'share' || 
				options['section'] == 'mobile' || options['section'] == 'optimize' || options['section'] == 'positions'
					|| options['section'] == 'modules')
			essbLiveCustomizer.request('livecustomizer_options', { 'section': options['section']}, essbLiveCustomizer.showReponse);
	}
	
	essbLiveCustomizer.showPreviewButtons = function(data) {
		if ($('.essb-customizer-preview').length)
			$('.essb-customizer-preview').html(data);
	}
	
	essbLiveCustomizer.showReponse = function(data) {
		if ($('.essb-live-customizer-options-content').length)
			$('.essb-live-customizer-options-content').html(data);
		
		// assign save settings event
		essbLiveCustomizer.assingSaveSettings();
		// assign dynamic loaded control events
		essbLiveCustomizer.assignControlEvents();		
		
		if (typeof(essbLiveCustomizerPostLoad) == 'function')
			essbLiveCustomizerPostLoad();
	}	
	
	essbLiveCustomizer.showPositionSetup = function(data) {
		essbLiveCustomizer.toggleButtonsPanel();
		
		if ($('.essb-live-button-customizer-options-content').length)
			$('.essb-live-button-customizer-options-content').html(data);
		
		// assign save settings event
		essbLiveCustomizer.assingSaveSettings();
		// assign dynamic loaded control events
		essbLiveCustomizer.assignControlEvents();
		// asign live preview action
		essbLiveCustomizer.assingPreviewButton();
		
		if (typeof(essbLiveCustomizerPostLoad) == 'function')
			essbLiveCustomizerPostLoad();
	}
	
	essbLiveCustomizer.request = function(type, params, action) {		
		
		$('.preloader-holder').fadeIn(100);
		
		params['action'] = 'essb_' + type;
		params['nonce'] = essb_settings.essb3_nonce || '';
		params['postid'] = essb_settings.post_id || '';
		
		if (debugMode)
			console.log(params);
		
		$.post(essb_settings.ajax_url, params).done(function( data ) {
			$('.preloader-holder').fadeOut(100);
			if (debugMode)
				console.log('request responce = ' + data);
			
			if (action) {
				//if (debugMode)
				//	console.log('calling action = ' + action)
				
				action(data);
			}
		});
	}
	
	essbLiveCustomizer.assingSaveSettings = function() {
		$('body').find('.essb-section-save').each(function() {
			$(this).click(function(e) {
				e.preventDefault();
				
				var section = $(this).attr('data-section') || '';
				if (debugMode)
					console.log('saving section = ' + section);
				
				if (section != '')					
					essbLiveCustomizer.saveSection(section);
			});
		});
	}
	
	essbLiveCustomizer.assingPreviewButton = function() {
		//essb-update-preview
		$('body').find('.essb-update-preview').each(function() {
			$(this).click(function(e) {
				e.preventDefault();
				
				var section = $(this).attr('data-section') || '';
				if (debugMode)
					console.log('saving section = ' + section);
				
				if (section != '') {
					var options = essbLiveCustomizer.generateSectionOptions(section);
					
					essbLiveCustomizer.request('livecustomizer_preview', options, essbLiveCustomizer.showPreviewButtons);

				}
			});
		});
	}
	
	essbLiveCustomizer.assignControlEvents = function() {
		$(".essb-switch .cb-enable").click(function(){
			var parent = $(this).parents('.essb-switch');
			$('.cb-disable',parent).removeClass('selected');
			$(this).addClass('selected');
			$('.checkbox',parent).attr('checked', true);
			
		});

		$(".essb-switch .cb-disable").click(function(){
			var parent = $(this).parents('.essb-switch');
			$('.cb-enable',parent).removeClass('selected');
			$(this).addClass('selected');
			$('.checkbox',parent).attr('checked', false);

		});
		

		
		// Image Radio & Checkboxes
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
			/*if (image) {
				var width = image.width();
				width += 10;
				
				$(this).parent().find('.essb_radio_label').width(width);
			}*/
			
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


		// sortable
		$('.essb_sortable').each(function() {
			var element = $(this).attr("id");
			jQuery('#'+element).sortable2();
		});
	}
	
	essbLiveCustomizer.generateSectionOptions = function(section) {
		if (!$('.'+section).length) 
			return;
		
		var params = {};
		var listOfParams = [];
		
		$('.'+section).find('.section-save').each(function() {
			var dataUpdate = $(this).attr('data-update') || '',
				dataField = $(this).attr('data-field') || '',
				dataValue = $(this).val(),
				isCheckbox = ($(this).is(':checkbox') || $(this).is(':radio')),
				dataFormat = $(this).attr('data-format') || '';
			
			if (isCheckbox && !$(this).is(':checked'))
				dataValue = '';
			
			//params.push({'update': dataUpdate, 'field': dataField, 'value': dataValue});
			if (dataFormat == 'array') {
				if (!params[dataField]) {
					params[dataField] = {'update': dataUpdate, 'value': []};
					listOfParams.push(dataField);
				}
				if (dataValue != '')
					params[dataField].value.push(dataValue);
			}
			else {
				params[dataField] = {'update': dataUpdate, 'value': dataValue};
				listOfParams.push(dataField);
			}
			
		});
		
		if (debugMode)
			console.log(params);
		
		params['list'] = listOfParams.join('|');
		
		return params;
	}
	
	essbLiveCustomizer.saveSection = function(section) {
		if (!$('.'+section).length) 
			return;
		
		var params = {};
		var listOfParams = [];
		
		$('.'+section).find('.section-save').each(function() {
			var dataUpdate = $(this).attr('data-update') || '',
				dataField = $(this).attr('data-field') || '',
				dataValue = $(this).val(),
				isCheckbox = ($(this).is(':checkbox') || $(this).is(':radio')),
				dataFormat = $(this).attr('data-format') || '';
			
			if (isCheckbox && !$(this).is(':checked'))
				dataValue = '';
			
			//params.push({'update': dataUpdate, 'field': dataField, 'value': dataValue});
			if (dataFormat == 'array') {
				if (!params[dataField])
					params[dataField] = {'update': dataUpdate, 'value': []};
				if (dataValue != '')
					params[dataField].value.push(dataValue);
			}
			else
				params[dataField] = {'update': dataUpdate, 'value': dataValue};
			listOfParams.push(dataField);
		});
		
		if (debugMode)
			console.log(params);
		
		params['list'] = listOfParams.join('|');
		
		if (section == 'section-position-settings')
			essbLiveCustomizer.request('livecustomizer_save', params, essbLiveCustomizer.reloadPage);
		else
			essbLiveCustomizer.request('livecustomizer_save', params, essbLiveCustomizer.promptForReload);
	}
	
	essbLiveCustomizer.promptForReload = function() {
		swal({
			  title: "Your settings are saved!",
			  text: "<strong>Your new setup is ready to use and it will take place once page/post is reloaded.</strong><br/><br/> If you use cache plugin (example: W3 Total Cache, WP Super Cache, WP Rocket) or optimization plugin (example: Autoptimize, BWP Minify) it is highly recommended to clear cache or you may not see the changes.",
			  type: "success",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Reload page to include new setup",
			  cancelButtonText: "Stay on page",
			  closeOnConfirm: true,
			  html: true
			},
			function(){
				location.reload();
			});
	}
	
	essbLiveCustomizer.reloadPage = function() {
		location.reload();
	}
	
	//-- Code Run
	essbLiveCustomizer.init();
	
	window.essbLiveCustomizer = essbLiveCustomizer;
});


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
