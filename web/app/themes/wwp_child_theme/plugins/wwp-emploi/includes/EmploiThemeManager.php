<?php

namespace WonderWp\Plugin\Emploi\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Emploi\EmploiManager;

class EmploiThemeManager extends EmploiManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}