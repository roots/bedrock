<?php

// Bedrock will load paths relative to this script make sure we're in the same directory
chdir(__DIR__);

// WordPress view bootstrapper
define('WP_USE_THEMES', true);
require(__DIR__ . '/wp/wp-blog-header.php');
