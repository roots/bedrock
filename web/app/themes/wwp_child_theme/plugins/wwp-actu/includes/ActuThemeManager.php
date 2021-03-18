<?php

namespace WonderWp\Plugin\Actu\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Actu\ActuManager;

class ActuThemeManager extends ActuManager
{
    public function register(Container $container)
    {
        $this->setConfig('list.cesureLength', 100);

        parent::register($container);

        return $this;
    }
}
