<?php

/**
 * Plugin Name:  Disable status tests
 * Plugin URI:   https://github.com/roots/bedrock/
 * Description:  Disable two status tests that conflict with the way Bedrock is intended.
 * Version:      1.0.0
 * Author:       Roots
 * Author URI:   https://roots.io/
 * License:      MIT License
 */

namespace Roots\Bedrock;

add_filter('site_status_tests', __NAMESPACE__ . '\\disable_status_tests');

/**
 * Disable WordPress Health Status tests
 * 
 * Disables tests that currently conflict with the way WordPress is intened.
 *
 * @param array $tests
 * @return void
 */
function disable_status_tests($tests)
{
   unset($tests['direct']['theme_version']); // disable theme update, theme inactive and default theme checks.
   unset($tests['async']['background_updates']); // disabled the background updates check.
   return $tests;
}
