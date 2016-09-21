<?php

namespace WonderWp\Plugin\Vote;

//Must uses
use \Composer\Autoload\ClassLoader as AutoLoader; //Must use the autoloader
use Pimple\Container as PContainer;
use WonderWp\APlugin\AbstractManager;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;
use WonderWp\Services\AbstractService;

/**
 * Class VoteManager
 * @package WonderWp\Plugin\Vote
 * The manager is the file that registers everything your plugin is going to use / need.
 * It's the most important file for your plugin, the one that bootstraps everything.
 * The manager registers itself with the DI container, so you can retrieve it somewhere else and use its config / controllers / services
 */
class VoteManager extends AbstractPluginManager{

    /**
     * Register AutoLoad dependencies for this plugin.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     */
    public function autoLoad(AutoLoader $loader){

        $pluginDir = plugin_dir_path( dirname( __FILE__ ) );
        $loader->addPsr4('WonderWp\\Plugin\\Vote\\',array(
            $pluginDir . 'includes'
        ));

        $loader->addClassMap(array(
            'WonderWp\\Plugin\\Vote\\VoteAdminController'=>$pluginDir.'admin'.DIRECTORY_SEPARATOR.'VoteAdminController.php',
            //'WonderWp\\Plugin\\Vote\\VotePublicController'=>$pluginDir.'public'.DIRECTORY_SEPARATOR.'VotePublicController.php', //Uncomment this if your plugin has a public controller
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
        $this->setConfig('entityName',VoteEntity::class);
        $this->setConfig('textDomain',WWP_VOTE_TEXTDOMAIN);

        //Register Controllers
        $this->addController(AbstractManager::$ADMINCONTROLLERTYPE,function(){
            return new VoteAdminController( $this );
        });
        //Uncomment this if your plugin has a public controller
        /*$this->addController(AbstractManager::$PUBLICCONTROLLERTYPE,function(){
            return $plugin_public = new VotePublicController($this);
        });*/

        //Register Services
        $this->addService(AbstractService::$HOOKSERVICENAME,$container->factory(function($c){
            //Hook service
            return new VoteHookService();
        }));
        $this->addService(AbstractService::$MODELFORMSERVICENAME,$container->factory(function($c){
            //Model Form service
            return new VoteForm();
        }));
        $this->addService(AbstractService::$LISTTABLESERVICENAME, function($container){
            //List Table service
            return new VoteListTable();
        });
        /* //Uncomment this if your plugin has assets, then create the VoteAssetService class in the include folder
        $this->addService(AbstractService::$ASSETSSERVICENAME,function(){
            //Asset service
            return new VoteAssetService();
        });*/
        /* //Uncomment this if your plugin has particular routes, then create the VoteRouteService class in the include folder
        $this->addService(AbstractService::$ROUTESERVICENAME,function(){
            //Route service
            return new VoteRouteService();
        });*/
        /* //Uncomment this if your plugin has page settings, then create the VotePageSettingsService class in the include folder
        $this->addService(AbstractService::$PAGESETTINGSSERVICENAME,function(){
            //Page settings service
            return new VotePageSettingsService();
        });*/
        /* //Uncomment this if your plugin has an api, then create the VoteApiService class in the include folder
        $this->addService(AbstractService::$APISERVICENAME,function(){
            //Api service
            return new VoteApiService();
        });*/

        return $this;
    }

}