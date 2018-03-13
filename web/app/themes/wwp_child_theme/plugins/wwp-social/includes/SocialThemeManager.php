<?php

namespace WonderWp\Plugin\Social\Child;

use WonderWp\Framework\DependencyInjection\Container;
use WonderWp\Plugin\Social\SocialManager;

class SocialThemeManager extends SocialManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}