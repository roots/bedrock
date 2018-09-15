var RevSliderAdmin = new function(){

	var t = this;
	var g_postTypesWithCats = null;
	
	/**
	 * init "slider" view functionality
	 */
	var initSaveSliderButton = function(ajaxAction){

		jQuery("#button_save_slider,#button_save_slider_t").click(function(){
			//collect data
			var data = {
				params: RevSliderSettings.getSettingsObject("form_slider_params"),
				main: RevSliderSettings.getSettingsObject("form_slider_main"),
				template: jQuery('#revslider_template').val() //determinate if we are a template slider or not
			};
			
			//add slider id to the data
			if(ajaxAction == "update_slider"){
				data.sliderid = jQuery("#sliderid").val();
				data.params.custom_css = rev_cm_custom_css.getValue();
				data.params.custom_javascript = rev_cm_custom_js.getValue();

				UniteAdminRev.setAjaxLoaderID("loader_update, #loader_update_t");
				UniteAdminRev.setAjaxHideButtonID("button_save_slider,button_save_slider_t");
				UniteAdminRev.setSuccessMessageID("update_slider_success,#update_slider_success_t");

			}

			UniteAdminRev.ajaxRequest(ajaxAction, data);
		});
	}
	
	
	t.initLayerPreview = function(){
		//preview slider actions
		jQuery("#button_preview_slider-tb").click(function(){
			var sliderID = jQuery("#sliderid").val();

			openPreviewSliderDialog(sliderID);
		});
	}


	/**
	 * update shortcode from alias value.
	 */
	var updateShortcode = function(){
		var alias = jQuery("#alias").val();
		var shortcode = '[rev_slider alias="'+alias+'"]';
		if(alias == "")
			shortcode = rev_lang.wrong_alias;
		jQuery("#shortcode").val(shortcode);
	}
	
	
	var template_library_loaded = false;
	t.load_slider_template_html = function(){
		//jQuery('#button_import_template_slider').click();
		
		//get HTML of Sliders and add them to the wrapper 
		if(!template_library_loaded){
			UniteAdminRev.ajaxRequest('load_template_store_sliders', {}, function(response){
				if(response.success){
					jQuery('.revolution-template-groups').html(response['html']);
					jQuery('#template_area').addClass("show");
					jQuery('#template_area').trigger("showitnow");
					
					initTemplateSliders();
					
					template_library_loaded = true;
				}
			});
		}else{
			jQuery('#template_area').addClass("show");
			jQuery('#template_area').trigger("showitnow");
		}
		
		return true;
	}
	
	var template_slide_library_loaded = false;
	t.load_slide_template_html = function(){
		//jQuery('#button_import_template_slider').click();
		
		//get HTML of Sliders and add them to the wrapper 
		if(!template_slide_library_loaded){
			UniteAdminRev.ajaxRequest('load_template_store_slides', {}, function(response){
				if(response.success){
					jQuery('.revolution-basic-templates').html(response['html']);
					template_slide_library_loaded = true;
					
					templateSelectorHandling();
					
					jQuery('#template_area').addClass("show");
					jQuery('.revolution-template-groups').perfectScrollbar();
					scrollTA();
				}
			});
		}else{
			jQuery('#template_area').addClass("show");
			jQuery('.revolution-template-groups').perfectScrollbar();
			scrollTA();
		}
		return true;
	}
	
	/**
	 * change fields of the slider view
	 */
	var enableSliderViewResponsitiveFields = function(enableRes,enableAuto,enableFullScreen,textMode){
		jQuery('input[name="width"]').attr('disabled', false);
		jQuery('input[name="height"]').attr('disabled', false);

		if(textMode == 'normal' || textMode == 'full'){
			jQuery('#layout-preshow').removeClass('lp-fullscreenalign');
		}
		
		//enable / disable responsitive fields
		if(enableRes){
			jQuery("#responsitive_row").removeClass("disabled");
			jQuery("#responsitive_row input").prop("disabled","");
		}else{
			jQuery("#responsitive_row").addClass("disabled");
			jQuery("#responsitive_row input").prop("disabled","disabled");
		}

		if(enableAuto){
			jQuery("#auto_height_row").removeClass("disabled");
			jQuery('#layout-preshow').removeClass('lp-fullscreenalign');
		}else{
			jQuery("#auto_height_row").addClass("disabled");
		}
		
		if(textMode == 'normal' && enableRes == false && enableAuto == false && enableFullScreen == false){
			jQuery('.rs-hide-on-fixed').hide();
		}else{
			jQuery('.rs-hide-on-fixed').show();
		}
		
		if(textMode == 'full'){
			jQuery('.rs-show-on-auto').toggle(100);
			jQuery('.rs-show-on-auto').show(100);
		}else{
			jQuery('.rs-show-on-auto').toggle(100);
			jQuery('.rs-show-on-auto').hide(100);
		}
		if(enableFullScreen){
			jQuery('.rs-show-on-fullscreen').show();
			jQuery('.rs-hide-on-fullscreen').hide();
			
			if(jQuery('input[name="full_screen_align_force"]:checked').val() == 'on') jQuery('#layout-preshow').addClass('lp-fullscreenalign');

			jQuery("#full_screen_align_force_row").removeClass("disabled");
			jQuery("#fullscreen_offset_container_row").removeClass("disabled");

		}else{
			jQuery('.rs-show-on-fullscreen').hide();
			jQuery('.rs-hide-on-fullscreen').show();
			
			jQuery("#full_screen_align_force_row").addClass("disabled");
			jQuery("#fullscreen_offset_container_row").addClass("disabled");
		}

		if(enableFullScreen || enableAuto){
			jQuery("#force_full_width_row").removeClass("disabled");
		}else{
			jQuery("#force_full_width_row").addClass("disabled");
		}

		jQuery('#layout-preshow').removeClass('lp-fixed');
		jQuery('#layout-preshow').removeClass('lp-custom'); //responsitive
		jQuery('#layout-preshow').removeClass('lp-autoresponsive'); //fullwidth
		jQuery('#layout-preshow').removeClass('lp-fullscreen');

		if(enableRes){
			jQuery('#layout-preshow').addClass('lp-custom');
		}else if(enableAuto){
			jQuery('#layout-preshow').addClass('lp-autoresponsive');
		}else if(enableFullScreen){
			jQuery('#layout-preshow').addClass('lp-fullscreen');
		}else{
			jQuery('#layout-preshow').addClass('lp-fixed');
		}
		

	}


	/**
	 * init slider view custom controls fields.
	 */
	var initSliderViewCustomControls = function(){

		//fixed
		jQuery("#slider_type_1").click(function(){
			enableSliderViewResponsitiveFields(false,false,false,"normal");
		});

		//responsitive
		jQuery("#slider_type_2").click(function(){
			enableSliderViewResponsitiveFields(true,false,false,"normal");
		});

		//full width
		jQuery("#slider_type_3").click(function(){
			enableSliderViewResponsitiveFields(false,true,false,"full");
		});

		//full screen
		jQuery("#slider_type_4").click(function(){
			enableSliderViewResponsitiveFields(false,false,true,"screen");
		});

		jQuery('input[name="full_screen_align_force"]').click(function(){
			if(jQuery(this).val() == 'on'){
				jQuery('#layout-preshow').addClass('lp-fullscreenalign');
			}else{
				jQuery('#layout-preshow').removeClass('lp-fullscreenalign');
			}
		});

		jQuery('input[name="auto_height"]').click(function(){
			if(jQuery(this).val() == "on")
				jQuery('#layout-preshow').addClass('lp-autoheight');
			else
				jQuery('#layout-preshow').removeClass('lp-autoheight');

		});

		jQuery('input[name="force_full_width"]').click(function(){
			if(jQuery(this).val() == "on")
				jQuery('#layout-preshow').addClass('lp-fullwidth');
			else
				jQuery('#layout-preshow').removeClass('lp-fullwidth');

		});

		jQuery('input[name="full_screen_align_force"]:checked').click();
		jQuery('input[name="auto_height"]:checked').click();
		jQuery('input[name="force_full_width"]:checked').click();

	}


	/**
	 *
	 * update category by post types
	 */
	var updateCatByPostTypes = function(typeSettingName,catSettingName){

		jQuery("#"+typeSettingName).change(function(){
			var arrTypes = jQuery(this).val();

			//replace the categories in multi select
			var mysel = [];
			jQuery("#"+catSettingName+' option').each(function(){
				if(jQuery(this).prop('selected') == true){
					mysel.push(jQuery(this).val());
				}
			});
			
			jQuery("#"+catSettingName).empty();
			jQuery(arrTypes).each(function(index,postType){
				var objCats = g_postTypesWithCats[postType];

				//var flagFirst = true;
				for(var catIndex in objCats){
					var catTitle = objCats[catIndex];
					//add option to cats select
					var opt = new Option(catTitle, catIndex);

					if(catIndex.indexOf("option_disabled") == 0){
						jQuery(opt).prop("disabled","disabled");
					}else{
						//select first option:
						//if(flagFirst == true){
							if(jQuery.inArray(jQuery(opt).val(),mysel) !== -1){
								jQuery(opt).prop("selected","selected");
							}
							//flagFirst = false;
						//}
					}

					jQuery("#"+catSettingName).append(opt);

				}

			});
		});
		jQuery("#"+typeSettingName).change();
	}


	/**
	 * init common functionality of the slider view.
	 */
	var initSliderViewCommon = function(){
		initShortcode();
		initSliderViewCustomControls();
		g_postTypesWithCats = jQuery.parseJSON(g_jsonTaxWithCats);


		updateCatByPostTypes("post_types","post_category");
		updateCatByPostTypes("product_types","product_category");
		
		jQuery('#fetch_type').change(function(){
			jQuery('.rs-post-type-wrap').hide();
			jQuery('.rs-post-order-setting').show();
			jQuery('#post_sortby_row').show();
			
			switch(jQuery(this).val()){
				case 'cat_tag':
					jQuery('.rs-post-type-wrap').show();
				break;
				case 'related':
				break;
				case 'popular':
					//only max post
					jQuery('.rs-post-order-setting').hide();
				break;
				case 'recent':
					//only max post
					jQuery('.rs-post-order-setting').hide();
				break;
				case 'next_prev':
					jQuery('#post_sortby_row').hide();
				break;
				default:
				break;
			}
			
		});
		jQuery('#fetch_type option:selected').change();
		
		jQuery("input[name='source_type']").click(function(){ //check for post click
			if(jQuery(this).val() == 'posts'){ //jQuery(this).val() == 'specific_posts' ||
				jQuery('#toolbox_wrapper').hide();

				//hide more elements
				jQuery('#slider_type_row').hide();
				jQuery('#slider_type_row').prev().hide();
				jQuery('#fullscreen_offset_container_row').hide();
				jQuery('#full_screen_align_force_row').hide();
				jQuery('#slider_size_row').hide();
				jQuery('#auto_height_row').hide();
				jQuery('#force_full_width_row').hide();
				jQuery('#responsitive_row').hide();
				jQuery('#responsitive_row').next().hide();
			}else{
				jQuery('.settings_panel_right').show();
				jQuery('#toolbox_wrapper').show();

				//show more elements
				jQuery('#slider_type_row').show();
				jQuery('#slider_type_row').prev().show();
				jQuery('#fullscreen_offset_container_row').show();
				jQuery('#full_screen_align_force_row').show();
				jQuery('#slider_size_row').show();
				jQuery('#auto_height_row').show();
				jQuery('#force_full_width_row').show();
				jQuery('#responsitive_row').show();
				jQuery('#responsitive_row').next().show();
				jQuery('#layout-preshow').show();
				
			}
			if(jQuery(this).val() == 'specific_posts'){
				jQuery('#fetch_type option[value="cat_tag"]').attr('selected', 'selected');
				jQuery('#fetch_type option:selected').change();
			}else{
				jQuery('#fetch_type option:selected').change();
			}
			
			jQuery('.rs-settings-wrapper').hide();
			if(jQuery(this).val() == 'posts' || jQuery(this).val() == 'specific_posts' ||  jQuery(this).val() == 'woocommerce'){
				jQuery('#rs-post-settings-wrapper').show();
				jQuery('.rs-specific-posts-wrap').hide();
				jQuery('.rs-woocommerce-product-wrap').hide();
				jQuery('.rs-post-types-wrapper').hide();
				jQuery('.rs-show-for-wc').hide();
				jQuery('.rs-hide-for-wc').show();
				if(jQuery(this).val() == 'posts'){
					jQuery('.rs-post-types-wrapper').show();
					jQuery('.rs-specific-posts-wrap').hide();
				}else if(jQuery(this).val() == 'specific_posts'){
					jQuery('.rs-post-types-wrapper').hide();
					jQuery('.rs-specific-posts-wrap').show();
				}else if(jQuery(this).val() == 'woocommerce'){
					jQuery('.rs-woocommerce-product-wrap').show();
					jQuery('.rs-show-for-wc').show();
					jQuery('.rs-hide-for-wc').hide();
				}
			}else{
				jQuery('#rs-post-settings-wrapper').hide();
				jQuery('#rs-'+jQuery(this).val()+'-settings-wrapper').show();
				if(jQuery(this).val()=="facebook") jQuery('select[name="facebook-type-source"]').change();
				if(jQuery(this).val()=="instagram") jQuery('select[name="instagram-type"]').change();
				if(jQuery("select[name=flickr-type]").val()=='photosets' && jQuery('input[name=source_type]:checked').val()=="flickr") jQuery('input[name=flickr-user-url]').change();
				if(jQuery('input[name=source_type]:checked').val()=="youtube" && jQuery("select[name='youtube-type-source']").val()=='playlist') jQuery('input[name=youtube-channel-id]').change();
			}
		});
		
		jQuery('.rs-settings-wrapper').hide();
		if(jQuery("#source_type_1").is(':checked') || jQuery("#source_type_2").is(':checked')){
			jQuery('#rs-post-settings-wrapper').show();
			if(jQuery("#source_type_1").is(':checked')){
				jQuery('.rs-post-types-wrapper').show();
				jQuery('.rs-specific-posts-wrap').hide();
			}else{
				jQuery('.rs-post-types-wrapper').hide();
				jQuery('.rs-specific-posts-wrap').show();
			}
		}
		else{
			jQuery('#rs-post-settings-wrapper').hide();
			jQuery('input[name=source_type]:checked').click();
		}
			
		if(jQuery("#source_type_1").is(':checked')){
			jQuery('#toolbox_wrapper').hide();

			//hide more elements
			jQuery('#slider_type_row').hide();
			jQuery('#slider_type_row').prev().hide();
			jQuery('#fullscreen_offset_container_row').hide();
			jQuery('#full_screen_align_force_row').hide();
			jQuery('#slider_size_row').hide();
			jQuery('#auto_height_row').hide();
			jQuery('#force_full_width_row').hide();
			jQuery('#responsitive_row').hide();
			jQuery('#responsitive_row').next().hide();
		}

		jQuery(document).ready(function(){
			jQuery('input[name="slider_type"]:checked').click();

			jQuery('select[name="navigation_style"]').change(function(){
				switch(jQuery(this).val()){
					case 'preview1':
					case 'preview2':
					case 'preview3':
					case 'preview4':
						jQuery('#leftarrow_align_hor_row').hide();
						jQuery('#leftarrow_align_vert_row').hide();
						jQuery('#leftarrow_offset_hor_row').hide();
						jQuery('#leftarrow_offset_vert_row').hide();
						jQuery('#rightarrow_align_hor_row').hide();
						jQuery('#rightarrow_align_vert_row').hide();
						jQuery('#rightarrow_offset_hor_row').hide();
						jQuery('#rightarrow_offset_vert_row').hide();
						jQuery('#navigation_arrows_row').hide();
					break;
					default:
						jQuery('#navigaion_type').change();
						jQuery('#navigation_arrows').change();
					break;
				}
			});

			jQuery('#navigation_arrows').on("change",function() {
				switch(jQuery(this).val()){						
					case 'nexttobullets':						
					case 'solo':
						var nsval = jQuery('select[name="navigation_style"]').val();
						if ( nsval!="preview1" && nsval!="preview2" && nsval!="preview3" && nsval!="preview4") {
							jQuery('#leftarrow_align_hor_row').show();
							jQuery('#leftarrow_align_vert_row').show();
							jQuery('#leftarrow_offset_hor_row').show();
							jQuery('#leftarrow_offset_vert_row').show();
							jQuery('#rightarrow_align_hor_row').show();
							jQuery('#rightarrow_align_vert_row').show();
							jQuery('#rightarrow_offset_hor_row').show();
							jQuery('#rightarrow_offset_vert_row').show();
						}							
					break;
					default:						
						jQuery('#leftarrow_align_hor_row').hide();
						jQuery('#leftarrow_align_vert_row').hide();
						jQuery('#leftarrow_offset_hor_row').hide();
						jQuery('#leftarrow_offset_vert_row').hide();
						jQuery('#rightarrow_align_hor_row').hide();
						jQuery('#rightarrow_align_vert_row').hide();
						jQuery('#rightarrow_offset_hor_row').hide();
						jQuery('#rightarrow_offset_vert_row').hide();							
					break;
				}
			})
			
			jQuery('select[name="navigation_style"] option:selected').change();
			
				jQuery('#navigation_type').change(function(){
				switch(jQuery(this).val()){
					case 'bullet':
					case 'thumb':
						var nsval = jQuery('select[name="navigation_style"]').val();
						if ( nsval!="preview1" && nsval!="preview2" && nsval!="preview3" && nsval!="preview4") {
							jQuery('#navigation_arrows_row').show();
						}
					break;
					default:
						jQuery('#navigation_arrows_row').hide();
					break;
				}
			});				
			jQuery('#navigation_style').change();
		});


		/**
		 * Facebook Type
		 */
		 jQuery('body').on('change','select[name="facebook-type-source"]',function(){
		 	var set = jQuery(this).val();
			if(set == 'timeline'){
				jQuery('#facebook-album-wrap').hide();
				jQuery('#facebook-timeline-wrap').show();
			}
			else{
				jQuery('#facebook-timeline-wrap').hide();
				jQuery('#facebook-album-wrap').show();
				jQuery('input[name=facebook-page-url]').change();
			}

			jQuery('input[name=facebook-type-source]').val(set);

		 });
		 if(jQuery('input[name=source_type]:checked').val()=="facebook") jQuery('select[name="facebook-type-source"]').change();

		 jQuery('input[name=facebook-page-url]').change(function(){
			if(jQuery("select[name='facebook-type-source']").val()=='album'){
				var data = {
								url 		:  jQuery('input[name=facebook-page-url]').val(),
								album 		:  jQuery('input[name=facebook-album]').val(),
								app_id		:  jQuery('input[name=facebook-app-id]').val(),
								app_secret	:  jQuery('input[name=facebook-app-secret]').val(),
							};
				if(jQuery('input[name=facebook-page-url]').val()!=""){
					UniteAdminRev.ajaxRequest("get_facebook_photosets", data,function(response){
						jQuery("select[name=facebook-album-select]").html(response.html);
						jQuery('select[name=facebook-album-select]').change();
					});	
				}
				else{
					jQuery("select[name=facebook-album-select]").html('');
					jQuery('select[name=facebook-album-select]').change();
				}
			}
		});
		if(jQuery('input[name=source_type]:checked').val()=="facebook") jQuery('input[name=facebook-page-url]').change();

		/**
		 * Same Value Facebook Album Select / Hidden Input
		 */
		jQuery('select[name=facebook-album-select]').change(function(){
			jQuery('input[name=facebook-album]').val(jQuery('select[name=facebook-album-select]').val());
		});

		/**
		 * Change flickr Stream Type
		 */
		jQuery('select[name=flickr-type]').change(function(){
			var set = jQuery(this).val();
			switch(set){
				case 'publicphotos':
					jQuery('#flickr-photosets-wrap,#flickr-gallery-url-wrap,#flickr-group-url-wrap').hide();
					jQuery('#flickr-publicphotos-url-wrap').show();
					break;
				case 'gallery':
					jQuery('#flickr-publicphotos-url-wrap,#flickr-photosets-wrap,#flickr-group-url-wrap').hide();
					jQuery('#flickr-gallery-url-wrap').show();
					break;
				case 'photosets':
					jQuery('#flickr-gallery-url-wrap,#flickr-group-url-wrap').hide();
					jQuery('#flickr-publicphotos-url-wrap,#flickr-photosets-wrap').show();
					break;
				case 'group':
					jQuery('#flickr-publicphotos-url-wrap,#flickr-photosets-wrap,#flickr-gallery-url-wrap').hide();
					jQuery('#flickr-group-url-wrap').show();
					break;
			}
		});
		jQuery('select[name=flickr-type]').change();

		/**
		 * Show/Hide flickr Photosets
		 */
		jQuery('input[name=flickr-user-url],select[name=flickr-type]').change(function(){
			if(jQuery("select[name=flickr-type]").val()=='photosets'){
				if(jQuery('input[name=flickr-user-url]').val()!="" && jQuery('input[name=flickr-api-key]').val()!=""){
					var data = {
									url 	:  jQuery('input[name=flickr-user-url]').val(),
									key 	:  jQuery('input[name=flickr-api-key]').val(),
									count 	:  jQuery('input[name=flickr-count]').val(),
									set 	:  jQuery('input[name=flickr-photoset]').val()
								};
					UniteAdminRev.ajaxRequest("get_flickr_photosets", data, function(response){
						jQuery("select[name=flickr-photoset-select]").html(response.data.html);
						jQuery('select[name=flickr-photoset-select]').change();
					});	
				}	
				else{
					jQuery("select[name=flickr-photoset-select]").html(response.data.html);
					jQuery('input[name=flickr-photoset]').val('');
				}
			}
		});

		if(jQuery("select[name=flickr-type]").val()=='photosets' && jQuery('input[name=source_type]:checked').val()=="flickr") jQuery('input[name=flickr-user-url]').change();

		/**
		 * Same Value flickr photoset Select / Hidden Input
		 */
		jQuery('select[name=flickr-photoset-select]').change(function(){
			jQuery('input[name=flickr-photoset]').val(jQuery('select[name=flickr-photoset-select]').val());
		});

		/**
		 * Same Value YouTube Playlist Select / Hidden Input
		 */
		jQuery('select[name=youtube-playlist-select]').change(function(){
			jQuery('input[name=youtube-playlist]').val(jQuery('select[name=youtube-playlist-select]').val());
		});

		/**
		 * Show/Hide YouTube Playlists
		 */
		jQuery('input[name=youtube-channel-id]').change(function(){
			if(jQuery("select[name='youtube-type-source']").val()=='playlist'){
				var data = {
								api: jQuery('input[name=youtube-api]').val(),
								id : jQuery('input[name=youtube-channel-id]').val(),
								playlist :  jQuery('input[name=youtube-playlist]').val()
							};
				if(jQuery('input[name=youtube-channel-id]').val()!=""){
					UniteAdminRev.ajaxRequest("get_youtube_playlists", data,function(response){
						jQuery("select[name=youtube-playlist-select]").html(response.data.html);
						jQuery('select[name=youtube-playlist-select]').change();
					});	
				}
				else{
					jQuery("select[name=youtube-playlist-select]").html('');
				}
			}
		});

		/**
		 * Change YouTube Stream Type
		 */
		jQuery('select[name=youtube-type-source]').change(function(){
			var set = jQuery(this).val();
			if(set != 'playlist'){
				jQuery('#youtube-playlist-wrap').hide();
			}
			else{
				jQuery('#youtube-playlist-wrap').show();
				if(jQuery('input[name=source_type]:checked').val()=="youtube" && jQuery('input[name=youtube-channel-id]').val()!="" && jQuery('select[name="youtube-type-source"]').val() == 'playlist'){
					jQuery('input[name=youtube-channel-id]').change();	
				}
			}
		});
		jQuery('select[name=youtube-type-source]').change();

		/**
		 * Show Vimeo Source Type specific Inputs
		 */
		jQuery('select[name=vimeo-type-source]').change(function(){
			var set = jQuery(this).val();
			jQuery(".source-vimeo").hide();
			jQuery("#vimeo-"+set+"-wrap").show();
		});
		jQuery('select[name=vimeo-type-source]').change();

		/**
		 * Change Instagram Type
		 */
		jQuery('body').on('change','select[name="instagram-type"]',function(){
		 	var set = jQuery(this).val();
			jQuery(this).parent().find('div').hide();
			jQuery("#instagram_"+set).show();
		 });
		 if(jQuery('input[name=source_type]:checked').val()=="instagram") jQuery('select[name="instagram-type"]').change();

		/**
		 * Set bullet type and navigation arrows to none if loop_slide is set to off
		 */
		jQuery('body').on('click', 'input[name="loop_slide"]', function(){

			if(jQuery(this).val() == 'noloop'){
				jQuery('#navigaion_type option[value="none"]').attr('selected', true);
				jQuery('#navigation_arrows option[value="none"]').attr('selected', true);
				jQuery('#navigaion_type').change();
				jQuery('#navigation_arrows').change();

				UniteAdminRev.showInfo({type: 'info', hideon: '', event: '', content: rev_lang.nav_bullet_arrows_to_none, hidedelay: 3});
			}
		});
		
		
		/**
		 * Enables the Advanced Responsive Sizes feature
		 */
		jQuery('#enable_advanced_sizes').click(function(){
			jQuery('.rev-advanced-sizes-wrap').show();
			jQuery('#rev-enable-advanced-sizes').hide();
			jQuery('input[name="advanced-responsive-sizes"]').val('true');
			jQuery('.rev-desktop-naming').html('Desktop');
			
		});


		/**
		 * Disable the Advanced Responsive Sizes feature
		 */
		jQuery('#disable_advanced_sizes').click(function(){
			jQuery('.rev-advanced-sizes-wrap').hide();
			jQuery('#rev-enable-advanced-sizes').show();
			jQuery('input[name="advanced-responsive-sizes"]').val('false');
			jQuery('.rev-desktop-naming').html('');
		});
	}


	/**
	Init Slider Spinner Admin View
	**/
	this.initSpinnerAdmin = function() {
		jQuery('#use_spinner_row').parent().prepend('<div id="spinner_preview"></div>');
		var spin = jQuery('#spinner_preview');
		var sel = jQuery('#use_spinner');
		var col = jQuery('#spinner_color');
		var oldcol = col.val();
		resetSpin(spin);

		sel.on("change",function() {
			resetSpin(spin,true);
		});
		setInterval(function() {
			if (oldcol!=col.val()) {
				spinnerColorChange();
				oldocl=col.val();
			}
		},300)
	}
	/**
	CHANGE SPINNER COLOR ON CALL BACK
	**/
	function spinnerColorChange() {
			var col = jQuery('#spinner_color').val();
			var sel = jQuery('#use_spinner');
			if (sel.val()==0 || sel.val()==5) col ="#ffffff";

			var spin = jQuery('#spinner_preview .tp-loader.tp-demo');
			if (spin.hasClass("spinner0") || spin.hasClass("spinner1") || spin.hasClass("spinner2")) {
				spin.css({'backgroundColor':col});
			} else {
				spin.find('div').css({'backgroundColor':col});
			}
	};

	/**
	RESET SPINNER DEMO
	**/
	function resetSpin(spin,remove) {
			var sel = jQuery('#use_spinner');
			spin.find('.tp-loader').remove();
			spin.append('<div class="tp-loader tp-demo">'+
														'<div class="dot1"></div>'+
														'<div class="dot2"></div>'+
														'<div class="bounce1"></div>'+
														'<div class="bounce2"></div>'+
														'<div class="bounce3"></div>'+
													 '</div>');
			spin.find('.tp-demo').addClass("spinner"+sel.val());
			if (sel.val()=='-1' || sel.val()==0 || sel.val()==5) {
				//jQuery('#spinner_color').val("#ffffff");
				jQuery('#spinner_color_row').css({display:"none"});
			} else {
				jQuery('#spinner_color_row').css({display:"block"});
			}
			spinnerColorChange();

	};

	/**
	 * init "slider->add" view.
	 */
	this.initAddSliderView = function(){

		initSliderViewCommon();

		jQuery("#title").focus();
		initSaveSliderButton("create_slider");

		enableSliderViewResponsitiveFields(false,false,false,"normal"); //show grid settings for fixed

		this.initSpinnerAdmin();
	}

	
	/**
	 * init "slider->edit" view.
	 */
	this.initEditSliderView = function(){

		initSliderViewCommon();

		initSaveSliderButton("update_slider");

		//delete slider action
		jQuery("#button_delete_slider, #button_delete_slider_t").click(function(){

			if(confirm(rev_lang.really_want_to_delete+" '"+jQuery("#title").val()+"' ?") == false)
				return(true);

			var data = {sliderid: jQuery("#sliderid").val()}

			UniteAdminRev.ajaxRequest("delete_slider" ,data);
		});
		

		//api inputs functionality:
		jQuery("#api_wrapper .api-input").click(function(){
			jQuery(this).select().focus();
		});

		//api button functions:
		jQuery("#link_show_api").click(function(){
			jQuery("#api_wrapper").show();
			jQuery("#link_show_api").addClass("button-selected");

			jQuery("#toolbox_wrapper").hide();
			jQuery("#link_show_toolbox").removeClass("button-selected");
		});

		jQuery("#link_show_toolbox").click(function(){
			jQuery("#toolbox_wrapper").show();
			jQuery("#link_show_toolbox").addClass("button-selected");

			jQuery("#api_wrapper").hide();
			jQuery("#link_show_api").removeClass("button-selected");
		});


		//export slider action
		jQuery("#button_export_slider").click(function(){
			var sliderID = jQuery("#sliderid").val();
			var useDummy = jQuery('input[name="export_dummy_images"]').is(':checked');
			var urlAjaxExport = ajaxurl+UniteAdminRev.return_ajaxurl_param()+"action="+g_uniteDirPlugin+"_ajax_action&client_action=export_slider&dummy="+useDummy+"&nonce=" + g_revNonce;
			urlAjaxExport += "&sliderid=" + sliderID;
			location.href = urlAjaxExport;
		});

		//preview slider actions
		jQuery("#button_preview_slider, #button_preview_slider_t").click(function(){
			var sliderID = jQuery("#sliderid").val();
			openPreviewSliderDialog(sliderID);
		});

		//replace url
		jQuery("#button_replace_url").click(function(){
			if(confirm(rev_lang.sure_to_replace_urls) == false)
				return(false);

			var data = {
					sliderid: jQuery("#sliderid").val(),
					url_from:jQuery("#replace_url_from").val(),
					url_to:jQuery("#replace_url_to").val()
				};

			//some ajax beautifyer
			UniteAdminRev.setAjaxLoaderID("loader_replace_url");
			UniteAdminRev.setAjaxHideButtonID("button_replace_url");
			UniteAdminRev.setSuccessMessageID("replace_url_success");

			UniteAdminRev.ajaxRequest("replace_image_urls" ,data);
		});

		jQuery('input[name="slider_type"]').each(function(){ if(jQuery(this).is(':checked')) jQuery(this).click(); }); //show grid settings for choosen setting


		jQuery('#reset_slide_button').click(function(){
			if(jQuery(this).css('opacity') == '0.5') return false;
			
			if(confirm(rev_lang.set_settings_on_all_slider) == false)
				return(false);
			
			var data = {sliderid: jQuery("#sliderid").val()};
			
			if(jQuery('input[name="reset-slide_transition"]').is(':checked')) data['slide_transition'] = jQuery('select[name="def-slide_transition"] option:selected').val();
			if(jQuery('input[name="reset-transition_duration"]').is(':checked')) data['transition_duration'] = jQuery('input[name="def-transition_duration"]').val();
			if(jQuery('input[name="reset-image_source_type"]').is(':checked')) data['image_source_type'] = jQuery('select[name="def-image_source_type"] option:selected').val(); 
			if(jQuery('input[name="reset-background_fit"]').is(':checked')){
				data['bg_fit'] = jQuery('#def-background_fit option:selected').val();
				if(data['bg_fit'] == 'percentage'){
					data['bg_fit_x'] = jQuery('input[name="def-bg_fit_x"]').val();
					data['bg_fit_y'] = jQuery('input[name="def-bg_fit_y"]').val();
				}
			}
			if(jQuery('input[name="reset-bg_position"]').is(':checked')){
				data['bg_position'] = jQuery('select[name="def-bg_position"] option:selected').val();
				if(data['bg_position'] == 'percentage'){
					data['bg_position_x'] = jQuery('input[name="def-bg_position_x"]').val();
					data['bg_position_y'] = jQuery('input[name="def-bg_position_y"]').val();
				}
			}
			if(jQuery('input[name="reset-bg_repeat"]').is(':checked')) data['bg_repeat'] = jQuery('select[name="def-bg_repeat"] option:selected').val();
			
			if(jQuery('input[name="reset-kenburn_effect"]').is(':checked')) data['kenburn_effect'] = (jQuery('input[name="def-kenburn_effect"]').is(':checked')) ? 'on' : 'off';
			if(jQuery('input[name="reset-kb_start_fit"]').is(':checked')) data['kb_start_fit'] = jQuery('input[name="def-kb_start_fit"]').val();
			if(jQuery('input[name="reset-kb_easing"]').is(':checked')) data['kb_easing'] = jQuery('select[name="def-kb_easing"] option:selected').val();
			if(jQuery('input[name="reset-kb_end_fit"]').is(':checked')) data['kb_end_fit'] = jQuery('input[name="def-kb_end_fit"]').val();
			if(jQuery('input[name="reset-kb_duration"]').is(':checked')) data['kb_duration'] = jQuery('input[name="def-kb_duration"]').val();
			
			
			if(jQuery('input[name="reset-kb_start_offset_x"]').is(':checked')) data['kb_start_offset_x'] = jQuery('input[name="def-kb_start_offset_x"]').val();
			if(jQuery('input[name="reset-kb_start_offset_y"]').is(':checked')) data['kb_start_offset_y'] = jQuery('input[name="def-kb_start_offset_y"]').val();
			
			if(jQuery('input[name="reset-kb_end_offset_x"]').is(':checked')) data['kb_end_offset_x'] = jQuery('input[name="def-kb_end_offset_x"]').val();
			if(jQuery('input[name="reset-kb_end_offset_y"]').is(':checked')) data['kb_end_offset_y'] = jQuery('input[name="def-kb_end_offset_y"]').val();
			if(jQuery('input[name="reset-kb_start_rotate"]').is(':checked')) data['kb_start_rotate'] = jQuery('input[name="def-kb_start_rotate"]').val();
			if(jQuery('input[name="reset-kb_end_rotate"]').is(':checked')) data['kb_end_rotate'] = jQuery('input[name="def-kb_end_rotate"]').val();
			
			UniteAdminRev.ajaxRequest('reset_slide_settings', data);
		});
		
		jQuery('.rs-reset-slide-setting').change(function(){
			jQuery('#reset_slide_button').css('opacity', '0.5');
			jQuery('.rs-reset-slide-setting').each(function(){
				if(jQuery(this).is(':checked')){
					
					jQuery('#reset_slide_button').css('opacity', '1');
					
					return true;
				}
			});
		});
		
		jQuery('.rs-reset-slide-setting').change();
		
		jQuery('.tp-moderncheckbox').each(function(){
			RevSliderSettings.onoffStatus(jQuery(this));
		});

		this.initSpinnerAdmin();
	}


	/**
	 * init shortcode functionality in the slider new and slider edit views.
	 */
	var initShortcode = function(){

		//select shortcode text when click on it.
		jQuery("#shortcode").focus(function(){
			this.select();
		});
		jQuery("#shortcode").click(function(){
			this.select();
		});

		//update shortcode
		jQuery("#alias").change(function(){
			updateShortcode();
		});

		jQuery("#alias").keyup(function(){
			updateShortcode();
		});
		updateShortcode();
	}


	/**
	 * update slides order
	 */
	var updateSlidesOrder = function(sliderID){
		var arrSlideHtmlIDs = jQuery( "#list_slides" ).sortable("toArray");

		//get slide id's from html (li) id's
		var arrIDs = [];
		var orderCounter = 0;
		jQuery(arrSlideHtmlIDs).each(function(index,value){
			var slideID = value.replace("slidelist_item_","");
			arrIDs.push(slideID);

			//update order visually
			orderCounter++;
			jQuery("#slidelist_item_"+slideID+" .order-text").text(orderCounter);
		});

		//save order
		var data = {arrIDs:arrIDs,sliderID:sliderID};

		jQuery("#saving_indicator").show();
		UniteAdminRev.ajaxRequest("update_slides_order" ,data,function(){
			jQuery("#saving_indicator").hide();
		});

		jQuery("#select_sortby").val("menu_order");
	}

	
	this.initNewsletterRoutine = function(){

		jQuery('#subscribe-to-newsletter').click(function(){

			var data = {
				email: jQuery('input[name="rs-email"]').val()
			}

			UniteAdminRev.ajaxRequest("subscribe_to_newsletter", data); //, '#subscribe-to-newsletter'
		});
		
		
		jQuery('#activate-unsubscribe').click(function(){
			jQuery('.subscribe-newsletter-wrap').hide();
			jQuery('#activate-unsubscribe').hide();
			jQuery('.unsubscribe-newsletter-wrap').show();
			jQuery('#unsubscribe-text').show();
			jQuery('#subscribe-text').hide();
		});
		jQuery('#cancel-unsubscribe').click(function(){
			jQuery('.subscribe-newsletter-wrap').show();
			jQuery('#activate-unsubscribe').show();
			jQuery('.unsubscribe-newsletter-wrap').hide();
			jQuery('#unsubscribe-text').hide();
			jQuery('#subscribe-text').show();
		});
		
		jQuery('#unsubscribe-to-newsletter').click(function(){

			var data = {
				email: jQuery('input[name="rs-email"]').val()
			}

			UniteAdminRev.ajaxRequest("unsubscribe_to_newsletter", data); //, '#unsubscribe-to-newsletter'
		});
		

	}
	
	/**
	 * init "sliders list" view
	 */
	this.initSlidersListView = function(){
		
		jQuery('body').on('click', '.rs-reload-shop', function(){
			showWaitAMinute({fadeIn:300,text:rev_lang.please_wait_a_moment});
			
			location.href = window.location.href+'&update_shop';
		});
		
		/**
		 * add Template Slider through Import. Check for zip name
		 **/
		jQuery('body').on('click', '.template_slider_item_reimport, .install_template_slider', function(){
			
			if(jQuery(this).hasClass('deny_download')){
				alert(rev_lang.this_template_requires_version+' '+jQuery(this).data('versionneed')+' '+rev_lang.of_slider_revolution);
				return false;
			}
			
			//modify the dialog with some informations 
			jQuery('.rs-zip-name').text(jQuery(this).data('zipname'));
			jQuery('.rs-uid').val(jQuery(this).data('uid'));
			
			//from server or from local file
			
			jQuery("#dialog_import_template_slider_from").dialog({
				modal:true,
				resizable:false,
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
				buttons:{
					"Local":function(){
						if(RS_DEMO){
							alert(rev_lang.not_available_in_demo);
							return false;
						}
						jQuery(".input_import_slider").val('');
						jQuery('.rs-import-slider-button').hide();
						
						jQuery("#dialog_import_template_slider").dialog({
							modal:true,
							resizable:false,
							width:600,
							height:400,
							closeOnEscape:true,
							dialogClass:"tpdialogs",
							create:function(ui) {				
								jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
							},
							buttons:{
								"Close":function(){
									jQuery(this).dialog("close");
								}
							},
						});	//dialog end
						
			
						jQuery(this).dialog("close");
					},
					"Online":function(){
						if(rs_plugin_validated){
							if(rs_single_page_creation){
								jQuery('#dialog_import_template_slider_page_template').dialog({
									modal:true,
									resizable:false,
									title:'Import',
									width:350,
									height:200,
									closeOnEscape:true,
									dialogClass:"tpdialogs",
									create:function(ui) {				
										jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
									},
									buttons:{
										'Yes':function(){
											
											jQuery('#rs-import-template-from-server').find('.rs-page-creation').val('true');
											//show please wait
											showWaitAMinute({fadeIn:300,text:rev_lang.please_wait_a_moment});
											
											//get from server
											jQuery('#rs-import-template-from-server').submit();
											jQuery(this).dialog("close");
											jQuery("#dialog_import_template_slider_from").dialog("close");
										},
										'No':function(){
											jQuery('#rs-import-template-from-server').find('.rs-page-creation').val('false');
											
											//show please wait
											showWaitAMinute({fadeIn:300,text:rev_lang.please_wait_a_moment});
											
											//get from server
											jQuery('#rs-import-template-from-server').submit();
											jQuery(this).dialog("close");
											jQuery("#dialog_import_template_slider_from").dialog("close");
										}
									}
									
								});
							}else{
								jQuery('#rs-import-template-from-server').find('.rs-page-creation').val('false');
								
								//show please wait
								showWaitAMinute({fadeIn:300,text:rev_lang.please_wait_a_moment});
								
								//get from server
								jQuery('#rs-import-template-from-server').submit();
								jQuery("#dialog_import_template_slider_from").dialog("close");
							}
						}else{
							jQuery('#regsiter-to-access-store-none').click();
						}
					}
				}
			});
			
			jQuery('#close-template').click();
			return false;
		});
		
		
		
		jQuery('body').on('click', '.template_slider_item_reimport_package, .install_template_slider_package', function(){
			
			if(jQuery(this).hasClass('deny_download')){
				alert(rev_lang.this_template_requires_version+' '+jQuery(this).data('versionneed')+' '+rev_lang.of_slider_revolution);
				return false;
			}
			
			//modify the dialog with some informations 
			jQuery('.rs-zip-name').text(jQuery(this).data('zipname'));
			jQuery('.rs-uid').val(jQuery(this).data('uid'));
			jQuery('.rs-package').val('true'); //set that the package needs to be installed
			
			if(rs_plugin_validated){
				if(rs_pack_page_creation){
					jQuery('#dialog_import_template_slider_page_template').dialog({
						modal:true,
						resizable:false,
						title:'Import',
						width:350,
						height:200,
						closeOnEscape:true,
						dialogClass:"tpdialogs",
						create:function(ui) {				
							jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
						},
						buttons:{
							'Yes':function(){
								
								jQuery('#rs-import-template-from-server').find('.rs-page-creation').val('true');
								//show please wait
								showWaitAMinute({fadeIn:300,text:rev_lang.please_wait_a_moment});
								
								//get from server
								jQuery('#rs-import-template-from-server').submit();
								jQuery('.rs-package').val('false');
				
								jQuery(this).dialog("close");
							},
							'No':function(){
								jQuery('#rs-import-template-from-server').find('.rs-page-creation').val('false');
								
								//show please wait
								showWaitAMinute({fadeIn:300,text:rev_lang.please_wait_a_moment});
								
								//get from server
								jQuery('#rs-import-template-from-server').submit();
								jQuery('.rs-package').val('false');
				
								jQuery(this).dialog("close");
							}
						}
						
					});
				}else{
					jQuery('#rs-import-template-from-server').find('.rs-page-creation').val('false');
					
					//show please wait
					showWaitAMinute({fadeIn:300,text:rev_lang.please_wait_a_moment});
					
					//get from server
					jQuery('#rs-import-template-from-server').submit();
					jQuery('.rs-package').val('false');
				}
			}else{
				jQuery('.rs-package').val('false');
			
				alert(rev_lang.this_feature_only_if_activated);
			}
			
			
			jQuery('#close-template').click();
			return false;
		});
		
		
		/**
		 * add Template Slider
		 **/
		jQuery('body').on('click', '.add_template_slider_item', function(){
			var slider_id = jQuery(this).data('sliderid');
			
			
			jQuery('#dialog_duplicate_slider').dialog({
				modal:true,
				resizable:false,
				title:'Import',
				width:250,
				height:200,
				closeOnEscape:true,
				dialogClass:"tpdialogs",
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
				buttons:{
					'Close':function(){
						jQuery(this).dialog("close");
					},
					'Import':function(){
						if(jQuery('#rs-duplicate-animation').val() == '') return false;
						
						UniteAdminRev.ajaxRequest('duplicate_slider', {sliderid:slider_id,title:jQuery('#rs-duplicate-animation').val()}, function(response){
							jQuery('#close-template').click();
						});
					}
				}
			});
		});
		
		
		/**
		 * add Template Slider Pack
		 **/
		jQuery('body').on('click', '.add_template_slider_item_package', function(){
			var uid = jQuery(this).data('uid');
			
			jQuery('#dialog_duplicate_slider_package').dialog({
				modal:true,
				resizable:false,
				title:'Import Package',
				width:250,
				height:200,
				closeOnEscape:true,
				dialogClass:"tpdialogs",
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
				buttons:{
					'Close':function(){
						jQuery(this).dialog("close");
					},
					'Import Package':function(){
						if(jQuery('#rs-duplicate-prefix').val() == '') return false;
						
						UniteAdminRev.ajaxRequest('duplicate_slider_package', {slideruid:uid,title:jQuery('#rs-duplicate-prefix').val()}, function(response){
							jQuery('#close-template').click();
						});
					}
				}
			});
		});
		
		jQuery(".input_import_slider").change(function(){
			if(jQuery(this).val() !== ''){
				jQuery('.rev-import-slider-button').show();
			}else{
				jQuery('.rev-import-slider-button').hide();
			}
		});
		
		
		jQuery("#button_import_template_slider, #button_import_template_slider_b").click(function(){
			t.load_slider_template_html();
		});
		
		//import slide dialog
		jQuery("#button_import_slider").click(function(){
			if(RS_DEMO){
				alert(rev_lang.not_available_in_demo);
				return false;
			}
			jQuery('.rev-import-slider-button').hide();
			
			jQuery(".input_import_slider").val('');
			
			jQuery("#dialog_import_slider").dialog({
				modal:true,
				resizable:false,
				width:600,
				height:400,
				closeOnEscape:true,
				dialogClass:"tpdialogs",
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
				buttons:{
					"Close":function(){
						jQuery(this).dialog("close");
					}
				},
			});	//dialog end

		});

		jQuery(".button_delete_slider").click(function(){
			
			var sliderID = this.id.replace("button_delete_","");
			var sliderTitle = jQuery("#slider_title_"+sliderID).text();
			if(confirm(rev_lang.really_want_to_delete+" '"+sliderTitle+"' ?") == false)
				return(false);

			UniteAdminRev.ajaxRequest("delete_slider_stay" ,{sliderid:sliderID}, function(){
				jQuery('li[data-id="'+sliderID+'"]').remove();
			});
		});

		//duplicate slider action
		jQuery('.button_duplicate_slider').click(function(){
			var sliderID = this.id.replace('button_duplicate_', '');
			
			jQuery('#dialog_duplicate_slider').dialog({
				modal:true,
				resizable:false,
				width:250,
				height:200,
				closeOnEscape:true,
				dialogClass:"tpdialogs",
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
				buttons:{
					'Close':function(){
						jQuery(this).dialog("close");
					},
					'Duplicate':function(){
						if(jQuery('#rs-duplicate-animation').val() == '') return false;
						
						UniteAdminRev.ajaxRequest('duplicate_slider' ,{sliderid:sliderID,title:jQuery('#rs-duplicate-animation').val()}, function(response){
							
						});
					}
				}
			});
			
			
		});

		//toggle Slider Favorite
		jQuery(".rev-toogle-fav").click(function(){
			var sliderID = this.id.replace('reg-toggle-id-','');
			UniteAdminRev.ajaxRequest('toggle_favorite' ,{id:sliderID},function(){
				var mi = jQuery('#reg-toggle-id-'+sliderID).find('i');
				if(mi.hasClass('eg-icon-star-empty')){
					mi.removeClass('eg-icon-star-empty');
					mi.addClass('eg-icon-star');
				}else{
					mi.removeClass('eg-icon-star');
					mi.addClass('eg-icon-star-empty');
				}
			});
		});

		//preview slider action
		jQuery(".button_slider_preview").click(function(){

			var sliderID = this.id.replace("button_preview_","");

			openPreviewSliderDialog(sliderID);
		});

		//export slider action on slider overview
		jQuery(".export_slider_overview").click(function(){

			var sliderID = this.id.replace("export_slider_","");
			var useDummy = false;//jQuery('input[name="export_dummy_images"]').is(':checked');
			var urlAjaxExport = ajaxurl+UniteAdminRev.return_ajaxurl_param()+"action="+g_uniteDirPlugin+"_ajax_action&client_action=export_slider&dummy="+useDummy+"&nonce=" + g_revNonce;
			urlAjaxExport += "&sliderid=" + sliderID;
			location.href = urlAjaxExport;
			
		});
		
		
		jQuery('body').on('click', '.rs-embed-slider', function(){
			
			var use_alias = jQuery(this).closest('li.tls-slide').find('.tls-alias').text();
			
			jQuery('.rs-dialog-embed-slider').find('.rs-example-alias').text(use_alias);
			jQuery('.rs-dialog-embed-slider').find('.rs-example-alias-1').text('[rev_slider alias="'+use_alias+'"]');
			
			jQuery('.rs-dialog-embed-slider').dialog({
				modal: true,
				resizable:false,
				minWidth:850,
				minHeight:300,
				closeOnEscape:true,
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				}
			});
		});
		

		jQuery(".export_slider_standalone").click(function(){
			
			var sliderID = this.id.replace("export_slider_standalone_","");
			var useDummy = false;//jQuery('input[name="export_dummy_images"]').is(':checked');
			var urlAjaxExport = ajaxurl+UniteAdminRev.return_ajaxurl_param()+"action="+g_uniteDirPlugin+"_ajax_action&client_action=preview_slider&only_markup=true&dummy="+useDummy+"&nonce=" + g_revNonce;
			urlAjaxExport += "&sliderid=" + sliderID;
			location.href = urlAjaxExport;
			
		});
	}

	/**
	 * open preview slider dialog
	 */
	var openPreviewSliderDialog = function(sliderID){

		var rs_form = jQuery('#rs-preview-form');
		
		//set action and data
		jQuery("#rs-client-action").val('preview_slider');
		jQuery("#preview_sliderid").val(sliderID);
		jQuery("#preview_slider_markup").val('false');
		
		rs_form.submit();
		
		jQuery('#rs-preview-wrapper').show();
		
		jQuery(window).trigger('resize');
	}

	/**
	 * get language array from the language list
	 */
	var getLangsFromLangList = function(objList){
		var arrLangs = [];
		objList.find(".icon_slide_lang").each(function(){
			var lang = jQuery(this).data("lang");
			arrLangs.push(lang);
		});

		return(arrLangs);
	}


	/**
	 * filter langs float menu by the list of icons
	 * show only languages in the float menu that not exists in the icons list
	 * return number of available languages
	 */
	var filterFloatMenuByListIcons = function(objList,operation){
		var arrLangs = getLangsFromLangList(objList);
		var numIcons = 0;

		jQuery("#langs_float_wrapper li.item_lang").each(function(){
			var objItem = jQuery(this);
			var lang = objItem.data("lang");
			var found = jQuery.inArray(lang,arrLangs);

			if(operation != "add")
				jQuery("#langs_float_wrapper li.operation_sap").hide();

			if(jQuery.inArray(lang,arrLangs) == -1){
				numIcons++;
				objItem.show();
				if(operation != "add")
					jQuery("#langs_float_wrapper li.operation_sap").show();
			}
			else
				objItem.hide();
		});

		return(numIcons);
	}


	/**
	 *
	 * init slides view posts related functions
	 */
	t.initSlidesListViewPosts = function(sliderID){

		initSlideListGlobals(sliderID);

		//init sortby
		jQuery("#select_sortby").change(function(){
			jQuery("#slides_top_loader").show();
			var data = {};
			data.sliderID = sliderID;
			data.sortby = jQuery(this).val();
			UniteAdminRev.ajaxRequest("update_posts_sortby" ,data,function(){
				jQuery("#slides_top_loader").html("Updated, reloading page...");
				location.reload(true);
			});
		});

		// delete single slide
		jQuery(".button_delete_slide").click(function(){
			var postID = jQuery(this).data("slideid");
			var data = {slideID:postID,sliderID:sliderID};

			if(confirm(g_messageDeleteSlide) == false)
				return(false);

			UniteAdminRev.ajaxRequest("delete_slide" ,data);
		});

	}


	/**
	 * init slide list global functions
	 */
	var initSlideListGlobals = function(sliderID){

		//set the slides sortable, init save order
		jQuery("#list_slides").sortable({
				axis:"y",
				handle:'.col-handle',
				update:function(){updateSlidesOrder(sliderID)}
		});


		//publish / unpublish item
		jQuery("#list_slides .icon_state").click(function(){
			var objIcon = jQuery(this);
			var objLoader = objIcon.siblings(".state_loader");
			var slideID = objIcon.data("slideid");
			var data = {slider_id:sliderID,slide_id:slideID};

			objIcon.hide();
			objLoader.show();
			UniteAdminRev.ajaxRequest("toggle_slide_state" ,data,function(response){
				objIcon.show();
				objLoader.hide();
				var currentState = response.state;

				if(currentState == "published"){
					objIcon.removeClass("state_unpublished").addClass("state_published").prop("title","Unpublish Slide");
				}else{
					objIcon.removeClass("state_published").addClass("state_unpublished").prop("title","Publish Slide");
				}

			});
		});

		//change image
		jQuery(".col-image .slide_image").click(function(){
			var slideID = this.id.replace("slide_image_","");
			UniteAdminRev.openAddImageDialog(g_messageChangeImage,function(urlImage,imageID){
				var data = {slider_id:sliderID,slide_id:slideID,url_image:urlImage,image_id:imageID};
				UniteAdminRev.ajaxRequest("change_slide_image" ,data);
			});
		}).tipsy({
			gravity:"s",
			delayIn: 70
		});

	}


	/**
	 * init "slides list" view
	 */
	t.initSlidesListView = function(sliderID){

		initSlideListGlobals(sliderID);

		//new slide
		jQuery("#button_new_slide, #button_new_slide_top").click(function(){
			var dialogTitle = jQuery("#button_new_slide").data("dialogtitle");

			UniteAdminRev.openAddImageDialog(dialogTitle, function(obj){
				var data = {sliderid:sliderID,obj:obj};
				UniteAdminRev.ajaxRequest("add_slide" ,data);
			},true);	//allow multiple selection

		});

		//new transparent slide
		jQuery("#button_new_slide_transparent, #button_new_slide_transparent_top").click(function(){
			jQuery(this).hide();
			jQuery(".new_trans_slide_loader").show();
			var data = {sliderid:sliderID};
			UniteAdminRev.ajaxRequest("add_slide" ,data);
		});

		//duplicate slide
		jQuery(".button_duplicate_slide").click(function(){
			var slideID = this.id.replace("button_duplicate_slide_","");
			var data = {slideID:slideID,sliderID:sliderID};
			UniteAdminRev.ajaxRequest("duplicate_slide" ,data);
		});

		//copy / move slides
		jQuery(".button_copy_slide").click(function(){
			if(jQuery(this).hasClass("button-disabled"))
				return(false);

			var dialogCopy = jQuery("#dialog_copy_move");

			var textClose = dialogCopy.data("textclose");
			var textUpdate = dialogCopy.data("textupdate");
			var objButton = jQuery(this);

			var buttons = {};
			buttons[textUpdate] = function(){
				var slideID = objButton.attr("id").replace("button_copy_slide_","");
				var targetSliderID = jQuery("#selectSliders").val();
				var operation = "copy";
				if(jQuery("#radio_move").prop("checked") == "checked")
					operation = "move";

				var data = {slideID:slideID,
							sliderID:sliderID,
							targetSliderID:targetSliderID,
							operation:operation};

				var objLoader = objButton.siblings(".loader_copy");

				objButton.hide();
				objLoader.show();

				UniteAdminRev.ajaxRequest("copy_move_slide" ,data);
				jQuery(this).dialog("close");
			};

			jQuery("#dialog_copy_move").dialog({
				modal:true,
				resizable:false,
				width:400,
				height:300,
				closeOnEscape:true,
				dialogClass:"tpdialogs",
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
				buttons:buttons
			});	//dialog end

		});

		// delete single slide
		jQuery(".button_delete_slide").click(function(){
			var slideID = jQuery(this).data("slideid");
			var data = {slideID:slideID,sliderID:sliderID};
			if(confirm("Delete this slide?") == false)
				return(false);

			var objButton = jQuery(this);
			var objLoader = objButton.siblings(".loader_delete");

			objButton.hide();
			objLoader.show();

			UniteAdminRev.ajaxRequest("delete_slide" ,data);
		});

		//preview slide from the slides list:
		jQuery("#list_slides .icon_slide_preview").click(function(){
			var slideID = jQuery(this).data("slideid");
			openPreviewSlideDialog(slideID,false);
		});

	}

	t.saveEditSlide = function(slideID, isDemo){
		if(!isDemo)
			isDemo = false;
		
		tpLayerTimelinesRev.updateZIndexByOrder();
		UniteLayersRev.setRowZoneOrders();
		tpLayerTimelinesRev.organiseGroupsAndLayer();
		
		var layers = UniteLayersRev.getLayers();
		
		var arrLayersNew = {};
		for(key in layers){
			if(layers[key].layer_unavailable !== true && layers[key].deleted !== true){
				arrLayersNew[key] = jQuery.extend(true, {}, layers[key]);
				
				if(typeof(arrLayersNew[key].layer_unavailable) !== 'undefined') delete(arrLayersNew[key].layer_unavailable);
				if(typeof(arrLayersNew[key].deleted) !== 'undefined') delete(arrLayersNew[key].deleted);
				if(typeof(arrLayersNew[key].references) !== 'undefined') delete(arrLayersNew[key].references);
				if(typeof(arrLayersNew[key].createdOnInit) !== 'undefined') delete(arrLayersNew[key].createdOnInit);
			}
		}
		
		if(JSON && JSON.stringify)
			arrLayersNew = JSON.stringify(arrLayersNew);
		
		
		
		var data = {
			slideid:slideID,
			layers:arrLayersNew
		};
		
		data.params = RevSliderSettings.getSettingsObject("form_slide_params");
		
		if(!isDemo){ //demo means static captions. This has

			data.params.slide_bg_color = jQuery("#slide_bg_color").val();
			data.params.slide_bg_external = jQuery("#slide_bg_external").val();
			data.params.bg_fit = jQuery("#slide_bg_fit").val();
			data.params.bg_fit_x = jQuery("input[name='bg_fit_x']").val();
			data.params.bg_fit_y = jQuery("input[name='bg_fit_y']").val();
			data.params.bg_repeat = jQuery("#slide_bg_repeat").val();
			data.params.bg_position = jQuery("#slide_bg_position").val();
			data.params.bg_position_x = jQuery("input[name='bg_position_x']").val();
			data.params.bg_position_y = jQuery("input[name='bg_position_y']").val();
			data.params.bg_end_position_x = jQuery("input[name='bg_end_position_x']").val();
			data.params.bg_end_position_y = jQuery("input[name='bg_end_position_y']").val();

			var slideBgSetting = getSlideBgSettings(); //get new background options

			if(typeof slideBgSetting === 'object' && !jQuery.isEmptyObject(slideBgSetting)){ //add new background options
				for(key in slideBgSetting){
					data.params[key] = slideBgSetting[key];
				}
			}
			
			//kenburns & pan zoom
			data.params.kenburn_effect = (jQuery("input[name='kenburn_effect']").is(':checked')) ? 'on' : 'off';
			//data.params.kb_rotation_start = jQuery("input[name='kb_rotation_start']").val();
			//data.params.kb_rotation_end = jQuery("input[name='kb_rotation_end']").val();
			data.params.kb_start_fit = jQuery("input[name='kb_start_fit']").val();
			data.params.kb_end_fit = jQuery("input[name='kb_end_fit']").val();

			data.params.bg_end_position = jQuery("select[name='bg_end_position']").val();
			data.params.kb_duration = jQuery("input[name='kb_duration']").val();
			data.params.kb_easing = jQuery("select[name='kb_easing']").val();
			
			data.params.slide_transition = [];
			data.params.slot_amount = [];
			data.params.transition_rotation = [];
			data.params.transition_duration = [];
			data.params.transition_ease_in = [];
			data.params.transition_ease_out = [];
			jQuery('.slide-trans-cur-ul li').each(function(){
				data.params.slide_transition.push(jQuery(this).data('animval'));
				data.params.slot_amount.push(jQuery(this).data('slot'));
				data.params.transition_rotation.push(jQuery(this).data('rotation'));
				data.params.transition_duration.push(jQuery(this).data('duration'));
				data.params.transition_ease_in.push(jQuery(this).data('ease_in'));
				data.params.transition_ease_out.push(jQuery(this).data('ease_out'));
			});
			
			var csel = jQuery('.bgsrcchanger:checked').val();
			
			if(csel == 'vimeo' || csel == 'html5' || csel == 'youtube'){ //check for cover image, if not set, deny the saving
				if((typeof(data.params.image_id) === 'undefined' || parseInt(data.params.image_id) == 0 || data.params.image_id == '') && ((typeof(data.params.image_url) === 'undefined') || data.params.image_url == '')){
					alert(rev_lang.cover_image_needs_to_be_set);
					return false;
				}
			}
			
			
			//remove image_url if we are a stream
			var gallery_type = jQuery('input[name="rs-gallery-type"]').val();
			switch(gallery_type){
				case 'gallery':
				break;
				case 'posts':
				case 'woocommerce':
				case 'facebook':
				case 'twitter':
				case 'instagram':
				case 'flickr':
				case 'youtube':
				case 'vimeo':
					data.params.image_url = '';
				break;
			}
			
			//console.log(tinyMCE.get('slide_description').getContent());
			//data.params.slide_description = 
			
		}
		
		
		//new part, settings that can be saved in slides
		data.settings = {};
		
		/**
		 * Add Horizontal/Vetical Lines
		 */
		var hor_lines = [];
		jQuery('#hor-css-linear .helplines').each(function(){
			hor_lines.push(jQuery(this).css('left'));
		});
		
		var ver_lines = [];
		jQuery('#ver-css-linear .helplines').each(function(){
			ver_lines.push(jQuery(this).css('top'));
		});
		
		data.settings['hor_lines'] = hor_lines;
		data.settings['ver_lines'] = ver_lines;
		
		// HOOK FOR EXTERNAL ADDONS
		jQuery.each(UniteLayersRev.addon_callbacks, function(i,callback_element) {
			var callback = callback_element["callback"],				
				env = callback_element["environment"],
				env_sub = callback_element["function_position"];
			if (env === "saveEditSlide" && env_sub=="data") 				
				data = callback(data);
		});
		
		data.obj_favorites = favoriteObjectsList;
		
		if(!isDemo){
			UniteAdminRev.setAjaxHideButtonID("button_save_slide,button_save_slide-tb");
			UniteAdminRev.setAjaxLoaderID("loader_update");
			UniteAdminRev.setSuccessMessageID("update_slide_success");
			UniteAdminRev.ajaxRequest("update_slide", data);
		}else{
			UniteAdminRev.setAjaxHideButtonID("button_save_static_slide,button_save_static_slide-tb");
			UniteAdminRev.setAjaxLoaderID("loader_update");
			UniteAdminRev.setSuccessMessageID("update_slide_success");
			UniteAdminRev.ajaxRequest("update_static_slide", data);
		}
	}
	
	
	/**
	 * init "edit slide" view
	 */
	this.initEditSlideView = function(slideID,sliderID,is_static){
		
		jQuery('body').on('click', '.rs-reload-shop', function(){
			if(confirm(rev_lang.unsaved_data_will_be_lost_proceed)){
				
				showWaitAMinute({fadeIn:300,text:rev_lang.please_wait_a_moment});
				
				location.href = window.location.href+'&update_shop';
			}
		});
		
		/**
		 * add Template Slider through Import, then add specific slide to current Slider and open it. Check for zip name
		 **/
		jQuery('body').on('click', '.install_template_slide', function(){
			var data = jQuery(this);
			
			if(data.hasClass('deny_download')){
				alert(rev_lang.this_template_requires_version+' '+data.data('versionneed')+' '+rev_lang.of_slider_revolution);
				return false;
			}
			
			if(confirm(rev_lang.unsaved_data_will_be_lost_proceed)){
				
				//modify the dialog with some informations 
				jQuery('.rs-zip-name').text(data.data('zipname'));
				jQuery('.rs-uid').val(data.data('uid'));
				jQuery('.rs-slide-number').val(data.data('slidenumber'));
				jQuery('.rs-slider-id').val(sliderID);
				if(is_static){
					jQuery('.rs-slide-id').val('static_'+sliderID);
				}else{
					jQuery('.rs-slide-id').val(slideID);
				}
				
				jQuery("#dialog_import_template_slide_from").dialog({
					modal:true,
					resizable:false,
					create:function(ui) {				
						jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
					},
					buttons:{
						"Local":function(){
							jQuery(".input_import_slider").val('');
							jQuery('.rs-import-slider-button').hide();
							
							jQuery("#dialog_import_template_slide").dialog({
								modal:true,
								resizable:false,
								width:600,
								height:350,
								closeOnEscape:true,
								dialogClass:"tpdialogs",
								create:function(ui) {				
									jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
								},
								buttons:{
									"Close":function(){
										jQuery(this).dialog("close");
									}
								},
							});	//dialog end
						},
						"Online":function(){
							if(rs_plugin_validated){
								//show please wait
								showWaitAMinute({fadeIn:300,text:rev_lang.please_wait_a_moment});
								
								//get from server
								jQuery('#rs-import-slide-template-from-server').submit();
								
								jQuery(this).dialog("close");
							}else{
								alert(rev_lang.this_feature_only_if_activated);
							}
						}
					}
				});
				
				jQuery('#close-template').click();
			}
		});
		
		
		
		// TOGGLE SOME ACCORDION
		jQuery('.tp-accordion').click(function() {

			var tpacc=jQuery(this);
			if (tpacc.hasClass("tpa-closed")) {
				tpacc.parent().parent().parent().find('.tp-closeifotheropen').each(function() {
					jQuery(this).slideUp(300);
					jQuery(this).parent().find('.tp-accordion').addClass("tpa-closed").addClass("box_closed").find('.postbox-arrow2').html("+");
				});

				tpacc.parent().find('.toggled-content').slideDown(300);
				tpacc.removeClass("tpa-closed").removeClass("box_closed");
				tpacc.find('.postbox-arrow2').html("-");
			} else {
				tpacc.parent().find('.toggled-content').slideUp(300);
				tpacc.addClass("tpa-closed").addClass("box_closed");
				tpacc.find('.postbox-arrow2').html("+");

			}
		})

		// MAKE MAX WIDTH OF CONTAINERS.
		jQuery('.mw960').each(function() {
			var newmw = jQuery('#divLayers').width();
			if (newmw<960) newmw=960;
			jQuery(this).css({maxWidth:newmw+"px"});
		})

		// SORTING AND DEPTH SELECTOR
		jQuery('#button_sort_depth').on('click',function() {
			jQuery('.layer_sortbox').addClass("depthselected");
			jQuery('.layer_sortbox').removeClass("timeselected");
		});

		jQuery('#button_sort_time').on('click',function() {
			jQuery('.layer_sortbox').removeClass("depthselected");
			jQuery('.layer_sortbox').addClass("timeselected");

		});


		//add slide top link
		jQuery("#link_add_slide").click(function(){
			var data = { sliderid:sliderID };
			
			jQuery("#loader_add_slide").show();
			UniteAdminRev.ajaxRequest("add_slide_fromslideview", data);
		});
		
		//add bulk slide top link
		jQuery("#link_add_bulk_slide").click(function(){
			UniteAdminRev.openAddImageDialog(rev_lang.add_bulk_slides, function(obj){
				var data = {sliderid:sliderID,obj:obj};
				UniteAdminRev.ajaxRequest("add_bulk_slide", data);
				
			},true);	//allow multiple selection
		});
		
		jQuery('body').on('click', '.add_template_slide_item, .add_user_template_slide_item', function(){			
			if(confirm(rev_lang.unsaved_data_will_be_lost_proceed)){
				var data = { slider_id:sliderID };
				
				data['slide_id'] = jQuery(this).data('slideid');
				if(is_static){
					data['redirect_id'] = 'static_'+sliderID;
				}else{
					data['redirect_id'] = slideID; //is set in slide.php
				}
				
				UniteAdminRev.ajaxRequest('copy_slide_to_slider', data, function(){
					jQuery('#close-template').click();
				});
			}
		});
		
		//save slide actions
		jQuery("#button_save_slide").click(function(){
			t.saveEditSlide(slideID);
			UniteLayersRev.set_save_needed(false);
		});

		jQuery("#button_save_slide-tb").click(function(){
			t.saveEditSlide(slideID);
			UniteLayersRev.set_save_needed(false);
		});

		//save slide actions
		jQuery("#button_save_static_slide").click(function(){
			t.saveEditSlide(slideID, true);
			UniteLayersRev.set_save_needed(false);
		});

		jQuery("#button_save_static_slide-tb").click(function(){
			t.saveEditSlide(slideID, true);
			UniteLayersRev.set_save_needed(false);
		});

		//change image actions
		jQuery("#button_change_image").click(function(){

			UniteAdminRev.openAddImageDialog(rev_lang.select_slide_img,function(urlImage,imageID){
				if(imageID == undefined)
					imageID = "";

				//set visual image
				jQuery("#divbgholder").css("background-image","url("+urlImage+")");
				jQuery('#slide_selector .list_slide_links li.selected .slide-media-container ').css("background-image","url("+urlImage+")")

				//update setting input
				jQuery("#image_url").val(urlImage);
				jQuery("#image_id").val(imageID);
				
				UniteLayersRev.changeSlotBGs();
				
				jQuery('.bgsrcchanger:checked').click();

				if(jQuery('input[name="kenburn_effect"]').is(':checked')){
					jQuery('input[name="kb_start_fit"]').change();
				}
			}); //dialog
		});	//change image click.

		
		
		//change image actions
		jQuery('.button_change_video').click(function(){
			
			var the_target = jQuery(this).data('inptarget');
			
			UniteAdminRev.openAddVideoDialog(rev_lang.select_slide_video,function(urlVideo,videoID){
				//set URL to the input fields
				jQuery('input[name="'+the_target+'"]').val(urlVideo);
				
				jQuery('#html5_url_audio, #html5_url_ogv, #html5_url_webm, #html5_url_mp4').change();
			}); //dialog
		});	//change image click.
		

		// slide options hide / show
		jQuery("#link_hide_options").click(function(){

			if(jQuery("#slide_params_holder").is(":visible") == true){
				jQuery("#slide_params_holder").hide("slow");
				jQuery(this).text(rev_lang.show_slide_opt).addClass("link-selected");
			}else{
				jQuery("#slide_params_holder").show("slow");
				jQuery(this).text(rev_lang.hide_slide_opt).removeClass("link-selected");
			}

		});


		//preview slide actions - open preveiw dialog
		jQuery("#button_preview_slide").click(function(){
			openPreviewSlideDialog(slideID,true);
		});
		//preview slide actions - open preveiw dialog
		jQuery("#button_preview_slide-tb").click(function(){
			openPreviewSlideDialog(slideID,true);
		});

		//init background options
		jQuery("#radio_back_image, #radio_back_trans, #radio_back_solid, #radio_back_external, #radio_back_youtube, #radio_back_htmlvideo").click(function(){
			var currentType = jQuery("#background_type").val();
			var bgType = jQuery(this).data("bgtype");

			if(currentType == bgType)
				return(true);

			//disable image button
			if(bgType == "image")
				jQuery("#button_change_image").removeClass("button-disabled");
			else
				jQuery("#button_change_external").addClass("button-disabled");

			if(bgType == "solid")
				jQuery("#slide_bg_color").removeClass("disabled").prop("disabled","");
			else
				jQuery("#slide_bg_color").addClass("disabled").prop("disabled","disabled");

			if(bgType == "external"){
				jQuery("#slide_bg_external").removeClass("disabled").prop("disabled","");
				jQuery("#button_change_image").removeClass("button-disabled");
				jQuery("#button_change_external").removeClass("button-disabled");
			}else{
				jQuery("#slide_bg_external").addClass("disabled").prop("disabled","disabled");
				jQuery("#button_change_external").addClass("button-disabled");
			}
			
			jQuery("#background_type").val(bgType);
			
			setSlideBGByType(bgType);
		});

		jQuery("#button_change_external").click(function(){
			var bgType = jQuery("#radio_back_external:checked").data("bgtype");

			if(bgType == "external"){
				jQuery("#slide_bg_external").removeClass("disabled").prop("disabled","");
				jQuery("#button_change_image").removeClass("button-disabled");
				setSlideBGByType(bgType);
				
				if(jQuery('input[name="kenburn_effect"]').is(':checked')){
					jQuery('input[name="kb_start_fit"]').change();
				}
				
				UniteLayersRev.changeSlotBGs();
			}
		});


		//on change bg color event
		UniteAdminRev.setColorPickerCallback(function(){
			var bgType = jQuery("#background_type").val();
			if(bgType == "solid"){
				var bgColor = jQuery("#slide_bg_color").val();
				jQuery("#divbgholder").css("background-color",bgColor);
				jQuery('#slide_selector .list_slide_links li.selected .slide-media-container ').css({backgroundColor:bgColor});
			}					
		});


		//on change title event
		jQuery("#title").on('input',function(e){
			jQuery(".slide_title").text(jQuery("#title").val());
		});

		jQuery(".list_slide_links").sortable({
			items: "li:not(.eg-drag-disabled)",
			update:function(){updateSlidesOrderEdit(sliderID)}
		});


		/**
		 * update slides order in slide edit
		 */
		var updateSlidesOrderEdit = function(sliderID){
			var arrSlideHtmlIDs = jQuery( ".list_slide_links" ).sortable("toArray");

			//get slide id's from html (li) id's
			var arrIDs = [];
			jQuery(arrSlideHtmlIDs).each(function(index,value){
				var slideID = value.replace("slidelist_item_","");
				arrIDs.push(slideID);
			});

			//save order
			var data = {arrIDs:arrIDs,sliderID:sliderID};

			jQuery("#loader_add_slide").show();
			UniteAdminRev.ajaxRequest("update_slides_order" ,data,function(){
				jQuery("#loader_add_slide").hide();
			});

		}

		jQuery('.inputDatePicker').datepicker({
			dateFormat : 'dd-mm-yy 00:00'
		});


		// delete single slide
		jQuery("#button_delete_slide").click(function(){
			var data = {slideID:slideID,sliderID:sliderID};

			if(confirm(g_messageDeleteSlide) == false)
				return(false);

			UniteAdminRev.ajaxRequest("delete_slide" ,data);
		});

		if(jQuery('input[name="load_googlefont"]:checked').val() == 'false'){
			jQuery('#load_googlefont_row').siblings('.spanSettingsStaticText').remove();

			jQuery('#load_googlefont_row').remove();
			jQuery('#google_font_row').remove();
			jQuery('#load_googlefont').closest('.postbox.unite-postbox').hide();

		}
		
		
		// delete single slide
		jQuery('body').on('click', '.slide-remove', function(){
			var slideID = jQuery(this).closest('li').attr("id").replace('slidelist_item_', '');
			var data = {slideID:slideID,sliderID:sliderID};
			
			if(confirm("Delete this slide?") == false)
				return(false);

			var objButton = jQuery(this);
			var objLoader = objButton.siblings(".loader_delete");
			
			objButton.hide();
			objLoader.show();
			
			var curlayer = jQuery(this).closest('li');
			
			var do_request = (curSlideID == slideID) ? 'delete_slide' : 'delete_slide_stay';
			
			UniteAdminRev.ajaxRequest(do_request, data, function(response){
				curlayer.remove();
			});
		});
		
		jQuery('body').on('click', '.slide-published.pubclickable, .slide-unpublished.pubclickable', function(){
			var li = jQuery(this).closest('li'),
				theslideID = li.attr("id").replace('slidelist_item_', ''),
				data = {slider_id:sliderID,slide_id:theslideID};
				objButton = jQuery(this);
			
			li.find('.slide-published').fadeOut(200);
			li.find('.slide-unpublished').fadeOut(200);
			UniteAdminRev.ajaxRequest("toggle_slide_state" ,data,function(response){
		
				var currentState = response.state;

				if(currentState == 'published'){
					li.find('.slide-published').removeClass("pubclickable").fadeIn(200);
					li.find('.slide-unpublished').addClass("pubclickable").fadeIn(200);
					if(curSlideID == theslideID) jQuery('select[name="state"] option[value="published"]').attr('selected', true);
				}else{
					li.find('.slide-published').addClass("pubclickable").fadeIn(200);
					li.find('.slide-unpublished').removeClass("pubclickable").fadeIn(200);
					if(curSlideID == theslideID) jQuery('select[name="state"] option[value="unpublished"]').attr('selected', true);
				}

			});
			return false;
		});
		
		
		jQuery('body').on('click', '.slide-hero-unpublished.pubclickable', function(){
			var li = jQuery(this).closest('li'),
				ul = jQuery(this).closest('ul'),
				theslideID = li.attr("id").replace('slidelist_item_', ''),
				data = {slider_id:sliderID,slide_id:theslideID};
				objButton = jQuery(this);
			
			UniteAdminRev.ajaxRequest("toggle_hero_slide", data,function(response){
				
				ul.find('.slide-hero-published').removeClass('slide-hero-published').addClass('slide-hero-unpublished').addClass('pubclickable');
				li.find('.slide-hero-unpublished').removeClass("pubclickable").removeClass('slide-hero-unpublished').addClass('slide-hero-published');
				
			});
			return false;
		});
		
		
		jQuery('body').on('click', '.slide-duplicate', function(){
			var cont = jQuery(this).closest('li');
			var slideID = cont.attr("id").replace('slidelist_item_', '');
			var data = {slider_id:sliderID,slide_id:slideID};
			
			var objButton = jQuery(this);
			objButton.hide();
			
			var data = {slideID:slideID,sliderID:sliderID};
			UniteAdminRev.ajaxRequest("duplicate_slide_stay", data, function(response){
				objButton.show();
				
				if(response.success == true){
					var new_ele = cont.clone(true).insertAfter(cont);
					
					new_ele.attr('id', 'slidelist_item_'+response.id);
					
					if(new_ele.hasClass('selected')){ //current slide duplicated
						new_ele.removeClass('selected');
						jQuery('<a href="#" class="slide-link-toolbar-button slide-moveto"><span class=""><i class="eg-icon-forward"></i><span>'+rev_lang.copy_move+'</span></span></a>').insertAfter(new_ele.find('.slide-remove'));
					}
					
					var ahref = new_ele.find('a').first().attr('href');
					if(ahref == 'javascript:void(0)'){
						ahref = '?page=revslider&view=slide&id='+ response.id;
					}else{
						ahref = ahref.replace('id='+slideID, 'id='+response.id);
					}
					
					new_ele.find('a').first().attr('href', ahref);
					
					var num = 0;
					jQuery('.list_slide_links li').each(function(){
						jQuery(this).find('.slide-link-nr').text('#'+num);
						num++;
					});
					
				}
			});
			
		});
		
		
		jQuery('body').on('click', '.slide-moveto', function(){
			var cont = jQuery(this).closest('li');
			
			var data = {slider_id:sliderID,slide_id:slideID};
			
			var objButton = jQuery(this);

			var dialogCopy = jQuery("#dialog_copy_move");

			var textClose = dialogCopy.data("textclose");
			var textUpdate = dialogCopy.data("textupdate");
			var objButton = jQuery(this);

			var buttons = {};
			buttons[textUpdate] = function(){
				var slideID = cont.attr("id").replace('slidelist_item_', '');
				var targetSliderID = jQuery("#selectSliders").val();
				var operation = "copy";
				
				
				if(jQuery("#radio_move").prop("checked") == "checked" || jQuery("#radio_move").prop("checked") == true)
					operation = "move";
				
				var data = {slideID:slideID,
							sliderID:sliderID,
							targetSliderID:targetSliderID,
							operation:operation};

				var objLoader = objButton.siblings(".loader_copy");

				objButton.hide();

				UniteAdminRev.ajaxRequest("copy_move_slide_stay", data, function(response){
					objButton.show();
					
					if(operation == 'move'){
						cont.remove();
					}
				});
				jQuery(this).dialog("close");
			};

			jQuery("#dialog_copy_move").dialog({
				modal:true,
				resizable:false,
				width:400,
				height:300,
				closeOnEscape:true,
				dialogClass:"tpdialogs",
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
				buttons:buttons
			});	//dialog end
			
		});
		
		
		jQuery('body').on('click', '.slide-add-as-template', function(){
			
			if(confirm(rev_lang.unsaved_changes_will_not_be_added)){
				var cont = jQuery(this).closest('li');
				var title = prompt(rev_lang.please_enter_a_slide_title, cont.find('.slidetitleinput').val());
				var slider_width = jQuery('input[name="rs-grid-width"]').val();
				var slider_height = jQuery('input[name="rs-grid-height"]').val();
				var slideID = cont.attr("id").replace('slidelist_item_', '');
				
				var settings = {'width': slider_width,'height': slider_height};
				
				if (title != null) {
					var objButton = jQuery(this);
					objButton.hide();
					
					var data = {'slideID':slideID,'title':title,'settings':settings};
					
					UniteAdminRev.ajaxRequest('add_slide_to_template', data, function(response){
						objButton.show();
						
						//reload template Slider
						jQuery('#template_area').replaceWith( response.HTML );
						
						templateSelectorHandling();
					});
				}
			}
			
		});
		
		
		//quick lang change by lang icon
		jQuery("#rev_lang_list").delegate(".icon_slide_lang, .icon_slide_lang_add","click",function(event){

			event.stopPropagation()
			var pos = UniteAdminRev.getAbsolutePos(this);
			var posLeft = pos[0] - 135;
			var posTop = pos[1] - 60;

			var objIcon = jQuery(this);

			var operation = objIcon.data("operation");
			var isParent = objIcon.data("isparent");

			if(operation == "add")
				jQuery("#langs_float_wrapper .item_operation").hide();
			else{
				jQuery("#langs_float_wrapper .item_operation").show();

				if(isParent == true)
					jQuery("#langs_float_wrapper .item_operation.operation_delete").hide();
			}

			var objList = objIcon.parents(".list_slide_icons");
			filterFloatMenuByListIcons(objList,operation);

			jQuery("#langs_float_wrapper").show().css({left:posLeft,top:posTop});
			jQuery("#langs_float_wrapper").data("iconid",this.id);
		});

		jQuery("body").click(function(){
			jQuery("#langs_float_wrapper").hide();
		});

		//switch the language
		jQuery("#slides_langs_float li a").click(function(){
			var obj = jQuery(this);
			var lang = obj.data("lang");

			var iconID = jQuery("#langs_float_wrapper").data("iconid");
			if(!iconID)
				return(true);

			var objIcon = jQuery("#"+iconID);
			var objList = objIcon.parents(".list_slide_icons");

			//set operation
			var operation = obj.data("operation");

			if(operation == undefined || !operation)
				operation = objIcon.data("operation");

			if(operation == undefined || !operation)
				operation = "update";

			var currentLang = objIcon.data("lang");
			var slideID = objIcon.data("slideid");
			var realSlideID = objIcon.data("origid");

			if(currentLang == lang)
				return(true);

			//show the loader
			if(operation != "preview"){
				objIcon.siblings(".icon_lang_loader").show();
				objIcon.hide();
			}

			if(operation == "edit"){
				var urlSlide = g_patternViewSlide.replace("[slideid]",slideID);
				location.href = urlSlide;
				return(true);
			}

			if(operation == "preview"){
				openPreviewSliderDialog(sliderID);
				//openPreviewSlideDialog(slideID,false);
				return(true);
			}
			
			if(operation == 'delete' || operation == 'update') realSlideID = slideID;
			
			var data = {sliderid:sliderID,slideid:realSlideID,lang:lang,operation:operation};
			
			UniteAdminRev.ajaxRequest("slide_lang_operation", data,function(response){

				objIcon.siblings(".icon_lang_loader").hide();

				//nandle after response
				switch(response.operation){
					case "update":
						objIcon.attr("src",response.url_icon);
						objIcon.attr("title",response.title);
						objIcon.data("lang",lang);
						objIcon.show();
					break;
					case "add":
						objIcon.show();
						objIcon.parent().before(response.html);

						//hide the add icon if all langs included
						if(response.isAll == true)
							objList.find(".icon_slide_lang_add").hide();

					break;
					case "delete":
						objIcon.parent().remove();
						//show the add icon
						objList.find(".icon_slide_lang_add").show();

					break;
				}

			});

		});
		
		jQuery('.tp-moderncheckbox').each(function(){
			RevSliderSettings.onoffStatus(jQuery(this));
		});
		
		RevSliderSettings.onoffStatus(jQuery('input[name="hideslideonmobile"]'));
		RevSliderSettings.onoffStatus(jQuery('input[name="stream_do_cover"]'));
		RevSliderSettings.onoffStatus(jQuery('input[name="stream_do_cover_both"]'));
		RevSliderSettings.onoffStatus(jQuery('input[name="kenburn_effect"]'));
		RevSliderSettings.onoffStatus(jQuery('input[name="save_performance"]'));
		RevSliderSettings.onoffStatus(jQuery('input[name="video_force_cover"]'));
		RevSliderSettings.onoffStatus(jQuery('input[name="video_nextslide"]'));
		RevSliderSettings.onoffStatus(jQuery('input[name="video_allowfullscreen"]'));
		RevSliderSettings.onoffStatus(jQuery('input[name="video_force_rewind"]'));
		RevSliderSettings.onoffStatus(jQuery('input[name="video_mute"]'));
		RevSliderSettings.onoffStatus(jQuery('input[name="thumb_for_admin"]'));
		
		jQuery('#video_force_cover').change(function(){
			if(jQuery(this).is(':checked')){
				jQuery('#video_dotted_overlay_wrap').show();
			}else{
				jQuery('#video_dotted_overlay_wrap').hide();
			}
		});
		jQuery('#video_force_cover').change();
	}//init slide view


	/**
	 * open preview slide dialog
	 */
	var openPreviewSlideDialog = function(slideID,useParams){

		if(useParams === undefined)
			useParams = true;

		var rs_form = jQuery('#rs-preview-form');
		
		//set action and data
		
		var objDataPreview = { slideid:slideID };
		
		if(useParams == true){
			objDataPreview.params = RevSliderSettings.getSettingsObject("form_slide_params"),
			objDataPreview.params.slide_bg_color = jQuery("#slide_bg_color").val();
			objDataPreview.params.slide_bg_external = jQuery("#slide_bg_external").val();
			objDataPreview.params.bg_fit = jQuery("#slide_bg_fit").val();
			objDataPreview.params.bg_fit_x = jQuery("input[name='bg_fit_x']").val();
			objDataPreview.params.bg_fit_y = jQuery("input[name='bg_fit_y']").val();
			objDataPreview.params.bg_repeat = jQuery("#slide_bg_repeat").val();
			objDataPreview.params.bg_position = jQuery("#slide_bg_position").val();
			objDataPreview.params.bg_position_x = jQuery("input[name='bg_position_x']").val();
			objDataPreview.params.bg_position_y = jQuery("input[name='bg_position_y']").val();
			objDataPreview.params.bg_end_position_x = jQuery("input[name='bg_end_position_x']").val();
			objDataPreview.params.bg_end_position_y = jQuery("input[name='bg_end_position_y']").val();

			//kenburns & pan zoom
			objDataPreview.params.kenburn_effect = (jQuery("input[name='kenburn_effect']").is(':checked')) ? 'on' : 'off';
			objDataPreview.params.kb_start_fit = jQuery("input[name='kb_start_fit']").val();
			objDataPreview.params.kb_end_fit = jQuery("input[name='kb_end_fit']").val();

			objDataPreview.params.bg_end_position = jQuery("select[name='bg_end_position']").val();
			objDataPreview.params.kb_duration = jQuery("input[name='kb_duration']").val();
			objDataPreview.params.kb_easing = jQuery("select[name='kb_easing']").val();
			
			var ml = UniteLayersRev.getLayers();
			
			var arrLayersNew = {};
			for(key in ml){
				if(ml[key].layer_unavailable !== true && ml[key].deleted !== true){
					arrLayersNew[key] = jQuery.extend(true, {}, ml[key]);
					
					if(typeof(arrLayersNew[key].layer_unavailable) !== 'undefined') delete(arrLayersNew[key].layer_unavailable);
					if(typeof(arrLayersNew[key].deleted) !== 'undefined') delete(arrLayersNew[key].deleted);
					if(typeof(arrLayersNew[key].references) !== 'undefined') delete(arrLayersNew[key].references);
					if(typeof(arrLayersNew[key].createdOnInit) !== 'undefined') delete(arrLayersNew[key].createdOnInit);
				}
			}
			
			objDataPreview.layers = arrLayersNew;
		}
		
		var jsonData = JSON.stringify(objDataPreview);

		
		jQuery("#preview-slide-data").val(jsonData);
		jQuery("#rs-client-action").val('preview_slide');
		
		rs_form.submit();
		
		jQuery('#rs-preview-wrapper').show();
		
		jQuery(window).trigger('resize');
	}
	
	
	/**
	 * set slide background by type (image, solid, bg).
	 */
	var setSlideBGByType = function(bgType){
		switch(bgType){
			case "image":
				var urlImage = jQuery("#image_url").val();
				jQuery("#divbgholder").css("background-image","url('"+urlImage+"')");
				jQuery("#divbgholder").css("background-color","transparent");
				jQuery("#divbgholder").removeClass("trans_bg");
				if(jQuery('input[name="kenburn_effect"]').is(':checked')){
					jQuery('input[name="kb_start_fit"]').change();
				}
			break;
			case "trans":
				jQuery("#divbgholder").css("background-image","none");
				jQuery("#divbgholder").css("background-color","transparent");
				jQuery("#divbgholder").addClass("trans_bg");
			break;
			case "solid":
				jQuery("#divbgholder").css("background-image","none");
				jQuery("#divbgholder").removeClass("trans_bg");
				var bgColor = jQuery("#slide_bg_color").val();
				jQuery("#divbgholder").css("background-color",bgColor);
				jQuery('#slide_selector .list_slide_links li.selected .slide-media-container ').css({backgroundColor:bgColor});
			break;
			case "external":
				var urlImage = jQuery("#slide_bg_external").val();
				jQuery("#divbgholder").css("background-image","url('"+urlImage+"')");
				jQuery("#divbgholder").css("background-color","transparent");
				jQuery("#divbgholder").removeClass("trans_bg");
				if(jQuery('input[name="kenburn_effect"]').is(':checked')){
					jQuery('input[name="kb_start_fit"]').change();
				}
			break;
			case "youtube":
				var urlImage = jQuery("#image_url").val();
				jQuery('#divbgholder').css("background-image","url('"+urlImage+"')");
				jQuery('#divbgholder').css("background-color","transparent");
				jQuery('#divbgholder').removeClass("trans_bg");
				
			break;
			case "html5":
				var urlImage = jQuery("#image_url").val();
				jQuery("#divbgholder").css("background-image","url('"+urlImage+"')");
				jQuery("#divbgholder").css("background-color","transparent");
				jQuery("#divbgholder").removeClass("trans_bg");
			break;
		}

	}

	var getSlideBgSettings = function(){
		var retParams = new Object;

		retParams['bg_fit'] = jQuery('#slide_bg_fit').val();
		if(retParams['bg_fit'] == 'percentage'){
			retParams['bg_fit_x'] = jQuery('input[name="bg_fit_x"]').val();
			retParams['bg_fit_y'] = jQuery('input[name="bg_fit_y"]').val();
		}

		retParams['bg_position'] = jQuery('#slide_bg_position').val();
		if(retParams['bg_position'] == 'percentage'){
			retParams['bg_position_x'] = jQuery('input[name="bg_position_x"]').val();
			retParams['bg_position_y'] = jQuery('input[name="bg_position_y"]').val();
		}

		retParams['bg_end_position'] = jQuery('#slide_bg_end_position').val();
		if(retParams['bg_end_position'] == 'percentage'){
			retParams['bg_end_position_x'] = jQuery('input[name="bg_end_position_x"]').val();
			retParams['bg_end_position_y'] = jQuery('input[name="bg_end_position_y"]').val();
		}

		retParams['bg_repeat'] = jQuery('#slide_bg_repeat').val();

		return retParams;
	}


	/**
	 * global style part
	 */

	var g_codemirrorCssDynamic = null;
	var g_codemirrorCssStatic = null;
	var staticStyles = null;
	var urlStaticCssCaptions = null;

	/**
	 * set static captions url for refreshing when needed
	 */
	t.setStaticCssCaptionsUrl = function(url){
		urlStaticCssCaptions = url;
	}

	/**
	 * get static captions url for refreshing when needed
	 */
	t.getUrlStaticCssCaptions = function(){
		return urlStaticCssCaptions;
	}

	t.initGlobalStyles = function(){
		initGlobalCssAccordion();
		initGlobalCssEditor();
	}

	t.setCodeMirrorStaticEditor = function(){
		g_codemirrorCssStatic = CodeMirror.fromTextArea(document.getElementById("textarea_edit_static"), { lineNumbers: true });
	}

	t.setCodeMirrorDynamicEditor = function(){
		g_codemirrorCssDynamic = CodeMirror.fromTextArea(document.getElementById("textarea_show_dynamic_styles"), {
			lineNumbers: true,
			readOnly: true
		});
	}

	var initGlobalCssAccordion = function(){
		jQuery("#css-static-accordion").accordion({
			heightStyle: "content",
			activate: function(event, ui){
				if(g_codemirrorCssStatic != null) g_codemirrorCssStatic.refresh();
				if(g_codemirrorCssDynamic != null) g_codemirrorCssDynamic.refresh();
			}
		});
	}

	var initGlobalCssEditor = function(){

		jQuery('#button_edit_css_global').click(function(){
			//if(!UniteLayersRev.getLayerGeneralParamsStatus()) return false; //false if fields are disabled

			jQuery("#css-static-accordion").accordion({ active: 1 });

			UniteAdminRev.ajaxRequest("get_static_css","",function(response){
				var cssData = response.data;

				if(g_codemirrorCssStatic != null)
					g_codemirrorCssStatic.setValue(cssData);
				else{
					jQuery("#textarea_edit_static").val(cssData);
					setTimeout('RevSliderAdmin.setCodeMirrorStaticEditor()',500);
				}
			});

			UniteAdminRev.ajaxRequest("get_dynamic_css","",function(response){
				var cssData = response.data;

				if(g_codemirrorCssDynamic != null)
					g_codemirrorCssDynamic.setValue(cssData);
				else{
					jQuery("#textarea_show_dynamic_styles").val(cssData);
					setTimeout('RevSliderAdmin.setCodeMirrorDynamicEditor()',500);
				}
			});

			jQuery("#css_static_editor_wrap").dialog({
				modal:true,
				resizable:false,
				title:rev_lang.global_styles_editor,
				minWidth:700,
				minHeight:500,
				closeOnEscape:true,
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
				open:function () {
					jQuery(this).closest(".ui-dialog")
					.find(".ui-button").each(function(i) {
					   var cl;
					   if (i==0) cl="revgray";
					   if (i==1) cl="revgreen";
					   if (i==2) cl="revred";
					   jQuery(this).addClass(cl).addClass("button-primary").addClass("rev-uibuttons");
				   })
				},
				buttons:{
					Save:function(){
						if(!confirm(rev_lang.really_update_global_styles)){
							return false;
						}

						UniteAdminRev.setErrorMessageID("dialog_error_message");
						var data;
						if(g_codemirrorCssStatic != null)
							data = g_codemirrorCssStatic.getValue();
						else
							data = jQuery("#textarea_edit_static").val();

						UniteAdminRev.ajaxRequest("update_static_css",data,function(response){
							if(g_codemirrorCssStatic != null)
								g_codemirrorCssStatic.setValue(response.css);
							else
								jQuery("#textarea_edit_static").val(css);

						});

						//if(urlStaticCssCaptions)
						//	setTimeout('UniteAdminRev.loadCssFile(RevSliderAdmin.getUrlStaticCssCaptions(),"rs-plugin-static-css");',1000);

						jQuery(this).dialog("close");
					},
					"Cancel":function(){
						jQuery(this).dialog("close");
					}
				}
			});
		});
	}

}
