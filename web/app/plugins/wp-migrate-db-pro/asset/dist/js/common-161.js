// global vars
var wpmdb = wpmdb || {};
wpmdb.common = {
	hooks: [],
	call_stack: [],
	non_fatal_errors: '',
	migration_error: false
};
wpmdb.functions = {};

/**
 * Toggle proper translated strings based on migration type selected.
 *
 * To show the properly translated strings for the selected push or pull
 * migration type, we need to hide all strings then show the right
 * translated strings based on the migration type selected.
 *
 * @see https://github.com/deliciousbrains/wp-migrate-db-pro/issues/764
 *
 * @return void
 */
function wpmdb_toggle_migration_action_text() {
	jQuery( '.action-text' ).hide();
	jQuery( '.action-text.' + jQuery( 'input[name=action]:checked' ).val() ).show();
}

/**
 * Return the currently selected migration type selected.
 *
 * @return string Will return `push`, `pull`, `savefile`, or `` for exporting as a file.
 */
function wpmdb_migration_type() {
	var action = jQuery( 'input[name=action]:checked' );
	if ( 0 === action.length ) {
		return '';
	}
	return action.val();
}

function wpmdb_call_next_hook() {
	if ( !wpmdb.common.call_stack.length ) {
		wpmdb.common.call_stack = wpmdb.common.hooks;
	}

	var func = wpmdb.common.call_stack[ 0 ];
	wpmdb.common.call_stack.shift();
	func.call( this );
}

function wpmdb_add_commas( number_string ) {
	number_string += '';
	var number_parts = number_string.split( '.' );
	var integer = number_parts[ 0 ];
	var decimal = 1 < number_parts.length ? '.' + number_parts[ 1 ] : '';
	var rgx = /(\d+)(\d{3})/;
	while ( rgx.test( integer ) ) {
		integer = integer.replace( rgx, '$1' + ',' + '$2' );
	}
	return integer + decimal;
}

function wpmdb_parse_json( maybe_json ) {
	var json_object = {};
	try {
		json_object = jQuery.parseJSON( maybe_json );
	}
	catch ( e ) {

		// We simply return false here because the json data itself will never just contain a value of "false"
		return false;
	}
	return json_object;
}

/**
 * Global error method for detecting PHP or other errors in AJAX response
 *
 * @param title - the error title if not a PHP error
 * @param code - the error code if not a PHP error
 * @param text - the AJAX response text to sniff for errors
 * @param jqXHR - optional AJAX object used to enrich the error message
 *
 * @returns {string} - html error string with view error toggle element
 */
function wpmdbGetAjaxErrors( title, code, text, jqXHR ) {
	var jsonErrors = false;
	var html = '';

	var validJson = wpmdb_parse_json( text );
	if ( false === validJson ) {
		jsonErrors = true;
		title = wpmdb_strings.ajax_json_message;
		code = '(#144)';
		var originalText = text;
		text = wpmdb_strings.ajax_json_errors + ' ' + code;
		text += '<br><a class="show-errors-toggle" href="#">' + wpmdb_strings.view_error_messages + '</a> ';
		text += '<div class="migration-php-errors">' + originalText + '</div>';
	}

	// Only add local connection issue if php errors (#144) or jqXHR has been provided
	if ( jsonErrors || 'undefined' !== jqXHR ) {
		html += '<strong>' + title + '</strong>' + ' &mdash; ';
	}

	// Only add extra error details if not php errors (#144) and jqXHR has been provided
	if ( !jsonErrors && 'undefined' !== jqXHR ) {
		html += wpmdb_strings.status + ': ' + jqXHR.status + ' ' + jqXHR.statusText;
		html += '<br /><br />' + wpmdb_strings.response + ':<br />';
	}

	// Add code to the end of the error text if not json errors
	if ( !jsonErrors ) {
		text += ' ' + code;
	}

	// Finally add the error message to the output
	html += text;

	return html;
}

wpmdb.preg_quote = function( str, delimiter ) {

	//  discuss at: http://phpjs.org/functions/preg_quote/
	// original by: booeyOH
	// improved by: Ates Goral (http://magnetiq.com)
	// improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// improved by: Brett Zamir (http://brett-zamir.me)
	// bugfixed by: Onno Marsman
	//   example 1: preg_quote("$40");
	//   returns 1: '\\$40'
	//   example 2: preg_quote("*RRRING* Hello?");
	//   returns 2: '\\*RRRING\\* Hello\\?'
	//   example 3: preg_quote("\\.+*?[^]$(){}=!<>|:");
	//   returns 3: '\\\\\\.\\+\\*\\?\\[\\^\\]\\$\\(\\)\\{\\}\\=\\!\\<\\>\\|\\:'

	return String( str )
		.replace( new RegExp( '[.\\\\+*?\\[\\^\\]$(){}=!<>|:\\' + ( delimiter || '' ) + '-]', 'g' ), '\\$&' );
};

wpmdb.table_is = function( table_prefix, desired_table, given_table ) {
	if ( ( table_prefix + desired_table ).toLowerCase() === given_table.toLowerCase() ) {
		return true;
	}

	var escaped_given_table = wpmdb.preg_quote( given_table );
	var regex = new RegExp( table_prefix + '([0-9]+)_' + desired_table, 'i' );
	var results = regex.exec( escaped_given_table );
	return null != results;
};

wpmdb.subsite_for_table = function( table_prefix, table_name ) {
	var escaped_table_name = wpmdb.preg_quote( table_name );
	var regex = new RegExp( table_prefix + '([0-9]+)_', 'i' );
	var results = regex.exec( escaped_table_name );

	if ( null === results ) {
		return 1;
	} else {
		return results[ 1 ];
	}
};

wpmdb.functions.convertKBSizeToHR = function( size, dec, kbSize, retArray ) {
	var retVal, units;
	kbSize = kbSize || 1000;
	dec = dec || 2;
	size = parseInt( size );

	if ( kbSize > Math.abs( size ) ) {
		retVal = [ size.toFixed( 0 ), 'KB' ];
	} else {
		units = [ 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' ];
		var u = -1;
		do {
			size /= kbSize;
			++u;
		} while ( Math.abs( size ) >= kbSize && u < units.length - 1 );
		retVal = [ Math.round( size * Math.pow( 10, dec ) ) / Math.pow( 10, dec ), units[ u ] ];
	}

	if ( ! retArray ) {
		retVal = retVal[0] + ' ' + retVal[1];
	}
	return retVal;
};

wpmdb.functions.convertKBSizeToHRFixed = function( size, dec, kbSize ) {
	dec = dec || 2;
	var hrSizeArray = wpmdb.functions.convertKBSizeToHR( size, dec, kbSize, true );
	if ( 'KB' !== hrSizeArray[1] ) {
		return hrSizeArray[ 0 ].toFixed( 2 ) + ' ' + hrSizeArray[ 1 ];
	}
	return hrSizeArray[ 0 ] + ' ' + hrSizeArray[ 1 ];
};
