<?php
/*
Plugin Name:  Disallow Indexing
Plugin URI:   https://roots.io/bedrock/
Description:  Disallow indexing of your site on non-production environments.
Version:      2.0.0
Author:       Roots
Author URI:   https://roots.io/
Text Domain:  roots
License:      MIT License
*/

if (!defined('WP_ENV') || WP_ENV === 'production') {
    return;
}

add_action('pre_option_blog_public', '__return_zero');

add_action('admin_notices', function () {
    $message = sprintf(
        __('%1$s Search engine indexing has been discouraged because the current environment is %2$s.', 'roots'),
        '<strong>Bedrock:</strong>',
        '<code>'.WP_ENV.'</code>'
    );
    echo "<div class='notice notice-warning'><p>{$message}</p></div>";
});
