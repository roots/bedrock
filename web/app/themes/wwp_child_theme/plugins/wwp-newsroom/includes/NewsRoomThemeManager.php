<?php

namespace WonderWp\Plugin\NewsRoom\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\NewsRoom\NewsRoomManager;

class NewsRoomThemeManager extends NewsRoomManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}