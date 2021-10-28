<?php

namespace WonderWp\Plugin\Actu\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Actu\ActuManager;

class ActuThemeManager extends ActuManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}