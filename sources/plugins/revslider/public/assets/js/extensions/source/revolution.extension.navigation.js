/********************************************
 * REVOLUTION 5.2 EXTENSION - NAVIGATION
 * @version: 1.3.1 (25.10.2016)
 * @requires jquery.themepunch.revolution.js
 * @author ThemePunch
*********************************************/
(function($) {
"use strict";
var _R = jQuery.fn.revolution,
	_ISM = _R.is_mobile(),
	extension = {	alias:"Navigation Min JS",
					name:"revolution.extensions.navigation.min.js",
					min_core: "5.3",
					version:"1.3.1"
			  };


///////////////////////////////////////////
// 	EXTENDED FUNCTIONS AVAILABLE GLOBAL  //
///////////////////////////////////////////
jQuery.extend(true,_R, {

		
	hideUnHideNav : function(opt) {	
		var w = opt.c.width(),
			a = opt.navigation.arrows,
			b = opt.navigation.bullets,
			c = opt.navigation.thumbnails,
			d = opt.navigation.tabs;

		if (ckNO(a)) biggerNav(opt.c.find('.tparrows'),a.hide_under,w,a.hide_over);	
		if (ckNO(b)) biggerNav(opt.c.find('.tp-bullets'),b.hide_under,w,b.hide_over);			
		if (ckNO(c)) biggerNav(opt.c.parent().find('.tp-thumbs'),c.hide_under,w,c.hide_over);	
		if (ckNO(d)) biggerNav(opt.c.parent().find('.tp-tabs'),d.hide_under,w,d.hide_over);		
		
		setONHeights(opt);
		
	},

	resizeThumbsTabs : function(opt,force) {	
		
		
		if ((opt.navigation && opt.navigation.tabs.enable) || (opt.navigation && opt.navigation.thumbnails.enable)) {
			var f = (jQuery(window).width()-480) / 500,
				tws = new punchgs.TimelineLite(),
				otab = opt.navigation.tabs,
				othu = opt.navigation.thumbnails,
				otbu = opt.navigation.bullets;

			tws.pause();
			f = f>1 ? 1 : f<0 ? 0 : f;
			
			if (ckNO(otab) && (force || otab.width>otab.min_width)) rtt(f,tws,opt.c,otab,opt.slideamount,'tab');	
			if (ckNO(othu) && (force || othu.width>othu.min_width)) rtt(f,tws,opt.c,othu,opt.slideamount,'thumb');
			if (ckNO(otbu) && force) {
				// SET BULLET SPACES AND POSITION
				var bw = opt.c.find('.tp-bullets');

				bw.find('.tp-bullet').each(function(i){
					var b = jQuery(this),			
						am = i+1,
						w = b.outerWidth()+parseInt((otbu.space===undefined? 0:otbu.space),0),
						h = b.outerHeight()+parseInt((otbu.space===undefined? 0:otbu.space),0);					
					
				if (otbu.direction==="vertical") {
					b.css({top:((am-1)*h)+"px", left:"0px"});
					bw.css({height:(((am-1)*h) + b.outerHeight()),width:b.outerWidth()});
				}
				else {
					b.css({left:((am-1)*w)+"px", top:"0px"});
					bw.css({width:(((am-1)*w) + b.outerWidth()),height:b.outerHeight()});			
				}
				});
				
			}

			tws.play();	
			
			setONHeights(opt);
		}
		return true;
	},

	updateNavIndexes : function(opt) {
		var _ = opt.c;
		
		function setNavIndex(a) {
			if (_.find(a).lenght>0) {
				_.find(a).each(function(i) {				
					jQuery(this).data('liindex',i);
				})
			}
		}
		
		setNavIndex('.tp-tab');
		setNavIndex('.tp-bullet');
		setNavIndex('.tp-thumb');		
		_R.resizeThumbsTabs(opt,true);
		_R.manageNavigation(opt);
	},


	// PUT NAVIGATION IN POSITION AND MAKE SURE THUMBS AND TABS SHOWING TO THE RIGHT POSITION
	manageNavigation : function(opt) {
		

		
		var	lof = _R.getHorizontalOffset(opt.c.parent(),"left"),
			rof = _R.getHorizontalOffset(opt.c.parent(),"right");

		if (ckNO(opt.navigation.bullets)) {
			if (opt.sliderLayout!="fullscreen" && opt.sliderLayout!="fullwidth") {
				// OFFSET ADJUSTEMENT FOR LEFT ARROWS BASED ON THUMBNAILS AND TABS OUTTER
				opt.navigation.bullets.h_offset_old = opt.navigation.bullets.h_offset_old === undefined ? opt.navigation.bullets.h_offset : opt.navigation.bullets.h_offset_old;
				opt.navigation.bullets.h_offset = opt.navigation.bullets.h_align==="center" ? opt.navigation.bullets.h_offset_old+lof/2 -rof/2: opt.navigation.bullets.h_offset_old+lof-rof;
			}
			setNavElPositions(opt.c.find('.tp-bullets'),opt.navigation.bullets,opt);		
		}
		
		if (ckNO(opt.navigation.thumbnails)) 
			setNavElPositions(opt.c.parent().find('.tp-thumbs'),opt.navigation.thumbnails,opt);		

		if (ckNO(opt.navigation.tabs))
			setNavElPositions(opt.c.parent().find('.tp-tabs'),opt.navigation.tabs,opt);		
		
		if (ckNO(opt.navigation.arrows)) {
			
			if (opt.sliderLayout!="fullscreen" && opt.sliderLayout!="fullwidth") {
				// OFFSET ADJUSTEMENT FOR LEFT ARROWS BASED ON THUMBNAILS AND TABS OUTTER
				opt.navigation.arrows.left.h_offset_old = opt.navigation.arrows.left.h_offset_old === undefined ? opt.navigation.arrows.left.h_offset : opt.navigation.arrows.left.h_offset_old;
				opt.navigation.arrows.left.h_offset = opt.navigation.arrows.left.h_align==="right" ?  opt.navigation.arrows.left.h_offset_old+rof : opt.navigation.arrows.left.h_offset_old+lof;

				opt.navigation.arrows.right.h_offset_old = opt.navigation.arrows.right.h_offset_old === undefined ? opt.navigation.arrows.right.h_offset : opt.navigation.arrows.right.h_offset_old;
				opt.navigation.arrows.right.h_offset = opt.navigation.arrows.right.h_align==="right" ? opt.navigation.arrows.right.h_offset_old+rof : opt.navigation.arrows.right.h_offset_old+lof;
			}
			setNavElPositions(opt.c.find('.tp-leftarrow.tparrows'),opt.navigation.arrows.left,opt);
			setNavElPositions(opt.c.find('.tp-rightarrow.tparrows'),opt.navigation.arrows.right,opt);
		}


		if (ckNO(opt.navigation.thumbnails))
			moveThumbsInPosition(opt.c.parent().find('.tp-thumbs'),opt.navigation.thumbnails);
		
		if (ckNO(opt.navigation.tabs))
			moveThumbsInPosition(opt.c.parent().find('.tp-tabs'),opt.navigation.tabs);
	},


	// MANAGE THE NAVIGATION
	 createNavigation : function(container,opt) {
	 	if (_R.compare_version(extension).check==="stop") return false;
		var cp = container.parent(),		
			_a = opt.navigation.arrows, _b = opt.navigation.bullets, _c = opt.navigation.thumbnails, _d = opt.navigation.tabs,
			a = ckNO(_a), b = ckNO(_b), c = ckNO(_c), d = ckNO(_d);
			
		
		// Initialise Keyboard Navigation if Option set so
		initKeyboard(container,opt);

		// Initialise Mouse Scroll Navigation if Option set so
		initMouseScroll(container,opt);

		//Draw the Arrows
		if (a) initArrows(container,_a,opt);

		// BUILD BULLETS, THUMBS and TABS		
		opt.li.each(function(index) {
			
			var li_rtl = jQuery(opt.li[opt.li.length-1-index]);
			var li = jQuery(this);				

			if (b) 
				if (opt.navigation.bullets.rtl)
					addBullet(container,_b,li_rtl,opt);		
				else
					addBullet(container,_b,li,opt);	
			
			if (c) 
				if (opt.navigation.thumbnails.rtl)
					addThumb(container,_c,li_rtl,'tp-thumb',opt);		
				else
					addThumb(container,_c,li,'tp-thumb',opt);
			if (d) 
				if (opt.navigation.tabs.rtl)
					addThumb(container,_d,li_rtl,'tp-tab',opt);
				else
					addThumb(container,_d,li,'tp-tab',opt);
		});
		
		// LISTEN TO SLIDE CHANGE - SET ACTIVE SLIDE BULLET				
		container.bind('revolution.slide.onafterswap revolution.nextslide.waiting',function() {		
			
			//cp.find('.tp-bullet, .tp-thumb, .tp-tab').removeClass("selected");			
			
			var si = container.find(".next-revslide").length==0 ? container.find(".active-revslide").data("index") : container.find(".next-revslide").data("index");			
			
			container.find('.tp-bullet').each(function() {
				var _t = jQuery(this);		
				if (_t.data('liref')===si) 
					_t.addClass("selected");
				else
					_t.removeClass("selected");
			});		

			cp.find('.tp-thumb, .tp-tab').each(function() {
				var _t = jQuery(this);				
				if (_t.data('liref')===si) {			
					_t.addClass("selected");	
					if (_t.hasClass("tp-tab"))			
						moveThumbsInPosition(cp.find('.tp-tabs'),_d);				
					else
						moveThumbsInPosition(cp.find('.tp-thumbs'),_c);				
				} else
					_t.removeClass("selected");		
				
			});		
			
			var ai = 0,			
				f = false;
			if (opt.thumbs)
				jQuery.each(opt.thumbs,function(i,obj) {			
					ai = f === false ? i : ai;
					f = obj.id === si || i === si ? true : f;
				});			
			
			
			var pi = ai>0 ? ai-1 : opt.slideamount-1,
				ni = (ai+1)==opt.slideamount ? 0 : ai+1;
				
			
			if (_a.enable === true) {
				var inst = _a.tmp;
				if (opt.thumbs[pi]!=undefined) {
					jQuery.each(opt.thumbs[pi].params,function(i,obj) {
						inst = inst.replace(obj.from,obj.to);
					});	
				}
				_a.left.j.html(inst);
				inst = _a.tmp;
				if (ni>opt.slideamount) return;
				jQuery.each(opt.thumbs[ni].params,function(i,obj) {
					inst = inst.replace(obj.from,obj.to);
				});	
				_a.right.j.html(inst);
				punchgs.TweenLite.set(_a.left.j.find('.tp-arr-imgholder'),{backgroundImage:"url("+opt.thumbs[pi].src+")"});
				punchgs.TweenLite.set(_a.right.j.find('.tp-arr-imgholder'),{backgroundImage:"url("+opt.thumbs[ni].src+")"});			
			}

			
		});
			
		hdResets(_a);
		hdResets(_b);
		hdResets(_c);
		hdResets(_d);
		
		
		// HOVER OVER ELEMENTS SHOULD SHOW/HIDE NAVIGATION ELEMENTS
		cp.on("mouseenter mousemove",function() {

			if (!cp.hasClass("tp-mouseover")) {
				cp.addClass("tp-mouseover");
				
				punchgs.TweenLite.killDelayedCallsTo(showHideNavElements);
				
				if (a && _a.hide_onleave) showHideNavElements(cp.find('.tparrows'),_a,"show");
				if (b && _b.hide_onleave) showHideNavElements(cp.find('.tp-bullets'),_b,"show");		
				if (c && _c.hide_onleave) showHideNavElements(cp.find('.tp-thumbs'),_c,"show");
				if (d && _d.hide_onleave) showHideNavElements(cp.find('.tp-tabs'),_d,"show");
				
				// ON MOBILE WE NEED TO HIDE ELEMENTS EVEN AFTER TOUCH
				if (_ISM) {
					cp.removeClass("tp-mouseover");		
					callAllDelayedCalls(container,opt);
				}
			}
		});
		
		cp.on("mouseleave",function() {
			cp.removeClass("tp-mouseover");		
			callAllDelayedCalls(container,opt);
		});

		// FIRST RUN HIDE ALL ELEMENTS 
		if (a && _a.hide_onleave) showHideNavElements(cp.find('.tparrows'),_a,"hide",0);
		if (b && _b.hide_onleave) showHideNavElements(cp.find('.tp-bullets'),_b,"hide",0);	
		if (c && _c.hide_onleave) showHideNavElements(cp.find('.tp-thumbs'),_c,"hide",0);
		if (d && _d.hide_onleave) showHideNavElements(cp.find('.tp-tabs'),_d,"hide",0);
		
		// Initialise Swipe Navigation
		if (c) swipeAction(cp.find('.tp-thumbs'),opt);
		if (d) swipeAction(cp.find('.tp-tabs'),opt);
		if (opt.sliderType==="carousel") swipeAction(container,opt,true);
		if (opt.navigation.touch.touchenabled=="on") swipeAction(container,opt,"swipebased");
	}

});




/////////////////////////////////
//	-	INTERNAL FUNCTIONS	- ///
/////////////////////////////////


var moveThumbsInPosition = function(container,opt) {

		var thumbs = container.hasClass("tp-thumbs") ? ".tp-thumbs" : ".tp-tabs",
			thumbmask = container.hasClass("tp-thumbs") ? ".tp-thumb-mask" : ".tp-tab-mask",
			thumbsiw = container.hasClass("tp-thumbs") ? ".tp-thumbs-inner-wrapper" : ".tp-tabs-inner-wrapper",
			thumb = container.hasClass("tp-thumbs") ? ".tp-thumb" : ".tp-tab",
			t=container.find(thumbmask),
			el = t.find(thumbsiw),
			thumbdir = opt.direction,							
			tw = thumbdir==="vertical" ? t.find(thumb).first().outerHeight(true)+opt.space : t.find(thumb).first().outerWidth(true)+opt.space,					
			tmw = thumbdir==="vertical" ? t.height() : t.width(),
			ti = parseInt(t.find(thumb+'.selected').data('liindex'),0),		
			me = tmw/tw,
			ts = thumbdir==="vertical" ? t.height() : t.width(),
			tp = 0-(ti * tw),
			els =  thumbdir==="vertical" ? el.height() : el.width(),
			curpos = tp < 0-(els-ts) ? 0-(els-ts) : curpos > 0 ? 0 : tp,
			elp = el.data('offset');


		if (me>2) {
			curpos = tp - (elp+tw) <= 0 ? tp - (elp+tw) < 0-tw ? elp : curpos + tw : curpos;		
			curpos = ( (tp-tw + elp + tmw)< tw && tp  + (Math.round(me)-2)*tw < elp) ? tp + (Math.round(me)-2)*tw : curpos;				
		}
		
		curpos = curpos < 0-(els-ts) ? 0-(els-ts) : curpos > 0 ? 0 : curpos;

		if (thumbdir!=="vertical" && t.width()>=el.width()) curpos = 0;
		if (thumbdir==="vertical" && t.height()>=el.height()) curpos = 0;


		if (!container.hasClass("dragged")) {
			if (thumbdir==="vertical")
				el.data('tmmove',punchgs.TweenLite.to(el,0.5,{top:curpos+"px",ease:punchgs.Power3.easeInOut}));
			else
				el.data('tmmove',punchgs.TweenLite.to(el,0.5,{left:curpos+"px",ease:punchgs.Power3.easeInOut}));
			el.data('offset',curpos);	
		}	
	};


// RESIZE THE THUMBS BASED ON ORIGINAL SIZE AND CURRENT SIZE OF WINDOW
var rtt = function(f,tws,c,o,lis,wh) {	
	var h = c.parent().find('.tp-'+wh+'s'),
		ins = h.find('.tp-'+wh+'s-inner-wrapper'),
		mask = h.find('.tp-'+wh+'-mask'),		
		cw = o.width*f < o.min_width ? o.min_width : Math.round(o.width*f),
		ch = Math.round((cw/o.width) * o.height),
		iw = o.direction === "vertical" ? cw : (cw*lis) + ((o.space)*(lis-1)),
		ih = o.direction === "vertical" ? (ch*lis) + ((o.space)*(lis-1)) : ch,
		anm = o.direction === "vertical" ? {width:cw+"px"} : {height:ch+"px"};
			

	tws.add(punchgs.TweenLite.set(h,anm));
	tws.add(punchgs.TweenLite.set(ins,{width:iw+"px",height:ih+"px"}));
	tws.add(punchgs.TweenLite.set(mask,{width:iw+"px",height:ih+"px"}));	
	var fin = ins.find('.tp-'+wh+'');
	if (fin)
		jQuery.each(fin,function(i,el) {
			if (o.direction === "vertical")
				tws.add(punchgs.TweenLite.set(el,{top:(i*(ch+parseInt((o.space===undefined? 0:o.space),0))),width:cw+"px",height:ch+"px"}));	
			else 
			if (o.direction === "horizontal")
				tws.add(punchgs.TweenLite.set(el,{left:(i*(cw+parseInt((o.space===undefined? 0:o.space),0))),width:cw+"px",height:ch+"px"}));	
		});	
	return tws;
};

// INTERNAL FUNCTIONS
var normalizeWheel = function( event) /*object*/ {
			
			  var sX = 0, sY = 0,       // spinX, spinY
			      pX = 0, pY = 0,       // pixelX, pixelY
			      PIXEL_STEP = 1,
			      LINE_HEIGHT = 1,
			      PAGE_HEIGHT = 1;

			  // Legacy
			  if ('detail'      in event) { sY = event.detail; }
			  if ('wheelDelta'  in event) { sY = -event.wheelDelta / 120; }
			  if ('wheelDeltaY' in event) { sY = -event.wheelDeltaY / 120; }
			  if ('wheelDeltaX' in event) { sX = -event.wheelDeltaX / 120; }

			  
			  //sY = navigator.userAgent.match(/mozilla/i) ? sY*10 : sY;
			  
			  
			  // side scrolling on FF with DOMMouseScroll
			  if ( 'axis' in event && event.axis === event.HORIZONTAL_AXIS ) {
			    sX = sY;
			    sY = 0;
			  }
			  
			  pX = sX * PIXEL_STEP;
			  pY = sY * PIXEL_STEP;

			  if ('deltaY' in event) { pY = event.deltaY; }
			  if ('deltaX' in event) { pX = event.deltaX; }



			  if ((pX || pY) && event.deltaMode) {
			    if (event.deltaMode == 1) {          // delta in LINE units
			      pX *= LINE_HEIGHT;
			      pY *= LINE_HEIGHT;
			    } else {                             // delta in PAGE units
			      pX *= PAGE_HEIGHT;
			      pY *= PAGE_HEIGHT;
			    }
			  }

			  // Fall-back if spin cannot be determined
			  if (pX && !sX) { sX = (pX < 1) ? -1 : 1; }
			  if (pY && !sY) { sY = (pY < 1) ? -1 : 1; }
			 
			  pY = navigator.userAgent.match(/mozilla/i) ? pY*10 : pY;			 			  

			  if (pY>300 || pY<-300) pY = pY/10;

			  return { spinX  : sX,
			           spinY  : sY,
			           pixelX : pX,
			           pixelY : pY };
		};

var initKeyboard = function(container,opt) {
	if (opt.navigation.keyboardNavigation!=="on")  return;		
	jQuery(document).keydown(function(e){
		if ((opt.navigation.keyboard_direction=="horizontal" && e.keyCode == 39) || (opt.navigation.keyboard_direction=="vertical" && e.keyCode==40)) {
			opt.sc_indicator="arrow";
			opt.sc_indicator_dir = 0;
			_R.callingNewSlide(container,1);					
		}
		if ((opt.navigation.keyboard_direction=="horizontal" && e.keyCode == 37) || (opt.navigation.keyboard_direction=="vertical" && e.keyCode==38)) {
			opt.sc_indicator="arrow";
			opt.sc_indicator_dir = 1;
			_R.callingNewSlide(container,-1);									
		}
	});		
};



var initMouseScroll = function(container,opt) {			

	if (opt.navigation.mouseScrollNavigation!=="on" && opt.navigation.mouseScrollNavigation!=="carousel") return;
	opt.isIEEleven = !!navigator.userAgent.match(/Trident.*rv\:11\./);
	opt.isSafari = !!navigator.userAgent.match(/safari/i);
	opt.ischrome = !!navigator.userAgent.match(/chrome/i);

	
	var bl = opt.ischrome ? -49 : opt.isIEEleven || opt.isSafari ? -9 : navigator.userAgent.match(/mozilla/i) ?  -29 :  -49,
		tl = opt.ischrome ? 49 : opt.isIEEleven || opt.isSafari ? 9 : navigator.userAgent.match(/mozilla/i) ? 29 :  49;
	
	
	container.on('mousewheel DOMMouseScroll', function(e) {							
						
			var res = normalizeWheel(e.originalEvent),		
				asi = container.find('.tp-revslider-slidesli.active-revslide').index(),
				psi = container.find('.tp-revslider-slidesli.processing-revslide').index(),
				fs = asi!=-1 && asi==0 || psi!=-1 && psi==0 ? true : false,
				ls = asi!=-1 && asi==opt.slideamount-1 || psi!=1 && psi==opt.slideamount-1 ? true:false,				
				ret = true;
			if (opt.navigation.mouseScrollNavigation=="carousel") 
				fs = ls = false;								
		

		if (psi==-1) {				

			if(res.pixelY<bl) {
				
				if (!fs) {					
					opt.sc_indicator="arrow";
					if (opt.navigation.mouseScrollReverse!=="reverse") {
						opt.sc_indicator_dir = 1;
						_R.callingNewSlide(container,-1);	
					} 
					ret = false;
				}
				if (!ls) {
					opt.sc_indicator="arrow";
					if (opt.navigation.mouseScrollReverse==="reverse") {
						opt.sc_indicator_dir = 0;
						_R.callingNewSlide(container,1);	
					}					
					ret = false;			 
				}
			 }
			 else 
			 if(res.pixelY>tl) {				
			 	if (!ls) {			 					 		
				 	opt.sc_indicator="arrow";
				 	if (opt.navigation.mouseScrollReverse!=="reverse") {
						opt.sc_indicator_dir = 0;
						_R.callingNewSlide(container,1);	
					} 				
					ret = false;
				}
				if (!fs) {
					opt.sc_indicator="arrow";
					if (opt.navigation.mouseScrollReverse==="reverse") {
						opt.sc_indicator_dir = 1;
						_R.callingNewSlide(container,-1);	
					}		
					ret = false;
				}
			 }
			 
			
		} else {										
			ret = false;		
		}	

		var tc = opt.c.offset().top-jQuery('body').scrollTop(),
			bc = tc+opt.c.height();
		if (opt.navigation.mouseScrollNavigation!="carousel") {
			if (opt.navigation.mouseScrollReverse!=="reverse")
				if ((tc>0 && res.pixelY>0) || (bc<jQuery(window).height() && res.pixelY<0))
					ret = true;
			if (opt.navigation.mouseScrollReverse==="reverse")
				if ((tc<0 && res.pixelY<0) || (bc>jQuery(window).height() && res.pixelY>0))
					ret = true;
		} else {
			ret=false;
		}

		
		if (ret==false) {
			e.preventDefault(e);    		
			return false;
		} else {			
			return;
		}
	});
};

var isme = function (a,c,e) {		
		a =  _ISM ? jQuery(e.target).closest('.'+a).length || jQuery(e.srcElement).closest('.'+a).length : jQuery(e.toElement).closest('.'+a).length || jQuery(e.originalTarget).closest('.'+a).length;
		return a === true || a=== 1 ? 1 : 0;
};

// 	-	SET THE SWIPE FUNCTION //	
var swipeAction = function(container,opt,vertical) {	
		
	//container[0].opt = opt;

	// TOUCH ENABLED SCROLL
	var _ = opt.carousel;
	jQuery(".bullet, .bullets, .tp-bullets, .tparrows").addClass("noSwipe");
	
	_.Limit = "endless";			
	var notonbody =  _ISM || _R.get_browser()==="Firefox",
		SwipeOn =  container, //notonbody ? container : jQuery('body'),
		pagescroll = opt.navigation.thumbnails.direction==="vertical" || opt.navigation.tabs.direction==="vertical"? "none" : "vertical",
		swipe_wait_dir = opt.navigation.touch.swipe_direction || "horizontal";

	pagescroll = vertical == "swipebased" && swipe_wait_dir=="vertical" ? "none" : vertical ? "vertical" : pagescroll;
	
	if (!jQuery.fn.swipetp) jQuery.fn.swipetp = jQuery.fn.swipe;
	if (!jQuery.fn.swipetp.defaults || !jQuery.fn.swipetp.defaults.excludedElements) 
		if (!jQuery.fn.swipetp.defaults) 
			jQuery.fn.swipetp.defaults = new Object();

	jQuery.fn.swipetp.defaults.excludedElements = "label, button, input, select, textarea, .noSwipe"


	SwipeOn.swipetp({			
		allowPageScroll:pagescroll,			
		triggerOnTouchLeave:true,
		treshold:opt.navigation.touch.swipe_treshold,
		fingers:opt.navigation.touch.swipe_min_touches,
						
		excludeElements:jQuery.fn.swipetp.defaults.excludedElements,	
			
		swipeStatus:function(event,phase,direction,distance,duration,fingerCount,fingerData) {			
					

			var withinslider = isme('rev_slider_wrapper',container,event),
				withinthumbs =  isme('tp-thumbs',container,event),
				withintabs =  isme('tp-tabs',container,event),
				starget = jQuery(this).attr('class'),
				istt = starget.match(/tp-tabs|tp-thumb/gi) ? true : false;
								

				
			// SWIPE OVER SLIDER, TO SWIPE SLIDES IN CAROUSEL MODE
			if (opt.sliderType==="carousel" && 
				(((phase==="move" || phase==="end" || phase=="cancel") &&  (opt.dragStartedOverSlider && !opt.dragStartedOverThumbs && !opt.dragStartedOverTabs))
				 || (phase==="start" && withinslider>0 && withinthumbs===0 && withintabs===0))) {				
									
				opt.dragStartedOverSlider = true;
				distance = (direction && direction.match(/left|up/g)) ?  Math.round(distance * -1) : distance = Math.round(distance * 1);
				
				switch (phase) {
					case "start":								
						if (_.positionanim!==undefined) {											
								_.positionanim.kill();																		
								_.slide_globaloffset = _.infinity==="off" ? _.slide_offset : _R.simp(_.slide_offset, _.maxwidth);																		
						}
						_.overpull = "none";																						
						_.wrap.addClass("dragged");		
					break;
					case "move":	
										

							_.slide_offset = _.infinity==="off" ? _.slide_globaloffset + distance : _R.simp(_.slide_globaloffset + distance, _.maxwidth);
							
							if (_.infinity==="off") {
								var bb = _.horizontal_align==="center" ? ((_.wrapwidth/2-_.slide_width/2) - _.slide_offset) / _.slide_width : (0 - _.slide_offset) / _.slide_width;
								
								if ((_.overpull ==="none" || _.overpull===0)  && (bb<0 || bb>opt.slideamount-1)) 
									_.overpull =  distance;
								else
								if (bb>=0 && bb<=opt.slideamount-1 && ((bb>=0 && distance>_.overpull) || (bb<=opt.slideamount-1 && distance<_.overpull)))
									_.overpull = 0;
																																			
								_.slide_offset = bb<0 ? _.slide_offset+ (_.overpull-distance)/1.1 + Math.sqrt(Math.abs((_.overpull-distance)/1.1)) : 
								 bb>opt.slideamount-1 ? _.slide_offset+ (_.overpull-distance)/1.1 - Math.sqrt(Math.abs((_.overpull-distance)/1.1)) : _.slide_offset ;
							 }
							_R.organiseCarousel(opt,direction,true,true);									
					break;

					case "end":
					case "cancel":		
							//duration !!
							_.slide_globaloffset = _.slide_offset;	
							_.wrap.removeClass("dragged");
							_R.carouselToEvalPosition(opt,direction);							
							opt.dragStartedOverSlider = false;
							opt.dragStartedOverThumbs = false;
							opt.dragStartedOverTabs = false;																									
					break;
				}
			}  else

			// SWIPE OVER THUMBS OR TABS
			if ((
				((phase==="move" || phase==="end" || phase=="cancel") &&  (!opt.dragStartedOverSlider && (opt.dragStartedOverThumbs || opt.dragStartedOverTabs)))
				 || 
				(phase==="start" && (withinslider>0 && (withinthumbs>0 || withintabs>0))))) {				
								
				
				if (withinthumbs>0) opt.dragStartedOverThumbs = true;
				if (withintabs>0) opt.dragStartedOverTabs = true;
				
				var thumbs = opt.dragStartedOverThumbs ? ".tp-thumbs" : ".tp-tabs",
					thumbmask = opt.dragStartedOverThumbs ? ".tp-thumb-mask" : ".tp-tab-mask",
					thumbsiw = opt.dragStartedOverThumbs ? ".tp-thumbs-inner-wrapper" : ".tp-tabs-inner-wrapper",
					thumb = opt.dragStartedOverThumbs ? ".tp-thumb" : ".tp-tab",
					_o = opt.dragStartedOverThumbs ? opt.navigation.thumbnails : opt.navigation.tabs;


				distance = (direction && direction.match(/left|up/g)) ?  Math.round(distance * -1) : distance = Math.round(distance * 1);						
				var t= container.parent().find(thumbmask),
					el = t.find(thumbsiw),
					tdir = _o.direction,
					els = tdir==="vertical" ? el.height() : el.width(),
					ts =  tdir==="vertical" ? t.height() : t.width(),
					tw = tdir==="vertical" ? t.find(thumb).first().outerHeight(true)+_o.space : t.find(thumb).first().outerWidth(true)+_o.space,	
					newpos =  (el.data('offset') === undefined ? 0 : parseInt(el.data('offset'),0)),
					curpos = 0;
				
				switch (phase) {
					case "start":							
						container.parent().find(thumbs).addClass("dragged");
						newpos = tdir === "vertical" ? el.position().top : el.position().left;
						el.data('offset',newpos);
						if (el.data('tmmove')) el.data('tmmove').pause();
						
					break;
					case "move":	
							if (els<=ts) return false;
															
							curpos = newpos + distance;																					
							curpos = curpos>0 ? tdir==="horizontal" ? curpos - (el.width() * (curpos/el.width() * curpos/el.width())) : curpos - (el.height() * (curpos/el.height() * curpos/el.height())) : curpos;
							var dif = tdir==="vertical" ? 0-(el.height()-t.height()) : 0-(el.width()-t.width());
							curpos = curpos < dif ? tdir==="horizontal" ? curpos + (el.width() * (curpos-dif)/el.width() * (curpos-dif)/el.width()) : curpos + (el.height() * (curpos-dif)/el.height() * (curpos-dif)/el.height()) : curpos;									
							if (tdir==="vertical") 									
								punchgs.TweenLite.set(el,{top:curpos+"px"});									
							else
								punchgs.TweenLite.set(el,{left:curpos+"px"});	
							

					break;

					case "end":
					case "cancel":		
						
						if (istt) {
							curpos = newpos + distance;								
															
							curpos = tdir==="vertical" ? curpos < 0-(el.height()-t.height()) ? 0-(el.height()-t.height()) : curpos : curpos < 0-(el.width()-t.width()) ? 0-(el.width()-t.width()) : curpos;
							curpos = curpos > 0 ? 0 : curpos;

							curpos = Math.abs(distance)>tw/10 ? distance<=0 ? Math.floor(curpos/tw)*tw : Math.ceil(curpos/tw)*tw : distance<0 ? Math.ceil(curpos/tw)*tw : Math.floor(curpos/tw)*tw;

							curpos = tdir==="vertical" ? curpos < 0-(el.height()-t.height()) ? 0-(el.height()-t.height()) : curpos : curpos < 0-(el.width()-t.width()) ? 0-(el.width()-t.width()) : curpos;
							curpos = curpos > 0 ? 0 : curpos;
							
							if (tdir==="vertical")
								punchgs.TweenLite.to(el,0.5,{top:curpos+"px",ease:punchgs.Power3.easeOut});
							else
								punchgs.TweenLite.to(el,0.5,{left:curpos+"px",ease:punchgs.Power3.easeOut});

							curpos = !curpos ?  tdir==="vertical" ? el.position().top : el.position().left : curpos;	
							
							el.data('offset',curpos);								
							el.data('distance',distance);

							setTimeout(function() {
								opt.dragStartedOverSlider = false;
								opt.dragStartedOverThumbs = false;
								opt.dragStartedOverTabs = false;
							},100);
							container.parent().find(thumbs).removeClass("dragged");
							
							return false;
						}
					break;							
				}
			}									
			else  {								
				if (phase=="end" && !istt) {		
					
					opt.sc_indicator="arrow";	
					
					if ((swipe_wait_dir=="horizontal" && direction == "left") || (swipe_wait_dir=="vertical" && direction == "up")) {
						opt.sc_indicator_dir = 0;
						_R.callingNewSlide(opt.c,1);
						return false;
					}
					if ((swipe_wait_dir=="horizontal" && direction == "right") || (swipe_wait_dir=="vertical" && direction == "down")) {
						opt.sc_indicator_dir = 1;
						_R.callingNewSlide(opt.c,-1);	
						return false;
					}

				}
				opt.dragStartedOverSlider = false;
				opt.dragStartedOverThumbs = false;
				opt.dragStartedOverTabs = false;
				return true;				
			}												
		}
	});	
};


// NAVIGATION HELPER FUNCTIONS
var hdResets = function(o) { 
	o.hide_delay = !jQuery.isNumeric(parseInt(o.hide_delay,0)) ? 0.2 : o.hide_delay/1000; 
	o.hide_delay_mobile = !jQuery.isNumeric(parseInt(o.hide_delay_mobile,0)) ? 0.2 : o.hide_delay_mobile/1000;
};

var ckNO = function(opt) { 
 	return opt && opt.enable; 
};

var ckNOLO = function(opt) { 
 	return opt && opt.enable && opt.hide_onleave===true && (opt.position===undefined ? true : !opt.position.match(/outer/g)); 
};

var callAllDelayedCalls = function(container,opt) {
	var cp = container.parent();

	if (ckNOLO(opt.navigation.arrows))
			punchgs.TweenLite.delayedCall(_ISM ? opt.navigation.arrows.hide_delay_mobile : opt.navigation.arrows.hide_delay,showHideNavElements,[cp.find('.tparrows'),opt.navigation.arrows,"hide"]);

	if (ckNOLO(opt.navigation.bullets))
		punchgs.TweenLite.delayedCall(_ISM ? opt.navigation.bullets.hide_delay_mobile : opt.navigation.bullets.hide_delay,showHideNavElements,[cp.find('.tp-bullets'),opt.navigation.bullets,"hide"]);
	
	if (ckNOLO(opt.navigation.thumbnails))
		punchgs.TweenLite.delayedCall(_ISM ? opt.navigation.thumbnails.hide_delay_mobile : opt.navigation.thumbnails.hide_delay,showHideNavElements,[cp.find('.tp-thumbs'),opt.navigation.thumbnails,"hide"]);
	
	if (ckNOLO(opt.navigation.tabs))
		punchgs.TweenLite.delayedCall(_ISM ? opt.navigation.tabs.hide_delay_mobile : opt.navigation.tabs.hide_delay,showHideNavElements,[cp.find('.tp-tabs'),opt.navigation.tabs,"hide"]);
};

var showHideNavElements = function(container,opt,dir,speed) {
	speed = speed===undefined ? 0.5 : speed;	
	switch (dir) {
		case "show":	
			punchgs.TweenLite.to(container,speed, {autoAlpha:1,ease:punchgs.Power3.easeInOut,overwrite:"auto"});
		break;
		case "hide":
			punchgs.TweenLite.to(container,speed, {autoAlpha:0,ease:punchgs.Power3.easeInOu,overwrite:"auto"});
		break;		
	}	

};


// ADD ARROWS
var initArrows = function(container,o,opt) {

	// SET oIONAL CLASSES
	o.style = o.style === undefined ? "" : o.style;
	o.left.style = o.left.style === undefined ? "" : o.left.style;
	o.right.style = o.right.style === undefined ? "" : o.right.style;	
		
	
	// ADD LEFT AND RIGHT ARROWS
	if (container.find('.tp-leftarrow.tparrows').length===0) 
		container.append('<div class="tp-leftarrow tparrows '+o.style+' '+o.left.style+'">'+o.tmp+'</div>');
	if (container.find('.tp-rightarrow.tparrows').length===0) 
		container.append('<div class="tp-rightarrow tparrows '+o.style+' '+o.right.style+'">'+o.tmp+'</div>');	
	var la = container.find('.tp-leftarrow.tparrows'),
		ra = container.find('.tp-rightarrow.tparrows');
	if (o.rtl) {
		// CLICK HANDLINGS ON LEFT AND RIGHT ARROWS
		la.click(function() { opt.sc_indicator="arrow"; opt.sc_indicator_dir = 0;container.revnext();});
		ra.click(function() { opt.sc_indicator="arrow"; opt.sc_indicator_dir = 1;container.revprev();});
	} else {
		// CLICK HANDLINGS ON LEFT AND RIGHT ARROWS
		ra.click(function() { opt.sc_indicator="arrow"; opt.sc_indicator_dir = 0;container.revnext();});
		la.click(function() { opt.sc_indicator="arrow"; opt.sc_indicator_dir = 1;container.revprev();});
	}
	// SHORTCUTS
	o.right.j = container.find('.tp-rightarrow.tparrows');
	o.left.j = container.find('.tp-leftarrow.tparrows')
	
	// OUTTUER PADDING DEFAULTS
	o.padding_top = parseInt((opt.carousel.padding_top||0),0),
	o.padding_bottom = parseInt((opt.carousel.padding_bottom||0),0);
	
	// POSITION OF ARROWS
	setNavElPositions(la,o.left,opt);
	setNavElPositions(ra,o.right,opt);

	o.left.opt = opt;
	o.right.opt = opt;
	

	if (o.position=="outer-left" || o.position=="outer-right") opt.outernav = true;	
};


// PUT ELEMENTS VERTICAL / HORIZONTAL IN THE RIGHT POSITION
var putVinPosition = function(el,o,opt) {
	
	var elh = el.outerHeight(true),
		elw = el.outerWidth(true),
		oh = o.opt== undefined ? 0 : opt.conh == 0 ? opt.height : opt.conh,
		by = o.container=="layergrid" ? opt.sliderLayout=="fullscreen" ? opt.height/2 - (opt.gridheight[opt.curWinRange]*opt.bh)/2 : (opt.autoHeight=="on" || (opt.minHeight!=undefined && opt.minHeight>0)) ? oh/2 - (opt.gridheight[opt.curWinRange]*opt.bh)/2  : 0 : 0,		
		a = o.v_align === "top" ? {top:"0px",y:Math.round(o.v_offset+by)+"px"} : o.v_align === "center" ? {top:"50%",y:Math.round(((0-elh/2)+o.v_offset))+"px"} : {top:"100%",y:Math.round((0-(elh+o.v_offset+by)))+"px"};					
	if (!el.hasClass("outer-bottom")) punchgs.TweenLite.set(el,a);	
	
};

var putHinPosition = function(el,o,opt) {
	
	var elh = el.outerHeight(true),
		elw = el.outerWidth(true),
		bx = o.container=="layergrid" ? opt.sliderType==="carousel" ? 0 : opt.width/2 - (opt.gridwidth[opt.curWinRange]*opt.bw)/2 : 0,
		a = o.h_align === "left" ? {left:"0px",x:Math.round(o.h_offset+bx)+"px"} : o.h_align === "center" ? {left:"50%",x:Math.round(((0-elw/2)+o.h_offset))+"px"} : {left:"100%",x:Math.round((0-(elw+o.h_offset+bx)))+"px"};	
	punchgs.TweenLite.set(el,a);
};

// SET POSITION OF ELEMENTS
var setNavElPositions = function(el,o,opt) {

	var wrapper =  
		el.closest('.tp-simpleresponsive').length>0 ? 
			el.closest('.tp-simpleresponsive') : 
			el.closest('.tp-revslider-mainul').length>0 ? 
				el.closest('.tp-revslider-mainul')  : 
				el.closest('.rev_slider_wrapper').length>0  ? 
				el.closest('.rev_slider_wrapper'):
				el.parent().find('.tp-revslider-mainul'),
		ww = wrapper.width(),
		wh = wrapper.height();	

	putVinPosition(el,o,opt);
	putHinPosition(el,o,opt);

	if (o.position==="outer-left" && (o.sliderLayout=="fullwidth" || o.sliderLayout=="fullscreen")) 
		punchgs.TweenLite.set(el,{left:(0-el.outerWidth())+"px",x:o.h_offset+"px"});
	else 
	if (o.position==="outer-right" && (o.sliderLayout=="fullwidth" || o.sliderLayout=="fullscreen"))
		punchgs.TweenLite.set(el,{right:(0-el.outerWidth())+"px",x:o.h_offset+"px"});
	
		
	// MAX WIDTH AND HEIGHT BASED ON THE SOURROUNDING CONTAINER
	if (el.hasClass("tp-thumbs") || el.hasClass("tp-tabs")) {

		var wpad = el.data('wr_padding'),
			maxw = el.data('maxw'),
			maxh = el.data('maxh'),			
			mask = el.hasClass("tp-thumbs") ? el.find('.tp-thumb-mask') : el.find('.tp-tab-mask'),
			cpt = parseInt((o.padding_top||0),0),
			cpb = parseInt((o.padding_bottom||0),0);
					
		
		// ARE THE CONTAINERS BIGGER THAN THE SLIDER WIDTH OR HEIGHT ?
		if (maxw>ww && o.position!=="outer-left" && o.position!=="outer-right") {				
			punchgs.TweenLite.set(el,{left:"0px",x:0,maxWidth:(ww-2*wpad)+"px"});
			punchgs.TweenLite.set(mask,{maxWidth:(ww-2*wpad)+"px"});
		} else {			
			punchgs.TweenLite.set(el,{maxWidth:(maxw)+"px"});
			punchgs.TweenLite.set(mask,{maxWidth:(maxw)+"px"});			
		}
		
		if (maxh+2*wpad>wh && o.position!=="outer-bottom" && o.position!=="outer-top") {				
			punchgs.TweenLite.set(el,{top:"0px",y:0,maxHeight:(cpt+cpb+(wh-2*wpad))+"px"});
			punchgs.TweenLite.set(mask,{maxHeight:(cpt+cpb+(wh-2*wpad))+"px"});
		} else {						
			punchgs.TweenLite.set(el,{maxHeight:(maxh)+"px"});
			punchgs.TweenLite.set(mask,{maxHeight:maxh+"px"});
		}
		
		if (o.position!=="outer-left" && o.position!=="outer-right") {
			cpt = 0;
			cpb = 0;
		}

		// SPAN IS ENABLED
		if (o.span===true && o.direction==="vertical") {
			punchgs.TweenLite.set(el,{maxHeight:(cpt+cpb+(wh-2*wpad))+"px",height:(cpt+cpb+(wh-2*wpad))+"px",top:(0-cpt),y:0});					
			putVinPosition(mask,o,opt);
		} else 

		if (o.span===true && o.direction==="horizontal") {
			punchgs.TweenLite.set(el,{maxWidth:"100%",width:(ww-2*wpad)+"px",left:0,x:0});					
			putHinPosition(mask,o,opt);
		}
	}
};


// ADD A BULLET
var addBullet = function(container,o,li,opt) {
	
	// Check if Bullet exists already ?		
	if (container.find('.tp-bullets').length===0) {
		o.style = o.style === undefined ? "" : o.style;		
		container.append('<div class="tp-bullets '+o.style+' '+o.direction+'"></div>');
	}
	
	// Add Bullet Structure to the Bullet Container
	var bw = container.find('.tp-bullets'),
		 linkto = li.data('index'),
		 inst = o.tmp;

	jQuery.each(opt.thumbs[li.index()].params,function(i,obj) { inst = inst.replace(obj.from,obj.to);})


	bw.append('<div class="justaddedbullet tp-bullet">'+inst+'</div>');

	// SET BULLET SPACES AND POSITION
	var b = container.find('.justaddedbullet'),
		am = container.find('.tp-bullet').length,
		w = b.outerWidth()+parseInt((o.space===undefined? 0:o.space),0),
		h = b.outerHeight()+parseInt((o.space===undefined? 0:o.space),0);
		
		//bgimage = li.data('thumb') !==undefined ? li.data('thumb') : li.find('.defaultimg').data('lazyload') !==undefined && li.find('.defaultimg').data('lazyload') !== 'undefined' ? li.find('.defaultimg').data('lazyload') : li.find('.defaultimg').data('src');

	if (o.direction==="vertical") {
		
		b.css({top:((am-1)*h)+"px", left:"0px"});
		bw.css({height:(((am-1)*h) + b.outerHeight()),width:b.outerWidth()});
	}
	else {
		
		b.css({left:((am-1)*w)+"px", top:"0px"});
		bw.css({width:(((am-1)*w) + b.outerWidth()),height:b.outerHeight()});			
	}
	
	b.find('.tp-bullet-image').css({backgroundImage:'url('+opt.thumbs[li.index()].src+')'});
	// SET LINK TO AND LISTEN TO CLICK
	b.data('liref',linkto);
	b.click(function() {
		opt.sc_indicator="bullet";				
		container.revcallslidewithid(linkto);
		container.find('.tp-bullet').removeClass("selected");
		jQuery(this).addClass("selected");

	});		
	// REMOVE HELP CLASS
	b.removeClass("justaddedbullet");

	// OUTTUER PADDING DEFAULTS
	o.padding_top = parseInt((opt.carousel.padding_top||0),0),
	o.padding_bottom = parseInt((opt.carousel.padding_bottom||0),0);
	o.opt = opt;	
	if (o.position=="outer-left" || o.position=="outer-right") opt.outernav = true;

	bw.addClass("nav-pos-hor-"+o.h_align);
	bw.addClass("nav-pos-ver-"+o.v_align);
	bw.addClass("nav-dir-"+o.direction);

	// PUT ALL CONTAINER IN POSITION
	setNavElPositions(bw,o,opt);		
};


var cHex = function(hex,o){	
		o = parseFloat(o);
	    hex = hex.replace('#','');	    
	    var r = parseInt(hex.substring(0,2), 16),
	    	g = parseInt(hex.substring(2,4), 16),
	    	b = parseInt(hex.substring(4,6), 16),
			result = 'rgba('+r+','+g+','+b+','+o+')';
	    return result;
};

// ADD THUMBNAILS
var addThumb = function(container,o,li,what,opt) {
	var thumbs = what==="tp-thumb" ? ".tp-thumbs" : ".tp-tabs",
		thumbmask = what==="tp-thumb" ? ".tp-thumb-mask" : ".tp-tab-mask",
		thumbsiw = what==="tp-thumb" ? ".tp-thumbs-inner-wrapper" : ".tp-tabs-inner-wrapper",
		thumb = what==="tp-thumb" ? ".tp-thumb" : ".tp-tab",
		timg = what ==="tp-thumb" ? ".tp-thumb-image" : ".tp-tab-image";

	o.visibleAmount = o.visibleAmount>opt.slideamount ? opt.slideamount : o.visibleAmount;	
	o.sliderLayout = opt.sliderLayout;

	// Check if THUNBS/TABS exists already ?		
	if (container.parent().find(thumbs).length===0) {
		o.style = o.style === undefined ? "" : o.style;		
		
		var spanw = o.span===true ? "tp-span-wrapper" : "",
			addcontent = '<div class="'+what+'s '+spanw+" "+o.position+" "+o.style+'"><div class="'+what+'-mask"><div class="'+what+'s-inner-wrapper" style="position:relative;"></div></div></div>';
	
		if (o.position==="outer-top")
			container.parent().prepend(addcontent)
		else
		if (o.position==="outer-bottom") 
			container.after(addcontent);
		else		
			container.append(addcontent);

		// OUTTUER PADDING DEFAULTS
		o.padding_top = parseInt((opt.carousel.padding_top||0),0),
		o.padding_bottom = parseInt((opt.carousel.padding_bottom||0),0);
		 
		if (o.position=="outer-left" || o.position=="outer-right") opt.outernav = true;
	}
	
	

	// Add Thumb/TAB Structure to the THUMB/TAB Container
	var linkto = li.data('index'),
		t = container.parent().find(thumbs),
		tm = t.find(thumbmask),
		tw = tm.find(thumbsiw),
		maxw = o.direction==="horizontal" ? (o.width * o.visibleAmount) + (o.space*(o.visibleAmount-1)) : o.width,		
		maxh = o.direction==="horizontal" ? o.height : (o.height * o.visibleAmount) + (o.space*(o.visibleAmount-1)),
		inst = o.tmp;
		jQuery.each(opt.thumbs[li.index()].params,function(i,obj) {
			inst = inst.replace(obj.from,obj.to);
		})	
	

		tw.append('<div data-liindex="'+li.index()+'" data-liref="'+linkto+'" class="justaddedthumb '+what+'" style="width:'+o.width+'px;height:'+o.height+'px;">'+inst+'</div>');


	// SET BULLET SPACES AND POSITION
	var b = t.find('.justaddedthumb'),
		am = t.find(thumb).length,
		w = b.outerWidth()+parseInt((o.space===undefined? 0:o.space),0),
		h = b.outerHeight()+parseInt((o.space===undefined? 0:o.space),0);		

	// FILL CONTENT INTO THE TAB / THUMBNAIL
	b.find(timg).css({backgroundImage:"url("+opt.thumbs[li.index()].src+")"});
	

	if (o.direction==="vertical") {		
		b.css({top:((am-1)*h)+"px", left:"0px"});
		tw.css({height:(((am-1)*h) + b.outerHeight()),width:b.outerWidth()});
	}
	else {		
		b.css({left:((am-1)*w)+"px", top:"0px"});
		tw.css({width:(((am-1)*w) + b.outerWidth()),height:b.outerHeight()});			
	}

	t.data('maxw',maxw);
	t.data('maxh',maxh);
	t.data('wr_padding',o.wrapper_padding);
	var position = o.position === "outer-top" || o.position==="outer-bottom" ? "relative" : "absolute",
		_margin = (o.position === "outer-top" || o.position==="outer-bottom") && (o.h_align==="center") ? "auto" : "0";
	

	tm.css({maxWidth:maxw+"px",maxHeight:maxh+"px",overflow:"hidden",position:"relative"});		
	t.css({maxWidth:(maxw)+"px",/*margin:_margin, */maxHeight:maxh+"px",overflow:"visible",position:position,background:cHex(o.wrapper_color,o.wrapper_opacity),padding:o.wrapper_padding+"px",boxSizing:"contet-box"});

	
	
	// SET LINK TO AND LISTEN TO CLICK	
	b.click(function() {

		opt.sc_indicator="bullet";			
		var dis = container.parent().find(thumbsiw).data('distance');
		dis = dis === undefined ? 0 : dis;
		if (Math.abs(dis)<10) {					
			container.revcallslidewithid(linkto);			
			container.parent().find(thumbs).removeClass("selected");			
			jQuery(this).addClass("selected");
		} 
	});		
	// REMOVE HELP CLASS
	b.removeClass("justaddedthumb");

	o.opt = opt;

	t.addClass("nav-pos-hor-"+o.h_align);
	t.addClass("nav-pos-ver-"+o.v_align);
	t.addClass("nav-dir-"+o.direction);
	
	// PUT ALL CONTAINER IN POSITION		
	setNavElPositions(t,o,opt);	
};

var setONHeights = function(o) {
	var ot = o.c.parent().find('.outer-top'),
		ob = o.c.parent().find('.outer-bottom');
	o.top_outer = !ot.hasClass("tp-forcenotvisible") ? ot.outerHeight() || 0 : 0;
	o.bottom_outer = !ob.hasClass("tp-forcenotvisible") ? ob.outerHeight() || 0 : 0;
};


// HIDE NAVIGATION ON PURPOSE
var biggerNav = function(el,a,b,c) {				
	if (a>b || b>c) 
		el.addClass("tp-forcenotvisible")
	else
		el.removeClass("tp-forcenotvisible");
};

})(jQuery);