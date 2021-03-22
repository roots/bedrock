<?php

namespace WonderWp\Plugin\Meteo\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Meteo\MeteoManager;

class MeteoThemeManager extends MeteoManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}