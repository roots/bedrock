<?php
/*
Plugin Name: WP Migrate DB Pro Compatibility
Plugin URI: http://deliciousbrains.com/wp-migrate-db-pro/
Description: Prevents 3rd party plugins from being loaded during WP Migrate DB specific operations
Author: Delicious Brains
Version: 1.2
Author URI: http://deliciousbrains.com
*/

if ( ! version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	return;
}

$GLOBALS['wpmdb_compatibility']['active'] = true;

if ( defined( 'WP_PLUGIN_DIR' ) ) {
	$plugins_dir = trailingslashit( WP_PLUGIN_DIR );

} else if ( defined( 'WPMU_PLUGIN_DIR' ) ) {
	$plugins_dir = trailingslashit( WPMU_PLUGIN_DIR );

} else if ( defined( 'WP_CONTENT_DIR' ) ) {
	$plugins_dir = trailingslashit( WP_CONTENT_DIR ) . 'plugins/';

} else {
	$plugins_dir = plugin_dir_path( __FILE__ ) . '../plugins/';
}

$compat_class_path            = 'class/Common/Compatibility/Compatibility.php';
$compat_class_name            = 'DeliciousBrains\WPMDB\Common\Compatibility\Compatibility';
$wpmdbpro_compatibility_class = $plugins_dir . 'wp-migrate-db-pro/' . $compat_class_path;
$wpmdb_compatibility_class    = $plugins_dir . 'wp-migrate-db/' . $compat_class_path;

if ( file_exists( $wpmdbpro_compatibility_class ) ) {
	include_once $wpmdbpro_compatibility_class;
} elseif ( file_exists( $wpmdb_compatibility_class ) ) {
	include_once $wpmdb_compatibility_class;
}

if ( class_exists( $compat_class_name ) ) {
	new $compat_class_name;
}