<?php

/**
 * Plugin Name:  Bedrock Autoloader
 * Plugin URI:   https://github.com/roots/bedrock-autoloader
 * Description:  An autoloader that enables standard plugins to be required just like must-use plugins. The autoloaded plugins are included during mu-plugin loading. An asterisk (*) next to the name of the plugin designates the plugins that have been autoloaded.
 * Author:       Roots
 * Author URI:   https://roots.io/
 * License:      MIT License
 */

namespace Roots\Bedrock;

if (is_blog_installed() && class_exists(Autoloader::class)) {
    new Autoloader();
}
