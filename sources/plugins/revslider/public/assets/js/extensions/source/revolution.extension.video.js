/********************************************
 * REVOLUTION 5.2.5.1 EXTENSION - VIDEO FUNCTIONS
 * @version: 2.0.1 (18.10.2016)
 * @requires jquery.themepunch.revolution.js
 * @author ThemePunch
*********************************************/
(function($) {
	"use strict";
var _R = jQuery.fn.revolution,
	_ISM = _R.is_mobile(),
	extension = {	alias:"Video Min JS",
					name:"revolution.extensions.video.min.js",
					min_core: "5.3",
					version:"2.0.1"
			  };



///////////////////////////////////////////
// 	EXTENDED FUNCTIONS AVAILABLE GLOBAL  //
///////////////////////////////////////////
jQuery.extend(true,_R, {

	
	preLoadAudio : function(li,opt) {
		if (_R.compare_version(extension).check==="stop") return false;
		li.find('.tp-audiolayer').each(function() {

			var element = jQuery(this),
				obj = {};
			if (element.find('audio').length===0) {
				obj.src =  element.data('videomp4') !=undefined ? element.data('videomp4')  : '',
				obj.pre = element.data('videopreload') || '';
				if (element.attr('id')===undefined) element.attr('audio-layer-'+Math.round(Math.random()*199999));
				obj.id = element.attr('id');
				obj.status = "prepared";
				obj.start = jQuery.now();
				obj.waittime = element.data('videopreloadwait')*1000 || 5000;


				if (obj.pre=="auto" || obj.pre=="canplaythrough" || obj.pre=="canplay" || obj.pre=="progress") {				
					if (opt.audioqueue===undefined) opt.audioqueue = [];					
					opt.audioqueue.push(obj);
					_R.manageVideoLayer(element,opt);
				}
			}
		});	
	},

	preLoadAudioDone : function(nc,opt,event) {	
		
		if (opt.audioqueue && opt.audioqueue.length>0)
			jQuery.each(opt.audioqueue,function(i,obj) {
				if (nc.data('videomp4') === obj.src && (obj.pre === event || obj.pre==="auto")) {				
					obj.status = "loaded";
				}
			});
	},

	resetVideo : function(_nc,opt) {	
		var _ = _nc.data();	
		switch (_.videotype) {
			case "youtube":
				
				var player=_.player;
			 	try{
					if (_.forcerewind=="on") {  //Removed Force Rewind Protection for Handy here !!!
						var s = getStartSec(_nc.data('videostartat')),
							wasdead = s==-1 ? true : false,
							forceseek =  _.bgvideo===1 || _nc.find('.tp-videoposter').length>0 ? true : false;
						s= s==-1 ? 0 : s;											
						if (_.player!=undefined) {							
							if ((s!==0 && !wasdead) || forceseek) {										
								_.player.seekTo(s);													
								_.player.pauseVideo();
							}
						}
					}					
				} catch(e) {}
				if (_nc.find('.tp-videoposter').length==0 && _.bgvideo!==1) 
					punchgs.TweenLite.to(_nc.find('iframe'),0.3,{autoAlpha:1,display:"block",ease:punchgs.Power3.easeInOut});	
				
			break;

			case "vimeo":
				var f = $f(_nc.find('iframe').attr("id"));	
			 	try{
					if (_.forcerewind=="on") 	{	  //Removed Force Rewind Protection for Handy here !!!					
						var s = getStartSec(_.videostartat),
							ct = 0,
							wasdead = s==-1 ? true : false,
							forceseek =  _.bgvideo===1 || _nc.find('.tp-videoposter').length>0 ? true : false;
						s= s==-1 ? 0 : s;		
						if ((s!==0 && !wasdead) || forceseek) {	
							f.api("seekTo",s);								
							f.api("pause");				
						}					
					}					
				} catch(e) {}
				if (_nc.find('.tp-videoposter').length==0 && _.bgvideo!==1)
					punchgs.TweenLite.to(_nc.find('iframe'),0.3,{autoAlpha:1,display:"block",ease:punchgs.Power3.easeInOut});
			break;

			case "html5":
				if (_ISM && _.disablevideoonmobile==1) return false;			
		
				var tag = _.audio=="html5" ? "audio" : "video",
					jvideo = _nc.find(tag),
					video = jvideo[0];

				
				punchgs.TweenLite.to(jvideo,0.3,{autoAlpha:1,display:"block",ease:punchgs.Power3.easeInOut});
				
				if (_.forcerewind=="on" && !_nc.hasClass("videoisplaying")) {
					try{
						
						var s = getStartSec(_.videostartat);					
						video.currentTime = s == -1 ? 0 : s;	
					} catch(e) {}
				}

				if (_.volume=="mute" || _R.lastToggleState(_nc.videomutetoggledby) || opt.globalmute===true)
					video.muted = true;			
			break;
		}
	},


	isVideoMuted : function(_nc,opt) {
		var muted = false,
			_ = _nc.data();
		switch (_.videotype) {
			case "youtube":
				try{
					var player=_.player;	
					muted = player.isMuted();										
				} catch(e) {}
			break;
			case "vimeo":
				try{
					var f = $f(_nc.find('iframe').attr("id"));
					if (_.volume=="mute")
						muted = true;	
					
				} catch(e) {}
			break;
			case "html5":
				var tag = _.audio=="html5" ? "audio" : "video",
					jvideo = _nc.find(tag),
					video = jvideo[0];

				if (video.muted)
					muted = true;							
			break;
		}	
		return muted;	
	},

	muteVideo : function(_nc,opt) {		
		var _ = _nc.data();	
		switch (_.videotype) {
			case "youtube":
				try{
					var player=_.player;	
					
					player.mute();										
				} catch(e) {}
			break;
			case "vimeo":
				try{
					var f = $f(_nc.find('iframe').attr("id"));
					_nc.data('volume',"mute");
					f.api('setVolume',0);
				} catch(e) {}
			break;
			case "html5":
				var tag = _.audio=="html5" ? "audio" : "video",
					jvideo = _nc.find(tag),
					video = jvideo[0];
				video.muted = true;
			break;
		}		
	},

	unMuteVideo : function(_nc,opt) {	
		if (opt.globalmute===true) return;
		var _ = _nc.data();
		switch (_.videotype) {
			case "youtube":
				try{
					var player=_.player;						
					player.unMute();										
				} catch(e) {}
			break;
			case "vimeo":
				try{
					var f = $f(_nc.find('iframe').attr("id"));
					_nc.data('volume',"1");
					f.api('setVolume',1);					
				} catch(e) {}
			break;
			case "html5":
				var tag = _.audio=="html5" ? "audio" : "video",
					jvideo = _nc.find(tag),
					video = jvideo[0];
				video.muted = false;
			break;
		}		
	},

	



	stopVideo : function(_nc,opt) {	
		var _ = _nc.data();
		if (!opt.leaveViewPortBasedStop) 
			opt.lastplayedvideos = [];

		opt.leaveViewPortBasedStop = false;
		
		switch (_.videotype) {
			case "youtube":

				//if (_ISM) return;
				try{

					var player=_.player;	
					
					if (player.getPlayerState()===2 || player.getPlayerState()===5) return;
					player.pauseVideo();	
					_.youtubepausecalled = true;
					setTimeout(function() {
						_.youtubepausecalled=false;
					},80);										
				} catch(e) {
					console.log("Issue at YouTube Video Pause:");
					console.log(e);
				}
			break;
			case "vimeo":

				try{
					var f = $f(_nc.find('iframe').attr("id"));
					f.api("pause");
					_.vimeopausecalled = true;
					setTimeout(function() {
						_.vimeopausecalled=false;
					},80);					

				} catch(e) { 
					console.log("Issue at Vimeo Video Pause:");
					console.log(e);
				}
			break;
			case "html5":
				var tag = _.audio=="html5" ? "audio" : "video",
					jvideo = _nc.find(tag),
					video = jvideo[0];
				if (jvideo!=undefined && video!=undefined) {
					
					video.pause();						
				}
			break;
		}		
	},

	playVideo : function(_nc,opt) {		

		clearTimeout(_nc.data('videoplaywait'));		
		var _ = _nc.data();
		switch (_.videotype) {
			case "youtube":				

				if (_nc.find('iframe').length==0) {
					_nc.append(_nc.data('videomarkup'));						
					addVideoListener(_nc,opt,true);
				} else {										
					if (_.player.playVideo !=undefined) {									
						
						var s = getStartSec(_nc.data('videostartat')),
							ct = _.player.getCurrentTime();
							if (_nc.data('nextslideatend-triggered')==1) {
								ct=-1;
								_nc.data('nextslideatend-triggered',0);
							}
						if (s!=-1 && s>ct) _.player.seekTo(s);			
						if (_.youtubepausecalled!==true)
							_.player.playVideo();
					} else {
						_nc.data('videoplaywait',setTimeout(function() {							
							if (_.youtubepausecalled!==true) _R.playVideo(_nc,opt);
						},50));
					}
				}
			break;
			case "vimeo":		
				
				if (_nc.find('iframe').length==0) {							
					_nc.append(_nc.data('videomarkup'));			
					addVideoListener(_nc,opt,true);
					
				} else {	
						if (_nc.hasClass("rs-apiready")) {
							var id = _nc.find('iframe').attr("id"),
								f = $f(id);												
								if (f.api("play")==undefined) {																
										_nc.data('videoplaywait',setTimeout(function() {	
											if (_.vimeopausecalled!==true)
												_R.playVideo(_nc,opt);
										},50));								
								} else {																																											
									setTimeout(function() {			
										
										f.api("play");
										var s = getStartSec(_nc.data('videostartat')),
											ct = _nc.data('currenttime');										
										if (_nc.data('nextslideatend-triggered')==1) {
											ct=-1;
											_nc.data('nextslideatend-triggered',0);
										}
										if (s!=-1 && s>ct) f.api("seekTo",s);		
									},510);	
								}																	
						} else {
							_nc.data('videoplaywait',setTimeout(function() {	
								if (_.vimeopausecalled!==true)
								_R.playVideo(_nc,opt);
							},50));
						}
				}
			break;
			case "html5":
				if (_ISM && _nc.data('disablevideoonmobile')==1) return false;			

				
				var tag = _.audio=="html5" ? "audio" : "video",
					jvideo = _nc.find(tag),
					video = jvideo[0],
					html5vid = jvideo.parent();

				if (html5vid.data('metaloaded') != 1) {						
					addEvent(video,'loadedmetadata',function(_nc) {								
						_R.resetVideo(_nc,opt);
						video.play();
						var s = getStartSec(_nc.data('videostartat')),
							ct = video.currentTime;
						if (_nc.data('nextslideatend-triggered')==1) {
								ct=-1;
								_nc.data('nextslideatend-triggered',0);
							}
						if (s!=-1 && s>ct) video.currentTime = s;
					}(_nc));
				} else {		
					video.play();					
					var s = getStartSec(_nc.data('videostartat')),
						ct = video.currentTime;
					if (_nc.data('nextslideatend-triggered')==1) {
							ct=-1;
							_nc.data('nextslideatend-triggered',0);
						}
					if (s!=-1 && s>ct) video.currentTime = s;										
				}
			break;
		}
	},

	isVideoPlaying : function(_nc,opt) {
		
		var ret = false;
		if (opt.playingvideos != undefined) {
			jQuery.each(opt.playingvideos,function(i,nc) {
				if (_nc.attr('id') == nc.attr('id'))					
					ret = true;													
			});
		}		
		return ret;
	},

	removeMediaFromList : function(_nc,opt) {
		remVidfromList(_nc,opt);
	},

	prepareCoveredVideo : function(asprat,opt,nextcaption) {		
		var ifr = nextcaption.find('iframe, video'),
			wa = asprat.split(':')[0],
			ha = asprat.split(':')[1],
			li = nextcaption.closest('.tp-revslider-slidesli'),
			od = li.width()/li.height(),
			vd = wa/ha,
			nvh = (od/vd)*100,
			nvw = (vd/od)*100;	

		if (od>vd) 																
			punchgs.TweenLite.to(ifr,0.001,{height:nvh+"%", width:"100%", top:-(nvh-100)/2+"%",left:"0px",position:"absolute"});
		else 
			punchgs.TweenLite.to(ifr,0.001,{width:nvw+"%", height:"100%", left:-(nvw-100)/2+"%",top:"0px",position:"absolute"});
		
		if (!ifr.hasClass("resizelistener")) {			
			ifr.addClass("resizelistener");		
			jQuery(window).resize(function() {
				clearTimeout(ifr.data('resizelistener'));
				ifr.data('resizelistener',setTimeout(function() {
					_R.prepareCoveredVideo(asprat,opt,nextcaption);
				},30));				
			})
		}
	},

	checkVideoApis : function(_nc,opt,addedApis) {		
		var httpprefix = location.protocol === 'https:' ? "https" : "http";
				
		if ((_nc.data('ytid')!=undefined  || _nc.find('iframe').length>0 && _nc.find('iframe').attr('src').toLowerCase().indexOf('youtube')>0)) opt.youtubeapineeded = true;
		if ((_nc.data('ytid')!=undefined  || _nc.find('iframe').length>0 &&  _nc.find('iframe').attr('src').toLowerCase().indexOf('youtube')>0) && addedApis.addedyt==0) {
			opt.youtubestarttime = jQuery.now();
			addedApis.addedyt=1;
			var s = document.createElement("script");								
			s.src = "https://www.youtube.com/iframe_api"; /* Load Player API*/
			var before = document.getElementsByTagName("script")[0],
				loadit = true;
			jQuery('head').find('*').each(function(){
				if (jQuery(this).attr('src') == "https://www.youtube.com/iframe_api")
				   loadit = false;
			});
			if (loadit) before.parentNode.insertBefore(s, before);

		}



		if ((_nc.data('vimeoid')!=undefined || _nc.find('iframe').length>0 && _nc.find('iframe').attr('src').toLowerCase().indexOf('vimeo')>0)) opt.vimeoapineeded = true;	
	  	if ((_nc.data('vimeoid')!=undefined || _nc.find('iframe').length>0 && _nc.find('iframe').attr('src').toLowerCase().indexOf('vimeo')>0) && addedApis.addedvim==0) {
			opt.vimeostarttime = jQuery.now();
			addedApis.addedvim=1;
			var f = document.createElement("script"),
				before = document.getElementsByTagName("script")[0],
				loadit = true;
			f.src = "https://secure-a.vimeocdn.com/js/froogaloop2.min.js"; /* Load Player API*/							

			jQuery('head').find('*').each(function(){
				if (jQuery(this).attr('src') == "https://secure-a.vimeocdn.com/js/froogaloop2.min.js")
				   loadit = false;
			});
			if (loadit)
				before.parentNode.insertBefore(f, before);
		}
		return addedApis;
	},

	manageVideoLayer : function(_nc,opt,recalled,internrecalled) {	
		if (_R.compare_version(extension).check==="stop") return false;			
		// YOUTUBE AND VIMEO LISTENRES INITIALISATION		
		var _ = _nc.data(),
			vida = _.videoattributes,
			vidytid = _.ytid,
			vimeoid = _.vimeoid,
			videopreload = _.videopreload === "auto" || _.videopreload === "canplay" || _.videopreload === "canplaythrough" || _.videopreload === "progress" ? "auto" : _.videopreload,
			videomp = _.videomp4,
			videowebm = _.videowebm,
			videoogv = _.videoogv,
			videoafs = _.allowfullscreenvideo,
			videocontrols = _.videocontrols,
			httpprefix = "http",
			videoloop = _.videoloop=="loop" ? "loop" : _.videoloop=="loopandnoslidestop" ? "loop" : "",
			videotype = (videomp!=undefined || videowebm!=undefined) ? "html5" : 
						(vidytid!=undefined && String(vidytid).length>1) ? "youtube" : 
						(vimeoid!=undefined && String(vimeoid).length>1) ? "vimeo" : "none",
			tag = _.audio=="html5" ? "audio" : "video",
			newvideotype = (videotype=="html5" && _nc.find(tag).length==0) ? "html5" : 
						(videotype=="youtube" && _nc.find('iframe').length==0) ? "youtube" : 
						(videotype=="vimeo" && _nc.find('iframe').length==0) ? "vimeo" : "none";

			// VideLoop reset if Next Slide at End is set ! 
			videoloop = _.nextslideatend === true ? "" : videoloop;


		_.videotype = videotype;
		// ADD HTML5 VIDEO IF NEEDED
		switch (newvideotype) {
			case "html5":

				if (videocontrols!="controls") videocontrols="";
				var tag = "video"

				//_nc.data('audio',"html5");
				if (_.audio=="html5") {
					tag = "audio";
					_nc.addClass("tp-audio-html5");
				}
				
				var apptxt = '<'+tag+' style="object-fit:cover;background-size:cover;visible:hidden;width:100%; height:100%" class="" '+videoloop+' preload="'+videopreload+'">';

				if (videopreload=="auto") opt.mediapreload = true;
				//if (_.videoposter!=undefined) apptxt = apptxt + 'poster="'+_nc.data('videoposter')+'">';
				if (videowebm!=undefined && _R.get_browser().toLowerCase()=="firefox") apptxt = apptxt + '<source src="'+videowebm+'" type="video/webm" />';
				if (videomp!=undefined) apptxt = apptxt + '<source src="'+videomp+'" type="video/mp4" />';
				if (videoogv!=undefined) apptxt = apptxt + '<source src="'+videoogv+'" type="video/ogg" />';
				apptxt = apptxt + '</'+tag+'>';
				var hfm ="";
				if (videoafs==="true" ||  videoafs===true)
					hfm = '<div class="tp-video-button-wrap"><button  type="button" class="tp-video-button tp-vid-full-screen">Full-Screen</button></div>';

				if (videocontrols=="controls")
					apptxt = apptxt + ('<div class="tp-video-controls">'+
										  '<div class="tp-video-button-wrap"><button type="button" class="tp-video-button tp-vid-play-pause">Play</button></div>'+
										  '<div class="tp-video-seek-bar-wrap"><input  type="range" class="tp-seek-bar" value="0"></div>'+
										  '<div class="tp-video-button-wrap"><button  type="button" class="tp-video-button tp-vid-mute">Mute</button></div>'+
										  '<div class="tp-video-vol-bar-wrap"><input  type="range" class="tp-volume-bar" min="0" max="1" step="0.1" value="1"></div>'+
										  hfm+
										  '</div>');
				
				_nc.data('videomarkup',apptxt)
				_nc.append(apptxt);

				// START OF HTML5 VIDEOS
				if ((_ISM && _nc.data('disablevideoonmobile')==1) ||_R.isIE(8)) _nc.find(tag).remove();

				// ADD HTML5 VIDEO CONTAINER				
				_nc.find(tag).each(function(i) {
					var video = this,
						jvideo = jQuery(this);

					if (!jvideo.parent().hasClass("html5vid"))
						jvideo.wrap('<div class="html5vid" style="position:relative;top:0px;left:0px;width:100%;height:100%; overflow:hidden;"></div>');

					var html5vid = jvideo.parent();
					if (html5vid.data('metaloaded') != 1) {
						addEvent(video,'loadedmetadata',function(_nc) {		
							htmlvideoevents(_nc,opt);
							_R.resetVideo(_nc,opt);						
						}(_nc));
					} 								
				});			
			break;
			case "youtube":
				httpprefix = "https";	
			/*	if (location.protocol === 'https:')	
					httpprefix = "https";		*/
				if (videocontrols=="none") {					
			 		vida = vida.replace("controls=1","controls=0");
			 		if (vida.toLowerCase().indexOf('controls')==-1)
			 		  vida = vida+"&controls=0";
			 	}
			 	if (_.videoinline===true || _.videoinline==="true" || _.videoinline===1)
			 		vida = vida + "&playsinline=1";
			 	var	s = getStartSec(_nc.data('videostartat')),
			 		e = getStartSec(_nc.data('videoendat'));
							 	
			 	if (s!=-1) vida=vida+"&start="+s;
			 	if (e!=-1) vida=vida+"&end="+e;

				// CHECK VIDEO ORIGIN, AND EXTEND WITH WWW IN CASE IT IS MISSING !
			 	var orig = vida.split('origin='+httpprefix+'://'),
			 		vida_new = "";
			 				 	
			 	if (orig.length>1) {
			 		vida_new = orig[0]+'origin='+httpprefix+'://';
			 		if (self.location.href.match(/www/gi) && !orig[1].match(/www/gi)) 						 	 						 		
			 				vida_new=vida_new+"www."
			 		vida_new=vida_new+orig[1];
			 	} else {
			 		vida_new = vida;
			 	}	
			 	
			 	var yafv = videoafs==="true" ||  videoafs===true ? "allowfullscreen" : "";		 	
			 	_nc.data('videomarkup','<iframe style="visible:hidden" type="text/html" src="'+httpprefix+'://www.youtube.com/embed/'+vidytid+'?'+vida_new+'" '+yafv+' width="100%" height="100%" style="width:100%;height:100%"></iframe>');
			break;

			case "vimeo":
			//	if (location.protocol === 'https:')
				httpprefix = "https";												
				_nc.data('videomarkup','<iframe style="visible:hidden" src="'+httpprefix+'://player.vimeo.com/video/'+vimeoid+'?autoplay=0&'+vida+'" webkitallowfullscreen mozallowfullscreen allowfullscreen width="100%" height="100%" style="100%;height:100%"></iframe>');
				
			break;
		}
		
		//if (videotype=="vimeo" || videotype=="youtube") {
		
		// IF VIDEOPOSTER EXISTING		
		var noposteronmobile = _ISM && _nc.data('noposteronmobile')=="on";
		
		if (_.videoposter!=undefined && _.videoposter.length>2 && !noposteronmobile) {
			if (_nc.find('.tp-videoposter').length==0)
				_nc.append('<div class="tp-videoposter noSwipe" style="cursor:pointer; position:absolute;top:0px;left:0px;width:100%;height:100%;z-index:3;background-image:url('+_.videoposter+'); background-size:cover;background-position:center center;"></div>');				
			if (_nc.find('iframe').length==0)
			_nc.find('.tp-videoposter').click(function() {					
				_R.playVideo(_nc,opt);															
				if (_ISM) {
					if (_nc.data('disablevideoonmobile')==1) return false;						
					punchgs.TweenLite.to(_nc.find('.tp-videoposter'),0.3,{autoAlpha:0,force3D:"auto",ease:punchgs.Power3.easeInOut});
					punchgs.TweenLite.to(_nc.find('iframe'),0.3,{autoAlpha:1,display:"block",ease:punchgs.Power3.easeInOut});
				}
			})
		} else {
			if  (_ISM && _nc.data('disablevideoonmobile')==1) return false;			
			if (_nc.find('iframe').length==0 && (videotype=="youtube" || videotype=="vimeo")) {				
				_nc.append(_nc.data('videomarkup'));
				addVideoListener(_nc,opt,false);
			}
		}
		
		// ADD DOTTED OVERLAY IF NEEDED
		if (_nc.data('dottedoverlay')!="none" && _nc.data('dottedoverlay')!=undefined && _nc.find('.tp-dottedoverlay').length!=1)
			_nc.append('<div class="tp-dottedoverlay '+_nc.data('dottedoverlay')+'"></div>');
		
		_nc.addClass("HasListener");	

		if (_nc.data('bgvideo')==1) {
			punchgs.TweenLite.set(_nc.find('video, iframe'),{autoAlpha:0});
		}
	}
	
});





//////////////////////////////////////////////////////
// * Revolution Slider - VIDEO / API FUNCTIONS		//
// * @version: 1.0 (30.10.2014)						//
// * @author ThemePunch								//
//////////////////////////////////////////////////////

function getStartSec(st) {						
	return st == undefined ? -1 :jQuery.isNumeric(st) ? st : st.split(":").length>1 ? parseInt(st.split(":")[0],0)*60 + parseInt(st.split(":")[1],0) : st;
};

// 	-	VIMEO ADD EVENT /////
var addEvent = function(element, eventName, callback) {
	if (element.addEventListener)
		element.addEventListener(eventName, callback, {capture:false,passive:true});
	else
		element.attachEvent(eventName, callback, {capture:false,passive:true});
};

var getVideoDatas = function(p,t,d) {
	var a = {};
	a.video = p;
	a.videotype = t;
	a.settings = d;
	return a;
}


var addVideoListener = function(_nc,opt,startnow) {
	
	var _=_nc.data(),
		ifr = _nc.find('iframe'),
		frameID = "iframe"+Math.round(Math.random()*100000+1),
		loop = _.videoloop,
		pforv = loop != "loopandnoslidestop";

	
	loop = loop =="loop" ||  loop =="loopandnoslidestop";
	

	// CARE ABOUT ASPECT RATIO

	if (_nc.data('forcecover')==1) {
		_nc.removeClass("fullscreenvideo").addClass("coverscreenvideo");			
		var asprat = _nc.data('aspectratio');														
		if (asprat!=undefined && asprat.split(":").length>1) 			
			_R.prepareCoveredVideo(asprat,opt,_nc);
	}
	
	if (_nc.data('bgvideo')==1) {
		var asprat = _nc.data('aspectratio');														
		if (asprat!=undefined && asprat.split(":").length>1) 			
			_R.prepareCoveredVideo(asprat,opt,_nc);
	}



	// IF LISTENER DOES NOT EXIST YET			
	ifr.attr('id',frameID);		

	if (startnow) _nc.data('startvideonow',true);

	if (_nc.data('videolistenerexist')!==1) {	
		switch (_.videotype) {
			// YOUTUBE LISTENER
			case "youtube":				
				var player = new YT.Player(frameID, {
					events: {
						"onStateChange": function(event) {		
														
							var container = _nc.closest('.tp-simpleresponsive'),
								videorate = _.videorate,
								videostart = _nc.data('videostart'),							 								 	
							 	fsmode = checkfullscreenEnabled();
							 	
							if (event.data == YT.PlayerState.PLAYING) {								
								punchgs.TweenLite.to(_nc.find('.tp-videoposter'),0.3,{autoAlpha:0,force3D:"auto",ease:punchgs.Power3.easeInOut});
								punchgs.TweenLite.to(_nc.find('iframe'),0.3,{autoAlpha:1,display:"block",ease:punchgs.Power3.easeInOut});							
								if (_nc.data('volume')=="mute" || _R.lastToggleState(_nc.data('videomutetoggledby')) || opt.globalmute===true) {
									  player.mute();									  
								 } else {
									  player.unMute();
									  player.setVolume(parseInt(_nc.data('volume'),0) || 75);
								}

								opt.videoplaying=true;									
								addVidtoList(_nc,opt);	
								if (pforv) 
									opt.c.trigger('stoptimer');
								else
									opt.videoplaying=false;								
																	
								opt.c.trigger('revolution.slide.onvideoplay',getVideoDatas(player,"youtube",_nc.data()));
								_R.toggleState(_.videotoggledby);													
							} else {							
								if (event.data==0 && loop) {
									//player.playVideo();
									var s = getStartSec(_nc.data('videostartat'));
									if (s!=-1) player.seekTo(s);
									player.playVideo();		
									_R.toggleState(_.videotoggledby);							
								}
								
								if (!fsmode && (event.data==0 || event.data==2) && _nc.data('showcoveronpause')=="on" && _nc.find('.tp-videoposter').length>0) {																
									punchgs.TweenLite.to(_nc.find('.tp-videoposter'),0.3,{autoAlpha:1,force3D:"auto",ease:punchgs.Power3.easeInOut});
									punchgs.TweenLite.to(_nc.find('iframe'),0.3,{autoAlpha:0,ease:punchgs.Power3.easeInOut});																			
								} 
								if ((event.data!=-1 && event.data!=3)) {
																		
									opt.videoplaying=false;									
									opt.tonpause = false;
									
									remVidfromList(_nc,opt);
									container.trigger('starttimer');
									opt.c.trigger('revolution.slide.onvideostop',getVideoDatas(player,"youtube",_nc.data()));
									
									if (opt.currentLayerVideoIsPlaying==undefined || opt.currentLayerVideoIsPlaying.attr("id") == _nc.attr("id"))									
										_R.unToggleState(_.videotoggledby);
									
								} 
								
								if (event.data==0 && _nc.data('nextslideatend')==true) {
									exitFullscreen();
									_nc.data('nextslideatend-triggered',1);
									opt.c.revnext();
									remVidfromList(_nc,opt);
								} else {									
									remVidfromList(_nc,opt);
									opt.videoplaying=false;
									container.trigger('starttimer');
									opt.c.trigger('revolution.slide.onvideostop',getVideoDatas(player,"youtube",_nc.data()));
									if (opt.currentLayerVideoIsPlaying==undefined || opt.currentLayerVideoIsPlaying.attr("id") == _nc.attr("id"))									
										_R.unToggleState(_.videotoggledby);
								}
							}
						},
						'onReady': function(event) {	
							
							
							var videorate = _.videorate,
								videostart = _nc.data('videostart');
								
							_nc.addClass("rs-apiready");
							if (videorate!=undefined)
								event.target.setPlaybackRate(parseFloat(videorate));
							
							// PLAY VIDEO IF THUMBNAIL HAS BEEN CLICKED
							_nc.find('.tp-videoposter').unbind("click");
							_nc.find('.tp-videoposter').click(function() {										
								 if (!_ISM) {
									 player.playVideo();
								}
							})

							if (_nc.data('startvideonow')) {
								
								_.player.playVideo();	
								var s = getStartSec(_nc.data('videostartat'));
								if (s!=-1) _.player.seekTo(s);
								//_nc.find('.tp-videoposter').click();
							}
							_nc.data('videolistenerexist',1);					
						}
					}
				});			
				_nc.data('player',player);
			break;

			// VIMEO LISTENER
			case "vimeo":
				var isrc = ifr.attr('src'),
					queryParameters = {}, queryString = isrc,
					re = /([^&=]+)=([^&]*)/g, m;
				// Creates a map with the query string parameters
				while (m = re.exec(queryString)) {
					queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
				}
				if (queryParameters['player_id']!=undefined)
					isrc = isrc.replace(queryParameters['player_id'],frameID);
				else
					isrc=isrc+"&player_id="+frameID;
				try{ isrc = isrc.replace('api=0','api=1'); } catch(e) {}
				isrc=isrc+"&api=1";
				ifr.attr('src',isrc);
				
			
				var player = _nc.find('iframe')[0],
					vimcont = jQuery('#'+frameID),
					f = $f(frameID);				

				f.addEvent('ready', function(){	
						
					_nc.addClass("rs-apiready");
					f.addEvent('play', function(data) {							
						_nc.data('nextslidecalled',0);
						punchgs.TweenLite.to(_nc.find('.tp-videoposter'),0.3,{autoAlpha:0,force3D:"auto",ease:punchgs.Power3.easeInOut});
						punchgs.TweenLite.to(_nc.find('iframe'),0.3,{autoAlpha:1,display:"block",ease:punchgs.Power3.easeInOut});							
						opt.c.trigger('revolution.slide.onvideoplay',getVideoDatas(f,"vimeo",_nc.data()));
						opt.videoplaying=true;
						
						addVidtoList(_nc,opt);
						if (pforv) 
							opt.c.trigger('stoptimer');
						else
							opt.videoplaying=false;
						if (_nc.data('volume')=="mute" || _R.lastToggleState(_nc.data('videomutetoggledby')) || opt.globalmute===true)
						  f.api('setVolume',"0")
						else
						  f.api('setVolume',(parseInt(_nc.data('volume'),0)/100 || 0.75));
						_R.toggleState(_.videotoggledby);
					});

					f.addEvent('playProgress',function(data) {					
						var et = getStartSec(_nc.data('videoendat'))							
						
						_nc.data('currenttime',data.seconds);
						if (et!=0 && (Math.abs(et-data.seconds) <0.3 && et>data.seconds) && _nc.data('nextslidecalled') != 1) {																
							if (loop) {								
								
								f.api("play");								
								var s = getStartSec(_nc.data('videostartat'));
								if (s!=-1) f.api("seekTo",s);				
							} else {									
								if (_nc.data('nextslideatend')==true) {	
									_nc.data('nextslideatend-triggered',1);			
									_nc.data('nextslidecalled',1);			
									opt.c.revnext();							
								}
								f.api("pause");
							}
						}
					});

					f.addEvent('finish', function(data) {
							remVidfromList(_nc,opt);
							opt.videoplaying=false;
							opt.c.trigger('starttimer');
							opt.c.trigger('revolution.slide.onvideostop',getVideoDatas(f,"vimeo",_nc.data())); 
							if (_nc.data('nextslideatend')==true) {
								_nc.data('nextslideatend-triggered',1);
								opt.c.revnext();
							}
							if (opt.currentLayerVideoIsPlaying==undefined || opt.currentLayerVideoIsPlaying.attr("id") == _nc.attr("id"))
								_R.unToggleState(_.videotoggledby);
							
					});

					f.addEvent('pause', function(data) {

							if (_nc.find('.tp-videoposter').length>0 && _nc.data('showcoveronpause')=="on") {
								punchgs.TweenLite.to(_nc.find('.tp-videoposter'),0.3,{autoAlpha:1,force3D:"auto",ease:punchgs.Power3.easeInOut});
								punchgs.TweenLite.to(_nc.find('iframe'),0.3,{autoAlpha:0,ease:punchgs.Power3.easeInOut});
							} 
							opt.videoplaying=false;
							opt.tonpause = false;
							
							remVidfromList(_nc,opt);
							opt.c.trigger('starttimer');
							opt.c.trigger('revolution.slide.onvideostop',getVideoDatas(f,"vimeo",_nc.data())); 
							if (opt.currentLayerVideoIsPlaying==undefined || opt.currentLayerVideoIsPlaying.attr("id") == _nc.attr("id"))
								_R.unToggleState(_.videotoggledby);
					});
					
					
					
					_nc.find('.tp-videoposter').unbind("click");
					_nc.find('.tp-videoposter').click(function() {							 
						 if (!_ISM) { 
						 	
						 	f.api("play");
						 	return false;
						 }
					})
					if (_nc.data('startvideonow')) {	
							
							f.api("play");
							var s = getStartSec(_nc.data('videostartat'));
							if (s!=-1) f.api("seekTo",s);					
					}
					_nc.data('videolistenerexist',1);
				});
			break;
		}
	} else {
		var s = getStartSec(_nc.data('videostartat'));
		switch (_.videotype) {
			// YOUTUBE LISTENER
			case "youtube":
				if (startnow) {
					_.player.playVideo();	
					if (s!=-1) _.player.seekTo()
				}
			break;
			case "vimeo":
				if (startnow) {
					
					var f = $f(_nc.find('iframe').attr("id"));	
					f.api("play");					
					if (s!=-1) f.api("seekTo",s);					
				}
			break;
		}
	}
}


var exitFullscreen = function() {
  if(document.exitFullscreen) {
    document.exitFullscreen();
  } else if(document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if(document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
  }
}


var checkfullscreenEnabled = function() {
   try{
	    // FF provides nice flag, maybe others will add support for this later on?
	    if(window['fullScreen'] !== undefined) {
	      return window.fullScreen;
	    }
	    // 5px height margin, just in case (needed by e.g. IE)
	    var heightMargin = 5;
	    if(jQuery.browser.webkit && /Apple Computer/.test(navigator.vendor)) {
	      // Safari in full screen mode shows the navigation bar, 
	      // which is 40px  
	      heightMargin = 42;
	    }
	    return screen.width == window.innerWidth &&
	        Math.abs(screen.height - window.innerHeight) < heightMargin;
	  } catch(e) {

	  }
  }
/////////////////////////////////////////	HTML5 VIDEOS 	///////////////////////////////////////////	

var htmlvideoevents = function(_nc,opt,startnow) {



	if (_ISM && _nc.data('disablevideoonmobile')==1) return false;			
	var _ = _nc.data(),
		tag = _.audio=="html5" ? "audio" : "video",
		jvideo = _nc.find(tag),
		video = jvideo[0],
		html5vid = jvideo.parent(),
		loop = _.videoloop,
		pforv = loop != "loopandnoslidestop";

	loop = loop =="loop" ||  loop =="loopandnoslidestop";

	html5vid.data('metaloaded',1);
	// FIRST TIME LOADED THE HTML5 VIDEO

	if (_nc.data('bgvideo')==1 && (_.videoloop==="none" || _.videoloop===false)) 		
		pforv = false;
	
	
								
	
	//PLAY, STOP VIDEO ON CLICK OF PLAY, POSTER ELEMENTS
	if (jvideo.attr('control') == undefined ) {
		if (_nc.find('.tp-video-play-button').length==0 && !_ISM)
			_nc.append('<div class="tp-video-play-button"><i class="revicon-right-dir"></i><span class="tp-revstop">&nbsp;</span></div>');
		_nc.find('video, .tp-poster, .tp-video-play-button').click(function() {
			if (_nc.hasClass("videoisplaying"))
				video.pause();
			else
				video.play();
		})
	}

	// PRESET FULLCOVER VIDEOS ON DEMAND
	if (_nc.data('forcecover')==1 || _nc.hasClass('fullscreenvideo') || _nc.data('bgvideo')==1)  {
		if (_nc.data('forcecover')==1 || _nc.data('bgvideo')==1) {
			html5vid.addClass("fullcoveredvideo");	
			var asprat = _nc.data('aspectratio') || "4:3";				
			_R.prepareCoveredVideo(asprat,opt,_nc);
		}
		else
			html5vid.addClass("fullscreenvideo");				
	}
	

	// FIND CONTROL BUTTONS IN VIDEO, AND ADD EVENT LISTENERS ON THEM
	var playButton = _nc.find('.tp-vid-play-pause')[0],
		muteButton = _nc.find('.tp-vid-mute')[0],
		fullScreenButton = _nc.find('.tp-vid-full-screen')[0],
		seekBar = _nc.find('.tp-seek-bar')[0],
		volumeBar = _nc.find('.tp-volume-bar')[0];

	if (playButton!=undefined) {
		// Event listener for the play/pause button
		addEvent(playButton,"click", function() {
			if (video.paused == true) 
				video.play();
			else
				video.pause();
		});
	}

	if (muteButton!=undefined) {

		// Event listener for the mute button
		addEvent(muteButton,"click", function() {
			if (video.muted == false) {
				video.muted = true;
				muteButton.innerHTML = "Unmute";
			} else {
				video.muted = false;
				muteButton.innerHTML = "Mute";
			}
		});
	}

	if (fullScreenButton!=undefined) {

		// Event listener for the full-screen button
		if (fullScreenButton)
			addEvent(fullScreenButton,"click", function() {
				if (video.requestFullscreen) {
					video.requestFullscreen();
				} else if (video.mozRequestFullScreen) {
					video.mozRequestFullScreen(); // Firefox
				} else if (video.webkitRequestFullscreen) {
					video.webkitRequestFullscreen(); // Chrome and Safari
				}
			});

	}

	if (seekBar !=undefined) {

		// Event listener for the seek bar
		addEvent(seekBar,"change", function() {							
			var time = video.duration * (seekBar.value / 100);							
			video.currentTime = time;											

		});

		// Pause the video when the seek handle is being dragged
		addEvent(seekBar,"mousedown", function() {
			_nc.addClass("seekbardragged");
			video.pause();

		});

		// Play the video when the seek handle is dropped
		addEvent(seekBar,"mouseup", function() {
			_nc.removeClass("seekbardragged");
			video.play();

		});
	}

	addEvent(video,"canplaythrough", function() {
		_R.preLoadAudioDone(_nc,opt,"canplaythrough");
	});

	addEvent(video,"canplay", function() {
		_R.preLoadAudioDone(_nc,opt,"canplay");
	});

	addEvent(video,"progress", function() {
		_R.preLoadAudioDone(_nc,opt,"progress");
	});

	// Update the seek bar as the video plays
	addEvent(video,"timeupdate", function() {						
	
		var value = (100 / video.duration) * video.currentTime,
			et = getStartSec(_nc.data('videoendat')),
			cs  =video.currentTime;	
		if (seekBar != undefined)	
			seekBar.value = value;	
		
		if (et!=0 && et!=-1 && (Math.abs(et-cs) <=0.3 && et>cs) && _nc.data('nextslidecalled') != 1) {			
			if (loop) {
				video.play();
				var s = getStartSec(_nc.data('videostartat'));
				if (s!=-1) video.currentTime = s;				
			} else {

				
				if (_nc.data('nextslideatend')==true) {							
					_nc.data('nextslideatend-triggered',1);		
					_nc.data('nextslidecalled',1);						
					opt.just_called_nextslide_at_htmltimer = true; 
					opt.c.revnext();						
					setTimeout(function() {
						opt.just_called_nextslide_at_htmltimer = false;
					},1000);
				}
				video.pause();
			}
		}
	});

	
	if (volumeBar != undefined) {		

		// Event listener for the volume bar
		addEvent(volumeBar,"change", function() {
			// Update the video volume
			video.volume = volumeBar.value;
		});
	}


	// VIDEO EVENT LISTENER FOR "PLAY"
	addEvent(video,"play",function() {

		
		_nc.data('nextslidecalled',0);
		
		var vol = _nc.data('volume');
		vol = vol!=undefined && vol!="mute" ?parseFloat(vol)/100 : vol;
		
		if (opt.globalmute===true) 
			video.muted = true;
		else
			video.muted = false;

		if (vol>1) vol = vol/100;
		if (vol=="mute")
			video.muted=true;
		else
		if (vol!=undefined) 
			video.volume = vol;



		_nc.addClass("videoisplaying");

		var tag = _.audio=="html5" ? "audio" : "video";

		addVidtoList(_nc,opt);

		if (!pforv || tag=="audio") {				
			opt.videoplaying=false;
			if (tag!="audio")  opt.c.trigger('starttimer');
			opt.c.trigger('revolution.slide.onvideostop',getVideoDatas(video,"html5",_));
		} else {				
			opt.videoplaying=true;
			opt.c.trigger('stoptimer');
			opt.c.trigger('revolution.slide.onvideoplay',getVideoDatas(video,"html5",_));				
		}

		punchgs.TweenLite.to(_nc.find('.tp-videoposter'),0.3,{autoAlpha:0,force3D:"auto",ease:punchgs.Power3.easeInOut});
		punchgs.TweenLite.to(_nc.find(tag),0.3,{autoAlpha:1,display:"block",ease:punchgs.Power3.easeInOut});	

		var playButton = _nc.find('.tp-vid-play-pause')[0],
			muteButton = _nc.find('.tp-vid-mute')[0];
		if (playButton!=undefined)
			playButton.innerHTML = "Pause";
		if (muteButton!=undefined && video.muted)
			muteButton.innerHTML = "Unmute";

		_R.toggleState(_.videotoggledby);
	});

	// VIDEO EVENT LISTENER FOR "PAUSE"
	addEvent(video,"pause",function() {
		
		var tag = _.audio=="html5" ? "audio" : "video",
			fsmode = checkfullscreenEnabled();
		

		if (!fsmode && _nc.find('.tp-videoposter').length>0 && _nc.data('showcoveronpause')=="on" && !_nc.hasClass("seekbardragged")) {
			punchgs.TweenLite.to(_nc.find('.tp-videoposter'),0.3,{autoAlpha:1,force3D:"auto",ease:punchgs.Power3.easeInOut});
			punchgs.TweenLite.to(_nc.find(tag),0.3,{autoAlpha:0,ease:punchgs.Power3.easeInOut});
		} 
		
		_nc.removeClass("videoisplaying");
		opt.videoplaying=false;
		remVidfromList(_nc,opt);
		if (tag!="audio")  opt.c.trigger('starttimer');
		opt.c.trigger('revolution.slide.onvideostop',getVideoDatas(video,"html5",_nc.data()));
		var playButton = _nc.find('.tp-vid-play-pause')[0];
		if (playButton!=undefined)
			playButton.innerHTML = "Play";		

		if (opt.currentLayerVideoIsPlaying==undefined || opt.currentLayerVideoIsPlaying.attr("id") == _nc.attr("id"))
			_R.unToggleState(_.videotoggledby);
	});

	// VIDEO EVENT LISTENER FOR "END"
	

	addEvent(video,"ended",function() {		
		exitFullscreen();
		
		remVidfromList(_nc,opt);
		opt.videoplaying=false;
		remVidfromList(_nc,opt);
		if (tag!="audio") opt.c.trigger('starttimer');
		opt.c.trigger('revolution.slide.onvideostop',getVideoDatas(video,"html5",_nc.data()));


		if (_nc.data('nextslideatend')===true && video.currentTime>0) {	
			
			if (!opt.just_called_nextslide_at_htmltimer==true) {
				_nc.data('nextslideatend-triggered',1);
				opt.c.revnext();
				opt.just_called_nextslide_at_htmltimer = true;
			}			
			setTimeout(function() {				
				opt.just_called_nextslide_at_htmltimer = false;
			},1500)
		}
		_nc.removeClass("videoisplaying");
		
		
	});		
}



var addVidtoList = function(_nc,opt) {

	if (opt.playingvideos == undefined) opt.playingvideos = new Array();		
	
	// STOP OTHER VIDEOS
	if (_nc.data('stopallvideos')) {		
		if (opt.playingvideos != undefined && opt.playingvideos.length>0) { 
			opt.lastplayedvideos = jQuery.extend(true,[],opt.playingvideos);
			jQuery.each(opt.playingvideos,function(i,_nc) {
				_R.stopVideo(_nc,opt);
			});
		}			
	}	
	opt.playingvideos.push(_nc);	
	opt.currentLayerVideoIsPlaying = _nc;		
	
}


var remVidfromList = function(_nc,opt) {			
	if (opt.playingvideos != undefined && jQuery.inArray(_nc,opt.playingvideos)>=0)
		opt.playingvideos.splice(jQuery.inArray(_nc,opt.playingvideos),1);		
}





	

})(jQuery);