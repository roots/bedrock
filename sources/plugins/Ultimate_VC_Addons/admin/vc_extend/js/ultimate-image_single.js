
/**
 * Callback function for the 'click' event of the 'Set Footer Image'
 * anchor in its meta box.
 *
 * Displays the media uploader for selecting an image.
 *
 * @since 0.1.0
 */

;(function ( $, window, undefined ) {

	/* 	= Image Up loader
	 *-------------------------------------------------*/
  	var pn = 'ULT_Image_Single',
  	    document = window.document,
  	    defaults = {
  	      add: ".ult_add_image",
  	      remove: "#remove-thumbnail",
  	    };

  	function ult( element, options ) {
  	  this.element = element;
	  this.options = $.extend( {}, defaults, options) ;
	  this._defaults = defaults;
  	  this._name = pn;
	  this.init();
  	}

	ult.prototype.save_and_show_image = function(id, url, caption, alt, title, description) {
  		var $t = $(this.element);

		$t.find( '.ult_selected_image_list .inner' )
	        .children( 'img' )
	            .attr( 'src', url )
	            .attr( 'alt', caption )
	            .show()
		        .parent()
		        .removeClass( 'hidden' );
		var string = '';
		string += (id != '') ? 'id^'+id+'|' : '';
		string += (url != '') ? 'url^'+url+'|' : '';
		string += (caption != '') ? 'caption^'+caption+'|' : '';
		string += (alt != '') ? 'alt^'+alt+'|' : '';
		string += (title != '') ? 'title^'+title+'|' : '';
		string += (description != '') ? 'description^'+description+'|' : '';

		if(string.substr(-1) === '|') {
	        string = string.substr(0, string.length - 1);
	    }

		$t.find('.ult-image_single-value').val(string);
		//	show image
		$t.find( '.ult_selected_image' ).show();
	};

	/* = {start} wp media uploader
	 *------------------------------------------------------------------------*/
	ult.prototype.renderMediaUploader = function() {
	    'use strict';

	    var fn, image_data, json;
	    var self = this;
	    if ( undefined !== fn ) {
	        fn.open();
	        return;
	    }

		fn = wp.media({
	      title: 'Select or Upload Image',
	      button: {
	        text: 'Use this image'
	      },
	      library: { type : 'image' },
	      multiple: false  // Set to true to allow multiple files to be selected
	    });

		//	Insert from {SELECT}
		fn.on( 'select', function() {

			// console.log(wp.media.string);

	        // Read the JSON data returned from the Media Uploader
			json = fn.state().get( 'selection' ).first().toJSON();

			if ( 0 > $.trim( json.url.length ) ) {
				return;
			}

			//	{save} image - id & src - for {SELECT}
			var id 		= json.id || null;
			var url 	= json.url || null;
			var caption = json.caption || null;
			var alt		= json.alt || null;
			var title		= json.title || null;
			var description	= json.description || null;
			self.save_and_show_image(id, url, caption, alt, title, description);
	    });

	 	//	Insert from {URL}
	    fn.state('embed').on( 'select', function() {
			var state = fn.state(),
				type = state.get('type'),
				embed = state.props.toJSON();

			//	{save} image - id & src - for {INSERT FROM URL}
			var id 		= null;
			var caption = embed.caption || null;
			var url 	= embed.url || null;
			var alt		= embed.alt || null;
			var title		= embed.title || null;
			var description	= embed.description || null;
			self.save_and_show_image(id, url, caption, alt, title, description);
		});

	    // Now display the actual fn
	    fn.open();
	};

	ult.prototype.resetUploadForm = function () {
  		var $t = $(this.element);
		$t.find( '.ult_selected_image' ).hide();
		//	{Remove} image - ID & SRC
		$t.find('.ult-image_single-value').val('');
		//$t.find('.ult-image_single-value').val('null|null');
	};

	ult.prototype.renderFeaturedImage = function ( ) {
		var $t = $(this.element);

		var v = $t.find( '.ult-image_single-value' ).val();
		if ( '' !== $.trim ( v ) ) {

			var tm = v.split('|');

			var id, url, title, alt, description, caption, old_id, old_url;
			old_id = tm[0];
			old_url = tm[1];

			jQuery.each(tm, function(i,tmv){
				if(stripos(tmv, '^') !== false) {
					var tmva = tmv.split('|');
					if( Object.prototype.toString.call( tmva ) == '[object Array]' ) {
						jQuery.each(tmva, function(j,tmvav){
							var tmvav_array = tmvav.split('^');
							eval(tmvav_array[0]+' = "'+tmvav_array[1]+'"');
						});
					}
				}
				else {
					id = old_id;
					url = old_url;
				}
			});

			// var url = url.split('|');
			if(typeof url != 'undefined' ) {
				if( url.indexOf('url:') != -1 ) {
					url = url.split("url:").pop();
				}
				if( url.indexOf('url^') != -1 ) {
					url = url.split("url^").pop();
				}
			}

			//	Saved Image - ID
			if( typeof id != 'undefined' && id != 'null' ) {

				if( !url ) {
					// set process
					$t.find( '.spinner.ult_img_single_spinner').css('visibility', 'visible');
					var data = {
						action : 'ult_get_attachment_url',
						attach_id : parseInt(id),
					}
					$.post(ajaxurl, data, function(img_url) {
						$t.find( '.spinner.ult_img_single_spinner').css('visibility', 'hidden');
						$t.find( '.ult_selected_image_list .inner' ).children( 'img' ).attr('src', img_url );
					});
				}
			}

			//	Saved Image - SRC
			if( typeof url != 'undefined' && url != 'null' ) {
				$t.find( '.ult_selected_image_list .inner' ).children( 'img' ).attr('src', url );
				$t.find( '.ult_selected_image' ).show();
			} else {
				$t.find( '.ult_selected_image' ).hide();
			}
		} else {

			$t.find( '.ult_selected_image' ).hide();
			//	{Default} image - ID & SRC
			$t.find('.ult-image_single-value').val('');
			//$t.find('.ult-image_single-value').val('null|null');
		}
	};
	/* = {end} wp media uploader
	 *------------------------------------------------------------------------*/

  	ult.prototype.init = function () {
  		var self = this;
  		var i = self._defaults;
  		var $t = $(self.element);

  		self.renderFeaturedImage( );
  		//	add image
  		$t.find(i.add).click(function(event) {
  			// Stop the anchor's default behavior
            event.preventDefault();
  			self.renderMediaUploader();
  		});

  		// remove image
  		$t.find(i.remove).click(function(event) {
			event.preventDefault();
			self.resetUploadForm( );
  		});

  	};

  	$.fn[pn] = function ( options ) {
  	  return this.each(function () {
  	    if (!$.data(this, 'plugin_' + pn)) {
  	      $.data(this, 'plugin_' + pn, new ult( this, options ));
  	    }
  	  });
  	}

  	//	initial call
	$(document).ready(function() {
		$('.ult-image_single').ULT_Image_Single();
	});

}(jQuery, window));