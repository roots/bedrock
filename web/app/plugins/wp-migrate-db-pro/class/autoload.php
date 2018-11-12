<?php

spl_autoload_register( function ( $class ) {
	$filename = str_replace( '\\', '/', $class ) . '.php';
	$filename = __DIR__ . '/' . $filename;

	$namespaces = array(
		'WPMDB'    => array(
			'search'  => 'WPMDB',
			'replace' => '',
		)
	);

	foreach ( $namespaces as $namespace => $search_replace ) {

		//Only loads files in the WPMDB namespace Ex. `WPMDB\Transfers`;
		if ( stristr( $class, $namespace ) ) {

			// Remove WPMDB from the path because `spl_autoload_register()` assumes a folder per namespace root
			$filename = str_replace( $search_replace['search'] . '/', $search_replace['replace'], $filename );

			if ( ! file_exists( $filename ) ) {
				return false; // End autoloader function and skip to the next if available.
			}

			include_once $filename;
		}
	}

	return true;
} );
