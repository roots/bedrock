<?php

namespace WPMDB\Transfers\Files;

/**
 * Class Excludes
 *
 * @package WPMDB\Transfers\Excludes
 */
class Excludes {

	public $excludes;

	public function __construct() {
	}

	/**
	 *
	 * Given an array of paths, check if $filePath matches
	 *
	 *
	 * @param string $filePath
	 * @param array $excludes
	 *
	 * @return array
	 */
	public static function shouldExcludeFile( $filePath, $excludes ) {
		$matches = [];

		if ( empty( $excludes ) || ! \is_array( $excludes ) ) {
			return $matches;
		}

		foreach ( $excludes as $pattern ) {
			$include = false;

			if ( empty( $pattern ) ) {
				break;
			}

			// If pattern starts with an exclamation mark remove exclamation mark and check if pattern matches current file path
			if ( 0 === strpos( $pattern, '!' ) ) {
				$pattern = ltrim( $pattern, '!' );
				$include = true;
			}

			if ( self::pathMatches( $filePath, $pattern ) ) {
				$type                            = $include ? 'include' : 'exclude';
				$matches[ $type ][ $filePath ][] = $pattern;
			}
		}

		// If the file should be included (based on the '!' character) none of the matched exclusion patterns matter
		if ( ! empty( $matches['include'] ) ) {
			$matches['exclude'] = [];
		}

		return $matches;
	}

	/**
	 *
	 * Convert glob pattern to regex
	 * https://stackoverflow.com/a/13914119/130596
	 *
	 * @param      $path
	 * @param      $pattern
	 * @param bool $ignoreCase
	 *
	 * @return bool
	 */
	public static function pathMatches( $path, $pattern, $ignoreCase = false ) {

		$expr = preg_replace_callback( '/[\\\\^$.[\\]|()?*+{}\\-\\/]/', function ( $matches ) {
			switch ( $matches[0] ) {
				case '*':
					return '.*';
				case '?':
					return '.';
				default:
					return '\\' . $matches[0];
			}
		}, $pattern );

		$expr = '/' . $expr . '/';
		if ( $ignoreCase ) {
			$expr .= 'i';
		}

		return (bool) preg_match( $expr, $path );
	}
}
