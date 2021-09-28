<?php

namespace WonderWp\Theme\Child\Service;

use WonderWp\Component\Asset\AbstractAssetService;
use WonderWp\Component\Asset\Asset;
use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Theme\Core\ThemeManager;

class ThemeAssetService extends AbstractAssetService
{
    public function getAssets()
    {
        if (empty($this->_assets)) {
            $container = Container::getInstance();
            $manager   = $container->offsetGet('wwp.theme.Manager');
            $themePath = $manager->getConfig('path.url');
            /** @var Asset $assetClass */
            $assetClass = self::$assetClassName;

            $this->_assets = [
                'css' => [
                    new $assetClass('styleguide', $themePath . '/assets/raw/scss/theme.scss', [], '', true, 'styleguide'),
                    new $assetClass('critical', $themePath . '/assets/raw/scss/critical.scss', [], '', true, 'critical'),
                    new $assetClass('admin', $themePath . '/assets/raw/scss/admin.scss', [], '', true, 'admin'),
                ],
                'js'  => [
                    new $assetClass('bootstrap', $themePath . '/assets/raw/js/app_bootstrap.js', [], '', true, ThemeManager::CRITICAL_ASSETS_GROUP), // global app entry point
                    new $assetClass('styleguide', $themePath . '/assets/raw/js/app_styleguide.js', [], '', true, ThemeManager::STYLEGUIDE_ASSETS_GROUP), // global UI components loader
                    new $assetClass('init', $themePath . '/assets/raw/js/app_init.js', [], '', true, ThemeManager::INIT_ASSETS_GROUP), // global plugin loader
                    //new $assetClass('critical', $themePath . '/assets/raw/js/app_critical.js', [], '', true, ThemeManager::CRITICAL_ASSETS_GROUP), // global plugin loader
                ],
            ];
        }

        return $this->_assets;
    }
}
