<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 25/08/2016
 * Time: 17:02
 */

namespace WonderWp\Plugin\Generator;

use WonderWp\APlugin\AbstractManager;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;
use WonderWp\Services\AbstractHookService;

class GeneratorHookService extends AbstractHookService{

    public function run(){

        $container = Container::getInstance();
        $this->_manager = $container->offsetGet('wonderwp_generator.Manager');

        /*
         * Admin Hooks
         */
        //Menus
        add_action( 'admin_menu', array($this, 'customizeMenus' ));

        //Translate
        add_action( 'plugins_loaded', array($this, 'loadTextdomain' ));

    }

    public function customizeMenus(){

        $adminController = $this->_manager->getController(AbstractManager::$ADMINCONTROLLERTYPE);
        $callable = array($adminController,'route');

        //Add top-level translation menu
        $page_title = 'Génération de plugin';
        $menu_title = 'Génération de plugin';
        $menu_slug = 'wonderwp-generator';
        add_management_page( $page_title, $menu_title, 'manage_options', $menu_slug, $callable );

    }

    public function loadTextdomain()
    {
        $languageDir = $this->_manager->getConfig('path.base') . '/languages/';
        load_plugin_textdomain($this->_manager->getConfig('textDomain'),false,$languageDir);
    }

}