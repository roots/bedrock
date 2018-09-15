// Stores the database ID of
// currently editing slider.
var LS_sliderID = 0,


// Store the indexes of currently
// selected items on the interface.
LS_activeSlideIndex = 0,
LS_activeLayerIndexSet = [0],
LS_activeLayerPageIndex = 0,
LS_activeLayerTransitionTab = 0,
LS_activeScreenType = 'desktop',


// Stores all preview items using an object
// to easily add and modify items.
//
// NOTE: it's not a jQuery collection, but a
// collection of jQuery-enabled elements.
LS_previewItems = [],


// Object references, pointing to the currently selected
// slide/layer data. These are not working copies, any
// change made will affect the main data object. This makes
// possible to avoid issues caused by inconsistent data.
LS_activeSlideData = {},
LS_activeLayerDataSet = [],
LS_activeStaticLayersDataSet = [],


// These objects will be filled with the default slide/layer
// properties when needed. They purpose as a caching mechanism
// for bulk slide/layer creation.
LS_defaultSliderData = {},
LS_defaultSlideData = {},
LS_defaultLayerData = {},


// Stores all previous editing sessions
// to cache results and speed up operations.
LS_editorSessions = [],

// Flag for unsaved changes on site.
// We use this to display a warning
// for the user when leaving the page.
LS_editorIsDirty = false,


// Stores default UI settings of
// editing sessions.
LS_defaultEditorSession = {
	slideIndex: LS_activeSlideIndex,
	layerIndex: LS_activeLayerIndexSet,
	zoomSlider: 100,
	zoomAutoFit: true
},


// Stores temporary data for all
// copy & pate operations.
LS_clipboard = {},


// Stores the main UI elements
LS_previewZoom = 1,
LS_previewArea,
LS_previewHolder,
LS_previewWrapper,
LS_previewStatic,


LS_transformStyles = [
	'rotation',
	'rotationX',
	'rotationY',
	'scaleX',
	'scaleY',
	'skewX',
	'skewY'
];

var $lasso = jQuery();

// Utility functions to perform
// commonly used tasks.
var LS_Utils = {

	convertDateToUTC: function(date) {
		return new Date(
				date.getUTCFullYear(),
				date.getUTCMonth(),
				date.getUTCDate(),
				date.getUTCHours(),
				date.getUTCMinutes(),
				date.getUTCSeconds()
		);
	},

	dataURItoBlob: function(dataURI) {
		var binary = atob(dataURI.split(',')[1]);
		var array = [];
		for(var i = 0; i < binary.length; i++) {
			array.push(binary.charCodeAt(i));
		}
		return new Blob([new Uint8Array(array)], {type: 'image/png'});
	},

	moveArrayItem: function(array, from, to) {
		if( to === from ) return;

		var target = array[from];
		var increment = to < from ? -1 : 1;

		for(var k = from; k != to; k += increment){
			array[k] = array[k + increment];
		}
		array[to] = target;
	},


	toAbsoluteURL: function(url) {
		// Handle absolute URLs (with protocol-relative prefix)
		// Example: //domain.com/file.png
		if (url.search(/^\/\//) != -1) {
			return window.location.protocol + url;
		}

		// Handle absolute URLs (with explicit origin)
		// Example: http://domain.com/file.png
		if (url.search(/:\/\//) != -1) {
			return url;
		}

		// Handle absolute URLs (without explicit origin)
		// Example: /file.png
		if (url.search(/^\//) != -1) {
			return window.location.origin + url;
		}

		// Handle relative URLs
		// Example: file.png
		var base = window.location.href.match(/(.*\/)/)[0];
		return base + url;
	},

	// credits: http://phpjs.org/functions/strip_tags/
	stripTags: function(input, allowed) {

		allowed = (((allowed || '') + '')
			.toLowerCase()
			.match(/<[a-z][a-z0-9]*>/g) || [])
			.join('');
		var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
			commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
		return input.replace(commentsAndPhpTags, '')
			.replace(tags, function($0, $1) {
				return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
			});
	},

	// credits: http://phpjs.org/functions/nl2br/
	nl2br: function(str, is_xhtml) {
		var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display
		return (str + '')
			.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
	},

	// credits: http://stackoverflow.com/questions/3169786/clear-text-selection-with-javascript
	removeTextSelection: function() {
		var selection = window.getSelection ? window.getSelection() : document.selection ? document.selection : null;
		if(!!selection) selection.empty ? selection.empty() : selection.removeAllRanges();
	},

	// credits: http://locutus.io/php/stripslashes/
	stripslashes: function(str) {
	  return (str + '')
		.replace(/\\(.?)/g, function (s, n1) {
		switch (n1) {
			case '\\':
			  return '\\'
			case '0':
			  return '\u0000'
			case '':
			  return ''
			default:
			  return n1
		  }
		});
	}
};


var LS_GUI = {

	updateImagePicker: function( $picker, image ) {

		if( typeof $picker === 'string' ) {
			$picker = jQuery('input[name="'+$picker+'"]').next();
		}

		if( image === 'useCurrent' ) {
			image = $picker.find('img').attr('src');
		}

		if( image && image.indexOf('blank.gif') !== -1 ) {
			image = false;
		}

		$picker
			.removeClass('has-image not-set')
			.addClass( image ? 'has-image' : 'not-set' )
			.find('img').attr('src', image ||  lsTrImgPath+'/blank.gif' );
	}
};



// Slide specific undo & redo operations.
// Uses callbacks to run any code stored by
// other methods. Supports custom parameters.
var LS_UndoManager = {

	index: -1,
	stack: [],
	limit: 50,

	add: function(cmd, name, updateInfo) {

		// Invalidate items higher on the stack when
		// called from an undo-ed position
		this.stack.splice(this.index + 1, this.stack.length - this.index);
		this.index = this.stack.length - 1;

		// Maintain stack limit
		if(this.stack.length > this.limit) {
			this.stack.shift();
		}

		// Verify 'history' object in slide
		if(!LS_activeSlideData.hasOwnProperty('history')) {
			LS_activeSlideData.history = [];
		}

		// Prepare updateInfo
		this.prepareUpdateInfo( updateInfo );

		// Add item
		this.stack.push({
			cmd: cmd,
			name: name,
			updateInfo: updateInfo
		});

		// Maintain buttons and stack index
		this.index = this.stack.length - 1;
		this.maintainButtons();

		// Mark unsaved changes on page
		LS_editorIsDirty = true;
	},


	// Replace this.stack when switching slides
	// to support slide-specific history.
	update: function() {

		// Verify 'history' object in slide
		if(!LS_activeSlideData.hasOwnProperty('history')) {
			LS_activeSlideData.history = [];
		}

		this.stack = LS_activeSlideData.history;
		this.index = this.stack.length - 1;
		this.maintainButtons();
	},


	// Merges new changes into the last item in
	// the UndoManager stack.
	merge: function( cmd, name, updateInfo ) {
		var lastItem = this.stack[ this.stack.length - 1 ];
		this.prepareUpdateInfo( updateInfo );
		jQuery.extend(true, lastItem.updateInfo, updateInfo);
	},


	undo: function() {
		if(this.stack[this.index]) {
			this.execute('undo', this.stack[this.index]);
			this.index--;
			this.maintainButtons();
		}
	},


	redo: function() {
		if(this.stack[this.index+1]) {
			this.index++;
			this.execute('redo', this.stack[this.index]);
			this.maintainButtons();
		}
	},

	prepareUpdateInfo: function( updateInfo ) {

		if( updateInfo && typeof updateInfo === 'object') {
			jQuery.each(updateInfo, function(key, val) {

				if( typeof val === 'object') {
					LS_UndoManager.prepareUpdateInfo( val );
					return true;
				}

				if( val === null || typeof val === 'undefined') {
					updateInfo[key] = '';
				}
			});
		}
	},

	maintainButtons: function(itemIndex) {

		var undoButton = jQuery('.ls-editor-undo');
		var redoButton = jQuery('.ls-editor-redo');

		if(this.index !== -1) { undoButton.removeClass('disabled'); }
			else { undoButton.addClass('disabled'); }

		if(this.index < this.stack.length-1) { redoButton.removeClass('disabled'); }
			else { redoButton.addClass('disabled'); }
	},

	execute: function(action, item) {

		// Convert object to array to easily
		// handle multi-action steps.
		if( jQuery.type(item.updateInfo) === 'object' ) {
			item.updateInfo = [item.updateInfo];
		}

		// Iterate through actions in step.
		for(var c = 0; c < item.updateInfo.length; c++) {

			this.executeItem(
				item.cmd,
				item.updateInfo[c].itemIndex,
				item.updateInfo[c][action],
				item.updateInfo[c]
			);
		}
	},

	executeItem: function(command, itemIndex, updateInfo, item) {

		switch(command) {

			case 'slide.general':
				this.updateOptions(LS_activeSlideData.properties, itemIndex, updateInfo, 'slide');
				LayerSlider.updateSlideInterfaceItems();
				LayerSlider.generatePreview();
				break;


			case 'slide.layers':
				if(jQuery.isEmptyObject(updateInfo.data)) {
					LayerSlider.removeLayer(itemIndex, { histroyEvent: true, requireConfirmation: false });
				} else {
					LayerSlider.addLayer(updateInfo.data, itemIndex, { histroyEvent: true });
					LayerSlider.selectLayer( item.selectIndex );
				}
				LS_DataSource.buildLayersList();
				LayerSlider.generatePreview();
				break;


			case 'layer.order':
				LS_Utils.moveArrayItem(LS_activeSlideData.sublayers, updateInfo.from, updateInfo.to);
				LS_DataSource.buildLayersList();
				LayerSlider.generatePreview();
				break;


			case 'layer.general':
				this.updateOptions(LS_activeSlideData.sublayers[itemIndex], itemIndex, updateInfo);
				LayerSlider.updateLayerInterfaceItems(itemIndex);
				LayerSlider.generatePreviewItem(itemIndex);
				LayerSlider.updatePreviewSelection();
				break;


			case 'layer.transition':
				this.updateOptions(LS_activeSlideData.sublayers[itemIndex].transition, itemIndex, updateInfo);
				LayerSlider.generatePreviewItem(itemIndex);
				break;


			case 'layer.style':
				this.updateOptions(LS_activeSlideData.sublayers[itemIndex].styles, itemIndex, updateInfo);
				LayerSlider.generatePreviewItem(itemIndex);
				LayerSlider.updatePreviewSelection();
				break;
		}
	},


	// Iterates over the updateInfo object,
	// overrides the keys in the provided
	// data object.
	updateOptions: function( data, index, updateInfo, area ) {

		area = area || 'layers';
		var parent = (area === 'slide') ? '.ls-slide-options' : '.ls-layers-table';

		jQuery.each(updateInfo, function(key, val) {

			//if( data.hasOwnProperty(key) ) {

				if( typeof val === 'object' ) {
					LS_UndoManager.updateOptions( data[key], index, updateInfo[key], area);
					return true;
				}

				// Update data
				data[key] = val;

				// Handle UI if it's the active layer
				if( area === 'slide' || (LS_activeLayerIndexSet.length == 1 && index == LS_activeLayerIndexSet[0]) ) {

					var $target = jQuery(parent+' '+'[name="'+key+'"]'),
						eventType = 'input';

					$target.val(val).trigger('input').trigger('keyup');

					if($target.is(':checkbox')) {
						if(val) { $target.next().addClass('on').removeClass('off'); }
							else { $target.next().addClass('off').removeClass('on'); }
						return;

					} else if($target.is('select')) {
						eventType = 'change';
					}
					var jqEvent = jQuery.Event(eventType, { target: $target[0], UndoManagerAction: true });
					jQuery('#ls-layers').triggerHandler(jqEvent);
				}

			//}
		});
	},


	trackInputs: function( event, element ) {

		event = event || { type: 'change' };

		if( event.UndoManagerAction ) { return false; }

		var $input = jQuery(element),
			cmd, name, index;

		if( event.type.toLowerCase() == 'click' && $input.is('input,textarea') ) {
			return;
		}

		if( event.type.toLowerCase() !== 'change' ) {
			$input.data('prevVal', $input.val() );
			return;
		}

		// Skip colorpickers, as they rapidly send change events
		if( $input.hasClass('ls-colorpicker') ) {
			return;
		}

		if( $input.closest('.ls-sublayer-pages').length ) {
			cmd = 'layer.general';
			name = 'Layer settings';
			index = LS_activeLayerIndexSet[0];

			if($input.hasClass('sublayerprop')) { cmd = 'layer.transition'; }
				else if($input.hasClass('auto')) { cmd = 'layer.style'; }

		} else if( $input.closest('.ls-slide-options').length ) {
			cmd = 'slide.general';
			name = 'Slide settings';
			index = LS_activeSlideIndex;

		} else {
			return true;
		}

		var optionName 	= $input.attr('name'),
			optionValue = $input.is(':checkbox') ?   $input.prop('checked') : $input.val(),
			prevValue 	= $input.is(':checkbox') ? ! $input.prop('checked') : $input.data('prevVal'),
			action 		= $input.hasClass('undomanager-merge') ? 'merge': 'add';

		if( ! optionName ) {
			return false;
		}

		var undo = {}, redo = {};
			undo[ optionName ] = prevValue;
			redo[ optionName ] = optionValue;

		if( prevValue !== optionValue ) {

			LS_UndoManager[action](cmd, name, {
				itemIndex: index,
				undo: undo,
				redo: redo
			});
		}
	}
};


var LayerSlider = {

	uploadInput: null,
	dragIndex: 0,
	timeout: 0,
	mediaCheckTimeout: 0,
	isSlidePreviewActive: false,
	isLayerPreviewActive: false,
	selectableTimeout: 0,


	selectMainTab: function(el) {

		// Select new tab
		jQuery(el).addClass('active').siblings().removeClass('active');

		// Show new tab contents
		jQuery('#ls-pages .ls-page').removeClass('active');
		jQuery('#ls-pages .ls-page').eq( jQuery(el).index() ).addClass('active');

		// Init CodeMirror
		if(jQuery(el).hasClass('callbacks')) {
			if(jQuery('.ls-callback-page .CodeMirror-code').length === 0) {
				LS_CodeMirror.init({ mode: 'javascript', autofocus : false, styleActiveLine : false });
				jQuery(window).scrollTop(0);
			}
		}
	},


	selectSettingsTab: function(li) {
		var index = jQuery(li).index();
		jQuery(li).addClass('active').siblings().removeClass('active');
		jQuery('div.ls-settings-contents tbody.active').removeClass('active');
		jQuery('div.ls-settings-contents tbody').eq(index).addClass('active');
	},


	addSlide: function() {

		// Get default data objects for slides and layers
		var newSlideData = jQuery.extend(true, {}, LS_DataSource.getDefaultSlideData()),
			newLayerData = jQuery.extend(true, {}, LS_DataSource.getDefaultLayerData());
			newLayerData.subtitle = 'Layer #1';

		// Add new slide data to data source
		window.lsSliderData.layers.push({
			properties: newSlideData,
			sublayers: [newLayerData]
		});

		// Add new slide tab
		var newIndex 	= window.lsSliderData.layers.length + 1,
			tab 		= jQuery('<a href="#"><span>Slide #'+newIndex+'</span><img src="'+(pluginPath+'admin/img/blank.gif')+'"><span class="dashicons dashicons-dismiss"></span>').insertBefore('#ls-add-layer');

		// Name new slide properly
		LayerSlider.reindexSlides();
		LayerSlider.addSlideSortables();
		LS_activeLayerPageIndex = 0;

		// Show new slide, re-initialize
		// interactive features
		tab.click();
		LayerSlider.addLayerSortables();
	},


	removeSlide: function(el) {

		if(confirm('Are you sure you want to remove this slide?')) {

			// Get tab and menu item index
			var index = LS_activeSlideIndex;
			var $tab = jQuery(el).parent();
			var $newTab = null;

			// Open next or prev layer
			if($tab.next(':not(.unsortable)').length > 0) {
				$newTab = $tab.next();

			} else if($tab.prev().length > 0) {
				$newTab = $tab.prev();
			}

			// Remove tab and slide data
			window.lsSliderData.layers.splice(index, 1);
			$tab.remove();

			// Create a new slide if the last one
			// was removed
			if(window.lsSliderData.layers < 1) {
				LayerSlider.addSlide();
				return true;
			}

			// Select new slide. The .click() event will
			// maintain the active slide index and data.
			LayerSlider.reindexSlides();
			$newTab.click();
		}
	},


	selectSlide: function(slideIndex, selectProperties) {

		// Set selectProperties to an empty object by default
		selectProperties = selectProperties || {};

		// Bail out early if it's the currently active layer
		if( !selectProperties.forceSelect && LS_activeSlideIndex === slideIndex) { return false; }

		// Set active slide, highlight new tab
		jQuery('#ls-layer-tabs a')
			.eq(slideIndex)
			.addClass('active')
			.attr('data-help-disabled', '1')

			.siblings()
			.removeClass('active')
			.removeAttr('data-help-disabled');

		// Stop live preview
		LayerSlider.stopSlidePreview();
		LayerSlider.stopLayerPreview();

		// Set new slide index & data
		LS_activeSlideIndex = slideIndex;
		LS_activeSlideData = window.lsSliderData.layers[ slideIndex ];

		// Create the 'meta' object if not set
		if(!LS_activeSlideData.meta) {
			LS_activeSlideData.meta = {};
		}

		// Make sure to include new slide options in all cases
		var defaults = jQuery.extend( true, {}, LS_DataSource.getDefaultSlideData() );
		LS_activeSlideData.properties = jQuery.extend( true, defaults, LS_activeSlideData.properties );

		// Set active layer index set
		LS_activeLayerIndexSet = LS_activeSlideData.meta.activeLayers || [0];

		// Add static layers
		LS_activeStaticLayersDataSet = LayerSlider.staticLayersForSlide( slideIndex );

		// Build slide
		LS_DataSource.buildSlide();
		LayerSlider.generatePreview();
		LayerSlider.selectLayer(LS_activeLayerIndexSet);
		LayerSlider.updatePreviewSelection();
		LS_UndoManager.update();
	},


	renameSlide: function(el) {
		var $el = jQuery(el);
		var name = jQuery('span:first-child', el).text();

		if($el.hasClass('editing')) { return false; }

		// Add input
		$el.addClass('editing');
		$input = jQuery('<input type="text">').appendTo($el).val(name);
		$input.focus().select();

		// Save changes on Enter
		$input.on('keydown', function(e) {
			if(e.which == 13) { LayerSlider.renameSlideEnd(el); }
		});

		// Save changes by clicking away
		jQuery('body').one('click', ':not(#ls-layer-tabs a input)', function() {
			LayerSlider.renameSlideEnd(el);
		});
	},


	renameSlideEnd: function(el) {

		var $el 	= jQuery(el),
			$input 	= jQuery('input', el),
			index 	= $el.index();

		if($el.hasClass('editing')) {

			window.lsSliderData.layers[ index ].properties.title = $input.val();
			jQuery('span', $el).first().text( $input.val());
			$input.remove();
			$el.removeClass('editing');
		}
	},


	duplicateSlide: function(el) {


		// Duplicate slide by using jQuery.extend()
		// to make sure it's a copy instead of an
		// object reference.
		var newSlideData = jQuery.extend(true, {}, LS_activeSlideData);

		// Assign new UUID
		newSlideData.properties.uuid = LS_DataSource.generateUUID();

		// Rename slide
		if(!!newSlideData.properties.title) {
			newSlideData.properties.title += ' copy';
		} else {
			newSlideData.properties.title = 'Slide #'+(LS_activeSlideIndex+1)+' copy';
		}

		// Duplicate slide by using jQuery.extend()
		// to make sure it's a copy instead of an
		// object reference.
		window.lsSliderData.layers.splice(
			LS_activeSlideIndex + 1, 0, newSlideData
		);

		// Insert the duplicate slide tab after the original
		var tab = jQuery('<a href="#"><span>'+newSlideData.properties.title+'</span><span class="dashicons dashicons-dismiss"></span></a>').insertAfter('#ls-layer-tabs a.active');
		LayerSlider.reindexSlides();
		LayerSlider.reindexStaticLayers();

		// Select new slide
		tab.click();
	},

	toggleAdvancedSlideOptions: function( el ) {

		var $el 	= jQuery(el),
			$target = jQuery('.ls-slide-options tr.ls-advanced');

		if( $el.hasClass('ls-opened') ) {
			$el.removeClass('ls-opened');
			$target.addClass('ls-hidden');
		} else {
			$el.addClass('ls-opened');
			$target.removeClass('ls-hidden');
		}
	},


	setPreviewZoom: function( value ) {

		LS_previewZoom = value;

		jQuery('.ls-editor-slider-val').text(''+Math.round(value * 100)+'%');

		jQuery( '.ls-preview-transform' ).css({
			transform: 'scale('+value+')'
		}).parent().trigger('zoom');

		var sliderProps = window.lsSliderData.properties,
			width 		= parseInt(sliderProps.sublayercontainer) || sliderProps.width || 1280,
			height 		= sliderProps.height || 720;

		jQuery( '.ls-preview-size' ).css({
			width: parseInt(width)* value,
			height: parseInt(height) * value
		});

		LayerSlider.updatePreviewSelection();
	},


	addPreviewSlider: function(target, value) {

		jQuery(target).slider({
			value: value, min: 0.5, max: 1.5, step: 0.01,
			range: 'min', orientation: 'horizontal',
			slide: function(event, ui) {

				// Disable auto-fit when resizing manually
				if( jQuery('#zoom-fit').prop('checked') ){
					jQuery('#zoom-fit').next().click();
				}

				LayerSlider.setPreviewZoom(ui.value);

				// Restart previews (if any)
				if( LayerSlider.isSlidePreviewActive ) {
					LayerSlider.stopSlidePreview( );
				}

				if( LayerSlider.isLayerPreviewActive ) {
					LayerSlider.stopLayerPreview( true );
				}
			},

			change: function(event, ui) {
				LS_previewZoom = ui.value;
				LayerSlider.updatePreviewSelection();
			}
		});


		// Resize preview on page load
		if( jQuery('#zoom-fit').prop('checked') ) {
			LayerSlider.autoFitPreview(target);

		// Slide value on page load
		} else if(typeof value != "undefined" && value != 1 ) {
			jQuery(target).slider('value', parseInt(value));
			LayerSlider.setPreviewZoom(value);
		}

		jQuery(document).on('click','#zoom-fit',function(){

			if( jQuery(this).prop('checked') ){
				LayerSlider.autoFitPreview(target, 0.75);
			}
		});

		jQuery(window).resize(function( event ){
			if( event.target === window ) {
				LayerSlider.autoFitPreview(target);
			}
		});
	},


	autoFitPreview: function(target, duration){

		if( jQuery('#zoom-fit').prop('checked') ){

			var sliderProps = window.lsSliderData.properties,
				width 		= parseInt(sliderProps.sublayercontainer) || parseInt(sliderProps.width) || 1280,
				height 		= parseInt(sliderProps.height) || 720,
				// 905(px) is the minimum width to keep the slider settings table organized
				smallestRatio = 916 / width > 0.5 ? 916 / width : 0.5,
				ratio = ( jQuery('#ls-main-nav-bar').outerWidth() - 32 ) / width;

			if( ratio < smallestRatio ){
				ratio = smallestRatio;
			} else if( ratio > 1 ){
				ratio = 1;
			}

			jQuery(target).slider('value', ratio );
			LayerSlider.setPreviewZoom( ratio );

			// jQuery('.ls-editor-slider-val').text(ratio+'%');

			// if( duration ){
			// 	TweenLite.to(
			// 		jQuery('#ls-preview-layers')[0],
			// 		duration,
			// 		{
			// 			parseTransform: true,
			// 			scale: ratio/100,
			// 			ease: 'Quint.easeInOut',
			// 			onUpdate: function() {
			// 				jQuery('.ls-preview-td').trigger('zoom');
			// 				LayerSlider.updatePreviewSelection();
			// 			}
			// 		}
			// 	);

			// 	TweenLite.to(
			// 		[LS_previewHolder, LS_previewWrapper],
			// 		duration,
			// 		{
			// 			width: width * ratio / 100,
			// 			height: height * ratio / 100,
			// 			ease: 'Quint.easeInOut'
			// 		}
			// 	);
			// }else{
				// LayerSlider.setPreviewZoom( ratio );
			// }
		}
	},


	addLayer: function(layerDataSet, atIndexSet, addProperties) {

		var c, len, selectIndexSet = [], updateInfo = [], emptyData, emptyIndex;

		// Set removeProperties to an empty object by default
		addProperties = addProperties || { selectLayer: true };

		// Get default layer data if not provided
		emptyData 	 = !layerDataSet;
		layerDataSet = layerDataSet || jQuery.extend(true, {}, LS_DataSource.getDefaultLayerData() );
		layerDataSet = jQuery.makeArray( layerDataSet );

		c = layerDataSet.length;

		// Add layer to the top if
		// not specified otherwise.
		emptyIndex = ! atIndexSet;
		atIndexSet = ! emptyIndex ? atIndexSet : [].fill(0, c);
		atIndexSet = jQuery.makeArray( atIndexSet );

		// Iterate backwards to keep indexes consistent throughout
		// the sequence. Don't use .revert() on data sets reference,
		// as it will change the original set as well.
		while(c--) {

			// Add new layer data to data source
			LS_activeSlideData.sublayers.splice(atIndexSet[c], 0, layerDataSet[c]);

			// Offsetting indexes to follow data storage
			// changes in case of multiple additions.
			selectIndexSet.push( atIndexSet[c] + c );

			// UndoManager
			updateInfo.push({
				itemIndex: atIndexSet[c],
				selectIndex: selectIndexSet[c],
				undo: { data: {} },
				redo: { data: layerDataSet[c] }
			});
		}

		// Maintain undoManager
		if( ! addProperties.histroyEvent) {
			LS_UndoManager.add(
				'slide.layers',
				updateInfo.length > 1 ? 'New layers' : 'New layer',
				updateInfo
			);
		}

		// Update layers list and preview
		LS_DataSource.buildLayersList();
		LayerSlider.generatePreview();

		// Select new layers
		if( addProperties.selectLayer ) {

			if( addProperties.hasOwnProperty('selectPage') ) {
				LS_activeLayerPageIndex = addProperties.selectPage;
			}

			LayerSlider.selectLayer( selectIndexSet );

			if( emptyData && updateInfo.length === 1 ) {
				jQuery('.ls-sublayers  li.active .ls-sublayer-title').focus().select();
			}
		}
	},


	selectLayer: function(layerIndexSet, selectProperties) {

		// Bail out early if the current slide has no layers
		if( ! LS_activeSlideData.sublayers.length) {
			jQuery('.ls-timeline-switch, .ls-sublayer-nav').hide();
			jQuery('.ls-sublayer-pages').empty();
			return false;

		} else {
			jQuery('.ls-timeline-switch, .ls-sublayer-nav').show();
		}

		// Bail out early if there's no active layer selection
		if( ! layerIndexSet || ! layerIndexSet.length) { return false; }

		// Bail out early if the current selection is the same
		// if( layerIndexSet.length == LS_activeLayerIndexSet.length ) {
		// 	if( layerIndexSet.every(function(v,i) { return v === LS_activeLayerIndexSet[i];}) ) {
		// 		return false;
		// 	}
		// }

		// Set removeProperties to an empty object by default
		selectProperties = selectProperties || {};

		// Bail out early if it's already a selected layer
		// if( !selectProperties.forceSelect &&
		// 	LS_activeLayerIndexSet.indexOf(layerIndex) !== -1 ) {
		// 	return false;
		// }

		var $layersList 	= jQuery('.ls-sublayers li'),
			$layerOptions 	= jQuery('.ls-sublayer-pages-wrapper');

		// Stop layer preview session (if any)
		LayerSlider.stopLayerPreview();

		// Update stored data & preview based on
		// the passed selection index set.
		LS_activeLayerIndexSet = [];
		LS_activeLayerDataSet = [];
		$layersList.removeClass('active');
		jQuery('#ls-preview-layers > *').removeClass('ui-selected');
		jQuery.each(layerIndexSet, function(idx, layerIndex) {
			LS_activeLayerIndexSet.push(layerIndex);
			LS_activeLayerDataSet.push(
				LS_activeSlideData.sublayers[layerIndex]
			);
			LS_previewItems[layerIndex].addClass('ui-selected');
			$layersList.eq(layerIndex).addClass('active');
		});

		if(!LS_activeLayerDataSet[0].meta) {
			LS_activeLayerDataSet[0].meta = {};
		}

		// Show/Hide layer options depending on
		// the number of selected layers
		if(LS_activeLayerIndexSet.length > 1) {
			$layerOptions.hide().prev().removeClass('ls-hidden');
		} else {
			$layerOptions.show().prev().addClass('ls-hidden');
		}

		// Build new layer ...
		if(LS_activeLayerIndexSet.length === 1) {
			LS_DataSource.buildLayer();
		}

		// Store selection
		LS_Utils.removeTextSelection();
		LayerSlider.updatePreviewSelection();
		LS_activeSlideData.meta.activeLayers = LS_activeLayerIndexSet;
		jQuery('.ls-timeline-switch, .ls-sublayer-nav').show();

		// Create layer transition preview animations
		layerTransitionPreview.create();
	},


	selectLayerPage: function(pageIndex) {

		// Select new tab
		jQuery('.ls-sublayer-nav a').removeClass('active')
			.eq(pageIndex).addClass('active');

		// Show the corresponding page
		jQuery('#ls-layers .ls-sublayer-page').removeClass('active')
			.eq( pageIndex ).addClass('active');

		// Store lastly selected layer page
		LS_activeLayerPageIndex = pageIndex;

		// SET: styles
		kmUI.smartResize.set();
	},


	selectTransitionPage: function( td ) {

		var $td = jQuery(td),
			index = ($td.index() - 1)  / 2,
			$target = jQuery('#ls-layer-transitions').children().eq(index);

		$target.addClass('active').siblings().removeClass('active');
		$td.addClass('selected').siblings().removeClass('selected');

		jQuery( '#ls-transition-selector' ).val( index );

		LS_activeLayerTransitionTab = index;

		$target.removeClass('disabled');
		if( ! $target.find('.ls-h-button input').prop('checked') ) {
			$target.addClass('disabled');
		}
	},

	enableTransitionPage: function( input ) {

		LayerSlider.reorderTransitionProperties(
			jQuery( input ).closest('section').index()
		);

 	},


 	reorderTransitionProperties: function( sectionIndex ) {

 		var media 		= LS_activeLayerDataSet[0].media || '',
 			index,
 			$sections 	= jQuery('#ls-layer-transitions').children(),
 			$section,
 			$input,
 			$td;

 		if( sectionIndex ) {
 			$sections = $sections.eq( sectionIndex );
 		}

 		$sections.each(function() {

 			$section 	= jQuery(this);
 			index 		= $section.index();
 			$input 		= $section.find('input.toggle').eq(0);
 			$td 		= jQuery('#ls-transition-selector-table td:not(.ls-padding)').eq( index );

 			// Disabled
 			if( ! $input.prop('checked') ) {
 				$td.removeClass('active');
 				$section.addClass('disabled');
 				$section.find(':input').each(function() {
					var $this 	= jQuery(this),
						name 	= $this.attr('name'),
						value 	= $this.is(':checkbox') ? $this.prop('checked') : $this.val();

					if( name && ! $this.is('.toggle') ) {
						$this.data('value', value );
						delete LS_activeLayerDataSet[0].transition[ name ];
					}
				});

 			// Active
 			} else {
 				$td.addClass('active');
 				$section.removeClass('disabled');
 				$section.find(':input').each(function() {
					var $this 	= jQuery(this),
						name 	= $this.attr('name'),
						value 	= $this.data('value');

					if( name && ! $this.is('.toggle') ) {
						LS_activeLayerDataSet[0].transition[ name ] = value;
					}
				});
 			}
 		});

 	},


	removeLayer: function(layerIndexSet, removeProperties) {

		// Set removeProperties to an empty object by default
		removeProperties = removeProperties || { requireConfirmation: true };

		// Require confirmation from user
		// if it's not a history event.
		if( removeProperties.requireConfirmation ) {
			if( !confirm('Are you sure you want to remove this layer?') ) {
				return false;
			}
		}

		// Get active layers if no index was provided
		if( ! layerIndexSet  && layerIndexSet !== 0 ) {
			layerIndexSet = LS_activeLayerIndexSet;

		// Convert a single index to an index set
		} else if( typeof layerIndexSet === 'number') {
			layerIndexSet = [layerIndexSet];
		}

		// Get layer(s)
		var c = layerIndexSet.length, $layers = jQuery('.ls-sublayers li'),
			updateInfo = [], $layer, $newLayer, layerIndex, layerData;

		// Iterate backwards to keep indexes consistent throughout the sequence.
		// Don't use .revert() on a LS_activeLayerIndexSet reference, as it will
		// change the original set as well.
		while(c--) {
			// console.log(c);
			layerIndex 	= layerIndexSet[c];
			$layer 		= $layers.eq(layerIndex);
			layerData 	= jQuery.extend(true, {}, LS_activeSlideData.sublayers[layerIndex]);

			// Get the next or prev layer
			if($layer.next().length > 0) { $newLayer = $layer.next(); }
				else if($layer.prev().length > 0) { $newLayer = $layer.prev(); }

			// Setup UndoManager updateInfo object
			updateInfo.push({
				itemIndex: layerIndex,
				undo: { data: layerData },
				redo: { data: {} }
			});

			// Remove layer from data source and UI
			LS_activeSlideData.sublayers.splice(layerIndex, 1);
			$layer.remove();
		}

		// Empty slide, hide UI items
		if(!LS_activeSlideData.sublayers.length) {
			jQuery('.ls-timeline-switch, .ls-sublayer-nav').hide();
			jQuery('.ls-sublayer-pages').empty();

		// Update UI otherwise
		// Select new layer. The .click() event will
		// maintain the active layer index and data.
		} else if($newLayer) {
			$newLayer.click();
			LayerSlider.reindexLayers();
		}

		// Update preview
		LayerSlider.generatePreview();
		LayerSlider.updatePreviewSelection();

		// Maintain undoManager only if
		// it wasn't a history action
		if( !removeProperties.histroyEvent && updateInfo.length) {
			LS_UndoManager.add('slide.layers', 'Remove layer(s)', updateInfo);
		}
	},


	hideLayer: function(el) {

		// Get layer index
		var layerIndex = jQuery(el).closest('li').index();
		var layerData = LS_activeSlideData.sublayers[layerIndex];

		// Maintain history
		LS_UndoManager.add('layer.general', 'Hide layer', {
			itemIndex: layerIndex,
			undo: { skip: !!layerData.skip },
			redo: { skip: !layerData.skip }
		});

		// Hide/show layer
		layerData.skip = !layerData.skip;
		if(layerData.skip) { jQuery(el).addClass('disabled'); }
			else { jQuery(el).removeClass('disabled'); }

		// Update preview
		LayerSlider.generatePreviewItem(layerIndex);
	},


	lockLayer: function(el) {

		// Get layer index
		var layerIndex 	= jQuery(el).closest('li').index(),
			layerData 	= LS_activeSlideData.sublayers[layerIndex],
			$previewItem = LayerSlider.previewItemAtIndex(layerIndex);

		// Maintain history
		LS_UndoManager.add('layer.general', 'Lock layer', {
			itemIndex: layerIndex,
			undo: { locked: !!layerData.locked },
			redo: { locked: !layerData.locked }
		});

		// Lock layer
		layerData.locked = !layerData.locked;
		if(layerData.locked) {
			jQuery(el).removeClass('disabled');
			$previewItem.addClass('disabled');
			$lasso.hide();

		// Unlock layer
		} else {

			jQuery(el).addClass('disabled');
			$previewItem.removeClass('disabled');
		}
	},


	setLayerMedia: function(mediaType, $mediaEl, layerData) {

		switch(mediaType) {
			case 'img':

			var src = layerData.imageThumb || pluginPath+'admin/img/blank.gif',
				classes = layerData.imageThumb ? '' : ' dashicons dashicons-format-image';

				$mediaEl.attr('class', 'ls-sublayer-thumb'+classes).html('<img src="'+(layerData.imageThumb || pluginPath+'admin/img/blank.gif')+'">');
				break;

			case 'html':
				$mediaEl.addClass('dashicons dashicons-editor-code');
				break;

			case 'media':
				$mediaEl.addClass('dashicons dashicons-video-alt3');
				break;

			case 'post':
				$mediaEl.addClass('dashicons dashicons-admin-post');
				break;

			default:
				$mediaEl.addClass('dashicons dashicons-editor-textcolor');
				break;
		}
	},


	setLayerAttributes: function( event, element ) {

		if( event.type === 'change' && ! jQuery(element).is(':checkbox') ) {
			return;
		}

		var $tr = jQuery(element).closest('tr'),
			$inputs = jQuery('input', $tr ),

			innerAttrs = LS_activeLayerDataSet[0].innerAttributes = {},
			outerAttrs = LS_activeLayerDataSet[0].outerAttributes = {};

		if( ! $inputs.eq(0).val() && ! $inputs.eq(1).val() ) {
			$tr.remove();
			return;
		}

		jQuery('.ls-sublayer-custom-attributes tr:not(:last-child)').each(function() {

			var $key = jQuery('td.first input', this),
				$val = jQuery('td.second input', this),
				$chb = jQuery('td.third input', this),
				key  = $key.val(),
				val  = $val.val();

			if( key && /^[a-zA-Z]([a-zA-Z0-9_-]+)$/.test( key ) ) {
				$key.removeClass('error');

				if( $chb.prop('checked') ) {
					outerAttrs[ key ] = val;
				} else {
					innerAttrs[ key ] = val;
				}

			} else {
				$key.addClass('error');
			}
		});
	},


	updateLayerAttributes: function( layerData ) {

		// Make sure to have objects for data
		layerData.innerAttributes = layerData.innerAttributes || {};
		layerData.outerAttributes = layerData.outerAttributes || {};

		var customAttrs = jQuery.extend( {}, layerData.innerAttributes, layerData.outerAttributes),
			$customAttributes = jQuery('.ls-sublayer-custom-attributes');

		// Sort keys
		Object.keys(customAttrs).sort().forEach(function(key) {
			var value = customAttrs[key];
			delete customAttrs[key];
			customAttrs[key] = value;
		});

		jQuery.each(customAttrs, function(key, val) {
			jQuery('tr:last-child input:eq(2)', $customAttributes).prop('checked', key in layerData.outerAttributes );
			jQuery('tr:last-child input:eq(1)', $customAttributes).val( val );
			jQuery('tr:last-child input:eq(0)', $customAttributes).val( key ).trigger('keyup');
		});
	},

	updateLayerBorderPadding: function(el) {

		var $input 	= jQuery(el),
			value 	= parseInt( $input.val() ),
			type 	= ($input.parent().index() === 1) ? 'border' : 'padding',
			edge 	= $input.closest('tr').data('edge');
			sel 	= '.ls-'+type+'-'+edge+'-value';

		jQuery(sel).text( value || '–' );
	},

	// Iterate through all slides and their layers to
	// find the ones appearing on the target slide.
	staticLayersForSlide: function( targetSlideIndex ) {

		var staticLayers = [];

		jQuery.each(window.lsSliderData.layers, function(slideIndex, slideData) {
			jQuery.each(slideData.sublayers, function(layerIndex, layerData) {

				if( layerData.transition.static ) {
					var staticOut = layerData.transition.static;
					if( ( staticOut > targetSlideIndex || staticOut === 'forever' ) && slideIndex < targetSlideIndex ) {

						staticLayers.push({
							slideIndex: slideIndex,
							slideData: 	slideData,
							layerIndex: layerIndex,
							layerData: 	layerData
						});
					}
				}
			});
		});

		return staticLayers;
	},


	reindexStaticLayers: function() {

		jQuery.each(window.lsSliderData.layers, function(slideIndex, slideData) {
			jQuery.each(slideData.sublayers, function(layerIndex, layerData) {

				if( layerData.transition.staticUUID ) {
					var staticOut = LS_DataSource.slideForUUID( layerData.transition.staticUUID );
					if( staticOut ) {
						layerData.transition.static = staticOut + 1;
					}
				}
			});
		});
	},

	setupStaticLayersChooser: function( select ) {

		var $select = jQuery(select);

			// Remove previously added options
			$select.children(':gt(1)').remove();

			// Gather slide data
			var sliderData 	= window.lsSliderData,
				slideCount 	= sliderData.layers ? sliderData.layers.length : 0,
				markup 		= '<option value="-2" disabled>–</option>',
				slideName;

			// Generate markup
			for( var s = 0; s < slideCount; s++) {
				slideName 	= sliderData.layers[s].properties.title;
				slideName 	= slideName ? ' ('+slideName+')' : '';
				markup += '<option value="'+(s+1)+'">Until the end of Slide #'+(s+1)+''+slideName+'</option>';
			}

			// Append select options
			$select.append(markup);

			var staticVal = parseInt( LS_activeLayerDataSet[0].transition.static );
			if( staticVal ) {
				$select.children('[value="'+staticVal+'"]').prop('selected', true)
					.siblings().prop('selected', false);
			}

	},


	revealStaticLayer: function( el ) {

		var $target = jQuery(el).closest('li'),
			index 	= $target.index(),
			data 	= LS_activeStaticLayersDataSet[ index ];

		LayerSlider.selectSlide( data.slideIndex );
		LayerSlider.selectLayer( [data.layerIndex] );
	},


	addColorPicker: function(el) {
		jQuery(el).minicolors({
			opacity: true,
			changeDelay: 100,
			position: 'bottom right',
			change: function(hex, opacity) {
				//LayerSlider.willGeneratePreview();
			}
		}).blur(function( event ) {
			event.stopImmediatePropagation();

			jQuery(this)
				.removeClass('ls-colorpicker')
				.trigger('change')
				.addClass('ls-colorpicker');

		});
	},


	duplicateLayer: function() {
		this.pasteLayer( this.copyLayer(false).layers );
	},


	copyLayer: function(useStorage, layerDataSet, layerIndexSet, copyProperties) {

		// Defaults
		useStorage 		= useStorage 	|| true;
		layerDataSet 	= layerDataSet 	|| LS_activeLayerDataSet;
		layerIndexSet 	= layerIndexSet || LS_activeLayerIndexSet;
		copyProperties 	= copyProperties || { shiftLayers: true };

		// Iterate over the data set, clone objects and
		// make some visual adjustments on items
		var clipboardData = [];
		jQuery.each(layerDataSet, function(key, item) {

			// Copy layer data object
			var copy = jQuery.extend(true, {}, item);
			copy.subtitle += ' copy';

			if( copyProperties.shiftLayers ) {
				// copy.styles.top = (copy.styles.top.indexOf('%') == -1) ? parseInt(copy.styles.top) + 10 + 'px' : parseInt(copy.styles.top) + 1 + '%';
				// copy.styles.left = (copy.styles.left.indexOf('%') == -1) ? parseInt(copy.styles.left) + 10 + 'px' : parseInt(copy.styles.left) + 1 + '%';
			}

			// Add copy to the new set
			clipboardData.push(copy);
		});

		// Build clipboard data
		clipboardData = {
			layers: clipboardData,
			sliderID: LS_sliderID,
			slideIndex: LS_activeSlideIndex,
			layerIndexSet: layerIndexSet
		};

		// Save to storage and return copies
		useStorage && localStorage.setObject('ls-layer-clipboard', clipboardData);
		return clipboardData;
	},


	pasteLayer: function(layerDataSet, layerIndexSet, pasteProperties) {

		// Check for provided data, fetch from clipboard if not
		var isDataProvided 	= layerDataSet ? true : false,
			clipboardData 	= localStorage.getObject('ls-layer-clipboard'),
			addIndexSet;

		layerDataSet 		= layerDataSet 	|| clipboardData.layers;
		layerIndexSet 		= layerIndexSet || clipboardData.layerIndexSet;

		// Warn users when there's nothing on the clipboard
		// and halt execution.
		if( ! layerDataSet ) {
			alert('There\'s nothing to paste. Copy a layer first!');
			return;
		}

		// Set pasteProperties to an empty object by default
		pasteProperties = pasteProperties || {};

		// If the layer is from the same slide, then
		// find the uppermost selected layer index
		// and insert everything into that position.
		// Otherwise insert at the beginning of the layers list.
		// -
		// Trying to insert layers before their parents
		// individually is complex, and it will fragment
		// dupe selection.
		if(clipboardData.sliderID !== LS_sliderID || clipboardData.slideIndex !== LS_activeSlideIndex) {
			addIndexSet = [].fill( 0, layerIndexSet.length);
		} else {
			addIndexSet = [].fill( Math.min.apply(Math, layerIndexSet), layerIndexSet.length);
		}

		// Insert new layers
		LayerSlider.addLayer(layerDataSet, addIndexSet, { selectLayer: true } );

		// Copy pasted layer to make a new reference
		// and update settings like position and name
		if(!isDataProvided) { this.copyLayer(true, layerDataSet, layerIndexSet); }
	},


	selectMediaType: function(el, layerIndex) {

		// Gather layer data
		layerIndex = layerIndex ? layerIndex : LS_activeLayerIndexSet;
		layerIndex = (typeof layerIndex === 'object') ? layerIndex[0] : layerIndex;
		var layerData  	= LS_activeSlideData.sublayers[layerIndex],
			layer 		= jQuery(el).closest('.ls-sublayer-page'),
			$layerItem 	= jQuery('.ls-sublayers li').eq(layerIndex),
			section 	= jQuery(el).data('section'),
			placeholder = jQuery(el).data('placeholder'),
			sections 	= jQuery('.ls-layer-sections', layer).children();

		// Set active class
		jQuery(el).attr('class', 'active').siblings().removeAttr('class');

		// Store selection
		layerData.media = section;

		// Show the corresponding sections
		sections.hide().removeClass('ls-hidden');
		jQuery('.ls-sublayer-element', layer).hide().removeClass('ls-hidden');
		jQuery('.ls-html-code .ls-options, .ls-html-code .ls-insert-media', layer).addClass('ls-hidden');

		switch(section) {
			case 'img':
				sections.eq(0).show();
				var src 	= layerData.imageThumb || pluginPath+'admin/img/blank.gif',
					classes = layerData.imageThumb ? '' : ' dashicons dashicons-format-image';

				jQuery('.ls-sublayer-thumb', $layerItem).attr('class', 'ls-sublayer-thumb'+classes).html('<img src="'+(layerData.imageThumb || pluginPath+'admin/img/blank.gif')+'">');
				break;

			case 'text':
				sections.eq(1).show();
				layer.find('.ls-sublayer-element').show();
				jQuery('.ls-html-code textarea').attr('placeholder', placeholder );
				jQuery('.ls-sublayer-thumb', $layerItem).attr('class', 'ls-sublayer-thumb dashicons dashicons-editor-textcolor').html('');
				break;

			case 'html':
				sections.eq(1).show();
				jQuery('.ls-html-code .ls-options, .ls-html-code .ls-insert-media', layer).addClass('ls-hidden');
				jQuery('.ls-html-code textarea').attr('placeholder', placeholder );
				jQuery('.ls-sublayer-thumb', $layerItem).attr('class', 'ls-sublayer-thumb dashicons dashicons-editor-code').html('');
				break;

			case 'media':
				sections.eq(1).show();
				jQuery('.ls-html-code .ls-options, .ls-html-code .ls-insert-media', layer).removeClass('ls-hidden');
				jQuery('.ls-html-code textarea').attr('placeholder', placeholder );
				jQuery('.ls-sublayer-thumb', $layerItem).attr('class', 'ls-sublayer-thumb dashicons dashicons-video-alt3').html('');
				break;

			case 'post':
				sections.eq(1).show();
				sections.eq(2).show();
				jQuery('.ls-html-code textarea').attr('placeholder', placeholder );
				jQuery('.ls-sublayer-thumb', $layerItem).attr('class', 'ls-sublayer-thumb dashicons dashicons-admin-post').html('');
				break;
		}

		if( section === 'img' || section === 'media' ) {
			jQuery('#ls-layer-transitions .ls-text-transition .ls-checkbox.toggle.on').click();
		}

		jQuery('.ls-sublayer-pages-wrapper').attr('class', 'ls-sublayer-pages-wrapper ls-layer-type-' + layerData.media);
	},


	selectElementType: function(el, layerIndex) {

		// Layer and properties
		layerIndex = layerIndex ? layerIndex : LS_activeLayerIndexSet;
		layerIndex = (typeof layerIndex === 'object') ? layerIndex[0] : layerIndex;

		var layerData  = LS_activeSlideData.sublayers[layerIndex],
			layer = jQuery(el).closest('.ls-sublayer-page'),
			element = jQuery(el).data('element');

		// Set active class
		jQuery(el).siblings().removeClass('active');
		jQuery(el).addClass('active');

		// Store selection
		layerData.type = element;
	},


	copyLayerSettings: function(el) {

		var $el 		= jQuery(el),
			$wrapper 	= $el.closest('[data-storage]'),
			storage 	= $wrapper.attr('data-storage'),
			data 		= { styles: {}, transition: {} };

		// Iterate over options, store values
		$wrapper.find(':input').each(function() {
			if(this.name) {
				var $item 	= jQuery(this),
					area 	= $item.hasClass('sublayerprop') ? 'transition' : 'styles';

				data[area][this.name] = $item.is(':checkbox') ? $item.prop('checked') : $item.val();
			}
		});

		// Add data to clipboard
		var LS_clipboard = localStorage.getObject('ls-options-clipboard') || {};
		LS_clipboard[ storage ] = {
			timestamp: Math.floor(Date.now() / 1000),
			data: data
		};
		localStorage.setObject('ls-options-clipboard', LS_clipboard);

		// Send feedback to users
		$el.css('color', '#fcd116');
		setTimeout(function() {
			$el.css('color', '#00a0d2');
		}, 1000);
	},


	pasteLayerSettings: function(el) {

		var $el 		= jQuery(el),
			$wrapper 	= $el.closest('[data-storage]'),
			storage 	= $wrapper.attr('data-storage'),
			undoObj 	= {},
			redoObj 	= {},
			undoArea;

		// Don't allow pasting options when the corresponding
		// transition sections is disabled
		if( $wrapper.closest('#ls-layer-transitions').length ) {
			if( ! $wrapper.find('.ls-h-button input').prop('checked') ) {
				$wrapper.find('.overlay').click();
				return;
			}
		}

		// Get clipboard data
		var LS_clipboard = localStorage.getObject('ls-options-clipboard') || {},
			clipboard = LS_clipboard[storage],
			timestamp = Math.floor(Date.now() / 1000);

		// Validate clipboard data
		if( ! clipboard || jQuery.isEmptyObject(clipboard.data) || clipboard.timestamp < timestamp - 60 * 60 * 3 ) {
			alert('There is nothing to paste!');
			return false;
		}

		// Iterate over options, set new values
		$wrapper.find(':input').each(function() {
			if(this.name && this.name != 'top' && this.name != 'left') { // !!! don't paste left & top style

				var $this 	= jQuery(this),
					area 	= $this.hasClass('sublayerprop') ? 'transition' : 'styles',
					curVal 	= $this.is(':checkbox') ? $this.prop('checked') : $this.val(),
					newVal 	= clipboard.data[area][this.name];


				if( curVal != newVal ) {
					if($this.is(':checkbox')) {
						$this.next().click();
					} else {
						$this.val( newVal ).trigger('input').trigger('keyup');
					}

					if( ! undoObj[ area ] ) { undoObj[ area ] = {}; }
					if( ! redoObj[ area ] ) { redoObj[ area ] = {}; }

					undoObj[ area ][ this.name ] = curVal;
					redoObj[ area ][ this.name ] = newVal;
				}


				LS_activeLayerDataSet[0][area][ this.name ] = newVal;
			}
		});

		// Add UndoManager action
		LS_UndoManager.add('layer.general', 'Paste layer settings', {
			itemIndex: LS_activeLayerIndexSet[0],
			undo: undoObj,
			redo: redoObj
		});

		$el.css('color', '#90ca77');
		setTimeout(function() { $el.css('color', '#00a0d2'); }, 1000);

		if( undoArea === 'style' ) {
			LayerSlider.generatePreviewItem( LS_activeLayerIndexSet[0] );
		}
	},


	updateSlideInterfaceItems: function() {

		var slideData 	= LS_activeSlideData.properties,
			imgSrc 		= slideData.backgroundThumb ? slideData.backgroundThumb : slideData.background;

		LS_GUI.updateImagePicker( 'background', imgSrc );
	},

	updateLayerInterfaceItems: function(layerIndex) {

		var $layer = jQuery('.ls-sublayer-pages'),
			$layerItem = jQuery('.ls-sublayers li').eq(layerIndex),
			layerData = LS_activeSlideData.sublayers[layerIndex];

		if( ! layerData ) { return; }

		// Image layer preview
		var imgSrc = layerData.imageThumb ? layerData.imageThumb : layerData.image;
		LS_GUI.updateImagePicker( 'image', imgSrc );

		// Video poster preview
		imgSrc = layerData.posterThumb ? layerData.posterThumb : layerData.poster;
		LS_GUI.updateImagePicker( 'poster', imgSrc );

		// Select layer and media type
		if(typeof layerData.media == 'undefined') {
			switch(layerData.type) {
				case 'img': layerData.media = 'img'; break;
				case 'div': layerData.media = 'html'; break;
				default: layerData.media = 'text';
			}
		}

		LayerSlider.selectMediaType( $layer.find('.ls-layer-kind li[data-section="'+layerData.media+'"]'), layerIndex );
		LayerSlider.selectElementType( $layer.find('.ls-sublayer-element > li[data-element="'+layerData.type+'"]'), layerIndex );

		// Skip
		if(layerData.skip) { jQuery('.ls-icon-eye', $layerItem).addClass('disabled'); }
			else { jQuery('.ls-icon-eye', $layerItem).removeClass('disabled'); }

		if(layerData.locked) { jQuery('.ls-icon-lock', $layerItem).removeClass('disabled'); }
			else { jQuery('.ls-icon-lock', $layerItem).addClass('disabled'); }
	},

	changeLayerScreenType: function( $button, updateLayer  ) {


		jQuery('.ls-set-screen-types button').each(function() {

			var layerData 	= LS_activeLayerDataSet[0],
				$item 		= jQuery(this),
				type 		= $item.data('type');

			if( $button && $button.is( $item ) ) {
				layerData['hide_on_'+type] = ! layerData['hide_on_'+type];
			}

			$item[ layerData['hide_on_'+type] ? 'removeClass' : 'addClass' ]('playing');
		});


		if( updateLayer ) {
			LayerSlider.generatePreviewItem( LS_activeLayerIndexSet[0] );
			setTimeout(function() {
				LS_DataSource.buildLayersListItem( LS_activeLayerIndexSet[0] );
			}, 200);
		}
	},

	changeVideoType: function() {

		var $input 		= jQuery('.ls-sublayer-basic input.bgvideo'),
			$options 	= jQuery('.ls-sublayer-basic .ls-media-options');
			$overlays 	= jQuery('.ls-sublayer-basic .ls-bgvideo-options');

		if( $input.prop('checked') ) {
			$options.hide();
			$overlays.show();
			LS_activeLayerDataSet[0].locked = true;

		} else {
			$options.show();
			$overlays.hide();
			LS_activeLayerDataSet[0].locked = false;

		}
	},


	willGeneratePreview: function() {
		clearTimeout(LayerSlider.timeout);
		LayerSlider.timeout = setTimeout(function() {
				LayerSlider.generatePreview();
		}, 1000);
	},


	generatePreview: function() {

		// –––––––––––––––––––––––––––––––––––––––––––––
		// READ-ONLY BLOCK
		//
		// Group DOM read/access operations together,
		// so the browser can cache and apply them in a
		// in a single pass, triggering only one reflow.
		// ———————————————————————————––––––––––––––––––

		// Slider data sets
	var sliderProps = window.lsSliderData.properties,
		slideIndex 	= LS_activeSlideIndex,
		slideData 	= LS_activeSlideData,
		slideProps 	= slideData.properties,
		layers 		= slideData.sublayers,
		$settings 	= jQuery('.ls-settings'),


		// Preview data
		width 		= parseInt( sliderProps.sublayercontainer) || parseInt(sliderProps.width) || 1280,
		height 		= parseInt(sliderProps.height) || 720,
		bgColor 	= sliderProps.backgroundcolor,
		bgImage 	= sliderProps.backgroundimage,
		yourLogo 	= sliderProps.yourlogo,
		yourLogoStyle = sliderProps.yourlogostyle,
		posts 		= window.lsPostsJSON,
		postOffset 	= slideProps.post_offset,
		slideBG 	= slideProps.background,
		slideBGSize = slideProps.bgsize,
		slideBGPos 	= slideProps.bgposition,
		post;



		// --- Adjust default values ---
		height 		= (height.indexOf('%') !== -1) ? 400 : parseInt(height);
		postOffset 	= (postOffset == -1) ? slideIndex : postOffset;
		post 		= posts[ postOffset ] || {};




		// –––––––––––––––––––––––––––––––––––––––––––––
		// WRITE-ONLY BLOCK
		//
		// Use only DOM write operations after this comment,
		// so the browser can cache and apply them in a
		// in a single pass, triggering only one reflow.
		// ———————————————————————————––––––––––––––––––


		// --- Set preview canvas size ---
		LS_previewArea.add(LS_previewStatic).css({
			width : width,
			height : height
		}).empty();

		jQuery('.ls-preview-size').css({
			width : width * LS_previewZoom,
			height : height * LS_previewZoom
		});

		// Make sure to follow preview area size changes
		jQuery('.ls-ruler').trigger('resize');
		LayerSlider.autoFitPreview();


		// --- Set global background ---
		LS_previewHolder.css({
			backgroundColor : bgColor || 'transparent',
			backgroundImage : bgImage ? 'url('+bgImage+')' : 'none',
			backgroundRepeat: sliderProps.globalBGRepeat,
			backgroundAttachment: sliderProps.globalBGAttachment,
			backgroundPosition: sliderProps.globalBGPosition,
			backgroundSize: sliderProps.globalBGSize
		});

		// Empty preview items list, so we don't include beyond
		// array bounds objects from previous slide in case of
		// slide change.
		LS_previewItems = [];

		// Handle post content
		if(slideBG == '[image-url]') {
			slideBG = post['image-url'];
			jQuery('.slide-image:eq(0) img').attr('src', post['image-url']);
		}

		// -- Set slide background && empty previous content ---
		if( ! slideBGSize || slideBGSize === 'inherit') {
			slideBGSize = sliderProps.slideBGSize;
		}

		if( ! slideBGPos || slideBGPos === 'inherit') {
			slideBGPos = sliderProps.slideBGPosition;
		}

		LS_previewStatic.css({
			backgroundImage: slideBG ? 'url('+slideBG+')' : 'none',
			backgroundSize: slideBGSize || 'auto',
			backgroundPosition: slideBGPos || 'center center',
			backgroundColor: slideProps.bgcolor || 'transparent',
			backgroundRepeat: 'no-repeat'
		});


		// -- Set background on slide tab
		slideBG = slideBG || pluginPath+'admin/img/blank.gif';
		jQuery('#ls-layer-tabs a').eq(slideIndex).data('help', "<img src='"+slideBG+"'>");



		// --- Setup yourLogo ---
		LS_previewHolder.parent().find('.yourlogo').remove();
		if( yourLogo ) {

			var logo = jQuery('<img src="'+yourLogo+'" class="yourlogo">').prependTo( LS_previewHolder );
			logo.attr('style', yourLogoStyle);

			var oL, oR, oT, oB,
				logoLeft, logoRight, logoTop, logoBottom;
				oL = oR = oT = oB = 'auto';

			if( logo.css('left') != 'auto' ){
				logoLeft = logo[0].style.left;
			}
			if( logo.css('right') != 'auto' ){
				logoRight = logo[0].style.right;
			}
			if( logo.css('top') != 'auto' ){
				logoTop = logo[0].style.top;
			}
			if( logo.css('bottom') != 'auto' ){
				logoBottom = logo[0].style.bottom;
			}

			if( logoLeft && logoLeft.indexOf('%') != -1 ){
				oL = width / 100 * parseInt( logoLeft ) - logo.width() / 2;
			}else{
				oL = parseInt( logoLeft );
			}

			if( logoRight && logoRight.indexOf('%') != -1 ){
				oR = width / 100 * parseInt( logoRight ) - logo.width() / 2;
			}else{
				oR = parseInt( logoRight );
			}

			if( logoTop && logoTop.indexOf('%') != -1 ){
				oT = height / 100 * parseInt( logoTop ) - logo.height() / 2;
			}else{
				oT = parseInt( logoTop );
			}

			if( logoBottom && logoBottom.indexOf('%') != -1 ){
				oB = height / 100 * parseInt( logoBottom ) - logo.height() / 2;
			}else{
				oB = parseInt( logoBottom );
			}

			logo.css({
				left : oL,
				right : oR,
				top : oT,
				bottom : oB
			});
		}


		// --- Setup layers ---
		for(var c = 0, len = layers.length; c < len; c++) {
			LayerSlider.generatePreviewItem( c, post);
		}

		// --- Setup static layers ---
		LayerSlider.generateStaticPreview();
	},


	generateStaticPreview: function() {

		LS_previewStatic.empty();

		jQuery.each(LS_activeStaticLayersDataSet, function(idx, data) {
			LayerSlider.generatePreviewItem( idx, false, {
				$targetArea: LS_previewStatic,
				$layerItem: LS_previewStatic.children().eq(idx),
				layerData: data.layerData,
				isStatic: true
			});
		});
	},


	willGeneratePreviewItem: function(layerIndex) {
		clearTimeout(LayerSlider.timeout);
		LayerSlider.timeout = setTimeout(function() {
				LayerSlider.generatePreviewItem(layerIndex);
		}, 150);
	},


	generatePreviewItem: function(layerIndex, post, generateProperties) {

		if( jQuery.type( layerIndex ) === 'array' ) {
			layerIndex = layerIndex[0];
		}

		generateProperties = generateProperties || {};
		generateProperties = jQuery.extend({}, {
			$targetArea: LS_previewArea,
			$layerItem: LS_previewItems[layerIndex],
			layerData: LS_activeSlideData.sublayers[layerIndex],
			isStatic: false

		}, generateProperties);

		// Don't update the editor while live previews are active
		if( LayerSlider.isLayerPreviewActive ) { return false; }

		// Remove affected item to replace with an updated one
		if( generateProperties.$layerItem ) {
			generateProperties.$layerItem.remove();
		}

		// Get layer data sets
		var layerData = generateProperties.layerData,

			// Get layer attributes
			item,
			type 	= layerData.type,
			html 	= layerData.html,
			id 		= layerData.id,

			// Get style settings
			top 	= layerData.styles.top,
			left 	= layerData.styles.left,

			innerAttrs = layerData.innerAttributes || {},
			outerAttrs = layerData.outerAttributes || {};

		switch( layerData.media ) {
			case 'img': type = 'img'; break;
			case 'media':
			case 'html':
				type = 'div'; break;
			case 'post': type = 'post'; break;
		}

		// Get post content if not passed
		if( ! post ) {
			var posts = window.lsPostsJSON,
				postOffset = LS_activeSlideData.properties.post_offset;

			if( postOffset == -1 ) {
				postOffset = LS_activeSlideIndex;
			}

			post = posts[postOffset] || {};
		}

		// Hidden layer
		if(layerData.skip || layerData['hide_on_'+LS_activeScreenType] ) {

			item = jQuery('<div>').appendToWithIndex(generateProperties.$targetArea, layerIndex).hide();
			if( ! generateProperties.isStatic ) {
				LS_previewItems[layerIndex] = item;
			}

			return true;
		}



		// Append element
		if(type == 'img') {
			var url = layerData.image;

			if(url == '[image-url]') {
				url = post['image-url'] || '';
				jQuery('.ls-layer-image img').attr('src', post['image-url']);
			}

			var tmpContent = url ? '<img src="'+url+'">' : '<div>';
			item = jQuery(tmpContent).hide().appendToWithIndex(generateProperties.$targetArea, layerIndex);

		} else if(type == 'post') {

			var textlength = layerData.post_text_length;
			for(var key in post) {
				if(html.indexOf('['+key+']') !== -1) {
					var postVal = post[key];
					if( (key == 'title' || key == 'content' || key == 'excerpt') && textlength > 0) {
						postVal = LS_Utils.stripTags(postVal).substr(0, textlength);
						postVal = LS_Utils.nl2br(postVal);
					}
					html = html.replace('['+key+']', postVal);
				}
			}

			// Test for html wrapper
			html = jQuery.trim(html);

			var first = html.substr(0, 1),
				last = html.substr(html.length-1, 1);
			if(first == '<' && last == '>') {
				html = html.replace(/(\r\n|\n|\r)/gm,"");
				item = jQuery(html).appendToWithIndex(generateProperties.$targetArea, layerIndex);
			} else {
				item = jQuery('<div>').html(html).appendToWithIndex(generateProperties.$targetArea, layerIndex);
			}

		} else {
			item = jQuery('<'+type+'>').appendToWithIndex(generateProperties.$targetArea, layerIndex);
			if(html !== '') { item.html(html); }
		}

		// Restore selection
		if( ! generateProperties.isStatic ) {
			LS_previewItems[layerIndex] = item;
			if(LS_activeLayerIndexSet.indexOf(layerIndex) !== -1) {
				item.addClass('ui-selected');
			} else {
				item.removeClass('ui-selected');
			}
		}

		// Sublayer properties
		var transforms = {}, trKey, trVal, defVal;
		for( trKey in layerData.transition) {
			if( LS_transformStyles.indexOf( trKey ) !== -1) {

				trVal = layerData.transition[trKey];

				if( ! trVal && trVal !== 0 ) { continue; }

				trVal = trVal.toString();

				defVal 	= ( trKey.indexOf('scale') !== -1 ) ? 1 : 0;
				if( parseInt(trVal) !== defVal ) {
					transforms[ trKey ] = parseFloat( trVal );
				}
			}
		}

		// Styles
		var styles = {};
		for(var sKey in layerData.styles) {

			var cssVal = layerData.styles[sKey];

			if( ! cssVal && cssVal !== 0 ) { continue; }

			cssVal = cssVal.toString();
			if( cssVal.slice(-1) == ';' ) { cssVal = cssVal.substring(0, cssVal.length - 1); }

			styles[sKey] = isNumber(cssVal) ? cssVal + 'px' : cssVal;

			if( ['font-weight', 'opacity'].indexOf( sKey )  !== -1 ) {
				styles[sKey] = cssVal;
			}
		}

		// Locked layer
		layerData.hasTransforms = ! jQuery.isEmptyObject( transforms );


		if( layerData.locked ) { item.addClass('disabled'); }
		if( layerData.hasTransforms ) { item.addClass('transformed'); }

		// Apply style settings and attributes
		item.attr( jQuery.extend({}, innerAttrs, outerAttrs) ).attr({
			id: id,
			style: layerData.style,
		}).css(styles).css({
			zIndex: 500 - layerIndex,
			whiteSpace: !layerData.styles.wordwrap ? 'nowrap' : 'normal',
		}).addClass(layerData['class']);

		// Iframes & media embeds
		var $iframe = item.children('iframe,video').eq(0);
		if( $iframe.length ) {

			if( layerData.transition.backgroundvideo ) {

				item.addClass('disabled bgvideo').css({
					pointerEvents: 'none'
				});

				if( layerData.transition.overlay ) {
					if( layerData.transition.overlayer !== 'disabled' ) {
						jQuery('<div>', {
							'class': 'video-overlay',
							'style': 'background-image: url('+layerData.transition.overlay+')'
						}).appendTo( item );
					}
				}

				// Exit script
				LayerSlider.updatePreviewSelection();
				return;

			} else {

				var width 	= parseInt( $iframe.attr('width') ) || $iframe.width(),
					height 	= parseInt( $iframe.attr('height') ) || $iframe.height();

				if( ! layerData.styles.width ) {
					item.width( width );
				}

				if( ! layerData.styles.height ) {
					item.height( height );
				}
			}
		}

		if( item.is('img') ) {

			item.on( 'load', function(){
				LayerSlider.setPositions(item, top, left);
				LayerSlider.updatePreviewSelection();
				clearTimeout(LayerSlider.selectableTimeout);
				LayerSlider.selectableTimeout = setTimeout(function() {
					LayerSlider.updatePreviewSelection();
				}, 100);
			}).attr('src',item.attr('src') );
		}else{
			LayerSlider.setPositions(item, top, left);
			LayerSlider.updatePreviewSelection();
		}

		// DO TRANSFORMS
		transforms.transformPerspective = 500;
		transforms.transformOrigin = layerData.transition.transformoriginin || '50% 50% 0';

		if( transforms.transformOrigin.indexOf( 'slider') !== -1 ){

			var	sliderWidth = parseInt( window.lsSliderData.properties.sublayercontainer ) || parseInt( window.lsSliderData.properties.width ) || 1280,
				sliderHeight = parseInt( window.lsSliderData.properties.height ) || 720,
				itemLeft = parseFloat( item[0].style.left ),
				itemTop = parseFloat( item[0].style.top ),
				itemWidth = item.outerWidth(),
				itemHeight = item.outerHeight();

			transforms.transformOrigin = transforms.transformOrigin
			.replace( 'sliderleft', -itemLeft + 'px' )
			.replace( 'sliderright', sliderWidth - itemLeft + 'px' )
			.replace( 'slidercenter', sliderWidth / 2 - itemLeft + 'px' )
			.replace( 'slidermiddle', sliderHeight / 2 - itemTop + 'px' )
			.replace( 'slidertop', -itemTop + 'px' )
			.replace( 'sliderbottom', sliderHeight - itemTop + 'px' );
		}

		TweenMax.set( item[0], transforms );

		// Add draggable
		LayerSlider.addDraggable();
	},

	setPositions: function(item, top, left, returnOnly) {

		item.show();

		var cssTop 	= top ? parseInt(top) : 0,
			cssLeft = left ? parseInt(left) : 0,
			style = item[0].style,
			marginLeft = parseInt( style.marginLeft ) || 0,
			marginTop = parseInt( style.marginTop ) || 0;

		// Position the element
		if( top && top.indexOf('%') !== -1 ) {

			if( cssTop === 0 ) {
				cssTop = 0 + marginTop;
			} else if( cssTop === 100 ) {
				cssTop = LS_previewArea.height() - item.outerHeight() + marginTop;
			} else {
				cssTop = LS_previewArea.height() / 100 * cssTop - item.outerHeight() / 2 + marginTop;
			}
		} else if( LS_activeLayerIndexSet.length === 1 ) {
			cssLeft += marginLeft;
		}

		if( left && left.indexOf('%') !== -1 ) {

			if( cssLeft === 0 ) {
				cssLeft =  0 + marginLeft;
			} else if( cssLeft === 100 ) {
				cssLeft = LS_previewArea.width() - item.outerWidth() + marginLeft;
			} else {
				cssLeft = LS_previewArea.width() / 100 * cssLeft - item.outerWidth() / 2 + marginLeft;
			}
		} else if( LS_activeLayerIndexSet.length === 1 ) {
			cssTop += marginTop;
		}

		if( returnOnly ) {
			return {
				top: cssTop,
				left: cssLeft
			};
		}

		item.css({ top: cssTop, left: cssLeft });
	},



	previewItemAtIndex: function(index) {
		return LS_previewArea.children().eq(index);
	},


	updatePreviewSelection: function() {

		// Hide lasso and stop execution
		// if there's no selected layers
		if( ! LS_activeLayerIndexSet.length ||
			! LS_activeSlideData.sublayers.length ||
			jQuery('.ls-editing').length) {
			$lasso.hide();
			return;
		}

		if( LS_activeLayerIndexSet.length === 1 ) {
			var layerData = LS_activeLayerDataSet[0];
			if ( layerData && ( layerData.hasTransforms ||layerData.locked ) ) {
				$lasso.hide();
				return;
			}
		}

		var a = { left: Infinity, top: Infinity },
			b = { left: -Infinity, top: -Infinity };

		jQuery.each(LS_activeLayerIndexSet, function(idx, layerIndex) {
			var $item = LS_previewItems[layerIndex];
			if($item) {
				var p = $item.position(),
					q = {
						top: p.top + $item.outerHeight() * LS_previewZoom,
						left: p.left + $item.outerWidth() * LS_previewZoom
					};

				if( p.left < a.left ){ a.left = p.left; }
				if( p.top < a.top ){ a.top = p.top; }
				if( q.left > b.left ){ b.left = q.left; }
				if( q.top > b.top ){ b.top = q.top; }
			}
		});

		a.width = b.left - a.left;
		a.height = b.top - a.top;
		$lasso.css(a).show();

		if( ! $lasso.hasClass('ls-resizable-disabled') ) {
			$lasso.removeClass('ui-resizable-disabled').css(a).show();
		}

		// Mark the position of 0x0 px selection
		if( ! a.width || ! a.height ) {
			$lasso.addClass('ui-resizable-disabled');
		}
	},


	hidePreviewSelection: function() {
		jQuery('.ls-preview-wrapper').addClass('hide-selection');
	},


	showPreviewSelection: function() {
		jQuery('.ls-preview-wrapper').removeClass('hide-selection');
	},

	openMediaLibrary: function() {

		jQuery(document).on('click', '.ls-upload', function(e) {
			e.preventDefault();

			uploadInput = this;

			// Get library type
			var type = jQuery(this).hasClass('ls-insert-media') ? 'video,audio' : 'image';
			var multiple = jQuery(this).hasClass('ls-bulk-upload');

			// Media Library params
			var frame = wp.media({
				title : 'Pick an image to use it in LayerSlider WP',
				multiple : multiple,
				library : { type : type },
				button : { text : 'Insert' }
			});

			// Runs on select
			frame.on('select',function() {

				// Get attachment(s) data
				var attachment 	= frame.state().get('selection').first().toJSON(),
					attachments = frame.state().get('selection').toJSON(),
					updateInfo 	= [],
					previewImg, newLayerData;



				// Slide image upload
				// -------------------------------------
				if(jQuery(uploadInput).hasClass('ls-slide-image') ) {

					// Set image chooser preview
					previewImg = !typeof attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.sizes.full.url;
					LS_GUI.updateImagePicker( jQuery(uploadInput),  previewImg);

					// Add action to UndoManager
					LS_UndoManager.add('slide.general', 'Slide image', {
						itemIndex: LS_activeSlideIndex,
						undo: {
							background: LS_activeSlideData.properties.background,
							backgroundId: LS_activeSlideData.properties.backgroundId,
							backgroundThumb: LS_activeSlideData.properties.backgroundThumb
						},
						redo: {
							background: attachment.url,
							backgroundId: attachment.id,
							backgroundThumb: previewImg
						}
					});

					// Set current layer image
					LS_activeSlideData.properties.background = attachment.url;
					LS_activeSlideData.properties.backgroundId = attachment.id;
					LS_activeSlideData.properties.backgroundThumb = previewImg;


					// Set other images
					for(c = 1; c < attachments.length; c++) {

						// Get preview image url
						previewImg = !typeof attachments[c].sizes.thumbnail ? attachments[c].sizes.thumbnail.url : attachments[c].sizes.full.url;

						// Build new slide
						var newSlideData = jQuery.extend(true, {}, LS_DataSource.getDefaultSlideData());
							newSlideData.background = attachments[c].url;
							newSlideData.backgroundId = attachments[c].id;
							newSlideData.backgroundThumb = previewImg;

						// Add a layer
						newLayerData = jQuery.extend(true, {}, LS_DataSource.getDefaultLayerData());
						newLayerData.subtitle = 'Layer #1';

						// Add new layer
						window.lsSliderData.layers.push({
							properties: newSlideData,
							sublayers: [newLayerData]
						});

						// Add new slide tab
						var newIndex 	= window.lsSliderData.layers.length + 1,
							tab 		= jQuery('<a href="#"><span>Slide #'+newIndex+'</span><img src="'+previewImg+'" ><span class="dashicons dashicons-dismiss"></span>').insertBefore('#ls-add-layer');
					}


				// Name new slide properly
				LayerSlider.reindexSlides();


				// Slide thumbnail upload
				// -------------------------------------
				} else if(jQuery(uploadInput).hasClass('ls-slide-thumbnail') ) {

					// Set image chooser preview
					previewImg = !typeof attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.sizes.full.url;
					LS_GUI.updateImagePicker( jQuery(uploadInput),  previewImg);

					// Set current layer image
					LS_activeSlideData.properties.thumbnail = attachment.url;
					LS_activeSlideData.properties.thumbnailId = attachment.id;
					LS_activeSlideData.properties.thumbnailThumb = previewImg;


				// Layer image upload
				// -------------------------------------
				} else if(jQuery(uploadInput).hasClass('ls-layer-image') ) {

					// Set image chooser preview
					previewImg = !typeof attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.sizes.full.url;
					LS_GUI.updateImagePicker( jQuery(uploadInput),  previewImg);

					// Add action to UndoManager
					LS_UndoManager.add('layer.general', 'Layer image', {
						itemIndex: LS_activeLayerIndexSet[0],
						undo: {
							image: LS_activeLayerDataSet[0].image,
							imageId: LS_activeLayerDataSet[0].imageId,
							imageThumb: LS_activeLayerDataSet[0].imageThumb
						},
						redo: {
							image: attachment.url,
							imageId: attachment.id,
							imageThumb: previewImg
						}
					});

					// Set current layer image
					LS_activeLayerDataSet[0].image = attachment.url;
					LS_activeLayerDataSet[0].imageId = attachment.id;
					LS_activeLayerDataSet[0].imageThumb = previewImg;

					// Set other images
					for(c = 1; c < attachments.length; c++) {

						// Get preview image url
						previewImg = !typeof attachments[c].sizes.thumbnail ? attachments[c].sizes.thumbnail.url : attachments[c].sizes.full.url;

						// Build new layer
						newLayerData = jQuery.extend(true, {}, LS_DataSource.getDefaultLayerData());
						newLayerData.image = attachments[c].url;
						newLayerData.imageId = attachments[c].id;
						newLayerData.imageThumb = previewImg;
						newLayerData.styles.top = (10*c)+'px';
						newLayerData.styles.left = (10*c)+'px';

						// Add new layer
						LS_activeSlideData.sublayers.unshift(newLayerData);
						updateInfo.push({
							itemIndex: 0,
							undo: { data: {} },
							redo: { data: newLayerData }
						});
					}

					// Rebuild layers list
					LS_DataSource.buildLayersList();

					// Maintain UndoManager
					if(updateInfo.length) {
						LS_UndoManager.add('slide.layers', 'New layer(s)', updateInfo);
					}


				// Media (video/audio) image upload
				// -------------------------------------
				} else if( jQuery(uploadInput).hasClass('ls-media-image') ) {

					// Set image chooser preview
					previewImg = !typeof attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.sizes.full.url;
					LS_GUI.updateImagePicker( jQuery(uploadInput),  previewImg);

					// Add action to UndoManager
					LS_UndoManager.add('layer.general', 'Video poster', {
						itemIndex: LS_activeLayerIndexSet[0],
						undo: {
							poster: LS_activeLayerDataSet[0].poster,
							posterId: LS_activeLayerDataSet[0].posterId,
							posterThumb: LS_activeLayerDataSet[0].posterThumb
						},
						redo: {
							poster: attachment.url,
							posterId: attachment.id,
							posterThumb: previewImg
						}
					});

					// Set current layer poster
					LS_activeLayerDataSet[0].poster = attachment.url;
					LS_activeLayerDataSet[0].posterId = attachment.id;
					LS_activeLayerDataSet[0].posterThumb = previewImg;


				// Global slider background
				// -------------------------------------
				} else if( jQuery(uploadInput).hasClass('ls-global-background') ) {

					// Set image chooser preview
					previewImg = !typeof attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.sizes.full.url;
					LS_GUI.updateImagePicker( jQuery(uploadInput),  previewImg);

					// Store changes and update the preview
					window.lsSliderData.properties.backgroundimage = attachment.url;
					window.lsSliderData.properties.backgroundimageId = attachment.id;


				// YourLogo
				// -------------------------------------
				} else if( jQuery(uploadInput).hasClass('ls-yourlogo-upload') ) {

					// Set image chooser preview
					previewImg = !typeof attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.sizes.full.url;
					LS_GUI.updateImagePicker( jQuery(uploadInput),  previewImg);

					// Store changes and update the preview
					window.lsSliderData.properties.yourlogo = attachment.url;
					window.lsSliderData.properties.yourlogoId = attachment.id;


				// Multimedia HTML
				} else if( jQuery(uploadInput).hasClass('ls-insert-media')) {

					var hasVideo 	= false,
						hasAudio 	= false,

						videos 		= [],
						audios 		= [],

						url 		= '',
						mediaHTML 	= '';

					// Iterate over selected items
					for(c = 0; c < attachments.length; c++) {
						url = '/' + attachments[c].url.split('/').slice(3).join('/');
						if(attachments[c].type === 'video') {
							hasVideo = true;
							videos.push({ url: url, mime: attachment.mime });

						} else if(attachments[c].type === 'audio') {
							hasAudio = true;
							audios.push({ url: url, mime: attachment.mime });
						}
					}

					// Insert multimedia
					if(hasVideo) {
						mediaHTML += '<video width="320" height="240" preload="metadata" controls>\r\n';
						for(c = 0; c < videos.length; c++) {
							mediaHTML += '\t<source src="'+videos[c].url+'" type="'+videos[c].mime+'">\r\n';
						}
						mediaHTML += '</video>';
					}

					if(hasAudio) {

						if(hasVideo) { mediaHTML += '\r\n\r\n'; }

						mediaHTML += '<audio preload="metadata" nocontrols>\r\n';
						for(c = 0; c < audios.length; c++) {
							mediaHTML += '\t<source src="'+audios[c].url+'" type="'+audios[c].mime+'">\r\n';
						}
						mediaHTML += '</audio>';
					}

					LS_activeLayerDataSet[0].html = mediaHTML;
					jQuery(uploadInput).prev().val(mediaHTML);

				// Image with input field
				} else {
					jQuery(uploadInput).val( attachment.url );
					if(jQuery(uploadInput).is('input[name="image"]')) {
						jQuery(uploadInput).prev().attr('src', attachment.url);
					}
				}

				// Generate preview
				LayerSlider.generatePreview();
			});

			// Open ML
			frame.open();
		});
	},


	handleDroppedImages: function(event) {

		var oe 	= event.originalEvent,
			files = oe.dataTransfer.files,
			p = LS_previewArea.offset(),
			x = (jQuery(window).scrollLeft() + oe.clientX - p.left) / LS_previewZoom,
			y = (jQuery(window).scrollTop() + oe.clientY - p.top) / LS_previewZoom,
			updateInfo = [],
			layerDataSet = [],
			layerIndexSet = [],
			counter = 1;

		// Iterate over the dropped files
		jQuery.each(files, function(index, file) {
			LayerSlider.uploadImageToMediaLibrary(file, function(data) {

				// Build new layer
				var layerData = jQuery.extend(true, {}, LS_DataSource.getDefaultLayerData());
				layerData.image = data.url;
				layerData.imageId = data.id;
				layerData.imageThumb = data.sizes.thumbnail ? data.sizes.thumbnail.url : data.url;
				layerData.subtitle = file.name;
				layerData.styles.left = x+'px';
				layerData.styles.top = y+'px';

				layerIndexSet.push(0);
				layerDataSet.push(layerData);

				// Increase next layer offsets
				x += 20;
				y += 20;

				// Add new layers when every image
				// has been uploaded
				if(counter++ === files.length) {
					LayerSlider.addLayer( layerDataSet, layerIndexSet );
				}
			});
		});
	},


	uploadImageToMediaLibrary: function(file, callback) {
		if(file.type.indexOf('image') === 0) {

			// Build FormData object
			var formData = new FormData();
			formData.append('action', 'upload-attachment');
			formData.append('async-upload', file, file.name);
			formData.append('name', file.name);
			formData.append('_wpnonce', _wpPluploadSettings.defaults.multipart_params._wpnonce);

			jQuery.ajax({
				url: ajaxurl.replace('admin-ajax', 'async-upload'),
				method: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Upload error:' + errorThrown);
				},
				success: function(resp) {

					if(!resp || !resp.success) {
						alert('Upload error');
						return;
					}

					if(typeof callback != "undefined") {
						callback(resp.data);
					}
				}
			});
		}
	},

	addLayerSortables: function() {

		// Bind sortable function
		jQuery('.ls-sublayer-sortable').sortable({

			handle : 'span.ls-sublayer-sortable-handle',
			containment : 'parent',
			tolerance : 'pointer',
			axis : 'y',

			start: function() {
				LayerSlider.dragIndex = jQuery('.ui-sortable-placeholder').index() - 1;
			},

			change: function() {
				jQuery('.ui-sortable-helper').addClass('moving');
			},

			stop: function(event, ui) {

				// Get indexes
				var oldIndex = LayerSlider.dragIndex;
				var index = jQuery('.moving').removeClass('moving').index();

				LS_UndoManager.add('layer.order', 'Sort layers', {
					itemIndex: null,
					undo: { from: index, to: oldIndex },
					redo: { from: oldIndex, to: index }
				});

				if( index > -1 ){
					LS_Utils.moveArrayItem(LS_activeSlideData.sublayers, oldIndex, index);
				}

				// Update active layer index
				LS_activeLayerIndexSet = [];
				jQuery('.ls-sublayers li.active').each(function() {
					LS_activeLayerIndexSet.push( jQuery(this).index() );
				});

				// Reindex layers
				LayerSlider.reindexLayers();
				LayerSlider.generatePreview();
			}
		});
	},


	addSlideSortables: function() {

		jQuery('#ls-layer-tabs').sortable({

			containment: 'parent',
			tolerance: 'pointer',
			items: 'a:not(.unsortable)',

			start: function() {
				LayerSlider.dragIndex = jQuery('.ui-sortable-placeholder').index() - 1;
			},

			change: function() {
				jQuery('.ui-sortable-helper').addClass('moving');
			},

			stop: function(event, ui) {

				// Get indexes
				var oldIndex = LayerSlider.dragIndex,
					index = jQuery('.moving').removeClass('moving').index();

				if( index > -1 ){
					LS_Utils.moveArrayItem(window.lsSliderData.layers, oldIndex, index);
				}

				// Update active slide index
				LS_activeSlideIndex = jQuery('#ls-layer-tabs a.active').index();

				// Add static layers
				LS_activeStaticLayersDataSet = LayerSlider.staticLayersForSlide( LS_activeSlideIndex );

				// Reindex slides
				LayerSlider.reindexSlides();
				LayerSlider.reindexStaticLayers();
				LayerSlider.generateStaticPreview();
				LS_DataSource.buildLayersList();
			}
		});
	},


	addDraggable: function() {

		// Add dragables and update settings
		// while and after dragging
		LS_previewArea.children().draggable({
			snap: true,
			snapTolerance: 10,
			cancel: '.disabled,.transformed',
			start: function(e, ui) {

				// Fix for deselect
				if( !ui.helper.hasClass('ui-selected') ){
					ui.helper.addClass('ui-selected').trigger('selectablestop.ls');
				}

				// Store selected layers & lasso originalPosition
				$lasso.data('originalPosition', $lasso.position());
				jQuery('.ls-preview .ui-selected').each(function() {
					var pos = jQuery(this).position();
					jQuery(this).data('originalPosition', {
						'top': pos.top / LS_previewZoom,
						'left': pos.left / LS_previewZoom,
					});
				});
			},

			drag: function(event, ui) {
				LayerSlider.dragging(ui);
			},

			stop: function(event, ui) {

				var updateInfo = [];
				LayerSlider.dragging(ui);

				jQuery('.ls-preview .ui-selected').each(function() {

					var $layer 			= jQuery(this),
						index 			= $layer.index(),
						position 		= $layer.position(),
						newTop 			= Math.round( position.top / LS_previewZoom ) +'px',
						newLeft 		= Math.round( position.left / LS_previewZoom ) +'px',
						origPosition 	= $layer.data('originalPosition');


					// Maintain changes in data source
					LS_activeSlideData.sublayers[index].styles.top  = newTop;
					LS_activeSlideData.sublayers[index].styles.left = newLeft;

					// Gather changes for undoing
					updateInfo.push({
						itemIndex: index,
						undo: { left: origPosition.left+'px', top: origPosition.top+'px' },
						redo: { left: newLeft, top: newTop }
					});
				});

				// Add changes to undoManager
				LS_UndoManager.add('layer.style', 'Layer position', updateInfo.reverse());
			}
		});
	},


	dragging: function(ui) {

		// Fix positions when zoomed
		ui.position.top = Math.round(ui.position.top  / LS_previewZoom );
		ui.position.left = Math.round(ui.position.left / LS_previewZoom );

		var index 	= ui.helper.index(),
			top 	= Math.round( ui.position.top ),
			left 	= Math.round( ui.position.left );

		// Update input field values if it's visible
		if(LS_activeLayerIndexSet.length === 1) {

			// Update input fields
			jQuery('.ls-sublayer-style input[name="top"]').val( ui.helper.position().top / LS_previewZoom + 'px');
			jQuery('.ls-sublayer-style input[name="left"]').val( ui.helper.position().left / LS_previewZoom + 'px');
		}
	},


	resizing: function(e, ui) {

		var rh = ui.size.height / ui.originalSize.height,
			rw = ui.size.width / ui.originalSize.width,
			uiRatio = ui.originalSize.width / ui.originalSize.height,
			tagNames = [], layer, $layer, layerIndex, layerData, width,
			height, op, os, r;

			if( !$lasso.data( 'dragDirection') ){
				$lasso.data( 'dragDirection', rh === 1 ? 'horizontal' : 'vertical' );
			}

		// Update layer data
		jQuery('.ls-preview .ui-selected').each(function() {

			layer 		= this;
			$layer 		= jQuery(this);
			layerIndex 	= $layer.index();
			layerData 	= LS_activeSlideData.sublayers[layerIndex];

			tagNames.push( layer.tagName.toLowerCase() );

			op = $layer.data('originalPosition');
			os = $layer.data('originalSize');

			layerData.styles.top 	= layer.style.top 	= Math.round( (op.top - Math.round( ui.originalPosition.top / LS_previewZoom ) ) * rh + Math.round( ui.position.top / LS_previewZoom ) ) + 'px';
			layerData.styles.left 	= layer.style.left 	= Math.round( (op.left - Math.round( ui.originalPosition.left / LS_previewZoom ) ) * rw + Math.round( ui.position.left / LS_previewZoom ) ) + 'px';

			width = Math.round(os.width * rw) + 'px';
			height = Math.round(os.height * rh) + 'px';

			if( layerData.styles.width || $layer.is('img,div') ) {
				layerData.styles.width 	= width;
			}

			if( layerData.styles.height || $layer.is('img,div') ) {
				layerData.styles.height = height;
			}

			$layer.outerWidth(width);
			$layer.outerHeight(height);


			// Font-size only
			if( ! $layer.is( 'img, iframe, video, audio' ) ) {
				r = ui.size.width / ui.originalSize.width;
				layerData.styles['font-size'] 	= layer.style.fontSize 	= Math.round( r * os.fontSize ) +'px';

				if( os.lineHeight ) {
					layerData.styles['line-height'] = layer.style.lineHeight = Math.round( r * os.lineHeight ) +'px';
				}
			}

			if(LS_activeLayerIndexSet.length === 1) {

				if( layerData.styles.width || $layer.is('img,div') ) {
					jQuery('.ls-sublayer-style input[name="width"]').val( layer.style.width);
				}

				if( layerData.styles.height || $layer.is('img,div') ) {
					jQuery('.ls-sublayer-style input[name="height"]').val( layer.style.height);
				}

				jQuery('.ls-sublayer-style input[name="top"]').val( layer.style.top);
				jQuery('.ls-sublayer-style input[name="left"]').val( layer.style.left);
				jQuery('.ls-sublayer-style input[name="font-size"]').val(layerData.styles['font-size']);
				if( os.lineHeight ) {
					jQuery('.ls-sublayer-style input[name="line-height"]').val( layerData.styles['line-height']+'px' );
				}
			}
		});

		if( tagNames.indexOf('img') === -1 && tagNames.indexOf('div') === -1 ) {
			switch( $lasso.data( 'dragDirection') ){
				case 'horizontal':
					ui.size.height = ui.size.width / uiRatio;
				break;
				case 'vertical':
					ui.size.width = ui.size.height * uiRatio;
				break;
			}
		}

		// Update lasso size info
		$lasso.attr({
			'data-info-0': 'w: ' + Math.round(ui.size.width) + 'px',
			'data-info-1': 'h: ' + Math.round(ui.size.height) + 'px'
		});
	},


	listPreviewItems: function(e) {

		// Bail out if preview is active
		if( LayerSlider.isSlidePreviewActive || LayerSlider.isLayerPreviewActive ) {
			return;
		}

		// Vars to hold overlapping elements
		// and mouse position
		var items 	= [],
			mt 		= e.pageY;
			ml 		= e.pageX;

		// Loop through layers list
		LS_previewArea.children().each(function(layerIndex) {

			// Get layer item and data
			var $layer 		= jQuery(this),
				layerData 	= LS_activeSlideData.sublayers[ $layer.index() ],

				// Get layer positions and dimensions
				t = LS_previewArea.offset().top + $layer.position().top,
				l = LS_previewArea.offset().left + $layer.position().left,
				w = $layer.outerWidth() * LS_previewZoom,
				h = $layer.outerHeight() * LS_previewZoom;

			if( (mt > t && mt < t+h) && (ml > l && ml < l+w) ) {
				items.push({ index: layerIndex, data: layerData });
			}
		});

		// Create list holder
		if(items.length > 1) {

			// Remove previous list (if any)
			jQuery('.ls-preview-item-list').remove();

			// Create list
			var $list = jQuery('<ul class="ls-preview-item-list">').prependTo('body');
				$list.hide().css({ top: mt, left: ml }).fadeIn(100);

			// Close event
			jQuery('body').one('click', function() {
				jQuery('.ls-preview-item-list').animate({ opacity: 0 }, 200, function() {
					jQuery(this).remove();
				});
			});

			// Loop through intersecting elements (if any)
			jQuery.each(items, function(idx, data) {

				var layerIndex = data.index,
					layerData = data.data,

					$li = jQuery('<li><div></div><span>'+layerData.subtitle+'</span></li>').appendTo($list);
					$li.data('layerIndex', layerIndex);

				LayerSlider.setLayerMedia( layerData.media,  jQuery('div', $li), layerData );
			});
		}
	},


	highlightPreviewItem: function(el) {

		// Get layer related data
		var layerIndex = jQuery(el).data('layerIndex');
		var $previewItem = LS_previewArea.children().eq(layerIndex);


		// Highlight item
		$previewItem.addClass('highlighted').siblings().addClass('lowlighted');

	},


	selectPreviewItem: function(el) {

		// Select layer
		var layerIndex = jQuery(el).data('layerIndex');
		jQuery('.ls-sublayers li').eq(layerIndex).click();

		// Remove layer highlights (if any)
		LS_previewArea.children().removeClass('highlighted lowlighted');
	},


	editLayerToggle: function() {
		if(LS_activeLayerIndexSet.length === 1) {
			var $editing 	= jQuery('.ls-editing'),
				$layer 		= LS_previewItems[ LS_activeLayerIndexSet[0] ];

			if(!$editing.length) {
				this.editLayerStart($layer);
			} else {
				this.editLayerEnd($editing);
			}
		}
	},


	editLayerStart: function( $layer ) {

		// Bail out earily if it's an image layer
		if( $layer.is('img') ) { return false; }

		LayerSlider.selectLayer( [$layer.index() ] );

		// Get layer data
		var layerData = LS_activeLayerDataSet[0];

		// Bail out early if it's a locked layer
		if( $layer.hasClass('disabled') || layerData.locked) { return false; }

		// Enable editing
		$layer.addClass('disabled ls-editing')
			.prop('contenteditable', true)
			.focus();

		// Hide selectable/resizable
		$lasso.addClass('ui-resizable-disabled').hide();

		// Save current value for undoManager
		jQuery('.ls-html-code textarea').data('prevVal',layerData.html);

		// Select all text
		document.execCommand('selectAll');

		// End editing when clicking away
		jQuery(document).on('click.ls-editing', function(event) {
			if(!jQuery(event.target).hasClass('ls-editing')) {
				LayerSlider.editLayerEnd( jQuery('.ls-editing') );
			}
		});
	},

	editLayer: function(e) {
		if((e.metaKey || e.ctrlKey || e.altKey) && e.which === 13) {
			e.preventDefault();
			document.execCommand('insertHTML', false, '\r\n&nbsp;');
		}
	},

	editLayerUpdate: function(layer) {
		var content 	= layer.textContent,
			$textarea 	= jQuery('.ls-html-code textarea'),
			styles 		= LS_activeLayerDataSet[0].styles;

		$textarea.val(content);
		LS_activeLayerDataSet[0].html = content;

		LayerSlider.setPositions( jQuery(layer), styles.top, styles.left);
	},

	editLayerPaste: function(event) {
		event.preventDefault();
		document.execCommand('insertHTML', false,
			event.originalEvent.clipboardData.getData('text/plain')
		);
	},

	editLayerEnd: function($layer) {
		jQuery(document).off('click.ls-editing');
		$layer.prop('contenteditable', false).removeClass('disabled ls-editing');
		jQuery('.ls-html-code textarea').trigger('change');
		LayerSlider.updatePreviewSelection();
	},

	reindexLayers: function(el) {

		var layerCount = LS_activeSlideData.sublayers.length;
			layerCount = layerCount ? layerCount : 0;

		// Reindex default layers' title
		jQuery('#ls-layers .ls-sublayers > li').each(function(index) {
			var layerTitle = jQuery(this).find('.ls-sublayer-title').val();
			if( layerTitle.indexOf('Layer #') != -1 && layerTitle.indexOf('copy') == -1) {
				jQuery(this).find('.ls-sublayer-title').val('Layer #' + (layerCount-index));
			}
		});
	},


	reindexSlides: function() {

		jQuery('#ls-layer-tabs a:not(.unsortable)').each(function(index) {

			var title 		= jQuery('span:first-child', this).text(),
				slideData 	= window.lsSliderData.layers[ index ],
				src 		= slideData.properties.backgroundThumb || pluginPath+'admin/img/blank.gif';


			if( title.indexOf('copy') === -1 && title.indexOf('Slide #') !== -1 ) {
				title = 'Slide #' + (index + 1);
			}

			jQuery(this)
				.attr({
					'data-help': "<div style='background-image: url("+src+");'></div>",
					'data-help-class': 'ls-slide-preview-tooltip popover-light',
					'data-help-delay': 1,
					'data-help-transition': false
				}).html('<span>'+title+'</span><span class="dashicons dashicons-dismiss"></span>');
		});
	},

	checkMediaAutoPlay: function( $textarea, prop, val ) {

		clearTimeout(LayerSlider.mediaCheckTimeout);
		LayerSlider.mediaCheckTimeout = setTimeout(function() {

			if( val.indexOf('autoplay') !== -1 ) {

				var $media = jQuery(val).filter('iframe'),
					autoplayDetected = false;

				 if( $media.is('iframe') ) {

					var URL = $media.attr('src').split('?'),
						targetIndex = -1;

					if( URL[1] ) {
						params = URL[1].split('&');
						jQuery.each(params, function(index, item) {
							if( item.indexOf('autoplay') !== -1 ) {
								autoplayDetected = true;
								targetIndex = index;
							}
						});

						if( targetIndex > -1 ) {
							params.splice(targetIndex, 1);
						}
					}

					if( typeof params !== 'undefined' ) {
						$media.attr('src', URL[0]+'?'+params.join('&') );
					}

				 } else if( $media.is('video') || $media.is('audio') ) {
					autoplayDetected = true;
					$media.removeAttr('autoplay');
				 }


				 if( autoplayDetected ) {

					$textarea.val( $media[0].outerHTML );
					$autoplay = jQuery('select[name="autoplay"]');

					jQuery('option', $autoplay)
						.prop('selected', false)
						.eq(1).prop('selected', true);

					TweenLite.to($autoplay[0], 0.2, {
						css: { scale: 1.3 },
						onComplete: function() {
							TweenLite.to($autoplay[0], 0.2, {
								css: { scale: 1 }
							});
						}
					});
				}
			}
		}, 100, $textarea, prop, val);
	},

	startSlidePreview: function( sliderOptions ) {

		// Stop **layer** preview if it's currently running
		// to prevent simultaneous instances
		this.stopLayerPreview(true);

		// Stop slide preview if it's currently running
		if(this.isSlidePreviewActive) {
			LayerSlider.stopSlidePreview();
			return true;
		}

		this.isSlidePreviewActive = true;

		sliderOptions = sliderOptions || {};

		// Get slider settings and preview container
		var sliderProps = window.lsSliderData.properties,

		// Slider settings
			width 		= sliderProps.width,
			height 		= sliderProps.height,
			posts 		= window.lsPostsJSON,
			callbacks 	= window.lsSliderData.callbacks;

		// Switch between preview and editor
		var  $slider  = jQuery('#ls-layers .ls-real-time-preview').show();
		 $slider  = jQuery('<div id="ls-preview-timeline" class="ls-wp-container">').appendTo( $slider );
		jQuery('#ls-layers .ls-preview').hide();
		jQuery('#ls-layers .ls-preview-button').html('Stop').addClass('playing');
		LayerSlider.hidePreviewSelection();

		// Iterate over the slides
		jQuery.each(window.lsSliderData.layers, function(slideIndex, slideData) {

			// Slide data
			var slideProps = slideData.properties,
				layers = slideData.sublayers.reverse();

			// Get post content if any
			var postOffset = slideProps.post_offset;
			if(postOffset == -1) { postOffset = slideIndex; }
			var post = posts[postOffset];

			// Slide attributes
			var properties = '', sKey, sVal;
			for( sKey in slideProps) {
				sVal = slideProps[ sKey ];
				if( sVal !== '' && sVal !== 'null' ) {

					// Slide BG inheritance
					if( sKey === 'bgsize' && sVal === 'inherit' ) {
						sVal = sliderProps.slideBGSize;

					} else if( sKey === 'bgposition' && sVal === 'inherit' ) {
						sVal = sliderProps.slideBGPosition;
					}

					properties += sKey+':'+sVal+';';
				}
			}

			// Build the Slide
			var layer = jQuery('<div class="ls-slide">')
							.attr('data-ls', properties)
							.appendTo( $slider );

			// Get background
			var background = slideProps.background;
			if(background === '[image-url]') {
				background = post['image-url'];
			}

			// Add background
			if(background) {
				jQuery('<img src="'+background+'" class="ls-bg">').appendTo(layer);
			}

			// Get selected transitions
			var tr2d = slideProps['2d_transitions'],
				tr3d = slideProps['3d_transitions'],
				tr2dcustom = slideProps.custom_2d_transitions,
				tr3dcustom = slideProps.custom_3d_transitions;

			// Apply transitions
			if(tr2d) layer.attr('data-ls', layer.attr('data-ls') + ' transition2d: '+tr2d+'; ');
			if(tr3d) layer.attr('data-ls', layer.attr('data-ls') + ' transition3d: '+tr3d+'; ');
			if(tr2dcustom) layer.attr('data-ls', layer.attr('data-ls') + ' customtransition2d: '+tr2dcustom+'; ');
			if(tr3dcustom) layer.attr('data-ls', layer.attr('data-ls') + ' customtransition3d: '+tr3dcustom+'; ');


			// Iterate over layers
			jQuery.each(layers, function(layerKey, layerData) {
				LayerSlider.appendLivePreviewItem(layerKey, layerData, layer, post);
			});

			// Revert back to original layer order, as the reversed
			// layers list is only a visual thing on the admin UI.
			slideData.sublayers.reverse();
		});

		// Get slider settings
		var autoPlayVideos = sliderProps.autoplayvideos;
			autoPlayVideos = autoPlayVideos ? true : false;

		// Callbacks
		if( callbacks ) {
			for( var key in callbacks ) {

				var callback 	= callbacks[ key ],
					startIndex 	= callback.indexOf('{') + 1,
					endIndex 	= callback.length - 1;

					body 	= callback.substring(startIndex, endIndex);

				$slider.on(key, new Function('event', 'slider', body));
			}
		}

		// Init layerslider
		$slider.layerSlider( jQuery.extend( true, {
			type: 'responsive',
			width: width,
			height: height,
			skin: 'v6',
			skinsPath: pluginPath + 'layerslider/skins/',
			firstSlide: LS_activeSlideIndex + 1,
			autoStart: true,
			pauseOnHover: false,
			startInViewport: false,
			autoPlayVideos: autoPlayVideos,
			slideBGSize: sliderProps.slideBGSize,
			slideBGPosition: sliderProps.slideBGPosition,
			globalBGColor: sliderProps.backgroundcolor,
			globalBGImage: sliderProps.backgroundimage,
			globalBGAttachment: sliderProps.globalBGAttachment,
			globalBGRepeat: sliderProps.globalBGRepeat,
			globalBGPosition: sliderProps.globalBGPosition,
			globalBGSize: sliderProps.globalBGSize,
			parallaxScrollReverse: sliderProps.parallaxScrollReverse,
			playByScroll: sliderProps.playByScroll ? true : false,
			playByScrollSpeed: sliderProps.playByScrollSpeed || 1,
			navButtons: false,
			navStartStop: false,
			allowRestartOnResize: sliderProps.allowRestartOnResize ? true : false

		}, sliderOptions )).on('slideTimelineDidComplete', function( event, slider ) {
			if( jQuery('.ls-timeline-switch li').eq(0).hasClass('active') ) {
				slider.api('replay');
				return false;
			}

		}).on( 'slideTimelineDidCreate', function(){
			jQuery( '.ls-slidebar-slider' ).attr({
				'data-help': 'Drag me :)',
				'data-km-ui-popover-once': 'true',
				'data-km-ui-popover-theme': 'red',
				'data-km-ui-popover-autoclose': 3,
				'data-km-ui-popover-distance': 20
			}).trigger( 'mouseenter' );
		});
	},


	stopSlidePreview: function() {

		if( this.isSlidePreviewActive ) {
			this.isSlidePreviewActive = false;

			// Show the editor
			jQuery('#ls-layers .ls-preview').show();

			// Stop LayerSlider and empty the preview contents
			var layersliders = jQuery('#ls-layers .ls-real-time-preview');
			layersliders.find('.ls-container').layerSlider( 'destroy', true );
			layersliders.hide();

			// Rewrote the Preview button text
			jQuery('#ls-layers .ls-preview-button').text('Slide').removeClass('playing');
			LayerSlider.generatePreview();
			LayerSlider.showPreviewSelection();
			LayerSlider.updatePreviewSelection();

			// Remove timeline
			jQuery('.ls-timeline-switch li:first-child').click();

			// SET: layer editor size
			kmUI.smartResize.set();
		}
	},


	startLayerPreview: function(button, forceStop) {

		// Stop **slide** preview if it's currently running
		// to prevent simultaneous instances
		this.stopSlidePreview();

		// Stop or restart current preview session (if any)
		if(this.isLayerPreviewActive){
			LayerSlider.stopLayerPreview(forceStop);

			if( !!forceStop ){
				return;
			}
		}

		// Change preview state
		this.isLayerPreviewActive = true;
		jQuery(button).addClass('playing').text('Stop');

		// Hide other layers
		LayerSlider.hidePreviewSelection();
		LS_previewArea.children().addClass('ls-transparent');

		// Create container element
		var $wrapper = jQuery('<div>').addClass('ls-layer-preview-wrapper').appendTo('.ls-preview-wrapper');

		// Slide properties
		var slideProps = LS_activeSlideData.properties,
			postOffset = slideProps.post_offset;

		if(postOffset == -1) { postOffset = LS_activeSlideIndex; }
		var post = window.lsPostsJSON[postOffset];

		// Slide attributes
		var properties = '', sKey, sVal;
		for( sKey in slideProps) {
			sVal = slideProps[ sKey ];

			// Don't allow empty values & force auto slide duration
			if( sVal !== '' && sVal !== 'null' && sKey !== 'slidedelay' ) {
				properties += sKey+':'+sVal+';';
			}
		}

		// Add slide
		$s1 = jQuery('<div>').attr({
			'class': 'ls-slide',
			'data-ls': properties
		}).appendTo($wrapper);

		// Get layer data
		var item = LS_activeLayerDataSet[0],
			layerData = jQuery.extend(true, {}, item);
			layerData.transition.delayin = 100;


		LayerSlider.appendLivePreviewItem(0, layerData, $s1, post);

		item.skip = true;
		LS_previewItems[ LS_activeLayerIndexSet[0] ].addClass('ls-invisible');

		// Initialize slider
		$wrapper.layerSlider({
			type: 'responsive',
			width: window.lsSliderData.properties.width,
			height: window.lsSliderData.properties.height,
			skin: 'v6',
			skinsPath: pluginPath + 'layerslider/skins/',
			pauseOnHover: false,
			autoPlayVideos: false,
			startInViewport: false,
			keybNav: false,
			navButtons: false,
			navStartStop: false,
			navPrevNext: false
		}).on('slideTimelineDidComplete', function( event, slider ) {
			if( jQuery('.ls-timeline-switch li').eq(0).hasClass('active') ) {
				slider.api('replay');
				return false;
			}
		});

	},


	updateLayerPreview: function() {

		var $slider = jQuery('.ls-real-time-preview .ls-container'),
			$layer 	= jQuery('.ls-layer', $slider);



		$slider.layerSlider( 'updateLayerData', $layer, 'scalein: 2; rotatein: 360; scaleout: 2; rotateout: 360; rotate: -45;' );
	},


	stopLayerPreview: function(forceStop){

		if(this.isLayerPreviewActive) {

			// Change preview state
			this.isLayerPreviewActive = false;
			LayerSlider.showPreviewSelection();
			jQuery('.ls-layer-preview-button').removeClass('playing').text('Layer');

			jQuery.each(LS_activeLayerDataSet, function(index, item) {
				item.skip = false;
			});

			// Restore editing area
			// LS_activeLayerDataSet.skip = false;
			if( forceStop ){
				jQuery.each(LS_activeLayerIndexSet, function(index, item) {
					LayerSlider.generatePreviewItem( item );
				});
			}

			jQuery('.ls-layer-preview-wrapper').layerSlider( 'destroy', true );
			LS_previewArea.children().removeClass('ls-transparent');
		}
	},


	appendLivePreviewItem: function(layerKey, layerData, $slide, post) {

		// Skip sublayer?
		if( !!layerData.skip || layerData['hide_on_'+LS_activeScreenType] ) {
			return true;
		}

		// Gather sublayer data
		var type = layerData.type;
		switch( layerData.media ) {
			case 'img':
				type = 'img';
				break;
			case 'html':
			case 'media':
				type = 'div';
				break;
			case 'post':
				type = 'post';
				break;
		}

		var image = layerData.image,
			html = layerData.html,
			style = layerData.style,
			top = layerData.styles.top,
			left = layerData.styles.left,
			skip = layerData.hasOwnProperty('skip'),
			url = layerData.url,
			id = layerData.id,
			classes = layerData['class'],

			innerAttrs = layerData.innerAttributes || {},
			outerAttrs = layerData.outerAttributes || {};

		// Sublayer properties
		var sublayerprops = '', trKey, trVal;
		for( trKey in layerData.transition) {

			trVal = layerData.transition[ trKey ];

			if( trKey.indexOf('perspective') !== -1 &&  trVal.toString() === '500') {
				continue;

			}

			if( trKey === 'backgroundvideo' && ! trVal ) {
				continue;
			}

			if( trVal !== '' && trVal !== null && trVal !== 'null' && trVal !== 'inherit' ) {
				sublayerprops += trKey+':'+trVal+';';
			}
		}


		// Styles
		var styles = {}, cssProp, cssVal;
		for( cssProp in layerData.styles ) {
			cssVal = layerData.styles[cssProp];

			if( ! cssVal && cssVal !== 0 ) { continue; }
			cssVal = cssVal.toString();

			if(cssVal.slice(-1) == ';' ) {
				cssVal = cssVal.substring(0, cssVal.length - 1);
			}
			if (cssVal) { // !! fix for unused styles don't override Custom CSS
				styles[cssProp] = isNumber(cssVal) ? cssVal + 'px' : cssVal;

				if( ['font-weight', 'opacity'].indexOf( cssProp )  !== -1 ) {
					styles[cssProp] = cssVal;
				}
			}
		}

		// Build the sublayer
		var sublayer;
		if(type == 'img') {
			if(!image) { return true; }
			if(image == '[image-url]') { image = post['image-url']; }

			sublayer = jQuery('<img src="'+image+'" class="ls-l">').appendTo($slide);

		} else if(type == 'post') {

			// Parse post placeholders
			var textlength = layerData.post_text_length;
			for(var key in post) {
				if(html.indexOf('['+key+']') !== -1) {
					if( (key == 'title' || key == 'content' || key == 'excerpt') && textlength > 0) {
						post[key] = post[key].substr(0, textlength);
					}
					html = html.replace('['+key+']', post[key]);
				}
			}

			// Test html
			html = jQuery.trim(html);
			var first = html.substr(0, 1);
			var last = html.substr(html.length-1, 1);
			if(first == '<' && last == '>') {
				html = html.replace(/(\r\n|\n|\r)/gm,"");
				sublayer = jQuery(html).appendTo($slide).addClass('ls-l');
			} else {
				sublayer = jQuery('<div>').appendTo($slide).html(html).addClass('ls-l');
			}

		} else {
			sublayer = jQuery('<'+type+'>').appendTo($slide).html(html).addClass('ls-l');

			// Rewrite Youtube/Vimeo iframe src to data-src
			var $video = sublayer.find('iframe[src*="youtube-nocookie.com"], iframe[src*="youtube.com"], iframe[src*="youtu.be"], iframe[src*="player.vimeo"]');
			if( $video.length ) {
				$video.attr('data-src', $video.attr('src') ).removeAttr('src');
			}
		}

		// Apply styles
		sublayer
			.attr({ 'id': id, 'style': style })
			.css(styles)
			.css('white-space', !layerData.styles.wordwrap ? 'nowrap' : 'normal')
			.addClass(classes);

		// Apply attributes
		for( var iaKey in innerAttrs ) {
			if( iaKey.toLowerCase() === 'class' ) {
				sublayer.addClass( innerAttrs[iaKey] );
				continue;
			}

			sublayer[0].setAttribute(iaKey, innerAttrs[iaKey]);
		}

		// Position the element
		if(top.indexOf('%') != -1) { sublayer.css({ top : top });
			} else { sublayer.css({ top : parseInt(top) }); }

		if(left.indexOf('%') != -1) { sublayer.css({ left : left });
			} else { sublayer.css({ left : parseInt(left) }); }

		if( url ) {
			var anchor = jQuery('<a href="'+url+'" target="_blank"></a>');
				anchor.attr( outerAttrs );

			sublayer.wrap( anchor );
		} else {

			// Apply attributes
			for( var oaKey in outerAttrs ) {
				if( oaKey.toLowerCase() === 'class' ) {
					sublayer.addClass( outerAttrs[oaKey] );
					continue;
				}

				sublayer[0].setAttribute(oaKey, outerAttrs[oaKey]);
			}
		}

		sublayer.attr('data-ls', sublayerprops);
	},


	openTransitionGallery: function() {

		// Create overlay
		jQuery('body').prepend( jQuery('<div>', { 'class' : 'ls-overlay'}));

		// Load transition selector modal window
		jQuery(jQuery('#tmpl-ls-transition-modal').html()).prependTo('body');

		// Append transitions
		LayerSlider.appendTransition('', '2d_transitions', layerSliderTransitions.t2d);
		LayerSlider.appendTransition('', '3d_transitions', layerSliderTransitions.t3d);

		// Append custom transitions
		if(typeof layerSliderCustomTransitions != "undefined") {
			if(layerSliderCustomTransitions.t2d.length) {
				LayerSlider.appendTransition('Custom 2D transitions', 'custom_2d_transitions', layerSliderCustomTransitions.t2d);
			}
			if(layerSliderCustomTransitions.t3d.length) {
				LayerSlider.appendTransition('Custom 3D transitions', 'custom_3d_transitions', layerSliderCustomTransitions.t3d);
			}
		}

		// Select proper tab
		jQuery('#ls-transition-window .filters li.active').click();

		// Close event
		jQuery(document).one('click', '.ls-overlay', function() {
			LayerSlider.closeTransitionGallery();
		});


		jQuery('#ls-transition-window').show();
	},


	closeTransitionGallery: function() {

		jQuery('#ls-transition-window').remove();
		jQuery('.ls-overlay').remove();
	},


	appendTransition: function(title, tbodyclass, transitions) {

		// Append new tbody
		var tbody = jQuery('<tbody>').data('tr-type', tbodyclass).appendTo('#ls-transition-window table');

		// Get checked transitions
		var checked = LS_activeSlideData.properties[tbodyclass];
			checked = checked ? checked.split(',') : [];

		if(title) {
			jQuery('<tr>').appendTo(tbody).append('<th colspan="4">'+title+'</th>');
		}

		for(c = 0; c < transitions.length; c+=2) {

			// Append new table row
			var tr = jQuery('<tr>').appendTo(tbody)
				.append( jQuery('<td class="c"></td>') )
				.append( jQuery('<td></td>') )
				.append( jQuery('<td class="c"></td>') )
				.append( jQuery('<td></td>')
			);

			// Append transition col 1 & 2
			tr.children().eq(0).append('<i>'+(c+1)+'</i><i class="dashicons dashicons-yes"></i>');
			tr.children().eq(1).append( jQuery('<a>', { 'href' : '#', 'html' : transitions[c].name+'', 'data-key' : (c+1) } ) );
			if(transitions.length > (c+1)) {
				tr.children().eq(2).append('<i>'+(c+2)+'</i><i class="dashicons dashicons-yes"></i>');
				tr.children().eq(3).append( jQuery('<a>', { 'href' : '#', 'html' : transitions[(c+1)].name+'', 'data-key' : (c+2) } ) );
			}

			// Check transitions
			if(checked.indexOf(''+(c+1)+'') != -1 || checked == 'all') {
				tr.children().eq(0).addClass('added');
				tr.children().eq(1).addClass('added');
			}

			if((checked.indexOf(''+(c+2)+'') != -1 || checked == 'all') ) {
				tr.children().eq(2).addClass('added');
				tr.children().eq(3).addClass('added');
			}
		}
	},


	selectAllTransition: function(index, check) {

		// Get checkbox and transition type
		var checkbox = jQuery('#ls-transition-window header i:last');
		var cat = jQuery('#ls-transition-window tbody').eq(index).data('tr-type');

		if(check) {

			jQuery('#ls-transition-window tbody').eq(index).find('td').addClass('added');
			checkbox.attr('class', 'on').text('Deselect all');
			LS_activeSlideData.properties[cat] = 'all';

		} else {

			jQuery('#ls-transition-window tbody').eq(index).find('td').removeClass('added');
			checkbox.attr('class', 'off').text('Select all');
			LS_activeSlideData.properties[cat] = '';
		}
	},

	toggleTransition: function(el) {

		// Toggle addded class
		if(jQuery(el).parent().hasClass('added')) {
			jQuery(el).parent().removeClass('added').prev().removeClass('added');

		} else {
			jQuery(el).parent().addClass('added').prev().addClass('added');
		}

		// Get transitions
		var trs = jQuery(el).closest('tbody').find('td');

		// All selected
		if(trs.filter('.c.added').length == trs.filter('.c').length) {

			LayerSlider.selectAllTransition( jQuery(el).closest('tbody').index(), true );
			return;

		// Uncheck select all
		} else {

			// Check the checkbox
			jQuery('#ls-transition-window header i:last').attr('class', 'off').text('Select all');
		}

		// Get category
		var cat = jQuery(el).closest('tbody').data('tr-type');

		// Gather checked selected transitions
		var checked = [];
		trs.filter('.added').find('a').each(function() {
			checked.push( jQuery(this).data('key') );
		});

		// Set data
		LS_activeSlideData.properties[cat] = checked.join(',');
	},


	save: function(el) {

		// Bring all layers back in,
		// as it can mess with saving.
		this.stopLayerPreview(true);

		// Get the slider data
		var sliderData = jQuery.extend(true, {}, window.lsSliderData);

		// Temporary disable submit button
		jQuery('.ls-publish').addClass('saving').find('button').text('Saving ...').attr('disabled', true);

		// Serialize slider settings to prevent jQuery form converting form data
		sliderData.properties = JSON.stringify(sliderData.properties);

		// 1. Iterate over the slides and encode them
		//    to workaround PHP's array size limitation.
		//
		// 2. Iterate over the styles object of layers
		//    to remove empty values added mistakenly.
		//
		// 3. Also check whether they use dynamic content.
		jQuery.each(sliderData.layers, function(slideIndex, slideData) {
			slideData.properties.post_content = false;
			jQuery.each(slideData.sublayers, function(layerIndex, layerData) {

				if( layerData.styles ) {
					jQuery.each(layerData.styles, function(cssIndex, cssVal) {
						if( cssVal === '' ) {
							delete layerData.styles[cssIndex];
						}
					});
				}

				layerData.transition 	= JSON.stringify(layerData.transition);
				layerData.styles 		= JSON.stringify(layerData.styles);

				if(slideData.properties.post_content === false && layerData.media == 'post') {
					slideData.properties.post_content = true;
				}
			});

			// Reverse the list of layers, as it is only
			// a visual thing on the admin UI.
			slideData.sublayers.reverse();
			sliderData.layers[slideIndex] = JSON.stringify(slideData);
		});


		// Save slider
		jQuery.ajax({
			type: 'POST', url: ajaxurl, dataType: 'text',
			data: {
				_wpnonce: jQuery('#_wpnonce').val(),
				_wp_http_referer: jQuery('#ls-slider-form input[name="_wp_http_referer"]').val(),
				action: 'ls_save_slider',
				id: LS_sliderID,
				sliderData: sliderData
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('It seems there is a server issue that prevented LayerSlider from saving your work. Please check LayerSlider -> System Status for potential errors, try to temporarily disable themes/plugins to rule out incompatibility issues or contact your hosting provider to resolve server configuration problems. Your HTTP server thrown the following error: \n\r\n\r' + errorThrown);
			},
			complete: function(data) {

				// Consider the editor as "clean", do not show
				// unsaved changes warning when leaving the page.
				LS_editorIsDirty = false;

				// Button feedback
				jQuery('.ls-publish').removeClass('saving').addClass('saved').find('button').text('Saved');
				setTimeout(function() {
					jQuery('.ls-publish').removeClass('saved').find('button').text('Save changes').attr('disabled', false);
				}, 2000);
			}
		});
	},
};



var LS_PostOptions = {

	init: function() {

		jQuery('#ls-layers').on('click', '.ls-configure-posts', function(e) {
			e.preventDefault(); LS_PostOptions.open(this);
		});

		jQuery('.ls-configure-posts-modal .header a').click(function(e) {
			e.preventDefault(); LS_PostOptions.close();
		});

		jQuery('#ls-post-options select:not(.ls-post-taxonomy, .post_offset)').change(function() {
			window.lsSliderData.properties[ jQuery(this).attr('name') ] = jQuery(this).val();
			LS_PostOptions.change(this);
		});

		jQuery('#ls-post-options select.offset').change(function() {
			LS_activeSlideData.properties.post_offset = jQuery(this).val();
			LayerSlider.willGeneratePreview();
		});

		jQuery('#ls-post-options select.ls-post-taxonomy').change(function() {
			window.lsSliderData.properties.post_taxonomy = jQuery(this).val();
			LS_PostOptions.getTaxonoies(this);
		});

		jQuery('#ls-layers').on('click', '.ls-post-placeholders li', function() {
			LS_PostOptions.insertPlaceholder(this);
		});
	},


	open: function(el) {

		// Create overlay
		jQuery('body').prepend(jQuery('<div>', { 'class' : 'ls-overlay'}));

		// Get slide's post offset
		var offset = parseInt(LS_activeSlideData.properties.post_offset) + 1;

		// Show modal window
		var modal = jQuery('#ls-post-options').show();
			modal.find('select.offset option').prop('selected', false).eq(offset).prop('selected', true);

		// Close event
		jQuery(document).one('click', '.ls-overlay', function() {
			LS_PostOptions.close();
		});

		// First open?
		if(modal.find('.ls-post-previews ul').children().length === 0) {
			LS_PostOptions.change( modal.find('select')[0] );
		}
	},


	getTaxonoies: function(select) {

		var target = jQuery(select).next().empty();

		if(jQuery(select).val() == 0) {
			LS_PostOptions.change(select);

		} else {

			jQuery.post(ajaxurl, jQuery.param({ action : 'ls_get_taxonomies', taxonomy : jQuery(select).val() }), function(data) {
				data = jQuery.parseJSON(data);
				for(c = 0; c < data.length; c++) {
					target.append( jQuery('<option>', { 'value' : data[c].term_id, 'text' : data[c].name }));
				}
			});
		}
	},


	change: function(el) {

		// Get options
		var items = {};
		jQuery('#ls-post-options').find('select').each(function() {
			items[ jQuery(this).data('param') ] = jQuery(this).val();
		});

		jQuery.post(ajaxurl, jQuery.param({ action: 'ls_get_post_details', params : items }), function(data) {

			// Handle data
			var parsed = jQuery.parseJSON(data);
			window.lsPostsJSON = parsed;

			// Update preview
			LayerSlider.willGeneratePreview();
			LS_PostOptions.update(el, parsed );
		});
	},


	update: function(el, data) {

		var preview = jQuery('#ls-post-options').find('.ls-post-previews ul').empty();

		if(data.length === 0) {
			preview.append( jQuery('<li>')
				.append( jQuery('<h4>', { 'text' : 'No posts were found with the current filters.' }) )
			);

		} else {
			for(c = 0; c < data.length; c++) {
				preview.append( jQuery('<li>')
					.append( jQuery('<span>', { 'class' : 'counter', 'text' : ''+(c+1)+'. ' }))
					.append( jQuery('<img>', { 'src' : data[c].thumbnail } ))
					.append( jQuery('<h3>', { 'html' : data[c].title } ))
					.append( jQuery('<p>', { 'html' : data[c].content } ))
					.append( jQuery('<span>', { 'class' : 'author', 'text' : data[c]['date-published']+' by '+data[c].author } ))
				);
			}
		}
	},


	close: function() {
		jQuery('#ls-post-options').hide();
		jQuery('.ls-overlay').remove();
	},


	insertPlaceholder: function(el) {

		var element = jQuery(el).closest('.ls-sublayer-page').find('textarea[name="html"]')[0];
		var text = (typeof jQuery(el).data('placeholder') != "undefined") ? jQuery(el).data('placeholder') : jQuery(el).children().text();

		if (document.selection) {
			element.focus();
			var sel = document.selection.createRange();
			sel.text = text;
			element.focus();
		} else if (element.selectionStart || element.selectionStart === 0) {
			var startPos = element.selectionStart;
			var endPos = element.selectionEnd;
			var scrollTop = element.scrollTop;
			element.value = element.value.substring(0, startPos) + text + element.value.substring(endPos, element.value.length);
			element.focus();
			element.selectionStart = startPos + text.length;
			element.selectionEnd = startPos + text.length;
			element.scrollTop = scrollTop;
		} else {
			element.value += text;
			element.focus();
		}

		jQuery('#ls-layers').triggerHandler(jQuery.Event('input', {
			target: element
		}));

		jQuery(element).keyup();
	}
};



var LS_DataSource = {

	buildSlide: function() {

		var $slide = jQuery('#ls-layers .ls-layer-box');
		var $slideOptions = $slide.find('.ls-slide-options');

		// Reset checkboxes
		$slideOptions.find('.ls-checkbox').remove();
		$slideOptions.find('input:checkbox').prop('checked', false);

		// Get default slide options
		var defaults = LS_DataSource.getDefaultSlideData();

		// Loop through slide option form items
		var $formItems = jQuery($slideOptions.find('input,textarea,select'));
		LS_DataSource.setFormItemValues($formItems, LS_activeSlideData.properties, defaults);

		// Set checboxes and color picker
		$slideOptions.find('input:checkbox').customCheckbox();
		LayerSlider.addColorPicker( $slideOptions.find('.ls-colorpicker') );

		// Set image placeholders
		LS_GUI.updateImagePicker( 'background', LS_activeSlideData.properties.backgroundThumb );
		LS_GUI.updateImagePicker( 'thumbnail', LS_activeSlideData.properties.thumbnailThumb );

		this.buildLayersList();
	},


	buildLayersList: function( buildProperties ) {

		buildProperties = buildProperties || { updateLayer: true };

		// Get the layer list and empty it (if any)
		var $layersList = jQuery('#ls-layers .ls-sublayers').empty();

		// Build layers
		var numOfLayers = !LS_activeSlideData.sublayers ? 0 : LS_activeSlideData.sublayers.length;
		var $template = jQuery(jQuery('#ls-layer-item-template').html());

		for(var c = 0; c < numOfLayers; c++) {

			var layerData = LS_activeSlideData.sublayers[c];
			var $layer = $template.clone();
			$layer.find('.ls-sublayer-number').text(c+1);
			$layer.find('.ls-sublayer-title').val(layerData.subtitle);

			// Hidden layer
			if(layerData.skip) { $layer.find('.ls-icon-eye').addClass('disabled'); }

			// Locked layer
			if(layerData.locked) { $layer.find('.ls-icon-lock').removeClass('disabled'); }

			// Not visible on current screen type
			$layer[ layerData['hide_on_'+LS_activeScreenType] ? 'addClass' : 'removeClass' ]('dim');

			LayerSlider.setLayerMedia( layerData.media,  jQuery('.ls-sublayer-thumb', $layer), layerData );
			$layersList.append($layer);
		}


		// Reset static layers
		jQuery('.ls-layers-list .subheader').hide();
		jQuery('.ls-static-sublayers').empty();

		// Add static layers (if any)
		if( LS_activeStaticLayersDataSet.length ) {

			jQuery('.ls-layers-list .subheader').show();

			$template = jQuery( jQuery('#ls-static-layer-item-template').html() );
			jQuery.each(LS_activeStaticLayersDataSet, function(idx, data) {

				var layerData = data.layerData,
					$layer = $template.clone();

					$layer.find('.ls-sublayer-number').text(idx+1);
					$layer.find('.ls-sublayer-title').text(layerData.subtitle);


				LayerSlider.setLayerMedia( layerData.media,  jQuery('.ls-sublayer-thumb', $layer), layerData );
				$layer.appendTo('.ls-static-sublayers');
			});
		}

		// Select first layer
		$layersList.children().eq(LS_activeLayerIndexSet).addClass('active');

		if( buildProperties.updateLayer ) {
			this.buildLayer();
		}
	},


	buildLayersListItem: function( layerIndex ) {

		var layerData 	= LS_activeSlideData.sublayers[ layerIndex ],
			$template 	= jQuery(jQuery('#ls-layer-item-template').html()),
			$target 	= jQuery('#ls-layers .ls-sublayers li').eq( layerIndex );
			$layer 		= $template.clone();


		$layer.find('.ls-sublayer-number').text(layerIndex+1);
		$layer.find('.ls-sublayer-title').val(layerData.subtitle);

		// Hidden layer
		if(layerData.skip) { $layer.find('.ls-icon-eye').addClass('disabled'); }

		// Locked layer
		if(layerData.locked) { $layer.find('.ls-icon-lock').removeClass('disabled'); }

		// Not visible on current screen type
		$layer[ layerData['hide_on_'+LS_activeScreenType] ? 'addClass' : 'removeClass' ]('dim');

		// Active?
		if( LS_activeLayerIndexSet[0] === $target.index() ) {
			$layer.addClass('active');
		}

		LayerSlider.setLayerMedia( layerData.media,  jQuery('.ls-sublayer-thumb', $layer), layerData );
		$target.replaceWith( $layer );
	},


	buildLayer: function() {

		// Bail out early if there's no layers on slide
		if( !LS_activeLayerDataSet.length ||
			!LS_activeSlideData.sublayers.length) {
				return false;
		}

		// Find active layer
		var $layerItem 	= jQuery('#ls-layers .ls-sublayers li.active'),
			$layer 		= jQuery('.ls-sublayer-pages'),
			layerIndex 	= LS_activeLayerIndexSet[0],
			layerData 	= LS_activeLayerDataSet[0];

		// Empty earlier layers and add new
		jQuery('.ls-sublayer-pages').empty();
		jQuery('.ls-sublayer-pages').html( jQuery('#ls-layer-template').html() );

		LayerSlider.updateLayerInterfaceItems(layerIndex);

		// Reset checkboxes
		// $layer.find('.ls-checkbox').remove();
		// $layer.find('input:checkbox:not(.noreset)').prop('checked', false);

		var $formItems = jQuery('input,textarea,select', $layer).filter(':not(.auto,.sublayerprop)'),
			$styleItems = jQuery('input,textarea,select', $layer).filter('.auto'),
			$transitionItems = jQuery('input,textarea,select', $layer).filter('.sublayerprop');

		LS_DataSource.setFormItemValues($formItems, layerData);
		LS_DataSource.setFormItemValues($styleItems, layerData.styles);
		jQuery('.ls-border-padding input').each(function() {
			LayerSlider.updateLayerBorderPadding( this );
		});

		// Backwards compatibility: put transitions settings into
		// the 'transition' object within the layer data
		if( ! layerData.transition || jQuery.isEmptyObject(layerData.transition) ) {
			this.restoreOldTransitionSettings( $transitionItems );
		}

		LS_DataSource.setFormItemValues($transitionItems, layerData.transition);
		LayerSlider.updateLayerAttributes( layerData );


		// Set image placeholder
		LS_GUI.updateImagePicker('image', layerData.imageThumb );
		LS_GUI.updateImagePicker('poster', layerData.posterThumb );

		// Set static layer chooser
		LayerSlider.setupStaticLayersChooser( $layer.find('.ls-sublayer-options select[name="static"]')[0] );


		// Init custom interface plugins
		$layer.find(':checkbox:not(.noreplace)').customCheckbox();
		LayerSlider.addColorPicker( $layer.find('.ls-colorpicker') );
		LayerSlider.changeLayerScreenType();
		LayerSlider.changeVideoType();

		jQuery('#ls-layer-transitions section .ls-h-button input').each(function() {
			var $input 		= jQuery(this),
				$section 	= $input.closest('section'),
				index 		= $section.index(),
				$target 	= jQuery('#ls-transition-selector-table td:not(.ls-padding)');

			if( $input.prop('checked') && layerData.transition[ $input.attr('name') ] !== false ) {
				$target.eq( index ).addClass('active');

			} else if( $input.prop('checked') ) {
				$input.prop('checked', false);
				$input.next().removeClass('on');
			}
		});
		jQuery('#ls-transition-selector-table td:not(.ls-padding)').eq(LS_activeLayerTransitionTab).click();

		// Select lastly viewed subpage
		LayerSlider.selectLayerPage(LS_activeLayerPageIndex);
	},

	setFormItemValues: function($items, values, defaults) {

		// Bail out early if no value was specified
		if( ! $items || ! values || jQuery.isEmptyObject( values ) ) { return false; }

		// Iterate over items
		for(var itemIndex = 0; itemIndex < $items.length; itemIndex++) {

			var $item = jQuery($items[itemIndex]),
				value = values[ $item.attr('name') ];

			if( ! $item.attr('name') ) { continue; }

			if( ! value && value !== false ) {
				if( typeof defaults == 'undefined' ) {
					continue;
				}

				value = defaults[$item.attr('name')];
			}

			// Checkboxes
			if($item.is(':checkbox')) {
				$item.prop('checked', Boolean(value)).data('value', Boolean(value));

			// Input, textarea
			} else if($item.is('input,textarea')) {
				$item.val(value).data('value', value);

			// Select
			} else if($item.is('select')) {
				$item.children().prop('selected', false);
				$item.children('[value="'+value+'"]').prop('selected', true);
				$item.data('value', value);
			}
		}
	},


	readSliderSettings: function() {

		// Return previously stored data whenever it's possible
		if( !jQuery.isEmptyObject(LS_defaultSliderData) ) {
			return LS_defaultSliderData;
		}

		var settings = {};
		jQuery('.ls-slider-settings').find('input,textarea,select').each(function() {

			var item = jQuery(this),
				prop = item.attr('name'),
				 val = item.is(':checkbox') ? item.prop('checked') : item.val();

			if(prop && val !== false) { settings[ prop ] = val; }
		});

		return settings;
	},


	parseSliderSetting: function() {

		var settings = window.lsSliderData.properties,
			key,
			val;

		for( key in settings ) {

			switch( settings[key] ) {
				case 'on':
				case 'true':
					settings[key] = true;
					break;

				case 'off':
				case 'false':
					settings[key] = false;
					break;
			}
		}
	},


	getDefaultSlideData: function() {

		// Return previously stored data whenever it's possible
		if( ! jQuery.isEmptyObject(LS_defaultSlideData)) {
			return LS_defaultSlideData;
		}

		// Get slide template
		var $template = jQuery( jQuery('#ls-slide-template').text() );

		// Iterate over form items and add their values to LS_defaultSlideData
		jQuery('.ls-slide-options', $template).find('input, textarea, select').each(function() {

			var item = jQuery(this),
				prop = item.attr('name'),
				val  = item.is(':checkbox') ? item.prop('checked') : item.val();

			if( prop ) { LS_defaultSlideData[ prop ] = val; }
		});

		return LS_defaultSlideData;
	},


	getDefaultLayerData: function() {

		// Build the default data object if there's no
		// stored copy yet
		if( jQuery.isEmptyObject( LS_defaultLayerData ) ) {

			var $template 	= jQuery( jQuery('#ls-layer-template').text() ),
				$inputs 	= jQuery();

			// Transition and style options will be stored in a sub-object
			LS_defaultLayerData.transition = {};
			LS_defaultLayerData.styles = {};

			$template.each(function() {

				var $this = jQuery(this);

				if( $this.hasClass('ls-sublayer-options') ) {
					jQuery('section .toggle', this).filter(':checkbox:checked').each(function() {
						$inputs = $inputs.add( jQuery('input, textarea, select', jQuery(this).closest('section') ) );
					});
				} else {
					 $inputs =  $inputs.add( jQuery('input, textarea, select', $this) );
				}
			});

			// Iterate over form items and add their values to LS_defaultLayerData
			$inputs.each(function() {

				var item 	= jQuery(this),
					prop 	= item.attr('name'),
					val 	= item.is(':checkbox') ? item.prop('checked') : item.val();

				if( prop ) {

					if( item.hasClass('sublayerprop') ) {
						LS_defaultLayerData.transition[prop] = val;

					} else if( item.hasClass('auto') ) {
						if( val !== '' ) {
							LS_defaultLayerData.styles[prop] = val;
						}

					} else {
						LS_defaultLayerData[prop] = val;
					}
				}
			});
		}

		// Make sure to always override the layer title in the stored copy
		// to avoid name collisions and weird behaviors.
		var layerCount 	= LS_activeSlideData.sublayers ? LS_activeSlideData.sublayers.length : 0,
			layerName 	= 'Layer #' + (layerCount+1);

		LS_defaultLayerData.subtitle = layerName;

		return LS_defaultLayerData;
	},


	uuidForSlide: function( slideIndex ) {

		slideIndex = slideIndex || LS_activeSlideIndex;
		return this.uuidForObject(
			window.lsSliderData.layers[slideIndex].properties
		);
	},


	slideForUUID: function( uuid ) {

		var slideIndex;

		jQuery.each(window.lsSliderData.layers, function(index, slide) {
			if( slide.properties.uuid && slide.properties.uuid == uuid ) {
				slideIndex = index;
				return false;
			}
		});

		return slideIndex;
	},


	uuidForLayer: function( layerIndex ) {

		layerIndex = layerIndex || LS_activeLayerIndexSet[0];
		return this.uuidForObject(
			LS_activeSlideData.sublayers[ layerIndex ]
		);
	},


	layerForUUID: function( uuid ) {

	},


	uuidForObject: function( data ) {

		if( ! data.uuid || ! data.uuid.length ) {
			data.uuid = this.generateUUID();
		}

		return data.uuid;
	},


	generateUUID: function() {
		return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
			var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
			return v.toString(16);
		});
	},


	// Backwards compatibility: put transitions settings into
	// the 'transition' object within the layer data
	restoreOldTransitionSettings: function($inputs) {

		// Get transition option names
		var options = [];
		for(var i=0;typeof($inputs[i])!='undefined';options.push($inputs[i++].getAttribute('name')));

		jQuery.each(window.lsSliderData.layers, function(slideKey, slideData) {
			jQuery.each(slideData.sublayers, function(layerKey, layerData) {
				for(var l = 0; l < options.length; l++) {
					if(layerData[ options[l] ]) {
						layerData.transition[ options[l] ] = layerData[ options[l] ];
						delete layerData[ options[l] ];
					}
				}
			});
		});
	}
};


jQuery(document).ready(function() {

	jQuery('.km-tabs').kmTabs();

	// Set the DB ID of currently editing slider
	LS_sliderID 		= jQuery('#ls-slider-form input[name="slider_id"]').val();
	LS_previewArea 		= jQuery('#ls-preview-layers');
	LS_previewHolder 	= LS_previewArea.parent();
	LS_previewWrapper 	= LS_previewHolder.parent();
	LS_previewStatic 	= jQuery('#ls-static-preview');


	// Set a small delay to prevent unintentional
	// dragging operations when a user clicks on
	// tabs or Preview items
	jQuery.ui.draggable.prototype.options.distance = 3;
	jQuery.ui.sortable.prototype.options.distance = 3;


	// Add default slide data to data source if it's a new slider
	if(window.lsSliderData.properties.new) {
		window.lsSliderData.properties = LS_DataSource.readSliderSettings();
		window.lsSliderData.layers = [{
			properties: jQuery.extend(true, {}, LS_DataSource.getDefaultSlideData()),
			sublayers: [jQuery.extend(true, {}, LS_DataSource.getDefaultLayerData())]
		}];

	// Extend existing slider data with defaults,
	// so we can guarantee that new options added in
	// future updates will always be present in the
	// data source object.
	} else {
		window.lsSliderData.properties = jQuery.extend( {},
			LS_DataSource.readSliderSettings(),
			window.lsSliderData.properties
		);
	}

	// Set callbacks
	var callbacks = window.lsSliderData.callbacks;
	jQuery('.ls-callback-box textarea:not([readonly])').each(function() {

		var $textarea 	= jQuery(this),
			name 		= $textarea.attr('name'),
			useData 	= $textarea.data('event-data');

		if( callbacks && callbacks[name] ) {
			$textarea.val( LS_Utils.stripslashes( callbacks[name] ) );
		}
	});

	LS_GUI.updateImagePicker( 'yourlogo', 'useCurrent' );
	LS_GUI.updateImagePicker( 'backgroundimage', 'useCurrent' );
	LayerSlider.selectSlide(LS_activeSlideIndex, { forceSelect: true });


	// URL rewrite after creating slider
	if( history.replaceState ) {
		if(document.location.href.indexOf('&showsettings=1') != -1) {
			var url = document.location.href.replace('&showsettings=1', '');
			history.replaceState(null, document.title, url);
		}
	}


	// Show "unsaved changes" warning
	jQuery( window ).on('beforeunload', function(e) {

		if( LS_editorIsDirty ) {
			var dialogText = 'You have unsaved changes on this page. Do you want to leave and discard the changes made since your last save?';
			e.returnValue = dialogText;
			return dialogText;
		}
	});


	// Main tab bar page select
	jQuery('#ls-main-nav-bar a:not(.unselectable)').click(function(e) {
		e.preventDefault();

		LayerSlider.selectMainTab( this );

		if( jQuery(this).hasClass('layers') ) {
			$ruler.trigger('resize.lsRuler');
			LayerSlider.generatePreview();
			LayerSlider.updatePreviewSelection();
		}
	});

	// Settings sidebar
	jQuery('ul.ls-settings-sidebar > li').click(function() {
		LayerSlider.selectSettingsTab(this);
	});

	// Deeplink Slider Settings
	if( document.location.hash ) {
		var hash 	= document.location.hash.replace('#', ''),
			$items 	= jQuery('.ls-settings-sidebar li'),
			$target = $items.filter('[data-deeplink="'+hash+'"]');

		if( $target.length ) {
			jQuery('#ls-main-nav-bar .settings').click();
			$target.click();
		}
	}

	// Settings: checkboxes
	jQuery('.ls-settings :checkbox, .ls-layer-box :checkbox:not(.noreplace)').customCheckbox();

	// Settings: datepicker
	var datePickerInterval = 0,
		datepicker = jQuery('.ls-settings .ls-datepicker-input').datepicker({
		inline: true,
		classes: 'ls-datepicker',
		language: 'en',
		dateFormat: 'yyyy-mm-dd',
		timeFormat: 'hh:ii:00',
		todayButton: new Date(),
		clearButton: true,
		timepicker: true,
		keyboardNav: false,
		range: false,

		onSelect: function(formattedDate, date, inst) {
			inst.$el.prev().fadeOut(200);
			inst.$el.trigger('keyup');
		}

	}).on('input', function() {
		var $this 	= jQuery(this);
			val 	= jQuery.trim( $this.val() );

			$this.prev().fadeOut(200);

		clearTimeout(datePickerInterval);
		datePickerInterval = setTimeout(function() {

			if( val.length > 2 && ! val.match(/^\d{4}-\d{2}-\d{2}/) ) {
				jQuery.getJSON( ajaxurl, { action: 'ls_parse_date', date: val }, function(data) {
					if( ! data.errorCount && data.dateStr != '' ) {
						$this.prev().fadeIn(200).removeClass('error').children('span').text( data.dateStr );
					} else {
						$this.prev().fadeIn(200).addClass('error').children('span').text( 'Invalid format' );
					}
				});
			}
		}, 1000);

	}).each(function() {

		var $this 	= jQuery(this),
			key 	= jQuery(this).data('schedule-key');

		if( parseInt(window.lsSliderData.properties[ key ]) ) {
			startDate = new Date( window.lsSliderData.properties[ key ] * 1000 );
			$this.data('datepicker').selectDate( startDate );
			$this.trigger('keyup');
		}

	});


	// Uploads
	LayerSlider.openMediaLibrary();
	kmComboBox.init();

	// Clear uploaded image button
	jQuery(document).on({
		mouseenter: function() {
			if( jQuery(this).hasClass('has-image') ) {
				jQuery(this).addClass('hover');
			}
		},
		mouseleave: function() {
			jQuery(this).removeClass('hover');
		}
	}, '.ls-image');


	jQuery(document).on('click', '.ls-image a.aviary', function(e) {

		e.preventDefault();
		e.stopPropagation();

		// Set ID on the currently editing image
		var $parent = jQuery(this).parent(),
			$image 	= $parent.find('img').attr('id', 'cc-current-image'),
			imageURL;

		// Prevent popover to become visible after opening the editor
		jQuery('body').addClass('hidepopover');

		// Find image URL
		if( $parent.hasClass('ls-slide-image') ) {
			imageURL = LS_activeSlideData.properties.background;
		} else if( $parent.hasClass('ls-slide-thumbnail') ) {
			imageURL = LS_activeSlideData.properties.thumbnail;
		} else if( $parent.hasClass('ls-layer-image') ) {
			imageURL = LS_activeLayerDataSet[0].image;
		} else if( $parent.hasClass('ls-media-image') ) {
			imageURL = LS_activeLayerDataSet[0].poster;
		}

		// Load editor
		featherEditor.launch({
			image: 'cc-current-image',
			url: LS_Utils.toAbsoluteURL( imageURL )
		});
	});

	// Clear uploads
	jQuery(document).on('click', '.ls-image .dashicons-dismiss', function(e) {
		e.preventDefault();
		e.stopPropagation();

		var $parent = jQuery(this).parent();

		$parent.removeClass('hover');
		$parent.prev().val('').prev().val('');
		LS_GUI.updateImagePicker( $parent, '' );

		// Global background
		if($parent.hasClass('ls-global-background')) {
			window.lsSliderData.properties.backgroundimage = '';
			window.lsSliderData.properties.backgroundimageId = '';
			window.lsSliderData.properties.backgroundimageThumb = '';

		} else if($parent.hasClass('ls-yourlogo-upload')) {
			window.lsSliderData.properties.yourlogo = '';
			window.lsSliderData.properties.yourlogoId = '';
			window.lsSliderData.properties.yourlogoThumb = '';

		} else if($parent.hasClass('ls-slide-image')) {

			LS_UndoManager.add('slide.general', 'Remove slide image', {
				itemIndex: LS_activeSlideIndex,
				undo: {
					background: LS_activeSlideData.properties.background,
					backgroundId: LS_activeSlideData.properties.backgroundId,
					backgroundThumb: LS_activeSlideData.properties.backgroundThumb
				},
				redo: {
					background: '',
					backgroundId: '',
					backgroundThumb: ''
				}
			});

			LS_activeSlideData.properties.background = '';
			LS_activeSlideData.properties.backgroundId = '';
			LS_activeSlideData.properties.backgroundThumb = '';


		} else if($parent.hasClass('ls-slide-thumbnail')) {
			LS_activeSlideData.properties.thumbnail = '';
			LS_activeSlideData.properties.thumbnailId = '';
			LS_activeSlideData.properties.thumbnailThumb = '';

		} else if($parent.hasClass('ls-layer-image')) {

			LS_UndoManager.add('layer.general', 'Remove layer image', {
				itemIndex: LS_activeLayerIndexSet[0],
				undo: {
					image: LS_activeLayerDataSet[0].image,
					imageId: LS_activeLayerDataSet[0].imageId,
					imageThumb: LS_activeLayerDataSet[0].imageThumb
				},
				redo: {
					image: '',
					imageId: '',
					imageThumb: ''
				}
			});

			LS_activeLayerDataSet[0].image = '';
			LS_activeLayerDataSet[0].imageId = '';
			LS_activeLayerDataSet[0].imageThumb = '';
			jQuery('.ls-sublayers li').eq(LS_activeLayerIndexSet[0])
				.find('.ls-sublayer-thumb').addClass('dashicons dashicons-format-image')
				.find('img').remove();


		} else if($parent.hasClass('ls-media-image')) {

			LS_UndoManager.add('layer.general', 'Remove video poster', {
				itemIndex: LS_activeLayerIndexSet[0],
				undo: {
					poster: LS_activeLayerDataSet[0].poster,
					posterId: LS_activeLayerDataSet[0].posterId,
					posterThumb: LS_activeLayerDataSet[0].posterThumb
				},
				redo: {
					poster: '',
					posterId: '',
					posterThumb: ''
				}
			});

			LS_activeLayerDataSet[0].poster = '';
			LS_activeLayerDataSet[0].posterId = '';
			LS_activeLayerDataSet[0].posterThumb = '';
		}


		LayerSlider.generatePreview();

	}).on('click', '.ls-timeline-switch li', function(e) {
		e.preventDefault();

		// Bail out early if it's the active menu item
		if( jQuery(this).hasClass('active') ) { return false; }

		var $item = jQuery(this),
			$layerList = jQuery('.ls-sublayers');

		// Toogle switch
		$item.addClass('active').siblings().removeClass('active');

		if( $item.index() == 1 ){
			jQuery('.ls-layers-table').hide().next().show();
			jQuery('.ls-add-sublayer').hide();

			LayerSlider.startSlidePreview({
				autoStart: false,
				pauseLayers: true,
				plugins: [{
					namespace: 'timeline',
					js: 'timeline/layerslider.timeline.js',
					css: 'timeline/layerslider.timeline.css',
					settings: {
						showLayersInfo: true
					}
				}]
			});


		} else {
			jQuery('.ls-layers-table').show().next().hide();
			jQuery('.ls-add-sublayer').show();

			LayerSlider.stopSlidePreview();
		}
	});


	// Settings: store any form element change in  data source
	jQuery('.ls-slider-settings').on('input change click', 'input,textarea,select', function(event) {

		// Bail out early if there was a click event
		// fired on a non-checkbox form item
		if(event.type === 'click') {
			if( !jQuery(this).is(':checkbox') ) {
				return false;
			}
		}

		// Get option data
		var item = jQuery(this),
			prop = item.attr('name'),
			val  = item.is(':checkbox') ? item.prop('checked') : item.val();

		if( prop === 'width' || prop === 'height' ) {

			if( val && ! val.toString().match(/^\d+$/) ) {
				val = parseInt(val) || '';
				item.val( val );
			}
		}

		// Set new setting
		window.lsSliderData.properties[ prop ] = val;

		// Mark unsaved changes on page
		LS_editorIsDirty = true;

		// Update preview
		if(item.is('select, :checkbox')) {
			LayerSlider.generatePreview();
		} else {
			LayerSlider.willGeneratePreview();
		}
	});

	// Settings: init slider size chooser
	jQuery('.ls-slider-dimensions').on('click', 'div', function(e) {

		var $this 	= jQuery(this),
			type 	= $this.data('type');

		$this.siblings('input[type="hidden"]').val( type );
		$this.addClass('active').siblings().removeClass('active');

		// Hide special fields
		jQuery('.full-width-row, .full-size-row', jQuery('.ls-settings-contents')).hide();

		switch( type ) {
			case 'fullwidth':
				jQuery('.ls-settings-contents .full-width-row').css('display', 'table-row');
				break;

			case 'fullsize':
				jQuery('.ls-settings-contents .full-size-row').css('display', 'table-row');
				break;
		}

		// Update data source & reload preview
		window.lsSliderData.properties.type = type;
		LayerSlider.generatePreview();
	});

	// Select slider type
	jQuery('.ls-slider-dimensions div[data-type="'+window.lsSliderData.properties.type+'"]').click();

	// if ($dim.find('input[name=fullpage]:checked').length) {
	// 	$dim.find('.full-screen').click();
	// } else if ($dim.find('input[name=forceresponsive]:checked').length) {
	// 	$dim.find('.full-width').click();
	// } else if ($dim.find('input[name=responsive]:checked').length) {
	// 	$dim.find('.responsive').click();
	// } else {
	// 	$dim.find('.non-responsive').click();
	// }
	// Settings: update slider height for full-screen
	jQuery('#container-height').on('change', function() {
		jQuery('#slider-height').val(this.value).change();
	});

	// Settings: reset button
	jQuery(document).on('click', '.ls-reset', function() {

		// Empty field
		jQuery(this).prev().val('');

		// Generate preview
		LayerSlider.generatePreview();
	});


	// Callbacks: store any form element change in  data source
	jQuery('.ls-callback-page').on('updated.ls', 'textarea:not([readonly])', function( event, cm ) {

		if( typeof window.lsSliderData.callbacks !== 'object' ) {
			window.lsSliderData.callbacks = {};
		}


		var key 	= jQuery(this).attr('name'),
			val 	= jQuery(this).val(),
			test 	= val.match(/\{([\s\S]*)\}/m)[1].replace(/(\r\n|\n|\r)/gm, '');

		if( jQuery.trim( test ).length ) {
			window.lsSliderData.callbacks[ key ] = val;
		} else {
			delete window.lsSliderData.callbacks[ key ];
		}
	});


	// Add slide
	jQuery('#ls-add-layer').click(function(e) {
		e.preventDefault(); LayerSlider.addSlide();
	});

	// Select slide
	jQuery('#ls-layer-tabs').on('click', 'a:not(.unsortable)', function(e) {
		e.preventDefault();
		if( ! jQuery(this).hasClass('active ') ) {
			LayerSlider.selectSlide( jQuery(this).index(), { forceSelect: true } );
		}

	// Rename slide
	}).on('dblclick', 'a:not(.unsortable)', function(e) {
		e.preventDefault(); LayerSlider.renameSlide(this);
	});

	// Duplicate slide
	jQuery('#ls-layers').on('click', 'button.ls-layer-duplicate', function(e){
		e.preventDefault(); e.stopPropagation();
		LayerSlider.duplicateSlide(this);
	});

	// Initialize floating layout
	jQuery( document ).on( 'click', '#menu-set-float', function( e ){

		e.preventDefault();

		jQuery( '#ls-layers-settings-popout' ).removeClass( 'ls-layers-settings-normal' ).addClass( 'ls-layers-settings-floating' ).draggable({
			handle: '#ls-layers-settings-popout-handler',
			containment: '#ls-slider-form',
			scroll: false
		}).resizable({
			minHeight: 450,
			minWidth: 350,
			maxWidth: 1500,
			create: function(){
				kmUI.smartResize.set();
			},
			resize: function(){
				kmUI.smartResize.set();
			}
		});

		jQuery( '#ls-layers-settings-popout-handler' ).trigger( 'mouseenter' );
		jQuery( '.ls-preview-wrapper' ).addClass( 'ls-forceto-left' );

	}).on( 'click', '#menu-set-putback', function( e ){

		e.preventDefault();

		jQuery( '#ls-layers-settings-popout' )
			.addClass( 'ls-layers-settings-normal' )
			.removeClass( 'ls-layers-settings-floating' )
			.draggable( 'destroy' )
			.resizable( 'destroy' );

		jQuery( '.ls-preview-wrapper' ).removeClass( 'ls-forceto-left' );

		kmUI.smartResize.set();
	});

	// Enter URL
	jQuery('#ls-layers').on('click', '.ls-url-prompt', function(e){
		e.preventDefault();

		var url = prompt('Enter an image URL');
		if( ! url ) { return false; }

		var $el 	= jQuery(this),
			$target = $el.parent().prev();

		// Slide image
		if($target.hasClass('ls-slide-image')) {
			LS_activeSlideData.properties.background = url;
			LS_activeSlideData.properties.backgroundId = '';
			LS_activeSlideData.properties.backgroundThumb = url;

		// Slide thumbnail
		} else if($target.hasClass('ls-slide-thumbnail')) {
			LS_activeSlideData.properties.thumbnail = url;
			LS_activeSlideData.properties.thumbnailId = '';
			LS_activeSlideData.properties.thumbnailThumb = url;

		// Image layer
		} else if($target.hasClass('ls-layer-image')) {
			LS_activeLayerDataSet[0].image = url;
			LS_activeLayerDataSet[0].imageId = '';
			LS_activeLayerDataSet[0].imageThumb = url;

		// Media image
		} else if($target.hasClass('ls-media-image')) {
			LS_activeLayerDataSet[0].poster = url;
			LS_activeLayerDataSet[0].posterId = '';
			LS_activeLayerDataSet[0].posterThumb = url;
		}

		jQuery('img', $target).attr('src', url);
		LayerSlider.generatePreview();
	});

	// Slide options: input, textarea, select
	jQuery('#ls-layers').on('keyup change click', '.ls-slide-options input, .ls-slide-options textarea, .ls-slide-options select', function(event) {

		// Bail out early if there was a click event
		// fired on a non-checkbox form item
		if(event.type === 'click') {
			if( !jQuery(this).is(':checkbox') ) {
				return false;
			}
		}

		var item = jQuery(this),
			prop = item.attr('name'),
			val  = item.is(':checkbox') ? item.prop('checked') : item.val();

		LS_activeSlideData.properties[prop] = val;

		// Update preview when setting properties
		// related to the background image
		var updateKeys = [
			'bgsize', 'bgposition', 'bgcolor'
		];

		if( updateKeys.indexOf(prop) !== -1 ) {
			LayerSlider.generatePreview();
		}
	});

	// Open Transition gallery
	jQuery('#ls-layers').on('click', '.ls-select-transitions', function(e) {
		e.preventDefault();
		LayerSlider.openTransitionGallery();
	});

	// Close transition gallery
	jQuery(document).on('click', '#ls-transition-window header b', function(e) {
		e.preventDefault();
		LayerSlider.closeTransitionGallery();
	});

	// Add/Remove layer transitions
	jQuery(document).on('click', '#ls-transition-window tbody a:not(.ls-checkbox)', function(e) {
		e.preventDefault();
		LayerSlider.toggleTransition(this);
	});

	// Add/Remove layer transitions
	jQuery(document).on('click', '#ls-transition-window header i:last', function(e) {
		var check = jQuery(this).hasClass('off') ? true : false;
		jQuery('#ls-transition-window tbody.active').each(function() {
			LayerSlider.selectAllTransition( jQuery(this).index(), check );
		});
	});

	// Apply on others
	jQuery(document).on('click', '#ls-transition-window header i:not(:last)', function(e) {

		// Confirmation
		if( ! confirm('Are you sure you want to apply the currently selected transitions on the other slides?') ) {
			return false;
		}

		// Dim color briefly
		var button = jQuery(this);
		button.css('color', '#bbb');
		setTimeout(function() {
			button.css('color', '#444');
		}, 2000);

		// Apply to other slides
		jQuery.each(window.lsSliderData.layers, function(slideIndex, slideData) {
			slideData.properties['3d_transitions'] = LS_activeSlideData.properties['3d_transitions'];
			slideData.properties['2d_transitions'] = LS_activeSlideData.properties['2d_transitions'];
			slideData.properties.custom_3d_transitions = LS_activeSlideData.properties.custom_3d_transitions;
			slideData.properties.custom_2d_transitions = LS_activeSlideData.properties.custom_2d_transitions;
		});

	}).on('click', '#ls-more-slide-options', function() {
		LayerSlider.toggleAdvancedSlideOptions( this );
	});


	// Show/Hide transition
	jQuery(document).on('mouseenter', '#ls-transition-window table a', function() {
		lsShowTransition( this );
	}).on('mouseleave', '#ls-transition-window table a', function() {
		lsHideTransition( this );
	});



	// Remove layer
	jQuery('#ls-layer-tabs').on('click', 'a span:last-child', function(e) {
		e.preventDefault();
		e.stopPropagation();
		LayerSlider.removeSlide(this);
	});

	// Add layer
	jQuery('#ls-layers').on('click', '.ls-add-sublayer', function(e) {
		e.preventDefault();
		LayerSlider.addLayer(null, null, {
			selectLayer: true,
			selectPage: 0
		});

	// Select layer
	}).on('click', '.ls-sublayers li', function() {
		if( ! jQuery(this).hasClass('active') || LS_activeLayerIndexSet.length !== 1 || LS_activeLayerIndexSet[0] !== jQuery(this).index()) {
			LayerSlider.selectLayer( [jQuery(this).index()] );
		}

	}).on('keyup', 'input[name="subtitle"]', function() {
		var index = jQuery(this).closest('li').index();
		LS_activeSlideData.sublayers[index].subtitle = jQuery(this).val();

	// Layer pages
	}).on('click', '.ls-sublayer-nav a', function(e) {
		e.preventDefault(); LayerSlider.selectLayerPage( jQuery(this).index() );

	// Remove layer
	}).on('click', '.ls-sublayers a.remove', function(e) {
		e.preventDefault(); e.stopPropagation();
		LayerSlider.removeLayer( jQuery(this).closest('li').index() );

	// Duplicate layer
	}).on('click', '.ls-sublayers a.duplicate', function(e) {
		e.preventDefault(); e.stopPropagation();
		LayerSlider.duplicateLayer();

	}).on('click', '.ls-set-screen-types button', function(e) {
		e.preventDefault();
		LayerSlider.changeLayerScreenType( jQuery(this), true );

	// Layer media type
	}).on('click', '.ls-layer-kind li', function(e) {
		e.preventDefault();
		var $item = jQuery(this);

		if( !$item.hasClass('active') ) {

			LS_UndoManager.add('layer.general', 'Layer media', {
				itemIndex: LS_activeLayerIndexSet,
				undo: { media: LS_activeLayerDataSet[0].media },
				redo: { media: $item.data('section') }
			});

			LayerSlider.selectMediaType(this);
			LayerSlider.generatePreviewItem(LS_activeLayerIndexSet);
		}

	// Layer element type
	}).on('click', '.ls-sublayer-element > li', function(e) {
		e.preventDefault();
		var $item = jQuery(this);

		LS_UndoManager.add('layer.general', 'Layer type', {
			itemIndex: LS_activeLayerIndexSet,
			undo: { type: LS_activeLayerDataSet[0].type },
			redo: { type: $item.data('element') }
		});

		LayerSlider.selectElementType(this);
		LayerSlider.generatePreviewItem(LS_activeLayerIndexSet);

	// Layer options: input, textarea, select
	}).on('input change click', '.ls-sublayer-pages input, .ls-sublayer-pages textarea, .ls-sublayer-pages select', function(event) {

		// Ignore events triggered by UndoManager
		if(event.UndoManagerAction) { return false; }

		// Bail out early if there was a click event
		// fired on a non-checkbox form item
		if(event.type === 'click' && !jQuery(this).is(':checkbox')) {
			return false;
		}

		// Prevent triggering the change event
		// on non-select form items
		if(event.type === 'change' && !jQuery(this).is('select')) {
			return false;
		}

		var $item 	= jQuery(this),
			prop 	= $item.attr('name'),
			val  	= $item.is(':checkbox') ? $item.prop('checked') : $item.val(),
			area 	= LS_activeLayerDataSet[0];

		if($item.hasClass('sublayerprop') ) { area = LS_activeLayerDataSet[0].transition; }
			else if($item.hasClass('auto') ) { area = LS_activeLayerDataSet[0].styles; }

		// Boolean conversion
		if( val === 'true' ) { val = true; }
		if( val === 'false' ) { val = false; }

		// Null values indicate empty option.
		// We should remove them entirely from data source.
		if( val === null || val === 'null' || val === '' ) {
			delete area[ prop ];
		} else {
			area[ prop ] = val;
		}

		LayerSlider.willGeneratePreviewItem(LS_activeLayerIndexSet);

		if( LayerSlider.isLayerPreviewActive ){
			LayerSlider.startLayerPreview( jQuery('.ls-layer-preview-button') );
		}

		if( $item.closest('.ls-sublayer-style').length ) {
			LayerSlider.updatePreviewSelection();
		}

		// Check if media embed code contains autoplay setting
		if( prop === 'html' &&  LS_activeLayerDataSet[0].media === 'media' ) {
			LayerSlider.checkMediaAutoPlay( $item, prop, val );
		}

		// startAt
		var $li = $item.closest('.start-at-wrapper'),
			$ul = $li.parent();

		if( $li.length && ! $item.is('.start-at-calc') ) {

			var timing 	= jQuery('.start-at-timing', $ul).val(),
				operator 	= jQuery('.start-at-operator', $ul).val(),
				value 		= jQuery('.start-at-value', $ul).val(),
				$calcInput 	= jQuery('.start-at-calc', $ul);

			$calcInput.data('prevVal', $calcInput.val() );
			setTimeout(function() {
				$calcInput.val( timing +' '+ operator +' '+ value).trigger('input');
				LS_UndoManager.trackInputs( null, $calcInput );
			}, 100);
		}

	}).on('change', '.ls-sublayer-basic input.bgvideo', function() {
		LayerSlider.changeVideoType();

	// Active transition sections
	}).on('click', '#ls-transition-selector-table td:not(.ls-padding)', function(event) {
		LayerSlider.selectTransitionPage( this );

	}).on('change', '#ls-transition-selector', function(event) {
		jQuery( '#ls-transition-selector-table td:not(.ls-padding)' ).eq( jQuery(this).val() ).click();

	}).on('change', '#ls-layer-transitions .ls-h-button input', function(event) {
		LayerSlider.enableTransitionPage( this );

	}).on('click', '#ls-layer-transitions .overlay', function(event) {
		var $this 		= jQuery(this),
			$section 	= $this.closest('section'),
			$checkbox 	= $section.find('.ls-h-button .ls-checkbox.toggle');

			if( $checkbox.hasClass('off') ) {

				if( $checkbox.data( 'tl' ) ){
					$checkbox.data( 'tl' ).progress(1).kill();
				}

				var tl = new TimelineMax();

				tl.to( $checkbox[0], 0.12, {
					yoyo: true,
					repeat: 3,
					ease: Quad.easeInOut,
					scale: 1.5,
					backgroundColor: '#ff1d1d'
				});

				$checkbox.data( 'tl', tl );
			}

	// Copy transition settings
	}).on('click', '.ls-h-actions .copy', function(event) {
		event.preventDefault();
		event.stopPropagation();
		LayerSlider.copyLayerSettings(this);

	// Paste transition settings
	}).on('click', '.ls-h-actions .paste', function(event) {
		event.preventDefault();
		event.stopPropagation();
		LayerSlider.pasteLayerSettings(this);
		jQuery('.ls-border-padding input').each(function() {
			LayerSlider.updateLayerBorderPadding( this );
		});

	// Static select
	}).on('mouseenter', '.ls-sublayer-options select[name="static"]', function() {
		LayerSlider.setupStaticLayersChooser( this );

	}).on('keyup', '.ls-sublayer-custom-attributes tr:last-child input', function() {

		if( jQuery(this).val() ) {
			var $tr = jQuery(this).closest('tr').removeClass('ls-hidden');
			$tr.clone().insertAfter( $tr ).find('input').val('');
		}

	}).on('keyup change', '.ls-sublayer-custom-attributes tr:not(:last-child) input', function( event ) {
		LayerSlider.setLayerAttributes(event, this);

	}).on('input', '.ls-border-padding input', function() {
		LayerSlider.updateLayerBorderPadding( this );




	// Pick static layer
	}).on('change', '.ls-sublayer-options select[name="static"]', function() {

		var $select = jQuery(this),
			value 	= $select.val(),
			index 	= parseInt( jQuery(this).val() ),
			uuid;

		if( value === 'null' || value === null || index === 0  ) {
			delete LS_activeLayerDataSet[0].transition.static;
			delete LS_activeLayerDataSet[0].transition.staticUUID;
			return;
		}

		if(index && index > 0) {
			uuid = LS_DataSource.uuidForSlide( index - 1 );
			LS_activeLayerDataSet[0].transition.staticUUID = uuid;
		}



	// Pick transformOrigin
	}).on('click', '#ls-layer-transitions .dashicons-search:not(.active)', function(event) {
		event.stopPropagation();

		var $this = jQuery(this).addClass('active'),
			$origin = $this.next(),
			$picker = jQuery('<div>').addClass('ls-origin-picker').appendTo('.ls-preview-wrapper');

		$picker.on('click', function(e) {

			var o = $picker.offset();
				x = e.pageX - o.left,
				y = e.pageY - o.top,
				$layer = LS_previewItems[ LS_activeLayerIndexSet[0] ],
				p = $layer.position(),
				ox = (x - p.left) / ( $layer.outerWidth() * LS_previewZoom ),
				oy = (y - p.top) / ( $layer.outerHeight() * LS_previewZoom ),

			$origin.val([
				Math.round(ox * 1000) / 10 + '%',
				Math.round(oy * 1000) / 10 + '%',
				$origin.val().split(/\s+/)[2] || ''
			].join(' ').trim());

			$origin.trigger('input');
		});

		jQuery(document).one('click', function() {
			jQuery('.ls-origin-picker').remove();
			jQuery('.dashicons-search.active').removeClass('active');
		});

		var origin = $origin.attr('name');
		jQuery.each(LS_previewItems, function(i, $sl) {

			var layerTransition = LS_activeSlideData.sublayers[i].transition;

			if( layerTransition && layerTransition[origin] ) {

				var o = layerTransition[origin].split(/\s+/),
					$layer = LS_previewItems[ LS_activeLayerIndexSet[0] ];

				if( o.length > 1 ) {

					var x = o[0] == 'left' ? '0' : (o[0] == 'right' ? '100%' : o[0]),
						y = o[1] == 'top' ? '0' : (o[1] == 'bottom' ? '100%' : o[1]),
						p = $sl.position();

					x = x.indexOf('%') < 0 ? parseInt(x) : parseFloat(x) / 100 * $sl.outerWidth();
					y = y.indexOf('%') < 0 ? parseInt(y) : parseFloat(y) / 100 * $sl.outerHeight();

					if ( ! isNaN( x ) && ! isNaN( y ) ) {
						jQuery('<div>')
							.addClass('ls-origin-point' + ($sl.is( $layer ) ? ' ls-origin-active' : ''))
							.css({
								left: p.left + (x * LS_previewZoom),
								top: p.top + (y * LS_previewZoom)
							}).appendTo($picker);
					}
				}
			}
		});
	});



	if( typeof Aviary !== 'undefined' ){
		var featherEditor = new Aviary.Feather({
			apiKey: '5cf23f4b299d4953bd257b881c8f37d7',
			maxSize: 3000,
			tools: ['enhance', 'effects', 'frames', 'overlays', 'orientation', 'crop', 'resize', 'lighting', 'color', 'sharpness', 'focus', 'vignette', 'blemish', 'whiten', 'redeye', 'draw', 'colorsplash', 'text'],
			fileFormat: 'png',

			onClose: function( isDirty ) {
				jQuery('#cc-current-image').removeAttr('id');
			},

			onSaveButtonClicked: function( imageID ) {
				featherEditor.showWaitIndicator();

				var $image 	= jQuery('#'+imageID).removeAttr('id');
					$parent = $image.closest('.ls-image'),

					imgName = 'aviary_'+Date.now()+'.png',
					imgData = jQuery('#avpw_canvas_element')[0].toDataURL(),
					imgBlob = LS_Utils.dataURItoBlob(imgData);
					imgBlob.lastModifiedDate = new Date();
					imgBlob.name = imgName;
					imgBlob.filename = imgName;

				LayerSlider.uploadImageToMediaLibrary(imgBlob, function(data) {
					$image.attr('src', data.url);

					if( $parent.hasClass('ls-slide-image') ) {

						// Add action to UndoManager
						LS_UndoManager.add('slide.general', 'Slide image', {
							itemIndex: LS_activeSlideIndex,
							undo: {
								background: LS_activeSlideData.properties.background,
								backgroundId: LS_activeSlideData.properties.backgroundId,
								backgroundThumb: LS_activeSlideData.properties.backgroundThumb
							},
							redo: {
								background: data.url,
								backgroundId: data.id,
								backgroundThumb: data.url
							}
						});

						LS_activeSlideData.properties.background = data.url;
						LS_activeSlideData.properties.backgroundId = data.id;
						LS_activeSlideData.properties.backgroundThumb = data.url;

						LayerSlider.generatePreview();

					} else if( $parent.hasClass('ls-slide-thumbnail') ) {

						LS_activeSlideData.properties.thumbnail = data.url;
						LS_activeSlideData.properties.thumbnailId = data.id;
						LS_activeSlideData.properties.thumbnailThumb = data.url;


					} else if( $parent.hasClass('ls-layer-image') ) {

						// Add action to UndoManager
						LS_UndoManager.add('layer.general', 'Layer image', {
							itemIndex: LS_activeLayerIndexSet[0],
							undo: {
								image: LS_activeLayerDataSet[0].image,
								imageId: LS_activeLayerDataSet[0].imageId,
								imageThumb: LS_activeLayerDataSet[0].imageThumb
							},
							redo: {
								image: data.url,
								imageId: data.id,
								imageThumb: data.url
							}
						});

						LS_activeLayerDataSet[0].image = data.url;
						LS_activeLayerDataSet[0].imageId = data.id;
						LS_activeLayerDataSet[0].imageThumb = data.url;

						LayerSlider.generatePreviewItem( LS_activeLayerIndexSet[0] );


					} else if( $parent.hasClass('ls-media-image') ) {

						// Add action to UndoManager
						LS_UndoManager.add('layer.general', 'Video poster', {
							itemIndex: LS_activeLayerIndexSet[0],
							undo: {
								poster: LS_activeLayerDataSet[0].poster,
								posterId: LS_activeLayerDataSet[0].posterId,
								posterThumb: LS_activeLayerDataSet[0].posterThumb
							},
							redo: {
								poster: data.url,
								posterId: data.id,
								posterThumb: data.url
							}
						});

						LS_activeLayerDataSet[0].poster = data.url;
						LS_activeLayerDataSet[0].posterId = data.id;
						LS_activeLayerDataSet[0].posterThumb = data.url;
					}

					featherEditor.hideWaitIndicator();
					featherEditor.close();
				});

				return false;
			}
		});
	}

	// Sublayer: sortables, draggable, etc
	LayerSlider.addSlideSortables();
	LayerSlider.addLayerSortables();
	LayerSlider.addDraggable();


	// Slide(r) Preview
	jQuery('#ls-layers').on('click', '.ls-preview-button', function(e) {
		e.preventDefault();
		LayerSlider.startSlidePreview();
	});

	// Animate Layer
	jQuery('#ls-layers').on('click', '.ls-layer-preview-button', function(e) {
		e.preventDefault(); LayerSlider.startLayerPreview(this, true);
	});


	// List intersecting preview items when right clicking on them
	LS_previewWrapper.on('contextmenu',function(e) {
		e.preventDefault(); LayerSlider.listPreviewItems(e);
	});

	// Don't drag locked layers
	LS_previewArea.on('dragstart', '.disabled,.transformed', function(e) {
		e.preventDefault();

	}).on('dblclick', '*:not(.disabled)', function() {
		LayerSlider.editLayerStart( jQuery(this) );


	}).on('keydown', '.ls-editing', function(event) {
		LayerSlider.editLayer(event);


	}).on('keyup', '.ls-editing', function() {
		LayerSlider.editLayerUpdate(this);


	}).on('paste', '.ls-editing', function(event) {
		LayerSlider.editLayerPaste(event);

	});

	// Highlight preview item when hovering the intersecting layers list
	jQuery(document).on({
		mouseenter: function() { LayerSlider.highlightPreviewItem(this); },
		mouseleave: function() { LS_previewArea.children().removeClass('highlighted lowlighted'); },
		}, '.ls-preview-item-list li'
	);

	// Select layer from intersecting layers list
	jQuery(document).on('click', '.ls-preview-item-list li', function() {
		LayerSlider.selectPreviewItem(this);
	});


	// Highlight dropable zone
	jQuery(document).on('dragover.ls', '.ls-preview-wrapper', function(e) {
		e.preventDefault();
		jQuery(this).addClass('ls-dragover');
	}).on('dragleave.ls drop.ls', '.ls-preview-wrapper', function(e) {
		e.preventDefault();
		jQuery(this).removeClass('ls-dragover');
	});

	// Handle dropped images
	jQuery('#ls-pages').on('drop.ls', '.ls-preview', function(event) {
		LayerSlider.handleDroppedImages(event);
	});


	// Handle alignment buttons
	jQuery('#slider-editor-toolbar').on('click', '#ls-layer-alignment td', function(event) {

		var $selection 	= jQuery('.ui-selected-helper'),
			moves 		= jQuery(this).data('move').split(' '),
			selTop 		= $selection.position().top,
			selLeft 	= $selection.position().left,
			selWidth 	= $selection.width(),
			selHeight 	= $selection.height(),
			areaWidth 	= LS_previewArea.width() * LS_previewZoom,
			areaHeight 	= LS_previewArea.height() * LS_previewZoom,
			updateInfo 	= [],
			diffTop, diffLeft, x, xp, y, yp;

			// Reposition, calc diff
			for(var c = 0; c < moves.length; c++) {
				switch(moves[c]) {
					case 'left': 	x = 0; xp = '0%'; break;
					case 'center': 	x = areaWidth / 2 - selWidth / 2; xp = '50%'; break;
					case 'right': 	x = areaWidth - selWidth; xp = '100%'; break;

					case 'top': 	y = 0; yp = '0%'; break;
					case 'middle': 	y = areaHeight / 2 - selHeight / 2; yp = '50%'; break;
					case 'bottom': 	y = areaHeight - selHeight; yp = '100%'; break;
				}
			}

		diffTop 	= selTop  - y;
		diffLeft 	= selLeft - x;


		jQuery.each(LS_activeLayerIndexSet, function(idx, layerIndex) {

			// Get layer data
			var layerData = LS_activeSlideData.sublayers[layerIndex];

			// Bail out early if it's a locked layer
			if( layerData.locked ) { return false; }

			// Get preview item, current position & direction
			var $previewItem = LS_previewItems[layerIndex],
				position = $previewItem.position(),
				left = Math.round( (position.left - diffLeft) / LS_previewZoom ).toString(),
				top = Math.round( (position.top - diffTop) / LS_previewZoom ).toString();

			// Use percents when only one layer is selected
			if( LS_activeLayerIndexSet.length === 1 ) {
				left = xp;
				top = yp;
			}


			// Maintain history
			updateInfo.push({
				itemIndex: layerIndex,
				undo: { left: layerData.styles.left, top: layerData.styles.top },
				redo: { left: left, top: top }
			});

			// Set new value
			layerData.styles.left = left;
			layerData.styles.top = top;
			jQuery('.ls-sublayer-pages input[name=left]').val(left);
			jQuery('.ls-sublayer-pages input[name=top]').val(top);

			LayerSlider.generatePreviewItem(layerIndex);
		});

		// Maintain history
		LayerSlider.updatePreviewSelection();
		LS_UndoManager.add('layer.style', 'Align layer(s)', updateInfo);

	}).on('click', '.ls-editor-layouts button', function(e) {
		e.preventDefault();

		LS_activeScreenType = jQuery(this).data('type');
		jQuery(this).addClass('playing').siblings().removeClass('playing');

		LS_DataSource.buildLayersList();

		if( LayerSlider.isLayerPreviewActive ) {
			LayerSlider.stopLayerPreview( true );
		}

		if( LayerSlider.isSlidePreviewActive ) {
			LayerSlider.stopSlidePreview();
			LayerSlider.startSlidePreview();
		}

		LayerSlider.generatePreview();
	});



	// GLOBAL SHORTCUTS
	var keyTimeout = null, oldX = {}, oldY = {},
		slidesItem = jQuery('#ls-main-nav-bar .layers');

	jQuery(document).on('keydown', function(e) {

		// Save slider when pressing Ctrl/Cmd + S
		if( (e.metaKey || e.ctrlKey) && e.which == 83 ) {
			e.preventDefault();
			LayerSlider.save();
			return;
		}

		// Disable keyboard shortcuts while the
		// main builder interface is not visible.
		if( ! slidesItem.hasClass('active') ) {
			return true;
		}

		var $target = jQuery(e.target);

		if(e.which == 13) {

			// Blur input fields when pressing enter
			if($target.is(':input:not(textarea)')) {
				e.preventDefault();
				e.target.blur();
				return;

			// Toggle layer editing
			} else if( !$target.is(':input') && !e.metaKey && !e.ctrlKey && !e.altKey ) {
				e.preventDefault();
				LayerSlider.editLayerToggle();
				return;
			}
		}

		// Disable keyboard shortcuts while editing
		// a layer with the 'contenteditable' attribute.
		if(jQuery('.ls-editing').length) {
			return;
		}


		// Toggle layer preview with Shift/Alt/Ctrl + space bar
		if( (e.shiftKey || e.altKey || e.ctrlKey) && e.which == 32 && !jQuery(e.target).is(':input') ) {
			e.preventDefault();
			return jQuery('.ls-layer-preview-button').click();
		}


		// Toggle slide preview with the space bar
		if(e.which == 32 && !jQuery(e.target).is(':input')) {
			e.preventDefault();
			return jQuery('.ls-preview-button').click();
		}

		// Disable the other keyboard shortcuts while in preview mode
		if( LayerSlider.isSlidePreviewActive || LayerSlider.isLayerPreviewActive ) {
			return;
		}


		// Redo on Ctrl/Cmd + Shift + Z
		// or Ctrl/Cmd + Y
		if( ((e.metaKey || e.ctrlKey) && e.shiftKey && e.which == 90) ||
			((e.metaKey || e.ctrlKey) && e.which == 89) ) {
			if( !jQuery(e.target).is(':input') ) {
				e.preventDefault();
				return LS_UndoManager.redo();
			}
		}


		// Undo on Ctrl/Cmd + Z
		if( (e.metaKey || e.ctrlKey) && e.which == 90 ) {
			if( !jQuery(e.target).is(':input') ) {
				e.preventDefault();
				return LS_UndoManager.undo();
			}
		}


		// Remove selected layer when pressing del/backspace
		if(e.which == 8 || e.which == 46) {
			if( !jQuery(e.target).is(':input') ) {
				e.preventDefault();
				LayerSlider.removeLayer();
				return;
			}
		}

		// Duplicate layer when pressing Ctrl/Cmd + D
		if( (e.metaKey || e.ctrlKey) && e.which == 68 ) {
			e.preventDefault();
			LayerSlider.duplicateLayer();
			return;
		}

		// Cut layer when pressing Ctrl/Cmd + X
		if( (e.metaKey || e.ctrlKey) && e.which == 88 ) {
			if( !jQuery(e.target).is(':input') ) {
				e.preventDefault();
				LayerSlider.copyLayer(true, LS_activeLayerDataSet, LS_activeLayerIndexSet, { shiftLayers: false });
				LayerSlider.removeLayer(null, { requireConfirmation: false });
				return;
			}
		}

		// Copy layer when pressing Ctrl/Cmd + C
		if( (e.metaKey || e.ctrlKey) && e.which == 67 ) {

			// Copy only if there's no text selection
			if( ! document.getSelection().toString() ) {
				if( ! jQuery(e.target).is(':input') ) {
					e.preventDefault();
					LayerSlider.copyLayer(true);
					return;
				}

			// Remove selection after copying text on page,
			// so future copy events on layers will be uninterrupted.
			} else {
				setTimeout(function() {
					LS_Utils.removeTextSelection();
				}, 300);
			}
		}

		// Paste layer when pressing Ctrl/Cmd + V
		if( (e.metaKey || e.ctrlKey) && e.which == 86 ) {
			if( !jQuery(e.target).is(':input') ) {
				e.preventDefault();
				LayerSlider.pasteLayer();
				return;
			}
		}


		// Move layers in preview with arrow buttons
		if( [37,38,39,40].indexOf(e.which) !== -1 ) {
			if( ! jQuery(e.target).is(':input') ) {
				e.preventDefault();

				var updateInfo = [];

				jQuery.each(LS_activeLayerIndexSet, function(idx, layerIndex) {
					var layerData 	= LS_activeSlideData.sublayers[layerIndex],
						previewItem = LS_previewItems[layerIndex];

					if(layerData.locked ) { return true; }

					var x = Math.round( parseInt(layerData.styles.left) ),
						y = Math.round( parseInt(layerData.styles.top) );

					if( layerData.styles.left.indexOf('%') !== -1 || layerData.styles.top.indexOf('%') !== -1 ) {
						var positions = LayerSlider.setPositions(previewItem, layerData.styles.top, layerData.styles.left, true);
						x = positions.left;
						y = positions.top;
					}

					if( ! oldX[layerIndex] ) { oldX[layerIndex] = x; }
					if( ! oldY[layerIndex] ) { oldY[layerIndex] = y; }

					var left = 0, top = 0;
					switch(e.which) {
						case 37: left--; break; // left
						case 38: top--;  break; // up
						case 39: left++;  break; // right
						case 40: top++;  break; // down
					}

					// Move horizontally
					if(left) {
						e.preventDefault();
						x += (e.shiftKey || e.altKey) ? left*10 : left;

						layerData.styles.left = x+'px';
						previewItem.css('left', x+'px');
						jQuery('.ls-sublayer-pages input[name=left]').val(x + 'px');
					}

					// Move vertically
					if(top) {
						e.preventDefault();
						y += (e.shiftKey || e.altKey) ? top*10 : top;

						layerData.styles.top = y+'px';
						previewItem.css('top', y+'px');
						jQuery('.ls-sublayer-pages input[name=top]').val(y + 'px');
					}

					updateInfo.push({
						itemIndex: layerIndex,
						undo: { left: oldX[layerIndex]+'px', top: oldY[layerIndex]+'px'},
						redo: { left: x+'px', top: y+'px'},
					});
				});

				clearTimeout(keyTimeout);
				keyTimeout = setTimeout(function() {
					LS_UndoManager.add('layer.style', 'Layer position', updateInfo.reverse());
					oldX = {}; oldY = {};
				}, 1000);

				LayerSlider.updatePreviewSelection();
			}
		}
	});


	// Save changes
	jQuery('#ls-slider-form').submit(function(e) {
		e.preventDefault();
		LayerSlider.save(this);
	});

	// Add color picker
	LayerSlider.addColorPicker( jQuery('.ls-slider-settings input.ls-colorpicker') );


	// Show color picker on focus
	jQuery('.color').focus(function() {
		jQuery(this).next().slideDown();

	// Hide color picker on blur
	}).blur(function() {
		jQuery(this).next().slideUp();
	});

	// Jump to original layer
	jQuery('.ls-static-sublayers').on('click', '.ls-icon-jump', function(e) {
		e.preventDefault();
		e.stopPropagation();
		LayerSlider.revealStaticLayer( this );
	});


	// Eye icon for layers
	jQuery('.ls-sublayers').on('click', '.ls-icon-eye', function(e) {
		e.stopPropagation();
		LayerSlider.hideLayer(this);


	// Lock icon for layers
	}).on('click', '.ls-icon-lock', function(e) {
		e.stopPropagation();
		LayerSlider.lockLayer(this);


	// Collapse layer before sorting
	}).on('mousedown', '.ls-sublayer-sortable-handle', function(){
		jQuery(this).closest('.ls-sublayers').addClass('dragging');


	// Expand layer after sorting
	}).on('mouseup', '.ls-sublayer-sortable-handle', function(){
		jQuery('#ls-layers .ls-layer-box.active .ls-sublayer-sortable').removeClass('dragging');
	});

	LS_PostOptions.init();

	// Transitions gallery
	jQuery(document).on('click', '#ls-transition-window .filters li', function() {

		// Update navigation
		jQuery(this).siblings().removeClass('active');
		jQuery(this).addClass('active');

		// Update view
		jQuery('#ls-transition-window tbody').removeClass('active');
		jQuery('#ls-transition-window tbody').eq( jQuery(this).index() ).addClass('active');

		// Custom transitions
		if(jQuery(this).index() == 2) {
			jQuery('#ls-transition-window tbody').eq(3).addClass('active');
		}

		// Update 'Select all' button
		var trs = jQuery('#ls-transition-window tbody.active td');
		if(trs.filter('.c.added').length == trs.filter('.c').length) {
			jQuery('#ls-transition-window header i:last').attr('class', 'on').text('Deselect all');
		} else {
			jQuery('#ls-transition-window header i:last').attr('class', 'off').text('Select all');
		}
	});

	// Link slide to post url
	jQuery('#ls-layers').on('click', '.ls-slide-link a', function(e) {
		e.preventDefault();
		LS_activeLayerDataSet.url = '[post-url]';
		jQuery(this).closest('.ls-slide-link').children('input').val('[post-url]');
	});


	// Use post image as slide background
	jQuery('#ls-layers').on('click', '.slide-image .ls-post-image', function(e) {
		e.preventDefault();

		var imageHolder = jQuery(this).closest('.slide-image').find('.ls-image');

		// Slide image
		if( imageHolder.hasClass('ls-slide-image') ) {
			LS_activeSlideData.properties.background = '[image-url]';
			LS_activeSlideData.properties.backgroundId = '';
			LS_activeSlideData.properties.backgroundThumb = '';

			// Reset image field, generatePreview() will populate them
			// with the actual content (if any)
			LS_GUI.updateImagePicker( 'background', imgSrc );

		// Layer image
		} else if( imageHolder.hasClass('ls-layer-image') ) {
			LS_activeLayerDataSet[0].image = '[image-url]';
			LS_activeLayerDataSet[0].imageId = '';
			LS_activeLayerDataSet[0].imageThumb = '';

			// Reset image field, generatePreview() will populate them
			// with the actual content (if any)
			LS_GUI.updateImagePicker( 'image', imgSrc );
			jQuery('.ls-sublayers li').eq(LS_activeLayerIndexSet[0])
				.find('.ls-sublayer-thumb').addClass('dashicons dashicons-format-image')
				.find('img').remove();
		}

		LayerSlider.generatePreview();
	});


	LS_DataSource.buildSlide();
	LayerSlider.addPreviewSlider( jQuery('#ls-layers .ls-editor-slider'), 1 );
	LayerSlider.generatePreview();

	var $ruler = jQuery('.ls-preview-td').lsRuler();

	// Undo
	jQuery('#ls-layers').on('click', '.ls-editor-undo:not(.disabled)', function() {
		LS_UndoManager.undo();

	// Redo
	}).on('click', '.ls-editor-redo:not(.disabled)', function() {
		LS_UndoManager.redo();

	// UndoManager track options
	}).on('click focus change', 'select, input, textarea', function(event) {
		LS_UndoManager.trackInputs( event, this );

	});

	$lasso = jQuery('<div>').resizable({
		handles: 'all'

	// keep aspect ratio when resize layer at corner
	}).on('mousedown.ls', '.ui-resizable-handle', function(e){
		if( e.which == 1 ){
			$lasso.data('ui-resizable')._aspectRatio = !!this.className.match(/-se|-sw|-ne|-nw/);
		}


	// store selected layers size & position
	}).on('resizestart.ls', function( event, ui ){

		var uiPos = ui.helper.position();

		ui.originalPosition.top = uiPos.top;
		ui.originalPosition.left = uiPos.left;

		jQuery('.ls-preview .ui-selected').each(function() {
			var $layer 	= jQuery(this),
				pos 	= $layer.position();

			$layer.data('originalPosition', {
				top: pos.top / LS_previewZoom,
				left: pos.left / LS_previewZoom
			}).data('originalSize', {
				width: $layer.outerWidth(),
				height: $layer.outerHeight(),
				fontSize: parseInt($layer.css('fontSize')),
				lineHeight: $layer.css('lineHeight').indexOf('px') !== -1 ? parseInt( $layer.css('lineHeight') ) : false
			});
		});


	// update selected layers size & position
	}).on('resize.ls', function(e, ui){
		LayerSlider.resizing(e, ui);

	}).on('resizestop.ls', function(e, ui) {

		var updateInfo 	= [];
		LayerSlider.resizing(e, ui);

		// Remove directio data from $lasso
		$lasso.removeData( 'dragDirection');

		jQuery('.ls-preview .ui-selected').each(function() {
			var $layer 		= jQuery(this),
				index 		= $layer.index(),
				layerData 	= LS_activeSlideData.sublayers[index],
				position 	= $layer.position(),
				size 		= { width: $layer.width(), height: $layer.height() },
				fontSize 	= parseInt($layer.css('font-size')),
				lineHeight 	= parseInt($layer.css('line-height')),
				origPos 	= $layer.data('originalPosition'),
				origSize 	= $layer.data('originalSize');

			var undoObj = {
				itemIndex: index,
				undo: {
					top: origPos.top+'px',
					left: origPos.left+'px',
					width: origSize.width+'px',
					height: origSize.height+'px',
					'font-size': origSize.fontSize+'px',
					'line-height': origSize.lineHeight+'px',
				},
				redo: {
					top: Math.round(position.top / LS_previewZoom)+'px',
					left: Math.round(position.left / LS_previewZoom)+'px',
					width: Math.round(size.width)+'px',
					height: Math.round(size.height)+'px',
					'font-size': Math.round(fontSize)+'px',
					'line-height': Math.round(lineHeight)+'px'
				}
			};


			if( ! layerData.styles.width && ! $layer.is('img,div') ) {
				$layer.width('auto');
				delete undoObj.undo.width;
				delete undoObj.redo.width;
			}

			if( ! layerData.styles.height && ! $layer.is('img,div') ) {
				$layer.height('auto');
				delete undoObj.undo.height;
				delete undoObj.redo.height;
			}


			updateInfo.push(undoObj);
		});

		LS_UndoManager.add('layer.style', 'Layer resize', updateInfo);
		LayerSlider.updatePreviewSelection();

	}).addClass('ui-selected-helper').appendTo( LS_previewHolder );


	LS_previewHolder.on('mouseup.ls', function(){
		var $helper = jQuery('.ui-selectable-helper');
		if( $helper.length ) {

			var pos 		= $helper.position(),
				selTop 		= pos.top,
				selLeft 	= pos.left,
				selWidth  	= $helper.outerWidth(),
				selHeight 	= $helper.outerHeight(),
				items = [];

			// Loop through layers list
			LS_previewArea.children().each(function(layerIndex) {

				var $layer 	= jQuery(this),
					t = LS_previewArea.offset().top + $layer.position().top,
					l = LS_previewArea.offset().left + $layer.position().left,
					w = $layer.outerWidth() * LS_previewZoom,
					h = $layer.outerHeight() * LS_previewZoom;

				if(
					(t > selTop  &&  t+h < selTop+selHeight) &&
					(l > selLeft  &&  l+w < selLeft+selWidth)
				) {
					items.push(layerIndex);
				}
			});

			if(items.length) {
				LayerSlider.selectLayer( items );
			}
		}
		// console.log( ( jQuery('.ui-selectable-helper').position().top - LS_previewArea.offset().top ) / LS_previewZoom );

	}).selectable({
		tolerance: 'fit',
		filter: '.ui-draggable:not(.disabled,.transformed)',
		cancel: '.disabled,.transformed'

	// removeFrom | addTo selected layers
	}).on('mousedown.ls', '.ui-draggable', function(e){

		if( e.which == 1 ) {

			var $layer 		= jQuery(this),
				layerIndex 	= $layer.index(),
				layerData 	= LS_activeSlideData.sublayers[layerIndex];

			// Prevent locked layers to be selected
			if( ! layerData || layerData.locked ) { return false; }

			if( $layer.hasClass('ui-selected') ){
				if( e.ctrlKey || e.metaKey ){
					$layer.removeClass('ui-selected').trigger('selectablestop.ls');
				}
			} else {
				if( !e.ctrlKey && !e.metaKey ){
					$layer.siblings('.ui-selected').removeClass('ui-selected');
				}
				$layer.addClass('ui-selected').trigger('selectablestop.ls');
			}
		}

	// store selected layers, compute lasso position & size
	}).on('selectablestop.ls', function(e, ui){

		var layerIndexSet = [];
		jQuery('.ls-preview-td .ui-selected').each(function() {
			layerIndexSet.push( jQuery(this).index() );

		});

		if( ! layerIndexSet.length ) {
			layerIndexSet = LS_activeLayerIndexSet;
		}

		LayerSlider.selectLayer(layerIndexSet);

	}).on( 'dragstart.ls', function(u, ui){

		var snapEl = ui.helper.data('ui-draggable').snapElements,
			snapElLength = snapEl.length,
			$item, width, height;

		for( var s=0; s<snapElLength; s++ ) {

			$item = jQuery( snapEl[s].item );

			snapEl[s].width = $item.width() * LS_previewZoom;
			snapEl[s].height = $item.height() * LS_previewZoom;
		}

			ui.helper.data({
				originalWidth: ui.helper[0].style.width,
				originalHeight: ui.helper[0].style.height
			});

	}).on('dragstop.ls', function(e, ui) {

		ui.helper[0].style.width = ui.helper.data('originalWidth') || 'auto';
		ui.helper[0].style.height = ui.helper.data('originalHeight') || 'auto';

	}).on('drag.ls', function(e, ui){

		jQuery.data( ui.helper[0], 'ui-draggable' ).helperProportions = {
			width: ui.helper.width() * LS_previewZoom,
			height: ui.helper.height() * LS_previewZoom
		};

		var dy = ( ui.position.top - ui.originalPosition.top ) / LS_previewZoom,
			dx = ( ui.position.left - ui.originalPosition.left ) / LS_previewZoom;

		// Move only horizontally/vertically while pressing shift
		if( e.shiftKey ){
			if( Math.abs(dx) >= Math.abs(dy) ){
				dy = 0; ui.position.top = ui.originalPosition.top;
			}else{
				dx = 0; ui.position.left = ui.originalPosition.left;
			}
			ui.helper.css(ui.position);
		}

		// Disable snapTo while pressing ctrl/cmd key
		if( ui.helper.draggable('option', 'snap')){
			var d = ui.helper.data('ui-draggable');
			if( (e.ctrlKey || e.metaKey) && d.snapElements.length ){
				d._snapElements = d.snapElements; d.snapElements = [];
			}
			if( !(e.ctrlKey || e.metaKey) && !d.snapElements.length ){
				d.snapElements = d._snapElements;
			}
		}

		// Update selected layers position
		jQuery.each(LS_activeLayerIndexSet, function(idx, layerIndex) {
			var $item = LS_previewItems[layerIndex];
			var op = $item.data('originalPosition');
			$item[0].style.top = ( op.top + dy ) + 'px';
			$item[0].style.left = ( op.left + dx ) + 'px';
		});

		// Update lasso position & position info
		var op = $lasso.data('originalPosition');
		$lasso.css({
			top:  op.top + dy * LS_previewZoom + 'px',
			left: op.left + dx * LS_previewZoom + 'px'
		}).attr({
			'data-info-0': 'x: ' + $lasso.css('left'),
			'data-info-1': 'y: ' + $lasso.css('top')
		});

	});

	// km-ui smartResize init
	kmUI.smartResize.init( '#ls-layers-settings-popout' );


	LayerSlider.updatePreviewSelection();
});

(function( $ ) {

	$.fn.lsRuler = function(unit) {
		unit = unit || 50;

		var $this = this.addClass('ls-ruler'),
			$preview = LS_previewWrapper;

		var offsetX = 0, offsetY = 0;
		var $info = $('<div class="ls-ruler-info">').appendTo(document.body);

		var onDragRulerLineX = function(e) {

			var y = parseFloat( $preview.data('lsRulerPos').y );
			$info.css({
				display: y > 0 ? 'block' : 'none',
				left: e.pageX + 15,
				top: e.pageY - 35,
			}).html('Y: '+ Math.round(y / LS_previewZoom) +' px');
		};

		var onDragRulerLineY = function(e) {
			var x = parseFloat( $preview.data('lsRulerPos').x );
			$info.css({
				display: x > 0 ? 'block' : 'none',
				left: e.pageX + 20,
				top: e.pageY - 40,
			}).html('X: '+ Math.round(x / LS_previewZoom) +' px');
		};


		var $x = $('<div class="ls-ruler-x">').draggable({
			axis: 'y',
			cursorAt: {top: 0},
			helper: function() {
				return $('<div class="ls-ruler-line-x">').appendTo(LS_previewWrapper);
			},
			drag: onDragRulerLineX,
			stop: function(e, ui) {
				$info.css('display', '');
				if (ui.position.top < 0) return;
				var $clone = ui.helper.clone().removeClass('ui-draggable-dragging');
					$clone.draggable({
						axis: 'y',
						start: function(e, ui) {
							offsetY = ui.offset.top - e.pageY;
						},
						drag: onDragRulerLineX,
						stop: function(e, ui) {
							offsetY = 0;
							$info.css('display', '');
							ui.position.top < 0 && ui.helper.remove();
						}
					}).data({
						originalTop: ui.position.top / LS_previewZoom,
						originalLeft: ui.position.left / LS_previewZoom
					}).appendTo($preview);
			}
		}).appendTo(LS_previewWrapper);

		var $y = $('<div class="ls-ruler-y">').draggable({
			axis: 'x',
			cursorAt: {left: 0},
			helper: function() {
				return $('<div class="ls-ruler-line-y">').appendTo(LS_previewWrapper);
			},
			drag: onDragRulerLineY,
			stop: function(e, ui) {
				$info.css('display', '');
				if (ui.position.left < 0) return;
				var $clone = ui.helper.clone().removeClass('ui-draggable-dragging');
					$clone.draggable({
						axis: 'x',
						start: function(e, ui) {
							offsetX = ui.offset.left - e.pageX;
						},
						drag: onDragRulerLineY,
						stop: function(e, ui) {
							offsetX = 0;
							$info.css('display', '');
							ui.position.left < 0 && ui.helper.remove();
						}
					}).data({
						originalTop: ui.position.top / LS_previewZoom,
						originalLeft: ui.position.left / LS_previewZoom
					}).appendTo($preview);
			}
		}).appendTo(LS_previewWrapper);

		var $xw = $('<div class="ls-ruler-wrapper">').appendTo($x),
			$yw = $('<div class="ls-ruler-wrapper">').appendTo($y),
			$xt = $('<div class="ls-ruler-tracker">').appendTo($x),
			$yt = $('<div class="ls-ruler-tracker">').appendTo($y);

		$this.on('zoom.lsRuler', function() {

			// Lower the number of ticks when zoomed out
			$this.toggleClass('disable-5px', LS_previewZoom < 0.75);

			// Resize ruler ticks
			$x.add($y).css({ fontSize: LS_previewZoom * unit });

			// Resize guide lines
			jQuery('.ls-ruler-line-x, .ls-ruler-line-y').each(function() {
				var top 	= jQuery(this).data('originalTop') * LS_previewZoom,
					left 	= jQuery(this).data('originalLeft') * LS_previewZoom;

				jQuery(this).css({ top: top, left: left });
			});

		}).on('resize.lsRuler', function() {

			$this.trigger('zoom.lsRuler');
			var xu = Math.ceil($preview.width() / LS_previewZoom / unit);
			var yu = Math.ceil($preview.height() / LS_previewZoom / unit);
			for (var i = $xw.children().length; i < xu; i++)
				$xw.append('<div class="ls-ruler-unit"><div class="ls-ruler-num">'+ i * unit);
			for (var j = $yw.children().length; j < yu; j++)
				$yw.append('<div class="ls-ruler-unit"><div class="ls-ruler-num">'+ j * unit);
		}).trigger('resize.lsRuler');

		$preview.on('mousemove.lsRuler', function(e) {
			var pos = {
				x: e.pageX + offsetX - Math.round($x.offset().left),
				y: e.pageY + offsetY - Math.round($y.offset().top)
			};
			$preview.data('lsRulerPos', pos);
			$xt.css('left', pos.x);
			$yt.css('top', pos.y);
		}).on('mouseleave.lsRuler', function() {
			$xt.css('left', '');
			$yt.css('top', '');
		});

		return $this;
	};

}( jQuery ));


var kmComboBox = {

	init: function() {

		jQuery(document).on('focus', '.km-combo-input:not(.opened)', function() {
			kmComboBox.show( jQuery(this) );

		}).on('blur', '.km-combo-input.opened', function() {
			var $input = jQuery(this);
			setTimeout(function($input) {
				kmComboBox.hide( $input );
			}, 200, $input);

		}).on('click', '.km-combo-box li', function(){
			kmComboBox.select( jQuery(this) );

		});
	},


	show: function( $input ) {

		var $wrapper,
			$list,
			$parent = $input.parent(),
			options,
			width,
			input,
			list,
			paddingTop;

		$parent.addClass( 'km-combo-parent' );

		input = {
				width: $input.outerWidth(),
				height: $input.outerHeight( true ),
				left: $input.position().left - parseInt( $parent.css( 'padding-left') ),
				top: $input.position().top,
				margins: parseInt( $input.css( 'margin-top' ) ) + parseInt( $input.css( 'margin-bottom' ) )
		};

		$parent.removeClass( 'km-combo-parent' );

		// Retrieve list options
		options = $input.data('options');

		// Create wrapper
		$wrapper = jQuery('<div class="km-combo-box"></div>').insertAfter( $input.addClass( 'opened' ) );

		// Insert combo-list after the input
		$list = jQuery('<ul class="km-combo-list">').appendTo( $wrapper );

		// Populate list
		jQuery.each(options, function(index, option) {
			var optionName = jQuery.type(option) == 'string' ? option : option.name || option.value,
				optionValue = option.value || optionName,
				listItem = jQuery('<li>').data('value', optionValue);
				listItem.text(optionName).appendTo($list);

			if( option.font ) {
				listItem.css('font-family', optionValue);
			}
		});

		// set styles
		list = {
			paddingLeft: parseInt( $list.css( 'padding-left' ) ),
			paddingRight: parseInt( $list.css( 'padding-right' ) ),
			paddingTop: parseInt( $list.css( 'padding-top' ) ),
			paddingBottom: parseInt( $list.css( 'padding-bottom' ) ),
			width: $list.outerWidth()
		};
		$list.css({
			paddingTop: list.paddingTop * 2 + input.height
		});
		list.height = $list.outerHeight();
		wrapper = {
			width: Math.max( input.width + list.paddingLeft + list.paddingRight, list.width ) + 4
		};

		$wrapper.css({
			width: wrapper.width,
			transform: 'translate3d( ' + ( ( input.left + input.width / 2 ) - wrapper.width / 2 ) + 'px,' + ( - input.height - list.paddingTop ) + 'px, 0 )',
			height: list.height
		});

	},


	hide: function( $input ) {

		// Remove the list and wrapper
		$input.removeClass( 'opened' ).next('.km-combo-box').remove();
	},


	select: function( $li ) {

		var $wrapper 	= $li.closest('.km-combo-box'),
			$input 		= $wrapper.prev('input');

		// Enter value into input & trigger event
		$input.val( $li.data('value') ).trigger('input').trigger('change');
	}

};

var layerTransitionPreview = {

	create: function(){

		jQuery( '#ls-layers' ).on( 'mouseenter', '#ls-transition-selector-table .ls-tpreview-wrapper', function(){

			var _tl = new TimelineMax(),
				$el = jQuery(this);

			if( $el.data( 'ls-tpreview' ) ){
				$el.data( 'ls-tpreview' ).clear().kill();
				$el.removeData( 'ls-tpreview' );
			}

			switch( $el.attr('id').split( 'ls-tpreview-')[1] ){

				case 'in':
					_tl.fromTo( $el.find( '.ls-preview-layer' )[0], 1.5, {
						opacity: 1,
						x: -90
					},{
						ease: Quart.easeInOut,
						x: 0
					}).to( $el.find( '.ls-preview-layer' )[0], 0.25, {
						opacity: 0,
						onComplete: function(){
							_tl.progress( 0 );
						}
					});
				break;

				case 'out':
					_tl.to( $el.find( '.ls-preview-layer' )[0], 1.5, {
						ease: Quart.easeInOut,
						x: 90
					}).fromTo( $el.find( '.ls-preview-layer' )[0], 0.25, {
						immediateRender: false,
						x: 0,
						opacity: 0
					},{
						opacity: 1,
						onComplete: function(){
							_tl.progress( 0 );
						}
					});
				break;

				case 'textin':
					_tl.staggerFromTo( $el.find( '.ls-preview-layer_t' ).get(), 1, {
						opacity: 1,
						x: -100,
						rotation: -90
					},{
						ease: Quart.easeOut,
						x: 0,
						rotation: 0
					}, 0.15, null, function(){
						_tl.staggerTo( $el.find( '.ls-preview-layer_t' ).get(), 0.25, {
							opacity: 0
						}, 0, null, function(){
							_tl.progress( 0 );
						});
					});
				break;

				case 'textout':
					_tl.staggerTo( $el.find( '.ls-preview-layer_t' ).get(), 1, {
						x: 100,
						rotation: 90,
						ease: Quart.easeIn,
					}, 0.15, null, function(){
						_tl.staggerFromTo( $el.find( '.ls-preview-layer_t' ).get(), 0.25, {
							immediateRender: false,
							x: 0,
							opacity: 0,
							rotation: 0
						},{
							opacity: 1
						}, 0, null, function(){
							_tl.progress( 0 );
						});
					});
				break;

				case 'loop':
					_tl.to( $el.find( '.ls-preview-layer' )[0], 1.5, {
						rotation: 360,
						repeat: -1,
						ease: Linear.easeNone
					});
				break;

				case 'hover':
					_tl.to( $el.find( '.ls-preview-layer' )[0], .75, {
						scale: 1.5,
						repeat: -1,
						yoyo: true,
						ease: Quad.easeInOut
					});
				break;

				case 'parallax':
					_tl.to( $el.find( '.ls-preview-layer' )[0], 1, {
						x: -10,
						repeat: -1,
						yoyo: true,
						ease: Quad.easeInOut
					}, 0 );
					_tl.to( $el.find( '.ls-preview-layer_b' )[0], 1, {
						x: -15,
						repeat: -1,
						yoyo: true,
						ease: Quad.easeInOut
					}, 0 );
				break;
			}

			jQuery(this).data( 'ls-tpreview', _tl );
		});

		jQuery( '#ls-layers' ).on( 'mouseleave', '#ls-transition-selector-table .ls-tpreview-wrapper', function(){

			if( jQuery(this).data( 'ls-tpreview' ) ){
				jQuery(this).data( 'ls-tpreview' ).clear().kill();
				jQuery(this).removeData( 'ls-tpreview' );
				TweenMax.set( jQuery(this).find( '.ls-preview-layer, .ls-preview-layer_t' ).get(), {
					opacity: 1,
					rotation: 0,
					scale: 1,
					x: 0,
				});
			}
		});
	}
};
