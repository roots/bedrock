
/*
	* LayerSlider Plugin: Timeline
	*
	* (c) 2016 Kreatura Media
	*
	* LayerSlider web:		https://layerslider.kreaturamedia.com/
	* licenses:				http://codecanyon.net/licenses/standard
*/



(function($){

	window._layerSlider.plugins.timeline = function( ls, $slider, sliderUID, userSettings ){

		var cl = this;

		cl.pluginData = {
			name: 'Timeline Plugin for LayerSlider',
			version: '1.0.2',
			requiredLSVersion: '6.0.0',
			authorName: 'Kreatura',
			releaseDate: '2016. 11. 07.'
		};

		cl.pluginDefaults = {

			eventNamespace: 'LSCT',
			showCurrentTime: true,
			showLayersInfo: true
		};

		cl.init = function(){

			this.applySettings();
			this.createMarkup();
			this.createEvents();
		};

		cl.applySettings = function(){

			this.settings = $.extend( true, {}, this.pluginDefaults, userSettings );
		};

		cl.createMarkup = function(){

			var	$isTimelineElement = $( '[data-timeline-for="' + $slider.attr( 'id' ) + '"]' );

			this.removeElement = $isTimelineElement.length ? false : true;
			this.$timelineElement = $isTimelineElement.length ? $isTimelineElement : $( '<div>').css({ maxWidth: $slider[0].style.maxWidth }).insertAfter( $slider );
			this.$strechedElement = $( '<div>' ).addClass( 'ls-timeline-streched' ).appendTo( this.$timelineElement );
			this.$infoElement = $( '<div>' ).addClass( 'ls-timeline-layer-info' ).appendTo( this.$timelineElement );
			this.$layerTweensWrapper = $( '<div>' ).addClass( 'ls-layer-tweens-wrapper' ).appendTo( this.$strechedElement );
			this.$timingsWrapper = $( '<div>' ).addClass( 'ls-timings-wrapper' ).appendTo( this.$strechedElement );

			this.$timelineElement.addClass( 'ls-slide-timeline ' + ( this.settings.showLayersInfo ? 'ls-show-layer-info' : '' ) );
			this.$strechedElement.append( $( '<div data-slidebar-for="' + sliderUID + '"></div>') );

			if( this.settings.showCurrentTime ){
 				this.$currentTimeElement = $( '<div>' ).addClass( 'ls-current-time' );
			}

			this.$legendWrapper = $( '<div class="ls-timeline-legend"><span class="ls-tl-leg">legend</span><span class="ls-tl-leg-delay">delay</span><span class="ls-tl-leg-in">in</span><span class="ls-tl-leg-out">out</span><span class="ls-tl-leg-textin">text in</span><span class="ls-tl-leg-textout">text out</span><span class="ls-tl-leg-loop">loop / middle</span><span class="ls-tl-leg-static">static</span></div>' ).appendTo( this.$timelineElement );
		};

		cl.round = function( value, decimal ){

			decimal = decimal ? decimal *= 10 : 1000;
			return Math.round( value * decimal ) / decimal;
		};

		cl.createEvents = function(){

			$slider.on( 'sliderDidLoad', function( event, data ){

				if( cl.settings.showCurrentTime ){
					cl.$strechedElement.find( '.ls-slidebar-slider' ).append( cl.$currentTimeElement );
				}
			}).on( 'slideTimelineDidCreate', function( event, data ){

				cl.slideTimelineDuration = data.slideTimelineDuration;
				cl.slideTimelineDurationRatio = data.slideTimeline.duration() < data.slideTimelineDuration ? 1 : cl.slideTimelineDuration / data.slideTimeline.duration();

				var	layersOnSlideTimeline = data.layersOnSlideTimeline.filter( ':not( .ls-bg )' ),
					layersCount = layersOnSlideTimeline.length,
					percent = cl.slideTimelineDuration / 100,
					secPercent,
					$layer,
					layerData,
					layerTweens = [],
					$layerTweens,
					$layerTweensInner,
					$layerInfo,
					staticLeft,
					loopEnd,
					className;

				cl.$layerTweensWrapper.empty();
				cl.$timingsWrapper.empty();
				cl.$infoElement.empty();

				for( var s=0; s<Math.floor(cl.slideTimelineDuration)+1; s++ ){
					secPercent = s * ( 100 / cl.slideTimelineDuration );
					secPercent = secPercent > 100 ? 100 : secPercent;
					className = secPercent >= 99 ? ' ls-timeline-seconds-last' : '';
					$( '<div class="ls-timeline-seconds' + className + '"><div class="ls-timeline-sec">' + s + 's</div></div>').css({
						left: secPercent + '%'
					}).appendTo( cl.$timingsWrapper );
					if( secPercent >= 100 ){
						break;
					}
				}

				for( var ds=1; ds<cl.slideTimelineDuration * 10; ds++ ){
					secPercent = ds * ( 100 / ( cl.slideTimelineDuration * 10 ) );
					secPercent = secPercent > 100 ? 100 : secPercent;
					if( ds%10 !== 0 ){
						$( '<div class="ls-timeline-dsecond"></div>').css({
							left: secPercent + '%'
						}).appendTo( cl.$timingsWrapper );
					}
					if( secPercent >= 100 ){
						break;
					}
				}

				for( var l=0; l<layersCount; l++ ){

					var	hoverEl = '',
						innerText;

					$layer = layersOnSlideTimeline.eq(l);

					layerData = $layer.data( ls.defaults.init.dataKey );

					// Creating markup
					$layerTweens = $( '<div>' ).addClass( 'ls-layer-tweens' ).data( 'lsTweensOfLayer', $layer ).prependTo( cl.$layerTweensWrapper );
					$layerTweensInner = $( '<div>' ).addClass( 'ls-layer-tweens-inner' ).appendTo( $layerTweens );

					if( cl.settings.showLayersInfo ){

						$layerInfo = $( '<div>' ).data( 'ls', {
							$layer: $layer,
							layerData: layerData,
							$outerWrapper: layerData.elements.$outerWrapper
						}).addClass( 'ls-layer-info' ).prependTo( cl.$infoElement ).on( 'mouseenter.' + cl.settings.eventNamespace, function(){

							$(this).data( 'ls' ).$outerWrapper.attr( 'id', 'ls-wrapper-highlighted' );

						}).on( 'mouseleave.' + cl.settings.eventNamespace, function(){

							$(this).data( 'ls' ).$outerWrapper.removeAttr( 'id' );
						});

						if( $layer.is( 'img') ){
							$layerInfo.append( $('<div><a href="' + $layer.attr( 'src' ) + '" target="_blank"></a></div>').css({
								backgroundImage: 'url(' + $layer.attr( 'src' ) + ')'
							}) );
						}

						if( $layer[0].src ){
							hoverEl = '<address>' + $layer[0].src + '</address>';
						}

 						if( $layer.children().first().length && $layer.children().first().is( 'iframe, video, audio' ) ){
							innerText = 'MEDIA LAYER';
 						}else{
 							innerText = $layer[0].innerText;
 						}

						$layerInfo.append( '<h1>' + hoverEl + $layer[0].tagName + '<span>' + innerText + '</span></h1> ' );
					}


					// Transition in
					if( !layerData.is.static || ls.slides.next.index === layerData.settings.slideIn ){
						$( '<div>' ).appendTo( $layerTweensInner ).addClass( 'ls-layer-tween ls-layer-transition-in' ).css({
							left: cl.round( layerData.timeline.transitioninstart ) / percent + '%',
							width: cl.round( layerData.timeline.transitioninend - layerData.timeline.transitioninstart ) / percent + '%'
						});
						if( layerData.timeline.transitioninstart > 0 ){
							$( '<div>' ).appendTo( $layerTweensInner ).addClass( 'ls-layer-tween ls-layer-delay-in' ).css({
								left: 0,
								width: cl.round( layerData.timeline.transitioninstart ) / percent + '%'
							});
						}
					}

					// Text transition in
					$( '<div>' ).appendTo( $layerTweensInner ).addClass( 'ls-layer-tween ls-layer-text-in' ).css({
						left: cl.round( layerData.timeline.textinstart ) / percent + '%',
						width: cl.round( layerData.timeline.textinend - layerData.timeline.textinstart ) / percent + '%'
					});

					// Loop transition
					loopEnd = layerData.loop.count === -1 ? cl.slideTimelineDuration : layerData.timeline.loopend;

					$( '<div>' ).appendTo( $layerTweensInner ).addClass( 'ls-layer-tween ls-layer-loop' ).css({
						left: cl.round( layerData.timeline.loopstart ) / percent + '%',
						width: cl.round( loopEnd - layerData.timeline.loopstart ) / percent + '%'
					});

					// Text transition out
					$( '<div>' ).appendTo( $layerTweensInner ).addClass( 'ls-layer-tween ls-layer-text-out' ).css({
						left: cl.round( layerData.timeline.textoutstart * 1000 ) / 1000 / percent + '%',
						width: cl.round( ( layerData.timeline.textoutend - layerData.timeline.textoutstart ) * 1000 ) / 1000 / percent + '%'
					});

					// Transition out
					if( ls.slides.next.index === layerData.settings.slideOut ){
						$( '<div>' ).appendTo( $layerTweensInner ).addClass( 'ls-layer-tween ls-layer-transition-out' ).css({
							left: cl.round( layerData.timeline.transitionoutstart ) / percent + '%',
							width: cl.round( layerData.timeline.transitionoutend - layerData.timeline.transitionoutstart ) / percent + '%'
						});
					}

					// Static layer
					if( layerData.is.static ){
						if( ls.slides.next.index === layerData.settings.slideOut ){

							var staticClass = layerData.out.startAt === 'slidechangeonly' ? 'static' : 'showuntil';

							$( '<div>' ).appendTo( $layerTweensInner ).addClass( 'ls-layer-tween ls-layer-' + staticClass ).css({
								left: 0,
								width: layerData.timeline.staticto === '100%' ?  layerData.timeline.staticto : cl.round( layerData.timeline.transitionoutstart ) / percent + '%'
							});
						}else{
							$( '<div>' ).appendTo( $layerTweensInner ).addClass( 'ls-layer-tween ls-layer-static' ).css({
								left: cl.round( layerData.timeline.staticfrom ) / percent + '%',
								width: '100%'
							});
						}
					}else{
						$( '<div>' ).appendTo( $layerTweensInner ).addClass( 'ls-layer-tween ls-layer-showuntil' ).css({
							left: cl.round( layerData.timeline.transitioninend ) / percent + '%',
							width: cl.round( layerData.timeline.transitionoutstart - layerData.timeline.transitioninend ) / percent + '%'
						});
					}
				}

				// IF: no layers on slide
				if( layersCount === 0 ){
					$( '<div class="ls-layer-info no-layers"><h1>No layers found</h1></div>' ).prependTo( cl.$infoElement );
				}

			}).on( 'slideTimelineDidUpdate', function( event, data ){

				var currentTime;

				if( cl.settings.showCurrentTime ){

					currentTime = ( parseInt( cl.slideTimelineDuration / cl.slideTimelineDurationRatio * data.progress() * 1000 ) / 1000 );
					if( currentTime !== currentTime ){ currentTime = 0; }
					cl.$currentTimeElement.text( currentTime.toFixed(3) );
				}
			}).on( 'sliderDidDestroy', function(){

				cl.api.destroy();
			});
		};

		cl.api = {

			destroy: function(){
				// CLEAR: events
				$( window ).add( 'body' ).add( $slider ).add( $slider.find( '*') ).add( cl.$timelineElement ).add( cl.$timelineElement.find( '*' ) ).off( '.' + cl.settings.eventNamespace );
				if( this.removeElement ){
					// REMOVE: timeline element from DOM
					cl.$timelineElement.remove();
				}else{
					cl.$timelineElement.empty();
				}
			}
		};
	};

})(jQuery, undefined);