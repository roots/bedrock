<?php

namespace WonderWp\Plugin\LazyLoad\Service;

use WonderWp\Framework\AbstractPlugin\ManagerInterface;
use WonderWp\Framework\Asset\AbstractAssetService;
use WonderWp\Framework\DependencyInjection\Container;

class LazyLoadAssetsService extends AbstractAssetService
{
    public function getAssets()
    {
        if (empty($this->assets)) {
            $container = Container::getInstance();
            /** @var ManagerInterface $manager */
            $manager    = $container[WWP_PLUGIN_LAZYLOAD_NAME . '.Manager'];
            $pluginPath = $manager->getConfig('path.url');
            $assetClass = $container->offsetGet('wwp.assets.assetClass');
            $jsAssetGroup = $manager->getConfig('jsAssetGroup');
            $this->assets = [
                'js'  => [
                    new $assetClass('wwp-lazyload', $pluginPath . '/public/js/lazy-load.js', ['app', 'styleguide'], '', true, 'plugins'),
                ],
            ];
        }

        return $this->assets;
    }
}
