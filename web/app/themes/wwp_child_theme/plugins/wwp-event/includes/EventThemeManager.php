<?php

namespace WonderWp\Plugin\Event\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Event\EventManager;

class EventThemeManager extends EventManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}