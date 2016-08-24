<?php

namespace WonderWp\Plugin\Newsletter;

//Must uses
use \Composer\Autoload\ClassLoader as AutoLoader; //Must use the autoloader
use Pimple\Container as PContainer;
use WonderWp\APlugin\AbstractPluginManager;
use WonderWp\DI\Container;

class NewsletterManager extends AbstractPluginManager{

    /**
     *
     * Register AutoLoad dependencies for this plugin.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     */
    public function autoLoad(AutoLoader $loader){

        $pluginDir = plugin_dir_path( dirname( __FILE__ ) );
        $loader->addPsr4('WonderWp\\Plugin\\Newsletter\\',array(
            $pluginDir . 'includes',
            $pluginDir . 'admin',
            $pluginDir . 'public',
        ));

    }

    public function register(PContainer $container)
    {
        parent::register($container);

        $container[$this->plugin_name.'.adminController'] = function(){
            return new NewsletterAdminController( $this->get_plugin_name(), $this->get_version() );
        };
        /*$container[$this->plugin_name.'.publicController'] = function() {
            return $plugin_public = new NewsletterPublicController($this->get_plugin_name(), $this->get_version());
        };*/

        $container[$this->plugin_name.'.wwp.entityName'] = NewsletterEntity::class;
        $container[$this->plugin_name.'wwp.forms.modelForm'] = $container->factory(function($c){
            return new NewsletterForm();
        });
        $container[$this->plugin_name.'.wwp.listTable.class'] = function($container){
            return new NewsletterListTable(array(
                'entityName'=>NewsletterEntity::class,
                'textdomain'=>WWP_NEWSLETTER_TEXTDOMAIN
            ));
        };
        /*$container[$this->plugin_name.'.assetService'] = function(){
            return new NewsletterAssetsService();
        };*/

        $container[$this->plugin_name.'.path.root'] = plugin_dir_path( dirname( __FILE__ ) );
        $container[$this->plugin_name.'.path.url'] = plugin_dir_url( dirname( __FILE__ ) );
    }

    public function loadTextdomain()
    {
        load_plugin_textdomain(WWP_NEWSLETTER_TEXTDOMAIN,false,dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/');
    }

}