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
                    new $assetClass('styleguide',$themePath.'/styleguide/scss/main.scss'),
                    new $assetClass('theme',$themePath.'/assets/raw/scss/theme.scss',array('styleguide'))
                ),
                'js'=>array(
                    new $assetClass('jquery',$themePath.'/assets/raw/js/jquery-2.2.3.min.js'),
                    new $assetClass('app',$themePath.'/assets/raw/js/app.js',array('jquery')),
                    new $assetClass('styleguide',$themePath.'/styleguide/js/styleguide.js',array('jquery')),
                    new $assetClass('page',$themePath.'/assets/raw/js/page.js',array('jquery','app')),
                    new $assetClass('theme',$themePath.'/assets/raw/js/theme.js',array('page'))
                )
            );
        }
        return $this->_assets;
    }
}