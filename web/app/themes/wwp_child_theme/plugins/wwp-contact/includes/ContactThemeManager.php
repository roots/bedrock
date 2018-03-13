<?php

namespace WonderWp\Plugin\Contact\Child;

use WonderWp\Framework\DependencyInjection\Container;
use WonderWp\Plugin\Contact\ContactManager;

class ContactThemeManager extends ContactManager
{
    public function register(Container $container)
    {
        parent::register ($container);

        return $this;
    }
}