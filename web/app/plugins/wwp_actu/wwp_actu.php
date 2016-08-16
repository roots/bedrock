<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://digital.wonderful.fr
 * @since             1.0.0
 * @package           WonderWp
 *
 * @wordpress-plugin
 * Plugin Name:       wwp Actualités
 * Plugin URI:        http://digital.wonderful.fr/wonderwp/actualites
 * Description:       Module d'aministration des actualités
 * Version:           1.0.0
 * Author:            WonderfulPlugin
 * Author URI:        http://digital.wonderful.fr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wonderwp_actu
 * Domain Path:       /languages
 * Module:            true
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('WWP_PLUGIN_ACTU_NAME','wonderwp_actu');
define('WWP_PLUGIN_ACTU_VERSION','1.0.0');
define('WWP_ACTU_TEXTDOMAIN','wonderwp_actu');

/**
 * Register activation hook
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wonderwp-activator.php
 */
register_activation_hook( __FILE__, function(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/ActuActivator.php';
	$activator = new \WonderWp\Plugin\Actu\ActuActivator(WWP_PLUGIN_ACTU_VERSION);
	$activator->activate();
} );

/**
 * Register deactivation hook
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wonderwp-deactivator.php
 */
register_deactivation_hook( __FILE__, function(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/ActuDeactivator.php';
	$deactivator = new \WonderWp\Plugin\Actu\ActuDeactivator();
	$deactivator->deactivate();
} );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * This class is called the manager
 * Instanciate here because it handles autoloading
 */
require plugin_dir_path( __FILE__ ) . 'includes/ActuManager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wwp_actu(){
	$plugin = new \WonderWp\Plugin\Actu\ActuManager(WWP_PLUGIN_ACTU_NAME,WWP_PLUGIN_ACTU_VERSION);
	$plugin->run();
}
run_wwp_actu();