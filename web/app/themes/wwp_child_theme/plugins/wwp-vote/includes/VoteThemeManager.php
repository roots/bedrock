<?php

namespace WonderWp\Plugin\Vote\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\Vote\VoteManager;

class VoteThemeManager extends VoteManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}