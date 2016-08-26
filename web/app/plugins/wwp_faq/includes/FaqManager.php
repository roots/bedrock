<?php

namespace WonderWp\Plugin\Faq; //Correct namespace

//Must uses
use \Composer\Autoload\ClassLoader as AutoLoader; //Must use the autoloader
use Pimple\Container as PContainer;
use WonderWp\APlugin\AbstractManager;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;

class FaqManager extends AbstractPluginManager{

    /**
     *
     * Register AutoLoad dependencies for this plugin.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     */
    public function autoLoad(AutoLoader $loader){

        $pluginDir = plugin_dir_path( dirname( __FILE__ ) );
        $loader->addPsr4('WonderWp\\Plugin\\Faq\\',array(
            $pluginDir . 'includes',
            $pluginDir . 'admin',
            $pluginDir . 'public',
        ));

    }

    public function register(PContainer $container)
    {
        parent::register($container);

        //Register Config
        $this->setConfig('path.root',plugin_dir_path( dirname( __FILE__ ) ));
        $this->setConfig('path.base',dirname( dirname( plugin_basename( __FILE__ ) ) ));
        $this->setConfig('path.url',plugin_dir_url( dirname( __FILE__ ) ));
        $this->setConfig('entityName',FaqEntity::class);
        $this->setConfig('textDomain',WWP_FAQ_TEXTDOMAIN);

        //Register Controllers
        $this->addController(AbstractManager::$ADMINCONTROLLERTYPE,function(){
            return new FaqAdminController( $this );
        });
        /*$container[$this->plugin_name.'.publicController'] = function() {
            return $plugin_public = new PublicController($this->get_plugin_name(), $this->get_version());
        };*/

        //Register Services
        $this->addService(AbstractManager::$HOOKSERVICENAME,$container->factory(function($c){
            return new FaqHookService();
        }));
        $this->addService(AbstractManager::$MODELFORMSERVICENAME,$container->factory(function($c){
            return new FaqForm();
        }));
        $this->addService(AbstractManager::$LISTTABLESERVICENAME, function($container){
            return new FaqListTable();
        });
        $this->addService(AbstractManager::$ASSETSSERVICENAME,function(){
            return new FaqAssetsService();
        });

        return $this;
    }

}