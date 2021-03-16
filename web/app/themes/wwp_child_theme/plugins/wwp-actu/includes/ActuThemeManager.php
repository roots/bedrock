<?php

namespace WonderWp\Plugin\Actu\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Component\Service\ServiceInterface;
use WonderWp\Plugin\Actu\ActuManager;
use WonderWp\Plugin\Actu\Child\Service\ActuThemeHookService;

class ActuThemeManager extends ActuManager
{
    public function register(Container $container)
    {
        $this->setConfig('list.cesureLength', 100);

        parent::register($container);

        return $this;
    }
}
