<?php
/**
 * Advanced domain mapping feature based upon domain_mapping plugin.
 * (couldn't stand warnings and notices and overhead if it can be solved easily)
 */

if (!defined('SUNRISE_LOADED')) {
    define('SUNRISE_LOADED', 1);
}

if (defined('COOKIE_DOMAIN')) {
    die('The constant "COOKIE_DOMAIN" is defined (probably in wp-config.php). Please remove or comment out that define() line.');
}

if (!isset($wpdb) || !($wpdb instanceof wpdb)) {
    die('Unauthorised call to sunrise script.');
}
// let the site admin page catch the VHOST == 'no'
// TODO verify security and report upstream
$dm_domain = $_SERVER['HTTP_HOST'];

if(strpos($dm_domain, 'www.') === 0) {
    $where = $wpdb->prepare('domain IN (%s,%s)', $dm_domain, substr($dm_domain, 4));
} else {
    $where = $wpdb->prepare('domain = %s', $dm_domain);
}

$wpdb->suppress_errors();
// -TODO refactor sql sort
// -TODO domain_mapping sets blog_id to with additional WHERE-clause:
// "path='/'" but resets path to / anyway and keeps anything else from first result
$current_blog = $wpdb->get_row(
    "SELECT * FROM {$wpdb->blogs} WHERE {$where} ORDER BY CHAR_LENGTH(domain) DESC LIMIT 1"
);
$wpdb->suppress_errors(false);

if($current_blog) {
    $current_blog->domain = $_SERVER['HTTP_HOST'];
    $current_blog->path = '/';
    $blog_id = (int) $current_blog->blog_id;
    $site_id = (int) $current_blog->site_id;

    define('COOKIE_DOMAIN', $_SERVER['HTTP_HOST']);

    $current_site = $wpdb->get_row("SELECT * FROM {$wpdb->site} WHERE id = '{$site_id}' LIMIT 0,1");
    $current_site->blog_id = $blog_id;
    if(function_exists('get_current_site_name')) {
        $current_site = get_current_site_name($current_site);
    }

    define( 'DOMAIN_MAPPING', 1 );
}
unset($dm_domain);
