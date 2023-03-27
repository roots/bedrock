<?php

namespace WonderWp\Plugin\Alerte\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Alerte\AlerteManager;

class AlerteThemeManager extends AlerteManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}