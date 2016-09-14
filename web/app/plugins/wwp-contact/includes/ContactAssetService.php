<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 06/09/2016
 * Time: 18:59
 */

namespace WonderWp\Plugin\Contact;

use WonderWp\Assets\AbstractAssetService;
use WonderWp\Assets\AssetManager;
use WonderWp\DI\Container;

class ContactAssetService extends AbstractAssetService{

    public function getAssets()
    {
        if(empty($this->_assets)) {
            $container = Container::getInstance();
            $manager = $container->offsetGet('wwp-contact.Manager');
            $pluginPath = $manager->getConfig('path.url');
            $assetClass = $container->offsetGet('wwp.assets.assetClass');

            $this->_assets = array(
                'css' => array(
                    new $assetClass('wwp-contact-admin', $pluginPath . '/admin/css/contact.scss', array('styleguide'), null, false, AbstractAssetService::$ADMINASSETSGROUP)
                ),
                'js' => array(
                    new $assetClass('wwp-contact-admin', $pluginPath . '/admin/js/contact.js', array(), null, false, AbstractAssetService::$ADMINASSETSGROUP)
                )
            );
        }
        return $this->_assets;
    }

}