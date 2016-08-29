<?php

namespace __PLUGIN_NS__;

//Must uses
use \Composer\Autoload\ClassLoader as AutoLoader; //Must use the autoloader
use Pimple\Container as PContainer;
use WonderWp\APlugin\AbstractManager;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;

/**
 * Class __PLUGIN_ENTITY__Manager
 * @package __PLUGIN_NS__
 * The manager is the file that registers everything your plugin is going to use / need.
 * It's the most important file for your plugin, the one that bootstraps everything.
 * The manager registers itself with the DI container, so you can retrieve it somewhere else and use its config / controllers / services
 */
class __PLUGIN_ENTITY__Manager extends AbstractPluginManager{

    /**
     * Register AutoLoad dependencies for this plugin.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     */
    public function autoLoad(AutoLoader $loader){

        $pluginDir = plugin_dir_path( dirname( __FILE__ ) );
        $loader->addPsr4('__ESCAPED_PLUGIN_NS__\\',array(
            $pluginDir . 'includes',
            $pluginDir . 'admin',
            $pluginDir . 'public',
        ));

    }

    /**
     * Registers config, controllers, services etc usable by the plugin components
     * @param PContainer $container
     * @return $this
     */
    public function register(PContainer $container)
    {
        parent::register($container);

        //Register Config
        $this->setConfig('path.root',plugin_dir_path( dirname( __FILE__ ) ));
        $this->setConfig('path.base',dirname( dirname( plugin_basename( __FILE__ ) ) ));
        $this->setConfig('path.url',plugin_dir_url( dirname( __FILE__ ) ));
        $this->setConfig('entityName',__PLUGIN_ENTITY__Entity::class);
        $this->setConfig('textDomain',WWP___PLUGIN_CONST___TEXTDOMAIN);

        //Register Controllers
        $this->addController(AbstractManager::$ADMINCONTROLLERTYPE,function(){
            return new __PLUGIN_ENTITY__AdminController( $this );
        });
        /*$container[$this->plugin_name.'.publicController'] = function() {
            return $plugin_public = new __PLUGIN_ENTITY__PublicController($this);
        };*/

        //Register Services
        $this->addService(AbstractManager::$HOOKSERVICENAME,$container->factory(function($c){
            //Hook service
            return new __PLUGIN_ENTITY__HookService();
        }));
        $this->addService(AbstractManager::$MODELFORMSERVICENAME,$container->factory(function($c){
            //Model Form service
            return new __PLUGIN_ENTITY__Form();
        }));
        $this->addService(AbstractManager::$LISTTABLESERVICENAME, function($container){
            //List Table service
            return new __PLUGIN_ENTITY__ListTable();
        });
        /* //Uncomment this if your plugin has assets
        $this->addService(AbstractManager::$ASSETSSERVICENAME,function(){
            //Asset service
            return new __PLUGIN_ENTITY__AssetService();
        });*/

        return $this;
    }

}