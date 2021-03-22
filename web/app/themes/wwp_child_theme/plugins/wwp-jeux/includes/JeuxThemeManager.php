<?php

namespace WonderWp\Plugin\Jeux\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Jeux\JeuxManager;

class JeuxThemeManager extends JeuxManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}