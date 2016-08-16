<?php

namespace WonderWp\Plugin\Actu;

use WonderWp\Assets\AssetsManager;
use WonderWp\DI\Container;

class ActuAssetsService{

    public function registerAssets(AssetsManager $assetsManager, $assetClass){
        
        $container = Container::getInstance();
        $pluginPath = $container['wonderwp_actu.path.url'];

        //CSS
        $assetsManager->registerAsset('css', new $assetClass('actu',$pluginPath.'/assets/actu.scss',array(),null,false,ASSETS_GROUP_APP));

    }

}