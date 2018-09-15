<?php
/*
Plugin Name: Templatera
Plugin URI: http://vc.wpbakery.com/
Description: Template Manager for Visual Composer on Steroids
Version: 1.1.11
Author: WPBakery
Author URI: http://wpbakery.com
License: http://codecanyon.net/licenses
*/

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
define( 'WPB_VC_REQUIRED_VERSION', '4.11' );

function templatera_notice() {
	$plugin_data = get_plugin_data( __FILE__ );
	echo '
  <div class="updated">
    <p>' . sprintf( __( '<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_template' ), $plugin_data['Name'] ) . '</p>
  </div>';
}

function templatera_notice_version() {
	$plugin_data = get_plugin_data( __FILE__ );
	echo '
  <div class="updated">
    <p>' . sprintf( __( '<strong>%s</strong> requires <strong>%s</strong> version of <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site. Current version is %s.', 'vc_template' ), $plugin_data['Name'], WPB_VC_REQUIRED_VERSION, WPB_VC_VERSION ) . '</p>
  </div>';
}

// Get directory path of this plugin.
$dir = dirname( __FILE__ );

// Template manager main class is required.
require_once( $dir . '/lib/vc_template_manager.php' );

/**
 * Registry hooks
 */

register_activation_hook( __FILE__, array( 'VcTemplateManager', 'install' ) );

add_action( 'init', 'templatera_init' );

/**
 * Initialize Templatera with init action.
 */
function templatera_init() {

	// Display notice if Visual Composer is not installed or activated.
	if ( ! defined( 'WPB_VC_VERSION' ) ) {
		add_action( 'admin_notices', 'templatera_notice' );

		return;
	} else if ( version_compare( WPB_VC_VERSION, WPB_VC_REQUIRED_VERSION ) < 0 ) {
		add_action( 'admin_notices', 'templatera_notice_version' );

		return;
	}

	if ( ! defined( 'WPB_VC_NEW_MENU_VERSION' ) ) {
		define( 'WPB_VC_NEW_MENU_VERSION', (boolean) ( version_compare( '4.5', WPB_VC_VERSION ) <= 0 ) );
	}

	if ( ! defined( 'WPB_VC_NEW_USER_ACCESS_VERSION' ) ) {
		define( 'WPB_VC_NEW_USER_ACCESS_VERSION', (boolean) ( version_compare( '4.8', WPB_VC_VERSION ) <= 0 ) );
	}

	if ( WPB_VC_NEW_MENU_VERSION ) {
		add_action( 'admin_head', 'wpb_templatera_menu_highlight' );
		add_action( 'vc_menu_page_build', 'wpb_templatera_add_submenu_page' );
	}

	add_filter( 'page_row_actions', 'wpb_templatera_render_row_action' );
	add_filter( 'post_row_actions', 'wpb_templatera_render_row_action' );

	$dir = dirname( __FILE__ );

	// Init or use instance of the manager.
	global $vc_template_manager;
	$vc_template_manager = new VcTemplateManager( $dir );
	$vc_template_manager->init();
}

/**
 * Add sub page to Visual Composer pages
 *
 * @since 1.2
 */
function wpb_templatera_add_submenu_page() {
	if ( ! WPB_VC_NEW_USER_ACCESS_VERSION || ( WPB_VC_NEW_USER_ACCESS_VERSION && vc_user_access()
				->part( 'templates' )
				->checkStateAny( true, null )
				->get() )
	) {
		$labels = VcTemplateManager::getPostTypesLabels();
		add_submenu_page( VC_PAGE_MAIN_SLUG, $labels['name'], $labels['name'], 'manage_options', 'edit.php?post_type=' . rawurlencode( VcTemplateManager::postType() ), '' );
	}
}

/**
 * Highlight Vc submenu
 *
 * @since 1.2
 */
function wpb_templatera_menu_highlight() {
	global $parent_file, $submenu_file, $post_type;

	if ( $post_type === VcTemplateManager::postType() && ( ! defined( 'VC_IS_TEMPLATE_PREVIEW' ) || ! VC_IS_TEMPLATE_PREVIEW ) ) {
		$parent_file = VC_PAGE_MAIN_SLUG;
		$submenu_file = 'edit.php?post_type=' . rawurlencode( VcTemplateManager::postType() );
	}
}

/**
 * Add 'Export' link to each template
 *
 * @param $actions
 *
 * @return mixed
 */
function wpb_templatera_render_row_action( $actions ) {
	$post = get_post();

	if ( 'templatera' === get_post_type( $post->ID ) ) {
		$url = 'export.php?page=wpb_vc_settings&action=export_templatera&id=' . $post->ID;
		$actions['vc_export_template'] = '<a href="' . $url . '">' . __( 'Export', 'js_composer' ) . '</a>';
	}

	return $actions;
}
