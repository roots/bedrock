<?php

namespace WonderWp\Plugin\Slider\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Slider\SliderManager;

class SliderThemeManager extends SliderManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}