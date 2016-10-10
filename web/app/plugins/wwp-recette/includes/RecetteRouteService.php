<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 15:40
 */

namespace WonderWp\Plugin\Recette;


use WonderWp\APlugin\AbstractManager;
use WonderWp\DI\Container;
use WonderWp\Route\AbstractRouteService;

class RecetteRouteService extends AbstractRouteService
{
    public function getRoutes(){
        if(empty($this->_routes)) {
            $manager = Container::getInstance()->offsetGet('wwp-recette.Manager');
            $this->_routes = array(
                ['recette/{recetteSlug}',array($manager->getController(AbstractManager::$PUBLICCONTROLLERTYPE),'recetteAction'),'GET']
            );
        }

        return $this->_routes;
    }
}