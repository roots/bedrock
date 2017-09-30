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

/**
 * Produces cleaner filenames for uploads
 *
 * @param  string $filename
 * @return string
 */
function wpartisan_sanitize_file_name( $filename ) {

    $sanitized_filename = remove_accents( $filename ); // Convert to ASCII

    // Standard replacements
    $invalid = array(
        ' '   => '-',
        '%20' => '-',
        '_'   => '-',
    );
    $sanitized_filename = str_replace( array_keys( $invalid ), array_values( $invalid ), $sanitized_filename );

    $sanitized_filename = preg_replace('/[^A-Za-z0-9-\. ]/', '', $sanitized_filename); // Remove all non-alphanumeric except .
    $sanitized_filename = preg_replace('/\.(?=.*\.)/', '', $sanitized_filename); // Remove all but last .
    $sanitized_filename = preg_replace('/-+/', '-', $sanitized_filename); // Replace any more than one - in a row
    $sanitized_filename = str_replace('-.', '.', $sanitized_filename); // Remove last - if at the end
    $sanitized_filename = strtolower( $sanitized_filename ); // Lowercase

    return $sanitized_filename;
}

add_filter( 'sanitize_file_name', 'wpartisan_sanitize_file_name', 10, 1 );
