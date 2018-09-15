//(function() {
	if(typeof(eg_lang) == 'undefined'){
		eg_lang = {};
		
		eg_lang.essential_grid_shortcode_creator = 'Essential Grid Shortcode Creator';
		eg_lang.shortcode_generator = 'Shortcode Generator';
		eg_lang.please_add_at_least_one_layer = 'Please add at least one Layer.';
		eg_lang.choose_image = 'Choose Image';
		
		eg_lang.shortcode_parsing_successfull = 'Shortcode parsing successfull. Items can be found in step 3';
		eg_lang.shortcode_could_not_be_correctly_parsed = 'Shortcode could not be parsed.';
	}

	if(typeof(tinymce) !== 'undefined'){
		tinymce.PluginManager.add('essgrid_sc_button', function( editor, url ) {
			editor.addButton('essgrid_sc_button', {
				title: eg_lang.essential_grid_shortcode_creator,
				icon: 'icon dashicons-screenoptions',
				onclick: function() {
					
					//reset all options and settings
					esg_tiny_reset_all();
					
					jQuery('#ess-grid-tiny-dialog-step-1').show();
					jQuery('#ess-grid-tiny-dialog-step-2').hide();
					jQuery('#ess-grid-tiny-dialog-step-3').hide();
					
					editor.windowManager.open({
						id       : 'ess-grid-tiny-mce-dialog',
						title	 : eg_lang.shortcode_generator,
						width    : 720,
						height   : 'auto',
						wpDialog : true
					},
					{
						plugin_url : url // Plugin absolute URL
					});
				}
			});
			
			open_editor = editor;
			
		});
	}
	
	var ess_grid_is_vc = false;
	var open_editor = false;
	var cur_vc_obj = false;
	
	/**
	 * Reset everything do defaults
	 **/
	function esg_tiny_reset_all(){
		ess_grid_is_vc = false;
		
		jQuery('#ess-grid-tiny-mce-settings-form').trigger('reset');
		jQuery('#ess-grid-tiny-grid-settings-wrap').removeClass('notselectable');
		jQuery('#eg-custom-elements-wrap').html(''); //remove all custom build elements
	}
	
	/**
	 * Generate shortcode and add it to content
	 **/
	jQuery('body').on('click', '#ess-grid-add-custom-shortcode, #ess-grid-add-custom-shortcode-special', function(){
		var form = jQuery(this).parents('form');
		if ( ! validateForm( form ) )
			return false;
		
		var esg_params = {};
		
		//remove content from all input fields that are currently hidden
		jQuery('.ess-grid-tiny-elset-row input').each(function(){
			if(jQuery(this).parents(':hidden').length!=0)
				jQuery(this).val('');
		});
		
		//collect all required data and store in content varialble
		
		var content = '[ess_grid ';
		var settings_raw = AdminEssentials.getFormParams('ess-grid-tiny-mce-settings-form');
		var layers_raw = AdminEssentials.getFormParams('ess-grid-tiny-mce-layers-form');
		var settings = {};
		var layers = {};
		
		if(jQuery('select[name="ess-grid-tiny-existing-settings"] option:selected').val() !== '-1'){
			content += ' alias="'+jQuery('select[name="ess-grid-tiny-existing-settings"] option:selected').val()+'"';
			if(ess_grid_is_vc)
				esg_params.alias = jQuery('select[name="ess-grid-tiny-existing-settings"] option:selected').val();
				
			if(typeof(settings_raw['ess-grid-tiny-max-entries']) !== 'undefined' && esg_create_by_predefined !== false){
				settings['max-entries'] = settings_raw['ess-grid-tiny-max-entries'];
				
				settings = JSON.stringify(settings).replace(/\[/g, '({').replace(/\]/g, '})').replace(/\'/g, '');
				content += " settings='"+settings+"'";
				if(ess_grid_is_vc)
					esg_params.settings = settings.replace(/\"/g, "'");
			}
		}else{
		
			for(var key in settings_raw){
				if(key == 'ess-grid-existing-grid') continue;
				if(key == 'ess-grid-tiny-existing-settings') continue;
				if(key == 'eg-shortcode-analyzer') continue;
				if(esg_create_by_predefined == false && key == 'ess-grid-tiny-max-entries') continue; //only take this setting if we are special like popular, recent or related
				
				var new_key = key.replace('ess-grid-tiny-', '');
				settings[new_key] = settings_raw[key];
				
			}
			
			settings = JSON.stringify(settings).replace(/\[/g, '({').replace(/\]/g, '})').replace(/\'/g, '');
			content += " settings='"+settings+"'";
			if(ess_grid_is_vc)
				esg_params.settings = settings.replace(/\"/g, "'");
		}
		
		if(jQuery(this).attr('id') == 'ess-grid-add-custom-shortcode'){
			//remove cobbles settings for layers if type is not cobbles
			if(jQuery('select[name="ess-grid-tiny-grid-layout"] option:selected').val() !== 'cobbles'){
				delete(layers_raw['ess-grid-tiny-cobbles-size']);
			}
			
			for(var key in layers_raw){
				
				var new_key = key.replace('ess-grid-tiny-', '');
				var ignore_setting = false;
				
				if(layers_raw[key] instanceof Array){
					var objSet = {};
					
					ignore_setting = true;
					for(var mkey in layers_raw[key]){
						if(layers_raw[key][mkey] !== ''){
							ignore_setting = false;
							objSet['0'+mkey] = layers_raw[key][mkey];
						}
					}
					layers_raw[key] = objSet;
					
				}
				
				if(ignore_setting == false)
					layers[new_key] = layers_raw[key];
				
			}
		
			if(jQuery.isEmptyObject(layers)){
				alert(eg_lang.please_add_at_least_one_layer);
				return false;
			}
			
			layers = JSON.stringify(layers).replace(/\[/g, '({').replace(/\]/g, '})').replace(/\'/g, '');
			
			content += " layers='"+layers+"'";
			if(ess_grid_is_vc)
				esg_params.layers = layers.replace(/\"/g, "'");
				
		}else{ //add special stuff here
			content += " special='"+esg_create_by_predefined+"'";
			if(ess_grid_is_vc)
				esg_params.special = esg_create_by_predefined;
		}
		
		content += '][/ess_grid]';
		
		if(!ess_grid_is_vc){
			
			tinyMCE.activeEditor.selection.setContent(content);
			if(open_editor !== false){
				open_editor.windowManager.close();
			}
			
		}else{

			jQuery('#ess-grid-tiny-mce-dialog').dialog('close');
			
			cur_vc_obj.model.save('params', esg_params);
		}
		return false;
	});
	
	
	/**
	 * Add shortcode with predefined grid to content
	 **/
	if(!jQuery('#eg-add-predefined-grid').hasClass('eg-clicklistener')){
		jQuery('#eg-add-predefined-grid').addClass('eg-clicklistener');
		
		jQuery('body').on('click', '#eg-add-predefined-grid', function(){
			var form = jQuery(this).parents('form');
			if ( ! validateForm( form ) )
				return false;
			
			var grid_handle = jQuery('select[name="ess-grid-existing-grid"] option:selected').val();
			if(grid_handle !== '-1'){
			
				var content = '[ess_grid alias="'+grid_handle+'"][/ess_grid]';
				if(!ess_grid_is_vc){
				
					tinyMCE.activeEditor.selection.setContent( content );
					if(open_editor !== false)
						open_editor.windowManager.close();
						
				}else{
					
					cur_vc_obj.model.save('params', {'alias':grid_handle});
					
					jQuery('#ess-grid-tiny-mce-dialog').dialog('close');
					
				}
			}
			
			return false;
		});
	
	
		/**
		 * Add custom element and insert all skin fields to it
		 **/
		jQuery('body').on('click', '.eg-add-custom-element', function(){
		
			var cur_type = jQuery(this).data('type');
			
			esg_tiny_add_element(cur_type);
			
		});
	
	}
	/**
	 * Add a new Element
	 */
	function esg_tiny_add_element(cur_type, add_options){
		var new_layer = jQuery('.esg-tiny-template-wrap').clone();
		
		jQuery('#eg-custom-elements-wrap').prepend(new_layer);
		jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap #ess-grid-tiny-custom-'+cur_type+'-wrap').show();
		jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap #ess-grid-tiny-custom-'+cur_type+'-wrap').append('<input type="hidden" name="ess-grid-tiny-custom-type[]" value="'+cur_type+'" />')
		
		switch(cur_type){
			case 'html5':
			case 'vimeo':
			case 'youtube':
				jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap #ess-grid-tiny-custom-poster-wrap').show();
				jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap #ess-grid-tiny-custom-ratio-wrap').show();												
			break;
			default:
				jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap #ess-grid-tiny-custom-ratio-wrap').remove();
		}
		
		switch(cur_type) {
			case "html5":
				jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap').find('.dashicons.dashicons-format-image').removeClass("dashicons-format-image").addClass("dashicons-editor-video");
			break;
			case "vimeo":
			case "youtube":				
				jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap').find('.dashicons.dashicons-format-image').removeClass("dashicons-format-image").addClass("dashicons-format-video");
			break;
			case "soundcloud":
				jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap').find('.dashicons.dashicons-format-image').removeClass("dashicons-format-image").addClass("dashicons-format-audio");
			break;

		}
		
		if(typeof(add_options) !== 'undefined'){
			for(var key in add_options){
				if(jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap select[name="ess-grid-tiny-'+key+'[]"]').length){
					jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap select[name="ess-grid-tiny-'+key+'[]"] option:first-child').attr('selected', true); //set first element first.
					jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap select[name="ess-grid-tiny-'+key+'[]"] option').each(function(){
						if(jQuery(this).val() == add_options[key]){
							jQuery(this).attr('selected', true);
						}
					});
				}else if(jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap input[name="ess-grid-tiny-'+key+'[]"]').length){
					var my_field = jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap input[name="ess-grid-tiny-'+key+'[]"]')
					if(my_field.attr('type') != 'radio'){
						my_field.val(add_options[key]);
						
						if(my_field.data('type') == 'image'){
							//ajax request
							AdminEssentials.ajaxRequest("get_image_url", {imageid: add_options[key]}, '',function(response){
								if(typeof(response.url) !== 'undefined'){
									jQuery('#eg-custom-elements-wrap input[name="ess-grid-tiny-custom-poster[]"][value="'+response.imageid+'"]').parent().find('img').attr('src', response.url).show();
									jQuery('#eg-custom-elements-wrap input[name="ess-grid-tiny-custom-image[]"][value="'+response.imageid+'"]').parent().find('img').attr('src', response.url).show();
								}
							});
						}
						
					}else if(my_field.attr('type') == 'radio'){
						jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap input[name="ess-grid-tiny-'+key+'[]"][value="'+add_options[key]+'"]').attr('checked', 'checked');
					}
					
				}else if(jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap textarea[name="ess-grid-tiny-'+key+'[]"]').length){
					jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap textarea[name="ess-grid-tiny-'+key+'[]"]').val(add_options[key]);
				}
			}
		}
		
		jQuery('#eg-custom-elements-wrap .esg-tiny-template-wrap').show().removeClass('esg-tiny-template-wrap');
	}
	
	
	/**
	 * Delete custom element
	 **/
	jQuery('body').on('click', '.esg-tiny-delete-entry', function(e){
		jQuery(this).closest('.esg-tiny-element').remove();
	});
	
	
	/**
	 * Go to step 2
	 **/
	var esg_create_by_predefined = false;
	
	jQuery('body').on('click', '#eg-goto-step-2', function(){
		jQuery('#ess-grid-tiny-dialog-step-1').hide();
		jQuery('#ess-grid-tiny-dialog-step-2-5').hide();
		jQuery('#ess-grid-tiny-dialog-step-2').show();
		jQuery('#ess-grid-tiny-dialog-step-3').hide();
		if(esg_create_by_predefined == false){
			jQuery('.esg-max-entries').hide();
			jQuery('#esg-tiny-shortcode-analyze-wrap').show();
			jQuery('#eg-goto-step-3').show();
			jQuery('#ess-grid-add-custom-shortcode-special').hide();
		}else{
			jQuery('.esg-max-entries').show();
			jQuery('#esg-tiny-shortcode-analyze-wrap').hide();
			jQuery('#eg-goto-step-3').hide();
			jQuery('#ess-grid-add-custom-shortcode-special').show();
		}
	});
	
	jQuery('body').on('click', '#eg-create-custom-grid', function(){
		esg_create_by_predefined = false;
		jQuery('#eg-goto-step-2').click();
	});
	
	jQuery('body').on('click', '#eg-edit-custom-grid', function(){
		esg_create_by_predefined = false;
		jQuery('#ess-grid-tiny-dialog-step-1').hide();
		jQuery('#ess-grid-tiny-dialog-step-2-5').show();
		jQuery('#ess-grid-tiny-dialog-step-2').hide();
		jQuery('#ess-grid-tiny-dialog-step-3').hide();
	});
	
	jQuery('body').on('click', '#eg-create-popularpost-grid', function(){
		esg_create_by_predefined = 'popular';
		jQuery('#eg-goto-step-2').click();
	});
	
	jQuery('body').on('click', '#eg-create-recentpost-grid', function(){
		esg_create_by_predefined = 'recent';
		jQuery('#eg-goto-step-2').click();
	});
	
	jQuery('body').on('click', '#eg-create-relatedpost-grid', function(){
		esg_create_by_predefined = 'related';
		jQuery('#eg-goto-step-2').click();
	});
	
	
	/**
	 * Go to step 1
	 **/
	jQuery('body').on('click', '#eg-goto-step-1, #eg-goto-step-1-5', function(){
		jQuery('#ess-grid-tiny-dialog-step-1').show();
		jQuery('#ess-grid-tiny-dialog-step-2').hide();
		jQuery('#ess-grid-tiny-dialog-step-2-5').hide();
		jQuery('#ess-grid-tiny-dialog-step-3').hide();
	});
	
	
	/**
	 * Go to step 3
	 **/
	jQuery('body').on('click', '#eg-goto-step-3', function(){
		jQuery('#ess-grid-tiny-dialog-step-1').hide();
		jQuery('#ess-grid-tiny-dialog-step-2').hide();
		jQuery('#ess-grid-tiny-dialog-step-2-5').hide();
		jQuery('#ess-grid-tiny-dialog-step-3').show();
	});
	
	
	jQuery('body').on('click', '.ess-grid-select-image', function(){
		var setto = jQuery(this).data('setto');
		var my_element = jQuery(this);
		
		var img_uploader;

		if (img_uploader) {
			img_uploader.open();
			return;
		}

		//Extend the wp.media object
		img_uploader = wp.media.frames.file_frame = wp.media({
			title: eg_lang.choose_image,
			button: {
				text: eg_lang.choose_image
			},
			multiple: false
		});

		//When a file is selected, grab the URL and set it as the text field's value
		img_uploader.on('select', function() {
			attachment = img_uploader.state().get('selection').first().toJSON();
			
			my_element.siblings('input[name="'+setto+'"]').val(attachment.id);
			my_element.siblings('.esg-tiny-img-placeholder').children('img').attr('src', attachment.url).show();
			//img_uploader.close();
		});

		//Open the uploader dialog
		img_uploader.open();
	});
	
	jQuery( document ).ready(function() {
		jQuery('#eg-custom-elements-wrap').sortable({
			containment: '#eg-custom-elements-wrap'
		});
	});
	
	jQuery('body').on('change', 'select[name="ess-grid-tiny-entry-skin"]', function(){
		var choosen_skin = jQuery(this).val();
		
		jQuery('.ess-grid-tiny-elset-row').hide(); //hide all fields
		
		if(typeof(esg_tiny_skin_layers[choosen_skin]) !== 'undefined'){
			for(var key in esg_tiny_skin_layers[choosen_skin]){
				jQuery('.ess-grid-tiny-'+key+'-wrap').show();
			}
		}
		
	});
	jQuery('select[name="ess-grid-tiny-entry-skin"]').change();
	
	jQuery('body').on('change', 'select[name="ess-grid-tiny-grid-layout"]', function(){
		var choosen_layout = jQuery(this).val();
		
		if(choosen_layout == 'cobbles'){
			jQuery('.ess-grid-tiny-cobbles-size-wrap').show();
		}else{
			jQuery('.ess-grid-tiny-cobbles-size-wrap').hide();
		}
		
	});
	jQuery('select[name="ess-grid-tiny-grid-layout"]').change();
	
	jQuery('body').on('change', 'select[name="ess-grid-tiny-existing-settings"]', function(){
		var choosen_grid = jQuery(this).val();
		
		if(choosen_grid != '-1'){
			jQuery('#ess-grid-tiny-grid-settings-wrap').addClass('notselectable');
			jQuery('#ess-grid-tiny-grid-settings-wrap').find('input, select, textarea').attr('disabled', 'disabled');
		}else{
			jQuery('#ess-grid-tiny-grid-settings-wrap').removeClass('notselectable');
			jQuery('#ess-grid-tiny-grid-settings-wrap').find('input, select, textarea').attr('disabled', false);
		}
		
	});
	jQuery('select[name="ess-grid-tiny-existing-settings"]').change();
	
	
	/**
	 * Shortcode parser
	 **/
	jQuery('body').on('click', '#eg-shortcode-do-analyze', function(){
		var sc = jQuery('input[name="eg-shortcode-analyzer"]').val();
		
		try{
			var msc = wp.shortcode.next('ess_grid', sc);
			
			if(typeof(msc) !== 'undefined'){
				if(ess_grid_is_vc){
					esg_tiny_reset_all(); //reset all
					ess_grid_is_vc = true;
				}else{
					esg_tiny_reset_all(); //reset all
				}
				
				if(typeof(msc.shortcode.attrs.named.alias) !== 'undefined'){ //either an alias is set
					
					jQuery('select[name="ess-grid-tiny-existing-settings"] option').each(function(){
						if(jQuery(this).val() == msc.shortcode.attrs.named.alias){
							jQuery(this).attr('selected', true);
							jQuery('select[name="ess-grid-tiny-existing-settings"]').change();
						}
					});
					
				}else if(typeof(msc.shortcode.attrs.named.settings) !== 'undefined'){ //or we take the settings if they exist
					jQuery('select[name="ess-grid-tiny-existing-settings"] option:first-child').attr('selected', true); //set first element first.
					jQuery('select[name="ess-grid-tiny-existing-settings"]').change();
					
					var settings = jQuery.parseJSON(msc.shortcode.attrs.named.settings);
					
					for(var key in settings){
						if(jQuery('select[name="ess-grid-tiny-'+key+'"]').length){
							jQuery('select[name="ess-grid-tiny-'+key+'"] option:first-child').attr('selected', true); //set first element first.
							jQuery('select[name="ess-grid-tiny-'+key+'"] option').each(function(){
								if(jQuery(this).val() == settings[key]){
									jQuery(this).attr('selected', true);
								}
							});
						}else if(jQuery('input[name="ess-grid-tiny-'+key+'"]').length){
							
							if(jQuery('input[name="ess-grid-tiny-'+key+'"]').attr('type') == 'text')
								jQuery('input[name="ess-grid-tiny-'+key+'"]').val(settings[key]);
							else if(jQuery('input[name="ess-grid-tiny-'+key+'"]').attr('type') == 'radio')
								jQuery('input[name="ess-grid-tiny-'+key+'"][value="'+settings[key]+'"]').attr('checked', 'checked');
							
						}else if(jQuery('textarea[name="ess-grid-tiny-'+key+'"]').length){
							jQuery('textarea[name="ess-grid-tiny-'+key+'"]').val(settings[key]);
						}
					}
				}
				
				if(typeof(msc.shortcode.attrs.named.layers) !== 'undefined'){ //get the layers
					var layers = jQuery.parseJSON(msc.shortcode.attrs.named.layers);
					
					var new_layer = {};
					//translate layers into object that we can use easy
					for(var key in layers){
						if(!jQuery.isEmptyObject(layers[key])){
							for(var lkey in layers[key]){
								if(typeof(new_layer[lkey]) == 'undefined') new_layer[lkey] = {};
								
								new_layer[lkey][key] = layers[key][lkey];
							}
						}
					}
					
					//order new_layer so DESC, so that we start with the last entry (because the function prepends elements)
					var keys = [];
					var sorted_obj = {};

					for(var key in new_layer){
						if(new_layer.hasOwnProperty(key)){
							keys.push(key);
						}
					}

					// sort keys
					keys.sort();
					keys.reverse(); //reserve order

					// create new array based on Sorted Keys
					jQuery.each(keys, function(i, key){
						sorted_obj[key] = new_layer[key];
					});
					
					for(var key in sorted_obj){
						var cur_type = '';
						if(typeof(sorted_obj[key]['custom-image']) !== 'undefined'){ //add image
							cur_type = 'image';
						}else if(typeof(sorted_obj[key]['custom-youtube']) !== 'undefined'){ //add youtube
							cur_type = 'youtube';
						}else if(typeof(sorted_obj[key]['custom-vimeo']) !== 'undefined'){ //add vimeo
							cur_type = 'vimeo';
						}else if(typeof(sorted_obj[key]['custom-soundcloud']) !== 'undefined'){ //add soundcloud
							cur_type = 'soundcloud';
						}else if(typeof(sorted_obj[key]['custom-html5-mp4']) !== 'undefined' || typeof(sorted_obj[key]['custom-html5-ogv']) !== 'undefined' || typeof(sorted_obj[key]['custom-html5-webm']) !== 'undefined'){ //add html5 video
							cur_type = 'html5';
						}else{ //nothing correct found
							if(typeof(sorted_obj[key]['custom-type']) !== 'undefined'){ //maybe the input type field is set
								cur_type = sorted_obj[key]['custom-type'];
								switch(cur_type){
									case 'image':
									case 'youtube':
									case 'vimeo':
									case 'soundcloud':
									case 'html':
										break;
									default: 
										continue;
								}
							}else{
								continue;
							}
						}
						esg_tiny_add_element(cur_type, sorted_obj[key]);
					}
					
				}
				
				jQuery('select[name="ess-grid-tiny-entry-skin"]').change();
				
				if(!ess_grid_is_vc)
					alert(eg_lang.shortcode_parsing_successfull);
				
				jQuery('#eg-goto-step-2').click();
				
			}else{
				alert(eg_lang.shortcode_could_not_be_correctly_parsed);
			}
			
		}catch(e){
			alert(eg_lang.shortcode_could_not_be_correctly_parsed);
		}
		
	});
//})();