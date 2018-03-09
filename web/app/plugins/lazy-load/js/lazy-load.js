
(function($) {

	lazy_load_init();
	$( 'body' ).bind( 'post-load', lazy_load_init ); // Work with WP.com infinite scroll

	function lazy_load_init() {
		$( 'img[data-lazy-src]' ).bind( 'scrollin', { distance: 200 }, function() {
			lazy_load_image( this );
		});

		// We need to force load gallery images in Jetpack Carousel and give up lazy-loading otherwise images don't show up correctly
		$( '[data-carousel-extra]' ).each( function() {
			$( this ).find( 'img[data-lazy-src]' ).each( function() {
				lazy_load_image( this );
			} );		
		} );
	}

	function lazy_load_image( img ) {
		var $img = jQuery( img ),
			src = $img.attr( 'data-lazy-src' );

		if ( ! src || 'undefined' === typeof( src ) )
			return;

		$img.unbind( 'scrollin' ) // remove event binding
			.hide()
			.removeAttr( 'data-lazy-src' )
			.attr( 'data-lazy-loaded', 'true' );

		img.src = src;
		$img.fadeIn();
	}
})(jQuery);
