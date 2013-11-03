<?php
/**
 * Set up our global environment constant and load its config first
 * Default: development
 */

define('WP_ENV', isset($_SERVER['WP_ENV']) ? $_SERVER['WP_ENV'] : 'development');

$env_config = dirname(__FILE__) . '/environments/' . WP_ENV . '.php';

if (file_exists($env_config)) {
  require_once $env_config;
}

/**
 * Custom Content Directory
 */
define('CONTENT_DIR', '/app');
define('WP_CONTENT_DIR', dirname(dirname(__FILE__)) . CONTENT_DIR);
define('WP_CONTENT_URL', 'http://' . $_SERVER['HTTP_HOST'] . CONTENT_DIR);

/**
 * DB settings
 */
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');
$table_prefix = 'wp_';

/**
 * Authentication Unique Keys and Salts
 * https://api.wordpress.org/secret-key/1.1/salt
 */
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

/**
 * Custom Settings
 */
define('AUTOMATIC_UPDATER_DISABLED', true);
define('DISABLE_WP_CRON', true);
define('DISALLOW_FILE_EDIT', true);

/**
 * Bootstrap WordPress
 */
if (!defined('ABSPATH')) {
  define('ABSPATH', dirname(dirname(__FILE__)) . '/wp/');
}
