jQuery(document).ready(function(){
	/* vc hack by amit */
	jQuery('.upb_row_bg').each(function(index,urow){
		var row = jQuery(urow).parent();
		row[0].style.setProperty('background-image', 'none', 'important');
	});
	/* end */
	if(jQuery('.vcpb-fs-jquery').length > 0){
		if (!jQuery.event.special.frame) {
		// jquery.events.frame.js
		// 1.1 - lite
		// Stephen Band
		//
		// Project home:
		// webdev.stephband.info/events/frame/
		//
		// Source:
		// http://github.com/stephband/jquery.event.frame
		(function(d,h){function i(a,b){function e(){f.frameCount++;a.call(f)}var f=this,g;this.frameDuration=b||25;this.frameCount=-1;this.start=function(){e();g=setInterval(e,this.frameDuration)};this.stop=function(){clearInterval(g);g=null}}function j(){var a=d.event.special.frame.handler,b=d.Event("frame"),e=this.array,f=e.length;for(b.frameCount=this.frameCount;f--;)a.call(e[f],b)}var c;if(!d.event.special.frame)d.event.special.frame={setup:function(a){if(c)c.array.push(this);else{c=new i(j,a&&a.frameDuration);
		c.array=[this];var b=setTimeout(function(){c.start();clearTimeout(b);b=null},0)}},teardown:function(){for(var a=c.array,b=a.length;b--;)if(a[b]===this){a.splice(b,1);break}if(a.length===0){c.stop();c=h}},handler:function(){d.event.handle.apply(this,arguments)}}})(jQuery);
		}
		// jquery.jparallax.js
		// 1.0
		// Stephen Band
		//
		// Project and documentation site:
		// webdev.stephband.info/jparallax/
		//
		// Repository:
		// github.com/stephband/jparallax
		//
		// Dependencies:
		// jquery.event.frame
		(function(l,t){function y(i){return this.lib[i]}function q(i){return typeof i==="boolean"?i:!!parseFloat(i)}function r(i,b){var k=[q(i.xparallax),q(i.yparallax)];this.ontarget=false;this.decay=i.decay;this.pointer=b||[0.5,0.5];this.update=function(e,a){if(this.ontarget)this.pointer=e;else if((!k[0]||u(e[0]-this.pointer[0])<a[0])&&(!k[1]||u(e[1]-this.pointer[1])<a[1])){this.ontarget=true;this.pointer=e}else{a=[];for(var g=2;g--;)if(k[g])a[g]=e[g]+this.decay*(this.pointer[g]-e[g]);this.pointer=a}}}
		function z(i,b){var k=this,e=i instanceof l?i:l(i),a=[q(b.xparallax),q(b.yparallax)],g=0,d;this.pointer=[0,0];this.active=false;this.activeOutside=b&&b.activeOutside||false;this.update=function(h){var j=this.pos,c=this.size,f=[],m=2;if(g>0){if(g===2){g=0;if(d)h=d}for(;m--;)if(a[m]){f[m]=(h[m]-j[m])/c[m];f[m]=f[m]<0?0:f[m]>1?1:f[m]}this.active=true;this.pointer=f}else this.active=false};this.updateSize=function(){var h=e.width(),j=e.height();k.size=[h,j];k.threshold=[1/h,1/j]};this.updatePos=function(){var h=
		e.offset()||{left:0,top:0},j=parseInt(e.css("borderLeftWidth"))+parseInt(e.css("paddingLeft")),c=parseInt(e.css("borderTopWidth"))+parseInt(e.css("paddingTop"));k.pos=[h.left+j,h.top+c]};l(window).bind("resize",k.updateSize).bind("resize",k.updatePos);e.bind("mouseenter",function(){g=1}).bind("mouseleave",function(h){g=2;d=[h.pageX,h.pageY]});this.updateSize();this.updatePos()}function A(i,b){var k=[],e=[],a=[],g=[];this.update=function(d){for(var h=[],j,c,f=2,m={};f--;)if(e[f]){h[f]=e[f]*d[f]+a[f];
		if(k[f]){j=g[f];c=h[f]*-1}else{j=h[f]*100+"%";c=h[f]*this.size[f]*-1}if(f===0){m.left=j;m.marginLeft=c}else{m.top=j;m.marginTop=c}}i.css(m)};this.setParallax=function(d,h,j,c){d=[d||b.xparallax,h||b.yparallax];j=[j||b.xorigin,c||b.yorigin];for(c=2;c--;){k[c]=o.px.test(d[c]);if(typeof j[c]==="string")j[c]=o.percent.test(j[c])?parseFloat(j[c])/100:v[j[c]]||1;if(k[c]){e[c]=parseInt(d[c]);a[c]=j[c]*(this.size[c]-e[c]);g[c]=j[c]*100+"%"}else{e[c]=d[c]===true?1:o.percent.test(d[c])?parseFloat(d[c])/100:
		d[c];a[c]=e[c]?j[c]*(1-e[c]):0}}};this.getPointer=function(){for(var d=i.offsetParent(),h=i.position(),j=[],c=[],f=2;f--;){j[f]=k[f]?0:h[f===0?"left":"top"]/(d[f===0?"outerWidth":"outerHeight"]()-this.size[f]);c[f]=(j[f]-a[f])/e[f]}return c};this.setSize=function(d,h){this.size=[d||i.outerWidth(),h||i.outerHeight()]};this.setSize(b.width,b.height);this.setParallax(b.xparallax,b.yparallax,b.xorigin,b.yorigin)}function s(i){var b=l(this),k=i.data,e=b.data(n),a=k.port,g=k.mouse,d=e.mouse;if(k.timeStamp!==
		i.timeStamp){k.timeStamp=i.timeStamp;a.update(w);if(a.active||!g.ontarget)g.update(a.pointer,a.threshold)}if(d){d.update(e.freeze?e.freeze.pointer:a.pointer,a.threshold);if(d.ontarget){delete e.mouse;e.freeze&&b.unbind(p).addClass(k.freezeClass)}g=d}else g.ontarget&&!a.active&&b.unbind(p);e.layer.update(g.pointer)}var n="parallax",x={mouseport:"body",xparallax:true,yparallax:true,xorigin:0.5,yorigin:0.5,decay:0.66,frameDuration:30,freezeClass:"freeze"},v={left:0,top:0,middle:0.5,center:0.5,right:1,
		bottom:1},o={px:/^\d+\s?px$/,percent:/^\d+\s?%$/},p="frame."+n,u=Math.abs,w=[0,0];y.lib=v;l.fn[n]=function(i){var b=l.extend({},l.fn[n].options,i),k=arguments,e=this;if(!(b.mouseport instanceof l))b.mouseport=l(b.mouseport);b.port=new z(b.mouseport,b);b.mouse=new r(b);b.mouseport.bind("mouseenter",function(){b.mouse.ontarget=false;e.each(function(){var a=l(this);a.data(n).freeze||a.bind(p,b,s)})});return e.bind("freeze",function(a){var g=l(this),d=
		g.data(n),h=d.mouse||d.freeze||b.mouse,j=o.percent.exec(a.x)?parseFloat(a.x.replace(/%$/,""))/100:a.x||h.pointer[0],c=o.percent.exec(a.y)?parseFloat(a.y.replace(/%$/,""))/100:a.y||h.pointer[1];a=a.decay;d.freeze={pointer:[j,c]};d.mouse=new r(b,h.pointer);if(a!==t)d.mouse.decay=a;g.bind(p,b,s)}).bind("unfreeze",function(a){var g=l(this),d=g.data(n);a=a.decay;var h;if(d.freeze){h=d.mouse?d.mouse.pointer:d.freeze.pointer;d.mouse=new r(b);d.mouse.pointer=h;if(a!==t)d.mouse.decay=a;delete d.freeze;g.removeClass(x.freezeClass).bind(p,
		b,s)}}).each(function(a){var g=l(this);a=k[a+1]?l.extend({},b,k[a+1]):b;var d=new A(g,a);g.data(n,{layer:d,mouse:new r(a,d.getPointer())})})};l.fn[n].options=x;l(document).ready(function(){l(document).mousemove(function(i){w=[i.pageX,i.pageY]})})})(jQuery);
		//if(! jQuery.browser.mobile){
			jQuery('.vcpb-fs-jquery').each(function(){
				var selector = jQuery(this);
				var sense = selector.data('parallax_sense');
				var incr =(selector.outerWidth()*(sense/100));
				var img_list = selector.data('img-array');
				img_list = img_list.split(',');
				var img_list_len = img_list.length;
				for (var i = 0; i < img_list_len; i++) {
					jQuery(selector).prepend('<img class="ultimate_h_parallax" src="'+img_list[i]+'"></div>')
				};
				var hp = jQuery(selector).find('.ultimate_h_parallax');
				hp.css({'max-width':'none','position':'absolute'});
				hp.css('min-width',(hp.parent().outerWidth())+incr+'px');
			});
			var resiz = function(){
				jQuery('.vcpb-fs-jquery').each(function(){
					var selector = jQuery(this);
					var sense = selector.data('parallax_sense');
					var incr =(selector.outerWidth()*(sense/100));
					var hp = jQuery(selector).find('.ultimate_h_parallax');
					if(hp.parent().outerHeight()>hp.outerHeight()){
						hp.css('min-height',(hp.parent().outerHeight())+incr+'px')
					}
					if(hp.outerHeight()>hp.outerWidth()){
						hp.css('width','auto')
					}
					jQuery(selector).css('background-image','')
				})
			}
			resiz();
			jQuery(window).resize(function(){
				resiz();
			})
			jQuery(window).load(function(){
				jQuery('.vcpb-fs-jquery').each(function(){
					var layer_count = jQuery(this).find('.ultimate_h_parallax').length;
					layer_count = 1/layer_count;
					var lay_opt = new Array();
					jQuery(this).find('.ultimate_h_parallax').each(function(index){
						lay_opt.push("{'xparallax':"+ layer_count*(index+1)+" , 'yparallax':"+ layer_count*(index+1)+"}");
					})
					lay_opt = lay_opt.join(",");
					
					if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
						var is_mobile = 'false';
					else
						var is_mobile = 'true';
					
					var is_img_parallax_disable_on_mobile = jQuery(this).parent().data('img-parallax-mobile-disable').toString();
					if(is_mobile == 'true' && is_img_parallax_disable_on_mobile == 'true')
						var disable_row_effect = 'true';
					else
						var disable_row_effect = 'false';
					
					if(disable_row_effect == 'false')
						eval("jQuery(this).find('.ultimate_h_parallax').parallax({mouseport: jQuery(this).parent()},"+lay_opt+"); var mouse = {x: 0, y: 0}; document.addEventListener('mousemove', function(e){  mouse.x = e.clientX || e.pageX; mouse.y = e.clientY || e.pageY; jQuery(this).parent().trigger({type: 'mousemove', pageX: mouse.x, pageY: mouse.y }); }, true); jQuery(this).parent().trigger({type: 'mouseenter', pageX: 0, pageY: 0}); var x = 1; document.onmousemove = document.onmouseover = function (e) { if(x > 1) return false; mouse.x = e.clientX || e.pageX;  mouse.y = e.clientY || e.pageY; x++; if(x == 2) jQuery(this).parent().trigger({type: 'mousemove', pageX: mouse.x, pageY: mouse.y }); }");
				})
			})
		//}
	}
})