<?php

/** @var string Directory containing all of the site's files */
$root_dir = dirname(__DIR__);

/** @var string Document Root */
$webroot_dir = $root_dir . '/web';

/**
 * Expose global env() function from oscarotero/env
 */
Env::init();

/**
 * Use Dotenv to set required environment variables and load .env file in root
 */
$dotenv = new Dotenv\Dotenv($root_dir);
if (file_exists($root_dir . '/.env')) {
    $dotenv->load();
    $dotenv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'WP_HOME', 'WP_SITEURL']);
}

/**
 * Set up our global environment constant and load its config first
 * Default: development
 */
define('WP_ENV', env('WP_ENV') ?: 'development');

$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';

if (file_exists($env_config)) {
    require_once $env_config;
}

/**
 * URLs
 */
define('WP_HOME', env('WP_HOME'));
define('WP_SITEURL', env('WP_SITEURL'));
if (!isset($_SERVER['HTTPS']) && strpos(WP_HOME, 'https') !== false) {
    $_SERVER['HTTPS'] = 'on';
}

/**
 * Custom Content Directory
 */
define('ROOT_DIR', $root_dir);
define('CONTENT_DIR', '/app');
define('WP_CONTENT_DIR', $webroot_dir . CONTENT_DIR);
define('WP_CONTENT_URL', WP_HOME . CONTENT_DIR);

/**
 * DB settings
 */
define('DB_NAME', env('DB_NAME'));
define('DB_USER', env('DB_USER'));
define('DB_PASSWORD', env('DB_PASSWORD'));
define('DB_HOST', env('DB_HOST') ?: 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');
define( 'WP_POST_REVISIONS', 5 );
$table_prefix = env('DB_PREFIX') ?: 'wp_';

/**
 * Authentication Unique Keys and Salts
 */
define('AUTH_KEY', env('AUTH_KEY'));
define('SECURE_AUTH_KEY', env('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY', env('LOGGED_IN_KEY'));
define('NONCE_KEY', env('NONCE_KEY'));
define('AUTH_SALT', env('AUTH_SALT'));
define('SECURE_AUTH_SALT', env('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT', env('LOGGED_IN_SALT'));
define('NONCE_SALT', env('NONCE_SALT'));
define('COOKIEHASH', sha1(WP_HOME));

/**
 * Langue
 */
define ('WPLANG', 'fr_FR');

/**
 * Custom Settings
 */
define('AUTOMATIC_UPDATER_DISABLED', !in_array(WP_ENV,['staging','production']));
define('DISABLE_WP_CRON', env('DISABLE_WP_CRON') ?: false);
define('DISALLOW_FILE_EDIT', true);
define('FS_METHOD','direct');

/**
 * WP Rocket
 */
define('WP_ROCKET_EMAIL', 'jeremy.desvaux@wonderful.fr');
define('WP_ROCKET_KEY', '90767766');

/**
 * Assets
 */
define('ASSETS_GROUP_APP','app');

/**
 * Bootstrap WordPress
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', $webroot_dir . '/wp/');
}

define('FRONT_ENV', 'webpack'); // change to Gulp for older version (default)
define("WWP_PLUGIN_GUTENBERGUTILS_MANAGER",WonderWp\Plugin\GutenbergUtils\Child\GutenbergUtilsThemeManager::class);
define("WWP_PLUGIN_TRANSLATOR_MANAGER",WonderWp\Plugin\Translator\Child\TranslatorThemeManager::class);
//define("WWP_PLUGIN_SOCIAL_MANAGER",WonderWp\Plugin\Social\Child\SocialThemeManager::class);
//define("WWP_PLUGIN_CONTACT_MANAGER",WonderWp\Plugin\Contact\Child\ContactThemeManager::class);
//define("WWP_PLUGIN_EMPLOI_MANAGER",WonderWp\Plugin\Emploi\Child\EmploiThemeManager::class);
//define("WWP_PLUGIN_MAP_MANAGER",WonderWp\Plugin\Map\Child\MapThemeManager::class);
//define("WWP_PLUGIN_RGPD_MANAGER",WonderWp\Plugin\RGPD\Child\RgpdThemeManager::class);
//define("WWP_PLUGIN_TROMBI_MANAGER",WonderWp\Plugin\Trombinoscope\Child\TrombiThemeManager::class);
//define("WWP_PLUGIN_VIDEO_MANAGER",WonderWp\Plugin\Video\Child\VideoThemeManager::class);
//define("WWP_PLUGIN_MEMBRE_MANAGER",WonderWp\Plugin\EspaceRestreint\Child\ErThemeManager::class);
//define("WWP_PLUGIN_EVENT_MANAGER",WonderWp\Plugin\Event\Child\EventThemeManager::class);
//define("WWP_PLUGIN_FAQ_MANAGER",WonderWp\Plugin\Faq\Child\FaqThemeManager::class);
//define("WWP_PLUGIN_GALERIE_MANAGER",WonderWp\Plugin\Galerie\Child\GalerieThemeManager::class);
//define("WWP_PLUGIN_JEUX_MANAGER",WonderWp\Plugin\Jeux\Child\JeuxThemeManager::class);
//define("WWP_PLUGIN_NEWSROOM_MANAGER",WonderWp\Plugin\NewsRoom\Child\NewsRoomThemeManager::class);
//define("WWP_PLUGIN_PARCOURS_MANAGER",WonderWp\Plugin\Parcours\Child\ParcoursThemeManager::class);
//define("WWP_PLUGIN_PARTENAIRE_MANAGER",WonderWp\Plugin\Partenaires\Child\PartenaireThemeManager::class);
//define("WWP_PLUGIN_SOCIAL_MANAGER",WonderWp\Plugin\Social\Child\SocialThemeManager::class);
//define("WWP_PLUGIN_VOTE_MANAGER",WonderWp\Plugin\Vote\Child\VoteThemeManager::class);
//define("WWP_PLUGIN_NEWSLETTER_MANAGER",WonderWp\Plugin\Newsletter\Child\NewsletterThemeManager::class);
//define("WWP_PLUGIN_BP_MANAGER",WonderWp\Plugin\Bp\Child\BpThemeManager::class);
//define("WWP_PLUGIN_MEMBRE_MANAGER",WonderWp\Plugin\EspaceRestreint\Child\ErThemeManager::class);
//define("WWP_PLUGIN_ACTU_MANAGER",WonderWp\Plugin\Actu\Child\ActuThemeManager::class);
//define("WWP_PLUGIN_CONTACT_MANAGER",WonderWp\Plugin\Contact\Child\ContactThemeManager::class);
//define("WWP_PLUGIN_EMPLOI_MANAGER",WonderWp\Plugin\Emploi\Child\EmploiThemeManager::class);
//define("WWP_PLUGIN_EVENT_MANAGER",WonderWp\Plugin\Event\Child\EventThemeManager::class);
//define("WWP_PLUGIN_FAQ_MANAGER",WonderWp\Plugin\Faq\Child\FaqThemeManager::class);
//define("WWP_PLUGIN_GALERIE_MANAGER",WonderWp\Plugin\Galerie\Child\GalerieThemeManager::class);
//define("WWP_PLUGIN_JEUX_MANAGER",WonderWp\Plugin\Jeux\Child\JeuxThemeManager::class);
//define("WWP_PLUGIN_SLIDER_MANAGER",WonderWp\Plugin\Slider\Child\SliderThemeManager::class);
//define("WWP_PLUGIN_NEWSLETTER_MANAGER",WonderWp\Plugin\Newsletter\Child\NewsletterThemeManager::class);
//define("WWP_PLUGIN_NEWSROOM_MANAGER",WonderWp\Plugin\NewsRoom\Child\NewsRoomThemeManager::class);
//define("WWP_PLUGIN_PARCOURS_MANAGER",WonderWp\Plugin\Parcours\Child\ParcoursThemeManager::class);
//define("WWP_PLUGIN_PARTENAIRE_MANAGER",WonderWp\Plugin\Partenaires\Child\PartenaireThemeManager::class);
//define("WWP_PLUGIN_RGPD_MANAGER",WonderWp\Plugin\RGPD\Child\RgpdThemeManager::class);
//define("WWP_PLUGIN_SEARCH_MANAGER",WonderWp\Plugin\Search\Child\SearchThemeManager::class);
//define("WWP_PLUGIN_SOCIAL_MANAGER",WonderWp\Plugin\Social\Child\SocialThemeManager::class);
//define("WWP_PLUGIN_STATS_MANAGER",WonderWp\Plugin\Stats\Child\StatsThemeManager::class);
//define("WWP_PLUGIN_TRACKER_MANAGER",WonderWp\Plugin\Tracker\Child\TrackerThemeManager::class);
//define("WWP_PLUGIN_TROMBI_MANAGER",WonderWp\Plugin\Trombinoscope\Child\TrombiThemeManager::class);
//define("WWP_PLUGIN_DOWNLOAD_MANAGER",WonderWp\Plugin\Download\Child\DownloadThemeManager::class);
//define("WWP_PLUGIN_VIDEO_MANAGER",WonderWp\Plugin\Video\Child\VideoThemeManager::class);
//define("WWP_PLUGIN_VOTE_MANAGER",WonderWp\Plugin\Vote\Child\VoteThemeManager::class);
//define("WWP_PLUGIN_ALERTE_MANAGER",WonderWp\Plugin\Alerte\Child\AlerteThemeManager::class);
