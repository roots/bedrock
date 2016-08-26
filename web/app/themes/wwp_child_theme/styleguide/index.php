<?php
if(!defined('WP_USE_THEMES')){ define('WP_USE_THEMES', false); }
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp/wp-blog-header.php' );
get_template_part('header'); ?>

<iframe src="<?php echo get_stylesheet_directory_uri(); ?>/styleguide/atomic-core/index.php" width="100%" height="100%" style="min-height: 1024px;"></iframe>

<?php get_template_part('footer');