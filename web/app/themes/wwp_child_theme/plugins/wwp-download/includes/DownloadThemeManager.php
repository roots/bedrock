<?php

namespace WonderWp\Plugin\Download\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Download\DownloadManager;

class DownloadThemeManager extends DownloadManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}