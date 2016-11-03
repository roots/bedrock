<?php

namespace WonderWp\Plugin\EspaceRestreint;

//Must uses
use \Composer\Autoload\ClassLoader as AutoLoader; //Must use the autoloader
use Pimple\Container as PContainer;
use WonderWp\APlugin\AbstractManager;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;
use WonderWp\Services\AbstractService;

/**
 * Class ErManager
 * @package WonderWp\Plugin\EspaceRestreint
 * The manager is the file that registers everything your plugin is going to use / need.
 * It's the most important file for your plugin, the one that bootstraps everything.
 * The manager registers itself with the DI container, so you can retrieve it somewhere else and use its config / controllers / services
 */
class ErManager extends AbstractPluginManager{

    /**
     * Register AutoLoad dependencies for this plugin.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     */
    public function autoLoad(AutoLoader $loader){

        $pluginDir = plugin_dir_path( dirname( __FILE__ ) );
        $loader->addPsr4('WonderWp\\Plugin\\EspaceRestreint\\',array(
            $pluginDir . 'includes'
        ));

        $loader->addClassMap(array(
            'WonderWp\\Plugin\\EspaceRestreint\\ErAdminController'=>$pluginDir.'admin'.DIRECTORY_SEPARATOR.'ErAdminController.php',
            'WonderWp\\Plugin\\EspaceRestreint\\ErPublicController'=>$pluginDir.'public'.DIRECTORY_SEPARATOR.'ErPublicController.php', //Uncomment this if your plugin has a public controller
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
        $this->setConfig('entityName',MembreEntity::class);
        $this->setConfig('textDomain',WWP_ER_TEXTDOMAIN);

        $urlRewritePrefix = '/espace-restreint';
        $this->setConfig('url_rewrite_prefix',$urlRewritePrefix);
        $this->setConfig('login_url',$urlRewritePrefix.'/identification');
        $this->setConfig('register_url',$urlRewritePrefix.'/inscription');
        $this->setConfig('forgotpwd_url',$urlRewritePrefix.'/mot-de-passe-oublie');
        $this->setConfig('resetpwd_url',$urlRewritePrefix.'/reinitialisation');
        $this->setConfig('logout_url',$urlRewritePrefix.'/deconnexion');

        //Register Controllers
        $this->addController(AbstractManager::$ADMINCONTROLLERTYPE,function(){
            return new ErAdminController( $this );
        });
        //Uncomment this if your plugin has a public controller
        $this->addController(AbstractManager::$PUBLICCONTROLLERTYPE,function(){
            return $plugin_public = new ErPublicController($this);
        });

        //Register Services
        $this->addService(AbstractService::$HOOKSERVICENAME,$container->factory(function($c){
            //Hook service
            return new ErHookService();
        }));
        $this->addService(AbstractService::$MODELFORMSERVICENAME,$container->factory(function($c){
            //Model Form service
            return new MembreForm();
        }));
        $this->addService(AbstractService::$LISTTABLESERVICENAME, function($container){
            //List Table service
            return new MembreListTable();
        });
        /* //Uncomment this if your plugin has assets, then create the ErAssetService class in the include folder
        $this->addService(AbstractService::$ASSETSSERVICENAME,function(){
            //Asset service
            return new ErAssetService();
        });*/
        $this->addService(AbstractService::$ROUTESERVICENAME,function(){
            //Route service
            return new ErRouteService();
        });
        /* //Uncomment this if your plugin has page settings, then create the ErPageSettingsService class in the include folder
        $this->addService(AbstractService::$PAGESETTINGSSERVICENAME,function(){
            //Page settings service
            return new ErPageSettingsService();
        });*/
        /* //Uncomment this if your plugin has an api, then create the ErApiService class in the include folder
        $this->addService(AbstractService::$APISERVICENAME,function(){
            //Api service
            return new ErApiService();
        });*/
        $this->addService('er',function(){
            //General service
            return new ErGeneralService();
        });
        $this->addService('erForm',function(){
            //General service
            return new ErFormService();
        });
        $this->addService('erFormHandler',function(){
            //General service
            return new ErFormHandlerService();
        });

        return $this;
    }

}