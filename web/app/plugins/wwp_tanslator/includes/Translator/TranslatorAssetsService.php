<?php

namespace WonderWp\Plugin\Translator;

use WonderWp\Assets\AbstractAssetService;
use WonderWp\Assets\AssetManager;
use WonderWp\DI\Container;

class TranslatorAssetsService extends AbstractAssetService{

    public function getAssets()
    {
        if(empty($this->_assets)) {
            $container = Container::getInstance();
            $manager = $container->offsetGet('wonderwp_translator.Manager');
            $pluginPath = $manager->getConfig('path.url');
            $assetClass = $container->offsetGet('wwp.assets.assetClass');

            $this->_assets = array(
                'css' => array(
                    new $assetClass('translator-admin',$pluginPath.'/admin/assets/translator-admin.scss',array(),null,false,AbstractAssetService::$ADMINASSETSGROUP)
                ),
                'js'=>array(
                    new $assetClass('translator-admin',$pluginPath.'/admin/assets/translator-admin.js',array('wwp-admin'),null,false,AbstractAssetService::$ADMINASSETSGROUP)
                )
            );
        }
        return $this->_assets;
    }

}