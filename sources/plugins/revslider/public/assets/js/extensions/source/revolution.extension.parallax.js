/********************************************
 * REVOLUTION 5.2.6 EXTENSION - PARALLAX
 * @version: 2.0.1 (24.10.2016)
 * @requires jquery.themepunch.revolution.js
 * @author ThemePunch
*********************************************/
(function($) {
"use strict";
var _R = jQuery.fn.revolution,
	_ISM = _R.is_mobile(),
	extension = {	alias:"Parallax Min JS",
					name:"revolution.extensions.parallax.min.js",
					min_core: "5.3",
					version:"2.0.1"
			  };

jQuery.extend(true,_R, {	
	
	checkForParallax : function(container,opt) {

		if (_R.compare_version(extension).check==="stop") return false;
		var _ = opt.parallax;

		if (_.done) return;
		_.done = true;

		if (_ISM && _.disable_onmobile=="on") return false;

		if (_.type=="3D" || _.type=="3d") {			
			punchgs.TweenLite.set(opt.c,{overflow:_.ddd_overflow});
			punchgs.TweenLite.set(opt.ul,{overflow:_.ddd_overflow});		
			if (opt.sliderType!="carousel" && _.ddd_shadow=="on") {
				opt.c.prepend('<div class="dddwrappershadow"></div>')
				punchgs.TweenLite.set(opt.c.find('.dddwrappershadow'),{force3D:"auto",transformPerspective:1600,transformOrigin:"50% 50%", width:"100%",height:"100%",position:"absolute",top:0,left:0,zIndex:0});			
			}
		}
		
		function setDDDInContainer(li) {
			if (_.type=="3D" || _.type=="3d") {
				li.find('.slotholder').wrapAll('<div class="dddwrapper" style="width:100%;height:100%;position:absolute;top:0px;left:0px;overflow:hidden"></div>');				
				li.find('.tp-parallax-wrap').wrapAll('<div class="dddwrapper-layer" style="width:100%;height:100%;position:absolute;top:0px;left:0px;z-index:5;overflow:'+_.ddd_layer_overflow+';"></div>');				

				// MOVE THE REMOVED 3D LAYERS OUT OF THE PARALLAX GROUP					
				li.find('.rs-parallaxlevel-tobggroup').closest('.tp-parallax-wrap').wrapAll('<div class="dddwrapper-layertobggroup" style="position:absolute;top:0px;left:0px;z-index:50;width:100%;height:100%"></div>');

				var dddw = li.find('.dddwrapper'),
					dddwl = li.find('.dddwrapper-layer'),
					dddwlbg = li.find('.dddwrapper-layertobggroup');

				dddwlbg.appendTo(dddw);
								
				if (opt.sliderType=="carousel") {
					 if (_.ddd_shadow=="on") dddw.addClass("dddwrappershadow");					 
					 punchgs.TweenLite.set(dddw,{borderRadius:opt.carousel.border_radius});
				}
				punchgs.TweenLite.set(li,{overflow:"visible",transformStyle:"preserve-3d",perspective:1600});
				punchgs.TweenLite.set(dddw,{force3D:"auto",transformOrigin:"50% 50%"});					
				punchgs.TweenLite.set(dddwl,{force3D:"auto",transformOrigin:"50% 50%",zIndex:5});					
				punchgs.TweenLite.set(opt.ul,{transformStyle:"preserve-3d",transformPerspective:1600});					
			}
		}

		opt.li.each(function() {
			setDDDInContainer(jQuery(this));						
		});

		if ((_.type=="3D" || _.type=="3d") && opt.c.find('.tp-static-layers').length>0) {
			punchgs.TweenLite.set(opt.c.find('.tp-static-layers'),{top:0, left:0,width:"100%",height:"100%"});
			setDDDInContainer(opt.c.find('.tp-static-layers'));
		}
		_.pcontainers = new Array();
		_.pcontainer_depths = new Array();
		_.bgcontainers = new Array();
		_.bgcontainer_depths = new Array();

		opt.c.find('.tp-revslider-slidesli .slotholder, .tp-revslider-slidesli .rs-background-video-layer').each(function() {
			var t = jQuery(this),
				l = t.data('bgparallax') || opt.parallax.bgparallax;		
			l = l == "on" ? 1 : l;				
			if (l!==undefined && l!=="off") {									
				_.bgcontainers.push(t);
				_.bgcontainer_depths.push(opt.parallax.levels[parseInt(l,0)-1]/100);
			}
		})

		

		for (var i = 1; i<=_.levels.length;i++)				
			opt.c.find('.rs-parallaxlevel-'+i).each(function() {					
				var pw = jQuery(this),
					tpw = pw.closest('.tp-parallax-wrap');												
				
				tpw.data('parallaxlevel',_.levels[i-1])
				tpw.addClass("tp-parallax-container");
				_.pcontainers.push(tpw);
				_.pcontainer_depths.push(_.levels[i-1]);
			});		

		
		if (_.type=="mouse" || _.type=="scroll+mouse" || _.type=="mouse+scroll" || _.type=="3D" || _.type=="3d") {
		
			container.mouseenter(function(event) {
				var currslide = container.find('.active-revslide'),
					t = container.offset().top,
					l = container.offset().left,
					ex = (event.pageX-l),
					ey =  (event.pageY-t);
				currslide.data("enterx",ex);
				currslide.data("entery",ey);
			});

			container.on('mousemove.hoverdir, mouseleave.hoverdir, trigger3dpath',function(event,data) {				
				var currslide = data && data.li ? data.li : container.find('.active-revslide');

				
				// CALCULATE DISTANCES
				if (_.origo=="enterpoint") {
					var	t = container.offset().top,
						l = container.offset().left;

					if (currslide.data("enterx")==undefined) currslide.data("enterx",(event.pageX-l));
					if (currslide.data("entery")==undefined) currslide.data("entery",(event.pageY-t));										

					var mh = currslide.data("enterx") || (event.pageX-l),
						mv = currslide.data("entery") || (event.pageY-t),
						diffh = (mh - (event.pageX - l)),
						diffv = (mv - (event.pageY - t)),
						s = _.speed/1000 || 0.4;
				} else {
					var	t = container.offset().top,
						l = container.offset().left,
						diffh = (opt.conw/2 - (event.pageX-l)),
						diffv = (opt.conh/2 - (event.pageY-t)),
						s = _.speed/1000 || 3;
				}
				

				if (event.type=="mouseleave") {
					diffh = _.ddd_lasth || 0;
					diffv = _.ddd_lastv || 0;
					s = 1.5;									
				}

				
				for (var i=0;i<_.pcontainers.length;i++) {				
					var pc = _.pcontainers[i],
						bl = _.pcontainer_depths[i],
						pl = _.type=="3D" || _.type=="3d" ? bl/200 : bl/100,
						offsh =	 diffh * pl,
						offsv =	 diffv * pl;		
						if (_.type=="scroll+mouse" || _.type=="mouse+scroll" ) 
							punchgs.TweenLite.to(pc,s,{force3D:"auto",x:offsh,ease:punchgs.Power3.easeOut,overwrite:"all"});
						else
							punchgs.TweenLite.to(pc,s,{force3D:"auto",x:offsh,y:offsv,ease:punchgs.Power3.easeOut,overwrite:"all"});
				};

				if (_.type=="3D" || _.type=="3d") {
					var sctor = '.tp-revslider-slidesli .dddwrapper, .dddwrappershadow, .tp-revslider-slidesli .dddwrapper-layer, .tp-static-layers .dddwrapper-layer';
					if (opt.sliderType==="carousel") sctor = ".tp-revslider-slidesli .dddwrapper, .tp-revslider-slidesli .dddwrapper-layer, .tp-static-layers .dddwrapper-layer";
					opt.c.find(sctor).each(function() {										
						var t = jQuery(this),
							pl = _.levels[_.levels.length-1]/200,										
							offsh =	diffh * pl,
							offsv =	diffv * pl,
							offrv = opt.conw == 0 ? 0 :  Math.round((diffh / opt.conw * pl)*100) || 0,
							offrh = opt.conh == 0 ? 0 : Math.round((diffv / opt.conh * pl)*100) || 0,										
							li = t.closest('li'),
							zz = 0,
							itslayer = false;

							if (t.hasClass("dddwrapper-layer")) {
								zz = _.ddd_z_correction || 65;
								itslayer = true;
							}

						if (t.hasClass("dddwrapper-layer")) {
							offsh=0;
							offsv=0;
						}
												
						if (li.hasClass("active-revslide") || opt.sliderType!="carousel")
							if (_.ddd_bgfreeze!="on" || (itslayer))								
								punchgs.TweenLite.to(t,s,{rotationX:offrh, rotationY:-offrv, x:offsh, z:zz,y:offsv,ease:punchgs.Power3.easeOut,overwrite:"all"});								  	
							else 								
								punchgs.TweenLite.to(t,0.5,{force3D:"auto",rotationY:0, rotationX:0, z:0,ease:punchgs.Power3.easeOut,overwrite:"all"});
						else 
							punchgs.TweenLite.to(t,0.5,{force3D:"auto",rotationY:0,x:0,y:0, rotationX:0, z:0,ease:punchgs.Power3.easeOut,overwrite:"all"});
																	
						if (event.type=="mouseleave")
						 	punchgs.TweenLite.to(jQuery(this),3.8,{z:0, ease:punchgs.Power3.easeOut});
					});
				}					
			});

			if (_ISM)
				window.ondeviceorientation = function(event) {
					var y = Math.round(event.beta  || 0)-70,
						x = Math.round(event.gamma || 0);

					var currslide = container.find('.active-revslide');

					if (jQuery(window).width() > jQuery(window).height()){
							var xx = x;
							x = y;
							y = xx;
					}

					var cw = container.width(),
						ch = container.height(),
						diffh = (360/cw * x),
				  		diffv = (180/ch * y),
				  		s = _.speed/1000 || 3,				  	
				  		pcnts = [];
					
					currslide.find(".tp-parallax-container").each(function(i){					
						pcnts.push(jQuery(this));
					});
					container.find('.tp-static-layers .tp-parallax-container').each(function(){
						pcnts.push(jQuery(this));
					});

				  	jQuery.each(pcnts, function() {
						var pc = jQuery(this),
							bl = parseInt(pc.data('parallaxlevel'),0),
							pl = bl/100,
							offsh =	 diffh * pl*2,
							offsv =	 diffv * pl*4;									
							punchgs.TweenLite.to(pc,s,{force3D:"auto",x:offsh,y:offsv,ease:punchgs.Power3.easeOut,overwrite:"all"});	
					});
					
					if (_.type=="3D" || _.type=="3d") {
						var sctor = '.tp-revslider-slidesli .dddwrapper, .dddwrappershadow, .tp-revslider-slidesli .dddwrapper-layer, .tp-static-layers .dddwrapper-layer';
						if (opt.sliderType==="carousel") sctor = ".tp-revslider-slidesli .dddwrapper, .tp-revslider-slidesli .dddwrapper-layer, .tp-static-layers .dddwrapper-layer";
						opt.c.find(sctor).each(function() {			
							var t = jQuery(this),
								pl = _.levels[_.levels.length-1]/200,
								offsh =	diffh * pl,
								offsv =	diffv * pl*3,
								offrv = opt.conw == 0 ? 0 :  Math.round((diffh / opt.conw * pl)*500) || 0,
								offrh = opt.conh == 0 ? 0 : Math.round((diffv / opt.conh * pl)*700) || 0,
								li = t.closest('li'),
								zz = 0,
								itslayer = false;

							if (t.hasClass("dddwrapper-layer")) {
								zz = _.ddd_z_correction || 65;
								itslayer = true;
							}

							if (t.hasClass("dddwrapper-layer")) {
								offsh=0;
								offsv=0;
							}
												
							if (li.hasClass("active-revslide") || opt.sliderType!="carousel")
								if (_.ddd_bgfreeze!="on" || (itslayer))								
									punchgs.TweenLite.to(t,s,{rotationX:offrh, rotationY:-offrv, x:offsh, z:zz,y:offsv,ease:punchgs.Power3.easeOut,overwrite:"all"});								  	
								else 								
									punchgs.TweenLite.to(t,0.5,{force3D:"auto",rotationY:0, rotationX:0, z:0,ease:punchgs.Power3.easeOut,overwrite:"all"});
							else 
								punchgs.TweenLite.to(t,0.5,{force3D:"auto",rotationY:0,z:0,x:0,y:0, rotationX:0, ease:punchgs.Power3.easeOut,overwrite:"all"});
																	
							if (event.type=="mouseleave")
							 	punchgs.TweenLite.to(jQuery(this),3.8,{z:0, ease:punchgs.Power3.easeOut});
						});
					}
				}			 
		}
				
		_R.scrollTicker(opt,container);
		

	},
	
	scrollTicker : function(opt,container) {
		var faut;

		if (opt.scrollTicker!=true) {
			opt.scrollTicker = true;		
			if (_ISM) {		
				punchgs.TweenLite.ticker.fps(150);
				punchgs.TweenLite.ticker.addEventListener("tick",function() {_R.scrollHandling(opt);},container,false,1);
			} else {				
				document.addEventListener('scroll',function(e) {						
					_R.scrollHandling(opt,true);											
				}, {passive:true});

				/*window.addEventListener('mousewheel',function(e) {
					_R.scrollHandling(opt,true);
				}, {passive:true});

				window.addEventListener('DOMMouseScroll',function() {_R.scrollHandling(opt,true);}, {passive:true});*/
			}		
				
		}		
		_R.scrollHandling(opt, true);
	},



	//	-	SET POST OF SCROLL PARALLAX	-
	scrollHandling : function(opt,fromMouse) {	
		opt.lastwindowheight = opt.lastwindowheight || window.innerHeight;
		opt.conh = opt.conh===0 || opt.conh===undefined ? opt.infullscreenmode ? opt.minHeight : opt.c.height() : opt.conh;
		if (opt.lastscrolltop==window.scrollY && !opt.duringslidechange && !fromMouse) return false;		
		punchgs.TweenLite.delayedCall(0.2,saveLastScroll,[opt,window.scrollY]);

		var b = opt.c[0].getBoundingClientRect(),
			_v = opt.viewPort,
			_ = opt.parallax;
		
		var proc = b.top<0 || b.height>opt.lastwindowheight ? b.top / b.height : b.bottom>opt.lastwindowheight ? (b.bottom-opt.lastwindowheight) / b.height : 0;
		opt.scrollproc = proc;

		if (_R.callBackHandling)
			_R.callBackHandling(opt,"parallax","start");

		if (_v.enable) {
			var area = 1-Math.abs(proc);
			area = area<0 ? 0 : area;
			// To Make sure it is not any more in %			
			if (!jQuery.isNumeric(_v.visible_area))
			 if (_v.visible_area.indexOf('%')!==-1) 
				_v.visible_area = parseInt(_v.visible_area)/100;
			
		 	if (1-_v.visible_area<=area) {
				if (!opt.inviewport) {
					opt.inviewport = true;
					_R.enterInViewPort(opt);
				}
			} else {
				if (opt.inviewport) {
					opt.inviewport = false;
					_R.leaveViewPort(opt);
				}
			}
		}
			
		// SCROLL BASED PARALLAX EFFECT 
		if (_ISM && _.disable_onmobile=="on") return false;

		if (_.type!="3d" && _.type!="3D") {
			if (_.type=="scroll" || _.type=="scroll+mouse" || _.type=="mouse+scroll") 		
				if (_.pcontainers) 		
					for (var i=0;i<_.pcontainers.length;i++) {
						if (_.pcontainers[i].length>0) {
							var pc = _.pcontainers[i],
								pl = _.pcontainer_depths[i]/100,						
								offsv = Math.round((proc * -(pl*opt.conh)*10))/10 || 0;										
							pc.data('parallaxoffset',offsv);		
							punchgs.TweenLite.set(pc,{overwrite:"auto",force3D:"auto",y:offsv})
						}
					}									
			if (_.bgcontainers)
				for (var i=0;i<_.bgcontainers.length;i++) {
					var t = _.bgcontainers[i],
						l = _.bgcontainer_depths[i],			
						offsv =	proc * -(l*opt.conh) || 0;							
					punchgs.TweenLite.set(t,{position:"absolute",top:"0px",left:"0px",backfaceVisibility:"hidden",force3D:"true",y:offsv+"px"});
					
				}			
		}
		
		if (_R.callBackHandling)
			_R.callBackHandling(opt,"parallax","end");		
		
	}
		
});

function saveLastScroll(opt,st) { opt.lastscrolltop = st;}


//// END OF PARALLAX EFFECT	
})(jQuery);