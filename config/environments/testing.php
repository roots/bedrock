<?php
/** Testing (PHPUnit) */
define('WP_DEBUG', true);
define('WP_USE_THEMES', true);
define('WP_DEFAULT_THEME', 'default');
define('WP_TESTS_DOMAIN', parse_url(env('WP_HOME'), PHP_URL_HOST));
define('WP_TESTS_EMAIL', 'test@' . WP_TESTS_DOMAIN);
define('WP_TESTS_TITLE', 'Test Title');
define('WP_PHP_BINARY', 'php');
define('WPLANG', '');

// Test with multisite enabled.
// define('WP_TESTS_MULTISITE', true);
