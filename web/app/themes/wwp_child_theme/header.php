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
        Header
        <?php _e('trad.welcome', WWP_THEME_TEXTDOMAIN); ?>
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

        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" aria-haspopup="true" aria-expanded="false">
                Dropdown button
                <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                <li role="presentation"><a role="menuitem" href="#">Action</a></li>
                <li role="presentation"><a role="menuitem" href="#">Another action</a></li>
                <li role="presentation"><a class="dropdown-item" href="#">Something else here</a></li>
                <li role="presentation" class="divider"></li>
                <li role="presentation"><a role="menuitem" href="#">About Us</a></li>
            </ul>
        </div>
