//(function() {
	if(typeof(rev_lang) == 'undefined'){
		rev_lang = {};
		
		rev_lang.slider_revolution_shortcode_creator = 'Slider Revolution Shortcode Creator';
		
		rev_lang.shortcode_generator = 'Shortcode Generator';
		rev_lang.please_add_at_least_one_layer = 'Please add at least one Layer.';
		rev_lang.choose_image = 'Choose Image';
		
		rev_lang.shortcode_parsing_successfull = 'Shortcode parsing successfull. Items can be found in step 3';
		rev_lang.shortcode_could_not_be_correctly_parsed = 'Shortcode could not be parsed.';
	}
	
	if(typeof(tinymce) !== 'undefined'){
		tinymce.PluginManager.add('revslider_sc_button', function( editor, url ) {
			editor.addButton('revslider_sc_button', {
				title: rev_lang.slider_revolution_shortcode_creator,
				icon: 'icon dashicons-update',
				onclick: function() {
					
					opened_by_mce = true;
					//reset all options and settings
					revslider_tiny_reset_all();
					
					jQuery('#revslider-tiny-dialog-step-1').show();
					jQuery('#revslider-tiny-dialog-step-1-5').hide();
					
					editor.windowManager.open({
						id       : 'revslider-tiny-mce-dialog',
						title	 : '',
						width    : 900,
						height   : 600,
						resizable: false,
						wpDialog : true
					},
					{
						plugin_url : url // Plugin absolute URL
					});
					
				}
			});
			
			rs_open_editor = editor;
			
		});
		
	}
	
	
	
	jQuery(document).ready(function () {
		if (typeof QTags !== 'undefined') {
			var add_rs_button = true;
			if(edButtons !== undefined){
				for(var key in edButtons){
					if(edButtons[key].id == 'slider-revolution'){
						add_rs_button = false;
						break;
					}
				}
			}
			
			if(add_rs_button){
				QTags.addButton('slider-revolution', 'Slider Revolution', function () {
					opened_by_mce = false;
					
					//reset all options and settings
					revslider_tiny_reset_all();
					
					jQuery('#revslider-tiny-dialog-step-1').show();
					jQuery('#revslider-tiny-dialog-step-1-5').hide();
					
					jQuery('#revslider-tiny-mce-dialog').dialog({
						modal:true,
						title	 : '',
						width    : 900,
						height   : 600,
						resizable: false,
						wpDialog : true
					});
				});
			}
		}
	});
	
	var opened_by_mce = false;
	var revslider_is_vc = false;
	var rs_cur_vc_obj = false;
	var rs_open_editor = false;
	
	
	/**
	 * Reset everything do defaults
	 **/
	function revslider_tiny_reset_all(){
		revslider_is_vc = false;
		
		//disable Quick Modify Slider button
		jQuery('#revslider-tiny-mce-settings-form').trigger('reset');
		jQuery('#revslider-tiny-mce-dialog').show();
		
		jQuery('#revslider-existing-slider option[value="-1"]').attr('selected', 'selected');
		
		jQuery('#revslider-tiny-grid-settings-wrap').removeClass('notselectable');
		jQuery('#rs-custom-elements-wrap').html(''); //remove all custom build elements
		jQuery('#revslider-existing-slider option:selected').change();
		
		jQuery('#rs-shortcode-select-wrapper li').each(function(){
			jQuery(this).removeClass('selected');
		});
	}

	function checkOpenRevDialogWindow() {
		setTimeout(function() {
		var rtmd = jQuery('#revslider-tiny-mce-dialog')
		if (rtmd.closest('.ui-dialog:visible')) 
			rtmd.closest('.ui-dialog').find('.ui-dialog-titlebar-close').click();
		},100);
	}
	
	jQuery(document).ready(function(){
		/**
		 * Add shortcode with predefined slider to content
		 **/
		if(!jQuery('#rs-add-predefined-slider').hasClass('rs-clicklistener')){
			
			jQuery('#rs-add-predefined-slider').addClass('rs-clicklistener');
			
			jQuery('body').on('change', '#revslider-existing-slider', function(){
				var sel = jQuery('#revslider-existing-slider option:selected');
				if(sel.data('slidertype') == 'gallery' || sel.data('slidertype') == 'specific_posts'){
					jQuery('#rs-modify-predefined-slider').removeClass('nonclickable');
				}else{
					jQuery('#rs-modify-predefined-slider').addClass('nonclickable');
				}
				if(sel.val() != '-1'){
					jQuery('#rs-add-predefined-slider').removeClass('nonclickable');
				}else{
					jQuery('#rs-add-predefined-slider').addClass('nonclickable');
				}
			});
			jQuery('#revslider-existing-slider').change();
			
			jQuery(document).ready(function(){
				jQuery('.rs-mod-slides-wrapper').sortable();
			});
			
			jQuery('body').on('click', '#rs-modify-predefined-slider', function(){
				var rs_raw_construct = wp.template( "rs-modify-slide-wrap" );
				var sel = jQuery('#revslider-existing-slider option:selected');
				if(sel.data('slidertype') == 'gallery' || sel.data('slidertype') == 'specific_posts'){
					
					jQuery('.rs-mod-slides-wrapper').html(''); //reset HTML
					
					//check if id is available
					if(typeof(rev_sliders_info) !== 'undefined'){
						for(var key in rev_sliders_info){
							if(key == sel.data('sliderid')){
								//add all found slides, empty the old ones first
								for(var sl in rev_sliders_info[key]){
									var content = rs_raw_construct(rev_sliders_info[key][sl]);
									
									jQuery('.rs-mod-slides-wrapper').append(content);
								}
								
								jQuery('#revslider-tiny-dialog-step-1').hide();
								jQuery('#revslider-tiny-dialog-step-1-5').show();
								return true;
							}
						}
					}
				}
			});
			
			
			jQuery('body').on('click', '#rs-add-predefined-slider', function(){

				var form = jQuery(this).parents('form');

				checkOpenRevDialogWindow();


				if ( ! validateForm( form ) )
					return false;
				
				rs_add_shortcode();
				
				
				

				return false;

			});
		
			
			function rs_add_shortcode(data){
				var slider_handle = jQuery('select[name="revslider-existing-slider"] option:selected').val();
				if(slider_handle !== '-1'){
					
					var order = '';
					if(data !== undefined){
						if(typeof(data.order) !== 'undefined'){
							order = ' order="'+data.order.join()+'"';
						}
					}
					
					var content = '[rev_slider alias="'+slider_handle+'"'+order+'][/rev_slider]';
					if(!revslider_is_vc){
						
						if(opened_by_mce){
							tinyMCE.activeEditor.selection.setContent( content );
							if(rs_open_editor !== false)
								rs_open_editor.windowManager.close();
						}else{
							QTags.insertContent(content);
						}
						//jQuery('#revslider-tiny-mce-dialog').closest('.ui-dialog').hide();
					}else{
						
						var rs_vc_data = {'alias':slider_handle};
						if(data !== undefined){
							if(typeof(data.order) !== 'undefined'){
								rs_vc_data.order = data.order;
							}
						}
						
						rs_cur_vc_obj.model.save('params', rs_vc_data);
						
						jQuery('#revslider-tiny-mce-dialog').dialog('close');
						
					}
				}
			}
			
			
			jQuery('body').on('click', '#rs-shortcode-select-wrapper li', function(){
				if(!jQuery(this).hasClass('rs-slider-modify-new-slider')){
					
					var sliderid = jQuery(this).data('sliderid');
					var slideralias = jQuery(this).data('slideralias');
					
					jQuery('#rs-shortcode-select-wrapper li').each(function(){
						jQuery(this).removeClass('selected');
					});
					
					jQuery(this).addClass('selected');
					
					jQuery('#revslider-existing-slider option[value="'+slideralias+'"]').attr('selected', 'selected');
					jQuery('#revslider-existing-slider option:selected').change();
				}
				
			});

		}
	
	
		/**
		 * Add Slider Sorted with the given order, also check for published/unpublished
		 **/
		jQuery('body').on('click', '#revslider-add-custom-shortcode-modify', function(){
			var myslides = [];
			
			var heroadded = false;
			
			jQuery('.rs-mod-slides-wrapper li').each(function(){
				var sp = jQuery(this).find('.slide-published');
				
				var slideid = jQuery(this).attr('id').replace('slidelist_item_', '');
				
				if(sp.length > 0 && !sp.hasClass('pubclickable')){ //check if we are published
					//we are published
					myslides.push(slideid);
				}else{
					//either hero or unpublished
					var sq = jQuery(this).find('.slide-unpublished');
					if(sq.length > 0 && !sq.hasClass('pubclickable')){ //check if we are unpublished
						//we are unpublished
					}else{
						//we are hero
						var sr = jQuery(this).find('.slide-hero-published');
						if(sr.length > 0 && !sr.hasClass('pubclickable') && heroadded == false){ //we are hero published
							//as we are hero, this is the last step and we can break the each here
							myslides.push(slideid);
							heroadded = true;
						}
					}
				}
			});
			
			rs_add_shortcode({order: myslides});

			checkOpenRevDialogWindow();
			
		});
		
		/**
		 * Go to step 1
		 **/
		jQuery('body').on('click', '.rs-goto-step-1', function(){
			jQuery('#revslider-tiny-dialog-step-1').show();
			jQuery('#revslider-tiny-dialog-step-1-5').hide();
		});
	});
	
	var revslider_create_by_predefined = false;
	
	
	
	jQuery('body').on('change', 'select[name="revslider-tiny-existing-settings"]', function(){
		var choosen_slider = jQuery(this).val();
		
		if(choosen_slider != '-1'){
			jQuery('#revslider-tiny-slider-settings-wrap').addClass('notselectable');
			jQuery('#revslider-tiny-slider-settings-wrap').find('input, select, textarea').attr('disabled', 'disabled');
		}else{
			jQuery('#revslider-tiny-slider-settings-wrap').removeClass('notselectable');
			jQuery('#revslider-tiny-slider-settings-wrap').find('input, select, textarea').attr('disabled', false);
		}
		
	});
	jQuery('select[name="revslider-tiny-existing-settings"]').change();
	
//})();