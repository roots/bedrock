<?php

namespace WonderWp\Plugin\GutenbergUtils\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\GutenbergUtils\Component\TestMolecule;
use WonderWp\Plugin\GutenbergUtils\GutenbergUtilsManager;
use WonderWp\Theme\Child\Components\Card\CardComponent;
use WonderWp\Theme\Child\Components\Dropdown\DropdownComponent;
use WonderWp\Theme\Child\Components\GutenbergCardComponent\CardGutenbergComponent;
use WonderWp\Theme\Child\Components\Video\VideoComponent;
use WonderWp\Theme\Child\Components\VideoEmbed\VideoEmbedComponent;

class GutenbergUtilsThemeManager extends GutenbergUtilsManager
{
    public function register(Container $container)
    {

        $this->setConfig('moleculesToRegister', [
            VideoComponent::class,
            VideoEmbedComponent::class,
            DropdownComponent::class,
            CardGutenbergComponent::class,
            TestMolecule::class
        ]);

        parent::register ($container);

        return $this;
    }
}
