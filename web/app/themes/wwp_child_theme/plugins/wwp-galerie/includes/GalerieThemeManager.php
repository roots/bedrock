<?php

namespace WonderWp\Plugin\Galerie\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Galerie\GalerieManager;

class GalerieThemeManager extends GalerieManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}