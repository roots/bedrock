<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 17/06/2016
 * Time: 09:46
 */
namespace WonderWp\Theme\Child;

use WonderWp\Framework\AbstractPlugin\AbstractManager;
use WonderWp\Framework\DependencyInjection\Container;
use WonderWp\Framework\Route\AbstractRouteService;

class ThemeRouteService extends AbstractRouteService
{

    public function getRoutes()
    {
        if (empty($this->_routes)) {
            $manager       = Container::getInstance()->offsetGet('wwp.theme.Manager');
            $this->_routes = [
                ['styleguide', [$manager->getController(AbstractManager::PUBLIC_CONTROLLER_TYPE), 'styleGuide']],
                ['sitemap', [$manager->getController(AbstractManager::PUBLIC_CONTROLLER_TYPE), 'sitemap']],
            ];
        }

        return $this->_routes;
    }

}
