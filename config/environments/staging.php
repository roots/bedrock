<?php
/* Staging */
define('DB_NAME', $_SERVER['DB_NAME']);
define('DB_USER', $_SERVER['DB_USER']);
define('DB_PASSWORD', $_SERVER['DB_PASSWORD']);
define('DB_HOST', isset($_SERVER['DB_HOST']) ? $_SERVER['WPDB_HOST_ENV'] : 'localhost');

define('WP_HOME', $_SERVER['WP_HOME']);
define('WP_SITEURL', $_SERVER['WP_SITEURL']);

ini_set('display_errors', 0);
define('WP_DEBUG_DISPLAY', false);
