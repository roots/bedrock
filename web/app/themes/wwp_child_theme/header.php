<?php if (!\WonderWp\Functions\isAjax()): ?>
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

    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
    <link rel="manifest" href="/favicons/site.webmanifest">
    <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <title><?php
        /*
         * Print the <title> tag based on what is being viewed.
         */
        global $page, $paged;

        $pageTitle = stripslashes(wp_title('|', false, 'right'));
        $pageTitle = str_replace(['|'], [' '], $pageTitle);
        if (!empty($pageTitle)) {
            echo $pageTitle . ' | ';
        }

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
        window.document.documentElement.className += ' js-enabled';
        window.document.documentElement.classList.remove('no-js');
        var criticalJsReadyFn = function () {
            window.wonderwp.FeatureDetector.runTests();
        }
        if (window.criticalJsReady) {
            criticalJsReadyFn();
        } else {
            document.addEventListener('criticalJsReady', function () {
                criticalJsReadyFn();
            });
        }

    </script>

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
    <div class="skip-links"><a href="#content"><?php echo trad('Skip to content', WWP_THEME_TEXTDOMAIN); ?></a></div>

    <?php echo apply_filters('wwp_before_header', ''); ?>

    <header class="site-header" id="header" role="banner">

        <div class="inner-header">

            <button class="wdf-burger nav-button" data-menu-toggler type="button" aria-label="open/close navigation"><i></i></button>

            <?php
            echo '<a href="/" class="logo" aria-label="' . trad('back.to.home', WWP_THEME_TEXTDOMAIN) . '"><img src="' . apply_filters('wwp-header-logo', '/app/themes/wwp_child_theme/assets/raw/images/logo-site.svg') . '" alt="Mon site - accueil" height="=44" width="200"></a>'
            ?>

            <nav role="navigation" aria-label="<?php echo trad('main.menu', WWP_THEME_TEXTDOMAIN); ?>" class="<?php echo apply_filters('wwp-main-nav-class', 'navigation-wrapper'); ?>">

                <ul class="header-menu" id="menu">
                    <?php
                    /** @var \WonderWp\Theme\Core\Service\ThemeViewService $viewService */
                    $viewService = wwp_get_theme_service('view');
                    $exclude     = [];
                    echo $viewService->getMainMenu($exclude);
                    ?>
                </ul>

            </nav>

            <?php
            /** @var \WonderWp\Theme\Core\Service\ThemeViewService $themeViewService */
            $themeViewService = wwp_get_theme_service('view');
            echo $langSwitcher = $themeViewService->getLangSwitcher(
                __DIR__ . '/plugins/wwp-translator/public/views/LangSwitcher.php',
                false,
                true
            );
            ?>

        </div>
    </header>
    <?php echo apply_filters('wwp_after_header', ''); ?>
    <?php endif; /* isAjax */ ?>
    <div id="content" class="site-content transitionning">
        <?php echo apply_filters('wwp_prepend_content', ''); ?>
