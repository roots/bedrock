<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 25/08/2016
 * Time: 17:02
 */

namespace WonderWp\Plugin\Translator;

use WonderWp\APlugin\AbstractManager;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;
use WonderWp\HttpFoundation\Request;
use WonderWp\Hooks\AbstractHookService;

class TranslatorHookService extends AbstractHookService{

    public function run(){

        $container = Container::getInstance();
        $this->_manager = $container->offsetGet('wonderwp_translator.Manager');

        /*
         * Admin Hooks
         */
        //Menus
        add_action( 'admin_menu', array($this, 'customizeMenus' ));

        //Translate
        add_action( 'plugins_loaded', array($this, 'loadTextdomain' ));

        //Locale
        add_action( 'locale', array($this, 'locale_changer' ));

    }

    public function customizeMenus(){

        $adminController = $this->_manager->getController(AbstractManager::$ADMINCONTROLLERTYPE);
        $callable = array($adminController,'route');
        $page_title = 'Gestion des traductions';
        $menu_title = 'Traductions';
        $menu_slug = 'wonderwp-trads';

        add_menu_page($page_title, $menu_title, 'read', $menu_slug, $callable, 'dashicons-translation', 20);

    }

    public function loadTextdomain()
    {
        $languageDir = $this->_manager->getConfig('path.base') . '/languages/';
        load_plugin_textdomain($this->_manager->getConfig('textDomain'),false,$languageDir);
    }

    public function locale_changer($lang){
        $request = Request::getInstance();
        $session = $request->getSession();
        $storedLocale = $session->get('locale');
        $newLocale = $request->get('locale');

        if(empty($storedLocale)){ $newLocale=$lang; }

        if(!empty($newLocale) && $newLocale!=$storedLocale){
            $session->set('locale',$newLocale);
            $storedLocale = $newLocale;
        }
        return $storedLocale;
    }

}