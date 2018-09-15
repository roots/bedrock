/*

KM-UI script

*/

jQuery( function( $ ){

	window.kmUI  = {

		modal: {

			defaults: {
				width: 800,
				height: 800,
				padding: 40,
				animate: 'flip',
				direction: 'top',
				theme: 'light',
				overlay: true,
				clip: true,
				close: true,
				into: 'body',
				title: '',
				content: ''
			},

			settings: {},

			state: 'closed',

			open: function( id, settings ){

				if( kmUI.modal.state !== 'opened' && kmUI.modal.state !== 'opening' ){

					kmUI.modal.state = 'opening';

					// EXTEND: defaults with settings
					if( typeof id === 'object' && !settings ){ settings = id; }
					kmUI.modal.settings = $.extend( true, {}, kmUI.modal.defaults, settings );

					// SET: responsive sizes
					if( kmUI.modal.settings.width > $( window ).width() - 40 - kmUI.modal.settings.padding * 2 ){
						kmUI.modal.settings.width = $( window ).width() - 40 - kmUI.modal.settings.padding * 2;
					}
					if( kmUI.modal.settings.height > $( window ).height() - 40 - kmUI.modal.settings.padding * 2 ){
						kmUI.modal.settings.height = $( window ).height() - 40 - kmUI.modal.settings.padding * 2;
					}

					if( typeof id === 'object' ){
						var close = kmUI.modal.settings.close ? '<b class="dashicons dashicons-no"></b>' : '';
						kmUI.modal.$window = $( '<div class="km-ui-modal-window km-ui-element km-ui-theme-' + kmUI.modal.settings.theme + '"><div><header><h1>' + kmUI.modal.settings.title + '</h1>' + close + '</header><div class="km-ui-modal-scrollable">' + kmUI.modal.settings.content + '</div></div></div>' );
					}else{
						// CREATE: modal window object markup
						kmUI.modal.$window = $( '<div class="km-ui-modal-window km-ui-element km-ui-theme-' + kmUI.modal.settings.theme + '">' + $( id ).text() + '</div>' );
					}

					kmUI.modal.$window.prependTo( kmUI.modal.settings.into ).css({
						width: kmUI.modal.settings.width,
						height: kmUI.modal.settings.height,
						padding: kmUI.modal.settings.padding
					});

					kmUI.modal.$header = kmUI.modal.$window.find( 'header' );
					// SET: styles
					kmUI.modal.size = {
						width: kmUI.modal.$window.outerWidth(),
						height: kmUI.modal.$window.outerHeight()
					};

					kmUI.modal.position = {
						marginLeft: -kmUI.modal.size.width / 2,
						marginTop: -kmUI.modal.size.height / 2
					};

					padding = parseInt( kmUI.modal.$window.css( 'padding-left' ) );

					if( kmUI.modal.$header.length ){
						kmUI.modal.$header.find( 'h1' ).css({
							top: padding * 1.4
						});
					}

					if( kmUI.modal.settings.close ){
						kmUI.modal.$window.find( 'b' ).on( 'click.kmUI', function(){
							if( kmUI.modal.state === 'opened' ){
								kmUI.modal.close();
								if( kmUI.modal.settings.overlay ){
									kmUI.overlay.close();
								}
							}
						}).css({
							marginRight: padding,
							marginTop: padding * 1.4
						});
					}else{
						kmUI.modal.$window.find( 'b' ).remove();
					}

					kmUI.modal.$window.css( kmUI.modal.position ).find( '.km-ui-modal-scrollable' ).css({
						width: kmUI.modal.size.width - padding * 2,
						height: kmUI.modal.size.height - padding * 4,
						left: padding,
						right: padding,
						top: kmUI.modal.$header.length ? kmUI.modal.$header.outerHeight() + ( padding * 3 ) : padding,
						bottom: padding
					});

					// SHOW: modal window
					if( kmUI.modal.settings.animate ){
						kmUI.modal.animate( 'open' );
					}else{
						kmUI.modal.opened();
					}

					// HIDE: overflow
					if( kmUI.modal.settings.clip ){
						$( 'body, html' ).addClass( 'km-ui-overflow-hidden' );
					}

					// ADD: overlay
					if( kmUI.modal.settings.overlay ){
						var overlaySettings = {
							direction: kmUI.modal.settings.direction,
							close: kmUI.modal.settings.close,
							opener: 'modal',
							into: kmUI.modal.settings.into
						};
						if( typeof kmUI.modal.settings.overlayAnimate !== 'undefined' ){
							overlaySettings.animate = kmUI.modal.settings.overlayAnimate;
						}
						kmUI.overlay.open( overlaySettings );
					}

					return kmUI.modal.$window;
				}
			},

			animate: function( event ){

				if( event && event === 'open' ){

					var transition = kmUI.transitions( kmUI.modal.$window, kmUI.modal.settings.animate, kmUI.modal.settings.direction );

					kmUI.modal._timeline = new TimelineMax({
						onComplete: function(){
							kmUI.modal.opened();
						},
						onReverseComplete: function(){
							kmUI.modal.remove();
						}
					});

					kmUI.modal._timeline.fromTo(
						kmUI.modal.$window[0],
						0.75,
						{
							autoCSS: false,
							css: transition.from
						},{
							ease: Quint.easeInOut,
							audoCSS: false,
							css: transition.to
						}
					);

				}else if( kmUI.modal._timeline ){

					kmUI.modal._timeline.reverse();
				}
			},

			opened: function(){

				kmUI.modal.$window.addClass( 'km-ui-visible' );
				kmUI.modal.state = 'opened';
			},

			close: function(){

				if( kmUI.modal.settings.animate ){
					kmUI.modal.animate( 'close' );
				}else{
					kmUI.modal.remove();
				}

				if( kmUI.modal.settings.clip ){
					$( 'body, html' ).removeClass( 'km-ui-overflow-hidden' );
				}
			},

			remove: function(){

				if( kmUI.modal._timeline ){
					kmUI.modal._timeline.clear().kill();
					delete kmUI.modal._timeline;
				}
				kmUI.modal.$window.remove();
				kmUI.modal.state = 'closed';
			}
		},

		overlay: {

			defaults: {
				animate: 'flow',
				direction: 'top',
				theme: 'dark',
				opener: 'user',
				close: true,
				into: 'body'
			},

			settings: {},

			state: 'closed',

			open: function( settings ){

				if( kmUI.overlay.state !== 'opened' && kmUI.overlay.state !== 'opening' ){

					kmUI.overlay.state = 'opening';

					// EXTEND: defaults with settings
					kmUI.overlay.settings = $.extend( true, {}, kmUI.overlay.defaults, settings );

					// CREATE: overlay element
					kmUI.overlay.$element = $( '<div class="km-ui-overlay km-ui-element km-ui-theme-' + kmUI.overlay.settings.theme + '">' ).prependTo( kmUI.overlay.settings.into );

					if( kmUI.overlay.settings.close ){

						kmUI.overlay.$element.on( 'click.kmUI', function(){
							if( kmUI.overlay.settings.opener === 'modal' ){
								kmUI.modal.close();
							}
							kmUI.overlay.close();
						});
					}

					if( kmUI.overlay.settings.animate ){
						kmUI.overlay.animate( 'open' );
					}else{
						kmUI.overlay.opened();
					}
				}
			},

			animate: function( event ){

				if( event && event === 'open' ){

					var transition = kmUI.transitions( kmUI.overlay.$element, kmUI.overlay.settings.animate, kmUI.overlay.settings.direction );

					kmUI.overlay._timeline = new TimelineMax({
						onReverseComplete: function(){
							kmUI.overlay.remove();
						}
					});

					kmUI.overlay._timeline.fromTo(
						kmUI.overlay.$element[0],
						0.35, {
							autoCSS: false,
							css: transition.from
						},{
							autoCSS: false,
							ease: Quart.easeInOut,
							css: transition.to
						}
					);

				}else if( kmUI.overlay._timeline ){

					var timing = kmUI.overlay.settings.opener === 'modal' ? 0.4 : 0;
					kmUI.overlay._timeline.to( kmUI.overlay.$element[0], timing, {}).progress(1).reverse();
				}
			},

			opened: function(){

				kmUI.overlay.$element.addClass( 'km-ui-visible' );
				kmUI.overlay.state = 'opened';
			},

			close: function(){

				if( kmUI.overlay.settings.animate ){
					kmUI.overlay.animate( 'close' );
				}else{
					kmUI.overlay.remove();
				}
			},

			remove: function(){

				if( kmUI.overlay._timeline ){
					kmUI.overlay._timeline.clear().kill();
					delete kmUI.overlay._timeline;
				}
				kmUI.overlay.$element.remove();
				kmUI.overlay.state = 'closed';
			}
		},

		popover: {

			defaults: {
				width: 100,
				padding: 20,
				durationOpen: 500,
				durationClose: 400,
				theme: 'dark',
				animate: 'flip',
				direction: 'top',
				timeout: 0,
				distance: 0
			},

			init : function() {

				$( document ).on( 'mouseenter.kmUI', '[data-help]:not([data-help-disabled],[data-km-ui-popover-disabled],[data-km-ui-disabled])', function(event) {

					event.stopPropagation();

					var $el = $(this),
						delay = parseInt( $el.data('help-delay') ) || 1000;

					kmUI.popover.timeout = setTimeout( function(){
						kmUI.popover.close();
						kmUI.popover.open( $el );
					}, delay );
				});

				$( document ).on( 'mouseleave.kmUI', '[data-help]', function() {
					clearTimeout(kmUI.popover.timeout);
					kmUI.popover.close();
				});

				$( document ).on( 'click.kmUI', '[data-popover]', function() {
					kmUI.popover.close();
					kmUI.popover.open( this, true );
				});
			},

			destroy : function() {

				$( document ).off( 'mouseover.kmUI', '[data-help]');
				$( document ).off( 'mouseout.kmUI', '[data-help]');
			},

			open : function( el, po ) {

				var $el = $(el);

				// Waiting for hiding previous popover
				var delay = 0;

				setTimeout( function(){

					// Create popover
					var $popover = $('<div class="km-ui-popover"><div class="km-ui-popover-inner"></div><span></span></div>').prependTo('body'),
						duration = parseInt( $el.data( 'help-duration') ) || kmUI.popover.defaults.durationOpen,
						distance = parseInt( $el.data( 'km-ui-popover-distance') ) || kmUI.popover.defaults.distance;

					// Get popover
					$popover.data( 'tooltipCaller', $el);

					// Custom class
					if( $el.data('help-class') ) {
						$popover.addClass( $el.data( 'help-class' ) );
					}

					// Custom theme
					if( typeof $el.data( 'km-ui-popover-theme' ) != 'undefined' ){
						$popover.addClass( 'km-ui-theme-' + $el.data( 'km-ui-popover-theme' ) );
					}

					// Set popover text
					if( po ){
						if( typeof $el.data( 'popover' ) != 'undefined' ){
							$popover.addClass( 'km-ui-' + $el.data( 'popover' ) );
						}

						if( typeof $el.data( 'popover-dir') != 'undefined' ){
							$popover.addClass( 'km-ui-popover-direction-' + $el.data( 'popover-dir' ) );
						}

						$popover.find( '.km-ui-popover-inner' ).html( $el.siblings( '.ls-popover-data, .km-ui-popover-data' ).html() );

						$( document ).one( 'click.kmUI', function(){
							kmUI.popover.close();
						});
					}else{
						$popover.find('.km-ui-popover-inner').html( $el.data('help') );
					}

					// Get viewport dimensions
					var v_w = $( window ).width(),

					// Get element dimensions
					e_w = $el.outerWidth(),

					// Get element position
					e_l = $el.offset().left,
					e_t = $el.offset().top,

					// Get tooltip dimensions
					t_w = $popover.outerWidth(),
					t_h = $popover.outerHeight(),

					// Position popover
					top = $popover.hasClass( 'km-ui-direction-btm' ) ? e_t + $el.outerHeight() + 10 : e_t - t_h - 10,
					from = $popover.hasClass( 'km-ui-direction-btm' ) ? -10 : 30;

					if( $el.data( 'help-transition' ) !== false ) {
						TweenLite.set( $popover[0],{
							opacity: 0,
							top: top - distance,
							y: -from,
							left: e_l - (t_w - e_w) / 2,
							transformPerspective: 500,
							transformOrigin: '50% bottom',
							rotationX: 30
						});
						TweenLite.to( $popover[0], duration/1000,{
							opacity: 1,
							rotationX: 0,
							y: 0,
							ease: Back.easeOut
						});
					} else {
						$popover.css({
							top: top - from,
							left: e_l - (t_w - e_w) / 2
						});
					}

					// Fix right position
					if( $popover.offset().left + t_w > v_w ){

						$popover.css({
							left: 'auto',
							right: 10
						});

						$popover.find( 'span' ).css({
							left: 'auto',
							right: v_w - $el.offset().left - $el.outerWidth() / 2 - 17,
							marginLeft: 'auto'
						});
					}

					if( $el.data( 'km-ui-popover-autoclose' ) ){
						setTimeout( function(){
							kmUI.popover.close();
						}, parseInt( $el.data( 'km-ui-popover-autoclose' ) ) * 1000 );
					}
				}, delay);
			},

			close : function() {

				var $item = $( '.km-ui-popover' );

				if( $item.length ) {
					var $caller = $item.data( 'tooltipCaller' ),
						duration = $caller.data( 'help-duration' ) || kmUI.popover.defaults.durationClose,
						playOnlyOnce = $caller.data( 'km-ui-popover-once') || null;

					if( $caller.data( 'help-transition' ) !== false ) {
						$('.km-ui-popover:last').animate({
							opacity : 0
						}, duration / 2, function(){
							$(this).remove();
						});
					} else {
						$('.km-ui-popover:last').remove();
					}

					if( playOnlyOnce ){
						$caller.attr( 'data-km-ui-popover-disabled', 'true' );
					}
				}
			}
		},

		smartResize: {

			$elements: jQuery(),

			settings: {
				className: 'km-ui-cols-'
			},

			init: function( $el ){

				if( $el ){
					kmUI.smartResize.add( $el );
				}

				$( window ).on( 'resize.kmUI', function( event ){
					if( event.target === window ){
						kmUI.smartResize.set();
					}
				});

				kmUI.smartResize.set();
			},

			add: function( $el ){

				if( $el ){

					if( !( $el instanceof jQuery ) ){
						$el = $( $el );
					}

					kmUI.smartResize.put( $el );

				}else{

					$( 'body [data="km-ui-resize"]' ).each(function(){

						kmUI.smartResize.put( $(this) );
					});
				}
			},

			put: function( $el ){

				$el.data( 'km-ui-resize', $el.data( 'km-ui-resize').split( ',') );
				kmUI.smartResize.$elements = kmUI.smartResize.$elements.add( $el );
			},

			set: function(){

				kmUI.smartResize.$elements.each(function(){

					var	$this = $(this),
						width = $this.width(),
						resizeData = $this.data( 'km-ui-resize' ),
						curClass = kmUI.smartResize.settings.className + '1';

					if( resizeData ){

						var length = resizeData.length;

						curClass = kmUI.smartResize.settings.className + ( length + 1 );

						for( var r=0; r<length; r++ ){

							if( width < parseInt( resizeData[r] ) ){
								curClass = kmUI.smartResize.settings.className + ( r + 1 );
								break;
							}
						}
					}

					if(	!$this.hasClass( curClass ) ){
						$this.removeClass( $this.data( 'km-ui-resize-current-cols' ) || '' ).addClass( curClass );
						$this.data( 'km-ui-resize-current-cols', curClass );
					}
				});
			}
		},

		transitions: function( $el, type, direction ){

			var	defaults = {
					from: {
						opacity: 0,
						transformPerspective: 500,
						visibility: 'visible'
					},
					to: {
						x: 0,
						y: 0,
						opacity: 1,
						rotation: 0,
						rotationX: 0,
						rotationY: 0,
						scale: 1
					}
				},
				from ={};

			switch( type ){

				case 'flip':
					switch( direction ){
						case 'top':
							from = {
								rotationX: 5,
								y: -$el.height() / 4
							};
						break;
						case 'bottom':
							from = {
								rotationX: -5,
								y: $el.height() / 4
							};
						break;
						case 'left':
							from = {
								rotationY: -5,
								x: -$el.width() / 4
							};
						break;
						case 'right':
							from = {
								rotationY: 5,
								x: $el.width() / 4
							};
						break;
					}
				break;

				case 'flow':
					switch( direction ){
						case 'top':
							from = {
								opacity: 1,
								y: -$( window ).height()
							};
						break;
						case 'bottom':
							from = {
								opacity: 1,
								y: $( window ).height()
							};
						break;
						case 'left':
							from = {
								opacity: 1,
								x: -$( window ).width()
							};
						break;
						case 'right':
							from = {
								opacity: 1,
								x: $( window ).width()
							};
						break;
					}
				break;
			}

			return {
				from: $.extend( true, {}, defaults.to, defaults.from, from ),
				to: defaults.to
			};
		}
	};
});
