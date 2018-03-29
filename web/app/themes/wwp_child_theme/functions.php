<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 26/08/2016
 * Time: 11:08
 */
function wwp_theme_setup()
{
    $request = \WonderWp\Framework\HttpFoundation\Request::getInstance();
    if(!$request->getSession()->isStarted() && session_status() === PHP_SESSION_NONE) {
        $request->getSession()->start();
    }
    get_template_part('/includes/ThemeManager');
    get_template_part('/includes/ChildThemeManager');
    $setupManager = new WonderWp\Theme\Child\ChildThemeManager();
    $setupManager->run();
}

function getSvgIcon($iconName)
{
    return \WonderWp\Theme\Child\Service\ChildThemeShortcodeService::getSvgIcon($iconName);
}
