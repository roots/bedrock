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
 * Plugin Name:       wwp Traduction
 * Plugin URI:        http://digital.wonderful.fr/wonderwp/translator
 * Description:       Module de gestion de langue et de traduction
 * Version:           1.0.0
 * Author:            Wonderful
 * Author URI:        http://digital.wonderful.fr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wonderwp_translator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('WWP_PLUGIN_TRANSLATOR_NAME','wonderwp_translator');
define('WWP_PLUGIN_TRANSLATOR_VERSION','1.0.0');
define('WWP_TRANSLATOR_TEXTDOMAIN','wonderwp_translator');

/**
 * Register activation hook
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wonderwp-activator.php
 */
register_activation_hook( __FILE__, function(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/Translator/TranslatorActivator.php';
	$activator = new \WonderWp\Plugin\Translator\TranslatorActivator(WWP_PLUGIN_TRANSLATOR_VERSION);
	$activator->activate();
} );

/**
 * Register deactivation hook
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wonderwp-deactivator.php
 */
register_deactivation_hook( __FILE__, function(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/Translator/TranslatorDeactivator.php';
	$deactivator = new \WonderWp\Plugin\Translator\TranslatorDeactivator();
	$deactivator->deactivate();
} );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * This class is called the manager
 * Instanciate here because it handles autoloading
 */
require plugin_dir_path( __FILE__ ) . 'includes/Translator/TranslatorManager.php';
require plugin_dir_path( __FILE__ ) . 'includes/functions.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wwp_translator(){
	$plugin = new \WonderWp\Plugin\Translator\TranslatorManager(WWP_PLUGIN_TRANSLATOR_NAME,WWP_PLUGIN_TRANSLATOR_VERSION);
	$plugin->run();
}
run_wwp_translator();