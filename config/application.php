<?php

/** @var string Directory containing all of the site's files */
define('BEDROCK_ROOT_DIR', dirname(__DIR__));

/** @var string Document Root */
define('BEDROCK_WEB_ROOT_DIR', BEDROCK_ROOT_DIR . '/web');

/** @var string Absolute path to the core WordPress directory */
if (!defined('ABSPATH')) {
    define('ABSPATH', BEDROCK_WEB_ROOT_DIR . '/wp/');
}

/**
 * Expose global env() function from oscarotero/env
 */
Env::init();

/**
 * Load configuration modules
 */
foreach (glob(__DIR__ . '/modules/*.php') as $file) {
    include $file;
}
unset($file);
