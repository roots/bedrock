<?php

namespace WonderWp\Plugin\Search\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Search\SearchManager;

class SearchThemeManager extends SearchManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}