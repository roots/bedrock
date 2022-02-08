<?php

namespace WonderWp\Plugin\Partenaires\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Partenaires\PartenaireManager;

class PartenaireThemeManager extends PartenaireManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}