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

    <!-- <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
    <link rel="manifest" href="/favicons/manifest.json">
    <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/favicons/favicon.ico">
    <meta name="msapplication-config" content="/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">--> <!--TODO : Generate favicons here : https://realfavicongenerator.net-->

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

    <script>
        var domElt = window.document.documentElement;
        if (domElt.classList.contains('no-js')) {
            // The box that we clicked has a class of bad so let's remove it and add the good class
            domElt.classList.remove('no-js');
        }
        domElt.className += ' js-enabled';
    </script>

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
    <div class="skip-links"><a href="#content"><?php _e('Skip to content', 'wonderwp'); ?></a></div>

    <header id="header">

        <div class="inner-header">

            <button class="wdf-burger nav-button" data-menu-toggler type="button" role="button" aria-label="open/close navigation"><i></i></button>

            <?php
            echo '<a href="/" class="logo">
                <!--<img src="/app/themes/wwp_child_theme/assets/raw/svg/logo.svg" alt="Mon site - accueil">--> LOGO
              </a>'
            ?>

            <div class="navigation-wrapper">

                <ul id="menu">
                    <?php
                    /** @var \WonderWp\Theme\Core\Service\ThemeViewService $viewService */
                    $viewService = wwp_get_theme_service('view');
                    $exclude     = [];
                    echo $viewService->getMainMenu($exclude);
                    ?>
                </ul>

            </div>

            <?php
            /** @var \WonderWp\Theme\Core\Service\ThemeViewService $themeViewService */
            $themeViewService = wwp_get_theme_service('view');
            echo $langSwitcher = $themeViewService->getLangSwitcher(null, false, true);
            ?>

        </div>
    </header>

    <div id="content" class="site-content">
