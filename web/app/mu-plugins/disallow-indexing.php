<?php
/*
Plugin Name:  Disallow Indexing
Plugin URI:   https://roots.io/bedrock/
Description:  Disallow indexing of your site on non-production environments.
Version:      1.0.0
Author:       Roots
Author URI:   https://roots.io/
License:      MIT License
*/

if (defined('DISALLOW_INDEXING') && DISALLOW_INDEXING && !is_admin()) {
    add_action('pre_option_blog_public', '__return_zero');
}

function disallow_indexing_notice() {
    echo '<div class="error">
            <p>This site is set to disallow indexing. It will not show up in search engines!</p>
        </div>';
}
add_action('admin_notices', 'disallow_indexing_notice');
