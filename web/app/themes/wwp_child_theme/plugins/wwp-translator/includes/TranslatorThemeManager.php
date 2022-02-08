<?php

namespace WonderWp\Plugin\Translator\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Translator\TranslatorManager;

class TranslatorThemeManager extends TranslatorManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}