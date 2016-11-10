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
 * Plugin Name:       wwp Jeux
 * Plugin URI:        http://digital.wonderful.fr/wonderwp/wwp-jeux
 * Description:       Moteur de jeux
 * Version:           1.0.0
 * Author:            WonderfulPlugin
 * Author URI:        http://digital.wonderful.fr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wwp-jeux
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('WWP_PLUGIN_JEUX_NAME','wwp-jeux');
define('WWP_PLUGIN_JEUX_VERSION','1.0.0');
define('WWP_JEUX_TEXTDOMAIN','wwp-jeux');

/**
 * Register activation hook
 * The code that runs during plugin activation.
 * This action is documented in includes/JeuxActivator.php
 */
register_activation_hook( __FILE__, function(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/JeuxActivator.php';
	$activator = new WonderWp\Plugin\Jeux\JeuxActivator(WWP_PLUGIN_JEUX_VERSION);
	$activator->activate();
} );

/**
 * Register deactivation hook
 * The code that runs during plugin deactivation.
 * This action is documented in includes/JeuxDeactivator.php
 */
/*register_deactivation_hook( __FILE__, function(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/JeuxDeactivator.php';
	$deactivator = new WonderWp\Plugin\Jeux\JeuxDeactivator();
	$deactivator->deactivate();
} );*/

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * This class is called the manager
 * Instanciate here because it handles autoloading
 */
require plugin_dir_path( __FILE__ ) . 'includes/JeuxManager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wwp_jeux(){
	$plugin = new WonderWp\Plugin\Jeux\JeuxManager(WWP_PLUGIN_JEUX_NAME,WWP_PLUGIN_JEUX_VERSION);
	$plugin->run();
}
run_wwp_jeux();