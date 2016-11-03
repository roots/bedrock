<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 15:40
 */

namespace WonderWp\Plugin\EspaceRestreint;


use WonderWp\APlugin\AbstractManager;
use WonderWp\DI\Container;
use WonderWp\Route\AbstractRouteService;

class ErRouteService extends AbstractRouteService
{
    public function getRoutes(){
        if(empty($this->_routes)) {
            $manager = Container::getInstance()->offsetGet('wwp-espace-restreint.Manager');

            $this->_routes = array();

            //Login
            $this->_expandRoutes($manager,'login_url','loginAction');
            $this->_expandRoutes($manager,'register_url','registerAction');
            $this->_expandRoutes($manager,'forgotpwd_url','forgetPasswordAction');
            $this->_expandRoutes($manager,'resetpwd_url','resetPasswordAction');
            $this->_expandRoutes($manager,'logout_url','logoutAction');

        }

        return $this->_routes;
    }

    private function _expandRoutes($manager,$type,$action){
        if(is_array($manager->getConfig($type))){
            foreach($manager->getConfig($type) as $typeUrl){
                $this->_routes[] = [ltrim($typeUrl,'/'),array($manager->getController(AbstractManager::$PUBLICCONTROLLERTYPE),$action)];
            }
        } else {
            $this->_routes[] = [ltrim($manager->getConfig($type),'/'),array($manager->getController(AbstractManager::$PUBLICCONTROLLERTYPE),$action)];
        }
    }
}