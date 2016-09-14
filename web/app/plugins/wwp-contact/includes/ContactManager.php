<?php

namespace WonderWp\Plugin\Contact;

//Must uses
use \Composer\Autoload\ClassLoader as AutoLoader; //Must use the autoloader
use Pimple\Container as PContainer;
use WonderWp\APlugin\AbstractManager;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;
use WonderWp\Plugin\PageSettings\AbstractPageSettingsService;
use WonderWp\Services\AbstractService;

/**
 * Class ContactManager
 * @package WonderWp\Plugin\Contact
 * The manager is the file that registers everything your plugin is going to use / need.
 * It's the most important file for your plugin, the one that bootstraps everything.
 * The manager registers itself with the DI container, so you can retrieve it somewhere else and use its config / controllers / services
 */
class ContactManager extends AbstractPluginManager{

    /**
     * Register AutoLoad dependencies for this plugin.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     */
    public function autoLoad(AutoLoader $loader){

        $pluginDir = plugin_dir_path( dirname( __FILE__ ) );
        $loader->addPsr4('WonderWp\\Plugin\\Contact\\',array(
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
        $this->setConfig('entityName',ContactEntity::class);
        $this->setConfig('textDomain',WWP_CONTACT_TEXTDOMAIN);

        //Register Controllers
        $this->addController(AbstractManager::$ADMINCONTROLLERTYPE,function(){
            return new ContactAdminController( $this );
        });
        $this->addController(AbstractManager::$PUBLICCONTROLLERTYPE,function(){
            return $plugin_public = new ContactPublicController($this);
        });

        //Register Services
        $this->addService(AbstractService::$HOOKSERVICENAME,$container->factory(function($c){
            //Hook service
            return new ContactHookService();
        }));
        $this->addService(AbstractService::$MODELFORMSERVICENAME,$container->factory(function($c){
            //Model Form service
            return new ContactForm();
        }));
        $this->addService(AbstractService::$LISTTABLESERVICENAME, function($container){
            //List Table service
            return new ContactListTable();
        });
        $this->addService(AbstractService::$ASSETSSERVICENAME,function(){
            //Asset service
            return new ContactAssetService();
        });
        /* //Uncomment this if your plugin has particular routes, then create the ContactRouteService class in the include folder
        $this->addService(AbstractService::$ROUTESERVICENAME,function(){
            //Route service
            return new ContactRouteService();
        });*/
        //Uncomment this if your plugin has page settings, then create the ContactPageSettingsService class in the include folder
        $this->addService(AbstractPageSettingsService::$PAGESETTINGSSERVICENAME,function(){
            //Page settings service
            return new ContactPageSettingsService();
        });
        /* //Uncomment this if your plugin has an api, then create the ContactApiService class in the include folder
        $this->addService(AbstractService::$APISERVICENAME,function(){
            //Api service
            return new ContactApiService();
        });*/

        return $this;
    }

}