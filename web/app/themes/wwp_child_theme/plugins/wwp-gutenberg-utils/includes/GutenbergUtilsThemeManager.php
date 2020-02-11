<?php

namespace WonderWp\Plugin\GutenbergUtils\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\GutenbergUtils\GutenbergUtilsManager;

class GutenbergUtilsThemeManager extends GutenbergUtilsManager
{
    public function register(Container $container)
    {

        $this->setConfig('moleculesToRegister', [

        ]);

        parent::register ($container);

        return $this;
    }
}
