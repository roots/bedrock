/*!
 * VERSION: beta 0.2.3
 * DATE: 2013-07-10
 * UPDATES AND DOCS AT: http://www.greensock.com
 *
 * @license Copyright (c) 2008-2013, GreenSock. All rights reserved.
 * SplitText is a Club GreenSock membership benefit; You must have a valid membership to use
 * this code without violating the terms of use. Visit http://www.greensock.com/club/ to sign up or get more details.
 * This work is subject to the software agreement that was issued with your membership.
 *
 * @author: Jack Doyle, jack@greensock.com
 */
(function(t){"use strict";var e=t.GreenSockGlobals||t,i=function(t){var i,s=t.split("."),r=e;for(i=0;s.length>i;i++)r[s[i]]=r=r[s[i]]||{};return r},s=i("com.greensock.utils"),r=function(t){var e=t.nodeType,i="";if(1===e||9===e||11===e){if("string"==typeof t.textContent)return t.textContent;for(t=t.firstChild;t;t=t.nextSibling)i+=r(t)}else if(3===e||4===e)return t.nodeValue;return i},n=document,a=n.defaultView?n.defaultView.getComputedStyle:function(){},o=/([A-Z])/g,h=function(t,e,i,s){var r;return(i=i||a(t,null))?(t=i.getPropertyValue(e.replace(o,"-$1").toLowerCase()),r=t||i.length?t:i[e]):t.currentStyle&&(i=t.currentStyle,r=i[e]),s?r:parseInt(r,10)||0},l=function(t){return t.length&&t[0]&&(t[0].nodeType&&t[0].style&&!t.nodeType||t[0].length&&t[0][0])?!0:!1},_=function(t){var e,i,s,r=[],n=t.length;for(e=0;n>e;e++)if(i=t[e],l(i))for(s=i.length,s=0;i.length>s;s++)r.push(i[s]);else r.push(i);return r},u=")eefec303079ad17405c",c=/(?:<br>|<br\/>|<br \/>)/gi,p=n.all&&!n.addEventListener,f="<div style='position:relative;display:inline-block;"+(p?"*display:inline;*zoom:1;'":"'"),m=function(t){t=t||"";var e=-1!==t.indexOf("++"),i=1;return e&&(t=t.split("++").join("")),function(){return f+(t?" class='"+t+(e?i++:"")+"'>":">")}},d=s.SplitText=e.SplitText=function(t,e){if("string"==typeof t&&(t=d.selector(t)),!t)throw"cannot split a null element.";this.elements=l(t)?_(t):[t],this.chars=[],this.words=[],this.lines=[],this._originals=[],this.vars=e||{},this.split(e)},g=function(t,e,i,s,o){c.test(t.innerHTML)&&(t.innerHTML=t.innerHTML.replace(c,u));var l,_,p,f,d,g,v,y,T,w,b,x,P,S=r(t),C=e.type||e.split||"chars,words,lines",k=-1!==C.indexOf("lines")?[]:null,R=-1!==C.indexOf("words"),A=-1!==C.indexOf("chars"),D="absolute"===e.position||e.absolute===!0,O=D?"&#173; ":" ",M=-999,L=a(t),I=h(t,"paddingLeft",L),E=h(t,"borderBottomWidth",L)+h(t,"borderTopWidth",L),N=h(t,"borderLeftWidth",L)+h(t,"borderRightWidth",L),F=h(t,"paddingTop",L)+h(t,"paddingBottom",L),U=h(t,"paddingLeft",L)+h(t,"paddingRight",L),X=h(t,"textAlign",L,!0),z=t.clientHeight,B=t.clientWidth,j=S.length,Y="</div>",q=m(e.wordsClass),V=m(e.charsClass),Q=-1!==(e.linesClass||"").indexOf("++"),G=e.linesClass;for(Q&&(G=G.split("++").join("")),p=q(),f=0;j>f;f++)g=S.charAt(f),")"===g&&S.substr(f,20)===u?(p+=Y+"<BR/>",f!==j-1&&(p+=" "+q()),f+=19):" "===g&&" "!==S.charAt(f-1)&&f!==j-1?(p+=Y,f!==j-1&&(p+=O+q())):p+=A&&" "!==g?V()+g+"</div>":g;for(t.innerHTML=p+Y,d=t.getElementsByTagName("*"),j=d.length,v=[],f=0;j>f;f++)v[f]=d[f];if(k||D)for(f=0;j>f;f++)y=v[f],_=y.parentNode===t,(_||D||A&&!R)&&(T=y.offsetTop,k&&_&&T!==M&&"BR"!==y.nodeName&&(l=[],k.push(l),M=T),D&&(y._x=y.offsetLeft,y._y=T,y._w=y.offsetWidth,y._h=y.offsetHeight),k&&(R!==_&&A||(l.push(y),y._x-=I),_&&f&&(v[f-1]._wordEnd=!0)));for(f=0;j>f;f++)y=v[f],_=y.parentNode===t,"BR"!==y.nodeName?(D&&(b=y.style,R||_||(y._x+=y.parentNode._x,y._y+=y.parentNode._y),b.left=y._x+"px",b.top=y._y+"px",b.position="absolute",b.display="block",b.width=y._w+1+"px",b.height=y._h+"px"),R?_?s.push(y):A&&i.push(y):_?(t.removeChild(y),v.splice(f--,1),j--):!_&&A&&(T=!k&&!D&&y.nextSibling,t.appendChild(y),T||t.appendChild(n.createTextNode(" ")),i.push(y))):k||D?(t.removeChild(y),v.splice(f--,1),j--):R||t.appendChild(y);if(k){for(D&&(w=n.createElement("div"),t.appendChild(w),x=w.offsetWidth+"px",T=w.offsetParent===t?0:t.offsetLeft,t.removeChild(w)),b=t.style.cssText,t.style.cssText="display:none;";t.firstChild;)t.removeChild(t.firstChild);for(P=!D||!R&&!A,f=0;k.length>f;f++){for(l=k[f],w=n.createElement("div"),w.style.cssText="display:block;text-align:"+X+";position:"+(D?"absolute;":"relative;"),G&&(w.className=G+(Q?f+1:"")),o.push(w),j=l.length,d=0;j>d;d++)"BR"!==l[d].nodeName&&(y=l[d],w.appendChild(y),P&&(y._wordEnd||R)&&w.appendChild(n.createTextNode(" ")),D&&(0===d&&(w.style.top=y._y+"px",w.style.left=I+T+"px"),y.style.top="0px",T&&(y.style.left=y._x-T+"px")));R||A||(w.innerHTML=r(w).split(String.fromCharCode(160)).join(" ")),D&&(w.style.width=x,w.style.height=y._h+"px"),t.appendChild(w)}t.style.cssText=b}D&&(z>t.clientHeight&&(t.style.height=z-F+"px",z>t.clientHeight&&(t.style.height=z+E+"px")),B>t.clientWidth&&(t.style.width=B-U+"px",B>t.clientWidth&&(t.style.width=B+N+"px")))},v=d.prototype;v.split=function(t){this.isSplit&&this.revert(),this.vars=t||this.vars,this._originals.length=this.chars.length=this.words.length=this.lines.length=0;for(var e=0;this.elements.length>e;e++)this._originals[e]=this.elements[e].innerHTML,g(this.elements[e],this.vars,this.chars,this.words,this.lines);return this.isSplit=!0,this},v.revert=function(){if(!this._originals)throw"revert() call wasn't scoped properly.";for(var t=this._originals.length;--t>-1;)this.elements[t].innerHTML=this._originals[t];return this.chars=[],this.words=[],this.lines=[],this.isSplit=!1,this},d.selector=t.$||t.jQuery||function(e){return t.$?(d.selector=t.$,t.$(e)):n?n.getElementById("#"===e.charAt(0)?e.substr(1):e):e}})(window||{});


/*! ROTATABLE */
// ROTATABLE
// 
!function(t,e){t.widget("ui.rotatable",t.ui.mouse,{options:{handle:!1,angle:!1,start:null,rotate:null,stop:null},handle:function(t){return t===e?this.options.handle:void(this.options.handle=t)},angle:function(t){return t===e?this.options.angle:(this.options.angle=t,void this.performRotation(this.options.angle))},_create:function(){var e;this.options.handle?e=this.options.handle:(e=t(document.createElement("div")),e.addClass("ui-rotatable-handle")),this.listeners={rotateElement:t.proxy(this.rotateElement,this),startRotate:t.proxy(this.startRotate,this),stopRotate:t.proxy(this.stopRotate,this)},e.draggable({helper:"clone",start:this.dragStart,handle:e}),e.bind("mousedown",this.listeners.startRotate),e.appendTo(this.element),0!=this.options.angle?(this.elementCurrentAngle=this.options.angle,this.performRotation(this.elementCurrentAngle)):this.elementCurrentAngle=0},_destroy:function(){this.element.removeClass("ui-rotatable"),this.element.find(".ui-rotatable-handle").remove()},performRotation:function(t){var e=180*t/Math.PI;punchgs.TweenLite.set(this.element,{rotationZ:e+"deg"})},getElementOffset:function(){this.performRotation(0);var t=this.element.offset();return this.performRotation(this.elementCurrentAngle),t},getElementCenter:function(){var t=this.getElementOffset(),e=t.left+this.element.width()/2,n=t.top+this.element.height()/2;return Array(e,n)},dragStart:function(){return this.element?!1:void 0},startRotate:function(e){var n=this.getElementCenter(),i=e.pageX-n[0],s=e.pageY-n[1];return this.mouseStartAngle=Math.atan2(s,i),this.elementStartAngle=this.elementCurrentAngle,this.hasRotated=!1,this._propagate("start",e),t(document).bind("mousemove",this.listeners.rotateElement),t(document).bind("mouseup",this.listeners.stopRotate),!1},rotateElement:function(t){if(!this.element)return!1;var e=this.getElementCenter(),n=t.pageX-e[0],i=t.pageY-e[1],s=Math.atan2(i,n),o=s-this.mouseStartAngle+this.elementStartAngle;this.performRotation(o);var r=this.elementCurrentAngle;return this.elementCurrentAngle=o,this._propagate("rotate",t),r!=o&&(this._trigger("rotate",t,this.ui()),this.hasRotated=!0),!1},stopRotate:function(e){return this.element?(t(document).unbind("mousemove",this.listeners.rotateElement),t(document).unbind("mouseup",this.listeners.stopRotate),this.elementStopAngle=this.elementCurrentAngle,this.hasRotated&&this._propagate("stop",e),setTimeout(function(){this.element=!1},10),!1):void 0},_propagate:function(e,n){t.ui.plugin.call(this,e,[n,this.ui()]),"rotate"!==e&&this._trigger(e,n,this.ui())},plugins:{},ui:function(){return{element:this.element,angle:{start:this.elementStartAngle,current:this.elementCurrentAngle,stop:this.elementStopAngle}}}})}(jQuery);

jQuery(document).ready(function(){
	UniteLayersRev.setGlobalAction(wp.template( "rs-action-layer-wrap" ));
	UniteLayersRev.setGlobalSlideImport(wp.template( "rs-import-layer-wrap" ));
	!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","jquery-ui/sortable"],e):e(window.jQuery)}(function(e){"use strict";function t(e,t,s){return e>t&&t+s>e}e.widget("mjs.nestedSortable",e.extend({},e.ui.sortable.prototype,{options:{disableParentChange:!1,doNotClear:!1,expandOnHover:700,isAllowed:function(){return!0},isTree:!1,listType:"ul",maxLevels:0,protectRoot:!1,rootID:null,rtl:!1,startCollapsed:!1,tabSize:20,branchClass:"mjs-nestedSortable-branch",collapsedClass:"mjs-nestedSortable-collapsed",disableNestingClass:"mjs-nestedSortable-no-nesting",errorClass:"mjs-nestedSortable-error",expandedClass:"mjs-nestedSortable-expanded",hoveringClass:"mjs-nestedSortable-hovering",leafClass:"mjs-nestedSortable-leaf",disabledClass:"mjs-nestedSortable-disabled"},_create:function(){var t,s=this;if(this.element.data("ui-sortable",this.element.data("mjs-nestedSortable")),!this.element.is(this.options.listType))throw t="nestedSortable: Please check that the listType option is set to your actual list type",new Error(t);this.options.isTree&&this.options.expandOnHover&&(this.options.tolerance="intersect"),e.ui.sortable.prototype._create.apply(this,arguments),this.options.isTree&&e(this.items).each(function(){var e=this.item,t=e.hasClass(s.options.collapsedClass),i=e.hasClass(s.options.expandedClass);e.children(s.options.listType).length?(e.addClass(s.options.branchClass),t||i||(s.options.startCollapsed?e.addClass(s.options.collapsedClass):e.addClass(s.options.expandedClass))):e.addClass(s.options.leafClass)})},_destroy:function(){return this.element.removeData("mjs-nestedSortable").removeData("ui-sortable"),e.ui.sortable.prototype._destroy.apply(this,arguments)},_mouseDrag:function(t){var s,i,o,l,r,n,a,h,p,d,c,u,f,m,g,v,C=this,b=this.options,y=!1,_=e(document);for(this.position=this._generatePosition(t),this.positionAbs=this._convertPositionTo("absolute"),this.lastPositionAbs||(this.lastPositionAbs=this.positionAbs),this.options.scroll&&(this.scrollParent[0]!==document&&"HTML"!==this.scrollParent[0].tagName?(this.overflowOffset.top+this.scrollParent[0].offsetHeight-t.pageY<b.scrollSensitivity?(y=this.scrollParent.scrollTop()+b.scrollSpeed,this.scrollParent.scrollTop(y)):t.pageY-this.overflowOffset.top<b.scrollSensitivity&&(y=this.scrollParent.scrollTop()-b.scrollSpeed,this.scrollParent.scrollTop(y)),this.overflowOffset.left+this.scrollParent[0].offsetWidth-t.pageX<b.scrollSensitivity?(y=this.scrollParent.scrollLeft()+b.scrollSpeed,this.scrollParent.scrollLeft(y)):t.pageX-this.overflowOffset.left<b.scrollSensitivity&&(y=this.scrollParent.scrollLeft()-b.scrollSpeed,this.scrollParent.scrollLeft(y))):(t.pageY-_.scrollTop()<b.scrollSensitivity?(y=_.scrollTop()-b.scrollSpeed,_.scrollTop(y)):e(window).height()-(t.pageY-_.scrollTop())<b.scrollSensitivity&&(y=_.scrollTop()+b.scrollSpeed,_.scrollTop(y)),t.pageX-_.scrollLeft()<b.scrollSensitivity?(y=_.scrollLeft()-b.scrollSpeed,_.scrollLeft(y)):e(window).width()-(t.pageX-_.scrollLeft())<b.scrollSensitivity&&(y=_.scrollLeft()+b.scrollSpeed,_.scrollLeft(y))),y!==!1&&e.ui.ddmanager&&!b.dropBehaviour&&e.ui.ddmanager.prepareOffsets(this,t)),this.positionAbs=this._convertPositionTo("absolute"),r=this.placeholder.offset().top,this.options.axis&&"y"===this.options.axis||(this.helper[0].style.left=this.position.left+"px"),this.options.axis&&"x"===this.options.axis||(this.helper[0].style.top=this.position.top+"px"),this.hovering=this.hovering?this.hovering:null,this.mouseentered=this.mouseentered?this.mouseentered:!1,function(){var e=this.placeholder.parent().parent();e&&e.closest(".ui-sortable").length&&(n=e)}.call(this),a=this._getLevel(this.placeholder),h=this._getChildLevels(this.helper),c=document.createElement(b.listType),s=this.items.length-1;s>=0;s--)if(i=this.items[s],o=i.item[0],l=this._intersectsWithPointer(i),l&&i.instance===this.currentContainer){if(-1!==o.className.indexOf(b.disabledClass))if(2===l){if(p=this.items[s+1],p&&p.item.hasClass(b.disabledClass))continue}else if(1===l&&(d=this.items[s-1],d&&d.item.hasClass(b.disabledClass)))continue;if(u=1===l?"next":"prev",o!==this.currentItem[0]&&this.placeholder[u]()[0]!==o&&!e.contains(this.placeholder[0],o)&&("semi-dynamic"===this.options.type?!e.contains(this.element[0],o):!0)){if(this.mouseentered||(e(o).mouseenter(),this.mouseentered=!0),b.isTree&&e(o).hasClass(b.collapsedClass)&&b.expandOnHover&&(this.hovering||(e(o).addClass(b.hoveringClass),this.hovering=window.setTimeout(function(){e(o).removeClass(b.collapsedClass).addClass(b.expandedClass),C.refreshPositions(),C._trigger("expand",t,C._uiHash())},b.expandOnHover))),this.direction=1===l?"down":"up","pointer"!==this.options.tolerance&&!this._intersectsWithSides(i))break;e(o).mouseleave(),this.mouseentered=!1,e(o).removeClass(b.hoveringClass),this.hovering&&window.clearTimeout(this.hovering),this.hovering=null,!b.protectRoot||this.currentItem[0].parentNode===this.element[0]&&o.parentNode!==this.element[0]?b.protectRoot||this._rearrange(t,i):this.currentItem[0].parentNode!==this.element[0]&&o.parentNode===this.element[0]?(e(o).children(b.listType).length||(o.appendChild(c),b.isTree&&e(o).removeClass(b.leafClass).addClass(b.branchClass+" "+b.expandedClass)),f="down"===this.direction?e(o).prev().children(b.listType):e(o).children(b.listType),void 0!==f[0]&&this._rearrange(t,null,f)):this._rearrange(t,i),this._clearEmpty(o),this._trigger("change",t,this._uiHash());break}}if(function(){var e=this.placeholder.prev();m=e.length?e:null}.call(this),null!=m)for(;"li"!==m[0].nodeName.toLowerCase()||-1!==m[0].className.indexOf(b.disabledClass)||m[0]===this.currentItem[0]||m[0]===this.helper[0];){if(!m[0].previousSibling){m=null;break}m=e(m[0].previousSibling)}if(function(){var e=this.placeholder.next();g=e.length?e:null}.call(this),null!=g)for(;"li"!==g[0].nodeName.toLowerCase()||-1!==g[0].className.indexOf(b.disabledClass)||g[0]===this.currentItem[0]||g[0]===this.helper[0];){if(!g[0].nextSibling){g=null;break}g=e(g[0].nextSibling)}return this.beyondMaxLevels=0,null==n||null!=g||b.protectRoot&&n[0].parentNode==this.element[0]||!(b.rtl&&this.positionAbs.left+this.helper.outerWidth()>n.offset().left+n.outerWidth()||!b.rtl&&this.positionAbs.left<n.offset().left)?null==m||m.hasClass(b.disableNestingClass)||!(m.children(b.listType).length&&m.children(b.listType).is(":visible")||!m.children(b.listType).length)||b.protectRoot&&this.currentItem[0].parentNode===this.element[0]||!(b.rtl&&this.positionAbs.left+this.helper.outerWidth()<m.offset().left+m.outerWidth()-b.tabSize||!b.rtl&&this.positionAbs.left>m.offset().left+b.tabSize)?this._isAllowed(n,a,a+h):(this._isAllowed(m,a,a+h+1),m.children(b.listType).length||(m[0].appendChild(c),b.isTree&&m.removeClass(b.leafClass).addClass(b.branchClass+" "+b.expandedClass)),r&&r<=m.offset().top?m.children(b.listType).prepend(this.placeholder):m.children(b.listType)[0].appendChild(this.placeholder[0]),"undefined"!=typeof n&&this._clearEmpty(n[0]),this._trigger("change",t,this._uiHash())):(n.after(this.placeholder[0]),v=!n.children(b.listItem).children("li:visible:not(.ui-sortable-helper)").length,b.isTree&&v&&n.removeClass(this.options.branchClass+" "+this.options.expandedClass).addClass(this.options.leafClass),"undefined"!=typeof n&&this._clearEmpty(n[0]),this._trigger("change",t,this._uiHash())),this._contactContainers(t),e.ui.ddmanager&&e.ui.ddmanager.drag(this,t),this._trigger("sort",t,this._uiHash()),this.lastPositionAbs=this.positionAbs,!1},_mouseStop:function(t){this.beyondMaxLevels&&(this.placeholder.removeClass(this.options.errorClass),this.domPosition.prev?e(this.domPosition.prev).after(this.placeholder):e(this.domPosition.parent).prepend(this.placeholder),this._trigger("revert",t,this._uiHash())),e("."+this.options.hoveringClass).mouseleave().removeClass(this.options.hoveringClass),this.mouseentered=!1,this.hovering&&window.clearTimeout(this.hovering),this.hovering=null,this._relocate_event=t,this._pid_current=e(this.domPosition.parent).parent().attr("id"),this._sort_current=this.domPosition.prev?e(this.domPosition.prev).next().index():0,e.ui.sortable.prototype._mouseStop.apply(this,arguments)},_intersectsWithSides:function(e){var s=this.options.isTree?.8:.5,i=t(this.positionAbs.top+this.offset.click.top,e.top+e.height*s,e.height),o=t(this.positionAbs.top+this.offset.click.top,e.top-e.height*s,e.height),l=t(this.positionAbs.left+this.offset.click.left,e.left+e.width/2,e.width),r=this._getDragVerticalDirection(),n=this._getDragHorizontalDirection();return this.floating&&n?"right"===n&&l||"left"===n&&!l:r&&("down"===r&&i||"up"===r&&o)},_contactContainers:function(){this.options.protectRoot&&this.currentItem[0].parentNode===this.element[0]||e.ui.sortable.prototype._contactContainers.apply(this,arguments)},_clear:function(){var t,s;for(e.ui.sortable.prototype._clear.apply(this,arguments),(this._pid_current!==this._uiHash().item.parent().parent().attr("id")||this._sort_current!==this._uiHash().item.index())&&this._trigger("relocate",this._relocate_event,this._uiHash()),t=this.items.length-1;t>=0;t--)s=this.items[t].item[0],this._clearEmpty(s)},serialize:function(t){var s=e.extend({},this.options,t),i=this._getItemsAsjQuery(s&&s.connected),o=[];return e(i).each(function(){var t=(e(s.item||this).attr(s.attribute||"id")||"").match(s.expression||/(.+)[-=_](.+)/),i=(e(s.item||this).parent(s.listType).parent(s.items).attr(s.attribute||"id")||"").match(s.expression||/(.+)[-=_](.+)/);t&&o.push((s.key||t[1])+"["+(s.key&&s.expression?t[1]:t[2])+"]="+(i?s.key&&s.expression?i[1]:i[2]:s.rootID))}),!o.length&&s.key&&o.push(s.key+"="),o.join("&")},toHierarchy:function(t){function s(t){var o,l=(e(t).attr(i.attribute||"id")||"").match(i.expression||/(.+)[-=_](.+)/),r=e(t).data();return r.nestedSortableItem&&delete r.nestedSortableItem,l?(o={id:l[2]},o=e.extend({},o,r),e(t).children(i.listType).children(i.items).length>0&&(o.children=[],e(t).children(i.listType).children(i.items).each(function(){var e=s(this);o.children.push(e)})),o):void 0}var i=e.extend({},this.options,t),o=[];return e(this.element).children(i.items).each(function(){var e=s(this);o.push(e)}),o},toArray:function(t){function s(t,r,n){var a,h,p,d=n+1;if(e(t).children(i.listType).children(i.items).length>0&&(r++,e(t).children(i.listType).children(i.items).each(function(){d=s(e(this),r,d)}),r--),a=e(t).attr(i.attribute||"id").match(i.expression||/(.+)[-=_](.+)/),r===o?h=i.rootID:(p=e(t).parent(i.listType).parent(i.items).attr(i.attribute||"id").match(i.expression||/(.+)[-=_](.+)/),h=p[2]),a){var c=e(t).children("div").data(),u=e.extend(c,{id:a[2],parent_id:h,depth:r,left:n,right:d});l.push(u)}return n=d+1}var i=e.extend({},this.options,t),o=i.startDepthCount||0,l=[],r=1;return i.excludeRoot||(l.push({item_id:i.rootID,parent_id:null,depth:o,left:r,right:2*(e(i.items,this.element).length+1)}),r++),e(this.element).children(i.items).each(function(){r=s(this,o,r)}),l=l.sort(function(e,t){return e.left-t.left})},_clearEmpty:function(t){function s(t,s,i,o){o&&(s=[i,i=s][0]),e(t).removeClass(s).addClass(i)}var i=this.options,o=e(t).children(i.listType),l=o.has("li").length,r=i.doNotClear||l||i.protectRoot&&e(t)[0]===this.element[0];i.isTree&&s(t,i.branchClass,i.leafClass,r),r||(o.parent().removeClass(i.expandedClass),o.remove())},_getLevel:function(e){var t,s=1;if(this.options.listType)for(t=e.closest(this.options.listType);t&&t.length>0&&!t.is(".ui-sortable");)s++,t=t.parent().closest(this.options.listType);return s},_getChildLevels:function(t,s){var i=this,o=this.options,l=0;return s=s||0,e(t).children(o.listType).children(o.items).each(function(e,t){l=Math.max(i._getChildLevels(t,s+1),l)}),s?l+1:l},_isAllowed:function(e,t,s){var i=this.options,o=this.placeholder.closest(".ui-sortable").nestedSortable("option","maxLevels"),l=this.currentItem.parent().parent(),r=i.disableParentChange&&("undefined"!=typeof e&&!l.is(e)||"undefined"==typeof e&&l.is("li"));r||!i.isAllowed(this.placeholder,e,this.currentItem)?(this.placeholder.addClass(i.errorClass),s>o&&0!==o?this.beyondMaxLevels=s-o:this.beyondMaxLevels=1):s>o&&0!==o?(this.placeholder.addClass(i.errorClass),this.beyondMaxLevels=s-o):(this.placeholder.removeClass(i.errorClass),this.beyondMaxLevels=0)}})),e.mjs.nestedSortable.prototype.options=e.extend({},e.ui.sortable.prototype.options,e.mjs.nestedSortable.prototype.options)});
});


jQuery(document).ready(function(){
	jQuery.widget( "custom.catcomplete", jQuery.ui.autocomplete, {
		_create: function() {
			this._super();
			this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
		},
		_renderMenu: function( ul, items ) {
			var that = this,
			currentCategory = "";
			if (items){
				jQuery.each( items, function( index, item ) {
					var li;
					if ( item.version != currentCategory ) {
						if (ul.closest("#tp-thelistoffonts").length>0)
							ul.append( "<li class='ui-autocomplete-category' style='font-size: 24px;'>" + item.version + "</li>" );
						else
							ul.append( "<li class='ui-autocomplete-category' style='font-size: 24px;'>Version: " + item.version + "</li>" );
						currentCategory = item.version;
					}
					li = that._renderItemData( ul, item );
					if ( item.version ) {
						li.attr( "aria-label", item.version + " : " + item.label );
					}					
				});

			}
		}
	});
	
});

// GLOBAL VARIABLES 
var timeline_timer = "",
	add_meta_into = '';

// EDIT Slider Functions
// VERSION: 5.0 
// DATE: 28-04-2015
var UniteLayersRev = new function(){
	
	var initTop = 100,
		initLeft = 100,
		initSpeed = 300,

		initTopVideo = 20,
		initLeftVideo = 20,
		g_startTime = 500,
		g_stepTime = 0,
		g_slideTime,


		initText = "Caption Text",
		initGroupName = "Group",
		initRowName = "Row",
		initColumnName = "Column",
		layout = 'desktop', //can be also tablet and mobil
		transSettings = [],

		t = this,
		u = tpLayerTimelinesRev,
		cm = tpLayerContextMenu,

		initArrFontTypes = [],
		containerID = "#divLayers",
		container,
		
		update_layer_changes = true,
		id_counter = 0,
		initLayers = null,
		initDemoLayers = null,
		initStaticLayers = [], //only used in non static slides, to show static slides in the action tab
		initDemoSettings = null,
		layerresized = false,
		layerGeneralParamsStatus = false,
		initLayerAnims = [],
		initLayerAnimsDefault = [],
		currentAnimationType = 'customin',
		curDemoSlideID = 0,
		slideIDs = {},
		
		alluniqueids = [],
		
		selectedLayerWidth = 0,
		selectedlayerHeight = 0,
		
		totalWidth = 0,
		totalHeight = 0,
		unique_layer_id = 0,
		//add_meta_into = '',
		global_action_template = null,
		global_layer_import_template = null,
		updateRevTimer = 0,
		updateRevChange = 0,
		save_needed = false,
		import_slides = {},
		lastchangedinput = "";

	// LAYER VERSION NUMBER FOR CLEAN OUTPUT IN FRONTEND
	t.core = 5;
	t.sub = 3;
	t.subsub = 0;

	t.newlayercoord = {x:-1,y:-1};

	u.layout = layout;
		
	t.groupMove = {x:0, y:0};
	t.selectedLayerSerial = -1;
	t.selectedLayers = new Array();
	t.justDropped = false;
	t.arrLayers = {};
	t.arrLayersClone = {};

	t.arrLayersDemo = {};
	t.arrLayersChanges = {undo:[], redo:[]};

	t.ignorAllUndoRedoLogs = false;

	t.attributegroups = [ 
		{ id:"0",icon:"move", groupname:"Layer Position", keys:["left.desktop",  "top.desktop", "align_hor.desktop", "align_vert.desktop", "left.notebook", "top.notebook", "align_hor.notebook", "align_vert.notebook", "left.tablet", "top.tablet", "align_hor.tablet", "align_vert.tablet", "left.mobile", "top.mobile", "align_hor.mobile", "align_vert.mobile"]},
		{ id:"1",icon:"play", groupname:"Start Animation", keys:["x_rotate_start","x_rotate_start_reverse","x_start","x_start_reverse","y_rotate_start","y_rotate_start_reverse","y_start","y_start_reverse","z_rotate_start","z_rotate_start_reverse","z_start"]},
		{ id:"2",icon:"play", groupname:"End Animation", keys:["x_end","x_end_reverse","x_origin_end","x_rotate_end","x_rotate_end_reverse","y_end","y_end_reverse","y_rotate_end","y_rotate_end_reverse","z_end","z_rotate_end","z_rotate_end_reverse"]},
		{ id:"31",icon:"play", groupname:"Frames", keys:["splitdelay","animation","split","split_extratime","relative_time","easing","speed","time"]},
		{ id:"3",icon:"play", groupname:"Loop Animation", keys:["loop_angle","loop_animation","loop_easing","loop_enddeg","loop_radius","loop_speed","loop_startdeg","loop_xend","loop_xorigin","loop_xstart","loop_yend","loop_yorigin","loop_ystart","loop_zoomend","loop_zoomstart"]},
		{ id:"4",icon:"play", groupname:"Mask Animation", keys:["mask_ease_end","mask_ease_start","mask_end","mask_speed_end","mask_speed_start","mask_start","mask_x_end","mask_x_end_reverse","mask_x_start","mask_x_start_reverse","mask_y_end","mask_y_end_reverse","mask_y_start","mask_y_start_reverse"]},
		{ id:"5",icon:"font", groupname:"Formatting", keys:["displaymode.desktop","displaymode.notebook","displaymode.tablet","displaymode.mobile","autolinebreak","whitespace.desktop","whitespace.notebook","whitespace.tablet","whitespace.mobile","html_tag","layer-selectable"]},
		{ id:"6",icon:"cog", groupname:"Behavior", keys:["basealign","lazy-load","resizeme","resize-full","responsive_offset"]},
		{ id:"7",icon:"eye", groupname:"Visibilty", keys:["hiddenunder","visible-desktop","visible-notebook","visible-tablet","visible-mobile","show-on-hover"]},
		{ id:"8",icon:"resize-full", groupname:"Sizing", keys:["scaleProportional","video_data.fullwidth", "video_data.cover", "originalWidth","originalHeight","cover_mode","height","width","image-size","video_height.desktop","video_height.notebook","video_height.tablet","video_height.mobile","video_width.desktop","video_width.notebook","video_width.tablet","video_width.mobile","max_height.desktop","max_height.notebook","max_height.tablet","max_height.mobile","min_height.desktop","min_height.notebook","min_height.tablet","min_height.mobile","max_width.desktop","max_width.notebook","max_width.tablet","max_width.mobile","scaleX.desktop","scaleX.notebook","scaleX.tablet","scaleX.mobile","scaleY.desktop","scaleY.notebook","scaleY.tablet","scaleY.mobile"]},			
		{ id:"9",icon:"font", groupname:"Naming and Alias", keys:["text","alias"]},

		{ id:"30",icon:"resize-vertical", groupname:"Order", keys:["order", "p_uid"]},

		{ id:"10",icon:"cancel", groupname:"Deleted", keys:["deleted"]},
		{ id:"11",icon:"plus", groupname:"Created", keys:["layer_unavailable"]},
		{ id:"12",icon:"link", groupname:"Source", keys:["svg.src","image_url"]},						
		{ id:"13",icon:"star", groupname:"SVG Style", keys:["svg.svgstroke-color","svg.svgstroke-dasharray","svg.svgstroke-dashoffset","svg.svgstroke-width","svg.svgstroke-hover-color","svg.svgstroke-hover-dasharray","svg.svgstroke-hover-dashoffset","svg.svgstroke-hover-transparency","svg.svgstroke-hover-width"]},
		{ id:"14",icon:"palette", groupname:"Main Styling", keys:["static_styles.color.desktop","static_styles.color.notebook","static_styles.color.tablet","static_styles.color.mobile","static_styles.font-size.desktop","static_styles.font-size.notebook","static_styles.font-size.tablet","static_styles.font-size.mobile","static_styles.font-weight.desktop","static_styles.font-weight.notebook","static_styles.font-weight.tablet","static_styles.font-weight.mobile","static_styles.line-height.desktop","static_styles.line-height.notebook","static_styles.line-height.tablet","static_styles.line-height.mobile"]},

		{ id:"15",icon:"thumbs-up", groupname:"Layer Action", keys:["layer_action","layer_action.action","layer_action.action_delay","layer_action.actioncallback","layer_action.image_link","layer_action.jump_to_slide","layer_action.jump_to_slide","layer_action.link_open_in","layer_action.link_type","layer_action.scrollunder_offset","layer_action.toggle_class","layer_action.toggle_layer_type","layer_action.tooltip_event"]},

		
		{ id:"16",icon:"droplet", groupname:"Styling Text", keys:["deformation.color-transparency","deformation.font-family","deformation.font-style","deformation.opacity","deformation.text-align","deformation.vertical-align","deformation.display","deformation.text-decoration"]},
		{ id:"17",icon:"droplet", groupname:"Styling Padding", keys:["deformation.padding","deformation.padding.0","deformation.padding.1","deformation.padding.2","deformation.padding.3"]},
		{ id:"17",icon:"droplet", groupname:"Styling Margin", keys:["margin.desktop","margin.notebook","margin.tablet","margin.mobile"]},
		{ id:"18",icon:"droplet", groupname:"Styling Corners", keys:["deformation.corner_left","deformation.corner_right"]},
		{ id:"19",icon:"droplet", groupname:"Styling Background", keys:["deformation.background-color","deformation.background-transparency"]},
		{ id:"20",icon:"droplet", groupname:"Styling Border", keys:["deformation.border-color","deformation.border-radius.0","deformation.border-radius.1","deformation.border-radius.2","deformation.border-radius.3","deformation.border-style","deformation.border-transparency","deformation.border-width"]},
		{ id:"21",icon:"droplet", groupname:"Styling Transforms", keys:["deformation.2d_origin_x","deformation.2d_origin_y","deformation.parallax","deformation.pers","deformation.scalex","deformation.scaley","deformation.skewx","deformation.skewy","deformation.text-transform","deformation.x","deformation.xrotate","deformation.y","deformation.yrotate","deformation.z"]},
		
		{ id:"22",icon:"droplet", groupname:"Styling Hover", keys:["hover","deformation-hover.css_cursor","deformation-hover.easing"]},
		{ id:"23",icon:"droplet", groupname:"Styling Hover Text", keys:["deformation-hover.color","deformation-hover.color-transparency","deformation-hover.font-family","deformation-hover.font-style","deformation-hover.opacity","deformation-hover.text-align","deformation-hover.vertical-align","deformation-hover.text-decoration"]},
		{ id:"24",icon:"droplet", groupname:"Styling Hover Padding", keys:["deformation-hover.padding","deformation-hover.padding.0","deformation-hover.padding.1","deformation-hover.padding.2","deformation-hover.padding.3"]},
		{ id:"24",icon:"droplet", groupname:"Styling Hover Margin", keys:["deformation-hover.margin","deformation-hover.margin.0","deformation-hover.margin.1","deformation-hover.margin.2","deformation-hover.margin.3"]},
		{ id:"25",icon:"droplet", groupname:"Styling Hover Corners", keys:["deformation-hover.corner_left","deformation-hover.corner_right"]},
		{ id:"26",icon:"droplet", groupname:"Styling Hover Background", keys:["deformation-hover.background-color","deformation-hover.background-transparency"]},
		{ id:"27",icon:"droplet", groupname:"Styling Hover Border", keys:["deformation-hover.border-color","deformation-hover.border-radius.0","deformation-hover.border-radius.1","deformation-hover.border-radius.2","deformation-hover.border-radius.3","deformation-hover.border-style","deformation-hover.border-transparency","deformation-hover.border-width"]},
		{ id:"28",icon:"droplet", groupname:"Styling Hover Transforms", keys:["deformation-hover.2d_origin_x","deformation-hover.2d_origin_y","deformation-hover.parallax","deformation-hover.pers","deformation-hover.scalex","deformation-hover.scaley","deformation-hover.skewx","deformation-hover.skewy","deformation-hover.text-transform","deformation-hover.x","deformation-hover.xrotate","deformation-hover.y","deformation-hover.yrotate","deformation-hover.z"]},
		{ id:"29",icon:"video", groupname:"Video/Audo Settings", keys:["video_data.urlAudio","video_data.previewimage","video_data.link","video_data.thumb_medium.url", "video_type","video_data.id","video_data.video_type","video_data.title","video_data.author","video_data.description", "video_data.args","video_data.autoplay","video_data.nextslide","video_data.forcerewind","video_data.controls","video_data.mute","video_data.stopallvideo","video_data.allowfullscreen","video_data.videoloop","video_data.show_cover_pause","video_data.start_at","video_data.end_at","video_data.volume","video_data.desc_small","video_data.thumb_small.url","video_data.thumb_small.width","video_data.thumb_small.height","video_data.thumb_medium.width","video_data.thumb_medium.height","video_data.video_height"]}
		
		];
	


	t.addon_callbacks = [];	 // Array of Callbacks.  { callback: function,  parameters: [ internalpar, par1, par2, par3]}

	

		
	t.set_save_needed = function(setto){	
		
		save_needed = setto;
	}
	
	t.ulff_core = 0;
		
	t.setGlobalAction = function (glfunc){
		global_action_template = glfunc;
	}
	t.setGlobalSlideImport = function (glfunc){
		global_layer_import_template = glfunc;
	}
	
	
	t.getLayout = function() {
		return layout;
	}

	t.setInitSlideIds = function(jsonIds){ slideIDs = jQuery.parseJSON(jsonIds); }
	
	// set init layers object (from db)
	t.setInitLayersJson = function(jsonLayers){ initLayers = jQuery.parseJSON(jsonLayers); }

	// set init static layers object in non static slides, for the usage of actions (from db)
	t.setInitStaticLayersJson = function(jsonLayers){ initStaticLayers = jQuery.parseJSON(jsonLayers); }
	
	// set init demo layers object (from db)
	t.setInitDemoLayersJson = function(jsonLayers){ initDemoLayers = jQuery.parseJSON(jsonLayers); }
	
	// set init demo settings object (from db)
	t.setInitDemoSettingsJson = function(jsonLayers){ initDemoSettings = jQuery.parseJSON(jsonLayers); }

	// set init layer animations (from db)
	t.setInitLayerAnim = function(jsonLayersAnims){ initLayerAnims = jQuery.parseJSON(jsonLayersAnims); }

	// set init layer animations (from db)
	t.setInitLayerAnimsDefault = function(jsonLayersAnims){ initLayerAnimsDefault = jQuery.parseJSON(jsonLayersAnims); }

	// set all settings that need trans
	t.setInitTransSetting = function(jsonTransSett){ transSettings = jQuery.parseJSON(jsonTransSett); }

	// update init layer animations (from db)
	t.updateInitLayerAnim = function(layerAnims){
		initLayerAnims = [];
		initLayerAnims = layerAnims;
	}

	// set init captions classes array (from the captions.css)
	t.setInitCaptionClasses = function(jsonClasses){ initArrCaptionClasses = jQuery.parseJSON(jsonClasses); }
	
	t.setCaptionClasses = function(objClasses){ initArrCaptionClasses = objClasses; }

	// set init font family types array
	t.setInitFontTypes = function(jsonClasses){ initArrFontTypes = jQuery.parseJSON(jsonClasses); }
	
	// GET / SET MAIN TIME
	t.getMaintime = function() { return g_slideTime; }
	t.setMaintime = function(a) { g_slideTime = a; }
	
	// GET OBJECT LENGTH
	t.getObjectLength = function(obj) {
		var i = 0;
		for (var a in obj) {
			i++;
		}
		return i;
	}
	

	t.sortFontTypesByUsage = function(){
		for(var skey in sgfamilies){
			for(var key in initArrFontTypes){
				
				if(initArrFontTypes[key]['label'].replace(/\ /g,'+') == sgfamilies[skey].replace(/\ /g,'+')){
					//add to front
					if(typeof(initArrFontTypes[key]['top']) == 'undefined'){ //push to top and define top
						initArrFontTypes[key]['top'] = true;
						//initArrFontTypes[key]['version'] = rev_lang.google_fonts_loaded;												
					}
					break;
				}
			}
		}
		
		//reorder the keys from 1 to xxx
		var items = {};
		var i = 0;
		for(var index in initArrFontTypes) {
			items[i] = initArrFontTypes[index];
			i++;
		}
		initArrFontTypes = items;
		
		
		//reinitialize the catcomplete on the field!
		//jQuery("#css_font-family").catcomplete("option","source",initArrFontTypes);
		
	}
	
	/**
	 * SET option to object depending on which size is choosen
	 */
	t.setVal = function(obj, handle, val, setall, setspecific,set_all_force){		
		if(jQuery.inArray(handle, transSettings) !== -1){ //handle is in the list, so save only on the current choosen size
			
			if(setall){
				if(typeof(obj[handle]) !== 'object') obj[handle] = {};							
				if (set_all_force==undefined || set_all_force==false) {
					obj[handle][layout] = val;
				} else {
					obj[handle]['desktop'] = val;
					obj[handle]['notebook'] = val;
					obj[handle]['tablet'] = val;
					obj[handle]['mobile'] = val;
				}
			}else if(setspecific !== undefined && setspecific!==null){
				for(var i in setspecific){
					if(typeof(obj[handle]) !== 'undefined' && typeof(obj[handle][setspecific[i]]) !== 'undefined'){
						obj[handle][setspecific[i]] = val;
					}else{
						if(typeof(obj[handle]) === 'undefined') obj[handle] = {};
						obj[handle][setspecific[i]] = val;
					}
				}
			}else{				
				if(typeof(obj[handle]) !== 'undefined' && typeof(obj[handle][layout]) !== 'undefined'){
					obj[handle][layout] = val;
				}else{
					if(typeof(obj[handle]) === 'undefined') obj[handle] = {};
					obj[handle][layout] = val;
				}
			}
		}else{
			obj[handle] = val;
		}		
		
		return obj;
	}
	
	
	/**
	 * GET option to object depending on which size is choosen
	 */
	t.getVal = function(obj, handle,forcelayout){
		forcelayout = forcelayout===undefined ? layout : forcelayout;

		if(typeof(obj) === 'undefined') return;
		
		if(jQuery.inArray(handle, transSettings) !== -1){ //handle is in the list, so save only on the current choosen size
			if(typeof(obj[handle]) !== 'undefined' && typeof(obj[handle][forcelayout]) !== 'undefined'){				
				return obj[handle][forcelayout];
			}else{
				if(typeof(obj[handle]) !== 'undefined' && typeof(obj[handle]) !== 'object'){
					return obj[handle];
				}else{
					if(typeof(obj[handle]) !== 'undefined'){
						//return next bigger / smaller value depending on what exists. First check bigger, then check smaller
						var nextval = '',
							returnval = 'novalue',
							calcblayout = "desktop";

						switch(forcelayout){
							case 'desktop':
								if(typeof(obj[handle]['notebook']) !== 'undefined')   {
									returnval = obj[handle]['notebook'];
									calcblayout = "notebook";
								}
								else 
								if(typeof(obj[handle]['tablet']) !== 'undefined') {
									returnval =  obj[handle]['tablet'];
									calcblayout = "tablet";
								}
								else
								if(typeof(obj[handle]['mobile']) !== 'undefined') {
									returnval =  obj[handle]['mobile'];
									calcblayout = "mobile";
								}
							break;
							case 'notebook':
								if(typeof(obj[handle]['desktop']) !== 'undefined') {
									returnval =  obj[handle]['desktop'];
									calcblayout = "desktop";
								}
								else
								if(typeof(obj[handle]['tablet']) !== 'undefined') {
									returnval =  obj[handle]['tablet'];
									calcblayout = "tablet";
								}
								else
								if(typeof(obj[handle]['mobile']) !== 'undefined') {
									returnval =  obj[handle]['mobile'];
									calcblayout = "mobile";
								}
							break;
							case 'tablet':
								if(typeof(obj[handle]['notebook']) !== 'undefined') {
									returnval =  obj[handle]['notebook'];
									calcblayout = "notebook";
								}
								else
								if(typeof(obj[handle]['desktop']) !== 'undefined') {
									returnval =  obj[handle]['desktop'];
									calcblayout = "desktop";
								}
								else
								if(typeof(obj[handle]['mobile']) !== 'undefined') {
									returnval =  obj[handle]['mobile'];
									calcblayout = "mobile";
								}
							break;
							case 'mobile':
								if(typeof(obj[handle]['tablet']) !== 'undefined') {
									returnval =  obj[handle]['tablet'];
									calcblayout = "tablet";
								}
								else
								if(typeof(obj[handle]['notebook']) !== 'undefined') {
									returnval =  obj[handle]['notebook'];
									calcblayout = "notebook";
								}
								else
								if(typeof(obj[handle]['desktop']) !== 'undefined') {
									returnval =  obj[handle]['desktop'];
									calcblayout = "desktop";
								}
							break;
						}
						 
						if (returnval!='novalue') {
							/*if (handle=="top" || handle=="left") returnval = 0;
							if (handle=="align_hor") returnval = "left";
							if (handle=="align_hor") returnval = "left";*/
							return returnval;
						}

					}
					return; //returns undefined
				}
			}
		}else{
			if(typeof(obj[handle]) !== 'undefined' && typeof(obj[handle]) !== 'object'){
				return obj[handle];
			}else{				
				return;
			}
		}
	}


	/**
	 * insert template to editor
	 */
	t.insertTemplate = function(text){
		if(add_meta_into === ''){
			if(t.selectedLayerSerial == -1) return(false);
			jQuery('#layer_text').val(jQuery('#layer_text').val()+'{{'+text+'}}');
			
			t.updateLayerFromFields();
		}else{
			if(jQuery.type(add_meta_into) == "object"){
				add_meta_into.val(add_meta_into.val()+'{{'+text+'}}').trigger('change');
			}
			else {
				jQuery('input[name="'+add_meta_into+'"]').val(jQuery('input[name="'+add_meta_into+'"]').val()+'{{'+text+'}}');
			}
		}
		jQuery('#dialog_template_insert').dialog('close');
	}


	/**************************************
		-	Refresh The Grid Size 	-
	***************************************/
	t.refreshGridSize = function(){
		
		var hcl = jQuery('#hor-css-linear .helplines-offsetcontainer'),
			vcl = jQuery('#ver-css-linear .helplines-offsetcontainer'),
			grid_size = jQuery('#rs-grid-sizes option:selected').val(),
			snapto = jQuery('#rs-grid-snapto option:selected').val(),
			wrapper = jQuery('#divLayers');


		if (grid_size!="custom") {
			wrapper.css({position:"relative"});
			wrapper.find('#helpergrid').remove();
			wrapper.append('<div id="helpergrid" style="position:absolute;top:0px;left:0px;position:absolute;z-index:0;width:100%;height:100%"></div>');
			var hg = wrapper.find('#helpergrid');
			if (grid_size>4) {
				for (var i=1;i<(wrapper.height()/grid_size);i++) {
					var jump = i*grid_size;
					hg.append('<div class="helplines" style="background-color:#4affff;width:100%;height:1px;position:absolute;left:0px;top:'+jump+'px"></div>');
				}

				for (var i=1;i<(wrapper.width()/grid_size);i++) {
					var jump = i*grid_size;
					hg.append('<div class="helplines" style="background-color:#4affff;height:100%;width:1px;position:absolute;top:0px;left:'+jump+'px"></div>');
				}
			}
			punchgs.TweenLite.to(hcl,0.3,{autoAlpha:0});
			punchgs.TweenLite.to(vcl,0.3,{autoAlpha:0});
		} else {
				punchgs.TweenLite.to(hcl,0.3,{autoAlpha:1});
				punchgs.TweenLite.to(vcl,0.3,{autoAlpha:1});
				wrapper.find('#helpergrid').remove();
				try{hcl.find('.helplines').draggable("destroy");} catch(e) {}
				try{vcl.find('.helplines').draggable("destroy");} catch(e) {}
				hcl.find('.helplines').draggable({ handle:".helpline-drag", axis:"x" });
				vcl.find('.helplines').draggable({ handle:".helpline-drag", axis:"y" });
		}

		for(var key in t.arrLayers){
			var layer = t.getHtmlLayerFromSerial(key);			
			layer.draggable({
					drag: t.onLayerDrag,						
					snap: snapto,
					snapMode:"outer"

				});
		}
	}
	
	/**
	 * Add unique layer ids
	 **/
	t.add_missing_unique_ids = function(){
		var layers = t.getSimpleLayers();
		var addfor = {};
		
		//first round, check which one are missing unique IDs and set the unique_layer_id to be used by new layers
		for(var key in layers){			
			if(layers[key].unique_id === undefined){
				addfor[key] = true;
			}else{
				if(layers[key].unique_id > unique_layer_id)
					unique_layer_id = layers[key].unique_id;
			}
		}
		
		for(var key in addfor){
			unique_layer_id++;
			var objUpdate = {};
			objUpdate.unique_id = unique_layer_id;
			
			update_layer_changes = false;
			t.updateLayer(key, objUpdate);
			update_layer_changes = true;
		}
		
	}

	

	//======================================================
	//	Init Functions
	//======================================================
	t.init = function(slideTime){
		
		if(jQuery().draggable == undefined || jQuery().autocomplete == undefined)
			jQuery("#jqueryui_error_message").show();
		

		jQuery('body').addClass("rs-layer-editor-view");
		
		g_slideTime = Number(slideTime);
		u.init(g_slideTime);
		
		container = jQuery(containerID);
					
		//add all layers from init
		if(initDemoLayers){
			var len = initDemoLayers.length;
			if(len){
				for(var i=0;i<len;i++){
					for(var key in initDemoLayers[i]){
						curDemoSlideID = i;
						
						addLayer(initDemoLayers[i][key],true,true,true);
						
					}
				}
			}else{
				for(var i in initDemoLayers){
					for(var key in initDemoLayers[i]){
						curDemoSlideID = i;
						
						addLayer(initDemoLayers[i][key],true,true,true);
					
					}
				}
			}
		}

		u.organiseGroupsAndLayer(false,true)

		
		//add all layers from init
		if(initLayers){
			var len = initLayers.length;
			if(len){
				for(var i=0;i<len;i++) {							
					addLayer(initLayers[i],true,false,true);										
				}
			}else{				
				for(var key in initLayers) {										
					addLayer(initLayers[key],true,false,true);										
				}
			}			
			t.add_missing_unique_ids();								
		}
		
		// IF LAYERS ADDED, WE CAN CALCULATE THE SCROLLER
		u.timeLineTableDimensionUpdate();
		
		// One Time Refresh of TimeTable (to reset Action, Wait texts on Time Line Layers)
		
		u.updateAllLayerTimeline();
		

		
		//disable the properties box
		disableFormFields();
		
		

		
		//init elements
		initMainEvents();	// CLICK ON CONTAINER
		
		initButtons();		// MAIN BUTTONS - ADD LAYERS, DUPLICATE, DELETE
		
		initHtmlFields();	// HTML FIELD HANDLINGS
		
		initAlignTable();
		
		initLoopFunctions();
		
		scaleAndResetLayerInit();
		
		positionChanged();
		
		initBackgroundFunctions();

		
		
		// STICKY CATEGORIES FOR SCROLL SELECTORS
		jQuery('#tp-thelistofclasses ul, #tp-thelistoffonts ul').bind('scroll',function() {
			var u = jQuery(this),
				s = u.scrollTop(),
				os = u.data('olds'),
				h = u.parent().height(),
				l,
				d = os==undefined || os<s ? "up" : "down";			
			u.find('.ui-autocomplete-category').each(function(i) {
				var t = jQuery(this),
					p = t.next().position().top,
					corr = i==0 ? 0 : 15;

				if ((d=="up" && p<50) || (d=="down" && p<(0-corr))) {

					t.css({position:"absolute",top:s-(corr),zIndex:i});	
					t.next().css({marginTop:(50+corr)})			
				} else {					
					t.css({position:"relative",top:0,zIndex:i});				
					t.next().css({marginTop:0})			
				}
			});
			u.data('olds',s);			
		});


		// HIDE/SHOW MAIN IMAGE SELECTION
		jQuery('.bgsrcchanger').each(function(){
			if(jQuery(this)[0].checked)
				initSliderMainOptions(jQuery(this));
		});
		// INIT CLICK HANDLING ON MAIN IMAGE SETTINGS
		jQuery('.bgsrcchanger').click(function() {
			initSliderMainOptions(jQuery(this));
		});
		
		jQuery('#alt_option').change(function(){
			if(jQuery('#alt_option option:selected').val() == 'custom'){
				jQuery('#alt_attr').show();
			}else{
				jQuery('#alt_attr').hide();
			}
		});
		
		jQuery('#title_option').change(function(){
			if(jQuery('#title_option option:selected').val() == 'custom'){
				jQuery('#title_attr').show();
			}else{
				jQuery('#title_attr').hide();
			}
		});

		initDisallowCaptionsOnClick();



		// OPEN LEFT PANEL TO FULL
		jQuery('.open_right_panel').click(function() {
			var orp = jQuery('.layer_props_wrapper')
			if (orp.hasClass("openeed")) {
				orp.removeClass("openeed");
			} else {
				orp.addClass("openeed");
			}
		});

		jQuery('#rs-grid-sizes, #rs-grid-snapto').change(function() {
			t.refreshGridSize();
		});
		
		jQuery('#layer_alt_option').change(function(){
			if(jQuery('#layer_alt_option option:selected').val() == 'custom'){
				jQuery('#layer_alt').show();
			}else{
				jQuery('#layer_alt').hide();
			}
		});

		jQuery('select[name="rev_show_the_slides"]').change(function(){
			var nextsh = jQuery('#divbgholder').find('.slotholder');
			
			//jQuery('.demo_layer').hide();
			jQuery('.demo_layer').addClass("invisible_demolayer");

			nextsh.addClass("trans_bg");
			nextsh.css("background-image","none");
			nextsh.css("background-color","transparent");
			nextsh.css("background-position","top center");
			nextsh.css("background-size","cover"); //100% 100%
			nextsh.css("background-repeat","no-repeat");
			
			jQuery('.tp-bgimg').css({backgroundImage:"none",backgroundColor:"transparent"});
			//jQuery('#divLayers-wrapper').css({backgroundImage:"none",backgroundColor:"transparent"});
			
			
			if(jQuery(this).val() !== 'none'){
				var sv = jQuery(this).val();
				jQuery('.demo_layer_'+sv).show();
				jQuery('.demo_layer_'+sv).removeClass("invisible_demolayer");

				if(typeof initDemoSettings[sv] !== 'undefined'){
					var bgfit = (initDemoSettings[sv]['bg_fit'] == 'percentage') ? initDemoSettings[sv]['bg_fit_x'] + '% ' + initDemoSettings[sv]['bg_fit_y'] + '% ' : initDemoSettings[sv]['bg_fit'];
					var bgpos = (initDemoSettings[sv]['bg_position'] == 'percentage') ? initDemoSettings[sv]['bg_position_x'] + '% ' + initDemoSettings[sv]['bg_position_y'] + '% ' : initDemoSettings[sv]['bg_position'];

					if(initDemoSettings[sv]['bg_fit'] == 'contain'){
						jQuery('#divLayers-wrapper').css('maxWidth', jQuery('#divbgholder').css('minWidth'));
					}else{
						jQuery('#divLayers-wrapper').css('maxWidth', 'none');
					}

					switch(initDemoSettings[sv]['background_type']){
						case "image":
						case "meta":
						case "streamyoutube":
						case "streamvimeo":
						case "streaminstagram":
						case "youtube":
						case "vimeo":
						case "html5":
							var urlImage = initDemoSettings[sv]['image'];							
							jQuery('#the_image_source_url').html(urlImage);
							nextsh.find('.defaultimg, .slotslidebg').css("background-image","url('"+urlImage+"')");
							nextsh.find('.defaultimg, .slotslidebg').css("background-color","transparent");
							nextsh.find('.defaultimg, .slotslidebg').css("background-size",bgfit);
							nextsh.find('.defaultimg, .slotslidebg').css("background-position",bgpos);
							nextsh.find('.defaultimg, .slotslidebg').css("background-repeat",initDemoSettings[sv]['bg_repeat']);
							nextsh.find('.defaultimg, .slotslidebg').removeClass("trans_bg");
						break;
						case "trans":
							nextsh.find('.defaultimg, .slotslidebg').css("background-image","none");
							nextsh.find('.defaultimg, .slotslidebg').css("background-color","transparent");
							nextsh.find('.defaultimg, .slotslidebg').addClass("trans_bg");
						break;
						case "solid":
							nextsh.find('.defaultimg, .slotslidebg').css("background-image","none");
							nextsh.find('.defaultimg, .slotslidebg').removeClass("trans_bg");
							var bgColor = initDemoSettings[sv]['slide_bg_color'];
							nextsh.find('.defaultimg, .slotslidebg').css("background-color",bgColor);
						break;
						case "external":
							var urlImage = initDemoSettings[sv]['slide_bg_external'];
							jQuery('#the_image_source_url').html(urlImage);
							nextsh.find('.defaultimg, .slotslidebg').css("background-image","url('"+urlImage+"')");
							nextsh.find('.defaultimg, .slotslidebg').css("background-color","transparent");
							nextsh.find('.defaultimg, .slotslidebg').css("background-size",bgfit);
							nextsh.find('.defaultimg, .slotslidebg').css("background-position",bgpos);
							nextsh.find('.defaultimg, .slotslidebg').css("background-repeat",initDemoSettings[sv]['bg_repeat']);
							nextsh.find('.defaultimg, .slotslidebg').removeClass("trans_bg");
						break;
					}
				}
			}
			jQuery('#divbgholder').css({backgroundImage:"none",backgroundColor:"transparent"});
			//t.changeSlotBGs();
		});
			
		jQuery('#thumb_for_admin').on('change',function() {
			t.changeSlotBGs();
		});

		if (jQuery('#slide_thumb_button_preview').find('div').length>0) 
			jQuery('.show_on_thumbnail_exist').show();
		
		jQuery('.rs-slide-device_selector').click(function(){
			if(rev_adv_resp_sizes == false) return;
					
			var changeto = jQuery(this).data('val');
			layout = changeto;
			u.layout = changeto
			
			var minheight = 0;
			jQuery('.row-zone-container').each(function() {
				minheight=minheight + jQuery(this).height();
			});

			minheight = minheight <rev_sizes[changeto][1] ? rev_sizes[changeto][1] : minheight;

			jQuery('.tp-bgimg.defaultimg, #divLayers').css({
				width:rev_sizes[changeto][0], 
				height:minheight
			});
					
			if (__slidertype!="auto") {
				jQuery('#divbgholder').css({minWidth:rev_sizes[changeto][0], maxWidth:"100%", marginLeft:"auto",marginRight:"auto"});
				jQuery('#divbgholder').css({minHeight:minheight,height:minheight});
				jQuery('.slotholder .tp-bgimg.defaultimg').css({minWidth:rev_sizes[changeto][0], maxWidth:"100%" });
				jQuery('.tp-bgimg.defaultimg').css({
					width:"100%"					
				})
			} else {
				
				jQuery('#divbgholder').css({minWidth:rev_sizes[changeto][0], maxWidth:rev_sizes[changeto][0], marginLeft:"auto",marginRight:"auto"});
				jQuery('#divbgholder').css({minHeight:minheight,height:minheight});
				jQuery('.slotholder .tp-bgimg.defaultimg').css({minWidth:rev_sizes[changeto][0], maxWidth:rev_sizes[changeto][0] })

			}			
			
			jQuery('#divLayers-wrapper').css('height', minheight + 1);

			jQuery('.rs-slide-device_selector').removeClass('selected');
			
			jQuery(this).addClass('selected');
			
			//update positions of all other slides elements if static slide is selected
			u.resetSlideAnimations();
			jQuery(window).trigger("resize");			
			redrawAllLayerHtml();
			t.setMiddleRowZone(100);
			// update Background Size !!
			
		});

		
		//DESELECT ALL LAYERS WHEN CLICKED SOME NEUTRAL PLACE
		jQuery('#divbgholder .oldslotholder, #divbgholder .slotholder, #divbgholder .defaultimg, #top-toolbar-wrapper, #layer-settings-toolbar-bottom').on('click',function(e) {
			var button = e.which || e.button;
		    if ( button === 1 )  cm.toggleMenuOff();		    
			if(e.target != this) return;	
			u.checkMultipleSelectedItems(true);		
			unselectLayers();
		});


	   
		var cfith = function(layer,a) {
			layer['deformation-hover'][a] = layer['deformation'][a];
			return layer;
		}
		var cfhti = function(layer,a) {
			layer['deformation'][a] = layer['deformation-hover'][a];
			return layer;
		}
		
		//copy idle to hover
		jQuery('.copy-from-idle').click(function(){
			
			if(confirm(rev_lang.copy_styles_to_idle_from_hover)){
				var layer = t.getCurrentLayer();
				
				layer['deformation-hover']['color'] = t.getVal(layer['static_styles'], 'color');
				layer['deformation-hover']['2d_rotation'] = layer['2d_rotation'];

				layer = cfith(layer,'2d_origin_x');
				layer = cfith(layer,'2d_origin_y');				
				layer = cfith(layer,'background-color');
				layer = cfith(layer,'background-transparency');
				layer = cfith(layer,'border-color');
				layer = cfith(layer,'border-radius');
				layer = cfith(layer,'border-style');
				layer = cfith(layer,'border-transparency');
				layer = cfith(layer,'border-width');				
				layer = cfith(layer,'color-transparency');
				layer = cfith(layer,'opacity');
				layer = cfith(layer,'scalex');
				layer = cfith(layer,'scaley');
				layer = cfith(layer,'skewx');
				layer = cfith(layer,'skewy');
				layer = cfith(layer,'text-decoration');
				layer = cfith(layer,'x');
				layer = cfith(layer,'xrotate');
				layer = cfith(layer,'y');
				layer = cfith(layer,'yrotate');
				layer = cfith(layer,'z');				
				
				t.updateLayerFormFields(t.selectedLayerSerial);
				
				t.updateLayerFromFields();
			}
		});
		
		//copy hover to idle
		jQuery('.copy-from-hover').click(function(){
			if(confirm(rev_lang.copy_styles_to_hover_from_idle)){
				var layer = t.getCurrentLayer();
				layer['2d_rotation'] = layer['deformation-hover']['2d_rotation'];
				layer['static_styles'] = t.setVal(layer['static_styles'], 'color', layer['deformation-hover']['color'], false);

				layer = cfhti(layer,'2d_origin_x');
				layer = cfhti(layer,'2d_origin_y');				
				layer = cfhti(layer,'background-color');
				layer = cfhti(layer,'background-transparency');
				layer = cfhti(layer,'border-color');
				layer = cfhti(layer,'border-radius');
				layer = cfhti(layer,'border-style');
				layer = cfhti(layer,'border-transparency');
				layer = cfhti(layer,'border-width');				
				layer = cfhti(layer,'color-transparency');
				layer = cfhti(layer,'opacity');
				layer = cfhti(layer,'scalex');
				layer = cfhti(layer,'scaley');
				layer = cfhti(layer,'skewx');
				layer = cfhti(layer,'skewy');
				layer = cfhti(layer,'text-decoration');
				layer = cfhti(layer,'x');
				layer = cfhti(layer,'xrotate');
				layer = cfhti(layer,'y');
				layer = cfhti(layer,'yrotate');
				layer = cfhti(layer,'z');		
				
				t.updateLayerFormFields(t.selectedLayerSerial);
				
				t.updateLayerFromFields();
			}
		});
		
		
		jQuery('#button_css_reset').click(function(){
			var layer = t.getCurrentLayer();
			if(layer !== null){
				t.reset_to_default_static_styles(layer);

				// Reset Fields from Style Template
				updateSubStyleParameters(layer, true);
				
				t.updateLayerFromFields();
			}
		});

		var getGridDimension = function() {
			var d = jQuery('#divLayers'),
				dl = d.offset(),
				dlw = jQuery('#divLayers-wrapper').offset(),
				rp = {top:dl.top-dlw.top, left:dl.left-dlw.left, bottom:dl.top-dlw.top+d.height(),right:dl.left-dlw.left+d.width()};
			return rp;
		}

		
		function edit_content_current_layer(){

			var layer = t.getCurrentLayer();
			if(layer !== null){

				switch(layer.type){
					case 'text':
					case 'button':
						
						t.showHideContentEditor(true);
						jQuery('#quick-layers-wrapper').slideUp(300);						
						jQuery('.current-active-main-toolbar').removeClass("opened");
						jQuery('#button_show_all_layer i').removeClass("eg-icon-up").addClass("eg-icon-menu");
						jQuery('#layer_text').focus();	
						
					break;
					case 'video':
						var objVideoData = layer.video_data;
						
						//open video dialog
						UniteAdminRev.openVideoDialog(function(videoData){
							//update video layer
							var objLayer = getVideoObjLayer(videoData);
							
							t.updateCurrentLayer(objLayer);
							updateHtmlLayersFromObject(t.selectedLayerSerial);
							t.updateLayerFormFields(t.selectedLayerSerial);
							redrawLayerHtml(t.selectedLayerSerial);
							
							scaleNormalVideo();
						}, objVideoData);
					break;
					case 'image':
						if (layer.image_library==="objectlibrary") {
							jQuery('#dialog_addobj').data('changeimg',true);						
							jQuery('#dialog_addobj').data('changeimgserial',layer.serial);
							t.callObjectLibraryDialog("object");
						} else {
							UniteAdminRev.openAddImageDialog(rev_lang.select_layer_image,function(urlImage){
								var objData = {};
								objData.image_url = urlImage;
								t.updateCurrentLayer(objData);
								
								redrawLayerHtml(t.selectedLayerSerial);
								t.add_layer_change();
								scaleNormal();
							});	
						}
					break;
					case 'shape':
					break;
					case 'svg':
						//jQuery('#svg-items-filter').change();

						jQuery('#dialog_addobj').data('changesvg',true);						
						jQuery('#dialog_addobj').data('changesvgserial',layer.serial);
						t.callObjectLibraryDialog("object");

					break;
					case 'audio':
						//do audio stuff here
						var objVideoData = layer.video_data;
						
						//open video dialog
						UniteAdminRev.openVideoDialog(function(videoData){
							//update video layer							
							var objLayer = getVideoObjLayer(videoData);
							
							t.updateCurrentLayer(objLayer);
							updateHtmlLayersFromObject(t.selectedLayerSerial);
							t.updateLayerFormFields(t.selectedLayerSerial);
							redrawLayerHtml(t.selectedLayerSerial);														
							u.drawAudioMap(layer);
							
						}, objVideoData, 'audio');
					break;
					//case 'no_edit':
						//do nothing!!
					//break;
				}
			}
		}
				
		jQuery('body').on('dblclick','.layer_selected',edit_content_current_layer);


		setTimeout(function() {
			jQuery('#form_slide_params').find('input, select').on('change',function() {				
				t.set_save_needed(true);
			});
		},500);
		
		// EDIT LAYER CONTENT FROM QUICK LIST		
		jQuery('body').on('click','.button_change_image_source, .button_edit_layer, .button_change_video_settings, .button_reset_size, .button_edit_shape, .button_change_audio_settings, .button_change_svg_settings',function() {
			
			jQuery(':focus').blur(); // Blur Focused Elements first
			var b = jQuery(this),
				serial = b.closest('.layer-toolbar-li').data('serial');			
			t.setLayerSelected(serial);		
			if (b.hasClass("button_reset_size")) 
				resetCurrentElementSize();
			else	
				edit_content_current_layer();
		});

		jQuery('body').on('click','.layer-title-with-icon',function() {
			var a = jQuery(this),
				infocus = a.find('input').is(":focus");
			if (!infocus)
				jQuery(':focus').blur(); // Blur Focused Elements first
			var b = jQuery(this),
				serial = b.closest('.layer-toolbar-li').data('serial');
			
			t.setLayerSelected(serial,false,infocus);		
			
		})

		
		// EDIT LAYER CONTENT FROM MAIN TOOLBAR
		jQuery('#button_edit_layer, #button_change_video_settings,#button_change_image_source').click(edit_content_current_layer);		

		//delete layer actions:
		jQuery('body').on('click',".button_delete_layer, #button_delete_layer", function(){

			jQuery(':focus').blur(); // Blur Focused Elements first
			var b = jQuery(this);

			if(b.hasClass("button-now-disabled")) return(false);
			
			if (b.hasClass("button_delete_layer")) {
				var serial = b.closest('.layer-toolbar-li').data('serial');				
				t.setLayerSelected(serial);	
			}


			var objLayer = t.getCurrentLayer();
			
			
			if (objLayer.type==="column") return false;
					
			if ((objLayer.type==="group" || objLayer.type==="row") && t.getLayersInGroup(objLayer.unique_id).layers.length>0) {
				jQuery('#delete-full-group-dialog').dialog({
					width:600,
					open: function() {
				        // On open, hide the original submit button			        
				    },
				    buttons: [
				        {
				            text: "Remove All Layers",
				            click: function() {
				            	var list = t.getLayersInGroup(objLayer.unique_id);
				            	jQuery.each(list.layers,function(i,layer) {
				            		t.deleteLayer(layer.serial);
				            	});
				            	jQuery.each(list.columns,function(i,column) {
				            		t.deleteLayer(column.serial);
				            	});
				            	t.deleteLayer(objLayer.serial);
				            	u.organiseGroupsAndLayer(true);
				            	 jQuery( this ).dialog( "close" );
				            }			            
				        },
				        {
				            text: "Move Layers to Root",
				            click: function() {
				            	var list = t.getLayersInGroup(objLayer.unique_id);
				            	jQuery.each(list.layers,function(i,layer) {
				            		layer.p_uid = -1;
				            	});
				            	jQuery.each(list.columns,function(i,column) {
				            		t.deleteLayer(column.serial);
				            	});
				            	t.deleteLayer(objLayer.serial);
				            	u.organiseGroupsAndLayer(true);
				            	 jQuery( this ).dialog( "close" );
				            }			            
				        },
				        {
				            text: "Cancel Action",
				            click: function() {
				                jQuery( this ).dialog( "close" );
				            }
				        }
				    ]
				})
			} else {
				if(confirm(rev_lang.delete_layer)){
				
					if (b.hasClass("button_delete_layer")) {
						var serial = b.closest('.layer-toolbar-li').data('serial');				
						t.setLayerSelected(serial);	
					}
					
					//delete selected layer
					deleteCurrentLayer();
					unselectLayers();					
				}
			}
		});

		
		t.makeRowSortableDroppable();


		//DUPLICATE layer actions:
		jQuery('body').on('click',".button_duplicate_layer, #button_duplicate_layer",function(){
			jQuery(':focus').blur(); // Blur Focused Elements first
			var b = jQuery(this);

			if(b.hasClass("button-now-disabled")) return(false);
			if (b.hasClass("button_duplicate_layer")) {
				var serial = b.closest('.layer-toolbar-li').data('serial');
				
				t.setLayerSelected(serial);	
			}
			//duplicate selected layer			
			duplicateCurrentLayer();		
			
			return false;
		});


		
		t.showHideContentEditor(false);
	
		t.changeSlotBGs();
		jQuery("#hide_layer_content_editor").click(function() {
			t.showHideContentEditor(false);
		});

		jQuery('#layer_animation, #layer_endanimation').change(function(){
			
			//set values from elements if existing
			var set_anim = (jQuery(this).attr('id') == 'layer_animation') ? 'in' : 'out';
			var anim_handle = jQuery(this).val();
			
			var found = false;
			for(var key in initLayerAnims){				
				if('custom'+set_anim+'-'+initLayerAnims[key]['id'] == anim_handle){
					switch(set_anim){
						case 'in':
							setNewAnimFromObj('start', initLayerAnims[key]['params']);
						break;
						case 'out':
							setNewAnimFromObj('end', initLayerAnims[key]['params']);
						break;
					}
					found = true;
					break;
				}
			}
			
			if(found == false){
				for(var key in initLayerAnimsDefault){				
					if(key == anim_handle){
						switch(set_anim){
							case 'in':
								setNewAnimFromObj('start', initLayerAnimsDefault[key]['params']);
							break;
							case 'out':
								setNewAnimFromObj('end', initLayerAnimsDefault[key]['params']);
							break;
						}
						break;
					}
				}
			}
			
			if(set_anim == 'out' && anim_handle == 'auto'){ //check if masking is enabled for in-animation, if yes do it here, too
				if(jQuery('#masking-start')[0].checked){
					if(jQuery('#masking-start')[0].checked == true){
						jQuery('#masking-end').attr('checked', true);
						RevSliderSettings.onoffStatus(jQuery('#masking-end'));	
						jQuery('.mask-end-settings').show();
					}
				}
			}
			
			t.updateLayerFromFields();
		});

		
		jQuery('#layer_caption').change(function(){
			//check if style is existing. If not, change fields from rename to save
			if(UniteCssEditorRev.checkIfHandleExists(jQuery(this).val())){
				jQuery('#extra_style_settings').removeClass('normal_rename normal_save save_rename save_save').addClass('normal_rename');
			}else{
				jQuery('#extra_style_settings').removeClass('normal_rename normal_save save_rename save_save').addClass('normal_save');
			}
		});

		
		jQuery('.save-current-animin, .save-current-animout').click(function() {
			var what = (jQuery(this).hasClass('save-current-animin')) ? 'start' : 'end';
			var handle = (what == 'start') ? jQuery('select[name="layer_animation"] option:selected').val() : jQuery('select[name="layer_endanimation"] option:selected').val();
			
			if(handle !== 'custom'){
				for(var key in initLayerAnimsDefault){
					if(key === handle){
						alert(rev_lang.cant_modify_default_anims);
						return false;
					}
				}
			}
			var anim = {};
			
			anim['params'] = createNewAnimObj(what);
			
			if(handle == 'custom'){
				//add dialog box asking for name. Then check if name exists or is default
				jQuery('#rs-save-under-animation').val('');
				
				var objLayer = t.getCurrentLayer();
				
				if(what == 'start' && typeof(objLayer['orig-anim']) !== 'undefined') jQuery('#rs-save-under-animation').val(objLayer['orig-anim']);
				if(what == 'end' && typeof(objLayer['orig-endanim']) !== 'undefined') jQuery('#rs-save-under-animation').val(objLayer['orig-endanim']);
				
				jQuery('#dialog_save_animation').dialog({
					modal: true,
					width: 300,
					height: 200,
					resizable: false,
					create:function(ui) {				
						jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
					},
					buttons:{
						'Save':function(){
							var new_name = jQuery('#rs-save-under-animation').val();
							var new_handle = UniteAdminRev.sanitize_input(new_name);
							
							var do_insert = true;
							for(var key in initLayerAnimsDefault){
								//if(key == new_handle){
								if(initLayerAnimsDefault[key]['handle'] == new_handle){
									alert(rev_lang.name_is_default_animations_cant_be_changed);
									return false;
								}
							}
							
							for(var key in initLayerAnims){
								//if(key == new_handle){
								if(initLayerAnims[key]['handle'] == new_handle){
									do_insert = (what == 'start') ? 'customin' : 'customout';
									do_insert += '-'+initLayerAnims[key]['id'];
									break;
								}
							}
							
							anim['handle'] = new_handle;
							
							anim['params']['type'] = (what == 'start') ? 'customin' : 'customout';
							
							if(do_insert === true){
								updateAnimInDb(new_handle, anim, false);
								jQuery(this).dialog('close');
							}else{
								if(confirm(rev_lang.override_animation)){
									updateAnimInDb(do_insert, anim, true);
									jQuery(this).dialog('close');
								}
							}
						},
						'Cancel':function(){
							jQuery(this).dialog('close');
						}
					}
				});
			}else{
				anim['params']['type'] = (what == 'start') ? 'customin' : 'customout';
				
				if(confirm(rev_lang.overwrite_animation)){
					updateAnimInDb(handle, anim, true);
					//check every layer if animation is set, if yes, then update values
					
				}
			}
			
			
		});

		
		
		
		jQuery('.save-as-current-animin, .save-as-current-animout').click(function() {
			var what = (jQuery(this).hasClass('save-as-current-animin')) ? 'start' : 'end';
			
			var curAnimHandle = (jQuery(this).hasClass('save-as-current-animin')) ? jQuery('#layer_animation option:selected').val() : jQuery('#layer_endanimation option:selected').val();
			
			currentAnimationType = (jQuery(this).hasClass('save-as-current-animin')) ? 'customin' : 'customout';
			
			/*if(curAnimHandle !== 'custom'){
				for(var key in initLayerAnimsDefault){
					if(key === curAnimHandle){
						alert(rev_lang.cant_modify_default_anims);
						return false;
					}
				}
			}*/
			
			jQuery('#dialog_save_as_animation').dialog({
				modal: true,
				width: 300,
				height: 200,
				resizable: false,
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
				buttons:{
					'Save':function(){
						var new_name = jQuery('#rs-save-as-animation').val(),
							new_handle = UniteAdminRev.sanitize_input(new_name),						
							is_new_handle_existing = false,
							anim = {};
						
						for(var key in initLayerAnimsDefault){
							if(key == new_handle){
								is_new_handle_existing = true;
								break;
							}
						}
						
						for(var key in initLayerAnims){
							if(initLayerAnims[key]['handle'] == new_handle){
								is_new_handle_existing = true;
								break;
							}
						}
						
						if(is_new_handle_existing){
							alert(rev_lang.anim_with_handle_exists);
							return false;
						}
						
						anim['params'] = createNewAnimObj(what);
						anim['handle'] = new_handle;
						anim['params']['type'] = currentAnimationType;
						
						updateAnimInDb(new_handle, anim, false);
						jQuery(this).dialog('close');
					},
					'Cancel':function(){
						jQuery(this).dialog('close');
					}
				}
			});

		
			
		});
		
		//jQuery('.rename-current-anim').click(function() {
		jQuery('.rename-current-animin, .rename-current-animout').click(function() {
			var curAnimHandle = (jQuery(this).hasClass('rename-current-animin')) ? jQuery('#layer_animation option:selected').val() : jQuery('#layer_endanimation option:selected').val();
			var curAnimText = (jQuery(this).hasClass('rename-current-animin')) ? jQuery('#layer_animation option:selected').text() : jQuery('#layer_endanimation option:selected').text();
			
			if(curAnimHandle !== 'custom'){
				for(var key in initLayerAnimsDefault){
					if(key === curAnimHandle){
						alert(rev_lang.cant_modify_default_anims);
						return false;
					}
				}
			}
			if(curAnimHandle == 'custom') return false;
			
			var curAnimID = curAnimHandle.replace('customin-', '').replace('customout-', '');
			
			jQuery('#rs-rename-animation').val(curAnimText);
			
			jQuery('#dialog_rename_animation').dialog({
				modal: true,
				width: 300,
				height: 200,
				resizable: false,
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
				buttons:{
					'Rename':function(){
						var new_name = jQuery('#rs-rename-animation').val(),
							new_handle = UniteAdminRev.sanitize_input(new_name),						
							is_found = false,
							is_new_handle_existing = false;
						
						for(var key in initLayerAnimsDefault){
							if(key == new_handle){
								is_new_handle_existing = true;
								break;
							}
						}
						
						var id = '';
						
						for(var key in initLayerAnims){
							if(key == new_handle) is_new_handle_existing = true;
							if(initLayerAnims[key]['id'] == curAnimID){
								is_found = true;
								id = initLayerAnims[key]['id'];
								break;
							}
						}
						
						if(is_new_handle_existing){
							alert(rev_lang.anim_with_handle_exists);
							return false;
						}
						
						if(is_found){
							renameAnimInDb(id, new_handle);
							
							jQuery(this).dialog('close');
							return false;
						}
					},
					'Cancel':function(){
						jQuery(this).dialog('close');
					}
				}
			});
		});
		
		//jQuery('#delete-current-start-anim, #delete-current-end-anim').click(function(){
		jQuery('#delete-current-animin, #delete-current-animout').click(function(){
			var curAnimHandle = (jQuery(this).attr('id') == 'delete-current-animin') ? jQuery('#layer_animation').val() : jQuery('#layer_endanimation').val();
			var curAnimText = (jQuery(this).attr('id') == 'delete-current-animin') ? jQuery('#layer_animation option:selected').text() : jQuery('#layer_endanimation option:selected').text();

			var isOriginal = (curAnimHandle.indexOf('custom') > -1) ? false : true;

			if(isOriginal || curAnimHandle == 'custom'){
				alert(rev_lang.default_animations_cant_delete);
			}else{
				if(confirm(rev_lang.really_delete_anim+' "'+curAnimText+'"?')){
					deleteAnimInDb(curAnimHandle);
				}
			}

		});

		//SHOW / HIDE EXTRA ANIMATION SETTINGS
		jQuery('#add_customanimation_in').click(function() {
			currentAnimationType = 'customin';
			var btn = jQuery(this);

			var sc = jQuery('#extra_start_animation_settings'),
				ec = jQuery('#extra_end_animation_settings');
			if (sc.css("display")=="block") {
				sc.hide(200);
				btn.removeClass("selected");
			} else {
				sc.show(200);
				btn.addClass("selected");				
			}
			ec.hide(200);
		});


		jQuery('#add_customanimation_out').click(function() {
			currentAnimationType = 'customout';
			var btn = jQuery(this);
			var sc = jQuery('#extra_start_animation_settings'),
				ec = jQuery('#extra_end_animation_settings');
			if (ec.css("display")=="block") {
				ec.hide(200);
				btn.removeClass("selected");				
			} else {
				ec.show(200);
				btn.addClass("selected");				
			}
			sc.hide(200);

		});
		
		
		jQuery('#reset-current-animin, #reset-current-animout').click(function(){
			var what = (jQuery(this).hasClass('reset-current-animin')) ? 'start' : 'end';

			var objLayer = t.getCurrentLayer();

			if(what == 'start' && typeof(objLayer['orig-anim-handle']) !== 'undefined'){
				jQuery('#layer_animation option[value="'+objLayer['orig-anim-handle']+'"]').attr('selected', true).change();
			}
			if(what == 'end' && typeof(objLayer['orig-endanim-handle']) !== 'undefined'){
				jQuery('#layer_endanimation option[value="'+objLayer['orig-endanim-handle']+'"]').attr('selected', true).change();
			}
		});
		
		
		jQuery('#button_edit_css, #style-morestyle, .close_extra_settings').click(function() {
			
			var es = jQuery('#extra_style_settings'),
				btn = jQuery('#button_edit_css'),
				mainbt = jQuery("#style-morestyle");
				
			if (es.css("display")=="block") {
				es.hide(200);
				btn.removeClass("selected");
				mainbt.removeClass("showmore");
			} else {
				es.show(200);
				btn.addClass("selected");
				mainbt.addClass("showmore");				
			}
		});

		


		// SWITCH BACK AND FORWARDS BETWEEN SETTINGS AND SAVE DPENEDING IF RENAME OF SAVE BUTTON IS VISIBLE
		jQuery('.rename-current-css').click(function() {
			
			jQuery('#rs-rename-css').val(jQuery('#layer_caption').val());
			
			jQuery('#dialog_rename_css').dialog({
				modal:true,
				resizable:false,
				width:400,
				closeOnEscape:true,
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
				buttons:{
					'Rename':function(){
						jQuery('#rs-rename-css').val(UniteAdminRev.sanitize_input(jQuery('#rs-rename-css').val()));
						var new_css_name = jQuery('#rs-rename-css').val();
						if(new_css_name != ''){
							var curStyleName = jQuery('#layer_caption').val();
							
							var	is_existing = UniteCssEditorRev.checkIfHandleExists(new_css_name);
							var	is_existing_old = UniteCssEditorRev.checkIfHandleExists(curStyleName);
							
							if(is_existing_old === false){ alert(rev_lang.css_orig_name_does_not_exists); return false; }
							
							if(is_existing !== false || curStyleName == new_css_name){ alert(rev_lang.css_name_already_exists); return false; } //cant rename to another existing name
							
							UniteCssEditorRev.renameStylesInDb(curStyleName, new_css_name);
						}
					}
				}
			});
			
		});
		
		
		/**
		 * Save As Current CSS
		 **/
		jQuery('.save-as-current-css').click(function() {
			//modal with selection of new style name
			jQuery('#rs-save-as-css').val(jQuery('#layer_caption').val());
			
			jQuery('#dialog_save_as_css').dialog({
				modal:true,
				resizable:false,
				width:400,
				closeOnEscape:true,
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
				buttons:{
					'Save':function(){
						jQuery('#rs-save-as-css').val(UniteAdminRev.sanitize_input(jQuery('#rs-save-as-css').val()));
						var new_css_name = jQuery('#rs-save-as-css').val();
						if(new_css_name != ''){
							
							var	is_existing = UniteCssEditorRev.checkIfHandleExists(new_css_name);
							if(is_existing !== false){ alert(rev_lang.css_name_already_exists); return false; } //cant rename to another existing name
							
							UniteCssEditorRev.saveStylesInDb(new_css_name, true, jQuery('#dialog_save_as_css'));
						}
					}
				}
			});
			
		});
		
		
		/**
		 * Delete Current CSS
		 **/
		jQuery('.delete-current-css').click(function() {
			if(confirm(rev_lang.delete_this_caption) === false) return false;
			
			var curStyleName = jQuery('#layer_caption').val();
			
			var	is_existing = UniteCssEditorRev.checkIfHandleExists(curStyleName);
			if(is_existing === false){ alert(rev_lang.css_name_does_not_exists); return false; } //cant rename to another existing name
			
			//rename the css name or create new one depending on what is set
			UniteCssEditorRev.deleteStylesInDb(curStyleName, is_existing);
			
		});
		
		
		/**
		 * Save Current CSS
		 **/
		jQuery('.save-current-css').click(function() {
			if(confirm(rev_lang.this_will_change_the_class)){
				var save_handle = jQuery('#layer_caption').val();
				var id = UniteCssEditorRev.checkIfHandleExists(save_handle);
				
				if(id !== false){ //update existing style
					UniteCssEditorRev.saveStylesInDb(save_handle, false);
				}else{ //save as new
					UniteCssEditorRev.saveStylesInDb(save_handle, true);
				}
			}
		});


		jQuery('.reset-current-css').click(function() {
			
			jQuery('input[name="rs-css-set-on[]"]').each(function(){
				jQuery(this).attr('checked', true);
			});
			jQuery('input[name="rs-css-include[]"]').each(function(){
				jQuery(this).attr('checked', true);
			});
			
			var layer = t.getCurrentLayer();
			if(layer.style !== undefined){
				//open modal and ask for changes
				jQuery('#dialog-change-style-from-css').dialog({
					buttons:{'OK':function(){
						//check what should be updated on which device types
						var is_allowed = false,
							set_to = {'device':[],'include':[]};
						
						jQuery('input[name="rs-css-set-on[]"]').each(function(){
							if(jQuery(this)[0].checked){
								is_allowed = true;
								set_to['device'].push(jQuery(this).val());
							}
						});
						
						jQuery('input[name="rs-css-include[]"]').each(function(){
							if(jQuery(this)[0].checked){
								set_to['include'].push(jQuery(this).val());
							}
						});
						
						if(!is_allowed){
							alert(rev_lang.select_at_least_one_device_type);
							return true;
						}
						
						layer.style = jQuery('#layer_caption').val();
						
						
						//update values that can be set without changing the class
						t.reset_to_default_static_styles(layer, set_to['include'], set_to['device']);
						// Reset Fields from Style Template
						
						updateSubStyleParameters(layer, true);
						
						jQuery('#layer_caption').change();
						
						t.updateLayerFromFields();

						jQuery('#dialog-change-style-from-css').dialog('close');
					},'Close':function(){
						jQuery('#dialog-change-style-from-css').dialog('close');
					}},
					minWidth: 275,
					minHeight: 365,
					modal: true,
					dialogClass: 'tpdialogs',
					create:function(ui) {				
						jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
					},
					close: function( event, ui ){
					},
					open:function() {
						jQuery('.rs-style-device_input').each(function() {
							var inp = jQuery(this);
							if (inp.attr('checked')==="checked")
								inp.siblings('.rs-style-device_selector_prev').addClass("selected");
							else 
								inp.siblings('.rs-style-device_selector_prev').removeClass("selected");
						})
					}
				});
				
			}
		});

		jQuery('body').on('click change','.rs-style-device_input',function() {
			var inp = jQuery(this);
			if (inp.attr('checked')==="checked")
				inp.siblings('.rs-style-device_selector_prev').addClass("selected");
			else 
				inp.siblings('.rs-style-device_selector_prev').removeClass("selected");
		});




		// TAB CHANGES IN SLIDER SETTINGS AND IN ANIMATION EXTRAS
		jQuery('.rs-layer-animation-settings-tabs li, .rs-layer-settings-tabs li').click(function() {

			var tn = jQuery(this),
				tw = tn.closest('ul').find('.selected');
			jQuery(tw.data('content')).hide(0);
			tw.removeClass("selected");
			tn.addClass("selected");
			jQuery(tn.data('content')).show(0);
			
			if(tn.data('content') == '#rs-hover-content-wrapper'){
				//4 u kriki
			}
			
		});

		// MOUSE MOVE SHOULD MOVE THE SMALL BLUE LINES ON RULERS
		jQuery('body').on('mousemove','#thelayer-editor-wrapper',function(event) {

			var mx = event.pageX - jQuery(this).offset().left,
				my = event.pageY - jQuery(this).offset().top,
				dl = jQuery('#divLayers'),
				l = parseInt(dl.offset().left,0) - parseInt(jQuery('#thelayer-editor-wrapper').offset().left,0);

			jQuery('#verlinie').css({left:mx+"px"});
			jQuery('#horlinie').css({top:my+"px"});

			jQuery('#verlinetext').html(Math.round(mx-l));
			jQuery('#horlinetext').html(Math.round(my-90));

			jQuery('#hor-css-linear .helplines-offsetcontainer').data('x',event.pageX-jQuery('#hor-css-linear .helplines-offsetcontainer').offset().left);
			jQuery('#hor-css-linear .helplines-offsetcontainer').data('y',my);
		});

		// ON CLICK DRAW SOME HELP GRID LINES
		jQuery('#hor-css-linear, #ver-css-linear, #verlinie, #horlinie').click(function() {
			var hcl = jQuery('#hor-css-linear .helplines-offsetcontainer'),
				vcl = jQuery('#ver-css-linear .helplines-offsetcontainer'),
				x = hcl.data('x'),
				y = hcl.data('y')-40,
				ph = jQuery('#thelayer-editor-wrapper').outerHeight(true),
				pw = jQuery('#thelayer-editor-wrapper').outerWidth(true);

			jQuery('#helpergrid').remove();
			jQuery('#rs-grid-sizes').val('custom');
			punchgs.TweenLite.to(hcl,0.3,{autoAlpha:1});
			punchgs.TweenLite.to(vcl,0.3,{autoAlpha:1});

			if (y<40 && x>0)
				hcl.append('<div class="helplines" data-left="'+x+'" data-top="'+y+'" style="position:absolute;width:1px;height:'+(ph-41)+'px;background:#4AFFFF;left:'+x+'px;top:-15px"><i class="helpline-drag eg-icon-move"></i><i class="helpline-remove eg-icon-cancel"></i></div>');
			if (x<40 && y>0)
				vcl.append('<div class="helplines" data-left="'+x+'" data-top="'+y+'"  style="position:absolute;width:'+(pw-35)+'px;height:1px;background:#4AFFFF;top:'+y+'px;left:-15px"><i class="helpline-drag eg-icon-move"></i><i class="helpline-remove eg-icon-cancel"></i></div>');

			try{hcl.find('.helplines').draggable("destroy");} catch(e) {}
			try{vcl.find('.helplines').draggable("destroy");} catch(e) {}
			hcl.find('.helplines').draggable({ handle:".helpline-drag", axis:"x" });
			vcl.find('.helplines').draggable({ handle:".helpline-drag", axis:"y" });
		});

		// REMOVE HELPLINE MOVERS
		jQuery('body').on("click",".helpline-remove",function() {
			jQuery(this).parent().remove();
		});

		

		jQuery('.extra_sub_settings_wrapper').addClass("normal_rename");

		jQuery('#extra_start_animation_settings input, #extra_end_animation_settings input').change(function(){
			if(jQuery(this).attr('id') === 'new_start_animation_name' || jQuery(this).attr('id') === 'new_end_animation_name') return false;

			var my_sel = (currentAnimationType == 'customin') ? jQuery('#layer_animation') : jQuery('#layer_endanimation'); //customout
			if(currentAnimationType == 'customin')
				jQuery(this).closest('.extra_start_animation_settings').removeClass('normal_rename normal_save save_rename save_save').addClass('normal_save');
			else
				jQuery(this).closest('.extra_end_animation_settings').removeClass('normal_rename normal_save save_rename save_save').addClass('normal_save');
			
			var original = my_sel.find('option:selected').text();
			var original_handle = my_sel.find('option:selected').val();
			if(my_sel.find('option:selected').val() !== 'custom'){
				my_sel.find('option[value="custom"]').attr('selected', true).change();
				//set animation fallback to the original
				if(currentAnimationType == 'customin')
					t.updateCurrentLayer({'animation':'custom','orig-anim':original,'orig-anim-handle':original_handle});
				else
					t.updateCurrentLayer({'endanimation':'custom','orig-endanim':original,'orig-endanim-handle':original_handle});
					
			}
		});


		jQuery('#extra_style_settings input, #extra_style_settings select').change(function(){
			if(jQuery(this).attr('id') === 'overwrite_style_name' || jQuery(this).attr('id') === 'new_style_name') return false;
			jQuery('#extra_style_settings').removeClass('normal_rename normal_save save_rename save_save').addClass('normal_save');
		});
		
		// CHANGES ON BACKGROUND ELEMENTS SHOULD REDRAW THE SLIDE TIMELINE 
		jQuery('input[name="background_type"], #slide_bg_fit, input[name="bg_fit_x"], input[name="bg_fit_y"], #slide_bg_position,input[name="bg_position_x"],input[name="bg_position_y"],#slide_bg_repeat ').change(function() {
			t.changeSlotBGs();
		})

				
		jQuery('body').on('blur','.timer-layer-text',function() {
			
			t.updateLayerFromFields(); 			
		});

		jQuery('#the_current-editing-layer-title').on('blur',function() {
			//var objLayer = t.selectedLayerSerial === -1 ? "" : t.getLayer(t.selectedLayerSerial);
			//objLayer.alias = jQuery(this).val();
			jQuery('#layer_sort_'+t.selectedLayerSerial+">.layer_sort_inner_wrapper .timer-layer-text").val(jQuery(this).val());
			
			t.updateLayerFromFields();
		});

		jQuery('body').on('blur','.layer-title-in-list',function() {			
			var serial = jQuery(this).closest('li').data('serial');		
			if (serial===undefined || serial==="") return false;	
			jQuery('#layer_sort_'+serial+" "+'>.layer_sort_inner_wrapper .timer-layer-text').val(jQuery(this).val());
			var objUpdate= {};
			objUpdate.alias = jQuery(this).val();			
			t.updateLayerFromFields();
		});


		// LOCK / UNLOCK / 
		jQuery('body').on("click",'.quick-layer-lock',function() {
			var b = jQuery(this),
				i = b.find('i'),
				p = b.closest('.layer-toolbar-li'),				
				serial = p.data('serial'),
				htmllayer = t.getHtmlLayerFromSerial(serial);

			if (serial===undefined || serial==="") return false;
									
			if(u.isLayerLocked(htmllayer)) {
				u.unlockLayer(serial);	
				jQuery('.layer-toolbar-li').each(function() {
					var li = jQuery(this);
					if (li.data('serial')==serial) {
						var b=li.find('.quick-layer-lock'),
							i=b.find('i');
						b.addClass("in-on").removeClass("in-off");
						i.removeClass("eg-icon-lock").addClass("eg-icon-lock-open");	
					}
				});	
			} else {
				u.lockLayer(serial);	
				jQuery('.layer-toolbar-li').each(function() {
					var li = jQuery(this);
					if (li.data('serial')==serial) {
						var b=li.find('.quick-layer-lock'),
							i=b.find('i');
						b.addClass("in-off").removeClass("in-on");
						i.removeClass("eg-icon-lock-open").addClass("eg-icon-lock");		
					}
				});				
			}
		});

		// VIEW / UNVIEW ELEMENTS
		jQuery('body').on("click",'.quick-layer-view',function() {
			var b = jQuery(this),				
				p = b.closest('.layer-toolbar-li'),
				serial = p.data('serial');

			if (serial===undefined || serial==="") return false;
			var	objLayer = t.getLayer(serial);
			
			
			if(u.isLayerVisible(objLayer.references.htmlLayer)){				
				objLayer.visible = false;
				u.hideLayer(objLayer);
				jQuery('.layer-toolbar-li').each(function() {
					var li = jQuery(this);
					if (li.data('serial')==serial) {
						var b=li.find('.quick-layer-view'),
							i=b.find('i');
						b.addClass("in-off").removeClass("in-on");
						i.removeClass("eg-icon-eye").addClass("eg-icon-eye-off");
					}
				});				
			}else{
				objLayer.visible = true;
				u.showLayer(objLayer);
				jQuery('.layer-toolbar-li').each(function() {
					var li = jQuery(this);
					if (li.data('serial')==serial) {
						var b=li.find('.quick-layer-view'),
							i=b.find('i');
						b.addClass("in-on").removeClass("in-off");				
						i.removeClass("eg-icon-eye-off").addClass("eg-icon-eye");		
					}		
				});
			}
		});

		jQuery('.rs-row-break-selector').click(function() {
			var _t = jQuery(this);
			jQuery('.rs-row-break-selector.selected').removeClass('selected');
			_t.addClass("selected");
			jQuery('#column_break_at option:selected').prop('selected',false);
			jQuery('#column_break_at option[value="'+_t.data("val")+'"]').attr('selected','selected');
			var objUpdate = {};
			objUpdate["column_break_at"] = _t.data("val");
			t.updateLayer(t.selectedLayerSerial,objUpdate,false,true)

		});

		// GROUP / COLUMNG HANDLING
		jQuery('#rs-check-row-layout').click(function(){
						
			//get current selected layer 
			var row_layer = t.getCurrentLayer();
			
			//check if layer is a row and can have columns
			if(row_layer.type !== 'row') return false;
			
			var rl = jQuery('input[name="rs-row-layout"]').val(),						
				rl_san = rl.replace(/[^\d\+\/ ]/gi, ''); //remove all but numbers, / and +

			jQuery('input[name="rs-row-layout"]').val(rl_san);
			
			if(rl !== rl_san){
				alert('Wrong format, please enter for example 1/2 + 1/4 + 1/4');
				return false;
			}
			
			//now check if the calculation is 1, if not then error_get_last
			var result = eval(rl_san);
			result = Math.ceil(result*100000000000000) / 100000000000000;

					
			if(result !== 1){
				alert('The columns have to be added up to 1, so for example 1/2 + 1/8 is lower than 1');
				return false;
			}

			
			t.ignorAllUndoRedoLogs = true;

			//check how many columns we have and how big they are
			var columns_f = rl_san.split('+'),						
				columns = new Array(),
				undeleted_columns = new Array(),
				deleted_columns = new Array();
						
			//Collect Columns in the Current ROW			
			jQuery.each(t.arrLayers, function(index,objLayer) {
				if(objLayer.type === "column" && objLayer.p_uid == row_layer.unique_id) {
					columns.push(objLayer);			
					if (objLayer.deleted!==true) undeleted_columns.push(objLayer);			
					if (objLayer.deleted===true) deleted_columns.push(objLayer);
				}
			});
						
			if(columns_f.length > undeleted_columns.length){ //new has more
				//add columns until even
				var availablecolumns = 0;				
				for(var i = columns.length; i < columns_f.length; i++){
					var c_objLayer = {
						type: "column",
						text: initColumnName + (id_counter +1),
						p_uid: row_layer.unique_id,
						column_size: columns_f[i],
						createdOnInit: false
					}
					addLayer(c_objLayer);
					availablecolumns++;
				}
												
				for (var i=0;i<deleted_columns.length;i++) {							
					if (availablecolumns<columns_f.length-1) {						
						var objData = { deleted:false};
						t.updateLayer(deleted_columns[i].serial,objData,false,true)
						deleted_columns[i].deleted = false;
						deleted_columns[i].references.htmlLayer.removeClass("layer-deleted");
						deleted_columns[i].references.quicklayer.removeClass("layer-deleted");
						deleted_columns[i].references.sorttable.layer.removeClass("layer-deleted");
						deleted_columns[i].references.sorttable.timeline.removeClass("layer-deleted");
					}
					availablecolumns++;
				}
				
			}else if(columns_f.length < undeleted_columns.length){ //new has less
				// Remove highest Columsn 1by1 and move Layers to last available Column						
				for(var i = undeleted_columns.length; i > columns_f.length; i--){
					//check the columns, remove the highest unique_id and save all the layers by moving them to the column before
					var highest = 0,
						second = 0;

					jQuery.each(undeleted_columns, function(index,column) {						
						if (column!=undefined && column.unique_id > highest && column.deleted===false) {
							second = highest;
							highest = column.unique_id;
						}
					});					
					jQuery.each(t.arrLayers, function(index,objLayer) {						
						if (objLayer.p_uid === highest) objLayer.p_uid = second;						
						if (objLayer.unique_id === highest) t.deleteLayer(objLayer.serial);						
					});									
				}
				
			}else{ //same amount
				
			}						
			var i = 0;
			//set the column sizes
			jQuery.each(t.arrLayers, function(index,objLayer){			
				if(objLayer.p_uid == row_layer.unique_id && objLayer.deleted===false && i<columns_f.length){			
					objLayer.column_size = columns_f[i];
					i++;
				}
			})
			t.ignorAllUndoRedoLogs = false;
			u.organiseGroupsAndLayer(u);
			u.allLayerToIdle();
			t.makeRowSortableDroppable();
			t.setLayerSelected(row_layer.serial);
			row_layer.references.htmlLayer.find('.row_editor').addClass("open_re");			
			
			jQuery('#rs-layout-row-composer').show(); //.appendTo(row_layer.references.htmlLayer.find('.row_toolbar'));
			u.timeLineTableDimensionUpdate();
			t.hideRowLayoutComposer();

		});
		
		//change image actions
		jQuery("#button_change_background_image, #button_change_background_image_objlib").click(function(){
			var layer = t.getCurrentLayer();
			if(layer !== null){
				if (jQuery(this).attr('id') == 'button_change_background_image_objlib') {
					layer.image_library = "objectlibrary";
					jQuery('#dialog_addobj').data('changeimg',true);						
					jQuery('#dialog_addobj').data('changeimgserial',layer.serial);
					t.callObjectLibraryDialog("layer");
				} else {
					delete(layer.image_library);
					UniteAdminRev.openAddImageDialog(rev_lang.select_layer_image,function(urlImage){
						switchLayerBackground({bgimage_url:urlImage});
					});	
				}
			}
		});	//change image click.
		
		jQuery("#button_clear_background_image").click(function(){			
				switchLayerBackground({bgimage_url:""});
			
		});
		
		t.sortFontTypesByUsage();
		t.cloneArrLayers();
		// INIT CONTEXT MENU
		cm.init();
		
	}

	/***
	 * 	SET Dimension of Slide based on Rows New 
	 */
	t.extendSlideHeightBasedOnRows = function() {
			var minheight = 0;
			if (typeof rev_sizes =="undefined" || rev_sizes===undefined) return;
			jQuery('.row-zone-container').each(function() {
				var _t=jQuery(this);
				if (!_t.hasClass("emptyzone"))
					minheight=minheight + _t.height();
			});
			minheight = minheight <rev_sizes[layout][1] ? rev_sizes[layout][1] : minheight;		

			jQuery('.tp-bgimg.defaultimg, #divLayers').each(function() {
				var _ = jQuery(this);
				if (!jQuery(this).hasClass("slide-transition-example"))
					_.css({height:minheight});
			});
			
			if (__slidertype!="auto")
				jQuery('#divbgholder').css({minHeight:minheight,height:minheight});				
			else								
				jQuery('#divbgholder').css({minHeight:minheight,height:minheight});							
			jQuery('#divLayers-wrapper').css('height', minheight + 1);
			
			/*u.resetSlideAnimations();
			jQuery(window).trigger("resize");			
			redrawAllLayerHtml();
			t.setMiddleRowZone(100);*/
		}

	
	/***
	 * Returns all Layers and Columns within a Group 
	 */
	t.getLayersInGroup = function(unique_id) {
		var list = {
			layers : [],
			columns : []
		};
		// Find All Columns
		jQuery.each(t.arrLayers,function(index,objLayer) {
			if (objLayer.p_uid === unique_id && objLayer.type==="column")
				list.columns.push(objLayer);
		});
		// Find All Layers in Group and Columns
		jQuery.each(t.arrLayers,function(index,objLayer) {
			if (objLayer.p_uid === unique_id && objLayer.type!=="column")
				list.layers.push(objLayer);
			for (var i=0;i<list.columns.length;i++) {				
				if (list.columns[i].unique_id === objLayer.p_uid) {					
					list.layers.push(objLayer);
				}
			}
		});		
		return list;
	}
	
	t.makeRowSortableDroppable = function() {
		
		//Dropable and Sortable Elements in Rows and Columns
		jQuery('#divLayers, .tp_layer_group_inner_wrapper .slide_layer_type_column, .slide_layer_type_group .tp_layer_group_inner_wrapper').droppable({
			refreshPositions:true,
			tolerance:"pointer",
			accept:".slide_layer_type_text, .slide_layer_type_image, .slide_layer_type_video, .slide_layer_type_shape, .slide_layer_type_audio, .slide_layer_type_svg, .slide_layer_type_button",
			over:function(event,ui) {
				var col = jQuery(event.target);
				jQuery('.slide_layer_type_column, .slide_layer_type_row, .slide_layer_type_group').removeClass("layer_selected").removeClass('layerchild_selected');
				if (col[0].id!=="divLayers") {
					punchgs.TweenLite.set(col,{zIndex:0});
					col.addClass("layer_selected").addClass('layerchild_selected');
				}
				if (event.target.id!=="divLayers");
					col.closest('.slide_layer_type_row, .slide_layer_type_group').addClass("layer_selected");				
				col.closest('.row-zone-container').addClass('layerrow_selected');

				
				
			},
			out:function(event,ui) {
				var col = jQuery(event.target);		
				punchgs.TweenLite.set(col,{zIndex:1});
				if (col[0].id!=="divLayers")		
					col.removeClass("layer_selected").removeClass('layerchild_selected');
				col.closest('.layer_selected').removeClass("layer_selected").removeClass('layerchild_selected');
				col.find('.layer_selected').removeClass("layer_selected").removeClass('layerchild_selected');	
				col.closest('.row-zone-container').removeClass('layerrow_selected');	
				jQuery(ui.draggable).addClass("layer_selected");
				
				//if (ui.draggable[0].parentNode.id!=="divLayers") jQuery('#divLayers').addClass("readytodrop");

			},
			drop:function(event,ui) {		
				
				jQuery(ui.draggable).data('dropin',jQuery(event.target));											
				t.setMiddleRowZone(100);
				t.checkRowZoneContents();
				jQuery('.row-zone-container').removeClass("nowyouseeme");
				jQuery('.row-zone-container').removeClass('layerrow_selected');
				
			}
		});

		jQuery('#row-zone-top, #row-zone-middle, #row-zone-bottom').sortable({
			refreshPositions:true,
			handle:".row_moveme",			
			start:function(event,ui) {
				
				ui.placeholder.html(ui.item.html());
				jQuery('.row-zone-container').addClass("nowyouseeme");
				jQuery('.row-zone-container').addClass('layerrow_selected');
				
			},
			stop:function(event,ui) {
				
				jQuery('.row-zone-container').removeClass("nowyouseeme");
				jQuery('.row-zone-container').removeClass('layerrow_selected');
				t.setRowZoneOrders();
				u.organiseGroupsAndLayer();
			},
			update:function(event,ui) {				
				var objLayer = t.getLayer(t.selectedLayerSerial);
				switch (ui.item[0].parentNode.id) {
					case "row-zone-top":
						objLayer = t.setVal(objLayer, 'align_vert', "top", true);						
					break;
					case "row-zone-middle":
						objLayer = t.setVal(objLayer, 'align_vert', "middle", true);						
					break;
					case "row-zone-bottom":
						objLayer = t.setVal(objLayer, 'align_vert', "bottom", true);						
					break;
				}								
				//t.setInnerGroupOrders(jQuery('#'+ui.item[0].parentNode.id));
				t.setRowZoneOrders();
				u.organiseGroupsAndLayer();
				t.updateLayerFormFields(objLayer.serial);
				t.setMiddleRowZone(100);
				t.checkRowZoneContents();
				


			},
			sort:function(event,ui) {
				
			}
		})

		jQuery('.slide_layer_type_column .tp_layer_group_inner_wrapper').sortable({
			refreshPositions:true,	
			placeholder:'layer_placeholder_in_column',
			start:function(event,ui) {				

				jQuery('.slide_layer_type_column, .slide_layer_type_row').removeClass("layer_selected").removeClass('layerchild_selected');
				jQuery('.row-zone-container').removeClass('layerrow_selected');
				ui.placeholder.html(ui.item.html());
				var img = ui.placeholder.find('.innerslide_layer>img');
				if (img.length>0) {
					img.css({width:ui.item.width(), height:ui.item.height()});
				}
			},		
			items:"> .slide_layer_type_text, > .slide_layer_type_image, > .slide_layer_type_video, > .slide_layer_type_shape, > .slide_layer_type_audio, > .slide_layer_type_svg, > .slide_layer_type_button",		
			cancel:	".slide_layer_type_row, .slide_layer_type_column, .slide_layer_type_group",
			update:function(event,ui) {				
				t.setInnerGroupOrders(jQuery(ui.item[0].parentNode));
				t.setMiddleRowZone(100);
				
			},
			sort:function(event,ui) {
				var a = jQuery(event.target);
				a.closest('.slide_layer_type_column').addClass("layer_selected").addClass('layerchild_selected');
				a.closest('.slide_layer_type_row').addClass("layer_selected");
				
			}
		});
	}

	t.setRowZoneOrders = function() {
		t.setInnerGroupOrders(jQuery('#row-zone-top'));
		t.setInnerGroupOrders(jQuery('#row-zone-middle'));
		t.setInnerGroupOrders(jQuery('#row-zone-bottom'));
	}

	t.setInnerGroupOrders = function (container) {				
		
		var order = container.sortable('toArray',{attribute:"data-uniqueid"});						
		for (var i=0;i<order.length;i++) {
			 var objUpdate = {groupOrder:i};												 
			 t.updateLayer(t.getLayerByUniqueId(order[i]).serial,objUpdate,false,true);							 
		}				
		
	}



	t.droppedContainerCheck = function (objLayer){
		
		
		var htmllayer = objLayer.references.htmlLayer,
			dropcontainer = htmllayer.data('dropin'),
			p_uid;
				
		if (objLayer.type==="row" || objLayer.type==="column" || objLayer.type==="group") {
			// Ignoe Drop. Return to old containerwe 					
		} else {			
			
			// ELEMENT IS DROPPED INTO A GROUP

			if (dropcontainer !=undefined && dropcontainer[0].classList.contains("tp_layer_group_inner_wrapper")) {				
				// ELEMENT IS ALREADY IN THE GROUP
				if (dropcontainer[0].contains(htmllayer[0])) {										
					p_uid = objLayer.p_uid;					
				} else {
				
				objLayer = t.setVal(objLayer,'align_hor',"left");
				objLayer = t.setVal(objLayer,'align_vert',"top");

				// ELEMENT IS DROPPED FIRST TIME IN THE GROUP
					var pos = htmllayer.position(),
						ocp = {left:0,top:0},
						zp = {left:0,top:0},
						origpos = htmllayer.data('originalPosition');
					if (objLayer.p_uid != -1) {
						
						var oldcontainer = t.getLayerByUniqueId(objLayer.p_uid)
						if (oldcontainer.type==="column" || oldcontainer.type==="group") {
							ocp =  oldcontainer.references.htmlLayer.position();
							var zc = oldcontainer.references.htmlLayer.closest(".row-zone-container");	
							zp = zc === undefined || zc.length==0 ? {left:0, top:0} : zc.position();							
							zp.top += zc === undefined || zc.length==0 ? 0 : parseInt(zc.css("marginTop"),0);
						}

					} 
					dropcontainer[0].appendChild(htmllayer[0]);
					
					p_uid = htmllayer.closest('.slide_layer_type_group').data('uniqueid');						
					var pobj =  t.getLayerByUniqueId(p_uid),				
						dim = {w:htmllayer.width(), h:htmllayer.height()};
						

					
					objLayer.p_uid = p_uid;
					
					jQuery.each(pobj.left,function(i,key) {									
						if (objLayer.top!==undefined && pobj.top!==undefined && pobj.top[i]!==undefined) {
							if (pobj.align_hor[i]==="right") 
								if (rev_sizes!==undefined)
									newl = Math.round(pos.left+ocp.left- (rev_sizes[i][0]- (parseInt(pobj.left[i],0)+parseInt(pobj.max_width[i],0))));
								else
									newl = Math.round(pos.left+ocp.left- (jQuery('#divLayers').width() - parseInt(pobj.left[i],0)));
							else 
								newl = Math.round(pos.left+ocp.left- parseInt(pobj.left[i],0));
							
							if (pobj.align_vert[i]==="bottom")
							 	if (rev_sizes!==undefined)
							 		newt = Math.round(pos.top+ocp.top+zp.top- (rev_sizes[i][1]- (parseInt(pobj.top[i],0)+parseInt(pobj.max_height[i],0))));
							 	else
							 		newt = Math.round(pos.top+ocp.top+zp.top- (jQuery('#divLayers').height() - parseInt(pobj.top[i],0)));
							else
								newt = Math.round(pos.top+ocp.top+zp.top - parseInt(pobj.top[i],0));						
														
							objLayer.left[i] = oldcontainer ? newl : newl-1;
							objLayer.top[i] = oldcontainer ? newt : newt-1;
						}
					});					
					t.updateHtmlLayerPosition(false,objLayer,t.getVal(objLayer, 'top'),t.getVal(objLayer, 'left'),t.getVal(objLayer, 'align_hor'),t.getVal(objLayer, 'align_vert'));
					u.organiseGroupsAndLayer(false);		
					pobj.references.htmlLayer.addClass("inwork");
					jQuery('#focusongroup').addClass("inwork");
				}
				
			} else 

			if (dropcontainer !=undefined &&  dropcontainer[0].classList.contains("slide_layer_type_column")) {  				
				// ELEMENT IS DROPPED INTO A ROW'S COLUMN
				if (!dropcontainer[0].getElementsByClassName('tp_layer_group_inner_wrapper')[0].contains(htmllayer[0]))
					dropcontainer[0].getElementsByClassName('tp_layer_group_inner_wrapper')[0].appendChild(htmllayer[0]);				
				p_uid =  htmllayer.closest('.slide_layer_type_column').data('uniqueid');						
				
				// SET ELEMENT WHITESPACE NORMAL IF IT COMES FROM ROOT
				var oldcontainer = t.getLayerByUniqueId(objLayer.p_uid);
				if (oldcontainer.type!=="column" && oldcontainer.type!=="group") 
					objLayer = t.setVal(objLayer,'whitespace','normal');

				objLayer.p_uid = p_uid;	
				u.organiseGroupsAndLayer(false);
				var ah = t.getVal(objLayer, 'align_hor'),
					av = t.getVal(objLayer, 'align_vert');
				ah = "left";
				av = "top";
				
				
				
				objLayer = t.setVal(objLayer,'align_hor',ah);
				objLayer = t.setVal(objLayer,'align_vert',av);
				if (objLayer.type==="text") {
				//	objLayer = t.setVal(objLayer, 'max_width', "auto", true);
					objLayer = t.setVal(objLayer, 'max_height', "auto", true);
				}
				if (objLayer.type==="shape") {
					var shapesizing = jQuery('#layer_cover_mode option:selected').val();					
					if (shapesizing==="fullheight" || shapesizing==="cover" || shapesizing==="cover-proportional") {
						jQuery('#layer_cover_mode option:selected').prop('selected',false);
						var objUpdate = {};

						if (shapesizing==="fullheight") {
							jQuery('#layer_cover_mode option[value="custom"]').attr("selected","selected");
							objUpdate = t.setVal(objUpdate, 'cover_mode', 'custom', true);
						}
						else {
							jQuery('#layer_cover_mode option[value="fullwidth"]').attr("selected","selected");
							objUpdate = t.setVal(objUpdate, 'cover_mode', 'fullwidth', true);
						}						
						t.updateLayer(objLayer.serial,objUpdate);
						t.set_cover_mode();				
					}
				}
				setTimeout(function() {
					t.extendSlideHeightBasedOnRows();
				},100);
				unselectAllFocusedGroup();
			} else 
			
			if (dropcontainer !=undefined &&  dropcontainer[0].id==="divLayers" && htmllayer[0].parentNode.id!=="divLayers") {
				// Add Back to Mainstage								
				var pos = htmllayer.position(),
					pobj = t.getLayerByUniqueId(objLayer.p_uid),
					off = pobj!=undefined && pobj.references!=undefined  && pobj.references.htmlLayer!=undefined ? pobj.references.htmlLayer.position() : {top:0,left:0},
					zp = {left:0, top:0},
					rp = {left:0, top:0};
					
					objLayer = t.setVal(objLayer,'align_hor',"left");
					objLayer = t.setVal(objLayer,'align_vert',"top");
				
				if (objLayer.p_uid != -1) {
					var oldcontainer = t.getLayerByUniqueId(objLayer.p_uid)
					if (oldcontainer.type==="column") {												
						ocp =  oldcontainer.references.htmlLayer.position();
						var zc = oldcontainer.references.htmlLayer.closest(".row-zone-container"),
							rc = oldcontainer.references.htmlLayer.closest(".slide_layer_type_row");
						rp = rc === undefined || rp.length==0 ? {left:0, top:0} : rc.position();
						zp = zc === undefined || zc.length==0 ? {left:0, top:0} : zc.position();
						zp.top += zc === undefined || zc.length==0 ? 0 : parseInt(zc.css("marginTop"),0);
						rp.top += rc === undefined || rc.length==0 ? 0 : parseInt(rc.css("marginTop"),0);						
					}					
				}
				objLayer.p_uid = -1;
				
				document.getElementById('divLayers').appendChild(htmllayer[0]);				
				
				
				jQuery.each(objLayer.left,function(i,key) {			
					objLayer.left[i] = Math.round(pos.left+1+off.left+zp.left+rp.left);
					objLayer.top[i] =  Math.round(pos.top+1+off.top+zp.top+rp.top);
				});
				
				
				t.updateHtmlLayerPosition(false,objLayer,t.getVal(objLayer, 'top'),t.getVal(objLayer, 'left'),"left","top");
				u.organiseGroupsAndLayer(false);	
				unselectAllFocusedGroup();												
			}
		}	
		t.setMiddleRowZone();		
		t.resetLayerSelected(objLayer);
	}

	t.checkRowZoneContents = function() {
		jQuery('.row-zone-container').each(function() {
			if (this.children.length === 0)
				jQuery(this).addClass("emptyzone");
			else
				jQuery(this).removeClass("emptyzone");
		})
	}

	t.setMiddleRowZone = function(delay) {		
		delay = delay === undefined ? 0 : delay;
		setTimeout(function() {
			var rzm = document.getElementById('row-zone-middle');
			rzm.style.marginTop = (0 - jQuery(rzm).height()/2)+"px";		
		},delay);
	}

	t.showHideToggleContent = function(objLayer) {		
		if (objLayer["toggle"]===true) {
			jQuery('#layer_text_wrapper').addClass("withtoggle");
		} else {
			jQuery('#layer_text_wrapper').removeClass("withtoggle");
		}
	}

	t.showHideContentEditor = function(show) {

		if (show) {
			jQuery('#button_edit_layer').hide();
			jQuery('#button_delete_layer').hide();
			jQuery('#button_duplicate_layer').hide();
			jQuery('#tp-addiconbutton').show();
			jQuery('#hide_layer_content_editor').show();
			jQuery('#linkInsertTemplate').show();
			jQuery('#layer_text_wrapper').show();
			jQuery('#button_reset_size').hide();
			jQuery('#button_change_video_settings').hide();
			jQuery('#layer_text_wrapper').addClass('currently_editing_txt');
			jQuery('#layer-short-tool-placeholder-a').hide();
			jQuery('#layer-short-tool-placeholder-b').hide();
		} else {		
			jQuery('#layer-short-tool-placeholder-a').show();
			jQuery('#layer-short-tool-placeholder-b').show();
			jQuery('#button_edit_layer').hide();
			jQuery('#button_change_image_source').hide();
			jQuery('#button_delete_layer').show();
			jQuery('#button_duplicate_layer').show();
			jQuery('#tp-addiconbutton').hide();
			jQuery('#hide_layer_content_editor').hide();
			jQuery('#linkInsertTemplate').hide();			
			jQuery('#button_reset_size').hide();
			jQuery('#button_change_video_settings').hide();
			jQuery('#layer_text_wrapper').hide();
			jQuery('#layer_text_wrapper').removeClass('currently_editing_txt');			
		}
		
		var objLayer = t.selectedLayerSerial === -1 ? "" : t.getLayer(t.selectedLayerSerial);	

		t.toolbarInPos(objLayer);
		t.showHideToggleContent(objLayer);
	}

	
	
	t.changeSlotBGs = function() {
		
		// MOVE ALL DATA TO THE RIGHT CONTAINER TO ANIMATE IT 
		var nextsh = jQuery('#divbgholder').find('.slotholder'),
			
			bgimg = jQuery("#image_url").val(),
			bgpos = (jQuery('#slide_bg_position').val() == 'percentage') ? jQuery("input[name='bg_position_x']").val() + '% ' + jQuery("input[name='bg_position_y']").val() + '% ' : jQuery('#slide_bg_position').val(),
			bgfit = (jQuery('#slide_bg_fit').val() == 'percentage') ? jQuery("input[name='bg_fit_x']").val() + '% ' + jQuery("input[name='bg_fit_y']").val() + '% ' : jQuery('#slide_bg_fit').val(),
			bgcolor = jQuery('#slide_bg_color').val();
			gallery_type = jQuery('input[name="rs-gallery-type"]').val();

			jQuery('#the_image_source_url').html(bgimg);
		
		jQuery('#video-settings').hide();
		jQuery('#bg-setting-wrap').show();
		jQuery('#vid-rev-youtube-options').hide();
		jQuery('#vid-rev-vimeo-options').hide();
		jQuery('#streamvideo_cover').hide();
		jQuery('#streamvideo_cover_both').hide();
		
		jQuery('#button_change_image').show();
		jQuery('#button_change_image_objlib').show();
		
		jQuery('.video_volume_wrapper').hide();
		
		jQuery('#slide_selector .list_slide_links li.selected .slide-media-container ').removeClass("mini-transparent").css({backgroundSize:"cover"});
		var bbggtt = jQuery('input[name="background_type"]:checked').data('bgtype');
		switch(bbggtt){
			case "image":
				jQuery('#button_change_image').hide();
				jQuery('#button_change_image_objlib').hide();
				
				switch(gallery_type){
					case 'gallery':
						jQuery('#button_change_image').show();
						jQuery('#button_change_image_objlib').show();
					break;
					case 'posts':
						bgimg = rs_plugin_url+'public/assets/assets/sources/post.png';
					break;
					case 'woocommerce':
						bgimg = rs_plugin_url+'public/assets/assets/sources/wc.png';
					break;
					case 'facebook':
						bgimg = rs_plugin_url+'public/assets/assets/sources/fb.png';
					break;
					case 'twitter':
						bgimg = rs_plugin_url+'public/assets/assets/sources/tw.png';
					break;
					case 'instagram':
						bgimg = rs_plugin_url+'public/assets/assets/sources/ig.png';
					break;
					case 'flickr':
						bgimg = rs_plugin_url+'public/assets/assets/sources/fr.png';
					break;
					case 'youtube':
						bgimg = rs_plugin_url+'public/assets/assets/sources/yt.png';
					break;
					case 'vimeo':
						bgimg = rs_plugin_url+'public/assets/assets/sources/vm.png';
					break;
				}
				
				jQuery('.mainbg-sub-kenburns-selector').show();
				jQuery('.mainbg-sub-parallax-selector').show();
				jQuery('.mainbg-sub-settings-selector').show();
				jQuery('#button_change_image').appendTo(jQuery('#tp-bgimagewpsrc'));
				jQuery('#button_change_image_objlib').appendTo(jQuery('#tp-bgimagewpsrc'));
								
				nextsh.find('.defaultimg, .slotslidebg').css({
						backgroundImage:("url("+bgimg+")"),
						backgroundPosition:bgpos,
						backgroundSize:bgfit,
						backgroundColor:"transparent"});	
				jQuery('#ken_burn_slot_example').css({
						backgroundImage:("url("+bgimg+")"),
						backgroundPosition:bgpos,
						backgroundSize:bgfit,
						backgroundColor:"transparent"}).data('src',bgimg);
				t.updateKenBurnExampleValues();
			break;
			case "trans":

				jQuery('#slide_selector .list_slide_links li.selected .slide-media-container ').css("background-image","").css("background-repeat","").addClass("mini-transparent").css({backgroundSize:"inherit"});

				nextsh.find('.defaultimg, .slotslidebg').css({
						backgroundImage:"none",
						backgroundPosition:bgpos,
						backgroundSize:bgfit,
						backgroundColor:"transparent"});	
				jQuery('.mainbg-sub-kenburns-selector').hide();
				jQuery('.mainbg-sub-parallax-selector').hide();
				jQuery('.mainbg-sub-settings-selector').hide();
			break;
			case "solid":
				nextsh.find('.defaultimg, .slotslidebg').css({
						backgroundImage:"none",
						backgroundPosition:bgpos,
						backgroundSize:bgfit,
						backgroundColor:bgcolor});	
				jQuery('.mainbg-sub-kenburns-selector').hide();
				jQuery('.mainbg-sub-parallax-selector').hide();
				jQuery('.mainbg-sub-settings-selector').hide();
				jQuery('#slide_selector .list_slide_links li.selected .slide-media-container ').css({
						backgroundImage:"none",
						backgroundPosition:bgpos,
						backgroundSize:bgfit,
						backgroundColor:bgcolor});
			break;
			case "external":
				bgimg = jQuery('#slide_bg_external').val();

				jQuery('#the_image_source_url').html(bgimg);
				nextsh.find('.defaultimg, .slotslidebg').css({
						backgroundImage:("url("+bgimg+")"),
						backgroundPosition:bgpos,
						backgroundSize:bgfit,
						backgroundColor:"transparent"});
				jQuery('#ken_burn_slot_example').css({
						backgroundImage:("url("+bgimg+")"),
						backgroundPosition:bgpos,
						backgroundSize:bgfit,
						backgroundColor:"transparent"}).data('src',bgimg);
				t.updateKenBurnExampleValues();
				jQuery('.mainbg-sub-kenburns-selector').show();
				jQuery('.mainbg-sub-parallax-selector').show();
				jQuery('.mainbg-sub-settings-selector').show();
			break;
			case "streamtwitter":
			case "streamtwitterboth":
				jQuery('#streamvideo_cover').show();
				jQuery('#streamvideo_cover_both').show();
				bgimg = rs_plugin_url+'public/assets/assets/sources/tw.png';
				nextsh.find('.defaultimg, .slotslidebg, #ken_burn_slot_example').css({
						backgroundImage:("url("+bgimg+")"),
						backgroundPosition:'center center',
						backgroundSize:'cover',
						backgroundColor:"transparent"});
				jQuery('#ken_burn_slot_example').css({
						backgroundImage:("url("+bgimg+")"),
						backgroundPosition:'center center',
						backgroundSize:'cover',
						backgroundColor:"transparent"}).data('src',bgimg);
				t.updateKenBurnExampleValues();
				jQuery('.mainbg-sub-kenburns-selector').hide();
				jQuery('.mainbg-sub-parallax-selector').show();
				jQuery('.mainbg-sub-settings-selector').show();
				jQuery('#button_change_image').appendTo(jQuery('#vimeo-image-picker'));
				jQuery('#button_change_image_objlib').appendTo(jQuery('#vimeo-image-picker'));
				jQuery('#video-settings').show();
				jQuery('#bg-setting-wrap').hide();
				jQuery('#vid-rev-vimeo-options').show();
				jQuery('#vid-rev-youtube-options').show();
				jQuery('.video_volume_wrapper').show();
				
			break;
			case "streamyoutube":
			case "streamyoutubeboth":
				jQuery('#streamvideo_cover').show();
				jQuery('#streamvideo_cover_both').show();
				bgimg = rs_plugin_url+'public/assets/assets/sources/yt.png';
			case "youtube":
				nextsh.find('.defaultimg, .slotslidebg, #ken_burn_slot_example').css({
						backgroundImage:("url("+bgimg+")"),
						backgroundPosition:'center center',
						backgroundSize:'cover',
						backgroundColor:"transparent"});
				jQuery('#ken_burn_slot_example').css({
						backgroundImage:("url("+bgimg+")"),
						backgroundPosition:'center center',
						backgroundSize:'cover',
						backgroundColor:"transparent"}).data('src',bgimg);
				t.updateKenBurnExampleValues();
				jQuery('.mainbg-sub-kenburns-selector').hide();
				jQuery('.mainbg-sub-parallax-selector').show();
				jQuery('.mainbg-sub-settings-selector').show();
				jQuery('#button_change_image').appendTo(jQuery('#youtube-image-picker'));
				jQuery('#button_change_image_objlib').appendTo(jQuery('#youtube-image-picker'));
				jQuery('#video-settings').show();
				jQuery('#bg-setting-wrap').hide();
				jQuery('#vid-rev-youtube-options').show();
				jQuery('.video_volume_wrapper').show();
			break;
			case "streamvimeo":
			case "streamvimeoboth":
				jQuery('#streamvideo_cover').show();
				jQuery('#streamvideo_cover_both').show();
				bgimg = rs_plugin_url+'public/assets/assets/sources/vm.png';
			case "vimeo":
				nextsh.find('.defaultimg, .slotslidebg, #ken_burn_slot_example').css({
						backgroundImage:("url("+bgimg+")"),
						backgroundPosition:'center center',
						backgroundSize:'cover',
						backgroundColor:"transparent"});
				jQuery('#ken_burn_slot_example').css({
						backgroundImage:("url("+bgimg+")"),
						backgroundPosition:'center center',
						backgroundSize:'cover',
						backgroundColor:"transparent"}).data('src',bgimg);
				t.updateKenBurnExampleValues();
				jQuery('.mainbg-sub-kenburns-selector').hide();
				jQuery('.mainbg-sub-parallax-selector').show();
				jQuery('.mainbg-sub-settings-selector').show();
				jQuery('#button_change_image').appendTo(jQuery('#vimeo-image-picker'));
				jQuery('#button_change_image_objlib').appendTo(jQuery('#vimeo-image-picker'));
				jQuery('#video-settings').show();
				jQuery('#bg-setting-wrap').hide();
				jQuery('#vid-rev-vimeo-options').show();
				jQuery('.video_volume_wrapper').show();
			break;
			case "streaminstagram":
			case "streaminstagramboth":
				jQuery('#streamvideo_cover').show();
				jQuery('#streamvideo_cover_both').show();
				bgimg = rs_plugin_url+'public/assets/assets/sources/ig.png';
			case "html5":
				nextsh.find('.defaultimg, .slotslidebg').css({
						backgroundImage:("url("+bgimg+")"),
						backgroundPosition:'center center',
						backgroundSize:'cover',
						backgroundColor:"transparent"});
				jQuery('#ken_burn_slot_example').css({
						backgroundImage:("url("+bgimg+")"),
						backgroundPosition:'center center',
						backgroundSize:'cover',
						backgroundColor:"transparent"}).data('src',bgimg);	
				t.updateKenBurnExampleValues();			
				jQuery('.mainbg-sub-kenburns-selector').hide();
				jQuery('.mainbg-sub-parallax-selector').show();
				jQuery('.mainbg-sub-settings-selector').show();
				jQuery('#button_change_image').appendTo(jQuery('#html5video-image-picker'));
				jQuery('#button_change_image_objlib').appendTo(jQuery('#html5video-image-picker'));
				jQuery('#video-settings').show();
				jQuery('#bg-setting-wrap').hide();

			break;
		}
		if (bbggtt != "solid" && bbggtt!="trans")
			jQuery('#slide_selector .list_slide_links li.selected .slide-media-container ').css("background-image","url("+bgimg+")");
		jQuery('#divbgholder').css({background:"none",backgroundImage:"none",backgroundColor:"transparent"});
		
		// Use Admin Thumbnail if Selected
		if (jQuery('#thumb_for_admin').attr('checked')=="checked") {
			var tbgimg = jQuery('#slide_thumb_button_preview div').css("background-image");			
			jQuery('#slide_selector .list_slide_links li.selected .slide-media-container').css({"background-image":tbgimg, backgroundSize:"cover",backgroundPosition:"center center"});
		}
		u.resetSlideAnimations(false);
	}
	
	
	var initDisallowCaptionsOnClick = function(){

		jQuery('.slide_layer.tp-caption a').on('click', function(){
			return false;
		});

	}


	function initSliderMainOptions(jQueryObj){
		
		var t=jQueryObj;
		jQuery('.bgsrcchanger-div').each(function() {
			if (jQuery(this).attr('id') !="tp-bgimagesettings" || (jQuery(this).attr('id') =="tp-bgimagesettings" && t.data('imgsettings')!="on")) {
				if (jQuery(this).attr('id') =="tp-bgimagesettings")
					jQuery(this).slideUp(200);
				else
					jQuery(this).css({display:"none"});
			}
		});
		jQuery('#'+t.data('callid')).css({display:"inline-block"});
		if (t.data('imgsettings')=="on")
			jQuery('#tp-bgimagesettings').slideDown(200);
		
		if(jQuery('input[name="background_type"]:checked').val() == 'image'){
			jQuery('.rs-img-source-size').show();
			jQuery('#alt_option').show();
			jQuery('#title_option').show();
			if(jQuery('#alt_option option:selected').val() == 'custom'){
				jQuery('#alt_attr').show();
			}else{
				jQuery('#alt_attr').hide();
			}
			if(jQuery('#title_option option:selected').val() == 'custom'){
				jQuery('#title_attr').show();
			}else{
				jQuery('#title_attr').hide();
			}
		}else{
			jQuery('#alt_option').hide();
			jQuery('#title_option').hide();
			jQuery('#alt_attr').show();
			jQuery('#title_attr').hide();
			jQuery('.rs-img-source-size').hide();
		}
		
		if(jQuery('input[name="background_type"]:checked').val() == 'external'){
			jQuery('.ext_setting').show();
		}else{
			jQuery('.ext_setting').hide();
		}
		
	}


	/*! ALIGN TABLE HANDLING */
	/**
	 * init the align table
	 */
	var initAlignTable = function(){
		
		jQuery('.rs-new-align-button').click(function(){
			var obj = jQuery(this);
			if(jQuery(obj).parent().hasClass('table_disabled')) return(false);
			
			var inpX = jQuery("#layer_left_text"),
				inpY = jQuery("#layer_top_text"),				
				alignHor = obj.data('hor'),
				alignVert = obj.data('ver');

			if(alignVert === undefined){ //we are in horizontal
				jQuery('#rs-align-wrapper').find('.selected').removeClass("selected");				
				switch(alignHor){
					case "left":
						inpX.html(inpX.data("textnormal")).css("width","auto");
						jQuery("#layer_left").val("0");
					break;
					case "right":
						inpX.html(inpX.data("textoffset")).css("width","42px");
						jQuery("#layer_left").val("0");
					break;
					case "center":
						inpX.html(inpX.data("textoffset")).css("width","42px");
						jQuery("#layer_left").val("0");
					break;
				}

				jQuery("#layer_align_hor").val(alignHor);
				
			}else{ //we are in vertical
				jQuery('#rs-align-wrapper-ver').find('.selected').removeClass("selected");
				switch(alignVert){
					case "top":
						inpY.html(inpY.data("textnormal")).css("width","auto");
						jQuery("#layer_top").val("0");
					break;
					case "bottom":
						inpY.html(inpY.data("textoffset")).css("width","42px");
						jQuery("#layer_top").val("0");
					break;
					case "middle":
						inpY.html(inpY.data("textoffset")).css("width","42px");
						jQuery("#layer_top").val("0");
					break;
				}
				jQuery("#layer_align_vert").val(alignVert);
			}

			var objLayer = t.getLayer(t.selectedLayerSerial);
			if (objLayer.type==="row") {
				switch (alignVert) {
					case "top":
						document.getElementById("row-zone-top").appendChild(objLayer.references.htmlLayer[0]);												
					break;
					case "middle":
						document.getElementById("row-zone-middle").appendChild(objLayer.references.htmlLayer[0]);
					break;
					case "bottom":
						document.getElementById("row-zone-bottom").appendChild(objLayer.references.htmlLayer[0]);
					break;
				}
				objLayer = t.setVal(objLayer,"align_vert",alignVert,true,null,true);
				t.checkRowZoneContents();
			}			
			obj.addClass('selected');
			t.updateLayerFromFields();
			t.toolbarInPos();			
			t.setMiddleRowZone(100);
		});
	}


	/**
	 * init general events
	 */
	var initMainEvents = function(){		
		//unselect layers on container click
		container.click(function(event) {			
			if (!layerresized) {
				
				if(event.target == this || jQuery(event.target).hasClass("slide_layers_border")) u.checkMultipleSelectedItems(true);
				unselectLayers();
				jQuery('#quick-layers-wrapper').slideUp(300);						
				jQuery('.current-active-main-toolbar').removeClass("opened");
				jQuery('#button_show_all_layer i').removeClass("eg-icon-up").addClass("eg-icon-menu");

			}
			else
				layerresized=false;
		});
	}


	/**
	 * show / hide offset row accorging the slide link value
	 */
	var showHideLinkActions = function(v, updatetimelines){

		var li = v.closest('li'),
			value = v.val();
			
		li.find('.action-link-wrapper').hide();
		li.find('.action-jump-to-slide').hide();
		li.find('.action-scrollofset').hide();
		li.find('.action-target-layer').hide();
		li.find('.action-callback').hide();
		li.find('.action-toggle_layer').hide();
		li.find('.action-toggleclass').hide();
		li.find('.action-delay-wrapper').show();
		
		
		switch (value) {
			case "none":
				li.find('.action-delay-wrapper').hide();				
			break;
			case "link":
				li.find('.action-link-wrapper').show();				
			break;
			case "jumpto":
				li.find('.action-jump-to-slide').show();
			break;
			
			case "scroll_under":
				li.find('.action-scrollofset').show();
			break;

			case "callback":
				li.find('.action-callback').show();
			break;

			case "start_in":
			case "start_out":
			case "start_video":
			case "stop_video":
			case "mute_video":
			case "unmute_video":
			case "toggle_video":
			case "toggle_mute_video":			
				li.find('.action-target-layer').show();
			break;
			case "toggle_layer":
				li.find('.action-target-layer').show();
				li.find('.action-toggle_layer').show();
			break;

			case "simulate_click":
				li.find('.action-target-layer').show();
			break;
			case "toggle_class":
				li.find('.action-target-layer').show();
				li.find('.action-toggleclass').show();
			break;
		}
		
		switch (value) {
			case 'start_in':
			case 'start_out':
			case 'toggle_layer':
				li.find('.action-triggerstates').show();
			break;
			default:
				li.find('.action-triggerstates').hide();
			break;
		}
		switch (value) {
			case "toggle_video":
			case "mute_video":
			case "unmute_video":
			case "toggle_global_mute_video":
			case "toggle_mute_video":
			case "start_video":
			case "stop_video":
				li.find('.action-target-layer').find('select[name="layer_target[]"] option').each(function(){
					if(jQuery(this).data('mytype') !== 'video' && jQuery(this).data('mytype') !== 'video-special' && jQuery(this).data('mytype') !== 'audio'){
						if(jQuery(this).data('mytype') === 'all'){
							jQuery(this).show(); //show if all
						}else{
							jQuery(this).hide();
						}
					}else{
						jQuery(this).show();
					}
				});
			break;
			default:
				li.find('.action-target-layer').find('select[name="layer_target[]"] option').each(function(){
					if(jQuery(this).data('mytype') !== 'video-special'){
						jQuery(this).show();
					}else{
						if(jQuery(this).data('mytype') === 'all'){
							jQuery(this).show(); //show if all
						}else{
							jQuery(this).hide();
						}
					}
				});
			break;
		}
		
		if (updatetimelines) u.updateAllLayerTimeline();
	}
	
	var showHideToolTip = function(){
		var value = jQuery("#layer_tooltip_event").val(),
			tpat = jQuery(".tooltip-parrent-part"),
			tchi = jQuery('.tooltip-child-part');

		switch (value) {
			case "none":
				tpat.hide();
				tchi.hide();
			break;
			case "parrent":
				tpat.show();
				tchi.hide();		
			break;			
			case "child":
				tpat.hide();
				tchi.show();				
			break;
		}
	}

	// SET SUFFIX FOR INPUT FIELD OR LEAVE THE CURRENT VALUE 
	var specOrVal = function(putin,possiblevalues,forcesuffix,suffix) {
		var n = parseFloat(putin),
			newsuffix = suffix===undefined && n!==undefined && jQuery.isNumeric(n) && !jQuery.isNumeric(putin) ? 
					putin.replace(n,"") 
					: suffix === undefined ? 
						forcesuffix===undefined ? 
							"" 
							: forcesuffix 
						: suffix;		

		result = jQuery.inArray(putin,possiblevalues)>=0 ? putin : putin===undefined || !jQuery.isNumeric(parseInt(putin)) || putin.length===0 ? "" : parseInt(putin)+newsuffix;				
		return result;
	}
	
	t.check_the_font_bold = function(font){
		var variants = ['100','200','300','400','500','600','700','800','900'];
		
		for(var key in initArrFontTypes){
			if(initArrFontTypes[key].label == font){
				if(typeof(initArrFontTypes[key].variants) !== 'undefined'){
					variants = initArrFontTypes[key].variants;
				}
				break;
			}
		}
		
		var fws = jQuery('select[name="font_weight_static"]');
		var sel = fws.find('option:selected').val();
		fws.html('');
		
		for(var key in variants){
			if(variants[key].indexOf('italic') > -1) continue;
			fws.append('<option value="'+variants[key]+'">'+variants[key]+'</option>');
		}
		fws.find('option[value="'+sel+'"]').attr('selected', 'selected');
	}
	
	
	t.do_google_font_loading = function(font){
		var gfamilies  = [];
		//check if this is a google font, if yes, then load the font with all stuff available
		for(var key in initArrFontTypes){
			if(initArrFontTypes[key].label == font){
				if(initArrFontTypes[key].type == 'googlefont'){
					//load font now!, its google
					var gstring = '';
					for(var mkey in initArrFontTypes[key].variants){
						if(mkey > 0) gstring += ',';
						gstring += initArrFontTypes[key].variants[mkey];
					}
					if(typeof(initArrFontTypes[key].subsets) !== 'undefined'){
						gstring += '&subset=';
						for(var mkey in initArrFontTypes[key].subsets){
							if(mkey > 0) gstring += ',';
							gstring += initArrFontTypes[key].subsets[mkey];
						}
					}
					fontclass = font.replace(/\ /g,'-');
					font = font.replace(/\ /g,'+');
					
					if(jQuery('.rev-css-'+fontclass).length == 0){
						//jQuery('head').append('<link class="rev-css-'+fontclass+'" href="//fonts.googleapis.com/css?family='+font+':'+gstring+'" rel="stylesheet" type="text/css">');
						gfamilies.push(font+":"+gstring);
						jQuery('body').append('<div style="display:none" class="rev-css-'+fontclass+'">RevSliderFont</div>');
						
						if(sgfamilies.indexOf(font) == -1){
							sgfamilies.push(font);
						}
						
						if (gfamilies!==null && gfamilies.length>0)
						tpWebFont.load({
							google:{
								families:gfamilies
							},
							loading:function() {								
								showWaitAMinute({fadeIn:300,text:font+" is Loading..."});
							},
							active:function() {
								setTimeout(function() {
									showWaitAMinute({fadeOut:300});
								},300);								
								u.allLayerToIdle({type:"text"});								
							},		
							inactive:function() {
								setTimeout(function() {
									showWaitAMinute({fadeOut:300});
								},300);								
								u.allLayerToIdle({type:"text"});								
							}		
						})
					}//else already loaded
				}
				break;
			}
		}
		
		t.sortFontTypesByUsage();
	}
	
	
	/*****************************************************
					INIT HTML FIELDS 
	  init events (update) for html properties change.
	*****************************************************/
	var initHtmlFields = function(){
		
		//show / hide slide link offset
		
		jQuery('body').on('change', 'select[name="layer_action[]"], select[name="no_layer_action[]"]',function() {
			
			showHideLinkActions(jQuery(this));
		});

		jQuery('body').on('click','#kenburn-playpause-wrapper', function() {
			var pb = jQuery('#kenburn-playpause-wrapper'),
				tl = jQuery('#ken_burn_example').data('kbtl');
			
			if (pb.hasClass("playing")) {
				pb.html('<i class="eg-icon-play"></i><span>PLAY</span>');
				pb.removeClass("playing");
				tl.pause();
			} else {
				pb.html('<i class="eg-icon-pause"></i><span>PAUSE</span>');
				pb.addClass("playing");
				tl.play();
			}
		});

		jQuery('body').on('click','#kenburn-backtoidle',function() {
			var tl = jQuery('#ken_burn_example').data('kbtl');
			tl.progress(0);
		});

		jQuery('.kb_input_values').change(t.updateKenBurnExampleValues);


		jQuery('#layer_tooltip_event').change(showHideToolTip);

		
		//set layers autocompolete
		jQuery("#layer_caption").catcomplete({
			source: initArrCaptionClasses,
			minLength:0,
			appendTo:"#tp-thelistofclasses",
			open:function(event,ui) {
				if (jQuery('#tp-thelistofclasses ul').height()>450) {
					jQuery('#tp-thelistofclasses ul').perfectScrollbar("destroy").perfectScrollbar({wheelPropagation:false, suppressScrollX:true});					
				}

			},
			close: function(event, ui){
				var layer = t.getCurrentLayer();
				
				if(layer === false || layer == null){
					return false;
				}
				
				if(layer.style !== undefined && layer.style !== jQuery('#layer_caption').val()){
					layer.style = jQuery('#layer_caption').val();
					//update values that can be set without changing the class
					t.reset_to_default_static_styles(layer);
					// Reset Fields from Style Template
					updateSubStyleParameters(layer, true);
				}
				jQuery('#layer_caption').change();
				jQuery('#css_font-family').change();
				
				t.updateLayerFromFields();
			}/*,
			change: function(event,ui){
				if (ui.item==null){
					jQuery("#layer_caption").val('');
					jQuery("#layer_caption").focus();
				}
			}*/
		}).data("customCatcomplete")._renderItem = function(ul, item) {
			var listItem = jQuery("<li></li>")
				.data("item.autocomplete", item)
				.append("<a>" + item.label + "</a>")
				.appendTo(ul);

			listItem.attr('original-title', item.value);
			return listItem;
		};

		

		//open the list on right button
		jQuery( "#layer_captions_down" ).click(function(event){
			event.stopPropagation();

			jQuery('#css_font-family').catcomplete("close");
			
			jQuery("#css_editor_expert").hide();
			jQuery("#css_editor_wrap").hide();

			//if opened - close autocomplete
			if(jQuery('#layer_caption').data("is_open") == true)
				jQuery( "#layer_caption" ).catcomplete("close");
			else   //else open autocomplete
			if(jQuery(this).hasClass("ui-state-active"))
				jQuery( "#layer_caption" ).catcomplete( "search", "" ).data("customCatcomplete")._renderItem = function(ul, item) {
					var listItem = jQuery("<li></li>")
						.data("item.autocomplete", item)
						.append("<a>" + item.label + "</a>")
						.appendTo(ul);
					listItem.attr('original-title', item.value);
					return listItem;
				};
		});

		//handle autocomplete close
		jQuery('#layer_caption').bind('catcompleteopen', function() {
			jQuery(this).data('is_open',true);

			//handle tooltip
			jQuery('.ui-autocomplete li').tipsy({
		        delayIn: 70,
		        //delayOut:100000,
				html: true,
				gravity:"w",
				//trigger:"manual",
				title: function(){
					setTimeout(function() {
						jQuery('.tp-present-caption-small').parent().addClass("tp-present-wrapper-small");
						jQuery('.tp-present-caption-small').parent().parent().addClass("tp-present-wrapper-parent-small");
					},10);
					return '<div class="tp-present-caption-small"><div class="example-dark-blinker"></div><div class="tp-caption '+this.getAttribute('original-title')+'">example</div></div>';
				}
			});
		});

		jQuery('#layer_caption').bind('catcompleteclose', function() {
			jQuery(this).data('is_open',false);
		});
		
		
		t.setLayersAutoComplete();
		
		//set layers autocompolete
		jQuery('input[name="adbutton-fontfamily"]').autocomplete({
			source: initArrFontTypes,
			minLength:0
		});

		//open the list on right button
		jQuery("#css_fonts_down").click(function(event){
			event.stopPropagation();
			
			jQuery('#layer_caption').catcomplete("close");
			
			//if opened - close autocomplete
			if(jQuery('#css_font-family').data("is_open") == true)
				jQuery('#css_font-family').catcomplete("close");
			else   //else open autocomplete
			if(jQuery(this).hasClass("ui-state-active"))
				jQuery('#css_font-family').catcomplete( "search", "" ).data("ui-autocomplete");

		});

		
		jQuery("body").click(function(){
			jQuery( "#layer_caption" ).catcomplete("close");
			jQuery('#css_font-family').catcomplete("close");
		});

		//set events:
		jQuery('body').on('change', ".form_layers select, #layer_proportional_scale, #layer_auto_line_break, #layer_displaymode", function(){
			t.updateLayerFromFields();
		});

		jQuery('#layer_proportional_scale, #layer_auto_line_break, #layer_displaymode').change(function(){
			if(jQuery(this)[0].checked)
				jQuery(this).parent().removeClass("notselected")
			else
				jQuery(this).parent().addClass("notselected")
		});

		var keyuprefresh;
		// UPDATE LAYER TEXT FIELD
		jQuery("#layer_text").keyup(function(){
			clearTimeout(keyuprefresh);
			var v = jQuery(this).val();
			keyuprefresh = setTimeout(function() {						
				updateLayerTextField("",jQuery('.sortlist li.ui-state-hover'),v);						
				t.toolbarInPos();
				t.updateLayerFromFields();
				u.updateCurrentLayerTimeline();
			},150);
		});

		jQuery("#layer_text_toggle").keyup(function(){
			clearTimeout(keyuprefresh);
			var v = jQuery(this).val();
			keyuprefresh = setTimeout(function() {						
				updateLayerTextField("",jQuery('.sortlist li.ui-state-hover'),v);						
				t.toolbarInPos();
				t.updateLayerFromFields();
			},150);
		});

		jQuery('.rev-visibility-on-sizes input').click(function(){
			t.updateLayerFromFields();
		});

		jQuery('body').on('blur', ".form_layers input, .form_layers textarea", function(){
			//var cname = jQuery(this).attr('name');
			//if(cname == 'layer_action_delay[]' || cname == 'layer_image_link[]' || cname == 'layer_actioncallback[]' || cname == 'layer_scrolloffset[]' || cname == 'layer_toggleclass[]') return false; //layer actions deny the blur
			
			t.updateLayerFromFields();
		});
		jQuery('body').on('change', ".form_layers input, .form_layers textarea", function(){
			t.updateLayerFromFields();
		});
		jQuery('body').on('keypress', ".form_layers input, .form_layers textarea", function(event){
			if(event.keyCode == 13){
				t.updateLayerFromFields();
			}
		});

		
		jQuery("#delay").keypress(function(event){
			if (Number(jQuery('#delay').val())>0) g_slideTime = jQuery('#delay').val();
		});

		jQuery("#delay").blur(function(){
			if (Number(jQuery('#delay').val())>0) g_slideTime = jQuery('#delay').val();

			var w = g_slideTime/10;
			jQuery('#mastertimer-maxtime').css({left:(w)+"px"});
			jQuery('#mastertimer-maxcurtime').html(u.convToTime(w));
			jQuery('.slide-idle-section').css({left:w});
			jQuery('.mastertimer-slide .tl-fullanim').css({width:(w)+"px"});
			u.mainMaxTimeLeft = w;
			u.masterTimerPositionChange(true);
			u.compareLayerEndsVSSlideEnd();
		});
		

		jQuery('.form_layers input').on("click",function() {
			jQuery(this).select();
		})

		// MIN, MAX VALUES - SUFFIX ADD ONS
		jQuery('.form_layers input').on("change blur focus",function(event) {	

			var inp = jQuery(this),
				cv = parseFloat(inp.val()),
				min = parseFloat(inp.data("min")),
				max = parseFloat(inp.data("max")),
				lsuffix = inp.val().slice(-1) || "",
				ltsuffix = inp.val().slice(-2) || "",
				usuffix = inp.data('suffix'),
				asuffix = inp.data('suffixalt');

			//if (event.type==="focus") 
			//	var saveprefix = inp.val().replace(cv,"");
			
			lastchangedinput = inp.attr('id');
			
			if (usuffix!=undefined) {		

				if (jQuery.isNumeric(cv) && cv > -9999999 && cv<9999999 ) {
					if (min!=undefined && cv<min) cv = min;
					if (min!=undefined && cv>max) cv = max;					
					if (isNaN(cv)) cv = 0;
					cv = Math.round(cv*100)/100;

					if (asuffix==undefined)
						inp.val(cv+usuffix);
					else {						
						if (lsuffix == asuffix)
							inp.val(cv+lsuffix)
						else
						if (ltsuffix == asuffix)
							inp.val(cv+ltsuffix)
						else
							inp.val(cv+usuffix);
					}
				}
			}		
			if (event.type==="focus") this.select();
		});

		jQuery('.form_layers select').on("change blur focus",function() {	
			
			lastchangedinput = jQuery(this).attr('id');
		});

		

		jQuery('#layer_speed, #layer_endspeed, #layer_splitdelay, #layer_endsplitdelay, #layer_split, #layer_endsplit').on("change blur", function() {
			u.updateCurrentLayerTimeline();
		});
		


		
		

		jQuery('body').on('focus','#layer_text, #layer_text_toggle',function() {		
			jQuery('#layer_text').removeClass("lasteditedlayertext");
			jQuery('#layer_text_toggle').removeClass("lasteditedlayertext");
			jQuery(this).addClass("lasteditedlayertext")
		})

	}
	t.nextNewLayerToPosition = function(c) {
		t.newlayercoord.x = c.x;
		t.newlayercoord.y = c.y;
	}
	
	t.setLayersAutoComplete = function(){
		
		//set layers autocompolete
		jQuery('#css_font-family').catcomplete({
			source: initArrFontTypes,
			appendTo:"#tp-thelistoffonts",
			open:function(event,ui) {
				if (jQuery('#tp-thelistoffonts ul').height()>450) {
					jQuery('#tp-thelistoffonts ul').perfectScrollbar("destroy").perfectScrollbar({wheelPropagation:false, suppressScrollX:true});				
					jQuery('#tp-thelistoffonts ul').scrollTop(0);
				}
			},
			minLength:0,
			close:t.updateLayerFromFields,
			select: function( event, ui ) {
				t.check_the_font_bold(ui.item.label);
				t.do_google_font_loading(ui.item.label);
			}
		}).data("customCatcomplete")._renderItem = function(ul, item) {			
			var listItem = jQuery("<li></li>")
				.data("item.autocomplete", item)
				.append("<a>" + item.label + "</a>");
			if (item.top) {				
				listItem.prependTo(ul);
				listItem.insertAfter('#insert-google-font-after-me');
			}
			else {
				listItem.appendTo(ul);
			}

			if (item.label=="Dont Show Me") {
				listItem.css({display:"block",height:"0px",width:"0px",visibility:"hidden"});
				listItem.attr('id','insert-google-font-after-me');
			}
			
			listItem.attr('original-title', item.value);
			return listItem;
		};
		
		jQuery('#css_font-family').change(function(){
			var font = jQuery(this).val();
			t.check_the_font_bold(font);
			t.do_google_font_loading(font);
		});
		
		//handle autocomplete close
		jQuery('#css_font-family').bind('catcompleteopen', function() {
			jQuery(this).data('is_open',true);
		});

		jQuery('#css_font-family').bind('catcompleteclose', function() {
			jQuery(this).data('is_open',false);
		});
		
	}

	var switchLayerBackground = function(objData){

		t.updateCurrentLayer(objData);			
		t.add_layer_change();		
		var objLayer = t.getCurrentLayer();				
		u.rebuildLayerIdleProgress(objLayer.references.htmlLayer);
	}

	/**
	 * init buttons actions
	 */
	var initButtons = function(){
		
		//set event buttons actions:
		jQuery('#button_add_layer').click(function(){	
			//ADDING NEW TEXT LAYER		
			addLayerText(jQuery(this).data('isstatic') == true ? 'static' : null);			
		});

		// add image layer
		jQuery('#button_add_layer_image').click(function(){
			var targ = jQuery(this).data('isstatic') == true ? rev_lang.select_static_layer_image : rev_lang.select_layer_image,
				par = jQuery(this).data('isstatic') == true ? 'static' : null;
			
			UniteAdminRev.openAddImageDialog(targ,function(urlImage,imgid,imgwidth,imgheight){
				var imgobj = {imgurl: urlImage, imgid: imgid, imgwidth: imgwidth, imgheight: imgheight};
				addLayerImage(imgobj, par);
			});			
		});

		//add youtube actions:
		jQuery('#button_add_layer_video').click(function(){
			var gallery_type = jQuery('input[name="rs-gallery-type"]').val();
			t.prepare_video_layer_add(gallery_type);
		});
		
		
		jQuery('#button_add_layer_audio').click(function(){
			t.prepare_video_layer_add('audio');
		});
		
		t.prepare_video_layer_add = function(gallery_type){
			
			jQuery('#video_dialog_form').trigger("reset");
			jQuery('#reset_video_dialog_tab').click();
			
			//check if we are youtubestream or vimeostream. If yes, change what can be seen and edited
			switch(gallery_type){
				case 'youtube':
					jQuery('.rs-show-when-youtube-stream').show();
					jQuery('.rs-hide-when-youtube-stream').show();
				break;
				case 'vimeo':
					jQuery('.rs-show-when-vimeo-stream').show();
					jQuery('.rs-hide-when-vimeo-stream').show();
				break;
				case 'instagram':
					jQuery('.rs-show-when-instagram-stream').show();
					jQuery('.rs-hide-when-instagram-stream').show();
				break;
				case 'audio': //open as audio!
					
				break;
			}
			
			
			var par = jQuery(this).data('isstatic') == true ? 'static' : null;
			UniteAdminRev.openVideoDialog(function(videoData){ 
				addLayerVideo(videoData, par); //audio will be handled inside
			}, false, gallery_type);
		}
		
		jQuery('#button_add_layer_button').click(function(){
			setExampleButtons();
			jQuery('#dialog_addbutton').dialog({
				buttons:{'Close':function(){jQuery('#dialog_addbutton').dialog('close');}},
				minWidth: 830,
				minHeight: 500,
				modal: true,
				dialogClass: 'tpdialogs',
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
			});
		});
		
		
		jQuery('#button_add_layer_svg, #button_add_object_layer').click(function(){
			setExampleButtons();
			//jQuery('#svg-items-filter').change();
			t.callObjectLibraryDialog("object");
		});

		//change image actions
		jQuery("#button_change_image_objlib").click(function(){		
			setExampleButtons();			
			t.callObjectLibraryDialog("background");			
		});	//change image click.

		// SWITCH THE MAIN BG FROM OBJECT LIBRARY
		function switchMainBGObject(urlImage) {
			
			var selectedBGType = jQuery('input[name="background_type"]:checked').val();
			if (jQuery.inArray(selectedBGType,['trans','solid','external']!=-1)) {
				jQuery('#radio_back_image').attr('checked','checked').change().click();
			}
			//set visual image
			jQuery("#divbgholder").css("background-image","url("+urlImage+")");
			jQuery('#slide_selector .list_slide_links li.selected .slide-media-container ').css("background-image","url("+urlImage+")")

			//update setting input
			jQuery("#image_url").val(urlImage);
			jQuery("#image_id").val("");
			
			t.changeSlotBGs();
			
			jQuery('.bgsrcchanger:checked').click();

			if(jQuery('input[name="kenburn_effect"]').is(':checked')){
				jQuery('input[name="kb_start_fit"]').change();
			}
		}
		
		
		

		// LOAD THE OBJECT ORIGINAL IMAGE SINCE IT WAS NOT YET LOADED IN THE UPLOADS FOLDER
		function getMediaObjectUrl(handle, par,size,change,target,addAsBg){
			UniteAdminRev.ajaxRequest('load_library_object', {'handle': handle, 'type': "orig"}, function(response){
				if(response.success){					
					var imgobj = {imgurl: response.url, imglib:"objectlibrary", imgproportion:true, imgwidth: parseInt(response.width,0)*size, imgheight: parseInt(response.height,0)*size};
					if (target==="object" && !addAsBg) {
						if (!change) {
							addLayerImage(imgobj, par);	
						} else {
							var objData = {};
							objData.image_url = response.url;
							objData.image_librarysize = {};
							objData.image_librarysize.width = parseInt(response.width,0)*size;
							objData.image_librarysize.height = parseInt(response.height,0)*size;
							objData.scaleProportional = true;							
							t.updateCurrentLayer(objData);						
							resetCurrentElementSize();
							redrawLayerHtml(t.selectedLayerSerial);
							
							t.add_layer_change();
							
						}
					} else if(target === 'background') {
						switchMainBGObject(response.url);
					} else if(target === 'layer'){
						var objData = {};
						objData.bgimage_url = response.url;
						objData.image_librarysize = {};
						objData.image_librarysize.width = parseInt(response.width,0)*size;
						objData.image_librarysize.height = parseInt(response.height,0)*size;
						switchLayerBackground(objData);
					}
				} 
			});
		}

		jQuery('body').on('click','.layer-link-type-element',function() {
			var _ = jQuery(this),
				_p = _.closest('.list-of-layer-links'),
				_s = _p.find('.layer-link-type-element-cs'),
				objLayer = t.getLayerByUniqueId(_p.data('uniqueid')),
				objUpdate = {};
			objUpdate.groupLink = _.data('linktype');
			t.updateLayer(objLayer.serial,objUpdate);
			for (var i=0;i<6;i++) {
				_s.removeClass('layer-link-type-'+i);
				objLayer.references.htmlLayer.removeClass("ldles_"+i);
				
			}
			objLayer.references.htmlLayer.addClass("ldles_"+objUpdate.groupLink);
			_s.addClass("layer-link-type-"+objUpdate.groupLink);
		})

		// CLICK ON THE "ADD OBJECT" ELEMENT AND ITS HANDLING
		jQuery('body').on('click','.objadd-single-item, .obj-item-size-selector',function() {	
			
			var so = jQuery(this);				
			if (jQuery.inArray(so.data('type'),[1,2,"1","2","img"])!==-1) return;
			if (so.hasClass("obj-item-size-selector")) {
				var size = "1";
				switch (so.data('s')) {
					case "xs": size = 0.1;break;
					case "s": size = 0.25;break;
					case "m": size = 0.50;break;
					case "l": size = 0.75;break;
					case "o": size = 1;break;
				};
				so = so.closest('.objadd-single-item');
			}

			//WHERE THE OBJECT LIBRARY WAS STARTED FROM (BG OR LAYER)
			var lastState = jQuery('#dialog_addobj').data('last_open_state'),
				addAsBg = jQuery('#obj-layer-bg-switcher').hasClass("addthisasbg");
			
			addAsBg = so.data('type')==="2" || so.data('type')===2 ? addAsBg : false;
			addAsBg = lastState==="layer" ? false : addAsBg;

			
			switch (so.data('type')) {
				case "img":
				case "1":
				case "2":
				case 1:
				case 2:
					if(!rs_plugin_validated){ //load image only if activated
						show_premium_dialog('register-to-acess-object-library');
						jQuery('#dialog_addobj').dialog('close');
						return false;
					}
					
					var stat = jQuery('#button_add_layer_image').data('isstatic'),
						targ = stat == true ? rev_lang.select_static_layer_image : rev_lang.select_layer_image,
						par = stat ? 'static' : null,
						src = so.data('origsrc');

						if (src.indexOf("/")!==-1) {
							if (jQuery('#dialog_addobj').data('changeimg')!==true) {								
								var imgobj = {imgurl: src, imglib:"objectlibrary", imgproportion:true, imgwidth: parseInt(so.data('mediawidth'),0)*size, imgheight: parseInt(so.data('mediaheight'),0)*size};													
								if (lastState==="object" && !addAsBg)
									addLayerImage(imgobj, par);
								else
								if (lastState==="background" || addAsBg)
									switchMainBGObject(src);
								else
								if (lastState==="layer") {									
									var objData = {};
									objData.bgimage_url = src;
									objData.image_librarysize = {};
									objData.image_librarysize.width = parseInt(so.data('mediawidth'),0)*size;
									objData.image_librarysize.height = parseInt(so.data('mediaheight'),0)*size;																			
									switchLayerBackground(objData);
								}
								
							} else {
								if (lastState==="object" && !addAsBg) {
									var objData = {};
									objData.image_url = src;
									objData.image_librarysize = {};
									objData.image_librarysize.width = parseInt(so.data('mediawidth'),0)*size;
									objData.image_librarysize.height = parseInt(so.data('mediaheight'),0)*size;	
									objData.scaleProportional = true;													

									t.updateCurrentLayer(objData);
									resetCurrentElementSize();
									redrawLayerHtml(t.selectedLayerSerial);									
									t.add_layer_change();
								}
								else
								if (lastState==="background" || addAsBg)
									switchMainBGObject(src);
								else
								if (lastState==="layer") {
									var objData = {};
									objData.bgimage_url = src;
									objData.image_librarysize = {};
									objData.image_librarysize.width = parseInt(so.data('mediawidth'),0)*size;
									objData.image_librarysize.height = parseInt(so.data('mediaheight'),0)*size;																			
									switchLayerBackground(objData);								
								}
							}
						} else {
							//Lade Image Über Get Object URL
							getMediaObjectUrl(src,par,size,jQuery('#dialog_addobj').data('changeimg'),lastState,addAsBg);
						}
						jQuery('#dialog_addobj').data('changeimg',false);									
				break;
				case "svg":
					var svg = so.find('svg');
					if (jQuery('#dialog_addobj').data('changesvg')!==true) {
						var data = {},
							w = svg.attr('width'),
							h = svg.attr('height');

						data['static_styles'] = {};
						data['static_styles'] = t.setVal(data['static_styles'], 'color', "#000000", true);
						data['deformation'] = {};
						data['deformation-hover'] = {};
						data.text = ' ';
						data.alias = 'SVG';
						data.type = 'svg';			
						data.style = '';
						data.svg = {};
						data.svg.src = jQuery(this).data('src');
						data = t.setVal(data, 'max_width', w, true);
						data = t.setVal(data, 'max_height', h, true);				
						data.createdOnInit = false;		
						addLayer(data);						
					} else {
						var src = jQuery(this).data('src'),
							w = svg.attr('width'),
							h = svg.attr('height');					

						serial = jQuery('#dialog_addobj').data('changesvgserial')				
						jQuery.get(src, function(data) {
							jQuery("#slide_layer_"+serial+" .innerslide_layer.tp-caption").first().html("");
							jQuery("#slide_layer_"+serial+" .innerslide_layer.tp-caption").first()[0].innerHTML = new XMLSerializer().serializeToString(data.documentElement);
							u.rebuildLayerIdle(jQuery("#slide_layer_"+serial));
							var objLayer = t.getLayer(serial),
								curw = parseInt(t.getVal(objLayer,'max_width'),0),
								curh = parseInt(t.getVal(objLayer,'max_height'),0);
							
							h = (curw / w) * h;
							w = curw;
							
							objLayer.svg.src = src;				  
							objLayer = t.setVal(objLayer, 'max_width', w, true);
							objLayer = t.setVal(objLayer, 'max_height', h, true);				
						});
						t.add_layer_change();
						jQuery('#dialog_addobj').data('changesvg',false);
					}
				break;
				case "icon":
					addLayerText(jQuery(this).data('isstatic') == true ? 'static' : null, '<i class="'+so.data('src')+'"></i>',50);
				break;
			}
			jQuery('#dialog_addobj').dialog('close');
		});
		
		
		
		jQuery('#button_add_layer_shape').click(function(){
			setExampleShape();
			jQuery('#dialog_addshape').dialog({
				buttons:{
					'Add':function(){
						//get values for shape
						var data = {};
						data['static_styles'] = {};
						data['deformation'] = {};
						data['deformation-hover'] = {};
						data.text = ' ';
						data.alias = 'Shape';
						data.type = 'shape';
						//data.style = 'tp-shape tp-shapewrapper';
						data.style = '';
						
						data.internal_class = 'tp-shape tp-shapewrapper';
						
						data.autolinebreak = false;
						
						data['deformation']['background-color'] = jQuery('input[name="adshape-color-1"]').val();
						data['deformation']['background-transparency'] = jQuery('input[name="adshape-opacity-1"]').val();
						data['deformation']['border-color'] = jQuery('input[name="adshape-border-color"]').val();
						data['deformation']['border-opacity'] = jQuery('input[name="adshape-border-opacity"]').val();
						data['deformation']['border-transparency'] = jQuery('input[name="adshape-border-opacity"]').val();
						data['deformation']['border-width'] = jQuery('input[name="adshape-border-width"]').val();
						data['deformation']['border-style'] = 'solid';
						data['deformation']['border-radius'] = [jQuery('.example-shape').css('borderTopLeftRadius'),jQuery('.example-shape').css('borderTopRightRadius'),jQuery('.example-shape').css('borderBottomRightRadius'),jQuery('.example-shape').css('borderBottomLeftRadius')];
						
						if(jQuery('input[name="shape_fullwidth"]')[0].checked){
							data['max_width'] = '100%';
							data['cover_mode'] = 'fullwidth';
						}else{
							data['max_width'] = jQuery('input[name="shape_width"]').val();
						}
						
						if(jQuery('input[name="shape_fullheight"]')[0].checked){
							data['max_height'] = '100%';
							data['cover_mode'] = 'fullheight';
						}else{
							data['max_height'] = jQuery('input[name="shape_height"]').val();
						}
						
						if(jQuery('input[name="shape_fullheight"]')[0].checked && jQuery('input[name="shape_fullwidth"]')[0].checked){
							data['cover_mode'] = 'cover';
						}
						
						//if(jQuery('input[name="shape_fullwidth"]')[0].checked && jQuery('input[name="shape_fullheight"]')[0].checked){
						//	data['deformation']['padding'] = [jQuery('.example-shape').css('paddingTop'), jQuery('.example-shape').css('paddingRight'), jQuery('.example-shape').css('paddingBottom'), jQuery('.example-shape').css('paddingLeft')];
						//}
						
						data.createdOnInit = false;
						addLayer(data);
						
						jQuery('#dialog_addshape').dialog('close');
						
					},'Close':function(){jQuery('#dialog_addshape').dialog('close');}
				},
				minWidth: 830,
				minHeight: 500,
				modal: true,
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
				dialogClass: 'tpdialogs'
			});
		});
		
		
		jQuery('#button_add_layer_import').click(function(){
			t.reset_import_layer();
			
			jQuery('#dialog_addimport').dialog({
				minWidth: 830,
				minHeight: 500,
				modal: true,
				dialogClass: 'tpdialogs',
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
			});
		});

		jQuery('#button_add_layer_group, #add_new_group').click(function(){
			addLayerGroup(jQuery(this).data('isstatic') == true ? 'static' : null);
		});

		jQuery('#add_new_row').click(function(){
			addLayerRow(jQuery(this).data('isstatic') == true ? 'static' : null);
		});
		
		
		/**
		 * get slides plus layers of the selected slider
		 * 
		 **/
		jQuery('#rs-import-layer-slider').change(function(){
			var im_slider_id = jQuery(this).val();
			if(im_slider_id == '-'){
				t.reset_import_layer();
				return false;
			}else{
				if(typeof(import_slides[im_slider_id]) == 'undefined'){ //get data for the im_slider_id
					UniteAdminRev.ajaxRequest('get_import_slides_data', im_slider_id, function(response){
						if(typeof(response.slides) !== 'undefined'){
							import_slides[im_slider_id] = response.slides;
							t.do_clear_layer_import();
							t.do_clear_slide_import();
							t.do_add_slide_import();
							t.do_show_sliders_import();
							return true;
						}else{
							alert(rev_lang.empty_data_retrieved_for_slider);
							t.reset_import_layer();
							return false;
						}
					});
					return false;
				}
				t.do_clear_layer_import();
				t.do_clear_slide_import();
				t.do_add_slide_import();
				t.do_show_sliders_import();
			}
		});
		
		jQuery('#rs-import-layer-type').change(function(){
			t.do_clear_layer_import();
			t.do_show_sliders_import();
		});
		
		jQuery('#rs-import-layer-slide').change(function(){
			t.do_clear_layer_import();
			t.do_show_sliders_import();
		});
		
		jQuery('body').on('click', '#rs-import-layer-holder li .import-layer-now', function(){
			if(confirm(rev_lang.import_selected_layer)){
				//import selected layer with the unique id clicked
				var btn = jQuery(this),
					li = btn.closest('li'),
					slider_id = li.data('sliderid'),
					slide_id = li.data('slideid'),
					unique_layer = li.data('id'),
					action_dependencies = li.data('actiondep');
				
				if(typeof(import_slides[slider_id]) == 'undefined') return false;
				if(typeof(import_slides[slider_id][slide_id]) == 'undefined') return false;
				
				var layers_to_add = t.get_layers_to_add_through_actions(import_slides[slider_id][slide_id]['layers'], unique_layer);
				
				//get the data, then use it to add a new layer
				if(layers_to_add!==null && layers_to_add.length > 0){
					if(layers_to_add.length > 1 && confirm(rev_lang.import_all_layer_from_actions)){
						var dependencies = [];
						dependencies = t.get_action_dependencies(li, slide_id, dependencies);
						
						for(var lta in layers_to_add){
							layers_to_add[lta].createdOnInit = false;
							addLayer(layers_to_add[lta], true);
							
							li.addClass("layerimported");
							btn.find('i').addClass("eg-icon-ok").removeClass("eg-icon-plus");
							
							for(var dkey in dependencies){
								var cli = jQuery('#to-import-layer-id-'+slide_id+'-'+dependencies[dkey]);
								if(!cli.hasClass('layerimported')){
									cli.addClass('layerimported');
									cli.find('.import-layer-now i').addClass("eg-icon-ok").removeClass("eg-icon-plus");
								}
							}
							
						}
					}else{ //just need to add one layer, so take the first one
						for(var lta in layers_to_add){
							//remove actions of first layer that are connected to other layers
							layers_to_add[lta] = t.remove_import_layer_actions(layers_to_add[lta]);
							layers_to_add[lta].createdOnInit = false;
							addLayer(layers_to_add[lta], true);
							li.addClass("layerimported");
							btn.find('i').addClass("eg-icon-ok").removeClass("eg-icon-plus");
							break;
						}
					}
				}
			}
		});
		
		t.object_library_loaded = false;
		t.callObjectLibraryDialog = function(type) {

			if(!t.object_library_loaded){
				
				
				UniteAdminRev.ajaxRequest('load_object_library', {}, function(response){
					if(response.success){
						//add data['list'] and data['html']
						for(var key in response.data['html']){
							
							if(response.data['html'][key]['type'] == 'tag'){				

								jQuery('.object-tag-list').append('<span class="obj_library_cats" id="obj_library_cats_'+response.data['html'][key]['handle']+'" data-tag="'+response.data['html'][key]['handle']+'">'+response.data['html'][key]['name']+'</span>');
							}else if(response.data['html'][key]['type'] == 'inner'){
								jQuery('#object_library_results-inner').append('<div style="display:none" class="rs-obj-library"></div>');
							}
						}
						
						for(var key in response.data['list']){
							var obj = { handle:key, list: []};
							for(var l in response.data['list'][key]){
								obj.list.push(response.data['list'][key][l]);
							}														
							obj_libraries.push(obj);														
						}
						
						push_objects_to_library();
						
						t.object_library_loaded = true;
						t.call_object_dialog(type);
					}
				});
			}else{
				t.call_object_dialog(type);
			}
		}
		
		t.call_object_dialog = function(type){

			jQuery('#dialog_addobj').dialog({								
				width:jQuery(window).width(),
				height:jQuery(window).height(),				
				modal: true,
				dialogClass: 'tpdialogs fullscreen-dialog-window objectlibrary_dialog',
				create:function(event,ui) {				
					var title = jQuery(event.target).parent().find('.ui-dialog-titlebar');
					title.addClass("tp-slider-new-dialog-title");
					title.prepend('<span class="revlogo-mini" style="margin-right:15px;"></span>');

				},
				hide:{effect:"",delay:250},
				open:function(event) {
					var holder = jQuery(event.target).parent();
					setTimeout(function() {
						holder.addClass("show");
					},200);
					if (jQuery('#dialog_addobj').data('last_open_state') !== type) {
						jQuery('#dialog_addobj').data('last_open_state',type);
						 
						var title = holder.find('.ui-dialog-titlebar .ui-dialog-title');
						if (type==="background") {							
							jQuery('.obj_library_cats_filter').hide();
							jQuery('#object_library_results').addClass("backgrounds");
							jQuery('#obj_lib_main_cat_filt_bgimage').show().click();							
							title.html("Add Background Image");
						} else if(type==='object') {
							jQuery('#object_library_results').removeClass("backgrounds");
							jQuery('.obj_library_cats_filter').show();
							jQuery('#obj_lib_main_cat_filt_all').show().click();
							title.html("Add Object Layer");
						} else if(type==='layer') {
							jQuery('.obj_library_cats_filter').hide();
							jQuery('#object_library_results').addClass("backgrounds");
							jQuery('#obj_lib_main_cat_filt_bgimage').show();
							jQuery('#obj_lib_main_cat_filt_image').show();							
							jQuery('#obj_lib_main_cat_filt_allimages').click();																					
							title.html("Add Image as Layer Background");
						}
					}
					 jQuery('#object_library_results-inner').perfectScrollbar("update");
					 if (jQuery('.obj_library_cats.selected').length==0)
						jQuery('.obj_library_cats').first().click();
					//ui is not available !?
					var ui = jQuery('#dialog_addobj').closest('.ui-dialog');
					ui.addClass("visible-fullscreen-dialog");
					t.setObjectLibraryHeight();										
				},
				beforeClose:function(event) {
					jQuery(event.target).parent().removeClass("show");
				},
				close:function(event) {
				
					var ui = jQuery('#dialog_addobj').closest('.ui-dialog');
					ui.removeClass("visible-fullscreen-dialog");
				}
			});	
		}
		
		
		t.setObjectLibraryHeight = function() {
			var das = jQuery('#dialog_addobj');
			if (das.is(":visible")) {				
				var	ol = jQuery('#object_library_results'),
					wh = jQuery(window).height(),
					hh = jQuery('#addobj-dialog-header').height(),
					th = das.parent().find('.tp-slider-new-dialog-title').height(),
					newh = wh-(hh+th+100);			
				das.height(wh-th);
				ol.height(newh);
			}
		}
		
		t.get_action_dependencies = function(li, slide_id, dependencies){
			var action_dependencies = li.data('actiondep');
			if(action_dependencies !== ''){
				action_dependencies = action_dependencies.toString().split(',');

				for(var adkey in action_dependencies){
					if(action_dependencies[adkey] !== 'backgroundvideo' && action_dependencies[adkey] !== 'firstvideo' && jQuery.inArray(action_dependencies[adkey], dependencies) == -1){
						
						dependencies.push(action_dependencies[adkey]);
						
						var new_dep = t.get_action_dependencies(jQuery('#to-import-layer-id-'+slide_id+'-'+action_dependencies[adkey]), slide_id, dependencies);

						for(var key in new_dep){
							if(jQuery.inArray(new_dep[key], dependencies) == -1) dependencies.push(new_dep[key]);
						}
					}
				}
			}

			return dependencies;
		}

		t.remove_import_layer_actions = function(layer){
			var attr = ['tooltip_event', 'action', 'image_link', 'link_open_in', 'jump_to_slide', 'scrollunder_offset', 'actioncallback', 'layer_target', 'action_delay', 'link_type', 'toggle_layer_type', 'toggle_class'];
			
			if(typeof(layer['layer_action']) !== 'undefined' && typeof(layer['layer_action']['action']) !== 'undefined' && layer['layer_action']['action'].length > 0){
				for(var lkey in layer['layer_action']['action']){
					switch(layer['layer_action']['action'][lkey]){
						case 'start_in':
						case 'start_out':
						case 'toggle_layer':
						case 'start_video':
						case 'stop_video':
						case 'toggle_video':
						case 'mute_video':
						case 'unmute_video':
						case 'toggle_global_mute_video':
						case 'toggle_mute_video':
						case 'simulate_click':
						case 'toggle_class':
							for(var akey in attr){
								if(typeof(layer['layer_action'][attr[akey]]) !== 'undefined' && typeof(layer['layer_action'][attr[akey]][lkey]) !== 'undefined') delete(layer['layer_action'][attr[akey]][lkey]);
							}
						break;
					}
				}
			}
			return layer;
		}
		
		t.get_layers_to_add_through_actions = function(layers, unique_id){
			var layers_to_add = [];
			
			layers_to_add = t.add_layer_to_queue_by_unique_id(layers, unique_id, layers_to_add);
			
			layers_to_add = t.check_actions_change_unique_ids(layers_to_add);
			
			return layers_to_add;
		}
		
		t.add_layer_to_queue_by_unique_id = function(layers, unique_id, layers_to_add){
			for(var key in layers){
				if(layers[key]['unique_id'] == unique_id){
					//remove the unique ID here, we need a new one
					
					layers_to_add.push(jQuery.extend(true, {}, layers[key]));
					
					if(typeof(layers[key]['layer_action']) !== 'undefined' && typeof(layers[key]['layer_action']['action']) !== 'undefined' && layers[key]['layer_action']['action'].length > 0){
						var actions = layers[key]['layer_action'];
						for(var lkey in actions['action']){
							switch(actions['action'][lkey]){
								case 'start_in':
								case 'start_out':
								case 'toggle_layer':
								case 'start_video':
								case 'stop_video':
								case 'toggle_video':
								case 'mute_video':
								case 'unmute_video':
								case 'toggle_mute_video':
								case 'toggle_global_mute_video':
								case 'simulate_click':
								case 'toggle_class':
									//check layers
									if(actions['layer_target'][lkey]){
										var do_add = true;
										for(var l in layers_to_add){
											if(layers_to_add[l]['unique_id'] == actions['layer_target'][lkey]){
												do_add = false;
												break;
											}
										}
										if(do_add){
											for(var akey in layers){
												if(layers[akey]['unique_id'] == actions['layer_target'][lkey]){
													t.add_layer_to_queue_by_unique_id(layers, layers[akey]['unique_id'], layers_to_add);
													//layers_to_add.push(jQuery.extend(true, {}, layers[akey]));
													break;
												}
											}
										}
									}
								break;
							}
						}
					}
				}
			}
			
			return layers_to_add;
		}
		
		t.check_actions_change_unique_ids = function(layers){
			//map the old layer ids with the new one they get now
			var map = {};
			
			for(var key in layers){
				unique_layer_id++;
				map[layers[key]['unique_id']] = unique_layer_id;
				layers[key]['unique_id'] = unique_layer_id;
			}
			
			//now change action layers connections to the new IDs
			//remove the go to slide actions
			for(var key in layers){
				if(typeof(layers[key]['layer_action']) !== 'undefined' && typeof(layers[key]['layer_action']['action']) !== 'undefined' && layers[key]['layer_action']['action'].length > 0){
					for(var lkey in layers[key]['layer_action']['layer_target']){
						for(var l in map){

							if(l == layers[key]['layer_action']['layer_target'][lkey]){
								layers[key]['layer_action']['layer_target'][lkey] = map[l];
								break;
							}
						}
					}
					for(var lkey in layers[key]['layer_action']['jump_to_slide']){
						layers[key]['layer_action']['jump_to_slide'][lkey] = '-1';
					}
				}
			}
			
			return layers;
		}
		
		t.reset_import_layer = function(){
			jQuery('#rs-import-layer-slider option[value="-"]').attr('selected', true);
			jQuery('#rs-import-layer-slide option[value="-"]').attr('selected', true);
			jQuery('#rs-import-layer-type option[value="-"]').attr('selected', true);
		}
		
		/**
		 * add slides to dropdown
		 **/
		t.do_add_slide_import = function(){
			var im_slider_id = jQuery('#rs-import-layer-slider option:selected').val();
			if(im_slider_id == '-' || typeof(import_slides[im_slider_id]) == 'undefined') return false;
			
			for(var key in import_slides[im_slider_id]){
				jQuery('#rs-import-layer-slide').append(jQuery('<option></option>').val(key).text('Slide: '+import_slides[im_slider_id][key]['params']['title']));
			}
		}
		
		t.do_clear_slide_import = function(){
			jQuery('#rs-import-layer-slide option').each(function(){
				if(jQuery(this).val() !== 'all' && jQuery(this).val() !== '-') jQuery(this).remove();
			});
		}
		
		t.do_clear_layer_import = function(){
			jQuery('#rs-import-layer-holder').html('');
		}
		
		t.do_show_sliders_import = function(){
			var im_slider_id = jQuery('#rs-import-layer-slider option:selected').val();
			var im_slide_id = jQuery('#rs-import-layer-slide option:selected').val();
			var im_slide_type = jQuery('#rs-import-layer-type option:selected').val();
			
			if(im_slider_id == '-') return false;
			
			if(typeof(import_slides[im_slider_id]) == 'undefined') return false;			
			for(var key in import_slides[im_slider_id]){				
				if(im_slide_id == 'all' || im_slide_id == '-' || im_slide_id == key){
					if (import_slides[im_slider_id][key]['layers'].length>0)
					jQuery('#rs-import-layer-holder').append('<li class="layer-import-slide-seperator">Slide Title - '+import_slides[im_slider_id][key].params.title+'</li>')

					for(var lkey in import_slides[im_slider_id][key]['layers']){

						if(im_slide_type == 'all' || im_slide_type == '-' || im_slide_type == import_slides[im_slider_id][key]['layers'][lkey]['type']){
							
							var action_string = [];
							action_string = t.get_action_string_dependencies(import_slides[im_slider_id][key]['layers'][lkey], im_slide_id, action_string, import_slides[im_slider_id][key]['layers']);
							
							var has_action = 'off';
							if(typeof(import_slides[im_slider_id][key]['layers'][lkey]['layer_action']) !== 'undefined' && typeof(import_slides[im_slider_id][key]['layers'][lkey]['layer_action']['action']) !== 'undefined' && import_slides[im_slider_id][key]['layers'][lkey]['layer_action']['action'].length > 0){
								for(var akey in import_slides[im_slider_id][key]['layers'][lkey]['layer_action']['action']){
									switch(import_slides[im_slider_id][key]['layers'][lkey]['layer_action']['action'][akey]){
										case 'start_in':
										case 'start_out':
										case 'toggle_layer':
										case 'start_video':
										case 'stop_video':
										case 'toggle_video':
										case 'mute_video':
										case 'unmute_video':
										case 'toggle_mute_video':
										case 'toggle_global_mute_video':
										case 'simulate_click':
										case 'toggle_class':
											action_string.push(import_slides[im_slider_id][key]['layers'][lkey]['layer_action']['layer_target'][akey]);
										break;
									}
								}
								has_action = 'on';
							}
							
							var content = global_layer_import_template({
								'withaction': has_action,
								'action_layers': action_string,
								'type': import_slides[im_slider_id][key]['layers'][lkey]['type'],
								'alias': import_slides[im_slider_id][key]['layers'][lkey]['alias'],
								'width': import_slides[im_slider_id][key]['layers'][lkey]['width'],
								'height': import_slides[im_slider_id][key]['layers'][lkey]['height'],
								'unique_id': import_slides[im_slider_id][key]['layers'][lkey]['unique_id'],
								'slider_id': im_slider_id,
								'slide_id': key
							});
							
							jQuery('#rs-import-layer-holder').append(content);
						}
					}
				}
			}
			
		}
		
		
		t.get_action_string_dependencies = function(layer, slide_id, action_string, layers){
			
			if(typeof(layer['layer_action']) !== 'undefined' && typeof(layer['layer_action']['action']) !== 'undefined' && layer['layer_action']['action'].length > 0){
				for(var akey in layer['layer_action']['action']){
					switch(layer['layer_action']['action'][akey]){
						case 'start_in':
						case 'start_out':
						case 'toggle_layer':
						case 'start_video':
						case 'stop_video':
						case 'toggle_video':
						case 'mute_video':
						case 'unmute_video':
						case 'toggle_mute_video':
						case 'toggle_global_mute_video':
						case 'simulate_click':
						case 'toggle_class':
							if(typeof(layer['layer_action']['layer_target']) !== 'undefined' && typeof(layer['layer_action']['layer_target'][akey]) !== 'undefined' && layer['layer_action']['layer_target'][akey] !== 'backgroundvideo' && layer['layer_action']['layer_target'][akey] !== 'firstvideo' && jQuery.inArray(layer['layer_action']['layer_target'][akey], action_string) == -1){
								action_string.push(layer['layer_action']['layer_target'][akey]);
								
								for(var lkey in layers){
									if(layers[lkey]['unique_id'] == layer['layer_action']['layer_target'][akey]){
										
										var new_action = t.get_action_string_dependencies(layers[lkey], slide_id, action_string, layers);
										for(var key in new_action){
											if(jQuery.inArray(new_action[key], action_string) == -1) action_string.push(new_action[key]);
										}
										break;
									}
								}

							}
						break;
					}
				}
			}
			
			return action_string;
		}
		
		jQuery('body').on('click', '.addbutton-examples-wrapper a.rev-btn', function(){
			//get values for buttons
			var data = {};
			data['static_styles'] = {};
			data['inline'] = {'idle':{}, 'hover':{}};
			data['deformation'] = {};
			data['deformation-hover'] = {};
			data.text = jQuery('input[name="adbutton-text"]').val();
			data.type = 'button';
			data.subtype = 'roundbutton'; //no_edit
			data.specialsettings = {};
			
			data.alias = 'Button';
			data.style = '';//'rev-btn';//jQuery(this).attr('class');
			
			data.internal_class = jQuery(this).data('needclass');
			
			//missing class needs to be added here as some special!
			
			data['resize-full'] = false;
			data['resizeme'] = false;
			
			data['static_styles']['color'] = jQuery('input[name="adbutton-color-2"]').val();
			data['static_styles']['font-size'] = jQuery(this).css('font-size');
			data['static_styles']['line-height'] = jQuery(this).css('font-size');
			//data['static_styles']['line-height'] = jQuery(this).css('line-height');
			data['static_styles']['font-weight'] = jQuery(this).css('font-weight');
			
			data['max_width'] = 'auto';
			data['max_height'] = 'auto';
			
			data['autolinebreak'] = false;
			
			data['deformation']['padding'] = [jQuery(this).css('paddingTop'), jQuery(this).css('paddingRight'), jQuery(this).css('paddingBottom'), jQuery(this).css('paddingLeft')];
			
			
			data['deformation']['font-family'] = jQuery('input[name="adbutton-fontfamily"]').val();
			data['deformation']['background-color'] = jQuery('input[name="adbutton-color-1"]').val();
			data['deformation']['background-transparency'] = jQuery('input[name="adbutton-opacity-1"]').val();
			data['deformation']['color-transparency'] = jQuery('input[name="adbutton-opacity-2"]').val();
			data['deformation']['border-radius'] = [jQuery(this).css('borderTopLeftRadius'),jQuery(this).css('borderTopRightRadius'),jQuery(this).css('borderBottomRightRadius'),jQuery(this).css('borderBottomLeftRadius')];
			data['deformation']['border-color'] = jQuery('input[name="adbutton-border-color"]').val();
			data['deformation']['border-transparency'] = jQuery('input[name="adbutton-border-opacity"]').val();
			data['deformation']['border-opacity'] = jQuery('input[name="adbutton-border-opacity"]').val();
			//data['deformation']['border-width'] = jQuery('input[name="adbutton-border-width"]').val();
			data['deformation']['border-width'] = [jQuery('input[name="adbutton-border-width"]').val(),jQuery('input[name="adbutton-border-width"]').val(),jQuery('input[name="adbutton-border-width"]').val(),jQuery('input[name="adbutton-border-width"]').val()];
			data['deformation']['border-style'] = 'solid';
			
			if(jQuery(this).hasClass('rev-withicon')){
				data['deformation']['icon-class'] = jQuery('.addbutton-icon i').attr('class'); //needs to be added
				data.text += '<i class="' + data['deformation']['icon-class'] + '"></i>';
			}else{
				data['deformation']['icon-class'] = '';
			}
			
			data['hover'] = true;
			data['deformation-hover']['background-color'] = jQuery('input[name="adbutton-color-1-h"]').val();
			data['deformation-hover']['background-transparency'] = jQuery('input[name="adbutton-opacity-1-h"]').val();
			data['deformation-hover']['color'] = jQuery('input[name="adbutton-color-2-h"]').val();
			data['deformation-hover']['color-transparency'] = jQuery('input[name="adbutton-opacity-2-h"]').val();
			data['deformation-hover']['border-radius'] = [jQuery(this).css('borderTopLeftRadius'),jQuery(this).css('borderTopRightRadius'),jQuery(this).css('borderBottomRightRadius'),jQuery(this).css('borderBottomLeftRadius')];
			data['deformation-hover']['border-color'] = jQuery('input[name="adbutton-border-color-h"]').val();
			data['deformation-hover']['border-transparency'] = jQuery('input[name="adbutton-border-opacity-h"]').val();
			data['deformation-hover']['border-opacity'] = jQuery('input[name="adbutton-border-opacity-h"]').val();
			//data['deformation-hover']['border-width'] = jQuery('input[name="adbutton-border-width-h"]').val();
			data['deformation-hover']['border-width'] = [jQuery('input[name="adbutton-border-width-h"]').val(),jQuery('input[name="adbutton-border-width-h"]').val(),jQuery('input[name="adbutton-border-width-h"]').val(),jQuery('input[name="adbutton-border-width-h"]').val()];
			data['deformation-hover']['border-style'] = 'solid';
			
			if(jQuery(this).hasClass('rev-hiddenicon')){
				data['deformation-hover']['icon-class'] = jQuery('.addbutton-icon i').attr('class'); //needs to be added
				data.text += ' <i class="' + data['deformation-hover']['icon-class'] + '"></i>';
			}else{
				data['deformation-hover']['icon-class'] = '';
			}
			
			
			//add stylings depending on classes it has
			if(jQuery(this).hasClass('rev-btn')){
				data['deformation']['text-decoration'] = 'none';
				data['deformation-hover']['css_cursor'] = 'pointer';
				data['inline']['idle']['outline'] = 'none';
				data['inline']['idle']['box-shadow'] = 'none';
				data['inline']['idle']['box-sizing'] = 'border-box';
				data['inline']['idle']['-moz-box-sizing'] = 'border-box';
				data['inline']['idle']['-webkit-box-sizing'] = 'border-box';
			}
			
			if(jQuery(this).hasClass('rev-uppercase')){
				data['inline']['idle']['text-transform'] = 'uppercase';
				data['inline']['idle']['letter-spacing'] = '1px';
			}
			
			/*
			if(jQuery(this).hasClass('rev-medium')){
			}
			
			if(jQuery(this).hasClass('rev-small')){
			}
			
			if(jQuery(this).hasClass('rev-maxround')){
			}
			
			if(jQuery(this).hasClass('rev-minround')){
			}
			*/
			
			data.createdOnInit = false;
			addLayer(data);
			
			jQuery('#dialog_addbutton').dialog('close');
			
		});
		
		var addSpecialButton = function(btn) {
			//get values for buttons
			var data = {};
			data['static_styles'] = {};
			data['inline'] = {'idle':{}, 'hover':{}};
			data['deformation'] = {};
			data['deformation-hover'] = {};
			data.text = btn.html();
			data.type = 'button'; //no_edit
			
			data.specialsettings = {};
			
			
			data.style = ''; //jQuery(this).attr('class');
			data.internal_class = btn.data('needclass');
			
			data['resize-full'] = false;
			data['resizeme'] = false;
			
			data['max_width'] = btn.css('width');
			data['max_height'] = btn.css('height');
			
			data['deformation']['padding'] = [btn.css('paddingTop'), btn.css('paddingRight'), btn.css('paddingBottom'), btn.css('paddingLeft')];
			
			
			data['deformation']['background-color'] = UniteAdminRev.rgb2hex(btn.css('backgroundColor'));
			var bgOpacity = UniteAdminRev.getTransparencyFromRgba(btn.css('backgroundColor'));
		    bgOpacity = bgOpacity === false ? 1 : bgOpacity;
			if(bgOpacity == 0) data['deformation']['background-color'] = 'transparent';
			
			data['deformation']['background-opacity'] = bgOpacity;
			data['deformation']['background-transparency'] = bgOpacity;
			
			
			data['deformation']['border-color'] = UniteAdminRev.rgb2hex(btn.css('borderTopColor'));
			var borOpacity = UniteAdminRev.getTransparencyFromRgba(btn.css('borderTopColor'));
		    borOpacity = borOpacity === false ? 1 : borOpacity;
			if(borOpacity == 0) data['deformation']['border-color'] = 'transparent';
			
			data['deformation']['border-opacity'] = borOpacity;
			data['deformation']['border-transparency'] = borOpacity;
			
			
			data['deformation']['border-radius'] = [btn.css('borderTopLeftRadius'),btn.css('borderTopRightRadius'),btn.css('borderBottomRightRadius'),btn.css('borderBottomLeftRadius')];
			
			//data['deformation']['border-width'] = btn.css('borderTopWidth');
			data['deformation']['border-width'] = [btn.css('borderTopWidth'),btn.css('borderRightWidth'),btn.css('borderBottomWidth'),btn.css('borderLeftWidth')];
			data['deformation']['border-style'] = btn.css('borderTopStyle');
			
			data['deformation-hover']['css_cursor'] = btn.css('cursor');
			
			data['inline']['idle']['box-sizing'] = 'border-box';
			data['inline']['idle']['-moz-box-sizing'] = 'border-box';
			data['inline']['idle']['-webkit-box-sizing'] = 'border-box';
			
			return data;
		}


		jQuery('body').on('click', '.addbutton-examples-wrapper div.rev-burger', function(){			
			var data = addSpecialButton(jQuery(this));			
			data.alias = 'Burger Button';
			data.subtype = 'burgerbutton'; //no_edit
			//add actions here
			data['layer_action'] = {};
			data['layer_action'].tooltip_event = [];
			data['layer_action'].tooltip_event.push('click');
			data['layer_action'].action = [];
			data['layer_action'].action.push('toggle_class');
			data['layer_action'].layer_target = [];
			data['layer_action'].layer_target.push('self');
			data['layer_action'].action_delay = [];
			data['layer_action'].action_delay.push(0);
			data['layer_action'].toggle_class = [];
			data['layer_action'].toggle_class.push('open');		
			data.createdOnInit = false;	
			addLayer(data);			
			jQuery('#dialog_addbutton').dialog('close');			
		});
		
		jQuery('body').on('click', '.addbutton-examples-wrapper span.rev-control-btn', function(){			
			var data = addSpecialButton(jQuery(this));			
			data.alias = 'Control Button';
			data.subtype = 'controlbutton';
			
			if(data['static_styles'] === undefined) data['static_styles'] = {};
			
			data['static_styles']['font-size'] = jQuery(this).css('font-size');
			data['static_styles']['line-height'] = jQuery(this).css('line-height');
			data['static_styles']['font-weight'] = jQuery(this).css('font-weight');
			data['static_styles']['color'] = UniteAdminRev.rgb2hex(jQuery(this).css('color'));
			
			data['deformation']['font-family'] = jQuery(this).css('font-family');
			data['text-align'] = jQuery(this).css('text-align');
			//data['deformation']['text-align'] = jQuery(this).css('text-align');
			data['deformation']['vertical-align'] = jQuery(this).css('vertical-align');
			
			
			
			data.createdOnInit = false;
			addLayer(data);			
			jQuery('#dialog_addbutton').dialog('close');			
		});
		
		
		jQuery('body').on('click', '.addbutton-examples-wrapper span.rev-scroll-btn', function(){
			var data = addSpecialButton(jQuery(this));			
			data.subtype = 'scrollbutton'; //no_edit
			data.alias = 'Scroll Button';
			data.createdOnInit = false;
			addLayer(data);			
			jQuery('#dialog_addbutton').dialog('close');
		});
		
		
		
		

		//insert button link - open the dialog
		jQuery("#linkInsertTemplate").click(function(){
			if(jQuery(this).hasClass("disabled"))
				return(false);
			
			add_meta_into = '';
			
			var buttons = {"Cancel":function(){jQuery("#dialog_template_insert").dialog("close")}}
			jQuery("#dialog_template_insert").dialog({
				buttons:buttons,
				minWidth:700,
				dialogClass:"tpdialogs",
				modal:true,
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
			});

		});
		
		//insert button link - open the dialog
		jQuery(".rs-param-meta-open").click(function(){
			
			add_meta_into = 'params_'+jQuery(this).data('curid');
			
			var buttons = {"Cancel":function(){jQuery("#dialog_template_insert").dialog("close")}}
			jQuery("#dialog_template_insert").dialog({
				buttons:buttons,
				minWidth:700,
				dialogClass:"tpdialogs",
				modal:true,
				create:function(ui) {				
					jQuery(ui.target).parent().find('.ui-dialog-titlebar').addClass("tp-slider-new-dialog-title");
				},
			});

		});

		jQuery('#rs-undo-handler').click(function(){
			t.undo_redo_layer('undo');
		});
		
		jQuery('#rs-redo-handler').click(function(){
			t.undo_redo_layer('redo');
		});
		
		
		jQuery('body').on('click', '.rs-undo-step', function(){
			var step = jQuery(this).data('gotokey');
			t.undo_redo_layer('undo', step);
		});
		
		jQuery('body').on('click', '.rs-redo-step', function(){
			var step = jQuery(this).data('gotokey');
			t.undo_redo_layer('redo', step);
		});
	}

	//======================================================
	//		Init Function End
	//======================================================

	
	/**
	 * get the values of custom animation dialog
	 */
	var createNewAnimObj = function(what){
		
		var customAnim = new Object;
		if(what == 'start'){
			customAnim['movex'] = jQuery('input[name="layer_anim_xstart"]').val();
			customAnim['movey'] = jQuery('input[name="layer_anim_ystart"]').val();
			customAnim['mask'] = jQuery('#masking-start')[0].checked;
			customAnim['movez'] = jQuery('input[name="layer_anim_zstart"]').val();
			customAnim['rotationx'] = jQuery('input[name="layer_anim_xrotate"]').val();
			customAnim['rotationy'] = jQuery('input[name="layer_anim_yrotate"]').val();
			customAnim['rotationz'] = jQuery('input[name="layer_anim_zrotate"]').val();
			customAnim['scalex'] = jQuery('input[name="layer_scale_xstart"]').val();
			customAnim['scaley'] = jQuery('input[name="layer_scale_ystart"]').val();
			customAnim['skewx'] = jQuery('input[name="layer_skew_xstart"]').val();
			customAnim['skewy'] = jQuery('input[name="layer_skew_ystart"]').val();
			customAnim['captionopacity'] = jQuery('input[name="layer_opacity_start"]').val();
			customAnim['mask'] = jQuery('#masking-start')[0].checked;
			customAnim['mask_x'] = jQuery('input[name="mask_anim_xstart"]').val();
			customAnim['mask_y'] = jQuery('input[name="mask_anim_ystart"]').val();
			customAnim['mask_ease'] = jQuery('input[name="mask_easing"]').val();
			customAnim['mask_speed'] = jQuery('input[name="mask_speed"]').val();
			customAnim['easing'] = jQuery('select[name="layer_easing"] option:selected').val();
			customAnim['speed'] = jQuery('input[name="layer_speed"]').val();
			customAnim['split'] = jQuery('select[name="layer_split"] option:selected').val();
			customAnim['splitdelay'] = jQuery('input[name="layer_splitdelay"]').val();
			
			customAnim['movex_reverse'] = jQuery('#layer_anim_xstart_reverse')[0].checked;
			customAnim['movey_reverse'] = jQuery('#layer_anim_ystart_reverse')[0].checked;
			customAnim['rotationx_reverse'] = jQuery('#layer_anim_xrotate_reverse')[0].checked;
			customAnim['rotationy_reverse'] = jQuery('#layer_anim_yrotate_reverse')[0].checked;
			customAnim['rotationz_reverse'] = jQuery('#layer_anim_zrotate_reverse')[0].checked;
			customAnim['scalex_reverse'] = jQuery('#layer_scale_xstart_reverse')[0].checked;
			customAnim['scaley_reverse'] = jQuery('#layer_scale_ystart_reverse')[0].checked;
			customAnim['skewx_reverse'] = jQuery('#layer_skew_xstart_reverse')[0].checked;
			customAnim['skewy_reverse'] = jQuery('#layer_skew_ystart_reverse')[0].checked;
			customAnim['mask_x_reverse'] = jQuery('#mask_anim_xstart_reverse')[0].checked;
			customAnim['mask_y_reverse'] = jQuery('#mask_anim_ystart_reverse')[0].checked;
			
		}else{
			customAnim['movex'] = jQuery('#layer_anim_xend').val();
			customAnim['movey'] = jQuery('#layer_anim_yend').val();
			customAnim['movez'] = jQuery('#layer_anim_zend').val();
			customAnim['rotationx'] = jQuery('#layer_anim_xrotate_end').val();
			customAnim['rotationy'] = jQuery('#layer_anim_yrotate_end').val();
			customAnim['rotationz'] = jQuery('#layer_anim_zrotate_end').val();
			customAnim['scalex'] = jQuery('#layer_scale_xend').val();
			customAnim['scaley'] = jQuery('#layer_scale_yend').val();
			customAnim['skewx'] = jQuery('#layer_skew_xend').val();
			customAnim['skewy'] = jQuery('#layer_skew_yend').val();
			customAnim['captionopacity'] = jQuery('#layer_opacity_end').val();
			customAnim['mask'] = jQuery('#masking-end')[0].checked;
			customAnim['mask_x'] = jQuery('#mask_anim_xend').val();
			customAnim['mask_y'] = jQuery('#mask_anim_yend').val();
			//customAnim['mask_ease'] = jQuery('input[name="mask_easing_end"]').val();
			//customAnim['mask_speed'] = jQuery('input[name="mask_speed_end"]').val();
			customAnim['easing'] = jQuery('#layer_endeasing option:selected').val();
			customAnim['speed'] = jQuery('#layer_endspeed').val();
			customAnim['split'] = jQuery('#layer_endsplit option:selected').val();
			customAnim['splitdelay'] = jQuery('#layer_endsplitdelay').val();
			
			customAnim['movex_reverse'] = jQuery('#layer_anim_xend_reverse')[0].checked;
			customAnim['movey_reverse'] = jQuery('#layer_anim_yend_reverse')[0].checked;
			customAnim['rotationx_reverse'] = jQuery('#layer_anim_xrotate_end_reverse')[0].checked;
			customAnim['rotationy_reverse'] = jQuery('#layer_anim_yrotate_end_reverse')[0].checked;
			customAnim['rotationz_reverse'] = jQuery('#layer_anim_zrotate_end_reverse')[0].checked;
			customAnim['scalex_reverse'] = jQuery('#layer_scale_xend_reverse')[0].checked;
			customAnim['scaley_reverse'] = jQuery('#layer_scale_yend_reverse')[0].checked;
			customAnim['skewx_reverse'] = jQuery('#layer_skew_xend_reverse')[0].checked;
			customAnim['skewy_reverse'] = jQuery('#layer_skew_yend_reverse')[0].checked;
			customAnim['mask_x_reverse'] = jQuery('#mask_anim_xend_reverse')[0].checked;
			customAnim['mask_y_reverse'] = jQuery('#mask_anim_xend_reverse')[0].checked;
		}
		return customAnim;

	}


	/**
	 * set the values of custom animation dialog
	 */
	var setNewAnimFromObj = function(what, obj_v){
		
		if(obj_v == undefined) return true;
		
		if(what == 'start'){
			if(obj_v['movex'] !== undefined) { jQuery('input[name="layer_anim_xstart"]').val(obj_v['movex']); }else{ jQuery('input[name="layer_anim_xstart"]').val(0); }
			if(obj_v['movey'] !== undefined) { jQuery('input[name="layer_anim_ystart"]').val(obj_v['movey']); }else{ jQuery('input[name="layer_anim_ystart"]').val(0); }
			if(obj_v['movez'] !== undefined) { jQuery('input[name="layer_anim_zstart"]').val(obj_v['movez']); }else{ jQuery('input[name="layer_anim_zstart"]').val(0); }
			if(obj_v['rotationx'] !== undefined) { jQuery('input[name="layer_anim_xrotate"]').val(obj_v['rotationx']); }else{ jQuery('input[name="layer_anim_xrotate"]').val(0); }
			if(obj_v['rotationy'] !== undefined) { jQuery('input[name="layer_anim_yrotate"]').val(obj_v['rotationy']); }else{ jQuery('input[name="layer_anim_yrotate"]').val(0); }
			if(obj_v['rotationz'] !== undefined) { jQuery('input[name="layer_anim_zrotate"]').val(obj_v['rotationz']); }else{ jQuery('input[name="layer_anim_zrotate"]').val(0); }
			if(obj_v['scalex'] !== undefined) { jQuery('input[name="layer_scale_xstart"]').val(obj_v['scalex']); }else{ jQuery('input[name="layer_scale_xstart"]').val(0); }
			if(obj_v['scaley'] !== undefined) { jQuery('input[name="layer_scale_ystart"]').val(obj_v['scaley']); }else{ jQuery('input[name="layer_scale_ystart"]').val(0); }
			if(obj_v['skewx'] !== undefined) { jQuery('input[name="layer_skew_xstart"]').val(obj_v['skewx']); }else{ jQuery('input[name="layer_skew_xstart"]').val(0); }
			if(obj_v['skewy'] !== undefined) { jQuery('input[name="layer_skew_ystart"]').val(obj_v['skewy']); }else{ jQuery('input[name="layer_skew_ystart"]').val(0); }
			if(obj_v['captionopacity'] !== undefined) { jQuery('input[name="layer_opacity_start"]').val(obj_v['captionopacity']); }else{ jQuery('input[name="layer_opacity_start"]').val(0); }
			if(obj_v['mask'] !== undefined && (obj_v['mask'] == 'true' || obj_v['mask'] == true)) { jQuery('#masking-start').attr('checked', true); }else{ jQuery('#masking-start').attr('checked', false); }
			if(obj_v['mask_x'] !== undefined) { jQuery('input[name="mask_anim_xstart"]').val(obj_v['mask_x']); }else{ jQuery('input[name="mask_anim_xstart"]').val(0); }
			if(obj_v['mask_y'] !== undefined) { jQuery('input[name="mask_anim_ystart"]').val(obj_v['mask_y']); }else{ jQuery('input[name="mask_anim_ystart"]').val(0); }
			if(obj_v['mask_ease'] !== undefined) { jQuery('input[name="mask_easing"]').val(obj_v['mask_ease']); }else{ jQuery('input[name="mask_easing"]').val(0); }
			if(obj_v['mask_speed'] !== undefined) { jQuery('input[name="mask_speed"]').val(obj_v['mask_speed']); }else{ jQuery('input[name="mask_speed"]').val(0); }
			
			if(obj_v['easing'] !== undefined) { jQuery('select[name="layer_easing"] option[value="'+obj_v['easing']+'"]').attr('selected', 'selected'); }
			if(obj_v['speed'] !== undefined) { jQuery('input[name="layer_speed"]').val(obj_v['speed']); }
			if(obj_v['split'] !== undefined) { jQuery('select[name="layer_split"] option[value="'+obj_v['split']+'"]').attr('selected', 'selected'); }
			if(obj_v['splitdelay'] !== undefined) { jQuery('input[name="layer_splitdelay"]').val(obj_v['splitdelay']); }
			
			
			if(obj_v['movex_reverse'] !== undefined && (obj_v['movex_reverse'] == 'true' || obj_v['movex_reverse'] == true)) { jQuery('#layer_anim_xstart_reverse').attr('checked', true); }else{ jQuery('#layer_anim_xstart_reverse').attr('checked', false); }
			if(obj_v['movey_reverse'] !== undefined && (obj_v['movey_reverse'] == 'true' || obj_v['movey_reverse'] == true)) { jQuery('#layer_anim_ystart_reverse').attr('checked', true); }else{ jQuery('#layer_anim_ystart_reverse').attr('checked', false); }
			if(obj_v['rotationx_reverse'] !== undefined && (obj_v['rotationx_reverse'] == 'true' || obj_v['rotationx_reverse'] == true)) { jQuery('input[name="layer_anim_xrotate_start_reverse"]').attr('checked', true); }else{ jQuery('input[name="layer_anim_xrotate_start_reverse"]').attr('checked', false); }
			if(obj_v['rotationy_reverse'] !== undefined && (obj_v['rotationy_reverse'] == 'true' || obj_v['rotationy_reverse'] == true)) { jQuery('input[name="layer_anim_yrotate_start_reverse"]').attr('checked', true); }else{ jQuery('input[name="layer_anim_yrotate_start_reverse"]').attr('checked', false); }
			if(obj_v['rotationz_reverse'] !== undefined && (obj_v['rotationz_reverse'] == 'true' || obj_v['rotationz_reverse'] == true)) { jQuery('input[name="layer_anim_zrotate_start_reverse"]').attr('checked', true); }else{ jQuery('input[name="layer_anim_zrotate_start_reverse"]').attr('checked', false); }
			if(obj_v['scalex_reverse'] !== undefined && (obj_v['scalex_reverse'] == 'true' || obj_v['scalex_reverse'] == true)) { jQuery('#layer_scale_xstart_reverse').attr('checked', true); }else{ jQuery('#layer_scale_xstart_reverse').attr('checked', false); }
			if(obj_v['scaley_reverse'] !== undefined && (obj_v['scaley_reverse'] == 'true' || obj_v['scaley_reverse'] == true)) { jQuery('#layer_scale_ystart_reverse').attr('checked', true); }else{ jQuery('#layer_scale_ystart_reverse').attr('checked', false); }
			if(obj_v['skewx_reverse'] !== undefined && (obj_v['skewx_reverse'] == 'true' || obj_v['skewx_reverse'] == true)) { jQuery('#layer_skew_xstart_reverse').attr('checked', true); }else{ jQuery('#layer_skew_xstart_reverse').attr('checked', false); }
			if(obj_v['skewy_reverse'] !== undefined && (obj_v['skewy_reverse'] == 'true' || obj_v['skewy_reverse'] == true)) { jQuery('#layer_skew_ystart_reverse').attr('checked', true); }else{ jQuery('#layer_skew_ystart_reverse').attr('checked', false); }
			if(obj_v['mask_x_reverse'] !== undefined && (obj_v['mask_x_reverse'] == 'true' || obj_v['mask_x_reverse'] == true)) { jQuery('#mask_anim_xstart_reverse').attr('checked', true); }else{ jQuery('#mask_anim_xstart_reverse').attr('checked', false); }
			if(obj_v['mask_y_reverse'] !== undefined && (obj_v['mask_y_reverse'] == 'true' || obj_v['mask_y_reverse'] == true)) { jQuery('#mask_anim_ystart_reverse').attr('checked', true); }else{ jQuery('#mask_anim_ystart_reverse').attr('checked', false); }
			
		}else{
			if(obj_v['movex'] !== undefined) { jQuery('#layer_anim_xend').val(obj_v['movex']); }else{ jQuery('#layer_anim_xend').val(0); }
			if(obj_v['movey'] !== undefined) { jQuery('#layer_anim_yend').val(obj_v['movey']); }else{ jQuery('#layer_anim_yend').val(0); }
			if(obj_v['movez'] !== undefined) { jQuery('#layer_anim_zend').val(obj_v['movez']); }else{ jQuery('#layer_anim_zend').val(0); }
			if(obj_v['rotationx'] !== undefined) { jQuery('#layer_anim_xrotate_end').val(obj_v['rotationx']); }else{ jQuery('#layer_anim_xrotate_end').val(0); }
			if(obj_v['rotationy'] !== undefined) { jQuery('#layer_anim_yrotate_end').val(obj_v['rotationy']); }else{ jQuery('#layer_anim_yrotate_end').val(0); }
			if(obj_v['rotationz'] !== undefined) { jQuery('#layer_anim_zrotate_end').val(obj_v['rotationz']); }else{ jQuery('#layer_anim_zrotate_end').val(0); }
			if(obj_v['scalex'] !== undefined) { jQuery('#layer_scale_xend').val(obj_v['scalex']); }else{ jQuery('#layer_scale_xend').val(0); }
			if(obj_v['scaley'] !== undefined) { jQuery('#layer_scale_yend').val(obj_v['scaley']); }else{ jQuery('#layer_scale_yend').val(0); }
			if(obj_v['skewx'] !== undefined) { jQuery('#layer_skew_xend').val(obj_v['skewx']); }else{ jQuery('#layer_skew_xend').val(0); }
			if(obj_v['skewy'] !== undefined) { jQuery('#layer_skew_yend').val(obj_v['skewy']); }else{ jQuery('#layer_skew_yend').val(0); }
			if(obj_v['captionopacity'] !== undefined) { jQuery('#layer_opacity_end').val(obj_v['captionopacity']); }else{ jQuery('#layer_opacity_end').val(0); }
			if(obj_v['mask'] !== undefined && (obj_v['mask'] == 'true' || obj_v['mask'] == true)) { jQuery('#masking-end').attr('checked', true); }else{ jQuery('#masking-end').attr('checked', false); }
			if(obj_v['mask_x'] !== undefined) { jQuery('#mask_anim_xend').val(obj_v['mask_x']); }else{ jQuery('#mask_anim_xend').val(0); }
			if(obj_v['mask_y'] !== undefined) { jQuery('#mask_anim_yend').val(obj_v['mask_y']); }else{ jQuery('#mask_anim_yend').val(0); }
			//if(obj_v['mask_ease'] !== undefined) { jQuery('input[name="mask_easing_end"]').val(obj_v['mask_ease']); }else{ jQuery('input[name="mask_easing_end"]').val(0); }
			//if(obj_v['mask_speed'] !== undefined) { jQuery('input[name="mask_speed_end"]').val(obj_v['mask_speed']); }else{ jQuery('input[name="mask_speed_end"]').val(0); }
			
			if(obj_v['easing'] !== undefined) { jQuery('#layer_endeasing option[value="'+obj_v['easing']+'"]').attr('selected', 'selected'); }
			if(obj_v['speed'] !== undefined) { jQuery('#layer_endspeed').val(obj_v['speed']); }
			if(obj_v['split'] !== undefined) { jQuery('#layer_endsplit option[value="'+obj_v['split']+'"]').attr('selected', 'selected'); }
			if(obj_v['splitdelay'] !== undefined) { jQuery('#layer_endsplitdelay').val(obj_v['splitdelay']); }
			
			if(obj_v['movex_reverse'] !== undefined && (obj_v['movex_reverse'] == 'true' || obj_v['movex_reverse'] == true)) { jQuery('#layer_anim_xend_reverse').attr('checked', true); }else{ jQuery('#layer_anim_xend_reverse').attr('checked', false); }
			if(obj_v['movey_reverse'] !== undefined && (obj_v['movey_reverse'] == 'true' || obj_v['movey_reverse'] == true)) { jQuery('#layer_anim_yend_reverse').attr('checked', true); }else{ jQuery('#layer_anim_yend_reverse').attr('checked', false); }
			if(obj_v['rotationx_reverse'] !== undefined && (obj_v['rotationx_reverse'] == 'true' || obj_v['rotationx_reverse'] == true)) { jQuery('#layer_anim_xrotate_end_reverse').attr('checked', true); }else{ jQuery('#layer_anim_xrotate_end_reverse').attr('checked', false); }
			if(obj_v['rotationy_reverse'] !== undefined && (obj_v['rotationy_reverse'] == 'true' || obj_v['rotationy_reverse'] == true)) { jQuery('#layer_anim_yrotate_end_reverse').attr('checked', true); }else{ jQuery('#layer_anim_yrotate_end_reverse').attr('checked', false); }
			if(obj_v['rotationz_reverse'] !== undefined && (obj_v['rotationz_reverse'] == 'true' || obj_v['rotationz_reverse'] == true)) { jQuery('#layer_anim_zrotate_end_reverse').attr('checked', true); }else{ jQuery('#layer_anim_zrotate_end_reverse').attr('checked', false); }
			if(obj_v['scalex_reverse'] !== undefined && (obj_v['scalex_reverse'] == 'true' || obj_v['scalex_reverse'] == true)) { jQuery('#layer_scale_xend_reverse').attr('checked', true); }else{ jQuery('#layer_scale_xend_reverse').attr('checked', false); }
			if(obj_v['scaley_reverse'] !== undefined && (obj_v['scaley_reverse'] == 'true' || obj_v['scaley_reverse'] == true)) { jQuery('#layer_scale_yend_reverse').attr('checked', true); }else{ jQuery('#layer_scale_yend_reverse').attr('checked', false); }
			if(obj_v['skewx_reverse'] !== undefined && (obj_v['skewx_reverse'] == 'true' || obj_v['skewx_reverse'] == true)) { jQuery('#layer_skew_xend_reverse').attr('checked', true); }else{ jQuery('#layer_skew_xend_reverse').attr('checked', false); }
			if(obj_v['skewy_reverse'] !== undefined && (obj_v['skewy_reverse'] == 'true' || obj_v['skewy_reverse'] == true)) { jQuery('#layer_skew_yend_reverse').attr('checked', true); }else{ jQuery('#layer_skew_yend_reverse').attr('checked', false); }
			if(obj_v['mask_x_reverse'] !== undefined && (obj_v['mask_x_reverse'] == 'true' || obj_v['mask_x_reverse'] == true)) { jQuery('#mask_anim_xend_reverse').attr('checked', true); }else{ jQuery('#mask_anim_xend_reverse').attr('checked', false); }
			if(obj_v['mask_y_reverse'] !== undefined && (obj_v['mask_y_reverse'] == 'true' || obj_v['mask_y_reverse'] == true)) { jQuery('#mask_anim_yend_reverse').attr('checked', true); }else{ jQuery('#mask_anim_yend_reverse').attr('checked', false); }
			
		}
	
		if(typeof(obj_v['mask']) !== 'undefined' && (obj_v['mask'] == 'true' || obj_v['mask'] == true)){
			jQuery('.mask-start-settings').show();
		}else{
			jQuery('.mask-start-settings').hide();
		}
		
		RevSliderSettings.onoffStatus(jQuery('#masking-start'));
		RevSliderSettings.onoffStatus(jQuery('#masking-end'));
		
		t.updateReverseList();
		
	}


	var checkMaskingAvailabity = function() {	
	 	
		if (jQuery('#layer__scalex').val()!=1 || jQuery('#layer__scaley').val()!=1 ||
			parseInt(jQuery('#layer__skewx').val(),0)!=0 || parseInt(jQuery('#layer__skewy').val(),0)!=0 ||
			parseInt(jQuery('#layer__xrotate').val(),0)!=0 || parseInt(jQuery('#layer__yrotate').val(),0)!=0 || parseInt(jQuery('#layer_2d_rotation').val(),0)!=0) {
				jQuery('.mask-not-available').show();
				jQuery('.mask-is-available').hide(); 
				jQuery('#masking-start').prop("checked",false);
				jQuery('#masking-end').prop("checked",false);
				jQuery('.mask-start-settings').hide();
				jQuery('.mask-end-settings').hide();
				jQuery('.tp-showmask').removeClass('tp-showmask');
				RevSliderSettings.onoffStatus(jQuery('#masking-start'));
				RevSliderSettings.onoffStatus(jQuery('#masking-end'));	
				u.rebuildLayerIdle(getjQueryLayer());
				
				t.updateLayerFromFields();
				
		} else {
			
			jQuery('.mask-not-available').hide();
			jQuery('.mask-is-available').show();
		}
		
		
	}

	/**
	 * check if anim handle already exists
	 */
	var checkIfAnimExists = function(handle){
		
		if(typeof initLayerAnims === 'object' && !jQuery.isEmptyObject(initLayerAnims)){
			for(var key in initLayerAnims){
				if(initLayerAnims[key]['handle'] == handle) return initLayerAnims[key]['id'];
			}
		}

		return false;

	}

	
	var checkIfAnimIsEditable = function(handle){
		
		if(typeof initLayerAnims === 'object' && !jQuery.isEmptyObject(initLayerAnims)){
			for(var key in initLayerAnims){
				if(initLayerAnims[key]['handle'] == handle) return initLayerAnims[key]['id'];
			}
		}

		return false;

	}
	
	
	/**
	 * update animation in database
	 */
	var deleteAnimInDb = function(handle){
		
		UniteAdminRev.setErrorMessageID("dialog_error_message");
		handle = jQuery.trim(handle);
		if(handle != ''){
			var animSelect = (currentAnimationType == 'customin') ? jQuery('#layer_animation option') : jQuery('#layer_endanimation option');

			UniteAdminRev.ajaxRequest("delete_custom_anim",handle,function(response){

				if(jQuery('#layer_animation option:selected') == handle || jQuery('#layer_animation option:selected') == handle.replace('customout', 'customin')){
					jQuery('#layer_animation option[value="tp-fade"]').attr('selected', true);
				}
				if(jQuery('#layer_endanimation option:selected') == handle || jQuery('#layer_endanimation option:selected') == handle.replace('customin', 'customout')){
					jQuery('#layer_endanimation option[value="tp-fade"]').attr('selected', true);
				}

				//update html select (got from response)
				t.updateInitLayerAnim(response.customfull);
				updateLayerAnimsInput(response.customin, 'customin');
				updateLayerAnimsInput(response.customout, 'customout');

			});
		}
	}


	/**
	 * rename animation in database
	 */
	var renameAnimInDb = function(id, new_name){
		
		var data = {};
		data['id'] = id;
		data['handle'] = new_name;

		UniteAdminRev.ajaxRequest("update_custom_anim_name",data,function(response){
			//update html select (got from response)
			t.updateInitLayerAnim(response.customfull);
			updateLayerAnimsInput(response.customin, 'customin');
			updateLayerAnimsInput(response.customout, 'customout');

			selectLayerAnim(new_name);
		});
	}


	/**
	 * update animation in database
	 */
	var updateAnimInDb = function(handle, animObj, id){
		
		UniteAdminRev.setErrorMessageID("dialog_error_message");
		animObj['handle'] = handle;

		if(id === false){ //create new
			//insert in database
			UniteAdminRev.ajaxRequest("insert_custom_anim",animObj,function(response){
				//update html select (got from response)
				t.updateInitLayerAnim(response.customfull);
				updateLayerAnimsInput(response.customin, 'customin');
				updateLayerAnimsInput(response.customout, 'customout');

				selectLayerAnim(handle);
			});

		}else{ //update existing

			//update to database
			UniteAdminRev.ajaxRequest("update_custom_anim",animObj,function(response){

				//update html select (got from response)
				t.updateInitLayerAnim(response.customfull);
				updateLayerAnimsInput(response.customin, 'customin');
				updateLayerAnimsInput(response.customout, 'customout');
                
				selectLayerAnim(handle);
				
				var raw_handle = handle.replace('customin-', '').replace('customout-', '');
				
				for(var key in t.arrLayers){

					if(t.arrLayers[key].frames.frame_999.animation == 'customout-'+raw_handle){
						t.arrLayers[key].x_end = animObj['params']['movex'];
						t.arrLayers[key].y_end = animObj['params']['movey'];
						t.arrLayers[key].z_end = animObj['params']['movez'];
						t.arrLayers[key].x_rotate_end = animObj['params']['rotationx'];
						t.arrLayers[key].y_rotate_end = animObj['params']['rotationy'];
						t.arrLayers[key].z_rotate_end = animObj['params']['rotationz'];
						t.arrLayers[key].scale_x_end = animObj['params']['scalex'];
						t.arrLayers[key].scale_y_end = animObj['params']['scaley'];
						t.arrLayers[key].opacity_end = animObj['params']['captionopacity'];
						t.arrLayers[key].skew_x_end = animObj['params']['skewx'];
						t.arrLayers[key].skew_y_end = animObj['params']['skewy'];
						t.arrLayers[key].mask_end = animObj['params']['mask'];
						t.arrLayers[key].mask_x_end = animObj['params']['mask_x'];
						t.arrLayers[key].mask_y_end = animObj['params']['mask_y'];
						t.arrLayers[key].mask_ease_end = animObj['params']['mask_ease'];
						t.arrLayers[key].mask_speed_end = animObj['params']['mask_speed'];
							
						t.arrLayers[key].x_end_reverse = animObj['params']['movex_reverse'];
						t.arrLayers[key].y_end_reverse = animObj['params']['movey_reverse'];
						
						t.arrLayers[key].x_rotate_end_reverse = animObj['params']['rotationx_reverse'];
						t.arrLayers[key].y_rotate_end_reverse = animObj['params']['rotationy_reverse'];
						t.arrLayers[key].z_rotate_end_reverse = animObj['params']['rotationz_reverse'];
						t.arrLayers[key].scale_x_end_reverse = animObj['params']['scalex_reverse'];
						t.arrLayers[key].scale_y_end_reverse = animObj['params']['scaley_reverse'];
						t.arrLayers[key].skew_x_end_reverse = animObj['params']['skewx_reverse'];
						t.arrLayers[key].skew_y_end_reverse = animObj['params']['skewy_reverse'];
						t.arrLayers[key].mask_x_end_reverse = animObj['params']['mask_x_reverse'];
						t.arrLayers[key].mask_y_end_reverse = animObj['params']['mask_y_reverse'];

						t.arrLayers[key].frames.frame_999.easing = animObj['params']['easing'];
						t.arrLayers[key].frames.frame_999.split = animObj['params']['split'];
						t.arrLayers[key].frames.frame_999.splitdelay = animObj['params']['splitdelay'];
						t.arrLayers[key].frames.frame_999.speed = animObj['params']['speed'];
					}else if(t.arrLayers[key].frames.frame_0.animation == 'customin-'+raw_handle){
						t.arrLayers[key].x_start = animObj['params']['movex'];
						t.arrLayers[key].y_start = animObj['params']['movey'];
						t.arrLayers[key].z_start = animObj['params']['movez'];
						t.arrLayers[key].x_rotate_start = animObj['params']['rotationx'];
						t.arrLayers[key].y_rotate_start = animObj['params']['rotationy'];
						t.arrLayers[key].z_rotate_start = animObj['params']['rotationz'];
						t.arrLayers[key].scale_x_start = animObj['params']['scalex'];
						t.arrLayers[key].scale_y_start = animObj['params']['scaley'];
						t.arrLayers[key].opacity_start = animObj['params']['captionopacity'];
						t.arrLayers[key].skew_x_start = animObj['params']['skewx'];
						t.arrLayers[key].skew_y_start = animObj['params']['skewy'];
						t.arrLayers[key].mask_start = animObj['params']['mask'];
						t.arrLayers[key].mask_x_start = animObj['params']['mask_x'];
						t.arrLayers[key].mask_y_start = animObj['params']['mask_y'];
						t.arrLayers[key].mask_ease_start = animObj['params']['mask_ease'];
						t.arrLayers[key].mask_speed_start = animObj['params']['mask_speed'];
						
						t.arrLayers[key].x_start_reverse = animObj['params']['movex_reverse'];
						t.arrLayers[key].y_start_reverse = animObj['params']['movey_reverse'];
						
						t.arrLayers[key].x_rotate_start_reverse = animObj['params']['rotationx_reverse'];
						t.arrLayers[key].y_rotate_start_reverse =  animObj['params']['rotationy_reverse'];
						t.arrLayers[key].z_rotate_start_reverse = animObj['params']['rotationz_reverse'];
						t.arrLayers[key].scale_x_start_reverse = animObj['params']['scalex_reverse'];
						t.arrLayers[key].scale_y_start_reverse = animObj['params']['scaley_reverse'];
						t.arrLayers[key].skew_x_start_reverse = animObj['params']['skewx_reverse'];
						t.arrLayers[key].skew_y_start_reverse = animObj['params']['skewy_reverse'];
						t.arrLayers[key].mask_x_start_reverse = animObj['params']['mask_x_reverse'];
						t.arrLayers[key].mask_y_start_reverse = animObj['params']['mask_y_reverse'];

						t.arrLayers[key].frames.frame_0.easing = animObj['params']['easing'];
						t.arrLayers[key].frames.frame_0.split = animObj['params']['split'];
						t.arrLayers[key].frames.frame_0.splitdelay = animObj['params']['splitdelay'];
						t.arrLayers[key].frames.frame_0.speed = animObj['params']['speed'];
					}
					
				}
			});
		}
	}

	/**
	 * update the layer animation inputs
	 */
	var selectLayerAnim = function(handle){
		
		var animSelectOption = (currentAnimationType == 'customin') ? jQuery('#layer_animation option') : jQuery('#layer_endanimation option');
		animSelectOption.each(function(){
			if(jQuery(this).text() == handle || jQuery(this).val() == handle)
				jQuery(this).prop('selected', true);
			else
				jQuery(this).prop('selected', false);
		});
		var animSelect = (currentAnimationType == 'customin') ? jQuery('#layer_animation option:selected') : jQuery('#layer_endanimation option:selected');
		animSelect.change();		
	}

	/**
	 * update the layer animation inputs
	 */
	var updateLayerAnimsInput = function(customAnim, type){
		
		if(type == 'customin'){
			var animSelect = jQuery('#layer_animation');
			var animOption = jQuery('#layer_animation option');
			var current = jQuery('#layer_animation option:selected').val();
		}else{
			var animSelect = jQuery('#layer_endanimation');
			var animOption = jQuery('#layer_endanimation option');
			var current = jQuery('#layer_endanimation option:selected').val();
		}

		animOption.each(function(){
			if(jQuery(this).val().indexOf(type) > -1){
				jQuery(this).remove();
			}
		});

		if(typeof customAnim === 'object' && !jQuery.isEmptyObject(customAnim)){
			for(key in customAnim){
				animSelect.append(new Option(customAnim[key], key));
			}
		}
		animSelect.val(current);
		animSelect.change();
	}

	



	/**
	 * get the first style from the styles list (from autocomplete)
	 */
	var getFirstStyle = function(){
		
		var arrClasses = jQuery( "#layer_caption" ).catcomplete("option","source");
		var firstStyle = "";

		if(arrClasses == null || arrClasses.length == 0)
			return("");
		
		var firstStyle = arrClasses[0]['label'];
		return(firstStyle);
	}


	/**
	 * clear layer html fields, and disable buttons
	 */
	var disableFormFields = function(){
		

		//clear html form
		jQuery(".form_layers")[0].reset();
		jQuery(".form_layers input, .form_layers select, .form_layers textarea").attr("disabled", "disabled").addClass("setting-disabled");

		jQuery("#button_delete_layer").addClass("button-now-disabled");
		jQuery("#button_duplicate_layer").addClass("button-now-disabled");

		jQuery(".form_layers label, .form_layers .setting_text, .form_layers .setting_unit").addClass("text-disabled");

		jQuery("#layer_captions_down").removeClass("ui-state-active").addClass("ui-state-default");
		jQuery("#css_fonts_down").removeClass("ui-state-active").addClass("ui-state-default");

		
		jQuery("#linkInsertTemplate").addClass("disabled");


		jQuery("#rs-align-wrapper").addClass("table_disabled");
		jQuery("#rs-align-wrapper-ver").addClass("table_disabled");

		if(!jQuery('#preview_looper').hasClass("deactivated")) jQuery('#preview_looper').click();

		layerGeneralParamsStatus = false;
	}

	/**
	 * enable buttons and form fields.
	 */
	var enableFormFields = function(){
		
		jQuery(".form_layers input, .form_layers select, .form_layers textarea").not(".rs_disabled_field").prop("disabled",false).removeClass("setting-disabled");

		jQuery("#button_delete_layer").removeClass("button-now-disabled");
		jQuery("#button_duplicate_layer").removeClass("button-now-disabled");

		jQuery(".form_layers label, .form_layers .setting_text, .form_layers .setting_unit").removeClass("text-disabled");

		jQuery("#layer_captions_down").removeClass("ui-state-default").addClass("ui-state-active");
		jQuery("#css_fonts_down").removeClass("ui-state-default").addClass("ui-state-active");

		
		jQuery("#linkInsertTemplate").removeClass("disabled");

		jQuery("#rs-align-wrapper").removeClass("table_disabled");
		jQuery("#rs-align-wrapper-ver").removeClass("table_disabled");

		if(jQuery('#preview_looper').hasClass("deactivated")) jQuery('#preview_looper').click();

		layerGeneralParamsStatus = true;
	}




	/**
	 * get layers array
	 */
	t.getLayers = function(){
		
		if(t.selectedLayerSerial != -1){
			t.updateLayerFromFields();
		}
		//update sizes in images
		updateLayersImageSizes();
		return(t.arrLayers);
	}
	
	
	/**
	 * get only layers array
	 */
	t.getSimpleLayers = function(){
		return(t.arrLayers);
	}


	/**
	 * update image sizes
	 */
	var updateLayersImageSizes = function(){
		
		for (serial in t.arrLayers){
			var layer = t.arrLayers[serial];
			if(layer.type == "image"){
				var htmlLayer = layer.references.htmlLayer;
				var objUpdate = {};
				objUpdate = t.setVal(objUpdate, 'width', htmlLayer.width());
				objUpdate = t.setVal(objUpdate, 'height', htmlLayer.height());
				t.updateLayer(serial,objUpdate);
			}
		}
		
	}

	t.clickInsideElement = function( e, className ) {
		var el = e.srcElement || e.target;			
		if ( el.classList.contains(className) ) {
			return el;
		} else {
			while ( el = el.parentNode ) {
				if ( el.classList && el.classList.contains(className) ) {
				  return el;
				}
			}
		}

		return false;
	}	


	var unselectAllFocusedGroup = function() {
		jQuery('.slide_layer_type_group.inwork').removeClass("inwork");
		jQuery('#focusongroup').removeClass("inwork");
	}
	/*! LAYER EVENTS */

	/**
	 * refresh layer events
	 */
	var refreshEvents = function(serial){
		var layer = t.getHtmlLayerFromSerial(serial),
			grid_size = jQuery('#rs-grid-sizes option:selected').val();

		//update layer events.
		var connect_to_sortable = layer[0].classList.contains("slide_layer_type_row") ? "#row-zone-top, #row-zone-middle, #row-zone-bottom" :  layer[0].classList.contains("slide_layer_type_column") || layer[0].classList.contains("slide_layer_type_group") ? "" : ".slide_layer_type_column .tp_layer_group_inner_wrapper",
			handle_item = layer[0].classList.contains("slide_layer_type_row") ? ".row_moveme" : false;
		
		layer.draggable({
			handle:handle_item,
			start:onLayerDragStart,
			refreshPositions:true,	
			drag: t.onLayerDrag,				//set ondrag event
			connectToSortable: connect_to_sortable,
			cancel:" textbox, #layer_text, .layer_on_lock",
			grid: [grid_size,grid_size],
			stop: onLayerDragEnd
		});

		jQuery('#focusongroup').click(unselectAllFocusedGroup);

		jQuery('body').on('dblclick','.inlaydecor',function(event) {
			jQuery(this).closest('.slide_layer_type_group').addClass("inwork");
			jQuery('#focusongroup').addClass("inwork");
		});

		layer.click(function(event){		
			
			var context = t.clickInsideElement( event, 'groupinfo');
			if (context!==false) {		
				jQuery(context).closest('.slide_layer_type_group').addClass("inwork");
				jQuery('#focusongroup').addClass("inwork");
				return false;
			}

			if(event.metaKey || (navigator.platform.toUpperCase().indexOf('WIN')!==-1 && event.ctrlKey)) {
    			var objLayer = t.getLayer(serial),
    				inp = jQuery('input#lots_id_'+objLayer.unique_id);
    			
    			if (inp.attr('checked')=="checked")
    				inp.prop("checked",false);
    			else
    				inp.attr('checked','checked');
    			u.checkMultipleSelectedItems();
  			} else {
				cm.toggleMenuOff();
				if (jQuery(':focus').attr('id')==="rs-row-layout") return false;			
				jQuery(':focus').blur();			
				t.setLayerSelected(serial);		
				var objLayer = t.getLayer(serial),
					inp = jQuery('input#lots_id_'+objLayer.unique_id);
				
				if (jQuery.inArray(objLayer.unique_id,t.selectedLayers)==-1) u.checkMultipleSelectedItems(true);
				inp.attr('checked','checked');
				t.setLayerSelected(serial);    				

				if (layer.hasClass("slide_layer_type_row")) {
					var objLayer = t.getCurrentLayer();
						
					
					if ((event.srcElement!==undefined && (event.srcElement.className==='eg-icon-menu' || event.srcElement.className==='row_editor')) || (event.target!=undefined && (event.target.className==='eg-icon-menu' || event.target.className==='row_editor'))) {						
						var btn = layer.find('.row_editor'),
							row_composer = jQuery('#rs-layout-row-composer');
						jQuery('.row_editor.open_re').removeClass("open_re");
						btn.addClass("open_re");
						row_composer.show();
						jQuery('.rs-row-break-selector').removeClass("selected");
						jQuery('.rs-row-break-selector.rs-slide-ds-'+jQuery('#column_break_at option:selected').val()).addClass("selected")	
						//row_composer.appendTo(btn.closest('.row_toolbar'));						
					} else 
					if ((event.srcElement!=undefined && (event.srcElement.className==='eg-icon-cancel' || event.srcElement.className==='row_editor')) || (event.target!=undefined && (event.target.className==='eg-icon-cancel' || event.target.className==='row_editor'))) {
						var btn = layer.find('.row_editor'),
							row_composer = jQuery('#rs-layout-row-composer');
						jQuery('.row_editor.open_re').removeClass("open_re");
						row_composer.hide();
						//row_composer.appendTo(jQuery('#divLayers'));
					} else 					
					if ((event.srcElement!=undefined && (event.srcElement.className==='eg-icon-droplet' || event.srcElement.className==='row_config')) || (event.target!=undefined && (event.target.className==='eg-icon-droplet' || event.target.className==='row_config'))) {
						var morestyle = jQuery('#style-morestyle');
						if (!morestyle.hasClass("showmore")) morestyle.click();
					}
				}
				
				event.stopPropagation();
				// IF ANIMATION TAB IS VISIBLE, AND PLAY IS SELECTED, WE CAN ALLOW TO ANIMATE THE SINGLE LAYER
				if (u.checkAnimationTab()) {
						u.stopAllLayerAnimation();
						u.animateCurrentSelectedLayer(0);
				}
				else
				if (u.checkLoopTab()) {
					u.stopAllLayerAnimation();
					u.callCaptionLoops();
				}
			}						
		});
	}


	/**
	 * get layer serial from id
	 */
	t.getSerialFromID = function(layerID){
		
		if (layerID == undefined) return false;
		var layerSerial = layerID.replace("slide_layer_","").replace("demo_layer_","");
		return(layerSerial);
	}

	/**
	 * get serial from sortID
	 */
	t.getSerialFromSortID = function(sortID){
		

		var layerSerial = sortID.replace("layer_sort_time_","");
		
		layerSerial = layerSerial.replace("layer_sort_","");
		layerSerial = layerSerial.replace("layer_quicksort_","");
		return(layerSerial);
	}


	/**
	 * hide in html and sortbox
	 */
	t.lockAllLayers = function(serial){

		for (serial in t.arrLayers) 			
			u.lockLayer(serial);		
	}


	/**
	 * show layer in html and sortbox
	 */
	t.unlockAllLayers = function(serial){

		for (serial in t.arrLayers)
			u.unlockLayer(serial);
	}

	/**
	 * show all layers
	 */
	t.showAllLayers = function(except_serial){
		for (var i in t.arrLayers) {
			if (except_serial!==t.arrLayers[i].serial)
				u.showLayer(t.arrLayers[i],true);
		}		
	}

	/**
	 * hide all layers
	 */
	t.hideAllLayers = function(except_serial){		
		for (var i in t.arrLayers) {	
			if (except_serial!==t.arrLayers[i].serial)		
				u.hideLayer(t.arrLayers[i],true);
		}		
	}


	/**
	 * get html layer from serial
	 */
	t.getHtmlLayerFromSerial = function(serial, isDemo){
		
		if(!isDemo)
			isDemo = false;

		if(!isDemo)
			var htmlLayer = jQuery("#slide_layer_"+serial);
		else
			var htmlLayer = jQuery("#demo_layer_"+serial);

		if(htmlLayer!==null && htmlLayer.length == 0)
			UniteAdminRev.showErrorMessage("Html Layer with serial: "+serial+" not found!");

		return(htmlLayer);
	}

	
	/**
	 * get layer object by the new Unique Id
	 */
	t.getLayerByUniqueId = function(uid){
		for(var key in t.arrLayers){
			if(t.arrLayers[key]['unique_id'] == uid) return t.getLayer(key);
		}

		for(var key in t.arrLayersDemo){
			if(t.arrLayersDemo[key]['unique_id'] == uid) return t.getLayer(key);
		}
		
		return false;
	}
	
	/**
	 * get layer object by the new Unique Id
	 */
	t.getLayerIdByUniqueId = function(uid){
		for(var key in t.arrLayers){
			if(t.arrLayers[key]['unique_id'] == uid) return key;
		}
		for(var key in t.arrLayersDemo){
			if(t.arrLayersDemo[key]['unique_id'] == uid) return key;
		}
		
		return false;
	}
	
	
	/**
	 * get unique ID by layer
	 */
	t.getUniqueIdByLayer = function(serial){
		for(var key in t.arrLayers){
			if(key == serial) return t.arrLayers[key]['unique_id'];
		}
		
		return false;
	}
	
	
	
	/**
	 * get layer object by id
	 */
	t.getLayer = function(serial, isDemo){
		
		if(isDemo){
			var layer = t.arrLayersDemo[serial];
		}else{
			var layer = t.arrLayers[serial];
		}
		if(!layer){ //check if still maybe demo layer
			var layer = t.arrLayersDemo[serial];
		}
		
		if(!layer){
			return false;
			//UniteAdminRev.showErrorMessage("getLayer error, Layer with serial: "+serial+" not found");
		}else{
			//modify some data
			layer.frames.frame_0.speed = Number(layer.frames.frame_0.speed);
			layer.frames.frame_999.speed = Number(layer.frames.frame_999.speed);
			return layer;
		}
		return false;
	}

	/**
	 * get current layer object
	 */
	t.getCurrentLayer = function(){
		if(t.selectedLayerSerial == -1){
			return false;
			//UniteAdminRev.showErrorMessage(rev_lang.sel_layer_not_set);
			//return(null);
		}
		return t.getLayer(t.selectedLayerSerial);
	}



	/*! MAKE HTML LAYER */

	/**
	 * make layer html, with params from the object
	 */
	t.makeLayerHtml = function(serial,objLayer,isDemo){
		
		if(!isDemo)
			isDemo = false;

		var type = "text";
		if(objLayer.type)
			type = objLayer.type;


		var zIndex = Number(objLayer.order)+100,
			style = "z-index:"+zIndex+";position:absolute;",
			stylerot ="",
			contaddon = "",
			precont = "",
			subcont = "";
		
		
		if(t.getVal(objLayer, 'max_width') !== 'auto')
			style += ' width: '+t.getVal(objLayer, 'max_width')+';';

		
		if(t.getVal(objLayer, 'max_height') !== 'auto') 
			style += ' height: '+t.getVal(objLayer, 'max_height')+';';

		//if(objLayer.whitespace !== 'normal')
			style += ' white-space: '+t.getVal(objLayer, 'whitespace')+';';

		var static_class = '';
		
		if(typeof objLayer.special_type !== 'undefined' && objLayer.special_type == 'static') static_class = ' static_layer';
		
		var internal_class = '';
		if(typeof objLayer.type !== 'undefined' && (objLayer.type == 'button' || objLayer.type == 'shape')) internal_class = ' '+objLayer.internal_class; // || objLayer.type == 'no_edit' 
		
		var linkgroup = objLayer.groupLink;
		linkgroup = linkgroup === undefined ? 0 : linkgroup;
		linkgroup = 'ldles_'+linkgroup;
		if(type == "image") style += "line-height:0;";
		if (type=="column") {
			precont = '<div class="slide_layer_col_sizer">';
			subcont = '</div>';
			
			contaddon = '<div class="column_background"></div>';
		}
						
		if(!isDemo){
			var html = '<div id="slide_layer_' + serial + '" data-uniqueid="'+objLayer.unique_id+'" data-serial="'+serial+'" data-type="'+type+'" style="' + style + '"               class="slide_layer_type_'+type+' slide_layer '+linkgroup+'">'+contaddon+precont+'<div style="'+stylerot+'" class="innerslide_layer tp-caption '+objLayer.style+static_class+internal_class+'" >';
		}else{
			if(rev_adv_resp_sizes === true){

			}
			if(objLayer['static_styles'] != undefined){
				style += ' font-size: '+t.getVal(objLayer['static_styles'],'font-size')+';';
				style += ' line-height: '+t.getVal(objLayer['static_styles'],'line-height')+';';
				style += ' font-weight: '+t.getVal(objLayer['static_styles'],'font-weight')+';';
				style += ' color: '+t.getVal(objLayer['static_styles'],'color')+';';
			}
			var html = '<div id="demo_layer_' + serial + '" data-uniqueid="'+objLayer.unique_id+'" data-serial="'+serial+'"  data-type="'+type+'" style="' + style + '" class="invisible_demolayer demo_layer_type_'+type+' demo_layer demo_layer_'+curDemoSlideID+' slide_layer" >'+contaddon+precont+'<div style="'+stylerot+'" class="innerslide_layer tp-caption '+objLayer.style+static_class+internal_class+'" >';
		}

		//add layer specific html
		switch(type){
			case "image":
				var addStyle = '';
				
				//if(t.getVal(objLayer,'scaleX') != "") addStyle += "width: " + t.getVal(objLayer,'scaleX') + "px; ";
				//if(t.getVal(objLayer,'scaleY') != "") addStyle += "height: " + t.getVal(objLayer,'scaleY') + "px;";
				
				html += '<img src="'+objLayer.image_url+'" alt="'+objLayer.alt+'" style="'+addStyle+'"></img>';
			break;
			default:
			case "text":
			case "button":
			//case 'no_edit':
				html += objLayer.text;
				
			break;
			case "group":
				html += '<div class="inlaydecor"></div><div class="groupinfo"><i class="fa-icon-object-group"></i><span class="group_info_text">Edit Group Layers</span></div><div class="tp_layer_group_inner_wrapper"></div>';
			break;
			case "column":
				html += '<div class="tp_layer_group_inner_wrapper"></div>';
			break;
			case "row":
				html += '<div class="tp_layer_group_inner_wrapper"></div>';
				if (!isDemo) html +='<div class="row_toolbar"><div class="row_editor"><i class="eg-icon-menu"></i><i class="eg-icon-cancel"></i></div><div class="row_moveme"><i class="eg-icon-arrow-combo"></i></div><div class="row_config"><i class="eg-icon-droplet"></i></div></div>';
			break;
			case "video":				
				//var styleVideo = "width:"+parseInt(t.getVal(objLayer, 'video_width'),0)+"px;height:"+parseInt(t.getVal(objLayer, 'video_height'),0)+"px;";
				var styleVideo = "width:100%;height:100%";
				if(typeof (objLayer.video_data) !== "undefined"){
					var useImage = (jQuery.trim(objLayer.video_data.previewimage) != '') ? objLayer.video_data.previewimage : objLayer.video_image_url;
				}else{
					var useImage = objLayer.video_image_url;
				}
				
				var videoIcon = objLayer.video_type;
				
				switch(objLayer.video_type){
					case "youtube":
					case "vimeo":
						styleVideo += ";background-image:url("+useImage+");";
					break;
					case "html5":
						if(useImage !== undefined && useImage != "")
							styleVideo += ";background-image:url("+useImage+");";
					break;
					case 'streamyoutube':
						videoIcon = 'youtube';
					break;
					case 'streamvimeo':
						videoIcon = 'vimeo';
					break;
					case 'streaminstagram':
						videoIcon = 'html5';
					break;
				}
				
				html += "<div class='slide_layer_video' style='"+styleVideo+"'><div class='video-layer-inner video-icon-"+videoIcon+"'>";
				html += "<div class='layer-video-title'>" + objLayer.video_title + "</div>";
				html += "</div></div>";
			break;
			case 'audio':
				var styleAudio = '';
				var audioIcon = '';				
				html += "<div class='slide_layer_audio' style='"+styleAudio+"'><div class='video-layer-inner video-icon-"+audioIcon+"'>";
				html += '<div class="slide_layer_audio_c_wrapper">';
				html += '<audio controls src="'+objLayer.video_data.urlAudio+'"></audio>';
				html += '<div class="tp-video-controls">'+
						'<div class="tp-video-button-wrap"><button type="button" class="tp-video-button tp-vid-play-pause">Play</button></div>'+
						'<div class="tp-video-seek-bar-wrap"><input  type="range" class="tp-seek-bar" value="0"></div>'+
						'<div class="tp-video-button-wrap"><button  type="button" class="tp-video-button tp-vid-mute">Mute</button></div>'+
						'<div class="tp-video-vol-bar-wrap"><input  type="range" class="tp-volume-bar" min="0" max="1" step="0.1" value="1"></div>'+												
						'</div>';
				html += '<div class="slide_layer_audio_c_cover"></div>';
				html += '</div>';
				html += "<div class='layer-audio-title'><i class='rs-icon-layeraudio_n'></i>" + objLayer.audio_title + "</div>";
				html += "</div></div>";
			break;
			case 'svg':				
				if (objLayer.svg!=undefined && objLayer.svg.src!=undefined) 
				jQuery.get(objLayer.svg.src, function(data) {
					var pref = !isDemo ? "#slide_layer_" : "#demo_layer_"
				  jQuery(pref+serial+" .innerslide_layer.tp-caption").first().html("");
				  jQuery(pref+serial+" .innerslide_layer.tp-caption").first()[0].innerHTML = new XMLSerializer().serializeToString(data.documentElement);
				  u.rebuildLayerIdle(jQuery(pref+serial));
				});
				
			break;
		}
		
		html +="</div>"+subcont;
		
		//add cross icon:
		html += "<div class='icon_cross'></div>";
		html += '</div>';
		return(html);
	}


	/**
	 * Reset values that can be set without changing the class to default
	 */
	t.reset_to_default_static_styles = function(layer, exclude, devices){
		
		if(layer.style !== undefined){
			//get css styles from choosen class
			var foundstyles = UniteCssEditorRev.getStyleSettingsByHandle(layer.style);

			if(foundstyles !== false){

				if(foundstyles.params['font-size'] !== undefined){
					if(exclude !== undefined && devices !== undefined){
						if(jQuery.inArray('font-size', exclude) !== -1){
							//set for specific devices now
							layer['static_styles'] = t.setVal(layer['static_styles'], 'font-size', foundstyles.params['font-size'], false, devices);
							
							if(jQuery.inArray(layout, devices) !== -1){
								jQuery('#layer_font_size_s').val(foundstyles.params['font-size']);
							}
						}
					}else{
						jQuery('#layer_font_size_s').val(foundstyles.params['font-size']);
					}
				}
				
				if(foundstyles.params['line-height'] !== undefined){
					if(exclude !== undefined && devices !== undefined){
						if(jQuery.inArray('line-height', exclude) !== -1){
							//set for specific devices now
							layer['static_styles'] = t.setVal(layer['static_styles'], 'line-height', foundstyles.params['line-height'], false, devices);
							
							if(jQuery.inArray(layout, devices) !== -1){
								jQuery('#layer_line_height_s').val(foundstyles.params['line-height']);
							}
						}
					}else{
						jQuery('#layer_line_height_s').val(foundstyles.params['line-height']);
					}
				}
				
				if(foundstyles.params['font-weight'] !== undefined){
					if(exclude !== undefined && devices !== undefined){
						if(jQuery.inArray('font-weight', exclude) !== -1){
							//set for specific devices now
							layer['static_styles'] = t.setVal(layer['static_styles'], 'font-weight', foundstyles.params['font-weight'], false, devices);
							
							if(jQuery.inArray(layout, devices) !== -1){
								jQuery('#layer_font_weight_s option[value="'+foundstyles.params['font-weight']+'"]').attr('selected', true);
							}
						}
					}else{
						jQuery('#layer_font_weight_s option[value="'+foundstyles.params['font-weight']+'"]').attr('selected', true);
					}
				}
				
				if(foundstyles.params['color'] !== undefined){
					if(exclude !== undefined && devices !== undefined){
						if(jQuery.inArray('color', exclude) !== -1){
							//set for specific devices now
							layer['static_styles'] = t.setVal(layer['static_styles'], 'color', UniteAdminRev.rgb2hex(foundstyles.params['color']), false, devices);
						}
						if(jQuery.inArray(layout, devices) !== -1){
							jQuery('#layer_color_s').val(UniteAdminRev.rgb2hex(foundstyles.params['color']));
							//trigger color change on the colorpicker
							jQuery('.wp-color-result').each(function(){
								jQuery(this).css('backgroundColor', jQuery(this).parent().find('.my-color-field').val());
							});
						}
					}else{
						jQuery('#layer_color_s').val(UniteAdminRev.rgb2hex(foundstyles.params['color']));
						//trigger color change on the colorpicker
						jQuery('.wp-color-result').each(function(){
							jQuery(this).css('backgroundColor', jQuery(this).parent().find('.my-color-field').val());
						});
					}
				}
			}

		}
	}


	/**
	 * update layer by data object
	 */
	t.updateLayer = function(serial,objData,del_certain,ignoreCallUndo){
		
		
		var layer = t.getLayer(serial);
		if(!layer){
			return(false);
		}

		var do_reset_static = false;

		if(objData.style !== undefined && objData.style !== layer['style'] && jQuery('#dialog-change-style-from-css').css('display') == 'none'){ //check if dialog is open, if yes then do not change static
			//update values that can be set without changing the class
			do_reset_static = true;
		}
		
		
		if(del_certain !== undefined){
			for(var key in del_certain){
				delete layer[del_certain[key]];
			}
		}
		
		
		
		for(var key in objData){
			if(typeof(objData[key]) === 'object'){
				for(var okey in objData[key]){
					if(typeof(layer[key]) === 'object'){
						if(typeof(layer[key][okey]) === 'object'){
							for(var mk in objData[key][okey]){
								layer[key][okey][mk] = objData[key][okey][mk];
							}
						}else{
							layer[key][okey] = objData[key][okey];
						}
					}else{
						layer[key] = {};
						layer[key][okey] = objData[key][okey];
					}
				}
			}else{
				layer[key] = objData[key];
			}
		}
		
		if(do_reset_static){
			t.reset_to_default_static_styles(layer);
			// Reset Fields from Style Template
			updateSubStyleParameters(layer);
		}
		
		if(!t.arrLayers[serial]){
			UniteAdminRev.showErrorMessage("setLayer error, Layer with ID: "+serial+" not found");
			return(false);
		}
		
		if (!ignoreCallUndo)
			if(update_layer_changes){
				t.add_layer_change(serial, objData);
			}
		
		t.arrLayers[serial] = jQuery.extend({},layer);
		
		t.updateReverseList();
		
	}
	

	/********************************************************************************************************/
	/* 						-		UNDO / REDO FUNCTION 	-												*/
	/********************************************************************************************************/

	// UNDO - REDO FUNCTIONS DUE ALL LAYERS
	t.cloneArrLayers = function() {
		t.arrLayersClone = jQuery.extend(true,{},t.arrLayers);		
	}


	function checkKeyGroups(chain) {
		
		//Check if any History exists		
		var c_chain_group = t.arrLayersChanges["undo"] && t.arrLayersChanges["undo"].length>0 ? t.arrLayersChanges["undo"][t.arrLayersChanges["undo"].length-1].undogroup : "",
			c_serial = t.arrLayersChanges["undo"] && t.arrLayersChanges["undo"].length>0 ? t.arrLayersChanges["undo"][t.arrLayersChanges["undo"].length-1].serial : -77,
			serial = chain.split(".")[0],
			obj = {},
			ai = -1;

		chain = chain.substring(chain.indexOf(".")+1);		
		obj.addtoarray = false;
		obj.serial = serial;

		var laction = chain.indexOf('layer_action')>=0,
			searchfor = laction ? "layer_action" : chain;
		
		jQuery.each(t.attributegroups, function(i,gob) {			
			if (jQuery.inArray(searchfor,gob.keys)!=-1) {
				obj.undogroup = gob.groupname;			
				obj.icon = gob.icon;
				obj.id = gob.id;
			}
		});
		
		if (obj.serial == c_serial || (obj.id==30 && c_chain_group=="Order")) {
			if (obj.undogroup != c_chain_group)			
				obj.addtoarray = true;
			else
				obj.addtoarray="samegroup";
		} else {
			obj.addtoarray = true
		}					

		// FOR FURTHER DEBUGS
		if (obj.undogroup==undefined) {
			
			obj.addtoarray = false;
		}

		return obj;
	}


	// REKURSIVE COMPARING OBJECTS
	function objRek (a, b, chain,found) {	
		chain = chain===undefined ? "" : chain;		
		jQuery.each(a, function(key,val) {
			if (found) return true;				
			if (key!=="references") 
				if (val instanceof(Object)) {				
					var originalchain = chain;
					chain = chain.length==0 ? key : chain+"."+key;		
					found = objRek(val,b[key],chain,found);				
					chain = originalchain;				
				} else {				
					var originalchain = chain;						
					chain = chain == undefined || chain.length==0 ? key : chain+"."+key;				
					// CHECK IF THE VALUES ARE DIFFERENT					
					if (((val!==b[key] && parseInt(val,0) != parseInt(b[key],0) && val!=undefined && b[key]!=undefined) && key!="renderedData"))	{	
						
						if ((t.arrLayersChanges["undo"] && t.arrLayersChanges["undo"].length==0) ||  t.arrLayersChanges["undo"][t.arrLayersChanges["undo"].length-1].chain != chain) {
							var obj = checkKeyGroups(chain);						
							if (obj.addtoarray===true) {
								t.arrLayersChanges["redo"].splice(0,t.arrLayersChanges["redo"].length);
								t.arrLayersChanges["undo"].push({amount:0, backup:jQuery.extend(true,{},t.arrLayersClone),restore:jQuery.extend(true,{},t.arrLayers),icon:obj.icon, id:obj.id, undogroup:obj.undogroup,serial:obj.serial, key:key, chain:chain, oldval:val, newval:b[key]});																		
								t.set_save_needed(true);
								found = true;
							} else {
								if (obj.addtoarray=="samegroup") {
									t.arrLayersChanges["redo"].splice(0,t.arrLayersChanges["redo"].length);
									t.arrLayersChanges["undo"][t.arrLayersChanges["undo"].length-1].amount++;
									t.set_save_needed(true);
									found = true;
								}
							}		
						} else {
							if (t.arrLayersChanges["undo"][t.arrLayersChanges["undo"].length-1].chain === chain) {
								t.arrLayersChanges["redo"].splice(0,t.arrLayersChanges["redo"].length);
								t.arrLayersChanges["undo"][t.arrLayersChanges["undo"].length-1].amount++;
								t.set_save_needed(true);
								found = true;
							}
						}	
					}																
					chain = originalchain;
				}
		})		
		return found;
	}

	// CHECK IF ANY CHANGES HAPPEND SINCE LAST ARRAY CLONE
	t.add_layer_change = function() {			
		if (t.ignorAllUndoRedoLogs) return;
		if (t.arrLayersChanges["undo"].length-1 > 27) 
			var removed = t.arrLayersChanges["undo"].splice(0,1);
		objRek(t.arrLayersClone,t.arrLayers,"");	
		if (t.arrLayersChanges["redo"].length==0 && t.arrLayersChanges["undo"].length>0)
			t.arrLayersChanges["undo"][t.arrLayersChanges["undo"].length-1].restore = jQuery.extend(true,{},t.arrLayers);
		
		t.cloneArrLayers();		
		
		t.update_undo_redo_list();			
		
	}
	
	t.oneStepUndo = function() {
		if (t.arrLayersChanges["undo"].length-1 >=0)
			t.undo_redo_layer("undo",t.arrLayersChanges["undo"].length-1);
	}

	t.oneStepRedo = function() {
		if (t.arrLayersChanges["redo"].length-1 >=0)
			t.undo_redo_layer("redo",0);
	}
	
	t.update_undo_redo_list = function(){

		if (jQuery('#rs-undo-list').length==0) {			
			jQuery('#layer-settings-toolbar-bottom').append('<div id="rs-undo-list"><div id="undo-redo-wrapper"></div></div>');			
			jQuery('body').on('click','.undostep',function() {
				t.undo_redo_layer("undo",jQuery(this).data('undoindex'));
			});		
			jQuery('body').on('click','.redostep',function() {
				t.undo_redo_layer("redo",jQuery(this).data('redoindex'));
			});			

			jQuery('body').on('click','#undo-last-action',function() {
				if (t.arrLayersChanges["undo"].length-1 >=0)
					t.undo_redo_layer("undo",t.arrLayersChanges["undo"].length-1);
			});

			jQuery('body').on('click','#showhide_undolist',function() {
				var c = jQuery('#rs-undo-list');
				
				if (!c.hasClass("inactive")) {
					c.slideDown(200).addClass("inactive");
					jQuery('#showhide_undolist i').addClass("eg-icon-down-open").removeClass('eg-icon-menu');
				}
				else {
					c.slideUp(200).removeClass("inactive");
					jQuery('#showhide_undolist i').removeClass("eg-icon-down-open").addClass('eg-icon-menu');
					setTimeout(function() {
						var udl = jQuery('#undo-redo-wrapper');
						udl.scrollTop(udl.prop("scrollHeight"));
						udl.perfectScrollbar("update");	
					},250);
				}								
			});	

			jQuery('#undo-redo-wrapper').perfectScrollbar({wheelPropagation:true, suppressScrollX:true});

		}

		var udl = jQuery('#undo-redo-wrapper');
		
		udl.find('.undoredostep').remove();
		
		
		jQuery.each(t.arrLayersChanges["undo"],function(i,obj) {
			var quicksb = '<div data-undoindex="'+i+'" class="undoredostep undostep">',
				name = t.arrLayers[obj.serial].alias,
				type = t.arrLayers[obj.serial].type;
			
			switch (type) {
				case "text":
					quicksb += '<span class="layer-title-with-icon"><i class="rs-icon-layerfont_n"></i></span>';					
				break;	
				case "shape":
					quicksb += '<span class="layer-title-with-icon"><i class="rs-icon-layershape_n"></i></span>';
					
				break;
				case "button":
					quicksb += '<span class="layer-title-with-icon"><i class="rs-icon-layerbutton_n"></i></span>';
					
				break;
				case "image":
					quicksb += '<span class="layer-title-with-icon"><i class="rs-icon-layerimage_n"></i></span>';
					
				break;
				case "video":
					quicksb += '<span class="layer-title-with-icon"><i class="rs-icon-layervideo_n"></i></span>';
					
				break;
				case "audio":
					quicksb += '<span class="layer-title-with-icon"><i class="rs-icon-layeraudio_n"></i></span>';					
				break;
				case "svg":
					quicksb += '<span class="layer-title-with-icon"><i class="rs-icon-layersvg_n"></i></span>';					
				break;
				case "row":
				case "group":
					quicksb += '<span class="layer-title-with-icon"><i class="fa-icon-object-group"></i></span>';					
				break;
				case "column":
					quicksb += '<span class="layer-title-with-icon"><i class="rs-icon-layercolumn_n"></i></span>';					
				break;
			}
			var suf = "";
			if (obj.amount >0) suf = ' ('+obj.amount+')';
			if (i==t.arrLayersChanges["undo"].length-1)
				jQuery('#quick-undo .single-undo-action').html('<span class="undo-name">'+name+'</span><span class="undo-action"><i class="eg-icon-'+obj.icon+'"></i>'+obj.undogroup+suf+'</span>');

			quicksb += '<span class="undo-name">'+name+'</span><span class="undo-action"><i class="eg-icon-'+obj.icon+'"></i>'+obj.undogroup+suf+'</span><i class="eg-icon-cw"></i>';
			quicksb += '</div>';
			udl.append(quicksb);			
		});

		if (t.arrLayersChanges["undo"].length-1<0) 
			jQuery('#quick-undo .single-undo-action').html('<span class="undo-name">'+jQuery(".single-undo-action").data("origtext")+'</span>');

		jQuery.each(t.arrLayersChanges["redo"],function(i,obj) {
			var quicksb = '<div data-redoindex="'+i+'" class="undoredostep redostep">',
				name = t.arrLayers[obj.serial] ===undefined ?  obj["backup"][obj.serial].alias : t.arrLayers[obj.serial].alias;
				type = t.arrLayers[obj.serial] ===undefined ?  obj["backup"][obj.serial].type : t.arrLayers[obj.serial].type;
				
			
			switch (type) {
				case "text":
					quicksb += '<span class="layer-title-with-icon"><i class="rs-icon-layerfont_n"></i></span>';					
				break;	
				case "shape":
					quicksb += '<span class="layer-title-with-icon"><i class="rs-icon-layershape_n"></i></span>';
					
				break;
				case "button":
					quicksb += '<span class="layer-title-with-icon"><i class="rs-icon-layerbutton_n"></i></span>';
					
				break;
				case "image":
					quicksb += '<span class="layer-title-with-icon"><i class="rs-icon-layerimage_n"></i></span>';
					
				break;
				case "video":
					quicksb += '<span class="layer-title-with-icon"><i class="rs-icon-layervideo_n"></i></span>';
					
				break;
				case "audio":
					quicksb += '<span class="layer-title-with-icon"><i class="rs-icon-layeraudio_n"></i></span>';					
				break;
				case "svg":
					quicksb += '<span class="layer-title-with-icon"><i class="rs-icon-layersvg_n"></i></span>';					
				break;
			}
			var suf = "";
			if (obj.amount >0) suf = ' ('+obj.amount+')';
			quicksb += '<span class="undo-name">'+name+'</span><span class="undo-action"><i class="eg-icon-'+obj.icon+'"></i>'+obj.undogroup+suf+'</span><i class="eg-icon-cw"></i>';
			quicksb += '</div>';
			udl.append(quicksb);			
		});
		
		
		if (udl.data('steps') != (t.arrLayersChanges["redo"].length+t.arrLayersChanges["undo"].length)) {
			udl.scrollTop(udl.prop("scrollHeight"));
			udl.data('steps',(t.arrLayersChanges["redo"].length+t.arrLayersChanges["undo"].length));
		}

		udl.perfectScrollbar("update");

		
	}
	
	function _len(a) {
		var r = 0;
		jQuery.each(a,function(i) { r++;});
		return r;
	}


	function forceShowHideLayer(objLayer,todo) {
		
		if (objLayer===undefined || objLayer === false) return;

		if (todo=="hide") {
			objLayer.references.htmlLayer.addClass("layer-deleted");
			if (objLayer.references.sorttable!=undefined) {
				objLayer.references.sorttable.layer.addClass("layer-deleted");
				objLayer.references.sorttable.timeline.addClass("layer-deleted");
				objLayer.references.quicklayer.addClass("layer-deleted");
			}
			
		} else {
			objLayer.references.htmlLayer.removeClass("layer-deleted");
			if (objLayer.references.sorttable!=undefined) {
				objLayer.references.sorttable.layer.removeClass("layer-deleted");
				objLayer.references.sorttable.timeline.removeClass("layer-deleted");
				objLayer.references.quicklayer.removeClass("layer-deleted");
			}		
		}

		u.timeLineTableDimensionUpdate();
	}

	function showHideDeletedLayers(force) {

		jQuery.each(t.arrLayers,function(i,objLayer) {						
			if (objLayer.layer_unavailable || objLayer.deleted===true) 	
				forceShowHideLayer(objLayer,"hide");
			else					
				forceShowHideLayer(objLayer,"show");
		});
	}

	function checkInvisibleRedoItems() {
		jQuery.each(t.arrLayersChanges["redo"],function(i,change){
			jQuery.each(change.backup,function(i,objLayer){
				if (objLayer.layer_unavailable) {					
					forceShowHideLayer(objLayer,"hide");
				}
			});					
		});				
	}



	function checkChangedSources(d) {
		function ccs_intern_check(change,direction) {			
			if (change.id==12 || change.id==9 || change.id==29) {				
				jQuery.each(change[d],function(i,objLayer){
					if ((change.id==12 && (objLayer.type=="svg" || objLayer.type=="image")) || 
						(change.id==29 && (objLayer.type=="audio" || objLayer.type=="video")) || 
						(change.id==9 && objLayer.type=="text")) 
						redrawLayerHtml(objLayer.serial);
					if (change.id==29 && (objLayer.type=="audio")) {						
						u.drawAudioMap(objLayer);
					}
				});					
			}
		}
		jQuery.each(t.arrLayersChanges["redo"],function(i,change){
			ccs_intern_check(change,d);
		});
		jQuery.each(t.arrLayersChanges["undo"],function(i,change){
			ccs_intern_check(change,d);
		});				
	}

	
	
	
	t.undo_redo_layer = function(type, step){
		t.set_save_needed(true);
		jQuery('.layer-on-timeline-selector').each(function() {
			this.checked = false;
		});
		t.selectedLayers=[];
		if (type=="undo") {				
			t.arrLayers = jQuery.extend(true,{},t.arrLayersChanges["undo"][step].backup);	
			showHideDeletedLayers();
			var j = t.arrLayersChanges["undo"].length-step;
			for (var i=0;i<j;i++) {
				t.arrLayersChanges["redo"].unshift(t.arrLayersChanges["undo"].pop())
				
			}
			checkInvisibleRedoItems();
			checkChangedSources("backup");			
		} else

		if (type=="redo") {				
			t.arrLayers = jQuery.extend(true,{},t.arrLayersChanges["redo"][step].restore);
			
			showHideDeletedLayers();
			for (var i=0;i<=step;i++) {
				t.arrLayersChanges["undo"].push(t.arrLayersChanges["redo"].shift());				
			}
			checkChangedSources("restore");
		} 


		t.recreateLayerReferences();
		u.redrawSortbox();
		unselectLayers();
		t.cloneArrLayers();				
		updateHtmlLayersFromObject();						
		u.allLayerToIdle();
		u.stopAllLayerAnimation();
		u.organiseGroupsAndLayer();
		setTimeout(function() {
			t.update_undo_redo_list();
			
			u.updateAllLayerTimeline();

		},10);		
	}


	/********************************************************************************************************/
	
	t.recreateLayerReferences = function() {

		for (var i in t.arrLayers) {
			var objLayer = t.arrLayers[i];
			objLayer.references = objLayer.references === undefined ? {} : objLayer.references;
			objLayer.references.htmlLayer = jQuery(document.getElementById('slide_layer_'+objLayer.serial));
			objLayer.references.sorttable.layer = jQuery(document.getElementById('layer_sort_'+objLayer.serial));
			objLayer.references.sorttable.timeline = jQuery(document.getElementById('layer_sort_time_'+objLayer.serial));
			objLayer.references.quicklayer = jQuery(document.getElementById('layer_quicksort_'+objLayer.serial));
		}

		for (var i in t.arrLayersDemo) {
			var objLayer = t.arrLayersDemo[i];
			objLayer.references = objLayer.references === undefined ? {} : objLayer.references;
			objLayer.references.htmlLayer = jQuery(document.getElementById('demo_layer_'+objLayer.serial));
			objLayer.references.sorttable.layer = jQuery(document.getElementById('demo_sort_'+objLayer.serial));
			objLayer.references.sorttable.timeline = jQuery(document.getElementById('demo_sort_time_'+objLayer.serial));
			objLayer.references.quicklayer = jQuery(document.getElementById('demo_quicksort_'+objLayer.serial));
		}
	}
	
	t.updateReverseList = function() {
		clearTimeout(updateRevTimer);
		updateRevTimer =  setTimeout(function() {
			RevSliderSettings.onoffStatus(jQuery('#layer_anim_xstart_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#layer_anim_ystart_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#layer_anim_xrotate_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#layer_anim_yrotate_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#layer_anim_zrotate_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#layer_scale_xstart_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#layer_scale_ystart_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#layer_skew_xstart_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#layer_skew_ystart_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#mask_anim_xstart_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#mask_anim_ystart_reverse'));

			RevSliderSettings.onoffStatus(jQuery('#layer_anim_xend_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#layer_anim_yend_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#layer_anim_xrotate_end_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#layer_anim_yrotate_end_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#layer_anim_zrotate_end_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#layer_scale_xend_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#layer_scale_yend_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#layer_skew_xend_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#layer_skew_yend_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#mask_anim_xend_reverse'));
			RevSliderSettings.onoffStatus(jQuery('#mask_anim_yend_reverse'));
		},100);
	}

	/**
	 * update current layer
	 */
	t.updateCurrentLayer = function(objData,del_certain){
		
		if(!t.arrLayers[t.selectedLayerSerial]){
			UniteAdminRev.showErrorMessage("error! the layer with serial: "+t.selectedLayerSerial+" doesn't exists");
			return(false);
		}
		
		
		t.updateLayer(t.selectedLayerSerial,objData,del_certain);

	}


	/**
	 * add image layer
	 */
	var addLayerImage = function(imgobj, special_type){
		
		objLayer = {
			style: "",
			text: "Image " + (id_counter+1),
			type: "image",
			image_url: imgobj.imgurl				
		};

		//Add Library Relevant Informations
		if (imgobj.imglib!==undefined) {
			objLayer.image_library = imgobj.imglib;
			objLayer.image_librarysize = {} 
			objLayer.image_librarysize.width = imgobj.imgwidth;
			objLayer.image_librarysize.height = imgobj.imgheight;
			
		}
		
		objLayer.scaleProportional = true;
		
		objLayer = t.setVal(objLayer, 'scaleX', imgobj.imgwidth, true);
		objLayer = t.setVal(objLayer, 'scaleY', imgobj.imgheight, true);

		objLayer = t.setVal(objLayer, 'originalWidth', imgobj.imgwidth, true);
		objLayer = t.setVal(objLayer, 'originalHeight', imgobj.imgheight, true);
		
		if(typeof special_type !== 'undefined')
			objLayer['special_type'] = special_type;

		objLayer.createdOnInit = false;
		addLayer(objLayer);

		
	}


	/**
	 * get video layer object from video data
	 */
	var getVideoObjLayer = function(videoData, adding){
		
		var objLayer = {
				type:"video",
				style : "",
				video_type: videoData.video_type,
				video_data:videoData
			};
			
		objLayer.video_data.autoplayonlyfirsttime = false; //needed for v5 as prior to v4, this was existing and is now in autoplay
		
		if(typeof(adding) !== 'undefined'){
			objLayer.video_width = videoData.video_width;
			objLayer.video_height = videoData.video_height;
		}

		if(objLayer.video_type == "youtube" || objLayer.video_type == "vimeo"){
			objLayer.video_id = videoData.id;
			objLayer.video_title = videoData.title;
			objLayer.video_image_url = videoData.thumb_medium.url;
			objLayer.video_args = videoData.args;
		}

		//set sortbox text
		switch(objLayer.video_type){
			case "youtube":
				objLayer.text = "Youtube: " + videoData.title;
			break;
			case "vimeo":
				objLayer.text = "Vimeo: " + videoData.title;
			break;
			case "streamyoutube":
				objLayer.text = "YouTube Stream";
				objLayer.video_title = objLayer.text;
				objLayer.video_image_url = "";
				if(videoData.urlPoster != "")
					objLayer.video_image_url = videoData.urlPoster;
			break;
			case "streamvimeo":
				objLayer.text = "Vimeo Stream";
				objLayer.video_title = objLayer.text;
				objLayer.video_image_url = "";
				if(videoData.urlPoster != "")
					objLayer.video_image_url = videoData.urlPoster;
			break;
			case "streaminstagram":
				objLayer.text = "Instagram Stream";
				objLayer.video_title = objLayer.text;
				objLayer.video_image_url = "";
				if(videoData.urlPoster != "")
					objLayer.video_image_url = videoData.urlPoster;
			break;
			case "html5":
				objLayer.text = "Html5 Video";
				objLayer.video_title = objLayer.text;
				objLayer.video_image_url = "";

				if(videoData.urlPoster != "")
					objLayer.video_image_url = videoData.urlPoster;

			break;
			case 'audio':
				objLayer.text = "Audio Layer";
				objLayer.audio_title = objLayer.text;
				objLayer.audio_image_url = "";

				if(videoData.urlPoster != "")
					objLayer.audio_image_url = videoData.urlPoster;
				
				objLayer.type = 'audio';
			break;
		}
		return(objLayer);
	}


	/**
	 * add video layer
	 */
	var addLayerVideo = function(videoData, special_type){
		
		var objLayer = getVideoObjLayer(videoData, true);

		if(typeof special_type !== 'undefined'){
			objLayer['special_type'] = special_type;
			
		}
		objLayer.createdOnInit = false;
		addLayer(objLayer);
		
		if(typeof special_type !== 'undefined'){
			if(special_type == 'audio'){
				var mcurrent_layer = t.getCurrentLayer();
				if(mcurrent_layer !== false) {
					u.drawAudioMap(mcurrent_layer);					
				}
			}
		}
	}


	/**
	 * add text layer
	 */
	var addLayerText = function(special_type,content){
		content = content===undefined ? initText + (id_counter+1) : content;

		var objLayer = {
			text:content,
			type:"text"
		};

		if(typeof special_type !== 'undefined')
			objLayer['special_type'] = special_type;

		objLayer.createdOnInit = false;
		addLayer(objLayer);

		setTimeout(function() {
			t.showHideContentEditor(true);				
			jQuery('#layer_text').data('new_content',true);
			jQuery('#layer_text').focus();						
		},50);
	}

	
	
	
	/**
	 * add Layer Group
	 */
	var addLayerGroup = function(special_type) {
		var objLayer = {
				type:"group",
				text:initGroupName + (id_counter +1),
				createdOnInit: false,
				grouptype:"logical",

			},
			c_objLayer =  {};
		
		if(typeof special_type !== 'undefined')
			objLayer['special_type'] = special_type;
		
		//get group unique ID to add it to the columns for reference
		var layer_id = addLayer(objLayer);
		t.makeRowSortableDroppable();
	}


	/**
	 * add Layer Row
	 */
	var addLayerRow = function(special_type) {
		var objLayer = {
				type:"row",
				text:initRowName + (id_counter +1),
				createdOnInit: false
			},
			c_objLayer =  {};
		
		if(typeof special_type !== 'undefined')
			objLayer['special_type'] = special_type;
		
		//get group unique ID to add it to the columns for reference
		var layer_id = addLayer(objLayer);
		var ml = t.getLayer(layer_id);
		var groupid = ml.unique_id;

		for (var i=0;i<2;i++) {
			c_objLayer = {
				type:"column",
				text:initColumnName + (id_counter +1),
				ref_group:groupid,
				p_uid:groupid,
				column_size:"1/2",
				createdOnInit: false
			}
			addLayer(c_objLayer);
		}
		
		//jump to the group tab and open it		
		t.makeRowSortableDroppable();
		t.setLayerSelected(layer_id);
	}


	/*! ADD LAYER */
	/**
	 * add layer
	 */
	///////////////////////////
	// ADD ONE SINGLE LAYER  //
	///////////////////////////
	var addLayer = function(objLayer, isInit, isDemo, skipScroller){
		
		// UPDATE FROM PRE VERSION 5.3 TO VERSION 5.3+ 
		if (objLayer.version===undefined) {
			if (objLayer.endtime !== undefined && objLayer.endspeed!==undefined) {
				if (jQuery.isNumeric(objLayer.endtime))
					objLayer.endtime = objLayer.endtime - objLayer.endspeed;
			}
			
			// UPDATE FROM PREVERSION 4.x TO Max. 5.2.x
			if (objLayer.realEndTime && objLayer.realEndTime!="undefined" && objLayer.realEndTime!=undefined) {				
				 objLayer.endtime = objLayer.realEndTime;
				 
				 delete objLayer.realEndTime;
				 delete objLayer.endTimeFinal;
				 delete objLayer.endSpeedFinal;			 
			}
		}
		
		objLayer.version=t.core+""+t.sub+""+t.subsub;		



		if (objLayer.frames===undefined) objLayer.frames = {};

		isInit = isInit || false;
		isDemo = isDemo || false;
		
		var do_style_reset = false;
		
		if(objLayer.subtype == undefined)
			objLayer.subtype = '';
		
		if(objLayer.specialsettings == undefined)
			objLayer.specialsettings = {};
		
		if(objLayer.order == undefined)
			objLayer.order = (id_counter);
		
		objLayer.order = Number(objLayer.order);
		
		if(isInit == false && !isDemo){ //add unique layer ID only if not init and not demo
			unique_layer_id++;
			objLayer.unique_id = unique_layer_id;
		}
		
		if (objLayer.unique_id===undefined) {
			unique_layer_id++;
			objLayer.unique_id = unique_layer_id;
		} 
		
		if (jQuery.inArray(objLayer.unique_id,alluniqueids)>=0) {
			objLayer.unique_id = objLayer.unique_id+Math.round(Math.random()*100+100);
			unique_layer_id = objLayer.unique_id;
		}

		if (unique_layer_id<objLayer.unique_id)
				unique_layer_id = objLayer.unique_id+1;
		
		
		if (!isDemo) alluniqueids.push(objLayer.unique_id);

		
		var _x = objLayer.type === "video" ? initLeftVideo : initLeft,
			_y = objLayer.type === "video" ? initTopVideo : initTop;

		_x = t.newlayercoord.x!==-1 ? t.newlayercoord.x : _x;
		_y = t.newlayercoord.y!==-1 ? t.newlayercoord.y : _y;
		

		//set init position
		objLayer = t.getVal(objLayer, 'left') == undefined ? t.setVal(objLayer, 'left', _x, true) : typeof(objLayer.left) !== 'object' ? t.setVal(objLayer, 'left', objLayer.left, true) : objLayer;
		objLayer = t.getVal(objLayer, 'top') == undefined ? t.setVal(objLayer, 'top', _y, true) : typeof(objLayer.top) !== 'object' ? t.setVal(objLayer, 'top', objLayer.top, true) : objLayer;			

		if(objLayer.type == "video") objLayer = checkUpdateFullwidthVideo(objLayer);
		
		t.newlayercoord.x = -1;
		t.newlayercoord.y = -1;

		objLayer.isDemo = isDemo;
		
		

		if(objLayer['layer_action'] !== undefined){ //check for each action if layer is set to self, if yes, change it to objLayer.unique_id
			if(objLayer['layer_action'].layer_target !== undefined){
				for(var key in objLayer['layer_action'].layer_target){
					if(objLayer['layer_action'].layer_target[key] == 'self')
						objLayer['layer_action'].layer_target[key] = objLayer.unique_id;
				}
			}
		}
		
		objLayer.internal_class = objLayer.internal_class || '';
		
		// Enabled Hover ?
		objLayer['hover'] = objLayer['hover'] || false;

		objLayer['alias'] = objLayer['alias'] || u.getSortboxText(objLayer.text).toLowerCase();

		// PRESET DELETED INFO
		objLayer.layer_unavailable = false;
		objLayer.deleted = false;
		objLayer.createdOnInit = objLayer.createdOnInit != undefined ? objLayer.createdOnInit : isInit==true ? true : false;
		
		//background image settings for layer
		objLayer.layer_bg_position = objLayer.layer_bg_position 	|| "center center";
		objLayer.layer_bg_size = objLayer.layer_bg_size 	|| "cover";
		objLayer.layer_bg_repeat = objLayer.layer_bg_repeat 	|| "no-repeat";
		
		
		//set Loop Animations
		objLayer.loop_animation = objLayer.loop_animation 	|| "none";
		objLayer.loop_easing = objLayer.loop_easing 		|| "linearEaseNone";
		objLayer.loop_speed = objLayer.loop_speed != undefined ? objLayer.loop_speed :  2;
		objLayer.loop_startdeg = objLayer.loop_startdeg != undefined ? objLayer.loop_startdeg : -20;
		objLayer.loop_enddeg = objLayer.loop_enddeg != undefined ? 	objLayer.loop_enddeg : 20;
		objLayer.loop_xorigin = objLayer.loop_xorigin != undefined ? objLayer.loop_xorigin : 50;
		objLayer.loop_yorigin = objLayer.loop_yorigin != undefined ? objLayer.loop_yorigin : 50;
		objLayer.loop_xstart = objLayer.loop_xstart != undefined ? objLayer.loop_xstart : 0;
		objLayer.loop_xend = objLayer.loop_xend != undefined ? objLayer.loop_xend : 0;
		objLayer.loop_ystart = objLayer.loop_ystart != undefined ? objLayer.loop_ystart : 0;
		objLayer.loop_yend = objLayer.loop_yend != undefined ? objLayer.loop_yend : 0;
		objLayer.loop_zoomstart = objLayer.loop_zoomstart != undefined ? objLayer.loop_zoomstart : 1;
		objLayer.loop_zoomend = objLayer.loop_zoomend != undefined ? objLayer.loop_zoomend : 1;
		objLayer.loop_angle = objLayer.loop_angle != undefined ? objLayer.loop_angle : 0;
		objLayer.loop_radius = objLayer.loop_radius != undefined ? objLayer.loop_radius : 10;

		objLayer.layer_blend_mode = objLayer.layer_blend_mode != undefined ? objLayer.layer_blend_mode : "normal";
		
		objLayer.html_tag = objLayer.html_tag 		|| "div";
		objLayer.parallax_layer_ddd_zlevel = objLayer.parallax_layer_ddd_zlevel 		|| "front";
		
		// set Mask Animation
		objLayer.mask_start = objLayer.mask_start	 		|| false;
		objLayer.mask_end = objLayer.mask_end		 		|| false;

		// Hover Force
		objLayer.force_hover = objLayer.force_hover===undefined ? true : objLayer.force_hover;
		
		// Column Break At
		if (objLayer.type==="row")
			objLayer.column_break_at = objLayer.column_break_at || "mobile";

		// Set Reverse Basics					
		objLayer.x_start_reverse = objLayer.x_start_reverse || false;
		objLayer.y_start_reverse = objLayer.y_start_reverse || false;
		objLayer.x_end_reverse = objLayer.x_end_reverse || false;
		objLayer.y_end_reverse = objLayer.y_end_reverse || false;
		objLayer.x_rotate_start_reverse = objLayer.x_rotate_start_reverse || false;
		objLayer.y_rotate_start_reverse = objLayer.y_rotate_start_reverse || false;
		objLayer.z_rotate_start_reverse = objLayer.z_rotate_start_reverse || false;
		objLayer.x_rotate_end_reverse = objLayer.x_rotate_end_reverse || false;
		objLayer.y_rotate_end_reverse = objLayer.y_rotate_end_reverse || false;
		objLayer.z_rotate_end_reverse = objLayer.z_rotate_end_reverse || false;
		objLayer.scale_x_start_reverse = objLayer.scale_x_start_reverse || false;
		objLayer.scale_y_start_reverse = objLayer.scale_y_start_reverse || false;
		objLayer.scale_x_end_reverse = objLayer.scale_x_end_reverse || false;
		objLayer.scale_y_end_reverse = objLayer.scale_y_end_reverse || false;
		objLayer.skew_x_start_reverse = objLayer.skew_x_start_reverse || false;
		objLayer.skew_y_start_reverse = objLayer.skew_y_start_reverse || false;
		objLayer.skew_x_end_reverse = objLayer.skew_x_end_reverse || false;
		objLayer.skew_y_end_reverse = objLayer.skew_y_end_reverse || false;
		objLayer.mask_x_start_reverse = objLayer.mask_x_start_reverse || false;
		objLayer.mask_y_start_reverse = objLayer.mask_y_start_reverse || false;
		objLayer.mask_x_end_reverse = objLayer.mask_x_end_reverse || false;
		objLayer.mask_y_end_reverse = objLayer.mask_y_end_reverse || false;

		objLayer.mask_x_start = objLayer.mask_x_start 			|| 0;
		objLayer.mask_y_start = objLayer.mask_y_start 			|| 0;
		objLayer.mask_speed_start = objLayer.mask_speed_start 	|| "inherit";
		objLayer.mask_ease_start = objLayer.mask_ease_start 	|| "inherit";
		
		objLayer.mask_x_end = objLayer.mask_x_end 			|| 0;
		objLayer.mask_y_end = objLayer.mask_y_end 			|| 0;
		objLayer.mask_speed_end = objLayer.mask_speed_end 	|| "inherit";
		objLayer.mask_ease_end = objLayer.mask_ease_end 	|| "inherit";
		
		objLayer.alt_option = objLayer.alt_option			|| 'media_library';
		objLayer.alt = objLayer.alt							|| '';

		// Layer Action
		objLayer.layer_action = objLayer.layer_action || {};
		objLayer.layer_action.tooltip_event = objLayer.layer_action.tooltip_event || [];
		objLayer.layer_action.action = objLayer.layer_action.action || [];
		objLayer.layer_action.image_link = objLayer.layer_action.image_link || [];
		objLayer.layer_action.link_open_in = objLayer.layer_action.link_open_in || [];
		objLayer.layer_action.jump_to_slide = objLayer.layer_action.jump_to_slide || [];
		objLayer.layer_action.scrollunder_offset = objLayer.layer_action.scrollunder_offset || [];
		objLayer.layer_action.actioncallback = objLayer.layer_action.actioncallback || [];
		objLayer.layer_action.layer_target = objLayer.layer_action.layer_target || [];
		objLayer.layer_action.link_type = objLayer.layer_action.link_type || [];
		objLayer.layer_action.action_delay = objLayer.layer_action.action_delay || [];
		objLayer.layer_action.toggle_layer_type = objLayer.layer_action.toggle_layer_type || [];
		objLayer.layer_action.toggle_class = objLayer.layer_action.toggle_class || [];
		
		

		
		
		objLayer = t.getVal(objLayer, 'max_height') == undefined ? 
			t.setVal(objLayer, 'max_height', "auto", true) : 
			typeof(objLayer.max_height) !== 'object' ? 
				t.setVal(objLayer, 'max_height', objLayer.max_height, true) : 
				objLayer;
			
		objLayer = t.getVal(objLayer, 'min_height') == undefined ? 
			t.setVal(objLayer, 'min_height', "40", true) : 
			typeof(objLayer.min_height) !== 'object' ? 
				t.setVal(objLayer, 'min_height', objLayer.min_height, true) : 
				objLayer;


		if(t.getVal(objLayer, 'max_width') == undefined){			
			objLayer = t.setVal(objLayer, 'max_width', "auto", true);
		}else{
			if(typeof(objLayer.max_width) !== 'object'){				
				objLayer = t.setVal(objLayer, 'max_width', objLayer.max_width, true);
			}
		}

		if (objLayer.type === "group" && t.getVal(objLayer, 'max_height') == "auto") {
			objLayer = t.setVal(objLayer, 'max_width', "200", true);
			objLayer = t.setVal(objLayer, 'max_height', "200", true);
		}
		
		if(objLayer.type == 'video' && typeof(objLayer.video_width) == 'undefined' && typeof(objLayer.video_data.width) !== 'undefined') objLayer.video_width = objLayer.video_data.width; //fallback to RS video prior 5.0
		if(t.getVal(objLayer, 'video_width') == undefined){
			objLayer = t.setVal(objLayer, 'video_width', 480, true);
		}else{
			if(typeof(objLayer.video_width) !== 'object'){
				objLayer = t.setVal(objLayer, 'video_width', objLayer.video_width, true);
			}
		}
		
		if(objLayer.type == 'video' && typeof(objLayer.video_height) == 'undefined' && typeof(objLayer.video_data.height) !== 'undefined') objLayer.video_height = objLayer.video_data.height; //fallback to RS video prior 5.0
		if(t.getVal(objLayer, 'video_height') == undefined){
			objLayer = t.setVal(objLayer, 'video_height', 360, true);
		}else{
			if(typeof(objLayer.video_height) !== 'object'){
				objLayer = t.setVal(objLayer, 'video_height', objLayer.video_height, true);
			}
		}

		// ORIGIN AND 2D ROTATION
		objLayer['2d_rotation'] = objLayer['2d_rotation'] == undefined && isInit ? 0 : objLayer['2d_rotation'];
		objLayer['2d_origin_x'] = objLayer['2d_origin_x'] != undefined ? objLayer['2d_origin_x'] : 50;
		objLayer['2d_origin_y'] = objLayer['2d_origin_y'] != undefined ?  objLayer['2d_origin_y'] : 50;
		
		
		if(t.getVal(objLayer, 'whitespace') == undefined){
			objLayer = t.setVal(objLayer, 'whitespace', jQuery("#layer_whitespace option:selected").val(), true);
		}else{
			if(typeof(objLayer.whitespace) !== 'object'){
				objLayer = t.setVal(objLayer, 'whitespace', objLayer.whitespace, true);
			}
		}

		if(t.getVal(objLayer, 'display') == undefined){
			objLayer = t.setVal(objLayer, 'display', jQuery("#layer_display option:selected").val(), true);
		}else{
			if(typeof(objLayer.display) !== 'object'){
				objLayer = t.setVal(objLayer, 'display', objLayer.display, true);
			}
		}

		if(objLayer.static_start == undefined)
			objLayer.static_start = jQuery("#layer_static_start option:selected").val();

		if(objLayer.static_end == undefined)
			objLayer.static_end = 'last'; 

		

		if(t.getVal(objLayer, 'align_hor') == undefined){
			objLayer = t.setVal(objLayer, 'align_hor', 'left', true);
		}else{
			if(typeof(objLayer.align_hor) !== 'object'){
				objLayer = t.setVal(objLayer, 'align_hor', objLayer.align_hor, true);
			}
		}
		if(t.getVal(objLayer, 'align_vert') == undefined){
			objLayer = t.setVal(objLayer, 'align_vert', 'top', true);
		}else{
			if(typeof(objLayer.align_vert) !== 'object'){
				objLayer = t.setVal(objLayer, 'align_vert', objLayer.align_vert, true);
			}
		}

		//set animation:
		objLayer.hiddenunder = objLayer.hiddenunder || false;	
		objLayer.resizeme = objLayer.resizeme || true;			
		objLayer['seo-optimized'] = objLayer['seo-optimized'] || false;
		
		//set image link		
		objLayer.link = objLayer.link || "";

		//set image link open in
		objLayer.link_open_in = objLayer.link_open_in || "same";

		//set slide link:		
		objLayer.link_slide = objLayer.link_slide || "nothing";

		//set scroll under offset		
		objLayer.scrollunder_offset = objLayer.scrollunder_offset || "";

		//set style, if empty, add first style from the list		
			objLayer.style = objLayer.style || '';
		
		
		
		
		objLayer['visible-desktop'] = (objLayer['visible-desktop']===undefined) ? true : objLayer['visible-desktop'];
		objLayer['visible-notebook'] = (objLayer['visible-notebook']===undefined) ? true : objLayer['visible-notebook'];
		objLayer['visible-tablet'] = (objLayer['visible-tablet']===undefined) ? true : objLayer['visible-tablet'];
		objLayer['visible-mobile'] = (objLayer['visible-mobile']===undefined) ? true : objLayer['visible-mobile'];
		
		objLayer['resize-full'] = objLayer['resize-full'] !== undefined ? objLayer['resize-full'] : true;				
		objLayer['hiddenunder'] = objLayer['hiddenunder'] !== undefined ? objLayer['hiddenunder'] : false;	
		objLayer['show-on-hover'] = objLayer['show-on-hover'] !== undefined ? objLayer['show-on-hover'] : false;				
		objLayer.basealign = objLayer.basealign || 'grid';						
		objLayer.responsive_offset = objLayer.responsive_offset!==undefined ? objLayer.responsive_offset : true;				
		objLayer.style = jQuery.trim(objLayer.style);
		

		if(isInit == false && objLayer.type == "text" && (!objLayer.style || objLayer.style == ""))	do_style_reset = true;				
		
		objLayer['lazy-load'] = objLayer['lazy-load'] || 'auto';			
		objLayer['image-size'] = objLayer['image-size'] || 'auto';
		
		//if(objLayer.type == "group"){
			objLayer['css-position'] = objLayer['css-position'] || 'relative';
		//}
		//add time


		

		// FIRST FRAME ANIMATION UPDATE
		if (objLayer.time!==undefined) {			
			objLayer.frames.frame_0 = {time:Number(objLayer.time), delay:0, split:objLayer.split, split_extratime: 0, splitdelay:objLayer.splitdelay, speed:objLayer.speed,animation:objLayer.animation, easing:objLayer.easing };
			 delete objLayer.time;
			 delete objLayer.splitdelay;
			 delete objLayer.speed;	
			 delete objLayer.split;
			 delete objLayer.easing;
			 delete objLayer.animation;			 
		} 

		// LAST FRAME ANIMATION UPDATE
		if (objLayer.endtime!==undefined) {
			objLayer.frames.frame_999 = {time:objLayer.endtime, delay:0,split:objLayer.endsplit, split_extratime:0, splitdelay:objLayer.endsplitdelay, speed:objLayer.endspeed!=undefined ? objLayer.endspeed : initSpeed, animation:objLayer.endanimation, easing:objLayer.endeasing};
			 delete objLayer.endtime;
			 delete objLayer.endsplitdelay;
			 delete objLayer.endspeed;	
			 delete objLayer.endeasing;
			 delete objLayer.endsplit;
			 delete objLayer.endanimation;
		}
		
		
		if (objLayer.frames.frame_0===undefined)  objLayer.frames.frame_0 = {time:0, delay:0, split:"none", splitdelay:10, split_extratime:0, speed:300,animation:"tp-fade", easing:"Power3.easeInOut"};		
		if (objLayer.frames.frame_999===undefined) objLayer.frames.frame_999 = {time:g_slideTime, delay:0, split:"none", splitdelay:10, split_extratime:0, speed:300,animation:"tp-fade", easing:"Power3.easeInOut"};
		
		objLayer.frames.frame_0.time =  objLayer.frames.frame_0.time===undefined ? 10 : objLayer.frames.frame_0.time;
		objLayer.frames.frame_0.delay =  objLayer.frames.frame_0.delay===undefined ? 0 : objLayer.frames.frame_0.delay;
		objLayer.frames.frame_0.split =  objLayer.frames.frame_0.split===undefined ? "none" : objLayer.frames.frame_0.split;
		objLayer.frames.frame_0.splitdelay =  objLayer.frames.frame_0.splitdelay===undefined ? 10 : objLayer.frames.frame_0.splitdelay;
		objLayer.frames.frame_0.split_extratime =  objLayer.frames.frame_0.split_extratime===undefined ? 0 : objLayer.frames.frame_0.split_extratime;
		objLayer.frames.frame_0.speed =  objLayer.frames.frame_0.speed===undefined ? 300 : objLayer.frames.frame_0.speed;
		objLayer.frames.frame_0.animation =  objLayer.frames.frame_0.animation===undefined ? "tp-fade" : objLayer.frames.frame_0.animation;
		objLayer.frames.frame_0.easing =  objLayer.frames.frame_0.easing===undefined ? "Power3.easeInOut" : objLayer.frames.frame_0.easing;

		objLayer.frames.frame_999.time =  objLayer.frames.frame_999.time===undefined ? 10 : objLayer.frames.frame_999.time;
		objLayer.frames.frame_999.delay =  objLayer.frames.frame_999.delay===undefined ? 0 : objLayer.frames.frame_999.delay;
		objLayer.frames.frame_999.split =  objLayer.frames.frame_999.split===undefined ? "none" : objLayer.frames.frame_999.split;
		objLayer.frames.frame_999.splitdelay =  objLayer.frames.frame_999.splitdelay===undefined ? 10 : objLayer.frames.frame_999.splitdelay;
		objLayer.frames.frame_999.split_extratime =  objLayer.frames.frame_999.split_extratime===undefined ? 0 : objLayer.frames.frame_999.split_extratime;
		objLayer.frames.frame_999.speed =  objLayer.frames.frame_999.speed===undefined ? 300 : objLayer.frames.frame_999.speed;
		objLayer.frames.frame_999.animation =  objLayer.frames.frame_999.animation===undefined ? "tp-fade" : objLayer.frames.frame_999.animation;
		objLayer.frames.frame_999.easing =  objLayer.frames.frame_999.easing===undefined ? "Power3.easeInOut" : objLayer.frames.frame_999.easing;

		
		
		if(t.getVal(objLayer, 'width') == undefined){
			objLayer = t.setVal(objLayer, 'width', -1, true);
		}else{
			if(typeof(objLayer.width) !== 'object'){
				objLayer = t.setVal(objLayer, 'width', objLayer.width, true);
			}
		}

		if(t.getVal(objLayer, 'height') == undefined){
			objLayer = t.setVal(objLayer, 'height', -1, true);
		}else{
			if(typeof(objLayer.height) !== 'object'){
				objLayer = t.setVal(objLayer, 'height', objLayer.height, true);
			}
		}
		
		if(t.getVal(objLayer, 'cover_mode') == undefined){
			objLayer = t.setVal(objLayer, 'cover_mode', 'custom', true); 
		}
		
		if(objLayer['static_styles'] == undefined){
			objLayer['static_styles'] = {};
			t.reset_to_default_static_styles(objLayer);

			if(t.getVal(objLayer['static_styles'], 'font-size') == undefined){
				objLayer['static_styles'] = t.setVal(objLayer['static_styles'], 'font-size', 20, true);
			}

			if(t.getVal(objLayer['static_styles'], 'line-height') == undefined){
				objLayer['static_styles'] = t.setVal(objLayer['static_styles'], 'line-height', 22, true);
			}

			if(t.getVal(objLayer['static_styles'], 'font-weight') == undefined){
				objLayer['static_styles'] = t.setVal(objLayer['static_styles'], 'font-weight', 400, true);
			}

			if(t.getVal(objLayer['static_styles'], 'color') == undefined){
				objLayer['static_styles'] = t.setVal(objLayer['static_styles'], 'color', "#ffffff", true);
			}
		}else{
			if(typeof(objLayer['static_styles']['font-size']) !== 'object'){
				objLayer['static_styles'] = t.setVal(objLayer['static_styles'], 'font-size', objLayer['static_styles']['font-size'], true);
			}
			if(typeof(objLayer['static_styles']['line-height']) !== 'object'){
				objLayer['static_styles'] = t.setVal(objLayer['static_styles'], 'line-height', objLayer['static_styles']['line-height'], true);
			}
			if(typeof(objLayer['static_styles']['font-weight']) !== 'object'){
				objLayer['static_styles'] = t.setVal(objLayer['static_styles'], 'font-weight', objLayer['static_styles']['font-weight'], true);
			}
			if(typeof(objLayer['static_styles']['color']) !== 'object'){
				objLayer['static_styles'] = t.setVal(objLayer['static_styles'], 'color', objLayer['static_styles']['color'], true);
			}
		}
		
		
		if(objLayer['margin'] == undefined){
			objLayer['margin'] = {};
			var cur_mar = [];
			jQuery('input[name="css_margin[]"]').each(function(){
				cur_mar.push(0);
			});		

			objLayer = t.setVal(objLayer,'margin' ,cur_mar, true);
		}else{
			if(typeof(objLayer['margin']) !== 'object'){
				objLayer = t.setVal(objLayer, 'margin', objLayer['margin'], true);
			}			
		}

		if(objLayer['padding'] == undefined){
			//check if we have in deformation
			if(objLayer['deformation'] !== undefined && objLayer['deformation']['padding'] !== undefined){ //fallback
				objLayer = t.setVal(objLayer, 'padding', objLayer['deformation']['padding'], true);
			}else{
				objLayer['padding'] = {};
				var cur_pad = [];
				jQuery('input[name="css_padding[]"]').each(function(){
					cur_pad.push(0);
				});		
				objLayer = t.setVal(objLayer, 'padding' ,cur_pad, true);
			}
		}else{
			if(typeof(objLayer['padding']) !== 'object'){
				objLayer = t.setVal(objLayer, 'padding', objLayer['padding'], true);
			}
		}
		
		if(objLayer['text-align'] == undefined){
			//check if we have in deformation
			if(objLayer['deformation'] !== undefined && objLayer['deformation']['text-align'] !== undefined){ //fallback
				objLayer = t.setVal(objLayer, 'text-align', objLayer['deformation']['text-align'], true);
			}else{
				objLayer = t.setVal(objLayer, 'text-align', 'inherit', true);
			}
		}else{
			if(typeof(objLayer['text-align']) !== 'object'){
				objLayer = t.setVal(objLayer, 'text-align', objLayer['text-align'], true);
			}			
		}


		//round position
		objLayer = t.setVal(objLayer, 'top', Math.round(t.getVal(objLayer, 'top')));
		objLayer = t.setVal(objLayer, 'left', Math.round(t.getVal(objLayer, 'left')));
		

		if(objLayer.x_start == undefined)
			objLayer.x_start = "inherit";

		if(objLayer.y_start == undefined)
			objLayer.y_start = "inherit";

		if(objLayer.z_start == undefined)
			objLayer.z_start = "inherit";

		if(objLayer.x_end == undefined)
			objLayer.x_end = "inherit";

		if(objLayer.y_end == undefined)
			objLayer.y_end = "inherit";

		if(objLayer.z_end == undefined)
			objLayer.z_end = "inherit";

		if(objLayer.opacity_start == undefined){
			if(isInit == false){
				objLayer.opacity_start = "0";
			}else{
				objLayer.opacity_start = "inherit";
			}
		}

		if(objLayer.opacity_end == undefined){
			if(isInit == false){
				objLayer.opacity_end = "0";
			}else{
				objLayer.opacity_end = "inherit";
			}
		}

		if(objLayer.x_rotate_start == undefined)
			objLayer.x_rotate_start = "inherit";

		if(objLayer.y_rotate_start == undefined)
			objLayer.y_rotate_start = "inherit";

		if(objLayer.z_rotate_start == undefined)
			objLayer.z_rotate_start = "inherit";

		if(objLayer.x_rotate_end == undefined)
			objLayer.x_rotate_end = "inherit";

		if(objLayer.y_rotate_end == undefined)
			objLayer.y_rotate_end = "inherit";

		if(objLayer.z_rotate_end == undefined)
			objLayer.z_rotate_end = "inherit";

		if(objLayer.scale_x_start == undefined)
			objLayer.scale_x_start = "inherit";

		if(objLayer.scale_y_start == undefined)
			objLayer.scale_y_start = "inherit";

		if(objLayer.scale_x_end == undefined)
			objLayer.scale_x_end = "inherit";

		if(objLayer.scale_y_end == undefined)
			objLayer.scale_y_end = "inherit";

		if(objLayer.skew_x_start == undefined)
			objLayer.skew_x_start = "inherit";

		if(objLayer.skew_y_start == undefined)
			objLayer.skew_y_start = "inherit";

		if(objLayer.skew_x_end == undefined)
			objLayer.skew_x_end = "inherit";

		if(objLayer.skew_y_end == undefined)
			objLayer.skew_y_end = "inherit";
		

		if(objLayer.pers_start == undefined)
			objLayer.pers_start = "inherit";

		if(objLayer.pers_end == undefined)
			objLayer.pers_end = "inherit";


		// KRISZTAN  -  ( NEW LAYER GETS ADDED ) deformation part
		if(objLayer.deformation == undefined || jQuery.isEmptyObject(objLayer['deformation']))
			objLayer.deformation = {};

		if(objLayer['deformation']['font-family'] == undefined){
			objLayer['deformation']['font-family'] = "Open Sans";
			sgfamilies.push('Open Sans');
		}else{
			if(objLayer['deformation']['font-family'] !== '' && sgfamilies.indexOf(objLayer['deformation']['font-family']) == -1){
				sgfamilies.push(objLayer['deformation']['font-family']);
			}
		}
		
		/*if(objLayer['deformation']['padding'] == undefined){
			var cur_pad = [];
			jQuery('input[name="css_padding[]"]').each(function(){
				cur_pad.push(0);
			});
			objLayer['deformation']['padding'] = cur_pad; //4 []
		}*/

		

		if(objLayer['deformation']['font-style'] == undefined){
			objLayer['deformation']['font-style'] = 'normal'; // checkbox
		}

		if(objLayer['deformation']['color-transparency'] == undefined)
			objLayer['deformation']['color-transparency'] = 1;
		
		if(objLayer['deformation']['text-decoration'] == undefined)
			objLayer['deformation']['text-decoration'] = "none";

		/*if(objLayer['deformation']['text-align'] == undefined)
			objLayer['deformation']['text-align'] = "inherit";*/
		
		if(objLayer['deformation']['vertical-align'] == undefined)
			objLayer['deformation']['vertical-align'] = "top";
		

		if(objLayer['deformation']['text-transform'] == undefined)
			objLayer['deformation']['text-transform'] = "none";

		if(objLayer['deformation']['background-color'] == undefined)
			objLayer['deformation']['background-color'] = "transparent";
		
		if(objLayer['deformation']['background-transparency'] == undefined)
			objLayer['deformation']['background-transparency'] = 1;

		if(objLayer['deformation']['border-color'] == undefined)
			objLayer['deformation']['border-color'] = "transparent";

		if(objLayer['deformation']['border-transparency'] == undefined)
			objLayer['deformation']['border-transparency'] = 1;

		if(objLayer['deformation']['border-style'] == undefined)
			objLayer['deformation']['border-style'] = "none";

		/*if(objLayer['deformation']['border-width'] == undefined)
			objLayer['deformation']['border-width'] = "0";
		*/
		
		if(objLayer['deformation']['border-width'] == undefined){
			var cur_bor = [];
			jQuery('input[name="css_border-width[]"]').each(function(){
				cur_bor.push(0);
			});
			objLayer['deformation']['border-width'] = cur_bor; //4 []
		}else{ //fallback
			if(!jQuery.isArray(objLayer['deformation']['border-width'])){
				objLayer['deformation']['border-width'] = [objLayer['deformation']['border-width'],objLayer['deformation']['border-width'],objLayer['deformation']['border-width'],objLayer['deformation']['border-width']];
			}
		}

		if(objLayer['deformation']['border-radius'] == undefined){
			var cur_bor = [];
			jQuery('input[name="css_border-radius[]"]').each(function(){
				cur_bor.push(0);
			});
			objLayer['deformation']['border-radius'] = cur_bor; //4 []
		}

		if (objLayer.svg==undefined) 
			objLayer.svg = {};

		if(objLayer.svg['svgstroke-color'] == undefined)
			objLayer.svg['svgstroke-color'] = "transparent";

		if(objLayer.svg['svgstroke-transparency'] == undefined)
			objLayer.svg['svgstroke-transparency'] = 1;

		if(objLayer.svg['svgstroke-dasharray'] == undefined)
			objLayer.svg['svgstroke-dasharray'] = "0";

		if(objLayer.svg['svgstroke-dashoffset'] == undefined)
			objLayer.svg['svgstroke-dashoffset'] = "0";

		if(objLayer.svg['svgstroke-width'] == undefined)
			objLayer.svg['svgstroke-width'] = "0"

		if(objLayer.svg['svgstroke-hover-color'] == undefined)
			objLayer.svg['svgstroke-hover-color'] = "transparent";

		if(objLayer.svg['svgstroke-hover-transparency'] == undefined)
			objLayer.svg['svgstroke-hover-transparency'] = 1;

		if(objLayer.svg['svgstroke-hover-dasharray'] == undefined)
			objLayer.svg['svgstroke-hover-dasharray'] = "0";

		if(objLayer.svg['svgstroke-hover-dashoffset'] == undefined)
			objLayer.svg['svgstroke-hover-dashoffset'] = "0";

		if(objLayer.svg['svgstroke-hover-width'] == undefined)
			objLayer.svg['svgstroke-hover-width'] = "0";
		
		if(objLayer['deformation']['x'] == undefined)
			objLayer['deformation']['x'] = 0;

		if(objLayer['deformation']['y'] == undefined)
			objLayer['deformation']['y'] = 0;

		if(objLayer['deformation']['z'] == undefined)
			objLayer['deformation']['z'] = 0;

		if(objLayer['deformation']['skewx'] == undefined)
			objLayer['deformation']['skewx'] = 0;

		if(objLayer['deformation']['skewy'] == undefined)
			objLayer['deformation']['skewy'] = 0;

		if(objLayer['deformation']['scalex'] == undefined)
			objLayer['deformation']['scalex'] = 1;

		if(objLayer['deformation']['scaley'] == undefined)
			objLayer['deformation']['scaley'] = 1;

		if(objLayer['deformation']['opacity'] == undefined)
			objLayer['deformation']['opacity'] = 1;

		if(objLayer['deformation']['xrotate'] == undefined)
			objLayer['deformation']['xrotate'] = 0;

		if(objLayer['deformation']['yrotate'] == undefined)
			objLayer['deformation']['yrotate'] = 0;

		if(objLayer['2d_rotation'] == undefined)
			objLayer['2d_rotation'] = 0;

		if(objLayer['deformation']['2d_origin_x'] == undefined)
			objLayer['deformation']['2d_origin_x'] = 50;

		if(objLayer['deformation']['2d_origin_y'] == undefined)
			objLayer['deformation']['2d_origin_y'] = 50;

		if(objLayer['deformation']['pers'] == undefined)
			objLayer['deformation']['pers'] = 600;

		if(objLayer['deformation']['corner_left'] == undefined)
			objLayer['deformation']['corner_left'] = 'nothing';

		if(objLayer['deformation']['corner_right'] == undefined)
			objLayer['deformation']['corner_right'] = 'nothing';

		if(objLayer['deformation']['parallax'] == undefined)
			objLayer['deformation']['parallax'] = '-';
		
		//deformation part end
		
		//deformation hover part start
		if(objLayer['deformation-hover'] == undefined || jQuery.isEmptyObject(objLayer['deformation-hover'])){
			objLayer['deformation-hover'] = {};
		}
				

		if(objLayer['deformation-hover']['color'] == undefined)
			objLayer['deformation-hover']['color'] = "#ffffff";
			
		if(objLayer['deformation-hover']['color-transparency'] == undefined)
			objLayer['deformation-hover']['color-transparency'] = "1";
		
		if(objLayer['deformation-hover']['text-decoration'] == undefined)
			objLayer['deformation-hover']['text-decoration'] = "none";

		if(objLayer['deformation-hover']['background-color'] == undefined)
			objLayer['deformation-hover']['background-color'] = "transparent";

		if(objLayer['deformation-hover']['background-transparency'] == undefined)
			objLayer['deformation-hover']['background-transparency'] = 0;

		if(objLayer['deformation-hover']['border-color'] == undefined)
			objLayer['deformation-hover']['border-color'] = "transparent";
		
		if(objLayer['deformation-hover']['border-transparency'] == undefined)
			objLayer['deformation-hover']['border-transparency'] = "1";

		if(objLayer['deformation-hover']['border-style'] == undefined)
			objLayer['deformation-hover']['border-style'] = "none";

		if(objLayer['deformation-hover']['border-width'] == undefined)
			objLayer['deformation-hover']['border-width'] = 0;
		
		if(objLayer['deformation-hover']['border-width'] == undefined){
			var cur_bor = [];
			jQuery('input[name="hover_css_border-width[]"]').each(function(){
				cur_bor.push(0);
			});
			objLayer['deformation-hover']['border-width'] = cur_bor; //4 []
		}else{ //fallback
			if(!jQuery.isArray(objLayer['deformation-hover']['border-width'])){
				objLayer['deformation-hover']['border-width'] = [objLayer['deformation-hover']['border-width'],objLayer['deformation-hover']['border-width'],objLayer['deformation-hover']['border-width'],objLayer['deformation-hover']['border-width']];
			}
		}
		
		if(objLayer['deformation-hover']['border-radius'] == undefined){
			var cur_bor = [];
			jQuery('input[name="hover_css_border-radius[]"]').each(function(){
				cur_bor.push(0);
			});
			objLayer['deformation-hover']['border-radius'] = cur_bor; //4 []
		}

		if (objLayer.svg != undefined) {
			if(objLayer.svg['svgstroke-hover-color'] == undefined)
				objLayer.svg['svgstroke-hover-color'] = "transparent";

			if(objLayer.svg['svgstroke-hover-transparency'] == undefined)
				objLayer.svg['svgstroke-hover-transparency'] = 1;

			if(objLayer.svg['svgstroke-hover-dasharray'] == undefined)
				objLayer.svg['svgstroke-hover-dasharray'] = "0";

			if(objLayer.svg['svgstroke-hover-dashoffset'] == undefined)
				objLayer.svg['svgstroke-hover-dashoffset'] = "0";

			if(objLayer.svg['svgstroke-hover-width'] == undefined)
				objLayer.svg['svgstroke-hover-width'] = "0"
		}

		if(objLayer['deformation-hover']['x'] == undefined)
			objLayer['deformation-hover']['x'] = 0;

		if(objLayer['deformation-hover']['y'] == undefined)
			objLayer['deformation-hover']['y'] = 0;

		if(objLayer['deformation-hover']['z'] == undefined)
			objLayer['deformation-hover']['z'] = 0;

		if(objLayer['deformation-hover']['skewx'] == undefined)
			objLayer['deformation-hover']['skewx'] = 0;

		if(objLayer['deformation-hover']['skewy'] == undefined)
			objLayer['deformation-hover']['skewy'] = 0;

		if(objLayer['deformation-hover']['scalex'] == undefined)
			objLayer['deformation-hover']['scalex'] = 1;

		if(objLayer['deformation-hover']['scaley'] == undefined)
			objLayer['deformation-hover']['scaley'] = 1;

		if(objLayer['deformation-hover']['opacity'] == undefined)
			objLayer['deformation-hover']['opacity'] = 1;

		if(objLayer['deformation-hover']['xrotate'] == undefined)
			objLayer['deformation-hover']['xrotate'] = 0;

		if(objLayer['deformation-hover']['yrotate'] == undefined)
			objLayer['deformation-hover']['yrotate'] = 0;

		if(objLayer['deformation-hover']['2d_rotation'] == undefined)
			objLayer['deformation-hover']['2d_rotation'] = 0;

		if(objLayer['deformation-hover']['2d_origin_x'] == undefined)
			objLayer['deformation-hover']['2d_origin_x'] = 50;

		if(objLayer['deformation-hover']['2d_origin_y'] == undefined)
			objLayer['deformation-hover']['2d_origin_y'] = 50;
		
		if(objLayer['deformation-hover']['speed'] == undefined)
			objLayer['deformation-hover']['speed'] = 0;

		if(objLayer['deformation-hover']['zindex'] == undefined)
			objLayer['deformation-hover']['zindex'] = "auto";
		
		if(objLayer['deformation-hover']['easing'] == undefined)
			objLayer['deformation-hover']['easing'] = 'Linear.easeNone';
		
		if(objLayer['deformation-hover']['css_cursor'] == undefined)
			objLayer['deformation-hover']['css_cursor'] = "auto";
		//deformation hover part end
		
		if(objLayer['visible'] == undefined) objLayer['visible'] = true;
		
		if(objLayer.animation_overwrite == undefined)
			objLayer.animation_overwrite = 'wait';
		
		if(objLayer.trigger_memory == undefined)
			objLayer.trigger_memory = 'keep';
		
		objLayer.serial = id_counter;			

		
		
		
		
		// HOOK FOR EXTERNAL ADDONS
		jQuery.each(t.addon_callbacks, function(i,callback_element) {
			
			var callback = callback_element["callback"],                
				env = callback_element["environment"],
				env_sub = callback_element["function_position"];

			if (env === "add_layer_to_stage" && env_sub=="data_definition")                 
				objLayer = callback(objLayer);
		});
		
		
		//add html
		
		objLayer.isDemo = isDemo;
		
		var htmlLayer = t.makeLayerHtml(id_counter,objLayer,isDemo);				
		container.append(htmlLayer);
		
		objLayer.references = objLayer.references === undefined ? {} : objLayer.references;

		objLayer.references.htmlLayer = t.getHtmlLayerFromSerial(id_counter,isDemo);

		if(!isDemo){
			t.arrLayers[id_counter] = jQuery.extend({},objLayer);
		}else{
			t.arrLayersDemo[id_counter] = jQuery.extend({},objLayer);
		}
		

		
		//add layer to sortbox
		if(!isDemo) {
			
			u.addToSortbox(id_counter,objLayer);			
			
			if (skipScroller!=true)				
				u.timeLineTableDimensionUpdate();			
			
			
		}
		
		
		
		if(objLayer['visible'] == false && !isDemo){
			u.hideLayer(objLayer);
		}
		

		//refresh draggables
		if(!isDemo)
			refreshEvents(id_counter);

		// UNDO / REDO FUNCTION "Added Layer"
		if (objLayer.createdOnInit===false) {
			if(!isDemo)
				t.arrLayers[id_counter].layer_unavailable = true;				
			else
				t.arrLayersDemo[id_counter].layer_unavailable = true;
			
			t.cloneArrLayers();
			
			if(!isDemo)
				t.arrLayers[id_counter].layer_unavailable = false;
			else
				t.arrLayersDemo[id_counter].layer_unavailable = false;
			
			t.add_layer_change();

		}
		
		id_counter++;

		//enable "delete all" button, not event, but anyway :)
		jQuery("#button_delete_all").removeClass("button-now-disabled");
		u.rebuildLayerIdle(objLayer.references.htmlLayer,0,isDemo);	

		

		//select the layer
		if(isInit == false && !isDemo){
			
			t.setLayerSelected(objLayer.serial);
			jQuery("#layer_text").focus();
		}
		
		
		if(do_style_reset){ //trigger change event so that element gets first styles
			t.reset_to_default_static_styles(objLayer);
			// Reset Fields from Style Template
			updateSubStyleParameters(objLayer, true);
		}
		

		
		t.cloneArrLayers();						
		
		u.timeLineTableDimensionUpdate();	
		// CHANGE GROUP SORTS FOR LAYERS
		
		u.organiseGroupsAndLayer(false,false,true);		
		// END OF GROUP SORTS
		
		return objLayer.serial;
		
	}



	/**
	 * delete all representation of some layer
	 */
	t.deleteLayer = function(serial){
		
		/*t.checkActionsOnLayers(serial);
		deleteLayerFromObject(serial);
		deleteLayerFromHtml(serial);
		u.deleteLayerFromSortbox(serial);
		u.timeLineTableDimensionUpdate();*/
		var objLayer = t.getLayer(serial);	

		objLayer.deleted = true;		
		forceShowHideLayer(objLayer,"hide")	
		t.add_layer_change();
		u.timeLineTableDimensionUpdate();
	}


	/**
	 *
	 * call "deleteLayer" function with selected serial
	 */
	var deleteCurrentLayer = function(){
		
		if(t.selectedLayerSerial == -1) {
			return(false);
		}

		t.deleteLayer(t.selectedLayerSerial);

		//set unselected
		t.selectedLayerSerial = -1;

		//clear form and disable buttons
		disableFormFields();		
	}


	
	/**
	 * call "duplicateLayer" function with selected serial
	 */
	var duplicateLayerIntoNewGroup = function(obj) {
		obj.order = undefined;
		obj.time = undefined;
		obj.createdOnInit = false;
		unique_layer_id++;
		obj.unique_id = unique_layer_id;
		addLayer(obj, true);
		u.timeLineTableDimensionUpdate();
		return unique_layer_id;
	}

	var duplicateCurrentLayer = function(){		
		if(t.selectedLayerSerial == -1)
			return(false);

		var obj = t.arrLayers[t.selectedLayerSerial];
		var obj2 = jQuery.extend(true, {}, obj);	//duplicate object
		
		//t.getVal(obj, 'top');

		obj2 = t.setVal(obj2, 'left', t.getVal(obj2, 'left')+5);
		obj2 = t.setVal(obj2, 'top', t.getVal(obj2, 'top')+5);
		obj2.order = undefined;
		obj2.time = undefined;
		obj2.createdOnInit = false;
		
		//unique_id change as the true in addLayer is not triggering this
		unique_layer_id++;
		obj2.unique_id = unique_layer_id;

		
		
		addLayer(obj2, true);
		initDisallowCaptionsOnClick();		
		u.timeLineTableDimensionUpdate();
				
		// DUPLICATE GROUP
		if ((obj.type==="group") && t.getLayersInGroup(obj.unique_id).layers.length>0) {			
			jQuery.each(t.getLayersInGroup(obj.unique_id).layers,function(j,layer) {
				var newobj = jQuery.extend(true, {}, layer);				
				newobj.p_uid = obj2.unique_id;	
				duplicateLayerIntoNewGroup(newobj);
			});
			t.makeRowSortableDroppable();
		}

		// DUPLICATE COLUMN
		if ((obj.type==="row") && t.getLayersInGroup(obj.unique_id).layers.length>0) {			
			jQuery.each(t.getLayersInGroup(obj.unique_id).columns,function(j,column) {						
				var newcolumn = jQuery.extend(true, {}, column);
				newcolumn.p_uid = obj2.unique_id;
				newcolumn.ref_group = obj2.unique_id;
				var column_uid = duplicateLayerIntoNewGroup(newcolumn);
				jQuery.each(t.getLayersInGroup(column.unique_id).layers,function(j,layer) {
					var newobj = jQuery.extend(true, {}, layer);				
					newobj.p_uid = column_uid;	
					duplicateLayerIntoNewGroup(newobj);
				});
			});
			t.makeRowSortableDroppable();
		}


		var key;
		jQuery.each(t.getLayers(),function(k,layer) {
			key = k;
		});		
		t.setLayerSelected(key);	
		if (obj2.p_uid!==-1 && t.getObjLayerType(obj2.p_uid)!=="group") 			
			t.setInnerGroupOrders(obj2.references.htmlLayer.parent());
	}



	/**
	 * update the corners
	 */
	t.updateHtmlLayerCorners = function(objLayer){
		
		htmlLayer = jQuery(objLayer.references.htmlLayer[0].getElementsByClassName('innerslide_layer')[0]);
		
		var ncch = htmlLayer.outerHeight(),
			bgcol = htmlLayer.css('backgroundColor'),
			bgOpacity = UniteAdminRev.getTransparencyFromRgba(htmlLayer.css('backgroundColor'));
		bgOpacity = bgOpacity === false ? 1 : bgOpacity;
				
		htmlLayer.find('.frontcorner').remove();
		htmlLayer.find('.frontcornertop').remove();
		htmlLayer.find('.backcorner').remove();
		htmlLayer.find('.backcornertop').remove();


		if (objLayer==undefined || objLayer==false) return false;
		switch(objLayer['deformation']['corner_left']){
			case "curved":

				htmlLayer.append("<div class='frontcorner'></div>");
			break;
			case "reverced":
				htmlLayer.append("<div class='frontcornertop'></div>");
			break;
		}

		switch(objLayer['deformation']['corner_right']){
			case "curved":
				htmlLayer.append("<div class='backcorner'></div>");
			break;
			case "reverced":
				htmlLayer.append("<div class='backcornertop'></div>");
			break;
		}


		htmlLayer.find(".frontcorner").css({
            'borderWidth':ncch+"px",
            'left':(0-ncch)+'px',
            'borderRight':'0px solid transparent',
            'borderTopColor':bgcol
		});

		htmlLayer.find(".frontcornertop").css({
            'borderWidth':ncch+"px",
            'left':(0-ncch)+'px',
            'borderRight':'0px solid transparent',
            'borderBottomColor':bgcol
		});

		htmlLayer.find('.backcorner').css({
            'borderWidth':ncch+"px",
            'right':(0-ncch)+'px',
            'borderLeft':'0px solid transparent',
            'borderBottomColor':bgcol
        });

		htmlLayer.find('.backcornertop').css({
             'borderWidth':ncch+"px",
             'right':(0-ncch)+'px',
             'borderLeft':'0px solid transparent',
             'borderTopColor':bgcol
         });
	}
	

	// DELIVER THE SELECTED JQUERY OBJECT BASED ON SERIAL
	var getjQueryLayer = function() {
		return jQuery('#slide_layer_'+t.selectedLayerSerial);
	}

	


	// UPDATE LAYER TEXT ON WRITE && UPDATE TITLE OF LAYER
	var updateLayerTextField = function(event,timerobj,txt) {
		var jobj = getjQueryLayer();		
		if (t.selectedLayerSerial!=-1 && jobj.length>0) jobj[0].getElementsByClassName('innerslide_layer')[0].innerHTML = txt;			
		var li = timerobj.closest("li");
		txt = u.getSortboxText(txt);		
		if (li!=undefined) li[0].getElementsByClassName('timer-layer-text')[0].innerHTML = txt;				
	}

	/**
	 * update the position of html cross
	 */
	t.updateCrossIconPosition = function(objLayer){
		
		var htmlCross = jQuery(objLayer.references.htmlLayer[0].getElementsByClassName("icon_cross")[0]);
		var crossWidth = htmlCross.width();
		var crossHeight = htmlCross.height();
		var totalWidth = objLayer.references.htmlLayer.outerWidth();
		var totalHeight = objLayer.references.htmlLayer.outerHeight();
		var crossHalfW = Math.round(crossWidth / 2);
		var crossHalfH = Math.round(crossHeight / 2);

		var posx = 0;
		var posy = 0;
		switch(t.getVal(objLayer, 'align_hor')){
			case "left":
				posx = - crossHalfW;
			break;
			case "center":
				posx = (totalWidth - crossWidth) / 2;
			break;
			case "right":
				posx = totalWidth - crossHalfW;
			break;
		}

		switch(t.getVal(objLayer, 'align_vert')){
			case "top":
				posy = - crossHalfH;
			break;
			case "middle":
				posy = (totalHeight - crossHeight) / 2;
			break;
			case "bottom":
				posy = totalHeight - crossHalfH;
			break;
		}

		htmlCross.css({"left":posx+"px","top":posy+"px"});
		
	}


	

	/**
	 * check / update full width video position and size
	 */
	var checkUpdateFullwidthVideo = function(objLayer){
		
		if(objLayer.type != "video") {
			return(objLayer);
		}

		if(typeof (objLayer.video_data) !== "undefined"){
			if(objLayer.video_data && objLayer.video_data.fullwidth && objLayer.video_data.fullwidth == true){

				objLayer = t.setVal(objLayer, 'top', 0);
				objLayer = t.setVal(objLayer, 'left', 0);

				objLayer = t.setVal(objLayer, 'align_hor', 'left', true);
				objLayer = t.setVal(objLayer, 'align_vert', 'top', true);
				objLayer.video_width = container.width();
				objLayer.video_height = container.height();
			}
		}
		return(objLayer);
	}

	/*! UPDATE HTML LAYER */
	/**
	 * update html layers from object
	 */
	var updateHtmlLayersFromObject = function(serial,posresets,isDemo){
				
		if(!serial) serial = t.selectedLayerSerial;

		var objLayer = t.getLayer(serial, isDemo);

		if(!objLayer) return(false);
		
		var htmlLayer = objLayer.references.htmlLayer;

		//set class name
		var className = "innerslide_layer tp-caption";
		if(serial == t.selectedLayerSerial) {
			htmlLayer.addClass("layer_selected");
			htmlLayer.closest('.slide_layer_type_row').addClass('layerchild_selected');
			htmlLayer.closest('.slide_layer_type_column').addClass('layerchild_selected');
		}
		
		className += " "+objLayer.style;
		
		switch(objLayer.type){
			case 'button':
			case 'shape':
				className += ' '+objLayer.internal_class;
			break;
			/*case 'no_edit':
				className += objLayer.internal_class;
			break;*/
		}
		
		htmlLayer[0].getElementsByClassName('innerslide_layer')[0].className = className;


		//set html
		var type = objLayer.type || "text";
		
		//update layer by type:
		switch(type){
			case "image":
			break;
			case "video":	//update fullwidth position
				objLayer = checkUpdateFullwidthVideo(objLayer);
			break;
			case "row":
			break;
			case "group":
			break;
			case "column":
			break;
			default:
			case "text":				
			case "button":						
				htmlLayer[0].getElementsByClassName('innerslide_layer')[0].innerHTML = objLayer.text;
				t.makeCurrentLayerRotatable(serial);
				t.updateHtmlLayerCorners(objLayer);				
			break;
			case "svg":
				objLayer.svg.renderedData = htmlLayer[0].getElementsByClassName('innerslide_layer')[0].innerHTML;
				t.makeCurrentLayerRotatable(serial);
			break;
			case 'audio':				
				//htmlLayer.find('audio').attr('src',objLayer.video_data.urlAudio);
			break;
			/*case 'no_edit':
				
			break;*/
		}					
		
		u.rebuildLayerIdle(getjQueryLayer());
	}
	
	// MAKE THINGS ROTATABLE
	t.makeCurrentLayerRotatable = function(serial) {
		
		if (u.checkLoopTab() || u.checkAnimationTab()) {
			t.removeCurrentLayerRotatable();		
			return false;
		}

		var el = document.getElementsByClassName('slide_layer layer_selected')[0];
		el = el!=undefined ? jQuery(el.getElementsByClassName('innerslide_layer')[0]) : el;
		

		if (el!=undefined && el!==null && el.length>0) {
			try{el.rotatable("destroy");} 
			catch(e) {}
			el.rotatable({
				angle:el.data('angle'),
				start:function(event,ui) {
				},
				rotate:function(event,ui) {
					jQuery('#layer_2d_rotation').val(getRotationDegrees(ui.element));
					ui.element.data('angle',ui.angle.current);
				},
				stop:function(event,ui) {
					t.updateLayerFromFields();
				}
			});		
		}
	}
	
	t.removeCurrentLayerRotatable = function() {
		
		jQuery('.slide_layer .ui-rotatable-handle').each(function() {
			var el = jQuery(this);
			setTimeout(function() {
				try{el.parent().rotatable("destroy");} catch(e) {}
				try{el.remove();} catch(e) {}
				try{el.parent().find('.ui-rotatable-handle').remove();} catch(e) {}
			},50);
		})
	}


	/**
	 THE CHANGE OF POSITION FIELD TRIGGERS THE REPOSITIONINNG OF THE LAYER
	**/
	var positionChanged = function() {
		
		jQuery("#layer_top, #layer_left").change(function() {			
			setTimeout(function() {
				updateHtmlLayersFromObject(t.getSerialFromID(jQuery('.layer_selected').attr('id')),true);
			},19);
		});
	}
	
	
	t.set_cover_mode = function(){
		var objLayer = t.getLayer(t.selectedLayerSerial);
		
		jQuery('#layer_scaleX').prop("disabled",false);
		jQuery('#layer_scaleY').prop("disabled",false);
		jQuery('#layer_max_width').prop("disabled",false);
		jQuery('#layer_max_height').prop("disabled",false);
		
		switch(objLayer.type) {
			case 'shape':
			case 'image':
				switch(jQuery('#layer_cover_mode option:selected').val()){
					case 'custom':
						//already removed disable
					break;
					case 'fullwidth':
						jQuery('#layer_scaleX').attr('disabled', 'disabled');
						jQuery('#layer_max_width').attr('disabled', 'disabled');
					break;
					case 'fullheight':
						jQuery('#layer_scaleY').attr('disabled', 'disabled');
						jQuery('#layer_max_height').attr('disabled', 'disabled');
					break;
					case 'cover':
					case 'cover-proportional':
						jQuery('#layer_scaleX').attr('disabled', 'disabled');
						jQuery('#layer_scaleY').attr('disabled', 'disabled');
						jQuery('#layer_max_width').attr('disabled', 'disabled');
						jQuery('#layer_max_height').attr('disabled', 'disabled');
				}
				break;
			default:
		}
	}
	
	/** 
	* IF ONLY X/Y VALUE CHANGED BASED ON KEY UP'S, SHOULD BE A QUICKER MOVEMENT AVAILABLE
	*/
	t.updateCurrentLayerPosition = function() {		
		var objUpdate = {};
		objUpdate = t.setVal(objUpdate, 'top', Number(parseInt(jQuery("#layer_top").val(),0)));
		objUpdate = t.setVal(objUpdate, 'left', Number(parseInt(jQuery("#layer_left").val(),0)));
		t.updateCurrentLayer(objUpdate);
		u.rebuildLayerIdle(jQuery('.slide_layer.layer_selected'));
	}

	/**
	 * update layer from html fields
	 */

	 t.updateLayerFromFields = function() {
	 	//clearTimeout(t.ulff_core);
	 	//t.ulff_core = setTimeout(function() {
	 		
	 		t.updateLayerFromFields_Core();
	 		
	 	//},350);
	 }

	t.updateLayerFromFields_Core = function(){		
		
		var objUpdate = {};

		// HOOK FOR EXTERNAL ADDONS
		jQuery.each(t.addon_callbacks, function(i,callback_element) {
			var callback = callback_element["callback"],				
				env = callback_element["environment"],
				env_sub = callback_element["function_position"];
			if (env === "updateLayerFromFields_Core" && env_sub=="start") 				
				objUpdate = callback(objUpdate);
			
		});


		if(t.selectedLayerSerial == -1) return(false);		
		UniteCssEditorRev.compare_to_original(); //compare style changes and mark elements depending on state
		

		objUpdate.style = document.getElementById("layer_caption").value;			
		objUpdate['hover'] = document.getElementById("hover_allow").checked;
		objUpdate['force_hover'] = document.getElementById("force_hover").checked;
		objUpdate['toggle'] = document.getElementById("toggle_allow").checked;

		objUpdate['toggle_use_hover'] = document.getElementById("toggle_use_hover").checked;
		objUpdate['toggle_inverse_content'] = document.getElementById("toggle_inverse_content").checked;
		
		
		objUpdate['visible-desktop'] = document.getElementById("visible-desktop").checked;
		objUpdate['visible-notebook'] = document.getElementById("visible-notebook").checked;
		objUpdate['visible-tablet'] = document.getElementById("visible-tablet").checked;
		objUpdate['visible-mobile'] = document.getElementById("visible-mobile").checked;
		
		objUpdate['show-on-hover'] = document.getElementById("layer_on_slider_hover").checked;
		
		objUpdate['lazy-load'] = jQuery("#layer-lazy-loading option:selected").val();
		objUpdate['image-size'] = jQuery("#layer-image-size option:selected").val();
		
		objUpdate['css-position'] = jQuery("#layer-css-position option:selected").val();
		
		objUpdate.text = document.getElementById("layer_text").value;
		objUpdate.texttoggle = document.getElementById("layer_text_toggle").value || "";
		
		objUpdate.alias = jQuery('#layer_sort_'+t.selectedLayerSerial+">.layer_sort_inner_wrapper .timer-layer-text").val();

		// IF NEW CONTENT IS EDITED FIRST TIME, USE THE SAME CONTENT FOR LAYER DESCRIPTION
		if (jQuery('#layer_text').data('new_content'))
			jQuery('#layer_sort_'+t.selectedLayerSerial+">.layer_sort_inner_wrapper .timer-layer-text").val(objUpdate.text);

		
		jQuery('#layer_quicksort_'+t.selectedLayerSerial+" .layer-title-in-list").val(objUpdate.alias);
		jQuery('#the_current-editing-layer-title').val(objUpdate.alias);		
		jQuery('#layer-short-toolbar').data('serial',t.selectedLayerSerial)


		objUpdate = t.setVal(objUpdate, 'top', Number(parseInt(document.getElementById("layer_top").value,0)));
		objUpdate = t.setVal(objUpdate, 'left', Number(parseInt(document.getElementById("layer_left").value,0)));
		
		
		objUpdate = t.setVal(objUpdate, 'whitespace', jQuery("#layer_whitespace option:selected").val());
		objUpdate = t.setVal(objUpdate, 'display', jQuery("#layer_display option:selected").val());
		objUpdate = t.setVal(objUpdate, 'max_height', document.getElementById("layer_max_height").value);
		objUpdate = t.setVal(objUpdate, 'min_height', document.getElementById("layer_min_height").value);
		objUpdate = t.setVal(objUpdate, 'max_width', document.getElementById("layer_max_width").value);
		
		objUpdate = t.setVal(objUpdate, 'video_height', document.getElementById("layer_video_height").value);
		objUpdate = t.setVal(objUpdate, 'video_width', document.getElementById("layer_video_width").value);
		

		objUpdate = t.setVal(objUpdate, 'scaleX', document.getElementById("layer_scaleX").value);
		objUpdate = t.setVal(objUpdate, 'scaleY', document.getElementById("layer_scaleY").value);
		
		objUpdate = t.setVal(objUpdate, 'cover_mode', jQuery("#layer_cover_mode option:selected").val());

		objUpdate['2d_rotation'] =  parseInt(document.getElementById("layer_2d_rotation").value,0);

		objUpdate['2d_origin_x'] =  parseInt(document.getElementById("layer_2d_origin_x").value,0);
		objUpdate['2d_origin_y'] =  parseInt(document.getElementById("layer_2d_origin_y").value,0);
		objUpdate['static_start'] = jQuery("#layer_static_start option:selected").val();
		objUpdate['static_end'] = jQuery("#layer_static_end option:selected").val();
		
		objUpdate.layer_bg_position = jQuery("#layer_bg_position option:selected").val();
		objUpdate.layer_bg_size = jQuery("#layer_bg_size option:selected").val();
		objUpdate.layer_bg_repeat = jQuery("#layer_bg_repeat option:selected").val();
		
		//set Loop Animations
		objUpdate.loop_animation = jQuery("#layer_loop_animation option:selected").val();
		objUpdate.loop_easing = document.getElementById("layer_loop_easing").value;
		objUpdate.loop_speed = document.getElementById("layer_loop_speed").value;
		objUpdate.loop_startdeg =  parseInt(document.getElementById("layer_loop_startdeg").value,0);
		objUpdate.loop_enddeg =  parseInt(document.getElementById("layer_loop_enddeg").value,0);
		objUpdate.loop_xorigin =  parseInt(document.getElementById("layer_loop_xorigin").value,0);
		objUpdate.loop_yorigin =  parseInt(document.getElementById("layer_loop_yorigin").value,0);
		objUpdate.loop_xstart =  parseInt(document.getElementById("layer_loop_xstart").value,0);
		objUpdate.loop_xend =  parseInt(document.getElementById("layer_loop_xend").value,0);
		objUpdate.loop_ystart =  parseInt(document.getElementById("layer_loop_ystart").value,0);
		objUpdate.loop_yend =  parseInt(document.getElementById("layer_loop_yend").value,0);
		objUpdate.loop_zoomstart = document.getElementById("layer_loop_zoomstart").value;
		objUpdate.loop_zoomend = document.getElementById("layer_loop_zoomend").value;
		objUpdate.loop_angle = document.getElementById("layer_loop_angle").value;
		objUpdate.loop_radius = document.getElementById("layer_loop_radius").value;
		
		objUpdate.html_tag = jQuery("#layer_html_tag option:selected").val();
		objUpdate.parallax_layer_ddd_zlevel = jQuery("#parallax_layer_ddd_zlevel option:selected").val();
		
		var layer = t.getHtmlLayerFromSerial(t.selectedLayerSerial);

		if (document.getElementById("layer__scalex").value!=1 || document.getElementById("layer__scaley").value!=1 || parseInt(document.getElementById("layer__skewx").value,0)!=0 || parseInt(document.getElementById("layer__skewy").value,0)!=0 || parseInt(document.getElementById("layer__xrotate").value,0)!=0 || parseInt(document.getElementById("layer__yrotate").value,0)!=0 || parseInt(document.getElementById("layer_2d_rotation").value,0)!=0) {			
				jQuery(document.getElementsByClassName('mask-not-available')[0]).show();
				jQuery(document.getElementsByClassName('mask-is-available')[0]).hide(); 
				document.getElementById('masking-start').removeAttribute("checked");
				document.getElementById('masking-end').removeAttribute("checked");
				jQuery(document.getElementsByClassName('mask-start-settings')[0]).hide();
				jQuery(document.getElementsByClassName('mask-end-settings')[0]).hide();
				jQuery('.tp-showmask').removeClass('tp-showmask');
				RevSliderSettings.onoffStatus(jQuery('#masking-start'));
				RevSliderSettings.onoffStatus(jQuery('#masking-end'));			
				layer.find('.tp-mask-wrap').css({overflow:"visible"});
		} else {
			jQuery(document.getElementsByClassName('mask-not-available')[0]).hide();
			jQuery(document.getElementsByClassName('mask-is-available')[0]).show(); 
		}

		//set Mask Animations
		objUpdate.mask_start = document.getElementById("masking-start").checked;
		objUpdate.mask_end = document.getElementById("masking-end").checked;
		objUpdate.mask_x_start = document.getElementById("mask_anim_xstart").value;
		objUpdate.mask_y_start =  document.getElementById("mask_anim_ystart").value;				
		objUpdate.mask_x_end =  document.getElementById("mask_anim_xend").value;
		objUpdate.mask_y_end = document.getElementById("mask_anim_yend").value;
		
		
		
						
		objUpdate = t.setVal(objUpdate, 'align_hor', document.getElementById("layer_align_hor").value);
		objUpdate = t.setVal(objUpdate, 'align_vert', document.getElementById("layer_align_vert").value);
		
		objUpdate.hiddenunder = document.getElementById("layer_hidden").checked;
		objUpdate.resizeme = document.getElementById("layer_resizeme").checked;
		objUpdate['resize-full'] = document.getElementById("layer_resize-full").checked;

		//objUpdate['seo-optimized'] = jQuery("#layer-seo-optimized")[0].checked;
		
		objUpdate.basealign = document.getElementById("layer_align_base").value;
		objUpdate.responsive_offset = document.getElementById("layer_resp_offset").checked;
		
		objUpdate.frames={};
		objUpdate.frames.frame_0 = {};
		objUpdate.frames.frame_999 = {};
		
		objUpdate.frames["frame_0"].animation = jQuery("#layer_animation option:selected").val();
		objUpdate.frames["frame_0"].speed = document.getElementById("layer_speed").value;
		objUpdate.frames["frame_0"].easing = document.getElementById("layer_easing").value;
		objUpdate.frames["frame_0"].split = document.getElementById("layer_split").value;
		objUpdate.frames["frame_0"].splitdelay = document.getElementById("layer_splitdelay").value;
		
		objUpdate.frames["frame_999"].split = document.getElementById("layer_endsplit").value;		
		objUpdate.frames["frame_999"].splitdelay = document.getElementById("layer_endsplitdelay").value;
		objUpdate.frames["frame_999"].animation = document.getElementById("layer_endanimation").value;
		objUpdate.frames["frame_999"].speed = document.getElementById("layer_endspeed").value;
		objUpdate.frames["frame_999"].easing = document.getElementById("layer_endeasing").value;
		
		objUpdate.alt_option = jQuery("#layer_alt_option option:selected").val();
		objUpdate.alt = document.getElementById("layer_alt").value;
		objUpdate = t.setVal(objUpdate, 'scaleX', jQuery("#layer_scaleX").val());
		objUpdate = t.setVal(objUpdate, 'scaleY', jQuery("#layer_scaleY").val());

		objUpdate.x_start =  document.getElementById("layer_anim_xstart").value;
		objUpdate.y_start =  document.getElementById("layer_anim_ystart").value;
		objUpdate.z_start =  document.getElementById("layer_anim_zstart").value;
		objUpdate.x_end =  document.getElementById("layer_anim_xend").value;
		objUpdate.y_end =  document.getElementById("layer_anim_yend").value;
		objUpdate.z_end =  document.getElementById("layer_anim_zend").value;
		objUpdate.opacity_start = document.getElementById("layer_opacity_start").value;
		objUpdate.opacity_end = document.getElementById("layer_opacity_end").value;
		objUpdate.x_rotate_start =  document.getElementById("layer_anim_xrotate").value;
		objUpdate.y_rotate_start =  document.getElementById("layer_anim_yrotate").value;
		objUpdate.z_rotate_start =  document.getElementById("layer_anim_zrotate").value;
		objUpdate.x_rotate_end =  document.getElementById("layer_anim_xrotate_end").value;
		objUpdate.y_rotate_end =  document.getElementById("layer_anim_yrotate_end").value;
		objUpdate.z_rotate_end =  document.getElementById("layer_anim_zrotate_end").value;
		objUpdate.scale_x_start = document.getElementById("layer_scale_xstart").value;
		objUpdate.scale_y_start = document.getElementById("layer_scale_ystart").value;
		objUpdate.scale_x_end = document.getElementById("layer_scale_xend").value;
		objUpdate.scale_y_end = document.getElementById("layer_scale_yend").value;
		objUpdate.skew_x_start = document.getElementById("layer_skew_xstart").value;
		objUpdate.skew_y_start = document.getElementById("layer_skew_ystart").value;
		objUpdate.skew_x_end = document.getElementById("layer_skew_xend").value;
		objUpdate.skew_y_end = document.getElementById("layer_skew_yend").value;
		
		objUpdate.x_start_reverse =  document.getElementById('layer_anim_xstart_reverse').checked || false;
		objUpdate.y_start_reverse =  document.getElementById('layer_anim_ystart_reverse').checked || false;
		objUpdate.x_end_reverse =  document.getElementById('layer_anim_xend_reverse').checked || false;
		objUpdate.y_end_reverse =  document.getElementById('layer_anim_yend_reverse').checked || false;
		objUpdate.x_rotate_start_reverse =  document.getElementById('layer_anim_xrotate_reverse').checked || false;
		objUpdate.y_rotate_start_reverse =  document.getElementById('layer_anim_yrotate_reverse').checked || false;
		objUpdate.z_rotate_start_reverse =  document.getElementById('layer_anim_zrotate_reverse').checked || false;
		objUpdate.x_rotate_end_reverse =  document.getElementById('layer_anim_xrotate_end_reverse').checked || false;
		objUpdate.y_rotate_end_reverse =  document.getElementById('layer_anim_yrotate_end_reverse').checked || false;
		objUpdate.z_rotate_end_reverse =  document.getElementById('layer_anim_zrotate_end_reverse').checked || false;
		objUpdate.scale_x_start_reverse = document.getElementById('layer_scale_xstart_reverse').checked || false;
		objUpdate.scale_y_start_reverse = document.getElementById('layer_scale_ystart_reverse').checked || false;
		objUpdate.scale_x_end_reverse = document.getElementById('layer_scale_xend_reverse').checked || false;
		objUpdate.scale_y_end_reverse = document.getElementById('layer_scale_yend_reverse').checked || false;
		objUpdate.skew_x_start_reverse = document.getElementById('layer_skew_xstart_reverse').checked || false;
		objUpdate.skew_y_start_reverse = document.getElementById('layer_skew_ystart_reverse').checked || false;
		objUpdate.skew_x_end_reverse = document.getElementById('layer_skew_xend_reverse').checked || false;
		objUpdate.skew_y_end_reverse = document.getElementById('layer_skew_yend_reverse').checked || false;
		objUpdate.mask_x_start_reverse = document.getElementById('mask_anim_xstart_reverse').checked || false;
		objUpdate.mask_y_start_reverse =  document.getElementById('mask_anim_ystart_reverse').checked || false;
		objUpdate.mask_x_end_reverse =  document.getElementById('mask_anim_xend_reverse').checked || false;
		objUpdate.mask_y_end_reverse =  document.getElementById('mask_anim_yend_reverse').checked || false;
		
		
		objUpdate.autolinebreak = jQuery("#layer_auto_line_break")[0].checked;

		objUpdate.displaymode = jQuery('#layer_displaymode')[0].checked;

		
		objUpdate.scaleProportional = jQuery("#layer_proportional_scale")[0].checked;
				
		objUpdate.attrID = document.getElementById("layer_id").value;
		objUpdate.attrWrapperID = document.getElementById("layer_wrapper_id").value;
		objUpdate.attrClasses = document.getElementById("layer_classes").value;
		objUpdate.attrWrapperClasses = document.getElementById("layer_wrapper_classes").value;
		objUpdate.attrTitle = document.getElementById("layer_title").value;
		objUpdate.attrRel = document.getElementById("layer_rel").value;
		//objUpdate.link = document.getElementById("layer_image_link").value;
		//objUpdate.link_open_in = document.getElementById("layer_link_open_in").value;
		//objUpdate.link_id = document.getElementById("layer_link_id").value;
		//objUpdate.link_class = document.getElementById("layer_link_class").value;
		//objUpdate.link_title = document.getElementById("layer_link_title").value;
		//objUpdate.link_rel = document.getElementById("layer_link_rel").value;

		

		objUpdate = t.setVal(objUpdate, 'scaleY', jQuery("#layer_scaleY").val());


		jQuery('#clayer_start_speed').val(objUpdate.speed);
		jQuery('#clayer_end_speed').val(objUpdate.endspeed);
		
		
		
		// CHECK IF THE INPUT FIELD NEED TO BE UPDATED FOR ALL DEVICE SIZES
		var set_all_color = lastchangedinput == "layer_color_s",
			set_all_color_force = jQuery('#on_all_devices_color').attr("checked")=="checked" || false,
			set_all_fontsize = lastchangedinput == "layer_font_size_s",
			set_all_fontsize_force =  jQuery('#on_all_devices_fontsize').attr("checked")=="checked" || false,
			set_all_fontweight = lastchangedinput == "layer_font_weight_s",
			set_all_fontweight_force = jQuery('#on_all_devices_fontweight').attr("checked")=="checked" || false,
			set_all_lineheight = lastchangedinput == "layer_line_height_s",
			set_all_lineheight_force = jQuery('#on_all_devices_lineheight').attr("checked")=="checked" || false;

		if(objUpdate['static_styles'] == undefined) objUpdate['static_styles'] = {};
		objUpdate['static_styles'] = t.setVal(objUpdate['static_styles'], 'font-size', jQuery("#layer_font_size_s").val(),set_all_fontsize,null,set_all_fontsize_force);
		objUpdate['static_styles'] = t.setVal(objUpdate['static_styles'], 'line-height', jQuery("#layer_line_height_s").val(),set_all_lineheight,null,set_all_lineheight_force);
		objUpdate['static_styles'] = t.setVal(objUpdate['static_styles'], 'font-weight', jQuery("#layer_font_weight_s option:selected").val(),set_all_fontweight,null,set_all_fontweight_force);
		objUpdate['static_styles'] = t.setVal(objUpdate['static_styles'], 'color', jQuery("#layer_color_s").val(),set_all_color,null,set_all_color_force);
		
		//deformation part
		if(objUpdate.deformation == undefined) objUpdate.deformation = {};
		//if (objUpdate["deformation"]["padding"] == undefined) objUpdate["deformation"]["padding"]=["0","0","0","0"];
		
		if (objUpdate["deformation"]["border-radius"] == undefined) objUpdate["deformation"]["border-radius"]=["0","0","0","0"];



		
		
		
		
		

		objUpdate['layer-selectable'] = jQuery('#css_layer_selectable option:selected').val();
		
		//objUpdate = updateSubStyleParameters(objUpdate);
		objUpdate['deformation']['color-transparency'] =  document.getElementById('css_font-transparency').value;
		objUpdate['deformation']['font-style'] = (jQuery('#css_font-style')[0].checked) ? 'italic' : 'normal';
		objUpdate['deformation']['font-family'] =  document.getElementById('css_font-family').value;
		
		
		//jQuery('input[name="css_padding[]"]').each(function(i){ objUpdate['deformation']['padding'][i] = jQuery(this).val();});
		var cur_pad = [];
		jQuery('input[name="css_padding[]"]').each(function(i){
			cur_pad.push(jQuery(this).val());
		});			
		objUpdate = t.setVal(objUpdate, 'padding', cur_pad, true);
		
		var cur_mar = [];
		jQuery('input[name="css_margin[]"]').each(function(i){
			cur_mar.push(jQuery(this).val());
		});			
		objUpdate = t.setVal(objUpdate, 'margin', cur_mar, true);
		
		objUpdate = t.setVal(objUpdate, 'text-align', jQuery('#css_text-align option:selected').val());


		//objUpdate['deformation']['text-align'] = jQuery('#css_text-align option:selected').val();
		
		objUpdate['deformation']['text-decoration'] = jQuery('#css_text-decoration option:selected').val();
		objUpdate['deformation']['overflow'] = jQuery('#css_overflow option:selected').val();
		objUpdate['column_break_at'] = jQuery('#column_break_at option:selected').val();
		objUpdate['deformation']['vertical-align'] = jQuery('#css_vertical-align option:selected').val();
		
		objUpdate['deformation']['text-transform'] = jQuery('#css_text-transform option:selected').val();
		objUpdate['deformation']['background-color'] =  document.getElementById('css_background-color').value;
		objUpdate['deformation']['background-transparency'] =  document.getElementById('css_background-transparency').value;
		objUpdate['deformation']['border-color'] =  document.getElementById('css_border-color-show').value;
		objUpdate['deformation']['border-transparency'] =  document.getElementById('css_border-transparency').value;
		objUpdate['deformation']['border-style'] = jQuery('#css_border-style option:selected').val();
		//objUpdate['deformation']['border-width'] =  document.getElementById('css_border-width').value;
		if(objUpdate.deformation['border-width'] == undefined) objUpdate.deformation['border-width'] = new Array();	
		jQuery('input[name="css_border-width[]"]').each(function(i){ objUpdate['deformation']['border-width'][i] = jQuery(this).val();});
		
		if(objUpdate.deformation['border-radius'] == undefined) objUpdate.deformation['border-radius'] = new Array();		
		jQuery('input[name="css_border-radius[]"]').each(function(i){ objUpdate['deformation']['border-radius'][i] = jQuery(this).val();});

		objUpdate['layer_blend_mode'] = jQuery('#layer_blend_mode option:selected').val();

		
		objUpdate['deformation']['x'] = 0; //parseInt(jQuery('input[name="layer__x"]').val(),0);
		objUpdate['deformation']['y'] = 0; //parseInt(jQuery('input[name="layer__y"]').val(),0);
		objUpdate['deformation']['z'] = parseInt( document.getElementById('layer__z').value,0);
		objUpdate['deformation']['skewx'] =  document.getElementById('layer__skewx').value;
		objUpdate['deformation']['skewy'] =  document.getElementById('layer__skewy').value;
		objUpdate['deformation']['scalex'] =  document.getElementById('layer__scalex').value;
		objUpdate['deformation']['scaley'] =  document.getElementById('layer__scaley').value;
		objUpdate['deformation']['opacity'] =  document.getElementById('layer__opacity').value;
		objUpdate['deformation']['xrotate'] = parseInt( document.getElementById('layer__xrotate').value,0);
		objUpdate['deformation']['yrotate'] = parseInt( document.getElementById('layer__yrotate').value,0);
		objUpdate['2d_rotation'] = parseInt( document.getElementById('layer_2d_rotation').value,0);
		objUpdate['deformation']['2d_origin_x'] =  document.getElementById('layer_2d_origin_x').value;
		objUpdate['deformation']['2d_origin_y'] =  document.getElementById('layer_2d_origin_y').value;
		objUpdate['deformation']['pers'] =  document.getElementById('layer__pers').value;
		objUpdate['deformation']['corner_left'] = jQuery('#layer_cornerleft option:selected').val();
		objUpdate['deformation']['corner_right'] = jQuery('#layer_cornerright option:selected').val();
		objUpdate['deformation']['parallax'] = jQuery('#parallax_level option:selected').val();
		
		//deformation hover part start
		if(objUpdate['deformation-hover'] == undefined || jQuery.isEmptyObject(objUpdate['deformation-hover'])) objUpdate['deformation-hover'] = {};		
		objUpdate['deformation-hover']['color'] = document.getElementById('hover_layer_color_s').value;
		objUpdate['deformation-hover']['color-transparency'] = document.getElementById('hover_css_font-transparency').value;
		objUpdate['deformation-hover']['text-decoration'] = jQuery('#hover_css_text-decoration option:selected').val();
		objUpdate['deformation-hover']['background-color'] = document.getElementById('hover_css_background-color').value;
		objUpdate['deformation-hover']['background-transparency'] = document.getElementById('hover_css_background-transparency').value;
		


		objUpdate['deformation-hover']['border-color'] = document.getElementById('hover_css_border-color-show').value;
		objUpdate['deformation-hover']['border-transparency'] = document.getElementById('hover_css_border-transparency').value;
		objUpdate['deformation-hover']['border-style'] = jQuery('#hover_css_border-style option:selected').val();
		//objUpdate['deformation-hover']['border-width'] = document.getElementById('hover_css_border-width').value;
		if(objUpdate['deformation-hover']['border-width'] == undefined) objUpdate['deformation-hover']['border-width'] = new Array();
		jQuery('input[name="hover_css_border-width[]"]').each(function(i){ objUpdate['deformation-hover']['border-width'][i] = jQuery(this).val(); });
		if(objUpdate['deformation-hover']['border-radius'] == undefined) objUpdate['deformation-hover']['border-radius'] = new Array();
		jQuery('input[name="hover_css_border-radius[]"]').each(function(i){ objUpdate['deformation-hover']['border-radius'][i] = jQuery(this).val(); });
		objUpdate['deformation-hover']['skewx'] = document.getElementById('hover_layer__skewx').value;
		objUpdate['deformation-hover']['skewy'] = document.getElementById('hover_layer__skewy').value;
		objUpdate['deformation-hover']['scalex'] = document.getElementById('hover_layer__scalex').value;
		objUpdate['deformation-hover']['scaley'] = document.getElementById('hover_layer__scaley').value;
		objUpdate['deformation-hover']['opacity'] = document.getElementById('hover_layer__opacity').value;
		objUpdate['deformation-hover']['xrotate'] = parseInt(document.getElementById('hover_layer__xrotate').value,0);
		objUpdate['deformation-hover']['yrotate'] = parseInt(document.getElementById('hover_layer__yrotate').value,0);
		objUpdate['deformation-hover']['2d_rotation'] = parseInt(document.getElementById('hover_layer_2d_rotation').value,0); //z rotate
		
		objUpdate['deformation-hover']['speed'] = document.getElementById('hover_speed').value;
		objUpdate['deformation-hover']['zindex'] = document.getElementById('hover_zindex').value;
		objUpdate['deformation-hover']['easing'] = jQuery('#hover_easing option:selected').val();
		objUpdate['deformation-hover']['css_cursor'] = jQuery('#css_cursor option:selected').val();
		
		// READ SVG BASED CONTENT
		if (objUpdate['svg']==undefined) objUpdate['svg']={};
		objUpdate['svg']['svgstroke-color'] = document.getElementById('css_svgstroke-color-show').value;
		objUpdate['svg']['svgstroke-transparency'] = document.getElementById('css_svgstroke-transparency').value;
		objUpdate['svg']['svgstroke-dasharray'] = document.getElementById('css_svgstroke-dasharray').value;
		objUpdate['svg']['svgstroke-dashoffset'] = document.getElementById('css_svgstroke-dashoffset').value;
		objUpdate['svg']['svgstroke-width'] = document.getElementById('css_svgstroke-width').value;
		objUpdate['svg']['svgstroke-hover-color'] = document.getElementById('css_svgstroke-hover-color-show').value;
		objUpdate['svg']['svgstroke-hover-transparency'] = document.getElementById('css_svgstroke-hover-transparency').value;
		objUpdate['svg']['svgstroke-hover-dasharray'] = document.getElementById('css_svgstroke-hover-dasharray').value;
		objUpdate['svg']['svgstroke-hover-dashoffset'] = document.getElementById('css_svgstroke-hover-dashoffset').value;
		objUpdate['svg']['svgstroke-hover-width'] = document.getElementById('css_svgstroke-hover-width').value;

		

		//deformation hover part end				
		if(objUpdate['layer_action'] == undefined || jQuery.isEmptyObject(objUpdate['layer_action'])) objUpdate['layer_action'] = {};
		
		objUpdate['layer_action'].tooltip_event = [];
		jQuery('select[name="layer_tooltip_event[]"] option:selected').each(function(){
			objUpdate['layer_action'].tooltip_event.push(jQuery(this).val());
		});
		
		objUpdate['layer_action'].action = [];
		jQuery('select[name="layer_action[]"] option:selected').each(function(){
			objUpdate['layer_action'].action.push(jQuery(this).val());
		});
		
		objUpdate['layer_action'].image_link = [];
		jQuery('input[name="layer_image_link[]"]').each(function(){
			objUpdate['layer_action'].image_link.push(jQuery(this).val());
		});
		
		objUpdate['layer_action'].link_open_in = [];
		jQuery('select[name="layer_link_open_in[]"] option:selected').each(function(){
			objUpdate['layer_action'].link_open_in.push(jQuery(this).val());
		});
		
		objUpdate['layer_action'].jump_to_slide = [];
		jQuery('select[name="jump_to_slide[]"] option:selected').each(function(){
			objUpdate['layer_action'].jump_to_slide.push(jQuery(this).val());
		});
		
		objUpdate['layer_action'].scrollunder_offset = [];
		jQuery('input[name="layer_scrolloffset[]"]').each(function(){
			objUpdate['layer_action'].scrollunder_offset.push(jQuery(this).val());
		});
		
		objUpdate['layer_action'].actioncallback = [];
		jQuery('input[name="layer_actioncallback[]"]').each(function(){
			objUpdate['layer_action'].actioncallback.push(jQuery(this).val());
		});
		
		objUpdate['layer_action'].layer_target = [];
		jQuery('select[name="layer_target[]"] option:selected').each(function(){			
			objUpdate['layer_action'].layer_target.push(jQuery(this).val());
		});
		
		objUpdate['layer_action'].link_type = [];
		jQuery('select[name="layer_link_type[]"] option:selected').each(function(){
			objUpdate['layer_action'].link_type.push(jQuery(this).val());
		});
		
		objUpdate['layer_action'].action_delay = [];
		jQuery('input[name="layer_action_delay[]"]').each(function(){
			objUpdate['layer_action'].action_delay.push(jQuery(this).val());
		});
		
		objUpdate['layer_action'].toggle_layer_type = [];
		jQuery('select[name="toggle_layer_type[]"] option:selected').each(function(){
			objUpdate['layer_action'].toggle_layer_type.push(jQuery(this).val());
		});
		
		objUpdate['layer_action'].toggle_class = [];
		jQuery('input[name="layer_toggleclass[]"]').each(function(){
			objUpdate['layer_action'].toggle_class.push(jQuery(this).val());
		});
		
		objUpdate.animation_overwrite = jQuery('#layer-animation-overwrite option:selected').val();
		objUpdate.trigger_memory = jQuery('#layer-tigger-memory option:selected').val();


				
		// HOOK FOR EXTERNAL ADDONS
		jQuery.each(t.addon_callbacks, function(i,callback_element) {
			var callback = callback_element["callback"],				
				env = callback_element["environment"],
				env_sub = callback_element["function_position"];
			if (env === "updateLayerFromFields_Core" && env_sub=="end"){
				objUpdate = callback(objUpdate);
			}
			
		});
		
		//update object - Write back changes in ObjArray
		t.updateCurrentLayer(objUpdate, ['layer_action']);	
		t.showHideToggleContent(objUpdate);			

		//update html layers
		updateHtmlLayersFromObject();
		
		//update html sortbox
		updateHtmlSortboxFromObject();
		
		//event on element for href
		initDisallowCaptionsOnClick();

		//var type = objLayer.type || "text";
		
		u.rebuildLayerIdle(layer);

		t.set_cover_mode();

		

		//t.add_layer_change();

	}



	/**
	 *
	 * update sortbox text from object
	 */
	var updateHtmlSortboxFromObject = function(serial){


		serial = serial!=undefined ? serial : t.selectedLayerSerial;

		var objLayer = t.getLayer(serial),
			htmlSortItem = u.getHtmlSortItemFromSerial(serial);

		
		if(!objLayer || !htmlSortItem) return(false);
				
		var sortboxText = u.getSortboxText(objLayer.alias);
		
		htmlSortItem.find(">.layer_sort_inner_wrapper .timer-layer-text").text(sortboxText);

	}

	/**
	 *
	 * redraw all Layer HTML 
	 *
	 */
	var redrawAllLayerHtml = function() {
		
		jQuery.each(t.arrLayers,function(i,obj) {
			redrawLayerHtml(obj.serial);
		});
		jQuery.each(t.arrLayersDemo,function(i,obj) {
			redrawLayerHtml(obj.serial, true);
		});
		jQuery('.slide_layer').each(function() {
			u.rebuildLayerIdle(jQuery(this));
		});
		t.updateLayerFormFields(t.selectedLayerSerial);
		
	}


	/**
	 * redraw some layer html
	 */
	var redrawLayerHtml = function(serial, isDemo){		
		if(isDemo == undefined) isDemo = false;
		
		var objLayer = t.getLayer(serial, isDemo),
			html = t.makeLayerHtml(serial,objLayer, isDemo);
		
		if (objLayer.type!="group" && objLayer.type!="row" && objLayer.type!="column") {
			var htmlInner = jQuery(html).html();
			
			objLayer.references.htmlLayer.html(htmlInner);
		}	
		
	}

	/**
	 * check if there is value in the object, and it is defined
	 */
	var nix = function(a) {
		return (a===undefined || a.length==0);
	}


	/**
	 * Reset Fields of Styling based on current selected Template
	 */
	var updateSubStyleParameters = function(objLayer, reset_full) {
		
		var reset = (typeof(reset_full) !== 'undefined' && reset_full === true) ? true : false;
		
		var fullstyles = UniteCssEditorRev.getStyleSettingsByHandle(objLayer["style"]);
		
		var styles = fullstyles.params,
			svgstyles = UniteCssEditorRev.getStyleSettingsByHandle(objLayer["svg"]);
		var hover_styles = fullstyles.hover;
		if(hover_styles == undefined) hover_styles = {};
		
		var is_hover = false;
		
		try{
			is_hover = fullstyles!==undefined ? fullstyles.hasOwnProperty('settings') ? (typeof(fullstyles.settings) !== 'undefined' && typeof(fullstyles.settings.hover) !== undefined) ? fullstyles.settings.hover : false : false : false;
		} catch(e) { 
		}
		
		// INSERT STANDART SETTINGS FROM TEMPLATE STYLE
		if(objLayer.deformation != undefined && styles !== undefined){
			// COLOR TRANSPARENCY
			if(nix(objLayer['deformation']['color-transparency']) || reset)
				objLayer['deformation']['color-transparency'] = !nix(styles["color-transparency"]) ? styles["color-transparency"] : "1";
			
			// FONT STYLE
			if(nix(objLayer['deformation']['font-style']) || reset)
				objLayer['deformation']['font-style'] = !nix(styles["font-style"]) ? styles["font-style"] : "normal";

			// FONT FAMILY
			if(nix(objLayer['deformation']['font-family']) || reset)
				objLayer['deformation']['font-family'] = !nix(styles["font-family"]) ? styles["font-family"] : "Arial"


			// PADDING SETTINGS
			/*if (nix(objLayer['deformation']['padding']) || (nix(objLayer['deformation']['padding'][0]) && nix(objLayer['deformation']['padding'][1]) &&  nix(objLayer['deformation']['padding'][2]) &&  nix(objLayer['deformation']['padding'][3])) || reset) {
				
				var pads = !nix(styles['padding']) ? typeof(styles['padding']) !== 'object' ? styles['padding'].split(" ") : styles['padding'] : ["0px","0px","0px","0px"];											
				objLayer['deformation']['padding'] = ["0","0","0","0"];

				jQuery(objLayer['deformation']['padding']).each(function(i){
					objLayer['deformation']['padding'][i] = pads.length<2 ? pads[0] : pads.length<4 ? i==0 || i==2 ? pads[0] : pads[1] : pads[i];									
				});
			}*/
			
			if(nix(objLayer['padding']) || reset){
				if(!nix(styles["padding"])){
					if((typeof styles["padding"] === "object") && (styles["padding"] !== null)){
						objLayer = t.setVal(objLayer, 'padding', styles["padding"], true);
					}else{
						objLayer = t.setVal(objLayer, 'padding', styles["padding"].split(' '), true);
					}
				}else{
					if(objLayer['padding'] == undefined){
						objLayer['padding'] = {};
						var cur_pad = [];
						jQuery('input[name="css_padding[]"]').each(function(){
							cur_pad.push(0);
						});			
						objLayer = t.setVal(objLayer, 'padding', cur_pad, true);
					}else{
						if(typeof(objLayer['padding']) !== 'object'){
							objLayer = t.setVal(objLayer, 'padding', objLayer['padding'], true);
						}
					}
				}
			}
			
			if(nix(objLayer['margin']) || reset){
				if(!nix(styles["margin"])){
					if((typeof styles["margin"] === "object") && (styles["margin"] !== null)){
						objLayer = t.setVal(objLayer, 'margin', styles["margin"], true);
					}else{
						objLayer = t.setVal(objLayer, 'margin', styles['margin'].split(' '), true);
					}
				}else{
					if(objLayer['margin'] == undefined){
						objLayer['margin'] = {};
						var cur_pad = [];
						jQuery('input[name="css_margin[]"]').each(function(){
							cur_pad.push(0);
						});			
						objLayer = t.setVal(objLayer, 'margin', cur_pad, true);
					}else{
						if(typeof(objLayer['margin']) !== 'object'){
							objLayer = t.setVal(objLayer, 'margin', objLayer['margin'], true);
						}
					}
				}
			}


			// TEXT ALIGNMENT
			/*if (nix(objLayer['deformation']['text-align']) || reset)
				objLayer['deformation']['text-align'] = !nix(styles["text-align"]) ? styles["text-align"] : "inherit";*/
			
			if(nix(objLayer['text-align']) || reset){
				if(!nix(styles["text-align"])){
					if((typeof styles["text-align"] === "object") && (styles["text-align"] !== null)){
						objLayer['text-align'] = styles["text-align"];
					}else{
						objLayer = t.setVal(objLayer, 'text-align', styles['text-align'], true);
					}
				}else{
					if(objLayer['text-align'] == undefined){
						objLayer['text-align'] = {};
						var cur_pad = [];
						jQuery('input[name="css_text-align[]"]').each(function(){
							cur_pad.push(0);
						});			
						objLayer = t.setVal(objLayer, 'text-align', cur_pad, true);
					}else{
						if(typeof(objLayer['text-align']) !== 'object'){
							objLayer = t.setVal(objLayer, 'text-align', objLayer['text-align'], true);
						}
					}
				}
			}
			
			// TEXT DECORATION
			if (nix(objLayer['deformation']['text-decoration']) || reset)
				objLayer['deformation']['text-decoration'] = !nix(styles["text-decoration"]) ? styles["text-decoration"] : "none";
				
			
				
			//  DISPLAY
			if (nix(objLayer['deformation']['display']) || reset)
				objLayer['deformation']['display'] = !nix(styles["display"]) ? styles["display"] : "block";
			

			// BACKGROUND COLOR
			if (nix(objLayer['deformation']['background-color']) || reset) {
				var hex = !nix(styles['background-color']) ? UniteAdminRev.rgb2hex(styles['background-color']) : "transparent",
					transparency = !nix(styles['background-color']) ? UniteAdminRev.getTransparencyFromRgba(styles['background-color']) : 1;
				transparency = transparency==undefined || transparency == false || transparency == "false" ? 1 : transparency;	
				
				if(!nix(styles['background-transparency'])) transparency = styles['background-transparency'];
				
				objLayer['deformation']['background-color'] = hex;
				objLayer['deformation']['background-transparency'] = transparency;
			}

			// BORDER COLOR
			if (nix(objLayer['deformation']['border-color']) || reset)
				objLayer['deformation']['border-color'] = !nix(styles['border-color']) ? UniteAdminRev.rgb2hex(styles['border-color']) : "transparent";
			
			// BORDER TRANSPARENCY
			if(nix(objLayer['deformation']['border-transparency']) || reset)
				objLayer['deformation']['border-transparency'] = !nix(styles["border-transparency"]) ? styles["border-transparency"] : "1";
			
			// BORDER STYLE
			if (nix(objLayer['deformation']['border-style']) || reset)
				objLayer['deformation']['border-style'] = !nix(styles['border-style']) ? styles['border-style'] : "none";
				
			// BORDER WIDTH
			//if (nix(objLayer['deformation']['border-width']) || reset)
			//	objLayer['deformation']['border-width'] = !nix(styles['border-width']) ? styles['border-width'] : "0";
			
			if (nix(objLayer['deformation']['border-width']) || (nix(objLayer['deformation']['border-width'][0]) && nix(objLayer['deformation']['border-width'][1]) && nix(objLayer['deformation']['border-width'][2]) && nix(objLayer['deformation']['border-width'][3])) || reset) {

				var cor = !nix(styles['border-width']) ? typeof(styles['border-width']) !== 'object' ? styles['border-width'].split(" ") : styles['border-width'] : ["0px","0px","0px","0px"];											
				objLayer['deformation']['border-width'] = ["0","0","0","0"];

				jQuery(objLayer['deformation']['border-width']).each(function(i){
					objLayer['deformation']['border-width'][i] = cor.length<2 ? cor[0] : cor.length<4 ? i==0 || i==2 ? cor[0] : cor[1] : cor[i];									
				});
			}
				
			// BORDER RADIUS
			if (nix(objLayer['deformation']['border-radius']) || (nix(objLayer['deformation']['border-radius'][0]) && nix(objLayer['deformation']['border-radius'][1]) && nix(objLayer['deformation']['border-radius'][2]) && nix(objLayer['deformation']['border-radius'][3])) || reset) {

				var cor = !nix(styles['border-radius']) ? typeof(styles['border-radius']) !== 'object' ? styles['border-radius'].split(" ") : styles['border-radius'] : ["0px","0px","0px","0px"];											
				objLayer['deformation']['border-radius'] = ["0","0","0","0"];

				jQuery(objLayer['deformation']['border-radius']).each(function(i){
					objLayer['deformation']['border-radius'][i] = cor.length<2 ? cor[0] : cor.length<4 ? i==0 || i==2 ? cor[0] : cor[1] : cor[i];									
				});
			}
			
			// CORNER LEFT
			if (nix(objLayer['deformation']['corner_left']) || reset)
				objLayer['deformation']['corner_left'] = !nix(styles['corner_left']) ? styles['corner_left'] : "nothing";
			
			// CORNER RIGHT
			if (nix(objLayer['deformation']['corner_right']) || reset)
				objLayer['deformation']['corner_right'] = !nix(styles['corner_right']) ? styles['corner_right'] : "nothing";
			
			// PARALLAX
			if (nix(objLayer['deformation']['parallax']) || reset)
				objLayer['deformation']['parallax'] = !nix(styles['parallax']) ? styles['parallax'] : "-";
			
			if (nix(objLayer['deformation']['x']) || reset) objLayer['deformation']['x'] = !nix(styles['x']) ? styles['x'] : 0;
			if (nix(objLayer['deformation']['y']) || reset) objLayer['deformation']['y'] = !nix(styles['y']) ? styles['y'] : 0;
			if (nix(objLayer['deformation']['z']) || reset) objLayer['deformation']['z'] = !nix(styles['z']) ? styles['z'] : 0;
			if (nix(objLayer['deformation']['skewx']) || reset) objLayer['deformation']['skewx'] = !nix(styles['skewx']) ? styles['skewx'] : 0;
			if (nix(objLayer['deformation']['skewy']) || reset) objLayer['deformation']['skewy'] = !nix(styles['skewy']) ? styles['skewy'] : 0;
			if (nix(objLayer['deformation']['scalex']) || reset) objLayer['deformation']['scalex'] = !nix(styles['scalex']) ? styles['scalex'] : 1;
			if (nix(objLayer['deformation']['scaley']) || reset) objLayer['deformation']['scaley'] = !nix(styles['scaley']) ? styles['scaley'] : 1;
			if (nix(objLayer['deformation']['opacity']) || reset) objLayer['deformation']['opacity'] = !nix(styles['opacity']) ? styles['opacity'] : 1;
			if (nix(objLayer['deformation']['xrotate']) || reset) objLayer['deformation']['xrotate'] = !nix(styles['xrotate']) ? styles['xrotate'] : 0;
			if (nix(objLayer['deformation']['yrotate']) || reset) objLayer['deformation']['yrotate'] = !nix(styles['yrotate']) ? styles['yrotate'] : 0;
			if (nix(objLayer['2d_rotation']) || reset) objLayer['2d_rotation'] =  !nix(styles['2d_rotation']) ? styles['2d_rotation'] : 0;
			if (nix(objLayer['deformation']['2d_origin_x']) || reset) objLayer['deformation']['2d_origin_x'] = !nix(styles['2d_origin_x']) ? styles['2d_origin_x'] : 50;
			if (nix(objLayer['deformation']['2d_origin_y']) || reset) objLayer['deformation']['2d_origin_y'] = !nix(styles['2d_origin_y']) ? styles['2d_origin_y'] : 50;
			if (nix(objLayer['deformation']['pers']) || reset) objLayer['deformation']['pers'] = !nix(styles['pers']) ? styles['pers'] : 600;
			
			
		}

		if (objLayer['svg']!=undefined && svgstyles!=undefined) {
			// SVG STROKE COLOR
			if (nix(objLayer['svg']['svgstroke-color']) || reset)
				objLayer['svg']['svgstroke-color'] = !nix(svgstyles['svgstroke-color']) ? UniteAdminRev.rgb2hex(svgstyles['svgstroke-color']) : "transparent";
			
			// SVG STROKE TRANSPARENCY
			if(nix(objLayer['svg']['svgstroke-transparency']) || reset)
				objLayer['svg']['svgstroke-transparency'] = !nix(svgstyles["svgstroke-transparency"]) ? svgstyles["svgstroke-transparency"] : "1";
			
			// SVG STROKE DASH ARRAY
			if (nix(objLayer['svg']['svgstroke-dasharray']) || reset)
				objLayer['svg']['svgstroke-dasharray'] = !nix(svgstyles['svgstroke-dasharray']) ? svgstyles['svgstroke-dasharray'] : "0";

			// SVG STROKE DASH OFFSET
			if (nix(objLayer['svg']['svgstroke-dashoffset']) || reset)
				objLayer['svg']['svgstroke-dashoffset'] = !nix(svgstyles['svgstroke-dashoffset']) ? svgstyles['svgstroke-dashoffset'] : "0";
				
			// SVG STROKE WIDTH
			if (nix(objLayer['svg']['svgstroke-width']) || reset)
				objLayer['svg']['svgstroke-width'] = !nix(svgstyles['svgstroke-width']) ? svgstyles['svgstroke-width'] : "0";

			// SVG STROKE COLOR
			if (nix(objLayer['svg']['svgstroke-hover-color']) || reset)
				objLayer['svg']['svgstroke-hover-color'] = !nix(svgstyles['svgstroke-hover-color']) ? UniteAdminRev.rgb2hex(svgstyles['svgstroke-hover-color']) : "transparent";
			
			// SVG STROKE TRANSPARENCY
			if(nix(objLayer['svg']['svgstroke-hover-transparency']) || reset)
				objLayer['svg']['svgstroke-hover-transparency'] = !nix(svgstyles["svgstroke-hover-transparency"]) ? svgstyles["svgstroke-hover-transparency"] : "1";
			
			// SVG STROKE DASH ARRAY
			if (nix(objLayer['svg']['svgstroke-hover-dasharray']) || reset)
				objLayer['svg']['svgstroke-hover-dasharray'] = !nix(svgstyles['svgstroke-hover-dasharray']) ? svgstyles['svgstroke-hover-dasharray'] : "0";

			// SVG STROKE DASH OFFSET
			if (nix(objLayer['svg']['svgstroke-hover-dashoffset']) || reset)
				objLayer['svg']['svgstroke-hover-dashoffset'] = !nix(svgstyles['svgstroke-hover-dashoffset']) ? svgstyles['svgstroke-hover-dashoffset'] : "0";
				
			// SVG STROKE WIDTH
			if (nix(objLayer['svg']['svgstroke-hover-width']) || reset)
				objLayer['svg']['svgstroke-hover-width'] = !nix(svgstyles['svgstroke-hover-width']) ? svgstyles['svgstroke-hover-width'] : "0";
		}


		if (objLayer.force_hover === true)
			jQuery('#force_hover').attr('checked', true);
		else
			jQuery('#force_hover').attr('checked', false);
		if(reset){
			if(is_hover === 'true' || is_hover === true){
				jQuery('#hover_allow').attr('checked', true);
				jQuery('#idle-hover-swapper').show();
			}else{
				jQuery('#hover_allow').attr('checked', false);
				jQuery('#idle-hover-swapper').hide();
			}
		}

		RevSliderSettings.onoffStatus(jQuery('#hover_allow'));
		RevSliderSettings.onoffStatus(jQuery('#toggle_allow'));
		RevSliderSettings.onoffStatus(jQuery('#toggle_use_hover'));
		RevSliderSettings.onoffStatus(jQuery('#toggle_inverse_content'));
		RevSliderSettings.onoffStatus(jQuery('#force_hover'));
		
		
		jQuery('#css_layer_selectable option[value="'+objLayer['layer-selectable']+'"]').attr('selected', true);
		
		if(objLayer.deformation != undefined){
			jQuery('#css_font-family').val(objLayer['deformation']['font-family']);
			
			//jQuery('input[name="css_padding[]"]').each(function(i){ jQuery(this).val(objLayer['deformation']['padding'][i]);});
			
			var cur_pad = t.getVal(objLayer, 'padding');
			if(cur_pad === undefined) cur_pad = objLayer['deformation']['padding'];
			if(cur_pad === undefined) cur_pad = [0,0,0,0];
			jQuery('input[name="css_padding[]"]').each(function(i){
				jQuery(this).val(cur_pad[i]);
			});

			var cur_mar = t.getVal(objLayer, 'margin');
			if(cur_mar === undefined) cur_mar = objLayer['deformation']['margin'];
			if(cur_mar === undefined) cur_mar = [0,0,0,0];
			jQuery('input[name="css_margin[]"]').each(function(i){
				jQuery(this).val(cur_mar[i]);
			});
			
			if(objLayer['deformation']['font-style'] == 'italic')
				jQuery('#css_font-style').attr('checked', true); // checkbox
			else
				jQuery('#css_font-style').attr('checked', false); // checkbox						
			RevSliderSettings.onoffStatus(jQuery('#css_font-style'));
			
			
			
			/*if(objLayer['layer-selectable'] == 'on')
				jQuery('#css_layer_selectable').attr('checked', true); // checkbox
			else
				jQuery('#css_layer_selectable').attr('checked', false); // checkbox
			RevSliderSettings.onoffStatus(jQuery('#css_layer_selectable'));*/
			
			jQuery('#css_text-align option[value="'+t.getVal(objLayer, 'text-align')+'"]').attr('selected', true);
			//jQuery('#css_text-align option[value="'+objLayer['deformation']['text-align']+'"]').attr('selected', true);
			
			
			jQuery('#css_font-transparency').val(objLayer['deformation']['color-transparency']);
			jQuery('#css_text-decoration option[value="'+objLayer['deformation']['text-decoration']+'"]').attr('selected', true);
			jQuery('#css_overflow option[value="'+objLayer['deformation']['overflow']+'"]').attr('selected', true);
			jQuery('#column_break_at option[value="'+objLayer['column_break_at']+'"]').attr('selected', true);
			
			jQuery('#css_vertical-align option[value="'+objLayer['deformation']['vertical-align']+'"]').attr('selected', true);
			
			jQuery('#css_text-transform option[value="'+objLayer['deformation']['text-transform']+'"]').attr('selected', true);
			jQuery('#css_background-color').val(objLayer['deformation']['background-color']);
			jQuery('#css_background-transparency').val(objLayer['deformation']['background-transparency']);
			jQuery('#css_border-color-show').val(objLayer['deformation']['border-color']);
			jQuery('#css_border-transparency').val(objLayer['deformation']['border-transparency']);
			jQuery('#css_border-style option[value="'+objLayer['deformation']['border-style']+'"]').attr('selected', true);
			//jQuery('#css_border-width').val(objLayer['deformation']['border-width']);
			jQuery('input[name="css_border-width[]"]').each(function(i){ jQuery(this).val(objLayer['deformation']['border-width'][i]);});
			jQuery('input[name="css_border-radius[]"]').each(function(i){ jQuery(this).val(objLayer['deformation']['border-radius'][i]);});
			jQuery('input[name="layer__x"]').val(objLayer['deformation']['x']);
			jQuery('input[name="layer__y"]').val(objLayer['deformation']['y']);
			jQuery('#layer__z').val(objLayer['deformation']['z']);
			jQuery('#layer__skewx').val(objLayer['deformation']['skewx']);
			jQuery('#layer__skewy').val(objLayer['deformation']['skewy']);
			jQuery('#layer__scalex').val(objLayer['deformation']['scalex']);
			jQuery('#layer__scaley').val(objLayer['deformation']['scaley']);
			jQuery('#layer__opacity').val(objLayer['deformation']['opacity']);
			jQuery('#layer__xrotate').val(objLayer['deformation']['xrotate']);
			jQuery('#layer__yrotate').val(objLayer['deformation']['yrotate']);
			jQuery('#layer_2d_rotation').val(objLayer['2d_rotation']);
			jQuery('#layer_2d_origin_x').val(objLayer['deformation']['2d_origin_x']);//
			jQuery('#layer_2d_origin_y').val(objLayer['deformation']['2d_origin_y']);//
			jQuery('#layer__pers').val(objLayer['deformation']['pers']);
			jQuery('#layer_cornerleft option[value="'+objLayer['deformation']['corner_left']+'"]').attr('selected', true);
			jQuery('#layer_blend_mode option[value="'+objLayer['layer_blend_mode']+'"]').attr('selected', true);
			

			jQuery('#layer_cornerright option[value="'+objLayer['deformation']['corner_right']+'"]').attr('selected', true);
			jQuery('#parallax_level option[value="'+objLayer['deformation']['parallax']+'"]').attr('selected', true);
			
			
			
			
			if (nix(objLayer['deformation-hover']['color']) || reset)
				objLayer['deformation-hover']['color'] = !nix(hover_styles['color']) ? hover_styles['color'] : '#000000';
			
			if (nix(objLayer['deformation-hover']['color-transparency']) || reset)
				objLayer['deformation-hover']['color-transparency'] = !nix(hover_styles['color-transparency']) ? hover_styles['color-transparency'] : '1';
			
			if (nix(objLayer['deformation-hover']['text-decoration']) || reset)
				objLayer['deformation-hover']['text-decoration'] = !nix(hover_styles['text-decoration']) ? hover_styles['text-decoration'] : 'none';
			
			if (nix(objLayer['deformation-hover']['background-color']) || reset)
				objLayer['deformation-hover']['background-color'] = !nix(hover_styles['background-color']) ? hover_styles['background-color'] : 'transparent';
			
			if (nix(objLayer['deformation-hover']['background-transparency']) || reset)
				objLayer['deformation-hover']['background-transparency'] = !nix(hover_styles['background-transparency']) ? hover_styles['background-transparency'] : '1';
			
			if (nix(objLayer['deformation-hover']['border-color']) || reset)
				objLayer['deformation-hover']['border-color'] = !nix(hover_styles['border-color']) ? hover_styles['border-color'] : 'transparent';
			
			if (nix(objLayer['deformation-hover']['border-transparency']) || reset)
				objLayer['deformation-hover']['border-transparency'] = !nix(hover_styles['border-transparency']) ? hover_styles['border-transparency'] : '1';
			
			if (nix(objLayer['deformation-hover']['border-style']) || reset)
				objLayer['deformation-hover']['border-style'] = !nix(hover_styles['border-style']) ? hover_styles['border-style'] : 'none';
			
			//if (nix(objLayer['deformation-hover']['border-width']) || reset)
			//	objLayer['deformation-hover']['border-width'] = !nix(hover_styles['border-width']) ? hover_styles['border-width'] : '0';
			if (nix(objLayer['deformation-hover']['border-width']) || (nix(objLayer['deformation-hover']['border-width'][0]) && nix(objLayer['deformation-hover']['border-width'][1]) && nix(objLayer['deformation-hover']['border-width'][2]) && nix(objLayer['deformation-hover']['border-width'][3])) || reset) {

				var cor = !nix(hover_styles['border-width']) ? typeof(hover_styles['border-width']) !== 'object' ? hover_styles['border-width'].split(" ") : hover_styles['border-width'] : ["0px","0px","0px","0px"];
				objLayer['deformation-hover']['border-width'] = ["0","0","0","0"];

				jQuery(objLayer['deformation-hover']['border-width']).each(function(i){
					objLayer['deformation-hover']['border-width'][i] = cor.length<2 ? cor[0] : cor.length<4 ? i==0 || i==2 ? cor[0] : cor[1] : cor[i];									
				});
			}
			
			if (nix(objLayer['deformation-hover']['border-radius']) || (nix(objLayer['deformation-hover']['border-radius'][0]) && nix(objLayer['deformation-hover']['border-radius'][1]) && nix(objLayer['deformation-hover']['border-radius'][2]) && nix(objLayer['deformation-hover']['border-radius'][3])) || reset) {

				var cor = !nix(hover_styles['border-radius']) ? typeof(hover_styles['border-radius']) !== 'object' ? hover_styles['border-radius'].split(" ") : hover_styles['border-radius'] : ["0px","0px","0px","0px"];											
				objLayer['deformation-hover']['border-radius'] = ["0","0","0","0"];

				jQuery(objLayer['deformation-hover']['border-radius']).each(function(i){
					objLayer['deformation-hover']['border-radius'][i] = cor.length<2 ? cor[0] : cor.length<4 ? i==0 || i==2 ? cor[0] : cor[1] : cor[i];									
				});
			}
			
			if (nix(objLayer['deformation-hover']['skewx']) || reset)
				objLayer['deformation-hover']['skewx'] = !nix(hover_styles['skewx']) ? hover_styles['skewx'] : 0;
			if (nix(objLayer['deformation-hover']['skewy']) || reset)
				objLayer['deformation-hover']['skewy'] = !nix(hover_styles['skewy']) ? hover_styles['skewy'] : 0;
			if (nix(objLayer['deformation-hover']['scalex']) || reset)
				objLayer['deformation-hover']['scalex'] = !nix(hover_styles['scalex']) ? hover_styles['scalex'] : 1;
			if (nix(objLayer['deformation-hover']['scaley']) || reset)
				objLayer['deformation-hover']['scaley'] = !nix(hover_styles['scaley']) ? hover_styles['scaley'] : 1;
			if (nix(objLayer['deformation-hover']['opacity']) || reset)
				objLayer['deformation-hover']['opacity'] = !nix(hover_styles['opacity']) ? hover_styles['opacity'] : 1;
			if (nix(objLayer['deformation-hover']['xrotate']) || reset)
				objLayer['deformation-hover']['xrotate'] = !nix(hover_styles['xrotate']) ? hover_styles['xrotate'] : 0;
			if (nix(objLayer['deformation-hover']['yrotate']) || reset)
				objLayer['deformation-hover']['yrotate'] = !nix(hover_styles['yrotate']) ? hover_styles['yrotate'] : 0;
			if (nix(objLayer['deformation-hover']['2d_rotation']) || reset)
				objLayer['deformation-hover']['2d_rotation'] = !nix(hover_styles['2d_rotation']) ? hover_styles['2d_rotation'] : 0;
			if (nix(objLayer['deformation-hover']['css_cursor']) || reset)
				objLayer['deformation-hover']['css_cursor'] = !nix(hover_styles['css_cursor']) ? hover_styles['css_cursor'] : 'auto';
			
			/* not included yet, missing values */
			if (nix(objLayer['deformation-hover']['speed']) || reset)
				objLayer['deformation-hover']['speed'] = !nix(hover_styles['speed']) ? hover_styles['speed'] : '0';
			
			if (nix(objLayer['deformation-hover']['easing']) || reset)
				objLayer['deformation-hover']['easing'] = !nix(hover_styles['easing']) ? hover_styles['easing'] : 'Linear.easeNone';
			
			/* ENDE not included yet, missing values */
			
			if(objLayer['deformation-hover'] != undefined){
				jQuery('#hover_layer_color_s').val(objLayer['deformation-hover']['color']);
				jQuery('#hover_css_font-transparency').val(objLayer['deformation-hover']['color-transparency']);				
				jQuery('#hover_css_text-decoration option[value="'+objLayer['deformation-hover']['text-decoration']+'"]').attr('selected', true);
				jQuery('#hover_css_background-color').val(objLayer['deformation-hover']['background-color']);
				jQuery('#hover_css_background-transparency').val(objLayer['deformation-hover']['background-transparency']);
				jQuery('#hover_css_border-color-show').val(objLayer['deformation-hover']['border-color']);
				jQuery('#hover_css_border-transparency').val(objLayer['deformation-hover']['border-transparency']);
				jQuery('#hover_css_border-style option[value="'+objLayer['deformation-hover']['border-style']+'"]').attr('selected', true);
				//jQuery('#hover_css_border-width').val(objLayer['deformation-hover']['border-width']);
				jQuery('input[name="hover_css_border-width[]"]').each(function(i){ jQuery(this).val(objLayer['deformation-hover']['border-width'][i]); });
				jQuery('input[name="hover_css_border-radius[]"]').each(function(i){ jQuery(this).val(objLayer['deformation-hover']['border-radius'][i]); });
				jQuery('#hover_layer__skewx').val(objLayer['deformation-hover']['skewx']);
				jQuery('#hover_layer__skewy').val(objLayer['deformation-hover']['skewy']);
				jQuery('#hover_layer__scalex').val(objLayer['deformation-hover']['scalex']);
				jQuery('#hover_layer__scaley').val(objLayer['deformation-hover']['scaley']);
				jQuery('#hover_layer__opacity').val(objLayer['deformation-hover']['opacity']);
				jQuery('#hover_layer__xrotate').val(objLayer['deformation-hover']['xrotate']);
				jQuery('#hover_layer__yrotate').val(objLayer['deformation-hover']['yrotate']);
				jQuery('#hover_layer_2d_rotation').val(objLayer['deformation-hover']['2d_rotation']); //z rotate
				jQuery('#css_cursor option[value="'+objLayer['deformation-hover']['css_cursor']+'"]').attr('selected', true);
				
				jQuery('#hover_speed').val(objLayer['deformation-hover']['speed']);
				jQuery('#hover_zindex').val(objLayer['deformation-hover']['zindex']);
				jQuery('#hover_easing option[value="'+objLayer['deformation-hover']['easing']+'"]').attr('selected', true);
				
			}
		}
		
		jQuery('.wp-color-result').each(function(){
			jQuery(this).css('backgroundColor', jQuery(this).parent().find('.my-color-field').val());
		});

		
		return objLayer;

	}




	/**
	 * update layer parameters from the object
	 */
	t.updateLayerFormFields = function(serial){
		
		var objLayer = t.arrLayers[serial];

		// HOOK FOR EXTERNAL ADDONS
		jQuery.each(t.addon_callbacks, function(i,callback_element) {
			var callback = callback_element["callback"],				
				env = callback_element["environment"],
				env_sub = callback_element["function_position"];
			if (env === "updateLayerFormFields" && env_sub=="start") 								
				objLayer = callback(objLayer);
			
		});
		
		
		if(typeof(objLayer) == 'undefined') return true;
		
		jQuery('#internal_classes').val(objLayer.internal_class);
		
		//ONLY FOR DEBUG!!
		//jQuery('#layer_type option[value="'+objLayer.type+'"]').attr('selected', true);
		
		jQuery('.rs-internal-class-wrapper').text(objLayer.internal_class);
		
		jQuery('#layer_caption').val(objLayer.style);

		jQuery('#layer_text').val(UniteAdminRev.stripslashes(objLayer.text));	
		
		if (objLayer.texttoggle!=undefined) 
			jQuery('#layer_text_toggle').val(UniteAdminRev.stripslashes(objLayer.texttoggle));		
		else 			
			jQuery('#layer_text_toggle').val("");
		

		
		jQuery('#layer_text').data('new_content',false)
		jQuery('#layer_alt_option option[value="'+objLayer.alt_option+'"]').attr('selected', 'selected');
		jQuery('#layer_alt').val(objLayer.alt);
		
		jQuery('#layer_alias_name').val(objLayer.alias);
		
		if(objLayer['hover'] == 'true' || objLayer['hover'] == true){
			jQuery('#hover_allow').prop("checked", true);
			jQuery('#idle-hover-swapper').show();
		}else{
			jQuery('#hover_allow').prop("checked", false);
			jQuery('#idle-hover-swapper').hide();
		}

		if (objLayer['force_hover'] == 'true' || objLayer['force_hover'] == true) 
			jQuery('#force_hover').prop("checked",true);
		else
			jQuery('#force_hover').prop("checked",false);


		if(objLayer['toggle'] == 'true' || objLayer['toggle'] == true){
			jQuery('#toggle_allow').prop("checked", true);			
		}else{
			jQuery('#toggle_allow').prop("checked", false);			
		}

		if(objLayer['toggle_use_hover'] == 'true' || objLayer['toggle_use_hover'] == true){
			jQuery('#toggle_use_hover').prop("checked", true);			
		}else{
			jQuery('#toggle_use_hover').prop("checked", false);			
		}

		if(objLayer['toggle_inverse_content'] == 'true' || objLayer['toggle_inverse_content'] == true){
			jQuery('#toggle_inverse_content').prop("checked", true);			
		}else{
			jQuery('#toggle_inverse_content').prop("checked", false);			
		}


		
		if(objLayer['visible-notebook'] == 'true' || objLayer['visible-notebook'] == true)
			jQuery('#visible-notebook').prop('checked',true);
		else
			jQuery('#visible-notebook').prop('checked',false);

		if(objLayer['visible-desktop'] == "true" || objLayer['visible-desktop'] == true)
			jQuery('#visible-desktop').prop('checked',true);
		else
			jQuery('#visible-desktop').prop('checked',false);

		if(objLayer['visible-tablet'] == "true" || objLayer['visible-tablet'] == true)
			jQuery('#visible-tablet').prop('checked',true);
		else
			jQuery('#visible-tablet').prop('checked',false);

		if(objLayer['visible-mobile'] == "true" || objLayer['visible-mobile'] == true)
			jQuery('#visible-mobile').prop('checked',true);
		else
			jQuery('#visible-mobile').prop('checked',false);
		
		if(objLayer['show-on-hover'] == "true" || objLayer['show-on-hover'] == true)
			jQuery('#layer_on_slider_hover').prop('checked',true);
		else
			jQuery('#layer_on_slider_hover').prop('checked',false);
		
		jQuery('#layer-lazy-loading option[value="'+objLayer['lazy-load']+'"]').attr('selected', 'selected');
		jQuery('#layer-image-size option[value="'+objLayer['image-size']+'"]').attr('selected', 'selected');
		jQuery('#layer-css-position option[value="'+objLayer['css-position']+'"]').attr('selected', 'selected');
		
		RevSliderSettings.onoffStatus(jQuery('#hover_allow'));
		RevSliderSettings.onoffStatus(jQuery('#force_hover'));
		RevSliderSettings.onoffStatus(jQuery('#toggle_allow'));
		RevSliderSettings.onoffStatus(jQuery('#toggle_use_hover'));
		RevSliderSettings.onoffStatus(jQuery('#toggle_inverse_content'));
		RevSliderSettings.onoffStatus(jQuery('#visible-desktop'));
		RevSliderSettings.onoffStatus(jQuery('#visible-notebook'));
		RevSliderSettings.onoffStatus(jQuery('#visible-tablet'));
		RevSliderSettings.onoffStatus(jQuery('#visible-mobile'));
		RevSliderSettings.onoffStatus(jQuery('#layer_on_slider_hover'));
		
		jQuery("#layer_scaleX").val(specOrVal(t.getVal(objLayer,'scaleX'),["auto"],"px"));
		jQuery("#layer_scaleY").val(specOrVal(t.getVal(objLayer,'scaleY'),["auto"],"px"));
		
		jQuery('#layer_cover_mode option[value="'+objLayer['cover_mode']+'"]').attr('selected', 'selected');
		
		jQuery("#layer_max_height").val(specOrVal(t.getVal(objLayer,'max_height'),["auto"],"px"));
		jQuery("#layer_min_height").val(specOrVal(t.getVal(objLayer,'min_height'),["auto"],"px"));
		jQuery("#layer_max_width").val(specOrVal(t.getVal(objLayer,'max_width'),["auto"],"px"));
		
		jQuery("#layer_video_height").val(specOrVal(t.getVal(objLayer,'video_height'),["auto"],"px"));
		jQuery("#layer_video_width").val(specOrVal(t.getVal(objLayer,'video_width'),["auto"],"px"));
		
		jQuery("#layer_2d_rotation").val(objLayer['2d_rotation']);
		jQuery("#layer_2d_origin_x").val(objLayer['2d_origin_x']);
		jQuery("#layer_2d_origin_y").val(objLayer['2d_origin_y']);

		jQuery("#layer_static_start option[value='"+objLayer.static_start+"']").attr('selected', 'selected');
		changeEndStaticFunctions();
		jQuery("#layer_static_end option[value='"+objLayer.static_end+"']").attr('selected', 'selected');

		jQuery("#layer_whitespace option[value='"+t.getVal(objLayer, 'whitespace')+"']").attr('selected', 'selected');

		jQuery("#layer_display option[value='"+t.getVal(objLayer, 'display')+"']").attr('selected', 'selected');


		if(objLayer.scaleProportional == "true" || objLayer.scaleProportional == true){
			jQuery('.rs-proportion-check').removeClass('notselected');
			jQuery("#layer_proportional_scale").prop("checked",true);
		}else{
			jQuery("#layer_proportional_scale").prop("checked",false);
			jQuery('.rs-proportion-check').addClass('notselected');
		}


		if (t.getVal(objLayer, 'whitespace') ==="normal") {
			jQuery('.rs-linebreak-check').removeClass("notselected");
			jQuery('#layer_auto_line_break').prop("checked",true);
		} else {
			jQuery('.rs-linebreak-check').addClass("notselected");
			jQuery('#layer_auto_line_break').prop("checked",false);
		}

		if (t.getVal(objLayer, 'display') ==="block") {
			jQuery('#layer-displaymode-wrapper').removeClass("notselected");
			jQuery('#layer_displaymode').prop("checked",true);
		} else {
			jQuery('#layer-displaymode-wrapper').addClass("notselected");
			jQuery('#layer_displaymode').prop("checked",false);
		}

		
		RevSliderSettings.onoffStatus(jQuery('.rs-proportion-check'));
		RevSliderSettings.onoffStatus(jQuery('.rs-linebreak-check'));
		
		jQuery("#layer_top").val(parseInt(t.getVal(objLayer, 'top'),0)+"px");
		jQuery("#layer_left").val(parseInt(t.getVal(objLayer, 'left'),0)+"px");
		
		jQuery("#layer_bg_position option[value='"+objLayer.layer_bg_position+"']").attr('selected', 'selected');
		jQuery("#layer_bg_size option[value='"+objLayer.layer_bg_size+"']").attr('selected', 'selected');
		jQuery("#layer_bg_repeat option[value='"+objLayer.layer_bg_repeat+"']").attr('selected', 'selected');
		
		
		//set Loop Animations
		jQuery("#layer_loop_animation option[value='"+objLayer.loop_animation+"']").attr('selected', 'selected');
		jQuery("#layer_loop_easing").val(objLayer.loop_easing);
		jQuery("#layer_loop_speed").val(objLayer.loop_speed);
		jQuery("#layer_loop_startdeg").val(objLayer.loop_startdeg);
		jQuery("#layer_loop_enddeg").val(objLayer.loop_enddeg);
		jQuery("#layer_loop_xorigin").val(objLayer.loop_xorigin);
		jQuery("#layer_loop_yorigin").val(objLayer.loop_yorigin);
		jQuery("#layer_loop_xstart").val(objLayer.loop_xstart);
		jQuery("#layer_loop_xend").val(objLayer.loop_xend);
		jQuery("#layer_loop_ystart").val(objLayer.loop_ystart);
		jQuery("#layer_loop_yend").val(objLayer.loop_yend);
		jQuery("#layer_loop_zoomstart").val(objLayer.loop_zoomstart);
		jQuery("#layer_loop_zoomend").val(objLayer.loop_zoomend);
		jQuery("#layer_loop_angle").val(objLayer.loop_angle);
		jQuery("#layer_loop_radius").val(objLayer.loop_radius);

		if (objLayer['svg']!=undefined) {
			jQuery('#css_svgstroke-color-show').val(objLayer['svg']['svgstroke-color']);
			jQuery('#css_svgstroke-transparency').val(objLayer['svg']['svgstroke-transparency']);
			jQuery('#css_svgstroke-dasharray').val(objLayer['svg']['svgstroke-dasharray']);
			jQuery('#css_svgstroke-dashoffset').val(objLayer['svg']['svgstroke-dashoffset']);
			jQuery('#css_svgstroke-width').val(objLayer['svg']['svgstroke-width']);
			jQuery('#css_svgstroke-hover-color-show').val(objLayer['svg']['svgstroke-hover-color']);
			jQuery('#css_svgstroke-hover-transparency').val(objLayer['svg']['svgstroke-hover-transparency']);
			jQuery('#css_svgstroke-hover-dasharray').val(objLayer['svg']['svgstroke-hover-dasharray']);
			jQuery('#css_svgstroke-hover-dashoffset').val(objLayer['svg']['svgstroke-hover-dashoffset']);
			jQuery('#css_svgstroke-hover-width').val(objLayer['svg']['svgstroke-hover-width']);
		}
		
		jQuery("#layer_html_tag option[value='"+objLayer.html_tag+"']").attr('selected', 'selected');
		jQuery("#parallax_layer_ddd_zlevel option[value='"+objLayer.parallax_layer_ddd_zlevel+"']").attr('selected', 'selected');
		
		if(objLayer.mask_start == "true" || objLayer.mask_start == true) {
			jQuery('#masking-start').attr("checked", true);
			jQuery('.mask-start-settings').show();						 	
		}
		else {
			jQuery('#masking-start').prop("checked",false);
			jQuery('.mask-start-settings').hide();
		}

		if(objLayer.mask_end == "true" || objLayer.mask_end == true) {
			jQuery('#masking-end').attr("checked", true);
			jQuery('.mask-end-settings').show();
		}
		else {
			jQuery('#masking-end').prop("checked",false);
			jQuery('.mask-end-settings').hide();
		}
	
		RevSliderSettings.onoffStatus(jQuery('#masking-start'));		
		RevSliderSettings.onoffStatus(jQuery('#masking-end'));
		
		jQuery("#mask_anim_xstart").val(objLayer.mask_x_start);
		jQuery("#mask_anim_ystart").val(objLayer.mask_y_start);
		jQuery("#mask_speed").val(objLayer.mask_speed_start);
		jQuery("#mask_easing").val(objLayer.mask_ease_start);
		
		jQuery("#mask_anim_xend").val(objLayer.mask_x_end);
		jQuery("#mask_anim_yend").val(objLayer.mask_y_end);
		//jQuery("#mask_speed_end").val(objLayer.mask_speed_end);
		//jQuery("#mask_easing_end").val(objLayer.mask_ease_end);
		
		jQuery("#layer_animation option[value='"+objLayer.frames["frame_0"].animation+"']").attr('selected', 'selected');

		jQuery("#layer_easing").val(objLayer.frames["frame_0"].easing);

		jQuery("#layer_split").val(objLayer.frames["frame_0"].split);
		jQuery("#layer_endsplit").val(objLayer.frames["frame_999"].split);
		jQuery("#layer_splitdelay").val(objLayer.frames["frame_0"].splitdelay);
		jQuery("#layer_endsplitdelay").val(objLayer.frames["frame_999"].splitdelay);

		
		jQuery("#layer_speed").val(objLayer.frames["frame_0"].speed);

		jQuery("#layer_align_hor").val(t.getVal(objLayer,'align_hor'));
		jQuery("#layer_align_vert").val(t.getVal(objLayer,'align_vert'));

		if(objLayer.hiddenunder == "true" || objLayer.hiddenunder == true)
			jQuery("#layer_hidden").prop("checked",true);
		else
			jQuery("#layer_hidden").prop("checked",false);
		
		if(objLayer.resizeme == "true" || objLayer.resizeme == true)
			jQuery("#layer_resizeme").prop("checked",true);
		else
			jQuery("#layer_resizeme").prop("checked",false);
		
		if(objLayer['seo-optimized'] == "true" || objLayer['seo-optimized'] == true)
			jQuery("#layer-seo-optimized").prop("checked",true);
		else
			jQuery("#layer-seo-optimized").prop("checked",false);
		
		if((objLayer['resize-full'] == "true" || objLayer['resize-full'] == true) && (objLayer.type!=="row" && objLayer.type!=="column")){
			jQuery("#layer_resize-full").prop("checked",true);
			if (objLayer.type==="group") {
				jQuery("#layer_resizeme").prop("checked",false);
				objLayer.resizeme = false; //remove checked state!
			}

		}else{
			jQuery("#layer_resize-full").prop("checked",false);
			jQuery("#layer_resizeme").prop("checked",false);
			objLayer.resizeme = false; //remove checked state!
		}
		
		jQuery("#layer_align_base").val(objLayer.basealign);
		
		if(objLayer.responsive_offset == "true" || objLayer.responsive_offset == true)
			jQuery("#layer_resp_offset").prop("checked",true);
		else
			jQuery("#layer_resp_offset").prop("checked",false);
		
		RevSliderSettings.onoffStatus(jQuery("#layer_hidden"));
		RevSliderSettings.onoffStatus(jQuery("#layer_resizeme"));
		RevSliderSettings.onoffStatus(jQuery("#layer_resize-full"));
		RevSliderSettings.onoffStatus(jQuery("#layer_resp_offset"));
		RevSliderSettings.onoffStatus(jQuery("#layer-seo-optimized"));
		
		jQuery("#layer_image_link").val(objLayer.link);
		jQuery("#layer_link_open_in").val(objLayer.link_open_in);
		jQuery("#layer_link_id").val(objLayer.link_id);
		jQuery("#layer_link_class").val(objLayer.link_class);
		jQuery("#layer_link_title").val(objLayer.link_title);
		jQuery("#layer_link_rel").val(objLayer.link_rel);

		jQuery('#layer_auto_line_break').val(objLayer.autolinebreak);

		jQuery('#layer_displaymode').val(objLayer.displaymode);


		jQuery("#layer_endanimation").val(objLayer.frames["frame_999"].animation);
		jQuery("#layer_endeasing").val(objLayer.frames["frame_999"].easing);
		jQuery("#layer_endspeed").val(objLayer.frames["frame_999"].speed);

		jQuery("#layer_anim_xstart").val(objLayer.x_start);
		jQuery("#layer_anim_ystart").val(objLayer.y_start);
		jQuery("#layer_anim_zstart").val(objLayer.z_start);
		jQuery("#layer_anim_xend").val(objLayer.x_end);
		jQuery("#layer_anim_yend").val(objLayer.y_end);
		jQuery("#layer_anim_zend").val(objLayer.z_end);
		jQuery("#layer_opacity_start").val(objLayer.opacity_start);
		jQuery("#layer_opacity_end").val(objLayer.opacity_end);
		jQuery("#layer_anim_xrotate").val(objLayer.x_rotate_start);
		jQuery("#layer_anim_yrotate").val(objLayer.y_rotate_start);
		jQuery("#layer_anim_zrotate").val(objLayer.z_rotate_start);
		jQuery("#layer_anim_xrotate_end").val(objLayer.x_rotate_end);
		jQuery("#layer_anim_yrotate_end").val(objLayer.y_rotate_end);
		jQuery("#layer_anim_zrotate_end").val(objLayer.z_rotate_end);
		jQuery("#layer_scale_xstart").val(objLayer.scale_x_start);
		jQuery("#layer_scale_ystart").val(objLayer.scale_y_start);
		jQuery("#layer_scale_xend").val(objLayer.scale_x_end);
		jQuery("#layer_scale_yend").val(objLayer.scale_y_end);
		jQuery("#layer_skew_xstart").val(objLayer.skew_x_start);
		jQuery("#layer_skew_ystart").val(objLayer.skew_y_start);
		jQuery("#layer_skew_xend").val(objLayer.skew_x_end);
		jQuery("#layer_skew_yend").val(objLayer.skew_y_end);
		
		jQuery("#layer_pers_start").val(objLayer.pers_start);
		jQuery("#layer_pers_end").val(objLayer.pers_end);
		
		if(typeof(objLayer['layer-selectable']) !== 'undefined'){
			jQuery('#css_layer_selectable option[value="'+objLayer['layer-selectable']+'"]').attr('selected', true);
		}else{
			jQuery('#css_layer_selectable option[value="default"]').attr('selected', true);
		}
		
		if(typeof(objLayer.x_start_reverse) !== 'undefined' && (objLayer.x_start_reverse == "true" || objLayer.x_start_reverse == true)) { jQuery('#layer_anim_xstart_reverse').attr('checked',true); }else{ jQuery('#layer_anim_xstart_reverse').prop("checked",false); }
		if(typeof(objLayer.y_start_reverse) !== 'undefined' && (objLayer.y_start_reverse == "true" || objLayer.y_start_reverse == true)) { jQuery('#layer_anim_ystart_reverse').attr('checked',true); }else{ jQuery('#layer_anim_ystart_reverse').prop("checked",false); }
		if(typeof(objLayer.x_end_reverse) !== 'undefined' && (objLayer.x_end_reverse == "true" || objLayer.x_end_reverse == true)) { jQuery('#layer_anim_xend_reverse').attr('checked',true); }else{ jQuery('#layer_anim_xend_reverse').prop("checked",false); }
		if(typeof(objLayer.y_end_reverse) !== 'undefined' && (objLayer.y_end_reverse == "true" || objLayer.y_end_reverse == true)) { jQuery('#layer_anim_yend_reverse').attr('checked',true); }else{ jQuery('#layer_anim_yend_reverse').prop("checked",false); }
		if(typeof(objLayer.x_rotate_start_reverse) !== 'undefined' && (objLayer.x_rotate_start_reverse == "true" || objLayer.x_rotate_start_reverse == true)) { jQuery('#layer_anim_xrotate_reverse').attr('checked',true); }else{ jQuery('#layer_anim_xrotate_reverse').prop("checked",false); }
		if(typeof(objLayer.y_rotate_start_reverse) !== 'undefined' && (objLayer.y_rotate_start_reverse == "true" || objLayer.y_rotate_start_reverse == true)) { jQuery('#layer_anim_yrotate_reverse').attr('checked',true); }else{ jQuery('#layer_anim_yrotate_reverse').prop("checked",false); }
		if(typeof(objLayer.z_rotate_start_reverse) !== 'undefined' && (objLayer.z_rotate_start_reverse == "true" || objLayer.z_rotate_start_reverse == true)) { jQuery('#layer_anim_zrotate_reverse').attr('checked',true); }else{ jQuery('#layer_anim_zrotate_reverse').prop("checked",false); }
		if(typeof(objLayer.x_rotate_end_reverse) !== 'undefined' && (objLayer.x_rotate_end_reverse == "true" || objLayer.x_rotate_end_reverse == true)) { jQuery('#layer_anim_xrotate_end_reverse').attr('checked',true); }else{ jQuery('#layer_anim_xrotate_end_reverse').prop("checked",false); }
		if(typeof(objLayer.y_rotate_end_reverse) !== 'undefined' && (objLayer.y_rotate_end_reverse == "true" || objLayer.y_rotate_end_reverse == true)) { jQuery('#layer_anim_yrotate_end_reverse').attr('checked',true); }else{ jQuery('#layer_anim_yrotate_end_reverse').prop("checked",false); }
		if(typeof(objLayer.z_rotate_end_reverse) !== 'undefined' && (objLayer.z_rotate_end_reverse == "true" || objLayer.z_rotate_end_reverse == true)) { jQuery('#layer_anim_zrotate_end_reverse').attr('checked',true); }else{ jQuery('#layer_anim_zrotate_end_reverse').prop("checked",false); }
		if(typeof(objLayer.scale_x_start_reverse) !== 'undefined' && (objLayer.scale_x_start_reverse == "true" || objLayer.scale_x_start_reverse == true)) { jQuery('#layer_scale_xstart_reverse').attr('checked',true); }else{ jQuery('#layer_scale_xstart_reverse').prop("checked",false); }
		if(typeof(objLayer.scale_y_start_reverse) !== 'undefined' && (objLayer.scale_y_start_reverse == "true" || objLayer.scale_y_start_reverse == true)) { jQuery('#layer_scale_ystart_reverse').attr('checked',true); }else{ jQuery('#layer_scale_ystart_reverse').prop("checked",false); }
		if(typeof(objLayer.scale_x_end_reverse) !== 'undefined' && (objLayer.scale_x_end_reverse == "true" || objLayer.scale_x_end_reverse == true)) { jQuery('#layer_scale_xend_reverse').attr('checked',true); }else{ jQuery('#layer_scale_xend_reverse').prop("checked",false); }
		if(typeof(objLayer.scale_y_end_reverse) !== 'undefined' && (objLayer.scale_y_end_reverse == "true" || objLayer.scale_y_end_reverse == true)) { jQuery('#layer_scale_yend_reverse').attr('checked',true); }else{ jQuery('#layer_scale_yend_reverse').prop("checked",false); }
		if(typeof(objLayer.skew_x_start_reverse) !== 'undefined' && (objLayer.skew_x_start_reverse == "true" || objLayer.skew_x_start_reverse == true)) { jQuery('#layer_skew_xstart_reverse').attr('checked',true); }else{ jQuery('#layer_skew_xstart_reverse').prop("checked",false); }
		if(typeof(objLayer.skew_y_start_reverse) !== 'undefined' && (objLayer.skew_y_start_reverse == "true" || objLayer.skew_y_start_reverse == true)) { jQuery('#layer_skew_ystart_reverse').attr('checked',true); }else{ jQuery('#layer_skew_ystart_reverse').prop("checked",false); }
		if(typeof(objLayer.skew_x_end_reverse) !== 'undefined' && (objLayer.skew_x_end_reverse == "true" || objLayer.skew_x_end_reverse == true)) { jQuery('#layer_skew_xend_reverse').attr('checked',true); }else{ jQuery('#layer_skew_xend_reverse').prop("checked",false); }
		if(typeof(objLayer.skew_y_end_reverse) !== 'undefined' && (objLayer.skew_y_end_reverse == "true" || objLayer.skew_y_end_reverse == true)) { jQuery('#layer_skew_yend_reverse').attr('checked',true); }else{ jQuery('#layer_skew_yend_reverse').prop("checked",false); }
		if(typeof(objLayer.mask_x_start_reverse) !== 'undefined' && (objLayer.mask_x_start_reverse == "true" || objLayer.mask_x_start_reverse == true)) { jQuery('#mask_anim_xstart_reverse').attr('checked',true); }else{ jQuery('#mask_anim_xstart_reverse').prop("checked",false); }
		if(typeof(objLayer.mask_y_start_reverse) !== 'undefined' && (objLayer.mask_y_start_reverse == "true" || objLayer.mask_y_start_reverse == true)) { jQuery('#mask_anim_ystart_reverse').attr('checked',true); }else{ jQuery('#mask_anim_ystart_reverse').prop("checked",false); }
		if(typeof(objLayer.mask_x_end_reverse) !== 'undefined' && (objLayer.mask_x_end_reverse == "true" || objLayer.mask_x_end_reverse == true)) { jQuery('#mask_anim_xend_reverse').attr('checked',true); }else{ jQuery('#mask_anim_xend_reverse').prop("checked",false); }
		if(typeof(objLayer.mask_y_end_reverse) !== 'undefined' && (objLayer.mask_y_end_reverse == "true" || objLayer.mask_y_end_reverse == true)) { jQuery('#mask_anim_yend_reverse').attr('checked',true); }else{ jQuery('#mask_anim_yend_reverse').prop("checked",false); }
		
		t.updateReverseList();




		if(objLayer['static_styles'] != undefined){
			jQuery("#layer_font_size_s").val(t.getVal(objLayer['static_styles'], 'font-size'));
			jQuery("#layer_line_height_s").val(t.getVal(objLayer['static_styles'], 'line-height'));
			jQuery("#layer_font_weight_s option[value='"+t.getVal(objLayer['static_styles'], 'font-weight')+"']").attr('selected', true);
			jQuery("#layer_color_s").val(t.getVal(objLayer['static_styles'], 'color'));
		}
		
		
		if(objLayer.animation_overwrite != undefined)
			jQuery('#layer-animation-overwrite option[value="'+objLayer.animation_overwrite+'"]').attr('selected', true);
		else
			jQuery('#layer-animation-overwrite option[value="wait"]').attr('selected', true);
			
		
		if(objLayer.trigger_memory != undefined)
			jQuery('#layer-tigger-memory option[value="'+objLayer.trigger_memory+'"]').attr('selected', true);
		else
			jQuery('#layer-tigger-memory option[value="keep"]').attr('selected', true);

		//deformation part

		
		//jQuery("#layer_slide_link").val(objLayer.link_slide);
		//jQuery("#layer_scrolloffset").val(objLayer.scrollunder_offset);
		
		//remove all html actions first
		t.remove_layer_actions();
		
		t.add_layer_actions(objLayer);

		// Reset Fields from Style Template
		objLayer = updateSubStyleParameters(objLayer);
		//KRISZTIAN ( UPDATE FIELDS VON LAYERS ON FOCUS) "Further Changes" From Deformations


		var vaHor = t.getVal(objLayer,'align_hor'),
			vaVer = t.getVal(objLayer,'align_vert');

		jQuery("#rs-align-wrapper a").removeClass("selected");
		jQuery("#rs-align-wrapper-ver a").removeClass("selected");
		
		jQuery("#rs-align-wrapper a[data-hor='"+vaHor+"']").addClass("selected");
		jQuery("#rs-align-wrapper-ver a[data-ver='"+vaVer+"']").addClass("selected");

		jQuery("#layer_id").val(objLayer.attrID);
		jQuery("#layer_wrapper_id").val(objLayer.attrWrapperID);
		jQuery("#layer_classes").val(objLayer.attrClasses);
		jQuery("#layer_wrapper_classes").val(objLayer.attrWrapperClasses);
		
		jQuery("#layer_title").val(objLayer.attrTitle);
		jQuery("#layer_rel").val(objLayer.attrRel);

		//show / hide go under slider offset row
		jQuery('select[name="layer_action[]"], select[name="no_layer_action[]"]').each(function() {			
			showHideLinkActions(jQuery(this));
		});
		showHideToolTip();
		showHideLoopFunctions(); //has to be the last thing done to not interrupt settings

		// HOOK FOR EXTERNAL ADDONS
		jQuery.each(t.addon_callbacks, function(i,callback_element) {
			var callback = callback_element["callback"],				
				env = callback_element["environment"],
				env_sub = callback_element["function_position"];
			if (env === "updateLayerFormFields" && env_sub=="end") 								
				objLayer = callback(objLayer);
			
		});
		
	}


	/**
	 * unselect all html layers
	 */
	var unselectHtmlLayers = function(){
		
		
		// HOOK FOR EXTERNAL ADDONS
		jQuery.each(t.addon_callbacks, function(i,callback_element) {
			var callback = callback_element["callback"],				
				env = callback_element["environment"],
				env_sub = callback_element["function_position"];
			if (env === "unselectHtmlLayers" && env_sub=="start") 				
				callback();			
		});

		var jcont = document.getElementById('divLayers');
			resizables = jcont.getElementsByClassName('ui-resizable'),
			rotatables = jcont.getElementsByClassName('ui-rotatable-handle');

		for (var a = 0; a<resizables.length-1;a++) {
			try{
				jQuery(resizables[a]).resizable("destroy");
			} catch(e) {
				
			}
		}
		for (var a = 0; a<rotatables.length-1;a++) {
			try{
				jQuery(rotatables[a]).rotatable("destroy");
			} catch(e) {}
		}
				
		jQuery(containerID + " .slide_layer").removeClass("layer_selected");
		jQuery('.layerrow_selected').removeClass("layerrow_selected");
		jQuery('.layerchild_selected').removeClass('layerchild_selected');		
		document.getElementById('id-esw').className="";
		

		// HOOK FOR EXTERNAL ADDONS
		jQuery.each(t.addon_callbacks, function(i,callback_element) {
			var callback = callback_element["callback"],				
				env = callback_element["environment"],
				env_sub = callback_element["function_position"];
			if (env === "unselectHtmlLayers" && env_sub=="end") 				
				callback();			
		});
		
	}

	t.hideRowLayoutComposer = function() {
		jQuery('#rs-layout-row-composer').hide(); //.appendTo(jQuery('#divLayers'));
		var rowopeners = document.getElementsByClassName('row_editor open_re');		
		for (var i=0;i<rowopeners.length;i++) {			
			rowopeners[i].className="row_editor";
		}
	}

	/**
	 * set all layers unselected
	 */
	var unselectLayers = function(){
		
		t.hideRowLayoutComposer();
		unselectHtmlLayers();
		jQuery('#timline-manual-dialog').appendTo(jQuery('#thelayer-editor-wrapper')).hide();
		var lslist = document.getElementsByClassName('layerchild_selected');
		for (var i=0;i<lslist.length-1;i++) {
			jQuery(lslist[i]).removeClass("layerchild_selected");
		}
		jQuery('.quicksortlayer.selected').removeClass("selected");
		jQuery('.layerrow_selected').removeClass("layerrow_selected");
		u.unselectSortboxItems();
		t.selectedLayerSerial = -1;
		disableFormFields();
				
		//reset elements
		
		t.showHideContentEditor(false);
		
		jQuery('.form_layers').addClass('notselected');
		
	
		u.resetIdleSelector();
		
		jQuery('#idle-hover-swapper').hide();

		u.allLayerToIdle();

		jQuery('#the_current-editing-layer-title').addClass("nolayerselectednow").val("No Layers Selected").attr("disabled","disabled");
		jQuery('#layer-short-toolbar').data('serial',"");
		
		
	}

	t.toolbarInPos = function(objLayer) {		
		if (objLayer)
			switch (objLayer.type) {
				case "image":
					jQuery('#button_change_image_source').show();
					jQuery('#button_edit_layer').hide();
					jQuery('#button_reset_size').show();
					jQuery('#button_change_video_settings').hide();
					jQuery('#layer-short-tool-placeholder-a').hide();
					jQuery('#layer-short-tool-placeholder-b').hide();
				break;
				case "text":
				case "button":
					if (!jQuery('#layer_text_wrapper').hasClass("currently_editing_txt")) {
						jQuery('#button_edit_layer').show();
						jQuery('#button_reset_size').show();
					} else {

						jQuery('#button_edit_layer').hide();
						jQuery('#button_reset_size').hide();
					}
					jQuery('#button_change_image_source').hide();					
					jQuery('#button_change_video_settings').hide();
					jQuery('#layer-short-tool-placeholder-a').hide();
					jQuery('#layer-short-tool-placeholder-b').hide();
				break;
				case 'audio':
				case "video":					
					jQuery('#button_edit_layer').hide();
					jQuery('#button_change_image_source').hide();
					jQuery('#button_reset_size').hide();
					jQuery('#button_change_video_settings').show();	
					jQuery('#layer-short-tool-placeholder-a').show();
					jQuery('#layer-short-tool-placeholder-b').hide();				
				break;
				case 'shape':
					jQuery('#button_change_image_source').hide();
					jQuery('#button_change_video_settings').hide();
					jQuery('#button_edit_layer').hide();
					jQuery('#button_reset_size').hide();
					jQuery('#layer-short-tool-placeholder-a').show();
					jQuery('#layer-short-tool-placeholder-b').show();
				break;
				/*case 'no_edit':
					jQuery('#button_change_image_source').hide();
					jQuery('#button_change_video_settings').hide();
					jQuery('#button_edit_layer').hide();
					jQuery('#button_reset_size').hide();
				break;*/
				case 'svg':
					jQuery('#button_change_image_source').hide();
					jQuery('#button_edit_layer').hide();
					jQuery('#button_reset_size').hide();
					jQuery('#button_change_video_settings').hide();
					jQuery('#layer-short-tool-placeholder-a').show();
					jQuery('#layer-short-tool-placeholder-b').hide();
					jQuery('#button_edit_layer').show();
					jQuery('#layer-short-tool-placeholder-b').hide();
					//show/hide elements depending
				break;
			}

		

	}
	
	
	t.remove_layer_actions = function(){
		
		jQuery('.layer_action_wrap').each(function(){
			jQuery(this).remove();
		});
		
	}
	
	/**
	 * check if the layer that is deleted, needs to be removed from any actions as well
	 **/
	t.checkActionsOnLayers = function(layerserial){
		var clayers = t.getSimpleLayers();
		
		var unique_id = t.getUniqueIdByLayer(layerserial); 
		
		for(var key in clayers){
			if(clayers[key]['layer_action'] !== undefined){
				for(var a in clayers[key]['layer_action']['action']){
					switch(clayers[key]['layer_action']['action'][a]){
						case 'start_in':
						case 'start_out':
						case 'start_video':
						case 'stop_video':
						case 'toggle_layer':
						case 'toggle_video':
						case 'mute_video':
						case 'unmute_video':
						case 'toggle_mute_video':
						case 'toggle_global_mute_video':
						case 'simulate_click':
						case 'toggle_class':
							
							var target_layer = clayers[key]['layer_action']['layer_target'][a];
							
							if(unique_id == target_layer){
								//remove that action from the layer
								if(clayers[key]['layer_action']['action'] && clayers[key]['layer_action']['action'][a]) delete clayers[key]['layer_action']['action'][a];
								if(clayers[key]['layer_action']['tooltip_event'] && clayers[key]['layer_action']['tooltip_event'][a]) delete clayers[key]['layer_action']['tooltip_event'][a];
								if(clayers[key]['layer_action']['image_link'] && clayers[key]['layer_action']['image_link'][a]) delete clayers[key]['layer_action']['image_link'][a];
								if(clayers[key]['layer_action']['link_open_in'] && clayers[key]['layer_action']['link_open_in'][a]) delete clayers[key]['layer_action']['link_open_in'][a];
								if(clayers[key]['layer_action']['jump_to_slide'] && clayers[key]['layer_action']['jump_to_slide'][a]) delete clayers[key]['layer_action']['jump_to_slide'][a];
								if(clayers[key]['layer_action']['scrolloffset'] && clayers[key]['layer_action']['scrolloffset'][a]) delete clayers[key]['layer_action']['scrolloffset'][a];
								if(clayers[key]['layer_action']['actioncallback'] && clayers[key]['layer_action']['actioncallback'][a]) delete clayers[key]['layer_action']['actioncallback'][a];
								if(clayers[key]['layer_action']['layer_target'] && clayers[key]['layer_action']['layer_target'][a]) delete clayers[key]['layer_action']['layer_target'][a];
								if(clayers[key]['layer_action']['action_delay'] && clayers[key]['layer_action']['action_delay'][a]) delete clayers[key]['layer_action']['action_delay'][a];
								if(clayers[key]['layer_action']['link_type'] && clayers[key]['layer_action']['link_type'][a]) delete clayers[key]['layer_action']['link_type'][a];
								if(clayers[key]['layer_action']['toggle_layer_type'] && clayers[key]['layer_action']['toggle_layer_type'][a]) delete clayers[key]['layer_action']['toggle_layer_type'][a];
								if(clayers[key]['layer_action']['toggle_class'] && clayers[key]['layer_action']['toggle_class'][a]) delete clayers[key]['layer_action']['toggle_class'][a];
							}
						break;
					}
				}
			}
		}
	}
	
	
	t.remove_action = function(o){
		if(confirm(rev_lang.remove_this_action)){
			o.closest('li').remove();
			t.updateLayerFromFields();
			
			u.updateAllLayerTimeline();
		}
	}

	t.checkLayerTriggered = function(objLayer) {
		var clayers = t.getSimpleLayers(),
			has_trigger = {in:false,out:false};	
		for(var key in clayers){
				if(clayers[key]['layer_action'] !== undefined){
					
					for(var a in clayers[key]['layer_action']['action']){
						switch(clayers[key]['layer_action']['action'][a]){
							case 'start_in':
							case 'start_out':
							case 'start_video':
							case 'stop_video':
							case 'toggle_layer':
							case 'toggle_video':
							case 'simulate_click':
							case 'toggle_class':
								var target_layer = clayers[key]['layer_action']['layer_target'][a];
								if(objLayer.unique_id == target_layer){
									switch(clayers[key]['layer_action']['action'][a]){
										case 'start_in':
											has_trigger.in=true;
										break;
										case 'start_out':
											has_trigger.out=true;
										break;
										case 'toggle_layer':
											has_trigger.in=true;
											has_trigger.out=true;
										break;
									}																	
								}
							break;
						}
					}					
				}
		}
		return has_trigger;
	}
	
	t.add_layer_actions = function(obj){

		
		var clayers = t.getSimpleLayers();
		
		if(obj === undefined){
			var content = global_action_template({'edit': true});
		
			jQuery('.layer_action_add_template').before(content);
			t.updateLayerFromFields();
		}else{
			jQuery('#triggered-element-behavior').hide();
			
			//add all actions from other layers that are directed to the currentlayer
			var current_layer = t.getCurrentLayer();
			
			for(var key in clayers){
				if(clayers[key]['layer_action'] !== undefined){
					var has_trigger = false;
					for(var a in clayers[key]['layer_action']['action']){
						switch(clayers[key]['layer_action']['action'][a]){
							case 'start_in':
							case 'start_out':
							case 'start_video':
							case 'stop_video':
							case 'toggle_layer':
							case 'toggle_video':
							case 'simulate_click':
							case 'toggle_class':
								var target_layer = clayers[key]['layer_action']['layer_target'][a];
								if(current_layer.unique_id == target_layer){
									switch(clayers[key]['layer_action']['action'][a]){
										case 'start_in':
										case 'start_out':
										case 'toggle_layer':
											has_trigger = true;
										break;
									}																	
									var act = '';
									switch(clayers[key]['layer_action']['action'][a]){
										case 'start_in':
											act = rev_lang.start_layer_in;
										break;
										case 'start_out':
											act = rev_lang.start_layer_out;
										break;
										case 'start_video':
											act = rev_lang.start_video;
										break;
										case 'stop_video':
											act = rev_lang.stop_video;
										break;
										case 'toggle_layer':
											act = rev_lang.toggle_layer_anim;
										break;
										case 'toggle_video':
											act = rev_lang.toggle_video;
										break;
										case 'simulate_click':
											act = rev_lang.simulate_click;
										break;
										case 'toggle_class':
											act = rev_lang.toggle_class;
										break;
									}
									
									jQuery('.layer_action_add_template').before('<li class="layer_is_triggered layer_action_wrap">'+rev_lang.layer_action_by+' <a href="javascript:UniteLayersRev.setLayerSelected(\''+key+'\');void(0);">'+clayers[key]['alias']+'</a> '+rev_lang.due_to_action+' '+act+'</li>');
								}
							break;
						}
					}
					
					if(has_trigger){
						jQuery('#triggered-element-behavior').show();
					}
					
				}
			}
			jQuery('.rs_disabled_field').each(function(){
				jQuery(this).attr('disabled', 'disabled'); //Disable
			});

		}


		if(obj !== undefined && obj['layer_action'] !== undefined && obj['layer_action'].action !== undefined){
			
			for(var key in obj['layer_action'].action){
				var data = {};
				data.edit = true;
				data.tooltip_event = (obj['layer_action'].tooltip_event !== undefined && obj['layer_action'].tooltip_event[key] !== undefined) ? obj['layer_action'].tooltip_event[key] : 'click';
				data.action = (obj['layer_action'].action !== undefined && obj['layer_action'].action[key] !== undefined) ? obj['layer_action'].action[key] : 'none';
				data.image_link = (obj['layer_action'].image_link !== undefined && obj['layer_action'].image_link[key] !== undefined) ? obj['layer_action'].image_link[key] : '';
				data.link_open_in = (obj['layer_action'].link_open_in !== undefined && obj['layer_action'].link_open_in[key] !== undefined) ? obj['layer_action'].link_open_in[key] : 'same';
				data.jump_to_slide = (obj['layer_action'].jump_to_slide !== undefined && obj['layer_action'].jump_to_slide[key] !== undefined) ? obj['layer_action'].jump_to_slide[key] : '';
				data.scrolloffset = (obj['layer_action'].scrollunder_offset !== undefined && obj['layer_action'].scrollunder_offset[key] !== undefined) ? obj['layer_action'].scrollunder_offset[key] : '';
				data.actioncallback = (obj['layer_action'].actioncallback !== undefined && obj['layer_action'].actioncallback[key] !== undefined) ? obj['layer_action'].actioncallback[key] : '';
				data.layer_target = (obj['layer_action'].layer_target !== undefined && obj['layer_action'].layer_target[key] !== undefined) ? obj['layer_action'].layer_target[key] : '';
				data.action_delay = (obj['layer_action'].action_delay !== undefined && obj['layer_action'].action_delay[key] !== undefined) ? obj['layer_action'].action_delay[key] : '';
				data.link_type = (obj['layer_action'].link_type !== undefined && obj['layer_action'].link_type[key] !== undefined) ? obj['layer_action'].link_type[key] : 'jquery';
				data.toggle_layer_type = (obj['layer_action'].toggle_layer_type !== undefined && obj['layer_action'].toggle_layer_type[key] !== undefined) ? obj['layer_action'].toggle_layer_type[key] : 'visible';
				data.toggle_class = (obj['layer_action'].toggle_class !== undefined && obj['layer_action'].toggle_class[key] !== undefined) ? obj['layer_action'].toggle_class[key] : '';

				// HOOK FOR EXTERNAL ADDONS
				jQuery.each(t.addon_callbacks, function(i,callback_element) {
					
					var callback = callback_element["callback"],				
						env = callback_element["environment"],
						env_sub = callback_element["function_position"];

					if (env === "add_layer_actions" && env_sub=="data_definition") 				
						data = callback(data,obj,key);
					
				});



				
				var content = global_action_template(data);
			
				jQuery('.layer_action_add_template').before(content);
				
			}
		}
		
	
		//add Slides and Layer into select fields, set these values again
		jQuery('select[name="jump_to_slide[]"], select[name="no_jump_to_slide[]"]').each(function(){
			jQuery(this).html('');
			for(var key in slideIDs){
				for(var mkey in slideIDs[key])
					jQuery(this).append(jQuery('<option></option>').val(mkey).text('Slide: '+slideIDs[key][mkey]));
			}
			
			var do_sel = jQuery(this).data('selectoption');
			
			jQuery(this).find('option[value="'+do_sel+'"]').attr('selected', true);
			
		}); //slide
		
		jQuery('select[name="layer_target[]"], select[name="no_layer_target[]"]').each(function(k){
			jQuery(this).html('');
			
			jQuery(this).append(jQuery('<option data-mytype="video-special"></option>').val('backgroundvideo').text(rev_lang.background_video));
			jQuery(this).append(jQuery('<option data-mytype="video-special"></option>').val('firstvideo').text(rev_lang.active_video));
			
			for(var key in clayers){
				if (clayers[key].deleted!==true)
					jQuery(this).append(jQuery('<option data-mytype="'+clayers[key].type+'"></option>').val(clayers[key]['unique_id']).text(clayers[key].alias));
			}
			
			if(initStaticLayers !== null && initStaticLayers.length > 0){
				jQuery(this).append(jQuery('<option data-mytype="all" disabled="disabled"></option>').text(rev_lang.static_layers));
				for(var key in initStaticLayers){
					jQuery(this).append(jQuery('<option data-mytype="'+initStaticLayers[key].type+'"></option>').val('static-'+initStaticLayers[key]['unique_id']).text(initStaticLayers[key].alias));
				}
			}
			
			var do_sel = jQuery(this).data('selectoption');
			
			jQuery(this).find('option[value="'+do_sel+'"]').attr('selected', true);
			
			var dataAnim = t.getAnimTimingAndTrigger(do_sel);
			
			jQuery(this).closest('li').find('select[name="do-layer-animation-overwrite[]"] option[value="'+dataAnim['animation_overwrite']+'"]').attr('selected', true);
			jQuery(this).closest('li').find('select[name="do-layer-trigger-memory[]"] option[value="'+dataAnim['trigger_memory']+'"]').attr('selected', true);
		}); //layer
		
	}
	
	
	/**
	 * set animation and trigger timings for actions
	 **/
	t.getAnimTimingAndTrigger = function(cur_id){
		
		var clayer = t.getLayerByUniqueId(cur_id);
		
		return {'animation_overwrite': clayer.animation_overwrite,'trigger_memory': clayer.trigger_memory};
		
	}
	
	/**
	 * set animation and trigger timings for actions
	 **/
	t.setAnimTimingAndTrigger = function(cur_id){
		
		var clayer = t.getLayerByUniqueId(cur_id);
		
		return {'animation_overwrite': clayer.animation_overwrite,'trigger_memory': clayer.trigger_memory};
		
	}
	
	/**
	 * SET THE LAYER RESIZABLE
	**/
	t.setLayerResizable = function(objLayer) {
		var aspectratio = false,
			layer = objLayer.references.htmlLayer;
		if(jQuery("#layer_proportional_scale")[0].checked || objLayer.type==="svg") aspectratio = true;		
		
		try{  layer.resizable("destroy"); } catch(e) { }
				
		layer.resizable({
			aspectRatio:aspectratio,
			handles:"all",
			start:function(event,ui) {				
				switch (objLayer.type) {
					case "img":
					case "audio":
					case "video":
						var th = aspectratio ? "auto" : "100%";					
						punchgs.TweenLite.set(ui.element,{width:ui.originalSize.width,height:ui.originalSize.height})
						punchgs.TweenLite.set(ui.element.find('img'),{width:"100%",height:th})
						punchgs.TweenLite.set(ui.element.find('.innerslide_layer').first(),{width:"100%",height:th})					
					break;
					
					default:												
						if (objLayer==="svg") 
							layer.find('.innerslide_layer.tp-caption').first().css({maxHeight:"none",minHeight:0,maxWidth:"none"});
						else {
							var mw = layer.outerWidth(),
								mh = objLayer.type==="shape" ? "none" : layer.outerHeight();
							if (objLayer.type!=="shape") layer.css({height:"auto"});
							punchgs.TweenLite.set(ui.element[0].getElementsByClassName('innerslide_layer')[0],{height:"auto",maxHeight:"none",minHeight:mh,maxWidth:mw});
						}						
					break;
				}
				
			},					
			resize:function(event,ui) {	
				switch (objLayer.type) {
					case "audio":
					case "video":
						jQuery('#layer_video_width').val(Math.round(ui.size.width)+"px");
						jQuery('#layer_video_height').val(Math.round(ui.size.height)+"px");
						var th = aspectratio ? "auto" : "100%";		

						if (ui.element[0].getElementsByTagName("img").length>0) punchgs.TweenLite.set(ui.element[0].getElementsByTagName("img")[0],{width:"100%",height:th})
						punchgs.TweenLite.set(ui.element[0].getElementsByClassName("innerslide_layer")[0],{maxWidth:"none",maxHeight:"none",width:"100%",height:"100%"});													
						punchgs.TweenLite.set(ui.element[0].getElementsByClassName("slide_layer_video")[0],{width:"100%",height:"100%"});
					break;
					case "image":					
						jQuery('#layer_scaleX').val(Math.round(ui.size.width)+"px");
						jQuery('#layer_scaleY').val(Math.round(ui.size.height)+"px");
						var th = aspectratio ? "auto" : "100%";																
						punchgs.TweenLite.set(ui.element,{width:Math.round(ui.size.width),height:Math.round(ui.size.height)})
						punchgs.TweenLite.set(ui.element[0].getElementsByTagName("img")[0],{width:"100%",height:th})
						punchgs.TweenLite.set(ui.element[0].getElementsByClassName("innerslide_layer")[0],{maxWidth:"100%", maxHeight:"100%",width:"100%",height:th})						
					break;					
										
					default:
						var il = ui.element[0].getElementsByClassName('innerslide_layer')[0],
							ilj = jQuery(il),
							minheight = ilj.outerHeight(),
							ilwidth = ilj.outerWidth(),
							maxheight = Math.round(ui.size.height)+1,
							maxwidth = Math.round(ui.size.width)+1;

						if (objLayer.type!=="shape" && objLayer.type!=="group") {
							maxheight = minheight>=maxheight ? "auto" : maxheight+"px";
							punchgs.TweenLite.set(il,{maxWidth:maxwidth});	
						} else {							
							punchgs.TweenLite.set(ilj,{maxWidth:maxwidth,maxHeight:maxheight,minHeight:"none",overwrite:"auto",height:"100%"});
						}
										
						
						jQuery('#layer_max_width').val(maxwidth+"px");
						jQuery('#layer_max_height').val(maxheight);
					break;
				}

				if (objLayer.type==="group") {
					jQuery.each(t.getLayersInGroup(objLayer.unique_id).layers,function(i,layer) {
						t.updateHtmlLayerPosition(false,layer,t.getVal(layer, 'top'),t.getVal(layer, 'left'),t.getVal(layer,'align_hor'),t.getVal(layer,'align_vert'));
					});					
				}
			},
			stop:function(event,ui) {
				layerresized = true;
				setTimeout(function() {
					layerresized = false;							
				},200);
				t.updateLayerFromFields();						
			}
		});

	}

	/* Set Style Layout based on Layer Style */
	t.resetLayerSelected = function(objLayer) {
		var layer = objLayer.references.htmlLayer;
			

		jQuery("#layer_cornerleft_row").hide();
		jQuery("#layer_cornerright_row").hide();
		jQuery("#layer_resizeme_row").hide();		
		jQuery("#layer_alt_row").hide();	
		jQuery("#layer_max_widthheight_wrapper").hide();
		jQuery("#layer_video_widthheight_wrapper").hide();
		jQuery("#layer_scaleXY_wrapper").hide();
		jQuery("#layer_minwidthheight_wrapper").hide();	
	
		var idesw = document.getElementById('id-esw'),
			incolumn = t.getObjLayerType(objLayer.p_uid)==="column";
		
		idesw.className = 'slt-'+objLayer.type+'-w';	
						
		if (incolumn) idesw.className +=' sltic';

		

		//do specific operations depends on type
		switch(objLayer.type){
			case 'audio':
			case 'video':	//show edit video button				
				jQuery("#linkInsertTemplate").addClass("disabled");
				jQuery("#layer_video_widthheight_wrapper").show();					
				t.showHideContentEditor(false);												
				
				if (layer.width()>=jQuery('#divLayers').width() && layer.height()>=jQuery('#divLayers').height())
					layer.addClass("fullscreen-video-layer");
				else
					layer.removeClass("fullscreen-video-layer");
			break;
			case 'image':
				//disable the insert button
				jQuery("#layer_scaleXY_wrapper").show();
				jQuery("#linkInsertTemplate").addClass("disabled");

				//show / hide some elements
				jQuery("#layer_alt_row").show();				
				
				
				jQuery('.rs-lazy-load-images-wrap').show();						
				if(jQuery('#layer_alt_option option:selected').val() == 'custom'){
					jQuery('#layer_alt').show();
				}else{
					jQuery('#layer_alt').hide();
				}									
			break;
			case 'svg':								
				jQuery("#layer_max_widthheight_wrapper").show();							
			break; 
			case 'shape':
				jQuery("#layer-covermode-wrapper").show();												
				jQuery('#layer_text_wrapper').removeClass('currently_editing_txt');	
				jQuery("#layer_max_widthheight_wrapper").show();						
			break;
			case 'group':
				jQuery("#layer_max_widthheight_wrapper").show();
			break;
			case 'row':
				jQuery("#layer_max_widthheight_wrapper").show();
			break;
			case 'column':				
				jQuery("#layer_minwidthheight_wrapper").show();	
			break;
			case 'text':
			case 'button':
			default:  //set layer text to default height								
				jQuery('#layer_text_wrapper').addClass('currently_editing_txt');								
				jQuery("#layer_cornerleft_row").show();
				jQuery("#layer_cornerright_row").show();
				jQuery("#layer_resizeme_row").show();								
				jQuery("#layer_max_widthheight_wrapper").show();													
			break;
		}


		if (objLayer.type!=="row" && objLayer.type!=="column") {
			t.setLayerResizable(objLayer);
			t.makeCurrentLayerRotatable();
		}

		if(jQuery('#hover_allow')[0].checked){
			jQuery('#idle-hover-swapper').show();
		}else{
			jQuery('#idle-hover-swapper').hide();
		}

		RevSliderSettings.onoffStatus(jQuery('#force_hover'));
		RevSliderSettings.onoffStatus(jQuery('#hover_allow'));
		RevSliderSettings.onoffStatus(jQuery('#toggle_allow'));
		RevSliderSettings.onoffStatus(jQuery('#toggle_use_hover'));
		RevSliderSettings.onoffStatus(jQuery('#toggle_inverse_content'));

		//hide autocomplete
		jQuery("#layer_caption").catcomplete("close");
		
		

		//reset all color picker fields to the corresponding colors
		jQuery('.wp-color-result').each(function(){
			jQuery(this).css('backgroundColor', jQuery(this).parent().find('.my-color-field').val());
		});
		
		u.rebuildLayerIdleProgress(layer);
	}
	
	/*! SET LAYER SELECTED */
	/**
	 * set layer selected representation
	 */
	t.setLayerSelected = function(serial,videoRefresh,infocus){

		
		if(t.selectedLayerSerial == serial && !videoRefresh)
			return(false);

		
		jQuery('#timline-manual-dialog').appendTo(jQuery('#thelayer-editor-wrapper')).hide();
		
		t.hideRowLayoutComposer();
		u.resetIdleSelector();

		jQuery('.quicksortlayer.selected').removeClass("selected");
		jQuery('#layer_quicksort_'+serial).addClass("selected");
		
		
		if (!infocus) jQuery('.timer-layer-text:focus').blur();

		t.remove_layer_actions();
		
		
		var objLayer = t.getLayer(serial);

		
				
		//add the correct bolds into the selectfield
		if ((objLayer.type==="text" || objLayer.type==="button"))
			if(typeof(objLayer['deformation']) !== 'undefined' && typeof(objLayer['deformation']['font-family']) !== 'undefined'){
				t.check_the_font_bold(objLayer['deformation']['font-family']);
			}else{
				t.check_the_font_bold('');
			}
				
		t.showHideContentEditor(false);
		t.toolbarInPos(objLayer);

		//unselect all other layers
		unselectHtmlLayers();

		// SOME TOOLBAR ACTION FOR SELECTED LAYER
		var	layer = objLayer.references.htmlLayer,
			tbar = jQuery('#layer-short-toolbar'),
			tcelt = jQuery('#the_current-editing-layer-title');
				
		tcelt.val(objLayer.alias).prop("disabled",false).removeClass("nolayerselectednow");			
		tbar.data('serial',serial);

		if(u.isLayerLocked(layer)) {
			var b=tbar.find('.quick-layer-lock'),
				i=b.find('i');
			b.addClass("in-off").removeClass("in-on");
			i.removeClass("eg-icon-lock-open").addClass("eg-icon-lock");				
		} else {
			var b=tbar.find('.quick-layer-lock'),
				i=b.find('i');
			b.addClass("in-on").removeClass("in-off");
			i.removeClass("eg-icon-lock").addClass("eg-icon-lock-open");							
		}

		if(u.isLayerVisible(layer)){
			var b=tbar.find('.quick-layer-view'),
				i=b.find('i');
			b.addClass("in-on").removeClass("in-off");				
			i.removeClass("eg-icon-eye-off").addClass("eg-icon-eye");				
		}else{
			var b=tbar.find('.quick-layer-view'),
				i=b.find('i');
			b.addClass("in-off").removeClass("in-on");
			i.removeClass("eg-icon-eye").addClass("eg-icon-eye-off");					
		}

		if (t.getVal(objLayer,"display")==="block") 			
			jQuery('#layer-displaymode-wrapper').removeClass("notselected");
		else
			jQuery('#layer-displaymode-wrapper').addClass("notselected");

		//set selected class
		layer.addClass("layer_selected");		
		layer.closest('.slide_layer_type_row').addClass('layerchild_selected');
		layer.closest('.row-zone-container').addClass('layerrow_selected');
		layer.closest('.slide_layer_type_column').addClass('layerchild_selected');

		u.setSortboxItemSelected(serial);

		//update selected serial var
		t.selectedLayerSerial = serial;
		//update bottom fields
		t.updateLayerFormFields(serial);

		//enable form fields
		enableFormFields();
		
		// HOOK FOR EXTERNAL ADDONS
		jQuery.each(t.addon_callbacks, function(i,callback_element) {
			var callback = callback_element["callback"],				
				env = callback_element["environment"],
				env_sub = callback_element["function_position"];			
			if (env === "setLayerSelected" && env_sub=="start") 							
				callback(serial);						
			
		});
		
		
		jQuery('#layer_text_wrapper').removeClass('currently_editing_txt');
		
		jQuery('.rs-lazy-load-images-wrap').hide();
		
		t.resetLayerSelected(objLayer);

		checkMaskingAvailabity();			
		u.rebuildLayerIdle(layer);	
		reAlignAndrePosition();
		
		jQuery('.form_layers').removeClass('notselected');
		t.set_cover_mode();
		
		//change the style classes available depending on .type
		
		UniteCssEditorRev.updateCaptionsInput(initArrCaptionClasses);
		t.updateReverseList();		
		jQuery('#parallax_level').change();

		

		// HOOK FOR EXTERNAL ADDONS
		jQuery.each(t.addon_callbacks, function(i,callback_element) {
			var callback = callback_element["callback"],				
				env = callback_element["environment"],
				env_sub = callback_element["envifunction_position"];			
			if (env === "setLayerSelected" && env_sub=="end") 							
				callback(serial);									
		});		
	}


	var  getRotationDegrees = function(obj) {
	    var matrix = obj.css("-webkit-transform") ||
	    obj.css("-moz-transform")    ||
	    obj.css("-ms-transform")     ||
	    obj.css("-o-transform")      ||
	    obj.css("transform");
	    if(matrix !== 'none') {
	        var values = matrix.split('(')[1].split(')')[0].split(',');
	        var a = values[0];
	        var b = values[1];
	        var angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
	    } else { var angle = 0; }
	    return (angle < 0) ? angle +=360 : angle;
	}
	/**
	 *
	 * return if the layer is selected or not
	 */
	var isLayerSelected = function(serial){
		return(serial == t.selectedLayerSerial);
	}



	var reAlignAndrePosition = function() {
		
	}



//======================================================
//			Time Functions
//======================================================

	/**
	 * get next available time
	 */
	var getNextTime = function(){
		var maxTime = 0;

		//get max time
		for (key in t.arrLayers){
			var layer = t.arrLayers[key];

			layerTime = (layer.time)?Number(layer.time):0;

			if(layerTime > maxTime)
					maxTime = layerTime;
		}

		var outputTime;
		if(maxTime == 0)
			outputTime = g_startTime;
		else
			outputTime = Number(maxTime) + Number(g_stepTime);


		if (outputTime>=g_slideTime) outputTime = g_slideTime / 2;
		return(outputTime);
	}


//======================================================
//				Time Functions End
//======================================================



//======================================================
//				HTML LAYER POSITION UPDATE
//======================================================
	t.updateHtmlLayerPosition = function(isInit,objLayer,top,left,align_hor,align_vert){
		
		

		if (objLayer===undefined || objLayer===false) return;
		//update positions by align
		var width = objLayer.references.htmlLayer.outerWidth(),
			height = objLayer.references.htmlLayer.outerHeight();


		totalWidth = container.width();		
		totalHeight = container.height();

		var _tw = totalWidth,
			_th = totalHeight;

		if (objLayer.p_uid!==-1 && t.getObjLayerType(objLayer.p_uid)==="group") {
			_tw = t.getLayerByUniqueId(objLayer.p_uid).references.htmlLayer.width();
			_th = t.getLayerByUniqueId(objLayer.p_uid).references.htmlLayer.height();
		}

		//get sizes from saved if on get
		if(isInit == true && objLayer.type == "image"){
			if(t.getVal(objLayer,'width') != -1)
				width = t.getVal(objLayer,'width');

			if(t.getVal(objLayer,'height') != -1)
				height = t.getVal(objLayer,'height');
		}
		
		var objCss = {};

		switch (objLayer.type) {
			case "row":				
				left = 0;
				top = 0;				
			break;
			case "column":
				left = 0;
				top = 0;
			break;
		}

		var _makrerelative = objLayer.p_uid!==-1 && t.getObjLayerType(objLayer.p_uid)==="column";

		
		objCss["position"] = _makrerelative || objLayer.type==="row" ? "relative" : "absolute";

		//handle horizontal
		switch(align_hor){
			default:
			case "left":
				objCss["right"] = "auto";
				objCss["left"] = _makrerelative ? "auto" : left+"px";
			break;
			case "right":
				objCss["left"] = "auto";
				objCss["right"] = _makrerelative ? "auto" :  left+"px";
			break;
			case "center":				
				var realLeft = (_tw - width)/2;
				realLeft = Math.round(realLeft) + left;
				objCss["left"] = _makrerelative ? "auto" : realLeft + "px";
				objCss["right"] = "auto";
			break;
		}

		//handle vertical
		switch(align_vert){
			default:
			case "top":
				objCss["bottom"] = "auto";
				objCss["top"] = _makrerelative ? "auto" :  top+"px";
			break;
			case "middle":
				var realTop = (_th - height)/2;
				realTop = objLayer.type==="row" ? 0 : Math.round(realTop)+top;
				objCss["top"] = _makrerelative ? "auto" :  realTop + "px";
				objCss["bottom"] = "auto";
			break;
			case "bottom":
				objCss["top"] = "auto";
				objCss["bottom"] = _makrerelative ? "auto" :  top+"px";
			break;
		}
		

		punchgs.TweenLite.set(objLayer.references.htmlLayer,objCss);
		
	}




//======================================================
//				Events Functions
//======================================================

	/**
	 *
	 * on layer drag event - update layer position
	 */
	var onLayerDragStart = function() {
		
		t.justDropped = false;
		t.showHideContentEditor(false);

		jQuery('#divLayers').addClass("onelayerinmove");

		
		var layerSerial = t.getSerialFromID(this.id),
			htmlLayer = jQuery(this),
			objLayer = t.getLayer(layerSerial);
		
		if (jQuery.inArray(objLayer.unique_id,t.selectedLayers)==-1) u.checkMultipleSelectedItems(true);
			
		htmlLayer.closest('.slide_layer_type_group').addClass("dragfromgroup");
		htmlLayer.data('originalPosition',htmlLayer.position());
		htmlLayer.addClass("draggable_toponall")				
		selectedLayerWidth = htmlLayer.outerWidth();
		selectedlayerHeight = htmlLayer.outerHeight();		
		totalWidth = container.width();
		totalHeight = container.height();
		htmlLayer.closest('.slide_layer_type_column').addClass("column_from_draggable");
		htmlLayer.closest('.slide_layer_type_row').css({zIndex:190});
		jQuery('#layer_text_wrapper').removeClass("currently_editing_txt");
		t.setLayerSelected(layerSerial);
		t.groupMove.x = 0;
		t.groupMove.y = 0;
		t.groupMove.sameGroup = t.getSameLinkedElements(objLayer);	
		//htmlLayer.css({width:(selectedLayerWidth+1)+"px"})
		
	}

	t.getSameLinkedElements = function(objLayer) {
		var list = [];			
		for (var i in t.selectedLayers) {
			var layer = t.getLayerByUniqueId(t.selectedLayers[i]);
			if (layer.unique_id !== objLayer.unique_id && layer.p_uid === objLayer.p_uid) {
				layer.positionCache = layer.references.htmlLayer.position();
				list.push(layer);			
			}
		}		
		return list;
	}

	t.getCurLinkedElements = function() {
		var list = [];			
		for (var i in t.selectedLayers) {
			var layer = t.getLayerByUniqueId(t.selectedLayers[i]);				
			list.push(layer);			
			
		}		
		if (list.length===0) {
			var layer = t.getLayer(t.selectedLayerSerial);			
			list.push(layer);
		}
		return list;
	}

	var onLayerDragEnd = function(event,ui) {
		
		var layerSerial = t.getSerialFromID(this.id),
			htmlLayer = jQuery(this);
		htmlLayer.removeClass("draggable_toponall")
		jQuery('.row-zone-container').removeClass("nowyouseeme");
		jQuery('.row-zone-container').removeClass('layerrow_selected');		
		jQuery('.column_from_draggable').removeClass("column_from_draggable");
		t.droppedContainerCheck(t.getLayer(layerSerial));		
		if (t.groupMove && t.groupMove.sameGroup && t.groupMove.sameGroup.length>0) {			
			for (var k=0;k<t.groupMove.sameGroup.length;k++) {
				var sgl = t.groupMove.sameGroup[k];
				selectedLayerWidth = sgl.references.htmlLayer.outerWidth();
				selectedlayerHeight = sgl.references.htmlLayer.outerHeight();
				t.onLayerDrag("ende",sgl.serial, sgl.references.htmlLayer);
			}
		} 
		selectedLayerWidth = htmlLayer.outerWidth();
		selectedlayerHeight = htmlLayer.outerHeight();		
		t.onLayerDrag("ende",layerSerial,htmlLayer);

		jQuery('.layer_selected').each(function() {
			var __ = jQuery(this),
				cs = __.data('serial');							
			if (cs!=layerSerial && layerSerial!==undefined) 		
				__.removeClass("layer_selected");
			
		});

		t.setLayerSelected(layerSerial);
		jQuery('#divLayers').removeClass("onelayerinmove");
		jQuery('.dragfromgroup').removeClass("dragfromgroup");
	}

	t.updateMovedLayers = function(forced) {				
		jQuery.each(t.keyboardmovedlayers,function(i,layer){
			if (layer.references!==undefined) {
				selectedLayerWidth = layer.references.htmlLayer.outerWidth();
				selectedlayerHeight = layer.references.htmlLayer.outerHeight();				
				t.onLayerDrag("ende",layer.serial, layer.references.htmlLayer,true);			
			}
		})
	}

	t.adjustSelectedLayerPositions = function(dir,dist) {
		t.keyboardmovedlayers = t.getCurLinkedElements();
		jQuery.each(t.keyboardmovedlayers,function(i,layer){
			if (layer.references!==undefined)
				if (dir=="top")
					punchgs.TweenLite.set(layer.references.htmlLayer,{top:Math.round(layer.references.htmlLayer.position().top)+dist});
				else
					punchgs.TweenLite.set(layer.references.htmlLayer,{left:Math.round(layer.references.htmlLayer.position().left)+dist});
		});
		
		
	}

	t.onLayerDrag = function(ui,event,htmlLayer,ignoreorig){
		
		htmlLayer = htmlLayer || jQuery(this);
		
		var position = htmlLayer.position(),
			posTop = Math.round(position.top),
			posLeft = Math.round(position.left),
			updateY = 0,
			updateX = 0,
			objLayer = event.originapPosition===undefined ? t.getLayer(event) : t.getLayer(t.selectedLayerSerial),
			_tw = totalWidth,
			_th = totalHeight;
		
		
		jQuery('#layer_text_wrapper').removeClass("currently_editing_txt");
		t.toolbarInPos(objLayer);

		var old = objLayer.p_uid;

		if (htmlLayer.parent().attr('id')==="divLayers") 			
			objLayer.p_uid = -1;

		if (old!==-1 && objLayer.p_uid!==-1) {
			// NO NEED TO CHANGE THE LAYER POSITION AND STYLE
		} else 
		if (old!=objLayer.p_uid) {
			if (objLayer.type==="row" || objLayer.p_uid!==-1 && t.getObjLayerType(objLayer.p_uid)==="column") 
				punchgs.TweenLite.set(htmlLayer,{left:"auto",right:"auto",top:"auto",bottom:"auto",display:"inline-block",position:"relative"});							
			else 
				punchgs.TweenLite.set(htmlLayer,{display:"block",position:"absolute"});				

		}
		
		if (objLayer.p_uid!==-1 && t.getObjLayerType(objLayer.p_uid)==="group") {
			_tw = t.getLayerByUniqueId(objLayer.p_uid).references.htmlLayer.width();
			_th = t.getLayerByUniqueId(objLayer.p_uid).references.htmlLayer.height();
		}
						
		if (ui.offsetX!==undefined && event.originalPosition!==undefined && t.groupMove.sameGroup.length>0) {		
			var dif = {x:(event.originalPosition.left - event.position.left), y: (event.originalPosition.top - event.position.top)}			
			for (var k=0;k<t.groupMove.sameGroup.length;k++) {
				var sgl = t.groupMove.sameGroup[k];
				punchgs.TweenLite.set(sgl.references.htmlLayer,{left:sgl.positionCache.left - dif.x, top:sgl.positionCache.top - dif.y});
			}
		}


		switch(t.getVal(objLayer,'align_hor')){
			case "left":
				updateX = posLeft;
			break;
			case "right":
				updateX = _tw - posLeft - selectedLayerWidth;
			break;
			case "center":
				updateX = posLeft - Math.round((_tw - selectedLayerWidth)/2);				
				updateX = Math.round(updateX);
			break;
			case "left":
			default:
				updateX = posLeft;
			break;
		}

		switch(t.getVal(objLayer,'align_vert')){
			case "bottom":
				updateY = _th - posTop - selectedlayerHeight;
			break;
			case "middle":
				updateY = posTop - Math.round((_th - selectedlayerHeight)/2);
				updateY = Math.round(updateY);
			break;
			case "top":
			default:
				updateY = posTop;
			break;
		}

		if (objLayer.p_uid!==-1 && t.getObjLayerType(objLayer.p_uid)==="column") {
			updateX = 0;
			updateY = 0;			
		} 

		
	
		jQuery('#layer_left').val(updateX+"px");
		jQuery('#layer_top').val(updateY+"px");

		if (ui==="ende") {
			var objUpdate = {};			
			objUpdate = t.setVal(objUpdate, 'left', updateX);
			objUpdate = t.setVal(objUpdate, 'top', updateY);
			objUpdate = t.setVal(objUpdate, 'width', selectedLayerWidth);
			objUpdate = t.setVal(objUpdate, 'height', selectedlayerHeight);		

			// event == layerSerial !!

			t.updateLayer(event,objUpdate);			
			t.updateHtmlLayerPosition(false,objLayer,t.getVal(objUpdate, 'top'),t.getVal(objUpdate, 'left'),t.getVal(objLayer,'align_hor'),t.getVal(objLayer,'align_vert'));
			
			if(isLayerSelected(event))			
				t.updateLayerFormFields(event);

		}
		

	}

	/**
	 * Get Object Layer  Type
	 */
	t.getObjLayerType = function(unique_id) {
		var o = t.getLayerByUniqueId(unique_id);
		if (o.type)
			return o.type
		else
			return false;		
	}


	

//======================================================
//		Events Functions End
//======================================================




	//======================================================
	//	Scale Functions
	//======================================================
		/**
		 * calculate image height/width
		 */

		var scaleAndResetLayerInit = function(){


			jQuery("#layer_scaleX").change(function(){
				if(jQuery("#layer_proportional_scale")[0].checked)
					scaleProportional(true);
				else
					scaleNormal();
			});

			jQuery("#layer_scaleY").change(function(){
				if(jQuery("#layer_proportional_scale")[0].checked)
					scaleProportional(false);
				else
					scaleNormal();
			});
			
			jQuery("#layer_video_width").change(function(){

				if(jQuery("#layer_proportional_scale")[0].checked)
					scaleProportionalVideo(true);
				else
					scaleNormalVideo();
			});

			jQuery("#layer_video_height").change(function(){
				if(jQuery("#layer_proportional_scale")[0].checked)
					scaleProportionalVideo(false);
				else
					scaleNormalVideo();
			});
			
			jQuery("#layer_proportional_scale").click(function(){
				var objLayer = t.getLayer(t.selectedLayerSerial);				
				if(this.checked){
					jQuery('#layer_cover_mode option[value="custom"]').attr('selected', true);
					jQuery('.rs-proportion-check').removeClass('notselected');
					if (objLayer.type==="video" || objLayer.type==="audio")
						scaleProportionalVideo(false);
					else
					if (objLayer.type==="image") {						
						scaleProportional(true);
					}
					
				}else{
					jQuery('.rs-proportion-check').addClass('notselected');
					if (objLayer.type==="video" || objLayer.type==="audio")
						scaleNormalVideo(false);
					else
					if (objLayer.type==="image")
						scaleNormal();
					
				}
				t.setLayerResizable(objLayer);			
			});


			// AUTO LINE BREAK on/off
			jQuery("#layer_auto_line_break").click(function(){				
				t.clickOnAutoLineBreak();				
			});

			

			jQuery("#layer_displaymode").click(function(){
				if(jQuery(this)[0].checked){
					jQuery("#layer_display option[value='block']").attr('selected', 'selected');
				} else {
					jQuery("#layer_display option[value='inline-block']").attr('selected', 'selected');
				}
			});

			jQuery('#layer_cover_mode').change(function(){
				t.set_cover_mode();
			});

			jQuery("#reset-scale, #button_reset_size").click(resetCurrentElementSize);
			
		}

		t.clickOnAutoLineBreak = function() {
				var serial = t.selectedLayerSerial;
				var layer = jQuery("#slide_layer_" + serial);
				var objLayer = t.getLayer(t.selectedLayerSerial);

				if(jQuery("#layer_auto_line_break")[0].checked){
					jQuery('.rs-linebreak-check').removeClass('notselected');					
					jQuery("#layer_whitespace option[value='normal']").attr('selected', 'selected');
					
					var mw = layer.outerWidth()+1,
						mh = layer.outerHeight()+1;
					layer.css({height:"auto"});
					layer.find('.innerslide_layer.tp-caption').first().css({maxHeight:"none",minHeight:mh,maxWidth:mw});
					jQuery('#layer_max_width').val(mw+"px");
					jQuery('#layer_max_height').val("auto");
				}else{
					jQuery('.rs-linebreak-check').addClass('notselected');										
					jQuery("#layer_whitespace option[value='nowrap']").attr('selected', 'selected');
					jQuery('#layer_max_width').val("auto");
					jQuery('#layer_max_height').val("auto");
					layer.css({width:"auto"});
					layer.find('.innerslide_layer.tp-caption').first().css({maxHeight:"none",minHeight:"none",maxWidth:"none"});
				}
				t.updateLayerFromFields();
			}

		var resetCurrentElementSize = function() {
			var objLayer = t.getLayer(t.selectedLayerSerial);
			
				if (objLayer.type == "shape") {
					return false;
				}else /*if (objLayer.type == "no_edit") {
					return false;
				}else*/ 
				if (objLayer.type == 'svg') {
					//reset svg size
					return false;
				}else if (objLayer.type == 'audio') {
					return false;
				}else if (objLayer.type=="text" || objLayer.type=="button") {
					var ww = jQuery('.slide_layer.layer_selected .innerslide_layer').first().outerWidth();
					if (parseInt(jQuery("#layer_max_width").val(),0)>ww) {
						ww = ww === undefined ? "auto" : ww+"px"
						jQuery("#layer_max_width").val("auto");
					}
					jQuery("#layer_max_height").val("auto");
					
					
				} else {
					if (objLayer.type == "image") {						
						jQuery('#layer_cover_mode option[value="custom"]').attr('selected', true);
					}
					
					var rsdimensions = resetImageDimensions();					
					jQuery("#layer_proportional_scale").attr('checked', true);
					//jQuery('.rs-proportion-check').addClass('notselected');
	
					jQuery("#layer_scaleX_text").html(jQuery("#layer_scaleX_text").data("textnormal")).css("width", "10px");
					
					var mwidth = objLayer.image_librarysize !=undefined ?  objLayer.image_librarysize.width : rsdimensions['width'],
						mheight = objLayer.image_librarysize !=undefined ?  objLayer.image_librarysize.height :rsdimensions['height'];

					
					jQuery("#layer_scaleX").val(mwidth);
					jQuery("#layer_scaleY").val(mheight);
					

					jQuery("#slide_layer_" + t.selectedLayerSerial + " img").css("width", mwidth);
					jQuery("#slide_layer_" + t.selectedLayerSerial + " img").css("height", mheight);					
				}
				
				t.updateLayerFromFields();			
		}

		var scaleProportional = function(useX){
			var serial = t.selectedLayerSerial;

			resetImageDimensions();

			var imgObj = new Image(),
				x,y,suffixX,suffixY,v;
			
			imgObj.src = jQuery("#slide_layer_" + serial + " img").attr("src");
			
			
			if(useX){
				v = jQuery("#layer_scaleX").val();
				x = parseFloat(v),
				suffixX = v.replace(x,"");				
				if(isNaN(x))
					x = suffixX==="%" ? 100 : imgObj.width;				
				y = suffixX==="%" ? "auto" : Math.round(100 / imgObj.width * x / 100 * imgObj.height, 0);
				suffixY = "";

			}else{
				v = jQuery("#layer_scaleY").val();
				y = parseFloat(v);
				suffixY = v.replace(y,"");
				if(isNaN(y)) 
					y = suffixY==="%" ? 100 : imgObj.height;				
				x = suffixY==="%" ? "auto" : Math.round(100 / imgObj.height * y / 100 * imgObj.width, 0);
				suffixX = "";
			}

			jQuery("#slide_layer_" + serial + " img").css("width", x + suffixX);
			jQuery("#slide_layer_" + serial + " img").css("height", y + suffixY);

			jQuery("#slide_layer_" + serial).css("width", jQuery("#slide_layer_" + serial + " img").width() + suffixX);
			jQuery("#slide_layer_" + serial).css("height", jQuery("#slide_layer_" + serial + " img").height() + suffixY);


			jQuery("#slide_layer_" + serial + " img").css("width", "100%");
			jQuery("#slide_layer_" + serial + " img").css("height", "100%");

			jQuery("#layer_scaleX").val(x+suffixX);
			jQuery("#layer_scaleY").val(y+suffixY);
		}
		
		var scaleNormal = function(){

			var serial = t.selectedLayerSerial,
				imgdims = resetImageDimensions(),
				layer = jQuery("#slide_layer_" + serial),
				ww = jQuery("#layer_scaleX").val(),
				hh = jQuery("#layer_scaleY").val();

			
			ww = jQuery.isNumeric(ww) ? ww+"px" : ww;
			hh = jQuery.isNumeric(hh) ? hh+"px" : hh;



			punchgs.TweenLite.set(layer,{width:ww,height:hh});
			punchgs.TweenLite.set(layer.find('.innerslide_layer').first(),{width:ww,height:hh});
			punchgs.TweenLite.set(layer.find('img'),{width:ww,height:hh});			
		}

		/**
		 * Scale Videos to the choosen proportion on width/height change
		 * @since: 5.0
		 **/
		var scaleProportionalVideo = function(useX){
			var serial = t.selectedLayerSerial,
				cur_video = jQuery("#slide_layer_" + serial).find('.slide_layer_video');

			if(useX){
				var x = parseInt(jQuery("#layer_video_width").val());
				if(isNaN(x)) x = cur_video.width();
				var y = Math.round(100 / cur_video.width() * x / 100 * cur_video.height(), 0);
			}else{
				var y = parseInt(jQuery("#layer_video_height").val());
				if(isNaN(y)) y = cur_video.height();
				var x = Math.round(100 / cur_video.height() * y / 100 * cur_video.width(), 0);
			}

			
			cur_video.css("width", x + "px");
			cur_video.css("height", y + "px");
			
			jQuery("#slide_layer_" + serial).css("width", x + "px");
			jQuery("#slide_layer_" + serial).css("height", y + "px");

			jQuery("#layer_video_width").val(x);
			jQuery("#layer_video_height").val(y);
		}

		var scaleNormalVideo = function(){
			var serial = t.selectedLayerSerial,
				cur_video = jQuery("#slide_layer_" + serial).find('.slide_layer_video'),
				ww = jQuery("#layer_video_width").val(),
				hh = jQuery("#layer_video_height").val();
			
			ww = jQuery.isNumeric(ww) ? ww+"px" : ww;
			hh = jQuery.isNumeric(hh) ? hh+"px" : hh;

			cur_video.css("width", ww);
			cur_video.css("height", hh);

			jQuery("#slide_layer_" + serial).css("width", ww);
			jQuery("#slide_layer_" + serial).css("height", hh);

		}
		
		
		var resetImageDimensions = function(){
			var imgObj = new Image();
			imgObj.src = jQuery("#slide_layer_" + t.selectedLayerSerial + " img").attr("src");
			jQuery("#slide_layer_" + t.selectedLayerSerial).css("width", imgObj.width + "px");
			jQuery("#slide_layer_" + t.selectedLayerSerial).css("height", imgObj.height + "px");

			var imgdims = {width:imgObj.width, height:imgObj.height};
			return imgdims;
		}

	//======================================================
	//	Scale Functions End
	//======================================================

	t.getLayerGeneralParamsStatus = function(){
		return layerGeneralParamsStatus;
	}

	//======================================================
	//	Main Background Image Functions
	//======================================================





	t.startKenBurn =  function(prgs) {

		var l = jQuery('#ken_burn_example'),
			d = l.data(),
			i = l.find('.defaultimg'),
			s = d.lastsrc,
			i_a = d.owidth / d.oheight,
			cw = l.width(),
			ch = l.height(),
			c_a = cw / ch;

		
		if (l.data('kbtl'))
			l.data('kbtl').kill();
		
		prgs = prgs || 0;
	
		if (s===undefined) return;

		l.find('.tp-kbimg').remove();

		

		// NO KEN BURN IMAGE EXIST YET
		if (l.find('.tp-kbimg').length==0) {
			l.append('<div class="tp-kbimg-wrap" style="z-index:2;width:100%;height:100%;top:0px;left:0px;position:absolute;"><img class="tp-kbimg" src="'+s+'" style="position:absolute;" width="'+d.owidth+'" height="'+d.oheight+'"></div>');
			l.data('kenburn',l.find('.tp-kbimg'));
		}

		var getKBSides = function(w,h,f,cw,ch,ho,vo) {			
					var tw = w * f,
						th = h * f,
						hd = Math.abs(cw-tw),
						vd = Math.abs(ch-th),
						s = new Object();
					s.l = (0-ho)*hd;
					s.r = s.l + tw;			
					s.t = (0-vo)*vd;
					s.b = s.t + th;	
					s.h = ho;
					s.v = vo;

					
					return s;
				},

			getKBCorners = function(d,cw,ch,ofs,o) {

				var p = d.bgposition.split(" ") || "center center",
					ho = p[0] == "center"  ? "50%" : p[0] == "left" || p [1] == "left" ? "0%" : p[0]=="right" || p[1] =="right" ? "100%" : p[0],
					vo = p[1] == "center" ? "50%" : p[0] == "top" || p [1] == "top" ? "0%" : p[0]=="bottom" || p[1] =="bottom" ? "100%" : p[1];
				
				ho = parseInt(ho,0)/100 || 0;
				vo = parseInt(vo,0)/100 || 0;


				var sides = new Object();


				sides.start = getKBSides(o.start.width,o.start.height,o.start.scale,cw,ch,ho,vo);
				sides.end = getKBSides(o.start.width,o.start.height,o.end.scale,cw,ch,ho,vo);
							
				return sides;	
			},

			kcalcL = function(cw,ch,d) {				
				var f=d.scalestart/100,
					fe=d.scaleend/100,
					ofs = d.offsetstart != undefined ? d.offsetstart.split(" ") || [0,0] : [0,0],
					ofe = d.offsetend != undefined ? d.offsetend.split(" ") || [0,0] : [0,0];
				d.bgposition = d.bgposition == "center center" ? "50% 50%" : d.bgposition;
				
				
				var o = new Object(),
					sw = cw*f,
					sh = sw/d.owidth * d.oheight,
					ew = cw*fe,
					eh = ew/d.owidth * d.oheight;		


				

				o.start = new Object();		
				o.starto = new Object();
				o.end = new Object();
				o.endo = new Object();
				
				o.start.width = cw;
				o.start.height = o.start.width / d.owidth * d.oheight;		

				if (o.start.height<ch) {
					var newf = ch / o.start.height;
					o.start.height = ch;
					o.start.width = o.start.width*newf;
				}
				o.start.transformOrigin = d.bgposition;					
				o.start.scale = f;	
				o.end.scale = fe;

				o.start.rotation = d.rotatestart+"deg";
				o.end.rotation = d.rotateend+"deg";		
				
				// MAKE SURE THAT OFFSETS ARE NOT TOO HIGH
				var c = getKBCorners(d,cw,ch,ofs,o);

				

				ofs[0] = parseFloat(ofs[0]) + c.start.l;
				ofe[0] = parseFloat(ofe[0]) + c.end.l;
				
				ofs[1] = parseFloat(ofs[1]) + c.start.t;			
				ofe[1] = parseFloat(ofe[1]) + c.end.t;
					
				var iws = c.start.r - c.start.l,
					ihs	= c.start.b - c.start.t,
					iwe = c.end.r - c.end.l,
					ihe	= c.end.b - c.end.t;
				
				
				// X (HORIZONTAL)
				
				ofs[0] = ofs[0]>0 ? 0 : iws + ofs[0] < cw ? cw-iws : ofs[0];
				ofe[0] = ofe[0]>0 ? 0 : iwe + ofe[0] < cw ? cw-iwe : ofe[0];
				o.starto.x = ofs[0]+"px";
				o.endo.x = ofe[0]+"px";
				
				// Y (VERTICAL)
				ofs[1] = ofs[1]>0 ? 0 : ihs + ofs[1] < ch ? ch-ihs : ofs[1];
				ofe[1] = ofe[1]>0 ? 0 : ihe + ofe[1] < ch ? ch-ihe : ofe[1];
				o.starto.y = ofs[1]+"px";				
				o.endo.y = ofe[1]+"px";	

				

				
				
				

				o.end.ease = o.endo.ease = d.ease;
				o.end.force3D = o.endo.force3D = true;
				return o;
			};
		
		if (l.data('kbtl')!=undefined) {
			l.data('kbtl').kill();
			l.removeData('kbtl');
		}

		var k = l.data('kenburn'),
			kw = k.parent(),
			anim = kcalcL(cw,ch,d),
			kbtl =  new punchgs.TimelineLite();
		
		
		kbtl.pause();
		
		anim.start.transformOrigin = "0% 0%";
		anim.starto.transformOrigin = "0% 0%";	
		
		kbtl.add(punchgs.TweenLite.fromTo(k,d.duration/1000,anim.start,anim.end),0);
		kbtl.add(punchgs.TweenLite.fromTo(kw,d.duration/1000,anim.starto,anim.endo),0);
			
		kbtl.progress(prgs);
		if (jQuery('#kenburn-playpause-wrapper').hasClass("playing")) 
			kbtl.play(0);	
		else
			kbtl.pause();
		
		kbtl.eventCallback("onComplete", function() {
			kbtl.play(0);
		});
		l.data('kbtl',kbtl);														
	}		


	t.updateKenBurnExampleValues = function() {
		var img = new Image(),
			nsrc = jQuery('#ken_burn_slot_example').data('src'),
			lsrc = jQuery('#ken_burn_example').data('lastsrc'),
			inloadalready = jQuery('#ken_burn_slot_example').data('inload');
		
		if (!inloadalready) {

			if (nsrc!==lsrc) {
				jQuery('#ken_burn_slot_example').data('inload',true)
				img.onload = function() {												 							
					jQuery('#ken_burn_example').data({
						lastsrc: this.src,
						owidth:this.width,
						oheight:this.height,
						bgposition:jQuery('#slide_bg_position').val(), 
						duration:parseInt(jQuery('#kb_duration').val(),0), 
						rotatestart: parseInt(jQuery('#kb_start_rotate').val(),0), 
						rotateend: parseInt(jQuery('#kb_end_rotate').val(),0),
						scalestart: parseInt(jQuery('#kb_start_fit').val(),0), 
						scaleend: parseInt(jQuery('#kb_end_fit').val(),0),
						offsetstart: jQuery('#kb_start_offset_x').val()+" "+jQuery('#kb_start_offset_y').val(),
						offsetend: jQuery('#kb_end_offset_x').val()+" "+jQuery('#kb_end_offset_y').val(),
						ease:jQuery('#kb_easing').val()
					});		
					jQuery('#ken_burn_slot_example').data('inload',false)		
					t.startKenBurn();				
				}
				img.onerror = function() {				
					console.log("Ken Burn Demo Image could not be Loaded");
				}
				img.onabort = function() {				
					console.log("Ken Burn Demo Image could not be Loaded");
				}
				img.src = nsrc;
			} else {
				jQuery('#ken_burn_example').data({
					lastsrc: jQuery('#ken_burn_slot_example').data('src'),
					owidth:jQuery('#ken_burn_example').data('owdith'),
					oheight:jQuery('#ken_burn_example').data('oheight'),
					bgposition:jQuery('#slide_bg_position').val(), 
					duration:parseInt(jQuery('#kb_duration').val(),0), 
					rotatestart: parseInt(jQuery('#kb_start_rotate').val(),0), 
					rotateend: parseInt(jQuery('#kb_end_rotate').val(),0),
					scalestart: parseInt(jQuery('#kb_start_fit').val(),0), 
					scaleend: parseInt(jQuery('#kb_end_fit').val(),0),
					offsetstart: jQuery('#kb_start_offset_x').val()+" "+jQuery('#kb_start_offset_y').val(),
					offsetend: jQuery('#kb_end_offset_x').val()+" "+jQuery('#kb_end_offset_y').val(),
					ease:jQuery('#kb_easing').val()
				});		
				t.startKenBurn();
			}
		}
		
	}

	var buildKenBurnExample = function() {
		var wrapper = jQuery('#ken_burn_example'),
			swrapper = jQuery('#ken_burn_slot_example'),
			c = jQuery('#divLayers'),
			newh = (wrapper.width() / c.width())*c.height();
		
		wrapper.css({height:newh+"px"});
		t.updateKenBurnExampleValues();


	}
	var initBackgroundFunctions = function(){
		jQuery('body').on('change', 'select[name="layer_target[]"]', function(){
			jQuery(this).data('selectoption', jQuery(this).find('option:selected').val());
			
			
			//update do-layer-animation-overwrite and do-layer-trigger-memory
			var dataAnim = t.getAnimTimingAndTrigger(jQuery(this).find('option:selected').val());
			
			jQuery(this).closest('li').find('select[name="do-layer-animation-overwrite[]"] option[value="'+dataAnim['animation_overwrite']+'"]').attr('selected', true);
			jQuery(this).closest('li').find('select[name="do-layer-trigger-memory[]"] option[value="'+dataAnim['trigger_memory']+'"]').attr('selected', true);
		});
		jQuery('body').on('change', 'select[name="jump_to_slide[]"]', function(){
			jQuery(this).data('selectoption', jQuery(this).find('option:selected').val());
		});
		
		
		jQuery('body').on('change', 'select[name="do-layer-animation-overwrite[]"]', function(){
			var do_sel = jQuery(this).closest('li').find('select[name="layer_target[]"] option:selected').val();
			var new_val = jQuery(this).val();
			
			var lid = t.getLayerIdByUniqueId(do_sel);
			
			var objUpdate = {};
			
			objUpdate.animation_overwrite = new_val;
			
			update_layer_changes = false;
			t.updateLayer(lid,objUpdate);
			update_layer_changes = true;
			
			jQuery('select[name="layer_target[]"] option:selected').each(function(){
				if(jQuery(this).val() == do_sel){
					jQuery(this).closest('li').find('select[name="do-layer-animation-overwrite[]"] option[value="'+new_val+'"]').attr('selected', true);
				}
			});
		});
		
		
		jQuery('body').on('change', 'select[name="do-layer-trigger-memory[]"]', function(){
			var do_sel = jQuery(this).closest('li').find('select[name="layer_target[]"] option:selected').val();
			var new_val = jQuery(this).val();
			var lid = t.getLayerIdByUniqueId(do_sel);
			
			var objUpdate = {};
			
			objUpdate.trigger_memory = new_val;
			
			update_layer_changes = false;
			t.updateLayer(lid,objUpdate);
			update_layer_changes = true;
			
			jQuery('select[name="layer_target[]"] option:selected').each(function(){
				if(jQuery(this).val() == do_sel){
					jQuery(this).closest('li').find('select[name="do-layer-trigger-memory[]"] option[value="'+new_val+'"]').attr('selected', true);
				}
			});
		});
		
		jQuery('#slide_bg_fit').change(function(){
			if(jQuery(this).val() == 'percentage'){
				jQuery('input[name="bg_fit_x"]').show();
				jQuery('input[name="bg_fit_y"]').show();

				jQuery('#divbgholder').css('background-size', jQuery('input[name="bg_fit_x"]').val()+'% '+jQuery('input[name="bg_fit_y"]').val()+'%');
			}else{
				jQuery('input[name="bg_fit_x"]').hide();
				jQuery('input[name="bg_fit_y"]').hide();

				jQuery('#divbgholder').css('background-size', jQuery(this).val());
			}


			if(jQuery(this).val() == 'contain'){
				jQuery('#divLayers-wrapper').css('maxWidth', jQuery('#divbgholder').css('minWidth'));
			}else{
				jQuery('#divLayers-wrapper').css('maxWidth', '100%');
			}
			
			
		});
		jQuery('#slide_bg_fit').change();

		jQuery('input[name="bg_fit_x"]').change(function(){
			jQuery('#divbgholder').css('background-size', jQuery('input[name="bg_fit_x"]').val()+'% '+jQuery('input[name="bg_fit_y"]').val()+'%');
		});

		jQuery('input[name="bg_fit_y"]').change(function(){
			jQuery('#divbgholder').css('background-size', jQuery('input[name="bg_fit_x"]').val()+'% '+jQuery('input[name="bg_fit_y"]').val()+'%');
		});

		jQuery('#slide_bg_position').change(function(){
			if(jQuery(this).val() == 'percentage'){
				jQuery('input[name="bg_position_x"]').show();
				jQuery('input[name="bg_position_y"]').show();

				jQuery('#divbgholder').css('background-position', jQuery('input[name="bg_fit_x"]').val()+'% '+jQuery('input[name="bg_fit_y"]').val()+'%');
			}else{
				jQuery('input[name="bg_position_x"]').hide();
				jQuery('input[name="bg_position_y"]').hide();

				jQuery('#divbgholder').css('background-position', jQuery(this).val());
			}
			
		});

		jQuery('input[name="bg_position_x"]').change(function(){
			jQuery('#divbgholder').css('background-position', jQuery('input[name="bg_position_x"]').val()+'% '+jQuery('input[name="bg_position_y"]').val()+'%');
		});

		jQuery('input[name="bg_position_y"]').change(function(){
			jQuery('#divbgholder').css('background-position', jQuery('input[name="bg_position_x"]').val()+'% '+jQuery('input[name="bg_position_y"]').val()+'%');
		});

		jQuery('#slide_bg_repeat').change(function(){
			jQuery('#divbgholder').css('background-repeat', jQuery(this).val());		
		});

		jQuery('input[name="kenburn_effect"]').change(function(){
			
			if(jQuery(this)[0].checked){
				jQuery('#kenburn_wrapper').show();
				//jQuery('#bg-position-lbl').hide();
				//jQuery('#bg-start-position-wrapper').children().appendTo(jQuery('#bg-start-position-wrapper-kb'));
				//jQuery('#bg-setting-wrap').hide();

				jQuery('#divbgholder').css('background-repeat', '');
				jQuery('#divbgholder').css('background-position', '');
				jQuery('#divbgholder').css('background-size', '');

				jQuery('input[name="kb_start_fit"]').change();

				jQuery('#divLayers-wrapper').css('maxWidth', 'none');

				jQuery('#slide_bg_position').change();
				jQuery('#bg-setting-bgfit-wrap').css({display:"none"});
				jQuery('#bg-setting-bgrep-wrap').css({display:"none"});
				jQuery('#bg-setting-bgpos-wrap').prependTo('#kenburn_wrapper');
				buildKenBurnExample();
			}else{
				jQuery('#kenburn_wrapper').hide();
				//jQuery('#bg-position-lbl').show();
				//jQuery('#bg-start-position-wrapper-kb').children().appendTo(jQuery('#bg-start-position-wrapper'));
				//jQuery('#bg-setting-wrap').show();

				jQuery('#slide_bg_repeat').change();
				jQuery('#slide_bg_position').change();
				jQuery('#slide_bg_fit').change();
				jQuery('#bg-setting-bgfit-wrap').show();
				jQuery('#bg-setting-bgrep-wrap').show();
				jQuery('#bg-setting-bgpos-wrap').appendTo('#bg-setting-bgpos-def-wrap');
				if(jQuery('#slide_bg_fit').val() == 'contain'){
					jQuery('#divLayers-wrapper').css('maxWidth', jQuery('#divbgholder').css('minWidth'));
				}else{
					jQuery('#divLayers-wrapper').css('maxWidth', '100%');
				}
			}
			t.changeSlotBGs();
		});
		jQuery('input[name="kenburn_effect"]:checked').change();


		// MEDIA FILTER CHANGES		
		jQuery('body').on('mouseenter','.inst-filter-griditem',function() {
			punchgs.TweenLite.to(jQuery(this).find('.inst-filter-griditem-img'),0.5,{autoAlpha:0});
		})
		jQuery('body').on('mouseleave','.inst-filter-griditem',function() {
			punchgs.TweenLite.to(jQuery(this).find('.inst-filter-griditem-img'),0.5,{autoAlpha:1});
		});

		jQuery('body').on('click','.inst-filter-griditem',function() {
			var a = jQuery(this);
			jQuery('#media-filter-type option:selected').prop('selected',false);
			jQuery('#media-filter-type option[value="'+a.data("type")+'"]').attr('selected','selected');
			jQuery('.inst-filter-griditem.selected').removeClass("selected")
			a.addClass("selected");
			jQuery('.oldslotholder').attr("class","oldslotholder "+a.data("type"));
			jQuery('.slotholder').attr("class","slotholder "+a.data("type"));
		});

		// SET CURRENT FILTER
		var mediafilter = jQuery('#media-filter-type option:selected').val();
		if (mediafilter!==undefined) {
			jQuery('.inst-filter-griditem.selected').removeClass("selected");
			jQuery('.inst-filter-griditem.filter_'+mediafilter).addClass("selected");
			jQuery('.oldslotholder').attr("class","oldslotholder "+mediafilter);
			jQuery('.slotholder').attr("class","slotholder "+mediafilter);
		}
		// END OF MEDIA FILTER CHANGES

		



		jQuery('#slide_bg_end_position').change(function(){
			if(jQuery(this).val() == 'percentage'){
				jQuery('input[name="bg_end_position_x"]').show();
				jQuery('input[name="bg_end_position_y"]').show();
			}else{
				jQuery('input[name="bg_end_position_x"]').hide();
				jQuery('input[name="bg_end_position_y"]').hide();
			}
		});


		jQuery('input[name="kb_start_fit"]').change(function(){
			var fitVal = parseInt(jQuery(this).val());
			var limg = new Image();
			limg.onload = function() {
				calculateKenBurnScales(fitVal, limg.width, limg.height, jQuery('#divbgholder'));
			}

			var urlImage = '';
			if(jQuery('#radio_back_image')[0].checked)
				urlImage = jQuery("#image_url").val();
			else if(jQuery('#radio_back_external')[0].checked)
				urlImage = jQuery("#slide_bg_external").val();

			if(urlImage != ''){
				limg.src = urlImage;
			}
			t.changeSlotBGs();
		});

		var calculateKenBurnScales = function(proc,owidth,oheight,opt) {
		   var ow = owidth;
		   var oh = oheight;


		   var factor = (opt.width() /ow);
		   var factorh = (opt.height() / oh);

		 //  if (factor>=1) {

				var nheight = oh * factor;
				proc = proc + "%";
				var hfactor = "auto"; //(nheight / opt.height())*proc;
			/*} else {

				var nwidth = "auto" //ow * factorh;
				var hfactor = proc+"%";
				proc = "auto";
				//proc = (nwidth / opt.width()) * proc;

			}*/

		   jQuery('#divbgholder').css('background-size', proc+" "+hfactor);
			t.changeSlotBGs();		   
		}

		jQuery("#layer_resize-full").change(function(){
			if(!jQuery(this)[0].checked){
				jQuery('#layer_resizeme').prop('checked', false);
				RevSliderSettings.onoffStatus(jQuery("#layer_resizeme"));
			}
		});
		
		jQuery("#layer_resizeme").change(function(){
			if(jQuery(this)[0].checked){
				jQuery('#layer_resize-full').prop('checked', true);
				RevSliderSettings.onoffStatus(jQuery("#layer_resize-full"));
			}
		});
		
		
		jQuery(window).resize(function(){
			if(jQuery('input[name="kenburn_effect"]:checked').val() == 'on'){
				var fitVal = parseInt(jQuery('input[name="kb_start_fit"]').val());
				var limg = new Image();
				limg.onload = function() {
					calculateKenBurnScales(fitVal, limg.width, limg.height, jQuery('#divbgholder'));
				}

				var urlImage = '';
				if(jQuery('#radio_back_image')[0].checked)
					urlImage = jQuery("#image_url").val();
				else if(jQuery('#radio_back_external')[0].checked)
					urlImage = jQuery("#slide_bg_external").val();

				if(urlImage != ''){
					limg.src = urlImage;
				}				
			}
			t.setObjectLibraryHeight();
			
		});
	}

	//======================================================
	//	Main Background Image Functions End
	//======================================================

	var initLoopFunctions = function(){

		jQuery('select[name="layer_loop_animation"]').change(function(){
			showHideLoopFunctions();
		});

		jQuery('#layer_static_start').change(function(){
			changeEndStaticFunctions();
		});
	}

	var showHideLoopFunctions = function(){

		jQuery('select[name="layer_loop_animation"]').each(function(){
			jQuery("#layer_easing_wrapper").hide();
			jQuery("#layer_speed_wrapper").hide();
			jQuery("#layer_parameters_wrapper").hide();
			jQuery("#layer_degree_wrapper").hide();
			jQuery("#layer_origin_wrapper").hide();
			jQuery("#layer_x_wrapper").hide();
			jQuery("#layer_y_wrapper").hide();
			jQuery("#layer_zoom_wrapper").hide();
			jQuery("#layer_angle_wrapper").hide();
			jQuery("#layer_radius_wrapper").hide();

			switch(jQuery(this).val()){
				case 'none':
				break;
				case 'rs-pendulum':
					jQuery("#layer_easing_wrapper").show();
					jQuery("#layer_speed_wrapper").show();
					jQuery("#layer_parameters_wrapper").show();
					jQuery("#layer_degree_wrapper").show();
					jQuery("#layer_origin_wrapper").show();
				break;
				case 'rs-rotate':
					jQuery("#layer_easing_wrapper").show();
					jQuery("#layer_speed_wrapper").show();
					jQuery("#layer_parameters_wrapper").show();
					jQuery("#layer_degree_wrapper").show();
					jQuery("#layer_origin_wrapper").show();
				break;

				case 'rs-slideloop':
					jQuery("#layer_easing_wrapper").show();
					jQuery("#layer_speed_wrapper").show();
					jQuery("#layer_parameters_wrapper").show();
					jQuery("#layer_x_wrapper").show();
					jQuery("#layer_y_wrapper").show();
				break;
				case 'rs-pulse':
					jQuery("#layer_easing_wrapper").show();
					jQuery("#layer_speed_wrapper").show();
					jQuery("#layer_parameters_wrapper").show();
					jQuery("#layer_zoom_wrapper").show();
				break;
				case 'rs-wave':
					jQuery("#layer_speed_wrapper").show();
					jQuery("#layer_parameters_wrapper").show();
					jQuery("#layer_angle_wrapper").show();
					jQuery("#layer_radius_wrapper").show();
					jQuery("#layer_origin_wrapper").show();
				break;
			}
		});
	}

	var changeEndStaticFunctions = function(){

		jQuery('#layer_static_start').each(function(){
			var cur_att = parseInt(jQuery(this).val());
			var cur_end = jQuery('#layer_static_end option:selected').val();
			var go_max_up_to = parseInt(jQuery('#layer_static_start option:last-child').val());

			jQuery('#layer_static_end').empty();

			for(var cur=cur_att+ 1; cur<=go_max_up_to; cur++){
				jQuery("#layer_static_end").append('<option value="'+cur+'">'+cur+'</option>');
			}
			jQuery("#layer_static_end").append('<option value="last">'+rev_lang.last_slide+'</option>');

			jQuery("#layer_static_end option[value='"+cur_end+"']").attr('selected', 'selected');
		});
	}
	
	t.get_current_selected_layer = function(){
		return t.selectedLayerSerial;
	}
	
	t.addPreventLeave = function(){
		/**
		 * warn the user if changes are made and not saved yet
		 */
		window.onbeforeunload = function (e) {
			if(save_needed){
				var message = rev_lang.leave_not_saved,
				e = e || window.event;
				// For IE and Firefox
				if (e) {
					e.returnValue = message;
				}

				// For Safari
				return message;
			}
		};
	} 
}