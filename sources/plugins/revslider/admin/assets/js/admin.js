
var UniteAdminRev = new function(){
	
	var t = this;
	
	var errorMessageID = null;
	var successMessageID = null;
	var ajaxLoaderID = null;
	var ajaxHideButtonID = null;
	var g_multiple_text_key = [];
	
	//video dialog vars:
	var lastVideoData = null;		//last fetched data
	var lastVideoCallback = null;   //last callback from video dialog return
	var colorPickerCallback = null;
	var video_found = false;
	

	/**********************************
		-	SHOW INFO AND HIDE INFO	-
	********************************/

	t.showInfo = function(obj) {

		var info = '<i class="eg-icon-info"></i>';
		if (obj.type=="warning") info = '<i class="eg-icon-cancel"></i>';
		if (obj.type=="success") info = '<i class="eg-icon-ok"></i>';

		obj.showdelay = obj.showdelay != undefined ? obj.showdelay : 0;
		obj.hidedelay = obj.hidedelay != undefined ? obj.hidedelay : 0;

		// CHECK IF THE TOOLBOX WRAPPER EXIST ALREADY
		if (jQuery('#eg-toolbox-wrapper').length==0) jQuery('#viewWrapper').append('<div id="eg-toolbox-wrapper"></div>');

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
	 * Find absolute position on the screen of some element
	 */	
	t.getAbsolutePos = function(obj){
	  var curleft = curtop = 0;
		if (obj.offsetParent) {
			curleft = obj.offsetLeft;
			curtop = obj.offsetTop;
			while (obj = obj.offsetParent) {
				curleft += obj.offsetLeft;
				curtop += obj.offsetTop;
			}
		}			
		return[curleft,curtop];
	}	
	
	t.stripslashes = function(str) {
		return (str + '').replace(/\\(.?)/g, function (s, n1) {
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
	 * set callback on color picker movement
	 */
	t.setColorPickerCallback = function(callbackFunc){
		colorPickerCallback = callbackFunc;
	}
	
	/**
	 * on color picker event. Pass the event further
	 */
	t.onColorPickerMoveEvent = function(event){
		
		if(typeof colorPickerCallback == "function")
			colorPickerCallback(event);
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
	 * change rgb & rgba to hex
	 */
	t.rgb2hex = function(rgb) {
		if (rgb.search("rgb") == -1 || jQuery.trim(rgb) == '') return rgb; //ie6
		
		function hex(x) {
			return ("0" + parseInt(x).toString(16)).slice(-2);
		}
		
		if(rgb.indexOf('-moz') > -1){
			var temp = rgb.split(' ');
			delete temp[0];
			rgb = jQuery.trim(temp.join(' '));
		}
		
		if(rgb.split(')').length > 2){
			var hexReturn = '';
			var rgbArr = rgb.split(')');
			for(var i = 0; i < rgbArr.length - 1; i++){
				rgbArr[i] += ')';
				var temp = rgbArr[i].split(',');
				if(temp.length == 4){
					rgb = temp[0]+','+temp[1]+','+temp[2];
					rgb += ')';
				}else{
					rgb = rgbArr[i];
				}
				rgb = jQuery.trim(rgb);
				
				rgb = rgb.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+))?\)$/);
				
				hexReturn += "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3])+" ";
			}
			
			return hexReturn;
		}else{
			var temp = rgb.split(',');
			if(temp.length == 4){
				rgb = temp[0]+','+temp[1]+','+temp[2];
				rgb += ')';
			}
			
			rgb = rgb.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+))?\)$/);
			
			return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
		}
	}
	
	
	/**
	 * get transparency value from 0 to 100
	 */
	t.getTransparencyFromRgba = function(rgba, inPercent){
		var temp = rgba.split(',');
		if(temp.length == 4){
			inPercent = (typeof inPercent !== 'undefined') ? inPercent : true;
			return (inPercent) ? temp[3].replace(/[^\d.]/g, "") : temp[3].replace(/[^\d.]/g, "") * 100;
		}
		
		return false;
	}
	
	
	/**
	 * debug html on the top of the page (from the master view)
	 */
	t.debug = function(html){
		jQuery("#div_debug").show().html(html);
	}
	
	
	/**
	 * output data to console
	 */
	t.trace = function(data,clear){
		if(clear && clear == true)
			console.clear();	
		console.log(data);
	}
	
	
	/**
	 * show error message or call once custom handler function
	 */
	t.showErrorMessage = function(htmlError){
		t.showInfo({content:htmlError, type:"warning", showdelay:0, hidedelay:3, hideon:"", event:"" });
		
		showAjaxButton();
	}

	
	/**
	 * hide error message
	 */
	var hideErrorMessage = function(){
		if(errorMessageID !== null){
			jQuery("#"+errorMessageID).hide();
			errorMessageID = null;
		}else
			jQuery("#error_message").hide();
	}
	
	
	/**
	 * set error message id
	 */
	t.setErrorMessageID = function(id){
		errorMessageID = id;
	}
	
	
	/**
	 * set success message id
	 */
	t.setSuccessMessageID = function(id){
		successMessageID = id;
	}
	
	
	/**
	 * show success message
	 */
	var showSuccessMessage = function(htmlSuccess){
		
		t.showInfo({content:htmlSuccess, type:"success", showdelay:0, hidedelay:1, hideon:"", event:"" });
		
		showAjaxButton();
	}
	
	
	/**
	 * hide success message
	 */
	this.hideSuccessMessage = function(){
		
		if(successMessageID){
			jQuery("#"+successMessageID).hide();
			successMessageID = null;	//can be used only once.
		}
		else
			jQuery("#success_message").slideUp("slow").fadeOut("slow");
		
		showAjaxButton();
	}
	
	
	/**
	 * set ajax loader id that will be shown, and hidden on ajax request
	 * this loader will be shown only once, and then need to be sent again.
	 */
	this.setAjaxLoaderID = function(id){
		ajaxLoaderID = id;
	}
	
	/**
	 * show loader on ajax actions
	 */
	var showAjaxLoader = function(){
		if(ajaxLoaderID)
			jQuery("#"+ajaxLoaderID).show();
	}
	
	/**
	 * hide and remove ajax loader. next time has to be set again before "ajaxRequest" function.
	 */
	var hideAjaxLoader = function(){
		if(ajaxLoaderID){
			jQuery("#"+ajaxLoaderID).hide();
			ajaxLoaderID = null;
		}
	}
	
	/**
	 * set button to hide / show on ajax operations.
	 */
	this.setAjaxHideButtonID = function(buttonID){
		ajaxHideButtonID = buttonID;
	}
	
	/**
	 * if exist ajax button to hide, hide it.
	 */
	var hideAjaxButton = function(){
		if(ajaxHideButtonID){
			var doHide = ajaxHideButtonID.split(',');
			if(doHide.length > 1){
				for(var i = 0; i < doHide.length; i++){
					jQuery("#"+doHide[i]).hide();
				}
			}else{
				jQuery("#"+ajaxHideButtonID).hide();
			}
		}
	}
	
	/**
	 * if exist ajax button, show it, and remove the button id.
	 */
	var showAjaxButton = function(){
		if(ajaxHideButtonID){
			var doShow = ajaxHideButtonID.split(',');
			if(doShow.length > 1){
				for(var i = 0; i < doShow.length; i++){
					jQuery("#"+doShow[i]).show();
				}
			}else{
				jQuery("#"+ajaxHideButtonID).show();
			}
			ajaxHideButtonID = null;
		}		
	}
	
	
	/**
	 * Ajax request function. call wp ajax, if error - print error message.
	 * if success, call "success function" 
	 */
	t.ajaxRequest = function(action,data,successFunction,hideOverlay,hideError){
		
		var objData = {
			action:g_uniteDirPlugin+"_ajax_action",
			client_action:action,
			nonce:g_revNonce,
			data:data
		}
		
		hideErrorMessage();
		showAjaxLoader();
		hideAjaxButton();
		
		if(hideOverlay===undefined) 			
			showWaitAMinute({fadeIn:300,text:rev_lang.please_wait_a_moment});
		
		
		jQuery.ajax({
			type:"post",
			url:ajaxurl,
			dataType: 'json',
			data:objData,
			success:function(response){
				if(hideOverlay===undefined && !response.is_redirect)
					showWaitAMinute({fadeOut:300});
				
				hideAjaxLoader();
				
				if(!response){
					t.showErrorMessage("Empty ajax response!");
					return(false);
				}

				if(response == -1){
					t.showErrorMessage("ajax error!!!");
					return(false);
				}
				
				if(response == 0){
					t.showErrorMessage("ajax error, action: <b>"+action+"</b> not found");
					return(false);
				}
				
				if(response.success == undefined){
					t.showErrorMessage("The 'success' param is a must!");
					return(false);
				}
				
				if(response.success == false){
					if(hideError===undefined){
						t.showErrorMessage(response.message);
						return(false);
					}else{
						if(typeof successFunction == "function"){
							successFunction(response);
						}
					}
				}else{
					
					//success actions:

					//run a success event function
					if(typeof successFunction == "function"){
						successFunction(response);
					}
					
					if(response.message)
						showSuccessMessage(response.message);
					
					if(response.is_redirect)
						location.href=response.redirect_url;
				}
			},		 	
			error:function(jqXHR, textStatus, errorThrown){
				if(hideOverlay===undefined)
					showWaitAMinute({fadeOut:300});
				
				hideAjaxLoader();
				
				if(textStatus == "parsererror")
					t.debug(jqXHR.responseText);
				
				t.showErrorMessage("Ajax Error!!! " + textStatus);
			}
		});
		
	}//ajaxrequest
	
	
	/**
	 * open new add image dialog
	 */
	var openNewImageDialog = function(title,onInsert,isMultiple){
		
		if(isMultiple == undefined)
			isMultiple = false;
		
		// Media Library params
		var frame = wp.media({
			//frame:      'post',
            //state:      'insert',
			title : title,
			multiple : isMultiple,
			library : { type : 'image' },
			button : { text : 'Insert' }
		});

		// Runs on select
		frame.on('select',function(){
			var objSettings = frame.state().get('selection').first().toJSON();
			
			var selection = frame.state().get('selection');
			var arrImages = [];
			
			if(isMultiple == true){		//return image object when multiple
			    selection.map( function( attachment ) {
			    	var objImage = attachment.toJSON();
			    	var obj = {};
			    	obj.url = objImage.url;
			    	obj.id = objImage.id;
			    	obj.width = objImage.width;
			    	obj.height = objImage.height;
			    	arrImages.push(obj);
			    });
				onInsert(arrImages);
			}else{		//return image url and id - when single
				onInsert(objSettings.url,objSettings.id,objSettings.width,objSettings.height);
			}
			    
		});

		// Open ML
		frame.open();
	}
	
	
	/**
	 * open old add image dialog
	 */
	var openOldImageDialog = function(title,onInsert){
		var params = "type=image&post_id=0&TB_iframe=true";
		
		params = encodeURI(params);
		
		tb_show(title,'media-upload.php?'+params);
		
		window.send_to_editor = function(html) {
			 tb_remove();
			 var urlImage = jQuery(html).attr('src');
			 if(!urlImage || urlImage == undefined || urlImage == "")
				var urlImage = jQuery('img',html).attr('src');
			
			onInsert(urlImage,"");	//return empty id, it can be changed
		}
	}
	
	
	/**
	 * open add video dialog
	 */
	var openNewVideoDialog = function(title,onInsert,isMultiple){
		
		if(isMultiple == undefined)
			isMultiple = false;
		
		// Media Library params
		var frame = wp.media({
			//frame:      'post',
            //state:      'insert',
			title : title,
			multiple : isMultiple,
			library : { }, //type : 'video'
			button : { text : 'Insert' }
		});

		// Runs on select
		frame.on('select',function(){
			var objSettings = frame.state().get('selection').first().toJSON();
			
			var selection = frame.state().get('selection');
			var arrVideos = [];
			
			if(isMultiple == true){		//return video object when multiple
			    selection.map( function( attachment ) {
			    	var objVideo = attachment.toJSON();
			    	var obj = {};
			    	obj.url = objVideo.url;
			    	obj.id = objVideo.id;
			    	obj.width = objVideo.width;
			    	obj.height = objVideo.height;
			    	arrVideos.push(obj);
			    });
				onInsert(arrVideos);
			}else{		//return image url and id - when single
				onInsert(objSettings.url,objSettings.id,objSettings.width,objSettings.height);
			}
			
		});

		// Open ML
		frame.open();
	}
	
	
	t.openAddImageDialog = function(title,onInsert,isMultiple){
		
		if(!title)
			title = rev_lang.select_image;
		
		if(typeof wp != "undefined" && typeof wp.media != "undefined")
			openNewImageDialog(title,onInsert,isMultiple);
		else{
			openOldImageDialog(title,onInsert);
		}
		
	}
	
	
	t.openAddVideoDialog = function(title,onInsert,isMultiple){
		
		if(!title)
			title = rev_lang.select_image;
		
		if(typeof wp != "undefined" && typeof wp.media != "undefined")
			openNewVideoDialog(title,onInsert,isMultiple);
		
	}
	
	
	/**
	 * load css file on the fly
	 * replace current item if exists
	 */
	t.loadCssFile = function(urlCssFile,replaceID){
		
		var rand = Math.floor((Math.random()*100000)+1);
		
		urlCssFile += "?rand="+rand;
		
		if(replaceID)
			jQuery("#"+replaceID).remove();
		
		jQuery("head").append("<link>");
		var css = jQuery("head").children(":last");
		css.attr({
		      rel:  "stylesheet",
		      type: "text/css",
		      href: urlCssFile
		});
		
		//replace current element
		if(replaceID)
			css.attr({id:replaceID});
	}
	
	
	/**
	 * get show image url
	 */
	t.getUrlShowImage = function(imageID,width,height,exact){
		
		imageID = parseInt(imageID, 0)
		
		var urlImage = g_urlAjaxShowImage+"&img="+imageID;
		
		if(width)
			urlImage += "&w="+width;
		
		if(height)
			urlImage += "&h="+height;
		
		if(exact && exact == true)
			urlImage += "&t=exact";
		
		return(urlImage);
	}
	
	
	/**
	 * set html to youtube dialog
	 * if empty data - clear the dialog
	 */
	var setYoutubeDialogHtml = function(data){
		
		//if empty data - clear the dialog
		if(!data){
			jQuery("#video_content").html("");
			return(false);
		}
		
		var thumb = data.thumb_medium;
		
		var useURL = (jQuery.trim(jQuery('#input_video_preview').val()) != '') ? jQuery('#input_video_preview').val() : thumb.url;
		
		var html = '<div class="video-thumbnail-all-wrapper">';
		html += '<div class="video-thumbnail-preview-wrapper"><div id="video-thumbnail-preview" style="background-size:cover; background-position:center center; background-image:url('+useURL+'); width:'+thumb.width+'px; height:'+thumb.height+'px;display:inline-block;vertical-align:bottom"></div></div>';
		html += '<div class="video-content-description">';	
		html += '<div class="video-content-title">'+data.title+'</div>';
		if(typeof data.desc_small != "undefined") html += data.desc_small;
		html += '</div>';
		html += '</div>';
		
		jQuery("#video_content").html(html);
	}
	
	
	/**
	 * set html to youtube dialog
	 * if empty data - clear the dialog
	 */
	var setAudioDialogHtml = function(data){
		
		jQuery('#button-audio-add').text(jQuery('#button-audio-add').data("textadd"));
		
		jQuery('#video_radio_audio').attr('checked', true);
		
		jQuery("#video_type_chooser").hide();
		jQuery("#video_block_youtube").hide();
		jQuery("#video_block_vimeo").hide();
		jQuery("#video_block_html5").hide();
		jQuery('#video_block_audio').show();
		
		jQuery('.rs-hide-on-audio').hide();
		jQuery('.rs-show-on-audio').show();
		
		
		
		//if empty data - clear the dialog
		if(!data){
			jQuery("#video_content").html("");
			return(false);
		}
		
		var thumb = data.thumb_medium;
		
		var useURL = (jQuery.trim(jQuery('#input_video_preview').val()) != '') ? jQuery('#input_video_preview').val() : thumb.url;
		
		var html = '<div class="video-thumbnail-all-wrapper">';
		html += '<div class="video-thumbnail-preview-wrapper"><div id="video-thumbnail-preview" style="background-size:cover; background-position:center center; background-image:url('+useURL+'); width:'+thumb.width+'px; height:'+thumb.height+'px;display:inline-block;vertical-align:bottom"></div></div>';
		html += '<div class="video-content-description">';	
		html += '<div class="video-content-title">'+data.title+'</div>';
		if(typeof data.desc_small != "undefined") html += data.desc_small;
		html += '</div>';
		html += '</div>';
		
		jQuery("#video_content").html(html);
	}
	
	
	/**
	 * pass youtube id or youtube url, and get the id
	 */
	var getYoutubeIDFromUrl = function(url){
		url = jQuery.trim(url);
		
		var video_id = url.split('v=')[1];
		
		if(video_id){
			var ampersandPosition = video_id.indexOf('&');
			if(ampersandPosition != -1) {
			  video_id = video_id.substring(0, ampersandPosition);
			}
		}else{
			//check if we are youtube.be
			var check = url.split('/')[3];
			if(check){
				video_id = check;
			}else{
				video_id = url;
			}
		}
		
		return(video_id);
	}

	
	/**
	 * get vimeo id from url
	 */
	var getVimeoIDFromUrl = function(url){
		url = jQuery.trim(url);
		
		var video_id = url.replace(/[^0-9]+/g, '');
		video_id = jQuery.trim(video_id);
		
		return(video_id);
	}
	
	
	
	/**
	 * youtube callback script, set and store youtube data, and add it to dialog
	 */
	t.onYoutubeCallback = function(obj){
		
		jQuery("#youtube_loader").hide();
		var desc_small_size = 200;
		
		//prepare data
		var data = {};
		data.id = jQuery("#youtube_id").val();
		data.id = jQuery.trim(data.id);
		data.video_type = "youtube";
		if(obj[0].width <= 170 || obj[0].height <= 140){
			data.title = 'YouTube: '+rev_lang.maybe_wrong_yt_id;
		}else{
			data.title = 'YouTube';
		}
		data.author = 'YouTube';
		data.link = '';
		data.description = '';
		data.desc_small = '';
		
		if(data.description.length > desc_small_size)
			data.desc_small = data.description.slice(0,desc_small_size)+"...";
		
		data.thumb_small = {url:obj[0].src,width:200,height:150};
		data.thumb_medium = {url:obj[0].src,width:320,height:240};
		data.thumb_big = {url:obj[0].src,width:obj[0].width,height:obj[0].height};
		data.thumb_very_big = {url:obj[0].src.replace('sddefault.jpg', 'maxresdefault.jpg'),width:obj[0].width,height:obj[0].height};
		
		data.video_width = obj[0].width;
		data.video_height = obj[0].height;
		
		//set html in dialog
		setYoutubeDialogHtml(data);
		
		//set the youtube arguments
		var objArguments = jQuery("#input_video_arguments");
		if(objArguments.val() == "")
			objArguments.val(objArguments.data("youtube"));
		
		//store last video data
		lastVideoData = data;
		
		jQuery('#video_dialog_tabs').removeClass('disabled');
		
		video_found = true;
		jQuery('#button-video-add').show();
	}
	
	t.initVideoDef = function(){
		jQuery('.button-image-select-video-default').click(function(){
			
			if(typeof(lastVideoData) == 'undefined') return false;
			
			switch(lastVideoData.video_type){
				case 'vimeo':
					jQuery("#input_video_preview").val(lastVideoData.thumb_medium.url);
					//update preview image:
					jQuery("#video-thumbnail-preview").css({backgroundImage:'url('+lastVideoData.thumb_medium.url+')'});
				break;
				case 'youtube':
					jQuery("#input_video_preview").val(lastVideoData.thumb_big.url);
					//update preview image:
					jQuery("#video-thumbnail-preview").css({backgroundImage:'url('+lastVideoData.thumb_big.url+')'});
				break;
			}
		});
		
		jQuery('.button-image-select-video-max').click(function(){
			
			if(typeof(lastVideoData) == 'undefined') return false;
			
			switch(lastVideoData.video_type){
				case 'vimeo':
					jQuery("#input_video_preview").val(lastVideoData.thumb_large.url);
					//update preview image:
					jQuery("#video-thumbnail-preview").css({backgroundImage:'url('+lastVideoData.thumb_large.url+')'});
				break;
				case 'youtube':
					jQuery("#input_video_preview").val(lastVideoData.thumb_very_big.url);
					//update preview image:
					jQuery("#video-thumbnail-preview").css({backgroundImage:'url('+lastVideoData.thumb_very_big.url+')'});
				break;
			}
		});
	}
	
	
	/**
	 * vimeo callback script, set and store vimeo data, and add it to dialog
	 */	
	t.onVimeoCallback = function(obj){
		jQuery("#vimeo_loader").hide();
		
		var desc_small_size = 200;
		obj = obj[0];
		
		var data = {};
		data.video_type = "vimeo";
		data.id = obj.id;
		data.id = jQuery.trim(data.id);
		data.title = obj.title;
		data.link = obj.url;
		data.author = obj.user_name;
		
		data.description = obj.description;
		if(data.description.length > desc_small_size)
			data.desc_small = data.description.slice(0,desc_small_size)+"...";
		
		data.thumb_large = {url:obj.thumbnail_large,width:640,height:360};
		data.thumb_medium = {url:obj.thumbnail_medium,width:200,height:150};
		data.thumb_small = {url:obj.thumbnail_small,width:100,height:75};
		
		data.video_with = 640;
		data.video_height = 360;
		
		//set html in dialog
		setYoutubeDialogHtml(data);
		
		//set the vimeo arguments
		var objArguments = jQuery("#input_video_arguments");
		if(objArguments.val() == "")
			objArguments.val(objArguments.data("vimeo"));
		
		//store last video data
		lastVideoData = data;
		
		jQuery('#video_dialog_tabs').removeClass('disabled');
		
		video_found = true;
		jQuery('#button-video-add').show();
	}

	
	/**
	 * show error message on the dialog
	 */
	t.videoDialogOnError = function(){
		
		//if ok, don't do nothing
		if(video_found == true){
			if(jQuery('#video_radio_audio').is(':checked')){
				jQuery('#button-audio-add').show();
			}else{
				jQuery('#button-video-add').show();
			}
			video_found = false;
			return(false);
		}
		
		//if error - show message
		jQuery('#button-video-add').hide();
		jQuery('#button-audio-add').hide();
		jQuery("#youtube_loader").hide();
		jQuery("#vimeo_loader").hide();
		var html = "<div class='video-content-error'>"+rev_lang.video_not_found+"</div>";
		jQuery("#video_content").html(html);
	}
	
	
	/**
	 * update video size enabled disabled according fullwidth properties
	 */
	var updateVideoSizeProps = function(){
		var isFullwidth = jQuery("#input_video_fullwidth").is(":checked");
		if(isFullwidth == true){	//disable
			jQuery('#video_full_screen_settings').show();
		}else{		//enable
			jQuery("#input_video_cover").prop("checked",false);
			jQuery('#video_full_screen_settings').hide();
		}
		
		var isCover = jQuery("#input_video_cover").is(":checked");
		if(isCover == true){	//disable
			jQuery("#input_video_ratio_lbl, #input_video_ratio, #input_video_dotted_overlay_lbl, #input_video_dotted_overlay").show();
		}else{		//enable
			jQuery("#input_video_ratio_lbl, #input_video_ratio, #input_video_dotted_overlay_lbl, #input_video_dotted_overlay").hide();
		}
		
		
		RevSliderSettings.onoffStatus(jQuery('#input_video_fullwidth'));
		RevSliderSettings.onoffStatus(jQuery('#input_video_cover'));
	}
	
	/**
	 * open dialog for youtube or vimeo import , add / update
	 */
	t.openVideoDialog = function(callback,objCurrentVideoData,gal_type){
		
		lastVideoCallback = callback;
		
		var dialogVideo = jQuery("#dialog_video");
		
		//set buttons:
		var buttons = {
			"Close":function(){
				dialogVideo.dialog("close");
			}
		};
		
		if(gal_type == 'audio'){
			setAudioDialogHtml(false);
		}else{
			//clear the dialog content
			setYoutubeDialogHtml(false);
			jQuery("#video_block_youtube").show();
			jQuery("#video_block_audio").hide();
			jQuery('#video_radio_youtube').attr('checked', true);
			jQuery('.rs-hide-on-audio').show();
			jQuery('.rs-show-on-audio').hide();
			jQuery("#video_type_chooser").show();
		}
		
		//enable fields:
		
		jQuery("#youtube_id,#vimeo_id").prop("disabled","").removeClass("input-disabled");
		
		//clear the fields
		jQuery('#html5_url_poster').val('');
		jQuery('#html5_url_mp4').val('');
		jQuery('#html5_url_webm').val('');
		jQuery('#html5_url_ogv').val('');
		jQuery('#html5_url_audio').val('');
		
		jQuery("#input_video_arguments").val("");
		jQuery("#select_video_autoplay option[value='false']").attr("selected",true);
		//jQuery("#input_video_autoplay").prop("checked","");
		//jQuery("#showautoplayfirsttime").hide();
		//jQuery("#input_video_autoplay_first_time").prop("checked","");
		jQuery("#input_video_nextslide").prop("checked","");
		jQuery("#input_video_force_rewind").prop("checked","");
		jQuery("#input_video_fullwidth").prop("checked","");
		jQuery("#input_video_control").prop("checked","");
		jQuery("#input_video_mute").prop("checked","");
		jQuery("#input_disable_on_mobile").prop("checked","");
		jQuery("#input_video_show_cover_pause").prop("checked","");
		jQuery("#input_video_large_controls").prop("checked",true);
		jQuery("#input_video_leave_fs_on_pause").prop("checked",true);
		jQuery("#input_video_cover").prop("checked","");
		jQuery("#input_video_stopallvideo").prop("checked","");
		jQuery("#input_video_allowfullscreen").prop("checked","");
		jQuery("#input_video_dotted_overlay option[value='none']").attr("selected",true);
		jQuery("#input_video_ratio option[value='16:9']").attr("selected",true);
		jQuery('#input_video_preload option[value="auto"]').attr("selected",true);
		jQuery('#input_video_preload_wait option[value="5"]').attr("selected",true);
		
		
		jQuery('#input_video_speed option[value="1"]').attr("selected",true);
		jQuery('#input_video_loop option[value="none"]').attr("selected",true);
		jQuery("#input_video_preview").val("");
		jQuery("#input_use_poster_on_mobile").prop("checked","");
		jQuery("#input_video_show_visibility").prop("checked","");
		jQuery("#input_video_play_inline").prop("checked","");
		
		jQuery("#input_video_start_at").val('');
		jQuery("#input_video_end_at").val('');
		
		jQuery("#input_video_volume").val('100');
		
		//RevSliderSettings.onoffStatus(jQuery("#input_video_autoplay"));
		//RevSliderSettings.onoffStatus(jQuery("#input_video_autoplay_first_time"));
		RevSliderSettings.onoffStatus(jQuery("#input_video_nextslide"));
		RevSliderSettings.onoffStatus(jQuery("#input_video_force_rewind"));
		RevSliderSettings.onoffStatus(jQuery("#input_video_fullwidth"));
		RevSliderSettings.onoffStatus(jQuery("#input_video_control"));
		RevSliderSettings.onoffStatus(jQuery("#input_video_mute"));
		RevSliderSettings.onoffStatus(jQuery("#input_disable_on_mobile"));
		RevSliderSettings.onoffStatus(jQuery("#input_video_cover"));
		RevSliderSettings.onoffStatus(jQuery("#input_video_stopallvideo"));
		RevSliderSettings.onoffStatus(jQuery("#input_video_allowfullscreen"));
		RevSliderSettings.onoffStatus(jQuery("#input_use_poster_on_mobile"));
		RevSliderSettings.onoffStatus(jQuery("#input_video_show_cover_pause"));
		RevSliderSettings.onoffStatus(jQuery("#input_video_large_controls"));
		RevSliderSettings.onoffStatus(jQuery("#input_video_leave_fs_on_pause"));
		RevSliderSettings.onoffStatus(jQuery("#input_video_show_visibility"));
		RevSliderSettings.onoffStatus(jQuery("#input_video_play_inline"));
		
		jQuery('#button-video-add').hide();
		jQuery('#button-audio-add').hide();
		if(!jQuery('#video_dialog_tabs').hasClass('disabled')) jQuery('#video_dialog_tabs').addClass('disabled');
		
		jQuery("#youtube_id").val("");
		jQuery("#vimeo_id").val("");
		
		jQuery("#fullscreenvideofun").hide();
		
		var buttonVideoAdd = jQuery("#button-video-add");
		buttonVideoAdd.text(buttonVideoAdd.data("textadd"));
		
		var buttonAudioAdd = jQuery("#button-audio-add");
		buttonAudioAdd.text(buttonAudioAdd.data("textadd"));
		
		//open the dialog
		dialogVideo.dialog({
			buttons:buttons,
			minWidth:830,
			minHeight:500,
			modal:true,
			dialogClass:"tpdialogs",
			create:function(ui) {				
				jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
			}
		});
		
		
		//if update dialog open:		
		if(objCurrentVideoData)
			setVideoDialogUpdateMode(objCurrentVideoData);
		
		updateVideoSizeProps();
	}
	
	
	/**
	 * prepare the dialog for video update
	 */
	var setVideoDialogUpdateMode = function(data){
		
		data.id = jQuery.trim(data.id);
		
		//disable fields:
		//jQuery("#youtube_id,#vimeo_id").prop("disabled","disabled").addClass("input-disabled");
		
		//set mode and video id
		switch(data.video_type){
			case "youtube":
				jQuery("#video-dialog-wrap").removeClass("html5select");
				jQuery("#video_radio_youtube").trigger("click");
				jQuery("#youtube_id").val(data.id);	
				jQuery("#fullscreenvideofun").hide();
			break;
			case "vimeo":
				jQuery("#video-dialog-wrap").removeClass("html5select");
				jQuery("#video_radio_vimeo").trigger("click");
				jQuery("#vimeo_id").val(data.id);
				jQuery("#fullscreenvideofun").hide();
			break;
			case "html5":
				jQuery("#video-dialog-wrap").addClass("html5select");
				jQuery("#html5_url_poster").val(data.urlPoster);
				jQuery("#html5_url_mp4").val(data.urlMp4);
				jQuery("#html5_url_webm").val(data.urlWebm);
				jQuery("#html5_url_ogv").val(data.urlOgv);
				jQuery("#video_radio_html5").trigger("click");
				jQuery("#fullscreenvideofun").show();
			break;
			case 'streamvimeo':
				jQuery("#video-dialog-wrap").removeClass("html5select");
				jQuery("#video_radio_streamvimeo").trigger("click");
			break;
			case 'streamyoutube':
				jQuery("#video-dialog-wrap").removeClass("html5select");
				jQuery("#video_radio_streamyoutube").trigger("click");
			break;
			case 'streaminstagram':
				jQuery("#video-dialog-wrap").removeClass("html5select");
				jQuery("#video_radio_streaminstagram").trigger("click");
			break;
			case 'audio':
				jQuery("#html5_url_audio").val(data.urlAudio);
				jQuery("#rev-html5-options").hide();
				
			break;
		}
		
		jQuery("#input_video_arguments").val(data.args);
		
		jQuery("#input_video_preview").val(data.previewimage);
		
		if(data.use_poster_on_mobile && data.use_poster_on_mobile == true){
			jQuery("#input_use_poster_on_mobile").prop("checked","checked");
		}else{
			jQuery("#input_use_poster_on_mobile").prop("checked","");
		}
		
		if(data.video_show_visibility && data.video_show_visibility == true){
			jQuery("#input_video_show_visibility").prop("checked","checked");
		}else{
			jQuery("#input_video_show_visibility").prop("checked","");
		}
		
		if(data.video_play_inline && data.video_play_inline == true){
			jQuery("#input_video_play_inline").prop("checked","checked");
		}else{
			jQuery("#input_video_play_inline").prop("checked","");
		}
		
		if(data.autoplayonlyfirsttime && data.autoplayonlyfirsttime == true)
			data.autoplay = '1sttime';
			
		if(data.autoplay){
			switch(data.autoplay){
				case 'true':
				case true:
					jQuery('#select_video_autoplay option[value="true"]').attr('selected', true);
				break;
				case false:
				case 'false':
					jQuery('#select_video_autoplay option[value="false"]').attr('selected', true);
				break;
				default:
					jQuery('#select_video_autoplay option[value="'+data.autoplay+'"]').attr('selected', true);
				break;
			}
		}
		
		if(data.nextslide && data.nextslide == true)
			jQuery("#input_video_nextslide").prop("checked","checked");
		else
			jQuery("#input_video_nextslide").prop("checked","");
	
		if(data.forcerewind && data.forcerewind == true)
			jQuery("#input_video_force_rewind").prop("checked","checked");
		else
			jQuery("#input_video_force_rewind").prop("checked","");

		if(data.fullwidth && data.fullwidth == true)
			jQuery("#input_video_fullwidth").prop("checked","checked");
		else
			jQuery("#input_video_fullwidth").prop("checked","");
		
		if(data.controls && data.controls == true)
			jQuery("#input_video_control").prop("checked","checked");
		else
			jQuery("#input_video_control").prop("checked","");
			
		if(data.mute && data.mute == true)
			jQuery("#input_video_mute").prop("checked","checked");
		else
			jQuery("#input_video_mute").prop("checked","");
		
		if(data.disable_on_mobile && data.disable_on_mobile == true)
			jQuery("#input_disable_on_mobile").prop("checked","checked");
		else
			jQuery("#input_disable_on_mobile").prop("checked","");
			
		if(data.cover && data.cover == true)
			jQuery("#input_video_cover").prop("checked","checked");
		else
			jQuery("#input_video_cover").prop("checked","");
		
		if(data.stopallvideo && data.stopallvideo == true)
			jQuery("#input_video_stopallvideo").prop("checked","checked");
		else
			jQuery("#input_video_stopallvideo").prop("checked","");

		if(data.allowfullscreen && data.allowfullscreen == true)
			jQuery("#input_video_allowfullscreen").prop("checked","checked");
		else
			jQuery("#input_video_allowfullscreen").prop("checked","");
		
		if(data.preload){
			jQuery("#input_video_preload option").each(function(){
				if(jQuery(this).val() == data.preload)
					jQuery(this).attr('selected', true);
			});
		}
		
		if(data.preload_audio){
			jQuery("#input_audio_preload option").each(function(){
				if(jQuery(this).val() == data.preload_audio)
					jQuery(this).attr('selected', true);
			});
		}
		
		if(data.preload_wait){
			jQuery("#input_video_preload_wait option").each(function(){
				if(jQuery(this).val() == data.preload_wait)
					jQuery(this).attr('selected', true);
			});
		}
		
		if(data.videospeed){
			jQuery("#input_video_speed option").each(function(){
				if(jQuery(this).val() == data.videospeed)
					jQuery(this).attr('selected', true);
			});
		}
		
		if(data.dotted){
			jQuery("#input_video_dotted_overlay option").each(function(){
				if(jQuery(this).val() == data.dotted)
					jQuery(this).attr('selected', true);
			});
		}
		if(data.ratio){
			jQuery("#input_video_ratio option").each(function(){
				if(jQuery(this).val() == data.ratio)
					jQuery(this).attr('selected', true);
			});
		}
		
		if(data.videoloop){
			if(data.videoloop == true){
				jQuery('#input_video_loop option[value="loop"]').attr("selected",true);
			}else{
				jQuery("#input_video_loop option").each(function(){
					if(jQuery(this).val() == data.videoloop)
						jQuery(this).attr('selected', true);
				});
			}
		}
		
		//change button text:
		var buttonVideoAdd = jQuery("#button-video-add");
		buttonVideoAdd.text(buttonVideoAdd.data("textupdate"));
		
		var buttonAudioAdd = jQuery("#button-audio-add");
		buttonAudioAdd.text(buttonAudioAdd.data("textupdate"));
		
		//search
		switch(data.video_type){
			case "youtube":
				jQuery("#button_youtube_search").trigger("click");
			break;
			case "vimeo":
				jQuery("#button_vimeo_search").trigger("click");
			break;
		}
		
		if(data.show_cover_pause && data.show_cover_pause == true)
			jQuery('#input_video_show_cover_pause').prop('checked', 'checked');
		else
			jQuery('#input_video_show_cover_pause').prop('checked', '');
		
		if(typeof(data.large_controls) !== 'undefined' && data.large_controls == false)
			jQuery('#input_video_large_controls').prop('checked', '');
		else
			jQuery('#input_video_large_controls').prop('checked', 'checked');
		
		if(typeof(data.leave_on_pause) !== 'undefined' && data.leave_on_pause == false)
			jQuery('#input_video_leave_fs_on_pause').prop('checked', '');
		else
			jQuery('#input_video_leave_fs_on_pause').prop('checked', 'checked');
		
		
		jQuery("#input_video_start_at").val(data.start_at);
		jQuery("#input_video_end_at").val(data.end_at);
		
		jQuery("#input_video_volume").val(data.volume);
		
		//RevSliderSettings.onoffStatus(jQuery('#input_video_autoplay'));
		//RevSliderSettings.onoffStatus(jQuery('#input_video_autoplay_first_time'));
		RevSliderSettings.onoffStatus(jQuery('#input_video_nextslide'));
		RevSliderSettings.onoffStatus(jQuery('#input_video_force_rewind'));
		RevSliderSettings.onoffStatus(jQuery('#input_video_fullwidth'));
		RevSliderSettings.onoffStatus(jQuery('#input_video_control'));
		RevSliderSettings.onoffStatus(jQuery('#input_video_mute'));
		RevSliderSettings.onoffStatus(jQuery('#input_disable_on_mobile'));
		RevSliderSettings.onoffStatus(jQuery('#input_video_cover'));
		RevSliderSettings.onoffStatus(jQuery('#input_video_stopallvideo'));
		RevSliderSettings.onoffStatus(jQuery('#input_video_allowfullscreen'));
		RevSliderSettings.onoffStatus(jQuery('#input_use_poster_on_mobile'));
		RevSliderSettings.onoffStatus(jQuery('#input_video_show_cover_pause'));
		RevSliderSettings.onoffStatus(jQuery('#input_video_large_controls'));
		RevSliderSettings.onoffStatus(jQuery('#input_video_leave_fs_on_pause'));
		RevSliderSettings.onoffStatus(jQuery('#input_video_show_visibility'));
		RevSliderSettings.onoffStatus(jQuery('#input_video_play_inline'));
		
		
		if(data.video_type == 'audio'){
			jQuery('#button-video-add').hide();
			jQuery('#button-audio-add').show();
		}else{
			jQuery('#button-video-add').show();
			jQuery('#button-audio-add').hide();
		}
		jQuery('#video_dialog_tabs').removeClass('disabled');
		
		jQuery('#reset_video_dialog_tab').click();
		
	}
	
	
	//add params from textboxes to object
	var addTextboxParamsToObj = function(obj){
		obj.args = jQuery("#input_video_arguments").val();
		obj.previewimage = jQuery("#input_video_preview").val();
		obj.autoplay = jQuery("#select_video_autoplay option:selected").val();
		//obj.autoplay = jQuery("#input_video_autoplay").is(":checked");
		obj.use_poster_on_mobile = jQuery("#input_use_poster_on_mobile").is(":checked");
		obj.video_show_visibility = jQuery("#input_video_show_visibility").is(":checked");
		obj.video_play_inline = jQuery("#input_video_play_inline").is(":checked");
		//obj.autoplayonlyfirsttime = jQuery("#input_video_autoplay_first_time").is(":checked");
		obj.nextslide = jQuery("#input_video_nextslide").is(":checked");
		obj.forcerewind = jQuery("#input_video_force_rewind").is(":checked");
		obj.fullwidth = jQuery("#input_video_fullwidth").is(":checked");
		obj.controls = jQuery("#input_video_control").is(":checked");
		obj.mute = jQuery("#input_video_mute").is(":checked");
		obj.disable_on_mobile = jQuery("#input_disable_on_mobile").is(":checked");
		obj.cover = jQuery("#input_video_cover").is(":checked");
		obj.stopallvideo = jQuery("#input_video_stopallvideo").is(":checked");
		obj.allowfullscreen = jQuery("#input_video_allowfullscreen").is(":checked");
		obj.dotted = jQuery("#input_video_dotted_overlay option:selected").val();
		obj.preload = jQuery("#input_video_preload option:selected").val();
		obj.preload_audio = jQuery("#input_audio_preload option:selected").val();
		obj.preload_wait = jQuery("#input_video_preload_wait option:selected").val();
		obj.videospeed = jQuery("#input_video_speed option:selected").val();
		obj.ratio = jQuery("#input_video_ratio option:selected").val();
		obj.videoloop = jQuery("#input_video_loop option:selected").val();
		obj.show_cover_pause = jQuery("#input_video_show_cover_pause").is(":checked");
		obj.start_at = jQuery("#input_video_start_at").val();
		obj.end_at = jQuery("#input_video_end_at").val();
		obj.volume = jQuery("#input_video_volume").val();
		obj.large_controls = jQuery('#input_video_large_controls').is(':checked');
		obj.leave_on_pause = jQuery('#input_video_leave_fs_on_pause').is(':checked');
		
		return(obj);
	}
	
	
	/**
	 * init video dialog buttons
	 */
	var initVideoDialog = function(){
		
		//set youtube radio checked:
		jQuery("#video_radio_youtube").prop("checked",true);
		
		//set radio boxes:
		jQuery("#video_radio_vimeo").click(function(){
			jQuery("#video_block_youtube").hide();
			jQuery("#video_block_html5").hide();
			jQuery("#rev-html5-options").hide();
			jQuery("#rev-youtube-options").hide();
			//jQuery("#video_content").show();
			jQuery("#video_block_vimeo").show();
			jQuery("#preview-image-video-wrap").show();
			jQuery("#video-dialog-wrap").removeClass("html5select");
			jQuery("#fullscreenvideofun").hide();
			jQuery(".video-volume").show();
			jQuery('.hide-for-vimeo').hide();
		});
		
		jQuery("#video_radio_youtube").click(function(){
			jQuery("#video_block_vimeo").hide();
			jQuery("#video_block_html5").hide();			
			jQuery("#rev-html5-options").hide();			
			jQuery("#rev-youtube-options").show();			
			//jQuery("#video_content").show();
			jQuery("#video_block_youtube").show();
			jQuery("#preview-image-video-wrap").show();
			jQuery("#video-dialog-wrap").removeClass("html5select");
			jQuery("#fullscreenvideofun").hide();
			jQuery(".video-volume").show();
			jQuery('.hide-for-vimeo').show();
		});
		
		jQuery("#video_radio_html5").click(function(){
			jQuery("#video_block_vimeo").hide();
			jQuery("#video_block_youtube").hide();
			jQuery("#video_block_html5").show();
			jQuery("#rev-youtube-options").hide();
			jQuery("#rev-html5-options").show();
			jQuery("#video_content").hide();
			jQuery("#preview-image-video-wrap").hide();
			jQuery("#video-dialog-wrap").addClass("html5select");
			jQuery("#fullscreenvideofun").show();
			jQuery(".video-volume").show();
			jQuery('.hide-for-vimeo').show();
		});
		
		
		jQuery("#video_radio_streamyoutube").click(function(){
			jQuery("#video_block_youtube").hide();
			jQuery("#video_block_vimeo").hide();
			jQuery("#video_block_html5").hide();
			jQuery("#rev-html5-options").hide();
			jQuery("#rev-youtube-options").hide();
			//jQuery("#video_content").show();
			jQuery("#preview-image-video-wrap").show();
			jQuery("#video-dialog-wrap").removeClass("html5select");
			jQuery("#fullscreenvideofun").hide();
			jQuery('#video_dialog_tabs').removeClass('disabled');
			jQuery('#button-video-add').show();
			jQuery(".video-volume").show();
			jQuery('.hide-for-vimeo').show();
		});
		
		
		jQuery("#video_radio_streamvimeo").click(function(){
			jQuery("#video_block_youtube").hide();
			jQuery("#video_block_vimeo").hide();
			jQuery("#video_block_html5").hide();			
			jQuery("#rev-html5-options").hide();			
			jQuery("#rev-youtube-options").show();			
			//jQuery("#video_content").show();
			jQuery("#preview-image-video-wrap").show();
			jQuery("#video-dialog-wrap").removeClass("html5select");
			jQuery("#fullscreenvideofun").hide();
			jQuery('#video_dialog_tabs').removeClass('disabled');
			jQuery('#button-video-add').show();
			jQuery(".video-volume").show();
			jQuery('.hide-for-vimeo').hide();
		});
		
		
		jQuery("#video_radio_streaminstagram").click(function(){
			jQuery("#video_block_youtube").hide();
			jQuery("#video_block_vimeo").hide();
			jQuery("#video_block_html5").hide();
			jQuery("#rev-html5-options").hide();
			jQuery("#rev-youtube-options").hide();
			//jQuery("#video_content").show();
			jQuery("#preview-image-video-wrap").show();
			jQuery("#video-dialog-wrap").removeClass("html5select");
			jQuery("#fullscreenvideofun").hide();
			jQuery('#video_dialog_tabs').removeClass('disabled');
			jQuery('#button-video-add').show();
			jQuery(".video-volume").hide();
			jQuery('.hide-for-vimeo').show();
		});
		
		
		/*jQuery("#input_video_autoplay").change(function(){
			if(jQuery(this).is(":checked")){
				jQuery("#showautoplayfirsttime").show();
			}else{
				jQuery("#showautoplayfirsttime").hide();
			}
		});*/
		
		jQuery("#input_video_cover").change(function(){
			if(jQuery(this).is(":checked")){
				if(!jQuery('#input_video_fullwidth').is(":checked")) jQuery('#input_video_fullwidth').prop("checked",true);
				RevSliderSettings.onoffStatus(jQuery('#input_video_fullwidth'));
			}
			updateVideoSizeProps();
		});
		
		
		jQuery("#input_video_fullwidth").change(function(){
			if(jQuery(this).is(':checked')){
				jQuery('#video_full_screen_settings').show();
			}else{
				jQuery('#video_full_screen_settings').hide();
			}
		});
		
		
		//set youtube search action
		jQuery("#button_youtube_search").click(function(){
			
			//init data
			setYoutubeDialogHtml(false);
			
			jQuery("#youtube_loader").show();
			var youtubeID = jQuery("#youtube_id").val();
			youtubeID = jQuery.trim(youtubeID);
			
			youtubeID = getYoutubeIDFromUrl(youtubeID);
			jQuery("#youtube_id").val(youtubeID);
			
			var img = new Image();
			img.onload = function() {
				var img = jQuery(this);
				UniteAdminRev.onYoutubeCallback(img);
			}
			img.src = "https://img.youtube.com/vi/"+youtubeID+"/sddefault.jpg";
			
			jQuery("#video_content").show();
			
			//handle not found:
			setTimeout("UniteAdminRev.videoDialogOnError()",2000);
		});
		
		
		//add the selected video to the callback function
		jQuery("#button-video-add, #button-audio-add").click(function(){

			var html5Checked = jQuery("#video_radio_html5").prop("checked");
			var audioChecked = jQuery("#video_radio_audio").prop("checked");
			var ytstreamChecked = jQuery("#video_radio_streamyoutube").prop("checked");
			var vmstreamChecked = jQuery("#video_radio_streamvimeo").prop("checked");
			var igstreamChecked = jQuery("#video_radio_streaminstagram").prop("checked");
			
			jQuery("#video_content").hide();
			
			if(html5Checked){	//in case of html5
				var obj = {};
				obj.video_type = "html5";
				obj.urlPoster = jQuery("#html5_url_poster").val();
				obj.urlMp4 = jQuery("#html5_url_mp4").val();
				obj.urlWebm = jQuery("#html5_url_webm").val();
				obj.urlOgv = jQuery("#html5_url_ogv").val();
				
				obj.video_width = 480;
				obj.video_height = 360;
				
				obj = addTextboxParamsToObj(obj);
				
				if(typeof lastVideoCallback == "function")
					lastVideoCallback(obj);
				
				jQuery("#dialog_video").dialog("close");
				
			}else if(ytstreamChecked){
				var obj = {};
				obj.video_type = "streamyoutube";
				
				obj.video_width = 480;
				obj.video_height = 360;
				
				obj = addTextboxParamsToObj(obj);
				
				if(typeof lastVideoCallback == "function")
					lastVideoCallback(obj);
				
				jQuery("#dialog_video").dialog("close");
			}else if(vmstreamChecked){
				var obj = {};
				obj.video_type = "streamvimeo";
				
				obj.video_width = 480;
				obj.video_height = 360;
				
				obj = addTextboxParamsToObj(obj);
				
				if(typeof lastVideoCallback == "function")
					lastVideoCallback(obj);
				
				jQuery("#dialog_video").dialog("close");
			}else if(igstreamChecked){
				var obj = {};
				obj.video_type = "streaminstagram";
				
				obj.video_width = 480;
				obj.video_height = 360;
				
				obj = addTextboxParamsToObj(obj);
				
				if(typeof lastVideoCallback == "function")
					lastVideoCallback(obj);
				
				jQuery("#dialog_video").dialog("close");
			}else if(audioChecked){
				var obj = {};
				obj.video_type = 'audio';
				obj.urlAudio = jQuery("#html5_url_audio").val();
				
				obj.video_width = 200;
				obj.video_height = 34;
				
				//maybe 30x30
				
				obj = addTextboxParamsToObj(obj);
				
				if(typeof lastVideoCallback == "function")
					lastVideoCallback(obj);
				
				jQuery("#dialog_video").dialog("close");
			}else{ //in case of vimeo and youtube 
				if(!lastVideoData)
					return(false);
				
				lastVideoData = addTextboxParamsToObj(lastVideoData);
				
				if(typeof lastVideoCallback == "function")
					lastVideoCallback(lastVideoData);
				
				jQuery("#dialog_video").dialog("close");
			}
			try {
				UniteLayersRev.setLayerSelected(selectedLayerSerial,true);
			} catch(e) {
				
			}
			
			
		});
		
		jQuery('#html5_url_audio, #html5_url_ogv, #html5_url_webm, #html5_url_mp4').on("change",function() {
			jQuery('#video_dialog_tabs').removeClass('disabled');
			
			if(jQuery(this).attr('id') == 'html5_url_audio'){
				jQuery('#button-video-add').hide();
				jQuery('#button-audio-add').show();
			}else{
				jQuery('#button-video-add').show();
				jQuery('#button-audio-add').hide();
			}
		});
		
		//set vimeo search
		jQuery("#button_vimeo_search").click(function(){
			//init data
			setYoutubeDialogHtml(false);
			
			jQuery("#vimeo_loader").show();
			
			jQuery("#video_content").show();
			
			var vimeoID = jQuery("#vimeo_id").val();
			vimeoID = jQuery.trim(vimeoID);
			vimeoID = getVimeoIDFromUrl(vimeoID);
			
			var urlAPI = '//www.vimeo.com/api/v2/video/' + vimeoID + '.json?callback=UniteAdminRev.onVimeoCallback'; 
			jQuery.getScript(urlAPI);
			
			//handle not found:
			setTimeout("UniteAdminRev.videoDialogOnError()",2000);
		});
		
		
		jQuery("#input_video_fullwidth").change(updateVideoSizeProps);
		
	}//end initVideoDialog
	
	
	/**
	 * init general settings dialog
	 */
	var initGeneralSettings = function(){
		
		//button general settings - open dialog
		jQuery("#button_general_settings").click(function(){
			
			jQuery("#loader_general_settings").hide();
			
			jQuery("#dialog_general_settings").dialog({
				minWidth:800,
				minHeight:500,
				modal:true,
				dialogClass:"tpdialogs",
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				}
			});
			
		});
		
		//button save general settings
		jQuery("#button_save_general_settings").click(function(){
			var data = RevSliderSettings.getSettingsObject("form_general_settings");
			jQuery("#loader_general_settings").show();
			UniteAdminRev.ajaxRequest("update_general_settings",data,function(response){
				jQuery("#loader_general_settings").hide();
				jQuery("#dialog_general_settings").dialog("close");
			});
		});
		
		//button trigger table creation process
		jQuery("#trigger_database_creation").click(function(){
			jQuery("#dialog_general_settings").dialog("close");
			
			UniteAdminRev.ajaxRequest("fix_database_issues",{},function(response){
			});
		});
		
		
	}
	
	
	//adds the update/deactivate option
	var initUpdateRoutine = function(){
		
		jQuery('#rs-validation-activate').click(function(){
			
			//UniteAdminRev.setAjaxLoaderID("rs_purchase_validation");
			//UniteAdminRev.setAjaxHideButtonID("rs-validation-activate");
			
			var data = {
				code: jQuery('input[name="rs-validation-token"]').val()/*,
				email: jQuery('input[name="rs-validation-email"]').val()*/
			}
			
			UniteAdminRev.ajaxRequest("activate_purchase_code",data,function(response){
				if(response.success == false){
					jQuery('#register-wrong-purchase-code').click();
				}else{
					if(response.error !== undefined){
						if(response.error == 'exist'){
							t.showErrorMessage(response.msg);
						}
					}
				}
			},undefined,true);
		});
		
		jQuery('#rs-validation-deactivate').click(function(){
			
			//UniteAdminRev.setAjaxLoaderID("rs_purchase_validation");
			//UniteAdminRev.setAjaxHideButtonID("rs-validation-deactivate");
			
			UniteAdminRev.ajaxRequest("deactivate_purchase_code",'');
			
		});
		
	}
	
	
	//run the init function
	jQuery(document).ready(function(){
		initVideoDialog();
		initGeneralSettings();
		initSliderMultipleText();
		initUpdateRoutine();
		
	});
	
	/**
	 * set multiple key values
	 */
	t.setMultipleTextKey = function(name, key){
		g_multiple_text_key[name] = key;
	}
	
	/**
	 * set multiple key values
	 */
	t.getMultipleTextKey = function(name){
		return g_multiple_text_key[name];
	}
	
	var initSliderMultipleText = function(){
	
		jQuery("body").on("click",".remove_multiple_text",function(){ //remove element
			jQuery("#"+jQuery(this).data('remove')).remove();
			jQuery(this).parent().remove();
		});
		
		jQuery(".multiple_text_add").click(function(){ //add element
			
			var handle = jQuery(this).data('name');
			var key = t.getMultipleTextKey(handle) + 1;
			var template = jQuery('.'+handle+'_TEMPLATE').html();
			
			template = template.replace(/##ID##/ig, handle+'_'+key).replace(/##NAME##/ig, handle);
			jQuery('#'+handle+'_row .setting_input').append(template);
			
			t.setMultipleTextKey(handle, key);
		});
		
	}
	
	/**
	 * set multiple key values
	 */
	t.parseCssMultiAttribute = function(value){
		if(value == '') return false;
		var raw = value.split(' ');
		var retObj = [];
		
		switch(raw.length){
			case 1:
				retObj[0] = raw[0];
				retObj[1] = raw[0];
				retObj[2] = raw[0];
				retObj[3] = raw[0];
			break;
			case 2:
				retObj[0] = raw[0];
				retObj[1] = raw[1];
				retObj[2] = raw[0];
				retObj[3] = raw[1];
			break;
			case 3:
				retObj[0] = raw[0];
				retObj[1] = raw[1];
				retObj[2] = raw[2];
				retObj[3] = raw[1];
			break;
			case 4:
				retObj[0] = raw[0];
				retObj[1] = raw[1];
				retObj[2] = raw[2];
				retObj[3] = raw[3];
			break;
			case 0:
			default:
			return false;
			break;
		}
		
		return retObj;
	}
	
	/**
	 * get rgb from hex values
	 */
	t.convertHexToRGB = function(hex) {
		var hex = parseInt(((hex.indexOf('#') > -1) ? hex.substring(1) : hex), 16);
		return [hex >> 16,(hex & 0x00FF00) >> 8,(hex & 0x0000FF)];
	}
	
	
	t.initGoogleFonts = function(){
		jQuery('#eg-font-setting-change').click(function(){
			UniteAdminRev.ajaxRequest("change_google_fonts_settings", {'setting': jQuery('input[name="load_fonts_place"]:checked').val()}, function(response){});
		});
		
		jQuery('#eg-font-add').click(function(){
			jQuery('#font-dialog-wrap').dialog({
				modal:true,
				draggable:false,
				resizable:false,
				width:470,
				height:320,
				closeOnEscape:true,
				dialogClass:'wp-dialog',
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
				buttons: [ { text: 'Add Font', click: function() {
					var data = {};
					
					data.handle = t.sanitize_input(jQuery('input[name="eg-font-handle"]').val());
					data['url'] = jQuery('input[name="eg-font-url"]').val();
					
					if(data.handle.length < 3 || data.url.length < 3){
						alert(rev_lang.handle_at_least_three_chars);
						return false;
					}
					
					UniteAdminRev.ajaxRequest("add_google_fonts", data, function(response){}); //'#eg-font-add',
					
				} } ],
			});
		});
		
		
		jQuery('body').on('click', '.eg-font-edit', function(){
			if(confirm(rev_lang.really_change_font_sett)){
				var data = {};
				var el = jQuery(this);
				data.handle = el.closest('.inside').find('input[name="esg-font-handle[]"]').val();
				data['url'] = el.closest('.inside').find('input[name="esg-font-url[]"]').val();
				
				UniteAdminRev.ajaxRequest("edit_google_fonts", data, function(response){}); //'#eg-font-add, .eg-font-edit, .eg-font-delete',
			}
			
		});
		
		
		jQuery('body').on('click', '.eg-font-delete', function(){
			if(confirm(rev_lang.really_delete_font)){
				var data = {};
				var el = jQuery(this);
				
				data.handle = el.closest('.inside').find('input[name="esg-font-handle[]"]').val();
				
				UniteAdminRev.ajaxRequest("remove_google_fonts", data, function(response){ //'#eg-font-add, .eg-font-edit, .eg-font-delete',
					if(response.success == true){
						el.closest('.postbox.eg-postbox').remove();
					}
				});
			}
		});
		
	}
	
	t.sanitize_input = function(raw){
		return raw.replace(/ /g, '-').replace(/[^-0-9a-zA-Z_-]/g,'');
	}
	
	t.sanitize_input_lc = function(raw){
		return raw.replace(/ /g, '-').replace(/[^-0-9a-z_-]/g,'');
	}
	
	t.initAccordion = function(){
		jQuery(".postbox-arrow").each(function(i) {

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
	
	t.return_ajaxurl_param = function(){
		return (ajaxurl.indexOf('?') === -1) ? '?' : '&';
	}

}



//user functions:

function trace(data,clear){
	UniteAdminRev.trace(data,clear);
}

function debug(data){
	UniteAdminRev.debug(data);
}

