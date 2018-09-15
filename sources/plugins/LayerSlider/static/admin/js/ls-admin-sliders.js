jQuery(function($) {

	var LS_GoogleFontsAPI = {

		results : 0,
		fontName : null,
		fontIndex : null,

		init : function() {

			// Prefetch fonts
			$('.ls-font-search input').focus(function() {
				LS_GoogleFontsAPI.getFonts();
			});

			// Search
			$('.ls-font-search > button').click(function(e) {
				e.preventDefault();
				var input = $(this).prev()[0];
				LS_GoogleFontsAPI.timeout = setTimeout(function() {
					LS_GoogleFontsAPI.search(input);
				}, 500);
			});

			$('.ls-font-search input').keydown(function(e) {
				if(e.which === 13) {
					e.preventDefault();
					var input = this;
					LS_GoogleFontsAPI.timeout = setTimeout(function() {
						LS_GoogleFontsAPI.search(input);
					}, 500);
				}
			});

			// Form save
			$('form.ls-google-fonts').submit(function() {
				$('ul.ls-font-list li', this).each(function(idx) {
					$('input', this).each(function() {
						$(this).attr('name', 'fontsData['+idx+']['+$(this).data('name')+']');
					});
				});

				return true;
			});

			// Select font
			$('.ls-google-fonts .fonts').on('click', 'li:not(.unselectable)', function() {
				LS_GoogleFontsAPI.showVariants(this);
			});

			// Add font event
			$('.ls-font-search').on('click', 'button.add-font', function(e) {
				e.preventDefault();
				LS_GoogleFontsAPI.addFonts(this);
			});

			// Back to results event
			$('.ls-google-fonts .variants').on('click', 'button:last', function(e) {
				e.preventDefault();
				LS_GoogleFontsAPI.showFonts(this);
			});

			// Close event
			$(document).on( 'click', '.ls-overlay', function() {

				if($(this).data('manualclose')) {
					return false;
				}

				if($('.ls-pointer').length) {
					$(this).remove();
					$('.ls-pointer').children('div.fonts').show().next().hide();
					$('.ls-pointer').animate({ marginTop : 40, opacity : 0 }, 150, function() {
						this.style.display = 'none';
					});
				}
			});

			// Remove font
			$('.ls-font-list').on('click', 'a.remove', function(e) {
				e.preventDefault();
				$(this).parent().animate({ height : 0, opacity : 0 }, 300, function() {

					// Add notice if needed
					if($(this).siblings().length < 2) {
						$(this).parent().append(
							$('<li>', { 'class' : 'ls-notice', 'text' : 'You haven\'t added any Google font to your library yet.'})
						);
					}

					$(this).remove();
				});
			});

			// Add script
			$('.ls-google-fonts .footer select').change(function() {

				// Prevent adding the placeholder option tag
				if($('option:selected', this).index() !== 0) {

					// Selected item
					var item = $('option:selected', this);
					var hasDuplicate = false;

					// Prevent adding duplicates
					$('.ls-google-font-scripts input').each(function() {
						if($(this).val() === item.val()) {
							hasDuplicate = true;
							return false;
						}
					});

					// Add item
					if(!hasDuplicate) {
						var clone = $('.ls-google-font-scripts li:first').clone();
							clone.find('span').text( item.text() );
							clone.find('input').val( item.val() );
							clone.removeClass('ls-hidden').appendTo('.ls-google-font-scripts');
					}

					// Show the placeholder option tag
					$('option:first', this).prop('selected', true);
				}
			});

			// Remove script
			$('.ls-google-font-scripts').on('click', 'li a', function(event) {
				event.preventDefault();

				if($('.ls-google-font-scripts li').length > 2) {
					$(this).closest('li').remove();
				} else {
					alert('You need to have at least one character set added. Please select another item before removing this one.');
				}
			});
		},

		getFonts : function() {

			if(LS_GoogleFontsAPI.results == 0) {
				var API_KEY = 'AIzaSyC_iL-1h1jz_StV_vMbVtVfh3h2QjVUZ8c';
				$.getJSON('https://www.googleapis.com/webfonts/v1/webfonts?key=' + API_KEY, function(data) {
					LS_GoogleFontsAPI.results = data;
				});
			}
		},

		search : function(input) {

			// Hide overlay if any
			$('.ls-overlay').remove();

			// Get search field
			var searchValue = $(input).val().toLowerCase();

			// Wait until fonts being fetched
			if(LS_GoogleFontsAPI.results != 0 && searchValue.length > 2 ) {

				// Search
				var indexes = [];
				var found = $.grep(LS_GoogleFontsAPI.results.items, function(obj, index) {
					if(obj.family.toLowerCase().indexOf(searchValue) !== -1) {
						indexes.push(index);
						return true;
					}
				});

				// Get list
				var list = $('.ls-font-search .ls-pointer .fonts ul');

				// Remove previous contents and append new ones
				list.empty();
				if(found.length) {
					for(c = 0; c < found.length; c++) {
						list.append( $('<li>', { 'data-key' : indexes[c], 'text' : found[c]['family'] }));
					}
				} else {
					list.append($('<li>', { 'class' : 'unselectable' })
						.append( $('<h4>', { 'text' : 'No results were found' }))
					);
				}

				// Show pointer and append overlay
				$('.ls-font-search .ls-pointer').show().animate({ marginTop : 15, opacity : 1 }, 150);
				$('<div>', { 'class' : 'ls-overlay dim'}).prependTo('body');
			}
		},

		showVariants : function(li) {

			// Get selected font
			var fontName = $(li).text();
			var fontIndex = $(li).data('key');
			var fontObject = LS_GoogleFontsAPI.results.items[fontIndex]['variants'];
			LS_GoogleFontsAPI.fontName = fontName;
			LS_GoogleFontsAPI.fontIndex = fontIndex;

			// Get and empty list
			var list = $(li).closest('div').next().children('ul');
				list.empty();


			// Change header
			$(li).closest('.ls-box').children('.header').text('Select "'+fontName+'" variants');

			// Append variants
			for(c = 0; c < fontObject.length; c++) {
				list.append( $('<li>', { 'class' : 'unselectable' })
					.append( $('<input>', { 'type' : 'checkbox'} ))
					.append( $('<span>', { 'text' : ucFirst(fontObject[c]) }))
				);
			}

			// Init checkboxes
			list.find(':checkbox').customCheckbox();

			// Show variants
			$(li).closest('.fonts').hide().next().show();
		},

		showFonts : function(button) {
			$(button).closest('.ls-box').children('.header').text('Choose a font family');
			$(button).closest('.variants').hide().prev().show();
		},

		addFonts: function(button) {

			// Get variants
			var variants = $(button).parent().prev().find('input:checked');

			var apiUrl = [];
			var urlVariants = [];
			apiUrl.push(LS_GoogleFontsAPI.fontName.replace(/ /g, '+'));

			if(variants.length) {
				apiUrl.push(':');
				variants.each(function() {
					urlVariants.push( $(this).siblings('span').text().toLowerCase() );
				});
				apiUrl.push(urlVariants.join(','));
			}

			LS_GoogleFontsAPI.appendToFontList( apiUrl.join('') );
		},

		appendToFontList : function(url) {

			// Empty notice if any
			$('ul.ls-font-list li.ls-notice').remove();

			var index = $('ul.ls-font-list li').length - 1;

			// Append list item
			var item = $('ul.ls-font-list li.ls-hidden').clone();
				item.children('input:text').val(url);
				item.appendTo('ul.ls-font-list').attr('class', '');

			// Reset search field
			$('.ls-font-search input').val('');

			// Close pointer
			$('.ls-overlay').click();
		}
	};


	// Checkboxes
	$('.ls-global-settings :checkbox').customCheckbox();
	$('.ls-google-fonts :checkbox').customCheckbox();

	// Tabs
	$('.km-tabs').kmTabs();

	// Google Fonts API
	LS_GoogleFontsAPI.init();

	$('.ls-sliders-grid').on('click', '.slider-actions', function() {

		var $this 		= $(this),
			$item 		= $this.closest('.slider-item'),
			$wrapper 	= $item.children(),
			$sheet 		= $item.find('.slider-actions-sheet');

			$item.addClass('ls-opened');
			$sheet.removeClass('ls-hidden');
			$('.ls-hover', $item).hide();
			TweenLite.to($sheet[0], 0.3, {
				y: 0
			});
	});

	$('.ls-sliders-grid').on('mouseleave', '.slider-item', function() {

		var $this 	= $(this),
			$item 	= $this.closest('.slider-item'),
			$sheet 	= $item.find('.slider-actions-sheet');

			if( $item.hasClass('ls-opened') ) {

				$item.removeClass('ls-opened');
				$sheet.removeClass('ls-hidden');
				$('.ls-hover', $item).show();

				TweenLite.to($sheet[0], 0.4, {
					y: -150
				});
			}

	// Add sliderls-add-slider-template
	}).on('click', '#ls-add-slider-button', function(e) {
		e.preventDefault();

		var $button = $(this),
			$wrap 	= $button.closest('.slider-item-wrapper'),
			$sheet 	= $('#ls-add-slider-template');

		if( ! $sheet.length ) {
			$sheet = $( $('#tmpl-ls-add-slider-grid').text() ).appendTo( $wrap );
		}

		$sheet.find('input').focus();
		TweenLite.set( $sheet, { x: 240 });
		TweenLite.to( [ $button[0], $sheet[0] ], 0.5, {
			x: '-=240'
		});
	});


	$('.ls-sliders-list').on('click', '#ls-add-slider-button', function(e) {
		e.preventDefault();

		var offsets = $(this).offset();
		var popup = $('#ls-add-slider-template-list').length ?
					$('#ls-add-slider-template-list') :
					$( $('#tmpl-ls-add-slider-list').html() ).prependTo('body');

		popup.css({
			top : offsets.top + 35,
			left : offsets.left - popup.outerWidth() / 2 + $(this).width() / 2 + 7
		}).show().animate({ marginTop : 0, opacity : 1 }, 150, function() {
			$(this).find('.inner input').focus();
		});

		$('<div>', { 'class' : 'ls-overlay dim'}).prependTo('body');


	}).on('click', '.slider-actions', function() {

		var $this = $(this);
		setTimeout(function() {
			var offsets = $this.position(),
				height 	= $('#ls-slider-actions-template').removeClass('ls-hidden').height();

			$('#ls-slider-actions-template').css({
				top : offsets.top + 15 - height / 2,
				right : 40,
				marginTop : 0,
				opacity : 1
			});

			$('#ls-slider-actions-template a:eq(0)').data('id', $this.data('id') );
			$('#ls-slider-actions-template a:eq(0)').data('slug', $this.data('slug') );

			$('#ls-slider-actions-template a:eq(1)').attr('href', $this.data('export-url') );
			$('#ls-slider-actions-template a:eq(2)').attr('href', $this.data('duplicate-url') );
			$('#ls-slider-actions-template a:eq(3)').attr('href', $this.data('remove-url') );


			setTimeout(function() {
				$('body').one('click', function() {
					$('#ls-slider-actions-template').addClass('ls-hidden');
				});
			}, 200);
		}, 100);
	});

	// Slider remove
	$('.ls-slider-list-form').on('click', 'a.remove', function(e) {
		e.preventDefault();
		if(confirm('Are you sure you want to remove this slider?')){
			document.location.href = $(this).attr('href');
		}


	// Upload
	}).on('click', '#ls-import-button', function(e) {
		e.preventDefault();
		kmUI.modal.open('#tmpl-upload-sliders', { height: 400 });

	// Embed
	}).on('click', 'a.embed', function(e) {
		e.preventDefault();

		var $this 	= $(this),
			$modal 	= kmUI.modal.open('#tmpl-embed-slider', { width: 900, height: 600 }),
			id 		= $this.data('id'),
			slug 	= $this.data('slug') || id;

		$modal.find('input.shortcode').val('[layerslider id="'+slug+'"]');
	});

	// Pagivation
	$('.pagination-links a.disabled').click(function(e) {
		e.preventDefault();
	});


	// Import sample slider
	$( '#ls-import-samples-button' ).on( 'click', function( event ) {

		event.preventDefault();

		var	$modal,
			width = jQuery( window ).width(),
			tl;

		if( jQuery( '#ls-import-modal-window' ).length ){

			$modal = jQuery( '#ls-import-modal-window' );

		}else{

			// Update last store view date
			jQuery.get( window.ajaxurl, { action: 'ls_store_opened' });

			$modal = jQuery( jQuery('#tmpl-import-sliders').text() ).hide().prependTo('body');

			lsLogo.append( '#ls-import-modal-window .layerslider-logo', true );

			setTimeout(function(){

				var	Shuffle = window.shuffle,
					element = jQuery( '#ls-import-modal-window .inner .items' )[0];
					shuffle = new Shuffle(element, {
						itemSelector: '.item',
						speed: 400,
						easing:'ease-in-out',
						delimeter: ','
					}),
					$comingSoon = jQuery( '.coming-soon' );

				jQuery( '#ls-import-modal-window .inner nav li' ).on( 'click', function(){
					jQuery(this).addClass('active').siblings().removeClass('active');
					shuffle.filter( jQuery(this).data( 'group' ) );
					if( !jQuery( '.shuffle .shuffle-item--visible' ).length ){
						$comingSoon.addClass( 'visible' );
					}else{
						$comingSoon.removeClass( 'visible' );
					}
				});

			}, 100 );
		}

		tl = new TimelineMax({
			onStart: function(){
				jQuery( 'html, body' ).addClass( 'ls-body-black' );
				jQuery( '<div>' ).addClass( 'ls-overlay-transparent' ).css({
					position: 'fixed',
					left: 0,
					top: 0,
					right: 0,
					bottom: 0
				}).appendTo( '#wpwrap' );
				jQuery( '#wpwrap' ).addClass( 'ls-wp-wrap-white' );
				jQuery(document).on( 'keyup.LS', function( e ) {
					if( e.keyCode === 27 ){
						jQuery( '#ls-import-samples-button' ).data( 'lsModalTimeline' ).reverse();
					}
				});
			},
			onReverseComplete: function(){
				jQuery( 'html, body' ).removeClass( 'ls-body-black' );
				jQuery( '#wpwrap' ).removeClass( 'ls-wp-wrap-white' );
				jQuery( '#wpwrap' ).attr( 'style', '' );
				jQuery( '#ls-import-samples-button' ).data( 'lsModalTimeline' ).clear().kill();
				jQuery( '#ls-import-samples-button' ).removeData( 'lsModalTimeline' );
				jQuery(document).off( 'keyup.LS' );
				jQuery( '#ls-import-modal-window' ).css({
					display: 'none'
				});
				jQuery( '.ls-overlay-transparent' ).remove();
			},
			paused: true
		});

		$(this).data( 'lsModalTimeline', tl );

		tl.fromTo( $modal[0], 1, {
			autoCSS: false,
			css: {
				position: 'fixed',
				display: 'block',
				x: width,
				rotationY: 45,
				opacity: .4,
				transformPerspective: width,
				transformOrigin: '0% 50%'
			}
		},{
			autoCSS: false,
			css: {
				x: 0,
				opacity: 1,
				rotationY: 0
			},
			ease: Quint.easeInOut
		}, 0 );

		tl.fromTo( $( '#wpwrap' )[0], 1, {
			autoCSS: false,
			css: {
				transformPerspective: width,
				transformOrigin: '100% 50%'
			}
		},{
			autoCSS: false,
			css: {
				x: -width,
				rotationY: -45,
				opacity: .4
			},
			ease: Quint.easeInOut
		}, 0 );

		tl.add( function(){
			shuffle.update();
		}, 0.15 );

		tl.play();
	});

	$( document ).on( 'click', '#ls-import-modal-window > header b', function(){
		$( '#ls-import-samples-button' ).data( 'lsModalTimeline' ).reverse();
	});

	// Close add slider window
	$(document).on( 'click', '.ls-overlay', function() {

		if($(this).data('manualclose')) {
			return false;
		}

		if($('.ls-pointer').length) {
			$('.ls-overlay').remove();
			$('.ls-pointer').animate({ marginTop : 40, opacity : 0 }, 150);
		}

	// Upload window
	}).on('submit', '#ls-upload-modal-window form', function(e) {

		jQuery('.button', this).text('Uploading, please wait ...').addClass('saving');
	});

	// Auto-update setup screen
	$('.button-activation').click(function(e) {
		e.preventDefault();

		var $wrapper 	= $(this).closest('.ls-box'),
			$guide 		= $wrapper.find('.guide'),
			$form 		= $wrapper.find('form'),
			width 		= $wrapper.outerWidth(true) + 10;

		$form.show().find('.key input').focus();

		TweenLite.set( $form, { x: width });
		TweenLite.to( [ $guide[0], $form[0] ], 0.5, {
			x: '-='+width
		});
	});

	// Auto-update authorization
	$('.ls-auto-update form').submit(function(e) {

		// Prevent browser default submission
		e.preventDefault();

		var $form 	= $(this),
			$key 	= $form.find('.key input'),
			$button = $form.find('.button-save:visible');

		if( $key.val().length < 10 ) {
			alert('Please enter a valid Item Purchase Code. For more information, please click on the "Where\'s my purchase code?" button.');
			return false;
		}

		// Send request and provide feedback message
		$button.data('text', $button.text() ).text('Working ...').addClass('saving');

		// Post it
		$.post( ajaxurl, $(this).serialize(), function(data) {

			// Parse response and set message
			data = $.parseJSON(data);

			// Show or hide 'Check for updates' button
			if(data && ! data.errCode ) {
				$form.closest('.ls-box').addClass('active');

				var $notice 	= $('p.note', $form);
				$notice.css('color', '#74bf48').text( data.message );

				$('[data-premium-warning]').data('premium-warning', false);

			// Alert message (if any)
			} else if(typeof data.message !== "undefined") {
				alert(data.message);
			}

			$button.removeClass('saving').text( $button.data('text') );
		});
	});


	// Auto-update deauthorization
	$('.ls-auto-update a.ls-deauthorize').click(function(event) {
		event.preventDefault();

		if( confirm('Are you sure you want to deactivate this site?') ) {

			var $form = $(this).closest('form');

			$.get( ajaxurl, $.param({ action: 'layerslider_deauthorize_site'}), function(data) {

				// Parse response and set message
				var data = $.parseJSON(data);

				if( data && ! data.errCode ) {

					var $box 	= $form.closest('.ls-box'),
						$guide 	= $box.find('.guide'),
						$notice = $form.find('p.note');

					$notice.css('color', '#666').text('');

					$form.find('.key input').val('');
					$box.removeClass('active');

					$form.hide();
					$guide.css('transform', 'translateX(0px)').show();
				}

				// Alert message (if any)
				if(typeof data.message !== "undefined") {
					alert(data.message);
				}
			});
		}
	});

	$('.ls-product-banner .unlock').click(function(e) {
		e.preventDefault();

		var $box 	= $('.ls-product-banner.ls-auto-update'),
			$window = $(window),
			wh 		= $window.height(),
			bt 		= $box.offset().top,
			bh 		= $box.height(),
			top 	= bt + (bh / 2) - (wh / 2);

			$('html,body').animate({ scrollTop: top }, 200, function() {
				setTimeout(function() {

					TweenMax.to( $box[0], 0.2, {
						yoyo: true,
						repeat: 3,
						ease: Quad.easeInOut,
						scale: 1.1
					});
				}, 100);
			});
	});

	// Permission form
	$('#ls-permission-form').submit(function(e) {
		e.preventDefault();
		if(confirm('WARNING: This option controls who can access to this plugin, you can easily lock out yourself by accident. Please, make sure that you have entered a valid capability without whitespaces or other invalid characters. Do you want to proceed?')) {
			this.submit();
		}
	});


	// News filters
	$('.ls-news .filters li').click(function() {

		// Highlight
		$(this).siblings().attr('class', '');
		$(this).attr('class', 'active');

		// Get stuff
		var page = $(this).data('page');
		var frame = $(this).closest('.ls-box').find('iframe');
		var baseUrl = frame.attr('src').split('#')[0];

		// Set filter
		frame.attr('src', baseUrl+'#'+page);

	});


	// Shortcode
	$('input.ls-shortcode').click(function() {
		this.focus();
		this.select();
	});

	// Importing demo sliders
	$( document ).on('click', '#ls-import-modal-window .item-import', function( event ) {
		event.preventDefault();

		var $item 	= jQuery(this),
			$figure = $item.closest('figure'),
			handle 	= $figure.data('handle'),
			bundled = !! $figure.data('bundled'),
			action 	= bundled ? 'ls_import_bundled' : 'ls_import_online';

		// Premium notice
		if( $figure.data('premium-warning') ) {
			kmUI.modal.open( {
				into: '#ls-import-modal-window',
				title: window.lsImportWarningTitle,
				content: window.lsImportWarningContent,
				width: 700,
				height: 200,
				overlayAnimate: 'fade'
			});
			return;
		}

		kmUI.modal.open( '#tmpl-importing', {
			into: '#ls-import-modal-window',
			width: 300,
			height: 300,
			close: false
		});
		lsLogo.append( '#ls-importing-modal-window .layerslider-logo', true );

		jQuery.ajax({
			url: ajaxurl,
			data: {
				action: action,
				slider: handle,
				security: window.lsImportNonce
			},
			success: function(data, textStatus, jqXHR) {
				data = JSON.parse( data );
				if( data && data.success ) {
					document.location.href = data.url;
				} else if(data.message) {
					setTimeout(function() {
						alert(data.message);
						setTimeout(function() {
							kmUI.modal.close();
							kmUI.overlay.close();
						}, 1000);
					}, 600);

				} else {
					setTimeout(function() {
						alert('It seems there is a server issue that prevented LayerSlider from importing your selected slider. Please check LayerSlider -> System Status for potential errors, try to temporarily disable themes/plugins to rule out incompatibility issues or contact your hosting provider to resolve server configuration problems. In many cases retrying to import the same slider can help.');
						setTimeout(function() {
							kmUI.modal.close();
							kmUI.overlay.close();
						}, 1000);
					}, 600);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				setTimeout(function() {
					kmUI.modal.close();
							kmUI.overlay.close();
					alert('It seems there is a server issue that prevented LayerSlider from importing your selected slider. Please check LayerSlider -> System Status for potential errors, try to temporarily disable themes/plugins to rule out incompatibility issues or contact your hosting provider to resolve server configuration problems. In many cases retrying to import the same slider can help. Your HTTP server thrown the following error: \n\r\n\r'+errorThrown);
					setTimeout(function() {
						kmUI.modal.close();
						kmUI.overlay.close();
					}, 1000);
				}, 600);
			},
			complete: function() {
				$item.css('color', '#0073aa');
			}
		});
	});

});

var addLSOverlay = function() {

	var $overlay = jQuery('<div class="ls-overlay"></div>').prependTo('body');

	TweenLite.fromTo( $overlay[0], 0.4, {
		autoCSS: false,
		css: {
			y: -jQuery( window ).height()
		}
	},{
		autoCSS: false,
		ease: Quart.easeInOut,
		css: {
			y: 0
		}
	});

	setTimeout(function() {

		jQuery( '.ls-overlay' ).one( 'click', function() {

			// TweenLite.fromTo( this, 0.4, {
			// 	autoCSS: false,
			// 	css: {
			// 		y: 0
			// 	}
			// },{
			// 	autoCSS: false,
			// 	ease: Quart.easeInOut,
			// 	css: {
			// 		y: -jQuery( window ).height()
			// 	},
			// 	onComplete: function(){
			// 		jQuery('.ls-overlay,.ls-modal').remove();
			// 		jQuery('body').css('overflow', 'auto');
			// 	}
			// });

			jQuery('.ls-overlay,.ls-modal').remove();
			jQuery('body').css('overflow', 'auto');
		});

		jQuery( '.ls-modal b' ).one( 'click', function() {
			jQuery( '.ls-overlay' ).click();
		});

	}, 300);
};
