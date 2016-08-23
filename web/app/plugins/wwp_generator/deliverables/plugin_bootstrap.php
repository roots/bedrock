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
 * Plugin Name:       __PLUGIN_NAME__
 * Plugin URI:        http://digital.wonderful.fr/wonderwp/__PLUGIN_SLUG__
 * Description:       __PLUGIN_DESC__
 * Version:           1.0.0
 * Author:            Wonderful
 * Author URI:        http://digital.wonderful.fr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       __PLUGIN_SLUG__
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('WWP_PLUGIN___PLUGIN_CONST___NAME','__PLUGIN_SLUG__');
define('WWP_PLUGIN___PLUGIN_CONST___VERSION','1.0.0');
define('WWP___PLUGIN_CONST___TEXTDOMAIN','__PLUGIN_SLUG__');

/**
 * Register activation hook
 * The code that runs during plugin activation.
 * This action is documented in includes/__PLUGIN_ENTITY__Activator.php
 */
register_activation_hook( __FILE__, function(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/__PLUGIN_ENTITY__Activator.php';
	$activator = new __PLUGIN_NS__\__PLUGIN_ENTITY__Activator(WWP_PLUGIN___PLUGIN_CONST___VERSION);
	$activator->activate();
} );

/**
 * Register deactivation hook
 * The code that runs during plugin deactivation.
 * This action is documented in includes/__PLUGIN_CLASSNAME__Deactivator.php
 */
/*register_deactivation_hook( __FILE__, function(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/__PLUGIN_CLASSNAME__Deactivator.php';
	$deactivator = new __PLUGIN_NS__\__PLUGIN_ENTITY__Deactivator();
	$deactivator->deactivate();
} );*/

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * This class is called the manager
 * Instanciate here because it handles autoloading
 */
require plugin_dir_path( __FILE__ ) . 'includes/__PLUGIN_ENTITY__Manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wwp___PLUGIN_CONST_LOW__(){
	$plugin = new __PLUGIN_NS__\__PLUGIN_ENTITY__Manager(WWP_PLUGIN___PLUGIN_CONST___NAME,WWP_PLUGIN___PLUGIN_CONST___VERSION);
	$plugin->run();
}
run_wwp___PLUGIN_CONST_LOW__();