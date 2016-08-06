<?php
/**
 * Set up our global environment constant and load its config first
 * Default: development
 */
define('WP_ENV', env('WP_ENV') ?: 'development');

$env_config = BEDROCK_ROOT_DIR . '/config/environments/' . WP_ENV . '.php';

if (file_exists($env_config)) {
    require_once $env_config;
}
unset($env_config);
