jQuery(document).ready(function($) {

	tinymce.create('tinymce.plugins.layerslider_plugin', {

		init : function(ed, url) {
			// Close event
			$(document).on('click', '.ls-overlay', $.proxy(function() {
				this.closePopup();
			}, this));

			// Button props
			ed.addButton('layerslider_button', {
				title : 'Add LayerSlider',
				cmd : 'layerslider_insert_shortcode',
				onClick : $.proxy(this.openPopup, this)
			});
		},


		openPopup : function(e) {
			// Re-assign "on slider select" event
			$(document).off('click', '.ls-pointer li').on('click', '.ls-pointer li', $.proxy(function(e) {
				this.selectSlider($(e.currentTarget));
				this.closePopup();
			}, this));

			// Get the popup
			var popup = $('.ls-pointer');

			// If the popup isn't already open, create it and load its content using ajax
			if(!$('.ls-pointer').length) {

				// Add popup markup
				$('body').prepend( $('<div>', { 'class' : 'ls-pointer ls-shortcode-pointer ls-box' })
					.append( $('<span>', { 'class' : 'ls-mce-arrow'} ))
					.append( $('<h3>', { 'class' : 'header', 'text' : 'Insert LayerSlider to page'} ))
					.append( $('<ul>', { 'class' : 'inner' } ))
				);

				// Add overlay
				$('<div>', { 'class' : 'ls-overlay dim'}).prependTo('body');

				// Re-assign popup to new container
				popup = $('.ls-pointer');
				popup.animate({ marginTop : 0, opacity : 1 }, 150);

				// Get sliders
				$.getJSON(ajaxurl, { action : 'ls_get_mce_sliders' }, function(data) {
					for(c = 0; c < data.length; c++) {
						popup.children('ul').append( $('<li>', { 'data-id' : data[c]['id'], 'data-slug' : data[c]['slug'] })
							.append( $('<div>', { 'class' : 'preview' })
								.append( $('<img>', { 'src' : data[c]['preview']}))
							)
							.append( $('<div>', { 'class' : 'title', 'html' : data[c]['name'].substr(0, 28) }))
						);
					}
				});
			}

			// move the popup to the button of the current editor
			var offsets = $(e.currentTarget).find('.mce-i-layerslider_button,.mce_layerslider_button').offset();
			popup.css({
				top : offsets.top + 35,
				left : offsets.left + 12 - popup.outerWidth() / 2
			});
		},

		searchSlider : function() {

		},

		selectSlider : function(el) {
			if(el.data('slug') != '') {
				tinymce.execCommand('mceInsertContent', false, '[layerslider id="'+el.data('slug')+'"]');
			} else {
				tinymce.execCommand('mceInsertContent', false, '[layerslider id="'+el.data('id')+'"]');
			}
		},

		closePopup : function() {
			if($('.ls-pointer').length) {
				$('.ls-overlay').remove();
				$('.ls-pointer').animate({ marginTop : 40, opacity : 0 }, 150, function() {
					$(this).remove();
				});
			}
		}
	});

	// Add button
	tinymce.PluginManager.add('layerslider_button', tinymce.plugins.layerslider_plugin);
});
