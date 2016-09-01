<?php

namespace WonderWp\Theme;

use WonderWp\Assets\AbstractAssetService;
use WonderWp\Assets\AssetManager;
use WonderWp\DI\Container;

class ThemeAssetService extends AbstractAssetService{

    public function registerAssets(AssetManager $assetManager, $assetClass){
        $container = Container::getInstance();
        $manager = $container->offsetGet('wwp.theme.Manager');
        $themePath = $manager->getConfig('path.url');

        //CSS
        $assetManager->registerAsset('css', new $assetClass('theme',$themePath.'/assets/raw/scss/theme.scss',array(),null,false));

    }

    public function getAssets()
    {
        if(empty($this->_assets)) {
            $container = Container::getInstance();
            $manager = $container->offsetGet('wwp.theme.Manager');
            $themePath = $manager->getConfig('path.url');
            $assetClass = $container->offsetGet('wwp.assets.assetClass');

            $this->_assets = array(
                'css' => array(
                    new $assetClass('theme',$themePath.'/assets/raw/scss/theme.scss')
                )
            );
        }
        return $this->_assets;
    }
}