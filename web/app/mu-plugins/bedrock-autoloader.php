<?php
/**
 * Plugin Name: Bedrock Autoloader
 * Plugin URI: https://github.com/roots/bedrock/
 * Description: An autoloader that enables standard plugins to be required just like must-use plugins. The autoloaded plugins are included after all mu-plugins and standard plugins have been loaded. An asterisk (*) next to the name of the plugin designates the plugins that have been autoloaded.
 * Version: 1.0.0
 * Author: Roots
 * Author URI: http://roots.io/
 * License: MIT License
 */

namespace Roots\Bedrock;

if (!is_blog_installed()) { return; }

class Autoloader {
  private static $cache; // Stores our plugin cache and site option.
  private static $auto_plugins; // Contains the autoloaded plugins (only when needed).
  private static $mu_plugins; // Contains the mu plugins (only when needed).
  private static $count; // Contains the plugin count.
  private static $activated; // Newly activated plugins.
  private static $relative_path; // Relative path to the mu-plugins dir.
  private static $_single; // Let's make this a singleton.

  function __construct() {
    if (isset(self::$_single)) { return; }

    self::$_single       = $this; // Singleton set.
    self::$relative_path = '/../' . basename(__DIR__); // Rel path set.

    if (is_admin()) {
      add_filter('show_advanced_plugins', array($this, 'show_in_admin'), 0, 2); // Admin only filter.
    }
    
    $this->load_plugins();
  }

  /**
   * Run some checks then autoload our plugins.
   */
  public function load_plugins() {
    $this->check_cache();
    $this->validate_plugins();
    $this->count_plugins();

    foreach (self::$cache['plugins'] as $plugin_file => $plugin_info) {
      include_once(WPMU_PLUGIN_DIR . '/' . $plugin_file);
    }

    $this->plugin_hooks();
  }

  /**
   * Filter show_advanced_plugins to display the autoloaded plugins.
   */
  public function show_in_admin($bool, $type) {
    $screen = get_current_screen();

    if ($screen->{'base'} != 'plugins' || $type != 'mustuse' || !current_user_can('activate_plugins')) {
      return $bool;
    }

    global $plugins;

    $this->update_cache(); // May as well update the transient cache whilst here.

    self::$auto_plugins = array_map(function ($auto_plugin) {
      $auto_plugin['Name'] .= ' *';
      return $auto_plugin;
    }, self::$auto_plugins);

    $plugins['mustuse'] = array_unique(array_merge(self::$auto_plugins, self::$mu_plugins), SORT_REGULAR);

    return false; // Prevent WordPress overriding our work.
  }

  /**
   * This sets the cache or calls for an update
   */
  private function check_cache() {
    $cache = get_site_option('bedrock_autoloader');

    if ($cache == false) {
      return $this->update_cache();
    }

    self::$cache = $cache;
  }

  /**
   * Get the plugins and mu-plugins from the mu-plugin path and remove duplicates.
   * Check cache against current plugins for newly activated plugins.
   * After that, we can update the cache.
   */
  private function update_cache() {
    require_once(ABSPATH . 'wp-admin/includes/plugin.php');

    self::$auto_plugins = get_plugins(self::$relative_path);
    self::$mu_plugins   = get_mu_plugins(self::$relative_path);
    $plugins            = array_diff_key(self::$auto_plugins, self::$mu_plugins);
    $rebuild            = !is_array(self::$cache['plugins']);
    self::$activated    = ($rebuild) ? $plugins : array_diff_key($plugins, self::$cache['plugins']);
    self::$cache        = array('plugins' => $plugins, 'count' => $this->count_plugins());

    update_site_option('bedrock_autoloader', self::$cache);
  }

  /**
   * This accounts for the plugin hooks that would run if the plugins were
   * loaded as usual. Plugins are removed by deletion, so there's no way
   * to deactivate or uninstall.
   */
  private function plugin_hooks() {
    if (!is_array(self::$activated)) { return; }

    foreach (self::$activated as $plugin_file => $plugin_info) {
      do_action('activate_' . $plugin_file);
    }
  }

  /**
   * Check that the plugin file exists, if it doesn't update the cache.
   */
  private function validate_plugins() {
    foreach (self::$cache['plugins'] as $plugin_file => $plugin_info) {
      if (!file_exists(WPMU_PLUGIN_DIR . '/' . $plugin_file)) {
        $this->update_cache();
        break;
      }
    }
  }

  /**
   * Count our plugins (but only once) by counting the top level folders in the
   * mu-plugins dir. If it's more or less than last time, update the cache.
   */
  private function count_plugins() {
    if (isset(self::$count)) { return self::$count; }

    $count = count(glob(WPMU_PLUGIN_DIR . '/*/', GLOB_ONLYDIR | GLOB_NOSORT));

    if (!isset(self::$cache['count']) || $count != self::$cache['count']) {
      self::$count = $count;
      $this->update_cache();
    }

    return self::$count;
  }
}

new Autoloader();
