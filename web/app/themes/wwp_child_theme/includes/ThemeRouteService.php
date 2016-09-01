<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 17/06/2016
 * Time: 09:46
 */
namespace WonderWp\Theme;

use WonderWp\APlugin\AbstractManager;
use WonderWp\APlugin\AbstractRouter;
use WonderWp\DI\Container;
use WonderWp\Route\AbstractRouteService;
use WonderWp\Route\RouteServiceInterface;

class ThemeRouteService extends AbstractRouteService{

    public function getRoutes(){
        if(empty($this->_routes)) {
            $manager = Container::getInstance()->offsetGet('wwp.theme.Manager');
            $this->_routes = array(
                ['styleguide',array($manager->getController(AbstractManager::$PUBLICCONTROLLERTYPE),'styleGuide')],
                ['sitemap',array($manager->getController(AbstractManager::$PUBLICCONTROLLERTYPE),'sitemap')]
            );
        }

        return $this->_routes;
    }

}