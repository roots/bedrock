var UniteCssEditorRev = new function(){
	
	var t = this;
	var initCssStyles = [];
	var cssPreClass = '.tp-caption';
	var cssCurrentType = 'params';
	var curActiveStyles = new Object;
	var curFullClass = new Object;
	var isHoverActive = false;
	
	var g_codemirrorCssUneditable = null;
	var g_codemirrorCssEditable = null;
	var g_codemirrorCssLayer = null;
	var common_styles = {
		'background-color': 'backgroundColor', //rgb rgba and opacity
		'border-color': 'borderColor',
		'border-radius': 'borderRadius',
		'border-style': 'borderStyle',
		'border-width': 'borderWidth',
		'color': 'color',
		'font-family': 'fontFamily',
		'font-size': 'fontSize',
		'font-style': 'fontStyle',
		'font-weight': 'fontWeight',
		'line-height': 'lineHeight',
		'opacity': 'opacity',
		'padding': 'padding',
		'text-decoration': 'textDecoration'
	};
	var cur_editing = 'idle';
	
	//======================================================
	//	Init Functions
	//======================================================
	
	/**
	 * set init css styles array
	 */
	t.setInitCssStyles = function(jsonClasses){
		initCssStyles = jQuery.parseJSON(jsonClasses);
	}
	
	/**
	 * set init css styles array
	 */
	t.setInitCssStylesObj = function(finalobject){
		initCssStyles = finalobject;
	}
	
	
	/**
	 * init the css editor
	 */
	t.init = function(){
		init50Editor();
		t.initAdvancedEditor();
	}
	
	//======================================================
	//	General Functions
	//======================================================
	
	/**
	 * fill curFullClass with curActiveStyles
	 */
	var updateCurFullClass = function(){
		curFullClass[cssCurrentType] = curActiveStyles;
	};
	
	
	/**
	 * creates the padding & corner in 1 line
	 */
	var filterCssPadCor = function(id){
		var retObj = [];
		var i = 0;
		var found = 0;
		jQuery(id).each(function(){
			retObj[i] = jQuery(this).val();
			if(retObj[i] != '') found++;
			i++;
		});
		
		switch(found){
			case 0:
				return false; //empty, no entrys found
				break;
			case 1:
				for(key in retObj){
					if(retObj[key] != '') return retObj[key]+'px';
				}
				break;
			case 2:
				var checkVal = 0;
				for(key in retObj){
					if(retObj[key] != '') checkVal+= parseInt(key);
				}
				
				switch(checkVal){
					case 1: // 1 1 x x
						return retObj[0]+'px '+retObj[1]+'px';
						break;
					case 2: // 1 x 1 x
						if(retObj[0] == retObj[2])
							return retObj[0]+'px 0';
						else
							return retObj[0]+'px 0 '+retObj[2]+'px';
						break;
					case 3: // 1 x x 1 || x 1 1 x
						if(retObj[0] != '')
							return retObj[0]+'px '+retObj[3]+'px';
						else
							return retObj[2]+'px '+retObj[1]+'px';
						break;
					case 4: // x 1 x 1
						if(retObj[1] == retObj[3])
							return '0 '+retObj[1]+'px ';
						else
							return '0 '+retObj[1]+'px 0 '+retObj[3]+'px';
					case 5: // x x 1 1
						return retObj[2]+'px '+retObj[3]+'px';
					default:
						return false;
				}
				break;
			case 3:
				if(retObj[3] != ''){
					for(key in retObj){
						if(retObj[key] == '') retObj[key] = '0';
					}
				}
				return retObj[0]+'px '+retObj[1]+'px '+retObj[2]+'px';
				break;
			case 4:
			default:
				return retObj[0]+'px '+retObj[1]+'px '+retObj[2]+'px '+retObj[3]+'px';
				break;
		}
	}
	
	
	/*****************
	 * Ver 5.0 changes
	 *****************/
	
	var init50Editor = function(){
		/**
		 * new advanced style editor dialog
		 **/
		jQuery('.rev-advanced-css-idle, .rev-advanced-css-hover').click(function(){
			//check if layer is selected or not
			var sel_layer = UniteLayersRev.get_current_selected_layer();
			
			if(sel_layer === -1) return false;
			
			
			if(!t.checkIfHandleExists(jQuery('#layer_caption').val())){
				alert(rev_lang.please_select_first_an_existing_style);
				return false;
			}
			
			cur_editing = (jQuery(this).hasClass('rev-advanced-css-idle')) ? 'idle' : 'hover';
			
			jQuery('#dialog_advanced_css').dialog({
				modal:true,
				resizable:false,
				title:'Currently editing: '+jQuery('#layer_caption').val(),
				minWidth:700,
				minHeight:500,
				closeOnEscape:true,
				open:function () {
					jQuery('.current-advance-edited-class').text(jQuery('#layer_caption').val());
					
					jQuery(this).closest(".ui-dialog")
						.find(".ui-button").each(function(i) {
						   var cl;
						   if (i==0) cl="revgray";
						   if (i==1) cl="revgreen";
						   if (i==2) cl="revred";
						   if (i==3) cl="revred";
						   jQuery(this).addClass(cl).addClass("button-primary").addClass("rev-uibuttons");						   						   
				   });
				   
				   if(g_codemirrorCssEditable != null) g_codemirrorCssEditable.refresh();
				   if(g_codemirrorCssUneditable != null) g_codemirrorCssUneditable.refresh();
				   
				   t.setTemplateCssUneditable();
				   t.setTemplateCssEditable();
				},
				buttons:{
					"Save":function(){
						t.saveTemplateStylesInDb();
						updateCurFullClass();
					},
					"Cancel":function(){
						jQuery(this).dialog("close");
					}
				}
			});
		});
		
		
		/**
		 * additional Layer CSS dialog
		 **/
		jQuery('.rev-advanced-css-idle-layer, .rev-advanced-css-hover-layer').click(function(){
			//check if layer is selected or not
			var sel_layer = UniteLayersRev.get_current_selected_layer();
			
			if(sel_layer === -1) return false;
			
			cur_editing = (jQuery(this).hasClass('rev-advanced-css-idle-layer')) ? 'idle' : 'hover';
			
			jQuery('#dialog_advanced_layer_css').dialog({
				modal:true,
				resizable:false,
				minWidth:700,
				minHeight:500,
				closeOnEscape:true,
				open:function () {
					//jQuery('.current-advance-edited-class').text(jQuery('#layer_caption').val());
					
					jQuery(this).closest(".ui-dialog")
						.find(".ui-button").each(function(i) {
						   var cl;
						   if (i==0) cl = "revgray";
						   if (i==1) cl = "revgreen";
						   if (i==2) cl = "revred";
						   if (i==3) cl = "revred";
						   jQuery(this).addClass(cl).addClass("button-primary").addClass("rev-uibuttons");						   						   
				   });
				   
				   if(g_codemirrorCssLayer != null) g_codemirrorCssLayer.refresh();
				   
				   t.setTemplateCssLayer();
				},
				buttons:{
					"Save":function(){
						updateLayerCSS();
						jQuery(this).dialog("close");
					},
					"Cancel":function(){
						jQuery(this).dialog("close");
					}
				}
			});
		});
		
	}

	t.initAdvancedEditor = function(){
		g_codemirrorCssEditable = CodeMirror.fromTextArea(document.getElementById("textarea_advanced_css_editor"), {
			onChange: function(){ },
			lineNumbers: true
		});
		
		g_codemirrorCssUneditable = CodeMirror.fromTextArea(document.getElementById("textarea_template_css_editor_uneditable"), {
			onChange: function(){ },
			lineNumbers: true,
			readOnly: true
		});
		
		g_codemirrorCssLayer = CodeMirror.fromTextArea(document.getElementById("textarea_template_css_editor_layer"), {
			onChange: function(){ },
			lineNumbers: true,
			readOnly: false
		});
	}
	
	
	/**
	 * add Class name to the preview
	 * @since: 5.0
	 */
	t.setPreviewTextClass = function(){
		if(typeof(curFullClass['handle']) !== 'undefined'){
			var use_class = curFullClass['handle'].split('.');
			for(var key in use_class){
				jQuery('#rev-example-style-layer').addClass(use_class[key]);
			}
		}
		jQuery('#rev-example-style-layer').parent().show();
	}
	
	
	/**
	 * remove all CSS classes and inline styles to clean the preview from all styling
	 * @since: 5.0
	 */
	t.clearPreviewText = function(){
		jQuery('#rev-example-style-layer').attr('style', '');
		jQuery('#rev-example-style-layer').attr('class', '');
	}
	
	
	/**
	 * set template css from choosen css
	 * @since: 5.0
	 */
	t.setTemplateCssUneditable = function(){
		jQuery("#textarea_template_css_editor_uneditable").val('');
		
		var cssData = "{\n";
		setFullClass();
		
		if(cur_editing == 'idle' && typeof(curFullClass['params']) !== 'undefined'){
			curActiveStyles = curFullClass['params'];
		}else if(cur_editing == 'hover' && typeof(curFullClass['hover']) !== 'undefined'){
			curActiveStyles = curFullClass['hover'];
		}else{
			curActiveStyles = [];
		}
		
		if(!jQuery.isEmptyObject(curActiveStyles)){
			for(var key in common_styles){
				var the_style = '';
				
				switch(key){ //could add padding for example
					default:
						if(typeof(curActiveStyles[key]) === 'object'){
							the_style = curActiveStyles[key].join(' ');
						}else{
							the_style = curActiveStyles[key];
						}
					break;
				}
				
				if(the_style !== 'undefined' && the_style !== undefined && the_style !== '' && the_style !== 'none'){
					cssData += '	'+key+': '+the_style+";\n";
				}
			}
		}
		
		cssData += "}";
		
		if(g_codemirrorCssUneditable != null){
			g_codemirrorCssUneditable.setValue(cssData);
		}else{
			jQuery("#textarea_template_css_editor_uneditable").val(cssData);
			t.initAdvancedEditor();
		}
		g_codemirrorCssUneditable.refresh();
	}
	
	
	/**
	 * set template css from choosen css which is editable (meaning advanced styles)
	 * @since: 5.0
	 */
	t.setTemplateCssEditable = function(){
		jQuery("#textarea_advanced_css_editor").val('');
		
		var cssData = "{\n";
		setFullClass();
		
		if(cur_editing == 'idle' && typeof(curFullClass['advanced']) !== 'undefined' && typeof(curFullClass['advanced']['idle']) !== 'undefined'){
			var myStyles = jQuery.extend({},curFullClass['advanced']['idle']);
		}else if(cur_editing == 'hover' && typeof(curFullClass['advanced']) !== 'undefined' && typeof(curFullClass['advanced']['hover']) !== 'undefined'){
			var myStyles = jQuery.extend({},curFullClass['advanced']['hover']);
		}else{
			var myStyles = [];
		}
		
		
		for(var key in myStyles){
			var the_style = '';
			
			switch(key){
				default:
					if(typeof(myStyles[key]) === 'object'){
						the_style = myStyles[key].join(' ');
					}else{
						the_style = myStyles[key];
					}
				break;
			}
			
			
			if(the_style !== 'undefined' && the_style !== undefined && the_style !== ''){
				cssData += '	'+key+': '+the_style+";\n";
			}
		}
		
		cssData += "}";
		
		if(g_codemirrorCssEditable != null){
			g_codemirrorCssEditable.setValue(cssData);
		}else{
			jQuery("#textarea_advanced_css_editor").val(cssData);
			t.initAdvancedEditor();
		}
		g_codemirrorCssEditable.refresh();
	}
	
	
	/**
	 * set layer inline css from choosen css which is editable
	 * @since: 5.0
	 */
	t.setTemplateCssLayer = function(){
		jQuery("#textarea_template_css_editor_layer").val('');
		
		var cssData = "{\n";
		setFullClass();
		
		var layer = UniteLayersRev.getCurrentLayer();
		
		if(layer === null) return false;
		
		if(layer)
		if(cur_editing == 'idle' && typeof(layer['inline']) !== 'undefined' && typeof(layer['inline']['idle']) !== 'undefined'){
			var myStyles = jQuery.extend({},layer['inline']['idle']);
		}else if(cur_editing == 'hover' && typeof(layer['inline']) !== 'undefined' && typeof(layer['inline']['hover']) !== 'undefined'){
			var myStyles = jQuery.extend({},layer['inline']['hover']);
		}else{
			var myStyles = [];
		}
		
		for(var key in myStyles){
			var the_style = '';
			
			switch(key){
				default:
					if(typeof(myStyles[key]) === 'object'){
						the_style = myStyles[key].join(' ');
					}else{
						the_style = myStyles[key];
					}
				break;
			}
			
			
			if(the_style !== 'undefined' && the_style !== undefined && the_style !== ''){
				cssData += '	'+key+': '+the_style+";\n";
			}
		}
		
		cssData += "}";
		
		if(g_codemirrorCssLayer != null){
			g_codemirrorCssLayer.setValue(cssData);
		}else{
			jQuery("#textarea_template_css_editor_layer").val(cssData);
			t.initAdvancedEditor();
		}
		g_codemirrorCssLayer.refresh();
	}
	
	
	/**
	 * save styles for class/create new class
	 * @since: 5.0
	 */
	t.saveStylesInDb = function(handle, new_style, dialog_obj){
		var data = {'idle':{},'hover':{}};
		
		var layer = UniteLayersRev.getCurrentLayer();
		
		data['handle'] = handle;
		
		data['idle']['color'] = jQuery('input[name="color_static"]').val();
		data['idle']['color-transparency'] = jQuery('input[name="css_font-transparency"]').val();
		data['idle']['font-size'] = jQuery('input[name="font_size_static"]').val();
		data['idle']['line-height'] = jQuery('input[name="line_height_static"]').val();
		data['idle']['font-weight'] = jQuery('select[name="font_weight_static"] option:selected').val();
		
		data['idle']['font-style'] = (jQuery('input[name="css_font-style"]').is(':checked')) ? 'italic' : 'normal';
		data['idle']['font-family'] = jQuery('input[name="css_font-family"]').val();
		data['idle']['text-decoration'] = jQuery('select[name="css_text-decoration"] option:selected').val();
		
		//data['idle']['padding'] = {};
		//jQuery('input[name="css_padding[]"]').each(function(i){ data['idle']['padding'][i] = jQuery(this).val();});
		//data['idle']['text-align'] = jQuery('select[name="css_text-align"] option:selected').val();
		//get certain data from all device sizes, so from the current layer directly
		data['idle']['text-align'] = layer['text-align'];
		data['idle']['margin'] = layer['margin'];
		data['idle']['padding'] = layer['padding'];
		
		data['idle']['background-color'] = jQuery('input[name="css_background-color"]').val();
		data['idle']['background-transparency'] = jQuery('input[name="css_background-transparency"]').val();
		data['idle']['border-color'] = jQuery('input[name="css_border-color-show"]').val();
		data['idle']['border-transparency'] = jQuery('input[name="css_border-transparency"]').val();
		data['idle']['border-style'] = jQuery('select[name="css_border-style"] option:selected').val();
		data['idle']['border-width'] = jQuery('input[name="css_border-width"]').val();
		data['idle']['border-radius'] = {};
		jQuery('input[name="css_border-radius[]"]').each(function(i){ data['idle']['border-radius'][i] = jQuery(this).val();});
		data['idle']['x'] = jQuery('input[name="layer__x"]').val();
		data['idle']['y'] = jQuery('input[name="layer__y"]').val();
		data['idle']['z'] = jQuery('input[name="layer__z"]').val();
		data['idle']['skewx'] = jQuery('input[name="layer__skewx"]').val();
		data['idle']['skewy'] = jQuery('input[name="layer__skewy"]').val();
		data['idle']['scalex'] = jQuery('input[name="layer__scalex"]').val();
		data['idle']['scaley'] = jQuery('input[name="layer__scaley"]').val();
		data['idle']['opacity'] = jQuery('input[name="layer__opacity"]').val();
		data['idle']['xrotate'] = jQuery('input[name="layer__xrotate"]').val();
		data['idle']['yrotate'] = jQuery('input[name="layer__yrotate"]').val();
		data['idle']['2d_rotation'] = jQuery('input[name="layer_2d_rotation"]').val();
		data['idle']['2d_origin_x'] = jQuery('input[name="layer_2d_origin_x"]').val();
		data['idle']['2d_origin_y'] = jQuery('input[name="layer_2d_origin_y"]').val();
		data['idle']['pers'] = jQuery('input[name="layer__pers"]').val();
		data['idle']['corner_left'] = jQuery('select[name="layer_cornerleft"] option:selected').val();
		data['idle']['corner_right'] = jQuery('select[name="layer_cornerright"] option:selected').val();
		
		data['idle']['parallax'] = jQuery('select[name="parallax_level"] option:selected').val();
		
		
		data['hover']['color'] = jQuery('input[name="hover_color_static"]').val();
		data['hover']['color-transparency'] = jQuery('input[name="hover_css_font-transparency"]').val();
		data['hover']['text-decoration'] = jQuery('select[name="hover_css_text-decoration"] option:selected').val();
		data['hover']['background-color'] = jQuery('input[name="hover_css_background-color"]').val();
		data['hover']['background-transparency'] = jQuery('input[name="hover_css_background-transparency"]').val();
		data['hover']['border-color'] = jQuery('input[name="hover_css_border-color-show"]').val();
		data['hover']['border-transparency'] = jQuery('input[name="hover_css_border-transparency"]').val();
		data['hover']['border-style'] = jQuery('select[name="hover_css_border-style"] option:selected').val();
		data['hover']['border-width'] = jQuery('input[name="hover_css_border-width"]').val();
		data['hover']['border-radius'] = {};
		jQuery('input[name="hover_css_border-radius[]"]').each(function(i){ data['hover']['border-radius'][i] = jQuery(this).val(); });
		data['hover']['opacity'] = jQuery('input[name="hover_layer__opacity"]').val();
		data['hover']['scalex'] = jQuery('input[name="hover_layer__scalex"]').val();
		data['hover']['scaley'] = jQuery('input[name="hover_layer__scaley"]').val();
		data['hover']['skewx'] = jQuery('input[name="hover_layer__skewx"]').val();
		data['hover']['skewy'] = jQuery('input[name="hover_layer__skewy"]').val();
		data['hover']['xrotate'] = jQuery('input[name="hover_layer__xrotate"]').val();
		data['hover']['yrotate'] = jQuery('input[name="hover_layer__yrotate"]').val();
		data['hover']['2d_rotation'] = jQuery('input[name="hover_layer_2d_rotation"]').val(); //z rotate
		data['hover']['css_cursor'] = jQuery('select[name="css_cursor"] option:selected').val();
		
		data['hover']['speed'] = jQuery('input[name="hover_speed"]').val();
		data['hover']['easing'] = jQuery('select[name="hover_easing"] option:selected').val();
		
		layer = UniteLayersRev.getCurrentLayer();
		
		data['settings'] = new Object;
		data['settings']['hover'] = jQuery('input[name="hover_allow"]').is(":checked");
		data['settings']['type'] = layer.type;
		
		data['advanced'] = {'idle':{},'hover':{}};
		
		setFullClass();
		
		if(typeof(curFullClass['advanced']) !== 'undefined'){
			if(typeof(curFullClass['advanced']['idle']) !== 'undefined') data['advanced']['idle'] = curFullClass['advanced']['idle'];
			if(typeof(curFullClass['advanced']['hover']) !== 'undefined') data['advanced']['hover'] = curFullClass['advanced']['hover'];
		}
		
		var donow = (new_style === true) ? 'insert_captions_css' : 'update_captions_css'; // ? create new : update existing
		
		
		//make changes to database
		UniteAdminRev.ajaxRequest(donow,data,function(response){
			
			UniteLayersRev.setCaptionClasses(response.arrCaptions);
			
			t.updateCaptionsInput(response.arrCaptions);
			
			t.setInitCssStylesObj(response.initstyles);
			
			if(response.compressed_css !== 'undefined'){
				t.refresh_css(response.compressed_css);
			}
			
			if(typeof(dialog_obj) !== 'undefined') dialog_obj.dialog('close');
			
			jQuery('#layer_caption').val(handle);
			jQuery('#layer_caption').change();
		});
		
	}
	
	
	/**
	 * save styles for class/create new class
	 * @since: 5.0
	 */
	t.saveTemplateStylesInDb = function(){
		var data = {};
		
		var handle = cssPreClass+'.'+jQuery('#layer_caption').val();
		var cssData = g_codemirrorCssEditable.getValue();
		
		while(cssData.indexOf("/*") !== -1){
			if(cssData.indexOf("*/") === -1) return false;
			var start = cssData.indexOf("/*");
			var end = cssData.indexOf("*/") + 2;
			cssData = cssData.replace(cssData.substr(start, end - start), '');
		}
		
		//delete all before the }
		if(cssData.indexOf('{') > -1){
			var temp = cssData.substr(0,cssData.indexOf('{'));
			cssData = cssData.replace(temp, '');
		}
		
		//delete all after the }
		if(cssData.indexOf('}') > -1){
			cssData = cssData.substr(0,cssData.indexOf('}'));
		}
		
		cssData = cssData.replace(/{/g, '').replace(/}/g, '').replace(/	/g, '').replace(/\n/g, '');
		
		var rs_css = cssData.split(';');
		
		var adv_styles = {};
		
		for(var key in rs_css){
			if(jQuery.trim(rs_css[key]) == '') continue;
			var t_style = rs_css[key].split(':');
			if(t_style.length !== 2) continue;
			
			adv_styles[jQuery.trim(t_style[0])] = jQuery.trim(t_style[1]);
		}
		
		if(jQuery.isEmptyObject(adv_styles)) adv_styles = '';
		
		data['handle'] = handle;
		data['styles'] = adv_styles;
		data['type'] = cur_editing;
		
		UniteAdminRev.ajaxRequest("update_captions_advanced_css",data,function(response){
			
			if(response.success !== false){
				//update html select (got as "data" from response)
				
				UniteLayersRev.setCaptionClasses(response.arrCaptions);
			
				t.updateCaptionsInput(response.arrCaptions);
				
				t.setInitCssStylesObj(response.initstyles);
				
				if(response.compressed_css !== 'undefined'){
					t.refresh_css(response.compressed_css);
				}
				
				//refresh initCSS
				curFullClass['advanced'][data['type']] = data['styles'];
				
				var id = t.checkIfHandleExists(jQuery('#layer_caption').val());
				
				t.updateInitCssStyles(jQuery('#layer_caption').val(), id);
				
				jQuery('#dialog_advanced_css').dialog("close");
				
			}
		});
		
	}
	
	
	var updateLayerCSS = function(){
		var layer = UniteLayersRev.getCurrentLayer();
		
		if(layer === null) return false;
		
		var data = {};
		
		var cssData = g_codemirrorCssLayer.getValue();
		
		while(cssData.indexOf("/*") !== -1){
			if(cssData.indexOf("*/") === -1) return false;
			var start = cssData.indexOf("/*");
			var end = cssData.indexOf("*/") + 2;
			cssData = cssData.replace(cssData.substr(start, end - start), '');
		}
		
		//delete all before the }
		if(cssData.indexOf('{') > -1){
			var temp = cssData.substr(0,cssData.indexOf('{'));
			cssData = cssData.replace(temp, '');
		}
		
		//delete all after the }
		if(cssData.indexOf('}') > -1){
			cssData = cssData.substr(0,cssData.indexOf('}'));
		}
		
		cssData = cssData.replace(/{/g, '').replace(/}/g, '').replace(/	/g, '').replace(/\n/g, '');
		
		var rs_css = cssData.split(';');
		
		var adv_styles = {};
		
		for(var key in rs_css){
			if(jQuery.trim(rs_css[key]) == '') continue;
			var t_style = rs_css[key].split(':');
			if(t_style.length !== 2) continue;
			
			adv_styles[jQuery.trim(t_style[0])] = jQuery.trim(t_style[1]);
		}
		
		if(typeof(layer['inline']) === 'undefined') layer['inline'] = {};
		if(typeof(layer['inline'][cur_editing]) === 'undefined') layer['inline'][cur_editing] = {};
		
		layer['inline'][cur_editing] = adv_styles;
		
		tpLayerTimelinesRev.rebuildLayerIdle(jQuery('.slide_layer.layer_selected'));
		//refresh building of layer css
	}
	
	/**
	 * rename class name in database with a new one
	 * @since: 5.0
	 */
	t.renameStylesInDb = function(old_name, new_name){
		
		var data = {};
		
		data.old_name = old_name;
		data.new_name = new_name;
		
		UniteAdminRev.ajaxRequest("rename_captions_css",data,function(response){
			
			UniteLayersRev.setCaptionClasses(response.arrCaptions);
			
			//update html select (got as "data" from response)
			t.updateCaptionsInput(response.arrCaptions);
			
			
			t.setInitCssStylesObj(response.initstyles);
			
			if(response.compressed_css !== 'undefined'){
				t.refresh_css(response.compressed_css);
			}
			
			var objUpdate = {};
			objUpdate.style = new_name;
			
			var layers = UniteLayersRev.getSimpleLayers();
			
			for(var key in layers){
				if(layers[key].style == old_name){
					UniteLayersRev.updateLayer(key, objUpdate);
				}
			}
			
			jQuery('#layer_caption').val(new_name);
			jQuery('#layer_caption').change();
			
			jQuery('#dialog_rename_css').dialog('close');
			
		});
		
		t.updateInitCssStyles(old_name, -1); //-1 is for ignore
		
		curFullClass = new Object;
		curActiveStyles = new Object;
		
	}
	
	
	/**
	 * delete class from db if exists
	 */
	t.deleteStylesInDb = function(handle, id){
		UniteAdminRev.setErrorMessageID("dialog_error_message");
		
		UniteAdminRev.ajaxRequest("delete_captions_css",handle,function(response){
			
			UniteLayersRev.setCaptionClasses(response.arrCaptions);
			
			//update html select (got as "data" from response)
			t.updateCaptionsInput(response.arrCaptions);
			
			t.setInitCssStylesObj(response.initstyles);
			
			if(response.compressed_css !== 'undefined'){
				t.refresh_css(response.compressed_css);
			}
		});
		
		t.updateInitCssStyles(handle, id, true);
		
		jQuery('#layer_caption').val('');
		
		curFullClass = new Object;
		curActiveStyles = new Object;
		
	}
	
	
	/**
	 * fill temp class with init class if found
	 */
	var setFullClass = function(){
		curFullClass = new Object;
		
		for(var key in initCssStyles){
			if(initCssStyles[key]['handle'] == cssPreClass+'.'+jQuery("#layer_caption").val()){
				curFullClass = jQuery.extend({},initCssStyles[key]);
				break;
			}
		}
	}
	
	
	/**
	 * check if class exists and return index
	 */
	t.checkIfHandleExists = function(handle){
		for(var key in initCssStyles){
			if(initCssStyles[key]['handle'] == cssPreClass+'.'+handle){
				return key;
			}
		}
		return false;
	}
	
	/**
	 * update the select html, set selected option, and update events.
	 */
	t.updateCaptionsInput = function(arrCaptions){
		layer = UniteLayersRev.getCurrentLayer();
		
		var use_captions = [];
		
		if(layer !== false){
			switch(layer.type){
				case 'image':
					//add image classes
					for(var key in arrCaptions){
						if(arrCaptions[key]['type'] == 'image'){
							use_captions.push(arrCaptions[key]);
						}
					}
				break;
				case 'button':
					//add button classes
					for(var key in arrCaptions){
						if(arrCaptions[key]['type'] == 'button'){
							use_captions.push(arrCaptions[key]);
						}
					}
				break;
				case 'shape':
					//add shape classes
					for(var key in arrCaptions){
						if(arrCaptions[key]['type'] == 'shape'){
							use_captions.push(arrCaptions[key]);
						}
					}
				break;
				default:
					//add all except button and shape
					for(var key in arrCaptions){
						if(arrCaptions[key]['type'] == 'text'){
							use_captions.push(arrCaptions[key]);
						}
					}
				break;
			}
		}
		
		jQuery("#layer_caption").catcomplete("option","source",use_captions);
	}
	
	/**
	 * update css object with new values
	 */
	t.updateInitCssStyles = function(handle, id, doDelete){
		var key = false;
		
		for(var i in initCssStyles){
			if(initCssStyles[i]['handle'] == cssPreClass+'.'+handle){
				key = i;
				break;
			}
		}
		
		if(typeof doDelete !== 'undefined'){
			delete initCssStyles[key];
			return true;
		}
		
		if(key === false) key = initCssStyles.length;
		
		if(id === false){
			id = initCssStyles.length;
			initCssStyles[key] = new Object;
			initCssStyles[key]['id'] = id;
			initCssStyles[key]['handle'] = cssPreClass+'.'+handle;
			initCssStyles[key]['params'] = [];
			initCssStyles[key]['hover'] = [];
			initCssStyles[key]['settings'] = [];
			initCssStyles[key]['advanced'] = {'hover':{},'idle':{}};
		}
		
		initCssStyles[key]['params'] = curFullClass['params'];
		initCssStyles[key]['hover'] = curFullClass['hover'];
		initCssStyles[key]['advanced'] = curFullClass['advanced'];
		if(typeof(initCssStyles[key]['settings']) == 'undefined')
			initCssStyles[key]['settings'] = new Object;
		
		initCssStyles[key]['settings']['hover'] = isHoverActive;
		
		return initCssStyles[key];
	}
	
	
	t.refresh_css = function(compressed_css){
		var remstyles = jQuery('#rs-plugin-settings-css').next();
		if(remstyles.is('style')){
			remstyles.html(compressed_css);
		}
	}
	
	
	t.getStyleSettingsByHandle = function(handle){
		for(var key in initCssStyles){
			if(initCssStyles[key]['handle'] == cssPreClass+'.'+handle){
				return initCssStyles[key];
			}
		}
		return false;
	}
	
	
	t.set_state = function(obj, handle, selector, def,  type, value){
		
		if(value === undefined){
			switch(type){
				case 'select':
					value = jQuery(selector+' option:selected').val();
				break;
				case 'multi':
					value = {};
					jQuery(selector).each(function(i){
						value[i] = jQuery(this).val();
					});
				break;
				default:
					value = jQuery(selector).val();
				break;
			}
		}
		
		//check if suffix is available, if yes, check both
		var suffix = '';
		if(typeof(jQuery(selector).data('suffix')) !== 'undefined') suffix = jQuery(selector).data('suffix');		
		if(typeof(obj[handle]) === 'undefined'){ //check if default value, if not then do differentthandefault
			//check def with value
			if(def == value || def+suffix == value){
				jQuery(selector).removeClass('differentthandefault');
				jQuery(selector).css('color', '#777');
			}else{
				jQuery(selector).addClass('differentthandefault');
				//jQuery(selector).css('color', '#F00');
			}
			if(typeof(def) === 'object'){ //if object
				var def_s = '';
				var val_s = '';
				var val_su = '';
				for(var key in def){
					if(def[key] == '') continue;
					def_s += def[key]+suffix;
				}
				for(var key in value){
					if(value[key] == '') continue;
					val_s += value[key];
					val_su += value[key]+suffix;
				}
				
				if(def_s===val_s || def_s===val_su){ //check again since its object
					jQuery(selector).removeClass('differentthandefault');
					jQuery(selector).css('color', '#777');
				}
			}
			
		}else if(typeof(obj[handle]) === 'object'){
			var def_s = '';
			var val_s = '';
			var val_su = '';
			for(var key in obj[handle]){
				if(obj[handle][key] == '') continue;
				def_s += obj[handle][key]+suffix;
			}
			for(var key in value){
				if(value[key] == '') continue;
				val_s += value[key];
				val_su += value[key]+suffix;
			}
			if(def_s===val_s || def_s===val_su){ //check again since its object
				jQuery(selector).removeClass('differentthandefault');
				jQuery(selector).css('color', '#777');
			}else{
				jQuery(selector).addClass('differentthandefault');
				//jQuery(selector).css('color', '#F00');
			}
		}else if(obj[handle] !== value && obj[handle]+suffix !== value){
			if(typeof(value) === 'object'){
				
				var cval = obj[handle].split(' ');
				var tempvar = '';
				switch(cval.length){
					case 1:
						tempvar = cval[0]+cval[0]+cval[0]+cval[0];
					break;
					case 2:
						tempvar = cval[0]+cval[1]+cval[0]+cval[1];
					break;
					case 3:
						tempvar = cval[0]+cval[1]+cval[2]+cval[1];
					break;
				}
				
				val_s = '';
				val_su = '';
				for(var key in value){
					if(value[key] == '') continue;
					val_s += value[key];
					val_su += value[key]+suffix;
				}
				
				if(tempvar == val_s || tempvar == val_su){
					jQuery(selector).removeClass('differentthandefault');
					jQuery(selector).css('color', '#777');
				}else{
					jQuery(selector).addClass('differentthandefault');
					//jQuery(selector).css('color', '#F00');
				}
			}else{
				jQuery(selector).addClass('differentthandefault');
				//jQuery(selector).css('color', '#F00');
			}
			
		}else{
			jQuery(selector).removeClass('differentthandefault');
			jQuery(selector).css('color', '#777');
		}
		
	}
	
	
	/**
	 * Compare current CSS settings to original settings and point out the differences
	 */
	t.compare_to_original = function(){
		var original_handle = jQuery('#layer_caption').val();
		
		orig_styles = t.getStyleSettingsByHandle(original_handle);
		
		if(orig_styles === false) return false; //maybe set all to be different state?
		
		if(typeof(orig_styles['params']) !== 'undefined'){
			var idle = orig_styles['params'];
			var italic = jQuery('input[name="css_font-style"]').is(':checked') ? 'italic' : 'normal';
			t.set_state(idle, 'color-transparency', 'input[name="css_font-transparency"]', '1');
			t.set_state(idle, 'font-style', 'input[name="css_font-style"]', 'normal', 'checkbox', italic);
			t.set_state(idle, 'font-family', 'input[name="css_font-family"]', '');
			t.set_state(idle, 'padding', 'input[name="css_padding[]"]', {0:'0', 1:'0', 2:'0', 3:'0'}, 'multi');
			t.set_state(idle, 'text-decoration', 'select[name="css_text-decoration"]', 'none', 'select');
			t.set_state(idle, 'background-color', 'input[name="css_background-color"]', 'transparent');
			t.set_state(idle, 'background-transparency', 'input[name="css_background-transparency"]', '1');
			t.set_state(idle, 'border-color', 'input[name="css_border-color-show"]', 'transparent');
			t.set_state(idle, 'border-transparency', 'input[name="css_border-transparency"]', '1');
			t.set_state(idle, 'border-style', 'select[name="css_border-style"]', 'none', 'select');
			t.set_state(idle, 'border-width', 'input[name="css_border-width"]', '0');
			t.set_state(idle, 'border-radius', 'input[name="css_border-radius[]"]', {0:'0', 1:'0', 2:'0', 3:'0'}, 'multi');
			t.set_state(idle, 'x', 'input[name="layer__x"]', '0');
			t.set_state(idle, 'y', 'input[name="layer__y"]', '0');
			t.set_state(idle, 'z', 'input[name="layer__z"]', '0');
			t.set_state(idle, 'skewx', 'input[name="layer__skewx"]', '0');
			t.set_state(idle, 'skewy', 'input[name="layer__skewy"]', '0');
			t.set_state(idle, 'scalex', 'input[name="layer__scalex"]', '1');
			t.set_state(idle, 'scaley', 'input[name="layer__scaley"]', '1');
			t.set_state(idle, 'opacity', 'input[name="layer__opacity"]', '1');
			t.set_state(idle, 'xrotate', 'input[name="layer__xrotate"]', '0');
			t.set_state(idle, 'yrotate', 'input[name="layer__yrotate"]', '0');
			t.set_state(idle, '2d_rotation', 'input[name="layer_2d_rotation"]', '0');
			t.set_state(idle, '2d_origin_x', 'input[name="layer_2d_origin_x"]', '50');
			t.set_state(idle, '2d_origin_y', 'input[name="layer_2d_origin_y"]', '50');
			t.set_state(idle, 'pers', 'input[name="layer__pers"]', '600');
			t.set_state(idle, 'corner_left', 'select[name="layer_cornerleft"]', 'nothing', 'select');
			t.set_state(idle, 'corner_right', 'select[name="layer_cornerright"]', 'nothing', 'select');
		}
		
		if(typeof(orig_styles['hover']) !== 'undefined' && !jQuery.isEmptyObject(orig_styles['hover'])){
			var hover = orig_styles['hover'];
			

			t.set_state(hover, 'color', 'input[name="hover_color_static"]');
			t.set_state(hover, 'color-transparency', 'input[name="hover_css_font-transparency"]', '1');
			t.set_state(hover, 'text-decoration', 'select[name="hover_css_text-decoration"]', 'none', 'select');
			t.set_state(hover, 'background-color', 'input[name="hover_css_background-color"]', 'transparent');
			t.set_state(hover, 'background-transparency', 'input[name="hover_css_background-transparency"]', '1');
			t.set_state(hover, 'border-color', 'input[name="hover_css_border-color-show"]', 'transparent');
			t.set_state(hover, 'border-transparency', 'input[name="hover_css_border-transparency"]', '1');
			t.set_state(hover, 'border-style', 'select[name="hover_css_border-style"]', 'none', 'select');
			t.set_state(hover, 'border-width', 'input[name="hover_css_border-width"]', '0', 'select');
			t.set_state(hover, 'border-radius', 'input[name="hover_css_border-radius[]"]', {0:'0', 1:'0', 2:'0', 3:'0'}, 'multi');
			
			t.set_state(hover, 'skewx', 'input[name="hover_layer__skewx"]', '0');
			t.set_state(hover, 'skewy', 'input[name="hover_layer__skewy"]', '0');
			t.set_state(hover, 'scalex', 'input[name="hover_layer__scalex"]', '1');
			t.set_state(hover, 'scaley', 'input[name="hover_layer__scaley"]', '1');
			t.set_state(hover, 'opacity', 'input[name="hover_layer__opacity"]', '1');
			t.set_state(hover, 'xrotate', 'input[name="hover_layer__xrotate"]', '0');
			t.set_state(hover, 'yrotate', 'input[name="hover_layer__yrotate"]', '0');
			t.set_state(hover, '2d_rotation', 'input[name="hover_layer_2d_rotation"]', '0');
			t.set_state(hover, 'css_cursor', 'select[name="css_cursor"]', 'auto', 'select');
			
			t.set_state(hover, 'speed', 'input[name="hover_speed"]', '0');
			t.set_state(hover, 'easing', 'select[name="hover_easing"]', '50', 'select');
		}
		
		return true;
		
	}
	
}