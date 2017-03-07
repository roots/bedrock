<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 25/08/2016
 * Time: 17:02
 */

namespace WonderWp\Plugin\Newsletter;

use WonderWp\APlugin\AbstractManager;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;
use WonderWp\Hooks\AbstractHookService;
use WonderWp\Plugin\WwpAdminChangerService;

/**
 * Class NewsletterHookService
 * @package WonderWp\Plugin\Newsletter
 * Defines the different hooks that are going to be used by your plugin
 */
class NewsletterHookService extends AbstractHookService{

    /**
     * Run
     * @return $this
     */
    public function run(){

        //Get Manager
        $container = Container::getInstance();
        $this->_manager = $container->offsetGet('wwp-newsletter.Manager');

        /*
         * Admin Hooks
         */
        //Menus
        add_action( 'admin_menu', array($this, 'customizeMenus' ));

        //Translate
        add_action( 'plugins_loaded', array($this, 'loadTextdomain' ));

        add_action( 'wwp_before_footer', array($this,'loadGlobalRegisterForm'));

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
        add_submenu_page('wonderwp-modules', 'Newsletter', 'Newsletter', WwpAdminChangerService::$DEFAULTMODULECAP, WWP_PLUGIN_NEWSLETTER_NAME, $callable);

    }

    /**
     * Load Textdomain
     */
    public function loadTextdomain()
    {
        $languageDir = $this->_manager->getConfig('path.base') . '/languages/';
        load_plugin_textdomain($this->_manager->getConfig('textDomain'),false,$languageDir);
    }

    public function loadGlobalRegisterForm(){
        $listId = get_option('wwp-newsletter_autoload_listform');
        if(!empty($listId)) {
            $shortCode = '[wwpmodule slug="wwp-newsletter"  list="' . $listId . '" ]';
            echo do_shortcode($shortCode);
        }
    }

}