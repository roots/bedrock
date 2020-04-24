<?php
/**
 * Plugin Name:  Bedrock Autoloader
 * Plugin URI:   https://github.com/roots/bedrock/
 * Description:  An autoloader that enables standard plugins to be required just like must-use plugins. The autoloaded plugins are included during mu-plugin loading. An asterisk (*) next to the name of the plugin designates the plugins that have been autoloaded.
 * Version:      1.0.1
 * Author:       Roots
 * Author URI:   https://roots.io/
 * License:      MIT License
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
    /**
     * Singleton instance.
     *
     * @var static
     */
    private static $instance;

    /**
     * Store Autoloader cache and site option.
     *
     * @var array
     */
    private $cache;

    /**
     * Autoloaded plugins.
     *
     * @var array
     */
    private $autoPlugins;

    /**
     * Autoloaded mu-plugins.
     *
     * @var array
     */
    private $muPlugins;

    /**
     * Number of plugins.
     *
     * @var int
     */
    private $count;

    /**
     * Newly activated plugins.
     *
     * @var array
     */
    private $activated;

    /**
     * Relative path to the mu-plugins directory.
     *
     * @var string
     */
    private $relativePath;

    /**
     * Create an instance of Autoloader.
     *
     * @return void
     */
    public function __construct()
    {
        if (isset(self::$instance)) {
            return;
        }

        self::$instance = $this;

        $this->relativePath = '/../' . basename(__DIR__);

        if (is_admin()) {
            add_filter('show_advanced_plugins', [$this, 'showInAdmin'], 0, 2);
        }

        $this->loadPlugins();
    }

   /**
    * Run some checks then autoload our plugins.
    *
    * @return void
    */
    public function loadPlugins()
    {
        $this->checkCache();
        $this->validatePlugins();
        $this->countPlugins();

        array_map(static function () {
            include_once WPMU_PLUGIN_DIR . '/' . func_get_args()[0];
        }, array_keys($this->cache['plugins']));

        $this->pluginHooks();
    }

    /**
     * Filter show_advanced_plugins to display the autoloaded plugins.
     *
     * @param  bool    $show Whether to show the advanced plugins for the specified plugin type.
     * @param  string  $type The plugin type, i.e., `mustuse` or `dropins`
     * @return bool    We return `false` to prevent WordPress from overriding our work
     */
    public function showInAdmin($show, $type)
    {
        $screen = get_current_screen();
        $current = is_multisite() ? 'plugins-network' : 'plugins';

        if ($screen->base !== $current || $type !== 'mustuse' || !current_user_can('activate_plugins')) {
            return $show;
        }

        $this->updateCache();

        $this->autoPlugins = array_map(function ($auto_plugin) {
            $auto_plugin['Name'] .= ' *';
            return $auto_plugin;
        }, $this->autoPlugins);

        $GLOBALS['plugins']['mustuse'] = array_unique(array_merge($this->autoPlugins, $this->muPlugins), SORT_REGULAR);

        return false;
    }

    /**
     * This sets the cache or calls for an update
     *
     * @return void
     */
    private function checkCache()
    {
        $cache = get_site_option('bedrock_autoloader');

        if ($cache === false || (isset($cache['plugins'], $cache['count']) && count($cache['plugins']) !== $cache['count'])) {
            $this->updateCache();
            return;
        }

        $this->cache = $cache;
    }

    /**
     * Update mu-plugin cache.
     *
     * Get the plugins and mu-plugins from the mu-plugin path and remove duplicates.
     * Check cache against current plugins for newly activated plugins.
     * After that, we can update the cache.
     *
     * @return void
     */
    private function updateCache()
    {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';

        $this->autoPlugins = get_plugins($this->relativePath);
        $this->muPlugins   = get_mu_plugins();
        $plugins           = array_diff_key($this->autoPlugins, $this->muPlugins);
        $rebuild           = !(isset($this->cache['plugins']) && is_array($this->cache['plugins']));
        $this->activated   = $rebuild ? $plugins : array_diff_key($plugins, $this->cache['plugins']);
        $this->cache       = ['plugins' => $plugins, 'count' => $this->countPlugins()];

        update_site_option('bedrock_autoloader', $this->cache);
    }

    /**
     * Activate plugin hooks.
     *
     * This accounts for the plugin hooks that would run if the plugins were
     * loaded as usual. Plugins are removed by deletion, so there's no way
     * to deactivate or uninstall.
     *
     * @return void
     */
    private function pluginHooks()
    {
        if (!is_array($this->activated)) {
            return;
        }

        foreach ($this->activated as $plugin_file => $plugin_info) {
            do_action('activate_' . $plugin_file);
        }
    }

    /**
     * Check that the plugin file exists, if it doesn't update the cache.
     *
     * @return void
     */
    private function validatePlugins()
    {
        foreach ($this->cache['plugins'] as $plugin_file => $plugin_info) {
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
        if (isset($this->count)) {
            return $this->count;
        }

        $count = count(glob(WPMU_PLUGIN_DIR . '/*/', GLOB_ONLYDIR | GLOB_NOSORT));

        if (!isset($this->cache['count']) || $count !== $this->cache['count']) {
            $this->count = $count;
            $this->updateCache();
        }

        return $this->count;
    }
}

new Autoloader();
