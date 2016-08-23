<?php

namespace __PLUGIN_NS__;

//Must uses
use \Composer\Autoload\ClassLoader as AutoLoader; //Must use the autoloader
use Pimple\Container as PContainer;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;

class __PLUGIN_ENTITY__Manager extends AbstractPluginManager{

    /**
     *
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

    public function register(PContainer $container)
    {
        parent::register($container);

        $container[$this->plugin_name.'.adminController'] = function(){
            return new __PLUGIN_ENTITY__AdminController( $this->get_plugin_name(), $this->get_version() );
        };
        /*$container[$this->plugin_name.'.publicController'] = function() {
            return $plugin_public = new __PLUGIN_ENTITY__PublicController($this->get_plugin_name(), $this->get_version());
        };*/

        $container[$this->plugin_name.'.wwp.entityName'] = __PLUGIN_ENTITY__Entity::class;
        $container[$this->plugin_name.'wwp.forms.modelForm'] = $container->factory(function($c){
            return new __PLUGIN_ENTITY__Form();
        });
        $container[$this->plugin_name.'.wwp.listTable.class'] = function($container){
            return new __PLUGIN_ENTITY__ListTable(array(
                'entityName'=>__PLUGIN_ENTITY__Entity::class,
                'textdomain'=>WWP___PLUGIN_CONST___TEXTDOMAIN
            ));
        };
        /*$container[$this->plugin_name.'.assetService'] = function(){
            return new __PLUGIN_ENTITY__AssetsService();
        };*/

        $container[$this->plugin_name.'.path.root'] = plugin_dir_path( dirname( __FILE__ ) );
        $container[$this->plugin_name.'.path.url'] = plugin_dir_url( dirname( __FILE__ ) );
    }

    public function loadTextdomain()
    {
        load_plugin_textdomain(WWP___PLUGIN_CONST___TEXTDOMAIN,false,dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/');
    }

}