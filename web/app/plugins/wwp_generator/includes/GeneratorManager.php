<?php

namespace WonderWp\Plugin\Generator; //Correct namespace

//Must uses
use \Composer\Autoload\ClassLoader as AutoLoader; //Must use the autoloader
use Pimple\Container as PContainer;
use WonderWp\APlugin\AbstractManager;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;
use WonderWp\HttpFoundation\Request;
use WonderWp\Services\AbstractService;

class GeneratorManager extends AbstractPluginManager{

    /**
     *
     * Register AutoLoad dependencies for this plugin.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     */
    public function autoLoad(AutoLoader $loader){

        $pluginDir = plugin_dir_path( dirname(__FILE__ ) );
        $loader->addPsr4('WonderWp\\Plugin\\Generator\\',array(
            $pluginDir . 'includes',
            $pluginDir . 'includes/generator',
            $pluginDir . 'admin',
        ));

    }

    public function register(PContainer $container)
    {
        parent::register($container);

        //Register Config
        $this->setConfig('path.root',plugin_dir_path( dirname( __FILE__ ) ));
        $this->setConfig('path.base',dirname( dirname( plugin_basename( __FILE__ ) ) ));
        $this->setConfig('path.url',plugin_dir_url( dirname( __FILE__ ) ));
        $this->setConfig('textDomain',WWP_GENERATOR_TEXTDOMAIN);

        //Register Controllers
        $this->addController(AbstractManager::$ADMINCONTROLLERTYPE,function(){
            return new GeneratorAdminController( $this );
        });

        //Register Services
        $this->addService(AbstractService::$HOOKSERVICENAME,$container->factory(function($c){
            return new GeneratorHookService();
        }));
        $this->addService(AbstractService::$LISTTABLESERVICENAME, function($container){
            return new TableListTable();
        });
        $this->addService('Generator', function() {
            return new PluginGenerator();
        });

        return $this;
    }

}