<?php

namespace WonderWp\Plugin\Actu; //Correct namespace

//Must uses

use \Composer\Autoload\ClassLoader as AutoLoader; //Must use the autoloader
use Pimple\Container as PContainer;
use WonderWp\APlugin\AbstractManager;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;

class ActuManager extends AbstractPluginManager{

    /**
     *
     * Register AutoLoad dependencies for this plugin.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     */
    public function autoLoad(AutoLoader $loader){

        $pluginDir = plugin_dir_path( dirname( __FILE__ ) );
        $loader->addPsr4('WonderWp\\Plugin\\Actu\\',array(
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
        $this->setConfig('entityName',ActuEntity::class);
        $this->setConfig('textDomain',WWP_ACTU_TEXTDOMAIN);

        //Register Controllers
        $this->addController(AbstractManager::$ADMINCONTROLLERTYPE,function(){
            return new ActuAdminController( $this );
        });
        $this->addController(AbstractManager::$PUBLICCONTROLLERTYPE,function(){
            return $plugin_public = new ActuPublicController($this);
        });

        //Register Services
        $this->addService(AbstractManager::$HOOKSERVICENAME,$container->factory(function($c){
            return new ActuHookService();
        }));
        /*$this->addService(AbstractManager::$MODELFORMSERVICENAME,$container->factory(function($c){
            return new ActuForm();
        }));*/
        $this->addService(AbstractManager::$LISTTABLESERVICENAME, function($container){
            return new ActuListTable();
        });
        $this->addService(AbstractManager::$ASSETSSERVICENAME,function(){
            return new ActuAssetService();
        });
        $this->addService(AbstractManager::$ROUTESERVICENAME,function(){
            return new ActuRouteService();
        });

        return $this;
    }

}