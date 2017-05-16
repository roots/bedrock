<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 26/08/2016
 * Time: 12:04
 */

namespace WonderWp\Theme\Child;

use WonderWp\Framework\AbstractPlugin\AbstractManager;
use WonderWp\Framework\DependencyInjection\Container;
use WonderWp\Framework\Service\ServiceInterface;
use WonderWp\Theme\Child\Service\ChildThemeHookService;
use WonderWp\Theme\Child\Service\ChildThemeShortcodeService;
use WonderWp\Theme\Child\Service\ThemeAssetService;
use WonderWp\Theme\Child\Service\ThemeRouteService;
use WonderWp\Theme\Core\ThemeManager;

class ChildThemeManager extends ThemeManager
{

    public function register(Container $container)
    {
        parent::register($container);

        //Controllers
        $this->addController(AbstractManager::PUBLIC_CONTROLLER_TYPE,function(){
           return new ThemePublicController();
        });

        //Hooks
        $this->addService(ServiceInterface::HOOK_SERVICE_NAME,function(){
            return new ChildThemeHookService();
        });
        //Routes
        $this->addService(ServiceInterface::ROUTE_SERVICE_NAME,function(){
            return new ThemeRouteService();
        });
        //Assets
        $this->addService(ServiceInterface::ASSETS_SERVICE_NAME,function(){
            return new ThemeAssetService();
        });
        //Shortcodes
        $this->addService(ServiceInterface::SHORT_CODE_SERVICE_NAME,function(){
            return new ChildThemeShortcodeService();
        });

    }

}
