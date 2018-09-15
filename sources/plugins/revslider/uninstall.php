<?php 
if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
	exit();

/**
 * disable deletion of anything 
 * @since 5.0
 
$currentFile = __FILE__;
$currentFolder = dirname($currentFile);
require_once $currentFolder . '/inc_php/globals.class.php';

global $wpdb;
$tableSliders = $wpdb->prefix . RevSliderGlobals::TABLE_SLIDERS_NAME;
$tableSlides = $wpdb->prefix . RevSliderGlobals::TABLE_SLIDES_NAME;
$tableSettings = $wpdb->prefix . RevSliderGlobals::TABLE_SETTINGS_NAME;
$tableCss = $wpdb->prefix . RevSliderGlobals::TABLE_CSS_NAME;
$tableAnims = $wpdb->prefix . RevSliderGlobals::TABLE_LAYER_ANIMS_NAME;
$tableStaticSlides = $wpdb->prefix . RevSliderGlobals::TABLE_STATIC_SLIDES_NAME;

$wpdb->query( "DROP TABLE $tableSliders" );
$wpdb->query( "DROP TABLE $tableSlides" );
$wpdb->query( "DROP TABLE $tableSettings" );
$wpdb->query( "DROP TABLE $tableCss" );
$wpdb->query( "DROP TABLE $tableAnims" );
$wpdb->query( "DROP TABLE $tableStaticSlides" );

//deactivate activation if plugin was activated

delete_option('revslider-latest-version');
delete_option('revslider-update-check-short');
delete_option('revslider-update-check');
delete_option('revslider_update_info');
delete_option('revslider-code');
delete_option('revslider-valid');
delete_option('revslider-valid-notice');
*/

//needs to be deleted so that everything gets checked at a new installation
delete_option('revslider_table_version');
delete_option('revslider_checktables');
delete_option('rs_public_version');
?>