(function( $ ) {

	$.wpmdb = {
		/**
		 * Implement a WordPress-link Hook System for Javascript
		 * TODO: Change 'tag' to 'args', allow number (priority), string (tag), object (priority+tag)
		 */
		hooks: { action: {}, filter: {} },
		add_action: function( action, callable, tag ) {
			jQuery.wpmdb.add_hook( 'action', action, callable, tag );
		},
		add_filter: function( action, callable, tag ) {
			jQuery.wpmdb.add_hook( 'filter', action, callable, tag );
		},
		do_action: function( action, args ) {
			jQuery.wpmdb.do_hook( 'action', action, null, args );
		},
		apply_filters: function( action, value, args ) {
			return jQuery.wpmdb.do_hook( 'filter', action, value, args );
		},
		remove_action: function( action, tag ) {
			jQuery.wpmdb.remove_hook( 'action', action, tag );
		},
		remove_filter: function( action, tag ) {
			jQuery.wpmdb.remove_hook( 'filter', action, tag );
		},
		add_hook: function( hook_type, action, callable, tag ) {
			if ( undefined === jQuery.wpmdb.hooks[hook_type][action] ) {
				jQuery.wpmdb.hooks[hook_type][action] = [];
			}
			var hooks = jQuery.wpmdb.hooks[hook_type][action];
			if ( undefined === tag ) {
				tag = action + '_' + hooks.length;
			}
			jQuery.wpmdb.hooks[hook_type][action].push( { tag: tag, callable: callable } );
		},
		do_hook: function( hook_type, action, value, args ) {
			if ( undefined !== jQuery.wpmdb.hooks[hook_type][action] ) {
				var hooks = jQuery.wpmdb.hooks[hook_type][action];
				for ( var i = 0; i < hooks.length; i++ ) {
					if ( 'action' === hook_type ) {
						hooks[i].callable( args );
					} else {
						value = hooks[i].callable( value, args );
					}
				}
			}
			if ( 'filter' === hook_type ) {
				return value;
			}
		},
		remove_hook: function( hook_type, action, tag ) {
			if ( undefined !== jQuery.wpmdb.hooks[hook_type][action] ) {
				var hooks = jQuery.wpmdb.hooks[hook_type][action];
				for ( var i = hooks.length - 1; 0 < i; i-- ) {
					if ( undefined === tag || tag === hooks[i].tag ) {
						hooks.splice( i, 1 );
					}
				}
			}
		}
	};

})( jQuery );
