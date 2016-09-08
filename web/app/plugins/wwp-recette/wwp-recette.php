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
 * Plugin Name:       wwp Recette
 * Plugin URI:        http://digital.wonderful.fr/wonderwp/wwp-recette
 * Description:       Module d'administration de recettes
 * Version:           1.0.0
 * Author:            WonderfulPlugin
 * Author URI:        http://digital.wonderful.fr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wwp-recette
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('WWP_PLUGIN_RECETTE_NAME','wwp-recette');
define('WWP_PLUGIN_RECETTE_VERSION','1.0.0');
define('WWP_RECETTE_TEXTDOMAIN','wwp-recette');

/**
 * Register activation hook
 * The code that runs during plugin activation.
 * This action is documented in includes/RecetteActivator.php
 */
register_activation_hook( __FILE__, function(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/RecetteActivator.php';
	$activator = new WonderWp\Plugin\Recette\RecetteActivator(WWP_PLUGIN_RECETTE_VERSION);
	$activator->activate();
} );

/**
 * Register deactivation hook
 * The code that runs during plugin deactivation.
 * This action is documented in includes/RecetteDeactivator.php
 */
/*register_deactivation_hook( __FILE__, function(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/RecetteDeactivator.php';
	$deactivator = new WonderWp\Plugin\Recette\RecetteDeactivator();
	$deactivator->deactivate();
} );*/

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * This class is called the manager
 * Instanciate here because it handles autoloading
 */
require plugin_dir_path( __FILE__ ) . 'includes/RecetteManager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wwp_recette(){
	$plugin = new WonderWp\Plugin\Recette\RecetteManager(WWP_PLUGIN_RECETTE_NAME,WWP_PLUGIN_RECETTE_VERSION);
	$plugin->run();
}
run_wwp_recette();