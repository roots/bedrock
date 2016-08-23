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
 * Plugin Name:       wwp Newsletter
 * Plugin URI:        http://digital.wonderful.fr/wonderwp/wwp-newsletter
 * Description:       Module permettant de donner la possibilité à vos utilisateurs de s'inscrire à des newsletter
 * Version:           1.0.0
 * Author:            Wonderful
 * Author URI:        http://digital.wonderful.fr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wwp-newsletter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('WWP_PLUGIN_NEWSLETTER_NAME','wwp-newsletter');
define('WWP_PLUGIN_NEWSLETTER_VERSION','1.0.0');
define('WWP_NEWSLETTER_TEXTDOMAIN','wwp-newsletter');

/**
 * Register activation hook
 * The code that runs during plugin activation.
 * This action is documented in includes/NewsletterActivator.php
 */
register_activation_hook( __FILE__, function(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/NewsletterActivator.php';
	$activator = new WonderWp\Plugin\Newsletter\NewsletterActivator(WWP_PLUGIN_NEWSLETTER_VERSION);
	$activator->activate();
} );

/**
 * Register deactivation hook
 * The code that runs during plugin deactivation.
 * This action is documented in includes/NewsletterDeactivator.php
 */
/*register_deactivation_hook( __FILE__, function(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/NewsletterDeactivator.php';
	$deactivator = new WonderWp\Plugin\Newsletter\NewsletterDeactivator();
	$deactivator->deactivate();
} );*/

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * This class is called the manager
 * Instanciate here because it handles autoloading
 */
require plugin_dir_path( __FILE__ ) . 'includes/NewsletterManager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wwp_newsletter(){
	$plugin = new WonderWp\Plugin\Newsletter\NewsletterManager(WWP_PLUGIN_NEWSLETTER_NAME,WWP_PLUGIN_NEWSLETTER_VERSION);
	$plugin->run();
}
run_wwp_newsletter();