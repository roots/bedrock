<?php

namespace WonderWp\Plugin\Actu;

use WonderWp\Assets\AbstractAssetService;
use WonderWp\Assets\AssetManager;
use WonderWp\DI\Container;

class ActuAssetService extends AbstractAssetService{

    public function registerAssets(AssetManager $assetManager, $assetClass){
        
        $container = Container::getInstance();
        $pluginPath = $container['wonderwp_actu.path.url'];

        //CSS
        $assetManager->registerAsset('css', new $assetClass('actu',$pluginPath.'/assets/actu.scss',array(),null,false));

    }

}