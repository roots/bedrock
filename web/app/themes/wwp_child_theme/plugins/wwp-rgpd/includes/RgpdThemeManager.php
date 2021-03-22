<?php

namespace WonderWp\Plugin\RGPD\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\RGPD\RgpdManager;

class RgpdThemeManager extends RgpdManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}