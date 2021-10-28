<?php

namespace WonderWp\Plugin\Faq\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Faq\FaqManager;

class FaqThemeManager extends FaqManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}