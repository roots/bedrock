var tpLayerContextMenu = new function() {
  
	/** CONTEXT MENU VARIABLES**/
	var	t = this,
		u = new Object(),
		tl = new Object(),

		contextMenuClassName = "context-menu",
		contextMenuItemClassName = "context-menu__item",
		contextMenuLinkClassName = "context-menu__link",
		contextMenuActive = "context-menu--active",
		taskItemInContext,

		clickCoords,
		clickCoordsX,
		clickCoordsY,

		_ctxmenu,
		_ctxmenuItems,
		_ctxmenuState = 0,
		_ctxmenuWidth,
		_ctxmenuHeight,
		_ctxmenuPosition,
		_ctxmenuPositionX,
		_ctxmenuPositionY,

		_ctxwindowWidth,
		_ctxwindowHeight;
	t.stylecache = {};

	t.init = function() {		
		//return false;
		u = UniteLayersRev;
		tl = tpLayerTimelinesRev;
		_ctxmenu = document.querySelector("#context-menu");
	  	_ctxmenuItems = _ctxmenu.querySelectorAll(".context-menu__item");
	  	_contextMenuinit();

	  	// PERFECT SCROLLBARS IN SUBMENUS
	  	jQuery('.context-submenu').perfectScrollbar({wheelPropagation:false, suppressScrollX:true});
	  	jQuery('.context-submenu').each(function() {
	  		jQuery(this).on('mouseenter',function() {
	  			jQuery(this).perfectScrollbar("update");
	  		});
	  	});

	  	//LAYER BORDER SHOW ON HOVER
	  	jQuery('body').on('mouseenter','.ctx-dyn-avl-list-item',function() {
	  		jQuery('.layer_due_list_element_selected').removeClass('layer_due_list_element_selected');
			jQuery('#slide_layer_'+jQuery(this).data('serial')).addClass("layer_due_list_element_selected");
	  	});
	  	jQuery('body').on('mouseleave','.ctx-dyn-avl-list-item',function() {
	  		jQuery('.layer_due_list_element_selected').removeClass('layer_due_list_element_selected');
	  	});

	  	//SWITCHER CLICK
	  	jQuery('body').on('click','.ctx-td-switcher',function() {
	  		var sw = jQuery(this);
	  		sw.toggleClass("ctx-td-s-off");
	  	});

	  	jQuery('body').on('click','.ctx-td-option-selector', function() {
	  		var btn = jQuery(this);
	  		btn.parent().find('.selected').removeClass("selected");
	  		btn.addClass("selected");
	  	});
	}

	/****************************************
		-	CONTEXT MENU EXTENSION    -
	*****************************************/

	

	/**
	* Get's exact position of event.
	* 
	* @param {Object} e The event passed in
	* @return {Object} Returns the x and y position
	*/
	function getPosition(e) {
		var posx = 0;
		var posy = 0;

		if (!e) var e = window.event;

		if (e.pageX || e.pageY) {
		  posx = e.pageX;
		  posy = e.pageY;
		} else if (e.clientX || e.clientY) {
		  posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
		  posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
		}

		return {
		  x: posx,
		  y: posy
		}
	}


	/**
	* Initialise our application's code.
	*/
	function _contextMenuinit() {
		
		contextListener();
		clickListener();
		keyupListener();
		resizeListener();
	}

	/**
	* Listens for contextmenu events.
	*/
	function contextListener() {
		document.addEventListener( "contextmenu", function(e) {			
		  taskItemInContext = u.clickInsideElement( e, 'slide_layer');

		  if (jQuery(taskItemInContext).hasClass("demo_layer")) return;

		  // CHECK FOR LAYER CONTEXT
		  if ( taskItemInContext ) {
		  	u.setLayerSelected(jQuery(taskItemInContext).data('serial'));
		    e.preventDefault();
		    t.toggleMenuOn("layer");
		    positionMenu(e);
		  } else {
		  	// CHECK FOR BG CONTEXT
		  	taskItemInContext = u.clickInsideElement( e, 'bg_context_listener');
		  	if (taskItemInContext) {
		  		e.preventDefault();
			    t.toggleMenuOn("background");
			    positionMenu(e);
		  	} else {
		  		// CHECK FOR 
			  	taskItemInContext = u.clickInsideElement( e, 'ignorecontextmenu');
			  	if (taskItemInContext) {
			  		e.preventDefault();
			    	t.toggleMenuOn();
			    	positionMenu(e);
			  	} else {
			    	taskItemInContext = null;
			    	t.toggleMenuOff();
			  	}
			 }
		  }
		});
	}

	/**
	* Listens for click events.
	*/
	function clickListener() {
		jQuery('body').on('click',function(e) {			
		  var clickeElIsLink = u.clickInsideElement( e, contextMenuLinkClassName );	

		  if ( clickeElIsLink ) {
		    e.preventDefault();
		    menuItemListener( clickeElIsLink );		    
		  } else {
		    var button = e.which || e.button;

		    if ( button === 1 ) {		    
		      t.toggleMenuOff();
		    }
		  }
		});
	}

	/**
	* Listens for keyup events.
	*/
	function keyupListener() {
		window.onkeyup = function(e) {
		  if ( e.keyCode === 27 ) {
		    t.toggleMenuOff();
		  }
		}
	}

	/**
	* Window resize event listener
	*/
	function resizeListener() {
		window.onresize = function(e) {
		  t.toggleMenuOff();
		};
	}

	function getLayerIcon(type) {
		var c="rs-icon-layerimage_n";
		switch (type) {
			case "image":
				c='rs-icon-layerimage_n';
			break;
			case "text":
				c='rs-icon-layerfont_n';
			break;
			case "button":
				c='rs-icon-layerbutton_n';
			break;
			case "audio":
				c='rs-icon-layeraudio_n';
			break;
			case "video":
				c='rs-icon-layervideo_n';
			break;
			case "svg":
				c='rs-icon-layersvg_n';
			break;
			case "row":
				c='rs-icon-layergroup_n';
			break;
			case "column":
				c='rs-icon-layercolumn_n';
			break;
			case "group":
				c='rs-icon-layergroup_n';
			break;
		}
		return c;
	}

	function setCTXOnOff(v,cont) {
		if (v)
			jQuery(cont).removeClass("ctx-td-s-off")
		else
			jQuery(cont).addClass("ctx-td-s-off");
	}

	function showContextMebuForBackground() {
		jQuery('.not_in_ctx_bg').hide();
		jQuery('.not_in_ctx_layer').show();
		// CREATE LIST OF LAYERS AND UNVISIBLE LAYERS
		var avl = jQuery('#ctx_list_of_layers');
		avl.html("");	
		for (i in u.arrLayers) {
			var layer = u.arrLayers[i],
				licon = getLayerIcon(layer.type);			
			
			avl.append('<li class="ctx-dyn-avl-list-item context-menu__item" data-serial="'+layer.serial+'"><div class="ctx_item_inner"><div class="context-menu__link" data-serial="'+layer.serial+'" data-action="selectonelayer"><i class="'+licon+'"></i><span class="cx-layer-name">'+layer.alias+'</span></div></div></li>');
		}		

	}

	function showContextMenuForSelectedLayer() {
		var objLayer = u.getLayer(u.selectedLayerSerial),
			layer = objLayer.references.htmlLayer;

		jQuery('.not_in_ctx_bg').show();
		jQuery('.not_in_ctx_layer').hide();

		// PREPARE MENU, ICON, ALIAS		
		jQuery('#cx-selected-layer-name').html(objLayer.alias);
		var slic = jQuery('#cx-selected-layer-icon');
		slic.attr('class',getLayerIcon(objLayer.type));

		// PREPARE CONTEXT MENU VISIBILITY AND LOCK ICONS / TEXTS
		var eye = jQuery('#cx-selected-layer-visible'),
			lock = jQuery('#cx-selected-layer-locked');
		if(tl.isLayerVisible(layer)) {
			eye.find('i').attr('class','eg-icon-eye-off')
			eye.find('.cx-layer-name').html("Hide Layer");
		}
		else {
			eye.find('i').attr('class','eg-icon-eye')
			eye.find('.cx-layer-name').html("Show Layer");
		}

		if(!tl.isLayerLocked(layer)) {
			 lock.find('i').attr('class','eg-icon-lock');
			 lock.find('.cx-layer-name').html("Lock Layer");
		}
		else {
			lock.find('i').attr('class','eg-icon-lock-open')
			lock.find('.cx-layer-name').html("Unlock Layer");
		}

		// PREPARE CONTECT MENU UNVISIBLE ELEMENT LISTS
		var inv = jQuery('#ctx_list_of_invisibles'),
			avl = jQuery('#ctx_list_of_layers'),
			first_invisible = true;
				
		inv.find('.ctx-dyn-inv-list-item').remove();
		avl.html("");
		
		// CREATE LIST OF LAYERS AND UNVISIBLE LAYERS
		for (i in u.arrLayers) {
			var layer = u.arrLayers[i],
				licon = getLayerIcon(layer.type),
				htmll = layer.references!==undefined && layer.references.htmlLayer!==undefined ? layer.references.htmlLayer : undefined;							
		
			if (htmll!==undefined && htmll.hasClass("currently_not_visible")) {
				var clas_ext = first_invisible ? "ctx-m-top-divider" : "";
				first_invisible = false;
				inv.append('<li class="ctx-dyn-inv-list-item '+clas_ext+' context-menu__item"><div class="ctx_item_inner"><div class="context-menu__link" data-serial="'+layer.serial+'" data-action="showonelayer"><i class="eg-icon-eye"></i><span class="cx-layer-name">'+layer.alias+'</span></div></div></li>')			
			}			
			avl.append('<li class="ctx-dyn-avl-list-item context-menu__item" data-serial="'+layer.serial+'"><div class="ctx_item_inner"><div class="context-menu__link" data-serial="'+layer.serial+'" data-action="selectonelayer"><i class="'+licon+'"></i><span class="cx-layer-name">'+layer.alias+'</span></div></div></li>');
		}		
		
		// SET RESPONSIVNESS SETTINGS
		if (objLayer.basealign==="grid") {
			jQuery('#ctx_gridbased').addClass("selected");
			jQuery('#ctx_slidebased').removeClass("selected");
		} else {
			jQuery('#ctx_gridbased').removeClass("selected");
			jQuery('#ctx_slidebased').addClass("selected");
		}

		setCTXOnOff(objLayer['resize-full'],'#ctx_autoresponsive');
		setCTXOnOff(objLayer.resizeme,'#ctx_childrenresponsive');
		setCTXOnOff(objLayer.responsive_offset,'#ctx_responsiveoffset');

		
		// SET VISIBILTY ON/OFF 
		setCTXOnOff(objLayer['visible-desktop'],'#ctx_showhideondesktop');
		setCTXOnOff(objLayer['visible-notebook'],'#ctx_showhideonnotebook');
		setCTXOnOff(objLayer['visible-tablet'],'#ctx_showhideontablet');
		setCTXOnOff(objLayer['visible-mobile'],'#ctx_showhideonmobile');


		// SET STYLE SETTINGS
		setCTXOnOff(objLayer.autolinebreak,'#ctx_linebreak');
		setCTXOnOff(objLayer.scaleProportional,'#ctx_keepaspect');
		
		if (objLayer.displaymode || objLayer.display==="block") {
			jQuery('#ctx_displayblock').addClass("selected");
			jQuery('#ctx_displayinline').removeClass("selected");
		} else {
			jQuery('#ctx_displayblock').removeClass("selected");
			jQuery('#ctx_displayinline').addClass("selected");
		}		

		// SET LAYER LINK GROUP
		jQuery('#ctx-list-of-layer-links').data('uniqueid',objLayer.unique_id);
		var groupLink = objLayer.groupLink !==undefined ? objLayer.groupLink : 0,
			_csl = jQuery('#ctx-layer-link-type-element-cs');
		for (var i=0;i<6;i++) {			
			_csl.removeClass('ctx-layer-link-type-'+i);
		}
		_csl.addClass('ctx-layer-link-type-'+groupLink);		

		// SAVE THE CURRENT LAYER IN SOME DATA CONTAINER
		jQuery(_ctxmenu).data('current_layer',htmll);


		// SET ELEMENTS VISIBLE / HIDDEN BASED ON LAYER TYPE AND MAIN CLASS
		var incolumn = u.getObjLayerType(objLayer.p_uid)==="column";
		_ctxmenu.className="context-menu layer_type_"+objLayer.type+" in_column_"+incolumn;

		// HIDE INHERIT FROM DEVICE SIZES WHICH ARE NOT AVAILABLE
		jQuery('#ctx-inheritdesktop').show();
		jQuery('#ctx-inheritnotebook').show();
		jQuery('#ctx-inherittablet').show();
		jQuery('#ctx-inheritmobile').show();		
		switch (u.getLayout()) {
			case "desktop":
				jQuery('#ctx-inheritdesktop').hide();				
			break;
			case "notebook":
				jQuery('#ctx-inheritnotebook').hide();
			break;
			case "tablet":
				jQuery('#ctx-inherittablet').hide();
			break;
			case "mobile":
				jQuery('#ctx-inheritmobile').hide();
			break;
		}		
	}

	function showContextMenuWithoutSelectedLayer() {

	}

	/**
	* Turns the custom context menu on.
	*/
	t.toggleMenuOn = function(type) {
		
		punchgs.TweenLite.fromTo(_ctxmenu,0.2,{x:10,autoAlpha:0},{x:0,autoAlpha:1,display:"block",ease:punchgs.Power2.easeInOut,delay:0.2});
		//punchgs.TweenLite.to(jQuery('#context_menu_underlay'),0.2,{autoAlpha:1,delay:0.2});
		if ( _ctxmenuState !== 1 ) {
		  _ctxmenuState = 1;
		}
		
		if (type==="layer") {			
			// LAYER SELECTED OR NOT ? 
			if (u.selectedLayerSerial!=-1) 
			  	showContextMenuForSelectedLayer();
			  else
			  	showContextMenuWithoutSelectedLayer();			  		
		} else 
		if (type==="background") {			
			showContextMebuForBackground();
		}
		
			
	}

	/**
	* Turns the custom context menu off.
	*/
	t.toggleMenuOff = function() {
		if ( _ctxmenuState !== 0 ) {
		  _ctxmenuState = 0;
		  punchgs.TweenLite.to(_ctxmenu,0.2,{y:25,autoAlpha:0});
		//  punchgs.TweenLite.to(jQuery('#context_menu_underlay'),0.2,{autoAlpha:0});
		  
		}
	}

	/**
	* Positions the menu properly.
	* 
	* @param {Object} e The event
	*/
	function positionMenu(e) {
		clickCoords = getPosition(e);
		clickCoordsX = clickCoords.x;
		clickCoordsY = clickCoords.y;


		var of = jQuery('#viewWrapper').offset(),
			dof = jQuery('#divbgholder').offset(),
			so = jQuery(window).scrollTop();


		_ctxmenuWidth = _ctxmenu.offsetWidth + 4;
		_ctxmenuHeight = _ctxmenu.offsetHeight + 4;

		_ctxwindowWidth = window.innerWidth;
		_ctxwindowHeight = window.innerHeight;

		var cvt = so,
			cvb = so+_ctxwindowHeight;

		var newl = (15+clickCoordsX - of.left),
			newt = (clickCoordsY-(of.top+25));

		clickCoords.x = clickCoordsX -dof.left;
		clickCoords.y = clickCoordsY - dof.top;

		newl = newl+250>_ctxwindowWidth-of.left ? _ctxwindowWidth-(260+of.left) : newl;	
		newt = (newt+300+of.top)>cvb ? cvb - 300-of.top :  newt;

	
		_ctxmenu.style.left = newl+"px";
		_ctxmenu.style.top = newt+"px";

		
				
		if (newl>_ctxwindowWidth-(of.left+500))
			jQuery('#context-menu-first-ul').addClass("submenustoleft");
		else
			jQuery('#context-menu-first-ul').removeClass("submenustoleft");

		if (newt+300+of.top+200 > cvb)
			jQuery('#context-menu-first-ul').addClass("submenustobottom");
		else
			jQuery('#context-menu-first-ul').removeClass("submenustobottom");



	}

	function switchOnOff(link) {		
		if (jQuery(link).hasClass("ctx-td-s-off")) 
			return false;
		
		else 			
			return true;
		
	}

	/**
	* Dummy action function that logs an action when a menu item link is clicked
	* 
	* @param {HTMLElement} link The link that was clicked
	*/
	function menuItemListener( link ) {
		var hideAfterAction = true
			objUpdate = {},
			htmlLayer,
			updateLayerForm = false,
			rebuild = false;

		if (link.getAttribute("data-action")==="delegate") {
			jQuery(document.getElementById(link.getAttribute("data-delegate"))).click();
			return;
		}

		switch (link.getAttribute("data-action")) {
			case "delete":
				jQuery('#button_delete_layer').click();
			break;
			case "duplicate":
				jQuery('#button_duplicate_layer').click();
			break;
			case "showhide":
				jQuery('#layer-short-toolbar .quick-layer-view').click();
			break;
			case "lockunlock":
				jQuery('#layer-short-toolbar .quick-layer-lock').click();
			break;
			case "showalllayer":
				u.showAllLayers();
			break;
			case "showonlycurrent":			
				u.hideAllLayers(u.selectedLayerSerial);
			break;
			case "showonelayer":
				var obj = u.getLayer(jQuery(link).data('serial'));
				tl.showLayer(obj);
			break;
			case "selectonelayer":
				u.setLayerSelected(jQuery(link).data('serial'));
			break;
			case "autoresponsive":
				hideAfterAction = false;
				objUpdate['resize-full'] = switchOnOff(link);
				if (!objUpdate['resize-full']) {
					objUpdate.resizeme=false;
					jQuery('#ctx_childrenresponsive').addClass("ctx-td-s-off");
				}
				updateLayerForm = true;
			break;
			case "childrenresponsive":
				hideAfterAction = false;
				objUpdate.resizeme = switchOnOff(link);
				if (objUpdate.resizeme) {
					objUpdate['resize-full'] = true;
					jQuery('#ctx_autoresponsive').removeClass("ctx-td-s-off");
				}
				updateLayerForm = true;
			break;
			case "responsiveoffset":
				hideAfterAction = false;
				objUpdate.responsive_offset = switchOnOff(link);
				updateLayerForm = true;
			break;
			case "gridbased":
				hideAfterAction = false;
				
				objUpdate.basealign = "grid";		
				updateLayerForm = true;						
			break;
			case "slidebased":
				hideAfterAction = false;
				
				objUpdate.basealign = "slide";
				updateLayerForm = true;
			break;
			case "nothing":
				hideAfterAction = false;
			break;		

			case "linebreak":
				hideAfterAction = false;
				if (jQuery("#layer_auto_line_break")[0].checked)
					jQuery("#layer_auto_line_break")[0].checked = false;
				else
					jQuery("#layer_auto_line_break")[0].checked = true;
				u.clickOnAutoLineBreak();				
			break;	

			case "displayblock":
				hideAfterAction = false;				
				objUpdate.displaymode = true;
				objUpdate.display="block";
				updateLayerForm = true;	
				htmlLayer = jQuery(_ctxmenu).data('current_layer');	
				rebuild = true;						
			break;	

			case "displayinline":
				hideAfterAction = false;				
				objUpdate.displaymode = false;
				objUpdate.display="inline-block";
				updateLayerForm = true;			
				htmlLayer = jQuery(_ctxmenu).data('current_layer');	
				rebuild = true;				
			break;	

			case "advancedcss":
				jQuery('#advanced-css-layer').click();
			break;

			case "resetsize":
				jQuery('#reset-scale').click();
			break;

			case "aspectratio":
				hideAfterAction = false;				
				if (jQuery('#layer_proportional_scale')[0].checked) {
					jQuery('#layer_proportional_scale')[0].checked = false;
					jQuery('#ctx_keepaspect').addClass("ctx-td-s-off");
				}
				else {
					jQuery('#layer_proportional_scale')[0].checked = true;
					jQuery('#ctx_keepaspect').removeClass("ctx-td-s-off");
				}
				objUpdate.scaleProportional = jQuery('#layer_proportional_scale')[0].checked;
				updateLayerForm = true;				
			break;
			case "copystyle":
				hideAfterAction = false;
				var objLayer = u.getLayer(u.selectedLayerSerial);
				t.stylecache = jQuery.extend(true, {}, objLayer);
				UniteAdminRev.showInfo({type:"success",content:"Layer Style Successfull Copied to Clipboard",hidedelay:3});					
			break;
			case "pastestyle":
				hideAfterAction = false;
				var objLayer = u.getLayer(u.selectedLayerSerial);
				
				if (jQuery.isEmptyObject(t.stylecache)===false) {
					objUpdate.deformation = t.stylecache.deformation;
					objUpdate["deformation-hover"] = t.stylecache["deformation-hover"];
					objUpdate.display = t.stylecache.display;
					objUpdate.displaymode = t.stylecache.displaymode;
					objUpdate.margin = t.stylecache.margin;
					objUpdate.autolinebreak = t.stylecache.autolinebreak;
					objUpdate.padding = t.stylecache.padding;
					objUpdate.whitespace = t.stylecache.whitespace;
					objUpdate.static_styles = t.stylecache.static_styles;		
					objUpdate["2d_rotation"] = t.stylecache["2d_rotation"];
					objUpdate["image-size"] = t.stylecache["image-size"];
					updateLayerForm = true;
					htmlLayer = objLayer.references.htmlLayer;
					rebuild = true;
				} else {
					UniteAdminRev.showInfo({type:"warning",content:"No Style saved to Clipboard",hidedelay:3});					
				}
			break;

			case "inheritfromdesktop":
			case "inheritfromnotebook":
			case "inheritfromtablet":
			case "inheritfrommobile":
				var objLayer = u.getLayer(u.selectedLayerSerial),
					size = link.getAttribute("data-size"),
					objUpdate = {};
				objUpdate.static_styles = {};
				objUpdate.static_styles["color"]={};
				objUpdate.static_styles["font-size"]={};
				objUpdate.static_styles["line-height"]={};
				objUpdate.static_styles["font-weight"]={};
				objUpdate.padding = {};
				objUpdate.margin = {};
				objUpdate.max_height = {};
				objUpdate.max_width = {};
				objUpdate.scaleX = {};
				objUpdate.scaleY = {};
				objUpdate["text-align"] = {};
				objUpdate.vieo_width = {};
				objUpdate.video_height = {};
				objUpdate.whitespace = {};

				
				objUpdate.static_styles = u.setVal(objUpdate["static_styles"],"color",u.getVal(objLayer["static_styles"], "color",size), false);				
				objUpdate.static_styles = u.setVal(objUpdate["static_styles"],"font-size",u.getVal(objLayer["static_styles"], "font-size",size), false);
				objUpdate.static_styles = u.setVal(objUpdate["static_styles"],"line-height",u.getVal(objLayer["static_styles"], "line-height",size), false);
				objUpdate.static_styles = u.setVal(objUpdate["static_styles"],"font-weight",u.getVal(objLayer["static_styles"], "font-weight",size), false);

				objUpdate = u.setVal(objUpdate,"padding",u.getVal(objLayer, "padding",size), false);
				objUpdate = u.setVal(objUpdate,"margin",u.getVal(objLayer, "margin",size), false);				
				objUpdate = u.setVal(objUpdate,"max_height",u.getVal(objLayer, "max_height",size), false);
				objUpdate = u.setVal(objUpdate,"max_width",u.getVal(objLayer, "max_width",size), false);
				objUpdate = u.setVal(objUpdate,"scaleX",u.getVal(objLayer, "scaleX",size), false);
				objUpdate = u.setVal(objUpdate,"scaleY",u.getVal(objLayer, "scaleY",size), false);
				objUpdate = u.setVal(objUpdate,"text-align",u.getVal(objLayer, "text-align",size), false);
				objUpdate = u.setVal(objUpdate,"vieo_width",u.getVal(objLayer, "vieo_width",size), false);
				objUpdate = u.setVal(objUpdate,"video_height",u.getVal(objLayer, "video_height",size), false);
				objUpdate = u.setVal(objUpdate,"whitespace",u.getVal(objLayer, "whitespace",size), false);
				

				updateLayerForm = true;
				htmlLayer = objLayer.references.htmlLayer;
				rebuild = true;
			break;

			case "showhideondesktop":
				hideAfterAction = false;				
				objUpdate['visible-desktop'] = switchOnOff(link);
				updateLayerForm = true;
			break;
			case "showhideonnotebook":
				hideAfterAction = false;
				objUpdate['visible-notebook'] = switchOnOff(link);
				updateLayerForm = true;
			break;
			case "showhideontablet":
				hideAfterAction = false;
				objUpdate['visible-tablet'] = switchOnOff(link);
				updateLayerForm = true;
			break;
			case "showhideonmobile":
				hideAfterAction = false;
				objUpdate['visible-mobile'] = switchOnOff(link);
				updateLayerForm = true;
			break;
			case "grouplinkchange":
				hideAfterAction = false;
				objUpdate.groupLink = link.getAttribute("data-linktype");
				var objLayer = u.getLayer(u.selectedLayerSerial),
					_sl = objLayer.references.sorttable.layer.find('.layer-link-type-element-cs').first(),
					_csl = jQuery('#ctx-layer-link-type-element-cs');
				for (var i=0;i<6;i++) {
					_sl.removeClass('layer-link-type-'+i);
					_csl.removeClass('ctx-layer-link-type-'+i);
				}
				_sl.addClass('layer-link-type-'+objUpdate.groupLink);
				_csl.addClass('ctx-layer-link-type-'+objUpdate.groupLink);

			break;
			case "addtextlayer":
				u.nextNewLayerToPosition(clickCoords);
				jQuery('#button_add_layer').click();
			break;
			case "addimagelayer":
				u.nextNewLayerToPosition(clickCoords);
				jQuery('#button_add_layer_image').click();
			break;
			case "addaudiolayer":
				u.nextNewLayerToPosition(clickCoords);
				jQuery('#button_add_layer_audio').click();
			break;
			case "addvideolayer":
				u.nextNewLayerToPosition(clickCoords);
				jQuery('#button_add_layer_video').click();
			break;
			case "addbuttonlayer":
				u.nextNewLayerToPosition(clickCoords);
				jQuery('#button_add_layer_button').click();
			break;
			case "addshapelayer":
				u.nextNewLayerToPosition(clickCoords);
				jQuery('#button_add_layer_shape').click();
			break;
			case "addobjectlayer":
				u.nextNewLayerToPosition(clickCoords);
				jQuery('#button_add_layer_svg').click();
			break;



		}

		if (jQuery.isEmptyObject(objUpdate)===false) 
			u.updateLayer(u.selectedLayerSerial, objUpdate);
		
		if (updateLayerForm)
			u.updateLayerFormFields(u.selectedLayerSerial);

		if (rebuild)
			tl.rebuildLayerIdle(htmlLayer);
	
		//console.log( "Task ID - " + taskItemInContext.getAttribute("data-id") + ", Task action - " + link.getAttribute("data-action"));
		if (hideAfterAction) t.toggleMenuOff();
	}
	 
}
