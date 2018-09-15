(function ( $, vc ) {
	'use strict';
	if ( vc && vc.events ) {
		vc.events.on( 'shortcodes:sync:param:type:vc_grid_id' +
			' shortcodes:add:param:type:vc_grid_id' +
			' shortcodes:update:param:type:vc_grid_id', function ( model ) {
			var params = model.get( 'params' );
			params.page_id = $( '#post_ID' ).val();
			model.set( 'params', params );
		} );
	}
})( window.jQuery, window.vc );