<?php
/**
 * Created by PhpStorm.
 * User: mathieudelafosse
 * Date: 09/03/2018
 * Time: 12:21
 */
namespace WonderWp\Plugin\LazyLoad;

use WonderWp\Framework\AbstractPlugin\AbstractPluginManager;
use WonderWp\Framework\DependencyInjection\Container;
use WonderWp\Framework\Service\ServiceInterface;
use WonderWp\Plugin\LazyLoad\Service\LazyLoadActivator;
use WonderWp\Plugin\LazyLoad\Service\LazyLoadAssetsService;

class LazyLoadManager extends AbstractPluginManager
{
    public function register(Container $container)
    {
        parent::register($container);
        $this->setConfig('path.url', plugin_dir_url(dirname(__FILE__)));

        $this->addService(ServiceInterface::ACTIVATOR_NAME, function () {
            //Activator
            return new LazyLoadActivator(WWP_PLUGIN_ACTU_VERSION);
        });

        $this->addService(ServiceInterface::ASSETS_SERVICE_NAME, function () {
            //Asset service
            return new LazyLoadAssetsService();
        });

        include(__DIR__.'/../lazy-load.php');
    }
}