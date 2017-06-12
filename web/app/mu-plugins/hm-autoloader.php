<?php

namespace HM\Autoloader;

class Autoloader {
	const NS_SEPARATOR = '\\';

	protected $prefix;
	protected $prefix_length;
	protected $path;

	public function __construct( $prefix, $path ) {
		$this->prefix        = $prefix;
		$this->prefix_length = strlen( $prefix );
		$this->path          = trailingslashit( $path );
	}

	public function load( $class ) {
		if ( strpos( $class, $this->prefix . self::NS_SEPARATOR ) !== 0 ) {
			return;
		}

		// Strip prefix from the start (ala PSR-4)
		$class = substr( $class, $this->prefix_length + 1 );
		$class = strtolower( $class );
		$file = '';

		if ( false !== ( $last_ns_pos = strripos( $class, self::NS_SEPARATOR ) ) ) {
			$namespace = substr( $class, 0, $last_ns_pos );
			$class     = substr( $class, $last_ns_pos + 1 );
			$file      = str_replace( self::NS_SEPARATOR, DIRECTORY_SEPARATOR, $namespace ) . DIRECTORY_SEPARATOR;
		}
		$file .= 'class-' . str_replace( '_', '-', $class ) . '.php';

		$path = $this->path . $file;

		if ( file_exists( $path ) ) {
			require_once $path;
		}
	}
}

function register_class_path( $prefix, $path ) {
	$loader = new Autoloader( $prefix, $path );
	spl_autoload_register( [ $loader, 'load' ] );
}
