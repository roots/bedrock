/************************************************
 * REVOLUTION 5.3 EXTENSION - LAYER ANIMATION
 * @version: 3.0.6 (25.10.2016)
 * @requires jquery.themepunch.revolution.js
 * @author ThemePunch
************************************************/
(function($) {
	"use strict";

var _R = jQuery.fn.revolution,
	_ISM = _R.is_mobile(),
	extension = {	alias:"LayerAnimation Min JS",
					name:"revolution.extensions.layeranimation.min.js",
					min_core: "5.3.0",
					version:"3.0.6"
			  };
	

///////////////////////////////////////////
// 	EXTENDED FUNCTIONS AVAILABLE GLOBAL  //
///////////////////////////////////////////
jQuery.extend(true,_R, {

	updateMarkup : function(layer,o) {		
				
		var d = jQuery(layer).data();
		if (d.start!==undefined && !d.frames_added && d.frames===undefined) {			
			var frames = new Array(),			
				oin = getAnimDatas(newAnimObject(),d.transform_in,undefined, false),
				oout = getAnimDatas(newAnimObject(),d.transform_out,undefined, false),
				oh =  getAnimDatas(newAnimObject(),d.transform_hover,undefined, false);
				
				if (jQuery.isNumeric(d.end) && jQuery.isNumeric(d.start) && jQuery.isNumeric(oin.speed)) {					
					d.end = (parseInt(d.end,0) - (parseInt(d.start,0)+parseFloat(oin.speed,0)));					
				}
			
			frames.push({frame:"0", delay:d.start, from:d.transform_in, to:d.transform_idle, split:d.splitin, speed:oin.speed, ease:oin.anim.ease, mask:d.mask_in, splitdelay:d.elementdelay});						 
			frames.push({frame:"5", delay:d.end, to:d.transform_out, split:d.splitout, speed:oout.speed, ease:oout.anim.ease, mask:d.mask_out, splitdelay:d.elementdelay});
			if (d.transform_hover) 
				frames.push({frame:"hover", to:d.transform_hover, style:d.style_hover,  speed:oh.speed, ease:oh.anim.ease,  splitdelay:d.elementdelay});
			d.frames = frames;
			//layer.frames_added = true;					
		} 
 
		if (!d.frames_added) {
			d.inframeindex = 0;
			d.outframeindex = -1;
			d.hoverframeindex = -1;			
			for (var i=0;i<d.frames.length;i++) {
				if (d.frames[0].from===undefined) d.frames[0].from = "o:inherit";
				
				if (d.frames[0].delay===0) d.frames[0].delay=20;
								
				if (d.frames[i].frame==="hover") 
					d.hoverframeindex =  i;
				else
				if (d.frames[i].frame==="frame_999" || d.frames[i].frame==="frame_out" || d.frames[i].frame==="last" || d.frames[i].frame==="end") 
					d.outframeindex = i;
				
				if (d.frames[i].split!==undefined && d.frames[i].split.match(/chars|words|lines/g)) 
					d.splittext = true;				
			}		
			d.outframeindex  = d.outframeindex===-1 ? d.hoverframeindex === -1 ? d.frames.length-1 : d.frames.length -2 : d.outframeindex; // CHECK LATER !!!
			d.frames_added = true;
								
		}						
	},

	// MAKE SURE THE ANIMATION ENDS WITH A CLEANING ON MOZ TRANSFORMS
 	animcompleted : function(_nc,opt) {		
 		
		var _ = _nc.data(),
			t = _.videotype,
			ap = _.autoplay,
			an = _.autoplayonlyfirsttime;

		
		if (t!=undefined && t!="none")
		 if (ap==true || ap=="true" || ap=="on" ||  ap=="1sttime" || an) {	

			_R.playVideo(_nc,opt);	

			_R.toggleState(_nc.data('videotoggledby'));
			if ( an || ap=="1sttime") {
				_.autoplayonlyfirsttime = false;
				_.autoplay = "off";
			}
		  }	else {
			  if (ap=="no1sttime") 
				_.datasetautoplay = 'on';
			  _R.unToggleState(_nc.data('videotoggledby'));
		  }

	},

	/********************************************************
		-	PREPARE AND DEFINE STATIC LAYER DIRECTIONS -
	*********************************************************/
	handleStaticLayers : function(_nc,opt) {
		
		var s = parseInt(_nc.data('startslide'),0),
			e = parseInt(_nc.data('endslide'),0);
		if (s < 0)
			s=0;
		if (e <0 )
			e = opt.slideamount;
		if (s===0 && e===opt.slideamount-1)
			e = opt.slideamount+1;
		_nc.data('startslide',s);
		_nc.data('endslide',e);		
	},

	/************************************ 
		ANIMATE ALL CAPTIONS 
	*************************************/	
	animateTheCaptions : function(obj)  {		

		if (_R.compare_version(extension).check==="stop") return false;

		var opt = obj.opt,
			nextli = obj.slide,
			recall = obj.recall,
			mtl = obj.maintimeline,
			preset = obj.preset,
			startSlideAnimAt = obj.startslideanimat,
			base_offsetx = opt.sliderType==="carousel" ? 0 : opt.width/2 - (opt.gridwidth[opt.curWinRange]*opt.bw)/2,
			base_offsety=0,
			index = nextli.data('index');

		// COLLECTION OF LAYERS
		opt.layers = opt.layers || new Object();		
		opt.layers[index] = opt.layers[index] || nextli.find('.tp-caption');
		opt.layers["static"] = opt.layers["static"] || opt.c.find('.tp-static-layers').find('.tp-caption');

		if (opt.timelines === undefined) _R.createTimelineStructure(opt);
		
		opt.conh = opt.c.height();
		opt.conw = opt.c.width();
		opt.ulw = opt.ul.width();
		opt.ulh = opt.ul.height();

		/* ENABLE DEBUG MODE */
		if (opt.debugMode) {
			nextli.addClass("indebugmode");
			nextli.find('.helpgrid').remove();	
			opt.c.find('.hglayerinfo').remove();	
			nextli.append('<div class="helpgrid" style="width:'+(opt.gridwidth[opt.curWinRange]*opt.bw)+'px;height:'+(opt.gridheight[opt.curWinRange]*opt.bw)+'px;"></div>');
			var hg = nextli.find('.helpgrid');
			hg.append('<div class="hginfo">Zoom:'+(Math.round(opt.bw*100))+'% &nbsp;&nbsp;&nbsp; Device Level:'+opt.curWinRange+'&nbsp;&nbsp;&nbsp; Grid Preset:'+opt.gridwidth[opt.curWinRange]+'x'+opt.gridheight[opt.curWinRange]+'</div>')
			opt.c.append('<div class="hglayerinfo"></div>')
			hg.append('<div class="tlhg"></div>');
		}
		
		// PREPARE THE LAYERS
		if (opt.layers[index])
			jQuery.each(opt.layers[index], function(i,a) { 
				_R.updateMarkup(this,opt);
				_R.prepareSingleCaption({caption:jQuery(this), opt:opt, offsetx:base_offsetx, offsety:base_offsety, index:i, recall:recall,  preset:preset});	
				if (!preset || startSlideAnimAt===0) _R.buildFullTimeLine({caption:jQuery(this), opt:opt, offsetx:base_offsetx, offsety:base_offsety, index:i, recall:recall,  preset:preset, regenerate: startSlideAnimAt===0});
			});
		
		if (opt.layers["static"])
			jQuery.each(opt.layers["static"], function(i,a) { 
				_R.updateMarkup(this,opt);
				_R.prepareSingleCaption({caption:jQuery(this), opt:opt, offsetx:base_offsetx, offsety:base_offsety, index:i, recall:recall,  preset:preset});
				if (!preset || startSlideAnimAt===0)  _R.buildFullTimeLine({caption:jQuery(this), opt:opt, offsetx:base_offsetx, offsety:base_offsety, index:i, recall:recall,  preset:preset, regenerate: startSlideAnimAt===0});
		});

		
		// RECALCULATE HEIGHTS OF SLIDE IF ROW EXIST
		var _actli = opt.nextSlide === -1 || opt.nextSlide===undefined ? 0 : opt.nextSlide;
		_actli = _actli>opt.rowzones.length ? opt.rowzones.length : _actli;	
		if (opt.rowzones!=undefined && opt.rowzones.length>0 && opt.rowzones[_actli]!=undefined && _actli>=0 && _actli<=opt.rowzones.length && opt.rowzones[_actli].length>0) 			
			_R.setSize(opt);
		
		
		// RESTART ANIMATION TIMELINES
		
		if (!preset) 
			if (startSlideAnimAt!==undefined) {		
				jQuery.each(opt.timelines[index].layers,function(key,o) {	
					var _ = o.layer.data();
					if (o.wrapper==="none" || o.wrapper===undefined) {												
						if (o.triggerstate=="keep" && _.triggerstate==="on")
							_R.playAnimationFrame({caption:o.layer,opt:opt,frame:"frame_0", triggerdirection:"in", triggerframein:"frame_0", triggerframeout:"frame_999"});							
						else 
							o.timeline.restart(0);						
					}															
				});
				if (opt.timelines.staticlayers) 				
					jQuery.each(opt.timelines.staticlayers.layers,function(key,o) {					
						
						var _ = o.layer.data(),
							in_v_range  = _actli>=o.firstslide && _actli<=o.lastslide,
							in_uv_range = _actli<o.firstslide || _actli>o.lastslide,
							flt = o.timeline.getLabelTime("slide_"+o.firstslide),
							elt = o.timeline.getLabelTime("slide_"+o.lastslide),
							ct = _.static_layer_timeline_time,
							isvisible = _.animdirection==="in" ? true : _.animdirection==="out" ? false : undefined,
							triggered_in = _.frames[0].delay==="bytrigger",
							triggered_out = _.frames[_.frames.length-1].delay==="bytrigger",
							layer_start_status = _.triggered_startstatus,
							triggerstate = _.lasttriggerstate;
												
						if (ct!==undefined && isvisible) {							
							if (triggerstate=="keep") {								
								_R.playAnimationFrame({caption:o.layer,opt:opt,frame:"frame_0", triggerdirection:"in", triggerframein:"frame_0", triggerframeout:"frame_999"});
								_.triggeredtimeline.time(ct);
							}
							else {
								o.timeline.time(ct);
							}
						}
							

						// RESET STATUS ALWAYS TO HIDDEN
						if (triggerstate==="reset" && layer_start_status==="hidden") {							
							o.timeline.time(0);
							_.animdirection = "out";
						}
						
						// NEED TO DO SOMETHING
						if (in_v_range) {								
							if (isvisible) {	
								if (_actli===o.lastslide) {								
									o.timeline.play(elt);
									_.animdirection = "in";
								}
							} else {											
								if (!triggered_in && _.animdirection!=="out") {																		
									o.timeline.play(flt);
								}
								if ((layer_start_status=="visible" && triggerstate!=="keep") || (triggerstate==="keep" &&  isvisible===true) || (layer_start_status=="visible" &&  isvisible===undefined)) {
									o.timeline.play(flt+0.01);
									_.animdirection = "in";									
								}
							}
						} else 

						if (in_uv_range) {							
							if (isvisible) {
								o.timeline.play("frame_999");
							} else {

							}
						}
						
					});		
				
			} 
				
		
		
		// RESUME THE MAIN TIMELINE NOW
		if (mtl != undefined) setTimeout(function() {
			mtl.resume();
		},30);

		
		

	},

	

	/******************************************** 
		PREPARE ALL LAYER SIZES, POSITION
	********************************************/	
	prepareSingleCaption : function(obj) {

		var _nc = obj.caption,
			_ = _nc.data(),
			opt = obj.opt,								
			recall = obj.recall,
			internrecall = obj.recall,						
			preset = obj.preset,
			rtl = jQuery('body').hasClass("rtl"),
			datas

		_._pw = _._pw===undefined ? _nc.closest('.tp-parallax-wrap') : _._pw;
		_._lw = _._lw===undefined ? _nc.closest('.tp-loop-wrap') : _._lw;
		_._mw = _._mw===undefined ? _nc.closest('.tp-mask-wrap') : _._mw;
			
		_._responsive  = _.responsive || "on";
		_._respoffset  = _.responsive_offset || "on";
		_._ba = _.basealign || "grid";
		_._gw = _._ba==="grid" ? opt.width : opt.ulw;
		_._gh = _._ba==="grid" ? opt.height : opt.ulh; 
		
		_._lig = _._lig===undefined ? _nc.hasClass("rev_layer_in_group") ? _nc.closest('.rev_group') : _nc.hasClass("rev_layer_in_column") ?_nc.closest('.rev_column_inner')  : _nc.hasClass("rev_column_inner") ?  _nc.closest(".rev_row") : "none" :  _._lig,			
		
		_._nctype = _.type || "none";
		_._cbgc_auto = _._cbgc_auto===undefined ? _._nctype==="column" ?  _._pw.find('.rev_column_bg_auto_sized') : false : _._cbgc_auto;
		_._cbgc_man = _._cbgc_man===undefined ? _._nctype==="column" ? _._pw.find('.rev_column_bg_man_sized') : false : _._cbgc_man;
		_._slideid = _._slideid || _nc.closest('.tp-revslider-slidesli').data('index');
		_._id = _._id===undefined ? _nc.data('id') || _nc.attr('id') : _._id;
		_._slidelink = _._slidelink || _nc.hasClass("slidelink");

		if (_._li===undefined) 
			if (_nc.hasClass("tp-static-layer")) {
				_._li = _nc.closest('.tp-static-layers');
				_._slideid = "staticlayers";
			} else {
				_._li = _nc.closest('.tp-revslider-slidesli');
			}

		_._row = _._row===undefined ? _._nctype==="column" ? _._pw.closest('.rev_row') : false : _._row;
						
		if (_._togglelisteners===undefined && _nc.find('.rs-toggled-content')) {			
			_._togglelisteners = true;
		} else {
			_._togglelisteners = false;
		}

		if (opt.sliderLayout=="fullscreen") 
			obj.offsety = _._gh/2 - (opt.gridheight[opt.curWinRange]*opt.bh)/2;

		if (opt.autoHeight=="on" || (opt.minHeight!=undefined && opt.minHeight>0))
			  obj.offsety = opt.conh/2 - (opt.gridheight[opt.curWinRange]*opt.bh)/2;;

		if (obj.offsety<0) obj.offsety=0;
		
		// LAYER GRID FOR DEBUGGING
		if (opt.debugMode) {
			_nc.closest('li').find('.helpgrid').css({top:obj.offsety+"px", left:obj.offsetx+"px"}); 
			var linfo = opt.c.find('.hglayerinfo');
			_nc.on("hover, mouseenter",function() {
				var ltxt = "",
					spa = 0;
				if (_nc.data())
					jQuery.each(_nc.data(),function(key,val) {
						if (typeof val !== "object") {
								
								ltxt = ltxt + '<span style="white-space:nowrap"><span style="color:#27ae60">'+key+":</span>"+val+"</span>&nbsp; &nbsp; ";
							
						}
					});
				linfo.html(ltxt);
			});
		}
		/* END OF DEBUGGING */

		var handlecaption=0,
			layervisible =  _.visibility === undefined ? "oon" : makeArray(_.visibility,opt)[opt.forcedWinRange] || makeArray(_.visibility,opt) || "ooon";
		
		// HIDE CAPTION IF RESOLUTION IS TOO LOW			
		if (layervisible==="off" || (_._gw<opt.hideCaptionAtLimit && _.captionhidden=="on") || (_._gw<opt.hideAllCaptionAtLimit)) 
			_._pw.addClass("tp-hidden-caption");											
		else
			_._pw.removeClass("tp-hidden-caption")

		_.layertype = "html";
		

		if (obj.offsetx<0) obj.offsetx=0;

		// FALL BACK TO NORMAL IMAGES
		if (_.thumbimage !=undefined && _.videoposter==undefined)
				_.videoposter = _.thumbimage;
																				
		// IF IT IS AN IMAGE
		if (_nc.find('img').length>0) {
			var im = _nc.find('img');
			_.layertype = "image";
			if (im.width()==0) im.css({width:"auto"});
			if (im.height()==0) im.css({height:"auto"});			
			if (im.data('ww') == undefined && im.width()>0) im.data('ww',im.width());
			if (im.data('hh') == undefined && im.height()>0) im.data('hh',im.height());

			var ww = im.data('ww'),
				hh = im.data('hh'),
				fuw = _._ba =="slide" ? opt.ulw : opt.gridwidth[opt.curWinRange],
				fuh = _._ba =="slide" ? opt.ulh : opt.gridheight[opt.curWinRange];
			
			ww =  makeArray(im.data('ww'),opt)[opt.curWinRange] || makeArray(im.data('ww'),opt) || "auto",
			hh =  makeArray(im.data('hh'),opt)[opt.curWinRange] || makeArray(im.data('hh'),opt) || "auto";
			
			var wful = ww==="full" || ww === "full-proportional",
				hful = hh==="full" || hh === "full-proportional";

			if (ww==="full-proportional") {
				var ow = im.data('owidth'),
					oh = im.data('oheight');				
				if (ow/fuw < oh/fuh) {
					ww = fuw;
					hh = oh*(fuw/ow);
				} else {
					hh = fuh;
					ww = ow*(fuh/oh);
				}				
			} else {				
				
				ww = wful ? fuw : !jQuery.isNumeric(ww) && ww.indexOf("%")>0 ? ww : parseFloat(ww);
				hh = hful ? fuh : !jQuery.isNumeric(hh) && hh.indexOf("%")>0 ? hh : parseFloat(hh);	
			}
									
			ww = ww===undefined ? 0 : ww;
			hh = hh===undefined ? 0 : hh;
			
			if (_._responsive!=="off") {							
				if (_._ba!="grid" && wful) 
					if (jQuery.isNumeric(ww))
						im.css({width:ww+"px"});
					else
						im.css({width:ww});					
				else 
					if (jQuery.isNumeric(ww))
						im.css({width:(ww*opt.bw)+"px"});
					else
						im.css({width:ww});
				
				if (_._ba!="grid" && hful) 
					if (jQuery.isNumeric(hh))
						im.css({height:hh+"px"});
					else					
						im.css({height:hh});
					
				else
					if (jQuery.isNumeric(hh))
						im.css({height:(hh*opt.bh)+"px"});				
					else
						im.css({height:hh});				
				
			} else {
				im.css({width:ww, height:hh});				
					
			}
			
		} 

		if (_._ba==="slide") {
			obj.offsetx = 0;
			obj.offsety=0;
		}

		var tag = _.audio=="html5" ? "audio" : "video";

		// IF IT IS A VIDEO LAYER
		if (_nc.hasClass("tp-videolayer") || _nc.hasClass("tp-audiolayer") || _nc.find('iframe').length>0 || _nc.find(tag).length>0) {

			_.layertype = "video";
			if (_R.manageVideoLayer) _R.manageVideoLayer(_nc,opt,recall,internrecall);				
			if (!recall && !internrecall) {
				var t = _.videotype;
				if (_R.resetVideo) _R.resetVideo(_nc,opt);					
			}
			
			var asprat = _.aspectratio;
			if (asprat!=undefined && asprat.split(":").length>1) 			
				_R.prepareCoveredVideo(asprat,opt,_nc);

			var im = _nc.find('iframe') ? _nc.find('iframe') : im = _nc.find(tag),
				html5vid = _nc.find('iframe') ? false : true,				
				yvcover = _nc.hasClass('coverscreenvideo');
									
			im.css({display:"block"});

			// SET WIDTH / HEIGHT 
			if (_nc.data('videowidth') == undefined) {
					_nc.data('videowidth',im.width());
					_nc.data('videoheight',im.height());
			}
			var ww =  makeArray(_nc.data('videowidth'),opt)[opt.curWinRange] || makeArray(_nc.data('videowidth'),opt) || "auto",
				hh =  makeArray(_nc.data('videoheight'),opt)[opt.curWinRange] || makeArray(_nc.data('videoheight'),opt) || "auto";
				
			if (!jQuery.isNumeric(ww) && ww.indexOf("%")>0) {
				hh = (parseFloat(hh)*opt.bh)+"px";
			} else {
				ww = (parseFloat(ww)*opt.bw)+"px";
				hh = (parseFloat(hh)*opt.bh)+"px";
			}
									
			// READ AND WRITE CSS SETTINGS OF IFRAME AND VIDEO FOR RESIZING ELEMENST ON DEMAND			
			_.cssobj = _.cssobj===undefined ? getcssParams(_nc,0) : _.cssobj;
			 

			var ncobj = setResponsiveCSSValues(_.cssobj,opt);

									
			// IE8 FIX FOR AUTO LINEHEIGHT
			if (ncobj.lineHeight=="auto") ncobj.lineHeight = ncobj.fontSize+4;
						

			if (!_nc.hasClass('fullscreenvideo') && !yvcover) {
				
				punchgs.TweenLite.set(_nc,{							 						 
					 paddingTop: Math.round((ncobj.paddingTop * opt.bh)) + "px",
					 paddingBottom: Math.round((ncobj.paddingBottom * opt.bh)) + "px",
					 paddingLeft: Math.round((ncobj.paddingLeft* opt.bw)) + "px",
					 paddingRight: Math.round((ncobj.paddingRight * opt.bw)) + "px",
					 marginTop: (ncobj.marginTop * opt.bh) + "px",
					 marginBottom: (ncobj.marginBottom * opt.bh) + "px",
					 marginLeft: (ncobj.marginLeft * opt.bw) + "px",
					 marginRight: (ncobj.marginRight * opt.bw) + "px",
					 borderTopWidth: Math.round(ncobj.borderTopWidth * opt.bh) + "px",
					 borderBottomWidth: Math.round(ncobj.borderBottomWidth * opt.bh) + "px",
					 borderLeftWidth: Math.round(ncobj.borderLeftWidth * opt.bw) + "px",
					 borderRightWidth: Math.round(ncobj.borderRightWidth * opt.bw) + "px",	
					 width:ww,						 
					 height:hh
				});
			} else  {
			   obj.offsetx=0; obj.offsety=0;			   
			   _nc.data('x',0)
			   _nc.data('y',0)

			   var ovhh = _._gh;
			   if (opt.autoHeight=="on") ovhh = opt.conh
			   _nc.css({'width':_._gw, 'height':ovhh });			
			}
						
			if ((html5vid == false && !yvcover) || ((_.forcecover!=1 && !_nc.hasClass('fullscreenvideo') && !yvcover))) {

				im.width(ww);
				im.height(hh);
			}					
		}	// END OF POSITION AND STYLE READ OUTS OF VIDEO
	
		// RESPONIVE HANDLING OF CURRENT LAYER		
		calcCaptionResponsive(_nc,opt,0,_._responsive);

		
		// ALL ELEMENTS IF THE MAIN ELEMENT IS REKURSIVE RESPONSIVE SHOULD BE REPONSIVE HANDLED
		if (_nc.hasClass("tp-resizeme")) 		
			_nc.find('*').each(function() {
				calcCaptionResponsive(jQuery(this),opt,"rekursive",_._responsive);
			});									
		
		// _nc FRONTCORNER CHANGES
		var ncch = _nc.outerHeight(),
			bgcol = _nc.css('backgroundColor');
		sharpCorners(_nc,'.frontcorner','left','borderRight','borderTopColor',ncch,bgcol);
		sharpCorners(_nc,'.frontcornertop','left','borderRight','borderBottomColor',ncch,bgcol);
		sharpCorners(_nc,'.backcorner','right','borderLeft','borderBottomColor',ncch,bgcol);
		sharpCorners(_nc,'.backcornertop','right','borderLeft','borderTopColor',ncch,bgcol);


		if (opt.fullScreenAlignForce == "on") {
			obj.offsetx=0;
			obj.offsety=0;
		}
			
			
		_.arrobj = new Object();
		_.arrobj.voa = makeArray(_.voffset,opt)[opt.curWinRange] || makeArray(_.voffset,opt)[0];
		_.arrobj.hoa = makeArray(_.hoffset,opt)[opt.curWinRange] || makeArray(_.hoffset,opt)[0];
		_.arrobj.elx = makeArray(_.x,opt)[opt.curWinRange] || makeArray(_.x,opt)[0];
		_.arrobj.ely = makeArray(_.y,opt)[opt.curWinRange] || makeArray(_.y,opt)[0];					
	
								
		var voa = _.arrobj.voa.length==0 ? 0 : _.arrobj.voa,
			hoa = _.arrobj.hoa.length==0 ? 0 : _.arrobj.hoa,
			elx = _.arrobj.elx.length==0 ? 0 : _.arrobj.elx,
			ely = _.arrobj.ely.length==0 ? 0 : _.arrobj.ely;
		
		_.eow = _nc.outerWidth(true);
		_.eoh = _nc.outerHeight(true);

		
		
		// NEED CLASS FOR FULLWIDTH AND FULLHEIGHT LAYER SETTING !!
		if (_.eow==0 && _.eoh==0) {
			_.eow = opt.ulw;
			_.eoh = opt.ulh;
		}

		
		var vofs= _._respoffset !=="off" ? parseInt(voa,0)*opt.bw : parseInt(voa,0),			
			hofs= _._respoffset !=="off" ? parseInt(hoa,0)*opt.bw : parseInt(hoa,0),
			crw = _._ba==="grid" ? opt.gridwidth[opt.curWinRange]*opt.bw : _._gw,
			crh = _._ba==="grid" ? opt.gridheight[opt.curWinRange]*opt.bw : _._gh;

					
		if (opt.fullScreenAlignForce == "on") {
			crw = opt.ulw;
			crh = opt.ulh;
		}
		
		// ALIGN POSITIONED ELEMENTS			
		if (_._lig!=="none" && _._lig!=undefined) {			
			crw=_._lig.width(); 
			crh=_._lig.height();
			obj.offsetx =0;
			obj.offsety = 0;			
		}

		
		
		elx = elx==="center" || elx==="middle" ? (crw/2 - _.eow/2) +  hofs : elx==="left" ? hofs : elx==="right" ? (crw - _.eow) - hofs : _._respoffset !=="off"  ? elx * opt.bw : elx;
		ely = ely=="center" || ely=="middle" ? 	(crh/2 - _.eoh/2) + vofs : ely =="top" ? vofs : ely=="bottom" ? (crh - _.eoh)-vofs : _._respoffset !=="off"  ? ely*opt.bw : ely;			
		
		if (rtl && !_.slidelink) 
			elx = elx + _.eow;
	
		if (_.slidelink) elx=0;

		_.calcx = (parseInt(elx,0)+obj.offsetx);
		_.calcy = (parseInt(ely,0)+obj.offsety);

	
		
		var tpcapindex = _nc.css("z-Index");
		
		
		// SET TOP/LEFT POSITION OF LAYER
		if (_._nctype!=="row" && _._nctype!=="column") 			
			punchgs.TweenLite.set(_._pw,{zIndex:tpcapindex, top:_.calcy,left:_.calcx,overwrite:"auto"});		
		else 
		if (_._nctype!=="row")
			punchgs.TweenLite.set(_._pw,{zIndex:tpcapindex, width:_.columnwidth, top:0,left:0,overwrite:"auto"});
		else
		if (_._nctype==="row") {
			var _roww = _._ba==="grid" ? crw+"px" : "100%";
			punchgs.TweenLite.set(_._pw,{zIndex:tpcapindex, width:_roww, top:0,left:obj.offsetx,overwrite:"auto"});
		}
		if (_.blendmode!==undefined)
			punchgs.TweenLite.set(_._pw,{mixBlendMode:_.blendmode});
		
				
		//SET ROW BROKEN / TABLE  FORMED
		if (_._nctype==="row") {
			if (_.columnbreak<=opt.curWinRange) {
				_nc.addClass("rev_break_columns");
			} else {
				_nc.removeClass("rev_break_columns");
			}
		}	

		// LOOP ANIMATION WIDTH/HEIGHT 
		if (_.loopanimation=="on") punchgs.TweenLite.set(_._lw,{minWidth:_.eow,minHeight:_.eoh});

	},


	/******************************************** 
		BUILD THE TIMELINE STRUCTURES
	********************************************/	
	createTimelineStructure : function(opt) {
		
		
		// COLLECTION OF TIMELINES
		opt.timelines = opt.timelines || new Object();				
				
		function addTimeLineWithLabel(layer,opt,parentobject,slideid) {			
			var timeline = new punchgs.TimelineLite({paused:true}),
				c;
				

			parentobject = parentobject || new Object();
			parentobject[layer.attr('id')] = parentobject[layer.attr('id')] || new Object();
			if (slideid==="staticlayers") {
				parentobject[layer.attr('id')].firstslide = layer.data('startslide');
				parentobject[layer.attr('id')].lastslide = layer.data('endslide');				
			}


			layer.data('slideid',slideid);
			parentobject[layer.attr('id')].defclasses=c=layer[0].className;
			parentobject[layer.attr('id')].wrapper = c.indexOf("rev_layer_in_column")>=0 ? layer.closest('.rev_column_inner') : c.indexOf("rev_column_inner")>=0 ? layer.closest(".rev_row") : c.indexOf("rev_layer_in_group")>=0 ? layer.closest(".rev_group") : "none";
			parentobject[layer.attr('id')].timeline = timeline;
			parentobject[layer.attr('id')].layer = layer;
			parentobject[layer.attr('id')].triggerstate = layer.data('lasttriggerstate');
			parentobject[layer.attr('id')].dchildren = c.indexOf("rev_row")>=0 ?  layer[0].getElementsByClassName('rev_column_inner') : c.indexOf("rev_column_inner")>=0 ?  layer[0].getElementsByClassName('tp-caption') : c.indexOf("rev_group")>=0 ?  layer[0].getElementsByClassName('rev_layer_in_group') : "none"; 
			layer.data('timeline',timeline);
					
		}


		//GO THROUGH ALL LI
		opt.c.find('.tp-revslider-slidesli, .tp-static-layers').each(function() {
			var slide = jQuery(this),
				index = slide.data('index');
			opt.timelines[index] = opt.timelines[index] || {};
			
			opt.timelines[index].layers = opt.timelines[index].layers || new Object();
			

			// COLLECT LAYERS
			slide.find('.tp-caption').each(function(i) {										
				addTimeLineWithLabel(jQuery(this),opt,opt.timelines[index].layers,index);				
			});

		});

		
		
		
	},



	/***************************************
		-	BUILD CAPTION FULL TIMELINES   -
	***************************************/
	buildFullTimeLine : function(obj) {
		
		//if (obj.recall) return;

		var _nc = obj.caption,
			_ = _nc.data(),
			opt = obj.opt,
			$svg = {},								
			_nc_tl_obj,
			_nc_timeline,									
			$hover = newHoverAnimObject(),
			timelineprog = 0;
								
		_nc_tl_obj = opt.timelines[_._slideid]["layers"][_._id];


		if (_nc_tl_obj.generated && obj.regenerate!==true) return;
		_nc_timeline = _nc_tl_obj.timeline;
		
		_nc_tl_obj.generated = true;
		
		if (_.current_timeline!==undefined && obj.regenerate!==true) {			
			_.current_timeline_pause = _.current_timeline.paused();
			_.current_timeline_time = _.current_timeline.time();	
			_.current_is_nc_timeline = 	_nc_timeline === _.current_timeline;	
			_.static_layer_timeline_time = _.current_timeline_time;
		} else {
			_.static_layer_timeline_time = _.current_timeline_time;
			_.current_timeline_time = 0;
			if (_.current_timeline) _.current_timeline.clear();
		}

		

		_nc_timeline.clear();

							
		// PRESET SVG STYLE
		$svg.svg = _.svg_src!=undefined ? _nc.find('svg') : false;				
		if ($svg.svg) _.idlesvg = setSVGAnimObject(_.svg_idle,newSVGHoverAnimObject());	
		
		// HOVER ANIMATION
		if (_.hoverframeindex!==-1 && _.hoverframeindex!==undefined) {						
				  	
			if (!_nc.hasClass("rs-hover-ready")) {		

				_nc.addClass("rs-hover-ready");		  						
				_.hovertimelines = {};
				_.hoveranim = getAnimDatas($hover,_.frames[_.hoverframeindex].to);
				_.hoveranim = convertHoverStyle(_.hoveranim,_.frames[_.hoverframeindex].style);			
				
				if ($svg.svg) {
					var $svghover = setSVGAnimObject(_.svg_hover,newSVGHoverAnimObject());
					if ($hover.anim.color!=undefined) 
						$svghover.anim.fill = $hover.anim.color;										
					_.hoversvg = $svghover;
				}
				_nc.hover(function(e) {					

				 	var obj = {caption:jQuery(e.currentTarget), opt:opt, firstframe : "frame_0", lastframe:"frame_999"},
				 		tl = getTLInfos(obj),
				 		nc = obj.caption,				 		
				 		_ = nc.data(),
				 		frame = _.frames[_.hoverframeindex],				 		
				 		animended = true; //tl.ct>=tl.ffe;
				 					 	
				 	_.forcehover = frame.force;
				 //	animended = _.forcehover===true ? true : _.triggeredtimeline!==undefined ? _.triggeredtimeline.progress()==1 : animended;
				 					 	
				 	if (animended) {	
				 		
					 	_.hovertimelines.item = punchgs.TweenLite.to(nc,frame.speed/1000,_.hoveranim.anim);					 	
					 	if (_.hoverzIndex || (_.hoveranim.anim && _.hoveranim.anim.zIndex)) {
							_.basiczindex = _.basiczindex===undefined ? _.cssobj.zIndex : _.basiczindex;
							_.hoverzIndex = _.hoverzIndex===undefined ? _.hoveranim.anim.zIndex : _.hoverzIndex;					
					 		_.hovertimelines.pwhoveranim = punchgs.TweenLite.to(_._pw,frame.speed/1000,{overwrite:"auto",zIndex:_.hoverzIndex});
					 	}
					 	if ($svg.svg)  
					 		_.hovertimelines.svghoveranim = punchgs.TweenLite.to($svg.svg,frame.speed/1000,_.hoversvg.anim);		
					 	_.hoveredstatus = true;
					 }
				 },
				 function(e) {
				 	var obj = {caption:jQuery(e.currentTarget), opt:opt, firstframe : "frame_0", lastframe:"frame_999"},
				 		tl = getTLInfos(obj),
				 		nc = obj.caption,
				 		_ = nc.data(),
				 		frame = _.frames[_.hoverframeindex],
				 		animended = true; //tl.ct>=tl.ffe;

				 //	animended = _.forcehover===true ? true : _.triggeredtimeline!==undefined ? _.triggeredtimeline.progress()==1 : animended;				 	
				 	if (animended) {	
				 		_.hoveredstatus = false;	
				 		
				 		_.hovertimelines.item = punchgs.TweenLite.to(nc,frame.speed/1000,jQuery.extend(true,{},_._gsTransformTo));
				 		if (_.hovertimelines.pwhoveranim!==undefined) _.hovertimelines.pwhoveranim = punchgs.TweenLite.to(_._pw,frame.speed/1000,{overwrite:"auto",zIndex:_.basiczindex}); 
				 		if ($svg.svg) punchgs.TweenLite.to($svg.svg,frame.speed/1000,_.idlesvg.anim);	 
				 	}
				 });
			}
		} // END IF HOVER ANIMATION 
		
		
		// LOOP TROUGH THE FRAMES AND CREATE FRAME TWEENS AND TL'S ON THE MAIN TIMELINE		
		for (var frame_index=0; frame_index<_.frames.length;frame_index++) {
			
			if (frame_index !== _.hoverframeindex) {
				
				// Create a new Timeline for each Frame
				var frame_name = frame_index === _.inframeindex ? "frame_0" : frame_index===_.outframeindex  || _.frames[frame_index].frame==="frame_999" ? "frame_999" : "frame_"+frame_index;
				_.frames[frame_index].framename = frame_name;

				_nc_tl_obj[frame_name] =  {};
				_nc_tl_obj[frame_name].timeline = new punchgs.TimelineLite({align:"normal"});
				

				var $start = _.frames[frame_index].delay,
					$start_status = _.triggered_startstatus,
					mdelay = $start !== undefined ? jQuery.inArray($start,["slideenter","bytrigger","wait"])>=0 ? $start : parseInt($start,0)/1000 : "wait";

								
				// ADD STARTLABEL FOR STATIC LAYERS 
				if (_nc_tl_obj.firstslide!==undefined && frame_name==="frame_0") {				
					_nc_timeline.addLabel("slide_"+_nc_tl_obj.firstslide+"_pause",0);
					_nc_timeline.addPause("slide_"+_nc_tl_obj.firstslide+"_pause");
					_nc_timeline.addLabel("slide_"+_nc_tl_obj.firstslide,"+=0.005");
				}

				// ADD ENDSLIDE LABEL FOR STATIC LAYERS
				if (_nc_tl_obj.lastslide!==undefined && frame_name==="frame_999") {
					_nc_timeline.addLabel("slide_"+_nc_tl_obj.lastslide+"_pause","+=0.01");
					_nc_timeline.addPause("slide_"+_nc_tl_obj.lastslide+"_pause");
					_nc_timeline.addLabel("slide_"+_nc_tl_obj.lastslide,"+=0.005");
				}

				if (!jQuery.isNumeric(mdelay)) {
					_nc_timeline.addLabel("pause_"+frame_index,"+=0.01");
					_nc_timeline.addPause("pause_"+frame_index);								
					_nc_timeline.addLabel(frame_name,"+=0.01");
				} else {				
					_nc_timeline.addLabel(frame_name,"+="+mdelay);					
				}			

																			
				_nc_timeline = _R.createFrameOnTimeline({caption:obj.caption, timeline : _nc_timeline, label:frame_name, frameindex : frame_index, opt:opt });																	


				
			} // 			
		} // END OF LOOP THROUGH FRAMES AND CREATING NEW TWEENS
		//_nc_timeline.time(timelineprog);		

		if (!obj.regenerate) {
			if (_.current_is_nc_timeline)
				_.current_timeline = _nc_timeline;
			if (_.current_timeline_pause)
				_nc_timeline.pause(_.current_timeline_time);
			else
				_nc_timeline.time(_.current_timeline_time);
		}
					
		return;					
	},

	/////////////////////////////////////
	// BUILD A FRAME ON THE TIMELINE   //
	/////////////////////////////////////
	createFrameOnTimeline : function(obj) {		
		var _nc = obj.caption,
			_ = _nc.data(),
			label = obj.label,
			timeline = obj.timeline,
			frame_index = obj.frameindex,
			opt = obj.opt,
			animobject = _nc,
			tweens =  {},
			_nc_tl_obj = opt.timelines[_._slideid]["layers"][_._id],
			verylastframe = _.frames.length-1,
			$split = _.frames[frame_index].split;

		if (_.hoverframeindex!==-1 &&  _.hoverframeindex==verylastframe) verylastframe=verylastframe-1;
		
		tweens.content =  new punchgs.TimelineLite({align:"normal"});
		tweens.mask =  new punchgs.TimelineLite({align:"normal"});

		
		if (timeline.vars.id===undefined)
			timeline.vars.id=Math.round(Math.random()*100000);
		if (_._nctype==="column") {
	  		timeline.add(punchgs.TweenLite.set(_._cbgc_man,{display:"block"}),label);
	  		timeline.add(punchgs.TweenLite.set(_._cbgc_auto,{display:"none"}),label);
	  	}

		if (_.mySplitText === undefined && _.splittext) {
			var splittarget = _nc.find('a').length>0 ? _nc.find('a') : _nc;			
			_.mySplitText = new punchgs.SplitText(splittarget,{type:"chars,words,lines",charsClass:"tp-splitted tp-charsplit",wordsClass:"tp-splitted tp-wordsplit",linesClass:"tp-splitted tp-linesplit"});
			_nc.addClass("splitted");				
		}

		if ( _.mySplitText !==undefined && $split && $split.match(/chars|words|lines/g)) animobject = _.mySplitText[$split];

		
		// ANIMATE THE FRAME
		
		var $to = frame_index!==_.outframeindex ? getAnimDatas(newAnimObject(),_.frames[frame_index].to) : _.frames[frame_index].to !==undefined && _.frames[frame_index].to.match(/auto:auto/g)===null ? getAnimDatas(newEndAnimObject(),_.frames[frame_index].to,opt.sdir==1) : getAnimDatas(newEndAnimObject(),_.frames[_.inframeindex].from,opt.sdir==0),					
			$from =  _.frames[frame_index].from !==undefined ? getAnimDatas($to,_.frames[_.inframeindex].from,opt.sdir==1) : undefined, 		// ANIMATE FROM THE VERY FIRST SETTING, OR FROM PREVIOUS SETTING 				
			$elemdelay = _.frames[frame_index].splitdelay,
			$mask_from,$mask_to;



		if (frame_index===0 && !obj.fromcurrentstate) 
			$mask_from = getMaskDatas(_.frames[frame_index].mask);
		else
			$mask_to = getMaskDatas(_.frames[frame_index].mask);
						
		$to.anim.ease =  _.frames[frame_index].ease===undefined ? punchgs.Power1.easeInOut : _.frames[frame_index].ease;
		
		if ($from!==undefined) {				
			$from.anim.ease = _.frames[frame_index].ease===undefined ? punchgs.Power1.easeInOut : _.frames[frame_index].ease;			
			$from.speed = _.frames[frame_index].speed === undefined ? $from.speed :   _.frames[frame_index].speed;			
			$from.anim.x = $from.anim.x * opt.bw || getBorderDirections($from.anim.x,opt,_.eow,_.eoh,_.calcy,_.calcx, "horizontal" );
	  		$from.anim.y = $from.anim.y * opt.bw || getBorderDirections($from.anim.y,opt,_.eow,_.eoh,_.calcy,_.calcx, "vertical" );

	  	}

	  	if ($to!==undefined) {				
			$to.anim.ease = _.frames[frame_index].ease===undefined ? punchgs.Power1.easeInOut : _.frames[frame_index].ease;	
			$to.speed = _.frames[frame_index].speed === undefined ? $to.speed :  _.frames[frame_index].speed;					
			$to.anim.x = $to.anim.x * opt.bw || getBorderDirections($to.anim.x,opt,_.eow,_.eoh,_.calcy,_.calcx, "horizontal" );
	  		$to.anim.y = $to.anim.y * opt.bw || getBorderDirections($to.anim.y,opt,_.eow,_.eoh,_.calcy,_.calcx, "vertical" );

	  	} 

	  	
		
		// FIX VISIBLE IFRAME BUG IN SAFARI
		if (_nc.data('iframes')) timeline.add(punchgs.TweenLite.set(_nc.find('iframe'),{autoAlpha:1}),label+"+=0.001");


	  	
	  	// IN CASE LAST FRAME REACHED, AND ANIMATION IS SET TO AUTO (REVERSE PLAYING)
	  	if (frame_index===_.outframeindex) {
	  		if (_.frames[frame_index].to && _.frames[frame_index].to.match(/auto:auto/g)) {
	  			//					
	  		}
	  		
			$to.speed = _.frames[frame_index].speed === undefined ||  _.frames[frame_index].speed==="inherit" ? _.frames[_.inframeindex].speed : _.frames[frame_index].speed;
			$to.anim.ease = _.frames[frame_index].ease === undefined ||  _.frames[frame_index].ease==="inherit" ? _.frames[_.inframeindex].ease : _.frames[frame_index].ease;
			$to.anim.overwrite ="auto";
	  	}

	  	// IN CASE FIRST FRAME REACHED
	  	if (frame_index===0 && !obj.fromcurrentstate) {		  	
	  		if (animobject != _nc) {		  		
				var oldease = $to.anim.ease;  	 
			  	timeline.add(punchgs.TweenLite.set(_nc, $to.anim),label);
			  	$to = newAnimObject();	
			  	$to.ease = oldease;
			}

			$from.anim.visibility = "hidden";
			$from.anim.immediateRender = true;	
			$to.anim.visibility = "visible";
			//_nc.data('speed',$from.speed);
			//_nc.data('ease',$to.anim.ease);					
		} else 

		if (frame_index===0 && obj.fromcurrentstate) {
			$to.speed = $from.speed;
		}

		if (obj.fromcurrentstate) {
			$to.anim.immediateRender = true;				
		}
		

	
		if (frame_index===0 && !obj.fromcurrentstate) 		
			timeline.add(tweens.content.staggerFromTo(animobject,$from.speed/1000,$from.anim,$to.anim,$elemdelay),label);												
		else
			timeline.add(tweens.content.staggerTo(animobject,$to.speed/1000,$to.anim,$elemdelay),label);
				
		if ($mask_to!==undefined && $mask_to!==false) {			
			$mask_to.anim.ease = $mask_to.anim.ease === undefined || $mask_to.anim.ease==="inherit" ? _.frames[0].ease : $mask_to.anim.ease;
			$mask_to.anim.overflow = "hidden";
			$mask_to.anim.x = $mask_to.anim.x * opt.bw || getBorderDirections($mask_to.anim.x,opt,_.eow,_.eoh,_.calcy,_.calcx,"horizontal");
		  	$mask_to.anim.y = $mask_to.anim.y * opt.bw || getBorderDirections($mask_to.anim.y,opt,_.eow,_.eoh,_.calcy,_.calcx,"vertical");
		}
						
		if (frame_index===0 && $mask_from && $mask_from!==false && !obj.fromcurrentstate) {
			$mask_to =  new Object();
			$mask_to.anim = new Object();
			$mask_to.anim.overwrite = "auto";	
			$mask_to.anim.ease = $to.anim.ease;					
			$mask_to.anim.x = $mask_to.anim.y = 0;
			$mask_from.anim.x = $mask_from.anim.x * opt.bw || getBorderDirections($mask_from.anim.x,opt,_.eow,_.eoh,_.calcy,_.calcx,"horizontal");
			$mask_from.anim.y = $mask_from.anim.y * opt.bw || getBorderDirections($mask_from.anim.y,opt,_.eow,_.eoh,_.calcy,_.calcx,"vertical");		  						
			$mask_from.anim.overflow ="hidden";					
		} else
		if (frame_index===0) 
			timeline.add(tweens.mask.set(_._mw,{overflow:"visible"}),label);
		



		
		if ($mask_from!==undefined && $mask_to!==undefined && $mask_from!==false && $mask_to!==false) 		
			timeline.add(tweens.mask.fromTo(_._mw,$from.speed/1000,$mask_from.anim,$mask_to.anim,$elemdelay),label);			
		else 
		if ($mask_to!==undefined && $mask_to!==false)
			timeline.add(tweens.mask.to(_._mw,$to.speed/1000,$mask_to.anim,$elemdelay),label);
				
		timeline.addLabel(label+"_end");
		
		// Reset Hover Effect when Last Frame (Out Animation) ordered
		if (_._gsTransformTo && frame_index===verylastframe && _.hoveredstatus)
			_.hovertimelines.item = punchgs.TweenLite.to(_nc,0,_._gsTransformTo);			
		
		_._gsTransformTo = false;
		
		
		
		// ON START
		tweens.content.eventCallback("onStart",function(frame_index,ncobj,pw,_,tl,toanim,_nc,ust){		

			var data={};
			data.layer = _nc;
			data.eventtype = frame_index===0 ? "enterstage" : frame_index===_.outframeindex ? "leavestage" : "framestarted";
			data.layertype = _nc.data('layertype');
			_nc.data('active',true);
									
			//_.idleanimadded = false;
			data.frame_index = frame_index;			
			data.layersettings = _nc.data();			  	
			opt.c.trigger("revolution.layeraction",[data]);
			if (_.loopanimation=="on") callCaptionLoops(_._lw,opt.bw);		

			if (data.eventtype==="enterstage") {
				_.animdirection="in";
				_.visibleelement=true;
				_R.toggleState(_.layertoggledby);
			}
			if (ncobj.dchildren!=="none" && ncobj.dchildren!==undefined && ncobj.dchildren.length>0) {								
				if (frame_index===0)
					for (var q=0;q<ncobj.dchildren.length;q++) {							
						jQuery(ncobj.dchildren[q]).data('timeline').play(0);						
					}
				else
				if (frame_index===_.outframeindex)
					for (var q=0;q<ncobj.dchildren.length;q++) {				
							_R.endMoveCaption({caption:jQuery(ncobj.dchildren[q]), opt:opt, checkchildrens:true});
					}						
			}		
			punchgs.TweenLite.set(pw,{visibility:"visible"});
			_.current_frame = frame_index;
			_.current_timeline = tl;
			_.current_timeline_time = tl.time();
			if (ust) _.static_layer_timeline_time = _.current_timeline_time;
			_.last_frame_started = frame_index;
			
						
		},[frame_index,_nc_tl_obj,_._pw,_,timeline,$to.anim,_nc,obj.updateStaticTimeline]);
		


		// ON UPDATE
		tweens.content.eventCallback("onUpdate",function(label,id,pw,_,tl,frame_index,toanim,ust) {	
			
			if (_._nctype==="column") setColumnBgDimension(_nc,opt);
			punchgs.TweenLite.set(pw,{visibility:"visible"});	
			_.current_frame = frame_index;
			_.current_timeline = tl;
			_.current_timeline_time = tl.time();
			if (ust) _.static_layer_timeline_time = _.current_timeline_time;
			
			if (_.hoveranim !== undefined && _._gsTransformTo===false) {					
				_._gsTransformTo = toanim;									
				if (_._gsTransformTo && _._gsTransformTo.startAt) delete _._gsTransformTo.startAt;
				
				if (_.cssobj.styleProps.css===undefined)
			 		_._gsTransformTo = jQuery.extend(true,{},_.cssobj.styleProps,_._gsTransformTo);					
			 	else
			 		_._gsTransformTo = jQuery.extend(true,{},_.cssobj.styleProps.css,_._gsTransformTo);					
			}
				
			_.visibleelement=true;	
			
		},[label,_._id,_._pw,_,timeline,frame_index,jQuery.extend(true,{},$to.anim),obj.updateStaticTimeline]);
		

		// ON COMPLETE
		tweens.content.eventCallback("onComplete",function(frame_index,frame_max,verylastframe,pw,_,tl,ust) {										
			var data={};					
			data.layer = _nc;
			data.eventtype = frame_index===0 ? "enteredstage" : frame_index===frame_max-1 || frame_index===verylastframe ? "leftstage" : "frameended";
			data.layertype = _nc.data('layertype');
			data.layersettings = _nc.data();			  	
			opt.c.trigger("revolution.layeraction",[data]);			  	
			if (data.eventtype!=="leftstage") _R.animcompleted(_nc,opt);
			if (data.eventtype==="leftstage") 
				if (_R.stopVideo) _R.stopVideo(_nc,opt);
			
			if (_._nctype==="column") {
				punchgs.TweenLite.set(_._cbgc_man,{display:"none"});
				punchgs.TweenLite.set(_._cbgc_auto,{display:"block"});
			}				
			if (data.eventtype === "leftstage") {
				punchgs.TweenLite.set(pw,{visibility:"hidden"});
				_.animdirection="out";
				_.visibleelement=false;
				_R.unToggleState(_.layertoggledby);
			}
			_.current_frame = frame_index;
			_.current_timeline = tl;
			_.current_timeline_time = tl.time();
			if (ust) _.static_layer_timeline_time = _.current_timeline_time;
			
			
		},[frame_index,_.frames.length,verylastframe,_._pw,_,timeline,obj.updateStaticTimeline]);

		
		return timeline;
	},

	



	//////////////////////////////
	//	MOVE OUT THE CAPTIONS  //
	////////////////////////////
	endMoveCaption : function(obj) {
		obj.firstframe="frame_0";
		obj.lastframe="frame_999";

		var nc = getTLInfos(obj),
			_ = obj.caption.data();
				
		if (obj.frame!==undefined)
			nc.timeline.play(obj.frame);
		else
		if (!nc.static || (obj.currentslide>=nc.removeonslide) || (obj.currentslide<nc.showonslide)) {		
			nc.outnow = new punchgs.TimelineLite;
			nc.timeline.pause();			
			if (_.visibleelement===true)
				_R.createFrameOnTimeline({caption:obj.caption, timeline : nc.outnow, label:"outnow", frameindex : obj.caption.data("outframeindex"), opt:obj.opt, fromcurrentstate:true}).play();	 		
		}		

		if (obj.checkchildrens) 
			if (nc.timeline_obj && nc.timeline_obj.dchildren && nc.timeline_obj.dchildren!=="none" && nc.timeline_obj.dchildren.length>0) 
				for (var q = 0; q<nc.timeline_obj.dchildren.length;q++) {								
					_R.endMoveCaption({caption:jQuery(nc.timeline_obj.dchildren[q]), opt:obj.opt});
				}			
	},

	//////////////////////////////////
	//	MOVE CAPTIONS TO xx FRAME  //
	/////////////////////////////////
	playAnimationFrame : function(obj) {
		obj.firstframe = obj.triggerframein;
		obj.lastframe = obj.triggerframeout;


		var nc = getTLInfos(obj),	
			_ = obj.caption.data(),
			frameindex,
			i=0;
		

		for (var k in _.frames) {			
			if (_.frames[k].framename === obj.frame) frameindex = i;
			i++;
		}
		

		_.triggeredtimeline = new punchgs.TimelineLite;
		nc.timeline.pause();

		var fcs = _.visibleelement===true ? true : false;
		_.triggeredtimeline = _R.createFrameOnTimeline({caption:obj.caption, timeline : _.triggeredtimeline, label:"triggered", frameindex : frameindex, updateStaticTimeline:true, opt:obj.opt, fromcurrentstate:fcs}).play();
		
		
		//nc.timeline.play(obj.frame);		
	
	},

	//////////////////////////
	//	REMOVE THE CAPTIONS //
	/////////////////////////
	removeTheCaptions : function(actli,opt) {	
		if (_R.compare_version(extension).check==="stop") return false;	
		var removetime = 0,
			index = actli.data('index'),	
			allcaptions = new Array;
		
		// COLLECT ALL CAPTIONS		
		if (opt.layers[index])
			jQuery.each(opt.layers[index], function(i,a) { allcaptions.push(a); });
		
		/*if (opt.layers["static"])
			jQuery.each(opt.layers["static"], function(i,a) { allcaptions.push(a); });*/
		
		var slideindex = _R.currentSlideIndex(opt);


		// GO THROUGH ALL CAPTIONS, AND MANAGE THEM
		if (allcaptions)
			jQuery.each(allcaptions,function(i) {
			    var _nc=jQuery(this);
				killCaptionLoops(_nc);
				clearTimeout(_nc.data('videoplaywait'));				
				_R.endMoveCaption({caption:_nc,opt:opt, currentslide:slideindex});					
				if (_R.removeMediaFromList) _R.removeMediaFromList(_nc,opt);
				opt.lastplayedvideos = [];
				
			});		
	}
});





/**********************************************************************************************
						-	HELPER FUNCTIONS FOR LAYER TRANSFORMS -
**********************************************************************************************/

//////////////////////////////////////////////
//	-	GET TIMELINE INFOS FROM CAPTION	-  //
/////////////////////////////////////////////
var getTLInfos = function(obj) {
	var _ = {};

	obj.firstframe=obj.firstframe===undefined ? "frame_0" : obj.firstframe;
	obj.lastframe=obj.lastframe===undefined ? "frame_999" : obj.lastframe;

 	_.id = obj.caption.data('id') || obj.caption.attr('id');
 	_.slideid = obj.caption.data('slideid') || obj.caption.closest('.tp-revslider-slidesli').data('index'); 	
 	_.timeline_obj = obj.opt.timelines[_.slideid]["layers"][_.id];
 	_.timeline = _.timeline_obj.timeline; 	
 	_.ffs = _.timeline.getLabelTime(obj.firstframe);
 	_.ffe = _.timeline.getLabelTime(obj.firstframe+"_end");
 	_.lfs = _.timeline.getLabelTime(obj.lastframe);
 	_.lfe = _.timeline.getLabelTime(obj.lastframe+"_end");
 	_.ct = _.timeline.time(); 	
 	_.static = _.timeline_obj.firstslide!=undefined || _.timeline_obj.lastslide!=undefined;
 	if (_.static) {
 		_.showonslide = _.timeline_obj.firstslide;
 		_.removeonslide = _.timeline_obj.lastslide;
 	}

	return _;
}


/////////////////////////////////////
//	-	CREATE ANIMATION OBJECT	-  //
/////////////////////////////////////
var newAnimObject = function(a) {
	a = a===undefined ? new Object() : a;	
	a.anim = a.anim===undefined ? new Object() : a.anim;
	a.anim.x = a.anim.x===undefined ? 0 : a.anim.x;
	a.anim.y = a.anim.y===undefined ? 0 : a.anim.y;
	a.anim.z = a.anim.z===undefined ? 0 : a.anim.z;
	a.anim.rotationX = a.anim.rotationX===undefined ? 0 : a.anim.rotationX;
	a.anim.rotationY = a.anim.rotationY===undefined ? 0 : a.anim.rotationY;
	a.anim.rotationZ = a.anim.rotationZ===undefined ? 0	: a.anim.rotationZ;
	a.anim.scaleX = a.anim.scaleX===undefined ? 1 : a.anim.scaleX;
	a.anim.scaleY = a.anim.scaleY===undefined ? 1 : a.anim.scaleY;
	a.anim.skewX = a.anim.skewX===undefined ? 0 : a.anim.skewX;
	a.anim.skewY = a.anim.skewY===undefined ? 0 : a.anim.skewY;
	a.anim.opacity = a.anim.opacity===undefined ? 1 : a.anim.opacity;
	a.anim.transformOrigin = a.anim.transformOrigin===undefined ? "50% 50%" : a.anim.transformOrigin;
	a.anim.transformPerspective = a.anim.transformPerspective===undefined ? 600 : a.anim.transformPerspective;
	a.anim.rotation = a.anim.rotation===undefined ? 0 : a.anim.rotation;
	//a.anim.ease = a.anim.ease===undefined ? punchgs.Power3.easeOut : a.anim.ease;
	a.anim.force3D = a.anim.force3D===undefined ? "auto" : a.anim.force3D;
	a.anim.autoAlpha = a.anim.autoAlpha===undefined ? 1 : a.anim.autoAlpha;
	a.anim.visibility = a.anim.visibility===undefined ? "visible" : a.anim.visibility;
	a.anim.overwrite = a.anim.overwrite===undefined ? "auto"  : a.anim.overwrite;
	a.speed = a.speed===undefined ? 0.3 : a.speed;


	return a;
}

var newSVGHoverAnimObject = function() {
	var a = new Object();
	a.anim = new Object();
	
	a.anim.stroke="none";
	a.anim.strokeWidth=0;
	a.anim.strokeDasharray="none";
	a.anim.strokeDashoffset="0";
	return a;
}

var setSVGAnimObject = function(data,a) {
	var customarray = data.split(';');	
	if (customarray)	
		jQuery.each(customarray,function(index,pa) {
			var p = pa.split(":")
			var w = p[0],
				v = p[1];
			
			if (w=="sc") a.anim.stroke=v;
			if (w=="sw") a.anim.strokeWidth=v;
			if (w=="sda") a.anim.strokeDasharray=v;
			if (w=="sdo") a.anim.strokeDashoffset=v;
		});

	return a;
}



var newEndAnimObject = function() {
	var a = new Object();
	a.anim = new Object();	
	a.anim.x=0;
	a.anim.y=0;	
	a.anim.z=0;
	return a;
}

var newHoverAnimObject = function() {
	var a = new Object();
	a.anim = new Object();		
	a.speed = 0.2;						
	return a;
}

var animDataTranslator = function(val,defval) {

	if (jQuery.isNumeric(parseFloat(val))) {				
		return parseFloat(val);
	} else 
	if (val===undefined || val==="inherit") {				
		return defval;
	} else 
	if (val.split("{").length>1) {
		var min = val.split(","),
			max = parseFloat(min[1].split("}")[0]);
		min = parseFloat(min[0].split("{")[1]);
		val = Math.random()*(max-min) + min;		
	}	
	return val;	
}	

var getBorderDirections = function (x,o,w,h,top,left,direction) {		
			
	if (!jQuery.isNumeric(x) && x.match(/%]/g)) {
		x = x.split("[")[1].split("]")[0];				
		if (direction=="horizontal")
			x = (w+2)*parseInt(x,0)/100;
		else
		if (direction=="vertical")
			x = (h+2)*parseInt(x,0)/100;
	} else {
		
		x = x === "layer_left"  ? (0-w) : x === "layer_right" ? w : x;
		x = x === "layer_top" ? (0-h) : x==="layer_bottom" ? h : x;
		x = x === "left" || x==="stage_left" ? (0-w-left) : x === "right" || x==="stage_right" ? o.conw-left : x === "center" || x === "stage_center" ? (o.conw/2 - w/2)-left : x;
		x = x === "top" || x==="stage_top" ? (0-h-top) : x==="bottom" || x==="stage_bottom" ? o.conh-top : x === "middle" || x === "stage_middle" ? (o.conh/2 - h/2)-top : x;					
	}
	

	return x;
}

///////////////////////////////////////////////////
// ANALYSE AND READ OUT DATAS FROM HTML CAPTIONS //
///////////////////////////////////////////////////
var getAnimDatas = function(frm,data,reversed) {		
	var o = new Object();
	o = jQuery.extend(true,{},o, frm);
	if (data === undefined) 
		return o;		


	var customarray = data.split(';');	
	
	if (customarray)	
		jQuery.each(customarray,function(index,pa) {
			var p = pa.split(":")
			var w = p[0],
				v = p[1];
			
			
			if (reversed && v!=undefined && v.length>0 && v.match(/\(R\)/)) {							
				v = v.replace("(R)","");
				v = v==="right" ? "left" : v==="left" ? "right" : v==="top" ? "bottom" : v==="bottom" ? "top" : v;	
				if (v[0]==="[" && v[1]==="-") v = v.replace("[-","[");
				else
				if (v[0]==="[" && v[1]!=="-") v = v.replace("[","[-");	
				else
				if (v[0]==="-") v = v.replace("-","");
				else
				if (v[0].match(/[1-9]/)) v="-"+v;											
			}
			
			if (v!=undefined) {
				v = v.replace(/\(R\)/,'');
				if (w=="rotationX" || w=="rX") o.anim.rotationX = animDataTranslator(v,o.anim.rotationX)+"deg";			
				if (w=="rotationY" || w=="rY") o.anim.rotationY = animDataTranslator(v,o.anim.rotationY)+"deg";
				if (w=="rotationZ" || w=="rZ") o.anim.rotation = animDataTranslator(v,o.anim.rotationZ)+"deg";					
				if (w=="scaleX" || w=="sX") o.anim.scaleX = animDataTranslator(v,o.anim.scaleX);
				if (w=="scaleY" || w=="sY") o.anim.scaleY = animDataTranslator(v,o.anim.scaleY);
				if (w=="opacity" || w=="o") o.anim.opacity = animDataTranslator(v,o.anim.opacity);
				if (o.anim.opacity===0) o.anim.autoAlpha = 0;

				o.anim.opacity = o.anim.opacity == 0 ? 0.0001 : o.anim.opacity;

				if (w=="skewX" || w=="skX") o.anim.skewX = animDataTranslator(v,o.anim.skewX);
				if (w=="skewY" || w=="skY") o.anim.skewY = animDataTranslator(v,o.anim.skewY);
				if (w=="x") o.anim.x = animDataTranslator(v,o.anim.x);
				if (w=="y") o.anim.y = animDataTranslator(v,o.anim.y);
				if (w=="z") o.anim.z = animDataTranslator(v,o.anim.z);
				if (w=="transformOrigin" || w=="tO") o.anim.transformOrigin = v.toString();
				if (w=="transformPerspective" || w=="tP") o.anim.transformPerspective=parseInt(v,0);
				if (w=="speed" || w=="s") o.speed = parseFloat(v);	
				
				//if (w=="ease" || w=="e") o.anim.ease = v;
			}

		})	

		
	return o;
}



/////////////////////////////////
// BUILD MASK ANIMATION OBJECT //
/////////////////////////////////
var getMaskDatas = function(d) {		
	if (d === undefined)
		return false;

	var o = new Object();	
	o.anim = new Object();
	var s = d.split(';')
	if (s)
		jQuery.each(s,function(index,param) {
			param = param.split(":")
			var w = param[0],
				v = param[1];
			if (w=="x") o.anim.x = v;
			if (w=="y") o.anim.y = v;
			if (w=="s") o.speed = parseFloat(v);
			if (w=="e" || w=="ease") o.anim.ease = v;	
		});

	return o;
}
	



////////////////////////
// SHOW THE CAPTION  //
///////////////////////

var makeArray = function(obj,opt,show) {
	
	if (obj==undefined) obj = 0;

	if (!jQuery.isArray(obj) && jQuery.type(obj)==="string" && (obj.split(",").length>1 || obj.split("[").length>1)) {
		obj = obj.replace("[","");
		obj = obj.replace("]","");
		var newobj = obj.match(/'/g) ? obj.split("',") : obj.split(",");
		obj = new Array();
		if (newobj)
			jQuery.each(newobj,function(index,element) {
				element = element.replace("'","");
				element = element.replace("'","");
				obj.push(element);
			})
	} else {
		var tempw = obj;			
		if (!jQuery.isArray(obj) ) {
			obj = new Array();				
			obj.push(tempw);				
		} 
	}

	var tempw = obj[obj.length-1]; 

	if (obj.length<opt.rle) {
		for (var i=1;i<=opt.curWinRange;i++) {
			obj.push(tempw);
		}
	}
	return obj;
}


/* CREATE SHARP CORNERS */
function sharpCorners(nc,$class, $side,$borderh,$borderv,ncch,bgcol) {
	var a = nc.find($class);
	a.css('borderWidth',ncch+"px");
	a.css($side,(0-ncch)+'px');
	a.css($borderh,'0px solid transparent');
	a.css($borderv,bgcol);
}


var convertHoverStyle = function(t,s) {
	if (s===undefined) return t;
	s = s.replace("c:","color:");
	s = s.replace("bg:","background-color:");
	s = s.replace("bw:","border-width:");
	s = s.replace("bc:","border-color:");
	s = s.replace("br:","borderRadius:");
	s = s.replace("bs:","border-style:");
	s = s.replace("td:","text-decoration:");
	s = s.replace("zi:","zIndex:");
	var sp = s.split(";");
	if (sp)
		jQuery.each(sp,function(key,cont){
			var attr = cont.split(":");
			if (attr[0].length>0)
				t.anim[attr[0]] = attr[1];		
		})				
	return t;

}


////////////////////////////////////////////////
//	-	GET CSS ATTRIBUTES OF ELEMENT	-	  //
////////////////////////////////////////////////
var getcssParams = function(nc,level) {
	
	var obj = new Object(),
		gp = false,
		pc;
	
	
	// CHECK IF CURRENT ELEMENT SHOULD RESPECT REKURSICVE RESIZES, AND SHOULD OWN THE SAME ATTRIBUTES FROM PARRENT ELEMENT
	if (level=="rekursive") {
		pc = nc.closest('.tp-caption');		
		if (pc && nc.css("fontSize") === pc.css("fontSize")) 
			gp = true;
	}

	obj.basealign = nc.data('basealign') || "grid";
	
	obj.fontSize = gp ? pc.data('fontsize')===undefined ?  parseInt(pc.css('fontSize'),0) || 0 : pc.data('fontsize')  :  nc.data('fontsize')===undefined ?  parseInt(nc.css('fontSize'),0) || 0 : nc.data('fontsize'); 
	obj.fontWeight = gp ? pc.data('fontweight')===undefined ?  parseInt(pc.css('fontWeight'),0) || 0 : pc.data('fontweight')  :  nc.data('fontweight')===undefined ?  parseInt(nc.css('fontWeight'),0) || 0 : nc.data('fontweight'); 
	obj.whiteSpace = gp ? pc.data('whitespace')===undefined ?  pc.css('whitespace') || "normal" : pc.data('whitespace')  :  nc.data('whitespace')===undefined ?  nc.css('whitespace') || "normal" : nc.data('whitespace'); 
	obj.textAlign = gp ? pc.data('textalign')===undefined ?  pc.css('textalign') || "inherit" : pc.data('textalign')  :  nc.data('textalign')===undefined ?  nc.css('textalign') || "inherit" : nc.data('textalign'); 
	obj.zIndex = gp ? pc.data('zIndex')===undefined ?  pc.css('zIndex') || "inherit" : pc.data('zIndex')  :  nc.data('zIndex')===undefined ?  nc.css('zIndex') || "inherit" : nc.data('zIndex'); 
	
	if (jQuery.inArray(nc.data('layertype'),["video","image","audio"])===-1 && !nc.is("img"))
		obj.lineHeight = gp ? pc.data('lineheight')===undefined ? parseInt(pc.css('lineHeight'),0) || 0 : pc.data('lineheight')  :  nc.data('lineheight')===undefined ? parseInt(nc.css('lineHeight'),0) || 0 : nc.data('lineheight');
	else
		obj.lineHeight = 0;
		
	obj.letterSpacing = gp ? pc.data('letterspacing')===undefined ? parseFloat(pc.css('letterSpacing'),0) || 0 : pc.data('letterspacing') : nc.data('letterspacing')===undefined ? parseFloat(nc.css('letterSpacing')) || 0 : nc.data('letterspacing');
				
	obj.paddingTop = nc.data('paddingtop')===undefined ? parseInt(nc.css('paddingTop'),0) || 0 : nc.data('paddingtop');
	obj.paddingBottom = nc.data('paddingbottom')===undefined ? parseInt(nc.css('paddingBottom'),0) || 0 : nc.data('paddingbottom');
	obj.paddingLeft = nc.data('paddingleft')===undefined ? parseInt(nc.css('paddingLeft'),0) || 0 : nc.data('paddingleft');
	obj.paddingRight = nc.data('paddingright')===undefined ? parseInt(nc.css('paddingRight'),0) || 0 : nc.data('paddingright');

	obj.marginTop = nc.data('margintop')===undefined ? parseInt(nc.css('marginTop'),0) || 0 : nc.data('margintop');
	obj.marginBottom = nc.data('marginbottom')===undefined ? parseInt(nc.css('marginBottom'),0) || 0 : nc.data('marginbottom');
	obj.marginLeft = nc.data('marginleft')===undefined ? parseInt(nc.css('marginLeft'),0) || 0 : nc.data('marginleft');
	obj.marginRight = nc.data('marginright')===undefined ? parseInt(nc.css('marginRight'),0) || 0 : nc.data('marginright');	
	obj.borderTopWidth = nc.data('bordertopwidth')===undefined ? parseInt(nc.css('borderTopWidth'),0) || 0 : nc.data('bordertopwidth');
	obj.borderBottomWidth = nc.data('borderbottomwidth')===undefined ? parseInt(nc.css('borderBottomWidth'),0) || 0 : nc.data('borderbottomwidth');
	obj.borderLeftWidth = nc.data('borderleftwidth')===undefined ? parseInt(nc.css('borderLeftWidth'),0) || 0 : nc.data('borderleftwidth');
	obj.borderRightWidth = nc.data('borderrightwidth')===undefined ? parseInt(nc.css('borderRightWidth'),0) || 0 : nc.data('borderrightwidth');

	if (level!="rekursive") {
		obj.color = nc.data('color')===undefined ? "nopredefinedcolor" : nc.data('color');

		obj.whiteSpace = gp ? pc.data('whitespace')===undefined ? pc.css('whiteSpace') || "nowrap" : pc.data('whitespace') : nc.data('whitespace')===undefined ? nc.css('whiteSpace') || "nowrap" : nc.data('whitespace');
		obj.textAlign = gp ? pc.data('textalign')===undefined ? pc.css('textalign') || "inherit" : pc.data('textalign') : nc.data('textalign')===undefined ? nc.css('textalign') || "inherit" : nc.data('textalign');

		obj.minWidth = nc.data('width')===undefined ? parseInt(nc.css('minWidth'),0) || 0 : nc.data('width');
		obj.minHeight = nc.data('height')===undefined ? parseInt(nc.css('minHeight'),0) || 0 : nc.data('height');

		if (nc.data('videowidth')!=undefined && nc.data('videoheight')!=undefined) {
			var vwid = nc.data('videowidth'),
				vhei = nc.data('videoheight');
			vwid = vwid==="100%" ? "none" : vwid;
			vhei = vhei==="100%" ? "none" : vhei;
			
			nc.data('width',vwid);
			nc.data('height',vhei);
		}
		
		obj.maxWidth = nc.data('width')===undefined ? parseInt(nc.css('maxWidth'),0) || "none" : nc.data('width');
		obj.maxHeight = nc.data('height')===undefined ? parseInt(nc.css('maxHeight'),0) || "none" : nc.data('height');
		
		obj.wan = nc.data('wan')===undefined ? parseInt(nc.css('-webkit-transition'),0) || "none" : nc.data('wan');
		obj.moan = nc.data('moan')===undefined ? parseInt(nc.css('-moz-animation-transition'),0) || "none" : nc.data('moan');
		obj.man = nc.data('man')===undefined ? parseInt(nc.css('-ms-animation-transition'),0) || "none" : nc.data('man');
		obj.ani = nc.data('ani')===undefined ? parseInt(nc.css('transition'),0) || "none" : nc.data('ani');
	}
		
	obj.styleProps = nc.css(["background-color",							 
							 "border-top-color",
							 "border-bottom-color",
							 "border-right-color",
							 "border-left-color",							
							 "border-top-style",
							 "border-bottom-style",
							 "border-left-style",
							 "border-right-style",							
							 "border-left-width",
							 "border-right-width",
							 "border-bottom-width",
							 "border-top-width",							 
							 "color",							 
							 "text-decoration",
							 "font-style",							 
							 "borderTopLeftRadius",
							 "borderTopRightRadius",
							 "borderBottomLeftRadius",
							 "borderBottomRightRadius"							
							 ]);		
	
	return obj;
}

// READ SINGLE OR ARRAY VALUES OF OBJ CSS ELEMENTS
var setResponsiveCSSValues = function(obj,opt) {
	var newobj = new Object();
	if (obj)
		jQuery.each(obj,function(key,val){						
			var res_a = makeArray(val,opt)[opt.curWinRange];
			newobj[key] = res_a!==undefined  ? res_a : obj[key];		
		});	
	return newobj;
}

var minmaxconvert = function(a,m,r,fr) {
	
	a = jQuery.isNumeric(a) ? (a * m)+"px" : a;
	a = a==="full" ? fr : a==="auto" || a==="none" ? r : a;
	return a;

}

/////////////////////////////////////////////////////////////////
//	-	CALCULATE THE RESPONSIVE SIZES OF THE CAPTIONS	-	  //
/////////////////////////////////////////////////////////////////
var calcCaptionResponsive = function(nc,opt,level,responsive) {
	
	var _=nc.data();
	try{
		if (nc[0].nodeName=="BR" || nc[0].tagName=="br") 			
			return false;				
	} catch(e) {

	}	

	_.cssobj = _.cssobj===undefined ? getcssParams(nc,level) : _.cssobj;
	
	var obj = setResponsiveCSSValues(_.cssobj,opt),	
		bw=opt.bw,
		bh=opt.bh;

	if (responsive==="off") {
		bw=1;
		bh=1;
	}
																	
	// IE8 FIX FOR AUTO LINEHEIGHT
	if (obj.lineHeight=="auto") obj.lineHeight = obj.fontSize+4;

						
	if (!nc.hasClass("tp-splitted")) {

		nc.css("-webkit-transition", "none");
	    nc.css("-moz-transition", "none");
	    nc.css("-ms-transition", "none");
	    nc.css("transition", "none");
	   
	    var hashover = nc.data('transform_hover')!==undefined || nc.data('style_hover')!==undefined;
	    if (hashover) punchgs.TweenLite.set(nc,obj.styleProps);
		

		punchgs.TweenLite.set(nc,{

			 fontSize: Math.round((obj.fontSize * bw))+"px",
			 fontWeight: obj.fontWeight,
			 letterSpacing:Math.floor((obj.letterSpacing * bw))+"px",
			 paddingTop: Math.round((obj.paddingTop * bh)) + "px",
			 paddingBottom: Math.round((obj.paddingBottom * bh)) + "px",
			 paddingLeft: Math.round((obj.paddingLeft* bw)) + "px",
			 paddingRight: Math.round((obj.paddingRight * bw)) + "px",
			 marginTop: (obj.marginTop * bh) + "px",
			 marginBottom: (obj.marginBottom * bh) + "px",
			 marginLeft: (obj.marginLeft * bw) + "px",
			 marginRight: (obj.marginRight * bw) + "px",			 
			 borderTopWidth: Math.round(obj.borderTopWidth * bh) + "px",
			 borderBottomWidth: Math.round(obj.borderBottomWidth * bh) + "px",
			 borderLeftWidth: Math.round(obj.borderLeftWidth * bw) + "px",
			 borderRightWidth: Math.round(obj.borderRightWidth * bw) + "px",
			 lineHeight: Math.round(obj.lineHeight * bh) + "px",
			 textAlign:(obj.textAlign),
			 overwrite:"auto"});


		if (level!="rekursive") {
			
			
			
			var winw = obj.basealign =="slide" ? opt.ulw : opt.gridwidth[opt.curWinRange],
				winh = obj.basealign =="slide" ? opt.ulh : opt.gridheight[opt.curWinRange],
				maxw = minmaxconvert(obj.maxWidth,bw,"none",winw),
				maxh = minmaxconvert(obj.maxHeight,bh,"none",winh),
				minw = minmaxconvert(obj.minWidth,bw,"0px",winw),
				minh = minmaxconvert(obj.minHeight,bh,"0px",winh);
			
			// TWEEN FIX ISSUES
			minw=minw===undefined ? 0 : minw;
			minh=minh===undefined ? 0 : minh;
			maxw=maxw===undefined ? "none" : maxw;
			maxh=maxh===undefined ? "none" : maxh;
			
			punchgs.TweenLite.set(nc,{
				 maxWidth:maxw,
				 maxHeight:maxh,
				 minWidth:minw,
				 minHeight:minh,
				 whiteSpace:obj.whiteSpace,		
				 textAlign:(obj.textAlign),			 
				 overwrite:"auto"
			});

			if (obj.color!="nopredefinedcolor") 
				punchgs.TweenLite.set(nc,{color:obj.color,overwrite:"auto"});
			
			if (_.svg_src!=undefined) {
				var scolto = obj.color!="nopredefinedcolor" && obj.color!=undefined ? obj.color : obj.css!=undefined && obj.css.color!="nopredefinedcolor" && obj.css.color!=undefined ? obj.css.color : obj.styleProps.color!=undefined ? obj.styleProps.color : obj.styleProps.css!=undefined && obj.styleProps.css.color!=undefined ? obj.styleProps.css.color : false; 
				if (scolto!=false) {
					punchgs.TweenLite.set(nc.find('svg'),{fill:scolto,overwrite:"auto"});
					punchgs.TweenLite.set(nc.find('svg path'),{fill:scolto,overwrite:"auto"});				
				}
			}
			
		}

		if (_._nctype==="column") {						
			if (_._column_bg_set===undefined) {
				_._column_bg_set = nc.css('backgroundColor');			
				_._column_bg_image = nc.css('backgroundImage');
		 		_._column_bg_image_repeat  =nc.css('backgroundRepeat');
		 		_._column_bg_image_position  =nc.css('backgroundPosition');
		 		_._column_bg_image_size  =nc.css('backgroundSize');
		 		_._column_bg_opacity = nc.data('bgopacity');
		 		_._column_bg_opacity = _._column_bg_opacity===undefined ? 1 : _._column_bg_opacity;
		 		
		 		
				punchgs.TweenLite.set(nc,{
					backgroundColor:"transparent",
					backgroundImage:""
				});
			}

			setTimeout(function() {
				setColumnBgDimension(nc,opt);
			},1);
			
			// DYNAMIC HEIGHT AUTO CALCULATED BY BROWSER 
			if (_._cbgc_auto) {		
				_._cbgc_auto[0].style.backgroundSize = _._column_bg_image_size;
				if (jQuery.isArray(obj.marginLeft)) {						
					punchgs.TweenLite.set(_._cbgc_auto,{						
						borderTopWidth:   (obj.marginTop[opt.curWinRange] * bh) + "px",
						borderLeftWidth:  (obj.marginLeft[opt.curWinRange] * bw) + "px",
						borderRightWidth: (obj.marginRight[opt.curWinRange] * bw) + "px",
						borderBottomWidth:(obj.marginBottom[opt.curWinRange] * bh) + "px",									
					 	backgroundColor:_._column_bg_set,
					 	backgroundImage:_._column_bg_image,
					 	backgroundRepeat:_._column_bg_image_repeat,
					 	backgroundPosition:_._column_bg_image_position,
					 	opacity:_._column_bg_opacity
					 	
					});
				} else {
					punchgs.TweenLite.set(_._cbgc_auto,{						
						borderTopWidth:   (obj.marginTop * bh) + "px",
						borderLeftWidth:  (obj.marginLeft * bw) + "px",
						borderRightWidth: (obj.marginRight * bw) + "px",
						borderBottomWidth:(obj.marginBottom * bh) + "px",							
					 	backgroundColor:_._column_bg_set,
					 	backgroundImage:_._column_bg_image,
					 	backgroundRepeat:_._column_bg_image_repeat,
					 	backgroundPosition:_._column_bg_image_position,
					 	opacity:_._column_bg_opacity
					 	
					});	
				}		
				
																
			}
		}

		setTimeout(function() {
			nc.css("-webkit-transition", nc.data('wan'));
		    nc.css("-moz-transition", nc.data('moan'));
		    nc.css("-ms-transition", nc.data('man'));
		    nc.css("transition", nc.data('ani'));
		},30);									
	}
}


var setColumnBgDimension = function(nc,opt) {
	// DYNAMIC HEIGHT BASED ON ROW HEIGHT
	var _ = nc.data();
	if (_._cbgc_man) {						
		
			
		var _l,_t,_b,_r,_h,_o;

		if (!jQuery.isArray(_.cssobj.marginLeft)) {			
			_l = (_.cssobj.marginLeft * opt.bw);
			_t = (_.cssobj.marginTop * opt.bh);
			_b = (_.cssobj.marginBottom * opt.bh);
			_r = (_.cssobj.marginRight * opt.bw);
		} else {
			_l = (_.cssobj.marginLeft[opt.curWinRange] * opt.bw);
			_t = (_.cssobj.marginTop[opt.curWinRange] * opt.bh);
			_b = (_.cssobj.marginBottom[opt.curWinRange] * opt.bh);
			_r = (_.cssobj.marginRight[opt.curWinRange] * opt.bw);
		}				
		_h = _._row.hasClass("rev_break_columns") ? "100%" : (_._row.outerHeight() - (_t+_b))+"px";		
		

		
		_._cbgc_man[0].style.backgroundSize = _._column_bg_image_size;
		punchgs.TweenLite.set(_._cbgc_man,{						
			width:"100%",
			height:_h,
		 	backgroundColor:_._column_bg_set,
		 	backgroundImage:_._column_bg_image,
		 	backgroundRepeat:_._column_bg_image_repeat,
		 	backgroundPosition:_._column_bg_image_position,		 	
		 	overwrite:"auto",
		 	opacity:_._column_bg_opacity
		});
		
	}
}

//////////////////////
//	CAPTION LOOPS	//
//////////////////////
var callCaptionLoops = function(el,factor) {
	var _ = el.data();
	// SOME LOOPING ANIMATION ON INTERNAL ELEMENTS
	if (el.hasClass("rs-pendulum")) {			
		if (_._loop_timeline==undefined) {
			_._loop_timeline = new punchgs.TimelineLite;
			var startdeg = el.data('startdeg')==undefined ? -20 : el.data('startdeg'),
				enddeg = el.data('enddeg')==undefined ? 20 : el.data('enddeg'),
				speed = el.data('speed')==undefined ? 2 : el.data('speed'),
				origin = el.data('origin')==undefined ? "50% 50%" : el.data('origin'),
				easing = el.data('easing')==undefined ? punchgs.Power2.easeInOut : el.data('easing');

				
			startdeg = startdeg * factor;
			enddeg = enddeg * factor;

			_._loop_timeline.append(new punchgs.TweenLite.fromTo(el,speed,{force3D:"auto",rotation:startdeg,transformOrigin:origin},{rotation:enddeg,ease:easing}));
			_._loop_timeline.append(new punchgs.TweenLite.fromTo(el,speed,{force3D:"auto",rotation:enddeg,transformOrigin:origin},{rotation:startdeg,ease:easing,onComplete:function() {
				_._loop_timeline.restart();
			}}));
		}

	}

	// SOME LOOPING ANIMATION ON INTERNAL ELEMENTS
	if (el.hasClass("rs-rotate")) {				
		if (_._loop_timeline==undefined) {
			_._loop_timeline = new punchgs.TimelineLite;
			var startdeg = el.data('startdeg')==undefined ? 0 : el.data('startdeg'),
				enddeg = el.data('enddeg')==undefined ? 360 : el.data('enddeg'),
				speed = el.data('speed')==undefined ? 2 : el.data('speed'),
				origin = el.data('origin')==undefined ? "50% 50%" : el.data('origin'),
				easing = el.data('easing')==undefined ? punchgs.Power2.easeInOut : el.data('easing');

			startdeg = startdeg * factor;
			enddeg = enddeg * factor;

			_._loop_timeline.append(new punchgs.TweenLite.fromTo(el,speed,{force3D:"auto",rotation:startdeg,transformOrigin:origin},{rotation:enddeg,ease:easing,onComplete:function() {
				_._loop_timeline.restart();
			}}));
		}

	}

	// SOME LOOPING ANIMATION ON INTERNAL ELEMENTS
	if (el.hasClass("rs-slideloop")) {			
		if (_._loop_timeline==undefined) {
			_._loop_timeline = new punchgs.TimelineLite;
			var xs = el.data('xs')==undefined ? 0 : el.data('xs'),
				ys = el.data('ys')==undefined ? 0 : el.data('ys'),
				xe = el.data('xe')==undefined ? 0 : el.data('xe'),
				ye = el.data('ye')==undefined ? 0 : el.data('ye'),
				speed = el.data('speed')==undefined ? 2 : el.data('speed'),
				easing = el.data('easing')==undefined ? punchgs.Power2.easeInOut : el.data('easing');

				xs = xs * factor;
				ys = ys * factor;
				xe = xe * factor;
				ye = ye * factor;

			_._loop_timeline.append(new punchgs.TweenLite.fromTo(el,speed,{force3D:"auto",x:xs,y:ys},{x:xe,y:ye,ease:easing}));
			_._loop_timeline.append(new punchgs.TweenLite.fromTo(el,speed,{force3D:"auto",x:xe,y:ye},{x:xs,y:ys,onComplete:function() {
				_._loop_timeline.restart();
			}}));
		}
	}

	// SOME LOOPING ANIMATION ON INTERNAL ELEMENTS
	if (el.hasClass("rs-pulse")) {			
		if (_._loop_timeline==undefined) {
			_._loop_timeline = new punchgs.TimelineLite;
			var zoomstart = el.data('zoomstart')==undefined ? 0 : el.data('zoomstart'),
				zoomend = el.data('zoomend')==undefined ? 0 : el.data('zoomend'),
				speed = el.data('speed')==undefined ? 2 : el.data('speed'),
				easing = el.data('easing')==undefined ? punchgs.Power2.easeInOut : el.data('easing');

			_._loop_timeline.append(new punchgs.TweenLite.fromTo(el,speed,{force3D:"auto",scale:zoomstart},{scale:zoomend,ease:easing}));
			_._loop_timeline.append(new punchgs.TweenLite.fromTo(el,speed,{force3D:"auto",scale:zoomend},{scale:zoomstart,onComplete:function() {
				_._loop_timeline.restart();
			}}));
		}
	}

	if (el.hasClass("rs-wave")) {			
		if (_._loop_timeline==undefined) {
			_._loop_timeline = new punchgs.TimelineLite;

			var angle= el.data('angle')==undefined ? 10 : parseInt(el.data('angle'),0),
				radius = el.data('radius')==undefined ? 10 : parseInt(el.data('radius'),0),
				speed = el.data('speed')==undefined ? -20 : el.data('speed'),
				origin = el.data('origin')==undefined ? "50% 50%" : el.data('origin'),
				ors = origin.split(" "),
				oo = new Object();

				if (ors.length>=1) {
					oo.x = ors[0];
					oo.y = ors[1];
				} else {
					oo.x = "50%";
					oo.y = "50%";
				}
								
				radius = radius * factor;

			var _ox = ((parseInt(oo.x,0)/100)-0.5) * el.width(),
				_oy = ((parseInt(oo.y,0)/100)-0.5) * el.height(), 
				 yo = (-1*radius) + _oy,
				 xo = 0 + _ox,
				 angobj= {a:0, ang : angle, element:el, unit:radius, xoffset:xo, yoffset:yo},
				 ang = parseInt(angle,0),
				 waveanim = new punchgs.TweenLite.fromTo(angobj,speed,{	a:(0+ang)	},{	a:(360+ang),force3D:"auto",ease:punchgs.Linear.easeNone});
			
			waveanim.eventCallback("onUpdate",function(angobj) {				
				var rad = angobj.a * (Math.PI / 180),
					yy = angobj.yoffset+(angobj.unit * (1 - Math.sin(rad))),
					xx = angobj.xoffset+Math.cos(rad) * angobj.unit;
				punchgs.TweenLite.to(angobj.element,0.1,{force3D:"auto",x:xx, y:yy});											
			},[angobj]);
			
			waveanim.eventCallback("onComplete",function(_) {				
				_._loop_timeline.restart();
			},[_]);

			_._loop_timeline.append(waveanim);
		}
	}
}

var killCaptionLoops = function(nextcaption) {
	// SOME LOOPING ANIMATION ON INTERNAL ELEMENTS
	nextcaption.closest('.rs-pendulum, .rs-slideloop, .rs-pulse, .rs-wave').each(function() {
		var _ = this;	
		if (_._loop_timeline!=undefined) {			
				_._loop_timeline.pause();
				_._loop_timeline = null;
			}
		});
}

})(jQuery);