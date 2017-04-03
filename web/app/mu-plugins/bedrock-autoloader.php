<?php
/**
 * Plugin Name: Bedrock Autoloader
 * Plugin URI: https://github.com/roots/bedrock/
 * Description: An autoloader that enables standard plugins to be required just like must-use plugins. The autoloaded plugins are included during mu-plugin loading. An asterisk (*) next to the name of the plugin designates the plugins that have been autoloaded.
 * Version: 1.0.0
 * Author: Roots
 * Author URI: https://roots.io/
 * License: MIT License
 */

namespace Roots\Bedrock;

if (!is_blog_installed()) {
    return;
}

/**
 * Class Autoloader
 * @package Roots\Bedrock
 * @author Roots
 * @link https://roots.io/
 */
class Autoloader
{
    /** @var array Store Autoloader cache and site option */
    private static $cache;

    /** @var array Autoloaded plugins */
    private static $auto_plugins;

    /** @var array Autoloaded mu-plugins */
    private static $mu_plugins;

    /** @var int Number of plugins */
    private static $count;

    /** @var array Newly activated plugins */
    private static $activated;

    /** @var string Relative path to the mu-plugins dir */
    private static $relative_path;

    /** @var static Singleton instance */
    private static $_single;

    /**
     * Create singleton, populate vars, and set WordPress hooks
     */
    public function __construct()
    {
        if (isset(self::$_single)) {
            return;
        }

        self::$_single = $this;
        self::$relative_path = '/../' . basename(__DIR__);

        if (is_admin()) {
            add_filter('show_advanced_plugins', [$this, 'showInAdmin'], 0, 2);
        }

        $this->loadPlugins();
    }

   /**
    * Run some checks then autoload our plugins.
    */
    public function loadPlugins()
    {
        $this->checkCache();
        $this->validatePlugins();
        $this->countPlugins();

        array_map(static function () {
            include_once(WPMU_PLUGIN_DIR . '/' . func_get_args()[0]);
        }, array_keys(self::$cache['plugins']));

        $this->pluginHooks();
    }

    /**
     * Filter show_advanced_plugins to display the autoloaded plugins.
     * @param $bool bool Whether to show the advanced plugins for the specified plugin type.
     * @param $type string The plugin type, i.e., `mustuse` or `dropins`
     * @return bool We return `false` to prevent WordPress from overriding our work
     * {@internal We add the plugin details ourselves, so we return false to disable the filter.}
     */
    public function showInAdmin($show, $type)
    {
        $screen = get_current_screen();
        $current = is_multisite() ? 'plugins-network' : 'plugins';

        if ($screen->{'base'} != $current || $type != 'mustuse' || !current_user_can('activate_plugins')) {
            return $show;
        }

        $this->updateCache();

        self::$auto_plugins = array_map(function ($auto_plugin) {
            $auto_plugin['Name'] .= ' *';
            return $auto_plugin;
        }, self::$auto_plugins);

        $GLOBALS['plugins']['mustuse'] = array_unique(array_merge(self::$auto_plugins, self::$mu_plugins), SORT_REGULAR);

        return false;
    }

    /**
     * This sets the cache or calls for an update
     */
    private function checkCache()
    {
        $cache = get_site_option('bedrock_autoloader');

        if ($cache === false) {
            $this->updateCache();
            return;
        }

        self::$cache = $cache;
    }

    /**
     * Get the plugins and mu-plugins from the mu-plugin path and remove duplicates.
     * Check cache against current plugins for newly activated plugins.
     * After that, we can update the cache.
     */
    private function updateCache()
    {
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');

        self::$auto_plugins = get_plugins(self::$relative_path);
        self::$mu_plugins   = get_mu_plugins();
        $plugins            = array_diff_key(self::$auto_plugins, self::$mu_plugins);
        $rebuild            = !is_array(self::$cache['plugins']);
        self::$activated    = ($rebuild) ? $plugins : array_diff_key($plugins, self::$cache['plugins']);
        self::$cache        = array('plugins' => $plugins, 'count' => $this->countPlugins());

        update_site_option('bedrock_autoloader', self::$cache);
    }

    /**
     * This accounts for the plugin hooks that would run if the plugins were
     * loaded as usual. Plugins are removed by deletion, so there's no way
     * to deactivate or uninstall.
     */
    private function pluginHooks()
    {
        if (!is_array(self::$activated)) {
            return;
        }

        foreach (self::$activated as $plugin_file => $plugin_info) {
            do_action('activate_' . $plugin_file);
        }
    }

    /**
     * Check that the plugin file exists, if it doesn't update the cache.
     */
    private function validatePlugins()
    {
        foreach (self::$cache['plugins'] as $plugin_file => $plugin_info) {
            if (!file_exists(WPMU_PLUGIN_DIR . '/' . $plugin_file)) {
                $this->updateCache();
                break;
            }
        }
    }

    /**
     * Count the number of autoloaded plugins.
     *
     * Count our plugins (but only once) by counting the top level folders in the
     * mu-plugins dir. If it's more or less than last time, update the cache.
     *
     * @return int Number of autoloaded plugins.
     */
    private function countPlugins()
    {
        if (isset(self::$count)) {
            return self::$count;
        }

        $count = count(glob(WPMU_PLUGIN_DIR . '/*/', GLOB_ONLYDIR | GLOB_NOSORT));

        if (!isset(self::$cache['count']) || $count != self::$cache['count']) {
            self::$count = $count;
            $this->updateCache();
        }

        return self::$count;
    }
}

new Autoloader();
