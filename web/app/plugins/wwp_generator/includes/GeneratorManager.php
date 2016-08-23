<?php

namespace WonderWp\Plugin\Generator; //Correct namespace

//Must uses
use \Composer\Autoload\ClassLoader as AutoLoader; //Must use the autoloader
use Pimple\Container as PContainer;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;
use WonderWp\HttpFoundation\Request;

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

        $container[$this->plugin_name.'.adminController'] = function(){
            return new GeneratorAdminController( $this->get_plugin_name(), $this->get_version() );
        };

        $container[$this->plugin_name.'.wwp.listTable.class'] = function($container){
            return new TableListTable(array(
                'textdomain'=>WWP_GENERATOR_TEXTDOMAIN
            ));
        };
        $container['wwp.generator'] = function() {
            return new PluginGenerator();
        };

        /*$container[$this->plugin_name.'.wwp.entityName'] = LangEntity::class;
        $container[$this->plugin_name.'wwp.forms.modelForm'] = $container->factory(function($c){
            return new LangForm();
        });*/

        $baseDir = plugin_dir_path( dirname( __FILE__ ));
        $container[$this->plugin_name.'.path.root'] = $baseDir;
        $container[$this->plugin_name.'.path.url'] = plugin_dir_url( dirname( __FILE__ ) );
    }

    public function getRouter()
    {
        return null;
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     */
    protected function define_admin_hooks($adminController) {
        //Admin pages
        $this->loader->add_action( 'admin_menu', $adminController, 'customizeMenus' );
    }

    public function loadTextdomain()
    {
        load_plugin_textdomain(WWP_GENERATOR_TEXTDOMAIN,false,dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/');
    }

}