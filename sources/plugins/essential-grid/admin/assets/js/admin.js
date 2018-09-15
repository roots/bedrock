/*****
 * TP: CHUNK -> lower memory usage & allow more entries for custom grids (experimental and disabled for now) -> Missing Save Part
 ****/

var AdminEssentials = new function(){

	var t = this;

	var esgAnimmatrix = null;

	var ajaxLoaderClass = null;
	var ajaxLoaderTempHTML = null;

	var all_pages  = [];
	var mapping = {};

	var espprevrevapi,skinpreviewselector, skinpreviewselector2;
	var eg_codemirror_navigation_css = null;
	var eg_codemirror_navigation_css_default_skin = [];
	var eg_codemirror_api_js = null;
	var eg_codemirror_ajax_css = null;

	/*******************************
	 * META BOX PART
	 *******************************/

	var arr_meta_keys = []
	var init_skins = {};
	var init_elements = {};
	var init_styles = {};
	var init_custom = {};


	/**
	 * set init skins object (from db)
	 */
	t.setInitSkinsJson = function(json_skins){
		init_skins = jQuery.parseJSON(json_skins);
	}

	/**
	 * set init elements object (from post)
	 */
	t.setInitElementsJson = function(json_elements){
		init_elements = jQuery.parseJSON(json_elements);
	}

	/**
	 * set init elements object (from post)
	 */
	t.setInitStylingJson = function(json_styles){
		init_styles = jQuery.parseJSON(json_styles);
	}

	/**
	 * set init custom elements
	 */
	t.setInitCustomJson = function(json_custom){
		init_custom = jQuery.parseJSON(json_custom);
	}


	/**
	 * set init meta keys
	 */
	t.setInitMetaKeysJson = function(json_meta){
		arr_meta_keys = jQuery.parseJSON(json_meta);
		/*json_meta_keys = jQuery.parseJSON(json_meta);
		for (meta in json_meta_keys){
			arr_meta_keys.push(meta);
		}*/
	}

	t.initMetaBox = function(){

		jQuery('#eg-add-custom-meta-field').click(function(){
			t.add_meta_element();
		});

		jQuery('body').on('click', '.eg-remove-custom-meta-field', function(){
			jQuery(this).parent().remove();
		});

		jQuery('body').on('change', '.eg-custom-meta-skin', function(){
			var sel = jQuery(this).val();
			var item_sel = jQuery(this).parent().children('.eg-custom-meta-element');
			var elements = '';

			for(var key in init_skins[sel].layers){
				elements += '<option value="'+init_skins[sel].layers[key]+'">eg-'+init_skins[sel].handle+'-element-'+init_skins[sel].layers[key]+'</option>';
			}

			//add other elements here
			elements += '<option value="layout">'+eg_lang.layout_settings+'</option>';

			item_sel.html(elements);
		});


		jQuery('body').on('change', '.eg-custom-meta-element', function(){
			var sel = jQuery(this).val();
			var settings = '';

			if(sel == 'layout'){ //put layout in select
				for(var key in init_styles){
					if(init_styles[key]['container'] == 'layout'){
						settings += '<option value="'+init_styles[key].name.handle+'">'+init_styles[key].name.text+'</option>';
						if(typeof init_styles[key].hover !== 'undefined' && init_styles[key].hover == 'true')
							settings += '<option value="'+init_styles[key].name.handle+'-hover">'+init_styles[key].name.text+':hover</option>';
					}
				}
			}else{ //insert style / anim things in select
				for(var key in init_styles){
					if(init_styles[key]['container'] == 'style' || init_styles[key]['container'] == 'anim'){
						settings += '<option value="'+init_styles[key].name.handle+'">'+init_styles[key].name.text+'</option>';
						if(typeof init_styles[key].hover !== 'undefined' && init_styles[key].hover == 'true')
							settings += '<option value="'+init_styles[key].name.handle+'-hover">'+init_styles[key].name.text+':hover</option>';
					}
				}
			}

			jQuery(this).siblings('.eg-custom-meta-setting').html(settings);
		});


		
										

		jQuery('body').on('change', '.eg-custom-meta-setting', function(){
			var sett = jQuery(this).val();
			var hover = false;
			if(sett.indexOf('-hover') >= 0){
				sett = sett.replace('-hover', '');
				hover = true;
			}

			for(var key in init_styles){
				if(init_styles[key].name.handle == sett){
					var sb_data = jQuery(this).siblings('.eg-custom-meta-style').data('eltype');

					switch(init_styles[key].type){
						case 'color':
							var cur_val = jQuery(this).siblings('.eg-custom-meta-style').val();
							jQuery(this).siblings('.eg-custom-meta-style, .wp-picker-container').remove();
							jQuery(this).parent().append('<input class="eg-custom-meta-style" data-eltype="color" type="text" name="eg-custom-meta-style[]" value="'+init_styles[key]['default']+'" data-default-color="'+init_styles[key]['default']+'">');
							jQuery(this).siblings('.eg-custom-meta-style').wpColorPicker({color:true});
							if(sb_data == 'color')
								jQuery(this).siblings('.eg-custom-meta-style').wpColorPicker('color', cur_val);
						break;
						case 'select':
							var cur_val = jQuery(this).siblings('.eg-custom-meta-style option:selected').val();
							jQuery(this).siblings('.eg-custom-meta-style, .wp-picker-container').remove();
							jQuery(this).parent().append('<select class="eg-custom-meta-style" data-eltype="select" name="eg-custom-meta-style[]"></select>');

							for(var opt in init_styles[key]['values']){
								jQuery(this).siblings('.eg-custom-meta-style').append('<option value="'+opt+'">'+init_styles[key]['values'][opt]+'</option>');
							}

							jQuery(this).siblings('.eg-custom-meta-style option[value="'+init_styles[key]['default']+'"]').attr('selected', 'selected');

							if(sb_data == 'select')
								jQuery(this).siblings('.eg-custom-meta-style option[value="'+cur_val+'"]').attr('selected', 'selected');
						break;
						case 'number':
							var cur_val = jQuery(this).siblings('.eg-custom-meta-style').val();
							jQuery(this).siblings('.eg-custom-meta-style, .wp-picker-container').remove();
							jQuery(this).parent().append('<input class="eg-custom-meta-style" type="number" data-eltype="number" name="eg-custom-meta-style[]" value="'+init_styles[key]['default']+'">');

							if(sb_data == 'number')
								jQuery(this).siblings('.eg-custom-meta-style').val(cur_val);
						break;
						case 'text':
						default:
							var cur_val = jQuery(this).siblings('.eg-custom-meta-style').val();
							jQuery(this).siblings('.eg-custom-meta-style, .wp-picker-container').remove();
							jQuery(this).parent().append('<input class="eg-custom-meta-style" type="text" data-eltype="text" name="eg-custom-meta-style[]" value="'+init_styles[key]['default']+'">');

							if(sb_data == 'text')
								jQuery(this).siblings('.eg-custom-meta-style').val(cur_val);
						break;
					}
					break;
				}
			}

		});


		for(var key in init_elements){
			t.add_meta_element(init_elements[key]);
		}

	}


	t.initCustomMeta = function(){

		jQuery('#eg-meta-add').click(function(){
			jQuery('#custom-meta-dialog-wrap').dialog({
				modal:true,
				draggable:false,
				resizable:false,
				width:340,
				height:560,
				closeOnEscape:true,
				dialogClass:'wp-dialog',
				buttons: [ { text: eg_lang.add_meta, click: function() {
					var data = {};

					data.handle = t.sanitize_input(jQuery('input[name="eg-custom-meta-handle"]').val());
					data.name = jQuery('input[name="eg-custom-meta-name"]').val();
					data['default'] = jQuery('input[name="eg-custom-meta-default"]').val();
					data.type = jQuery('select[name="eg-custom-meta-type"] option:selected').val();
					data['sort-type'] = jQuery('select[name="eg-custom-meta-sort-type"] option:selected').val();
					data.sel = false;

					jQuery('input[name="eg-custom-meta-handle"]').val(data.handle);

					if(data.type == 'select' || data.type == 'multi-select')
						data.sel = jQuery('textarea[name="eg-custom-meta-select"]').val();

					if(data.handle.length < 3 || data.name.length < 3){
						alert(eg_lang.handle_and_name_at_least_3);
						return false;
					}

					AdminEssentials.ajaxRequest("add_custom_meta", data, '#eg-meta-add',function(response){});

				} } ],
			});
		});


		jQuery('body').on('click', '.eg-meta-edit', function(){
			if(confirm(eg_lang.really_change_meta_effects)){
				var data = {};
				var el = jQuery(this);
				data.handle = el.closest('.inside').find('input[name="esg-meta-handle[]"]').val();
				data.name = el.closest('.inside').find('input[name="esg-meta-name[]"]').val();
				data['default'] = el.closest('.inside').find('input[name="esg-meta-default[]"]').val();
				data.sel = el.closest('.inside').find('textarea[name="esg-meta-select[]"]').val();

				AdminEssentials.ajaxRequest("edit_custom_meta", data, '#eg-meta-add, .eg-meta-edit, .eg-meta-delete',function(response){});
			}

		});


		jQuery('body').on('click', '.eg-meta-delete', function(){
			if(confirm(eg_lang.really_delete_meta)){
				var data = {};
				var el = jQuery(this);

				data.handle = el.closest('.inside').find('input[name="esg-meta-handle[]"]').val();

				AdminEssentials.ajaxRequest("remove_custom_meta", data, '#eg-meta-add, .eg-meta-edit, .eg-meta-delete',function(response){
					if(response.success == true){
						el.closest('.postbox.eg-postbox').remove();
					}
				});
			}
		});


		jQuery('select[name="eg-custom-meta-type"]').change(function(){
			if(jQuery(this).val() == 'select' || jQuery(this).val() == 'multi-select'){
				jQuery('#eg-custom-meta-select-wrap').show();
			}else{
				jQuery('#eg-custom-meta-select-wrap').hide();
			}
		});



		jQuery('#eg-link-meta-add').click(function(){
			jQuery('#link-meta-dialog-wrap').dialog({
				modal:true,
				draggable:false,
				resizable:false,
				width:320,
				height:380,
				closeOnEscape:true,
				dialogClass:'wp-dialog',
				buttons: [ { text: eg_lang.add_meta, click: function() {
					var data = {};

					data.handle = t.sanitize_input(jQuery('input[name="eg-link-meta-handle"]').val());
					data.name = jQuery('input[name="eg-link-meta-name"]').val();
					data.original = t.sanitize_input(jQuery('input[name="eg-link-meta-original"]').val());
					data['sort-type'] = jQuery('select[name="eg-link-meta-sort-type"] option:selected').val();

					jQuery('input[name="eg-link-meta-handle"]').val(data.handle);
					jQuery('input[name="eg-link-meta-original"]').val(data.original);

					if(data.handle.length < 3 || data.name.length < 3 || data.original.length < 3){
						alert(eg_lang.handle_and_name_at_least_3);
						return false;
					}

					AdminEssentials.ajaxRequest("add_link_meta", data, '#eg-link-meta-add',function(response){});

				} } ],
			});
		});


		jQuery('body').on('click', '.eg-link-meta-edit', function(){
			if(confirm(eg_lang.really_change_meta_effects)){
				var data = {};
				var el = jQuery(this);
				data.handle = el.closest('.inside').find('input[name="esg-link-meta-handle[]"]').val();
				data.name = el.closest('.inside').find('input[name="esg-link-meta-name[]"]').val();
				data.original = el.closest('.inside').find('input[name="esg-link-meta-original[]"]').val();

				AdminEssentials.ajaxRequest("edit_link_meta", data, '#eg-link-meta-add, .eg-link-meta-edit, .eg-link-meta-delete',function(response){});
			}

		});


		jQuery('body').on('click', '.eg-link-meta-delete', function(){
			if(confirm(eg_lang.really_delete_meta)){
				var data = {};
				var el = jQuery(this);

				data.handle = el.closest('.inside').find('input[name="esg-link-meta-handle[]"]').val();

				AdminEssentials.ajaxRequest("remove_link_meta", data, '#eg-link-meta-add, .eg-link-meta-edit, .eg-link-meta-delete',function(response){
					if(response.success == true){
						el.closest('.postbox.eg-postbox').remove();
					}
				});
			}
		});

		jQuery('#eg-grid-custom-meta-wrapper').tabs();

		jQuery('.eg-custom-meta-info-box').click(function() {
			if (jQuery(this).hasClass("show")) {
				jQuery(this).find('.eg-custom-meta-toggle-visible').slideUp(200);
				jQuery(this).removeClass("show");
			} else {
				jQuery(this).find('.eg-custom-meta-toggle-visible').slideDown(200);
				jQuery(this).addClass("show");

			}
		});
	}

	t.add_meta_element = function(entry){
		var skins = '';
		for(var key in init_skins){
			skins += '<option value="'+key+'">'+init_skins[key].name+'</option>';
		}

		jQuery('#eg-advanced-param').append('<div class="eg-custom-meta-setting-wrap">'+
												'<a class="button-primary eg-remove-custom-meta-field" href="javascript:void(0);">-</a>'+
												'<select class="eg-custom-meta-skin" name="eg-custom-meta-skin[]">'+skins+'</select>'+
												'<select class="eg-custom-meta-element" name="eg-custom-meta-element[]"></select>'+
												'<select class="eg-custom-meta-setting" name="eg-custom-meta-setting[]"></select>'+
											'</div>');

		if(typeof entry !== undefined && typeof entry !== 'undefined'){

			jQuery('.eg-custom-meta-skin').last().find('option[value="'+entry['skin']+'"]').attr("selected","selected");
			jQuery('.eg-custom-meta-skin').last().change();

			//before inserting the value, create the field depending on what is selected
			jQuery('.eg-custom-meta-element').last().find('option[value="'+entry['element']+'"]').attr("selected","selected");
			jQuery('.eg-custom-meta-element').last().change();

			jQuery('.eg-custom-meta-setting').last().find('option[value="'+entry['setting']+'"]').attr("selected","selected");
			jQuery('.eg-custom-meta-setting').last().change();

			//check if skin, element and setting still exists
			if(	jQuery('.eg-custom-meta-skin option[value="'+entry['skin']+'"]').last().length == 0 ||
				jQuery('.eg-custom-meta-element option[value="'+entry['element']+'"]').last().length == 0 ||
				jQuery('.eg-custom-meta-setting option[value="'+entry['setting']+'"]').last().length == 0 ){
					jQuery('.eg-custom-meta-setting-wrap').last().remove();
					return false;
				}


			//check what the element is now, and add the value to it
			var sb = jQuery('.eg-custom-meta-style').last();
			var sb_data = sb.data('eltype');

			switch(sb_data){
				case 'color':
					sb.wpColorPicker('color', entry['style']);
				break;
				case 'select':
					sb.find('option[value="'+entry['style']+'"]').attr('selected', 'selected');
				break;
				case 'number':
				case 'text':
				default:
					sb.val(entry['style']);
				break;
			}

		}else{
			jQuery('.eg-custom-meta-skin').last().change();
			jQuery('.eg-custom-meta-element').last().change();
			jQuery('.eg-custom-meta-setting').last().change();
		}

	}

	/**
	 * handles widget areas page
	 * since 1.0.6
	 */

	t.initWidgetAreas = function(){
		jQuery('#eg-widget-area-add').click(function(){
			jQuery('#widget-areas-dialog-wrap').dialog({
				modal:true,
				draggable:false,
				resizable:false,
				width:300,
				height:340,
				closeOnEscape:true,
				dialogClass:'wp-dialog',
				buttons: [ { text: eg_lang.add_widget_area, click: function() {
					var data = {};

					data.handle = t.sanitize_input(jQuery('input[name="eg-widget-area-handle"]').val());
					data.name = jQuery('input[name="eg-widget-area-name"]').val();

					jQuery('input[name="eg-widget-area-handle"]').val(data.handle);

					if(data.handle.length < 3 || data.name.length < 3){
						alert(eg_lang.handle_and_name_at_least_3);
						return false;
					}

					AdminEssentials.ajaxRequest("add_widget_area", data, '.ui-button',function(response){});

				} } ],
			});
		});


		jQuery('body').on('click', '.eg-widget-area-edit', function(){
			if(confirm(eg_lang.really_change_widget_area_name)){
				var data = {};
				var el = jQuery(this);
				data.handle = el.closest('.inside').find('input[name="esg-widget-area-handle[]"]').val();
				data.name = el.closest('.inside').find('input[name="esg-widget-area-name[]"]').val();

				AdminEssentials.ajaxRequest("edit_widget_area", data, '#eg-widget-area-add, .eg-widget-area-edit, .eg-widget-area-delete',function(response){});
			}

		});


		jQuery('body').on('click', '.eg-widget-area-delete', function(){
			if(confirm(eg_lang.really_delete_widget_area)){
				var data = {};
				var el = jQuery(this);

				data.handle = el.closest('.inside').find('input[name="esg-widget-area-handle[]"]').val();

				AdminEssentials.ajaxRequest("remove_widget_area", data, '#eg-widget-area-add, .eg-widget-area-edit, .eg-widget-area-delete',function(response){
					if(response.success == true){
						el.closest('.postbox.eg-postbox').remove();
					}
				});
			}
		});

	}

	t.initGoogleFonts = function(){

		jQuery('#eg-font-add').click(function(){
			jQuery('#font-dialog-wrap').dialog({
				modal:true,
				draggable:false,
				resizable:false,
				width:470,
				height:320,
				closeOnEscape:true,
				dialogClass:'wp-dialog',
				buttons: [ { text: eg_lang.add_font, click: function() {
					var data = {};

					data.handle = t.sanitize_input(jQuery('input[name="eg-font-handle"]').val());
					data['url'] = jQuery('input[name="eg-font-url"]').val();

					if(data.handle.length < 3 || data.url.length < 3){
						alert(eg_lang.handle_and_name_at_least_3);
						return false;
					}

					AdminEssentials.ajaxRequest("add_google_fonts", data, '#eg-font-add',function(response){});

				} } ],
			});
		});


		jQuery('body').on('click', '.eg-font-edit', function(){
			if(confirm(eg_lang.really_change_font_effects)){
				var data = {};
				var el = jQuery(this);
				data.handle = el.closest('.inside').find('input[name="esg-font-handle[]"]').val();
				data['url'] = el.closest('.inside').find('input[name="esg-font-url[]"]').val();

				AdminEssentials.ajaxRequest("edit_google_fonts", data, '#eg-font-add, .eg-font-edit, .eg-font-delete',function(response){});
			}

		});


		jQuery('body').on('click', '.eg-font-delete', function(){
			if(confirm(eg_lang.really_delete_meta)){
				var data = {};
				var el = jQuery(this);

				data.handle = el.closest('.inside').find('input[name="esg-font-handle[]"]').val();

				AdminEssentials.ajaxRequest("remove_google_fonts", data, '#eg-font-add, .eg-font-edit, .eg-font-delete',function(response){
					if(response.success == true){
						el.closest('.postbox.eg-postbox').remove();
					}
				});
			}
		});

	}

	/**
	 * Init Search Settings
	 * @since: 2.0
	 */
	t.initSearchSettings = function(){

		jQuery('#eg-btn-save-settings').click(function(){
			var data = {};

			data.global = t.getFormParams('esg-search-global-settings');
			data.shortcode = t.getFormParams('esg-search-shortcode-settings');
			data.settings = {}
			data.settings['search-enable'] = jQuery('input[name="search-enable"]:checked').val();

			AdminEssentials.ajaxRequest("save_search_settings", data, '#eg-btn-save-settings',function(response){});
		});

		jQuery('body').on('click', '.eg-btn-remove-setting', function(){
			jQuery(this).closest('.postbox').remove();
		});

		jQuery('input[name="search-enable"]').click(function(){
			if(jQuery(this).val() == 'on')
				jQuery('#esg-search-global-settings').show();
			else
				jQuery('#esg-search-global-settings').hide();

		});
		jQuery('input[name="search-enable"]:checked').click();


		jQuery('#eg-btn-add-global-setting').click(function(){
			t.append_global_setting( {} );
			t.initAccordion();
		});

		jQuery('#eg-btn-add-shortcode-setting').click(function(){
			t.append_shortcode_setting( {} );
			t.initAccordion();
		});


		jQuery('body').on('keyup', 'input[name="search-class[]"]', function(){
			jQuery(this).closest('.postbox').find('.search-title').text(jQuery(this).val());
		});


		jQuery('#eg-grid-search-wrapper').tabs();

		jQuery('.eg-search-settings-info-box').click(function() {
			if (jQuery(this).hasClass("show")) {
				jQuery(this).find('.eg-search-settings-toggle-visible').slideUp(200);
				jQuery(this).removeClass("show");
			} else {
				jQuery(this).find('.eg-search-settings-toggle-visible').slideDown(200);
				jQuery(this).addClass("show");
			}
		});


		t.append_global_setting = function(data){
			var content = global_settings_template(data);
			jQuery('.eg-global-search-wrap').append(content);
		}

		t.append_shortcode_setting = function(data){
			var content = shortcode_settings_template(data);
			jQuery('.eg-shortcode-search-wrap').append(content);
		}

		var global_settings_template = wp.template( "esg-global-settings-wrap" );
		var shortcode_settings_template = wp.template( "esg-shortcode-settings-wrap" );
		var data = global_settings;

		if(typeof(data.global) !== 'undefined' && typeof(data.global['search-class']) !== 'undefined'){
			for(var i = 0; i<data.global['search-class'].length;i++){
				var init_data = {};
				for(var key in data.global){
					init_data[key] = data.global[key][i];
				}

				t.append_global_setting(init_data);
			}
		}

		if(typeof(data.shortcode) !== 'undefined' && typeof(data.shortcode['sc-grid-id']) !== 'undefined'){
			for(var i = 0; i<data.shortcode['sc-grid-id'].length;i++){
				var init_data = {};
				for(var key in data.shortcode){
					init_data[key] = data.shortcode[key][i];
				}

				t.append_shortcode_setting(init_data);
			}
		}



		jQuery('body').on('change', '#eg-shortcode-search-wrap select, #eg-shortcode-search-wrap input', function(){
			jQuery(this).closest('.postbox').find('input[name="sc-shortcode[]"]').val('[ess_grid_search handle="'+jQuery(this).closest('.postbox').find('input[name="sc-handle[]"]').val()+'"]');
		});
		jQuery('#eg-shortcode-search-wrap select, #eg-shortcode-search-wrap input').each(function(){
			jQuery(this).find('option:selected').change();
		});

		jQuery('input[name="sc-shortcode[]"]').click(function(){
			this.select();
		});
	}


	/*******************************
	 *	- SHOW INFO AND HIDE INFO -
	 *******************************/

	t.showInfo = function(obj) {

		if(typeof(punchgs) === 'undefined') return true;

		var info = '<i class="eg-icon-info"></i>';
		if (obj.type=="warning") info = '<i class="eg-icon-cancel"></i>';
		if (obj.type=="success") info = '<i class="eg-icon-ok"></i>';

		obj.showdelay = obj.showdelay != undefined ? obj.showdelay : 0;
		obj.hidedelay = obj.hidedelay != undefined ? obj.hidedelay : 0;

		// CHECK IF THE TOOLBOX WRAPPER EXIST ALREADY
		if (jQuery('#eg-toolbox-wrapper').length==0) jQuery('#eg-wrap').append('<div id="eg-toolbox-wrapper"></div>');

		// ADD NEW INFO BOX
		jQuery('#eg-toolbox-wrapper').append('<div class="eg-toolbox newadded">'+info+obj.content+'</div>');
		var nt = jQuery('#eg-toolbox-wrapper').find('.eg-toolbox.newadded');
		nt.removeClass('newadded');


		// ANIMATE THE INFO BOX
		punchgs.TweenLite.fromTo(nt,0.5,{y:-50,autoAlpha:0,transformOrigin:"50% 50%", transformPerspective:900, rotationX:-90},{autoAlpha:1,y:0,rotationX:0,ease:punchgs.Back.easeOut,delay:obj.showdelay});

		if (obj.hideon != "event") {
			nt.click(function() {
				punchgs.TweenLite.to(nt,0.3,{x:200,ease:punchgs.Power3.easeInOut,autoAlpha:0,onComplete:function() {nt.remove()}});
			})

			if (obj.hidedelay !=0 && obj.hideon!="click")
				punchgs.TweenLite.to(nt,0.3,{x:200,ease:punchgs.Power3.easeInOut,autoAlpha:0,delay:obj.hidedelay + obj.showdelay, onComplete:function() {nt.remove()}});
		} else  {
			jQuery('#eg-toolbox-wrapper').on(obj.event,function() {
				punchgs.TweenLite.to(nt,0.3,{x:200,ease:punchgs.Power3.easeInOut,autoAlpha:0,onComplete:function() {nt.remove()}});
			});
		}
	}


	/**
	 * escape html, turn html to a string
	 */
	t.htmlspecialchars = function(string){
		  return string
		      .replace(/&/g, "&amp;")
		      .replace(/</g, "&lt;")
		      .replace(/>/g, "&gt;")
		      .replace(/"/g, "&quot;")
		      .replace(/'/g, "&#039;");
	}

	/**
	 * turn string value ("true", "false") to string
	 */
	t.strToBool = function(str){

		if(str == undefined)
			return(false);

		if(typeof(str) != "string")
			return(false);

		str = str.toLowerCase();

		var bool = (str == "true")?true:false;
		return(bool);
	}

	/**
	 * strip html tags
	 */
	t.stripTags = function(input, allowed) {
	    allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
	    var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
	        commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
	    return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
	        return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
	    });
	}


	/**
	 * Strip slashes
	 * since 1.0.2
	 */
	t.stripslashes = function(str) {
	//       discuss at: http://phpjs.org/functions/stripslashes/
	//      original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	//      improved by: Ates Goral (http://magnetiq.com)
	//      improved by: marrtins
	//      improved by: rezna
	//         fixed by: Mick@el
	//      bugfixed by: Onno Marsman
	//      bugfixed by: Brett Zamir (http://brett-zamir.me)
	//         input by: Rick Waldron
	//         input by: Brant Messenger (http://www.brantmessenger.com/)
	// reimplemented by: Brett Zamir (http://brett-zamir.me)
	//        example 1: stripslashes('Kevin\'s code');
	//        returns 1: "Kevin's code"
	//        example 2: stripslashes('Kevin\\\'s code');
	//        returns 2: "Kevin\'s code"

	return (str + '')
		.replace(/\\(.?)/g, function(s, n1) {
		  switch (n1) {
			case '\\':
			  return '\\';
			case '0':
			  return '\u0000';
			case '':
			  return '';
			default:
			  return n1;
		  }
		});
	}


    /**
	 * change hex to rgb
	 */
    t.hex_to_rgba = function(hex, transparency, format){
        if(typeof transparency !== 'undefined'){
            transparency = (transparency > 0) ? transparency / 100 : 0;
        }else{
            transparency = 1;
        }

        // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
        var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
        hex = hex.replace(shorthandRegex, function(m, r, g, b) {
            return r + r + g + g + b + b;
        });

        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);

        if(typeof format !== 'undefined'){
            if(result){
                return 'rgba('+parseInt(result[1], 16)+', '+parseInt(result[2], 16)+', '+parseInt(result[3], 16)+', '+transparency+')';
            }else{
                return null;
            }
        }else{
            return result ? {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16),
                a: transparency
            } : null;
        }
    }


	t.upload_image_img = function(id){
		var custom_uploader;

		if (custom_uploader) {
			custom_uploader.open();
			return;
		}

		//Extend the wp.media object
		custom_uploader = wp.media.frames.file_frame = wp.media({
			title: eg_lang.choose_image,
			button: {
				text: eg_lang.choose_image
			},
			multiple: false
		});

		//When a file is selected, grab the URL and set it as the text field's value
		custom_uploader.on('select', function() {
			attachment = custom_uploader.state().get('selection').first().toJSON();

			jQuery('#'+id).val(attachment.id);
			jQuery('#'+id+'-img').attr('src', attachment.url);
			jQuery('#'+id+'-img').show();
			
			if(id == 'esg-custom-image'){
				jQuery('.eg-elset-row').find('input[name="title"]').val(attachment.title);
				jQuery('.eg-elset-row').find('input[name="excerpt"]').val(attachment.description);
				jQuery('.eg-elset-row').find('input[name="content"]').val(attachment.description);
			}
			//custom_uploader.close();
		});

		//Open the uploader dialog
		custom_uploader.open();
	}

	t.upload_image_bg = function(id){
		var custom_uploader;

		if (custom_uploader) {
			custom_uploader.open();
			return;
		}

		//Extend the wp.media object
		custom_uploader = wp.media.frames.file_frame = wp.media({
			title: eg_lang.choose_image,
			button: {
				text: eg_lang.choose_image
			},
			multiple: false
		});

		//When a file is selected, grab the URL and set it as the text field's value
		custom_uploader.on('select', function() {
			attachment = custom_uploader.state().get('selection').first().toJSON();

			jQuery('#'+id).val(attachment.id);
			jQuery('#'+id+'-wrapper').css('background', 'url('+attachment.url+')');
			//custom_uploader.close();
		});

		//Open the uploader dialog
		custom_uploader.open();
	}

	t.add_custom_grid_multiple_images = function(id){
		var custom_uploader;

		if (custom_uploader) {
			custom_uploader.open();
			return;
		}

		//Extend the wp.media object
		custom_uploader = wp.media.frames.file_frame = wp.media({
			title: eg_lang.choose_images,
			button: {
				text: eg_lang.choose_images
			},
			multiple: true
		});

		//When a file is selected, grab the URL and set it as the text field's value
		custom_uploader.on('select', function() {

			custom_uploader.state().get('selection').each(function(sel_image){
				var curimg = sel_image.toJSON();
				
				if(typeof curimg !== 'undefined' && typeof curimg.id !== 'undefined' && parseInt(curimg.id) > 0){
					t.reset_custom_dialog();
					t.remove_hightlighting();
					
					jQuery('#esg-custom-image').val(curimg.id);
					
					jQuery('.eg-elset-row').find('input[name="title"]').val(curimg.title);
					jQuery('.eg-elset-row').find('input[name="excerpt"]').val(curimg.description);
					jQuery('.eg-elset-row').find('input[name="content"]').val(curimg.description);
					
					var new_data = JSON.stringify(t.getFormParams('edit-custom-element-form')); //get set data
					
					jQuery('#esg-preview-wrapping-wrapper').prepend('<input id="eg-new-temp-layer" class="esg-new-temp-layer" name="layers[]" type="hidden" values="" />');
					jQuery('#eg-new-temp-layer').val(new_data);

				}
			});

			t.changePreviewGrid(true);

		});

		//Open the uploader dialog
		custom_uploader.open();
	}


	t.getFormParams = function(formID, ignore_empty){
		var obj = new Object();
		var form = document.getElementById(formID);
		var name,value,type,flagUpdate;

		//enabling all form items connected to mx
		var len = form.elements.length;
		for(var i=0; i<len; i++){
			var element = form.elements[i];

			name = element.name;
			value = element.value;

			type = element.type;
			if(jQuery(element).hasClass("wp-editor-area"))
				type = "editor";

			flagUpdate = true;

			switch(type){
				case "checkbox":
					if(form.elements[i].className.indexOf('eg-get-val') !== -1){
						if(form.elements[i].checked){
							value = form.elements[i].value;
						}else{
							continue;
						}
					}else{
						value = form.elements[i].checked;
					}
				break;
				case "radio":
					if(form.elements[i].className.indexOf('eg-get-val') !== -1){
						if(form.elements[i].checked){
							value = form.elements[i].value;
						}else{
							continue;
						}
					}else{
						if(form.elements[i].checked == false)
							flagUpdate = false;
					}
				break;
				case "editor":
					if(typeof(tiynMCE) !== 'undefined' && tinyMCE.get(name) != null){
						value = tinyMCE.get(name).getContent();
					}
				break;
				case "select-multiple":
					value = jQuery(element).val();
					if(value)
						value = value.toString();
				break;
			}

			if(flagUpdate == true && name != undefined){
				if(typeof ignore_empty !== 'undefined'){ //remove empty values from string that first needs to be json to obj
					if(value != ''){
						try{
							var json_array  = jQuery.parseJSON(value);
						}catch(e){
							try{
								value = t.stripslashes(value);
								var json_array = jQuery.parseJSON(value);
							}catch(e){
								continue; //invalid json
							}
						}

						if(typeof json_array == 'object'){

							for(var key in json_array){
								if(json_array[key] == '') delete(json_array[key]);
							}

							value = JSON.stringify(json_array);
						}
					}else{
						continue;
					}
				}
				if(name.indexOf('[]') > -1){
					name = name.replace('[]', '');
					if(typeof obj[name] !== 'object') obj[name] = [];

					obj[name][Object.keys(obj[name]).length] = value;
				}else{
					obj[name] = value;
				}
			}
		}
		return(obj);
	}

	/**
	 * init accordion
	 */
	t.initAccordion = function(){

		jQuery(".postbox-arrow").each(function(i) {

			jQuery(this).closest('h3').unbind('click');

			jQuery(this).closest('h3').click(function(){
				var handle = jQuery(this);

				//open
				if(!handle.hasClass("box-closed")){
					handle.closest('.postbox').find('.inside').slideUp("fast");
					handle.addClass("box-closed");

				}else{	//close
					jQuery('.postbox-arrow').each(function() {
						var handle = jQuery(this).closest('h3');
						handle.closest('.postbox').find('.inside').slideUp("fast");
						handle.addClass("box-closed");
					})
					handle.closest('.postbox').find('.inside').slideDown("fast");
					handle.removeClass("box-closed");

				}
			});

		});

	}

	/**
	 * init slider
	 */
	t.initSlider = function(){
		jQuery(function() {
			var sliders = [
				{name: 'rows', min: 1, max: 99},
				{name: 'grid-animation-speed', min: 0, max: 9000, step: 100},
				{name: 'grid-animation-delay', min: 1, max: 30},
				{name: 'hover-animation-speed', min: 0, max: 9000, step: 100},
				{name: 'hover-animation-delay', min: 1, max: 30},
				{name: 'load-more-amount', min: 1, max: 20},
				{name: 'load-more-start', min: 1, max: 20}
				];


			for(key in sliders){
				var curval = jQuery('input[name="'+sliders[key].name+'"]').val();
				var curstep = 1;
				if(sliders[key].step != undefined) curstep = sliders[key].step;
				jQuery('#slider-'+sliders[key].name).slider({
					value: curval,
					min: sliders[key].min,
					max: sliders[key].max,
					step: curstep,
					slide: function(event, ui){
						jQuery('input[name="'+jQuery(this).attr('id').replace('slider-', '')+'"]').val(ui.value);
						jQuery("body").trigger("esgslide",jQuery(this));
					}

				});
				var neww = parseInt(jQuery('#slider-'+sliders[key].name+' .ui-slider-handle').css('left'),0);
				jQuery('#slider-'+sliders[key].name).prepend('<span class="eg-pre-slider"></span>');
				jQuery('#slider-'+sliders[key].name+' .eg-pre-slider').css({width:neww});

			}

			for(var i=1; i<=7; i++){
				var columns = jQuery('#columns-'+i).val();
				jQuery('#slider-columns-'+i).slider({
					value: columns,
					min: 1,
					max: 15,
					slide: function(event, ui){
						jQuery('#columns-'+jQuery(this).data('num')).val(ui.value);
						jQuery("body").trigger("esgslide",jQuery(this));

					}
				});
				jQuery('#slider-columns-'+i).prepend('<span class="eg-pre-slider"></span>');

				var neww = parseInt(jQuery('#slider-columns-'+i+' .ui-slider-handle').css('left'),0);
				jQuery('#slider-columns-'+i+' .eg-pre-slider').css({width:neww});
			}


			// RESCALE SLIDER SELECTED PART
			jQuery('body').on('esgslide',function(event,$obj) {
				var obj = jQuery($obj);
				setTimeout(function() {
					var neww = parseInt(obj.find('.ui-slider-handle').css('left'),0);
					obj.find('.eg-pre-slider').css({width:neww});
				},10);

			});


		});
	}

	t.recalcSlidersPos = function() {

			var sliders = [
				{name: 'rows', min: 1, max: 99},
				{name: 'grid-animation-speed', min: 0, max: 9000, step: 100},
				{name: 'grid-animation-delay', min: 1, max: 30},
				{name: 'hover-animation-speed', min: 0, max: 9000, step: 100},
				{name: 'hover-animation-delay', min: 1, max: 30},
				{name: 'load-more-amount', min: 1, max: 20},
				{name: 'load-more-start', min: 1, max: 20}
				];


			for(key in sliders){
				var curval = jQuery('input[name="'+sliders[key].name+'"]').val();
				var curstep = 1;
				if(sliders[key].step != undefined) curstep = sliders[key].step;
				var neww = parseInt(jQuery('#slider-'+sliders[key].name+' .ui-slider-handle').css('left'),0);
				jQuery('#slider-'+sliders[key].name+' .eg-pre-slider').css({width:neww});

			}

			for(var i=1; i<=7; i++){
				var columns = jQuery('#columns-'+i).val();
				var neww = parseInt(jQuery('#slider-columns-'+i+' .ui-slider-handle').css('left'),0);
				jQuery('#slider-columns-'+i+' .eg-pre-slider').css({width:neww});
			}


			// RESCALE SLIDER SELECTED PART
			jQuery('body').on('esgslide',function(event,$obj) {
				var obj = jQuery($obj);
				setTimeout(function() {
					var neww = parseInt(obj.find('.ui-slider-handle').css('left'),0);
					obj.find('.eg-pre-slider').css({width:neww});
				},10);

			});

	}


	t.initAutocomplete = function(){

		for(var i = 0; i < pages.length; ++i) {
			all_pages.push(pages[i].label);
			mapping[pages[i].label] = pages[i].value;
		}

		jQuery("#pages").autocomplete({
			minLength: 1,
			source: all_pages,
			select: function(event, ui) {

				t.insertSelectedPage(ui.item.value);

				return false;
			}
		});

		jQuery('body').on('click', '.del-page-entry', function(){
			var rem_id = jQuery(this).parent().data('id');
			jQuery('select[name="selected_pages"] option[value="' + rem_id + '"]').attr('selected', false);

			jQuery(this).parent().remove();
		});
	}

	t.insertSelectedPage = function(page_value){
		var last_key = 0;
		var add_id = mapping[page_value];

		if(jQuery('select[name="selected_pages"] option[value="' + add_id + '"]').is(':selected')){ //already inserted
			jQuery('#pages').val('');
			return false;
		}

		jQuery('#pages-wrap').append('<div data-id="'+mapping[page_value]+'">'+page_value+' <i class="eg-icon-trash del-page-entry"></i></div>');

		var sortedDivs = jQuery("#pages-wrap").children().toArray().sort(
			function sorter(a, b) {
				return (jQuery(a).text() > jQuery(b).text()) ? 1 : 0;
			}
		);

		jQuery.each(sortedDivs, function (index, value) {
			jQuery("#pages-wrap").append(value);
		});

		jQuery('select[name="selected_pages"] option[value="' + mapping[page_value] + '"]').attr('selected', true);

		jQuery('#pages').val('');
	}

	/***********************
	* Create Grid Start
	***********************/

	/**
	 * update shortcode from alias value.
	 */
	t.updateShortcode = function(){
		var alias = jQuery("input[name='handle']").val();
		var shortcode = '[ess_grid alias="'+alias+'"]';
		if(alias == '')
			shortcode = '-- '+eg_lang.aj_wrong_alias+' -- ';
		jQuery('input[name="shortcode"]').val(shortcode);

		jQuery('input[name="ajax-container-shortcode"]').val(shortcode.replace('[ess_grid', '[ess_grid_ajax_target'));

		jQuery('.filter-shortcode-filter').each(function(){
			jQuery(this).val(shortcode.replace('[ess_grid', '[ess_grid_nav id="'+jQuery(this).data('num')+'" '));
		});

	}

	t.checkEvenMasonryInput = function() {
		//if ((jQuery('input[name="layout"]:checked').val()== "even" || jQuery('input[name="layout"]:checked').val()== "cobbles") && jQuery("input[name='layout-sizing']:checked").val() != 'fullscreen') {
		if (jQuery("input[name='layout-sizing']:checked").val() != 'fullscreen') {
			jQuery('#eg-items-ratio-wrap').show();
			if (jQuery('input[name="layout"]:checked').val()== "even")
				jQuery('#eg-content-push-wrap').show();
			else
				jQuery('#eg-content-push-wrap').hide();

		} else {
			jQuery('#eg-content-push-wrap').hide();
			jQuery('#eg-items-ratio-wrap').hide();
		}

		if(jQuery('input[name="layout"]:checked').val() == 'cobbles'){
			jQuery('#eg-cobbles-options').show();
		}else{
			jQuery('#eg-cobbles-options').hide();
		}

		if(jQuery('input[name="layout"]:checked').val() == 'masonry'){
			jQuery('#eg-masonry-options').show();
		}else{
			jQuery('#eg-masonry-options').hide();
		}
		
		if(jQuery('input[name="layout"]:checked').val() == 'masonry' && jQuery('input[name="auto-ratio"]').attr('checked') == 'checked'){
			jQuery('#eg-ratio-wrapper').hide();
		}else{
			jQuery('#eg-ratio-wrapper').show();
		}
		
	}
	
	

	t.initCreateGrid = function(doAction){

		jQuery("input[name='layout-sizing']").change(function(){
			if(jQuery("input[name='layout-sizing']:checked").val() == 'fullscreen') {
				jQuery('#eg-fullscreen-container-wrap').show();
				jQuery('#eg-even-masonry-wrap').hide();
				jQuery('input[name="layout"][value="even"]').click();
				jQuery('input[name="rows-unlimited"][value="off"]').click();

				jQuery('#eg-pagination-wrap').hide();
				t.checkEvenMasonryInput();
			} else {
				jQuery('#eg-fullscreen-container-wrap').hide();
				jQuery('#eg-even-masonry-wrap').show();
				t.checkEvenMasonryInput();
				jQuery('#eg-pagination-wrap').show();
			}
		});
		
		jQuery('input[name="auto-ratio"]').click(function(){
			
			if(jQuery(this).attr('checked') == 'checked'){
				jQuery('#eg-ratio-wrapper').hide();
			}else{
				jQuery('#eg-ratio-wrapper').show();
			}
		});

		jQuery('input[name="layout"]').change(function() {
			t.checkEvenMasonryInput();
		});

		jQuery("input[name='layout-sizing']").change();

		//update shortcode
		jQuery("input[name='handle']").change(function(){
			t.updateShortcode();
		});

		jQuery("input[name='handle']").keyup(function(){
			t.updateShortcode();
		});

		//select shortcode text onclick.
		jQuery("input[name='shortcode']").focus(function(){
			this.select();
		});

		//select shortcode text onclick.
		jQuery('body').on('focus', ".filter-shortcode-filter", function(){
			this.select();
		});

		jQuery("input[name='shortcode']").click(function(){
			this.select();
		});

		t.updateShortcode();

		jQuery('input[name="ajax-container-position"]').click(function(){
			if(jQuery(this).val() == 'shortcode')
				jQuery('#eg-ajax-shortcode-wrapper').show();
			else
				jQuery('#eg-ajax-shortcode-wrapper').hide();
		});
		jQuery('input[name="ajax-container-position"]:checked').click();


		jQuery('#eg-btn-save-grid').click(function(){
			t.removeRedHighlighting();

			var errors = 0;

			var data = {
				name: jQuery.trim(jQuery('input[name="name"]').val()),
				handle: jQuery.trim(jQuery('input[name="handle"]').val()), //is alias
				postparams: t.getFormParams('eg-form-create-posts'),
				params: t.getFormParams('eg-form-create-settings')
			};

			data.params['css-id'] = jQuery('#esg-id-value').val();

			data.params['navigation-layout'] = t.get_navigation_layout();
			data.params['custom-javascript'] = eg_codemirror_api_js.getValue();
			data.params['ajax-container-css'] = eg_codemirror_ajax_css.getValue();
			
			data.params['custom-filter'] = eg_filter_handles_selected;

			delete data['postparams']['search_pages']; //unused
			delete data['params']['do-not-save']; //unused
			delete data['params']['ajax-container-shortcode']; //unused

			if(jQuery('input[name="source-type"]:checked').val() == 'custom'){
				var custom_layers = t.getFormParams('eg-custom-elements-form-wrap');
				data.layers = (typeof custom_layers['layers'] !== 'undefined') ? custom_layers['layers'] : [];

				if(typeof custom_layers['layers'] === 'undefined'){
					errors++;
					t.showErrorMessage(eg_lang.add_at_least_one_element);
				}
			}

			if(data.name.length < 2 || data.name.length > 255){
				t.addRedHighlighting('input[name="name"]');
				errors++;
			}
			if(data.handle.length < 2 || data.handle.length > 255){
				t.addRedHighlighting('input[name="handle"]');
				errors++;
			}

			if(errors == 0){ //do update
				//add slider id to the data
				if(doAction == 'update_grid'){
					data.id = jQuery('input[name="eg-id"]').val();
				}

				//start update/insert process
				t.ajaxRequest("update_create_grid", data, '.save-wrap-settings');
			}
		});

		jQuery('#eg-btn-delete-grid').click(function(){
			var delete_id = jQuery('input[name="eg-id"]').val();

			var data = { id: delete_id }

			if(confirm(eg_lang.delete_grid)){
				t.ajaxRequest("delete_grid", data, '.save-wrap-settings');
			}
		});


		eg_postTypesWithCats = jQuery.parseJSON(eg_jsonTaxWithCats);

		jQuery('select[name="post_types"]').change(function(){
			var arrTypes = jQuery(this).val();
			var is_page_active = false;

			jQuery('#set-pages-wrap').hide();
			jQuery('#eg-post-cat-wrap').hide();

			//replace the categories in multi select
			jQuery('select[name="post_category"]').empty();
			jQuery(arrTypes).each(function(index,postType){
				var objCats = eg_postTypesWithCats[postType];
				if(postType == 'page') jQuery('#set-pages-wrap').show();
				if(postType != 'page') jQuery('#eg-post-cat-wrap').show();

				var flagFirst = true;

				for(catIndex in objCats){
					var catTitle = objCats[catIndex];
					//add option to cats select
					var opt = new Option(catTitle, catIndex);

					if(catIndex.indexOf("option_disabled") == 0)
						jQuery(opt).prop("disabled","disabled");
					else{
						//select first option:
						if(flagFirst == true){
							jQuery(opt).prop("selected","selected");
							flagFirst = false;
						}
					}

					jQuery('select[name="post_category"]').append(opt);

				}
			});

		});


		jQuery('input[name="filter-meta-key"]').autocomplete({
			source: arr_meta_keys,
			minLength:0
		});

		//open the list on right button
		jQuery('.filter-meta-selector').click(function(event){
			event.stopPropagation();
			if(jQuery('input[name="filter-meta-key"]').data('is_open') == true)
				jQuery('input[name="filter-meta-key"]').autocomplete('close');
			else   //else open autocomplete
				jQuery('input[name="filter-meta-key"]').autocomplete('search', '').data('ui-autocomplete');
		});

		t.build_filter_tab = function(filter_sel, wrap, filter_name, nr){

			var filter = []; //save who is checked
			jQuery('.'+filter_sel+':checked').each(function(){
				filter.push(jQuery(this).val());
			});

			var filter_all = []; //save the order
			jQuery('.'+filter_sel).each(function(){
				filter_all.push(jQuery(this).val());
			});
			
			//push custom wanted also in here
			
			
			var cur_selected = jQuery('select[name="post_category"]').val(); //currently selected categories and tags

			if(cur_selected == null) cur_selected = [];

			//add available metas here
			if(typeof(eg_meta_handles) !== 'undefined'){
				for(var key in eg_meta_handles){
					cur_selected.push(key);
				}
			}
			
			//add available metas here
			if(typeof(eg_filter_handles_selected) !== 'undefined'){
				for(var key in eg_filter_handles_selected){
					if(jQuery.inArray(key, cur_selected) === -1){
						cur_selected.push(key);
					}else{
						delete(eg_filter_handles_selected[key]);
					}
				}
			}

			jQuery('.'+wrap).html('');

			for(var fa_key in filter_all){
				if(cur_selected !== null && cur_selected.indexOf(filter_all[fa_key]) > -1){ //still exists add it
					var opt_html = '';
					var opt_name = (filter_all[fa_key].indexOf('meta-') > -1) ? eg_meta_handles[filter_all[fa_key]]+' '+eg_lang.meta_val : jQuery('select[name="post_category"] option[value="'+filter_all[fa_key]+'"]').html();

					opt_html = '<div class="eg-media-source-order revblue button-primary"><span style="float:left">'+opt_name+'</span><input class="eg-get-val eg-filter-input '+filter_sel+'" type="checkbox" name="'+filter_name+'" data-origname="filter-selected-#NR[]" value="'+filter_all[fa_key]+'" /><div style="clear:both"></div></div>';
					jQuery('.'+wrap).append(opt_html);

					//now check if it should be selected
					if(filter !== null && filter.indexOf(filter_all[fa_key]) > -1) jQuery('.'+filter_sel+'[value="'+filter_all[fa_key]+'"]').attr('checked', 'checked');

					//remove element from the cur_selected array so that we have in the end only elements that need to be added to the list. (also need to be checked because they are new)
					delete(cur_selected[cur_selected.indexOf(filter_all[fa_key])]);
				}
			}

			if(cur_selected !== null){
				for(var key in cur_selected){
					var opt_html = '';
					var opt_name = (cur_selected[key].indexOf('meta-') > -1) ? eg_meta_handles[cur_selected[key]]+' '+eg_lang.meta_val : jQuery('select[name="post_category"] option[value="'+cur_selected[key]+'"]').html();

					opt_html = '<div class="eg-media-source-order revblue button-primary"><span style="float:left">'+opt_name+'</span><input class="eg-get-val eg-filter-input '+filter_sel+'" type="checkbox" name="'+filter_name+'" data-origname="filter-selected-#NR[]" value="'+cur_selected[key]+'" /><div style="clear:both"></div></div>';
					jQuery('.'+wrap).append(opt_html);

					if(!filter_startup){
						jQuery('.'+filter_sel+'[value="'+cur_selected[key]+'"]').attr('checked', 'checked');
					}
				}
			}

			//check if all exist, if not add the missing ones
			if(typeof(nr) !== 'undefined' && jQuery('.'+wrap).length > 0){
				if(jQuery('.eg-navigation-cons-filter-'+nr).length === 0){
					//add filter button for dropdown
					jQuery('.eg-navigation-cons-wrapper').append('<div data-navtype="filter-'+nr+'" class="eg-navigation-cons-filter-'+nr+' eg-nav-cons-filter eg-navigation-cons"><i class="eg-icon-megaphone"></i>'+eg_lang.filter+' '+nr+'</div>');
				}
			}
		}
		// SHOW / HIDE WARNING ABOUT SMALL CACHE
		function checkSmallCache() {
			jQuery('.cachenumbercheck').each(function() {
				var me = jQuery(this),
					inp = me.find('input'),
					lab = me.find('.showonsmallcache');
				if (inp.val()<3600) 
					lab.show()
				else
					lab.hide();
			})			
		}

		checkSmallCache();
		jQuery('.cachenumbercheck input').change(checkSmallCache);

		// SHOW/HIDE FILTERS
		jQuery('body').on('mouseenter','.inst-filter-griditem',function() {
			punchgs.TweenLite.to(jQuery(this).find('.inst-filter-griditem-img'),0.5,{autoAlpha:0});
		})
		jQuery('body').on('mouseleave','.inst-filter-griditem',function() {
			punchgs.TweenLite.to(jQuery(this).find('.inst-filter-griditem-img'),0.5,{autoAlpha:1});
		});

		jQuery('body').on('click','.inst-filter-griditem',function() {
			var a = jQuery(this);
			jQuery('#media-filter-type option:selected').removeAttr('selected');
			jQuery('#media-filter-type option[value="'+a.data("type")+'"]').attr('selected','selected');
			jQuery('.inst-filter-griditem.selected').removeClass("selected")
			a.addClass("selected");
		});

		// SHOW / HIDE AVAILALE MEDIA ELEMENTS IN LIGHTBOX, AJAX AND MEDIA SOURCE
		function qCheckAC(el) {
			
			return (!el.hasClass("notavailable") && el.find('input').is(":checked"))
		}
		function checkAvailablePosters() {
			
			jQuery('#pso-list').find('.eg-media-source-order').each(function() {
				jQuery(this).addClass("notavailable");
			});
			var gt = jQuery('input[name="source-type"]:checked').val(),
				any = false,
				obj = {	fei:{a:false, b:"#pso-featured-image"},
						alt:{a:false, b:"#pso-alternate-image"},
						fci:{a:false, b:"#pso-content-image"},
						ydi:{a:false, b:"#pso-default-youtube-image"},
						vdi:{a:false, b:"#pso-default-vimeo-image"},
						hdi:{a:false, b:"#pso-default-html-image"},						
						yth:{a:false, b:"#pso-youtube-image"},
						vth:{a:false, b:"#pso-vimeo-image"},
						ni:{a:false, b:"#pso-no-image"}};
				
			if  (qCheckAC(jQuery('#imso-youtube')) || qCheckAC(jQuery('#imso-content-youtube'))) {
				obj.fei.a=true;
				obj.alt.a=true;
				obj.fci.a=true;
				obj.ni.a=true;
				obj.ydi.a=true;
				obj.yth.a=true;				
			}

			if  (qCheckAC(jQuery('#imso-vimeo')) || qCheckAC(jQuery('#imso-content-vimeo'))) {
				obj.fei.a=true;
				obj.alt.a=true;
				obj.fci.a=true;
				obj.ni.a=true;
				obj.vdi.a=true;
				obj.vth.a=true;				
			}

			if  (qCheckAC(jQuery('#imso-html5')) || qCheckAC(jQuery('#imso-content-html5'))) {
				obj.fei.a=true;
				obj.alt.a=true;
				obj.fci.a=true;
				obj.ni.a=true;
				obj.hdi.a=true;
				obj.vth.a=true;				
			}
			
			if  (qCheckAC(jQuery('#imso-wistia')) || qCheckAC(jQuery('#imso-soundcloud'))) {
				obj.fei.a=true;
				obj.alt.a=true;
				obj.fci.a=true;
				obj.ni.a=true;
			}						
			
			jQuery.each(obj,function(i,el){
				if (el.a)
					jQuery(el.b).removeClass("notavailable");
			})
		}

		// SHOW/HIDE THE AVAILABLE MEDIA SOUERCES ON DEMAND
		function checkAvailableMedias() {
			var gt = jQuery('input[name="source-type"]:checked').val(),
				st = jQuery('input[name="stream-source-type"]:checked').val();
			if (gt!=="post") {
				jQuery('#imso-list,#lbo-list, #ajo-list').find('.eg-media-source-order').each(function() {
					jQuery(this).addClass("notavailable");
				});				
			}
			switch (gt) {
				case "post":
					jQuery('#imso-list, #lbo-list, #ajo-list').find('.eg-media-source-order').each(function() {
						jQuery(this).removeClass("notavailable");
					});
					
				break;
				case "custom":
					jQuery('#imso-list, #lbo-list, #ajo-list').find('.eg-media-source-order').each(function(i) {						
						var id = this.id.indexOf("imso-content-",0);
						
						if (id!=-1)
							jQuery(this).addClass("notavailable");
						else
							jQuery(this).removeClass("notavailable");

					});
					jQuery('#ajo-revslider').addClass("notavailable");
					jQuery('#ajo-content-image').addClass("notavailable");
				break;
				case "stream":
					jQuery('#imso-'+st+', #lbo-'+st+', #ajo-'+st).removeClass("notavailable");
					switch (st) {
						case "instagram":
							jQuery('#imso-featured-image, #lbo-featured-image, #ajo-featured-image').removeClass("notavailable");
							jQuery('#imso-html5,#lbo-html5').removeClass("notavailable");
						break;
						case "twitter":
							jQuery('#imso-featured-image,#lbo-featured-image,#ajo-featured-image').removeClass("notavailable");							
						break;
						case "flickr":
							jQuery('#imso-featured-image,#lbo-featured-image,#ajo-featured-image').removeClass("notavailable");							
						break;
						case "facebook":
							jQuery('#imso-featured-image,#lbo-featured-image,#ajo-featured-image').removeClass("notavailable");
							jQuery('#imso-html5,#lbo-html5,#ajo-html5').removeClass("notavailable");
							jQuery('#imso-youtube,#lbo-youtube,#ajo-youtube').removeClass("notavailable");
						break;
					}					
				break;
			}	
			checkAvailablePosters();			
		}



		jQuery('#esg-source-choose-wrapper input').change(checkAvailableMedias);
		jQuery('#imso-list input').change(checkAvailablePosters);


		/**
		 * function that populates the three filter selectboxes
		 **/
		jQuery('select[name="post_category"]').change(function(){

			t.build_filter_tab('eg-filter-selected', 'eg-filter-selected-order-wrap', 'filter-selected[]');

			//do all also for the other elements
			if(eg_filter_counter > 1 || typeof(jQuery('input[name="filter-all-text-1"]')) !== 'undefined'){
				for(var i = 1; i <= eg_filter_counter; i++){

					t.build_filter_tab('eg-filter-selected-'+i, 'eg-filter-selected-order-wrap-'+i, 'filter-selected-'+i+'[]', i);
					jQuery('.eg-filter-selected-order-wrap-'+i).closest('.eg-filter-options-wrap').find('.eg-remove-filter-tab').show();

				}
			}
			filter_startup = false;
		});
		jQuery('select[name="post_category"]').change(); //to propagate filter dropdowns

		jQuery('select[name="filter2-type"]').change(function(){
			if(jQuery(this).val() == 'custom')
				jQuery('#eg-filter2-sel-wrap').show();
			else
				jQuery('#eg-filter2-sel-wrap').hide();
		});


		jQuery('select[name="filter3-type"]').change(function(){
			if(jQuery(this).val() == 'custom')
				jQuery('#eg-filter3-sel-wrap').show();
			else
				jQuery('#eg-filter3-sel-wrap').hide();
		});


		//show/hide page selector depending on what is selected at start
		var sel = jQuery('select[name="post_types"]').val();
		jQuery('#set-pages-wrap').hide();
		jQuery('#eg-post-cat-wrap').hide();
		jQuery(sel).each(function(index,postType){
			if(postType == 'page') jQuery('#set-pages-wrap').show();
			if(postType != 'page') jQuery('#eg-post-cat-wrap').show();

		});


		jQuery('input[name="layout"]').click(function(){
			if(jQuery(this).val() == 'even')
				jQuery('#eg-layout-even-ratio').show();
			else
				jQuery('#eg-layout-even-ratio').hide();
		});

		jQuery('#main-background-color').wpColorPicker({
			change:function() {
				setTimeout(function() {
					jQuery('#eg-live-preview-wrap').css({backgroundColor:jQuery('#main-background-color').val()});
				},50);
			}
		});

		jQuery('#spinner_color').wpColorPicker({
			change:function() {
				setTimeout(function() {
					t.spinnerColorChange();
				},50);
			}
		});

		jQuery('#lazy-load-color').wpColorPicker();

		jQuery('#eg-live-preview-wrap').css({backgroundColor:jQuery('#main-background-color').val()});

		jQuery('input[name="rows-unlimited"]').change(function(){
			if(jQuery(this).val() == 'off'){
				jQuery('.load-more-wrap').hide();
				jQuery('.rows-num-wrap').show();
			}else{
				jQuery('.load-more-wrap').show();
				jQuery('.rows-num-wrap').hide();
			}
		});

		jQuery('select[name="load-more"]').change(function(){
			if(jQuery('input[name="rows-unlimited"]:checked').val() == 'on'){
				if(jQuery(this).val() == 'scroll'){
					jQuery('.load-more-hide-wrap').show();
				}else{
					jQuery('.load-more-hide-wrap').hide();
				}
			}else{
				jQuery('.load-more-hide-wrap').hide();
			}
		});

		jQuery('input[name="columns-advanced"]').change(function(){
			if(jQuery(this).val() == 'on') {
				jQuery('.columns-width').show();
				jQuery('.columns-height').show();
				jQuery('.columns-sliding').hide();
				for (var i=0;i<8;i++) {
					jQuery('#slider-columns-'+i).addClass("shortform");
				}
			} else {
				jQuery('.columns-width').hide();
				jQuery('.columns-height').hide();
				jQuery('.columns-sliding').show();
				for (var i=0;i<8;i++) {
					jQuery('#slider-columns-'+i).removeClass("shortform");
				}

			}

			t.calc_advanced_rows(jQuery(this).val());
		});

		if(jQuery('input[name="columns-advanced"]:checked').val() == 'on'){
			jQuery('.columns-width').show();
			jQuery('.columns-height').show();
			jQuery('.columns-sliding').hide();
		}

		t.calc_advanced_rows(jQuery('input[name="columns-advanced"]:checked').val());


		jQuery('body').on('click', '#eg-add-column-advanced', function(){
			var len = jQuery('.columns-adv-head').length;

			if(len == 9) return true;

			var col = [];

			if(len == 0){
				col[0] = jQuery('#columns-1').val();
				col[1] = jQuery('#columns-2').val();
				col[2] = jQuery('#columns-3').val();
				col[3] = jQuery('#columns-4').val();
				col[4] = jQuery('#columns-5').val();
				col[5] = jQuery('#columns-6').val();
				col[6] = jQuery('#columns-7').val();
			}else{
				var c = len - 1;

				jQuery('input[name="columns-advanced-rows-'+c+'[]"]').each(function(e){
					col[e] = jQuery(this).val();
				});
			}

			jQuery('#eg-col-00').append('<td class="columns-adv-'+len+' columns-adv-rows columns-adv-head" style="text-align: center;position:relative;"></td>');
			jQuery('#eg-col-1').append('<td class="columns-adv-'+len+' columns-adv-rows" style="position:relative;"><input class="input-settings-small" type="text" name="columns-advanced-rows-'+len+'[]" value="'+col[0]+'" /></td>');
			jQuery('#eg-col-2').append('<td class="columns-adv-'+len+' columns-adv-rows" style="position:relative;"><input class="input-settings-small" type="text" name="columns-advanced-rows-'+len+'[]" value="'+col[1]+'" /></td>');
			jQuery('#eg-col-3').append('<td class="columns-adv-'+len+' columns-adv-rows" style="position:relative;"><input class="input-settings-small" type="text" name="columns-advanced-rows-'+len+'[]" value="'+col[2]+'" /></td>');
			jQuery('#eg-col-4').append('<td class="columns-adv-'+len+' columns-adv-rows" style="position:relative;"><input class="input-settings-small" type="text" name="columns-advanced-rows-'+len+'[]" value="'+col[3]+'" /></td>');
			jQuery('#eg-col-5').append('<td class="columns-adv-'+len+' columns-adv-rows" style="position:relative;"><input class="input-settings-small" type="text" name="columns-advanced-rows-'+len+'[]" value="'+col[4]+'" /></td>');
			jQuery('#eg-col-6').append('<td class="columns-adv-'+len+' columns-adv-rows" style="position:relative;"><input class="input-settings-small" type="text" name="columns-advanced-rows-'+len+'[]" value="'+col[5]+'" /></td>');
			jQuery('#eg-col-7').append('<td class="columns-adv-'+len+' columns-adv-rows" style="position:relative;"><input class="input-settings-small" type="text" name="columns-advanced-rows-'+len+'[]" value="'+col[6]+'" /></td>');

			t.calc_advanced_rows(jQuery('input[name="columns-advanced"]:checked').val());

		});

		jQuery('body').on('click', '#eg-remove-column-advanced', function(){
			var len = jQuery('.columns-adv-head').length;

			if(len == 0) return true;

			len--;

			jQuery('.columns-adv-'+len).remove();

			t.calc_advanced_rows(jQuery('input[name="columns-advanced"]:checked').val());

		});

		t.getPagesDialog();

		jQuery('#navigation-skin-select').change(function(){
			/*if(jQuery('#navigation-skin-select option:selected').hasClass('custom-skin')){
			}else{
				jQuery('#eg-edit-navigation-skin').hide();
			}*/

			//jQuery('#eg-edit-navigation-skin').show();
		});


		/**
		 * Change new Navigation Skin
		 */
		jQuery('#eg-edit-navigation-skin').click(function(){
			var skin_handle = jQuery('#navigation-skin-select option:selected').val();
			t.open_navigation_skin_dialog(skin_handle);
		});


		/**
		 * Delete selected Navigation Skin
		 */
		jQuery('#eg-delete-navigation-skin').click(function(){
			if(confirm(eg_lang.deleting_nav_skin_message)){
				var skin_handle = jQuery('#navigation-skin-select option:selected').val();
				var data = {skin: skin_handle};

				AdminEssentials.ajaxRequest("delete_navigation_skin_css", data, '#eg-edit-navigation-skin,#eg-create-navigation-skin,#eg-delete-navigation-skin',function(response){
					if(response.success == true){

						jQuery('#navigation-styling-css-wrapper').html(response.css);
						jQuery('#navigation-skin-select').html(response.select);

						jQuery('#navigation-skin-select option:first').attr("selected","selected");

						t.changePreviewGrid();

						eg_codemirror_navigation_css_default_skin = jQuery.extend({}, response.default_skins);

						jQuery('#navigation-skin-css-edit-dialog-wrap').dialog('close');
					}
				});
			}
		});



		/**
		 * Create new Navigation Skin
		 */
		jQuery('#eg-create-navigation-skin').click(function(){
			var nav_skin_name = prompt(eg_lang.please_enter_unique_skin_name);
            if(nav_skin_name == null) return false;

            if(nav_skin_name.length < 2){
			    alert(eg_lang.skin_name_too_short);
                return false;
            }

			var nav_skin_name_sanitize = t.sanitize_input(nav_skin_name);
			for(var key in eg_codemirror_navigation_css_default_skin){
				if(eg_codemirror_navigation_css_default_skin[key]['handle'] == nav_skin_name_sanitize){
					alert(eg_lang.skin_name_already_registered);
					return false;
				}
			}

			t.open_navigation_skin_dialog(nav_skin_name);
		});



		t.open_navigation_skin_dialog = function(skin_handle){
			var exist = false;

			for(var key in eg_codemirror_navigation_css_default_skin){
				if(eg_codemirror_navigation_css_default_skin[key]['handle'] == skin_handle){
					eg_codemirror_navigation_css.setValue(eg_codemirror_navigation_css_default_skin[key]['css']);
					exist = eg_codemirror_navigation_css_default_skin[key]['id'];
					break;
				}
			}

			if(exist == false){ //not found, use first entry for referal, we create a new skin now
				for(var key in eg_codemirror_navigation_css_default_skin){
					var san_skin = t.sanitize_input(skin_handle);
					var han_skin = eg_codemirror_navigation_css_default_skin[key]['handle'];

					nav_css = eg_codemirror_navigation_css_default_skin[key]['css'];
					nav_css = nav_css.split('.'+han_skin).join('.'+san_skin);

					eg_codemirror_navigation_css.setValue(nav_css);
					break;
				}
			}


			jQuery("#navigation-skin-css-edit-dialog-wrap").dialog({
				modal:true,
				draggable:false,
				resizable:false,
				width:632,
				height:565,
				closeOnEscape:true,
				buttons: [ { text: eg_lang.create_nav_skin+': '+skin_handle, click: function() {
					var data = {
						skin_css: eg_codemirror_navigation_css.getValue()
					};

					if(exist !== false){ //change existing skin
						data.sid = exist;
					}else{ //create skin
						data.name = skin_handle;
					}

					AdminEssentials.ajaxRequest("update_create_navigation_skin_css", data, '.ui-button',function(response){

						if(response.success == true){
							if(exist !== false)
								var do_select = jQuery('#navigation-skin-select option:selected').val();
							else
								var do_select = t.sanitize_input(skin_handle);

							jQuery('#navigation-styling-css-wrapper').html(response.css);
							jQuery('#navigation-skin-select').html(response.select);

							jQuery('#navigation-skin-select option[value="'+do_select+'"]').attr("selected","selected");

							t.changePreviewGrid();

							eg_codemirror_navigation_css_default_skin = jQuery.extend({}, response.default_skins);

							jQuery('#navigation-skin-css-edit-dialog-wrap').dialog('close');
						}
					});

				} } ],
				dialogClass:'wp-dialog',
				open: function(){
					//jQuery('#eg-nav-skins-select').prependTo('.ui-dialog-buttonpane');
				},
				close: function(){
					//jQuery('#eg-nav-skins-select').prependTo('.ui-dialog-buttonpane');
				}
			});

			eg_codemirror_navigation_css.refresh();
		}

		eg_codemirror_navigation_css = CodeMirror.fromTextArea(document.getElementById("eg-navigation-skin-css-editor"), {
			lineNumbers: true
		});

		eg_codemirror_navigation_css.setSize(632, 482);

		jQuery('.eg-navigation-drop-inner, .eg-navigation-cons-wrapper').sortable({
			connectWith: ".eg-navigation-drop-inner, .eg-navigation-cons-wrapper",
			revert: true,
			over: function(event, ui) {
				/*if(!ui.item.hasClass('eg-navigation-cons-right') && !ui.item.hasClass('eg-navigation-cons-left')){
					var elid = ui.item.closest('.eg-navigation-drop-wrapper').attr('id');
					if(elid != 'eg-navigations-sort-left' && elid != 'eg-navigations-sort-right')
						return false;
				}*/

				jQuery(this).addClass("eg-navigation-drop-inner-hovered");
			},
			stop: function(event, ui){

				/*if(!ui.item.hasClass('eg-navigation-cons-right') && !ui.item.hasClass('eg-navigation-cons-left')){
					var elid = ui.item.closest('.eg-navigation-drop-wrapper').attr('id');
					if(elid != 'eg-navigations-sort-left' && elid != 'eg-navigations-sort-right')
						return false;
				}*/

				jQuery(this).removeClass("eg-navigation-drop-inner-hovered");
			},
			receive: function(event,ui) {
				if(ui.item.closest('#eg-navigations-sort-external').length == 1){
					//add fields if not already existing
					if(ui.item.find('.eg-filter-sc').length == 0){

						var item_skin = jQuery('#navigation-skin-select').clone().wrap('<div></div>');
						item_skin.attr('id', '');
						item_skin.attr('name', 'navigation-special-skin[]');

						var new_item = '<div class="eg-filter-sc"><input class="filter-shortcode-filter" type="text" readonly="readonly" data-num="'+ui.item.data('navtype')+'" /><input type="text" name="navigation-special-class[]" value="" />';
						new_item += item_skin.parent().html();
						new_item += '</div>';

						ui.item.append(new_item);
						t.updateShortcode();
					}else{ //already existing

					}
				}else{
					if(ui.item.closest('.eg-navigation-default-wrap').length == 1){
						jQuery('.eg-stay-last-element').appendTo('.eg-navigation-default-wrap');
					}

					//remove fields if they exist
					if(ui.item.find('.eg-filter-sc').length == 1){
						ui.item.find('.eg-filter-sc').remove();
					}
				}

			},
			out: function(event,ui) {

				jQuery(this).removeClass("eg-navigation-drop-inner-hovered");
			}
		});

		jQuery('.eg-media-source-order-wrap .eg-media-source-order').tpsortable({

		});


		/**
		 * set options for posts
		 */

		jQuery('body').on('click', '.eg-btn-activate-post-item', function(){
			var cur_post_id = jQuery(this).attr('id').replace('eg-act-post-item-', '');
			var cur_grid_id = jQuery('input[name="eg-id"]').val();

			var data = { post_id: cur_post_id, grid_id: cur_grid_id };

			AdminEssentials.ajaxRequest("trigger_post_meta_visibility", data, '.eg-btn-activate-post-item',function(response){
				if(typeof(response.success != 'undefined') && response.success == true){
					if(jQuery('#eg-act-post-item-'+cur_post_id).children().hasClass('eg-icon-eye')) {
						jQuery('#eg-act-post-item-'+cur_post_id).children().removeClass('eg-icon-eye').addClass('eg-icon-eye-off');
						jQuery('#eg-act-post-item-'+cur_post_id).removeClass("revblue").addClass("revred");
					} else {
						jQuery('#eg-act-post-item-'+cur_post_id).children().removeClass('eg-icon-eye-off').addClass('eg-icon-eye');
						jQuery('#eg-act-post-item-'+cur_post_id).removeClass("revred").addClass("revblue");
					}
				}
			});

		});


		jQuery('body').on('click', '.eg-btn-edit-post-item', function(){
			var cur_post_id = jQuery(this).attr('id').replace('eg-edit-post-item-', '');
			var cur_grid_id = jQuery('input[name="eg-id"]').val();
			var data = { post_id: cur_post_id, grid_id: cur_grid_id };

			AdminEssentials.ajaxRequest("get_post_meta_html_for_editor", data, '.eg-btn-edit-post-item',function(response){
				if(typeof(response.success != 'undefined') && response.success == true){


					jQuery('#eg-meta-box').html(response.data.html);

					document.getElementById('eg-form-post-meta-settings').reset();

					jQuery('#post-meta-dialog-wrap').dialog({
						modal:true,
						draggable:false,
						resizable:false,
						width:650,
						height:600,
						closeOnEscape:true,
						dialogClass:'wp-dialog',
						buttons: [ { text: eg_lang.save_post_meta, click: function() {

							var data = {
								metas: t.getFormParams('eg-form-post-meta-settings')
							};

							data.metas['grid_id'] = jQuery('input[name="eg-id"]').val();

							AdminEssentials.ajaxRequest("update_post_meta_through_editor", data, '.ui-button',function(response){
								t.changePreviewGrid(true);
								document.getElementById('eg-form-post-meta-settings').reset();
								jQuery('#post-meta-dialog-wrap').dialog('close');
							});

						} } ],
					});
				}
			});
		});


		/**
		 * Custom Create Grid Switch
		 */

		var do_change = false;

		jQuery('input[name="source-type"]').change(function(){
			var set = jQuery(this).val();

			switch(set){
				case 'post':
					jQuery('#post-pages-wrap').show();
					jQuery('#set-pages-wrap').show();
					jQuery('.filter-only-for-post').show();
					jQuery('#aditional-pages-wrap').show();
					jQuery('#custom-sorting-wrap').hide();
					//jQuery('#eg-external-drag-wrap').show();
					jQuery('#custom-element-add-elements-wrapper').hide();
					jQuery('#all-stream-wrap').hide();
					jQuery('#media-source-order-wrap').show();
					jQuery('#media-source-sizes').show();
					break;
				case 'custom':
					jQuery('#post-pages-wrap').hide();
					jQuery('#set-pages-wrap').hide();
					jQuery('.filter-only-for-post').hide();
					jQuery('#aditional-pages-wrap').hide();
					jQuery('#custom-sorting-wrap').show();
					//jQuery('#eg-external-drag-wrap').hide();
					jQuery('#custom-element-add-elements-wrapper').show();
					jQuery('#media-source-order-wrap').show();
					jQuery('#media-source-sizes').show();
					//move all elements back to start
					/*jQuery('#eg-navigations-sort-external .eg-navigation-drop-inner div').each(function(){
						jQuery(this).appendTo('.eg-navigation-cons-wrapper');
						jQuery('.eg-filter-sc').remove();
					});*/
					jQuery('#all-stream-wrap').hide();
					break;
				case 'stream':
					jQuery('#post-pages-wrap').hide();
					jQuery('#set-pages-wrap').hide();
					jQuery('.filter-only-for-post').hide();
					jQuery('#aditional-pages-wrap').hide();
					jQuery('#custom-sorting-wrap').hide();
					jQuery('#custom-element-add-elements-wrapper').hide();
					//jQuery('#media-source-order-wrap').hide();
					jQuery('#all-stream-wrap').show();
					jQuery('#media-source-sizes').hide();
					jQuery('input[name="stream-source-type"]:checked').change();
					break;
			}

			

			if(do_change == true) //do not preview on load
				t.changePreviewGrid(true);
			else
				do_change = true;

		});
		jQuery('input[name="source-type"]:checked').change();

		/**
		 * Show/Hide Stream Sources
		 * @since 1.1.0
		 */
		jQuery('input[name="stream-source-type"]').change(function(){
			
			if(jQuery('input[name="source-type"]:checked').val()!='stream') return false;
			
			var set = jQuery(this).val();

			jQuery( "[id$='-external-stream-wrap']" ).hide();
			jQuery( "#"+set+"-external-stream-wrap" ).show();

			jQuery("#eg-source-youtube-message,#eg-source-vimeo-message").hide();

			switch(set){
				case 'vimeo':
					jQuery('input[name="vimeo-type-source"]:checked').change();
					jQuery("#eg-source-vimeo-message").show();
				break;
				case 'youtube':
					jQuery('input[name="youtube-type-source"]:checked').change();
					jQuery("#eg-source-youtube-message").show();
				break;
				case 'facebook':
					jQuery('input[name="facebook-type-source"]:checked').change();
				break;
				case 'flickr':
					jQuery('input[name="flickr-type"]:checked').change();
				break;
				
			}

/*
			try{
				if(do_change == true) //do not preview on load
					t.changePreviewGrid(true);
				else
					do_change = true;
			}
			catch(e){}
*/
		});
		jQuery('input[name="stream-source-type"]:checked').change();

		// Vimeo Source
		jQuery('input[name="vimeo-type-source"]').change(function(){
			if(jQuery('input[name="source-type"]:checked').val()!='stream') return false;		
			if(jQuery('input[name="stream-source-type"]:checked').val()!='vimeo') return false;
			var set = jQuery(this).val();
			
			jQuery( ".eg-external-source-vimeo" ).hide();
			jQuery( "#eg-external-source-vimeo-"+set+"-wrap" ).show();

			try{
				if(do_change == true) //do not preview on load
					t.changePreviewGrid(true);
				else
					do_change = true;
			}
			catch(e){}

		});
		jQuery('input[name="vimeo-type-source"]:checked').change();

		// YouTube Source
		jQuery('input[name="youtube-type-source"]').change(function(){
			if(jQuery('input[name="source-type"]:checked').val()!='stream') return false;		
			if(jQuery('input[name="stream-source-type"]:checked').val()!='youtube') return false;
			var set = jQuery(this).val();
			
			if(set=="playlist"){
				jQuery("#eg-external-source-youtube-playlist-wrap").show();
				var data = { api: jQuery('#youtube-api').val() , id: jQuery('#youtube-channel-id').val(), playlist: jQuery('#youtube-playlist').val() };
				AdminEssentials.ajaxRequest("get_youtube_playlists", data, '#youtube-playlist-select',function(response){
					jQuery('#youtube-playlist-select').html(response.data.html).show();
					jQuery('input[name=youtube-playlist').val(jQuery('#youtube-playlist-select').val());
				});
			}
			else {
				jQuery("#eg-external-source-youtube-playlist-wrap").hide();	
			}

			try{
				if(do_change == true) //do not preview on load
					t.changePreviewGrid(true);
				else
					do_change = true;
			}
			catch(e){}

		});
		jQuery('input[name="youtube-type-source"]:checked').change();

		jQuery('#youtube-playlist-select').change(function(){
			jQuery('input[name=youtube-playlist').val(jQuery('#youtube-playlist-select').val());	
		});

		// YouTube Channel ID
		jQuery('input[name="youtube-channel-id"]').change(function(){
			if( jQuery('input[name="youtube-type-source"]:checked').val() == "playlist" ){
				jQuery('input[name="youtube-type-source"]:checked').change();
			}
		});

		// Flickr Source
		jQuery('input[name="flickr-type"]').change(function(){
			if(jQuery('input[name="source-type"]:checked').val()!='stream') return false;		
			if(jQuery('input[name="stream-source-type"]:checked').val()!='flickr') return false;
			var set = jQuery(this).val();

			jQuery("#eg-external-source-flickr-sources div").hide();
			switch(set){
				case 'publicphotos':
					jQuery('#eg-external-source-flickr-publicphotos-url-wrap').show();
				break;
				case 'photosets':
					var data = { key: jQuery('input[name=flickr-api-key').val() , count: jQuery('input[name=flickr-count').val() , url: jQuery('input[name=flickr-user-url').val() , set: jQuery('input[name=flickr-photoset]').val() };
					AdminEssentials.ajaxRequest("get_flickr_photosets", data, 'select[name=flickr-photoset-select]',function(response){
						jQuery('select[name=flickr-photoset-select]').html(response.data.html).show();
						jQuery('input[name=flickr-photoset').val(jQuery('select[name=flickr-photoset-select]').val());
					});
					jQuery('#eg-external-source-flickr-photosets-wrap').show();
				break;
				case 'gallery':
					jQuery('#eg-external-source-flickr-gallery-url-wrap').show();
				break;
				case 'group':
					jQuery('#eg-external-source-flickr-group-url-wrap').show();
				break;
				default:
				break;
			}

			try{
				if(do_change == true) //do not preview on load
					t.changePreviewGrid(true);
				else
					do_change = true;
			}
			catch(e){}

		});
		jQuery('input[name="flickr-type"]:checked').change();

		jQuery('select[name=flickr-photoset-select]').change(function(){
			jQuery('input[name=flickr-photoset]').val(jQuery('select[name=flickr-photoset-select]').val());	
		});

		// Facebook Source
		jQuery('input[name="facebook-type-source"]').change(function(){
			if(jQuery('input[name="source-type"]:checked').val()!='stream') return false;		
			if(jQuery('input[name="stream-source-type"]:checked').val()!='facebook') return false;
			var set = jQuery(this).val();

			if(set=="album"){
				var data = { url: jQuery("input[name=facebook-page-url]").val(), album: jQuery("input[name=facebook-album]").val(), api_key: jQuery("input[name=facebook-app-id]").val(), api_secret: jQuery("input[name=facebook-app-secret]").val()};
				AdminEssentials.ajaxRequest("get_facebook_photosets", data, 'select[name=facebook-album-select]',function(response){
					jQuery('select[name=facebook-album-select]').html(response.data.html).show();
					jQuery('input[name=facebook-album').val(jQuery('select[name=facebook-album-select]').val());
				});
				jQuery("#eg-external-source-facebook-album-wrap").show();
			}
			else{
				jQuery("#eg-external-source-facebook-album-wrap").hide();	
			}

			try{
				if(do_change == true) //do not preview on load
					t.changePreviewGrid(true);
				else
					do_change = true;
			}
			catch(e){}

		});
		jQuery('input[name="facebook-type-source"]:checked').change();

		jQuery('select[name=facebook-album-select]').change(function(){
			jQuery('input[name=facebook-album]').val(jQuery('select[name=facebook-album-select]').val());	
		});

		jQuery('input[name="facebook-page-url"]').change(function(){
			jQuery('input[name="facebook-type-source"]:checked').change();
		});		

		jQuery('.eg-clear-cache').click(function(){
			t.clearStreamCache(jQuery(this));
		});

		/**
		 * Show/Hide filter options depending on setting
		 * @since 1.1.0
		 */
		jQuery('input[name="filter-listing"]').change(function(){
			var set = jQuery(this).val();
			if(set == 'list'){
				jQuery('.filter-only-if-dropdown').hide();
			}else{
				jQuery('.filter-only-if-dropdown').show();
			}
		});
		jQuery('input[name="filter-listing"]:checked').change();

		jQuery('input[name="poster-source-order[]"]').change(function(){
			$this = jQuery(this);
			var values = new Array();
			jQuery.each(jQuery("input[name='poster-source-order[]']:checked"), function() {
			  values.push(jQuery(this).val());
			});
			
			values.indexOf("default-youtube-image")>-1 ? jQuery("#eg-youtube-default-poster").show() : jQuery("#eg-youtube-default-poster").hide();
			values.indexOf("default-vimeo-image")>-1 ? jQuery("#eg-vimeo-default-poster").show() : jQuery("#eg-vimeo-default-poster").hide();
			values.indexOf("default-html-image")>-1 ? jQuery("#eg-html5-default-poster").show() : jQuery("#eg-html5-default-poster").hide();	
		});
		jQuery('input[name="poster-source-order[]"]').change();

		/**
		 * Reset the custom Elements
		 */
		t.reset_custom_fields = function(){
			for(var key in init_custom){
				switch(init_custom[key]['type']){
					case 'input':
						var set_val = (typeof(init_custom[key]['default']) !== 'undefined') ? init_custom[key]['default'] : '';
						jQuery('input[name="'+init_custom[key]['name']+'"]').val(set_val);
						break;
					case 'select':
					case 'multi-select':
						var set_val = (typeof(init_custom[key]['default']) !== 'undefined') ? init_custom[key]['default'] : jQuery('select[name="'+init_custom[key]['name']+'"] option:first-child').attr('selected', 'selected');
						jQuery('select[name="'+init_custom[key]['name']+'"] option[value="'+set_val+'"]').attr('selected', 'selected');
						break;
					case 'textarea':
						var set_val = (typeof(init_custom[key]['default']) !== 'undefined') ? init_custom[key]['default'] : '';
						jQuery('textarea[name="'+init_custom[key]['name']+'"]').val(set_val);
						break;
					case 'image':
						jQuery('input[name="'+init_custom[key]['name']+'"]').val('');
						jQuery('#'+init_custom[key]['name']+'-img').attr('src', '');
						jQuery('#'+init_custom[key]['name']+'-img').hide();
						break;
				}
			}

		}

		/**
		 * remove highlight class from elements
		 */
		t.remove_hightlighting = function(){
			jQuery('div').removeClass('eg-elset-row-highlight');
		}


		jQuery('body').on('click', '.eg-btn-duplicate-custom-element', function(){
			var data = jQuery(this).closest('li').find('input[name="layers[]"]').val(); //get set data

			jQuery('#esg-preview-wrapping-wrapper').prepend('<input id="eg-new-temp-layer" class="esg-new-temp-layer" name="layers[]" type="hidden" values="" />');
			jQuery('#eg-new-temp-layer').val(data);

			t.changePreviewGrid(true);
		});


		jQuery('body').on('click', '.eg-btn-edit-custom-element', function(){
			var data = jQuery(this).closest('li').find('input[name="layers[]"]').val(); //get set data
			data = jQuery.parseJSON(data);

			if(typeof(data['custom-type']) === 'undefined') data['custom-type'] = 'image';

			var cur_type = data['custom-type'];

			t.open_custom_element_dialog(cur_type, data, jQuery(this).closest('li').find('input[name="layers[]"]'));
		});


		jQuery('body').on('click', '.esg-open-edit-dialog', function(){
			var cur_type = jQuery(this).attr('id').replace('esg-add-new-custom-', '').replace('-top', '');
			
			if(cur_type == 'image'){
				jQuery('#custom-element-image-dialog-wrap').dialog({
					modal:true,
					draggable:false,
					resizable:false,
					width:300,
					height:200,
					closeOnEscape:true,
					dialogClass:'wp-dialog',
					buttons: [
					{ text: eg_lang.single, click: function() {
						t.open_custom_element_dialog(cur_type, false);
						jQuery(this).dialog('close');
					} },
					{ text: eg_lang.bulk, click: function() {
						t.add_custom_grid_multiple_images();
						jQuery(this).dialog('close');
					} }]
				});
			}else{
				t.open_custom_element_dialog(cur_type, false);
			}
		});



		t.open_custom_element_dialog = function(cur_type, cur_data, input_obj){

			t.reset_custom_dialog();
			t.remove_hightlighting();

			jQuery('.esg-item-skin-elements').hide(); //hide all specific elements first
			jQuery('.esg-item-skin-media-title').show(); //hide all specific elements first

			var editor_text = eg_lang.add_element;
			var editor_save_text = eg_lang.add_element;

			jQuery('input[name="custom-type"]').val(cur_type); //write the type into the box

			switch(cur_type){
				case 'youtube':
					jQuery('#esg-item-skin-elements-media-youtube').show();
					jQuery('#esg-item-skin-elements-media-image').show();
					jQuery('#esg-item-skin-elements-media-ratio').show();
					break;
				case 'vimeo':
					jQuery('#esg-item-skin-elements-media-vimeo').show();
					jQuery('#esg-item-skin-elements-media-image').show();
					jQuery('#esg-item-skin-elements-media-ratio').show();
					break;
				case 'soundcloud':
					jQuery('#esg-item-skin-elements-media-sound').show();
					jQuery('#esg-item-skin-elements-media-image').show();
					jQuery('#esg-item-skin-elements-media-ratio').show();
					break;
				case 'html5':
					jQuery('#esg-item-skin-elements-media-html5').show();
					jQuery('#esg-item-skin-elements-media-image').show();
					jQuery('#esg-item-skin-elements-media-ratio').show();
					break;
				case 'image':
					jQuery('#esg-item-skin-elements-media-image').show();
					break;
				case 'text':
					jQuery('.esg-item-skin-media-title').hide();
					break;
			}

			//set values from current settings
			var cur_ele = jQuery('#esg-template-wrapper .esg-data-handler').data('exists');

			for(var key in cur_ele){
				jQuery('#edit-custom-element-form input[name="'+key+'"]').val(cur_ele[key]);
				jQuery('#edit-custom-element-form input[name="'+key+'"]').closest('div').addClass('eg-elset-row-highlight');
			}

			//set data into fields if we have some presets
			if(cur_data !== false){ //edit mode
				var editor_text = eg_lang.edit_element;
				var editor_save_text = eg_lang.save_changes;

				t.set_custom_dialog_fields(cur_data);
			}

			jQuery('#edit-custom-element-dialog-wrap').dialog({
				modal:true,
				draggable:false,
				resizable:false,
				title: editor_text,
				width:650,
				height:600,
				closeOnEscape:true,
				dialogClass:'wp-dialog',
				buttons: [
				{ text: eg_lang.close, click: function() {
					jQuery(this).dialog('close');
				} },
				{ text: editor_save_text, click: function() {

					//write input field in the front of elements, then refresh the preview
					var new_data = JSON.stringify(t.getFormParams('edit-custom-element-form')); //get set data

					if(cur_data === false){ //we create a new entry

						jQuery('#esg-preview-wrapping-wrapper').prepend('<input id="eg-new-temp-layer" class="esg-new-temp-layer" name="layers[]" type="hidden" values="" />');
						jQuery('#eg-new-temp-layer').val(new_data);

					}else{ //we update an existing entry
						//set new_data into the right input field
						input_obj.val(new_data);
					}

					jQuery(this).dialog('close');

					t.changePreviewGrid(true);

				} }

				],
			});
		}


		jQuery('body').on('click', '.eg-btn-move-before-custom-element, .eg-btn-move-after-custom-element, .eg-btn-switch-custom-element', function(){

			var new_position,
				jt = jQuery(this),
				jtli = jt.closest('li');

			if(jt.hasClass('eg-btn-move-before-custom-element')){
				new_position = jtli.index();
				jtli.insertBefore(jtli.parent().find('>li:nth-child('+new_position+')'));
			}

			else

			if(jt.hasClass('eg-btn-move-after-custom-element')){
				new_position = jtli.index()+2;
				if (new_position >= jtli.parent().find('>li').length) new_position=jtli.parent().find('>li').length-1;
				jtli.insertAfter(jtli.parent().find('>li:nth-child('+new_position+')'));
			}

			else

			if(jt.hasClass('eg-btn-switch-custom-element')){
				new_position = parseInt(prompt(eg_lang.enter_position,1));
				if (new_position >=0 && new_position<99999) {
					if (new_position >= jtli.parent().find('>li').length) new_position=jtli.parent().find('>li').length-1;
					jtli.insertAfter(jtli.parent().find('>li:nth-child('+new_position+')'));
				}
			}
			t.resetCustomItemValues();
			t.changePreviewGrid();

		});

		t.resetCustomItemValues = function() {
			if(jQuery('input[name="source-type"]:checked').val() == 'custom'){
				jQuery('#esg-preview-skinlevel').find('ul >li').each(function() {
					var li = jQuery(this);
					li.find('.eg-order-nr').remove();
					if (!li.hasClass("eg-addnewitem-wrapper"))
						li.append('<div class="eg-order-nr">'+(li.index()+1)+'</div>');
				});
			}
		};



		t.reset_custom_dialog = function(){

			t.reset_custom_fields();

			jQuery('#esg-custom-image-img').attr('src', '');
			jQuery('#esg-custom-image-img').hide();

			document.getElementById('edit-custom-element-form').reset();

		};

		t.set_custom_dialog_fields = function(cur_data){
			var set_form = document.getElementById('edit-custom-element-form');
			for(var key in cur_data){
				var els = document.getElementsByName(key);
				if(typeof els[0] !== 'undefined'){
					switch(els[0].tagName){
						case 'INPUT':
							jQuery('input[name="'+key+'"]').val(cur_data[key]);

							//check if we are an image
							var is_img = jQuery('#esg-'+key+'-img');
							if(is_img.length === 0) //custom meta images
								var is_img = jQuery('#'+key+'-img');

							//show the img tag and set the right source
							if(is_img.length > 0){
								if(parseInt(cur_data[key]) > 0){
									var data = {img_id: cur_data[key]}

									t.ajaxRequest('get_image_by_id', data, '', function(response, img_obj){
										if(typeof(response.success != 'undefined') && response.success == true){
											img_obj.attr('src', response.url);
											img_obj.show();
										}
									}, is_img);
								}
							}
						break;
						case 'SELECT':
							jQuery('select[name="'+key+'"] option[value="'+cur_data[key]+'"]').attr('selected', 'selected');
						break;
					}
				}
			}
		}


		/**
		 * Remove Custom Element from list
		 */
		jQuery('body').on('click', '.eg-btn-delete-custom-element', function(){
			if(confirm(eg_lang.remove_this_element)){
				jQuery(this).closest('li').remove();

				jQuery('#esg-preview-grid').esappend(); // Add the new Element to Grid Logic

				t.resetCustomItemValues();
				t.changePreviewGrid();
			}
		});


		/**
		SET RATIO VISIBILTY BASED ON LAOYUT
		**/
		t.checkEvenMasonryInput();

		/**
		CHECK BOX FOR SKIN SELECTION
		**/
		t.skinSelectorFakes();

		/**
		Set The Layout Dependencies of Lightbox
		**/
		t.lightboxLayoutDependencies();
		t.lightboxLayoutEvents();

		/**
		CHANGE ON ITEM ADD HOVER THE TITLES IN ELEMENTS
		**/
		t.changeAddElementTitles();


		/**
		NAVIGATION SETTINGS
		**/
		jQuery('input[name="nagivation-type"]').change(function(){
			jQuery('#es-ng-layout-wrapper').hide();
			jQuery('#es-ng-external-wrapper').hide();
			jQuery('#es-ng-widget-wrapper').hide();

			switch(jQuery(this).val()){
				case 'internal':
					jQuery('#es-ng-layout-wrapper').show();
				break;
				case 'external':
					jQuery('#es-ng-external-wrapper').show();
				break;
				case 'widget':
					jQuery('#es-ng-widget-wrapper').show();
				break;
			}
		});
		jQuery('input[name="nagivation-type"]:checked').change();


		eg_codemirror_api_js = CodeMirror.fromTextArea(document.getElementById("eg-api-custom-javascript"), {
			lineNumbers: true,
			mode: "text/javascript"
		});

		eg_codemirror_api_js.setSize(500, 250);

		eg_codemirror_ajax_css = CodeMirror.fromTextArea(document.getElementById("eg-ajax-custom-css"), {
			lineNumbers: true,
			mode: "text/css"
		});

		eg_codemirror_ajax_css.setSize(500, 250);


		jQuery('.eg-api-inputs').click(function(){
			jQuery(this).select().focus();
		});

		jQuery('.eg-default-image-add,.eg-youtube-default-image-add,.eg-vimeo-default-image-add,.eg-html-default-image-add').click(function(e) {
			e.preventDefault();
			AdminEssentials.upload_image_img(jQuery(this).data('setto'));

			return false;
		});

		jQuery('.eg-default-image-clear,.eg-youtube-default-image-clear,.eg-vimeo-default-image-clear,.eg-html-default-image-clear').click(function(e) {
			e.preventDefault();
			var setto = jQuery(this).data('setto');
			jQuery('#'+setto).val('');
			jQuery('#'+setto+'-img').attr("src","");
			jQuery('#'+setto+'-img').hide();
			return false;
		});

		
		jQuery('.eg-clear-taxonomies').click(function(){
			jQuery('select[name="post_category"]').val([]);
		});
		
		
		/*******************
		 * More Filter Functions
		 *******************/
		jQuery('body').on('click', '.eg-filter-add-custom-filter', function(){
			//open list with all filters plus the custom filters that were added
			jQuery('#eg-filter-select-box').html('');
			var sel_filters = jQuery('select[name="post_category"]').val();
			
			for(var key in eg_filter_handles){
				var opt = new Option(eg_filter_handles[key], key);
				
				if(key.indexOf("option_disabled") == 0 || jQuery.inArray(key, sel_filters) !== -1){
					jQuery(opt).prop("disabled","disabled");
				}
				
				
				if(eg_filter_handles_selected[key] !== undefined){
					jQuery(opt).attr("selected","selected");
				}
				
				
				jQuery('#eg-filter-select-box').append(opt);
			}
			
			jQuery('#filter-select-dialog-wrap').dialog({
				modal:true,
				resizable:false,
				width:600,
				height:350,
				closeOnEscape:true,
				dialogClass:'wp-dialog',
				buttons:[
					{ text: eg_lang.save_changes, click: function(){
							eg_filter_handles_selected = {};
							jQuery('#eg-filter-select-box option:selected').each(function(){
								eg_filter_handles_selected[jQuery(this).val()] = jQuery(this).text();
							});
							
							//update the list
							jQuery('select[name="post_category"]').change();
							
							jQuery(this).dialog("close");
						}
					},
					{ text: eg_lang.close, click: function(){
							jQuery(this).dialog("close");
						}
					}
				],
				create:function () {
					jQuery(this).closest(".ui-dialog")
						.find(".ui-dialog-buttonpane") // the first button
						.addClass("save-wrap");
				},
			});
		});
		
		jQuery('.eg-add-filter-box').click(function(){
			eg_filter_counter++;

			var filter_html = jQuery('.eg-original-filter-options-wrap').clone();
			filter_html.removeClass('eg-original-filter-options-wrap');

			filter_html.find('[data-origname]').each(function(){
				jQuery(this).attr('name', jQuery(this).data('origname').replace('#NR', eg_filter_counter));
			});


			filter_html.find('.filter-shortcode-filter').data('num', eg_filter_counter);
			filter_html.find('.filter-shortcode-filter').attr('data-num', eg_filter_counter);
			filter_html.find('.filter-header-id').text(eg_filter_counter);
			filter_html.find('.eg-remove-filter-tab').show();
			filter_html.find('.eg-filter-selected-order-wrap').removeClass('eg-filter-selected-order-wrap').addClass('eg-filter-selected-order-wrap-'+eg_filter_counter);

			filter_html.find('.eg-filter-selected').each(function(){
				jQuery(this).removeClass('eg-filter-selected').addClass('eg-filter-selected-'+eg_filter_counter);
			});

			filter_html.appendTo('.eg-original-filter-options-holder');

			jQuery('.eg-media-source-order-wrap .eg-media-source-order').tpsortable({});

			jQuery('.eg-navigation-cons-wrapper').append('<div data-navtype="filter-'+eg_filter_counter+'" class="eg-navigation-cons-filter-'+eg_filter_counter+' eg-nav-cons-filter eg-navigation-cons"><i class="eg-icon-megaphone"></i>'+eg_lang.filter+' '+eg_filter_counter+'</div>');

			t.updateShortcode();

		});

		jQuery('body').on('click', '.eg-remove-filter-tab', function(){
			if(confirm(eg_lang.deleting_this_cant_be_undone)){
				var curnum = jQuery(this).siblings('input').attr('name').replace('filter-all-text-', '');
				jQuery('.eg-navigation-cons-filter-'+curnum).remove();
				jQuery(this).closest('.eg-filter-options-wrap').remove();
			}
		});

		jQuery('input[name="filter-arrows"]').change(function(){
			if(jQuery(this).val() == 'multi'){
				jQuery('.eg-filter-logic').show();
			}else{
				jQuery('.eg-filter-logic').hide();
			}
		});
		jQuery('input[name="filter-arrows"]:checked').change();


		jQuery('input[name="ajax-close-button"]').change(function(){
			if(jQuery(this).val() == 'on' || jQuery('input[name="ajax-nav-button"]:checked').val() == 'on'){
				if(jQuery(this).val() == 'on'){
					jQuery('.eg-close-button-settings-wrap').show();
				}
				jQuery('.eg-close-nav-button-settings-wrap').show();

			}else{
				jQuery('.eg-close-button-settings-wrap').hide();
				jQuery('.eg-close-nav-button-settings-wrap').hide();
			}
		});
		jQuery('input[name="ajax-close-button"]:checked').change();

		jQuery('input[name="ajax-nav-button"]').change(function(){
			if(jQuery(this).val() == 'on' || jQuery('input[name="ajax-close-button"]:checked').val() == 'on'){
				jQuery('.eg-close-nav-button-settings-wrap').show();
			}else{
				jQuery('.eg-close-nav-button-settings-wrap').hide();
			}
		});
		jQuery('input[name="ajax-nav-button"]:checked').change();


		jQuery('select[name="lightbox-mode"]').change(function(){
			if(jQuery(this).val() == 'content' || jQuery(this).val() == 'content-gallery' || jQuery(this).val() == 'woocommerce-gallery'){
				jQuery('.lightbox-mode-addition-wrapper').show();
			}else{
				jQuery('.lightbox-mode-addition-wrapper').hide();
			}
		});
		jQuery('select[name="lightbox-mode"] option:selected').change();


		jQuery('.eg-add-new-cobbles-pattern').click(function(){
			var cob_sort_count = jQuery('.cob-sort-order').length + 1;
			var cobbles_container = '<div class="eg-cobbles-drop-wrap"><span class="cob-sort-order">'+ cob_sort_count +'.</span><select name="cobbles-pattern[]"><option value="1x1">1:1</option><option value="1x2">1:2</option><option value="1x3">1:3</option><option value="2x1">2:1</option><option value="2x2">2:2</option><option value="2x3">2:3</option><option value="3x1">3:1</option><option value="3x2">3:2</option><option value="3x3">3:3</option></select><a class="button-primary revred eg-delete-cobbles" href="javascript:void(0);"><i class="eg-icon-trash"></i></a></div>';
			jQuery('.eg-cobbles-pattern-wrap').append(cobbles_container);
		});

		jQuery('input[name="use-cobbles-pattern"]').change(function(){
			if(jQuery(this).val() == 'on'){
				jQuery('.eg-cobbles-pattern-wrap').show();
				jQuery('.eg-add-new-cobbles-pattern').show();
				jQuery('.eg-refresh-cobbles-pattern').show();
			}else{
				jQuery('.eg-cobbles-pattern-wrap').hide();
				jQuery('.eg-add-new-cobbles-pattern').hide();
				jQuery('.eg-refresh-cobbles-pattern').hide();
			}
		});


		jQuery('body').on('click', '.eg-delete-cobbles', function(){
			jQuery(this).closest('.eg-cobbles-drop-wrap').remove();
		});

		jQuery('.eg-cobbles-pattern-wrap').sortable({
			stop: function(event, ui){
				jQuery('.cob-sort-order').each(function(e){
					e = e + 1;
					jQuery(this).text(e+'.');
				});
			}
		});
	}


	t.initImportExport = function(){
		jQuery('input[name="export-grids"]').click(function(){
			t.switchCheckInputFields('export-grids', jQuery(this).is(':checked'));
		});
		jQuery('input[name="export-skins"]').click(function(){
			t.switchCheckInputFields('export-skins', jQuery(this).is(':checked'));
		});
		jQuery('input[name="export-elements"]').click(function(){
			t.switchCheckInputFields('export-elements', jQuery(this).is(':checked'));
		});
		jQuery('input[name="export-custom-meta"]').click(function(){
			t.switchCheckInputFields('export-custom-meta', jQuery(this).is(':checked'));
		});
		jQuery('input[name="export-navigation-skins"]').click(function(){
			t.switchCheckInputFields('export-navigation-skins', jQuery(this).is(':checked'));
		});
		jQuery('input[name="export-punch-fonts"]').click(function(){
			t.switchCheckInputFields('export-punch-fonts', jQuery(this).is(':checked'));
		});

		jQuery('input[name="import-grids"]').click(function(){
			t.switchCheckInputFields('import-grids', jQuery(this).is(':checked'));
		});
		jQuery('input[name="import-skins"]').click(function(){
			t.switchCheckInputFields('import-skins', jQuery(this).is(':checked'));
		});
		jQuery('input[name="import-elements"]').click(function(){
			t.switchCheckInputFields('import-elements', jQuery(this).is(':checked'));
		});
		jQuery('input[name="import-custom-meta"]').click(function(){
			t.switchCheckInputFields('import-custom-meta', jQuery(this).is(':checked'));
		});
		jQuery('input[name="import-navigation-skins"]').click(function(){
			t.switchCheckInputFields('import-navigation-skins', jQuery(this).is(':checked'));
		});
		jQuery('input[name="import-punch-fonts"]').click(function(){
			t.switchCheckInputFields('import-punch-fonts', jQuery(this).is(':checked'));
		});




		t.switchCheckInputFields = function(name, check){
			jQuery('input[name="'+name+'-id[]"]').each(function(){
				jQuery(this).attr('checked', check);
			});
			jQuery('input[name="'+name+'-handle[]"]').each(function(){
				jQuery(this).attr('checked', check);
			});
		}

		jQuery('#esg-import-data').click(function(){
			var import_data = t.getFormParams('eg-grid-import-form');

			t.ajaxRequest("import_data", {imports: import_data}, '#esg-import-data',function(response){

			});
		});

		jQuery('#eg-grid-export-import-wrapper .eg-li-intern-wrap').click(function(ev){
			var ec = jQuery(this).find('.eg-expand-collapse');

			if (ec.length>0 && jQuery(ev.target).hasClass("eg-li-intern-wrap") || jQuery(ev.target).hasClass("eg-expand-collapse") || jQuery(ev.target).hasClass("eg-icon-folder-open") || jQuery(ev.target).hasClass("eg-icon-folder")) {
				var li = ec.closest("li");
				if (ec.hasClass("closed")) {
					ec.removeClass("closed")
					li.find('ul').first().slideDown(200);
				} else {
					ec.addClass("closed")
					li.find('ul').first().slideUp(200);
				}
			}
		})

		jQuery('#eg-grid-export-import-wrapper ul li ul').each(function() {
			var ul = jQuery(this),
				lilen = ul.find('>li').length;
			ul.parent().find('.eg-amount-of-lis').html("("+lilen+")");

		})
		// PREPARING CHECKED AND NOT CHECKED STATUS
		jQuery('#eg-grid-export-import-wrapper').find('.eg-inputchecked').each(function() {
			var ch = jQuery(this);
			ch.click(function() {
				var inp = ch.siblings('input');
				inp.click();
				t.checkImportExportInputs();
				return false;
			});
		})

		t.checkImportExportInputs();

		/**
		 * Import Demo Posts
		 */
		jQuery('#esg-import-demo-posts').click(function(){
			if(confirm(eg_lang.import_demo_post_heavy_loading)){
				t.ajaxRequest("import_default_post_data", '', '#esg-import-demo-posts, #esg-import-demo-posts-210, #esg-read-file-import, #eg-export-selected-settings',function(response){

				});
			}
		});
		
		/**
		 * Import Demo Grids added at 2.1.0
		 */
		jQuery('#esg-import-demo-posts-210').click(function(){
			if(confirm(eg_lang.import_demo_grids_210)){
				t.ajaxRequest("import_default_grid_data_210", '', '#esg-import-demo-posts, #esg-import-demo-posts-210, #esg-read-file-import, #eg-export-selected-settings',function(response){

				});
			}
		});

	}


	t.checkImportExportInputs = function() {
		jQuery('#eg-grid-export-import-wrapper').find('.eg-inputchecked').each(function() {
			var ch = jQuery(this);
			ch.removeClass("eg-partlychecked");

			var inp = ch.siblings('input');

			if (inp.attr('checked')== "checked") {
				ch.addClass("checked")
				if (ch.closest('.eg-ie-sub-ul').length>0) {
					var chli = ch.closest('.eg-ie-sub-ul').closest('li').find('.eg-inputchecked').first();
					var notch = ch.closest('.eg-ie-sub-ul').find("input:checkbox:not(:checked)").length;
					if (!chli.hasClass("checked") && notch>0) chli.addClass("eg-partlychecked");
				}
			} else {
				ch.removeClass("checked");
				if (ch.closest('.eg-ie-sub-ul').length>0) {
					var chli = ch.closest('.eg-ie-sub-ul').closest('li').find('.eg-inputchecked').first();
					if (chli.hasClass("checked")) chli.addClass("eg-partlychecked");
				}

			}


		});
	}

	/**
	CHANGE ITEM TITLES IN ADD ELEMENT
	**/
//	esg-center eg-addnewitem-element-1 esg-rotatescale

	t.changeAddElementTitles = function() {

		jQuery(document.body).on("mouseenter",".eg-addnewitem-element-1",function() {
			var txt = eg_lang.selectyouritem;
			switch (jQuery(this).attr('id')) {
				case "esg-add-new-custom-youtube":
					txt = eg_lang.withyoutube;
				break;
				case "esg-add-new-custom-vimeo":
					txt = eg_lang.withvimeo;
				break;
				case "esg-add-new-custom-html5":
					txt = eg_lang.withthtml5;
				break;
				case "esg-add-new-custom-soundcloud":
					txt = eg_lang.withsoundcloud;
				break;
				case "esg-add-new-custom-image":
					txt = eg_lang.withimage;
				break;
				case "esg-add-new-custom-text":
					txt = eg_lang.withoutmedia;
				break;
				default:
					txt = eg_lang.selectyouritem;
				break;
			}
			jQuery('.esg-bottom.eg-addnewitem-element-2.esg-flipup').html(txt);
		});
		jQuery(document.body).on("mouseleave",".eg-addnewitem-element-1",function() {
			jQuery('.esg-bottom.eg-addnewitem-element-2.esg-flipup').html(eg_lang.selectyouritem);
		});

	}

	/**
	Set The Layout Dependencies of Lightbox
	**/
	t.lightboxLayoutDependencies = function () {
		var tyval = jQuery('select[name="lightbox-type"] option:selected').val();
		if (tyval=="null" || tyval =="over") {
		   jQuery('#eg-lb-title-position').hide();
/*		   jQuery('#eg-lb-twitter').hide();
		   jQuery('#eg-lb-facebook').hide();		   */
		} else {
			jQuery('#eg-lb-title-position').show();
/*			jQuery('#eg-lb-twitter').show();
		   jQuery('#eg-lb-facebook').show();			*/
		}

	}

	t.lightboxLayoutEvents = function() {
		jQuery('select[name="lightbox-type"]').change(function() {
			t.lightboxLayoutDependencies();
		})
	}

	/**
	CHECK BOX FOR SKIN SELECTION
	**/
	t.skinSelectorFakes = function() {
		jQuery('.eg-fakeinput, .esg-screenselect-toolbar').click(function() {
			var li = jQuery(this).closest('li');
			jQuery('li.filter-selectedskin').removeClass("filter-selectedskin");
			li.addClass('filter-selectedskin');
			li.find('input[name="entry-skin"]').attr('checked',true).change();

		});
	}


	/**
	 * Returns the navigation layout
	 */
	t.get_navigation_layout = function(){
		var elements = {pagination:{},left:{},right:{},filter:{},filter2:{},filter3:{},cart:{},sorting:{},'search-input':{}}

		var c_pagination = jQuery('.eg-navigation-cons-pagination');
		var c_left = jQuery('.eg-navigation-drop-inner .eg-navigation-cons-left');
		var c_right = jQuery('.eg-navigation-drop-inner .eg-navigation-cons-right');
		var c_filter = jQuery('.eg-navigation-drop-inner .eg-navigation-cons-filter');
		var c_filter2 = jQuery('.eg-navigation-drop-inner .eg-navigation-cons-filter2');
		var c_filter3 = jQuery('.eg-navigation-drop-inner .eg-navigation-cons-filter3');
		var c_cart = jQuery('.eg-navigation-drop-inner .eg-navigation-cons-cart');
		var c_sort = jQuery('.eg-navigation-drop-inner .eg-navigation-cons-sort');
		var c_search_input = jQuery('.eg-navigation-drop-inner .eg-navigation-cons-search-input');

		//var c_navigation = jQuery('.eg-navigation-drop-inner .eg-navigation-cons-navigation');

		if(c_pagination.closest('.eg-navigation-drop-wrapper').attr('id') !== undefined){
			pagination = c_pagination.closest('.eg-navigation-drop-wrapper').attr('id').replace('eg-navigations-sort-', '');
			order = c_pagination.parent().children('div').index(c_pagination);
			elements.pagination[pagination] = order;
		}

		if(c_left.closest('.eg-navigation-drop-wrapper').attr('id') !== undefined){
			left = c_left.closest('.eg-navigation-drop-wrapper').attr('id').replace('eg-navigations-sort-', '');
			order = c_left.parent().children('div').index(c_left);
			elements.left[left] = order;
		}

		if(c_right.closest('.eg-navigation-drop-wrapper').attr('id') !== undefined){
			right = c_right.closest('.eg-navigation-drop-wrapper').attr('id').replace('eg-navigations-sort-', '');
			order = c_right.parent().children('div').index(c_right);
			elements.right[right] = order;
		}

		if(c_filter.closest('.eg-navigation-drop-wrapper').attr('id') !== undefined){
			filter = c_filter.closest('.eg-navigation-drop-wrapper').attr('id').replace('eg-navigations-sort-', '');
			order = c_filter.parent().children('div').index(c_filter);
			elements.filter[filter] = order;
		}

		if(c_filter2.closest('.eg-navigation-drop-wrapper').attr('id') !== undefined){
			filter2 = c_filter2.closest('.eg-navigation-drop-wrapper').attr('id').replace('eg-navigations-sort-', '');
			order = c_filter2.parent().children('div').index(c_filter2);
			elements.filter2[filter2] = order;
		}

		if(c_filter3.closest('.eg-navigation-drop-wrapper').attr('id') !== undefined){
			filter3 = c_filter3.closest('.eg-navigation-drop-wrapper').attr('id').replace('eg-navigations-sort-', '');
			order = c_filter3.parent().children('div').index(c_filter3);
			elements.filter3[filter3] = order;
		}

		if(c_cart.closest('.eg-navigation-drop-wrapper').attr('id') !== undefined){
			cart = c_cart.closest('.eg-navigation-drop-wrapper').attr('id').replace('eg-navigations-sort-', '');
			order = c_cart.parent().children('div').index(c_cart);
			elements.cart[cart] = order;
		}

		if(c_sort.closest('.eg-navigation-drop-wrapper').attr('id') !== undefined){
			sort = c_sort.closest('.eg-navigation-drop-wrapper').attr('id').replace('eg-navigations-sort-', '');
			order = c_sort.parent().children('div').index(c_sort);
			elements.sorting[sort] = order;
		}

		if(c_search_input.closest('.eg-navigation-drop-wrapper').attr('id') !== undefined){
			search_input = c_search_input.closest('.eg-navigation-drop-wrapper').attr('id').replace('eg-navigations-sort-', '');
			order = c_search_input.parent().children('div').index(c_search_input);
			elements['search-input'][search_input] = order;
		}

		for(var i = 1;i<= eg_filter_counter; i++){
			var fil = jQuery('.eg-navigation-drop-inner .eg-navigation-cons-filter-'+i);
			if(fil.length > 0){
				sort = fil.closest('.eg-navigation-drop-wrapper').attr('id').replace('eg-navigations-sort-', '');
				order = fil.parent().children('div').index(fil);
				elements['filter-'+i] = {};
				elements['filter-'+i][sort] = order;
			}
		}

		jQuery('.eg-stay-last-element').appendTo('.eg-navigation-default-wrap');

		return elements;
	}


	/**
	 * set the navigation layout
	 */
	t.set_navigation_layout = function(){
		for (var i=0;i<99;i++) {
			var el = jQuery('.eg-navigation-cons[data-putin="top-1"][data-sort="'+i+'"]');
			if (el.length>0) jQuery('#eg-navigations-sort-top-1 .eg-navigation-drop-inner').append(el);

			var el = jQuery('.eg-navigation-cons[data-putin="top-2"][data-sort="'+i+'"]');
			if (el.length>0) jQuery('#eg-navigations-sort-top-2 .eg-navigation-drop-inner').append(el);

			var el = jQuery('.eg-navigation-cons[data-putin="bottom-1"][data-sort="'+i+'"]');
			if (el.length>0) jQuery('#eg-navigations-sort-bottom-1 .eg-navigation-drop-inner').append(el);

			var el = jQuery('.eg-navigation-cons[data-putin="bottom-2"][data-sort="'+i+'"]');
			if (el.length>0) jQuery('#eg-navigations-sort-bottom-2 .eg-navigation-drop-inner').append(el);

			var el = jQuery('.eg-navigation-cons[data-putin="left"][data-sort="'+i+'"]');
			if (el.length>0) jQuery('#eg-navigations-sort-left .eg-navigation-drop-inner').append(el);

			var el = jQuery('.eg-navigation-cons[data-putin="right"][data-sort="'+i+'"]');
			if (el.length>0) jQuery('#eg-navigations-sort-right .eg-navigation-drop-inner').append(el);

			var el = jQuery('.eg-navigation-cons[data-putin="external"][data-sort="'+i+'"]');
			if (el.length>0) jQuery('#eg-navigations-sort-external .eg-navigation-drop-inner').append(el);

		}

		var i = 0;

		jQuery('#eg-navigations-sort-external .eg-navigation-drop-inner>div').each(function(){
			var cval = '';
			var skin_sel = '';
			if(typeof(eg_nav_special_class[i]) !== 'undefined') cval = eg_nav_special_class[i];
			if(typeof(eg_nav_special_skin[i]) !== 'undefined') skin_sel = eg_nav_special_skin[i];


			var item_skin = jQuery('#navigation-skin-select').clone().wrap('<div></div>');
			item_skin.attr('id', '');
			item_skin.attr('name', 'navigation-special-skin[]');
			item_skin.find('option').attr('selected', false);
			item_skin.find('option[value="'+skin_sel+'"]').attr('selected', 'selected');

			var new_item = '<div class="eg-filter-sc"><input class="filter-shortcode-filter" type="text" readonly="readonly" data-num="'+jQuery(this).data('navtype')+'" /><input type="text" name="navigation-special-class[]" value="'+cval+'" />';
			new_item += item_skin.parent().html();
			new_item += '</div>';

			jQuery(this).append(new_item);
			i++;
		});
		t.updateShortcode();

	}


	t.set_default_nav_skin = function(json_css){
		css = jQuery.parseJSON(json_css)
		eg_codemirror_navigation_css_default_skin = jQuery.extend({}, css);
	}


	t.removeRedHighlighting = function(){
		jQuery('input').removeClass('eg-alert');
	}

	t.addRedHighlighting = function(theSelector){
		jQuery(theSelector).addClass('eg-alert');
	}

	/***********************
	* Overview Grid
	***********************/

	t.initOverviewGrid = function(doAction){

		jQuery('.eg-btn-delete-grid').click(function(){
			var delete_id = jQuery(this).attr('id').replace('eg-delete-', '');

			var data = { id: delete_id }
			if(confirm(eg_lang.delete_grid)){
				t.ajaxRequest("delete_grid", data, '.btn-wrap-overview-'+delete_id);
            }
		});

		jQuery('.eg-btn-duplicate-grid').click(function(){
			var duplicate_id = jQuery(this).attr('id').replace('eg-duplicate-', '');

			var data = { id: duplicate_id }

			t.ajaxRequest("duplicate_grid", data, '.btn-wrap-overview-'+duplicate_id);
		});

		jQuery('.eg-toggle-favorite').click(function(){
			var star_id = jQuery(this).attr('id').replace('eg-star-id-', '');
			
			var data = { id: star_id };
			
			t.ajaxRequest("toggle_grid_favorite", data, '', function(result){
				if(typeof result !== 'undefined' && typeof result['success'] !== 'undefined' && result['success'] === true){
					if(jQuery('#eg-star-id-'+star_id+' i').hasClass('eg-icon-star-empty')){
						jQuery('#eg-star-id-'+star_id+' i').removeClass('eg-icon-star-empty').addClass('eg-icon-star');
					}else{
						jQuery('#eg-star-id-'+star_id+' i').removeClass('eg-icon-star').addClass('eg-icon-star-empty');
					}
				}
			});
		});
	}
	
	
	/***********************
	* Global Settings init
	***********************/

	t.initGlobalSettings = function(doAction){
		jQuery("#ess-grid-delete-cache").click(function(){
			var data = {};

			t.ajaxRequest("delete_full_cache", data, '#ess-grid-delete-cache');
		});
		
		jQuery('#eg-btn-save-global-settings').click(function(){
			var plugin_permissions = jQuery('select[name="plugin_permissions"] option:checked').val();
			var plugin_tooltips = jQuery('select[name="plugin_tooltips"] option:checked').val();
			var output_protection = jQuery('select[name="output_protection"] option:checked').val();
			var wait_for_fonts = jQuery('select[name="wait_for_fonts"] option:checked').val();
			var use_cache = jQuery('select[name="use_cache"] option:checked').val();
			var js_to_footer = jQuery('select[name="js_to_footer"] option:checked').val();
			var overwrite_gallery = jQuery('select[name="overwrite_gallery"] option:checked').val();
			var query_type = jQuery('select[name="query_type"] option:checked').val();
			var enable_log = jQuery('select[name="enable_log"] option:checked').val();
			var use_lightbox = jQuery('select[name="use_lightbox"] option:checked').val();
			var enable_custom_post_type = jQuery('select[name="enable_custom_post_type"] option:checked').val();
			var enable_post_meta = jQuery('select[name="enable_post_meta"] option:checked').val();
			

			var data = {
				permission:plugin_permissions,
				tooltips:plugin_tooltips,
				protection:output_protection,
				wait_for_fonts:wait_for_fonts,
				use_cache:use_cache,
				js_to_footer:js_to_footer,
				overwrite_gallery:overwrite_gallery,
				query_type:query_type,
				enable_log:enable_log,
				use_lightbox:use_lightbox,
				enable_custom_post_type:enable_custom_post_type,
				enable_post_meta:enable_post_meta
			};

			t.ajaxRequest("update_general_settings", data, '#eg-btn-save-global-settings');
		});
	}
	

	/***********************
	* Dialogs
	***********************/

	t.calc_advanced_rows = function(adv){
		if(adv == 'off'){
			jQuery('.columns-adv-rows').hide();
			jQuery('.columns-adv-first').text('');
		}else{
			jQuery('.columns-adv-rows').show();

			var len = jQuery('.columns-adv-head').length;

			//write text in head of columns
			if(len == 0){
				var t = '1';
				t += ',';
				t += 2 + 1 * len;
				t += ',';
				t += 3 + 2 * len;

				jQuery('.columns-adv-first').html("Rows:<br>"+t);

				var new_html = jQuery('.columns-adv-first').html();
				new_html += '<div style="position: absolute;top: 11px;white-space: nowrap;left: 100%;"><a class="button-primary revblue" href="javascript:void(0);" id="eg-add-column-advanced">+</a></div>';
				jQuery('.columns-adv-first').html(new_html);
			}else{
				var t = '1';
				t += ',';
				t += 2 + 1 * len;
				t += ',';
				t += 3 + 2 * len;

				jQuery('.columns-adv-first').html("Rows:<br>"+t);

				for(var i = 0; i < len; i++){
					var t = i + 2;
					t += ',';
					t += i+3 + 1 * len;
					t += ',';
					t += i+4 + 2 * len;

					jQuery('.columns-adv-'+i+'.columns-adv-head').html("Rows:<br>"+t);

					if(i == len - 1){
						var new_html = jQuery('.columns-adv-'+i+'.columns-adv-head').html();
						if(len == 9)
							new_html += '<div style="position: absolute;top: 11px;white-space: nowrap;left: 100%;"><a class="button-primary revblue" href="javascript:void(0);" id="eg-remove-column-advanced">-</a></div>';
						else
							new_html += '<div style="position: absolute;top: 11px;white-space: nowrap;left: 100%;"><a class="button-primary revblue" href="javascript:void(0);" id="eg-add-column-advanced">+</a> <a class="button-primary revblue" href="javascript:void(0);" id="eg-remove-column-advanced">-</a></div>';

						jQuery('.columns-adv-'+i+'.columns-adv-head').html(new_html);
					}
				}
			}
		}
	}


	t.getPagesDialog = function(){

		jQuery("#button-add-pages").click(function(){
			jQuery("#pages-select-dialog-wrap").dialog({
				modal:true,
				resizable:false,
				width:600,
				height:350,
				closeOnEscape:true,
				dialogClass:'wp-dialog',
				buttons:[
					{ text: eg_lang.add_selected, click: function(){
							jQuery('input[name="selected-pages"]').each(function(){
								if(jQuery(this).prop('checked') == true)
									t.insertSelectedPage(jQuery(this).val());
							});

							jQuery(this).dialog("close");
						}
					},
					{ text: eg_lang.close, click: function(){
							jQuery(this).dialog("close");
						}
					}
				],
				create:function () {
					jQuery(this).closest(".ui-dialog")
						.find(".ui-dialog-buttonpane") // the first button
						.addClass("save-wrap");
				},
			});
		});

		jQuery('#check-uncheck-pages').click(function(){
			var do_enable = true;
			if(jQuery(this).attr('checked') != 'checked') do_enable = false;

			jQuery('input[name="selected-pages"]').each(function(){
				jQuery(this).attr('checked', do_enable);
			});
		});

	}




	/***********************
	* Ajax
	***********************/

	t.ajaxRequest = function(action,data,statusElement,successFunction,args){

		var objData = {
			action:"Essential_Grid_request_ajax",
			client_action:action,
			token:token,
			data:data
		}

		if(typeof statusElement !== undefined){
			t.setAjaxLoaderElement(statusElement);
			t.showAjaxLoader();
		}

		jQuery.ajax({
			type:"post",
			url:ajaxurl,
			dataType: 'json',
			data:objData,
			success:function(response){
				t.hideAjaxLoader();

				if(!response){
					t.showErrorMessage(eg_lang.aj_empty_response);
					return(false);
				}

				if(response == -1){
					t.showErrorMessage(eg_lang.aj_ajax_error);
					return(false);
				}

				if(response == 0){
					t.showErrorMessage(eg_lang.aj_error_not_found+': <b>'+action+'</b>');
					return(false);
				}

				if(response.success == undefined){
					t.showErrorMessage(eg_lang.aj_success_must);
					return(false);
				}

				if(response.success == false){
					t.showErrorMessage(response.message);
					return(false);
				}

				//success actions:

				//run a success event function
				if(typeof successFunction == "function")
					successFunction(response,args);

				if(response.message)
					t.showSuccessMessage(response.message);


				//if everything worked and data is not false, check if redirect
				if(response.is_redirect)
					location.href=response.redirect_url;

			},
			error:function(jqXHR, textStatus, errorThrown){
				t.hideAjaxLoader();

				if(textStatus == "parsererror")
					console.log(jqXHR.responseText);

				t.showErrorMessage(eg_lang.aj_ajax_error+" " + textStatus);
			}
		});

	}//ajaxrequest

	/**
	 * show error message or call once custom handler function
	 */
	t.showErrorMessage = function(htmlError, hideOn){
        if(typeof hideOn == undefined) hideOn = "click";

        AdminEssentials.showInfo({content:htmlError, type:"warning", showdelay:0, hidedelay:2, hideon:hideOn, event:"" });
	}

	/**
	 * show success message or call once custom handler function
	 */
	t.showSuccessMessage = function(htmlSuccess){
        AdminEssentials.showInfo({content:htmlSuccess, type:"success", showdelay:0, hidedelay:2, hideon:"", event:"" });
	}

	/**
	 * show success message or call once custom handler function
	 */
	t.showInfoMessage = function(htmlInfo){
        AdminEssentials.showInfo({content:htmlInfo, type:"info", showdelay:0, hidedelay:2, hideon:"", event:"" });
	}

	/**
	 * set ajax loader class that will be shown, and hidden on ajax request
	 * this loader will be shown only once, and then need to be sent again.
	 */
	t.setAjaxLoaderElement = function(newClass){
		ajaxLoaderElement = newClass;
	}

	t.showWaitAMinute = function(obj) {
		var wm = jQuery('#waitaminute');		
		// SHOW AND HIDE WITH DELAY
		if (obj.delay!=undefined) {

			punchgs.TweenLite.to(wm,0.3,{autoAlpha:1,ease:punchgs.Power3.easeInOut});
			punchgs.TweenLite.set(wm,{display:"block"});
			
			setTimeout(function() {
				punchgs.TweenLite.to(wm,0.3,{autoAlpha:0,ease:punchgs.Power3.easeInOut,onComplete:function() {
					punchgs.TweenLite.set(wm,{display:"block"});	
				}});  			
			},obj.delay)
		}

		// SHOW IT
		if (obj.fadeIn != undefined) {
			punchgs.TweenLite.to(wm,obj.fadeIn/1000,{autoAlpha:1,ease:punchgs.Power3.easeInOut});
			punchgs.TweenLite.set(wm,{display:"block"});			
		}

		// HIDE IT
		if (obj.fadeOut != undefined) {

			punchgs.TweenLite.to(wm,obj.fadeOut/1000,{autoAlpha:0,ease:punchgs.Power3.easeInOut,onComplete:function() {
					punchgs.TweenLite.set(wm,{display:"block"});	
				}});  
		}

		// CHANGE TEXT
		if (obj.text != undefined) {
			switch (obj.text) {
				case "progress1":

				break;
				default:					
					wm.html('<div class="waitaminute-message"><i class="eg-icon-coffee"></i><br>'+obj.text+'</div>');
				break;	
			}
		}
	}


	/**
	 * show loader on ajax actions
	 */
	t.showAjaxLoader = function(){
		/*if(ajaxLoaderElement){
			jQuery(ajaxLoaderElement).hide();
			jQuery(ajaxLoaderElement).parent().append('<div class="ajax-loading-wrap">'+eg_lang.aj_please_wait+'</div>');
		}*/
		t.showWaitAMinute({fadeIn:300,text:eg_lang.aj_please_wait});
	}

	/**
	 * init Side Buttons
	 */
	t.initSideButtons = function(i) {
		punchgs.TweenLite.fromTo(jQuery('#eg-tool-panel'),0.5,{autoAlpha:0,x:40},{autoAlpha:1,x:0,ease:punchgs.Power3.easeInOut,delay:3});

		jQuery.each(jQuery('.eg-side-buttons'),function(ind,elem) {
			punchgs.TweenLite.fromTo(elem,0.5,{x:40},{x:0,ease:punchgs.Power3.easeInOut,delay:4+(ind*0.3)});
		})

		jQuery('.eg-side-buttons').hover(function() {
					punchgs.TweenLite.to(jQuery(this),0.3,{x:-110,ease:punchgs.Power3.easeInOut});
				},
				function() {
					punchgs.TweenLite.to(jQuery(this),0.3,{x:0,ease:punchgs.Power3.easeInOut});
				})

	}

	/**
	 * hide and remove ajax loader. next time has to be set again before "ajaxRequest" function.
	 */
	t.hideAjaxLoader = function(){
		if(ajaxLoaderElement){
			/*jQuery(ajaxLoaderElement).show();

			jQuery(".ajax-loading-wrap").each(function(){
                jQuery(this).remove();
            });*/
            t.showWaitAMinute({fadeOut:300});

			ajaxLoaderElement = null;
		}
	}

	t.initSmallMenu = function() {

		jQuery('.eg-lc-vertical-menu li').each(function(){
			var li = jQuery(this);
			li.click(function() {
				jQuery('.eg-lc-vertical-menu .selected-lc-setting').removeClass('selected-lc-setting');
				li.addClass('selected-lc-setting');

				var aes = jQuery('.eg-lc-menu-wrapper .active-esc')
				var newaes=jQuery('#'+li.data('toshow'));

				punchgs.TweenLite.to(aes,0.1,{autoAlpha:0});
				aes.removeClass("active-esc");

				punchgs.TweenLite.fromTo(newaes,0.3,{autoAlpha:0},{autoAlpha:1,overwrite:"all"});
				newaes.addClass("active-esc");
				setTimeout(t.interResizeSettings,10);
			})
		})


		jQuery('.eg-small-vertical-menu li').each(function(){
			var li = jQuery(this);
			li.click(function() {
				jQuery('.eg-small-vertical-menu .selected-el-setting').removeClass('selected-el-setting');
				li.addClass('selected-el-setting');

				var aes = jQuery('#eg-element-style .active-esc')
				var newaes=jQuery('#'+li.data('toshow'));

				punchgs.TweenLite.to(aes,0.1,{autoAlpha:0});
				aes.removeClass("active-esc");

				punchgs.TweenLite.fromTo(newaes,0.3,{autoAlpha:0},{autoAlpha:1,overwrite:"all"});
				newaes.addClass("active-esc");
				setTimeout(t.interResizeSettings,10);
			})
		})


	}


	t.initTabSizes = function() {
		jQuery('#eg-create-settings-menu li').each(function(){
			var li = jQuery(this);
			li.click(function() {
				jQuery('#eg-create-settings-menu .selected-esg-setting').removeClass('selected-esg-setting');
				li.addClass('selected-esg-setting');

				var aes = jQuery('.active-esc')
				var newaes=jQuery('#'+li.data('toshow'));

				punchgs.TweenLite.to(aes,0.1,{autoAlpha:0});
				aes.removeClass("active-esc");

				punchgs.TweenLite.fromTo(newaes,0.3,{autoAlpha:0},{autoAlpha:1,overwrite:"all"});
				newaes.addClass("active-esc");
				setTimeout(t.interResizeSettings,10);
				t.recalcSlidersPos();

				if(li.data('toshow') == 'esg-settings-skins-settings')
					jQuery('#esg-grid-even-1').esredraw();

				eg_codemirror_api_js.refresh();
				eg_codemirror_ajax_css.refresh();
			})
		});
		t.interResizeSettings();
		jQuery(window).resize(t.interResizeSettings);

		jQuery('#eg-create-settings-wrap').click(t.interResizeSettings);
	}

	t.interResizeSettings = function () {
		var ecsw = jQuery('#eg-create-settings-wrap');

		ecsw.find('.esg-settings-container').each(function(i) {
			var esc = jQuery(this);
			esc.width(jQuery('#eg-create-settings-wrap').width()-80);
		});

		punchgs.TweenLite.to(ecsw,0.3,{height:ecsw.find('.esg-settings-container.active-esc').outerHeight()+15,overwrite:"all"});

		ecsw.find('.ui-slider').each(function() {
			var uis = jQuery(this);
			var neww = parseInt(uis.find('.ui-slider-handle').css('left'),0);
			uis.find('.eg-pre-slider').css({width:neww});
		});

	}

	/********************************************************
		-	CALL ON CHANGE (SELECTOR AND CALL FUNCTION	-
	********************************************************/
	t.callOnChange = function( selector, call, delay, param1, param2) {

		jQuery(selector).find('input').each(function() {
			var input = jQuery(this);
			input.on("change",function() {
				call(param1,param2);
			});

			if (input.attr('type')=="hidden") {
				input.data('oldval',input.val());

				setInterval(function() {
					if (input.data('oldval')!=input.val()) {
						input.data('oldval',input.val());
						call(param1,param2);
					}
				},200)
			}
		})

		jQuery(selector).find('textarea').each(function() {
			var input = jQuery(this);
			input.data('oldval',input.val());

				setInterval(function() {
					if (input.data('oldval')!=input.val()) {
						input.data('oldval',input.val());
						call(param1,param2);
					}
				},200);
		})

		jQuery(selector).find('.ui-slider-handle').each(function() {
			var han = jQuery(this);

			han.on("mousedown",function() {
				han.data('pos',han.position().left);
				han.addClass("youaredown");
				clearInterval(han.data("timer"));
				han.data('timer',setInterval(function() {

					if (han.data('pos')!=han.position().left) {
						han.data('pos',han.position().left);
						call(param1,param2);
					}
				},delay));
			});

		});

		jQuery('body').on("mouseup",function() {
				jQuery(selector).find('.ui-slider-handle').each(function() {
					var han = jQuery(this);
					clearInterval(han.data("timer"));
				});
		});

		jQuery(selector).find('select').each(function() {
			var input = jQuery(this);
			input.on("change",function() {
				var sf = jQuery(this).parent().find('.select_fake');

				if (sf.length) {
					var cont = jQuery(this).find('option:selected').text()

					sf.find('span').html(cont);
				}
				call(param1,param2);

			});
		});


	}

	/******************************
		-	GET BASIC GRID VALUES	-
	********************************/

	t.getBasicEntries = function() {
		var colwidths = jQuery('input[name="columns-width[]"]');
		var cols = jQuery('input[name="columns[]"]');
		var basicEntries = new Array();

		jQuery.each(cols,function(index) {
			var obj = new Object();
			obj.width = parseInt(colwidths[index].value,0);
			obj.amount = parseInt(cols[index].value,0);
			basicEntries.push(obj);
		});

		return basicEntries;
	}

	t.getMultipleEntries = function() {

	  if (jQuery('input[name="columns-advanced"]:checked').val() == "on") {
			var multipleentries = new Array();
			var cols = jQuery('input[name="columns[]"]');
			var elar = new Array();
			jQuery.each(cols,function(index) {
				elar.push(parseInt(cols[index].value,0));
			});
			multipleentries.push(elar);

			for (var i=0; i<11;i++) {
				var cols = jQuery('input[name="columns-advanced-rows-'+i+'[]"]');
				if (cols!=undefined && cols.length>0) {

					var elar = new Array();
					jQuery.each(cols,function(index) {
						elar.push(parseInt(cols[index].value,0));
					});
					multipleentries.push(elar);
				}
			}
			return multipleentries;
	   }

	   else

	   return [];

	}

	/******************************
		-	CREATE A PREVIEW GRID	-
	********************************/

	t.buildGridPreview = function() {
		var custom_grid = false;
		var data = {
				name: 'gridform',
				handle: 'gridform', //is alias
				postparams: t.getFormParams('eg-form-create-posts'),
				params: t.getFormParams('eg-form-create-settings')
			};

		data.params['navigation-layout'] = t.get_navigation_layout();

		data.params['css-id'] = jQuery('#esg-id-value').val();

		data.id = jQuery('input[name="eg-id"]').val();


		if(jQuery('input[name="source-type"]:checked').val() == 'custom')
			custom_grid = true;

		if(custom_grid){
			var custom_layers = t.getFormParams('eg-custom-elements-form-wrap', true); //ignore empty values
			data.layers = (typeof custom_layers['layers'] !== 'undefined') ? custom_layers['layers'] : [];
		}
		/*  //TP: CHUNK
		*/

		jQuery('body').append('<div id="esg-preview-clone" style="display: none;"></div>');
		jQuery('#esg-preview-wrapper').clone(true).appendTo('#esg-preview-clone');

		jQuery('.eg-remove-on-reload').remove(); //remove initial input fields with starting data
		jQuery('.esg-new-temp-layer').remove(); //remove afterwards pushed input field with new entry data

		try{jQuery('#esg-preview-grid').esskill();} catch(e) { console.log("e:"+e)}
		jQuery('#esg-preview-wrapper').remove();

		jQuery('#esg-preview-wrapping-wrapper').append('<div id="esg-preview-wrapper"></div>');
		/* //TP: CHUNK
		if(custom_grid){
			var chunk = 25;
			var chunk_layers = [];
			var temp_layers = [];
			var layers_html = [];
			if(data.layers.length > chunk){ //split the ajax requests into x / 25 parts

				for (var i = 0; i < data.layers.length; i += chunk) {
					temp_layers = data.layers.slice(i, i + chunk);
					chunk_layers.push(temp_layers);
				}

				chunk_layers.reverse();

				var ajaxReqs = [];

				for(var key in chunk_layers){
					data.layers = chunk_layers[key];

					var objData = {
						action:"Essential_Grid_request_ajax",
						client_action:"get_preview_html_markup_chunk",
						order_id:key,
						token:token,
						data:data
					}

					ajaxReqs.push(
						jQuery.ajax({
							type:"post",
							url:ajaxurl,
							dataType: 'json',
							data:objData,
							success:function(response){

								if(!response){
									t.showErrorMessage(eg_lang.aj_empty_response);
									return(false);
								}

								if(response == -1){
									t.showErrorMessage(eg_lang.aj_ajax_error);
									return(false);
								}

								if(response == 0){
									t.showErrorMessage(eg_lang.aj_error_not_found+': <b>'+action+'</b>');
									return(false);
								}

								if(response.success == undefined){
									t.showErrorMessage(eg_lang.aj_success_must);
									return(false);
								}

								if(response.success == false){
									t.showErrorMessage(response.message);
									return(false);
								}

								//success actions:

								//run a success event function
								if(typeof successFunction == "function")
									successFunction(response,args);

								if(response.message)
									t.showSuccessMessage(response.message);


								//if everything worked and data is not false, check if redirect
								if(response.is_redirect)
									location.href=response.redirect_url;

								layers_html[response.data.order_id] = response.data.preview;
							},
							error:function(jqXHR, textStatus, errorThrown){

								if(textStatus == "parsererror")
									console.log(jqXHR.responseText);

								t.showErrorMessage(eg_lang.aj_ajax_error+" " + textStatus);
							}
						})
					);
				}

				data.layers = []; //reset to empty layers, to get only the html wrap structure
			}
		} */

		t.ajaxRequest("get_preview_html_markup", data, '#eg-grid-layout-wrapper,#eg-grid-skin-wrapper,.esg-refresh-preview-button,#esg-source-choose-wrapper,.ui-dialog-buttonset',function(response){
			var restore_previous = false;
			if(typeof(response.error) != 'undefined'){ //add last state again and say something about it
				alert(response.error);
				alert(eg_lang.script_will_try_to_load_last_working);

				restore_previous = true;

				jQuery('#esg-preview-clone').children().appendTo('#esg-preview-wrapper');

				//jQuery('#esg-preview-wrapper').html(temp_preview);

			}else{
				jQuery('#esg-preview-wrapper').append(response.data.html);
			}
			jQuery('#esg-preview-clone').remove();
			if(jQuery('input[name="source-type"]:checked').val() == 'custom'){
				if(!restore_previous){
					jQuery('#esg-template-wrapper').html(response.data.preview);
					jQuery("#esg-preview-grid ul").sortable({ //start the sorting
						start: function(){
							espprevrevapi.esquickdraw();
						},
						stop: function(){
							t.resetCustomItemValues();
							espprevrevapi.esquickdraw();
						},
						change: function(){
							t.changePreviewGrid();
						},
						placeholder: false,
						helper: 'original',
						cancel: '.ui-state-disabled'
					});
					jQuery("#esg-preview-grid ul").disableSelection();
				}else{
					//jQuery('#esg-template-wrapper').html(temp_preview);

					jQuery('window').trigger('resize');
					//espprevrevapi.esquickdraw();
				}
			}
			
			if(!restore_previous){
				var rim = new Array();
				if (data.params["columns-advanced-rows-0"] != undefined && data.params["columns-advanced"]=="on") {
					rim.push(data.params["columns"]);
					for (var i = 0;i<10;i++) {
						if (data.params["columns-advanced-rows-"+i] != undefined)
							rim.push(data.params["columns-advanced-rows-"+i])
					}
				}

				var rows = jQuery('input[name="rows"]').val();
				var basicEntries = t.getBasicEntries();
				var multipleEntries = t.getMultipleEntries();

				if (jQuery('input[name="rows-unlimited"]:checked').val()=="on") rows=9999;

				/* //TP: CHUNK
				if(custom_grid){
					jQuery.when.apply(jQuery, ajaxReqs).done(function(){

						for(var key in layers_html){
							jQuery('#esg-preview-wrapper ul').prepend(layers_html[key]);
						}

						espprevrevapi = jQuery('#esg-preview-grid').tpessential({

							layout:jQuery('input[name="layout"]:checked').val(),
							forceFullWidth:"off",

							row:rows,
							space:jQuery('input[name="spacings"]').val(),

							pageAnimation:jQuery('#grid-animation-select').val(),

							animSpeed:jQuery('input[name="grid-animation-speed"]').val(),
							animDelay:"on",
							delayBasic:jQuery('input[name="grid-animation-delay"]').val(),

							aspectratio:jQuery('input[name="x-ratio"]').val()+":"+jQuery('input[name="y-ratio"]').val(),
							rowItemMultiplier : rim,
							responsiveEntries: basicEntries

						});

						t.resetCustomItemValues();
						t.initToolTipser();

						// TWO OBJECT FOR SAVING ALL KIND OF INFORMATIONS OF GRID
						espprevrevapi.settings = new Object();
						espprevrevapi.standards = new Object();

						// SAVE GRID SETTINGS
						espprevrevapi.settings.layout=jQuery('input[name="layout"]:checked').val();
						espprevrevapi.settings.forceFullWidth="off";
						espprevrevapi.settings.row=rows;
						espprevrevapi.settings.space=jQuery('input[name="spacings"]').val();
						espprevrevapi.settings.pageAnimation=jQuery('select [name="grid-animation"]').val();
						espprevrevapi.settings.animSpeed=jQuery('input[name="grid-animation-speed"]').val();
						espprevrevapi.settings.animDelay="on";
						espprevrevapi.settings.delayBasic=jQuery('input[name="grid-animation-delay"]').val();
						espprevrevapi.settings.aspectratio=jQuery('input[name="x-ratio"]').val()+":"+jQuery('input[name="y-ratio"]').val();
						espprevrevapi.settings.responsiveEntries=basicEntries;
						espprevrevapi.settings.rowItemMultiplier=multipleEntries;
						espprevrevapi.settings.filterskin =jQuery('#navigation-skin-select').val();
						espprevrevapi.settings.skin = jQuery('input[name="entry-skin"]:checked').val();

					});
				}else{ */

					var cobbles_pattern = '';
					if(jQuery('input[name="use-cobbles-pattern"]:checked').val() == 'on'){
						jQuery('select[name="cobbles-pattern[]"]').each(function(){
							if(cobbles_pattern !== '') cobbles_pattern += ',';
							cobbles_pattern += jQuery(this).find('option:selected').val();
						});
					}

					var smart_pagination = 'on';
					if(jQuery('input[name="pagination-numbers"]:checked').val() == 'full')
						smart_pagination = 'off';
						
					espprevrevapi = jQuery('#esg-preview-grid').tpessential({

						layout:jQuery('input[name="layout"]:checked').val(),
						forceFullWidth:"off",
						
						smartPagination:smart_pagination,
						cobblesPattern:cobbles_pattern,
						row:rows,
						space:jQuery('input[name="spacings"]').val(),

						pageAnimation:jQuery('#grid-animation-select').val(),

						animSpeed:jQuery('input[name="grid-animation-speed"]').val(),
						animDelay:"on",
						delayBasic:jQuery('input[name="grid-animation-delay"]').val(),

						aspectratio:jQuery('input[name="x-ratio"]').val()+":"+jQuery('input[name="y-ratio"]').val(),
						rowItemMultiplier : rim,
						responsiveEntries: basicEntries

					});


					t.resetCustomItemValues();
					t.initToolTipser();

					// TWO OBJECT FOR SAVING ALL KIND OF INFORMATIONS OF GRID
					espprevrevapi.settings = new Object();
					espprevrevapi.standards = new Object();

					// SAVE GRID SETTINGS
					espprevrevapi.settings.layout=jQuery('input[name="layout"]:checked').val();
					espprevrevapi.settings.forceFullWidth="off";
					espprevrevapi.settings.row=rows;
					espprevrevapi.settings.smartPagination=smart_pagination;
					espprevrevapi.settings.space=jQuery('input[name="spacings"]').val();
					espprevrevapi.settings.pageAnimation=jQuery('select [name="grid-animation"]').val();
					espprevrevapi.settings.animSpeed=jQuery('input[name="grid-animation-speed"]').val();
					espprevrevapi.settings.animDelay="on";
					espprevrevapi.settings.delayBasic=jQuery('input[name="grid-animation-delay"]').val();
					espprevrevapi.settings.aspectratio=jQuery('input[name="x-ratio"]').val()+":"+jQuery('input[name="y-ratio"]').val();
					espprevrevapi.settings.responsiveEntries=basicEntries;
					espprevrevapi.settings.rowItemMultiplier=multipleEntries;
					espprevrevapi.settings.filterskin =jQuery('#navigation-skin-select').val();
					espprevrevapi.settings.skin = jQuery('input[name="entry-skin"]:checked').val();

				//} //TP: CHUNK
			}
		});

	}


	t.createPreviewGrid = function() {

		t.buildGridPreview();

		// START THE ROUTINE TO CHECK IF ANY INPUT FIELDS HAS BEEN CHANGED !
		t.callOnChange( '#eg-form-create-settings', t.changePreviewGrid, 100);

		jQuery('.esg-refresh-preview-button').click(function() {
			t.changePreviewGrid(true);
		})
		//t.changePreviewGrid(esprevapi);
	}


	/***********************************************
		-	CHANGE GRID BASED ON NEW SETTINGS	-
	***********************************************/
	t.changePreviewGrid = function(rebuild) {

		if( typeof espprevrevapi !== 'undefined'){
			clearTimeout(espprevrevapi.timeout);

			jQuery('#eg-live-preview-wrap').css({background:jQuery('input[name="main-background-color"]').val()});

			espprevrevapi.timeout = setTimeout(function() {

				// CHANGE SKIN CLASS
				jQuery('#esg-preview-skinlevel').attr('class','myportfolio-container fullwidthcontainer-with-padding').addClass(jQuery('#navigation-skin-select').val());

				// COLLECT ALL GRID BASED OPTIONS, AND COMPARE THEM
				var basicEntries = t.getBasicEntries();
				var multipleEntries = t.getMultipleEntries();
				var smart_pagination = 'on';
				if(jQuery('input[name="pagination-numbers"]:checked').val() == 'full')
					smart_pagination = 'off';
						
				var settings = new Object();
				settings.layout=jQuery('input[name="layout"]:checked').val();
				settings.forceFullWidth="on";
				settings.row=jQuery('input[name="rows"]').val();
				if (jQuery('input[name="rows-unlimited"]:checked').val()=="on") settings.row=9999;
				settings.space=jQuery('input[name="spacings"]').val();
				settings.smartPagination=smart_pagination;
				settings.pageAnimation=jQuery('#grid-animation-select').val();
				settings.animSpeed=jQuery('input[name="grid-animation-speed"]').val();
				settings.animDelay="on";
				settings.delayBasic=jQuery('input[name="grid-animation-delay"]').val();
				settings.aspectratio=jQuery('input[name="x-ratio"]').val()+":"+jQuery('input[name="y-ratio"]').val();
				settings.responsiveEntries=basicEntries;
				settings.rowItemMultiplier=multipleEntries;
				settings.skin = jQuery('input[name="entry-skin"]:checked').val();
				settings.rtl = jQuery('input[name="rtl"]:checked').val();

				var different = false;
				var difkey = new Array();

				// COMPARE VALUES OF GRID SETTINGS
				jQuery.each(settings, function(key,index) {
					if (key!="responsiveEntries" && (settings[key] != espprevrevapi.settings[key])) {
						different = true;
						difkey.push(key);
					}
				})
				// COMPARE RESPONSIVE VALUES
				jQuery.each(settings.responsiveEntries,function(index,obj) {
					if (obj.width != espprevrevapi.settings.responsiveEntries[index].width ||
						obj.amount != espprevrevapi.settings.responsiveEntries[index].amount) {
						different = true;
						difkey.push("responsiveEntries");
					}
				})


				if (settings.skin != espprevrevapi.settings.skin || settings.layout != espprevrevapi.settings.layout || rebuild==true) {
					// SAVE NEW SETTINGS

					jQuery.extend(espprevrevapi.settings,settings);
					t.buildGridPreview();
					different = false;
				} else {

					// SAVE NEW SETTINGS
					jQuery.extend(espprevrevapi.settings,settings);
				}

				// IF DIFFERENT, REDRAW GRID
				if (different)  {

					espprevrevapi.esredraw({
						aspectratio:espprevrevapi.settings.aspectratio,
						space:espprevrevapi.settings.space,
						row:espprevrevapi.settings.row,
						pageAnimation:espprevrevapi.settings.pageAnimation,
						smartPagination:espprevrevapi.settings.smartPagination,
						animSpeed:espprevrevapi.settings.animSpeed,
						animDelay:"on",
						rtl:settings.rtl,
						responsiveEntries:espprevrevapi.settings.responsiveEntries,
						delayBasic:espprevrevapi.settings.delayBasic,
						silent:false,
						changedAnim:"pageanim",
						rowItemMultiplier:espprevrevapi.settings.rowItemMultiplier

					});

					t.resetCustomItemValues();

					setTimeout(function() {
						var btns = jQuery('.esg-navigationbutton.esg-filterbutton.esg-pagination-button ');
						if (difkey[0]=="pageAnimation" || difkey[0] == "animSpeed" || difkey[0] == "delayBasic") {
							if (jQuery(btns[0]).hasClass("selected"))
								try{btns[1].click()} catch(e) { }
						}
						setTimeout(function() {
							if (btns != undefined && btns.length>0) btns[0].click();
						},250);
					 },250);

				}

				t.initToolTipser();

			},100);
		}
	}


	/******************************
		-	REMOVE A PREVIEW GRID	-
	********************************/
	t.removePreviewGrid = function() {

	}


	/******************************************************
		-	ANIMATE ELEMENTS FOR SKIN EDITOR PREVIEW	-
	*******************************************************/

	t.animateElements = function(direction) {

	  // PREPARE THE HOVER ANIMATIONS
	  if (esgAnimmatrix == null)
	     var esgAnimmatrix = [
	  						['.esg-none',				0, {autoAlpha:1,rotationZ:0,x:0,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0},{autoAlpha:1,ease:punchgs.Power2.easeOut, overwrite:"all"}, 0, {autoAlpha:1,overwrite:"all"} ],

	    					['.esg-fade',				0.3, {autoAlpha:0,rotationZ:0,x:0,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0},{autoAlpha:1,ease:punchgs.Power2.easeOut, overwrite:"all"}, 0.3, {autoAlpha:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
	    					['.esg-fadeout',			0.3, {autoAlpha:1,ease:punchgs.Power2.easeOut, overwrite:"all"}, {autoAlpha:0,rotationZ:0,x:0,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0}, 0.3, {autoAlpha:1,rotationZ:0,x:0,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0,ease:punchgs.Power2.easeOut,overwrite:"all"}],

							['.esg-covergrowup',		0.3, {autoAlpha:1,top:"100%",marginTop:-10,rotationZ:0,x:0,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0},{autoAlpha:1,top:"0%", marginTop:0, ease:punchgs.Power2.easeOut, overwrite:"all"}, 0.3, {autoAlpha:1,top:"100%",marginTop:-10,bottom:0,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ,true],



				 			['.esg-flipvertical',		0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,rotationX:180,autoAlpha:0,z:-0.001,transformOrigin:"50% 50%"}, {rotationX:0,autoAlpha:1,scale:1,z:0.001,ease:punchgs.Power3.easeInOut,overwrite:"all"} , 0.5,{rotationX:180,autoAlpha:0,scale:1,z:-0.001,ease:punchgs.Power3.easeInOut,overwrite:"all"} ,true],
			 				['.esg-flipverticalout',	0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,rotationX:0,autoAlpha:1,z:0.001,transformOrigin:"50% 50%"},{rotationX:-180,scale:1,autoAlpha:0,z:-150,ease:punchgs.Power3.easeInOut,overwrite:"all"} ,0.5,{rotationX:0,autoAlpha:1,scale:1,z:0,ease:punchgs.Power3.easeInOut,overwrite:"all"} ],

			 				['.esg-fliphorizontal',		0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,rotationY:180,autoAlpha:0,z:-0.001,transformOrigin:"50% 50%"}, {rotationY:0,autoAlpha:1,scale:1,z:0.001,ease:punchgs.Power3.easeInOut,overwrite:"all"} , 0.5, {rotationY:180,autoAlpha:0,scale:1,z:-0.001,ease:punchgs.Power3.easeInOut,overwrite:"all"} ,true],
				 			['.esg-fliphorizontalout',	0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,z:0.001,transformOrigin:"50% 50%"}, {rotationY:-180,scale:1,autoAlpha:0,z:-150,ease:punchgs.Power3.easeInOut,overwrite:"all"} , 0.5, {rotationY:0,autoAlpha:1,scale:1,z:0.001,ease:punchgs.Power3.easeInOut,overwrite:"all"} ],

			 				['.esg-flipup',				0.5, {x:0,y:0,scale:0.8,rotationZ:0,rotationX:90,rotationY:0,skewX:0,skewY:0,autoAlpha:0,z:0.001,transformOrigin:"50% 100%"}, {scale:1,rotationX:0,autoAlpha:1,z:0.001,ease:punchgs.Power2.easeOut,overwrite:"all"} , 0.3, {scale:0.8,rotationX:90,autoAlpha:0,z:0.001,ease:punchgs.Power2.easeOut,overwrite:"all"} ,true],
			 				['.esg-flipupout',			0.5, {rotationX:0,autoAlpha:1,y:0,ease:punchgs.Bounce.easeOut,overwrite:"all"} ,{x:0,y:0,scale:1,rotationZ:0,rotationX:-90,rotationY:0,skewX:0,skewY:0,autoAlpha:1,z:0.001,transformOrigin:"50% 0%"} , 0.3, {rotationX:0,autoAlpha:1,y:0,ease:punchgs.Bounce.easeOut,overwrite:"all"} ],


			 				['.esg-flipdown',			0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:-90,rotationY:0,skewX:0,skewY:0,autoAlpha:0,z:0.001,transformOrigin:"50% 0%"},{rotationX:0,autoAlpha:1,y:0,ease:punchgs.Bounce.easeOut,overwrite:"all"} ,0.3, {rotationX:-90,z:0,ease:punchgs.Power2.easeOut,autoAlpha:0,overwrite:"all"},true ],
			 				['.esg-flipdownout',		0.5, {scale:1,rotationX:0,autoAlpha:1,z:0.001,ease:punchgs.Power2.easeOut,overwrite:"all"}, {x:0,y:0,scale:0.8,rotationZ:0,rotationX:90,rotationY:0,skewX:0,skewY:0,autoAlpha:0,z:0.001,transformOrigin:"50% 100%"}, 0.3, {scale:1,rotationX:0,autoAlpha:1,z:0.001,ease:punchgs.Power2.easeOut,overwrite:"all"} ],

			 				['.esg-flipright',			0.5, {x:0,y:0,scale:0.8,rotationZ:0,rotationX:0,rotationY:90,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"0% 50%"},{scale:1,rotationY:0,autoAlpha:1,ease:punchgs.Power2.easeOut,overwrite:"all"} ,0.3,{autoAlpha:0,scale:0.8,rotationY:90,ease:punchgs.Power3.easeOut,overwrite:"all"} ,true],
			 				['.esg-fliprightout',		0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,rotationY:0,autoAlpha:1,transformOrigin:"100% 50%"},{scale:1,rotationY:-90,autoAlpha:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ,0.3,{scale:1,z:0,rotationY:0,autoAlpha:1,ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-flipleft',			0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:-90,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"100% 50%"},{rotationY:0,autoAlpha:1,z:0.001,scale:1,ease:punchgs.Power3.easeOut,overwrite:"all"} ,0.3,{autoAlpha:0,rotationY:-90,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ,true],
			 				['.esg-flipleftout',		0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,rotationY:0,autoAlpha:1,transformOrigin:"0% 50%"},{scale:1,rotationY:90,autoAlpha:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ,0.3,{scale:1,z:0,rotationY:0,autoAlpha:1,ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-turn',				0.5, {x:50,y:0,scale:0,rotationZ:0,rotationX:0,rotationY:-40,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{scale:1,x:0,rotationY:0,autoAlpha:1,ease:punchgs.Power3.easeInOut,overwrite:"all"} ,0.3,{scale:0,rotationY:-40,autoAlpha:1,z:0,x:50,ease:punchgs.Power3.easeInOut,overwrite:"all"} ,true],
			 				['.esg-turnout',			0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{scale:1,rotationY:40,scale:0.6,autoAlpha:0,x:-50,ease:punchgs.Power3.easeInOut,overwrite:"all"} ,0.3,{scale:1,rotationY:0,z:0,autoAlpha:1,x:0, rotationX:0, rotationZ:0, ease:punchgs.Power3.easeInOut,overwrite:"all"} ],

			 				['.esg-slide',				0.5, {x:-10000,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{autoAlpha:1,x:0, y:0,ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:1,x:-10000,y:0,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-slideout',			0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{autoAlpha:1,x:0, y:0,ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:1,x:0,y:0,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],

			 				['.esg-slideright',			0.5, {xPercent:-50,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,xPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,xPercent:-50,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-sliderightout',		0.5, {autoAlpha:1,xPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"},{xPercent:50,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,xPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-scaleleft',			0.5, {x:0,y:0,scaleX:0,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"100% 50%"},{autoAlpha:1,x:0, scaleX:1, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:1,x:0,z:0,scaleX:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-scaleright',			0.5, {x:0,y:0,scaleX:0,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"0% 50%"},{autoAlpha:1,x:0, scaleX:1, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:1,x:0,z:0,scaleX:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],

			 				['.esg-slideleft',			0.5, {xPercent:50,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,xPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,xPercent:50,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-slideleftout',		0.5, {autoAlpha:1,xPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"},{xPercent:-50,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,xPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"}],

			 				['.esg-slideup',			0.5, {x:0,yPercent:50,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,yPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,yPercent:50,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-slideupout',			0.5, {autoAlpha:1,yPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"},{x:0,yPercent:-50,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,yPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-slidedown',			0.5, {x:0,yPercent:-50,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,yPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,yPercent:-50,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-slidedownout',		0.5, {autoAlpha:1,yPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"},{x:0,yPercent:50,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,yPercent:0, ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-slideshortright',	0.5, {x:-30,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,x:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,x:-30,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-slideshortrightout',	0.5, {autoAlpha:1,x:0, ease:punchgs.Power3.easeOut,overwrite:"all"},{x:30,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,x:30, ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-slideshortleft',		0.5, {x:30,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,x:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,x:30,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-slideshortleftout',	0.5, {autoAlpha:1,x:0, ease:punchgs.Power3.easeOut,overwrite:"all"},{x:-30,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,x:0, ease:punchgs.Power3.easeOut,overwrite:"all"}],

			 				['.esg-slideshortup',		0.5, {x:0,y:30,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,y:30,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-slideshortupout',	0.5, {autoAlpha:1,y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},{x:0,y:-30,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,y:0, ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-slideshortdown',		0.5, {x:0,y:-30,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,y:-30,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-slideshortdownout',	0.5, {autoAlpha:1,y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},{x:0,y:30,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,y:0, ease:punchgs.Power3.easeOut,overwrite:"all"} ],


			 				['.esg-skewright',			0.5, {xPercent:-100,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:60,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,xPercent:0, skewX:0,ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,skewX:-60,xPercent:-100,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-skewrightout',		0.5, {autoAlpha:1,xPercent:0, skewX:0,ease:punchgs.Power3.easeOut,overwrite:"all"},{xPercent:100,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:-60,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,xPercent:0, skewX:0,ease:punchgs.Power3.easeOut,overwrite:"all"}],

			 				['.esg-skewleft',			0.5, {xPercent:100,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:-60,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,xPercent:0, skewX:0,ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,xPercent:100,z:0,skewX:60,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-skewleftout',		0.5, {autoAlpha:1,xPercent:0, skewX:0,ease:punchgs.Power3.easeOut,overwrite:"all"},{xPercent:-100,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:60,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,xPercent:0, skewX:0,ease:punchgs.Power3.easeOut,overwrite:"all"}],

			 				['.esg-shifttotop',			0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{autoAlpha:1,y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:1,y:0,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],

			 				['.esg-rollleft',			0.5, {xPercent:50,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,rotationZ:90,transformOrigin:"50% 50%"},{autoAlpha:1,xPercent:0, rotationZ:0,ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,xPercent:50,z:0,rotationZ:90,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-rollleftout',		0.5, {autoAlpha:1,xPercent:0, rotationZ:0,ease:punchgs.Power3.easeOut,overwrite:"all"},{xPercent:50,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,rotationZ:90,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,xPercent:0, rotationZ:0,ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-rollright',			0.5, {xPercent:-50,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,rotationZ:-90,transformOrigin:"50% 50%"},{autoAlpha:1,xPercent:0, rotationZ:0,ease:punchgs.Power3.easeOut,overwrite:"all"},0.3,{autoAlpha:0,xPercent:-50,rotationZ:-90,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-rollrightout',		0.5, {autoAlpha:1,xPercent:0, rotationZ:0,ease:punchgs.Power3.easeOut,overwrite:"all"},{xPercent:-50,y:0,scale:1,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,rotationZ:-90,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,xPercent:0, rotationZ:0,ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-falldown',			0.4, {x:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0, yPercent:-100},{autoAlpha:1,yPercent:0,ease:punchgs.Power3.easeOut,overwrite:"all"},0.4,{yPercent:-100,autoAlpha:0,z:0,ease:punchgs.Power2.easeOut,delay:0.2,overwrite:"all"} ],
			 				['.esg-falldownout',		0.4, {autoAlpha:1,yPercent:0,ease:punchgs.Back.easeOut,overwrite:"all"},{x:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0, yPercent:100},0.4,{autoAlpha:1,yPercent:0,ease:punchgs.Power3.easeOut,overwrite:"all"} ],

			 				['.esg-rotatescale',		0.3, {x:0,y:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,rotationZ:80,scale:0.6,transformOrigin:"50% 50%"},{autoAlpha:1,scale:1,rotationZ:0,ease:punchgs.Back.easeOut,overwrite:"all"},0.3,{autoAlpha:0,scale:0.6,z:0,rotationZ:80,ease:punchgs.Power2.easeOut,overwrite:"all"}],
			 				['.esg-rotatescaleout',		0.3, {autoAlpha:1,scale:1,rotationZ:0,ease:punchgs.Back.easeOut,overwrite:"all"},{x:0,y:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,rotationZ:80,scale:0.6,transformOrigin:"50% 50%"},0.3,{autoAlpha:1,scale:1,rotationZ:0,ease:punchgs.Back.easeOut,overwrite:"all"}],

			 				['.esg-zoomintocorner',		0.5, {x:0, y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"20% 50%"},{autoAlpha:1,scale:1.2, x:0, y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.5,{autoAlpha:0,x:0, y:0,scale:1,autoAlpha:1,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"}],
			 				['.esg-zoomouttocorner',	0.5, {x:0, y:0,scale:1.2,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"80% 50%"},{autoAlpha:1,scale:1, x:0, y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.5,{autoAlpha:0,x:0, y:0,scale:1.2,autoAlpha:1,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"}],
			 				['.esg-zoomtodefault',		0.5, {x:0, y:0,scale:1.2,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{autoAlpha:1,scale:1, x:0, y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.5,{autoAlpha:0,x:0, y:0,scale:1.2,autoAlpha:1,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"}],

			 				['.esg-zoomback',			0.5, {x:0, y:0,scale:0.2,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,scale:1, x:0, y:0, ease:punchgs.Back.easeOut,overwrite:"all"},0.5,{autoAlpha:0,x:0, y:0,scale:0.2,autoAlpha:0,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"}],
			 				['.esg-zoombackout',		0.5, {autoAlpha:1,scale:1, x:0, y:0, ease:punchgs.Back.easeOut,overwrite:"all"},{x:0, y:0,scale:0.2,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.5,{autoAlpha:1,scale:1, x:0, y:0, ease:punchgs.Back.easeOut,overwrite:"all"}],

			 				['.esg-zoomfront',			0.5, {x:0, y:0,scale:1.5,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},{autoAlpha:1,scale:1, x:0, y:0, ease:punchgs.Power3.easeOut,overwrite:"all"},0.5,{autoAlpha:0,x:0, y:0,scale:1.5,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"}],
			 				['.esg-zoomfrontout',		0.5, {autoAlpha:1,scale:1, x:0, y:0, ease:punchgs.Back.easeOut,overwrite:"all"},{x:0, y:0,scale:1.5,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:0,transformOrigin:"50% 50%"},0.5,{autoAlpha:1,scale:1, x:0, y:0, ease:punchgs.Back.easeOut,overwrite:"all"}],

			 				['.esg-flyleft',			0.8, {x:-80, y:0,z:0,scale:0.3,rotationZ:0,rotationY:75,rotationX:10,skewX:0,skewY:0,autoAlpha:0.01,transformOrigin:"30% 10%"},{x:0, y:0, rotationY:0,  z:0.001,rotationX:0,rotationZ:0,autoAlpha:1,scale:1, x:0, y:0, z:0,ease:punchgs.Power3.easeInOut,overwrite:"all"},0.8,{autoAlpha:0.01,x:-40, y:0,z:300,rotationY:60,rotationX:20,overwrite:"all"}],
			 				['.esg-flyleftout',			0.8, {x:0, y:0, rotationY:0,  z:0.001,rotationX:0,rotationZ:0,autoAlpha:1,scale:1, x:0, y:0, z:0,ease:punchgs.Power3.easeInOut,overwrite:"all"},{x:-80, y:0,z:0,scale:0.3,rotationZ:0,rotationY:75,rotationX:10,skewX:0,skewY:0,autoAlpha:0.01,transformOrigin:"30% 10%"},0.8,{x:0, y:0, rotationY:0,  z:0.001,rotationX:0,rotationZ:0,autoAlpha:1,scale:1, x:0, y:0, z:0,ease:punchgs.Power3.easeInOut,overwrite:"all"}],

			 				['.esg-flyright',			0.8, {scale:1,skewX:0,skewY:0,autoAlpha:0,x:80, y:0,z:0,scale:0.3,rotationZ:0,rotationY:-75,rotationX:10,transformOrigin:"70% 20%"},{x:0, y:0, rotationY:0,  z:0.001,rotationX:0,autoAlpha:1,scale:1, x:0, y:0, z:0,ease:punchgs.Power3.easeInOut,overwrite:"all"},0.8,{autoAlpha:0,x:40, y:-40,z:300,rotationY:-60,rotationX:-40,overwrite:"all"}],
			 				['.esg-flyrightout',		0.8, {x:0, y:0, rotationY:0,  z:0.001,rotationX:0,autoAlpha:1,scale:1, x:0, y:0, z:0,ease:punchgs.Power3.easeInOut,overwrite:"all"},{scale:1,skewX:0,skewY:0,autoAlpha:0,x:80, y:0,z:0,scale:0.3,rotationZ:0,rotationY:-75,rotationX:10,transformOrigin:"70% 20%"},0.8,{x:0, y:0, rotationY:0,  z:0.001,rotationX:0,autoAlpha:1,scale:1, x:0, y:0, z:0,ease:punchgs.Power3.easeInOut,overwrite:"all"}],

			 				['.esg-mediazoom',			0.3, {x:0, y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{autoAlpha:1,scale:1.4, x:0, y:0, ease:punchgs.Back.easeOut,overwrite:"all"},0.3,{autoAlpha:0,x:0, y:0,scale:1,z:0,ease:punchgs.Power2.easeOut,overwrite:"all"}],
			 				['.esg-zoomandrotate',		0.6, {x:0, y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{autoAlpha:1,scale:1.4, x:0, y:0, rotationZ:30,ease:punchgs.Power2.easeOut,overwrite:"all"},0.4,{x:0, y:0,scale:1,z:0,rotationZ:0,ease:punchgs.Power2.easeOut,overwrite:"all"}],

			 				['.esg-pressback',			0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"50% 50%"},{rotationY:0,autoAlpha:1,scale:0.8,ease:punchgs.Power3.easeOut,overwrite:"all"} ,0.3,{rotationY:0,autoAlpha:1,z:0,scale:1,ease:punchgs.Power2.easeOut,overwrite:"all"} ],
			 				['.esg-3dturnright',		0.5, {x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,transformPerspective:600},{x:-40,y:0,scale:0.8,rotationZ:2,rotationX:5,rotationY:-28,skewX:0,skewY:0,autoAlpha:1,transformOrigin:"100% 50% 40%",transformPerspective:600,ease:punchgs.Power3.easeOut,overwrite:"all"} ,0.3,{z:0,x:0,y:0,scale:1,rotationZ:0,rotationX:0,rotationY:0,skewX:0,skewY:0,autoAlpha:1,force3D:"auto",ease:punchgs.Power2.easeOut,overwrite:"all"} ,true]
			 			   ];




					 	 // ADD A CLASS FOR ANY FURTHER DEVELOPEMENTS
					 	 var item = jQuery('#skin-dz-wrapper');


						 var maxdd = 0;


						 var	 mc = jQuery('.eg-editor-inside-wrapper'),
								 content = jQuery('#skin-dz-m-wrap'),
								 covergroup = jQuery('#skin-dz-wrapper'),
								 media = jQuery('#skin-dz-media-bg');

						 punchgs.TweenLite.set(mc,{transformStyle:"flat"});
						 punchgs.TweenLite.set(content,{transformStyle:"flat"});
						 punchgs.TweenLite.set(covergroup,{transformStyle:"flat"});
						 punchgs.TweenLite.set(media,{transformStyle:"flat"});
						 var nextd =direction;


						 if (direction=="hover") {

							 jQuery.each(esgAnimmatrix,function(index,key) {

								 item.parent().find(key[0]).each(function() {

									  var elem = jQuery(this);
									  var hideunder = elem.data('hideunder');

									  if (elem.hasClass("eg-special-element")){
										//NOTHINNG
									  }

									  else

									  if (item.width()<hideunder && hideunder!=undefined) {

									  	  if (elem.css('display')!="none") {
									  	  	elem.data('display',elem.css('display'));

									  	  }
										  elem.css({display:'none'});
									  } else {
										  var dd = elem.data('delay')!=undefined ? parseFloat(elem.data('delay')) : 0;

										  var animfrom = key[2];
				  						  var animto = key[3];
				  						  animto.delay=dd;
				  						  animto.overwrite="all";
				  						  animfrom.overwrite="all";
				  						  animto.transformStyle="flat";
				  						  animto.force3D = true;
				  						  var splitted = false;
				  						  var elemdelay =0;

				  						  if (elem.attr('id')!="skin-dz-media-bg")
					  						  animto.clearProps="transform";

				  						  if (animfrom.z == undefined) animfrom.z = 0.001;
				  						  if (animto.z == undefined || animto.z==0) animto.z = 0.001;


				  						  if (key[0]==".esg-shifttotop") {
					  						 // animto.y = 0 - item.find('.esg-entry-cover').last().height();
					  						 animto.y = 0 - item.find('#skin-dz-br').last().height();
				  						  }

				  						  if (key[0]==".esg-slide") {
					  						  var dire = Math.round(Math.random()*4+1);
					  						  switch (dire) {
						  						  case 1:
						  						  	animfrom.y = -20-elem.height();
						  						  	animfrom.x = 0;
						  						  break;
						  						  case 2:
						  						  	animfrom.y = 20+elem.height();
						  						  	animfrom.x = 0;
						  						  break;
						  						  case 3:
						  						  	animfrom.x = -20-elem.width();
						  						  	animfrom.y = 0;
						  						  break;
						  						  case 4:
						  						  	animfrom.x = 20+elem.width();
						  						  	animfrom.y = 0;
						  						  break;
						  						  default:
						  						  	animfrom.x = 20+elem.width();
						  						  	animfrom.y = 0;
						  						  break;
					  						  }
					  						  elem.closest('.eg-editor-inside-wrapper').css({overflow:"hidden"});
				  						  }

				  						   if (key[0]==".esg-slideout") {
					  						  var dire = Math.round(Math.random()*4+1);
					  						  switch (dire) {
						  						  case 1:
						  						  	animto.y = -20-elem.height();
						  						  	animto.x = 0;
						  						  break;
						  						  case 2:
						  						  	animto.y = 20+elem.height();
						  						  	animto.x = 0;
						  						  break;
						  						  case 3:
						  						  	animto.x = -20-elem.width();
						  						  	animto.y = 0;
						  						  break;
						  						  case 4:
						  						  	animto.x = 20+elem.width();
						  						  	animto.y = 0;
						  						  break;
						  						  default:
						  						  	animto.x = 20+elem.width();
						  						  	animto.y = 0;
						  						  break;
					  						  }
					  						  elem.closest('.eg-editor-inside-wrapper').css({overflow:"hidden"});
				  						  }

				  						  if (animto.transformPerspective ==undefined)
					  						  animto.transformPerspective = 1000;

					  					  if (animfrom.transformPerspective ==undefined)
					  						  animfrom.transformPerspective = 1000;


				  						  punchgs.TweenLite.killTweensOf(elem,false);

				  						  var animobject = elem;

				  						  punchgs.TweenLite.fromTo(animobject,key[1],animfrom,animto,elemdelay);


										  if (elem.css('display')=="none")
										  	elem.css({display:elem.data('display')});
									    if (dd>maxdd)  maxdd =dd ;
				  					}
								 })
							 })
							 nextd = "leave";
						}

						if (direction=="last") {
							jQuery.each(esgAnimmatrix,function(index,key) {
								 item.parent().find(key[0]).each(function() {
								 	var elem = jQuery(this);

								 	punchgs.TweenLite.killTweensOf(elem,false);
								 	if (elem.data('mySplitText') !=undefined) elem.data('mySplitText').revert();
								 	punchgs.TweenLite.to(item,0.5,{autoAlpha:1,overwrite:"auto",clearProps:"transform"});
								 	punchgs.TweenLite.to(elem,0.5,{skewX:0, skewY:0, rotationX:0, rotationY:0, rotationZ:0, x:0, y:0, z:0,scale:1,clearProps:"transform",autoAlpha:1,overwrite:"all"});
								 	elem.closest('.eg-editor-inside-wrapper').css({overflow:"hidden"});
								 });
							})
						}

						if (direction=="leave") {
									 var maxdelay=0;
									 jQuery.each(esgAnimmatrix,function(index,key) {
										 item.parent().find(key[0]).each(function() {
											  var elem = jQuery(this);
											  var dd = elem.data('delay')!=undefined ? elem.data('delay') : 0;
											  var animto = key[5];
											  if (maxdelay<dd) maxdelay = dd;
					  						  animto.z = 0;
					  						  var elemdelay =0;
					  						  var animobject = elem;
					  						  var splitted = false;

					  						  if (elem.attr('id')=="skin-dz-media-bg")
					  						  	animto.clearProps="transform";

					  						  if (key[0]==".esg-slide") {
						  						  var dire = Math.round(Math.random()*4+1);
						  						  switch (dire) {
							  						  case 1:
							  						  	animto.y = -20-elem.height();
							  						  	animto.x = 0;
							  						  break;
							  						  case 2:
							  						  	animto.y = 20+elem.height();
							  						  	animto.x = 0;
							  						  break;
							  						  case 3:
							  						  	animto.x = -20-elem.width();
							  						  	animto.y = 0;
							  						  break;
							  						  case 4:
							  						  	animto.x = 20+elem.width();
							  						  	animto.y = 0;
							  						  break;
							  						  default:
							  						  	animto.x = 20+elem.width();
							  						  	animto.y = 0;
							  						  break;
						  						  }
						  						  elem.closest('.eg-editor-inside-wrapper').css({overflow:"hidden"});
						  						 }


					  					   if (elem.hasClass("eg-special-element")){
						  					   		//NOTHINNG
						  					  }
						  					  else {
												  punchgs.TweenLite.to(animobject,key[4],animto,elemdelay);
						  					  }




										 })
									 })
									 if (maxdelay==0) maxdelay=0.2;

					 	     maxdd=0;
					 	     nextd="hover";
					 	}



					 	if (direction!="last")
						 	jQuery('#eg-preview-item-skin').data('timer',setTimeout(function() {
							    t.animateElements(nextd);
							},(maxdd*1000)+1500))


	}


	t.playElementAnimation = function() {

		jQuery('#drop-1').removeClass("revgreen").addClass("revred");
		jQuery(".dropzonetext").css({visibility:"hidden"});

		jQuery('#eg-preview-item-skin').css({'display':'none'});
		jQuery('#eg-preview-stop-item-skin').css({'display':'inline-block'});

		jQuery('#skin-dz-wrapper .skin-dz-elements.eg-special-element').css({visibility:"hidden"});

		jQuery('.dropzonetext').each(function() {
				jQuery(this).closest('.eec').addClass("eg-filled-container")
		})

		var but = jQuery('#make-3d-map');

		if (but.hasClass("3don")) {
			t.moveIn3d("off",0);
			but.removeClass("3don");
			but.html("3D");
			setTimeout(function() {
				t.animateElements("hover");
			},600)
		} else {
				t.animateElements("hover");
		}


	};

	t.stopElementAnimation = function(now) {

		jQuery('#drop-1').removeClass("revred").addClass("revgreen");
		jQuery(".dropzonetext").css({visibility:"visible"});


		clearTimeout(jQuery('#eg-preview-item-skin').data('timer'));
		var item = jQuery('#skin-dz-wrapper');

		jQuery('#eg-preview-item-skin').css({'display':'inline-block'});
		jQuery('#eg-preview-stop-item-skin').css({'display':'none'});
		jQuery('#skin-dz-wrapper .skin-dz-elements.eg-special-element').css({visibility:"visible"});



		clearTimeout(jQuery('#eg-preview-item-skin').data('timer'));
		setTimeout(function() {
			clearTimeout(jQuery('#eg-preview-item-skin').data('timer'));
		 	t.animateElements("last");
		},200)


		t.atDropStop();


	}

/******************************************************
	-	SCHEMATIC ANIMATION && DROP ZONE HIDES	-
******************************************************/

	t.eg3dtakeCare = function() {

		var timer;

		jQuery('#drop-1').click(function() {
			var bt = jQuery(this);
			var cl = ".dropzonetext";

			if (bt.hasClass("revgreen")) {
				bt.removeClass("revgreen").addClass("revred");
				jQuery(cl).css({visibility:"hidden"});
			} else {
				bt.removeClass("revred").addClass("revgreen");
				jQuery(cl).css({visibility:"visible"});
			}
		})

		jQuery('#make-3d-map').hover(

			function() {
				clearTimeout(timer)
				timer=setTimeout(t.show3danim,250);


			},

			function() {
					clearTimeout(timer)
					t.hide3danim();
			});
	}

	t.show3danim = function() {
		var orig = jQuery('.eg-editor-inside-wrapper');
				var mc = jQuery('#eg-3dpp');
				var tw = jQuery('#eg-it-layout-wrap');
				var mci = jQuery('#eg-3dpp-inner');

				var bg = jQuery('.eg-3d-bg');
				var cover = jQuery('.eg-3d-cover');
				var elem = jQuery('.eg-3d-element');
				var elems = jQuery('.eg-3d-elements');
				var content = jQuery('.eg-3dcc');
				var bgcc = jQuery('.eg-3d-ccbg');
				var st1 = jQuery('#eg-3d-cstep1');
				var st2 = jQuery('#eg-3d-cstep2');
				var st3 = jQuery('#eg-3d-cstep3');
				var st4 = jQuery('#eg-3d-cstep4');


				punchgs.TweenLite.to(jQuery('#eg-it-layout-wrap'),0.5,{backgroundColor:"#d5d5d5"});
				punchgs.TweenLite.to(orig,0.5,{autoAlpha:0});
				punchgs.TweenLite.to(mc,0.5,{z:-200,y:-30,autoAlpha:1})
				punchgs.TweenLite.to(tw,0.3,{minHeight:600});

				//3d MAP STEP1

				punchgs.TweenLite.set(mci,{z:0,rotationY:0,rotationX:0,overwrite:"all"});
				punchgs.TweenLite.set(jQuery('#eg-3d-description'),{autoAlpha:0, delay:3});
				punchgs.TweenLite.set(elem,{ opacity:1,z:4,overwrite:"all"});
				punchgs.TweenLite.set(elems,{opacity:1,z:4,overwrite:"all"});
				punchgs.TweenLite.set(cover,{opacity:1, z:3,overwrite:"all"});
				punchgs.TweenLite.set(bgcc,{opacity:1, z:2,overwrite:"all"});
				punchgs.TweenLite.set(bg,{opacity:1, z:1,overwrite:"all"});

				punchgs.TweenLite.set(mc,{transformStyle:"preserve-3d", transformOrigin:"50% 50% 50%",transformPerspective:1200});
				punchgs.TweenLite.set(jQuery('.eg-3dmc'),{transformStyle:"preserve-3d", transformOrigin:"50% 50% 50%",transformPerspective:1200});
				punchgs.TweenLite.set(mci,{transformStyle:"preserve-3d", transformOrigin:"50% 50% 0%",transformPerspective:1200});
				punchgs.TweenLite.set(elems,{transformStyle:"preserve-3d", transformOrigin:"50% 50% 0%",transformPerspective:1200});
				punchgs.TweenLite.set(content,{transformStyle:"preserve-3d", transformOrigin:"50% 50% 0%",transformPerspective:1200});
				punchgs.TweenLite.to(mci,2,{z:0,rotationY:-45,rotationX:7,delay:0.5,overwrite:"all",ease:punchgs.Power1.easeOut});



				// STEP2
				punchgs.TweenLite.to(elem,1,{z:90,overwrite:"all",delay:1,ease:punchgs.Power1.easeOut});
				punchgs.TweenLite.to(cover,0.7,{z:50,overwrite:"all" ,delay:1,ease:punchgs.Power1.easeOut});
				punchgs.TweenLite.to(bgcc,0.5,{z:22,overwrite:"all",delay:1,ease:punchgs.Power1.easeOut});
				punchgs.TweenLite.to(bg,0.5,{z:20,overwrite:"all",delay:1,ease:punchgs.Power1.easeOut});



				// STEP3
				punchgs.TweenLite.to(jQuery('#eg-3d-description'),0.5,{autoAlpha:1, delay:3});
				punchgs.TweenLite.fromTo(st1,0.5,{autoAlpha:0,y:-10},{autoAlpha:1, y:0,delay:3});
				punchgs.TweenLite.to(elems,0.5,{opacity:1,delay:3});
				punchgs.TweenLite.to(cover,0.5,{opacity:0,delay:3});
				punchgs.TweenLite.to(content,0.5,{opacity:0,delay:3});
				punchgs.TweenLite.to(bg,0.5,{opacity:0,delay:3});

				// STEP4
				punchgs.TweenLite.to(st1,0.5,{autoAlpha:0, delay:4.5});
				punchgs.TweenLite.fromTo(st2,0.5,{autoAlpha:0,y:-10},{autoAlpha:1, y:0,delay:4.5});
				punchgs.TweenLite.to(elems,0.5,{opacity:0,delay:4.5});
				punchgs.TweenLite.to(cover,0.5,{opacity:1,delay:4.5});

				// STEP5
				punchgs.TweenLite.to(st2,0.5,{autoAlpha:0, delay:6});
				punchgs.TweenLite.fromTo(st3,0.5,{autoAlpha:0,y:-10},{autoAlpha:1, y:0,delay:6});
				punchgs.TweenLite.to(cover,0.5,{opacity:0,delay:6});
				punchgs.TweenLite.to(bg,0.5,{opacity:1,delay:6});

				// STEP5
				punchgs.TweenLite.to(st3,0.5,{autoAlpha:0, delay:7.5});
				punchgs.TweenLite.fromTo(st4,0.5,{autoAlpha:0,y:-10},{autoAlpha:1, y:0,delay:7.5});
				punchgs.TweenLite.to(content,0.5,{opacity:1,delay:7.5});
				punchgs.TweenLite.to(bg,0.5,{opacity:0,delay:7.5});

				orig.data('timer',setTimeout(function() {
					t.hide3danim();
				},9000));
	}

	t.hide3danim = function() {
				var orig = jQuery('.eg-editor-inside-wrapper');
				clearTimeout(orig.data('timer'))

				var mc = jQuery('#eg-3dpp');
				var tw = jQuery('#eg-it-layout-wrap');
				var mci = jQuery('#eg-3dpp-inner');

				var bg = jQuery('.eg-3d-bg');
				var cover = jQuery('.eg-3d-cover');
				var elem = jQuery('.eg-3d-element');
				var elems = jQuery('.eg-3d-elements');
				var content = jQuery('.eg-3dcc');
				var bgcc = jQuery('.eg-3d-ccbg');
				var st1 = jQuery('#eg-3d-cstep1');
				var st2 = jQuery('#eg-3d-cstep2');
				var st3 = jQuery('#eg-3d-cstep3');
				var st4 = jQuery('#eg-3d-cstep4');


				punchgs.TweenLite.to(jQuery('#eg-it-layout-wrap'),0.5,{backgroundColor:"#fff"});
				punchgs.TweenLite.to(mc,0.5,{z:0,y:0,autoAlpha:0})
				punchgs.TweenLite.to(orig,0.5,{autoAlpha:1});
				punchgs.TweenLite.to(tw,0.3,{minHeight:0});

				//3d MAP
				punchgs.TweenLite.set(st1,{autoAlpha:0,overwrite:"all"});
				punchgs.TweenLite.set(st2,{autoAlpha:0,overwrite:"all"});
				punchgs.TweenLite.set(st3,{autoAlpha:0,overwrite:"all"});
				punchgs.TweenLite.set(st4,{autoAlpha:0,overwrite:"all"});
				punchgs.TweenLite.to(content,0.5,{opacity:1,overwrite:"all"});

				punchgs.TweenLite.to(mci,0.5,{z:0,rotationY:0,rotationX:0,overwrite:"all"});
				punchgs.TweenLite.to(jQuery('#eg-3d-description'),0.5,{autoAlpha:0, delay:3});
				punchgs.TweenLite.to(elem,0.5,{ opacity:1,z:4,overwrite:"all"});
				punchgs.TweenLite.to(elems,0.5,{opacity:1,z:4,overwrite:"all"});
				punchgs.TweenLite.to(cover,0.5,{opacity:1, z:3,overwrite:"all"});
				punchgs.TweenLite.to(bgcc,0.5,{opacity:1, z:2,overwrite:"all"});
				punchgs.TweenLite.to(bg,0.5,{opacity:1, z:1,overwrite:"all"});
	}



	/********************************************
		-	SORT AND DRAG DROP LOOK A LIKE	-
	********************************************/

	t.whileDropOrSort = function(selector) {
		 var esh = jQuery('.eg-state-highlight');
         var dd = jQuery(selector);
         esh.html(dd.html());
         esh.css({
         		'borderTop':dd.css('borderTop'),
		 		'borderBottom':dd.css('borderBottom'),
		 		'borderRight':dd.css('borderRight'),
		 		'borderLeft':dd.css('borderLeft'),

         		'paddingTop':dd.css('paddingTop'),
		 		'paddingBottom':dd.css('paddingBottom'),
		 		'paddingLeft':dd.css('paddingLeft'),
		 		'paddingRight':dd.css('paddingRight'),
        		'color':dd.css('color'),
        		'border':dd.css('border'),
        		'marginTop':dd.css('marginTop'),
        		'marginLeft':dd.css('marginLeft'),
        		'marginBottom':dd.css('marginBottom'),
        		'marginRight':dd.css('marginRight'),
        		'fontSize':dd.css('fontSize'),
        		'lineHeight':dd.css('lineHeight')
				})
		t.atDropStop();
	}

	t.adjustDropHeights = function() {
		var tc = jQuery('.esg-tc.eec');
		var bc = jQuery('.esg-bc.eec');
		var cc = jQuery('.esg-bc.eec');

		var tci = jQuery('#skin-dz-tl');
		var bci = jQuery('#skin-dz-br');
		var cci = jQuery('#skin-dz-c');

		var pp = jQuery('#skin-dz-wrapper');
		pph = pp.height();
		var shouldh = ((pph*0.8) - cci.height()) /2;
		if (shouldh > (pph*0.8)/3) shouldh =(pph*0.8)/3



		if (!tc.hasClass("eg-filled-container")) {
			tc.css({minHeight:shouldh+"px"});

		} else {

			tc.css({height:"auto"});
		}

		if (!bc.hasClass("eg-filled-container")) {
			bc.css({minHeight:shouldh+"px"});

		} else {
			bc.css({minHeight:"auto"});
		}
	}

	t.atDropStop = function(limit) {
		if (limit==undefined) limit = 0;

		if (jQuery("input[name='choose-layout']:checked").val() =="even")
		  jQuery('#drop-4').hide();
		else
		  jQuery('#drop-4').show();

		jQuery('.dropzonetext').each(function(i) {
			var eec = jQuery(this).closest('.eec')
			if (eec.length==0) eec = jQuery(this).closest("#skin-dz-m-wrap");

			if (eec.length>0) {
				var amountelems = eec.find('.skin-dz-elements').length;
				var dragelems = eec.find('.skin-dz-elements.ui-sortable-helper').length;


				if (amountelems>limit) {
					eec.addClass("eg-filled-container")
				} else {

					if (amountelems==1 && dragelems!=1)
						eec.addClass("eg-filled-container")
					else
						eec.removeClass("eg-filled-container")
				}
			}
		})
		t.adjustDropHeights();

	}

	t.presetSelects = function() {
		jQuery('#eg-wrap').find('select').each(function() {
			var input = jQuery(this);
			var sf = jQuery(this).parent().find('.select_fake');
			if (sf.length) {
				var cont = input.find('option:selected').text();
				if (cont.length==0) cont = eg_lang.not_selected;
				sf.find('span').html(cont);
			}
		})

	}


	//adds the update/deactivate option
	t.initUpdateRoutine = function(){

		jQuery('#eg-validation-activate').click(function(){

			var data = {
				code: jQuery('input[name="eg-validation-token"]').val()
			}

			t.ajaxRequest("activate_purchase_code", data, '#eg-validation-activate');
		});

		jQuery('#eg-validation-deactivate').click(function(){
			t.ajaxRequest("deactivate_purchase_code", '', '#eg-validation-deactivate');
		});

	}

	
	t.initNewsletterRoutine = function(){

		jQuery('#subscribe-to-newsletter').click(function(){

			var data = {
				email: jQuery('input[name="eg-email"]').val()
			}

			t.ajaxRequest("subscribe_to_newsletter", data, '#subscribe-to-newsletter');
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
				email: jQuery('input[name="eg-email"]').val()
			}

			t.ajaxRequest("unsubscribe_to_newsletter", data, '#unsubscribe-to-newsletter');
		});
		

	}

	/******************************
		-	SANITIZE INPUT	-
	********************************/

	t.sanitize_input = function(raw){
		return raw.toLowerCase().replace(/ /g, '-').replace(/[^-0-9a-z_-]/g,'');
	}

	/**
	Init Slider Spinner Admin View
	**/
	t.initSpinnerAdmin = function() {
		jQuery('#use_spinner_row').parent().prepend('<div id="spinner_preview"></div>');
		var spin = jQuery('#spinner_preview');
		var sel = jQuery('#use_spinner');
		var col = jQuery('#spinner_color');
		var oldcol = col.val();
		t.resetSpin(spin);

		sel.on("change",function() {
			t.resetSpin(spin,true);
		});
		setInterval(function() {
			if (oldcol!=col.val()) {
				t.spinnerColorChange();
				oldocl=col.val();
			}
		},300)
	}
	/**
	CHANGE SPINNER COLOR ON CALL BACK
	**/
	t.spinnerColorChange = function() {
			var col = jQuery('#spinner_color').val();
			var sel = jQuery('#use_spinner');
			if (sel.val()==0 || sel.val()==5) col ="#ffffff";

			var spin = jQuery('#spinner_preview .esg-loader.esg-demo');
			if (spin.hasClass("spinner0") || spin.hasClass("spinner1") || spin.hasClass("spinner2")) {
				spin.css({'backgroundColor':col});
			} else {
				spin.find('div').css({'backgroundColor':col});
			}
	};

	/**
	RESET SPINNER DEMO
	**/
	t.resetSpin = function(spin,remove) {
			var sel = jQuery('#use_spinner');
			spin.find('.esg-loader').remove();
			spin.append('<div class="esg-loader esg-demo">'+
												  		'<div class="dot1"></div>'+
												  	    '<div class="dot2"></div>'+
												  	    '<div class="bounce1"></div>'+
														'<div class="bounce2"></div>'+
														'<div class="bounce3"></div>'+
													 '</div>');
			spin.find('.esg-demo').addClass("spinner"+sel.val());
			if (sel.val()==-1 || sel.val()==0 || sel.val()==5) {
				//jQuery('#spinner_color').val("#ffffff");
				jQuery('#spinner_color_row').css({display:"none"});
			} else {
				jQuery('#spinner_color_row').css({display:"block"});
			}
			t.spinnerColorChange();

	};


	/**
	INITIALISE THE TOOLTIP
	**/
	t.initToolTipser = function() {
		if (es_do_tooltipser)
		jQuery('.eg-tooltip-wrap').not('.tooltipser').tooltipster({
			theme: 'eg-tooltip',
			delay:0,
			ion:"top",
			offsetY:0
		});
	}

	/**
	INITIALISE THE CLEAR STREAM CACHE
	**/
	t.clearStreamCache = function(buttonpressed) {
		current_transient = buttonpressed.parent().find("input");
		current_transient_val = current_transient.val();
		jQuery('input[name=' + buttonpressed.data("clear") + ']').parent().find("input").val("0");
		t.changePreviewGrid(true);
		setTimeout(function(){ jQuery('input[name=' + buttonpressed.data("clear") + ']').val(current_transient_val) }, 500);
	}
}



jQuery.fn.tpsortable = function(){
	function disableSelection(sel){
		sel.preventDefault();
	}
    jQuery(this).mousedown(function(e){
		var drag = jQuery(this);
		var posParentTop = drag.parent().offset().top;
		var posParentBottom = posParentTop + drag.parent().height();
		var posOld = drag.offset().top;
		var posOldCorrection = e.pageY - posOld;
        drag.css({'z-index':2, 'background-color':'#eeeeee'});
		var mouseMove = function(e){
			var posNew = e.pageY - posOldCorrection;
			if (posNew < posParentTop){
				drag.offset({'top': posParentTop});
				if (drag.prev().length > 0 ) {
					drag.insertBefore(drag.prev().css({'top':-drag.height()}).animate({'top':0}, 100));
				}
			} else if (posNew + drag.height() > posParentBottom){
				drag.offset({'top': posParentBottom - drag.height()});
				if (drag.next().length > 0 ) {
					drag.insertAfter(drag.next().css({'top':drag.height()}).animate({'top':0}, 100));
                }
			} else {
				drag.offset({'top': posNew});
				if (posOld - posNew > drag.height() - 1){
					drag.insertBefore(drag.prev().css({'top':-drag.height()}).animate({'top':0}, 100));
					drag.css({'top':0});
					posOld = drag.offset().top;
					posNew = e.pageY - posOldCorrection;
					posOldCorrection = e.pageY - posOld;
				} else if (posNew - posOld > drag.height() - 1){
					drag.insertAfter(drag.next().css({'top':drag.height()}).animate({'top':0}, 100));
					drag.css({'top':0});
					posOld = drag.offset().top;
					posNew = e.pageY - posOldCorrection;
					posOldCorrection = e.pageY - posOld;
				}
			}
		};
		var mouseUp = function(){
			jQuery(document).off('mousemove', mouseMove).off('mouseup', mouseUp);
			jQuery(document).off((jQuery.support.selectstart?'selectstart':'mousedown')+'.ui-disableSelection', disableSelection);
            drag.animate({'top':0}, 1, function(){
				drag.css({'z-index':1, 'background-color':'transparent'});
	        });
        };
		jQuery(document).on('mousemove', mouseMove).on('mouseup', mouseUp).on('contextmenu', mouseUp);
		jQuery(document).on((jQuery.support.selectstart?'selectstart':'mousedown')+'.ui-disableSelection', disableSelection);
        jQuery(window).on('blur', mouseUp);
    });
}