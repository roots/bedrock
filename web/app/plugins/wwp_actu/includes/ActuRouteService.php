<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 17/06/2016
 * Time: 09:46
 */
namespace WonderWp\Plugin\Actu;

use WonderWp\APlugin\AbstractManager;
use WonderWp\APlugin\AbstractRouter;
use WonderWp\DI\Container;
use WonderWp\Route\RouteServiceInterface;

class ActuRouteService implements RouteServiceInterface{

    private $_routes;

    public function getRoutes(){
        if(empty($this->_routes)) {
            $manager = Container::getInstance()->offsetGet('wonderwp_actu.Manager');
            $this->_routes = array(
                ['actualites',array($manager->getController(AbstractManager::$PUBLICCONTROLLERTYPE),'listActus')]
            );
        }

        return $this->_routes;
    }

}