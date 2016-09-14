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
 * Plugin Name:       wwp Contact
 * Plugin URI:        http://digital.wonderful.fr/wonderwp/wwp-contact
 * Description:       Gestion de formulaires de contact et sauvegarde des messages générés
 * Version:           1.0.0
 * Author:            WonderfulPlugin
 * Author URI:        http://digital.wonderful.fr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wwp-contact
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('WWP_PLUGIN_CONTACT_NAME','wwp-contact');
define('WWP_PLUGIN_CONTACT_VERSION','1.0.0');
define('WWP_CONTACT_TEXTDOMAIN','wwp-contact');

/**
 * Register activation hook
 * The code that runs during plugin activation.
 * This action is documented in includes/ContactActivator.php
 */
register_activation_hook( __FILE__, function(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/ContactActivator.php';
	$activator = new WonderWp\Plugin\Contact\ContactActivator(WWP_PLUGIN_CONTACT_VERSION);
	$activator->activate();
} );

/**
 * Register deactivation hook
 * The code that runs during plugin deactivation.
 * This action is documented in includes/ContactDeactivator.php
 */
/*register_deactivation_hook( __FILE__, function(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/ContactDeactivator.php';
	$deactivator = new WonderWp\Plugin\Contact\ContactDeactivator();
	$deactivator->deactivate();
} );*/

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * This class is called the manager
 * Instanciate here because it handles autoloading
 */
require plugin_dir_path( __FILE__ ) . 'includes/ContactManager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wwp_contact(){
	$plugin = new WonderWp\Plugin\Contact\ContactManager(WWP_PLUGIN_CONTACT_NAME,WWP_PLUGIN_CONTACT_VERSION);
	$plugin->run();
}
run_wwp_contact();