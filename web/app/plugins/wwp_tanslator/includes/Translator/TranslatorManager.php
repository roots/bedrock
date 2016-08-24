<?php

namespace WonderWp\Plugin\Translator; //Correct namespace

//Must uses
use \Composer\Autoload\ClassLoader as AutoLoader; //Must use the autoloader
use Pimple\Container as PContainer;
use Symfony\Component\Translation\Translator;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;
use WonderWp\HttpFoundation\Request;

class TranslatorManager extends AbstractPluginManager{

    /**
     *
     * Register AutoLoad dependencies for this plugin.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     */
    public function autoLoad(AutoLoader $loader){

        $pluginDir = plugin_dir_path( dirname( dirname(__FILE__ )) );
        $loader->addPsr4('WonderWp\\Plugin\\Translator\\',array(
            $pluginDir . 'includes',
            $pluginDir . 'includes/Translator',
            $pluginDir . 'includes/Lang',
            $pluginDir . 'includes/Loco',
            $pluginDir . 'admin',
            $pluginDir . 'public',
        ));

    }

    public function register(PContainer $container)
    {
        parent::register($container);

        $container[$this->plugin_name.'.adminController'] = function(){
            return new TranslatorAdminController( $this->get_plugin_name(), $this->get_version() );
        };
        /*$container[$this->plugin_name.'.publicController'] = function() {
            return $plugin_public = new PublicController($this->get_plugin_name(), $this->get_version());
        };*/

        $container[$this->plugin_name.'.wwp.entityName'] = LangEntity::class;
        $container[$this->plugin_name.'.wwp.textDomain'] = WWP_TRANSLATOR_TEXTDOMAIN;

        $container[$this->plugin_name.'wwp.forms.modelForm'] = $container->factory(function($c){
            return new LangForm();
        });
        $container[$this->plugin_name.'.wwp.listTable.class'] = function($container){
            return new LangListTable();
        };
        $container[$this->plugin_name.'.assetService'] = function(){
            return new TranslatorAssetsService();
        };
        $container[$this->plugin_name.'.getTextService'] = function(){
            return new TranslatorGetTextService();
        };

        $baseDir = plugin_dir_path( dirname( __FILE__ ));
        $container[$this->plugin_name.'.path.root'] = $baseDir;
        $container[$this->plugin_name.'.path.url'] = plugin_dir_url( dirname(dirname( __FILE__ ) ));

        $container['wwp.currentLang'] = function($container){
            $em = $container->offsetGet('entityManager');
            return $em->getRepository(LangEntity::class)->getCurrentLang();
        };

        include $baseDir.'/build/gettext-compiled.php';
        include $baseDir.'/build/shell-compiled.php';
    }

    public function getRouter()
    {
        return null;
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     */
    protected function define_admin_hooks($adminController) {
        //Admin pages
        $this->loader->add_action( 'admin_menu', $adminController, 'customizeMenus' );
    }

    public function loadTextdomain()
    {
        load_plugin_textdomain(WWP_TRANSLATOR_TEXTDOMAIN,false,dirname(dirname( dirname( plugin_basename( __FILE__ ) ) ) ). '/languages/');
    }

    public function registerAssets(){
        $container = Container::getInstance();
        $assetsService = $container->offsetGet($this->plugin_name.'.assetsService');
        $assetsManager = $container->offsetGet('wwp.assets.manager');
        $assetClass = $container->offsetGet('wwp.assets.assetClass');
        $assetsService->registerAssets($assetsManager,$assetClass);
    }

    protected function _translate()
    {
        $this->loader->add_action( 'locale', $this, 'locale_changer' );
        parent::_translate();
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