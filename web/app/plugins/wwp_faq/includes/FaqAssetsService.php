<?php

namespace WonderWp\Plugin\Faq;

use WonderWp\Assets\AssetsManager;
use WonderWp\DI\Container;

class FaqAssetsService{

    public function registerAssets(AssetsManager $assetsManager, $assetClass){
        
        $container = Container::getInstance();
        $pluginPath = $container['wonderwp_faq.path.url'];

        //CSS
        $assetsManager->registerAsset('css', new $assetClass('faq',$pluginPath.'/assets/faq.scss',array(),null,false,ASSETS_GROUP_APP));

    }

}