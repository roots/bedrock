<?php

namespace WonderWp\Plugin\Tracker\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Tracker\TrackerManager;

class TrackerThemeManager extends TrackerManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}