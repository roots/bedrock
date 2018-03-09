<?php

/**
 *
 * Plugin Name: Wonderful Lazy Load
 * Description: Lazy load images to improve page load times. Uses jQuery.sonar to only load an image when it's visible in the viewport.
 * Version: 1.0.0
 * Text Domain: lazy-load
 *
 * Code by the WordPress.com VIP team, TechCrunch 2011 Redesign team, and Jake Goldman (10up LLC).
 * Uses jQuery.sonar by Dave Artz (AOL): http://www.artzstudio.com/files/jquery-boston-2010/jquery.sonar/
 *
 * License: GPL2
 */

use WonderWp\Framework\AbstractPlugin\ActivatorInterface;
use WonderWp\Framework\AbstractPlugin\DeactivatorInterface;
use WonderWp\Framework\AbstractPlugin\ManagerInterface;
use WonderWp\Framework\DependencyInjection\Container;
use WonderWp\Framework\Service\ServiceInterface;
use WonderWp\Plugin\LazyLoad\LazyLoadManager;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('WWP_PLUGIN_LAZYLOAD_NAME','wwp-lazyload');
define('WWP_PLUGIN_LAZYLOAD_VERSION','1.0.0');
define('WWP_LAZYLOAD_TEXTDOMAIN','wwp-lazyload');
if (!defined('WWP_PLUGIN_LAZYLOAD_MANAGER')) {
    define('WWP_PLUGIN_LAZYLOAD_MANAGER', LazyLoadManager::class);
}

/**
 * Register activation hook
 * The code that runs during plugin activation.
 * This action is documented in includes/ErActivator.php
 */
register_activation_hook(__FILE__, function () {
    $activator = Container::getInstance()->offsetGet(WWP_PLUGIN_LAZYLOAD_NAME . '.Manager')->getService(ServiceInterface::ACTIVATOR_NAME);

    if ($activator instanceof ActivatorInterface) {
        $activator->activate();
    }
});

/**
 * Register deactivation hook
 * The code that runs during plugin deactivation.
 * This action is documented in includes/MembreDeactivator.php
 */
register_deactivation_hook(__FILE__, function () {
    $deactivator = Container::getInstance()->offsetExists(WWP_PLUGIN_LAZYLOAD_NAME . '.Manager') ? Container::getInstance()->offsetGet(WWP_PLUGIN_LAZYLOAD_NAME . '.Manager')->getService(ServiceInterface::DEACTIVATOR_NAME) : null;

    if ($deactivator instanceof DeactivatorInterface) {
        $deactivator->deactivate();
    }
});

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * This class is called the manager
 * Instanciate here because it handles autoloading
 */
$plugin = WWP_PLUGIN_LAZYLOAD_MANAGER;
$plugin = new $plugin(WWP_PLUGIN_LAZYLOAD_NAME, WWP_PLUGIN_LAZYLOAD_VERSION);

if (!$plugin instanceof ManagerInterface) {
    throw new \BadMethodCallException(sprintf('Invalid manager class for %s plugin : %s', WWP_PLUGIN_LAZYLOAD_NAME, WWP_PLUGIN_LAZYLOAD_MANAGER));
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
$plugin->run();
