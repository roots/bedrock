<?php

namespace WonderWp\Plugin\EspaceRestreint\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\EspaceRestreint\ErManager;

class ErThemeManager extends ErManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}