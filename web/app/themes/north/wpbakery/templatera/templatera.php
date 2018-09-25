<?php
/*
Plugin Name: Templatera
Plugin URI: http://vc.wpbakery.com/
Description: Template Manager for Visual Composer on Steroids
Version: 1.0.5
Author: WPBakery
Author URI: http://wpbakery.com
License: http://codecanyon.net/licenses
*/


// don't load directly
if (!defined('ABSPATH')) die('-1');
define('WPB_VC_REQUIRED_VERSION', '3.6.8');

function templatera_notice() {
    $plugin_data = get_plugin_data(__FILE__);
    echo '
  <div class="updated">
    <p>' . sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'north'), $plugin_data['Name']) . '</p>
  </div>';
}
function templatera_notice_version() {
    $plugin_data = get_plugin_data(__FILE__);
    echo '
  <div class="updated">
    <p>' . sprintf(__('<strong>%s</strong> requires <strong>%s</strong> version of <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site. Current version is %s.', 'north'), $plugin_data['Name'], WPB_VC_REQUIRED_VERSION, WPB_VC_VERSION) . '</p>
  </div>';
}


// Get directory path of this plugin.
$dir = dirname(__FILE__);

// Template manager main class is required.
require_once($dir . '/lib/vc_template_manager.php');

/**
 * Registry hooks
 */

register_activation_hook(__FILE__, array('VcTemplateManager', 'install'));

add_action('init', 'templatera_init');
/**
 * Initialize Templatera with init action.
 */
function templatera_init() {
    /*
        Display notice if Visual Composer is not installed or activated.
    */
    if (!defined('WPB_VC_VERSION')) {
        add_action('admin_notices', 'templatera_notice');
        return;
    } elseif(version_compare(WPB_VC_VERSION, WPB_VC_REQUIRED_VERSION) < 0) {
        add_action('admin_notices', 'templatera_notice_version');
        return;
    }
    $dir = dirname(__FILE__);
    // Init or use instance of the manager.
    global $vc_template_manager;
    $vc_template_manager = new VcTemplateManager($dir);
    $vc_template_manager->init();
}