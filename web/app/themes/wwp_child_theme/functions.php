<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 26/08/2016
 * Time: 11:08
 */
function wwp_theme_setup() {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); //Needed to use is_plugin_active according to the codex
    $wwpplugin = 'wonderwp_plugin/wonderwp.php';
    if(is_plugin_active($wwpplugin)) {
        get_template_part('/includes/ThemeManager');
        get_template_part('/includes/ChildThemeManager');
        $setupManager = new WonderWp\Theme\ChildThemeManager();
        $setupManager->run();
    } else {
        echo "<div class='update-nag'>" . __( 'This theme requires the wonderwp plugin to run ('.$wwpplugin.')' ) . "</div>";
    }
}