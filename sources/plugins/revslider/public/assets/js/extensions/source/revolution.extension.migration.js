/*****************************************************************************************************
 * jquery.themepunch.revmigrate.js - jQuery Plugin for Revolution Slider Migration from 4.x to 5.0   
 * @version: 1.0.2 (20.01.2016)
 * @requires jQuery v1.7 or later (tested on 1.9)
 * @author ThemePunch
*****************************************************************************************************/


(function($) {

var _R = jQuery.fn.revolution;

///////////////////////////////////////////
// 	EXTENDED FUNCTIONS AVAILABLE GLOBAL  //
///////////////////////////////////////////
jQuery.extend(true,_R, {

		// OUR PLUGIN HERE :)
		migration: function(container,options) {
			// PREPARE THE NEW OPTIONS
			options = prepOptions(options);			
			// PREPARE LAYER ANIMATIONS
			prepLayerAnimations(container,options);
			return options;
		}
	});

var prepOptions = function(o) {
	
	// PARALLAX FALLBACKS
	if (o.parallaxLevels || o.parallaxBgFreeze) {
		var p = new Object();		
		p.type = o.parallax
		p.levels = o.parallaxLevels;
		p.bgparallax = o.parallaxBgFreeze == "on" ? "off" : "on";

		p.disable_onmobile = o.parallaxDisableOnMobile;
		o.parallax = p;				
	}
	if (o.disableProgressBar === undefined) 
		o.disableProgressBar = o.hideTimerBar || "off";
	
	// BASIC FALLBACKS
	if (o.startwidth || o.startheight) {
		o.gridwidth = o.startwidth;
		o.gridheight = o.startheight;
	}

	if (o.sliderType===undefined) 
		o.sliderType = "standard";
	
	if (o.fullScreen==="on") 
		o.sliderLayout = "fullscreen";

	if (o.fullWidth==="on") 
		o.sliderLayout = "fullwidth";
	
	if (o.sliderLayout===undefined)
			o.sliderLayout = "auto";


	// NAVIGATION ARROW FALLBACKS
	if (o.navigation===undefined) {
		var n = new Object();
		if (o.navigationArrows=="solo" || o.navigationArrows=="nextto") {
			var a = new Object();
			a.enable = true;
			a.style = o.navigationStyle || "";
			a.hide_onmobile = o.hideArrowsOnMobile==="on" ? true : false; 														
			a.hide_onleave = o.hideThumbs >0 ? true : false;
			a.hide_delay = o.hideThumbs>0 ? o.hideThumbs : 200;
			a.hide_delay_mobile = o.hideNavDelayOnMobile || 1500;
			a.hide_under = 0;
			a.tmp = '';
			a.left = {															
							h_align:o.soloArrowLeftHalign,
							v_align:o.soloArrowLeftValign,
							h_offset:o.soloArrowLeftHOffset,
							v_offset:o.soloArrowLeftVOffset								
					 };
			a.right = {
							h_align:o.soloArrowRightHalign,
							v_align:o.soloArrowRightValign,
							h_offset:o.soloArrowRightHOffset,
							v_offset:o.soloArrowRightVOffset
						};
			n.arrows = a;
		}
		if (o.navigationType=="bullet") {
			var b = new Object();
			b.style = o.navigationStyle || "";
			b.enable=true;
			b.hide_onmobile = o.hideArrowsOnMobile==="on" ? true : false; 														
			b.hide_onleave = o.hideThumbs >0 ? true : false;
			b.hide_delay = o.hideThumbs>0 ? o.hideThumbs : 200;
			b.hide_delay_mobile = o.hideNavDelayOnMobile || 1500;
			b.hide_under = 0;
			b.direction="horizontal";
			b.h_align=o.navigationHAlign || "center";
			b.v_align=o.navigationVAlign || "bottom";
			b.space=5;
			b.h_offset=o.navigationHOffset || 0;
			b.v_offset=o.navigationVOffset || 20;
			b.tmp='<span class="tp-bullet-image"></span><span class="tp-bullet-title"></span>';
			n.bullets = b;
		}
		if (o.navigationType=="thumb") {
			var t = new Object();
			t.style=o.navigationStyle || "";
			t.enable=true;
			t.width=o.thumbWidth || 100;
			t.height=o.thumbHeight || 50;
			t.min_width=o.thumbWidth || 100;
			t.wrapper_padding=2;
			t.wrapper_color="#f5f5f5";
			t.wrapper_opacity=1;
			t.visibleAmount=o.thumbAmount || 3;
			t.hide_onmobile = o.hideArrowsOnMobile==="on" ? true : false; 														
			t.hide_onleave = o.hideThumbs >0 ? true : false;
			t.hide_delay = o.hideThumbs>0 ? o.hideThumbs : 200;
			t.hide_delay_mobile = o.hideNavDelayOnMobile || 1500;
			t.hide_under = 0;
			t.direction="horizontal";
			t.span=false;
			t.position="inner";							
			t.space=2;
			t.h_align=o.navigationHAlign || "center";
			t.v_align=o.navigationVAlign || "bottom";
			t.h_offset=o.navigationHOffset || 0;
			t.v_offset=o.navigationVOffset || 20;
			t.tmp='<span class="tp-thumb-image"></span><span class="tp-thumb-title"></span>';
			n.thumbnails = t;
		}
		
		o.navigation = n;

		o.navigation.keyboardNavigation=o.keyboardNavigation || "on";				
		o.navigation.onHoverStop=o.onHoverStop || "on";
		o.navigation.touch = {
			touchenabled:o.touchenabled || "on",
			swipe_treshold : o.swipe_treshold ||75,
			swipe_min_touches : o.swipe_min_touches || 1,
			drag_block_vertical:o.drag_block_vertical || false
		};

	}
	
	if (o.fallbacks==undefined)
		o.fallbacks  = {
						isJoomla:o.isJoomla || false,
						panZoomDisableOnMobile: o.parallaxDisableOnMobile || "off",
						simplifyAll:o.simplifyAll || "on",
						nextSlideOnWindowFocus:o.nextSlideOnWindowFocus || "off",	
						disableFocusListener:o.disableFocusListener || true						
					};

	return o;

}
	
var prepLayerAnimations = function(container,opt) {
			
	var c = new Object(),
		cw = container.width(),
		ch = container.height();

	c.skewfromleftshort = "x:-50;skX:85;o:0";
	c.skewfromrightshort = "x:50;skX:-85;o:0";
	c.sfl = "x:-50;o:0";
	c.sfr = "x:50;o:0";
	c.sft = "y:-50;o:0";
	c.sfb = "y:50;o:0";
	c.skewfromleft = "x:top;skX:85;o:0";
	c.skewfromright = "x:bottom;skX:-85;o:0";
	c.lfl = "x:top;o:0";
	c.lfr = "x:bottom;o:0";
	c.lft = "y:left;o:0";
	c.lfb = "y:right;o:0";
	c.fade = "o:0";
	var src = (Math.random()*720-360)
	
	
	container.find('.tp-caption').each(function() {		
		var cp = jQuery(this),
			rw = Math.random()*(cw*2)-cw,
			rh = Math.random()*(ch*2)-ch,
			rs = Math.random()*3,
			rz = Math.random()*720-360,
			rx = Math.random()*70-35,
			ry = Math.random()*70-35,
			ncc = cp.attr('class');
		c.randomrotate = "x:{-400,400};y:{-400,400};sX:{0,2};sY:{0,2};rZ:{-180,180};rX:{-180,180};rY:{-180,180};o:0;";	
		
		if (ncc.match("randomrotate")) cp.data('transform_in',c.randomrotate) 
			else
		if (ncc.match(/\blfl\b/)) cp.data('transform_in',c.lfl) 
			else
		if (ncc.match(/\blfr\b/)) cp.data('transform_in',c.lfr) 
			else
		if (ncc.match(/\blft\b/)) cp.data('transform_in',c.lft) 
			else
		if (ncc.match(/\blfb\b/)) cp.data('transform_in',c.lfb) 
			else
		if (ncc.match(/\bsfl\b/)) cp.data('transform_in',c.sfl) 
			else
		if (ncc.match(/\bsfr\b/)) cp.data('transform_in',c.sfr) 
			else
		if (ncc.match(/\bsft\b/)) cp.data('transform_in',c.sft) 
			else
		if (ncc.match(/\bsfb\b/)) cp.data('transform_in',c.sfb) 
			else
		if (ncc.match(/\bskewfromleftshort\b/)) cp.data('transform_in',c.skewfromleftshort) 
			else
		if (ncc.match(/\bskewfromrightshort\b/)) cp.data('transform_in',c.skewfromrightshort) 
			else 
		if (ncc.match(/\bskewfromleft\b/)) cp.data('transform_in',c.skewfromleft) 
			else
		if (ncc.match(/\bskewfromright\b/)) cp.data('transform_in',c.skewfromright) 
			else
		if (ncc.match(/\bfade\b/)) cp.data('transform_in',c.fade);

		if (ncc.match(/\brandomrotateout\b/)) cp.data('transform_out',c.randomrotate) 
			else
		if (ncc.match(/\bltl\b/)) cp.data('transform_out',c.lfl) 
			else
		if (ncc.match(/\bltr\b/)) cp.data('transform_out',c.lfr) 
			else
		if (ncc.match(/\bltt\b/)) cp.data('transform_out',c.lft) 
			else
		if (ncc.match(/\bltb\b/)) cp.data('transform_out',c.lfb) 
			else
		if (ncc.match(/\bstl\b/)) cp.data('transform_out',c.sfl) 
			else
		if (ncc.match(/\bstr\b/)) cp.data('transform_out',c.sfr) 
			else
		if (ncc.match(/\bstt\b/)) cp.data('transform_out',c.sft) 
			else
		if (ncc.match(/\bstb\b/)) cp.data('transform_out',c.sfb) 
			else
		if (ncc.match(/\bskewtoleftshortout\b/)) cp.data('transform_out',c.skewfromleftshort) 
			else
		if (ncc.match(/\bskewtorightshortout\b/)) cp.data('transform_out',c.skewfromrightshort) 
			else
		if (ncc.match(/\bskewtoleftout\b/)) cp.data('transform_out',c.skewfromleft) 
			else
		if (ncc.match(/\bskewtorightout\b/)) cp.data('transform_out',c.skewfromright) 
			else
		if (ncc.match(/\bfadeout\b/)) cp.data('transform_out',c.fade);

		if (cp.data('customin')!=undefined) cp.data('transform_in',cp.data('customin'));
		if (cp.data('customout')!=undefined) cp.data('transform_out',cp.data('customout'));			

	})
	
}
})(jQuery);					




