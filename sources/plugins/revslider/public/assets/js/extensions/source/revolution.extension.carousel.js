/********************************************
 * REVOLUTION 5.0 EXTENSION - CAROUSEL
 * @version: 1.1 (25.10.2015)
 * @requires jquery.themepunch.revolution.js
 * @author ThemePunch
*********************************************/
(function($) {
"use strict";
var _R = jQuery.fn.revolution,
	extension = {	alias:"Carousel Min JS",
					name:"revolution.extensions.carousel.min.js",
					min_core: "5.0",
					version:"1.1.0"
			  };

	///////////////////////////////////////////
	// 	EXTENDED FUNCTIONS AVAILABLE GLOBAL  //
	///////////////////////////////////////////
jQuery.extend(true,_R, {

	// CALCULATE CAROUSEL POSITIONS
	prepareCarousel : function(opt,a,direction) {	

		if (_R.compare_version(extension).check==="stop") return false;

		direction = opt.carousel.lastdirection = dircheck(direction,opt.carousel.lastdirection);		
		setCarouselDefaults(opt);	
			
		opt.carousel.slide_offset_target = getActiveCarouselOffset(opt);
		
		if (a==undefined) 	
			_R.carouselToEvalPosition(opt,direction);		
		else 	
			animateCarousel(opt,direction,false);	
			
	},

	// MOVE FORWARDS/BACKWARDS DEPENDING ON THE OFFSET TO GET CAROUSEL IN EVAL POSITION AGAIN
	carouselToEvalPosition : function(opt,direction) {
		
		var _ = opt.carousel;
		direction = _.lastdirection = dircheck(direction,_.lastdirection);		
		
		var bb = _.horizontal_align==="center" ? ((_.wrapwidth/2-_.slide_width/2) - _.slide_globaloffset) / _.slide_width : (0 - _.slide_globaloffset) / _.slide_width,
			fi = _R.simp(bb,opt.slideamount,false);		
		
		var cm = fi - Math.floor(fi),
			calc = 0,
			mc = -1 * (Math.ceil(fi) - fi),
			mf = -1 * (Math.floor(fi) - fi);
			
		calc = cm>=0.3 && direction==="left" || cm>=0.7 && direction==="right" ?  mc : cm<0.3 && direction==="left" || cm<0.7 && direction==="right" ? mf : calc;
		calc = _.infinity==="off" ?  fi<0 ? fi : bb>opt.slideamount-1 ? bb-(opt.slideamount-1) : calc : calc;

		_.slide_offset_target = calc * _.slide_width;
		// LONGER "SMASH" +/- 1 to Calc
		
		if (Math.abs(_.slide_offset_target) !==0) 
			animateCarousel(opt,direction,true);
		else {
			_R.organiseCarousel(opt,direction);				
		}	
	},

	// ORGANISE THE CAROUSEL ELEMENTS IN POSITION AND TRANSFORMS
	organiseCarousel : function(opt,direction,setmaind,unli) {	

		direction = direction === undefined  || direction=="down" || direction=="up" || direction===null || jQuery.isEmptyObject(direction) ? "left" : direction;
		var _ = opt.carousel,
			slidepositions = new Array(),
			len = _.slides.length,
			leftlimit = _.horizontal_align ==="right" ? opt.width : 0;
		

		for (var i=0;i<len;i++) {					
			var pos = (i * _.slide_width) + _.slide_offset;	
			if (_.infinity==="on") {						
				pos = pos>_.wrapwidth-_.inneroffset && direction=="right" ? _.slide_offset - ((_.slides.length-i)*_.slide_width) : pos;			
				pos = pos<0-_.inneroffset-_.slide_width && direction=="left" ? pos + _.maxwidth : pos;									
			}
			slidepositions[i] = pos;			
		}
		var maxd = 999;

		// SECOND RUN FOR NEGATIVE ADJUSTMENETS
		if (_.slides)
		 jQuery.each(_.slides,function(i,slide) {		
			var pos = slidepositions[i];		
			if (_.infinity==="on") {	

				pos = pos>_.wrapwidth-_.inneroffset && direction==="left" ? slidepositions[0] - ((len-i)*_.slide_width) : pos;
				pos = pos<0-_.inneroffset-_.slide_width ? direction=="left" ? pos + _.maxwidth :  direction==="right" ? slidepositions[len-1] + ((i+1)*_.slide_width) : pos : pos;			
			}

			var tr= new Object();	

			tr.left = pos + _.inneroffset;

			// CHCECK DISTANCES FROM THE CURRENT FAKE FOCUS POSITION
			var d =  _.horizontal_align==="center" ? (Math.abs(_.wrapwidth/2) - (tr.left+_.slide_width/2))/_.slide_width : (_.inneroffset - tr.left)/_.slide_width,
				offsdir = d<0 ? -1:1,
				ha = _.horizontal_align==="center" ? 2 : 1;
			 	
					
			if ((setmaind && Math.abs(d)<maxd) || d===0) {	
				maxd = Math.abs(d);				
				_.focused = i;		
			}	
									
			tr.width =_.slide_width;
			tr.x = 0;		
			tr.transformPerspective = 1200;
			tr.transformOrigin = "50% "+_.vertical_align;
					
			// SET VISIBILITY OF ELEMENT		
			if (_.fadeout==="on") 			
				if (_.vary_fade==="on")
					tr.autoAlpha = 1-Math.abs(((1/Math.ceil(_.maxVisibleItems/ha))*d))
				else 
					switch(_.horizontal_align) {
						case "center":
							tr.autoAlpha = Math.abs(d)<Math.ceil((_.maxVisibleItems/ha)-1) ? 1 : 1-(Math.abs(d)-Math.floor(Math.abs(d)));
						break;
						case "left":
							tr.autoAlpha = d<1 &&  d>0 ?  1-d : Math.abs(d)>_.maxVisibleItems-1 ? 1- (Math.abs(d)-(_.maxVisibleItems-1)) : 1;
						break;
						case "right":
							tr.autoAlpha = d>-1 &&  d<0 ?  1-Math.abs(d) : d>_.maxVisibleItems-1 ? 1- (Math.abs(d)-(_.maxVisibleItems-1)) : 1;
						break;
					}
			else
				tr.autoAlpha = Math.abs(d)<Math.ceil((_.maxVisibleItems/ha)) ? 1 : 0;

				
			
			// SET SCALE DOWNS 
			if (_.minScale!==undefined && _.minScale >0) {
				if (_.vary_scale==="on") {
					tr.scale = 1- Math.abs(((_.minScale/100/Math.ceil(_.maxVisibleItems/ha))*d));
					var sx = (_.slide_width - (_.slide_width*tr.scale))  *Math.abs(d);				
				} else {				
					tr.scale = d>=1 || d<=-1 ? 1 - _.minScale/100 : (100-( _.minScale*Math.abs(d)))/100;				
					var sx=(_.slide_width - (_.slide_width*(1 - _.minScale/100)))*Math.abs(d);				
				}
			}

			// ROTATION FUNCTIONS		
			if (_.maxRotation!==undefined && Math.abs(_.maxRotation)!=0)	{	
				if (_.vary_rotation  ==="on") {
					tr.rotationY = Math.abs(_.maxRotation) - Math.abs((1-Math.abs(((1/Math.ceil(_.maxVisibleItems/ha))*d))) * _.maxRotation);						
					tr.autoAlpha = Math.abs(tr.rotationY)>90 ? 0 : tr.autoAlpha;
				} else {
					tr.rotationY = d>=1 || d<=-1 ?  _.maxRotation : Math.abs(d)*_.maxRotation;
				}
				tr.rotationY = d<0 ? tr.rotationY*-1 : tr.rotationY;
			}

			// SET SPACES BETWEEN ELEMENTS
			tr.x = (-1*_.space) * d;	

			tr.left = Math.floor(tr.left);
			tr.x = Math.floor(tr.x);
			
			// ADD EXTRA SPACE ADJUSTEMENT IF COVER MODE IS SELECTED		
			 tr.scale !== undefined ? d<0 ? tr.x-sx :tr.x+sx : tr.x;

			// ZINDEX ADJUSTEMENT
			tr.zIndex = Math.round(100-Math.abs(d*5));
			
			// TRANSFORM STYLE			
			tr.transformStyle = opt.parallax.type!="3D" && opt.parallax.type!="3d" ? "flat" : "preserve-3d";
			


			// ADJUST TRANSFORMATION OF SLIDE
			punchgs.TweenLite.set(slide,tr);				
		});	
		
		if (unli) {
			opt.c.find('.next-revslide').removeClass("next-revslide");
			jQuery(_.slides[_.focused]).addClass("next-revslide");
			opt.c.trigger("revolution.nextslide.waiting");
		}	

		var ll = _.wrapwidth/2 - _.slide_offset ,
			rl = _.maxwidth+_.slide_offset-_.wrapwidth/2;			
	}	
		
});

/**************************************************
	-	CAROUSEL FUNCTIONS   -
***************************************************/

var defineCarouselElements = function(opt) {
	var _ = opt.carousel;

	_.infbackup = _.infinity;
	_.maxVisiblebackup = _.maxVisibleItems;
	// SET DEFAULT OFFSETS TO 0
	_.slide_globaloffset = "none";
	_.slide_offset = 0; 	
	// SET UL REFERENCE
	_.wrap = opt.c.find('.tp-carousel-wrapper');	
	// COLLECT SLIDES
	_.slides = opt.c.find('.tp-revslider-slidesli');

	// SET PERSPECTIVE IF ROTATION IS ADDED
	if (_.maxRotation!==0) 
		if (opt.parallax.type!="3D" && opt.parallax.type!="3d") 
			punchgs.TweenLite.set(_.wrap,{perspective:1200,transformStyle:"flat"});
		else
			punchgs.TweenLite.set(_.wrap,{perspective:1600,transformStyle:"preserve-3d"});

	if (_.border_radius!==undefined && parseInt(_.border_radius,0) >0) {
		punchgs.TweenLite.set(opt.c.find('.tp-revslider-slidesli'),{borderRadius:_.border_radius});
	}		
}

var setCarouselDefaults = function(opt) {	
	
	if (opt.bw===undefined) _R.setSize(opt);
	var _=opt.carousel,
		loff = _R.getHorizontalOffset(opt.c,"left"),
		roff = _R.getHorizontalOffset(opt.c,"right");		

	// IF NO DEFAULTS HAS BEEN DEFINED YET
	if (_.wrap===undefined) defineCarouselElements(opt);	
	// DEFAULT LI WIDTH SHOULD HAVE THE SAME WIDTH OF TH OPT WIDTH
	_.slide_width = _.stretch!=="on" ? opt.gridwidth[opt.curWinRange]*opt.bw : opt.c.width();		

	// CALCULATE CAROUSEL WIDTH
	_.maxwidth = opt.slideamount*_.slide_width;
	if (_.maxVisiblebackup>_.slides.length+1) 
		_.maxVisibleItems = _.slides.length+2;
	
	// SET MAXIMUM CAROUSEL WARPPER WIDTH (SHOULD BE AN ODD NUMBER)	
	_.wrapwidth = (_.maxVisibleItems * _.slide_width) + ((_.maxVisibleItems - 1) * _.space);	
	_.wrapwidth = opt.sliderLayout!="auto" ? 
		_.wrapwidth>opt.c.closest('.tp-simpleresponsive').width() ? opt.c.closest('.tp-simpleresponsive').width() : _.wrapwidth : 
		_.wrapwidth>opt.ul.width() ? opt.ul.width() : _.wrapwidth;
	

	// INFINITY MODIFICATIONS		
	_.infinity = _.wrapwidth >=_.maxwidth ? "off" : _.infbackup;
			
	
	// SET POSITION OF WRAP CONTAINER		
	_.wrapoffset = _.horizontal_align==="center" ? (opt.c.width()-roff - loff - _.wrapwidth)/2 : 0;	
	_.wrapoffset = opt.sliderLayout!="auto" && opt.outernav ? 0 : _.wrapoffset < loff ? loff : _.wrapoffset;
	
	var ovf = "hidden";
	if ((opt.parallax.type=="3D" || opt.parallax.type=="3d"))
		ovf = "visible";

	
	
	if (_.horizontal_align==="right")	
		punchgs.TweenLite.set(_.wrap,{left:"auto",right:_.wrapoffset+"px", width:_.wrapwidth, overflow:ovf});
	else
		punchgs.TweenLite.set(_.wrap,{right:"auto",left:_.wrapoffset+"px", width:_.wrapwidth, overflow:ovf});



	// INNER OFFSET FOR RTL
	_.inneroffset = _.horizontal_align==="right" ? _.wrapwidth - _.slide_width : 0;
	
	// THE REAL OFFSET OF THE WRAPPER
	_.realoffset = (Math.abs(_.wrap.position().left)); // + opt.c.width()/2);
	
	// THE SCREEN WIDTH/2
	_.windhalf = jQuery(window).width()/2;			

	

}


// DIRECTION CHECK
var dircheck = function(d,b) {		
	return d===null || jQuery.isEmptyObject(d) ? b : d === undefined ?  "right" : d;;
}

// ANIMATE THE CAROUSEL WITH OFFSETS
var animateCarousel = function(opt,direction,nsae) {
	var _ = opt.carousel;
	direction = _.lastdirection = dircheck(direction,_.lastdirection);		
	
	var animobj = new Object();	
	animobj.from = 0;
	animobj.to = _.slide_offset_target;
	if (_.positionanim!==undefined)
		_.positionanim.pause();
	_.positionanim = punchgs.TweenLite.to(animobj,1.2,{from:animobj.to,
		onUpdate:function() {					
			_.slide_offset = _.slide_globaloffset + animobj.from;
			_.slide_offset = _R.simp(_.slide_offset , _.maxwidth);
			_R.organiseCarousel(opt,direction,false,false);												
		},
		onComplete:function() {	
			
			_.slide_globaloffset = _.infinity==="off" ? _.slide_globaloffset + _.slide_offset_target : _R.simp(_.slide_globaloffset + _.slide_offset_target, _.maxwidth);
			_.slide_offset = _R.simp(_.slide_offset , _.maxwidth);
			
			_R.organiseCarousel(opt,direction,false,true);	
			var li = jQuery(opt.li[_.focused]);	
			opt.c.find('.next-revslide').removeClass("next-revslide");
			if (nsae) _R.callingNewSlide(opt.c,li.data('index'));
		}, ease:punchgs.Expo.easeOut});	
}


var breduc = function(a,m) {	
	return Math.abs(a)>Math.abs(m) ? a>0 ? a - Math.abs(Math.floor(a/(m))*(m)) : a + Math.abs(Math.floor(a/(m))*(m)) : a;
}

// CAROUSEL INFINITY MODE, DOWN OR UP ANIMATION
var getBestDirection = function(a,b,max) {		
		var dira = b-a,max,
			dirb = (b-max) - a,max;						
		dira = breduc(dira,max);
		dirb = breduc(dirb,max);		
		return Math.abs(dira)>Math.abs(dirb) ? dirb : dira;
	}

// GET OFFSETS BEFORE ANIMATION
var getActiveCarouselOffset = function(opt) {
	var ret = 0,
		_ = opt.carousel;
	
	if (_.positionanim!==undefined) _.positionanim.kill();					

	if (_.slide_globaloffset=="none") 
		_.slide_globaloffset = ret = _.horizontal_align==="center" ? (_.wrapwidth/2-_.slide_width/2) : 0;									
	
	else {
		
		_.slide_globaloffset = _.slide_offset;
		_.slide_offset = 0;
		var ci = opt.c.find('.processing-revslide').index(),
			fi = _.horizontal_align==="center" ? ((_.wrapwidth/2-_.slide_width/2) - _.slide_globaloffset) / _.slide_width : (0 - _.slide_globaloffset) / _.slide_width;				

		fi = _R.simp(fi,opt.slideamount,false);		
		ci = ci>=0 ? ci : opt.c.find('.active-revslide').index(); 
		ci = ci>=0 ? ci : 0;		
		
		ret = _.infinity==="off" ? fi-ci : -getBestDirection(fi,ci,opt.slideamount);				
		ret = ret *  _.slide_width;	
	}	
	return ret; 		
}
	
})(jQuery);