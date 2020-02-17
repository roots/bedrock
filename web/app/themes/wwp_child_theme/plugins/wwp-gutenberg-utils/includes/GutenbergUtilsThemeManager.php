<?php

namespace WonderWp\Plugin\GutenbergUtils\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\GutenbergUtils\GutenbergUtilsManager;
use WonderWp\Theme\Child\Components\Video\VideoComponent;
use WonderWp\Theme\Child\Components\VideoEmbed\VideoEmbedComponent;

class GutenbergUtilsThemeManager extends GutenbergUtilsManager
{
    public function register(Container $container)
    {

        $this->setConfig('moleculesToRegister', [
            VideoComponent::class,
            VideoEmbedComponent::class,
        ]);

        parent::register ($container);

        return $this;
    }
}
