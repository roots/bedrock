<?php

namespace WonderWp\Plugin\Video\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Video\VideoManager;

class VideoThemeManager extends VideoManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}