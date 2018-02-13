<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package    WordPress
 * @subpackage WonderWp_theme
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">

    <title><?php
        /*
         * Print the <title> tag based on what is being viewed.
         */
        global $page, $paged;

        echo stripslashes(wp_title('|', false, 'right'));

        // Add the blog name.
        echo get_bloginfo('name');

        // Add the blog description for the home/front page.
        if (is_home() || is_front_page()) {
            $site_description = get_bloginfo('description', 'display');
            if ($site_description) {
                echo " | $site_description";
            }
        }

        // Add a page number if necessary:
        if ($paged >= 2 || $page >= 2) {
            echo ' | ' . sprintf(__('Page %s', 'twentyten'), max($paged, $page));
        }

        ?></title>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
    <div class="skip-links"><a href="#content"><?php _e('Skip to content', 'wonderwp'); ?></a></div>

    <header id="header">
        <ul id="menu">
            <?php
            /** @var \WonderWp\Theme\Core\Service\ThemeViewService $viewService */
            $viewService = wwp_get_theme_service('view');
            $exclude     = [];
            echo $viewService->getMainMenu($exclude);
            ?>
        </ul>
    </header>

    <div id="content" class="site-content">
