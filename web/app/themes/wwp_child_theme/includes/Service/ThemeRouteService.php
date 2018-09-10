<?php

namespace WonderWp\Theme\Child\Service;

use WonderWp\Component\PluginSkeleton\AbstractManager;
use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Component\Routing\Route\AbstractRouteService;

class ThemeRouteService extends AbstractRouteService
{

    public function getRoutes()
    {
        if (empty($this->_routes)) {
            $manager       = $this->manager;
            $this->_routes = [
                ['styleguide', [$manager->getController(AbstractManager::PUBLIC_CONTROLLER_TYPE), 'styleGuide']],
                ['sitemap', [$manager->getController(AbstractManager::PUBLIC_CONTROLLER_TYPE), 'sitemap']],
            ];
        }

        return $this->_routes;
    }

}
