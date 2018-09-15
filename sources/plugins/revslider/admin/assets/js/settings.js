
var RevSliderSettings = new function(){
	
	var arrControls = {};
	var colorPicker;
	
	var t=this;
	
	this.getSettingsObject = function(formID){
		var obj = new Object();
		var form = document.getElementById(formID);
		var name,value,type,flagUpdate;
		
		//enabling all form items connected to mx
		var len = form.elements.length;
		for(var i=0; i<len; i++){
			var element = form.elements[i];
			
			if(element.name == "##NAME##[]") continue; //ignore dummy from multi text
			if(jQuery(element).hasClass("rs-ingore-save")) continue; //ignore some fields that do not need to be saved
			
			name = element.name;
			value = element.value;
			
			type = element.type;
			if(jQuery(element).hasClass("wp-editor-area"))
				type = "editor";
			
			flagUpdate = true;
			
			switch(type){
				case "checkbox":
					if(typeof(form.elements[i].getAttribute('data-useval')) !== 'undefined' && form.elements[i].getAttribute('data-useval') !== null){
						if(form.elements[i].checked){
							value = form.elements[i].value;
						}else{ continue; };
					}else if(typeof(form.elements[i].getAttribute('data-unchecked')) !== 'undefined' && form.elements[i].getAttribute('data-unchecked') !== null){
						value = (form.elements[i].checked) ? value : form.elements[i].getAttribute('data-unchecked');
					}else{
						value = form.elements[i].checked;
					}
				break;
				case "radio":
					if(form.elements[i].checked == false) 
						flagUpdate = false;
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
	 * combine controls to one object, and init control events.
	 * OBSOLETE?
	 */
	var initControls = function(){
		
		//combine controls
		if(typeof g_settingsObj !== 'undefined'){
			for(key in g_settingsObj){
				var obj = g_settingsObj[key];
				
				for(controlKey in obj.controls){
					arrControls[controlKey] = obj.controls[controlKey];				
				}
			}
		}
	}
	
	
	/**
	 * close all accordion items
	 */
	var closeAllAccordionItems = function(formID){
		jQuery("#"+formID+" .unite-postbox .inside").slideUp("fast");
		jQuery("#"+formID+" .unite-postbox h3").addClass("box_closed");
	}
	
	/**
	 * init side settings accordion - started from php
	 */
	t.initAccordion = function(formID){
		var classClosed = "box_closed";
		jQuery("#"+formID+" .unite-postbox h3").click(function(){
			var handle = jQuery(this);
			
			//open
			if(handle.hasClass(classClosed)){
				closeAllAccordionItems(formID);
				handle.removeClass(classClosed).siblings(".inside").slideDown("fast");
			}else{	//close
				handle.addClass(classClosed).siblings(".inside").slideUp("fast");
			}
			
		});
	}
	
	/**
	 * image search
	 */
	var initImageSearch = function(){
		
		jQuery(".button-image-select").click(function(){
			var settingID = this.id.replace("_button","");
			UniteAdminRev.openAddImageDialog("Choose Image",function(urlImage, imageID){
				//update input:
				jQuery("#"+settingID).val(urlImage);
				
				//update preview image:
				var urlShowImage = UniteAdminRev.getUrlShowImage(imageID,100,70,true);
				jQuery("#" + settingID + "_button_preview").html('<div style="width:100px;height:70px;background:url(\''+urlShowImage+'\'); background-position:center center; background-size:cover;"></div>');
				jQuery('.show_on_thumbnail_exist').show();
				// Use Admin Thumbnail if Selected
				if (jQuery('#thumb_for_admin').attr('checked')=="checked") {
					var tbgimg = jQuery('#slide_thumb_button_preview div').css("background-image");			
					jQuery('#slide_selector .list_slide_links li.selected .slide-media-container').css({"background-image":tbgimg, backgroundSize:"cover",backgroundPosition:"center center"});
				}
			});
		});
		
		jQuery(".button-image-remove").click(function(){
			var settingID = this.id.replace("_button_remove","");
			jQuery("#"+settingID).val('');
			
			jQuery("#" + settingID + "_button_preview").html('');
			jQuery('.show_on_thumbnail_exist').hide();
		});
		
		jQuery(".button-image-select-video").click(function(){
			UniteAdminRev.openAddImageDialog("Choose Image",function(urlImage, imageID){
				
				//update input:
				jQuery("#input_video_preview").val(urlImage);
				
				//update preview image:
				var urlShowImage = UniteAdminRev.getUrlShowImage(imageID,200,150,true);
				jQuery("#video-thumbnail-preview").css({backgroundImage:'url('+urlShowImage+')'});
				
			});
		});
		
		jQuery(".button-image-remove-video").click(function(){
			jQuery("#input_video_preview").val('');

			if(jQuery('#video_block_vimeo').css('display') != 'none')
				jQuery("#button_vimeo_search").trigger("click");
			
			if(jQuery('#video_block_youtube').css('display') != 'none')
				jQuery("#button_youtube_search").trigger("click");
			
		});
		
		
		jQuery(".button-image-select-html5-video").click(function(){
			UniteAdminRev.openAddImageDialog("Choose Image",function(urlImage, imageID){
				//update input:
				jQuery("#html5_url_poster").val(urlImage);
			});
		});
		
	}
	
	
	
	/**
	 * init the settings function, set the tootips on sidebars.
	 */
	var init = function(){
		
		//init tipsy
		jQuery(".list_settings li .setting_text").tipsy({
			gravity:"e",
	        delayIn: 70
		});
		
		jQuery(".tipsy_enabled_top").tipsy({
			gravity:"s",
	        delayIn: 70
		});

		jQuery(".tipsy_enabled_top_left").tipsy({
			gravity:"se",
	        delayIn: 70
		});
		
		jQuery(".button-primary").tipsy({
			gravity:"s",
	        delayIn: 70
		});
		
		jQuery('input[type="checkbox"]').change(function(){
			RevSliderSettings.onoffStatus(jQuery(this));
		});
		
		//init controls
		initControls();
		
		initImageSearch();
		
		/****
		 * PREVIEW SLIDE/SLIDER SCRIPT
		 ****/
		
		jQuery('body').on('click', '.rs-close-preview', function(){
			var rs_form = jQuery('#rs-preview-form');
			rs_form.action = g_urlAjaxActions;
			jQuery("#preview-slide-data").val("empty_output");
			jQuery("#preview_sliderid").val("empty_output");
			
			jQuery('#rs-preview-wrapper').hide();
			
			rs_form.submit();
		});
		
		jQuery(document).keyup(function(e){
			if (e.keyCode == 27) jQuery('.rs-close-preview').click(); // 27 == esc
		});
		
		jQuery(window).resize(function() {
			jQuery('.rs-preview-width').text(jQuery('.rs-frame-preview-wrapper').width());
			jQuery('.rs-preview-height').text(jQuery('.rs-frame-preview-wrapper').height());
		});
		
	}
	
	
	t.createModernOnOff = function() {
		// CREATE AND HANLDE OF SINGLE INPUT BOXES BASED ON CHECKBOX
		jQuery(".tp-moderncheckbox").each(function() {
			var inp = jQuery(this);
			inp.wrap('<div class="tp-onoffbutton"><span class="tp-onoff-onstate">On</span><span class="tp-onoff-offstate">Off</span></div>');
			inp.change(function() {
				var inp = jQuery(this);						
				if (!inp.hasClass("changedbyclick"))
					t.onoffStatus(inp)
			});
		});

		// CREATE AND HANDLE OF INPUT BOXES BASED ON TWO INPUT BOXES WITH VALUE ON AND OFF
		jQuery(".tp-modernonoffboxes").each(function() {
			var inp = jQuery(this);
			inp.wrap('<div class="tp-onoffbutton tp-onoffbasedontwo"><span class="tp-onoff-onstate">On</span><span class="tp-onoff-offstate">Off</span></div>');			
			var inpon = inp.find('input[value="on"]'),
				inpoff = inp.find('input[value="off"]');
			inpon.change(function() {
				if (!inpon.hasClass("changedbyclick"))
					t.onoffStatusBasedOnTwo(inpon,inpoff);
			})
			inpoff.change(function() {
				if (!inpon.hasClass("changedbyclick"))
					t.onoffStatusBasedOnTwo(inpon,inpoff);
			})
			t.onoffStatusBasedOnTwo(inpon,inpoff);
		});

		jQuery('.tp-onoffbutton').each(function() {
			var cb = jQuery(this);
			cb.click(function() {
				var cb = jQuery(this);
				if (cb.hasClass("tp-onoffbasedontwo")) {
					var inpon = cb.find('input[value="on"]'),
						inpoff = cb.find('input[value="off"]');
					inpon.addClass("changedbyclick");
					setTimeout(function() {
						inpon.removeClass("changedbyclick");
					},200);
					if (inpon.attr('checked')===undefined || inpon.attr('checked')==false || inpon.attr("checked")=="") {
						inpon.attr('checked',"checked");
						inpoff.attr('checked',false);
					}
					else {
						inpon.attr('checked',false);						
						inpoff.attr('checked',"checked");
					}
					inpon.trigger("change");
					inpoff.trigger("change");
					t.onoffStatusBasedOnTwo(inpon,inpoff);
				} else {
					inp = cb.find('input');
					inp.addClass("changedbyclick");
					setTimeout(function() {
						inp.removeClass("changedbyclick");
					},200);
					if (inp.attr('checked')===undefined || inp.attr('checked')==false || inp.attr("checked")=="")
						inp.attr('checked',"checked");
					else
						inp.attr('checked',false);

					inp.trigger("change");
					t.onoffStatus(inp);
				}
			});
		});

		


	}

	t.onoffStatus = function(inp) {
		var cb = inp.closest('.tp-onoffbutton'),
			con = cb.find('.tp-onoff-onstate'),
			coff = cb.find('.tp-onoff-offstate');

		if (inp.attr('checked')===undefined || inp.attr('checked')==false || inp.attr("checked")=="") {
			punchgs.TweenLite.to(con,0.2,{left:"50px"});
			punchgs.TweenLite.to(coff,0.2,{left:"0px"});
		} else {
			punchgs.TweenLite.to(con,0.2,{left:"0px"});
			punchgs.TweenLite.to(coff,0.2,{left:"-50px"});
		}
	}

	t.onoffStatusBasedOnTwo = function(inpon,inpoff) {
		var cb = inpon.closest('.tp-onoffbutton'),
			con = cb.find('.tp-onoff-onstate'),
			coff = cb.find('.tp-onoff-offstate');

		if (inpon.attr('checked')===undefined || inpon.attr('checked')==false || inpon.attr("checked")=="") {
			punchgs.TweenLite.to(con,0.2,{left:"50px"});
			punchgs.TweenLite.to(coff,0.2,{left:"0px"});
		} else {
			punchgs.TweenLite.to(con,0.2,{left:"0px"});
			punchgs.TweenLite.to(coff,0.2,{left:"-50px"});
		}
	}
	
	
	//call "constructor"
	jQuery(document).ready(function(){
		init();
	});
	
} // UniteSettings class end


