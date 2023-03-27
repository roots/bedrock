<?php

namespace WonderWp\Plugin\GutenbergUtils\Child;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Plugin\GutenbergUtils\Bloc\AccordionBlock\AccordionBlock;
use WonderWp\Plugin\GutenbergUtils\Bloc\AccordionBlock\AccordionPaneBlock;
use WonderWp\Plugin\GutenbergUtils\GutenbergUtilsManager;
use WonderWp\Theme\Child\Components\Button\ButtonComponent;
use WonderWp\Theme\Child\Components\Card\CardComponent;
use WonderWp\Theme\Child\Components\ChiffreCle\ChiffreCleComponent;
use WonderWp\Theme\Child\Components\Citation\CitationComponent;
use WonderWp\Theme\Child\Components\Dropdown\DropdownComponent;
use WonderWp\Theme\Child\Components\Hero\HeroComponent;
use WonderWp\Theme\Child\Components\ToggleContentViaFilter\TcvfItemComponent;
use WonderWp\Theme\Child\Components\VideoEmbed\VideoEmbedComponent;
use WonderWp\Theme\Child\Components\VideoModale\VideoModaleComponent;

class GutenbergUtilsThemeManager extends GutenbergUtilsManager
{
    public function register(Container $container)
    {

        $this->setConfig('blocksToRegister',[
            AccordionBlock::class,
            AccordionPaneBlock::class
        ]);

        $this->setConfig('moleculesToRegister',[
            CardComponent::class,
            ButtonComponent::class,
            CitationComponent::class,
            ChiffreCleComponent::class,
            VideoEmbedComponent::class,
            VideoModaleComponent::class,
            DropdownComponent::class,
            HeroComponent::class,
            TcvfItemComponent::class
        ]);

        parent::register ($container);

        return $this;
    }
}
