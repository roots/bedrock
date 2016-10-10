<?php

namespace WonderWp\Plugin\Recette;

//Must uses
use \Composer\Autoload\ClassLoader as AutoLoader; //Must use the autoloader
use Pimple\Container as PContainer;
use WonderWp\APlugin\AbstractManager;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;
use WonderWp\Services\AbstractService;

/**
 * Class RecetteManager
 * @package WonderWp\Plugin\Recette
 * The manager is the file that registers everything your plugin is going to use / need.
 * It's the most important file for your plugin, the one that bootstraps everything.
 * The manager registers itself with the DI container, so you can retrieve it somewhere else and use its config / controllers / services
 */
class RecetteManager extends AbstractPluginManager{

    /**
     * Register AutoLoad dependencies for this plugin.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     */
    public function autoLoad(AutoLoader $loader){

        $pluginDir = plugin_dir_path( dirname( __FILE__ ) );
        $loader->addPsr4('WonderWp\\Plugin\\Recette\\',array(
            $pluginDir . 'includes'
        ));
        $loader->addClassMap(array(
            'WonderWp\\Plugin\\Recette\\RecetteAdminController'=>$pluginDir.'admin'.DIRECTORY_SEPARATOR.'RecetteAdminController.php',
            'WonderWp\\Plugin\\Recette\\RecettePublicController'=>$pluginDir.'public'.DIRECTORY_SEPARATOR.'RecettePublicController.php'
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
        $this->setConfig('entityName',RecetteEntity::class);
        $this->setConfig('textDomain',WWP_RECETTE_TEXTDOMAIN);

        //Register Controllers
        $this->addController(AbstractManager::$ADMINCONTROLLERTYPE,function(){
            return new RecetteAdminController( $this );
        });
        $this->addController(AbstractManager::$PUBLICCONTROLLERTYPE,function(){
            return $plugin_public = new RecettePublicController($this);
        });

        //Register Services
        $this->addService(AbstractService::$HOOKSERVICENAME,$container->factory(function($c){
            //Hook service
            return new RecetteHookService();
        }));
        $this->addService(AbstractService::$MODELFORMSERVICENAME,$container->factory(function($c){
            //Model Form service
            return new RecetteForm();
        }));
        $this->addService(AbstractService::$LISTTABLESERVICENAME, function($container){
            //List Table service
            return new RecetteListTable();
        });
        //Uncomment this if your plugin has assets, then create the RecetteAssetService class in the include folder
        $this->addService(AbstractService::$ASSETSSERVICENAME,function(){
            //Asset service
            return new RecetteAssetService();
        });
        $this->addService(AbstractService::$ROUTESERVICENAME,function(){
            //Route service
            return new RecetteRouteService();
        });
        /* //Uncomment this if your plugin has page settings, then create the RecettePageSettingsService class in the include folder
        $this->addService(AbstractService::$PAGESETTINGSSERVICENAME,function(){
            //Page settings service
            return new RecettePageSettingsService();
        });*/
        /* //Uncomment this if your plugin has an api, then create the RecetteApiService class in the include folder
        $this->addService(AbstractService::$APISERVICENAME,function(){
            //Api service
            return new RecetteApiService();
        });*/

        return $this;
    }

}