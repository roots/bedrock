<?php

namespace WonderWp\Plugin\Translator; //Correct namespace

//Must uses
use \Composer\Autoload\ClassLoader as AutoLoader; //Must use the autoloader
use Pimple\Container as PContainer;
use Symfony\Component\Translation\Translator;
use WonderWp\APlugin\AbstractManager;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;
use WonderWp\HttpFoundation\Request;
use WonderWp\Services\AbstractService;

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

        //Register Config
        $baseDir = plugin_dir_path( dirname( __FILE__ ));
        $this->setConfig('path.root',$baseDir);
        $this->setConfig('path.base',dirname(dirname( dirname( plugin_basename( __FILE__ ) ) )));
        $this->setConfig('path.url', plugin_dir_url( dirname(dirname( __FILE__ ) )));
        $this->setConfig('entityName',LangEntity::class);
        $this->setConfig('textDomain',WWP_TRANSLATOR_TEXTDOMAIN);

        //Register Controllers
        $this->addController(AbstractManager::$ADMINCONTROLLERTYPE,function(){
            return new TranslatorAdminController( $this );
        });

        //Register Services
        $this->addService(AbstractService::$HOOKSERVICENAME,$container->factory(function($c){
            return new TranslatorHookService();
        }));
        $this->addService(AbstractService::$MODELFORMSERVICENAME,$container->factory(function($c){
            return new LangForm();
        }));
        $this->addService(AbstractService::$LISTTABLESERVICENAME, function($container){
            return new LangListTable();
        });
        $this->addService(AbstractService::$ASSETSSERVICENAME,function(){
            return new TranslatorAssetsService();
        });
        $this->addService('getText',function(){
            return new TranslatorGetTextService();
        });

        $container['wwp.currentLang'] = function($container){
            $em = $container->offsetGet('entityManager');
            return $em->getRepository(LangEntity::class)->getCurrentLang();
        };

        include $baseDir.'/build/gettext-compiled.php';
        include $baseDir.'/build/shell-compiled.php';

        return $this;
    }

}