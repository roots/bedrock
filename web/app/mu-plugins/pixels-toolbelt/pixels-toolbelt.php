<?php
/*
Plugin Name:  Pixels Toolbelt
Plugin URI:   https://github.com/pixelshelsinki/pixels-toolbelt
Description:  A number of minor modifications for Pixels projects.
Version:      1.0.0
Author:       Pixels Helsinki Oy
Author URI:   https://pixels.fi/
License:      MIT License
*/

namespace PixelsToolbelt;

/**
 * Add SVG to allowed mimetypes.
 *
 * @param  array $mimes  Allowed mimetypes.
 * @return array         Newly allowed mimetypes.
 */
function allow_svg_upload($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}

add_filter('upload_mimes', __NAMESPACE__ . '\\allow_svg_upload');

/**
 * Move the Yoast SEO box to the bottom of the edit screen.
 * @return string The metabox priority.
 */
function move_yoast_to_bottom() {
  return 'low';
}

add_filter( 'wpseo_metabox_prio', __NAMESPACE__ . '\\move_yoast_to_bottom');
