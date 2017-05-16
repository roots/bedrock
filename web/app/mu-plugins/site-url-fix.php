<?php
/*
Plugin Name:  Site URL fix
Plugin URI:   https://roots.io/bedrock/
Description:  Remove /wp/ if the URL doesn't contain /wp-includes/ or /wp-admin/
Version:      1.0.0
Author:       Roots
Author URI:   https://roots.io/
License:      MIT License
*/

namespace Roots\Bedrock;

if (!is_blog_installed()) {
    return;
}

function site_url_fix($site_url)
{
    if (preg_match('/wp\/(?!wp-(includes|admin))/', $site_url)) {
        $site_url = str_replace('/wp', '', $site_url);
    }

    return $site_url;
}
add_filter('site_url', '\Roots\Bedrock\site_url_fix', 99);
