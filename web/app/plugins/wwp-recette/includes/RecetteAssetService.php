<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 06/09/2016
 * Time: 18:59
 */

namespace WonderWp\Plugin\Recette;

use WonderWp\Assets\AbstractAssetService;
use WonderWp\Assets\AssetManager;
use WonderWp\DI\Container;

class RecetteAssetService extends AbstractAssetService{

    public function getAssets()
    {
        if(empty($this->_assets)) {
            $container = Container::getInstance();
            $manager = $container->offsetGet('wwp-recette.Manager');
            $pluginPath = $manager->getConfig('path.url');
            $assetClass = $container->offsetGet('wwp.assets.assetClass');

            $this->_assets = array(
                'css' => array(
                    new $assetClass('wwp-recette-admin', $pluginPath . '/admin/css/recette.scss', array('styleguide'), null, false, AbstractAssetService::$ADMINASSETSGROUP),
                    new $assetClass('wwp-recette-list', $pluginPath . '/public/css/recipeslist.scss', array('styleguide')),
                    new $assetClass('wwp-recette', $pluginPath . '/public/css/recipe.scss', array('styleguide'))
                ),
                'js' => array(
                    new $assetClass('wwp-recette-admin', $pluginPath . '/admin/js/recette.js', array('jquery-chosen'), null, false, AbstractAssetService::$ADMINASSETSGROUP),
                    new $assetClass('wwp-ingredient-admin', $pluginPath . '/admin/js/ingredient.js', array(), null, false, AbstractAssetService::$ADMINASSETSGROUP),
                    new $assetClass('wwp-recette', $pluginPath . '/public/js/recette.js', array('app','styleguide')),
                    new $assetClass('wwp-recette-list', $pluginPath . '/public/js/recette-list.js', array('app','styleguide')),
                )
            );
        }
        return $this->_assets;
    }

}