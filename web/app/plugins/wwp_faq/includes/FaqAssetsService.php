<?php

namespace WonderWp\Plugin\Faq;

use WonderWp\Assets\AbstractAssetService;
use WonderWp\Assets\AssetManager;
use WonderWp\DI\Container;

class FaqAssetsService extends AbstractAssetService{

    public function registerAssets(AssetManager $assetManager, $assetClass){
        
        $container = Container::getInstance();
        $manager = $container->offsetGet('wonderwp_faq.Manager');
        $pluginPath = $manager->getConfig('path.url');

        //CSS
        $assetManager->registerAsset('css', new $assetClass('faq',$pluginPath.'/assets/faq.scss',array(),null,false));

    }

}