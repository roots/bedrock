<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 26/08/2016
 * Time: 12:04
 */

namespace WonderWp\Theme;

use Pimple\Container as PContainer;
use WonderWp\APlugin\AbstractManager;
use WonderWp\Services\AbstractService;
use \Composer\Autoload\ClassLoader as AutoLoader;

class ChildThemeManager extends ThemeManager
{

    public function autoLoad(AutoLoader $loader)
    {
        parent::autoLoad($loader);

        $loader->addPsr4('WonderWp\\Theme\\Components\\', array(STYLESHEETPATH . '/styleguide/components/components/componentsClasses', TEMPLATEPATH . '/includes'));

        return $this;
    }

    public function register(PContainer $container)
    {
        parent::register($container);
        //Hooks
        $this->addService(AbstractService::$HOOKSERVICENAME,function(){
            return new ChildThemeHookService();
        });
        //Routes
        $this->addService(AbstractService::$ROUTESERVICENAME,function(){
            return new ThemeRouteService();
        });
        //Assets
        $this->addService(AbstractService::$ASSETSSERVICENAME,function(){
            return new ThemeAssetService();
        });
        //Shortcodes
        $this->addService(AbstractService::$SHORTCODESERVICENAME,function(){
            return new ThemeShortcodeService();
        });
    }

}