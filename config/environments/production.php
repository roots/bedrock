<?php

/**
 * Configuration overrides for WP_ENV === 'production'
 */

use Roots\WPConfig\Config;
use function Env\env;

/* Debug */
Config::define('SAVEQUERIES', false);
Config::define('WP_DEBUG', false);
Config::define('WP_DEBUG_DISPLAY', false);
Config::define('WP_DEBUG_LOG', env('WP_DEBUG_LOG') ?? false);
Config::define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
Config::define('SCRIPT_DEBUG', false);

/* Enable and disable indexing */
Config::define('DISALLOW_INDEXING', false);

/* Cache */
Config::define('WP_CACHE', true);

/* Disable File Edits */
Config::define('DISALLOW_FILE_EDIT', true);

/* Posts Revisions */
Config::define('WP_POST_REVISIONS', 2);

/* Clean the trash */
Config::define('EMPTY_TRASH_DAYS', 5);

/* Allows edited images to replace the original files on the server */
Config::define('IMAGE_EDIT_OVERWRITE', true);

/* SSL */
Config::define('FORCE_SSL_LOGIN', true);
Config::define('FORCE_SSL_ADMIN', true);

/* WordPress URL. */
Config::define('WP_SITEURL', env('WP_SITEURL') ?? 'https://example.com/wp');

/* Compression GZIP */
Config::define('ENFORCE_GZIP', true);

/* CRON */
Config::define('DISABLE_WP_CRON', false);

ini_set('display_errors', 0);

/* Enable updates and installation of plugins and themes from the admin */
Config::define('DISALLOW_FILE_MODS', false);
