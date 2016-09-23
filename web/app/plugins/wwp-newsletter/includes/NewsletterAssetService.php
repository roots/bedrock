<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 06/09/2016
 * Time: 18:59
 */

namespace WonderWp\Plugin\Newsletter;

use WonderWp\Assets\AbstractAssetService;
use WonderWp\Assets\AssetManager;
use WonderWp\DI\Container;

class NewsletterAssetService extends AbstractAssetService{

    public function getAssets()
    {
        if(empty($this->_assets)) {
            $container = Container::getInstance();
            $manager = $container->offsetGet('wwp-newsletter.Manager');
            $pluginPath = $manager->getConfig('path.url');
            $assetClass = $container->offsetGet('wwp.assets.assetClass');

            $this->_assets = array(
                'css' => array(
                    new $assetClass('wwp-newsletter', $pluginPath . '/public/css/newsletter.scss', array('styleguide'))
                ),
                'js' => array(
                    new $assetClass('wwp-newsletter', $pluginPath . '/public/js/newsletter.js',array('app','styleguide'))
                )
            );
        }
        return $this->_assets;
    }

}