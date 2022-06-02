<?php

namespace WonderWp\Plugin\Parcours\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Parcours\ParcoursManager;

class ParcoursThemeManager extends ParcoursManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}