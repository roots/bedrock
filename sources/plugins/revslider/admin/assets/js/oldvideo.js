var jvideo = jQuery(this);
var video = this;

if (!jvideo.parent().hasClass("html5vid")) {
	jvideo.wrap('<div class="html5vid" style="position:relative;top:0px;left:0px;width:auto;height:auto"></div>');

}
var html5vid = jQuery(this).parent();

// WAITING FOR META DATAS
if (video.addEventListener)
	video.addEventListener("loadedmetadata",function() {
		html5vid.data('metaloaded',1);
	});
else
	video.attachEvent("loadedmetadata",function() {
		html5vid.data('metaloaded',1);
	});


if (!jvideo.hasClass("HasListener")) {
	jvideo.addClass("HasListener");
	
	if (nextcaption.data('dottedoverlay')!="none" && nextcaption.data('dottedoverlay')!=undefined)
	if (nextcaption.find('.tp-dottedoverlay').length!=1)
		html5vid.append('<div class="tp-dottedoverlay '+nextcaption.data('dottedoverlay')+'"></div>');

	if (jvideo.attr('control') == undefined ) { 
		if (html5vid.find('.tp-video-play-button').length==0)
			html5vid.append('<div class="tp-video-play-button"><i class="revicon-right-dir"></i><div class="tp-revstop"></div></div>');
		html5vid.find('video, .tp-poster, .tp-video-play-button').click(function() {
			if (html5vid.hasClass("videoisplaying"))
				video.pause();
			else
				video.play();
		})

	}
	
	if (nextcaption.data('forcecover')==1 || nextcaption.hasClass('fullscreenvideo'))  {
		if (nextcaption.data('forcecover')==1) {
			updateHTML5Size(html5vid,opt.container);
			html5vid.addClass("fullcoveredvideo");
			nextcaption.addClass("fullcoveredvideo");
		}															
		html5vid.css({width:"100%", height:"100%"});
	}

	
	video.addEventListener("play",function() {
		html5vid.addClass("videoisplaying");
		punchgs.TweenLite.to(html5vid.find('.tp-poster'),0.1,{autoAlpha:0});
		if (nextcaption.data('volume')=="mute")
			  video.muted=true;
		if (nextcaption.data('videoloop')!="loopandnoslidestop") {
			opt.container.trigger('stoptimer');															
			opt.container.trigger('revolution.slide.onvideoplay');
		}

		opt.videoplaying=true;

		if (nextcaption.data('videoloop')=="loopandnoslidestop") {
				opt.videoplaying=false;
				opt.container.trigger('starttimer');
				opt.container.trigger('revolution.slide.onvideostop');

		}

	});

	video.addEventListener("pause",function() {
			html5vid.removeClass("videoisplaying");
			opt.videoplaying=false;
			opt.container.trigger('starttimer');
			opt.container.trigger('revolution.slide.onvideostop');
	});

	video.addEventListener("ended",function() {

			html5vid.removeClass("videoisplaying");
			opt.videoplaying=false;
			opt.container.trigger('starttimer');
			opt.container.trigger('revolution.slide.onvideostop');
			if (opt.nextslideatend==true)
				opt.container.revnext();
	});
}

punchgs.TweenLite.set(html5vid.find('.tp-poster'),{autoAlpha:1});


var autoplaywason = false;

if (nextcaption.data('autoplayonlyfirsttime') == true || nextcaption.data('autoplayonlyfirsttime')=="true") 
	autoplaywason = true;



clearInterval(html5vid.data('interval'));
html5vid.data('interval',setInterval(function() {

	if (html5vid.data('metaloaded')==1 || video.duration!=NaN) {

		clearInterval(html5vid.data('interval'));
		
		var mediaaspect=16/9;
		if (nextcaption.data('aspectratio')=="4:3") mediaaspect=4/3;
		html5vid.data('mediaAspect',mediaaspect);

		if (html5vid.closest('.tp-caption').data('forcecover')==1) {
			updateHTML5Size(html5vid,opt.container);
			html5vid.addClass("fullcoveredvideo");
		}

		jvideo.css({display:"block"});

		opt.nextslideatend = nextcaption.data('nextslideatend');

		// IF VIDEO SHOULD BE AUTOPLAYED
		if (nextcaption.data('autoplay')==true || autoplaywason==true) {
			setTimeout(function(){
				if (nextcaption.data('videoloop')=="loopandnoslidestop") {
					setTimeout(function() {
						opt.videoplaying=false;
						opt.container.trigger('starttimer');
						opt.container.trigger('revolution.slide.onvideostop');
					},900);
				} else {
					opt.videoplaying=true;
					opt.container.trigger('stoptimer');
					opt.container.trigger('revolution.slide.onvideoplay');																	
				}
			},200);

			if (nextcaption.data('forcerewind')=="on" && !html5vid.hasClass("videoisplaying"))
				if (video.currentTime>0) video.currentTime=0;

			if (nextcaption.data('volume')=="mute")
				video.muted = true;

			html5vid.data('timerplay',setTimeout(function() {

				if (nextcaption.data('forcerewind')=="on" && !html5vid.hasClass("videoisplaying"))
					if (video.currentTime>0) video.currentTime=0;

				if (nextcaption.data('volume')=="mute")
						video.muted = true;

				setTimeout(function() {

					video.play();

				},500);
			},10+nextcaption.data('start')));
		}


		if (html5vid.data('ww') == undefined) html5vid.data('ww',jvideo.attr('width'));
		if (html5vid.data('hh') == undefined) html5vid.data('hh',jvideo.attr('height'));

		if (!nextcaption.hasClass("fullscreenvideo") && nextcaption.data('forcecover')==1) {
			try{
				html5vid.width(html5vid.data('ww')*opt.bw);
				html5vid.height(html5vid.data('hh')*opt.bh);
			} catch(e) {}
		}

		clearInterval(html5vid.data('interval'));
	}
}),100);