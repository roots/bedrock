<?php

namespace WonderWp\Theme\Child\Service;

use WonderWp\Component\Asset\AbstractAssetService;
use WonderWp\Component\Asset\Asset;
use WonderWp\Component\Asset\AssetManager;
use WonderWp\Component\DependencyInjection\Container;

class ThemeAssetService extends AbstractAssetService
{

    public function registerAssets(AssetManager $assetManager, $assetClass)
    {

        //CSS
        // TODO : Check ce que ça fait ici
        $container = Container::getInstance();
        $manager   = $container->offsetGet('wwp.theme.Manager');
        $themePath = $manager->getConfig('path.url');
       // $assetManager->registerAsset('css', new $assetClass('theme', $themePath . '/assets/raw/scss/theme.scss', [], '', false, 'core' ));

    }

    public function getAssets()
    {
        if (empty($this->_assets)) {
            $container  = Container::getInstance();
            $manager    = $container->offsetGet('wwp.theme.Manager');
            $themePath  = $manager->getConfig('path.url');
            /** @var Asset $assetClass */
            $assetClass = self::$assetClassName;

            $this->_assets = [
                'css' => [
                    new $assetClass('styleguide', $themePath . '/assets/raw/scss/theme.scss', [], '', true, 'styleguide' ),
                    new $assetClass('critical', $themePath . '/assets/raw/scss/critical.scss', [], '', true, 'critical' )
                ],
                'js' => [
                    new $assetClass('core', $themePath . '/assets/raw/js/app_bootstrap.js', [], '', true, 'core' ), // global app entry point
                    new $assetClass('styleguide', $themePath . '/assets/raw/js/app_styleguide.js', [], '', true, 'styleguide'), // global UI components loader
                    new $assetClass('bootstrap', $themePath . '/assets/raw/js/app_init.js', [], '', true, 'bootstrap'), // global plugin loader
                    new $assetClass('critical', $themePath . '/assets/raw/js/app_critical.js', [], '', true, 'critical'), // global plugin loader
                ]
            ];
        }

        return $this->_assets;
    }
}
