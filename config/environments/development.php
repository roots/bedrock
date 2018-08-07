<?php
/** Configuration Overrides for Development */

use Roots\WPConfig\Config;

Config::define('SAVEQUERIES', true);
Config::define('WP_DEBUG', true);
Config::define('SCRIPT_DEBUG', true);

ini_set('display_errors', 1);
