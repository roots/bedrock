<?php

namespace WonderWp\Plugin\Translator;

use WonderWp\Assets\AbstractAssetService;
use WonderWp\Assets\AssetManager;
use WonderWp\DI\Container;

class TranslatorAssetsService extends AbstractAssetService{

    public function registerAssets(AssetManager $assetManager, $assetClass){

        $container = Container::getInstance();
        $manager = $container->offsetGet('wonderwp_translator.Manager');
        $pluginPath = $manager->getConfig('path.url');

        //CSS Back
        $assetManager->registerAsset('css', new $assetClass('translator-admin',$pluginPath.'/admin/assets/translator-admin.scss',array(),null,false,'admin'));
        //JS Back
        $assetManager->registerAsset('js', new $assetClass('translator-admin',$pluginPath.'/admin/assets/translator-admin.js',array(),null,false,'admin'));

    }

}