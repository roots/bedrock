
/*
	* LayerSlider Plugin: Debug
	*
	* (c) 2016 Kreatura Media
	*
	* LayerSlider web:		https://layerslider.kreaturamedia.com/
	* licenses:				http://codecanyon.net/licenses/standard
*/



(function($){

	window._layerSlider.plugins.debug = function( ls, $slider, sliderUID, userSettings ){

		var d = this,
			params = document.location.hash.split( '?' )[1],
			param,
			defaultKeys = {
				transitionduration: 	'transitionDuration',
				td: 					'transitionDuration',
				firstslide: 			'firstSlide',
				fs: 					'firstSlide',
				timeline: 				'timeline',
				tl: 					'timeline'
			},
			timeline = {
				namespace: 'timeline',
				js: 'timeline/layerslider.timeline.js',
				css: 'timeline/layerslider.timeline.css',
				settings: {
					showLayersInfo: true
				}
			},
			forceSliderSettings = {
					autoStart 					: false,
					startInViewport				: true,
					pauseOnHover				: 'looplayers',
					skin						: 'v6',
					navPrevNext					: true,
					navStartStop				: true,
					navButtons					: true,
					keybNav						: true,
					touchNav					: true,
					hoverPrevNext				: true,
					hoverBottomNav				: false,
					showBarTimer				: true,
					showCircleTimer				: true,
					thumbnailNavigation			: 'hover'
			};

		d.pluginData = {
			name: 'Debug Plugin for LayerSlider',
			version: '1.0.1',
			requiredLSVersion: '6.0.4',
			authorName: 'Kreatura',
			releaseDate: '2016. 11. 07.'
		};

		d.init = function(){
			ls.debugMode = true;
			ls.debug = ls.initializedPlugins.debug;
			$.extend( ls.o, forceSliderSettings );
		};

		d.options = {};

		if( params ){

			params = params.split( '&' );

			for( var p=0; p < params.length; p++ ){
				param = params[p].split( '=' );
				d.options[ defaultKeys[ $.trim( param[0].toLowerCase() ) ] ] = $.isNumeric( param[1] ) ? parseFloat( param[1] ) : $.trim( param[1] );
			}

			if( d.options.timeline ){
				ls.o.plugins.push( timeline );
				ls.o.pauseLayers = true;
			}
		}

		d.slider = 'LayerSlider(' + ( $( '.ls-container' ).index( $slider ) + 1 ) + '):';

		d.add = function( type, name, prop, forceCreateGroup ){

			if( name && name.indexOf('.') === -1 ){
				name += '.info';
			}

			var	groupName = name.split('.')[0],
				subName = name.split('.')[1],
				lng = d.lng[groupName];

			if( d.cache && type + groupName + subName !== d.cache ){
				d.showInfo();
			}

			if( typeof prop !== 'object' ){
				prop = [prop];
			}

			if( forceCreateGroup || type === 'group' ){
				if( d.lng[groupName].delay ){
					d.openedDelayedGroup = groupName;
					d.openedDelayedSub = subName;
					d.save( d.openedDelayedGroup, 'group', d.slider+' '+lng.n[subName].toUpperCase(), subName );
				}else{
					d.openedGroup = groupName;
					d.save( d.openedGroup, 'group', d.slider+' '+lng.n[subName].toUpperCase() );
				}
			}

			if( type === 'log' ){
				d.set( type, d.lng[groupName].l[subName], prop, groupName, subName );
			}else if( type === 'warn' ){
				d.set( type, d.lng[groupName].w[subName], prop, groupName, subName );
			}

			if( forceCreateGroup ){
				d.groupEnd( name );
			}
		};

		d.groupEnd = function( name ){

			if( name && name.indexOf('.') === -1 ){
				name += '.info';
			}

			var	groupName = name ? name.split('.')[0] : false,
				subName = name ? name.split('.')[1] : false;

			if( d.cache ){
				d.showInfo();
			}
			if( groupName && groupName === d.openedDelayedGroup && d.lng[d.openedDelayedGroup].delay ){
				d.save( d.openedDelayedGroup, 'groupEnd', false, d.openedDelayedSub );
				delete d.openedDelayedGroup;
				delete d.openedDelayedSub;
			}else{
				d.save( d.openedGroup, 'groupEnd', false, subName );
				delete d.openedGroup;
			}
		};

		d.set = function( type, lng, prop, groupName, subName ){

			var	curProp,
				msg;

			switch( type ){

				case 'log':
					for( var p=0; p<prop.length; p++ ){

						curProp = prop[p];
						msg = lng[p];

						if( typeof curProp !== 'undefined' ){
							if( typeof curProp !== 'object' ){
								curProp = [curProp];
							}
							for( var o=0; o<curProp.length; o++ ){
								msg = msg.replace( '$'+o, curProp[o] );
							}
							d.save( groupName, type, msg, subName );
						}
					}
				break;

				case 'warn':
					msg = lng[0];
					for( var p=0; p<prop.length; p++ ){
						msg = msg.replace( '$'+p, prop[p] );
					}
					d.save( groupName, type, msg, subName );

					if( lng[1] ){
						msg = lng[1];

						for( var p=0; p<prop.length; p++ ){
							msg = msg.replace( '$'+p, prop[p] );
						}

						d.cache = 'warn' + groupName + subName;
						d.showInfo = function(){
							d.save( groupName, 'info', msg, subName );
							delete d.cache;
							delete d.showInfo;
						};
					}
				break;
			}
		};

		d.save = function( groupName, type, msg, subName ){

			if( !d.lng[groupName].delay ){
				d.show( groupName, type, msg );
			}else{
				if( !d.collector ){
					d.collector = {};
				}
				if( !d.collector[subName] || type === 'group' ){
					d.collector[subName] = [];
				}
				d.collector[subName].push( [type,msg] );

				clearTimeout( d.debugTimeout );
				d.debugTimeout = setTimeout(function(){
					d.show( d.openedDelayedGroup, type, false, true );
				}, d.lng[groupName].delay );
			}
		};

		d.show = function( groupName, type, msg, delayed ){

			if( !d.extension ){
				d.extension = [];
			}

			if( delayed ){
				var p;
				for( var key in d.collector ){
					for( var f=0; f<d.collector[key].length; f++ ){
						p = d.collector[key][f];
						console[p[0]]( p[1] );
						d.extension.push( [type,p[1]] );
					}
				}

				delete d.collector;
			}else{
				if( !msg && type === 'groupEnd' ){
					console[type]();
					d.extension.push( [type] );
				}else{
					console[type]( msg );
					d.extension.push( [type,msg] );
				}
			}
		};

		d.lng = {

			sliderInit: {
				n: {
					info: 'Initial slider data',
					style: 'Initial slider style'
				},
				l: {
					info: [
						'Plugin version: $0',
						'Release Date: $0',
						'Slider version: $0',
						'Slider id attribute: #$0',
						'Unique slider ID: $0',
						'jQuery version: $0',
						'WordPress Plugin Version: $0',
						'WordPress version: $0',
					],
					style: [
						'Width: $0px',
						'Height: $0px',
						'Original width: $0',
						'Original height: $0',
						'layersContainerWidth: $0px',
						'layersContainerHeight: $0px',
						'Ratio of slider width & height: $0',
						'Maximum Width: $0px',
						'Margin left & right: $0, $1'
					],
					customTransitions: [
						'layerSliderCustomTransitions object found. Custom slide transitions are loaded.'
					]
				},
				w: {
					margin: [
						'Originally detected horizontal margins ($0px) are converted to "auto".',
						'Margins of slider element should be specified in the element style attribute and not in external CSS file or in inline <style> element!'
					],
					noWidth: [
						'Slider has no initial width specified!',
						'Setting slider width to layersContainerWidth ($0px).'
					],
					noHeight: [
						'Slider has no initial height specified!',
						'Setting slider height to layersContainerHeight ($0px).'
					],
					noWidth2: [
						'Neighter initial width nor layersContainerWidth width specified!',
						'Setting slider width to element.clientWidth ($0px).'
					],
					noHeight2: [
						'Neighter initial height nor layersContainerHeight specified!',
						'Setting slider height to element.parent.clientHeight ($0px).'
					],

					responsive: [
						'Slider type is "$0", but it has percentage intial height: $1!',
						'Setting slider height to element.parent.clientHeight ($2px).'
					],

					fullsize: [
						'Slider type is "$0" and it has percentage intial width: $1!',
						'Converting percentage width to: $2px, (slider parent width is: $3px, layersContainerWidth is: $4px).'
					],
					fullsize2: [
						'Slider type is "$0" and it has percentage intial height: $1!',
						'Converting percentage height to: $2px, (window.height is: $3px, layersContainerHeight is: $4px).'
					],

					fullwidth: [
						'Slider type is "fullwidth", but it has no responsiveUnder property specified!',
						'Setting responsiveUnder to layersContainerWidth ($0px).'
					],
					fullwidth2: [
						'Slider type is "$0", but it has percentage intial height: $1!',
						'Converting percentage height to: $2px (regarding to element.parent.clientHeight).'
					],

					percWidth: [
						'Slider type is "$0", but it has percentage intial width: $1!',
						'Setting slider width to element.clientWidth ($2px)!'
					],

					conWidth: [
						'Slider type is "$0" and it has no layersContainerWidth property specified!',
						'Setting layersContainerWidth to sliderWidth ($1px).'
					],
					conHeight: [
						'Slider type is "$0" and it has no layersContainerHeight property specified!',
						'Saving layersContainerHeight to sliderHeight ($1px).'
					],
					conWidth2: [
						'Slider type is "$0" and it has unnecessary layersContainerWidth property: $1px!'
					],
					conHeight2: [
						'Slider type is "$0" and it has unnecessary layersContainerHeight property: $1px!'
					],

					bgCover: [
						'Slider type is "$0" and it has no backgroundSize property specified!',
						'Setting backgroundSize to "auto".'
					],
					slideTransitions: [
						'layerSliderTransitions object not found. Possible issue: layerslider.transitions.js file is not loaded.'
					],
					customTransitions: [
						'Slide $0 has custom transitions specified, but layerSliderCustomTransitions object not found! Using default - transition2d: 1 - slide transition. Possible issue: layerslider.customtransitions.js file is not loaded.'
					],
					noSlideTransitions: [
						'layerSliderTransitions or layerSliderCustomTransitions objects not found. Skipping slide transitions. Possible issue: layerslider.transitions.js and layerslider.customtransitions.js files are not loaded.'
					]
				}
			},

			layerInit: {
				n: {
					info: 'Initializing layers...'
				},
				w: {
					splitType1: [
						'Layer Init: A $0 layer on slide $1 which with children element(s) has text transition property! Possible issues: \r\n- the whole layer is invisible\r\n- parts of the layer are invisible\r\n- appearance (layer style) is wrong'
					],
					splitType2: [
						'Layer Init: An image or media layer on slide $0 has text transition property. $1 layer could not be splitted, ignoring.'
					],
					splitType3a: [
						'Layer Init: $0 layer has wrong texttypein property: $1',
						'Skipping text transition in on this layer.'
					],
					splitType3b: [
						'Layer Init: $0 layer has wrong texttypeout property: $1',
						'Skipping text transition out on this layer.'
					],
					prop1: [
						'Layer Init: Detected multiple property values in a non text transition related property: $0',
						'Original value: $1 -> converted to: $2'
					],
					prop2: [
						'Layer Init: Detected the following property with no value: $0'
					],
					prop3: [
						'Layer Init: Detected mistyped(?) comma character inside the value of property name $0: $1',
						'Cycled properties in text transitions must be separated with: | character.'
					],
					prop4: [
						'Layer Init: Unknown property name in layer data-ls: $0'
					]
				}
			},

			preload: {
				n: {
					info: 'Preload'
				},
				l: {
					info: [
						'Starting preload images of slide $0'
					],
					success: [
						'preloaded: $0'
					]
				},
				w: {
					fail: [
						'NOT preloaded: $0',
						'Possible issue: Wrong file name or URL!'
					]
				}
			},

			slideshow: {
				n: {
					info: 'Slideshow'
				},
				l: {
					inviewport: [
						'STARTINVIEWPORT: At least half of the slider is in viewport, starting layer transitions after preload...'
					],
					change: [
						'Current side index: $0',
						'Next slide index: $0',
						'Slideshow direction: $0',
						'Navigation direction: $0'
					],
					changedByUser: [
						'Changed by user'
					],
					setdir: [
						'Switching slideshow direction to: $0'
					]
				},
				w: {
					invalidSlideIndex: [
						'Tried to change to an invalid slide index: $0, (total number of slides: $1)'
					]
				}
			},

			resize: {
				delay: 250,
				n: {
					info: 'Resize layers',
					window: 'User Event: Viewport is resized!'
				},
				l: {
					window: [
						'New viewport width: $0px'
					]
				},
				w: {
					width: [
						'Layer[$0] has wrong original width property: $1'
					],
					height: [
						'Layer[$0] has wrong original height property: $1'
					]				}
			},

			slideTransition: {
				n: {
					info: 'Slide Transition'
				},
				l: {
					info: [
						'Type: $0',
						'Id: $0',
						'Name: $0'
					],
					properties: [
						'Cols * Rows: $0 * $1',
						'Total number of tiles: $0'
					]
				},
				w: {
					customTransition: [
						'The following $0 slide transition with ID $1 is not found. Using default - transition2d: 1 - slide transition.'
					],
					noSlideTransition: [
						'layerSliderTransitions or layerSliderCustomTransitions objects not found! Skipping slide transition on slide $0.'
					]
				}
			},

			layerTransition: {
				n: {
					info: 'Layer Transition'
				},
				w: {
					infinite: [
						'Warning: layer $0 has wrong timing properties which would cause an infinite loop!'
					],
					timing1: [
						'Wrong timing name: $0'
					],
					timing2: [
						'Calculated timing error of $0 property: $2',
						'Original value was: $1$2 -> will be 0'
					],
					timing3: [
						'Timing hierarchy does not match: $0[$1] <-> $2[$3]'
					]
				}
			},

			slideTimeline: {
				n: {
					info: 'Slide Timeline'
				},
				w: {
					restart: [
						'Slide Timeline: at least one layer on the current slide has loop offset x, loop offset y or clip transition.',
						'Slide timeline restart on resize is: $0'
					],
					duration: [
						'Slide Timeline: user specified slide duration is less than calculated ( $0s < $1s )!',
						'Some layer transitions may not visible before slide change'
					]
				}
			}
		};
	};

})(jQuery, undefined);