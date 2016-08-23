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
 * Plugin Name:       wwp Generator
 * Plugin URI:        http://digital.wonderful.fr/wonderwp/generator
 * Description:       Module de generation de plugin compatible wonderwp
 * Version:           1.0.0
 * Author:            Wonderful
 * Author URI:        http://digital.wonderful.fr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wonderwp_generator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('WWP_PLUGIN_GENERATOR_NAME','wonderwp_generator');
define('WWP_PLUGIN_GENERATOR_VERSION','1.0.0');
define('WWP_GENERATOR_TEXTDOMAIN','wonderwp_generator');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * This class is called the manager
 * Instanciate here because it handles autoloading
 */
require plugin_dir_path( __FILE__ ) . 'includes/GeneratorManager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wwp_generator(){
	$plugin = new \WonderWp\Plugin\Generator\GeneratorManager(WWP_PLUGIN_GENERATOR_NAME,WWP_PLUGIN_GENERATOR_VERSION);
	$plugin->run();
}
run_wwp_generator();