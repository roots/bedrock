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

class ThemeRouter extends AbstractRouter{

    private $_routes;

    public function getRoutes(){
        if(empty($this->_routes)) {
            $manager = Container::getInstance()->offsetGet('wwp.theme.Manager');
            $this->_routes = array(
                ['styleguide/*',array($manager->getController(AbstractManager::$PUBLICCONTROLLERTYPE),'styleGuide')]
            );
        }

        return $this->_routes;
    }

}