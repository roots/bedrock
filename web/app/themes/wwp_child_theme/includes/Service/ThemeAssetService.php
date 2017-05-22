<?php

namespace WonderWp\Theme\Child\Service;

use WonderWp\Framework\Asset\AbstractAssetService;
use WonderWp\Framework\Asset\AssetManager;
use WonderWp\Framework\DependencyInjection\Container;

class ThemeAssetService extends AbstractAssetService
{

    public function registerAssets(AssetManager $assetManager, $assetClass)
    {
        $container = Container::getInstance();
        $manager   = $container->offsetGet('wwp.theme.Manager');
        $themePath = $manager->getConfig('path.url');

        //CSS
        $assetManager->registerAsset('css', new $assetClass('theme', $themePath . '/assets/raw/scss/theme.scss', [], null, false));

    }

    public function getAssets()
    {
        if (empty($this->_assets)) {
            $container  = Container::getInstance();
            $manager    = $container->offsetGet('wwp.theme.Manager');
            $themePath  = $manager->getConfig('path.url');
            $assetClass = $container->offsetGet('wwp.assets.assetClass');

            $this->_assets = [
                'css' => [
                    new $assetClass('styleguide', $themePath . '/styleguide/scss/main.scss'),
                    new $assetClass('theme', $themePath . '/assets/raw/scss/theme.scss', ['styleguide']),
                ],
                'js'  => [
                    new $assetClass('jquery', $themePath . '/assets/raw/js/jquery-2.2.3.min.js'),
                    new $assetClass('app', $themePath . '/assets/raw/js/app.js', ['jquery']),
                    new $assetClass('styleguide', $themePath . '/styleguide/js/compiled/styleguide.js', ['jquery']),
                    new $assetClass('page', $themePath . '/assets/raw/js/page.js', ['jquery', 'app']),
                    new $assetClass('theme', $themePath . '/assets/raw/js/theme.js', ['page']),
                ],
            ];
        }

        return $this->_assets;
    }
}
