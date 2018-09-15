/*! perfect-scrollbar - v0.5.7
* http://noraesae.github.com/perfect-scrollbar/
* Copyright (c) 2014 Hyunje Alex Jun; Licensed MIT */
(function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?e(require("jquery")):e(jQuery)})(function(e){"use strict";function t(e){return"string"==typeof e?parseInt(e,10):~~e}var o={wheelSpeed:1,wheelPropagation:!1,minScrollbarLength:null,maxScrollbarLength:null,useBothWheelAxes:!1,useKeyboard:!0,suppressScrollX:!1,suppressScrollY:!1,scrollXMarginOffset:0,scrollYMarginOffset:0,includePadding:!1},n=0,r=function(){var e=n++;return function(t){var o=".perfect-scrollbar-"+e;return t===void 0?o:t+o}};e.fn.perfectScrollbar=function(n,l){return this.each(function(){function i(e,o){var n=e+o,r=E-W;I=0>n?0:n>r?r:n;var l=t(I*(D-E)/(E-W));S.scrollTop(l)}function a(e,o){var n=e+o,r=x-Y;X=0>n?0:n>r?r:n;var l=t(X*(M-x)/(x-Y));S.scrollLeft(l)}function c(e){return L.minScrollbarLength&&(e=Math.max(e,L.minScrollbarLength)),L.maxScrollbarLength&&(e=Math.min(e,L.maxScrollbarLength)),e}function s(){var e={width:x};e.left=O?S.scrollLeft()+x-M:S.scrollLeft(),B?e.bottom=q-S.scrollTop():e.top=H+S.scrollTop(),A.css(e);var t={top:S.scrollTop(),height:E};z?t.right=O?M-S.scrollLeft()-Q-N.outerWidth():Q-S.scrollLeft():t.left=O?S.scrollLeft()+2*x-M-F-N.outerWidth():F+S.scrollLeft(),_.css(t),K.css({left:X,width:Y-U}),N.css({top:I,height:W-G})}function d(){S.removeClass("ps-active-x"),S.removeClass("ps-active-y"),x=L.includePadding?S.innerWidth():S.width(),E=L.includePadding?S.innerHeight():S.height(),M=S.prop("scrollWidth"),D=S.prop("scrollHeight"),!L.suppressScrollX&&M>x+L.scrollXMarginOffset?(C=!0,Y=c(t(x*x/M)),X=t(S.scrollLeft()*(x-Y)/(M-x))):(C=!1,Y=0,X=0,S.scrollLeft(0)),!L.suppressScrollY&&D>E+L.scrollYMarginOffset?(k=!0,W=c(t(E*E/D)),I=t(S.scrollTop()*(E-W)/(D-E))):(k=!1,W=0,I=0,S.scrollTop(0)),X>=x-Y&&(X=x-Y),I>=E-W&&(I=E-W),s(),C&&S.addClass("ps-active-x"),k&&S.addClass("ps-active-y")}function u(){var t,o,n=!1;K.bind(j("mousedown"),function(e){o=e.pageX,t=K.position().left,A.addClass("in-scrolling"),n=!0,e.stopPropagation(),e.preventDefault()}),e(R).bind(j("mousemove"),function(e){n&&(a(t,e.pageX-o),d(),e.stopPropagation(),e.preventDefault())}),e(R).bind(j("mouseup"),function(){n&&(n=!1,A.removeClass("in-scrolling"))}),t=o=null}function p(){var t,o,n=!1;N.bind(j("mousedown"),function(e){o=e.pageY,t=N.position().top,n=!0,_.addClass("in-scrolling"),e.stopPropagation(),e.preventDefault()}),e(R).bind(j("mousemove"),function(e){n&&(i(t,e.pageY-o),d(),e.stopPropagation(),e.preventDefault())}),e(R).bind(j("mouseup"),function(){n&&(n=!1,_.removeClass("in-scrolling"))}),t=o=null}function f(e,t){var o=S.scrollTop();if(0===e){if(!k)return!1;if(0===o&&t>0||o>=D-E&&0>t)return!L.wheelPropagation}var n=S.scrollLeft();if(0===t){if(!C)return!1;if(0===n&&0>e||n>=M-x&&e>0)return!L.wheelPropagation}return!0}function v(){function e(e){var t=e.originalEvent.deltaX,o=-1*e.originalEvent.deltaY;return(t===void 0||o===void 0)&&(t=-1*e.originalEvent.wheelDeltaX/6,o=e.originalEvent.wheelDeltaY/6),e.originalEvent.deltaMode&&1===e.originalEvent.deltaMode&&(t*=10,o*=10),t!==t&&o!==o&&(t=0,o=e.originalEvent.wheelDelta),[t,o]}function t(t){var n=e(t),r=n[0],l=n[1];o=!1,L.useBothWheelAxes?k&&!C?(l?S.scrollTop(S.scrollTop()-l*L.wheelSpeed):S.scrollTop(S.scrollTop()+r*L.wheelSpeed),o=!0):C&&!k&&(r?S.scrollLeft(S.scrollLeft()+r*L.wheelSpeed):S.scrollLeft(S.scrollLeft()-l*L.wheelSpeed),o=!0):(S.scrollTop(S.scrollTop()-l*L.wheelSpeed),S.scrollLeft(S.scrollLeft()+r*L.wheelSpeed)),d(),o=o||f(r,l),o&&(t.stopPropagation(),t.preventDefault())}var o=!1;window.onwheel!==void 0?S.bind(j("wheel"),t):window.onmousewheel!==void 0&&S.bind(j("mousewheel"),t)}function g(){var t=!1;S.bind(j("mouseenter"),function(){t=!0}),S.bind(j("mouseleave"),function(){t=!1});var o=!1;e(R).bind(j("keydown"),function(n){if((!n.isDefaultPrevented||!n.isDefaultPrevented())&&t){for(var r=document.activeElement?document.activeElement:R.activeElement;r.shadowRoot;)r=r.shadowRoot.activeElement;if(!e(r).is(":input,[contenteditable]")){var l=0,i=0;switch(n.which){case 37:l=-30;break;case 38:i=30;break;case 39:l=30;break;case 40:i=-30;break;case 33:i=90;break;case 32:case 34:i=-90;break;case 35:i=n.ctrlKey?-D:-E;break;case 36:i=n.ctrlKey?S.scrollTop():E;break;default:return}S.scrollTop(S.scrollTop()-i),S.scrollLeft(S.scrollLeft()+l),o=f(l,i),o&&n.preventDefault()}}})}function b(){function e(e){e.stopPropagation()}N.bind(j("click"),e),_.bind(j("click"),function(e){var o=t(W/2),n=e.pageY-_.offset().top-o,r=E-W,l=n/r;0>l?l=0:l>1&&(l=1),S.scrollTop((D-E)*l)}),K.bind(j("click"),e),A.bind(j("click"),function(e){var o=t(Y/2),n=e.pageX-A.offset().left-o,r=x-Y,l=n/r;0>l?l=0:l>1&&(l=1),S.scrollLeft((M-x)*l)})}function h(){function t(){var e=window.getSelection?window.getSelection():document.getSlection?document.getSlection():{rangeCount:0};return 0===e.rangeCount?null:e.getRangeAt(0).commonAncestorContainer}function o(){r||(r=setInterval(function(){return P()?(S.scrollTop(S.scrollTop()+l.top),S.scrollLeft(S.scrollLeft()+l.left),d(),void 0):(clearInterval(r),void 0)},50))}function n(){r&&(clearInterval(r),r=null),A.removeClass("in-scrolling"),_.removeClass("in-scrolling")}var r=null,l={top:0,left:0},i=!1;e(R).bind(j("selectionchange"),function(){e.contains(S[0],t())?i=!0:(i=!1,n())}),e(window).bind(j("mouseup"),function(){i&&(i=!1,n())}),e(window).bind(j("mousemove"),function(e){if(i){var t={x:e.pageX,y:e.pageY},r=S.offset(),a={left:r.left,right:r.left+S.outerWidth(),top:r.top,bottom:r.top+S.outerHeight()};t.x<a.left+3?(l.left=-5,A.addClass("in-scrolling")):t.x>a.right-3?(l.left=5,A.addClass("in-scrolling")):l.left=0,t.y<a.top+3?(l.top=5>a.top+3-t.y?-5:-20,_.addClass("in-scrolling")):t.y>a.bottom-3?(l.top=5>t.y-a.bottom+3?5:20,_.addClass("in-scrolling")):l.top=0,0===l.top&&0===l.left?n():o()}})}function w(t,o){function n(e,t){S.scrollTop(S.scrollTop()-t),S.scrollLeft(S.scrollLeft()-e),d()}function r(){b=!0}function l(){b=!1}function i(e){return e.originalEvent.targetTouches?e.originalEvent.targetTouches[0]:e.originalEvent}function a(e){var t=e.originalEvent;return t.targetTouches&&1===t.targetTouches.length?!0:t.pointerType&&"mouse"!==t.pointerType&&t.pointerType!==t.MSPOINTER_TYPE_MOUSE?!0:!1}function c(e){if(a(e)){h=!0;var t=i(e);p.pageX=t.pageX,p.pageY=t.pageY,f=(new Date).getTime(),null!==g&&clearInterval(g),e.stopPropagation()}}function s(e){if(!b&&h&&a(e)){var t=i(e),o={pageX:t.pageX,pageY:t.pageY},r=o.pageX-p.pageX,l=o.pageY-p.pageY;n(r,l),p=o;var c=(new Date).getTime(),s=c-f;s>0&&(v.x=r/s,v.y=l/s,f=c),e.stopPropagation(),e.preventDefault()}}function u(){!b&&h&&(h=!1,clearInterval(g),g=setInterval(function(){return P()?.01>Math.abs(v.x)&&.01>Math.abs(v.y)?(clearInterval(g),void 0):(n(30*v.x,30*v.y),v.x*=.8,v.y*=.8,void 0):(clearInterval(g),void 0)},10))}var p={},f=0,v={},g=null,b=!1,h=!1;t&&(e(window).bind(j("touchstart"),r),e(window).bind(j("touchend"),l),S.bind(j("touchstart"),c),S.bind(j("touchmove"),s),S.bind(j("touchend"),u)),o&&(window.PointerEvent?(e(window).bind(j("pointerdown"),r),e(window).bind(j("pointerup"),l),S.bind(j("pointerdown"),c),S.bind(j("pointermove"),s),S.bind(j("pointerup"),u)):window.MSPointerEvent&&(e(window).bind(j("MSPointerDown"),r),e(window).bind(j("MSPointerUp"),l),S.bind(j("MSPointerDown"),c),S.bind(j("MSPointerMove"),s),S.bind(j("MSPointerUp"),u)))}function m(){S.bind(j("scroll"),function(){d()})}function T(){S.unbind(j()),e(window).unbind(j()),e(R).unbind(j()),S.data("perfect-scrollbar",null),S.data("perfect-scrollbar-update",null),S.data("perfect-scrollbar-destroy",null),K.remove(),N.remove(),A.remove(),_.remove(),S=A=_=K=N=C=k=x=E=M=D=Y=X=q=B=H=W=I=Q=z=F=O=j=null}function y(){d(),m(),u(),p(),b(),h(),v(),(J||V)&&w(J,V),L.useKeyboard&&g(),S.data("perfect-scrollbar",S),S.data("perfect-scrollbar-update",d),S.data("perfect-scrollbar-destroy",T)}var L=e.extend(!0,{},o),S=e(this),P=function(){return!!S};if("object"==typeof n?e.extend(!0,L,n):l=n,"update"===l)return S.data("perfect-scrollbar-update")&&S.data("perfect-scrollbar-update")(),S;if("destroy"===l)return S.data("perfect-scrollbar-destroy")&&S.data("perfect-scrollbar-destroy")(),S;if(S.data("perfect-scrollbar"))return S.data("perfect-scrollbar");S.addClass("ps-container");var x,E,M,D,C,Y,X,k,W,I,O="rtl"===S.css("direction"),j=r(),R=this.ownerDocument||document,A=e("<div class='ps-scrollbar-x-rail'>").appendTo(S),K=e("<div class='ps-scrollbar-x'>").appendTo(A),q=t(A.css("bottom")),B=q===q,H=B?null:t(A.css("top")),U=t(A.css("borderLeftWidth"))+t(A.css("borderRightWidth")),_=e("<div class='ps-scrollbar-y-rail'>").appendTo(S),N=e("<div class='ps-scrollbar-y'>").appendTo(_),Q=t(_.css("right")),z=Q===Q,F=z?null:t(_.css("left")),G=t(_.css("borderTopWidth"))+t(_.css("borderBottomWidth")),J="ontouchstart"in window||window.DocumentTouch&&document instanceof window.DocumentTouch,V=null!==window.navigator.msMaxTouchPoints;return y(),S})}});

(function( $ ) {
	$(document).ready(function(){
		//hover toggles buttons
		
			/*$(".rs-addon-activated").hover(function () {
				$this = $(this);
			    $this.data("original",$this.html());
			    $this.removeClass('rs-status-green').addClass('rs-status-orange').html($this.data('alternative'));
			}, function () {
				$this = $(this);
			    $this.removeClass('rs-status-orange').addClass('rs-status-green').html($this.data("original"));
			});

			$(".rs-addon-not-activated").hover(function () {
				$this = $(this);
			    $this.data("original",$this.html());
			    $this.removeClass('rs-status-orange').addClass('rs-status-green').html($this.data('alternative'));
			}, function () {
				$this = $(this);
			    $this.removeClass('rs-status-green').addClass('rs-status-orange').html($this.data("original"));
			});

			$(".rs-addon-not-installed").hover(function () {
				$this = $(this);
			    $this.data("original",$this.html());
			    $this.removeClass('rs-status-red').addClass('rs-status-green').html($this.data('alternative'));
			}, function () {
				$this = $(this);
			    $this.removeClass('rs-status-green').addClass('rs-status-red').html($this.data("original"));
			});*/
		
		//click event to install plugin
			$(".rs-addon-not-installed").click(function(){
				showWaitAMinute({fadeIn:300,text:rev_slider_addon.please_wait_a_moment});
				$this = $(this);
				//console.log("install process");
				$.ajax({
				url : rev_slider_addon.ajax_url,
				type : 'post',
				data : {
					action : 'install_plugin',
					nonce: 	$('#ajax_rev_slider_addon_nonce').text(),// The security nonce
					plugin: $this.data("plugin")
				},
				success : function( response ) {
					switch(response){
						case "0":
								showWaitAMinute({fadeOut:300,text:rev_slider_addon.please_wait_a_moment});
								UniteAdminRev.showErrorMessage("Something went wrong!");
								//console.log("Something Went Wrong");
								break;
						case "1":
								//console.log("Plugin installed");
								location.reload();
								break;
						case "-1":
								showWaitAMinute({fadeOut:300,text:rev_slider_addon.please_wait_a_moment});
								UniteAdminRev.showErrorMessage("Nonce missing!");
								//console.log("Nonce missing");
								break;
					}
				},
				error : function ( response ){
					//console.log('Ajax Error');
					showWaitAMinute({fadeOut:300,text:rev_slider_addon.please_wait_a_moment});
					UniteAdminRev.showErrorMessage("Something went wrong!");
				}
			}); // End Ajax
		}); // End Click

		//click event to activate plugin
			$(".rs-addon-not-activated").click(function(){
				showWaitAMinute({fadeIn:300,text:rev_slider_addon.please_wait_a_moment});
				
				$this = $(this);
				$.ajax({
				url : rev_slider_addon.ajax_url,
				type : 'post',
				data : {
					action : 'activate_plugin',
					nonce: 	$('#ajax_rev_slider_addon_nonce').text(),// The security nonce
					plugin: $this.data("plugin")
				},
				success : function( response ) {
					switch(response){
						case "0":
								console.log("Something Went Wrong");
								break;
						case "1":
								console.log("Plugin activated");
								 location.reload();
								break;
						case "-1":
								console.log("Nonce missing");
								break;
					}
				},
				error : function ( response ){
					console.log('Ajax Error');
				}
			}); // End Ajax
		}); // End Click

		//click event to deactivate plugin
			$(".rs-dash-deactivate-addon").click(function(){
				showWaitAMinute({fadeIn:300,text:rev_slider_addon.please_wait_a_moment});
				$this = $(this);
				//console.log("deactivate process");
				$.ajax({
				url : rev_slider_addon.ajax_url,
				type : 'post',
				data : {
					action : 'deactivate_plugin',
					nonce: 	$('#ajax_rev_slider_addon_nonce').text(),// The security nonce
					plugin: $this.data("plugin")
				},
				success : function( response ) {
					switch(response){
						case "0":
								console.log("Something Went Wrong");
								break;
						case "1":
								console.log("Plugin deactivated");
								location.reload();
								break;
						case "-1":
								console.log("Nonce missing");
								break;
					}
				},
				error : function ( response ){
					//console.log('Ajax Error');
				}
			}); // End Ajax
		}); // End Click
	});// End Document ready

})( jQuery );


if (showWaitAMinute===undefined)
function showWaitAMinute(obj) {
		var wm = jQuery('#waitaminute');		
		
		// SHOW AND HIDE WITH DELAY
		if (obj.delay!=undefined) {

			punchgs.TweenLite.to(wm,0.3,{autoAlpha:1,ease:punchgs.Power3.easeInOut});
			punchgs.TweenLite.set(wm,{display:"block"});
			
			setTimeout(function() {
				punchgs.TweenLite.to(wm,0.3,{autoAlpha:0,ease:punchgs.Power3.easeInOut,onComplete:function() {
					punchgs.TweenLite.set(wm,{display:"block"});	
				}});  			
			},obj.delay)
		}

		// SHOW IT
		if (obj.fadeIn != undefined) {
			punchgs.TweenLite.to(wm,obj.fadeIn/1000,{autoAlpha:1,ease:punchgs.Power3.easeInOut});
			punchgs.TweenLite.set(wm,{display:"block"});			
		}

		// HIDE IT
		if (obj.fadeOut != undefined) {

			punchgs.TweenLite.to(wm,obj.fadeOut/1000,{autoAlpha:0,ease:punchgs.Power3.easeInOut,onComplete:function() {
					punchgs.TweenLite.set(wm,{display:"block"});	
				}});  
		}

		// CHANGE TEXT
		if (obj.text != undefined) {
			switch (obj.text) {
				case "progress1":

				break;
				default:					
					wm.html('<div class="waitaminute-message"><i class="eg-icon-emo-coffee"></i><br>'+obj.text+'</div>');
				break;	
			}
		}
	 }


