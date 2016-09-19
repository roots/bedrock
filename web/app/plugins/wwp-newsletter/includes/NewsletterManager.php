<?php

namespace WonderWp\Plugin\Newsletter;

//Must uses
use \Composer\Autoload\ClassLoader as AutoLoader; //Must use the autoloader
use Pimple\Container as PContainer;
use WonderWp\APlugin\AbstractManager;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;
use WonderWp\Plugin\PageSettings\AbstractPageSettingsService;
use WonderWp\Services\AbstractService;

/**
 * Class NewsletterManager
 * @package WonderWp\Plugin\Newsletter
 * The manager is the file that registers everything your plugin is going to use / need.
 * It's the most important file for your plugin, the one that bootstraps everything.
 * The manager registers itself with the DI container, so you can retrieve it somewhere else and use its config / controllers / services
 */
class NewsletterManager extends AbstractPluginManager{

    /**
     * Register AutoLoad dependencies for this plugin.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     */
    public function autoLoad(AutoLoader $loader){

        $pluginDir = plugin_dir_path( dirname( __FILE__ ) );
        $loader->addPsr4('WonderWp\\Plugin\\Newsletter\\',array(
            $pluginDir . 'includes'
        ));
        $loader->addClassMap(array(
            'WonderWp\\Plugin\\Newsletter\\NewsletterAdminController'=>$pluginDir.'admin'.DIRECTORY_SEPARATOR.'NewsletterAdminController.php',
            'WonderWp\\Plugin\\Newsletter\\NewsletterPublicController'=>$pluginDir.'public'.DIRECTORY_SEPARATOR.'NewsletterPublicController.php'
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
        $this->setConfig('entityName',NewsletterEntity::class);
        $this->setConfig('textDomain',WWP_NEWSLETTER_TEXTDOMAIN);

        //Register Controllers
        $this->addController(AbstractManager::$ADMINCONTROLLERTYPE,function(){
            return new NewsletterAdminController( $this );
        });
        $this->addController(AbstractManager::$PUBLICCONTROLLERTYPE,function(){
            return new NewsletterPublicController( $this );
        });

        //Register Services
        $this->addService(AbstractService::$HOOKSERVICENAME,$container->factory(function($c){
            //Hook service
            return new NewsletterHookService();
        }));
        $this->addService(AbstractService::$MODELFORMSERVICENAME,$container->factory(function($c){
            //Model Form service
            return new NewsletterForm();
        }));
        $this->addService(AbstractService::$LISTTABLESERVICENAME, function($container){
            //List Table service
            return new NewsletterListTable();
        });
        /* //Uncomment this if your plugin has assets
        $this->addService(AbstractService::$ASSETSSERVICENAME,function(){
            //Asset service
            return new NewsletterAssetService();
        });*/
        //Page settings
        $this->addService(AbstractPageSettingsService::$PAGESETTINGSSERVICENAME, function(){
            return new NewsletterPageSettingsService();
        });
        //Passerelles
        $this->addService('passerelle', function(){
            return new NewsletterPasserelleService();
        });


        return $this;
    }

}