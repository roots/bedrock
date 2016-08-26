<?php

namespace WonderWp\Plugin\Actu;

use WonderWp\Assets\AbstractAssetService;
use WonderWp\Assets\AssetManager;
use WonderWp\DI\Container;

class ActuAssetService extends AbstractAssetService{

    public function registerAssets(AssetManager $assetManager, $assetClass){
        
        $container = Container::getInstance();
        $manager = $container->offsetGet('wonderwp_actu.Manager');
        $pluginPath = $manager->getConfig('path.url');

        //CSS
        $assetManager->registerAsset('css', new $assetClass('actu',$pluginPath.'/assets/actu.scss',array(),null,false));

    }

}