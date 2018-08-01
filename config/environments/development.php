<?php
/** Configuration Overrides for Development */
// Enable plugin and theme updates and installation from the admin
define('DISALLOW_FILE_MODS', false);

define('SAVEQUERIES', true);
define('SCRIPT_DEBUG', true);
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', true);
ini_set('display_errors', 1);
