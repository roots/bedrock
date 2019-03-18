<?php

namespace WonderWp\Plugin\Newsletter\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Newsletter\NewsletterManager;

class NewsletterThemeManager extends NewsletterManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}