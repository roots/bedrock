<?php

namespace WonderWp\Plugin\Trombinoscope\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Trombinoscope\TrombiManager;

class TrombiThemeManager extends TrombiManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}