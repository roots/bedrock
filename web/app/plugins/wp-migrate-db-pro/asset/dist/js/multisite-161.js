var wpmdb = wpmdb || {};

wpmdb.multisite = {};

(function( $, wpmdb ) {
	wpmdb.multisite.update_multiselect = function( element, subsites, selected_subsite_ids ) {
		$( element ).empty();

		if ( 0 < Object.keys( subsites ).length ) {
			var table_prefix = $.wpmdb.apply_filters( 'wpmdb_get_table_prefix', null, null );
			var site_selected = false;
			$.each( subsites, function( blog_id, subsite_path ) {
				if ( $.wpmdb.apply_filters( 'wpmdb_exclude_subsite', false, blog_id ) ) {
					return;
				}

				var selected = ' ';
				if ( ( undefined === selected_subsite_ids || null === selected_subsite_ids || 0 === selected_subsite_ids.length ) ||
					( undefined !== selected_subsite_ids && null !== selected_subsite_ids && 0 < selected_subsite_ids.length && -1 !== $.inArray( blog_id, selected_subsite_ids ) )
				) {
					selected = ' selected="selected" ';
					site_selected = true;
				}
				subsite_path += ' (' + table_prefix + ( ( '1' !== blog_id ) ? blog_id + '_' : '' ) + ')';
				$( element ).append( '<option' + selected + 'value="' + blog_id + '">' + subsite_path + '</option>' );
			} );

			// If nothing selected (maybe IDs differ between saved profile and current config) revert to default of all selected.
			if ( false === site_selected ) {
				wpmdb.multisite.update_multiselect( element, subsites, [] );
			}
		}
	};

})( jQuery, wpmdb );
