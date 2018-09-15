
/* perfect-scrollbar v0.6.11 */
!function t(e,n,r){function o(l,a){if(!n[l]){if(!e[l]){var s="function"==typeof require&&require;if(!a&&s)return s(l,!0);if(i)return i(l,!0);var c=new Error("Cannot find module '"+l+"'");throw c.code="MODULE_NOT_FOUND",c}var u=n[l]={exports:{}};e[l][0].call(u.exports,function(t){var n=e[l][1][t];return o(n?n:t)},u,u.exports,t,e,n,r)}return n[l].exports}for(var i="function"==typeof require&&require,l=0;l<r.length;l++)o(r[l]);return o}({1:[function(t,e,n){"use strict";function r(t){t.fn.perfectScrollbar=function(t){return this.each(function(){if("object"==typeof t||"undefined"==typeof t){var e=t;i.get(this)||o.initialize(this,e)}else{var n=t;"update"===n?o.update(this):"destroy"===n&&o.destroy(this)}})}}var o=t("../main"),i=t("../plugin/instances");if("function"==typeof define&&define.amd)define(["jquery"],r);else{var l=window.jQuery?window.jQuery:window.$;"undefined"!=typeof l&&r(l)}e.exports=r},{"../main":7,"../plugin/instances":18}],2:[function(t,e,n){"use strict";function r(t,e){var n=t.className.split(" ");n.indexOf(e)<0&&n.push(e),t.className=n.join(" ")}function o(t,e){var n=t.className.split(" "),r=n.indexOf(e);r>=0&&n.splice(r,1),t.className=n.join(" ")}n.add=function(t,e){t.classList?t.classList.add(e):r(t,e)},n.remove=function(t,e){t.classList?t.classList.remove(e):o(t,e)},n.list=function(t){return t.classList?Array.prototype.slice.apply(t.classList):t.className.split(" ")}},{}],3:[function(t,e,n){"use strict";function r(t,e){return window.getComputedStyle(t)[e]}function o(t,e,n){return"number"==typeof n&&(n=n.toString()+"px"),t.style[e]=n,t}function i(t,e){for(var n in e){var r=e[n];"number"==typeof r&&(r=r.toString()+"px"),t.style[n]=r}return t}var l={};l.e=function(t,e){var n=document.createElement(t);return n.className=e,n},l.appendTo=function(t,e){return e.appendChild(t),t},l.css=function(t,e,n){return"object"==typeof e?i(t,e):"undefined"==typeof n?r(t,e):o(t,e,n)},l.matches=function(t,e){return"undefined"!=typeof t.matches?t.matches(e):"undefined"!=typeof t.matchesSelector?t.matchesSelector(e):"undefined"!=typeof t.webkitMatchesSelector?t.webkitMatchesSelector(e):"undefined"!=typeof t.mozMatchesSelector?t.mozMatchesSelector(e):"undefined"!=typeof t.msMatchesSelector?t.msMatchesSelector(e):void 0},l.remove=function(t){"undefined"!=typeof t.remove?t.remove():t.parentNode&&t.parentNode.removeChild(t)},l.queryChildren=function(t,e){return Array.prototype.filter.call(t.childNodes,function(t){return l.matches(t,e)})},e.exports=l},{}],4:[function(t,e,n){"use strict";var r=function(t){this.element=t,this.events={}};r.prototype.bind=function(t,e){"undefined"==typeof this.events[t]&&(this.events[t]=[]),this.events[t].push(e),this.element.addEventListener(t,e,!1)},r.prototype.unbind=function(t,e){var n="undefined"!=typeof e;this.events[t]=this.events[t].filter(function(r){return n&&r!==e?!0:(this.element.removeEventListener(t,r,!1),!1)},this)},r.prototype.unbindAll=function(){for(var t in this.events)this.unbind(t)};var o=function(){this.eventElements=[]};o.prototype.eventElement=function(t){var e=this.eventElements.filter(function(e){return e.element===t})[0];return"undefined"==typeof e&&(e=new r(t),this.eventElements.push(e)),e},o.prototype.bind=function(t,e,n){this.eventElement(t).bind(e,n)},o.prototype.unbind=function(t,e,n){this.eventElement(t).unbind(e,n)},o.prototype.unbindAll=function(){for(var t=0;t<this.eventElements.length;t++)this.eventElements[t].unbindAll()},o.prototype.once=function(t,e,n){var r=this.eventElement(t),o=function(t){r.unbind(e,o),n(t)};r.bind(e,o)},e.exports=o},{}],5:[function(t,e,n){"use strict";e.exports=function(){function t(){return Math.floor(65536*(1+Math.random())).toString(16).substring(1)}return function(){return t()+t()+"-"+t()+"-"+t()+"-"+t()+"-"+t()+t()+t()}}()},{}],6:[function(t,e,n){"use strict";var r=t("./class"),o=t("./dom"),i=n.toInt=function(t){return parseInt(t,10)||0},l=n.clone=function(t){if(null===t)return null;if(t.constructor===Array)return t.map(l);if("object"==typeof t){var e={};for(var n in t)e[n]=l(t[n]);return e}return t};n.extend=function(t,e){var n=l(t);for(var r in e)n[r]=l(e[r]);return n},n.isEditable=function(t){return o.matches(t,"input,[contenteditable]")||o.matches(t,"select,[contenteditable]")||o.matches(t,"textarea,[contenteditable]")||o.matches(t,"button,[contenteditable]")},n.removePsClasses=function(t){for(var e=r.list(t),n=0;n<e.length;n++){var o=e[n];0===o.indexOf("ps-")&&r.remove(t,o)}},n.outerWidth=function(t){return i(o.css(t,"width"))+i(o.css(t,"paddingLeft"))+i(o.css(t,"paddingRight"))+i(o.css(t,"borderLeftWidth"))+i(o.css(t,"borderRightWidth"))},n.startScrolling=function(t,e){r.add(t,"ps-in-scrolling"),"undefined"!=typeof e?r.add(t,"ps-"+e):(r.add(t,"ps-x"),r.add(t,"ps-y"))},n.stopScrolling=function(t,e){r.remove(t,"ps-in-scrolling"),"undefined"!=typeof e?r.remove(t,"ps-"+e):(r.remove(t,"ps-x"),r.remove(t,"ps-y"))},n.env={isWebKit:"WebkitAppearance"in document.documentElement.style,supportsTouch:"ontouchstart"in window||window.DocumentTouch&&document instanceof window.DocumentTouch,supportsIePointer:null!==window.navigator.msMaxTouchPoints}},{"./class":2,"./dom":3}],7:[function(t,e,n){"use strict";var r=t("./plugin/destroy"),o=t("./plugin/initialize"),i=t("./plugin/update");e.exports={initialize:o,update:i,destroy:r}},{"./plugin/destroy":9,"./plugin/initialize":17,"./plugin/update":21}],8:[function(t,e,n){"use strict";e.exports={handlers:["click-rail","drag-scrollbar","keyboard","wheel","touch"],maxScrollbarLength:null,minScrollbarLength:null,scrollXMarginOffset:0,scrollYMarginOffset:0,stopPropagationOnClick:!0,suppressScrollX:!1,suppressScrollY:!1,swipePropagation:!0,useBothWheelAxes:!1,wheelPropagation:!1,wheelSpeed:1,theme:"default"}},{}],9:[function(t,e,n){"use strict";var r=t("../lib/helper"),o=t("../lib/dom"),i=t("./instances");e.exports=function(t){var e=i.get(t);e&&(e.event.unbindAll(),o.remove(e.scrollbarX),o.remove(e.scrollbarY),o.remove(e.scrollbarXRail),o.remove(e.scrollbarYRail),r.removePsClasses(t),i.remove(t))}},{"../lib/dom":3,"../lib/helper":6,"./instances":18}],10:[function(t,e,n){"use strict";function r(t,e){function n(t){return t.getBoundingClientRect()}var r=function(t){t.stopPropagation()};e.settings.stopPropagationOnClick&&e.event.bind(e.scrollbarY,"click",r),e.event.bind(e.scrollbarYRail,"click",function(r){var i=o.toInt(e.scrollbarYHeight/2),s=e.railYRatio*(r.pageY-window.pageYOffset-n(e.scrollbarYRail).top-i),c=e.railYRatio*(e.railYHeight-e.scrollbarYHeight),u=s/c;0>u?u=0:u>1&&(u=1),a(t,"top",(e.contentHeight-e.containerHeight)*u),l(t),r.stopPropagation()}),e.settings.stopPropagationOnClick&&e.event.bind(e.scrollbarX,"click",r),e.event.bind(e.scrollbarXRail,"click",function(r){var i=o.toInt(e.scrollbarXWidth/2),s=e.railXRatio*(r.pageX-window.pageXOffset-n(e.scrollbarXRail).left-i),c=e.railXRatio*(e.railXWidth-e.scrollbarXWidth),u=s/c;0>u?u=0:u>1&&(u=1),a(t,"left",(e.contentWidth-e.containerWidth)*u-e.negativeScrollAdjustment),l(t),r.stopPropagation()})}var o=t("../../lib/helper"),i=t("../instances"),l=t("../update-geometry"),a=t("../update-scroll");e.exports=function(t){var e=i.get(t);r(t,e)}},{"../../lib/helper":6,"../instances":18,"../update-geometry":19,"../update-scroll":20}],11:[function(t,e,n){"use strict";function r(t,e){function n(n){var o=r+n*e.railXRatio,l=Math.max(0,e.scrollbarXRail.getBoundingClientRect().left)+e.railXRatio*(e.railXWidth-e.scrollbarXWidth);0>o?e.scrollbarXLeft=0:o>l?e.scrollbarXLeft=l:e.scrollbarXLeft=o;var a=i.toInt(e.scrollbarXLeft*(e.contentWidth-e.containerWidth)/(e.containerWidth-e.railXRatio*e.scrollbarXWidth))-e.negativeScrollAdjustment;c(t,"left",a)}var r=null,o=null,a=function(e){n(e.pageX-o),s(t),e.stopPropagation(),e.preventDefault()},u=function(){i.stopScrolling(t,"x"),e.event.unbind(e.ownerDocument,"mousemove",a)};e.event.bind(e.scrollbarX,"mousedown",function(n){o=n.pageX,r=i.toInt(l.css(e.scrollbarX,"left"))*e.railXRatio,i.startScrolling(t,"x"),e.event.bind(e.ownerDocument,"mousemove",a),e.event.once(e.ownerDocument,"mouseup",u),n.stopPropagation(),n.preventDefault()})}function o(t,e){function n(n){var o=r+n*e.railYRatio,l=Math.max(0,e.scrollbarYRail.getBoundingClientRect().top)+e.railYRatio*(e.railYHeight-e.scrollbarYHeight);0>o?e.scrollbarYTop=0:o>l?e.scrollbarYTop=l:e.scrollbarYTop=o;var a=i.toInt(e.scrollbarYTop*(e.contentHeight-e.containerHeight)/(e.containerHeight-e.railYRatio*e.scrollbarYHeight));c(t,"top",a)}var r=null,o=null,a=function(e){n(e.pageY-o),s(t),e.stopPropagation(),e.preventDefault()},u=function(){i.stopScrolling(t,"y"),e.event.unbind(e.ownerDocument,"mousemove",a)};e.event.bind(e.scrollbarY,"mousedown",function(n){o=n.pageY,r=i.toInt(l.css(e.scrollbarY,"top"))*e.railYRatio,i.startScrolling(t,"y"),e.event.bind(e.ownerDocument,"mousemove",a),e.event.once(e.ownerDocument,"mouseup",u),n.stopPropagation(),n.preventDefault()})}var i=t("../../lib/helper"),l=t("../../lib/dom"),a=t("../instances"),s=t("../update-geometry"),c=t("../update-scroll");e.exports=function(t){var e=a.get(t);r(t,e),o(t,e)}},{"../../lib/dom":3,"../../lib/helper":6,"../instances":18,"../update-geometry":19,"../update-scroll":20}],12:[function(t,e,n){"use strict";function r(t,e){function n(n,r){var o=t.scrollTop;if(0===n){if(!e.scrollbarYActive)return!1;if(0===o&&r>0||o>=e.contentHeight-e.containerHeight&&0>r)return!e.settings.wheelPropagation}var i=t.scrollLeft;if(0===r){if(!e.scrollbarXActive)return!1;if(0===i&&0>n||i>=e.contentWidth-e.containerWidth&&n>0)return!e.settings.wheelPropagation}return!0}var r=!1;e.event.bind(t,"mouseenter",function(){r=!0}),e.event.bind(t,"mouseleave",function(){r=!1});var l=!1;e.event.bind(e.ownerDocument,"keydown",function(c){if(!c.isDefaultPrevented||!c.isDefaultPrevented()){var u=i.matches(e.scrollbarX,":focus")||i.matches(e.scrollbarY,":focus");if(r||u){var d=document.activeElement?document.activeElement:e.ownerDocument.activeElement;if(d){if("IFRAME"===d.tagName)d=d.contentDocument.activeElement;else for(;d.shadowRoot;)d=d.shadowRoot.activeElement;if(o.isEditable(d))return}var p=0,f=0;switch(c.which){case 37:p=-30;break;case 38:f=30;break;case 39:p=30;break;case 40:f=-30;break;case 33:f=90;break;case 32:f=c.shiftKey?90:-90;break;case 34:f=-90;break;case 35:f=c.ctrlKey?-e.contentHeight:-e.containerHeight;break;case 36:f=c.ctrlKey?t.scrollTop:e.containerHeight;break;default:return}s(t,"top",t.scrollTop-f),s(t,"left",t.scrollLeft+p),a(t),l=n(p,f),l&&c.preventDefault()}}})}var o=t("../../lib/helper"),i=t("../../lib/dom"),l=t("../instances"),a=t("../update-geometry"),s=t("../update-scroll");e.exports=function(t){var e=l.get(t);r(t,e)}},{"../../lib/dom":3,"../../lib/helper":6,"../instances":18,"../update-geometry":19,"../update-scroll":20}],13:[function(t,e,n){"use strict";function r(t,e){function n(n,r){var o=t.scrollTop;if(0===n){if(!e.scrollbarYActive)return!1;if(0===o&&r>0||o>=e.contentHeight-e.containerHeight&&0>r)return!e.settings.wheelPropagation}var i=t.scrollLeft;if(0===r){if(!e.scrollbarXActive)return!1;if(0===i&&0>n||i>=e.contentWidth-e.containerWidth&&n>0)return!e.settings.wheelPropagation}return!0}function r(t){var e=t.deltaX,n=-1*t.deltaY;return"undefined"!=typeof e&&"undefined"!=typeof n||(e=-1*t.wheelDeltaX/6,n=t.wheelDeltaY/6),t.deltaMode&&1===t.deltaMode&&(e*=10,n*=10),e!==e&&n!==n&&(e=0,n=t.wheelDelta),[e,n]}function o(e,n){var r=t.querySelector("textarea:hover, .ps-child:hover");if(r){if("TEXTAREA"!==r.tagName&&!window.getComputedStyle(r).overflow.match(/(scroll|auto)/))return!1;var o=r.scrollHeight-r.clientHeight;if(o>0&&!(0===r.scrollTop&&n>0||r.scrollTop===o&&0>n))return!0;var i=r.scrollLeft-r.clientWidth;if(i>0&&!(0===r.scrollLeft&&0>e||r.scrollLeft===i&&e>0))return!0}return!1}function a(a){var c=r(a),u=c[0],d=c[1];o(u,d)||(s=!1,e.settings.useBothWheelAxes?e.scrollbarYActive&&!e.scrollbarXActive?(d?l(t,"top",t.scrollTop-d*e.settings.wheelSpeed):l(t,"top",t.scrollTop+u*e.settings.wheelSpeed),s=!0):e.scrollbarXActive&&!e.scrollbarYActive&&(u?l(t,"left",t.scrollLeft+u*e.settings.wheelSpeed):l(t,"left",t.scrollLeft-d*e.settings.wheelSpeed),s=!0):(l(t,"top",t.scrollTop-d*e.settings.wheelSpeed),l(t,"left",t.scrollLeft+u*e.settings.wheelSpeed)),i(t),s=s||n(u,d),s&&(a.stopPropagation(),a.preventDefault()))}var s=!1;"undefined"!=typeof window.onwheel?e.event.bind(t,"wheel",a):"undefined"!=typeof window.onmousewheel&&e.event.bind(t,"mousewheel",a)}var o=t("../instances"),i=t("../update-geometry"),l=t("../update-scroll");e.exports=function(t){var e=o.get(t);r(t,e)}},{"../instances":18,"../update-geometry":19,"../update-scroll":20}],14:[function(t,e,n){"use strict";function r(t,e){e.event.bind(t,"scroll",function(){i(t)})}var o=t("../instances"),i=t("../update-geometry");e.exports=function(t){var e=o.get(t);r(t,e)}},{"../instances":18,"../update-geometry":19}],15:[function(t,e,n){"use strict";function r(t,e){function n(){var t=window.getSelection?window.getSelection():document.getSelection?document.getSelection():"";return 0===t.toString().length?null:t.getRangeAt(0).commonAncestorContainer}function r(){c||(c=setInterval(function(){return i.get(t)?(a(t,"top",t.scrollTop+u.top),a(t,"left",t.scrollLeft+u.left),void l(t)):void clearInterval(c)},50))}function s(){c&&(clearInterval(c),c=null),o.stopScrolling(t)}var c=null,u={top:0,left:0},d=!1;e.event.bind(e.ownerDocument,"selectionchange",function(){t.contains(n())?d=!0:(d=!1,s())}),e.event.bind(window,"mouseup",function(){d&&(d=!1,s())}),e.event.bind(window,"mousemove",function(e){if(d){var n={x:e.pageX,y:e.pageY},i={left:t.offsetLeft,right:t.offsetLeft+t.offsetWidth,top:t.offsetTop,bottom:t.offsetTop+t.offsetHeight};n.x<i.left+3?(u.left=-5,o.startScrolling(t,"x")):n.x>i.right-3?(u.left=5,o.startScrolling(t,"x")):u.left=0,n.y<i.top+3?(i.top+3-n.y<5?u.top=-5:u.top=-20,o.startScrolling(t,"y")):n.y>i.bottom-3?(n.y-i.bottom+3<5?u.top=5:u.top=20,o.startScrolling(t,"y")):u.top=0,0===u.top&&0===u.left?s():r()}})}var o=t("../../lib/helper"),i=t("../instances"),l=t("../update-geometry"),a=t("../update-scroll");e.exports=function(t){var e=i.get(t);r(t,e)}},{"../../lib/helper":6,"../instances":18,"../update-geometry":19,"../update-scroll":20}],16:[function(t,e,n){"use strict";function r(t,e,n,r){function o(n,r){var o=t.scrollTop,i=t.scrollLeft,l=Math.abs(n),a=Math.abs(r);if(a>l){if(0>r&&o===e.contentHeight-e.containerHeight||r>0&&0===o)return!e.settings.swipePropagation}else if(l>a&&(0>n&&i===e.contentWidth-e.containerWidth||n>0&&0===i))return!e.settings.swipePropagation;return!0}function s(e,n){a(t,"top",t.scrollTop-n),a(t,"left",t.scrollLeft-e),l(t)}function c(){Y=!0}function u(){Y=!1}function d(t){return t.targetTouches?t.targetTouches[0]:t}function p(t){return t.targetTouches&&1===t.targetTouches.length?!0:!(!t.pointerType||"mouse"===t.pointerType||t.pointerType===t.MSPOINTER_TYPE_MOUSE)}function f(t){if(p(t)){w=!0;var e=d(t);v.pageX=e.pageX,v.pageY=e.pageY,g=(new Date).getTime(),null!==y&&clearInterval(y),t.stopPropagation()}}function h(t){if(!w&&e.settings.swipePropagation&&f(t),!Y&&w&&p(t)){var n=d(t),r={pageX:n.pageX,pageY:n.pageY},i=r.pageX-v.pageX,l=r.pageY-v.pageY;s(i,l),v=r;var a=(new Date).getTime(),c=a-g;c>0&&(m.x=i/c,m.y=l/c,g=a),o(i,l)&&(t.stopPropagation(),t.preventDefault())}}function b(){!Y&&w&&(w=!1,clearInterval(y),y=setInterval(function(){return i.get(t)?Math.abs(m.x)<.01&&Math.abs(m.y)<.01?void clearInterval(y):(s(30*m.x,30*m.y),m.x*=.8,void(m.y*=.8)):void clearInterval(y)},10))}var v={},g=0,m={},y=null,Y=!1,w=!1;n&&(e.event.bind(window,"touchstart",c),e.event.bind(window,"touchend",u),e.event.bind(t,"touchstart",f),e.event.bind(t,"touchmove",h),e.event.bind(t,"touchend",b)),r&&(window.PointerEvent?(e.event.bind(window,"pointerdown",c),e.event.bind(window,"pointerup",u),e.event.bind(t,"pointerdown",f),e.event.bind(t,"pointermove",h),e.event.bind(t,"pointerup",b)):window.MSPointerEvent&&(e.event.bind(window,"MSPointerDown",c),e.event.bind(window,"MSPointerUp",u),e.event.bind(t,"MSPointerDown",f),e.event.bind(t,"MSPointerMove",h),e.event.bind(t,"MSPointerUp",b)))}var o=t("../../lib/helper"),i=t("../instances"),l=t("../update-geometry"),a=t("../update-scroll");e.exports=function(t){if(o.env.supportsTouch||o.env.supportsIePointer){var e=i.get(t);r(t,e,o.env.supportsTouch,o.env.supportsIePointer)}}},{"../../lib/helper":6,"../instances":18,"../update-geometry":19,"../update-scroll":20}],17:[function(t,e,n){"use strict";var r=t("../lib/helper"),o=t("../lib/class"),i=t("./instances"),l=t("./update-geometry"),a={"click-rail":t("./handler/click-rail"),"drag-scrollbar":t("./handler/drag-scrollbar"),keyboard:t("./handler/keyboard"),wheel:t("./handler/mouse-wheel"),touch:t("./handler/touch"),selection:t("./handler/selection")},s=t("./handler/native-scroll");e.exports=function(t,e){e="object"==typeof e?e:{},o.add(t,"ps-container");var n=i.add(t);n.settings=r.extend(n.settings,e),o.add(t,"ps-theme-"+n.settings.theme),n.settings.handlers.forEach(function(e){a[e](t)}),s(t),l(t)}},{"../lib/class":2,"../lib/helper":6,"./handler/click-rail":10,"./handler/drag-scrollbar":11,"./handler/keyboard":12,"./handler/mouse-wheel":13,"./handler/native-scroll":14,"./handler/selection":15,"./handler/touch":16,"./instances":18,"./update-geometry":19}],18:[function(t,e,n){"use strict";function r(t){function e(){s.add(t,"ps-focus")}function n(){s.remove(t,"ps-focus")}var r=this;r.settings=a.clone(c),r.containerWidth=null,r.containerHeight=null,r.contentWidth=null,r.contentHeight=null,r.isRtl="rtl"===u.css(t,"direction"),r.isNegativeScroll=function(){var e=t.scrollLeft,n=null;return t.scrollLeft=-1,n=t.scrollLeft<0,t.scrollLeft=e,n}(),r.negativeScrollAdjustment=r.isNegativeScroll?t.scrollWidth-t.clientWidth:0,r.event=new d,r.ownerDocument=t.ownerDocument||document,r.scrollbarXRail=u.appendTo(u.e("div","ps-scrollbar-x-rail"),t),r.scrollbarX=u.appendTo(u.e("div","ps-scrollbar-x"),r.scrollbarXRail),r.scrollbarX.setAttribute("tabindex",0),r.event.bind(r.scrollbarX,"focus",e),r.event.bind(r.scrollbarX,"blur",n),r.scrollbarXActive=null,r.scrollbarXWidth=null,r.scrollbarXLeft=null,r.scrollbarXBottom=a.toInt(u.css(r.scrollbarXRail,"bottom")),r.isScrollbarXUsingBottom=r.scrollbarXBottom===r.scrollbarXBottom,r.scrollbarXTop=r.isScrollbarXUsingBottom?null:a.toInt(u.css(r.scrollbarXRail,"top")),r.railBorderXWidth=a.toInt(u.css(r.scrollbarXRail,"borderLeftWidth"))+a.toInt(u.css(r.scrollbarXRail,"borderRightWidth")),u.css(r.scrollbarXRail,"display","block"),r.railXMarginWidth=a.toInt(u.css(r.scrollbarXRail,"marginLeft"))+a.toInt(u.css(r.scrollbarXRail,"marginRight")),u.css(r.scrollbarXRail,"display",""),r.railXWidth=null,r.railXRatio=null,r.scrollbarYRail=u.appendTo(u.e("div","ps-scrollbar-y-rail"),t),r.scrollbarY=u.appendTo(u.e("div","ps-scrollbar-y"),r.scrollbarYRail),r.scrollbarY.setAttribute("tabindex",0),r.event.bind(r.scrollbarY,"focus",e),r.event.bind(r.scrollbarY,"blur",n),r.scrollbarYActive=null,r.scrollbarYHeight=null,r.scrollbarYTop=null,r.scrollbarYRight=a.toInt(u.css(r.scrollbarYRail,"right")),r.isScrollbarYUsingRight=r.scrollbarYRight===r.scrollbarYRight,r.scrollbarYLeft=r.isScrollbarYUsingRight?null:a.toInt(u.css(r.scrollbarYRail,"left")),r.scrollbarYOuterWidth=r.isRtl?a.outerWidth(r.scrollbarY):null,r.railBorderYWidth=a.toInt(u.css(r.scrollbarYRail,"borderTopWidth"))+a.toInt(u.css(r.scrollbarYRail,"borderBottomWidth")),u.css(r.scrollbarYRail,"display","block"),r.railYMarginHeight=a.toInt(u.css(r.scrollbarYRail,"marginTop"))+a.toInt(u.css(r.scrollbarYRail,"marginBottom")),u.css(r.scrollbarYRail,"display",""),r.railYHeight=null,r.railYRatio=null}function o(t){return t.getAttribute("data-ps-id")}function i(t,e){t.setAttribute("data-ps-id",e)}function l(t){t.removeAttribute("data-ps-id")}var a=t("../lib/helper"),s=t("../lib/class"),c=t("./default-setting"),u=t("../lib/dom"),d=t("../lib/event-manager"),p=t("../lib/guid"),f={};n.add=function(t){var e=p();return i(t,e),f[e]=new r(t),f[e]},n.remove=function(t){delete f[o(t)],l(t)},n.get=function(t){return f[o(t)]}},{"../lib/class":2,"../lib/dom":3,"../lib/event-manager":4,"../lib/guid":5,"../lib/helper":6,"./default-setting":8}],19:[function(t,e,n){"use strict";function r(t,e){return t.settings.minScrollbarLength&&(e=Math.max(e,t.settings.minScrollbarLength)),t.settings.maxScrollbarLength&&(e=Math.min(e,t.settings.maxScrollbarLength)),e}function o(t,e){var n={width:e.railXWidth};e.isRtl?n.left=e.negativeScrollAdjustment+t.scrollLeft+e.containerWidth-e.contentWidth:n.left=t.scrollLeft,e.isScrollbarXUsingBottom?n.bottom=e.scrollbarXBottom-t.scrollTop:n.top=e.scrollbarXTop+t.scrollTop,a.css(e.scrollbarXRail,n);var r={top:t.scrollTop,height:e.railYHeight};e.isScrollbarYUsingRight?e.isRtl?r.right=e.contentWidth-(e.negativeScrollAdjustment+t.scrollLeft)-e.scrollbarYRight-e.scrollbarYOuterWidth:r.right=e.scrollbarYRight-t.scrollLeft:e.isRtl?r.left=e.negativeScrollAdjustment+t.scrollLeft+2*e.containerWidth-e.contentWidth-e.scrollbarYLeft-e.scrollbarYOuterWidth:r.left=e.scrollbarYLeft+t.scrollLeft,a.css(e.scrollbarYRail,r),a.css(e.scrollbarX,{left:e.scrollbarXLeft,width:e.scrollbarXWidth-e.railBorderXWidth}),a.css(e.scrollbarY,{top:e.scrollbarYTop,height:e.scrollbarYHeight-e.railBorderYWidth})}var i=t("../lib/helper"),l=t("../lib/class"),a=t("../lib/dom"),s=t("./instances"),c=t("./update-scroll");e.exports=function(t){var e=s.get(t);e.containerWidth=t.clientWidth,e.containerHeight=t.clientHeight,e.contentWidth=t.scrollWidth,e.contentHeight=t.scrollHeight;var n;t.contains(e.scrollbarXRail)||(n=a.queryChildren(t,".ps-scrollbar-x-rail"),n.length>0&&n.forEach(function(t){a.remove(t)}),a.appendTo(e.scrollbarXRail,t)),t.contains(e.scrollbarYRail)||(n=a.queryChildren(t,".ps-scrollbar-y-rail"),n.length>0&&n.forEach(function(t){a.remove(t)}),a.appendTo(e.scrollbarYRail,t)),!e.settings.suppressScrollX&&e.containerWidth+e.settings.scrollXMarginOffset<e.contentWidth?(e.scrollbarXActive=!0,e.railXWidth=e.containerWidth-e.railXMarginWidth,e.railXRatio=e.containerWidth/e.railXWidth,e.scrollbarXWidth=r(e,i.toInt(e.railXWidth*e.containerWidth/e.contentWidth)),e.scrollbarXLeft=i.toInt((e.negativeScrollAdjustment+t.scrollLeft)*(e.railXWidth-e.scrollbarXWidth)/(e.contentWidth-e.containerWidth))):e.scrollbarXActive=!1,!e.settings.suppressScrollY&&e.containerHeight+e.settings.scrollYMarginOffset<e.contentHeight?(e.scrollbarYActive=!0,e.railYHeight=e.containerHeight-e.railYMarginHeight,e.railYRatio=e.containerHeight/e.railYHeight,e.scrollbarYHeight=r(e,i.toInt(e.railYHeight*e.containerHeight/e.contentHeight)),e.scrollbarYTop=i.toInt(t.scrollTop*(e.railYHeight-e.scrollbarYHeight)/(e.contentHeight-e.containerHeight))):e.scrollbarYActive=!1,e.scrollbarXLeft>=e.railXWidth-e.scrollbarXWidth&&(e.scrollbarXLeft=e.railXWidth-e.scrollbarXWidth),e.scrollbarYTop>=e.railYHeight-e.scrollbarYHeight&&(e.scrollbarYTop=e.railYHeight-e.scrollbarYHeight),o(t,e),e.scrollbarXActive?l.add(t,"ps-active-x"):(l.remove(t,"ps-active-x"),e.scrollbarXWidth=0,e.scrollbarXLeft=0,c(t,"left",0)),e.scrollbarYActive?l.add(t,"ps-active-y"):(l.remove(t,"ps-active-y"),e.scrollbarYHeight=0,e.scrollbarYTop=0,c(t,"top",0))}},{"../lib/class":2,"../lib/dom":3,"../lib/helper":6,"./instances":18,"./update-scroll":20}],20:[function(t,e,n){"use strict";var r,o,i=t("./instances"),l=document.createEvent("Event"),a=document.createEvent("Event"),s=document.createEvent("Event"),c=document.createEvent("Event"),u=document.createEvent("Event"),d=document.createEvent("Event"),p=document.createEvent("Event"),f=document.createEvent("Event"),h=document.createEvent("Event"),b=document.createEvent("Event");l.initEvent("ps-scroll-up",!0,!0),a.initEvent("ps-scroll-down",!0,!0),s.initEvent("ps-scroll-left",!0,!0),c.initEvent("ps-scroll-right",!0,!0),u.initEvent("ps-scroll-y",!0,!0),d.initEvent("ps-scroll-x",!0,!0),p.initEvent("ps-x-reach-start",!0,!0),f.initEvent("ps-x-reach-end",!0,!0),h.initEvent("ps-y-reach-start",!0,!0),b.initEvent("ps-y-reach-end",!0,!0),e.exports=function(t,e,n){if("undefined"==typeof t)throw"You must provide an element to the update-scroll function";if("undefined"==typeof e)throw"You must provide an axis to the update-scroll function";if("undefined"==typeof n)throw"You must provide a value to the update-scroll function";"top"===e&&0>=n&&(t.scrollTop=n=0,t.dispatchEvent(h)),"left"===e&&0>=n&&(t.scrollLeft=n=0,t.dispatchEvent(p));var v=i.get(t);"top"===e&&n>=v.contentHeight-v.containerHeight&&(n=v.contentHeight-v.containerHeight,n-t.scrollTop<=1?n=t.scrollTop:t.scrollTop=n,t.dispatchEvent(b)),"left"===e&&n>=v.contentWidth-v.containerWidth&&(n=v.contentWidth-v.containerWidth,n-t.scrollLeft<=1?n=t.scrollLeft:t.scrollLeft=n,t.dispatchEvent(f)),r||(r=t.scrollTop),o||(o=t.scrollLeft),"top"===e&&r>n&&t.dispatchEvent(l),"top"===e&&n>r&&t.dispatchEvent(a),"left"===e&&o>n&&t.dispatchEvent(s),"left"===e&&n>o&&t.dispatchEvent(c),"top"===e&&(t.scrollTop=r=n,t.dispatchEvent(u)),"left"===e&&(t.scrollLeft=o=n,t.dispatchEvent(d))}},{"./instances":18}],21:[function(t,e,n){"use strict";var r=t("../lib/helper"),o=t("../lib/dom"),i=t("./instances"),l=t("./update-geometry"),a=t("./update-scroll");e.exports=function(t){var e=i.get(t);e&&(e.negativeScrollAdjustment=e.isNegativeScroll?t.scrollWidth-t.clientWidth:0,o.css(e.scrollbarXRail,"display","block"),o.css(e.scrollbarYRail,"display","block"),e.railXMarginWidth=r.toInt(o.css(e.scrollbarXRail,"marginLeft"))+r.toInt(o.css(e.scrollbarXRail,"marginRight")),e.railYMarginHeight=r.toInt(o.css(e.scrollbarYRail,"marginTop"))+r.toInt(o.css(e.scrollbarYRail,"marginBottom")),o.css(e.scrollbarXRail,"display","none"),o.css(e.scrollbarYRail,"display","none"),l(t),a(t,"top",t.scrollTop),a(t,"left",t.scrollLeft),o.css(e.scrollbarXRail,"display",""),o.css(e.scrollbarYRail,"display",""))}},{"../lib/dom":3,"../lib/helper":6,"./instances":18,"./update-geometry":19,"./update-scroll":20}]},{},[1]);

// AUDIO CONTEXT
window.AudioContext = window.AudioContext || window.webkitAudioContext ;
if (window.AudioContext) {
	var audioContext = new AudioContext(),
		audiosource = audioContext.createBufferSource(); 	// creates a sound source
} else {
	audiosource = null;
}



/*****************************************************
	-	THE  TIME LINE AND ANIMATION FUNCTIONS 	-
*****************************************************/

var tpLayerTimelinesRev = new function(){
	var t = this,
		u = new Object(),			
		sortMode = "time",
		__ctime,
		__ctimeb,
		__ctimei ,
		__coffset = 0; 

	t.timelinetype ="absolute";
	t.mainMaxTimeLeft = 0;
	t.layout="desktop";
	t.timercorrectur = 0;	

	/***********************************************************
		-	INITIALISE THE TIMELINE AND ANIMATION ELEMENTS	-
	***********************************************************/

	t.init = function() {
		u = UniteLayersRev;
		g_rebuildTimer =999;
		g_slideTime = u.getMaintime();
		g_keyTimer = 0;
		
		t.mainMaxTimeLeft = jQuery('#mastertimer-maxtime').position().left;
		
		initSlideDuration();
		initSortbox();
		initMasterTimer();
		preparePeviewAnimations();
		prepareLoopAnimations();
		showHideTimeines();
		basicClicksAndHovers();
		addIconFunction();

		t.addToSortbox();
		//jQuery('.master-rightcell .layers-wrapper, .master-leftcell .layers-wrapper, #divLayers-wrapper').perfectScrollbar("update");
		
		jQuery('#slide_transition, #slot_amount, #transition_rotation').change(function() {
			
			setFakeAnim();
		});
		
		
		var timer;
		jQuery(window).resize(function() {
				clearTimeout(timer);
				timer = setTimeout(function(){
					t.resetSlideAnimations(false);
				},250);
			});
		var keyboardallowed = false;
		
		jQuery('#thelayer-editor-wrapper').hover(function() {

			keyboardallowed = true;						
						
		},function() {
			keyboardallowed = false;					
		})


		jQuery('#fake-select-title-wrapper').click(function() {
			jQuery('#slide-animation-settings-content-tab').click();
			jQuery('html,body').animate({scrollTop: (-100 + jQuery('#slide-animation-settings-content-tab').offset().top)},200);
		})

		jQuery('.slide-trans-menu-element').each(function() {
			var b = jQuery(this);
			b.text(b.text().toLowerCase());
			b.click(function() {
				var b = jQuery(this);
				jQuery('.slide-trans-menu-element').removeClass("selected");
				b.addClass("selected");
				jQuery('.slide-trans-checkelement').hide();
				jQuery("."+b.data('reference')).show();
			});
		});

		jQuery('.slide-trans-menu-element').first().click();
		
		var createListOfTrans = function() {
			var c = jQuery('.slide-trans-cur-ul');
			for(var key in choosen_slide_transition){
				var data_string = '';
				data_string+= ' data-duration="'+transition_settings['duration'][key]+'"';
				data_string+= ' data-ease_in="'+transition_settings['ease_in'][key]+'"';
				data_string+= ' data-ease_out="'+transition_settings['ease_out'][key]+'"';
				data_string+= ' data-rotation="'+transition_settings['rotation'][key]+'"';
				data_string+= ' data-slot="'+transition_settings['slot'][key]+'"';
				
				c.append('<li value="'+choosen_slide_transition[key]+'"'+data_string+' class="justaddedtrans draggable-trans-element">'+jQuery('input[name="slide_transition[]"][value="'+choosen_slide_transition[key]+'"]').parent().text()+'<i class="remove-trans-from-list eg-icon-cancel"></i></li>');
				jQuery('.justaddedtrans').data('animval',choosen_slide_transition[key]);
				jQuery('.justaddedtrans').removeClass("justaddedtrans");
			}
			
			setFakeAnim();
		};
		
		if(typeof(choosen_slide_transition) !== 'undefined'){ //if not exists, then we are at static slide
			createListOfTrans();
		}
		
		var etl = new punchgs.TimelineLite(),
			ord = 0,
			sto = jQuery('#form_slide_params').offset(),
			tou;

		jQuery('body').on('click','.remove-trans-from-list',function() {
			var t = jQuery(this),
				li = t.parent(),
				v = li.data('animval'),
				found = false;

			jQuery('.slide-trans-checkelement').each(function() {
				var d = jQuery(this),
					inp = d.find('input');
				
				if (inp.val()==v) {
					inp.removeAttr('checked');
					found = true;
				}
			});
			if (found && jQuery('.remove-trans-from-list').length>1) {
				li.remove();
				jQuery('.slide-trans-cur-ul li:first-child').click();
			}else{
				alert(rev_lang.cant_remove_last_transition);
			}
			
			return false;
			
		});

		jQuery('.slide-trans-checkelement').on("mouseover", function(e) {		

			var inp = jQuery(this).find('input[name="slide_transition[]"]'),
				a = jQuery('.slide-trans-example-inner .slotholder'),
				b = jQuery('.slide-trans-example-inner .oldslotholder'),
				examp = jQuery('.slide-trans-example');

			
			
			
				a.find('.slot').each(function() { jQuery(this).remove();});
				b.find('.slot').each(function() { jQuery(this).remove();});
				etl.kill()
				punchgs.TweenLite.set(a,{clearProps:"transform"});
				punchgs.TweenLite.set(b,{clearProps:"transform"});
				punchgs.TweenLite.set(a.find('.defaultimg'),{clearProps:"transform",autoAlpha:1});
				punchgs.TweenLite.set(b.find('.defaultimg'),{clearProps:"transform",autoAlpha:1});
				
				etl = slideAnimation(a, b,inp.val(),etl,true);
				etl.pause(0.001);
				punchgs.TweenLite.to(examp,0.2,{top:(e.pageY - sto.top),overwrite:"all",autoAlpha:1,ease:punchgs.Power3.easeInOut,onComplete:function() {
					setTimeout(function() {
							etl.play();
						},100);
				}});
			

		});

		jQuery('.slide-trans-checkelement').on("mouseleave",function() {
			clearTimeout(tou);
			var inp = jQuery(this).find('input[name="slide_transition[]"]'),
				a = jQuery('.slide-trans-example-inner .slotholder'),
				b = jQuery('.slide-trans-example-inner .oldslotholder');
			
			punchgs.TweenLite.to(jQuery('.slide-trans-example'),0.2,{autoAlpha:0,delay:0.2});
		});

		jQuery('input[name="slide_transition[]"]').on("change",function() {
			if (jQuery(this).is(":checked")) {
				var data_string = '';
				data_string+= ' data-duration="default"';
				data_string+= ' data-ease_in="default"';
				data_string+= ' data-ease_out="default"';
				data_string+= ' data-rotation="0"';
				data_string+= ' data-slot="default"';
				
				jQuery('.slide-trans-cur-ul').append('<li value="'+jQuery(this).val()+'"'+data_string+' class="justaddedtrans draggable-trans-element">'+jQuery(this).parent().text()+'<i class="remove-trans-from-list eg-icon-cancel"></i></li>')					
				jQuery('.justaddedtrans').data('animval',jQuery(this).val());
				jQuery('.justaddedtrans').removeClass("justaddedtrans");
			} else {
				if (jQuery('.remove-trans-from-list').length>1) {
					jQuery('.slide-trans-cur-ul').find('li:data[value='+jQuery(this).val()+']').remove();
					jQuery('.slide-trans-cur-ul li:first-child').click();
				}else{
					jQuery(this).attr('checked', true);
					alert(rev_lang.cant_remove_last_transition);
				}
				
			}
			
			setFakeAnim();
		});
		
		jQuery('body').on('click', '.slide-trans-cur-ul li', function(){
			jQuery('.slide-trans-cur-ul li').each(function(){
				jQuery(this).removeClass('selected');
			});
			
			jQuery(this).addClass('selected');
			
			jQuery('input[name="slot_amount"]').val(jQuery(this).data('slot'));
			jQuery('input[name="transition_rotation"]').val(jQuery(this).data('rotation'));
			jQuery('input[name="transition_duration"]').val(jQuery(this).data('duration'));
			jQuery('select[name="transition_ease_in"] option[value="'+jQuery(this).data('ease_in')+'"]').attr('selected', true);
			jQuery('select[name="transition_ease_out"] option[value="'+jQuery(this).data('ease_out')+'"]').attr('selected', true);
		});
		
		jQuery('.slide-trans-cur-ul li:first-child').click();
		
		jQuery('input[name="slot_amount"]').change(function(){
			jQuery('.slide-trans-cur-ul li.selected').data('slot', jQuery(this).val());
		});
		jQuery('input[name="transition_rotation"]').change(function(){
			jQuery('.slide-trans-cur-ul li.selected').data('rotation', jQuery(this).val());
		});
		jQuery('input[name="transition_duration"]').change(function(){
			jQuery('.slide-trans-cur-ul li.selected').data('duration', jQuery(this).val());
			setSlideTransitionTimerBar();
		});
		jQuery('select[name="transition_ease_in"]').change(function(){
			jQuery('.slide-trans-cur-ul li.selected').data('ease_in', jQuery(this).val());
		});
		jQuery('select[name="transition_ease_out"]').change(function(){
			jQuery('.slide-trans-cur-ul li.selected').data('ease_out', jQuery(this).val());
		});

		jQuery('.slide-trans-cur-ul').sortable({
			containment: ".slide-trans-cur-selected",
			stop:function() {
				setTimeout(function() {					
					setFakeAnim();
				},200);
			}
		})
			

		jQuery('#abs_rel_timeline').on('change',function() {
			t.timelinetype = jQuery(this).val();			
			t.updateAllLayerTimeline();
		})

		// END OF MAIN TRANSITION SELECTOR 
		jQuery(document).on('keydown', function(event) {	
			 var noinputfocus = jQuery('input:focus').length>0;
			 
			 if (event.ctrlKey || event.metaKey || event.shiftKey) {
			 
		        switch (String.fromCharCode(event.which).toLowerCase()) {
		        	case 's':
		     
		        		if (!event.shiftKey) {
		           			event.preventDefault();
		           			if (jQuery('#button_save_static_slide-tb').length>0)
		           				jQuery('#button_save_static_slide-tb').click();	
		           			else
		            			jQuery('#button_save_slide-tb').click();
		            	}
		            break;		      
		            case 'z':
						if ((event.metaKey || event.ctrlKey) && !noinputfocus) { 		            	
			            	event.preventDefault();
			            	if (event.shiftKey)
			            		u.oneStepRedo();
			            	else
			            		u.oneStepUndo();
			            }
		            break;  
		            case 'y':		            
		            	if ((event.ctrlKey || event.metaKey) && !noinputfocus) {
		            		event.preventDefault();
		            		u.oneStepRedo();
		            	}
		            break;  

		    	}
		    }
		    switch (event) {
				
			}
		});

		jQuery("body").on("keydown keyup",function(e) {
			
			
			if (jQuery('#layer_text').is(":focus")) return true;
			if (jQuery('#layer_text_toggle').is(":focus")) return true;
			
			var code = (e.keyCode ? e.keyCode : e.which),
			dist = jQuery(document.activeElement).data('steps')!=undefined ? parseFloat(jQuery(document.activeElement).data('steps')):1,
			x = Number(parseInt(jQuery('#layer_left').val(),0)),
			y = Number(parseInt(jQuery('#layer_top').val(),0));
			
			if (e.shiftKey) dist = dist*10; 
									
			switch (jQuery(document.activeElement).get(0).tagName.toLowerCase()) {
				case "INPUT":
				case "input":				
					var cv = parseFloat(jQuery(document.activeElement).val());
					
					if (jQuery(document.activeElement).data('suffix')!=undefined && !jQuery(document.activeElement).data('suffix').match(/auto/g)) {
						cv=Number(cv);
						if (jQuery.isNumeric(cv)) 
							switch(code) {
							    case 38: 
									if (e.type=="keyup") reBlurFocus(dist,cv,jQuery(document.activeElement));
									return false;
						        break;
						        case 40:									
									if (e.type=="keyup") reBlurFocus(-dist,cv,jQuery(document.activeElement));			 	
									return false;
						        break;
							}
					}							
				break;
				case "textarea":				
					return true;
				break;
				default:					
					switch(code) {
						case 8:
						case 46:
							e.preventDefault();
							if (e.type=="keydown") {								
								jQuery('#button_delete_layer').click();
								window.deletecalled = true;
							}
						break;
					}

					if (keyboardallowed) 						
						switch(code) {						
							
						    case 40: 
								if (e.type=="keyup") 
									setTimeout(function() {u.updateMovedLayers()},50);
								else
									u.adjustSelectedLayerPositions("top",dist);
								return false;
						    break;
						    case 38:
							    if (e.type=="keyup")
									setTimeout(function() {u.updateMovedLayers();},50);
								else
									u.adjustSelectedLayerPositions("top",-1*dist);				
								return false;
						    break;
						    case 37:
							    if (e.type=="keyup")					    		
									setTimeout(function() {u.updateMovedLayers();},50);
								else
									u.adjustSelectedLayerPositions("left",-1*dist);					
								return false;
						    break;
						    case 39:
							    if (e.type=="keyup") 						    		
									setTimeout(function() {u.updateMovedLayers();},50);	
								else											
									u.adjustSelectedLayerPositions("left",dist);						
								return false;
						    break;
						}					
				break;
			}
		});


		// DEEP LINK INPUT FIELD ADD ONS
		jQuery('.input-deepselects').each(function() {
			var inp = jQuery(this);
			inp.wrap('<span class="inp-deep-wrapper"></span>');
			inp.parent().append('<div class="inp-deep-list"></div>');
			var dl = inp.parent().find('.inp-deep-list'),
				txt = '<span class="inp-deep-listitems">',
				rev = inp.data('reverse'),
				minw = inp.data('deepwidth'),
				list = inp.data('selects') != undefined ? inp.data('selects').split("||") : "",
				vals = inp.data('svalues') != undefined ? inp.data('svalues').split("||") : "",
				icos = inp.data('icons') != undefined ? inp.data('icons').split("||") : "",
				id = inp.attr('id');
				
			if (minw!==undefined)
				punchgs.TweenLite.set(dl,{minWidth:minw+"px"});

			if (rev=="on") {
				txt = txt+"<span class='reverse_input_wrapper'><span class='reverse_input_text'>Direction Auto Reverse</span><input class='reverse_input_check tp-moderncheckbox' name='"+id+"_reverse' id='"+id+"_reverse' type='checkbox'></span>";
			}
			if (list!==undefined && list!="") {							
				jQuery.each(list,function(i){
					var v = vals[i] || "",
						l = list[i] || "",
						i = icos[i] || "";								
					txt = txt + "<span class='inp-deep-prebutton' data-val='"+v+"'><i class='eg-icon-"+i+"'></i>"+l+"</span>";
				});	
			}
			txt = txt + "</span>";
			
			dl.append(txt);
			if (rev=="on") {
				RevSliderSettings.onoffStatus(jQuery('input[name="'+id+'_reverse"]'));
			}
		})

		jQuery('body').on('click','.inp-deep-prebutton',function() {
			var btn = jQuery(this),
				inp = btn.closest('.inp-deep-wrapper').find('input');
			inp.val(btn.data('val'));			
			inp.blur();
			inp.focus();
			inp.trigger("change");						
		});

		jQuery('body').on('click','.input-deepselects',function() {
				jQuery(this).closest('.inp-deep-wrapper').find('.inp-deep-list').addClass("visible");
				jQuery(this).closest('.inp-deep-wrapper').addClass("selected-deep-wrapper");
		})

		jQuery('.inp-deep-wrapper').on('mouseleave',function() {
			jQuery(this).find('.inp-deep-list').removeClass("visible");
			jQuery(this).removeClass("selected-deep-wrapper");
		});


		// SHOW HIDE MASKING PARAMETERS
		jQuery('input[name="masking-start"]').on("change",function() {		
			if (jQuery(this).attr('checked') ==="checked")
			 	jQuery('.mask-start-settings').show();
			 else									
			 	jQuery('.mask-start-settings').hide();
		})	

		jQuery('input[name="masking-end"]').on("change",function() {			
			if (jQuery(this).attr('checked') ==="checked")
			 	jQuery('.mask-end-settings').show();
			 else									
			 	jQuery('.mask-end-settings').hide();
		});


		

		// OPEN QUICK TIME LINE INPUT FIELDS		
		jQuery('body').on('click','.show_timeline_helper',function() {
			var btn = jQuery(this),
				li = btn.closest('li'),
				tf = btn.closest('.timeline_frame'),
				d = jQuery('#timline-manual-dialog'),
				pl = tf.position().left,
				lw = li.width(),
				fi = tf.data('frameindex'),
				objLayer = u.getLayerByUniqueId(li.data('uniqueid')),
				st = objLayer.frames["frame_"+fi].time,
				sp = objLayer.frames["frame_"+fi].speed;


			d.appendTo(li);
			pl = fi===999 ? (pl-d.width()+tf.width()-20) : fi===0 ? pl : (pl-d.width()/2)+10;
			pl = pl<20 ? 20 : pl;			
			d.css({left:pl});

			// Update Frame Start and Speed in Quick Editor

			jQuery('#clayer_start_time').val(st)
			jQuery('#clayer_start_speed').val(sp)
			d.data('frameindex',fi);
			d.data('uniqueid',objLayer.unique_id);
			d.show();
		})

		// CLOSE QUICK TIME LINE INPUT FIELDS
		jQuery('body').on('click','#timline-manual-closer',function() {
			var d = jQuery('#timline-manual-dialog');
			d.hide();
			d.appendTo(jQuery('#thelayer-editor-wrapper'));
			
		});

		jQuery('body').on('click','#timline-manual-apply',function() {	

			var btn = jQuery(this),
				d = jQuery('#timline-manual-dialog'),																
				fi = d.data('frameindex'),
				frame = document.getElementById("tl_"+d.data('uniqueid')+"_frame_"+fi)
				objLayer = u.getLayerByUniqueId(d.data('uniqueid')),
				objUpdate = {frames:{}};
			
			t.recordFrameStatus(frame);

			objUpdate.frames["frame_"+fi] = {};
			
			objUpdate.frames["frame_"+fi].time = jQuery('#clayer_start_time').val();
			objUpdate.frames["frame_"+fi].speed = jQuery('#clayer_start_speed').val();
	
			d.hide();	
			d.appendTo(jQuery('#thelayer-editor-wrapper'));			
			u.updateLayer(objLayer.serial,objUpdate);
			t.updateLayerTimeline(objLayer);	

	  		t.updateTLFrame(frame,"trigger");
	  		t.updateAllSelectedLayerTimeline(frame);	 	
	  		
			t.updateAllLayerTimeline();  	//PERFORMANCE WIN, ONLY CALL IF LAYER IS A GROUP OR COLUMN ETC... 
		});

		

		// SELECT / DESELECT ALL LAYERS
		jQuery('body').on('click','#timing-all-onoff-checkbox',function() {
			var b = jQuery(this),
				objUpdate = {};
			
			if (b.attr('checked')!="checked" || jQuery('.mastertimer-timeline-selector-row.selected').length==jQuery('.layer-on-timeline-selector').length) {				
				jQuery('.mastertimer-timeline-selector-row.selected').removeClass("selected");
				jQuery('.layer-on-timeline-selector').removeAttr('checked');
			} else {				
				jQuery('.layer-on-timeline-selector').attr('checked','checked');
				jQuery('.sortable_elements .mastertimer-timeline-selector-row').addClass("selected");
			}
			t.checkMultipleSelectedItems();
			checkAvailableAutoTimes();
		});

		jQuery('body').on('click','.list-of-layer-links', function() {
			jQuery(this).toggleClass("showmenow");
		});

		jQuery('body').on('click','.timing-layer-link-type-element',function() {
			var ltype = jQuery(this).data('linktype'),
				objUpdate = {};
			u.selectedLayers = [];
			jQuery('.layer-on-timeline-selector').each(function() {
				var inp = jQuery(this),
					uniqueid = inp.closest('.mastertimer-layer').data('uniqueid'),
					objLayer = u.getLayerByUniqueId(uniqueid);

				if (objLayer.groupLink == ltype) {
					inp.attr('checked','checked');
					u.selectedLayers.push(uniqueid);	
					objLayer.references.htmlLayer.addClass("multiplelayerselected");					
				} else {
					inp.removeAttr('checked','checked');
					objLayer.references.htmlLayer.removeClass("multiplelayerselected");				
				}				
			});	
		});
		jQuery('body').on('change','.layer-on-timeline-selector',function() { t.checkMultipleSelectedItems() });		
	}

	t.checkMultipleSelectedItems = function(disableall) {
		u.selectedLayers = [];
		var objUpdate = {};
		jQuery('.layer-on-timeline-selector').each(function() {
			var inp = jQuery(this),
				objLayer = u.getLayerByUniqueId(inp.closest('.mastertimer-layer').data('uniqueid'));

			if (inp.attr('checked') && disableall!==true) {
				objLayer.references.htmlLayer.addClass("multiplelayerselected");
				u.selectedLayers.push(objLayer.unique_id);				
			} else {
				inp.removeAttr('checked');
				objLayer.references.htmlLayer.removeClass("multiplelayerselected");				
			}			
		});					
	}

	// COMPARE SLIDE LENGTH TO LAYERS END, AND UPDATE THE END OF THE LAYERS AS NEEDED
	t.compareLayerEndsVSSlideEnd = function() {				
		var maxtime = (t.mainMaxTimeLeft)*10;		
		jQuery.each(u.arrLayers,function(i,objLayer) {						
			if (objLayer.endWithSlide || maxtime<objLayer.frames["frame_999"].time - objLayer.frames["frame_999"].speed) {				
				objLayer.frames["frame_999"].time = maxtime+objLayer.frames["frame_999"].speed;
				//t.updateLayerTimeline(jQuery('#layer_sort_time_'+objLayer.serial+" .timeline .tl-fullanim"));
			}
		});		
		t.updateAllLayerTimeline();
	}

	function checkAvailableAutoTimes() {
		var sel = jQuery('.mastertimer-timeline-selector-row.selected').length;				
			jQuery('.autotiming-action').addClass("notclickable");
		
		if (sel>1) {
			jQuery('.autotiming-action').removeClass("notclickable");			
		} else

		if (sel==1) {
			jQuery('.autotiming-action-3').removeClass("notclickable");
			jQuery('.autotiming-action-4').removeClass("notclickable");
			jQuery('.autotiming-action-5').removeClass("notclickable");
			jQuery('.autotiming-action-6').removeClass("notclickable");
		}
	}
	
	function addIconFunction() {
		jQuery('#tp-addiconbutton, .addbutton-icon').click(function() {


			var buttons = {"Close":function(){jQuery("#dialog_insert_button").dialog("close")}}			
			jQuery("#dialog_insert_icon").dialog({
				//buttons:buttons,
				width:491,
				height:500,
				dialogClass:"tpdialogs",
				resize:function() {
						var di = jQuery('#dialog_insert_icon');
						di.css({width:(di.parent().width()-30),height:(di.parent().height()-60)});	
				},
				modal:true,
				create:function(event,ui) {
					var cont = jQuery(event.target),
						sheets = document.styleSheets,
						di = jQuery('#dialog_insert_icon');
					di.parent().css({padding:"0px", border:"none", borderRadius:"0px"});
					di.parent().find('.ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix.ui-draggable-handle').addClass("tp-slider-new-dialog-title");
					//css({fontSize:"14px", fontWeight:"400",lineHeight:"35px"});
					if (sheets)
					jQuery.each(sheets,function(index,sheet) {
						var found = false,
							markup = "";	
						try{
							if (sheet.cssRules !==null & sheet.cssRules!=undefined)									
								jQuery.each(sheet.cssRules, function(index,rule) {
									
									if (rule && rule!==null && rule !=="null" && rule.selectorText!=undefined) {
										jQuery.each(rs_icon_sets,function(j,prefix){
											if (rule.selectorText.split(prefix).length>1 && rule.cssText.split("content").length>1) {																							
												var csname = rule.selectorText.split("::before")[0].split(":before")[0];
												
												if (csname!=undefined)  {
													csname = csname.split(".")[1];	
													if (csname!=undefined) {													
														if (found==false) {
																found=true;
																markup = '<ul class="tp-icon-preview-list lastaddediconset">';
														}
														markup=markup + '<li><i class="'+csname+'"></i></li>';
													}
												}
											}							
										})
									}
								});
						} catch(e) {}
						if (found) {
							markup = markup + '</ul>';
							cont.append(markup);
							var fli = cont.find('.lastaddediconset').find('li').first().find('i');
							cont.find('.lastaddediconset').prepend('<h3>'+fli.css("fontFamily")+'</h3>').removeClass("lastaddediconset");
						}
					})
					cont.on("click","li",function() {

						if (jQuery('#dialog_addbutton').length>0 && jQuery('#dialog_addbutton').closest('.tpdialogs').css('display')!=="none") {
							if (jQuery('.addbutton-icon:visible').length>0) {
								jQuery('.addbutton-icon').html(jQuery(this).html());
								jQuery("#dialog_insert_icon").dialog("close");
								setExampleButtons();
							} else {
								if (jQuery('.lasteditedlayertext').length>0)
									jQuery('.lasteditedlayertext').val(jQuery('.lasteditedlayertext').val()+jQuery(this).html()).blur().focus();	
								else
									jQuery('#layer_text').val(jQuery('#layer_text').val()+jQuery(this).html()).blur().focus();										
								jQuery("#dialog_insert_icon").dialog("close");
							}																												
						} else {
							if (jQuery('.lasteditedlayertext').length>0)
								jQuery('.lasteditedlayertext').val(jQuery('.lasteditedlayertext').val()+jQuery(this).html()).blur().focus();
							else
								jQuery('.layer_text').val(jQuery('#layer_text').val()+jQuery(this).html()).blur().focus();
							jQuery("#dialog_insert_icon").dialog("close");
						}
						
						u.updateLayerFromFields();
						
					});
				}
			});			
		});

	}

	function reBlurFocus(dist,cv,el) {	

		if (!jQuery('#rs-animation-tab-button').hasClass("selected") && !jQuery('#rs-loopanimation-tab-button').hasClass("selected")) {
			cv = Number(cv) +dist;			
			cv=Math.round(cv*100)/100;		
			el.val(cv);	
			/*  PUT THIS IN EDIT_LAYERS.js */
			jQuery(':focus').blur();
			
			el.focus();
		}
	}



	/***********************************************************
		-	INITIALISE CLICK, LOOP, INOUT ANIMATION HANDLERS	-
	***********************************************************/
	function basicClicksAndHovers() {
		// CHANGING ANY STYLE SHOULD REBUILD THE LAYERS
		jQuery('.rs-staticcustomstylechange').change(function() {

			//setTimeout(function() {
					
					t.rebuildLayerIdle(jQuery('.slide_layer.layer_selected'));
			//	},20);
		})


		// HANDLING OF LAYER ANIMATIONS STOP/PLAY OF SINGLE LAYERS
		jQuery('.rs-layer-settings-tabs li').click(function() {

				var li = jQuery(this);
				if ((li.attr('id') != '#rs-animation-tab-button' && li.closest('#rs-animation-tab-button').length==0) &&
					(li.attr('id') != '#rs-loopanimation-tab-button' && li.closest('#rs-loopanimation-tab-button').length==0)) {

						t.stopAllLayerAnimation();
						setTimeout(function() {
							u.removeCurrentLayerRotatable();
							u.makeCurrentLayerRotatable();
							jQuery('#hide_layer_content_editor').click();
						},19);
				} else
				if (!jQuery(this).hasClass("selected")) {
					t.stopAllLayerAnimation();
					if (li.attr('id') == '#rs-animation-tab-button' || li.closest('#rs-animation-tab-button').length!=0) {
						t.animateCurrentSelectedLayer(3);
						u.removeCurrentLayerRotatable();
						jQuery('#hide_layer_content_editor').click();
					} else {
						t.callCaptionLoops();
						u.removeCurrentLayerRotatable();
						jQuery('#hide_layer_content_editor').click();
					}
				}
		});

		// CLICK ON LAYERS ARE SHOULD STOP ANY LAYER ANIMATION OR LOOPS
		jQuery('#divLayers').click(function() {
			

			t.stopAllLayerAnimation();
			u.removeCurrentLayerRotatable();			
			
			setTimeout(function() {
				if (t.checkAnimationTab()) 
					t.animateCurrentSelectedLayer(4);
				
				if (t.checkLoopTab()) 
					t.callCaptionLoops();
			},19);				

		})

		// Click on LayerAnimation Button the current Selected Layer should be Animated
		jQuery('#layeranimation-playpause').click(function() {

				var btn = jQuery(this);
				if (btn.hasClass("inpause")) {
					btn.removeClass("inpause");
					if (t.checkAnimationTab()) {
						t.stopAllLayerAnimation();
						t.animateCurrentSelectedLayer(5);
						u.removeCurrentLayerRotatable();												
					}
				} else {
					btn.addClass("inpause");

					t.stopAllLayerAnimation();
				}
			})

		// Click on LayerAnimation Button the current Selected Layer should be Animated
		jQuery('#loopanimation-playpause').click(function() {

				var btn = jQuery(this);
				if (btn.hasClass("inpause")) { 
					btn.removeClass("inpause");
					if (t.checkLoopTab()) {
						t.stopAllLayerAnimation();						
						t.callCaptionLoops();						
						u.removeCurrentLayerRotatable();						
					}
				} else {
					btn.addClass("inpause");
					t.stopAllLayerAnimation();					
				}
			})
			
				
		jQuery('#rs-style-tab-button').click(function() {
			setTimeout(function() {
					jQuery('.slide_layer').each(function() {
						
						t.rebuildLayerIdle(jQuery(this));	
						var inlayer = jQuery(this).find('.innerslide_layer').first();
						if (inlayer.length>0 && inlayer.data('hoveranim')!=undefined) {
							var tl = inlayer.data('hoveranim');
							tl.seek(tl.endTime());
						}					
					})
				},19);	
		});
		
		jQuery('#toggle-idle-hover').click(function() {
			setTimeout(function() {					
					t.rebuildLayerIdle(jQuery('.slide_layer.layer_selected'));
			},19);
		})
		

		
		jQuery('#style_form_wrapper').on("colorchanged",function() {			
			t.rebuildLayerIdle(jQuery('.slide_layer.layer_selected'));				
		})
	}

	t.resetIdleSelector = function() {
		var bt = jQuery('#toggle-idle-hover');
		bt.addClass("idleisselected").removeClass("hoverisselected");
		jQuery('#tp-idle-state-advanced-style').show();
		jQuery('#tp-hover-state-advanced-style').hide();
	}

	/************************************************************************************************************************
				-	CHECK IF ANIMATION AND LOOP ANIMATION TABS ARE ACTIVATED AND IN IDLE OR PLAY MODE ARE	-
	**************************************************************************************************************************/

	t.checkAnimationTab = function() {
		return (!jQuery('#layeranimation-playpause').hasClass("inpause") && jQuery('#rs-animation-tab-button').hasClass("selected"));
	}

	t.checkLoopTab = function() {
		return (!jQuery('#loopanimation-playpause').hasClass("inpause") && jQuery('#rs-loopanimation-tab-button').hasClass("selected"));
	}



	/**********************************************************
					-	ANIMATION HANDLING	-
	**********************************************************/

	/*********************************
	-	PREPARE THE ANIMATIONS	-
	********************************/

	function preparePeviewAnimations() {

		// NORMAL FIELDS CHANGED IN IN/OUT ANIMATION
		jQuery('.rs-inoutanimationfield').on("change",
				function() {					
					if (t.checkAnimationTab()) {
						t.stopAllLayerAnimation();
						setTimeout(function() {						
								t.animateCurrentSelectedLayer(50);
						},19);
					}
				});
		// NORMAL FIELDS CHANGED IN LOOP ANIMATIONS
	}

	function prepareLoopAnimations() {

		// NORMAL FIELDS CHANGED IN IN/OUT ANIMATION
		jQuery('.rs-loopanimationfield').on("change",
				function() {
					if (t.checkLoopTab()) {
						t.stopAllLayerAnimation();
						setTimeout(function() {
								t.callCaptionLoops();
						},19);

					}
				});

	}

	/******************************
		-	STOP ALL ANIMATION	-
	********************************/

	t.stopAllLayerAnimation = function() {
		
		document.getElementById('mastertimer-playpause-wrapper').innerHTML = '<i class="eg-icon-play"></i><span>PLAY</span>';
		
		punchgs.TweenLite.set(document.getElementsByClassName('tp-mask-wrap'),{clearProps:"transform",overwrite:"all"});
		jQuery('.tp-showmask').removeClass('tp-showmask');
		
		var ils = document.getElementsByClassName("innerslide_layer");
		for (var i=0;i<ils.length;i++) {
			var nextcaption = jQuery(ils[i]);			
				if (ils[i].parentNode.classList.contains('rs-preview-inside-looper') || ils[i].parentNode.parentNode.classList.contains('rs-preview-inside-looper'))
					nextcaption.unwrap();

			if (nextcaption.data('tl')!=undefined) {				
				var tl = nextcaption.data('tl');
				tl.clear();
				tl.kill();				
				try{
					if (nextcaption.data('mySplitText')) 
							nextcaption.data('mySplitText').revert();
					} catch(e) {}
				punchgs.TweenLite.set(nextcaption[0].parentNode,{autoAlpha:1});
				
				t.rebuildLayerIdle(nextcaption.closest('.slide_layer'));
				u.removeCurrentLayerRotatable();
			}
		}
		
		punchgs.TweenLite.set(document.getElementById('startanim_wrapper'),{autoAlpha:0});
		punchgs.TweenLite.set(document.getElementById('endanim_wrapper'),{autoAlpha:0});

	}


	/******************************
		-	LOOP ANIMATIONS	-
	********************************/

	t.callCaptionLoops = function() {
		t.stopAllLayerAnimation();
		
		var caption = jQuery('.slide_layer.layer_selected'),
			el = caption.find('.innerslide_layer').first();
		if (el.length==0) {
				return false;
			}

		var	id = u.getSerialFromID(caption.attr('id'));
			params=u.getLayer(id),
			loopanim = params["loop_animation"];



		if (el.closest('.rs-preview-inside-looper').length>0) {
			el.unwrap();
		}

		el.wrap('<div class="rs-preview-inside-looper" style="width:100%;height:100%;position:relative"></div>');

		var loopobj =caption.find('.rs-preview-inside-looper'),
			startdeg = params["loop_startdeg"],
			enddeg = params["loop_enddeg"],
			speed = params["loop_speed"],
			origin = ''+params["loop_xorigin"]+'% '+params["loop_yorigin"]+'%',
			easing = params["loop_easing"],
			angle= params["loop_angle"],
			radius = parseInt(params["loop_radius"],0),
			xs = params["loop_xstart"],
			ys = params["loop_ystart"],
			xe = params["loop_xend"],
			ye = params["loop_yend"],
			zoomstart = params["loop_zoomstart"],
			zoomend = params["loop_zoomend"];

		factor = 1;

        

		var tl = new punchgs.TimelineLite();
		tl.pause();


		// SOME LOOPING ANIMATION ON INTERNAL ELEMENTS
		switch (loopanim) {
			case "rs-pendulum":


					//punchgs.TweenLite.fromTo(loopobj,speed,{force3D:"auto",rotation:startdeg,transformOrigin:origin},{rotation:enddeg,ease:easing});
					tl.add(punchgs.TweenLite.fromTo(loopobj,speed,{force3D:"auto",rotation:startdeg,transformOrigin:origin},{rotation:enddeg,ease:easing}));
					tl.add(punchgs.TweenLite.fromTo(loopobj,speed,{force3D:"auto",rotation:enddeg},{rotation:startdeg,ease:easing,onComplete:function() {
						tl.restart();
					}}));
			break;

			case "rs-rotate":
					tl.add(punchgs.TweenLite.fromTo(loopobj,speed,{force3D:"auto",rotation:startdeg,transformOrigin:origin},{rotation:enddeg,ease:easing,onComplete:function() {
						tl.restart();
					}}));
			break;

			case "rs-slideloop":

					tl.add(punchgs.TweenLite.fromTo(loopobj,speed,{force3D:"auto",x:xs,y:ys},{x:xe,y:ye,ease:easing}));
					tl.add(punchgs.TweenLite.fromTo(loopobj,speed,{force3D:"auto",x:xe,y:ye},{x:xs,y:ys,onComplete:function() {
						tl.restart();
					}}));
			break;

			case "rs-pulse":
					tl.add(punchgs.TweenLite.fromTo(loopobj,speed,{force3D:"auto",scale:zoomstart},{scale:zoomend,ease:easing}));
					tl.add(punchgs.TweenLite.fromTo(loopobj,speed,{force3D:"auto",scale:zoomend},{scale:zoomstart,onComplete:function() {
						tl.restart();
					}}));
			break;

			case "rs-wave":					
					var _ox = ((parseInt(params["loop_xorigin"],0)/100)-0.5) * loopobj.width(),
						_oy = ((parseInt(params["loop_yorigin"],0)/100)-0.5) * loopobj.height(),
						yo = (-1*radius) + _oy,
						xo = 0 + _ox,
						angobj = {a:0, ang : angle, element:loopobj, unit:radius,xoffset:xo,yoffset:yo};

					var ang = parseInt(angle,0);

					tl.add(punchgs.TweenLite.fromTo(angobj,speed,
							{	a:0+ang	},
							{	a:360+ang,
								force3D:"auto",
								ease:punchgs.Linear.easeNone,								
								onUpdate:function() {
									var rad = angobj.a * (Math.PI / 180),
										yy = angobj.yoffset+(angobj.unit * (1 - Math.sin(rad))),
										xx = angobj.xoffset+Math.cos(rad) * angobj.unit;
						            punchgs.TweenLite.to(angobj.element,0.1,{force3D:"auto",x:xx, y:yy});
								},
								onComplete:function() {
									tl.restart();
								}
							}
							));
			break;
		}
		tl.play();
		caption.data('tl',tl);
	}


	/******************************************
		-	REBUILD IDLE STATES OF ITEMS 	-
	******************************************/
	
	t.rebuildLayerIdle = function(caption,timer,isDemo) {
		
		timer = timer == undefined ? 50 : timer;
		isDemo = isDemo == undefined ? false : isDemo;
				
		if (g_rebuildTimer == 0) {
			timer = 0;
			g_rebuildTimer = 999;
		}
						
		if (caption==undefined || jQuery(caption).length==0 || caption[0].classList.contains("layer-deleted")) return false;
				
		var cp = jQuery(caption);
		

		clearTimeout(cp.data('idlerebuildtimer'));
						
		t.rebuildLayerIdleProgress(caption);
		
		
		var id = u.getSerialFromID(caption.attr('id')),
			objLayer = u.getLayer(id,isDemo);

		
		var e_img = caption.find('.tp-caption img');
		
		u.updateHtmlLayerPosition(false,objLayer,u.getVal(objLayer, 'top'),u.getVal(objLayer, 'left'),u.getVal(objLayer, 'align_hor'),u.getVal(objLayer, 'align_vert'));

		if (e_img.length>0 && !jQuery(e_img).hasClass("loaded")) {
			jQuery(e_img).addClass("loaded");
			
			var img = new Image();			
			img.onload = function() {					
							 				
				objLayer.originalWidth = this.width;
				objLayer.originalHeight = this.height;
				u.updateHtmlLayerPosition(false,objLayer,u.getVal(objLayer, 'top'),u.getVal(objLayer, 'left'),u.getVal(objLayer, 'align_hor'),u.getVal(objLayer, 'align_vert'));
			}
			img.onerror = function() {				
				e_img[0].src = objLayer.image_url = g_revslider_url+"/admin/assets/images/tp-brokenimage.png";
				u.updateHtmlLayerPosition(false,objLayer,u.getVal(objLayer, 'top'),u.getVal(objLayer, 'left'),u.getVal(objLayer, 'align_hor'),u.getVal(objLayer, 'align_vert'));
			}
			img.onabort = function() {				
				u.updateHtmlLayerPosition(false,objLayer,u.getVal(objLayer, 'top'),u.getVal(objLayer, 'left'),u.getVal(objLayer, 'align_hor'),u.getVal(objLayer, 'align_vert'));
			}

			img.src = e_img[0].src;
		} else {
			//u.updateHtmlLayerPosition(false,caption,objLayer,u.getVal(objLayer, 'top'),u.getVal(objLayer, 'left'),u.getVal(objLayer, 'align_hor'),u.getVal(objLayer, 'align_vert'));
			//update corners
			u.updateHtmlLayerCorners(objLayer);
			//update cross position
			u.updateCrossIconPosition(objLayer);
		}
		u.extendSlideHeightBasedOnRows();
		return true;
	}
	


	////////////////////////////////
	// REBUILD LAYER CSS FOR IDLE //
	////////////////////////////////
	t.rebuildLayerIdleProgress = function(caption) {

		if (caption===undefined) return;
		
		var is_demo = (caption.attr('id') !== caption.attr('id').replace('demo_layer_')) ? true : false;
		
		if (caption==undefined || jQuery(caption).length==0) return false;
		
		var id = u.getSerialFromID(caption.attr('id')),
			params=u.getLayer(id, is_demo);
		if (params==undefined || params==false) return false;

		// CLEAR UP HALF ANIMATED STATUS ON WRAPPING AND HELPING CONTAINERS
		punchgs.TweenLite.set(caption.find('.tp-mask-wrap'), {	 clearProps:"all", visibility:"visible",opacity:1});
		
		if (params.type==="column")
			punchgs.TweenLite.set(caption.find('.column_background').first(),{clearProps:"all",visibility:"visible",opacity:1});
				

		var inlayer = jQuery(caption[0].getElementsByClassName('innerslide_layer')[0]),
			deform = params.deformation,
			deformidle = params.deformation,
			ss = params["static_styles"],
			fontcolor = u.getVal(ss,"color"),
			fonttrans = deform["color-transparency"],
			bgcolor = deform["background-color"],
			bgtrans = deform["background-transparency"],
			bordercolor = deform["border-color"],
			bordertrans = deform["border-transparency"];

		

		if (params.type=="audio") {
			if (params.video_data.video_show_visibility) {
				caption.addClass("invisible-audio");
			} else {
				caption.removeClass("invisible-audio");
			}
			return false;
		}



		if(is_demo && params.alias == 'First'){
			
		}
		
		// REMOVE SPLITS
		if (inlayer.data('mySplitText') != undefined) {
			try{inlayer.data('mySplitText').revert();} catch(e) {}
			if (params.type=="text" || params.type=="button") {
				inlayer[0].innerHTML = params.text;				
				u.makeCurrentLayerRotatable();
			}
			inlayer.removeData('mySplitText')
		}

		// BACKGROUND OPACITY
		if (Number(bgtrans)<1) {
			var rgb = UniteAdminRev.convertHexToRGB(bgcolor);
			bgcolor="rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+","+bgtrans+")";
		}

		// BORDER OPACITY
		if (Number(bordertrans)<1) {
			var rgb = UniteAdminRev.convertHexToRGB(bordercolor);
			bordercolor="rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+","+bordertrans+")";
		}

		// FONT OPACITY
		if (Number(fonttrans)<1) {
			var rgb = UniteAdminRev.convertHexToRGB(fontcolor);
			fontcolor="rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+","+fonttrans+")";
		}


		// SET ELEMENT IDLE		
		var mwidth = u.getVal(params,"max_width"),
			mheight = u.getVal(params,"max_height"),
			cmode = u.getVal(params,"cover_mode"),
			loc_position = "absolute";
		


				
		switch(params.type){
			case 'image':
				mwidth = u.getVal(params,"scaleX");
				mheight = u.getVal(params,"scaleY"); 
			break;
			case 'video':
				mwidth = params.video_data.cover===true || params.video_data.fullwidth===true ? "100%" : u.getVal(params,"video_width");
				mheight = params.video_data.cover===true || params.video_data.fullwidth===true ? "100%" :  u.getVal(params,"video_height"); 						
				caption.find('.slide_layer_video').css({width:parseInt(mwidth,0)+"px",height:parseInt(mheight,0)+"px"});								
			break;
			case 'row':				
				mwidth = "100%";
				if (u.getVal(params,"align_vert")==="bottom") 
					caption[0].style.position = "absolute"					
				else
					caption[0].style.position = "relative"			

				if ((params.column_break_at==="mobile" && t.layout==="mobile") ||
					(params.column_break_at==="tablet" && (t.layout==="tablet" || t.layout==="mobile")) ||
					(params.column_break_at==="notebook" && t.layout!=="desktop")) {
					caption.addClass("rev_breakcolumns");
				} else {
					caption.removeClass("rev_breakcolumns");
				}


			break;
			case 'column':
				mwidth = (100*eval(params.column_size))+"%";								
				mheight = "auto";
				caption[0].style.position = "relative";
				caption[0].style.display = "table_cell";
				caption[0].style.minHeight = parseInt(u.getVal(params,"min_height"),0)+"px";
				
				caption[0].cb = caption[0].cb === undefined ? caption.find('.column_background') : caption[0].cb;
				/*caption[0].style.marginTop = parseInt(u.getVal(params,'margin')[0],0)+"px";
				caption[0].style.marginRight= parseInt(u.getVal(params,'margin')[1],0)+"px";
				caption[0].style.marginBottom = parseInt(u.getVal(params,'margin')[2],0)+"px";
				caption[0].style.marginLeft = parseInt(u.getVal(params,'margin')[3],0)+"px";*/				
				if (params.bgimage_url!==undefined && params.bgimage_url.length>0) {
					caption[0].cb.css({
						backgroundImage:"url('"+params.bgimage_url+"')", 
						backgroundSize:params.layer_bg_size, 
						backgroundPosition:params.layer_bg_position, 
						backgroundRepeat:params.layer_bg_repeat,
						backgroundColor:bgcolor
					});									
				} else {
					caption[0].cb.css({
						backgroundImage:"",
						backgroundColor:bgcolor				
					})	
				}
				
			break;
			case 'group':
			
			break;
			
		}


		//console.log(params.text+"  "+params.groupOrder)
		
		if (deform.overflow===undefined || params.type!=="group")
			deform.overflow = "visible";
		
		if(mwidth == undefined) mwidth = '';
		if(mheight == undefined) mheight = '';

		
		if (params.p_uid!==-1 && u.getObjLayerType(params.p_uid)==="column") 
			punchgs.TweenLite.set(caption,{position:"relative", display:u.getVal(params,"display"), top:"auto",left:"auto",right:"auto",bottom:"auto"});										
		else {
			if (params.type==="column") {			
				punchgs.TweenLite.set(caption,{position:"absolute", display:"table-cell"});					
			}
			else
				punchgs.TweenLite.set(caption,{position:"absolute", display:"block"});
		}

		if (params.type==="column") bgcolor = "transparent"
		
		mwidth = cmode===undefined || cmode==="custom" ?  
				jQuery.isNumeric(mwidth) ? 
					mwidth+"px" : mwidth.match(/px/g) ? 
						parseInt(mwidth,0)+"px" : mwidth.match(/%/g) ? 
							parseFloat(mwidth)+"%" : mwidth :
								cmode === "fullwidth" || cmode ==="cover"  || cmode ==="cover-proportional" ? "100%" : mwidth;

		mheight = cmode===undefined || cmode==="custom" ?  
				jQuery.isNumeric(mheight) ? 
					mheight+"px" : mheight.match(/px/g) ? 
						parseInt(mheight,0)+"px" : mheight.match(/%/g) ? 
							parseFloat(mheight,0)+"%" : mheight :
								cmode === "fullheight" || cmode ==="cover" || cmode ==="cover-proportional"  ? "100%" : mheight;

		

		// SET LAYER WIDTH HEIGHT INNER AND OUTTER
		
		caption[0].style.width = mwidth;
		caption[0].style.height = mheight;
		if (params.type==="column") {			
			//caption[0].style.minWidth = mwidth;
			//caption[0].style.maxWidth = mwidth;			
		}
		
		var fw = parseInt(u.getVal(ss,"font-weight"),0) || 400;

		

		var bgimage = "";
		punchgs.TweenLite.set(inlayer, {	 clearProps:"all", visibility:"visible",opacity:1});
		if (params.bgimage_url!==undefined && params.bgimage_url.length>0 && params.type!=="column") 			
			inlayer.css({backgroundImage:"url('"+params.bgimage_url+"')", backgroundSize:params.layer_bg_size, backgroundPosition:params.layer_bg_position, backgroundRepeat:params.layer_bg_repeat});			
		else
			inlayer.css({backgroundImage:"", backgroundSize:params.layer_bg_size, backgroundPosition:params.layer_bg_position, backgroundRepeat:params.layer_bg_repeat});
		
		
		punchgs.TweenLite.set(inlayer, {	
											// overflow:deform.overflow,
											 z:deform.z,												 
											 scaleX:parseFloat(deform.scalex),
											 scaleY:parseFloat(deform.scaley),
											 textAlign:u.getVal(params,"text-align"),
											 rotationX:parseFloat(deform.xrotate),
											 rotationY:parseFloat(deform.yrotate),
											 rotationZ:parseFloat(params["2d_rotation"]),

											 skewX:parseFloat(deform.skewx),
											 skewY:parseFloat(deform.skewy),

											 transformPerspective:parseFloat(deform.pers),
											 transformOrigin:params["layer_2d_origin_x"]+"% "+params["layer_2d_origin_y"]+"%",

											 autoAlpha:deform.opacity,
											 paddingTop:parseInt(u.getVal(params,'padding')[0],0)+"px",
											 paddingRight:parseInt(u.getVal(params,'padding')[1],0)+"px",
											 paddingBottom:parseInt(u.getVal(params,'padding')[2],0)+"px",
											 paddingLeft:parseInt(u.getVal(params,'padding')[3],0)+"px",
																						
											 fontSize:parseInt(u.getVal(ss,"font-size"),0)+"px",
											 lineHeight:parseInt(u.getVal(ss,"line-height"),0)+"px",		
											 fontWeight:fw,		
											 color:fontcolor,
											 backgroundColor:bgcolor,											 
						
											 fontFamily:deformidle["font-family"],
											 fontStyle:deformidle["font-style"],
											 textDecoration:deform["text-decoration"],
											 textTransform:deform["text-transform"],
											 borderColor:bordercolor,
											 borderRadius:deform["border-radius"][0]+" "+deform["border-radius"][1]+" "+deform["border-radius"][2]+" "+deform["border-radius"][3],
											 borderWidth:deform["border-width"][0]+" "+deform["border-width"][1]+" "+deform["border-width"][2]+" "+deform["border-width"][3],
											 //borderWidth:parseInt(deform["border-width"],0)+"px",
											 borderStyle:deform["border-style"],
											 whiteSpace:u.getVal(params,"whitespace"),
											 maxWidth:"100%",
											 maxHeight:"100%"											 
							});
		if (params.type==="group") 
			punchgs.TweenLite.set(inlayer.find('.tp_layer_group_inner_wrapper').first(),{overflow:deform.overflow});
		
		if (params.layer_blend_mode!==undefined && jQuery.inArray(params.type,["image","shape","text","svg"]>=0))		
			punchgs.TweenLite.set(inlayer.closest('.slide_layer'),{mixBlendMode:params.layer_blend_mode});
		
		switch (params.type) {
			case "shape":
			case "svg":
				punchgs.TweenLite.set(caption, {	
					 marginTop:parseInt(u.getVal(params,'margin')[0],0)+"px",
					 marginRight:parseInt(u.getVal(params,'margin')[1],0)+"px",
					 marginBottom:parseInt(u.getVal(params,'margin')[2],0)+"px",
					 marginLeft:parseInt(u.getVal(params,'margin')[3],0)+"px"
				});
			break;			

			case "column":				
				// Draw Border to fake color Background of Column Content
				punchgs.TweenLite.set(caption.find('.column_background'),{
					 borderTopWidth:parseInt(u.getVal(params,'margin')[0],0)+"px",
					 borderRightWidth:parseInt(u.getVal(params,'margin')[1],0)+"px",
					 borderBottomWidth:parseInt(u.getVal(params,'margin')[2],0)+"px",
					 borderLeftWidth:parseInt(u.getVal(params,'margin')[3],0)+"px"
				});
				// Set Column inner Content Spacing for Column Gap's
				punchgs.TweenLite.set(inlayer, {	
					 marginTop:parseInt(u.getVal(params,'margin')[0],0)+"px",
					 marginRight:parseInt(u.getVal(params,'margin')[1],0)+"px",
					 marginBottom:parseInt(u.getVal(params,'margin')[2],0)+"px",
					 marginLeft:parseInt(u.getVal(params,'margin')[3],0)+"px"
				});
			break;			
			default:
				punchgs.TweenLite.set(inlayer, {	
					 marginTop:parseInt(u.getVal(params,'margin')[0],0)+"px",
					 marginRight:parseInt(u.getVal(params,'margin')[1],0)+"px",
					 marginBottom:parseInt(u.getVal(params,'margin')[2],0)+"px",
					 marginLeft:parseInt(u.getVal(params,'margin')[3],0)+"px"
				});
			break;
		}
		
		if (params.type==="image") {
			if(params.scaleProportional) {					
				punchgs.TweenLite.set(inlayer.find('img'),{width:"100%",height:"auto"})
				punchgs.TweenLite.set(inlayer,{width:"100%",height:"auto"})
			} else {					
				punchgs.TweenLite.set(inlayer.find('img'),{width:"100%",height:"100%"})
				punchgs.TweenLite.set(inlayer,{width:"100%",height:"100%"})						
			}		
		}

		if (params.type==="video") {			
				punchgs.TweenLite.set(inlayer.find('.slide_layer_video'),{width:"100%",height:"100%"})
				punchgs.TweenLite.set(inlayer,{width:"100%",height:"100%"})									
		}
		
		if (params.type==="svg" && params.svg!=undefined) {			
				var svgstrokecolor = params.svg["svgstroke-color"] || "transparent",
					svgstroketrans = params.svg["svgstroke-transparency"] || 0,
					svgstrokewidth = params.svg["svgstroke-width"] || 0,
					svgstrokedasharray = params.svg["svgstroke-dasharray"] || 0,
					svgstrokedashoffset = params.svg["svgstroke-dashoffset"] || 0;

				// STROKE OPACITY
				if (Number(svgstroketrans)<1) {
					var rgb = UniteAdminRev.convertHexToRGB(svgstrokecolor);
					svgstrokecolor="rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+","+svgstroketrans+")";
				}
				
				punchgs.TweenLite.set(inlayer.find('svg'),{
																fill:fontcolor,
																stroke:svgstrokecolor,
																strokeWidth:svgstrokewidth,
																strokeDasharray:svgstrokedasharray,
																strokeDashoffset:svgstrokedashoffset
															});				
				punchgs.TweenLite.set(inlayer.find('svg path'),{
																fill:fontcolor
															});	
		}

		if (params.inline !=undefined && params.inline.idle!=undefined)					
			jQuery.each(params.inline.idle, function(key,value) {

				inlayer.css(key,value);
			})

		
		
		//SET ELEMENT HOVER (IN CASE IT EXISTS)
		
		if (params.hover===true) {
			deform = params["deformation-hover"];
			var fontcolor = deform.color,
				fonttrans = deform["color-transparency"],		
				bgcolor = deform["background-color"],
				bgtrans = deform["background-transparency"],
				bordercolor = deform["border-color"],
				bordertrans = deform["border-transparency"];

			
			// BACKGROUND OPACITY
			if (Number(bgtrans)<1) {
				var rgb = UniteAdminRev.convertHexToRGB(bgcolor);
				bgcolor="rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+","+bgtrans+")";
			}

			// BORDER OPACITY
			if (Number(bordertrans)<1) {
				var rgb = UniteAdminRev.convertHexToRGB(bordercolor);
				bordercolor="rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+","+bordertrans+")";
			}

			// FONT OPACITY
			if (Number(fonttrans)<1) {
				var rgb = UniteAdminRev.convertHexToRGB(fontcolor);
				fontcolor="rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+","+fonttrans+")";
			}
		
			var tl=new punchgs.TimelineLite();				
			tl.pause();
			
			var hoverspeed = parseFloat(deform.speed)/1000;
			hoverspeed = hoverspeed === 0 ? 0.001 : hoverspeed;
			
			tl.add(punchgs.TweenLite.to(inlayer, hoverspeed,{
	
											 scaleX:parseFloat(deform.scalex),
											 scaleY:parseFloat(deform.scaley),
	
											 rotationX:parseFloat(deform.xrotate),
											 rotationY:parseFloat(deform.yrotate),
											 rotationZ:parseFloat(deform["2d_rotation"]),
	
											 skewX:parseFloat(deform.skewx),
											 skewY:parseFloat(deform.skewy),
		
											 autoAlpha:deform.opacity,
											 color:fontcolor,
											 backgroundColor:bgcolor,						
											 textDecoration:deform["text-decoration"],
											 borderColor:bordercolor,
											 borderRadius:parseInt(deform["border-radius"][0],0)+"px "+parseInt(deform["border-radius"][1],0)+"px "+parseInt(deform["border-radius"][2],0)+"px "+parseInt(deform["border-radius"][3],0)+"px",
											 borderWidth:parseInt(deform["border-width"][0],0)+"px "+parseInt(deform["border-width"][1],0)+"px "+parseInt(deform["border-width"][2],0)+"px "+parseInt(deform["border-width"][3],0)+"px",
											 //borderWidth:parseInt(deform["border-width"],0)+"px",
											 borderStyle:deform["border-style"],
											 onComplete:function() {
											 	if (params.inline && params.inline.hover!=undefined)					
													jQuery.each(params.inline.hover, function(key,value) {
														inlayer.css(key,value);
													})
											 },
											 ease:deform.easing
							}));
			if (params.type==="svg" && params.svg!=undefined) {					
					var svgstrokecolor = params.svg["svgstroke-hover-color"] || "transparent",
						svgstroketrans = params.svg["svgstroke-hover-transparency"] || 0,
						svgstrokewidth = params.svg["svgstroke-hover-width"] || 0,
						svgstrokedasharray = params.svg["svgstroke-hover-dasharray"] || 0,
						svgstrokedashoffset = params.svg["svgstroke-hover-dashoffset"] || 0;

					// STROKE OPACITY
					if (Number(svgstroketrans)<1) {
						var rgb = UniteAdminRev.convertHexToRGB(svgstrokecolor);
						svgstrokecolor="rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+","+svgstroketrans+")";
					}
					

					tl.add(punchgs.TweenLite.to(inlayer.find('svg'),hoverspeed,{
																	fill:fontcolor,
																	stroke:svgstrokecolor,
																	strokeWidth:svgstrokewidth,
																	strokeDasharray:svgstrokedasharray,
																	strokeDashoffset:svgstrokedashoffset,
																	ease:deform.easing
																}),0);				
			}

			inlayer.data('hoveranim',tl);
			

			

			// ADD HOVER ON THE ELEMENT
			if (caption.data('hoverexist')===undefined || caption.data('hoverexist')===false)  {
				caption.hover(function() {
				  if (jQuery('#rs-style-tab-button').hasClass("selected")) {
					if (jQuery('#toggle-idle-hover').hasClass("idleisselected")) {
						var inlayer = jQuery(this).find('.innerslide_layer').first();
						if (inlayer.length>0 && inlayer.data('hoveranim')!=undefined) {
							var tl = inlayer.data('hoveranim');
							tl.play(0);
						}
					}
				  }
				},function() {
					if (jQuery('#rs-style-tab-button').hasClass("selected")) {
						if (jQuery('#toggle-idle-hover').hasClass("idleisselected")) {
							var inlayer = jQuery(this).find('.innerslide_layer').first();
							if (inlayer.length>0 && inlayer.data('hoveranim')!=undefined) {
								var tl = inlayer.data('hoveranim');
								tl.reverse();
							}
						}
					}
				});
				caption.data('hoverexist',true);
			} 


			
			
			
			if (document.getElementById('toggle-idle-hover').classList.contains("hoverisselected")) {				
				tl.seek(tl.endTime());
			} else {				
				tl.seek(0);
				tl.pause(0);
				setTimeout(function() {					
					tl.pause(0);
				},109)
			}
		} else {
			caption.unbind("hover");
			caption.data("hoverexist",false);
		}


		
	}

	/******************************************************************************************
			-	ANIMATE CURRENT SELECTED LAYER IN AND OUT ON SHORT TIMEFRAME	-
	********************************************************************************************/

	t.animateCurrentSelectedLayer = function(delay) {
		

		//	if (delay==undefined) delay = 229;
			u.removeCurrentLayerRotatable();
			var nextcaption = jQuery('.slide_layer.layer_selected').find('.innerslide_layer').first();
			
			if (nextcaption.length==0) {
					return false;
			}
			if (nextcaption.data('tl')==undefined)
				var tl=new punchgs.TimelineLite();
			else
				var tl = nextcaption.data('tl');
			
			tl.clear();
			tl.kill();
			tl.pause();
			
				
	
			nextcaption.data('inanim',theLayerInAnimation(nextcaption));
			nextcaption.data('outanim',theLayerOutAnimation(nextcaption));

			// RUN THE IN ANIMATION
			tl.addLabel("inanimation");
			tl.add(nextcaption.data('inanim'),"=+0.2");

			// ADD SOME ANIMATION ON THE IN/OUT TABS
			tl.addLabel("outanimation");
			tl.add(punchgs.TweenLite.fromTo(jQuery('#startanim_timerunner'),1,{x:0,y:0},{y:41}),"outanimation");
			tl.add(punchgs.TweenLite.fromTo(jQuery('#startanim_timerunnerbox'),1,{x:0,y:0},{y:41}),"outanimation");
			tl.add(punchgs.TweenLite.fromTo(jQuery('#endanim_timerunnerbox'),1,{x:0,y:-41},{x:0,y:0}),"outanimation");
			tl.add(punchgs.TweenLite.fromTo(jQuery('#endanim_timerunner'),1,{x:0,y:-41},{y:0}),"outanimation");
			tl.add(punchgs.TweenLite.set(jQuery('#endanim_wrapper'),{width:67,autoAlpha:1}),"outanimation");

			// RUN THE OUT ANIMATION
			tl.add(nextcaption.data('outanim'));
			tl.eventCallback("onComplete",function() {
				tl.restart();
			})


			tl.play();

			nextcaption.data('tl',tl);
			
		}


	/***************************************
		-	BUILD IN ANIMATION TIMELINE	-
	****************************************/

	var checkAnimValue = function(val,defval,nextcaption,direction) {
		var v = val,
			d = defval;


		if (jQuery.isNumeric(parseFloat(v))) {				
			return parseFloat(v);
		} else 
		if (v===undefined || v==="inherit") {				
			return d;
		} else 
		if (v.split("{").length>1) {
			var min = v.split(",");
				max = min[1].split("}")[0];
			min = min[0].split("{")[1];
			v = Math.random()*(max-min) + min;				
			return v;
		} else {
			var cw = jQuery('#divLayers').width(),
				ch = jQuery('#divLayers').height(),
				el = nextcaption.closest('.slide_layer'),
				elw = el.width(),
				elh = el.height(),
				p = el.position();

			if (v.match(/%]/g)) {
				v = v.split("[")[1].split("]")[0];				
				if (direction=="horizontal")
					v = elw*parseInt(v,0)/100;
				else
				if (direction=="vertical")
					v = elh*parseInt(v,0)/100;
			} else 

			switch (v.toLowerCase()) {
				case "top":
				case "stage_top":
					v = 0-elh-p.top;						
				break;
				case "bottom":						
				case "stage_bottom":						
					v = ch;
				break;
				case "stage_left":
				case "left":
					v = 0-elw-p.left;
				break;
				case "right":
				case "stage_right":
					v = cw;
				break;
				case "center":
				case "stage_center":
					v =  (cw/2 - p.left - elw/2);
				break;
				case "middle":
				case "stage_middle":
					v =  (ch/2 - p.top - elh/2);
				break;


				case "layer_top":
					v = 0-elh;						
				break;
				case "layer_bottom":						
					v = elh;
				break;
				case "layer_left":
					v = 0-elw;
				break;
				case "layer_right":
					v = elw;
				break;
				case "layer_center":					
					v =  elw/2;
				break;
				case "layer_middle":
					v =  elh/2;
				break;
				default:
				break;
			}				
			
			return v;
		}		
		return v;	
	}	


	function theLayerInAnimation(nextcaption) {

		
		var sl = nextcaption.closest('.slide_layer'),
			id = u.getSerialFromID(sl.attr('id')),
			params = new Object();		
		params=jQuery.extend(true,{},params, u.getLayer(id));
		
		
		if (sl.children(".tp-mask-wrap").length==0)
			sl.wrapInner('<div style="width:100%;height:100%;position:relative;" class="tp-mask-wrap"></div>');

		
		var	mask = sl.find('.tp-mask-wrap'),
			anim = params.animation,					
			colbg = sl.hasClass("slide_layer_type_column") ? sl.find('.column_background').first() : undefined,
			speed = params.frames["frame_0"].speed/1000,
			easedata = params.frames["frame_0"].easing,
			mdelay = params.frames["frame_0"].splitdelay/100,
			$split = params.frames["frame_0"].split,
			$endsplit = params.frames["frame_999"].split, 
			animobject = nextcaption,
			thesource = new Object(),
			theresult = new Object();

		

		thesource.transx = 0;
		thesource.transy = 0;
		thesource.transz = 0;
		thesource.rotatex = 0;
		thesource.rotatey = 0;
		thesource.rotatez = 0;
		thesource.scalex = 1;
		thesource.scaley = 1;
		thesource.skewx = 0;
		thesource.skewy = 0;
		thesource.opac = 0;
		thesource.tper = parseFloat(params.deformation.pers);
		thesource.origin = "center,center",

		
			//parseInt(u.getVal(ss,"font-size"),0)+"px",
		theresult.transx = 0;
		theresult.transy = 0;
		theresult.transz = parseFloat(params.deformation.z);
		theresult.rotatex = parseFloat(params.deformation.xrotate);
		theresult.rotatey = parseFloat(params.deformation.yrotate);
		theresult.rotatez = parseFloat(params["2d_rotation"]);
		theresult.scalex = parseFloat(params.deformation.scalex);
		theresult.scaley = parseFloat(params.deformation.scaley);
		theresult.skewx = parseFloat(params.deformation.skewx);
		theresult.skewy = parseFloat(params.deformation.skewy);
		theresult.opac = parseFloat(params.deformation.opacity);
		theresult.tper = parseFloat(params.deformation.pers);
		
		

		var originx = params["layer_2d_origin_x"]+"%",
			originy = params["layer_2d_origin_y"]+"%",
			origin = originx+" "+originy;



		if (nextcaption.data('mySplitText') != undefined)
			if ($split !="none" || $endsplit !="none") 
				try{nextcaption.data('mySplitText').revert();} catch(e) {}

		if ($split == "chars" || $split == "words" || $split == "lines" || $endsplit == "chars" || $endsplit == "words" || $endsplit == "lines" ) {
			if (nextcaption.find('a').length>0)
				nextcaption.data('mySplitText',new SplitText(nextcaption.find('a'),{type:"lines,words,chars"}));
			else
				nextcaption.data('mySplitText',new SplitText(nextcaption,{type:"lines,words,chars"}));
		} else {
			nextcaption.data('mySplitText',"none");
		}

		

		
		switch($split) {
			case "chars":
				animobject = nextcaption.data('mySplitText').chars;
			break;
			case "words":
				animobject = nextcaption.data('mySplitText').words;
			break;
			case "lines":
				animobject = nextcaption.data('mySplitText').lines;
			break;
		}

		var timedelay=((animobject.length*mdelay) + speed)*1000;

		punchgs.TweenLite.killTweensOf(nextcaption,false);
		punchgs.TweenLite.killTweensOf(animobject,false);		
		punchgs.TweenLite.set(mask,{clearProps:"transform"});
		punchgs.TweenLite.set(nextcaption,{clearProps:"transform"});
		punchgs.TweenLite.set(animobject,{clearProps:"transform"});


		var tl = new punchgs.TimelineLite(),
			tt = new punchgs.TimelineLite();

		if (animobject != nextcaption) {
			tl.add(punchgs.TweenLite.set(nextcaption, { scaleX:theresult.scalex, scaleY:theresult.scaley,
						  rotationX:theresult.rotatex, rotationY:theresult.rotatey, rotationZ:theresult.rotatez,
						  x:theresult.transx, y:theresult.transy, z:theresult.transz+1,
						  skewX:theresult.skewx, skewY:theresult.skewy,
						  transformPerspective:theresult.tper, transformOrigin:origin,
						  autoAlpha:theresult.opac,overwrite:"all"}));
		}
		

		if (nextcaption.data("timer")) clearTimeout(nextcaption.data('timer'));
		if (nextcaption.data("timera")) clearTimeout(nextcaption.data('timera'));

		
			
		

		thesource.transx = checkAnimValue(params.x_start,theresult.transx,nextcaption,"horizontal");
		thesource.transy = checkAnimValue(params.y_start,theresult.transy,nextcaption,"vertical");
		thesource.transz = checkAnimValue(params.z_start,theresult.transz,nextcaption);
		thesource.rotatex = checkAnimValue(params.x_rotate_start,theresult.rotatex,nextcaption);
		thesource.rotatey = checkAnimValue(params.y_rotate_start,theresult.rotatey,nextcaption);
		thesource.rotatez = checkAnimValue(params.z_rotate_start,theresult.rotatez,nextcaption);
		thesource.scalex = checkAnimValue(params.scale_x_start,theresult.scalex,nextcaption);
		thesource.scaley = checkAnimValue(params.scale_y_start,theresult.scaley,nextcaption);
		thesource.skewx = checkAnimValue(params.skew_x_start,theresult.skewx,nextcaption);
		thesource.skewy =checkAnimValue( params.skew_y_start,theresult.skewy,nextcaption);
		thesource.opac = checkAnimValue(params.opacity_start,theresult.opac,nextcaption);
		thesource.tper = params.deformation.pers;


		tl.add(tt.set(animobject,{clearProps:"transform"}),0);
		
		tl.add(tt.staggerFromTo(animobject,speed,
						{ scaleX:thesource.scalex,
						  scaleY:thesource.scaley,
						  rotationX:thesource.rotatex, rotationY:thesource.rotatey, rotationZ:thesource.rotatez,
						  x:thesource.transx, y:thesource.transy, z:thesource.transz,
						  skewX:thesource.skewx, skewY:thesource.skewy,
						  transformPerspective:thesource.tper, transformOrigin:origin,
						  autoAlpha:thesource.opac

						},
						{ scaleX:theresult.scalex, scaleY:theresult.scaley,
						  rotationX:theresult.rotatex, rotationY:theresult.rotatey, rotationZ:theresult.rotatez,
						  x:theresult.transx, y:theresult.transy, z:theresult.transz,
						  skewX:theresult.skewx, skewY:Number(theresult.skewy),
						  transformPerspective:theresult.tper, transformOrigin:origin,
						  ease:easedata,
						  autoAlpha:theresult.opac,overwrite:"all",
						  force3D:"auto"
						},mdelay
						));

		// COLUMN BG ANIMATION
		
		if (colbg!=undefined) {
			
			tl.add(punchgs.TweenLite.fromTo(colbg,speed,
							{ scaleX:thesource.scalex,
							  scaleY:thesource.scaley,
							  rotationX:thesource.rotatex, rotationY:thesource.rotatey, rotationZ:thesource.rotatez,
							  x:thesource.transx, y:thesource.transy, z:thesource.transz,
							  skewX:thesource.skewx, skewY:thesource.skewy,
							  transformPerspective:thesource.tper, transformOrigin:origin,
							  autoAlpha:thesource.opac

							},
							{ scaleX:theresult.scalex, scaleY:theresult.scaley,
							  rotationX:theresult.rotatex, rotationY:theresult.rotatey, rotationZ:theresult.rotatez,
							  x:theresult.transx, y:theresult.transy, z:theresult.transz,
							  skewX:theresult.skewx, skewY:Number(theresult.skewy),
							  transformPerspective:theresult.tper, transformOrigin:origin,
							  ease:easedata,
							  autoAlpha:theresult.opac,overwrite:"all",
							  force3D:"auto"							  
							}),0);
		}

		// MASK ANIMATION
		if (!params.mask_start) tl.add(punchgs.TweenLite.set(mask,{overflow:"visible"}),0);


		// MASK ANIMATION
		if (params.mask_start) {			
			var maskp = new Object();
			maskp.x = checkAnimValue(params.mask_x_start,params.mask_x_start,nextcaption,"horizontal");
			maskp.y = checkAnimValue(params.mask_y_start,params.mask_y_start,nextcaption,"vertical");						
			tl.add(punchgs.TweenLite.fromTo(mask,speed,{overflow:"hidden",x:maskp.x,y:maskp.y},{x:0,y:0,ease:easedata}),0);
		}

		if (params.mask_start || params.mask_end)
			mask.addClass('tp-showmask');
		else
			mask.removeClass('tp-showmask');

		nextcaption.data('startanimobj',thesource);

		tl.add(punchgs.TweenLite.fromTo(jQuery('#startanim_wrapper'),tt.totalDuration(),{autoAlpha:1,width:0},{width:67,ease:easedata}),0);
		if (animobject != nextcaption)
			tl.add(punchgs.TweenLite.fromTo(nextcaption.parent(), 0.2,{autoAlpha:0},{autoAlpha:1}),0);		
		
		return tl;

	}

	/***************************************
		-	BUILD OUT ANIMATION TIMELINE	-
	****************************************/
	function theLayerOutAnimation(nextcaption) {
		var sl = nextcaption.closest('.slide_layer'),
			id = u.getSerialFromID(sl.attr('id')),
			params = new Object();
		
		params=jQuery.extend(true,{},params, u.getLayer(id));


		var	mask = sl.find('.tp-mask-wrap'),			
			colbg = sl.hasClass("slide_layer_type_column") ? sl.find('.column_background').first() : undefined,			
			anim = params.frames["frame_999"].animation,
			speed = params.frames["frame_999"].speed/1000,
			easedata = params.frames["frame_999"].easing,
			mdelay = params.frames["frame_999"].splitdelay/100,
			$split = params.frames["frame_999"].split,
			animobject = nextcaption;
			theanim = new Object(),
			theresult = new Object(),
			originx = params["layer_2d_origin_x"]+"%",
			originy = params["layer_2d_origin_y"]+"%",
			origin = originx+" "+originy;

		easedata = easedata=="nothing" ? params.frames["frame_999"].easing :  easedata;

		theanim.transx = 0;
		theanim.transy = 0;
		theanim.transz = 0;
		theanim.rotatex = 0;
		theanim.rotatey = 0;
		theanim.rotatez = 0;
		theanim.scalex = 1;
		theanim.scaley = 1;
		theanim.skewx = 0;
		theanim.skewy = 0;
		theanim.opac = 0;
		theanim.tper = parseFloat(params.deformation.pers);;


		theresult.transx = 0;
		theresult.transy = 0;
		theresult.transz = parseFloat(params.deformation.z);
		theresult.rotatex = parseFloat(params.deformation.xrotate);
		theresult.rotatey = parseFloat(params.deformation.yrotate);
		theresult.rotatez = parseFloat(params["2d_rotation"]);
		theresult.scalex = parseFloat(params.deformation.scalex);
		theresult.scaley = parseFloat(params.deformation.scaley);
		theresult.skewx = parseFloat(params.deformation.skewx);
		theresult.skewy =parseFloat( params.deformation.skewy);
		theresult.opac = parseFloat(params.deformation.opacity);
		theresult.tper = parseFloat(params.deformation.pers);

		switch($split) {
			case "chars":
				animobject = nextcaption.data('mySplitText').chars;
			break;
			case "words":
				animobject = nextcaption.data('mySplitText').words;
			break;
			case "lines":
				animobject = nextcaption.data('mySplitText').lines;
			break;
		}
			
		  var timedelay=((animobject.length*mdelay) + speed)*1000;

		  var tl = new punchgs.TimelineLite(),
			  tt = new punchgs.TimelineLite();

		
		if (anim == null) anim = "auto";
				
		
		// MASK ANIMATION
		if (!params.mask_end || (anim==="auto" && !params.mask_start)) 			
			tl.add(punchgs.TweenLite.set(mask,{overflow:"visible"}));


		if (anim==="auto") {
			theanim = nextcaption.data('startanimobj');
		} else {		
			var mask_is_on = params.mask_end || (anim==="auto" && params.mask_start) ? true : false;

			theanim.transx = checkAnimValue(params.x_end,theresult.transx,nextcaption,"horizontal");
			theanim.transy = checkAnimValue(params.y_end,theresult.transy,nextcaption,"vertical");
			theanim.transz = checkAnimValue(params.z_end,theresult.transz,nextcaption);
			theanim.rotatex = checkAnimValue(params.x_rotate_end,theresult.rotatex,nextcaption);
			theanim.rotatey = checkAnimValue(params.y_rotate_end,theresult.rotatey,nextcaption);
			theanim.rotatez = checkAnimValue(params.z_rotate_end,theresult.rotatez,nextcaption);
			theanim.scalex = checkAnimValue(params.scale_x_end,theresult.scalex,nextcaption);
			theanim.scaley = checkAnimValue(params.scale_y_end,theresult.scaley,nextcaption);
			theanim.skewx = checkAnimValue(params.skew_x_end,theresult.skewx,nextcaption);
			theanim.skewy =checkAnimValue( params.skew_y_end,theresult.skewy,nextcaption);
			theanim.opac = checkAnimValue(params.opacity_end,theresult.opac,nextcaption);
			theanim.tper = params.deformation.pers;
		}
		
		

		
		
		tl.add(tt.staggerTo(animobject,speed,
								{
								  scaleX:theanim.scalex,
								  scaleY:theanim.scaley,
								  rotationX:theanim.rotatex,
								  rotationY:theanim.rotatey,
								  rotationZ:theanim.rotatez,
								  x:theanim.transx,
								  y:theanim.transy,
								  z:theanim.transz+1,
								  skewX:theanim.skewx,
								  skewY:theanim.skewy,
								  opacity:theanim.opac,
								  transformPerspective:theanim.tper,
								  transformOrigin:origin,
								  ease:easedata
								 },mdelay));

		// COLUMN BG ANIMATION
		if (colbg!=undefined) 		
			tl.add(punchgs.TweenLite.to(colbg,speed,
								{
								  scaleX:theanim.scalex,
								  scaleY:theanim.scaley,
								  rotationX:theanim.rotatex,
								  rotationY:theanim.rotatey,
								  rotationZ:theanim.rotatez,
								  x:theanim.transx,
								  y:theanim.transy,
								  z:theanim.transz+1,
								  skewX:theanim.skewx,
								  skewY:theanim.skewy,
								  opacity:theanim.opac,
								  transformPerspective:theanim.tper,
								  transformOrigin:origin,
								  ease:easedata
								 },mdelay),0);
		
			
		// MASK ANIMATION
		if (params.mask_end) {
			var maskp = new Object();					
			maskp.x = checkAnimValue(params.mask_x_end,params.mask_x_end,nextcaption);
			maskp.y = checkAnimValue(params.mask_y_end,params.mask_y_end,nextcaption);					
			tl.add(punchgs.TweenLite.to(mask,speed,{x:maskp.x,y:maskp.y,ease:easedata,overflow:"hidden"},mdelay),0);
		} else 

		if (anim==="auto" && params.mask_start) {
			var maskp = new Object();			
			maskp.x = checkAnimValue(params.mask_x_start,params.mask_x_start,nextcaption);
			maskp.y = checkAnimValue(params.mask_y_start,params.mask_y_start,nextcaption);			
			tl.add(punchgs.TweenLite.to(mask,speed,{x:maskp.x,y:maskp.y,ease:easedata},mdelay),0);
		}

		tl.add(punchgs.TweenLite.fromTo(jQuery('#endanim_timerunnerbox'),tt.totalDuration(),{x:0},{x:-67,ease:easedata}),0);
		tl.add(punchgs.TweenLite.fromTo(jQuery('#endanim_timerunner'),tt.totalDuration(),{x:0},{x:-67,ease:easedata}),0);
		if (animobject != nextcaption)
			tl.add(punchgs.TweenLite.fromTo(nextcaption.parent(), 0.2,{autoAlpha:1},{autoAlpha:0}),(tt.totalDuration()-0.2));		
		return tl;
	}




	/******************************************************************************************
		-	PUT THE BLUE TIMER LINE IN POSITION BASED ON DEFAULT OR PREDEFINED VALUES 	-
	******************************************************************************************/
	var initSlideDuration = function() {

		// SET MAXTIME POSITION
		var duration = jQuery('#delay').val();
		if (duration==undefined || duration==0 || duration=="undefined")
			duration = g_slideTime;
		jQuery('#mastertimer-maxtime').css({left:duration/10});


	}




	/******************************************************************************************
		-	EVENT LISTENER FOR MASTER TIME POSITION CHANGE, ALL ANIMATION MOVE IN POSTION 	-
	********************************************************************************************/

	t.masterTimerPositionChange = function(recreatetimers) {
			
			var mp = jQuery(document.getElementById('mastertimer-position')),	
				tpos =  (((mp[0].getBoundingClientRect().left - document.getElementById('master-rightheader').getBoundingClientRect().left+t.timercorrectur))/100),					
				mst = jQuery(document.getElementById('divbgholder')).data('slidetimeline');
				
			mp[0].className = mp[0].classList.contains("hovering") ? mp[0].className : mp[0].className + " hovering";
			
			
			if (tpos<=0 && (mp.data('wasidle')=="wasnotidle" || mp.data('wasidle')==undefined)) {

				t.stopAllLayerAnimation();
				mp.data('wasidle',"wasidle");
				
				if (mp.data('tl')!=undefined) {
					mp.data('tl').kill();
				}
				if (mst!=undefined) {
					mst.stop();
					mst.seek(100000);
				}
					
				t.allLayerToIdle();
			}

			
			if (tpos>0 && (mp.data('wasidle')=="wasidle" || mp.data('wasidle')==undefined)) {
				mp.data('wasidle','wasnotidle');
				createGlobalTimeline(true);
				document.getElementById('mastertimer-playpause-wrapper').innerHTML = '<i class="eg-icon-play"></i><span>PLAY</span>';
				mp[0].className = mp[0].classList.contains('inaction') ? mp[0].className : mp[0].className+" inaction";
			}

			if (tpos>0 && mp.data('wasidle')=="wasnotidle") {
				if (recreatetimers) createGlobalTimeline(false);
				var mtl = mp.data('tl');
				mtl.stop();
				mst.stop();
				mtl.seek(tpos);
				mst.seek(tpos);
			}
			
			if (tpos>0) {
				var mpst = document.getElementById('mastertimer-poscurtime');
				mpst.className = mpst.classList.contains('movedalready') ? mpst.className : mpst.className+' movedalready';
				mpst.innerHTML = t.convToTime(tpos*100);
				mp.removeClass("timerinidle");
			} else {
				var mpst = document.getElementById('mastertimer-poscurtime');
				if (mpst.classList.contains('movedalready')) {
					mpst.innerHTML = "Idle";
					mp.addClass("timerinidle");
				}

			}
			mp.trigger('poschanged');
			
		}

	t.convToTime = function(tpos) {


		
		var min = Math.floor(tpos/6000),
			sec = Math.floor(Math.ceil(tpos - (min*6000))/100),
			ms = Math.round(tpos-(sec*100)-(min*6000));

		if (min==0) min = "00"
		else
		if (min<10) min = "0"+min.toString();

		if (sec==0) sec = "00"
		else
		if (sec<10) sec = "0"+sec.toString();

		if (ms==0) ms = "00"
		else
		if (ms<10) ms = "0"+ms.toString()
		return min.toString()+":"+sec.toString()+"."+ms.toString();

	}
	
	
	t.allLayerToIdle = function(obj) {		
		var search = obj!=undefined && obj.type!=undefined ? 'slide_layer_type_'+obj.type : 'slide_layer';				
			elements = document.getElementsByClassName(search);
		for (var i=0;i<elements.length;i++) {
			t.rebuildLayerIdle(jQuery(elements[i]));					
		}
				
	}

	/***********************************
		-	INIT THE MASTER TIMER	-
	************************************/
	var initMasterTimer = function() {
		var mw = jQuery('#master-rightheader');


		// CHANGE THE POSITION OF THE TIME LINE
		jQuery('#mastertimer-position').on("poschanged",function() {
			var mp = jQuery(this),
				tpos = Math.round((mp.position().left+t.timercorrectur)),
				str = t.convToTime(tpos);
			if (tpos<0) str="IDLE";
			document.getElementById('master-timer-time').innerHTML = str;
		});


		// BACK TO IDLE
		jQuery('#mastertimer-backtoidle').click(function() {
			jQuery('#mastertimer-position').removeClass("inaction");
			document.getElementById('mastertimer-playpause-wrapper').innerHTML = '<i class="eg-icon-play"></i><span>PLAY</span>';		
			document.getElementById('master-timer-time').innerHTML = 'IDLE';
			t.stopAllLayerAnimation();
			var mp = jQuery('#mastertimer-position'),
				mst = jQuery('#divbgholder').data('slidetimeline');
			mp.css({left:"-15px"});			
			if (mp.data('tl')!=undefined) {
				mp.data('tl').kill();
			}
			if (mst!=undefined) {
				mst.stop();
				mst.seek(100000);
			}

			t.allLayerToIdle();
			
		})
		
		
		// HOVER OUT OF MASTERTIMER SHOULD RESET ANY SETTINGS
		jQuery('#divLayers').hover(function() {

			var mp = jQuery(document.getElementById('mastertimer-position')),
				mpw = document.getElementById('mastertimer-playpause-wrapper'),
				mst = jQuery(document.getElementById('divbgholder')).data('slidetimeline');
			
			if (mp.data('tl')!=undefined)
				mp.data('tl').stop();
			
			if (mst!=undefined) {
				mst.stop();
				mst.seek(100000);
			}

			mp.removeClass("inaction");
			mpw.innerHTML = '<i class="eg-icon-play"></i><span>PLAY</span>';
			if (mp.hasClass("hovering")) {
				mp.removeClass("hovering");
				t.stopAllLayerAnimation();
				t.allLayerToIdle();

				// Click on LayerAnimation Button the current Selected Layer should be Animated
				if (!jQuery('#layeranimation-playpause').hasClass("inpuase")) {
					if (t.checkAnimationTab())
						t.animateCurrentSelectedLayer(1);
				}

				if (!jQuery('#loopanimation-playpause').hasClass("inpuase")) {
					if (t.checkLoopTab())
						t.animateCurrentSelectedLayer(2);
				}
			}

		});

		// HOVER ON THE ANIMATION PART, SHOULD START THE ANIMATION MODE AGAIN
		jQuery('#mastertimer-wrapper').hover(function() {

			if (!jQuery(this).hasClass("overme")) {
				jQuery(this).addClass("overme");
				t.masterTimerPositionChange(true);
			}
		}, function() {
			jQuery(this).removeClass("overme");

		})


		
		// DRAG THE MASTER TIMER SHOULD ANIMATE THINGS IN POSITION
		jQuery('#mastertimer-position').draggable({
			axis:"x",
			start:function(event,ui) {

				punchgs.TweenLite.set(document.getElementById('mastertimer-curtime'),{autoAlpha:0,x:-3,y:-10});
				punchgs.TweenLite.set(document.getElementById('mastertimer-curtime-b'),{autoAlpha:0});		
						
				t.deactivatePerfectScrollBars();

			},
			drag:function(event,ui) {
				ui.position.left = Math.max(-15,ui.position.left);
				t.masterTimerPositionChange(false);
			},
			
			stop:function(event,ui) {
				punchgs.TweenLite.set(document.getElementById('mastertimer-curtime'),{autoAlpha:1,x:-1,y:0,ease:punchgs.Power2.easeInOut});
				punchgs.TweenLite.set(document.getElementById('mastertimer-curtime-b'),{autoAlpha:1});						
			}
		});

		// CLICK SOMEWHERE ON THE LINEAR
		jQuery('#mastertimer-linear').click(function(e) {
			var lo = jQuery('#mastertimer-linear').offset().left,
				sl = jQuery('#master-rightheader').scrollLeft();

			jQuery('#mastertimer-position').css({left:(e.pageX-lo + sl)+"px"});
			t.masterTimerPositionChange();
		})
		
		jQuery('#mastertimer-maxtime').draggable({
			axis:"x",			
			containment:"#master-rightheader",
			create:function(event,ui) {
				t.mainMaxTimeLeft = jQuery('#mastertimer-maxtime').position().left;
				document.getElementById('mastertimer-maxcurtime').innerHTML = t.convToTime(t.mainMaxTimeLeft);
				t.setIdleZones();				
			},
			start:function(event,ui) {
				punchgs.TweenLite.set(document.getElementById('mastertimer-curtime'),{autoAlpha:0,x:-3,y:-10});
				punchgs.TweenLite.set(document.getElementById('mastertimer-curtime-b'),{autoAlpha:0});	
				document.getElementById('mastertimer-maxcurtime').innerHTML = t.convToTime(t.mainMaxTimeLeft);				
				t.setIdleZones();
				t.deactivatePerfectScrollBars();
			},
			drag:function(event,ui) {				
				t.mainMaxTimeLeft = ui.position.left;
				document.getElementById('mastertimer-maxcurtime').innerHTML = t.convToTime(t.mainMaxTimeLeft);				
				document.getElementById('delay').value = t.mainMaxTimeLeft*10;			
				t.setIdleZones();								
				t.compareLayerEndsVSSlideEnd();
			},
			stop:function(event,ui) {
				punchgs.TweenLite.set(document.getElementById('mastertimer-curtime'),{autoAlpha:1,x:-1,y:0,ease:punchgs.Power2.easeInOut});
				punchgs.TweenLite.set(document.getElementById('mastertimer-curtime-b'),{autoAlpha:1});
				t.mainMaxTimeLeft = ui.position.left;
				document.getElementById('mastertimer-maxcurtime').innerHTML = t.convToTime(t.mainMaxTimeLeft);				
				document.getElementById('delay').value = t.mainMaxTimeLeft*10;			
				t.setIdleZones();								
				g_slideTime = t.mainMaxTimeLeft*10;
				u.setMaintime(g_slideTime);
				t.compareLayerEndsVSSlideEnd();
				t.rerenderAllAudioMap();
			}

		});

		
		__ctime = jQuery('#mastertimer-curtime');
		__ctimeb = jQuery('#mastertimer-curtime-b');
		__ctimei = jQuery('#mastertimer-curtimeinner');

		function checklroffset() {
			__coffset = parseInt(jQuery('#layers-right').offset().left,0);
		}

		jQuery(window).resize(function() {
				checklroffset();		
		});

		checklroffset();
		__ctime.data('offset',0);
		
		jQuery('.master-rightcell').on('mousemove',function(e) {
			
			var x = (e.pageX-__coffset)-jQuery(document.getElementById('master-rightheader')).data('left');
			if (__ctime.data('offset') ==0) {				
				punchgs.TweenLite.set(__ctime,{left:x});
				punchgs.TweenLite.set(__ctimeb,{left:x+15});
				__ctimei[0].innerHTML = t.convToTime(x-10);
			}
		});

		
		// CLICK ON PLAY/PAUSE BUTTON SHOULD PLAY OR RESET THINGS
		jQuery('#mastertimer-playpause-wrapper').click(function() {
			var mpw = jQuery(this);
			punchgs.TweenLite.to(jQuery('#mastertimer-poscurtime'),0.3,{autoAlpha:0,x:-3,y:-10,ease:punchgs.Power2.easeInOut});
			if (mpw.find('.eg-icon-pause').length>0) {

				document.getElementById('mastertimer-playpause-wrapper').innerHTML = '<i class="eg-icon-play"></i><span>PLAY</span>';
				t.stopAllLayerAnimation();
				var mp = jQuery('#mastertimer-position');
				if (mp.data('tl')!=undefined) {
					mp.data('tl').kill();
				}
			} else {
				createGlobalTimeline(true);
				document.getElementById('mastertimer-playpause-wrapper').innerHTML ='<i class="eg-icon-pause"></i><span>PAUSE</span>';
				jQuery('#mastertimer-position').addClass("inaction");
				var mp = jQuery('#mastertimer-position'),
					mtl = mp.data('tl'),
					mst = jQuery('#divbgholder').data('slidetimeline'),
					tpos = (mp.position().left)/100;

				mtl.play(tpos);
				mst.play(tpos);
				jQuery('#divbgholder').data('slidetimeline').play(tpos);				
				mtl.eventCallback("onComplete",function() {
					mtl.play(0);
					mst.play(0);
				});
				mtl.eventCallback("onUpdate",function() {
					mp.css({left:((mtl.time()*100))});
					mp.trigger('poschanged');
				})
			}
		})

	}

	t.setIdleZones = function() {
		var el = document.getElementsByClassName('slide-idle-section');
		for (var i=0;i<el.length;i++) {
			el[i].style.left = (t.mainMaxTimeLeft+15)+"px";
		}
	}

	/**********************************
		-	BUILD GLOBAL TIMELINE	-
	***********************************/
	function createGlobalTimeline(firsttime,animsaregenerated) {

		if (firsttime) t.stopAllLayerAnimation();
		var mp = jQuery('#mastertimer-position');


		if (mp.data('tl')!=undefined) {
			mp.data('tl').kill();
		}

		var mtl = new punchgs.TimelineLite();
		mtl.pause();
		
		jQuery(' .slide_layer .innerslide_layer').each(function() {
			var nextcaption = jQuery(this);
		
			nextcaption.data('inanim',theLayerInAnimation(nextcaption));
			nextcaption.data('outanim',theLayerOutAnimation(nextcaption));
			var id = u.getSerialFromID(nextcaption.closest('.slide_layer').attr('id'));
				params=u.getLayer(id);

			
			mtl.add(nextcaption.data('inanim'),params.frames["frame_0"].time/1000);
			var endspeed = params.frames["frame_999"].endspeed;
			if (endspeed==undefined) endspeed = params.frames["frame_0"].speed;			
			mtl.add(nextcaption.data('outanim'),(params.frames["frame_999"].time/1000));

		});

		mp.data('tl',mtl);
	}
	
	var setFakeAnim = function() {
		
		var found=false,
			li = jQuery('.slide-trans-cur-ul li').first();
		
		var comingtransition = li.data('animval'),
			comingtext = li.text();

		if (comingtransition == "random-selected" || comingtransition == "random" || comingtransition == "random-static" || comingtransition == "random-premium") {
			comingtransition = "fade";
			comingtext = "Fade";
		} 

		
		document.getElementById('fake-select-label').innerHTML = '"'+comingtext+'"';
		jQuery('#fake-select-label').data('valu',comingtransition);
		
		removeAllSlots();
		
		slideAnimation();
		found=true;
		
		if (found) return false;		
	}
	/**************************************
		-	ADD SLIDE MAIN TO SORTBOX	-
	**************************************/

	t.setSlideTransitionTimerBar = function() {
		var sist = document.getElementById('slide_in_sort_time'),
			speed = sist.getElementsByClassName('timeline_frame')[0],
			cont = sist.getElementsByClassName('timeline_full')[0],
			dur = document.getElementById('transition_duration') ? document.getElementById('transition_duration').value : 0,
			durcont = sist.getElementsByClassName('duration_cont')[0];

		durcont.innerHTML = dur;
		if (!jQuery.isNumeric(dur)) dur = 500;
		punchgs.TweenLite.set(speed,{width:dur/10});
		punchgs.TweenLite.set(cont,{left:15,width:t.mainMaxTimeLeft});
		
	}


	var addSlideToSortbox = function() {
		
		t.setSlideTransitionTimerBar();
		

		var sist = document.getElementById('slide_in_sort_time'),
			speed = sist.getElementsByClassName('timeline_frame')[0],
			durcont = sist.getElementsByClassName('duration_cont')[0];
			
							
		jQuery(speed).resizable({
			minWidth:0,
			handles:"e",
			start:function(event,ui) {
				
			},
			stop:function(event,ui) {								
				document.getElementById('transition_duration').value = ui.size.width*10;
				durcont.innerHTML = (ui.size.width*10);
				jQuery('.slide-trans-cur-ul li.selected').data('duration', (ui.size.width*10));
				t.resetSlideAnimations(true);
			},
			resize:function(event,ui) {
				document.getElementById('transition_duration').value = ui.size.width*10;				
				jQuery('.slide-trans-cur-ul li.selected').data('duration', (ui.size.width*10));
				durcont.innerHTML = (ui.size.width*10);
			}
			//snap:".tl-fullanim"
		});
		
		
		
	}

	
	


	//////////////////////////////////
	// 		SET AUDIO MAP 			//
	//////////////////////////////////

	t.rerenderAllAudioMap = function() {
		jQuery.each(u.arrLayers,function(i,objLayer) {			
			if (objLayer.type == "audio") {				
				t.drawAudioMap(objLayer);
			}
		});
	};


	t.drawAudioMap = function(objLayer) {
	 	
	 //	try {
		 	var li = objLayer.references.sorttable.timeline;	 	
		 	if (li.data('lastaudio') == objLayer.video_data.urlAudio && li.data('audiobuffer')!=undefined) {	 		
		 		displayAudioBuffer(objLayer,li.data('audiobuffer'));
		 	} else {
		 		loadMusicTimeLine(objLayer,objLayer.video_data.urlAudio);
		 	}

		 	li.data('lastaudio',objLayer.video_data.urlAudio);
			

			if (!AudioContext) {
				console.log('Audio Map cannot be drawn  in your Browser. Try a recent Chrome or Firefox. ');
				return false;
			}
	//	} catch(e) { console.log("Drwaring of Audio Map Failer at Initialisation");}
		
	}
	
	

	// MUSIC LOADER + DECODE
	function loadMusicTimeLine(objLayer,url) {   
		if (audioContext === null || !AudioContext) return false;
	    var req = new XMLHttpRequest(),	  
	    	li =   	objLayer.references.sorttable.timeline,
	    	currentBuffer  = null;
	    
	    req.open( "GET", url, true );
	    req.responseType = "arraybuffer";    
	    
	    req.onreadystatechange = function (e) {
	          if (req.readyState == 4) {
	             if(req.status == 200)
	                  audioContext.decodeAudioData(req.response, 
	                    function(buffer) {
	                             currentBuffer = buffer;
	                             li.data('audiobuffer',buffer);
	                             displayAudioBuffer(objLayer,buffer);
	                    }, onDecodeError);
	             else
	                  console.log('error during the load.Wrong url or cross origin issue');
	          }
	    } ;
	    req.send();
	}	

	function onDecodeError() {  alert('error while decoding your Audio file.');  }

	function getStartSec(st) {						
		return st == undefined ? -1 : st=="" ? -1 : st==" " ? -1 : jQuery.isNumeric(st) ? st : st.split(":").length>1 ? parseInt(st.split(":")[0],0)*60 + parseInt(st.split(":")[1],0) : st;
	};

	function displayAudioBuffer(objLayer,buff) {
		try {
			var li = objLayer.references.sorttable.timeline,
				leftChannel = buff.getChannelData(0), // Float32Array describing left channel     
				wr = li.find('.timeline_full'),				
				canvasWidth =buff.duration*100,
			   	canvasHeight = 19,
			   	shift = objLayer.video_data.start_at,		   	
			   	s = getStartSec(objLayer.video_data.start_at),
			   	e = getStartSec(objLayer.video_data.end_at)
			
			s= s==-1 ? 0 : s;
			e= e==-1 ? 999999999 : e;				
			s= s /60;
			e= e /60;			
			e = e>buff.duration ? buff.duration : e;
			s = s*buff.sampleRate;
			e = e*buff.sampleRate;			
			canvasWidth = ((e-s)/buff.sampleRate)*100;
			li.find('canvas').remove();
			
			// CANVAS		
			var newCanvas   = document.createElement('canvas');
			newCanvas.width = ((t.mainMaxTimeLeft));
			newCanvas.height = canvasHeight;	
			li.append('<div class="timeline_audio"></div>');

			li.find('.timeline_audio').append(newCanvas);
			
			var jc = li.find('canvas');			
			punchgs.TweenLite.set(jc,{zIndex:2,top:3,left:0,position:"absolute"});

			var context = newCanvas.getContext('2d'),
				lineOpacity = canvasWidth / leftChannel.length;

			   
		   context.save();
		   context.fillStyle = 'transparent' ;
		   context.fillRect(0,0,canvasWidth,canvasHeight );
		   context.strokeStyle = '#333';	   
		   context.translate(0,canvasHeight / 2);
		   context.globalAlpha = 0.5 ; // lineOpacity ;
		   
		   var pl = 0,
		   	   seglength = e-s;		   	 
			for (var i=0; i<e-s; i=i+200) {
			       // on which line do we get ?
			       var x = Math.floor (canvasWidth * i / seglength );
			       var y = leftChannel[s+i] * canvasHeight;			       
			       context.beginPath();
			       context.moveTo( x  , 0 );
			       context.lineTo( x+1, y );
			       context.stroke();
			       pl++;
			}

			if (objLayer.video_data.videoloop!="none") {
				var imgdata = context.getImageData(0, 0, canvasWidth, canvasHeight),
					lmult = (((t.mainMaxTimeLeft)) / canvasWidth);								
				for (var i=0;i<lmult;i++) {
					context.beginPath();
					context.moveTo(i*canvasWidth,-50);
					context.lineTo(i*canvasWidth,canvasHeight);
					context.lineWidth = 3;
					context.strokeStyle = "#c0392b";
					context.stroke();
					context.putImageData(imgdata,i*canvasWidth,0);
				}

			}

			//playSound(buff);
			
		   context.restore();	   
		   audio = jQuery(objLayer.references.sorttable.timeline[0]).find('.timeline_audio');			
			if (audio!==undefined && audio.length>0)		
				punchgs.TweenLite.set(audio,{left:15+(objLayer.frames["frame_0"].time/10), width:((objLayer.frames["frame_999"].time - objLayer.frames["frame_0"].time) + objLayer.frames["frame_999"].split_extratime + objLayer.frames["frame_999"].speed)/10});
		 } catch(e) { console.log("Drawing of Audio Map failed !")}
	}

	

	

	/******************************
		-	ADD LAYER TO SORTBOX	-
	********************************/
	t.addToSortbox = function(serial,objLayer){

				
		if (document.getElementById('layers-right-ul').children.length===1) 	
			addSlideToSortbox();
		
		if (serial===undefined) return false;

		
		var endslideclass = "",
			isVisible = t.isLayerVisible(objLayer.references.htmlLayer),
			classLI = "",
			classDrop = "",
			sortboxText = t.getSortboxText(objLayer.alias),
			depth = Number(objLayer.order)+5,
			htmlSortbox = "",
			quicksb  = ""
			visibleclass = "in-on",
			groupLink = objLayer.groupLink !==undefined ? objLayer.groupLink : 0;
		
		switch (objLayer.type) {
			case "group":
				classLI=" sortable_elements sortable_group";
				classDrop = " droppable_sortable_group";
			break;
			case "row":
				classLI="  sortable_elements sortable_group sortable_row";
				classDrop = " droppable_sortable_row";
			break;
			case "column":
				classLI=" sortable_elements sortable_column";
				classDrop = " droppable_sortable_column";
			break;
			default:
				classLI=" sortable_elements sortable_layers";
			break;
		}
		
		if (objLayer.deleted) classLI=classLI+" layer-deleted";
							
		htmlSortbox += '<li data-uniqueid="'+objLayer.unique_id+'" id="layer_sort_'+serial+'" data-type="'+objLayer.type+'" class="mastertimer-layer ui-state-default'+classLI+'" data-grouptype="'+objLayer.grouptype+'" data-pid="'+objLayer.p_uid+'">';
		
		htmlSortbox += '	<div class="layer_sort_inner_wrapper '+classDrop+'">';
				
		htmlSortbox += '		<span class="mastertimer-timeline-selector-row tipsy_enabled_top" title="Select Layer in Timeline">';
		htmlSortbox += '			<input data-uniqueid="'+objLayer.unique_id+'"  id="lots_id_'+objLayer.unique_id+'" class="layer-on-timeline-selector" style="margin:0px" type="checkbox"/>';		
		htmlSortbox += '		</span>';
		htmlSortbox += '		<span data-uniqueid="'+objLayer.unique_id+'" class="list-of-layer-links tipsy_enabled_top" title="Choose Layers Group Link">';		
		htmlSortbox += '			<span class="layer-link-type-element layer-link-type-element-cs layer-link-type-'+groupLink+'"></span>';
		htmlSortbox += '			<span class="list-of-layer-links-inner">';		
		htmlSortbox += '				<span data-linktype="1" class="layer-link-type-element layer-link-type-1"></span>';
		htmlSortbox += '				<span data-linktype="2" class="layer-link-type-element layer-link-type-2"></span>';
		htmlSortbox += '				<span data-linktype="3" class="layer-link-type-element layer-link-type-3"></span>';
		htmlSortbox += '				<span data-linktype="4" class="layer-link-type-element layer-link-type-4"></span>';
		htmlSortbox += '				<span data-linktype="5" class="layer-link-type-element layer-link-type-5"></span>';
		htmlSortbox += '				<span data-linktype="0" class="layer-link-type-element layer-link-type-0"></span>';		
		htmlSortbox += '			</span>';				
		htmlSortbox += '		</span>';
		if (objLayer.type!="column") {
			
			if (objLayer.type!=="row") {
				htmlSortbox += '	<span  class="mastertimer-timeline-zindex-row tipsy_enabled_top" title="z-Index">';
				htmlSortbox += '		<i style="margin-left:15px;margin-right:0px;" class="layersortclass eg-icon-sort"></i>';
				htmlSortbox += '		<span class="sortbox_depth" title="z-Index">'+depth+'</span>';
				htmlSortbox += '	</span>';
			} else {
				htmlSortbox += '	<span  class="mastertimer-timeline-zindex-row tipsy_enabled_top" style="cursor:default !important" title="z-Index"></span>';
			}
			
		} else {
			htmlSortbox += ' 	<span class="column_sort_row_spacer"></span>';
		}			
		htmlSortbox += '		<span class="mastertimer-timeline-tillendcontainer" style="">';
		htmlSortbox += '			<span data-uniqueid="'+objLayer.unique_id+'" data-serial="'+serial+'" class="till_slideend tipsy_enabled_top '+endslideclass+'" title="Wait till Slides End / Custom End"><i class="eg-icon-back-in-time"></i><i class="eg-icon-download-2"></i></span>';
		htmlSortbox += '		</span>';		
		htmlSortbox += '		<span class="sort-hover-part layer_sort_layer_text_field">';
		htmlSortbox += '			<span class="sortbox_text"><i class="layertypeclass ';		

		
		switch (objLayer.type) {
			case "group":
				htmlSortbox += 'fa-icon-object-group';
			break;
			case "row":
				htmlSortbox += 'rs-icon-layergroup';		
			break;

			case "column":
				htmlSortbox += 'rs-icon-layercolumns';		
			break;

			case "text":
				htmlSortbox += 'rs-icon-layerfont';
		
			break;
			case "image":
				htmlSortbox += 'rs-icon-layerimage';
		
			break;
			case "video":
				htmlSortbox += 'rs-icon-layervideo';		
			break;

			case "audio":
				htmlSortbox += 'rs-icon-layeraudio';		
			break;
			
			case "button":
				htmlSortbox += 'rs-icon-layerbutton';		
			break;

			case "shape":
				htmlSortbox += 'rs-icon-layershape';		
			break;

			case "svg":
				htmlSortbox += 'rs-icon-layersvg';		
			break;
		}


		htmlSortbox += '"></i>';

		htmlSortbox += '				<input class="timer-layer-text" style="margin-top:-1px !important" type="text" enabled value="'+sortboxText + '">';

		htmlSortbox += '			</span>';
		htmlSortbox += '		</span>';
		if (objLayer.type=="group" || objLayer.type=="row" || objLayer.type=="column") 
			htmlSortbox += '		<span class="sort_group_collapser"><i class="eg-icon-down-dir"></i><i class="eg-icon-right-dir"></i></span>'
		
		if (objLayer.type!="column")
			htmlSortbox += '		<span class="timer-manual-edit"><i class="eg-icon-pencil"></i></span>'
		htmlSortbox += '	</div>';
		
		if (objLayer.type=="group" || objLayer.type=="row") 
			htmlSortbox += '<ul id="sortable_group_'+objLayer.unique_id+'" class="sortable_groups_wrap sgw_def"></ul>';
		if (objLayer.type=="column") 
			htmlSortbox += '<ul id="sortable_columns_'+objLayer.unique_id+'" class="sortable_layers_in_columns sgw_def"></ul>';
		htmlSortbox += '</li>';

		var quickClassE = "";
		if (objLayer.p_uid!=undefined && objLayer.p_uid !==-1 && objLayer.type!=="row" && objLayer.type!=="group") quickClassE = " quick_in_group";
		if (objLayer.type==="row") quickClassE +=" quick_in_row"

		quicksb += '<li id="layer_quicksort_'+serial+'" data-serial="'+serial+'" class="quicksortlayer ui-state-default layer-toolbar-li'+quickClassE+'">';
		var btlist ='<span class="quick-edit-toolbar-in-list">';

		switch (objLayer.type) {
			case "text":
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="rs-icon-layerfont_n"></i>';
				btlist += '<span id="button_edit_layer_'+serial+'" class="button_edit_layer layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>';
				btlist += '<span id="button_reset_size_'+serial+'" class="button_reset_size layer-short-tool revblue"><i class="eg-icon-resize-normal"></i></span>';
			break;
			case "group":			
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="fa-icon-object-group"></i>';				
				btlist += '<span  class="layer-short-tool revdarkgray"></span>';
				btlist += '<span  class="layer-short-tool revdarkgray"></span>';
			break;
			case "row":
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="rs-icon-layergroup_n"></i>';				
				btlist += '<span  class="layer-short-tool revdarkgray"></span>';
				btlist += '<span  class="layer-short-tool revdarkgray"></span>';
			break;
			case "column":			
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="rs-icon-layercolumns_n"></i>';				
				btlist += '<span  class="layer-short-tool revdarkgray"></span>';
				btlist += '<span  class="layer-short-tool revdarkgray"></span>';
				btlist += '<span  class="layer-short-tool revdarkgray"></span>';
				btlist += '<span  class="layer-short-tool revdarkgray"></span>';
			break;	
			case "shape":
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="rs-icon-layershape_n"></i>';
				btlist += '<span id="button_edit_shape_'+serial+'" class="button_edit_shape layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>';
				btlist += '<span  class="layer-short-tool revdarkgray"></span>';
			break;
			case "button":
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="rs-icon-layerbutton_n"></i>';
				btlist += '<span id="button_edit_layer_'+serial+'" class="button_edit_layer layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>';
				btlist += '<span id="button_reset_size_'+serial+'" class="button_reset_size layer-short-tool revblue"><i class="eg-icon-resize-normal"></i></span>';
			break;
			case "image":
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="rs-icon-layerimage_n"></i>';
				btlist += '<span  id="button_change_image_source_'+serial+'" class="button_change_image_source layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>';
				btlist += '<span id="button_reset_size_'+serial+'" class="button_reset_size layer-short-tool revblue"><i class="eg-icon-resize-normal"></i></span>';
			break;
			case "video":
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="rs-icon-layervideo_n"></i>';
				btlist += '<span  id="button_change_video_settings_'+serial+'" class="button_change_video_settings layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>';				
				btlist += '<span  class="layer-short-tool revdarkgray"></span>';
			break;
			case "audio":
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="rs-icon-layeraudio_n"></i>';
				btlist += '<span  id="button_changeaudio_settings_'+serial+'" class="button_change_audio_settings layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>';				
				btlist += '<span  class="layer-short-tool revdarkgray"></span>';
				classLI = " layer-sort-audio-item"
			break;
			case "svg":
				quicksb += '<span class="layer-short-tool revdarkgray layer-title-with-icon"><i class="rs-icon-layersvg_n"></i>';
				btlist += '<span  id="button_changesvg_settings_'+serial+'" class="button_change_svg_settings layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>';				
				btlist += '<span  class="layer-short-tool revdarkgray"></span>';
			break;
		}
		
		quicksb += '<input type="text" class="layer-title-in-list" value="'+sortboxText+'"></span>';
		quicksb += btlist;		
		if (objLayer.type!=="column") {
			quicksb += '<span id="button_delete_layer_'+serial+'" class="button_delete_layer layer-short-tool revred"><i class="rs-lighttrash"></i></span>';
			quicksb += '<span id="button_duplicate_layer_'+serial+'" class="button_duplicate_layer layer-short-tool revyellow" data-isstatic=""><i class="rs-lightcopy"></i></span>';
		} 
		quicksb += '<span style="display:block;float:none;clear:both"></span></span>';
		quicksb += '<span class="quick-layer-view layer-short-tool revdarkgray '+visibleclass+'"><i class="eg-icon-eye"></i></span>';
		quicksb += '<span class="quick-layer-lock layer-short-tool revdarkgray"><i class="eg-icon-lock-open"></i></span>';
		quicksb += '<div style="clear:both;display:block"></div>';
		quicksb +='</li>';
		
		
				
		if (document.getElementById('quick-layers-list-id').childNodes.length>1) document.getElementById('nolayersavailable').style.display='none';

		var htmlTimeline = "",
			grouptypeclass = objLayer.grouptype === "logical_o" ? " hide_timeline" : "";
		htmlTimeline += '<li data-uniqueid="'+objLayer.unique_id+'" data-serial="'+serial+'" id="layer_sort_time_'+serial+'" class="sortable_elements mastertimer-layer ui-state-default'+classLI+grouptypeclass+'" data-grouptype="'+objLayer.grouptype+'" data-pid="'+objLayer.p_uid+'">';
		htmlTimeline += '		<div class="timeline_full"></div>';		
		htmlTimeline += '  <div class="timeline">';		
		htmlTimeline += '  	<div class="timeline-relative-marker trm-groupandrowmarker"></div>';

		htmlTimeline += '		<div data-frameindex="0" id="tl_'+objLayer.unique_id+'_frame_0" class="timeline_frame tf_startframe tl_layer_frame" data-uniqueid="'+objLayer.unique_id+'" data-serial="'+serial+'" style="z-index:50;">';		
		htmlTimeline += ' 			<span class="timebefore_cont"></span>';
		htmlTimeline += '			<div class="tl_speed_wrapper">';			
		htmlTimeline += '				<div class="tlf_speed"><span class="duration_cont"></span></div>';
		htmlTimeline += '				<div class="tlf_splitdelay"></div>';
		htmlTimeline += '			</div>';
		htmlTimeline += '			<span class="show_timeline_helper">EDIT</span>';
		htmlTimeline += '		</div>';		
		htmlTimeline += '		<div data-frameindex="999" id="tl_'+objLayer.unique_id+'_frame_999" class="timeline_frame tf_endframe tl_layer_frame" data-uniqueid="'+objLayer.unique_id+'" data-serial="'+serial+'" style="z-index:48;">';
		htmlTimeline += ' 			<span class="timebefore_cont"></span>';
		htmlTimeline += '			<div class="tl_speed_wrapper">';		
		htmlTimeline += '				<div class="tlf_speed"><span class="duration_cont"></span></div>';
		htmlTimeline += '				<div class="tlf_splitdelay"></div>';
		htmlTimeline += '			</div>';
		htmlTimeline += '			<span class="show_timeline_helper">EDIT</span>';
		htmlTimeline += '		</div>';		
		htmlTimeline += ' </div>';
		htmlTimeline += ' <div class="slide-idle-section"></div>';
		htmlTimeline += '</li>';

		var inserttoend = true;
		if (objLayer.type==="row" && document.getElementById('layers-left-ul').getElementsByClassName('sortable_row').length>0) {
			inserttoend = false;
			document.getElementById('layers-left-ul').getElementsByClassName('sortable_row')[0].insertAdjacentHTML('afterend',htmlSortbox);				
			document.getElementById('quick-layers-list-id').getElementsByClassName('quick_in_row')[0].insertAdjacentHTML('afterend',quicksb);
			document.getElementById('layers-right-ul').getElementsByClassName('sortable_row')[0].insertAdjacentHTML('afterend',htmlTimeline);
		}	

		if (inserttoend) {
			document.getElementById('layers-left-ul').insertAdjacentHTML('beforeend',htmlSortbox);		
			document.getElementById('quick-layers-list-id').insertAdjacentHTML('beforeend',quicksb);
			document.getElementById('layers-right-ul').insertAdjacentHTML('beforeend',htmlTimeline);
		}
		
		
		jQuery('#layer_quicksort_'+serial).on('mouseenter',function(event) {
			jQuery('.layer_due_list_element_selected').removeClass('layer_due_list_element_selected');
			jQuery('#slide_layer_'+jQuery(this).data('serial')).addClass("layer_due_list_element_selected");
		});

		jQuery('#layer_quicksort_'+serial).on('mouseleave',function(event) {
			jQuery('.layer_due_list_element_selected').removeClass('layer_due_list_element_selected');			
		});

		jQuery("#layers-left .tipsy_enabled_top").tipsy({
  				gravity:"s",
  				delayIn: 70
  		});

  		
		reinitSortBox();

		
		var liel= document.getElementById('layer_sort_time_'+serial),
			li = jQuery(liel),
			curel = liel.getElementsByClassName("timeline")[0],
			cur = jQuery(curel);
				

		objLayer.references.sorttable = objLayer.references.sorttable === undefined ? {} : objLayer.references.sorttable;
		objLayer.references.sorttable.layer = jQuery(document.getElementById('layer_sort_'+serial));
		objLayer.references.sorttable.timeline = li;
		objLayer.references.quicklayer = jQuery(document.getElementById('layer_quicksort_'+serial));




		if (objLayer.type=="audio") {
			li.data('objref',objLayer);			

  			t.drawAudioMap(objLayer);

  			li.on('mousemove',function(e) {  				
  				try{
	  				var li = jQuery(this),
	  					objLayer = li.data('objref'),
	  					serial = li.data('serial'),
	  					player = jQuery('#slide_layer_'+serial+" audio")[0];
	  				if (!li.hasClass("ui-state-hover")) return false;
					
					clearTimeout(li.data('audiopreview'));
					li.find('.audio-progress').remove();
					player.pause();
	  				
	  				
	  				li.data('audiopreview',setTimeout(function() {
		  				
		  				var	tf = li.find('.timeline_full'),
		  					dl = tf.position().left,  					
		  					dw = tf.width(),
		  					mousex = (e.pageX-li.offset().left),
		  					time = mousex-dl;

		  				if (mousex <dl || mousex>(dl+dw)) return;
		  				
		  				
		  				li.find('.audio-progress').remove();
		  				li.append('<div class="audio-progress"></div>');
		  				var ap = li.find('.audio-progress'),		  						  				
		  					
		  					_s = getStartSec(objLayer.video_data.start_at),
			   				_e = getStartSec(objLayer.video_data.end_at);

						_s= _s==-1 ? 0 : _s;
						_e= _e==-1 ? 999999999 : _e;				
						_s= _s /60;
						_e= _e /60;			
						_e = _e>player.duration ? player.duration : _e;
						
						var segment = _e-_s,
							shift = Math.floor((time / (segment*100)));
						

		  				if (time>segment*100) 
		  					time = time - ((segment*100)*shift);

		  					  				
		  				if (time>0) {
		  					restw = (segment-time/100) * 100;  					  				
		  					punchgs.TweenLite.fromTo(ap,(segment-time/100),{left:(dl+time+(shift*(segment*100))),transformOrigin:"0% 50%", width:restw,scaleX:0},{scale:1,ease:punchgs.Linear.easeNone, onUpdate:function() {}, onComplete:function() {
		  						player.pause();
		  					}});
		  				}
		  				if (time>0) {
		  					player.play();
		  					player.currentTime = time/100;
		  				} 	
		  			},400));	  				
		  		} catch(er) {

		  		}
  			});

  			li.on('mouseleave',function(e) {
  				try {
  					var li = jQuery(this),  					
	  					serial = li.data('serial'),
	  					player = jQuery('#slide_layer_'+serial+" audio")[0];
	  				clearTimeout(li.data('audiopreview'));
	  				li.find('.audio-progress').remove();
  					player.pause();
  				} catch(er) { }
	  		});
  		}

  		var el = liel.getElementsByClassName('timeline_frame');  		  		
  		for (var i=0;i<el.length;i++) {  			
  			jQuery(el[i]).resizable({
  				handles: 'e,w',
  				minWidth:1,
	  			create: function(event,ui) {
	  				var a = this;		  				 			
	  				t.setTLFrame(a);
	  				setTimeout(function() {
	  					t.frameLimitations(a);
	  				},25);
	  			},
	  			start: function(event,ui) {	  				
	  				t.deactivatePerfectScrollBars();	  	  				
	  				t.updateTLFrame(this,"trigger",undefined,ui.size.width);

	  			},
	  			resize: function(event,ui) {	  					  				
	  				t.updateTLFrame(this,"trigger",undefined,ui.size.width);	  				
	  			},
	  			stop: function(event,ui) {
	  				t.updateTLFrame(this,"trigger");
	  			}
	  		});

	  		jQuery(el[i]).draggable({
	  			axis:"x",
	  			start:function(event,ui) {
	  				t.recordFrameStatus(this,ui);
	  			},
	  			drag:function(event,ui) {	  				
	  				t.frameLimitations(this,ui);
	  				t.updateTLFrame(this,"trigger");	
	  				t.updateAllSelectedLayerTimeline(this);  									
	  			},
	  			stop:function(event,ui) {
	  				t.frameLimitations(this,ui);
	  				t.updateTLFrame(this,"trigger");
	  				t.updateAllSelectedLayerTimeline(this);	  				
	  			}
	  		});
  		}  	
  		t.resetTimeLineHeight();
  		t.setIdleZones();			
	}

	/**
	 Deactivate the Perfect Scroll bars for a while, since elements just simple slow down
	*/
	t.deactivatePerfectScrollBars = function() {
		jQuery('.revolution-template-groups').perfectScrollbar("destroy");		
	}

	t.activatePerfectScrollBars = function() {
		jQuery('.revolution-template-groups').perfectScrollbar();
	}

	/**
	 check if the Layer should go till Slide End, or should animate our before.
	 if objLayer.endWithSlide == true -> the Layer should not get any "data-end" output !!
	*/
	var checkTillSlideEnd = function(objLayer) {
		
		var maxtime = ((t.mainMaxTimeLeft))*10,
			li = document.getElementById('layer_sort_'+objLayer.serial);
			
		if ( objLayer.frames["frame_999"].time >= maxtime) {			
			objLayer.endWithSlide = true;
			if (!li.classList.contains("tillendon")) 			
				li.className += " tillendon";			
		} else {
			objLayer.endWithSlide = false;
			jQuery(li).removeClass("tillendon");
		}	
	}

	t.setTLFrame = function(frame) {
		var speedcont = frame.getElementsByClassName('tlf_speed')[0],
			splitcont = frame.getElementsByClassName('tlf_splitdelay')[0],	
			durcont = frame.getElementsByClassName('duration_cont')[0],	
			timecont = frame.getElementsByClassName('timebefore_cont')[0],				
			trm = frame.parentNode.parentNode.getElementsByClassName('timeline-relative-marker')[0],
			frame=jQuery(frame),			
			objLayer = u.getLayerByUniqueId(frame.data('uniqueid')),
			triggered = u.checkLayerTriggered(objLayer),
			frameslength = u.getObjectLength(objLayer.frames);

		objLayer.frames["frame_0"].time = Math.max(0,objLayer.frames["frame_0"].time);				
		objLayer.frames["frame_999"].time = Math.min(t.mainMaxTimeLeft*10,objLayer.frames["frame_999"].time);


		var fi = frame.data('frameindex'),
			speed = objLayer.frames["frame_"+fi].speed,
			time = objLayer.frames["frame_"+fi].time,
			splitdelay = getSplitCounts(objLayer.text,objLayer.frames["frame_"+fi].split,objLayer.frames["frame_"+fi].splitdelay),
			timedif = time;
										

		objLayer.frames["frame_"+fi].split_extratime = splitdelay;
		
		
		if (splitdelay!==0) {
			punchgs.TweenLite.set(speedcont,{width:(speed/10)-splitdelay});
			punchgs.TweenLite.set(splitcont,{width:splitdelay});
		} else {
			punchgs.TweenLite.set(speedcont,{width:speed/10});
		}

		
		punchgs.TweenLite.set(frame,{left:time/10, width:(splitdelay+(speed/10))});		
		durcont.innerHTML = speed;
		
		
		if (objLayer.p_uid!==undefined && objLayer.p_uid!==-1 && u.getLayerByUniqueId(objLayer.p_uid).length>0) {
			var p_objLayer = u.getLayerByUniqueId(objLayer.p_uid);			
			trm.style.display="block";
			trm.style.width = ((p_objLayer.frames["frame_0"].time/10)-1)+"px";		
			timedif = time - p_objLayer.frames["frame_0"].time;				
		} else {
			trm.style.display="none";
			trm.style.width = "0px";
			if (fi!==0) {				
				var prevframe = fi===999 ? objLayer.frames["frame_"+(frameslength-2)] : objLayer.frames["frame_"+(fi-1)];
				if (prevframe!==undefined)
					timedif = time - (prevframe.time + prevframe.speed + (prevframe.split_extratime*10));
			}
		}


		if (time == t.mainMaxTimeLeft * 10) 
			timecont.innerHTML = '<span class="wait_slide_end">WAIT</span>';								
	
		
		objLayer.frames["frame_"+fi].time_relative = timedif;

		if (fi==0 && triggered.in) timecont.innerHTML = '<span class="triggered_layer_on_timeline">a</span>';
		if (fi==999 && triggered.out) timecont.innerHTML = '<span class="triggered_layer_on_timeline">a</span>';
		t.updateFullTime(objLayer);
		checkTillSlideEnd(objLayer);

	}

	t.updateTLFrame = function(frame,source,ignorerecursive,resizewidth) {
		if (t.recordFrameStatusForce) 
			t.recordFrameStatus(frame);
		

		var curserial = u.getCurrentLayer().serial,
			speedcont = frame.getElementsByClassName('tlf_speed')[0],
			splitcont = frame.getElementsByClassName('tlf_splitdelay')[0],	
			durcont = frame.getElementsByClassName('duration_cont')[0],
			timecont = frame.getElementsByClassName('timebefore_cont')[0],							
			trm = frame.parentNode.parentNode.getElementsByClassName('timeline-relative-marker')[0],
			frame=jQuery(frame),			
			objLayer = u.getLayerByUniqueId(frame.data('uniqueid')),
			objUpdate = {frames:{}},
			frameslength = u.getObjectLength(objLayer.frames),
			triggered = u.checkLayerTriggered(objLayer);	
			fi = frame.data('frameindex'),
			speed = frame.outerWidth()*10,
			time = frame.position().left*10,			
			splitdelay = getSplitCounts(objLayer.text,objLayer.frames["frame_"+fi].split,objLayer.frames["frame_"+fi].splitdelay),
			currentframe = objLayer.frames["frame_"+fi],
			updateTimerText = true,
			timedif = time;
		
		objUpdate.frames["frame_"+fi] = {};
			
		if ((speed-(splitdelay*10))<0) {
			speed = splitdelay*10;			
			punchgs.TweenLite.set(frame,{width:(splitdelay)});
		}
				
		if (splitdelay!==0) {
			punchgs.TweenLite.set(speedcont,{width:(speed/10)-splitdelay});
			punchgs.TweenLite.set(splitcont,{width:splitdelay});
		} else {
			punchgs.TweenLite.set(speedcont,{width:speed/10});
		}
		
		
		durcont.innerHTML = speed;
		
		if ((time == t.mainMaxTimeLeft * 10) || (fi==0 && triggered.in) || (fi==999 && triggered.out))
			updateTimerText = false;

		// CALCULATE THE DELAYS BETWEEN FRAMES OR PARRENT ELEMENTS		
		if (objLayer.p_uid!==undefined && objLayer.p_uid!==-1 && u.getLayerByUniqueId(objLayer.p_uid).length>0) {
			var p_objLayer = u.getLayerByUniqueId(objLayer.p_uid);			
			timedif = time - p_objLayer.frames["frame_0"].time;
			trm.style.display="block";
		} else {
			trm.style.display="none";
			trm.style.width="0px";		
			if (fi!==0) {
				var prevframe = fi===999 ? objLayer.frames["frame_"+(frameslength-2)] : objLayer.frames["frame_"+(fi-1)];							
				if (prevframe)
					timedif = time - (prevframe.time + prevframe.speed + (prevframe.split_extratime*10));
			}
		}
		
		// SET TO "WAIT" IF ELEMENT IS BIGGER THAN SLIDE LENGTH
		if (time == t.mainMaxTimeLeft * 10) timecont.innerHTML = '<span class="wait_slide_end">WAIT</span>';												
		// DRAW AN "A" IF LAYER ACTION TRIGGERED
		if (fi==0 && triggered.in) timecont.innerHTML = '<span class="triggered_layer_on_timeline">a</span>';
		if (fi==999 && triggered.out) timecont.innerHTML = '<span class="triggered_layer_on_timeline">a</span>';
		
		currentframe.time_relative = timedif;		
		objUpdate.frames["frame_"+fi].speed = speed-(splitdelay*10);
		objUpdate.frames["frame_"+fi].time = time;	
		objUpdate.frames["frame_"+fi].time_relative=timedif;	
		objUpdate.frames["frame_"+fi].split_extratime = splitdelay;						
		
		if (objLayer.serial == curserial) {	
			if (fi===0)	document.getElementById('layer_speed').value = objUpdate.frames["frame_0"].speed;
			if (fi===999) document.getElementById('layer_endspeed').value =  objUpdate.frames["frame_999"].speed;
		}
		if (source!=="trigger") {
			currentframe.speed = objUpdate.frames["frame_"+fi].speed;
			currentframe.time = objUpdate.frames["frame_"+fi].time;
		}			

		// MOVE ALL CHILDREN ELEMENTS TOGETHER WITH THE FIRST FRAME
		if (fi===0) {
			if (objLayer.type==="row" || objLayer.type==="column" || objLayer.type=="group") {
				var _list = u.getLayersInGroup(objLayer.unique_id);						
				for (var i=0;i<_list.columns.length;i++) {
					var l_tl = _list.columns[i].references.sorttable.timeline,
						trm = l_tl[0].getElementsByClassName('timeline-relative-marker')[0];
					trm.style.width = ((time/10)-1)+"px";
				}
				for (i=0;i<_list.layers.length;i++) {
					var l_tl = _list.layers[i].references.sorttable.timeline,
						trm = l_tl[0].getElementsByClassName('timeline-relative-marker')[0];

					if (objLayer.type==="row") {
						var p_tl = document.getElementById("tl_"+_list.layers[i].p_uid+"_frame_0");							
						if (p_tl!==null && p_tl!==undefined) {															
							trm.style.width = p_tl.style.left; 							
						}
					} else {
						trm.style.width = ((time/10)-1)+"px";
					}
				}
			}		
		}

		// UPDATE DELAYS ON EACH FRAMES COMING AFTER THE CURRENT FRAME 
		if (fi!==999) {
			var nfi = fi+1>=frameslength-1 ? 999 : fi+1,
				nextframe = objLayer.frames["frame_"+nfi];			
			if (nextframe!=undefined) {
				nextframe.time_relative = nextframe.time - (currentframe.time+currentframe.speed+(currentframe.split_extratime*10));			
				objUpdate.frames["frame_"+nfi] = {time_relative : nextframe.time_relative};
			}

		}
				
		if (source=="trigger")
			u.updateLayer(objLayer.serial,objUpdate);
		else 
			currentframe.split_extratime = objUpdate.frames["frame_"+fi].split_extratime;
		

		t.frameLimitations(frame,false,ignorerecursive,{update:updateTimerText,triggered:triggered,timecont:timecont});
		t.updateFullTime(objLayer);
		checkTillSlideEnd(objLayer);
	}

	t.addLayersColumnsToSelectedElements = function(objLayer,fi) {		
		var temp =  u.getLayersInGroup(objLayer.unique_id)
		if (objLayer.type==="row" || objLayer.type=="column" || objLayer.type==="group") {
			for (var sfi=0;sfi<=temp.layers.length-1;sfi++) {
				var _pid = temp.layers[sfi].unique_id;
				if (jQuery.inArray(_pid,u.selectedLayers) == -1 && jQuery.inArray(_pid,u.currentGroupElements) == -1) {					
					var _pel = document.getElementById('tl_'+_pid+'_frame_'+fi);					
					u.currentGroupElementsPositionLeftReset.push(parseInt(_pel.style.left,0));			
					u.currentGroupElements.push(_pid);
				}
			}
			if (objLayer.type==="row")
				for (var sfi=0;sfi<=temp.columns.length-1;sfi++) {
					var _pid = temp.columns[sfi].unique_id;
					if (jQuery.inArray(_pid,u.selectedLayers) == -1 && jQuery.inArray(_pid,u.currentGroupElements) == -1) {					
						var _pel = document.getElementById('tl_'+_pid+'_frame_'+fi);						
						u.currentGroupElementsPositionLeftReset.push(parseInt(_pel.style.left,0));			
						u.currentGroupElements.push(_pid);
					}
				}
		}
		return true;
	}

	// Record the last known Position of Elements before Drag
	t.recordFrameStatus = function(frame,ui) {
		var frame=jQuery(frame),
			fi = frame.data('frameindex'),
			objLayer = u.getLayerByUniqueId(frame.data('uniqueid'));
		
		objLayer.positionLeftReset = ui!==undefined ? ui.position.left : frame.position().left;
		u.selectedLayersPositionLeftReset = [];
		u.currentGroupElements = [];
		u.currentGroupElementsPositionLeftReset = [];
		for (var sfi=0;sfi<=u.selectedLayers.length-1;sfi++) {
			var _pid = u.selectedLayers[sfi],
				_obj = _pid!==-1 ? u.getLayerByUniqueId(_pid) : -1,
				_pel = document.getElementById('tl_'+_pid+'_frame_'+fi);
			u.selectedLayersPositionLeftReset.push(parseInt(_pel.style.left,0));			
			if (_obj!==-1) 				
				t.addLayersColumnsToSelectedElements(_obj,0);
			
		}				
		t.addLayersColumnsToSelectedElements(objLayer,0);
		t.recordFrameStatusForce=false;		
	}

	// CHECK IF LEFT OR RIGHT SIDE OF FRAME ALREADY REACHED, REPRINT DELAYS AND POSITIONS
	t.frameLimitations = function(frame,ui,ignorerecursive,_tc) {
		
		if (t.recordFrameStatusForce) 
			t.recordFrameStatus(frame);
		
		var frame=jQuery(frame),
			objLayer = u.getLayerByUniqueId(frame.data('uniqueid')),
			pframe = frame.prev(),
			nframe = frame.next(),
			nframei = nframe.data('frameindex'),
			fi = frame.data('frameindex'),
			fl = ui!==undefined && ui!==false ? ui.position.left : frame.position().left,
			fw = frame.outerWidth(),
			frameslength = u.getObjectLength(objLayer.frames),
			currentframe = objLayer.frames["frame_"+fi];
			

			
		// LEFT CHECK

		if (pframe.length>0) 
			fl = Math.max((pframe.position().left+pframe.outerWidth())-1, fl);			
		fl = Math.max(0,fl); 					
		
		// RIGHT CHECK
		if (nframe.length>0 && fi!==999)
			fl = Math.min(nframe.position().left-fw, fl);
		fl = Math.min(t.mainMaxTimeLeft,fl);

		// REWRITE TIME INFO'S
		if (_tc!==undefined && _tc.update) {
			var timedif = 0;
			if (objLayer.p_uid!==undefined && fi===0 && objLayer.p_uid!==-1 && u.getLayerByUniqueId(objLayer.p_uid).length>0) {				
				var p_objLayer = u.getLayerByUniqueId(objLayer.p_uid);			
				timedif = (fl*10) - p_objLayer.frames["frame_0"].time;
			} else
			if (fi!==0) {
				var prevframe = fi===999 ? objLayer.frames["frame_"+(frameslength-2)] : objLayer.frames["frame_"+(fi-1)];	
				if (prevframe)					
					timedif = (fl*10) - (prevframe.time + prevframe.speed + (prevframe.split_extratime*10));
			}
			
			if (t.timelinetype==="absolute") 
				_tc.timecont.innerHTML = fl*10;
			else 
				_tc.timecont.innerHTML = timedif;
		}

		if (fi!==999 && t.timelinetype!=="absolute") {
			var nextframe = objLayer.frames["frame_"+nframei];
			nextframe.time_relative = nextframe.time - (currentframe.time+(currentframe.split_extratime*10)+currentframe.speed);
			nframe.find('.timebefore_cont').html(nextframe.time_relative);
		}
		
		if (ui!==undefined && ui!==false) ui.position.left = fl;

		
		punchgs.TweenLite.set(frame,{left:fl});

		// Check if more than one Layer selected, and move all Layer parallel to the Master layer				
		if ((u.selectedLayers.length>0 && !ignorerecursive) || (u.currentGroupElements!=undefined && u.currentGroupElements.length>0 && !ignorerecursive)) {
			var dragdif = fl - (objLayer.positionLeftReset);						
			for (var sfi=0;sfi<=u.selectedLayers.length-1;sfi++) {				
				var _pid = u.selectedLayers[sfi];													
				if (_pid != objLayer.unique_id) {					
					var _pel = document.getElementById('tl_'+_pid+'_frame_'+fi);								
					_pel.style.left = (u.selectedLayersPositionLeftReset[sfi] + dragdif)+"px"; 
					t.updateFullTime(u.getLayerByUniqueId(_pid),(u.selectedLayersPositionLeftReset[sfi] + dragdif));				
				}
			}

			if (fi===0 && u.currentGroupElements!==undefined && u.currentGroupElements.length>0)
				for (var sfi=0;sfi<=u.currentGroupElements.length-1;sfi++) {
					var _pid = u.currentGroupElements[sfi];
																	
					if (_pid != objLayer.unique_id) {					
						var _pel = document.getElementById('tl_'+_pid+'_frame_'+fi);																			
						_pel.style.left = (u.currentGroupElementsPositionLeftReset[sfi] + dragdif)+"px";
						t.updateFullTime(u.getLayerByUniqueId(_pid),(u.currentGroupElementsPositionLeftReset[sfi] + dragdif) );
					}
				}
		}	


		t.updateFullTime(objLayer);
		checkTillSlideEnd(objLayer);
	}

	t.updateFullTime = function(objLayer,left) {
		var fullcont = objLayer.references.sorttable.timeline[0].getElementsByClassName('timeline_full')[0],
			audio = jQuery(objLayer.references.sorttable.timeline[0]).find('.timeline_audio'),
			left = left === undefined ? 15+(objLayer.frames["frame_0"].time/10) : left+15,
			newtime = (left - 15) * 10;				
		punchgs.TweenLite.set(fullcont,{left:left, width:((objLayer.frames["frame_999"].time - newtime) + objLayer.frames["frame_999"].split_extratime + objLayer.frames["frame_999"].speed)/10});
		if (audio!==undefined && audio.length>0)		
			punchgs.TweenLite.set(audio,{left:left, width:((objLayer.frames["frame_999"].time - newtime) + objLayer.frames["frame_999"].split_extratime + objLayer.frames["frame_999"].speed)/10});
		
	}
	t.updateLayerTimeline = function(objLayer) {
		var tf = objLayer.references.sorttable.timeline[0].getElementsByClassName('timeline_frame');
			for (var i=0;i<tf.length;i++) { 
			t.setTLFrame(tf[i]);
			t.updateTLFrame(tf[i],false,true);
		}
	}

	t.updateCurrentLayerTimeline = function() {								
		var el = document.getElementById('layer_sort_time_'+u.getCurrentLayer().serial),
			tf = el.getElementsByClassName('timeline_frame');		
  		for (var i=0;i<tf.length;i++) { 
			t.setTLFrame(tf[i],false,true);
		}
	};

	t.updateAllLayerTimeline = function() {
		var tf = document.getElementsByClassName('timeline_frame tl_layer_frame');		
  		for (var i=0;i<tf.length;i++) { 
  			
			t.updateTLFrame(tf[i],false,true);
			
		}
	}

	t.updateAllSelectedLayerTimeline = function(frame) {
		var frame=jQuery(frame),
			frameid = frame.data('uniqueid'),
			fi = frame.data('frameindex');
		if (u.selectedLayers.length>0) 						
			for (var i=0;i<=u.selectedLayers.length-1;i++) {
				var _pid = u.selectedLayers[i];													
				if (_pid != frameid) 
					t.updateTLFrame(document.getElementById('tl_'+_pid+'_frame_'+fi),false,true);
			}
		if (fi===0 && u.currentGroupElements!==undefined && u.currentGroupElements.length>0)
			for (var i=0;i<=u.currentGroupElements.length-1;i++) {
				var _pid = u.currentGroupElements[i];															
				if (_pid != frameid)
					t.updateTLFrame(document.getElementById('tl_'+_pid+'_frame_'+fi),false,true);									
			}
	}


	t.showTimeLineDirectInput = function(objLayer) {
		// SET CURRENT TIMING HELPERS
		jQuery('#clayer_start_time').val(objLayer.time);
		jQuery('#clayer_start_speed').val(objLayer.speed);
	}

	t.manageTimeLineDirectInput = function() {
		jQuery('#clayer_start_time, #clayer_end_time').on("change blur", function() {
			var objLayer = t.getLayer(selectedLayerSerial);
			
			objLayer.time = jQuery('#clayer_start_time').val();
			objLayer.frames["frame_999"].time = jQuery('#clayer_end_time').val();
			objLayer.speed = jQuery('#clayer_start_speed').val();
			objLayer.frames["frame_999"].speed = jQuery('#clayer_end_speed').val();
			
			jQuery('#layer_speed').val(objLayer.speed);
			jQuery('#layer_endspeed').val(objLayer.frames["frame_999"].speed);
			t.updateLayerFromFields();
			u.updateCurrentLayerTimeline();
		});
	}


	/**
		CALCULATE WIDTH TO TIME
	*/
	var msToSec = function(ms) {
		var s = Math.floor(ms / 1000);
		ms = ms - (s*1000);
		var str = s+".";
		if (ms<100)
			str=str+"0";
		str = str+Math.round(ms/10);
		return str;
	}

	// COUNT THE AMOUNT OF CHARS, WORDS, LINES IN A TEXT
	var getSplitCounts = function(txt,split,splitdelay) {
		
		if (txt==undefined) return 0;
		var splitted = new Object();
			ht = jQuery('<div>'+txt+'</div>'),
			w = 1;

		splitted.c = ht.text().replace(/ /g, "").length;
		splitted.w = txt.split(" ").length;
		splitted.l = txt.split('<br').length;


		switch (split) {
			case "chars":
				w = splitted.c;
			break;
			case "words":
				w = splitted.w;
			break;
			case "lines":
				w = splitted.l;
			break;
		}

		
		return (w -1) * splitdelay;
	}


	/**
		Show / HIde The Timelines
	*/
	var showHideTimeines = function() {
		/* HIDE / SHOW  TIMELINES */

		jQuery('#button_sort_timing').click(function() {
			var bst = jQuery(this);
			if (bst.hasClass("off")) {
				bst.removeClass("off");
				bst.find('.onoff').html('- on');
				punchgs.TweenLite.to(jQuery('.sortlist .timeline'),0.5,{autoAlpha:0.5,overwrite:"auto"});
			} else {
				punchgs.TweenLite.to(jQuery('.sortlist .timeline'),0.5,{autoAlpha:0,overwrite:"auto"});
				bst.addClass("off");
				bst.find('.onoff').html('- off');
			}
		})
	}


	/**
	 *
	 * delete layer from sortbox
	 */
	t.deleteLayerFromSortbox = function(serial){

		var sortboxLayer = t.getHtmlSortItemFromSerial(serial),
			sortboxTimeLayer = t.getHtmlSortTimeItemFromSerial(serial),
			quickItem = t.getHtmlQuickTimeItemFromSerial(serial);
		try{
			sortboxLayer.remove();
			sortboxTimeLayer.remove();
			quickItem.remove();
		} catch(e) {

		}

		if (jQuery('.quick-layers-list li').length<2) jQuery('.nolayersavailable').show();

	}

	/**
	 *
	 * unselect all items in sortbox
	 */
	t.unselectSortboxItems = function(){

		jQuery(".sortlist li,#layers-right li, .quick-layers-list li").removeClass("ui-state-hover").addClass("ui-state-default");

	}

	/**
	 * Organise groups and objects *
     * This will move one Single Layer into its Group / Row / Column * 
	*/
	
	t.organiseGroupsAndLayer = function(editorupdate,demo,ignore_timelines) {	

		var _A_ = demo ? u.arrLayersDemo : u.arrLayers,		
			sortchanged = false;		
		
		for (var i in _A_) {
		    var objLayer = _A_[i];				    
		    
		    
			if (objLayer.type!="group" && objLayer.type!="row" && objLayer.p_uid!=undefined && objLayer.p_uid!=-1) {					
				
				var sortelement = demo ? null : objLayer.references.sorttable.layer,
					j_gpel = u.getLayerByUniqueId(objLayer.p_uid),
					groupelement =  !demo && j_gpel ? j_gpel.references.sorttable.layer[0].getElementsByClassName("sgw_def")[0] : undefined,
					htmllayer = objLayer.references.htmlLayer,
					grouplayer = j_gpel ? j_gpel.references.htmlLayer : undefined;
				
				
				if (grouplayer && htmllayer && !grouplayer[0].contains(htmllayer[0])) {
					
					var g = grouplayer[0].getElementsByClassName('tp_layer_group_inner_wrapper')[0];					
					
					if (objLayer.type!=="column") {
						var noelement = true,
							so = 99999,
							ib;						
						for (var j in _A_) {
							var objComp = _A_[j];							
							if (objLayer.p_uid === objComp.p_uid && objComp.references.htmlLayer!==undefined && objComp.groupOrder!==undefined && objComp.groupOrder > objLayer.groupOrder && objComp.groupOrder<so) {
								so = objComp.groupOrder;
								noelement = false;
								ib = objComp.references.htmlLayer;					
							}
						}
						if (ib!==undefined && so<99999) {							
							if (ib[0].parentNode == g)
								g.insertBefore(htmllayer[0],ib[0]); 
							else
								g.appendChild(htmllayer[0])
						}
						else
							g.appendChild(htmllayer[0]);
					} else {				
						//console.log("Add Column with ID:"+objLayer.unique_id+"  into Group:"+objLayer.p_uid);
						g.appendChild(htmllayer[0])
					}
					
				} 
			
										
				
				if (!demo && !editorupdate && groupelement!==undefined && !groupelement.contains(sortelement[0])) {					
					sortchanged = true;
					groupelement.appendChild(sortelement[0]);					
				}

				
				if (!demo && groupelement===undefined && objLayer.type==="column") u.deleteLayer(objLayer.serial);	
			} else {
				objLayer.p_uid = -1;
				var htmllayer = objLayer.references.htmlLayer,
					sortelement = demo ? null : objLayer.references.sorttable.layer;

			 
				if (objLayer.type==="row") {	
					
					// PUT IN THE RIGHT ORDER THE ROW IN TO THE ZONE	
					var _zone = "row-zone-"+u.getVal(objLayer, 'align_vert'),													
						_znoelement = true,
						_zso = 99999,
						_zib,
						_zg = document.getElementById(_zone);
					
					//if (htmllayer[0].parentNode.id===_zone) return false;
					
					for (var _j in _A_) {
						var objComp = _A_[_j];
						
						
						if (objComp.type==="row" && objComp.unique_id !== objLayer.unique_id && u.getVal(objLayer, 'align_vert') === u.getVal(objComp, 'align_vert') && objComp.references.htmlLayer!==undefined && objComp.groupOrder!==undefined && objComp.groupOrder >= objLayer.groupOrder && objComp.groupOrder<_zso) {
						
							_zso = objComp.groupOrder;
							_znoelement = false;
							_zib = objComp.references.htmlLayer;					
						}
					}
					
					if (_zib!==undefined && _zso<99999) {							
						if (_zib[0].parentNode == _zg)
							_zg.insertBefore(htmllayer[0],_zib[0]); 
						else
							_zg.appendChild(htmllayer[0])
					}
					else
						_zg.appendChild(htmllayer[0]);
					u.checkRowZoneContents();
				} else {
					if (htmllayer[0].parentNode.id!='divLayers') document.getElementById("divLayers").appendChild(htmllayer[0]);
				}
				
				
				if (!demo && sortelement[0].parentNode.id!='layers-left-ul') {					
					document.getElementById('layers-left-ul').insertBefore(sortelement[0],document.getElementById("last_drop_zone_layers"));
					sortchanged = true;
				}
			}
		}
		
		u.setMiddleRowZone();
		
		if (sortchanged) t.updateOrderFromSortbox(ignore_timelines);
		
	}


	/**
	 * update layers order from sortbox elements
	 */
	t.updateOrderFromSortbox = function(ignore_timelines){
		
		// RESET GROUP AND COLUMN REFERENCES			
		for (i in u.arrLayers) {
			var objLayer = u.arrLayers[i];
			if (objLayer.type!="column" && objLayer.type != "row" && objLayer.type != "group") {
				
				var _t = objLayer.references.sorttable.layer,					
					cc = _t[0].parentNode.parentNode.classList.contains("sortable_column"),
					gg = _t[0].parentNode.parentNode.classList.contains("sortable_group"),					
					uqid = -1; 			
								
				if ((!cc && !gg) || _t[0].parentNode.parentNode.id == "layers-left-ul") {						
					// IGNORE ITEM HERE
				} else {
					var c = jQuery(_t[0].parentNode.parentNode);							
					if (!cc) {	
						
						_t.data('pid',c.data('uniqueid'));
						var gtype = c.data('type');
						
						if (gtype==="row") {
							
							c = _t.prev();
							if (c.length==0) c = _t.next();
							
							c[0].getElementsByClassName("sortable_layers_in_columns")[0].appendChild(_t[0]);							
						} else {
							//c[0].getElementsByClassName("sortable_groups_wrap")[0].appendChild(_t[0]);							
						}
					}	
					uqid = 	c.data('uniqueid');			
				}
				_t.data('pid',uqid);	
				_t.attr('pid',uqid);							
				
				if (objLayer.p_uid != uqid) {				
					objLayer.p_uid = uqid;				
					u.add_layer_change();
				}
			}
		}	
		

		var arrSortLayers = jQuery( "#layers-left-ul" ).sortable("toArray",{attribute:"data-uniqueid"});
		
		for(var i=0;i<arrSortLayers.length;i++){
			var objLayer = u.getLayerByUniqueId(arrSortLayers[i]),
				depth = i+5,				
				objUpdate = {order:i,zIndex:depth};
						
			u.arrLayers[objLayer.serial].order = i;
			u.arrLayers[objLayer.serial].zIndex = depth;
						
			//update sortbox order input
			
			
			
			if (objLayer.references.sorttable.layer[0].getElementsByClassName("sortbox_depth")[0])
				objLayer.references.sorttable.layer[0].getElementsByClassName("sortbox_depth")[0].innerHTML = depth;

			

			document.getElementById("layers-right-ul").appendChild(objLayer.references.sorttable.timeline[0]);

			document.getElementById('quick-layers-list-id').appendChild(objLayer.references.quicklayer[0]);
			
			if (objLayer.p_uid!=-1 && objLayer.p_uid!==undefined && objLayer.type!=="row" && objLayer.type!=="group") 
				objLayer.references.quicklayer.addClass("quick_in_group")
			else
				objLayer.references.quicklayer.removeClass("quick_in_group")

		}
		
		//update z-index of the html window by order
				
		t.updateZIndexByOrder();
		
		
		if (ignore_timelines!=true) t.updateAllLayerTimeline();
		
	}


	t.resetTimeLineHeight = function() {
		// SET HEIGHT OF MASTERTIMER
		var maxh = document.getElementById('layers-right-ul').clientHeight;		
		punchgs.TweenLite.set(jQuery('#mastertimer-position'),{height:maxh+40});						
	}


	t.timeLineTableDimensionUpdate = function() {		
		clearTimeout(timeline_timer);		
		timeline_timer = setTimeout(function() {		
			t.resetTimeLineHeight();	
			var maxh = ((jQuery('#layers-right ul li').length+1)*30) - ((jQuery('#layers-right ul li.layer-deleted').length+1)*30);
			
			punchgs.TweenLite.set(jQuery('.layers-wrapper'),{height:maxh+3});
			punchgs.TweenLite.set(jQuery('#mastertimer-wrapper'),{height:maxh+3})
			jQuery('.master-rightcell .layers-wrapper, .master-leftcell .layers-wrapper, #divLayers-wrapper, .quick-layers-list').perfectScrollbar("update");
		},50);
	}

	/**
	 * update z-index of the layers by order value
	 */
	t.updateZIndexByOrder = function(){
		
		for (var i in u.arrLayers) {
			var objLayer = u.arrLayers[i],
				depth = objLayer.order!==undefined ? objLayer.order+5 : 5,
				objUpdate = {zIndex:depth};

			if (objLayer.order !==undefined)
				punchgs.TweenLite.set(objLayer.references.htmlLayer,{zIndex:(Number(objLayer.order)+100)});

			u.updateLayer(objLayer.serial,objUpdate,false,true);			
		}

	}

	/**
	 * shift order among all the layers, push down all order num beyong the given
	 * need to redraw after this function
	 */
	var shiftOrder = function(orderToFree){

		for(key in u.arrLayers){
			var obj = u.arrLayers[key];
			if(obj.order >= orderToFree){
				obj.order = Number(obj.order)+1;
				u.arrLayers[key] = obj;
			}
		}
	}


	/**
	 * get sortbox text from layer html
	 */
	t.getSortboxText = function(text){
		sorboxTextSize = 20;
		var textSortbox = UniteAdminRev.stripTags(text);

		//if no content - escape html
		if(textSortbox.length < 2)
			textSortbox = UniteAdminRev.htmlspecialchars(text);

		//short text
		if(textSortbox.length > sorboxTextSize)
			textSortbox = textSortbox.slice(0,sorboxTextSize)+"...";

		return(textSortbox);
	}

	/**
	 *
	 * redraw the sortbox
	 */
	t.redrawSortbox = function(mode){


		if(mode == undefined)
			mode = sortMode;

		emptySortbox();

		var layers_array = getLayersSorted("depth");


		if(layers_array.length == 0) {
			return(false);
		}

		
		for(var i=0; i<layers_array.length;i++){
			var objLayer = layers_array[i];
			t.addToSortbox(objLayer.serial,objLayer);
		}

				

		if(u.selectedLayerSerial != -1)
			t.setSortboxItemSelected(u.selectedLayerSerial);





	}

	
	var reinitSortBox = function(sortable) {	

		jQuery('#last_drop_zone_layers').appendTo('#layers-left-ul');
		//set the sortlist sortable
		if (sortable) {
			jQuery('.layer_sortbox ul').sortable({
				axis:'y',	
				refreshPositions:true,
				placeholder:"silent-placeholder",
				cancel:"#slide_in_sort, input",
				handle:".mastertimer-timeline-zindex-row",
				items:".sortable_elements",				
				toleranceElement: '> div',						
				connectWith:"#layers-left-ul, .sortable_groups_wrap, .sortable_layers_in_columns",
				update: function(evnt,ui){

					var src = jQuery(ui.item);
					// CANCEL IF ELEMENT IS A ROW
					if (src.hasClass("sortable_row")) jQuery(this).sortable("cancel");
					
					// CANCEL CHANGE IF GROUP MOVED INTO OTHER GROUP
					
					var tg = src.parent(),
						mg = tg.closest('.sortable_group'),
						telement = jQuery('#layers-left-ul');
						
					if ((tg.hasClass("sortable_groups_wrap") || tg.hasClass("sortable_layers_in_columns")) && !src.hasClass("sortable_layers")) {
						
						if (src.index()<tg.children().length/2) 						
							src.insertBefore(mg);						
						else 							
							src.insertAfter(mg);																		
					} 		



					// PUT ITEM BEFORE OR AFTER ROWS IN CASE THE ROW 					
					if (tg.attr("id")==="layers-left-ul" || tg.parent().attr('id')==="layers-left-ul" || src.hasClass("sortable_group")) {
						var rows = telement.find('.sortable_row'),
							fr = rows.first().index(),
							lr = rows.last().index(),
							si = src.index();						
						if (si>fr && si<lr) 
							src.insertAfter(rows.last());					
					}										
					onSortboxSorted();	
					t.organiseGroupsAndLayer();								
				}
			});
		}

		

		jQuery('.droppable_sortable_group,.droppable_sortable_row, .droppable_sortable_column').droppable({
			tolerance:"intersect",
			greedy:true,	
			over:function(ui) {
				jQuery(ui.target).addClass("readytodrop")
			},
			out:function(ui) {
				jQuery(ui.target).removeClass("readytodrop")
			},
			drop:function(ui) {
				
				jQuery(ui.target).removeClass("readytodrop");
				var cl = jQuery(ui.target).attr('class'),
					src = jQuery(ui.srcElement).closest('.sortable_elements.sortable_layers'),
					tg;
								
				if (!src.length) return false;

				// ADD TO GROUP					
				if (cl.indexOf('droppable_sortable_group')>=0)					
					tg = jQuery(ui.target).closest('li.sortable_group').find('.sortable_groups_wrap');
				
				// ADD TO FIRST COLUMN IN ROW					
				if (cl.indexOf('droppable_sortable_row')>=0)
					tg = jQuery(ui.target).closest('li.sortable_group.sortable_row').find('.sortable_layers_in_columns').first();
				
				// ADD TO COLUMN
				if (cl.indexOf('droppable_sortable_column')>=0) 					
					tg = jQuery(ui.target).closest('li.sortable_column').find('.sortable_layers_in_columns').first();

				setTimeout(function(){
					src.appendTo(tg);
					onSortboxSorted();
					t.organiseGroupsAndLayer();	
				},50);
			}
		})
	}

	//======================================================
	//			Sortbox Functions
	//======================================================
	var initSortbox = function(){

		t.redrawSortbox();
		reinitSortBox(true);
		

		//set click event on full row
		jQuery("body").delegate(".layer_sort_inner_wrapper","mousedown",function(e){
			var li = jQuery(this).closest('.sortable_elements');

			if (li.hasClass("ui-state-hover")) return true;
			if (!li.hasClass("mastertimer-slide")) {				
				var serial = u.getSerialFromSortID(li.attr('id'));
				u.setLayerSelected(serial);
				return false;
			}
			
		});

		//set click event on collapser
		jQuery("body").on("click",".sort_group_collapser",function(e){
			
			var t = jQuery(this),
				c = t.closest('.sortable_column'),
				g = c.length ? c  : t.closest('.sortable_group'),
				cenv = c.length? g.find('.sortable_layers_in_columns') : g.find('.sortable_groups_wrap');
			
			t.toggleClass("collapsed");			
			if (t.hasClass("collapsed"))									
				cenv.css({maxHeight:"0px", overflow:"hidden"});
			else
				cenv.css({maxHeight:"none", overflow:"visible"});
					
			cenv.find('.sortable_elements').each(function(i,a) {				
				var a = jQuery(a),
					uid = a.data('uniqueid');
				
				if (t.hasClass("collapsed"))
					jQuery('#layers-right-ul li[data-uniqueid="'+uid+'"]').addClass("unvisibletimeline");
				else
					jQuery('#layers-right-ul li[data-uniqueid="'+uid+'"]').removeClass("unvisibletimeline");
			});							
		});

		//set click event on timelines
		jQuery("#layers-right").delegate("li","mousedown",function(e){
			var li = jQuery(this);
			t.recordFrameStatusForce = true;
			if (li.hasClass("ui-state-hover")) return true;
			if (!li.hasClass("mastertimer-slide")) {				
				var serial = u.getSerialFromSortID(this.id);
				u.setLayerSelected(serial);
				return false;
			}			
		});


		jQuery('.quick-layer-all-lock').click(function() {
			var b = jQuery(this),
				i = b.find('i');
			if (i.hasClass("eg-icon-lock")) {
				jQuery('.quick-layer-lock i').each(function() {
					jQuery(this).removeClass("eg-icon-lock-open").addClass("eg-icon-lock");
				});
				i.addClass("eg-icon-lock-open").removeClass("eg-icon-lock");
				u.lockAllLayers();
			} else {
				jQuery('.quick-layer-lock i').each(function() {
					jQuery(this).removeClass("eg-icon-lock").addClass("eg-icon-lock-open");
				});
				i.removeClass("eg-icon-lock-open").addClass("eg-icon-lock");
				
				u.unlockAllLayers();
			}
		})

		jQuery('.quick-layer-all-view').click(function() {
			var b = jQuery(this),
				i = b.find('i');
			if (i.hasClass("eg-icon-eye")) {
				jQuery('.quick-layer-view i').each(function() {
					jQuery(this).addClass("eg-icon-eye").removeClass("eg-icon-eye-off");
				});
				i.removeClass("eg-icon-eye").addClass("eg-icon-eye-off");				
				u.showAllLayers();
			} else {
				jQuery('.quick-layer-view i').each(function() {
					jQuery(this).removeClass("eg-icon-eye").addClass("eg-icon-eye-off");
				});
				i.addClass("eg-icon-eye").removeClass("eg-icon-eye-off");
				u.hideAllLayers();
			}
		})



		//on show / hide layer icon click - show / hide layer
		jQuery(".sortlist").delegate(".till_slideend","mousedown",function(event){
			var button = jQuery(this),
				li = button.closest('li'),
				serial = button.data('serial'),
				objLayer = u.getLayer(serial),				
				maxtime = (t.mainMaxTimeLeft)*10;

			if (li.hasClass("tillendon")) {
				li.removeClass("tillendon")
				objLayer.frames["frame_999"].time = objLayer.frames["frame_999"].time-200;
				t.updateLayerTimeline(objLayer);				
			} else {
				li.addClass("tillendon");
				objLayer.frames["frame_999"].time =  maxtime;				
				t.updateLayerTimeline(objLayer);
			}

		});

	}




	/***********************************
		order layers by time
		type can be [time] or [order]
	************************************/
	var getLayersSorted = function(type){

		if(type == undefined)
			type = "time";

		//convert to array
		var layers_array = [];
		for(key in u.arrLayers){
			var obj = u.arrLayers[key];
			obj.serial = key;
			layers_array.push(obj);
		}

		if(layers_array.length == 0)
			return(layers_array);

		//sort layers array
		layers_array.sort(function(layer1,layer2){

			switch(type){
				case "time":

					if(Number(layer1.time) == Number(layer2.time)){
						if(layer1.order == layer2.order)
							return(0);

						if(layer1.order > layer2.order)
							return(1);

						return(-1);
					}

					if(Number(layer1.time) > Number(layer2.time))
						return(1);
				break;
				case "depth":
					if(layer1.order == layer2.order)
						return(0);

					if(layer1.order > layer2.order)
						return(1);
				break;
				default:
					trace("wrong sort type: "+type);
				break;
			}

			return(-1);
		});

		return(layers_array);
	}


	/**
	 * hide in html and sortbox
	 */
	t.hideLayer = function(objLayer,skipGlobalButton){		
		if (objLayer.references===undefined || objLayer.references.htmlLayer===undefined) return;
		var htmlLayer = objLayer.references.htmlLayer;
		
		htmlLayer.css({visibility:"hidden"});
		htmlLayer.addClass("currently_not_visible");
		if (!objLayer.isDemo)
			setSortboxItemHidden(objLayer.serial);
		
		if(skipGlobalButton != true){
			if(t.isAllLayersHidden())
				jQuery("#button_sort_visibility").addClass("e-disabled");
		}
	}


	/**
	 * show layer in html and sortbox
	 */
	t.showLayer = function(objLayer,skipGlobalButton){		
		if (objLayer.references===undefined || objLayer.references.htmlLayer===undefined) return;
		var htmlLayer = objLayer.references.htmlLayer;
		htmlLayer.css({visibility:"visible"});
		htmlLayer.removeClass("currently_not_visible");
		if (!objLayer.isDemo)
			setSortboxItemVisible(objLayer.serial);

		if(skipGlobalButton != true)
			jQuery("#button_sort_visibility").removeClass("e-disabled");
	}


	

	


	/**
	 * get true / false if the layer is hidden
	 */
	t.isLayerVisible = function(htmlLayer){
		var isVisible = true;
		
		if (htmlLayer!=undefined && htmlLayer[0].classList.contains("currently_not_visible"))
			isVisible = false;		
			
		return(isVisible);
	}

	/**
	 * get true / false if all layers hidden
	 */
	t.isAllLayersHidden = function(){
		var i=0;
		for(serial in u.arrLayers){			
			if(u.arrLayers[i]!==undefined && t.isLayerVisible(u.arrLayers[i].references.htmlLayer) == true) return(false);			
			i++;
		}
		return(true);
	}


	/**
	 * get true / false if the layer can be moved
	 */
	t.isLayerLocked = function(htmllayer){		
		return htmllayer.hasClass("layer_on_lock");
	}


	/**
	 * hide in html and sortbox
	 */
	t.lockLayer = function(serial){
		setSortboxItemLocked(serial);

		var layer = u.getHtmlLayerFromSerial(serial);


		layer.addClass("layer_on_lock");
	
	}


	/**
	 * show layer in html and sortbox
	 */
	t.unlockLayer = function(serial){
		setSortboxItemUnlocked(serial);
		var layer = u.getHtmlLayerFromSerial(serial);		
		layer.removeClass("layer_on_lock");
	}


	/**
	 * set sortbox items selected
	 */
	t.setSortboxItemSelected = function(serial){

		var sortItem = t.getHtmlSortItemFromSerial(serial),
			sortTimeItem = t.getHtmlSortTimeItemFromSerial(serial),
			quickItem = t.getHtmlQuickTimeItemFromSerial(serial);
		
		t.unselectSortboxItems();
		if (sortItem)
			sortItem.removeClass("ui-state-default").addClass("ui-state-hover");
		if (sortTimeItem)
			sortTimeItem.removeClass("ui-state-default").addClass("ui-state-hover");
		if (quickItem)
			quickItem.removeClass("ui-state-default").addClass("ui-state-hover");
	}


	/**
	 * set sortbox item hidden mode
	 */
	var setSortboxItemHidden = function(serial){
		var sortItem = t.getHtmlSortItemFromSerial(serial),
			sortTimeItem = t.getHtmlSortTimeItemFromSerial(serial),
			quickItem = t.getHtmlQuickTimeItemFromSerial(serial);

		if (sortItem)
			sortItem.addClass("sortitem-hidden");
		if (sortTimeItem)
			sortTimeItem.addClass("sortitem-hidden");
		if (quickItem) {
			quickItem.addClass("sortitem-hidden");
			quickItem.find('.eg-icon-eye').addClass("eg-icon-eye-off").removeClass('eg-icon-eye');
			quickItem.find('.quick-layer-view').addClass("in-off");
		}
	}

	/**
	 * set sortbox item visible mode
	 */
	var setSortboxItemVisible = function(serial){
		var sortItem = t.getHtmlSortItemFromSerial(serial),
			sortTimeItem = t.getHtmlSortTimeItemFromSerial(serial),
			quickItem = t.getHtmlQuickTimeItemFromSerial(serial);
		if (sortItem)
			sortItem.removeClass("sortitem-hidden");
		if (sortTimeItem)
			sortTimeItem.removeClass("sortitem-hidden");
		if (quickItem) 
			quickItem.removeClass("sortitem-hidden");
	}

	/**
	 * set sortbox item locked mode
	 */
	var setSortboxItemLocked = function(serial){
		var sortItem = t.getHtmlSortItemFromSerial(serial),
			sortTimeItem = t.getHtmlSortTimeItemFromSerial(serial),
			quickItem = t.getHtmlQuickTimeItemFromSerial(serial);
		
		if (sortItem)
			sortItem.addClass("sortitem-locked");
		if (sortTimeItem)
			sortTimeItem.addClass("sortitem-locked");
		if (quickItem)
			quickItem.addClass("sortitem-locked");
	}

	/**
	 * set sortbox item unlocked mode
	 */
	var setSortboxItemUnlocked = function(serial){
		var sortItem = t.getHtmlSortItemFromSerial(serial),
			sortTimeItem = t.getHtmlSortTimeItemFromSerial(serial),
			quickItem = t.getHtmlQuickTimeItemFromSerial(serial);
		
		if (sortItem)
			sortItem.removeClass("sortitem-locked");
		if (sortTimeItem)
			sortTimeItem.removeClass("sortitem-locked");
		if (quickItem)
			quickItem.removeClass("sortitem-locked");
	}

	/**
	 * get sort field element from serial
	 */
	t.getHtmlSortItemFromSerial = function(serial){
		var htmlSortItem = jQuery("#layer_sort_"+serial);
		if(htmlSortItem.length == 0){
			UniteAdminRev.showErrorMessage("Html sort field with serial: "+serial+" not found!");
			return(false);
		}
		return(htmlSortItem);
	}

	t.getHtmlSortTimeItemFromSerial = function(serial){
		var htmlSortItem = jQuery("#layer_sort_time_"+serial);
		if(htmlSortItem.length == 0){
			UniteAdminRev.showErrorMessage("Html sort field with serial: "+serial+" not found!");
			return(false);
		}
		return(htmlSortItem);
	}

	t.getHtmlQuickTimeItemFromSerial = function(serial){
		var htmlSortItem = jQuery("#layer_quicksort_"+serial);
		if(htmlSortItem.length == 0){
			UniteAdminRev.showErrorMessage("Html sort field with serial: "+serial+" not found!");
			return(false);
		}
		return(htmlSortItem);
	}



	/**
	 * remove all from sortbox
	 */
	var emptySortbox = function(){
		jQuery(".sortlist ul").find('.sortable_elements').remove();
		jQuery('#layers-right ul').find('.sortable_elements').remove();
	}


	/**
	 * on sortbox sorted event.
	 */
	var onSortboxSorted = function(){
		
		t.updateOrderFromSortbox();
	}
	//======================================================
	//			Sortbox Functions End
	//======================================================
	
	
	
	///////////////////////
	// PREPARE THE SLIDE //
	//////////////////////
	var prepareOneSlide = function(slotholder,opt,visible,vorh,w,h) {

				var sh=slotholder,
					img = sh.find('.defaultimg'),
					scalestart = sh.data('zoomstart'),
					rotatestart = sh.data('rotationstart'),
					src = sh.find('.defaultimg').css("backgroundImage"),
					bgcolor=sh.find('.defaultimg').css('backgroundColor'),
					off=0,
					bgfit = sh.find('.defaultimg').css("backgroundSize"),
					bgrepeat = sh.find('.defaultimg').css("backgroundRepeat"),
					bgposition = sh.find('.defaultimg').css("backgroundPosition");
				

				src=src.replace('"','');
				src=src.replace('"','');				


				if (bgfit==undefined) bgfit="cover";
				if (bgrepeat==undefined) bgrepeat="no-repeat";
				if (bgposition==undefined) bgposition="center center";
				

				var w= w !=undefined ? w : jQuery('#divbgholder').width(),
					h= h !=undefined ? h : jQuery('#divbgholder').height();
				opt.slotw=Math.ceil(w/opt.slots),
				opt.sloth=Math.ceil(h/opt.slots);
				
				// SET THE MINIMAL SIZE OF A BOX
				var basicsize = 0,
					x = 0,
					y = 0;

				if (opt.sloth>opt.slotw)
					basicsize=opt.sloth
				else
					basicsize=opt.slotw;

				opt.slotw = basicsize;
				opt.sloth = basicsize;
				

				var x=0,
					y=0,
					fulloff = 0,
					fullyoff = 0;
							
									
	
				switch (vorh) {
					// BOX ANIMATION PREPARING
					case "box":
						
						
						for (var j=0;j<opt.slots;j++) {

							y=0;
							for (var i=0;i<opt.slots;i++) 	{


								sh.append('<div class="slot" '+
										  'style="position:absolute;'+
													'top:'+(fullyoff+y)+'px;'+
													'left:'+(fulloff+x)+'px;'+
													'width:'+basicsize+'px;'+
													'height:'+basicsize+'px;'+
													'overflow:hidden;">'+

										  '<div class="slotslide" data-x="'+x+'" data-y="'+y+'" '+
										  			'style="position:absolute;'+
													'top:'+(0)+'px;'+
													'left:'+(0)+'px;'+
													'width:'+basicsize+'px;'+
													'height:'+basicsize+'px;'+
													'overflow:hidden;">'+

										  '<div class="slotslidebg" style="position:absolute;'+
													'top:'+(0-y)+'px;'+
													'left:'+(0-x)+'px;'+
													'width:'+w+'px;'+
													'height:'+h+'px;'+
													'background-color:'+bgcolor+';'+
													'background-image:'+src+';'+
													'background-repeat:'+bgrepeat+';'+
													'background-size:'+bgfit+';background-position:'+bgposition+';">'+
										  '</div></div></div>');
								y=y+basicsize;								
							}
							x=x+basicsize;
						}
					break;

					// SLOT ANIMATION PREPARING
					case "vertical":
					case "horizontal":		
					
				
						 if (vorh == "horizontal") {
							if (!visible) var off=0-opt.slotw;
																											
							for (var i=0;i<opt.slots;i++) {
									
									sh.append('<div class="slot" style="position:absolute;'+
																	'top:'+(0+fullyoff)+'px;'+
																	'left:'+(fulloff+(i*opt.slotw))+'px;'+
																	'overflow:hidden;width:'+(opt.slotw+0.6)+'px;'+
																	'height:'+h+'px">'+
									'<div class="slotslide" style="position:absolute;'+
																	'top:0px;left:'+off+'px;'+
																	'width:'+(opt.slotw+0.6)+'px;'+
																	'height:'+h+'px;overflow:hidden;">'+
									'<div class="slotslidebg" style="background-color:'+bgcolor+';'+
																	'position:absolute;top:0px;'+
																	'left:'+(0-(i*opt.slotw))+'px;'+
																	'width:'+w+'px;height:'+h+'px;'+
																	'background-image:'+src+';'+
																	'background-repeat:'+bgrepeat+';'+
																	'background-size:'+bgfit+';background-position:'+bgposition+';">'+
									'</div></div></div>');									
							}

						} else {
							if (!visible) var off=0-opt.sloth;
						
							for (var i=0;i<opt.slots+2;i++) {
								sh.append('<div class="slot" style="position:absolute;'+
														 'top:'+(fullyoff+(i*opt.sloth))+'px;'+
														 'left:'+(fulloff)+'px;'+
														 'overflow:hidden;'+
														 'width:'+w+'px;'+
														 'height:'+(opt.sloth)+'px">'+

											 '<div class="slotslide" style="position:absolute;'+
																 'top:'+(off)+'px;'+
																 'left:0px;width:'+w+'px;'+
																 'height:'+opt.sloth+'px;'+
																 'overflow:hidden;">'+
											'<div class="slotslidebg" style="background-color:'+bgcolor+';'+
																	'position:absolute;'+
																	'top:'+(0-(i*opt.sloth))+'px;'+
																	'left:0px;'+
																	'width:'+w+'px;height:'+h+'px;'+
																	'background-image:'+src+';'+
																	'background-repeat:'+bgrepeat+';'+
																	'background-size:'+bgfit+';background-position:'+bgposition+';">'+

											'</div></div></div>');
							}
						}
					break;
				}
		}
		
		
		
	//////////////////////////////
	//	SWAP SLIDE PROGRESS		//
	//////////////////////////////
	var slideAnimation = function(nextsh,actsh,comingtransition,givebackmtl,smallpreview) {

		
			if (nextsh!=undefined) {
				var nextli = nextsh,
					actli = actsh,
					container = new Object(),					
					opt = new Object();
					opt.width = nextsh.width();
					opt.height = nextsh.height();
			} else {
				var nextsh = nextli = jQuery('#divbgholder').find('.slotholder'),
					actsh = actli = jQuery('#divbgholder').find('.oldslotholder'), 
					container = new Object(),
					comingtransition = jQuery('#fake-select-label').data('valu'),
					opt = new Object();
					opt.width = jQuery('#divbgholder').width();
					opt.height = jQuery('#divbgholder').height();

					
			}

			if (comingtransition=="slidingoverlayvertical") 
						comingtransition = "slidingoverlayup"	

			if (comingtransition=="slidingoverlayhorizontal") 
						comingtransition = "slidingoverlayleft"	
		
			if (comingtransition=="slideoverhorizontal") 
						comingtransition = "slideoverleft"
			
			if (comingtransition=="slideoververtical") 
						comingtransition = "slideoverup"

			if (comingtransition=="slideremovehorizontal") 
						comingtransition = "slideremoveleft"
			
			if (comingtransition=="slideremovevertical") 
						comingtransition = "slideremoveup"

			if (comingtransition=="slidehorizontal") 
						comingtransition = "slideleft"

			if (comingtransition=="slidevertical") 
						comingtransition = "slideup"

			if (comingtransition=="parallaxhorizontal") 
						comingtransition = "parallaxtoleft"


			if (comingtransition=="parallaxvertical") 
						comingtransition = "parallaxtotop"

			var p1i = punchgs.Power1.easeIn, 
				p1o = punchgs.Power1.easeOut,
				p1io = punchgs.Power1.easeInOut,
				p2i = punchgs.Power2.easeIn,
				p2o = punchgs.Power2.easeOut,
				p2io = punchgs.Power2.easeInOut,
				p3i = punchgs.Power3.easeIn, 
				p3o = punchgs.Power3.easeOut, 
				p3io = punchgs.Power3.easeInOut,
				flatTransitions = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45],
				premiumTransitions = [16,17,18,19,20,21,22,23,24,25,27],
				nexttrans =0,
				specials = 1,
				STAindex = 0,
				indexcounter =0,
				STA = new Array,
				transitionsArray = [['boxslide' , 0, 1, 10, 0,'box',false,null,0,p1o,p1o,500,6],
							 ['boxfade', 1, 0, 10, 0,'box',false,null,1,p1io,p1io,700,5],
							 ['slotslide-horizontal', 2, 0, 0, 200,'horizontal',true,false,2,p2io,p2io,700,3],
							 ['slotslide-vertical', 3, 0,0,200,'vertical',true,false,3,p2io,p2io,700,3],
							 ['curtain-1', 4, 3,0,0,'horizontal',true,true,4,p1o,p1o,300,5],
							 ['curtain-2', 5, 3,0,0,'horizontal',true,true,5,p1o,p1o,300,5],
							 ['curtain-3', 6, 3,25,0,'horizontal',true,true,6,p1o,p1o,300,5],
							 ['slotzoom-horizontal', 7, 0,0,400,'horizontal',true,true,7,p1o,p1o,300,7],
							 ['slotzoom-vertical', 8, 0,0,0,'vertical',true,true,8,p2o,p2o,500,8],
							 ['slotfade-horizontal', 9, 0,0,500,'horizontal',true,null,9,p2o,p2o,500,25],
							 ['slotfade-vertical', 10, 0,0 ,500,'vertical',true,null,10,p2o,p2o,500,25],
							 ['fade', 11, 0, 1 ,300,'horizontal',true,null,11,p2io,p2io,1000,1],
							 ['crossfade', 11, 1, 1 ,300,'horizontal',true,null,11,p2io,p2io,1000,1],
							 ['fadethroughdark', 11, 2, 1 ,300,'horizontal',true,null,11,p2io,p2io,1000,1],
							 ['fadethroughlight', 11, 3, 1 ,300,'horizontal',true,null,11,p2io,p2io,1000,1],
							 ['fadethroughtransparent', 11, 4, 1 ,300,'horizontal',true,null,11,p2io,p2io,1000,1],
							 ['slideleft', 12, 0,1,0,'horizontal',true,true,12,p3io,p3io,1000,1],
							 ['slideup', 13, 0,1,0,'horizontal',true,true,13,p3io,p3io,1000,1],
							 ['slidedown', 14, 0,1,0,'horizontal',true,true,14,p3io,p3io,1000,1],
							 ['slideright', 15, 0,1,0,'horizontal',true,true,15,p3io,p3io,1000,1],
							 ['slideoverleft', 12, 7,1,0,'horizontal',true,true,12,p3io,p3io,1000,1],
							 ['slideoverup', 13, 7,1,0,'horizontal',true,true,13,p3io,p3io,1000,1],
							 ['slideoverdown', 14, 7,1,0,'horizontal',true,true,14,p3io,p3io,1000,1],
							 ['slideoverright', 15, 7,1,0,'horizontal',true,true,15,p3io,p3io,1000,1],
							 ['slideremoveleft', 12, 8,1,0,'horizontal',true,true,12,p3io,p3io,1000,1],
							 ['slideremoveup', 13, 8,1,0,'horizontal',true,true,13,p3io,p3io,1000,1],
							 ['slideremovedown', 14, 8,1,0,'horizontal',true,true,14,p3io,p3io,1000,1],
							 ['slideremoveright', 15, 8,1,0,'horizontal',true,true,15,p3io,p3io,1000,1],
							 ['papercut', 16, 0,0,600,'',null,null,16,p3io,p3io,1000,2],
							 ['3dcurtain-horizontal', 17, 0,20,100,'vertical',false,true,17,p1io,p1io,500,7],
							 ['3dcurtain-vertical', 18, 0,10,100,'horizontal',false,true,18,p1io,p1io,500,5],
							 ['cubic', 19, 0,20,600,'horizontal',false,true,19,p3io,p3io,500,1],
							 ['cube',19,0,20,600,'horizontal',false,true,20,p3io,p3io,500,1],
							 ['flyin', 20, 0,4,600,'vertical',false,true,21,p3o,p3io,500,1],
							 ['turnoff', 21, 0,1,500,'horizontal',false,true,22,p3io,p3io,500,1],
							 ['incube', 22, 0,20,200,'horizontal',false,true,23,p2io,p2io,500,1],
							 ['cubic-horizontal', 23, 0,20,500,'vertical',false,true,24,p2o,p2o,500,1],
							 ['cube-horizontal', 23, 0,20,500,'vertical',false,true,25,p2o,p2o,500,1],
							 ['incube-horizontal', 24, 0,20,500,'vertical',false,true,26,p2io,p2io,500,1],
							 ['turnoff-vertical', 25, 0,1,200,'horizontal',false,true,27,p2io,p2io,500,1],
							 ['fadefromright', 12, 1,1,0,'horizontal',true,true,28,p2io,p2io,1000,1],
							 ['fadefromleft', 15, 1,1,0,'horizontal',true,true,29,p2io,p2io,1000,1],
							 ['fadefromtop', 14, 1,1,0,'horizontal',true,true,30,p2io,p2io,1000,1],
							 ['fadefrombottom', 13, 1,1,0,'horizontal',true,true,31,p2io,p2io,1000,1],
							 ['fadetoleftfadefromright', 12, 2,1,0,'horizontal',true,true,32,p2io,p2io,1000,1],
							 ['fadetorightfadefromleft', 15, 2,1,0,'horizontal',true,true,33,p2io,p2io,1000,1],
							 ['fadetobottomfadefromtop', 14, 2,1,0,'horizontal',true,true,34,p2io,p2io,1000,1],
							 ['fadetotopfadefrombottom', 13, 2,1,0,'horizontal',true,true,35,p2io,p2io,1000,1],
							 ['parallaxtoright', 12, 3,1,0,'horizontal',true,true,36,p2io,p2i,1500,1],
							 ['parallaxtoleft', 15, 3,1,0,'horizontal',true,true,37,p2io,p2i,1500,1],
							 ['parallaxtotop', 14, 3,1,0,'horizontal',true,true,38,p2io,p1i,1500,1],
							 ['parallaxtobottom', 13, 3,1,0,'horizontal',true,true,39,p2io,p1i,1500,1],
							 ['scaledownfromright', 12, 4,1,0,'horizontal',true,true,40,p2io,p2i,1000,1],
							 ['scaledownfromleft', 15, 4,1,0,'horizontal',true,true,41,p2io,p2i,1000,1],
							 ['scaledownfromtop', 14, 4,1,0,'horizontal',true,true,42,p2io,p2i,1000,1],
							 ['scaledownfrombottom', 13, 4,1,0,'horizontal',true,true,43,p2io,p2i,1000,1],
							 ['zoomout', 13, 5,1,0,'horizontal',true,true,44,p2io,p2i,1000,1],
							 ['zoomin', 13, 6,1,0,'horizontal',true,true,45,p2io,p2i,1000,1],
							 ['slidingoverlayup', 27, 0,1,0,'horizontal',true,true,47,p1io,p1o,2000,1],
							 ['slidingoverlaydown', 28, 0,1,0,'horizontal',true,true,48,p1io,p1o,2000,1],
							 ['slidingoverlayright', 30, 0,1,0,'horizontal',true,true,49,p1io,p1o,2000,1],
							 ['slidingoverlayleft', 29, 0,1,0,'horizontal',true,true,50,p1io,p1o,2000,1],
							 ['notransition',26,0,1,0,'horizontal',true,null,46,p2io,p2i,1000,1],							 
						   ];



			

			// RANDOM TRANSITIONS
			if (comingtransition == "random-selected" || comingtransition == "random" || comingtransition == "random-static" || comingtransition == "random-premium") 
				comingtransition = 11;				


			function findTransition() {
				// FIND THE RIGHT TRANSITION PARAMETERS HERE
				if (transitionsArray)
				jQuery.each(transitionsArray,function(inde,trans) {
					if (trans[0] == comingtransition || trans[8] == comingtransition) {
						nexttrans = trans[1];
						specials = trans[2];
						STAindex = indexcounter;
					}
					indexcounter = indexcounter+1;
				})
			}

			findTransition();

			var direction = -1,
				masterspeed = jQuery('#transition_duration').val();
				



			if (nexttrans>30) nexttrans = 30;
			if (nexttrans<0) nexttrans = 0;

			// PREPARED DEFAULT SETTINGS PER TRANSITION
			STA = transitionsArray[STAindex];


			///////////////////////////////
			//	MAIN TIMELINE DEFINITION //
			///////////////////////////////

			var mtl = new punchgs.TimelineLite();
						
			//SET DEFAULT IMG UNVISIBLE AT START
			mtl.add(punchgs.TweenLite.set(nextsh.find('.defaultimg'),{autoAlpha:0}));
			mtl.pause();

			mtl.add(punchgs.TweenLite.set(actsh,{autoAlpha:1,force3D:"auto",zIndex:0}),0);
			mtl.add(punchgs.TweenLite.set(nextsh,{autoAlpha:1,force3D:"auto",zIndex:1}),0);
			


			// ADJUST MASTERSPEED
			/*masterspeed = masterspeed + STA[4];

			if ((nexttrans==4 || nexttrans==5 || nexttrans==6) && opt.slots<3 ) opt.slots=3;

			// ADJUST SLOTS
			if (STA[3] != 0) opt.slots = Math.min(opt.slots,STA[3]);
			if (nexttrans==9) opt.slots = opt.width/20;
			if (nexttrans==10) opt.slots = opt.height/20;*/

			opt.slots = jQuery('#slot_amount').val();
			opt.rotate = jQuery('#transition_rotation').val();

			

			masterspeed = masterspeed==="default" ? STA[11] : masterspeed==="random" ? Math.round(Math.random()*1000+300) : masterspeed!=undefined ? parseInt(masterspeed,0) : STA[11];
			masterspeed = masterspeed > opt.delay ? opt.delay : masterspeed;

			// ADJUST MASTERSPEED
			masterspeed = masterspeed + STA[4];
			
			
			
			///////////////////////
			//	ADJUST SLOTS     //	
			///////////////////////
			
			opt.slots = opt.slots==undefined || opt.slots=="default" ? STA[12] : opt.slots=="random" ? Math.round(Math.random()*12+4) : STA[12];
			opt.slots = opt.slots < 1 ? comingtransition=="boxslide" ? Math.round(Math.random()*6+3) : comingtransition=="flyin" ? Math.round(Math.random()*4+1) : opt.slots : opt.slots;
			opt.slots = (nexttrans==4 || nexttrans==5 || nexttrans==6) && opt.slots<3 ? 3 : opt.slots;
			opt.slots = STA[3] != 0 ? Math.min(opt.slots,STA[3]) : opt.slots;
			opt.slots = nexttrans==9 ? opt.width/20 : nexttrans==10 ? opt.height/20 : opt.slots;
			

			/////////////////////////////////////////////
			//	SET THE ACTUAL AMOUNT OF SLIDES !!     //
			//  SET A RANDOM AMOUNT OF SLOTS          //
			///////////////////////////////////////////
			
			opt.rotate = opt.rotate==undefined || opt.rotate=="default" ? 0 : opt.rotate==999 || opt.rotate=="random" ? Math.round(Math.random()*360) : opt.rotate;
			opt.rotate = (!jQuery.support.transition  || opt.ie || opt.ie9) ? 0 : opt.rotate;
									
			
			opt.slotw=Math.ceil(opt.width/jQuery('#slot_amount').val()),
			opt.sloth=Math.ceil(opt.height/jQuery('#slot_amount').val());

			if (STA[7] !=null) prepareOneSlide(actsh,opt,STA[7],STA[5],opt.width,opt.height);
			if (STA[6] !=null) prepareOneSlide(nextsh,opt,STA[6],STA[5],opt.width,opt.height);			

			var ei= jQuery('select[name=transition_ease_in]').val(),
				eo =jQuery('select[name=transition_ease_out]').val(),
				slidedirection = 1;



			ei = ei==="default" ? STA[9] || punchgs.Power2.easeInOut : ei || STA[9] || punchgs.Power2.easeInOut;
			eo = eo==="default" ? STA[10] || punchgs.Power2.easeInOut : eo || STA[10] || punchgs.Power2.easeInOut;



	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==0) {								// BOXSLIDE


				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				var maxz = Math.ceil(opt.height/opt.sloth);
				var curz = 0;
				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);
					curz=curz+1;
					if (curz==maxz) curz=0;

					mtl.add(punchgs.TweenLite.from(ss,(masterspeed)/600,
										{opacity:0,top:(0-opt.sloth),left:(0-opt.slotw),rotation:opt.rotate,force3D:"auto",ease:ei}),((j*15) + ((curz)*30))/1500);
				});
	}
	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==1) {

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				var maxtime,
					maxj = 0;

				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this),
						rand=Math.random()*masterspeed+300,
						rand2=Math.random()*500+200;
					if (rand+rand2>maxtime) {
						maxtime = rand2+rand2;
						maxj = j;
					}
					mtl.add(punchgs.TweenLite.from(ss,rand/1000,
								{autoAlpha:0, force3D:"auto",rotation:opt.rotate,ease:ei}),rand2/1000);
				});
	}


	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==2) {

				var subtl = new punchgs.TimelineLite();
				// ALL OLD SLOTS SHOULD BE SLIDED TO THE RIGHT
				actsh.find('.slotslide').each(function() {
					var ss=jQuery(this);
					subtl.add(punchgs.TweenLite.to(ss,masterspeed/1000,{left:opt.slotw,ease:ei, force3D:"auto",rotation:(0-opt.rotate)}),0);
					mtl.add(subtl,0);
				});

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function() {
					var ss=jQuery(this);
					subtl.add(punchgs.TweenLite.from(ss,masterspeed/1000,{left:0-opt.slotw,ease:ei, force3D:"auto",rotation:opt.rotate}),0);
					mtl.add(subtl,0);
				});
	}



	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==3) {
				var subtl = new punchgs.TimelineLite();

				// ALL OLD SLOTS SHOULD BE SLIDED TO THE RIGHT
				actsh.find('.slotslide').each(function() {
					var ss=jQuery(this);
					subtl.add(punchgs.TweenLite.to(ss,masterspeed/1000,{top:opt.sloth,ease:ei,rotation:opt.rotate,force3D:"auto",transformPerspective:600}),0);
					mtl.add(subtl,0);

				});

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function() {
					var ss=jQuery(this);
					subtl.add(punchgs.TweenLite.from(ss,masterspeed/1000,{top:0-opt.sloth,rotation:opt.rotate,ease:eo,force3D:"auto",transformPerspective:600}),0);
					mtl.add(subtl,0);
				});
	}



	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==4 || nexttrans==5) {

				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);


				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				var cspeed = (masterspeed)/1000,
					ticker = cspeed,
					subtl = new punchgs.TimelineLite();

				actsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this);
					var del = (i*cspeed)/opt.slots;
					if (nexttrans==5) del = ((opt.slots-i-1)*cspeed)/(opt.slots)/1.5;
					subtl.add(punchgs.TweenLite.to(ss,cspeed*3,{transformPerspective:600,force3D:"auto",top:0+opt.height,opacity:0.5,rotation:opt.rotate,ease:ei,delay:del}),0);
					mtl.add(subtl,0);
				});

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this);
					var del = (i*cspeed)/opt.slots;
					if (nexttrans==5) del = ((opt.slots-i-1)*cspeed)/(opt.slots)/1.5;
					subtl.add(punchgs.TweenLite.from(ss,cspeed*3,
									{top:(0-opt.height),opacity:0.5,rotation:opt.rotate,force3D:"auto",ease:punchgs.eo,delay:del}),0);
					mtl.add(subtl,0);

				});


	}

	/////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION I.  //
	////////////////////////////////////
	if (nexttrans==6) {


				if (opt.slots<2) opt.slots=2;
				if (opt.slots % 2) opt.slots = opt.slots+1;

				var subtl = new punchgs.TimelineLite();

				//SET DEFAULT IMG UNVISIBLE
				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);

				actsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this);
					if (i+1<opt.slots/2)
						var tempo = (i+2)*90;
					else
						var tempo = (2+opt.slots-i)*90;

					subtl.add(punchgs.TweenLite.to(ss,(masterspeed+tempo)/1000,{top:0+opt.height,opacity:1,force3D:"auto",rotation:opt.rotate,ease:ei}),0);
					mtl.add(subtl,0);
				});

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this);

					if (i+1<opt.slots/2)
						var tempo = (i+2)*90;
					else
						var tempo = (2+opt.slots-i)*90;

					subtl.add(punchgs.TweenLite.from(ss,(masterspeed+tempo)/1000,
											{top:(0-opt.height),opacity:1,force3D:"auto",rotation:opt.rotate,ease:eo}),0);
					mtl.add(subtl,0);
				});
	}


	////////////////////////////////////
	// THE SLOTSZOOM - TRANSITION II. //
	////////////////////////////////////
	if (nexttrans==7) {

				masterspeed = masterspeed *2;
				if (masterspeed>opt.delay) masterspeed=opt.delay;
				var subtl = new punchgs.TimelineLite();

				//SET DEFAULT IMG UNVISIBLE
				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);

				// ALL OLD SLOTS SHOULD BE SLIDED TO THE RIGHT
				actsh.find('.slotslide').each(function() {
					var ss=jQuery(this).find('div');
					subtl.add(punchgs.TweenLite.to(ss,masterspeed/1000,{
							left:(0-opt.slotw/2)+'px',
							top:(0-opt.height/2)+'px',
							width:(opt.slotw*2)+"px",
							height:(opt.height*2)+"px",
							opacity:0,
							rotation:opt.rotate,
							force3D:"auto",
							ease:ei}),0);
					mtl.add(subtl,0);

				});

				//////////////////////////////////////////////////////////////
				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT //
				///////////////////////////////////////////////////////////////
				nextsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this).find('div');

					subtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
								{left:0,top:0,opacity:0,transformPerspective:600},
								{left:(0-i*opt.slotw)+'px',
								 ease:eo,
								 force3D:"auto",
							     top:(0)+'px',
							     width:opt.width,
							     height:opt.height,
								 opacity:1,rotation:0,
								 delay:0.1}),0);
					mtl.add(subtl,0);
				});
	}




	////////////////////////////////////
	// THE SLOTSZOOM - TRANSITION II. //
	////////////////////////////////////
	if (nexttrans==8) {

				masterspeed = masterspeed * 3;
				if (masterspeed>opt.delay) masterspeed=opt.delay;
				var subtl = new punchgs.TimelineLite();



				// ALL OLD SLOTS SHOULD BE SLIDED TO THE RIGHT
				actsh.find('.slotslide').each(function() {
					var ss=jQuery(this).find('div');
					subtl.add(punchgs.TweenLite.to(ss,masterspeed/1000,
								  {left:(0-opt.width/2)+'px',
								   top:(0-opt.sloth/2)+'px',
								   width:(opt.width*2)+"px",
								   height:(opt.sloth*2)+"px",
								   force3D:"auto",
								   ease:ei,
								   opacity:0,rotation:opt.rotate}),0);
					mtl.add(subtl,0);

				});


				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT //
				///////////////////////////////////////////////////////////////
				nextsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this).find('div');

					subtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
								  {left:0, top:0,opacity:0,force3D:"auto"},
								  {'left':(0)+'px',
								   'top':(0-i*opt.sloth)+'px',
								   'width':(nextsh.find('.defaultimg').data('neww'))+"px",
								   'height':(nextsh.find('.defaultimg').data('newh'))+"px",
								   opacity:1,
								   ease:eo,rotation:0,
								   }),0);
					mtl.add(subtl,0);
				});
	}


	////////////////////////////////////////
	// THE SLOTSFADE - TRANSITION III.   //
	//////////////////////////////////////
	if (nexttrans==9 || nexttrans==10) {
				var ssamount=0;
				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function(i) {
					var ss=jQuery(this);
					ssamount++;
					mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,{autoAlpha:0,force3D:"auto",transformPerspective:600},
																		 {autoAlpha:1,ease:ei,delay:(i*5)/1000}),0);

				});
	}

	///////////////////////////
	// SIMPLE FADE ANIMATION //
	///////////////////////////
	if (nexttrans==11 || nexttrans==26) {
				var ssamount=0,
					bgcol = specials == 2 ? "#000000" : specials == 3 ? "#ffffff" : "transparent";
				if (nexttrans==26) masterspeed=0;

				if (smallpreview) {
					mtl.add(punchgs.TweenLite.set(nextsh.parent(),{backgroundColor:bgcol,force3D:"auto"}),0);
					switch (specials) {
						case 0: 
							mtl.add(punchgs.TweenLite.fromTo(actsh,masterspeed/1000,{autoAlpha:0,zIndex:1},{autoAlpha:1,zIndex:1,force3D:"auto",ease:ei}),0);
							mtl.add(punchgs.TweenLite.set(nextsh,{autoAlpha:1,force3D:"auto",zIndex:0}),0);
						break;

						case 1:
							mtl.add(punchgs.TweenLite.fromTo(actsh,masterspeed/1000,{autoAlpha:0},{autoAlpha:1,force3D:"auto",ease:ei}),0);
							mtl.add(punchgs.TweenLite.fromTo(nextsh,masterspeed/1000,{autoAlpha:1},{autoAlpha:0,force3D:"auto",ease:ei}),0);
						break;

						case 2:
						case 3:
						case 4:
							mtl.add(punchgs.TweenLite.fromTo(nextsh,masterspeed/2000,{autoAlpha:1},{autoAlpha:0,force3D:"auto",ease:ei}),0);
							mtl.add(punchgs.TweenLite.set(actsh,{autoAlpha:0,force3D:"auto"}),0);
							mtl.add(punchgs.TweenLite.fromTo(actsh,masterspeed/2000,{autoAlpha:0},{autoAlpha:1,force3D:"auto",ease:ei}),masterspeed/2000);							
						break;
					}
				} else {				
					nextsh.find('.slotslide').each(function(i) {
						var ss=jQuery(this);
						mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,{autoAlpha:0},{autoAlpha:1,force3D:"auto",ease:ei}),0);
					});
				}
	}

	//////////////////////
	// SLIDING OVERLAYS //
	//////////////////////
		
	if (nexttrans==27||nexttrans==28||nexttrans==29||nexttrans==30) {

		var slot = nextsh.find('.slot'),		
			nd = nexttrans==27 || nexttrans==28 ? 1 : 2,
			mhp = nexttrans==27 || nexttrans==29 ? "-100%" : "+100%",
			php = nexttrans==27 || nexttrans==29 ? "+100%" : "-100%",
			mep = nexttrans==27 || nexttrans==29 ? "-80%" : "80%",
			pep = nexttrans==27 || nexttrans==29 ? "80%" : "-80%",
			ptp = nexttrans==27 || nexttrans==29 ? "10%" : "-10%",
			fa = {overwrite:"all"},
			ta = {autoAlpha:0,zIndex:1,force3D:"auto",ease:punchgs.Power1.easeInOut},
			fb = {position:"inherit",autoAlpha:0,overwrite:"all"},
			tb = {autoAlpha:1,force3D:"auto",ease:punchgs.Power1.easeOut},
			fc = {overwrite:"all",zIndex:2},
			tc = {autoAlpha:1,force3D:"auto",overwrite:"all",ease:punchgs.Power1.easeInOut},
			fd = {overwrite:"all",zIndex:2},
			td = {autoAlpha:1,force3D:"auto",ease:punchgs.Power1.easeInOut},
			at = nd==1 ? "y" : "x";

		fa[at] = "0px";
		ta[at] = mhp;
		fb[at] = ptp;
		tb[at] = "0%";
		fc[at] = php;
		tc[at] = mhp;
		fd[at] = mep;
		td[at] = pep;

		slot.append('<span style="background-color:rgba(0,0,0,0.6);width:100%;height:100%;position:absolute;top:0px;left:0px;display:block;z-index:2"></span>');
		
		
		mtl.add(punchgs.TweenLite.fromTo(actsh,masterspeed/1000,fa,ta),0);						
		mtl.add(punchgs.TweenLite.fromTo(nextsh.find('.defaultimg'),masterspeed/2000,fb,tb),masterspeed/2000);				
		mtl.add(punchgs.TweenLite.fromTo(slot,masterspeed/1000,fc,tc),0);	
		mtl.add(punchgs.TweenLite.fromTo(slot.find('.slotslide div'),masterspeed/1000,fd,td),0);			
	}



	if (nexttrans==12 || nexttrans==13 || nexttrans==14 || nexttrans==15) {
				masterspeed = masterspeed;
				if (masterspeed>opt.delay) masterspeed=opt.delay;
				//masterspeed = 1000;

				setTimeout(function() {
					punchgs.TweenLite.set(actsh.find('.defaultimg'),{autoAlpha:0});

				},100);

				var oow = opt.width,
					ooh = opt.height,
					ssn=nextsh.find('.slotslide'),
					twx = 0,
					twy = 0,
					op = 1,
					scal = 1,
					fromscale = 1,					
					speedy = masterspeed/1000,
					speedy2 = speedy;


				if (opt.sliderLayout=="fullwidth" || opt.sliderLayout=="fullscreen") {
					oow=ssn.width();
					ooh=ssn.height();
				}



				if (nexttrans==12)
					twx = oow;
				else
				if (nexttrans==15)
					twx = 0-oow;
				else
				if (nexttrans==13)
					twy = ooh;
				else
				if (nexttrans==14)
					twy = 0-ooh;


				// DEPENDING ON EXTENDED SPECIALS, DIFFERENT SCALE AND OPACITY FUNCTIONS NEED TO BE ADDED
				if (specials == 1) op = 0;
				if (specials == 2) op = 0;
				if (specials == 3) speedy = masterspeed / 1300;				

				if (specials==4 || specials==5)
					scal=0.6;
				if (specials==6 )
					scal=1.4;


				if (specials==5 || specials==6) {
				    fromscale=1.4;
				    op=0;
				    oow=0;
				    ooh=0;twx=0;twy=0;
				 }
				if (specials==6) fromscale=0.6;
				var dd = 0;

				if (specials==7) {
					oow = 0;
					ooh = 0;
				}

				var inc = nextsh.find('.slotslide'),
					outc = actsh.find('.slotslide');

				mtl.add(punchgs.TweenLite.set(actli,{zIndex:15}),0);
				mtl.add(punchgs.TweenLite.set(nextli,{zIndex:20}),0);

				if (specials==8) {
										
					mtl.add(punchgs.TweenLite.set(actli,{zIndex:20}),0);
					mtl.add(punchgs.TweenLite.set(nextli,{zIndex:15}),0);					
					mtl.add(punchgs.TweenLite.set(inc,{left:0, top:0, scale:1, opacity:1,rotation:0,ease:ei,force3D:"auto"}),0);
				} else {

					mtl.add(punchgs.TweenLite.from(inc,speedy,{left:twx, top:twy, scale:fromscale, opacity:op,rotation:opt.rotate,ease:ei,force3D:"auto"}),0);
				}
				
				if (specials==4 || specials==5) {
					oow = 0; ooh=0;
				}

				if (specials!=1)
					switch (nexttrans) {
						case 12:
							mtl.add(punchgs.TweenLite.to(outc,speedy2,{'left':(0-oow)+'px',force3D:"auto",scale:scal,opacity:op,rotation:opt.rotate,ease:eo}),0);
						break;
						case 15:
							mtl.add(punchgs.TweenLite.to(outc,speedy2,{'left':(oow)+'px',force3D:"auto",scale:scal,opacity:op,rotation:opt.rotate,ease:eo}),0);
						break;
						case 13:						
							mtl.add(punchgs.TweenLite.to(outc,speedy2,{'top':(0-ooh)+'px',force3D:"auto",scale:scal,opacity:op,rotation:opt.rotate,ease:eo}),0);
						break;
						case 14:
							mtl.add(punchgs.TweenLite.to(outc,speedy2,{'top':(ooh)+'px',force3D:"auto",scale:scal,opacity:op,rotation:opt.rotate,ease:eo}),0);
						break;
					}
	
	}

	//////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XVI.  //
	//////////////////////////////////////
	if (nexttrans==16) {						// PAPERCUT


			var subtl = new punchgs.TimelineLite();
			mtl.add(punchgs.TweenLite.set(actli,{'position':'absolute','z-index':20}),0);
			mtl.add(punchgs.TweenLite.set(nextli,{'position':'absolute','z-index':15}),0);


			// PREPARE THE CUTS
			actli.wrapInner('<div class="tp-half-one" style="position:relative; width:100%;height:100%"></div>');

			actli.find('.tp-half-one').clone(true).appendTo(actli).addClass("tp-half-two");
			actli.find('.tp-half-two').removeClass('tp-half-one');

			var oow = opt.width,
				ooh = opt.height;
			if (opt.autoHeight=="on")
				ooh = container.height();


			actli.find('.tp-half-one .defaultimg').wrap('<div class="tp-papercut" style="width:'+oow+'px;height:'+ooh+'px;"></div>')
			actli.find('.tp-half-two .defaultimg').wrap('<div class="tp-papercut" style="width:'+oow+'px;height:'+ooh+'px;"></div>')
			actli.find('.tp-half-two .defaultimg').css({position:'absolute',top:'-50%'});
			actli.find('.tp-half-two .tp-caption').wrapAll('<div style="position:absolute;top:-50%;left:0px;"></div>');

			mtl.add(punchgs.TweenLite.set(actli.find('.tp-half-two'),
			                 {width:oow,height:ooh,overflow:'hidden',zIndex:15,position:'absolute',top:ooh/2,left:'0px',transformPerspective:600,transformOrigin:"center bottom"}),0);

			mtl.add(punchgs.TweenLite.set(actli.find('.tp-half-one'),
			                 {width:oow,height:ooh/2,overflow:'visible',zIndex:10,position:'absolute',top:'0px',left:'0px',transformPerspective:600,transformOrigin:"center top"}),0);

			// ANIMATE THE CUTS
			var img=actli.find('.defaultimg'),
				ro1=Math.round(Math.random()*20-10),
				ro2=Math.round(Math.random()*20-10),
				ro3=Math.round(Math.random()*20-10),
				xof = Math.random()*0.4-0.2,
				yof = Math.random()*0.4-0.2,
				sc1=Math.random()*1+1,
				sc2=Math.random()*1+1,
				sc3=Math.random()*0.3+0.3;

			mtl.add(punchgs.TweenLite.set(actli.find('.tp-half-one'),{overflow:'hidden'}),0);
			mtl.add(punchgs.TweenLite.fromTo(actli.find('.tp-half-one'),masterspeed/800,
			                 {width:oow,height:ooh/2,position:'absolute',top:'0px',left:'0px',force3D:"auto",transformOrigin:"center top"},
			                 {scale:sc1,rotation:ro1,y:(0-ooh-ooh/4),autoAlpha:0,ease:ei}),0);
			mtl.add(punchgs.TweenLite.fromTo(actli.find('.tp-half-two'),masterspeed/800,
			                 {width:oow,height:ooh,overflow:'hidden',position:'absolute',top:ooh/2,left:'0px',force3D:"auto",transformOrigin:"center bottom"},
			                 {scale:sc2,rotation:ro2,y:ooh+ooh/4,ease:ei,autoAlpha:0,onComplete:function() {
				                // CLEAN UP
								punchgs.TweenLite.set(actli,{'position':'absolute','z-index':15});
								punchgs.TweenLite.set(nextli,{'position':'absolute','z-index':20});
								if (actli.find('.tp-half-one').length>0)  {
									actli.find('.tp-half-one .defaultimg').unwrap();
									actli.find('.tp-half-one .slotholder').unwrap();
								}
								actli.find('.tp-half-two').remove();
			                 }}),0);

			subtl.add(punchgs.TweenLite.set(nextsh.find('.defaultimg'),{autoAlpha:1}),0);

			if (actli.html()!=null)
				mtl.add(punchgs.TweenLite.fromTo(nextli,(masterspeed-200)/1000,
												{scale:sc3,x:(opt.width/4)*xof, y:(ooh/4)*yof,rotation:ro3,force3D:"auto",transformOrigin:"center center",ease:eo},
												{autoAlpha:1,scale:1,x:0,y:0,rotation:0}),0);

			mtl.add(subtl,0);


	}

	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XVII.  //
	///////////////////////////////////////
	if (nexttrans==17) {								// 3D CURTAIN HORIZONTAL


				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT

				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);

					mtl.add(punchgs.TweenLite.fromTo(ss,(masterspeed)/800,
									{opacity:0,rotationY:0,scale:0.9,rotationX:-110,force3D:"auto",transformPerspective:600,transformOrigin:"center center"},
									{opacity:1,top:0,left:0,scale:1,rotation:0,rotationX:0,force3D:"auto",rotationY:0,ease:ei,delay:j*0.06}),0);

				});
	}



	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XVIII.  //
	///////////////////////////////////////
	if (nexttrans==18) {								// 3D CURTAIN VERTICAL

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);

					mtl.add(punchgs.TweenLite.fromTo(ss,(masterspeed)/500,
									{autoAlpha:0,rotationY:110,scale:0.9,rotationX:10,force3D:"auto",transformPerspective:600,transformOrigin:"center center"},
									{autoAlpha:1,top:0,left:0,scale:1,rotation:0,rotationX:0,force3D:"auto",rotationY:0,ease:ei,delay:j*0.06}),0);
				});



	}


	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XIX.  //
	///////////////////////////////////////
	if (nexttrans==19 || nexttrans==22) {								// IN CUBE

				var subtl = new punchgs.TimelineLite();
				//SET DEFAULT IMG UNVISIBLE

				mtl.add(punchgs.TweenLite.set(actli,{zIndex:20}),0);
				mtl.add(punchgs.TweenLite.set(nextli,{zIndex:20}),0);
				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);
				var rot = 90,
					op = 1,
					torig ="center center ";

				if (slidedirection==1) rot = -90;

				if (nexttrans==19) {
					torig = torig+"-"+opt.height/2;
					op=0;

				} else {
					torig = torig+opt.height/2;
				}

				// ALL NEW SLOTS SHOULD BE SLIDED FROM THE LEFT TO THE RIGHT
				punchgs.TweenLite.set(container,{transformStyle:"flat",backfaceVisibility:"hidden",transformPerspective:600});

				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);

					subtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
									{transformStyle:"flat",backfaceVisibility:"hidden",left:0,rotationY:opt.rotate,z:10,top:0,scale:1,force3D:"auto",transformPerspective:600,transformOrigin:torig,rotationX:rot},
									{left:0,rotationY:0,top:0,z:0, scale:1,force3D:"auto",rotationX:0, delay:(j*50)/1000,ease:ei}),0);
					subtl.add(punchgs.TweenLite.to(ss,0.1,{autoAlpha:1,delay:(j*50)/1000}),0);
					mtl.add(subtl);
				});

				actsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);
					var rot = -90;
					if (slidedirection==1) rot = 90;

					subtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
									{transformStyle:"flat",backfaceVisibility:"hidden",autoAlpha:1,rotationY:0,top:0,z:0,scale:1,force3D:"auto",transformPerspective:600,transformOrigin:torig, rotationX:0},
									{autoAlpha:1,rotationY:opt.rotate,top:0,z:10, scale:1,rotationX:rot, delay:(j*50)/1000,force3D:"auto",ease:eo}),0);

					mtl.add(subtl);					
				});
				mtl.add(punchgs.TweenLite.set(actli,{zIndex:18}),0);
	}




	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XX.  //
	///////////////////////////////////////
	if (nexttrans==20 ) {								// FLYIN


				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);
				
				if (slidedirection==1) {
				   var ofx = -opt.width
				   var rot  =80;
				   var torig = "20% 70% -"+opt.height/2;
				} else {
					var ofx = opt.width;
					var rot = -80;
					var torig = "80% 70% -"+opt.height/2;
				}


				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this),
						d = (j*50)/1000;

					

					mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
									{left:ofx,rotationX:40,z:-600, opacity:op,top:0,scale:1,force3D:"auto",transformPerspective:600,transformOrigin:torig,transformStyle:"flat",rotationY:rot},
									{left:0,rotationX:0,opacity:1,top:0,z:0, scale:1,rotationY:0, delay:d,ease:ei}),0);
				

				});
				actsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this),
						d = (j*50)/1000;
						d = j>0 ?  d + masterspeed/9000 : 0;

					if (slidedirection!=1) {
					   var ofx = -opt.width/2
					   var rot  =30;
					   var torig = "20% 70% -"+opt.height/2;
					} else {
						var ofx = opt.width/2;
						var rot = -30;
						var torig = "80% 70% -"+opt.height/2;
					}
					eo=punchgs.Power2.easeInOut;

					mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
									{opacity:1,rotationX:0,top:0,z:0,scale:1,left:0, force3D:"auto",transformPerspective:600,transformOrigin:torig, transformStyle:"flat",rotationY:0},
									{opacity:1,rotationX:20,top:0, z:-600, left:ofx, force3D:"auto",rotationY:rot, delay:d,ease:eo}),0);
					
					
				});
	}

	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XX.  //
	///////////////////////////////////////
	if (nexttrans==21 || nexttrans==25) {								// TURNOFF


				//SET DEFAULT IMG UNVISIBLE

				setTimeout(function() {
					actsh.find('.defaultimg').css({opacity:0});
				},100);
				var rot = 90,
					ofx = -opt.width,
					rot2 = -rot;

				if (slidedirection==1) {
				   if (nexttrans==25) {
				   	 var torig = "center top 0";
				   	 rot = opt.rotate;
				   } else {
				     var torig = "left center 0";
				     rot2 = opt.rotate;
				   }

				} else {
					ofx = opt.width;
					rot = -90;
					if (nexttrans==25) {
				   	 var torig = "center bottom 0"
				   	 rot2 = -rot;
				   	 rot = opt.rotate;
				   } else {
				     var torig = "right center 0";
				     rot2 = opt.rotate;
				   }
				}

				nextsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this),
						ms2 = ((masterspeed/1.5)/3);


					mtl.add(punchgs.TweenLite.fromTo(ss,(ms2*2)/1000,
									{left:0,transformStyle:"flat",rotationX:rot2,z:0, autoAlpha:0,top:0,scale:1,force3D:"auto",transformPerspective:1200,transformOrigin:torig,rotationY:rot},
									{left:0,rotationX:0,top:0,z:0, autoAlpha:1,scale:1,rotationY:0,force3D:"auto",delay:ms2/1000, ease:ei}),0);
				});


				if (slidedirection!=1) {
				   	ofx = -opt.width
				   	rot  = 90;

				   if (nexttrans==25) {
				   	 torig = "center top 0"
				   	 rot2 = -rot;
				   	 rot = opt.rotate;
				   } else {
				     torig = "left center 0";
				     rot2 = opt.rotate;
				   }

				} else {
					ofx = opt.width;
					rot = -90;
					if (nexttrans==25) {
				   	 torig = "center bottom 0"
				   	 rot2 = -rot;
				   	 rot = opt.rotate;
				   } else {
				     torig = "right center 0";
				     rot2 = opt.rotate;
				   }
				}

				actsh.find('.slotslide').each(function(j) {
					var ss=jQuery(this);
					mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
									{left:0,transformStyle:"flat",rotationX:0,z:0, autoAlpha:1,top:0,scale:1,force3D:"auto",transformPerspective:1200,transformOrigin:torig,rotationY:0},
									{left:0,rotationX:rot2,top:0,z:0,autoAlpha:1,force3D:"auto", scale:1,rotationY:rot,ease:eo}),0);
				});
	}



	////////////////////////////////////////
	// THE SLOTSLIDE - TRANSITION XX.  //
	///////////////////////////////////////
	if (nexttrans==23 || nexttrans == 24) {								// cube-horizontal - inboxhorizontal

		//SET DEFAULT IMG UNVISIBLE
		setTimeout(function() {
			actsh.find('.defaultimg').css({opacity:0});
		},100);
		var rot = -90,
			op = 1,
			opx=0;

		if (slidedirection==1) rot = 90;
		if (nexttrans==23) {
			var torig = "center center -"+opt.width/2;
			op=0;
		} else
			var torig = "center center "+opt.width/2;

		punchgs.TweenLite.set(container,{transformStyle:"preserve-3d",backfaceVisibility:"hidden",perspective:2500});
						nextsh.find('.slotslide').each(function(j) {
			var ss=jQuery(this);
			mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
							{left:opx,rotationX:opt.rotate,force3D:"auto",opacity:op,top:0,scale:1,transformPerspective:1200,transformOrigin:torig,rotationY:rot},
							{left:0,rotationX:0,autoAlpha:1,top:0,z:0, scale:1,rotationY:0, delay:(j*50)/500,ease:ei}),0);
		});

		rot = 90;
		if (slidedirection==1) rot = -90;

		actsh.find('.slotslide').each(function(j) {
			var ss=jQuery(this);
			mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/1000,
							{left:0,rotationX:0,top:0,z:0,scale:1,force3D:"auto",transformStyle:"flat",transformPerspective:1200,transformOrigin:torig, rotationY:0},
							{left:opx,rotationX:opt.rotate,top:0, scale:1,rotationY:rot, delay:(j*50)/500,ease:eo}),0);
			if (nexttrans==23) mtl.add(punchgs.TweenLite.fromTo(ss,masterspeed/2000,{autoAlpha:1},{autoAlpha:0,delay:(j*50)/500 + masterspeed/3000,ease:eo}),0);

		});
	}	

	

			// SHOW FIRST LI && ANIMATE THE CAPTIONS
			mtl.add(punchgs.TweenLite.set(nextsh.find('.defaultimg'),{autoAlpha:1}));
			mtl.add(punchgs.TweenLite.set(nextsh.find('.slot'),{autoAlpha:0}));		

			mtl.seek(100000);
	
			if (givebackmtl!=undefined)
				return mtl;
			else
				jQuery('#divbgholder').data('slidetimeline',mtl);
			
		}
	

	


	///////////////////////
	//	REMOVE SLOTS	//
	/////////////////////
	var removeAllSlots = function() {
				if (jQuery('#divbgholder').data('slidetimeline')!=undefined) {
					jQuery('#divbgholder').data('slidetimeline').kill();
					jQuery('#divbgholder').find('.slot').each(function() {
						jQuery(this).remove();
					});
				}
				
		}
	
	t.resetSlideAnimations = function(seekinpos) {
		removeAllSlots();
		slideAnimation();
		var mst = jQuery('#divbgholder').data('slidetimeline'),
			mp = jQuery('#mastertimer-position'),
			tpos = (mp.position().left)/100;
		if (mst!=undefined) {
			mst.stop();
			if (seekinpos) mst.seek(tpos);
		}
	}
	
}