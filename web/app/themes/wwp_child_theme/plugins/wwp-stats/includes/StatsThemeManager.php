<?php

namespace WonderWp\Plugin\Stats\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Stats\StatsManager;

class StatsThemeManager extends StatsManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}