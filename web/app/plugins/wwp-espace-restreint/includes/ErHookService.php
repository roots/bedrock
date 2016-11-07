<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 25/08/2016
 * Time: 17:02
 */

namespace WonderWp\Plugin\EspaceRestreint;

use WonderWp\APlugin\AbstractManager;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;
use WonderWp\Hooks\AbstractHookService;

/**
 * Class ErHookService
 * @package WonderWp\Plugin\EspaceRestreint
 * Defines the different hooks that are going to be used by your plugin
 */
class ErHookService extends AbstractHookService{

    /**
     * Run
     * @return $this
     */
    public function run(){

        //Get Manager
        $container = Container::getInstance();
        $this->_manager = $container->offsetGet('wwp-espace-restreint.Manager');

        /*
         * Admin Hooks
         */
        //Menus
        add_action( 'admin_menu', array($this, 'customizeMenus' ));

        //Translate
        add_action( 'plugins_loaded', array($this, 'loadTextdomain' ));

        add_action('template_redirect',array($this,'protectPage'));

        return $this;
    }

    /**
     * Add entry under top-level functionalities menu
     */
    public function customizeMenus(){

        //Get admin controller
        $adminController = $this->_manager->getController(AbstractManager::$ADMINCONTROLLERTYPE);
        $callable = array($adminController,'route');

        //Add entry under top-level functionalities menu
        add_submenu_page('wonderwp-modules', 'Espace Restreint', 'Espace Restreint', 'read', WWP_PLUGIN_MEMBRE_NAME, $callable);

    }

    /**
     * Load Textdomain
     */
    public function loadTextdomain()
    {
        $languageDir = $this->_manager->getConfig('path.base') . '/languages/';
        load_plugin_textdomain($this->_manager->getConfig('textDomain'),false,$languageDir);
    }

    public function protectPage(){
        global $post;

        /** @var ErService $erService */
        $erService = $this->_manager->getService('er');


        $isProtected = $erService->isPostProtected($post);

        if($isProtected){
            $manager = Container::getInstance()->offsetGet('wwp-espace-restreint.Manager');
            /** @var ErGeneralService $erGleService */
            $erGleService = $manager->getService('er');
            \WonderWp\redirect($erGleService->getLoginUrl());
        }
    }

}